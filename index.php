<?php session_start();

if ($_SESSION['logado'] <> "S") {
    //header("login.php");
    echo "<script language='JavaScript' type='text/JavaScript'> 
            <!--
                window.location='login.php';
            //-->
            </script>";
    //echo "teste LOGADO " . $_SESSION['logado'];
}
include("header.php");
include("config.php");
include('scripts/functions.php');
?>
<div id="page-wrapper">
    <div class="container-fluid color-custom">
        <!-- TITULO e cabeçalho das paginas  -->
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3> ESTATISTICAS<br><br>
                        <small>Visão Geral de Entradas</small>
                    </h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class='breadcrumb-header'>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Estatisticas</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- /.row -->
        <div class="cards mb-5">
            <div class="parent">
                <div class="conta card-custom">
                    <div class="conta content-box box1">
                        <?php
                            $rowEmitidos = $db->query("select  count(lb.id) as total from lancamentosbancarios lb where lb.TipoOrigem = 'CR' ")->results()[0];
                        ?>
                        <span class="conta card-custom-title">Boletos Recebidos</span>
                        <div class="conta card-content">
                            <a data-href="contas-a-receber.php" style="cursor: pointer;" onclick="verDetalhes(this)">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalhes ></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="date-box">
                        <span class="month"><?= $rowEmitidos->total ? $rowEmitidos->total : "0"; ?></span>
                    </div>
                </div>
            </div>

            <div class="parent">
                <div class="conta card-custom">
                    <div class="conta content-box box2">
                        <?php
                        $rowEmitidos = $db->query("select  count(distinct lb.idUsuario) as total from lancamentosbancarios lb where lb.TipoOrigem = 'CR' ")->results()[0];
                        ?>
                        <span class="conta card-custom-title">Usam o Sistema</span>
                        <div class="conta card-content">
                            <a data-href="contas-a-receber.php" style="cursor: pointer;" onclick="verDetalhes(this)">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalhes ></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="date-box">
                        <span class="month"><?= $rowEmitidos->total ? $rowEmitidos->total : "0"; ?></span>
                    </div>
                </div>
            </div>

            <div class="parent">
                <div class="conta card-custom">
                    <div class="conta content-box box3">
                        <?php

                        $rowCampos = $db->query("SELECT count(*) as total  FROM campos ;")->results()[0];
                        echo $rowCampos->total;

                                    ?>
                                <span class="conta card-custom-title">Qtd de Campos</span>
                                <div class="conta card-content">
                                    <a href="listar-usuarios.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Ver Detalhes ></span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="date-box">
                                <span class="month"><?=$rowCampos->total ? $rowCampos->total: "0";?></span>
                            </div>
                        </div>
                    </div>

            <div class="parent">
                <div class="conta card-custom">
                    <div class="conta content-box box4">
                        <?php

                        $rowOptionInad = $db->query("

                                                    SELECT  count(*) as meses FROM
                                                        lancamentosbancarios LB
                                                        join usuarios u on (u.id = LB.idUsuario)
                                                            join congregacoes gr on (gr.id = u.idCongregacao)
                                                                join campos c on (c.id = gr.idCampo)
                                                                where
                                                                LB.Valor = 0 and LB.TipoLancamento in ('Regular','Inadimplente','')    
                                                                and month(LB.DataReferencia) >= 06
                                                                                                            and year(LB.DataReferencia)  >= 2012           
                                                                group by u.id,u.Nome                
                                                                order by count(u.id) desc ;
                                                         
                                                    ")->results(true);

                        $totalIndimplentes = 0;
                        foreach ($rowOptionInad as $rsInad) {
                            foreach ($rsInad as $key => $value) {
                                $rsInad[$key] = stripslashes($value);
                            }

                            if ((int)$rsInad["meses"] >= 6) {
                                $totalIndimplentes = $totalIndimplentes + 1;
                            }
                        }


                        ?>
                        <span class="conta card-custom-title">Inadimplentes</span>
                        <div class="conta card-content">
                            <a data-href="inadimplentes.php" style="cursor: pointer;" onclick="verDetalhes(this)">
                                <div class="panel-footer">
                                    <span class="pull-left">Ver Detalhes ></span>
                                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                    <div class="clearfix"></div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="date-box">
                        <span class="month"><?= $totalIndimplentes ? $totalIndimplentes : "0"; ?></span>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i>
                            Indice de inadimplencia por Região</h3>
                    </div>
                    <div class="panel-body">

                        <div>
                            <canvas id="myChart"></canvas>
                        </div>

                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

                        <?php


                        # chama view de contagem de campos
                        $rsInad = $db->query("SELECT Regiao, count(*) as total FROM Inadimplentes GROUP BY Regiao")->results(true);

                        $labels = [];
                        $data = [];

                        foreach ($rsInad as $rowOptionInad) {
                            $labels[] = trim($rowOptionInad['Regiao']);
                            $data[] = (int)$rowOptionInad['total'];
                        }

                        // Convertendo os arrays PHP para strings JSON
                        $labels_json = json_encode($labels);
                        $data_json = json_encode($data);

                        ?>

                        <script>
                            const ctx = document.getElementById('myChart');

                            new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?= $labels_json ?>,
                                    datasets: [{
                                        label: 'Inadimplentes por regiões',
                                        data: <?= $data_json ?>,
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true
                                        }
                                    }
                                }
                            });
                        </script>

                        <!-- HTML
                            <div id="legendPlaceholder"></div>
                            <div id="flotcontainer"></div> -->

                        <div class="text-right">
                            <a data-href="inadimplentes.php" onclick="verDetalhes(this)" style="cursor: pointer;">Ver Detalhes <i class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i>
                            Maiores contribuintes TOP 10 </h3>
                        <div class="panel-body">
                            <!-- HTML -->


                            <?php

                            $rsCamposPagadores = $db->query("
                                                select u.Nome, FORMAT(SUM(lb.Valor),2)  as Valor
                                                from lancamentosbancarios lb join usuarios u on (u.id = lb.idUsuario)
                                                group by u.id  order by SUM(lb.Valor) desc
                                                limit 10
                                                ")->results(true);

                            foreach ($rsCamposPagadores as $rowCamposPagadores) {
                                foreach ($rowCamposPagadores as $key => $value) {
                                    $rowCamposPagadores[$key] = stripslashes($value);
                                }


                                echo "                                                

                                                    <a href='#' class='list-group-item'>
                                                        <span style='color:#2f4858' class='badge badge-gold'>R$ {$rowCamposPagadores['Valor']}</span>
                                                        <i class='fa fa-fw fa-user'></i> {$rowCamposPagadores['Nome']}
                                                    </a>";
                            }

                            ?>


                        </div>
                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">

            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title" style="color: #43aa8b;"><i class="fa fa-long-arrow-right fa-fw"></i>
                            Campos que utilizam boletos </h3>
                        <div class="registros-container panel-body" data-action="com_boleto">
                            <!-- HTML -->
                        </div>

                        <div class="text-center mt-5">
                            <button class="btn-carregar-mais btn btn-primary" style="background-color: #43aa8b; border:1px solid White" data-url="inc_com_boletos.php" data-action="com_boleto">Carregar tudo</button>
                        </div>

                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-6">
                <div class="panel panel-info ">
                    <div class="panel-heading">
                        <h2 class="panel-title" style="color: #f94144;"><i class="fa fa-long-arrow-right fa-fw"></i>
                            Não usam boletos
                        </h2>
                        <div class="registros-container panel-body" data-action="sem_boleto" style="background-color: #F04E4E !important;">
                            <!-- HTML -->

                        </div>

                        <div class="text-center mt-5">
                            <button class="btn-carregar-mais btn btn-primary" style="background-color: #f94144; border:1px solid White" data-url="inc_sem_boletos.php" data-action="sem_boleto">Carregar tudo</button>
                        </div>

                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->



    <?php
    include("footer.php");
    ?>
    <script src="js/plugins/morris/morris.min.js"></script>
<script>
    $(document).ready(function() {
        var limit = 5; // Número inicial de registros a serem carregados por vez
        var todosCarregados = false; // Flag para controlar se todos os registros já foram carregados

            // Função para carregar os registros
            function carregarRegistros(url, action) {
                $.ajax({
                    url: url,
                    method: 'GET',
                    data: {
                        limit: todosCarregados ? 'all' : limit,
                        action: action // Passando a ação desejada como parâmetro
                    },
                    success: function(response) {
                        $('.registros-container[data-action="' + action + '"]').html(response); // Substitui o conteúdo atual pelo novo conteúdo na div correspondente à ação
                        $('.btn-carregar-mais[data-action="' + action + '"]').toggle(!todosCarregados); // Oculta o botão se todos os registros já foram carregados
                    },
                    error: function() {
                        alert('Erro ao carregar registros.');
                    }
                });
            }

            // Carregar os primeiros registros assim que a página carregar
            $('.btn-carregar-mais').each(function() {
                var url = $(this).data('url');
                var action = $(this).data('action');
                carregarRegistros(url, action); // Carrega registros para cada estrutura
            });

            // Evento de clique no botão "Carregar Mais"
            $('.btn-carregar-mais').click(function() {
                var url = $(this).data('url');
                var action = $(this).data('action');
                todosCarregados = true; // Define que todos os registros serão carregados
                carregarRegistros(url, action); // Carrega todos os registros
            });
        });

        function verDetalhes(elemento) {
            let urlDefinida = $(elemento).attr("data-href");

            Swal.fire({
                title: 'Informação!',
                text: 'Aguarde, processando dados.',
                icon: 'info',
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
            });

            $.ajax({
                url: urlDefinida, // Aqui você pode usar a mesma URL definida para a ação do formulário
                method: "POST", // Método de envio do formulário
                success: function(Dados) {
                    swal.close();
                    $('.ConteudoGeral').html(Dados);
                    return false;
                },
                error: function(xhr, status, error) {
                    $('.ConteudoGeral').html('Erro ao carregar página');
                }
            });
        }
    </script>