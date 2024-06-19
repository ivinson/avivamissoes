<?php  session_start();

  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
      
?>

<style>
    .toggle-button {
        position: relative;
        cursor: pointer;
    }
    .arrow {
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        margin: 10px auto;
        transition: transform 0.3s ease;
    }
    .arrow-down {
        border-top: 6px solid #333;
    }
    .arrow-up {
        border-bottom: 6px solid #333;
    }
</style>

<script src="http://mrrio.github.io/jsPDF/dist/jspdf.debug.js"></script>

<!-- Para criar o excel exportado-->
<iframe id="txtArea1" style="display:none"></iframe>                
                

<div class="row" style="margin-bottom:120px">
  <div class="navbar navbar-default">
      <div class="container">
  
          <div class="navbar-header">
              <button type="button" class="toggle-button btn btn-sm btn-light" data-toggle="collapse" data-target=".navbar-collapse">
                <div class="arrow arrow-down"></div>
              </button>
              <a class="navbar-brand" href="#"></a>
          </div>


          <div class="navbar-collapse ">
              

            <!-- Por data de emissão -->
            <div style="display:flex; justify-content:flex-start; align-items:center; flex-wrap:wrap">
              <h4 style="margin-top: 7px;">Entradas em </h4>
              <div class="col-lg-2" style="margin-top: 7px;">
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

              <div class="col-lg-2" style="margin-top: 7px;">
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

              <div class="col-lg-2" style="margin-top: 7px;">
              
                <a href="javascript:getFiltroDataEmissao();" class="btn btn-sm btn-light">OK</a>                       
              </div>
            </div>
          </div>
          <!--/.nav-collapse -->
      </div>
  </div>                  
</div>





<div class="row" id="divCampos">


<?php 
//Lista os contas a Receber
$fTotalRegiao = 0;
$countLanc = 0;
$AgrupamentoReferencia = ""; 
$AgrupamentoEmissao = ""; 
$fTotalEntradas=0;




