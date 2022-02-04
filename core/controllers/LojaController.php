<?php
namespace core\controllers;

use core\classes\Store;
use core\handlers\Products;

class LojaController {

    public function index() {

        // Verificar que categoria será exibida
        $categoryQueryString = "todos";
        if(isset($_GET["c"])) {
            $categoryQueryString = $_GET["c"];
        }

        // Buscando lista de produtos do banco de dados
        $listProducts = Products::listProductsVisibles($categoryQueryString);

        // Lista das categorias do banco de dados
        $listCategories = Products::listCategories();

        $data = [
            "products" => $listProducts,
            "categories" => $listCategories
        ];

        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/store",
            "partials/bottom",
            "partials/footer"
        ], $data);
        
    }
    
}