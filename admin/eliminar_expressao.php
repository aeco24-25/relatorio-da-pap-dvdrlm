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

$id_expressao = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Eliminar a expressão e todos os dados relacionados
$conn->begin_transaction();

try {
    // Eliminar exemplos
    $conn->query("DELETE FROM exemplos WHERE id_expressao = $id_expressao");
    
    // Eliminar progresso
    $conn->query("DELETE FROM progresso WHERE id_expressao = $id_expressao");
    
    // Eliminar exercícios específicos
    $conn->query("DELETE FROM exercicio_preenchimento WHERE id_expressao = $id_expressao");
    $conn->query("DELETE FROM exercicio_associacao WHERE id_expressao = $id_expressao");
    
    // Eliminar a expressão
    $conn->query("DELETE FROM expressoes WHERE id_expressao = $id_expressao");
    
    $conn->commit();
    $_SESSION['success_message'] = "Expressão eliminada com sucesso!";
} catch (Exception $e) {
    $conn->rollback();
    $_SESSION['error_message'] = "Erro ao eliminar expressão: " . $e->getMessage();
}

header('Location: gerir_expressoes.php');
exit();
?>