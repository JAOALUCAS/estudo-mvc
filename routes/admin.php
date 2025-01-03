<?php

use \App\Http\Response;
use \App\Controllers\Admin;

// Rota admin
$obRouter->get("/admin", [
    "middlewares" => [
        "require-admin-login"
    ],
    function (){
        return new Response(200, "Admin");
    }
]);

// Rota login
$obRouter->get("/admin/login", [
    "middlewares" => [
        "require-admin-logout"
    ],
    function ($request){
        return new Response(200, Admin\Login::getLogin($request));
    }
]);

// Rota login (post)
$obRouter->post("/admin/login", [
    "middlewares" => [
        "require-admin-logout"
    ],
    function ($request){
        return new Response(200, Admin\Login::setLogin($request));
    }
]);

// Rota logout
$obRouter->get("/admin/logout", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request){
        return new Response(200, Admin\Login::setLogout($request));
    }
]);
