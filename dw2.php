<?php
session_start();
if($_SESSION['logado'] <> "S"){

    //header("login.php");
    echo "<script language='JavaScript' type='text/JavaScript'> <!--
        window.location='login.php';
        //-->
        </script>";


}

  include('config.php');  
  include('scripts/functions.php');  


function formatarNossoNumero($nn){
	
	$nosso_numero = 	explode('/', $nn);
	$nosso_numero2 = 	explode('-', $nosso_numero[1]);
	return $nosso_numero2[0];
}

echo formatarNossoNumero('109/00002266-2');

exit();

//require_once('classes/class.contas.php'); // Essa é minha Classe 
//$contax = new Contas();
$taxa_boletoX = 2.90;//Caso boleto seja cobrado

ini_set("max_execution_time",9999);

function limit($palavra,$limite){
        if(strlen($palavra) >= $limite)        {
			$var = substr($palavra, 0,$limite);
        }else{
			$max = (int)($limite-strlen($palavra));
			$var = $palavra.complementoRegistro($max,"brancos");
        }
        return $var;
}

function limitteste($palavra,$limite){
        if(strlen($palavra) >= $limite)        {
			$var = substr($palavra, 0,$limite);
        }else{
			$max = (int)($limite-strlen($palavra));
			$var = $palavra.complementoRegistroteste($max,"zeros");
        }
        return $var;
}


function sequencial($i){
        if($i < 10){
			return zeros(0,5).$i;
        }else if($i > 9 && $i < 100){
			return zeros(0,4).$i;
        }else if($i > 100 && $i < 1000){
			return zeros(0,3).$i;
        }else if($i > 1000 && $i < 10000){
			return zeros(0,2).$i;
        }else if($i > 10000 && $i < 100000){
			return zeros(0,1).$i;
        }
}

function zeros($min,$max){
        $x = ($max - strlen($min));
        for($i = 0; $i < $x; $i++){
			$zeros .= '0';
        }
        return $zeros.$min;
}

function complementoRegistro($int,$tipo){
        if($tipo == "zeros"){
			$space = '';
			for($i = 1; $i <= $int; $i++){
       			 $space .= '0';
			}
        }else if($tipo == "brancos"){
			$space = '';
			for($i = 1; $i <= $int; $i++){
				$space .= ' ';
			}
        }        
        return $space;
}

function complementoRegistroteste($int,$tipo){
        if($tipo == "zeros"){
			$space = '';
			for($i = 1; $i <= $int; $i++){
       			 $space .= '-';
			}
        }else if($tipo == "brancos"){
			$space = '';
			for($i = 1; $i <= $int; $i++){
				$space .= ' ';
			}
        }        
        return $space;
}


function erro($mensagem){
	echo "Erro : $mensagem";
}

function msg($mensagem){
	echo "Mensagem: $mensagem";

}

function msg2($mensagem,$filename){
	//echo "Mensagem: $mensagem";

echo "<div class='alert alert-success'>
  <strong>Success!</strong> $mensagem 
  <a id='btn' href='{$filename}' download='{$filename}' class='btn btn-default'>
              <span class='glyphicon glyphicon-cloud-download'></span>Download </a>   
</div>";


}


function tirarAcentos($string){
    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
}



function trataTxt($var) {		

	#Adic
	$var = tirarAcentos($var);
	$var = str_replace("Ã","A",$var);
	$var = str_replace("É","E",$var);
		$var = str_replace("°","o",$var);
		$var = str_replace("á","a",$var);
		$var = str_replace("à","a",$var);
		$var = str_replace("â","a",$var);
		$var = str_replace("ã","a",$var);
		$var = str_replace("ª","a",$var);
		$var = str_replace("é","e",$var);
		$var = str_replace("è","e",$var);
		$var = str_replace("ê","e",$var);
		$var = str_replace("ó","o",$var);
		$var = str_replace("ò","o",$var);
		$var = str_replace("ô","o",$var);
		$var = str_replace("õ","o",$var);
		$var = str_replace("ú","u",$var);
		$var = str_replace("ù","u",$var);
		$var = str_replace("û","u",$var);
		$var = str_replace("ç","c",$var);		
		$var = str_replace(","," ",$var);			
		$a = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿ';	
		$b = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyyby';	
		$var = (strtr($var, $a, $B));
		$var = strtoupper(($var));		

		//echo "{$var} -> <br>";
		
		return $var;
}


