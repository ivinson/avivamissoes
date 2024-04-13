<?php 

  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
      
?>


<!-- TITULO e cabeçalho das paginas  -->
<div class="row">
<div class="col-lg-12">
  <h1 class="page-header">
  <img src="icon-boleto.jpg" width="100" height="100">

     Verificar integridade de pagamentos 
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
        <a href='extrato-processamento.php?id={$rowOption['id']}' class='btn btn-info' role='button'><span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span> Importar Extrato Bradesco</a>
      </LI>
  </ol>

</div>
</div>
                
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                       
                            

                    <?php 
                                   

#TROCAR USUARIO PRODUCAO
$resultBoletos = $db->query("
    select * from contasreceber
        where Status='Pago'


and        NossoNumero = '109/00000000-7'

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
    $ValorAjuste       =  $rowOption['Valor'];





    #Update Lancamento Bancario
    $sqlUpdate = "Update 
                  lancamentosbancarios 
                  SET DataBaixa ='{$DataBaixaBoleto}' ,
                      Valor = '{$ValorAjuste}' 

                  WHERE idContaReceber = {$idBoleto} ";

    echo $rowOption['NossoNumero'] . " | Valor de ajuste : {$ValorAjuste} " . " - ". $sqlUpdate . "<br>";
    //echo 
    



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