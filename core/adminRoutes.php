<?php

// Array de rotas
$routes = [
    "home" => "adminController@index",

    // Users
    "users" => "adminController@users",
    "detailsUser" => "adminController@detailsUser",
    "userHistoryOrder" => "adminController@userHistoryOrder",

    // Orders
    "ordersList" => "adminController@ordersList",
    "detailsOrder" => "adminController@detailsOrder",
    "alterStatusOrder" => "adminController@alterStatusOrder",

    // Login admin
    "signInAdmin" => "authController@signIn",
    "signInAdminAction" => "authController@signInAdminAction",
    "logoutAdmin" => "authController@logoutAdmin",
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
$controller = "core\\controllers\\admin\\".ucfirst($parts[0]);
$method = $parts[1];

$ctr = new $controller();
$ctr->$method();