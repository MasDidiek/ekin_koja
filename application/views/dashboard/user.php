<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .datepicker {
      z-index: 1999;
    }

    /* Modernized Shortcut Buttons */
    .dashboard-shortcut-btn {
      display: flex;
      align-items: center;
      padding: 14px 18px;
      border-radius: 12px;
      color: #ffffff;
      text-decoration: none;
      font-weight: 600;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      margin-bottom: 12px;
      transition: all 0.3s ease;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
    }

    .dashboard-shortcut-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.12);
      color: #ffffff;
    }

    .dashboard-shortcut-btn .icon-box {
      width: 40px;
      height: 40px;
      background: rgba(0, 0, 0, 0.15);
      border-radius: 8px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 14px;
      font-size: 1.1rem;
    }

    .btn-primary-gradient {
      background: linear-gradient(135deg, #297fb8 0%, #1f5f8b 100%);
    }

    .btn-turquoise-gradient {
      background: linear-gradient(135deg, #1abc9c 0%, #16a085 100%);
    }

    .btn-purple-gradient {
      background: linear-gradient(135deg, #8e44ad 0%, #732d91 100%);
    }

    .btn-orange-gradient {
      background: linear-gradient(135deg, #f39c12 0%, #d35400 100%);
    }

    .loading-image {
      background: rgba(255, 255, 255, 0.85);
      width: 100%;
      height: 100%;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 888;
      display: flex;
      align-items: center;
      justify-content: center;
      display: none;
      border-radius: 12px;
    }

    .card {
      border: none;
      box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
      border-radius: 1rem;
      margin-bottom: 1.5rem;
    }
  </style>
</head>

<body>
  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div>
        <?php $this->load->view('layout/section/sidebar'); ?>
      </div>
    </aside>
    <!-- Sidebar End -->

    <div class="page-wrapper">
      <!-- Header Start -->
      <?php $this->load->view('layout/section/header'); ?>
      <!-- Header End -->

      <div class="body-wrapper">
        <div class="container-fluid">

          <?php
          $nama_user =  $this->session->userdata('nama');
          $nip_user =  $this->session->userdata('nip');
          $id_pegawai =  $this->session->userdata('id_pegawai');
          $usergroup =  $this->session->userdata('usergroup');
          $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);
          $message = $this->session->flashdata('success');

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
          ?>

          <!-- Welcome Banner Section -->
          <div class="row">
            <div class="col-md-12">
              <div class="card bg-primary-subtle border-0 mb-4 overflow-hidden">
                <div class="card-body p-4">
                  <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center gap-4">
                      <div class="position-relative">
                        <div class="p-1 bg-white rounded-circle shadow-sm">
                          <img src="<?php echo base_url(); ?>uploads/photo_profile/<?php echo $photo; ?>" class="rounded-circle object-fit-cover" alt="user" width="70" height="70">
                        </div>
                        <span class="position-absolute bottom-0 end-0 translate-middle p-2 bg-success border border-light rounded-circle">
                          <span class="visually-hidden">Active</span>
                        </span>
                      </div>
                      <div>
                        <h3 class="fw-bold text-dark mb-1">Hi, <?php echo $nama_user; ?>!</h3>
                        <p class="text-muted mb-0 font-medium">Have a wonderful and productive workday • <?php echo date('d F Y'); ?></p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>


          <div class="alert alert-success"><?= $message; ?></div>



          <!-- Main Row -->
          <div class="row">
            <!-- Left Side: Attendance Recap & Financial Info -->
            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100 position-relative">
                <div class="loading-image">
                  <img src="<?php echo base_url(); ?>assets/images/loading_baru.gif" width="120">
                </div>
                <div class="card-body p-4">
                  <div class="d-sm-flex d-block align-items-center justify-content-between mb-4">
                    <div>
                      <h5 class="card-title fw-bold mb-1">Rekap Absensi</h5>
                      <p class="card-subtitle text-muted mb-0">Ringkasan data kehadiran periode aktif</p>
                    </div>
                    <select class="form-select w-auto mt-2 mt-sm-0 shadow-none border-primary-subtle font-medium" id="change_periode">
                      <?php
                      $listBulan = array_bulan();
                      for ($i = 1; $i < count($listBulan); $i++) {
                        if ($i == $bulan) {
                          echo '<option value="' . $i . '/' . $tahun . '" selected>' . $listBulan[$i] . ' ' . $tahun . '</option>';
                        } else {
                          echo '<option value="' . $i . '/' . $tahun . '">' . $listBulan[$i] . ' ' . $tahun . '</option>';
                        }
                      }
                      ?>
                    </select>
                  </div>

                  <div class="row align-items-center">
                    <div class="col-md-7">
                      <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                          <tbody>
                            <tr>
                              <td class="fw-semibold text-muted ps-0"><i class="ti ti-clock-exclamation text-warning me-2"></i> Terlambat</td>
                              <td class="text-end fw-bold text-dark"><?php echo $telat; ?> menit</td>
                            </tr>
                            <tr>
                              <td class="fw-semibold text-muted ps-0"><i class="ti ti-clock-down text-danger me-2"></i> Pulang Cepat</td>
                              <td class="text-end fw-bold text-dark"><?php echo $pulang_awal; ?> menit</td>
                            </tr>
                            <tr>
                              <td class="fw-semibold text-muted ps-0"><i class="ti ti-medical-cross text-info me-2"></i> Sakit</td>
                              <td class="text-end fw-bold text-dark"><?php echo $sakit; ?> hari</td>
                            </tr>
                            <tr>
                              <td class="fw-semibold text-muted ps-0"><i class="ti ti-file-text text-primary me-2"></i> Izin</td>
                              <td class="text-end fw-bold text-dark"><?php echo $izin; ?> hari</td>
                            </tr>
                            <tr>
                              <td class="fw-semibold text-muted ps-0"><i class="ti ti-calendar-event text-success me-2"></i> Cuti</td>
                              <td class="text-end fw-bold text-dark"><?php echo $jumlah_cuti; ?> hari</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>

                    <div class="col-md-5 border-start-md ps-md-4 mt-4 mt-md-0">
                      <div class="bg-light-subtle p-3 rounded-3 border mb-3">
                        <div class="d-flex align-items-center mb-2">
                          <div class="p-2 bg-primary-subtle text-primary rounded-2 me-2">
                            <i class="ti ti-wallet fs-5"></i>
                            </span>
                            <span class="text-muted fs-3 fw-semibold">Total THP TKD</span>
                          </div>
                          <h4 class="mb-0 fw-bold text-primary">Rp. <?php echo rupiah($thp); ?></h4>
                        </div>

                        <div class="d-flex align-items-center justify-content-between mb-2">
                          <span class="fs-3 text-muted">PPh21</span>
                          <span class="fs-3 fw-semibold text-dark">Rp. <?php echo rupiah($pph21); ?></span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                          <span class="fs-3 text-muted">Lainnya</span>
                          <span class="fs-3 fw-semibold text-dark">-</span>
                        </div>

                        <div>
                          <a href="<?php echo base_url(); ?>kinerja/capaian" class="btn btn-outline-primary w-100 mb-3 fw-semibold">
                            Lihat Detail Kinerja
                          </a>

                          <?php
                          if ($usergroup == 0) {
                            echo '<a href="' . base_url() . 'dashboard/pengajuan_dinas_luar_pegawai" class="btn btn-success w-100 mb-2 fw-semibold">
                                  <i class="fa-solid fa-file me-2"></i> Pengajuan Dinas Luar
                                </a>';
                            echo '<a href="' . base_url() . 'dashboard/tarikDataAbsensiMesin" class="btn btn-info w-100 mb-2 fw-semibold text-white">
                                  <i class="fa-solid fa-download me-2"></i> Tarik Data Absensi
                                </a>';
                            echo '<a href="' . base_url() . 'dashboard/list_pengajuan_izin" class="btn btn-warning w-100 fw-semibold text-dark">
                                  <i class="fa-solid fa-file-medical me-2"></i> Pengajuan Izin / Sakit
                                </a>';
                          }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Right Side: Performance Breakdown & Shortcuts -->
              <div class="col-lg-4">
                <div class="row">
                  <!-- Yearly/Monthly Capaian Kinerja Card -->
                  <div class="col-lg-12 col-md-6">
                    <div class="card">
                      <div class="card-body p-4">
                        <div class="row align-items-center">
                          <div class="col-7">
                            <h5 class="card-title fw-bold mb-3">Capaian Kinerja</h5>
                            <h3 class="fw-bold text-dark mb-2"><?php echo $capaian; ?>%</h3>
                            <div class="d-flex align-items-center mb-2">
                              <span class="me-2 rounded-circle bg-success-subtle p-1 d-flex align-items-center justify-content-center">
                                <i class="ti ti-arrow-up-left text-success fs-3"></i>
                              </span>
                              <span class="text-muted fs-3"><?php echo $nama_bulan; ?></span>
                            </div>
                            <div class="d-flex align-items-center gap-3">
                              <span class="fs-2 text-muted"><span class="round-8 bg-primary rounded-circle d-inline-block me-1"></span> <?php echo $tahun; ?></span>
                              <span class="fs-2 text-muted"><span class="round-8 bg-primary-subtle rounded-circle d-inline-block me-1"></span> 2024</span>
                            </div>
                          </div>
                          <div class="col-5">
                            <div class="d-flex justify-content-center">
                              <div id="breakup"></div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Modern Shortcuts Card -->
                  <div class="col-lg-12 col-md-6">
                    <div class="card">
                      <div class="card-body p-4">
                        <h5 class="card-title fw-bold mb-3">Shortcut Menu</h5>
                        <div class="d-flex flex-column gap-2">
                          <a href="<?php echo base_url(); ?>kinerja/index" class="dashboard-shortcut-btn btn-primary-gradient">
                            <div class="icon-box"><i class="fa-solid fa-book"></i></div>
                            <span>Input Kinerja</span>
                          </a>
                          <a href="<?php echo base_url(); ?>absensi/dinas_luar" class="dashboard-shortcut-btn btn-turquoise-gradient">
                            <div class="icon-box"><i class="fa-solid fa-building-circle-exclamation"></i></div>
                            <span>Dinas Luar</span>
                          </a>
                          <a href="#" class="dashboard-shortcut-btn btn-purple-gradient" data-bs-toggle="modal" data-bs-target="#samedata-modal">
                            <div class="icon-box"><i class="fa-solid fa-calendar"></i></div>
                            <span>Pengajuan Cuti</span>
                          </a>
                          <a href="<?php echo base_url(); ?>absensi/izin_sakit" class="dashboard-shortcut-btn btn-orange-gradient">
                            <div class="icon-box"><i class="fa-solid fa-file-medical"></i></div>
                            <span>Sakit / Izin</span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>

        <?php
        $id_pegawai = $this->session->userdata('id_pegawai');
        $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
        $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 4);
        $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);
        $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');
        $arrayJnsHakCuti = array(2, 4, 3);
        $arraySisaCuti = array($hakCutiThnLalu, $hakCutiThnIni, $hakCutiBersama);
        ?>

        <!-- Modal Pengajuan Cuti -->
        <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <form method="post" action="<?php echo base_url(); ?>cuti/check_date" enctype="multipart/form-data" class="w-100">
              <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-bottom px-4 py-3">
                  <h5 class="modal-title fw-bold" id="exampleModalLabel1">
                    Pengajuan Cuti
                  </h5>
                  <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                  <div class="row g-3">
                    <div class="col-md-6">
                      <label class="form-label fw-semibold text-muted fs-3">Tanggal Mulai:</label>
                      <input type="text" required name="date_from" autocomplete="off" class="form-control" value="<?php echo date('d-m-Y'); ?>" id="dpd1">
                    </div>
                    <div class="col-md-6">
                      <label class="form-label fw-semibold text-muted fs-3">Tanggal Akhir:</label>
                      <input type="text" required name="date_to" autocomplete="off" class="form-control" value="<?php echo date('d-m-Y'); ?>" id="dpd2">
                    </div>
                    <div class="col-md-6 mt-3">
                      <label class="form-label fw-semibold text-muted fs-3">Jenis Cuti:</label>
                      <select name="jns_cuti" id="jns_cuti" class="form-select">
                        <option value="1">Cuti Tahunan</option>
                        <option value="2">Cuti Bersalin</option>
                        <option value="3">Cuti Alasan Penting</option>
                        <option value="4">Cuti Sakit</option>
                        <option value="5">Cuti Besar</option>
                      </select>
                    </div>
                    <div class="col-md-6 mt-3">
                      <label class="form-label fw-semibold text-muted fs-3">Hak Cuti yang digunakan:</label>
                      <select name="jns_hak_cuti" id="jns_hak_cuti" class="form-select">
                        <?php
                        for ($i = 0; $i < count($arrayHakCuti); $i++) {
                          $idjnsHak =   $arrayJnsHakCuti[$i];
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
                <div class="modal-footer border-top px-4 py-3">
                  <button type="button" class="btn btn-light font-medium px-4" data-bs-dismiss="modal">
                    Tutup
                  </button>
                  <button type="submit" class="btn btn-primary px-4 fw-semibold">
                    Selanjutnya
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>


        <!-- ========================================================== -->
        <!-- MODAL NOTIFIKASI PERMINTAAN PENGGANTI CUTI (AUTO TRIGGER) -->
        <!-- ========================================================== -->
        <?php if (!empty($pending_pengganti)) : ?>
          <div class="modal fade" id="modalNotifPengganti" tabindex="-1" aria-labelledby="modalNotifPenggantiLabel" aria-hidden="true" data-bs-backdrop="static">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">

                <!-- Header dengan Warna Warning/Perhatian -->
                <div class="modal-header bg-warning-subtle text-warning-emphasis border-0 py-3 px-4">
                  <div class="d-flex align-items-center gap-2">
                    <div class="p-2 bg-warning text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                      <i class="fa-solid fa-bell"></i>
                    </div>
                    <h5 class="modal-title fw-bold mb-0 fs-4" id="modalNotifPenggantiLabel">Permintaan Pengganti Cuti</h5>
                  </div>
                  <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">
                  <p class="text-muted fs-3 mb-3">
                    Anda ditunjuk sebagai <strong>Petugas Pengganti</strong> untuk pengajuan cuti berikut:
                  </p>

                  <div class="space-y-3">
                    <?php foreach ($pending_pengganti as $item) : ?>
                      <div class="p-3 bg-light rounded-3 border">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                          <div>
                            <h6 class="fw-bold text-dark mb-0"><?= $item['nama_pemohon']; ?></h6>
                            <small class="text-muted"><?= $item['jabatan_pemohon']; ?></small>
                          </div>
                          <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill">
                            <?= $item['lama_cuti']; ?> Hari
                          </span>
                        </div>

                        <div class="row g-2 text-xs text-muted border-top border-light-subtle pt-2 mt-2">
                          <div class="col-6">
                            <span class="d-block text-uppercase fw-semibold" style="font-size: 0.65rem;">Mulai:</span>
                            <span class="fw-medium text-dark"><?= date('d-m-Y', strtotime($item['tgl_mulai'])); ?></span>
                          </div>
                          <div class="col-6">
                            <span class="d-block text-uppercase fw-semibold" style="font-size: 0.65rem;">Selesai:</span>
                            <span class="fw-medium text-dark"><?= date('d-m-Y', strtotime($item['tgl_selesai'])); ?></span>
                          </div>
                          <div class="col-12 mt-2">
                            <span class="d-block text-uppercase fw-semibold" style="font-size: 0.65rem;">Alasan Cuti:</span>
                            <span class="text-dark font-italic">"<?= $item['alasan_cuti']; ?>"</span>
                          </div>
                        </div>

                        <div class="mt-3 text-end">

                          <a href="<?= base_url('cuti/total_penggantian_cuti/' . $item['id']); ?>" class="btn btn-sm btn-outline-danger fw-semibold px-3 rounded-2">
                            <i class="fa-solid fa-file-signature me-1"></i> Tolak
                          </a>

                          <a href="<?= base_url('cuti/approve_penggantian_cuti/' . $item['id']); ?>" class="btn btn-sm btn-primary fw-semibold px-3 rounded-2">
                            <i class="fa-solid fa-file-signature me-1"></i> Setujui
                          </a>
                        </div>
                      </div>
                    <?php endforeach; ?>
                  </div>
                </div>

                <div class="modal-footer bg-light-subtle border-top px-4 py-2">
                  <button type="button" class="btn btn-sm btn-secondary rounded-2" data-bs-dismiss="modal">Nanti Saja</button>
                </div>

              </div>
            </div>
          </div>

          <!-- JavaScript Auto Open Modal -->
          <script>
            document.addEventListener('DOMContentLoaded', function() {
              var notifModalElement = document.getElementById('modalNotifPengganti');
              if (notifModalElement) {
                var notifModal = new bootstrap.Modal(notifModalElement);
                notifModal.show();
              }
            });
          </script>
        <?php endif; ?>


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
  document.addEventListener('DOMContentLoaded', function() {
    var notifModalElement = document.getElementById('modalNotifPengganti');
    if (notifModalElement) {
      var notifModal = new bootstrap.Modal(notifModalElement);
      notifModal.show();
    }
  });

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
    $(".loading-image").css("display", "flex");

    $.ajax({
      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>dashboard/set_session_periode",
      data: "bulan=" + bulan + "&tahun=" + tahun,
      success: function(msg) {
        window.location.reload();
      }
    });
  });

  var nowTemp = new Date();
  var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

  var checkin = $('#dpd1').datepicker({
    onRender: function(date) {
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
      return '';
    }
  }).on('changeDate', function(ev) {
    checkout.hide();
  }).data('datepicker');
</script>

</html>