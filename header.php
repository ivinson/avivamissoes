<?php

header('Content-Type: text/html; charset=utf-8');

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>AvivaFinanças - Sistema de apoio financeiro DGEM </title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- implementacao de datatables e choosen select  -->
    <link href="css/jquery.dataTables.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="js/plugins/chosen/chosen.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

<style> 

.scrollable-menu {
    height: auto;
    max-height: 200px;
    overflow-x: hidden;
}



@import url(http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700);
/* written by riliwan balogun http://www.facebook.com/riliwan.rabo*/
.board{
    width: 90%;
margin: 0px auto;
height:  auto;
background: #fff;
/*box-shadow: 10px 10px #ccc,-10px 20px #ddd;*/
}
.board .nav-tabs {
    position: relative;
    /* border-bottom: 0; */
    /* width: 80%; */
    margin: 40px auto;
    margin-bottom: 0;
    box-sizing: border-box;

}

.board > div.board-inner{
    background: #fafafa url(http://subtlepatterns.com/patterns/geometry2.png);
    background-size: 30%;
}

p.narrow{
    width: 60%;
    margin: 10px auto;
}

.liner{
    height: 2px;
    background: #ddd;
    position: absolute;
    width: 80%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
}

.nav-tabs > li.active > a, .nav-tabs > li.active > a:hover, .nav-tabs > li.active > a:focus {
    color: #555555;
    cursor: default;
    /* background-color: #ffffff; */
    border: 0;
    border-bottom-color: transparent;
}

span.round-tabs{
    width: 70px;
    height: 70px;
    line-height: 70px;
    display: inline-block;
    border-radius: 100px;
    background: white;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}

span.round-tabs.one{
    color: rgb(34, 194, 34);border: 2px solid rgb(34, 194, 34);
}

li.active span.round-tabs.one{
    background: #fff !important;
    border: 2px solid #ddd;
    color: rgb(34, 194, 34);
}

span.round-tabs.two{
    color: #febe29;border: 2px solid #febe29;
}

li.active span.round-tabs.two{
    background: #fff !important;
    border: 2px solid #ddd;
    color: #febe29;
}

span.round-tabs.three{
    color: #3e5e9a;border: 2px solid #3e5e9a;
}

li.active span.round-tabs.three{
    background: #fff !important;
    border: 2px solid #ddd;
    color: #3e5e9a;
}

span.round-tabs.four{
    color: #f1685e;border: 2px solid #f1685e;
}

li.active span.round-tabs.four{
    background: #fff !important;
    border: 2px solid #ddd;
    color: #f1685e;
}

span.round-tabs.five{
    color: #999;border: 2px solid #999;
}

li.active span.round-tabs.five{
    background: #fff !important;
    border: 2px solid #ddd;
    color: #999;
}

.nav-tabs > li.active > a span.round-tabs{
    background: #fafafa;
}
.nav-tabs > li {
    width: 20%;
}
/*li.active:before {
    content: " ";
    position: absolute;
    left: 45%;
    opacity:0;
    margin: 0 auto;
    bottom: -2px;
    border: 10px solid transparent;
    border-bottom-color: #fff;
    z-index: 1;
    transition:0.2s ease-in-out;
}*/
.nav-tabs > li:after {
    content: " ";
    position: absolute;
    left: 45%;
   opacity:0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #ddd;
    transition:0.1s ease-in-out;
    
}
.nav-tabs > li.active:after {
    content: " ";
    position: absolute;
    left: 45%;
   opacity:1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #ddd;
    
}
.nav-tabs > li a{
   width: 70px;
   height: 70px;
   margin: 20px auto;
   border-radius: 100%;
   padding: 0;
}

.nav-tabs > li a:hover{
    background: transparent;
}

.tab-content{
}
.tab-pane{
   position: relative;
padding-top: 50px;
}
.tab-content .head{
    font-family: 'Roboto Condensed', sans-serif;
    font-size: 25px;
    text-transform: uppercase;
    padding-bottom: 10px;
}
.btn-outline-rounded{
    padding: 10px 40px;
    margin: 20px 0;
    border: 2px solid transparent;
    border-radius: 25px;
}

