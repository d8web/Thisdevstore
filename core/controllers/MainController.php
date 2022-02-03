<?php

namespace core\controllers;

use core\classes\Store;

class MainController {

    // ============================================================
    public function index() {

        $data = [
            "clients" => ["Daniel", "Andressa", "André", "Juliana"]
        ];

        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/home",
            "partials/bottom",
            "partials/footer"
        ], $data);
    }

}