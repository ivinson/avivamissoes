<?php

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log_ivinson.txt');
error_reporting(E_ALL);

?>

<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

<!-- Optional theme -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap-theme.min.css">


<script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<style type="text/css">
    /*
 * Specific styles of signin component
 */
    /*
 * General styles
 */
    body,
    html {
        height: 100%;
        background-repeat: no-repeat;
        background-color: #6685A3;
    }

    .card-container.card {
        max-width: 350px;
        padding: 40px 40px;
    }

    .btn {
        font-weight: 700;
        height: 36px;
        -moz-user-select: none;
        -webkit-user-select: none;
        user-select: none;
        cursor: default;
    }

    /*
 * Card component
 */
    .card {
        background-color: #F7F7F7;
        /* just in case there no content*/
        padding: 20px 25px 30px;
        margin: 0 auto 25px;
        margin-top: 50px;
        /* shadows and rounded borders */
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        -moz-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        -webkit-box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
        box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.3);
    }

    .profile-img-card {
        width: 96px;
        height: 96px;
        margin: 0 auto 10px;
        display: block;
        -moz-border-radius: 50%;
        -webkit-border-radius: 50%;
        border-radius: 50%;
    }

    /*
 * Form styles
 */
    .profile-name-card {
        font-size: 16px;
        font-weight: bold;
        text-align: center;
        margin: 10px 0 0;
        min-height: 1em;
    }

    .reauth-email {
        display: block;
        color: #404040;
        line-height: 2;
        margin-bottom: 10px;
        font-size: 14px;
        text-align: center;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .form-signin #inputEmail,
    .form-signin #inputPassword {
        direction: ltr;
        height: 44px;
        font-size: 16px;
    }

    .form-signin input[type=email],
    .form-signin input[type=password],
    .form-signin input[type=text],
    .form-signin button {
        width: 100%;
        display: block;
        margin-bottom: 10px;
        z-index: 1;
        position: relative;
        -moz-box-sizing: border-box;
        -webkit-box-sizing: border-box;
        box-sizing: border-box;
    }

    .form-signin .form-control:focus {
        border-color: rgb(104, 145, 162);
        outline: 0;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
    }

    .btn.btn-signin {
        background-color: #4d90fe;
        /*background-color: rgb(104, 145, 162);*/
        /* background-color: linear-gradient(rgb(104, 145, 162), rgb(12, 97, 33));*/
        padding: 0px;
        font-weight: 700;
        font-size: 14px;
        height: 36px;
        -moz-border-radius: 3px;
        -webkit-border-radius: 3px;
        border-radius: 3px;
        border: none;
        -o-transition: all 0.218s;
        -moz-transition: all 0.218s;
        -webkit-transition: all 0.218s;
        transition: all 0.218s;
    }

    .btn.btn-signin:hover,
    .btn.btn-signin:active,
    .btn.btn-signin:focus {
        background-color: rgb(12, 97, 33);
    }

    .forgot-password {
        color: rgb(104, 145, 162);
    }

    .forgot-password:hover,
    .forgot-password:active,
    .forgot-password:focus {
        color: rgb(12, 97, 33);
    }
</style>

<?php

if (isset($_POST["submitted"])) {


    include('config.php');

    $rsLogin = mysql_query("

        select count(*) as total, o.* from operadores o
            where o.user = '{$_POST["inputEmail"]}'
            and o.password = '{$_POST["inputPassword"]}'
        ");


    $data = mysql_fetch_assoc($rsLogin);

    //echo "teste ------ ". $data['total'];



    //if(1==3){

    if ($data['total'] == 1) {
        //if(( $_POST["inputEmail"] == "a@a.com") and ($_POST["inputPassword"] == "123")){
        // session_start inicia a sessão
        session_start();
        $_SESSION['login'] = $data['user'];
        //$_SESSION['senha'] = $_POST["inputPassword"] ;
        $_SESSION['nome'] = $data['nome'];
        $_SESSION['idlogado'] = $data['id'];
        $_SESSION['logado'] = "S";

        include "logger.php";
        Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] fez o login no sistema.");



        //header("login.php");
        echo "<script language='JavaScript' type='text/JavaScript'> <!--
        window.location='index.php';
        //-->
        </script>";

        //header('location:index.php');
        //echo "logado";

    }
    //Caso contrário redireciona para a página de autenticação
    else {

        include "logger.php";
        Logger("{$_POST["inputEmail"]} com a senha {$_POST["inputPassword"]} tentou logar no sistema.");


        echo "Nao logado";
        //Destrói
        session_destroy();
        //Limpa
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        //Redireciona para a página de autenticação
        //header('location:login.php');
        echo "<script language='JavaScript' type='text/JavaScript'> <!--
        window.location='login.php';
        // //-->
        // </script>";
    }

    //}
}
?>


<!--
    you can substitue the span of reauth email for a input with the email and
    include the remember me checkbox
    -->
<div class="container">
    <div class="card card-container">
        <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
        <img id="profile-img" class="profile-img-card" src="am.png" />

        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin" action="login.php" method="POST">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="login" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
            <input type="hidden" value="1" name="submitted">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="submit">Entrar</button>

        </form><!-- /form -->

    </div><!-- /card-container -->
</div><!-- /container -->