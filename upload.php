<?php session_start();

ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(E_ALL); 

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
  


#DEBUG
/*
  if($vlinha) {
    foreach($vlinha as $nome_indice => $valor)
      echo get_class($self) . ": $nome_indice: <b>$valor</b><br/>\n ";
    echo "<br/>\n";

    continue;

  }

*/
  



if($vlinha) {
	if($vlinha["registro"] == $self::DETALHE) {
  	//printf("%08d: ", $numLn);
  	#echo "<br>Acao  :" ." Identificou a linha detalhe"; 
	//die();  

	#Variaveis de controle
	$StringProcessada = get_class($self) . ": Nosso N&uacute;mero <b>".$vlinha['nosso_numero']."</b> "."Data <b>".$vlinha["data_ocorrencia"]."</b> "."Valor <b>".$vlinha["valor"]."</b>";
	$statusboleto   = 'Pago';
	$fNome_Arquivo 	=   $_FILES['imagem']['name']; 				
	$fNN 			=   Rtrim( $vlinha["nosso_numero"], " ") ;
	$fDT			=	$vlinha["data_ocorrencia"];
	$fValor			=	$vlinha["valor"] ;
	$controle		=   Rtrim($vlinha["controle"], " ");
	##########################################################


	### TODO
	//Vericar boletos pelo numero do boleto(Nosso numero) ! So apagar QUANDO O NOSSO NUMERO FOR IGUAL
	// Isso acontece quando o usuraio sobe mais de uma vez o mesmo retorno.
	// Apenas apagar qudo o vhalor for Fechamento (no mesmo mes), ou qdo for do MESMO Nosso numero.


	//echo "<br> fnn = ".$fNN;  
	//die();





	#Verifica se o boleto foi rejeitado e grava
	# o Status de REJEITADO nesse boleto
	if($fNN == '00000000'){
		
		#Seta rejeitado
		$statusboleto = 'Rejeitado';

		#Encontra boleto com esse nosso numero                                 
		$resultSelect2 = mysql_query(" SELECT * FROM contasreceber WHERE NossoNumero like '%".$controle."%';") or trigger_error(mysql_error());                 
		//echo "SELECT * FROM contasreceber WHERE NossoNumero like '%".$controle."%';";
		//die();
		while($rowOption = mysql_fetch_array($resultSelect2)){ 
			foreach($rowOption AS $key => $value) { 
				$rowOption[$key] = stripslashes($value); 
			} 

			#Atualiza boleto para rejeitado no banco de dados
			$SqlBaixaBoletoRejeitado = "Update contasreceber 
					set  Status 	=  	'{$statusboleto}'
						,ValorBaixa = 	'$fValor'
						,DataBaixa 	= 	Curdate()
						,BaixadoPor = 	0
						 where id 	= 	".$rowOption['id'] ;
			if (! mysql_query($SqlBaixaBoletoRejeitado) ){
				  die( ':: Erro : '. mysql_error()); 
				};


			#Verifica se há lançamento baixado, para esse boleto rejeitado e deleta
			//if(verificaLancamento($fValor,$rowOption['DataReferencia'],$rowOption['idUsuario'])){ }

				//echo "... ->> <br>";

			
	

         	#Mensagem Azul de processado com sucesso esse boleto
          	echo " <div class=\"alert alert-danger\">
                    Atenção - Boleto <strong>REJEITADO!</strong> 
					Nosso N&uacute;mero <b>".$vlinha['controle']."</b> ".
           			"Data <b>"  .$vlinha["data_ocorrencia"]."</b> ". 
           			"Valor <b>" .$vlinha["valor"]."</b><br/>
           			Avise a Igreja/Pastor através dos emails cadastrdos e olhe qual o motivo junto a sua instituição financeira para correção junto ao desenvolvedor .
           			
                 </div>";						 

					#Avisa Usuario desse boleto rejeitado
					//echo  "O Boleto com Nosso N&uacute;mero <b>".$vlinha['controle']."</b> ".
					//	       "Data <b>".$vlinha["data_ocorrencia"]."</b> ". 
					//	       "Valor <b>".$vlinha["valor"]."</b> foi REJEITADO. Verificar junto ao banco e avisar o pastor <br/>\n";					 
		}
	}else{	

			#Caso o boleto tenha sido aceito
		    //echo  "Processado o retorno com Nosso N&uacute;mero <b>".$vlinha['nosso_numero']."</b> ".
		     //      "Data <b>".$vlinha["data_ocorrencia"]."</b> ". 
		     //      "Valor <b>".$vlinha["valor"]."</b><br/>\n";
		
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

				//echo "<br> ## PROCESSAMENTO : " . $SqlInsereProcessamento ."<br>";
				//die();
	          


	          #Debug- Descomentar
	          if (! mysql_query($SqlInsereProcessamento) ){
                  die( ':: Erro : '. mysql_error()); 
               //   echo "Fase de teste : Anote o seguinte erro!";
                };

               //echo " <br> SELECT * FROM contasreceber 
				//		 WHERE NossoNumero like '%". $fNN ."%';" ;

                /* Busca Boleto com esse nosso numero*/                                        
                $resultSelect2 = mysql_query("
						
						SELECT * FROM contasreceber 
						 WHERE NossoNumero like '%".$fNN."%';

                  ") or trigger_error(mysql_error());                 

                while($rowOption = mysql_fetch_array($resultSelect2)){ 
    					
    					foreach($rowOption AS $key => $value) { 
    						$rowOption[$key] = stripslashes($value); 
    					} 



    					//echo "----- >>>";
    					//die();

    					 /*GERA CONTAS A RECEBER 
						TROCAR #IDUSUARIO POR BAIXADO POR
	                	*/

    					$SqlBaixaBoleto = "Update contasreceber 
    					set  Status 	=  	'Pago'
    						,ValorBaixa = 	'$fValor'
    						,DataBaixa 	= 	Curdate()
    						,BaixadoPor = 	0
    						 where id 	= 	".$rowOption['id'] ;

    					// echo "<br> UPDATE :". $SqlBaixaBoleto . "<br>"		 ;

    					#z3
	    				#debug - Descomentar 
		    			if (! mysql_query($SqlBaixaBoleto) ){
		                  die( ':: Erro : '. mysql_error()); 
		                  echo "Fase de teste da baixa de boleto: Anote o seguinte erro!";
		                };



		                /*GERA LANCAMENTOS BANCARIOS 	*/
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

							//echo "<br> lancamentosbancarios  " . $SqlInsereProcessamento;


							#Verifica Lancamento
							if(verificaLancamento($fValor,$rowOption['DataReferencia'],$rowOption['idUsuario'],$fNN)){

							  #############################
					            
								#descomentar  e trocar o if
								//if(1==2){
					            
					            if (! mysql_query($SqlInsereProcessamento) ){
				                  die( ':: Erro : '. mysql_error()); 
				                 // echo "Fase de teste lancamentosbancarios: Anote o seguinte erro!";
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
								    $mails = "";

								    foreach ($arrMails as $value) {
								        //echo "$value <br>";
								        //if (validaEmail($value))
								         //{
								            //echo "O e-mail inserido é valido!";
								            //$mails = $mails .' ; '.$value;
								             //funcEnviaConfirmacaoBoleto( $value, $rowEmail['Nome'], $fValor, $rowOption['DataReferencia'] );
								            

								    		#Debug - Descomentar
								    		$mails = $mails ."<br>Foi enviado um email para {$rowEmail['Nome']} ( {$value} ) confirmando o pagto de <b>{$fValor} </b>"; 
								             funcEnviaConfirmacaoBoleto_ver02( $value, $rowEmail['Nome'], $fValor, $rowOption['DataReferencia'] );	
								            



								            //echo "<br>Enviado com sucesso";

								        //}
								    }



				                 #Mensagem Azul de processado com sucesso esse boleto
						          echo " <div class=\"alert alert-success\">
						                    <strong>Processado o retorno!</strong> 
											Nosso N&uacute;mero <b>".$vlinha['nosso_numero']."</b> ".
						           			"Data <b>"  .$vlinha["data_ocorrencia"]."</b> ". 
						           			"Valor <b>" .$vlinha["valor"]."</b><br/>
						           			{$mails}
						                 </div>";
		                      	};
 
		                      	#########################################
                      		};// Fim verifica Lancamento

      					//echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
    			} 

    }
    };



     //die();



  } else echo "Tipo da linha n&atilde;o identificado<br/>\n";
}





