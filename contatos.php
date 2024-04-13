  <?php session_start();
  include("header.php"); 
  include('config.php');  
  include('scripts/functions.php'); 
  ?>
<style>
.wrapper
{
    width: 98%;
    margin: 0 auto;
}

    .wrapper h1
    {
        color: #555;
        text-align: center;
        text-shadow: rgba(0, 0, 0, 0.15) 0px 0px 1px;
        letter-spacing: 2px;
    }

#conutries
{
    width: 98%;
    background: white;
}

.alphabet
{
    margin: 0 0 10px;
    overflow: hidden;
}

    .alphabet a, #countries-table tr
    {
        transition: background-color 0.3s ease-in-out;
        -moz-transition: background-color 0.3s ease-in-out;
        -webkit-transition: background-color 0.3s ease-in-out;
    }

    .alphabet a
    {
        width: 20px;
        float: left;
        color: #333;
        cursor: pointer;
        height: 20px;
        border: 1px solid #CCC;
        display: block;
        padding: 2px 2px;
        font-size: 14px;
        text-align: center;
        line-height: 20px;
        text-shadow: 0 1px 0 rgba(255, 255, 255, .5);
        border-right: none;
        text-decoration: none;
        background-color: #F1F1F1;
    }

        .alphabet a.first
        {
            border-radius: 3px 0 0 3px;
        }

        .alphabet a.last
        {
            border-right: 1px solid silver;
            border-radius: 0 3px 3px 0;
        }

        .alphabet a:hover,
        .alphabet a.active
        {
            background: #FBF8E9;
            font-weight: bold;
        }
    </style>

<?php 

$resultSelect = $db->query("
  SELECT usuarios.Nome , usuarios.Telefone1, usuarios.Telefone2, usuarios.Email,usuarios.id , campos.NomePastorTitular as Pastor
 from usuarios 
 join congregacoes on (congregacoes.id = usuarios.idCongregacao)
 join campos on (campos.id = congregacoes.idCampo)

 where usuarios.idTipoUsuario <> 8 -- inativos
 order by Nome

")->results(true) or trigger_error($db->errorInfo()[2]); 

?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            
            <small>Lista de Contatos  </small>
        </h1>
    </div>
</div>
       

<div class="wrapper">

<div class="alphabet">
            <a class="first" id="primeiro" href="#">A</a>
            <a href="#">B</a>
            <a href="#">C</a>
            <a href="#">D</a>
            <a href="#">E</a>
            <a href="#">F</a>
            <a href="#">G</a>
            <a href="#">H</a>
            <a href="#">I</a>
            <a href="#">J</a>
            <a href="#">K</a>
            <a href="#">L</a>
            <a href="#">M</a>
            <a href="#">N</a>
            <a href="#">O</a>
            <a href="#">P</a>
            <a href="#">Q</a>
            <a href="#">R</a>
            <a href="#">S</a>
            <a href="#">T</a>
            <a href="#">U</a>
            <a href="#">V</a>
            <a href="#">W</a>
            <a href="#">X</a>
            <a href="#">Y</a>
            <a class="last" href="#">Z</a></div>


  
                         
<div id="conutries" class="table-responsive">
<table  class="table table-bordered table-hover" id="countries-table">
<thead>
<tr>
<th>
Nome</th>
<th>
Telefone</th><th>Email </th> <th> Novo contato </th>
</tr>

</thead>

<tbody>

<?php 





foreach($resultSelect as $rowOption ){ 
foreach($rowOption AS $key => $value) { $rowOption[$key] = stripslashes($value); }                                             
  //echo "<li ><a  href='lancamentos-campo.php?id={$id}&ano={$rowOption['Ano']}'>{$rowOption['Ano']} </a></li>";              


echo "<tr>
<td><a href='editar-usuarios.php?id={$rowOption['id']}'>{$rowOption['Nome']} <p><label>({$rowOption['Pastor']})<label></p></a></td>
<td>{$rowOption['Telefone1']} /{$rowOption['Telefone2']} </td>
<td>{$rowOption['Email']}</td>
<td> <a href='follow-up.php?id={$rowOption['id']}'> Follow-up </a></td>

</tr> ";


}


?>



</tbody>
</table>
</div>
</div>

    <!-- Include JavaScript -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>



<?php include("footer.php"); ?>

<script type="text/javascript" >

$(function () {
    var _alphabets = $('.alphabet > a');
    var _contentRows = $('#countries-table tbody tr');

    _alphabets.click(function () {
        var _letter = $(this), _text = $(this).text(), _count = 0;


        _alphabets.removeClass("active");
        _letter.addClass("active");

        _contentRows.hide();
        _contentRows.each(function (i) {
            var _cellText = $(this).children('td').eq(0).text();
            if (RegExp('^' + _text).test(_cellText)) {
                _count += 1;
                $(this).fadeIn(400);
            }
        });
    });
});



$("document").ready(function() {
    setTimeout(function() {
        $("#primeiro").trigger('click');
    },10);
});

</script>