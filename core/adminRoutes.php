<?php

// Array de rotas
$routes = [
    "home" => "adminController@index",

    // Gerar PDFS example
    "pdf" => "adminController@pdf",

    // Users
    "users" => "userController@users",
    "detailsUser" => "userController@detailsUser",
    "userHistoryOrder" => "userController@userHistoryOrder",

    // Orders
    "ordersList" => "orderController@ordersList",
    "detailsOrder" => "orderController@detailsOrder",
    "alterStatusOrder" => "orderController@alterStatusOrder",
    "createOrderPDF" => "orderController@createOrderPDF",
    "sendOrderPDF" => "orderController@sendOrderPDF",

    // Products
    "productsList" => "productsController@productsList",
    "newProduct" => "productsController@newProduct",
    "newProductSubmit" => "productsController@newProductSubmit",
    "editProduct" => "productsController@editProduct",
    "editProductSubmit" => "productsController@editProductSubmit",
    "deleteProduct" => "productsController@deleteProduct",

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