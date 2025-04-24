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

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $conn->real_escape_string($_POST['titulo']);
    
    $sql = "INSERT INTO categoria (titulo) VALUES (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $titulo);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Categoria adicionada com sucesso!";
        header('Location: gerir_categorias.php');
        exit();
    } else {
        $error = "Erro ao adicionar categoria: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Adicionar Categoria</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">
  <link rel="stylesheet" href="css/styleindexadmin.css">
  <link rel="stylesheet" href="css/styleadicionar_categoria.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
  
</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container">
    <div class="form-container">
      <h2 style="margin-bottom: 10px;"><i class="fas fa-plus-circle"></i> Adicionar Nova Categoria</h2>
      
      <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <form method="POST">
        <div class="form-group">
          <label for="titulo">Título da Categoria</label>
          <input type="text" id="titulo" name="titulo" class="form-control" required>
        </div>
        
        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Guardar Categoria</button>
        <a href="gerir_categorias.php" class="admin-btn" style="margin-left: 10px;"><i class="fas fa-arrow-left"></i> Voltar</a>
      </form>
    </div>
  </div>
</body>
</html>