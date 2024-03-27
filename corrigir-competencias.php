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


    #deleta 
    if(isset($_GET['action'])){
      if($_GET['action']=="confirm"){
        $mesRef = $_GET['mes'];
        $anoRef = $_GET['ano'];
        $idUsuario = $_GET['id'];
        echo "--- {$idUsuario}";
        setCorrigirCompetencias($mesRef,$anoRef,$idUsuario);
      }
    }




      
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



</style>

                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                        <img src="http://www.horsecare.com.br/wp-content/uploads/2014/10/pendencias-HorseCare-250x250.png" width="100" height="100">

                           Corrigir competência <h3>Registro atual: </h3>
                        </h1>




  <div class="row">
      <div class="col-lg-12">
              
              <div class="form-group">
             

<?php

$mesRef = $_GET['mes'];
$anoRef = $_GET['ano'];
$idUsuario = $_GET['userid'];

  #SQL INICIO 
  # Verifica se existe lancamento identico
  $sqlAtuais = " select lb.*, u.Nome from lancamentosbancarios lb
                join usuarios u on (u.id = lb.idusuario)
      where 
        month(lb.DataReferencia) = {$mesRef}
      and year(lb.DataReferencia)  = {$anoRef}
      and lb.idUsuario = {$idUsuario}
      and TipoLancamento not in ('PENDENTE')
  ";

$resultAtuais = mysql_query($sqlAtuais) or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($resultAtuais)){ 
    foreach($row AS $key => $value) { $row[$key] = stripslashes($value); }
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
                   echo "<tr bgcolor='#ffe6e6'>";        
                    $phpdate = strtotime( $row['DataBaixa'] );
                    $mysqldate = date( 'd/m/Y', $phpdate );                 
                    echo "<td>". nl2br( $mysqldate) ."</td>";
                    echo "<td>". nl2br( $mysqldateRef) ."</td>";                    
                    echo "<td>". nl2br( $row['Nome']) ."</td>";
                    echo "<td style='color:Red;'> {$row['Descricao']} </td>";
                    echo "<td > R$ ". nl2br( number_format( $row['Valor'], 2)) ."</td>";
                    echo "<td> 
                     </td>";
                    echo "</tr>";
                    echo "</threa></table>"; 

}


#SQL INICIO 
# Verifica se existe lancamento identico
$sqlPendentes = " select lb.*, u.Nome from lancamentosbancarios lb
              join usuarios u on (u.id = lb.idusuario)
    where 
      month(lb.DataReferencia) = {$mesRef}
    and year(lb.DataReferencia)  = {$anoRef}
    and lb.idUsuario = {$idUsuario}
    and TipoLancamento ='PENDENTE'
";
      
      echo "<h3>Substituir por : </h3>";
      echo "<table class='table' >
                                <thead>
                                    <tr>                                       
                                    </tr>" ;      

                  
$resultPendentes = mysql_query($sqlPendentes) or trigger_error(mysql_error()); 
  while($row = mysql_fetch_array($resultPendentes)){ 
      foreach($row AS $key => $value) { $row[$key] = stripslashes($value); }
          echo "<tr bgcolor='#ccffcc'>"; 
          $phpdate = strtotime( $row['DataBaixa'] );
          $mysqldate = date( 'd/m/Y', $phpdate );     
          echo "<td>". nl2br( $mysqldate) ."</td>";
          echo "<td>". nl2br( $mysqldateRef) ."</td>";                    
          echo "<td>". nl2br( $row['Nome']) ."</td>";
          echo "<td style='color:Red;'> Consistencia </td>";
          echo "<td > R$ ". nl2br( number_format( $row['Valor'], 2)) ."</td>";
          echo "<td> </td>";
  }
echo "</threa></table>"; 
?>                  

        </div>                        
    </div>
</div>





<?php

 echo "<a href='corrigir-competencias.php?action=confirm&mes={$mesRef}&ano={$anoRef}&id={$idUsuario}' class='btn btn-danger' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Confirma ?</a>";

?>

  <a href='listar-pendentes-consistencia.php' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Cancela</a>


</div></div>


<?php
#corrir competencias com problemas
function setCorrigirCompetencias($mesRef,$anoRef,$idUsuario){



echo $idUsuario . "<br>";



# Deletar lancamento bancario atual
  #SQL INICIO 
  # Verifica se existe lancamento identidwwco
  $sqlAtuais = " select * from lancamentosbancarios lb
      where 
        month(lb.DataReferencia) = {$mesRef}
      and year(lb.DataReferencia)  = {$anoRef}
      and lb.idUsuario = {$idUsuario}
      and TipoLancamento not in ('PENDENTE')
  ";
echo $sqlAtuais;
  

$resultAtuais = mysql_query($sqlAtuais) or trigger_error(mysql_error()); 
while($rowAtuais = mysql_fetch_array($resultAtuais)){ 
 foreach($rowAtuais AS $key => $value) { $rowAtuais[$key] = stripslashes($value); }

        $id = $rowAtuais['id'];   
        $sqlDel = "DELETE FROM lancamentosbancarios WHERE id= {$id} ;";              
        mysql_query($sqlDel) ; 
        echo "deletou lancamentosbancarios id {$id}<br>";
}


#Atualizar todos os Pendentes daquele Mes para Regular

#SQL INICIO 
# Verifica se existe lancamento identico
$sqlPendentes = " 

select * from lancamentosbancarios lb
          
    where 
      month(lb.DataReferencia) = {$mesRef}
    and year(lb.DataReferencia)  = {$anoRef}
    and lb.idUsuario = {$idUsuario}
    and lb.TipoLancamento ='PENDENTE'
";
  
echo "<br>";    
echo $sqlPendentes;
                  
$resultPendentes = mysql_query($sqlPendentes) or trigger_error(mysql_error()); 
  while($row = mysql_fetch_array($resultPendentes)){ 
      foreach($rowPendentes AS $key => $value) { $row[$key] = stripslashes($value); }
        $id = $row['id'];   
        $sqlUpd = "UPDATE  lancamentosbancarios 
                Set TipoLancamento = 'Regular'
        WHERE id= {$id} ;";              
        mysql_query($sqlUpd) ; 

}

die("<script>location.href = 'listar-pendentes-consistencia.php?action=confirm&idUsuario={$idUsuario}';</script>");

}



?>