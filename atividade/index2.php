<?php

require_once("./authSession.php");
require_once("./conf/confBD.php");

?>

<!DOCTYPE html>
<html>

<head>

<meta charset="utf-8" />
<link rel="stylesheet" href="style.css" />
<link href='http://fonts.googleapis.com/css?family=Calligraffitti' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Lato:400,100italic' rel='stylesheet' type='text/css'>

<title>Atividade de Pos Graduação</title>

<script type="text/javascript">


 function abrir_popup(classe,id){
 
  c=document.getElementById(classe);
  
		item=document.getElementById(id);
		if(item.style.display=="block")
		{
			item.style.display="none";
			c.style.backgroundColor="";
		}
		else
		{
			item.style.display="block";
			c.style.backgroundColor="#FFF";
		}
		return false;
	}


</script>

</head>

<body>


<header>

<p id="pr"> <?php echo utf8_decode($_SESSION['nomeCompleto']);?> - <a id="sair" href="logout.php" >sair</a></p>


<a href="index2.php"><img id="bg" src="img/header.png" alt="Logo PucMinasVirtual" />
<img id="left" src="img/puc.png" alt="Logo PucMinasVirtual" />
<img id="right" src="img/Linux.png" alt="Logo PucMinasVirtual" />
<h1>Desenvolvimento de Aplicações Web</h1>
</a>


</header>

<div id="divtopo">

<div id="busca">

<form method="post" action="index2.php" >
<label for="filtro">Busca:</label>
<input type="text" name="filtro" id="buscaField" placeholder="Matheus Leão" required="required" />
<input type="submit" name="send" id="send" placeholder="Enviar"  />
</form>

</div>

<?php


try{
	// instancia objeto PDO, conectando no mysql
	 $conexao = conn_mysql();
		
		$loginUser = utf8_encode($_SESSION['loginUser']);

		// instrução SQL básica (sem restrição de nome)
		$SQLSelect = 'SELECT * FROM participantes WHERE login=?';
	
			//prepara a execução da sentença
		$operacao = $conexao->prepare($SQLSelect);		
		

	 if(!empty($_GET['verPerfil'])){
	         $loginUser = utf8_encode(htmlspecialchars($_GET['verPerfil']));
		}
				
		$pesquisar = $operacao->execute(array($loginUser));
		
		//captura TODOS os resultados obtidos
		$resultados = $operacao->fetchAll();
		
		// fecha a conexão (os resultados já estão capturados)
		$conexao = null;
		
		// se há resultados, os escreve em uma tabela
		if (count($resultados)>0){		

			foreach($resultados as $contatosEncontrados){		//para cada elemento do vetor de resultados...
				
echo "<a class='app2' href='#'>
	      <figure>
         <img id='imgUser' src='./".utf8_decode($contatosEncontrados['arquivoFoto'])."'/>
         <figcaption>".utf8_decode($contatosEncontrados['nomeCompleto'])."</figcaption>
       </figure>
      </a>";

echo "<div id='dados_pessoais'>
		  <p><strong>Nome:</strong> ".utf8_decode($contatosEncontrados['nomeCompleto'])."</p>   
   		<p><strong>E-mail:</strong> ".utf8_decode($contatosEncontrados['email'])."</p> 
   		<p><strong>Informações:</strong> ".utf8_decode($contatosEncontrados['descricao'])."</p>
	   	<p><strong>Cidade:</strong> Teófilo Otoni</p>
	   	<p><strong>Estado:</strong> Minas Gerais</p> 
	   	
   </div>";
   
   	if(empty($_GET['verPerfil'])){
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='./apagarContato.php?login=".htmlspecialchars($contatosEncontrados['email'])."'><button type=\button\ class='send' >Apagar</button></a>";		
				echo "&nbsp;&nbsp;<a href='./editarPerfil.php?contato=".htmlspecialchars($contatosEncontrados['nomeContato'])."'><button type=\button\ class='send' >Editar</button></a></td></tr>";
			}
					
			}

		}
		else{
			echo'<div class="starter-template">';
			echo"\n<h3 class=\sub-header\>Dados não encontrados.</h3>";
			echo'</div>';
		}
	} //try
	catch (PDOException $e)
	{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
	}
	
?>	

</div>

<h2>YEARBOOK</h2>

<section>


<?php
try{

	// instancia objeto PDO, conectando no mysql
	$conexao = conn_mysql();
		
		// instrução SQL básica (sem restrição de nome)
		$SQLSelect = 'SELECT login, nomeCompleto, arquivoFoto FROM participantes';
	
	

	 if(!empty($_POST['filtro'])){
	   $nomeBusca = utf8_encode(htmlspecialchars($_POST['filtro']));
			 $nomeBusca = "%".$nomeBusca."%";
			 $SQLSelect .=' where nomeCompleto like ?';

		}
						
			//prepara a execução da sentença
		$operacao = $conexao->prepare($SQLSelect);	
		  
		if(!empty($_POST['filtro'])){				
			//executa a sentença SQL com o valor passado por parâmetro
			$pesquisar = $operacao->execute(array($nomeBusca));

		}
		else
				$pesquisar = $operacao->execute();
		//captura TODOS os resultados obtidos
		
		$resultados = $operacao->fetchAll();
		
		// fecha a conexão (os resultados já estão capturados)
		$conexao = null;
		
		// se há resultados, os escreve em uma tabela
		if (count($resultados)>0){		

			foreach($resultados as $contatosEncontrados){		//para cada elemento do vetor de resultados...
			
	echo "<a class='app' href='./index2.php?verPerfil=".htmlspecialchars($contatosEncontrados['login'])."'>
     <figure>
       <img src='./".utf8_decode($contatosEncontrados['arquivoFoto'])."' alt='".utf8_decode($contatosEncontrados['nomeCompleto'])."' />
      <figcaption>".utf8_decode($contatosEncontrados['nomeCompleto'])."</figcaption>
     </figure>

    <div class='appear'>
	    <img id='lupa' src='img/lupa.png' alt='' />
    </div>
    </a>";
		}
	}
		else{
			echo"\n<h3>Nenhum participante com este nome.</h3>";
		}
	} //try
	catch (PDOException $e)
	{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
	}
	
?>	

</section>

</body>

</html>
