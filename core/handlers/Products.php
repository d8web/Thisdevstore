<?php
namespace core\handlers;

use core\classes\Database;

class Products {

    public static function listProductsVisibles(string $category) {

        $db = new Database();
        // Lista de categorias da loja
        $categories = self::listCategories();

        $sql = "SELECT * FROM products ";
        $sql .= "WHERE visible = 1 ";

        if(in_array($category, $categories)) {
            $sql .= "AND category = '$category'";
        }

        $products = $db->select($sql);
        return $products;
    }

    public static function listCategories() {

        // Lista de categorias existentes no banco de dados
        $db = new Database();
        // DISTINCT retorna apenas um valor de cada
        // Ex: se no banco tivermos vários produtos com a categoria relógio ele retornara apenas um valor
        $results = $db->select("SELECT DISTINCT category FROM products");

        $categories = [];
        foreach($results as $result) {
            array_push($categories, $result->category);
        }

        return $categories;
    }

}