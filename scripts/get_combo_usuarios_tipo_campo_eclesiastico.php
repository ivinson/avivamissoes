<?php

 include('./config.php');

  echo <select  data-placeholder="Escolha um usuário... " id="selectUsuario" class="chosen-select"  onChange="getMontaformulario();">
    <?php 
      
      //Lista Apenas Campos Eclesiáticos
      //Parametrizar
      $resultSelect = mysql_query("SELECT * FROM `Usuarios` where idTipoUsuario = 6 order by nome") or trigger_error(mysql_error()); 
      while($rowOption = mysql_fetch_array($resultSelect)){ 
      foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
        echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
      } 
      
      ?> 

  </select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <br>




 echo $resultStr;
?>
