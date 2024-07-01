<?php
//echo "----";
include('config.php');
require_once('scripts/excel_reader2.php');
include "logger.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//include('db.php'); 
$pasta = "retorno/extratos/"; /* formatos de imagem permitidos */

//$pasta = dirname($_SERVER['PHP_SELF']) ;
//$permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp",".ret"); 
$permitidos = array(".xlsx", ".xls");

//echo "string";
if (isset($_POST)) {
	#################################################################
	$nome_imagem = $_FILES['imagem']['name'];
	$tamanho_imagem = $_FILES['imagem']['size'];
	/* pega a extensão do arquivo */
	$ext = strtolower(strrchr($nome_imagem, "."));
	#################################################################

	echo "1  ";
	echo " {$ext} ";
	/* verifica se a extensão está entre as extensões permitidas */
	if (in_array($ext, $permitidos)) {
		echo "2";

		/* converte o tamanho para KB */
		$tamanho = round($tamanho_imagem / 1024);
		if ($tamanho < 1024) {
			echo "3";

			//se imagem for até 1MB envia 
			$nome_atual = md5(uniqid(time())) . $ext;
			//nome que dará a imagem 
			$tmp = $_FILES['imagem']['tmp_name'];
			//caminho temporário da imagem 


			$filename = $pasta . $nome_atual;
			#Debug
			echo "filename - " . $filename;
			echo "<br> pasta - " . $pasta . $nome_imagem;
			//echo "<br> tmp - ".$tmp;

			####################################################################
			if (move_uploaded_file($tmp, $pasta . $nome_atual)) {

				//-------INÍCIO DA EXECUÇÃO DO CÓDIGO-----------------------------------------------------					
				$fCampo = $ffile_campo;
				//$Planilha = "C:\wamp\www\appstorm\historico\\". $fCampo.".xls" ;
				///$Planilha = 	$_SERVER['path'];


				//echo "<br> self ".$_SERVER['PHP_SELF'] . "<br>";
				//echo "<br> dir  ".dirname(__FILE__) . "<br>";

				//$arquivo = "/app/retorno/extratos/".$nome_atual;
				$arquivo = dirname(__FILE__) . "/retorno/extratos/" . $nome_atual;
				echo "3";

				//Leitura Excel	
				$data = new Spreadsheet_Excel_Reader($arquivo);

				echo "4";
				$totalLinhas = $data->rowcount();
				$totalColunas = $data->colcount();
				$totalCredito = 0;

				echo "<br>Total totalLinhas :" . $totalLinhas;
				echo "<br>Total totalColunas :" . $totalColunas;
				echo "<br>";
				for ($i = 1; $i <= $totalLinhas; $i++) {

					//echo "Debug : encerra fluxo para averiguar a montagem dos cabeçalhos"
					// exit;
					if ($i > 12) {
						$fdata 			= $data->val($i, "A");
						$fDescricao 	= $data->val($i, "B");
						$fNroDocto 		= $data->val($i, "C");
						$fValorCREDITO 	= $data->val($i, "D");
						$fValorDEBITO 	= $data->val($i, "E");


						$mystring = $fValorCREDITO;
						$findme   = '$';
						$pos = strpos($mystring, $findme);

						//echo "9";

						// Note o uso de ===.  Simples == não funcionaria como esperado
						// por causa da posição de 'a' é 0 (primeiro) caractere.
						if ($pos === false) {
							//echo "A string '$findme' não foi encontrada na string '$mystring'";
						} else {
							//echo "A string '$findme' foi encontrada na string '$mystring'";
							//echo " e existe na posição $pos";
							$fValorCREDITO = "";
						}



						# tira o ponto
						$fValorCREDITO = str_replace(".", "", $fValorCREDITO);
						#troca virgula por ponto
						$fValorCREDITO = str_replace(",", ".", $fValorCREDITO);



						echo "<br> Data : " . $fdata;
						echo "<br> Descricao : " . $fDescricao;
						echo "<br> NroDocto : " . $fNroDocto;
						echo "<br> ValorCredito : " . $fValorCREDITO;
						echo "<br> ValorDebito : " . $fValorDEBITO;
						echo "<br>";

						if (!$fValorCREDITO == "") {


							//if(!$fValorCREDITO == "Crédito (R$)"){
							#echo " {$i} # " .$fValorCREDITO ."   Docto {$fNroDocto}<br>";
							//Se valor do campo credito for Crédito, pula 

							#dEBUG
							//echo $fdata ." | ". $fDescricao." | ".$fNroDocto." | ".$fValorCREDITO." | ".$fValorDEBITO."<br>";
							//echo "<br>" ;



							$dateMySql = str_replace('/', '-', $fdata);


							if (!$fDescricao == "") {

								#echo "10" ;						 
								if (verificaLancamento($fDescricao, $fNroDocto, $fValorCREDITO, date('Y-m-d', strtotime($dateMySql))) == true) {

									//echo "<br> Gerado.";
									geraCredito($fdata, $fDescricao, $fNroDocto, $fValorCREDITO);
									//echo $fValorCREDITO . "<br>";
									$totalCredito++;
								}
								//echo "Credito GERADO<br>";
							} else {
								//echo "CREDITO NAO GERADO<br>";
							};

							//}


							echo "Pulou, cabeçalhos.";

						} else {
							//geraCredito($fdata,$fDescricao,$fNroDocto,$fValorDEBITO);
							//echo "gera debito <br>";
						}
					}
				}



				#Verifica irregulares
				$i = 0;

				for ($i = 1; $i <= $totalLinhas; $i++) {

					//echo "Debug : encerra fluxo para averiguar a montagem dos cabeçalhos"
					// exit;
					if ($i > 12) {
						$fdata 			= $data->val($i, "A");
						$fDescricao 	= $data->val($i, "B");
						$fNroDocto 		= $data->val($i, "C");
						$fValorCREDITO 	= $data->val($i, "D");
						$fValorDEBITO 	= $data->val($i, "E");


						$mystring = $fValorCREDITO;
						$findme   = '$';
						$pos = strpos($mystring, $findme);


						//SE FOR RESGATE NAO GERA LANCAMENTO
						if (strpos($fDescricao, "OPER IRREGULAR") !== false) {

							//return false;
							echo "<br> Verifica lancamento achou OPER IRREGULAR <br>";
							echo "<br> Numero Docto : " . $fNroDocto;
							echo "<br> Credito : " . $fValorCREDITO;
							echo "<br> Debito  : " . $fValorDEBITO;

							if (verificaOperacoesIrregulares($fNroDocto, $fValorCREDITO, $fValorDEBITO)) {

								echo " Verificado ";
							}
						}
					}
				}


				#Debug   
				#
				echo "###################################";

				// die("<script> location.href='listar-extrato.php?sucess={$totalCredito}&fail=0'</script>");
			} else {
				echo " <div class=\"alert alert-warning\">
					                    <strong> Opa!</strong> Algum problema ocorreu !
					               </div>";
			}
		}
	}
}




