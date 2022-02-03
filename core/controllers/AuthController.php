<?php

namespace core\controllers;

use core\classes\Store;

class AuthController {

    public function signIn() {
        // Mostrar o formulário de login
        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/signin",
            "partials/bottom",
            "partials/footer"
        ]);
    }

}