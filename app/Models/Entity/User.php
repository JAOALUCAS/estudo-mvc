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

        return (new Database("usuarios"))->select('email = "'.$email.'"')->fetchObject(self::class);

    }

}