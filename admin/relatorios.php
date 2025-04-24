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

// Estatísticas e relatórios
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
  <link rel="stylesheet" href="css/stylerelatorios.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
  
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