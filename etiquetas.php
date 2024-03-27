<?php 
    include("header.php")    ;
    include('config.php');  

 ?>


<form role="form" action='' method='POST'> 
                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Emissão de Etiquetas <br>
                            <small id="lblRegiao"> Escolha uma região para imprimir as estiquetas de correspondencia</small>
                        </h1>
                   
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">

                    <div class="col-lg-6">
                       
                        <select  class="form-control input-lg" id="selectRegiao"  
                            name="selectRegiao" class="chosen-select"  >
                        <?php               
                        
                            $resultSelect = mysql_query("select * from regioes where id 
                                                          union
                                                          select '0','','Selecione uma região clicando aqui','',0
                                                           from regioes 
                                                           order by ordem
                                                        ") or trigger_error(mysql_error()); 
                            while($rowOption = mysql_fetch_array($resultSelect)){ 
                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                              echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                          } 
                          
                          ?> 
                        </select>  
                        <br>

                      </div>
                      <div class="col-lg-6">
                      
                             
                         

                      </div>

                    </div>

                <div class="row">

                    <div class="col-lg-12">
                     
     
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
    docprint.document.write('</head><body><center>');
    docprint.document.write('<h1>'+oTitulo+' </h1>');    
    docprint.document.write(oTable.parentNode.innerHTML);
    docprint.document.write('</center></body></html>'); 
    docprint.document.close(); 
    docprint.print();
    docprint.close();


	}	



$("#selectRegiao").change(function() {
    var id = $("#selectRegiao option:selected").index()
    window.open('/fpdf/etiqueta.php?idRegiao='+id, '_blank');
});

</script>