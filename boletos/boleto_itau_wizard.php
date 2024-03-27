<html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php 
if (isset($_GET['CNPJ'])){
    #Variavies para boleto
    $cnpj         = "";
    $idUser       = "";
    $valor        = "";
    $mes          = "";
    $ano          = "";
    $tipoEmissao  = "1via";
    $nossonumero  = "";
    $codigobarra  = "";
    $tipoOferta   = 2;


    if( isset($_GET['nn']) )
    {
         $nossonumero1 = substr($_GET['nn'], 0, -2) ;
         $nossonumero =  (int)str_replace("109/", "",$nossonumero1);
         //Retirar 109/
         //substr_replace($nossonumero, "", -2);
         //substr($nossonumero, 0, -1);
         //substr(string, start)

         //echo  $nossonumero;

         //depois do "-"
    } 

  //exit();




    if( isset($_GET['codigobarra']) )
    {
         $codigobarra = $_GET['codigobarra'];
    } 
    if( isset($_GET['CNPJ']) )
    {
         $cnpj = $_GET['CNPJ'];
    }

    if( isset($_GET['id']) )
    {
         $idUser = $_GET['id'];
         //echo "{$idUser}";
         //exit();
    }

    if( isset($_GET['Valor']) )
    {
         $valor = $_GET['Valor'];
    }    

    if( isset($_GET['Mes']) )
    {
         $mes = $_GET['Mes'];
    } 

    if( isset($_GET['Ano']) )
    {
         $ano = $_GET['Ano'];
    } 

    if( isset($_GET['function']) )
    {
         $tipoEmissao = $_GET['function'];
    } 

    if( isset($_GET['projeto']) )
    {
         $tipoOferta = $_GET['projeto'];
    } 

}else{
  echo "Boleto nao pode ser emitido! Por favor tente novamente e verifique todas as informações.";
  exit;
}


//echo "<br> tipo de emissao " . $tipoEmissao ;
//echo "<br>valor : " . $valor;
//exit;

?>


<html>
<head>
<title></title>
<meta http-equiv="Content-Type" charset="ISO-8859-1">

</head>
<body>

<?php


include("../config.php"); 

header("Content-Type: text/html;  charset=ISO-8859-1",true);

//mysql_query("SET NAMES 'utf8'");
//mysql_query("SET character_set_connection=utf8");
//mysql_query("SET character_set_client=utf8");
//mysql_query("SET character_set_results=utf8");

/* Variaveis Globais para Boleto e Contas  Receber */
//Variaveis -----------------------------------------

$fID      =  $idUser; //Id Usuario - idUsuario
$fValor   =  $valor;  
//echo "<br />  Valor " . $fValor ; 
$ValorSemPonto = str_replace(".","",$fValor); 
//echo "<br />  ValorSemPonto " . $ValorSemPonto ; 
//echo "<br>newstring " . $newstring;

$fMesRef  =  $mes ;
$fAnoref  =  $ano ;

  ########### ATUALIZAR CNPJ/CPF e formata para mostra no boleto
  //$sqlUpCNPJ = "";
  //echo 
  if (strlen($cnpj)> 12){
    $fCNPJ    =  mask($cnpj,'##.###.###/####-##');
    $sqlUpCNPJ =  "update usuarios set CNPJ = '{$cnpj}' where id = {$fID}";
  }
  else{
    $fCNPJ    =  mask($cnpj,'###.###.###-##');
    $sqlUpCNPJ =  "update usuarios set CPF = '{$cnpj}' where id = {$fID}";
  }

  mysql_query($sqlUpCNPJ) or die(mysql_error()); 

  //echo "DEBUG <br>";
  //echo "--> Atualiza CNPJ e CPF <br>";
  //echo $sqlUpCNPJ;

  //exit();


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

  //echo "DEBUG <br>";
  //echo "--> Proximo nosso numero : {$fNossoNumero} <br>";
  //  echo "--> Nosso numero do GET: {$nossonumero} <br>";


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



