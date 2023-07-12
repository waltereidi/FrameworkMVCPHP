<?php
namespace MVC\Controller\IndexController;
use MVC\Controller\AbstractController\AbstractController;

use MVC\View\IndexView\IndexView;
use MVC\Model\IndexModel\IndexModel;
use MVC\Controller\PaginaErroController\PaginaErroController;
    class IndexController extends AbstractController{
        public $view;
        public $model;

        public function __construct($request , $di ){
            $this->view = new IndexView();
            $this->model = new IndexModel($di);
            
        }
        public function direcionar($metodo ){
            if($metodo == ''){
            $this->retornaIndex();
            }else{
                $retorno = new PaginaErroController();
                
            }

        }
        
        public function retornaIndex(){
            $dados = $this->model->selectBanco();
            $this->view->montarPagina($dados);
        }

    }

?>