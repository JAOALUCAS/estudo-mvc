<?php

use \App\Http\Response;
use \App\Controllers\Admin;

// Rota admin
$obRouter->get("/admin", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request){
        return new Response(200, Admin\Home::getHome($request));
    }
]);
