<?php
	//Ligação
	include ("ligacao.php");
	
	//Definir $email e $pass
	$email=$_POST["email"];
	$pass=$_POST["pass"];

	$sql = "SELECT username, email, pass FROM users WHERE email = :email";
	$consulta = $ligacao->prepare($sql);
	$consulta->bindParam(':email', $email, PDO::PARAM_STR);
	$consulta->execute();
	
	if ($consulta->rowCount() == 1) {
		$user = $consulta->fetch(PDO::FETCH_ASSOC);
		
		if ($pass === $user['pass']) {
			session_start();
			$_SESSION["username"] = $user['username'];
			$_SESSION["email"] = $user['email'];
			header("Location: user/indexuser.php");
			exit();
		} else {
			echo "Email e/ou senha incorreto(s)";
			header("Refresh: 3; URL = login.php");
			exit();
		}
	} else {
		echo "Email e/ou senha incorreto(s)";
		header("Refresh: 3; URL = login.php"); 
		exit();
	}
?>