#FUNCAO QUE GERA OS LANCAMENTOS DE ENTRADA COMO NAO IDENTIFICADOS
function geraCredito($fdata, $fDescricao, $fNroDocto, $fValor)
{
	# id usuario homolog 1182
	# id usuario producao 1196

	// Realize a conexão com o banco de dados
	$db = DB::getInstance();

	$SqlInsereProcessamento	= "
	INSERT INTO lancamentosbancarios
	(
		`idUsuario`,
		`Valor`,
		`TipoOrigem`,
		`DataBaixa`,
		`idProjeto`,
		`GeradoPor`,																			
		`Descricao`,
		`idContaBancaria`,
		`NumeroDocumento`
	)
	VALUES
	(
		1196 ,
		$fValor,
		'C',
		STR_TO_DATE('$fdata', '%d/%m/%Y') ,
		1 ,
		{$_SESSION['idlogado']},						
		'{$fDescricao}',
		1,					
		'$fNroDocto');";

	//echo "<br>Executando codigo : " . $SqlInsereProcessamento;



	if (!$db->query($SqlInsereProcessamento)) {
		die(':: Erro : ' . $db->errorInfo()[2]);
		echo "Fase de teste lancamentosbancarios: Anote o seguinte erro!";
	}



	Logger("# UPLOAD[Extrato] ##");
	Logger("# O usuario {$_SESSION['nome']}({$_SESSION['idlogado']}) gerou um lacamento bancario atraves do upload de extrato. ");
	Logger("# Dt :: {$fdata} ");
	Logger("# Docto :: {$fNroDocto}");
	Logger("# Valor :: {$fValor}");
	Logger("------------------------------------------------------------------------------");
}


