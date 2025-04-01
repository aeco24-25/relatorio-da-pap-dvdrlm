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
    die("Erro de conexão: " . $conn->connect_error);
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
        $stmt = $conn->prepare("INSERT INTO progresso (username, id_expressao, completo) 
                               VALUES (?, ?, TRUE) 
                               ON DUPLICATE KEY UPDATE completo = TRUE");
        $stmt->bind_param("si", $username, $id_expressao);
        $stmt->execute();
    } else {
        $mensagem = '<div class="mensagem-erro"><i class="fas fa-times"></i> Incorreto. Tente novamente.</div>';
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
<html lang="pt-PT">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Exercício</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <style>
    body {
      background-color: #1a1a2e;
      color: #fff;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 20px;
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
    
    .instrucao {
      font-size: 1.3rem;
      color: #fff;
      margin-bottom: 25px;
      font-style: italic;
      text-align: center;
    }
    
    .exercicio-questao {
      font-size: 1.8rem;
      font-weight: bold;
      text-align: center;
      margin: 40px 0;
      padding: 25px;
      background-color: rgba(55, 70, 79, 0.3);
      border-radius: 12px;
      border-left: 4px solid #7b6ada;
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
      padding: 20px;
      background-color: transparent;
      border-radius: 12px;
      cursor: pointer;
      text-align: center;
      transition: all 0.3s;
      border: 2px solid #37464f;
      color: #fff;
      font-size: 1.2rem;
    }
    
    .opcao-escolha:hover {
      background-color: rgba(255, 255, 255, 0.05);
    }
    
    .opcao-radio:checked + .opcao-escolha {
      border-color: #7b6ada;
      background-color: rgba(123, 106, 218, 0.2);
      font-weight: 600;
    }
    
    .btn-submeter {
      background-color: #7b6ada;
      color: white;
      border: none;
      border-radius: 12px;
      padding: 18px;
      font-size: 1.2rem;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      margin-top: 30px;
      transition: all 0.3s;
    }
    
    .btn-submeter:hover {
      background-color: #6a59c9;
    }
    
    .mensagem-erro {
      background-color: rgba(231, 76, 60, 0.15);
      border-left: 4px solid #e74c3c;
      color: #fff;
      padding: 20px;
      margin-bottom: 30px;
      border-radius: 8px;
      font-size: 1.1rem;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .exercicio-completo {
      text-align: center;
      margin-top: 40px;
    }
    
    .resposta-correta {
      font-size: 1.5rem;
      color: #2ecc71;
      margin: 30px 0;
      font-weight: bold;
    }
    
    .traducao-container {
      background-color: rgba(55, 70, 79, 0.3);
      padding: 25px;
      border-radius: 12px;
      margin: 30px 0;
    }
    
    .fas {
      margin-right: 10px;
    }
  </style>
</head>

<body>
  <div class="exercicio-container">
    <div class="exercicio-card">
      <?php echo $mensagem; ?>
      
      <?php if (!$resposta_correta): ?>
        <div class="instrucao">
         Selecione a opção correta
        </div>
        
        <div class="exercicio-questao">
          <?php echo htmlspecialchars($expressao['versao_ingles']); ?>
        </div>
        
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
          
          <button type="submit" class="btn-submeter">
            <i class="fas fa-check"></i> Verificar
          </button>
        </form>
      <?php else: ?>
        <div class="exercicio-completo">
          <div class="resposta-correta">
            <i class="fas fa-check-circle"></i> Resposta Correta!
          </div>
          
          <div class="traducao-container">
            <p><strong><?php echo htmlspecialchars($expressao['versao_ingles']); ?></strong></p>
            <p><i class="fas fa-arrow-down"></i></p>
            <p><strong><?php echo htmlspecialchars($expressao['traducao_portugues']); ?></strong></p>
          </div>
          
          <?php if ($proxima_expressao): ?>
            <a href="exercicio.php?id=<?php echo $proxima_expressao['id_expressao']; ?>" class="btn-submeter">
              <i class="fas fa-arrow-right"></i> Próxima Expressão
            </a>
          <?php else: ?>
            <a href="indexuser.php" class="btn-submeter">
              <i class="fas fa-home"></i> Voltar ao Início
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
  
  <script src="../assets/js/fontawesome.js"></script>
</body>
</html>