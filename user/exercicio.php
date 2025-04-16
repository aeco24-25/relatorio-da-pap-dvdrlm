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

// Inicializar vidas se não existirem
if (!isset($_SESSION['lives'])) {
    $_SESSION['lives'] = 5;
}

// Inicializar erros atuais se não existirem
if (!isset($_SESSION['erros_atual'])) {
    $_SESSION['erros_atual'] = array();
}

$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// Obter expressão principal e informações da categoria
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
$id_categoria = $expressao['id_categoria'];

// Inicializar progresso da categoria na sessão se não existir
if (!isset($_SESSION['progresso_categorias'][$id_categoria])) {
    $_SESSION['progresso_categorias'][$id_categoria] = array(
        'expressoes_completas' => array(),
        'total_expressoes' => 0,
        'ultima_expressao' => null
    );
    
    // Obter total de expressões na categoria
    $stmt_total = $conn->prepare("SELECT COUNT(*) as total FROM expressoes WHERE id_categoria = ?");
    $stmt_total->bind_param("i", $id_categoria);
    $stmt_total->execute();
    $result_total = $stmt_total->get_result();
    $_SESSION['progresso_categorias'][$id_categoria]['total_expressoes'] = $result_total->fetch_assoc()['total'];
}

// Inicializar meta diária
if (!isset($_SESSION['meta_diaria'])) {
    $_SESSION['meta_diaria'] = array(
        'data' => date('Y-m-d'),
        'completas' => 0
    );
} elseif ($_SESSION['meta_diaria']['data'] != date('Y-m-d')) {
    // Resetar meta se for um novo dia
    $_SESSION['meta_diaria'] = array(
        'data' => date('Y-m-d'),
        'completas' => 0
    );
}

