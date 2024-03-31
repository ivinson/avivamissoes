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

                  $rowBaixados = $db->query("SELECT count(*) as total  FROM contasreceber WHERE DataBaixa is not null;")->results();
                  echo $rowBaixados->total;

                  ?>

                </div>
                <div>Boletos Recebidos</div>
              </div>
            </div>
          </div>
          <a style="cursor: pointer;" data-href="contas-a-receber.php" onclick="verDetalhes(this)">
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

                  $rowEmitidos = $db->query("select  count(distinct lb.idUsuario) as total from lancamentosbancarios lb where lb.TipoOrigem = 'CR' ")->results();
                  echo $rowEmitidos->total;

                  ?>

                </div>
                <div>Usam o Sistema</div>
              </div>
            </div>
          </div>
          <!-- <a href="contas-a-receber.php"> -->
          <a style="cursor: pointer;" data-href="contas-a-receber.php" onclick="verDetalhes(this)">
            <div class="panel-footer">
              <span class="pull-left">Ver Detalhes</span>
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

                  $rowCampos = $db->query("SELECT count(*) as total  FROM campos ;")->results();
                  echo $rowCampos->total;

                  ?>


                </div>
                <div>Qtd de Campos</div>
              </div>
            </div>
          </div>
          <a style="cursor: pointer;" data-href="listar-usuarios.php" onclick="verDetalhes(this)">
            <div class="panel-footer">
              <span class="pull-left">Ver Detalhes</span>
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
                                                         
                                                    ")->results();


                  $totalIndimplentes = 0;
                  foreach ($rowOptionInad as $rsInad) {
                    foreach ($rsInad as $key => $value) {
                      $rsInad->$key = stripslashes($value);
                    }

                    if ((int)$rsInad->meses >= 6) {
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
          <a style="cursor: pointer;" data-href="inadimplentes.php" onclick="verDetalhes(this)">
            <div class="panel-footer">
              <span class="pull-left">Ver Detalhes</span>
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
              <a style="cursor: pointer;" data-href="inadimplentes.php" onclick="verDetalhes(this)">Ver Detalhes<i class="fa fa-arrow-circle-right"></i></a>
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

              $rowCamposPagadores = $db->query("
                                            select u.Nome, FORMAT(SUM(lb.Valor),2)  as Valor
                                            from lancamentosbancarios lb join usuarios u on (u.id = lb.idUsuario)
                                            group by u.id  order by SUM(lb.Valor) desc
                                            limit 10
                                            ")->results();

              foreach ($rowCamposPagadores as $rsCamposPagadores) {
                foreach ($rsCamposPagadores as $key => $value) {
                  $rsCamposPagadores->$key = stripslashes($value);
                }


                echo "                                                

                                                <a href='#' class='list-group-item'>
                                                    <span class='label label-success'>R$ {$rsCamposPagadores->Valor}</span>
                                                    <i class='fa fa-fw fa-user'></i> {$rsCamposPagadores->Nome}
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

              $rowCamposPagadores = $db->query("
                                            select  
                                            u.Nome,
                                            lb.idUsuario,
                                            count( lb.idUsuario) as total 
                                            from 

                                            lancamentosbancarios lb join usuarios u on(u.id = lb.idUsuario)

                                            where lb.TipoOrigem = 'CR' 
                                            group by u.Nome,lb.idUsuario
                                            order by total desc
                                            
                                            ")->results();

              foreach ($rowCamposPagadores as $rsCamposPagadores) {
                foreach ($rsCamposPagadores as $key => $value) {
                  $rsCamposPagadores->$key = stripslashes($value);
                }


                echo "                                                

                                                  <a href='follow-up.php?id={$rsCamposPagadores->idUsuario}' class='list-group-item'>                                                  
                                                    <i class='fa fa-fw fa-user'></i> {$rsCamposPagadores->Nome}

                                                     <span class='label label-success'> {$rsCamposPagadores->total}</span>
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
                                            
                                            ")->results();

                foreach ($rsCamposPagadores as $rowCamposPagadores) {
                  foreach ($rowCamposPagadores as $key => $value) {
                    $rowCamposPagadores->$key = stripslashes($value);
                  }


                  echo "                                                

                                                <a href='follow-up.php?id={$rowCamposPagadores->id}' class='list-group-item'>                                                   
                                                    <i class='fa fa-fw fa-user'></i> {$rowCamposPagadores->Nome}
                                                     
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
  $rsInad = $db->query(" SELECT Regiao, count(*) as total, id from Inadimplentes group by Regiao")->results();


  $fdata = "    var data = [";
  $fVirgula = "";
  foreach ($rsInad  as $rowOptionInad) {
    foreach ($rowOptionInad as $key => $value) {
      $rowOptionInad->$key = stripslashes($value);
    }



    if ($fVirgula != ",") {
      $fdata = $fdata . "{label: '{$rowOptionInad->Regiao}', data:{$rowOptionInad->total}, url:'/inadimplentes.php?idregiao={$rowOptionInad->total}&six=true'}";
      $fVirgula = ",";
    } else {
      $fdata =  $fdata . $fVirgula . "{label: '{$rowOptionInad->Regiao}', data:{$rowOptionInad->total}, url:'/inadimplentes.php?idregiao={$rowOptionInad->total}&six=true'}";
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
  <script>
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
      },
      error: function(xhr, status, error) {
        swal.close();
        alert('não ok')
      }

    });
  }
  </script>