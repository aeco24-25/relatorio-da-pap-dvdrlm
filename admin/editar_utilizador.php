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

$username = $_GET['username'] ?? '';
$error = '';
$user = [];

// Obter dados do utilizador
$stmt = $conn->prepare("SELECT username, email, is_admin FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    header('Location: gerir_utilizadores.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;
    $change_password = isset($_POST['change_password']);
    
    // Verificar se novo username já existe (se foi alterado)
    if ($new_username !== $username) {
        $check = $conn->prepare("SELECT username FROM users WHERE username = ?");
        $check->bind_param("s", $new_username);
        $check->execute();
        $check->store_result();
        
        if ($check->num_rows > 0) {
            $error = "Username já existe!";
        }
    }
    
    if (empty($error)) {
        // Atualizar com ou sem password
        if ($change_password && !empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, pass = ?, is_admin = ? WHERE username = ?");
            $stmt->bind_param("sssis", $new_username, $email, $password, $is_admin, $username);
        } else {
            $stmt = $conn->prepare("UPDATE users SET username = ?, email = ?, is_admin = ? WHERE username = ?");
            $stmt->bind_param("ssis", $new_username, $email, $is_admin, $username);
        }
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Utilizador atualizado com sucesso!";
            header('Location: gerir_utilizadores.php');
            exit();
        } else {
            $error = "Erro ao atualizar utilizador: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Editar Utilizador</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">
  <link rel="stylesheet" href="css/styleindexadmin.css">
  <link rel="stylesheet" href="css/styleeditar_utilizador.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

</head>

<body style="background:#f2f0ff;">
  <?php include 'header_admin.php'; ?>
  
  <div class="admin-container">
    <div class="form-container" style="color:black;">
      <h2 style="margin-bottom: 10px;"><i class="fas fa-user-edit"></i> Editar Utilizador</h2>
      
      <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
      <?php endif; ?>
      
      <form method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" class="form-control" 
                 value="<?php echo htmlspecialchars($user['username']); ?>" required>
        </div>
        
        <div class="form-group">
          <label for="email">Email</label>
          <input type="email" id="email" name="email" class="form-control" 
                 value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>
        
        <div class="checkbox-group" style="margin-bottom: 15px;">
          <input type="checkbox" id="change_password" name="change_password" >
          <label for="change_password">Alterar Password</label>
        </div>
        
        <div class="form-group" id="password-field" style="display:none;">
          <label for="password">Nova Password</label>
          <input type="password" id="password" name="password" class="form-control">
        </div>
        
        <div class="checkbox-group" style="margin-bottom: 15px;">
          <input type="checkbox" id="is_admin" name="is_admin" <?php echo $user['is_admin'] ? 'checked' : ''; ?>>
          <label for="is_admin">Administrador</label>
        </div>
        
        <button type="submit" class="btn-submit"><i class="fas fa-save"></i> Atualizar Utilizador</button>
        <a href="gerir_utilizadores.php" class="admin-btn" style="margin-left: 10px;"><i class="fas fa-arrow-left"></i> Voltar</a>
      </form>
    </div>
  </div>

  <script>
    document.getElementById('change_password').addEventListener('change', function() {
      document.getElementById('password-field').style.display = this.checked ? 'block' : 'none';
    });
  </script>
</body>
</html>