<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .datepicker {
      z-index: 1999;
    }

    .table-medium td {
      padding: 8px;
      color: #666;
    }

    .loading {
      width: 100%;
      height: 300px;
      margin: 0 auto;
      text-align: center;
      background: rgba(255, 255, 255, 0.8);
      position: fixed;
      z-index: 999;
      font-size: 20px;
      color: #134fc4;

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
                  <h4 class="fw-semibold mb-8">My Absensi</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">My Absensi</li>
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

          $nama_user =  $this->session->userdata('nama');
          $nip_user =  $this->session->userdata('nip');
          $id_pegawai =  $this->session->userdata('id_pegawai');
          $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);
          $message = $this->session->flashdata('message');

          $bulan = $this->uri->segment(3);

          $tahun =  $this->uri->segment(4);



          $periode = $tahun . '-' . $bulan;
          $periode = date('Y-m', strtotime($periode));
          $lastDate = date('t', strtotime($periode)) + 1;
          $nip = $this->session->userdata('nip');
          $id_pegawai = $this->session->userdata('id_pegawai');

          $jns_jam_kerja = $detail_pegawai[0]->jns_jam_kerja;
          $id_puskesmas = $detail_pegawai[0]->id_puskesmas;
          $nip = $detail_pegawai[0]->nip;
          $nama = $detail_pegawai[0]->nama;
          $pin = $detail_pegawai[0]->id_mesin; // user id yg didaftarkan di mesin absensi

          $photo = $this->Pegawai_model->getPhotoPegawai($nip);


          if ($photo == '') {
            $photo = 'avatar.png';
          }


          $nama_bulan = getBulan($bulan);
          ?>




          <div class="row">
            <div class="d-flex align-items-center gap-4 mb-4">
              <div class="position-relative">
                <div class="rounded-circle">
                  <img src="<?php echo base_url(); ?>uploads/photo_profile/<?php echo $photo; ?>" class="rounded-circle m-1" alt="user1" width="60">
                </div>
              </div>
              <div>
                <h3 class="fw-semibold"><span class="text-dark"><?php echo  $nama; ?></span>
                </h3>
                <span>Periode - <strong><?php echo $nama_bulan; ?> <?php echo $tahun; ?> </strong></span>
              </div>
            </div>

            <?php echo $message; ?>

            <div class="loading d-none">
              <img src="<?php echo base_url(); ?>assets/images/loading_baru.gif" alt="user1" width="100">
              updating data absensi....
            </div>


            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">

                  <a href="<?php echo base_url(); ?>absensi/update_absensi/<?php echo $bulan . '/' . $tahun . '/' . $pin . '/' . $id_puskesmas; ?>" class="btn btn-info sinkron_absen float-end me-2">
                    <i class="ti ti-refresh"></i> Update Absensi </a>


                  <div class="clearfix"></div>

                  <div class="table-responsive mt-4">
                    <table class="table table-bordered table-medium">
                      <thead>
                        <tr>
                          <th width="50" rowspan="2">Tanggal</th>
                          <th width="100" rowspan="2">Hari</th>
                          <th width="100" rowspan="2">Shift</th>
                          <th width="160" colspan="2">Jam Kerja</th>
                          <th width="160" colspan="2">Jam Absen</th>

                          <th width="100" rowspan="2">Telat</th>
                          <th width="100" rowspan="2">P Awal</th>
                          <th rowspan="2">Keterangan</th>

                        </tr>

                        <tr>
                          <th width="100"> Masuk</th>
                          <th width="100"> Pulang</th>
                          <th width="100"> Masuk</th>
                          <th width="100"> Pulang</th>
                        </tr>
                      </thead>


                      <tbody>

                        <?php
                        $totalTelat = 0;
                        $totalPawal = 0;

                        $totalIzin = 0;
                        $totalSakit = 0;
                        $totalCuti = 0;


                        for ($t = 1; $t < $lastDate; $t++) {
                          $tanggal = $periode . '-' . $t;
                          $formatDate = date('Y-m-d', strtotime($tanggal));
                          $day = date('l', strtotime($tanggal));
                          $hari = getNamahari($tanggal);

                          $absensiHarian  = $this->Presensi_model->getDataAbsensi($pin, $formatDate);
                          if (!empty($absensiHarian)) {
                            $kodeShift         = $absensiHarian[0]->shift;
                            $jamMasukKerja     = $absensiHarian[0]->jam_masuk;
                            $jamKeluarKerja    = $absensiHarian[0]->jam_pulang;

                            $absenMasuk         = $absensiHarian[0]->masuk;
                            $absenPulang        = $absensiHarian[0]->pulang;
                            $keterangan_absen   = $absensiHarian[0]->keterangan;

                            $telat         = $absensiHarian[0]->telat;
                            $p_awal         = $absensiHarian[0]->p_awal;
                          } else {
                            $kodeShift         = '';
                            $jamMasukKerja      = '';
                            $jamKeluarKerja    = '';

                            $absenMasuk        = '';
                            $absenPulang        = '';
                            $keterangan_absen   = '';

                            $telat         = 0;
                            $p_awal         = 0;
                          }

                          $hariLibur = $this->Presensi_model->cekHariLibur($tanggal);

                          if (!empty($hariLibur)) {


                            $kodeShift         = '';
                            $jamMasukKerja     = '-';
                            $jamKeluarKerja    = '-';

                            $absenMasuk         = '<span class="text-danger bg-danger-subtle fs-2">LIBUR NASIONAL</span>';
                            $absenPulang        =  '<span class="text-danger bg-danger-subtle fs-2">LIBUR NASIONAL</span>';
                            $keterangan_absen   = $hariLibur[0]->keterangan;


                            $telat         = 0;
                            $p_awal         = 0;
                          }



                          if ($kodeShift == 'OFF') {
                            $jamMasukKerja  = '';
                            $jamKeluarKerja  = '';
                            $bg_btn = 'btn btn-outline-danger';
                          } else {
                            $bg_btn = 'btn btn-outline-success';
                          }




                          $totalTelat = $totalTelat + $telat;
                          $totalPawal = $totalPawal + $p_awal;


                          echo '  <tr>
                                                                            <td class="text-center">' . $t . '</td>
                                                                            <td class="text-center">' . $hari . '</td>
                                                                            <td id="tr_' . $t . '" class="text-center">
                                                                            <button type="button" class="btn btn-sm  fs-1 ' . $bg_btn . ' input-absen" value="' . $tanggal . '" data-bs-toggle="modal" data-bs-target="#modal-input">' . $kodeShift . '</button> </td>
                                                                            <td class="text-darkblue text-center">' . $jamMasukKerja  . '</td>
                                                                            <td class="text-darkblue  text-center">' . $jamKeluarKerja . '</td>
                                                                            <td class="text-center">' . $absenMasuk . '</td>
                                                                            <td class="text-center">' . $absenPulang . '</td>
                                                                            <td class="text-center">' . $telat . '</td>
                                                                            <td class="text-center">' . $p_awal . '</td>
                                                                            <td style="text-align:left">' . $keterangan_absen . '</td>
                                                                            
                                                                            
                                                                </tr>';
                        }


                        ?>

                        <tr>
                          <td colspan="7"></td>
                          <td><?php echo $totalTelat; ?></td>
                          <td><?php echo $totalPawal; ?></td>
                          <td></td>

                        </tr>



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
        <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>


</body>


<script>
  $(document).ready(function() {

    var msg = '<?php echo $message; ?>';
    //alert(msg);

    if (msg != '') {
      toastr.success(msg, "Update Absensi Berhasil");
    }


    $(".sinkron_absen").click(function() {

      $(".loading").removeClass("d-none");
    });




  });
  // Success Type
  //  $("#ts-success").on("click", function () {
  //     toastr.success("Have fun storming the castle!", "Miracle Max Says");
  // });
</script>

</html>