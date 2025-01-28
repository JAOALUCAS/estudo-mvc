<?php

namespace App\Controllers\Api;

use \App\Models\Entity\Testimony as EntityTestimony;
use \App\Db\Pagination;
use Exception;

class Testimony extends Api{

    /**
     * Método responsável por retornar a renderização dos itens de uma página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    
    private static function getTestimonyItens($request, &$obPagination)
    {
        // Depoimentos
        $itens = [];
    
        // Quantidade total de registros
        $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;
    
        // Página atual
        $queryParams = $request->getQuerryParams(); 
    
        $paginaAtual = $queryParams["page"] ?? 1;
    
        // Instancia de paginação 
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);
    
        // Resultados da página 
        $results = EntityTestimony::getTestimonies(null, "id DESC", $obPagination->getLimit());
    
        // Renderiza o item
        while($obTestimony = $results->fetchObject(EntityTestimony::class)){
            $itens[] = [
            "id" => (int)$obTestimony->id,
            "nome" => $obTestimony->nome,
            "mensagem" => $obTestimony->mensagem,
            "data" => $obTestimony->data
            ];
        }

        // Retorna os depoimentos 
        return $itens;
    }

    /**
     * Método responsávelo por retornar os depoimentos cadastrados
     * @param Request $request
     * @return array
     */

    public static function getTestimonies($request)
    {

        return [
            "depoimento" => self::getTestimonyItens($request, $obPagination), 
            "paginacao" => parent::getPagination($request, $obPagination)
        ];

    }

    /**
     * Método responsável por buscar os detalhes do depoimento
     * @param Request $request
     * @param integer $id
     * @return array
     */

    public static function getTestimony($request, $id)
    {

        // Valida  o id do depoimento
        if(!is_numeric($id)){

            throw new Exception("O id '".$id."' não é válido", 400);

        }

        // Busca o depoimento
        $obTestimony = EntityTestimony::getTestimonyById($id);

        // Valida se existe
        if(!$obTestimony instanceof EntityTestimony){

            throw new Exception("O depoimento ".$id." não foi encontrado", 404);

        }

        // Retorna os depoimentos
        return [
            "id" => (int)$obTestimony->id,
            "nome" => $obTestimony->nome,
            "mensagem" => $obTestimony->mensagem,
            "data" => $obTestimony->data
        ];

    }

    /**
     * Método responsável por cadastrar um novo depoimento
     * @param Request $request
     */

    public static function setNewTestimony($request)
    {

        // Post vars
        $postVars = $request->getPostVars();

        // Valida os campos obrigatórios
        if(!isset($postVars["nome"]) or !isset($postVars["mensagem"])){

            throw new Exception("Os campos 'nome' e 'mensagem' são obrigatórios", 400);

        }

        // Novo depoimento
        $obTestimony = new EntityTestimony;

        $obTestimony->nome = $postVars["nome"];

        $obTestimony->mensagem = $postVars["mensagem"];

        $obTestimony->cadastrar();

        // Retorna os detalhes do depoimento cadastrado
        return [
            "id" => (int)$obTestimony->id,
            "nome" => $obTestimony->nome,
            "mensagem" => $obTestimony->mensagem,
            "data" => $obTestimony->data
        ];
        
    }

    /**
     * Método responsável por editar um depoimento
     * @param Request $request
     */

     public static function setEditTestimony($request, $id)
     {
 
         // Post vars
         $postVars = $request->getPostVars();
 
         // Valida os campos obrigatórios
         if(!isset($postVars["nome"]) or !isset($postVars["mensagem"])){
 
             throw new Exception("Os campos 'nome' e 'mensagem' são obrigatórios", 400);
 
         }

         // Busca o depoimento 
         $obTestimony = EntityTestimony::getTestimonyById($id);

         // Valida a instancia
         if(!$obTestimony instanceof EntityTestimony){

            throw new Exception("O depoimento ".$id." não foi encontrado", 404);

         }

         // Atualiza o depoimento
         $obTestimony->nome = $postVars["nome"];
 
         $obTestimony->mensagem = $postVars["mensagem"];
 
         $obTestimony->atualizar();
 
         // Retorna os detalhes do depoimento atualizado
         return [
             "id" => (int)$obTestimony->id,
             "nome" => $obTestimony->nome,
             "mensagem" => $obTestimony->mensagem,
             "data" => $obTestimony->data
         ];
         
     }
 
    /**
     * Método responsável por excluir um depoimento
     * @param Request $request
     */

    public static function setDeleteTestimony($request, $id)
    {

        // Busca o depoimento 
        $obTestimony = EntityTestimony::getTestimonyById($id);

        // Valida a instancia
        if(!$obTestimony instanceof EntityTestimony){

        throw new Exception("O depoimento ".$id." não foi encontrado", 404);

        }

        // Exclui depoimento
        $obTestimony->excluir();
        
        // Retorna o sucesso da exclusão
        return [
            "sucesso" => true
        ];
         
    }
 

}