<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .datepicker {
      z-index: 1999;
    }
    
    .card-stat {
      border: none;
      border-radius: 1rem;
      transition: all 0.25s ease-in-out;
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.04);
    }
    
    .card-stat:hover {
      transform: translateY(-3px);
      box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.08);
    }

    .icon-shape {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.25rem;
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
            $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);
            $message = $this->session->flashdata('message');

            if (empty($photo)) {
              $photo = 'avatar.png';
            }


            $nuPengajuanCuti = count($pending_approval_list);

            $jmlhPengajuanCuti = !empty($nuPengajuanCuti) ? $nuPengajuanCuti : 0;
            $jmlhPengajuanDL   = !empty($pengajuanDL) ? count($pengajuanDL) : 0;
          ?>

          <!-- Flash Message -->
          <?php if (!empty($message)): ?>
            <div class="mb-3">
              <?php echo $message; ?>
            </div>
          <?php endif; ?>

          <!-- Header / Welcome Banner -->
          <div class="card bg-primary-subtle border-0 mb-4 overflow-hidden rounded-4">
            <div class="card-body p-4">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="position-relative">
                    <img src="<?php echo base_url(); ?>uploads/photo_profile/<?php echo $photo; ?>" class="rounded-circle object-fit-cover border border-2 border-white shadow-sm" width="60" height="60" alt="user" />
                  </div>
                  <div>
                    <h4 class="fw-bold text-dark mb-1">Selamat Datang, <?php echo $nama_user; ?>!</h4>
                    <p class="text-muted mb-0 font-medium fs-3">
                      <i class="ti ti-calendar me-1"></i> <?php echo date('D, d F Y'); ?>
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Cards Summary Row -->
          <div class="row g-4 mb-4">
            
            <!-- 1. Card Pengajuan Cuti (Pending Approval) -->
            <div class="col-lg-4 col-md-6">
              <div class="card card-stat h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                      <span class="text-uppercase fw-semibold text-muted fs-2 tracking-wider">Menunggu Persetujuan</span>
                      <h2 class="fw-bold text-dark mb-0 mt-1"><?php echo $jmlhPengajuanCuti; ?></h2>
                      <span class="text-muted fs-2">Pengajuan Cuti</span>
                    </div>
                    <div class="icon-shape bg-success-subtle text-success">
                      <i class="ti ti-calendar-time"></i>
                    </div>
                  </div>
                  <div class="pt-2 border-top border-light-subtle d-flex justify-content-end">
                    <a href="<?php echo base_url(); ?>admin/cuti/pengajuan_cuti_pegawai/pending" class="btn btn-sm btn-success px-3 rounded-2 fw-semibold">
                      Tinjau Cuti <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- 2. Card Pengajuan Dinas Luar -->
            <div class="col-lg-4 col-md-6">
              <div class="card card-stat h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                      <span class="text-uppercase fw-semibold text-muted fs-2 tracking-wider">Permohonan Aktif</span>
                      <h2 class="fw-bold text-dark mb-0 mt-1"><?php echo $jmlhPengajuanDL; ?></h2>
                      <span class="text-muted fs-2">Pengajuan Dinas Luar</span>
                    </div>
                    <div class="icon-shape bg-info-subtle text-info">
                      <i class="ti ti-briefcase"></i>
                    </div>
                  </div>
                  <div class="pt-2 border-top border-light-subtle d-flex justify-content-end">
                    <a href="<?php echo base_url(); ?>dashboard/pengajuan_dinas_luar_pegawai" class="btn btn-sm btn-info px-3 rounded-2 fw-semibold">
                      Lihat Detail <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>

            <!-- 3. Card Pengajuan Izin / Sakit -->
            <div class="col-lg-4 col-md-6">
              <div class="card card-stat h-100">
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                  <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                      <span class="text-uppercase fw-semibold text-muted fs-2 tracking-wider">Permohonan Aktif</span>
                      <h2 class="fw-bold text-dark mb-0 mt-1">0</h2>
                      <span class="text-muted fs-2">Pengajuan Izin / Sakit</span>
                    </div>
                    <div class="icon-shape bg-warning-subtle text-warning">
                      <i class="ti ti-file-medical"></i>
                    </div>
                  </div>
                  <div class="pt-2 border-top border-light-subtle d-flex justify-content-end">
                    <a href="<?php echo base_url(); ?>admin/absensi/pengajuan_izin_sakit_pegawai" class="btn btn-sm btn-warning px-3 rounded-2 fw-semibold text-dark">
                      Lihat Detail <i class="ti ti-arrow-right ms-1"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>

          </div> <!-- End Row -->

        </div>
      </div>

      <?php $this->load->view('layout/section/theme-setting.php'); ?>
      <?php $this->load->view('master/request-cuti.php'); ?>

    </div>
    <div class="dark-transparent sidebartoggler"></div>
  </div>


  <!-- ========================================================== -->
  <!-- MODAL NOTIFIKASI AUTO POP-UP UNTUK APPROVAL ATASAN         -->
  <!-- ========================================================== -->
  <?php if (!empty($pending_approval_list)): ?>
  <div class="modal fade" id="modalNotifApprovalAtasan" tabindex="-1" aria-labelledby="modalNotifApprovalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
        
        <!-- Header Modal -->
        <div class="modal-header bg-primary text-white border-0 py-3 px-4">
          <div class="d-flex align-items-center gap-2">
            <div class="p-2 bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
              <i class="ti ti-bell-ringing fs-5"></i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-white mb-0" id="modalNotifApprovalLabel">Persetujuan Cuti Menunggu Tindakan</h5>
              <small class="text-white-50">Terdapat <?php echo count($pending_approval_list); ?> pengajuan cuti pegawai yang membutuhkan verifikasi Anda.</small>
            </div>
          </div>
          <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body p-4" style="max-height: 420px; overflow-y: auto;">
          <div class="d-flex flex-column gap-3">
            <?php foreach ($pending_approval_list as $item): ?>

              <?php
              $id_jabatan = $item['jabatan_pemohon'];
              $jabatan = $this->Master_model->getNamaJabatan($id_jabatan)
