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

// Obter todas as categorias
$sql = "SELECT c.*, COUNT(e.id_expressao) as total_expressoes 
        FROM categoria c
        LEFT JOIN expressoes e ON c.id_categoria = e.id_categoria
        GROUP BY c.id_categoria
        ORDER BY c.id_categoria";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Gerir Categorias</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="css/styleindexadmin.css">
</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container">
    <div class="admin-section">
      <h2><i class="fas fa-folder"></i> Gerir Categorias</h2>
      
      <?php if (isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?></div>
      <?php endif; ?>
      
      <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
      <?php endif; ?>
      
      <a href="adicionar_categoria.php" class="admin-btn add-btn"><i class="fas fa-plus"></i> Adicionar Categoria</a>
      
      <table class="category-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Expressões</th>
            <th>Ações</th>
          </tr>
        </thead>
        <tbody>
          <?php while($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['id_categoria']; ?></td>
            <td><?php echo htmlspecialchars($row['titulo']); ?></td>
            <td><?php echo $row['total_expressoes']; ?></td>
            <td class="admin-actions">
              <a href="editar_categoria.php?id=<?php echo $row['id_categoria']; ?>" class="admin-btn edit-btn"><i class="fas fa-edit"></i> Editar</a>
              <a href="eliminar_categoria.php?id=<?php echo $row['id_categoria']; ?>" class="admin-btn delete-btn" onclick="return confirm('Tem a certeza que deseja eliminar esta categoria?')"><i class="fas fa-trash"></i> Eliminar</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>