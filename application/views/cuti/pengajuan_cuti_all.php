<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css" />
                                                


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
                          $info = $this->session->flashdata('message');


                          $list_bulan = array_bulan();


                           $periode_bulan = $this->session->userdata('periode_bulan');
                           $periode_tahun = $this->session->userdata('periode_tahun');
                           $id_pkm_sess   = $this->session->userdata('id_pkm');
                           $id_pj_sess = $this->session->userdata('id_pj');
                           $id_user_validator   = $this->session->userdata('id_pegawai');

                           if($periode_bulan=='') {
                           $bulan = date('m');
                           $tahun = date('Y');

                           }else{
                               $bulan = $periode_bulan;
                               $tahun = $periode_tahun;
                           }

                           $periode = $tahun.'-'.$bulan;
                           $periode = date('Y-m', strtotime($periode));

                         ?>

                            <div class="col-xxl-12col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Pengajuan Cuti Pegawai</h4>
                                        <br>

                                        <?php

                                                for ($i = 1; $i <= 12; $i++) {
                                                    $nm_bulan = getBulan($i); 
                                                    echo '<div class="border-bottom mt-4 p-1 mb-3 fw-bold">' . $nm_bulan . ' ' . $tahun . '</div>';
                                                    echo '<div class="table-responsive">
                                                            <table class="table table-centered table-nowrap mb-0">
                                                                <thead>
                                                                    <tr class="fs-5">
                                                                        <th>No</th>
                                                                        <th>Tgl Pengajuan</th>
                                                                        <th>Nama</th>
                                                                        <th>Lama Cuti</th>
                                                                        <th>Tanggal Mulai</th>
                                                                        <th>Tanggal Akhir</th>
                                                                         <th>Status</th>
                                                                        <th>Action</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>';

                                                    if (!empty($cuti_perbulan[$i])) {
                                                        $no = 1;
                                                        foreach ($cuti_perbulan[$i] as $row) {

                                                            $status = $row->status;
                                                            if ($status == 'PEND0') {
                                                                $flag_status = '<span class="badge bg-warning text-white">Menunggu Acc Pengganti</span>';
                                                            }else if ($status == 'PEND1') {
                                                                $flag_status = '<span class="badge bg-warning text-white">Menunggu Acc Kapustu/Kasatpel</span>';
                                                            } else if ($status == 'PEND2') {
                                                                $flag_status = '<span class="badge bg-info text-white">Menunggu Acc Ka.Subbag TU</span>';
                                                            }else if ($status == 'APPROVE') {
                                                                $flag_status = '<span class="badge bg-success text-white">Disetujui</span>';
                                                            } else if ($status == 'CANCEL') {
                                                                $flag_status = '<span class="badge bg-danger text-white">Dibatalkan</span>';
                                                            } else {
                                                                $flag_status = '<span class="badge bg-secondary text-white">Unknown</span>';
                                                            }

                                                            echo '<tr>
                                                                    <td>'.$no++.'</td>
                                                                    <td>'.format_view($row->tgl).'</td>
                                                                    <td class="fw-bold">'.$row->nama.'</td>
                                                                    <td>'.$row->hari_cuti.' hari</td>
                                                                    <td>'.format_view($row->tgl_dari).'</td>
                                                                    <td>'.format_view($row->tgl_sampai).'</td>
                                                                    <td>'.$flag_status.'</td>
                                                                    <td>
                                                                        <button type="button" value="'.$row->id.'" class="btn btn-sm btn-info btn-detail">Detail</button>';
                                                                        if($status == 'PEND1'){
                                                                            echo '
                                                                              <button type="button" value="'.$row->id.'" class="btn btn-sm btn-success btn-setujui">Setujui</button>';
                                                                        }
                                                                    echo '
                                                                    </td>
                                                                </tr>';
                                                        }
                                                    } else {
                                                        echo '<tr><td colspan="7" class="text-center">Tidak ada pengajuan cuti</td></tr>';
                                                    }

                                                    echo '</tbody></table></div>';
                                                }

                                        ?>
                                     


                                    </div>
                                </div>
                            </div>
                    </div>


                    <!-- Modal Detail Cuti -->
                        <div class="modal fade" id="modalDetailCuti" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                            <div class="modal-header bg-primary text-white">
                                <h5 class="modal-title">Detail Cuti</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <div id="detailCutiContent">
                                <!-- detail cuti akan dimuat via ajax -->
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>

                                   

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


        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url();?>assets/new/js/ui/component.todo.js"></script>


        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->
<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



        <!-- Datatable Init js -->
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.datatable-init.js"></script>



        
        <script type="text/javascript">
                $(document).on("click", ".btn-detail", function () {
                    let id_cuti = $(this).val();

                    $.ajax({
                        url: "<?= base_url('cuti/ajax_detail_pengajuan_cuti'); ?>/" + id_cuti,
                        type: "GET",
                        success: function (res) {
                            $("#detailCutiContent").html(res);
                            $("#modalDetailCuti").modal("show");
                        }
                    });
                });


                $(document).on("click", ".btn-setujui", function () {
                    let id_cuti = $(this).val();

                    Swal.fire({
                        title: "Setujui Cuti?",
                        text: "Apakah kamu yakin ingin menyetujui cuti ini?",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "Ya, Setujui",
                        cancelButtonText: "Batal"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "<?= base_url('cuti/setujui_cuti_kapuskel'); ?>/" + id_cuti,
                                type: "POST",
                                success: function (res) {
                                    Swal.fire("Berhasil!", "Cuti telah disetujui.", "success").then(() => {
                                        location.reload(); // reload table
                                    });
                                },
                                error: function () {
                                    Swal.fire("Error", "Terjadi kesalahan", "error");
                                }
                            });
                        }
                    });
                });


        </script>




    </body>
</html>
