<?php
    namespace MVC\ConectorDatabase\CrudController ; 
    
    use MVC\ConectorDatabase\DatabaseConnect\DatabaseConnect; 
    use MVC\Entidade\EntidadeBase\EntidadeBase ;
    use PDO;
    use Exception;

    class CrudController {
        public $PDO ;


    function __construct(){
        $db = new DatabaseConnect();
        $this->PDO = $db->databaseConnection();
    }

    public function getCamposEntidadeSelect(EntidadeBase $entidade ){
        
        $campos = implode( ',', array_keys(get_class_vars(get_class( $entidade ) )) );
        return $campos;
    }
    public function getCamposEntidadeUpdate(EntidadeBase $entidade ){
        $campos =  array_keys(get_class_vars(get_class( $entidade ) ));
        $camposMerge='';
        foreach($campos as $campo ){
            $camposMerge .= $campo.'= :'.$campo.' ,' ; 
        }
        return strtolower(substr($camposMerge , 0 , -1)); 
    }
    public function getCamposEntidadeInsert(EntidadeBase $entidade ) : string{
        $campos =  array_keys(get_class_vars(get_class( $entidade ) ));
        $camposInsert='';
        foreach($campos as $campo ){
            if($campo != 'Id'){
                $camposInsert .= ' :'.$campo.' ,'; 
            }
        }
        
        return substr($camposInsert, 0,-1); ; 
    }
    
    public function getNomeTabela(EntidadeBase $entidade ){
        $nomeTabela = explode( '\\' , get_class( $entidade ) ) ; 
        return $nomeTabela[count($nomeTabela) -1 ]; 
    }
    
    public function retorna(EntidadeBase $entidade ){
        $query = 'select '.$this->getCamposEntidadeSelect($entidade).' from '.$this->getNomeTabela($entidade).' where id = :Id '; 
        $statement = $this->PDO->prepare($query) ; 
        $statement->bindValue('Id' , $entidade->Id);

        try{
            $statement->execute();
            $retornoQuery = $statement->fetch() ;
            if($retornoQuery){
                foreach( array_keys($retornoQuery) as $column ){
              
                    foreach( array_keys(get_class_vars(get_class( $entidade ) )) as $nomeColuna ){
                        if( strtolower( $nomeColuna ) == strtolower($column) )
                        {
                            $entidade->$nomeColuna  = $retornoQuery[$column] ;
                        }
                    }
                    
                }
                return $entidade ; 
            }else{
                return null; 
            }
            
        }
        catch(Exception $e ){
            throw $e ; 
            return null ; 
        }
    }

    public function update(EntidadeBase $entidade ){
        $query = 'update '.$this->getNomeTabela($entidade).' SET '.$this->getCamposEntidadeUpdate($entidade).' where id = '.$entidade->Id ;
        $statement = $this->PDO->prepare($query); 
        foreach(  array_keys(get_class_vars(get_class( $entidade ) )) as $coluna ){
            if(strtolower($coluna) == 'ultimamodificacao'){
                $statement->bindValue('ultimamodificacao' , 'now()' ) ;
            }else{
                if($entidade->$coluna == null ){
                    $statement->bindValue( ':'.strtolower($coluna) ,$entidade->$coluna , PDO::PARAM_NULL  );
                }else{
                    $statement->bindValue( ':'.strtolower($coluna) ,$entidade->$coluna , PDO::PARAM_STR  );
                }
            }
        }

        try{
            $statement->execute();
            return $statement->rowCount();
        }
        catch(Exception $e)
        {
            throw $e ; 
            return null ; 
        }

    }        
    public function insert(EntidadeBase $entidade){
        
        $query ='insert into '.$this->getNomeTabela($entidade).'('.str_replace(':','',$this->getCamposEntidadeInsert($entidade)).') values('.$this->getCamposEntidadeInsert($entidade).')';
        
        
        $statement = $this->PDO->prepare($query);
        $entidadeInsert = (array)$entidade;
        unset($entidadeInsert['Id']);  

        foreach(array_keys($entidadeInsert) as $campo ){
            if($entidadeInsert[$campo] == null ){
                $statement->bindValue( $campo , $entidadeInsert[$campo] , PDO::PARAM_NULL);
            }else{
            switch($campo){
            case 'UltimaModificacao' : $statement->bindvalue($campo , 'now()'); break;
            case 'CriadoEm': $statement->bindValue( $campo , 'now()' ); break; 
            default: 
            $statement->bindValue( $campo , $entidadeInsert[$campo] );
            }}
        }
        
        try{
            $statement->execute();
            return $statement->fetchAll();
        }
        catch(Exception $e){
            throw $e ; 
            return null ; 
        }

    }

    public function delete(EntidadeBase $entidade ){
        $query = 'delete from '.$this->getNomeTabela($entidade).' where Id = '.$entidade->Id;
        $statement = $this->PDO->prepare($query);
        
        

        try{
            if($statement->execute() )
            {
                return $statement->rowCount();
            }else{
                return 'Erro ao executar a query "'.$query.'"';
            }
        }
        catch(Exception $e){
            throw $e ;
            return null ; 
        }


    }

    public function executar( $query , $params){
        $statement =$this->PDO->prepare($query);
        foreach(array_keys($params) as $param){
            if($params[$param] == null ){
                $statement->bindValue( $param , $params[$param] , PDO::PARAM_NULL );    
            }else{
                $statement->bindValue( $param , $params[$param] );
            }

        }
        
        try{

            $statement->execute($params);
            $retorno = $statement->fetchAll();
            return $retorno ;
        }
        catch(Exception $e){
            return $e ; 
        }

    }
   
    }
    

?>
