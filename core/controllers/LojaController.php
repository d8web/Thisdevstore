<?php

namespace core\controllers;
use core\classes\Store;

class LojaController
{
    public function index()
    {
        Store::Render([
            "partials/header",
            "partials/navbar",
            "pages/store",
            "partials/bottom",
            "partials/footer"
        ]);
    }
}