.btn.green{
    background-color:#5cb85c;
    /*border: 2px solid #5cb85c;*/
    color: #ffffff;
}



@media( max-width : 585px ){
    
    .board {
width: 90%;
height:auto !important;
}
    span.round-tabs {
        font-size:16px;
width: 50px;
height: 50px;
line-height: 50px;
    }
    .tab-content .head{
        font-size:20px;
        }
    .nav-tabs > li a {
width: 50px;
height: 50px;
line-height:50px;
}

.nav-tabs > li.active:after {
content: " ";
position: absolute;
left: 35%;
}

.btn-outline-rounded {
    padding:12px 20px;
    }
}


.label { border-radius: 0; text-shadow: none; font-size: 11px; font-weight: normal; padding: 3px 5px 3px; background-color: #abbac3!important }
.label[class*="span"][class*="arrow"] { min-height: 0 }
.badge {text-shadow: none;
font-size: 12px;
padding: 1px 15px;
font-weight: normal;
line-height: 15px;
background-color: #ABBAC3!important; }
.label-transparent,
.badge-transparent { background-color: transparent!important }
.label-grey,
.badge-grey { background-color: #a0a0a0!important }
.label-info,
.badge-info { background-color: #3a87ad!important }
.label-primary,
.badge-primary { background-color: #2283c5!important }
.label-success,
.badge-success { background-color: #82af6f!important }
.label-important,
.badge-important { background-color: #d15b47!important }
.label-inverse,
.badge-inverse { background-color: #333!important }
.label-warning,
.badge-warning { background-color: #f89406!important }
.label-pink,
.badge-pink { background-color: #d6487e!important }
.label-purple,
.badge-purple { background-color: #9585bf!important }
.label-yellow,
.badge-yellow { background-color: #fee188!important }
.label-light,
.badge-light { background-color: #e7e7e7!important }
.badge-yellow,
.label-yellow { color: #963!important; border-color: #fee188 }
.badge-light,
.label-light { color: #888!important }
.label.arrowed,
.label.arrowed-in { position: relative; margin-left: 9px }
.label.arrowed:before,
.label.arrowed-in:before { display: inline-block; content: ""; position: absolute; left: -14px; top: 0; border: 9px solid transparent; border-width: 9px 7px; border-right-color: #abbac3 }
.label.arrowed-in:before { border-color: #abbac3; border-left-color: transparent!important; left: -9px }
.label.arrowed-right,
.label.arrowed-in-right { position: relative; margin-right: 9px }
.label.arrowed-right:after,
.label.arrowed-in-right:after { display: inline-block; content: ""; position: absolute; right: -14px; top: 0; border: 9px solid transparent; border-width: 9px 7px; border-left-color: #abbac3 }
.label.arrowed-in-right:after { border-color: #abbac3; border-right-color: transparent!important; right: -9px }
.label-info.arrowed:before { border-right-color: #3a87ad }
.label-info.arrowed-in:before { border-color: #3a87ad }
.label-info.arrowed-right:after { border-left-color: #3a87ad }
.label-info.arrowed-in-right:after { border-color: #3a87ad }
.label-primary.arrowed:before { border-right-color: #2283c5 }
.label-primary.arrowed-in:before { border-color: #2283c5 }
.label-primary.arrowed-right:after { border-left-color: #2283c5 }
.label-primary.arrowed-in-right:after { border-color: #2283c5 }
.label-success.arrowed:before { border-right-color: #82af6f }
.label-success.arrowed-in:before { border-color: #82af6f }
.label-success.arrowed-right:after { border-left-color: #82af6f }
.label-success.arrowed-in-right:after { border-color: #82af6f }
.label-warning.arrowed:before { border-right-color: #f89406 }
.label-warning.arrowed-in:before { border-color: #f89406 }
.label-warning.arrowed-right:after { border-left-color: #f89406 }
.label-warning.arrowed-in-right:after { border-color: #f89406 }
.label-important.arrowed:before { border-right-color: #d15b47 }
.label-important.arrowed-in:before { border-color: #d15b47 }
.label-important.arrowed-right:after { border-left-color: #d15b47 }
.label-important.arrowed-in-right:after { border-color: #d15b47 }
.label-inverse.arrowed:before { border-right-color: #333 }
.label-inverse.arrowed-in:before { border-color: #333 }
.label-inverse.arrowed-right:after { border-left-color: #333 }
.label-inverse.arrowed-in-right:after { border-color: #333 }
.label-pink.arrowed:before { border-right-color: #d6487e }
.label-pink.arrowed-in:before { border-color: #d6487e }
.label-pink.arrowed-right:after { border-left-color: #d6487e }
.label-pink.arrowed-in-right:after { border-color: #d6487e }
.label-purple.arrowed:before { border-right-color: #9585bf }
.label-purple.arrowed-in:before { border-color: #9585bf }
.label-purple.arrowed-right:after { border-left-color: #9585bf }
.label-purple.arrowed-in-right:after { border-color: #9585bf }
.label-yellow.arrowed:before { border-right-color: #fee188 }
.label-yellow.arrowed-in:before { border-color: #fee188 }
.label-yellow.arrowed-right:after { border-left-color: #fee188 }
.label-yellow.arrowed-in-right:after { border-color: #fee188 }
.label-light.arrowed:before { border-right-color: #e7e7e7 }
.label-light.arrowed-in:before { border-color: #e7e7e7 }
.label-light.arrowed-right:after { border-left-color: #e7e7e7 }
.label-light.arrowed-in-right:after { border-color: #e7e7e7 }
.label-grey.arrowed:before { border-right-color: #a0a0a0 }
.label-grey.arrowed-in:before { border-color: #a0a0a0 }
.label-grey.arrowed-right:after { border-left-color: #a0a0a0 }
.label-grey.arrowed-in-right:after { border-color: #a0a0a0 }
.label-large { font-size: 13px; padding: 3px 8px 4px }
.label-large.arrowed,
.label-large.arrowed-in { margin-left: 12px }
.label-large.arrowed:before,
.label-large.arrowed-in:before { left: -16px; border-width: 11px 8px }
.label-large.arrowed-in:before { left: -12px }
.label-large.arrowed-right,
.label-large.arrowed-in-right { margin-right: 11px }
.label-large.arrowed-right:after,
.label-large.arrowed-in-right:after { right: -16px; border-width: 11px 8px }
.label-large.arrowed-in-right:after { right: -12px }



.message-item {
margin-bottom: 25px;
margin-left: 40px;
position: relative;
}
.message-item .message-inner {
background: #fff;
border: 1px solid #ddd;
border-radius: 3px;
padding: 10px;
position: relative;
}
.message-item .message-inner:before {
border-right: 10px solid #ddd;
border-style: solid;
border-width: 10px;
color: rgba(0,0,0,0);
content: "";
display: block;
height: 0;
position: absolute;
left: -20px;
top: 6px;
width: 0;
}
.message-item .message-inner:after {
border-right: 10px solid #fff;
border-style: solid;
border-width: 10px;
color: rgba(0,0,0,0);
content: "";
display: block;
height: 0;
position: absolute;
left: -18px;
top: 6px;
width: 0;
}
.message-item:before {
background: #fff;
border-radius: 2px;
bottom: -30px;
box-shadow: 0 0 3px rgba(0,0,0,0.2);
content: "";
height: 100%;
left: -30px;
position: absolute;
width: 3px;
}
.message-item:after {
background: #fff;
border: 2px solid #ccc;
border-radius: 50%;
box-shadow: 0 0 5px rgba(0,0,0,0.1);
content: "";
height: 15px;
left: -36px;
position: absolute;
top: 10px;
width: 15px;
}
.clearfix:before, .clearfix:after {
content: " ";
display: table;
}
.message-item .message-head {
border-bottom: 1px solid #eee;
margin-bottom: 8px;
padding-bottom: 8px;
}
.message-item .message-head .avatar {
margin-right: 20px;
}
.message-item .message-head .user-detail {
overflow: hidden;
}
.message-item .message-head .user-detail h5 {
font-size: 25px;
font-weight: bold;
margin: 0;
}
.message-item .message-head .post-meta {
float: left;
padding: 0 15px 0 0;
}
.message-item .message-head .post-meta >div {
color: #333;
font-weight: bold;
text-align: right;
}
.post-meta > div {
color: #777;
font-size: 12px;
line-height: 22px;
}
.message-item .message-head .post-meta >div {
color: #333;
font-weight: bold;
text-align: right;
}
.post-meta > div {
color: #777;
font-size: 12px;
line-height: 22px;
}
img {
 min-height: 40px;
 max-height: 40px;
}


</style>



</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand" href="index.html"><img src="http://app.avivamissoes.com.br/logo.png" alt="Aviva Missoes" width="120" height="30"></a>
            </div>
            <!-- Top Menu Items -->
            <ul class="nav navbar-right top-nav">
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i>Olá, <?php  echo $_SESSION['nome']; ?> <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="http://webmail.avivamissoes.com.br"><i class="fa fa-fw fa-envelope"></i> Acessar WebMail</a>
                        </li>
                        <li class="divider"></li>
                       <li>
                            <a href="logout.php"><i class="fa fa-fw fa-power-off"></i> Sair </a>
                        </li>
                    </ul>
                </li>

 
            </ul>
            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
            <div class="collapse navbar-collapse navbar-ex1-collapse scrollable-menu">
                <ul class="nav navbar-nav side-nav">

                    <li>
                        <a href="index.php"><i class="fa fa-fw fa-dashboard fa-3x"></i> Estatisticas</a>
                    </li>
                    
                    <li class="active">
                        <a href="relatorios-gerais.php"><i class="fa fa-fw fa-users fa-2x"></i> Relatórios</a>
                    </li>
  
                    <li class="active">
                        <a href="listar-usuarios.php"><i class="fa fa-fw fa-users fa-2x"></i> Campos</a>
                    </li>
                    <li>
                        <a href="javascript:;" data-toggle="collapse" data-target="#BoletoDRP">
                            <i class="fa fa-fw fa-heart-o fa-2x "></i> Ofertas Pastorais  <i class="fa fa-fw fa-caret-down"></i></a>
                        <ul id="BoletoDRP" class="collapse">
                            <li>
                                <a href="listar-extrato.php">Identificar ofertas</a>
                            </li>

                            <li>
                                <a href="contas-a-receber.php">Boletos Emitidos</a>
                            </li>
                     
                             <!--<li>
                                <a href="emitir-boleto-lote.php">Emitir boletos em Lote</a> 
                            </li>-->
                            <li>
                                <a href="processar-recebimentos.php">Processar Retorno</a>
                            </li> 

                            <li>
                                <a href="processar-remessas.php">Arq. de Remessa</a>
                            </li>                                 
                        

                    

                            <li>
                                <a href="nova-entrada-direta.php">Entradas Diretas </a>
                            </li>


                        </ul>
                    </li>
          
          <!--
                    <li class="active">
                        <a href="contas-a-pagar.php"><i class="fa fa-fw fa-file"></i> Contas a Pagar</a>
                    </li>

                -->
                    <li class="active">
                        <a href="lancamentos-bancarios.php"><i class="fa fa-fw fa-money fa-2x"></i> Movimento Bancário</a>
                    </li>
                     

<!--
                    <li class="active">
                        <a href="metas.php"><i class="fa fa-fw fa-gear"></i> Metas</a>
                    </li>
    -->                

                    <li class="active">
                        <a href="contatos.php"><i class="fa fa-fw fa-comments-o fa-2x"></i> Lista de Contatos</a>
                    </li>  
                    <li class="active">
                        <a href="utils.php"><i class="fa fa-cog fa-spin fa-2x fa-fw"></i> Ferramentas </a>
                    </li>                  

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">