<?php ob_start(); ?> 
<?php 
  include("header.php")    ; 
  include('config.php'); 
  include('scripts/functions.php'); 
  

?>

                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            CAMPOS ECLESIASTICOS
                            <small>Editar</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Editar de Usuários
                            </li>
                        </ol>
                    </div>
                </div>
                
                <!-- /.row -->




                          <?php 
                        

                          if (isset($_GET['id']) ) { 
                            $id = (int) $_GET['id']; 
                              
                              //debug
                              //echo "<br> <p> <h3> Calores do POST </h3>";
                            if (isset($_POST['submitted'])) { 
                              foreach($_POST AS $key => $value) { 
                
                                $_POST[$key] = stripslashes(htmlentities($value));
                                

                               } 


                               $nomeCampoDecode = utf8_decode($_POST['Nome']);

                              // Se for Campo Eclesiastico
                               // atualiza os dados pela mudança das regras no meio do projeto
                               // Os usuarios agora serao campos eclesiastivos...
                               // Entao, se der continuidade da ideia original ( Campo - Congregacoes - Usuarios)
                               // O sistema ja é ajustavel e extensivel Ivinson jan / 2015

                               if(($_POST['selectPerfil'] == 6 ) || ($_POST['selectPerfil'] == 7 ) || ($_POST['selectPerfil'] == 4 )){
                                    //Primeiro grava na tabela de CAMPOS ECLESIASTICOS
                                    $sqlCampos = "UPDATE `campos` SET  
                                            `NomePastorTitular` =  '{$_POST['NomePastorTitular']}' ,  
                                            `TotalCongregacoes` =  '{$_POST['TotalCongregacoes']}' ,  
                                            `Membros`           =  '{$_POST['Membros']}' ,
                                            `BairroSede`        =  '{$_POST['Bairro']}' ,  
                                            `CidadeSede`        =  '{$_POST['Cidade']}' ,  
                                            `UFSede`            =  '{$_POST['UF']}' ,  
                                            `CEPSede`           =  '{$_POST['CEP']}' ,  
                                            `Pais`              =  '{$_POST['Pais']}' , 
                                            `Telefone1Sede`     =  '{$_POST['Telefone1']}' ,  
                                            `Telefone2Sede`     =  '{$_POST['Telefone2']}' ,                           
                                            `Celular1Sede`      =  '{$_POST['Celular1']}' ,  
                                            `Celular2Sede`      =  '{$_POST['Celular2']}'   ,
                                            `Nome`              =  '{$nomeCampoDecode}' ,  
                                            `Email`             =  '{$_POST['Email']}',
                                            `EnderecoSede`      =  '{$_POST['Endereco']}',
                                            `idRegiao`          =  '{$_POST['selectRegiao']}'
                                            
                                            


                                             WHERE `id` = '{$_POST['idCampo']}' ";  

                                    if (! $db->query($sqlCampos) ){
                                      die( ':: Erro : '. $db->errorInfo()[2]); 
                                      echo "Fase de teste : Anote o seguinte erro!";
                                    };
                                }


                                $textArea =  trim( $_POST['Observacao']); 


                                  //PREPARA AS VARIAVEIS DE DATA
                                  //INICIO                                                                           
                                  $parts1 = explode('/', $_POST['DataInicio']);
                                  $dateInicio1  = "$parts1[2]-$parts1[1]-$parts1[0]";

                                //GRAVA DADOS DOS USUARIOS
                                $sql = "UPDATE `usuarios` 
                                SET  `Nome`   =  '{$nomeCampoDecode}' ,  
                                `Email`       =  '{$_POST['Email']}' ,  
                                `Senha`       =  '{$_POST['Senha']}' ,  
                                `CPF`         =  '{$_POST['CPF']}' ,  
                                `Sexo`        =  '{$_POST['Genero']}' ,  
                                  
                                -- `idCongregacao` =  '{$_POST['selectCongregacao']}' ,  
                                `idProjetos`    =  '{$_POST['selectProjeto']}' , 
                                `idTipoUsuario` =  '{$_POST['selectPerfil']}' ,  
                                `Endereco`      =  '{$_POST['Endereco']}' , 
                                `Bairro`        =  '{$_POST['Bairro']}' ,  
                                `Cidade`        =  '{$_POST['Cidade']}' ,  
                                `UF`            =  '{$_POST['UF']}' ,  
                                `CEP`           =  '{$_POST['CEP']}' ,  
                                `Pais`          =  '{$_POST['Pais']}' , 
                                `Telefone1`     =  '{$_POST['Telefone1']}' ,  
                                `Telefone2`     =  '{$_POST['Telefone2']}' , 
                                `Celular1`      =  '{$_POST['Celular1']}' ,  
                                `Celular2`      =  '{$_POST['Celular2']}', 
                                 observacao     =  '{$textArea}' ,
                                `DataInicio`    =  '{$dateInicio1}',
                                `NomePastor`    = '{$_POST['NomePastorTitular']}',
                                `cartazes`      = '{$_POST['cartazes']}' 
                                
                                   WHERE `id` = '$id' "; 

                                if (! $db->query($sql) ){

                                  die( ':: Erro : '. $db->errorInfo()[2]); 
                                  echo "Fase de teste : Anote o seguinte erro!";
                                  echo $sql;

                               };


                                include "logger.php";
                                Logger("{$_SESSION['nome']} [ID::{$_SESSION['idlogado']}] atualizou o cadastro de {$_POST['Nome']} [ID::{$id}] ");                               

                                //sleep(3);

                               //echo "<input type='hidden' value='1' name='fSuccess' /> ";
                               //header("Location: http://www.pagina.com.br/pagina.php");
                               
                               Redirect("listar-usuarios.php",false); 

                          } 


                           
                           $row = $db->query("SELECT u.*,
                           c.NomePastorTitular, 
                           c.TotalCongregacoes, 
                           c.Membros, c.id as idCampo 
                           ,r.Nome as NomeRegiao
                           ,r.id as IDREGIAO
                           FROM usuarios u join 
                                congregacoes congreg on(congreg.id = u.idCongregacao) join 
                                campos c on(c.id = congreg.idCampo) join
                                regioes r on (c.idRegiao = r.id)


                                WHERE u.id = '$id' ")->results(true) ; 
                          
                          ?>                 
 
          <form role="form" action='' method='POST'> 
 

                  <div class="row">

                    <div class="col-lg-3">

                            <div class="form-group">
                                <label>Nome</label>
                                <input class="form-control" name='Nome'  value='<?= stripslashes($row['Nome']) ?>'>                                
                            </div>




<div class="form-group">
                <label>Regiao</label>
        <?php 
        echo "<select  data-placeholder=\"Escolha um usuário... \" id=\"selectRegiao\"    \" name=\"selectRegiao\" class=\"form-control\" class=\"chosen-select\" 
         />";

            
            //Lista Apenas Campos Eclesiáticos                                
            $resultSelect = $db->query("
                                           
                      select '' as id,' Escolha uma Regiao ' as Nome
                      union
                       Select id, Nome  from regioes

                                            
                ")->results(true) or 
                    trigger_error($db->errorInfo()[2]); 
                    
                    foreach($resultSelect as $rowOption ){ 
                                      foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                                        echo "<option " . (stripslashes($row['IDREGIAO'])==$rowOption['id'] ? ' selected ' : '') ."  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                                      //echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                                      } 
                    echo "</select>";
        ?>                                             
            </div>


                            <div  style="display:none ;" class="form-group">
                                <label>Congresgação</label>
                                

                                  <select  class="form-control" id="selectCongregacao"  name="selectCongregacao" class="chosen-select">
                                    <?php 
                                      
                                      $resultSelect = $db->query("select IGR.id as ID, concat (C.Nome,' - ', IGR.TipoCongregacao) as Nome  from congregacoes IGR
                                                                    JOIN campos C ON ( C.id = IGR.idcampo)
                                                                    order by C.Nome")->results(true) or trigger_error($db->errorInfo()[2]); 
                                      foreach($resultSelect as $rowOption ){ 
                                      foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                                        echo "<option " . (stripslashes($row['idCongregacao'])==$rowOption['ID'] ? ' selected ' : '') ."  value='". nl2br( $rowOption['ID']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                                      } 
                                      
                                      ?> 


                                  </select>                                
                            </div>


                            <div class="form-group">
                                <label>Perfil</label>
                                  <select class="form-control" id="selectPerfil"  name="selectPerfil" class="chosen-select">
                                    <?php 
                                                                            
                                      $resultSelect = $db->query(" select * from tipousuario ")->results(true) or trigger_error($db->errorInfo()[2]);                                   
                                      foreach($resultSelect as $rowOption){ 
                                      foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                                        //echo "<option " . (stripslashes($row['idTipoUsuario'])==$rowOption['ID'] ? ' selected ' : '') ."  value='". nl2br( $rowOption['ID']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                                      echo "<option " . (stripslashes($row['idTipoUsuario'])==$rowOption['id'] ? ' selected ' : '')  . "  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                                      } 
                                      
                                      ?> 

                                  </select>

                                 <input type='hidden' name='idTipoUsuario' value='<?= stripslashes($row['idTipoUsuario']) ?>' /> 
                                
                            </div> 



                    </div>

                    <div class="col-lg-3">

                            <div class="form-group">
                                <label>Email</label>                                
                                <input class="form-control" type='text' name='Email' value='<?= stripslashes($row['Email']) ?>' /> 
                            </div>


                            <div class="form-group">
                                <label>Gênero</label>                                
                                   <select  name="Genero" id="Genero" class="form-control" >
                                      <option   '<?= (stripslashes($row['Sexo'])=='Masculino' ? ' selected ' : '') ?>'  value="Masculino"> Masculino</option>
                                      <option   '<?= (stripslashes($row['Sexo'])=='Feminino' ? ' selected ' : '') ?>'  value="Feminino"> Feminino</option>
                                   </select>

                                   <input type='hidden' name='Sexo' value='<?= stripslashes($row['Sexo']) ?>' /> 

                                  <?php
                                  //Data de Nascimento
                                  //$dataNascimento = $row['DataNascimento'];
                                  //echo "<br>" . $dataNascimento;


                                  //$parts = explode('-', $dataNascimento);
                                  //$dateNascimento  = "$parts[2]/$parts[1]/$parts[0]";
                                  //echo "<br><h3> Data vizualização =  ". $dateNascimento ." </h3>"

                                  ?>                                  
                            </div>    

                            <div class="form-group">
                                <label>Projetos</label>
                                  <select   class="form-control" id="selectProjeto" name="selectProjeto"  class="chosen-select">

                                    <?php 
                                      
                                      
                                      $resultSelect2 = $db->query(" select * from projetos ")->results(true) or trigger_error($db->errorInfo()[2]);                                   
                                      foreach($resultSelect2 as $rowOption){ 
                                      foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                                        echo "<option " . (stripslashes($row['idProjetos'])==$rowOption['id'] ? ' selected ' : '') ."  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                                      } 
                                      
                                      ?> 

                                  </select>

                                <input type='hidden' name='idProjetos' value='<?= stripslashes($row['idProjetos']) ?>' /> 
                               
                            </div>  





                    </div>



                    <div class="col-lg-3">
                         

                       

                            <div class="form-group">
                                <label>Senha</label>
                                <input class="form-control" type='text' name='Senha' value='<?= stripslashes($row['Senha']) ?>' />
                            </div>


               <?php
                                  //PREPARA AS VARIAVEIS DE DATA
                                  //Data de Vigencia (Inicio)                                                                           
                                  $parts = explode('-', $row['DataInicio']);
                                  $dateInicio  = "$parts[2]/$parts[1]/$parts[0]";

                                  ?>

                                  
                            <div class="form-group">
                                <label>Iniciado em </label>
                                <input class='form-control'  id="DtInicio" type='text' name='DataInicio' value='<?= $dateInicio ?>' />
                            </div>                               

                            <div style="display:none !Important;"  class="form-group">
                                <label>Data Nascimento</label>                               
                                <input  class="form-control" id="datepicker" type='text' name='DataNascimento' value='<?= $dateNascimento ?>' />
                            </div>

                            <div class="form-group">
                                <label>CPF</label>                                
                                <input class="form-control" type='text' name='CPF' value='<?= stripslashes($row['CPF']) ?>' />
                            </div>

                  </div>
                  </div>


                  <div  id='dvCamposPerfil' style="display:none !Important;" class="row">
                 
                    <div class="col-lg-3">          
                            <div class="form-group">
                                <label>Nome Pastor</label>                                
                                <input class='form-control' type='text' name='NomePastorTitular' value='<?= stripslashes($row['NomePastorTitular']) ?>' />                               
                            </div>
                    </div>
                    <div class="col-lg-2">          
                            <div class="form-group">
                                <label>Total de Igrejas</label>                                
                                <input class='form-control' type='text' name='TotalCongregacoes' value='<?= stripslashes($row['TotalCongregacoes']) ?>' />                               
                            </div>
                    </div>
                    <div class="col-lg-2">          
                            <div class="form-group">
                                <label>Total de Membros</label>                                
                                <input class='form-control' type='text' name='Membros' value='<?= stripslashes($row['Membros']) ?>' />                               
                                <input type='hidden' name='idCampo' value='<?= stripslashes($row['idCampo']) ?>' /> 
                            </div>
                    </div>                    

                 

                    <div class="col-lg-2">          
                            <div class="form-group">
                                <label>Total de cartazes</label>                                
                                <input class='form-control' type='text' name='cartazes' value='<?= stripslashes($row['cartazes']) ?>' />                               
                                
                            </div>
                    </div>                    

                  </div>




                  <div class="row">
                    <div class="col-lg-6">
                      <h3> Endereço</h3>  

                            <div class="form-group">
                                <label>Endereco</label>
                                
                                <input class='form-control' type='text' name='Endereco' value='<?= stripslashes($row['Endereco']) ?>' />
                               
                            </div>



                            <div class="form-group">
                                <label>Cidade</label>
                                <input class='form-control' type='text' name='Cidade' value='<?= stripslashes($row['Cidade']) ?>' /> 
                            </div>



                            <div class="form-group">
                                <label>CEP</label>
                                <input class='form-control' type='text' name='CEP' value='<?= stripslashes($row['CEP']) ?>' />
                            </div>



                            <div class="form-group">
                                <label>Telefones</label>
                                <br>
                                <input class="form-control" type='text' name='Telefone1' value='<?= stripslashes($row['Telefone1']) ?>' />
                                <p class="help-block">Digite acima seu telefone Residencial</p>
                                <input class="form-control" type='text' name='Telefone2' value='<?= stripslashes($row['Telefone2']) ?>' /> 
                                <p class="help-block">Digite acima seu telefone Escritório</p>
                                <input class="form-control" type='text' name='Celular1'  value='<?= stripslashes($row['Celular1'])  ?>' />
                                <p class="help-block">Digite acima seu telefone Celular</p>
                                <input class="form-control" type='text' name='Celular2'  value='<?= stripslashes($row['Celular2'])  ?>' />
                                <p class="help-block">Digite acima seu telefone Celular</p>
                            </div>

                            <div style="display:none !Important;" class="form-group">
                                <label>Contibui ?</label>
                                 <?php  //preenche o  radio de Ativo

                                    //if(!stripslashes($row['Ativo'])=='') or {

                                        if(stripslashes($row['Contribuicao'])== 1){

                                          echo "  <b>SIM:</b> <input type='radio' name='rbContribui'  checked='checked' />";
                                          echo "  <b>NÃO:</b> <input   type='radio' name='rbContribui'  />";

                                        }else{

                                          echo "  <b>SIM:</b> <input  type='radio' name='rbContribui'   />";
                                          echo "  <b>NÃO:</b> <input  type='radio' name='rbContribui'  checked='checked' />";
                                        }
                                    ?>
                                
                            </div>


                                <?php



                                  //Data de Vigencia (Termino)                                                                           
                                  $parts = explode('-', $row['DataFim']);
                                  $dateDataFim  = "$parts[2]/$parts[1]/$parts[0]";

                                  //Data de Vigencia (Vencimento prarametral)                                                                           
                                  $parts = explode('-', $row['DataVencimento']);
                                  $dateVencimento  = "$parts[2]/$parts[1]/$parts[0]";
                                ?>  



                    </div>

                    <div class="col-lg-6">
                      <br><br><br>

                            <div class="form-group">
                                <label>Bairro</label>
                                 <input class='form-control' type='text' name='Bairro' value='<?= stripslashes($row['Bairro']) ?>' />
                            </div>

                            <div class="form-group">
                                <label>UF</label>
                                <input class='form-control' type='text' name='UF' value='<?= stripslashes($row['UF']) ?>' />
                            </div>

                            <div class="form-group">
                                <label>País</label>
                                <input class='form-control' type='text' name='Pais' value='<?= stripslashes($row['Pais']) ?>' />
                            </div> 

                            <div class="form-group">
                                <label>Observações</label>
                                 <textarea 
                                 class="form-control" 
                                 name='Observacao'  rows="11"> 
                                 <?= rtrim(stripslashes($row['observacao'] )) ?> 

                               </textarea>
                                
                            </div>  



                    </div>
                  </div>



                  <div  style="display:none !Important;" class="row">

                    <h3> Contribuições </h3>

                    <div class="col-lg-3">

                         


                            <div class="form-group">
                                <label>Periodos</label>
                                <input type='hidden' id='valuePeriocidade' name='valuePeriocidade' value='<?= stripslashes($row['Periocidade']) ?>' /> 
                                <select class='form-control'   id="selectPeriodicidade"  name="selectPeriodicidade" class="chosen-select">
                                    <option  value="30">Mensal</option>
                                    <option  value="60">Bimestral</option>
                                    <option  value="90">Trimestral</option>
                                    <option  value="180">Semestral</option>
                                    <option  value="360">Anual</option>
                                </select>
                            </div>                              



                    </div>
                    <div class="col-lg-3">
                            <div class="form-group">
                                <label>dt Termino</label>
                                <input class='form-control'  type='text' id="DtFim" name='DataFim' value='<?= $dateDataFim ?>' />
                            </div>



                      

                    </div>
                    <div class="col-lg-3">

                            <div class="form-group">
                                <label>Data Vencimento</label>
                                <input class='form-control'  id="DtVencimento" type='text' name='DataVencimento' value='<?= $dateVencimento ?>' /> 
                            </div>


                    </div>
                    <div class="col-lg-3">

                            <div class="form-group">
                                <label>Forma Contribuição</label>
                                <select  class='form-control' id="selectFormaContribuicao"  name="selectFormaContribuicao" class="chosen-select">
                                    <option value="Boleto">Boleto Bancário</option>
                                    <option disabled value="Cartão">Cartão de Crédito</option>
                                </select>
                                

                            </div>

                    </div>

                  </div>

      
                    


                  <div class="row">

                    <div class="col-lg-12">



                            <input class="btn btn-lg btn-success" type='submit' value='Gravar alterações' />                        
                            <input class="btn btn-lg btn-info" onclick='history.back(-1)' value='Voltar' />
                            
                            <input type='hidden' value='1' name='submitted' /> 
                            

                            <p><br><br><br></p>
                            <p></p>
                            <p></p>



                        </form>


<?php 

include "logger.php";
Logger("{$_SESSION['nome']} [ID::{$_SESSION['idlogado']}] acessou o cadastro de {$row['Nome']} [ID::{$id}] ");





}


 ?> 


                    </div>
                  </div>

               



<?php include("footer.php")    ; ?>


<script type="text/javascript">

 $(function() {
    $( "#datepicker"   ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#DtFim"        ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#DtInicio"     ).datepicker({ dateFormat: 'dd/mm/yy' });
    $( "#DtVencimento" ).datepicker({ dateFormat: 'dd/mm/yy' });

    //Inicializa Perfil de campos que vem da tabelas de cmapos elesiasticos
    var fPerfil = $('#selectPerfil').val();
    //alert(fPerfil);
    if((fPerfil == 6)|| (fPerfil == 4) || (fPerfil == 7) || (fPerfil == 5)){
      $( "#dvCamposPerfil" ).show( "slow", function() {
        // Animation complete.
      });
    };




  });



//Atualiza valores da periodicidade
$(function(){
    var hv = $('#valuePeriocidade').val();
    $('#selectPeriodicidade option[value='+hv+']').attr('selected','selected');
    $('#selectPeriodicidade').trigger('chosen:updated');
});




//Caso o PERFIL seja CAMPO Eclesiastico
//Habilitar os seguintes campos da tabela CAMPOS
//Nome do Pastor
//Total de Congregações
//Total de Membros
$('#selectPerfil').change(function () {
   var perfil  = $('#selectPerfil').val();

   //alert(perfil);
   if((perfil == 6)|| (perfil == 4) || (perfil == 7) || (perfil == 5)){
    //alert("Campo Eclesiastico");
    $( "#dvCamposPerfil" ).show( "slow", function() {
    // Animation complete.
    });

   } else
   {
    $( "#dvCamposPerfil" ).hide( "slow", function() {
        // Animation complete.
      });

   }



});



</script>