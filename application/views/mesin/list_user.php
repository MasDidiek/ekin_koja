<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>

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
                            $message = $this->session->flashdata('message');
                        ?>
                       

                        <div class="row">
                            <div class="col-xl-3 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                      
                                        <div class="row">
                                             <div class="col-md-3">
                                                <div style="font-size:80px">
                                                    <i class="mdi mdi-file-table-box"></i>
                                                </div>
                                            </div>
                                             <div class="col-md-8"> <br>
                                                <h4 class="mb-1"><?php echo  $detail_mesin[0]->nama_mesin ;?></h4>
                                                <p class="font-13"> <?php echo $detail_mesin[0]->serial_number;?></p>
                                                <strong><?php echo $detail_mesin[0]->ip_address;?></strong>
                                             </div>
                                        
                                           
                                            
                                        </div>
                                        <!-- end div-->
                                    </div>
                                </div>

                                 <div class="card widget-flat">
                                    <div class="card-body">
                                        <h4>Mesin Absensi</h4> <br>

                                      <?php

                                        for ($i=0; $i < count($mesin_absensi) ; $i++) { 
                                            $serial_number = $mesin_absensi[$i]->serial_number;
                                            $nama_mesin = $mesin_absensi[$i]->nama_mesin;
                                            $ip_address = $mesin_absensi[$i]->ip_address;
                                            $status = $mesin_absensi[$i]->status;

                                        
                                            if($detail_mesin[0]->serial_number== $serial_number ){
                                                 $class="btn-light";
                                            }else{
                                                 $class="btn-success";
                                            }

                                            

                                            if ($status==1) {
                                                $flag = '<a href="'.base_url().'admin/setting/refresh_mesin/'.$ip_address.'" class="badge bg-success">
                                                        Online  &nbsp; <i class="fas fa-refresh"></i>
                                                    </a>';
                                            }else{
                                                $flag = '<a href="'.base_url().'admin/setting/refresh_mesin/'.$ip_address.'" class="badge bg-danger">
                                                Offline  &nbsp;<i class="fas fa-refresh"></i>
                                                </a>';

                                                 $class="btn-warning";
                                            }


                                            echo '     

                                                <a href="'.base_url().'admin/setting/list_user/'.$serial_number.'"  class="'. $class.' btn text-start  mb-2 d-block" >   
                                                    <div style="font-size:14px">
                                                        <strong>'.$mesin_absensi[$i]->nama_mesin.' <br>'.$mesin_absensi[$i]->ip_address.'</strong>  <i class="mdi mdi-arrow-right"></i>
                                                    </div>
                                                </a>
                                               ';

                                        }


                                        ?>
                                        <!-- end div-->
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xxl-9 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>List User</h4>
                                        <br>

                                        <button type="button" class="btn btn-primary mb-2 float-end" data-bs-toggle="modal" data-bs-target="#standard-modal">Add New User</button>
                                          
                                        <div class="clearfix"></div>
                                          <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                  <div class="modal-dialog">
                                                      <div class="modal-content">
                                                          <form action="<?php echo base_url();?>admin/mesin/insert_user/<?php echo $this->uri->segment(4).'/'.$detail_mesin[0]->ip_address;?>" method="post">
                                                              <div class="modal-header">
                                                                  <h4 class="modal-title" id="standard-modalLabel">Add New User</h4>
                                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                              </div>
                                                              <div class="modal-body">
                                                           
                                                                   
                                                                      <div class="mb-3">
                                                                            <label for="userId" class="inline-block mb-2 text-base font-medium">PIN / ID</label>
                                                                            <input type="text" id="userId" name="pin" class="form-control"  required="">
                                                                        </div>
                                                                    
                                                                        <div class="mb-3">
                                                                            <label for="userNameInput" class="inline-block mb-2 text-base font-medium">Nama</label>
                                                                            <input type="text" id="userNameInput" name="nama" class="form-control" placeholder="Enter name" required="">
                                                                        </div>
            
                                                                  
                                                              
  
                                                              </div>
                                                              <div class="modal-footer">
                                                                  <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                                  <button type="submit" class="btn btn-primary">Save changes</button>
                                                              </div>
  
                                                          </form>
  
                                                      </div><!-- /.modal-content -->
                                                  </div><!-- /.modal-dialog -->
                                              </div><!-- /.modal -->

                                              

                                     <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>PIN</th>
                                                    <th>Nama</th>
                                                    <th>Action</th>
                                                   
                                                </tr>
                                            </thead>


                                            <tbody>

                                                <?php
                                                    for ($i=0; $i < count($list_user) ; $i++) { 
                                                        $pin = $list_user[$i]['pin'];
                                                        $nama = $list_user[$i]['nama'];

                                                        $nama_url = url_title($nama);

                                                        if ($pin !='') {
                                                            echo ' <tr>
                                                            <td>'.($i+1).'</td>
                                                            <td>'. $pin .'</td>
                                                            <td class="text-start">'. $nama .'</td>
                                                            <td  class="text-center">
                                                             <a href="'.base_url().'admin/mesin/detail_user/'.$pin.'/'.$nama_url.'/'.$detail_mesin[0]->ip_address.'/'.$detail_mesin[0]->serial_number.'" class="btn btn-info btn-sm"> <i class="mdi mdi-eye"></i></a>
                                                             <a href="#" class="btn btn-success btn-sm"> <i class="mdi mdi-pencil"></i></a>
                                                            
                                                             <a href="'.base_url().'admin/mesin/delete_user/'.$pin.'/'.$detail_mesin[0]->serial_number.'/'.$detail_mesin[0]->ip_address.'" class="btn btn-danger btn-sm" onClick="return confirm(\'Hapus User ini?\');">
                                                              <i class="mdi mdi-trash-can-outline"></i></a>
                                                            </td>
                                                          
                                                        </tr>';
                                                        }
                                                        
                                                    }
                                                
                                                ?>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col-->
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

                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>

        <!-- Datatable Init js -->
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.datatable-init.js"></script>

    </body>

    <?php
    if($message !=''){
    ?>
    <script>$.NotificationApp.send("Berhasil","<?php echo $message;?>","top-right","rgba(0,0,0,0.2)","success")</script>

    <?php } ?>
</html>
