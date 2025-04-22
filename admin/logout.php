<?php
// Iniciar sessão
session_start();

// Destruir a sessão
session_destroy(); 

// Redirecionar para a página de index
header('Location: ../index.php');
exit();
?>