;              ?>
              <div class="p-3 bg-light rounded-3 border d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                <div>
                  <div class="d-flex align-items-center gap-2 mb-1">
                    <h6 class="fw-bold text-dark mb-0"><?php echo $item['nama_pemohon']; ?></h6>
                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle text-uppercase" style="font-size: 0.65rem;">
                      <?php echo $item['role_approval']; ?>
                    </span>
                  </div>
                  <p class="text-muted small mb-1"><?php echo $jabatan; ?></p>
                  <div class="d-flex align-items-center gap-3 text-xs text-muted">
                    <span><i class="ti ti-calendar me-1"></i> <?php echo date('d/m/Y', strtotime($item['tgl_mulai'])); ?> s/d <?php echo date('d/m/Y', strtotime($item['tgl_selesai'])); ?></span>
                    <span><i class="ti ti-clock me-1"></i> <?php echo $item['lama_cuti']; ?> Hari</span>
                  </div>
                  <div class="mt-1">
                    <small class="text-dark"><em>"<?php echo $item['alasan_cuti']; ?>"</em></small>
                  </div>
                </div>

                <div class="text-sm-end">
                  <a href="<?php echo base_url('admin/cuti/detail_pengajuan_cuti/' . $item['id']); ?>" class="btn btn-primary btn-sm px-3 rounded-2 fw-medium whitespace-nowrap">
                    <i class="ti ti-edit me-1"></i> Diproses
                  </a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="modal-footer bg-light border-top px-4 py-2 d-flex justify-content-between">
          <span class="text-muted small"><i class="ti ti-info-circle me-1"></i> Silakan klik 'Diproses' untuk menyetujui atau menolak.</span>
          <button type="button" class="btn btn-sm btn-secondary rounded-2" data-bs-dismiss="modal">Nanti Saja</button>
        </div>

      </div>
    </div>
  </div>

  <!-- JavaScript Auto Open Modal -->
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var notifModalElement = document.getElementById('modalNotifApprovalAtasan');
      if (notifModalElement) {
        var notifModal = new bootstrap.Modal(notifModalElement);
        notifModal.show();
      }
    });
  </script>
  <?php endif; ?>

  <!-- Import JS Files -->
  <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
  <script src="../assets/js/app.init.js"></script>
  <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

  <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>
</body>

</html>