<?php

namespace core\controllers\admin;

use core\classes\PDF;
use core\classes\SendEmail;
use core\classes\Store;
use core\handlers\AdminOrders;

class OrderController {

    public function __construct() {
        // Verificar se existe um admin logado
        if(!Store::LoggedAdmin()) {
            Store::Redirect("signInAdmin", true);
            exit;
        }
    }

    public function ordersList() {

        $filters = [
            "pending" => "PENDING",
            "processing" => "PROCESSING",
            "canceled" => "CANCELED",
            "send" => "SEND",
            "concluded" => "CONCLUDED"
        ];

        $filter = "";
        if(isset($_GET["filter"])) {

            // Verificar se a variável vinda da query string existe no array de filtros permitidos
            if(key_exists($_GET["filter"], $filters)) {
                $filter = $filters[$_GET["filter"]];
            }
        }

        // Pegando o id do usuário caso exista na query string
        $userId = null;
        if(isset($_GET["user"])) {
            $userId = Store::aesDescrypt($_GET["user"]);
        }

        $data = [
            "listSales" => AdminOrders::getListOrders($filter, $userId),
            "filter" => $filter
        ];

        // Aprensentar a página de admin
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/orders",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);

    }

    public function detailsOrder() {

        // Verifica se o id do usuario foi passado pela query string
        if(!isset($_GET["order"])) {
            Store::Redirect("home", true);
            exit;
        }

        $orderId = Store::aesDescrypt($_GET["order"]);

        // Verificar se o id do usuário está vazio, caso esteja redirecionamos para a home
        if(empty($orderId)) {
            Store::Redirect("home", true);
            exit;
        }

        // Verificar se o tipo do parâmetro é diferente de uma string.
        // Caso não seja uma string redirecionamos para home.
        if(gettype($orderId) != "string") {
            Store::Redirect("home", true);
            exit;
        }

        // Carregar os dados da venda selecionada
        $data = AdminOrders::detailsOrder($orderId);

        // Página de detalhes da venda
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/detailsOrder",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);

    }

    public function alterStatusOrder() {
        
        // Verifica se o id do usuario foi passado pela query string
        if(!isset($_GET["idOrder"])) {
            Store::Redirect("home", true);
            exit;
        }

        $idOrder = Store::aesDescrypt($_GET["idOrder"]);

        // Verificar se o id do usuário está vazio, caso esteja redirecionamos para a home
        if(empty($idOrder)) {
            Store::Redirect("home", true);
            exit;
        }

        // Verificar se o tipo do parâmetro é diferente de uma string.
        // Caso não seja uma string redirecionamos para home.
        if(gettype($idOrder) != "string") {
            Store::Redirect("home", true);
            exit;
        }

        // Verificar se existe um parâmetro status
        if(!isset($_GET["status"])) {
            Store::Redirect("home", true);
            exit;
        }

        // Verificar se o status está vazio
        $status = $_GET["status"];
        if(empty($status)) {
            Store::Redirect("home", true);
            exit;
        }

        // Verificar se o status da venda existe no array
        if(!in_array($status, STATUS)) {
            Store::Redirect("home", true);
            exit;
        }

        // Atualizar o status da venda
        AdminOrders::updateStatusOrder($idOrder, $status);

        switch($status) {
            case "PENDING":
                $this->notifyClientAlterStatus($idOrder);
            break;
            case "PROCESSING":
                $this->notifyClientAlterStatus($idOrder);
            break;
            case "CANCELED":
                $this->notifyClientAlterStatus($idOrder);
            break;
            case "SEND":
                // Enviar email para o cliente para informar que a compra foi enviada para os correios
                $res = $this->sendEmailOrderSending($idOrder);
                if($res) {
                    echo "Email enviado com sucesso!";
                    exit;
                }
            break;
            case "CONCLUDED":
                $this->notifyClientAlterStatus($idOrder);
            break;
        }

        // Redirecionar para a página de vendas
        Store::Redirect("detailsOrder&order=".$_GET["idOrder"], true);
        exit;

    }

    // Construir essa função para enviar um email e notificar o cliente da mudança de status da sua compra
    private function notifyClientAlterStatus($idOrder) {}

    private function sendEmailOrderSending($idOrder) {
        // Pegando os dados da compra
        $orderData = AdminOrders::detailsOrder($idOrder);

        return SendEmail::sendEmailSendProduct($orderData);
    }

