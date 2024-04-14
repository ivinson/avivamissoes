<?php
if (session_status() === PHP_SESSION_NONE) {
    // A sessão ainda não foi iniciada, então iniciamos a sessão
    session_start();
}
?>
<!DOCTYPE html>
<html lang="pt-Br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AvivaFinanças - Sistema de apoio financeiro DGEM </title>

    <link rel="stylesheet" href="assets/css/bootstrap.css">
    <link rel="stylesheet" href="assets/vendors/chartjs/Chart.min.css">
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/images/favicon.svg" type="image/x-icon">
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
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script src="js/sweetalert.js"></script>
</head>
<body>
    <div id="app">
        <div id="sidebar" class='active'>
            <div class="sidebar-wrapper active">
                <div class="sidebar-header">
                    <a class="navbar-brand" href="index.html"><img src="http://app.avivamissoes.com.br/logo.png" alt="Aviva Missoes" width="120" height="30"></a>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        
                            <li class="sidebar-item">
                                <a href="index.php" class='sidebar-link'>
                                    <i data-feather="home" width="20"></i> 
                                    <span>Estatisticas</span>
                                </a>
                                
                            </li>

                            <li class="sidebar-item ">
                                <a href="relatorios-gerais.php" class='sidebar-link'>
                                    <i data-feather="home" width="20"></i> 
                                    <span>Relatórios</span>
                                </a>
                                
                            </li>
                            <li class="sidebar-item ">
                                <a href="listar-usuarios.php" class='sidebar-link'>
                                    <i data-feather="home" width="20"></i> 
                                    <span>Campos</span>
                                </a>
                                
                            </li>

                        
                            <li class="sidebar-item  has-sub">
                                <a href="relatorios-gerais.php" class='sidebar-link'>
                                    <i data-feather="triangle" width="20"></i> 
                                    <span>Ofertas Pastorais</span>
                                </a>
                                
                                <ul class="submenu ">
                                    
                                    <li>
                                        <a href="listar-extrato.php">Identificar ofertas</a>
                                    </li>
                                    
                                    <li>
                                        <a href="contas-a-receber.php">Boletos Emitidos</a>
                                    </li>
                                    
                                    <li>
                                        <a href="processar-recebimentos.php">Processar Retorno</a>
                                    </li>
                                    
                                    <li>
                                        <a href="processar-remessas.php">Arq. de Remessa</a>
                                    </li>
                                    
                                    <li>
                                        <a href="nova-entrada-direta.php">Entradas Diretas</a>
                                    </li>
                                    
                                </ul>
                                
                            </li>

                            <li class="sidebar-item  ">
                                <a href="lancamentos-bancarios.php" class='sidebar-link'>
                                    <i data-feather="layout" width="20"></i> 
                                    <span>Movimento Bancário</span>
                                </a>
                                
                            </li>

                        
                            <li class="sidebar-item  ">
                                <a href="contatos.php" class='sidebar-link'>
                                    <i data-feather="layout" width="20"></i> 
                                    <span>Lista de Contatos</span>
                                </a>
                                
                            </li>
                        
                            <li class="sidebar-item  ">
                                <a href="utils.php" class='sidebar-link'>
                                    <i data-feather="layers" width="20"></i> 
                                    <span>Ferramentas</span>
                                </a>
                                
                            </li>
                    </ul>
                </div>
                <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
            </div>
        </div>
        <div id="main">
            <nav class="navbar navbar-header navbar-expand navbar-light">
                <a class="sidebar-toggler" href="#"><span class="navbar-toggler-icon"></span></a>
                <button class="btn navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav d-flex align-items-center navbar-light ml-auto">
                        <li class="dropdown">
                            <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <div class="avatar mr-1">
                                    <div style="width: 40px; height:40px; background:gray; border-radius:50%"></div>
                                </div>
                                <div class="d-none d-md-block d-lg-inline-block">Olá, <?php  echo $_SESSION['nome']; ?> </div>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="http://webmail.avivamissoes.com.br"><i data-feather="user"></i> Acessar WebMail</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout.php"><i data-feather="log-out"></i> Sair</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            
            <div class="main-content">
                <div class="container-fluid ConteudoGeral">