<?php 
  session_start();
  include("header.php");
  include('config.php');  
  include('scripts/functions.php'); 


  #INICIA ROTINA DE FECHAMENTO ==============================================
  # O FECHAMENTO CONSISTEM EM CRIAR LANCAMENTOS ZERADOS PARA OS ACAMPOS
  # QUE ATE O MOMENTO NAO ENVIARAM O COMPROVANETE DE OFERTA OU NAO
  # FIZERAM O PAGTO POR BOLETO BANCARIO.
  #========================================================================== 

   if (isset($_GET['type']) ) { 
      if($_GET['type'] == "fechamento"){


        # 1 - SELECIONAR TODOS OS CAMPOS QUE NAO TEM LANCAMENTO PARA O MES
        # 2 - LANCAR PARA CADA CAMPO UM REGISTRO ZERADO COM A COMPETENCIA DO MES ESCOLHIDO PARA FECHAMENTO

        $fano = $_GET['ano'];
        $fmes = $_GET['mes']; 

        $fanoComp = $_GET['ano'];
        $fmesComp = $_GET['mes']; 


        /* campos sem lancamento no mes atual*/
          $rsCamposSemLancamento =$db->query("

            select u.* from 
                              campos c 
                              join congregacoes cg on (cg.idCampo = c.id )
                              join usuarios u on (u.idCongregacao = cg.id)
                                where
                                u.id not in
                                (
                                      select lb2.idUsuario from lancamentosbancarios lb2
                                      where  
                                          month(lb2.DataReferencia) = {$fmes} 
                                        and year(lb2.DataReferencia) = {$fano}
                                            and lb2.TipoLancamento in ('Regular','Inadimplente', 'Fechamento','Identificado')
                                        -- Considera o inicio do campo ()
                                          and lb2.DataReferencia > u.DataInicio

                                          

                                )
                                and  c.idRegiao <> 12 -- BASE DGEM 
                                and u.idTipoUsuario <> 8 -- inativos 

                                ;
                                
            ")->results(true); 



                               // exit;


        $countLancamentos = 0;

        foreach($rsCamposSemLancamento as $rowOption){ 
          foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
            

            //echo "<br>";
            //echo " Lancamento gerado para ".$rowOption['Nome']." .";
            $fano = $_GET['ano'];
            $fmes = $_GET['mes'] ; 

            
            if($fmes != 12) {
            $fmes = $fmes+1;
            }else{
              $fano = $fano +1;
              $fmes = 1;
            }





            $fDT      = "28/".$fmes ."/".$fano;
            $fDTComp  = "15/".$fmesComp ."/".$fanoComp;

            //Echo $fDT;
            //exit;






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

                  
            `Descricao`,
            `idContaBancaria`,
            `DataReferencia`,
            `NumeroDocumento`,
            `TipoLancamento`

            )
            VALUES
            (
            ".$rowOption['id']." ,
            '0.00',
            'F',
            STR_TO_DATE('$fDT', '%d/%m/%Y') ,

            1 ,
            {$_SESSION['idlogado']},
            {$_SESSION['idlogado']},

      
            'Lancamento gerado automaticamente pelo processo de fechamento mensal',
            1,
            STR_TO_DATE('$fDTComp', '%d/%m/%Y') , 'INAD0000".$rowOption['id']."','Fechamento');";

            //echo "<br>" . $SqlInsereProcessamento;

            //exit;
            
                
            
            //Verificar se a data de inicio dele éanterior ao fechamento do mes solicitado
            $fData_Competencia = $fanoComp.'-'.$fmesComp ."-15";
            
            #Debug
            //if($rowOption['id'] == 1212){


              //echo $fData_Competencia. "<br>";
              //echo $rowOption['id'] . "<br>";

            if ( verificaIniciodoCampo($fData_Competencia, $rowOption['id'])){
              //exit;

              if (! $db->query($SqlInsereProcessamento) ){
              
              //      die( ':: Erro : '. mysql_error()); 
              
                    echo "Fase de teste lancamentosbancarios: Anote o seguinte erro!";
                  }else{            
                    $countLancamentos++;
                }
        
          }

      //}


        } //Fim while

        if($countLancamentos > 0){
          echo " <div class=\"alert alert-success\">
                  <strong> <h3>Fechamento concluido com sucesso!!!</h3></strong> 
          <br> Foram gerados {$countLancamentos} lançamentos para a competencia de {$fmesComp}/{$fanoComp}   
          com data de baixa  {$fDT}       
          </div>";
      }else{
          echo " <div class=\"alert alert-warning\">
                  <strong> <h3>Esse periodo já foi fechado</h3></strong> 
          <br> Não há lançamentos para a competencia de {$fmesComp}/{$fanoComp} com data de baixa  {$fDT}

          </div>";

      }

      }//fim if fechamento
   }// fim Isset


      
