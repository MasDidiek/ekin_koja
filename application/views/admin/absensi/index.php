<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

    <style>
        .form-periode {
            width: 20em;
            height: 13em;
            background: #FFF;
            position: absolute;
            top: 9em;
            left: 2em;
            border: 1px solid #DDD;
            border-radius: 3px;
            padding: 0;
            display: none;
        }

        .header-periode {
            background-color: #FFF;
            color: #666;
            height: 50px;
            display: block;
            width: 100%;
            padding: 5px;
        }



        .body-periode {
            background-color: #FFF;

            height: auto;
            display: block;
        }

        .btn-prev,
        .btn-next {
            width: 20%;
            display: inline-block;
            padding: 6px 10px;
            border: none;
            font-size: 14px;
        }



        .tahun_periode {
            border: none;
            width: 57%;
            display: inline-block;
            padding: 6px 10px;
            font-size: 14px;
            cursor: none;
            text-align: center;
        }

        .btn-bulan {
            display: inline-block;
            width: 25%;
            padding: 8px 5px;
            border: none;
            background-color: #FFF;
            color: #666;
            border-radius: 3px;
        }

        .btn-bulan:hover {
            background-color: #2792e7;
            color: #FFF;
        }

        .bln-active {
            background-color: #2792e7;
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
                                    <h4 class="fw-semibold mb-8">Data Pegawai</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Data Pegawai</li>
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


                    $id = $this->uri->segment(4);
                    $message = $this->session->flashdata('message');

                    $periode_bulan = $this->session->userdata('periode_bulan');
                    $periode_tahun = $this->session->userdata('periode_tahun');

                    if ($periode_bulan == '') {
                        $periode_bulan = date('m');
                        $periode_tahun = date('Y');
                    }


                    //  echo $periode_bulan;
                    $periode = $periode_tahun . '-' . $periode_bulan;
                    $periode = date('Y-m', strtotime($periode));

                    ?>


                    <div class="row">

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">

                                    <?php

                                    $id_pjlp = $data_pjlp[0]->id_pjlp;
                                    $nama = $data_pjlp[0]->nama;
                                    // $jabatan = $data_pjlp[0]->jabatan;
                                    // $lokasi_kerja = $data_pjlp[0]->lokasi_kerja;

                                    $jabatan =  '';
                                    $lokasi_kerja = '';

                                    echo '<h3>' . $nama . '</h3>
                              <h4>' . $id_pjlp . '</h4>
                              <h6>Petugas ' . $jabatan . ' &nbsp;&nbsp; @  Puskesmas ' . $lokasi_kerja . '  </h6>';
                                    ?>


                                    <div class="clearfix"></div>
                                    <Br><Br>
                                    <form action="<?php echo base_url(); ?>admin/absensi_pjlp/change_periode/<?php echo $id_pjlp; ?>" method="post">

                                        <select name="periode_bulan" id="bulan" class="form-control float-start me-2" style="width:120px">
                                            <?php
                                            for ($i = 1; $i < 13; $i++) {
                                                if ($periode_bulan == $i) {
                                                    echo ' <option value="' . $i . '" selected>' . getBulan($i) . '</option>';
                                                } else {
                                                    echo ' <option value="' . $i . '">' . getBulan($i) . '</option>';
                                                }
                                            }
                                            ?>

                                        </select>
                                        <input type="number" name="periode_tahun" class="form-control me-2 float-start" style="width:120px" id="tahun" value="<?php echo $periode_tahun; ?>">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </form>

                                    <Br>

                                    <a href="<?php echo base_url(); ?>admin/absensi_pjlp/print_data/<?php echo $id_pjlp; ?>" target="_blank" class="btn btn-info">
                                        Print
                                    </a>

                                    <div class="table-responsive mt-4">

                                        <table class="table table-bordered text-center">
                                            <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th>Hari</th>
                                                    <th>Jam Absen Masuk</th>
                                                    <th>Jam Absen Pulang</th>

                                                </tr>
                                            </thead>


                                            <?php


                                            // $pin = substr($id_pjlp, -5);
                                            $pin =   $id_pjlp;
                                            //$dataAbsensi = $this->Presensi_model->getAbsenHarian($pin, $tanggal);


                                            for ($i = 0; $i < 31; $i++) {
                                                $tgl = $i + 1;

                                                $tanggal = $periode . '-' . $tgl;
                                                $tanggal = format_db($tanggal);

                                                $day = date('l', strtotime($tanggal));
                                                $hari = getNamahari($tanggal);

                                                $dataAbsensi = $this->Presensi_model->getAbsenHarian($pin, $tanggal);
                                                if (!empty($dataAbsensi)) {
                                                    #print_array($dataAbsensi);
                                                    $absenHarian = '';
                                                    for ($a = 0; $a < count($dataAbsensi); $a++) {

                                                        $date = $dataAbsensi[$a]->tanggal;
                                                        $status  = $dataAbsensi[$a]->status;

                                                        if ($status == 0) {
                                                            $jns_absen = '(Masuk)';
                                                        } else {
                                                            $jns_absen = '(Pulang)';
                                                        }


                                                        $jamAbsen = date('H:i:s', strtotime($date));
                                                        $absenHarian .= $jamAbsen . ' ' . $jns_absen . '<br>';
                                                    }
                                                } else {
                                                    $date = '-';
                                                    $status  = '';
                                                    $absenHarian = '';
                                                }

                                                echo '<tr>
                                                          <td>' . format_view($tanggal) . '</td>
                                                          <td>' . $hari . '</td>
                                                          <td>' . $absenHarian . '</td>
                                                          
                                                         
                                                        </tr>';
                                                //print_array($dataAbsensi);

                                            }

                                            // print_array($dataAbsensi);
                                            ?>

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

                <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

                <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
                <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


</body>



</html>