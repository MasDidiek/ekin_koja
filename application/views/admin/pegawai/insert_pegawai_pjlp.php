<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        .datepicker {
            z-index: 1999;
        }
    </style>
</head>

<body>
    <!-- <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome to Modernize</h5>
        <h6 class="text-white fs-2 mb-0">Easy to costomize the Template!!!</h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div> -->
    <!-- Preloader -->

    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <aside class="left-sidebar with-vertical">
            <div><!-- ---------------------------------- -->
                <!-- Start Vertical Layout Sidebar -->
                <!-- ---------------------------------- -->


                <?php $this->load->view('layout/section/sidebar'); ?>

                <!-- 
            <div  class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
              <div class="hstack gap-3">
                <div class="john-img">
                  <img
                    src="../assets/images/profile/user-1.jpg"
                    class="rounded-circle"
                    width="40"
                    height="40"
                    alt=""
                  />
                </div>
                <div class="john-title">
                  <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                  <span class="fs-2">Designer</span>
                </div>
                <button
                  class="border-0 bg-transparent text-primary ms-auto"
                  tabindex="0"
                  type="button"
                  aria-label="logout"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  data-bs-title="logout"
                >
                  <i class="ti ti-power fs-6"></i>
                </button>
              </div>
            </div>

            <!-- ---------------------------------- -->
                <!-- Start Vertical Layout Sidebar -->
                <!-- ---------------------------------- -
            </div> -->
        </aside>

        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <?php $this->load->view('layout/section/header'); ?>
            <!--  Header End -->


            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Input Data Pegawai</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-item"> <a class="text-muted text-decoration-none" href="../main/index.html">Data Pegawai</a></li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-acive">Input Data Pegawai</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5">

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <?php

                    $message = $this->session->flashdata('message');
                    echo $message
                    ?>


                    <div class="row">

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">


                                    <form method="post" action="<?php echo base_url(); ?>admin/pegawai/insert_pegawai/pjlp">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="mb-4">
                                                            <label for="exampleInputtext" class="form-label fw-semibold">Nama Lengkap</label>
                                                            <input type="text" name="nama" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-4">
                                                            <label for="exampleInputtext" class="form-label fw-semibold">ID PJLP</label>
                                                            <input type="text" name="id_pjlp" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="mb-4">
                                                            <label for="exampleInputtext" class="form-label fw-semibold">ID Mesin</label>
                                                            <input type="text" name="id_mesin" required class="form-control">
                                                            <label for="floatingEmptyPlaintextInput">ID pegawai yang digunakan di mesin absensi</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-7">
                                                        <div class="mb-4">
                                                            <label for="exampleInputtext" class="form-label fw-semibold">Jabatan</label>

                                                            <select class="form-select" name="jabatan" aria-label="Default select example">
                                                                <option value="keamanan">Petugas Keamanan (Security)</option>
                                                                <option value="kebersihan">Petugas Kebersihan (Cleaning Service) </option>
                                                                <option value="driver">Driver</option>
                                                            </select>

                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="mb-4">
                                                    <label for="exampleInputPassword1" class="form-label fw-semibold">Lokasi Kerja</label>
                                                    <select class="form-select" name="lokasi_kerja" aria-label="Default select example">
                                                        <?php
                                                        foreach ($list_puskesmas as $puskesmas) {

                                                            $id_puskesmas = $puskesmas->id_puskesmas;
                                                            $nama_puskesmas = $puskesmas->nama;

                                                            if ($id_puskesmas == $pegawai[0]->id_puskesmas) {
                                                                echo ' <option value="' . $nama_puskesmas . '" selected>' . $nama_puskesmas . '</option>';
                                                            } else {
                                                                echo ' <option value="' . $nama_puskesmas . '">' . $nama_puskesmas . '</option>';
                                                            }
                                                        }

                                                        ?>

                                                    </select>
                                                </div>

                                            </div><!--col-md-6-->


                                        </div><!--row-->
                                        <button type="submit" class="btn btn-success">Simpan </button>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>


                    <script>
                        function handleColorTheme(e) {
                            $("html").attr("data-color-theme", e);
                            $(e).prop("checked", !0);
                        }
                    </script>

                    <?php $this->load->view('layout/section/theme-setting.php'); ?>

                    <?php $this->load->view('master/request-cuti.php'); ?>

                </div>
                <div class="dark-transparent sidebartoggler"></div>
                <!-- Import Js Files -->

                <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
                <script src="../assets/js/app.init.js"></script>
                <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
                <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

                <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

                <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>


                <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

</body>


=

</html>