<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    :root {

      --bs-body-font-family: 'Inter', system-ui, -apple-system, sans-serif;
      --primary-color: #0d6efd;
      --card-border-radius: 12px;
    }


    /* Top Navigation Tabs */
    .nav-tabs-custom {
      border-bottom: 2px solid #e2e8f0;
      background: #ffffff;
      padding: 0 1.5rem;
      border-radius: var(--card-border-radius);
    }
    .nav-tabs-custom .nav-link {
      border: none;
      color: #64748b;
      font-weight: 500;
      padding: 1rem 1.25rem;
      border-bottom: 3px solid transparent;
      transition: all 0.2s ease;
    }
    .nav-tabs-custom .nav-link:hover {
      color: var(--primary-color);
    }
    .nav-tabs-custom .nav-link.active {
      color: var(--primary-color);
      border-bottom-color: var(--primary-color);
      background: transparent;
      font-weight: 600;
    }

    /* Cards */
    .custom-card {
      background: #ffffff;
      border: 1px solid #e2e8f0;
      border-radius: var(--card-border-radius);
      box-shadow: 0 1px 3px rgba(0,0,0,0.02);
      margin-bottom: 1.5rem;
    }
    .card-header-clean {
      padding: 1.25rem 1.5rem 0.5rem;
      background: transparent;
      border-bottom: none;
    }
    .card-header-clean h5 {
      font-size: 1.1rem;
      font-weight: 700;
      color: #0f172a;
      margin: 0;
    }
    .card-header-clean p {
      font-size: 0.875rem;
      color: #64748b;
      margin: 0.25rem 0 0;
    }

    /* Profile Avatar Styling */
    .avatar-wrapper {
      position: relative;
      width: 100px;
      height: 100px;
      margin: 0 auto;
    }
    .avatar-img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #f1f5f9;
      background-color: #e2e8f0;
    }
    .avatar-edit-btn {
      position: absolute;
      bottom: 0;
      right: 0;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      background: var(--primary-color);
      color: white;
      border: 2px solid white;
      display: flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 0.85rem;
      transition: transform 0.2s;
    }
    .avatar-edit-btn:hover {
      transform: scale(1.1);
    }

    /* Form Controls */
    .form-label {
      font-size: 0.85rem;
      font-weight: 600;
      color: #475569;
      margin-bottom: 0.4rem;
    }
    .form-control, .form-select {
      border-color: #cbd5e1;
      padding: 0.6rem 0.85rem;
      font-size: 0.9rem;
      border-radius: 8px;
    }
    .form-control:focus, .form-select:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }
    .form-control[readonly], .form-control:disabled {
      background-color: #f8fafc;
      color: #64748b;
    }

    /* Sticky Bottom Action Bar */
    .sticky-bottom-bar {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: #ffffff;
      border-top: 1px solid #e2e8f0;
      padding: 0.9rem 2rem;
      box-shadow: 0 -4px 12px rgba(0,0,0,0.05);
      z-index: 1030;
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

        <?php $this->load->view('layout/section/sidebar'); ?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header'); ?>
      <!--  Header End -->
 <?php

                $id_pegawai = $pegawai[0]->id_pegawai;
                $tgl_masuk = $pegawai[0]->tgl_masuk;
                $nip = $pegawai[0]->nip;
                $nama_pegawai = $pegawai[0]->nama;
                $photo = $this->Pegawai_model->getPhotoPegawai($nip);

                if ($photo == '') {
                $photo = 'avatar.png';
                }


                $arrayStatusPajak = array('TK', 'K0', 'K1', 'K2');
                $array_group = arrayUsergroup();


                $message = $this->session->flashdata('message');

                $data = $pegawai[0];
                $detail_pegawai = $data_detail_pegawai[0];
          ?>


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
                      <a href="<?php echo base_url();?>admin/pegawai/data_pegawai/<?= $data->jns_pegawai; ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                         <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
                      </a>
                  </div>
                </div>
              </div>


            </div>
          </div>
         

          <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
              
                <div class="card-body">

                <form id="formEditPegawai" method="post" action="<?php echo base_url();?>admin/pegawai/update_data_pegawai/<?php echo $pegawai[0]->id_pegawai.'/'.$pegawai[0]->nip;?>" enctype="multipart/form-data">
                      <!-- Top Navigation Tabs -->
                        <div class="custom-card mb-4">
                          <ul class="nav nav-tabs-custom" id="pegawaiTab" role="tablist">
                            <li class="nav-item" role="presentation">
                              <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button"><i class="bi bi-person me-2"></i>Account & Profil</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="sip-tab" data-bs-toggle="tab" data-bs-target="#sip" type="button"><i class="bi bi-file-earmark-text me-2"></i>SIP / STR</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="cuti-tab" data-bs-toggle="tab" data-bs-target="#cuti" type="button"><i class="bi bi-calendar-event me-2"></i>Data Cuti</button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link" id="pelatihan-tab" data-bs-toggle="tab" data-bs-target="#pelatihan" type="button"><i class="bi bi-award me-2"></i>Pelatihan</button>
                            </li>
                          </ul>
                        </div>

                        <div class="row g-4">
                          
              
                              <!-- LEFT COLUMN: Profile Sidebar & Quick Actions -->
                              <div class="col-lg-4 col-xl-3">
                                <div class="custom-card p-4 text-center">
                                  <!-- Avatar Section -->
                                  <div class="avatar-wrapper mb-3">
                                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($data->nama) ?>&background=0D8ABC&color=fff" alt="Foto Pegawai" class="avatar-img">
                                    <label class="avatar-edit-btn" title="Ubah Foto">
                                      <i class="bi bi-camera"></i>
                                      <input type="file" name="foto_profil" class="d-none" accept="image/*">
                                    </label>
                                  </div>
                                 <h5 class="fw-bold mb-1"><?= htmlspecialchars($data->nama) ?></h5>
                                  <p class="text-muted small mb-2">NIP: <?= htmlspecialchars($data->nip ?? '-') ?></p>
                                  <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 mb-3">
                                    <?= strtoupper($data->jns_pegawai) ?>
                                  </span>

                                  <hr class="my-3 text-muted opacity-25">

                                  <!-- Status Kepegawaian Input -->
                                 <div class="text-start mb-3">
                                  <label class="form-label">Status Kepegawaian</label>
                                  <select class="form-select fw-semibold" name="status_kerja">
                                    <option value="1" <?= $data->status_kerja == '1' ? 'selected' : '' ?>>🟢 Aktif</option>
                                    <option value="2" <?= $data->status_kerja == '2' ? 'selected' : '' ?>>🟡 Cuti Bersalin / Cuti</option>
                                    <option value="0" <?= $data->status_kerja == '0' ? 'selected' : '' ?>>🔴 Tidak Aktif</option>
                                  </select>
                                </div>

                                  <!-- Quick Action Buttons -->
                                  <div class="d-grid gap-2 mt-4">
                                    <button type="button" class="btn btn-outline-warning text-dark text-start btn-sm py-2 px-3">
                                      <i class="bi bi-key me-2"></i> Reset Password
                                    </button>
                                    <button type="button" class="btn btn-outline-danger text-start btn-sm py-2 px-3" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                      <i class="bi bi-trash me-2"></i> Hapus Pegawai
                                    </button>
                                  </div>
                                </div>

                                <!-- Info Card Summary -->
                              <div class="custom-card p-3">
                                <div class="d-flex align-items-center gap-3">
                                  <div class="p-2 bg-light rounded text-primary fs-4">
                                    <i class="bi bi-fingerprint"></i>
                                  </div>
                                  <div>
                                    <div class="text-muted extra-small">ID Mesin Absensi</div>
                                    <div class="fw-bold text-dark"><?= !empty($data->id_mesin) ? htmlspecialchars($data->id_mesin) : '— (Belum Diatur)' ?></div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            

                              <!-- RIGHT COLUMN: Detailed Form Cards -->
                              <div class="col-lg-8 col-xl-9" style="margin-bottom:50px">
                                                              
                                  <!-- Card 1: Informasi Kepegawaian & Identitas -->
                                  <div class="custom-card">
                                    <div class="card-header-clean">
                                      <h5>Informasi Akun & Kepegawaian</h5>
                                      <p>Data identitas utama pegawai dan status administrasi</p>
                                    </div>
                                    <div class="p-4">
                                      <div class="row g-3">
                                            
                                            <!-- Nama Lengkap -->
                                            <div class="col-md-6">
                                              <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                              <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($data->nama) ?>" required>
                                            </div>

                                            <!-- TMT -->
                                            <div class="col-md-6">
                                              <label class="form-label">TMT (Tanggal Mulai Tugas)</label>
                                              <input type="date" class="form-control" name="tmt" value="<?= htmlspecialchars($data->tmt) ?>">
                                            </div>

                                            <!-- NIP -->
                                            <div class="col-md-6">
                                              <label class="form-label">NIP (Nomor Induk Pegawai)</label>
                                              <input type="text" class="form-control" name="nip" value="<?= htmlspecialchars($data->nip) ?>">
                                            </div>

                                            <!-- NRK -->
                                            <div class="col-md-6">
                                              <label class="form-label">NRK (Nomor Registrasi Kepegawaian)</label>
                                              <input type="text" class="form-control" name="nrk" value="<?= htmlspecialchars($data->nrk) ?>">
                                            </div>

                                            <!-- ID Mesin -->
                                            <div class="col-md-6">
                                              <label class="form-label">ID Mesin Absensi</label>
                                              <input type="text" class="form-control" name="id_mesin" value="<?= htmlspecialchars($data->id_mesin) ?>" placeholder="Masukkan ID mesin">
                                            </div>

                                            <!-- Jenis Pegawai -->
                                            <div class="col-md-6">
                                              <label class="form-label">Status / Jenis Pegawai</label>
                                              <select class="form-select" name="jns_pegawai">
                                                <option value="non_pns" <?= $data->jns_pegawai == 'non_pns' ? 'selected' : '' ?>>NON PNS</option>
                                                <option value="pns" <?= $data->jns_pegawai == 'pns' ? 'selected' : '' ?>>PNS</option>
                                                <option value="pppk" <?= $data->jns_pegawai == 'pppk' ? 'selected' : '' ?>>PPPK</option>
                                                <option value="pjlp" <?= $data->jns_pegawai == 'pjlp' ? 'selected' : '' ?>>PJLP</option>
                                              </select>
                                            </div>

                                            <!-- Jabatan -->
                                            <div class="col-md-6">
                                              <label class="form-label">Jabatan</label>
                                              <select class="form-select" name="id_jabatan">
                                                <option value="">-- Pilih Jabatan --</option>
                                                <?php foreach ($list_jabatan as $jabatan): ?>
                                                  <option value="<?= $jabatan->id ?>" <?= $jabatan->id == $data->id_jabatan ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($jabatan->nama) ?>
                                                  </option>
                                                <?php endforeach; ?>
                                              </select>
                                            </div>

                                            <!-- Golongan -->
                                            <div class="col-md-6">
                                              <label class="form-label">Golongan</label>
                                              <input type="text" class="form-control" name="golongan" value="<?= htmlspecialchars($data->golongan) ?>">
                                            </div>

                                      </div>
                                    </div>
                                  </div>

                                  <!-- Card 2: Detail Personal & Placement -->
                                  <div class="custom-card">
                                    <div class="card-header-clean">
                                      <h5>Personal Details & Unit Kerja</h5>
                                      <p>Pengaturan penempatan, atasan, dan status perpajakan</p>
                                    </div>
                                    <div class="p-4">
                                      <div class="row g-3">
                                        <!-- Puskesmas -->
                                        <div class="col-md-4">
                                          <label class="form-label">Puskesmas / Unit Kerja</label>
                                          <select class="form-select" name="id_puskesmas">
                                            <option value="">-- Pilih Puskesmas --</option>
                                            <?php foreach ($list_puskesmas as $puskesmas): ?>
                                              <option value="<?= $puskesmas->id_puskesmas ?>" <?= $puskesmas->id_puskesmas == $data->id_puskesmas ? 'selected' : '' ?>>
                                                <?= htmlspecialchars($puskesmas->nama) ?>
                                              </option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>


                                         <!-- Atasan Langsung / Validator -->
                                            <div class="col-md-4">
                                              <label class="form-label">Atasan Langsung (Validator)</label>
                                              <select class="form-select" name="id_validator">
                                                <option value="">-- Pilih Validator --</option>
                                                <?php foreach ($list_validator as $val): ?>
                                                  <option value="<?= $val->id_pegawai ?>" <?= $val->id_pegawai == $data->id_validator ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($val->nama) ?>
                                                  </option>
                                                <?php endforeach; ?>
                                              </select>
                                            </div>

                                        
                                       <!-- Poli / Layanan -->
                                          <div class="col-md-4">
                                            <label class="form-label">Poli / Layanan</label>
                                            <select class="form-select" name="id_poli">
                                              <option value="">-- Pilih Poli --</option>
                                              <?php foreach ($list_poli as $poli): ?>
                                                <option value="<?= $poli->id ?>" <?= $poli->id == $data->id_poli ? 'selected' : '' ?>>
                                                  <?= htmlspecialchars($poli->nama_poli) ?>
                                                </option>
                                              <?php endforeach; ?>
                                            </select>
                                          </div>


                                            <!-- Pendidikan -->
                                            <div class="col-md-4">
                                              <label class="form-label">Pendidikan Terakhir</label>
                                              <select class="form-select" name="id_pendidikan">
                                                <option value="">-- Pilih Pendidikan --</option>
                                                <?php foreach ($list_pendidikan as $pend): ?>
                                                  <option value="<?= $pend->id ?>" <?= $pend->id == $data->id_pendidikan ? 'selected' : '' ?>>
                                                    <?= htmlspecialchars($pend->pendidikan) ?>
                                                  </option>
                                                <?php endforeach; ?>
                                              </select>
                                            </div>
                                            
                                        <div class="col-md-4">
                                          <label class="form-label">Status Kawin (Tunjangan)</label>
                                          <select class="form-select" name="status_kawin">
                                               <?php
                                                foreach ($list_Status as $status_kawin){
                                                                            
                                                  $id_status = $status_kawin->id;
                                                  $status = $status_kawin->status;
                                                  $ket_status = $status_kawin->ket;

                                                  if($id_status==$pegawai[0]->status_kawin){
                                                    echo ' <option value="'. $id_status .'" selected>'.$status .' - '.$ket_status.'</option>';
                                                  }else{
                                                    echo ' <option value="'. $id_status .'">'.$status .' - '.$ket_status.'</option>';
                                                  }
                                                

                                                }

                                            ?>
                                          </select>
                                        </div>
                                        <div class="col-md-4">
                                          <label class="form-label">Rumpun Kerja</label>
                                            <select class="form-select" name="rumpun_kerja">
                                              <option value="admen" <?= $data->rumpun_kerja == 'admen' ? 'selected' : '' ?>>ADMEN (Administrasi & Manajemen)</option>
                                              <option value="ukp" <?= $data->rumpun_kerja == 'ukp' ? 'selected' : '' ?>>UKP (Upaya Kesehatan Perseorangan)</option>
                                              <option value="ukm" <?= $data->rumpun_kerja == 'ukm' ? 'selected' : '' ?>>UKM (Upaya Kesehatan Masyarakat)</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                          <label class="form-label">Jam Kerja</label>
                                            <select class="form-select" name="jns_jam_kerja">
                                              <option value="non_shift" <?= $data->jns_jam_kerja == 'non_shift' ? 'selected' : '' ?>>Non-Shift (Regular)</option>
                                              <option value="shift" <?= $data->jns_jam_kerja == 'shift' ? 'selected' : '' ?>>Shift</option>
                                            </select>
                                        </div>

                                       
                                         <div class="col-md-4">
                                          <label class="form-label">Status Pajak (PTKP)</label>
                                          <select class="form-select" name="status_pajak" aria-label="Default select example">
                                            <?php foreach ($arrayStatusPajak as $status_pajak): ?>
                                              <option value="<?= $status_pajak ?>" <?= $status_pajak == $pegawai[0]->status_pajak ? 'selected' : '' ?>>
                                                <?= $status_pajak ?>
                                              </option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>

                                        <div class="col-md-4">
                                          <label class="form-label">Usergroup Access</label>
                                          <select class="form-select" name="usergroup" aria-label="Default select example">
                                            <?php foreach ($array_group as $ug_id => $group): ?>
                                              <option value="<?= $ug_id ?>" <?= $ug_id == $pegawai[0]->usergroup ? 'selected' : '' ?>>
                                                <?= $group ?>
                                              </option>
                                            <?php endforeach; ?>
                                          </select>
                                        </div>

                                         <div class="col-md-4">
                                            <label class="form-label">Kelompok Klaster</label>
                                              <select class="form-select" name="klaster">
                                                <?php
                                                  for($a=1; $a< 6; $a++){?>
                                                     <option value="<?= $a ?>"  <?= $data->klaster==$a?"selected":"" ?>>Klaster <?= $a ?></option>
                                                  <?php }?>
                                            
                                              </select>
                                        </div>
                                          <div class="col-md-4">
                                            <label class="form-label">Email</label>
                                            <div class="input-group">
                                              <span class="input-group-text"><i class="ti ti-mail fs-6"></i></span>
                                              <input 
                                                type="text" 
                                                class="form-control" 
                                                name="email" 
                                                value="<?= htmlspecialchars($detail_pegawai->email ?? '') ?>" 
                                                placeholder="masukkan email" 
                                                required>
                                            </div>
                                            
                                          </div>

                                           <div class="col-md-4">
                                              <label class="form-label">No Handphone</label>
                                              <div class="input-group">
                                                <span class="input-group-text"><i class="ti ti-phone fs-6"></i></span>
                                                <input 
                                                  type="text" 
                                                  class="form-control" 
                                                  name="no_telp" 
                                                  value="<?= htmlspecialchars($detail_pegawai->no_tlp ?? '') ?>" 
                                                  placeholder="Contoh: 081234567890" 
                                                  maxlength="15"
                                                  minlength="10"
                                                  pattern="[0-9]{10,15}"
                                                  inputmode="numeric"
                                                  oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                              </div>
                                              <div class="form-text extra-small">Minimal 10 digit angka.</div>
                                            </div>


                                      </div>

                                      <div class="row g-3 mt-1">
  
                                          <!-- Input NIK -->
                                          <div class="col-md-4">
                                            <label class="form-label">NIK (Nomor Induk Kependudukan) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                              <span class="input-group-text"><i class="ti ti-user-circle fs-6"></i></span>
                                              <input 
                                                type="text" 
                                                class="form-control" 
                                                name="nik" 
                                                value="<?= htmlspecialchars($detail_pegawai->no_ktp ?? '') ?>" 
                                                placeholder="16 Digit NIK" 
                                                maxlength="16"
                                                minlength="16"
                                                pattern="[0-9]{16}"
                                                inputmode="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                                >
                                            </div>
                                            <div class="form-text extra-small">Harus 16 digit angka.</div>
                                          </div>

                                          <!-- Input NPWP -->
                                          <div class="col-md-4">
                                            <label class="form-label">NPWP (Nomor Pokok Wajib Pajak)</label>
                                            <div class="input-group">
                                              <span class="input-group-text"><i class="ti ti-cards fs-6"></i></span>
                                              <input 
                                                type="text" 
                                                class="form-control" 
                                                id="npwp_input"
                                                name="npwp" 
                                                value="<?= htmlspecialchars($detail_pegawai->npwp ?? '') ?>" 
                                                placeholder="XX.XXX.XXX.X-XXX.XXX" 
                                                maxlength="20"
                                                inputmode="numeric">
                                            </div>
                                            <div class="form-text extra-small">Contoh: 12.345.678.9-012.000</div>
                                          </div>

                                          <!-- Input No. Rekening & Bank -->
                                          <div class="col-md-4">
                                            <label class="form-label">No. Rekening Bank</label>
                                            <div class="input-group">
                                              <span class="input-group-text"><i class="ti ti-building fs-6"></i></span>
                                              <input 
                                                type="text" 
                                                class="form-control" 
                                                name="no_rekening" 
                                                value="<?= htmlspecialchars($detail_pegawai->no_rekening ?? '') ?>" 
                                                placeholder="Nomor Rekening Tabungan" 
                                                inputmode="numeric"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                            </div>
                                            <div class="form-text extra-small">Khusus angka tanpa titik/spasi.</div>
                                          </div>

                                        </div>
                                    </div>
                                  </div>

                              </div>

                       </div>



              </div>
            </div>
          </div>


          <!-- Sticky Bottom Action Bar -->
          <div class="sticky-bottom-bar d-flex justify-content-between align-items-center">
            <div class="text-muted small d-none d-sm-block">
              <i class="bi bi-info-circle me-1"></i> Pastikan seluruh data bertanda bintang (*) telah terisi.
            </div>
            <div class="d-flex gap-2 ms-auto">
              <button type="button" class="btn btn-light border px-4">Batal</button>
              <button type="submit" class="btn btn-primary px-4 fw-semibold">
                <i class="bi bi-check-lg me-1"></i> Simpan Perubahan
              </button>
            </div>
          </div>

       </form>

          <!-- Modal Konfirmasi Hapus -->
          <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content border-0 shadow">
                <div class="modal-body p-4 text-center">
                  <div class="text-danger mb-3" style="font-size: 3rem;">
                    <i class="bi bi-exclamation-triangle"></i>
                  </div>
                  <h5 class="fw-bold mb-2">Hapus Data Pegawai?</h5>
                  <p class="text-muted small mb-4">Apakah Anda yakin ingin menghapus data pegawai <strong>Dina Aryani</strong>? Tindakan ini tidak dapat dibatalkan.</p>
                  <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger px-4">Ya, Hapus</button>
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


        <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>


                <!-- jQuery (Jika belum ada) -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

        <!-- SweetAlert2 CSS & JS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>


      <script>
      $(document.body).ready(function() {
          $('#formEditPegawai').on('submit', function(e) {
              e.preventDefault(); // Mencegah reload halaman biasa

              var form = $(this);
              var actionUrl = form.attr('action');
              var formData = new FormData(this); // Menggunakan FormData agar bisa menangani input file/foto

              // Menampilkan Loading Alert
              Swal.fire({
                  title: 'Menyimpan Data...',
                  text: 'Mohon tunggu sebentar',
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  didOpen: () => {
                      Swal.showLoading();
                  }
              });

              // Kirim via AJAX
              $.ajax({
                  type: "POST",
                  url: actionUrl,
                  data: formData,
                  contentType: false,
                  processData: false,
                  dataType: "json", // Mengolah response bertipe JSON dari Controller
                  success: function(response) {
                      if (response.status === 'success' || response.status === true) {
                          Swal.fire({
                              icon: 'success',
                              title: 'Berhasil!',
                              text: response.message || 'Data pegawai berhasil diperbarui.',
                              timer: 2000,
                              showConfirmButton: true,
                              confirmButtonText: 'OK'
                          }).then((result) => {
                              // Opsional: Reload halaman atau redirect setelah sukses
                              location.reload();
                              // Atau redirect: window.location.href = '<?= base_url("admin/pegawai") ?>';
                          });
                      } else {
                          Swal.fire({
                              icon: 'error',
                              title: 'Gagal Menyimpan!',
                              text: response.message || 'Terjadi kesalahan saat memperbarui data.',
                              confirmButtonText: 'Tutup'
                          });
                      }
                  },
                  error: function(xhr, status, error) {
                      console.error(xhr.responseText);
                      Swal.fire({
                          icon: 'error',
                          title: 'Terjadi Kesalahan Server!',
                          text: 'Tidak dapat menghubungkan ke server. Silakan coba beberapa saat lagi.',
                          confirmButtonText: 'Tutup'
                      });
                  }
              });
          });
      });
      </script>

</html>