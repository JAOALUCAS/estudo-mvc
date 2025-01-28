<?php

use \App\Http\Response;
use \App\Controllers\Admin;

// Rota de listagem de todos os usuários 
$obRouter->get("/admin/users", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request){
        return new Response(200, Admin\User::getUsers($request));
    }
]);

// Rota de cadastro de um novo usuário
$obRouter->get("/admin/users/new", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request){
        return new Response(200, Admin\User::getNewUser($request));
    }
]);

// Rota de cadastro de um novo usuário (post)
$obRouter->post("/admin/users/new", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request){
        return new Response(200, Admin\User::setNewUser($request));
    }
]);

// Rota de edição de um usuário
$obRouter->get("/admin/users/{id}/edit", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request, $id){
        return new Response(200, Admin\User::getEditUser($request, $id));
    }
]);

// Rota de edição de um usuário (post)
$obRouter->post("/admin/users/{id}/edit", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request, $id){
        return new Response(200, Admin\User::setEditUser($request, $id));
    }
]);

// Rota de exclusão de um usuário
$obRouter->get("/admin/users/{id}/delete", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request, $id){
        return new Response(200, Admin\User::getDeleteUser($request, $id));
    }
]);

// Rota de exclusão de um usuário (post)
$obRouter->post("/admin/users/{id}/delete", [
    "middlewares" => [
        "require-admin-login"
    ],
    function ($request, $id){
        return new Response(200, Admin\User::setDeleteUser($request, $id));
    }
]);