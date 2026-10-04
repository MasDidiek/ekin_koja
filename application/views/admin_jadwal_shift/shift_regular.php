<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/addon.css" media="screen">

  <style>
    .shift-off {
      background: #f53b54;
      color: #FFF;
      font-weight: 100;
    }

    .shift-loff {
      background: #f5b03b;
      color: #FFF;
      font-weight: 100;
    }

    .btn-close {
      float: right;
      cursor: pointer;
    }

    .alert .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      color: #aaa;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .alert .close-btn:hover {
      color: #000;
    }

    #div_change_shift {
      width: 400px;
      height: auto;
      background: #FFF;
      position: fixed;
      top: 18%;
      right: 400px;
      box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
      -webkit-box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
      -moz-box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
      display: none;
      padding: 20px;
      z-index: 99;
    }

    .col-name {
      left: 0;
      position: sticky;
    }

    .pilih-shift {
      border: 1px solid #DDD;
      padding: 5px 10px;
      font-size: 12px;
      color: #FFF;
      margin: 3px;
      width: 80px;
    }

    .shift-on {
      background: #FFF;
      color: #097d42;
    }

    .shift-on:hover {
      background: #bef4e6;
      color: #097d42;
    }

    .jam-kerja {
      font-size: 11px;
      color: #d87829;
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
                  <h4 class="fw-semibold mb-8">Shift Kerja Pegawai</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Shift Kerja Pegawai UGD-RB</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">

                </div>
              </div>
            </div>


          </div>
        </div>

        <?php
        $message = $this->session->flashdata('success');

        // $periode = date('Y-m');
        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');

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

        echo $message;


        $listBulan = array_bulan();

        $lastDateMonth = date('t', strtotime($periode));
        ?>

        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">

                <?php if ($message != '') { ?>
                  <div class="alert alert-success">
                    <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Success! </strong> <?php echo  $message; ?>
                  </div>
                <?php }  ?>

                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Tambah Depertamen /  Bagian
                            </button> -->

                <div id="div_change_shift">

                  <div class="btn-close"></div>
                  <h3>Pengaturan Shift Kerja</h3>
                  <hr>
                  <div id="data_info"></div> <br>

                  <?php
                  for ($g = 0; $g < count($shift_kerja); $g++) {
                    echo '<button type="button" value="' . $shift_kerja[$g]->kode_shift . '" class="pilih-shift shift-on">' . $shift_kerja[$g]->kode_shift . '</button>';
                  }
                  ?>



                </div>
                <div class="row">
                  <div class="col-md-3">
                    <label for="bulan">Periode</label><br>
                    <input type="text" readonly class="periode" name="periode" id="periode" value="<?php echo $nm_bulan . ' &nbsp; &nbsp; ' . $tahun; ?>">
                  </div>
                  <div class="form-periode">
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


                </div><!--row-->

                <div class="table-responsive mt-4">
                  <table class="table table-bordered table-hover table-sm" style="width:200%">
                    <thead>
                      <tr>

                        <th>Nama Pegawai</th>
                        <?php
                        for ($i = 1; $i < ($lastDateMonth + 1); $i++) {
                          $date =  $periode . '-' . $i;

                          $tanggal = format_db($date);
                          $day = date('l', strtotime($tanggal));
                          if ($day == 'Sunday') {
                            $hari = 'Mg';
                          } else if ($day == 'Monday') {
                            $hari = 'Sn';
                          } else if ($day == 'Tuesday') {
                            $hari = 'Sl';
                          } else if ($day == 'Wednesday') {
                            $hari = 'Rb';
                          } else if ($day == 'Thursday') {
                            $hari = 'Km';
                          } else if ($day == 'Friday') {
                            $hari = 'Jm';
                          } else {
                            $hari = 'Sb';
                          }

                          echo ' <th class="text-center">' . $i . ' <br>
                                                    <small>' . $hari . '</small></th>';
                        }

                        ?>

                      </tr>
                    </thead>
                    <tbody>



                      <tr>
                        <td class="col-name">PEGAWAI REGULER</td>
                        <?php
                        for ($a = 1; $a < ($lastDateMonth + 1); $a++) {


                          $tanggal  = $periode . '-' . $a;
                          $matrikId = '0_' . $tanggal;
                          $tgl = format_db($tanggal);

                          $shift = $this->Presensi_model->getDatashiftKerja(0, $tgl, 'shift');
                          $shift_class = '';
                          if ($shift != '-') {
                            $detailShift = $this->Presensi_model->detailShiftByKode($shift);
                            //   $detailShift =  'REG';
                            $jam_masuk  = format_jam($detailShift->jam_masuk);
                            $jam_pulang = format_jam($detailShift->jam_pulang);

                            $jam_kerja = $jam_masuk . ' - ' . $jam_pulang;

                            if ($shift == 'OFF') {
                              $shift_class = 'bg-light';
                            } else {
                              $shift_class = 'bg-success';
                            }
                          } else {
                            $jam_kerja = '';
                            $shift_class = 'bg-light';
                          }
                          echo '<td class="text-center">
                                                            <button type="button" class="btn-change-shift btn btn-sm fs-1 ' . $shift_class . '"  id="' . $matrikId . '">' . $shift . '</button>
                                                            
                                                            </td>';
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

      <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>


</body>
<script type="text/javascript">
  matrikId = '';
  id_pegawai = '';
  $(".btn-change-shift").click(function() {

    matrikId = $(this).attr("id");
    id_pegawai = $(this).val();


    $("#div_change_shift").show();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>admin_jadwal_shift/getInfo",
      data: "data_post=" + matrikId,
      success: function(return_data) {
        $("#data_info").html(return_data);

      }
    });


  });


  $(".pilih-shift").click(function() {
    var kode_shift = $(this).val();

    $("#" + matrikId).html(kode_shift);


    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>admin_jadwal_shift/insertShiftKerja",
      data: "data_post=" + matrikId + "&kode_shift=" + kode_shift,
      success: function(return_data) {
        //$("#data_info").html(return_data);

      }
    });
    $("#div_change_shift").hide();
  });


  $(".btn-close").click(function() {
    $("#div_change_shift").hide();
  });



  $(".btn-bulan").click(function() {
    var bulan = $(this).val();
    var tahun = $("#tahun").val();

    var bulan_tahun = bulan + '  ' + tahun;
    $("#periode").val(bulan_tahun);

    $(".form-periode").hide();

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
    $(".form-periode").show();
  });
</script>

</html>