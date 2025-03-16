<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

$username = $_SESSION['username'];
$mensagem = '';
$erro = '';

// Conectar à base de dados
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

// Processar o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password_atual = $_POST['password_atual'];
    $nova_password = $_POST['nova_password'];
    $confirmar_password = $_POST['confirmar_password'];
    
    // Verificar se a password atual está correta
    if ($password_atual !== $user['pass']) {
        $erro = "A password atual está incorreta.";
    } else {
        // Verificar se o email é válido
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
                // Se o utilizador quiser alterar a password
                if (!empty($nova_password)) {
                    // Verificar se as passwords coincidem
                    if ($nova_password !== $confirmar_password) {
                        $erro = "As novas passwords não coincidem.";
                    } else {
                        // Atualizar email e password
                        $stmt = $conn->prepare("UPDATE users SET email = ?, pass = ? WHERE username = ?");
                        $stmt->bind_param("sss", $email, $nova_password, $username);
                        
                        if ($stmt->execute()) {
                            $mensagem = "Perfil atualizado com sucesso!";
                        } else {
                            $erro = "Erro ao atualizar o perfil: " . $conn->error;
                        }
                    }
                } else {
                    // Apenas atualizar o email
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
  <link href="ltr-6a8f5d2e.css" rel="stylesheet">
  <style>
    .perfil-container {
      max-width: 800px;
      margin: 0 auto;
      margin-top: 110px;
    }

    .perfil-titulo {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 30px;
      color: #333;
      text-align: center;
    }
    
    .formulario {
      background-color: #fff;
      border-radius: 12px;
      padding: 30px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .form-group {
      margin-bottom: 20px;
    }
    
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 8px;
      color: #444;
    }
    
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 12px;
      border: 2px solid #e0e0e0;
      border-radius: 8px;
      font-size: 16px;
      transition: border-color 0.3s ease;
    }
    
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #1cb0f6;
      outline: none;
    }
    
    .btn-salvar {
      background-color: #1cb0f6;
      color: white;
      border: none;
      border-radius: 8px;
      padding: 12px 24px;
      font-size: 16px;
      font-weight: bold;
      cursor: pointer;
      width: 100%;
      margin-top: 10px;
      transition: background-color 0.3s ease;
    }
    
    .btn-salvar:hover {
      background-color: #0c8ed2;
    }
    
    .mensagem-sucesso {
      background-color: #e6f7e6;
      border-left: 4px solid #78c800;
      color: #2e7d32;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
    }
    
    .mensagem-erro {
      background-color: #ffeaea;
      border-left: 4px solid #ff5252;
      color: #c62828;
      padding: 15px;
      margin-bottom: 20px;
      border-radius: 4px;
    }
    
    .secao-titulo {
      font-size: 18px;
      font-weight: bold;
      margin: 30px 0 15px;
      color: #333;
      border-bottom: 1px solid #e0e0e0;
      padding-bottom: 10px;
    }
    
    .campo-desativado {
      background-color: #f5f5f5;
      cursor: not-allowed;
    }
    
    .nota-info {
      font-size: 14px;
      color: #666;
      margin-top: 8px;
      font-style: italic;
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
              <span class="_3ROGm"><img class="_3Kp8s" src="../assets/images/user.png" alt="Avatar do Utilizador"></span><span><?php echo htmlspecialchars($username); ?></span><span class="_2Vgy6 _1k0u2 cCL9P"></span>
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
          <a style="margin-left: 45px; background-position: -234px; height: 35px; width: 235px; background-size: cover; background-image:url(dteaches.png);" class="NJXKT _1nAJB cCL9P _2s5Eb" data-test="topbar-logo" href="indexuser.php"></a>
          <div class="_3I8Kk"></div>
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
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
          </div>
          
          <div class="secao-titulo">Alterar Password</div>
          
          <div class="form-group">
            <label for="password_atual">Password Atual</label>
            <input type="password" id="password_atual" name="password_atual">
            <div class="nota-info">Necessário para confirmar qualquer alteração.</div>
          </div>
          
          <div class="form-group">
            <label for="nova_password">Nova Password</label>
            <input type="password" id="nova_password" name="nova_password">
            <div class="nota-info">Deixe em branco para manter a password atual.</div>
          </div>
          
          <div class="form-group">
            <label for="confirmar_password">Confirmar Nova Password</label>
            <input type="password" id="confirmar_password" name="confirmar_password">
          </div>
          
          <button type="submit" class="btn-salvar">Guardar Alterações</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>