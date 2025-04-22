<?php
//Ligação
include ("ligacao.php");

if (empty($_POST['email']) || empty($_POST['pass'])) {
    header("Location: login.php?erro=campos_vazios");
    exit();
}

//Definir $email e $pass
$email = $_POST["email"];
$pass = $_POST["pass"];

$sql = "SELECT username, email, pass, is_admin FROM users WHERE email = :email";
$consulta = $ligacao->prepare($sql);
$consulta->bindParam(':email', $email, PDO::PARAM_STR);
$consulta->execute();

if ($consulta->rowCount() == 1) {
    $user = $consulta->fetch(PDO::FETCH_ASSOC);
    
    if ($pass === $user['pass']) {
        session_start();
        $_SESSION["username"] = $user['username'];
        $_SESSION["email"] = $user['email'];
        $_SESSION["is_admin"] = $user['is_admin']; // Adiciona status admin à sessão
        
        // Redireciona conforme o tipo de usuário
        if ($user['is_admin']) {
            header("Location: admin/indexadmin.php");
        } else {
            header("Location: user/indexuser.php");
        }
        exit();
    } else {
        header("Location: login.php?erro=dados_invalidos");
        exit();
    }
} else {
    header("Location: login.php?erro=dados_invalidos");
    exit();
}
?>