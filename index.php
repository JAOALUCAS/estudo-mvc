<?php

require __DIR__ . "/includes/app.php";

use \App\Http\Router;

// Inicia o Router
$obRouter = new Router(URL);

// Inclui as rotas de página
include __DIR__ . "/routes/pages.php";

// Inclui as rotas do painel
include __DIR__ . "/routes/admin.php";

// Inclui as rotas da api
include __DIR__ . "/routes/api.php";

// Imprime o response da rota
$obRouter->run()->sendResponse();
