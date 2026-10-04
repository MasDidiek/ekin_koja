
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Ekinerja | Puskesmas Cilincing</title>

      <!-- Layout config Js -->
	<link rel="shortcut icon" type="image/png" href="<?php echo base_url();?>assets/images/favicon.png"  />   <
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">


    <meta name="description" content="Sistem penginputan dan pemantauan kinerja pegawai Puskesmas Cilincing" itemprop="description" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="initial-scale = 1.0, user-scalable = no, width=device-width, height=device-height, maximum-scale=1.0" />
    <meta property="og:type" content="application" />
    <meta property="og:site_name" content="ekinerja" />
    <meta property="og:title" content="ekinerja - Sistem penginputan dan pemantauan kinerja pegawai Puskesmas Cilincing" />
    <meta property="og:image" content="<?php echo base_url();?>assets/images/logo-ekin-baru.png" />
    <meta property="og:description" content="Sistem penginputan dan pemantauan kinerja pegawai Puskesmas Cilincing" />
    <meta property="og:url" content="https://ekinerja-puskesmascilincing.jakarta.go.id/" />
    <meta property="og:image:type" content="image/jpeg" />
    <meta property="og:image:width" content="650" />
    <meta property="og:image:height" content="366" />
    <meta name="copyright" content="" itemprop="dateline" />
    <meta name="p:domain_verify" content="2057b86bf61e5a346e22a380c6fecf89" />
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow" />
    <meta name="googlebot-news" content="index, follow" />
    
    <meta content="Sistem penginputan dan pemantauan kinerja pegawai Puskesmas Cilincing" itemprop="headline" />
    <meta name="keywords" content="ekinerja puskesmas cilincing, ekin puskesmas cilincing, sistem informasi kinerja puskesmas cilincing" itemprop="keywords" />
    <meta name="thumbnailUrl" content="<?php echo base_url();?>assets/images/logo-ekin-baru.png" itemprop="thumbnailUrl" />
    <meta name="dtk:acctype" content="acc-ekinerja" />
    <meta name="dtk:kanalid" content="-" />
    <meta name="dtk:articleid" content="-" />
    <meta name="dtk:createddate" content="-1" />


    
    <style>
     

      body {
          color: #000;
          overflow-x: hidden;
          height: 100%;
          background-color: #FFF;
          background-repeat: no-repeat;
          font-family: "Roboto", serif;
        
      }
      .bg-blue{
        background-color:rgb(55, 103, 150);
      }

        .card0 {
            box-shadow: 0px 1px 10px 0px #EEE;
            border-radius: 0px;

        }

        .card2 {
            margin: 0px 40px;
        }

        .logo {
            width: 150px;
            height: 40px;
            margin-top: 20px;
            margin-left: 35px;
        }

        .image {
            width: 360px;
            height: 280px;
        }

        .border-line {
            border-right: 1px solid #EEEEEE;
        }

   

        .text-sm {
            font-size: 14px !important;
        }

        ::placeholder {
            color: #BDBDBD;
            opacity: 1;
            font-weight: 300
        }

        :-ms-input-placeholder {
            color: #BDBDBD;
            font-weight: 300
        }

        ::-ms-input-placeholder {
            color: #BDBDBD;
            font-weight: 300
        }

        input, textarea {
            padding: 10px 12px 10px 12px;
            border: 1px solid lightgrey;
            border-radius: 2px;
            margin-bottom: 5px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            color: #2C3E50;
            font-size: 14px;
            border-radius: 8px;
            
        }

        input:focus, textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #304FFE;
            outline-width: 0;
        }

        .topheader{
           background: rgb(107,99,242);
            background: linear-gradient(90deg, rgba(107,99,242,1) 0%, rgba(70,70,241,1) 25%, rgba(0,212,255,1) 100%); ;
        }

        
        ol li{
          font-size: 14px;
          
        }

        .btn-custom {
            background: rgb(107,99,242);
            background: linear-gradient(90deg, rgba(107,99,242,1) 0%, rgba(70,70,241,1) 25%, rgba(0,212,255,1) 100%); ;
            width: 150px;
            color: #fff;
            border-radius: 8px;
        }

        .btn-custom:hover {
            background: rgb(0,212,255);
background: linear-gradient(90deg, rgba(0,212,255,1) 0%, rgba(107,99,242,1) 84%, rgba(70,70,241,1) 100%); 
            cursor: pointer;
            color: #fff;
        }

     
        .alert{
          font-size: 12px;
        }

        .container-fluid{
          max-width: 70%;
         
        }

        @media screen and (max-width: 1400px) {
           

            .container-fluid{
              max-width: 90%;
            }
       
      }

        @media screen and (max-width: 991px) {
            .logo {
                margin-left: 0px;
            }

            .container-fluid{
          max-width: 95%;
        }

            .image {
                width: 300px;
                height: 220px;
            }

            .border-line {
                border-right: none;
            }

            .card2 {
                border-top: 1px solid #EEEEEE !important;
                margin: 0px 15px;
            }
        }

    </style>
