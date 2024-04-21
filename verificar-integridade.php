<?php 

  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
      
?>

<?php
$tituloPrincipal = "Verificar integridade de pagamentos ";
$tituloSecondario = "Verificar";
$navPagina = "Verificar integridade de pagamentos";
?>
	<!-- TITULO e cabeçalho das paginas  -->
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last mb-5">
                    <h3><img src="icon-boleto.jpg" width="100" height="100"> <?=$tituloPrincipal?><br><br>
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
            </div>
        </div>
        <!-- /.row -->

                
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                      <a href='extrato-processamento.php?id={$rowOption['id']}"" class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Importar Extrato Bradesco</a>
                            

                    <?php            

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
    $DataBaixaBoleto   =  $rowOption['DataEmissao'];



    #Update Lancamento Bancario
    $sqlUpdate = "Update lancamentosbancarios SET DataBaixa ='{$DataBaixaBoleto}' WHERE idContaReceber = {$idBoleto} ";

    echo $rowOption['NossoNumero'] . " - ". $sqlUpdate . "<br>";
    

    if (! $db->query($sqlUpdate) ){
      die( ':: Erro : '. $db->errorInfo()[2]); 
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

?>             