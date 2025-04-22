<div id="root">
  <div data-reactroot="">
    <div class="_6t5Uh" style="height: 78px;">
      <div class="NbGcm">
        <div class="_3vDrO">
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
      <div class="admin-container">
        <div class="nav-admin">
          <?php
          $current_page = basename($_SERVER['PHP_SELF']);
          ?>
          <a href="indexadmin.php" class="<?= ($current_page == 'indexadmin.php') ? 'active' : '' ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a>
          <a href="gerir_utilizadores.php" class="<?= ($current_page == 'gerir_utilizadores.php') ? 'active' : '' ?>"><i class="fas fa-users"></i> Gerir Utilizadores</a>
          <a href="gerir_categorias.php" class="<?= ($current_page == 'gerir_categorias.php') ? 'active' : '' ?>"><i class="fas fa-folder"></i> Gerir Categorias</a>
          <a href="gerir_expressoes.php" class="<?= ($current_page == 'gerir_expressoes.php') ? 'active' : '' ?>"><i class="fas fa-language"></i> Gerir Expressões</a>
          <a href="relatorios.php" class="<?= ($current_page == 'relatorios.php') ? 'active' : '' ?>"><i class="fas fa-chart-bar"></i> Relatórios</a>
        </div>