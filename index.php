<!DOCTYPE html>
<html lang="pt-pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="assets/images/logo.png">
	  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>DTeaches</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-scholar.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
	
	<!-- TemplateMo 586 Scholar https://templatemo.com/tm-586-scholar -->
  </head>

<body>
  <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

<style>
  .header-area.header-sticky .header-image {
      margin-top: -29px;
      width: 165px;
      margin-left: 45px;
      margin-right: 19px;
      object-fit: contain;
  }

  .header-area.header-sticky.background-header .header-image {
      margin-top: -12px;
      width: 165px;
      margin-left: 45px;
      margin-right: 19px;
      object-fit: contain;
  }
</style>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky" >
    <?php
      include ("menu.inc");
    ?>
  </header>

  <!-- ***** Header Area End ***** -->

  <div class="main-banner" id="top">
    <div class="container" style="max-width:1200px; margin-top: -20px;">
      <div class="row">
        <div class="col-lg-12">
          <div class="owl-carousel owl-banner">
            <div class="item item-1" style="margin-right: -25px; background-position: right; background-size: contain;">
              <div class="header-text" style="margin-left: -155px; margin-top: -30px;">
                <h2 style="width:55%;">Enriqueça a sua Viagem</h2>
                  <p style="width:47%; margin-top:-10px;">Aprender algumas expressões básicas pode fazer uma grande diferença na sua experiência de viagem. Desde pedir comida a solicitar direções, conhecer o básico do idioma local torna a sua experiência mais rica e agradável.</p>
              </div>
            </div>
            <div class="item item-2" style="margin-top: 10px; margin-right: 110px; background-position: right; background-size: contain;">
              <div class="header-text" style="margin-left: -120px; margin-top: -25px;">
                <h2 style="width:55%;">Grátis e Divertido!</h2>
                  <p style="width:42%; margin-top:-10px;">Estudar é mais divertido com lições rápidas e interativas — e melhor ainda, não precisa de pagar nada para aprender.</p>
              </div>
            </div>
            <div class="item item-3" style="margin-top: 10px; margin-right: 110px; background-position: right; background-size: contain;">
              <div class="header-text" style="margin-left: -120px; margin-top: -25px;">
                <h2 style="width:55%;">aaaaa</h2>
                  <p style="width:42%; margin-top:-10px;">aaaaa</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="services section" id="services">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 col-md-6">
          <div class="service-item">
            <div class="icon">
              <img src="assets/images/dialogo.png" alt="online degrees" style="max-width:98px;">
            </div>
            <div class="main-content">
              <h4>aaaaa</h4>
              <p>aaaaa</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="service-item">
            <div class="icon">
              <img src="assets/images/aviao.png" alt="short courses" style="max-width:120px;">
            </div>
            <div class="main-content">
              <h4>aaaaa</h4>
              <p>aaaaa</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="service-item">
            <div class="icon">
              <img src="assets/images/lapis.png" alt="web experts" style="margin-top:-5px;">
            </div>
            <div class="main-content">
              <h4>aaaaa</h4>
              <p>aaaaa</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="contact-us section" id="contact">
    <div class="container">
      <div class="row">
        <div class="col-lg-6  align-self-center">
          <div class="section-heading">
            <h6>COMEÇAR JÁ</h6>
            <h2>Criar Conta</h2>
            <p>Ao entrar no DTeaches, concorda com os Termos e Política de Privacidade.</p>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="contact-us-content">
            <form id="contact-form" action="processar_registo.php" method="post">
              <div class="row">
                <div class="col-lg-12">
                  <fieldset>
                    <input style="width: 100%;" type="text" name="username" id="username" placeholder="Nome" autocomplete="on" required>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input style="width: 100%;" type="email" name="email" id="email" placeholder="E-mail" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input style="width: 100%;" type="password" name="pass" id="pass" placeholder="Password" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input type='hidden' name='data_criacao' value='$data_criacao'>
                    <button style="width: 100%;" type="submit" id="form-submit" class="orange-button">Crie o seu perfil</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <footer>
    <div class="container">
      <div class="col-lg-12">
        <p>© 2024-2025 DTeaches. Todos os direitos reservados.</a></p>
      </div>
    </div>
  </footer>

  <!-- Scripts -->
  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/js/isotope.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/counter.js"></script>
  <script src="assets/js/custom.js"></script>

  </body>
</html>