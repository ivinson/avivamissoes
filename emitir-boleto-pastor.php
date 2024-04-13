<?php include("header-wp.php")    ;
      include('config.php'); 
 ?>
<style>


h2 {
    background-color: #449d44;
    color: white;
}

h4 {
    background-color: #5bc0de;
    color: black;
}

.btn-lg, .btn-group-lg>.btn {

  color : black !important;
  font-size: 26px !important;
}


#txtValor{


}
</style>


                <!-- TITULO e cabeçalho das paginas  -->
                <div id="rowEmissao" class="row">

                  <div class="col-lg-6">

                    <img src="logo.png">
                    <br> 
                      Espaço para emissão de oferta de missões 

                  </div>


                    <div class="col-lg-10">
                        <h2 > Escolha sua região   </h2>

                        <select  class="form-control input-lg" id="selectRegiao"  
                        name="selectRegiao" class="chosen-select"  >
                        <?php               
                        
                            $resultSelect = $db->query("  select '0' as id,'Escolha uma Regiao' as Nome, '' as ordem
                                                              union
                                                           Select id, Ltrim(Nome), ordem from regioes r
                                                            where id not in (12,2)
                                                              
                                                                  order by ordem asc

                                                        ")->results(true) or trigger_error($db->errorInfo()[2]); 
                            foreach($resultSelect as $rowOption ){ 
                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                              echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                          } 
                          
                          ?> 


                        </select> 


                    </div>

                    <div  id="dvCampos" style="display:none !Important;" class="col-lg-10">                    
                        <h2>  Escolha seu campo </h2>

                          



                      <div id="divCampos" >


                      </div>

                      <h2> Valor</h2> 
                      <input class="form-control input-lg"  id='txtValor' type='text' name='txtValor2' value=""/>


                      <label> Referente ao mês </label>
                      <select class="form-control input-lg" id='selectMes'>
                              <option value='0' >Escolha o mês</option>
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
                      <select class="form-control input-lg" name='ano' id='selectAno' onChange='funcMostraBotao();'>
                              <option value='0'>Selecione ano</option>"                              
                              <option value='2007'>2007</option>
                              <option value='2008'>2008</option>
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
     
                      <div  lass="col-lg-4">
                               

                          <section id="tables">                                                                
                            

                            <section id="buttons">
                              <div style="color:gray;" id="divFormulario"></div>
                              
                              <input class="form-control btn-lg btn-info" type="button" id="btnEmitir" 
                              value="Gerar boleto" style="display:block; display:block;padding-top: 1px;" 
                              onClick="funcEmiteBoleto();"/> 
                            </section>
                          </section> 

                      </div>

                    </div>                                        


                </div> <!-- Final da linha -->

                <div id="divConfirmacao" style="display:none;">
                  <h2> Boleto emitido com sucesso!</h2>
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



  if(fUser == "0") {

    alert('Escolha seu campo por favor.');
    return;    
  }



  if(fValor == "") {

    alert('Digite um valor');
    return;    
  }




  if(fMesRef == "0") {

    alert('Escolha um Mes');
    return;    
  }


  if(fAnoRef == "0") {

    alert('Escolha um Ano');
    return;    
  }


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

  // Configuração para campos de Real.
  $("#txtValor").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
});

</script>                