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

if (isset($_GET['sair'])) {
  header("Location: indexuser.php");
  exit();
}

$id_expressao = $_GET['id'];
$username = $_SESSION['username'];

if (!isset($_SESSION['lives'])) {
    $_SESSION['lives'] = 5;
}

if (!isset($_SESSION['erros_atual'])) {
    $_SESSION['erros_atual'] = array();
}

// Inicializar progresso da sessão
if (!isset($_SESSION['progresso_sessao'])) {
    $_SESSION['progresso_sessao'] = array(
        'categoria_atual' => null,
        'expressoes_completas' => array(),
        'total_expressoes' => 0
    );
}

$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Obter expressão principal
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

// Verificar se mudou de categoria
if ($_SESSION['progresso_sessao']['categoria_atual'] != $expressao['id_categoria']) {
    $_SESSION['progresso_sessao'] = array(
        'categoria_atual' => $expressao['id_categoria'],
        'expressoes_completas' => array(),
        'total_expressoes' => 0
    );
    
    // Obter total de expressões na categoria
    $stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM expressoes WHERE id_categoria = ?");
    $stmt_total->bind_param("i", $expressao['id_categoria']);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $_SESSION['progresso_sessao']['total_expressoes'] = $result_total->fetch_assoc()['total'];
}

// Verificar progresso no banco de dados
$stmt_first_view = $conn->prepare("SELECT completo FROM progresso 
                                 WHERE username = ? AND id_expressao = ?");
$stmt_first_view->bind_param("si", $username, $id_expressao);
$stmt_first_view->execute();
$result_first_view = $stmt_first_view->get_result();
$first_view = ($result_first_view->num_rows === 0);

// Obter próxima expressão
$stmt_proxima = $conn->prepare("SELECT id_expressao FROM expressoes 
                              WHERE id_categoria = ? AND id_expressao > ? 
                              ORDER BY id_expressao ASC LIMIT 1");
$stmt_proxima->bind_param("ii", $expressao['id_categoria'], $id_expressao);
$stmt_proxima->execute();
$result_proxima = $stmt_proxima->get_result();
$proxima_expressao = $result_proxima->fetch_assoc();

// Obter exemplos de uso
$stmt_exemplos = $conn->prepare("SELECT exemplo FROM exemplos WHERE id_expressao = ?");
$stmt_exemplos->bind_param("i", $id_expressao);
$stmt_exemplos->execute();
$result_exemplos = $stmt_exemplos->get_result();

$mensagem = '';
$resposta_correta = false;
$mostrar_explicacao = $first_view && !isset($_POST['pular_explicacao']);
$mostrar_resumo_erros = isset($_POST['finalizar_sessao']) && !empty($_SESSION['erros_atual']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pular_explicacao'])) {
        $mostrar_explicacao = false;
    } 
    elseif (isset($_POST['finalizar_sessao'])) {
        $_SESSION['erros_atual'] = array();
        header("Location: exercicio.php?id=$id_expressao");
        exit();
    }
    else {
        $resposta_usuario = isset($_POST['resposta']) ? trim($_POST['resposta']) : '';
        
        $resposta_correta_db = strtolower(trim($expressao['traducao_portugues']));
        $resposta_usuario_normalized = strtolower(trim($resposta_usuario));
        
        $resposta_correta = ($resposta_usuario_normalized === $resposta_correta_db);
        
        if ($resposta_correta) {
            $stmt = $conn->prepare("INSERT INTO progresso (username, id_expressao, completo) 
                                   VALUES (?, ?, TRUE) 
                                   ON DUPLICATE KEY UPDATE completo = TRUE");
            $stmt->bind_param("si", $username, $id_expressao);
            $stmt->execute();
            
            if (!in_array($id_expressao, $_SESSION['progresso_sessao']['expressoes_completas'])) {
                $_SESSION['progresso_sessao']['expressoes_completas'][] = $id_expressao;
            }
            
            if (($key = array_search($id_expressao, $_SESSION['erros_atual'])) !== false) {
                unset($_SESSION['erros_atual'][$key]);
            }
        } else {
            $_SESSION['lives']--;
            $mensagem = '<div class="mensagem-erro"><i class="fas fa-times"></i> Incorreto. Tente novamente.</div>';
            
            if (!in_array($id_expressao, $_SESSION['erros_atual'])) {
                $_SESSION['erros_atual'][] = $id_expressao;
            }
            
            if ($_SESSION['lives'] <= 0) {
                $_SESSION['lives'] = 5;
                $mostrar_resumo_erros = true;
            }
        }
    }
}

// Obter alternativas para a questão
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

// Se for mostrar resumo de erros, buscar detalhes das expressões erradas
$expressoes_erradas = array();
if ($mostrar_resumo_erros && !empty($_SESSION['erros_atual'])) {
    $ids_erros = implode(",", $_SESSION['erros_atual']);
    $stmt_erros = $conn->prepare("SELECT * FROM expressoes WHERE id_expressao IN ($ids_erros)");
    $stmt_erros->execute();
    $result_erros = $stmt_erros->get_result();
    
    while ($erro = $result_erros->fetch_assoc()) {
        $expressoes_erradas[] = $erro;
    }
}

// Calcular progresso atual para mostrar na barra
$progresso_atual = count($_SESSION['progresso_sessao']['expressoes_completas']);
$total_expressoes_categoria = $_SESSION['progresso_sessao']['total_expressoes'];
$percentagem = ($total_expressoes_categoria > 0) ? round(($progresso_atual / $total_expressoes_categoria) * 100) : 0;
?>

<!DOCTYPE html>
<html lang="pt-PT">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Exercício</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/styleexercicio.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  
</head>

<body>
  <div class="exercicio-container">
    <a href="exercicio.php?id=<?php echo $id_expressao; ?>&sair=1" class="btn-sair" title="Voltar" onclick="return confirm('Quer mesmo sair?');">
      <i class="fas fa-times"></i>
    </a>
    
    <div class="exercicio-card">
      <!-- Progress bar and lives -->
      <div class="progress-container">
        <div class="progress-bar">
          <div class="progress-fill" style="width: <?php echo $percentagem; ?>%"></div>
        </div>
        <div class="lives-container">
          <?php 
          $full_hearts = $_SESSION['lives'];
          $empty_hearts = 5 - $full_hearts;
          
          for ($i = 0; $i < $full_hearts; $i++) {
              echo '<i class="fas fa-heart life"></i>';
          }
          for ($i = 0; $i < $empty_hearts; $i++) {
              echo '<i class="far fa-heart life"></i>';
          }
          ?>
        </div>
      </div>
      
      <?php echo $mensagem; ?>
      
      <?php if ($mostrar_resumo_erros): ?>
        <!-- Tela de resumo de erros -->
        <div class="resumo-erros-container">
          <h2 class="resumo-erros-titulo"><i class="fas fa-exclamation-triangle"></i> Revise os seus erros</h2>
          
          <?php foreach ($expressoes_erradas as $erro): ?>
            <div class="erro-item">
              <div class="erro-questao"><?php echo htmlspecialchars($erro['versao_ingles']); ?></div>
              <div class="erro-resposta">Resposta correta: <?php echo htmlspecialchars($erro['traducao_portugues']); ?></div>
            </div>
          <?php endforeach; ?>
          
          <form method="POST">
            <button type="submit" name="finalizar_sessao" class="btn-submeter">
              <i class="fas fa-check"></i> Continuar
            </button>
          </form>
        </div>
      <?php elseif ($mostrar_explicacao): ?>
        <!-- Tela de explicação -->
        <div class="explicacao-container">
          <h2 class="explicacao-titulo"><?php echo htmlspecialchars($expressao['versao_ingles']); ?></h2>
          <p class="explicacao-conteudo" style="color: #7b6ada; font-size: 1.5rem; margin-bottom: 25px; text-align: center; font-weight: bold;">
             <?php echo htmlspecialchars($expressao['traducao_portugues']); ?>
          </p>
          
          <?php if (!empty($expressao['explicacao'])): ?>
            <div class="explicacao-conteudo">
               <?php echo htmlspecialchars($expressao['explicacao']); ?>
            </div>
          <?php endif; ?>
          
          <?php if ($result_exemplos->num_rows > 0): ?>
            <div class="exemplos-container">
              <h4><i class="fas fa-comment-dots"></i> Exemplos de uso:</h4>
              <?php while($exemplo = $result_exemplos->fetch_assoc()): ?>
                <div class="exemplo-item">
                  <div class="exemplo-ingles"><?php echo htmlspecialchars($exemplo['exemplo']); ?></div>
                </div>
              <?php endwhile; ?>
            </div>
          <?php endif; ?>
          
          <form method="POST">
            <button type="submit" name="pular_explicacao" class="btn-submeter">
              <i class="fas fa-arrow-right"></i> Praticar agora
            </button>
          </form>
        </div>
      <?php elseif (!$resposta_correta): ?>
        <!-- Tela de exercício -->
        <div class="instrucao">
          Selecione a tradução correta
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
        <!-- Tela de resposta correta -->
        <div class="exercicio-completo">
          <div class="resposta-correta">
            <i class="fas fa-check-circle"></i> Resposta Correta!
          </div>
          
          <div class="traducao-container">
            <p style="color:#f5f4ff;"><strong><?php echo htmlspecialchars($expressao['versao_ingles']); ?></strong></p>
            <p style="color:#f5f4ff;"><i class="fas fa-arrow-down"></i></p>
            <p style="color:#f5f4ff;"><strong><?php echo htmlspecialchars($expressao['traducao_portugues']); ?></strong></p>
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