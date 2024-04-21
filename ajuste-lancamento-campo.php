<?php  session_start();

include("header.php"); 
include('config.php');  
include('scripts/functions.php'); 

if (isset($_GET['id']) ) { 
$id = (int) $_GET['id']; 
$idUsuario = $_GET['idusuario'];

    if (isset($_POST['submitted'])) { 
    foreach($_POST AS $key => $value) { 
        $_POST[$key] = stripslashes($value); 
        //echo "<br> key {$_POST[$key]} ::: {$value}";
    } 


//DEBUG ==============================================
//valor da data de baixa
#    echo "data passada : " . $_POST['dtBaixa'];
#    $time = strtotime($_POST['dtBaixa']);
#    $newvalue = date('Y-m-d', $time);
#    echo "<br>data convertida : " . $newvalue;
#    echo '<br>';
    $ymd = DateTime::createFromFormat('d/m/Y', $_POST['dtBaixa'])->format('Y/m/d');
#    echo "YMD ". $ymd; 
    $newvalue = $ymd;
    //exit();
    
//DEBUG ==============================================
    
         if ($_FILES['arquivo']['name'] != ""){ 

            // Pasta onde o arquivo vai ser salvo
            $_UP['pasta'] = 'retorno/anexos/movimentobancario/';

            // Tamanho máximo do arquivo (em Bytes)
            $_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb

            // Array com as extensões permitidas
            $_UP['extensoes'] = array('jpg', 'png', 'gif','pdf','doc','xps','docx','jpeg');

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
              echo "Upload efetuado com sucesso!";
              echo '<a href="' . $_UP['pasta'] . $nome_final . '">Clique aqui para acessar o arquivo</a>';
            } else {
              // Não foi possível fazer o upload, provavelmente a pasta está incorreta
              echo "Não foi possível enviar o arquivo, tente novamente";
            }

            $AnexoLancamento =  $_UP['pasta'] . $nome_final ;

        }
            


    $sWhere = "";
    if ($AnexoLancamento != ""){

        $sWhere = ", Anexos = '{$AnexoLancamento}' ";
    }

    $data_referencia = $_POST['Ano']."-".ltrim($_POST["Mes"])."-15";
    //Data de baixa
    $DataBaixa =  $newvalue; //date('Y-d-m', strtotime($_POST['dtBaixa']));

    //$SQL ="INSERT  INTO lancamentosbancarios
    //       (idUsuario,Valor,TipoOrigem,DataBaixa,idProjeto,GeradoPor,BaixadoPor,Descricao,idContaBancaria,TipoLancamento, DataReferencia, Anexos)
    //       VALUES ({$_GET['id']},'{$_POST['Valor']}','C',now(),2,{$_GET['id']},{$_GET['id']},'{$_POST['Descricao']}',1,'Regular', '{$data_referencia}','$AnexoLancamento')";

    $fValor = $_POST['Valor'];
    $ValorSemPonto = str_replace(".","",$fValor); 
    $valor_cobrado = $ValorSemPonto;
    //echo "<br />  Valor Cobrado " . $valor_cobrado ;    
    $valor_cobrado = str_replace(",", ".",$valor_cobrado);


    
    $rowHistorico = $db->query("SELECT MotivoAjuste
                            from `lancamentosbancarios` WHERE `id` = '$id' ")->results(true); 




    $fMotivo =  ":: Pagamento de valor {$_POST['ValorOriginal']}, alterado para {$valor_cobrado}. 
                   Justificativa : {$_POST['Motivo']} . Ajustado por {$_SESSION['nome']}" . " \n ==== ANTERIOR ===== \n". $rowHistorico['MotivoAjuste'] ;

    $sql = "UPDATE `lancamentosbancarios` SET  Valor =  '{$valor_cobrado}' ,  
                                                DataAjuste = now(),
                                                MotivoAjuste = '{$fMotivo}',
                                                DataBaixa = '{$DataBaixa}',
                                                DataReferencia = '{$data_referencia}',
                                                TipoLancamento = 'Regular'
                                                , GeradoPor = {$_SESSION['idlogado']} 
                                                ". $sWhere ."
                                        WHERE `id` = '$id' "; 



                                             
                                        //echo rtrim($data_referencia);

    //exit;

    //echo $sql;                                        
    
    


    //echo "<a href='listar-plano-de-contas.php'>Voltar a Listagem </a>"; 

    //echo $idUsuario;
    //Redirect("lancamentos-campo.php?id=".$idUsuario,true); 
    

    $db->query($sql) or die($db->errorInfo()[2]); 
    die("<script>location.href = 'lancamentos-campo.php?id={$idUsuario}'</script>");


    } 
    
    $row = $db->query("SELECT *, year(DataReferencia) as Ano , month(DataReferencia) as Mes from `lancamentosbancarios` WHERE `id` = '$id' ")->results(true); 




}



?>
<?php
$tituloPrincipal = "Ajuste lançamento de entrada";
$tituloSecondario = "";
$navPagina = "Movimento bancário";
?>
	<!-- TITULO e cabeçalho das paginas  -->
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3><?=$tituloPrincipal?><br><br>
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
               


<form role="form" action='' method='POST' enctype="multipart/form-data"> 
<div class="row">

<div class="col-lg-3">


        <div class="form-group">
            <label>Valor original</label>
            <input class="form-control" name='ValorOriginal' id='ValorOriginal' readonly="readonly" value=' <?= stripslashes($row['Valor']) ?>'>                                
        </div>
        <div class="form-group">
            <label>Valor a ser ajustado</label>
            <input class="form-control" name='Valor' id='Valor' value=''>                                
        </div>        

        <div class="form-group">
            <label>Data de Entrada Bancária</label>
            <input   class="form-control"  id="dtBaixa" type='text' name='dtBaixa' value='' />                              
        </div> 



</div>

<div class="col-lg-3">
        <div class="form-group">
            <label>Mês Referência</label>                                
            <input class="form-control" type='text'  name='Mes' value=' <?= stripslashes($row['Mes']) ?>' /> 
        </div>                                               
</div>
<div class="col-lg-3">
        <div class="form-group">
            <label>Ano Referência</label>                                
            <input class="form-control" readonly="readonly" type='text' name='Ano' value=' <?= stripslashes($row['Ano']) ?>' /> 
        </div>                                               
</div>


<div class="col-lg-9">
        <div class="form-group">
            <label>Motivo do ajuste</label>
            <input class="form-control" type='text' name='Motivo' value='' />
        </div>
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
  // Configuração padrão.
  //$("#currency").maskMoney();

  // Configuração para campos de Real.
  $("#Valor").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
  $("#ValorOriginal").maskMoney({showSymbol:true, symbol:"R$", decimal:",", thousands:"."});
  $("#dtBaixa").mask("99/99/9999",{placeholder:"__/__/____"});
  //$("#dtBaixa" ).datepicker({ dateFormat: 'dd/mm/yy' });

  // Configuração para mudar a precisão da máscara. Neste caso a máscara irá aceitar 3 dígitos após a virgula.
  //$("#precision").maskMoney({precision:3})
});



  
</script>
