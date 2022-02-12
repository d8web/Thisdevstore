<?php

namespace core\handlers;
use core\classes\Database;

class Admin {

    /**
        * @param string $email
        * @param string $password
        * @return bool|object
    */
    public static function validateAdminLogin(string $user, string $password) {
        
        // Verificar se o login é válido
        $params = [ ":user" => $user ];

        $db = new Database();
        $results = $db->select("
            SELECT * FROM admins WHERE user = :user
            AND deleted_at IS NULL",
            $params
        );

        if(count($results) != 1) {
            // Não existe usuário admin com este email
            return false;
        } else {

            // Temos o usuário, verificar senha
            $userAdmin = $results[0];

            // Verificar senha
            if(!password_verify($password, $userAdmin->password)) {

                // Senha inválida
                return false;

            } else {
                
                // login válido
                return $userAdmin;
            }

        }
    }

    /**
     * @return int 
    */
    public static function getTotalOrdersPending(): int {
        // Pegando a quantidade de vendas pendentes
        $db = new Database();
        $results = $db->select("
            SELECT COUNT(*) as total FROM orders
            WHERE status = 'PENDING'
        ");

        return $results[0]->total;
    }

    /**
     * @return int 
    */
    public static function getTotalOrdersProcessing(): int {
        // Pegando a quantidade de vendas em processamento
        $db = new Database();
        $results = $db->select("
            SELECT COUNT(*) as total FROM orders
            WHERE status = 'PROCESSING'
        ");

        return $results[0]->total;
    }
 
}