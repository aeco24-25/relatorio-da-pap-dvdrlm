<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../login.php');
    exit();
}

// Verificar se o usuário é admin (você precisaria adicionar esta coluna na tabela users)
$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

$sql = "SELECT is_admin FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// if (!$user || !$user['is_admin']) {
//     header('Location: ../user/indexuser.php');
//     exit();
// }

// Obter estatísticas para o painel admin
$sql_stats = "SELECT 
    (SELECT COUNT(*) FROM users) as total_users,
    (SELECT COUNT(*) FROM expressoes) as total_expressoes,
    (SELECT COUNT(*) FROM progresso WHERE completo = TRUE) as total_completas,
    (SELECT COUNT(DISTINCT username) FROM progresso WHERE completo = TRUE) as usuarios_ativos";
$result_stats = $conn->query($sql_stats);
$stats = $result_stats->fetch_assoc();

// Obter últimos usuários registrados
$sql_last_users = "SELECT username, email, data_criacao FROM users ORDER BY data_criacao DESC LIMIT 5";
$result_last_users = $conn->query($sql_last_users);

// Obter categorias com estatísticas
$sql_categorias = "SELECT 
    c.id_categoria, 
    c.titulo,
    COUNT(e.id_expressao) as total_expressoes,
    (SELECT COUNT(*) FROM progresso p 
     JOIN expressoes e2 ON p.id_expressao = e2.id_expressao 
     WHERE e2.id_categoria = c.id_categoria AND p.completo = TRUE) as completas
