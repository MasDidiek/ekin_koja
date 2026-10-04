<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">


  <style>
    .loader {
      width: 40px;
      height: 40px;
      border: 5px solid #3ab874;
      border-bottom-color: transparent;
      border-radius: 50%;
      display: none;
      box-sizing: border-box;
      animation: rotation 1s linear infinite;

    }

    @keyframes rotation {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }


    table {
      width: 100%;
    }

    .table-absensi th {
      border: 1px solid #EEE;
      padding: 10px;
      text-align: center;
      font-size: 15px;
    }

    .table-absensi td {
      border: 1px solid #EEE;
      padding: 8px;
      text-align: center;
      font-size: 14px;
      color: #555
    }
  </style>
</head>

<body>
  <!--  Body Wrapper -->
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->


        <?php $this->load->view('layout/section/sidebar'); ?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header'); ?>


      <?php

      #print_array($this->session->userdata);
      // $bulan = $this->session->userdata('periode_bulan');
      // $tahun = $this->session->userdata('periode_tahun');


      $periode_bulan = $this->session->userdata('periode_bulan');
      $periode_tahun = $this->session->userdata('periode_tahun');
      $id_pkm_sess   = $this->session->userdata('id_pkm');

      $order_by = $this->uri->segment(4);


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
      $id_validator = $this->session->userdata('id_pegawai');
      $id_pj_sess  = $this->session->userdata('id_pj');


      $listBulan = array_bulan();

      if ($id_pj_sess != '') {
        $id_validator = $id_pj_sess;
      }
      #print_array($rekap_absensi);

      ?>

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">

                Data Pengajuan Izin Sakit
              </div>


            </div>
          </div>



          <div class="row">
            <!-- Column -->

            <div class="col-md-2">
              <label for="jns_absensi">Jenis Absensi</label>
              <select name="jns" id="jns_absensi" class="form-control">
                <option value="IZIN">IZIN</option>
                <option value="SAKIT">SAKIT</option>
              </select>
              <span class="loader"></span>
            </div>
            <div class="col-md-2">
              <label for="status">Status</label>
              <select name="status" id="status" class="form-control">
                <option value="0">Belum diperiksa</option>
                <option value="1">Sudah diperiksa</option>
              </select>

            </div>



            <div class="table-responsive mt-4">
              <table class="table  table-hover table-striped" id="data-table">
                <thead>
                  <tr>

                    <th class="w-1">No.</th>
                    <th>Jenis Absen</th>
                    <th>Nama</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Status</th>

                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="body-content">

                  <?php
                  // print_array($izin_sakit);

                  for ($i = 0; $i < count($izin_sakit); $i++) {
                    $id = $izin_sakit[$i]->id;
                    $id_pegawai = $izin_sakit[$i]->id_pegawai;
                    $tanggal = $izin_sakit[$i]->tanggal;
                    $jenis_absen = $izin_sakit[$i]->jenis_absen;
                    $keterangan = $izin_sakit[$i]->keterangan;
                    $nama = $this->Pegawai_model->getNamaPegawaiByID($id_pegawai);
                    $status = $izin_sakit[$i]->status;
                    $file_image = $izin_sakit[$i]->file_image;
                    if ($status == 0) {
                      $status_flag = '<span class="badge bg-warning-subtle text-warning">Belum diperiksa</span>';
                    } else {
                      $status_flag = '<span class="badge bg-success-subtle text-success">Belum diperiksa</span>';
                    }
                    echo '<tr>
                                  <td>' . ($i + 1) . '</td>
                                 
                                  <td>' . $jenis_absen . '</td>
                                  <td> <a href="' . base_url() . 'uploads/surat_izin/' . $file_image . '" target="_blank">' . $nama . '</a></td>
                                  <td>' . format_view($tanggal) . '</td>
                                  <td>' . $keterangan . '</td>
                                  <td>' . $status_flag . '</td>
                                 
                                  <td> <a href="' . base_url() . 'dashboard/setujuiIzinSakit/' . $id . '/1" class="btn btn-sm btn-success"> Setujui</a></td>
                                 </tr>
                                ';
                    # code...
                  }
                  ?>
                </tbody>

              </table>

            </div>


            <!-- Column -->
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
        <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

        <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

        <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>


        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
</body>


<script>
  $("#validator").change(function() {
    var id_pj = $(this).val();

    $.ajax({

      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>admin/presensi/set_session_validator",
      data: "id_pj=" + id_pj,
      success: function(msg) {
        window.location.reload();
        //$("#modal-form").html(msg);
        //console.log(msg);
      }

    });

  });





  $("#jns_absensi").change(function() {
    var jenis_absensi = $(this).val();
    var status = $("#status").val();
    $(".loader").css("display", "inline-block");

    $.ajax({

      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>dashboard/filter_jns_absensi",
      data: "jenis_absensi=" + jenis_absensi + "&status=" + status,
      success: function(msg) {
        $(".loader").css("display", "none");
        $("#body-content").html(msg);
      }

    });

  });

  $("#status").change(function() {
    var status = $(this).val();
    var jenis_absensi = $("#jns_absensi").val();
    $(".loader").css("display", "inline-block");

    $.ajax({

      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>dashboard/filter_jns_absensi",
      data: "jenis_absensi=" + jenis_absensi + "&status=" + status,
      success: function(msg) {
        $(".loader").css("display", "none");
        $("#body-content").html(msg);
      }

    });

  });





  $('#data-table').dataTable({
    lengthMenu: [
      [20, -1],
      ['20', '50', '100', 'Show all']
    ]
  });
</script>

</html>