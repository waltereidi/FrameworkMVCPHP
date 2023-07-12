<?php
    namespace MVC\InjetorDependencia;

    use MVC\ConectorDatabase\CrudController\CrudController;

    class InjetorDependencia{
            public $CrudController ;

        public function __construct(
    

        ){
            $this->CrudController = new CrudController(); 
        }
    }