#Verifica se ja existe algum lancamwnto ( mesmo no extrato) para nao haver duplicidades
# Por exemplo pode fazer upload quantas vezes quiser do extrato
# Existe uma questão de pastores fazerem 2 depositos no mesmo dia com mesmo valor.
# Nesse caso o sistema vai considerar apenas 1 lancamento apenas  tedo que fazer os demais manualmente
# por inviabilidade tecnica de identifica-los ( esmo codido, mesma data, mesmo valor)
function verificaLancamento($fDescricao, $fNroDocto, $fValorCREDITO, $fdata)
{


	# return true;

	#Debug
	#if($fNroDocto == 1101479){

	#echo "select count(*) as total from lancamentosbancarios where NumeroDocumento = '{$fNroDocto}' 
	#	and DataBaixa = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}' ";
	#	die();
	#}
	// Realize a conexão com o banco de dados
	$db = DB::getInstance();

	//SE FOR RESGATE NAO GERA LANCAMENTO
	if (strpos($fDescricao, "RESGATE") !== false) {
		return false;
		//echo "string : " . $fNroDocto;
		//echo "<br>Verifica lancamento achou RESGATE <br>" ;
	}


	$rs = $db->query("select count(*) as total from lancamentosbancarios where NumeroDocumento = '{$fNroDocto}' 
    		and DataBaixa = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
    ");
	$row = $rs->results(true);
	if ($row['total'] > 0) {
		//ECHO "total  {$row['total']} - ja existe<br>";	
		return false;
	} else {
		//echo "total  {$row['total']} - nao existe existe<br>";	
		return true;
	}
}



# Verifica se ja existe algum lancamento de referencia a
# OPER IRREGULAR
# DEVOL 
# Caso seja OPER IRREGULAR , e tenha esse numero de docto remover
function verificaOperacoesIrregulares($fNroDocto, $fValorCREDITO, $fValorDEBITO)
{

	#Debug
	#if($fNroDocto == 1101479){
	$VlDoc = $fValorDEBITO * (-1);

	#echo "select count(*) as total from lancamentosbancarios where NumeroDocumento = '{$fNroDocto}' 
	#	 and Round(Valor,2) = '{$VlDoc}' ";
	#	die();
	#}
	// Realize a conexão com o banco de dados
	$db = DB::getInstance();


	$rs = $db->query("select count(*) as total 
    			from lancamentosbancarios 
    				where 
    				NumeroDocumento = '{$fNroDocto}' and  
    				Round(Valor,2) = '{$VlDoc}'
    ");
	$row = $rs->results(true);
	if ($row['total'] > 0) {

		echo "<br>total  {$row['total']} - ja existe<br>";




		echo "delete lancamentosbancarios 
    				where 
    				NumeroDocumento = '{$fNroDocto}' and  
    				Round(Valor,2) = '{$VlDoc}'";


		$rsDeleteOp = $db->query("delete from lancamentosbancarios 
    				where 
    				NumeroDocumento = '{$fNroDocto}' and  
    				Round(Valor,2) = '{$VlDoc}'
    				");



		$row = $rsDeleteOp->results(true);
		echo "<br> Deletado.";



		Logger("# UPLOAD[Operacao Irregular] ##");
		Logger("# O usuario {$_SESSION['nome']}({$_SESSION['idlogado']} deletou um lacamento de bancario atraves do upload de extrato. ");
		Logger("# Docto :: {$fNroDocto}");
		Logger("# Valor :: {$VlDoc}");
		Logger("----------------------------------------------------------------------------------------------------------------------");



		return true;
	} else {
		echo "<br>total  {$row['total']} - nao existe existe<br>";
		return false;
	}
}
