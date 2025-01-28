<?php

namespace App\Controllers\Api;

class Api{

    /**
     * Método responsávelo por retornar os detalhes da api
     * @param Request $request
     * @return array
     */

    public static function getDetails($request)
    {

        return [
            "nome" => "Api - Jl",
            "versao" => "v1.0.0",
            "autor" => "João",
            "email" => "joao.lucast02@gmail.com"
        ];

    }

    /**
     * Método responsável por retornar os detalhes da paginação
     * @param Request $request
     * @param Pagination $obPagination
     * @return array
     */

    protected static function getPagination($request, $obPagination)
    {

        // Querry Params
        $querryParams = $request->getQuerryParams();

        // Página
        $pages = $obPagination->getPages();

        // Retorno
        return [
            "paginaAtual" => isset($querryParams["page"]) ? (int)$querryParams["page"] : 1,
            "quantidadePaginas" => !empty($pages) ? count($pages) : 1
        ];

    }

}