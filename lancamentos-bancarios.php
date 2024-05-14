<?php 

include("header.php");
include('config.php');
include('scripts/functions.php');

?>

<style type="text/css">
  .Vencida {
    width: 110px;
    padding: 1px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0;
    background-color: red;
    color: white;
  }

  .AVencer {
    width: 110px;
    padding: 1px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0;
    background-color: green;
    color: white;
  }

  .Recebida {
    width: 110px;
    padding: 2px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0;
    background-color: blue;
    color: white;
  }
</style>

<!-- Para criar o excel exportado-->
<iframe id="txtArea1" style="display:none"></iframe>



<?php
$tituloPrincipal = "Entradas";
$tituloSecondario = "Listagem de Entradas";
$navPagina = "Lançamentos Bancários";


?>
<!-- TITULO e cabeçalho das paginas  -->
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><img src="lancamentos-entrada.jpg" width="100" height="100"><?= $tituloPrincipal ?><br><br>
        <small><?= $$tituloSecondario ?></small>
      </h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class='breadcrumb-header'>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
          <li class="breadcrumb-item active" aria-current="page"><?= $navPagina ?></li>
          <li class="breadcrumb-item">Último dia do Mês:
            <?php
            $a_date = date('d-m-Y H:i:s');
            echo date("t-m-Y", strtotime($a_date));
            ?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<!-- /.row -->

<div class="row">
  <div class="navbar navbar-default">
    <div class="container">

      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
          <span class="sr-only"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
      </div>


                                  <div class="col-lg-4">
                                    <select id="selectAno" class="form-control" >
                                      <option>Ano</option>


                                      <script>
                                        // Selecionando o elemento select
                                        var selectElement = document.getElementById("selectAno");

                                        // Loop de 2008 a 2036
                                        for (var year = 2008; year <= 2036; year++) {
                                          // Criando uma nova opção
                                          var option = document.createElement("option");
                                          // Definindo o valor e o texto da opção
                                          option.value = year;
                                          option.text = year;
                                          // Adicionando a opção ao select
                                          selectElement.appendChild(option);
                                        }
                                      </script>
                                    </select>
                                  </div>

                                  <div class="col-lg-2" style:"margin-top:4px !Important;">
                                    <a href="javascript:getFiltroData();" class="btn btn-sm btn-primary">OK</a>                       
                                  </div>
                                  </li>

                                  <!-- Por data de emissão -->
                                  <li id='liFiltroDataEmissao' style='display:none;margin-top:8px;'>

                                    <div class="col-lg-6">
                                    <select id="selectMesEmissao" class="form-control">
                                      <option>Mês</option>
                                      <option value="01">Janeiro</option>
                                      <option value="02">Fevereiro</option>
                                      <option value="03">Março</option>
                                      <option value="04">Abril</option>
                                      <option value="05">Maio</option>
                                      <option value="06">Junho</option>
                                      <option value="07">Julho</option>
                                      <option value="08">Agosto</option>
                                      <option value="09">Setembro</option>
                                      <option value="10">Outubro</option>
                                      <option value="11">Novembro</option>
                                      <option value="12">Dezembro</option>
                                    </select>
                                  </div>


                                  <div class="col-lg-4">
                                    <select id="selectAnoEmissao" class="form-control" >
                                      <option>Ano</option>
                                      <script>
                                        // Selecionando o elemento select
                                        var selectElement = document.getElementById("selectAnoEmissao");

                                        // Loop de 2008 a 2036
                                        for (var year = 2008; year <= 2036; year++) {
                                          // Criando uma nova opção
                                          var option = document.createElement("option");
                                          // Definindo o valor e o texto da opção
                                          option.value = year;
                                          option.text = year;
                                          // Adicionando a opção ao select
                                          selectElement.appendChild(option);
                                        }
                                      </script>
                                    </select>
                                  </div>

            </ul>
          </li>
          <li id='liFiltroData' style='display:none;margin-top:8px;'>

            <div class="col-lg-6">
              <select id="selectMes" class="form-control">
                <option>Mês</option>
                <option value="01">Janeiro</option>
                <option value="02">Fevereiro</option>
                <option value="03">Março</option>
                <option value="04">Abril</option>
                <option value="05">Maio</option>
                <option value="06">Junho</option>
                <option value="07">Julho</option>
                <option value="08">Agosto</option>
                <option value="09">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>
              </select>
            </div>


            <div class="col-lg-4">
              <select id="selectAno" class="form-control">
                <option>Ano</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
            </div>

            <div class="col-lg-2" style:"margin-top:4px !Important;">
              <a href="javascript:getFiltroData();" class="btn btn-sm btn-primary">OK</a>
            </div>
          </li>

          <!-- Por data de emissão -->
          <li id='liFiltroDataEmissao' style='display:none;margin-top:8px;'>

            <div class="col-lg-6">
              <select id="selectMesEmissao" class="form-control">
                <option>Mês</option>
                <option value="01">Janeiro</option>
                <option value="02">Fevereiro</option>
                <option value="03">Março</option>
                <option value="04">Abril</option>
                <option value="05">Maio</option>
                <option value="06">Junho</option>
                <option value="07">Julho</option>
                <option value="08">Agosto</option>
                <option value="09">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>
              </select>
            </div>


            <div class="col-lg-4">
              <select id="selectAnoEmissao" class="form-control">
                <option>Ano</option>
                <option value="2008">2008</option>
                <option value="2009">2009</option>
                <option value="2010">2010</option>
                <option value="2011">2011</option>
                <option value="2012">2012</option>
                <option value="2013">2013</option>
                <option value="2014">2014</option>
                <option value="2015">2015</option>
                <option value="2016">2016</option>
                <option value="2017">2017</option>
                <option value="2018">2018</option>
                <option value="2019">2019</option>
                <option value="2020">2020</option>
              </select>
            </div>

            <div class="col-lg-2" style:"margin-top:4px !Important;">
              <a href="javascript:getFiltroDataEmissao();" class="btn btn-sm btn-warning">OK</a>
            </div>
          </li>


          <li>
            <div class="col-lg-2" style:"margin-top:4px !Important;">
              <a style="margin-top: 8px;" href="javascript:fnExcelReport();" class="btn btn-sm btn-info"><i class="fa fa-file-excel-o"></i> Excel</a>
            </div>



        </ul>







      </div>
      <!--/.nav-collapse -->
    </div>
  </div>
