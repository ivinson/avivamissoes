<?php session_start();
if($_SESSION['logado'] <> "S"){

    //header("login.php");
    echo "<script language='JavaScript' type='text/JavaScript'> <!--
        window.location='login.php';
        //-->
        </script>";


}

include("header.php"); 
include('config.php');  
include('scripts/functions.php'); 
require_once('scripts/excel_reader2.php');
include "logger.php";


if(isset($_GET["file"])){
	 //echo "<h2> Iniciando a migração do arquivo : ".$_GET["file"] ."</h2>";
	 startConsistencia(2013);
	 exit();
}


# INICIA A MIGRACAO 
function startConsistencia($ffile_campo, $ano){
	
	Logger("Inicio Processo de consistencia");	
   	Logger("Iniciado por {$_SESSION['nome']}");


	$nome_imagem = $_FILES['imagem']['name']; 
	$pasta = "./retorno/consistencia/";
	$filename = $pasta. date("d-m-Y_H_i_s")."--".$nome_imagem;
	//caminho temporário da imagem
	$tmp = $_FILES['imagem']['tmp_name']; 
			 
	if(move_uploaded_file($tmp,$filename))
	{ 
		Logger("Arquivo de excel ok.");
		Logger("Arquivo de excel {$filename} upload ok.");
		echo " <div class=\"alert alert-success\"><strong> UPLOAD OK </strong> </div>";	
	}
	else
	{  
	echo " <div class=\"alert alert-warning\">
                <strong> Opa!</strong> 
				  Algum problema ocorreu !
             </div>";	
             Logger("Arquivo de excel não foi feito upload.Algum problema aconetceu.");						  
	}
	

	//$fCampo = "historicosul3";
	$fCampo = $ffile_campo;
	//$Planilha = "C:\\xampp\htdocs\app\\consistencia\\teste.xls" ;
	$Planilha = $filename;

	//echo $Planilha . "<br>";
	$idRegiao = "";


	$data = new Spreadsheet_Excel_Reader($Planilha);
	 
	$totalLinhas = $data->rowcount();
	$totalColunas = $data->colcount();
	Logger("Total de linhas {$totalLinhas}.");
	Logger("Total de linhas {$totalColunas}.");


	echo " <div class=\"alert alert-success\"><strong> Total de Linhas ".$totalLinhas."</strong> </div>";
	echo " <div class=\"alert alert-success\"><strong> Total de Colunas ".$totalColunas."</strong> </div>";
	echo "<br>";


	//exit();
	//Ate aqui leu o arquivo e fez upload

	$array = "";
	$arrCabecalho = ["0","0"];
	$idUsuarioRow="0";
	//echo "<table border=1>";

	#Montagem de resumo
	$PgtosOK = 0;
	$PgtosIncluidos = 0;
	$PgtosConflito = 0;

	for ($i = 1; $i <= $totalLinhas; $i++) {

		if($i==1){
			//NMonta o aary de cabeçalho
			for ($j = 1; $j <= $totalColunas; $j++) {
	    		if($j > 2){
	    		 array_push($arrCabecalho, $data->val($i, $j)) ;
	    		 //echo $data->val($i, $j) . " | ";
				}
	    	
			}	

		}
	    

		#Leitura das linhas
	    if($i > 1){
		//echo "<tr>";
	    for ($j = 1; $j <= $totalColunas ; $j++) {
	            

	    		#Data de Baixa
	    		if ($j== 1) {
	    			$fDataBaixa = $data->val($i, $j) ;
	    			
	    		}
	    		#Descricao
	    		if ($j== 2) {
	    			$fDataDescricao = $data->val($i, $j) ;
	    			
	    		}

	    		#Documento
	    		if ($j== 3) {
	    			$fDoc = $data->val($i, $j) ;
	    			
	    		}	    		

	    		#Valor
	    		if ($j== 4) {
	    			
					
	    			$fValor = $data->val($i, $j) ;

	    		
	    		}	

	    		#Nome Campo
	    		if ($j== 5) {
	    			$fNome = $data->val($i, $j) ;
	    			
	    		}	

	    		#Data Referencia
	    		if ($j== 6) {
	    			$fDataReferencia = $data->val($i, $j) ;
	    			
	    		}	

	    		#Id do Usuario 
	    		if ($j== 7) {
	    			$fIdUsuario = $data->val($i, $j) ;
	    			
	    		}		 

	    }

	    //echo "id :: {$fIdUsuario} <br>";


 		### Pular linha em branco
 		if ($fValor == null){ continue;}
     	####################

	    #VERIFICAR SE PAGTO EXISTE
	    $retunVerificaLanc =  VerificaLancExiste($fDataReferencia, $fValor,$fIdUsuario) ;
    	#SE EXISTIR AVISA NA TELA QUE JA EXISTE
    	if ($retunVerificaLanc== "Existe" ){
    		Logger("Sem alteração no Banco de Dados : Lançamento de valor {$fValor}, ref {$fDataReferencia} do usuario ID {$fIdUsuario} já EXISTE.");

    		 echo " <div class=\"alert alert-success\"><strong>Excel {$i} <strong>:: EXISTENTE ::    Pagto de {$fNome} no valor de {$fValor} reais  referente a {$fDataReferencia}</div>";	

    		$PgtosOK++;
		}

    	#SE EXISTIR NA DATA UM PGTO MAS COM VALOR DIFERENTE [#Insere como Pendente e demonstrar em tela para usuario]
		else if ( $retunVerificaLanc =="ValorNaoIgual"){ 
	   		Logger("Incluido como PENDENTE : Lançamento de ref {$fDataReferencia} do usuario ID {$fIdUsuario} já EXISTE mas com valor diferente.");
	   		
	   		echo " <div class=\"alert alert-warning\"><strong>Excel {$i} <strong>:: Incluido como PENDENTE ::    Pagto de {$fNome} no valor de {$fValor} reais  referente a {$fDataReferencia}</div>";	

	   			//$valor,$idUsuario,$datareferencia,$tipolancamento,$dataBaixa
				geraLancamentoBancarioConsistencia($fValor, $fIdUsuario, "15/".$fDataReferencia, "PENDENTE", $fDataBaixa,$fDoc );


	   		$PgtosConflito++;
    	}

    	#SE NAO EXISTIR CRIA UM NOVO LANCAMENTO [#Insere]
    	else if ( $retunVerificaLanc =="NaoExiste"){ 
	   		Logger("Incluido: Lançamento de valor {$fValor}, ref {$fDataReferencia} do usuario ID {$fIdUsuario} foi incluido no Banco de Dados pois não existia.");
	 	   	
	 	   	echo " <div class=\"alert alert-info\"><strong>Excel {$i} <strong>:: Incluido ::    Pagto de {$fNome} no valor de {$fValor} reais  referente a {$fDataReferencia}</div>";	

	   			//$valor,$idUsuario,$datareferencia,$tipolancamento,$dataBaixa
				geraLancamentoBancarioConsistencia($fValor, $fIdUsuario, "15/".  $fDataReferencia, "Regular", $fDataBaixa);


	 	   	$PgtosIncluidos++;
    	}
	    //echo $fValor . " | " . $fIdUsuario .  "<br>";
		}
	    
	}
?>



                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                       
                                        	<?php echo $PgtosIncluidos; ?>
                                        </div>
                                        <div>Pgtos Criados</div>
                                    </div>
                                </div>
                            </div>
                            <a href="contas-a-receber.php">
                                <div class="panel-footer">
                                   
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-green">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                      
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                               <?php echo $PgtosOK; ?>                    

                                        </div>
                                        <div>Pgtos OK</div>
                                    </div>
                                </div>
                            </div>
                            <a href="contas-a-receber.php">
                                <div class="panel-footer">
                                    
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="panel panel-yellow">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-3">
                                        
                                    </div>
                                    <div class="col-xs-9 text-right">
                                        <div class="huge">
                                                                                
										<?php echo $PgtosConflito; ?>

                                        </div>
                                        <div>Pagtos em conflito</div>
                                    </div>
                                </div>
                            </div>
                            
                                <div class="panel-footer">
                                    <span class="pull-left"></span>
                                    <span class="pull-right"></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>

                </div>
                <!-- /.row -->



<?php
	return true;
}

