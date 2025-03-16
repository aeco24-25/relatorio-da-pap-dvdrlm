<?php
session_start();

// Conectar à base de dados
$conn = new mysqli('localhost', 'root', '', 'dteaches');
if ($conn->connect_error) {
    die("Falha na ligação: " . $conn->connect_error);
}

// Estatísticas gerais
$sql_users = "SELECT COUNT(*) as total_users FROM users";
$result_users = $conn->query($sql_users);
$total_users = $result_users->fetch_assoc()['total_users'];

$sql_expressoes = "SELECT COUNT(*) as total_expressoes FROM expressoes";
$result_expressoes = $conn->query($sql_expressoes);
$total_expressoes = $result_expressoes->fetch_assoc()['total_expressoes'];

$sql_categorias = "SELECT COUNT(*) as total_categorias FROM categoria";
$result_categorias = $conn->query($sql_categorias);
$total_categorias = $result_categorias->fetch_assoc()['total_categorias'];

// Obter categorias
$sql_categorias_lista = "SELECT * FROM categoria ORDER BY id_categoria";
$result_categorias_lista = $conn->query($sql_categorias_lista);
?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
    <meta charset="UTF-8">
    <title>DTeaches - Painel de Administração</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../assets/images/logo.png">
    <link href="../user/ltr-6a8f5d2e.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        
        .header {
            background-color: #1cb0f6;
            color: white;
            padding: 15px 0;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .logo {
            width: 200px;
            height: auto;
        }
        
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 0 20px;
        }
        
        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .card {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .card h3 {
            margin-top: 0;
            font-size: 16px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .card p {
            font-size: 36px;
            font-weight: bold;
            margin: 10px 0;
            color: #1cb0f6;
        }
        
        .admin-section {
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        h2 {
            color: #333;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
            margin-top: 0;
        }
        
        .btn-add {
            background-color: #78c800;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 10px 15px;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
        }
        
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .table th, .table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .table th {
            background-color: #f9f9f9;
            color: #333;
            font-weight: bold;
        }
        
        .table tr:hover {
            background-color: #f5f5f5;
        }
        
        .actions {
            display: flex;
            gap: 10px;
        }
        
        .btn-edit, .btn-delete, .btn-view {
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 12px;
        }
        
        .btn-view {
            background-color: #1cb0f6;
        }
        
        .btn-edit {
            background-color: #f9a826;
        }
        
        .btn-delete {
            background-color: #ff5252;
        }
        
        .navigation {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        
        .nav-link {
            background-color: #1cb0f6;
            color: white;
            padding: 10px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DTeaches - Painel de Administração</h1>
    </div>
    
    <div class="container">
        <div class="navigation">
            <a href="index.php" class="nav-link">Dashboard</a>
            <a href="categorias.php" class="nav-link">Categorias</a>
            <a href="expressoes.php" class="nav-link">Expressões</a>
            <a href="utilizadores.php" class="nav-link">Utilizadores</a>
            <a href="../user/indexuser.php" class="nav-link">Ver Site</a>
            <a href="../logout.php" class="nav-link">Sair</a>
        </div>
        
        <div class="dashboard">
            <div class="card">
                <h3>Utilizadores</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="card">
                <h3>Categorias</h3>
                <p><?php echo $total_categorias; ?></p>
            </div>
            <div class="card">
                <h3>Expressões</h3>
                <p><?php echo $total_expressoes; ?></p>
            </div>
        </div>
        
        <div class="admin-section">
            <h2>Categorias</h2>
            <a href="categorias_add.php" class="btn-add">+ Adicionar Categoria</a>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Expressões</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_categorias_lista->num_rows > 0) {
                        while ($row = $result_categorias_lista->fetch_assoc()) {
                            // Contar expressões nesta categoria
                            $cat_id = $row['id_categoria'];
                            $sql_count = "SELECT COUNT(*) as total FROM expressoes WHERE id_categoria = $cat_id";
                            $result_count = $conn->query($sql_count);
                            $count_row = $result_count->fetch_assoc();
                            
                            echo "<tr>
                                    <td>{$row['id_categoria']}</td>
                                    <td>{$row['titulo']}</td>
                                    <td>{$count_row['total']} expressões</td>
                                    <td class='actions'>
                                        <a href='categorias_view.php?id={$row['id_categoria']}' class='btn-view'>Ver</a>
                                        <a href='categorias_edit.php?id={$row['id_categoria']}' class='btn-edit'>Editar</a>
                                        <a href='categorias_delete.php?id={$row['id_categoria']}' class='btn-delete' onclick='return confirm(\"Tem certeza que deseja excluir esta categoria?\")'>Excluir</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align: center;'>Nenhuma categoria encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        
        <div class="admin-section">
            <h2>Últimas Expressões Adicionadas</h2>
            <a href="expressoes_add.php" class="btn-add">+ Adicionar Expressão</a>
            
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Inglês</th>
                        <th>Português</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql_expressoes_recentes = "SELECT e.*, c.titulo as categoria_nome 
                                              FROM expressoes e 
                                              JOIN categoria c ON e.id_categoria = c.id_categoria 
                                              ORDER BY e.id_expressao DESC LIMIT 5";
                    $result_expressoes_recentes = $conn->query($sql_expressoes_recentes);
                    
                    if ($result_expressoes_recentes->num_rows > 0) {
                        while ($row = $result_expressoes_recentes->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['id_expressao']}</td>
                                    <td>{$row['versao_ingles']}</td>
                                    <td>{$row['traducao_portugues']}</td>
                                    <td>{$row['categoria_nome']}</td>
                                    <td class='actions'>
                                        <a href='expressoes_edit.php?id={$row['id_expressao']}' class='btn-edit'>Editar</a>
                                        <a href='expressoes_delete.php?id={$row['id_expressao']}' class='btn-delete' onclick='return confirm(\"Tem certeza que deseja excluir esta expressão?\")'>Excluir</a>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align: center;'>Nenhuma expressão encontrada.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>