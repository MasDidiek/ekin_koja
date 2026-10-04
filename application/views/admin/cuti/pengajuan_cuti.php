<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">


    <style>
        .datepicker {
            z-index: 1999;
        }




        .alert-danger {
            color: #F04444;
            background: #FFF8F8 !important;
        }

        .timeline-alt {
            padding: 20px 0;
            position: relative;
        }

        .timeline-item {
            border-left: 2px solid #EEE;
            padding-left: 10px;
            margin-top: 10px;
            border-bottom: 1px solid #EEE
        }

        .text-warning,
        .text-muted {
            font-size: 12px;
        }

        .bagde {
            font-size: 12px;
            padding: 2px 10px;
            border-radius: 8px;
            color: #FFF8F8;
        }

        .bg-success {
            background-color: #51e04c;

        }

        .bg-grey {
            background-color: #d1e2e9;
            color: #3e74d8;

        }

        .bg-dark-grey {
            background-color: #76797a;
            color: #f4f5f7;

        }
    </style>
</head>

<body>


    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <aside class="left-sidebar with-vertical">
            <div><!-- ---------------------------------- -->
                <!-- Start Vertical Layout Sidebar -->
                <!-- ---------------------------------- -->

                <?php $this->load->view('layout/section/sidebar'); ?>

        </aside>

        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <?php $this->load->view('layout/section/header'); ?>
            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Pengajuan Cuti</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="<?php echo base_url(); ?>dashboard/index">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Pengajuan Cuti</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>


                        </div>
                    </div>


                    <div class="col-12">
                        <div class="page-title-box">

                            <h4 class="page-title"> Pengajuan Cuti </h4>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <?php
                //print_array($cuti);
                ?>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="card border-bawah-danger">




                            <div class="card-body ">
                                <form method="get" action="<?php echo base_url(); ?>admin/cuti/filter_cuti" class="mb-3">
                                    <div class="row g-2">


                                        <!-- Date From -->
                                        <div class="col-md-2">
                                            <label class="form-label text-muted">Tanggal From</label>
                                            <input type="date" name="date_from" class="form-control" value="<?= $this->input->get('date_from') ?>">
                                        </div>

                                        <!-- Date To -->
                                        <div class="col-md-2">
                                            <label class="form-label text-muted">Tanggal To</label>
                                            <input type="date" name="date_to" class="form-control" value="<?= $this->input->get('date_to') ?>">
                                        </div>

                                        <!-- Status -->
                                        <div class="col-md-2">
                                            <label class="form-label text-muted">Status</label>
                                            <select name="status" class="form-select">
                                                <option value="">-- Semua --</option>
                                                <option value="proses">Pending</option>
                                                <option value="disetujui">Disetujui</option>
                                                <option value="ditolak">Ditolak</option>
                                                <option value="dibatalkan">Dibatalkan</option>
                                            </select>
                                        </div>

                                        <!-- Jenis Cuti -->
                                        <div class="col-md-2">
                                            <label class="form-label text-muted">Jenis Cuti</label>
                                            <select name="jenis_cuti" class="form-select">
                                                <option value="">-- Semua --</option>
                                                <?php foreach ($listJenisCuti as $jc) : ?>
                                                    <option value="<?= $jc->id ?>">
                                                        <?= $jc->jenis_cuti ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <!-- Button -->
                                        <div class="col-md-2 d-flex align-items-end">
                                            <button class="btn btn-danger w-100">
                                                <i class="fa fa-filter"></i> Filter
                                            </button>
                                        </div>

                                    </div>
                                </form>
                                <table border="1" class="table table-hover" width="100%" id="tblCuti">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Jenis Cuti</th>
                                            <th>Nama Pegawai</th>
                                            <th>Tanggal Mulai </th>
                                            <th>Tanggal Akhir </th>
                                            <th>Lama Cuti (Hari)</th>
                                            <th>Alasan Cuti</th>
                                            <th>Status Approval</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($cuti)) : ?>
                                            <?php foreach ($cuti as $key => $row) : ?>
                                                <tr onclick="goDetail(<?= $row->id ?>)" style="cursor:pointer;">
                                                    <td><?= $key + 1 ?></td>
                                                    <td><?= $row->jenis_cuti ?></td>
                                                    <td class="text-left text-navy"><?= $row->nama ?></td>


                                                    <td>
                                                        <?= format_view($row->tgl_mulai) ?>

                                                    </td>
                                                    <td>
                                                        <?= format_view($row->tgl_selesai) ?>

                                                    </td>
                                                    <td class="text-center"><?= $row->lama_cuti ?></td>


                                                    <td><?= $row->alasan_cuti ?></td>
                                                    <td>
                                                        <?php if ($row->status_akhir == 'proses') : ?>
                                                            <span class="bagde bg-warning">Proses</span>
                                                        <?php elseif ($row->status_akhir == 'draft') : ?>
                                                            <span class="bagde bg-grey">Pengajuan</span>
                                                        <?php elseif ($row->status_akhir == 'disetujui') : ?>
                                                            <span class="bagde bg-success">Disetujui</span>
                                                        <?php elseif ($row->status_akhir == 'dibatalkan') : ?>
                                                            <span class="bagde bg-dark-grey">Batal</span>
                                                        <?php else : ?>
                                                            <span class="bagde bg-danger">Rejected</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <tr>
                                                <td colspan="10" align="center">Data tidak tersedia</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>

                            </div>
                            <!-- end card-body -->
                        </div>
                        <!-- end card-->
                    </div> <!-- end col-->




                </div>
            </div>



            <div class="py-6 px-6 text-center">
                <p class="mb-0 fs-4">Design and Developed by
                    <a href="#" target="_blank" class="pe-1 text-primary text-decoration-underline">DhifaWebStudio</a>
                </p>
            </div>

            <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
            <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
            <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>dashboard.js"></script>


            <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

            <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>
            <script>
                function goDetail(id) {
                    window.location.href = "<?= base_url('admin/cuti/detail_pengajuan_cuti/') ?>" + id;
                }


                $(document).ready(function() {
                    $('#tblCuti').DataTable({
                        pageLength: 10,
                        lengthMenu: [10, 25, 50, 100],
                        ordering: true,
                        searching: true,
                        info: true,
                        autoWidth: false,
                        columnDefs: [{
                                orderable: false,
                                targets: [0, 5]
                            } // No & Aksi tidak bisa sort
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