<?php
	//Ligação
	include ("ligacao.php");
	
	if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['pass']))	{
		header("Location: index.php?erro=campos_vazios#contact");
		exit();
	}
	else
	{
		$email = $_POST["email"];
		$username = $_POST["username"];
		$pass = $_POST["pass"];
		
		$sqlemail = "SELECT email FROM users WHERE email = :email";
		$verificar1 = $ligacao->prepare($sqlemail);
		$verificar1->bindParam(':email', $email, PDO::PARAM_STR);
		$verificar1->execute();

		$sqlUsername = "SELECT username FROM users WHERE username = :username";
		$verificar2 = $ligacao->prepare($sqlUsername);
		$verificar2->bindParam(':username', $username, PDO::PARAM_STR);
		$verificar2->execute();

		// Verifica se um registro com o email ou username já foi encontrado
		if ($verificar1->fetch(PDO::FETCH_ASSOC)) {
			header("Location: index.php?erro=email_existente#contact");
			exit();
		}
		else if ($verificar2->fetch(PDO::FETCH_ASSOC)) {
			header("Location: index.php?erro=username_existente#contact");
			exit();
		}
		else{
			//Inserir dados na BD
			$sqlU= "INSERT INTO users (username, email, pass, data_criacao) VALUES (:username, :email, :pass, NOW())";
			$stmt = $ligacao->prepare($sqlU);
			$stmt->bindParam(':username', $username, PDO::PARAM_STR);
			$stmt->bindParam(':email', $email, PDO::PARAM_STR);
			$stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
			$stmt->execute();
			
			header('Location: login.php?sucesso=conta_criada');
			exit();
		}
	}	
?>