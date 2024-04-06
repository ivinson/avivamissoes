<?php
 
	date_default_timezone_set('America/Sao_Paulo');
	 
	function Logger($msg){
	 
		//pega o path completo de onde esta executanto
		$caminho_atual = getcwd(); 
		#echo "<br>caminho_atual :" . $caminho_atual;
		 
		//muda o contexto de execução para a pasta logs
		chdir("/home/storage/6/da/e7/avivamissoes2/public_html/app/logs/");
		 
		$data = date("d-m-y");
		$hora = date("H:i:s");
		$ip = $_SERVER['REMOTE_ADDR'];
		 
		//Nome do arquivo:
		// $arquivo = "/home/storage/6/da/e7/avivamissoes2/public_html/app/logs/Logger_$data.txt";debora voltar par essa variavel pois é do servidor
		$arquivo = sys_get_temp_dir() . "/Logger_$data.txt";
		#echo $arquivo."<br>";
		 
		//Texto a ser impresso no log:
		$texto = "[$hora][$ip]> $msg \n";
		 
		$manipular = fopen("$arquivo", "a+b");
		fwrite($manipular, $texto);
		fclose($manipular);
		 
		//Volta o contexto de execução para o caminho em que estava antes
		chdir($caminho_atual);
 
}




 

 
?>