</div>


<!-- /.row -->

<div class="row">
  <div class="col-lg-12">
    <div class="datatable-tools">
      <table class="table " id="tbUsuarios">
        <thead>
          <tr>
            <th> </th>
            <th>Data Baixa</th>
            <th>Nº Documento</th>
            <th>Campo</th>
            <th>Valor</th>
            <th>Referente á </th>
            <!-- <th>Estado </th> -->
            <th></th>

          </tr>

          <?php
          //Lista os contas a Receber
          $fTotalData = 0;
          $fTotalNaoIdentificadoData = 0;
          $countLanc = 0;
          $AgrupamentoReferencia = "";
          $AgrupamentoEmissao = "";

         
          echo "<tr>";


          if (isset($_GET['type'])) {

            $type = (string) $_GET['type'];
            $fano = $_GET['ano'];
            $fmes = $_GET['mes'];

            if ($type == "dt") {
              $whereMes = "";
              $whereAno = "";
              if ($fmes != "Mês") {
                $whereMes = "MONTH(lb.DataReferencia) = {$fmes} AND YEAR(lb.DataReferencia) = {$fano}";
              }
            }
            if ($type == "dtEmissao") {
              $whereMes = "";
              $whereAno = "";
              if ($fmes != "Mês") {
                $whereMes = "MONTH(lb.DataBaixa) = {$fmes} AND YEAR(lb.DataBaixa) = {$fano}";
              }
            }

        
         
            //Lista Apenas Campos Eclesiáticos                              
            $resultSelect = $db->query("
                                      SELECT 
                                      lb.*
                                      ,DATE_FORMAT(lb.DataReferencia, '%m/%Y') AS Referente
                                      ,DATE_FORMAT(lb.DataBaixa, '%d/%m/%Y') AS DataEmissao
                                      , u.*, lb.Valor as ValorBoleto
                                      ,lb.id as idLancamentos

                                      FROM

                                      lancamentosbancarios lb 
                                      join usuarios u on (u.id = lb.idusuario)

                                      where " . $whereMes . " 

                                      and lb.valor > 0 

                                      order by lb.DataBaixa desc  
                                      
                                      limit 10

                                      ")->results(true) or trigger_error($db->errorInfo()[2]);

                                      

            //echo $resultSelect;


            foreach ($resultSelect as $rowOption) {
              foreach ($rowOption as $key => $value) {
                $rowOption[$key] = stripslashes($value);
              }


              $valorMySQL = $rowOption['ValorBoleto'];
              $countLanc++;
              $moeda = number_format($valorMySQL, 2, ',', '.');


              $LinkAnexo = $rowOption['Anexos'];
              $Anexos = "";
              if ($LinkAnexo != "") {

                $Anexos =  " <a style='color:red;'  target='_blank' href='{$LinkAnexo}' ><i class='fa fa-paperclip'></i></a>";
              }



              /*

                                            if($type == "dt"){
                                              if( ($AgrupamentoReferencia != $rowOption['Referente'])  ){
                                                   echo "<tr>";
                                                   echo " <th style='color:green;'>   {$rowOption['Referente']} </th><th></th><th></th><th></th><th></th><th> </th><th></th>";
                                                   echo  "</tr>";
                                              } 
                                            }
 

                                            if($type == "dtEmissao"){
                                              if( ($AgrupamentoEmissao != $rowOption['DataEmissao'])  ){
                                                   echo "<tr>";
                                                   echo " <th style='color:green;'>   {$rowOption['DataEmissao']} </th><th></th><th></th><th></th><th></th><th> </th><th></th>";
                                                   echo  "</tr>";
                                              } 
                                            }
                                        */


              //if($type == "dtEmissao"){                                          
              if (('1196' == $rowOption['idUsuario'])) {
                $fTotalNaoIdentificadoData  = $fTotalNaoIdentificadoData + $rowOption['ValorBoleto'];
                //echo "<tr>";
                //echo " <th style='color:green;'>   {$rowOption['DataEmissao']} </th><th></th><th></th><th></th><th></th><th> </th><th></th>";
                //echo  "</tr>";
                continue;
              }
              //}


              echo "<tr>";
              echo "<td> <div title='Esse boleto foi Recebido e 
                                              \n  baixado em " . nl2br($rowOption['DataBaixa']) . " 
                                              \n . 
                                              \n '  class='cCredito'>";
              echo "  </div></td>";

              echo "<td>" . nl2br($rowOption['DataEmissao']) . "</td>";
              echo "<td>" . nl2br($rowOption['NumeroDocumento']) . "</td>";
              echo "<td><b>" . nl2br($rowOption['Nome']) . "</b></td>";
              echo "<td style='color:green;' > " . $Anexos . "<b>   R$ " . nl2br($moeda) . "</b></td>";
              echo "<td>" . nl2br($rowOption['Referente']) . "</td>";

              echo "<td>  <i onclick='getModalDetalhamento(" . $rowOption['idLancamentos'] . ")' data-toggle='modal' data-target='#modalView' title='Detalhes' class='fa fa-search fa-2x'></i>                                                         
                                                    </td>";



              echo "</tr>";

              //Total e controle
              $fTotalData             = $fTotalData + $rowOption['ValorBoleto'];
              $AgrupamentoReferencia  = $rowOption['Referente'];
              $AgrupamentoEmissao     = $rowOption['DataEmissao'];
              $countLanc++;

              //echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
            }

            echo "<tr style='background-color:#FFA500;color:black;'>";
            echo " <th style='color:green;'>    </th><th></th><th></th><th>NÃO IDENTIFICADOS</th><th><b>R$ " . nl2br(number_format($fTotalNaoIdentificadoData, 2)) . "</b></th><th> </th><th></th>";
            echo  "</tr>";

            echo "<tr style='background-color:#008000;color:white;'>";
            echo "<td></td><td></td><td></td>";
            echo "<td><b>TOTAL</b>( {$countLanc} pagtos )</td><td><b>R$ " . nl2br(number_format($fTotalData, 2)) . "</b></td>";
            echo "<td></td><td></td></tr>";
          } else {

            //Lista Apenas Campos Eclesiáticos  SEM FILTROS                              
            $resultSelect = $db->query("
                                          SELECT 
                                            lb.*
                                            -- DATEDIFF( cr.DataEmissao, curdate()) as DiasAtraso
                                            ,DATE_FORMAT(lb.DataReferencia, '%m/%Y') AS Referente
                                            ,DATE_FORMAT(lb.DataBaixa, '%d/%m/%Y') AS DataEmissao                                            
                                            , u.*, lb.Valor as ValorBoleto
                                            , lb.id as idLancamentos

                                           FROM

                                            lancamentosbancarios lb 
                                            join usuarios u on (u.id = lb.idusuario)
                                                -- join contasreceber cr on (cr.id = lb.idContaReceber)

                                                  where  lb.valor > 0 and year( lb.DataReferencia) >= 2015
                                                  order by lb.DataReferencia desc
                                                  limit 10000

                                      ")->results(true) or trigger_error($db->errorInfo()[2]);



            foreach ($resultSelect as $rowOption) {
              foreach ($rowOption as $key => $value) {
                $rowOption[$key] = stripslashes($value);
              }

              //$AgrupamentoReferencia = $rowOption['Referente'];  
              //$valorMySQL = str_replace(".","",$rowOption['ValorBoleto']);                                            
              $valorMySQL = $rowOption['ValorBoleto'];
              $moeda = number_format($valorMySQL, 2, ',', '.');



              $LinkAnexo = $rowOption['Anexos'];
              $Anexos = "";
              if ($LinkAnexo != "") {

                $Anexos =  " <a style='color:red;'  target='_blank' href='{$LinkAnexo}' ><i class='fa fa-paperclip'></i></a>";
              }


              //$moeda = $rowOption['ValorBoleto'];

              $fTotalData = $fTotalData + $rowOption['ValorBoleto'];
              $countLanc++;

              if (('1196' == $rowOption['idUsuario'])) {
                $fTotalNaoIdentificadoData  = $fTotalNaoIdentificadoData + $rowOption['ValorBoleto'];
                //echo "<tr>";
                //echo " <th style='color:green;'>   {$rowOption['DataEmissao']} </th><th></th><th></th><th></th><th></th><th> </th><th></th>";
                //echo  "</tr>";
                continue;
              }

              /*
                                            if( ($AgrupamentoReferencia != $rowOption['Referente'])  ){
                                                 echo "<tr>";
                                                 echo " <th style='color:green;'>   {$rowOption['Referente']} </th><th></th><th></th><th></th><th></th><th> </th><th></th>";
                                                 echo  "</tr>";
                                            } 

                                            */


              echo "<tr>";
              echo "<td> <div title='Esse boleto foi Recebido e 
                                            \n  baixado em " . nl2br($rowOption['DataEmissao']) . " 
                                            \n . 
                                            \n '  class='cCredito'>";
              echo "</div></td>";

              echo "<td>" . nl2br($rowOption['DataEmissao']) . "</td>";
              echo "<td>" . nl2br($rowOption['NumeroDocumento']) . "</td>";
              echo "<td><b>" . nl2br($rowOption['Nome']) . "</b></td>";
              //echo "<td style='color:blue;' ><b> R$ ". nl2br( number_format( $rowOption['ValorBoleto'], 2)) ."</b></td>";
              echo "<td style='color:green;' > " . $Anexos . "<b>   R$ " . nl2br($moeda) . "</b></td>";
              echo "<td>" . nl2br($rowOption['Referente']) . "</td>";

              echo "<td>  <i onclick='getModalDetalhamento(" . $rowOption['idLancamentos'] . ")' data-toggle='modal' data-target='#modalView' title='Detalhes' class='fa fa-search fa-2x'></i>                                                         
                                                  </td>";
              echo "</tr>";


              $fTotalData = $fTotalData + $rowOption['ValorBoleto'];

              //echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 

              $AgrupamentoReferencia = $rowOption['Referente'];
            }



            echo "<tr style='background-color:#FFA500;color:black;'>";
            echo " <th style='color:green;'>    </th><th></th><th></th><th>NÃO IDENTIFICADOS</th><th><b>R$ " . nl2br(number_format($fTotalNaoIdentificadoData, 2)) . "</b></th><th> </th><th></th>";
            echo  "</tr>";
            echo "<tr style='background-color:#D0F5A9;'>";
            echo "<td></td><td></td><td></td>";
            echo "<td><b>TOTAL</b>( {$countLanc} pagtos )</td><td><b>R$ " . nl2br(number_format($fTotalData, 2)) . "</b></td>";
            echo "<td></td><td></td></tr>";
          }


          echo "</tr>";

          ?>


          <tr>


            <td></td>
            <td></td>
            <td></td>


          </tr>

        </thead>
      </table>
    </div>

  </div>


</div>


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



<?php include("footer.php"); ?>

<script type="text/javascript">
  //
  function getModalDetalhamento(idLancamento) {
    //Carrega automaticamente a tela de colocar o valor, data de referencia
    //para emir o boleto
    //var fId = idLancamento;
    //MONTA TELA
    $.ajax({
      //CRIA AJAX PRA CARREGAR A PAGINA
      type: "GET",
      url: "montaDetalhamento.php?id=" + idLancamento,
      dataType: "html", //HTML PRA CARREGAR                
      success: function(response) {
        $("#dvCorpo").html("<br>" + response);
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
  function getNewModal() {
    //Carrega automaticamente a tela de novo
    //alert();
    //MONTA TELA
    $.ajax({
      //CRIA AJAX PRA CARREGAR A PAGINA
      type: "GET",
      url: "modal-novo-lancamento-bancario.php",
      dataType: "html", //HTML PRA CARREGAR                
      success: function(response) {
        $("#dvModalNewContent").html("<br>" + response);
      }
    });
  }
  //================================================    
  //DATA DE REFERENCIA ================================================    

  function showFiltroData() {
    $("#liFiltroData").show("slow", function() {});

    //Esconde demais divs
    $("#liFiltroDataEmissao").hide("slow", function() {});

  }

  function getFiltroData() {
    $("#liFiltroData").show("slow", function() {});
    //Esconde demais divs
    $("#liFiltroDataEmissao").hide("slow", function() {});

    var fMes = $("#selectMes").val();
    var fAno = $("#selectAno").val();
    var ftype = "dt";
    window.location.href = "lancamentos-bancarios.php?mes=" + fMes + "&ano=" + fAno + "&type=" + ftype;

  }


  //================================================    
  //DATA DE EMISSAO ================================================    
  function showFiltroDataEmissao() {
    $("#liFiltroDataEmissao").show("slow", function() {});
    //Esconde demais divs
    $("#liFiltroData").hide("slow", function() {});

  }

  function getFiltroDataEmissao() {
    $("#liFiltroDataEmissao").show("slow", function() {});
    //Esconde demais divs
    $("#liFiltroData").hide("slow", function() {});

    var fMes = $("#selectMesEmissao").val();
    var fAno = $("#selectAnoEmissao").val();
    var ftype = "dtEmissao";
    window.location.href = "lancamentos-bancarios.php?mes=" + fMes + "&ano=" + fAno + "&type=" + ftype;

  }





  // Read a page's GET URL variables and return them as an associative array.
  function getUrlVars() {
    var vars = [],
      hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for (var i = 0; i < hashes.length; i++) {
      hash = hashes[i].split('=');
      vars.push(hash[0]);
      vars[hash[0]] = hash[1];
    }
    return vars;
  }


  //Atualiza valores da periodicidade
  $(function() {

    if (getUrlVars()["type"] == "dt") {

      $("#liFiltroData").show("slow", function() {});
    } else {
      $("#liFiltroDataEmisso").show("slow", function() {});

    }

  });

  function fnExcelReport() {
    var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange;
    var j = 0;
    tab = document.getElementById('tbUsuarios'); // id of table

    for (j = 0; j < tab.rows.length; j++) {
      tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
      //tab_text=tab_text+"</tr>";
    }

    tab_text = tab_text + "</table>";
    tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, ""); //remove if u want links in your table
    tab_text = tab_text.replace(/<img[^>]*>/gi, ""); // remove if u want images in your table
    tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE ");

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)) // If Internet Explorer
    {
      txtArea1.document.open("txt/html", "replace");
      txtArea1.document.write(tab_text);
      txtArea1.document.close();
      txtArea1.focus();
      sa = txtArea1.document.execCommand("SaveAs", true, "Say Thanks to Sumit.xls");
    } else //other browser not tested on IE 11
      sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));

    return (sa);
  }
</script>