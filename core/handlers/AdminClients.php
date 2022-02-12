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

}