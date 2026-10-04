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

                                        <h4 class="header-title">Riwayat Cuti</h4>
                                        <br>

                                     
                                        <button type="button" class="btn btn-sm btn-primary float-end"  data-bs-toggle="modal" data-bs-target="#cuti-modal">Buat Pengajuan Cuti</button>
                                        <div class="clearfix"></div> <br>

                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm mb-0 table-bordered">
                                                <thead>
                                                        <tr>
                                                            <th>Tanggal Pengajuan</th>
                                                            <th>Tanggal Mulai</th>
                                                            <th>Tanggal Akhir</th>
                                                            <th>Lama Cuti</th>
                                                            <th>Alasan</th>
                                                            <th>Status</th>
                                                            <th>Action</th>
                                                        </tr>
                                                </thead>
                                                <tbody>
                                               

                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

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
         <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <!-- demo end -->

        <script>
            var message = '<?php echo $message;?>';

            if(message != ''){
                $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
            }

         

        </script>




    </body>
</html>
