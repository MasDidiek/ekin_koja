<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

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

    .progress-bar {
      width: 50px;
      height: 50px;
      border-radius: 50%;

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
      $message = $this->session->flashdata('message');

      $id_pegawai = $this->session->userdata('id_pegawai');

      #print_array($this->session->userdata);
      $periode_bulan = $this->session->userdata('periode_bulan');
      $periode_tahun = $this->session->userdata('periode_tahun');
      $id_pkm_sess   = $this->session->userdata('id_pkm');

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

      $nip = $this->session->userdata('nip');
      $pin = substr($nip, -4);
      #print_array($dataAktifitasPegawai);



      $dataCuti = $this->Presensi_model->getCutiFromTableAbsensi($pin, $periode);
      #$dataCuti = $this->Cuti_model->getCutiPegawai($id_pegawai, $periode);


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
          $color = '#13deb9';
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

      //print_array($dataCuti);
      // print_array($dataAktifitas);

      $totalMenitCuti = 0;
      for ($c = 0; $c < count($dataCuti); $c++) {
        $tg = $dataCuti[$c]->tanggal;

        $totalMenitCuti =  $totalMenitCuti + 300;;
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



      $json_aktifitas = json_encode($dataAktifitas);

      $waktuEfektifFinal = $menitEfektifBulanan - $totalMenitCuti;



      //print_array($dataAktifitas);
      echo $message;


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
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home / Kinerja</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive"> Input Aktifitas </li>
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


          <div class="row">
            <div class="col-md-4">
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
            <div class="col-md-3 text-center">
              <div class=" p-2 fs-3 bg-light text-info">
                <i class="ti ti-clock"></i> Waktu efektif input : <strong><?php echo rupiah($waktuEfektifFinal); ?> menit</strong>

              </div>

            </div>

            <div class="col-md-2 text-center">

              <!-- <a href="<?php echo base_url(); ?>kinerja/tarik_data_aktifitas" class="btn btn-sm btn-light">
                <i class="fa fa-download"></i> Tarik Data</a> -->
            </div>



          </div>





          <div class="row">

            <div class="col-lg-8 d-flex align-items-stretch">
              <div class="monthly" id="mycalendar"></div>
              <div class="card-body position-relative">
                <div class="card w-100  overflow-hidden">

                  <button class="btn btn-primary d-none" type="button" id="offcanvasbtn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">Toggle right offcanvas</button>

                  <?php echo form_open('kinerja/insert_aktifitas', 'class="input_aktifitas" id="input_aktifitas"'); ?>

                  <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">

                    <div class="offcanvas-header">

                      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>

                    <div class="row">
                      <div class="col-md-10 ms-4">
                        <button type="button" value="1" class=" btn-input-aktifitas text-dark border-end"> <i class="fa-solid fa-pencil"></i> &nbsp; Input Aktifitas</button>
                        <button type="button" value="" id="lihat_inputan_aktifitas" class="btn-lihat-aktifitas text-muted"><i class="fa-solid fa-file"></i> &nbsp; Lihat Aktifitas</button>
                      </div>
                    </div>



                    <div class="offcanvas-body p-4 view_aktifitas d-none">
                      <div class="p-2 fs-3 bg-info-subtle">
                        <span class="text-dark fw-semibold fs-3"> <i class="ti ti-calendar fs-4"></i>&nbsp; <span id="tanggal_pilih"></span> </span><br>
                        <input type="hidden" name="tgl_pilih_inputan" id="tgl_pilih_inputan" value="">
                        <br>
                        <span class="text-muted"> Masuk : </span> <strong class="text-info"> - </strong> &nbsp; &nbsp;
                        <span class="text-muted"> Keluar : </span> <strong class="text-danger"> - </strong>
                      </div>
                      <div id="view_aktifitas"></div>
                    </div><!--view_aktifitas-->


                    <div id="error" class="m-4 p-4 error-date-restricted d-none alert text-danger alert-danger"></div>

                    <div class="offcanvas-body p-4 input_kegiatan" id="input_kegiatan">
                      <?php
                      $bulanNow = date('m');


                      ?>
                      <strong>Jenis Kegiatan</strong>
                      <div class="jns_kegiatan">
                        <div class="jenis_aktifitas aktifitas-utama">
                          <input type="radio" name="jns_kegiatan" id="kegiatan_utama" value="1" checked>
                          <label for="kegiatan_utama" class="label-kegiatan utama kegiatan_active"> Utama</label>
                        </div>

                        <div class="jenis_aktifitas aktifitas-tambahan">
                          <input type="radio" name="jns_kegiatan" id="kegiatan_tambahan" value="2">
                          <label for="kegiatan_tambahan" class="label-kegiatan tambahan"> Tambahan</label>
                        </div>
                      </div>

                      <div class="col-md-6  col-6 mb-3">
                        <label for="from" class="fw-semibold">Tanggal <span class="text-danger">*</span></label> : <br>
                        <input class="form-input-kinerja" type="text" name="tanggal" id="tgl_kinerja" readonly value="">
                      </div>



                      <div class="form-input">
                        <label for="from" class="fw-semibold"> Indikator Kegiatan <span class="text-danger">*</span></label> : <br>
                        <textarea id="indikator" name="indikator" class="form-input-kinerja" required autocomplete="off" rows="2" cols="10" wrap="soft"></textarea>
                        <div id="ajaxlist_indikator"></div>
                      </div>
                      <br>

                      <div class="form-input">
                        <label for="from" class="fw-semibold"> Aktifitas <span class="text-danger">*</span></label> : <br>
                        <textarea id="aktifitas" name="aktifitas" class="form-input-kinerja" required autocomplete="off" rows="2" cols="10" wrap="soft"></textarea>
                        <div id="ajaxlist_aktifitas"></div>
                      </div>


                      <br>


                      <div class="row">

                        <div class="col-md-6  col-6 mb-3">
                          <label for="from" class="fw-semibold">Jam Mulai <span class="text-danger">*</span></label> : <br>
                          <input class="time precisionTime5 form-input-kinerja" type="text" name="jam_mulai" id="jam_mulai" value="06:00">

                        </div>
                        <div class="col-md-6  col-6 mb-3">
                          <label for="from" class="fw-semibold"> Jam Selesai <span class="text-danger">*</span></label> : <br>
                          <input type="text" name="jam_selesai" id="jam_selesai" class="time durationNegativeMinMax  form-input-kinerja" value="07:00">

                        </div>
                        <div class="col-md-6 col-6">
                          <label for="from" class="fw-semibold"> Waktu Efektif <span class="text-danger">*</span></label> : <br>
                          <input type="number" name="waktu_efektif" value="0" class="form-input-kinerja" id="waktu_efektif">
                        </div>

                        <div class="col-md-6  col-6">
                          <label for="from" class="fw-semibold"> Volume <span class="text-danger">*</span></label> : <br>
                          <input type="number" id="volume" name="vol" class="form-input-kinerja" required autocomplete="off">
                          <span class="loader" style="display:none"> <img src="<?php echo PATH_IMAGE; ?>loading.gif"></span> <br>

                        </div>
                      </div>

                      <br>
                      <div class="form-input">
                        <label for="from" class="fw-semibold"> Keterangan <span class="text-danger">*</span></label> : <br>
                        <textarea name="keterangan" id="keterangan" class="form-input-kinerja" rows="2" cols="10" wrap="soft"></textarea>
                        <div id="list_keterangan"></div>
                      </div>

                      <div class="form-input mt-4">

                        <button type="submit" value="insert" name="action" class="btn btn-success float-end">Simpan</button>
                        <button type="button" class="btn btn-light float-end me-2" data-bs-dismiss="offcanvas" aria-label="Close">Batal</button>
                      </div>

                    </div>
                  </div>

                  <?php echo form_close(); ?>

                </div>
              </div>
            </div>
            <div class="col-lg-4 pt-4">

              <div class="card text-bg-info">
                <div class="card-body text-white">
                  <div class="d-flex flex-row align-items-center">
                    <div class="round-40  d-flex align-items-center justify-content-center ">
                      <i class="ti ti-pencil fs-6"></i>
                    </div>
                    <div class="ms-3">
                      <h4 class="mb-0 text-white fs-4"> <?php echo $totalAktifitas; ?> &nbsp; Aktifitas</h4>
                      <span class="text-white-50">Total input</span>
                    </div>

                  </div>

                  <div class="d-flex flex-row mt-4 align-items-center">
                    <div class="round-40 rounded-circle d-flex align-items-center justify-content-center">
                      <i class="ti ti-clock fs-6"></i>
                    </div>
                    <div class="ms-3">
                      <h4 class="mb-0 text-white fs-4"><?php echo rupiah($totalMenitAktifitas); ?> &nbsp; menit</h4>
                      <span class="text-white-50">Total Waktu</span>
                    </div>

                  </div>
                </div>
              </div>


              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-row">


                    <div class="progress-bar pending">
                      <progress value="62" min="0" max="100" style="visibility:hidden;height:0;width:0;">62%</progress>
                    </div>


                    <div class="ms-3 align-self-center">
                      <h4 class="mb-0 fs-4">Belum divalidasi</h4>
                      <span class="text-dark fw-semibold fs-4"> <?php echo $jmlPending; ?></span>
                      <span class="text-muted">Aktifitas</span>
                      &nbsp;&nbsp;&nbsp;
                      <span class="text-dark fw-semibold fs-4"> <?php echo rupiah($jmlMentPending); ?></span>
                      <span class="text-muted">Menit</span>

                    </div>

                  </div>
                </div>
              </div>

              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-row">

                    <div class="progress-bar approve">
                      <progress value="62" min="0" max="100" style="visibility:hidden;height:0;width:0;">62%</progress>
                    </div>

                    <div class="ms-3 align-self-center">
                      <h4 class="mb-0 fs-4">Disetujui</h4>
                      <span class="text-dark fw-semibold fs-4"> <?php echo $jmlApprove; ?></span>
                      <span class="text-muted">Aktifitas</span>
                      &nbsp;&nbsp;&nbsp;
                      <span class="text-dark fw-semibold fs-4"> <?php echo rupiah($jmlMentApprove); ?></span>
                      <span class="text-muted">Menit</span>

                    </div>

                  </div>
                </div>
              </div>


              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-row">
                    <div class="progress-bar reject">
                      <progress value="62" min="0" max="100" style="visibility:hidden;height:0;width:0;">62%</progress>
                    </div>
                    <div class="ms-3 align-self-center">
                      <h4 class="mb-0 fs-4">Ditolak</h4>
                      <span class="text-dark fw-semibold fs-4"> <?php echo $jmlReject; ?></span>
                      <span class="text-muted">Aktifitas</span>
                      &nbsp;&nbsp;&nbsp;
                      <span class="text-dark fw-semibold fs-4"> <?php echo rupiah($jmlMentReject); ?></span>
                      <span class="text-muted">Menit</span>

                    </div>

                  </div>
                </div>
              </div>



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



          // Success Type
          // $("#ts-success").on("click", function () {
          //     toastr.success("Have fun storming the castle!", "Miracle Max Says");
          // });


          $("#indikator").keyup(function() {
            var keyword = $(this).val();
            $("#ajaxlist_indikator").show();
            $.ajax({

              type: "POST",
              dataType: "html",
              url: "<?php echo base_url(); ?>kinerja/ajaxSearchIndikator",
              data: "keyword=" + keyword,
              success: function(msg) {
                $("#ajaxlist_indikator").html(msg);
              }

            });


          });


          $('#input_aktifitas').submit(function() {

            $.ajax({
              type: 'POST',
              url: $(this).attr('action'),
              data: $(this).serialize(),
              success: function(msg) {
                toastr.success(msg, "Berhasil");
                $("#input_kegiatan").html();

                $(".btn-lihat-aktifitas").trigger("click");
                $("#aktifitas").val("");
                $("#indikator").val("");
                $("#keterangan").val("");
                $("#waktu_efektif").val(0);
                $("#volume").val(0);
              }
            })
            return false;
          });


          $('.standard').clockTimePicker();
          $('.required').clockTimePicker({
            required: true
          });
          $('.separatorTime').clockTimePicker({
            separator: '.'
          });
          $('.amPmTime').clockTimePicker({
            useAmPm: true
          });
          $('.precisionTime5').clockTimePicker({
            precision: 5
          });

          $('.duration').clockTimePicker({
            duration: true,
            maximum: '80:00'
          });
          $('.durationNegative').clockTimePicker({
            duration: true,
            durationNegative: true
          });
          $('.durationMinMax').clockTimePicker({
            duration: true,
            minimum: '1:00',
            maximum: '24:00'
          });

          $('.durationNegativeMinMax').clockTimePicker({
            duration: true,
            precision: 5
          });



          $("#jam_mulai").change(function() {
            var jam_mulai = $(this).val();
            // alert(jam_mulai);
            // var pecah = jam_mulai.split(":");
            // var jam_awal = pecah[0];
            // var menit_awal = pecah[1];
            // var resctr_jam =
            $("#jam_selesai").val(jam_mulai);
            $('.durationNegativeMinMax').clockTimePicker({
              duration: true,
              minimum: jam_mulai,
              maximum: '23:59',
              precision: 5
            });
            $("#jam_selesai").focus();
          });


          $("#jam_selesai").change(function() {
            waktu_efektif = $("#waktu_efektif").val();
            var jam_mulai = $("#jam_mulai").val();
            var jam_selesai = $(this).val();
            $(".loader").show();
            $.ajax({
              type: "POST",
              dataType: "html",
              url: "<?php echo base_url(); ?>kinerja/hitung_volume",
              data: "waktu_efektif=" + waktu_efektif + "&jam_mulai=" + jam_mulai + "&jam_selesai=" + jam_selesai,
              success: function(msg) {
                $("#volume").val(msg);
                $(".loader").fadeOut();
              }
            });
          });



          //klik di inputan untuk mencari kegiatan yang biasa di input oleh pegawai tersebut
          $("#aktifitas").click(function() {
            var keyword = $(this).val();
            $("#ajaxlist_aktifitas").show();
            $.ajax({
              type: "POST",
              dataType: "html",
              url: "<?php echo base_url(); ?>kinerja/ajaxGetFrequentAktifitas",
              data: "keyword=" + keyword,
              success: function(msg) {
                $("#ajaxlist_aktifitas").html(msg);
              }

            });
          });



          $("#keterangan").keyup(function() {
            $("#list_keterangan").hide();
          });


          $("#keterangan").click(function() {
            var keyword = $(this).val();
            $("#list_keterangan").show();
            $.ajax({
              type: "POST",
              dataType: "html",
              url: "<?php echo base_url(); ?>kinerja/ajaxGetKeteranganAktifitas",
              data: "keyword=" + keyword,
              success: function(msg) {
                $("#list_keterangan").html(msg);
              }

            });
          });


          //search kegiatan secara global
          $("#aktifitas").keyup(function() {
            var keyword = $(this).val();
            $("#ajaxlist_aktifitas").show();
            $.ajax({
              type: "POST",
              dataType: "html",
              url: "<?php echo base_url(); ?>kinerja/ajaxSearchAktifitas",
              data: "keyword=" + keyword,
              success: function(msg) {
                $("#ajaxlist_aktifitas").html(msg);
              }

            });


          });



          $(".btn-lihat-aktifitas").click(function() {

            $(".view_aktifitas").removeClass("d-none");
            $(".input_kegiatan").addClass("d-none");

            $(this).removeClass("text-muted");
            $(this).addClass("fw-semibold text-dark");

            $(".btn-input-aktifitas").removeClass("fw-semibold text-dark");
            $(".btn-input-aktifitas").addClass("text-muted");


            var tanggal = $(this).val();

            $.ajax({
              type: "POST",
              dataType: "html",
              url: "<?php echo base_url(); ?>kinerja/getInputanAktifitas",
              data: "tanggal=" + tanggal,
              success: function(msg) {
                $("#view_aktifitas").html(msg);
              }

            });


          });


          $(".btn-input-aktifitas").click(function() {
            $(".view_aktifitas").addClass("d-none");
            var tanggal_input = $("#tgl_pilih_inputan").val();
            //alert(tanggal_input);

            $.ajax({
              type: "POST",
              dataType: "html",
              url: "<?php echo base_url(); ?>kinerja/cekTanggalAktifitas",
              data: "tanggal=" + tanggal_input,
              success: function(msg) {

                //$("#input_kegiatan").html(msg);

                //$("#view_aktifitas").html(msg);

                // alert(msg);
                if (msg == 'allowed') {
                  $(".input_kegiatan").removeClass("d-none");
                  $(".error-date-restricted").addClass("d-none");
                } else {
                  // alert(msg);

                  $(".error-date-restricted").removeClass("d-none");
                  if (msg == 'restricted1') {
                    $(".error-date-restricted").html("<strong> <i class=\"fa-solid fa-triangle-exclamation\"></i> Batas input aktifitas telah berakhir!!</strong><br> anda tidak diperkenankan untuk melakukan input aktifitas");
                  } else if (msg == 'restricted3') {
                    $(".error-date-restricted").html("<strong> <i class=\"fa-solid fa-triangle-exclamation\"></i> Anda cuti di tanggal tersebut!!</strong><br> anda tidak diperkenankan untuk melakukan input aktifitas");
                  } else if (msg == 'restricted4') {
                    $(".error-date-restricted").html("<strong> <i class=\"fa-solid fa-triangle-exclamation\"></i> Anda izin/sakit !!</strong><br> anda tidak diperkenankan untuk melakukan input aktifitas");
                  } else {
                    $(".error-date-restricted").html("<strong> <i class=\"fa-solid fa-triangle-exclamation\"></i> Tanggal melebihi!!</strong><br> anda tidak diperkenankan untuk melakukan input aktifitas");
                  }

                }
              }

            });


            //$(".input_kegiatan").removeClass("d-none");

            $(this).removeClass("text-muted");
            $(this).addClass("fw-semibold text-dark");

            $(".btn-lihat-aktifitas").removeClass("fw-semibold text-dark");
            $(".btn-lihat-aktifitas").addClass("text-muted");


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