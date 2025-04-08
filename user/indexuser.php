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

// Obter categorias para o menu
$sql_categorias = "SELECT id_categoria, titulo FROM categoria ORDER BY id_categoria";
$result_categorias = $conn->query($sql_categorias);

// Obter o progresso do utilizador
$username = $_SESSION['username'];
$sql_progresso = "SELECT COUNT(*) as total_completo FROM progresso WHERE username = ? AND completo = TRUE";
$stmt = $conn->prepare($sql_progresso);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_progresso = $stmt->get_result();
$progresso_row = $result_progresso->fetch_assoc();
$total_completo = $progresso_row['total_completo'];

// Obter total de expressões
$sql_total = "SELECT COUNT(*) as total FROM expressoes";
$result_total = $conn->query($sql_total);
$total_row = $result_total->fetch_assoc();
$total_expressoes = $total_row['total'];

// Calcular percentagem para mostrar no progresso
$percentagem = ($total_expressoes > 0) ? round(($total_completo / $total_expressoes) * 100) : 0;

// Função para calcular coordenadas do arco SVG
function getProgressCoordinates($percent, $radius) {
    $percent = min(100, max(0, $percent));
    $angle = ($percent / 100) * 360;
    $radians = (($angle - 90) * M_PI) / 180;
    $x = $radius + ($radius * cos($radians));
    $y = $radius + ($radius * sin($radians));
    return round($x, 1) . ' ' . round($y, 1);
}

// Verificar quais categorias estão liberadas
$categorias_liberadas = array();
$categorias_completas = array();

$sql_categorias_progresso = "SELECT c.id_categoria, c.titulo, 
                            COUNT(e.id_expressao) as total,
                            SUM(CASE WHEN p.completo = TRUE THEN 1 ELSE 0 END) as completas
                            FROM categoria c
                            JOIN expressoes e ON c.id_categoria = e.id_categoria
                            LEFT JOIN progresso p ON e.id_expressao = p.id_expressao AND p.username = ?
                            GROUP BY c.id_categoria
                            ORDER BY c.id_categoria";
$stmt = $conn->prepare($sql_categorias_progresso);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_categorias_progresso = $stmt->get_result();

$categoria_anterior_completa = true;

