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
                                    <h4 class="fw-semibold mb-8">Data Cuti Pegawai</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Data Cuti Pegawai</li>
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


                    $jns_pegawai = $this->uri->segment(4);
                    $message = $this->session->flashdata('message');



                    echo $message



                    ?>


                    <div class="row">

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold mb-4">Data Cuti Pegawai </h5>

                                    <div class="clearfix"></div>


                                    <div class="table-responsive mt-4">
                                        <table class="table  table-hover table-bordered" id="data-table">
                                            <thead>
                                                <tr>

                                                    <th class="w-1">No.</th>

                                                    <th>NIP</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Puskesmas</th>
                                                    <th>Sisa Cuti 2024 </th>
                                                    <th>Sisa Cuti 2025 </th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $no = 1;
                                                foreach ($pegawai as $peg) {

                                                    $id_pegawai = $peg->id_pegawai;
                                                    $nip = $peg->nip;
                                                    $id_jabatan = $peg->id_jabatan;
                                                    $tmt = $peg->tgl_masuk;
                                                    $id_puskesmas = $peg->id_puskesmas;

                                                    $photo  = $this->Pegawai_model->getPhotoPegawai($nip);

                                                    $sisaTahunLalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
                                                    $sisaTahunIni = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');
                                                    echo ' <tr>
                                                                  <td>' . $no . ' </td>
                                                                 
                                                                  <td class="text-center"> ' . $peg->nip . '</td>
                                                                  <td><a href="' . base_url() . 'admin/pegawai/detail_pegawai/' . $id_pegawai . '">' . $peg->nama . '</a></td>
                                                                  <td>' . $peg->jabatan . ' </td>
                                                                  <td>' . $peg->puskesmas . ' </td>
                                                  
                                                                  <td class="text-center"> 
                                                                  ' . $sisaTahunLalu . '
                                                                  </td>
                                                                  
                                                                  <td class="text-center"> 
                                                                  ' . $sisaTahunIni . '
                                                                  </td>
                                                              
                                                                  
                                                              </tr>';

                                                    $no += 1;
                                                }


                                                ?>






                                            </tbody>
                                        </table>
                                    </div>
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

                <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

</body>




<script>
    $('#data-table').dataTable({
        lengthMenu: [
            [20, -1],
            ['20', '50', '100', 'Show all']
        ]
    });
</script>

</html>