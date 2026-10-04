<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <style>
        .btn-xs{
            padding:3px 6px !important;
        }
    </style>



    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/index">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/presensi/index_v3">Laporan</a></li>
                                            <li class="breadcrumb-item active">Rekap Absensi</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Rekap Absensi</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <div class="col-xxl-12 col-lg-12">
                            <div class="card widget-flat">
                                <div class="card-body text-left">
                                    <h4>Rekap Absensi Pegawai</h4>
                                    <table>
                                        
                                    </table>
                                </div>
                             </div>
                        </div>


                        <!-- end row -->
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


        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url();?>assets/new/js/ui/component.todo.js"></script>

        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   

    </body>



</html>
