<?php

use \App\Http\Response;
use \App\Controllers\Pages;

// Rota de home
$obRouter->get("/", [
    function (){
        return new Response(200, Pages\Home::getHome());
    }

]);

// Rota de sobre
$obRouter->get("/sobre", [
    function (){
        return new Response(200, Pages\About::getAbout());
    }

]);

// Rota de depoimentos
$obRouter->get("/depoimentos", [
    function ($request){
        return new Response(200, Pages\Testimony::getTestimonies($request));
    }

]);


// Rota de depoimentos (INSERT)
$obRouter->post("/depoimentos", [
    function ($request){
        return new Response(200, Pages\Testimony::insertTestimony($request));
    }

]);