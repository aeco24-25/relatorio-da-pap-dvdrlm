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

// Obter todos os utilizadores
$result = $conn->query("SELECT username, email, data_criacao, is_admin FROM users ORDER BY data_criacao DESC");
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Gerir Utilizadores</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">
  <link rel="stylesheet" href="css/styleindexadmin.css">
  <link rel="stylesheet" href="css/stylegerir_utilizadores.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container" style="color: black;">
    <div class="admin-section">
      <h2><i class="fas fa-users"></i> Gerir Utilizadores</h2>
      
      <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
      <?php endif; ?>
      
      <a href="adicionar_utilizador.php" class="admin-btn add-btn"><i class="fas fa-plus"></i> Adicionar Utilizador</a>
      
      <table class="user-table">
        <thead>
          <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Data Registo</th>
            <th>Tipo</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['username']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo date('d/m/Y', strtotime($row['data_criacao'])); ?></td>
            <td><?php echo $row['is_admin'] ? 'Admin' : 'Utilizador'; ?></td>
            <td class="admin-actions">
              <a href="editar_utilizador.php?username=<?php echo $row['username']; ?>" class="admin-btn edit-btn"><i class="fas fa-edit"></i> Editar</a>
              <a href="eliminar_utilizador.php?username=<?php echo $row['username']; ?>" class="admin-btn delete-btn" onclick="return confirm('Tem a certeza que deseja eliminar este utilizador?')"><i class="fas fa-trash"></i> Eliminar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>