//include('db.php'); 
$pasta = "retorno/files-itau/"; /* formatos de imagem permitidos */ 
//echo $pasta;



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
			#echo " <br> filename - " . $filename;
			


			#Debug - Descomentar
			//if (file_exists($filename)) {
			//if('1'== '2'){
			//    
			//    echo " <div class=\"alert alert-danger\">
            //        		<strong> OPERAÇÃO NÃO PERMITIDA!</strong> 
			//		  		<br>O Arquivo <b>$filename </b> já foi processado!
            //     		</div>";
			//} 
			//else 
		//	{
			
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

					#echo "<br><br> Acao  : " ." Moveu arquivo para " . $pas.$nome_imagem; 
					//die();
					//-------INÍCIO DA EXECUÇÃO DO CÓDIGO-----------------------------------------------------

					  $cnab400 = RetornoFactory::getRetorno($filename, "linhaProcessada");
					  $retorno = new RetornoBanco($cnab400);
					  $retorno->processar();

					  //echo "<img src='retorno/files-itau/".$nome_imagem."' id='previsualizar'>"; 
					  //imprime a foto na tela 

				
          			echo " <div class=\"alert alert-info\">
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



			//}
 
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

function verificaLancamento($fValorCREDITO,$fdata,$idusuario,$NBoleto){


	$nn= ltrim($NBoleto, '0');

    #Debug
    /*echo   " 
		select count(*) as total from lancamentosbancarios where 
		             
		             idContaReceber = {$nn} and idUsuario = {$idusuario} 
		             or 
		             (DataReferencia = '{$fdata}' and idUsuario = {$idusuario} and TipoLancamento = 'Fechamento') 

		     ";
		     */

            //die();
	//Nao necessita deletar 
	//return true;


    $rs = mysql_query("select count(*) as total from lancamentosbancarios where 
             
             idContaReceber = {$nn} and idUsuario = {$idusuario} 
             or 
             (DataReferencia = '{$fdata}' and idUsuario = {$idusuario} and TipoLancamento = 'Fechamento' )
             
    ");

    //-- and Round(Valor,2) = '{$fValorCREDITO}'

    $row=mysql_fetch_assoc($rs);
    if($row['total'] > 0){
        //echo "total  {$row['total']} - ja existe<br>";  

        //$id = $_GET['id'];  
        
        #Deleta o Registro encontrado para colocar um novo valor(inclusive fechamentos)
        mysql_query("DELETE FROM `lancamentosbancarios` WHERE 
        
        	 idContaReceber = {$nn} and idUsuario = {$idusuario} 
             	or 
             (DataReferencia = '{$fdata}' and idUsuario = {$idusuario} and TipoLancamento = 'Fechamento' )
        ") ; 
        //and Round(Valor,2) = '{$fValorCREDITO}'      

		//echo " <div class=\"alert alert-danger\">
		//<strong>Lancamento ja existe! </strong> Excluindo o pagamento de //{//$fValorCREDITO} reais.
		
		echo " <strong>Existe fechamentos ou retorno já foi feito! </strong> Excluindo o fechamento caso exista para esse lançamento e substituindo pelos valores que constam no retorno.
		</div>";
				           			

        //Redirect("lancamentos-campo.php?id=".$id);
        //die("<script>location.href = 'lancamentos-campo.php?id={$id}'</script>");


        return true;
    }else{
        //echo "total  {$row['total']} - nao existe existe<br>";    
        return true;
    }


}

?>