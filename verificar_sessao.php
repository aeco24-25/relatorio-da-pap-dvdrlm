<?php
	//Iniciar sessão
	session_start();
	
	//Verificar se há uma sessão associada ao campo id_utilizador
	if (empty($_SESSION['username'])) {
	//Caso a sessão não esteja iniciada, volta à página de acesso
	header('Location: login.php');
	exit();
	}
?>