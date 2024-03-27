	    <?php 
	   //Destrói
	    session_start();

  include "logger.php";
        Logger("{$_SESSION['nome']} [{$_SESSION['idlogado']}] saiu do sistema .");



	    //Limpa
	    unset ($_SESSION['login']);
	    unset ($_SESSION['nome']);
        unset ($_SESSION['logado']);
        //$_SESSION['logado'] == 'N';

	    //Redireciona para a página de autenticação
	    header('location:login.php');	

	    ?>