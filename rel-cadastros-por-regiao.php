<?php 
    include("header.php")    ;
    include('config.php');  

 ?>


<form role="form" action='' method='POST'> 
                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                           Cadastros por Região 
                            <small id="lblRegiao"></small>
                        </h1>
                   
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">

                    <div class="col-lg-6">
                       
                        <select  class="form-control input-lg" id="selectRegiao"  
                            name="selectRegiao" class="chosen-select"  >
                        <?php               
                        
                            $resultSelect = $db->query("select * from regioes where id 
                                                          union
                                                          select '0','','Selecione uma região clicando aqui','',0
                                                           from regioes 
                                                           order by ordem
                                                        ")->results(true) or trigger_error($db->errorInfo()[2]); 
                            foreach( $resultSelect as $rowOption){ 
                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                              echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
                          } 
                          
                          ?> 
                        </select>  
                        <br>

                      </div>
                      <div class="col-lg-6">
                      
                            <input class="btn btn-lg btn-success" type='submit' value='Buscar ' />  
                            <input class="btn btn btn-info" onclick='javascript:imprimirPDF()' value='Imprimir Posição' />
                            <a style="margin-top: 8px;" href="javascript:fnExcelReport();" class="btn btn-sm btn-info"><i class="fa fa-file-excel-o"></i>  Excel</a>                       
                                      
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
                                        <th>Membros</th>
                                        <th>Envelopes(45%)</th>
                                        <th>Cartazes</th>

                                        
                                    </tr>
                                </thead>
                                <tbody>  

<?php
    
    if (isset($_POST['submitted'])) { 
          foreach($_POST AS $key => $value) {  $_POST[$key] = stripslashes(htmlentities($value));}
    

            //{$_POST['Membros']}' 


            //$mysql = mysql_connect(‘localhost’, ‘test’, ‘test’, false, 65536);
            //mysql_select_db(‘test’, $mysql);

         // echo "select u.*, c.TotalCongregacoes,c.Membros from  campos c 
          //                    join congregacoes cg on (cg.idCampo = c.id )
          //                    join usuarios u on (u.idCongregacao = cg.id)
                              //where c.idRegiao = {$_POST['selectRegiao']}";
            
            $result = $db->query(" select u.*, c.TotalCongregacoes,c.Membros  from  campos c 
                                      join congregacoes cg on (cg.idCampo = c.id )
                                      join usuarios u on (u.idCongregacao = cg.id)
                                      where c.idRegiao = {$_POST['selectRegiao']}
                                      and u.idTipoUsuario <> 8 -- inativos
                                        order by u.Nome 
                                       "
                                      )->results(true)
            or die("Query fail: " . $db->errorInfo()[2]);


                   foreach($result as $rowOption ){ 
                            foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                              
                              //echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ."</option>";   

                              $envelope = ceil(  porcentagem_xn(45,$rowOption['Membros']) );                            
                          

                            echo "<tr>
                                        <td><a href='editar-usuarios.php?id={$rowOption['id']}'> {$rowOption['Nome']} </a></td>
                                        <td>{$rowOption['Email']}</td>
                                        <td>{$rowOption['Telefone']}  {$rowOption['Telefone1']}  {$rowOption['Celeular']}  {$rowOption['Celeular1']}</td>                                        
                                        <td>{$rowOption['TotalCongregacoes']}</td>
                                        <td>{$rowOption['Membros']}</td>
                                        <td>{$envelope}</td>
                                        <td>{$rowOption['cartazes']}</td>
                                    </tr> ";


                          } 


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
    docprint.document.write('</head><body><center>');
    docprint.document.write('<h1>'+oTitulo+' </h1>');    
    docprint.document.write(oTable.parentNode.innerHTML);
    docprint.document.write('</center></body></html>'); 
    docprint.document.close(); 
    docprint.print();
    docprint.close();


	}	


function fnExcelReport()
{
    var tab_text="<table border='2px'><tr bgcolor='#87AFC6'>";
    var textRange; var j=0;
    tab = document.getElementById('tbregiao'); // id of table

    for(j = 0 ; j < tab.rows.length ; j++) 
    {     
        tab_text=tab_text+tab.rows[j].innerHTML+"</tr>";
        //tab_text=tab_text+"</tr>";
    }

    tab_text=tab_text+"</table>";
    tab_text= tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
    tab_text= tab_text.replace(/<img[^>]*>/gi,""); // remove if u want images in your table
    tab_text= tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

    var ua = window.navigator.userAgent;
    var msie = ua.indexOf("MSIE "); 

    if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))      // If Internet Explorer
    {
        txtArea1.document.open("txt/html","replace");
        txtArea1.document.write(tab_text);
        txtArea1.document.close();
        txtArea1.focus(); 
        sa=txtArea1.document.execCommand("SaveAs",true,"Say Thanks to Sumit.xls");
    }  
    else                 //other browser not tested on IE 11
        sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));  

    return (sa);
}


</script>