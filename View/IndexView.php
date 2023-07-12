<?php 
namespace MVC\View\IndexView; 
    class IndexView{

    
    public function montarPagina($dados){
        echo "<table border='solid' ><th>numero</th>";
        foreach($dados as $row ){
            echo '<tr><td>'.$row['gen'].'</td></tr>';
        }
        echo '</table>';
    }

    }
?>