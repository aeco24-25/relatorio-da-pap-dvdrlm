<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: indexuser.php');
    exit();
}

$id_expressao = $_GET['id'];
$username = $_SESSION['username'];

$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

$stmt = $conn->prepare("SELECT e.*, c.titulo as categoria_titulo, c.id_categoria 
                       FROM expressoes e 
                       JOIN categoria c ON e.id_categoria = c.id_categoria 
                       WHERE e.id_expressao = ?");
$stmt->bind_param("i", $id_expressao);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header('Location: indexuser.php');
    exit();
}

$expressao = $result->fetch_assoc();

$stmt_proxima = $conn->prepare("SELECT id_expressao FROM expressoes 
                              WHERE id_categoria = ? AND id_expressao > ? 
                              ORDER BY id_expressao ASC LIMIT 1");
$stmt_proxima->bind_param("ii", $expressao['id_categoria'], $id_expressao);
$stmt_proxima->execute();
$result_proxima = $stmt_proxima->get_result();
$proxima_expressao = $result_proxima->fetch_assoc();

$mensagem = '';
$resposta_correta = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $resposta_usuario = isset($_POST['resposta']) ? trim($_POST['resposta']) : '';
    
    $resposta_correta = (strtolower($resposta_usuario) === strtolower($expressao['traducao_portugues']));
    
    if ($resposta_correta) {
        $mensagem = '<div class="mensagem-sucesso">Correto! Parabéns!</div>';
        
        $stmt = $conn->prepare("INSERT INTO progresso (username, id_expressao, completo) 
                               VALUES (?, ?, TRUE) 
                               ON DUPLICATE KEY UPDATE completo = TRUE");
        $stmt->bind_param("si", $username, $id_expressao);
        $stmt->execute();
    } else {
        $mensagem = '<div class="mensagem-erro">Incorreto. Tente novamente.</div>';
    }
}

$stmt = $conn->prepare("SELECT traducao_portugues FROM expressoes 
                       WHERE id_categoria = ? AND id_expressao != ? 
                       ORDER BY RAND() LIMIT 3");
$stmt->bind_param("ii", $expressao['id_categoria'], $id_expressao);
$stmt->execute();
$result_alternativas = $stmt->get_result();

$alternativas = array();
while ($row = $result_alternativas->fetch_assoc()) {
    $alternativas[] = $row['traducao_portugues'];
}
$alternativas[] = $expressao['traducao_portugues'];
shuffle($alternativas);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Exercício</title>
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
    
    .exercicio-container {
      max-width: 800px;
      margin: 0 auto;
      padding: 20px;
    }
    
    .exercicio-card {
      background-color: transparent;
      padding: 30px;
    }
    
    .exercicio-titulo {
      font-size: 24px;
      font-weight: bold;
      color: #333;
      margin-bottom: 30px;
      text-align: center;
    }
    
    .exercicio-questao {
      font-size: 24px;
      font-weight: bold;
      color: white;
      text-align: center;
      margin: 30px 0;
      padding: 20px;
      background-color: transparent;
    }
    
    .opcoes-container {
      display: grid;
      grid-template-columns: 1fr;
      gap: 15px;
      margin-bottom: 30px;
    }
    
    .opcao-label {
      display: block;
    }
    
    .opcao-radio {
      display: none;
    }
    
    .opcao-escolha {
      padding: 18px;
      background-color: transparent;
      border-radius: 12px;
      cursor: pointer;
      text-align: center;
      transition: all 0.3s ease;
      border: 2px solid #37464f;
      color: white;
      font-size: 18px;
    }
    
    .opcao-escolha:hover {
      background-color: rgba(255, 255, 255, 0.1);
    }
    
    .opcao-radio:checked + .opcao-escolha {
      border-color: #7b6ada;
      background-color: rgba(123, 106, 218, 0.2);
      color: #fff;
      font-weight: 600;
    }
    
    .btn-submeter {
      background-color: #7b6ada;
      color: white;
      border: none;
      border-radius: 12px;
      padding: 16px 24px;
      font-size: 18px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      margin-top: 20px;
      transition: all 0.3s ease;
      text-transform: uppercase;
    }
    
    .btn-submeter:hover {
      background-color: #6a59c9;
    }
    
    .mensagem-sucesso {
      background-color: rgba(123, 106, 218, 0.2);
      border-left: 4px solid #7b6ada;
      color: #fff;
      padding: 18px;
      margin-bottom: 25px;
      border-radius: 8px;
      font-size: 17px;
    }
    
    .mensagem-erro {
      background-color: rgba(255, 75, 75, 0.15);
      border-left: 4px solid #ff4b4b;
      color: #fff;
      padding: 18px;
      margin-bottom: 25px;
      border-radius: 8px;
      font-size: 17px;
    }
    
    .exercicio-completo {
      text-align: center;
      margin-top: 30px;
    }
    
    .exercicio-completo p {
      font-size: 20px;
      margin-bottom: 25px;
      color: #fff;
    }
    
    .btn-proximo {
      background-color: #7b6ada;
    }
    
    .btn-proximo:hover {
      background-color: #6a59c9;
    }
  </style>
</head>

<body>
  
      <div class="exercicio-container">
        <?php echo $mensagem; ?>
        
        <div class="exercicio-card"> 
            <div style="font-size: 25px; color: white; margin-bottom: 15px; font-style: italic;">
              Selecione a opção correta:
            </div>
          <div class="exercicio-questao">
            <?php echo htmlspecialchars($expressao['versao_ingles']); ?>
          </div>
          
          <?php if (!$resposta_correta): ?>
          <form method="POST" class="exercicio-form">
            <div class="opcoes-container">
              <?php foreach ($alternativas as $alternativa): ?>
              <label class="opcao-label">
                <input type="radio" name="resposta" value="<?php echo htmlspecialchars($alternativa); ?>" class="opcao-radio" required>
                <div class="opcao-escolha">
                  <?php echo htmlspecialchars($alternativa); ?>
                </div>
              </label>
              <?php endforeach; ?>
            </div>
            
            <button type="submit" class="btn-submeter">VERIFICAR</button>
          </form>
          <?php else: ?>
          <div class="exercicio-completo">
            <p>Parabéns! Acertas-te! 🎉</p>
            
            <?php if ($proxima_expressao): ?>
            <a href="exercicio.php?id=<?php echo $proxima_expressao['id_expressao']; ?>" class="btn-submeter btn-proximo">
              Próxima Expressão
            </a>
            <?php else: ?>
            <a href="indexuser.php" class="btn-submeter btn-proximo">
              Categoria Completa - Voltar ao Início
            </a>
            <?php endif; ?>
          </div>
          <?php endif; ?>
        </div>
      </div>
    
</body>
</html>