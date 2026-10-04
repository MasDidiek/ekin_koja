<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  
  <!-- Select2 CSS & Bootstrap 5 Theme -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />

  <style>
    /* Custom styling untuk menyatukan dengan tema Bootstrap */
    :root {
      --bs-primary: #3b82f6; /* Warna biru tema utama */
    }

    /* Custom Table Styling */
    .custom-table thead th {
      font-weight: 600;
      letter-spacing: 0.5px;
      border-bottom: 1px solid #f1f5f9;
      padding-top: 0.8rem;
      padding-bottom: 0.8rem;
    }

    .custom-table tbody tr {
      transition: all 0.15s ease-in-out;
    }

    .custom-table tbody tr:hover {
      background-color: #f8fafc;
    }

    .custom-table td {
      padding-top: 0.85rem;
      padding-bottom: 0.85rem;
      border-bottom: 1px solid #f1f5f9;
    }

    .breadcrumb-item2 {
      font-size: 14px;
    }

    nav ol span {
      font-size: 14px;
      padding: 0 10px;
    }

    /* Penyesuaian tinggi Select2 agar pas dengan form-control Bootstrap */
    .select2-container--bootstrap-5 .select2-selection {
      min-height: 38px !important;
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

      <?php
        $jns_pegawai = $this->uri->segment(4);
        $status_kerja = ($this->uri->segment(5) != '') ? $this->uri->segment(5) : 1;
        $message = $this->session->flashdata('message');
        $jns_pegawai_title = strtoupper(str_replace("_", " ", $jns_pegawai));

        echo $message;
      ?>

      <div class="body-wrapper">
        <div class="container-fluid px-4 py-3">
          
          <!-- Page Header / Breadcrumb -->
          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 fs-7">
                  <li class="breadcrumb-item2"><a href="<?= base_url('admin/pegawai/data_pegawai/non_pns') ?>" class="text-decoration-none">Pegawai</a></li>
                  <span> / </span> 
                  <li class="breadcrumb-item2 active" aria-current="page">Detail Pegawai</li>
                  <span> / </span> 
                  <li class="breadcrumb-item2 active" aria-current="page"><?= $jns_pegawai_title ?></li>

                   
                </ol>
              </nav>
              <h4 class="fw-bold m-0 text-dark">Detail Data Pegawai</h4>
            </div>
            <a href="<?php echo base_url(); ?>admin/pegawai/add_pegawai/<?php echo $jns_pegawai; ?>" class="btn btn-primary waves-effect float-end ml-2">
              <i class="ti ti-plus"></i> Input Pegawai Baru
            </a>
          </div>

          <!-- Main Card Component -->
          <div class="card border-0 shadow-sm rounded-3">
            
            <!-- Filter & Search Section (Dalam 1 Row) -->
            <div class="card-header bg-white py-3 border-0">
              <form id="form-filter" method="GET" action="">
                <div class="row g-2 align-items-end">
                  
                  <!-- 1. Filter Status -->
                  <div class="col-12 col-md-2">
                    <label for="filter-status" class="form-label text-muted fw-medium fs-2 mb-1">Status</label>
                    <select name="status" id="filter-status" class="form-select border-light-subtle bg-light">
                      <option value="">Semua Status</option>
                      <option value="1" <?= (isset($_GET['status']) && $_GET['status'] == '1') ? 'selected' : ''; ?>>Aktif</option>
                      <option value="0" <?= (isset($_GET['status']) && $_GET['status'] == '0') ? 'selected' : ''; ?>>Tidak Aktif</option>
                    </select>
                  </div>

                  <!-- 2. Filter Jabatan (Select2 Autocomplete) -->
                  <div class="col-12 col-md-3">
                    <label for="filter-jabatan" class="form-label text-muted fw-medium fs-2 mb-1">Jabatan</label>
                    <select name="id_jabatan" id="filter-jabatan" class="form-select" data-placeholder="Cari Jabatan...">
                      <option value="">Semua Jabatan</option>
                      <?php if (!empty($list_jabatan)): ?>
                        <?php foreach ($list_jabatan as $jabatan): ?>
                          <option value="<?= $jabatan->id; ?>" <?= (isset($_GET['id_jabatan']) && $_GET['id_jabatan'] == $jabatan->id) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($jabatan->nama); ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>

                  <!-- 3. Filter Unit Kerja / Puskesmas -->
                  <div class="col-12 col-md-3">
                    <label for="filter-puskesmas" class="form-label text-muted fw-medium fs-2 mb-1">Unit Kerja / Puskesmas</label>
                    <select name="id_puskesmas" id="filter-puskesmas" class="form-select border-light-subtle bg-light">
                      <option value="">Semua Unit Kerja</option>
                      <?php if (!empty($list_puskesmas)): ?>
                        <?php foreach ($list_puskesmas as $puskesmas): ?>
                          <option value="<?= $puskesmas->id_puskesmas; ?>" <?= (isset($_GET['id_puskesmas']) && $_GET['id_puskesmas'] == $puskesmas->id_puskesmas) ? 'selected' : ''; ?>>
                            <?= htmlspecialchars($puskesmas->nama); ?>
                          </option>
                        <?php endforeach; ?>
                      <?php endif; ?>
                    </select>
                  </div>

                  <!-- 4. Tombol Submit Filter -->
                  <div class="col-12 col-md-auto">
                    <button type="submit" class="btn btn-primary px-3 d-flex align-items-center gap-1 w-100">
                      <i class="ti ti-filter"></i> Filter
                    </button>
                  </div>

                  <!-- 5. Input Search Nama/NIP (Di Paling Kanan) -->
                  <div class="col-12 col-md-3 ms-auto">
                    <label for="search-keyword" class="form-label text-muted fw-medium fs-2 mb-1">Pencarian</label>
                    <div class="input-group">
                      <span class="input-group-text bg-light border-light-subtle text-muted">
                        <i class="ti ti-search"></i>
                      </span>
                      <input type="text" name="q" id="search-keyword" class="form-control border-light-subtle bg-light" placeholder="Cari nama atau NIP..." value="<?= isset($_GET['q']) ? htmlspecialchars($_GET['q']) : ''; ?>">
                    </div>
                  </div>

                </div>
              </form>
            </div>

            <!-- Table Body -->
            <div class="table-responsive">
              <table class="table table-hover align-middle mb-0 custom-table">
                <thead class="bg-light text-muted fs-3 text-uppercase">
                  <tr>
                    <th class="ps-4" style="width: 60px;">No</th>
                    <th class="text-center">TMT</th>
                    <th class="text-center">NIP</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th>Puskesmas</th>
                  </tr>
                </thead>
                <tbody class="fs-3 text-secondary">
                  <?php
                  if (!empty($pegawai)) {
                    $no = 1;
                    foreach ($pegawai as $peg) {
                      $id_pegawai = $peg->id_pegawai;
                      $nip = $peg->nip;
                      $tmt = $peg->tgl_masuk;

                      echo '<tr>
                              <td class="ps-4 fw-medium">' . $no . '</td>
                              <td class="text-center">' . format_semi($tmt) . '</td>
                              <td class="text-center"><code>' . $peg->nip . '</code></td>
                              <td><a href="' . base_url() . 'admin/pegawai/detail_pegawai/' . $id_pegawai . '" class="fw-semibold text-primary text-decoration-none">' . $peg->nama . '</a></td>
                              <td>' . $peg->jabatan . '</td>
                              <td>' . $peg->puskesmas . '</td>
                            </tr>';
                      $no++;
                    }
                  } else {
                    echo '<tr><td colspan="6" class="text-center py-4 text-muted">Data pegawai tidak ditemukan</td></tr>';
                  }
                  ?>
                </tbody>
              </table>
            </div>

         

          </div>

        </div>

        <?php $this->load->view('layout/section/theme-setting.php'); ?>
        <?php $this->load->view('master/request-cuti.php'); ?>

      </div>
      <div class="dark-transparent sidebartoggler"></div>
    </div>
  </div>

  <!-- Import JS Files -->
  <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

  <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

  <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>

  <!-- SELECT2 JS (DIBETULKAN DARI SANGAT KELIRU: dist/css/ => dist/js/) -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    $(document).ready(function() {
      // Inisialisasi Select2 Autocomplete untuk Jabatan
      $('#filter-jabatan').select2({
        theme: 'bootstrap-5',
        placeholder: 'Cari Jabatan...',
        allowClear: true,
        minimumInputLength: 3, // Minimal ketik 3 huruf
        language: {
          inputTooShort: function() {
            return "Ketik min. 3 huruf...";
          },
          noResults: function() {
            return "Jabatan tidak ditemukan";
          }
        }
      });
    });

    $(document).ready(function() {
      let searchTimer;

      // Event handler ketika user mengetik di input search
      $('#search-keyword').on('keyup', function() {
        clearTimeout(searchTimer);
        
        // Delay 400ms (debounce) agar tidak terus-menerus melakukan hit request ke server saat mengetik
        searchTimer = setTimeout(function() {
          fetchDataPegawai();
        }, 400);
      });

      function fetchDataPegawai() {
        const formData = $('#form-filter').serialize();
        const jnsPegawai = '<?= $jns_pegawai; ?>';

        $.ajax({
          url: '<?= base_url("admin/pegawai/ajax_search_pegawai/"); ?>' + jnsPegawai,
          type: 'GET',
          data: formData,
          dataType: 'json',
          beforeSend: function() {
            $('tbody').html('<tr><td colspan="6" class="text-center py-4"><div class="spinner-border text-primary" role="status"></div></td></tr>');
          },
          success: function(response) {
            let html = '';
            if (response.data && response.data.length > 0) {
              $.each(response.data, function(index, peg) {
                html += `
                  <tr>
                    <td class="ps-4 fw-medium">${index + 1}</td>
                    <td class="text-center">${peg.tgl_masuk_formatted || peg.tgl_masuk}</td>
                    <td class="text-center"><code>${peg.nip}</code></td>
                    <td><a href="<?= base_url(); ?>admin/pegawai/detail_pegawai/${peg.id_pegawai}" class="fw-semibold text-primary text-decoration-none">${peg.nama}</a></td>
                    <td>${peg.jabatan || '-'}</td>
                    <td>${peg.puskesmas || '-'}</td>
                  </tr>
                `;
              });
            } else {
              html = '<tr><td colspan="6" class="text-center py-4 text-muted">Data pegawai tidak ditemukan</td></tr>';
            }
            $('tbody').html(html);
          },
          error: function() {
            $('tbody').html('<tr><td colspan="6" class="text-center py-4 text-danger">Gagal memuat data</td></tr>');
          }
        });
      }
    });
  </script>

</body>
</html>