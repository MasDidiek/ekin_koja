<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <style>

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
        >
    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header'); ?>
      <!--  Header End -->


      <div class="body-wrapper">
        <div class="container-fluid">


          <?php

          $nama_user =  $this->session->userdata('nama');
          $nip_user =  $this->session->userdata('nip');
          $id_pegawai =  $this->session->userdata('id_pegawai');
          $usergroup =  $this->session->userdata('usergroup');
          $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);
          $message = $this->session->flashdata('message');

          $periode_bulan = $this->session->userdata('periode_bulan');
          $periode_tahun = $this->session->userdata('periode_tahun');
          if ($periode_bulan == '') {
            $bulan = date('m');
            $tahun = date('Y');
          } else {
            $bulan = $periode_bulan;
            $tahun = $periode_tahun;
          }

          $jumlah_cuti =  $this->Cuti_model->getHariCutiPegawai($id_pegawai, $bulan, $tahun);
          #print_array($this->session->userdata);

          if ($photo == '') {
            $photo = 'avatar.png';
          }


          if (!empty($rekapTKD)) {
            $tkd_pokok = $rekapTKD[0]->tkd_pokok;
            $capaian = $rekapTKD[0]->capaian;
            $bruto  = $rekapTKD[0]->bruto;
            $pph21 = $rekapTKD[0]->pph21;
            $bpjs = $rekapTKD[0]->bpjs;
            $bpjs_tk = $rekapTKD[0]->bpjs_tk;
            $thp = $rekapTKD[0]->thp;
            $masa_kerja = $rekapTKD[0]->masa_kerja;
          } else {
            $tkd_pokok = 0;
            $capaian =  0;
            $bruto  = 0;
            $pph21 =  0;
            $bpjs =  0;
            $bpjs_tk =  0;
            $thp =  0;
            $masa_kerja = '';
          }



          if (!empty($dataRekap)) {
            $telat = $dataRekap[0]->telat;
            $pulang_awal = $dataRekap[0]->pulang_awal;
            $izin = $dataRekap[0]->izin;
            $sakit = $dataRekap[0]->sakit;
          } else {
            $telat = 0;
            $pulang_awal = 0;
            $izin = 0;
            $sakit = 0;
          }


          $nama_bulan = getBulan($bulan);
          #print_array($dataRekap);

          ?>

          <div class="row">

            <div class="col-md-12">
              <div class="d-flex align-items-center gap-4 mb-4">
                <div class="position-relative">
                  <div class="border border-2 border-primary rounded-circle">
                    <img src="<?php echo base_url(); ?>uploads/photo_profile/<?php echo $photo; ?>" class="rounded-circle m-1" alt="user1" width="60">
                  </div>

                </div>
                <div>
                  <h3 class="fw-semibold">Hi, <span class="text-dark"> <?php echo $nama_user; ?></span>
                  </h3>
                  <span>Cheers, and happy activities - <?php echo date('d'); ?> <?php echo date('F'); ?> 2024</span>
                </div>
              </div>


            </div>

            <!--  Row 1 -->
            <div class="row">
              <div class="card">
                <h4>Halaman</h4>

                <div id="chart"></div>
              </div>

            </div>
          </div>



          <?php
          $id_pegawai = $this->session->userdata('id_pegawai');
          $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 1);
          $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
          $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);
          $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');
          $arraySisaCuti = array($hakCutiThnLalu, $hakCutiThnIni, $hakCutiBersama);
          ?>


          <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
              <form method="post" action="<?php echo base_url(); ?>cuti/check_date" enctype="multipart/form-data">
                <div class="modal-content">
                  <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="exampleModalLabel1">
                      Pengajuan Cuti
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col-md-6 col-sm-6 col-6 mt-3">
                        <label for="">Tanggal Mulai: </label>
                        <input type="text" required name="date_from" autocomplete="off" class="form-control" value="<?php echo date('d-m-Y'); ?>" id="dpd1">
                      </div>
                      <div class="col-md-6 col-sm-6 col-6 mt-3">
                        <label for=""> Tanggal Akhir: </label>
                        <input type="text" required name="date_to" autocomplete="off" class="form-control" value="<?php echo date('d-m-Y'); ?>" id="dpd2">
                      </div>
                      <div class="col-md-6 mt-3">
                        Jenis Cuti:
                        <select name="jns_cuti" id="jns_cuti" class="form-control">
                          <option value="1">Cuti Tahunan</option>
                          <option value="2">Cuti Bersalin</option>
                          <option value="3">Cuti Alasan Penting</option>
                          <option value="4">Cuti Sakit</option>
                          <option value="5">Cuti Besar</option>

                        </select>

                      </div>
                      <div class="col-md-6 mt-3">
                        Hak Cuti yang digunakan:
                        <select name="jns_hak_cuti" id="jns_cuti" class="form-control">
                          <?php
                          for ($i = 0; $i < count($arrayHakCuti); $i++) {
                            $idjnsHak = $i + 1;
                            $nama_hak_cuti = $arrayHakCuti[$i];

                            if ($jns_hak_cuti == $idjnsHak) {
                              echo '<option value="' . $idjnsHak . '" selected>' . $nama_hak_cuti . ' (' . $arraySisaCuti[$i] . ')</option>';
                            } else {
                              echo '<option value="' . $idjnsHak . '">' . $nama_hak_cuti . ' (' . $arraySisaCuti[$i] . ')</option>';
                            }
                          }
                          ?>


                        </select>
                      </div>
                    </div>


                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                      Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                      Selanjutnya
                    </button>
                  </div>
                </div>

              </form>
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

        <script src="<?php echo LIBS_JS_PATH; ?>apexcharts/dist/apexcharts.min.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>
</body>


<script>
  var options = {
    chart: {
      type: 'bar'
    },
    series: [{
      name: 'sales',
      data: [30, 40, 45, 50, 49, 60, 70, 91, 125]
    }],
    xaxis: {
      categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999]
    }
  }

  var chart = new ApexCharts(document.querySelector("#chart"), options);

  chart.render();


  $("#button_upload").click(function() {
    $(".form-upload").removeClass('d-none');


  });


  $(".approve").click(function() {
    var id_cuti = $(this).val();
    $("#id_cuti_approve").val(id_cuti);

  });


  $("#change_periode").change(function() {
    var periode = $(this).val();
    var explod = periode.split("/");
    var bulan = explod[0];
    var tahun = explod[1];
    $(".loading-image").show();

    // alert(tahun);
    // return false;

    $.ajax({

      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>dashboard/set_session_periode",
      data: "bulan=" + bulan + "&tahun=" + tahun,
      success: function(msg) {
        //return false;
        window.location.reload();
        //$("#modal-form").html(msg);
        //console.log(msg);
      }

    });

  });




  var nowTemp = new Date();
  var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
  //1700931600000
  //1703264400000

  var checkin = $('#dpd1').datepicker({

    onRender: function(date) {

      //alert(date.valueOf());
      //return date.valueOf() < now.valueOf() ? 'disabled' : '';
      return '';
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
      return '';
    }
  }).on('changeDate', function(ev) {
    checkout.hide();
  }).data('datepicker');
</script>

</html>