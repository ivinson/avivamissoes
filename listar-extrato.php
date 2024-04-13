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



.panel-heading .accordion-toggle h4:after {
    /* symbol for "opening" panels */
    font-family: 'Glyphicons Halflings';  
    content:"\E113";   
    float: right;        
    color: grey;        
    overflow: no-display;
}
.panel-heading .accordion-toggle.collapsed h4:after {
    /* symbol for "collapsed" panels */
    content:"\E114";
}
a.accordion-toggle{
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

                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                        <img src="icon-boleto.jpg" width="100" height="100">

                           Extrato Bancario 
                            <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Listagem de depositos não identificados
                            </li>
                            <LI>
                              <a href='extrato-processamento.php?id={$rowOption['id']}' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Importar Extrato Bradesco</a>
                            </LI>
                        </ol>

<?php 






//if(isset($_GET['action'])){
//if($_GET['action']=="debug"){

### Nova visao Listagem

$sqlMeses = "
select 
  distinct(DATE_FORMAT(DataBaixa, '%m-%Y'))AS DataEmissao
from lancamentosbancarios
where TipoOrigem = 'C' and idUsuario = 1196 
  order by DataBaixa";


#TROCAR USUARIO PRODUCAO
$resultMeses = $db->query($sqlMeses)->results(true) or trigger_error($db->errorInfo()[2]);

foreach($resultMeses as $rowOptionMeses){ 
  foreach($rowOptionMeses AS $key => $value) { $rowOptionMeses[$key] = $db->escape($value); }                               
     
echo "<div class=\"panel-group\" id=\"accordion\">";

echo "
  <div class=\"panel panel-default\">
    <div class=\"panel-heading\">      
        <a class=\"accordion-toggle collapsed\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse{$rowOptionMeses['DataEmissao']}\">
          <h4 class=\"panel-title\">{$rowOptionMeses['DataEmissao']}</h4>
        </a>      
    </div>
    <div id=\"collapse{$rowOptionMeses['DataEmissao']}\" class=\"panel-collapse collapse\">
      <div class=\"panel-body\"> ";
        



              //exit;
              #TROCAR USUARIO PRODUCAO
              $resultSelectDetalhamento = $db->query("
              select * from lancamentosbancarios

              where TipoOrigem = 'C' and idUsuario = 1196 
              and DATE_FORMAT(DataBaixa, '%m-%Y') = '{$rowOptionMeses['DataEmissao']}'
              order by DataBaixa

              ")->results(true) or trigger_error($db->errorInfo()[2]);


          echo "<table class='table' >
                                <thead>
                                    <tr>
                                        <th>Data</th>                          
                                        <th>Nº Documento</th>
                                        <th>Descritivo</th>
                                        <th>Valor</th>
                                        <th>  </th>

                                    </tr>" ; 

                foreach($resultSelectDetalhamento as $rowOptionDetalhamento){ 
                  foreach($rowOptionDetalhamento AS $key => $value) { $rowOptionDetalhamento[$key] = $db->escape($value); }                               
              
                    echo "<tr>";        
                    $phpdate = strtotime( $rowOptionDetalhamento['DataBaixa'] );
                    $mysqldate = date( 'd/m/Y', $phpdate );

                    echo "<td>". nl2br( $mysqldate) ."</td>";
                    echo "<td>". nl2br( $rowOptionDetalhamento['NumeroDocumento']) ."</td>";
                    echo "<td><b>". nl2br( $rowOptionDetalhamento['Descricao']) ."</b></td>";
                    echo "<td style='color:blue;' ><b> R$ ". nl2br( number_format( $rowOptionDetalhamento['Valor'], 2)) ."</b></td>";
                    echo "<td>  
                    <a href='identificar-deposito-extrato.php?id={$rowOptionDetalhamento['id']}' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Identificar</a>
                    <a href='listar-extrato.php?id={$rowOptionDetalhamento['id']}&action=del' class='btn btn-danger' role='button'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> </a>
                     </td>";
                    echo "</tr>";  

                  //echo $rowOptionDetalhamento['Valor'] . '<br>';


                }

                echo "
                           <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                                               
                                </thead>
                            </table> ";


      


      echo "

            </div>
          </div>
        </div>
      </div>
      ";




}








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

<script type="text/javascript">

    


</script>                