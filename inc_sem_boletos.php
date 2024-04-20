<!-- HTML -->
<?php
  include("config.php");
  include('scripts/functions.php');


  // Verifica se a solicitação é para carregar todos os registros
  if ($_GET['limit'] === 'all') {
      $query = "SELECT DISTINCT ud.id, ud.Nome 
          FROM usuarios ud 
          LEFT JOIN lancamentosbancarios lb ON ud.id = lb.idUsuario AND lb.TipoOrigem = 'CR'
          WHERE lb.idUsuario IS NULL";

  } else {
      $limit = (int)$_GET['limit']; // Número de registros a serem carregados
      $query = "SELECT DISTINCT ud.id, ud.Nome 
          FROM usuarios ud 
          LEFT JOIN lancamentosbancarios lb ON ud.id = lb.idUsuario AND lb.TipoOrigem = 'CR'
          WHERE lb.idUsuario IS NULL
          LIMIT $limit";
  }


  $rsCamposPagadores = $db->query($query)->results(true);

  // Exibição dos registros
  if ($rsCamposPagadores) {
    foreach ($rsCamposPagadores as $rowCamposPagadores) {
      foreach ($rowCamposPagadores as $key => $value) {
        $rowCamposPagadores[$key] = stripslashes($value);
      }

      echo "                                                

                <a href='follow-up.php?id={$rowCamposPagadores['id']}' class='list-group-item'>                                                   
                    <i class='fa fa-fw fa-user'></i> {$rowCamposPagadores['Nome']}
                    
                </a>";
    }
  } else {
    echo "Nenhum registro encontrado.";
  }



?>