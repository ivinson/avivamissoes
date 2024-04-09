<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>AvivaFinanças - Sistema de apoio financeiro DGEM </title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" ></script>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <!-- Custom Fonts -->
        <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="js/plugins/chosen/chosen.css">
        <!-- Morris Charts CSS -->
        <link href="css/plugins/morris.css" rel="stylesheet">
        
    </head>
    <body class="sb-nav-fixed">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-secondary">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php"></i><img src="http://app.avivamissoes.com.br/logo.png" alt="Aviva Missoes" width="120" height="30"> <b class="caret"></b></a>
            <!-- Sidebar Toggle-->
            <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
            <!-- Navbar Search-->
            <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
                <div class="input-group">
                </div>
            </form>
            <!-- Navbar-->
            <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i style="color: #000;" class="fas fa-user fa-fw"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="http://webmail.avivamissoes.com.br"><i class="fa fa-fw fa-envelope"></i> Acessar WebMail</a></li>
                        <li><a class="dropdown-item" href="logout.php"><i class="fa fa-fw fa-power-off"></i> Sair </a></li>
                    </ul>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion bg-secondary bg-gradient" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link text-light" href="index.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Estatisticas
                            </a>

                            <a class="nav-link text-light" href="relatorios-gerais.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Relatórios
                            </a>

                            <a class="nav-link text-light" href="listar-usuarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Campos
                            </a>

                            <a class="nav-link collapsed text-light" href="javascript:;" data-bs-toggle="collapse" data-bs-target="#BoletoDRP" aria-expanded="false" aria-controls="BoletoDRP">
                                <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                                 Ofertas Pastorais
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="BoletoDRP" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link text-light" href="listar-extrato.php">Identificar ofertas</a>
                                    <a class="nav-link text-light" href="contas-a-receber.php">Boletos Emitidos</a>
                                    <a class="nav-link text-light" href="processar-recebimentos.php">Processar Retorno</a>
                                    <a class="nav-link text-light" href="processar-remessas.php">Arq. de Remessa</a>
                                    <a class="nav-link text-light" href="nova-entrada-direta.php">Entradas Diretas</a>
                                </nav>
                            </div>

                            <a class="nav-link text-light" href="lancamentos-bancarios.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Movimento Bancário
                            </a>

                            <a class="nav-link text-light" href="contatos.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Lista de Contatos
                            </a>

                            <a class="nav-link text-light" href="utils.php">
                                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                                Ferramentas
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid px-4">