# GERA UM LANCAMENTO BANCARIO 
############################################
function geraLancamentoBancarioConsistencia($valor,$idUsuario,$datareferencia,$tipolancamento,$dataBaixa,$fDoc){



	if($valor==null ){return true;}

	// Realize a conexão com o banco de dados
	$db = DB::getInstance();
	//$dataatual = date("d-m-Y H:i:s");
	$datareferencia 		= str_replace("/", "-", $datareferencia);
	$dataReferenciaMysql 	= date('Y-m-d', strtotime($datareferencia));
    //echo $dataReferenciaMysql;. 

    

    //echo $dataBaixa . "<br>";
	#Prepara data de Baixa
	$dataArray = 0;
	if(isset($dataBaixa)){
		$dataArray = 	explode('/', $dataBaixa);
		$dataBaixaMysql 	= $dataArray[2]."-".$dataArray[0]."-".$dataArray[1];

	}else{
			$dataBaixaMysql 	= "2013-01-15";
	}
    //echo "<br>". $dataBaixaMysql;
    //exit;

	//echo "<br>valor = {$valor}";
    $tempVl = str_replace(",", "", $valor );
    $tempVl = str_replace("*", "", $tempVl );
    
    //echo "<br>temp = {$tempVl}";

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
		{$idUsuario},
		'{$tempVl}',
		'C',
		'{$dataBaixaMysql}',

		2,
		0,
		0,
		Null,
		Null,

		'Lançamento bancário gerado pelo script de Migracao ' ,
		1,
		'{$dataReferenciaMysql}',
		Null,
		'CONS-{$fDoc}',
		'$tipolancamento'
	)";



		if($dataBaixaMysql != "--"){
		$db->query($sql) or die($db->errorInfo()[2]); 
		return true;
	}
}

