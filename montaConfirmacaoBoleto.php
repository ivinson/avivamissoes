<?php 
include('config.php'); 

$fID =  $_GET['id'] ;
$result = mysql_query("select 
                        usuarios.Nome as NomeEmissor
                      , usuarios.id as IdUsuario
                      , campos.id as idCampo
                      , campos.Nome as NomeDoCampo
                      , campos.NomePastorTitular as PastorTitular
                      , campos.Email as EmailCampo 

                      from usuarios 
                      join congregacoes on usuarios.idCongregacao = congregacoes.id
                      join campos on congregacoes.idCampo = campos.id

                      where usuarios.id = ".$fID." order by NomeEmissor ") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 

//echo "<div class=\"main\">";
//echo "<div class=\"container\">";
//echo "<div class=\"span12\">";


echo "<table width='100%'>";
//echo "<tr><td spanCOL=2> </td> </tr>"; 

//echo "<tr><td><label> Data de Vencimento</label> <label> Referente</label> </td></tr>";
echo "<tr><td><label> Valor</label> <input class=\"form-control\" 
        id='txtValor' type='text' name='txtValor' value=\"\"/></td></tr>";




echo "<tr><td><label> Referente ao mês </label> ";


echo "<select class=\"form-control\" id='selectMes'>
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
      </select>

      <label> Referente ao ano </label>
      ";

echo @"<select class=\"form-control\" name='ano' id='selectAno' onChange='funcMostraBotao();'>
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