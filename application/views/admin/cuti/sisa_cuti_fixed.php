<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .my-table{
            width: 100%;
        }
        .my-table  td{
            padding:2px;

        }
        .btn-list {
            padding:10px 15px;
            text-align:center;
            border-bottom:1px solid #EEE;
            color:#666;
            margin-right:2px;
        }

        .active-btn{
            border-bottom:1px solid #66bad9;
            color:orange;
        }


    </style>


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('layout/section/sidebar');?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view('layout/section/topbar');?>

                    <!-- Start Content-->
                    <div class="container-fluid">


                        <?php
                            $message = $this->session->flashdata('message');
                            $id_pegawai = $this->session->userdata('id_pegawai');


                        ?>



                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Main Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php

                                    $list_bulan = array_bulan();

                                    $periode_bulan = $this->session->userdata('periode_bulan');
                                    $periode_tahun = $this->session->userdata('periode_tahun');
                                    $id_pkm_sess   = $this->session->userdata('id_pkm');


                               ?>




                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">Sisa Cuti Pegawai</h4>
                                        <br>

                                        <a href="<?php echo base_url();?>admin/cuti/generate_hak_cuti" class="btn btn-sm btn-primary float-end">Generate Cuti</a>
                                        <div class="clearfix"></div> <br>

                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm mb-0 table-bordered">
                                                <thead>
                                                        <tr>
                                                            <th class="text-center" rowspan="2">No</th>
                                                            <th rowspan="2">Nama</th>
                                                            <th rowspan="2">Jabatan</th>

                                                            <th class="text-center bg-warning-lighten" colspan="3">Cuti 2025</th>
                                                            <th class="text-center bg-success-lighten" colspan="3">Cuti 2026</th>
                                                            <th rowspan="2" class="text-center">Action</th>
                                                        </tr>
                                                        <tr>
                                                         
                                                            <th  class="text-center bg-warning-lighten">Hak Cuti</td>
                                                            <th  class="text-center bg-warning-lighten">Terpakai</td>
                                                            <th  class="text-center bg-warning-lighten">Sisa  Cuti</td>
                                                            <th  class="text-center bg-success-lighten">Hak Cuti</td>
                                                            <th  class="text-center bg-success-lighten">Terpakai</td>
                                                            <th  class="text-center bg-success-lighten">Sisa  Cuti</td>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                   
                                                            <?php $no = 1; foreach ($list as $row): ?>
                                                    <tr>
                                                        <td class="text-center"><?= $no++; ?></td>
                                                        <td><?= $row['nama']; ?></td>
                                                        <td><?= $row['jabatan']; ?></td>

                                                        <?php foreach ($tahun as $th): 
                                                            $cuti = $row['cuti'][$th] ?? ['hak'=>0,'terpakai'=>0,'sisa'=>0];
                                                        ?>
                                                            <td class="text-center"><?= $cuti['hak']; ?></td>
                                                            <td class="text-center"><?= $cuti['terpakai']; ?></td>
                                                            <td class="text-center fw-bold"><?= $cuti['sisa']; ?></td>
                                                        <?php endforeach; ?>

                                                       <td class="text-center">
                                                            <button 
                                                                type="button"
                                                                class="btn btn-sm btn-warning btn-input-cuti"
                                                                data-id="<?= $row['id_pegawai']; ?>"
                                                                data-nama="<?= $row['nama']; ?>"
                                                                data-sisa="<?= $row['cuti'][2025]['sisa'] ?? 0; ?>"
                                                            >
                                                                Input Sisa Cuti 2025
                                                            </button>

                                                            <a href="<?= base_url('admin/cuti/detail/'.$row['id_pegawai']); ?>" 
                                                            class="btn btn-sm btn-info mt-1">
                                                            Detail
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>


                            <div class="modal fade" id="modalSisaCuti" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <form action="<?= base_url('admin/cuti/simpanSisaCuti2025'); ?>" method="post">
                                                
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Input Sisa Cuti 2025</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>

                                                <div class="modal-body">
                                                    <input type="hidden" name="id_pegawai" id="idPegawai">

                                                    <div class="mb-2">
                                                        <label>Nama Pegawai</label>
                                                        <input type="text" id="namaPegawai" class="form-control" readonly>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label>Sisa Cuti Tahun 2025</label>
                                                        <input 
                                                            type="number" 
                                                            name="sisa_cuti" 
                                                            id="sisaCuti"
                                                            class="form-control"
                                                            min="0"
                                                            max="12"
                                                            required
                                                        >
                                                        <small class="text-muted">
                                                            Diisi sesuai rekap sisa cuti tahun 2025
                                                        </small>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">
                                                        Simpan
                                                    </button>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        Batal
                                                    </button>
                                                </div>

                                            </form>

                                        </div>
                                    </div>
                                </div>


                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>


        </div>
        <!-- END wrapper -->
        <?php $this->load->view('layout/section/theme-setting');?>


        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
   
        <!-- demo end -->
            <script>
            document.addEventListener('DOMContentLoaded', function () {

                document.querySelectorAll('.btn-input-cuti').forEach(function (btn) {
                    btn.addEventListener('click', function () {

                        document.getElementById('idPegawai').value = this.dataset.id;
                        document.getElementById('namaPegawai').value = this.dataset.nama;
                        document.getElementById('sisaCuti').value = this.dataset.sisa;

                        var modal = new bootstrap.Modal(
                            document.getElementById('modalSisaCuti')
                        );
                        modal.show();
                    });
                });

            });
            </script>




    </body>
</html>
