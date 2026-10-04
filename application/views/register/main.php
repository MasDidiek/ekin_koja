<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Register | Hyper - Responsive Bootstrap 5 Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>assets/images/favicon.png"  />

         <!-- App css -->
         <link href="<?php echo base_url();?>assets/new/css/icons.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url();?>assets/new/css/app.min.css" rel="stylesheet" type="text/css" id="light-style">
        <link href="<?php echo base_url();?>assets/new/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style">


        
        <style>
            .auth-fluid{
                background:url("<?php echo base_url();?>assets/images/register_image.png");
            }
        </style>



    </head>

    <body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

        <div class="auth-fluid">
            <!--Auth fluid left content -->
            

            <!-- Auth fluid right content -->
            <div class="auth-fluid-right text-center">
                <div class="auth-user-testimonial">
                <h2 class="mb-3">Bangga Melayani Bangsa</h2>
                    <p class="lead"><i class="mdi mdi-format-quote-open"></i> Puskesmas Cilincing. Ramah, Cepat, Nyaman<i class="mdi mdi-format-quote-close"></i>
                    </p>
                    <p>
                        
                    </p>
                </div> <!-- end auth-user-testimonial-->
            </div>

            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">

                        <!-- Logo -->
                        <div class="auth-brand text-center text-lg-start">
                            <a href="<?php echo base_url();?>" class="logo-dark">
                            <img src="<?php echo base_url();?>assets/images/logo-ekin-baru.png" alt="" height="40">
                            </a>
                            <a href="<?php echo base_url();?>" class="logo-light">
                            <img src="<?php echo base_url();?>assets/images/logo-ekin-baru.png" alt="" height="40">
                            </a>
                        </div>

                        <!-- title-->
                        <h4 class="mt-0">Registrasi </h4>
                        <p class="text-muted mb-4">Don't have an account? Create your account, it takes less than a minute</p>

                        <!-- form -->
                        <form action="<?php echo base_url();?>register/set_session" method="post">
                            <div class="mb-3">
                                <label for="fullname" class="form-label">Nama Lengkap</label>
                                <input class="form-control" type="text" id="fullname" name="nama" placeholder="Masukkan nama lengkap" required>
                            </div>
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Alamat Email</label>
                                <input class="form-control" type="email" id="emailaddress" name="email" required placeholder="Masukkan alamat email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input class="form-control" type="password" required id="password" name="password" placeholder="Masukkan password">
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signup">
                                    <label class="form-check-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-muted">Terms and Conditions</a></label>
                                </div>
                            </div>
                            <div class="mb-0 d-grid text-center">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-account-circle"></i> Sign Up </button>
                            </div>
                            <!-- social-->
                            <div class="text-center mt-4">
                                <p class="text-muted font-16">Sign up using</p>
                                <ul class="social-list list-inline mt-3">
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-primary text-primary"><i class="mdi mdi-facebook"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github"></i></a>
                                    </li>
                                </ul>
                            </div>
                        </form>
                        <!-- end form-->

                        <!-- Footer-->
                        <footer class="footer footer-alt">
                            <p class="text-muted">Already have account? <a href="<?php echo base_url();?>login/login_page" class="text-muted ms-1"><b>Log In</b></a></p>
                        </footer>

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

            <!-- end Auth fluid right content -->
        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->

         <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

        <!-- demo end -->

    </body>

</html>