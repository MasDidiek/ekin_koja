<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

  <style>
    /* Custom Table Styling */
    .table {
      font-size: 0.875rem;
      color: #495057;
    }

    .table thead th {
      background-color: #f8f9fa;
      color: #343a40;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.5px;
      border-bottom: 2px solid #e9ecef;
      padding: 0.75rem;
    }

    .table thead th.sub-header {
      background-color: #f1f3f5;
      font-size: 0.7rem;
    }

    .table tbody td {
      padding: 0.6rem 0.75rem;
      border-bottom: 1px solid #f1f3f5;
    }

    /* Row Highlight untuk Weekend */
    .table-light-weekend {
      background-color: #fcfcfc;
      color: #adb5bd;
    }

    /* Button & Action Styling */
    .btn-action-delete {
      color: #dc3545;
      opacity: 0.6;
      transition: opacity 0.2s ease;
      padding: 2px 6px;
      border-radius: 4px;
    }

    .btn-action-delete:hover {
      opacity: 1;
      background-color: #ffe8e6;
    }

    .btn-light-primary {
      background-color: #e7f5ff;
      color: #1c7ed6;
      border: none;
      padding: 2px 8px;
      font-size: 0.75rem;
    }

    .btn-light-primary:hover {
      background-color: #d0ebff;
      color: #1864ab;
    }

    /* Footer / Summary Row */
    .table-summary {
      background-color: #f8f9fa;
      border-top: 2px solid #dee2e6;
      font-size: 0.9rem;
    }

    .my_btn {
      padding: 8px 15px;
      color: #FFF;
      border-radius: 3px;
      font-family: Arial, Helvetica, sans-serif
    }

    .btn-info {
      background-color: #37aee9;
    }

    .btn-info:hover {
      background-color: #2d9ed6;
    }

    .btn-warning {
      background-color: #f0ad38;
    }

    .btn-light {
      background-color: #f0f3f5;
      color: #666;
      padding: 8px 15px;
      border: 1px solid #dee8ed;
    }

    .btn-light:hover {
      background-color: #dce6eb;
      color: #333;
    }

    .btn-primary {
      background-color: #3787e9;
    }

    .btn-primary:hover {
      background-color: #2974d0;
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
          $error = $this->session->flashdata('error');
          $success = $this->session->flashdata('success');


          //print_array($this->session->flashdata);
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

                  <?php if ($success != '') : ?>
                    <div class="alert alert-success"><?= $success; ?></div>
                  <?php endif; ?>


                  <?php if ($error != '') : ?>
                    <div class="alert alert-danger"><?= $error; ?></div>
                  <?php endif; ?>

                  <?php

                  //print_array($data_pjlp);
                  $id_pegawai = $data_pjlp[0]->id;
                  $id_pjlp = $data_pjlp[0]->id_pjlp;
                  $nama = $data_pjlp[0]->nama;
                  $jabatan = $data_pjlp[0]->jabatan;
                  $lokasi_kerja = $data_pjlp[0]->lokasi_kerja;


                  $absensi_raw = $this->Presensi_model->getAbsenBulanan($id_pjlp, $periode);


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

                  <a href="<?php echo base_url(); ?>admin/absensi_pjlp/main" class="my_btn btn-light me-2 float-start">Kembali</a>
                  <a href="<?php echo base_url(); ?>admin/absensi_pjlp/update_rekap/<?php echo $id_pegawai . '/' . $id_pjlp . '/' . $periode; ?>" class="my_btn btn-primary ms-1 float-end">Update Rekap</a>

                  <a href="<?php echo base_url(); ?>admin/absensi_pjlp/sinkron_data_shift/<?php echo $id_pegawai . '/' . $id_pjlp; ?>" class="my_btn btn-info float-start">Tarik Data Shift</a>
                  <a href="<?php echo base_url(); ?>admin/absensi_pjlp/sinkron_data_absensi/<?php echo $id_pegawai . '/' . $id_pjlp; ?>" class="my_btn btn-warning float-start  ms-1 me-1">Tarik Data Absen</a>
                  <a href="<?= base_url(); ?>admin/absensi_pjlp/cetak_absensi/<?php echo $id_pjlp; ?>" target="_blank" class="my_btn btn-light float-end me-2">Print</a>


                  <button class="btn bg-danger-subtle text-danger" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                    Data Absensi RAW
                  </button>


                  <div class="clearfix"></div>

                  <div class="card-body p-0 mt-2">
                    <div class="table-responsive">
                      <table class="table table-hover align-middle mb-0">
                        <thead>
                          <tr>
                            <th rowspan="2" class="text-center align-middle">Tanggal</th>
                            <th rowspan="2" class="text-center align-middle">Hari</th>
                            <th rowspan="2" class="text-center align-middle">Shift</th>
                            <th colspan="2" class="text-center">Jam Kerja</th>
                            <th colspan="2" class="text-center">Jam Absen</th>
                            <th rowspan="2" class="text-center align-middle">Telat</th>
                            <th rowspan="2" class="text-center align-middle">P. Awal</th>
                            <th rowspan="2" class="text-left align-middle">Keterangan</th>
                          </tr>
                          <tr>
                            <th class="text-center sub-header">Masuk</th>
                            <th class="text-center sub-header">Keluar</th>
                            <th class="text-center sub-header">Masuk</th>
                            <th class="text-center sub-header">Keluar</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $totalTelat  = 0;
                          $totalP_awal = 0;

                          for ($i = 0; $i < 31; $i++) {
                            $tgl = $i + 1;
                            $tanggal = format_db($periode . '-' . $tgl);
                            $hari = getNamahari($tanggal);
                            $dataAbsensi = $this->Presensi_model->getDataAbsensi($id_pjlp, $tanggal, "tbl_absensi_pjlp");

                            if (!empty($dataAbsensi)) {
                              $shift       = $dataAbsensi[0]->shift;
                              $jam_masuk   = $dataAbsensi[0]->jam_masuk;
                              $jam_pulang  = $dataAbsensi[0]->jam_pulang;
                              $masuk       = $dataAbsensi[0]->masuk;
                              $pulang      = $dataAbsensi[0]->pulang;
                              $telat       = $dataAbsensi[0]->telat;
                              $p_awal      = $dataAbsensi[0]->p_awal;
                              $keterangan  = $dataAbsensi[0]->keterangan;
                            } else {
                              $shift = $jam_masuk = $jam_pulang = $masuk = $pulang = $keterangan = '-';
                              $telat = 0;
                              $p_awal = 0;
                            }



                            $totalTelat += $telat;
                            $totalP_awal += $p_awal;

                            // Formatting Badge Status (Izin / Sakit)
                            $masuk_display = $masuk;
                            $pulang_display = $pulang;
                            if (in_array($masuk, ['IZIN', 'SAKIT'])) {
                              $masuk_display = '<span class="badge bg-warning-subtle text-warning fw-semibold">' . $masuk . '</span>';
                              $pulang_display = '<span class="badge bg-warning-subtle text-warning fw-semibold">' . $pulang . '</span>';
                            }
                            if ($masuk == 'CUTI') {
                              $masuk_display = '<span class="badge bg-success-subtle text-success fw-semibold">' . $masuk . '</span>';
                              $pulang_display = '<span class="badge bg-success-subtle text-success fw-semibold">' . $pulang . '</span>';
                            }

                            // Formatting Tombol Aksi
                            if (empty($masuk) || $masuk == '-') {
                              $btn_absen_masuk = '<button type="button" value="' . $tanggal . '" class="btn btn-sm btn-light-primary input_absen_manual" data-bs-toggle="modal" data-bs-target="#insert-absensi-modal" title="Tambah Absen"><i class="fa-solid fa-plus"></i></button>';
                              $btn_absen_keluar = '';
                            } else {
                              $btn_absen_masuk = '<a href="' . base_url() . 'admin/absensi_pjlp/delete_absen/' . $tanggal . '/' . $id_pjlp . '/masuk" class="btn-action-delete ms-1" title="Hapus" onClick="return confirm(\'Hapus data absensi Masuk tanggal ' . format_view($tanggal) . '\');"><i class="ti ti-trash"></i></a>';
                              $btn_absen_keluar = '<a href="' . base_url() . 'admin/absensi_pjlp/delete_absen/' . $tanggal . '/' . $id_pjlp . '/keluar" class="btn-action-delete ms-1" title="Hapus" onClick="return confirm(\'Hapus data absensi Keluar tanggal ' . format_view($tanggal) . '\');"><i class="ti ti-trash"></i></a>';
                            }

                            // Penanda Akhir Pekan (Weekend Highlight)
                            $isWeekend = in_array($hari, ['Sabtu', 'Minggu', 'Saturday', 'Sunday']);
                            $rowClass = $isWeekend ? 'table-light-weekend' : '';
                          ?>
                            <tr class="<?= $rowClass; ?>">
                              <td class="text-center fw-medium"><?= format_view($tanggal); ?></td>
                              <td class="text-center"><?= $hari; ?></td>
                              <td class="text-center"><span class="badge bg-light text-dark border"><?= $shift; ?></span></td>
                              <td class="text-center text-muted"><?= $jam_masuk; ?></td>
                              <td class="text-center text-muted"><?= $jam_pulang; ?></td>
                              <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                  <span><?= $masuk_display; ?></span>
                                  <?= $btn_absen_masuk; ?>
                                </div>
                              </td>
                              <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                  <span><?= $pulang_display; ?></span>
                                  <?= $btn_absen_keluar; ?>
                                </div>
                              </td>
                              <td class="text-center"><?= $telat > 0 ? '<span class="text-danger fw-bold">' . $telat . 'm</span>' : '-'; ?></td>
                              <td class="text-center"><?= $p_awal > 0 ? '<span class="text-warning fw-bold">' . $p_awal . 'm</span>' : '-'; ?></td>
                              <td class="text-start text-muted fs-2"><?= $keterangan; ?></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                        <tfoot>
                          <tr class="table-summary">
                            <td colspan="7" class="text-end fw-bold">Total Keterlambatan & Pulang Awal:</td>
                            <td class="text-center fw-bold text-danger"><?= $totalTelat; ?> m</td>
                            <td class="text-center fw-bold text-warning"><?= $totalP_awal; ?> m</td>
                            <td></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>



          <div class="modal fade" id="insert-absensi-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">

              <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                  <h4 class="modal-title" id="exampleModalLabel1">
                    Insert Absensi
                  </h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                  <div class="row">

                    <div class="col-md-12">
                      <?php
                      echo form_open_multipart(base_url() . 'admin/absensi_pjlp/input_absensi_manual/' . $id_pjlp);


                      echo '
                                  <label>Tanggal</label>
                                  <input type="text" name="tgl_absensi" id="tgl_absensi" class="form-control" readonly value="">
                                  <br>

                                  <div class="row mb-4">
                                    <div class="col-md-6">
                                      <label>Absen Masuk</label>
                                      <input type="text" name="absensi_masuk" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                    <label>Absen Keluar</label>
                                    <input type="text" name="absensi_keluar" class="form-control">
                                    </div>
                                  </div>


                                  <button type="submit" class="btn btn-info float-end">
                                    <i class="fa fa-external-link-square"></i> &nbsp; simpan
                                  </button>';

                      echo form_close();
                      ?>

                    </div>
                  </div>


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                    Close
                  </button>

                </div>
              </div>


            </div>
          </div>




          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
              <h5 class="offcanvas-title" id="offcanvasExampleLabel">
                Absensi Raw
              </h5>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">

              <table class="table table-center table-sm text-nowrap table-bordered">
                <thead>
                  <tr>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Action</th>

                  </tr>
                </thead>

                <tbody>
                  <?php

                  # print_array($absensi_raw);


                  $today = date('Y-m-d');

                  //print_array($data_absensi);
                  $initial_date = '';
                  if (!empty($absensi_raw)) {
                    $initial_date = $absensi_raw[0]->tanggal;

                    $initial_date = format_view($initial_date);
                  }

                  echo ' <tr>
                                                    <td style="text-align:left" class="badge bg-indigo-lt">
                                                    <strong>' . format_full($initial_date) . '</strong>

                                                    </td>
                                                    <td  colspan="2" >  <a href="' . base_url() . 'admin/presensi/clear_duplicate/' . $initial_date . '/' . $pin . '/' . $id_pegawai . '">Clear</a></td>
                                            </tr>';


                  //  print_array($absensi_raw);
                  for ($b = 0; $b < count($absensi_raw); $b++) {

                    $absen_for = $absensi_raw[$b]->status;
                    $id       = $absensi_raw[$b]->id;
                    $pin       = $absensi_raw[$b]->pin;


                    if ($absen_for == 0) {
                      $flag = '<span class="badge bg-success-subtle text-success">MSK</span>';
                      $change_to = 1;
                    } else {
                      $flag = '<span class="badge bg-danger-subtle text-danger">KEL</span>';
                      $change_to = 0;
                    }


                    $date = $absensi_raw[$b]->tanggal;
                    $tanggal = format_view($date);

                    if ($initial_date <> $tanggal) {
                      echo '
                                                <tr class="bg-light">
                                                    <td colspan="2" style="text-align:left" class="badge bg-info-subtle text-info"">
                                                    <strong>' . format_full($tanggal) . '</strong>

                                                    </td>
                                                <td  colspan="2" > </td>
                                                </tr>';
                    }



                    // hapus_absen


                    echo '
                                                <tr id="row' . $id . '">
                                                        <td align="center">' . date('H:i:s', strtotime($absensi_raw[$b]->tanggal)) . '</td>
                                                        <td align="center" id="td_' . $id . '">' . $flag . '</td>
                                                        <td align="center">
                                                            <button type="button" value="' . $id . '" class="btn btn-xs btn-info">Ubah</button>
                                                            <button type="button" value="' . $id . '" class="btn btn-xs btn-danger delete_raw_absen">Hapus</button>
                                                    </td>


                                                    </tr> ';

                    $initial_date = $tanggal;
                  }
                  ?>

                </tbody>
              </table>
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


  $(".input_absen_manual").click(function() {
    var tanggal = $(this).val();

    $("#tgl_absensi").val(tanggal);


  });
</script>

</html>