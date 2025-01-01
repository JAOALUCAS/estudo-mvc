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
     * Método responsável por renderizar o layout de paginação
     * @param Request $request
     * @param Pagination $obPagination
     * @return void
     */
    public static function getPagination($request, $obPagination)
    {

        // Páginas
        $pages = $obPagination->getPages();

        // Verifica a quantidade de páginas
        if(count($pages) <= 1) return "";

        // Links
        $links = "";

        // Url atual (sem gets)
        $url = $request->getRouter()->getCurrentUrl(); 

        // GET
        $querryParams = $request->getQuerryParams();
        
        // Renderiza os links 
        foreach($pages as $page)
        {

            // Altera a página
            $querryParams["page"] = $page["page"];

            // Link
            $link = $url . "?" . http_build_query($querryParams);

            // View
            $links .= View::render("pages/pagination/link", [
                "page"=> $page["page"],
                "link" => $link,
                "active" => $page["current"] ? "active" : ""
            ]);

        }

        // Renderiza a box de paginação
        return View::render("pages/pagination/box", [
            "links" => $links
        ]);

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