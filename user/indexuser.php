<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

// Conectar à base de dados
$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

// Obtem as categorias para o menu
$sql_categorias = "SELECT id_categoria, titulo FROM categoria ORDER BY id_categoria";
$result_categorias = $conn->query($sql_categorias);

// Obtem o progresso do utilizador
$username = $_SESSION['username'];
$sql_progresso = "SELECT COUNT(*) as total_completo FROM progresso WHERE username = ? AND completo = TRUE";
$stmt = $conn->prepare($sql_progresso);
$stmt->bind_param("s", $username);
$stmt->execute();
$result_progresso = $stmt->get_result();
$progresso_row = $result_progresso->fetch_assoc();
$total_completo = $progresso_row['total_completo'];

// Obtem total de expressões
$sql_total = "SELECT COUNT(*) as total FROM expressoes";
$result_total = $conn->query($sql_total);
$total_row = $result_total->fetch_assoc();
$total_expressoes = $total_row['total'];

// Calcula percentagem para mostrar no progresso
$percentagem = ($total_expressoes > 0) ? round(($total_completo / $total_expressoes) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Início</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  <link href="ltr-6a8f5d2e.css" rel="stylesheet">
  
  <style>
    .progress-circle {
      position: relative;
      width: 150px;
      height: 150px;
    }
    
    .progress-circle-bg {
      fill: #e2e2e2;
    }
    
    .progress-circle-fill {
      fill: #78c800;
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
      background-color: #1cb0f6;
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
      margin-top: 10px;
    }
    
    .categoria-progress-fill {
      height: 100%;
      background-color: #78c800;
      border-radius: 5px;
      transition: width 0.3s ease;
    }
  </style>
</head>

<body>
  <div id="root">
    <div data-reactroot="">
      <div class="_6t5Uh" style="height: 78px;">
        <div class="NbGcm">
          <div class="_3vDrO">
            <div class="_3I51r _2OF7V">
              <span class="oboa9 _3viv6 HCWXf _3PU7E _3JPjo"></span><span class="_1icRZ _1k9o2 cCL9P"></span>
              <div class="_2LqjD">
                <ul class="_20LC5 _2HujR _1ZY-H">
                  <li class="qsrrc"></li>
                  <?php
                  if ($result_categorias->num_rows > 0) {
                      while($row = $result_categorias->fetch_assoc()) {
                          echo '<li class="_2uBp_ _1qBnH"><a href="categoria.php?id=' . $row['id_categoria'] . '">' . htmlspecialchars($row['titulo']) . '</a></li>';
                      }
                  }
                  ?>
                </ul>
              </div>
            </div>
            <div class="_1ALvM"></div>
            <div class="_1G4t1 _3HsQj _2OF7V" data-test="user-dropdown">
              <span class="_3ROGm"><img class="_3Kp8s" src="../assets/images/user.png" alt="Avatar"></span><span><?php echo htmlspecialchars($username); ?></span><span class="_2Vgy6 _1k0u2 cCL9P"></span>
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
          </div><a style="margin-left: 45px; background-position: -234px; height: 35px; width: 235px; background-size: cover; background-image:url(dteaches.png);" class="NJXKT _1nAJB cCL9P _2s5Eb" data-test="topbar-logo" href="indexuser.php"></a>
        </div>
      </div>
      <div class="LFfrA _3MLiB">
          <div class="_2_lzu">
            <div class="_21w25 _1E3L7">
              <h2>Progresso Geral</h2>
              <div class="_2PIra">
                <div class="Rbutm">
                  <span class="_25O1e _2na4C cCL9P _1wV8Y"></span>
                  <div class="_3Ttma">
                    <svg height="150" width="150" viewBox="0 0 150 150">
                      <circle cx="75" cy="75" r="75" fill="#e2e2e2" />
                      <?php if ($percentagem > 0): ?>
                      <path d="M 75 75 L 75 0 A 75 75 0 <?php echo $percentagem > 50 ? "1" : "0"; ?> 1 <?php echo getProgressCoordinates($percentagem, 75); ?> Z" fill="#78c800" />
                      <?php endif; ?>
                      <?php if ($percentagem < 100): ?>
                      <path d="M 75 75 L <?php echo getProgressCoordinates($percentagem, 75); ?> A 75 75 0 <?php echo $percentagem > 50 ? "1" : "0"; ?> 0 75 0 Z" fill="#e2e2e2" />
                      <?php endif; ?>
                      <circle cx="75" cy="75" r="60" fill="#ffffff" />
                      <text x="75" y="80" font-size="24" text-anchor="middle" fill="#333"><?php echo $percentagem; ?>%</text>
                    </svg>
                  </div>
                </div>
                <div class="_1h5j2">
                  <div class="g-M5R">
                    <?php echo $total_completo; ?>
                  </div><span>expressões aprendidas</span>
                  <div class="g-M5R">
                    <?php echo $total_expressoes - $total_completo; ?>
                  </div><span>expressões por aprender</span>
                </div>
              </div>
            </div>
          </div>
          <div class="_3MT-S">
              <div class="_2hEQd _1E3L7">
                <h2 style="margin-bottom: 20px;">Categorias</h2>
                <div style="max-width: 800px; margin: 0 auto;">
                  <?php
                  $result_categorias->data_seek(0);
                  if ($result_categorias->num_rows > 0) {
                      while($row = $result_categorias->fetch_assoc()) {
                          // Obter o número de expressões nesta categoria
                          $cat_id = $row['id_categoria'];
                          $sql_count = "SELECT COUNT(*) as total FROM expressoes WHERE id_categoria = $cat_id";
                          $result_count = $conn->query($sql_count);
                          $count_row = $result_count->fetch_assoc();
                          $total_cat = $count_row['total'];
                          
                          // Obter progresso na categoria
                          $sql_prog = "SELECT COUNT(*) as completo FROM expressoes e 
                                      JOIN progresso p ON e.id_expressao = p.id_expressao 
                                      WHERE e.id_categoria = $cat_id AND p.username = '$username' AND p.completo = TRUE";
                          $result_prog = $conn->query($sql_prog);
                          $prog_row = $result_prog->fetch_assoc();
                          $completo_cat = $prog_row['completo'];
                          
                          // Calcular percentagem para esta categoria
                          $cat_percent = ($total_cat > 0) ? round(($completo_cat / $total_cat) * 100) : 0;
                          
                          // Criar a primeira letra como ícone
                          $first_letter = strtoupper(substr($row['titulo'], 0, 1));
                          
                          echo '<a href="categoria.php?id=' . $cat_id . '" style="text-decoration: none; color: inherit;">
                                <div class="categoria-card">
                                  <div class="categoria-icon">' . $first_letter . '</div>
                                  <div class="categoria-info">
                                    <div class="categoria-titulo">' . htmlspecialchars($row['titulo']) . '</div>
                                    <div>' . $completo_cat . ' de ' . $total_cat . ' expressões aprendidas</div>
                                    <div class="categoria-progress">
                                      <div class="categoria-progress-fill" style="width: ' . $cat_percent . '%;"></div>
                                    </div>
                                  </div>
                                </div>
                              </a>';
                      }
                  }
                  ?>
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>

<?php
// Função para calcular as coordenadas do arco SVG com base na percentagem
function getProgressCoordinates($percent, $radius) {
    $percent = min(100, max(0, $percent)); // Limitar entre 0-100
    $angle = ($percent / 100) * 360;
    $radians = (($angle - 90) * M_PI) / 180; // -90 para começar do topo
    $x = $radius + ($radius * cos($radians));
    $y = $radius + ($radius * sin($radians));
    return round($x, 1) . ' ' . round($y, 1);
}
?>
</body>
</html>