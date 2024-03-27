<?php 
include('config.php'); 

$fID =  $_GET['id'] ;


$result = mysql_query(" select lb.*
                      , usuarios.Nome as NomeEmissor
                      , usuarios.id as IdUsuario
                      , campos.id as idCampo
                      , campos.Nome as NomeDoCampo
                      , campos.NomePastorTitular as PastorTitular
                      , campos.Email as EmailCampo 
                      , regioes.Nome as NomeRegiao
                      , lb.MotivoAjuste

                      from usuarios 
                      join congregacoes on usuarios.idCongregacao = congregacoes.id
                      join campos on congregacoes.idCampo = campos.id
                      join lancamentosbancarios lb on (lb.idUsuario = usuarios.id )
                      join regioes on (regioes.id = campos.idRegiao)

                      where lb.id = ".$fID." order by NomeEmissor ") or trigger_error(mysql_error()); 



while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 

//echo "<br>" . $row['Valor'];


$LinkAnexo = $row['Anexos'];
$Anexos = "";
if($LinkAnexo != ""){

$Anexos =  " <a style='color:red;'  target='_blank' href='{$LinkAnexo}' ><i class='fa fa-paperclip'></i></a>" ;

}                                              


echo "<table width='100%'>";
//echo "<tr><td spanCOL=2> </td> </tr>"; 

//echo "<tr><td><label> Data de Vencimento</label> <label> Referente</label> </td></tr>";
echo "<tr><td><label> Região</label> {$row['NomeRegiao']}  </td></tr>";
echo "<tr><td><label> Campo</label> {$row['NomeDoCampo']}  </td></tr>";
echo "<tr><td><label> Valor</label> {$row['Valor']} </td></tr>";
echo "<tr><td><label> Referente ao mês </label>".$row['DataReferencia']."</td></tr> ";
echo "<tr><td><label> Detalhamento :  </label>".$row['Descricao']."</td></tr> ";
echo "<tr><td><label> Anexo </label>".$Anexos."</td></tr> ";
echo "<tr><td><label> Motivo do Ajuste  </label>".nl2br($row['MotivoAjuste'])."</td></tr> ";
echo "</table>";



} 


?>