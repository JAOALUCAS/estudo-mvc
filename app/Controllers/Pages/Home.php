<?php

namespace App\Controllers\Pages;

use \App\Utils\View;
use \App\Models\Entity\Organization;

class Home extends Page{

    /**
     * Método responsável por retornar o contéudo [view] da nossa home
     *  @return string
     */

    public static function getHome()
    {
        //Organização
        $obOrganization = new Organization;

        //View da Home
        $content =  View::render("pages/home", [
            "name" => $obOrganization->name,
            "description" => $obOrganization->description,
            "site" => $obOrganization->site
        ]);

        //Retorna a view da página
        return parent::getPage("Site - Home", $content);
    }

}