<?php

ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', dirname(__FILE__) . '/error_log_ivinson.txt');
error_reporting(E_ALL);
session_start();
include_once('header_login.php');

?>


<?php

if (isset($_POST["submitted"])) {


    require_once('config.php');

    $rsLogin = $db->query("

        select count(*) as total, o.* from operadores o
            where o.user = '{$_POST["inputEmail"]}'
            and o.password = '{$_POST["inputPassword"]}'
        ");


    $data = $db->results()[0];



    if ($data->total == 1) {

        // session_start inicia a sessão

        $_SESSION['login'] = $data->user;
        //$_SESSION['senha'] = $_POST["inputPassword"] ;
        $_SESSION['nome'] = $data->nome;
        $_SESSION['idlogado'] = $data->id;
        $_SESSION['logado'] = "S";

        // include "logger.php";debora ver depois
        // Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] fez o login no sistema.");debora ver depois

        // echo "login autorizado";


    }
    //Caso contrário redireciona para a página de autenticação
    else {

        // include "logger.php";debora ver depois
        // Logger("{$_POST["inputEmail"]} com a senha {$_POST["inputPassword"]} tentou logar no sistema.");debora ver depois


        echo "Nao logado";
        //Destrói
        session_destroy();
        //Limpa
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        //Redireciona para a página de autenticação
        header('location:login.php');
        die();
        // echo "<script language='JavaScript' type='text/JavaScript'> <!--
        // window.location.href='login.php';
        // // //-->
        // // </script>";
    }

    //}
}
?>

<div class="container">
    <div class="card card-container">
        <img id="profile-img" class="profile-img-card" src="am.png" />

        <p id="profile-name" class="profile-name-card"></p>
        <form class="form-signin" method="POST">
            <span id="reauth-email" class="reauth-email"></span>
            <input type="login" name="inputEmail" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
            <input type="password" name="inputPassword" id="inputPassword" class="form-control" placeholder="Password" required>
            <input type="hidden" value="1" name="submitted">
            <button class="btn btn-lg btn-primary btn-block btn-signin" type="button" onclick="logar()">Entrar</button>

        </form>

    </div>
</div>

<script>
    function logar() {

        let formData = $('.form-signin').serialize();


        Swal.fire({
            title: 'Informação!',
            text: 'Aguarde, processando dados.',
            icon: 'info',
            allowEscapeKey: false,
            allowOutsideClick: false,
            showConfirmButton: false,
        });

        $.ajax({
            url: "login.php", // Aqui você pode usar a mesma URL definida para a ação do formulário
            method: "POST", // Método de envio do formulário
            data: formData, // Dados do formulário serializados
            success: function(Dados) {
                window.location.href = 'index.php';
            },
            error: function(xhr, status, error) {
                alert('não ok')
            }
        });
    }
</script>