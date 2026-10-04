<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">


  <style>
    table {
      width: 100%;
    }

    body {
      background-color: #F8F8F8;
    }

    .badge-status-cuti {
      padding: 2px 10px;
      text-align: center;
      color: #FFF;
      font-size: 12px;
      border-radius: 5px;
    }

    .bg-amber {
      background-color: #ffe26b;
      color: #cb871b;
    }

    .table-absensi th {
      border: 1px solid #EEE;
      padding: 5px 10px;
      text-align: center;
      font-size: 15px;
    }

    .table-absensi td {
      border: 1px solid #EEE;
      padding: 5px 10px;
      text-align: center;
      font-size: 14px;
      color: #333
    }

    .btn-hover-show {
      border: none;
      color: #FFF;
      background: #FFF;
    }

    .btn-hover-show:hover {
      border: none;
      color: blue;
      background: #F8F8F8;
    }

    .btn-md {
      font-size: 13px;
      padding: 6px 12px;
    }

    .hover-show {
      color: #FFF;
    }

    .hover-show:hover {
      color: #F00;
    }

    .btn-light {
      background: #F8F8F8;
      color: #666;
    }

    .btn-light:hover {
      background: #ebe8e8;
      color: #333;
    }

    .btn-primary {
      background: #3e74eb;
    }

    .btn-primary:hover {
      background: #295ac5;
    }

    .btn-borderless {
      background: none;
      border: none;
    }

    .popup-click {
      width: 500px;
      height: auto;
      position: fixed;
      background: #FFF;
      z-index: 999;
      margin-left: 15%;
      margin-top: 10%;
      padding: 20px;
      display: none;
      box-shadow: -2px 8px 23px 5px rgba(204, 204, 204, 0.75);
      -webkit-box-shadow: -2px 8px 23px 5px rgba(204, 204, 204, 0.75);
      -moz-box-shadow: -2px 8px 23px 5px rgba(204, 204, 204, 0.75);

    }

    .btn-close-shift {
      position: absolute;
      right: 10px;
      top: 10px;
      cursor: pointer;
    }

    .btn-close-shift:hover {
      color: #900;
    }

    .btn-shft {
      width: 80px;
      padding: 5px;
      display: inline-block;
      text-align: center;
      font-size: 12px;
      color: #FFF;
      -webkit-transition: all 0.3s;
      -moz-transition: all 0.3s;
      transition: all 0.3s;
      border: none;
    }

    .new-btn {

      border: none;
      color: #FFF;
      padding: 8px 10px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      font-size: 13px;
      margin: 4px 2px;
      cursor: pointer;
      border-radius: 2px;
    }

    .btn-warning-light{
      background: #f0b73b;
    }
    
    .btn-warning-light:hover{
      background: #f5af18;
    }

    .btn-info-light {
      background: #2eafeb
    }

    .btn-info-light:hover {
      background: skyblue !important;
    }


    .btn-success-outline {
      border: 1px solid #1ae288;
      color: #19cd7c;
    }

    .btn-success-outline:hover {
      border: 1px solid #19cd7c;
      color: #19cd7c;
    }

    .btn-success {
      background: #19cd7c;
    }

    .btn-warning {
      background: #F8F8F8;
      border: 1px solid #DDDDDD;
    }

    .btn-warning:hover {
      border: 1px solid #f3bb14;
      background: #F8F8F8;
    }

    .btn-danger {
      background: #f98282;
    }

    .btn-danger:hover {
      background: #19cd7c;
    }

    .btn-shift {
      background-color: #ECFFEA;
    }

    .badge-danger-lighten {
      background-color: #FCE3E7 !important;
      color: #900;
    }

    .badge-warning-lighten {
      background-color: #FCF1E3 !important;
      color: #f3bb14;
    }
    .btn-border{
      border: 1px solid #EEE;
      background: #FFF;
      color: #333;
    }

    .btn-border:hover{
       border: 1px solid #19cd7c;
      background: #F8F8F8;
      color: #19cd7c;
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
        <!-- ---------------------------------- -->

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
      $filter = $this->session->userdata('filter_presensi');
      $periode       = $filter['periode'];
      $id_validator  = $filter['id_validator'];
 

      $tahun = date('Y', strtotime($periode));
      $bulan = date('m', strtotime($periode));

      $nm_bulan = getBulan($bulan);
      $periode = $tahun . '-' . $bulan;
      $periode = date('Y-m', strtotime($periode));


      $lastDate = date('t', strtotime($periode)) + 1;

      $id_pegawai = $this->uri->segment(4);
      $pin = $this->uri->segment(5);

      $nip = $data_pegawai[0]->nip;
      $shift = $jns_jam_kerja = $data_pegawai[0]->jns_jam_kerja;
      $nama_pegawai = $data_pegawai[0]->nama;
      $id_puskesmas = $data_pegawai[0]->id_puskesmas;
     // $pin = $data_pegawai[0]->pin;

      $puskesmas = $this->Presensi_model->getNamaPuskesmas($id_puskesmas);
      $message = $this->session->flashdata('message');

      $grouped = [];

      if (!empty($absensiRaw)) {
        foreach ($absensiRaw as $row) {
          $tanggal = date('Y-m-d', strtotime($row->tanggal));
          $grouped[$tanggal][] = $row;
        }
      }


      ?>

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Absensi Pegawai</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="<?php echo base_url(); ?>admin/dashboard/index">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Absensi Pegawai</li>

                    </ol>
                  </nav>
                </div>

              </div>


            </div>


          

            <div class="popup-click">
              <form action="<?php echo base_url(); ?>admin/presensi/update_shift_harian/<?php echo $pin . '/' . $id_pegawai; ?>" method="post">
                <h4>Edit Shift</h4>
                <span class="btn-close-shift"> <i class="ti ti-x me-1 fs-4"></i></span></span>
                <h6>Tanggal : <span class="tanggal-shift"> </h6>
                <br>
                <input type="hidden" name="tgl_shift" value="" id="tgl_shift">
                <?php
                for ($s = 0; $s < count($data_shift_kerja); $s++) {
                  if ($data_shift_kerja[$s]->kode_shift == 'OFF') {
                    $btn_shift = ' btn-danger';
                  } else if ($data_shift_kerja[$s]->kode_shift == 'L-OFF') {
                    $btn_shift = ' btn-warning';
                  } else {
                    $btn_shift = ' btn-info';
                  }
                  echo '<button type="submit" name="shift" value="' . $data_shift_kerja[$s]->kode_shift . '" class="btn-shft ' . $btn_shift . ' m-1">' . $data_shift_kerja[$s]->kode_shift . '</button>';
                }

                ?>
              </form>
            </div>


          </div>

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-lg-9 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <div class="col-md-12  my-4">
                    <h4>
                      <?php echo $nama_pegawai; ?>
                      <a href="<?php echo base_url(); ?>admin/presensi/edit_data_pegawai/<?php echo $pin . '/' . $id_pegawai; ?>" class="text-primary" title="edit data pegawai">
                        <i class="fas fa-edit"></i>
                      </a>
                      <br>
                      <span class="text-muted fs-3"><?php echo $nip; ?></span> <br>
                      <span class="text-muted fs-3">ID USER Mesin Absensi :</span> <strong class="text-warning"> <?php echo $pin; ?></strong>

                    </h4>

                    <small><?php echo $puskesmas; ?></small>
                    <?php

                    if ($shift == 1) {
                      echo '<span class="badge bg-info-subtle text-info">Shift</span>';
                    }
                    ?>
                    <br>
                    Periode : <strong> <?php echo date('F Y', strtotime($periode)); ?> </strong>


                  </div>





                  <div class="row">
                    <div class="col-md-4">
                                              <!-- Tombol Action Utama -->
                        <a href="<?php echo base_url('admin/presensi/index'); ?>" class="flat-btn btn-border fs-3 px-4 py-2 mb-3 me-2">
                          <i class="fas fa-arrow-left"></i> &nbsp; Kembali
                        </a>

                        <a href="<?php echo base_url('admin/presensi/edit_shift/' . $pin . '/' . $id_pegawai); ?>" class="flat-btn btn-warning text-danger fs-3 px-4 py-2 mb-3 me-2">
                          <i class="fas fa-pencil"></i> &nbsp;Edit Shift
                        </a>

                    </div>
                    <div class="col-md-8 text-end">

                    
                        <a href="<?php echo base_url('admin/presensi/generate_shift/' . $pin . '/' . $id_pegawai . '/' . $jns_jam_kerja . '/' . $periode); ?>" class="flat-btn btn-info-light fs-3 px-4 py-2 mb-3 me-1">
                          <i class="fas fa-refresh"></i> &nbsp;Generate Shift
                        </a>
                        
                     <a href="<?php echo base_url('admin/presensi/update_data_rekap/' . $pin . '/' . $id_pegawai); ?>" 
                          id="btn-update-rekap"
                          class="flat-btn btn-success fs-3 px-4 py-2 mb-3 me-2">
                          <i class="fas fa-sync-alt icon-status"></i> &nbsp;<span class="btn-text">Update</span>
                        </a>

                        <!-- TOMBOL CETAK ABSENSI BARU (Buka di Tab Baru) -->
                        <a href="<?php echo base_url('admin/presensi/cetak_absensi/' . $pin . '/' . $id_pegawai . '/' . $periode); ?>" target="_blank" class="flat-btn btn-light fs-3 px-4 py-2 mb-3 me-2">
                          <i class="fas fa-print"></i> &nbsp;Cetak Absensi
                        </a>


                    </div>
                  </div>

                  


                  <div class="clearfix"></div>
                  <div class="table-responsive mt-4">
                    <table class="table-absensi table-sm">
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

                        $tgl_now = date('Y-m-d');

                        $totalTelat = 0;
                        $totalPawal = 0;

                        $totalIzin = 0;
                        $totalSakit = 0;
                        $totalCuti = 0;


                        $absensiHarian  = $this->Presensi_model->getAbsensiPegawai($pin, $periode);
                        // print_array($absensiHarian);

                        $tgl_now = date('Y-m-d');

                        $totalTelat = 0;
                        $totalPawal = 0;

                        $totalIzin = 0;
                        $totalSakit = 0;
                        $totalCuti = 0;


                        //   for ($t = 1; $t < $lastDate; $t++) {
                        //       $tanggal = $periode . '-' . $t;
                        //       $formatDate = date('Y-m-d', strtotime($tanggal));
                        //       $day = date('l', strtotime($tanggal));
                        //       $hari = getNamahari($tanggal);

                        //$absensiHarian  = $this->Presensi_model->getDataAbsensi($pin, $formatDate);
                        $tgl = 0;
                        for ($t = 0; $t < count($absensiHarian); $t++) {

                          $id         = $absensiHarian[$t]->id;
                          $tanggal         = $absensiHarian[$t]->tanggal;
                          $kodeShift         = $absensiHarian[$t]->shift;
                          $jamMasukKerja     = $absensiHarian[$t]->jam_masuk;
                          $jamKeluarKerja    = $absensiHarian[$t]->jam_pulang;

                          $absenMasuk         = $absensiHarian[$t]->masuk;
                          $absenPulang        = $absensiHarian[$t]->pulang;
                          $keterangan_absen   = $absensiHarian[$t]->keterangan;

                          $telat         = $absensiHarian[$t]->telat;
                          $p_awal         = $absensiHarian[$t]->p_awal;

                          $hari = getNamahari($tanggal);


                          $formatDate = format_db($tanggal);
                          $dataModelAbsensi = $this->Presensi_model->modelDataAbsensi($pin, $id_pegawai, $id, $jns_jam_kerja, $hari, $absenMasuk, $absenPulang, $jamMasukKerja, $jamKeluarKerja, $formatDate, $kodeShift);
                          $bg_btn = $dataModelAbsensi[0];
                          $absenMasuk = $dataModelAbsensi[1];
                          $absenPulang = $dataModelAbsensi[2];




                          $totalTelat = $totalTelat + $telat;
                          $totalPawal = $totalPawal + $p_awal;



                          $tgl = $tgl + 1;

                          echo '  <tr>
                                              <td class="text-center">' . $tgl . '         </td>
                                              <td class="text-center">' . $hari . '</td>
                                              <td id="tr_' . $t . '" class="text-center">
                                              <button type="button" class="btn-shift  fs-2 ' . $bg_btn . '  change-shift" value="' . format_view($tanggal) . '">' . $kodeShift . '</button> </td>


                                              <td class="text-darkblue text-center">' . $jamMasukKerja  . '</td>
                                              <td class="text-red  text-center">' . $jamKeluarKerja . '</td>
                                              <td class="text-center">' . $absenMasuk;
                          if ($absenMasuk == '') {
                            echo '<button class="btn-hover-show"  value="' . format_view($tanggal) . '" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg"><i class="fa-solid fa-pencil"></i></button>';
                          } else {
                            echo '<a href="' . base_url() . 'admin/presensi/delete_absensi/' . $tanggal . '/' . $pin . '/' . $id_pegawai . '/0" class="float-end hover-show"><i class="fa-solid fa-trash"></i></a>';
                          }

                          echo '</td>
                                              <td class="text-center" class="td-jam-absen">' . $absenPulang;

                          if ($absenPulang != '') {
                            echo '<a href="' . base_url() . 'admin/presensi/delete_absensi/' . $tanggal . '/' . $pin . '/' . $id_pegawai . '/1" class="float-end hover-show"><i class="fa-solid fa-trash"></i>  </a>';
                          } else {
                            echo '<button class="btn-hover-show"  value="' . format_view($tanggal) . '" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg"><i class="fa-solid fa-pencil"></i></button>';
                          }


                          echo '</td>
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
                          <td></td>

                        </tr>
                      </tbody>
                    </table>
                  </div>

                </div>

              </div>
            </div>

            <div class="col-lg-3">
              <div class="card shadow-sm border-0">

                <div class="card-body p-4">

                  <h4 class="mb-4 fw-semibold">Detail Presensi Pegawai</h4>

                  <!-- ================== REKAP ABSEN ================== -->
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center cursor-pointer" data-bs-toggle="collapse" data-bs-target="#rekapAbsen" style="cursor: pointer;">

                      <h6 class="mb-0 fw-semibold text-primary">Rekap Absensi</h6>
                      <i class="ti ti-chevron-down"></i>
                    </div>

                    
                    <div class="collapse show mt-3" id="rekapAbsen">
                      <?php if (!empty($dataRekap)) :

                        $rekap  = $dataRekap[0];
                        $id_rekap = $rekap->id;
                        $status = $rekap->status;
                      ?>


                        <?php if ($status == 0) : ?>
                          <span class="badge text-warning w-100 px-3 py-2">
                            <i class="ti ti-alert-circle"></i>Absensi Belum Sesuai
                          </span>
                        <?php else : ?>
                          <span class="badge  text-success w-100 px-3 py-2">
                            <i class="ti ti-check"></i>Absensi Sudah Sesuai
                          </span>
                        <?php endif; ?>

                        <!-- Button -->
                        <?php if ($status == 0) : ?>
                          <div class="text-end mt-3">
                            <a href="<?= base_url('admin/presensi/check_ok/' . $pin . '/' . $id_pegawai . '/' . $id_rekap); ?>" class="new-btn btn-success-outline btn-sm px-4 float-end">
                              <i class="ti ti-check"></i> Check Sesuai
                            </a>
                          </div>
                        <?php endif; ?>

                        <div class="clearfix"></div>

                        <div class="row mb-2 mt-4">
                          <div class="col-6 text-muted">Telat</div>
                          <div class="col-6 text-end fw-medium"><?= $rekap->telat ?> menit</div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-6 text-muted">Pulang Awal</div>
                          <div class="col-6 text-end"><?= $rekap->pulang_awal ?> menit</div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-6 text-muted">Sakit</div>
                          <div class="col-6 text-end"><?= $rekap->sakit ?> hari</div>
                        </div>

                        <div class="row mb-2">
                          <div class="col-6 text-muted">Izin</div>
                          <div class="col-6 text-end"><?= $rekap->izin ?> hari</div>
                        </div>

                        <div class="row mb-3">
                          <div class="col-6 text-muted">Cuti</div>
                          <div class="col-6 text-end"><?= $rekap->cuti ?> hari</div>
                        </div>


                      <?php else : ?>


                        <div class="alert alert-warning text-center">
                          <i class="ti ti-alert-triangle"></i> Data Absensi belum direkap
                        </div>

                      <?php endif; ?>

                 

                      
                  


                      <div class="clearfix"></div>
                    </div>
                  </div>

                  <hr>

                  <!-- ================== DATA CUTI ================== -->
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#dataCuti" style="cursor: pointer;">

                      <h6 class="mb-0 fw-semibold text-success">Data Cuti</h6>
                      <i class="ti ti-chevron-down"></i>
                    </div>

                    <div class="collapse mt-3" id="dataCuti">
                      <?php if (!empty($dataCuti)) : ?>
                        <?php foreach ($dataCuti as $cuti) : ?>
                          <div class="p-2 mb-3 border-0 border-bottom">
                            <div>

                              <!-- Header -->
                              <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="mb-0 fw-semibold">
                                  <?= $cuti->jenis_cuti ?>
                                </h5>

                                <span class="badge-status-cuti <?php echo $cuti->status_akhir == 'disetujui' ? 'bg-success' : ($cuti->status_akhir == 'ditolak' ? 'bg-danger' : 'bg-amber'); ?>">
                                  <?= ucfirst($cuti->status_akhir) ?>
                                </span>
                              </div>

                              <!-- Detail -->
                              <div class="row mb-2">
                                <div class="col-5 text-muted">Tanggal Cuti</div>
                                <div class="col-7 text-end fw-medium">
                                  <?= format_periode_cuti($cuti->tgl_mulai, $cuti->tgl_selesai); ?>
                                </div>
                              </div>

                              <div class="row mb-2">
                                <div class="col-5 text-muted">Lama Cuti</div>
                                <div class="col-7 text-end">
                                  <?= $cuti->lama_cuti ?> hari
                                </div>
                              </div>

                              <div class="row mb-3">
                                <div class="col-5 text-muted">Alasan</div>
                                <div class="col-7 text-end">
                                  <?= $cuti->alasan_cuti ?>
                                </div>
                              </div>

                              <!-- Button -->
                              <div class="text-end">
                                <a href="<?= base_url('admin/presensi/sinkron_to_absensi/' . $cuti->id . '/' . $pin . '/' . $periode) ?>" class="btn btn-sm btn-info px-4">
                                  Update Absensi
                                </a>
                              </div>

                            </div>
                          </div>
                        <?php endforeach; ?>
                      <?php else : ?>
                        <div class="text-center text-muted py-4">
                          Tidak ada data cuti.
                        </div>
                      <?php endif; ?>
                    </div>
                  </div>

                  <hr>

                  <!-- ================== IZIN / SAKIT ================== -->
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#izinSakit" style="cursor: pointer;">

                      <h6 class="mb-0 fw-semibold text-warning">Data Izin / Sakit</h6>
                      <i class="ti ti-chevron-down"></i>
                    </div>

                    <div class="collapse mt-3" id="izinSakit">
                      <!--<div class="row mb-2">
                                    <div class="col-6 text-muted">15 Jan 2026</div>
                                    <div class="col-6 text-end">Sakit</div>
                                </div>
                                <div class="row">
                                    <div class="col-6 text-muted">18 Jan 2026</div>
                                    <div class="col-6 text-end">Izin</div>
                                </div>-->
                    </div>
                  </div>

                  <hr>

                  <!-- ================== DINAS LUAR ================== -->
                  <div class="mb-3">
                    <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#dinasLuar" style="cursor: pointer;">

                      <h6 class="mb-0 fw-semibold text-info">Data Dinas Luar</h6>
                      <i class="ti ti-chevron-down"></i>
                    </div>
                    <!-- 
                              [id] => 3131
            [id_pegawai] => 108
            [tanggal] => 2026-01-09
            [jns_dl] => DLP
            [surtug] => 
            [photo] => ega_utami_amdgz_202601090551.jpg
            [keterangan] => Tagging Anggaran Website Aksi Bangda
            [lat] => -6.120232899456552
            [lon] => 106.89191746137197
            [status] => 1
             -->
                    <div class="collapse mt-3" id="dinasLuar">

                      <?php
                      if ($pengajuan_dinas_luar != null) {

                        //print_array($pengajuan_dinas_luar);
                        foreach ($pengajuan_dinas_luar as $dl) {
                          $status = $dl->status == 1 ? '<span class="badge bg-success-subtle text-success">Disetujui</span>' : '<span class="badge bg-warning-subtle text-danger">Pending</span>';

                      ?>


                          <div class="row mb-2 border-0 border-bottom pb-2">
                            <div class="col-6 text-dark"><?= format_hari($dl->tanggal) ?>, <?= format_tanggal_indo($dl->tanggal) ?></div>
                            <div class="col-6 text-end"><?= $status ?></div>
                            <div class="col-12  mb-2">
                              <div class="text-info"> <?= $dl->jns_dl ?></div>
                              <div class="text-muted"> <?= $dl->keterangan ?></div>

                            </div>
                            <div class="col-12">

                              <a href="<?php echo base_url('admin/presensi/sinkron_dinas_luar/' . $dl->id . '/' . $id_pegawai . '/' . $pin); ?>" class="flat-btn btn-md btn-info float-end ms-2">
                                <i class="fas fa-sync"></i> Sinkron</a>
                              <a href="<?php echo base_url('admin/presensi/detail_dinas_luar/' . $dl->id); ?>" class="flat-btn btn-md btn-light  float-end">
                                <i class="fas fa-external-link-alt"></i> Detail</a>
                            </div>
                          </div>

                        <?php
                        }
                      } else { ?>
                        <div class="text-center text-muted py-4">
                          Tidak ada dinas luar
                        </div>


                      <?php } ?>
                    </div>


                  </div>

                  <hr>

                  <!-- ================== ABSENSI RAW ================== -->
                  <div>
                    <div class="d-flex justify-content-between align-items-center" data-bs-toggle="collapse" data-bs-target="#absensiRaw" style="cursor: pointer;">

                      <h6 class="mb-0 fw-semibold text-danger">Data Absensi Raw</h6>
                      <i class="ti ti-chevron-down"></i>
                    </div>

                    <div class="collapse mt-3" id="absensiRaw">
                      <?php if (!empty($grouped)) : ?>

                        <?php foreach ($grouped as $tgl => $records) : ?>
                          <!-- Tanggal -->
                          <h6 class="fw-semibold mb-3">
                            <?= format_tanggal_indo($tgl); ?>
                          </h6>

                          <?php foreach ($records as $absen) :
                            $jam = date('H:i', strtotime($absen->tanggal));

                            $isPulang = ($absen->status == 1);
                          ?>

                            <div class="row mb-2">
                              <div class="col-6 text-muted"> <?= $jam ?></div>
                              <div class="col-6 text-end">
                                <?php if ($isPulang) : ?>
                                  <span class="badge bg-danger-subtle text-danger">
                                    Pulang
                                  </span>
                                <?php else : ?>
                                  <span class="badge bg-success-subtle text-success">
                                    Masuk
                                  </span>
                                <?php endif; ?>
                              </div>
                            </div>

                          <?php endforeach; ?>

                        <?php endforeach; ?>

                      <?php else : ?>

                        <div class="alert alert-warning text-center">
                          Tidak ada data absensi.
                        </div>

                      <?php endif; ?>



                    </div>
                  </div>

                </div>
              </div>


            </div><!--row-->


            <?php
            $arrayAbsen = ['DL-PENUH', 'DL-AWAL', 'DL-AKHIR', 'IZIN', 'SAKIT', 'SAKIT DGN SURAT'];
            ?>

            <div class="modal fade" id="edit-absensi" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <form action="<?= base_url('admin/presensi/insert_absen_ketidakhadiran/' . $pin . '/' . $id_pegawai) ?>" method="post">

                    <div class="modal-header">
                      <h5 class="modal-title">Update Absensi Pegawai</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                      <!-- Hidden input -->
                      <input type="hidden" name="pin" id="modal_pin">
                      <input type="hidden" name="id_pegawai" id="modal_id_pegawai">
                      <input type="hidden" name="tanggal" id="modal_tanggal">

                      <!-- Nav Tabs -->
                      <ul class="nav nav-tabs" id="absensiTab" role="tablist">
                        <li class="nav-item" role="presentation">
                          <button class="nav-link active" id="manual-tab" data-bs-toggle="tab" data-bs-target="#manual" type="button">
                            Input Jam Manual
                          </button>
                        </li>

                        <li class="nav-item" role="presentation">
                          <button class="nav-link" id="status-tab" data-bs-toggle="tab" data-bs-target="#status" type="button">
                            Tidak Hadir / Dinas Luar
                          </button>
                        </li>
                      </ul>

                      <!-- Tab Content -->
                      <div class="tab-content mt-3">
                        <div class="mb-3">
                          <label class="form-label">Tanggal Absensi</label>
                          <input type="date" name="tanggal_display" id="modal_tanggal_display" class="form-control" readonly>
                        </div>


                        <!-- TAB 1 : INPUT JAM -->
                        <div class="tab-pane fade show active" id="manual">

                          <div class="row">
                            <div class="col-6">
                              <div class="mb-3">
                                <label class="form-label">Jam Masuk</label>
                                <input type="time" name="jam_masuk" class="form-control">
                              </div>

                            </div>
                            <div class="col-6">

                              <div class="mb-3">
                                <label class="form-label">Jam Pulang</label>
                                <input type="time" name="jam_pulang" class="form-control">
                              </div>
                            </div>
                          </div>



                          <small class="text-muted">
                            Isi salah satu atau keduanya jika mesin absensi tidak sinkron.
                          </small>

                        </div>

                        <!-- TAB 2 : STATUS -->
                        <div class="tab-pane fade" id="status">

                          <div class="mb-3">
                            <label class="form-label">Status Absensi</label>
                            <select name="status" class="form-select">
                              <option value="">-- Pilih Status --</option>
                              <?php foreach ($arrayAbsen as $status) : ?>
                                <option value="<?= $status ?>"><?= $status ?></option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea name="keterangan" class="form-control"></textarea>
                          </div>

                        </div>

                      </div>

                    </div>


                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Update</button>
                    </div>

                  </form>
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
        <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

        <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>


</body>


<script>
  var pesan = '<?php echo $message; ?>';
  if (pesan != '') {
    toastr.success(pesan, "Success!");
  }

  document.addEventListener('DOMContentLoaded', function() {

    const modal = document.getElementById('edit-absensi');

    modal.addEventListener('show.bs.modal', function(event) {

      const button = event.relatedTarget;
      const value = button.value;

      const data = value.split('/');

      const pin = data[0];
      const idPegawai = data[1];
      const tanggal = data[2];

      document.getElementById('modal_pin').value = pin;
      document.getElementById('modal_id_pegawai').value = idPegawai;
      document.getElementById('modal_tanggal').value = tanggal;

      // tampilkan ke input readonly
      document.getElementById('modal_tanggal_display').value = tanggal;

    });

  });


  $('#btn-update-rekap').on('click', function() {
    var $btn = $(this);
    
    // Ubah icon jadi spinner dan ubah teks
    $btn.find('.icon-status').attr('class', 'fas fa-spinner fa-spin icon-status');
    $btn.find('.btn-text').text('Memproses...');
    
    // Matikan klik lanjutan agar tidak double submit
    $btn.css({'pointer-events': 'none', 'opacity': '0.75'});
  });



  $(".change-shift").click(function() {
    var tanggal = $(this).val();
    $(".popup-click").show();
    $(".tanggal-shift").html(tanggal);
    $("#tgl_shift").val(tanggal);


  });

  $(".btn-close-shift").click(function() {
    $(".popup-click").hide();

  });


  $(".btn-delete-dl").click(function() {
    var tanggal = $(this).val();

    $("#footer-button").html('<br><a href="<?php echo base_url(); ?>admin/presensi/delete_absensi_dl/<?php echo $pin . '/' . $id_pegawai; ?>/' + tanggal + '" class="btn btn-success">Iya Hapus</a>');
  });
</script>

</html>