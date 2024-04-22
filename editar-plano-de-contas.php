<?php

include("header.php"); 
include('config.php');  
include('scripts/functions.php'); 

if (isset($_GET['id']) ) { 
$id = (int) $_GET['id']; 
	if (isset($_POST['submitted'])) { 
	foreach($_POST AS $key => $value) { $_POST[$key] = stripslashes($value); } 
	$sql = "UPDATE `planodecontas` SET  `nome` =  '{$_POST['nome']}' ,  `tipo` =  '{$_POST['tipo']}'   WHERE `id` = '$id' "; 
	$db->query($sql) or die($db->errorInfo()[2]); 
	echo ($db->rowCount() > 0) ? "Edited row.<br />" : "Nothing changed. <br />"; 
	echo "<a href='listar-plano-de-contas.php'>Voltar a Listagem </a>"; 
	Redirect("listar-plano-de-contas.php",false); 


	} 
$row =  $db->query("SELECT * FROM `planodecontas` WHERE `id` = '$id' ")->results(true); 
?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <?= stripslashes($row['nome']) ?>
            <small> 
 </small>
        </h1>
    </div>
</div>

<form action='' method='POST'> 
	<p><b>Nome:</b>
	<input type='text' name='nome' value='<?= stripslashes($row['nome']) ?>' /> 
	<b>Tipo:</b> 
	<select name='tipo' >
		<?php 
		if (stripslashes($row['tipo']) == "Entrada"){
			echo "<option value='Saida'>Saidas e Pagamentos</option>";
			echo "<option selected value='Entrada'>Receitas e Entradas</option>"; 
		}else{
			echo "<option selected value='Saida'>Saidas e Pagamentos</option>";
			echo "<option value='Entrada'>Receitas e Entradas</option>"; 
		}

	?>
	</select>


<input type='submit' value='SALVAR' />
<input type='hidden' value='1' name='submitted' /> 

</form> 

<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header">
            Sub-Contas de <?= stripslashes($row['nome']) ?>
            <small> </small>
        </h3>

    </div>
</div>

<!-- PLANO DE CONTAS DETALHES -->
<div class="row">
<div class="col-lg-12">
<div class="datatable-tools">
<?php 

//include('config.php'); 
echo "<table class='table' ><thead>"; 
echo "<tr>"; 
echo "<th><b>Id</b></th>"; 
echo "<th><b>Nome</b></th>"; 
echo "<th><b>Tipo</b></th>"; 
echo "</tr>"; 
$result = $db->query("select * from planodecontas_niveis where idplanodecontas = {$id}  ")->results(true) or trigger_error($db->errorInfo()[2]); 
foreach($result as $row ){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['id']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['nome']) . "</td>";  


if($row['tipo'] == "Entrada"){
	echo "<td valign='top' class='blue'> <i class='fa fa-plus fa-2x'></i> " . nl2br( $row['tipo']) . "</td>";  
}else
{

echo "<td valign='top' class='red'> <i class='fa fa-minus fa-2x'></i> " . nl2br( $row['tipo']) . "</td>";  
}


echo "<td valign='top'><a href=editar-plano-de-contas.php?id={$row['id']}>Editar</a></td><td>SubContas</td> "; 
echo "</tr>"; 
} 
echo "<thead></table>"; 

?>
<a href="#" role="button" class="btn btn-large btn-primary" data-toggle='modal' data-target='#modalView'>Incluir sub-conta</a>
</div>
</div>




</div>




<?php } ?> 




<!-- Modal -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Vizualizar</h4>
      </div>
      <div class="modal-body">
      	<?php include("nova-subconta.php");  ?>
        
      </div>

        
        
       <div class="modal-footer">
           <button class="btn btn-success" id="submit">Salvar</button>
           <a href="#" class="btn" data-dismiss="modal">Close</a>
      </div>

      
    </div>
  </div>
</div>   


<?php include("footer.php");  ?>

<script>

 $(function() {
//twitter bootstrap script
  $("button#submit").click(function(){
      
        alert('Antes');
       $('myform').submit();  
       alert('Depois');

  });
});
</script>