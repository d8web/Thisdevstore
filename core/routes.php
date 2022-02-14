<?php

// Array de rotas
$routes = [
    "home" => "mainController@index",
    "loja" => "lojaController@index",

    // Cadastro
    "signup" => "userController@newUser",
    "signupAction" => "userController@newUserAction",
    "confirmEmail" => "userController@confirmEmail",

    // Perfil
    "myaccount" => "userController@myaccount",
    "alterUserData" => "userController@alterUserData",
    "alterUserDataSubmit" => "userController@alterUserDataSubmit",
    "alterUserPassword" => "userController@alterUserPassword",
    "alterUserPasswordSubmit" => "userController@alterUserPasswordSubmit",

    // Histórico de compras do usuário
    "historyUserOrders" => "userController@historyUserOrders",
    "detailsOrder" => "userController@detailsOrder",

    // Altenticação
    "signin" => "authController@signIn",
    "signinAction" => "authController@signinAction",
    "logout" => "authController@logout",

    // Carrinho
    "cart" => "cartController@index",
    "addToCart" => "cartController@addToCart",
    "clearCart" => "cartController@clearCart",
    "removeProductCart" => "cartController@removeProductCart",

    // Compras
    "checkout" => "orderController@checkout",
    "resumeCheckout" => "orderController@resumeCheckout",
    "addressAlternative" => "orderController@addressAlternative",
    "confirmOrder" => "orderController@confirmOrder",
    "checkoutConfirmed" => "orderController@checkoutConfirmed",

    // Pagamentos [simulação]
    "payment" => "paymentController@payment",
    "paymentStripeRequest" => "paymentController@paymentStripeRequest"
];

// Action padrão
$action = "home";

// Verificar se existe uma action na query string
if(isset($_GET["a"])) {
    // Verificar se existe a action no array de rotas
    if(!key_exists($_GET["a"], $routes)) {
        $action = "home";
    } else {
        $action = $_GET["a"];
    }
}

// Definindo as rotas
$parts = explode("@", $routes[$action]);
$controller = "core\\controllers\\".ucfirst($parts[0]);
$method = $parts[1];

$ctr = new $controller();
$ctr->$method();