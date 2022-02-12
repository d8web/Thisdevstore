<?php

define("APP_NAME",          "DEV STORE");
define("APP_VERSION",       "1.0.0");
define("BASE_URL",          "http://localhost/store/public/");

// MYSQL DADOS
define("MYSQL_SERVER",      "localhost");
define("MYSQL_DATABASE",    "store");
define("MYSQL_USER",        "root");
define("MYSQL_PASS",        "");
define("MYSQL_CHARSET",     "utf8");

// AES ENCRIPTAÇÃO
define("AES_KEY",           "muf4YDYMw3KeNv7rFkLFRJhkRwapBDVF");
define("AES_IV",            "NjWA3sg3vyk6yVk2");

// Status order
define("STATUS", ["PENDING", "PROCESSING", "SEND", "CANCELED", "CONCLUDED"]);

// PDF
define("PDF_PATH",          "C:/xampp/htdocs/store/pdfs/");