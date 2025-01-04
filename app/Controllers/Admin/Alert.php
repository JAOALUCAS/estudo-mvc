<?php

namespace App\Controllers\Admin;

use App\Utils\View;

class Alert{

    /**
     * Método responsável por a mensagem de erro
     * @param string $message
     * @return string
     */
    
     public static function getError($message)
     {
 
         return View::render("admin/alert/status", [
             "tipo" => "danger",
             "mensagem" => $message
         ]);
 
     }

    /**
     * Método responsável por a mensagem de sucesso
     * @param string $message
     * @return string
     */

    public static function getSucess($message)
    {

        return View::render("admin/alert/status", [
            "tipo" => "success",
            "mensagem" => $message
        ]);

    }

}