<?php

session_start();

// // //if(isset($_SESSION['logado'])){
//     echo "teste LOGADO : " . $_SESSION['logado'];
// echo "inside";

// die();

if ($_SESSION['logado'] <> "S") {
    //header("login.php");
    echo "<script language='JavaScript' type='text/JavaScript'> 
            <!--
                window.location='login.php';
            //-->
            </script>";
    //echo "teste LOGADO " . $_SESSION['logado'];
}
//}
?>

<?php
include("header.php");
include("config.php");
include('scripts/functions.php');

?>

<style>
    #flotcontainer {
        width: 400px;
        height: 400px;
        text-align: right;
    }
</style>

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h2 class="page-header">
                    ESTATISTICAS <small>Visão Geral de Entradas</small>
                </h2>

            </div>
        </div>
        <!-- /.row -->

        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-usd fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                    <?php

                                    $rowBaixados = mysql_fetch_array(mysql_query("SELECT count(*) as total  FROM contasreceber WHERE DataBaixa is not null;"));
                                    echo $rowBaixados['total'];

                                    ?>

                                </div>
                                <div>Boletos Recebidos</div>
                            </div>
                        </div>
                    </div>
                    <a href="contas-a-receber.php">
                        <div class="panel-footer">
                            <span class="pull-left">Ver detalhes</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                    <?php

                                    $rowEmitidos = mysql_fetch_array(mysql_query("select  count(distinct lb.idUsuario) as total from lancamentosbancarios lb where lb.TipoOrigem = 'CR' "));
                                    echo $rowEmitidos['total'];

                                    ?>

                                </div>
                                <div>Usam o Sistema</div>
                            </div>
                        </div>
                    </div>
                    <a href="contas-a-receber.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-users fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">
                                    <?php

                                    $rowCampos = mysql_fetch_array(mysql_query("SELECT count(*) as total  FROM campos ;"));
                                    echo $rowCampos['total'];

                                    ?>


                                </div>
                                <div>Qtd de Campos</div>
                            </div>
                        </div>
                    </div>
                    <a href="listar-usuarios.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-support fa-5x"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge">

                                    <?php

                                    $rsInad = mysql_query("

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
                                                         
                                                    ");


                                    $totalIndimplentes = 0;
                                    while ($rowOptionInad = mysql_fetch_array($rsInad)) {
                                        foreach ($rowOptionInad as $key => $value) {
                                            $rowOptionInad[$key] = stripslashes($value);
                                        }

                                        if ((int)$rowOptionInad["meses"] >= 6) {
                                            $totalIndimplentes = $totalIndimplentes + 1;
                                        }
                                    }
                                    echo $totalIndimplentes;


                                    ?>




                                </div>
                                <div>Inadimplentes</div>
                            </div>
                        </div>
                    </div>
                    <a href="inadimplentes.php">
                        <div class="panel-footer">
                            <span class="pull-left">View Details</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <!-- /.row -->



        <!-- /.row -->

        <div class="row">
            <div class="col-lg-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i>
                            Indice de inadimplencia por Região</h3>
                    </div>
                    <div class="panel-body">
                        <!-- HTML -->
                        <div id="legendPlaceholder"></div>
                        <div id="flotcontainer"></div>

                        <div class="text-right">
                            <a href="inadimplentes.php">View Details <i class="fa fa-arrow-circle-right"></i></a>
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

                            $rsCamposPagadores = mysql_query("
                                            select u.Nome, FORMAT(SUM(lb.Valor),2)  as Valor
                                            from lancamentosbancarios lb join usuarios u on (u.id = lb.idUsuario)
                                            group by u.id  order by SUM(lb.Valor) desc
                                            limit 10
                                            ");

                            while ($rowCamposPagadores = mysql_fetch_array($rsCamposPagadores)) {
                                foreach ($rowCamposPagadores as $key => $value) {
                                    $rowCamposPagadores[$key] = stripslashes($value);
                                }


                                echo "                                                

                                                <a href='#' class='list-group-item'>
                                                    <span class='label label-success'>R$ {$rowCamposPagadores['Valor']}</span>
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

        <div class="row">

            <div class="col-lg-6">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i>
                            Campos que utilizam boletos </h3>
                        <div class="panel-body">
                            <!-- HTML -->


                            <?php

                            $rsCamposPagadores = mysql_query("
                                            select  
                                            u.Nome,
                                            lb.idUsuario,
                                            count( lb.idUsuario) as total 
                                            from 

                                            lancamentosbancarios lb join usuarios u on(u.id = lb.idUsuario)

                                            where lb.TipoOrigem = 'CR' 
                                            group by u.Nome,lb.idUsuario
                                            order by total desc
                                            
                                            ");

                            while ($rowCamposPagadores = mysql_fetch_array($rsCamposPagadores)) {
                                foreach ($rowCamposPagadores as $key => $value) {
                                    $rowCamposPagadores[$key] = stripslashes($value);
                                }


                                echo "                                                

                                                  <a href='follow-up.php?id={$rowCamposPagadores['idUsuario']}' class='list-group-item'>                                                  
                                                    <i class='fa fa-fw fa-user'></i> {$rowCamposPagadores['Nome']}

                                                     <span class='label label-success'> {$rowCamposPagadores['total']}</span>
                                                </a>";
                            }

                            ?>


                        </div>
                        <div class="text-right">

                        </div>
                    </div>
                </div>
            </div>



            <div class="row">

                <div class="col-lg-6">
                    <div class="panel panel-info ">
                        <div class="panel-heading">
                            <h2 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i>
                                NÃO USAM BOLETOS
                            </h2>
                            <div class="panel-body" style="background-color: #F04E4E !important;">
                                <!-- HTML -->
                                <?php

                                $rsCamposPagadores = mysql_query("
                                        select * from usuarios ud 

                                        where ud.id not in (


                                                            select  distinct
                                                            u.id
                                                            from 
                                                            lancamentosbancarios lb join usuarios u on(u.id = lb.idUsuario)
                                                            where lb.TipoOrigem = 'CR'  and ud.id
                                                            
                                                        )
                                            
                                            ");

                                while ($rowCamposPagadores = mysql_fetch_array($rsCamposPagadores)) {
                                    foreach ($rowCamposPagadores as $key => $value) {
                                        $rowCamposPagadores[$key] = stripslashes($value);
                                    }


                                    echo "                                                

                                                <a href='follow-up.php?id={$rowCamposPagadores['id']}' class='list-group-item'>                                                   
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
            <!-- /.row -->


        </div>
        <!-- /.container-fluid -->

    </div>
    <!-- /#page-wrapper -->



    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>



    <?php

    //tOP MAIORES PAGADORES
    $SQL = "select u.Nome, FORMAT(SUM(lb.Valor),2)  as Valor
from lancamentosbancarios lb join usuarios u on (u.id = lb.idUsuario)
group by u.id  order by SUM(lb.Valor) desc";




    # chama view de contagem de campos
    $rsInad = mysql_query(" SELECT Regiao, count(*) as total, id from Inadimplentes group by Regiao");


    $fdata = "    var data = [";
    $fVirgula = "";
    while ($rowOptionInad = mysql_fetch_array($rsInad)) {
        foreach ($rowOptionInad as $key => $value) {
            $rowOptionInad[$key] = stripslashes($value);
        }



        if ($fVirgula != ",") {
            $fdata = $fdata . "{label: '{$rowOptionInad['Regiao']}', data:{$rowOptionInad['total']}, url:'/inadimplentes.php?idregiao={$rowOptionInad['total']}&six=true'}";
            $fVirgula = ",";
        } else {
            $fdata =  $fdata . $fVirgula . "{label: '{$rowOptionInad['Regiao']}', data:{$rowOptionInad['total']}, url:'/inadimplentes.php?idregiao={$rowOptionInad['total']}&six=true'}";
        }
    }
    $fdata = $fdata . "];";


    //echo $fdata;


    //include "logger.php";
    //Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] acessou a pagina principal!");



    ?>

    <!-- Javascript -->
    <script type="text/javascript">
        $("#flotcontainer").bind("plotclick", function(event, pos, item) {
            //alert('click!');
            //for(var i in item){
            //alert('my '+i+' = '+ item[i]);
            //}
        });


        $(function() {
            //Data que vem do php
            <?php echo $fdata; ?>

            var options = {
                series: {
                    pie: {
                        innerRadius: 0.5,
                        show: true
                    }
                },
                legend: {
                    show: false
                },
                grid: {
                    hoverable: true,
                    clickable: true
                },

            };


            $.plot($("#flotcontainer"), data, options);
        });
    </script>