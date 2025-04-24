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

$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

// VERIFICAÇÃO DA META DIÁRIA
$sql_hoje = "SELECT COUNT(*) as hoje FROM progresso 
            WHERE username = ? AND completo = TRUE 
            AND DATE(data_conclusao) = CURDATE()";
$stmt_hoje = $conn->prepare($sql_hoje);
$stmt_hoje->bind_param("s", $_SESSION['username']);
$stmt_hoje->execute();
$result_hoje = $stmt_hoje->get_result();
$hoje_row = $result_hoje->fetch_assoc();

$_SESSION['meta_diaria'] = [
    'data' => date('Y-m-d'),
    'completas' => min(10, $hoje_row['hoje']),
    'completas_real' => $hoje_row['hoje']
];

// Obter expressão principal e informações da categoria
$stmt = $conn->prepare("SELECT e.*, c.titulo as categoria_titulo, c.id_categoria, e.tipo_exercicio
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
$tipo_exercicio = $expressao['tipo_exercicio'];

// Obter dados específicos do tipo de exercício
$preenchimento_data = null;
$associacao_data = null;

if ($tipo_exercicio == 'preenchimento') {
    $stmt_preenchimento = $conn->prepare("SELECT * FROM exercicio_preenchimento WHERE id_expressao = ?");
    $stmt_preenchimento->bind_param("i", $id_expressao);
    $stmt_preenchimento->execute();
    $result_preenchimento = $stmt_preenchimento->get_result();
    $preenchimento_data = $result_preenchimento->fetch_assoc();
} elseif ($tipo_exercicio == 'associacao') {
    $stmt_associacao = $conn->prepare("SELECT * FROM exercicio_associacao WHERE id_expressao = ?");
    $stmt_associacao->bind_param("i", $id_expressao);
    $stmt_associacao->execute();
    $result_associacao = $stmt_associacao->get_result();
    $associacao_data = $result_associacao->fetch_assoc();
}

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
    
    // Obter expressões já completadas pelo utilizador nesta categoria
    $stmt_completas = $conn->prepare("SELECT id_expressao FROM progresso 
                                    WHERE username = ? AND completo = TRUE 
                                    AND id_expressao IN (SELECT id_expressao FROM expressoes WHERE id_categoria = ?)");
    $stmt_completas->bind_param("si", $username, $id_categoria);
    $stmt_completas->execute();
    $result_completas = $stmt_completas->get_result();
    
    while ($row = $result_completas->fetch_assoc()) {
        $_SESSION['progresso_categorias'][$id_categoria]['expressoes_completas'][$row['id_expressao']] = true;
    }
}

// Verificar progresso na BD para esta expressão
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
                              WHERE e.id_categoria = ? AND (p.id_expressao IS NULL OR e.id_expressao > ?)
                              ORDER BY e.id_expressao ASC LIMIT 1");
$stmt_proxima->bind_param("sii", $username, $id_categoria, $id_expressao);
$stmt_proxima->execute();
$result_proxima = $stmt_proxima->get_result();
$proxima_expressao = $result_proxima->fetch_assoc();

// Verificar se a categoria está completa
$sql_categoria_completa = "SELECT COUNT(*) as total, 
                          SUM(CASE WHEN p.completo = TRUE AND p.username = ? THEN 1 ELSE 0 END) as completas
                          FROM expressoes e
                          LEFT JOIN progresso p ON e.id_expressao = p.id_expressao AND p.username = ?
                          WHERE e.id_categoria = ?";
$stmt_completa = $conn->prepare($sql_categoria_completa);
$stmt_completa->bind_param("ssi", $username, $username, $id_categoria);
$stmt_completa->execute();
$result_completa = $stmt_completa->get_result();
$completa_row = $result_completa->fetch_assoc();

$categoria_completa = ($completa_row['completas'] == $completa_row['total']);

// Quando a categoria está completa ou não há próxima expressão
if ($categoria_completa || !$proxima_expressao) {
    // Verificar se o utilizador quer repetir a categoria
    if (isset($_GET['repetir_categoria'])) {
        // Reseta o progresso da categoria na BD
        $stmt_reset = $conn->prepare("DELETE FROM progresso WHERE username = ? AND id_expressao IN (SELECT id_expressao FROM expressoes WHERE id_categoria = ?)");
        $stmt_reset->bind_param("si", $username, $id_categoria);
        $stmt_reset->execute();
        
        // Reseta o progresso da categoria na sessão
        $_SESSION['progresso_categorias'][$id_categoria]['expressoes_completas'] = array();
        
        // Procura a primeira expressão da categoria
        $stmt_primeira = $conn->prepare("SELECT id_expressao FROM expressoes WHERE id_categoria = ? ORDER BY id_expressao ASC LIMIT 1");
        $stmt_primeira->bind_param("i", $id_categoria);
        $stmt_primeira->execute();
        $result_primeira = $stmt_primeira->get_result();
        
        if ($result_primeira->num_rows > 0) {
            $expressao_inicial = $result_primeira->fetch_assoc();
            header("Location: exercicio.php?id=" . $expressao_inicial['id_expressao']);
            exit();
        }
    } elseif (!$first_view) {
        // Mostrar opção para repetir a categoria apenas se não for a primeira visualização
        echo '<script>
                if (confirm("Completou todas as expressões desta categoria. Deseja repetir?")) {
                    window.location.href = "exercicio.php?id=' . $id_expressao . '&repetir_categoria=1";
                } else {
                    window.location.href = "indexuser.php";
                }
              </script>';
        exit();
    }
}

// Obter exemplos de uso
$stmt_exemplos = $conn->prepare("SELECT exemplo FROM exemplos WHERE id_expressao = ?");
$stmt_exemplos->bind_param("i", $id_expressao);
$stmt_exemplos->execute();
$result_exemplos = $stmt_exemplos->get_result();

$mensagem = '';
$resposta_correta = false;
$mostrar_explicacao = $first_view && !isset($_POST['saltar_explicacao']);
$mostrar_feedback = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['saltar_explicacao'])) {
        $mostrar_explicacao = false;
    } 
    else {
        $resposta_utilizador = isset($_POST['resposta']) ? trim($_POST['resposta']) : '';
        $resposta_correta_db = strtolower(trim($expressao['traducao_portugues']));
        $resposta_utilizador_normalized = strtolower(trim($resposta_utilizador));
        
        if ($tipo_exercicio == 'traducao') {
            $resposta_correta = ($resposta_utilizador_normalized === $resposta_correta_db);
        } elseif ($tipo_exercicio == 'preenchimento') {
            $respostas_corretas = json_decode($preenchimento_data['palavras_chave'], true);
            $respostas_utilizador = isset($_POST['respostas_lacunas']) ? $_POST['respostas_lacunas'] : [];
            $resposta_correta = true;
            
            foreach ($respostas_corretas as $index => $correta) {
                if (!isset($respostas_utilizador[$index]) || strtolower(trim($respostas_utilizador[$index])) !== strtolower($correta)) {
                    $resposta_correta = false;
                    break;
                }
            }
        } elseif ($tipo_exercicio == 'associacao') {
            $pares_corretos = json_decode($associacao_data['itens_ingles'], true);
            $resposta_correta = true;
            
            foreach ($pares_corretos as $index => $ingles) {
                $portugues_correto = json_decode($associacao_data['itens_portugues'], true)[$index];
                if (!isset($_POST['associacao'][$index]) || $_POST['associacao'][$index] !== $portugues_correto) {
                    $resposta_correta = false;
                    break;
                }
            }
        }
        
        if ($resposta_correta) {
            // Atualizar BD
            $stmt = $conn->prepare("INSERT INTO progresso (username, id_expressao, completo, data_conclusao) 
                                  VALUES (?, ?, TRUE, NOW()) 
                                  ON DUPLICATE KEY UPDATE completo = TRUE, data_conclusao = NOW()");
            $stmt->bind_param("si", $_SESSION['username'], $id_expressao);
            $stmt->execute();
            
            // Atualizar contador na sessão
            if (!isset($_SESSION['meta_diaria'])) {
                $_SESSION['meta_diaria'] = [
                    'data' => date('Y-m-d'),
                    'completas' => 0
                ];
            }
            
            if ($_SESSION['meta_diaria']['completas'] < 10) {
                $_SESSION['meta_diaria']['completas']++;
            }
            
            // Atualizar progresso na sessão
            $_SESSION['progresso_categorias'][$id_categoria]['expressoes_completas'][$id_expressao] = true;
            
            // Redirecionar para feedback
            $_SESSION['mostrar_feedback'] = true;
            $_SESSION['expressao_feedback'] = $id_expressao;
            header("Location: exercicio.php?id=$id_expressao");
            exit();
        } else {
            // Resposta incorreta
            $_SESSION['lives']--;
            
            if ($_SESSION['lives'] <= 0) {
                $_SESSION['mostrar_tela_erros'] = true;
                $_SESSION['lives'] = 0;
            }
            
            $mensagem = '<div class="exercicio-completo"><div class="resposta-incorreta"><i class="fas fa-times-circle"></i> Incorreto!</div></div>';
        }
    }
}

