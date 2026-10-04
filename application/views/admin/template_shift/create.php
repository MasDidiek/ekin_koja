<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
<!-- DataTables CSS -->


                    <!-- Datatables css -->
    <link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />


    
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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/my_dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>setting/hari_kerja">Data Absensi</a></li>
                                            <li class="breadcrumb-item active">Rekap Absensi</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Template Shift Kerja Pegawai</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


            
                  <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                        
                            <div class="card-body p-4">
                               
                                        <h3>Buat Template Shift</h3>

                                        <form method="post" action="<?= base_url('admin/template_shift/store') ?>">
                                            Nama Template : <br>
                                            <input type="text" name="nama_template" class="form-control" required><br><br>

                                            Bulan : <br>
                                            <input type="number" name="bulan"  class="form-control"  min="1" max="12" required><br><br>

                                            Tahun : <br>
                                            <input type="number" name="tahun"  class="form-control"  required><br><br>

                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </form>
                                
                                </div>
                            </div><!--card body-->
                        </div>

                               
                       

                        </div>
                      </div>
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

        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>
        <!-- Todo js -->
        <script src="<?php echo base_url();?>assets/new/js/ui/component.todo.js"></script>
    
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- DataTables JS -->
    
    </body>
</html>
