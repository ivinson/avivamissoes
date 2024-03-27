<?php include("header.php")    ;
      include("config.php");


if (isset($_POST['submitted'])) { 

    foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
    $data_referencia = $_POST['Ano']."-".$_POST["Mes"]."-15";
    //Data de baixa
    $DataBaixa = DateTime::createFromFormat('d/m/Y', $_POST['dtBaixa'])->format('Y-m-d');
    #$ymd = DateTime::createFromFormat('d/m/Y', $_POST['dtBaixa'])->format('Y-m-d');
    #echo "YMD ". $ymd;     
    //Configurações de valor para o banco
    $fValor = $_POST['Valor'];

    echo "<br>";
    echo "valor que vem do campo : " . $fValor;
    echo "<br>";echo "<br>";echo "<br>";
    



    $ValorSemPonto = $fValor;// str_replace(".","",$fValor); 
    $valor_cobrado = $ValorSemPonto;
    $valor_cobrado = str_replace(",", ".",$valor_cobrado);

    echo "<br>";
    echo "valor que vai pro banco :".$valor_cobrado ." <br>" ;
    exit;



    $NumeroDocumento = $_POST['Numerodoc'];
    $idUsuario = $_POST['selectUsuario'];
    
        //DEBUG ==============================================
        ########################################################################
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

    #####################################################################################

 
$data_referencia = $_POST['Ano']."-".$_POST["Mes"]."-15";  
$id = (int) $_GET['id']; 
$idUsuario = (int)$_POST['selectUsuario'];
$sql = "UPDATE `lancamentosbancarios` SET  TipoLancamento = 'Identificado'
                                            , DataReferencia = '{$data_referencia}'
                                                , GeradoPor = {$_SESSION['idlogado']} 
                                                , idUsuario = $idUsuario
                                                , Valor =  '{$valor_cobrado}' 
                                                ". $sWhere ."
                                        WHERE `id` = '$id' "; 

    //echo $sql . "<br>";                                        
    
    //exit;


    //echo (mysql_affected_rows()) ? "Edited row.<br />" : "Nothing changed. <br />"; 
    //echo "<a href='listar-plano-de-contas.php'>Voltar a Listagem </a>"; 

    //echo $idUsuario;
    //Redirect("lancamentos-campo.php?id=".$idUsuario,true); 
    
    //echo "<br>usuario antes - " . $idUsuario;

    if(verificaLancamento(0,$data_referencia,$idUsuario)){

        //echo "<br>usuario Depois - " . $idUsuario; 
        
        mysql_query($sql) or die(mysql_error()); 
        //exit;


    //echo $SQL;


    #Descomentar e verificar o envio de Identificação Manual
    #######################################################################################################
    //mysql_query($SQL) or die(mysql_error()); 
    //$dataReferencia = $_POST['Mes']."/".$_POST["Ano"];
    //$arrMails = explode('/', $rowEmail['Email']);
    //foreach ($arrMails as $value) {
    //    funcEnviaConfirmacaoDeposito( $value, $rowEmail['Nome'], $fValor, $_POST['Mes']."/".$_POST["Ano"] );
    //}
    #######################################################################################################
}
    die("<script>location.href = 'listar-extrato.php'</script>");
} 



?>

<!-- TITULO e cabeçalho das paginas  -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            
            <small>Identificação de depósitos</small>
        </h1>
        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Movimento bancário
            </li>
        </ol>
    </div>
</div>
                

<form role="form" action='' method='POST' enctype="multipart/form-data"> 

