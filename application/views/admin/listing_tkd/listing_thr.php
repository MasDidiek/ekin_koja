<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />

    <style>
        .btn-xs{
            padding:3px 6px !important;
        }

        .account-user-avatar img{
            width: 40px;
            height:45px;
        }

        img {
            border-radius: 50%;
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



                            <div class="col-xxl-12col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data Listing THR</h4>
                                        <br>


                                        <?php
                                                $totalRow = count($data_tkd);
                                                $numTTD = 0;
                                                for ($i=0; $i < count($data_tkd); $i++) { 

                                                      $ttd_spj = $data_tkd[$i]->ttd_spj;
                                                      if($ttd_spj !=''){
                                                        $numTTD =  $numTTD +1;


                                                      }


                                                }

                                                $persentage = ($numTTD/$totalRow)*100;
                                                $persentage = ceil($persentage);
                                            ?>
                                        <div id="views-min" class="apex-charts mt-2" data-colors="#0acf97"></div>

                                                                                    <!-- Success -->
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persentage ;?>%" aria-valuenow="<?php echo $persentage ;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                              <h5>
                                            <?php
                                                echo  '<span class="text-warning">'.$numTTD.' </span>/ '.$totalRow .' rows &nbsp; ( '. $persentage.'%)'; 
                                            ?>



                                        <a href="<?php echo base_url();?>admin/pegawai/add_pegawai" class="btn btn-primary float-end">Tambah Pegawai</a>
                                        <div class="clearfix">  </div> <br>

                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                                <thead class="bg-light">
                                                     <tr>
                                                        
                                                        <th class="text-center">No.</th>
                                                        <th>Nama</th>
                                                        <th>Jabatan</th>
                                                        <th>NPWP</th>
                                                        <th>THR Gaji</th>
                                                        <th>THR TKD</th>
                                                        <th class="text-center">Total</th>
                                                        <th class="text-center">No Handphone</th>
                                                      
                                                        <th class="text-center">TTD</th>
                                                        <th  class="text-center">Action</th>
                                                    
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                <?php 
                                                    $case = $this->uri->segment(4);
                                                    $grandTotal = 0;
                                                    $no = 1;
                                                    foreach ($data_tkd as $peg){

                                                    $nama = $peg->nama;
                                                    $nip = $peg->nip;
                                                    $jabatan = $peg->jabatan;
                                                    $npwp = $peg->npwp;
                                                    $thr_gaji =   $peg->thr_gaji;
                                                    $thr_tkd =   $peg->thr_tkd;
                                                    $total =   $peg->total;
                                                    $capaian = rupiah($total);

                                                     
                                                    

                                                    $ttd_spj = $peg->ttd_spj;
                                                  


                                                    if($ttd_spj==''){
                                                        $btn_ttd = '<span class="badge bg-danger">Belum</span>';
                                                        $no_hp = '';
                                                        $btn_reset = '';
                                                    }else{
                                                        $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="100">';
                                                        $no_hp = $peg->no_hp;
                                                        $btn_reset = '<a href="'.base_url().'admin/listing_tkd/reset_tdd/'.$peg->id.'" class="btn btn-sm btn-warning" onClick="return confirm(\'apakah anda ingin mereset tandatangan ini?\')">
                                                          Reset
                                                        </a>';
                                                    }
                                                        
                                                    

                                                        echo' <tr>
                                                                    <td class="text-center">'.$no.'</td>
                                                                    <td class="text-left"> '.$nama.'</td>
                                                                
                                                                    <td class="text-left">'.$jabatan.'</td>
                                                                    <td class="text-center">'.$npwp.'</td>
                                                                    <td class="text-end">'.rupiah($thr_gaji).'</td>
                                                                    <td class="text-end">'.rupiah($thr_tkd).'</td>
                                                                    <td class="text-end">'.$capaian.'</td>
                                                                
                                                                    <td class="text-center">'.$no_hp.'</td>
                                                                    <td class="text-center">'.$btn_ttd.'</td>
                                                                    <td class="text-center">'.$btn_reset.'</td>

                                                                </tr>';

                                                            $no += 1;

                                                    }

                                                    ?>
                                                            </tbody>
                                                </table>



                                    </div>
                                </div>
                            </div> <!-- end col-->
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

                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>

        <!-- Datatable Init js -->
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.datatable-init.js"></script>






    </body>
</html>
