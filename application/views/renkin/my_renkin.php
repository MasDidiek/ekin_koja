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
                <!-- Elemen Loading (Diatur d-none agar tersembunyi secara bawaan) -->
                <div id="loadingState" class="d-none align-items-center gap-2">
                    <span class="loader-spinner"></span>
                    <span class="fw-semibold">Sedang menyimpan data...</span>
                </div>

                <!-- Tombol Buat Rencana Kinerja (Di sebelah kanan) -->
                <a href="<?php echo base_url('admin/renkin/buat_renkin?tahun=' . $tahun_renkin); ?>" 
                id="btnBuatRenkin" 
                class="btn btn-primary ms-auto">
                Buat Rencana Kinerja
                </a>
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
                                        $status = $row->status;

                                        // Re-index data detail berdasarkan bulan (1-12)
                                        $detail_by_bulan = [];
                                        if (!empty($renkin_detail)) {
                                            foreach ($renkin_detail as $rd) {
                                                $detail_by_bulan[$rd->bulan] = $rd; 
                                            }
                                        }
                                    ?>
                                        <tr>
                                            <td class="text-center fw-bold"><?= $no++ ?></td>
                                            <td>
                                                <a href="javascript:void(0)" 
                                                class="text-primary fw-semibold btn-edit-renkin" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditRenkin"
                                                data-id="<?= $row->id ?>" 
                                                data-target="<?= $row->target_tahunan; ?>"
                                                data-indikator="<?= htmlspecialchars($row->indikator) ?>">
                                                    <?= word_limiter(htmlspecialchars($row->indikator), 10) ?>
                                                </a>
                                            </td>
                                            <td class="text-center"><?= htmlspecialchars($row->satuan) ?></td>
                                            <td class="text-center fw-bold"><?= number_format($row->target_tahunan, 0, ',', '.') ?></td>
                                            
                                            <!-- Looping tepat 12 bulan (1 s/d 12) -->
                                            <?php for ($bln = 1; $bln <= 12; $bln++): 
                                                $detail = isset($detail_by_bulan[$bln]) ? $detail_by_bulan[$bln] : null;
                                                $target_val = $detail ? $detail->target : null;
                                                $realisasi_val = $detail ? $detail->realisasi : null;
                                                $status_val = $detail ? $detail->status : null;

                                                $total_target_tahunan += (float)$target_val;

                                                // Tampilan Target & Realisasi
                                                $target_show = is_null($target_val) ? '-' : $target_val;
                                                $realisasi_show = (is_null($realisasi_val) || $realisasi_val === '') ? '-' : $realisasi_val;

                                                // Kalkulasi Persentase Capaian & Style Class
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
                                                <!-- Kolom Target -->
                                                <td class="text-center"><?= $target_show ?></td>

                                                <!-- Kolom Realisasi (Bersih hanya menampilkan angka/karakter) -->
                                                <td class="text-center"><?= $realisasi_show ?></td>

                                                <!-- Kolom Capaian % (Dilengkapi Badge + Status Dot) -->
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

                <!-- Modal Form Renkin -->
                <div class="modal fade" id="modalEditRenkin" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Target & Realisasi: </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="formRenkin" action="<?= base_url('admin/renkin/update_detail') ?>" method="POST">

                            <div class="px-4">
                               <div class="border border-warning p-2 fw-bold"><span id="labelIndikator"></span></div>

                               <div class="my-3" style="width: 200px;">
                                <label for="titel-target">Target Tahunan</label>
                                 <input type="number" name="target_tahunan" id="target_tahunan" value="0" class="form-control">
                               </div>
                              
                            </div>
                               
                                <input type="hidden" name="id_renkin" id="input_id_renkin">
                                <div class="modal-body">
                                    <div class="table-responsive" style="max-height: 300px; overflow-y: scroll;">
                                        <table class="table table-bordered align-middle">
                                            <thead class="table-light text-center">
                                                <tr>
                                                    <th>Bulan</th>
                                                    <th>Target</th>
                                                    <th>Realisasi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="containerFormBulan">
                                                <!-- Inputan 12 bulan akan di-load via JavaScript -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
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


  $('#btnBuatRenkin').on('click', function() {
        // Tampilkan loading state
        $('#loadingState').removeClass('d-none').addClass('d-inline-flex');
        
        // Nonaktifkan tombol
        $(this).addClass('disabled').css('pointer-events', 'none');
    });

     $(document).ready(function() {
            $('.btn-edit-renkin').on('click', function() {
                var idRenkin = $(this).data('id');
                var target_tahunan = $(this).data('target');
                var namaIndikator = $(this).data('indikator');

                $('#input_id_renkin').val(idRenkin);
                $('#target_tahunan').val(target_tahunan);
                $('#labelIndikator').text(namaIndikator);

                // Reset isi tabel form sebelum memuat data baru
                $('#containerFormBulan').html('<tr><td colspan="3" class="text-center">Memuat data...</td></tr>');

                $.ajax({
                    url: '<?= base_url("admin/renkin/get_detail_ajax") ?>/' + idRenkin,
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        var html = '';
                        var namaBulan = [
                            "Januari", "Februari", "Maret", "April", "Mei", "Juni", 
                            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                        ];

                        // Ambil bulan saat ini (1 - 12)
                        var currentMonth = new Date().getMonth() + 1;

                        var dataMap = {};
                        if (Array.isArray(response)) {
                            response.forEach(function(item) {
                                dataMap[item.bulan] = item;
                            });
                        }

                        for (var i = 1; i <= 12; i++) {
                            var item = dataMap[i] || {};

                            var targetVal = (item.target !== undefined && item.target !== null) ? item.target : '';
                            var realisasiVal = (item.realisasi !== undefined && item.realisasi !== null) ? item.realisasi : '';

                            // Cek apakah bulan iterasi melebihi bulan saat ini
                            var isFutureMonth = i > currentMonth;
                            var disabledAttr = isFutureMonth ? 'disabled' : '';
                            var placeholderText = isFutureMonth ? 'Belum Waktunya' : 'Kosong (Belum Input)';
                            var bgClass = isFutureMonth ? 'bg-light' : '';

                            html += '<tr class="' + bgClass + '">';
                            html += '<td class="fw-bold text-center align-middle">' + namaBulan[i - 1] + '</td>';
                            
                            // Input Target: Kapan saja SELALU BISA diisi
                            html += '<td><input type="number" name="target[' + i + ']" class="form-control text-center" value="' + targetVal + '" min="0"></td>';
                            
                            // Input Realisasi: Jika bulan yang akan datang, tambahkan atribut "disabled"
                            html += '<td><input type="number" name="realisasi[' + i + ']" class="form-control text-center ' + bgClass + '" value="' + realisasiVal + '" placeholder="' + placeholderText + '" min="0" ' + disabledAttr + '></td>';
                            
                            html += '</tr>';
                        }

                        $('#containerFormBulan').html(html);
                        $('#modalEditRenkin').modal('show');
                    },
                    error: function() {
                        alert('Gagal mengambil data detail Renkin.');
                    }
                });
            });
        });
</script>

</html>