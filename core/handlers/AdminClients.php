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
            SELECT id_client, email, name, phone, active, deleted_at
            FROM clients
        ");

        return $results;
    }

    /**
     * @param int $idClient
     * @return object
    */
    public static function searchClientById($idClient): object {
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