<?php

namespace core\controllers\admin;

use core\classes\SendEmail;
use core\classes\Store;
use core\handlers\Admin;
use core\handlers\AdminClients;

class AdminController {

    public function __construct() {
        // Verificar se existe um admin logado
        if(!Store::LoggedAdmin()) {
            Store::Redirect("signInAdmin", true);
            exit;
        }
    }

    public function index() {
        
        $data = [
            "totalPendingOrders" =>  Admin::getTotalOrdersPending(),
            "totalProcessingOrders" => Admin::getTotalOrdersProcessing()
        ];

        // Aprensentar a página de admin
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/home",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);

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
            "listSales" => Admin::getListOrders($filter, $userId),
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

    public function users() {

        $data = [ 
            "clients" => AdminClients::getListClients()
        ];

        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/users",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);
    }

    public function detailsUser() {

        // Verifica se o id do usuario foi passado pela query string
        if(!isset($_GET["user"])) {
            Store::Redirect("home", true);
            exit;
        }

        $clientId = Store::aesDescrypt($_GET["user"]);

        // Verificar se o id do usuário está vazio, caso esteja redirecionamos para a home
        if(empty($clientId)) {
            Store::Redirect("home", true);
            exit;
        }

        $data = [ 
            "detailsClient" => AdminClients::searchClientById($clientId),
            "totalOrdersClient" => AdminClients::searchOrdersClient($clientId)
        ];

        // Página de detalhes do usuário
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/detailsUser",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);
    }

    public function userHistoryOrder() {

        // Verifica se o id do usuario foi passado pela query string
        if(!isset($_GET["user"])) {
            Store::Redirect("home", true);
            exit;
        }

        $clientId = Store::aesDescrypt($_GET["user"]);

        // Verificar se o id do usuário está vazio, caso esteja redirecionamos para a home
        if(empty($clientId)) {
            Store::Redirect("home", true);
            exit;
        }

        // Pegando as compras do usuário
        $data = [
            "ordersUser" => AdminClients::searchOrdersUserById($clientId),
            "user" => AdminClients::searchClientById($clientId)
        ];
        
        // Página de detalhes do usuário
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/ordersUser",
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
        $data = AdminClients::detailsOrder($orderId);

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
        AdminClients::updateStatusOrder($idOrder, $status);

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

        echo "Deu certo!";

    }

    // Construir essa função para enviar um email e notificar o cliente da mudança de status da sua compra
    private function notifyClientAlterStatus($idOrder) {}

    private function sendEmailOrderSending($idOrder) {
        // Pegando os dados da compra
        $orderData = AdminClients::detailsOrder($idOrder);

        return SendEmail::sendEmailSendProduct($orderData);
    }

}