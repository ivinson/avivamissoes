<?php 

echo "<h1>".date()."</h1>";

  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
      
?>


<!-- TITULO e cabeçalho das paginas  -->
<div class="row">
<div class="col-lg-12">
  <h1 class="page-header">
  <img src="icon-boleto.jpg" width="100" height="100">

     Tela de Utilidades Gerais do Sistema
      <small></small>
  </h1>
  <ol class="breadcrumb">
      <li>
          <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
      </li>
      <li class="active">
          <i class="fa fa-file"></i> 
      </li>
      <LI>
      
      </LI>
  </ol>


<br>   <a href='utils.php?action=files' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
Verificar Arquivos sem lancamentos correspondentes </a>

<a href='verificar-integridade.php' class='btn btn-warning' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
Verificar Integridade </a>

<br><br>

</div>
</div>  
<!-- /.row -->
<div class="row">
<div class="col-lg-12">
<?php 
        

if (isset($_GET['move']) ) { 

  #Move o arquivo referido para outra pasta
  $path = "retorno/anexos/movimentobancario/";
  $novoPath = "retorno/anexos/movimentodel/";

  $arquivo =  $_GET["move"] ;
  //$diretorio = dir($path);

  rename($path.$arquivo, $novoPath.$arquivo);
  $_GET['action'] = "files";
  
  #echo  "de : " . $path.$arquivo;
  #echo  "<br> para : ";
  #echo  $novoPath.$arquivo;
  
  //exit();



}


$iTotal;
$iSemCorrespondentes;

if (isset($_GET['action']) ) { 

echo "  
<div class='table-responsive'>
  <table class='table'>
    <thead>
      <tr>
 
        <th>Arquivo</th>
        <th>Data </th>
        <th>Ação</th>
      </tr>
    </thead>
    <tbody>";


  if($_GET['action'] == "files"){

   $path = "retorno/anexos/movimentobancario/";
   $diretorio = dir($path);
    
  echo "Lista de Arquivos do diretório '<strong>".$path."</strong>':<br />";    

   echo "<br> Total::: " . $diretorio -> read() ."<br>";
   while($arquivo = $diretorio -> read()){
    $iTotal++;
     
             //if($iSemCorrespondentes > 10){
      
               // continue;

             //}
       continue;      
    #Verifico se existe esse anexo em algum lancamento no banco de dados
    $sql = "select * from lancamentosbancarios
            where Anexos = 'retorno/anexos/movimentobancario/{$arquivo}'";


      $resultLancamentos = $db->query($sql)->results(true) or trigger_error($db->errorInfo()[2]); 


      $count = $resultLancamentos->num_rows;

      if ($count == 0){

        $iSemCorrespondentes++;
        
        if($iTotal > 2){
        
        $filename = $path.$arquivo;

        $DataArquivo = date ("d/m/y", filemtime($filename));
      echo "
      <tr>
        <td><a target='_blank' href='".$path.$arquivo."'>".$arquivo."</a><br /></td>
        <td>{$DataArquivo}</td>
        <td>
          <a href='listar-extrato.php' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
          Identificar </a>

          <a href='nova-entrada-direta.php?lk=".$path.$arquivo."' class='btn btn-success' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> 
          Novo Lançamento </a>

           <a href='utils.php?move=".$arquivo."' class='btn btn-danger' role='button'><span aria-hidden='true'></span> 
          X </a>         

        </td>
      </tr>
      ";

      }
          #echo "<a target='_blank' href='".$path.$arquivo."'>".$arquivo."</a><br />";
         

      }

      
   }

   $diretorio -> close();      


  } 

}
    echo "  
    </tbody>
  </table>
  </div>
";

echo "Total de Arquivos na pasta<h1>{$iTotal}</h1> <br>";
echo "Total de Arquivos sem correspondentes <h1>{$iSemCorrespondentes}</h1> <br>";

exit(); 

