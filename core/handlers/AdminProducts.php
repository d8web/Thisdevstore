<?php

namespace core\handlers;
use core\classes\Database;

class AdminProducts {

    /**
     * @return array 
    */
    public static function getListProducts(): array {
        $db = new Database();
        $result = $db->select("SELECT * FROM products");
        return $result;
    }

    /**
     * @param array $data 
    */
    public static function addProduct($data) {

        $params = [
            ":category" => $data["category"],
            ":name" => $data["name"],
            ":description" => $data["description"],
            ":image" => $data["image"],
            ":price" => $data["price"],
            ":stock" => $data["stock"],
            ":visible" => $data["visible"],
            ":bestseller" => $data["bestseller"]
        ];

        $db = new Database();
        $db->insert("INSERT INTO products VALUES(
            0,
            :category,
            :name,
            :description,
            :image,
            :price,
            :stock,
            :visible,
            :bestseller,
            NOW(),
            NOW(),
            NULL
        )", $params);

    }

    /**
     * @param int $idProduct
     * @return object 
    */
    public static function getProductById(int $idProduct): object {
        $params = [ ":id_product" => $idProduct ];

        $db = new Database();
        return $db->select("
            SELECT * FROM products
            WHERE id_product = :id_product",
        $params)[0];
    }

    public static function updateProduct($updateData) {
        $params = [
            ":id_product" => $updateData["id"],
            ":category" => $updateData["category"],
            ":name" => $updateData["name"],
            ":description" => $updateData["description"],
            ":image" => $updateData["image"],
            ":price" => $updateData["price"],
            ":stock" => $updateData["stock"],
            ":visible" => $updateData["visible"],
            ":bestseller" => $updateData["bestseller"]
        ];

        $db = new Database();
        $db->update("
            UPDATE products
            SET category = :category,
            name = :name,
            description = :description,
            image = :image,
            price = :price,
            stock = :stock,
            visible = :visible,
            bestseller = :bestseller,
            updated_at = NOW()
            WHERE id_product = :id_product
        ", $params);
    }

    public static function deletedProduct($id) {

        $params = [ ":id_product" => $id ];

        $db = new Database();
        $db->update("
            UPDATE products
            SET deleted_at = NOW()
            WHERE id_product = :id_product
        ", $params);

    }

}