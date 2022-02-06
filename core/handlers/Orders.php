<?php
namespace core\handlers;

use core\classes\Database;

class Orders {

    /**
     * @param array $dataOrder
     * @param array $dataProducts
     * @return void 
    */

    public static function saveOrder(array $dataOrder, array $dataProducts) {

        // Guardar DADOS DA ENCOMENDA no banco de dados
        $db = new Database();
        $params = [
            ":id_client" => $_SESSION["loggedUser"],
            ":address" => $dataOrder["address"],
            ":city" => $dataOrder["city"],
            ":email" => $dataOrder["email"],
            ":phone" => $dataOrder["phone"],
            ":code_order" => $dataOrder["codeOrder"],
            ":status" => $dataOrder["status"],
            ":message" => $dataOrder["message"]
        ];

        $db->insert("INSERT INTO orders VALUES(
            0,
            :id_client,
            NOW(),
            :address,
            :city,
            :email,
            :phone,
            :code_order,
            :status,
            :message,
            NOW(),
            NOW()
        )", $params);

        // Guardar DADOS DO PRODUTO no banco de dados
        $idOrder = $db->select("SELECT MAX(id_order) id_order FROM orders")[0]->id_order;

        foreach ($dataProducts as $product) {
            $params = [
                ":id_order" => $idOrder,
                ":name" => $product["name"],
                ":price_unit" => $product["price"],
                ":quantity" => $product["quantity"]
            ];

            $db->insert("INSERT INTO sale_products VALUES(
                0,
                :id_order,
                :name,
                :price_unit,
                :quantity,
                NOW()
            )", $params);
        }
    }

}