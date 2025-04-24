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

$id_expressao = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obter dados da expressão
$sql = "SELECT e.*, c.titulo as categoria_nome 
        FROM expressoes e
        JOIN categoria c ON e.id_categoria = c.id_categoria
        WHERE e.id_expressao = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_expressao);
$stmt->execute();
$result = $stmt->get_result();
$expressao = $result->fetch_assoc();

if (!$expressao) {
    header('Location: gerir_expressoes.php');
    exit();
}

// Obter exemplos
$exemplos = $conn->query("SELECT exemplo FROM exemplos WHERE id_expressao = $id_expressao");

// Obter categorias para dropdown
$categorias = $conn->query("SELECT id_categoria, titulo FROM categoria ORDER BY titulo");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingles = $conn->real_escape_string($_POST['ingles']);
    $portugues = $conn->real_escape_string($_POST['portugues']);
    $explicacao = $conn->real_escape_string($_POST['explicacao']);
    $categoria_id = intval($_POST['categoria_id']);
    $tipo_exercicio = $conn->real_escape_string($_POST['tipo_exercicio']);

    // Atualizar expressão
    $stmt = $conn->prepare("UPDATE expressoes SET versao_ingles = ?, traducao_portugues = ?, explicacao = ?, id_categoria = ?, tipo_exercicio = ? WHERE id_expressao = ?");
    $stmt->bind_param("sssisi", $ingles, $portugues, $explicacao, $categoria_id, $tipo_exercicio, $id_expressao);
    
    if ($stmt->execute()) {
        // Eliminar exemplos antigos
        $conn->query("DELETE FROM exemplos WHERE id_expressao = $id_expressao");
        
        // Adicionar novos exemplos se existirem
        if (!empty($_POST['exemplos'])) {
            $stmt_ex = $conn->prepare("INSERT INTO exemplos (id_expressao, exemplo) VALUES (?, ?)");
            
            foreach ($_POST['exemplos'] as $exemplo) {
                if (!empty(trim($exemplo))) {
                    $exemplo_clean = $conn->real_escape_string(trim($exemplo));
                    $stmt_ex->bind_param("is", $id_expressao, $exemplo_clean);
                    $stmt_ex->execute();
                }
            }
        }
        
        $_SESSION['success_message'] = "Expressão atualizada com sucesso!";
        header('Location: gerir_expressoes.php');
        exit();
    } else {
        $error = "Erro ao atualizar expressão: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Editar Expressão</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">
  <link rel="stylesheet" href="css/styleindexadmin.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container">
    <div class="form-container">
      <h2 style="margin-bottom: 10px;"><i class="fas fa-edit"></i> Editar Expressão</h2>
      
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <form method="POST">
        <div class="form-group">
          <label for="ingles">Expressão em Inglês</label>
          <input type="text" id="ingles" name="ingles" class="form-control" 
                 value="<?php echo htmlspecialchars($expressao['versao_ingles']); ?>" required>
        </div>
        
        <div class="form-group">
          <label for="portugues">Tradução em Português</label>
          <input type="text" id="portugues" name="portugues" class="form-control" 
                 value="<?php echo htmlspecialchars($expressao['traducao_portugues']); ?>" required>
        </div>
        
        <div class="form-group">
          <label for="explicacao">Explicação</label>
          <textarea id="explicacao" name="explicacao" class="form-control" required><?php 
            echo htmlspecialchars($expressao['explicacao']); 
          ?></textarea>
        </div>
        
        <div class="form-group">
          <label for="categoria_id">Categoria</label>
          <select id="categoria_id" name="categoria_id" class="form-control" required>
            <?php while($cat = $categorias->fetch_assoc()): ?>
              <option value="<?php echo $cat['id_categoria']; ?>" <?php 
                echo $cat['id_categoria'] == $expressao['id_categoria'] ? 'selected' : ''; 
              ?>>
                <?php echo htmlspecialchars($cat['titulo']); ?>
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        
        <div class="form-group">
          <label for="tipo_exercicio">Tipo de Exercício</label>
          <select id="tipo_exercicio" name="tipo_exercicio" class="form-control" required>
            <option value="traducao" <?php echo $expressao['tipo_exercicio'] == 'traducao' ? 'selected' : ''; ?>>Tradução</option>
            <option value="preenchimento" <?php echo $expressao['tipo_exercicio'] == 'preenchimento' ? 'selected' : ''; ?>>Preenchimento</option>
            <option value="associacao" <?php echo $expressao['tipo_exercicio'] == 'associacao' ? 'selected' : ''; ?>>Associação</option>
          </select>
        </div>
        
        <div class="form-group">
          <label>Exemplos</label>
          <div id="exemplos-container">
            <?php if ($exemplos->num_rows > 0): ?>
              <?php while($ex = $exemplos->fetch_assoc()): ?>
                <div class="exemplo-item">
                  <input type="text" name="exemplos[]" class="form-control" 
                         value="<?php echo htmlspecialchars($ex['exemplo']); ?>">
                  <button type="button" class="admin-btn delete-btn remove-exemplo"><i class="fas fa-times"></i></button>
                </div>
              <?php endwhile; ?>
            <?php else: ?>
              <div class="exemplo-item">
                <input type="text" name="exemplos[]" class="form-control" placeholder="Exemplo de uso">
                <button type="button" class="admin-btn delete-btn remove-exemplo"><i class="fas fa-times"></i></button>
              </div>
            <?php endif; ?>
          </div>
          <button type="button" id="add-exemplo" class="admin-btn"><i class="fas fa-plus"></i> Adicionar Exemplo</button>
        </div>
        
        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Atualizar Expressão</button>
        <a href="gerir_expressoes.php" class="admin-btn" style="margin-left: 10px;"><i class="fas fa-arrow-left"></i> Voltar</a>
      </form>
    </div>
  </div>

  <script>
    // Mesmo script do adicionar_expressao.php para gerir exemplos
    document.getElementById('add-exemplo').addEventListener('click', function() {
      const container = document.getElementById('exemplos-container');
      const newItem = document.createElement('div');
      newItem.className = 'exemplo-item';
      newItem.innerHTML = `
        <input type="text" name="exemplos[]" class="form-control" placeholder="Exemplo de uso">
        <button type="button" class="admin-btn delete-btn remove-exemplo"><i class="fas fa-times"></i></button>
      `;
      container.appendChild(newItem);
    });

    document.addEventListener('click', function(e) {
      if (e.target.classList.contains('remove-exemplo')) {
        e.target.parentElement.remove();
      }
    });
  </script>
</body>
</html>