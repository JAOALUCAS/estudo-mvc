<?php

require __DIR__ . "/includes/app.php";

use \App\Http\Router;

// Inicia o Router
$obRouter = new Router(URL);

// Inclui as rotas de página
include __DIR__ . "/routes/Pages.php";

// Imprime o response da rota
$obRouter->run()->sendResponse();
