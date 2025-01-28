<?php

namespace App\Models\Entity;

use \App\Db\Database;
use \PDO;

class User{

    /**
     * Identificador único
     * @var integer
     */

    public $id;

    /**
     * Nome do usuário
     * @var string
     */

    public $nome;

    /**
     * Email
     * @var string
     */

    public $email;

    /**
     * Senha
     * @var string
     */
    
    public $senha;

    /**
     * Método responsável por retornar um usuário atráves do email
     * @param string $email
     * @return User
     */

    public static function getUserByEmail($email)
    {

        return self::getUsers('email = "'.$email.'"')->fetchObject(self::class);

    }

    /**
     * Método responsável por cadastrara instancia atual no banco de dados
     * @return boolean
     */

    public function cadastrar()
    {

        // Insere a instancia no banco
        $this->id = (new Database("usuarios"))->insert([
            "nome" => $this->nome,
            "email" => $this->email,
            "senha" => $this->senha
        ]);

        // Sucesso
        return true;

    }

    /**
     * Método responsável por atualizar os dados do banco
     * @return boolean
     */

    public function atualizar()
    {

        return (new Database("usuarios"))->update("id = ".$this->id, [
            "nome" => $this->nome,
            "email" => $this->email,
            "senha" => $this->senha
        ]);

    }

    /**
     * Método responsável por excluir o usuário do banco
     * @return boolean
     */

    public function excluir()
    {

        return (new Database("usuarios"))->delete("id = ".$this->id);

    }

    /**
     * Método responsável por retornar os usuários do banco de dados
     * @param string $where
     * @param string $order
     * @param string $limit
     * @param string $fields
     * @return PDOstatement
     */

    public static function getUsers($where = null, $order = null , $limit = null, $fields = "*")
    {
 
        return (new Database("usuarios"))->select($where, $order, $limit, $fields);
 
    }

    /**
     * Método responsável por retornar uma instancia com base id
     * @param integer $id
     * @return User
     */
    public static function getUserById($id)
    {

        return self::getUsers("id = ".$id)->fetchObject(self::class);

    }

}