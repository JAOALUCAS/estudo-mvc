<?php

use \App\Http\Response;
use \App\Controllers\Admin;

// Rota de listagem de todos os depoimentos 
$obRouter->get("/admin/testimonies", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request){
        return new Response(200, Admin\Testimony::getTestimonies($request));
    }
]);