FROM categoria c
LEFT JOIN expressoes e ON c.id_categoria = e.id_categoria
GROUP BY c.id_categoria, c.titulo
ORDER BY c.id_categoria";
$result_categorias = $conn->query($sql_categorias);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <title>DTeaches - Admin</title>
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
    .admin-stats {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
      gap: 20px;
      margin-bottom: 30px;
    }
    
    .stat-card {
      background: #fcfcff;
      border-radius: 12px;
      padding: 20px;
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
      background: #fcfcff;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 20px;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
  <div id="root">
    <div data-reactroot="">
      <div class="_6t5Uh" style="height: 78px;">
        <div class="NbGcm">
          <div class="_3vDrO">
            <div class="_3I51r _2OF7V">
              <span class="oboa9 _3viv6 HCWXf _3PU7E _3JPjo" style="margin-right: 5px;"></span><span class="_1icRZ _1k9o2 cCL9P"></span>
            </div>
            <div class="_1ALvM"></div>
            <div class="_1G4t1 _3HsQj _2OF7V" data-test="user-dropdown">
              <span class="_3ROGm"><img class="_3Kp8s" src="../assets/images/user2.png" alt="Avatar"></span>
              <span style="margin-left:-5px;"><?php echo htmlspecialchars($_SESSION['username']); ?> (Admin)</span>
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
          <a href="indexadmin.php" class="logo">
          <h1>D<span style="line-height: 1.2; color: rgba(255, 255, 255, 0.75);">Teaches</span></h1>
          </a>
        </div>
      </div>
      
      <div class="LFfrA _3MLiB">
        <div class="nav-admin">
          <a href="indexadmin.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="gerir_utilizadores.php"><i class="fas fa-users"></i> Gerir Utilizadores</a>
          <a href="gerir_categorias.php"><i class="fas fa-folder"></i> Gerir Categorias</a>
          <a href="gerir_expressoes.php"><i class="fas fa-language"></i> Gerir Expressões</a>
          <a href="relatorios.php"><i class="fas fa-chart-bar"></i> Relatórios</a>
        </div>
        
        <div class="_2_lzu" style="line-height:0.75;">
          <div class="_21w25 _1E3L7" style="background:#7b6ada;">
            <h2 style="text-align: center; color:#ffffff">Estatísticas Gerais</h2>
            <div class="admin-stats">
              <div class="stat-card">
                <h3>Utilizadores Registados</h3>
                <div class="stat-number"><?php echo $stats['total_users']; ?></div>
                <i class="fas fa-users fa-2x" style="color: #7b6ada;"></i>
              </div>
              
              <div class="stat-card">
                <h3>Expressões no Sistema</h3>
                <div class="stat-number"><?php echo $stats['total_expressoes']; ?></div>
                <i class="fas fa-language fa-2x" style="color: #7b6ada;"></i>
              </div>
              
              <div class="stat-card">
                <h3>Exercícios Completos</h3>
                <div class="stat-number"><?php echo $stats['total_completas']; ?></div>
                <i class="fas fa-check-circle fa-2x" style="color: #7b6ada;"></i>
              </div>
              
              <div class="stat-card">
                <h3>Utilizadores Ativos</h3>
                <div class="stat-number"><?php echo $stats['usuarios_ativos']; ?></div>
                <i class="fas fa-user-check fa-2x" style="color: #7b6ada;"></i>
              </div>
            </div>
          </div>
          
          <div class="admin-section">
            <h2><i class="fas fa-users"></i> Últimos Utilizadores Registados</h2>
            <a href="adicionar_utilizador.php" class="admin-btn add-btn"><i class="fas fa-plus"></i> Adicionar Utilizador</a>
            <table class="user-table">
              <thead>
                <tr>
                  <th>Username</th>
                  <th>Email</th>
                  <th>Data de Registo</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php while($user = $result_last_users->fetch_assoc()): ?>
                <tr>
                  <td><?php echo htmlspecialchars($user['username']); ?></td>
                  <td><?php echo htmlspecialchars($user['email']); ?></td>
                  <td><?php echo date('d/m/Y H:i', strtotime($user['data_criacao'])); ?></td>
                  <td class="admin-actions">
                    <a href="editar_utilizador.php?username=<?php echo $user['username']; ?>" class="admin-btn edit-btn"><i class="fas fa-edit"></i> Editar</a>
                    <a href="eliminar_utilizador.php?username=<?php echo $user['username']; ?>" class="admin-btn delete-btn" onclick="return confirm('Tem a certeza que deseja eliminar este utilizador?')"><i class="fas fa-trash"></i> Eliminar</a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
          
          <div class="admin-section">
            <h2><i class="fas fa-folder"></i> Categorias</h2>
            <a href="adicionar_categoria.php" class="admin-btn add-btn"><i class="fas fa-plus"></i> Adicionar Categoria</a>
            <table class="category-table">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>Título</th>
                  <th>Expressões</th>
                  <th>Completas</th>
                  <th>Progresso</th>
                  <th>Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php while($categoria = $result_categorias->fetch_assoc()): 
                  $percent = ($categoria['total_expressoes'] > 0) ? round(($categoria['completas'] / $categoria['total_expressoes']) * 100) : 0;
                ?>
                <tr>
                  <td><?php echo $categoria['id_categoria']; ?></td>
                  <td><?php echo htmlspecialchars($categoria['titulo']); ?></td>
                  <td><?php echo $categoria['total_expressoes']; ?></td>
                  <td><?php echo $categoria['completas']; ?></td>
                  <td>
                    <div style="background:#e2e2e2; height:10px; border-radius:5px;">
                      <div style="background:#7b6ada; height:10px; border-radius:5px; width:<?php echo $percent; ?>%"></div>
                    </div>
                    <small><?php echo $percent; ?>%</small>
                  </td>
                  <td class="admin-actions">
                    <a href="editar_categoria.php?id=<?php echo $categoria['id_categoria']; ?>" class="admin-btn edit-btn"><i class="fas fa-edit"></i> Editar</a>
                    <a href="eliminar_categoria.php?id=<?php echo $categoria['id_categoria']; ?>" class="admin-btn delete-btn" onclick="return confirm('Tem a certeza que deseja eliminar esta categoria?')"><i class="fas fa-trash"></i> Eliminar</a>
                  </td>
                </tr>
                <?php endwhile; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>