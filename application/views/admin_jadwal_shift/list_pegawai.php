<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/addon.css" media="screen">

  <style>
    /* Style Modern untuk Shift Management */
    .card-shift-container {
      background: #ffffff;
      border-radius: 16px;
    }

    /* Custom Modal Backdrop (Latar Belakang Gelap) */
    .modal-backdrop-custom {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background-color: rgba(15, 23, 42, 0.4);
      /* Slate dark dengan opacity */
      backdrop-filter: blur(4px);
      /* Efek blur halus modern */
      z-index: 1040;
      display: none;
    }

    /* Modal Popup Edit Shift Centered (Modern Floating Card) */
    #div_change_shift {
      width: 90%;
      max-width: 480px;
      /* Ukuran proporsional modal */
      height: auto;
      background: #ffffff;
      position: fixed;

      /* Trik CSS centering presisi di tengah layar */
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%) scale(0.95);

      border-radius: 16px;
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
      display: none;
      padding: 24px;
      z-index: 1050;
      border: 1px solid #f1f5f9;
      transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    /* Efek saat modal aktif/muncul */
    #div_change_shift.show-modal {
      transform: translate(-50%, -50%) scale(1);
    }

    #div_change_shift h5 {
      font-weight: 700;
      color: #0f172a;
      font-size: 16px;
    }

    /* Tombol Pilihan Shift yang Lebih Bervariasi & Rapi */
    .pilih-shift {
      border: 1px solid #e2e8f0;
      padding: 10px 16px;
      font-size: 13px;
      font-weight: 600;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.15s ease;
      background-color: #f8fafc;
      color: #334155;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .pilih-shift:hover {
      background-color: #3b82f6;
      color: #ffffff;
      border-color: #3b82f6;
      box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);
    }

    /* Preset Warna Tag Shift Modern */
    .badge-shift {
      display: inline-block;
      padding: 6px 10px;
      font-size: 11px;
      font-weight: 700;
      border-radius: 8px;
      border: none;
      width: 100%;
      text-align: center;
      transition: all 0.2s ease;
      cursor: pointer;
      width: 100px;
    }

    .badge-shift:hover {
      opacity: 0.85;
      transform: scale(0.98);
    }

    /* Warna Kategori Shift */
    .shift-long {
      background-color: #ffe4e6 !important;
      color: #9f1239 !important;
    }

    /* Pink */
    .shift-middle {
      background-color: #e0f2fe !important;
      color: #0369a1 !important;
    }

    /* Blue */
    .shift-pagi {
      background-color: #dcfce7 !important;
      color: #166534 !important;
    }

    /* Green */
    .shift-siang {
      background-color: #fef3c7 !important;
      color: #92400e !important;
    }

    /* Yellow */
    .shift-malam {
      background-color: #f3f4f6 !important;
      color: #374151 !important;
    }

    /* Grey */
    .shift-off-badge {
      background-color: #f3e8ff !important;
      color: #6b21a8 !important;
    }

    /* Purple */
    .shift-default {
      background-color: #f1f5f9 !important;
      color: #64748b !important;
    }

    /* Light Neutral */

    /* Tabel Jadwal Modern */
    .table-shift {
      border-collapse: separate;
      border-spacing: 0 6px;
    }

    .table-shift thead th {
      border: none;
      background-color: #f8fafc;
      color: #64748b;
      font-size: 12px;
      font-weight: 600;
      padding: 12px 8px;
    }

    .table-shift thead th.active-day {
      background-color: #fef3c7;
      color: #b45309;
      border-radius: 8px;
    }

    .table-shift tbody tr td {
      border: none;
      background: #ffffff;
      vertical-align: middle;
      padding: 8px 4px;
    }

    .col-name-sticky {
      position: sticky;
      left: 0;
      background: #ffffff !important;
      z-index: 10;
      font-weight: 600;
      color: #1e293b;
      font-size: 13px;
      min-width: 180px;
      box-shadow: 4px 0 8px -2px rgba(0, 0, 0, 0.05);
    }

    /* 1. Berikan lebar minimal yang cukup untuk container dropdown */
    .form-periode {
      min-width: 320px;
      /* atur lebar minimal agar 3 kolom tidak terhimpit */
      width: max-content;
      height: auto;
    }

    /* 2. Pastikan teks bulan tidak turun/memotong per huruf */
    .body-periode button,
    .body-periode .item-bulan,
    /* sesuaikan dengan kelas tombol/item bulan Anda */
    .body-periode div {
      white-space: nowrap;
      /* mencegah teks pembungkus/turun baris */
      text-align: center;
      padding: 8px 4px;
      /* sesuaikan padding agar rapi */

    }

    /* 3. Pengaturan Grid 3 Kolom */
    .body-periode {
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 8px;
      /* tambahkan jarak antarkolom/baris agar lebih lega */
      border: 1px solid #EEE;
    }

    /* Buat tombol bulan memenuhi seluruh area sel grid */
    .body-periode .btn-bulan {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px 0;
      /* atur tinggi tombol sesuai selera */
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


            <div class="card card-shift-container w-100 shadow-sm border-0">
              <div class="card-body p-4">

                <?php if ($message != '') { ?>
                  <div class="alert alert-success alert-dismissible fade show rounded-3 mb-4" role="alert">
                    <strong>Success! </strong> <?php echo $message; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                <?php } ?>


                <!-- Filter & Header Actions -->
                <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                  <div class="d-flex align-items-center gap-2">
                    <!-- Pembungkus dibuat position-relative agar dropdown menempel presisi -->
                    <div class="position-relative" id="periodeContainer">
                      <label for="periode" class="form-label text-muted fw-semibold fs-2 mb-1">PERIODE</label>
                      <input type="text" readonly class="form-control form-control-sm fw-bold border-0 bg-light rounded-3 px-3 py-2" id="periode" value="<?php echo $nm_bulan . ' ' . $tahun; ?>" style="cursor: pointer;">

                      <!-- Selector Periode Dropdown Overlay (Tambahkan class d-none agar hide saat pertama muat) -->
                      <div class="form-periode1 card shadow-lg p-3 position-absolute bg-white d-none " id="dropdownPeriode" style="z-index: 1000; top: 100%; left: 0; min-width: 320px; margin-top: 4px;">

                        <div class="header-periode d-flex justify-content-between align-items-center mb-2">
                          <button type="button" class="btn btn-sm btn-light btn-prev"><i class="fa-solid fa-angle-left"></i></button>
                          <input type="text" name="periode_tahun" class="form-control form-control-sm text-center fw-bold border-0" value="<?php echo $tahun; ?>" id="tahun" style="width: 80px;">
                          <button type="button" class="btn btn-sm btn-light btn-next"><i class="fa-solid fa-angle-right"></i></button>
                        </div>

                        <div class="body-periode d-grid gap-1" style="grid-template-columns: repeat(3, 1fr);">
                          <?php
                          for ($b = 1; $b < 13; $b++) {
                            $active = ($b == $bulan) ? 'btn-primary text-white' : 'btn-outline-light text-dark';
                            // Menambahkan class 'btn btn-sm w-100' agar tombol memenuhi grid
                            echo '<button type="button" class="btn btn-sm w-100 btn-bulan ' . $active . '" value="' . $listBulan[$b] . '">' . substr($listBulan[$b], 0, 3) . '</button>';
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <a href="<?php echo base_url(); ?>admin_jadwal_shift/summary/<?php echo $this->uri->segment(3); ?>" class="btn btn-primary rounded-3 px-3 py-2 fs-2 fw-semibold">
                      <i class="fa fa-clock-o me-1"></i> Lihat Rekap Jam Kerja
                    </a>
                  </div>
                </div>

                <!-- Table Section -->
                <div class="table-responsive" style="max-height:500px ; overflow:scroll">
                  <table class="table table-shift align-middle" style="width: 100%; min-width: 1200px;">
                    <thead>
                      <tr>
                        <th class="col-name-sticky px-3">Pegawai</th>
                        <?php
                        for ($i = 1; $i < ($lastDateMonth + 1); $i++) {
                          $date = $periode . '-' . $i;
                          $tanggal = format_db($date);
                          $day = date('l', strtotime($tanggal));
                          $map_hari = [
                            'Sunday'    => 'Mg',
                            'Monday'    => 'Sn',
                            'Tuesday'   => 'Sl',
                            'Wednesday' => 'Rb',
                            'Thursday'  => 'Km',
                            'Friday'    => 'Jm',
                            'Saturday'  => 'Sb'
                          ];

                          $hari = isset($map_hari[$day]) ? $map_hari[$day] : 'Sb';

                          $isSunday = ($day == 'Sunday') ? 'active-day' : '';

                          echo '<th class="text-center ' . $isSunday . '">' . sprintf("%02d", $i) . '<br><small class="fw-normal text-muted">' . $hari . '</small></th>';
                        }
                        ?>
                      </tr>
                    </thead>
                    <tbody>
                      <?php

                      // print_array($list_pegawai);
                      for ($i = 0; $i < count($list_pegawai); $i++) {
                        $id_pegawai = $list_pegawai[$i]->id_pegawai;
                        $nip        = $list_pegawai[$i]->nip;
                        // $pin        = substr($nip, -4);
                        $pin  = $list_pegawai[$i]->id_mesin;

                        echo '<tr>';
                        echo '<td class="col-name-sticky px-3 d-flex justify-content-between align-items-center">
                                  <span>' . $list_pegawai[$i]->nama . '</span>
                                  <a href="' . base_url() . 'admin_jadwal_shift/update_absensi_pegawai/' . $id_pegawai . '/' . $pin . '" id="' . $pin . '" class="text-muted hover-primary ms-2" title="Upload Absen">
                                    <i class="fa fa-upload"></i>
                                  </a>
                                </td>';

                        for ($a = 1; $a < ($lastDateMonth + 1); $a++) {
                          $tanggal  = $periode . '-' . $a;
                          $matrikId = $id_pegawai . '_' . $tanggal;
                          $tgl      = format_db($tanggal);

                          $shift = $this->Presensi_model->getDatashiftKerja($pin, $tgl, 'shift');

                          // Pemetaan Warna Kelas Sesuai Nama/Kode Shift
                          $shift_upper = strtoupper($shift);

                          switch ($shift_upper) {
                            case 'P':
                            case 'PAGI':
                              $shift_class = 'shift-pagi';
                              break;
                            case 'S':
                            case 'SIANG':
                              $shift_class = 'shift-siang';
                              break;
                            case 'M':
                            case 'MALAM':
                              $shift_class = 'shift-malam';
                              break;
                            case 'L-OFF':
                            case 'OFF':
                              $shift_class = 'shift-off-badge';
                              break;
                            case 'MIDDLE':
                            case 'M1':
                              $shift_class = 'shift-middle';
                              break;
                            case 'LONG':
                              $shift_class = 'shift-long';
                              break;
                            case '-':
                            case '':
                              $shift_class = 'shift-default';
                              break;
                            default:
                              $shift_class = 'shift-pagi';
                              break;
                          }

                          $display_shift = ($shift != '' && $shift != '-') ? $shift : '-';

                          echo '<td class="text-center">
                                    <button type="button" class="badge-shift btn-change-shift ' . $shift_class . '" data-pin="' . $pin . '" id="' . $matrikId . '"
                                     data-bs-toggle="modal" data-bs-target="#modal-shift" >' . $display_shift . '</button>
                                  </td>';
                        }
                        echo '</tr>';
                      }
                      ?>
                    </tbody>
                  </table>
                </div>

              </div>
            </div>

            <!-- Modal Add New Shift -->
            <div class="modal fade" id="modal-shift" tabindex="-1" aria-labelledby="modalAddShiftLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">

                  <!-- Modal Header -->
                  <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalAddShiftLabel">
                      <i class="fa fa-plus-circle text-primary me-2"></i>Ubah Shift Kerja
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <!-- Form Shift -->

                  <div class="modal-body py-3">

                    <div id="data_info" class="p-3 bg-light rounded-3 text-secondary fs-2 mb-3 border"></div>

                    <div class="d-grid gap-2" style="grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));">
                      <?php
                      for ($g = 0; $g < count($shift_kerja); $g++) {
                        echo '<button type="button" value="' . $shift_kerja[$g]->kode_shift . '" class="pilih-shift">' . $shift_kerja[$g]->kode_shift . '</button>';
                      }
                      ?>
                    </div>


                  </div>

                  <!-- Modal Footer -->
                  <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Close</button>

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

      <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>


</body>
<script type="text/javascript">
  matrikId = '';
  id_pegawai = '';
  pin_pegawai = '';
  $(".btn-change-shift").click(function() {

    matrikId = $(this).attr("id");
    pin_pegawai = $(this).data('pin');


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
      data: "data_post=" + matrikId + "&kode_shift=" + kode_shift + "&pin=" + pin_pegawai,
      success: function(return_data) {
        //$("#div_change_shift").fadeOut(200);
        $(".btn-close").trigger("click");


      }
    });
    $("#div_change_shift").hide();
  });

  $(".btn-close-shift, .btn-close").click(function() {
    $("#div_change_shift").fadeOut(200);
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
    $(".form-periode1").removeClass("d-none");
  });
</script>

</html>