<?php

namespace App\Models\Entity;

use \App\Db\Database;

class Testimony{

    /**
     * Identificador único do depoimento
     * @var integer
     */

    public $id;

    /**
     * Nome do escritor do depoimento
     * @var string
     */

    public $nome;

    /**
     * Mensagem
     * @var string
     */

    public $mensagem;

    /**
     * Data de publicação da mensagem
     * @var string
     */
    
    public $data;

    /**
     * Método responsável por cadastrar a instancia atual no banco de dados
     * @return boolean
     */

    public function cadastrar()
    {

        // Define a data
        $this->data = date("Y-m-d H:i:s");

        // Insere o depoimento no banco de dados
        $this->id = (new Database("depoimentos"))->insert([
            "nome" => $this->nome,
            "mensagem" => $this->mensagem,
            "data" => $this->data
        ]);

        // Sucesso
        return true;

    }

    
     /**
     * Método responsável por retornar os depoimentos do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return array
     */

     public static function getTestimonies($where = null, $order = null , $limit = null, $fields = "*")
     {
 
         return (new Database("depoimentos"))->select($where, $order, $limit, $fields);
 
     }

}