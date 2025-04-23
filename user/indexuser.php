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

// Quantas completou no dia
$sql_hoje = "SELECT COUNT(*) as hoje FROM progresso 
            WHERE username = ? AND completo = TRUE 
            AND DATE(data_conclusao) = CURDATE()";
$stmt_hoje = $conn->prepare($sql_hoje);
$stmt_hoje->bind_param("s", $_SESSION['username']);
$stmt_hoje->execute();
$result_hoje = $stmt_hoje->get_result();
$hoje_row = $result_hoje->fetch_assoc();

// Mostrar no máximo 10 na interface
$completas_hoje_visual = min(10, $hoje_row['hoje']);

// Atualiza a sessão 
$_SESSION['meta_diaria'] = [
    'data' => date('Y-m-d'),
    'completas' => $completas_hoje_visual,
    'completas_real' => $hoje_row['hoje'] // Armazena o valor real internamente
];

// Obter categorias
$sql_categorias = "SELECT id_categoria, titulo FROM categoria ORDER BY id_categoria";
$result_categorias = $conn->query($sql_categorias);

// Obter progresso geral (completas) do utilizador
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

// Calcular percentagem de progresso geral
$percentagem = ($total_expressoes > 0) ? round(($total_completo / $total_expressoes) * 100) : 0;

// Função para coordenadas do arco de progresso
function getProgressCoordinates($percent, $radius) {
    $percent = min(100, max(0, $percent));
    $angle = ($percent / 100) * 360;
    $radians = (($angle - 90) * M_PI) / 180;
    $x = $radius + ($radius * cos($radians));
    $y = $radius + ($radius * sin($radians));
    return round($x, 1) . ' ' . round($y, 1);
}

// Verificar categorias disponibilizadas e completas
$categorias_disponibilizadas = array();
$categorias_completas = array();

$sql_categorias_progresso = "SELECT 
    c.id_categoria, 
    c.titulo,
    COUNT(e.id_expressao) as total,
    SUM(CASE WHEN p.completo = TRUE AND p.username = ? THEN 1 ELSE 0 END) as completas
FROM categoria c
JOIN expressoes e ON c.id_categoria = e.id_categoria
LEFT JOIN progresso p ON e.id_expressao = p.id_expressao AND p.username = ?
GROUP BY c.id_categoria, c.titulo
ORDER BY c.id_categoria";

$stmt = $conn->prepare($sql_categorias_progresso);
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result_categorias_progresso = $stmt->get_result();

$categoria_anterior_completa = true;

while ($row = $result_categorias_progresso->fetch_assoc()) {
    $completa = ($row['completas'] == $row['total']);
    $categorias_completas[$row['id_categoria']] = $completa;
    $categorias_disponibilizadas[$row['id_categoria']] = $categoria_anterior_completa;
    $categoria_anterior_completa = $completa;
}

// Inicializar array de progresso por categoria na sessão se não existir
if (!isset($_SESSION['progresso_categorias'])) {
    $_SESSION['progresso_categorias'] = array();
}

// Ícones para categorias
$categorias_icones = [
    'fa-handshake', 'fa-hotel', 'fa-utensils', 'fa-bus', 
    'fa-exclamation-triangle', 'fa-shopping-bag', 'fa-map-marked-alt', 
    'fa-briefcase', 'fa-laptop-code', 'fa-gamepad'
];
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
  <link rel="stylesheet" href="css/styleindexuser.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
</head>

<body style="background:#f2f0ff;">
  <div id="root">
    <div data-reactroot="">
      <div class="_6t5Uh" style="height: 78px;">
        <div class="NbGcm">
          <div class="_3vDrO">
            <div class="_3I51r _2OF7V">
              <span class="oboa9 _3viv6 HCWXf _3PU7E _3JPjo" style="margin-right: 5px;"></span><span class="_1icRZ _1k9o2 cCL9P"></span>
            </div>
            <div class="_1ALvM"></div>
            <div class="_1G4t1 _3HsQj _2OF7V" data-test="user-dropdown">
              <span class="_3ROGm"><img class="_3Kp8s" src="../assets/images/user2.png" alt="Avatar"></span>
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
          <h1>D<span style="line-height: 1.2; color: rgba(255, 255, 255, 0.75);">Teaches</span></h1>
          </a>
        </div>
      </div>
      <div class="LFfrA _3MLiB">
          <div class="_2_lzu" style="line-height:0.75;">
            <div class="_21w25 _1E3L7" style="background:#7b6ada;">
              <h2 style="text-align: center; color:#ffffff">Progresso Geral</h2>
              <div class="progress-container">
                <div class="progress-circle">
                  <svg height="150" width="150" viewBox="0 0 150 150" aria-labelledby="progress-percent">
                    <circle cx="75" cy="75" r="75" fill="#e2e2e2" />
                    <?php if ($percentagem > 0): ?>
                    <path d="M 75 75 L 75 0 A 75 75 0 <?php echo $percentagem > 50 ? "1" : "0"; ?> 1 <?php echo getProgressCoordinates($percentagem, 75); ?> Z" fill="var(--primary-color)" />
                    <?php endif; ?>
                    <?php if ($percentagem < 100): ?>
                    <path d="M 75 75 L <?php echo getProgressCoordinates($percentagem, 75); ?> A 75 75 0 <?php echo $percentagem > 50 ? "1" : "0"; ?> 0 75 0 Z" fill="#66BB6A" />
                    <?php endif; ?>
                    <circle cx="75" cy="75" r="60" fill="#fcfcff" />
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
            <div class="daily-goal">
                <h3>Meta Diária</h3>
                <div class="goal-progress">
                    <div class="goal-progress-fill" style="width: <?= min(100, ($completas_hoje_visual / 10) * 100) ?>%"></div>
                </div>
                <div class="goal-text">
                    <?= $completas_hoje_visual ?> de 10 expressões hoje<br><br>
                    <?= ($completas_hoje_visual >= 10) ? '🎉 Meta concluída!' : '' ?>
                </div>
            </div>

