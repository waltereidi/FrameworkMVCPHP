<?php
namespace MVC\Controller\PaginaErroController; 
use MVC\Controller\AbstractController\AbstractController;
use MVC\View\PaginaErroView\PaginaErroView;
    
    class PaginaErroController extends AbstractController{
        private $view ;

        public function __construct( )
        {
            $this->view = new PaginaErroView() ; 

        }

    }




?>