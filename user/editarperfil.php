<?php
// Iniciar sessão
session_start();

// Verificar autenticação do utilizador
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

// Definir variáveis iniciais
$username = $_SESSION['username'];
$mensagem = '';
$erro = '';

// Estabelecer ligação à base de dados
$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

// Obter informações do utilizador
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Processar formulário de edição de perfil
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Limpar e validar dados de entrada
    $email = trim($_POST['email']);
    $password_atual = $_POST['password_atual'];
    $nova_password = $_POST['nova_password'];
    $confirmar_password = $_POST['confirmar_password'];
    
    // Verificar se a password atual está correta
    if ($password_atual !== $user['pass']) {
        $erro = "A password atual está incorreta.";
    } else {
        // Validar email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro = "Por favor, insira um email válido.";
        } else {
            // Verificar se o email já está em uso por outro utilizador
            $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND username != ?");
            $stmt->bind_param("ss", $email, $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $erro = "Este email já está associado a outra conta.";
            } else {
                // Processar alteração de password
                if (!empty($nova_password)) {
                    // Validar nova password
                    if ($nova_password !== $confirmar_password) {
                        $erro = "As novas passwords não coincidem.";
                    } else {
                        // Atualizar email e password
                        $stmt = $conn->prepare("UPDATE users SET email = ?, pass = ? WHERE username = ?");
                        $stmt->bind_param("sss", $email, $nova_password, $username);
                        
                        if ($stmt->execute()) {
                            $mensagem = "Perfil atualizado com sucesso!";
                            header("Location: editarperfil.php");
                            exit;
                        } else {
                            $erro = "Erro ao atualizar o perfil: " . $conn->error;
                        }
                    }
                } else {
                    // Atualizar apenas o email
                    $stmt = $conn->prepare("UPDATE users SET email = ? WHERE username = ?");
                    $stmt->bind_param("ss", $email, $username);
                    
                    if ($stmt->execute()) {
                        $mensagem = "Email atualizado com sucesso!";
                    } else {
                        $erro = "Erro ao atualizar o email: " . $conn->error;
                    }
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Editar Perfil</title>
  <meta content="width=device-width,initial-scale=1,user-scalable=no" name="viewport">
  <meta content="yes" name="mobile-web-app-capable">
  <link rel="shortcut icon" href="../assets/images/logo.png">
  
  <link rel="stylesheet" href="css/ltr-6a8f5d2e.css">
  <link rel="stylesheet" href="css/styleeditar.css">
  <link rel="stylesheet" href="../assets/css/fontawesome.css">
  <link rel="stylesheet" href="../assets/css/templatemo-scholar.css">
  <link rel="stylesheet" href="../assets/css/owl.css">
  <link rel="stylesheet" href="../assets/css/animate.css">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

</head>

<body style="background:#7b6ada;">
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
              <span class="_3ROGm"><img class="_3Kp8s" src="../assets/images/user2.png" alt="Avatar"></span>
              <span style="margin-left:-5px;"><?php echo htmlspecialchars($username); ?></span>
              <span class="_2Vgy6 _1k0u2 cCL9P"></span>
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
                <h1>D<span style="line-height: 1.2; color: rgba(255, 255, 255, 0.75);">Teaches</span></h1>
            </a>
        </div>
        <a class="_19E7J" href="perfil.php">« Voltar ao Perfil</a>
      </div>
      
      <div class="perfil-container">
        <div class="perfil-titulo">Editar Perfil</div>
        
        <?php if(!empty($mensagem)): ?>
        <div class="mensagem-sucesso"><?php echo $mensagem; ?></div>
        <?php endif; ?>
        
        <?php if(!empty($erro)): ?>
        <div class="mensagem-erro"><?php echo $erro; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="formulario">
          
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" style="background-color: #f5f4ff;" value="<?php echo htmlspecialchars($user['email']); ?>" required>
          </div>
          
          <div class="secao-titulo">Alterar Password</div>
          
          <div class="form-group">
            <label for="password_atual">Password Atual</label>
            <input style="background-color: #f5f4ff;" type="password" id="password_atual" name="password_atual">
            <div class="nota-info">Necessário para confirmar qualquer alteração.</div>
          </div>
          
          <div class="form-group">
            <label for="nova_password">Nova Password</label>
            <input type="password" id="nova_password" name="nova_password" style="background-color: #f5f4ff;">
            <div class="nota-info">Deixe em branco para manter a password atual.</div>
          </div>
          
          <div class="form-group">
            <label for="confirmar_password">Confirmar Nova Password</label>
            <input type="password" id="confirmar_password" name="confirmar_password" style="background-color: #f5f4ff;">
          </div>
          <button type="submit" class="btn-salvar">Guardar Alterações</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>