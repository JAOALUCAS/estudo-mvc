<?php

namespace App\Controllers\Pages;

use \App\Utils\View;

class Page{

    /**
     * Método responsável por retornar o topo da página
     *  @return string
     */

    private static function getHeader()
    {
        return View::render("pages/header");
    }

    /**
     * Método responsável por retornar o final da página
     *  @return string
     */


    private static function getFooter()
    {
        return View::render("pages/footer");
    }


    /**
     * Método responsável por retornar o contéudo [view] da nossa página genérica
     *  @return string
     */

    public static function getPage($title, $content)
    {
        return View::render("pages/page", [
            "title"=> $title,
            "header" => self::getHeader(),
            "content" => $content,
            "footer" => self::getFooter(),
        ]);
    }

}