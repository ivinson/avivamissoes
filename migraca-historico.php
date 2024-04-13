<?php
include('config.php');
require_once('/scripts/excel_reader2.php');

# RETORNA O MES
function getMes($mes){
	if($mes == "Jan"){ $result ='01';}
	if($mes == "Feb"){ $result ='02';}
	if($mes == "Mar"){ $result ='03';}
	if($mes == "Apr"){ $result ='04';}
	if($mes == "May"){ $result ='05';}
	if($mes == "Jun"){ $result ='06';}
	if($mes == "Jul"){ $result ='07';}
	if($mes == "Aug"){ $result ='08';}
	if($mes == "Sep"){ $result ='09';}
	if($mes == "Oct"){ $result ='10';}
	if($mes == "Nov"){ $result ='11';}
	if($mes == "Dec"){ $result ='12';}
	return $result;
}

# GERA UM LANCAMNTO BANCARIO ATRAVES DO INSERT
function geraLancamentoBancario($valor,$idUsuario,$datareferencia,$tipolancamento){
	// Realize a conexão com o banco de dados
	$db = DB::getInstance();
	//$dataatual = date("d-m-Y H:i:s");

	$sql= "INSERT INTO lancamentosbancarios
	(
		`idUsuario`,
		`Valor`,
		`TipoOrigem`,
		`DataBaixa`,

		`idProjeto`,
		`GeradoPor`,
		`BaixadoPor`,
		`idContaReceber`,
		`idContaPagar`,

		`Descricao`,
		`idContaBancaria`,
		`DataReferencia`,
		`idPlanoDeContasNiveis`,
		`NumeroDocumento`,
		`TipoLancamento`
	)
	VALUES
	(
		$idUsuario,
		'$valor',
		'C',
		now(),

		2,
		0,
		0,
		Null,
		Null,

		'Lancamento bancario gerado automaticamente pela migracao do historico em $dataatual ' ,
		1,
		'$datareferencia',
		Null,
		'00000000000',
		'$tipolancamento'
	)";




	//echo "Lancamento de R$ $valor gerado com o usuario $idUsuario<br />"; 
	//echo "<a href='listar-plano-de-contas.php'>Back To Listing</a>";
	
	if($valor == $idUsuario or $datareferencia == '--15'){
		 
	}else 
	{
		$db->query($sql) or die($db->errorInfo()[2]); 
		//echo $sql;
		echo "Lancamento de R$ $valor gerado com o usuario $idUsuario"; 

	}
	return true;
}

# INICIA A MIGRACAO 
function startMigracao($ffile_campo){

	//$fCampo = "historicosul3";
	$fCampo = $ffile_campo;
	$Planilha = "C:\wamp\www\appstorm\historico\\". $fCampo.".xls" ;
	echo $Planilha . "<br>";
	$idRegiao = "";


	$data = new Spreadsheet_Excel_Reader($Planilha);
	 
	$totalLinhas = $data->rowcount();
	$totalColunas = $data->colcount();

	echo "<br>Total totalLinhas :" .$totalLinhas;
	echo "<br>Total totalColunas :" .$totalColunas;
	echo "<br>";
	 

	$array = "";
	$arrCabecalho = ["0","0"];
	$idUsuarioRow="0";
	//echo "<table border=1>";

	for ($i = 1; $i <= $totalLinhas; $i++) {

		if($i==1){
			//NMonta o aary de cabeçalho
			for ($j = 1; $j <= $totalColunas; $j++) {
	    		if($j > 2){
	    		 array_push($arrCabecalho, $data->val($i, $j)) ;
	    		 echo $data->val($i, $j) . " | ";
				}
	    	
			}	

		}
	    
	    //echo "Debug : encerra fluxo para averiguar a montagem dos cabeçalhos"
	    // exit;

	    if($i > 1){
		//echo "<tr>";
	    for ($j = 1; $j <= $totalColunas; $j++) {
	            

	    		if ($j== 1) {
	    			$idUsuarioRow = $data->val($i, $j) ;
	    		}
	            //$array = $data->val($i, $j);
	    		//array_push($array, $data->val($i, $j) );
	    		$fValor = $data->val($i, $j) ;
	    		//echo "Valor original : " . $fValor = $data->val($i, $j). " | ";

	    		//TRATAMENTOS
	    		$fValor = str_replace("* ", "", $fValor);
	    		$fValor = str_replace("x ", "", $fValor);
	    		$fValor = str_replace("X ", "", $fValor);
	    		$fValor = str_replace("(", "", $fValor);
	    		$fValor = str_replace(")", "", $fValor);
	    		$fValor = str_replace("-??", "0", $fValor);

	    		# tira o ponto
	    		$fValor = str_replace(",", "", $fValor);
	    		//$fValor = str_replace(".", ",", $fValor);	    		  


	    		//Tipo do Lancamento especial : 
	    		//	-- Anistiado (perdoados as dividas ate esse lancamento)
	    		//  -- NaoCampo (campos nao existente ate esse lancamento)
	    		//  -- "Acordo Comissão Executiva" 
	    		$tipoLancamento = "Regular";

	    		if($fValor == "anistiado"){
	    			$tipoLancamento = "anistiado";
	    		}else if($fValor == "NaoCampo"){
	    			$tipoLancamento = "NaoCampo";
	    		}else if($fValor == "0"){
	    			$tipoLancamento = "Inadimplente";
	    		}else if(is_numeric($fValor) == FALSE) { 
	    			$tipoLancamento = $fValor; }

	    		if(strpos($fValor,"Executiva") != false){
					$tipoLancamento = "Acordo Comissão Executiva";
	    		}

	    		$arrMesAno = explode("-", $arrCabecalho[$j-1]);
	    		$MesReferencia =  $arrMesAno[0];
	    		$AnoReferencia =  $arrMesAno[1];
	            //echo "<td>15-". getMes($MesReferencia)."-$AnoReferencia        #      ". $fValor. "</td>";
	           
	    		//echo "<br>";
	            geraLancamentoBancario($fValor, $idUsuarioRow,"$AnoReferencia-". getMes($MesReferencia)."-15",$tipoLancamento );
	            echo "<br>";
	            //echo $j;
	           //echo $data->val($i,$j);
	    }
	    //echo "</tr>";
		}
	    //echo "<br>" ;
	}

	return true;
}




