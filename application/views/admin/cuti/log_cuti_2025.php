<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <style>
        .btn-xs{
            padding:3px 6px !important;
        }

        .modal-dialog{
            z-index:999;
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">My Absensi</a></li>
                                            <li class="breadcrumb-item active">Kehadiran</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Data Absensi</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php

                                ?>




                        <div class="row">
                      

                            <div class="col-xxl-12  col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data Riwayat Cuti</h4>
                                       <span><?php
                                       if(!empty($log_cuti))
                                        {
                                         echo $log_cuti[0]->nama;
                                        }?>
                                         
                                        </span> <br> 
                                        

                                       <div class="mt-2">

                                    
                                            <form action="<?= base_url();?>admin/cuti/update_riwayat_cuti" method="post" style="display:flex;align-items:center;">
                                                    <input type="hidden" name="id_pegawai" value="<?= $this->uri->segment(4); ?>">

                                                    <span style="margin-right:8px;">Sisa Cuti 2024 :</span>

                                                    <input type="text" name="sisa_cuti" class="form-control" value="0" style="width:100px; margin-right:8px;">

                                                    <button type="submit" class="btn btn-info">Update</button>
                                                </form>
                                           </div>


                                         <table class="table mt-4 table-bordered table-sm">
                                                <thead class="bg-light">
                                                    <tr>
                                                            
                                                        <th class="text-center"> No</th>
                                                       
                                                        <th class="text-center">hak_cuti_tahun</th>
                                                        <th class="text-center">jns_cuti</th>
                                                        <th class="text-center">jns_transaksi</th>
                                                        <th class="text-center">tgl_dari</th>
                                                        <th class="text-center">tgl_sampai</th>
                                                        <th class="text-center"> alasan_cuti</th>
                                                        <th class=" text-center">Status</th>
                                                        
                                                         <th class="text-center">sisa_awal</th>
                                                        <th class="text-center"> jumlah hari</th>
                                                        <th class=" text-center">sisa_akhir</th>
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                   //print_array($log_cuti);

                                                 $no = 1;
                                                    foreach ($log_cuti as $list) {

                                                           $jns_hak_cuti = $list->jns_hak_cuti;
                                                           if ($jns_hak_cuti == 2) {
                                                                $hak_cuti_tahun = 2024;
                                                               
                                                            } else {
                                                                $hak_cuti_tahun = 2025;
                                                               
                                                            }

                                                      
                                                            echo '  <tr>
                                                                    <td class="text-center">'.$no.'</td>
                                                                   
                                                                    <td class="text-center">' . $hak_cuti_tahun . '</td>
                                                                    <td class="text-center">   '. $list->jns_cuti .' </td>
                        
                                                                    <td class="text-center">'.$list->jns_transaksi.' </td>
                                                                    <td class="text-center">'.$list->tgl_dari.'</td>
                                                                    <td class="text-center">'.$list->tgl_sampai.'</td>
                                                                    <td >'. $list->alasan_cuti.'</td>
                                                                    <td class="text-center">'. $list->status.'</td>
                                                                    <td class="text-center">'. $list->sisa_awal.'</td>
                                                                    <td class="text-center">'. $list->jumlah.'</td>
                                                                    <td class="text-center">'. $list->sisa_akhir.'</td>
                                                                    
                                                                            
                                                                            
                                                                </tr>';
                                                                $no++;
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

                <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-scrollable" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="scrollableModalTitle">Modal title</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body" id="datalist_absensi_raw">
                                asf
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->
                                    

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
