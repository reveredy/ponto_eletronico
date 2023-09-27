<?php

class Database{
    //Função estática(::) para conectar ao banco de dados
    public static function getConection(){
        //envPath é o caminho do arquivo env.ini
        //dirname(__FILE__) nos retorna o diretório que esse arquivo está.
        $envPath = realpath(dirname(__FILE__) . '/../env.ini');

        //parse_ini_file() carrega o arquivo INI especificado em filename e retorna as configurações contidas nele em um array associativo.
        $env = parse_ini_file($envPath);

        //Fazendo a conexão com o banco de forma dinâmica, atraves do array associativo(chave e nome)
        $conn = new mysqli($env['host'], $env['password'], $env['username'], $env['database']);
        
        //Verificando se tem algum erro na conexão
        if($conn->connect_error){
            die("Erro: " . $conn->connect_error);
        }

        //Se estiver tudo ok retorna a conexão
        return $conn;
    }
}