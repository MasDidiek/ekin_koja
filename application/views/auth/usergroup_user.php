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
                                            <li class="breadcrumb-item active">Pengaturan Menu</li>
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
                            

                               ?>




                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">Usergroup User list</h4>
                                        <br>

                                        <button type="button" class="btn btn-sm btn-primary float-end"  data-bs-toggle="modal" data-bs-target="#new_menu">
                                            Add  User</button>
                                        <div class="clearfix"></div> <br>

                                        <div class="table-responsive mt-3">
                                        
                                                <table class="table  table-hover table-bordered"  id="data-table">
                                                        <thead>
                                                            <tr>
                                                            
                                                            <th class="w-1">No.</th>

                                                                <th>NIP</th>
                                                                <th>Nama</th>
                                                                <th>Jabatan</th>
                                                            
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 

                                                                $no = 1;

                                                                #print_array($pegawai);
                                                                foreach ($list_user as $peg){

                                                                    $id_pegawai = $peg->id_pegawai;
                                                                    $nip = $peg->nip;
                            
                                                                    $id_puskesmas = $peg->id_puskesmas;

                                                                  
                                                                    echo' <tr>
                                                                                <td>'.$no.' </td>
                                                                               
                                                                                <td class="text-center"> '.$peg->nip.'</td>
                                                                                <td>'.$peg->nama.'</td>
                                                                                <td class="text-center"> '.$peg->jabatan.'</td>
                                                                               
                                                                                
                                                                            </tr>';

                                                                            $no += 1;

                                                                }


                                                        ?>
                                                        

                                                        

                                                        
                                                        
                                                        </tbody>
                                                </table>
                                         
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
                                             <form method="post" action="<?php echo base_url();?>admin/auth/insert_user_usergroup" enctype="multipart/form-data">
                                             <!-- Date Range -->
                                                    <div class="mb-2">
                                                        <label class="form-label">Cari user</label>
                                                         <input type="text" class="form-control" name="keyword"  id="keyword" placeholder="cari nama pegawai" >

                                                          <select name="id_pegawai" id="list_pegawai" class="form-control"> </select>
                                                    </div>
                                                    
                                                    
                                                    <input type="hidden" name="usergroup_id" value="<?php echo $this->uri->segment(4);?>">
                                                     <div class="mb-2">
                                                        <button type="submit" class="btn btn-success">Tambahkan</button>

                                                     </div>

                                              

                                                   
                                             <form>



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

            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
 
        <!-- demo end -->

        <script>
            var message = '<?php echo $message;?>';

            if(message != ''){
                $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
            }


            $("#keyword").keydown(function(){
                let keyword = $(this).val();

                $.ajax({
                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/auth/search_pegawai",
                            data:"keyword="+keyword,
                            success:function(msg){
                          
                                $("select#list_pegawai").html(msg);
                                //console.log(msg);
                            }
                });
            });

             $('#data-table').dataTable( {
                lengthMenu: [
                    [  20, -1 ],
                    ['20', '50', '100', 'Show all' ]
                ]
            } );

        </script>




    </body>
</html>
