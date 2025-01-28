<?php

use \App\Http\Response;
use \App\Controllers\Api;

// Rota de listagem de usuários
$obRouter->get("/api/v1/users", [
    "middlewares" => [
        "api",
        "user-basic-auth"
    ],
    function($request){
        return new Response(200, Api\User::getUsers($request), "application/json");
    }
]);


// Rota de individual de usuário
$obRouter->get("/api/v1/users/{id}", [
    "middlewares" => [
        "api",
        "user-basic-auth"
    ],
    function($request,$id){
        return new Response(200, Api\User::getUser($request,$id), "application/json");
    }
]);

// Rota de cadastro de usuário
$obRouter->post("/api/v1/users", [
    "middlewares" => [
        "api", 
        "user-basic-auth"
    ],
    function($request){
        return new Response(201, Api\User::setNewUser($request), "application/json");
    }
]);

// Rota de atualização de usuário
$obRouter->put("/api/v1/users/{id}", [
    "middlewares" => [
        "api", 
        "user-basic-auth"
    ],
    function($request, $id){
        return new Response(200, Api\User::setEditUser($request, $id), "application/json");
    }
]);

// Rota para exclusão de um usuário
$obRouter->delete("/api/v1/users/{id}", [
    "middlewares" => [
        "api", 
        "user-basic-auth"
    ],
    function($request, $id){
        return new Response(200, Api\User::setDeleteUser($request, $id), "application/json");
    }
]);