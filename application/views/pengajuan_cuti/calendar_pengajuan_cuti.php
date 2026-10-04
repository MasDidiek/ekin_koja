<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        .datepicker {
            z-index: 1999;
        }


        .status_cuti {
            padding: 3px 5px;
            font-size: 11px;
            border-radius: 3px;
            color: #FFF;
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
                                    <h4 class="fw-semibold mb-8">Data Pengajuan Cuti</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Data Pengajuan Cuti</li>
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

                    $arrayJnsCuti = array('Semua', 'Tahunan', 'Bersalin', 'Alasan Penting', 'Sakit', 'Besar');
                    $jns_cuti = $this->session->userdata('jns_cuti');
                    $bln_cuti = $this->session->userdata('bln_cuti');

                    //print_array($list_cuti);

                    ?>


                    <div class="row">

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold mb-4">Data Pengajuan Cuti</h5>


                                    <?php
                                    $idjns  = 0;
                                    for ($i = 1; $i < count($arrayJnsCuti); $i++) {

                                        $jenis_cuti = $arrayJnsCuti[$i];

                                        if ($jns_cuti == $i) {
                                            $class_btn = ' btn-info';
                                        } else {
                                            $class_btn = ' btn-white';
                                        }
                                        echo '<a href="' . base_url() . 'admin/pengajuan_cuti/pengajuan_cuti_by_jns/' . $i . '" class="btn border ' . $class_btn . ' me-1"> Cuti ' . $jenis_cuti . '</a>';


                                        $idjns  = $i + 1;
                                    }


                                    ?>


                                    <div class="clearfix"></div>


                                    <?php
                                    for ($b = 1; $b < 13; $b++) {

                                        if ($bln_cuti == $b) {
                                            $class_btn2 = ' btn-info';
                                        } else {
                                            $class_btn2 = ' btn-light';
                                        }

                                        $bulan_name = getNamaBulan($b);
                                        echo ' <a href="' . base_url() . 'admin/pengajuan_cuti/set_session_bulan/' . $b . '" class="btn btn-sm ' . $class_btn2 . ' mt-1">' . $bulan_name . '</a>';
                                    }

                                    ?>



                                    <div class="mt-3">

                                        <div class="fs-3">Num Rows : <strong><?php echo count($list_cuti); ?> Rows </strong> </div>

                                        <div class="border p-3 mt-2">

                                            <?php

                                            $no = 1;
                                            foreach ($list_cuti as $cuti) {
                                                $id         = $cuti->id;

                                                $tgl_dari      =  $cuti->tgl_dari;
                                                $tgl_sampai    =  $cuti->tgl_sampai;
                                                $hari_cuti     =  $cuti->hari_cuti;
                                                $status        =  $cuti->status;


                                                if ($status == 'APPROVE') {
                                                    $flag_cuti = '<span class="status_cuti  bg-success">  Disetujui</span>';
                                                } else if ($status == 'CANCEL') {
                                                    $flag_cuti = '<span class="status_cuti   bg-light text-muted">Dibatalkan</span>';
                                                } else if ($status == 'REJECT') {
                                                    $flag_cuti = '<span class="status_cuti   bg-warning">Ditolak</span>';
                                                } else {
                                                    $flag_cuti = '<span class="status_cuti   bg-light text-warning">Pending</span>';
                                                }

                                                $keterangan_status = '';
                                                if ($status == 'PEND0') {
                                                    $keterangan_status = 'Menunggu Persetujuan Pengganti';
                                                } else if ($status == 'PEND1') {
                                                    $keterangan_status = 'Menunggu Persetujuan Kapustu/Kasatpel';
                                                } else if ($status == 'PEND2') {
                                                    $keterangan_status = 'Menunggu Persetujuan Ka.TU';
                                                }

                                                echo '    
                                               <div class="row">
                                                    <div class="col-md-6">
                                                  
                                                        <strong>  <a href="' . base_url() . 'admin/pengajuan_cuti/detail/' . $id . '">
                                                         ' . $no . ' .  ' . $cuti->nama . ' </a> </strong><br>
                                                          <span class="text-muted fs-2">- &nbsp; &nbsp;  &nbsp; ' . word_limiter($cuti->alasan_cuti, 4) . ' </span>
                                                     
                                                        </div>
                                                    <div class="col-md-6 text-end">
                                                        <span class="text-muted fs-2"> Tgl Cuti </span> : &nbsp; <strong>' . format_full($tgl_dari) . ' </strong>&nbsp; &nbsp; &nbsp;
                                                        <span class="text-muted fs-2"> s/d </span> &nbsp; <strong> ' . format_full($tgl_sampai) . '</strong> &nbsp; &nbsp; ( ' . $hari_cuti . ' hari)

                                                         &nbsp; &nbsp; - &nbsp; &nbsp;   &nbsp; &nbsp; ' . $flag_cuti . ' <br>
                                                         <span class="text-info fs-2">  ' . $keterangan_status . '</span>
                                                    </div>
                                                </div>


                                                <hr>';

                                                $no += 1;
                                            }

                                            ?>



                                        </div>
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


</body>


</html>