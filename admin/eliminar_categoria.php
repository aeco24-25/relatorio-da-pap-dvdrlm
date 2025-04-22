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

$id_categoria = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Verificar se existem expressões associadas
$sql_check = "SELECT COUNT(*) as total FROM expressoes WHERE id_categoria = ?";
$stmt = $conn->prepare($sql_check);
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row['total'] > 0) {
    $_SESSION['error_message'] = "Não é possível eliminar a categoria porque contém expressões associadas.";
    header('Location: gerir_categorias.php');
    exit();
}

// Eliminar a categoria
$sql = "DELETE FROM categoria WHERE id_categoria = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_categoria);

if ($stmt->execute()) {
    $_SESSION['success_message'] = "Categoria eliminada com sucesso!";
} else {
    $_SESSION['error_message'] = "Erro ao eliminar categoria: " . $conn->error;
}

header('Location: gerir_categorias.php');
exit();
?>