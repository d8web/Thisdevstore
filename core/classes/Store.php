<?php

namespace core\classes;
use Exception;

class Store {

    /**
     * @param array $structures
     * @param array|null $data
     * @return void 
    */
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

    /**
     * @param array $structures
     * @param array|null $data
     * @return void 
    */
    public static function RenderAdmin(array $structures, $data = null): void {
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
            include("../../core/views/$structure.php");
        }
    }

    /**
     * @return bool 
    */
    public static function LoggedUser(): bool {
        return isset($_SESSION["loggedUser"]);
    }

    /**
     * @return bool 
    */
    public static function LoggedAdmin(): bool {
        return isset($_SESSION["loggedAdmin"]);
    }

    /**
     * @param string $route
     * @param bool $admin
     * @return void 
    */
    public static function Redirect(string $route = "", bool $admin = false): void {
        // Redirecionar para a rota desejada
        if(!$admin) {
            header("Location: " . BASE_URL . "?a=$route");
        } else {
            header("Location: " . BASE_URL . "/admin?a=$route");
        }
    }

    /**
     * @return string 
    */
    public static function createHash(int $numcharacters = 12): string {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        return substr(str_shuffle($chars), 0, $numcharacters);
    }

    /**
     * @param string $value
     * @return string 
    */
    public static function aesEncrypt(string $value) {
        return bin2hex(openssl_encrypt($value, "aes-256-cbc", AES_KEY, OPENSSL_RAW_DATA, AES_IV));
    }

    /**
     * @param string $value
     * @return string
    */
    public static function aesDescrypt(string $value) {
        return openssl_decrypt(hex2bin($value), "aes-256-cbc", AES_KEY, OPENSSL_RAW_DATA, AES_IV);
    }

    /**
     * @return string 
    */
    public static function GenerateHashOrder(): string {
        // Gerar código da encomenda
        $code = "";
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $code .= substr(str_shuffle($chars), 0, 2);
        $code .= rand(100000, 999999);
        return $code;
    }

    /**
     * @return void 
    */
    public static function PrintData($data, $die = true): void {
        if (is_array($data) || is_object($data)) {
            echo "<pre>";
            print_r($data);
        } else {
            echo "<pre>";
            echo $data;
        }

        if($die) {
            die("<br> Terminado");
        }
    }

}