//echo "</table>";

//implode(',', $array);
//$comma_separated = implode(",", $arrCabecalho);
//print $comma_separated; // lastname,email,phone


/*
1- Ler palnilha
2- Identificar Campo
3- Identificar o MES
4- Identificar o Ano
5- Gerar Lancamento Bancario pro Campo
*/


//$data->dump($row_numbers=false,$col_letters=false,$sheet=0,$table_class='excel')


//inicia a migração
if(isset($_GET["file"])){
	 echo "<h1> Iniciando a migração do arquivo : ".$_GET["file"] ."</h1>";
	 startMigracao($_GET["file"]);

}else{
	echo "<h1>Clique em um campo para inicar a migracao</h1>";

} 




?>




<H3>Escolha o campo a ser migrado</H3>

<p>ok - RELATÓRIO INADIMPLÊNCIA - 2014 - SUL 3 <a href="<?php echo url().'?file='; ?>historicosul3-"  > :: Migrar </a></p>
<p>ok - RELATÓRIO INADIMPLÊNCIA - 2014 - SUL 2 <a href="<?php echo url().'?file='; ?>historicosul2-"  > :: Migrar </a></p>
<p>ok - RELATÓRIO INADIMPLÊNCIA - 2014 - SUL 1 <a href="<?php echo url().'?file='; ?>historicosul1-"  > :: Migrar </a></p>

<br>

<p>ok - RELATÓRIO INADIMPLÊNCIA - 2014 - SUDESTE 3 <a href="<?php echo url().'?file='; ?>historicosudeste3-"  > :: Migrar </a></p>
<p>ok - RELATÓRIO INADIMPLÊNCIA - 2014 - SUDESTE 2 <a href="<?php echo url().'?file='; ?>historicosudeste2-"  > :: Migrar </a></p>
<p>ok - RELATÓRIO INADIMPLÊNCIA - 2014 - SUDESTE 1 <a href="<?php echo url().'?file='; ?>historicosudeste1-"  > :: Migrar </a></p>

<br>

<p>ok - RELATÓRIO INADIMPLÊNCIA - 2014 - NORTE<a href="<?php echo url().'?file='; ?>historiconorte"  > :: Migrar </a></p>
<p>ok - RELATÓRIO INADIMPlÊNCIA - 2014 - NORDESTE <a href="<?php echo url().'?file='; ?>historiconordeste"  > :: Migrar </a></p>
<p>ok - RELATÓRIO INADIMPLÊNCIA - 2014 - CENTRO - OESTE<a href="<?php echo url().'?file='; ?>historicocentrooeste"  > :: Migrar </a></p>

<p>RELATÓRIO INADIMPLÊNCIA - 2014 - MISSOES NACIONAIS<a href="<?php echo url().'?file='; ?>historicosul1"  > :: Migrar </a></p>

