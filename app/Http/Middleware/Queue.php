<?php

namespace App\Http\Middleware;
use \Closure;

class Queue{

    /**
     *  Mapeamento de middlewares
     * @var array
     */

    private static $map = [];

    /**
     * Mapeamento de middlewares que serão carregados em todas as rotas
     * @var array
     */

     private static $default = [];

    /**
     * Fila de middlewares a serem executados
     * @var array
     */

    private $middlewares = [];


    /**
     * Função de execução do controlador
     * @var Closure
     */

    private $controllers;

    /**
     * Argumentos da função do controlador
     * @var array
     */

    private $controllersArgs;

    /**
     * Método responsável por instanciar a classe de fila de middlewares
     * @param array $middlewares
     * @param Closure $controllers
     * @param array $controllersArgs
     */

    public function __construct($middlewares, $controllers, $controllersArgs)
    {

        $this->middlewares = array_merge(self::$default, $middlewares);

        $this->controllers = $controllers;

        $this->controllersArgs = $controllersArgs;

    }

    /**
     * Método responsável por definir o mapeamento
     * @param array $map
     */

    public static function setMap($map)
    {

        self::$map = $map;

    }

     /**
     * Método responsável por definir o mapeamento padrões
     * @param array $default
     */

     public static function setDefault($default)
     {
 
         self::$default = $default;
 
     }

    /**
     * Método responsável por avançar um nivel da fila do middlewares
     * @param Request $request
     * @return Response
     */

    public function next($request)
    {

        // Verifica se a fila está vazia
        if(empty($this->middlewares)) return call_user_func_array($this->controllers, $this->controllersArgs);

        // Middleware
        $middleware = array_shift($this->middlewares);

        // Verifica o mapeamento
        if(!isset(self::$map[$middleware])){

            throw new \Exception("Problema ao processar o middleware da requisição", 500);

        }

        // Next
        $queue = $this;

        $next = function($request) use ($queue){

            return $queue->next($request);

        };

        // Executa o middleware
        return (new self::$map[$middleware])->handle($request, $next);

    }

}