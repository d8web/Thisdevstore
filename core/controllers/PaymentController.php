<?php
namespace core\controllers;

use core\handlers\Orders;

class PaymentController {

    public function payment() {

        // Verificar se o código da compra veio na query string
        $codeOrder = "";
        if(!isset($_GET["codeOrder"])) {
            return;
        } else {
            $codeOrder = $_GET["codeOrder"];
        }

        $resultOrder = Orders::makePayment($codeOrder);
        echo (int)$resultOrder;

    }

}