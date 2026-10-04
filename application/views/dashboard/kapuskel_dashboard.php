<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view("layout/section/header"); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



    <style>

        

    </style>


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view("layout/section/sidebar"); ?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view("layout/section/topbar"); ?>

                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Kapustu Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body fs-5">
                                        <?php
                                       // print_array($this->session->userdata);

                                        $nama = $this->session->userdata('nama');
                                        $id_puskesmas = $this->session->userdata('id_puskesmas');
                                        $usergroup = $this->session->userdata('usergroup');
                                      
                                        if($usergroup==4){
                                            $login_as = 'Penanggung Jawab Cluster';
                                        }else{
                                             $login_as = 'Kepala Puskesmas Pembantu';
                                        }

                                        $puskesmas = $this->Master_model->getNamaPuskesmas($id_puskesmas);
                                        ?>


                                            Selamat Datang, <strong><?php echo $nama;?> </strong> Anda login sebagai  <strong> <?=  $login_as ; ?> di <?= $puskesmas; ?></strong> <br>
                                            Aplikasi  Ekinerja Puskesmas Cilincing. 


                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row g-3">

                            <!-- Cuti -->
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="avatar-lg bg-opacity-10 text-success rounded  me-3 d-flex align-items-center justify-content-center">
                                            <i class="mdi mdi-calendar-clock fs-1"></i>
                                            
                                        </div>
                                        <div>
                                            <h3 class="mb-0 fw-bold"><?php echo $numCutiPending;?></h3>
                                            <div class="text-muted">Pengajuan Cuti</div>
                                            <small class="text-warning">Menunggu Persetujuan</small> <br>
                                             <a href="<?php echo base_url();?>dashboard/pengajuan_cuti_pending/kapustu" class="btn btn-sm text-info btn-light">Lihat</a>
                                           
                                        </div>
                                        
                                    </div>
                                    
                                </div>
                            </div>

                            <!-- Izin -->
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="avatar-lg bg-light bg-opacity-10 text-warning rounded  me-3 d-flex align-items-center justify-content-center">
                                            <i class="mdi mdi-account-clock fs-1"></i>
                                        </div>
                                        <div>
                                            <h3 class="mb-0 fw-bold">2</h3>
                                            <div class="text-muted">Pengajuan Izin</div>
                                            <small class="text-warning">Menunggu Persetujuan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Dinas Luar -->
                            <div class="col-md-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-body d-flex align-items-center">
                                        <div class="avatar-lg bg-light bg-opacity-10 text-info rounded me-3 d-flex align-items-center justify-content-center">
                                            <i class="mdi mdi-briefcase-outline fs-1"></i>
                                        </div>
                                        <div>
                                            <h3 class="mb-0 fw-bold">9</h3>
                                            <div class="text-muted">Dinas Luar</div>
                                            <small class="text-warning">Menunggu Persetujuan</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- end page title -->

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
        <?php $this->load->view("layout/section/theme-setting"); ?>

        <!-- bundle -->
        <script src="<?php echo base_url(); ?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url(); ?>assets/new/js/ui/component.todo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

         <script src="<?php echo base_url(); ?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->


    </body>
</html>
