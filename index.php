<?php

require __DIR__  . "/vendor/autoload.php";

use \App\Controllers\Pages\Home;
use \App\Http\Router;
use \App\Http\Response;

define("URL", "https:/localhost/mvc");

$obRouter = new Router(URL);

//Rota de home
$obRouter->get("/", [
    function (){
        return new Response(200, Home::getHome());
    }
]);
