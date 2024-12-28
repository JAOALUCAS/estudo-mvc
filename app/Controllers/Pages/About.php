<?php

namespace App\Controllers\Pages;

use \App\Utils\View;
use \App\Models\Entity\Organization;

class About extends Page{

    /**
     * Método responsável por retornar o contéudo [view] do nosso sobre
     *  @return string
     */

    public static function getAbout()
    {
        //Organização
        $obOrganization = new Organization;

        //View do sobre
        $content =  View::render("pages/about", [
            "name" => $obOrganization->name,
            "description" => $obOrganization->description,
            "site" => $obOrganization->site
        ]);

        //Retorna a view da página
        return parent::getPage("Site - Sobre", $content);
        
    }

}