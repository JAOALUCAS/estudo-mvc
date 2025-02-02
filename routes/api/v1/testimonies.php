<?php

use \App\Http\Response;
use \App\Controllers\Api;

// Rota de listagem de depoimentos
$obRouter->get("/api/v1/testimonies", [
    "middlewares" => [
        "api"
    ],
    function($request){
        return new Response(200, Api\Testimony::getTestimonies($request), "application/json");
    }
]);


// Rota de individual de depoimentos
$obRouter->get("/api/v1/testimonies/{id}", [
    "middlewares" => [
        "api"
    ],
    function($request,$id){
        return new Response(200, Api\Testimony::getTestimony($request,$id), "application/json");
    }
]);

// Rota de cadastro de depoimento
$obRouter->post("/api/v1/testimonies", [
    "middlewares" => [
        "api", 
        "user-basic-auth"
    ],
    function($request){
        return new Response(201, Api\Testimony::setNewTestimony($request), "application/json");
    }
]);

// Rota de atualização de depoimento
$obRouter->put("/api/v1/testimonies/{id}", [
    "middlewares" => [
        "api", 
        "user-basic-auth"
    ],
    function($request, $id){
        return new Response(200, Api\Testimony::setEditTestimony($request, $id), "application/json");
    }
]);

// Rota para exclusão de um depoimento
$obRouter->delete("/api/v1/testimonies/{id}", [
    "middlewares" => [
        "api", 
        "user-basic-auth"
    ],
    function($request, $id){
        return new Response(200, Api\Testimony::setDeleteTestimony($request, $id), "application/json");
    }
]);