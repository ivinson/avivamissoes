<?php 
session_start();
//Verificação inicial e log de acesso sem login
if($_SESSION['logado'] <> "S"){

  $url=$_SERVER['REQUEST_URI'];
  include "logger.php";
  Logger("#### Acesso não autorizado ######");
  Logger("Algum usuario não identificado tentou acessar a {$url}");
  Logger("# ------------------------------------------------------> ");
  
  echo "<script language='JavaScript' type='text/JavaScript'> <!--
      window.location='login.php';
      //-->
      </script>";

  die("login.php");

}
  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
  include "logger.php";
      
?>

<style type="text/css">

.dt-search{
  text-align: right !important;
}

.dt-length{
  margin-bottom: 20px !important;
}

.dt-input{
  margin-right: 20px;
}

.panel-heading .accordion-toggle h4:after {
    /* Define o caractere Unicode para a seta para baixo */
    content: "\25BC"; /* Unicode para a seta para baixo */
    /* Espaçamento à direita para separar o ícone do texto */
    margin-left: 10px;
    /* Posiciona o ícone à direita do texto */
    float: right;
    /* Cor do ícone */
    color: grey;
}

.panel-heading .accordion-toggle.collapsed h4:after {
    /* Define o caractere Unicode para a seta para cima quando o painel está "fechado" */
    content: "\25B2"; /* Unicode para a seta para cima */
}

a.accordion-toggle {
    /* Remove o sublinhado do texto dentro do elemento com a classe .accordion-toggle */
    text-decoration: none;
}   

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
</style>


        <?php
        $tituloPrincipal = "Extrato Bancario ";
        $tituloSecondario = "Extrato";
        $navPagina = "Listagem de depositos não identificados";
        ?>
          <!-- TITULO e cabeçalho das paginas  -->
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 col-md-6 order-md-1 order-last">
                            <h3><img src="icon-boleto.jpg" width="100" height="100"><?=$tituloPrincipal?><br><br>
                            <small><?=$$tituloSecondario?></small></h3>
                        </div>
                        <div class="col-12 col-md-6 order-md-2 order-first">
                            <nav aria-label="breadcrumb" class='breadcrumb-header'>
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="index.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?=$navPagina?></li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <ol class="breadcrumb mb-4">
                            <LI>
                              <a href='extrato-processamento.php?id={$rowOption['id']}' class='btn btn-info' role='button'><i data-feather="layout" width="20"></i></span> Importar Extrato Bradesco</a>
                            </LI>
                        </ol>

<?php 






//if(isset($_GET['action'])){
//if($_GET['action']=="debug"){

### Nova visao Listagem

$sqlMeses = "
SELECT DISTINCT(DATE_FORMAT(DataBaixa, '%Y')) AS Ano,
DATE_FORMAT(DataBaixa, '%Y') AS DataEmissao
FROM lancamentosbancarios
WHERE TipoOrigem = 'C' AND idUsuario = 1196 
ORDER BY DataBaixa";

$resultMeses = $db->query($sqlMeses)->results(true) or trigger_error($db->errorInfo()[2]);

echo "<table id='dataTable' class='table'>
        <thead>
            <tr>
                <th>Ano</th>
                <th>Data</th>
                <th>Nº Documento</th>
                <th>Descritivo</th>
                <th>Valor</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>";

foreach ($resultMeses as $rowOptionMeses) {
    $resultSelectDetalhamento = $db->query("
    SELECT * FROM lancamentosbancarios
    WHERE TipoOrigem = 'C' AND idUsuario = 1196 
    AND DATE_FORMAT(DataBaixa, '%Y') = '{$rowOptionMeses['Ano']}'
    ORDER BY DataBaixa")->results(true) or trigger_error($db->errorInfo()[2]);

    foreach ($resultSelectDetalhamento as $rowOptionDetalhamento) {
        echo "<tr>";
        echo "<td>" . $rowOptionMeses['Ano'] . "</td>";
        $phpdate = strtotime($rowOptionDetalhamento['DataBaixa']);
        $mysqldate = date('d/m/Y', $phpdate);
        echo "<td>" . nl2br($mysqldate) . "</td>";
        echo "<td>" . nl2br($rowOptionDetalhamento['NumeroDocumento']) . "</td>";
        echo "<td><b>" . nl2br($rowOptionDetalhamento['Descricao']) . "</b></td>";
        echo "<td style='color:blue;'><b>R$ " . nl2br(number_format($rowOptionDetalhamento['Valor'], 2)) . "</b></td>";
        echo "<td>
                <a href='identificar-deposito-extrato.php?id={$rowOptionDetalhamento['id']}' class='btn btn-info' role='button'><i data-feather='layout' width='20'></i> Identificar</a>
                <a href='listar-extrato.php?id={$rowOptionDetalhamento['id']}&action=del' class='btn btn-danger' role='button'><i data-feather='x' width='20'></i></a>
              </td>";
        echo "</tr>";
    }
}

echo "</tbody>
      </table>";



### Nova visao listagem




    
      if(isset($_GET['sucess'])){
        if($_GET['sucess'] > 0){


                    echo " <div class=\"alert alert-success\">
                              <strong> Extrato importado com sucesso!</strong> 
                              <br>{$_GET['sucess']} entradas importadas
                         </div>";   

                    }else if($_GET['sucess'] == 0){


                    echo " <div class=\"alert alert-info\">
                              <strong> Extrato já importado hoje!</strong> 
                              <br>{$_GET['sucess']} entradas importadas
                         </div>";   


                    }
                
                  }


            #deleta 
           if(isset($_GET['action'])){
              if($_GET['action']=="del"){
              // sql to delete a record              
              $id = (int) $_GET['id'];   
              $sql = "DELETE FROM lancamentosbancarios WHERE id= {$id} ";              
              $db->query($sql) ; 

              Logger("# Extrato Bradesco [Exclusao] ##");
              Logger("# O usuario {$_SESSION['nome']}({$_SESSION['idlogado']}) excluiu manualmente um lacamento bancario.");
              Logger("# ID :: {$id}");
              Logger("# -----------------------------------------------------------");
              //Redirect("lancamentos-campo.php?id=".$id);
              die("<script>location.href = 'listar-extrato.php'</script>");
             }
           }        
?>



                    </div>
                </div>
                
            
<?php include("footer.php")    ; ?>



            
<script>


$(document).ready(function() {
    $('#dataTable').DataTable({
        dom: 'lBfrtip',
        responsive: true,
        language: {
            url: './assets/js/datatables/api.json'
        },
        buttons: [
            {
                extend: 'searchBuilder',
                text: 'Search Builder',
                config: {
                    columns: ':not(.no-search)'
                }
            },
            'copy', 'csv', 'excel'
        ],
        searchBuilder: {
            container: false // Desativa o contêiner separado para o SearchBuilder
        },
        layout: {
            top1: {
            searchBuilder: {
                liveSearch: false
             }
            }
        },
        createdRow: function(row, data, dataIndex) {
            // Aplica estilos especiais à primeira célula da linha
            $('td:eq(0)', row).css({
                'font-weight': 'bold', // Deixa a letra em negrito
                'font-size': 'larger' // Aumenta o tamanho da letra
            });
        }
    });
});




</script>
