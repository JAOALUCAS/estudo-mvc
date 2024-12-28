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

// Rota dinâmica
$obRouter->get("/pagina/{idPagina}/{acao}", [
    function ($idPagina, $acao){
        return new Response(200, "Página" . $idPagina . " - " . $acao);
    }

]);

