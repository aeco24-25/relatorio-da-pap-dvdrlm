<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: indexuser.php');
    exit();
}

$id_categoria = $_GET['id'];
$username = $_SESSION['username'];

$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT titulo, conteudo FROM categoria WHERE id_categoria = ?");
$stmt->bind_param("i", $id_categoria);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: indexuser.php');
    exit();
}

$categoria = $result->fetch_assoc();

$stmt = $conn->prepare("SELECT e.*, p.completo 
                       FROM expressoes e 
                       LEFT JOIN progresso p ON e.id_expressao = p.id_expressao AND p.username = ? 
                       WHERE e.id_categoria = ? 
                       ORDER BY e.id_expressao");
$stmt->bind_param("si", $username, $id_categoria);
$stmt->execute();
$expressoes = $stmt->get_result();

$total_expressoes = $expressoes->num_rows;
$expressoes_completas = 0;
$expressoes_array = array();

while ($row = $expressoes->fetch_assoc()) {
    $expressoes_array[] = $row;
    if ($row['completo']) {
        $expressoes_completas++;
    }
}

$percentagem = ($total_expressoes > 0) ? round(($expressoes_completas / $total_expressoes) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - <?php echo htmlspecialchars($categoria['titulo']); ?></title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  <link href="ltr-6a8f5d2e.css" rel="stylesheet">
  <link href="custom-styles.css" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

  <style>
    .logo {
      margin-top: 16px;
      margin-left: 50px;
      display: inline-block;
    }

    h1 {
      font-family: 'Poppins', sans-serif !important;
      margin-top: -5px;
      margin-bottom: 0px;
      font-size: 46px;
      text-transform: uppercase;
      color: #fff;
      font-weight: 700;
      margin-right: 20px;
      padding-right: 20px;
    }
    
    .categoria-container {
      max-width: 800px;
      margin: 0 auto;
      margin-top: 110px;
      padding: 20px;
    }
    
    .categoria-header {
      background-color: white;
      border-radius: 12px;
      padding: 30px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .categoria-titulo {
      font-size: 28px;
      font-weight: bold;
      color: #333;
      margin-bottom: 15px;
    }
    
    .categoria-conteudo {
      font-size: 16px;
      color: #666;
      line-height: 1.6;
    }
    
    .progresso-container {
      background-color: white;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .progresso-titulo {
      font-size: 18px;
      font-weight: bold;
      color: #333;
      margin-bottom: 15px;
    }
    
    .progresso-barra {
      height: 20px;
      background-color: #e5e5e5;
      border-radius: 10px;
      overflow: hidden;
      margin-bottom: 10px;
    }
    
    .progresso-preenchido {
      height: 100%;
      background-color: #78c800;
      border-radius: 10px;
      transition: width 0.5s ease;
    }
    
    .progresso-texto {
      font-size: 14px;
      color: #666;
      text-align: center;
    }
    
    .card-expressao {
      background-color: white;
      border-radius: 12px;
      padding: 25px;
      margin-bottom: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      position: relative;
    }
    
    .completo {
      position: absolute;
      top: 15px;
      right: 15px;
      background-color: #78c800;
      color: white;
      padding: 5px 10px;
      border-radius: 20px;
      font-size: 12px;
      font-weight: bold;
    }
    
    .expressao-ingles {
      font-size: 20px;
      font-weight: bold;
      color: #1cb0f6;
      margin-bottom: 10px;
    }
    
    .expressao-portugues {
      font-size: 16px;
      color: #333;
      margin-bottom: 20px;
    }
    
    .btn-practice {
      background-color: #1cb0f6;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 10px 20px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    
    .btn-practice:hover {
      background-color: #0c8ed2;
    }
    
    .sem-expressoes {
      background-color: white;
      border-radius: 12px;
      padding: 30px;
      text-align: center;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      color: #666;
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
            </div>
            <div class="_1ALvM"></div>
            <div class="_1G4t1 _3HsQj _2OF7V" data-test="user-dropdown">
              <span class="_3ROGm"><img class="_3Kp8s" src="../assets/images/user.png" alt="Avatar"></span><span style="margin-left:-5px; font-family: 'Poppins', sans-serif !important;"><?php echo htmlspecialchars($username); ?></span><span class="_2Vgy6 _1k0u2 cCL9P"></span>
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
        <a class="_19E7J" href="indexuser.php">« Voltar</a>
      </div>
      
      <div class="categoria-container">
        <div class="categoria-header">
          <h1 class="categoria-titulo"><?php echo htmlspecialchars($categoria['titulo']); ?></h1>
          <div class="categoria-conteudo"><?php echo nl2br(htmlspecialchars($categoria['conteudo'])); ?></div>
        </div>
        
        <div class="progresso-container">
          <div class="progresso-titulo">Seu Progresso</div>
          <div class="progresso-barra">
            <div class="progresso-preenchido" style="width: <?php echo $percentagem; ?>%;"></div>
          </div>
          <div class="progresso-texto">
            <?php echo $expressoes_completas; ?> de <?php echo $total_expressoes; ?> expressões aprendidas (<?php echo $percentagem; ?>%)
          </div>
        </div>
        
        <?php if (!empty($expressoes_array)): ?>
          <?php foreach ($expressoes_array as $expressao): ?>
          <div class="card-expressao">
            <?php if ($expressao['completo']): ?>
            <div class="completo">✓ Completo</div>
            <?php endif; ?>
            
            <div class="expressao-ingles"><?php echo htmlspecialchars($expressao['versao_ingles']); ?></div>
            <div class="expressao-portugues"><?php echo htmlspecialchars($expressao['traducao_portugues']); ?></div>
            
            <form action="exercicio.php" method="GET">
              <input type="hidden" name="id" value="<?php echo $expressao['id_expressao']; ?>">
              <button type="submit" class="btn-practice">
                <?php echo $expressao['completo'] ? 'Praticar novamente' : 'Praticar'; ?>
              </button>
            </form>
          </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="sem-expressoes">
            <p>Ainda não existem expressões nesta categoria.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</body>
</html>