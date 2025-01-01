<?php

namespace App\Db;

use \PDO;
use PDOException;

class Database{

    /**
     * Host de conexão com o banco de dados
     *  @var string
     */

     private static $host;
    
    /**
     * Nome do banco
     *  @var string
     */

     private static $name;

    /**
     * Usuário do banco 
     *  @var string
     */

     private static $user;

    /**
     * Senha do banco de dados
     *  @var string
     */

     private static $pass;

    /**
     * Porta de conexão com o banco de dados
     *  @var string
     */

    private static $port;

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
     * Método responsável por configurar a classe
     * @param  string  $host
     * @param  string  $name
     * @param  string  $user
     * @param  string  $pass
     * @param  integer $port
    */

    public static function config($host,$name,$user,$pass,$port = 3306){

        self::$host = $host;

        self::$name = $name;

        self::$user = $user;

        self::$pass = $pass;

        self::$port = $port;

    }

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

        try {
            
            // Corrigindo a string de conexão com os delimitadores corretos
            $dsn = "mysql:host=" . self::$host . ";dbname=" . self::$name . ";port=" . self::$port;
            
            // Estabelecendo a conexão
            $this->connection = new PDO($dsn, self::$user, self::$pass);
            
            // Configurando o modo de erro para exceções
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            
            // Finalizando em caso de erro
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
        return $this->connection->lastInsertId();

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
        $querry = "SELECT ". $fields ." FROM " . $this->table . " " . $where . " " . $order . " " . $limit;

        // Executa a querry
        return $this->execute($querry);

    }

}