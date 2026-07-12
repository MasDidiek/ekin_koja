<!DOCTYPE html>
<html lang="en-US" dir="ltr">
    <?php $this->load->view('master/header');?>

  <body>

    <!-- ===============================================-->
    <!--    Main Content-->
    <!-- ===============================================-->
    <main class="main" id="top">
      <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3 d-block" data-navbar-on-scroll="data-navbar-on-scroll">
        <div class="container"><a class="navbar-brand" href="<?php echo base_url();?>home/index"> 
              <img class="me-3 d-inline-block" src="<?php echo base_url();?>assets/img/logo_cilincing.jpg" alt="" width="80" />
          </a>
          <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
          <div class="collapse navbar-collapse border-top border-lg-0 mt-4 mt-lg-0" id="navbarSupportedContent">
         <ul class="navbar-nav me-auto pt-2 pt-lg-0 font-base">
              <li class="nav-item px-2"><a class="nav-link fw-bold active" aria-current="page" href="<?php echo base_url();?>home/index">Beranda</a></li>
              <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link fw-bold" href="<?php echo base_url();?>about_us/index">Tentang Kami</a></li>
              <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link fw-bold" href="<?php echo base_url();?>service/index">Layanan Kami</a></li>
              <li class="nav-item px-2" data-anchor="data-anchor"><a class="nav-link fw-bold" href="<?php echo base_url();?>contact_us/index">Hubungi Kami</a></li>
            </ul>
           
          </div>
        </div>
      </nav>
      <section id="home">
        <div class="container">
          <div class="row align-items-center g-2">
            <div class="col-md-5 col-lg-12 text-center">
              <!--<img class="pt-7 pt-md-0 w-100" src="<?php //echo base_url();?>assets/caten/images/success_reg.gif" alt="hero-header" />-->
            </div>
            <div class="col-md-7 col-lg-12 py-6 text-md-start text-center">
             
              <h1 class="fw-bold fs-4 fs-lg-6 fs-xxl-7 text-success"> Pendaftaran Calon Pengantin berhasil simpan!!</h1>
              <p class="mb-5 fs-1 fw-medium">
              Terima kasih telah mengisi formulir calon pengantin, 
              mohon cek secara berkala pada bagian home dibagian “<strong>Validasi data calon pengantin</strong>”
              </p>
            <a class="btn hover-top btn-collab" href="<?php echo base_url();?>"><i class="fas fa-home me-2"></i> Kembali ke halaman Beranda</a>
             
            </div>
          </div>
        </div>
      </section>


    



    </main>
    <!-- ===============================================-->
    <!--    End of Main Content-->
    <!-- ===============================================-->




    <!-- ===============================================-->
    <!--    JavaScripts-->
    <!-- ===============================================-->
    <script src="<?php echo base_url();?>assets/js/popper.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/is.min.js"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=window.scroll"></script>
    <script src="<?php echo base_url();?>assets/js/all.min.js"></script>
    <script src="<?php echo base_url();?>assets/js/theme.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400;500;600;700&amp;family=Montserrat:wght@200;300&amp;display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@200;300;400;500;600;700&amp;family=Montserrat:wght@200;300;400;500;600;700&amp;display=swap" rel="stylesheet">
  </body>

</html>