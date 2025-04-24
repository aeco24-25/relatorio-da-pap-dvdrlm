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

// Obter todas as expressões com info da categoria
$sql = "SELECT e.id_expressao, e.versao_ingles, e.traducao_portugues, c.titulo as categoria 
        FROM expressoes e 
        JOIN categoria c ON e.id_categoria = c.id_categoria
        ORDER BY e.id_expressao";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Gerir Expressões</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">
  <link rel="stylesheet" href="css/styleindexadmin.css">
  <link rel="stylesheet" href="css/stylegerir_expressoes.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container">
    <div class="admin-section">
      <h2><i class="fas fa-language"></i> Gerir Expressões</h2>
      
      <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
      <?php endif; ?>
      
      <a href="adicionar_expressao.php" class="admin-btn add-btn"><i class="fas fa-plus"></i> Adicionar Expressão</a>
      
      <table class="category-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Inglês</th>
            <th>Português</th>
            <th>Categoria</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id_expressao']; ?></td>
            <td><?php echo htmlspecialchars($row['versao_ingles']); ?></td>
            <td><?php echo htmlspecialchars($row['traducao_portugues']); ?></td>
            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
            <td class="admin-actions">
              <a href="editar_expressao.php?id=<?php echo $row['id_expressao']; ?>" class="admin-btn edit-btn"><i class="fas fa-edit"></i> Editar</a>
              <a href="eliminar_expressao.php?id=<?php echo $row['id_expressao']; ?>" class="admin-btn delete-btn" onclick="return confirm('Tem a certeza que deseja eliminar esta expressão?')"><i class="fas fa-trash"></i> Eliminar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>