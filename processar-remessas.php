<?php 

#TODO = listar remessas para gerar hoje

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

  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<style type="text/css">
.alert span {
  vertical-align: middle;
  line-height:normal;
}

.alert > div {
  line-height: 34px;
}
</style>

<!-- TITULO e cabeçalho das paginas  -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"> 
          <img src="itau-logo.png" width="100" height="100">
          Banco Itau 
          <small>Gerar de arquivo de remessas</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Ofertas Pastorais | Remessas
            </li>
        </ol>
    </div>
</div>

<!-- /.row -->

  <div class="row">
      <div class="col-lg-12">
  
              
              <div class="form-group">

              <label>Inicio </label>
              <input type="text" id="dtInicio">
              <label>Fim</label>
              <input type="text" id="dtFinal">

              <a id="btn" href=""  class="btn btn-default">
              <span class="glyphicon glyphicon-cloud-download"></span> Gerar remessa </a>    



               <div id="viewDiv" > </div>       
              </div>                        

      </div>
  </div>


  <div class="row">
      <div class="col-lg-12">
       


      </div>
  </div>



               
<?php include("footer.php")    ; ?>


  <script>





  $( function() {
      $( "#dtInicio").datepicker({ dateFormat: 'yy-mm-dd' });
      $( "#dtFinal").datepicker({ dateFormat: 'yy-mm-dd' });
  } );



$( "#btn" ).click(function() {


  var dtinicio =  $('#dtInicio').datepicker({ dateFormat: 'yy-mm-dd' }).val();
  var dtfim    =  $('#dtFinal').datepicker({ dateFormat: 'yy-mm-dd' }).val();



    $('#viewDiv').html('<img src="http://d13yacurqjgara.cloudfront.net/users/12755/screenshots/1037374/hex-loader2.gif" alt="Gerando as remessas ..."/> Gerando as remessas ...'); 

            //MONTA TELA
        $.ajax({    
                //CRIA AJAX PRA CARREGAR A PAGINA
                type: "GET",
                url: "download-remessa.php?dtinicio="+dtinicio+"&dtfim="+dtfim,             
                dataType: "html",   //HTML PRA CARREGAR                
                success: function(response){                    
                    $("#viewDiv").html( "<br>"+response); 

                    //alert();

                }
              });    


    //alert('aaaa');
//window.location.href = "download-remessa.php?dtinicio="+dtinicio+"&dtfim="+dtfim;
return false;
    //$( "#formulario" ).submit();
});




  </script>