<?php

namespace core\controllers;

use core\classes\Store;
use core\handlers\Products;

class CartController {

    public function index() {

        // Verificar se existe uma sessão cart
        if(!isset($_SESSION["cart"]) || count($_SESSION["cart"]) == 0) {
            $data = [ "cart" => null ];
        } else {

            $ids = [];
            foreach($_SESSION["cart"] as $idProduct => $quantity) {
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

            $data = [ "cart" => $dataTmp ];
        }

        // Aprensentar a página de carrinho
        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/cart",
            "partials/bottom",
            "partials/footer"
        ], $data);
    }

    public function addToCart() {

        // Verificando se na query string existe o parâmetro idProduct e se o seu valor é diferente de NULL
        if(!isset($_GET["idProduct"])) {
            echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : "";
            return;
        }

        // Pegando o id do produto na query string
        $idProduct = $_GET["idProduct"];
        $results = Products::verifyStockProduct($idProduct);

        if(!$results) {
            echo isset($_SESSION["cart"]) ? count($_SESSION["cart"]) : "";
            return;
        }

        // Array do carrinho
        $cart = [];
        if(isset($_SESSION["cart"])) {
            $cart = $_SESSION["cart"];
        }

        // Adicionar o produto ao carrinho
        if(key_exists($idProduct, $cart)) {
            // Existe o produto no carrinho, adiciona mais um na quantidade;
            $cart[$idProduct]++;
        } else {
            // Adicionando o novo produto ao carrinho
            $cart[$idProduct] = 1;
        }

        // Atualiza os dados do carrinho na sessão
        $_SESSION["cart"] = $cart;

        // Resposta (número de produtos no carrinho)
        $total = 0;
        foreach ($cart as $quantity) {
            $total += $quantity;
        }

        echo $total;
    }

    public function clearcart() {
        // Esvaziar o carrinho
        unset($_SESSION['cart']);

        // Redireciona/Refresh para o carrinho
        $this->index();
    }

    public function removeProductCart() {
        
        // Verificando se na query string tem o idProduct, se seu valor é diferente de null
        if (!isset($_GET["idProduct"])) {
            Store::Redirect("cart");
            exit;
        }

        // Pegando o id do produto na query string
        $idProduct = $_GET["idProduct"];

        // Pegando sessão do carrinho
        $cart = $_SESSION["cart"];

        // Removendo produto do carrinho
        unset($cart[$idProduct]);

        // Atualizar sessão carrinho com o novo carrinho com o item excluido
        $_SESSION["cart"] = $cart;

        // Apresentar/atualizar página do carrinho
        $this->index();
    }

}