<div class="row">
    <div class="col-lg-9">
            <div class="form-group">
                <label>Campo</label>
        <?php 
        echo "<select  data-placeholder=\"Escolha um usuário... \" id=\"selectUsuario\"    \" name=\"selectUsuario\" class=\"form-control\" class=\"chosen-select\" 
         \>";

            
            //Lista Apenas Campos Eclesiáticos                                
            $resultSelect = mysql_query("
                                            SELECT u.id, u.Nome FROM `usuarios` u
                                                    join congregacoes i on (i.id= u.idCongregacao)
                                                    join campos c on(c.id = i.idCampo)
                                            where 
                                            u.idTipoUsuario = 6   or u.idTipoUsuario = 7 or u.idTipoUsuario = 9                                            
                                        union
                                            select '' as id,' Escolha um campo ' as Nome
                                            order by nome

                                            
                ") or 
                    trigger_error(mysql_error()); 
                    
                    while($rowOption = mysql_fetch_array($resultSelect)){ 
                    foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                      echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                    } 
                    echo "</select>";
        ?>                                             
            </div>

    </div>
</div>

<?php 
$fID =  $_GET['id'] ;
$result = mysql_query("SELECT *  from lancamentosbancarios where id = ".$fID) or trigger_error(mysql_error()); 

while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 


?>
<div class="row">

<div class="col-lg-3">

        <div class="form-group">
            <label>Valor</label>
            <input class="form-control" name='Valor' id='Valor'  value='<?= stripslashes($row['Valor']) ?>'>                                
        </div>

</div>

<div class="col-lg-3">
        <div class="form-group">
            <label>Mês Referência</label>                                
            <!--<input class="form-control" type='text' name='Mes' value='' /> -->
            <!-- Month dropdown -->
            <select name='Mes' id='Mes' class="form-control"   size="1">
                <option selected value="">Escolha o mes</option>
                <option value="01">Janeiro</option>
                <option value="02">Fevereiro</option>
                <option value="03">Março</option>
                <option value="04">Abril</option>
                <option value="05">Maio</option>
                <option value="06">Junho</option>
                <option value="07">Julho</option>
                <option value="08">Agosto</option>
                <option value="09">Setembro</option>
                <option value="10">Outubro</option>
                <option value="11">Novembro</option>
                <option value="12">Dezembro</option>
            </select>

        </div>                                               
</div>
<div class="col-lg-3">
        <div class="form-group">
            <label>Ano Referência</label>                                
           <!-- <input class="form-control" type='text' name='Ano' value='' />  -->
            
            <select class="form-control" id="Ano" name='Ano'>
              <script>
                  var myDate = new Date();
                  var year = myDate.getFullYear();
                  document.write('<option selected value="">Escolha o Ano </option>');
                  for(var i = 2005; i < year+5; i++){
                      document.write('<option value="'+i+'">'+i+'</option>');
                  }
              </script>
            </select>            


        </div>                                               
</div>


<div class="col-lg-9">
        <div class="form-group">
            <label>Descrição lançamento</label>
            <input class="form-control" type='text' name='Descricao' value='<?= stripslashes($row['Descricao']) ?>' heigth="200" />
        </div>
</div>

</div>

<div class="row">

        <div class="col-lg-3">
        <div class="form-group">
            <label>Numero do Doc./Transação</label>
            <input   class="form-control"  id="Numerodoc" type='text' name='Numerodoc' value='<?= stripslashes($row['NumeroDocumento']) ?>' />                              
        </div> 
        </div>

        <div class="col-lg-3">
        <div class="form-group">
            <label>Data de Entrada Bancária</label>
            <?php 
                $phpdate = strtotime( $row['DataBaixa'] );
                $mysqldate = date( 'd-m-Y', $phpdate );
            ?>

            <input   class="form-control"  id="dtBaixa" type='text' name='dtBaixa' value='<?= stripslashes($mysqldate) ?>' />                              
        </div> 
        </div>

    <div class="col-lg-3">
        <div class="form-group">
            <label>Tem comprovante?</label>
            <input type="file" name="arquivo" />
        </div>
    </div>


<?php } ?>
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
      //$("#Valor").maskMoney({showSymbol:true, symbol:"R$", decimal:".", thousands:","});      
      $("#dtBaixa").mask("99/99/9999",{placeholder:"__/__/____"}); 



    // add the rule here
     $.validator.addMethod("valueNotEquals", function(value, element, arg){
      return arg != value;
     }, "Value must not equal arg.");

     // configure your validation
     $("form").validate({
      rules: {
       SelectName: { valueNotEquals: "-1" }
      },
      messages: {
       SelectName: { valueNotEquals: "Please select an item!" }
      }  
     });
           
    });


</script>


<?php

function verificaLancamento($fValorCREDITO,$fdata,$idusuario){



    #Debug
  

           // exit;


    $rs = mysql_query("select count(*) as total from lancamentosbancarios where 
             DataReferencia = '{$fdata}' and Round(Valor,2) = '{$fValorCREDITO}'
             and idUsuario = {$idusuario}
    ");
    $row=mysql_fetch_assoc($rs);


    #debug
    //exit;


    if($row['total'] > 0){
        //echo "total  {$row['total']} - ja existe<br>";  

        
        
      

        //exit;

        mysql_query("DELETE FROM `lancamentosbancarios` WHERE 

        DataReferencia = '{$fdata}' 
        and Round(Valor,2) = '{$fValorCREDITO}'
        and idUsuario = {$idusuario} ") ; 
       
        //Redirect("lancamentos-campo.php?id=".$id);
        //die("<script>location.href = 'lancamentos-campo.php?id={$id}'</script>");


        return true;
    }else{
        //echo "total  {$row['total']} - nao existe existe<br>";    
        return true;
    }


}

?>