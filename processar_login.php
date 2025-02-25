<?php
	//Ligação
	include ("ligacao.php");
	
	//Definir $email e $password
	$email=$_POST["email"];
	$pass=$_POST["pass"];
	
	$sql = "SELECT email, pass FROM users WHERE email = '$email' AND pass = '$pass'";
	echo $sql."<br>";
	$consulta = $ligacao->query($sql);
	$consulta->setFetchMode(PDO::FETCH_ASSOC);
	
	//Consulta à base de dados
	
	$contar = $consulta->rowCount();
	if ($contar == 1){
		session_start();
		$_SESSION["email"] = $email;
		header("Location: indexuser.php"); exit;
	}
	else{
		header("Location: login.php"); exit;
	}
?>