<?php 
  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
?>
<!-- TITULO e cabeçalho das paginas  -->

<style type="text/css">
.blue {color: blue !important;}
.red {color: red !important;}

</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Plano de Contas
            <small> </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> <a href='novo-plano-de-contas.php'>Novo Plano de Contas</a>
            </li>
        </ol>
    </div>
</div>


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
$result = $db->query("SELECT * FROM `planodecontas`")->results(true) or trigger_error($db->errorInfo()[2]); 
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
</div>
</div>
</div>

<?php
echo "<a href=novo-plano-de-contas.php>Novo Plano de Contas</a>"; 
?>