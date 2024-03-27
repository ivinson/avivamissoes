<?php 
    include("header.php")    ;
    include('config.php'); 




    if (isset($_POST['submitted'])) { 
          foreach($_POST AS $key => $value) {  $_POST[$key] = mysql_real_escape_string(htmlentities($value));}
    

            //{$_POST['Membros']}' 


            //$mysql = mysql_connect(‘localhost’, ‘test’, ‘test’, false, 65536);
            //mysql_select_db(‘test’, $mysql);
            
            $result = mysql_query("call Inserir_Campo({$_POST['selectRegiao']}, '"
                .$_POST['NomeCampo']."', ".$_POST['QtdMembros'].");")
            or die("Query fail: " . mysqli_error());

              $res = mysql_query('SELECT last_insert_id() AS result');
                if ($res === false) {
                    echo mysql_errno().': '.mysql_error();
                }
                while ($obj = mysql_fetch_object($res)) {
                    //echo $obj->result;
                    //Redirect("editar-usuarios.php?id=".$obj->result,false); 
                    //header("editar-usuarios.php?id=".$obj->result);

                    Echo "<h1>Campo criado com sucesso.<br></h1>";
                    echo "<h3><a href='editar-usuarios.php?id=".$obj->result."'> Clique aqui </a> para contiuar seu cadastro.<h3>";
                    exit;
                }

        



    } 

 ?>


<form role="form" action='' method='POST'> 
                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Incluir novo Campo
                            <small></small>
                        </h1>
                        <ol class="breadcrumb">
                           
                        </ol>
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">

                    <div class="col-lg-6">
                        <h3>Qual a região?</h3>
                        <select  class="form-control input-lg" id="selectRegiao"  
                            name="selectRegiao" class="chosen-select"  >
                        <?php               
                        
                            $resultSelect = mysql_query("select * from regioes where id 
                                                          union
                                                          select '0','','Selecione uma região clicando aqui','',0
                                                           from regioes 
                                                           order by id
                                                        ") or trigger_error(mysql_error()); 
                            while($rowOption = mysql_fetch_array($resultSelect)){ 
                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                              echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                          } 
                          
                          ?> 


                        </select> <br>


                        <div class="form-group">
                                <label>Nome do Campo</label>                                
                                <input class='form-control input-lg' type='text' name='NomeCampo' value='' />                               
                        </div><br>

                        <div class="form-group">
                                <label>Quantos membros?</label>                                
                                <input class='form-control input-lg' type='text' name='QtdMembros' value='' />                               
                        </div>

                <input class="btn btn-lg btn-success" type='submit' value='Gravar alterações' />                        
                <input class="btn btn-lg btn-info" onclick='history.back(-1)' value='Voltar' />                
                <input type='hidden' value='1' name='submitted' /> 

                </div>
                </div>
                <!-- /.row -->

  </form>             

<?php include("footer.php")    ; ?>