<?php

/*
$result = $db->query("select * from planodecontas_niveis where idplanodecontas = {$id}  ") or trigger_error($db->errorInfo()[2])(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo nl2br( $row['id']) . "</td>";  
nl2br( $row['nome']) . "</td>";  
} 
*/

if (isset($_POST['submitted'])) { 

	echo "POST";

foreach($_POST AS $key => $value) { $_POST[$key] = $db->escape($value); } 
$sql = "INSERT INTO `planodecontas_niveis` ( `idplanodecontas` ,  `nome`  ) 
		VALUES( '{$_GET['id']}', '{$_POST['nome']}'   ) "; 
$db->query($sql) or die($db->errorInfo()[2]); 
echo "Subconta Adicionada<br />"; 
echo "<a href='listar-plano-de-contas.php'>Back To Listing</a>"; 
} 

?>


<form  id='myform' action='' method='POST'> 
	<p><b>Nome:</b>
	<input type='text' name='nome' value='' /> 
	<input type='submit' name='submit' value='submit' /> 
	<input type='hidden' value='1' name='submitted' /> 
</form> 






