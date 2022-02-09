<?php
namespace core\controllers;

use core\classes\Store;
use core\classes\SendEmail;

use core\handlers\Orders;
use core\handlers\Users;

class UserController {

    public function newUser() {

        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

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

        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }
        
        // Verificar se houve submissão do formulário
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            Store::Redirect("home");
            exit;
        }

        // Verificar se as senhas são iguais
        if($_POST["password"] !== $_POST["password_confirm"]) {
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

        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

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

    // Página do perfil do usuário com a lista de informações, email, name, address, city, phone
    public function myaccount() {

        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(!Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

        $data = [];
        $data["user"] = Users::searchDataClient($_SESSION["loggedUser"]);

        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/profile/profileNavigation",
            "pages/profile/myaccount",
            "partials/bottom",
            "partials/footer"
        ], $data);

    }

    // Mostrar o formulário para alterar os dados do usuário logado, name, email, address, city, phone
    public function alterUserData() {

        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(!Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

        $data = [];
        $data["user"] = Users::searchDataClient($_SESSION["loggedUser"]);

        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/profile/profileNavigation",
            "pages/profile/alterUserData",
            "partials/bottom",
            "partials/footer"
        ], $data);

    }

    // Submissão do formulário para alteração dos dados do usuário logado
    public function alterUserDataSubmit() {
        
        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(!Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

        // Verificar se houve uma submissão do formulário POST
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            Store::Redirect("home");
            exit;
        }

        $email = trim(strtolower(trim($_POST["email"])));
        $name = trim($_POST["name"]);
        $address = trim($_POST["address"]);
        $city = trim($_POST["city"]);
        $phone = trim($_POST["phone"]);

        // Validar se o email é válido
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION["error"] = "E-mail inválido!";
            Store::Redirect("alterUserData");
            exit;
        }

        // Verificar se todos os dados estão vazios, caso estejam retornamos um erro
        if(empty($name) || empty($address) || empty($city)) {
            $_SESSION["error"] = "Preencha todos os dados corretamente";
            Store::Redirect("alterUserData");
            exit;
        }

        // Verificar se o email já existe e esta em uso no banco de dados
        $emailExistsInOtherAccount = Users::verifyEmailExistsInOtherAccount($_SESSION["loggedUser"], $email);
        if($emailExistsInOtherAccount) {
            $_SESSION["error"] = "Escolha outro E-mail!";
            Store::Redirect("alterUserData");
            exit;
        }

        // Atualizar os dados do usuário
        Users::updateDataClient($email, $name, $address, $city, $phone, $_SESSION["loggedUser"]);

        // Atualizar os dados da sessão
        $_SESSION["name"] = $name;
        $_SESSION["email"] = $email;

        // Redirecionar para a página do perfil
        Store::Redirect("myaccount");
    }

    // Mostrar o formulário para alterar a senha
    public function alterUserPassword() {

        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(!Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/profile/profileNavigation",
            "pages/profile/alterUserPassword",
            "partials/bottom",
            "partials/footer"
        ]);

    }

    // Submissão do formulário para alteração da senha do usuário logado
    public function alterUserPasswordSubmit() {

        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(!Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

        // Verificar se houve uma submissão do formulário POST
        if($_SERVER["REQUEST_METHOD"] !== "POST") {
            Store::Redirect("home");
            exit;
        }

        $oldPassword = trim($_POST["oldPassword"]);
        $newPassword = trim($_POST["newPassword"]);
        $newPasswordConfirm = trim($_POST["newPasswordConfirm"]);

        // Verificar se a nova senha tem pelo menos 6 caracteres, caso não tenha retornamos um erro
        if(strlen($newPassword) < 6) {
            $_SESSION["error"] = "Digite a nova senha e confirme corretamente!";
            Store::Redirect("alterUserPassword");
            exit;
        }

        // Verificar se a nova senha é diferente da confirmação da nova senha, caso seja retornamos um erro
        if($newPassword != $newPasswordConfirm) {
            $_SESSION["error"] = "Sua nova não é igual a confirmação da senha!";
            Store::Redirect("alterUserPassword");
            exit;
        }

        // Verificar se a senha atual esta correta, se não estiver retornamos um erro
        $verifyIsPasswordCorrect = Users::verifyIsPasswordCorrect($_SESSION["loggedUser"], $oldPassword);
        if(!$verifyIsPasswordCorrect) {
            $_SESSION["error"] = "Sua senha está incorreta!";
            Store::Redirect("alterUserPassword");
            exit;
        }

        // Verificar se a senha atua é igual a nova senha, se sim retornamos um erro
        if($oldPassword == $newPassword) {
            $_SESSION["error"] = "Sua nova senha não pode ser igual a senha antiga!";
            Store::Redirect("alterUserPassword");
            exit;
        }

        // Atualizar a senha
        Users::updatePassword($newPassword, $_SESSION["loggedUser"]);

        // Senha alterada com sucesso, redirecionar para a página do Perfil
        Store::Redirect("myaccount");
    }

    // Mostrar a tabela com o histório de compras do usuário logado
    public function historyUserOrders() {

        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(!Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

        $historyOrders = Orders::searchHistoryOrdersFromLoggedUser($_SESSION["loggedUser"]);
        $data["historyOrders"] = $historyOrders;

        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/profile/profileNavigation",
            "pages/profile/historyOrdersUserLogged",
            "partials/bottom",
            "partials/footer"
        ], $data);

    }

    // Mostrar os detalhes de uma compra realizada pelo usuário logado
    public function detailsOrder() {
        
        // Verificar se existe um usuário logado, se existir redirecionar para a página home.
        if(!Store::LoggedUser()) {
            Store::Redirect("home");
            exit;
        }

        // Verificar se não existe um parâmetro na url chamado id, caso não exista redirecionamos para o inicio
        if(!isset($_GET["id"])) {
            Store::Redirect("home");
            exit;
        }

        $id = null;

        // Verificar se a contagem de caracteres é diferente de 32, caso seja diferente redirecionamos para o inicio
        if(strlen($_GET["id"]) != 32) {
            Store::Redirect("home");
            exit;
        } else {
            $id = Store::aesDescrypt($_GET["id"]);

            if(empty($id)) {
                Store::Redirect("home");
                exit;   
            }
        }

        // Verificar se a compra pertence ao usuário logado
        $result = Orders::verifyOrderLoggedUser($_SESSION["loggedUser"], $id);
        if(!$result) {
            Store::Redirect("home");
            exit;
        }

        // Buscando dados da encomenda para mostrar os detalhes
        $detailOrder = Orders::detailsOrder($_SESSION["loggedUser"], $id);

        // Calculando o total da encomenda
        $totalPurchase = 0;
        foreach($detailOrder["productsOrder"] as $product) {
            $totalPurchase += ($product->quantity * $product->price_unit);
        }

        $data = [ 
            "detailOrder" => $detailOrder["dataOrder"],
            "productsOrder" => $detailOrder["productsOrder"],
            "totalPurchase" => $totalPurchase
        ];

        // Apresentação da view dos detalhes
        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/profile/profileNavigation",
            "pages/profile/detailsOrder",
            "partials/bottom",
            "partials/footer"
        ], $data);

    }

}