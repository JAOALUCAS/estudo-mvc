<?php

namespace App\Http;

class Request{

    /**
     * Método HTTP da requisição
     * @var string
     */
    
    private $httpMethod;

    /**
     * URI da página
     * @var string
     */

    private $uri;

    /**
     *  Parâmetros da URL ($_GET)
     * @var array
     */

    private $querryParams = [];

    /**
     * Variáveis recebidas pelo POST da página ($_POST)
     * @var array
     */

    private $postVars = [];

    /**
     * Cabeçalho da requisição
     * @var array
     */

    private $headers = [];

    /**
     * Construtor da classe
     */

    public function __construct()
    {
        $this->headers = getallheaders();

        $this->querryParams = $_GET ?? [];

        $this->postVars = $_POST ?? [];

        $this->httpMethod = $_SERVER["REQUEST_METHOD"] ?? '';

        $this->uri = $_SERVER["REQUEST_URI"] ?? '';
        
    }

    /**
     * Método responsável por retorna o HTTP da requisição
     * @return string
     */

    public function getHttpMethod()
    {
        return $this->httpMethod;
    }
    
    /**
     * Método responsável por retorna a URI da requisição
     * @return string
     */

    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Método responsável por retorna os headers da requisição
     * @return array
     */

    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Método responsável por retorna os paramêtos da url da requisição
     * @return array
     */

    public function getQuerryParams()
    {
        return $this->querryParams;
    }

    /**
     * Método responsável por retorna as variáveis POST da requisição
     * @return array
     */

    public function getPostVars()
    {
        return $this->postVars;
    }

}