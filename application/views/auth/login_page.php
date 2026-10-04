<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Log In | Ekinerja Cilincing</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- App css -->
        <link href="<?php echo base_url();?>assets/new/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url();?>assets/new/css/app.min.css" rel="stylesheet" type="text/css" id="light-style" />
        <link href="<?php echo base_url();?>assets/new/css/app-dark.min.css" rel="stylesheet" type="text/css" id="dark-style" />


        <style>
            .auth-fluid{
                background:url("<?php echo base_url();?>assets/images/bg-login2.jpg");
            }
        </style>

    </head>

    <body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

    <?php
        $dateNow = date('Y-m-d');
        $hari = format_hari($dateNow);
        $blnNow = date('m');

        $bln_lalu = $blnNow - 1;
        $nama_bulan_lalu = getBulan($bln_lalu);

        $tanggal_hari_ini = formatTanggalIndo($dateNow);

        $exlode = explode(" ", $tanggal_hari_ini);
        $bulan  = $exlode[1];

        $tgl_now = date('d');

        if ($tgl_now < 6) {
            $showInfo =  true;
        } else {
            $showInfo =  false;
        }

        $global_config = $this->Master_model->config_global();
        $logo = $global_config[0]->logo;
    ?>

        <div class="auth-fluid">

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
            <!-- end Auth fluid right content -->


            <!--Auth fluid left content -->
            <div class="auth-fluid-form-box">
                <div class="align-items-center d-flex h-100">
                    <div class="card-body">
                      <br>
                        <!-- Logo -->
                        <div>

                        <a href="index.html" class="logo-light">
                            <span> <img  src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>" style="width:150px" alt=""></span>
                            </a>
                        </div>
                        <!-- title-->
                         <br><br>

                        <h4 class="mt-0">Sign In</h4>

                        <p class="text-muted mb-4">Enter your email address and password to access account.</p>

                        <?php
                            $msg = $this->session->flashdata('error');
                            $nip = $this->session->flashdata('nip');

                            if($msg !=''){
                                echo '<div class="alert alert-danger">Login Gagal! '.$msg .'</div>';
                            }

                        ?>

                        <!-- form -->
                        <form action="<?php echo EKIN; ?>auth/login_process" method="post" name="form-login">
                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">NIP/NRK</label>
                                <input   type="text" required name="idpegawai" value="<?= html_escape($nip); ?>" placeholder="masukan NIP / NRK anda" autocomplete="off" class="form-control   <?= form_error('idpegawai') ? 'is-invalid' : '' ?>">
                            </div>
                            <div class="mb-3">
                            <!-- <a href="<?php //echo base_url();?>auth/reset_password" class="text-muted float-end"><small>Forgot your password?</small></a> -->
                              <label for="password" class="form-label">Password</label><br>
                                <div class="input-group input-group-merge">

                                    <input type="password" id="password" name="password" required="" class="form-control" autocomplete="off"  placeholder="Masukkan password">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin">
                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>
                            <div class="d-grid mb-0 text-center">
                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-login"></i> Log In </button>
                            </div>
                            <!-- social-->
                            <div class="text-center mt-4">
                                <p class="text-muted font-16">Sign in with</p>
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
                            <p class="text-muted">Don't have an account? <a href="pages-register-2.html" class="text-muted ms-1"><b>Sign Up</b></a></p>
                        </footer>

                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

    </body>

</html>