    /**
     * Criar o pdf da compra 
    */
    public function createOrderPDF() {

        // Verificar se veio o parâmetro order na query string
        if(!isset($_GET["order"])) {
            Store::Redirect("home", true);
            exit;
        }

        $orderId = Store::aesDescrypt($_GET["order"]);

        // Verificar se o id do usuário está vazio, caso esteja redirecionamos para a home
        if(empty($orderId)) {
            Store::Redirect("home", true);
            exit;
        }

        // Verificar se o tipo do parâmetro é diferente de uma string.
        // Caso não seja uma string redirecionamos para home.
        if(gettype($orderId) != "string") {
            Store::Redirect("home", true);
            exit;
        }

        // Pegando dados da compra
        $orderData = AdminOrders::detailsOrder($orderId);

        // Criar o PDF
        $pdf = new PDF();

        // Definindo o template do pdf
        $pdf->setTemplate(getcwd()."/assets/templates/example.pdf");

        // Definindo a família, tamanho e tipo da fonte
        $pdf->setFontFamily("Arial");
        $pdf->setFontSize("14px");
        $pdf->setFontWeight("bold");

        // Mostrando a data no PDF
        $pdf->positionAndDimension(225, 204, 165, 22);
        $pdf->writePDF(date("d/m/Y H:i:s", strtotime($orderData["order"]->created_at)));

        // Mostrando o código da compra no PDF
        $pdf->positionAndDimension(550, 203, 165, 22);
        $pdf->writePDF($orderData["order"]->code_order);

        // Mostrando os dados do cliente no PDF
        // Nome
        $pdf->positionAndDimension(75, 260, 600, 22);
        $pdf->writePDF($orderData["order"]->name);

        // Endereço
        $pdf->positionAndDimension(75, 284, 600, 22);
        $pdf->writePDF($orderData["order"]->address. " - ".$orderData["order"]->city);

        // Email e telefone
        $pdf->positionAndDimension(75, 308, 600, 22);
        if($orderData["order"]->phone != "") {
            $pdf->writePDF($orderData["order"]->email. " - ". $orderData["order"]->phone);
        } else {
            $pdf->writePDF($orderData["order"]->email);
        }

        // Aprensentar a lista de produtos no PDF
        $y = 390;
        $totalOrder = 0;
        $pdf->setFontWeight("normal");

        foreach($orderData["orderProducts"] as $item) {
            // Apresentação da quantdade e nome do produto
            $pdf->setAlignText("left");
            $pdf->positionAndDimension(75, $y, 500, 22);
            $pdf->writePDF($item->quantity. " x ".substr($item->name, 0, 200));

            // Preço do produto
            $pdf->setAlignText("right");
            $pdf->positionAndDimension(560, $y, 150, 22);

            $price = $item->price_unit * $item->quantity;
            $totalOrder += $price;

            $pdf->writePDF("R$ ".number_format($price, 2, ',', '.'));

            $y += 28;
        }

        // Apresentar o total da compra
        $pdf->setAlignText("right");
        $pdf->setFontSize("22px");
        $pdf->setFontWeight("bold");
        $pdf->setColor("#fff");

        $pdf->positionAndDimension(455, 850, 260, 28);
        $pdf->writePDF("Total = R$ ".number_format($totalOrder, 2, ',', '.'));

        // Aprensentar o PDF criado
        $pdf->presentPDF();
    }

    public function sendOrderPDF() {

        // Verificar se veio o parâmetro order na query string
        if(!isset($_GET["order"])) {
            Store::Redirect("home", true);
            exit;
        }

        $orderId = Store::aesDescrypt($_GET["order"]);

        // Verificar se o id do usuário está vazio, caso esteja redirecionamos para a home
        if(empty($orderId)) {
            Store::Redirect("home", true);
            exit;
        }

        // Verificar se o tipo do parâmetro é diferente de uma string.
        // Caso não seja uma string redirecionamos para home.
        if(gettype($orderId) != "string") {
            Store::Redirect("home", true);
            exit;
        }

        // Pegando dados da compra
        $orderData = AdminOrders::detailsOrder($orderId);

        // Criar o PDF
        $pdf = new PDF();

        // Definindo o template do pdf
        $pdf->setTemplate(getcwd()."/assets/templates/example.pdf");

        // Definindo a família, tamanho e tipo da fonte
        $pdf->setFontFamily("Arial");
        $pdf->setFontSize("14px");
        $pdf->setFontWeight("bold");

        // Mostrando a data no PDF
        $pdf->positionAndDimension(225, 204, 165, 22);
        $pdf->writePDF(date("d/m/Y H:i:s", strtotime($orderData["order"]->created_at)));

        // Mostrando o código da compra no PDF
        $pdf->positionAndDimension(550, 203, 165, 22);
        $pdf->writePDF($orderData["order"]->code_order);

        // Mostrando os dados do cliente no PDF
        // Nome
        $pdf->positionAndDimension(75, 260, 600, 22);
        $pdf->writePDF($orderData["order"]->name);

        // Endereço
        $pdf->positionAndDimension(75, 284, 600, 22);
        $pdf->writePDF($orderData["order"]->address. " - ".$orderData["order"]->city);

        // Email e telefone
        $pdf->positionAndDimension(75, 308, 600, 22);
        if($orderData["order"]->phone != "") {
            $pdf->writePDF($orderData["order"]->email. " - ". $orderData["order"]->phone);
        } else {
            $pdf->writePDF($orderData["order"]->email);
        }

        // Aprensentar a lista de produtos no PDF
        $y = 390;
        $totalOrder = 0;
        $pdf->setFontWeight("normal");

        foreach($orderData["orderProducts"] as $item) {
            // Apresentação da quantdade e nome do produto
            $pdf->setAlignText("left");
            $pdf->positionAndDimension(75, $y, 500, 22);
            $pdf->writePDF($item->quantity. " x ".substr($item->name, 0, 200));

            // Preço do produto
            $pdf->setAlignText("right");
            $pdf->positionAndDimension(560, $y, 150, 22);

            $price = $item->price_unit * $item->quantity;
            $totalOrder += $price;

            $pdf->writePDF("R$ ".number_format($price, 2, ',', '.'));

            $y += 28;
        }

        // Apresentar o total da compra
        $pdf->setAlignText("right");
        $pdf->setFontSize("22px");
        $pdf->setFontWeight("bold");
        $pdf->setColor("#fff");

        $pdf->positionAndDimension(455, 850, 260, 28);
        $pdf->writePDF("Total = R$ ".number_format($totalOrder, 2, ',', '.'));

        // Aprensentar o PDF criado
        // $pdf->presentPDF();

        // Guardar o arquivo PDF
        $name = $orderData["order"]->code_order . "_" . date("YmdHis").".pdf";
        $pdf->savePDF($name);

        // Enviar email para o cliente com o PDF em anexo
        $resultEmail = SendEmail::sendPDFOrderFromClient($orderData["order"]->email, $name);

        if($resultEmail) {
            echo "Email enviado com sucesso!";
        }

    }

}