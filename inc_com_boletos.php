<!-- HTML -->
<?php
  include("config.php");
  include('scripts/functions.php');


  // Verifica se a solicitação é para carregar todos os registros
  if ($_GET['limit'] === 'all') {
      $query = "
                select  
                u.Nome,
                lb.idUsuario,
                count( lb.idUsuario) as total 
                from 

                lancamentosbancarios lb join usuarios u on(u.id = lb.idUsuario)

                where lb.TipoOrigem = 'CR' 
                group by u.Nome,lb.idUsuario
                order by total desc
                
                ";

  } else {
      $limit = (int)$_GET['limit']; // Número de registros a serem carregados
      $query = "
                select  
                u.Nome,
                lb.idUsuario,
                count( lb.idUsuario) as total 
                from 

                lancamentosbancarios lb join usuarios u on(u.id = lb.idUsuario)

                where lb.TipoOrigem = 'CR' 
                group by u.Nome,lb.idUsuario
                order by total desc
          LIMIT $limit";
  }



$rsCamposPagadores = $db->query($query)->results(true);

if ($rsCamposPagadores) {
  foreach ($rsCamposPagadores as $rowCamposPagadores) {
          foreach ($rowCamposPagadores as $key => $value) {
              $rowCamposPagadores[$key] = stripslashes($value);
          }


          echo "                                                

                            <a href='follow-up.php?id={$rowCamposPagadores['idUsuario']}' class='list-group-item'>                                                  
                              <i class='fa fa-fw fa-user'></i> {$rowCamposPagadores['Nome']}

                                <span style='background:#40916c; padding:5px 10px; color:white; border-radius:50%'> {$rowCamposPagadores['total']}</span>
                          </a>";
      }

  } else {
    echo "Nenhum registro encontrado.";
  }



         