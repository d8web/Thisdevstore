<?php
namespace core\controllers;

use core\classes\Store;
use core\handlers\Users;

class UserController {

    public function __construct() {
        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if (Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }
    }

    // ============================================================
    public function newUser() {
        // Retorna a página com formulário para adicionar/cadastrar um novo usuário.
        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/newUser",
            "partials/bottom",
            "partials/footer"
        ]);
    }

    // ============================================================
    public function newUserAction() {
        // Verificar se houve submissão do formulário
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            Store::Redirect("home");
            exit;
        }

        // Verificar se as senhas são iguais
        if ($_POST["password"] !== $_POST["password_confirm"]) {
            $_SESSION["error"] = "As senhas não são iguais!";
            Store::Redirect("signup");
            exit;
        }

        // Verificar se existe algum cliente com o email
        if(Users::emailExists($_POST["email"])) {
            $_SESSION["error"] = "Este email já está em uso!";
            Store::Redirect("signup");
            exit;
        }

        // Usuário pronto para ser inserido no banco de dados
        $hash = Users::registerUserDatabase();

        $linkHash = "http://localhost/store/public/?a=confirmEmail&hash=$hash";
    }
}