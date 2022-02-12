<?php

namespace core\controllers\admin;

use core\classes\Store;
use core\handlers\AdminClients;
use core\handlers\AdminOrders;

class UserController {

    public function __construct() {
        // Verificar se existe um admin logado
        if(!Store::LoggedAdmin()) {
            Store::Redirect("signInAdmin", true);
            exit;
        }
    }

    public function users() {

        $data = [ 
            "clients" => AdminClients::getListClients()
        ];

        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/users",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);
    }

    public function detailsUser() {

        // Verifica se o id do usuario foi passado pela query string
        if(!isset($_GET["user"])) {
            Store::Redirect("home", true);
            exit;
        }

        $clientId = Store::aesDescrypt($_GET["user"]);

        // Verificar se o id do usuário está vazio, caso esteja redirecionamos para a home
        if(empty($clientId)) {
            Store::Redirect("home", true);
            exit;
        }

        $data = [ 
            "detailsClient" => AdminClients::searchClientById($clientId),
            "totalOrdersClient" => AdminOrders::searchOrdersClient($clientId)
        ];

        // Página de detalhes do usuário
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/detailsUser",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);
    }

    public function userHistoryOrder() {

        // Verifica se o id do usuario foi passado pela query string
        if(!isset($_GET["user"])) {
            Store::Redirect("home", true);
            exit;
        }

        $clientId = Store::aesDescrypt($_GET["user"]);

        // Verificar se o id do usuário está vazio, caso esteja redirecionamos para a home
        if(empty($clientId)) {
            Store::Redirect("home", true);
            exit;
        }

        // Pegando as compras do usuário
        $data = [
            "ordersUser" => AdminOrders::searchOrdersUserById($clientId),
            "user" => AdminClients::searchClientById($clientId)
        ];
        
        // Página de detalhes do usuário
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/ordersUser",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);

    }

}