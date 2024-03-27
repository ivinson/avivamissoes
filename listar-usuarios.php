<?php
//if(isset($_SESSION['logado'])){
//echo "inside";
session_start();
if($_SESSION['logado'] <> "S"){

    //header("login.php");
    echo "<script language='JavaScript' type='text/JavaScript'> <!--
        window.location='login.php';
        //-->
        </script>";


}
include("header.php")    ;

  include "logger.php";
        Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] acessou listagem de campos .");

?>


                <!-- TITULO e cabeçalho das paginas  -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                          <img src="campos.jpg" width="100" height="100">
                            Usuários
                            <small>Listagem de usuarios</small>
                        </h1>
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.php">Início</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Listagem de Usuários
                            </li>
                             <li class="active">
                                <i class="fa fa-user"></i> <a href="novo-campo.php">Novo usuário</a>
                            </li>
                        </ol>
                    </div>
                </div>
                
                <!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="datatable-tools">
                            <table class="table table-bordered table-striped table-highlight table-hover" id="tbUsuarios">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nome</th>
                                        <th>NomePastor</th>
                                        <th>Email</th>
                                        <th>Cidade</th>
                                        <!-- <th>Estado </th> -->
                                        <th></th>

                                    </tr>
                                </thead>
                            </table>
                        </div>

                    </div>
                </div>

               

<?php include("footer.php")    ; ?>


<script type="text/javascript">


    $(document).ready(function() {
            var selected = [];                         
             $('#tbUsuarios').dataTable( {
                              
                  "processing": true,
                  "serverSide": true,
                  "sAjaxSource": "scripts/getUsuarios.php",
                  "order" : [[0,"desc"]],
                  "pagingType": "full_numbers",
                  "bDestroy": true,
                   "rowCallback": function( row, data, displayIndex ) {
                  if ( $.inArray(data.DT_RowId, selected) !== -1 ) {
                      $(row).addClass('selected');
                  }
              },
              "columnDefs": [ {
                  "targets": 5, 
                  "data": null,
                  "defaultContent": "<button id='btnEditar'>Editar</button> <button id='btnRemessa'>Remessas</button>"

              }]
    } );

    var lastIdx = null;
    var table = $('#tbUsuarios').DataTable();
     
    $('#tbUsuarios tbody')
        .on( 'mouseover', 'td', function () {
            var colIdx = table.cell(this).index().column;
 
            if ( colIdx !== lastIdx ) {
                $( table.cells().nodes() ).removeClass( 'highlight' );
                $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
            }
        } )
        .on( 'mouseleave', function () {
            $( table.cells().nodes() ).removeClass( 'highlight' );
        } );


          $('#tbUsuarios tbody').on( 'click', 'button', function () {
            

            if($(this).attr('id') == "btnRemessa"){

                var data = table.row( $(this).parents('tr') ).data();
                //console.log($(this).attr('id'));
                window.location.href = "lancamentos-campo.php?id="+ data[0];

            }else{

                var data = table.row( $(this).parents('tr') ).data();
                //console.log($(this).attr('id'));
                window.location.href = "editar-usuarios.php?id="+ data[0];

            }

          //$('#tbUsuarios tbody').on('click', 'tr', function () {  
              //console.log("botao clicado");

              var data = table.row( $(this).parents('tr') ).data();
              console.log($(this).attr('id'));
              //window.location.href = "editUsuario.php?id="+ data[0];
              //alert( data[0] +"'s salary is: "+ data[0] );
  

          } );
} );


</script>                