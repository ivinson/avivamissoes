<?php session_start();

//Verificação inicial e log de acesso sem login
if($_SESSION['logado'] <> "S"){

  $url=$_SERVER['REQUEST_URI'];
  include "logger.php";
  Logger("#### Acesso não autorizado ######");
  Logger("Algum usuario não identificado tentou acessar a {$url}");
  Logger("# ------------------------------------------------------> ");
  echo "<script language='JavaScript' type='text/JavaScript'> <!--
    window.location='login.php';
    //-->
    </script>";
    
  die("login.php");

}

  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
  //require('pdftohtml.php'); 
  # create and load the HTML
  //include('simple_html_dom.php');
   include "logger.php";
  

if (isset($_GET['type'])  ) {         
  if ($_GET['type'] == 'delete'){
      $id = (int) $_GET['id'];   
      $idLancamento = (int) $_GET['idLancamento']; 
      $db_>query("DELETE FROM `lancamentosbancarios` WHERE `id` = '$idLancamento' ") ;   Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] deletou a remessa {$idLancamento} do campo id={$id}.");  
      //Redirect("lancamentos-campo.php?id=".$id);
      die("<script>location.href = 'lancamentos-campo.php?id={$id}'</script>");
  }
}



if (isset($_GET['type'])  ) {         
  if ($_GET['type'] == 'reprocessamento'){
      
      $id = (int) $_GET['id'];   
      
      
      echo "REPROCESSAMENTO!!!!!!!!";
         Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] fez um reprocessamento."); 

# Verifica todos os boletos pagos e se tem lancamentos bancarios correspondentes...
# Caso contrario cria para esse campo
$resultPagos = $db->query("
  select * from contasreceber where Status = 'Pago' ;
")->results(true) or trigger_error($db->errorInfo()[2]); 

foreach($resultPagos as $rowOption){ 
  foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                                             
      ##################################################################################3
      # Cria Lancamentos bancarios caso nao tenha ocorrencia 
      $resultLancBanc = $db->query("
        select * from lancamentosbancarios where idContaReceber = {$rowOption['id']} ;
      ")->results(true) or trigger_error($db->errorInfo()[2]); 

      $countLac = 0;
      echo " boleto {$rowOption['id']} <br>";

      foreach($resultLancBanc as $rowOptionLanc){ 
        foreach($rowOptionLanc AS $key => $value) { $rowOptionLanc[$key] = stripslashes($value); }                                             
          $countLac++;
        //echo "<li ><a  href='lancamentos-campo.php?id={$id}&ano={$rowOption['Ano']}'>{$rowOption['Ano']} </a></li>";              
      }
      ##################################################################################3
      //echo $countLac;
      if ($countLac == 0){

        
      $fNN      =  $rowOption['NossoNumero'];

      $SqlInsereProcessamento = "
            INSERT INTO lancamentosbancarios
            (
            `idUsuario`,
            `Valor`,
            `TipoOrigem`,
            `DataBaixa`,
            `idProjeto`,

            `GeradoPor`,
            `BaixadoPor`,
            `idContaReceber`,           
            
            `Descricao`,
            `idContaBancaria`,
            `DataReferencia`,
            `NumeroDocumento`
            )
            VALUES
            (
            ".$rowOption['idUsuario']." ,
            ".$rowOption['Valor'].",
            'CR',
            '".$rowOption['DataEmissao']."',
            ".$rowOption['idProjeto']." ,
            ".$rowOption['GeradoPor']." ,            
            {$_SESSION['idlogado']},

            ".$rowOption['id']." ,
            'Crédito gerado por boleto bancario online Nosso Nº $fNN',
            1,
            '".$rowOption['DataReferencia']."', '$fNN');";

            //echo "<br>" . $SqlInsereProcessamento;
                
                if (! $db->query($SqlInsereProcessamento) ){
                      die( ':: Erro : '. $db->errorInfo()[2]); 
                      echo "Fase de teste lancamentosbancarios: Anote o seguinte erro!";
                    }

                echo "<br> Criado um lancamento de {$rowOption['valor']} para o boleto {$rowOption['id']}" ;


      }
  //echo "<li ><a  href='lancamentos-campo.php?id={$id}&ano={$rowOption['Ano']}'>{$rowOption['Ano']} </a></li>";              

}
}
}


      
?>

<style type="text/css">



</style>
<form  id="formulario" target="_blank"  method="post" action="pdftohtml.php">

<?php 
if (isset($_GET['id']) ) { 
                   
   $id = (int) $_GET['id'];   

    $resultSelect = $db->query("
          SELECT distinct
          year(lb.DataReferencia) as Ano 
           FROM
            lancamentosbancarios lb 
            join usuarios u on (u.id = lb.idusuario)
            where lb.idUsuario = {$id}
            and lb.TipoLancamento not in ('PENDENTE') 
            order by year(lb.DataReferencia) desc

      ")->results(true) or trigger_error($db->errorInfo()[2]); 



echo " <ul class='nav nav-tabs'>";

    ###############################################################################
    ###### Contabiliza o meses em aberto e gera um link para a proxima aba
    #Meses apenas para campos Eclesiasticos
    #
    $qtdProrec = "";
    $valorProrec = "";
    $tipoUsuario = "";
    $strQtdMesesAtrasados = "";
    $strNomePastor = "";
    $BaixadoPor = "";
    $boolProrec = "";
    $rUsuario = $db->query("  SELECT * FROM usuarios where id = {$id}
    ")->results(true) or trigger_error($db->errorInfo()[2]); 
    
    foreach($rUsuario as $rowOptionUsuario ){ 
      foreach($rowOptionUsuario AS $key => $value) { $rowOptionUsuario[$key] = stripslashes($value); }       
          $tipoUsuario = $rowOptionUsuario['idTipoUsuario'];    
          $qtdProrec   = $rowOptionUsuario['prorec_qtd_parcelas'];    
          $valorProrec = $rowOptionUsuario['prorec_valor_parcelas'];    
          //$BaixadoPor = $rowOptionUsuario['B'];   
          $strNomePastor = $rowOptionUsuario['NomePastorTitular'];   
    }

    if($tipoUsuario == 6){

        $rsMesesEmAberto =$db->query("
      
        SELECT    
        r.Nome as Regiao,  
        u.id,
        u.Nome,
        c.NomePastorTitular,
        count(u.id) as MesesEmAberto   
        , LB.id as idLancamentos 

        FROM
        lancamentosbancarios LB
        join usuarios u on (u.id = LB.idUsuario)
        join congregacoes gr on (gr.id = u.idCongregacao)
          join campos c on (c.id = gr.idCampo)
          join regioes r on  (r.id = c.idRegiao)

          where
              LB.Valor = 0 and LB.TipoLancamento in ('Regular','Inadimplente','Fechamento')               
              and u.id = {$id}     
              and LB.DataReferencia >= '2012-01-01'


                and LB.DataReferencia > u.DataInicio
                and u.idTipoUsuario <> 8 -- inativos
                and LB.idProjeto <> 3  -- Prorec nao conta
                group by
                u.id,
                u.Nome

                order by count(u.id) desc;

          ")->results(true) or trigger_error($db->errorInfo()[2]); 


          foreach($rsMesesEmAberto as $rowOptionMeses ){ 
              foreach($rowOptionMeses AS $keyMes => $valueMes) { $rowOptionMeses[$keyMes] = stripslashes($valueMes); }
                 $strQtdMesesAtrasados = $strQtdMesesAtrasados .   "<span class=\"label label-important arrowed-in\">{$rowOptionMeses['MesesEmAberto']} meses em aberto</span>";
          }       
    }
  echo "</ul>";
}    
?>

<div class="row">

<!-- <section style="background:#efefe9;">
        <div class="container">
            <div class="row"> -->
                <div class="board">
                   
                    <div class="board-inner">
                    <ul class="nav nav-tabs" id="myTab">
                    <div class="liner"></div>
                     <li class="active">
                     <a href="#home" data-toggle="tab" title="Remessas Gerais">
                      <span class="round-tabs one">
                              <i class="glyphicon glyphicon-barcode"></i>
                      </span> 
                  </a></li>

                  <li><a href="#profile" data-toggle="tab" title="Remessas em ABERTO">
                     <span class="round-tabs two">
                         <i class="glyphicon glyphicon-thumbs-down"></i>

                     </span> 

           </a>
                 </li>
                 <li><a href="#messages" data-toggle="tab" title="Acordos e Negociações">
                     <span class="round-tabs three">
                          <i class="glyphicon glyphicon-calendar"></i>
                     </span> </a>
                     </li>


                     
                     </ul></div>

                     <div class="tab-content" >
                      <div  style="padding-top: 10px ;"  class="tab-pane fade in active"  id="home">
                      


<!-- <p class="text-center"> -->

<h3 class="head text-center">Histórico de Remessas</h3>
<?php

echo "<p class=\"text-center\">";

// <!-- MONTA O CABEÇALHO COLM AS DATAS -->
// if (isset($_GET['id']) ) { 
   $id = (int) $_GET['id'];   
   //$Ano = (int) $_GET['Ano'];   

   /**
    * RETORNA os meses de pagamentos realizados 
    * @var 
    */
  $resultSelect = $db->query("
        SELECT distinct
        year(lb.DataReferencia) as Ano 
         FROM
          lancamentosbancarios lb 
          join usuarios u on (u.id = lb.idusuario)
          where lb.idUsuario = {$id}
          and lb.TipoLancamento not in ('PENDENTE') 
          order by year(lb.DataReferencia) desc

    ")->results(true) or trigger_error($db->errorInfo()[2]); 

    foreach($resultSelect as $rowOption){ 
      foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                                             
        echo "<a style='font-color :#FFFFFf !important;'  href='lancamentos-campo.php?id={$id}&ano={$rowOption['Ano']}'> <span class=\"label label-info arrowed-in-right arrowed\">{$rowOption['Ano']} </span></a>";
    }   




  echo  $strQtdMesesAtrasados; 

    // <span class="badge badge-warning">4</span>

  echo " <div class='datatable-tools'>
    <table class='table' id='tbUsuarios'>
        <thead>
            <tr>
                <th>  </th>
                <th>Emitido em</th>
                <th>Nº Documento</th>
                <th>Campo</th>
                <th>Valor</th>
                <th>Referente á </th>
                <!-- <th>Estado </th> -->
                <th></th>

            </tr>";

            //Lista os lancamentos feitos por ano selecionado
            echo "<tr>";

        if (!isset($_GET['abertos']))  { 

           $id = (int) $_GET['id']; 

           if (isset($_GET['ano']) ) { 
               $Ano = (int) $_GET['ano'];      
            } else { $Ano = date('Y');}

            
            //Lista Apenas Campos Eclesiáticos                                
            $resultSelect3 = $db->query("
                  SELECT 
                    lb.*
                    -- DATEDIFF( cr.DataEmissao, curdate()) as DiasAtraso
                    ,DATE_FORMAT(lb.DataReferencia, '%m/%Y') AS Referente
                    ,DATE_FORMAT(lb.DataBaixa, '%d/%m/%Y') AS DataEmissao
                    
                        , u.*, lb.Valor as ValorBoleto,
                    lb.id as idLancamentos

                   FROM

                    lancamentosbancarios lb 
                    join usuarios u on (u.id = lb.idusuario)

                    where lb.idUsuario = {$id}
                     and year(lb.DataReferencia) = {$Ano}
                     and lb.TipoLancamento not in ('PENDENTE') 

                     order by Referente

              ")->results(true) or trigger_error($db->errorInfo()[2]); 

                  foreach($resultSelect3 as $rowOption){ 
                    foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }     

                    if($rowOption['idProjeto'] == 3){
                       $boolProrec=  "<span class=\"label label-success arrowed \">proRec</span>";
                    }

                      $valorMySQL = $rowOption['ValorBoleto'];                                            
                      $moeda = number_format( $valorMySQL , 2, ',', '.');

                     $LinkAnexo = $rowOption['Anexos'];
                     $Anexos = "";
                     if($LinkAnexo != ""){

                      $Anexos =  " <a style='color:red;'  target='_blank' href='{$LinkAnexo}' ><i class='fa fa-paperclip'></i></a>" ;

                     }

                      echo "<tr>";                                                                                                                                              
                      echo "<td> <div  title='Esse boleto foi Recebido e 
                      \n  baixado em ". nl2br( $rowOption['DataBaixa']) ." 
                      \n . 
                      \n '  class='cCredito'>";  
                      echo "<a  id='lnkDelete' style='display:none !important;' href='lancamentos-campo.php?id=$id&idLancamento={$rowOption['idLancamentos']}&type=delete'><i class='fa fa-check-square'></i>Excluir<a></div></td>";
                    
                      echo "<td>". nl2br( $rowOption['DataEmissao']) ."</td>";
                      echo "<td>". nl2br( $rowOption['NumeroDocumento']) ."</td>";
                      echo "<td><b>". nl2br( $rowOption['Nome']) ."</b></td>";
                      echo "<td style='color:blue;' ><a href='ajuste-lancamento-campo.php?id={$rowOption['idLancamentos']}&idusuario={$id}'> <b> R$ ". nl2br( $moeda) ."</b></a> ".  $Anexos ."{$boolProrec}</td>";
                      echo "<td>". nl2br(  $rowOption['Referente']) ."</td>";
                      



                      echo "<td>  <i onclick='getModalDetalhamento({$rowOption['idLancamentos']})' data-toggle='modal' data-target='#modalView' title='Detalhes' class='fa fa-search fa-2x'></i>                                                         
                            </td>";
                      echo "</tr>";

                      //echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                  } 

                }
     

            echo "</tr>";
            echo "
            <tr>
                
                <td></td>
                <td></td>
                <td></td>

            </tr>
                                      
        </thead>
    </table>
</div> ";
?>
</p> 


       
</div>
                      
<!-- 
########################
Parte de meses em aberto (Inadinplantes)
************************************************ --> 

<div style="padding-top: 10px ;" class="tab-pane fade" id="profile">
    <h3 class="head text-center">Meses em Aberto</h3>
    <p class="text-center">
        <?php  echo $strQtdMesesAtrasados ; ?> 
    <?php   

    $totProrecCampo = 0;                         
                       
echo " <div class='datatable-tools'>
    <table class='table' id='tbUsuarios'>
        <thead>
            <tr>
                <th>  </th>
                <th>Emitido em</th>
                <th>Nº Documento</th>
                <th>Campo</th>
                <th>Valor</th>
                <th>Referencia </th>
                <th></th>

            </tr>";
              
//Lista os contas a Receber
echo "<tr>";
$id = (int) $_GET['id']; 
$resultSelect5 = $db->query("

      SELECT    
      r.Nome as Regiao,  
      u.id as idUsuario,
      u.Nome as Campo,
      c.NomePastorTitular,
      LB.Valor,
      DATE_FORMAT(LB.DataReferencia, '%m/%Y') AS Referente
      ,DATE_FORMAT(LB.DataBaixa, '%d/%m/%Y') AS DataEmissao
      -- count(u.id) as MesesEmAberto   
      , LB.*
      ,LB.id as idLancamentos 

      FROM
      lancamentosbancarios LB
      join usuarios u on (u.id = LB.idUsuario)
      join congregacoes gr on (gr.id = u.idCongregacao)
        join campos c on (c.id = gr.idCampo)
        join regioes r on  (r.id = c.idRegiao)
        where
            LB.Valor = 0 and LB.TipoLancamento in ('Regular','Inadimplente','Fechamento')               
            and u.id = {$id} 
            and LB.DataReferencia >= '2012-01-01'
        -- Considera o inicio do campo ()
        and LB.DataReferencia > u.DataInicio
        and u.idTipoUsuario <> 8 -- inativos 
        ; ")->results(true) or trigger_error($db->errorInfo()[2]); 


foreach($resultSelect5 as $rowOption){ 
  foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); } 

  $valorMySQL = $rowOption['ValorBoleto'];                                            
  $moeda = number_format( $valorMySQL , 2, ',', '.');
  $LinkAnexo = $rowOption['Anexos'];
  $Anexos = "";
  $totProrecCampo++; 

  if($LinkAnexo != ""){
      $Anexos =  " <a style='color:red;'  target='_blank' href='{$LinkAnexo}' ><i class='fa fa-paperclip'></i></a>" ;
  }                        
          
    echo "<tr>";
    echo "<td> <div  ". nl2br( $rowOption['DataBaixa']) ." class='cCredito'>";  
    echo "<div <i><a style='display:none !important;' id='lnkDelete' href='lancamentos-campo.php?id=$id&idLancamento={$rowOption['idLancamentos']}&type=delete'> </div><i class='fa fa-check-square'></i>Excluir<a></i></div></td>";  
    echo "<td>". nl2br( $rowOption['DataEmissao']) ."</td>";
    echo "<td>". nl2br( $rowOption['NumeroDocumento']) ."</td>";
    echo "<td><b>". nl2br( $rowOption['Campo']) ."</b></td>";
    echo "<td style='color:blue;' ><a href='ajuste-lancamento-campo.php?id={$rowOption['idLancamentos']}&idusuario={$id}'> <b> R$ ". nl2br( $moeda) ."</b></a> ".$Anexos."</td>";
    echo "<td>". nl2br( $rowOption['Referente']) ."</td>";    
    echo "<td>  <i onclick='getModalDetalhamento({$rowOption['idLancamentos']})' data-toggle='modal' data-target='#modalView' title='Detalhes' class='fa fa-search fa-2x'></i></td>";
    echo "</tr>";

  //echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
} 

echo "</tr>";
echo "
<tr>    
    <td></td>
    <td></td>
    <td></td>
</tr>                          
</thead>
</table>
</div> ";
?>
                    <!-- <a href="" class="btn btn-success btn-outline-rounded green"> create your profile <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></a> -->
</p>

</div>

<!-- 
*************** NEGOCIACOES
#########################################3 -->

<div style="padding-top: 10px ;" class="tab-pane fade" id="messages">
<h3 class="head text-center">Acordos e Negociações</h3>
<p class="narrow text-center">

<?php 

$id = (int) $_GET['id'];

$sqlProrecZ = "    Select lb.*
                
                    ,DATE_FORMAT(lb.DataReferencia, '%m/%Y') AS Referente
                    ,DATE_FORMAT(lb.DataBaixa, '%d/%m/%Y') AS DataEmissao
                    
                        , u.*, lb.Valor as ValorBoleto,
                    lb.id as idLancamentos

                   FROM

                    lancamentosbancarios lb 
                    join usuarios u on (u.id = lb.idusuario)

                    where lb.idUsuario = {$id}
                  
                     and lb.TipoLancamento not in ('PENDENTE') 
                      and lb.idProjeto = 3
                     order by Referente;";



$resultSelect56 = $db->query($sqlProrecZ)->results(true) or trigger_error($db->errorInfo()[2]); 

$timeline = "";
$countLac = 0;

foreach( $resultSelect56 as $rowOption){ 
  foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); } 


  if($rowOption['idProjeto'] == 3){
     $boolProrec=  "<span class=\"label label-success arrowed \">proRec</span>";
  }

  $valorMySQL = $rowOption['ValorBoleto'];                                            
  $moeda = number_format( $valorMySQL , 2, ',', '.');
  $LinkAnexo = $rowOption['Anexos'];
  $Anexos = "";

  //echo "1 <br>";

  if($LinkAnexo != ""){
      $Anexos =  " <a style='color:red;'  target='_blank' href='{$LinkAnexo}' ><i class='fa fa-paperclip'></i></a>" ;
  }                        
          
  //echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 

$timeline = $timeline . "    <div class=\"qa-message-list\" id=\"wallmessages\">
             <div class=\"message-item\" >
            <div class=\"message-inner\">
              <div class=\"message-head clearfix\">
                <div class=\"avatar pull-left\"><img src=\"ok.gif\"></div>            
                <div class=\"user-detail\">
                 
                  <div class=\"post-meta\" style=\"padding-top: 9px;\">
                    <div class=\"asker-meta\">
                      <span class=\"qa-message-what\"> PAGAMENTO PROREC </span>
                      <span class=\"qa-message-when\">
                        <span class=\"qa-message-when-data\"> em {$rowOption['DataEmissao']} </span>
                      </span>
                      <span class=\"qa-message-who\">
                        <span class=\"qa-message-who-pad\">   </span>
                        <span class=\"qa-message-who-data\"></span>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
              <div class=\"qa-message-content\">
              <p> Pagamento realizado em {$rowOption['DataBaixa']} <br>
                  Gerado em <b>{$rowOption['DataEmissao']}</b> | Numero Documento <b>{$rowOption['NumeroDocumento']}</b> 
              <br> Responsavel negociação <b>Pr.{$rowOption['NomePastor']} </b> - {$rowOption['Email']} 
              </div>
          </div></div> ";

          $countLac++;

} 
?>

<!-- ####################### Timeline -->
<div class="container" 
style="    width: 90%; ">
<DIV class=" text-center">
Parcelas pagas <span class="badge badge-success"> <?php echo $countLac ?></span>
Parcelas restantes <span class="badge badge-warning"><?php echo $qtdProrec - $countLac ?></span>
Valor Negociado <span class="badge badge-important"> <?php echo $valorProrec ?></span>

</DIV>
<br><br>  
<?php echo $timeline; ?>

</div>
</div>                         

<!-- ##################### final TIMELINE -->

    </p>
    
    <p class="text-center">
<!-- <a href="" class="btn btn-success btn-outline-rounded green"> start using bootsnipp <span style="margin-left:10px;" class="glyphicon glyphicon-send"></span></a> -->
</p>
</div>





<div class="clearfix"></div>
</div>

</div>
<!-- </div>
</div>
</section> -->

</div>




<input class="btn btn btn-success" onclick='history.back(-1)' value='Voltar' />
<input class="btn btn btn-info" onclick='javascript:imprimirPDF()' value='Imprimir Posição' />


<?php 
   echo "</div>";
   echo "</div>";


 $idCampoLog = (int) $_GET['id'];   
 Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] acessou as remessas do campo {$idCampoLog} .");   
?>



<!-- TITULO e cabeçalho das paginas  -->
<div  class="row">


<div id="divposicao" class="row">
    <div id="divListagem" class="col-lg-12">





</div>
</div>

<input type="hidden" name="fhtml" id="fhtml" value="" />

</form>

 

<!-- Modal -->
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Visualizar</h4>
      </div>
      <div class="modal-body" id="dvCorpo">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>                



<?php include("footer.php")    ; ?>

<script type="text/javascript">



//
function getModalDetalhamento(idLancamento){
        //Carrega automaticamente a tela de colocar o valor, data de referencia
        //para emir o boleto
        //var fId = idLancamento;
        //MONTA TELA
        $.ajax({    
                //CRIA AJAX PRA CARREGAR A PAGINA
                type: "GET",
                url: "montaDetalhamento.php?id="+idLancamento,             
                dataType: "html",   //HTML PRA CARREGAR                
                success: function(response){                    
                    $("#dvCorpo").html( "<br>"+response); 
                }
              });

  $("#tables").show();
  $("#divCampos").show();
  $("#dvTitle").show();
  
   // Mostra mensagem de Emitido com sucesso
  $("#divConfirmacao").hide();
}
//================================================    


// Cria a tela pra um novo Lancamento Bancario
function getNewModal(){
        //Carrega automaticamente a tela de novo
        //alert();
        //MONTA TELA
        $.ajax({    
                //CRIA AJAX PRA CARREGAR A PAGINA
                type: "GET",
                url: "modal-novo-lancamento-bancario.php",             
                dataType: "html",   //HTML PRA CARREGAR                
                success: function(response){                    
                    $("#dvModalNewContent").html( "<br>"+response); 
                }
              });
}
//================================================    


function imprimirPDF(){

//var html = getElementById("divposicao").value;
//var html = $("<div />").append($("#divposicao").clone()).html();
//$("#fhtml").val(html);
//alert();
//$("#formulario").submit();
var url      = window.location.href;     // Returns full URL
$("#wrapper a").removeAttr("href").css("cursor","pointer");
window.print();

window.location.href = url;     // Returns full URL

//$("#tbUsuarios a").removeAttr("href").css("cursor","pointer");



}



function novoLancamento(){
var idUsuario = getUrlVars()["id"];
  window.location.href= "novo-lancamento-campo.php?id="+idUsuario;

}



function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('headerTable'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}








var pressedCtrl = false; 

//Quando uma tecla for liberada verifica se é o CTRL para notificar que CTRL não está pressionado
document.onkeyup=function(e){ 
  if(e.which == 17) 
  pressedCtrl =false;
}


// Quando alguma tecla for pressionada:
// Primeiro if - verifica se é o CTRL e avisa que CTRL está pressionado
// Segundo if - verifica se a tecla é o "s" (keycode 83) para executar a ação


document.onkeydown=function(e){
  if(e.which == 17)
    pressedCtrl = true; 

  if(e.which == 66 && pressedCtrl == true ) { 
    //Aqui vai o código e chamadas de funções para o ctrl+s
    //alert("CTRL + b pressionados");

      $(document).ready(function() {
        //alert('deletar');
        $("#tbUsuarios #lnkDelete").toggle();
      
      });

  }

  if(e.which == 81 && pressedCtrl == true ) { 
    //Aqui vai o código e chamadas de funções para o ctrl+s
    //alert("CTRL + b pressionados");

      $(document).ready(function() {
        //alert('Reprocessar');
        $("#btnReprocessamento").toggle();
      
      });

  }


}


$(function(){
$('a[title]').tooltip();
});
</script>                