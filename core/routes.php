<?php

// Array de rotas
$routes = [
    "home" => "mainController@index",
    "loja" => "lojaController@index",

    // User rotas
    "signup" => "userController@newUser",
    "signupAction" => "userController@newUserAction",
    "confirmEmail" => "userController@confirmEmail",

    // Login
    "signin" => "authController@signIn",

    "cart" => "cartController@index",
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