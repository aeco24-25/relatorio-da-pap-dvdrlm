<?php
	//Ligação
	include ("ligacao.php");
	
	if (empty($_POST['username']))
	{
		echo "Preencha os campos de formulário!";
		header ("Refresh: 1; URL = index.php");
	}
	else
	{
		//Verificação se existe ou não já um email igual
		$email = $_POST["email"];
		
		$sqlemail = "SELECT email FROM users WHERE email = :email";
		$verificar = $ligacao->prepare($sqlemail);
		$verificar->bindParam(':email', $email, PDO::PARAM_STR);
		$verificar->execute();

		if ($verificar->fetch(PDO::FETCH_ASSOC)) {
			echo "O email já está registado";
			header("Refresh: 3; URL = index.php#contact");
		}
		else{
			//Inserir dados na BD
			$username = $_POST["username"];
			$pass = $_POST["pass"];
			$data_criacao = $_POST["data_criacao"];
			
			$sqlU= "INSERT INTO users (username, email, pass, data_criacao ) VALUES ('$username', '$email', '$pass', NOW())";
			$ligacao -> exec($sqlU);
			
			header ("Refresh: 1; URL = login.php");
		}
	}	
?>