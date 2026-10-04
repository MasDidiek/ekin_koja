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
                                   
                                    $url_name =  $this->uri->segment(5);
                                    $ip_address = $this->uri->segment(6);
                                    $pin =  $detail_user[0]['pin'];

                                    $uri = $pin.'/'.$url_name.'/'.$ip_address;
                                ?>

                        <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                      
                                        <div class="row">
                                             <div class="col-md-3">
                                                <div style="font-size:80px">
                                                    <i class="mdi mdi-account-box"></i>
                                                </div>
                                            </div>
                                             <div class="col-md-6"> 
                                                <br>
                                                <h4 class="mb-1"><?php echo  $detail_user[0]['nama'] ;?></h4>
                                                <p class="font-13"> <?php echo $detail_user[0]['pin'];?></p>
                                               
                                             </div>

                                             <hr>

                                             <h4>Data Absensi</h4>
                                             <div class="col-md-12 " data-simplebar="" style="max-height: 500px;"> 

                                              
                                                <table class="table table-sm table-striped">
                                                    <tr>
                                                        <th>PIN</th>
                                                        <th>DateTime</th>
                                                        <th>status</th>
                                                    </tr>
                                                    <?php
                                                    rsort($absensi);
                                                    for ($a=0; $a < count($absensi) ; $a++) { 
                                                        echo ' <tr>
                                                                    <td>'.$absensi[$a]['pin'].'</td>
                                                                   <td>'.$absensi[$a]['DateTime'].'</td>
                                                                    <td>'.$absensi[$a]['Status'].'</td>
                                                                </tr>';
                                                    }
                                                    ?>
                                                   
                                                </table>
                                             </div>
                                        
                                           
                                            
                                        </div>
                                        <!-- end div-->
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xxl-8 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Sidik Jari User</h4>
                                        <br>


                                        <a href="<?php echo base_url();?>admin/setting/list_user/<?php echo $this->uri->segment(7);?>" class="btn btn-danger  mb-2">Kembali</a>
                                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#standard-modal">Add Sidik Jari</button>
                                          
                                        <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="<?php echo base_url();?>admin/mesin/insertSidikJari/<?php echo $this->uri->segment(5);?>" method="post">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">Add Sidik Jari</h4>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                         
                                                                    <input type="hidden" name="ip_address" value="<?php echo $this->uri->segment(6);?>">
                                                                

                                                                    <div>
                                                                        <label for="pin" class="inline-block mb-2 text-base font-medium">PIN / ID</label>
                                                                        <input type="text" id="pin"  name="pin"   style="width: 100px;"  value="<?php echo $this->uri->segment(4);?>" class="form-control">
                                                                    </div>

                                                                    
                                                                    <div class="mt-2">
                                                                        <label for="FingerID" class="inline-block mb-2 text-base font-medium">Finger ID</label>
                                                                        <input type="number" id="FingerID"  name="FingerID"  style="width: 100px;" value="1" class="form-control">
                                                                    </div>
                                                                    <div class="mt-2 mb-4">
                                                                        <label for="textArea" class="inline-block mb-2 text-base font-medium">Template</label>
                                                                        <textarea name="template" class="form-control" id="textArea" rows="8"></textarea>
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


                                        <?php

                                                for ($i=0; $i < count($sidik_jari) ; $i++) { 
                                                    $FingerID = $sidik_jari[$i]['FingerID'];
                                                    $Template = $sidik_jari[$i]['Template'];
                                                  

                                                    echo '<div class="border p-3 mb-2">
                                                            <div>
                                                              <table>
                                                                <tr>
                                                                    <td>Finger ID : </td>
                                                                    <td><strong>'.$FingerID .'</strong></td>
                                                                </tr>
                                                              </table>
                                                            </div>
                                                            <br>
                                                            <span style="font-size:12px"> '.$Template.'</span>
                                                          </div>';
                                                }
                                        ?>
                                     

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


        <?php
    if($message !=''){
    ?>
    <script>$.NotificationApp.send("Berhasil","<?php echo $message;?>","top-right","rgba(0,0,0,0.2)","success")</script>

    <?php } ?>
    </body>
</html>
