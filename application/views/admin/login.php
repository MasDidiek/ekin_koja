
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
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>SIPUSPA - SkrIning Kesehatan Pengemudi BUS PuskesmAs Cakung.</title>
    <script defer data-api="/stats/api/event" data-domain="preview.tabler.io" src="/stats/js/script.js"></script>
    <meta name="msapplication-TileColor" content=""/>
    <meta name="theme-color" content=""/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="HandheldFriendly" content="True"/>
    <meta name="MobileOptimized" content="320"/>
    <link rel="icon" href="./favicon.ico" type="image/x-icon"/>
    <link rel="shortcut icon" href="./favicon.ico" type="image/x-icon"/>
    <meta name="description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!"/>
    <meta name="canonical" content="https://preview.tabler.io/sign-in-illustration.html">
    <meta name="twitter:image:src" content="https://preview.tabler.io/static/og.png">
    <meta name="twitter:site" content="@tabler_ui">
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta name="twitter:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <meta property="og:image" content="https://preview.tabler.io/static/og.png">
    <meta property="og:image:width" content="1280">
    <meta property="og:image:height" content="640">
    <meta property="og:site_name" content="Tabler">
    <meta property="og:type" content="object">
    <meta property="og:title" content="Tabler: Premium and Open Source dashboard template with responsive and high quality UI.">
    <meta property="og:url" content="https://preview.tabler.io/static/og.png">
    <meta property="og:description" content="Tabler comes with tons of well-designed components and features. Start your adventure with Tabler and make your dashboard great again. For free!">
    <!-- CSS files -->
    <link href="<?php echo base_url();?>assets/css/tabler.min.css?1685973381" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/tabler-flags.min.css?1685973381" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/tabler-payments.min.css?1685973381" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/tabler-vendors.min.css?1685973381" rel="stylesheet"/>
    <link href="<?php echo base_url();?>assets/css/demo.min.css?1685973381" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="./dist/js/demo-theme.min.js?1685973381"></script>
    <div class="page page-center">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-4">
          <div class="col-lg">
            <div class="container-tight">
              <div class="text-center mb-4">
                   <a href="<?php echo base_url();?>" class="navbar-brand navbar-brand-autodark">
                    SIPUSPA
                  </a>
                <h5>

                     <div class="caption"> <span>S</span>kr<span>I</span>ning
                                    Kesehatan <span>P</span>engemudi B<span>US P</span>uskesm<span>A</span>s</div>
                </h5>
              </div>
              <div class="card card-md">



                <div class="card-body">
                     <?php
                     $error = $this->session->flashdata('error_login');




                     echo $error;
                  ?>
                  <h2 class="h2 text-center mb-4">Login to your account</h2>
                 <form method="post" name="login" action="<?php echo base_url('admin/login/do_login');?>">
                    <div class="mb-3">
                      <label class="form-label">Username</label>
                        <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" value="<?php echo set_value('username'); ?>"  name="username"  placeholder="masukan username anda" autocomplete="off">
                      <span class="invalid-feedback"><?php echo form_error('username'); ?> </span>
                    </div>
                    <div class="mb-2">
                      <label class="form-label">
                        Password
                        <span class="form-label-description">
                          <a href="./forgot-password.html">I forgot password</a>
                        </span>
                      </label>
                      <div class="input-group input-group-flat">
                          <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?>"  name="password"  placeholder="Your password" id="userpassword"  autocomplete="off">

                        <span class="input-group-text">
                          <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"  onclick="showHidePassword()"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" /><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" /></svg>
                          </a>
                        </span>
                        <span class="invalid-feedback"> <?php echo form_error('password'); ?></span>
                      </div>
                    </div>
                    <div class="mb-2">
                      <label class="form-check">
                        <input type="checkbox" class="form-check-input"/>
                        <span class="form-check-label">Remember me on this device</span>
                      </label>
                    </div>
                    <div class="form-footer">
                      <button type="submit" class="btn bg-primary w-100 text-white">Sign in</button>
                    </div>
                  </form>
                </div>


               <?php
                   // print_array($this->session->flashdata);

               ?>

              </div>
              <div class="text-center text-secondary mt-3">
                Don't have account yet? <a href="./sign-up.html" tabindex="-1">Sign up</a>
              </div>
            </div>
          </div>
          <div class="col-lg d-none d-lg-block">
           <img src="<?php echo base_url();?>assets/img/creative_design.jpg" alt="sidokar">
          </div>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->

    <script src="<?php echo base_url();?>assets/js/tabler.min.js?1685973381" defer></script>
    <script src="<?php echo base_url();?>assets/js/demo.min.js?1685973381" defer></script>

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
