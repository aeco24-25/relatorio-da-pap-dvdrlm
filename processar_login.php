<?php
	//Ligação
	include ("ligacao.php");
	
	//Definir $email e $password
	$email=$_POST["email"];
	$pass=$_POST["pass"];
	
	$sql = "SELECT nomeuser, pwd, niveluser FROM utilizadores WHERE nomeuser = '$username' AND pwd = '$password'";
	echo $sql."<br>";
	$consulta = $ligacao->query($sql);
	$consulta->setFetchMode(PDO::FETCH_ASSOC);
	
	//Consulta à base de dados
	while ($result = $consulta->fetch()){
		$nivel = $result['niveluser'];
	}
	$contar = $consulta->rowCount();
	if ($contar == 1){
		session_start();
		$_SESSION["username"] = $username;
		if($nivel == 1){
			header("Location: ./admin/indexadministrador.php"); exit;
		}
		else{
			header("Location: ./user/indexUser.php"); exit;
		}
	}
	else{
		header("Location: registar.php"); exit;
	}
?>