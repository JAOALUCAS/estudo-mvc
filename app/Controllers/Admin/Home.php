<?php

namespace App\Controllers\Admin;

use App\Utils\View;

class Home extends Page{

    /**
     * Método responsável por renderizar view da página home do painel
     * @param Request $request
     * @return string
     */

     public static function getHome($request)
     {

        // Conteúdo da home
        $content = View::render("admin/modules/home/index", []);
 
        return parent::getPainel("Home - Painel", $content, "home");

     }
 

}