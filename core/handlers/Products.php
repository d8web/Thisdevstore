<?php
namespace core\handlers;

use core\classes\Database;

class Products {

    public static function listProductsVisibles(string $category) {

        $db = new Database();
        // Lista de categorias da loja
        $categories = self::listCategories();

        $sql = "SELECT * FROM products WHERE 1";
        $sql .= " AND visible = 1";
        $sql .= " AND deleted_at IS NULL";

        if(in_array($category, $categories)) {
            $sql .= " AND category = '$category'";
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

    public static function verifyStockProduct(int $id_product): bool {

        $db = new Database();
        $params = [ 'id_product' => $id_product ];
        $results = $db->select("
            SELECT * FROM products
            WHERE id_product = :id_product
            AND visible = 1
            AND stock > 0",
        $params);

        return count($results) != 0 ? true : false;
    }

    public static function getProductsByIds(string $ids): array {

        $db = new Database();
        return $db->select("
            SELECT * FROM products
            WHERE id_product IN ($ids)
        ");
        
    }

}