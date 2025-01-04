<?php

namespace App\Controllers\Admin;

use App\Utils\View;

class Testimony extends Page{

    /**
     * Método responsável por renderizar view de listagem de depoimentos do painel
     * @param Request $request
     * @return string
     */

     public static function getTestimonies($request)
     {

        // Conteúdo da home
        $content = View::render("admin/modules/testimonies/index", []);
 
        return parent::getPainel("Home - Painel", $content, "testimonies");

     }
 

}