#TROCAR USUARIO PRODUCAO
$resultBoletos = $db->query("
    select * from contasreceber
        where Status='Pago'

")->results(true) or trigger_error($db->errorInfo()[2]); 


foreach($resultBoletos as $rowOption ){ 
  foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }  


    #Para cada boleto pago verifico se tem um lancamento bacario
    #correspondente. Senao, Crio com o valor e a data de referencia do boleto

      #TROCAR USUARIO PRODUCAO
    $sql = "select * from lancamentosbancarios
              where idContaReceber = {$rowOption['id']}";

      $resultLancamentos = $db->query($sql)->results(true) or trigger_error($db->errorInfo()[2]); 


      $count = $resultLancamentos->num_rows;

      if ($count == 0){
        //echo $sql."<br>";
        echo " Boleto {$rowOption['NossoNumero']}  de Valor {$rowOption['Valor']} não encontrado. <br>";
        echo "<br>Reconstruindo pagamento...";


        $NossoNumero = str_replace("/", "-",$rowOption['NossoNumero']) ;


        $SqlInsereLancamento = "
        INSERT INTO lancamentosbancarios
        (
        `idUsuario`,
        `Valor`,
        `TipoOrigem`,
        `DataBaixa`,
        `idProjeto`,

        `GeradoPor`,
        `BaixadoPor`,
        `idContaReceber`,           

        `Descricao`,
        `idContaBancaria`,
        `DataReferencia`,
        `NumeroDocumento`
        )
        VALUES
        (
        ".$rowOption['idUsuario']." ,
        {$rowOption['Valor']},
        'CR',
        '".$rowOption['DataBaixa']."',
        ".$rowOption['idProjeto']." ,
        ".$rowOption['GeradoPor']." ,
        {$_SESSION['idlogado']},
        ".$rowOption['id']." ,
        'Crédito gerado por boleto bancario online Nosso Nº {$NossoNumero} ',
        1,
        '".$rowOption['DataReferencia']."', '{$NossoNumero}' );";

        echo "####<br>SQL Insert <br>  " . $SqlInsereLancamento."   <br>#######################";

        #Verifica Lancamento
          if(verificaLancamento2(0,$rowOption['DataReferencia'],$rowOption['idUsuario'])){

            echo "<br>User: {$rowOption['idUsuario']} | Valor:{$rowOption['Valor']}  -  Pagamento ok. <br>";

                  if (! $db->query($SqlInsereLancamento) ){
                    echo '<br>:: Erro : '. $db->errorInfo()[2];
                    #echo "F: Anote o seguinte erro!";
                  }else{
                    echo "<br>Pagamento ok.<br><br>";
                }

                


          }

      }else{
        
    #Se existir pgamento atualiza a data de Baixa para o lancamento bancario
    $idBoleto          =  $rowOption['id'];
    $DataBaixaBoleto   = $rowOption['DataBaixa'];



    #Update Lancamento Bancario
    $sqlUpdate = "Update lancamentosbancarios SET DataBaixa ='{$DataBaixaBoleto}' WHERE idContaReceber = {$idBoleto} ";

    echo $rowOption['NossoNumero'] . " - ". $sqlUpdate . "<br>";
    

    if (! $db->query($sqlUpdate) ){
      die( ':: Erro : '.  $db->errorInfo()[2]); 
      echo "Fase de teste : Anote o seguinte erro! <br>";
    };







      }


}  




?>



                    </div>
                </div>
            
<?php include("footer.php")    ; ?>

<script type="text/javascript">

    


</script>   





<?php

function verificaLancamento2($fValorCREDITO,$fdata,$idusuario){

      #Debug
       #echo " select count(*) as total from lancamentosbancarios where 
       #      DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
       #      and idUsuario = {$idusuario} ";

            //exit;
    // Realize a conexão com o banco de dados
    $db = DB::getInstance();

    $sqlDel = "select count(*) as total from lancamentosbancarios where 
             DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
             and idUsuario = {$idusuario}";

    echo "<br> {$sqlDel}  ";       
    $rs = $db->query($sqlDel);
    $row= $rs->results(true);
    if($row['total'] > 0){
        echo "total  {$row['total']} - existe<br>";  
        echo "Excluindo fechamentos...<br>";

        //$id = $_GET['id'];  

        #$db->query("DELETE FROM `lancamentosbancarios` WHERE 
        #DataReferencia = '{$fdata}' 
        #and Round(Valor,2) = '{$fValorCREDITO}'
        #and idUsuario = {$idusuario} ") ; 
        
        echo "DELETE FROM `lancamentosbancarios` WHERE 
        DataReferencia = '{$fdata}' 
        and Round(Valor,2) = '{$fValorCREDITO}'
        and idUsuario = {$idusuario} <br>";

        //Redirect("lancamentos-campo.php?id=".$id);
        //die("<script>location.href = 'lancamentos-campo.php?id={$id}'</script>");


        return true;
    }else{
        //echo "total  {$row['total']} - nao existe existe<br>";    
        echo "Não foi gerada fechamento apara esse boleto...";
        return true;
    }


}


echo "<h1>".date()."</h1>";
?>             



