<?php
ini_set('display_errors',0);
ini_set('display_startup_erros',0);
error_reporting(0);

session_start();
	//Constantes
	/*
		$Servidor	= "186.202.152.189";
		$NomeBanco 	= "avivamissoes22";
		$User 	   	= "avivamissoes22";
		$Senha	   	= "Aviva@Missoes";
	*/

	/* PRODUCAO	*/
	define('Cons_Servidor', 	'186.202.152.189', false);
	define('Cons_NomeBanco', 	'avivamissoes22', false);
	define('Cons_UserBD', 		'avivamissoes22', false);
	define('Cons_SenhaBD', 		'Aviva@Missoes', false);


// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
//require("phpmailer/class.phpmailer.php");
require ('phpmailer/PHPMailerAutoload.php');




	/* HOMOLOGACAO - LOCALHOS 
	define('Cons_Servidor', 	'localhost', false);
	define('Cons_NomeBanco', 	'avivamissoes22', false);
	define('Cons_UserBD', 		'root', false);
	define('Cons_SenhaBD', 		'root', false);
	*/

	//Acesso bando online Locaweb
	$link = mysql_connect(Cons_Servidor, Cons_UserBD, Cons_SenhaBD);
	if (!$link) {
	    die('Not connected : ' . mysql_error());
	}//else{ 	echo 'CONECTADO';}


	    mysql_query("SET NAMES 'utf8'");
		mysql_query("SET character_set_connection=utf8");
		mysql_query("SET character_set_client=utf8");
		mysql_query("SET character_set_results=utf8");

	if (! mysql_select_db(Cons_NomeBanco) ) {
	    die ('Erro no banco de dados  : ' . mysql_error());
	}

	function Redirect($url, $permanent = false)
	{
	    header('Location: ' . $url, true, $permanent ? 301 : 302);
	    exit();
	}

	function url(){
	  return sprintf(
	    "%s://%s%s",
	    isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
	    $_SERVER['SERVER_NAME'],
	    $_SERVER['REQUEST_URI']
	  );
	}


//validar e-mails usando regexp
function validaEmail($email) {
	$conta = "^[a-zA-Z0-9\._-]+@";
	$domino = "[a-zA-Z0-9\._-]+.";
	$extensao = "([a-zA-Z]{2,4})$";
	$pattern = $conta.$domino.$extensao;
	if (ereg($pattern, $email))
		return true;
	else
		return false;
}	


#funcao de envio de emails especifico pela locaweb
function funcEnviaConfirmacaoDeposito($maildestinatario, $nomeDestinatario, $valor, $data){

// Inicia a classe PHPMailer
    $mail = new PHPMailer();
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsSMTP(); // Define que a mensagem será SMTP
//$mail->Host = "localhost"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
$mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
$mail->Username = 'financeiro@avivamissoes.com.br'; // Usuário do servidor SMTP (endereço de email)
$mail->Password = 'Aviva2015'; // Senha do servidor SMTP (senha do email usado)
 
// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->From = "financeiro@avivamissoes.com.br"; // Seu e-mail
$mail->Sender = "financeiro@avivamissoes.com.br"; // Seu e-mail
$mail->FromName = "Equipe Financeira [DGEM]"; // Seu nome
 
// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->AddAddress($maildestinatario);
//$mail->AddAddress('ivinson@mpcsaopaulo.org');
//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
 
// Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
 
// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
$assunto  = '=?UTF-8?B?'.base64_encode("Confirmação de depósito - Remessa {$data}").'?=';
$mensagem = "<img src='http://avivamissoes.com.br/wp-content/uploads/2014/03/Logo300x100.png'>". utf8_decode("<h1>Olá amado pastor, do campo de {$nomeDestinatario}</h1>");
$mensagem =$mensagem . utf8_decode("<h2>Esse email é para confirmar o depósito da remessa referente a {$data}, no valor de R$ {$valor} reais.</h2><br>");
$mensagem =$mensagem . utf8_decode("Uma coisa importante é lembra-lo que existe uma outra forma de enviar suas ofertas, através de boleto bancário.") . "<br>";
$mensagem =$mensagem . utf8_decode("Veja as vantagens : ") . "<br>";
$mensagem =$mensagem . utf8_decode("1 - Não precisa mais enviar comprovantes ") . "<br>";
$mensagem =$mensagem . utf8_decode("2 - Suas ofertas serão identificadas automaticamente em nossos sistemas") . "<br>";
$mensagem =$mensagem . utf8_decode("3 - É rápido, seguro e fácil de usar.") . "<br>";
$mensagem =$mensagem . utf8_decode("") . "<br>";
$mensagem =$mensagem . utf8_decode("<h2>Muitos pastores já estão usufruindo a praticidade desse método.</h2>") . "<br>";
$mensagem =$mensagem . utf8_decode("Veja como é simples :") . "<br>";
$mensagem =$mensagem . utf8_decode(" - Acesse www.avivamissoes.com.br/ofertas") . "<br>";
$mensagem =$mensagem . utf8_decode(" - Escolha seu campo, valor e data de referência e pronto!") . "<br>";
$mensagem =$mensagem . utf8_decode("Após o pagamento sua oferta ja estará contabilizada em nossos relatórios. E ainda informaremos através de email a confirmação. Prático, concorda?") . "<br>";
$mensagem =$mensagem . utf8_decode("") . "<br>";
$mensagem =$mensagem . utf8_decode("") . "<br>";
$mensagem =$mensagem . utf8_decode("Queremos agradecer o seu empenho, dedicação e o coração disposto em servir em missões, contribuindo e ensinando a igreja a importância e o privilégio de sermos bons mordomos daquilo que Deus tem nos confiado!");
$mensagem =$mensagem . utf8_decode("") . "<br><br>";
$mensagem =$mensagem . utf8_decode("Muito obrigado") . "<br>";
$mensagem =$mensagem . utf8_decode("Equipe AvivaMissões [DGEM]") . "<br>";
$mail->Subject  = $assunto; // Assunto da mensagem
$mail->Body = $mensagem;

$mail->AltBody = 'Olá Pastor {$nomeDestinatario} ! \n
Esse email é para confirmar seu depósito referente a remessa referente a {$data}, no valor de R$ {$valor}.
Queremos agradecer o empenho e o coração disposto em servir missões contribuindo e ensinando a igreja!';
// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("/home/login/documento.pdf", "novo_nome.pdf");  // Insere um anexo
 
// Envia o e-mail
$enviado = $mail->Send();
 
// Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();
 
// Exibe uma mensagem de resultado
if ($enviado) {
	return true;
//echo "E-mail enviado com sucesso!";
} else {
	echo "Não foi possível enviar o e-mail.";
	echo "Informações do erro: " . $mail->ErrorInfo;
} 



}



