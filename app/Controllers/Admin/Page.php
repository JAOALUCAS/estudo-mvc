<?php

namespace App\Controllers\Admin;

use App\Utils\View;

class Page{    

    /**
     * Módulos disponiveis no painel
     * @var array
     */
     
    private static $modules = [
        "home" => [
            "label" => "Home",
            "link" => URL."/admin"
        ],
        "testimonies" => [
            "label" => "Depoimentos",
            "link" => URL."/admin/testimonies"
        ],
        "users" => [
            "label" => "Usuários",
            "link" => URL."/admin/users"
        ]
    ];

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

    /**
     * Método responsável por renderizar a view  do painel com conteúdo dinâmicos
     * @param string $currentModule
     * @return string
     */

    private static function getMenu($currentModule)
    {

        // Links do menu
        $links = "";

        // Itera os módulos
        foreach(self::$modules as $hash=>$module)
        {

            $links .= View::render("admin/menu/link", [
                "label" => $module["label"],
                "link" => $module["link"],
                "current" => $hash == $currentModule ? "text-danger" : ""
            ]);

        }

        // Retorna a renderização do menu
        return View::render("admin/menu/box", [
            "links" => $links
        ]);

    }

    /**
     * Método responsável por renderizar a view do painel com conteúdos dinâmicos
     * @param string $title
     * @param string $content
     * @param string $currentModule
     * @return string
     */

    public static function getPainel($title, $content, $currentModule)
    {

        // Renderiza a view do painel
        $contentPanel = View::render("admin/panel", [
            "menu" => self::getMenu($currentModule),
            "content" => $content
        ]);

        // Retorna a página renderizada
        return self::getPage($title, $contentPanel);

    }

}