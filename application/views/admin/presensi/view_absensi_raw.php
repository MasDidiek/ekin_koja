<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .datepicker {
      z-index: 1999;
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
                  <h4 class="fw-semibold mb-8"> Absensi Pegawai</h4>
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




          ?>
          <div class="row">



            <?php

            $tahun = $this->session->userdata('periode_tahun');
            $bulan = $this->session->userdata('periode_bulan');
            
            if (empty($tahun) || empty($bulan)) {
              $filter = $this->session->userdata('filter_presensi');
              if (!empty($filter['periode'])) {
                $tahun = date('Y', strtotime($filter['periode']));
                $bulan = date('m', strtotime($filter['periode']));
              } else {
                $tahun = date('Y');
                $bulan = date('m');
              }
            }


            $periode = $tahun . '-' . $bulan;
            $periode = date('Y-m', strtotime($periode));

            $lastDate = date('t', strtotime($periode)) + 1;

            $id_pegawai = $data_pegawai[0]->id_pegawai;

            $nip        = $data_pegawai[0]->nip;
            $id_mesin        = $data_pegawai[0]->id_mesin;
            $nama_pegawai = $data_pegawai[0]->nama;
            $pin = substr($nip, -4);

            $message = $this->session->flashdata('message');

            ?>


            <div class="col-md-12 me-4">
              <h4> <?php echo $nama_pegawai; ?> <br>
                <span class="text-muted fs-3"><?php echo $nip; ?></span>
              </h4> <br>
              Periode : <strong> <?php echo date('F Y', strtotime($periode)); ?> </strong>

            </div>

            <div class="col-md-12">
              <a href="<?php echo base_url(); ?>admin/presensi/lihat_absensi_pegawai/<?php echo $id_pegawai . '/' . $pin; ?>" class="btn btn-danger  mb-3">
                Back
              </a>


              <form method="post" action="<?php echo base_url(); ?>admin/presensi/edit_id_pin/<?php echo $id_pegawai . '/' . $pin; ?>">
                <div class="form-group">
                  <label> ID/PIN Mesin</label>
                  <input type="text" name="id_mesin" value="<?php echo $id_mesin; ?>" required>
                  <i class="ti ti-flag"></i>
                  <label> PIN Pegawai</label>

                  <input type="text" name="id_pin" value="<?php echo $pin; ?>" required>
                  <button type="submit" class="btn btn-info">Submit</button>


                </div>
              </form>
              "


              <a class="btn btn-success btn-sm me-2 float-end  mb-3" href="<?php echo base_url(); ?>admin/presensi/sinkron_absensi/<?php echo $pin . '/' . $id_pegawai . '/' . $periode; ?>">
                <i class="ti ti-download me-1 fs-4"></i> Sinkron Data Absensi </a>

            </div>


            <div class="row">

              <div class="col-md-7">
                <h5>Data Cuti</h5>



                <a href="#" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modal-cuti">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 5l0 14" />
                    <path d="M5 12l14 0" />
                  </svg>
                  Input Cuti
                </a>

                <table class="table table-center text-nowrap table-bordered">
                  <thead>
                    <tr>
                      <th>Tanggal Mulai</th>
                      <th>Tanggal Akhir</th>
                      <th>Alasan Cuti</th>
                      <th>Status</th>

                    </tr>
                  </thead>

                  <tbody>

                    <?php
                    for ($c = 0; $c < count($data_cuti); $c++) {


                      $id_cuti = $data_cuti[$c]->id;
                      $tanggal = $data_cuti[$c]->tgl;
                      $keterangan = $data_cuti[$c]->alasan_cuti;
                      $tgl_dari   =  $data_cuti[$c]->tgl_dari;
                      $tgl_sampai =   $data_cuti[$c]->tgl_sampai;
                      $hari_cuti  =   $data_cuti[$c]->hari_cuti;
                      $status  =   $data_cuti[$c]->status;

                      $flagStatus = getStatusCuti($status);

                      echo '
                                    <tr>
                                        <td>' . format_semi($tgl_dari) . '</td>
                                        <td>' . format_semi($tgl_sampai) . '</td>
                                        <td class="text-start">' . $keterangan . '</td>
                                        <td>' .  $flagStatus . ' 
                                         <a href="' . base_url() . 'admin/presensi/reupdate_absensi_cuti/' . $id_cuti . '/' . $pin . '/' . $id_pegawai . '" class="btn btn-sm btn-warning">Reupdate</a>
                                        </td>
                                    </tr>
                                ';
                    }

                    ?>

                  </tbody>
                </table>


                <br>

                <hr>
                <h5>Data Pengajuan Dinas Luar</h5>


                <table class="table">
                  <thead>
                    <tr>
                      <th class="w-1">No.</th>

                      <th>Tanggal</th>
                      <th>Jenis Dinas Luar</th>
                      <th>Keterangan</th>
                      <th>Status</th>
                      <th>Action </th>

                    </tr>
                  </thead>
                  <tbody>

                    <?php

                    $path        = 'uploads/surat_tugas/';
                    $no = 1;
                    foreach ($pengajuan_dinas_luar as $dl) {

                      $id_pegawai = $dl->id_pegawai;
                      $id = $dl->id;
                      $jns_dl = $dl->jns_dl;
                      $tanggal = $dl->tanggal;
                      $keterangan = $dl->keterangan;
                      $status = $dl->status;
                      $surtug = $dl->surtug;

                      if ($jns_dl == 'DLP') {
                        $dl_name = '<span class="badge  bg-primary-subtle text-primary">DL - PENUH</span>';
                      } else if ($jns_dl == 'DLA') {
                        $dl_name = '<span class="badge  bg-warning-subtle text-warning">DL - AWAL</span>';
                      } else {
                        $dl_name = '<span class="badge  bg-success-subtle text-success">DL -  AKHIR</span>';
                      }

                      if ($status == 0) {
                        $flag = '<span class="badge bg-warning fs-1">Belum diperiksa</span>';
                      } else if ($status == 1) {
                        $flag = '<span class="badge bg-success">Valid</span>';
                      } else {
                        $flag = '<span class="badge bg-danger">Tidak Valid</span>';
                      }

                      echo ' <tr>
                                                <td>' . $no . ' </td>
                                            
                                                <td class="text-center">' . format_semi($tanggal) . '</td>
                                                <td class="text-center"> ' . $dl_name . '</td>
                                                <td>' . $keterangan . ' </td>
                                                <td class="text-center">' . $flag . ' </td>
                                                <td class="text-center">
                                                    <a href="' . base_url() . $path . $surtug . '" class="btn btn-sm bg-info-subtle text-info" title="Unduh file" target="_blank">
                                                            <i class="fas fa-file-pdf"></i> Lihat
                                                    </a>
                                                    <a href="' . base_url() . 'admin/presensi/setujui_pengajuan_dl/' . $id . '/1/' . $pin . '/' . $id_pegawai . '" class="btn btn-sm btn-success" class="btn btn-sm btn-info">
                                                    <i class="fas fa-check"></i> Setujui
                                                </a>
                                                <a href="' . base_url() . 'admin/presensi/setujui_pengajuan_dl/' . $id . '/2/' . $pin . '/' . $id_pegawai . '" class="btn btn-sm btn-sm btn-danger">
                                                    <i class="fas fa-times"></i>  Tolak
                                                </a>
                                                    </td>
                                            
                                                
                                            </tr>';

                      $no += 1;
                    }

                    ?>




                  </tbody>
                </table>
              </div>


              <div class="col-md-3">
                <table class="table table-center text-nowrap table-bordered">
                  <thead>
                    <tr>
                      <th>Tanggal</th>
                      <th>Status</th>
                      <th>Action</th>

                    </tr>
                  </thead>

                  <tbody>
                    <?php

                    # print_array($absensi);


                    $today = date('Y-m-d');

                    // print_array($absensi);
                    $initial_date = '';
                    if (!empty($absensi)) {
                      $initial_date = $absensi[0]->tanggal;

                      $initial_date = format_view($initial_date);
                    }

                    echo ' <tr>
                                                    <td style="text-align:left" class="badge bg-indigo-lt">
                                                     <strong>' . format_full($initial_date) . '</strong>
                                                   
                                                    </td>
                                                    <td  colspan="2" >  <a href="' . base_url() . 'admin/presensi/clear_duplicate/' . $initial_date . '/' . $pin . '/' . $id_pegawai . '">Clear</a></td>
                                            </tr>';


                    //  print_array($absensi);
                    for ($b = 0; $b < count($absensi); $b++) {

                      $absen_for = $absensi[$b]->status;
                      $id       = $absensi[$b]->id;
                      $pin       = $absensi[$b]->pin;


                      if ($absen_for == 0) {
                        $flag = '<span class="badge bg-success-subtle text-success">MSK</span>';
                        $change_to = 1;
                      } else {
                        $flag = '<span class="badge bg-danger-subtle text-danger">KEL</span>';
                        $change_to = 0;
                      }


                      $date = $absensi[$b]->tanggal;
                      $tanggal = format_view($date);

                      if ($initial_date <> $tanggal) {
                        echo '
                                                                        <tr class="bg-light">
                                                                            <td colspan="2" style="text-align:left" class="badge bg-info-subtle text-info"">
                                                                              <strong>' . format_full($tanggal) . '</strong>
                                                                    
                                                                            </td>
                                                                        <td  colspan="2" >  <a href="' . base_url() . 'admin/presensi/clear_duplicate/' . $tanggal . '/' . $pin . '/' . $id_pegawai . '">Clear</a></td>
                                                                        </tr>';
                      }



                      // hapus_absen


                      echo '
                                                                <tr id="row' . $id . '">
                                                                    <td align="center">
                                                                        <span class="raw-time-text" id="time_text_'.$id.'">' . date('H:i:s', strtotime($absensi[$b]->tanggal)) . '</span>
                                                                        <input type="time" class="raw-time-input form-control form-control-sm mx-auto" id="time_input_'.$id.'" value="'.date('H:i:s', strtotime($absensi[$b]->tanggal)).'" style="display:none; max-width: 120px;" data-id="'.$id.'" step="1">
                                                                    </td>
                                                                    <td align="center" id="td_' . $id . '">' . $flag . '</td>
                                                                    <td align="center">
                                                                        <button type="button" value="' . $id . '" class="btn btn-sm btn-info">Ubah</button>
                                                                        <button type="button" value="' . $id . '" class="btn btn-sm btn-danger delete_raw_absen">Hapus</button>
                                                                </td>
                                                                
                                                                
                                                                </tr> ';

                      $initial_date = $tanggal;
                    }
                    ?>

                  </tbody>
                </table>
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




</body>


<script>
  <?php
  if ($message != '') {

    echo "toastr.success('" . $message . "');  ";
  }
  ?>


  $(".btn-info").click(function() {
    var id = $(this).val();

    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>admin/presensi/ubah_status_absen',
      data: 'id=' + id,
      success: function(msg) {
        $("#td_" + id).html(msg);
      }
    })


  });

  $(".delete_raw_absen").click(function() {
    var id = $(this).val();

    $.ajax({
      type: 'POST',
      url: '<?php echo base_url(); ?>admin/presensi/delete_absensi_raw',
      data: 'id=' + id,
      success: function(msg) {
        $(this).fadeOut();
        $("#td_" + id).html(msg);

      }
    })


  });

  // Secret combination: Ctrl + Alt + E
  document.addEventListener('keydown', function(e) {
    if (e.ctrlKey && e.altKey && e.key.toLowerCase() === 'e') {
      e.preventDefault();
      $('.raw-time-text').toggle();
      $('.raw-time-input').toggle();
    }
  });

  // Alternative secret: Double click the time
  $('.raw-time-text').on('dblclick', function() {
    $(this).hide();
    $(this).siblings('.raw-time-input').show().focus();
  });

  $('.raw-time-input').on('blur', function() {
    var id = $(this).data('id');
    var time = $(this).val();
    
    if(time) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/presensi/update_raw_time',
            data: { id: id, time: time },
            success: function(msg) {
                if(msg !== 'error') {
                    $('#time_text_' + id).text(msg);
                    $('#time_input_' + id).hide();
                    $('#time_text_' + id).show();
                } else {
                    alert('Gagal mengupdate waktu');
                }
            }
        });
    }
  });
</script>

</html>