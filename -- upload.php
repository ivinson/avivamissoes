<?php session_start();
include('config.php');
require_once("retorno/RetornoBanco.php");
require_once("retorno/RetornoFactory.php");


function linhaProcessada1($self, $numLn, $vlinha) {
  printf("%08d) ", $numLn);
  if($vlinha) {
    foreach($vlinha as $nome_indice => $valor)
      echo get_class($self) . ": $nome_indice: <b>$valor</b><br/>\n ";
    echo "<br/>\n";

  } else echo "Tipo da linha n&atilde;o identificado<br/>\n";
}

/* 
  Função handler a ser associada ao evento aoProcessarLinha de um objeto da classe 
*/
function linhaProcessada($self, $numLn, $vlinha) {
  if($vlinha) {



	  if($vlinha["registro"] == $self::DETALHE) {
      //printf("%08d: ", $numLn);
      
      $StringProcessada = get_class($self) . ": Nosso N&uacute;mero <b>".$vlinha['nosso_numero']."</b> ".
           "Data <b>".$vlinha["data_ocorrencia"]."</b> ". 
           "Valor <b>".$vlinha["valor"]."</b><br/>\n";



          echo " <div class=\"alert alert-info\">
                    <strong>Processado o retorno!</strong> 
					Nosso N&uacute;mero <b>".$vlinha['nosso_numero']."</b> ".
           			"Data <b>".$vlinha["data_ocorrencia"]."</b> ". 
           			"Valor <b>".$vlinha["valor"]."</b><br/>\n
                 </div>";

		    /*  echo  "Processado o retorno com Nosso N&uacute;mero <b>".$vlinha['nosso_numero']."</b> ".
		           "Data <b>".$vlinha["data_ocorrencia"]."</b> ". 
		           "Valor <b>".$vlinha["valor"]."</b><br/>\n";
			*/

           	$fNome_Arquivo 	=   $_FILES['imagem']['name']; 				
 			$fNN 			=  Rtrim( $vlinha["nosso_numero"], " ") ;
			$fDT			=	$vlinha["data_ocorrencia"];
			$fValor			=	$vlinha["valor"] ;

			$SqlInsereProcessamento	= "
				INSERT INTO ProcessamentoRetorno
				(
				`NossoNumero`,
				`DataPgto`,
				`Valor`,
				`DataProcessamento`,
				`NomeArquivo`,
				`StringProcessada`,
				`idusuario`)
				VALUES
				(
				'$fNN',
				STR_TO_DATE('$fDT', '%d/%m/%Y') ,
				$fValor,
				CURDATE(),
				'$fNome_Arquivo',
				'$StringProcessada'
				, 0);";

				//echo "<br>" . $SqlInsereProcessamento;
	          
	          if (! mysql_query($SqlInsereProcessamento) ){
                  die( ':: Erro : '. mysql_error()); 
                  echo "Fase de teste : Anote o seguinte erro!";
                };

                //echo "SELECT * FROM contasreceber 
				//		 WHERE NossoNumero like '%". $fNN ."%';" ;

                /* Busca Boleto com esse nosso numero*/                                        
                $resultSelect2 = mysql_query("
						
						SELECT * FROM contasreceber 
						 WHERE NossoNumero like '%".$fNN."%';

                  ") or trigger_error(mysql_error());                 

                	//echo $resultSelect2;

                while($rowOption = mysql_fetch_array($resultSelect2)){ 
    					
    					foreach($rowOption AS $key => $value) { 
    						$rowOption[$key] = stripslashes($value); 
    					} 

    					 /*GERA CONTAS A RECEBER 
						TROCAR #IDUSUARIO POR BAIXADO POR
	                */

    				$SqlBaixaBoleto = "Update contasreceber 
    					set  Status 	=  	'Pago'
    						,ValorBaixa = 	'$fValor'
    						,DataBaixa 	= 	Curdate()
    						,BaixadoPor = 	0
    						 where id 	= 	".$rowOption['id'] ;

    				//echo $SqlBaixaBoleto . "<br>"		 ;

    				
	    			if (! mysql_query($SqlBaixaBoleto) ){
	                  die( ':: Erro : '. mysql_error()); 
	                  echo "Fase de teste da baixa de boleto: Anote o seguinte erro!";
	                };



	                /*GERA LANCAMENTOS BANCARIOS 
						TROCAR #IDUSUARIO POR USUARIO LOGADO baixadopor
	                */

			
					$SqlInsereProcessamento	= "
						INSERT INTO lancamentosbancarios
						(
						`idUsuario`,
						`Valor`,
						`TipoOrigem`,
						`DataBaixa`,
						`idProjeto`,

						`GeradoPor`,
						`BaixadoPor`,
						`idContaReceber`,						
						
						`Descricao`,
						`idContaBancaria`,
						`DataReferencia`,
						`NumeroDocumento`
						)
						VALUES
						(
						".$rowOption['idUsuario']." ,
						$fValor,
						'CR',
						STR_TO_DATE('$fDT', '%d/%m/%Y') ,
						".$rowOption['idProjeto']." ,
						".$rowOption['GeradoPor']." ,
						{$_SESSION['idlogado']},
						".$rowOption['id']." ,
						'Crédito gerado por boleto bancario online Nosso Nº $fNN',
						1,
						'".$rowOption['DataReferencia']."', $fNN);";

						//echo "<br>" . $SqlInsereProcessamento;


					#Verifica Lancamento
					if(verificaLancamento(0,$rowOption['DataReferencia'],$rowOption['idUsuario'])){

					  #############################
			          
			          if (! mysql_query($SqlInsereProcessamento) ){
		                  die( ':: Erro : '. mysql_error()); 
		                  echo "Fase de teste lancamentosbancarios: Anote o seguinte erro!";
		                }else{

						    //Enviar email
						    #Pegar email do pastor
						    $rowEmail = mysql_fetch_array ( 
						                    mysql_query("SELECT *
						                                  from usuarios WHERE id = ".$rowOption['idUsuario']." "));         

						    //$valor_cobrado = '1300';
						    //$data_referencia = '03/2015';
						    
						    # limpar trocar  / por ;
						    $arrMails = explode('/', $rowEmail['Email']);
						    //$mails = "";
						    foreach ($arrMails as $value) {
						        //echo "$value <br>";
						        //if (validaEmail($value))
						         //{
						            //echo "O e-mail inserido é valido!";
						            //$mails = $mails .' ; '.$value;
						             //funcEnviaConfirmacaoBoleto( $value, $rowEmail['Nome'], $fValor, $rowOption['DataReferencia'] );
						             funcEnviaConfirmacaoBoleto_ver02( $value, $rowEmail['Nome'], $fValor, $rowOption['DataReferencia'] );	
						            //echo "<br>Enviado com sucesso";

						        //}
						    }

                      };

                      #########################################
                      	};// Dim verifica Lancamento

      				//echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
    			} 

    }
  } else echo "Tipo da linha n&atilde;o identificado<br/>\n";
}





//include('db.php'); 
$pasta = "retorno/files-itau/"; /* formatos de imagem permitidos */ 

//$pasta = dirname($_SERVER['PHP_SELF']) ;
//$permitidos = array(".jpg",".jpeg",".gif",".png", ".bmp",".ret"); 
$permitidos = array(".ret"); 
if(isset($_POST)){ 
	$nome_imagem = $_FILES['imagem']['name']; 
	$tamanho_imagem = $_FILES['imagem']['size']; 
	/* pega a extensão do arquivo */ 
	$ext = strtolower(strrchr($nome_imagem,".")); 
	
	/* verifica se a extensão está entre as extensões permitidas */ 
	if(in_array($ext,$permitidos)){ 
		/* converte o tamanho para KB */ 
		$tamanho = round($tamanho_imagem / 1024); 
		if($tamanho < 1024){ 
		//se imagem for até 1MB envia 
			$nome_atual = md5(uniqid(time())).$ext; 
			//nome que dará a imagem 
			$tmp = $_FILES['imagem']['tmp_name']; 
			//caminho temporário da imagem 


			$filename = $pasta.$nome_imagem;
			//echo "filename - " . $filename;


			if (file_exists($filename)) {
			    
			    		echo " <div class=\"alert alert-danger\">
                    <strong> OPERAÇÃO NÃO PERMITIDA!</strong> 
					  <br>O Arquivo <b>$filename </b> já foi processado!
                 </div>";
			} 
			else 
			{
			
				//echo "nao existe";

			//echo "O arquivo $filename não existe";
			/* 	

				ok 1- Faz o upload 
				2- Insere no banco de dados 
				3- Processa e da baixa nos boletos
				4- Mensagem processado com sucesso
*/
		
				if(move_uploaded_file($tmp,$pasta.$nome_imagem))
					{ 

					//-------INÍCIO DA EXECUÇÃO DO CÓDIGO-----------------------------------------------------

					  $cnab400 = RetornoFactory::getRetorno($filename, "linhaProcessada");
					  $retorno = new RetornoBanco($cnab400);
					  $retorno->processar();

					  //echo "<img src='retorno/files-itau/".$nome_imagem."' id='previsualizar'>"; 
					  //imprime a foto na tela 

				
          			echo " <div class=\"alert alert-success\">
                    <strong> Processamento Concluido com sucesso</strong> 
					  Você pode verificar as baixas na tela de 
					  <a href='contas-a-receber.php' > Ofertas </a>
                 </div>";

					}
					else
					{  
		echo " <div class=\"alert alert-warning\">
                    <strong> Opa!</strong> 
					  Algum problema ocorreu !
                 </div>";						
							  
					}



			}
 
		}
		else{ 


		echo " <div class=\"alert alert-warning\">
                    <strong> Arquivo muito grande!</strong> 
					  Arquivos com no maximo 1 Mb !
                 </div>";
		} 
	}else
		{ 
					echo " <div class=\"alert alert-warning\">
                    <strong> Formato Incorreto</strong> 
					 Só é permitido apenas arquivos de retorno do banco ITAU .RET!
                 </div>";
		} 
	}
	else
	{ 
				echo " <div class=\"alert alert-warning\">
                    <strong> Selecione um arquivo</strong> 
					  Arquivos com no maximo 1 Mb !
                 </div>";
		exit; 
	} 

?>



<?php

function verificaLancamento($fValorCREDITO,$fdata,$idusuario){

    #Debug
       //echo " select count(*) as total from lancamentosbancarios where 
       //      DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
       //      and idUsuario = {$idusuario} ";

            //exit;


    $rs = mysql_query("select count(*) as total from lancamentosbancarios where 
             DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
             and idUsuario = {$idusuario}
    ");
    $row=mysql_fetch_assoc($rs);
    if($row['total'] > 0){
        //echo "total  {$row['total']} - ja existe<br>";  

        $id = $_GET['id'];  
        mysql_query("DELETE FROM `lancamentosbancarios` WHERE 

        DataReferencia = '{$fdata}' 
        and Round(Valor,2) = '{$fValorCREDITO}'
        and idUsuario = {$idusuario} ") ; 
       
        //Redirect("lancamentos-campo.php?id=".$id);
        //die("<script>location.href = 'lancamentos-campo.php?id={$id}'</script>");


        return true;
    }else{
        //echo "total  {$row['total']} - nao existe existe<br>";    
        return true;
    }


}

?>