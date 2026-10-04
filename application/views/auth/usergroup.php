<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Usergroup</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Usergroup Setting</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php

                                    $list_bulan = array_bulan();
                                    $message = $this->session->flashdata('success');
                                    $usergroup_id = $this->session->userdata('usergroup');


                                    //print_array($this->session->userdata);
                                  

                               ?>




                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">Usergroup Setting</h4>
                                        <br>

                                        <button type="button" class="btn btn-sm btn-primary float-end"  data-bs-toggle="modal" data-bs-target="#new_menu">
                                            Add  Usergroup</button>
                                        <div class="clearfix"></div> <br>

                                        <div class="row">
                                           
                                           
                                            <?php
                                                foreach($usergroup as $ug){

                                                    $menu_access = $ug->usergroup_menu;
                                                    $explode_menu     = explode(",", $menu_access);
                                                    


                                                    echo ' <div class="col-md-4">
                                                                <div class="card p-3">
                                                                    <div class="card-title"> 
                                                                        <span class="fw-bold"> '.$ug->usergroup_name.'</span>
                                                                         <a href="'.base_url().'admin/auth/usergroup_user/'.$ug->id.'" class="btn btn-sm btn-info float-end ms-2">
                                                                                     User
                                                                                 </a>
                                                                           <button type="button" value="  '.$ug->id.'/'.$ug->usergroup_name.'" class="btn btn-sm btn-light float-end edit_useraccess"  data-bs-toggle="modal" data-bs-target="#setting_menu_access">
                                                                                 Menu Access</button>
                                                                                
                                                                            <div class="clearfix"></div>
                                                                    </div>
                                                                     <div class="card-body">
                                                                      <ul  class="list-group  ms-1">';
                                                                     for ($i=0; $i <  count($explode_menu); $i++) { 
                                                                        $MenuID = $explode_menu[$i];

                                                                        $menu_name = $this->Auth_model->getMenuName($MenuID);
                                                                        echo '<li class="list-group-item text-dark"><i class="uil-corner-down-right-alt"></i> &nbsp; '.$menu_name.'</li>';
                                                                     }
                                                                     
                                                                     echo '</ul>
                                                                     </div>
                                                                </div>

                                                               
                                                             </div>';
                                                }
                                            ?>

                                         
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>


                            <div class="modal fade" id="new_menu" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Add New Menu</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                             <form method="post" action="<?php echo base_url();?>admin/auth/insert_usergroup" enctype="multipart/form-data">
                                          
                                                    <div class="mb-2">
                                                        <label class="form-label">Usergroup Name</label>
                                                        <input type="text" class="form-control" name="usergroup_name" required >
                                                    </div>
                                                     
                                                     <div class="mb-2">
                                                        <button type="submit" class="btn btn-success">Simpan</button>

                                                     </div>
                                            </form>



                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <div class="modal fade" id="setting_menu_access" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Setting Menu Access </h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                             <form method="post" action="<?php echo base_url();?>admin/auth/insert_usergroup_menu">
                                          
                                                    <div class="mb-2">
                                                         <input type="hidden" name="id_usergroup" id="id_usergroup" value="">
                                                         <input type="text" name="usergroup_name" id="usergroup_name" value="" class="form-control" readonly><br>

                                                          <div class="flex flex-wrap gap-4">

                                                            <?php
                                                                foreach ($list_menu as $menu) {

                                                                        if ($menu->menu_level == 1) {
                                                                            echo '  <div class="flex items-center gap-2 fs-5 mb-2">
                                                                                        <input id="menu'.$menu->id_menu.'" name="id_menu[]"  value=" '.$menu->id_menu.'"  type="checkbox"> &nbsp;
                                                                                        <label for="menu'.$menu->id_menu.'" class="align-middle">
                                                                                            '.$menu->menu_name.'
                                                                                        </label>
                                                                                    </div>';
                                                                        }



                                                                }
                                                            ?>

                                                        </div>


                                                    </div>
                                                     
                                                     <div class="mb-2">
                                                        <button type="submit" class="btn btn-success">Simpan</button>
                                                    </div>
                                              </form>



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
 
        <!-- demo end -->

        <script>
            var message = '<?php echo $message;?>';

            if(message != ''){
                $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
            }

            $(document).ready(function(){

                $(".edit_useraccess").click(function(){
                    var  usergroup = $(this).val();
                    var pecah = usergroup.split("/");

                    var id = pecah[0];
                    var usergroup_name = pecah[1];

                    $("#id_usergroup").val(id);
                    $("#usergroup_name").val(usergroup_name);
                });

            });
          

        </script>




    </body>
</html>
