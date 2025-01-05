<?php

namespace App\Models\Entity;

use \App\Db\Database;
use \PDO;

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
     * Método responsável por atualizar a instancia atual 
     * @return boolean
     */

    public function atualizar()
    {

        // Atualiza o depoimento no banco de dados
        return (new Database("depoimentos"))->update("id = ".$this->id,[
            "nome" => $this->nome,
            "mensagem" => $this->mensagem,
        ]);

    }

     
   /**
    * Método responsável por excluir a vaga do banco
    * @return boolean
    */ 

    public function excluir()
    {

        return (new Database("depoimentos"))->delete("id = " . $this->id);

    }

    /**
     * Método responsável por retornar um depoimento com base no seu id
     * @param integer $id
     * @return Testimony
     */

    public static function getTestimonyById($id)
    {

        return self::getTestimonies("id = ".$id)->fetchObject(self::class);

    }

    
     /**
     * Método responsável por retornar os depoimentos do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOStatement
     */

     public static function getTestimonies($where = null, $order = null , $limit = null, $fields = "*")
     {
 
        return (new Database("depoimentos"))->select($where, $order, $limit, $fields)->fetchAll(PDO::FETCH_CLASS, self::class);
 
     }

}