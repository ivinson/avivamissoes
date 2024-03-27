<?php 
include('config.php'); 

$fID =  $_GET['id'] ;
$result = mysql_query("                                        
                            SELECT 
                                          lb.*,
                                            DATEDIFF( cr.DataEmissao, curdate()) as DiasAtraso
                                            ,DATE_FORMAT(cr.DataReferencia, '%m/%Y') AS Referente
                                            ,DATE_FORMAT(cr.DataEmissao, '%d/%m/%Y') AS DataEmissao
                                            ,cr.*, u.*, cr.Valor as ValorBoleto

                                         FROM

                                          lancamentosbancarios lb 
                                            join contasreceber cr on (cr.id = lb.idContaReceber)
                                            join usuarios u on (u.id = cr.idusuario)

                      where lb.id = ".$fID." ") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 

//echo "<div class=\"main\">";
//echo "<div class=\"container\">";
//echo "<div class=\"span12\">";


echo "<table width='100%'>";
echo "<tr><td><b>  </b>  </td></tr>";
echo "<tr><td spanCOL=2><b>{$row['NomeDoCampo']}  </b> </td> </tr>"; 

//echo "<tr><td><label> Data de Vencimento</label> <label> Referente</label> </td></tr>";
echo "<tr><td><label> Valor</label> <input  id='txtValor' type='text' name='txtValor' value=\"\"/></td></tr>";




echo "<tr><td><label> Referente a </label> ";


echo "<select id='selectMes'>
        <option>Escolha o mês</option>
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
      </select>";

echo @"<select name='ano' id='selectAno' onChange='funcMostraBotao();'>
        <option>Selecione ano</option>";
      
  
        for ($i = 2006; $i <= date("Y")+1; $i++) {
        
            print("<option value=$i");
               //if($editar['ano'] == $i){print "selected";}
             print ">$i</option>";
           };

      echo @" </select>";


echo "</td></tr>";
//echo "<tr><td><label> CAMPO / PASTOR TITULAR </label></td><td><label> {$row['EmailCampo']} </label> </td></tr>"; 
echo "  ";
echo "</table>";



} 


?>