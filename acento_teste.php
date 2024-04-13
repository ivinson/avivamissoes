<?php

ini_set('display_errors',0);
ini_set('display_startup_erros',0);
error_reporting(0);

session_start();
define ('DEBUG', false); 


  include("header.php")    ; 
# Teste de acento
# id 1178


  if (isset($_POST['submitted'])) {

$Nome =  "Genérico";
$Nome2 = "ÇÇÉéGenériço";
$Nome3 = $_POST['Nome'];

# Banco de Dados

define('Cons_Servidor', 	'186.202.152.189', false);
define('Cons_NomeBanco', 	'avivamissoes22', false);
define('Cons_UserBD', 		'avivamissoes22', false);
define('Cons_SenhaBD', 		'Aviva@Missoes', false);

//Acesso bando online Locaweb
// Verifique se a conexão foi bem-sucedida
if (!$db) {
    die('Erro na conexão com o banco de dados: ' . $db->errorInfo()[2]);
}else{ 	echo '<br>CONECTADO';}

$db->query("SET NAMES 'utf8'");
$db->query("SET character_set_connection=utf8");
$db->query("SET character_set_client=utf8");
$db->query("SET character_set_results=utf8");

// Tente selecionar o banco de dados
if (!$db->select_db(Cons_NomeBanco)) {
    die('Erro ao selecionar o banco de dados: ' . $db->errorInfo()[2]);
}else{ 	echo '<br> Banco Selecionado';}

echo "<br>Teste ok";

# Update
$sqlCampos = "UPDATE usuarios SET  Nome =  '{$Nome3}' WHERE id = 1178 ";  

if (! $db->query($sqlCampos) ){
  die( ':: Erro : '. $db->errorInfo()[2]); 
  echo "Fase de teste : Anote o seguinte erro!";
}else{ 	echo '<br> Gravado com Sucesso';}

  }



ini_set('display_errors',1);
ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);
set_time_limit(0);
 
?>


 <form role="form" action='' method='POST'> 
   
<div class="form-group">
    <label>Nome</label>
    <input class="form-control" name='Nome'  value='<?= stripslashes($row['Nome']) ?>'>                                
</div>  
   

<input class="btn btn-lg btn-success" type='submit' value='Gravar alterações' />                        
<input class="btn btn-lg btn-info" onclick='history.back(-1)' value='Voltar' />

<input type='hidden' value='1' name='submitted' />    
</form>
