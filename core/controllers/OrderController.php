<?php

namespace core\controllers;

use core\classes\Store;
use core\handlers\Products;
use core\handlers\Users;

class OrderController {

    public function __construct() {}

    public function checkout() {
        if (!Store::LoggedUser()) {
            $_SESSION["tmpCart"] = true;
            Store::Redirect("signin");
        } else {
            Store::Redirect("resumeCheckout");
        }
    }

    public function resumeCheckout() {

        // Verificar se existe um usuário logado
        if (!Store::LoggedUser()) {
            $_SESSION["tmpCart"] = true;
            Store::Redirect("signin");
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
        // $_SESSION["total"] = $total;

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

    public function confirmOrder() {

        echo 'ESCOLHER';
        // $_SESSION["dataAlternative"] = [
        //     "address",
        //     "city",
        //     "email",
        //     "phone"
        // ];
        Store::PrintData($_SESSION);

    }
}