// Verificar progresso no banco de dados para esta expressão
$stmt_first_view = $conn->prepare("SELECT completo FROM progresso 
                                 WHERE username = ? AND id_expressao = ?");
$stmt_first_view->bind_param("si", $username, $id_expressao);
$stmt_first_view->execute();
$result_first_view = $stmt_first_view->get_result();
$first_view = ($result_first_view->num_rows === 0);

// Obter próxima expressão não completada na mesma categoria
$stmt_proxima = $conn->prepare("SELECT e.id_expressao 
                              FROM expressoes e
                              LEFT JOIN progresso p ON e.id_expressao = p.id_expressao AND p.username = ? AND p.completo = TRUE
                              WHERE e.id_categoria = ? AND p.id_expressao IS NULL AND e.id_expressao > ?
                              ORDER BY e.id_expressao ASC LIMIT 1");
$stmt_proxima->bind_param("sii", $username, $id_categoria, $id_expressao);
$stmt_proxima->execute();
$result_proxima = $stmt_proxima->get_result();
$proxima_expressao = $result_proxima->fetch_assoc();

// Se não houver próxima expressão não completada, verificar se há alguma após esta
if (!$proxima_expressao) {
    $stmt_proxima_alternativa = $conn->prepare("SELECT id_expressao FROM expressoes 
                                              WHERE id_categoria = ? AND id_expressao > ? 
                                              ORDER BY id_expressao ASC LIMIT 1");
    $stmt_proxima_alternativa->bind_param("ii", $id_categoria, $id_expressao);
    $stmt_proxima_alternativa->execute();
    $result_proxima_alternativa = $stmt_proxima_alternativa->get_result();
    $proxima_expressao = $result_proxima_alternativa->fetch_assoc();
}

// Obter exemplos de uso
$stmt_exemplos = $conn->prepare("SELECT exemplo FROM exemplos WHERE id_expressao = ?");
$stmt_exemplos->bind_param("i", $id_expressao);
$stmt_exemplos->execute();
$result_exemplos = $stmt_exemplos->get_result();

$mensagem = '';
$resposta_correta = false;
$mostrar_explicacao = $first_view && !isset($_POST['pular_explicacao']);
$mostrar_feedback = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pular_explicacao'])) {
        $mostrar_explicacao = false;
    } 
    else {
        $resposta_usuario = isset($_POST['resposta']) ? trim($_POST['resposta']) : '';
        $resposta_correta_db = strtolower(trim($expressao['traducao_portugues']));
        $resposta_usuario_normalized = strtolower(trim($resposta_usuario));
        
        $resposta_correta = ($resposta_usuario_normalized === $resposta_correta_db);
        
        if ($resposta_correta) {
            // Atualizar banco de dados
            $stmt = $conn->prepare("INSERT INTO progresso (username, id_expressao, completo) 
                                   VALUES (?, ?, TRUE) 
                                   ON DUPLICATE KEY UPDATE completo = TRUE");
            $stmt->bind_param("si", $username, $id_expressao);
            $stmt->execute();
            
            // Atualizar progresso na sessão
            if (!in_array($id_expressao, $_SESSION['progresso_categorias'][$id_categoria]['expressoes_completas'])) {
                $_SESSION['progresso_categorias'][$id_categoria]['expressoes_completas'][] = $id_expressao;
                $_SESSION['progresso_categorias'][$id_categoria]['ultima_expressao'] = $id_expressao;
            }
            
            // Remover dos erros se estiver lá
            if (($key = array_search($id_expressao, $_SESSION['erros_atual'])) !== false) {
                unset($_SESSION['erros_atual'][$key]);
            }
            
            // Atualizar meta diária (máximo 10)
            if ($_SESSION['meta_diaria']['completas'] < 10) {
                $_SESSION['meta_diaria']['completas']++;
            }
            
            // Preparar feedback para próxima tela
            $_SESSION['mostrar_feedback'] = true;
            $_SESSION['expressao_feedback'] = $id_expressao;
            
            header("Location: exercicio.php?id=$id_expressao");
            exit();
        } else {
            // Resposta incorreta
            $_SESSION['lives']--;
            
            // Verificar se acabaram as vidas
            if ($_SESSION['lives'] <= 0) {
                $_SESSION['lives'] = 5; // Resetar vidas
                $_SESSION['erros_atual'] = array(); // Limpar erros
                header("Location: indexuser.php"); // Redirecionar para início
                exit();
            }
            
            $mensagem = '<div class="mensagem-erro"><i class="fas fa-times"></i> Incorreto. Tente novamente.</div>';
            
            // Adicionar aos erros se não estiver lá
            if (!in_array($id_expressao, $_SESSION['erros_atual'])) {
                $_SESSION['erros_atual'][] = $id_expressao;
            }
        }
    }
}

// Verificar se deve mostrar feedback de acerto
if (isset($_SESSION['mostrar_feedback']) && $_SESSION['mostrar_feedback'] && $_SESSION['expressao_feedback'] == $id_expressao) {
    $mostrar_feedback = true;
    unset($_SESSION['mostrar_feedback']);
    unset($_SESSION['expressao_feedback']);
}

// Obter alternativas para a questão
$stmt = $conn->prepare("SELECT traducao_portugues FROM expressoes 
                       WHERE id_categoria = ? AND id_expressao != ? 
                       ORDER BY RAND() LIMIT 3");
$stmt->bind_param("ii", $id_categoria, $id_expressao);
$stmt->execute();
$result_alternativas = $stmt->get_result();

$alternativas = array();
while ($row = $result_alternativas->fetch_assoc()) {
    $alternativas[] = $row['traducao_portugues'];
}
$alternativas[] = $expressao['traducao_portugues'];
shuffle($alternativas);

// Calcular progresso atual para mostrar na barra
$progresso_atual = count($_SESSION['progresso_categorias'][$id_categoria]['expressoes_completas']);
$total_expressoes_categoria = $_SESSION['progresso_categorias'][$id_categoria]['total_expressoes'];
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
      <!-- Barra de progresso e vidas -->
      <div class="progress-container">
        <div class="progress-bar">
          <div class="progress-fill" style="width: <?php echo $percentagem; ?>%"></div>
          <div class="progress-text"><?php echo $progresso_atual; ?>/<?php echo $total_expressoes_categoria; ?></div>
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
      
      <?php if ($mostrar_explicacao): ?>
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
      <?php elseif ($mostrar_feedback): ?>
        <!-- Feedback de acerto -->
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
      <?php endif; ?>
    </div>
  </div>
  
  <script src="../assets/js/fontawesome.js"></script>
</body>
</html>