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
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

  <style>
    .form-container {
      margin-top: 0px !important;
      max-width: 600px;
      margin: 30px auto;
      padding: 20px;
      background: #fcfcff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 500;
    }
    
    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    
    .checkbox-group {
      display: flex;
      align-items: center;
      margin: 15px 0;
    }
    
    .checkbox-group input {
      margin-right: 10px;
    }
    
    .btn-submit {
      background: #7b6ada;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }

    .alert {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    
    .alert-success {
      background: #d4edda;
      color: #155724;
    }
    
    .alert-danger {
      background: #f8d7da;
      color: #721c24;
    }

    :root {
      --primary-color: #7b6ada;
      --secondary-color: #5a4fcf;
      --success-color: #4CAF50;
      --light-gray: #e2e2e2;
      --dark-gray: #333;
      --error-color: #c62828;
    }

    .admin-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .admin-main-content {
      display: flex;
      flex-direction: column;
      gap: 20px;
      width: 100%;
    }

    .stats-panel {
      background: #7b6ada;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 0;
    }

    .stats-panel h2 {
      text-align: center;
      color: #ffffff;
      margin-top: 0;
    }

    .admin-stats {
      margin-top: 18px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .stat-card {
      background: #fcfcff;
      border-radius: 22px;
      padding: 17px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .stat-card h3 {
      color: #7b6ada;
      margin-top: 0;
      margin-bottom: 10px;
      font-size: 1.1rem;
    }

    .stat-number {
      font-size: 2rem;
      font-weight: bold;
      color: #434343;
      margin: 10px 0;
    }

    .admin-section {
      margin-top: 0px !important;
      background: #fcfcff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 100%;
    }

    .admin-section h2 {
      color: #7b6ada;
      margin-top: 0;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }

    .user-table, .category-table {
      width: 100%;
      border-collapse: collapse;
    }

    .user-table th, .category-table th {
      background: #7b6ada;
      color: white;
      padding: 10px;
      text-align: left;
    }

    .user-table td, .category-table td {
      padding: 10px;
      border-bottom: 1px solid #eee;
    }

    .user-table tr:hover, .category-table tr:hover {
      background: #f5f5ff;
    }

    .admin-actions {
      display: flex;
      gap: 10px;
    }

    .admin-btn {
      padding: 5px 10px;
      border-radius: 5px;
      color: white;
      text-decoration: none;
      font-size: 0.8rem;
      display: inline-flex;
      align-items: center;
    }

    .edit-btn {
      background: #4CAF50;
    }

    .delete-btn {
      background: #c62828;
    }

    .add-btn {
      background: #7b6ada;
      margin-bottom: 15px;
      padding: 8px 15px;
    }

    .admin-btn i {
      margin-right: 5px;
    }

    .nav-admin {
      justify-content: space-around;
      margin-top: -30px;
      display: flex;
      background: #7b6ada;
      padding: 10px 20px;
      margin-bottom: 20px;
      border-radius: 8px;
    }

    .nav-admin a {
      color: white;
      text-decoration: none;
      margin-right: 20px;
      padding: 5px 10px;
      border-radius: 5px;
    }

    .nav-admin a:hover {
      background: rgba(255,255,255,0.2);
    }

    .nav-admin a.active {
      background: white;
      color: #7b6ada;
    }
  </style>
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