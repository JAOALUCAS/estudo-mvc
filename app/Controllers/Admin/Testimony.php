<?php

namespace App\Controllers\Admin;

use \App\Utils\View;
use \App\Models\Entity\Testimony as EntityTestimony;
use \App\Db\Pagination;

class Testimony extends Page{

   /**
     * Método responsável por retornar a renderização dos itens de uma página
     * @param Request $request
     * @param Pagination $obPagination
     * @return string
     */

   private static function getTestimonyItens($request, &$obPagination)
   {
      // Depoimentos
      $itens = "";
   
      // Quantidade total de registros
      $quantidadeTotal = EntityTestimony::getTestimonies(null, null, null, "COUNT(*) as qtd")[0]->qtd;
   
      // Página atual
      $queryParams = $request->getQuerryParams(); 
   
      $paginaAtual = $queryParams["page"] ?? 1;
   
      // Instancia de paginação 
      $obPagination = new Pagination($quantidadeTotal, $paginaAtual, 5);
   
      // Resultados da página 
      $results = EntityTestimony::getTestimonies(null, "id DESC", $obPagination->getLimit());
   
      // Renderiza o item
      foreach ($results as $obTestimony) {
            $itens .= View::render("admin/modules/testimonies/item", [
               "id" => $obTestimony->id,
               "nome" => $obTestimony->nome,
               "mensagem" => $obTestimony->mensagem,
               "data" => date("d/m/Y H:i:s", strtotime($obTestimony->data))
            ]);
      }
   
      // Retorna os depoimentos 
      return $itens;
   }

   /**
    * Método responsável por renderizar view de listagem de depoimentos do painel
    * @param Request $request
    * @return string
    */

   public static function getTestimonies($request)
   {

      // Conteúdo dos depoimentos
      $content = View::render("admin/modules/testimonies/index", [
         "itens" => self::getTestimonyItens($request, $obPagination),
         "pagination" => parent::getPagination($request, $obPagination)
      ]);

      return parent::getPainel("Depoimentos - Painel", $content, "testimonies");

   }

   /**
   * Método responsável por retornar o formulário de cadastro de um novo depoimento
   * @param Request $request
   * @return string
   */

   public static function getNewTestimony($request)
   {
      
      // Conteúdo do formulário
      $content = View::render("admin/modules/testimonies/form", [
         "title" => "Cadastrar depoimento",
         "nome" => "",
         "mensagem" => ""
      ]);

      return parent::getPainel("Cadastrar depoimento - Painel", $content, "testimonies");

   }

   /**
   * Método responsável por cadastrar um depoimento no banco
   * @param Request $request
   * @return string
   */

   public static function setNewTestimony($request)
   {
         
      // Post vars
      $postVars = $request->getPostVars();

      // Nova instancia depoimento
      $obTestimony = new EntityTestimony;

      $obTestimony->nome = $postVars["nome"] ?? "";

      $obTestimony->mensagem = $postVars["mensagem"] ?? "";

      $obTestimony->cadastrar();

      // Redereciona o usuário
      $request->getRouter()->redirect("/admin/testimonies/".$obTestimony->id."/edit?status=created");

   }
 
   /**
   * Método responsável por retornar o formulário de edição de um depoimento
   * @param Request $request
   * @param integter $id
   * @return string
   */

   public static function getEditTestimony($request, $id)
   {

      // Obtém o depoimento do banco de dados
      $obTestimony = EntityTestimony::getTestimonyById($id);

      // Valida a instancia
      if(!$obTestimony instanceof EntityTestimony){

         $request->getRouter()->redirect("/admin/testimonies");

      }
         
      // Conteúdo do formulário
      $content = View::render("admin/modules/testimonies/form", [
         "title" => "Editar depoimento",
         "nome" => $obTestimony->nome,
         "mensagem" => $obTestimony->mensagem
      ]);

      return parent::getPainel("Editar depoimento - Painel", $content, "testimonies");

   }

   
   /**
   * Método responsável por gravar a mudança do depoimento
   * @param Request $request
   * @param integter $id
   * @return string
   */

   public static function setEditTestimony($request, $id)
   {

      // Obtém o depoimento do banco de dados
      $obTestimony = EntityTestimony::getTestimonyById($id);

      // Valida a instancia
      if(!$obTestimony instanceof EntityTestimony){

         $request->getRouter()->redirect("/admin/testimonies");

      }
      
      // Post vars
      $postVars = $request->getPostVars();

      // Atualiza a instancia
      $obTestimony->nome = $postVars["nome"] ?? $obTestimony->nome;
      
      $obTestimony->mensagem = $postVars["mensagem"] ?? $obTestimony->mensagem;

      $obTestimony->atualizar();

      // Redereciona o usuário
      $request->getRouter()->redirect("/admin/testimonies/".$obTestimony->id."/edit?status=updated");

   }

}