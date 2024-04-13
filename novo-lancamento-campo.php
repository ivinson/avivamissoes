<?php session_start();

include("header.php")    ;
      include("config.php");


if (isset($_POST['submitted'])) { 

    

   if ($_FILES['arquivo']['name'] != ""){ 

    // Pasta onde o arquivo vai ser salvo
    $_UP['pasta'] = 'retorno/anexos/movimentobancario/';

    // Tamanho máximo do arquivo (em Bytes)
    $_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb

    // Array com as extensões permitidas
    $_UP['extensoes'] = array('jpg', 'png', 'gif','pdf','doc','xps','docx');

    // Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
    $_UP['renomeia'] = true;

    // Array com os tipos de erros de upload do PHP
    $_UP['erros'][0] = 'Não houve erro';
    $_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
    $_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
    $_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
    $_UP['erros'][4] = 'Não foi feito o upload do arquivo';

    // Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
    if ($_FILES['arquivo']['error'] != 0) {
      die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
      exit; // Para a execução do script
    }

    // Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar

    // Faz a verificação da extensão do arquivo
    $extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
    if (array_search($extensao, $_UP['extensoes']) === false) {
      echo "Por favor, envie arquivos com as seguintes extensões: jpg, png ou gif";
      exit;
    }

    // Faz a verificação do tamanho do arquivo
    if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
      echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
      exit;
    }

    // O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta

    // Primeiro verifica se deve trocar o nome do arquivo
    if ($_UP['renomeia'] == true) {
      // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
      $nome_final = md5(time()).'.'.$extensao;
    } else {
      // Mantém o nome original do arquivo
      $nome_final = $_FILES['arquivo']['name'];
    }
      
    // Depois verifica se é possível mover o arquivo para a pasta escolhida
    if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
      // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
      //echo "Upload efetuado com sucesso!";
      //echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
    } else {
      // Não foi possível fazer o upload, provavelmente a pasta está incorreta
      echo "Não foi possível enviar o arquivo, tente novamente";
    }

    $AnexoLancamento =  $_UP['pasta'] . $nome_final ;
}


    #Caso tenha anexo
    $sWhere = "";
    if ($AnexoLancamento != ""){

        $sWhere     = " ,'$AnexoLancamento' ";
        $sWhereINTO = " , Anexos"; 
    }


    //echo "POST";

    foreach($_POST AS $key => $value) { $_POST[$key] = $db->escape($value); } 
    
    //$sql = "INSERT INTO `planodecontas_niveis` ( `idplanodecontas` ,  `nome`  ) 
    //       VALUES( '{$_GET['id']}', '{$_POST['nome']}'   ) "; 

    $data_referencia = $_POST['Ano']."-".$_POST["Mes"]."-15";

    //Data de baixa
    $DataBaixa = DateTime::createFromFormat('d/m/Y', $_POST['dtBaixa'])->format('Y/m/d');//date('Y-d-m', strtotime($_POST['dtBaixa']));

    //Configurações de valor para o banco
    $fValor = $_POST['Valor'];
    $ValorSemPonto = str_replace(".","",$fValor); 
    $valor_cobrado = $ValorSemPonto;
    //echo "<br />  Valor Cobrado " . $valor_cobrado ;    
    $valor_cobrado = str_replace(",", ".",$valor_cobrado);
    $NumeroDocumento = $_POST['Numerodoc'];


    $SQL ="INSERT  INTO lancamentosbancarios
           (NumeroDocumento,idUsuario,Valor,TipoOrigem,DataBaixa,idProjeto,GeradoPor,BaixadoPor,Descricao,idContaBancaria,TipoLancamento, DataReferencia {$sWhereINTO})
           VALUES ('{$NumeroDocumento}' ,{$_GET['id']},'{$valor_cobrado}','C','{$DataBaixa}',2,{$_SESSION['idlogado']},{$_SESSION['idlogado']},'{$_POST['Descricao']}',1,'Regular', '{$data_referencia}' {$sWhere})";

    

    //Enviar email
    #Pegar email do pastor
    
    $rowEmail = $db->query("SELECT *
                                from usuarios WHERE id = {$_GET['id']} ")->results(true);         



$dataReferencia = $_POST['Mes']."/".$_POST["Ano"];
$dataMysql = $_POST["Ano"]."-".$_POST['Mes']."-15";

if(verificaLancamento(0,$dataMysql)){
                                
    #######################################################################################################
    //echo $SQL;
    $db->query($SQL) or die($db->errorInfo()[2]); 

    # limpar trocar  / por ;
    $arrMails = explode('/', $rowEmail['Email']);
    #$mails = "";
    foreach ($arrMails as $value) {
        //echo "$value <br>";
        //if (validaEmail($value)) {
            //echo "O e-mail inserido é valido!";
            //$mails = $mails .' ; '.$value;
        funcEnviaConfirmacaoDeposito( $value, $rowEmail['Nome'], $fValor, $_POST['Mes']."/".$_POST["Ano"] );


        //}
    }

} //Verifica lancamento
 //Se achou algum fachemento


    #######################################################################################################

    die("<script>location.href = 'lancamentos-campo.php?id={$_GET['id']}'</script>");
    //Redirect("lancamentos-campo.php?id={$_GET['id']}",false);

    //echo "Lancamento Efetuado com Sucesso<br />"; 
    //echo "<a href='lancamentos-campo.php?id={$_GET['id']}'>Voltar</a>"; 
} 