# Verifa o status de comparacao ENTRE A ACOMPARACAO DO EXEL ENVIADO
# E O BANCO DE DADOS
#######################################################################
function VerificaLancExiste($DataReferencia,$valorOferta,$idUsuario){

	#Prepara data de refrencia
	$mesRef = 0;
	$anoRef = 0;
	$dataArray = 0;
	if(isset($DataReferencia)){
		$dataArray = 	explode('/', $DataReferencia);
		$mesRef = $dataArray[0];
		$anoRef = $dataArray[1];	
	}
	// Realize a conexão com o banco de dados
	$db = DB::getInstance();
	//echo "<br>valor = {$valorOferta}";
    $tempVl = str_replace(",", "", $valorOferta );
    $tempVl = str_replace("*", "", $tempVl );
    	  floatval($_POST['$va']);


	$vlFloat  = floatval($tempVl)  ;  
    //echo "<br>temp = {$tempVl}";


/*

	echo "<br>DataReferencia = " 	. $DataReferencia;
	echo "<br>valorOferta = " 		. $valorOferta;
	echo "<br>idUsuario = " 		. $idUsuario;
	echo "<br>";
	echo "#########################################<br><br><br>";
	//echo "<br>DataReferencia = " . $DataReferencia;

*/



	#SQL INICIO 
	# Verifica se existe lancamento identico
	$sql = "select * from lancamentosbancarios
			where 
				month(DataReferencia) = {$mesRef}
			and year(DataReferencia)  = {$anoRef}
			and idUsuario = {$idUsuario}
			and Format(valor,3) = Format({$vlFloat},3) 
	";





	$resultLancamentos = $db->query($sql)->results(true) or trigger_error($db->errorInfo()[2]); 
	$count = $resultLancamentos->num_rows;


	//echo $sql ;
	//echo "<br> Count :  {$count} ";
	//exit();
	if($count >= 1){
		//echo "<br> {$sql}";
		return "Existe";
	}
	 
	# Verifica se existe lancamento no mesmo mes com valor diferente
	$sql = "select * from lancamentosbancarios
			where 
				month(DataReferencia) = {$mesRef}
			and year(DataReferencia)  = {$anoRef}
			and idUsuario = {$idUsuario}
			and NumeroDocumento <> 'CONS0000'
	";
	$resultLancamentos = $db->query($sql)->results(true) or trigger_error($db->errorInfo()[2]); 
	$count = $resultLancamentos->num_rows;
	//echo "<br>  sql = {$sql}";
	//echo "<br> Count :  {$count} ";
	

	//exit();
	if($count >= 1){
		return "ValorNaoIgual";
	}else
	{
		return "NaoExiste";
	}

	//echo "<br>  sql = {$sql}";
	//exit();

}






