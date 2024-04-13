<?php include("header-wp.php")    ;
      include('config.php'); 
 ?>


                <!-- TITULO e cabeçalho das paginas  -->
                <div id="rowEmissao" class="row">
                    <div class="col-lg-4">
                        <h1 >
                           Escolha sua região                            
                        </h1>

                        <select  class="form-control" id="selectRegiao"  
                        name="selectRegiao" class="chosen-select"  >
                        <?php               
                        
                          $resultSelect = $db->query("select * from regioes where id <> 2 
                          union
                          select '0','Selecione um Campo...','','' from regioes where  id <> 2 

                          order by id")->results(true) or trigger_error($db->errorInfo()[2]); 
                            foreach($resultSelect as $rowOption ){ 
                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                              echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Abreviacao']) ." - ".nl2br( $rowOption['Nome']) ."</option>";                                 
                          } 
                          
                          ?> 


                        </select> 


                    </div>

                    <div  id="dvCampos" style="display:none !Important;" class="col-lg-4">                    
                        <h1>  Escolha seu campo </h1>

                          



                      <div id="divCampos" >


                      </div>

                      <h2> Valor</h2> 
                      <input class="form-control"  id='txtValor' type='text' name='txtValor2' value=""/>


                      <label> Referente ao mês </label>
                      <select class="form-control" id='selectMes'>
                              <option>Escolha o mês</option>
                              <option value='01'>Janeiro</option>
                              <option value='02'>Fevereiro</option>
                              <option value='03'>Março</option>
                              <option value='04'>Abril</option>
                              <option value='05'>Maio</option>
                              <option value='06'>Junho</option>
                              <option value='07'>Julho</option>
                              <option value='08'>Agosto</option>
                              <option value='09'>Setembro</option>
                              <option value='10'>Outubro</option>
                              <option value='11'>Novembro</option>
                              <option value='12'>Dezembro</option>
                            </select>

                      <label> Referente ao ano </label>
                      <select class="form-control" name='ano' id='selectAno' onChange='funcMostraBotao();'>
                              <option>Selecione ano</option>"                              
                              <option value='2009'>2009</option>
                              <option value='2010'>2010</option>
                              <option value='2011'>2011</option>
                              <option value='2012'>2012</option>
                              <option value='2013'>2013</option>
                              <option value='2014'>2014</option>
                              <option value='2015'>2015</option>
                              <option value='2016'>2016</option>
                              <option value='2017'>2017</option>
                              <option value='2018'>2018</option>
                              <option value='2019'>2019</option>                             
                      </select>
     
                      <div class="panel-body">
                               

                          <section id="tables">                                                                
                            <h3 id="h3titulo" > </h3>

                            <section id="buttons">
                              <div style="color:gray;" id="divFormulario"></div>
                              <input class="form-control" type="button" id="btnEmitir" 
                              value="Gerar boleto" style="display:none;" 
                              onClick="funcEmiteBoleto();"/>                                  
                            </section>
                        </section> 

                        </div>

                    </div>                                        


                </div> <!-- Final da linha -->

                <div id="divConfirmacao" style="display:none;">
                  <h3> Boleto emitido com sucesso!</h3>
                  <h4> Obrigado por usar nosso novo recurso. </h4>
                </div>                
     

<?php include("footer.php")    ; ?>

<!-- 

S C R I P T S 
================================================
================================================

 -->
<script src="./js/jquery.maskMoney.min.js" type="text/javascript"></script>
<script type="text/javascript">

$('#selectRegiao').on('change', function() {
  view_Campos( $('#selectRegiao').val());
});





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
  //$("#tables").hide();
  //$("#divCampos").hide();
  //$("#dvTitle").hide();
  $("#rowEmissao").hide();
  
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



$(document).ready(function(){
  // Configuração padrão.
  //$("#currency").maskMoney();

  // Configuração para campos de Real.
  $("#txtValor").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});

  // Configuração para mudar a precisão da máscara. Neste caso a máscara irá aceitar 3 dígitos após a virgula.
  //$("#precision").maskMoney({precision:3})
});

</script>                