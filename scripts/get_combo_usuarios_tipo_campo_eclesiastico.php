<?php

 include('./config.php');
?>
<select data-placeholder="Escolha um usuário..." id="selectUsuario" class="chosen-select" onChange="getMontaformulario()">
  <?php 
    // Lista Apenas Campos Eclesiáticos
    // Parametrizar
    $resultSelect = $db->query("SELECT * FROM `Usuarios` WHERE idTipoUsuario = 6 ORDER BY nome")->results(true) or trigger_error($db->errorInfo()[2]); 
    foreach($resultSelect as $rowOption) { 
      foreach($rowOption as $key => $value) { 
        $rowOption[$key] = stripslashes($value); 
      }                               
      echo "<option value='". nl2br($rowOption['id']) ."'>". nl2br($rowOption['Nome']) ."</option>";                                 
    } 
  ?> 
</select>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>

<?php echo $resultStr; ?>