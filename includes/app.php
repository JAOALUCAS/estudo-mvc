<?php

require __DIR__  . "/../vendor/autoload.php";

use \App\Utils\View;
use \App\Common\Enviroment;

Enviroment::load(__DIR__ . "/../");

// Define a constante de Url do projeto
define("URL", getenv("URL"));

// Define as configurações do banco de dados
Database::config(
    getenv("DB_HOST"),
    getenv("DB_NAME"),
    getenv("DB_USER"),
    getenv("DB_PASS"),
    getenv("DB_PORT")
);

// Define o valor padrão das váriaveis
View::init([
    "URL" => URL
]);