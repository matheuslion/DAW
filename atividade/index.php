<?php

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



<p id="pr">

<a id="cad" href="#" onclick="abrir_popup('cad','divCad'); return false;">Cadastre-se</a> ou faça <a id="login" href="#" onclick="abrir_popup('login','divLogin'); return false;">Login.</a>

</p>

<form method="post" action="verificarLogin.php" >

<div id="divLogin">

<h2>Faça o Login</h2>


<input type="email" name="login" id="login" placeholder="matheusleao@linux.com" required="required" />

<input type="password" name="pass" id="pass" placeholder="Senha" required="required" />

<label>
   <input type="checkbox"  name="lembrarLogin" id="lembrarLogin" value="loginAutomatico"> Permanecer conectado
</label>

<input type="submit" name="send" id="send" placeholder="Enviar"  />
        
</div>

</form>


<form method="post" action="gravarPerfil.php" enctype="multipart/form-data">

<div id="divCad">


<h2>Cadastro</h2>


<input type="text" name="nome" id="nome" placeholder="Matheus Leão" required="required"/>


<label for="estado">Estado:</label>
<select name="estado" id="estado">
	<option value="MG">MG</option>
	<option value="RJ">RJ</option>
	<option value="SP">SP</option>
</select>

<br>

<label for="cidade">Cidade:</label>
<select name="cidade" id="cidade">
	<option value="01">Teófilo Otoni</option>
	<option value="02">São Paulo</option>
	<option value="03">Rio de Janeiro</option>
</select>

<br>


<input type="file" name="fileName" id="fileName" placeholder="Foto" required="required" />
<input type="hidden" name="MAX_FILE_SIZE" value="500000" >

<textarea name="desc" id="desc" placeholder="Descrição pessoal"></textarea>

<input type="email" name="login" id="login" placeholder="matheusleao@linux.com" required="required" />

<input type="password" name="pass" id="pass" placeholder="Senha (De 4 a 8 caracteres)" required="required" />

<input type="password" name="pass2" id="pass2" placeholder="Confirmar senha" required="required" />

<input type="submit" name="send" id="send" placeholder="Enviar" />


</div>

</form>


<img id="bg" src="img/header.png" alt="Logo PucMinasVirtual" />
<img id="left" src="img/puc.png" alt="Logo PucMinasVirtual" />
<img id="right" src="img/Linux.png" alt="Logo PucMinasVirtual" />
<h1>Desenvolvimento de Aplicações Web</h1>
</header>

<div id="divtopo">

<p>Atividade Aberta 05</p>

<hr/>
<br>

<p>Como projeto interdisciplinar do primeiro módulo do curso, foi desenvolvido um álbum dos alunos da turma do curso de especialização. A ideia é implementar algo parecido com os Yearbooks publicados pelas escolas americanas. As tarefas da disciplina de Desenvolvimento de Aplicações Web vão estender o protótipo que já foi desenvolvido na disciplina anterior.</p>

</div>

<h2>YEARBOOK</h2>

<section>


<?php


try{
	// instancia objeto PDO, conectando no mysql
	 $conexao = conn_mysql();
		
		// instrução SQL básica (sem restrição de nome)
		$SQLSelect = 'SELECT * FROM participantes';
	
			//prepara a execução da sentença
		$operacao = $conexao->prepare($SQLSelect);		
		
				
		$pesquisar = $operacao->execute();
		
		//captura TODOS os resultados obtidos
		$resultados = $operacao->fetchAll();
		
		// fecha a conexão (os resultados já estão capturados)
		$conexao = null;
		
		// se há resultados, os escreve em uma tabela
		if (count($resultados)>0){		

			foreach($resultados as $contatosEncontrados){		//para cada elemento do vetor de resultados...
			
	echo "<a class='app' href='./index.php?verPerfil=".htmlspecialchars($contatosEncontrados['login'])."'>
     <figure>
       <img src='./".utf8_decode($contatosEncontrados['arquivoFoto'])."' alt='".utf8_decode($contatosEncontrados['nomeCompleto'])."' />
      <figcaption>".utf8_decode($contatosEncontrados['nomeCompleto'])."</figcaption>
     </figure>

    <div class='appear'>
	    <img id='lupa' src='img/cadeado.png' alt='' />
    </div>
    </a>";
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



</section>

</body>

</html>