// Verificar se deve mostrar feedback de acerto
if (isset($_SESSION['mostrar_feedback']) && $_SESSION['mostrar_feedback'] && $_SESSION['expressao_feedback'] == $id_expressao) {
    $mostrar_feedback = true;
    unset($_SESSION['mostrar_feedback']);
    unset($_SESSION['expressao_feedback']);
}

// Obter alternativas para a questão (apenas para o de tipo tradução)
$alternativas = array();
if ($tipo_exercicio == 'traducao') {
    $stmt = $conn->prepare("SELECT traducao_portugues FROM expressoes 
                           WHERE id_categoria = ? AND id_expressao != ? 
                           ORDER BY RAND() LIMIT 3");
    $stmt->bind_param("ii", $id_categoria, $id_expressao);
    $stmt->execute();
    $result_alternativas = $stmt->get_result();

    while ($row = $result_alternativas->fetch_assoc()) {
        $alternativas[] = $row['traducao_portugues'];
    }
    $alternativas[] = $expressao['traducao_portugues'];
    shuffle($alternativas);
}

// Calcular progresso atual
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
  
  <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
  <script src="js/confetti.js"></script> 

</head>

<body>
<div class="exercicio-container">
    <a href="#" class="btn-sair" title="Voltar" onclick="confirmarSaida(); return false;">
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
      
      <?php if (isset($_SESSION['mostrar_tela_erros']) && $_SESSION['mostrar_tela_erros']): ?>
        <!-- Tela simplificada de perda de vidas -->
        <div class="tela-erros-container">
          <div class="icone-aviso">
            <i class="fas fa-exclamation-triangle"></i>
          </div>
          <h2>Perdeu todas as vidas!</h2>
          <p style="color:white;">Tente novamente.</p>
          
          <a href="indexuser.php" class="btn-voltar-inicio" onclick="
            <?php 
            $_SESSION['lives'] = 5;
            unset($_SESSION['mostrar_tela_erros']);
            ?>">
            <i class="fas fa-home"></i> Voltar ao Início
          </a>
        </div>
      
      <?php elseif ($mostrar_explicacao && $_SESSION['lives'] > 0): ?>
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
            <button type="submit" name="saltar_explicacao" class="btn-submeter">
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
              <i class="fas fa-arrow-right"></i> <?php echo ($progresso_atual >= $total_expressoes_categoria) ? 'Repetir Categoria' : 'Próxima Expressão'; ?>
            </a>
          <?php else: ?>
            <a href="exercicio.php?id=<?php echo $id_expressao; ?>" class="btn-submeter">
              <i class="fas fa-redo"></i> Repetir Categoria
            </a>
          <?php endif; ?>
        </div>
        
        <script>
          window.onload = function() {
            fireConfetti();
          };
        </script>

      <?php elseif (!$resposta_correta && $_SESSION['lives'] > 0): ?>
        <!-- Tela de exercício -->
        <?php if ($tipo_exercicio == 'traducao'): ?>
          <!-- Exercício de tradução -->
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

        <?php elseif ($tipo_exercicio == 'preenchimento' && $preenchimento_data): ?>
          <!-- Exercício de preenchimento de lacunas -->
          <div class="instrucao">
            Preencha as lacunas corretamente
          </div>
          
          <div class="exercicio-questao">
            <?php 
            $texto = $preenchimento_data['texto_com_lacunas'];
            $partes = explode('______', $texto);
            $total_lacunas = count($partes) - 1;
            ?>
            
            <form method="POST" class="exercicio-form">
              <?php for ($i = 0; $i < count($partes); $i++): ?>
                <?php echo htmlspecialchars($partes[$i]); ?>
                <?php if ($i < $total_lacunas): ?>
                  <input type="text" name="respostas_lacunas[]" class="lacuna-input" required>
                <?php endif; ?>
              <?php endfor; ?>
              
              <button type="submit" class="btn-submeter">
                <i class="fas fa-check"></i> Verificar
              </button>
            </form>
          </div>

        <?php elseif ($tipo_exercicio == 'associacao' && $associacao_data): ?>
          <!-- Exercício de associação -->
          <div class="instrucao">
            Associe cada termo em inglês com a sua tradução
          </div>
          
          <div class="exercicio-questao">
            <form method="POST" class="exercicio-form">
              <div class="associacao-container">
                <?php
                $itens_ingles = json_decode($associacao_data['itens_ingles'], true);
                $itens_portugues = json_decode($associacao_data['itens_portugues'], true);
                shuffle($itens_portugues);
                
                foreach ($itens_ingles as $index => $ingles): ?>
                  <div class="associacao-item">
                    <span class="associacao-ingles"><?php echo htmlspecialchars($ingles); ?></span>
                    <select name="associacao[<?php echo $index; ?>]" class="associacao-select" required>
                      <option value=""> Selecione </option>
                      <?php foreach ($itens_portugues as $portugues): ?>
                        <option value="<?php echo htmlspecialchars($portugues); ?>">
                          <?php echo htmlspecialchars($portugues); ?>
                        </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                <?php endforeach; ?>
              </div>
              
              <button type="submit" class="btn-submeter">
                <i class="fas fa-check"></i> Verificar
              </button>
            </form>
          </div>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
  
  <!-- Para confirmar se quer sair !-->
  <script>
  function confirmarSaida() {
      const dialogo = document.createElement('div');
      dialogo.className = 'dialogo-confirmacao';
      dialogo.innerHTML = `
          <div class="dialogo-conteudo">
              <div class="dialogo-titulo">Tem a certeza que deseja sair?</div>
              <div class="dialogo-botoes">
                  <button class="dialogo-btn dialogo-btn-confirmar" onclick="window.location.href='exercicio.php?id=<?php echo $id_expressao; ?>&sair=1'">Sim</button>
                  <button class="dialogo-btn dialogo-btn-cancelar" onclick="this.parentNode.parentNode.parentNode.remove()">Cancelar</button>
              </div>
          </div>
      `;
      document.body.appendChild(dialogo);
      return false;
  }
  </script>

  <script src="../assets/js/fontawesome.js"></script>
</body>
</html>