<?php

namespace App\Db;

use \PDO;
use PDOException;

class Database{

    /**
     * Host de conexão com o banco de dados
     *  @var string
     */

    const HOST = "localhost";
    
    /**
     * Nome do banco
     *  @var string
     */

    const NAME = "database";

    /**
     * Usuário do banco 
     *  @var string
     */

    const USER = "root";

    /**
     * Senha do banco de dados
     *  @var string
     */

    const PASS = "";

    /**
     * Porta de conexão com o banco de dados
     *  @var string
     */

    const PORT = "3306";

    /**
     * Nome da tabela a ser manipulada
     * @var string
     */
    private $table;

    /**
     * Instancia de conexão com o banco de dados
     * @var PDO
     */

    private $connection;

    /**
     * Define a table e instancia a conexão
     * @param string $table
     */
    public function __construct($table = null)
    {
        
        $this->table = $table;

        $this->setConnection();

    }

    /** 
     * Método responsável por definir a conexão com o banco de dados
    */ 
    private function setConnection()
    {
          
        try{

            $this->connection = new PDO("mysql:host" . self::HOST. ";dbname:" . self::NAME, self::USER, self::PASS);

            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){

            die("ERROR: " . $e->getMessage());

        }

    }

    /**
     * Método responsável por executar querries dentro do banco de dados 
     * @param string $querry
     * @param array $params
     * @return PDOstatement
     */

    public function execute($querry, $params = [])
    {

        try{

            $statment = $this->connection->prepare($querry);

            $statment->execute($params);

            return $statment;

        }catch(PDOException $e){

            die("ERROR: " . $e->getMessage());

        }

    }

    /**
     * Métodod responsável por inserir dados no banco 
     * @param array $values [field => value]
     * @return integer Id inserido
     */

    public function insert($values)
    {
        // Monta a querry
        $fields = array_keys($values);

        $binds = array_pad([], count($fields), "?");

        // Dados da querry 
        $querry = "INSERT INTO " . $this->table . "(". implode(",", $fields) . ") VALUES(". implode(",", $binds).")";

        // Executa o insert
        $this->execute($querry, array_values($values));

        // Retorna o id inserido 
        $this->connection->lastInsertId();

    }

   /**
    * Método responsável por executar uma consulta no banco de dados
    * @param string $where
    * @param string $order
    * @param string $limit
    * @param string $fields
    * @return PDOstatement
    */

    public function select($where = null , $order = null , $limit = null , $fields = "*")
    {

        // Dados da querry
        $where = strlen($where) ? "WHERE " . $where : "";

        $order = strlen($order) ? "ORDER BY " . $order : "";

        $limit = strlen($limit) ? "LIMIT " . $limit : "";
    
        // Monta a querry
        $querry = "SELECT ". $fields ." FROM " . $this->table ."";

        // Executa a querry
        return $this->execute($querry);

    }

}