?>

<style type="text/css">

.custom {
    width: 105px !important;
}

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

          <?php
          $tituloPrincipal = "";
          $tituloSecondario = "";
          $navPagina = "Inadimplentes";
          ?>
            <!-- TITULO e cabeçalho das paginas  -->
                  <div class="page-title">
                      <div class="row">
                          <div class="col-12 col-md-6 order-md-1 order-last">
                              <h3><?=$tituloPrincipal?><br><br>
                              <small><?=$$tituloSecondario?></small></h3>
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

                <!-- TITULO e cabeçalho das paginas  -->
                <div id="ListagemINAD" class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          <img src="inadimplentes.jpg" width="100" height="100">
                           
                            INADIMPLENTES
                            <small>Listagem de remessas em aberto</small>
                        </h1>
                        <div style="display: flex; flex-direction: row; justify-content: flex-start; gap:25px; align-items:center">
                            <div>
                                Região
                                <select class="form-control" id="slregiao">
                                    <option value="">Todas as Regiões</option>
                                    <option value="3">Nordeste</option>
                                    <option value="4">Norte</option>
                                    <option value="11">Centro-oeste</option>
                                    <option value="5">Sudeste 1</option>
                                    <option value="6">Sudeste 2</option>
                                    <option value="7">Sudeste 3</option>
                                    <option value="8">Sul 1</option>
                                    <option value="9">Sul 2</option>
                                    <option value="10">Sul 3</option>
                                    <option value="1">Missões Nacionais</option>
                                </select>
                            </div>

                            <div>
                                <label><input id="chkMeses" type="checkbox" value=""> 3 meses ou mais</label>
                            </div>

                            <div>
                                <input class="btn btn btn-info" onclick="javascript:imprimirPDF()" value="Imprimir Posição" />
                            </div>
                        </div>

                        <div style="margin-top: 25px;">
                            <input id="btnFechar" class="btn btn-info" onclick='javascript:showFiltroDataFechamento()' value='Fechar Mes' />

                              <div id='liFiltroData' style='display:none;margin-top:8px;'>

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
                                    <select id="selectAno" class="form-control" >
                                      <option>Ano</option>
                                    </select>
                                  </div>

                                  <div class="col-lg-2" >
                                    <a href="javascript:fecharMes();" class="btn btn-sm btn-primary">OK</a>                       
                                  </div>
                              </div>                                  

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
                                        <th>Região</th>
                                        <th>Campo</th>
                                        <th>Pr. titular</th>
                                        <th>Atraso</th>  
                                        <!-- <th>Estado </th> -->
                                        <th></th>

                                    </tr>

                                    <?php 
                                    //Lista os contas a Receber
                                    echo "<tr>";

                                    $whereRegiao = "";
                                    if(isset($_GET['idregiao'])){

                                      $whereRegiao = " and r.id = ". $_GET['idregiao'] ."   ";
                                    }

                                        


                                     




                                    //Lista Apenas Campos Eclesiáticos                                
                                        $resultSelect = $db->query("
                                                  SELECT    
                                                  r.Nome as Regiao,  
                                                  u.id,
                                                  u.Nome,
                                                  c.NomePastorTitular,
                                                  count(u.id) as MesesEmAberto   

                                                  FROM
                                                  lancamentosbancarios LB
                                                  join usuarios u on (u.id = LB.idUsuario)
                                                  join congregacoes gr on (gr.id = u.idCongregacao)
                                                    join campos c on (c.id = gr.idCampo)
                                                    join regioes r on  (r.id = c.idRegiao)

                                                    where
                                                        LB.Valor = 0 and LB.TipoLancamento in ('Regular','Inadimplente','Fechamento')  


                                                        ". $whereRegiao."  
                                                       -- Considera o inicio do campo ()
                                                       and LB.DataReferencia > u.DataInicio
                                                       and u.idTipoUsuario <> 8 -- inativos
                                                       and u.idTipoUsuario <> 5 -- transculturais
                                                       and u.idTipoUsuario <> 7 -- Campos Evangelistico (CE)
                                                       -- para fins da convenção - autoriz pr waldir / pr Misael
                                                       -- and month(LB.DataReferencia) >= 06
                                                       -- and year(LB.DataReferencia)  >= 2012

                                                       and LB.DataReferencia >= '2012-01-01'






                                                        group by
                                                        u.id,
                                                        u.Nome
                                                        
                                                        order by count(u.id) desc ;



                                      ")->results(true);

                                          foreach($resultSelect as $rowOption ){ 
                                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                                              

                                             if(isset($_GET['six'])){

                                                if($rowOption['MesesEmAberto'] < 3 ){ continue; }

                                             };

                                              echo "<tr>";
                                              echo "<td > <span class='label label-success'>". nl2br( $rowOption['Regiao']) ."</span> </td>";
                                              echo "<td> ". nl2br( $rowOption['Nome']) ."</td>";
                                              echo "<td> <a href='editar-usuarios.php?id=".$rowOption['id']."' >". nl2br( $rowOption['NomePastorTitular']) ."</a></td>";
                                              
                                              echo "<td style='background-color:#EEEEEE; color:blue;'  ><B>"."<a href='lancamentos-campo.php?id=".$rowOption['id']."' ><span class='label label-danger'>". nl2br(ceil( $rowOption['MesesEmAberto'] )) ." meses  </B></span> </td>";
                                             

                                              echo "
                                                    </td>";
                                              echo "</tr>";

                                              //echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
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

                            <br><br><br>
                        </div>

                    </div>
                </div>

               

<?php include("footer.php")    ; ?>

<script type="text/javascript">

    $('#slregiao').on('change', function (e) {
      //var optionSelected = $("option:selected", this).value();
      window.location.href = "inadimplentes.php?idregiao=" + this.value;
    });


$(document).ready(function() {
    $('#chkMeses').change(function() {
        if($(this).is(":checked")) {          
            var url      = window.location.href;     // Returns full URL
            if(url.indexOf('?') >= 0){
                window.location.href = url + "&six=true";
            }else{window.location.href = url + "?six=true";}
        }
    });
});


//------------
// 
//------------
function showFiltroDataFechamento(){
    //$( "#liFiltroDataEmissao" ).show( "slow", function() {});
        //Esconde demais divs
    $( "#liFiltroData" ).show( "slow", function() {});
    $( "#liFiltroData" ).css('display', 'flex'); // Garantir que o estilo display:flex seja aplicado
    $( "#liFiltroData" ).css('flex-direction', 'row'); // Definindo a direção do flex
    $( "#liFiltroData" ).css('justify-content', 'space-evenly'); // Definindo o alinhamento do flex
    $( "#btnFechar" ).hide( "slow", function() {});


    //var fMes  = $("#selectMesEmissao").val();
    //var fAno  = $("#selectAnoEmissao").val();
    //var ftype = "fechamento";
    //window.location.href = "inadimplentes.php?mes="+fMes+"&ano="+fAno+"&type="+ftype;

}


//------------
// 
//------------
  // Selecionando o elemento select
  var selectAno = document.getElementById("selectAno");

  // Definindo o ano inicial e final
  var anoInicial = 2008;
  var anoFinal = 2036;

  // Loop para adicionar as opções de ano
  for (var ano = anoInicial; ano <= anoFinal; ano++) {
    var option = document.createElement("option");
    option.value = ano;
    option.text = ano;
    selectAno.appendChild(option);
  }

  // Função para fechar o mês com o ano selecionado
  function fecharMes() {
    var fMes = $("#selectMes").val();
    var fAno = $("#selectAno").val();
    var ftype = "fechamento";
    window.location.href = "inadimplentes.php?mes=" + fMes + "&ano=" + fAno + "&type=" + ftype;
  }


function imprimirPDF(){

//var html = getElementById("divposicao").value;
//var html = $("<div />").append($("#divposicao").clone()).html();
//$("#fhtml").val(html);
//alert();
//$("#formulario").submit();
var url      = window.location.href;     // Returns full URL
$("#wrapper a").removeAttr("href").css("cursor","pointer");
$("#ListagemINAD").css("display", "none");

window.print();

window.location.href = url;     // Returns full URL

//$("#tbUsuarios a").removeAttr("href").css("cursor","pointer");

}


</script>                


<?php

function verificaIniciodoCampo( $fdata, $fIdUsuario){

    $db = DB::getInstance();
    $rs = $db->query("select count(*) as total 
                        from usuarios u 
                      where u.id = {$fIdUsuario} 
                        and  '{$fdata}' > u.DataInicio    ");
    $row=$rs->results(true);

    //Caso a data de inicio for menor que a competencia
    //RetornaTrue e gera o fechamento
    if($row['total'] > 0){
        //echo "total  {$row['total']} - ja existe<br>";  
        return true;
    }else{
        //echo "total  {$row['total']} - nao existe existe<br>";    
        return false;
    }


}





?>