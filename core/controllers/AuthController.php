<?php

namespace core\controllers;

use core\classes\Store;
use core\handlers\Users;

class AuthController {

    public function signIn() {

        // Verificar se existe um usuário logado, caso exista redirecionamos para a página home
        if(Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

        // Mostrar o formulário de login
        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/signin",
            "partials/bottom",
            "partials/footer"
        ]);
    }

    public function signinAction() {

        // Verificar se existe um usuário logado, caso exista redirecionamos para a página home
        if(Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }
        
        // Verificar se houve submissão do formulário
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            Store::Redirect("home");
            exit;
        }

        // Verificar se os dados enviados não existem ou não foram definidos seus respectivos valores
        if (
            !isset($_POST["email"]) ||
            !isset($_POST["password"]) ||
            !filter_var(trim($_POST["email"]), FILTER_VALIDATE_EMAIL)
        ) {
            // Erro de preenchimento do formulário
            $_SESSION["error"] = "Login inválido!";
            Store::Redirect("signin");
        }

        // Preparando os dados para o model
        $email = trim(strtolower($_POST['email']));
        $password = trim($_POST['password']);

        // Carrega o model e verifica se o login é válido
        $user = new Users();
        $result = $user->validateLogin($email, $password);

        // Analizando se o resultado é um boolean do valor falso.
        if(is_bool($result)) {

            // Login inválido
            $_SESSION["error"] = "Login inválido!";
            Store::redirect("signin");
            return;
        
        // Caso não retorne um valor boleano essa função vai retornar um objeto do usuário.
        } else {
            
            // Login válido, inserir dados na sessão
            $_SESSION["loggedUser"] = $result->id_client;
            $_SESSION["email"] = $result->email;
            $_SESSION["name"] = $result->name;
            
            // Verificar se a variável temporária da sessão está definida [ referer para o carrinho ]
            if(isset($_SESSION["tmpCart"])) {

                // Remove a variável temporária da sessão [ referer ]
                unset($_SESSION["tmpCart"]);
                // Redirecionar usuário para o resumo do checkout
                Store::redirect("resumeCheckout");

            } else {
                // Redirecionar para página Home
                Store::redirect("home");
            }
        }

    }

    public function logout() {
        // Remover todas as variáveis das sessões
        unset($_SESSION["loggedUser"]);
        unset($_SESSION["email"]);
        unset($_SESSION["name"]);

        // Redirecionar para o inicio
        Store::redirect("home");
    }

}