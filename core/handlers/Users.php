<?php

namespace core\handlers;

use core\classes\Database;
use core\classes\Store;

class Users {

    /**
     * @param string $email
     * @return bool
    */
    public static function emailExists(string $email): bool {
        // Verificar se o email existe no banco de dados
        $db = new Database();
        $params = [":email" => strtolower(trim($email))];
        $results = $db->select("SELECT email FROM clients WHERE email = :email", $params);

        return count($results) != 0 ? true : false;
    }

    /**
     * @param int $idClient
     * @param string $email
     * @return bool 
    */
    public static function verifyEmailExistsInOtherAccount(int $idClient, string $email): bool {

        $db = new Database();
        $params = [
            ':id_client' => $idClient,
            ':email' => strtolower(trim($email))
        ];

        $results = $db->select("
            SELECT id_client
            FROM clients
            WHERE id_client <> :id_client
            AND email = :email",
            $params
        );

        return (count($results) != 0) ? true : false;
    }

    /**
     * @return string 
    */
    public static function registerUserDatabase(): string {
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

    /**
     * @param string $hash
     * @return bool
    */
    public static function validateEmail(string $hash): bool {
        // Validar o email do novo usuário
        $params = [ ":hash" => $hash ];
        $db = new Database();
        $results = $db->select("SELECT * FROM clients WHERE hash = :hash", $params);

        if(count($results) !== 1) {
            return false;
        }

        // Encontrou um usuário com o hash
        $idClient = $results[0]->id_client;

        $newParams = [ ":id_client" => $idClient ];
        $db->update("
            UPDATE clients SET
            hash = NULL,
            active = 1,
            updated_at = NOW()
            WHERE id_client = :id_client",
        $newParams);

        return true;
    }

    /**
     * @param string $email
     * @param string $name
     * @param string $address
     * @param string $city
     * @param string $phone
     * @param int $idClient
     * @return void
    */
    public static function updateDataClient(string $email, string $name, string $address, string $city, string $phone, int $idClient): void {
        
        $params = [
            ":id_client" => $idClient,
            ":email" => $email,
            ":name" => $name,
            ":address" => $address,
            ":city" => $city,
            ":phone" => $phone,
        ];

        $db = new Database();
        $db->update("
            UPDATE clients
            SET
                name = :name,
                email = :email,
                address = :address,
                city = :city,
                phone = :phone,
                updated_at = NOW()
            WHERE id_client = :id_client
        ", $params);

    }

    /**
        * @param string $email
        * @param string $password
        * @return bool|object
    */
    public static function validateLogin(string $email, string $password) {
        // Verificar se o login é válido
        $params = [ ":email" => $email ];

        $db = new Database();
        $results = $db->select("
            SELECT * FROM clients WHERE email = :email
            AND active = 1
            AND deleted_at IS NULL",
            $params
        );

        if(count($results) != 1) {
            // Não existe usuário com este email
            return false;
        } else {

            // Temos o usuário, verificar senha
            $user = $results[0];

            // Verificar senha
            if(!password_verify($password, $user->password)) {
                // Senha inválida
                return false;
            } else {
                // login válido, retornamos o objeto do usuário
                return $user;
            }

        }
    }

    /**
     * @param int $idClient
     * @return object
    */
    public static function searchDataClient(int $idClient): object {

        $params = [ ":id_client" => $idClient ];

        $db = new Database();
        $results = $db->select("
            SELECT
                email,
                name,
                address,
                city,
                phone
            FROM clients
            WHERE id_client = :id_client",
        $params);

        return $results[0];
    }

    /**
     * @param int $idClient
     * @param string $password
     * @return bool
    */
    public static function verifyIsPasswordCorrect(int $idClient, string $password): bool {

        // Verifica se a senha atual está correta de acordo com o banco de dados
        $params = [ ":id_client" => $idClient ];
        $db = new Database();
        $passwordDB = $db->select("
            SELECT password
            FROM clients
            WHERE id_client = :id_client
        ", $params)[0]->password;

        return password_verify($password, $passwordDB);

    }

    /**
     * @param string $password
     * @param int $idClient
     * @return void 
    */
    public static function updatePassword(string $password, int $idClient): void {

        // Atualizar senha do usuário
        $params = [
            ":id_client" => $idClient,
            ":password" => password_hash($password, PASSWORD_DEFAULT)
        ];

        $db = new Database();
        $db->update("
            UPDATE clients
            SET password = :password,
            updated_at = NOW()
            WHERE id_client = :id_client
        ", $params);

    }
}