//print_r($_POST);

#125649

$agencia = '1381';//Numero da Agencia mantenedora da Conta
$conta = '12182';//Numero da Sua conta 
$digito_conta = '9';//Numero do Digito da Conta
$nome_sua_empresa = 'Conselho Geral da Igr.Ev. Avivamento Biblico';
$cnpj_empresa = '05.620.322/0001-57';

$fusohorario = 3; //fuso para o horario do brasil
$timestamp = mktime(date("H") - $fusohorario, date("i"), date("s"), date("m"), date("d"), date("Y"));

$DATAHORA['PT'] = gmdate("d/m/Y H:i:s", $timestamp);
$DATAHORA['EN'] = gmdate("Y-m-d H:i:s", $timestamp);
$DATA['PT'] = gmdate("d/m/Y", $timestamp);
$DATA['EN'] = gmdate("Y-m-d", $timestamp);
$DATA['DIA'] = gmdate("d",$timestamp);
$DATA['MES'] = gmdate("m",$timestamp);
$DATA['ANO'] = gmdate("y",$timestamp);
$HORA = gmdate("H:i:s", $timestamp);

define("REMESSA","retorno/remessa/",true);//Pasta onde será salvo o arquivo.


$nome_arquivo = "Remessa-{$_SESSION['idlogado']}-";
$filename = REMESSA.$DATA['DIA'].$DATA['MES'].$DATA['ANO'].$_POST['mes'].".rm";
$conteudo = '';

## REGISTRO HEADER
                                                   #NOME DO CAMPO          #SIGNIFICADO    #POSICAO        #PICTURE
$conteudo .= '0';                           //      tipo de registro        id registro header              001 001         9(01) 
$conteudo .= '1';                           //      operacao        tipo operacao remessa   002 002         9(01)
$conteudo .= 'REMESSA';                     //      literal remessa         escr. extenso   003 009         X(07)
$conteudo .= '01';                          //      codigo servico          id tipo servico 010 011         9(02)
$conteudo .= limit('COBRANCA',15);          //      literal cobranca        escr. extenso   012 026         X(15)
$conteudo .= $agencia;                      //      agencia   mantenedora conta               027 030         9(04)
$conteudo .= complementoRegistro(2,"zeros");//      zeros complemento d registro     031 032         9(02)
$conteudo .= $conta;                        //      conta conta da empresa033 037         9(05)
$conteudo .= $digito_conta;                 //      dac           digito autoconf conta   038 038         9(01)
$conteudo .= complementoRegistro(8,"brancos");//        complemento registro    039 046         X(08)
$conteudo .= limit($nome_sua_empresa,30);   //nome da empresa  047 076         X(30)
$conteudo .= '341';                         // codigo banco Nº BANCO CÂMARA COMP.   077 079         9(03)
$conteudo .= limit('BANCO ITAU SA',15);     //      nome do banco por ext.  080 094         X(15)
$conteudo .= $DATA['DIA'].$DATA['MES'].$DATA['ANO'];//data geracao arquivo      095 100         9(06)
$conteudo .= complementoRegistro(294,"brancos");// complemento de registr       101 394         X(294)
$conteudo .= sequencial(1);                // numero sequencial    registro no arquivo             395 400         9(06)

#tODO - ok
$conteudo .= chr(13).chr(10); //essa é a quebra de linha


# Gerar array de boletos para remessas

$dtinicio = $_GET['dtinicio'];
$dtfim = $_GET['dtfim'];


