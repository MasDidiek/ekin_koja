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

   
                    $selected_profesi = $this->input->get('id_jabatan');

                    $selected_profesi = (isset($selected_profesi)) ? $selected_profesi : '';
                    ?>

                    <div class="card">
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Form Filter Menggunakan Method GET -->
                                        <form action="<?= site_url('admin/renkin/index'); ?>" method="get" class="mb-4">
                                            <div class="row g-3 align-items-end">

                                            
                                                    <div class="col-md-4">
                                                        <label for="id_validator" class="form-label fw-semibold">Jabatan/Profesi</label>
                                                        <select name="id_jabatan" id="id_jabatan" class="form-select">
                                                            <option value="">-- Semua Jabatan --</option>
                                                            <?php
                                                            if (!empty($list_jabatan)) {
                                                                foreach ($list_jabatan as $pj) {
                                                                    $selected = ($selected_profesi == $pj->id) ? 'selected' : '';
                                                                    echo '<option value="' . $pj->id . '" ' . $selected . '>' . htmlspecialchars($pj->nama) . '</option>';
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                            

                                                <!-- Tombol Submit & Reset -->
                                                <div class="col-md-3 d-flex gap-2">
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="ti ti-filter me-1"></i> Filter
                                                    </button>
                                                    <a href="<?= site_url('admin/renkin/index'); ?>" class="btn btn-light border text-muted" title="Reset Filter">
                                                        <i class="ti ti-refresh"></i>
                                                    </a>
                                                </div>

                                            </div>
                                        </form>
                                    </div>

                                

                                    <div class="table-responsive">
                                    
                                        <div class="col-md-12  mb-2 text-end">
                                            <button type="button" class="btn btn-success me-1" data-bs-toggle="modal" data-bs-target="#modalImport">
                                                <i class="uil-upload me-1"></i> Import Excel
                                            </button>
                                            <a href="<?= base_url('admin/renkin/add_indikator') ?>" class="btn btn-primary float-end">
                                                <i class="uil-plus me-1"></i> Add Indikator
                                            </a>
                                        </div>

                                        <div class="clearfix"></div>
                                        <table class="table table-bordered table-hover table-sm mt-3" id="tbl-validasi">
                                            <thead class="table-light text-center">
                                                        <tr>
                                                            <th width="50">No</th>
                                                            <th>Indikator Kinerja</th>
                                                            <th width="100">Satuan</th>
                                                            <th width="120">Target Tahunan</th>
                                                            <th width="160">Jabatan / Profesi</th>
                                                            <th width="120">Auto Fill Target</th>
                                                            <th width="100">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php if (!empty($list_indikator)): ?>
                                                            <?php $no = 1; foreach ($list_indikator as $row): ?>
                                                                <tr>
                                                                    <td class="text-center fw-bold"><?= $no++ ?></td>
                                                                    <td><?= htmlspecialchars($row->indikator) ?></td>
                                                                    <td class="text-center">
                                                                        <span class="text-dark"><?= htmlspecialchars($row->satuan) ?></span>
                                                                    </td>
                                                                    <td class="text-center fw-bold"><?= number_format($row->target_tahunan, 0, ',', '.') ?></td>
                                                                    <td>
                                                                        <span class=" text-dark"><?= htmlspecialchars($row->jabatan) ?></span>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php if ($row->auto_fill_target == 'Y'): ?>
                                                                            <span class="text-success">Ya</span>
                                                                        <?php else: ?>
                                                                            <span class="text-danger">Tidak</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <a href="<?= base_url('admin/renkin/edit_indikator/' . $row->id) ?>" class="btn btn-sm btn-outline-warning" title="Edit">
                                                                        <i class="ti ti-edit"></i>
                                                                        </a>
                                                                        <a href="<?= base_url('admin/renkin/hapus_indikator/' . $row->id) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')" title="Hapus">
                                                                        <i class="ti ti-trash"></i>
                                                                        </a>
                                                                    </td>
                                                                </tr>
                                                            <?php endforeach; ?>
                                                        <?php endif; ?>
                                                    </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                    </div>
                  

                      <!-- Modal Import Excel -->
                        <div class="modal fade" id="modalImport" tabindex="-1" aria-labelledby="modalImportLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalImportLabel">Import Data Indikator via Excel</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="<?= base_url('renkin/import_excel') ?>" method="post" enctype="multipart/form-data">
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label class="form-label">Pilih File Excel (.xlsx / .xls)</label>
                                                <input type="file" name="file" class="form-control" accept=".xlsx, .xls" required>
                                            </div>
                                            <div class="alert alert-info py-2">
                                                <small><strong>Format kolom Excel:</strong><br>
                                                Kolom A: Indikator<br>
                                                Kolom B: Satuan<br>
                                                Kolom C: Target Tahunan (Angka)<br>
                                                Kolom D: ID Profesi/Jabatan<br>
                                                Kolom E: Auto Fill Target (Y/T)
                                                </small>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success"><i class="uil-upload me-1"></i>Import Sekarang</button>
                                        </div>
                                    </form>
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
                        targets: [0, 6]
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