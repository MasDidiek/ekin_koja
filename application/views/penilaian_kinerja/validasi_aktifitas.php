<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/monthly.css'); ?>">
    <style type="text/css">
        .calendar-table th {
            background: #f8f9fa;
            text-align: center;
        }

        .calendar-cell {
            height: 110px;
            vertical-align: top;
            position: relative;
            padding: 5px;
        }

        .calendar-cell .date-number {
            position: absolute;
            top: 5px;
            right: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .calendar-cell.today {
            background: #e3f2fd;
            border: 2px solid #2196f3;
        }

        .calendar-table {
            table-layout: fixed;
            width: 100%;
        }
        .text-grey{
            color: #666;
        }
        .fw-bold{
            font-weight: bold;
        }
        .text-orange{
            color: orangered;
        }

        .bg-orange {
            background-color: #fd7e14 !important;
            color: #ffffff !important;
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
                $jumlahHariKerja    = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
                $menitEfektifBulanan = $jumlahHariKerja * 300;

                $data_peg = isset($detail_pegawai[0]) ? $detail_pegawai[0] : null;

                $id_pegawai = isset($data_peg->id_pegawai) ? $data_peg->id_pegawai : '';
                $nama       = isset($data_peg->nama) ? $data_peg->nama : '';
                $nip        = isset($data_peg->nip) ? $data_peg->nip : '';
                $jabatan    = isset($data_peg->jabatan) ? $data_peg->jabatan : '';
                $puskesmas  = isset($data_peg->puskesmas) ? $data_peg->puskesmas : '';

                $periode    = $tahun . '-' . sprintf('%02d', $bulan);
            ?>

            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Penilaian Kinerja</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-primary text-decoration-none" href="<?php echo base_url('dashboard/index'); ?>">Dashboard</a>
                                            </li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-item">
                                                <a class="text-primary text-decoration-none" href="<?php echo base_url('admin/penilaian_kinerja/index'); ?>">Penilaian Kinerja</a>
                                            </li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-item">
                                                <a class="text-primary text-decoration-none" href="<?php echo base_url('admin/penilaian_kinerja/index'); ?>">Validasi Aktivitas</a>
                                            </li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-active text-muted"><?= htmlspecialchars($nama) ?></li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3 text-end">
                                    <a href="<?php echo base_url('admin/penilaian_kinerja/index'); ?>" class="btn btn-outline-secondary rounded-pill px-3">
                                        <i class="ti ti-arrow-left me-1"></i> Kembali ke daftar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <a href="?bulan=<?= $prev_bulan ?>&tahun=<?= $prev_tahun ?>" class="btn btn-sm btn-outline-secondary">
                                        «
                                    </a>
                                    <strong class="mx-3">
                                        <?= date('F Y', strtotime($tahun . '-' . $bulan . '-01')) ?>
                                    </strong>
                                    <a href="?bulan=<?= $next_bulan ?>&tahun=<?= $next_tahun ?>" class="btn btn-sm btn-outline-secondary">
                                        »
                                    </a>
                                </div>
                            </div>

                            <table class="table table-bordered calendar-table">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th>Sen</th>
                                        <th>Sel</th>
                                        <th>Rab</th>
                                        <th>Kam</th>
                                        <th>Jum</th>
                                        <th>Sab</th>
                                        <th>Min</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $today = date('Y-m-d');

                                        // Spasi sebelum tanggal 1
                                        for ($i = 1; $i < $hari_pertama; $i++) {
                                            echo '<td class="bg-light"></td>';
                                        }

                                        for ($tgl = 1; $tgl <= $jumlah_hari; $tgl++) {

                                            $currentDate = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tgl);
                                            $isToday     = ($currentDate == $today);
                                        ?>
                                            <td class="calendar-cell <?= $isToday ? 'today' : '' ?>" data-tgl="<?= $currentDate ?>" data-id="<?= $id_pegawai; ?>">
                                                <div class="calendar-day">
                                                    <div class="date-number"><?= $tgl ?></div>
                                                </div>

                                                <?php if (isset($kinerja[$currentDate])) : ?>
                                                    <div class="calendar-total" data-tgl="<?= $currentDate ?>" data-id="<?= $id_pegawai; ?>">
                                                        <div class="p-1 mt-4 text-white text-center rounded fs-1 total-inputan <?= $kinerja[$currentDate]['bg'] ?>" style="cursor:pointer">
                                                            <?= $kinerja[$currentDate]['total'] ?> menit
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </td>

                                        <?php
                                            if (($tgl + $hari_pertama - 1) % 7 == 0) {
                                                echo '</tr><tr>';
                                            }
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-4">
                            <!-- Card Profil Pegawai -->
                            <div class="card border-0 shadow-sm rounded-3 mb-3 bg-primary text-white">
                                <div class="card-body p-3">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded-circle bg-white-10 p-2 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background: rgba(255,255,255,0.2);">
                                            <i class="ti ti-user fs-3 text-white"></i>
                                        </div>
                                        <div>
                                            <h5 class="fw-bold mb-0 text-white"><?= htmlspecialchars($nama); ?></h5>
                                            <div class="small text-white-50"><?= htmlspecialchars($nip); ?></div>
                                            <span class="badge bg-white text-primary mt-1 fw-semibold"><?= htmlspecialchars($jabatan); ?> @ <?= htmlspecialchars($puskesmas); ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php 
                                // Logic Kalkulasi Persentase PHP 5.6+
                                $target_menit  = max(($menitEfektifBulanan ? $menitEfektifBulanan : 0), 1);
                                
                                $menit_input   = isset($summary['total_input']['menit']) ? $summary['total_input']['menit'] : 0;
                                $menit_acc     = isset($summary['disetujui']['menit']) ? $summary['disetujui']['menit'] : 0;
                                $menit_pending = isset($summary['pending']['menit']) ? $summary['pending']['menit'] : 0;
                                $menit_tolak   = isset($summary['ditolak']['menit']) ? $summary['ditolak']['menit'] : 0;

                                $jml_input   = isset($summary['total_input']['jumlah']) ? $summary['total_input']['jumlah'] : 0;
                                $jml_acc     = isset($summary['disetujui']['jumlah']) ? $summary['disetujui']['jumlah'] : 0;
                                $jml_pending = isset($summary['pending']['jumlah']) ? $summary['pending']['jumlah'] : 0;
                                $jml_tolak   = isset($summary['ditolak']['jumlah']) ? $summary['ditolak']['jumlah'] : 0;

                                // Hitung Persentase Terhadap Target Bulanan
                                $pct_input   = min(round(($menit_input / $target_menit) * 100, 1), 100);
                                $pct_acc     = min(round(($menit_acc / $target_menit) * 100, 1), 100);
                                $pct_pending = min(round(($menit_pending / $target_menit) * 100, 1), 100);
                                $pct_tolak   = min(round(($menit_tolak / $target_menit) * 100, 1), 100);
                            ?>

                            <!-- Card Target & Capaian Waktu Efektif Bulanan -->
                            <div class="card border border-light-subtle shadow-sm rounded-3 mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span class="fw-bold text-dark fs-7">Capaian Target Bulanan</span>
                                        <span class="badge bg-primary-subtle text-primary fw-bold"><?= $pct_input; ?>%</span>
                                    </div>
                                    <div class="text-muted small mb-2">
                                        Periode: <strong><?= date('F Y', strtotime($tahun . '-' . $bulan . '-01')); ?></strong>
                                    </div>

                                    <h4 class="fw-bold text-primary mb-2">
                                        <?= number_format($menit_input, 0, ',', '.'); ?> 
                                        <span class="fs-6 text-muted fw-normal">/ <?= number_format($target_menit, 0, ',', '.'); ?> menit</span>
                                    </h4>

                                    <!-- Combined Progress Bar Breakdown -->
                                    <div class="progress mb-2" style="height: 10px; background-color: #e9ecef;">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= $pct_acc; ?>%" title="Disetujui: <?= $pct_acc; ?>%"></div>
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: <?= $pct_pending; ?>%" title="Pending: <?= $pct_pending; ?>%"></div>
                                        <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $pct_tolak; ?>%" title="Ditolak: <?= $pct_tolak; ?>%"></div>
                                    </div>

                                    <!-- Legend Progress Bar -->
                                    <div class="d-flex justify-content-between text-muted fs-4">
                                        <span class="text-success"><i class="ti ti-circle-check me-1"></i> Acc: <?= $pct_acc; ?>%</span>
                                        <span class="text-warning"><i class="ti ti-clock me-1"></i> Pending: <?= $pct_pending; ?>%</span>
                                        <span class="text-danger"><i class="ti ti-circle-x me-1"></i> Tolak: <?= $pct_tolak; ?>%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Total Input Aktivitas -->
                            <div class="card border-0  shadow-sm rounded-3 mb-3">
                                <div class="card-body p-3">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <strong class="text-info d-block">Total Input Aktivitas</strong>
                                            <span class="text-muted small">Semua aktivitas yang telah diinput</span>
                                        </div>
                                        <button type="button" class="btn btn-info btn-sm view-all rounded-pill px-3" data-id="<?= $id_pegawai; ?>">
                                            <i class="ti ti-eye me-1"></i> Lihat Semua
                                        </button>
                                    </div>

                                    <div class="row g-2 mt-1">
                                        <div class="col-6">
                                            <span class="text-muted small d-block">Jumlah Input</span>
                                            <h5 class="fw-bold text-dark mb-0" id="sum-total-input"><?= $jml_input; ?> <small class="fs-7 text-muted">Aktivitas</small></h5>
                                        </div>
                                        <div class="col-6">
                                            <span class="text-muted small d-block">Total Menit</span>
                                            <h5 class="fw-bold text-info mb-0" id="sum-total-menit"><?= number_format($menit_input, 0, ',', '.'); ?> <small class="fs-7 text-muted">Menit</small></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Card Breakdown Status Aktivitas -->
                            <div class="card border border-light-subtle shadow-sm rounded-3">
                                <div class="card-body p-3">
                                    <strong class="text-dark d-block mb-3">Rincian Status Validasi</strong>

                                    <!-- Item 1: Disetujui -->
                                    <div class="p-2 mb-2 rounded bg-success-subtle border border-success-subtle d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-success fs-5"><i class="ti ti-circle-check me-1"></i> Disetujui</div>
                                            <small class="text-muted"><?= $jml_acc; ?> Aktivitas</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-success"><?= number_format($menit_acc, 0, ',', '.'); ?> mnt</div>
                                            <small class="text-muted"><?= $pct_acc; ?>% target</small>
                                        </div>
                                    </div>

                                    <!-- Item 2: Pending (Belum Diperiksa) -->
                                    <div class="p-2 mb-2 rounded bg-warning-subtle border border-warning-subtle d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-warning fs-5"><i class="ti ti-clock me-1"></i> Belum Diperiksa</div>
                                            <small class="text-muted"><?= $jml_pending; ?> Aktivitas</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-warning"><?= number_format($menit_pending, 0, ',', '.'); ?> mnt</div>
                                            <small class="text-muted"><?= $pct_pending; ?>% target</small>
                                        </div>
                                    </div>

                                    <!-- Item 3: Ditolak -->
                                    <div class="p-2 rounded bg-danger-subtle border border-danger-subtle d-flex justify-content-between align-items-center">
                                        <div>
                                            <div class="fw-bold text-danger fs-5"><i class="ti ti-circle-x me-1"></i> Ditolak</div>
                                            <small class="text-muted"><?= $jml_tolak; ?> Aktivitas</small>
                                        </div>
                                        <div class="text-end">
                                            <div class="fw-bold text-danger"><?= number_format($menit_tolak, 0, ',', '.'); ?> mnt</div>
                                            <small class="text-muted"><?= $pct_tolak; ?>% target</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Modal Detail Kinerja -->
                    <div class="modal fade" id="modalKinerja" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body" id="modalKinerjaBody" style="max-height: 800px; overflow-y: auto;">
                                    <div class="text-center p-4">
                                        <span class="spinner-border"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php $this->load->view('layout/section/theme-setting.php'); ?>
                    <?php $this->load->view('master/request-cuti.php'); ?>

                </div>
            </div>
            <div class="dark-transparent sidebartoggler"></div>
        </div>
    </div>

    <!-- Import JavaScript Base Libraries -->
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

    <script>
        function handleColorTheme(e) {
            $("html").attr("data-color-theme", e);
            $(e).prop("checked", !0);
        }

        $(document).ready(function() {

            // Klik cell/tanggal kalender -> list aktivitas harian
            $(document).on('click', '.calendar-cell, .calendar-total', function(e) {
                e.stopPropagation();

                var tgl        = $(this).data('tgl');
                var id_pegawai = $(this).data('id');

                if (!tgl || !id_pegawai) return;

                $('#modalKinerjaBody').html('<div class="text-center p-4"><span class="spinner-border"></span></div>');
                $('#modalKinerja').modal('show');

                $('#modalKinerjaBody').load(
                    '<?= site_url('admin/penilaian_kinerja/view_list_input_aktifitas') ?>', 
                    { tgl: tgl, id_pegawai: id_pegawai }
                );
            });

            // Klik tombol Lihat Semua -> modal semua aktivitas bulanan
            $(document).on('click', '.view-all', function(e) {
                e.stopPropagation();

                var id_pegawai = $(this).data('id');
                var periode    = '<?php echo $periode; ?>';

                $('#modalKinerjaBody').html('<div class="text-center p-4"><span class="spinner-border"></span></div>');
                $('#modalKinerja').modal('show');

                $('#modalKinerjaBody').load(
                    '<?= site_url('admin/penilaian_kinerja/view_all_aktifitas') ?>', 
                    { id_pegawai: id_pegawai, periode: periode }
                );
            });

            // Check All Global
            $(document).on('change', '#checkAllGlobal', function() {
                var isChecked = $(this).is(':checked');
                $('.check-item').prop('checked', isChecked);
            });

            $(document).on('change', '.check-item', function() {
                var totalItems   = $('.check-item').length;
                var totalChecked = $('.check-item:checked').length;
                $('#checkAllGlobal').prop('checked', (totalItems === totalChecked && totalItems > 0));
            });

            // Handling Submit Action Setujui / Tolak (Bulk Update)
            $(document).on('click', '.btn-action', function(e) {
                e.preventDefault();

                var actionType   = $(this).data('status');
                var checkedCount = $('.check-item:checked').length;

                if (checkedCount === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Pilih Aktivitas!',
                        text: 'Silakan centang minimal satu aktivitas terlebih dahulu.',
                        confirmButtonText: 'Pengertian'
                    });
                    return;
                }

                var titleText    = (actionType === 'setujui') ? 'Setujui Aktivitas?' : 'Tolak Aktivitas?';
                var confirmColor = (actionType === 'setujui') ? '#198754' : '#dc3545';

                Swal.fire({
                    title: titleText,
                    text: 'Anda akan memproses ' + checkedCount + ' aktivitas yang dipilih.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: confirmColor,
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Lanjutkan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        var form     = $('#formPenilaianAktifitas');
                        var formData = form.serializeArray();
                        formData.push({ name: 'action_status', value: actionType });

                        Swal.fire({
                            title: 'Memproses Data...',
                            allowOutsideClick: false,
                            didOpen: () => { Swal.showLoading(); }
                        });

                        $.ajax({
                            type: "POST",
                            url: form.attr('action'),
                            data: formData,
                            dataType: "json",
                            success: function(response) {
                                if (response.status === 'success' || response.status === true) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Berhasil!',
                                        text: response.message,
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        $('#modalKinerja').modal('hide');
                                        location.reload();
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: response.message
                                    });
                                }
                            },
                            error: function() {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Server Error!',
                                    text: 'Gagal memproses data.'
                                });
                            }
                        });
                    }
                });
            });

        });
    </script>
</body>
</html>