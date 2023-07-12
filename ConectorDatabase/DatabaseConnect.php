<?php
    namespace MVC\ConectorDatabase\DatabaseConnect;

    use Exception;

    class DatabaseConnect{

    public function databaseConnection(){
        $config =json_decode( file_get_contents('config.json'));
        $connectionString = sprintf("pgsql:host=%s;port=%d;dbname=%s;user=%s;password=%s", 
        $config->host,  
        $config->port, 
        $config->database , 
        $config->user , 
        $config->password );

        try{
            $pdo = new \PDO($connectionString);
            $pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC );
        }
        catch(Exception $e){
            
            throw $e ; 
        }
        return $pdo;
    }
}
?>