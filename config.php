<?php


ini_set('display_errors',1);
ini_set('display_startup_erros',1);
error_reporting(1);

session_start();
define ('DEBUG', true); 

##### EMAIL GENERICO ########
define ( 'V_EMAIL_TEMPLATE' , "
<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Strict//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\">
<head>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\"/>
<meta name=\"viewport\" content=\"width=device-width\"/>
<style>#outlook a{padding:0;}body{width:100%!important;min-width:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;margin:0;padding:0;}.ExternalClass{width:100%;}.ExternalClass,.ExternalClass p,.ExternalClass span,.ExternalClass font,.ExternalClass td,.ExternalClass div{line-height:100%;}#backgroundTable{margin:0;padding:0;width:100%!important;line-height:100%!important;}img{outline:none;text-decoration:none;-ms-interpolation-mode:bicubic;width:auto;max-width:100%;float:left;clear:both;display:block;}center{width:100%;min-width:580px;}a img{border:none;}p{margin:0 0 0 10px;}table{border-spacing:0;border-collapse:collapse;}td{word-break:break-word;-webkit-hyphens:auto;-moz-hyphens:auto;hyphens:auto;border-collapse:collapse!important;}table,tr,td{padding:0;vertical-align:top;text-align:left;}hr{color:#d9d9d9;background-color:#d9d9d9;height:1px;border:none;}table.body{height:100%;width:100%;}table.container{width:580px;margin:0 auto;text-align:inherit;}table.row{padding:0px;width:100%;position:relative;}table.container table.row{display:block;}td.wrapper{padding:10px 20px 0px 0px;position:relative;}table.columns,table.column{margin:0 auto;}table.columns td,table.column td{padding:0px 0px 10px;}table.columns td.sub-columns,table.column td.sub-columns,table.columns td.sub-column,table.column td.sub-column{padding-right:10px;}td.sub-column,td.sub-columns{min-width:0px;}table.row td.last,table.container td.last{padding-right:0px;}table.one{width:30px;}table.two{width:80px;}table.three{width:130px;}table.four{width:180px;}table.five{width:230px;}table.six{width:280px;}table.seven{width:330px;}table.eight{width:380px;}table.nine{width:430px;}table.ten{width:480px;}table.eleven{width:530px;}table.twelve{width:580px;}table.one center{min-width:30px;}table.two center{min-width:80px;}table.three center{min-width:130px;}table.four center{min-width:180px;}table.five center{min-width:230px;}table.six center{min-width:280px;}table.seven center{min-width:330px;}table.eight center{min-width:380px;}table.nine center{min-width:430px;}table.ten center{min-width:480px;}table.eleven center{min-width:530px;}table.twelve center{min-width:580px;}table.one .panel center{min-width:10px;}table.two .panel center{min-width:60px;}table.three .panel center{min-width:110px;}table.four .panel center{min-width:160px;}table.five .panel center{min-width:210px;}table.six .panel center{min-width:260px;}table.seven .panel center{min-width:310px;}table.eight .panel center{min-width:360px;}table.nine .panel center{min-width:410px;}table.ten .panel center{min-width:460px;}table.eleven .panel center{min-width:510px;}table.twelve .panel center{min-width:560px;}.body .columns td.one,.body .column td.one{width:8.333333%;}.body .columns td.two,.body .column td.two{width:16.666666%;}.body .columns td.three,.body .column td.three{width:25%;}.body .columns td.four,.body .column td.four{width:33.333333%;}.body .columns td.five,.body .column td.five{width:41.666666%;}.body .columns td.six,.body .column td.six{width:50%;}.body .columns td.seven,.body .column td.seven{width:58.333333%;}.body .columns td.eight,.body .column td.eight{width:66.666666%;}.body .columns td.nine,.body .column td.nine{width:75%;}.body .columns td.ten,.body .column td.ten{width:83.333333%;}.body .columns td.eleven,.body .column td.eleven{width:91.666666%;}.body .columns td.twelve,.body .column td.twelve{width:100%;}td.offset-by-one{padding-left:50px;}td.offset-by-two{padding-left:100px;}td.offset-by-three{padding-left:150px;}td.offset-by-four{padding-left:200px;}td.offset-by-five{padding-left:250px;}td.offset-by-six{padding-left:300px;}td.offset-by-seven{padding-left:350px;}td.offset-by-eight{padding-left:400px;}td.offset-by-nine{padding-left:450px;}td.offset-by-ten{padding-left:500px;}td.offset-by-eleven{padding-left:550px;}td.expander{visibility:hidden;width:0px;padding:0!important;}table.columns .text-pad,table.column .text-pad{padding-left:10px;padding-right:10px;}table.columns .left-text-pad,table.columns .text-pad-left,table.column .left-text-pad,table.column .text-pad-left{padding-left:10px;}table.columns .right-text-pad,table.columns .text-pad-right,table.column .right-text-pad,table.column .text-pad-right{padding-right:10px;}.block-grid{width:100%;max-width:580px;}.block-grid td{display:inline-block;padding:10px;}.two-up td{width:270px;}.three-up td{width:173px;}.four-up td{width:125px;}.five-up td{width:96px;}.six-up td{width:76px;}.seven-up td{width:62px;}.eight-up td{width:52px;}table.center,td.center{text-align:center;}h1.center,h2.center,h3.center,h4.center,h5.center,h6.center{text-align:center;}span.center{display:block;width:100%;text-align:center;}img.center{margin:0 auto;float:none;}.show-for-small,.hide-for-desktop{display:none;}body,table.body,h1,h2,h3,h4,h5,h6,p,td{color:#222222;font-family:\"Helvetica\",\"Arial\",sans-serif;font-weight:normal;padding:0;margin:0;text-align:left;line-height:1.3;}h1,h2,h3,h4,h5,h6{word-break:normal;}h1{font-size:40px;}h2{font-size:36px;}h3{font-size:32px;}h4{font-size:28px;}h5{font-size:24px;}h6{font-size:20px;}body,table.body,p,td{font-size:14px;line-height:19px;}p.lead,p.lede,p.leed{font-size:18px;line-height:21px;}p{margin-bottom:10px;}small{font-size:10px;}a{color:#2ba6cb;text-decoration:none;}a:hover{color:#2795b6!important;}a:active{color:#2795b6!important;}a:visited{color:#2ba6cb!important;}h1 a,h2 a,h3 a,h4 a,h5 a,h6 a{color:#2ba6cb;}h1 a:active,h2 a:active,h3 a:active,h4 a:active,h5 a:active,h6 a:active{color:#2ba6cb!important;}h1 a:visited,h2 a:visited,h3 a:visited,h4 a:visited,h5 a:visited,h6 a:visited{color:#2ba6cb!important;}.panel{background:#f2f2f2;border:1px solid #d9d9d9;padding:10px!important;}.sub-grid table{width:100%;}.sub-grid td.sub-columns{padding-bottom:0;}table.button,table.tiny-button,table.small-button,table.medium-button,table.large-button{width:100%;overflow:hidden;}table.button td,table.tiny-button td,table.small-button td,table.medium-button td,table.large-button td{display:block;width:auto!important;text-align:center;background:#2ba6cb;border:1px solid #2284a1;color:#ffffff;padding:8px 0;}table.tiny-button td{padding:5px 0 4px;}table.small-button td{padding:8px 0 7px;}table.medium-button td{padding:12px 0 10px;}table.large-button td{padding:21px 0 18px;}table.button td a,table.tiny-button td a,table.small-button td a,table.medium-button td a,table.large-button td a{font-weight:bold;text-decoration:none;font-family:Helvetica,Arial,sans-serif;color:#ffffff;font-size:16px;}table.tiny-button td a{font-size:12px;font-weight:normal;}table.small-button td a{font-size:16px;}table.medium-button td a{font-size:20px;}table.large-button td a{font-size:24px;}table.button:hover td,table.button:visited td,table.button:active td{background:#2795b6!important;}table.button:hover td a,table.button:visited td a,table.button:active td a{color:#fff!important;}table.button:hover td,table.tiny-button:hover td,table.small-button:hover td,table.medium-button:hover td,table.large-button:hover td{background:#2795b6!important;}table.button:hover td a,table.button:active td a,table.button td a:visited,table.tiny-button:hover td a,table.tiny-button:active td a,table.tiny-button td a:visited,table.small-button:hover td a,table.small-button:active td a,table.small-button td a:visited,table.medium-button:hover td a,table.medium-button:active td a,table.medium-button td a:visited,table.large-button:hover td a,table.large-button:active td a,table.large-button td a:visited{color:#ffffff!important;}table.secondary td{background:#e9e9e9;border-color:#d0d0d0;color:#555;}table.secondary td a{color:#555;}table.secondary:hover td{background:#d0d0d0!important;color:#555;}table.secondary:hover td a,table.secondary td a:visited,table.secondary:active td a{color:#555!important;}table.success td{background:#5da423;border-color:#457a1a;}table.success:hover td{background:#457a1a!important;}table.alert td{background:#c60f13;border-color:#970b0e;}table.alert:hover td{background:#970b0e!important;}table.radius td{-webkit-border-radius:3px;-moz-border-radius:3px;border-radius:3px;}table.round td{-webkit-border-radius:500px;-moz-border-radius:500px;border-radius:500px;}body.outlook p{display:inline!important;}@media only screen and (max-width: 600px) {table[class=\"body\"] img{width:auto!important;height:auto!important;}table[class=\"body\"] center{min-width:0!important;}table[class=\"body\"] .container{width:95%!important;}table[class=\"body\"] .row{width:100%!important;display:block!important;}table[class=\"body\"] .wrapper{display:block!important;padding-right:0!important;}table[class=\"body\"] .columns,table[class=\"body\"] .column{table-layout:fixed!important;float:none!important;width:100%!important;padding-right:0px!important;padding-left:0px!important;display:block!important;}table[class=\"body\"] .wrapper.first .columns,table[class=\"body\"] .wrapper.first .column{display:table!important;}table[class=\"body\"] table.columns td,table[class=\"body\"] table.column td{width:100%!important;}table[class=\"body\"] .columns td.one,table[class=\"body\"] .column td.one{width:8.333333%!important;}table[class=\"body\"] .columns td.two,table[class=\"body\"] .column td.two{width:16.666666%!important;}table[class=\"body\"] .columns td.three,table[class=\"body\"] .column td.three{width:25%!important;}table[class=\"body\"] .columns td.four,table[class=\"body\"] .column td.four{width:33.333333%!important;}table[class=\"body\"] .columns td.five,table[class=\"body\"] .column td.five{width:41.666666%!important;}table[class=\"body\"] .columns td.six,table[class=\"body\"] .column td.six{width:50%!important;}table[class=\"body\"] .columns td.seven,table[class=\"body\"] .column td.seven{width:58.333333%!important;}table[class=\"body\"] .columns td.eight,table[class=\"body\"] .column td.eight{width:66.666666%!important;}table[class=\"body\"] .columns td.nine,table[class=\"body\"] .column td.nine{width:75%!important;}table[class=\"body\"] .columns td.ten,table[class=\"body\"] .column td.ten{width:83.333333%!important;}table[class=\"body\"] .columns td.eleven,table[class=\"body\"] .column td.eleven{width:91.666666%!important;}table[class=\"body\"] .columns td.twelve,table[class=\"body\"] .column td.twelve{width:100%!important;}table[class=\"body\"] td.offset-by-one,table[class=\"body\"] td.offset-by-two,table[class=\"body\"] td.offset-by-three,table[class=\"body\"] td.offset-by-four,table[class=\"body\"] td.offset-by-five,table[class=\"body\"] td.offset-by-six,table[class=\"body\"] td.offset-by-seven,table[class=\"body\"] td.offset-by-eight,table[class=\"body\"] td.offset-by-nine,table[class=\"body\"] td.offset-by-ten,table[class=\"body\"] td.offset-by-eleven{padding-left:0!important;}table[class=\"body\"] table.columns td.expander{width:1px!important;}table[class=\"body\"] .right-text-pad,table[class=\"body\"] .text-pad-right{padding-left:10px!important;}table[class=\"body\"] .left-text-pad,table[class=\"body\"] .text-pad-left{padding-right:10px!important;}table[class=\"body\"] .hide-for-small,table[class=\"body\"] .show-for-desktop{display:none!important;}table[class=\"body\"] .show-for-small,table[class=\"body\"] .hide-for-desktop{display:inherit!important;}}</style>
<style>table.facebook td{background:#3b5998;border-color:#2d4473;}table.facebook:hover td{background:#2d4473!important;}table.twitter td{background:#00acee;border-color:#0087bb;}table.twitter:hover td{background:#0087bb!important;}table.google-plus td{background-color:#DB4A39;border-color:#CC0000;}table.google-plus:hover td{background:#CC0000!important;}.template-label{color:#ffffff;font-weight:bold;font-size:11px;}.callout .panel{background:#ECF8FF;border-color:#b9e5ff;}.header{background:#3B5998;}.footer .wrapper{background:#ebebeb;}.footer h5{padding-bottom:10px;}table.columns .text-pad{padding-left:10px;padding-right:10px;}table.columns .left-text-pad{padding-left:10px;}table.columns .right-text-pad{padding-right:10px;}@media only screen and (max-width: 600px) {table[class=\"body\"] .right-text-pad{padding-left:10px!important;}table[class=\"body\"] .left-text-pad{padding-right:10px!important;}}</style>
<style>table.facebook td{background:#3b5998;border-color:#2d4473;}table.facebook:hover td{background:#2d4473!important;}table.twitter td{background:#00acee;border-color:#0087bb;}table.twitter:hover td{background:#0087bb!important;}table.google-plus td{background-color:#DB4A39;border-color:#CC0000;}table.google-plus:hover td{background:#CC0000!important;}.template-label{color:#ffffff;font-weight:bold;font-size:11px;}.callout .wrapper{padding-bottom:20px;}.callout .panel{background:#ECF8FF;border-color:#b9e5ff;}.header{background:#3B5998;}.footer .wrapper{background:#ebebeb;}.footer h5{padding-bottom:10px;}table.columns .text-pad{padding-left:10px;padding-right:10px;}table.columns .left-text-pad{padding-left:10px;}table.columns .right-text-pad{padding-right:10px;}@media only screen and (max-width: 600px) {table[class=\"body\"] .right-text-pad{padding-left:10px!important;}table[class=\"body\"] .left-text-pad{padding-right:10px!important;}}</style>
</head>
<body>
<table class=\"body\">
<tr>
<td class=\"center\" align=\"center\" valign=\"top\">
<center>
<table class=\"row header\">
<tr>
<td class=\"center\" align=\"center\">
<center>
<table class=\"container\">
<tr>
<td class=\"wrapper last\">
<table class=\"twelve columns\">
<tr>
<td class=\"six sub-columns\">
<img src='http://avivamissoes.com.br/wp-content/uploads/2014/03/Logo300x100.png' </td>
<td class=\"six sub-columns last\" style=\"text-align:right; vertical-align:middle;\">
<span class=\"template-label\">Diretoria de Evangelismo e Missões</span>
</td>
<td class=\"expander\"></td>
</tr>
</table>
</td>
</tr>
</table>
</center>
</td>
</tr>
</table>
<table class=\"container\">
<tr>
<td>
<table class=\"row\">
<tr>
<td class=\"wrapper last\">
<table class=\"twelve columns\">
<tr>
<td>
<h1>Olá, #NOME#</h1>
<p class=\"lead\">#Texto1#</p>
<p>#Texto2#</p>
</td>
<td class=\"expander\"></td>
</tr>
</table>
</td>
</tr>
</table>
<table class=\"row callout\">
<tr>
<td class=\"wrapper last\">
<table class=\"twelve columns\">
<tr>
<td class=\"panel\">
<p>#RodapeAzul#</p>
</td>
<td class=\"expander\"></td>
</tr>
</table>
</td>
</tr>
</table>
<table class=\"row footer\">
<tr>
<td class=\"wrapper\">
<table class=\"six columns\">
<tr>
<td class=\"left-text-pad\">
<h5>Fale com a gente:</h5>
<table class=\"tiny-button facebook\">
<tr>
<td>
<a href=\"http://facebook.com/avivamissoes\">Facebook</a>
</td>
</tr>
</table>
<br>

<br>

</td>
<td class=\"expander\"></td>
</tr>
</table>
</td>
<td class=\"wrapper last\">
<table class=\"six columns\">
<tr>
<td class=\"last right-text-pad\">
<h5>Contatos:</h5>
<p>Telefone: 11 4232-9671</p>
<p>Email: <a href=\"mailto:contato@avivamissoes.com.br\">contato@avivamissoes.com.br</a></p>
</td>
<td class=\"expander\"></td>
</tr>
</table>
</td>
</tr>
</table>
<table class=\"row\">
<tr>
<td class=\"wrapper last\">
<table class=\"twelve columns\">
<tr>
<td align=\"center\">
<center>

</center>
<table>
<tr> 
<td class=\"panel\">
<p> <h6> MISSÕES MAIS PERTO DE VOCE         .</h6> <BR>
 <h5> NÃO VAMOS DIMINUIR O RITMO </H5>
</p>
</td></tr>
</table>
</td>
<td class=\"expander\"></td>
</tr>
</table>
</td>
</tr>
</table>
 
</td>
</tr>
</table>
</center>
</td>
</tr>
</table>
</body>
</html>


" );




require_once('classes/DB.php');

################

// produção
// define('Cons_Servidor', 	'186.202.152.189', false);
// define('Cons_NomeBanco', 	'avivamissoes22', false);
// define('Cons_UserBD', 		'avivamissoes22', false);
// define('Cons_SenhaBD', 		'Aviva@Missoes', false);

define('Cons_Servidor', 	'localhost:3306', false);
define('Cons_NomeBanco', 	'avivamissoes22', false);
define('Cons_UserBD', 		'root', false);
define('Cons_SenhaBD', 		'', false);


$GLOBALS['config'] = array(
'meulocal' => array(
'host' => 'localhost:3306',
'username' => 'root',
'password' => '',
'db' => 'avivamissoes22',
),
'producao' => array(
'host' => '186.202.152.189',
'username' => 'avivamissoes22',
'password' => 'Aviva@Missoes',
'db' => 'Aviva@Missoes',
),);


$db2 = DB::getDB(['meulocal','init']);

$db = DB::getInstance();


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
    $mail->From 	= "financeiro@avivamissoes.com.br"; // Seu e-mail
    $mail->Sender 	= "financeiro@avivamissoes.com.br"; // Seu e-mail
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





#****************************************
#########################################
# CONFIRMAÇÃO DE BOLETO
#########################################
#funcao de envio de emails especifico pela locaweb
function funcEnviaConfirmacaoBoleto_ver02($maildestinatario, $nomeDestinatario, $valor, $data){

// Inicia a classe PHPMailer
    $mail = new PHPMailer(true);
// Define os dados do servidor e tipo de conexão
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //$mail->IsSMTP(); // Define que a mensagem será SMTP
	$mail->Host = "ssl://smtp.avivamissoes.com.br"; // Endereço do servidor SMTP (caso queira utilizar a autenticação, utilize o host smtp.seudomínio.com.br)
	$mail->Port = 587;
    $mail->SMTPAuth = true; // Usar autenticação SMTP (obrigatório para smtp.seudomínio.com.br)
    $mail->Username = 'contato@avivamissoes.com.br'; // Usuário do servidor SMTP (endereço de email)
    $mail->Password = 'Aviva2014'; // Senha do servidor SMTP (senha do email usado)
    //$mail->SMTPDebug = 1;

// Define o remetente
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->setFrom 	= "contato@avivamissoes.com.br"; // Seu e-mail
    $mail->AddReplyTo 	= "contato@avivamissoes.com.br"; // Seu e-mail
    $mail->FromName = "IEAB - Diretoria Geral de Evangelismo e Missões "; // Seu nome
  

  	$mail->SMTPSecure = 'ssl';   
	// Define os destinatário(s)
	// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    //$mail->AddAddress($maildestinatario);
    $mail->AddAddress('ivinsons@gmail.com');
	//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
	$mail->AddBCC('adm@avivamissoes.com.br', 'Administração DGEM '); // Cópia Oculta
	$mail->AddBCC('ivinsons@gmail.com', 'Administração DGEM '); // Cópia Oculta

// Define os dados técnicos da Mensagem
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $mail->IsHTML(true); 
// Define a mensagem (Texto e Assunto)
// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
    $assunto  = '=?UTF-8?B?'.base64_encode("Confirmação de boleto bancário - Remessa {$data}").'?=';
    //$mensagem = "<img src='http://avivamissoes.com.br/wp-content/uploads/2014/03/Logo300x100.png'>". utf8_decode("<h1>Olá amado pastor, do campo de {$nomeDestinatario}</h1>");

    $mensagem = V_EMAIL_TEMPLATE;  
    $mensagem = str_replace("#NOME#", $nomeDestinatario, $mensagem);
    $mensagem = str_replace("#Texto1#", "Queremos agradecer o seu empenho e dedicação, alem do 
    									coração disposto servindo em missões, contribuindo e ensinando a igreja a importância e o 
    									privilégio de sermos bons mordomos daquilo que Deus tem nos confiado!", $mensagem);
    $mensagem = str_replace("#Texto2#", 
    									"Esse email é para confirmar o recebimento da remessa 
    									referente a {$data}, no valor de R$ {$valor} reais, feita por boleto bancário."
    									    , $mensagem);
    $mensagem = str_replace("#RodapeAzul#", 
    							"<b>Confirmamos o repasse referente a {$data}, no valor de R$ {$valor} reais.</b><br>
    							<br>
    							Deem e será dado a vocês: uma boa medida, calcada, 
    							sacudida e transbordante será dada a vocês. Pois a medida que
    							 usarem também será usada para medir vocês.<br>
								Lucas 6:38 ", 

    							$mensagem);


    $mail->Subject  = $assunto; // Assunto da mensagem
    $mail->Body = utf8_decode($mensagem);

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
echo "E-mail enviado com sucesso!";
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