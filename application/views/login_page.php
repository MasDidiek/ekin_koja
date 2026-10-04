<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Login Form - Petruk Koja Puskesmas Koja.</title>
  <meta name="msapplication-TileColor" content="" />
  <meta name="theme-color" content="" />
  <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
  <meta name="apple-mobile-web-app-capable" content="yes" />
  <meta name="mobile-web-app-capable" content="yes" />
  <meta name="HandheldFriendly" content="True" />
  <meta name="MobileOptimized" content="320" />
  <link rel="icon" href="./favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon" />
  <meta name="description" content="Ekinerja Puskesmas Koja adalah aplikasi yang digunakan untuk melakukan pemantauan kinerja pegawai di Puskesmas Cilincing" />
  <meta name="canonical" content="https://preview.tabler.io/sign-in-illustration.html">

  <meta property="og:image:width" content="1280">
  <meta property="og:image:height" content="640">
  <meta property="og:site_name" content="Tabler">
  <meta property="og:type" content="object">
  <meta property="og:title" content="ekinerja: Puskesmas Koja">
  <meta property="og:description" content="Ekinerja Puskesmas Koja adalah aplikasi yang digunakan untuk melakukan pemantauan kinerja pegawai di Puskesmas Cilincing">
  <!-- CSS files -->
  <link href="<?php echo base_url(); ?>assets/css/tabler.min.css?1685973381" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/tabler-flags.min.css?1685973381" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/tabler-payments.min.css?1685973381" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/tabler-vendors.min.css?1685973381" rel="stylesheet" />
  <link href="<?php echo base_url(); ?>assets/css/demo.min.css?1685973381" rel="stylesheet" />
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }

    .alert-danger {
      background: #fdebeb;
    }
  </style>
</head>

<body class=" d-flex flex-column">
  <?php
  $global_config = $this->Master_model->config_global();
  $logo = $global_config[0]->logo;
  ?>
  <script src="./dist/js/demo-theme.min.js?1685973381"></script>
  <div class="page page-center">
    <div class="container container-normal py-4">
      <div class="row align-items-center g-4">
        <div class="col-lg">
          <div class="container-tight">
            <div class="text-center mb-4">
              <center><img src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>" width="250"></center> <Br><Br>
              <?php echo $this->session->flashdata('msg_login'); ?>
            </div>

            <div class="card card-md">
              <div class="card-body">

                <h2 class="h2 text-center mb-4">Login to your account</h2>
                <form action="<?php echo EKIN; ?>Login/do_login" method="post" autocomplete="off" novalidate>
                  <div class="mb-3">
                    <label class="form-label">NIP / NRK</label>
                    <input type="text" class="form-control <?= form_error('idpegawai') ? 'is-invalid' : '' ?>" value="<?php echo set_value('idpegawai'); ?>" name="idpegawai" placeholder="masukan NIP / NRK anda" autocomplete="off">
                    <span class="invalid-feedback"><?php echo form_error('idpegawai'); ?> </span>
                  </div>
                  <div class="mb-2">
                    <label class="form-label">
                      Password
                      <span class="form-label-description">
                        <a href="./forgot-password.html">I forgot password</a>
                      </span>
                    </label>
                    <div class="input-group input-group-flat">
                      <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>" name="password" placeholder="Your password" id="userpassword" autocomplete="off">

                      <span class="input-group-text">
                        <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip" onclick="showHidePassword()"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                          </svg>
                        </a>
                      </span>
                      <span class="invalid-feedback"> <?php echo form_error('password'); ?></span>
                    </div>
                  </div>
                  <div class="mb-2">
                    <label class="form-check">
                      <input type="checkbox" class="form-check-input" />
                      <span class="form-check-label">Remember me on this device</span>
                    </label>
                  </div>
                  <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Sign in</button>
                  </div>
                </form>
              </div>
              <div class="hr-text">or</div>
              <div class="card-body">
                <div class="row">

                  <div class="text-center text-secondary mt-3">
                    Don't have account yet? <a href="<?php echo base_url(); ?>login/register" tabindex="-1">Sign up</a>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
        <div class="col-lg d-none d-lg-block">
          <img src="<?php echo base_url(); ?>assets/images/login-artwork.svg" height="300" class="d-block mx-auto" alt="">
        </div>
      </div>
    </div>
  </div>
  <!-- Libs JS -->
  <!-- Tabler Core -->
  <script src="<?php echo base_url(); ?>assets/js/tabler.min.js?1685973381" defer></script>
  <script src="<?php echo base_url(); ?>assets/js/demo.min.js?1685973381" defer></script>

  <script>
    function showHidePassword() {
      var x = document.getElementById("userpassword");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>



</body>

</html>