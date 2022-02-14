<?php

namespace core\controllers;

use Error;
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

    public function paymentStripeRequest() {

        // This is your test secret API key.
        \Stripe\Stripe::setApiKey(STRIPE_KEY);

        function calculateOrderAmount(array $items): int {
            // Replace this constant with a calculation of the order's amount
            // Calculate the order total on the server to prevent
            // people from directly manipulating the amount on the client
            return intval($_SESSION["total"]."00");
        }

        header("Content-Type: application/json");

        try {
            // retrieve JSON from POST body
            $jsonStr = file_get_contents("php://input");
            $jsonObj = json_decode($jsonStr);

            // Create a PaymentIntent with amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                "amount" => calculateOrderAmount($jsonObj->items),
                "currency" => "brl",
                "automatic_payment_methods" => [
                    "enabled" => true,
                ],
            ]);

            $output = [
                "clientSecret" => $paymentIntent->client_secret,
            ];

            echo json_encode($output);
        } catch (Error $e) {
            http_response_code(500);
            echo json_encode(["error" => $e->getMessage()]);
        }

    }
}