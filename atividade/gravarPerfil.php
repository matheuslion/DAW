<?php

require_once("./conf/confBD.php");

$permissoes = array("gif", "jpeg", "jpg", "png", "image/gif", "image/jpeg", "image/jpg", "image/png");  //strings de tipos e extensoes validas
$temp = explode(".", basename($_FILES["fileName"]["name"]));
$extensao = end($temp);

if ((in_array($extensao, $permissoes))
&& (in_array($_FILES["fileName"]["type"], $permissoes))
&& ($_FILES["fileName"]["size"] < $_POST["MAX_FILE_SIZE"]))
  {
  if ($_FILES["fileName"]["error"] > 0)
    {
    echo "<h1>Erro no envio, código: " . $_FILES["fileName"]["error"] . "</h1>";
    }
  else
    {
	  $dirUploads = "uploads/";
   $nomeUsuario = $_POST["login"]."/";	  
	  
	  if(!file_exists ( $dirUploads ))
			mkdir($dirUploads, 0500);  //permissao de leitura e execucao
	  
	  $caminhoUpload = $dirUploads.$nomeUsuario;
	  if(!file_exists ( $caminhoUpload))
			mkdir($caminhoUpload, 0700);  //permissoes de escrita, leitura e execucao
			
	  $pathCompleto = $caminhoUpload.basename($_FILES["fileName"]["name"]);
      if(move_uploaded_file($_FILES["fileName"]["tmp_name"], $pathCompleto))
	     //echo "<h1>Armazenado em: <a href=\"./imagem.php?imgfile=" . htmlspecialchars($pathCompleto)."\"> $pathCompleto </a></h1>";
		echo "";
      else
		echo "<h1>Problemas ao armazenar o arquivo. Tente novamente.<h1>";
    }
  }
else
  {
  echo "<h1>Arquivo inválido<h1>";
  }


try
{
	// se não foram passados 4 parâmetros na requisição e não vier da página de cadastro
	//desvia para a mensagem de erro: 	// "previne" acesso direto à página
	$origem = basename($_SERVER['HTTP_REFERER']);
	if((count($_POST)!=9)&&($origem!='http://localhost/atividade/index.html')){
		header("Location: acessoNegado.php");
		die();
	}
	//se existem os parâmetros...
	else{
		//instancia objeto PDO, conectando-se ao mysql
		$conexao = conn_mysql();
		
		//captura valores do vetor POST
		//utf8_encode para manter consistência da codificação utf8 nas páginas e no banco
		$nome = utf8_encode(htmlspecialchars($_POST['nome']));
		$login = utf8_encode(htmlspecialchars($_POST['login']));
		$senha = utf8_encode(htmlspecialchars($_POST['pass']));
		$senhaConf = utf8_encode(htmlspecialchars($_POST['pass2']));
		$cidade = utf8_encode(htmlspecialchars($_POST['cidade']));
		$desc = utf8_encode(htmlspecialchars($_POST['desc']));

         
         
		if(($senha!=$senhaConf)||(strlen($senha)<4)||(strlen($senha)>8)){
		header("Location:./erroCadastro.php");
		die();
		}
		
		// cria instrução SQL parametrizada
		$SQLInsert = 'INSERT INTO participantes (login, senha, nomeCompleto, arquivoFoto, cidade, email, descricao)
			  		  VALUES (?,MD5(?),?,?,?,?,?)';
					  
		//prepara a execução
		$operacao = $conexao->prepare($SQLInsert);					  
		
		//executa a sentença SQL com os parâmetros passados por um vetor
		$inserir = $operacao->execute(array($login, $senha, $nome, $pathCompleto,$cidade,$login,$desc));
		
		// fecha a conexão ao banco
		$conexao = null;
		
		//verifica se o retorno da execução foi verdadeiro ou falso,
		//imprimindo mensagens ao cliente
		if ($inserir){
			 echo "<h1>Cadastro efetuado com sucesso.</h1>\n";
			 echo "<p class=\"lead\"><a href=\"./index.php\">Página principal</a></p>\n";
		}
		else {
			echo "<h1>Erro na operação.</h1>\n";
				$arr = $operacao->errorInfo();		//mensagem de erro retornada pelo SGBD
				$erro = utf8_decode($arr[2]);
				echo "<p>$erro</p>";							//deve ser melhor tratado em um caso real
			    echo "<p><a href=\"./index.php\">Retornar</a></p>\n";
		}
    }
}
catch (PDOException $e)
{
    // caso ocorra uma exceção, exibe na tela
    echo "Erro!: " . $e->getMessage() . "<br>";
    die();
}
  

?>
