<?php

namespace core\controllers\admin;

use core\classes\Store;
use core\handlers\Admin;

class AuthController {

    // Mostrar formulário para login do admin
    public function signIn() {

        // Verificar se existe um admin logado
        if(Store::LoggedAdmin()) {
            Store::Redirect("home", true);
            exit;
        }

        // Aprensentar a página de admin
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/signIn",
            "admin/partials/bottom",
            "admin/partials/footer"
        ]);

    }

    // Submissão do formulário para login do admin
    public function signInAdminAction() {
        
        // Verificar se existe admin logado, se existe não tem por que acessar a página d login
        if(Store::loggedAdmin()) {
            Store::Redirect("home", true);
            return;
        }

        // Verificar se foi efetuado o post do formulário de login do admin
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            Store::Redirect("home", true);
            return;
        }

        // Verificar se os dados enviados não existem ou não foram definidos seus respectivos valores
        if (
            !isset($_POST["user"]) ||
            !isset($_POST["password"]) ||
            !filter_var(trim($_POST["user"]), FILTER_VALIDATE_EMAIL)
        ) {
            // Erro de preenchimento do formulário
            $_SESSION["error"] = "Login inválido!";
            Store::Redirect("signInAdmin", true);
        }

        // Preparando os dados para o model
        $user = trim(strtolower($_POST["user"]));
        $password = trim($_POST["password"]);

        // Carrega o model e verifica se o login é válido
        $result = Admin::validateAdminLogin($user, $password);

        // Analizando se o resultado é um boolean do valor falso, único valor boleano que o validateLogin retorna.
        if(is_bool($result)) {

            // Login inválido
            $_SESSION["error"] = "Login inválido!";
            Store::Redirect("signInAdmin", true);
            return;

        } else {

            // Login válido, inserir dados na sessão do admin
            $_SESSION["loggedAdmin"] = $result->id;
            $_SESSION["userAdmin"] = $result->user;

            // Redirecionar para a página inicial do backoffice
            Store::Redirect("home", true);
        }

    }

    // Logout do admin
    public function logoutAdmin() {

        // Remover todas as variáveis das sessões
        unset($_SESSION["loggedAdmin"]);
        unset($_SESSION["userAdmin"]);

        // Redirecionar para o inicio
        Store::redirect("signInAdmin", true);

    }

}