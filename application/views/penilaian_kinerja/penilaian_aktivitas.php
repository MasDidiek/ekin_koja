<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/monthly.css">
  <style type="text/css">
    .form-periode2 {
      display: none;
      width: 15em;
      height: 13em;
      background: #fff;
      position: absolute;
      border: 1px solid #ddd;
      border-radius: 3px;
      padding: 0;
      z-index: 999;
    }


    .pending {
      background:
        radial-gradient(closest-side, white 79%, transparent 80% 100%),
        conic-gradient(#ffae1f 62%, #EEE 0);
    }

    .approve {
      background:
        radial-gradient(closest-side, white 79%, transparent 80% 100%),
        conic-gradient(#13deb9 62%, #EEE 0);
    }

    .reject {
      background:
        radial-gradient(closest-side, white 79%, transparent 80% 100%),
        conic-gradient(#fa896b 62%, #EEE 0);
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

      $function = $this->uri->segment(3);
      $id_pegawai = $this->uri->segment(4);
      $message = $this->session->flashdata('message');


      #print_array($this->session->userdata);
      $periode_bulan = $this->session->userdata('periode_bulan');
      $periode_tahun = $this->session->userdata('periode_tahun');
      $id_pkm_sess   = $this->session->userdata('id_pkm');


      $nama_pegawai = $pegawai[0]->nama;
      $nip = $pegawai[0]->nip;
      $jabatan = $pegawai[0]->jabatan;
      $puskesmas = $pegawai[0]->puskesmas;

      $pin = substr($nip, -4);
      #print_array($dataAktifitasPegawai);



      if ($periode_bulan == '') {
        $bulan = date('m');
        $tahun = date('Y');
      } else {
        $bulan = $periode_bulan;
        $tahun = $periode_tahun;
      }


      $nm_bulan = getBulan($bulan);


      $periode = $tahun . '-' . $bulan;
      $periode = date('Y-m', strtotime($periode));
      #print_array($dataAktifitasPegawai);
      $dataCuti = $this->Presensi_model->getCutiFromTableAbsensi($pin, $periode);

      $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
      $menitEfektifBulanan  = $jumlahHariKerja * 300;

      $dataAktifitas = array();


      $totalMenitAktifitas = 0;

      $totalAktifitas  = 0;
      $jmlPending = 0;
      $jmlMentPending = 0;

      $jmlApprove = 0;
      $jmlMentApprove = 0;

      $jmlReject = 0;
      $jmlMentReject = 0;

      foreach ($dataAktifitasPegawai as $aktifitas) {
        $tgl = $aktifitas->tgl;
        $jam_mulai = $aktifitas->jam_mulai;
        $jam_selesai = $aktifitas->jam_selesai;
        $total = $aktifitas->total;
        $status = $aktifitas->status;


        $periodeAktifitas = date('Y-m', strtotime($tgl));

        if ($periode == $periodeAktifitas) {
          $totalAktifitas  = $totalAktifitas + 1;


          if ($status == 0) {

            $jmlPending = $jmlPending + 1;
            $jmlMentPending = $jmlMentPending + $total;
          } else if ($status == 1) {
            $jmlApprove = $jmlApprove + 1;
            $jmlMentApprove =  $jmlMentApprove + $total;
          } else {
            $jmlReject = $jmlReject + 1;
            $jmlMentReject =  $jmlMentReject + $total;
          }

          $totalMenitAktifitas =  $totalMenitAktifitas + $total;
        }







        if ($status == 0) {
          $color = '#ffae1f';
        } else if ($status == 1) {
          $color = '#41c46e';
        } else {
          $color = '#fa896b';
        }


        $dataAktifitas[] = array(
          'id' => $aktifitas->id,
          'name' => $total,
          'startdate' => $tgl,
          'enddate' => $tgl,
          'starttime' => date('H:i', strtotime($jam_mulai)),
          'endtime' => date('H:i', strtotime($jam_selesai)),
          'color' => $color
        );
      }

      for ($c = 0; $c < count($dataCuti); $c++) {
        $tg = $dataCuti[$c]->tanggal;

        $dataAktifitas[] = array(
          'id' => 5000,
          'name' => 'CUTI',
          'startdate' => $tg,
          'enddate' =>  $tg,
          'starttime' => '07:30:00',
          'endtime' => '16:30:00',
          'color' => '#f15242'
        );
      }

      if ($totalAktifitas > 0) {
        $persenPending =  ceil(($jmlPending / $totalAktifitas) * 100);
        $persenApprove =  ceil(($jmlApprove / $totalAktifitas) * 100);
        $persenReject  =  ceil(($jmlReject / $totalAktifitas) * 100);
      } else {
        $persenPending = 0;
        $persenApprove = 0;
        $persenReject  = 0;
      }


      //print_array($dataAktifitas);

      $json_aktifitas = json_encode($dataAktifitas);
      $listBulan = array_bulan();
      $lastDateMonth = date('t', strtotime($periode));


      ?>


      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8"> Kinerja </h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home / Penilaian Kinerja</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive"> Validasi Aktifitas Pegawai</li>
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


          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-md-6 mb-4">


                  <h3 class="fs-6"> <?php echo $nama_pegawai; ?></h3>
                  <strong><?php echo $nip; ?></strong>
                  <h6 class="card-subtitle text-muted mb-2"><?php echo $jabatan; ?> @
                    <span class="text-info"><?php echo $puskesmas; ?> </span>
                  </h6>

                </div>



                <div class="col-md-3">
                  <label for="bulan">Periode</label>
                  <input type="text" readonly class="periode" style="width: 150px;" name="periode" id="periode" value="<?php echo $nm_bulan . ' &nbsp; &nbsp; ' . $tahun; ?>">

                  <div class="form-periode2">
                    <div class="header-periode">
                      <button type="button" class="btn-prev"><i class="fa-solid fa-angle-left"></i> </button>
                      <input type="text" name="periode_tahun" class="tahun_periode" value="<?php echo $tahun; ?>" id="tahun">
                      <button type="button" class="btn-next"><i class="fa-solid fa-angle-right"></i> </button>
                    </div>
                    <div class="body-periode">
                      <?php
                      for ($b = 1; $b < 13; $b++) {

                        if ($b == $bulan) {
                          $active = 'bln-active';
                        } else {
                          $active = '';
                        }
                        echo '<button class="btn-bulan ' . $active . '" value="' . $listBulan[$b] . '">' . substr($listBulan[$b], 0, 3) . '</button>';
                      }
                      ?>
                    </div>
                  </div><!--form-periode-->
                </div>

                <div class="col-md-3">
                  <div class="d-flex flex-row align-items-center">
                    <div class="round-40  d-flex align-items-center justify-content-center ">
                      <i class="ti ti-clock fs-6"></i>
                    </div>
                    <div class="ms-3">
                      <h4 class="mb-0 text-info fs-4"> <?php echo rupiah($menitEfektifBulanan); ?> &nbsp; menit</h4>
                      <span class="text-warning fs-2"> Waktu Efektif input</span>
                    </div>

                  </div>
                </div>

                <div class="col-md-3">
                  <div class="d-flex flex-row align-items-center">
                    <div class="round-40  d-flex align-items-center justify-content-center ">
                      <i class="ti ti-clock fs-6"></i>
                    </div>
                    <div class="ms-3">
                      <h4 class="mb-0 text-info fs-4"> <?php echo rupiah($totalAktifitas); ?> &nbsp; Aktifitas</h4>
                      <span class="text-warning fs-2"> Total input Aktifitas</span>
                    </div>

                  </div>
                </div>

                <div class="col-md-3">
                  <div class="d-flex flex-row align-items-center">
                    <div class="round-40  d-flex align-items-center justify-content-center ">
                      <i class="ti ti-clock fs-6"></i>
                    </div>
                    <div class="ms-3">
                      <h4 class="mb-0 text-info fs-4"> <?php echo rupiah($totalMenitAktifitas); ?> &nbsp; Menit</h4>
                      <span class="text-warning fs-2"> Total input (menit)</span>
                    </div>

                  </div>
                </div>

              </div>


              <div class="row">
                <div class="col-lg-9 d-flex align-items-stretch">

                  <div class="monthly" id="mycalendar"></div>

                  <div class="card-body position-relative">
                    <div class="card w-100  overflow-hidden">
                      <button class="btn btn-primary d-none" type="button" id="offcanvasbtn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button>
                      <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">

                        <div class="offcanvas-header">
                          <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                        </div>

                        <div class="row">
                          <div class="col-md-10 ms-4">

                            <button type="button" value="" id="lihat_inputan_aktifitas" class="btn-lihat-aktifitas text-muted"><i class="fa-solid fa-file"></i>
                              &nbsp; Aktifitas Pegawai</button>
                          </div>
                        </div>



                        <div class="offcanvas-body p-4 view_aktifitas d-none">
                          <div class="p-2 fs-3 bg-info-subtle">
                            <span class="text-dark fw-semibold fs-3"> <i class="ti ti-calendar fs-4"></i>&nbsp;
                              <span id="tanggal_pilih"></span> </span><br>
                            <br>
                            <span class="text-muted"> Masuk : </span> <strong class="text-info"> - </strong> &nbsp; &nbsp;
                            <span class="text-muted"> Keluar : </span> <strong class="text-danger"> - </strong>
                          </div>
                          <div id="view_aktifitas"></div>
                        </div><!--view_aktifitas-->



                      </div>



                    </div>
                  </div>
                </div>
                <div class="col-lg-3 pt-4">


                  <!-- Column -->
                  <div class="col-lg-12 col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12">
                            <h3 class="fs-6"> <?php echo $jmlPending; ?> &nbsp; <small> Aktifitas</small> / <span class="text-muted fw-semibold fs-2"> <?php echo rupiah($jmlMentPending); ?> menit</span></h3>
                            <h6 class="card-subtitle text-muted mb-2">Belum divalidasi</h6>
                          </div>
                          <div class="col-12">
                            <div class="progress text-bg-light">
                              <div class="progress-bar text-bg-warning" role="progressbar" style="width:<?php echo $persenPending; ?>%; height: 6px;" aria-valuenow="<?php echo $persenPending; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>

                  </div>
                  <!-- Column -->

                  <!-- Column -->
                  <div class="col-lg-12 col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12">
                            <h3 class="fs-6"><?php echo $jmlApprove; ?> &nbsp; <small> Aktifitas</small>/ <span class="text-muted fw-semibold fs-2"> <?php echo rupiah($jmlMentApprove); ?> menit</span></h3>
                            <h6 class="card-subtitle mb-2 text-muted text-muted">Aktifitas disetujui</h6>
                          </div>
                          <div class="col-12">
                            <div class="progress text-bg-light">
                              <div class="progress-bar text-bg-success" role="progressbar" style="width: <?php echo $persenApprove; ?>%; height: 6px;" aria-valuenow="<?php echo $persenApprove; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Column -->

                  <!-- Column -->
                  <div class="col-lg-12 col-md-12">
                    <div class="card">
                      <div class="card-body">
                        <div class="row">
                          <div class="col-12">
                            <h3 class="fs-6"><?php echo $jmlReject; ?> &nbsp; <small> Aktifitas</small> / <span class="text-muted fw-semibold fs-2"> <?php echo rupiah($jmlMentReject); ?> menit</span></h3>
                            <h6 class="card-subtitle mb-2 text-muted text-muted">Aktifitas Ditolak</h6>
                          </div>
                          <div class="col-12">
                            <div class="progress text-bg-light">
                              <div class="progress-bar text-bg-danger" role="progressbar" style="width: <?php echo $persenReject; ?>%; height: 6px;" aria-valuenow="<?php echo $persenReject; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- Column -->





                </div>


              </div><!--row-->


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

            <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/monthly.js"></script>
            <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-clock-timepicker.js"></script>
            <script type="text/javascript">
              $(document).mouseup(function(e) {
                var container = $(".form-periode2");

                // if the target of the click isn't the container nor a descendant of the container
                if (!container.is(e.target) && container.has(e.target).length === 0) {
                  container.hide();
                }
              });



              $(".btn-bulan").click(function() {
                var bulan = $(this).val();
                var tahun = $("#tahun").val();

                var bulan_tahun = bulan + '  ' + tahun;
                $("#periode").val(bulan_tahun);

                $(".form-periode2").hide();

                $(".btn-bulan").removeClass("bln-active");
                $(this).addClass("bln-active");

                $.ajax({

                  type: "POST",
                  dataType: "html",
                  url: "<?php echo base_url(); ?>admin/presensi/set_session_periode",
                  data: "bulan=" + bulan + "&tahun=" + tahun,
                  success: function(msg) {
                    window.location.reload();
                    //$("#modal-form").html(msg);
                    //console.log(msg);
                  }

                });

              });


              $("#periode").click(function() {
                $(".form-periode2").show();
              });

              $(".btn-next").click(function() {
                var tahun = $("#tahun").val();

                var new_tahun = parseInt(tahun) + 1;
                $("#tahun").val(new_tahun);
              });


              $(".btn-prev").click(function() {
                var tahun = $("#tahun").val();

                var new_tahun = parseInt(tahun) - 1;
                $("#tahun").val(new_tahun);
              });



              $(".label-kegiatan").click(function() {

                $(".label-kegiatan").removeClass("kegiatan_active");
                $(this).addClass("kegiatan_active");

              });





              $(".btn-lihat-aktifitas").click(function() {

                $(".view_aktifitas").removeClass("d-none");
                $(".input_kegiatan").addClass("d-none");

                $(this).removeClass("text-muted");
                $(this).addClass("fw-semibold text-dark");

                $(".btn-input-aktifitas").removeClass("fw-semibold text-dark");
                $(".btn-input-aktifitas").addClass("text-muted");


                var tanggal = $(this).val();
                var id_pegawai = '<?php echo $id_pegawai; ?>';

                $.ajax({
                  type: "POST",
                  dataType: "html",
                  url: "<?php echo base_url(); ?>admin/penilaian_kinerja/getInputanAktifitasPegawai",
                  data: "tanggal=" + tanggal + '&id_pegawai=' + id_pegawai,
                  success: function(msg) {
                    $("#view_aktifitas").html(msg);
                  }

                });


              });





              var sampleEvents = {
                "monthly": <?php echo $json_aktifitas; ?>
              };

              $(window).load(function() {
                $('#mycalendar').monthly({
                  mode: 'event',
                  dataType: 'json',
                  events: sampleEvents
                });
              });
            </script>

</html>