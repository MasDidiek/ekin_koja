<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
        .loader-spinner {
            --color-1: #007bff; /* Sesuaikan warna agar terlihat (biru/gelap) */
            --size: 0.5px;      /* Menghasilkan ukuran ~24px */
            width: calc(30 * var(--size));
            height: calc(30 * var(--size));
            border: calc(5 * var(--size)) solid var(--color-1);
            border-bottom-color: transparent;
            border-radius: 50%;
            display: inline-block;
            box-sizing: border-box;
            animation: rotation 1s linear infinite;
        }

        @keyframes rotation {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }


        /* Base Style untuk Status Dot */
            .status-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            flex-shrink: 0;
            }

            /* Status: Pending (Kuning / Orange) */
            .status-dot-pending {
            background-color: #ffc107;
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.2); /* Efek glow tipis */
            }

            /* Status: Disetujui / Approved (Hijau) */
            .status-dot-approved,
            .status-dot-success {
            background-color: #198754;
            box-shadow: 0 0 0 3px rgba(25, 135, 84, 0.2);
            }

            /* Status: Ditolak / Rejected (Merah) */
            .status-dot-rejected,
            .status-dot-danger {
            background-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2);
            }

            /* Opsional: Animasi Kedip (Pulse) untuk status Pending agar lebih menarik */
            .status-dot-pulse {
            animation: dot-pulse 1.5s infinite ease-in-out;
            }

            @keyframes dot-pulse {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 5px rgba(255, 193, 7, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
            }
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

        <?php $this->load->view('layout/section/sidebar'); ?>

      
    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header'); ?>
      <!--  Header End -->


       <?php
            

            $usergroup = $this->session->userdata('usergroup');
            $error = $this->session->flashdata('error');
            $success = $this->session->flashdata('success');
            $tahun_renkin     = $this->input->get('tahun');

            if(empty($tahun_renkin)){
              $tahun_renkin = date('Y');
            }
         
            $tahun_awal = 2026;
            $tahun_akhir = $tahun_renkin+5;
          ?>




      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Rencana Kinerja</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="<?= base_url('dashboard/index') ?>">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Rencana Kinerja</li>
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
         
        

          <div class="card">
            <div class="card-body">

              <?php if (!empty($success)) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <?= $success; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>


              <?php if (!empty($error)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <?= $error; ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
              <?php endif; ?>



              <form action="<?= base_url('admin/renkin/index'); ?>" method="get" class="form-inline">
                <div class="form-group" style="max-width: 300px;">
                    <label for="tahun" class="mr-2">Tahun:</label>
                      <div class="input-group">
                        <select name="tahun" id="tahun" class="custom-select form-control" style="width: auto; margin-right: 10px;">
                            <?php
                            for ($i = $tahun_awal; $i <= $tahun_akhir; $i++) {
                            $selected = ($i == $tahun_renkin) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </div>
                </form>
        
                <div class="row">

                <div class="d-flex justify-content-between align-items-center mb-2">
                    <div id="loadingState" class="d-none align-items-center gap-2">
                        <span class="loader-spinner"></span>
                        <span class="fw-semibold">Sedang menyimpan data...</span>
                    </div>

                    <div class="ms-auto d-flex gap-2">
                        <!-- Tombol Baru untuk Validasi Massal -->
                        <button type="button" id="btnValidasiMassal" data-bs-toggle="modal" data-bs-target="#modalValidasiMassal" class="btn btn-warning text-dark fw-bold">
                            <i class="bi bi-check2-square"></i> Validasi Renkin (Bulan Ini)
                        </button>

                    </div>
                </div>
              

                  <div class="table-responsive mt-4">
                    

                   <div class="table-responsive">
                       <table class="table table-bordered table-sm fs-2 align-middle w-100">
                            <thead class="table-light text-center align-middle">
                                <!-- Baris Header Level 1 -->
                                <tr>
                                    <th style="min-width: 50px;" rowspan="3">No</th>
                                    <th style="min-width: 250px;" rowspan="3">Indikator Kinerja</th>
                                    <th style="min-width: 100px;" rowspan="3">Satuan</th>
                                    <th style="min-width: 100px;" rowspan="3">Target Tahunan</th>
                                    <th colspan="36">Bulan</th>
                                    <th style="min-width: 50px;" rowspan="3">Total</th>
                                </tr>

                                <!-- Baris Header Level 2 -->
                                <tr>
                                    <?php
                                    for ($bln = 1; $bln <= 12; $bln++) { 
                                        $nama_bulan = getNamaBulan($bln);
                                        echo '<th colspan="3" class="text-center">'.$nama_bulan.'</th>';
                                    }
                                    ?>
                                </tr>

                                <!-- Baris Header Level 3 (Sub-kolom Target, Realisasi, & %) -->
                                <tr>
                                    <?php for ($i = 0; $i < 12; $i++): ?>
                                        <th style="min-width: 60px;" class="text-center"><span style="font-size: 10px;">(Target)</span></th>
                                        <th style="min-width: 60px;" class="text-center"><span style="font-size: 10px;">(Realisasi)</span></th>
                                        <th style="min-width: 110px;" class="text-center"><span style="font-size: 10px;">(Capaian %)</span></th>
                                    <?php endfor; ?>
                                </tr>
                            </thead>
                           <tbody>
                                    <?php
                                    $total_target_tahunan = 0;

                                    if (!empty($list_renkin)): ?>
                                        <?php $no = 1; foreach ($list_renkin as $row): 
                                            $id_renkin = $row->id;
                                            $renkin_detail = $this->rm->getRenkinDetail($id_renkin);

                                            // Re-index data detail berdasarkan bulan (1-12)
                                            $detail_by_bulan = [];
                                            if (!empty($renkin_detail)) {
                                                foreach ($renkin_detail as $rd) {
                                                    $detail_by_bulan[$rd->bulan] = $rd; 
                                                }
                                            }
                                        ?>
                                            <!-- Tambahkan class "row-renkin" dan simpan detail per bulan dalam data attributes -->
                                            <tr class="row-renkin" data-id="<?= $row->id ?>" data-indikator="<?= htmlspecialchars($row->indikator) ?>">
                                                <td class="text-center fw-bold"><?= $no++ ?></td>
                                                <td> <?= word_limiter(htmlspecialchars($row->indikator), 10) ?>  </td>
                                                <td class="text-center"><?= htmlspecialchars($row->satuan) ?></td>
                                                <td class="text-center fw-bold"><?= number_format($row->target_tahunan, 0, ',', '.') ?></td>
                                                
                                                <!-- Looping 12 bulan -->
                                                <?php for ($bln = 1; $bln <= 12; $bln++): 
                                                    $detail = isset($detail_by_bulan[$bln]) ? $detail_by_bulan[$bln] : null;
                                                    $target_val = $detail ? $detail->target : null;
                                                    $realisasi_val = $detail ? $detail->realisasi : null;
                                                    $status_val = $detail ? $detail->status : null;
                                                    $catatan_val = $detail ? $detail->catatan : '';

                                                    $total_target_tahunan += (float)$target_val;

                                                    $target_show = is_null($target_val) ? '-' : $target_val;
                                                    $realisasi_show = (is_null($realisasi_val) || $realisasi_val === '') ? '-' : $realisasi_val;

                                                    $badge_class = 'bg-light text-muted border';
                                                    if (is_null($realisasi_val) || $realisasi_val === '') {
                                                        $persen_show = '-'; 
                                                    } else {
                                                        $target_num = (float) $target_val;
                                                        $realisasi_num = (float) $realisasi_val;

                                                        if ($target_num > 0) {
                                                            $persen = ($realisasi_num / $target_num) * 100;
                                                            if ($persen >= 100) {
                                                                $badge_class = 'bg-success-subtle text-success border border-success-subtle';
                                                            } else if ($persen > 0) {
                                                                $badge_class = 'bg-warning-subtle text-warning border border-warning-subtle';
                                                            } else {
                                                                $badge_class = 'bg-danger-subtle text-danger border border-danger-subtle';
                                                            }
                                                            $persen_show = (floor($persen) == $persen) ? number_format($persen, 0) . '%' : number_format($persen, 1, ',', '.') . '%';
                                                        } else {
                                                            $persen_show = ($realisasi_num > 0) ? '100%' : '0%';
                                                            $badge_class = ($realisasi_num > 0) ? 'bg-success-subtle text-success border border-success-subtle' : 'bg-warning-subtle text-warning border border-warning-subtle';
                                                        }
                                                    }
                                                ?>
                                                    <!-- Simpan data detail bulan ke hidden/data-attribute cell agar bisa dibaca JS massal -->
                                                    <td class="text-center"><?= $target_show ?></td>
                                                    <td class="text-center" 
                                                        data-bulan="<?= $bln ?>" 
                                                        data-target="<?= $target_show ?>" 
                                                        data-realisasi="<?= $realisasi_show ?>" 
                                                        data-status="<?= $status_val ?>" 
                                                        data-catatan="<?= $catatan_val ?>">
                                                        <?= $realisasi_show ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if ($persen_show !== '-'): ?>
                                                            <span class="badge <?= $badge_class ?> rounded-pill px-2 py-1 d-inline-flex align-items-center gap-1">
                                                                <?= renderStatusDot($status_val) ?>
                                                                <span><?= $persen_show ?></span>
                                                            </span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endfor; ?>
                                                
                                                <td class="text-center fw-semibold"><?= number_format($total_target_tahunan, 0, ',', '.') ?></td>
                                                <?php $total_target_tahunan = 0; ?>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="41" class="text-center">Data tidak ditemukan</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                        </table>
                    </div>
                  </div>
                </div>

              </div>

              <!-- Modal Validasi Massal -->
                    <div class="modal fade" id="modalValidasiMassal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light">
                                    <h5 class="modal-title fw-bold">
                                        Validasi Massal Kinerja Bulan: <span id="labelBulanValidasi" class="text-primary"></span>
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                
                                <form id="formValidasiMassal" action="<?= base_url('admin/renkin/simpan_validasi_massal') ?>" method="POST">
                                    <input type="hidden" name="bulan_validasi" id="input_bulan_validasi">
                                    <input type="hidden" name="tahun_validasi" value="<?= $tahun_renkin ?>">
                                    <input type="hidden" name="id_pegawai_validasi" value="<?= htmlspecialchars($id_pegawai, ENT_QUOTES, 'UTF-8') ?>">

                                    <div class="modal-body">
                                        <!-- Control Action Bar di Bagian Atas -->
                                        <div class="p-3 bg-light-subtle border rounded mb-3 d-flex align-items-center justify-content-between">
                                            <div class="form-check me-3">
                                                <input class="form-check-input" type="checkbox" id="checkAllIndikator">
                                                <label class="form-check-label fw-bold" for="checkAllIndikator">Pilih Semua Indikator</label>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-success btn-sm" id="btnBatchApprove">
                                                    <i class="bi bi-check-circle"></i> Setujui Yang Dipilih
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" id="btnBatchReject">
                                                    <i class="bi bi-x-circle"></i> Tolak Yang Dipilih
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Tabel Daftar Indikator -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered align-middle">
                                                <thead class="table-light text-center">
                                                    <tr>
                                                        <th style="width: 40px;">#</th>
                                                        <th>Indikator Kinerja</th>
                                                        <th style="width: 90px;">Target</th>
                                                        <th style="width: 90px;">Realisasi</th>
                                                        <th style="width: 130px;">Status</th>
                                                        <th style="width: 250px;">Catatan / Alasan (Jika Ditolak)</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="containerFormMassal">
                                                    <!-- Data Indikator Di-load via AJAX -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Semua Validasi</button>
                                    </div>
                                </form>
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
        

</body>


<script>
  $("#light-layout").click(function() {
    $.ajax({
      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>dashboard/change_theme",
      data: "theme=light",
      success: function(msg) {

        setTimeout(function() {
          window.location.reload(1);
        }, 3000);
        //$("#aktifitasPegawai"+id).fadeOut(1000);

      }

    });

  });



    $(document).ready(function() {
    var namaBulan = [
        "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
        "Juli", "Agustus", "September", "Oktober", "November", "Desember"
    ];

            // Hitung bulan validasi (1 bulan sebelum bulan berjalan)
            var currentMonth = new Date().getMonth() + 1; // Misal: 10 (Oktober)
            var validatableMonth = currentMonth - 1;       // September (9)
            if (validatableMonth === 0) validatableMonth = 12; // Handle Januari

            // Trigger saat tombol Validasi Massal diklik
            $('#btnValidasiMassal').on('click', function() {
                $('#labelBulanValidasi').text(namaBulan[validatableMonth - 1]);
                $('#input_bulan_validasi').val(validatableMonth);
                $('#checkAllIndikator').prop('checked', false);
                $('#containerFormMassal').html('<tr><td colspan="6" class="text-center">Memuat daftar indikator...</td></tr>');

                $.ajax({
                    url: '<?= base_url("admin/renkin/get_massal_ajax") ?>',
                    type: 'GET',
                    data: { 
                        bulan: validatableMonth, 
                        tahun: '<?= $tahun_renkin ?>',
                        id_pegawai: '<?= htmlspecialchars($id_pegawai, ENT_QUOTES, 'UTF-8') ?>'
                    },
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        if (Array.isArray(response) && response.length > 0) {
                            response.forEach(function(item, index) {
                                var statusVal = item.status || 'pending';
                                var catatanVal = item.catatan || '';
                                var targetVal = (item.target === null || item.target === undefined || item.target === '') ? '-' : item.target;
                                var realisasiVal = (item.realisasi === null || item.realisasi === undefined || item.realisasi === '') ? '-' : item.realisasi;

                                html += '<tr>';
                                html += '<td class="text-center"><input type="checkbox" class="form-check-input chk-item" value="' + item.id_renkin + '"></td>';
                                html += '<td class="fw-semibold">' + item.indikator + '</td>';
                                html += '<td class="text-center">' + targetVal + '</td>';
                                html += '<td class="text-center fw-bold text-primary">' + realisasiVal + '</td>';
                                
                                // Dropdown Status Per Baris
                                html += '<td class="text-center">';
                                html += '<select name="status[' + item.id_renkin + ']" class="form-select form-select-sm select-status" data-id="' + item.id_renkin + '">';
                                html += '<option value="pending" ' + (statusVal === 'pending' ? 'selected' : '') + '>PENDING</option>';
                                html += '<option value="approved" ' + (statusVal === 'approved' ? 'selected' : '') + '>DISETUJUI</option>';
                                html += '<option value="rejected" ' + (statusVal === 'rejected' ? 'selected' : '') + '>DITOLAK</option>';
                                html += '</select>';
                                html += '</td>';

                                // Input Catatan
                                html += '<td>';
                                html += '<input type="text" name="catatan[' + item.id_renkin + ']" id="catatan_' + item.id_renkin + '" class="form-control form-control-sm" value="' + catatanVal + '" placeholder="Keterangan..." ' + (statusVal !== 'rejected' ? 'readonly' : '') + '>';
                                html += '</td>';
                                html += '</tr>';
                            });
                        } else {
                            html = '<tr><td colspan="6" class="text-center text-muted">Tidak ada indikator kinerja yang perlu divalidasi.</td></tr>';
                        }

                        $('#containerFormMassal').html(html);
                        $('#modalValidasiMassal').modal('show');
                    }
                });
            });

            // Check All Checkbox
            $('#checkAllIndikator').on('change', function() {
                $('.chk-item').prop('checked', $(this).is(':checked'));
            });

            // Toggle Readonly pada Catatan saat Status Dropdown berubah
            $(document).on('change', '.select-status', function() {
                var id = $(this).data('id');
                var isRejected = $(this).val() === 'rejected';
                $('#catatan_' + id).prop('readonly', !isRejected);
                if (isRejected) $('#catatan_' + id).focus();
            });

            // Action Batch Approved untuk Item yang Dicentang
            $('#btnBatchApprove').on('click', function() {
                $('.chk-item:checked').each(function() {
                    var idRenkin = $(this).val();
                    var $row = $(this).closest('tr');
                    $row.find('.select-status').val('approved').trigger('change');
                });
            });

            // Action Batch Rejected untuk Item yang Dicentang
            $('#btnBatchReject').on('click', function() {
                $('.chk-item:checked').each(function() {
                    var idRenkin = $(this).val();
                    var $row = $(this).closest('tr');
                    $row.find('.select-status').val('rejected').trigger('change');
                });
            });
        });
</script>

</html>