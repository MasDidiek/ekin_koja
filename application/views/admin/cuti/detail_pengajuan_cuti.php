<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
            .cuti-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.05);
            margin-bottom: 1.5rem;
        }
        .cuti-card-header {
            background-color: #fcfdfe;
            border-bottom: 1px solid #edf2f7;
            border-top-left-radius: 1rem !important;
            border-top-right-radius: 1rem !important;
            padding: 1rem 1.5rem;
            font-weight: 600;
            color: #2d3748;
            display: flex;
            align-items: center;
        }
        .icon-box {
            width: 36px;
            height: 36px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .info-label {
            font-size: 0.75rem;
            font-weight: 500;
            color: #a0aec0;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.25rem;
            display: block;
        }
        .info-value {
            font-size: 0.9375rem;
            font-weight: 600;
            color: #2d3748;
            display: block;
        }

        .period-card {
            background-color: #f8fafc;
            border: 1px solid #edf2f7;
            border-radius: 0.75rem;
            padding: 1rem;
        }
        .period-item { display: flex; align-items: center; }
        .period-icon {
            padding: 0.6rem;
            background-color: white;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
            color: #718096;
            margin-right: 1rem;
        }

        .badge-status {
            font-size: 0.7rem;
            font-weight: 600;
            padding: 0.35em 0.8em;
            border-radius: 50rem;
        }

        /* TIMELINE STYLES */
        .timeline-approval {
            position: relative;
            padding-left: 2rem;
            list-style: none;
        }
        .timeline-approval::before {
            content: '';
            position: absolute;
            left: 7px;
            top: 10px;
            bottom: 10px;
            width: 2px;
            background-color: #edf2f7;
            z-index: 1;
        }
        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            z-index: 2;
        }
        .timeline-point {
            position: absolute;
            left: -32px;
            top: 2px;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.65rem;
            border: 4px solid white;
        }
        
        .status-approved .timeline-point { background-color: #10b981; color: white; }
        .status-approved .timeline-content h6 { color: #10b981; }

        .status-pending .timeline-point { background-color: #f59e0b; color: white; animation: pulse 2s infinite; }
        .status-pending .timeline-content h6 { color: #b45309; }

        .status-rejected .timeline-point { background-color: #ef4444; color: white; }
        .status-rejected .timeline-content h6 { color: #ef4444; }

        .status-none { opacity: 0.6; }
        .status-none .timeline-point { background-color: #e2e8f0; color: #718096; }

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0.4); }
            70% { box-shadow: 0 0 0 8px rgba(245, 158, 11, 0); }
            100% { box-shadow: 0 0 0 0 rgba(245, 158, 11, 0); }
        }

        .timeline-content h6 { font-size: 0.875rem; font-weight: 600; margin-bottom: 0.15rem; }
        .timeline-content p { font-size: 0.75rem; color: #718096; margin-bottom: 0; }
        .approval-role { font-size: 0.7rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.1rem; display: block;}

        @media print {
            body { background-color: white; padding: 0; }
            .cuti-card { border: 1px solid #ddd; box-shadow: none; }
            .d-print-none { display: none !important; }
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
      

      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->


      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8">Detail Cuti</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html" >Home</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive">Detail Cuti</li>
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
                    
                
                #echo $usergroup;

               //print_array($cuti);
                $id_pegawai = $cuti['id_pegawai'];
                $id_pengganti = $cuti['id_pengganti'];
                $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
               
                $nama = $detail_pegawai[0]->nama;
                $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
                $jabatan = $detail_pegawai[0]->jabatan;
                $puskesmas = $detail_pegawai[0]->puskesmas;

                $detail_pegawai_pengganti = $this->Pegawai_model->getDetailPegawai($id_pengganti);
                $jabatan_pengganti = $detail_pegawai_pengganti[0]->jabatan;
                $puskesmas_pengganti = $detail_pegawai_pengganti[0]->puskesmas;

                $hak_cuti          = $this->Cuti_model->get_rekap_cuti_pegawai_by_id($id_pegawai);
                $riwayat_cuti      = $this->Cuti_model->getHistoryCutiPegawai($id_pegawai);

                $tahun = date('Y');

                $hak_cuti_bersama  = $this->Cuti_model->getHakCutiBersama($id_pegawai, $tahun);

               // echo $id_pegawai;
//
             //print_array($hak_cuti_bersama);
  
              

               ?>

                      
                      <!-- Header Actions & Title -->
                      <div class="cuti-card card mb-4">
                          <div class="card-body d-flex flex-column flex-sm-row justify-content-between align-items-sm-center py-3 px-4">
                              <div class="mb-3 mb-sm-0">
                                  <div class="d-flex align-items-center">
                                      <h4 class="mb-0 fw-bold text-gray-800 me-3">Detail Pengajuan Cuti</h4>
                                      <?php 
                                          $status_class = [
                                              'draft'        => 'bg-secondary-subtle text-secondary border-secondary-subtle',
                                              'proses'       => 'bg-warning-subtle text-warning-emphasis border-warning-subtle',
                                              'disetujui'    => 'bg-success-subtle text-success border-success-subtle',
                                              'ditolak'      => 'bg-danger-subtle text-danger border-danger-subtle',
                                              'ditangguhkan' => 'bg-info-subtle text-info border-info-subtle',
                                              'dibatalkan'   => 'bg-dark-subtle text-dark border-dark-subtle'
                                          ];
                                          $badge = isset($status_class[$cuti['status_akhir']]) ? $status_class[$cuti['status_akhir']] : 'bg-secondary-subtle text-secondary';
                                      ?>
                                      <span class="badge badge-status border <?= $badge; ?>">
                                          <?= strtoupper($cuti['status_akhir']); ?>
                                      </span>
                                  </div>
                                  <p class="text-muted small mb-0 mt-1">ID Pengajuan: <span class="font-monospace fw-medium text-dark">#CUTI-<?= $cuti['id']; ?></span></p>
                              </div>
                              <div class="d-flex gap-2 d-print-none">
                                  <button onclick="window.print()" class="btn btn-sm btn-outline-secondary">
                                      <i class="fa-solid fa-print me-1"></i> Cetak
                                  </button>
                              </div>
                          </div>
                      </div>

                      <div class="row">
                          <!-- Left Side: Detail Data -->
                          <div class="col-lg-8">

                              <!-- 1. Pemohon Cuti -->
                              <div class="cuti-card card">
                                  <div class="cuti-card-header">
                                      <div class="icon-box bg-primary-subtle text-primary">
                                          <i class="fa-solid fa-user m-0"></i>
                                      </div>
                                      Pemohon Cuti
                                  </div>
                                  <div class="card-body px-4 py-4">
                                      <div class="row g-4 text-sm">
                                          <div class="col-sm-4">
                                              <span class="info-label">Nama Lengkap</span>
                                              <span class="info-value"><?= !empty($cuti['nama_pemohon']) ? $cuti['nama_pemohon'] : '-'; ?></span>
                                          </div>
                                          <div class="col-sm-4">
                                              <span class="info-label">Jabatan</span>
                                              <span class="info-value fw-normal"><?=  $jabatan ?></span>
                                          </div>
                                          <div class="col-sm-4">
                                              <span class="info-label">Unit Kerja</span>
                                              <span class="info-value fw-normal"><?= $puskesmas ?></span>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <!-- 2. Informasi Cuti -->
                              <div class="cuti-card card">
                                  <div class="cuti-card-header">
                                      <div class="icon-box bg-indigo-subtle" style="color: #6610f2; background-color: #f0e6ff;">
                                          <i class="fa-solid fa-calendar-days m-0"></i>
                                      </div>
                                      Informasi Cuti
                                  </div>
                                  
                                  <div class="card-body px-4 py-4">
                                      <div class="row g-4 pb-4 mb-4 border-bottom border-light-subtle">
                                          <div class="col-6 col-sm-3">
                                              <span class="info-label">Jenis Hak Cuti</span>
                                              <span class="info-value text-capitalize"><?= $cuti['jenis_hak_cuti']; ?></span>
                                          </div>
                                          <div class="col-6 col-sm-3">
                                              <span class="info-label">Tahun Hak Cuti</span>
                                              <span class="info-value"><?= $cuti['tahun_hak_cuti']; ?></span>
                                          </div>
                                          <div class="col-6 col-sm-3">
                                              <span class="info-label">Tgl Pengajuan</span>
                                              <span class="info-value fw-normal"><?= date('d-m-Y', strtotime($cuti['tgl_pengajuan'])); ?></span>
                                          </div>
                                          <div class="col-6 col-sm-3">
                                              <span class="info-label">Lama Cuti</span>
                                              <span class="badge bg-primary-subtle text-primary fw-semibold rounded-pill" style="font-size: 0.8rem; padding: 0.4em 0.8em;">
                                                  <?= $cuti['lama_cuti']; ?> Hari
                                              </span>
                                          </div>
                                      </div>

                                      <!-- Periode Tanggal -->
                                      <div class="period-card d-flex flex-column flex-sm-row align-items-sm-center justify-content-sm-between gap-3 mb-4">
                                          <div class="period-item">
                                              <div class="period-icon">
                                                  <i class="fa-regular fa-calendar m-0"></i>
                                              </div>
                                              <div>
                                                  <span class="text-muted small d-block">Tanggal Mulai</span>
                                                  <span class="info-value"><?= format_hari($cuti['tgl_mulai']).', '.date('d-m-Y', strtotime($cuti['tgl_mulai'])); ?></span>
                                              </div>
                                          </div>
                                          <i class="fa-solid fa-arrow-right text-muted d-none d-sm-block"></i>
                                          <div class="period-item">
                                              <div class="period-icon">
                                                  <i class="fa-regular fa-calendar-check m-0"></i>
                                              </div>
                                              <div>
                                                  <span class="text-muted small d-block">Tanggal Selesai</span>
                                                  <span class="info-value"><?=  format_hari($cuti['tgl_selesai']).', '.date('d-m-Y', strtotime($cuti['tgl_selesai'])); ?></span>
                                              </div>
                                          </div>
                                      </div>

                                      <!-- Kontak, Alasan & Delegasi -->
                                      <div class="row g-4 pt-2 text-sm">
                                          <div class="col-sm-6">
                                              <span class="info-label">Alamat Selama Cuti</span>
                                              <p class="text-sm fw-medium text-dark mb-0"><?= nl2br($cuti['alamat_cuti']); ?></p>
                                          </div>
                                          <div class="col-sm-6">
                                              <span class="info-label">No. Telepon</span>
                                              <p class="text-sm fw-medium text-dark mb-0">
                                                  <i class="fa-solid fa-phone text-muted me-1 small"></i> <?= $cuti['no_telp']; ?>
                                              </p>
                                          </div>
                                          <div class="col-12">
                                              <span class="info-label">Alasan Cuti</span>
                                              <p class="text-sm fw-medium text-dark bg-light p-3 rounded-3 border mb-0"><?= nl2br($cuti['alasan_cuti']); ?></p>
                                          </div>
                                          <div class="col-12">
                                              <span class="info-label">Delegasi Tugas</span>
                                              <div class="text-sm text-dark bg-light p-3 rounded-3 border">
                                                  <?= nl2br($cuti['delegasi_tugas']); ?>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                              </div>

                              <!-- 3. Petugas Pengganti -->
                              <div class="cuti-card card">
                                  <div class="cuti-card-header">
                                      <div class="icon-box bg-warning-subtle text-warning-emphasis">
                                          <i class="fa-solid fa-user-gear m-0"></i>
                                      </div>
                                      Petugas Pengganti
                                  </div>
                                  <div class="card-body px-4 py-4 text-sm">
                                      <div class="row g-4">
                                          <div class="col-sm-4">
                                              <span class="info-label">Nama Pengganti</span>
                                              <span class="info-value"><?= !empty($cuti['nama_pengganti']) ? $cuti['nama_pengganti'] : '-'; ?></span>
                                          </div>
                                          <div class="col-sm-4">
                                              <span class="info-label">Jabatan</span>
                                              <span class="info-value fw-normal"><?= $jabatan_pengganti; ?></span>
                                          </div>
                                          <div class="col-sm-4">
                                              <span class="info-label">Unit Kerja</span>
                                              <span class="info-value fw-normal"><?= $puskesmas_pengganti; ?></span>
                                          </div>
                                      </div>
                                  </div>
                              </div>


                              
      
                          </div> <!-- End Left Side -->

                        <!-- Right Side: Timeline Approval Real & Action -->
                            <div class="col-lg-4">

                                <div class="cuti-card card">
                                    <div class="card-body p-4">
                                        <h6 class="card-title fw-bold text-dark mb-4 d-flex align-items-center">
                                            <i class="fa-solid fa-route text-primary me-2"></i> Status Persetujuan
                                        </h6>

                                        <ul class="timeline-approval mb-0">
                                            
                                            <?php if (!empty($cuti['approval_list'])): ?>
                                                <?php foreach ($cuti['approval_list'] as $app): ?>
                                                    <?php 
                                                        // Style Status
                                                        $status_item = 'status-none';
                                                        $icon_item = '<i class="fa-solid fa-minus"></i>';
                                                        
                                                        if ($app['status'] == 'approved') {
                                                            $status_item = 'status-approved';
                                                            $icon_item = '<i class="fa-solid fa-check"></i>';
                                                        } else if ($app['status'] == 'pending') {
                                                            $status_item = 'status-pending';
                                                            $icon_item = '<i class="fa-solid fa-hourglass-half"></i>';
                                                        } else if ($app['status'] == 'rejected') {
                                                            $status_item = 'status-rejected';
                                                            $icon_item = '<i class="fa-solid fa-xmark"></i>';
                                                        }

                                                        // Variable Session User
                                                        $session_id_pegawai = $this->session->userdata('id_pegawai');
                                                        $session_usergroup  = $this->session->userdata('usergroup'); // Misal: 1 = Superadmin

                                                        //echo $session_usergroup;

                                                        // LOGIKA AKSES TOMBOL APPROVAL:
                                                        // 1. Level approval tersebut berada di langkah aktif (current_step == level_approval)
                                                        // 2. Status item tersebut masih 'pending'
                                                        // 3. User yang login adalah id_pegawai_approval YBS ATAU Usergroup Superadmin (< 2)
                                                        //$is_current_step = ($cuti['current_step'] == $app['level_approval']);

                                                       
                                                        $is_pending      = ($app['status'] == 'pending');

                                                     
                                                        $is_authorized   = ($session_id_pegawai == $app['id_pegawai_approval'] || $session_usergroup < 2);

                                                        //echo  'cureent step = '.$is_current_step .' is_pending = '.$is_pending.' is_authorized = '.$is_authorized;

                                                        $can_approve = ($is_pending && $is_authorized);
                                                    ?>
                                                    <li class="timeline-item <?= $status_item; ?>">
                                                        <div class="timeline-point">
                                                            <?= $icon_item; ?>
                                                        </div>
                                                        <div class="timeline-content">
                                                            <span class="approval-role text-muted">LEVEL <?= $app['level_approval']; ?></span>
                                                            <h6><?= $app['role_approval']; ?></h6>
                                                            
                                                            <p class="text-dark fw-medium mb-1">
                                                                <?= !empty($app['nama_approval']) ? $app['nama_approval'] : '<span class="text-muted fw-normal">(Belum ditentukan)</span>'; ?>
                                                            </p>

                                                            <!-- Status Badge -->
                                                            <?php if ($app['status'] == 'approved'): ?>
                                                                <span class="badge badge-status bg-success-subtle text-success border border-success-subtle">
                                                                    Disetujui
                                                                </span>
                                                                <?php if(!empty($app['approved_at'])): ?>
                                                                    <small class="d-block text-muted mt-1" style="font-size: 0.65rem;">
                                                                        <i class="fa-regular fa-clock"></i> <?= date('d/m/Y H:i', strtotime($app['approved_at'])); ?>
                                                                    </small>
                                                                <?php endif; ?>
                                                            <?php elseif ($app['status'] == 'pending'): ?>
                                                                <span class="badge badge-status bg-warning-subtle text-warning-emphasis border border-warning-subtle">
                                                                    Menunggu Persetujuan
                                                                </span>
                                                            <?php elseif ($app['status'] == 'rejected'): ?>
                                                                <span class="badge badge-status bg-danger-subtle text-danger border border-danger-subtle">
                                                                    Ditolak
                                                                </span>
                                                            <?php elseif ($app['status'] == 'ditangguhkan'): ?>
                                                                <span class="badge badge-status bg-info-subtle text-info border border-info-subtle">
                                                                    Ditangguhkan
                                                                </span>
                                                            <?php endif; ?>

                                                            <!-- Catatan Approval Jika Ada -->
                                                            <?php if (!empty($app['catatan'])): ?>
                                                                <p class="small text-muted bg-light p-2 rounded mt-2 border" style="font-size: 0.75rem;">
                                                                    <em>"<?= $app['catatan']; ?>"</em>
                                                                </p>
                                                            <?php endif; ?>

                                                            <!-- TOMBOL ACTION APPROVAL (Hanya Tampil Jika Memenuhi Syarat) -->
                                                            <?php if ($can_approve): ?>
                                                                <div class="mt-3">
                                                                    <button type="button" 
                                                                            class="btn btn-sm btn-primary w-100 shadow-sm rounded-3 fw-medium"
                                                                            data-bs-toggle="modal" 
                                                                            data-bs-target="#modalApproval"
                                                                            data-id-approval="<?= $app['id']; ?>"
                                                                            data-role="<?= $app['role_approval']; ?>">
                                                                        <i class="fa-solid fa-pen-to-square me-1"></i> Proses Persetujuan
                                                                    </button>
                                                                </div>
                                                            <?php endif; ?>

                                                        </div>
                                                    </li>
                                                <?php endforeach; ?>
                                            <?php else: ?>
                                                <li class="text-center text-muted py-3">Tidak ada data alur approval.</li>
                                            <?php endif; ?>

                                        </ul>
                                    </div>
                                </div>

                              
                                <div class="cuti-card card">
                                    <div class="card-body p-4">
                                        <h6 class="card-title fw-bold text-dark mb-4 d-flex align-items-center">
                                            <i class="fa-solid fa-route text-primary me-2"></i> Hak Cuti
                                        </h6>
                                        

                                        <h6 class="text-primary">Hak Cuti Tahunan</h6>
                                         <table class="table align-middle table-sm fs-2 text-center table-bordered text-nowrap mb-0">
                                            <thead>
                                              <tr>
                                                <th>Tahun</th>
                                                <th>Hak Cuti</th>
                                                <th>Digunakan</th>
                                                <th>Dalam Proses</th>
                                                <th>Sisa Akhir</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                              <?php foreach ($hak_cuti as $tahun => $detail): ?>
                                                <tr>
                                                  <td><?= $tahun; ?></td>
                                                  <td><?= $detail['hak']; ?></td>
                                                  <td><?= $detail['terpakai']; ?></td>
                                                  <td><?= $detail['reserved']; ?></td>
                                                  <td><strong><?= $detail['sisa']; ?></strong></td>
                                                </tr>
                                              <?php endforeach; ?>
                                            </tbody>
                                          </table>

                                          <br>
                                           <h6 class="text-warning">Hak Cuti Bersama</h6>
                                         <table class="table align-middle table-sm fs-2 text-center table-bordered text-nowrap mb-0">
                                            <thead>
                                              <tr>
                                                <th>Tahun</th>
                                                <th>Hak Cuti</th>
                                                <th>Digunakan</th>
                                                <th>Dalam Proses</th>
                                                <th>Sisa Akhir</th>
                                              </tr>
                                            </thead>
                                            <tbody>
                                                  <?php

                                                  if(!empty($hak_cuti_bersama)){
                                                      $tahun2 = $hak_cuti_bersama->tahun;
                                                      $hak_total = $hak_cuti_bersama->hak_total;
                                                      $hak_terpakai = $hak_cuti_bersama->hak_terpakai;
                                                      $hak_reserved = $hak_cuti_bersama->hak_reserved;
                                                      $sisa_akhir = $hak_total -$hak_terpakai-$hak_reserved;

                                                  }else{
                                                     $tahun2 = 0;
                                                      $hak_total = 0;
                                                      $hak_terpakai = 0;
                                                      $hak_reserved = 0;
                                                      $sisa_akhir = 0;
                                                  }

                                                ?>

                                                <tr>
                                                  <td><?= $tahun2 ?></td>
                                                  <td><?= $hak_total ?></td>
                                                  <td><?= $hak_terpakai ?></td>
                                                  <td><?= $hak_reserved ?></td>
                                                  <td><?= $sisa_akhir ?></td>
                                                </tr>
                                            </tbody>
                                          </table>

                                    </div>
                                </div>

                            </div> <!-- End Right Side -->
                          
                            <div class="col-12">
                              <div class="card">
                                <div class="card-body">
                                   <h6 class="card-title fw-bold text-dark mb-4 d-flex align-items-center">
                                            <i class="fa-solid fa-route text-primary me-2"></i> Riwayat Cuti
                                        </h6>
                                   <table class="table align-middle table-sm fs-2 text-center table-bordered text-nowrap mb-0" id="data-table">
                                      <thead>
                                        <tr class="text-muted fw-semibold">
                                          <th>No</th>
                                          <th>Hak Tahun</th>
                                           <th>Hak Cuti</th>
                                          <th>Tanggal Pengajuan</th>
                                          <th scope="col">Jenis Cuti</th>
                                          <th scope="col">Tanggal Mulai</th>
                                          <th scope="col">Tanggal Akhir</th>
                                          <th scope="col">Lama Cuti</th>
                                          <th class="text-start" scope="col">Alasan</th>
                                          <th scope="col">Status</th>
                                          <th scope="col">Aksi</th>
                                        </tr>
                                      </thead>
                                      <tbody class="border-top">
                                        <?php if (!empty($riwayat_cuti)): ?>
                                          <?php 
                                          // Mapping jenis cuti
                                          $list_jenis_cuti = [
                                              1 => 'Cuti Tahunan',
                                              2 => 'Cuti Bersalin',
                                              3 => 'Cuti Alasan Penting',
                                              4 => 'Cuti Sakit',
                                              5 => 'Cuti Besar',
                                              6 => 'Cuti Bersalin Anak ke-3'
                                          ];

                                          $no = 1;
                                          foreach ($riwayat_cuti as $row): 
                                            // Ambil nama jenis cuti
                                          $nama_jenis_cuti = (isset($list_jenis_cuti[$row->jenis_cuti]) && $list_jenis_cuti[$row->jenis_cuti] != '') 
                                          ? $list_jenis_cuti[$row->jenis_cuti] 
                                          : 'Cuti Lainnya';

                                            // Badge Status Styling
                                            $status = strtolower($row->status_akhir);
                                            if ($status == 'proses') {
                                                $badge_status = '<span class="badge bg-warning-subtle text-warning px-2 py-1 fs-2">Proses</span>';
                                            } elseif ($status == 'disetujui' || $status == 'acc') {
                                                $badge_status = '<span class="badge bg-success-subtle text-success px-2 py-1  fs-2">Disetujui</span>';
                                            } elseif ($status == 'ditolak') {
                                                $badge_status = '<span class="badge bg-danger-subtle text-danger px-2 py-1  fs-2">Ditolak</span>';
                                            } else {
                                                $badge_status = '<span class="badge bg-secondary-subtle text-secondary px-2 py-1  fs-2">' . ucfirst($status) . '</span>';
                                            }
                                          ?>
                                            <tr>
                                              <td><?= $no++ ?></td>
                                              <td><?= $row->tahun_hak_cuti; ?></td>
                                              <td><?= $row->jenis_hak_cuti; ?></td>
                                              <td><?= format_semi($row->tgl_pengajuan) ?></td>
                                              <td><span class="fw-semibold text-dark"><?= $nama_jenis_cuti ?></span></td>
                                              <td><?= format_semi($row->tgl_mulai) ?></td>
                                              <td><?= format_semi($row->tgl_selesai) ?></td>
                                              <td><?= $row->lama_cuti ?> Hari</td>
                                              <td class="text-start"><?= htmlspecialchars($row->alasan_cuti) ?></td>
                                              <td><?= $badge_status ?></td>
                                              <td>
                                                <a href="<?= base_url('admin/pegawai/detail_cuti/' . $row->id) ?>" class="btn btn-sm btn-info text-white">
                                                  <i class="ti ti-eye me-1"></i> Detail
                                                </a>
                                              </td>
                                            </tr>
                                          <?php endforeach; ?>
                                        <?php else: ?>
                                          <tr>
                                            <td colspan="9" class="text-muted">Belum ada riwayat pengajuan cuti.</td>
                                          </tr>
                                        <?php endif; ?>
                                      </tbody>
                                    </table>
                                </div>
                              </div>
                            </div>


                      </div>
           

                       <!-- ========================================== -->
                            <!-- MODAL ACTION APPROVAL -->
                        <div class="modal fade" id="modalApproval" tabindex="-1" aria-labelledby="modalApprovalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg rounded-4">
                                    <div class="modal-header border-bottom-0 pb-0">
                                        <h5 class="modal-title fw-bold text-dark" id="modalApprovalLabel">Proses Persetujuan Cuti</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    
                                    <?= form_open('admin/cuti/proses_approval', ['id' => 'formApproval']); ?>
                                        <div class="modal-body py-3">
                                            <!-- Hidden Input Data -->
                                            <input type="hidden" name="id_pengajuan_cuti" value="<?= $cuti['id']; ?>">
                                            <input type="hidden" name="id_approval" id="modal_id_approval" value="">
                                            <!-- Hidden Input Hasil TTD Digital (Base64) -->
                                            <input type="hidden" name="ttd_digital" id="ttd_digital_input" value="">

                                            <p class="text-muted small mb-3">
                                                Anda akan memproses persetujuan cuti sebagai <strong id="modal_role_text" class="text-dark"></strong>.
                                            </p>

                                            <!-- 1. Pilihan Opsi Status (Radio di Sebelah Kanan) -->
                                            <div class="mb-3">
                                                <label class="form-label text-xs fw-semibold text-uppercase text-muted">Tindakan</label>
                                                <div class="d-flex flex-column gap-2">
                                                    
                                                    <!-- Option Setujui -->
                                                    <label for="opt_approve" class="border rounded-3 p-3 d-flex align-items-center justify-content-between cursor-pointer">
                                                        <span class="fw-semibold text-success">
                                                            <i class="fa-solid fa-circle-check me-2"></i> Setujui Pengajuan
                                                        </span>
                                                        <input class="form-check-input m-0 fs-5" type="radio" name="status" id="opt_approve" value="approved" checked>
                                                    </label>

                                                    <!-- Option Tolak -->
                                                    <label for="opt_reject" class="border rounded-3 p-3 d-flex align-items-center justify-content-between cursor-pointer">
                                                        <span class="fw-semibold text-danger">
                                                            <i class="fa-solid fa-circle-xmark me-2"></i> Tolak Pengajuan
                                                        </span>
                                                        <input class="form-check-input m-0 fs-5" type="radio" name="status" id="opt_reject" value="rejected">
                                                    </label>

                                                    <!-- Option Tangguhkan -->
                                                    <label for="opt_hold" class="border rounded-3 p-3 d-flex align-items-center justify-content-between cursor-pointer">
                                                        <span class="fw-semibold text-info">
                                                            <i class="fa-solid fa-circle-pause me-2"></i> Tangguhkan
                                                        </span>
                                                        <input class="form-check-input m-0 fs-5" type="radio" name="status" id="opt_hold" value="ditangguhkan">
                                                    </label>

                                                </div>
                                            </div>

                                            <!-- 2. Area Canvas Tanda Tangan Digital -->
                                            <div class="mb-3">
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <label class="form-label text-xs fw-semibold text-uppercase text-muted mb-0">Tanda Tangan Digital</label>
                                                    <button type="button" class="btn btn-link text-danger btn-sm p-0 text-decoration-none" id="clear_signature">
                                                        <i class="fa-solid fa-rotate-left me-1"></i> Reset TTD
                                                    </button>
                                                </div>
                                                <div class="border rounded-3 bg-light position-relative overflow-hidden" style="touch-action: none;">
                                                    <canvas id="signature-pad" class="w-100" height="150" style="cursor: crosshair; display: block;"></canvas>
                                                    <div class="position-absolute bottom-0 start-0 w-100 text-center pb-1 pointer-events-none" style="pointer-events: none;">
                                                        <small class="text-muted opacity-50" style="font-size: 0.65rem;">Goreskan tanda tangan di atas area ini</small>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- 3. Input Catatan -->
                                            <div class="mb-2">
                                                <label for="catatan" class="form-label text-xs fw-semibold text-uppercase text-muted">Catatan / Alasan</label>
                                                <textarea class="form-control rounded-3" name="catatan" id="catatan" rows="2" placeholder="Tambahkan alasan atau catatan (Opsional)"></textarea>
                                            </div>
                                        </div>

                                        <div class="modal-footer border-top-0 pt-0">
                                            <button type="button" class="btn btn-light rounded-3" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary rounded-3 px-4">Simpan Keputusan</button>
                                        </div>
                                    <?= form_close(); ?>
                                </div>
                            </div>
                        </div>

      <script>
          function handleColorTheme(e) {
            $("html").attr("data-color-theme", e);
            $(e).prop("checked", !0);
          }
        </script>

        <?php $this->load->view('layout/section/theme-setting.php');?>

        <?php $this->load->view('master/request-cuti.php');?>

  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->

    <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>
    <script src="../assets/js/app.init.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.min.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>theme.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>init.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>jquery.blockUI.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>block-ui.js"></script>


    <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>

    <!-- CDN Signature Pad JS -->
<script src="https://cdn.jsdelivr.net/npm/signature_pad@4.1.7/dist/signature_pad.umd.min.js"></script>

</body>




<script>



document.addEventListener('DOMContentLoaded', function () {
    var modalApproval = document.getElementById('modalApproval');
    var canvas = document.getElementById('signature-pad');
    var signaturePad;

    // Resize canvas agar presisi
    function resizeCanvas() {
        var ratio =  Math.max(window.devicePixelRatio || 1, 1);
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        canvas.getContext("2d").scale(ratio, ratio);
        if (signaturePad) {
            signaturePad.clear();
        }
    }

    if (modalApproval) {
        modalApproval.addEventListener('shown.bs.modal', function (event) {
            var button = event.relatedTarget;
            var idApproval = button.getAttribute('data-id-approval');
            var role = button.getAttribute('data-role');

            modalApproval.querySelector('#modal_id_approval').value = idApproval;
            modalApproval.querySelector('#modal_role_text').textContent = role;

            // Inisialisasi Signature Pad saat modal terbuka
            if (!signaturePad) {
                signaturePad = new SignaturePad(canvas, {
                    backgroundColor: 'rgb(248, 249, 250)', // Warna latar canvas (bg-light)
                    penColor: 'rgb(15, 23, 42)'             // Warna tinta
                });
            }
            resizeCanvas();
        });

        // Event Tombol Reset TTD
        document.getElementById('clear_signature').addEventListener('click', function () {
            if (signaturePad) {
                signaturePad.clear();
            }
        });

        // Submit Form Handling
        document.getElementById('formApproval').addEventListener('submit', function (e) {
            if (signaturePad && !signaturePad.isEmpty()) {
                // Simpan TTD dalam bentuk String Base64 PNG ke hidden input
                var dataUrl = signaturePad.toDataURL('image/png');
                document.getElementById('ttd_digital_input').value = dataUrl;
            } else {
                document.getElementById('ttd_digital_input').value = '';
            }
        });
    }
});
 

</script>
</html>