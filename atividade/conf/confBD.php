<?php
 function conn_mysql(){

 		try{
			$host = 'br-cdbr-azure-south-a.cloudapp.net';
			$usuario = 'b8aa3fe301542d';
			$senha='7e119973';
			$banco = 'atividaAXUwEFlHL';
			$charset = "utf8"; 
			$string_conexao = "mysql:host=$host;dbname=$banco;charset=$charset;";
			
			$conn = new PDO($string_conexao,$usuario,$senha);
			
			return $conn;
		}
		catch(PDOException $e){
			echo 'Erro: '.$e->getMessage().'<br />';
			die();
		}
		
   }
?>
