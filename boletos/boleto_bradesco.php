 <?php
include("../config.php"); 

mysql_query("SET NAMES 'utf8'");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_results=utf8");

/* Variaveis Globais para Boleto e Contas  Receber */
//Variaveis -----------------------------------------

$fID      =  $_GET['id'] ; //Id Usuario - idUsuario
$fValor   =  $_GET['Valor'];
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
$resultNossonumero = mysql_query("select max(id) + 1 as NossoNumero from contasreceber") or trigger_error(mysql_error()); 
while($rowNN = mysql_fetch_array($resultNossonumero)){    
    foreach($rowNN AS $keyNN => $valueNN) { $rowNN[$keyNN] = stripslashes($valueNN); } 
      $fNossoNumero     =  $rowNN["NossoNumero"] ;
}
/* **************************************************************** */


//Select
$result = mysql_query("select 
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

                      where usuarios.id = ".$fID." ") or trigger_error(mysql_error()); 

while($row = mysql_fetch_array($result)){ 
    
    foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
    /*
    echo "<br>ID usuario ----> " . $fID;
    echo "<br>Valor ----> " . $fValor;
    echo "<br> Referente ao mes de  ----> " . $fMesRef;
    echo "<br> Ano ----> " . $fAnoref;
    */

    // ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
    // Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//

    // DADOS DO BOLETO PARA O SEU CLIENTE
    $dias_de_prazo_para_pagamento = 5;
    $taxa_boleto    = 0;//2.95;
    $data_venc      = "";//date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006";
    $valor_cobrado  = $fValor; // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
    $valor_cobrado  = str_replace(",", ".",$valor_cobrado);
    $valor_boleto   = number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

    //Pegar o id do ultimo boleto concatenado com o codigo do usuario
    $dadosboleto["nosso_numero"] = $fNossoNumero;  // Nosso numero sem o DV - REGRA: Máximo de 11 caracteres!

    $dadosboleto["numero_documento"] = $dadosboleto["nosso_numero"];	// Num do pedido ou do documento = Nosso numero
    $dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
    $dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
    $dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
    $dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

    // DADOS DO SEU CLIENTE
    $dadosboleto["sacado"]    = $row['NomeDoCampo'];
    $dadosboleto["endereco1"] = $row['EnderecoSede'];
    $dadosboleto["endereco2"] = $row['CidadeSede'] ." - ". $row['UFSede'] ." - CEP : ". $row['CEPSede'];// "Cidade - Estado -  CEP: 00000-000";

    // INFORMACOES PARA O CLIENTE
    $dadosboleto["demonstrativo1"] = "Remessa de oferta referente ao mes " . $fMesRef.'/'.$fAnoref;
    $dadosboleto["demonstrativo2"] = "";//"Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
    $dadosboleto["demonstrativo3"] = "";//"BoletoPhp - http://www.boletophp.com.br";
    $dadosboleto["instrucoes1"] = "";//"- Sr. Caixa, cobrar multa de 2% após o vencimento";
    $dadosboleto["instrucoes2"] = "Remessa de oferta referente ao mes " . $fMesRef.'/'.$fAnoref;//"- Receber até 10 dias após o vencimento";
    $dadosboleto["instrucoes3"] = "Duvidas? Entre em contato : financeiro@avivamissoes.com.br / 11 4444-4444";
    $dadosboleto["instrucoes4"] = "Emitido pelo sistema de boletos no site avivamissoes.com.br/ofertamissionaria";

    // DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
    $dadosboleto["quantidade"]      = "001";
    $dadosboleto["valor_unitario"]  = $valor_boleto;
    $dadosboleto["aceite"]          = "";
    $dadosboleto["especie"]         = "R$";
    $dadosboleto["especie_doc"]     = "DM";

    // ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

    // DADOS DA SUA CONTA - Bradesco
    $dadosboleto["agencia"]     = "0591"; // Num da agencia, sem digito
    $dadosboleto["agencia_dv"]  = "6"; // Digito do Num da agencia
    $dadosboleto["conta"]       = "0088000"; 	// Num da conta, sem digito
    $dadosboleto["conta_dv"]    = "0"; 	// Digito do Num da conta

    // DADOS PERSONALIZADOS - Bradesco
    $dadosboleto["conta_cedente"]     = "0088000"; // ContaCedente do Cliente, sem digito (Somente Números)
    $dadosboleto["conta_cedente_dv"]  = "0"; // Digito da ContaCedente do Cliente
    $dadosboleto["carteira"]          = "06";  // Código da Carteira: pode ser 06 ou 03

    // SEUS DADOS
    $dadosboleto["identificacao"]     = "";//Conselho Geral da Igr.Ev. Avivamento Biblico";
    $dadosboleto["cpf_cnpj"]          = "05.620.322/0001-57";
    $dadosboleto["endereco"]          = "";//;"Coloque o endereço da sua empresa aqui";
    $dadosboleto["cidade_uf"]         = "";//;"Cidade / Estado";
    $dadosboleto["cedente"]           = "Conselho Geral da Igr.Ev. Avivamento Biblico";//"Coloque a Razão Social da sua empresa aqui";


    // NÃO ALTERAR!
    include("include/funcoes_bradesco.php");
    include("include/layout_bradesco.php");

    //echo $dadosboleto["linha_digitavel"];


    //Gravar contas a Receber
    $fidProjeto       = $row["CodigoProjeto"]; //`idProjeto`,
    $fCodigoBarra     = $dadosboleto["linha_digitavel"]; //`CodigoBarra`,
    $fGeradoPor       = $fID; //`GeradoPor`
    $fNossoNumero     = $dadosboleto["nosso_numero"];



    //
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
    `NossoNumero`
    )
    VALUES
    (
    {$fID},
    {$fValor},
    \"{$fDataEmissao}\",
    \"{$fDataReferencia}\",
    \"{$fStatus}\",
    {$fidProjeto},
    \"{$fCodigoBarra}\",
    {$fID},
    \"{$fNossoNumero}\"

    );     "; 
    
    //echo $sqlInsert;
    mysql_query($sqlInsert) or die(mysql_error()); 
    echo "<br /> Gerado uma previsão no sistema avivamissoes."; 
}

?>
