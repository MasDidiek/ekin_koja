<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/signature.js"></script>

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

                                  
                                    $bulan = $periode_bulan;
                                    $tahun = $periode_tahun;
                                

                                  
                                   $id_pegawai = $this->session->userdata('id_pegawai');
                                   
                                   $nama_user =  $this->session->userdata('nama');
                                   $nip_user =  $this->session->userdata('nip');
                                   $id_pegawai =  $this->session->userdata('id_pegawai');
                                   $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);


                                   $pin 	= substr($nip_user, -4);

                                   $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);

                                   $jabatan =  $detail_pegawai[0]->jabatan;
                                   $puskesmas =  $detail_pegawai[0]->puskesmas;


                               ?>



                        <div class="row">
                            <div class="col-xl-4 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <span class="float-start m-2 me-4">
                                            <img src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photo ;?>" style="height: 100px;" alt="" class="rounded-circle img-thumbnail">
                                        </span>
                                        <div class="">
                                            <h4 class="mt-1 mb-1"><?php echo  $nama_user ;?></h4>
                                            <p class="font-13"> <?php echo $jabatan;?></p>
                                    
                                            <ul class="mb-0 list-inline">
                                                <li class="list-inline-item me-3">
                                                   
                                                    <p class="mb-0 font-13"><?php echo $puskesmas;?></p>
                                                </li>
                                                <li class="list-inline-item">
                                                    <h5 class="mb-1"><?php echo $nip_user;?></h5>
                                                   
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- end div-->
                                    </div>
                                    <!-- end card-body-->
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-4 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <i class="mdi mdi-chart-bar widget-icon bg-success rounded-circle text-white"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Revenue">Total Capaian </h5>
                                        <h3 class="mt-3"><?php echo $dataCapaian[0]->total_capaian;?>%</h3>
                                        <div class="row text-start">
                                            <div class="col-4">
                                                <h6 class="text-truncate d-block">Bobot Aktifitas</h6>
                                                <p class="font-18 mb-0"><?php echo $dataCapaian[0]->bobot_aktifitas;?>%</p>
                                            </div>
                                            <div class="col-4">
                                                <h6 class="text-truncate d-block">Perilaku</h6>
                                                <p class="font-18 mb-0"><?php echo $dataCapaian[0]->perilaku;?>%</p>
                                            </div>
                                            <div class="col-4">
                                                <h6 class="text-truncate d-block">Serapan</h6>
                                                <p class="font-18 mb-0"><?php echo $dataCapaian[0]->serapan;?>%</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xl-4 col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                            <h5 class="text-muted fw-normal mt-0" title="Revenue"> Total Menit Pengurang</h5>
                                            <h3 class="mt-3"><?php echo $dataRekap[0]->telat;?> menit</h3>
                                           
                                            <div class="row text-start">
                                            <div class="col-4 text-danger">
                                                <h6 class="text-truncate d-block">Telat</h6>
                                                <p class="font-18 mb-0"><?php echo $dataRekap[0]->telat;?></p>
                                            </div>
                                            <div class="col-4 text-warning">
                                                <h6 class="text-truncate d-block">Izin</h6>
                                                <p class="font-18 mb-0"><?php echo $dataRekap[0]->izin;?></p>
                                            </div>
                                            <div class="col-4 text-warning">
                                                <h6 class="text-truncate d-block">Sakit</h6>
                                                <p class="font-18 mb-0"><?php echo $dataRekap[0]->sakit;?></p>
                                            </div>
                                        </div>
                                        <!-- end div-->
                                    </div>
                                    <!-- end card-body-->
                                </div>
                            </div> <!-- end col -->

                           
                        </div>
                        <!-- end row-->



                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            </div>
                                        </div>
                                        <h4 class="header-title">Capaian Kinerja</h4>
                                        <br><br>

                                     
                                                <div class="col-xl-6">
                                                  
                                                            <div dir="ltr">
                                                                <div class="donut-container text-center" style="width: 100%;" data-colors2="#727cf5,#0acf97,#6c757d,#fa5c7c,#ffbc00,#39afd1"></div>
                                                                <div class="legend-chart-container text-center"></div>
                                                            </div>
                                                      
                                                    <!-- end card -->
                                                </div>

                                                
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

        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>

               <!-- third party:js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/d3.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/britecharts.min.js"></script>
        <!-- third party end -->

      
      
    </body>
</html>
