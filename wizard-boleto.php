<?php include('config.php');  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="robots" content="noindex">

    <title>Emissão de boletos IEAB</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
    <style type="text/css">

body{ 
    margin-top:40px; 
}


#section1 {
    height: 90%; 
    width:100%;
    display:flex;
    align-items: center;
    justify-content: center;
}

#divConfirmacao {
    height: 90%; 
    width:100%;
    text-align:center;
    align-items: center;
    justify-content: center;
    color: green;
}

.img-responsive {
    margin: 0 auto;
}
.stepwizard-step p {
    margin-top: 20px;
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 25px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;

}

.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 50px;
  height: 50px;
  text-align: center;
  padding: 10px 0;
  font-size: 20px;
  line-height: 1.428571429;
  border-radius: 30px;
}

.radio-group label {
   overflow: hidden;
} .radio-group input {
    /* This is on purpose for accessibility. Using display: hidden is evil.
    This makes things keyboard friendly right out tha box! */
   height: 1px;
   width: 1px;
   position: absolute;
   top: -10px;
} .radio-group .not-active  {
   color: #3276b1;
   background-color: #fff;
}




</style>
    <script src="//code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
   
</head>
<body>


<div >
<img class="img-responsive" src="http://www.avivamissoes.com.br/wp-content/uploads/2016/04/Logo.png"> 
</div>

<div  id="divConfirmacao">
    <img heigth='300' width='300' src='checkmark.gif' /> 
    <h1>Obrigado! </h1> 
    <h3> <a href="wizard-boleto.php"> Clique aqui <a> para emitir outro boleto, ou feche essa janela.</h3>
</div>


<div class="container" id="containerdv">

<div class="section1"  id="section1">
<h4>Emissão de ofertas de missões</h4>
</div>

<div class="stepwizard">
    <div class="stepwizard-row setup-panel">
        <div class="stepwizard-step">
        <input type="hidden" id="hdDoc" name="hdDoc" value="" />
            <a href="#step-1" type="button" class="btn btn-primary btn-circle">
                <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
            </a>
            <p>Dados Cadastrais</p>
        </div>
        <div class="stepwizard-step">
            <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">
                <span class="glyphicon glyphicon-barcode" aria-hidden="true"></span>
            </a>
            <p>Dados do Boleto</p>
        </div>
        <div class="stepwizard-step">
            <a id="btn-step3" href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">
                <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
            </a>
            <p>Confirmação</p>
        </div>
    </div>
</div>

