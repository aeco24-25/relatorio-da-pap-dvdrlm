<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

$username = $_GET['username'] ?? '';

if ($username === $_SESSION['username']) {
    $_SESSION['error_message'] = "Não pode eliminar a sua própria conta.";
    header('Location: gerir_utilizadores.php');
    exit();
}

// Eliminar o utilizador
$stmt = $conn->prepare("DELETE FROM users WHERE username = ?");
$stmt->bind_param("s", $username);

if ($stmt->execute()) {
    // Eliminar o progresso associado
    $conn->query("DELETE FROM progresso WHERE username = '$username'");
    $_SESSION['success_message'] = "Utilizador eliminado com sucesso!";
} else {
    $_SESSION['error_message'] = "Erro ao eliminar utilizador: " . $conn->error;
}

header('Location: gerir_utilizadores.php');
exit();
?>