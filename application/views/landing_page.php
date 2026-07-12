<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- basic -->
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- mobile metas -->
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="viewport" content="initial-scale=1, maximum-scale=1">
      <!-- site metas -->
      <title>SIPUSPA</title>
      <meta name="keywords" content="">
      <meta name="description" content="">
      <meta name="author" content="">
      <!-- bootstrap css -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/bootstrap.min.css">
      <!-- style css -->
      <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/style.css">
      <!-- Responsive-->
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/responsive.css">
      <!-- fevicon -->
      <link rel="icon" href="images/fevicon.png" type="image/gif" />
      <!-- Scrollbar Custom CSS -->
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.mCustomScrollbar.min.css">
      <!-- Tweaks for older IEs-->
      <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css">
      <!-- fonts -->
      <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
      <!-- owl stylesheets --> 
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/owl.carousel.min.css">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.css" media="screen">

      <style>
      body, html {
            height: 100%;
            background: rgb(150,144,240);
background: linear-gradient(90deg, rgba(150,144,240,1) 0%, rgba(84,166,237,1) 35%, rgba(0,212,255,1) 100%);
            }
         .brand{
            font-size:40px;
            font-weight:bold;
            color:#EEE;
            line-height:20px;
         }

         .caption{
            color:#FFF;
            font-size:20px;
         }
         .caption span{
            color:#e8ff02;
            font-size:30px;
         }

         .title{
            font-size:20px;
         }
         .rounded-full{
            border-radius:10px;
         }

         .details{
            color:#333;
         }
         .btn-register{
            display:block;
            padding:10px;
            text-align:center;
            background:#2f62a4;
            color:#FFF;
            border-radius:5px;
            margin-top:30px;
            width:100%;
         }
         .btn-register:hover{
            background:#4c7acf;
         }
      </style>
   </head>
   <body>


      <!--header section start -->
            <div class="header_section">
               
               <!--banner section start -->
               <div class="banner_section layout_padding">
                  <div class="container">
                        <div class="page page-center">
                              <div class="container container-tight py-4">
                                 <div class="text-center">
                                    <a href="#" class="brand">
                                       SIPUSPA 
                                 
                                    </a>
                        
                                    <div class="caption"> <span>S</span>kr<span>I</span>ning 
                                    Kesehatan <span>P</span>engemudi B<span>US P</span>uskesm<span>A</span>s</div>
                           
                                 </div>
                              </div>
                        </div>

                        <center>
                              <div class="col-md-5 bg-white  page-center p-4 rounded-full">
                                   <div class="title">Registrasi Pengemudi Bus</div>



                                    <form action="<?php echo base_url();?>home/create_session" method="post">
                                       
                                       <div class="flex-container">
                                          <div class="flex-item-left">
                                             <div class="input-box">
                                                <span class="details">Nama Lengkap <span class="text-danger">*</span></span>
                                                <input type="text" placeholder="ketik nama lengkap anda" name="nama_lengkap" class="<?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>" value="<?php echo set_value('nama_lengkap'); ?>" >
                                                <span class="error-msg"> <?php echo form_error('nama_lengkap'); ?> </span>
                                             </div>

                                                
                                             <div class="input-box">
                                                <span class="details">NIK / NO KTP <span class="text-danger">*</span></span>
                                                <input type="text" name="no_ktp" placeholder="ketik no KTP anda"  onkeypress="return onlyNumberKey(event)"  class="charcounter-control <?= form_error('no_ktp') ? 'is-invalid' : '' ?>" value="<?php echo set_value('no_ktp'); ?>"   maxlength='16'  warnlength='14' >
                                                <span class="error-msg"><?php echo form_error('no_ktp'); ?> </span>
                                             </div>

                                             <div class="input-box">
                                                <span class="details">Tanggal Lahir  <span class="text-danger">*</span></span>
                                                <input type="text" placeholder="tgl/bln/thn" name="tgl_lahir" class="js-date <?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>" maxlength="10" value="<?php echo set_value('tgl_lahir'); ?>">
                                                <span class="error-msg"><?php echo form_error('tgl_lahir'); ?> </span>
                                             </div>


                                             <button type="submit" class="btn-register">Registrasi</button>
                                           </div>
                                       </div>


                                     </form>
                              </div>
                        </center>
                        
                  


                  </div>
               </div>
               <!--banner section end -->
            </div>



      <!-- Javascript files-->
      <script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
      <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
      <script src="<?php echo base_url();?>assets/js/bootstrap.bundle.min.js"></script>
      <script src="<?php echo base_url();?>assets/js/jquery-3.0.0.min.js"></script>
      <script src="<?php echo base_url();?>assets/js/plugin.js"></script>
      <!-- sidebar -->
      <script src="<?php echo base_url();?>assets/js/jquery.mCustomScrollbar.concat.min.js"></script>
      <script src="<?php echo base_url();?>assets/js/custom.js"></script>
      <!-- javascript --> 
      <script src="js/owl.carousel.js"></script>
      <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
   </body>
</html>