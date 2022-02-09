<?php

namespace core\handlers;

// Functions required
use core\classes\Store;
use core\classes\Database;

class AdminClients {

    /**
     * @return array 
    */
    public static function getListClients(): array {
        $db = new Database();

        $results = $db->select("
            SELECT
                clients.id_client,
                clients.email,
                clients.name,
                clients.phone,
                clients.active,
                clients.deleted_at,
                COUNT(orders.id_order) totalUserOrders
            FROM clients LEFT JOIN orders
            ON clients.id_client = orders.id_client
            GROUP BY clients.id_client
        ");

        return $results;
    }

    /**
     * @param int $idClient
     * @return object
    */
    public static function searchClientById(int $idClient): object {
        $params = [ ":id_client" => $idClient ];

        $db = new Database();
        $results = $db->select("
            SELECT *
            FROM clients
            WHERE id_client = :id_client",
        $params);

        return $results[0];
    }

    /**
     * @param int $idClient
     * @return int 
    */
    public static function searchOrdersClient(int $idClient): int {
        $params = [ ":id_client" => $idClient ];

        $db = new Database();
        $results = $db->select("
            SELECT count(*) as total
            FROM orders
            WHERE id_client = :id_client",
        $params);

        return $results[0]->total;
    }

    /**
     * @param int $idClient
     * @return array
    */
    public static function searchOrdersUserById(int $idClient): array {
        $params = [ ":id_client" => $idClient ];

        $db = new Database();
        return $results = $db->select("
            SELECT * FROM orders
            WHERE id_client = :id_client",
        $params);
    }

    /**
     * @param int $idClient
     * @return array
    */
    public static function detailsOrder(string $idOrder): array {
        $params = [ ":id_order" => $idOrder ];
        
        $db = new Database();
        $dataOrder = $db->select("
            SELECT clients.name, orders.*
            FROM clients, orders
            WHERE orders.id_order = :id_order
            AND clients.id_client = orders.id_client",
        $params);
        $orderProducts = $db->select("SELECT * FROM sale_products WHERE id_order = :id_order", $params);

        return [
            "order" => $dataOrder[0],
            "orderProducts" => $orderProducts
        ];
    }

    /**
     * @param int $irOrder
     * @param string $status
     * @return void
    */
    public static function updateStatusOrder($idOrder, $status): void {
        $params = [ ":id_order" => $idOrder, "status" => $status ];
        
        $db = new Database();
        $db->update("
            UPDATE orders
            SET status = :status, updated_at = NOW()
            WHERE id_order = :id_order
        ", $params);
    }

}