<?php

namespace core\controllers;

use core\classes\SendEmail;
use core\classes\Store;
use core\handlers\Orders;
use core\handlers\Products;
use core\handlers\Users;

class OrderController {
    
    public function checkout() {
        // Verificar se existe um usuário logado
        if (!Store::LoggedUser()) {
            $_SESSION["tmpCart"] = true;
            Store::Redirect("signin");
        } else {
            Store::Redirect("resumeCheckout");
        }
    }
    
    public function addressAlternative() {
    
        // Axios retorna um json
        // Receber os dados via ajax, transformando em um array associoativo
        $post = json_decode(file_get_contents("php://input"), true);
        
        // Adicionar na sessão/altera a variável dataAlternative = []
        $_SESSION["dataAlternative"] = [
            "address" => $post["address"],
            "city" => $post["city"],
            "email" => $post["email"],
            "phone" => $post["phone"],
        ];
        
    }

    public function resumeCheckout() {

        // Verificar se existe um usuário logado
        if (!Store::LoggedUser()) {
            Store::Redirect("signin");
            exit;
        }

        // Verificar se podemos avançar para gravar a compra
        if(!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
            Store::redirect("home");
            exit;
        }

        // Informações da encomenda
        $ids = [];
        foreach ($_SESSION["cart"] as $idProduct => $quantity) {
            array_push($ids, $idProduct);
        }

        $ids = implode(",", $ids);
        $results = Products::getProductsByIds($ids);

        $dataTmp = [];
        foreach($_SESSION["cart"] as $idProduct => $quantityCart) {

            // Imagem do produto
            foreach($results as $product) {
                if($product->id_product == $idProduct) {
                    $idProduct = $product->id_product;
                    $image = $product->image;
                    $title = $product->name;
                    $quantity = $quantityCart;
                    $price = $product->price * $quantity;

                    // Adicionando produto ao array
                    array_push($dataTmp, [
                        "idProduct" => $idProduct,
                        "image" => $image,
                        "title" => $title,
                        "quantity" => $quantity,
                        "price" => $price
                    ]);

                    break;
                }
            }
        }

        // Calcular o total
        $total = 0;
        foreach($dataTmp as $item) {
            $total += $item["price"];
        }

        array_push($dataTmp, $total);

        // Inserir o total na sessão
        $_SESSION["total"] = $total;

        // Dados do carrinho
        $data = [];
        $data["cart"] = $dataTmp;

        $dataClient = Users::searchDataClient($_SESSION["loggedUser"]);
        $data["client"] = $dataClient;

        /* ===============================================
            Gerar código do pedido
        =============================================== */
        if(!isset($_SESSION["codeOrder"])) {
            $codeOrder = Store::generateHashOrder();
            $_SESSION["codeOrder"] = $codeOrder;
        }

        // Mostrar os dados da encomenda
        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/resumeCheckout",
            "partials/bottom",
            "partials/footer"
        ], $data);
    }

    public function confirmOrder() {

        // Verificar se tem cliente logado, caso não tenha redireciona a loja para página inicial
        if(!Store::loggedUser()) {
            Store::redirect("home");
            exit;
        }

        // Verificar se podemos avançar para gravar a compra
        if(!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
            Store::redirect("home");
            exit;
        }

        $dataOrder = [];

        // Pegando os dados dos produtos
        $ids = [];
        foreach($_SESSION["cart"] as $idProduct => $quantity) {
            array_push($ids, $idProduct);
        }

        $ids = implode(",", $ids);
        $dataOrder["products"] = Products::getProductsByIds($ids);

        // Total da compra
        $dataOrder["total"] = "R$ ".number_format($_SESSION["total"], 2, ',', '.');

        Store::Render([
            "pages/stripeCheckout"
        ], $dataOrder);

    }

    public function checkoutConfirmed() {

        // Verificar se tem cliente logado, caso não tenha redireciona a loja para página inicial
        if(!Store::loggedUser()) {
            Store::redirect("home");
            exit;
        }

        // Verificar se podemos avançar para gravar a compra
        if(!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
            Store::redirect("home");
            exit;
        }

        $dataOrder = [];

        // Pegando os dados dos produtos
        $ids = [];
        foreach($_SESSION["cart"] as $idProduct => $quantity) {
            array_push($ids, $idProduct);
        }

        $ids = implode(",", $ids);
        $ProductsOrder = Products::getProductsByIds($ids);

        // Estrutura de dados dos produtos para enviar para o cliente
        $stringProduct = [];
        foreach($ProductsOrder as $product) {
            // Pegando a quantidade
            $quantity = $_SESSION["cart"][$product->id_product];

            // Adicionando ao array de strings
            $stringProduct[] = "$quantity x $product->name - R$ ".number_format($product->price, 2, ',', '.')." / Unidade.";
        }

        // Lista de produtos para enviar no email
        $dataOrder["products"] = $stringProduct;

        // Total da compra
        $dataOrder["total"] = "R$ ".number_format($_SESSION["total"], 2, ',', '.');

        // Informações de pagamento
        $dataOrder["paymentData"] = [
            "codeOrder" => $_SESSION["codeOrder"],
            "total" => "R$ ".number_format($_SESSION["total"], 2, ',', '.')
        ];

        // Enviando email para o comprador com informações da compra
        $resultEmail = SendEmail::sendEmailConfirmOrder($_SESSION["email"], $dataOrder);

        if($resultEmail) {

            $dataOrder = [];
            $dataOrder["id_client"] = $_SESSION["loggedUser"];
    
            // Endereço anternativo
            if(isset($_SESSION["dataAlternative"]["address"]) && !empty($_SESSION["dataAlternative"]["address"])) {
                // Endereço alternativo foi enviado, usamos seu valor para inserir na BD
                $dataOrder["address"] = $_SESSION["dataAlternative"]["address"];
                $dataOrder["city"] = $_SESSION["dataAlternative"]["city"];
                $dataOrder["email"] = $_SESSION["dataAlternative"]["email"];
                $dataOrder["phone"] = $_SESSION["dataAlternative"]["phone"];
            } else {
                // Endereço do cliente já salvo no banco de dados
                $dataClient = Users::searchDataClient($_SESSION["loggedUser"]);
    
                $dataOrder["address"] = $dataClient->address;
                $dataOrder["city"] = $dataClient->city;
                $dataOrder["email"] = $dataClient->email;
                $dataOrder["phone"] = $dataClient->phone;
            }
    
            // Código da encomenda
            $dataOrder["codeOrder"] = $_SESSION["codeOrder"];
    
            // Status da compra
            $dataOrder["status"] = "PROCESSING";
            $dataOrder["message"] = "";
    
            // Montando array de dados do produto da compra realizada
            $productsData = [];
            foreach($ProductsOrder as $product) {
                $productsData[] = [
                    "name" => $product->name,
                    "price" => $product->price,
                    "quantity" => $_SESSION["cart"][$product->id_product]
                ];
            }
    
            // Inserindo nova compra na tabela
            Orders::saveOrder($dataOrder, $productsData);
    
            // Código da compra
            $codeOrder = $_SESSION["codeOrder"];
    
            // Total da compra
            $totalSale = $_SESSION["total"];
    
            // Limpando variáveis da sessão [cart], [codeOrder], [total], [dataAlternative]
            unset($_SESSION["codeOrder"]);
            unset($_SESSION["cart"]);
            unset($_SESSION["total"]);
            unset($_SESSION["dataAlternative"]);
    
            // Preenchendo dados para mostrar na página de compra confirmada
            $data = [
                "codeOrder" => $codeOrder,
                "totalSale" => $totalSale
            ];
    
            // Mostrar a view da compra confirmada
            Store::Render([
                "partials/header",
                "partials/navbar",
                "pages/confirmOrder",
                "partials/bottom",
                "partials/footer"
            ], $data);
        }

    }

}