<div class="gamification-panel">
    <h3>Conquistas</h3>
    <div class="badge-container">
        <?php
        // Badges baseadas no progresso
        $badges = [
            ['icon' => 'fa-medal', 'title' => 'Iniciante', 'earned' => $total_completo > 0],
            ['icon' => 'fa-trophy', 'title' => 'Aprendiz', 'earned' => $total_completo >= 10],
            ['icon' => 'fa-star', 'title' => 'Intermediário', 'earned' => $total_completo >= 30],
            ['icon' => 'fa-crown', 'title' => 'Avançado', 'earned' => $total_completo >= 50],
            ['icon' => 'fa-gem', 'title' => 'Mestre', 'earned' => $total_completo >= 100],
        ];
        
        foreach ($badges as $badge) {
            echo '<div class="badge' . ($badge['earned'] ? ' earned' : '') . '">';
            echo '<i class="fas ' . $badge['icon'] . '"></i>';
            if ($badge['earned']) {
                echo '<span class="badge-tooltip">' . $badge['title'] . '</span>';
            }
            echo '</div>';
        }
        ?>
    </div>
    
    <div class="leaderboard">
        <h3>Classificação</h3>
        <?php
        // Obter top 5 utilizadores
        $sql_leaderboard = "SELECT username, COUNT(*) as score 
                          FROM progresso 
                          WHERE completo = TRUE 
                          GROUP BY username 
                          ORDER BY score DESC";
        $result_leaderboard = $conn->query($sql_leaderboard);
        
        if ($result_leaderboard->num_rows > 0) {
            echo '<ol>';
            $position = 1;
            while ($row = $result_leaderboard->fetch_assoc()) {
                $highlight = ($row['username'] == $_SESSION['username']) ? 'highlight' : '';
                echo '<li class="' . $highlight . '">';
                echo '<span class="position">' . $position . '</span>';
                echo '<span class="username">' . htmlspecialchars($row['username']) . '</span>';
                echo '<span class="score">' . $row['score'] . ' pts</span>';
                echo '</li>';
                $position++;
            }
            echo '</ol>';
        } else {
            echo '<p>Ainda não há classificações disponíveis.</p>';
        }
        ?>
    </div>
</div>
          </div>
          
          <div class="_3MT-S">
              <div class="_2hEQd _1E3L7" style="background:#7b6ada;">
                <h2 style="margin-top: -10px; margin-bottom: 20px; text-align: center; color:#ffffff;">Categorias</h2>
                <div style="max-width: 800px; margin: 0 auto;">
                  <?php
                  $result_categorias->data_seek(0);
                  if ($result_categorias->num_rows > 0) {
                      while($row = $result_categorias->fetch_assoc()) {
                          $cat_id = $row['id_categoria'];
                          $disponibilizada = isset($categorias_disponibilizadas[$cat_id]) && $categorias_disponibilizadas[$cat_id];
                          $completa = isset($categorias_completas[$cat_id]) && $categorias_completas[$cat_id];
                          
                          // Obter progresso da categoria
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
                          
                          echo '<div class="categoria-card' . (!$disponibilizada ? ' categoria-bloqueada' : '') . ($completa ? ' categoria-completa' : '') . '">';                        
                                                
                          if ($disponibilizada || $completa) {
                            $sql_primeira = "SELECT e.id_expressao 
                                            FROM expressoes e
                                            LEFT JOIN progresso p ON e.id_expressao = p.id_expressao AND p.username = '$username' AND p.completo = TRUE
                                            WHERE e.id_categoria = $cat_id AND p.id_expressao IS NULL
                                            ORDER BY e.id_expressao ASC LIMIT 1";
                            
                            $result_primeira = $conn->query($sql_primeira);
                            
                            if ($result_primeira->num_rows === 0) {
                                $sql_primeira_expressao = "SELECT id_expressao FROM expressoes 
                                                         WHERE id_categoria = $cat_id 
                                                         ORDER BY id_expressao ASC LIMIT 1";
                                $result_primeira = $conn->query($sql_primeira_expressao);
                            }
                            
                            if ($result_primeira->num_rows > 0) {
                                $primeira_row = $result_primeira->fetch_assoc();
                                echo '<a href="exercicio.php?id=' . $primeira_row['id_expressao'] . '" style="text-decoration: none; color: inherit; display: flex; width: 100%;">';
                            } else {
                                echo '<div style="display: flex; width: 100%;">';
                            }
                        } else {
                            echo '<div style="display: flex; width: 100%;">';
                        }
                          
                          $icon = $categorias_icones[$cat_id - 1] ?? 'fa-folder';
                          echo '<div class="categoria-icon"><i class="fas ' . $icon . '"></i></div>';
                          
                          echo '<div class="categoria-info">
                                  <div class="categoria-titulo">' . htmlspecialchars($row['titulo']) . '</div>';
                          
                          if (!$disponibilizada) {
                              echo '<div class="bloqueio-mensagem">Bloqueado</div>';
                          }
                          
                          echo '<div class="categoria-progress">
                                  <div class="categoria-progress-fill" style="width: ' . $cat_percent . '%;"></div>
                                </div>
                              </div>';
                          
                          if (($disponibilizada || $completa) && isset($primeira_row)) {
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