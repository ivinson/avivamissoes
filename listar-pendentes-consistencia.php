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
                        <img src="http://www.horsecare.com.br/wp-content/uploads/2014/10/pendencias-HorseCare-250x250.png" width="100" height="100">

                           Lançamentos Pendentes
                            <small></small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Listagem pendentes depois do processo de consistencia
                            </li>
                            <LI>
                              <a href='consistencia.php' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Importar excel</a>
                            </LI>
                        </ol>

<?php 

### Nova visao Listagem

$sqlMeses = "
select 
  distinct(DATE_FORMAT(DataReferencia, '%m-%Y'))AS DataRef
from lancamentosbancarios
where TipoLancamento = 'PENDENTE'
 -- and idUsuario = 924
  order by DataBaixa";


#TROCAR USUARIO PRODUCAO
$resultMeses = $db->query($sqlMeses)->results(true) or trigger_error($db->errorInfo()[2]); 

foreach($resultMeses as $rowOptionMeses){ 
  foreach($rowOptionMeses AS $key => $value) { $rowOptionMeses[$key] = stripslashes($value); }                               
     
echo "<div class=\"panel-group\" id=\"accordion\">";

echo "
  <div class=\"panel panel-default\">
    <div class=\"panel-heading\">      
        <a class=\"accordion-toggle collapsed\" data-toggle=\"collapse\" data-parent=\"#accordion\" href=\"#collapse{$rowOptionMeses['DataRef']}\">
          <h4 class=\"panel-title\">Competência {$rowOptionMeses['DataRef']}</h4>
        </a>    </div>
    <div id=\"collapse{$rowOptionMeses['DataRef']}\" class=\"panel-collapse collapse\">
      <div class=\"panel-body\"> ";
        

              //exit;
              #TROCAR USUARIO PRODUCAO
              $resultSelectDetalhamento = $db->query("
               select lb.*, u.Nome from lancamentosbancarios lb
                join usuarios u on (u.id = lb.idusuario)

              where 
              TipoLancamento = 'PENDENTE' and 
              
              DATE_FORMAT(lb.DataReferencia, '%m-%Y') = '{$rowOptionMeses['DataRef']}'
               -- and lb.idUsuario = 924 -- Campo Grande
              order by lb.idUsuario

              ")->results(true) or trigger_error($db->errorInfo()[2]); 

              $usuarioAnterior =0;

              echo "<table class='table' >
                                <thead>
                                    <tr>
                                        <th>Baixa</th>
                                        <th>Ref</th>                            
                                        <th>Campo</th>
                                        <th>Descritivo</th>
                                        <th>Valor</th>
                                        <th>Status  </th>

                                    </tr>" ; 

                foreach($resultSelectDetalhamento as $rowOptionDetalhamento){ 
                  foreach($rowOptionDetalhamento AS $key => $value) { $rowOptionDetalhamento[$key] = stripslashes($value); }                               
              

                  if($usuarioAnterior == $rowOptionDetalhamento['idUsuario']){
                    
                  
                  #Verificação de Status de Registro
                  //$Status = $rowOptionDetalhamento['TipoLancamento'] ;
                  #Se for pendente de consistencia configura botoes e acoes
                  //if ($Status == "PENDENTE"){

                    echo "<tr bgcolor='#ffe6e6'>";        
                    $phpdate = strtotime( $rowOptionDetalhamento['DataBaixa'] );
                    $mysqldate = date( 'd/m/Y', $phpdate );

                    //$phpdateRef = strtotime( $rowOptionDetalhamento['DataBaixa'] );
                    $mysqldateRef = date( 'm/Y', strtotime( $rowOptionDetalhamento['DataReferencia'] ) );

                    echo "<td>". nl2br( $mysqldate) ."</td>";
                    echo "<td>". nl2br( $mysqldateRef) ."</td>";
                    
                    echo "<td>". nl2br( $rowOptionDetalhamento['Nome']) ."</td>";
                    echo "<td style='color:Red;'> Consistencia </td>";
                    echo "<td > R$ ". nl2br( number_format( $rowOptionDetalhamento['Valor'], 2)) ."</td>";
                    echo "<td>  
                    
                    <a href='listar-pendentes-consistencia.php?id={$rowOptionDetalhamento['id']}&action=del' class='btn btn-danger' role='button'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> </a>
                     </td>";
                    echo "</tr>";

                    
                 // }
                   
                }else{

                  
                    //$phpdateRef = strtotime( $rowOptionDetalhamento['DataBaixa'] );
                    $mysqldateRef = date( 'm/Y', strtotime( $rowOptionDetalhamento['DataReferencia'] ) );

                  getLancamentosMes($mysqldateRef, $rowOptionDetalhamento['idUsuario']);


                   echo "<tr bgcolor='#ffe6e6'>";        
                    $phpdate = strtotime( $rowOptionDetalhamento['DataBaixa'] );
                    $mysqldate = date( 'd/m/Y', $phpdate );

                 
                    echo "<td>". nl2br( $mysqldate) ."</td>";
                    echo "<td>". nl2br( $mysqldateRef) ."</td>";
                    
                    echo "<td>". nl2br( $rowOptionDetalhamento['Nome']) ."</td>";
                    echo "<td style='color:Red;'> Consistencia </td>";
                    echo "<td > R$ ". nl2br( number_format( $rowOptionDetalhamento['Valor'], 2)) ."</td>";
                    echo "<td>  
                 
                    <a href='listar-extrato.php?id={$rowOptionDetalhamento['id']}&action=del' class='btn btn-danger' role='button'><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> </a>
                     </td>";
                    echo "</tr>";










                  $usuarioAnterior = $rowOptionDetalhamento['idUsuario'];



                }
                 
                  //echo $rowOptionDetalhamento['Valor'] . '<br>';
                  #Controle de agrupamento
                 


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
              //$sql = "DELETE FROM lancamentosbancarios WHERE id= {$id} ";              
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


<?php 
# Verifa o status de comparacao ENTRE A ACOMPARACAO DO EXEL ENVIADO
# E O BANCO DE DADOS
#######################################################################
function getLancamentosMes($DataReferencia,$idUsuario){
  // Realize a conexão com o banco de dados
  $db = DB::getInstance();

  #Prepara data de refrencia
  $mesRef = 0;
  $anoRef = 0;
  $dataArray = 0;
  if(isset($DataReferencia)){
    $dataArray =  explode('/', $DataReferencia);
    $mesRef = $dataArray[0];
    $anoRef = $dataArray[1];  
  }

  //echo "<br>valor = {$valorOferta}";
    $tempVl = str_replace(",", "", $valorOferta );
    $tempVl = str_replace("*", "", $tempVl );
    
    //echo "<br>temp = {$tempVl}";


/*

  echo "<br>DataReferencia = "  . $DataReferencia;
  echo "<br>valorOferta = "     . $valorOferta;
  echo "<br>idUsuario = "     . $idUsuario;
  echo "<br>";
  echo "#########################################<br><br><br>";
  //echo "<br>DataReferencia = " . $DataReferencia;

*/

  #SQL INICIO 
  # Verifica se existe lancamento identico
  $sql = "   select lb.*, u.Nome from lancamentosbancarios lb
                join usuarios u on (u.id = lb.idusuario)
      where 
        month(lb.DataReferencia) = {$mesRef}
      and year(lb.DataReferencia)  = {$anoRef}
      and lb.idUsuario = {$idUsuario}
      and TipoLancamento not in ('PENDENTE')
  ";


  $resultLancamentos = $db->query($sql)->results(true) or trigger_error($db->errorInfo()[2]); 
  $count = $resultLancamentos->num_rows;

  //echo $sql ;
  //echo "<br> Count :  {$count} ";
  //exit();
if($count >= 1){
    //echo "<br> {$sql}";
 foreach($resultLancamentos as $row ){ 
                  foreach($row AS $key => $value) { $row[$key] = stripslashes($value); }


    $desc = $row["Descricao"];
    $pos = strpos($desc, "migracao");

    // Note o uso de ===.  Simples == não funcionaria como esperado
    // por causa da posição de 'a' é 0 (primeiro) caractere.
    if ($pos !== false) {
       $desc = "Migracao de histórico ";
       // echo " e existe na posição $pos";
    }


  echo "<tr bgcolor='#ddffcc'>";        
  $phpdate = strtotime( $row['DataBaixa'] );
  $mysqldate = date( 'd/m/Y', $phpdate );

  $mysqldateRef = date( 'm/Y', strtotime( $row['DataReferencia'] ) );

  //echo "<td > {$row['Descricao']}  </td>";

  echo "<td>". nl2br( $mysqldate) ."</td>";
  echo "<td>". nl2br( $mysqldateRef) ."</td>";
  echo "<td>". nl2br( $row['Nome']) ."</td>";
  echo "<td><b>". nl2br( $desc) ."</b></td>";
  echo "<td style='color:black;' ><b> R$ ". nl2br( number_format( $row['Valor'], 2)) ."</b></td>";
  echo "<td> 
   
   <a href='corrigir-competencias.php?mes={$mesRef}&ano={$anoRef}&userid={$idUsuario}' class='btn btn-success' role='button'> Corrigir</a>


   </td>";
  echo "</tr>";

}


return "true";
}
  
}                
    
?>            
            
<?php include("footer.php")    ; ?>
