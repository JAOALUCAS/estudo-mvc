<?php

namespace App\Controllers\Pages;

use \App\Utils\View;
use \App\Models\Entity\Testimony as EntityTestimony;
use \App\Db\Pagination;

class Testimony extends Page{


    /**
     * Método responsável por retornar a renderização dos itens de uma página
     * @param Request $request
     * @return string
     */

    private function getTestimonyItens($request)
    {

        // Depoimentos
        $itens = "";

        // Quantidade total de registro
        $quantidadeTotal = EntityTestimony::getTestimonies(null , null, null , "COUNT(*) as qtd")->fetchObject()->qtd;

        // Página atual
        $querryParams = $request->getQuerryParams();

        $paginaAtual = $querryParams["page"] ?? 1;

        // Instancia de paginação 
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 1);

        // Resultados da página 
        $results = EntityTestimony::getTestimonies(null , "id DESC", $obPagination->getLimit());

        // Renderiza o item
        while($obTestimony = $results->fetchObject(EntityTestimony::class))
        {

            $itens .=  View::render("pages/testimony/item", [
                "nome" => $obTestimony->nome,
                "mensagem" => $obTestimony->mensagem,
                "data" => date("d/m/Y H:i:s", strtotime($obTestimony->data))
            ]);

        }

        // Retorna os depoimentos 
        return $itens;

    }

    /**
     * Método responsável por retornar o contéudo [view] de depoimentos
     *  @param Request $request
     *  @return string
     */

    public static function getTestimonies($request)
    {

        //View de depoimentos
        $content =  View::render("pages/testimonies", [
            "itens" => self::getTestimonyItens($request)
        ]);

        //Retorna a view da página
        return parent::getPage("Site - Depoimento", $content);
        
    }

    /**
     * Método responsável por cadastrar um depoimento
     * @param Request $request
     * @return string
     */

    public static function insertTestimony($request)
    {

        // Dados do post
        $postVars = $request->getPostVars();

        // Nova instancia de depoimento
        $obTestimony = new EntityTestimony;

        $obTestimony->nome = $postVars["nome"];

        $obTestimony->mensagem = $postVars["mensagem"];

        $obTestimony->cadastrar();

        // Retorna a página de listagem de depoimentos
        return self::getTestimonies($request);

    }

}