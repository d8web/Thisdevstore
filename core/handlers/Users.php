<?php

namespace core\handlers;

use core\classes\Database;
use core\classes\Store;

class Users {

    // ============================================================
    public static function emailExists(string $email) {
        // Verificar se o email existe no banco de dados
        $db = new Database();
        $params = [":email" => strtolower(trim($email))];
        $results = $db->select("SELECT email FROM clients WHERE email = :email", $params);

        return count($results) != 0 ? true : false;
    }

    // ============================================================
    public static function registerUserDatabase() {
        // Registrar novo cliente no banco de dados
        $db = new Database();

        // Criando hash para registrar cliente
        $hash = Store::createHash();

        // Parâmetros
        $params = [
            ":email" => strtolower(trim($_POST["email"])),
            ":password" => password_hash($_POST["password"], PASSWORD_DEFAULT),
            ":name" => trim($_POST["name"]),
            ":address" => trim($_POST["address"]),
            ":city" => trim($_POST["city"]),
            ":phone" => trim($_POST["phone"]),
            ":hash" => $hash,
            ":active" => 0
        ];

        $db->insert(
            "INSERT INTO clients VALUES(
                0,
                :email,
                :password,
                :name,
                :address,
                :city,
                :phone,
                :hash,
                :active,
                NOW(),
                NOW(),
                NULL
            )",$params
        );

        // Retorna a hash
        return $hash;
    }
}
