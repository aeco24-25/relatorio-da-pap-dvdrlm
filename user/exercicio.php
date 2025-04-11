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

// Verificação de saída
if (isset($_GET['sair'])) {
    $_SESSION['confirmar_saida'] = true;
    header("Location: indexuser.php");
    exit();
}

if (isset($_GET['confirmar_saida'])) {
    unset($_SESSION['erros_atual']);
    $_SESSION['lives'] = 5;
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

// Verificar se deve mostrar explicação
$mostrar_explicacao = false;
if (isset($_POST['ver_explicacao'])) {
    $mostrar_explicacao = true;
} elseif ($first_view && !isset($_SESSION['explicacao_vista_'.$id_expressao])) {
    $mostrar_explicacao = true;
    $_SESSION['explicacao_vista_'.$id_expressao] = true;
}

$mostrar_resumo_erros = isset($_POST['finalizar_sessao']) && !empty($_SESSION['erros_atual']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['pular_explicacao'])) {
        $_SESSION['explicacao_vista_'.$id_expressao] = true;
        $mostrar_explicacao = false;
    } 
    elseif (isset($_POST['finalizar_sessao'])) {
        $_SESSION['erros_atual'] = array();
        header("Location: exercicio.php?id=$id_expressao");
        exit();
    }
    elseif (!isset($_POST['ver_explicacao'])) {
        $resposta_usuario = isset($_POST['resposta']) ? trim($_POST['resposta']) : '';
        
        $resposta_correta_db = strtolower(trim($expressao['traducao_portugues']));
        $resposta_usuario_normalized = strtolower(trim($resposta_usuario));
        
        $resposta_correta = ($resposta_usuario_normalized === $resposta_correta_db);
        
        if ($resposta_correta) {
            // Salvar no banco de dados
            $stmt = $conn->prepare("INSERT INTO progresso (username, id_expressao, completo) 
                                   VALUES (?, ?, TRUE) 
                                   ON DUPLICATE KEY UPDATE completo = TRUE");
            $stmt->bind_param("si", $username, $id_expressao);
            $stmt->execute();
            
            // Atualizar progresso da sessão
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
  
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  
  <style>
    body {
      background-color: #1a1a2e;
      color: #ffffff;
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 20px;
    }
    
    .exercicio-container {
      margin-top:-70px !important;
      max-width: 850px;
      margin: -55px auto;
      padding: 20px;
      position: relative;
    }
    
    .exercicio-card {
      padding-bottom: 0px !important;
      margin-top: 20px;
      background-color: transparent;
      padding: 30px;
    }
    
    .instrucao {
      font-size: 1.3rem;
      color: #fff;
      margin-bottom: 28px;
      font-style: italic;
      font-weight: bold;
      text-align: center;
    }
    
    .exercicio-questao {
      font-size: 1.3rem;
      text-align: center;
      padding: 17px;
      background-color: rgba(55, 70, 79, 0.3);
      border-radius: 12px;
      border-left: 6px solid #7b6ada;
      border-right: 6px solid #7b6ada;
    }
    
    .opcoes-container {
      margin-top: 35px;
      display: grid;
      grid-template-columns: 1fr;
      gap: 15px;
    }
    
    .opcao-label {
      display: block;
    }
    
    .opcao-radio {
      display: none;
    }
    
    .opcao-escolha {
      padding: 15px;
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
      text-decoration: none; 
    }
    
    .btn-submeter:hover {
      background-color: #6a59c9;
    }
    
    .btn-secundario {
      background-color: transparent;
      color: #7b6ada;
      border: 2px solid #7b6ada;
      border-radius: 12px;
      padding: 15px;
      font-size: 1.1rem;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      margin-top: 15px;
      transition: all 0.3s;
    }
    
    .btn-secundario:hover {
      background-color: rgba(123, 106, 218, 0.1);
    }
    
    .mensagem-erro {
      background-color: rgba(231, 76, 60, 0.15);
      border-left: 4px solid #e74c3c;
      color: #fff;
      padding: 20px;
      margin-bottom: 25px;
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
      margin-bottom: 50px !important;
      background-color: rgba(55, 70, 79, 0.3);
      padding: 25px;
      border-radius: 12px;
      margin: 30px 0;
    }
    
    .btn-sair {
      position: absolute;
      top: 62px;
      left: 40px;
      background-color: transparent;
      color: #fff;
      width: 40px;
      height: 40px;
      font-size: 1.68rem;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: all 0.3s;
      text-decoration: none;
    }
    
    .btn-sair:hover {
      background-color: rgba(123, 106, 218, 0.2);
    }
    
    .progress-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 23px;
    }
    
    .progress-bar {
      margin-left: 40px;
      flex-grow: 1;
      height: 20px;
      background-color: rgba(55, 70, 79, 0.3);
      border-radius: 10px;
      margin-right: 20px;
      overflow: hidden;
    }
    
    .progress-fill {
      height: 100%;
      background-color: #7b6ada;
      border-radius: 10px;
      transition: width 0.3s;
    }
    
    .lives-container {
      display: flex;
      align-items: center;
    }
    
    .life {
      color: #e74c3c;
      font-size: 1.5rem;
      margin-left: 5px;
    }
    
    .explicacao-container {
      background-color: rgba(55, 70, 79, 0.3);
      padding: 25px;
      border-radius: 12px;
      margin-bottom: 30px;
    }
    
    .explicacao-titulo {
      color: #7b6ada;
      font-size: 1.5rem;
      margin-bottom: 5px;
      text-align: center;
    }
    
    .explicacao-conteudo {
      font-size: 1.1rem;
      line-height: 1.6;
    }
    
    .exemplos-container {
      background-color: rgba(55, 70, 79, 0.2);
      padding: 15px;
      border-radius: 8px;
      margin: 15px 0;
    }
    
    .exemplos-container h4 {
      margin-top: 0;
      color: #7b6ada;
      font-size: 1.2rem;
    }
    
    .exemplo-item {
      margin: 10px 0;
      padding: 10px;
      border-left: 3px solid #7b6ada;
      background-color: rgba(123, 106, 218, 0.1);
    }
    
    .resumo-erros-container {
      background-color: rgba(231, 76, 60, 0.1);
      border: 2px solid #e74c3c;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
    }
    
    .resumo-erros-titulo {
      color: #e74c3c;
      font-size: 1.5rem;
      margin-bottom: 20px;
      text-align: center;
    }
    
    .erro-item {
      background-color: rgba(231, 76, 60, 0.2);
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 15px;
    }
    
    .erro-questao {
      font-weight: bold;
      color: #fff;
    }
    
    .erro-resposta {
      color: #2ecc71;
      font-style: italic;
    }
  </style>
</head>

<body>
  <div class="exercicio-container">
    <a href="exercicio.php?id=<?php echo $id_expressao; ?>&sair=1" class="btn-sair" title="Voltar" onclick="return confirm('Tem a certeza que quer sair? O progresso não será guardado.');">
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
          <h2 class="resumo-erros-titulo"><i class="fas fa-exclamation-triangle"></i> Revise seus erros</h2>
          
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
          
          <button type="submit" name="ver_explicacao" value="1" class="btn-secundario">
            <i class="fas fa-book"></i> Ver Explicação Novamente
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