<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
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
                                        <h4>Datalist Import Data</h4>
                                        <br>

                                        

                                        <a href="<?php echo base_url();?>admin/listing_tkd/submit_import" class="btn btn-success float-end" >
                                            <i class="align-bottom ri-add-line me-1"></i> Simpan Data</a>
                                            <div class="clearfix"></div>
                                            <br>

                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                                <thead class="bg-light">
                                                    <tr>
                                                    <th class="w-1">No.</th>
                                            
                                                    <th>NIK</th>
                                                    <th>Nama Pegawai</th>
                                                    <th>Jumlah</th>
                                                    <th>Nama</th>
            
                                                    <th>NIP </th>
                                                    
                                            
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php 


//print_array($import_data);
                                                                                            
                                                        $no = 1;
                                                        foreach ($import_data as $import){

                                                            $nik  = $import->nik;
                                                            $nama  = $import->nama;
                                                            $jumlah = $import->jumlah;

                                                            $pegawai = $this->Pegawai_model->getPegawaiByNIK($nik);
                                                            
                                                            if(!empty($pegawai)){
                                                                $nm = $pegawai[0]->nama;
                                                                $nip = $pegawai[0]->nip;
                                                            }else{
                                                                $nm = '-';
                                                                $nip = '-';
                                                            }


                                                            echo' <tr>
                                                                    <td class="text-center">'.$no.'</td>
                                                                    <td class="text-center">'.$nik.'</td>
                                                                    <td class="text-start"> '.$nama.'</td>
                                                                    <td class="text-end">'.$jumlah.'</td>
                                                                    <td class="text-start">'.$nm.'</td>
                                                                    <td class="text-center">'.$nip.'</td>
                                                        
                                                                
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

        



    </body>
</html>
