<!DOCTYPE html>
<?php
$theme = $this->session->userdata('theme');
$theme = (isset($theme) && $theme != '') ? $theme : 'light';
?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

    <style>
        .custom-badge {
            font-size: 12px !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 0.25rem !important;
            color: #FFF !important;
        }

        /* TABLE: hanya garis horizontal */
        #tbl-validasi {
            border-collapse: collapse;
        }

        #tbl-validasi thead th {
            border-left: none !important;
            border-right: none !important;
            border-top: none;
            border-bottom: 2px solid #dee2e6;
        }

        #tbl-validasi tbody td {
            border-left: none !important;
            border-right: none !important;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
        }

        /* hover row lebih halus */
        #tbl-validasi tbody tr:hover {
            background-color: #f8f9fa;
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
                                            <li class="breadcrumb-active text-muted">Validasi Aktivitas</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $jns_pegawai = $this->uri->segment(4);
                    $usergroup   = $this->session->userdata('usergroup');
                    $id_pj_sess  = $this->session->userdata('id_pj');
                    $message    = $this->session->flashdata('message');

                    if (!empty($message)) {
                        echo $message;
                    }

                    // Penanganan parameter GET aman untuk PHP 5.6+
                    $get_bulan          = $this->input->get('bulan');
                    $get_tahun          = $this->input->get('tahun');
                    $selected_validator = $this->input->get('id_validator');


                    if ($get_bulan == '') {
                        $get_bulan           = $this->session->userdata('bulan');
                        $get_tahun           = $this->session->userdata('tahun');
                        $selected_validator = $this->session->userdata('id_validator');
                    }


                    $selected_bulan     = (isset($get_bulan) && $get_bulan != '') ? $get_bulan : date('n');
                    $selected_tahun     = (isset($get_tahun) && $get_tahun != '') ? $get_tahun : date('Y');
                    $selected_validator = (isset($selected_validator)) ? $selected_validator : '';
                    ?>

                    <div class="row">
                        <div class="col-12">
                            <!-- Form Filter Menggunakan Method GET -->
                            <form action="<?= site_url('admin/penilaian_kinerja/index'); ?>" method="get" class="mb-4">
                                <div class="row g-3 align-items-end">

                                    <!-- Filter Bulan -->
                                    <div class="col-md-3">
                                        <label for="bulan" class="form-label fw-semibold">Bulan</label>
                                        <select name="bulan" id="bulan" class="form-select">
                                            <?php
                                            $nama_bulan = array(
                                                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                            );
                                            foreach ($nama_bulan as $key => $value) {
                                                $selected = ($selected_bulan == $key) ? 'selected' : '';
                                                echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <!-- Filter Tahun -->
                                    <div class="col-md-2">
                                        <label for="tahun" class="form-label fw-semibold">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-select">
                                            <?php
                                            $tahun_sekarang = date('Y');
                                            for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 5; $i--) {
                                                $selected = ($selected_tahun == $i) ? 'selected' : '';
                                                echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <?php if ($usergroup < 2) : ?>
                                        <!-- Filter Penanggung Jawab / Validator -->
                                        <div class="col-md-4">
                                            <label for="id_validator" class="form-label fw-semibold">Penanggung Jawab</label>
                                            <select name="id_validator" id="id_validator" class="form-select">
                                                <option value="">-- Semua Validator --</option>
                                                <?php
                                                if (!empty($validator)) {
                                                    foreach ($validator as $pj) {
                                                        $selected = ($selected_validator == $pj->id_pegawai) ? 'selected' : '';
                                                        echo '<option value="' . $pj->id_pegawai . '" ' . $selected . '>' . htmlspecialchars($pj->nama) . '</option>';
                                                    }
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    <?php endif; ?>

                                    <!-- Tombol Submit & Reset -->
                                    <div class="col-md-3 d-flex gap-2">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="ti ti-filter me-1"></i> Filter
                                        </button>
                                        <a href="<?= site_url('admin/penilaian_kinerja/index'); ?>" class="btn btn-light border text-muted" title="Reset Filter">
                                            <i class="ti ti-refresh"></i>
                                        </a>
                                    </div>

                                </div>
                            </form>
                        </div>

                        <div class="table-responsive mt-2">
                            <a href="<?= site_url(
                                            'admin/penilaian_kinerja/updateRekapInput'
                                                . '?bulan=' . $selected_bulan
                                                . '&tahun=' . $selected_tahun
                                                . '&id_validator=' . $selected_validator
                                        ) ?>" class="btn btn-info float-end">
                                <i class="fas fa-sync-alt me-1"></i> Update Data
                            </a>

                            <div class="clearfix"></div>
                            <table class="table table-bordered table-hover table-sm mt-3" id="tbl-validasi">
                                <thead class="thead-light">
                                    <tr>
                                        <th width="30" class="text-center">No</th>
                                        <th>Nama Pegawai</th>
                                        <th>Jabatan</th>
                                        <th class="text-center">Total Input</th>
                                        <th class="text-center">Disetujui</th>
                                        <th class="text-center">Ditolak</th>
                                        <th class="text-center">Progress</th>
                                        <th class="text-center" width="120">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    if (!empty($data_pegawai)) :
                                        foreach ($data_pegawai as $row) :
                                            // Warna badge progress
                                            $persen = isset($row->persen_validasi) ? $row->persen_validasi : 0;
                                            if ($persen >= 90) {
                                                $badge = 'success';
                                            } elseif ($persen >= 70) {
                                                $badge = 'warning';
                                            } else {
                                                $badge = 'danger';
                                            }
                                    ?>
                                            <tr>
                                                <td class="text-center"><?= $no++ ?></td>
                                                <td>
                                                    <strong><?= htmlspecialchars($row->nama) ?></strong><br>
                                                    <small class="text-muted"><?= htmlspecialchars(isset($row->nip) ? $row->nip : '-') ?></small>
                                                </td>
                                                <td><?= htmlspecialchars(isset($row->jabatan) ? $row->jabatan : '-') ?></td>
                                                <td class="text-center"><?= isset($row->total_input) ? $row->total_input : 0 ?></td>
                                                <td class="text-center text-success fw-bold"><?= isset($row->disetujui) ? $row->disetujui : 0 ?></td>
                                                <td class="text-center text-danger fw-bold"><?= isset($row->ditolak) ? $row->ditolak : 0 ?></td>
                                                <td class="text-center">
                                                    <span class="badge bg-<?= $badge ?>">
                                                        <?= $persen ?>%
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    <a href="<?= site_url(
                                                                    'admin/penilaian_kinerja/validasi_aktifitas/'
                                                                        . $row->id_pegawai
                                                                        . '?bulan=' . $selected_bulan
                                                                        . '&tahun=' . $selected_tahun
                                                                ) ?>" class="btn btn-sm btn-primary">
                                                        <i class="fas fa-check me-1"></i> Validasi
                                                    </a>
                                                </td>
                                            </tr>
                                    <?php
                                        endforeach;
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <?php $this->load->view('layout/section/theme-setting.php'); ?>
                    <?php $this->load->view('master/request-cuti.php'); ?>

                </div>
            </div>
            <div class="dark-transparent sidebartoggler"></div>
        </div>
    </div>

    <!-- Import JavaScript Files -->
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

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

    <script>
        function handleColorTheme(e) {
            $("html").attr("data-color-theme", e);
            $(e).prop("checked", !0);
        }

        $(document).ready(function() {
            $('#tbl-validasi').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                searching: true,
                info: true,
                autoWidth: false,
                columnDefs: [{
                        orderable: false,
                        targets: [0, 7]
                    } // No (0) & Aksi (7) tidak bisa di-sort
                ],
                language: {
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                    infoEmpty: "Tidak ada data",
                    zeroRecords: "Data tidak ditemukan",
                    paginate: {
                        first: "Awal",
                        last: "Akhir",
                        next: "›",
                        previous: "‹"
                    }
                }
            });
        });
    </script>
</body>

</html>