<?php

namespace core\classes;
use Exception;

class Store {

    // ===========================================================
    public static function Render(array $structures, $data = null): void {
        // Verificar se a estrutura é um array, neste caso se não for retornamos um erro!
        if(!is_array($structures)) {
            throw new Exception("Erro na estrutura de views");
        }

        // Variáveis
        if(!empty($data) && is_array($data)) {
            extract($data); // https://www.w3schools.com/php/func_array_extract.asp
        }

        // Apresentar as views
        foreach($structures as $structure) {
            include("../core/views/$structure.php");
        }
    }

    // ===========================================================
    public static function LoggedUser(): bool {
        return isset($_SESSION['loggedUser']);
    }

    // ===========================================================
    public static function Redirect(string $route = '', bool $admin = false): void {
        // Redirecionar para a rota desejada
        if(!$admin) {
            header("Location: " . BASE_URL . "?a=$route");
        } else {
            header("Location: " . BASE_URL . "/admin?a=$route");
        }
    }

    // ===========================================================
    public static function createHash(int $numcharacters = 12) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle($chars), 0, $numcharacters);
    }

}