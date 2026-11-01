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
                                    <h4 class="fw-semibold mb-8">Renkin</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-primary text-decoration-none" href="<?php echo base_url('dashboard/index'); ?>">Dashboard</a>
                                            </li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-item">
                                                <a class="text-primary text-decoration-none" href="<?php echo base_url('admin/renkin/renkin_pegawai'); ?>">Rencana Kinerja</a>
                                            </li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-active text-muted">Indikator Renkin</li>
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
                                        <form action="<?= site_url('admin/renkin/indikator_renkin'); ?>" method="get" class="mb-4">
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
                                                    <a href="<?= site_url('admin/renkin/indikator_renkin'); ?>" class="btn btn-light border text-muted" title="Reset Filter">
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
                                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalIndikator">
                                                <i class="uil-plus me-1"></i> Add Indikator
                                            </button>
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
                                                            <th width="120">Jenis Indikator</th>
                                                            <th width="100">Status</th>
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
                                                                        <?php if ($row->jns_indikator == 'absolut'): ?>
                                                                            <span class="text-success">ABSOLUT</span>
                                                                        <?php else: ?>
                                                                            <span class="text-danger">AKUMULATIF</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?php if ($row->publish == 1): ?>
                                                                            <span class="badge bg-success">Published</span>
                                                                        <?php else: ?>
                                                                            <span class="badge bg-secondary">Unpublished</span>
                                                                        <?php endif; ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <button type="button" class="btn btn-sm btn-outline-warning" title="Edit" data-bs-toggle="modal" data-bs-target="#modalIndikator" data-indikator-id="<?= (int) $row->id ?>" data-indikator="<?= htmlspecialchars($row->indikator, ENT_QUOTES, 'UTF-8') ?>" data-satuan="<?= htmlspecialchars($row->satuan, ENT_QUOTES, 'UTF-8') ?>" data-target="<?= htmlspecialchars($row->target_tahunan, ENT_QUOTES, 'UTF-8') ?>" data-profesi="<?= (int) $row->profesi ?>"  data-jenis="<?= htmlspecialchars($row->jns_indikator, ENT_QUOTES, 'UTF-8') ?>">
                                                                        <i class="ti ti-edit"></i>
                                                                        </button>
                                                                        <form action="<?= base_url('admin/renkin/update_publish_indikator/' . $row->id) ?>" method="post" class="d-inline" onsubmit="return confirm('<?= $row->publish == 1 ? 'Unpublish' : 'Publish' ?> indikator ini?')">
                                                                            <input type="hidden" name="publish" value="<?= $row->publish == 1 ? 0 : 1 ?>">
                                                                            <button type="submit" class="btn btn-sm <?= $row->publish == 1 ? 'btn-outline-danger' : 'btn-outline-success' ?>" title="<?= $row->publish == 1 ? 'Unpublish' : 'Publish' ?>">
                                                                                <i class="ti <?= $row->publish == 1 ? 'ti-eye-off' : 'ti-eye' ?>"></i>
                                                                            </button>
                                                                        </form>
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
                  

                      <!-- Modal Tambah/Edit Indikator -->
                        <div class="modal fade" id="modalIndikator" tabindex="-1" aria-labelledby="modalIndikatorLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <form action="<?= base_url('admin/renkin/simpan_indikator_kinerja') ?>" method="post" id="formIndikator">
                                        <input type="hidden" name="id" id="indikator-id">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalIndikatorLabel">Tambah Indikator</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="indikator-text" class="form-label">Indikator Kinerja</label>
                                                <textarea name="indikator" id="indikator-text" class="form-control" rows="3" required></textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="indikator-satuan" class="form-label">Satuan</label>
                                                    <input type="text" name="satuan" id="indikator-satuan" class="form-control" required>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="indikator-target" class="form-label">Target Tahunan</label>
                                                    <input type="number" name="target_tahunan" id="indikator-target" class="form-control" min="1" step="1" required>
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="indikator-profesi" class="form-label">Jabatan / Profesi</label>
                                                <select name="profesi" id="indikator-profesi" class="form-select" required>
                                                    <option value="">-- Pilih Jabatan --</option>
                                                    <?php foreach ($list_jabatan as $jabatan): ?>
                                                        <option value="<?= (int) $jabatan->id ?>"><?= htmlspecialchars($jabatan->nama, ENT_QUOTES, 'UTF-8') ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="indikator-jenis" class="form-label">Jenis Indikator</label>
                                                    <select name="jns_indikator" id="indikator-jenis" class="form-select" required>
                                                        <option value="absolut">Absolut</option>
                                                        <option value="akumulatif">Akumulatif</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" id="indikator-submit">Simpan</button>
                                        </div>
                                    </form>
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

        var modalIndikator = document.getElementById('modalIndikator');
        modalIndikator.addEventListener('show.bs.modal', function(event) {
            var trigger = event.relatedTarget;
            var isEdit = trigger && trigger.hasAttribute('data-indikator-id');
            var form = document.getElementById('formIndikator');

            form.reset();
            document.getElementById('indikator-id').value = isEdit ? trigger.dataset.indikatorId : '';
            document.getElementById('indikator-text').value = isEdit ? trigger.dataset.indikator : '';
            document.getElementById('indikator-satuan').value = isEdit ? trigger.dataset.satuan : '';
            document.getElementById('indikator-target').value = isEdit ? trigger.dataset.target : '';
            document.getElementById('indikator-profesi').value = isEdit ? trigger.dataset.profesi : '';
            document.getElementById('indikator-auto-fill').value = isEdit ? trigger.dataset.autoFill : 'T';
            document.getElementById('indikator-jenis').value = isEdit ? trigger.dataset.jenis : 'absolut';
            document.getElementById('modalIndikatorLabel').textContent = isEdit ? 'Edit Indikator' : 'Tambah Indikator';
            document.getElementById('indikator-submit').textContent = isEdit ? 'Simpan Perubahan' : 'Simpan';
        });

    </script>
</body>

</html>