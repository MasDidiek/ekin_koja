<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Reset Password | Ekinerja Cilincing</title>
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
                background:url("<?php echo base_url();?>assets/images/bg-reset.jpg") ;
            }

    
            .wrapper .content {
                margin:0;
            }
            .content p {
                color: #333;
                font-size: 1.3rem;
            }
            .content .requirement-list {
                margin-top: 20px;
                color: #900;
            }
            .requirement-list li {
                font-size: 0.8rem;
                list-style: none;
                display: flex;
                align-items: center;
                margin-bottom: 5px;
            
            }
            .requirement-list li i {
                width: 20px;
                color: #aaa;
                font-size: 0.6rem;
            }
            .requirement-list li.valid i {
                font-size: 1.2rem;
                color: green;
            }
            .requirement-list li span {
                margin-left: 12px;
                color: #333;
            }
            .requirement-list li.valid span {
                color:#229f48;
            }

            #form_change_password p{
                color: #f06b59;
            }

            .error-feedback{
                color: #f06b59;
            }
        </style>

    </head>

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

    <body class="loading authentication-bg" data-layout-config='{"leftSideBarTheme":"dark","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xxl-4 col-lg-5">
                        <div class="card">

                            <!-- Logo -->
                            <div class="card-header pt-4 pb-4 text-center bg-primary">
                                <a href="index.html">
                                <span> <img  src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>" style="width:150px" alt=""></span>
                                </a>
                            </div>

                     <div class="card-body">
                             
                    

                        <div class="text-center  m-auto"> 
                            <h4 class="mt-0 text-danger"> <i class="mdi mdi-lock-alert-outline"></i>  Warning!<br> Perbaharui Password / kata sandi</h4>
                            
                            <p class="text-muted mb-4">
                                Demi meningkatkan sistem keamanan, mohon perbaharui password atau kata sandi, karena saat ini password lama sudah tidak dapat digunakan.
                            </p>
                              <a href="<?php echo base_url();?>reset_password" class="btn btn-info">Mulai Perbaharui Sandi</a>

                              <br><br>
        <p>Jika anda sudah melakukan pembaruan password dalam 7 hari terakhir, silahkan klik tombol login </p>
                               
                              <a href="<?php echo base_url();?>auth/login" class="btn btn-success">Login</a>

                                <!-- end form-->

                        </div>
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