<?php

namespace App\Controllers\Admin;

use \App\Utils\View;
use \App\Models\Entity\User as EntityUser;
use \App\Db\Pagination;

class User extends Page{

   /**
     * Método responsável por retornar a renderização dos itens de uma página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */

   private static function getUserItens($request, &$obPagination)
   {
      // Usuários
      $itens = "";
   
      // Quantidade total de registros
      $quantidadeTotal = EntityUser::getUsers(null, null, null, "COUNT(*) as qtd")[0]->qtd;
   
      // Página atual
      $queryParams = $request->getQuerryParams(); 
   
      $paginaAtual = $queryParams["page"] ?? 1;
   
      // Instancia de paginação 
      $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);
   
      // Resultados da página 
      $results = EntityUser::getUsers(null, "id DESC", $obPagination->getLimit());
   
       // Renderiza o item
       while($obUser = $results->fetchObject(EntityUser::class)){
         $itens .= View::render("admin/modules/users/item", [
            "id" => $obUser->id,
            "nome" => $obUser->nome,
            "email" => $obUser->email,
         ]);
      }
   
      // Retorna os depoimentos 
      return $itens;
   }

   /**
    * Método responsável por renderizar view de listagem de usuários
    * @param Request $request
    * @return string
    */

   public static function getUsers($request)
   {

      // Conteúdo dos depoimentos
      $content = View::render("admin/modules/users/index", [
         "itens" => self::getUserItens($request, $obPagination),
         "pagination" => parent::getPagination($request, $obPagination),
         "status" => self::getStatus($request)
      ]);

      return parent::getPainel("Usuários - Painel", $content, "users");

   }

   /**
   * Método responsável por retornar o formulário de cadastro de um novo usuário
   * @param Request $request
   * @return string
   */

   public static function getNewUser($request)
   {
      
      // Conteúdo do formulário
      $content = View::render("admin/modules/users/form", [
         "title" => "Cadastrar usuário",
         "nome" => "",
         "email" => "",
         "status" => self::getStatus($request)
      ]);

      return parent::getPainel("Cadastrar usuário - Painel", $content, "users");

   }

   /**
   * Método responsável por cadastrar um usuário no banco
   * @param Request $request
   * @return string
   */

   public static function setNewUser($request)
   {
         
      // Post vars
      $postVars = $request->getPostVars();

      $email = $postVars["email"] ?? "";
      
      $nome = $postVars["nome"] ?? "";

      $senha = $postVars["senha"] ?? "";

      // Valida o email do usuário
      $obUser = EntityUser::getUserByEmail($email);

      if($obUser instanceof EntityUser){
            
         // Redereciona o usuário
         $request->getRouter()->redirect("/admin/users/new?status=duplicated");

      }

      // Nova instancia usuário  
      $obUser = new EntityUser;

      $obUser->nome = $nome;

      $obUser->email = $email;

      $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);

      $obUser->cadastrar();

      // Redereciona o usuário
      $request->getRouter()->redirect("/admin/users/".$obUser->id."/edit?status=created");

   }
   /**
    * Método responsável por retornar a mensagem de status
    * @param Request $request
    * @return string
    */
   private static function getStatus($request)
   {

      // Query params
      $queryParams = $request->getQuerryParams();

      // Status
      if(!isset($queryParams["status"])) return "";

      // Mensagens de status
      switch($queryParams["status"]){
         case "create":
            return Alert::getSucess("Usuário criado com sucesso!");
            break;
         case "updated":
            return Alert::getSucess("Usuário atualizado com sucesso!");
            break;
         case "deleted":
            return Alert::getSucess("Usuário excluido com sucesso!");
            break;
         case "duplicated":
            return Alert::getError("O email digitado já está sendo utilizado por outro usuário.");
            break;
      }

   }
 
   /**
   * Método responsável por retornar o formulário de edição de um usuário
   * @param Request $request
   * @param integter $id
   * @return string
   */

   public static function getEditUser($request, $id)
   {

      // Obtém o usuário do banco de dados
      $obUser = EntityUser::getUserById($id);

      // Valida a instancia
      if(!$obUser instanceof EntityUser){

         $request->getRouter()->redirect("/admin/users");

      }
         
      // Conteúdo do formulário
      $content = View::render("admin/modules/users/form", [
         "title" => "Editar usuário",
         "nome" => $obUser->nome,
         "email" => $obUser->email,
         "status" => self::getStatus($request)
      ]);

      return parent::getPainel("Editar usuário - Painel", $content, "users");

   }
   
   /**
   * Método responsável por gravar a mudança do usuário
   * @param Request $request
   * @param integter $id
   * @return string
   */

   public static function setEditUser($request, $id)
   {

     // Obtém o usuário do banco de dados
     $obUser = EntityUser::getUserById($id);

     // Valida a instancia
     if(!$obUser instanceof EntityUser){

        $request->getRouter()->redirect("/admin/users");

     }
      
      // Post vars
      $postVars = $request->getPostVars();

      $email = $postVars["email"] ?? "";
      
      $nome = $postVars["nome"] ?? "";

      $senha = $postVars["senha"] ?? "";

      // Valida o email do usuário
      $obUserEmail = EntityUser::getUserByEmail($email);

      if($obUserEmail instanceof EntityUser && $obUserEmail->id != $id){
            
         // Redereciona o usuário
         $request->getRouter()->redirect("/admin/users/".$id."/edit?status=duplicated");

      }

      // Atualiza a instancia
      $obUser->nome = $nome;

      $obUser->email = $email;

      $obUser->senha = password_hash($senha, PASSWORD_DEFAULT);

      $obUser->atualizar();

      // Redereciona o usuário
      $request->getRouter()->redirect("/admin/users/".$obUser->id."/edit?status=updated");

   }

    /**
   * Método responsável por retornar o formulário de exclusão de um usuário
   * @param Request $request
   * @param integter $id
   * @return string
   */

   public static function getDeleteUser($request, $id)
   {

      // Obtém o usuário do banco de dados
      $obUser = EntityUser::getUserById($id);

      // Valida a instancia
      if(!$obUser instanceof EntityUser){

         $request->getRouter()->redirect("/admin/users");

      }
         
      // Conteúdo do formulário
      $content = View::render("admin/modules/users/delete", [
         "nome" => $obUser->nome,
         "email" => $obUser->email
      ]);

      return parent::getPainel("Excluir usuário - Painel", $content, "users");

   }

     /**
   * Método responsável por excluir o usuário
   * @param Request $request
   * @param integter $id
   * @return string
   */

   public static function setDeleteUser($request, $id)
   {

      // Obtém o usuário do banco de dados
      $obUser = EntityUser::getUserById($id);

      // Valida a instancia
      if(!$obUser instanceof EntityUser){

         $request->getRouter()->redirect("/admin/users");

      }

      // Excluir usuário
      $obUser->excluir();

      // Redereciona o usuário
      $request->getRouter()->redirect("/admin/users?status=deleted");

   }

}