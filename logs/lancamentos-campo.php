<?php session_start();


if($_SESSION['logado'] <> "S"){

    //header("login.php");
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
      mysql_query("DELETE FROM `lancamentosbancarios` WHERE `id` = '$idLancamento' ") ;   Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] deletou a remessa {$idLancamento} do campo id={$id}.");  
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
$resultPagos = mysql_query("
  select * from contasreceber where Status = 'Pago' ;
") or trigger_error(mysql_error()); 

while($rowOption = mysql_fetch_array($resultPagos)){ 
  foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                                             
      ##################################################################################3
      # Cria Lancamentos bancarios caso nao tenha ocorrencia 
      $resultLancBanc = mysql_query("
        select * from lancamentosbancarios where idContaReceber = {$rowOption['id']} ;
      ") or trigger_error(mysql_error()); 

      $countLac = 0;
      echo " boleto {$rowOption['id']} <br>";

      while($rowOptionLanc = mysql_fetch_array($resultLancBanc)){ 
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
                
                if (! mysql_query($SqlInsereProcessamento) ){
                      die( ':: Erro : '. mysql_error()); 
                      echo "Fase de teste lancamentosbancarios: Anote o seguinte erro!";
                    }

                echo "<br> Criado um lancamento de {$rowOption['valor']} para o boleto {$rowOption['id']}" ;


      }
  //echo "<li ><a  href='lancamentos-campo.php?id={$id}&ano={$rowOption['Ano']}'>{$rowOption['Ano']} </a></li>";              

}







      //mysql_query("DELETE FROM `lancamentosbancarios` WHERE `id` = '$idLancamento' ") ; 
      
      //Redirect("lancamentos-campo.php?id=".$id);
      //die("<script>location.href = 'lancamentos-campo.php?id={$id}'</script>");
  }
}


      
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
  .bs-example{
    margin: 20px;
  }




</style>

<form  id="formulario" target="_blank"  method="post" action="pdftohtml.php">



