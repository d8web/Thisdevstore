<?php

namespace core\controllers;
use core\classes\Store;

class CartController {

    public function index() {
        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/cart",
            "partials/bottom",
            "partials/footer"
        ]);
    }
    
}