</head>
    <body>

        
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
    
    <div class="topheader mb-4">
        
          <div class="container-fluid  px-md-5 px-lg-1 px-xl-5 mx-auto" >
                <div class="row">
                  <div class="col-lg-12 py-3 text-white">
                      Ekinerja Puskesmas Cilincing
                  </div>
                </div>
            </div>
        </div>


    <div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 mt-4 mx-auto" >
        
        <div class="card card0 border-0">
            <div class="row d-flex">
                <div class="col-lg-8">
                    <div class="card1 pb-5">
                        <div class="row">
                        
                        </div>
                        <div class="row p-3 mt-4 mb-5 border-line">

                           <div class="col-md-8"></div>
                           <div class="col-md-4"> <strong><?php echo $hari; ?>, <?php echo $tanggal_hari_ini; ?></strong> </div>

                           <div class="p-4 text-center">
                            <img src="<?php echo base_url();?>assets/static/illustrations/undraw_medicine_b1ol.svg" alt="" width="40%">
                           </div>
                          
  
                        
                           <div class="px-4 text-left">
                              <ol>
                                  <li> Proses input aktivitas akan di tutup tanggal 5 pukul 23:59 bulan Berikutnya</li>
                                  <li> Batas akhir validasi Kinerja oleh Kepala Satuan Pelaksana adalah dari tanggal 6 sampai tanggal 10 di setiap bulannya.</li>
                                  <li> Selalu periksa capaian kinerja dan absensi setiap bulannya</li>
                                  <li> Apabila anda tdk menyelesaikan input kinerja akan berpengaruh kepada tunjangan kinerja yang diterima</li>
                              </ol>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card2 card border-0 px-2 py-5">
                       
                      <img class="logo" src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>" alt="">


                        <div class="row mt-4 mb-4">
                          <div class="text-dark">
                            <h5>Login Form</h5>
                            <small>Silahkan Masuk Untuk Memulai Aplikasi</small>  
                          </div>
                    
                            <div class="col-md-12 p-0">

                            <hr>
                                  <?php
                                    $errorNIP =  form_error('idpegawai');

                                    $msg = $this->session->flashdata('msg_login');
                                    // if($errorNIP !=''){
                                    //   echo '<div class="alert alert-danger">'.$errorNIP .'</div>';
                                    // }

                                    echo $msg;

                                  ?> 

                                  
                          </div>

                        </div>
                        
                     
                        <form action="<?php echo EKIN; ?>Login/do_login" method="post" name="form-login">
                          <div class="row">
                              <label class="mb-1"><h6 class="mb-0 text-sm">NIP/NRK</h6></label>
                              <input class="mb-4"  type="text" required name="idpegawai" placeholder="masukan NIP / NRK anda" autocomplete="off" class="form-control   <?= form_error('idpegawai') ? 'is-invalid' : '' ?>">
                               
                            </div>
                          <div class="row">
                              <label class="mb-1"><h6 class="mb-0 text-sm">Password</h6></label>
                              <input type="password" name="password" placeholder="Enter password">
                          </div>
                          <div class="row  mb-4">
                              <div class="custom-control custom-checkbox custom-control-inline">
                                  <input id="chk1" type="checkbox" name="chk" class="custom-control-input"> 
                                  <label for="chk1" class="custom-control-label text-sm">Remember me</label>
                              </div>
                              <a href="#" class="ml-auto mb-0 text-sm">Forgot Password?</a>
                          </div>
                          <div class="row mb-3">
                              <button type="submit" class="btn btn-custom text-center w-100 rounded-2">Login</button>
                          </div>
                        <div class="row mb-4 px-3">
                            <small class="font-weight-bold">Don't have an account? <a class="text-danger ">Register</a></small>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
    </div>

    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </body>
</html>