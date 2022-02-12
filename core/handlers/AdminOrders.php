<?php

namespace core\handlers;

use core\classes\Database;

class AdminOrders {

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
    public static function updateStatusOrder(int $idOrder, string $status): void {
        $params = [ ":id_order" => $idOrder, "status" => $status ];
        
        $db = new Database();
        $db->update("
            UPDATE orders
            SET status = :status, updated_at = NOW()
            WHERE id_order = :id_order
        ", $params);
    }

    /**
     * @param int $idClient
     * @return array
    */
    public static function searchOrdersUserById(int $idClient): array {
        $params = [ ":id_client" => $idClient ];

        $db = new Database();
        return $db->select("
            SELECT * FROM orders
            WHERE id_client = :id_client",
        $params);
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
     * @param string $filter
     * @param null|string $userId
     * @return array
    */
    public static function getListOrders(string $filter, $userId): array {
        $db = new Database();

        $stringSql = "SELECT o.*, c.name FROM orders o LEFT JOIN clients c ON o.id_client = c.id_client WHERE 1";
        if($filter != "") {
            $stringSql .= " AND o.status = '$filter'";
        }

        if(!empty($userId)) {
            $stringSql .= " AND o.id_client = $userId";
        }

        $stringSql .= " ORDER BY o.id_order DESC";

        return $db->select($stringSql);
    }

}