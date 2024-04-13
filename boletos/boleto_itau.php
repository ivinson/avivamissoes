
<html>
<head>
<title>Minha pagina</title>
<meta http-equiv="Content-Type" charset="ISO-8859-1">

</head>
<body>

<?php


include("../config.php"); 

header("Content-Type: text/html;  charset=ISO-8859-1",true);

//$db->query("SET NAMES 'utf8'");
//$db->query("SET character_set_connection=utf8");
//$db->query("SET character_set_client=utf8");
//$db->query("SET character_set_results=utf8");

/* Variaveis Globais para Boleto e Contas  Receber */
//Variaveis -----------------------------------------

$fID      =  $_GET['id'] ; //Id Usuario - idUsuario
$fValor   =  $_GET['Valor'];
//echo "<br />  Valor " . $fValor ; 
$ValorSemPonto = str_replace(".","",$fValor); 
//echo "<br />  ValorSemPonto " . $ValorSemPonto ; 


//echo "<br>newstring " . $newstring;

$fMesRef  =  $_GET['Mes'] ;
$fAnoref  =  $_GET['Ano'] ;
//  
//$phptime =      date("d/m/Y H:i:s");
$mysqltime        = date("Y/m/d H:i:s");
$fDataEmissao     = $mysqltime; //`DataEmissao`,
$fDataReferencia  = $fAnoref. "-" .$fMesRef ."-". "15"; //`DataReferencia`,
$fStatus          = "Pendente"; //`Status`,    
$fidProjeto       = 0; //`idProjeto`,
$fCodigoBarra     = 0; //`CodigoBarra`,
$fGeradoPor       = 0; //`GeradoPor`



//Pegar proximo numero e gravar como nosso numero
$fNossoNumero     =  0 ;
$resultNossonumero = $db->query("select max(id) + 1 as NossoNumero from contasreceber")->results(true) or trigger_error($db->errorInfo()[2]); 
foreach($resultNossonumero as $rowNN ){    
    foreach($rowNN AS $keyNN => $valueNN) { $rowNN[$keyNN] = stripslashes($valueNN); } 
      $fNossoNumero     =  $rowNN["NossoNumero"] ;
}
/* **************************************************************** */


