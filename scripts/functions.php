<?php


if(file_exists('file.php'))
    include('./config.php');



#total de boletos pagos
function fn_Total_Boletos_Baixados (){
  $result=mysql_query("SELECT Count(*) as total FROM contasreceber WHERE DataBaixa is not null;");

while ($row = mysql_fetch_assoc($result)) {
    // Do stuff with $row
     $row['total'];
}

};


#Baixa de contas a receber para a tabela de lançamentos bancarios
function fn_baixa_contas_receber( 
  
      $data_baixa
    , $valor_baixa
    , $id_usuario
    , $id_usuario_operador
    , $id_projeto
    , $id_contas_receber
    , $obs_do_contas_receber
    , $id_conta_bancaria

  ){

    #Atualiza Contas a Receber com a a DataBaixa, ValorBaixa, BaixadoPor
    //
    //
    //
    //
    

    #Cria lancamento bancario
    $sqlInsert=  "INSERT INTO `lancamentosbancarios`
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
      `idContaBancaria`)
    VALUES
    (
      {$id_usuario },
      {$valor_baixa },
      {\"CR\" },
      {\"$data_baixa\" },
      {$id_projeto },
      {$id_usuario },
      {$id_usuario_operador },
      {$id_contas_receber },
      {\"$obs_do_contas_receber\" },
      {$id_conta_bancaria })";
      //echo "SQL - <br><br>" . $sqlInsert;
      //echo $sqlInsert;
      //mysql_query($sqlInsert) or die(mysql_error()); 


  return $sqlInsert;
}




?>
