<?php  session_start();

  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
      
?>



<script src="http://mrrio.github.io/jsPDF/dist/jspdf.debug.js"></script>

<!-- Para criar o excel exportado-->
<iframe id="txtArea1" style="display:none"></iframe>                
                

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


                          <div class="navbar-collapse ">
                              

                                  <!-- Por data de emissão -->
                                

                                    <div class="col-lg-2">
                                    <h4>Entradas em </h4>
                                  </div>
                                  
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
                                      <option value="2021">2021</option>
                                      <option value="2022">2022</option>
                                      <option value="2023">2023</option>
                                      <option value="2024">2024</option>
                                    </select>
                                  </div>

                                   <div class="col-lg-2" style="margin-top: 7px;">
                                 
                                    <a href="javascript:getFiltroDataEmissao();" class="btn btn-sm btn-warning">OK</a>                       
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
    $resultRegioes = mysql_query("  Select * from regioes where id<>2") or trigger_error(mysql_error()); 

      //SELECIONA TODAS AS REGIOES 
      while($rowOptionRegioes = mysql_fetch_array($resultRegioes)){ 
      foreach($rowOptionRegioes AS $key => $value) { $rowOptionRegioes[$key] = stripslashes($value); }  


          echo "<div  id='reg_{$rowOptionRegioes['id']}' class='col-md-12' style=' border:1px !Important;'> <h3 style='background-color:#FFC107;'>".$rowOptionRegioes['Nome'] ." </h3>";
          //PARA CADA REGIAO, SELECIONAMOS TODOS OS CAMPOS
          $resultCampos = mysql_query("  

                          select u.* from usuarios u 
                          join congregacoes cg on (u.idCongregacao = cg.id)
                          join campos c on (cg.idCampo = c.id)
                          join regioes r on (c.idRegiao = r.id)
                                where r.id = {$rowOptionRegioes['id']}

                                and u.idTipoUsuario <> 8 -- inativos

                                order by u.Nome
                                ;
            ") or trigger_error(mysql_error()); 

              #Tabela de campos
              echo "<table class='table table-condensed'>";  
              //echo "<thead> <tr> <th> Nome </th> <th> Valor </th> <th> Comp. </th> </tr> </thead>";
              echo "<tbody>";

              //SELECIONA TODOS OS CAMPOS 
              while($rowOptionCampos = mysql_fetch_array($resultCampos)){ 
              foreach($rowOptionCampos AS $key => $value) { $rowOptionCampos[$key] = stripslashes($value); }  




                    ##Debug
              //echo " Select * from lancamentosbancarios  lb
                //                    where 
                ////                    ". $whereMes . "
                //                    AND lb.idUsuario = {$rowOptionCampos['id']};";

                    //PARA CADA CAMPO, VER AS MOVIMENTACOES DO MES, SOMAR E CONCATENAR
                    //AS COMPETENCIAS
                    $resultMovimento = mysql_query("  

                                    Select lb.*
                                      ,DATE_FORMAT(lb.DataReferencia, '%m/%y') AS dtReferente

                                     from lancamentosbancarios  lb
                                    where 
                                    ". $whereMes . "
                                    AND lb.idUsuario = {$rowOptionCampos['id']}
                                    order by lb.DataReferencia asc
                                    
                                    ;
                      ") or trigger_error(mysql_error());  



                        $vl_totalMes = 0;
                        $concat_Competencias = "";    

                        

                        //SELECIONA TODOS OS CAMPOS 
                        while($rowOptionMovimento = mysql_fetch_array($resultMovimento)){ 
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