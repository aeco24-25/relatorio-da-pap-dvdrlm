<!DOCTYPE html>
<html lang="pt-pt">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="assets/images/logo.png">

    <title>DTeaches - Login</title>

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

  .main-banner {
    height: 80vh;
  }

  .container {
    text-align: center;
    justify-content: center;
  }
</style>

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky" >
    <div class="container">
        <div class="row">
            <div class="col-12">
                <nav class="main-nav">

                <!-- ***** Logo Start ***** -->
                <img src="assets/images/logo.png" class="header-image" alt="DTeaches Logo" onclick="window.location.href='index.php';">
                <!-- ***** Logo End ***** -->
                <a href="index.php" class="logo">
                  <h1>D<span style="color: #ffffffb0;">Teaches</span></h1>
                </a>

                <!-- ***** Menu Start ***** -->
                <ul class="nav">
                  <li class="scroll-to-section"><a href="./index.php#contact" style="font-weight: 600;">COMEÇAR JÁ</a></li>
                  <li class="scroll-to-section"><a href="./login.php" style="font-weight: 600;">LOGIN</a></li>
                </ul>
                <!-- ***** Menu End ***** -->
                </nav>
            </div>
        </div>
    </div>
  </header>

  <!-- ***** Header Area End ***** -->

  <div class="main-banner">
    <div class="container" style="display: flex;">
        <div class="col-lg-6 align-self-center">
          <div class="section-heading">
            <h1 style="margin-top: -26px;">LOGIN</h1>
          </div>
          <div class="contact-us-content">
            <form style="margin-top: -30px;" id="contact-form" action="processar_login.php" method="post">
              <div class="row">
                <div class="col-lg-12">
                  <fieldset>
                    <input type="email" name="email" id="email" placeholder="E-mail" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input type="password" name="pass" id="pass" placeholder="Password" required="">
                    <p style="margin-top: -10px;" >Não tem uma conta? <a style="color: #ffffffb0;" href="./index.php#contact">Registe-se aqui</a></p>
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input type="hidden" name="data_criacao" value="$data_criacao">
                      <button style="margin-top: 25px;" type="submit" class="btn">ENTRAR</button>
                  </fieldset>
                </div>
              </div>
            </form>
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
    </div>
  </div>

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
