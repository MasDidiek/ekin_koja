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
                                        <h4>Data Pegawai Non PNS</h4>
                                        <br>

                                        <a href="<?php echo base_url();?>admin/pegawai/add_pegawai" class="btn btn-primary float-end">Tambah Pegawai</a>
                                        <div class="clearfix">  </div> <br>

                                        <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                                <thead class="bg-light">
                                                    <tr>

                                                        <th class="text-center"> No</th>
                                                        <th class="text-center">TMT</th>
                                                        <th class="text-center">NIP</th>
                                                        <th class="text-center">Nama Pegawai</th>

                                                        <th class="text-center">Jabatan</th>
                                                        <th class="text-center">Lokasi Kerja</th>
                                                        <th class="text-center"> Jam Kerja</th>

                                                    </tr>
                                                </thead>
                                                <tbody>


                                                <?php

                                                            $no = 1;

                                                            //print_array($pegawai);

                                                            foreach ($pegawai as $list ) {

                                                                    $id_pegawai = $list->id_pegawai;
                                                                    $nip = $list->nip;
                                                                    $nama = $list->nama;
                                                                    $tmt  = $list->tmt;
                                                                    $usergroup = $list->usergroup;
                                                                    $email = '';
                                                                    $puskesmas = $list->puskesmas;
                                                                    $jabatan = $list->jabatan;
                                                                    $jns_jam_kerja= $list->jns_jam_kerja;


                                                                    $photo = $this->Pegawai_model->getPhotoPegawai($nip);

                                                                    $tmt = $list->tmt;


                                                                    $jns_pegawai = $list->jns_pegawai;


                                                                    if($jns_jam_kerja=='non_shift'){
                                                                        $class_span = 'border bg-custom-100 border-custom-200 text-custom-500 dark:bg-custom-500/20 dark:border-custom-500/20';
                                                                        $shift = 'REGULAR';
                                                                    }else{
                                                                        $class_span = 'border bg-yellow-100 border-yellow-200 text-yellow-500 dark:bg-yellow-500/20 dark:border-yellow-500/20';
                                                                            $shift = 'SHIFT';
                                                                    }

                                                                    echo ' <tr>


                                                                                <td>'.$no.'</td>
                                                                                <td>'.date('d M, Y', strtotime($tmt)).'</td>
                                                                                <td> <a href="'.base_url().'admin/pegawai/detail_pegawai/'.$id_pegawai.'">'.$nip.'</a></td>
                                                                                <td> '.$nama.'  </td>
                                                                                <td>'.$jabatan.'</td>
                                                                                <td>'.$puskesmas.'</td>
                                                                                <td> '.$shift.'</td>

                                                                            </tr>';



                                                            $no+=1;
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
