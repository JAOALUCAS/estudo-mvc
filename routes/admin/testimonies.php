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

// Rota de cadastro de um novo depoimeto
$obRouter->get("/admin/testimonies/new", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request){
        return new Response(200, Admin\Testimony::getNewTestimony($request));
    }
]);

// Rota de cadastro de um novo depoimeto (post)
$obRouter->post("/admin/testimonies/new", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request){
        return new Response(200, Admin\Testimony::setNewTestimony($request));
    }
]);

// Rota de edição de um depoimento
$obRouter->get("/admin/testimonies/{id}/edit", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request, $id){
        return new Response(200, Admin\Testimony::getEditTestimony($request, $id));
    }
]);

// Rota de edição de um depoimento
$obRouter->post("/admin/testimonies/{id}/edit", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request, $id){
        return new Response(200, Admin\Testimony::setEditTestimony($request, $id));
    }
]);

// Rota de exclusão de um depoimento
$obRouter->get("/admin/testimonies/{id}/delete", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request, $id){
        return new Response(200, Admin\Testimony::getDeleteTestimony($request, $id));
    }
]);

// Rota de exclusão de um depoimento (post)
$obRouter->post("/admin/testimonies/{id}/delete", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request, $id){
        return new Response(200, Admin\Testimony::setDeleteTestimony($request, $id));
    }
]);