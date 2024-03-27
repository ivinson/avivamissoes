<?php 
include('config.php'); 

$fID =  $_GET['id'] ;

echo "<select   name=\"selectUsuario\" id=\"selectUsuario\" class=\"form-control\" class=\"chosen-select\" 
 \>";

 


    //Lista Apenas Campos Eclesiáticos                                
    $resultSelect = mysql_query("
									SELECT u.* FROM `usuarios` u
											join congregacoes i on (i.id= u.idCongregacao)
											join campos c on(c.id = i.idCampo)

									where c.idRegiao = ". $fID ."

									                                       
                                    and u.idTipoUsuario <> 8 
                                    and u.idTipoUsuario in (6,7,4,9)

   union 
                                     select 0, '- Selecione um campo para emitir o boleto' 
                               , '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
                               , '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', ''
                               , '', '','','',''
                                      order by Nome asc
    	") or 
    trigger_error(mysql_error()); 
    
    while($rowOption = mysql_fetch_array($resultSelect)){ 
    foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
      echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
    } 

    echo "</select>";
    
 






?>