<?php include("header.php")    ;
      include('config.php'); 
 ?>


                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Boletos
                            <small>Ofertas de Campo Eclesiasticos</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-print"></i> Emissão de boletos por campo
                            </li>
                        </ol>
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">

                    <div id="dvRegioes" class="col-sm-4">
                        <div class="list-group">
                            <a href="#" class="list-group-item active">
                                <h4 class="list-group-item-heading">Escolha sua região</h4>
                                <p class="list-group-item-text">Somos divididos em 9 regiões eclesiásticas, e mais 2 regiões missionárias. Escolha a sua abaixo</p>
                            </a>
                            <a href="javascript: view_Campos(1);" class="list-group-item">
                                <h4 class="list-group-item-heading">    Missões Nacionais    </h4>                                
                            </a>
                            <a href="javascript: view_Campos(2);" class="list-group-item">
                                <h4 class="list-group-item-heading">    Missões Transculturais   </h4>                                
                            </a>
                            <a href="javascript: view_Campos(3);" class="list-group-item">
                                <h4 class="list-group-item-heading">    Nordeste     </h4>                                
                            </a>
                            <a href="javascript: view_Campos(4);" class="list-group-item">
                                <h4 class="list-group-item-heading">    Norte    </h4>                                
                            </a>
                            <a href="javascript: view_Campos(5);" class="list-group-item">
                                <h4 class="list-group-item-heading">  Sudeste 1  </h4>                                
                            </a>
                            <a href="javascript: view_Campos(6);" class="list-group-item">
                                <h4 class="list-group-item-heading">  Sudeste 2  </h4>                                
                            </a>
                            <a href="javascript: view_Campos(7);" class="list-group-item">
                                <h4 class="list-group-item-heading">  Sudeste 3  </h4>                                
                            </a>
                            <a href="javascript: view_Campos(8);" class="list-group-item">
                                <h4 class="list-group-item-heading">Sul 1</h4>                                
                            </a>
                            <a href="javascript: view_Campos(9);" class="list-group-item">
                                <h4 class="list-group-item-heading">Sul 2</h4>                                
                            </a>
                            <a href="javascript: view_Campos(10);" class="list-group-item">
                                <h4 class="list-group-item-heading">Sul 3</h4>                                
                            </a>
                            <a href="javascript: view_Campos(11);" class="list-group-item">
                                <h4 class="list-group-item-heading">Centro Oeste</h4>                                
                            </a>
                        </div>
                    </div>    


                    <div  id="dvCampos" style="display:none !Important;" class="col-lg-8">

                        <div id="dvTitle" class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Escolha seu Campo</h3>
                            </div>
                            <div id="divCampos" class="panel-body">
                                                         


                            </div>
                        </div>



                    <div class="panel panel-success">
                            <div class="panel-heading">
                                <h3 class="panel-title">Dados da oferta</h3>
                            </div>

                        <div class="panel-body">
                               
                          <div id="divConfirmacao" style="display:none;">
                            <h3> Boleto emitido com sucesso!</h3>
                            <h4> Após o pagamento iremos informar ao campo por celular ou email.</h4>
                          </div>
                          <section id="tables">                                                                
                            <h3 id="h3titulo" >Oferta de missões campo missionário </h3>

                            <section id="buttons">
                              <div style="color:gray;" id="divFormulario"></div>
                              <input type="button" id="btnEmitir" value="Gerar boleto" style="display:none;" onClick="funcEmiteBoleto();"/>                                  
                            </section>
                        </section> 

                        </div>

                    </div>


                    </div>                                        


                </div> <!-- Final da linha -->
               

<?php include("footer.php")    ; ?>

<!-- 

S C R I P T S 
================================================
================================================

 -->

<script type="text/javascript">

//
function funcEmiteBoleto(){



  //Carrega automaticamente a tela de colocar o valor, data de referencia
  //para emir o boleto
  var fUser   = $("#selectUsuario").val();
  var fValor  = $('#txtValor').val();
  var fMesRef = $('#selectMes').val();
  var fAnoRef = $('#selectAno').val();

  //Abre nova TAB com boleto
  OpenInNewTab("boletos/boleto_itau.php?id="+fUser + "&Valor="+fValor+"&Mes="+fMesRef+"&Ano="+fAnoRef);
  //Esconde as opções de emissão
  $("#tables").hide();
  $("#divCampos").hide();
  $("#dvTitle").hide();
  
   // Mostra mensagem de Emitido com sucesso
  $("#divConfirmacao").show();

  //alert("---");
};



//-----------------------------------------------
//FUNCOES AUXILIARES
//-----------------------------------------------
function OpenInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}


 function funcMostraBotao(){

      $('#btnEmitir').css('display', 'block');

}
  

function view_Campos( fregiao){
      
        $('#dvCampos').show('show');
        $("#divCampos").show('slow');
        $("#dvTitle").show('slow');

        //MONTA TELA
        $.ajax({    
                //CRIA AJAX PRA CARREGAR A PAGINA
                type: "GET",
                url: "monta-select-campos.php?id="+fregiao,             
                dataType: "html",   //HTML PRA CARREGAR                
                success: function(response){                    
                    $("#divCampos").html( "<br>"+response); 
                }
              });         
}

//
function getMontaformulario(){



        //Carrega automaticamente a tela de colocar o valor, data de referencia
        //para emir o boleto
        var fUser = $("#selectUsuario").val();

        //MONTA TELA
        $.ajax({    
                //CRIA AJAX PRA CARREGAR A PAGINA
                type: "GET",
                url: "montaConfirmacaoBoleto.php?id="+fUser,             
                dataType: "html",   //HTML PRA CARREGAR                
                success: function(response){                    
                    $("#divFormulario").html( "<br>"+response); 
                }
              });


  $("#tables").show();
  $("#divCampos").show();
  $("#dvTitle").show();
  
   // Mostra mensagem de Emitido com sucesso
  $("#divConfirmacao").hide();



}
//================================================

</script>                