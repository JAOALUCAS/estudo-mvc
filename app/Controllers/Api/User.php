<?php

namespace App\Controllers\Api;

use \App\Models\Entity\User as EntityUser;
use \App\Db\Pagination;
use Exception;

class User extends Api{

    /**
     * Método responsável por retornar a renderização dos itens de uma página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */
    
    private static function getUserItens($request, &$obPagination)
    {
        // Depoimentos
        $itens = [];
    
        // Quantidade total de registros
        $quantidadeTotal = EntityUser::getUsers(null, null, null, "COUNT(*) as qtd")->fetchObject()->qtd;
    
        // Página atual
        $queryParams = $request->getQuerryParams(); 
    
        $paginaAtual = $queryParams["page"] ?? 1;
    
        // Instancia de paginação 
        $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 3);
    
        // Resultados da página 
        $results = EntityUser::getUsers(null, "id DESC", $obPagination->getLimit());
    
        // Renderiza o item
        while($obUser = $results->fetchObject(EntityUser::class)){
            $itens[] = [
            "id" => (int)$obUser->id,
            "nome" => $obUser->nome,
            "email" => $obUser->email
            ];
        }

        // Retorna os usuários 
        return $itens;
    }

    /**
     * Método responsávelo por retornar os usuários cadastrados
     * @param Request $request
     * @return array
     */

    public static function getUsers($request)
    {

        return [
            "usuário" => self::getUserItens($request, $obPagination), 
            "paginacao" => parent::getPagination($request, $obPagination)
        ];

    }

    /**
     * Método responsável por buscar os detalhes do usuário
     * @param Request $request
     * @param integer $id
     * @return array
     */

    public static function getUser($request, $id)
    {

        // Valida  o id do usuário
        if(!is_numeric($id)){

            throw new Exception("O id '".$id."' não é válido", 400);

        }

        // Busca o usuário
        $obUser = EntityUser::getUserById($id);

        // Valida se existe
        if(!$obUser instanceof EntityUser){

            throw new Exception("O usuário ".$id." não foi encontrado", 404);

        }

        // Retorna os usuário
        return [
            "id" => (int)$obUser->id,
            "nome" => $obUser->nome,
            "email" => $obUser->email
        ];

    }

    /**
     * Método responsável por cadastrar um novo usuário
     * @param Request $request
     */

    public static function setNewUser($request)
    {

        // Post vars
        $postVars = $request->getPostVars();

        // Valida os campos obrigatórios
        if(!isset($postVars["nome"]) or !isset($postVars["email"]) or !isset($postVars["senha"])){

            throw new Exception("Os campos 'nome' , 'email' e 'senha' são obrigatórios", 400);

        }

        // Valida a duplicação de email do usuário
        $obUserEmail = EntityUser::getUserByEmail($postVars["email"]);

        if($obUserEmail instanceof EntityUser){
                
            throw new Exception("O email '".$postVars."' já está em uso.", 400);

        }

        // Novo usuário
        $obUser = new EntityUser;

        $obUser->nome = $postVars["nome"];

        $obUser->email = $postVars["email"];
        
        $obUser->senha = password_hash($postVars["senha"], PASSWORD_DEFAULT);

        $obUser->cadastrar();

        // Retorna os detalhes do usuário cadastrado
        return [
            "id" => (int)$obUser->id,
            "nome" => $obUser->nome,
            "email" => $obUser->email
        ];  
        
    }

    /**
     * Método responsável por editar um usuário
     * @param Request $request
     */

     public static function setEditUser($request, $id)
     {
 
        // Post vars
        $postVars = $request->getPostVars();

        // Valida os campos obrigatórios
        if(!isset($postVars["nome"]) or !isset($postVars["email"]) or !isset($postVars["senha"])){

            throw new Exception("Os campos 'nome' , 'email' e 'senha' são obrigatórios", 400);

        }

        // Valida  o id do usuário
        if(!is_numeric($id)){

            throw new Exception("O id '".$id."' não é válido", 400);

        }

        // Busca o usuário
        $obUser = EntityUser::getUserById($id);

        // Valida se existe
        if(!$obUser instanceof EntityUser){

            throw new Exception("O usuário ".$id." não foi encontrado", 404);

        }

        // Valida a duplicação de email do usuário
        $obUserEmail = EntityUser::getUserByEmail($postVars["email"]);

        if($obUserEmail instanceof EntityUser && $obUserEmail->id != $obUser->id){
                
            throw new Exception("O email '".$postVars."' já está em uso.", 400);

        }

        // Atualiza usuário
        $obUser->nome = $postVars["nome"];

        $obUser->email = $postVars["email"];
        
        $obUser->senha = password_hash($postVars["senha"], PASSWORD_DEFAULT);

        $obUser->atualizar();

        // Retorna os detalhes do usuário
        return [
            "id" => (int)$obUser->id,
            "nome" => $obUser->nome,
            "email" => $obUser->email
        ];  
         
     }
 
    /**
     * Método responsável por excluir um usuário
     * @param Request $request
     */

    public static function setDeleteUser($request, $id)
    {

       // Busca o usuário
       $obUser = EntityUser::getUserById($id);

       // Valida se existe
       if(!$obUser instanceof EntityUser){

            throw new Exception("O usuário ".$id." não foi encontrado", 404);

       }

       // Impede a exclusão do própio usuário
       if($obUser->id == $request->user->id){

            throw new Exception("Não é possivel excluir o usuário atualmente conectado", 400);

       }

        // Exclui usuário
        $obUser->excluir();
        
        // Retorna o sucesso da exclusão
        return [
            "sucesso" => true
        ];
         
    }
 

}