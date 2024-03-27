<?php 
include('config.php'); 


?>

<form role="form" action='' method='POST'> 
 <div class="row">
  <div class="col-lg-8">

       <div class="form-group">
              <label>Crédito/Débito </label>
              <select Onchange="viewOrigem();" id="selectOrigem" class="form-control" 
                      
                      name="selectOrigem" 
                      class="chosen-select">
                      <option value="C"> Crédito    </option> 
                      <option value="D"> Débito     </option> 
                      
                </select>                              
        </div>   


  </div>
  <div class="col-lg-4">
      <div class="form-group">
          <label>Valor</label>                              
            <br>
            <input class="form-control" name='Valor'  value=''>                                 
      </div>


   

  </div>
 </div>


 <div class="row">
  <div class="col-lg-8">
      <div id="dvOrigemOfertas" class="form-group">
          <label>Origem das entradas</label>                              
            <select  class="form-control" id="selectCongregacao"  name="selectCongregacao" class="chosen-select">
            <?php               
              $resultSelect = mysql_query("select IGR.id as ID, concat (C.Nome,' - ', IGR.TipoCongregacao) as Nome  from congregacoes IGR
                                            JOIN campos C ON ( C.id = IGR.idcampo)
                                            order by C.Nome") or trigger_error(mysql_error()); 
              while($rowOption = mysql_fetch_array($resultSelect)){ 
              foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                echo "<option " . (stripslashes($row['idCongregacao'])==$rowOption['ID'] ? ' selected ' : '') ."  value='". nl2br( $rowOption['ID']) ."'>". nl2br( $rowOption['Nome']) ."</option>";                                 
              } 
              
              ?> 
            </select>                                
      </div> 


      <div class="form-group">
          <label>Banco</label>                              
            <select  class="form-control" id="selectBanco"  name="selectCongregacao" class="chosen-select">
              <?php               
              $resultSelect = mysql_query("select * from contabancaria") or trigger_error(mysql_error()); 
              while($rowOption = mysql_fetch_array($resultSelect)){ 
              foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                               
                echo "<option  value='". nl2br( $rowOption['id']) ."'>". nl2br( $rowOption['Nome']) ." - ".nl2br( $rowOption['Banco']) ."</option>";                                 
              } 
              
              ?> 


            </select>                                
      </div>
  </div>
  <div class="col-lg-4">
       <div class="form-group">
              <label>Projeto </label>
              <select  class="form-control" id="selectCongregacao"  name="selectCongregacao" class="chosen-select">
             
              </select>                            
        </div>
  </div>
 </div>

 <div class="row">


  <div class="col-lg-6">

  </div>
  <div class="col-lg-6">
    
  <div style="height: 10px !Important;" class="form-group">
    <label>Data Referencia </label>
    </div> 


      <div class="form-group col-xs-6">
          
          <input class="form-control" placeholder="Mes">  
                                               
      </div>

      <div class="form-group col-xs-6">
                    
          <input class="form-control" placeholder="Ano">                         
      </div>

  </div>  
 </div>


  <div class="row">


  <div class="col-lg-12">
      <div class="form-group">
          <label>Descrição da Entrada / Debito</label>                              
          
            <textarea class="form-control" name="txtdescricao" rows="3"></textarea>  
  </div>

 </div>

</form>



<script type="text/javascript">




//Caso a Origem for despesa, o campo que vai mostrar é Origem de despesas
$('#selectOrigem').change(function () {
    //showOrigem();
 });



function showOrigem(){
   var fOrigem  = $('#selectOrigem').val();

   //alert(perfil);
   if(fOrigem== "C"){
    //alert("Campo Eclesiastico");
    $( "#dvOrigemOfertas" ).show( "slow", function() {
    // Animation complete.
    });
    $( "#dvOrigemDespesas" ).hide( "slow", function() {
    // Animation complete.
    });

   } else
   {
    $( "#dvOrigemOfertas" ).hide( "slow", function() {
        // Animation complete.
      });
    $( "#dvOrigemDespesas" ).show( "slow", function() {
        // Animation complete.
      });

   }



}
</script>


 
