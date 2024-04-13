<?php 
include('config.php'); 

#Retorna o CNPJ do Campo
//if (isset($_GET['function']) ) { 
    
    #id 
    $id = (int) $_GET['id']; 
    //if ($_GET['function']=='CNPJ'){ 

        //Lista Apenas Campos Eclesiáticos                                
        $resultSelect = $db->query("select * from usuarios where id = {$id} ")->results(true) or trigger_error($db->errorInfo()[2]); 
        //echo "select * from usuarios where id = {$id}";

        foreach($resultSelect as $rowOption ){ 
          foreach($rowOption AS $key => $value) { 
            $rowOption[$key] = stripslashes($value); 
          }


          if(($rowOption['CNPJ'] != "") || ($rowOption['CPF']=="")){
              echo "#CNPJ#" . $rowOption['CNPJ'];   
          }else{
                echo "#CPF#" .$rowOption['CPF'];
          }                              
      
        } 
    
       
    //}
//}

?>


