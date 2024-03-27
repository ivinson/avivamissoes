<?php 
    include("header.php")    ;
    include('config.php');  

 ?>


<form role="form" action='' method='POST'> 
                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Campos TRANCULTURAIS
                            <small id="lblRegiao"></small>
                        </h1>
                   
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">

                    <div class="col-lg-6">
                       
                        
                        <br>

                      </div>
                      <div class="col-lg-6">
                      
                             
                            <input class="btn btn btn-info" onclick='javascript:imprimirPDF()' value='Imprimir Posição' />

                      </div>

                    </div>

                <div class="row">

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover" id="tbregiao">
                                <thead>
                                    <tr>
                                        <th>Campo</th>
                                        <th>Email</th>
                                        <th>Telefones</th>
                                        <th>Congregações</th>
                                        

                                        
                                    </tr>
                                </thead>
                                <tbody>  

<?php
    
   
    
            
            $result = mysql_query(" select u.*, c.TotalCongregacoes,c.Membros  from  campos c 
                                      join congregacoes cg on (cg.idCampo = c.id )
                                      join usuarios u on (u.idCongregacao = cg.id)
                                      where 

                                       u.idTipoUsuario = 5 -- inativos
                                        order by u.Nome
                                       "
                                      )
            or die("Query fail: " . mysqli_error());


                   while($rowOption = mysql_fetch_array($result)){ 
                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                              
                              //echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";   

                              $envelope = ceil(  porcentagem_xn(45,$rowOption['Membros']) );                            
                          

                            echo "<tr>
                                        <td><a href='editar-usuarios.php?id={$rowOption['id']}'> {$rowOption['Nome']} </a></td>
                                        <td>{$rowOption['Email']}</td>
                                        <td>{$rowOption['Telefone']}  {$rowOption['Telefone1']}  {$rowOption['Celeular']}  {$rowOption['Celeular1']}</td>                                        
                                        <td>{$rowOption['TotalCongregacoes']}</td>
                                       
                                    </tr> ";


                          } 


        
    ?>                                                              
                                    


                                </tbody>
                            </table>
                        </div>


                                     
                            
                <input type='hidden' value='1' name='submitted' />
                <input type='hidden' value='<?php echo $_POST['selectRegiao']; ?>' name='hddRegiao' id ="hddRegiao" /> 

                

                </div>
                </div>
                <!-- /.row -->

  </form>             

<?php 

// Função de porcentagem: Quanto é X% de N?
function porcentagem_xn ( $porcentagem, $total ) {
	return ( $porcentagem / 100 ) * $total;
}

include("footer.php")    ; ?>

<script type="text/javascript">
	function imprimirPDF(){


    var docprint = window.open("about:blank", "_blank"); 
    var oTable = document.getElementById("tbregiao");
    var oRegiao = $("#hddRegiao").val();
    //alert(oRegiao);
    //alert()
    //alert($('#selectRegiao option[value="'+oRegiao+'"]').text());
    //var oTitulo = $('#selectRegiao value=["'+oRegiao+'"]').text();
    //alert(oTitulo);
    //var option_user_selection = oRegiao.options[ oRegiao.sele].text;
    //Alert(option_user_selection);
    var oTitulo = "";


    docprint.document.open(); 
    docprint.document.write('<html><head><title>'+ oTitulo +'</title>'); 
     docprint.document.write("'<link href='css/bootstrap.min.css' rel='stylesheet'>");
    docprint.document.write('</head><body><center>');
    docprint.document.write('<h1>'+oTitulo+' </h1>');    
    docprint.document.write(oTable.parentNode.innerHTML);
    docprint.document.write('</center></body></html>'); 
    docprint.document.close(); 
    docprint.print();
    docprint.close();


	}	


</script>