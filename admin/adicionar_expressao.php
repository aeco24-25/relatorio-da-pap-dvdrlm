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

// Obter categorias para o dropdown
$categorias = $conn->query("SELECT id_categoria, titulo FROM categoria ORDER BY titulo");

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ingles = $conn->real_escape_string($_POST['ingles']);
    $portugues = $conn->real_escape_string($_POST['portugues']);
    $explicacao = $conn->real_escape_string($_POST['explicacao']);
    $categoria_id = intval($_POST['categoria_id']);
    $tipo_exercicio = $conn->real_escape_string($_POST['tipo_exercicio']);

    // Inserir a expressão
    $stmt = $conn->prepare("INSERT INTO expressoes (versao_ingles, traducao_portugues, explicacao, id_categoria, tipo_exercicio) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $ingles, $portugues, $explicacao, $categoria_id, $tipo_exercicio);
    
    if ($stmt->execute()) {
        $id_expressao = $conn->insert_id;
        
        // Processar exemplos se existirem
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
        
        $_SESSION['success_message'] = "Expressão adicionada com sucesso!";
        header('Location: gerir_expressoes.php');
        exit();
    } else {
        $error = "Erro ao adicionar expressão: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Adicionar Expressão</title>
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
  
  <style>
    .form-container {
      max-width: 800px;
      margin: 30px auto;
      padding: 20px;
      background: #fcfcff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    textarea.form-control {
      min-height: 100px;
    }
    
    .exemplo-item {
      display: flex;
      margin-bottom: 10px;
    }
    
    .exemplo-item input {
      flex-grow: 1;
      margin-right: 10px;
    }
    
    #exemplos-container {
      margin-bottom: 20px;
    }

    .form-container {
      margin-top: 0px !important;
      max-width: 600px;
      margin: 30px auto;
      padding: 20px;
      background: #fcfcff;
      border-radius: 12px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    .form-group label {
      display: block;
      margin-bottom: 8px;
      color: #333;
      font-weight: 500;
    }
    
    .form-control {
      width: 100%;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }
    
    .btn-submit {
      background: #7b6ada;
      color: white;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    
    .btn-submit:hover {
      background: #5a4fcf;
    }
    
    .alert {
      padding: 10px;
      margin-bottom: 20px;
      border-radius: 5px;
    }
    
    .alert-success {
      background: #d4edda;
      color: #155724;
    }
    
    .alert-danger {
      background: #f8d7da;
      color: #721c24;
    }

    :root {
      --primary-color: #7b6ada;
      --secondary-color: #5a4fcf;
      --success-color: #4CAF50;
      --light-gray: #e2e2e2;
      --dark-gray: #333;
      --error-color: #c62828;
    }

    .admin-container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 20px;
    }

    .admin-main-content {
      display: flex;
      flex-direction: column;
      gap: 20px;
      width: 100%;
    }

    .stats-panel {
      background: #7b6ada;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 0;
    }

    .stats-panel h2 {
      text-align: center;
      color: #ffffff;
      margin-top: 0;
    }

    .admin-stats {
      margin-top: 18px;
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
    }

    .stat-card {
      background: #fcfcff;
      border-radius: 22px;
      padding: 17px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .stat-card h3 {
      color: #7b6ada;
      margin-top: 0;
      margin-bottom: 10px;
      font-size: 1.1rem;
    }

    .stat-number {
      font-size: 2rem;
      font-weight: bold;
      color: #434343;
      margin: 10px 0;
    }

    .admin-section {
      margin-top: 20px;
      background: #fcfcff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 10px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
      width: 100%;
    }

    .admin-section h2 {
      color: #7b6ada;
      margin-top: 0;
      border-bottom: 1px solid #eee;
      padding-bottom: 10px;
    }

    .user-table, .category-table {
      width: 100%;
      border-collapse: collapse;
    }

    .user-table th, .category-table th {
      background: #7b6ada;
      color: white;
      padding: 10px;
      text-align: left;
    }

    .user-table td, .category-table td {
      padding: 10px;
      border-bottom: 1px solid #eee;
    }

    .user-table tr:hover, .category-table tr:hover {
      background: #f5f5ff;
    }

    .admin-actions {
      display: flex;
      gap: 10px;
    }

    .admin-btn {
      padding: 5px 10px;
      border-radius: 5px;
      color: white;
      text-decoration: none;
      font-size: 0.8rem;
      display: inline-flex;
      align-items: center;
    }

    .edit-btn {
      background: #4CAF50;
    }

    .delete-btn {
      background: #c62828;
    }

    .add-btn {
      background: #7b6ada;
      margin-bottom: 15px;
      padding: 8px 15px;
    }

    .admin-btn i {
      margin-right: 5px;
    }

    .nav-admin {
      justify-content: space-around;
      margin-top: -30px;
      display: flex;
      background: #7b6ada;
      padding: 10px 20px;
      margin-bottom: 20px;
      border-radius: 8px;
    }

    .nav-admin a {
      color: white;
      text-decoration: none;
      margin-right: 20px;
      padding: 5px 10px;
      border-radius: 5px;
    }

    .nav-admin a:hover {
      background: rgba(255,255,255,0.2);
    }

    .nav-admin a.active {
      background: white;
      color: #7b6ada;
    }
  </style>
</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container">
    <div class="form-container">
      <h2 style="margin-bottom: 10px;"><i class="fas fa-plus-circle"></i> Adicionar Nova Expressão</h2>
      
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <form method="POST">
        <div class="form-group">
          <label for="ingles">Expressão em Inglês</label>
          <input type="text" id="ingles" name="ingles" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label for="portugues">Tradução em Português</label>
          <input type="text" id="portugues" name="portugues" class="form-control" required>
        </div>
        
        <div class="form-group">
          <label for="explicacao">Explicação</label>
          <textarea id="explicacao" name="explicacao" class="form-control" required></textarea>
        </div>
        
        <div class="form-group">
          <label for="categoria_id">Categoria</label>
          <select id="categoria_id" name="categoria_id" class="form-control" required>
            <?php while($cat = $categorias->fetch_assoc()): ?>
              <option value="<?php echo $cat['id_categoria']; ?>"><?php echo htmlspecialchars($cat['titulo']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        
        <div class="form-group">
          <label for="tipo_exercicio">Tipo de Exercício</label>
          <select id="tipo_exercicio" name="tipo_exercicio" class="form-control" required>
            <option value="traducao">Tradução</option>
            <option value="preenchimento">Preenchimento</option>
            <option value="associacao">Associação</option>
          </select>
        </div>
        
        <div class="form-group">
          <label>Exemplos (opcional)</label>
          <div id="exemplos-container">
            <div class="exemplo-item">
              <input type="text" name="exemplos[]" class="form-control" placeholder="Exemplo de uso">
              <button type="button" class="admin-btn delete-btn remove-exemplo"><i class="fas fa-times"></i></button>
            </div>
          </div>
          <button type="button" id="add-exemplo" class="admin-btn"><i class="fas fa-plus"></i> Adicionar Exemplo</button>
        </div>
        
        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Guardar Expressão</button>
        <a href="gerir_expressoes.php" class="admin-btn" style="margin-left: 10px;"><i class="fas fa-arrow-left"></i> Voltar</a>
      </form>
    </div>
  </div>

  <script>
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