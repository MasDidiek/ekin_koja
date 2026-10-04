<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.css" rel="stylesheet">

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
                            $usergroup = $this->session->userdata('usergroup');
                            
                           // print_array($this->session->userdata);

//print_array($cuti_pegawai);
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
                                            
                                            <li class="breadcrumb-item active">Pengajuan Cuti</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Pengajuan Cuti</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                            
                                    
                              


                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">Pengajuan Cuti</h4>
                                        <br>

                                        <div class="table-responsive mt-3">
                                              <table id="datatable" class="table dt-responsive nowrap w-100">
                                                 <thead>
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th>Nama</th>
                                                            <th>Tgl Pengajuan</th>
                                                            <th>Jenis Cuti</th>
                                                           
                                                            <th class="text-center">Tgl Mulai Cuti</th>
                                                            <th class="text-center">Lama Cuti</th>
                                                            <th>Alasan</th>
                                                            <th class="text-center">Status</th>
                                                            
                                                            <th class="text-center">Action</th>
                                                        </tr>
                                                 </thead>
                                                <tbody>
                                                    <?php

                                                    $tahun = date('Y');
                                                    $cuti_tahun = $tahun;
                                                    $no = 1;
                                                    foreach($cuti_pegawai as $row){
                                                        
                                                        $tgl_dari = $row->tgl_mulai;
                                                        $tgl_sampai = $row->tgl_selesai;
                                                        $puskesmas = '';
                                                        $jns_cuti = $row->jenis_cuti;
                                                        $status_approval = $row->status_approval;

                                                         if($jns_cuti=='Cuti Tahunan'){
                                                            $text_class = 'text-info';
                                                        }else if($jns_cuti=='Cuti Sakit'){
                                                            $text_class = 'text-warning';
                                                        }else if($jns_cuti=='Cuti Alasan Penting'){
                                                            $text_class = 'text-danger';
                                                        }else{
                                                            $text_class = 'text-secondary';
                                                        }

                                                    

                                                    ?>
                                                  <tr  >
                                                    <td class="text-center"><?php echo $no++;?></td>
                                                    <td><?php echo $row->nama;?></td>
                                                    <td>
                                                        
                                                    <?php echo format_view($row->tgl_pengajuan);?></td>
                                                     <td class="<?php echo $text_class;?>"><?php echo $jns_cuti; ?></td>
                                                  
                                                    <td class="text-center"><?php echo format_hari($tgl_dari);?>, <?php echo format_semi($tgl_dari);?></td>
                                                    <td class="text-center"><?php echo $row->lama_cuti;?> Hari</td>
                                                    <td><?php echo $row->alasan_cuti;?></td>

                                                    <td><span class="badge bg-warning"> <?php echo $status_approval;?></span></td>
                                                  
                                                    <td class="text-center">
                                                      
                                                         <a href="<?php echo base_url();?>admin/cuti/detail_pengajuan_cuti/<?= $row->id; ?>" class="btn btn-sm btn-info">Detail</button>
                                                      
                                               
                                                    </td>
                                                  </tr>

                                                  <?php } ?>

                                                </tbody>
                                            </table>

                                            
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->

                            </div> <!-- end col-->
                        </div>





                             <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                                 <div class="modal-dialog modal-dialog-scrollable" role="document">

                                      <div class="modal-content">
                                        
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="scrollableModalTitle">Pengajuan Cuti</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body" id="info-detail-cuti"></div>
                                            <div class="modal-footer">
                                              
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="button" class="btn btn-success edit_cuti" value="" id="btn_edit_cuti">Ubah</button>
                                            </div>
                                     
                                   </div><!-- /.modal-content -->


                          </div><!-- /.modal-dialog -->
                      </div><!-- /.modal -->




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
               <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>
        
        <script>
 
            $('#datatable').dataTable( {
                lengthMenu: [
                    [  20, -1 ],
                    ['20', '50', '100', 'Show all' ]
                ]
            } );


        </script>

    </body>
</html>