<form role="form" action="wizard-boleto.php" method="post">
    <div class="row setup-content" id="step-1">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3> Dados Cadastrais</h3>
                <div class="form-group">
                    <label class="control-label">Região</label>
                    <select  class="form-control" required="required" id="selectRegiao"  
                        name="selectRegiao" class="chosen-select"  >
                        <?php                                       
                            $resultSelect = $db->query("  select '0' as id,'Escolha uma Regiao' as Nome, '' as ordem
                                                              union
                                                           Select id, Ltrim(Nome), ordem from regioes r
                                                            where id not in (12,2)
                                                              
                                                                  order by ordem asc

                                                    ") or trigger_error($db->errorInfo()[2]); 
                        foreach($resultSelect as $rowOption ){ 
                        foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                          echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                      } 
                      
                      ?> 


                    </select> 




                
                </div>
                <div id="dvContainerCampos" class="form-group">
                    <label class="control-label">Campo</label> 
                    <div id="dvCamposZ3"></div>
                </div>

                <div id="dvContainerCNPJ" class="form-group">
                                   
                 <div class="input-group">
                    <div class="btn-group radio-group">
                       <label class="btn btn-primary active">CNPJ 
                       <input type="radio" id="rdCNPJ" value="CNPJ" name="tipo" ></label>
                       <label class="btn btn-primary not-active">CPF 
                       <input id="rdCPF" type="radio" value="CPF" name="tipo"></label>
                    </div>
                 </div>
               
                <div id="dvViewCNPJ" >
                    
                    <input maxlength="100" type="text" required="required"  class="form-control" id="CNPJ" name="CNPJ"  placeholder="Insira o CNPJ" />
                    <div id="alertCNPJ" class="alert alert-danger">
                      <strong>CNPJ ou CPF Obrigatório!</strong> A partir de 2017, a FEBRABAN obriga a constar no documento de cobrança e no registro bancário pela internet o CPF ou CNPJ do pagador (sacado).
                    </div>
                </div>
                <div id="dvViewCPF" >
                <input maxlength="100" type="text" required="required"  class="form-control" id="CPF" name="CPF" placeholder="Insira o seu CPF" />
                    <div id="alertCPF" class="alert alert-danger">
                      <strong>CNPJ ou CPF Obrigatório!</strong> A partir de 2017, a FEBRABAN obriga a constar no documento de cobrança e no registro bancário pela internet o CPF ou CNPJ do pagador (sacado).
                    </div> 
                    
                </div>

                </div>


                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-2">
        <div class="col-xs-12">
            <div class="col-md-12">
                <h3> Dados do Boleto</h3>
                <div class="form-group">
                    <label class="control-label">Valor</label>
                    <input maxlength="200" type="text" required="required" class="form-control" placeholder="Digite o Valor da oferta" id="txtValor" name="txtValor" />
                </div>
                <div class="form-group">
                            
                <select class="form-control " id='selectMes' name="mes">
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
                </div>

                <div class="form-group">
                <select class="form-control " name='ano' id='selectAno' >
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

    
        <div class="form-group">
          <br>
            <label>Tipo oferta</label>
            <span class="badge badge-info"> Nova opção</span>
            <select name='idprojeto' id='idprojeto' class="form-control"   size="1">
               
                <option selected value="2">Oferta do mês</option>
                <option value="3">Campanha ProRec até 2016</option>
            </select>       
        </div>
    


                </div>
                
                <button class="btn btn-primary nextBtn btn-lg pull-right" type="button" >Next</button>
                <button class="btn btn-primary prevBtn btn-lg pull-right" type="button" >Anterior</button> 
            </div>
        </div>
    </div>
    <div class="row setup-content" id="step-3">
        <div class="col-xs-12">
            <div class="col-md-12">
               
                <div id="dvConfirmaBoleto" class="panel panel-default">
                  <!-- Tela de confirmação -->
                </div>
            </div>
        </div>
    </div>
</form>
</div>
	<script type="text/javascript">
	$(document).ready(function () {

    var navListItems = $('div.setup-panel div a'),
            allWells = $('.setup-content'),
            allNextBtn = $('.nextBtn');
            allPrevBtn = $('.prevBtn');

    allWells.hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
                $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-primary').addClass('btn-default');
            $item.addClass('btn-primary');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allNextBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input[type='text'],input[type='url'],select"),
            isValid = true,
            confirm = getConfirm() ;




      if (curStepBtn == "step-1"){

                var fDoc = $('input[name=tipo]:checked').val();
                if((fDoc == 'CNPJ') && ($('#CNPJ').val()=== "")){

                  alert("Preencha por favor um CNPJ.");
                   
                   //$("#hdDoc").val("CNPJ");
                }
                if((fDoc == 'CPF') && ($('#CPF').val()=== "")){

                  alert("Preencha por favor um CPF.");
                   
                   //$("#hdDoc").val("CNPJ");
                }


      }

    //Verifica se ja existe um boleto para esse periodo com esse 
    //valor         
    if (curStepBtn == "step-2"){
        var id     = $("#selectUsuario").val();
        var valor  = $('#txtValor').val();
        var mes    = $('#selectMes').val();
        var ano    = $('#selectAno').val();
        var campo  = $('#selectUsuario option:selected').text();

        var cpfcnpj = '';
        var fDoc = $('input[name=tipo]:checked').val();
        if(fDoc == 'CNPJ'){
           cpfcnpj = $('#CNPJ').val();
           $("#hdDoc").val("CNPJ");
        }else{
           cpfcnpj = $('#CPF').val();
           $("#hdDoc").val("");
        }


        $.ajax({    
                //Busca no banco boletos com esses parametros
                type: "GET",
                url: "get-boletos-ref.php?id="+id +"&valor="+valor + "&mes="+mes + "&ano="+ano+"&function=getBoletos&campo=" + campo + "&cnpj="+ cpfcnpj,          
                dataType: "html",   //HTML PRA CARREGAR                
                success: function(response){   

                    console.log("get-boletos-ref.php?id="+id +"&valor="+valor + "&mes="+mes + "&ano="+ano+"&function=getBoletos&campo=" + campo + "&cnpj="+ cpfcnpj);
                    console.log(response);

                    $("#dvConfirmaBoleto").html(response); 
                }
              });  

            



    }       



    allPrevBtn.click(function(){
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
            prevStepWizard.removeAttr('disabled').trigger('click');

        });        

        $(".form-group").removeClass("has-error");
        for(var i=0; i<curInputs.length; i++){
            if (!curInputs[i].validity.valid){
                isValid = false;
                $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid)
            nextStepWizard.removeAttr('disabled').trigger('click');
        });

        $('#dvContainerCNPJ').hide();
        $('#dvContainerCampos').hide();
        $('#dvViewCPF').hide();
        $('#dvViewCNPJ').show('slow');
        $("#dvViewCPF").removeClass("has-error");  
        $("#CPF").removeAttr('required');
        $('#alertCNPJ').hide();
        $('#divConfirmacao').hide();
        
        
        $('div.setup-panel div a.btn-primary').trigger('click');
});


