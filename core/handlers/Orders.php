<?php
namespace core\handlers;

use core\classes\Database;

class Orders {

    /**
     * @param array $dataOrder
     * @param array $dataProducts
     * @return void 
    */
    public static function saveOrder(array $dataOrder, array $dataProducts): void {

        // Guardar DADOS DA COMPRA no banco de dados
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

    /**
     * @param int $loggedUser
     * @return array 
    */
    public static function searchHistoryOrdersFromLoggedUser(int $loggedUser): array {
        // Buscar o histórico do usuário
        $params = [ "id_client" => $loggedUser ];

        $db = new Database();
        $results = $db->select("
            SELECT id_order, date, code_order, status
            FROM orders
            WHERE id_client = :id_client
            ORDER BY date DESC
        ", $params);

        return $results;
    }

    /**
     * @param int $idClient
     * @param int $idOrder
     * @return bool 
    */
    public static function verifyOrderLoggedUser(int $idClient, int $idOrder): bool {

        // Verificar se a encomenda pertence ao usuário logado
        $params = [ "id_client" => $idClient, "id_order" => $idOrder ];
        $db = new Database();
        $result = $db->select("
            SELECT id_order
            FROM orders
            WHERE id_order = :id_order
            AND id_client = :id_client
        ", $params);

        return count($result) == 0 ? false: true;
    }

    /**
     * @param int $idClient
     * @param int $idOrder
     * @return array 
    */
    public static function detailsOrder(int $idClient, int $idOrder): array {

        // Buscar os dados da encomenda e lista dos produtos da encomenda
        $params = [
            ":id_client" => $idClient,
            ":id_order" => $idOrder
        ];
        
        $db = new Database();

        // Dados da encomenda
        $dataOrder = $db->select("
            SELECT * FROM orders
            WHERE id_client = :id_client
            AND id_order = :id_order
        ", $params)[0];

        // Dados dos produtos da encomenda
        $params = [
            "id_order" => $idOrder
        ];

        $productsOrder = $db->select("
            SELECT *
            FROM sale_products
            WHERE id_order = :id_order
        ", $params);

        // Devolver ao controler os dados da encomenda
        return [
            "dataOrder" => $dataOrder,
            "productsOrder" => $productsOrder
        ];
    }

    /**
     * @param string $codeOrder
     * @return bool 
    */
    public static function makePayment(string $codeOrder): bool {
        $params = [ ":code_order" => $codeOrder ];
        
        $db = new Database();
        $results = $db->select("
            SELECT *
            FROM orders
            WHERE code_order = :code_order
            AND status = 'PENDING'
        ", $params);

        if(count($results) == 0) {
            return false;
        }

        // Alterar o status da compra
        $db->update("
            UPDATE orders
            SET status = 'PROCESSING',
            updated_at = NOW()
            WHERE code_order = :code_order        
        ", $params);

        return true;
    }

}