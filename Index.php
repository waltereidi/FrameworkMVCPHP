<?php
require_once "vendor/autoload.php";

use MVC\InjetorDependencia\InjetorDependencia;
use MVC\Router\Router ;
use Exception\Exception;
use MVC\Controller\PaginaErroController\PaginaErroController;



$di = new InjetorDependencia();

if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] !== '/' && $_SERVER['REQUEST_URI'] !== '\\' ){
    $controller = null ; 
    $router = new Router();
    $retornoRouter = $router->getControllerName($_SERVER['REQUEST_URI']) ;
    try{
        if( class_exists($retornoRouter['NamespaceController']) ){
            $controller = new $retornoRouter['NamespaceController']($_REQUEST , $di );
            $retorno = $controller->direcionar($retornoRouter['NomeMetodo']);
            
        }else{
            $controller = new PaginaErroController();
        }
        
    }catch(Exception $ex){
        throw $ex;
        
    }
    
    
}else{
    $controller = new \MVC\Controller\IndexController\IndexController($_REQUEST , $di );
    $controller->direcionar('');


}




    

?>