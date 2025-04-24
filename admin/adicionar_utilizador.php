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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validação e Preparação de Dados
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Verificar se username ou email já existem
    $check = $conn->prepare("SELECT username, email FROM users WHERE username = ? OR email = ?");
    $check->bind_param("ss", $username, $email);
    $check->execute();
    $check->store_result();
    
    // Inserção do Novo Utilizador
    if ($check->num_rows > 0) {
        $error = "Username ou email já existem!";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (username, email, pass, is_admin) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $username, $email, $password, $is_admin);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Utilizador adicionado com sucesso!";
            header('Location: gerir_utilizadores.php');
            exit();
        } else {
            $error = "Erro ao adicionar utilizador: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Adicionar Utilizador</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">
  <link rel="stylesheet" href="css/styleindexadmin.css">
  <link rel="stylesheet" href="css/styleadicionar_utilizador.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
  
</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container">
    <div class="form-container" style="color:black;">
      <h2 style="margin-bottom: 10px;"><i class="fas fa-user-plus"></i> Adicionar Novo Utilizador</h2>
      
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <form method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" class="form-control" required>
        </div>
        
        <div class="checkbox-group">
          <input type="checkbox" id="is_admin" name="is_admin">
          <label for="is_admin">Administrador</label>
        </div>
        
        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Guardar Utilizador</button>
        <a href="gerir_utilizadores.php" class="admin-btn" style="margin-left: 10px;"><i class="fas fa-arrow-left"></i> Voltar</a>
      </form>
    </div>
  </div>
</body>
</html>