#########################################
# CONFIRMAÇÃO DE BOLETO
###########################################
#funcao de envio de emails especifico pela locaweb
function funcEnviaConfirmacaoBoleto($maildestinatario, $nomeDestinatario, $valor, $data){

// Inicia a classe PHPMailer
    $mail = new PHPMailer();
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsSMTP(); // Define que a mensagem será SMTP
//$mail->Host = "localhost"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
    $mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
    $mail->Username = 'financeiro@avivamissoes.com.br'; // Usuário do servidor SMTP (endereço de email)
    $mail->Password = 'Aviva2015'; // Senha do servidor SMTP (senha do email usado)
    //$mail->SMTPDebug = 1;

// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->From = "financeiro@avivamissoes.com.br"; // Seu e-mail
    $mail->Sender = "financeiro@avivamissoes.com.br"; // Seu e-mail
    $mail->FromName = "Equipe Financeira [DGEM]"; // Seu nome

	$mail->SMTPOptions = array(
	    'ssl' => array(
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => true
	    )
	);    

// Define os destinatário(s)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->AddAddress($maildestinatario);
    
//$mail->AddAddress('ivinson@mpcsaopaulo.org');
//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta

// Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsHTML(true); // Define que o e-mail será enviado como HTML
//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)

// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $assunto  = '=?UTF-8?B?'.base64_encode("Confirmação de boleto bancário - Remessa {$data}").'?=';
    $mensagem = "<img src='http://avivamissoes.com.br/wp-content/uploads/2014/03/Logo300x100.png'>". utf8_decode("<h1>Olá amado pastor, do campo de {$nomeDestinatario}</h1>");
    $mensagem =$mensagem . utf8_decode("<h2>Esse email é para confirmar o recebimento da remessa referente a {$data}, no valor de R$ {$valor} reais, feita por boleto bancário.</h2><br>");

    $mensagem =$mensagem . utf8_decode("") . "<br>";
    $mensagem =$mensagem . utf8_decode("Queremos agradecer o seu empenho, dedicação e o coração disposto em servir em missões, contribuindo e ensinando a igreja a importância e o privilégio de sermos bons mordomos daquilo que Deus tem nos confiado!");
    $mensagem =$mensagem . utf8_decode("") . "<br><br>";
    $mensagem =$mensagem . utf8_decode("Muito obrigado") . "<br>";
    $mensagem =$mensagem . utf8_decode("Equipe AvivaMissões [DGEM]") . "<br>";
    $mail->Subject  = $assunto; // Assunto da mensagem
    $mail->Body = $mensagem;

    $mail->AltBody = '';
// Define os anexos (opcional)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
//$mail->AddAttachment("/home/login/documento.pdf", "novo_nome.pdf");  // Insere um anexo

// Envia o e-mail
    $enviado = $mail->Send();

// Limpa os destinatários e os anexos
    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

// Exibe uma mensagem de resultado
    if ($enviado) {
        return true;
//echo "E-mail enviado com sucesso!";
    } else {
        echo "Não foi possível enviar o e-mail.";
        echo "Informações do erro: " . $mail->ErrorInfo;
    }






}







//}




ini_set('display_errors',1);
ini_set('display_startup_erros',1);
//error_reporting(E_ALL);
error_reporting(E_ERROR | E_PARSE);
set_time_limit(0);

?>