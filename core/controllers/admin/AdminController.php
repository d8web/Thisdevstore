<?php

namespace core\controllers\admin;
use core\classes\Store;
use core\handlers\Admin;
use core\handlers\AdminClients;

class AdminController {

    public function __construct() {
        // Verificar se existe um admin logado
        if(!Store::LoggedAdmin()) {
            Store::Redirect("signInAdmin", true);
            exit;
        }
    }

    public function index() {
        
        $data = [
            "totalPendingOrders" =>  Admin::getTotalOrdersPending(),
            "totalProcessingOrders" => Admin::getTotalOrdersProcessing()
        ];

        // Aprensentar a página de admin
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/home",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);

    }

    public function ordersList() {

        $filters = [
            "pending" => "PENDING",
            "processing" => "PROCESSING",
            "canceled" => "CANCELED",
            "send" => "SEND",
            "concluded" => "CONCLUDED"
        ];

        $filter = "";
        if(isset($_GET["filter"])) {

            // Verificar se a variável vinda da query string existe no array de filtros permitidos
            if(key_exists($_GET["filter"], $filters)) {
                $filter = $filters[$_GET["filter"]];
            }
        }

        $data = [
            "listSales" => Admin::getListOrders($filter),
            "filter" => $filter
        ];

        // Aprensentar a página de admin
        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/orders",
            "admin/partials/bottom",
            "admin/partials/footer"
        ], $data);

    }

    public function users() {

        $data = [ 
            "clients" => AdminClients::getListClients()
        ];

        Store::RenderAdmin([
            "admin/partials/header",
            "admin/partials/navbar",
            "admin/pages/clients",
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
            "detailsClient" => AdminClients::searchClientById($clientId)
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

}