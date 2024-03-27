<?php 
include('config.php'); 

#Retorna o CNPJ do Campo
//if (isset($_GET['function']) ) { 
    
    #id 
    $id = (int) $_GET['id']; 
    //if ($_GET['function']=='CNPJ'){ 

        //Lista Apenas Campos Eclesiáticos                                
        $resultSelect = mysql_query("select * from usuarios where id = {$id} ") or trigger_error(mysql_error()); 
        //echo "select * from usuarios where id = {$id}";

        while($rowOption = mysql_fetch_array($resultSelect)){ 
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


