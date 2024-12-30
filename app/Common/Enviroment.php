<?php

namespace App\Common;

class Enviroment{

    /**
     *  Método responsável por carregar as váriaveis de ambiente do projeto
     * @param string $dir Caminho absoluto onde encontra-se o arquivo .env
     */
    public static function load($dir)
    {

        // Verifica se o arquivo .env existe
        if(!file_exists($dir . "./.env")){

            return false;

        }

        
        $lines = file($dir . "/.env");

        foreach($lines as $line)
        {

            // Define as váriaveis de ambiente
            putenv(trim($line));

        }

    }

}