//Monta Painel com informações 
//de confirmação


function view_Campos( fregiao){

        $('#dvContainerCampos').show('show');
        $("#dvCamposZ3").show('slow');
        //$("#dvContainerCNPJ").show('slow');
        //MONTA TELA
        $.ajax({    
                //CRIA AJAX PRA CARREGAR A PAGINA
                type: "GET",
                url: "monta-select-campos.php?id="+fregiao,             
                dataType: "html",   //HTML PRA CARREGAR                
                success: function(response){                    
                    $("#dvCamposZ3").html( response); 
                }
              });         
}

$(function() {
    // Input radio-group visual controls
    $('.radio-group label').on('click', function(){
    $(this).removeClass('not-active').siblings().addClass('not-active');
    });
});






$("input:radio[name=tipo]").click(function() {
    var value = $(this).val();
    //alert("value : " + value);

    if(value=='CNPJ'){
        $("#dvViewCNPJ").show();
        $("#dvViewCPF").hide(); 
        $("#dvViewCPF").removeClass("has-error");  
        $("#CPF").removeAttr('required');


    }else{
        $("#dvViewCNPJ").hide();
        $("#dvViewCPF").show();
        $("#dvViewCNPJ").removeClass("has-error");  
        $("#CNPJ").removeAttr('required');        
    }
});

$(document).ready(function(){
  // Configuração para campos de Real.
  $("#txtValor").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
});

</script>
</body>
</html>

<script src="./js/jquery.maskMoney.min.js" type="text/javascript"></script>

<script type="text/javascript">
    
//-----------------------------------------------
//FUNCOES AUXILIARES
//-----------------------------------------------
function OpenInNewTab(url) {
  var win = window.open(url, '_blank');
  win.focus();
}
   
//Emite novo boleto
function funcEmiteBoleto(){
    //Carrega automaticamente a tela de colocar o valor, data de referencia
    //para emir o boleto
    var fUser     = $("#selectUsuario").val();
    var fValor    = $('#txtValor').val();
    var fMesRef   = $('#selectMes').val();
    var fAnoRef   = $('#selectAno').val();
    /**
     * Para prorec
     */
    var fidProjeto = $('#idprojeto').val(); 

    var cpfcnpj = '';
    var fDoc = $('input[name=tipo]:checked').val();
    if(fDoc == 'CNPJ'){
       cpfcnpj = $('#CNPJ').val();
    }else{
       cpfcnpj = $('#CPF').val();
    }

    var url = "boletos/boleto_itau_wizard.php?id="+fUser + "&Valor="+fValor+"&Mes="+fMesRef+"&Ano="+fAnoRef+"&CNPJ="+cpfcnpj+"&projeto="+fidProjeto ;


  if(fUser!=""){
        OpenInNewTab(url);
        $('#containerdv').hide();
        $("#divConfirmacao").show();
    }
  //Esconde as opções de emissão
  //$("#tables").hide();
  //$("#divCampos").hide();
  //$("#dvTitle").hide();
  
  
  
   // Mostra mensagem de Emitido com sucesso


  //alert("---");
};