//Select
$result = $db->query("select 
                        usuarios.Nome as NomeEmissor
                      , usuarios.id as IdUsuario
                      , campos.id as idCampo
                      , campos.Nome as NomeDoCampo
                      , campos.NomePastorTitular as PastorTitular
                      , campos.Email as EmailCampo 
                      , usuarios.Endereco
                      , usuarios.idProjetos as CodigoProjeto
                      , campos.*
                      , usuarios.*                      

                      from usuarios 
                      join congregacoes on usuarios.idCongregacao = congregacoes.id
                      join campos on congregacoes.idCampo = campos.id

                      where usuarios.id = ".$fID." ")->results(true) or trigger_error($db->errorInfo()[2]); 



// ------------------------- DADOS DIN�MICOS DO SEU CLIENTE PARA A GERA��O DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formul�rio c/ POST, GET ou de BD (MySql,Postgre,etc)	//


foreach($result as $row ){ 
    
    foreach($row AS $key => $value) { $row[$key] = stripslashes(htmlentities($value)); } 
    /*
    echo "<br>ID usuario ----> " . $fID;
    echo "<br>Valor ----> " . $fValor;
    echo "<br> Referente ao mes de  ----> " . $fMesRef;
    echo "<br> Ano ----> " . $fAnoref;
    */

	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 7;
	$taxa_boleto = 0;
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
	$data_venc_mysql = date("Y-m-d", time() + ($dias_de_prazo_para_pagamento * 86400));

  //$valor_cobrado = $fValor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
  $valor_cobrado = $ValorSemPonto;
  //echo "<br />  Valor Cobrado " . $valor_cobrado ; 	
  $valor_cobrado = str_replace(",", ".",$valor_cobrado);
  //echo "<br />  Valor Cobrado " . $valor_cobrado ; 
  //$valor_cobrado = $ValorSemPonto;
  
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
  //echo "<br />  Valor Boleto format " . $valor_boleto ; 
  //$valor_boleto=number_format($valor_cobrado, 2, ',', '');

	$dadosboleto["nosso_numero"] = $fNossoNumero;  // Nosso numero - REGRA: M�ximo de 8 caracteres!
	$dadosboleto["numero_documento"] = $fNossoNumero;	// Num do pedido ou nosso numero
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emiss�o do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com v�rgula e sempre com duas casas depois da virgula



#DEBUG ACENTO
#ECHO $row['NomeDoCampo'];
#ECHO "<BR>";
#ECHO html_entity_decode($row['NomeDoCampo']);
#ECHO "<BR>";
#ECHO htmlspecialchars($row['NomeDoCampo']);
#EXIT;


	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] =  html_entity_decode($row['NomeDoCampo']);//"Nome do seu Cliente";
	$dadosboleto["endereco1"] = html_entity_decode($row['EnderecoSede']);//"Endere�o do seu Cliente";
	$dadosboleto["endereco2"] = html_entity_decode($row['CidadeSede'] ." - ". $row['UFSede'] ." - CEP : ". $row['CEPSede']);// "Cidade - Estado -  CEP: 00000-000";

	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "Remessa de oferta referente ao mes " . $fMesRef.'/'.$fAnoref;
	$dadosboleto["demonstrativo2"] = "";//"Mensalidade referente a nonon nonooon nononon<br>Taxa banc�ria - R$ ".number_format($taxa_boleto, 2, ',', '');
	$dadosboleto["demonstrativo3"] = "";//"http://ivicomm.net";
	$dadosboleto["instrucoes1"]    = "- Sr. Caixa, n�o cobrar multa ap�s o vencimento pois essa, ";
	$dadosboleto["instrucoes2"]    = "  � uma doacao volunt�ria que recebemos";
	$dadosboleto["instrucoes3"]    = "- Em caso de d�vidas entre em contato financeiro@avivamissoes.com.br / 11 4232-9671";
	$dadosboleto["instrucoes4"]    = "";//&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"]     = "001";
	$dadosboleto["valor_unitario"] = $valor_boleto;
	$dadosboleto["aceite"]         = "";		
	$dadosboleto["especie"]        = "R$";
	$dadosboleto["especie_doc"]    = "DM";

	// ---------------------- DADOS FIXOS DE CONFIGURA��O DO SEU BOLETO --------------- //

	// DADOS DA SUA CONTA - ITA�
	$dadosboleto["agencia"] = "1381"; // Num da agencia, sem digito
	$dadosboleto["conta"] = "12182";	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = "9"; 	// Digito do Num da conta

	// DADOS PERSONALIZADOS - ITA�
	$dadosboleto["carteira"] = "157";  // C�digo da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

	// SEUS DADOS
	$dadosboleto["identificacao"] 	= "Conselho Geral da Igr.Ev. Avivamento Biblico";
	$dadosboleto["cpf_cnpj"] 		    = "05.620.322/0001-57";
	$dadosboleto["endereco"] 		    = "Rua Visconde de Inhauma,878-Oswaldo Cruz-Sao Caetano SUL";
	$dadosboleto["cidade_uf"] 		  = "S�o Caetano do Sul/SP";
	$dadosboleto["cedente"] 		    = "Conselho Geral da Igr.Ev. Avivamento Biblico";

	// N�O ALTERAR!
	include("include/funcoes_itau.php"); 
	include("include/layout_itau.php");

 //Gravar contas a Receber
  $fidProjeto       = $row["CodigoProjeto"]; //`idProjeto`,
  $fCodigoBarra     = $dadosboleto["linha_digitavel"]; //`CodigoBarra`,
  $fGeradoPor       = $fID; //`GeradoPor`
  $fNossoNumero     = $dadosboleto["nosso_numero"];


  //echo date('d/m/Y', strtotime($data_venc));

  //echo "$newDateString  - " . $newDateString;

/*
  echo "<br>data_venc - " . $data_venc;
  echo "<br>strtotime - " . strtotime($data_venc);
  echo "<br>DataConvertida - " .  $dataConvertida = date("Y-m-d", $data_venc);
*/

//$date = new DateTime('2000-01-01');
//echo $date->format('Y-m-d H:i:s');


//echo $data_venc_mysql;


    //echo "<br><br><br>";
    //

    $valor_cobrado = str_replace(",", ".",$valor_cobrado);
    
    $sqlInsert = "INSERT INTO `contasreceber`
    (
      `idUsuario`,
      `Valor`,
      `DataEmissao`,
      `DataReferencia`,
      `Status`,
      `idProjeto`,
      `CodigoBarra`,
      `GeradoPor`,
      `NossoNumero`,
      `DataVencimentoBoleto`
    )
    VALUES
    (
      {$fID},
    \"{$valor_cobrado}\",
    \"{$fDataEmissao}\",
    \"{$fDataReferencia}\",
    \"{$fStatus}\",
      {$fidProjeto},
    \"{$fCodigoBarra}\",
      {$fID},
    \"{$fNossoNumero}\",
    \"{$data_venc_mysql}\"

    );     "; 
    

    //echo "<br> SQL - " . $sqlInsert;
    //echo $sqlInsert;
    $db->query($sqlInsert) or die($db->errorInfo()[2]); 
    echo "<br /> Gerado uma previs�o no sistema avivamissoes de "; 
    echo "   " . $ValorSemPonto ; 
}

?>

</body>
</html>