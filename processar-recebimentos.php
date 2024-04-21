<?php 

session_start();
if($_SESSION['logado'] <> "S"){

    //header("login.php");
    echo "<script language='JavaScript' type='text/JavaScript'> <!--
        window.location='login.php';
        //-->
        </script>";


}
//include("header.php")    ;


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

<h1>  </h1>

<?php
$tituloPrincipal = "Banco Itau ";
$tituloSecondario = "Processamento de arquivo de retorno";
$navPagina = "Ofertas Pastorais";
?>
	<!-- TITULO e cabeçalho das paginas  -->
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last mb-5">
                    <h3><img src="itau-logo.png" width="100" height="100"> <?=$tituloPrincipal?><br><br>
                    <small><?=$tituloSecondario?></small></h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?=$navPagina?></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- /.row -->



                <form id="formulario" method="post" enctype="multipart/form-data" action="upload.php">
                  <div class="row">
                      <div class="col-lg-12">
                              
                              <div class="form-group">
                                  <label>Escolha o arquivo de retorno para processar</label>
                                  <br><br>
                                  <input id="imagem" name="imagem" type="file">

                                  
                              </div>                        

                      </div>

                   
                  </div>


                </form>

                <div id="visualizar">
                


                </div>


               
<?php include("footer.php")    ; ?>

<script type="text/javascript"> 
//<![CDATA[

    // insert teh codez


$(document).ready(function(){ 
 

  /* #imagem é o id do input, ao alterar o conteudo do input execurará a função baixo */ 
  $('#imagem').change(function(){ 
    
    //alert('Teste');

    $('#visualizar').html('<img src="ajax-loader.gif" alt="Enviando..."/> Enviando...'); 
    /* Efetua o Upload sem dar refresh na pagina */
     


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


/*
     $('#formulario').ajaxForm({ 
      target:'#visualizar' 

      // o callback será no elemento com o id #visualizar 
    }).submit(); 

*/



   }); 
}) 

//]]>
</script>

