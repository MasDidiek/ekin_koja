<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">


  <style>

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
      $pin_mesin    = $data_pegawai[0]->id_mesin;

      // print_array($data_pegawai);
      // $pin = $data_pegawai[0]->pin;

      $jabatan = $data_pegawai[0]->jabatan;
      $puskesmas = $data_pegawai[0]->puskesmas;
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
          </div>

          <?php



          ?>
          <div class="card shadow position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">

              <!-- 1. INFORMASI PEGAWAI -->
              <div class="d-flex align-items-center justify-content-between pb-3 mb-4 border-bottom">
                <div>
                  <h4 class="fw-semibold mb-1"><?= $nama_pegawai; ?></h4>
                  <span class="badge bg-light-primary text-primary fw-medium mb-2">NIP: <?= isset($nip) ? $nip : '-'; ?></span>
                  <span>ID Mesin : <strong><?= $pin_mesin; ?></strong> </span>
                  <div class="d-flex align-items-center gap-3 text-muted fs-3">
                    <div><i class="ti ti-briefcase me-1"></i><?= $jabatan; ?></div>
                    <div>•</div>
                    <div><i class="ti ti-building me-1"></i><?= $puskesmas; ?></div>
                  </div>

                  Periode : <strong> <?php echo date('F Y', strtotime($periode)); ?> </strong>
                </div>
                <div>


                  <a href="<?php echo base_url(); ?>admin/presensi/update_data_rekap/<?php echo $pin . '/' . $id_pegawai . '/' . $periode; ?>" class="btn btn-outline-primary ">
                    <i class="fas fa-refresh"></i>
                    Update Rekap
                  </a>

                  <a href="<?php echo base_url('admin/presensi/cetak_absensi/' . $pin . '/' . $id_pegawai . '/' . $periode); ?>" target="_blank" class="btn btn-outline-secondary ">
                    <i class="ti ti-printer me-1"></i> Cetak Absensi
                  </a>

                  <a href="<?php echo base_url('admin/presensi/absensi_raw/' . $pin . '/' . $id_pegawai); ?>" id="btn-data-raw" class="btn btn-outline-info" style="display:none;">
                    <i class="ti ti-server me-1"></i> Data Raw Mesin
                  </a>

                  <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRiwayat" aria-controls="offcanvasRiwayat">
                    <i class="ti ti-history me-1"></i> Riwayat & Pengajuan
                  </button>

                </div>
              </div>
              <?php
              // Set default 0 lebih dulu
              $id_rekap   = null;
              $status = null;

              $rekap = null;

              // Timpa nilai jika data tersedia
              if (!empty($dataRekap)) {
                $rekap       = $dataRekap[0];
                $id_rekap   = $rekap->id;
                $status = $rekap->status;
              }

              //print_array($rekap);
              ?>



              <!-- 2. REKAP DATA ABSENSI (STATISTIK) -->
              <div class="row">
                <div class="col-md-4">
                  <!-- Tombol Action Utama -->
                  <a href="<?php echo base_url('admin/presensi/index'); ?>" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i> &nbsp; Kembali
                  </a>

                  <a href="<?php echo base_url('admin/presensi/edit_shift/' . $pin . '/' . $id_pegawai); ?>" class="btn btn-warning text-white">
                    <i class="fas fa-pencil"></i> &nbsp;Edit Shift
                  </a>

                </div>
                <div class="col-md-8 text-end">

                  <div class="text-end">

                    <?php if ($status == 0) : ?>
                      <span class="p-3 border rounded text-center bg-warning bg-opacity-10 float-start">
                        <i class="ti ti-alert-circle"></i>Absensi Belum Sesuai
                      </span>
                    <?php else : ?>
                      <span class="p-3 border rounded text-center bg-warning bg-opacity-10 float-start">
                        <i class="ti ti-check"></i>Absensi Sudah Sesuai
                      </span>
                    <?php endif; ?>

                    <?php if ($status == 0) : ?>

                      <a href="<?= base_url('admin/presensi/check_ok/' . $pin . '/' . $id_pegawai . '/' . $id_rekap); ?>" class="btn btn-info ">
                        <i class="ti ti-check"></i> Check Sesuai
                      </a>
                    <?php endif; ?>
                    <div class="clearfix"></div>
                    <br>
                  </div>


                  <a href="<?php echo base_url('admin/presensi/generate_shift/' . $pin . '/' . $id_pegawai . '/' . $jns_jam_kerja . '/' . $periode); ?>" class="btn btn-info">
                    <i class="fas fa-refresh btn-icon"></i> &nbsp;<span class="btn-text">Update Shift</span>
                  </a>
                </div>


                <div class="col-md-6">
                  <h5 class="card-title fw-semibold mb-3">Ringkasan Kehadiran</h5>

                </div>
                <div class="col-md-6">



                  <!-- Button -->

                </div>
              </div>


              <div class="row g-3">
                <!-- Terlambat -->
                <div class="col-6 col-md-4 col-lg-2">
                  <div class="p-3 border rounded text-center bg-warning bg-opacity-10">
                    <span class="text-warning d-block mb-1 fs-6 fw-bold">Terlambat</span>
                    <h3 class="mb-0 fw-semibold text-warning" id="summary_telat"><?= isset($rekap->telat) ? $rekap->telat : 0; ?></h3>
                    <small class="text-muted">Menit</small>
                  </div>
                </div>

                <!-- Pulang Awal -->
                <div class="col-6 col-md-4 col-lg-2">
                  <div class="p-3 border rounded text-center bg-danger bg-opacity-10">
                    <span class="text-danger d-block mb-1 fs-6 fw-bold">Pulang Awal</span>
                    <h3 class="mb-0 fw-semibold text-danger" id="summary_pawal"><?= isset($rekap->pulang_awal) ? $rekap->pulang_awal : 0; ?></h3>
                    <small class="text-muted">Menit</small>
                  </div>
                </div>

                <!-- Izin -->
                <div class="col-6 col-md-4 col-lg-2">
                  <div class="p-3 border rounded text-center bg-info bg-opacity-10">
                    <span class="text-info d-block mb-1 fs-6 fw-bold">Izin</span>
                    <h3 class="mb-0 fw-semibold text-info"><?= isset($rekap->izin) ? $rekap->izin : 0; ?></h3>
                    <small class="text-muted">Hari</small>
                  </div>
                </div>

                <!-- Sakit -->
                <div class="col-6 col-md-4 col-lg-2">
                  <div class="p-3 border rounded text-center bg-primary bg-opacity-10">
                    <span class="text-primary d-block mb-1 fs-6 fw-bold">Sakit</span>
                    <h3 class="mb-0 fw-semibold text-primary"><?= isset($rekap->sakit) ? $rekap->sakit : 0; ?></h3>
                    <small class="text-muted">Hari</small>
                  </div>
                </div>

                <!-- Cuti -->
                <div class="col-6 col-md-4 col-lg-2">
                  <div class="p-3 border rounded text-center bg-success bg-opacity-10">
                    <span class="text-success d-block mb-1 fs-6 fw-bold">Cuti</span>
                    <h3 class="mb-0 fw-semibold text-success"><?= isset($rekap->cuti) ? $rekap->cuti : 0; ?></h3>
                    <small class="text-muted">Hari</small>
                  </div>
                </div>

                <!-- Alpa -->
                <div class="col-6 col-md-4 col-lg-2">
                  <div class="p-3 border rounded text-center bg-secondary bg-opacity-10">
                    <span class="text-dark d-block mb-1 fs-6 fw-bold">Alpa / Alpha</span>
                    <h3 class="mb-0 fw-semibold text-dark"><?= isset($rekap->alpha) ? $rekap->alpha : 0; ?></h3>
                    <small class="text-muted">Hari</small>
                  </div>
                </div>
              </div>

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


              ?>
              <div class="table-responsive mt-4">
                <table class="table table-bordered table-hover align-middle">
                  <thead class="table-light text-center">
                    <tr>
                      <th rowspan="2" class="align-middle">Tgl</th>
                      <th rowspan="2" class="align-middle">Hari</th>
                      <th rowspan="2" class="align-middle">Shift</th>
                      <th colspan="2">Jam Kerja Standar</th>
                      <th colspan="2">Jam Absen Realisasi</th>
                      <th rowspan="2" class="align-middle">Telat</th>
                      <th rowspan="2" class="align-middle">P. Awal</th>
                      <th rowspan="2" class="align-middle">Keterangan</th>
                    </tr>
                    <tr>
                      <th>Masuk</th>
                      <th>Pulang</th>
                      <th>Masuk</th>
                      <th>Pulang</th>
                    </tr>
                  </thead>
                  <tbody class="text-center">
                    <?php
                    for ($t = 0; $t < count($absensiHarian); $t++) {

                      $id               = $absensiHarian[$t]->id;
                      $tanggal          = $absensiHarian[$t]->tanggal;
                      $kodeShift        = $absensiHarian[$t]->shift;
                      $jamMasukKerja    = $absensiHarian[$t]->jam_masuk;
                      $jamKeluarKerja   = $absensiHarian[$t]->jam_pulang;

                      $absenMasuk       = $absensiHarian[$t]->masuk;
                      $absenPulang      = $absensiHarian[$t]->pulang;
                      $keterangan_absen = $absensiHarian[$t]->keterangan;

                      $telat            = $absensiHarian[$t]->telat;
                      $p_awal           = $absensiHarian[$t]->p_awal;

                      if ($kodeShift == 'OFF') {
                        $jamMasukKerja    = '-';
                        $jamKeluarKerja   = '-';
                      }

                      $hari = getNamahari($tanggal);

                      // 1. Logika Warna Badge Shift
                      $badgeShiftClass = 'bg-success bg-opacity-10 text-success'; // Default shift biasa
                      if ($kodeShift == 'L-OFF') {
                        $badgeShiftClass = 'bg-warning bg-opacity-10 text-warning';
                      } elseif ($kodeShift == 'OFF') {
                        $badgeShiftClass = 'bg-danger bg-opacity-10 text-danger';
                      }


                      $totalTelat = $totalTelat + $telat;
                      $totalPawal = $totalPawal + $p_awal;

                    ?>
                      <tr>
                        <td class="text-center fw-bold"><?= date('d', strtotime($tanggal)); ?></td>
                        <td class="text-center"><?= $hari; ?></td>

                        <!-- Shift dengan Warna Dinamis -->
                        <td class="text-center">
                          <span class="badge <?= $badgeShiftClass; ?> fw-semibold">
                            <?= $kodeShift; ?>
                          </span>
                        </td>

                        <td class="text-center text-muted"><?= $jamMasukKerja; ?></td>
                        <td class="text-center text-muted"><?= $jamKeluarKerja; ?></td>

                        <!-- Jam Absen Masuk + Tombol Hapus/Edit -->
                        <td class="text-center">
                          <?php if (!empty($absenMasuk)) : ?>
                            <span class="real-time-text" id="time_text_masuk_<?= $id; ?>"><?= $absenMasuk; ?></span>
                            <input type="time" class="real-time-input form-control form-control-sm mx-auto" id="time_input_masuk_<?= $id; ?>" value="<?= $absenMasuk; ?>" style="display:none; max-width: 120px;" data-id="<?= $id; ?>" data-type="masuk" step="1">
                            <a href="<?= base_url() . 'admin/presensi/delete_absensi/' . $tanggal . '/' . $pin . '/' . $id_pegawai . '/0'; ?>" class="text-danger ms-1 real-time-text" title="Hapus Jam Masuk"><i class="ti ti-trash"></i></a>
                          <?php else : ?>
                            <!-- Button Trigger Modal -->
                            <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-1 btn-edit-absen" data-bs-toggle="modal" data-bs-target="#edit-absensi" data-id="<?= $id; ?>" data-pin="<?= $pin; ?>" data-pegawai="<?= $id_pegawai; ?>" data-tanggal="<?= $tanggal; ?>" data-type="masuk" title="Input Jam Masuk">
                              <i class="ti ti-pencil"></i>
                            </button>
                          <?php endif; ?>
                        </td>

                        <!-- Jam Absen Pulang -->
                        <td class="text-center">
                          <?php if (!empty($absenPulang)) : ?>
                            <span class="real-time-text" id="time_text_pulang_<?= $id; ?>"><?= $absenPulang; ?></span>
                            <input type="time" class="real-time-input form-control form-control-sm mx-auto" id="time_input_pulang_<?= $id; ?>" value="<?= $absenPulang; ?>" style="display:none; max-width: 120px;" data-id="<?= $id; ?>" data-type="pulang" step="1">
                            <a href="<?= base_url() . 'admin/presensi/delete_absensi/' . $tanggal . '/' . $pin . '/' . $id_pegawai . '/1'; ?>" class="text-danger ms-1 real-time-text" title="Hapus Jam Pulang"><i class="ti ti-trash"></i></a>
                          <?php else : ?>
                            <!-- Button Trigger Modal -->
                            <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-1 btn-edit-absen" data-bs-toggle="modal" data-bs-target="#edit-absensi" data-id="<?= $id; ?>" data-pin="<?= $pin; ?>" data-pegawai="<?= $id_pegawai; ?>" data-tanggal="<?= $tanggal; ?>" data-type="pulang" title="Input Jam Pulang">
                              <i class="ti ti-pencil"></i>
                            </button>
                          <?php endif; ?>
                        </td>

                        <!-- Telat (Tegas jika > 0, Muted jika 0) -->
                        <td class="text-center" id="telat_<?= $id; ?>">
                          <?php if ($telat > 0) : ?>
                            <span class=" text-danger fw-bold"><?= $telat; ?></span>
                          <?php else : ?>
                            <span class="text-muted">0</span>
                          <?php endif; ?>
                        </td>

                        <!-- Pulang Awal (Tegas jika > 0, Muted jika 0) -->
                        <td class="text-center" id="p_awal_<?= $id; ?>">
                          <?php if ($p_awal > 0) : ?>
                            <span class=" text-danger fw-bold"><?= $p_awal; ?></span>
                          <?php else : ?>
                            <span class="text-muted">0</span>
                          <?php endif; ?>
                        </td>

                        <td><?= !empty($keterangan_absen) ? $keterangan_absen : '-'; ?></td>
                      </tr>
                    <?php } ?>

                    <tr>
                      <td colspan="7"></td>
                      <td><?php echo $totalTelat; ?></td>
                      <td><?php echo $totalPawal; ?></td>

                      <td></td>

                    </tr>
                  </tbody>
                </table>
              </div>



            </div>
          </div>



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


          <!-- OFFCANVAS RIGHT -->
          <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRiwayat" aria-labelledby="offcanvasRiwayatLabel" style="width: 450px;">
            <div class="offcanvas-header border-bottom">
              <h5 class="offcanvas-title fw-semibold" id="offcanvasRiwayatLabel">
                <i class="ti ti-history me-1"></i> Riwayat & Pengajuan
              </h5>
              <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>

            <div class="offcanvas-body p-0">

              <!-- NAV TABS -->
              <ul class="nav nav-tabs nav-fill border-bottom bg-light" id="riwayatTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active py-2 fs-2" id="log-tab" data-bs-toggle="tab" data-bs-target="#tab-log" type="button">Log</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link py-2 fs-2" id="cuti-tab" data-bs-toggle="tab" data-bs-target="#tab-cuti" type="button">Cuti</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link py-2 fs-2" id="izin-tab" data-bs-toggle="tab" data-bs-target="#tab-izin" type="button">Izin/Sakit</button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link py-2 fs-2" id="dl-tab" data-bs-toggle="tab" data-bs-target="#tab-dl" type="button">DL</button>
                </li>
              </ul>

              <!-- TAB CONTENT -->
              <div class="tab-content p-3" id="riwayatTabContent">

                <!-- 1. TAB LOG ABSENSI -->
                <div class="tab-pane fade show active" id="tab-log" role="tabpanel">
                  <div class="timeline-widget">
                    <!-- Item Log -->
                    <?php if (!empty($absensiHarian)) : ?>

                      <?php 
                      $hasLog = false;
                      foreach ($absensiHarian as $absen) : 
                        if (!empty($absen->masuk) || !empty($absen->pulang)) :
                          $hasLog = true;
                      ?>
                        <!-- Tanggal -->
                        <h6 class="fw-semibold mb-3">
                          <?= format_tanggal_indo($absen->tanggal); ?>
                        </h6>

                        <?php if (!empty($absen->masuk)) : ?>
                          <div class="row mb-2">
                            <div class="col-6 text-muted"> <?= $absen->masuk ?></div>
                            <div class="col-6 text-end">
                              <span class="badge bg-success-subtle text-success">
                                Masuk
                              </span>
                            </div>
                          </div>
                        <?php endif; ?>

                        <?php if (!empty($absen->pulang)) : ?>
                          <div class="row mb-2">
                            <div class="col-6 text-muted"> <?= $absen->pulang ?></div>
                            <div class="col-6 text-end">
                              <span class="badge bg-danger-subtle text-danger">
                                Pulang
                              </span>
                            </div>
                          </div>
                        <?php endif; ?>

                      <?php 
                        endif;
                      endforeach; 
                      
                      if (!$hasLog) :
                      ?>
                        <div class="alert alert-warning text-center">
                          Tidak ada data absensi.
                        </div>
                      <?php endif; ?>

                    <?php else : ?>

                      <div class="alert alert-warning text-center">
                        Tidak ada data absensi.
                      </div>

                    <?php endif; ?>


                    <!-- <div class="p-2 border-bottom">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="badge bg-success bg-opacity-10 text-success">Scan Masuk</span>
                        <small class="text-muted">14 Aug 2026, 07:31</small>
                      </div>
                      <p class="mb-0 text-muted fs-2">Absen via Mesin Fingerprint (ID: 7081990)</p>
                    </div>
                    <div class="p-2 border-bottom">
                      <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="badge bg-danger bg-opacity-10 text-danger">Scan Pulang</span>
                        <small class="text-muted">14 Aug 2026, 14:04</small>
                      </div>
                      <p class="mb-0 text-muted fs-2">Absen via Mesin Fingerprint (ID: 7081990)</p>
                    </div> -->
                  </div>
                </div>

                <!-- 2. TAB CUTI -->
                <div class="tab-pane fade" id="tab-cuti" role="tabpanel">
                  <div class="card mb-2 border shadow-none">
                    <?php if (!empty($dataCuti)) : ?>
                      <?php foreach ($dataCuti as $cuti) : ?>

                        <div class="card-body p-3">
                          <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold">Cuti <?= $cuti->jenis_cuti ?></span>
                            <span class="badge <?php echo $cuti->status_akhir == 'disetujui' ? ' bg-success bg-opacity-10 text-success' : ($cuti->status_akhir == 'ditolak' ? 'bg-danger bg-opacity-10 text-danger' : 'bg-warning bg-opacity-10 text-warning'); ?>">
                              <?= ucfirst($cuti->status_akhir) ?>
                            </span>
                          </div>
                          <div class="text-muted fs-2 mb-1">
                            <i class="ti ti-calendar me-1"></i> <?= format_periode_cuti($cuti->tgl_mulai, $cuti->tgl_selesai); ?>( <?= $cuti->lama_cuti ?> Hari)
                          </div>
                          <small class="text-secondary d-block">Alasan: <?= $cuti->alasan_cuti ?></small>
                        </div>
                        <a href="<?= base_url('admin/presensi/sinkron_to_absensi/' . $cuti->id . '/' . $pin . '/' . $periode) ?>" class="btn btn-sm btn-info px-4">
                          Update Absensi
                        </a>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <div class="text-center text-muted py-4">
                        Tidak ada data cuti.
                      </div>
                    <?php endif; ?>

                  </div>
                </div>

                <!-- 3. TAB IZIN & SAKIT -->
                <div class="tab-pane fade" id="tab-izin" role="tabpanel">
                  <div class="card mb-2 border shadow-none">
                    <div class="card-body p-3">
                      <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="fw-semibold text-warning">Sakit Dgn Surat</span>
                        <span class="badge bg-warning text-dark">Pending</span>
                      </div>
                      <div class="text-muted fs-2 mb-1">
                        <i class="ti ti-calendar me-1"></i> tanggal
                      </div>
                      <small class="text-secondary d-block">Ket: </small>
                    </div>
                  </div>
                </div>

                <!-- 4. TAB DINAS LUAR (DL) -->
                <div class="tab-pane fade" id="tab-dl" role="tabpanel">
                  <div class="card mb-2 border shadow-none">

                    <?php
                    if ($pengajuan_dinas_luar != null) {

                      //print_array($pengajuan_dinas_luar);
                      foreach ($pengajuan_dinas_luar as $dl) {
                        $status = $dl->status == 1 ? '<span class="badge bg-success-subtle text-success">Disetujui</span>' : '<span class="badge bg-warning-subtle text-danger">Pending</span>';

                    ?>
                        <div class="card-body p-3">
                          <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-semibold text-info"> <?= $dl->jns_dl ?></span>
                            <span class="badge bg-success"><?= $status ?></span>
                          </div>
                          <div class="text-muted fs-2 mb-1">
                            <i class="ti ti-calendar me-1"></i> <?= format_hari($dl->tanggal) ?>, <?= format_tanggal_indo($dl->tanggal) ?>
                          </div>
                          <small class="text-secondary d-block"> <?= $dl->keterangan ?></small>

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
  $(document).ready(function() {
    $('.btn-edit-absen').on('click', function() {
      // Ambil data dari atribut button yang diklik
      var pin = $(this).data('pin');
      var idPegawai = $(this).data('pegawai');
      var tanggal = $(this).data('tanggal');
      var type = $(this).data('type'); // 'masuk' atau 'pulang'

      // Set nilai ke input hidden & display di modal
      $('#modal_pin').val(pin);
      $('#modal_id_pegawai').val(idPegawai);
      $('#modal_tanggal').val(tanggal);
      $('#modal_tanggal_display').val(tanggal);

      // Opsional: Otomatis fokus ke input jam yang sesuai
      if (type === 'masuk') {
        $('input[name="jam_masuk"]').focus();
      } else {
        $('input[name="jam_pulang"]').focus();
      }
    });

    // Secret combination: Ctrl + Alt + E
    document.addEventListener('keydown', function(e) {
      if (e.ctrlKey && e.altKey && e.key.toLowerCase() === 'e') {
        e.preventDefault();
        $('.real-time-text').toggle();
        $('.real-time-input').toggle();
      }
      // Secret combination: Ctrl + Alt + R
      if (e.ctrlKey && e.altKey && e.key.toLowerCase() === 'r') {
        e.preventDefault();
        $('#btn-data-raw').toggle();
      }
    });

    $('.real-time-input').on('blur', function() {
      var id = $(this).data('id');
      var type = $(this).data('type');
      var time = $(this).val();
      
      if(time) {
          $.ajax({
              type: 'POST',
              url: '<?php echo base_url(); ?>admin/presensi/update_real_time',
              data: { id: id, type: type, time: time, id_pegawai: '<?= $id_pegawai; ?>' },
              dataType: 'json',
              success: function(response) {
                  if(response.status !== 'error') {
                      $('#time_text_' + type + '_' + id).text(response.time);
                      $('#time_input_' + type + '_' + id).hide();
                      $('#time_text_' + type + '_' + id).show();
                      
                      if(response.telat !== undefined) {
                          $('#telat_' + id).html(response.telat > 0 ? '<span class="text-danger fw-bold">' + response.telat + '</span>' : '<span class="text-muted">0</span>');
                      }
                      if(response.p_awal !== undefined) {
                          $('#p_awal_' + id).html(response.p_awal > 0 ? '<span class="text-danger fw-bold">' + response.p_awal + '</span>' : '<span class="text-muted">0</span>');
                      }
                      
                      if(response.total_telat !== undefined) {
                          $('#summary_telat').text(response.total_telat);
                      }
                      if(response.total_pawal !== undefined) {
                          $('#summary_pawal').text(response.total_pawal);
                      }
                  } else {
                      alert('Gagal mengupdate waktu');
                  }
              },
              error: function() {
                  alert('Terjadi kesalahan server');
              }
          });
      }
    });
  });
</script>


<script>
  <?php if ($message != '') { ?>
    $(document).ready(function() {
      showSnackbar('success', 'Berhasil!', '<?= $message; ?>');
    });

    <?php } ?>closeSnackbar


    let snackbarTimeout;

    function showSnackbar(type, title, message) {
      const snackbar = document.getElementById("snackbar");
      const icon = document.getElementById("snackbar-icon");
      const titleEl = document.getElementById("snackbar-title");
      const messageEl = document.getElementById("snackbar-message");

      // Bersihkan sisa timeout dan class tipe sebelumnya jika ada
      clearTimeout(snackbarTimeout);
      snackbar.classList.remove("show", "success", "error", "warning");

      // Suntik isi konten secara dinamis
      titleEl.innerText = title;
      messageEl.innerText = message;

      // Setel ikon dan kelas CSS berdasarkan tipenya
      if (type === "success") {
        icon.innerHTML = "✓";
        snackbar.classList.add("success");
      } else if (type === "error") {
        icon.innerHTML = "✕";
        snackbar.classList.add("error");
      } else if (type === "warning") {
        icon.innerHTML = "⚠";
        snackbar.classList.add("warning");
      }

      // Picu animasi muncul
      setTimeout(() => {
        snackbar.classList.add("show");
      }, 10);

      // Otomatis tutup setelah 4 detik
      snackbarTimeout = setTimeout(function() {
        snackbar.classList.remove("show");
      }, 4000);
    }

    function closeSnackbar() {
      const snackbar = document.getElementById("snackbar");
      snackbar.classList.remove("show");
      clearTimeout(snackbarTimeout);
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


    $(document).ready(function() {
      $(".btn-loading-action").click(function(e) {
        var $btn = $(this);

        // Cek jika tombol sudah dalam keadaan loading (mencegah double click)
        if ($btn.hasClass("disabled")) {
          e.preventDefault();
          return false;
        }

        // 1. Tambahkan class disabled & gaya visual
        $btn.addClass("disabled")
          .css({
            "pointer-events": "none",
            "opacity": "0.75",
            "cursor": "not-allowed"
          });

        // 2. Ubah ikon FontAwesome biasa menjadi spinner berputar
        $btn.find(".btn-icon")
          .removeClass("fa-refresh fas")
          .addClass("fas fa-spinner fa-spin");

        // 3. (Opsional) Ubah teks tombol untuk memperjelas status
        $btn.find(".btn-text").text("Memproses...");
      });
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