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


        $message_error = $this->session->flashdata('message_error');


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
                            <h4 class="mt-0">Perbaharui Password</h4>

                            <p class="text-muted mb-4">Isi form dibawah ini untuk melakukan Perbaharui password.</p>

                              <?php

                                if( $message_error !=''){
                                    echo '<div class="alert alert-danger">'.$message_error.'</div>';
                                }
                              ?>

                                <div class="text-start">
                                <!-- form -->
                                    <form action="<?php echo EKIN; ?>auth/reset_password_process" method="post" name="form-login">
                                        <div class="mb-3">
                                            <label for="emailaddress" class="form-label">NIP/NRK</label>
                                            <input class="form-control"  type="text" required name="nip" placeholder="masukan NIP / NRK anda" autocomplete="off" value="<?php echo set_value('nip');?>" class="form-control   <?= form_error('nip') ? 'is-invalid' : '' ?>">

                                            <div class="error-feedback"> <?php echo form_error('nip'); ?></div>

                                        </div>
                                        <div class="mb-3 pass-field">
                                            <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Masukkan Password Lama</small></a>
                                            <label for="password" class="form-label">Old Password</label>


                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" name="old_password" required="" class="form-control" autocomplete="off"  value="<?php echo set_value('old_password');?>" placeholder="Masukkan password lama">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>

                                            <div class="error-feedback"> <?php echo form_error('new_password'); ?></div>


                                        </div>

                                        <div class="mb-3 pass-field">
                                            <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Masukkan Password baru</small></a>
                                            <label for="password" class="form-label">Password</label>


                                            <div class="input-group input-group-merge">
                                                <input type="password" id="password" name="new_password" required="" class="form-control" autocomplete="off"  value="<?php echo set_value('new_password');?>" placeholder="Masukkan password">
                                                <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>

                                            <div class="error-feedback"> <?php echo form_error('new_password'); ?></div>


                                        </div>



                                        <div class="mb-3">
                                            <a href="pages-recoverpw-2.html" class="text-muted float-end"><small>Ulangi Password</small></a>
                                            <label for="password" class="form-label">Confirm Password</label>
                                            <div class="input-group input-group-merge">
                                             <input class="form-control" type="password" name="conf_password" required="" id="conf_password" autocomplete="off" placeholder="Confirm password">
                                             <div class="input-group-text" data-password="false">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                            <div class="error-feedback"> <?php echo form_error('conf_password'); ?></div>
                                        </div>

                                    <div class="content mt-4">
                                            <strong>Password harus berisi</strong>
                                            <ul class="requirement-list">
                                                  <li>
                                                    <i data-lucide="dot" class="mdi mdi-chevron-right"></i>
                                                    <span>Minimal panjang  8 karakter</span>
                                                  </li>
                                                  <li>
                                                  <i data-lucide="dot" class="mdi mdi-chevron-right"></i>
                                                    <span>Minimal 1 karakter (0...9)</span>
                                                  </li>
                                                  <li>
                                                  <i data-lucide="dot" class="mdi mdi-chevron-right"></i>
                                                    <span>Minimal 1 karakter huruf kecil (a...z)</span>
                                                  </li>
                                                  <li>
                                                  <i data-lucide="dot" class="mdi mdi-chevron-right"></i>
                                                    <span>Minimal 1 karakter spesial karakter (!...$)</span>
                                                  </li>
                                                  <li>
                                                  <i data-lucide="dot" class="mdi mdi-chevron-right"></i>
                                                    <span>Minimal 1 karakter huruf besar (A...Z)</span>
                                                  </li>
                                                </ul>

                                        </div>

                                    <div class="d-grid mb-0 text-center">
                                        <button class="btn btn-primary" type="submit">Reset Password </button>
                                    </div>
                                    <!-- social-->

                                </form>

                                </div>
                                <!-- end form-->


                    </div> <!-- end .card-body -->
                </div> <!-- end .align-items-center.d-flex.h-100-->
            </div>
            <!-- end auth-fluid-form-box-->

        </div>
        <!-- end auth-fluid-->

        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>


        <script>
              var state= false;
              var state2= false;
         function toggle(){
            if(state){
              document.getElementById("password").setAttribute("type","password");
              document.getElementById("eye1").style.color='#7a797e';
              state = false;
            } else{
              document.getElementById("password").setAttribute("type","text");
              document.getElementById("eye1").style.color='#5887ef';
              state = true;
            }
        };

          //validate password
        const passwordInput = document.querySelector(".pass-field input");
        const eyeIcon = document.querySelector(".pass-field i");
        const requirementList = document.querySelectorAll(".requirement-list li");
        // An array of password requirements with corresponding
        // regular expressions and index of the requirement list item
        const requirements = [
            { regex: /.{8,}/, index: 0 }, // Minimum of 8 characters
            { regex: /[0-9]/, index: 1 }, // At least one number
            { regex: /[a-z]/, index: 2 }, // At least one lowercase letter
            { regex: /[^A-Za-z0-9]/, index: 3 }, // At least one special character
            { regex: /[A-Z]/, index: 4 }, // At least one uppercase letter
        ]
        passwordInput.addEventListener("keyup", (e) => {
            requirements.forEach(item => {
                // Check if the password matches the requirement regex
                const isValid = item.regex.test(e.target.value);
                const requirementItem = requirementList[item.index];
                // Updating class and icon of requirement item if requirement matched or not

                if (isValid) {
                    requirementItem.classList.add("valid");
                    requirementItem.firstElementChild.className = "mdi mdi-check";
                } else {
                    requirementItem.classList.remove("valid");
                    requirementItem.firstElementChild.className = "mdi mdi-chevron-right";
                }
            });
        });
    </script>


    </body>

</html>
