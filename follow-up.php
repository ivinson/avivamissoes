<?php

include("header.php"); 
include('config.php');  
include('scripts/functions.php'); 

if (isset($_GET['id']) ) { 
    $id = (int) $_GET['id']; 
    $idUsuario = $_GET['idusuario'];

    //Seleciona id
    $row = $db->query("SELECT * from usuarios  WHERE id = {$id} ")->results(true)[0]; 
    foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 


    // Se for Edicao
    if (isset($_POST['submitted'])) { 
    foreach($_POST AS $key => $value) { 
        $_POST[$key] = $db->escape($value); 
        //echo "<br> key {$_POST[$key]} ::: {$value}";
    } 
             
    //$data_referencia = $_POST['Ano']."-".$_POST["Mes"]."-15";
    $conteudoAnterior = $row['Follow'];

    $fConversa = "Canal : via {$_POST['sCanal']} :: "."\xA"."  Data : ". date("d-m-Y H:i:s")."\xA"." Conversa :  ".htmlentities($_POST['txtconversa'])."<hr>". $conteudoAnterior;
    
    $sql = "UPDATE usuarios SET  Follow =  '{$fConversa}'  
                                        WHERE id = $id "; 
    
    //$sql = "insert into usuarios (Follow) values ()"                                        
    //echo $sql;                                        
    
    $db->query($sql) or die($db->errorInfo()[2]); 
    //echo "<a href='listar-plano-de-contas.php'>Voltar a Listagem </a>"; 

    //echo $idUsuario;
    //Redirect("lancamentos-campo.php?id=".$idUsuario,true); 



        if ($_GET['form'] == 'useredit'){
            die("<script>location.href = 'editar-usuarios.php?id={$id}'</script>");
        }
    


    die("<script>location.href = 'follow-up.php?id={$id}'</script>");

    } 
    
   

}



?>

<!-- TITULO e cabeçalho das paginas  -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            
            <small><b>Contatos realizados</b> <br> </small>
        </h1>
        <h3>
        <ol class="breadcrumb">

            <li class="active">
                <i class="fa fa-user"></i> <?php echo($row['Nome']);?>
                <i class="fa fa-phone"></i> <?php echo($row['Telefone'] ." " .$row['Telefone1']." " .$row['Celular']." " .$row['Celular1'] );?>
                <i class="fa fa-envelope "></i> <?php echo($row['Email']);?>
            </li>
        </ol>
    </h3>
    </div>
</div>
                


<form role="form" action='' method='POST' enctype="multipart/form-data"> 
<div class="row">

<div class="col-lg-8">

    <div class="form-group">
        <label>Text area</label>
        <textarea class="form-control" id="txtconversa" name="txtconversa" rows="6"></textarea>
    </div>

</div>




<div class="col-lg-4">
        <div class="form-group">
            <label>Canal</label>  <br>          
            <select class="form-group" id="sCanal" name="sCanal">
              <option value="Telefone">Telefone</option>
              <option value="Email">Email</option>
              <option value="Pessoalmente">Pessoalmente</option>
              <option value="Whatsapp">Whatsapp</option>
            </select>
        </div>
       
</div>
</div>

<div class="row">
    <div class="col-lg-12">
        <input class="btn btn-lg btn-success" type='submit' value='Salvar ' />   
        <input class="btn btn-lg btn-info" type='submit' value='Voltar' onclick='history.back(-1)' />   
        <input type='hidden' value='1' name='submitted' />                                           
    </div>
    <div class="col-lg-3">                       
        

        
    </div>    
</div>  

</form>               

<div class="row">
    <div class="col-lg-12">
        <h3> Histórico de conversas</h3>
        <?php 

        //echo " <textarea style='height:100% !important;' readonly hei class='form-control'>".html_entity_decode($row['Follow'])."</textarea>"
        echo " <label>".nl2br($row['Follow'])."</label>";
        echo "<hr>";
        //echo ;  ?>



    </div>
    
</div>  



<?php include("footer.php")    ; ?>

<script type="text/javascript">

$(document).ready(function(){
  // Configuração padrão.
  //$("#currency").maskMoney();

  // Configuração para campos de Real.
  $("#Valor").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
  $("#ValorOriginal").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});

  // Configuração para mudar a precisão da máscara. Neste caso a máscara irá aceitar 3 dígitos após a virgula.
  //$("#precision").maskMoney({precision:3})
    

});

$("document").ready(function() {
    setTimeout(function() {
        $("#txtconversa").trigger('click');
    },10);
});

</script>
