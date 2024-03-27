<?php 

  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
      
?>

<style type="text/css">

.Vencida{    
    width: 110px;
    padding: 1px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: red;
    color: white;
}

.AVencer{    
    width: 110px;
    padding: 1px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: green;
    color: white;
}

.rejeitado{    
    width: 110px;
    padding: 2px;
    border: 1px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: #FF9A0B;
    color: black;
}

.Recebida{    
    width: 110px;
    padding: 2px;
    border: 2px solid white;
    border-radius: 8px;
    margin: 0; 
    background-color: blue;
    color: white;
}

</style>

                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                        <img src="icon-boleto.jpg" width="100" height="100">

                            Ofertas Pastorais
                            <small>Listagem de boletos </small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Contas a receber
                            </li>
                              <li>
                                <i class="fa fa-dashboard"></i>  <a href="wizard-boleto.php">Emitir boleto</a>
                            </li>
                        </ol>
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="datatable-tools">
                            <table class="table " id="tbUsuarios">
                                <thead>
                                    <tr>
                                        <th>  </th>
                                        <th>Emitido em</th>
                                        <th>Nº Documento</th>
                                        <th>Campo</th>
                                        <th>Valor</th>
                                        <th>Referente á </th>
                                        <!-- <th>Estado </th> -->
                                        <th></th>

                                    </tr>

                                    <?php 
                                    //Lista os contas a Receber
                                    echo "<tr>";

                                        
                                        
                                    //Lista Apenas Campos Eclesiáticos                                

                                    $resultSelect = mysql_query("
                                          select 
                                              DATEDIFF( cr.DataEmissao, curdate()) as DiasAtraso
                                              ,DATE_FORMAT(cr.DataReferencia, '%m/%Y') AS Referente
                                              ,DATE_FORMAT(cr.DataEmissao, '%d/%m/%Y') AS DataEmissaoF
                                              ,cr.*, u.*, cr.Valor as ValorBoleto

                                               from contasreceber cr
                                              join usuarios u on (u.id = cr.idusuario)

                                              order by cr.id desc

                                              limit 1000


                                      ") or trigger_error(mysql_error()); 

                                          while($rowOption = mysql_fetch_array($resultSelect)){ 
                                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                                              echo "<tr>";



                                              //Calcula o indicador de vencidos, a vencer e recebidos  
                                              if( $rowOption['Status'] == "Pendente" ){

                                                $diasAtraso =  $rowOption['DiasAtraso'] * -1;
                                              
                                                  if($diasAtraso > 25 ){
                                                       echo "<td> <div data-toggle='tooltip' data-placement='left' title='Esse boleto está Vencido porque seu vencimento 
                                                       \n está registrado para ". nl2br( $rowOption['DataVencimentoBoleto']) ." e até o 
                                                       \n momento não consta baixa em nosso sistema. 
                                                       \n '  class='Vencida'>";  
                                                       echo "<i class='fa fa-frown-o'></i></i> VENCIDA </div></td>";
                                                  }else{

                                                       echo "<td> <div title='Esse boleto está aguardando seu vencimento que
                                                       \n está registrado para ". nl2br( $rowOption['DataVencimentoBoleto']) ." e até o 
                                                       \n momento não consta baixa em nosso sistema. 
                                                       \n '  class='AVencer'>";  
                                                       echo "<i class='fa fa-spinner'></i></i> EM ABERTO </div></td>";
                                                  }
                                              }else if( $rowOption['Status'] == "Rejeitado" ){


                                                   # REJEITADO pela o valor da baixa estar em branco                                                                                                  
                                                   echo "<td> <div title='Esse boleto foi REJEITADO  
                                                   \n   em ". nl2br( $rowOption['DataBaixa']) ." Entre em contato com o banco e avise o campo. 
                                                   \n . 
                                                   \n '  class='rejeitado'>";  
                                                   echo "<i class='fa fa-arrow-down'></i></i> <b>REJEITADO </b> </div></td>";

                                              }else {                                              

                                                  # RECEBIDO pela o valor da baixa estar em branco                                                                                                  
                                                   echo "<td> <div title='Esse boleto foi Recebido e 
                                                   \n  baixado em ". nl2br( $rowOption['DataBaixa']) ." 
                                                   \n . 
                                                   \n '  class='Recebida'>";  
                                                   echo "<i class='fa fa-check-square'></i></i> RECEBIDO </div></td>";



                                              }   

                                              echo "<td>". nl2br( $rowOption['DataEmissaoF']) ."</td>";
                                              $boolProrec="";
                                              if($rowOption['idProjeto'] == 3){
                                                 $boolProrec =  "<span class=\"label label-success arrowed \">proRec</span>";
                                              }
                                              echo "<td>". nl2br( $rowOption['NossoNumero']) ." {$boolProrec}</td>";
                                              

                                              echo "<td><b>". nl2br( $rowOption['Nome']) ."</b></td>";
                                              echo "<td style='color:blue;' ><b> R$ ". nl2br( number_format( $rowOption['ValorBoleto'], 2)) ."</b></td>";
                                              echo "<td>". nl2br( $rowOption['Referente']) ."</td>";
                                              
                                              
                                              echo "</tr>";

                                              //echo "<option value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                                          } 



                                    echo "</tr>";
                                                                                
                                    ?>  


                                    <tr>


                                        <td></td>
                                        <td></td>
                                        <td></td>


                                    </tr>
                                                               
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>

               

<?php include("footer.php")    ; ?>

<script type="text/javascript">

    


</script>                