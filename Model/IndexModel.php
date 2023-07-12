<?php
    namespace MVC\Model\IndexModel;

    class IndexModel{
        public $di; 
    
    public function __construct( $di ){
        
        $this->di = $di ;
    }
    public function selectBanco(  ){

        return $this->di->CrudController->executar('SELECT gen from generate_series(1,10,1) gen ' , [] ) ; 

    }
}

?>