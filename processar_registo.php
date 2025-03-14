<?php
	//Ligação
	include ("ligacao.php");
	
	if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['pass']))	{
		echo "Preencha os campos de formulário";
		header ("Refresh: 2; URL = index.php");
		exit();
	}
	else
	{
		$email = $_POST["email"];
		$username = $_POST["username"];
		$pass = $_POST["pass"];
		$data_criacao = $_POST["data_criacao"];
		
		$sqlemail = "SELECT email FROM users WHERE email = :email";
		$verificar1 = $ligacao->prepare($sqlemail);
		$verificar1->bindParam(':email', $email, PDO::PARAM_STR);
		$verificar1->execute();

		$sqlUsername = "SELECT username FROM users WHERE username = :username";
		$verificar2 = $ligacao->prepare($sqlUsername);
		$verificar2->bindParam(':username', $username, PDO::PARAM_STR);
		$verificar2->execute();

		// Verifica se um registro com o nome de usuário já foi encontrado
		if ($verificar1->fetch(PDO::FETCH_ASSOC)) {
			echo "O email já está registado";
			header("Refresh: 3; URL = index.php#contact");
		}
		if ($verificar2->fetch(PDO::FETCH_ASSOC)) {
			echo "O username já está registado";
			header("Refresh: 3; URL = index.php#contact");
		}
		else{
			//Inserir dados na BD
			$sqlU= "INSERT INTO users (username, email, pass, data_criacao ) VALUES ('$username', '$email', '$pass', NOW())";
			$ligacao -> exec($sqlU);
			echo "Conta criada";
			header ('Location: login.php');
		}
	}	
?>