while ($row = $result_categorias_progresso->fetch_assoc()) {
    $completa = ($row['completas'] == $row['total']);
    $categorias_completas[$row['id_categoria']] = $completa;
    
    if ($categoria_anterior_completa) {
        $categorias_liberadas[$row['id_categoria']] = true;
        $categoria_anterior_completa = $completa;
    } else {
        $categorias_liberadas[$row['id_categoria']] = false;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Início</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
  
  <style>
    :root {
      --primary-color: #7b6ada;
      --secondary-color: #5a4fcf;
      --success-color: #4CAF50;
      --light-gray: #e2e2e2;
      --dark-gray: #333;
      --error-color: #c62828;
    }
    
    body {
      background: white;
      font-family: 'Poppins', sans-serif;
    }
    
    .logo {
      margin-top: 16px;
      margin-left: 50px;
      display: inline-block;
    }

    h1 {
      margin-top: -5px;
      margin-bottom: 0px;
      font-size: 46px;
      text-transform: uppercase;
      color: #fff;
      font-weight: 700;
      margin-right: 20px;
      padding-right: 20px;
    }

    .progress-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 2rem;
      background: white;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      margin-bottom: 2rem;
      max-width: 800px;
      margin: 20px auto;
    }

    .progress-circle {
      position: relative;
      width: 150px;
      height: 150px;
      margin-bottom: 1.5rem;
    }

    .progress-stats {
      display: flex;
      justify-content: space-around;
      width: 100%;
      text-align: center;
    }

    .stat-item {
      flex: 1;
      padding: 0.5rem;
    }

    .stat-number {
      font-size: 1.6rem;
      font-weight: bold;
      color: var(--primary-color);
    }

    .stat-label {
      font-size: 0.95rem;
      color: var(--dark-gray);
    }

    .perfil-container {
      max-width: 800px;
      margin: 0 auto;
      margin-top: 110px;
    }

    .perfil-titulo {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 30px;
      color: #333;
      text-align: center;
    }

    .logo {
      margin-top: 16px;
      margin-left: 50px;
      display: inline-block;
    }

    h1 {
      margin-top: -5px;
      margin-bottom: 0px;
      font-size: 46px;
      text-transform: uppercase;
      color: #fff;
      font-weight: 700;
      margin-right: 20px;
      padding-right: 20px;
    }

    .progress-circle {
      position: relative;
      width: 150px;
      height: 150px;
    }
    
    .progress-circle-bg {
      fill: #e2e2e2;
    }
    
    .progress-circle-fill {
      fill: #7b6ada;
      transition: all 0.3s ease;
    }
    
    .progress-circle-text {
      font-size: 24px;
      font-weight: bold;
      fill: #333;
      text-anchor: middle;
      dominant-baseline: central;
    }
    
    .categoria-card {
      background-color: white;
      border-radius: 12px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      padding: 20px;
      margin-bottom: 15px;
      transition: all 0.3s ease;
      display: flex;
      align-items: center;
    }
    
    .categoria-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .categoria-icon {
      width: 50px;
      height: 50px;
      background-color: #7b6ada;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 15px;
      color: white;
      font-weight: bold;
      font-size: 20px;
    }
    
    .categoria-info {
      flex: 1;
    }
    
    .categoria-titulo {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 5px;
      color: #333;
    }
    
    .categoria-progress {
      background-color: #e2e2e2;
      height: 10px;
      border-radius: 5px;
      overflow: hidden;
      margin-top: 15px;
    }
    
    .categoria-progress-fill {
      height: 100%;
      background-color: #7b6ada;
      border-radius: 5px;
      transition: width 0.3s ease;
    }
    
    .categoria-bloqueada {
      opacity: 0.6;
      background-color: #f5f5f5;
    }
    
    .categoria-bloqueada .categoria-icon {
      background-color: #999;
    }
    
    .categoria-bloqueada .categoria-progress-fill {
      background-color: #999;
    }
    
    .bloqueio-mensagem {
      font-size: 14px;
      color: #c62828;
      margin-top: 5px;
      font-style: italic;
    }
  </style>
</head>

<body style="background:white;">
  <div id="root">
    <div data-reactroot="">
      <div class="_6t5Uh" style="height: 78px;">
        <div class="NbGcm">
          <div class="_3vDrO">
            <div class="_3I51r _2OF7V">
              <span class="oboa9 _3viv6 HCWXf _3PU7E _3JPjo"></span><span class="_1icRZ _1k9o2 cCL9P"></span>
            </div>
            <div class="_1ALvM"></div>
            <div class="_1G4t1 _3HsQj _2OF7V" data-test="user-dropdown">
              <span class="_3ROGm"><img class="_3Kp8s" src="../assets/images/user.png" alt="Avatar"></span>
              <span style="margin-left:-5px;"><?php echo htmlspecialchars($username); ?></span>
              <span class="_2Vgy6 _1k0u2 cCL9P"></span>
              <ul class="_3q7Wh OSaWc _2HujR _1ZY-H">
                <li class="_31ObI _1qBnH">
                  <a href="perfil.php" class="_3sWvR">Perfil</a>
                </li>
                <li class="_31ObI _1qBnH">
                  <a href="editarperfil.php" class="_3sWvR">Editar Perfil</a>
                </li>
                <li class="_31ObI _1qBnH">
                  <a href="logout.php" class="_3sWvR">Sair</a>
                </li>
              </ul>
            </div>
          </div>
          <a href="indexuser.php" class="logo">
            <h1>D<span style="text-align: var(--bs-body-text-align); -webkit-text-size-adjust: 100%; -webkit-tap-highlight-color: transparent; -webkit-font-smoothing: antialiased; font-family: 'Poppins', sans-serif !important; --bs-gutter-x: 1.5rem; --bs-gutter-y: 0; line-height: 1.2; font-size: 46px; text-transform: uppercase; font-weight: 700; box-sizing: border-box; margin: 0; padding: 0; border: 0; outline: 0; color: rgba(255, 255, 255, 0.75);">Teaches</span></h1>
          </a>
        </div>
      </div>
      <div class="LFfrA _3MLiB">
          <div class="_2_lzu">
          <div class="_21w25 _1E3L7">
            <h2>Progresso Geral</h2>
            <div class="progress-container">
              <div class="progress-circle">
                <svg height="150" width="150" viewBox="0 0 150 150" aria-labelledby="progress-percent">
                  <circle cx="75" cy="75" r="75" fill="#e2e2e2" />
                  <?php if ($percentagem > 0): ?>
                  <path d="M 75 75 L 75 0 A 75 75 0 <?php echo $percentagem > 50 ? "1" : "0"; ?> 1 <?php echo getProgressCoordinates($percentagem, 75); ?> Z" fill="var(--primary-color)" />
                  <?php endif; ?>
                  <?php if ($percentagem < 100): ?>
                  <path d="M 75 75 L <?php echo getProgressCoordinates($percentagem, 75); ?> A 75 75 0 <?php echo $percentagem > 50 ? "1" : "0"; ?> 0 75 0 Z" fill="#e2e2e2" />
                  <?php endif; ?>
                  <circle cx="75" cy="75" r="60" fill="#ffffff" />
                  <text x="75" y="80" font-size="24" text-anchor="middle" fill="#333"><?php echo $percentagem; ?>%</text>
                </svg>
              </div>
              
              <div class="progress-stats">
                <div class="stat-item">
                  <div class="stat-number"><?php echo $total_completo; ?></div>
                  <div class="stat-label">expressões aprendidas</div>
                </div>
                <div class="stat-item">
                  <div class="stat-number"><?php echo $total_expressoes - $total_completo; ?></div>
                  <div class="stat-label">expressões por aprender</div>
                </div>
              </div>
            </div>
          </div>
          </div>
          <div class="_3MT-S">
              <div class="_2hEQd _1E3L7">
                <h2 style="margin-top: -10px; margin-bottom: 20px; text-align: center;">Categorias</h2>
                <div style="max-width: 800px; margin: 0 auto;">
                  <?php
                  $result_categorias->data_seek(0);
                  if ($result_categorias->num_rows > 0) {
                      while($row = $result_categorias->fetch_assoc()) {
                          $cat_id = $row['id_categoria'];
                          $total_cat = 0;
                          $completo_cat = 0;
                          
                          $sql_count = "SELECT COUNT(*) as total FROM expressoes WHERE id_categoria = $cat_id";
                          $result_count = $conn->query($sql_count);
                          $count_row = $result_count->fetch_assoc();
                          $total_cat = $count_row['total'];
                          
                          $sql_prog = "SELECT COUNT(*) as completo FROM expressoes e 
                                      JOIN progresso p ON e.id_expressao = p.id_expressao 
                                      WHERE e.id_categoria = $cat_id AND p.username = '$username' AND p.completo = TRUE";
                          $result_prog = $conn->query($sql_prog);
                          $prog_row = $result_prog->fetch_assoc();
                          $completo_cat = $prog_row['completo'];
                          
                          $cat_percent = ($total_cat > 0) ? round(($completo_cat / $total_cat) * 100) : 0;
                          $first_letter = strtoupper(substr($row['titulo'], 0, 1));
                          
                          $liberada = isset($categorias_liberadas[$cat_id]) && $categorias_liberadas[$cat_id];
                          $completa = isset($categorias_completas[$cat_id]) && $categorias_completas[$cat_id];
                          
                          echo '<div class="categoria-card' . (!$liberada ? ' categoria-bloqueada' : '') . '">';
                          
                          if ($liberada) {
                              // Obter primeira expressão da categoria
                              $sql_primeira = "SELECT e.id_expressao FROM expressoes e 
                                              WHERE e.id_categoria = $cat_id 
                                              ORDER BY e.id_expressao LIMIT 1";
                              $result_primeira = $conn->query($sql_primeira);
                              if ($result_primeira->num_rows > 0) {
                                  $primeira_row = $result_primeira->fetch_assoc();
                                  echo '<a href="exercicio.php?id=' . $primeira_row['id_expressao'] . '" style="text-decoration: none; color: inherit; display: flex; width: 100%;">';
                              } else {
                                  echo '<div style="display: flex; width: 100%;">';
                              }
                          } else {
                              echo '<div style="display: flex; width: 100%;">';
                          }
                          
                          echo '<div class="categoria-icon">' . $first_letter . '</div>
                                <div class="categoria-info">
                                  <div class="categoria-titulo">' . htmlspecialchars($row['titulo']) . '</div>';
                          
                          if (!$liberada) {
                              echo '<div class="bloqueio-mensagem">Complete a categoria anterior</div>';
                          }
                          
                          echo '<div class="categoria-progress">
                                  <div class="categoria-progress-fill" style="width: ' . $cat_percent . '%;"></div>
                                </div>
                              </div>';
                          
                          if ($liberada && $result_primeira->num_rows > 0) {
                              echo '</a>';
                          } else {
                              echo '</div>';
                          }
                          
                          echo '</div>';
                      }
                  }
                  ?>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</body>
</html>