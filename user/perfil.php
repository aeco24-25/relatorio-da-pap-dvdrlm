<?php
// Iniciar sessão
session_start();

// Verificar autenticação do utilizador
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

$username = $_SESSION['username'];

// Estabelecer ligação à base de dados
$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

// Obter informações do utilizador
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Calcular estatísticas
$stmt = $conn->prepare("SELECT COUNT(*) as total_expressoes FROM expressoes");
$stmt->execute();
$result = $stmt->get_result();
$total_row = $result->fetch_assoc();
$total_expressoes = $total_row['total_expressoes'];

$stmt = $conn->prepare("SELECT COUNT(*) as total_completo FROM progresso WHERE username = ? AND completo = TRUE");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$completo_row = $result->fetch_assoc();
$total_completo = $completo_row['total_completo'];

// Calcular percentagem de progresso geral
$percentagem_total = ($total_expressoes > 0) ? round(($total_completo / $total_expressoes) * 100) : 0;

// Obter número de categorias em que o utilizador já tem expressões aprendidas
$stmt = $conn->prepare("SELECT COUNT(DISTINCT c.id_categoria) as categorias_estudadas 
                        FROM categoria c
                        JOIN expressoes e ON c.id_categoria = e.id_categoria
                        JOIN progresso p ON e.id_expressao = p.id_expressao 
                        WHERE p.username = ? AND p.completo = TRUE");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$categorias_row = $result->fetch_assoc();
$categorias_estudadas = $categorias_row['categorias_estudadas'];

// Obter progresso por categoria (apenas para categorias que o utilizador está estudando)
$sql = "SELECT c.id_categoria, c.titulo, 
        COUNT(e.id_expressao) as total_categoria,
        COUNT(p.id_expressao) as completo_categoria
        FROM categoria c
        JOIN expressoes e ON c.id_categoria = e.id_categoria
        LEFT JOIN progresso p ON e.id_expressao = p.id_expressao AND p.username = ? AND p.completo = TRUE
        WHERE EXISTS (
            SELECT 1 FROM progresso p2 
            JOIN expressoes e2 ON p2.id_expressao = e2.id_expressao
            WHERE p2.username = ? AND p2.completo = TRUE AND e2.id_categoria = c.id_categoria
        )
        GROUP BY c.id_categoria
        ORDER BY c.id_categoria";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $username);
$stmt->execute();
$result_categorias = $stmt->get_result();

// Formatar a data de criação da conta
$data_criacao = new DateTime($user['data_criacao']);
$data_criacao_formatada = $data_criacao->format('d/m/Y');
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Perfil</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">  
  <link rel="stylesheet" href="css/styleperfil.css">  
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

</head>

<body style="background:#7b6ada;">
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
        <a class="_19E7J" href="indexuser.php">« Voltar</a>
      </div>
      
      <div class="perfil-container">
        <div class="perfil-header">
          <div class="perfil-avatar">
            <?php echo strtoupper(substr($username, 0, 1)); ?>
          </div>
          <div class="perfil-info">
            <div class="perfil-nome"><?php echo htmlspecialchars($username); ?></div>
            <div class="perfil-email"><?php echo htmlspecialchars($user['email']); ?></div>
            <div class="perfil-data">Membro desde: <?php echo $data_criacao_formatada; ?></div>
          </div>
        </div>
        
        <div class="perfil-estatisticas">
          <div class="estatistica-card">
            <div class="estatistica-valor"><?php echo $total_completo; ?></div>
            <div class="estatistica-label">Expressões Aprendidas</div>
          </div>
          <div class="estatistica-card">
            <div class="estatistica-valor"><?php echo $percentagem_total; ?>%</div>
            <div class="estatistica-label">Progresso Total</div>
          </div>
          <div class="estatistica-card">
            <div class="estatistica-valor"><?php echo $categorias_estudadas; ?></div>
            <div class="estatistica-label">Categorias Estudadas</div>
          </div>
        </div>
        
        <div class="progresso-titulo">Progresso por Categoria</div>
        
        <?php 
        if ($result_categorias->num_rows > 0) {
            while ($categoria = $result_categorias->fetch_assoc()) {
                $total_cat = $categoria['total_categoria'];
                $completo_cat = $categoria['completo_categoria'];
                $percentagem_cat = ($total_cat > 0) ? round(($completo_cat / $total_cat) * 100) : 0;
        ?>
        <div class="categoria-progresso">
          <div class="categoria-nome"><?php echo htmlspecialchars($categoria['titulo']); ?></div>
          <div class="categoria-estatisticas">
            <div><?php echo $completo_cat; ?> de <?php echo $total_cat; ?> expressões</div>
            <div><?php echo $percentagem_cat; ?>% completo</div>
          </div>
          <div class="progresso-barra">
            <div class="progresso-preenchido" style="width: <?php echo $percentagem_cat; ?>%;"></div>
          </div>
        </div>
        <?php
            }
        } else {
          // Mensagem quando não há progresso em nenhuma categoria
          echo 'Ainda não completaste nenhuma expressão.';
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>