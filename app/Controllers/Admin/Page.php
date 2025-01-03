<?php

namespace App\Controllers\Admin;

use App\Utils\View;

class Page{

    

    /**
     * Método responsável por retornar o conteúdo (view) da estrutura génerica  da página do painel 
     * @param string $tittle
     * @param string $content
     * @return string
     */

    public static function getPage($title, $content)
    {

        return View::render("admin/page", [
            "title" => $title,
            "content" => $content
        ]);

    }

}