<?php 
    include("config.php");
    //Enviar email
    #Pegar email do pastor
    $rowEmail = mysql_fetch_array ( 
                    mysql_query("SELECT *
                                from usuarios WHERE id = 1178 "));         
    #######################################################################################################
    //echo $SQL;
    //mysql_query($SQL) or die(mysql_error());

    $valor_cobrado = '1300';
    $data_referencia = '03/2015';
    
    # limpar trocar  / por ;
    $arrMails = explode('/', $rowEmail['Email']);
    //$mails = "";
    foreach ($arrMails as $value) {
        //echo "$value <br>";
        //if (validaEmail($value))
         //{
            //echo "O e-mail inserido é valido!";
            //$mails = $mails .' ; '.$value;
            funcEnviaEmail( $value, $rowEmail['Nome'], $valor_cobrado, $data_referencia );

            echo "<br>Enviado com sucesso";

        //}
    }

?>