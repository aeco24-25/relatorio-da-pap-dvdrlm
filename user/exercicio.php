<?php
// Iniciar sessão
session_start();

// Verificar autenticação do utilizador
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

// Verificar se foi fornecido um ID de expressão
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: indexuser.php');
    exit();
}

// Definir variáveis
$id_expressao = $_GET['id'];
$username = $_SESSION['username'];

// Estabelecer ligação à base de dados
$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

// Obter informações da expressão
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

// Variáveis para processamento da resposta
$mensagem = '';
$resposta_correta = false;

// Processar resposta do utilizador
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_exercicio = isset($_POST['tipo']) ? $_POST['tipo'] : 'normal';
    $resposta_usuario = trim($_POST['resposta']);
    
    // Verificar resposta com base no tipo de exercício
    if ($tipo_exercicio === 'inverso') {
        // Comparar com a versão em inglês
        $resposta_correta = (strtolower($resposta_usuario) === strtolower($expressao['versao_ingles']));
    } else {
        // Comparar com a tradução em português
        $resposta_correta = (strtolower($resposta_usuario) === strtolower($expressao['traducao_portugues']));
    }
    
    // Processar resultado da resposta
    if ($resposta_correta) {
        $mensagem = '<div class="mensagem-sucesso">Correto! Parabéns!</div>';
        
        // Atualizar progresso do utilizador
        $stmt = $conn->prepare("INSERT INTO progresso (username, id_expressao, completo) 
                               VALUES (?, ?, TRUE) 
                               ON DUPLICATE KEY UPDATE completo = TRUE");
        $stmt->bind_param("si", $username, $id_expressao);
        $stmt->execute();
    } else {
        $mensagem = '<div class="mensagem-erro">Incorreto. Tente novamente.</div>';
    }
}

// Obter expressões da mesma categoria para opções múltipla escolha
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

// Adicionar a resposta correta e embaralhar
$alternativas[] = $expressao['traducao_portugues'];
shuffle($alternativas);

// Determinar o tipo de exercício (aleatório entre 1-3)
$tipo_exercicio = isset($_GET['tipo']) ? $_GET['tipo'] : rand(1, 3);
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
        <a class="_19E7J" href="categoria.php?id=<?php echo $expressao['id_categoria']; ?>">« Voltar à categoria</a>
      </div>
      
      <div class="exercicio-container">
        <?php echo $mensagem; ?>
        
        <div class="exercicio-card">
          <div class="exercicio-titulo">
            Exercício de <?php echo htmlspecialchars($expressao['categoria_titulo']); ?>
          </div>
          
          <?php if ($tipo_exercicio == 1): ?>
          <!-- Exercício Tipo 1: Tradução Direta -->
          <div class="exercicio-instrucoes">
            Traduza a expressão em inglês para português:
          </div>
          <div class="exercicio-questao">
            "<?php echo htmlspecialchars($expressao['versao_ingles']); ?>"
          </div>
          
          <form method="POST" class="exercicio-form">
            <input type="text" name="resposta" class="exercicio-input" placeholder="Digite a tradução em português" required autofocus>
            <button type="submit" class="btn-submeter">Verificar</button>
          </form>
          
          <?php elseif ($tipo_exercicio == 2): ?>
          <!-- Exercício Tipo 2: Escolha Múltipla -->
          <div class="exercicio-instrucoes">
            Escolha a tradução correta para a expressão em inglês:
          </div>
          <div class="exercicio-questao">
            "<?php echo htmlspecialchars($expressao['versao_ingles']); ?>"
          </div>
          
          <form method="POST" class="exercicio-form">
            <div class="opcoes-container">
              <?php foreach ($alternativas as $alternativa): ?>
              <div class="opcao-escolha" onclick="document.getElementById('resposta-<?php echo md5($alternativa); ?>').checked = true;">
                <input type="radio" id="resposta-<?php echo md5($alternativa); ?>" name="resposta" value="<?php echo htmlspecialchars($alternativa); ?>" style="display:none;">
                <?php echo htmlspecialchars($alternativa); ?>
              </div>
              <?php endforeach; ?>
            </div>
            <button type="submit" class="btn-submeter" style="margin-top: 20px;">Verificar</button>
          </form>
          
          <?php else: ?>
          <!-- Exercício Tipo 3: Português para Inglês -->
          <div class="exercicio-instrucoes">
            Escreva em inglês a expressão:
          </div>
          <div class="exercicio-questao">
            "<?php echo htmlspecialchars($expressao['traducao_portugues']); ?>"
          </div>
          
          <form method="POST" class="exercicio-form">
            <input type="text" name="resposta" class="exercicio-input" placeholder="Digite a expressão em inglês" required autofocus>
            <input type="hidden" name="tipo" value="inverso">
            <button type="submit" class="btn-submeter">Verificar</button>
          </form>
          <?php endif; ?>
          
          <?php if ($resposta_correta): ?>
          <div style="margin-top: 30px; text-align: center;">
            <p style="font-size: 18px; margin-bottom: 20px;">
              <strong>🎉 Parabéns! 🎉</strong><br>
              Você aprendeu esta expressão corretamente!
            </p>
            
            <a href="categoria.php?id=<?php echo $expressao['id_categoria']; ?>" class="btn-submeter">
              Continuar Aprendendo
            </a>
          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
  
  <script>
    // Script para marcar as opções de múltipla escolha ao clicar
    document.querySelectorAll('.opcao-escolha').forEach(function(opcao) {
      opcao.addEventListener('click', function() {
        // Limpar todas as seleções anteriores
        document.querySelectorAll('.opcao-escolha').forEach(function(item) {
          item.style.backgroundColor = '#f5f5f5';
          item.style.borderColor = '#e0e0e0';
        });
        
        // Marcar a opção selecionada
        this.style.backgroundColor = '#e8f4fd';
        this.style.borderColor = '#1cb0f6';
      });
    });
  </script>
</body>
</html>