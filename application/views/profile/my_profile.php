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
      box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
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

    /* Form Controls */
    .form-label {
      font-size: 0.85rem;
      font-weight: 600;
      color: #475569;
      margin-bottom: 0.4rem;
    }

    .form-control,
    .form-select {
      border-color: #cbd5e1;
      padding: 0.6rem 0.85rem;
      font-size: 0.9rem;
      border-radius: 8px;
    }

    .form-control:focus,
    .form-select:focus {
      border-color: #3b82f6;
      box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15);
    }

    .form-control[readonly],
    .form-control:disabled {
      background-color: #f8fafc;
      color: #64748b;
    }

    .detail-value {
      color: #333;
      font-weight: 600;
    }

    .breadcrumb-item2 {
      font-size: 14px;
    }

    nav ol span {
      font-size: 14px;
      padding: 0 10px;
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
      $data = isset($data_detail[0]) ? $data_detail[0] : null;

      // print_array($data_detail);
      $detail_pegawai = isset($data_detail_pegawai[0]) ? $data_detail_pegawai[0] : null;

      $id_pegawai   = isset($data->id_pegawai) ? $data->id_pegawai : '';
      $tgl_masuk    = isset($data->tgl_masuk) ? $data->tgl_masuk : '';
      $nip          = isset($data->nip) ? $data->nip : '';
      $nama_pegawai = isset($data->nama) ? $data->nama : '';

      // Foto Profil
      $photo_name = $this->Pegawai_model->getPhotoPegawai($nip);
      $file_path  = FCPATH . 'uploads/photo_profile/' . $photo_name;

      if (!empty($photo_name) && file_exists($file_path)) {
        $avatar_url = base_url('uploads/photo_profile/' . $photo_name);
      } else {
        $avatar_url = 'https://ui-avatars.com/api/?name=' . urlencode($nama_pegawai) . '&background=0D8ABC&color=fff&size=128';
      }

      $arrayStatusPajak = array('TK', 'K0', 'K1', 'K2');
      $array_group      = function_exists('arrayUsergroup') ? arrayUsergroup() : array();

      $pendidikan       = $this->Master_model->getNamaPendidikan(isset($data->id_pendidikan) ? $data->id_pendidikan : 0);
      $poli             = $this->Master_model->getNamaPoli(isset($data->id_poli) ? $data->id_poli : 0);
      $atasan_langsung  = $this->Pegawai_model->getNamaPegawaiByID($id_pegawai);
      ?>

      <div class="body-wrapper">
        <div class="container-fluid">

          <!-- Header Breadcrumb & Actions -->
          <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
            <div>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 fs-7">
                  <li class="breadcrumb-item2"><a href="<?= base_url('admin/pegawai/data_pegawai/non_pns') ?>" class="text-decoration-none">Pegawai</a></li>
                  <span> / </span>
                  <li class="breadcrumb-item2 active" aria-current="page">Detail Pegawai</li>
                </ol>
              </nav>
              <h4 class="fw-bold m-0 text-dark">Detail Data Pegawai</h4>
            </div>
            <div class="d-flex gap-2">

              <a href="<?= base_url('profile/edit_profile/' . $id_pegawai) ?>" class="btn btn-primary btn-sm rounded-pill px-3">
                <i class="ti ti-pencil me-1"></i> Edit Profile
              </a>
            </div>
          </div>

          <!-- Navigation Tabs -->
          <div class="custom-card mb-4">
            <ul class="nav nav-tabs-custom" id="pegawaiTab" role="tablist">
              <li class="nav-item" role="presentation">
                <button class="nav-link active" id="account-tab" data-bs-toggle="tab" data-bs-target="#account" type="button" role="tab" aria-controls="account" aria-selected="true">
                  <i class="ti ti-user me-2 fs-6"></i>Account & Profil
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="gaji-tab" data-bs-toggle="tab" data-bs-target="#gaji" type="button" role="tab" aria-controls="gaji" aria-selected="false">
                  <i class="ti ti-moneybag me-2 fs-6"></i>Data Gaji
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="sip-tab" data-bs-toggle="tab" data-bs-target="#sip" type="button" role="tab" aria-controls="sip" aria-selected="false">
                  <i class="ti ti-files me-2 fs-6"></i>SIP / STR
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="cuti-tab" data-bs-toggle="tab" data-bs-target="#cuti" type="button" role="tab" aria-controls="cuti" aria-selected="false">
                  <i class="ti ti-plane me-2 fs-6"></i>Data Cuti
                </button>
              </li>
              <li class="nav-item" role="presentation">
                <button class="nav-link" id="pelatihan-tab" data-bs-toggle="tab" data-bs-target="#pelatihan" type="button" role="tab" aria-controls="pelatihan" aria-selected="false">
                  <i class="ti ti-certificate me-2 fs-6"></i>Pelatihan
                </button>
              </li>
            </ul>
          </div>

          <!-- Tab Content Wrapper -->
          <div class="tab-content" id="pegawaiTabContent">

            <!-- TAB 1: ACCOUNT & PROFIL -->
            <div class="tab-pane fade show active" id="account" role="tabpanel" aria-labelledby="account-tab">
              <div class="row g-4">

                <!-- SIDEBAR KIRI: Ringkasan Pegawai -->
                <div class="col-lg-4 col-xl-3">
                  <div class="custom-card p-4 text-center">
                    <div class="avatar-wrapper mb-3">
                      <img src="<?= $avatar_url ?>" alt="Foto <?= htmlspecialchars($nama_pegawai) ?>" class="avatar-img">
                    </div>

                    <h5 class="fw-bold mb-1"><?= htmlspecialchars($nama_pegawai) ?></h5>
                    <p class="text-muted small mb-2"><?= isset($data->jabatan) && $data->jabatan != '' ? htmlspecialchars($data->jabatan) : 'Pegawai' ?></p>

                    <!-- Badge Jenis Pegawai -->
                    <span class="badge bg-primary-subtle text-primary fw-semibold px-3 py-1 mb-3">
                      <?= isset($data->jns_pegawai) && $data->jns_pegawai != '' ? strtoupper($data->jns_pegawai) : 'N/A' ?>
                    </span>

                    <hr class="my-3 text-muted opacity-25">

                    <!-- Badge Status Kerja -->
                    <div class="text-center mb-2">
                      <div class="detail-label mb-1">Status Kepegawaian</div>
                      <?php
                      $status_kerja = (isset($data->status_kerja) && $data->status_kerja !== '') ? $data->status_kerja : 1;
                      if ($status_kerja == 1) :
                      ?>
                        <span class="badge bg-success-subtle text-success px-3 py-2 fw-semibold fs-7 rounded-pill w-100">
                          <i class="ti ti-circle-check me-1"></i> Aktif
                        </span>
                      <?php elseif ($status_kerja == 2) : ?>
                        <span class="badge bg-warning-subtle text-warning px-3 py-2 fw-semibold fs-7 rounded-pill w-100">
                          <i class="ti ti-clock me-1"></i> Cuti
                        </span>
                      <?php else : ?>
                        <span class="badge bg-danger-subtle text-danger px-3 py-2 fw-semibold fs-7 rounded-pill w-100">
                          <i class="ti ti-circle-x me-1"></i> Tidak Aktif
                        </span>
                      <?php endif; ?>
                    </div>
                  </div>

                  <!-- Card Mesin Absensi -->
                  <div class="custom-card p-3">
                    <div class="d-flex align-items-center gap-3">
                      <div class="p-2 bg-primary-subtle rounded text-primary fs-3">
                        <i class="ti ti-fingerprint"></i>
                      </div>
                      <div>
                        <div class="detail-label">ID Mesin Absensi</div>
                        <div class="fw-bold text-dark"><?= (isset($data->id_mesin) && !empty($data->id_mesin)) ? htmlspecialchars($data->id_mesin) : '—' ?></div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- KONTEN KANAN: Detail Informasi -->
                <div class="col-lg-8 col-xl-9">

                  <!-- Card 1: Informasi Kepegawaian -->
                  <div class="custom-card">
                    <div class="card-header-clean">
                      <h5>Informasi Akun & Kepegawaian</h5>
                      <p>Data identitas utama dan nomor registrasi kepegawaian</p>
                    </div>
                    <div class="p-4">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Nama Lengkap</div>
                            <div class="detail-value"><?= htmlspecialchars($nama_pegawai) ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">TMT (Tanggal Mulai Tugas)</div>
                            <div class="detail-value"><?= (isset($data->tmt) && !empty($data->tmt) && $data->tmt != '0000-00-00') ? date('d F Y', strtotime($data->tmt)) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">NIP (Nomor Induk Pegawai)</div>
                            <div class="detail-value"><?= (isset($data->nip) && $data->nip != '') ? htmlspecialchars($data->nip) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">NRK (Nomor Registrasi)</div>
                            <div class="detail-value"><?= (isset($data->nrk) && $data->nrk != '') ? htmlspecialchars($data->nrk) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Jabatan</div>
                            <div class="detail-value"><?= (isset($data->jabatan) && $data->jabatan != '') ? htmlspecialchars($data->jabatan) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Golongan</div>
                            <div class="detail-value"><?= (isset($data->golongan) && $data->golongan != '') ? htmlspecialchars($data->golongan) : '—' ?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <?php
                  // print_array($detail_pegawai);
                  ?>

                  <!-- Card 2: Detail Personal & Identitas Dokumen -->
                  <div class="custom-card">
                    <div class="card-header-clean">
                      <h5>Detail Identitas & Kontak</h5>
                      <p>Informasi kependudukan, perpajakan, dan kontak pribadi</p>
                    </div>
                    <div class="p-4">
                      <div class="row g-3">
                        <div class="col-md-4">
                          <div class="detail-box">
                            <div class="detail-label"><i class="ti ti-id me-1"></i> NIK</div>
                            <div class="detail-value"><?= (isset($detail_pegawai->nik) && $detail_pegawai->nik != '') ? htmlspecialchars($detail_pegawai->nik) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="detail-box">
                            <div class="detail-label"><i class="ti ti-receipt me-1"></i> NPWP</div>
                            <div class="detail-value"><?= (isset($detail_pegawai->npwp) && $detail_pegawai->npwp != '') ? htmlspecialchars($detail_pegawai->npwp) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="detail-box">
                            <div class="detail-label"><i class="ti ti-phone me-1"></i> No. Handphone</div>
                            <div class="detail-value"><?= (isset($detail_pegawai->no_tlp) && $detail_pegawai->no_tlp != '') ? htmlspecialchars($detail_pegawai->no_tlp) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="detail-box">
                            <div class="detail-label"><i class="ti ti-credit-card me-1"></i> No. Rekening</div>
                            <div class="detail-value"><?= (isset($detail_pegawai->no_rekening) && $detail_pegawai->no_rekening != '') ? htmlspecialchars($detail_pegawai->no_rekening) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="detail-box">
                            <div class="detail-label"><i class="ti ti-mail me-1"></i> Email</div>
                            <div class="detail-value"><?= (isset($detail_pegawai->email) && $detail_pegawai->email != '') ? htmlspecialchars($detail_pegawai->email) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="detail-box">
                            <div class="detail-label"><i class="ti ti-school me-1"></i> Pendidikan</div>
                            <div class="detail-value"><?= htmlspecialchars($pendidikan); ?></div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="detail-box">
                            <div class="detail-label">Status Kawin</div>
                            <div class="detail-value">
                              <?php
                              $sk = isset($data->status_kawin) ? $data->status_kawin : 0;
                              if ($sk == 1) {
                                echo 'Menikah anak >=2';
                              } elseif ($sk == 2) {
                                echo 'Menikah anak 1';
                              } elseif ($sk == 3) {
                                echo 'Menikah';
                              } else {
                                echo 'Belum menikah';
                              }
                              ?>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="detail-box">
                            <div class="detail-label">Status Pajak (PTKP)</div>
                            <div class="detail-value"><?= (isset($data->status_pajak) && $data->status_pajak != '') ? htmlspecialchars($data->status_pajak) : '—' ?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Card 3: Penempatan Unit Kerja -->
                  <div class="custom-card">
                    <div class="card-header-clean">
                      <h5>Penempatan & Unit Kerja</h5>
                      <p>Informasi lokasi kerja, poli, dan rumpun tugas</p>
                    </div>
                    <div class="p-4">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Puskesmas / Unit Kerja</div>
                            <div class="detail-value"><?= (isset($data->puskesmas) && $data->puskesmas != '') ? htmlspecialchars($data->puskesmas) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Poli / Layanan</div>
                            <div class="detail-value"><?= htmlspecialchars($poli) ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Klaster</div>
                            <div class="detail-value"><?= (isset($data->klaster) && $data->klaster != '') ? htmlspecialchars($data->klaster) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Atasan Langsung</div>
                            <div class="detail-value"><?= htmlspecialchars($atasan_langsung) ?></div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Rumpun Kerja</div>
                            <div class="detail-value"><?= (isset($data->rumpun_kerja) && $data->rumpun_kerja != '') ? strtoupper(htmlspecialchars($data->rumpun_kerja)) : '—' ?></div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="detail-box">
                            <div class="detail-label">Jenis Jam Kerja</div>
                            <div class="detail-value"><?= (isset($data->jns_jam_kerja) && $data->jns_jam_kerja == 'shift') ? 'Shift' : 'Non-Shift (Regular)' ?></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                </div>

              </div>
            </div>

            <!-- TAB 2: DATA GAJI -->
            <div class="tab-pane fade" id="gaji" role="tabpanel" aria-labelledby="gaji-tab">
              <div class="custom-card p-4">
                <h5 class="fw-bold mb-3"><i class="ti ti-moneybag me-2 text-primary"></i>Informasi & Rincian Gaji</h5>
                <?php $this->load->view('profile/tab_gaji'); ?>
              </div>
            </div>

            <!-- TAB 3: SIP / STR -->
            <div class="tab-pane fade" id="sip" role="tabpanel" aria-labelledby="sip-tab">
              <div class="custom-card p-4">
                <h5 class="fw-bold mb-3"><i class="ti ti-files me-2 text-primary"></i>Dokumen Surat Izin Praktik (SIP) & STR</h5>
                <p class="text-muted">Riwayat dokumen SIP/STR pegawai belum diunggah.</p>
              </div>
            </div>

            <!-- TAB 4: DATA CUTI -->
            <div class="tab-pane fade" id="cuti" role="tabpanel" aria-labelledby="cuti-tab">
              <div class="custom-card p-4">
                <h5 class="fw-bold mb-3"><i class="ti ti-plane me-2 text-primary"></i>Riwayat & Kuota Cuti</h5>
                <p class="text-muted">Data riwayat pengajuan cuti pegawai.</p>

                <?php $this->load->view('profile/tab_cuti'); ?>
              </div>
            </div>

            <!-- TAB 5: PELATIHAN -->
            <div class="tab-pane fade" id="pelatihan" role="tabpanel" aria-labelledby="pelatihan-tab">
              <div class="custom-card p-4">
                <h5 class="fw-bold mb-3"><i class="ti ti-certificate me-2 text-primary"></i>Sertifikat & Pelatihan</h5>
                <p class="text-muted">Data sertifikat pengembangan kompetensi pegawai.</p>
              </div>
            </div>

          </div>
        </div>
      </div>

    </div>
  </div>

  <div class="dark-transparent sidebartoggler"></div>

  <!-- JavaScript Base Libraries (Telah Dirapikan) -->
  <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

  <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

  <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

  <!-- SweetAlert2 CSS & JS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Section Views & Settings -->
  <?php $this->load->view('layout/section/theme-setting.php'); ?>
  <?php $this->load->view('master/request-cuti.php'); ?>

  <!-- Inline Application Scripts -->
  <script>
    function handleColorTheme(e) {
      $("html").attr("data-color-theme", e);
      $(e).prop("checked", !0);
    }

    $(document).ready(function() {

      // 1. Submit Edit Pegawai via AJAX
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
          didOpen: () => {
            Swal.showLoading();
          }
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
                location.reload();
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

      // 2. Toggle Edit Form Cuti
      $(document).on('click', '.btn-toggle-edit, .btn-cancel-edit', function(e) {
        e.preventDefault();
        var targetClass = $(this).data('target');
        $(targetClass).toggleClass('d-none');
      });

      // 3. Submit Update Cuti via AJAX
      $(document).on('submit', '.form-update-cuti', function(e) {
        e.preventDefault();

        var form = $(this);
        var actionUrl = form.attr('action');
        var formData = form.serialize();
        var inputContainer = form.find('.row');
        var newQty = form.find('input[name="qty_input"]').val();
        var displaySpan = form.closest('.card-body').find('span[id^="display_cuti"]');

        Swal.fire({
          title: 'Memperbarui Cuti...',
          allowOutsideClick: false,
          didOpen: () => {
            Swal.showLoading();
          }
        });

        $.ajax({
          type: "POST",
          url: actionUrl,
          data: formData,
          dataType: "json",
          success: function(response) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: 'Sisa cuti berhasil diperbarui.',
              timer: 1500,
              showConfirmButton: false
            });

            displaySpan.text(newQty);
            inputContainer.addClass('d-none');
          },
          error: function(xhr, status, error) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal!',
              text: 'Terjadi kesalahan saat memperbarui kuota cuti.',
              confirmButtonText: 'Tutup'
            });
          }
        });
      });

    });
  </script>

</body>

</html>