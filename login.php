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

  .container .eye {
    position: absolute;
    animation: keyframes-fill .5s;
  }

  .container .eye-slash {
    position: absolute;
    animation: keyframes-fill .5s;
    display: none;
  }

  .container input:checked ~ .eye {
    display: none;
  }

  .container input:checked ~ .eye-slash {
    display: block;
  }

  /* ------ Animation ------ */
  @keyframes keyframes-fill {
    0% {
      transform: scale(0);
      opacity: 0;
    }

    50% {
      transform: scale(1.2);
    }
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
                    <input style="width:80%;" type="email" name="email" id="email" placeholder="E-mail" required="">
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <input style="width:80%;" type="password" name="pass" id="pass" placeholder="Password" required >
                    <label class="container" style=" --color: #a5a5b0; height:25px; --size: 30px; display: flex;justify-content: right; margin-top: -67px; margin-left: -63px; font-size: var(--size); fill: var(--color);">
                        <input style="width:6%; opacity:0;"type="checkbox" id="togglePassword">
                        <svg class="eye" xmlns="http://www.w3.org/2000/svg" height="0.8em" viewBox="0 0 576 512">
                          <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"></path>
                        </svg>
                        <svg class="eye-slash" xmlns="http://www.w3.org/2000/svg" height="0.8em" viewBox="0 0 640 512">
                          <path d="M38.8 5.1C28.4-3.1 13.3-1.2 5.1 9.2S-1.2 34.7 9.2 42.9l592 464c10.4 8.2 25.5 6.3 33.7-4.1s6.3-25.5-4.1-33.7L525.6 386.7c39.6-40.6 66.4-86.1 79.9-118.4c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C465.5 68.8 400.8 32 320 32c-68.2 0-125 26.3-169.3 60.8L38.8 5.1zM223.1 149.5C248.6 126.2 282.7 112 320 112c79.5 0 144 64.5 144 144c0 24.9-6.3 48.3-17.4 68.7L408 294.5c8.4-19.3 10.6-41.4 4.8-63.3c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3c0 10.2-2.4 19.8-6.6 28.3l-90.3-70.8zM373 389.9c-16.4 6.5-34.3 10.1-53 10.1c-79.5 0-144-64.5-144-144c0-6.9 .5-13.6 1.4-20.2L83.1 161.5C60.3 191.2 44 220.8 34.5 243.7c-3.3 7.9-3.3 16.7 0 24.6c14.9 35.7 46.2 87.7 93 131.1C174.5 443.2 239.2 480 320 480c47.8 0 89.9-12.9 126.2-32.5L373 389.9z"></path>
                        </svg>
                    </label>
                  </fieldset>
                  <p style="margin-top: 40px;" >Não tem uma conta? <a style="color: #ffffffb0;" href="./index.php#contact">Registe-se aqui</a></p>
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

  <script>
    // JavaScript para alternar a visibilidade da senha
    document.getElementById('togglePassword').addEventListener('change', function() {
      const passwordInput = document.getElementById('pass');
      if (this.checked) {
        passwordInput.type = 'text';
      } else {
        passwordInput.type = 'password';
      }
    });
  </script>

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
