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

  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <?php $this->load->view('layout/section/sidebar'); ?>
    </aside>
    <!-- Sidebar End -->

    <div class="page-wrapper">
      <!-- Header Start -->
      <?php $this->load->view('layout/section/header'); ?>
      <!-- Header End -->

      <?php
        $data           = isset($pegawai[0]) ? $pegawai[0] : null;
        $detail_pegawai = isset($data_detail_pegawai[0]) ? $data_detail_pegawai[0] : null;

        $id_pegawai   = isset($data->id_pegawai) ? $data->id_pegawai : '';
        $nip          = isset($data->nip) ? $data->nip : '';
        $nama_pegawai = isset($data->nama) ? $data->nama : '';

        // Ambil Foto Profil
        $photo_name = $this->Pegawai_model->getPhotoPegawai($nip); 
        $file_path  = FCPATH . 'uploads/photo_profile/' . $photo_name;

        if (!empty($photo_name) && file_exists($file_path)) {
            $avatar_url = base_url('uploads/photo_profile/' . $photo_name);
        } else {
            $avatar_url = 'https://ui-avatars.com/api/?name=' . urlencode($nama_pegawai) . '&background=0D8ABC&color=fff&size=128';
        }

        $arrayStatusPajak = array('TK', 'K0', 'K1', 'K2');
        $array_group      = function_exists('arrayUsergroup') ? arrayUsergroup() : array();
      ?>

      <div class="body-wrapper">
        <div class="container-fluid">
          
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Edit Data Profile</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="<?= base_url('admin/pegawai'); ?>">Data Pegawai</a>
                      </li>
                      <li> &nbsp; / &nbsp; </li>
                      <li class="breadcrumb-active">Edit Data</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3 text-end">
                  <a href="<?= base_url('profile/my_profile/' . $id_pegawai); ?>" class="btn btn-outline-secondary btn-sm rounded-pill px-3">
                     <i class="ti ti-arrow-left me-1"></i> Kembali
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-lg-12">
              <div class="card-body">

                <form id="formEditPegawai" method="post" action="<?= base_url('profile/update_profile'); ?>" enctype="multipart/form-data">

                  <div class="row g-4">
                    
                    <!-- LEFT COLUMN: Profile Sidebar -->
                    <div class="col-lg-4 col-xl-3">
                      <div class="custom-card p-4 text-center">
                        
                        <!-- Avatar Section -->
                        <div class="avatar-wrapper mb-3">
                          <img src="<?= $avatar_url ?>" alt="Foto <?= htmlspecialchars($nama_pegawai) ?>" class="avatar-img" id="preview-avatar">
                          <label class="avatar-edit-btn" title="Ubah Foto">
                            <i class="ti ti-camera"></i>
                            <input type="file" name="foto_profil" class="d-none" accept="image/*" onchange="previewImage(this)">
                          </label>
                        </div>

                        <h5 class="fw-bold mb-1"><?= htmlspecialchars($nama_pegawai) ?></h5>
                        <p class="text-muted small mb-2">NIP: <?= (isset($data->nip) && $data->nip != '') ? htmlspecialchars($data->nip) : '-' ?></p>
                        <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 mb-3">
                          <?= isset($data->jns_pegawai) ? strtoupper($data->jns_pegawai) : 'N/A' ?>
                        </span>

                        <hr class="my-3 text-muted opacity-25">

                        <!-- Status Kepegawaian Input -->
                        <div class="text-start mb-3">
                          <label class="form-label">Status Kepegawaian</label>
                          <select class="form-select fw-semibold" disabled name="status_kerja">
                            <option value="1" <?= (isset($data->status_kerja) && $data->status_kerja == '1') ? 'selected' : '' ?>>🟢 Aktif</option>
                            <option value="2" <?= (isset($data->status_kerja) && $data->status_kerja == '2') ? 'selected' : '' ?>>🟡 Cuti Bersalin / Cuti</option>
                            <option value="0" <?= (isset($data->status_kerja) && $data->status_kerja == '0') ? 'selected' : '' ?>>🔴 Tidak Aktif</option>
                          </select>
                        </div>

                      
                      </div>

                      <!-- Info Card Summary -->
                      <div class="custom-card p-3">
                        <div class="d-flex align-items-center gap-3">
                          <div class="p-2 bg-light rounded text-primary fs-4">
                            <i class="ti ti-fingerprint"></i>
                          </div>
                          <div>
                            <div class="text-muted extra-small">ID Mesin Absensi</div>
                            <div class="fw-bold text-dark"><?= (isset($data->id_mesin) && !empty($data->id_mesin)) ? htmlspecialchars($data->id_mesin) : '— (Belum Diatur)' ?></div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- RIGHT COLUMN: Detailed Form Cards -->
                    <div class="col-lg-8 col-xl-9" style="margin-bottom:80px">
                                                    
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
                              <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($nama_pegawai) ?>" required>
                            </div>

                            <!-- TMT -->
                            <div class="col-md-6">
                              <label class="form-label">TMT (Tanggal Mulai Tugas)</label>
                              <input type="date" class="form-control" readonly name="tmt" value="<?= (isset($data->tmt) && $data->tmt != '0000-00-00') ? htmlspecialchars($data->tmt) : '' ?>">
                            </div>

                            <!-- NIP -->
                            <div class="col-md-6">
                              <label class="form-label">NIP (Nomor Induk Pegawai)</label>
                              <input type="text" class="form-control" readonly name="nip" value="<?= (isset($data->nip)) ? htmlspecialchars($data->nip) : '' ?>">
                            </div>

                            <!-- NRK -->
                            <div class="col-md-6">
                              <label class="form-label">NRK (Nomor Registrasi Kepegawaian)</label>
                              <input type="text" class="form-control" readonly name="nrk" value="<?= (isset($data->nrk)) ? htmlspecialchars($data->nrk) : '' ?>">
                            </div>

                            <!-- ID Mesin -->
                            <div class="col-md-6">
                              <label class="form-label">ID Mesin Absensi</label>
                              <input type="text" class="form-control" readonly name="id_mesin" value="<?= (isset($data->id_mesin)) ? htmlspecialchars($data->id_mesin) : '' ?>" placeholder="Masukkan ID mesin">
                            </div>

                            <?php 
                              $array_jns_pegawai = array(
                                  'non_pns' => 'NON PNS',
                                  'pns'     => 'PNS',
                                  'pppk'    => 'PPPK',
                                  'pppk_pw' => 'PPPK PW',
                                  'pjlp'    => 'PJLP'
                              );
                              $jns_peg = isset($data->jns_pegawai) ? $data->jns_pegawai : '';
                            ?>

                            <!-- Jenis Pegawai -->
                            <div class="col-md-6">
                              <label class="form-label">Status / Jenis Pegawai</label>
                              <select class="form-select" disabled name="jns_pegawai">
                                <?php foreach ($array_jns_pegawai as $val => $label): ?>
                                  <option value="<?= $val ?>" <?= ($jns_peg == $val) ? 'selected' : '' ?>>
                                    <?= $label ?>
                                  </option>
                                <?php endforeach; ?>
                              </select>
                            </div>

                            <!-- Jabatan -->
                            <div class="col-md-6">
                              <label class="form-label">Jabatan</label>
                              <select class="form-select" disabled name="id_jabatan">
                                <option value="">-- Pilih Jabatan --</option>
                                <?php if (isset($list_jabatan)): foreach ($list_jabatan as $jabatan): ?>
                                  <option value="<?= $jabatan->id ?>" <?= (isset($data->id_jabatan) && $jabatan->id == $data->id_jabatan) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($jabatan->nama) ?>
                                  </option>
                                <?php endforeach; endif; ?>
                              </select>
                            </div>

                            <!-- Golongan -->
                            <div class="col-md-6">
                              <label class="form-label">Golongan</label>
                              <input type="text" class="form-control" disabled name="golongan" value="<?= (isset($data->golongan)) ? htmlspecialchars($data->golongan) : '' ?>">
                            </div>

                          </div>
                        </div>
                      </div>

                      <!-- Card 2: Detail Personal & Unit Kerja -->
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
                                <?php if (isset($list_puskesmas)): foreach ($list_puskesmas as $puskesmas): ?>
                                  <option value="<?= $puskesmas->id_puskesmas ?>" <?= (isset($data->id_puskesmas) && $puskesmas->id_puskesmas == $data->id_puskesmas) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($puskesmas->nama) ?>
                                  </option>
                                <?php endforeach; endif; ?>
                              </select>
                            </div>

                            <!-- Atasan Langsung / Validator -->
                            <div class="col-md-4">
                              <label class="form-label">Atasan Langsung (Validator)</label>
                              <select class="form-select" name="id_validator">
                                <option value="">-- Pilih Validator --</option>
                                <?php if (isset($list_validator)): foreach ($list_validator as $val): ?>
                                  <option value="<?= $val->id_pegawai ?>" <?= (isset($data->id_validator) && $val->id_pegawai == $data->id_validator) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($val->nama) ?>
                                  </option>
                                <?php endforeach; endif; ?>
                              </select>
                            </div>

                            <!-- Poli / Layanan -->
                            <div class="col-md-4">
                              <label class="form-label">Poli / Layanan</label>
                              <select class="form-select" name="id_poli">
                                <option value="">-- Pilih Poli --</option>
                                <?php if (isset($list_poli)): foreach ($list_poli as $poli): ?>
                                  <option value="<?= $poli->id ?>" <?= (isset($data->id_poli) && $poli->id == $data->id_poli) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($poli->nama_poli) ?>
                                  </option>
                                <?php endforeach; endif; ?>
                              </select>
                            </div>

                            <!-- Pendidikan -->
                            <div class="col-md-4">
                              <label class="form-label">Pendidikan Terakhir</label>
                              <select class="form-select" name="id_pendidikan">
                                <option value="">-- Pilih Pendidikan --</option>
                                <?php if (isset($list_pendidikan)): foreach ($list_pendidikan as $pend): ?>
                                  <option value="<?= $pend->id ?>" <?= (isset($data->id_pendidikan) && $pend->id == $data->id_pendidikan) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($pend->pendidikan) ?>
                                  </option>
                                <?php endforeach; endif; ?>
                              </select>
                            </div>
                                
                          

                         
                            <div class="col-md-4">
                              <label class="form-label">Jam Kerja</label>
                              <select class="form-select" name="jns_jam_kerja">
                                <option value="non_shift" <?= (isset($data->jns_jam_kerja) && $data->jns_jam_kerja == 'non_shift') ? 'selected' : '' ?>>Non-Shift (Regular)</option>
                                <option value="shift" <?= (isset($data->jns_jam_kerja) && $data->jns_jam_kerja == 'shift') ? 'selected' : '' ?>>Shift</option>
                              </select>
                            </div>

                            <div class="col-md-4">
                              <label class="form-label">Kelompok Klaster</label>
                              <select class="form-select" name="klaster">
                                <?php for($a = 1; $a < 6; $a++){ ?>
                                  <option value="<?= $a ?>" <?= (isset($data->klaster) && $data->klaster == $a) ? "selected" : "" ?>>Klaster <?= $a ?></option>
                                <?php } ?>
                              </select>
                            </div>

                            <div class="col-md-4">
                              <label class="form-label">Email</label>
                              <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-mail fs-6"></i></span>
                                <input 
                                  type="email" 
                                  class="form-control" 
                                  name="email" 
                                  value="<?= (isset($detail_pegawai->email)) ? htmlspecialchars($detail_pegawai->email) : '' ?>" 
                                  placeholder="masukkan email">
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
                                  value="<?= (isset($detail_pegawai->no_tlp)) ? htmlspecialchars($detail_pegawai->no_tlp) : '' ?>" 
                                  placeholder="Contoh: 081234567890" 
                                  maxlength="15"
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
                                <span class="input-group-text"><i class="ti ti-id fs-6"></i></span>
                                <input 
                                  type="text" 
                                  class="form-control" 
                                  name="nik" 
                                  value="<?= (isset($detail_pegawai->no_ktp)) ? htmlspecialchars($detail_pegawai->no_ktp) : '' ?>" 
                                  placeholder="16 Digit NIK" 
                                  maxlength="16"
                                  inputmode="numeric"
                                  oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                              </div>
                              <div class="form-text extra-small">Harus 16 digit angka.</div>
                            </div>

                            <!-- Input NPWP -->
                            <div class="col-md-4">
                              <label class="form-label">NPWP (Nomor Pokok Wajib Pajak)</label>
                              <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-receipt fs-6"></i></span>
                                <input 
                                  type="text" 
                                  class="form-control" 
                                  id="npwp_input"
                                  name="npwp" 
                                  value="<?= (isset($detail_pegawai->npwp)) ? htmlspecialchars($detail_pegawai->npwp) : '' ?>" 
                                  placeholder="XX.XXX.XXX.X-XXX.XXX" 
                                  maxlength="20">
                              </div>
                              <div class="form-text extra-small">Contoh: 12.345.678.9-012.000</div>
                            </div>

                            <!-- Input No. Rekening -->
                            <div class="col-md-4">
                              <label class="form-label">No. Rekening Bank</label>
                              <div class="input-group">
                                <span class="input-group-text"><i class="ti ti-credit-card fs-6"></i></span>
                                <input 
                                  type="text" 
                                  class="form-control" 
                                  name="no_rekening" 
                                  value="<?= (isset($detail_pegawai->no_rekening)) ? htmlspecialchars($detail_pegawai->no_rekening) : '' ?>" 
                                  placeholder="Nomor Rekening Tabungan" 
                                  inputmode="numeric"
                                  oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                              </div>
                              <div class="form-text extra-small">Khusus angka tanpa titik/spasi.</div>
                            </div>

                             <!-- Golongan -->
                            <div class="col-md-4">
                              <label class="form-label">Tempat lahir</label>
                              <input type="text" class="form-control" name="kota_lahir" value="<?= (isset($detail_pegawai->tempat_lahir)) ? htmlspecialchars($detail_pegawai->tempat_lahir) : '' ?>">
                            </div>
                               <!-- TMT -->
                            <div class="col-md-4">
                              <label class="form-label">Tanggal lahir</label>
                              <input type="date" class="form-control" name="tgl_lahir" value="<?= (isset($detail_pegawai->tgl_lahir) && $detail_pegawai->tgl_lahir != '0000-00-00') ? htmlspecialchars($detail_pegawai->tgl_lahir) : '' ?>">
                            </div>

                            <div class="col-md-6">
                               <label class="form-label">Alamat KTP</label>
                               <textarea name="alamat_ktp"  class="form-control"  id="alamat_ktp" cols="30" rows="3"><?php echo $detail_pegawai->alamat_ktp;?></textarea>
                            
                            </div>
                             <div class="col-md-6">
                               <label class="form-label">Alamat Domisili</label>
                               <textarea name="alamat_ktp"  class="form-control"  id="alamat_domisili" cols="30" rows="3"><?php echo $detail_pegawai->alamat_domisili;?></textarea>
                            
                            </div>



                          </div>

                        </div>
                      </div>

                    </div>

                  </div>

                  <!-- Sticky Bottom Action Bar -->
                  <div class="sticky-bottom-bar d-flex justify-content-between align-items-center">
                    <div class="text-muted small d-none d-sm-block">
                      <i class="ti ti-info-circle me-1"></i> Pastikan seluruh data bertanda bintang (*) telah terisi.
                    </div>
                    <div class="d-flex gap-2 ms-auto">
                      <a href="<?= base_url('profile/my_profile/' . $id_pegawai); ?>" class="btn btn-light border px-4">Batal</a>
                      <button type="submit" class="btn btn-primary px-4 fw-semibold">
                        <i class="ti ti-check me-1"></i> Simpan Perubahan
                      </button>
                    </div>
                  </div>

                </form>

              </div>
            </div>
          </div>


        </div>
      </div>

    </div>
  </div>

  <div class="dark-transparent sidebartoggler"></div>

  <!-- JavaScript Base Libraries -->
  <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

  <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

  <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>

  <!-- SweetAlert2 CSS & JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <?php $this->load->view('layout/section/theme-setting.php'); ?>
  <?php $this->load->view('master/request-cuti.php'); ?>

  <script>
    // Preview Foto Profil Langsung Saat Upload
    function previewImage(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $('#preview-avatar').attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $(document).ready(function() {

      // Submit Form Edit Pegawai via AJAX
      $('#formEditPegawai').on('submit', function(e) {
        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');
        var formData = new FormData(this);

        Swal.fire({
          title: 'Menyimpan Data...',
          text: 'Mohon tunggu sebentar',
          allowOutsideClick: false,
          allowEscapeKey: false,
          didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
          type: "POST",
          url: actionUrl,
          data: formData,
          contentType: false,
          processData: false,
          dataType: "json",
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
                window.location.href = '<?= base_url("profile/my_profile/" . $id_pegawai) ?>';
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
              text: 'Tidak dapat menghubungkan ke server.',
              confirmButtonText: 'Tutup'
            });
          }
        });
      });

    });
  </script>

</body>
</html>