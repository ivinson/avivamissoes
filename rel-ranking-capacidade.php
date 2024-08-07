<?php 

  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
      
?>

<style type="text/css">

.Vencida{    
    width: 110px;
    padding: 1px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: red;
    color: white;
}

.AVencer{    
    width: 110px;
    padding: 1px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: green;
    color: white;
}

.Recebida{    
    width: 110px;
    padding: 2px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: blue;
    color: white;
}

.badge-gold {
    background-color: #efebce; /* Cor de fundo dourada */
    color: #333; /* Cor do texto */
    border-radius: 10px; /* Borda arredondada */
    padding: 5px 10px; /* Espaçamento interno */
    font-weight: bold; /* Texto em negrito */
    text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Sombra do texto para destacar */
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Sombra para adicionar profundidade */
    display: inline-block; /* Para que o badge se ajuste ao conteúdo */
    font-size: 15px;
}
</style>

<?php
$tituloPrincipal = "RANKING DE OFERTAS POR CAPACIDADE";
$tituloSecondario = "Listagem de total de remessas enviadas (2008 ate hoje)";
$navPagina = "Relatório capacidade";
?>

                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-12 col-md-6 order-md-1 order-last mb-5">
                        <h3><img src="inadimplentes.jpg" width="100" height="100"> <?=$tituloPrincipal?><br><br>
                        <small><?=$tituloSecondario?></small></h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?=$navPagina?></li>
                                </ol>
                            </nav>
                        </div>
                        <ol class="breadcrumb" style="display:none !important;">

                            <li class="active">

                                Região
                                <select>
                                  <option value="">Todas as Regiões</option>
                                  <option value="2">Missões Nacionais</option>
                                  <option value="3">Nordeste</option>
                                  <option value="4">Norte</option>
                                  <option value="5">Sudeste 1</option>
                                  <option value="6">Sudeste 2</option>
                                  <option value="7">Sudeste 3</option>                                  
                                  <option value="8">Sul 1</option>
                                  <option value="9">Sul 2</option>
                                  <option value="10">Sul 3</option>                                                              
                                  <option value="11">Centro-oeste</option>
                                  
                                </select>

                            </li>

                            <li>
                              <label><input  id="chkMeses" type="checkbox" value=""> 6 meses ou mais</label>
                            </li>

                        </ol>
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> 
                                    Maiores contribuintes TOP 10 </h3>
                                    <div class="panel-body">
<!-- HTML -->
                        

                                    <?php

                                        $rsCamposPagadores = $db->query("
              select u.Nome, FORMAT(SUM(lb.Valor)/ c.Membros,2)  as Valor,
                        c.Membros, FORMAT(SUM(lb.Valor),2)  as ValorTotal
                                            from lancamentosbancarios lb 
                                            join usuarios u on (u.id = lb.idUsuario)
                                            join congregacoes cg on (cg.id = u.idCongregacao)
                                            join campos c on ( c.id = cg.idCampo)
                                            group by u.id,c.Membros  order by SUM(lb.Valor)/c.Membros desc
                                            limit 10000
                                            ")->results(true) ;

                                        $posicao = 1;


                                            foreach($rsCamposPagadores as $rowCamposPagadores){                                             
                                                foreach($rowCamposPagadores AS $key => $value) { $rowCamposPagadores[$key] = stripslashes($value); }                               
                                                                                    

                                                echo "                                                

                                                <a href='#' class='list-group-item'>
                                                <h4><span style='color:#2f4858' class='badge badge-gold label label-warning label-as-badge'>{$posicao}º</span>
                                                    <span class='label label-success'>R$ {$rowCamposPagadores['Valor']} p/ membro </span>
                                                    <i class='fa fa-fw fa-user'></i> <b>{$rowCamposPagadores['Nome']} </b> ( total de membros : {$rowCamposPagadores['Membros']}) </h4>
                                                </a>";

                                                $posicao++;

                                            }                                    

                                    ?>                                 


                                    </div>
                                <div class="text-right">
                                    
                                </div>
                            </div>
                        </div>
                    </div>   

                    </div>
                </div>

               

<?php include("footer.php")    ; ?>

<script type="text/javascript">

    $('select').on('change', function (e) {
      //var optionSelected = $("option:selected", this).value();
      window.location.href = "inadimplentes.php?idregiao=" + this.value;
    });


$(document).ready(function() {
    $('#chkMeses').change(function() {
        if($(this).is(":checked")) {          
            var url      = window.location.href;     // Returns full URL
            if(url.indexOf('?') >= 0){
                window.location.href = url + "&six=true";
            }else{window.location.href = url + "?six=true";}
        }
    });
});

</script>                