<?php

namespace App\Http\Middleware;

use Exception;

use \App\Models\Entity\User;

class UserBasicAuth{


    /**
     * Método respomsável por validar acesso via http basic auth
     * @param Request $request
     */

    private function basicAuth($request)
    {

        // Verifica o usuário recebido
        if($obUser = $this->getBasicAuthUser()){

            $request->user = $obUser;

            return true;

        }

        // Emite o erro de senha inválida
        throw new Exception("Usuário ou senha inválidos", 403);

    }

    /**
     * Método responsável por retornar a instância do usuário autenticado
     * @return User
     */

    private function getBasicAuthUser()
    {

        // Verifica a existencia dos dados de acesso
        if(!isset($_SERVER["PHP_AUTH_USER"]) or !isset($_SERVER["PHP_AUTH_PW"])){

            return false;

        }


        // Busca o usuário pelo email
        $obUser = User::getUserByEmail($_SERVER["PHP_AUTH_USER"]);

        // Verifica a instancia
        if(!$obUser instanceof User){

            return false;

        }

        // Valida a senha e retorna o usuário
        return password_verify($_SERVER["PHP_AUTH_PW"], $obUser->senha) ? $obUser : false;

    }

    /**
     * Método responsável por executar o middleware
     * @param Request $request
     * @param Closure $next
     * @return Response
     */

    public function handle($request , $next)
    {

        // Realiza a validação do acesso via basic auth
        $this->basicAuth($request);

        // Executa o próximo nível
        return $next($request);

    }
    
}