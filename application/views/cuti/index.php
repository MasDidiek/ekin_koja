<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .datepicker {
      z-index: 1999;
    }

    
        .badge{
            font-size: 12px;
            padding: 2px 10px;
            border-radius: 8px;
            color: #FFF8F8;
        }

        .bg-success{
            background-color: #51e04c;

        }
          .bg-grey{
            background-color: #d1e2e9;
            color: #3e74d8;

        }
           .bg-dark-grey{
            background-color: #76797a;
            color: #f4f5f7;

        }
  </style>
</head>

<body>


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

      <?php



      $tgl_masuk = $pegawai[0]->tgl_masuk;
      $id_pegawai = $pegawai[0]->id_pegawai;
      $nama_pegawai  = $pegawai[0]->nama;
      $message_update = $this->session->flashdata('message_update');
      $message = $this->session->flashdata('message');

      $tgl_masuk = $pegawai[0]->tgl_masuk;
      $nip = $pegawai[0]->nip;
      $nama_pegawai = $pegawai[0]->nama;
      $id_pegawai = $pegawai[0]->id_pegawai;
      $sisaCuber = 0;


      // $sisaTahunLalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
      // $sisaTahunIni = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');
      // $sisaCuber = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 3, 'DESC');
      // $sisaCutiAll = $sisaTahunLalu + $sisaTahunIni + $sisaCuber;

      //print_array($rekap_hak_cuti);

      // [2026] => Array
      //   (
      //       [hak] => 12
      //       [terpakai] => 0
      //       [reserved] => 0
      //       [sisa] => 12
      //   )

      $tahun = $this->uri->segment(3) ?: date('Y');

      $thn_cuti =  $tahun;
      $arrayTahun = [2024, 2025, 2026];
      if (isset($tahun) && $tahun != '') {
        $tahunAktif = $tahun;
      } else {
        $tahunAktif = date('Y');
      }

      $cutiThn2025 = $rekap_hak_cuti['2025'];
      $cutiThn2026 = $rekap_hak_cuti['2026'];

      $sisa2025 = 2;
      $sisa2026 = isset($cutiThn2026['sisa']) ? $cutiThn2026['sisa'] : 0;

      $thnini = date('Y');
      $thnLalu = $thnini - 1;

      $sisaCutiAll = $sisa2025 + $sisa2026;

      if($sisa_cuti_bersama){
        $sisaCuber = $sisa_cuti_bersama->hak_total - $sisa_cuti_bersama->hak_terpakai- $sisa_cuti_bersama->hak_reserved;
        $sisaCutiAll += $sisaCuber;
      }


     // print_array($sisa_cuti_bersama);

      ?>
      <div class="body-wrapper">
        <div class="container-fluid mw-100">
          <!--  Row 1 -->
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-12">
                  <h4 class="fw-semibold mb-8">Cuti Saya</h4>
                  <?php echo   $message_update; ?>
                </div>

              </div>
            </div>
          </div>



          <div class="row">
            <div class="col-lg-3 col-md-6">

              <div class="card">
                <div class="card-body">

                  <div class="d-flex flex-row align-items-center">

                    <div class="round-40 text-white d-flex align-items-center justify-content-center text-bg-warning">
                      <i class="ti ti-credit-card fs-6"></i>
                    </div>
                    <div class="ms-3 align-self-center">

                      <h3 class="mb-0 fs-6">
                        <strong><?php echo $sisa2025; ?></strong>
                        <small>hari</small>
                      </h3>
                      <span class="text-muted">Sisa Cuti Tahun <?= $thnLalu; ?></span>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body">


                  <div class="d-flex flex-row align-items-center">
                    <div class="round-40  text-white d-flex align-items-center justify-content-center text-bg-info">
                      <i class="ti ti-users fs-6"></i>
                    </div>
                    <div class="ms-3 align-self-center">
                      <h3 class="mb-0 fs-6">

                        <strong><?php echo $sisa2026; ?></strong>
                        <small>hari</small>
                      </h3>
                      <span class="text-muted">Sisa Cuti Tahun <?= $thnini; ?></span>
                    </div>
                  </div>

                </div>
              </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body">

                  <div class="d-flex flex-row align-items-center">
                    <div class="round-40  text-white d-flex align-items-center justify-content-center text-bg-danger">
                      <i class="ti ti-calendar fs-6"></i>
                    </div>
                    <div class="ms-3 align-self-center">
                      <h3 class="mb-0 fs-6">

                        <strong><?php echo $sisaCuber; ?></strong>
                        <small>hari</small>
                      </h3>
                      <span class="text-muted">Hak Cuti Bersama</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Column -->
            <!-- Column -->
            <div class="col-lg-3 col-md-6">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-row align-items-center">
                    <div class="round-40  text-white d-flex align-items-center justify-content-center text-bg-success">
                      <i class="ti ti-settings fs-6"></i>
                    </div>
                    <div class="ms-3 align-self-center">
                      <h3 class="mb-0 fs-6"><?php echo $sisaCutiAll; ?> &nbsp; <small>hari</small></h3>
                      <span class="text-muted">Total hak Cuti</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Column -->

            <div class="col-md-12">

              <div class="btn-group" role="group">
                <?php foreach ($arrayTahun as $t) : ?>
                  <a href="<?= base_url('cuti/index/' . $t) ?>" class="btn <?= ($t == $tahunAktif) ? 'btn-primary active' : 'btn-outline-primary' ?>">
                    <?= $t ?>
                  </a>
                <?php endforeach; ?>
              </div>
              <br>


              <a href="<?php echo base_url(); ?>cuti/buat_pengajuan_cuti" class="btn btn-info float-end mb-2">Input Pengajuan Cuti</a>
              <div class="clearfix"></div>

              <h4>Riwayat Cuti</h4>
              <div class="clearfix"></div>
              <table border="1" class="table table-md  table-hover"  width="100%">
                    <thead>
                        <tr>
                            <th>Tanggal Pengajuan</th>
                           
                            <th>Jenis Cuti</th>

                            <th>Tgl Mulai </th>
                            <th>Tgl Akhir </th>
                            <th>Lama Cuti (Hari)</th>
                            <th>Alasan Cuti</th>
                            <th>Status Approval</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php

                      //print_array($history);
                    for ($i = 0; $i < count($history); $i++) {

                      //karna format tablenya berubah, maka utk mendeklasarikan kolom juga berbeda tuk tahun sebelum 2026
                      $id_cuti = $history[$i]->id;
                        $jenis_cuti = $history[$i]->jenis_cuti;
                      if ($thn_cuti < 2026) {
                        $tgl_pengajuan = $history[$i]->tgl;
                        $tgl_dari = $history[$i]->tgl_dari;
                        $tgl_sampai = $history[$i]->tgl_sampai;
                        $hari_cuti = $history[$i]->hari_cuti;
                      
                        $status = $history[$i]->status;

                        if ($status == 'PEND0') {
                          $flag_status = '<span class="badge bg-light  text-dark">Pengajuan</span>';
                        } else if ($status == 'PEND1') {
                          $flag_status = '<span class="badge bg-info">Proses</span>';
                        } else if ($status == 'APPROVE') {
                          $flag_status = '<span class="badge bg-success">Disetujui</span>';
                        } else if ($status == 'CANCEL') {
                          $flag_status = '<span class="badge bg-light  text-danger">Dibatalkan</span>';
                        } else {
                          $flag_status = '<span class="badge bg-danger">Ditolak</span>';
                        }
                      } else {
                        $tgl_pengajuan = $history[$i]->tgl_pengajuan;
                        $tgl_dari = $history[$i]->tgl_mulai;
                        $tgl_sampai = $history[$i]->tgl_selesai;
                        $hari_cuti = $history[$i]->lama_cuti;
                        $status = $history[$i]->status_akhir;
                        $jenis_cuti = $history[$i]->jenis_cuti;

                        if ($status == 'draft') {
                          $flag_status = '<span class="badge bg-light  text-dark">Pengajuan</span>';
                        } else if ($status == 'proses') {
                          $flag_status = '<span class="badge bg-info">Proses</span>';
                        } else if ($status == 'disetujui') {
                          $flag_status = '<span class="badge bg-success">Disetujui</span>';
                        } else if ($status == 'dibatalkan') {
                          $flag_status = '<span class="badge bg-light  text-danger">Dibatalkan</span>';
                        } else {
                          $flag_status = '<span class="badge bg-danger">Ditolak</span>';
                        }
                      }


                      echo '
                            <tr onclick="goDetail('.$id_cuti.')" style="cursor:pointer;">
                                <td>' . format_semi($tgl_pengajuan) . '</td>
                                  <td>'.$jenis_cuti.'</td>
                                <td>' . format_semi($tgl_dari) . '</td>
                                <td> ' . format_semi($tgl_sampai) . '</td>
                                <td>' . $hari_cuti . ' hari</td>
                                <td>' . $history[$i]->alasan_cuti . ' </td>
                                <td>' . $flag_status . '</td>
                                
                            </tr>
                            ';
                    }

                    ?>



                  </tbody>
                </table>
              </div>
            </div><!--col-md-12-->


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


  <script>
          function goDetail(id) {
              window.location.href = "<?= base_url('cuti/summary_pengajuan_cuti/') ?>" + id;
          }
  
  $(".cancel_cuti").click(function() {
    var id_cuti = $(this).val();
    $("#id_cuti_cancel").val(id_cuti);

  });



  var nowTemp = new Date();
  var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

  var checkin = $('#dpd1').datepicker({
    onRender: function(date) {
      //  return date.valueOf() < now.valueOf() ? 'disabled' : '';
    }
  }).on('changeDate', function(ev) {
    if (ev.date.valueOf() > checkout.date.valueOf()) {
      var newDate = new Date(ev.date)
      newDate.setDate(newDate.getDate() + 1);
      checkout.setValue(newDate);
    }
    checkin.hide();
    $('#dpd2')[0].focus();
  }).data('datepicker');
  var checkout = $('#dpd2').datepicker({
    onRender: function(date) {
      // return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
    }
  }).on('changeDate', function(ev) {
    checkout.hide();
  }).data('datepicker');


  // var nowTemp = new Date();
  // var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

  // var checkin = $('#dpd1').datepicker({
  //  onRender: function(date) {
  //     //  return date.valueOf() < now.valueOf() ? 'disabled' : '';
  //     }
  // }).on('changeDate', function(ev) {
  // if (ev.date.valueOf() > checkout.date.valueOf()) {
  //     var newDate = new Date(ev.date)
  //     newDate.setDate(newDate.getDate() + 1);
  //     checkout.setValue(newDate);
  // }
  //       checkin.hide();
  // $('#dpd2')[0].focus();
  // }).data('datepicker');
  //     var checkout = $('#dpd2').datepicker({
  //     onRender: function(date) {
  //     return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
  // }
  // }).on('changeDate', function(ev) {
  // checkout.hide();
  // }).data('datepicker');
</script>

</html>