?>

<style type="text/css">
	.Vencida{    
	    width: 110px;
	    padding: 1px;
	    border: 1px solid white;
	    border-radius: 8px;
	    margin: 0; 
	    background-color: red;
	    color: white;
	}

	.AVencer{    
	    width: 110px;
	    padding: 1px;
	    border: 1px solid white;
	    border-radius: 8px;
	    margin: 0; 
	    background-color: green;
	    color: white;
	}

	.Recebida{    
	    width: 110px;
	    padding: 2px;
	    border: 1px solid white;
	    border-radius: 8px;
	    margin: 0; 
	    background-color: blue;
	    color: white;
	}
</style>
<?php
$tituloPrincipal = "Verificar consistencia";
$tituloSecondario = "Processamento de extratos antigos";
$navPagina = "Listar relatório de pendentes";
?>
	<!-- TITULO e cabeçalho das paginas  -->
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3><img src="http://saldopositivo.cgd.pt/assets/2014/12/CONCILIA%C3%87%C3%83O-BANC%C3%81RIA.jpg" width="100" height="100">
										<?=$tituloPrincipal?> <br><br>
                    <small><?=$$tituloSecondario?></small></h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><a href="listar-pendentes-consistencia.php"><?=$navPagina?></a></li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- /.row -->
<form id="formulario" method="post" enctype="multipart/form-data" action="consistencia.php?file=yes">
  <div class="row">
      <div class="col-lg-12">
              
              <div class="form-group">
                  <label>Escolha o arquivo de extrato para processar</label>
                  <br><br>
                  <input id="imagem" name="imagem" type="file">

                  
              </div>                        

      </div>
  </div>
</form>

<div id="visualizar"></div>
<?php include("footer.php")    ; ?>

<script type="text/javascript"> 
$(document).ready(function(){ 
 
  /* #imagem é o id do input, ao alterar o conteudo do input execurará a função baixo */ 
  $('#imagem').change(function(){ 
    
    //alert('Teste');

    $('#visualizar').html('<img src="ajax-loader.gif" alt="Enviando..."/> Enviando...'); 
    /* Efetua o Upload sem dar refresh na pagina */
     


        $("#formulario").ajaxForm({

           target:'#visualizar' ,

            success: function(response, textStatus, xhr, form) {
                console.log("in ajaxForm success");

                if (!response.length || response != 'good') {
                    console.log("bad or empty response");
                    return xhr.abort();
                }
                console.log("All good. Do stuff");
            },
            error: function(xhr, textStatus, errorThrown) {
                console.log(textStatus);
                console.log(errorThrown);
                console.log("in ajaxForm error");
            },
            complete: function(xhr, textStatus) {
                console.log("in ajaxForm complete");
            }
        }).submit();

   }); 
}) 

</script>


