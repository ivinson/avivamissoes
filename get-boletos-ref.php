<?php 
$divConfirmReimpressao = 
"                  <!-- Default panel contents -->
<div id=\"dvTitleConfirm\" class=\"panel-heading\">#TITULO# </div>
<!-- Table -->
<table class=\"table\">
<tr><td><span class=\"glyphicon glyphicon-map-marker\" aria-hidden=\"true\"></span></td><td>Campo</td><td id=\"tdCampo\"  >#CAMPO#</td></tr>
<tr><td><span class=\"glyphicon glyphicon-barcode\" aria-hidden=\"true\"></span></td><td>Valor</td><td id=\"tdValor\">#VALOR#</td></tr>
<tr><td><span class=\"glyphicon glyphicon-calendar\" aria-hidden=\"true\"></span></td><td>Data de Referência</td><td id=\"tdData\">#DATA#</td></tr>
<tr><td><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></td><td>CNPJ/CPF</td> <td id=\"tdCNPJ\">#CNPJ#</td></tr>
<tr><td><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></td><td>Nosso Numero</td><td id=\"tdNN\">#NN#</td></tr>
<tr><td><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></td><td>Codigo Barras</td><td id=\"tdCodBarra\">#CODBARRA#</td></tr>

</table>
<br><br>



<button 
style=\"margin-right: 15px !important;\"

class=\"btn btn-success btn-lg pull-right\" 
  type=\"button\" onClick=\"funcReimprimirBoleto();\">
    Desejo Re-imprimir esse boleto
</button> 



<button 
style=\"margin-right: 15px !important;\"
class=\"btn btn-info btn-lg pull-right\" 
  type=\"button\" onClick=\"funcEmiteBoleto();\">
    Desejo imprimir um NOVO <br>boleto com as informações que digitei anteriormente
</button>

 <input type=\"hidden\" id=\"hdValor2Via\" name=\"hdValor2Via\" value=\"#Valor2Via#\" />

 <input type=\"hidden\" id=\"hdCODBARRA\" name=\"hdCODBARRA\" value=\"#CODBARRA#\" />
  <input type=\"hidden\" id=\"hdNN\" name=\"hdNN\" value=\"#NN#\" />

";

$divConfirm = 
"                  <!-- Default panel contents -->
<div id=\"dvTitleConfirm\" class=\"panel-heading\">#TITULO# </div>
<!-- Table -->
<table class=\"table\">
<tr><td><span class=\"glyphicon glyphicon-map-marker\" aria-hidden=\"true\"></span></td><td>Campo</td><td id=\"tdCampo\"  >#CAMPO#</td></tr>
<tr><td><span class=\"glyphicon glyphicon-barcode\" aria-hidden=\"true\"></span></td><td>Valor</td><td id=\"tdValor\">#VALOR#</td></tr>
<tr><td><span class=\"glyphicon glyphicon-calendar\" aria-hidden=\"true\"></span></td><td>Data de Referência</td><td id=\"tdData\">#DATA#</td></tr>
<tr><td><span class=\"glyphicon glyphicon-pencil\" aria-hidden=\"true\"></span></td><td>CNPJ/CPF</td> <td id=\"tdCNPJ\">#CNPJ#</td></tr>
</table>
<br><br>

<button 
style=\"margin-right: 15px !important;\"

class=\"btn btn-success btn-lg pull-right\" 
  type=\"button\" onClick=\"funcEmiteBoleto();\">
    Deseja imprimir o boleto com essas informações?
</button> 




";




include('config.php'); 
 //$divConfirm = "";
  if($_GET['function']== "getBoletos"){
    #id 
    $id   = (int) $_GET['id']; 
    $data = $_GET['ano'] .'-'. $_GET['mes'];
    //if ($_GET['function']=='CNPJ'){ 

        //Lista Apenas Campos Eclesiáticos                                
        $result = $db->query("        
           select * from contasreceber 
                   where idUsuario      = {$id} 
                     and Status         = 'Pendente'
                     and DataReferencia = '{$data}-15 00:00:00'  
                     order by id desc 
         ")->results(true) or trigger_error($db->errorInfo()[2]); 


                    

        $rowCount = $result->num_rows;


        ##Ja existe um ou mais boletos 
        ##para esse mes e ano
        //echo "<br> linhas " . $rowCount;
//         if($rowCount > 0){
//            //echo "select * from usuarios where id = {$id}";
//             while($row = mysql_fetch_array($result)){ 
//               foreach($row AS $key => $value) { 
//                 $row[$key] = stripslashes($value); 
//               }  
            
            
//             //echo "---";
//             //$divConfirm = V_Div_Confirmacao;  
//             $divConfirmReimpressao = str_replace("#CAMPO#", $_GET['campo'], $divConfirmReimpressao);
//             //$divConfirm = str_replace("#VALOR#", $_GET['valor'], $divConfirm);
//             $divConfirmReimpressao = str_replace("#VALOR#", $row['Valor'], $divConfirmReimpressao);
//             $divConfirmReimpressao = str_replace("#Valor2Via#", $row['Valor'], $divConfirmReimpressao);

//             $divConfirmReimpressao = str_replace("#DATA#",  $_GET['mes'] ."/".$_GET['ano'], $divConfirmReimpressao);
//             $divConfirmReimpressao = str_replace("#CNPJ#", $_GET['cnpj'], $divConfirmReimpressao);
//             $divConfirmReimpressao = str_replace("#TITULO#", "<h4><span style='color:red !important;'> ATENÇÃO: Já existe boleto(s) emitidos para esse mês com os dados abaixo </span></h4>", $divConfirmReimpressao);

//             $divConfirmReimpressao = str_replace("#NN#", $row['NossoNumero'], $divConfirmReimpressao);
//             $divConfirmReimpressao = str_replace("#CODBARRA#", $row['CodigoBarra'], $divConfirmReimpressao);

//             $divConfirmReimpressao = str_replace("#NN#", $row['NossoNumero'], $divConfirmReimpressao);
//             $divConfirmReimpressao = str_replace("#CODBARRA#", $row['CodigoBarra'], $divConfirmReimpressao);

//  }
//             echo $divConfirmReimpressao;
       

//              //echo "<h1>Já existe boleto</h1> "; 
//         }else{
            ## Monta div de confirmação com a opção de emitir um novo boleto 
            //$divConfirm = V_Div_Confirmacao;  
            $divConfirm = str_replace("#CAMPO#", $_GET['campo'], $divConfirm);
            $divConfirm = str_replace("#VALOR#", $_GET['valor'], $divConfirm);
            //$divConfirm = str_replace("#VALOR#", $row['Valor'], $divConfirm);
            $divConfirm = str_replace("#DATA#",  $_GET['mes'] ."/".$_GET['ano'], $divConfirm);
            $divConfirm = str_replace("#CNPJ#", $_GET['cnpj'], $divConfirm);
            $divConfirm = str_replace("#TITULO#", "<img heigth='80' width='80' src='checkmark.gif' />Confirme as informações para emitir um boleto com os seguintes dados:", $divConfirm);            
              echo $divConfirm;
             //echo "<h1>Não Existe/h1> "; 
        // }




}
?>