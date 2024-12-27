<?php

namespace App\Http;

use \Closure;

class Router{

    /**
     * URL completa do projeto (raiz)
     * @var string
     */

    private $url = "";

    /**
     * Prefixo de todas as rotas
     * @var string
     */

    private $prefix = "";

    /**
     * Indice de rotas
     * @var array
     */

    private $routes = [];

    /**
     * Instacia do Request
     * @var Request
     */

    private $request;

    /**
     * Método respoinsável por iniciar a classe
     * @param string $url
     */
    public function __construct($url)
    {

        $this->request = new Request();

        $this->url = $url;

        $this->setPrefix();

    }

    /** 
     * Método responsável por definir o prefixo das rotas 
    */

    private function setPrefix()
    {

        //Informações da Url atual
        $parseUrl = parse_url($this->url);

        //Define o prefixo
        $this->prefix = $parseUrl["path"] ?? "";

    }

    /**
     * Método responsável por adicionar uma rota na classe
     * @param string $method
     * @param string $routes
     * @param array $params
     */

    private function addRoutes($method, $routes, $params = [])
    {
        
        foreach($params as $key=>$value)
        {

            if($value instanceof Closure){

                $params["controller"] = $value;

                unset($params[$key]);

            }

        }

        $patternRoutes = "/^" . str_replace("/", "\/", $routes) . "$/";

    }

    /**
     * Método responsável por definir uma rota de GET
     *
     * @param string $routes
     * @param array $params
     */

    public function get($routes, $params = [])
    {

        return $this->addRoutes('GET', $routes, $params);

    }

}