// ------------------------- DADOS DINÂMICOS DO SEU CLIENTE PARA A GERAÇÃO DO BOLETO (FIXO OU VIA GET) -------------------- //
// Os valores abaixo podem ser colocados manualmente ou ajustados p/ formulário c/ POST, GET ou de BD (MySql,Postgre,etc)	//


while($row = mysql_fetch_array($result)){ 
    
    foreach($row AS $key => $value) { $row[$key] = stripslashes(htmlentities($value)); } 
    /*
      echo "<br>ID usuario ----> " . $fID;
      echo "<br>Valor ----> " . $fValor;
      echo "<br> Referente ao mes de  ----> " . $fMesRef;
      echo "<br> Ano ----> " . $fAnoref;
    */

	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 20;
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

  /* **************************************************************** */
  if($tipoEmissao == "2via"){
      $fNossoNumero  = $nossonumero ; 
  }


  /******************************************************/
	 // Nosso numero - REGRA: Máximo de 8 caracteres!
	$dadosboleto["numero_documento"] = $fNossoNumero;	// Num do pedido ou nosso numero
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula


	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] =  html_entity_decode($row['NomeDoCampo']) . " - {$fCNPJ}";//"Nome do seu Cliente";
	$dadosboleto["endereco1"] = html_entity_decode($row['EnderecoSede']);//"Endereço do seu Cliente";
	$dadosboleto["endereco2"] = html_entity_decode($row['CidadeSede'] ." - ". $row['UFSede'] ." - CEP : ". $row['CEPSede']);// "Cidade - Estado -  CEP: 00000-000";

	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "Remessa de oferta referente ao mes " . $fMesRef.'/'.$fAnoref;
	$dadosboleto["demonstrativo2"] = "";//"Mensalidade referente a nonon nonooon nononon<br>Taxa bancária - R$ ".number_format($taxa_boleto, 2, ',', '');
	$dadosboleto["demonstrativo3"] = "";//"http://ivicomm.net";
	$dadosboleto["instrucoes1"]    = "- Sr. Caixa, não cobrar multa após o vencimento pois essa, ";
	$dadosboleto["instrucoes2"]    = "  é uma doacao voluntária que recebemos";
	$dadosboleto["instrucoes3"]    = "- Em caso de dúvidas entre em contato financeiro@avivamissoes.com.br / 11 4232-9671";
	$dadosboleto["instrucoes4"]    = "";//&nbsp; Emitido pelo sistema Projeto BoletoPhp - www.boletophp.com.br";

	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"]     = "001";
	$dadosboleto["valor_unitario"] = $valor_boleto;
	$dadosboleto["aceite"]         = "";		
	$dadosboleto["especie"]        = "R$";
	$dadosboleto["especie_doc"]    = "DM";

	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //

	// DADOS DA SUA CONTA - ITAÚ
	$dadosboleto["agencia"] = "1381"; // Num da agencia, sem digito
	$dadosboleto["conta"] = "12182";	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = "9"; 	// Digito do Num da conta

	// DADOS PERSONALIZADOS - ITAÚ
	$dadosboleto["carteira"] = "109";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

	// SEUS DADOS
	$dadosboleto["identificacao"] 	= "Conselho Geral da Igr.Ev. Avivamento Biblico";
	$dadosboleto["cpf_cnpj"] 		    = "05.620.322/0001-57";
	$dadosboleto["endereco"] 		    = "Rua Visconde de Inhauma,878-Oswaldo Cruz-Sao Caetano SUL";
	$dadosboleto["cidade_uf"] 		  = "São Caetano do Sul/SP";
	$dadosboleto["cedente"] 		    = "Conselho Geral da Igr.Ev. Avivamento Biblico";

 //if($tipoEmissao == "2via"){
      //$fNossoNumero  = $nossonumero ; 
      $dadosboleto["nosso_numero"] = $fNossoNumero;

    //}else

	// NÃO ALTERAR!
	include("include/funcoes_itau.php"); 
	include("include/layout_itau.php");

 //Gravar contas a Receber
  $fidProjeto       = $row["CodigoProjeto"]; //`idProjeto`,
  $fCodigoBarra     = $dadosboleto["linha_digitavel"]; //`CodigoBarra`,
  $fGeradoPor       = $idUser; //`GeradoPor`

      $data = $ano ."-".$mes;

  /* **************************************************************** */
  if($tipoEmissao == "2via"){
      //$fNossoNumero  = $nossonumero ; 
      //$dadosboleto["nosso_numero"] = $nossonumero;


             //Lista Apenas Campos Eclesiáticos                                
        $result = mysql_query("        
           select * from contasreceber 
                   where idUsuario      = {$fGeradoPor} 
                     and Status         = 'Pendente'
                     and DataReferencia = '{$data}-15 00:00:00' 
         ") or trigger_error(mysql_error()); 


/*
        echo "<br> select * from contasreceber 
                   where idUsuario      = {$fGeradoPor} 
                     and Status         = 'Pendente'
                     and DataReferencia = '{$data}-15 00:00:00' ";
  */      
                     
        $rowCount = mysql_num_rows($result);

        ##Ja existe um ou mais boletos 
        ##para esse mes e ano
        //echo "<br> linhas " . $rowCount;
        if($rowCount > 0){
           //echo "select * from usuarios where id = {$id}";
            while($row = mysql_fetch_array($result)){ 
              foreach($row AS $key => $value) { 
                $row[$key] = stripslashes($value); 
              }  
            

            $SqlBaixaBoleto = 
                  "Update contasreceber 
                    set     Status      =   'Pendente'
                      ,     Valor       =   '{$valor_cobrado}'
                      ,     DataEmissao =   '{$fDataEmissao}'
                      ,     NossoNumero =   '{$nossonumero}'
                      ,     CodigoBarra =   '{$fCodigoBarra}'
                      ,     idProjeto   =   '{$tipoOferta}'
                      ,     DataVencimentoBoleto = '{$data_venc_mysql}'

                    where   id          =    {$row['id']}" ;

            }
            //echo "--> Se 2 via : {$fNossoNumero} <br>";
            echo "<br> UPDATE sqlbaixado:". $SqlBaixaBoleto . "<br>"    ;

            /*#debug - Descomentar   */ 
            
            if (! mysql_query($SqlBaixaBoleto) ){
                    die( ':: Erro 1: '. mysql_error()); 
                    echo "Fase de teste da baixa de boleto: Anote o seguinte erro!";
                  }; 
                          

            echo "<br /> Atualizado uma previsão no sistema avivamissoes "; 
            //echo "   " . $ValorSemPonto ; 


          }




  }else{
  /******************************************************/

    #Deletar todos os boletos existentes
    $SqlDelete = " DELETE FROM contasreceber 
                          where idUsuario = {$fGeradoPor}
                          and   DataReferencia = '{$data}-15 00:00:00' " ;

    // echo "<br> delete :". $SqlDelete . "<br>"    ;
    //exit;

    /*#debug - Descomentar  */
    
    // if (! mysql_query($SqlDelete) ){
    //         die( ':: Erro 2: '. mysql_error()); 
    //         echo "Fase de teste da baixa de boleto: 
    //         Anote o seguinte erro!";
    //       }; 
           





    $fNossoNumero     = $dadosboleto["nosso_numero"];

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
      {$tipoOferta},
    \"{$fCodigoBarra}\",
      {$fID},
    \"{$fNossoNumero}\",
    \"{$data_venc_mysql}\"

    );     "; 
    

    //echo "<br> SQL Insert qdo for nova emissao - " . $sqlInsert;
    //echo $sqlInsert;
    mysql_query($sqlInsert) or die(mysql_error()); 
    echo "<br /> Gerado uma previs&atilde;o no sistema avivamissoes"; 
    //echo "   " . $ValorSemPonto ; 

  }
}




function mask($val, $mask)
{
 $maskared = '';
 $k = 0;
 for($i = 0; $i<=strlen($mask)-1; $i++)
 {
 if($mask[$i] == '#')
 {
 if(isset($val[$k]))
 $maskared .= $val[$k++];
 }
 else
 {
 if(isset($mask[$i]))
 $maskared .= $mask[$i];
 }
 }
 return $maskared;
}

?>

</body>
</html>