/*
$sql = "	Select 

	DATE_FORMAT(cr.DataReferencia, '%m/%Y') AS Referente
	,DATE_FORMAT(cr.DataEmissao, '%d/%m/%Y') AS DataEmissaoF
	,cr.*, u.*, cr.Valor as ValorBoleto
	,DATE_FORMAT(cr.DataVencimentoBoleto, '%d/%m/%Y') AS DataVenc

	from contasreceber cr
	join usuarios u on (u.id = cr.idUsuario)


	where   cr.DataEmissao >= '{$dtinicio} 00:00:00'  
	and 	cr.DataEmissao <= '{$dtfim} 23:59:59'
	and 	cr.Status = 'Pendente'";


 // echo "<br>" . $sql . "<br>";
*/

$result = mysql_query("
	Select 

	DATE_FORMAT(cr.DataReferencia, '%m/%Y') AS Referente
	,DATE_FORMAT(cr.DataEmissao, '%d/%m/%Y') AS DataEmissaoF
	,cr.*, u.*, cr.Valor as ValorBoleto
	,DATE_FORMAT(cr.DataVencimentoBoleto, '%d/%m/%Y') AS DataVenc

	from contasreceber cr
	join usuarios u on (u.id = cr.idUsuario)


	where   cr.DataEmissao >= '{$dtinicio} 00:00:00'  
	and 	cr.DataEmissao <= '{$dtfim} 23:59:59'
	and 	cr.Status = 'Pendente'


	") or trigger_error(mysql_error()); 

	while($row = mysql_fetch_array($result)){ 
	foreach($row AS $key => $value) { $row[$key] = stripslashes($value); }

		//$row['Status']





	#DataVencimento
	$dt_vencimento = explode('-',$row['DataVenc']);
	$dt_vencimento = $dt_vencimento[2].$dt_vencimento[1].$dt_vencimento[0];	
	$vencimento = $dt_vencimento;	
	
	#Valor
	$valor = number_format(($row['ValorBoleto'] ),2,'','');		

	$cpf = str_replace('-','',$row['CPF']);
	$cpf = str_replace('/','',$cpf);
	$cpf = str_replace('.','',$cpf);

	$cnpj = str_replace('-','',$row['CNPJ']);
	$cnpj = str_replace('/','',$cnpj);
	$cnpj = str_replace('.','',$cnpj);

	$cep = str_replace('-','',$row['CEP']); 
	
		$clientes[] = array(
					
					'cliente' =>  trataTxt($row['Nome']),
					'codigo' => $row['idUsuario'],
					'valor' => $valor,
					'vencimento'=> $vencimento,
					'cnpj'=> $cnpj,
					'cpf'=> $cpf,
					'endereco_rua_numero_complemento' => trataTxt($row['Endereco']),
					'bairro'=> trataTxt($row['Bairro']),
					'cep' => $cep,
					'estado'=> trataTxt($row['UF']),
					'cidade' => trataTxt($row['Nome']),
					'nosso_numero' => $row['NossoNumero']);
	} 



//print_r ($clientes);

### cOMECAR GERAR O DETALHE
$i = 2;
//Se vier o comando Gerar remessa e o numero de clientes for maior que 0
if(count($clientes)>0){ 
	
foreach($clientes as $cliente){


if ( $cliente['codigo'] == 1019){

	//print_r($cliente) . "<br><br>";

	//echo "aaaa";

}



                                ##  REGISTRO DETALHE (OBRIGATORIO)
                                 #  NOME DO CAMPO#SIGNIFICADO    #POSICAO        #PICTURE
$conteudo .= '1';               //      tipo registro id registro transacac.  001 001         9(01)
$conteudo .= '02';              //      codigo inscricao        tipo inscricao empresa  002 003         9(02)
$conteudo .= limit($cnpj_empresa,14);              //      cnpj da empresa004 017         9(14)
$conteudo .= limit($agencia,4);              //      agencia mantenedora da conta    018 021         9(04)
$conteudo .= '00';              //      zeros   complemento registro    022 023         9(02)
$conteudo .= limit($conta,5);              //      conta   numero da conta 024 028         9(05)
$conteudo .= limit($digito_conta,1);    //      dac             dig autoconf conta              029 029         9(01)
$conteudo .= complementoRegistro(4,"brancos");  //      brancos complemento registro    030 033         X(04)
$conteudo .= complementoRegistro(4,"zeros");               //  CÓD.INSTRUÇÃO/ALEGAÇÃO A SER CANC NOTA 27   034 037         9(04)
$conteudo .= limit($cliente['identifica_titulo'],25);              //      USO / IDENT. DO TÍTULO NA EMPRESA NOTA 2        038 062         X(25)
$conteudo .= complementoRegistro(8,"zeros");              //      NOSSO NUMERO / ID TITULO DO BANCO NOTA 3        063 070         9(08)
$conteudo .= limit('0000000000000',13);              //QTDE MOEDA    NOTA 4          071 083         9(08)V9(5)
$conteudo .= '112';              //      nº da carteira          nº carteira banco     084 086         9(03)   
$conteudo .= complementoRegistro(21,"brancos");              // uso do banco ident. oper. no banco         087 107         X(21)
$conteudo .= 'I';              //      carteira codigo da carteira NOTA 5            108 108         X(01)
$conteudo .= '01';              // codigo ocorrencia / ident da ocorrencia NOTA 6               109 110         9(02)

$conteudo .= complementoRegistro(10 - strlen($cliente['identifica_titulo']),"zeros");// nº documento
// nº documento de cobranca NOTA 18 111 120 X(10)
$conteudo .= $cliente['identifica_titulo']; 
$conteudo .= limit($cliente['vencimento'],6); // vencimento data venc. titulo NOTA 7        121 126         9(06)
$conteudo .= complementoRegistro(13-strlen($cliente['valor']),"zeros");
$conteudo .= $cliente['valor']; // valor titulo valor nominal NOTA 8    127 139         9(11)V9(2)
$conteudo .= '341';  // codigo do banco              Nº BANCO CÂMARA COMP.   140     142             9(03)           
$conteudo .= complementoRegistro(5,"zeros");//agencia cobradora / ONDE TÍTULO SERÁ COBRADO NOTA 9   143 147         9(05)
$conteudo .= '08';   // especie              especie do titulo NOTA 10     148 149         X(02)
$conteudo .= 'A'; // aceite ident de titutlo aceito (A=aceite,N=nao aceite)     150 150         X(01)
$conteudo .= date('dmy');          // data emissao titulo  NOTA 31       151 156         9(06)
$conteudo .= '82';      // instrucao 1  NOTA 11       157 158         X(02)
$conteudo .= '00';      // instrucao 2  NOTA 11       159 160         X(02)

$juros = number_format( 0/30 ,2);//Juros de 8% ao Mês.
$valor = (float)substr($cliente['valor'],0,strlen($cliente['valor'])-2).'.'.substr($cliente['valor'],strlen($cliente['valor'])-2,strlen($cliente['valor']));
$juros_mora = (float)number_format(($valor * $juros / 100),2,'','');
//$juros_mora = str_replace('.','x',$juros_mora);

$conteudo .= complementoRegistro(13-strlen($juros_mora),"zeros");
$conteudo .= $juros_mora;
//complementoRegistro(13,"zeros");
// juros de 1 dia  valor de mora NOTA 12   161 173         9(11)V9(02)

$conteudo .= zeros(0,6);        // desconto até data limite p/ descont  174 179         9(06)
$conteudo .= complementoRegistro(13,"zeros");
// valor desconto          a ser concedido NOTA 13 180 192         9(11)V9(02)
$conteudo .= complementoRegistro(13,"zeros");
// valor I.O.F RECOLHIDO P NOTAS SEGURO NOTA 14 193 205         9(11)V9(02)
$conteudo .= complementoRegistro(13,"zeros");   


// abatimento   a ser concedido NOTA 13 206 218         9(11)V9(02)
if(strlen($cliente['cnpj'])==14){
	$conteudo .= '02'; // codigo de inscricao tipo de insc. sacado 01=CPF 02=CNPJ   219 220         9(02)
	$conteudo .= $cliente['cnpj'];  // numero de inscricao  cpf ou cnpj   221 234         9(14)
}else{
	$conteudo .= '01'; // codigo de inscricao tipo de insc. sacado 01=CPF 02=CNPJ   219 220         9(02)
	$conteudo .= complementoRegistro(14-strlen($cliente['cpf']),"zeros");
	$conteudo .= $cliente['cpf'];  // numero de inscricao  cpf ou cnpj   221 234         9(14)
}





$conteudo .= limit($cliente['cliente'],30);     // nome nome do sacado NOTA 15  235 264         X(30)
$conteudo .= complementoRegistro(10,"brancos");//NOTA 15 complem regist         265 274         X(10)

//if ( $cliente['codigo'] == 1019){

	//echo "<br>" . limitteste($cliente['cliente'],30) . complementoRegistro(10,"zeros");
	//echo "<br> ";
	//print_r($cliente) . "<br><br>"; 
	//echo "aaaa";

//}


$conteudo .= limit($cliente['endereco_rua_numero_complemento'],40);      // logradouro rua numero e compl sacado 275 314         X(40)
$conteudo .= limit($cliente['bairro'],12);      // bairro     bairro do sacado315 326         X(12)
$conteudo .= limit($cliente['cep'],8);       // cep        cep do sacado   327 334         9(08)
$conteudo .= limit($cliente['cidade'],15);      // cidade     cidade do sacado335 349         X(15)           
$conteudo .= limit($cliente['estado'],2);       // estado     uf do sacado    350 351         X(02)
$conteudo .= limit('',30);      // sacador/avalista             sacad ou aval. NOTA 16  352 381         X(30)
$conteudo .= complementoRegistro(4,"brancos");// complemento de regist.         382 385         X(04)
$conteudo .= zeros(0,6);        // data de mora data de mora    386 391         9(06)           
$conteudo .= '05';        // prazo      qtde de dias NOTA 11(A) 392 393         9(02)   
$conteudo .= complementoRegistro(1,"brancos");          // brancos    complemento de registr. 394 394         X(01)
$conteudo .= sequencial($i++);  // numero sequencial    do registro no arquivo  395 400         9(06)
$conteudo .= chr(13).chr(10); //essa é a quebra de linha


	#Tabela de amostragem
	$tr = $tr.   "<tr>
	<td><a href='editar-usuarios.php?id={$cliente['codigo']}' > {$cliente['cidade']} </a></td>
	<td>{$cliente['cnpj']}</td>
	<td>{$cliente['cpf']}</td>
	<td>{$valor}</td>
	<td>{$cliente['vencimento']}</td>
	<td>{$cliente['nosso_numero']}</td>
  	</tr>";


}// fecha loop de clientes

$tbRemessas = "
<table class='table'>
<thead>
  <tr>
    <th>Campo</th>
    <th>CNPJ</th>
    <th>CPF</th>
    <th>Valor</th>
    <th>vencimento</th>
    <th>Nosso Numero</th>
  </tr>
</thead>
<tbody>
".$tr."
</tbody>
</table>";


echo $tbRemessas ; 


## REGISTRO TRAILER DE ARQUIVO
/*
CORRETO LAYOUT ITAU
                        #NOME DO CAMPO          #SIGNIFICADO    #POSICAO        #PICTURE*/
$conteudo .= '9';      //      tipo de registro        id registro trailer             001 001         9(01)
$conteudo .= complementoRegistro(393,"zeros"); // brancos    complemento de registro 002 394  /X(393)
$conteudo .= zeros(sequencial($i++),6);  //nº sequencial   do regsitro no arquivo  395 400    9(06)
$conteudo .= chr(13).chr(10);



//echo $conteudo;
// Em nosso exemplo, nós vamos abrir o arquivo $filename
// em modo de adição. O ponteiro do arquivo estará no final
// do arquivo, e é pra lá que $conteudo irá quando o 
// escrevermos com fwrite().
// 'w+' e 'w' apaga tudo e escreve do zero
if (!$handle = fopen($filename, 'w+')) 
{
         erro("Não foi possível abrir o arquivo ($filename)");
}
// Escreve $conteudo no nosso arquivo aberto.
if (fwrite($handle, "$conteudo") === FALSE) 
{
        erro("Não foi possível escrever no arquivo ($filename)");
}
fclose($handle);
msg2("Arquivo de remessa gerado com sucesso!<br/>",$filename);
    //echo "<a href='$filename' target='_blank'>Download </a>";
 }

?>