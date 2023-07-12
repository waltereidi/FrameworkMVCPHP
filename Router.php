<?php
    namespace MVC\Router; 
    class Router{
             
       
        public function getControllerName($requestURI){
            
            $request = preg_replace( '/^[\\/\\\\](.*?)[\\/\\\\]$/' , '$1', $requestURI) ;
            
            preg_match('/(?<=\?).*/' , $request , $parametros); 
            $Controller = str_replace( '/' , '\\' , str_replace('?' , '' ,str_replace( $parametros , '' , $request ) ));   


            if(substr( $Controller , 0 , 1 ) == '\\' ){
                $Controller= substr($Controller , 1);
            }
            
            $nomeController=empty($Controller) ?  null :explode('\\' , $Controller ) ;
                
            $retornoController =empty($nomeController[0]) ? null : 'MVC\\'.'Controller\\'.ucfirst($nomeController[0]).'Controller'.'\\'.ucfirst($nomeController[0]).'Controller' ;
            $retornoMetodo = empty($nomeController[1]) ? null : $nomeController[1] ;



            return array( 'NamespaceController' => $retornoController ,'NomeMetodo'=> $retornoMetodo ,'Parametros'=> $parametros ) ;

        }

    }

?>
