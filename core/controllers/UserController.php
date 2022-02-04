<?php
namespace core\controllers;

use core\classes\Store;
use core\classes\SendEmail;
use core\handlers\Users;

class UserController {

    public function __construct() {
        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if (Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }
    }

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
        $userEmail = strtolower(trim($_POST["email"]));
        $hash = Users::registerUserDatabase();

        // Enviar email para o novo usuário
        $email = new SendEmail();
        $result = $email->sendEmailConfirmNewClient($userEmail, $hash);

        if($result) {
            
            // Apresentar página para informar que foi enviado um email para confirmar a nova conta.
            Store::Render([
                "partials/header",
                "partials/navbar",
                "pages/newUserSucess",
                "partials/bottom",
                "partials/footer"
            ]);
            exit;

        } else {
            echo "Ocorreu um erro.";
        }
    }

    public function confirmEmail() {
        // Verificar se existe uma hash na query string
        if(!isset($_GET["hash"])) {
            Store::Redirect("home");
            exit;
        }

        // Verificar se o hash é válido
        $hash = $_GET["hash"];
        if(strlen($hash) !== 12) {
            Store::Redirect("home");
            exit;
        }

        $result = Users::validateEmail($hash);
        if($result) {

            // Apresentar página para informar que a conta do usuário foi confirmada com sucesso.
            Store::Render([
                "partials/header",
                "partials/navbar",
                "pages/accountConfirmSuccess",
                "partials/bottom",
                "partials/footer"
            ]);
            exit;

        } else {
            Store::Redirect("home");
            exit;
        }
    }

}