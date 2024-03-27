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

.Recebida{    
    width: 110px;
    padding: 2px;
    border: 1px solid white;
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
                          <img src="inadimplentes.jpg" width="100" height="100">
                           
                            Relatório de FollowUP<br>
                            <small>Para pesquisar um nome, aperte <bb>Ctrl+F </b></small>
                        </h1>
 
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">

                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right fa-fw"></i> 
                                    Listagem</h3>
                                    <div class="panel-body">
<!-- HTML -->
                        

                                    <?php

                                        $rsCampos = mysql_query("
                                            select * from usuarios  where Follow <> '' 
                                             order by Nome ") ;

                                        


                                            while($rowCampos = mysql_fetch_array($rsCampos)){                                             
                                                foreach($rowCampos AS $key => $value) { $rowCampos[$key] = stripslashes($value); }                               
                                                                                    

                                                echo "                                                

                                                <a href='#' class='list-group-item'>
                                                <h3>
                                                    <i class='fa fa-fw fa-user'></i><span class='label label-success'> {$rowCampos['Nome']} </span> </h3>
                                                     
                                                ";

                                                     echo " <label>".nl2br($rowCampos['Follow'])."</label> </a> ";
                                                     echo "<hr>";



                                                

                                            }                                    

                                    ?>                                 


                                    </div>
                                <div class="text-right">
                                    
                                </div>
                            </div>
                        </div>
                    </div>   

                    </div>
                </div>

               

<?php include("footer.php")    ; ?>

<script type="text/javascript">

    $('select').on('change', function (e) {
      //var optionSelected = $("option:selected", this).value();
      window.location.href = "inadimplentes.php?idregiao=" + this.value;
    });


$(document).ready(function() {
    $('#chkMeses').change(function() {
        if($(this).is(":checked")) {          
            var url      = window.location.href;     // Returns full URL
            if(url.indexOf('?') >= 0){
                window.location.href = url + "&six=true";
            }else{window.location.href = url + "?six=true";}
        }
    });
});

</script>                