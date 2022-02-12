<?php

namespace core\controllers\admin;

use core\classes\SendEmail;
use core\classes\Store;
use core\classes\PDF;

use core\handlers\Admin;
use core\handlers\AdminClients;
use core\handlers\AdminOrders;

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

    public function pdf() {
        
        // die(getcwd());
        $pdf = new PDF();
        // Definindo o template do pdf
        $pdf->setTemplate(getcwd()."/assets/templates/example.pdf");

        $pdf->setFontFamily("Courier New");
        $pdf->setFontSize("2em");
        $pdf->setFontWeight("bold");

        $pdf->setColor("#333");
        $pdf->setBackground("#fff");
        $pdf->setAlignText("center");
        
        $pdf->positionAndDimension(98, 300, 596, 28);
        $pdf->writePDF("Primeira frase de teste");

        $pdf->presentPDF();
    }

}