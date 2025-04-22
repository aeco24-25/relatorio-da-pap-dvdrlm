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

// Estatísticas para relatórios
$total_usuarios = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc()['total'];
$total_expressoes = $conn->query("SELECT COUNT(*) as total FROM expressoes")->fetch_assoc()['total'];
$total_completas = $conn->query("SELECT COUNT(*) as total FROM progresso WHERE completo = TRUE")->fetch_assoc()['total'];

// Progresso por categoria
$progresso_categorias = $conn->query("
    SELECT c.titulo, 
           COUNT(e.id_expressao) as total,
           SUM(CASE WHEN p.completo = TRUE THEN 1 ELSE 0 END) as completas
    FROM categoria c
    LEFT JOIN expressoes e ON c.id_categoria = e.id_categoria
    LEFT JOIN progresso p ON e.id_expressao = p.id_expressao
    GROUP BY c.id_categoria
    ORDER BY completas DESC
");

// Últimas atividades
$ultimas_atividades = $conn->query("
    SELECT u.username, e.versao_ingles, p.data_conclusao 
    FROM progresso p
    JOIN users u ON p.username = u.username
    JOIN expressoes e ON p.id_expressao = e.id_expressao
    WHERE p.completo = TRUE
    ORDER BY p.data_conclusao DESC
    LIMIT 10
");
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Relatórios</title>
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
    
    .btn-submit {
      background: #7b6ada;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    
    .btn-submit:hover {
      background: #5a4fcf;
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
      margin-top: 20px;
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

    .stats-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    
    .stat-card {
      background: #fcfcff;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
    }
    
    .stat-card h3 {
      color: #7b6ada;
      margin-top: 0;
    }
    
    .progress-chart {
      margin-top: 20px;
    }
    
    .progress-item {
      margin-bottom: 15px;
    }
    
    .progress-title {
      display: flex;
      justify-content: space-between;
      margin-bottom: 5px;
    }
    
    .progress-bar {
      height: 10px;
      background: #e2e2e2;
      border-radius: 5px;
      overflow: hidden;
    }
    
    .progress-fill {
      height: 100%;
      background: #7b6ada;
      border-radius: 5px;
    }
    
    .activity-item {
      padding: 10px;
      border-bottom: 1px solid #eee;
      display: flex;
      justify-content: space-between;
    }
    
    .activity-item:last-child {
      border-bottom: none;
    }


  </style>
</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container">
    <h2 style="margin-bottom: 20px;"><i class="fas fa-chart-bar"></i> Relatórios e Estatísticas</h2>
    
    <div class="stats-grid">
      <div class="stat-card">
        <h3>Total de Utilizadores</h3>
        <div class="stat-number"><?php echo $total_usuarios; ?></div>
        <i class="fas fa-users fa-3x" style="color: #7b6ada;"></i>
      </div>
      
      <div class="stat-card">
        <h3>Total de Expressões</h3>
        <div class="stat-number"><?php echo $total_expressoes; ?></div>
        <i class="fas fa-language fa-3x" style="color: #7b6ada;"></i>
      </div>
      
      <div class="stat-card">
        <h3>Exercícios Completos</h3>
        <div class="stat-number"><?php echo $total_completas; ?></div>
        <i class="fas fa-check-circle fa-3x" style="color: #7b6ada;"></i>
      </div>
    </div>
    
    <div style="color:black;" class="admin-section">
      <h3><i class="fas fa-chart-pie"></i> Progresso por Categoria</h3>
      
      <div class="progress-chart">
        <?php while($cat = $progresso_categorias->fetch_assoc()): 
          $percent = $cat['total'] > 0 ? round(($cat['completas'] / $cat['total']) * 100) : 0;
        ?>
        <div class="progress-item">
          <div class="progress-title">
            <span><?php echo htmlspecialchars($cat['titulo']); ?></span>
            <span><?php echo $cat['completas']; ?>/<?php echo $cat['total']; ?> (<?php echo $percent; ?>%)</span>
          </div>
          <div class="progress-bar">
            <div class="progress-fill" style="width: <?php echo $percent; ?>%"></div>
          </div>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
    
    <div style="color: black;" class="admin-section">
      <h3><i class="fas fa-history"></i> Últimas Atividades</h3>
      
      <div class="activity-list">
        <?php while($activity = $ultimas_atividades->fetch_assoc()): ?>
        <div class="activity-item">
          <span>
            <strong><?php echo htmlspecialchars($activity['username']); ?></strong> completou 
            "<?php echo htmlspecialchars($activity['versao_ingles']); ?>"
          </span>
          <span><?php echo date('d/m/Y H:i', strtotime($activity['data_conclusao'])); ?></span>
        </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</body>
</html>