<!-- TITULO e cabeçalho das paginas  -->
<div  class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
          <img src="inadimplentes.jpg" width="100" height="100">
           
            Remessas
            <small>Quadro de posição do campo </small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Posição do campo
            </li>
          

                <?php
                if (isset($_GET['id']) ) { 
                   $id = (int) $_GET['id'];   
                   //$Ano = (int) $_GET['Ano'];   

                    $resultSelect = mysql_query("
                          SELECT distinct
                          year(lb.DataReferencia) as Ano 
                           FROM
                            lancamentosbancarios lb 
                            join usuarios u on (u.id = lb.idusuario)
                            where lb.idUsuario = {$id}
                            order by year(lb.DataReferencia) desc

                      ") or trigger_error(mysql_error()); 



                echo "
                    <ul class='nav nav-tabs'>";

                      while($rowOption = mysql_fetch_array($resultSelect)){ 
                        foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                                             
                          echo "<li ><a  href='lancamentos-campo.php?id={$id}&ano={$rowOption['Ano']}'>{$rowOption['Ano']} </a></li>";              
                        }






                    ###############################################################################
                    ######Meses apenas para campos Eclesiasticos
                    $tipoUsuario = "";
                    $rUsuario = mysql_query("  SELECT * FROM usuarios where id = {$id}
                    ") or trigger_error(mysql_error()); 
                    
                    while($rowOptionUsuario = mysql_fetch_array($rUsuario)){ 
                      foreach($rowOptionUsuario AS $key => $value) { $rowOptionUsuario[$key] = stripslashes($value); }                                             
                       $tipoUsuario = $rowOptionUsuario['idTipoUsuario'];              
                      }
                      
                    ######Meses em aberto apenas para campos eclesiasticos
                    # if idTipoUsuario <> 6
                    
                    //echo $tipoUsuario . "<br> ============= ";
                    
                    if($tipoUsuario == 6){

                        $rsMesesEmAberto = mysql_query("
                      
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
                            
    
                                -- Considera o inicio do campo ()
                                and LB.DataReferencia > u.DataInicio
                                and u.idTipoUsuario <> 8 -- inativos
                                group by
                                u.id,
                                u.Nome

                                order by count(u.id) desc;
    
                          ") or trigger_error(mysql_error()); 
    
    
                          while($rowOptionMeses = mysql_fetch_array($rsMesesEmAberto)){ 
                              foreach($rowOptionMeses AS $keyMes => $valueMes) { $rowOptionMeses[$keyMes] = stripslashes($valueMes); }
                              echo "<li> <a>  -  </a>   </li><li ><a style='color:red !important;' href='lancamentos-campo.php?id={$id}&abertos=y'>  {$rowOptionMeses['MesesEmAberto']} Meses em Aberto </a></li>";              
                          }
                            
                    }
                        
                        
                        ######Meses em aberto apenas para campos eclesiasticos
                        


                  echo "</ul>";

                }    


                ?>

                  <ul id="btnReprocessamento"  style='display:none;'  class='nav nav-tabs'>
                    <li>

                     <div >
                      <a id='lnkReproce' 
                         href="lancamentos-campo.php?id=<?=$id ?>&type=reprocessamento">                        
                         Reprocessar
                      </a>
                     </div>;
                      
                  </ul>

        </ol>
    </div>





<div id="divposicao" class="row">
    <div id="divListagem" class="col-lg-12">


<?php

                            

echo "<h3>Historico </h3>";
echo "<p>Quadro de remessas do ano de {$_GET['ano']}. </p>";
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

            //Lista os contas a Receber
            echo "<tr>";

        if (!isset($_GET['abertos']))  { 

           $id = (int) $_GET['id']; 

           if (isset($_GET['ano']) ) { 
               $Ano = (int) $_GET['ano'];      
            } else { $Ano = date('Y');}

            
            //Lista Apenas Campos Eclesiáticos                                
            $resultSelect3 = mysql_query("
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

                     order by Referente

              ") or trigger_error(mysql_error()); 

                  while($rowOption = mysql_fetch_array($resultSelect3)){ 
                    foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }     

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
                      echo "<td style='color:blue;' ><a href='ajuste-lancamento-campo.php?id={$rowOption['idLancamentos']}&idusuario={$id}'> <b> R$ ". nl2br( $moeda) ."</b></a> ".  $Anexos ."</td>";
                      echo "<td>". nl2br( $rowOption['Referente']) ."</td>";
                      



                      echo "<td>  <i onclick='getModalDetalhamento({$rowOption['idLancamentos']})' data-toggle='modal' data-target='#modalView' title='Detalhes' class='fa fa-search fa-2x'></i>                                                         
                            </td>";
                      echo "</tr>";

                      //echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                  } 

                }else if (isset($_GET['abertos'])){


                  $id = (int) $_GET['id']; 


              
              //Lista Apenas Campos Eclesiáticos                                
              $resultSelect5 = mysql_query("

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


                           

                            

                                        ;    
                                   
                                

                ") or trigger_error(mysql_error()); 

                    while($rowOption = mysql_fetch_array($resultSelect5)){ 
                      foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); } 

                        $valorMySQL = $rowOption['ValorBoleto'];                                            
                        $moeda = number_format( $valorMySQL , 2, ',', '.');


                         $LinkAnexo = $rowOption['Anexos'];
                         $Anexos = "";
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

<?php 
   echo "</div>";
   echo "</div>";


 $idCampoLog = (int) $_GET['id'];   



        Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] acessou as remessas do campo {$idCampoLog} .");   
?>


</div>
</div>

<input type="hidden" name="fhtml" id="fhtml" value="" />

</form>

 
<input class="btn btn btn-success" onclick='history.back(-1)' value='Voltar' />
<input class="btn btn btn-info" onclick='javascript:novoLancamento()' value='Novo Lancamento' />
<input class="btn btn btn-info" onclick='javascript:imprimirPDF()' value='Imprimir Posição' />






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

</script>                