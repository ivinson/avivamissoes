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
          $rsCamposSemLancamento = $db->query("

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
                                
            ")->results(true) or trigger_error($db->errorInfo()[2]); 



                               // exit;


        $countLancamentos = 0;

        foreach($rsCamposSemLancamento as $rowOption ){ 
          foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
            

          if($rowOption['id'] <> 981){
            continue;
          }



            echo "<br>";
            echo " Lancamento gerado para ".$rowOption['Nome']." .";
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

            Echo $fDT;
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

            echo "<br>" . $SqlInsereProcessamento;

            //exit;
            
                
            
            //Verificar se a data de inicio dele éanterior ao fechamento do mes solicitado
            $fData_Competencia = $fanoComp.'-'.$fmesComp ."-15";

            echo "<br>Codigo Juazeiro : " . $rowOption['id'] ;
            
            #Debug
            if($rowOption['id'] == 981){


              echo $fData_Competencia. "<br>";
              echo $rowOption['id'] . "<br>";

            if ( verificaIniciodoCampo($fData_Competencia, $rowOption['id'])){
              //exit;

              if (! $db->query($SqlInsereProcessamento) ){
              
                    die( ':: Erro : '. $db->errorInfo()[2]); 
              
                    echo "Fase de teste lancamentosbancarios: Anote o seguinte erro!";
                  }else{            
                    $countLancamentos++;
                }
        
          }

      }//Fim DEbug


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

                <!-- TITULO e cabeçalho das paginas  -->
                <div id="ListagemINAD" class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          <img src="inadimplentes.jpg" width="100" height="100">
                           
                            INADIMPLENTES
                            <small>Listagem de remessas em aberto</small>
                        </h1>
                        <ol class="breadcrumb">

                            <li class="active">

                                Região
                                <select class="form-control" id="slregiao">
                                  <option value="">Todas as Regiões</option>
                                  <option value="1">Missões Nacionais</option>
                                  <option value="3">Nordeste</option>
                                  <option value="4">Norte</option>
                                  <option value="5">Sudeste 1</option>
                                  <option value="6">Sudeste 2</option>
                                  <option value="7">Sudeste 3</option>                                  
                                  <option value="8">Sul 1</option>
                                  <option value="9">Sul 2</option>
                                  <option value="10">Sul 3</option>                                                              
                                  <option value="11">Centro-oeste</option>
                                  
                                </select>

                            </li>

                            <li>
                              <label><input  id="chkMeses" type="checkbox" value=""> 6 meses ou mais</label>
                            </li>

                            <li> 
                              <input class="btn btn btn-info" onclick='javascript:imprimirPDF()' value='Imprimir Posição' />
                            </li>

                            <li>
                                <input id="btnFechar" class="btn btn-info custom" onclick='javascript:showFiltroDataFechamento()' value='Fechar Mes' />

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
                                        <select id="selectAno" class="form-control" >
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

                                      <div class="col-lg-2" >
                                        <a href="javascript:fecharMes();" class="btn btn-sm btn-primary">OK</a>                       
                                      </div>
                                  </li>                                  

                            </li>

                        </ol>
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
                                                       -- para fins da convenção - autoriz pr waldir / pr Misael
                                                       
                                                      and LB.DataReferencia >= '2012-06-01'
                                                       -- and month(LB.DataReferencia) >= 06
                                                       -- and year(LB.DataReferencia)  >= 2012







                                                        group by
                                                        u.id,
                                                        u.Nome
                                                        
                                                        order by count(u.id) desc ;



                                      ")->results(true) or trigger_error($db->errorInfo()[2]); 

                                          foreach($resultSelect as $rowOption){ 
                                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                                              

                                             if(isset($_GET['six'])){

                                                if($rowOption['MesesEmAberto'] < 6 ){ continue; }

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
      window.location.href = "debug_inadimplentes.php?idregiao=" + this.value;
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
    $( "#btnFechar" ).hide( "slow", function() {});


    //var fMes  = $("#selectMesEmissao").val();
    //var fAno  = $("#selectAnoEmissao").val();
    //var ftype = "fechamento";
    //window.location.href = "inadimplentes.php?mes="+fMes+"&ano="+fAno+"&type="+ftype;

}


//------------
// 
//------------
function fecharMes(){
    //Esconde demais divs
    //$( "#liFiltroData" ).show( "slow", function() {});

    var fMes  = $("#selectMes").val();
    var fAno  = $("#selectAno").val();
    var ftype = "fechamento";
    window.location.href = "debug_inadimplentes.php?mes="+fMes+"&ano="+fAno+"&type="+ftype;


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
    // Realize a conexão com o banco de dados
    $db = DB::getInstance();
    $rs = $db->query("select count(*) as total 
                        from usuarios u 
                      where u.id = {$fIdUsuario} 
                        and  '{$fdata}' > u.DataInicio   ");

    #echo "<br>#Debug VerificaIniciodoCampo : ";
    #echo "<br>";
    #echo "select count(*) as total 
    #                    from usuarios u 
    #                  where u.id = {$fIdUsuario} 
    #                    and  month('{$fdata}') > month(u.DataInicio)                        
    #                   and year('{$fdata}') >= year(u.DataInicio) ";

    $row=$rs->results(true);

    //Caso a data de inicio for menor que a competencia
    //RetornaTrue e gera o fechamento
    if($row['total'] > 0){
        echo "total  {$row['total']} - ja existe<br>";  
        return true;
    }else{
        echo "total  {$row['total']} - nao existe existe<br>";    
        return false;
    }


}





?>