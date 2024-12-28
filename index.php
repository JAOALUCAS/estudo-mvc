<?php

require __DIR__  . "/vendor/autoload.php";

use \App\Http\Router;
use \App\Utils\View;

define("URL", "https:/localhost/mvc");


// Define o valor padrão das váriaveis
View::init([
    "URL" => URL
]);


// Inicia o Router
$obRouter = new Router(URL);

// Inclui as rotas de página
include __DIR__ . "/routes/Pages.php";

// Imprime o response da rota
$obRouter->run()->sendResponse();