?>

<!-- TITULO e cabeçalho das paginas  -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            
            <small>Novo lançamento de entrada</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Movimento bancário
            </li>
        </ol>
    </div</div>
                


<form role="form" action='' method='POST' enctype="multipart/form-data"> 
<div class="row">

<div class="col-lg-3">

        <div class="form-group">
            <label>Valor</label>
            <input class="form-control" name='Valor' id='Valor'  value=''>                                
        </div>

</div>

<div class="col-lg-3">
        <div class="form-group">
            <label>Mês Referência</label>                                
            <input class="form-control" type='text' name='Mes' value='' /> 
        </div>                                               
</div>
<div class="col-lg-3">
        <div class="form-group">
            <label>Ano Referência</label>                                
            <input class="form-control" type='text' name='Ano' value='' /> 
        </div>                                               
</div>


<div class="col-lg-12">
        <div class="form-group">
            <label>Descrição lançamento</label>
            <input class="form-control" type='text' name='Descricao' value='' />
        </div>
</div>

</div>

<div class="row">

        <div class="col-lg-3">
        <div class="form-group">
            <label>Numero do Doc./Transação</label>
            <input   class="form-control"  id="Numerodoc" type='text' name='Numerodoc' value='' />                              
        </div> 
        </div>

        <div class="col-lg-3">
        <div class="form-group">
            <label>Data de Entrada Bancária</label>
            <input   class="form-control"  id="dtBaixa" type='text' name='dtBaixa' value='' />                              
        </div> 
        </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label>Tem comprovante?</label>
            <input type="file" name="arquivo" />
        </div>
    </div>


</div>



<div class="row">
    <div class="col-lg-3">
        <input class="btn btn-lg btn-success" type='submit' value='Salvar' />   
        <input class="btn btn-lg btn-info" type='submit' value='Voltar' onclick='history.back(-1)' />   
        <input type='hidden' value='1' name='submitted' />                                           
    </div>
    <div class="col-lg-3">                       
        

        
    </div>    
</div>               
</form>               

<?php include("footer.php")    ; ?>


<script type="text/javascript">

    $(document).ready(function(){
      // Configuração para campos de Real e Data.
      $("#Valor").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});      
      $("#dtBaixa").mask("99/99/9999",{placeholder:"__/__/____"});      
    });


</script>

<?php

function verificaLancamento($fValorCREDITO,$fdata){

    #Debug
       //echo "select count(*) as total from lancamentosbancarios where 
       //      DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'

             //and idUsuario = {$_GET['id']}
            // ";

            //exit;
    // Realize a conexão com o banco de dados
    $db = DB::getInstance();

    $rs = $db->query("select count(*) as total from lancamentosbancarios where 
             DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
             and idUsuario = {$_GET['id']}
    ");
    $row= $rs->results(true);
    if($row['total'] > 0){
        echo "total  {$row['total']} - ja existe<br>";  

        $id = $_GET['id'];  
        $db->query("DELETE FROM `lancamentosbancarios` WHERE 

        DataReferencia = '{$fdata}' 
        and Round(Valor,2) = '{$fValorCREDITO}'
        and idUsuario = {$_GET['id']} ") ; 
       
        //Redirect("lancamentos-campo.php?id=".$id);
        //die("<script>location.href = 'lancamentos-campo.php?id={$id}'</script>");


        return true;
    }else{
        //echo "total  {$row['total']} - nao existe existe<br>";    
        return true;
    }


}

?>