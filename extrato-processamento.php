<?php
session_start();
if($_SESSION['logado'] <> "S"){

    //header("login.php");
    echo "<script language='JavaScript' type='text/JavaScript'> <!--
        window.location='login.php';
        //-->
        </script>";


}
  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
      
?>

<style type="text/css">
.Vencida{    
    width: 110px;
    padding: 1px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: red;
    color: white;
}

.AVencer{    
    width: 110px;
    padding: 1px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: green;
    color: white;
}

.Recebida{    
    width: 110px;
    padding: 2px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: blue;
    color: white;
}
</style>

<!-- TITULO e cabeçalho das paginas  -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"> <img src="https://upload.wikimedia.org/wikipedia/pt/d/d0/Bradesco_logo.png" width="150" height="100">
            
            <small>Processamento de Extratos Bradesco</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Ofertas Pastorais
            </li>
        </ol>
    </div>
</div>

<!-- /.row -->
<form id="formulario" method="post" enctype="multipart/form-data" action="upload-extrato.php">
  <div class="row">
      <div class="col-lg-12">
              
              <div class="form-group">
                  <label>Escolha o arquivo de extrato para processar</label>
                  <br><br>
                  <input class="btn btn-warning" id="imagem" name="imagem" type="file">
                  <input type='hidden' value='1' name='submitted' />  
                  <br>     
                  <input class="btn btn-danger" type="submit" value="Importar">            
              </div>                        

      </div>
  </div>
</form>

<div id="visualizar">



</div>

<?php include("footer.php")    ; ?>

<script type="text/javascript"> 

/*
$(document).ready(function(){ 
 

 
  $('#imagem').change(function(){ 
    
    //alert('Teste');

    $('#visualizar').html('<img src="ajax-loader.gif" alt="Enviando..."/> Enviando...'); 
    
     


        $("#formulario").ajaxForm({

           target:'#visualizar' ,

            success: function(response, textStatus, xhr, form) {
                console.log("in ajaxForm success");

                if (!response.length || response != 'good') {
                    console.log("bad or empty response");
                    return xhr.abort();
                }
                console.log("All good. Do stuff");
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
                console.log("in ajaxForm error");
            },
            complete: function(xhr, textStatus) {
                console.log("in ajaxForm complete");
            }
        }).submit();




   }); 
}) 
*/
</script>

