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
                          $message  = $this->session->flashdata('message');


    //print_array($cuti);
        
                         ?>

                            <div class="col-xxl-12col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data Listing Cuti</h4>
                                        <br>


                                        <table id="datatable-buttons" class="table table-sm dt-responsive nowrap w-100">
                                                <thead class="bg-light">
                                                      <tr>

                                                          <th>No</th>
                                                          <th>Nama Pegawai</th>
                                                          <th>Jenis Cuti</th>
                                                          <th>Tgl Mulai Cuti</th>
                                                          <th>Lama Cuti</th>
                                                          <th>Alasan Cuti</th>
                                                          <th>Status Akhir</th>
                                                          <th>Pending On</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody>
                                                   <?php
                                                   $no =1;
                                                    foreach ($cuti as $row): 
                                                      $id  = $row->id;
                                                      $status_akhir  = $row->status_akhir;
                                                      $role_approval  = $row->role_approval;
                                                      $id_pegawai_approval  = $row->id_pegawai_approval;

                                                      if($status_akhir=='draft'){
                                                        $flag = '<span class="badge bg-light text-info">DRAFT</span>';
                                                      }elseif($status_akhir=='proses'){
                                                       $flag = '<span class="badge bg-warning">PROSES</span>';
                                                      }elseif($status_akhir=='dibatalkan'){
                                                       $flag = '<span class="badge bg-danger">CANCEL</span>';
                                                      }else{
                                                        $flag = '<span class="badge bg-success">DISETUJUI</span>';
                                                      }
                                                    ?>

                                                     <tr>
                                                      <td><?= $no ?></td>
                                                      <td><?= $row->nama; ?></td>
                                                      <td><?= $row->nama_jenis_cuti; ?></td>
                                                      <td class="text-center">
                                                        <a href="<?php echo base_url('admin/cuti/detail_pengajuan_cuti/'.$id);?>">
                                                        <?= format_semi($row->tgl_mulai); ?></a>  
                                                    </td>
                                                      <td class="text-center"><?= $row->lama_cuti; ?></td>
                                                      <td><?= $row->alasan_cuti; ?></td>
                                                      <td><?=  $flag; ?></td>
                                                      <td><?= $role_approval ; ?></td>
                                                     </tr>


                                                    <?php $no++; endforeach;?>

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


        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/buttons.bootstrap5.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/buttons.html5.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/buttons.flash.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/buttons.print.min.js"></script>




        <!-- Datatable Init js -->
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.datatable-init.js"></script>


        <script type="text/javascript">


        </script>




    </body>
</html>