//
function funcReimprimirBoleto(){
    //Carrega automaticamente a tela de colocar o valor, data de referencia
    //para emir o boleto
    var fUser     = $("#selectUsuario").val();
    var fValor    = $('#hdValor2Via').val().replace(".", ",");
    
    var fMesRef   = $('#selectMes').val();
    var fAnoRef   = $('#selectAno').val();

    var fNN       = $('#hdNN').val();
    var fCodBarra = $('#hdCODBARRA').val();

    //alert(fValor);

    var cpfcnpj = '';
    var fDoc = $('input[name=tipo]:checked').val();
    if(fDoc == 'CNPJ'){
       cpfcnpj = $('#CNPJ').val();
    }else{
       cpfcnpj = $('#CPF').val();
    }

    var url = "boletos/boleto_itau_wizard.php?id="+fUser + "&Valor="+fValor+"&Mes="+fMesRef+"&Ano="+fAnoRef+"&CNPJ="+cpfcnpj+"&function=2via&nn="+ fNN + "&codigobarra="+fCodBarra +"&projeto="+fidProjeto;


  if(fUser!=""){
        OpenInNewTab(url);
        $('#containerdv').hide();
        $("#divConfirmacao").show();
    }
  //Esconde as opções de emissão
  //$("#tables").hide();
  //$("#divCampos").hide();
  //$("#dvTitle").hide();
  
  
  
   // Mostra mensagem de Emitido com sucesso


  //alert("---");
};




//quando escolher a Regiao
$('#selectRegiao').on('change', function() {
  view_Campos( $('#selectRegiao').val());
});

//quando escolher o Campo
$(document.body).on('change','#selectUsuario',function(){ 
     getCNPJ();
});


function setDocVisible(doc, bool){

  $("#dvViewCNPJ").hide()
  $("#dvViewCPF").hide()


if(bool == true){
     $('#dvView'+doc).show();
     $("#dvContainer"+doc).show('slow');
     $('#alert'+doc).show('slow');
     $("#rd"+doc).click()
 }
 
    $('#dvContainerCNPJ').show('slow');
}


function getCNPJ(){
       id = $('#selectUsuario').val();
        //console.log(id);
        //Pega CNPJ do Campo
        $.ajax({    
                //CRIA AJAX PRA CARREGAR A PAGINA
                type: "GET",
                url: "get-cnpj.php?id="+id,             
                dataType: "html",   //HTML PRA CARREGAR                
                success: function(response){ 
                    var retorno = response.replace("#CNPJ#", "");
                        retorno = retorno.replace("#CPF#", "");            
                    //Se for CNPJ
                    if (response.indexOf("#CNPJ#") >= 0){
                        setDocVisible("CNPJ",true);
                        $("#CNPJ").val(retorno); 
                    }else 
                    //Se for CPF
                    if (response.indexOf("#CPF#") >= 0){
                         setDocVisible("CPF",true);
                         $("#CPF").val(retorno);
                    }
                }
              });  
}

function getConfirm(){
    data = $('#selectMes').val() + '/'+ $('#selectAno').val();
    $('#tdValor').html($('#txtValor').val());
    $('#tdCampo').html($('#selectUsuario option:selected').text());
    $('#tdData').html(data);

    var fDoc = $('input[name=tipo]:checked').val();
    //alert('fdcod = ' + fDoc);
    if(fDoc == 'CNPJ'){
        $('#tdCNPJ').html($('#CNPJ').val());
    }else{
        $('#tdCNPJ').html($('#CPF').val());
    }


//alert('getConfirm ok');

return true;
}



</script>