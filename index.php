<?php

session_start();


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

        <!-- TITULO e cabeçalho das paginas  -->
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3> ESTATISTICAS<br><br>
                    <small>Visão Geral de Entradas</small></h3>
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

        <style>
/* INICIO ESTILO DO CARD MINHA CONTA */

  .parent {
  width: 200px;
  padding-top: 20px;
}

.card-custom {
  padding-top: 40px;
  /* border-radius: 10px; */
  border: 3px solid rgb(255, 255, 255);
  transform-style: preserve-3d;
  width: 100%;
  height: 150px;
  box-shadow: rgba(142, 142, 142, 0.3) 0px 30px 30px -10px;
  border-radius: 5px;
}

.content-box {
  padding: 20px 25px 25px 25px;
  color: white;
  height: 120px;
}

.content-box.box1 {
    background: rgba(242, 132, 130, 0.732);
}

.content-box.box2 {
    background: rgba(132, 165, 157, 0.732);
}

.content-box.box3 {
    background: rgba(245, 202, 195, 0.732);
}

.content-box.box4 {
    background: rgba(246, 189, 96, 0.732);
}

.content-box .card-custom-title {
  display: inline-block;
  color: white;
  font-size: 18px;
  font-weight: 900;
}



.content-box .card-custom-content, .conta .card-content a  {
  margin-top: 10px;
  font-size: 15px;
  font-weight: 700;
  color: #3e5c76;

}

.conta .card-content a :hover {
  color: #49111c;
}

.date-box {
  position: absolute;
  top: -10px;
  right: 0px;
  height: 60px;
  width: 60px;
  background: white;
  border: 1px solid #e0afa0;
  /* border-radius: 10px; */
  padding: 10px;
  transform: translate3d(0px, 0px, 80px);
  box-shadow: rgba(100, 100, 111, 0.2) 0px 17px 10px -10px;
}

.date-box span {
  display: block;
  text-align: center;
}

.date-box .month {
  color: #e0afa0;
  font-size: 25px;
  font-weight: 700;
}


.date-box .date {
  font-size: 20px;
  font-weight: 900;
  color: #e0afa0;
}
/* FIM ESTILO DO CARD MINHA CONTA */

.cards {
  display: flex;
  flex-direction: row;
  gap: 15px;
  flex-wrap: wrap;
  margin-bottom: 15px;
}

.cards .card .card-content, .card-custom .card-content{
  display: flex;
  justify-content: space-between;
}

@media (max-width: 592px) {
    .parent-child {
      width: 400px;
  }

}

            </style>

            <div class="cards">   

                    <div class="parent">
                        <div class="conta card-custom">
                            <div class="conta content-box box1">
                                <?php

                                    $rowEmitidos = $db->query("select  count(distinct lb.idUsuario) as total from lancamentosbancarios lb where lb.TipoOrigem = 'CR' ")->results(true);                                   

                                    ?>
                                <span class="conta card-custom-title">Boletos Recebidos</span>
                                <div class="conta card-content">
                                    <a href="contas-a-receber.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Ver Detalhes ></span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="date-box">
                                <span class="month"><?=$rowEmitidos->total ? $rowEmitidos->total : "0";?></span>
                            </div>
                        </div>
                    </div>

                    <div class="parent">
                        <div class="conta card-custom">
                            <div class="conta content-box box2">
                                <?php

                                    $rowEmitidos = $db->query("select  count(distinct lb.idUsuario) as total from lancamentosbancarios lb where lb.TipoOrigem = 'CR' ")->results(true);
                                    

                                    ?>
                                <span class="conta card-custom-title">Usam o Sistema</span>
                                <div class="conta card-content">
                                    <a href="contas-a-receber.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Ver Detalhes ></span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="date-box">
                                <span class="month"><?=$rowEmitidos->total ? $rowEmitidos->total: "0";?></span>
                            </div>
                        </div>
                    </div>

                    <div class="parent">
                        <div class="conta card-custom">
                            <div class="conta content-box box3">
                                <?php

                                    $rowCampos = $db->query("SELECT count(*) as total  FROM campos ;")->results(true);
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
                                    <a href="inadimplentes.php">
                                        <div class="panel-footer">
                                            <span class="pull-left">Ver Detalhes ></span>
                                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                                            <div class="clearfix"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="date-box">
                                <span class="month"><?=$totalIndimplentes ? $totalIndimplentes: "0";?></span>
                            </div>
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

                            $rsCamposPagadores = $db->query("
                                            select u.Nome, FORMAT(SUM(lb.Valor),2)  as Valor
                                            from lancamentosbancarios lb join usuarios u on (u.id = lb.idUsuario)
                                            group by u.id  order by SUM(lb.Valor) desc
                                            limit 10
                                            ");

                            foreach ($rsCamposPagadores as $rowCamposPagadores) {
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

                            $rsCamposPagadores = $db->query("
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

                            foreach ($rsCamposPagadores as $rowCamposPagadores) {
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

                                $rsCamposPagadores = $db->query("
                                        select * from usuarios ud 

                                        where ud.id not in (


                                                            select  distinct
                                                            u.id
                                                            from 
                                                            lancamentosbancarios lb join usuarios u on(u.id = lb.idUsuario)
                                                            where lb.TipoOrigem = 'CR'  and ud.id
                                                            
                                                        )
                                            
                                            ");

                                foreach ($rsCamposPagadores as $rowCamposPagadores) {
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



<?php
include("footer.php");
?>
    <script src="js/plugins/morris/morris.min.js"></script>
    <script src="js/plugins/flot/jquery.flot.js"></script>
    <script src="js/plugins/flot/jquery.flot.pie.js"></script>




    <?php

    //tOP MAIORES PAGADORES
    $SQL = "select u.Nome, FORMAT(SUM(lb.Valor),2)  as Valor
from lancamentosbancarios lb join usuarios u on (u.id = lb.idUsuario)
group by u.id  order by SUM(lb.Valor) desc";




    # chama view de contagem de campos
    $rsInad = $db->query(" SELECT Regiao, count(*) as total, id from Inadimplentes group by Regiao")->results(true);


    $fdata = "    var data = [";
    $fVirgula = "";
    foreach ($rsInad as $rowOptionInad ) {
        foreach ($rowOptionInad as $key => $value) {
            $rowOptionInad[$key] = $db->escape($value);
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