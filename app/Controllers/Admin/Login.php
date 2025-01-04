<?php

namespace App\Controllers\Admin;

use App\Utils\View;
use App\Models\Entity\User;
use App\Session\Admin\Login as SessionAdminLogin;
use App\Controllers\Admin\Alert;

class Login extends Page{

    /**
     * Método responsável por retornar  renderização da página de login
     * @param Request $request
     * @param string $errorMessage
     * @return string
     */

    public static function getLogin($request, $errorMessage = null)
    {
        //Status
        $status  = !is_null($errorMessage) ? Alert::getSucess($errorMessage) : "";

        // Conteúdo da página de login
        $content = View::render("admin/login", [
            "status" => $status
        ]);

        // Retorna a página completa
        return parent::getPage("Login", $content);

    }

    /**
     * Método responsável por definir o login de usuário
     * @param Request $request
     */

    public static function setLogin($request)
    {

        //Post vars
        $postVars = $request->getPostVars();

        $email = $postVars["email"] ?? "";

        $senha = $postVars["senha"] ?? "";

        // Busca o usuário pelo email
        $obUser = User::getUserByEmail($email);

        if(!$obUser instanceof User){

            return self::getLogin($request, "Email ou senha inválidos");

        }

        // Verifica a senha do usuário
        if(!password_verify($senha, $obUser->senha)){

            return self::getLogin($request, "Email ou senha inválidos");
            
        }

        // Cria a sessão de login
        SessionAdminLogin::login($obUser);

        // Redireciona o usuário para página admin
        $request->getRouter()->redirect("/admin");

    }

    /**
     * Método responsável por deslogar
     * @param Request $request
     */
    public static function setLogout($request)
    {
        
        // Destroi a sessão de login
        SessionAdminLogin::logout();

        // Redireciona o usuário para a tela de loin
        $request->getRouter()->redirect("/admin/login");

    }

}