if (isset($_GET['type']) ) { 

    $type = (string) $_GET['type'];                                 
    $fano = $_GET['ano'];
    $fmes = $_GET['mes']; 
     
    if($type == "dtEmissao"){
        $whereMes = "";
        $whereAno = "";  
        if($fmes != "Mês"){
          $whereMes = "MONTH(lb.DataBaixa) = {$fmes} AND YEAR(lb.DataBaixa) = {$fano}";
        }
    }                              

     
    //Lista TODAS AS REGIOES                             
    $resultRegioes = $db->query("  Select * from regioes where id<>2")->results(true) or trigger_error($db->errorInfo()[2]); 

      //SELECIONA TODAS AS REGIOES 
      foreach($resultRegioes as $rowOptionRegioes ){ 
      foreach($rowOptionRegioes AS $key => $value) { $rowOptionRegioes[$key] = stripslashes($value); }  


          echo "<div  id='reg_{$rowOptionRegioes['id']}' class='col-md-12' style=' border:1px !Important;'> <h3 style='background-color:#FFC107;'>".$rowOptionRegioes['Nome'] ." </h3>";
          //PARA CADA REGIAO, SELECIONAMOS TODOS OS CAMPOS
          $resultCampos = $db->query("  

                          select u.* from usuarios u 
                          join congregacoes cg on (u.idCongregacao = cg.id)
                          join campos c on (cg.idCampo = c.id)
                          join regioes r on (c.idRegiao = r.id)
                                where r.id = {$rowOptionRegioes['id']}

                                and u.idTipoUsuario <> 8 -- inativos

                                order by u.Nome
                                ;
            ")->results(true) or trigger_error($db->errorInfo()[2]); 

              #Tabela de campos
              echo "<table class='table table-condensed'>";  
              //echo "<thead> <tr> <th> Nome </th> <th> Valor </th> <th> Comp. </th> </tr> </thead>";
              echo "<tbody>";

              //SELECIONA TODOS OS CAMPOS 
              foreach($resultCampos as $rowOptionCampos ){ 
              foreach($rowOptionCampos AS $key => $value) { $rowOptionCampos[$key] = stripslashes($value); }  




                    ##Debug
              //echo " Select * from lancamentosbancarios  lb
                //                    where 
                ////                    ". $whereMes . "
                //                    AND lb.idUsuario = {$rowOptionCampos['id']};";

                    //PARA CADA CAMPO, VER AS MOVIMENTACOES DO MES, SOMAR E CONCATENAR
                    //AS COMPETENCIAS
                    $resultMovimento = $db->query("  

                                    Select lb.*
                                      ,DATE_FORMAT(lb.DataReferencia, '%m/%y') AS dtReferente

                                     from lancamentosbancarios  lb
                                    where 
                                    ". $whereMes . "
                                    AND lb.idUsuario = {$rowOptionCampos['id']}
                                    order by lb.DataReferencia asc
                                    
                                    ;
                      ")->results(true) or trigger_error($db->errorInfo()[2]);  



                        $vl_totalMes = 0;
                        $concat_Competencias = "";    

                        

                        //SELECIONA TODOS OS CAMPOS 
                        foreach($resultMovimento as $rowOptionMovimento ){ 
                        foreach($rowOptionMovimento AS $key => $value) { $rowOptionMovimento[$key] = stripslashes($value); }                      

                            $vl_totalMes = $vl_totalMes + $rowOptionMovimento['Valor'];

                            //echo "---" . $rowOptionMovimento['Valor'];
                            
                            //Concatena as competencias diferentes pagas num mesmo mes
                            if($concat_Competencias != ""){
                              $concat_Competencias = $concat_Competencias.",". $rowOptionMovimento['dtReferente'];
                            }else{
                              $concat_Competencias = $rowOptionMovimento['dtReferente'] .",";
                            } 
                            

                        }
                        
                        //Formatacoes para a planilha
                        $moeda = number_format( $vl_totalMes , 2, ',', '.');
                        $competencias_final =  str_replace(",,",",",$concat_Competencias);
                        
                        //echo $competencias_final . "<br>";
                        //echo $concat_Competencias . "--- <br>";
                          

                     echo "<tr>  <td>{$rowOptionCampos['Nome']}</td> <td>{$moeda}</td> <td>{$competencias_final}</td> </tr>";
              
               $fTotalRegiao = $fTotalRegiao + $vl_totalMes;
               
              

              }

             
             

              echo "<tr>  <td>Total da regiao </td> <td>{$fTotalRegiao}</td> <td></td> </tr>";

              echo " </tbody> </table>";
                  
            echo "</div>";  
            
            $fTotalEntradas =  $fTotalEntradas + $fTotalRegiao; 
            $fTotalRegiao=0;

    
    #debug 
    //break;
    
    
      } 

        # TOTAL de entradas      

        #Tabela de campos
        //echo $fTotalEntradas;
        echo "<table class='table table-condensed'>";  

        //echo "<thead> <tr> <th> Nome </th> <th> Valor </th> <th> Comp. </th> </tr> </thead>";
        echo "<tbody>";
        echo "<tr>  <td><h2>Total geral </h2></td> <td><h2>R$ ".number_format($fTotalEntradas,2)."</h2></td> <td></td> </tr>";
        echo " </tbody> </table>";

}else{

//echo '#########Escolha um periodo! #####################';
//exit;
}

                                                        
?>


    
        
</div>  


</div>

</div>


</div>

<?php include("footer.php")    ; ?>

<script type="text/javascript">

// Read a page's GET URL variables and return them as an associative array.
function getUrlVars()
{
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}


function getFiltroDataEmissao(){
   // $( "#liFiltroDataEmissao" ).show( "slow", function() {});
        //Esconde demais divs
   // $( "#liFiltroData" ).hide( "slow", function() {});

   //alert();

    var fMes  = $("#selectMesEmissao").val();
    var fAno  = $("#selectAnoEmissao").val();
    var ftype = "dtEmissao";
    window.location.href = "rel-financeiro.php?mes="+fMes+"&ano="+fAno+"&type="+ftype;

}


function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('#divCampos'); // id of table

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

</script>                


<script>
    function demoFromHTML() {
        var pdf = new jsPDF('p', 'pt', 'letter');
        // source can be HTML-formatted string, or a reference
        // to an actual DOM element from which the text will be scraped.
        source = $('#divCampos')[0];

        // we support special element handlers. Register them with jQuery-style 
        // ID selector for either ID or node name. ("#iAmID", "div", "span" etc.)
        // There is no support for any other type of selectors 
        // (class, of compound) at this time.
        specialElementHandlers = {
            // element with id of "bypass" - jQuery style selector
            '#bypassme': function (element, renderer) {
                // true = "handled elsewhere, bypass text extraction"
                return true
            }
        };
        margins = {
            top: 80,
            bottom: 60,
            left: 40,
            width: 522
        };
        // all coords and widths are in jsPDF instance's declared units
        // 'inches' in this case
        pdf.fromHTML(
        source, // HTML string or DOM elem ref.
        margins.left, // x coord
        margins.top, { // y coord
            'width': margins.width, // max width of content on PDF
            'elementHandlers': specialElementHandlers
        },

        function (dispose) {
            // dispose: object with X, Y of the last line add to the PDF 
            //          this allow the insertion of new lines after html
            pdf.save('Test.pdf');
        }, margins);
    }




function ImprimirRelatorio(){

$(document).ready(function() {

//alert();
  $( "#td_Norte").html( $("#reg_3").html() );
  $( "#td_Nordeste").html( $("#reg_4").html() );
  $( "#td_Sudeste1").html( $("#reg_5").html() );
  $( "#td_Sudeste2").html( $("#reg_6").html() );

});



}

</script>

<script>
    $(document).ready(function() {
        $('.toggle-button').on('click', function() {
            var expanded = $(this).attr('aria-expanded') === 'true';
            var arrow = $(this).find('.arrow');
            
            if (expanded) {
                arrow.removeClass('arrow-up').addClass('arrow-down');
            } else {
                arrow.removeClass('arrow-down').addClass('arrow-up');
            }

            $(this).attr('aria-expanded', !expanded);
        });
    });
</script>