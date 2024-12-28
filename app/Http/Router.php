<?php

namespace App\Http;

use \Closure;
use \Exception;
use \ReflectionFunction;

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
        // Validação dos parâmetros
        foreach($params as $key=>$value)
        {

            if($value instanceof Closure){

                $params["controller"] = $value;

                unset($params[$key]);

            }

        }

        // Váriaveis da rota
        $params["variables"] = [];

        // Padrão de validação das rotas
        $patternVariable = "/{(.*?)}/";

        if(preg_match_all($patternVariable, $routes, $matches)){

            $routes = preg_replace($patternVariable, "(.*?)", $routes);

            $params["variables"] = $matches[1];

        }

        // Padrão de validação da Url
        $patternRoutes = "/^" . str_replace("/", "\/", $routes) . "$/";

        // Adiciona a rota dentro da classe
        $this->routes[$patternRoutes][$method] = $params;

    }

    /**
     * Método responsável por definir uma rota de POST
     *
     * @param string $routes
     * @param array $params
     */

    public function post($routes, $params = [])
    {

        return $this->addRoutes('POST', $routes, $params);

    }

     /**
     * Método responsável por definir uma rota de PUT
     *
     * @param string $routes
     * @param array $params
     */

     public function put($routes, $params = [])
     {
 
         return $this->addRoutes('PUT', $routes, $params);
 
     }

      /**
     * Método responsável por definir uma rota de DELETE
     *
     * @param string $routes
     * @param array $params
     */

    public function delete($routes, $params = [])
    {

        return $this->addRoutes('DELETE', $routes, $params);

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

    /**
     * Método responsável por retornar a URI sem o prefixo
     * @return string
     */

    private function getUri()
    {

        // URI da request
        $uri = $this->request->getUri();

        // Fatia a uri com o prefixo
        $xUri = strlen($this->prefix) ? explode($this->prefix, $uri) : [$uri];

        // Retorna a URI sem prefixo
        return end($xUri);

    }

    /**
     * Método responsável por retornar os dados da rota atual
     * @return array
     */

    private function getRoute()
    {

        // URI
        $uri = $this->getUri();

        // Method
        $httpMethod = $this->request->getHttpMethod();

        // Valida as rotas
        foreach($this->routes as $patternRoutes=>$methods)
        {

            // Verifica se a Uri bate com o padrão
            if(preg_match($patternRoutes, $uri, $matches)){

                // Verifica os methods
                if(isset($methods[$httpMethod])){

                    // Remove a primeira posição
                    unset($matches[0]);

                    // Chaves
                    $keys = $methods[$httpMethod]["variables"];

                    $methods[$httpMethod]["variables"] = array_combine($keys, $matches);
                    $methods[$httpMethod]["variables"]["request"] = $this->request;

                    // Retorno dos parâmetros da rota
                    return $methods[$httpMethod];

                }

                // Método não permitido
                throw new Exception("Método não permitido" , 405);

            }

        }
        
        // Url não encontrada
         throw new Exception("Url não encontrada", 404);

    }

    /**
     *  Método responsável por executar a rota atual
     * @return Response
     */

    public function run()
    {

        try{

            // Obtém a rota atual
            $routes = $this->getRoute();

            // Verifica a rota atual
            if(!isset($routes["controller"])){

                throw new Exception("A Url não pode ser processada" , 500);

            }

            // Argumentos da função
            $args = [];

            // Reflection
            $reflection = new ReflectionFunction($routes["controller"]);

            foreach($reflection->getParameters() as $parameter)
            {

                $name = $parameter->getName();

                $args[$name] = $routes["variables"][$name] ?? '';

            }

            // Retorna a execução da função
            return call_user_func_array($routes["controller"], $args);

        }catch(Exception $e){

            return new Response($e->getCode(), $e->getMessage());

        }

    }

}