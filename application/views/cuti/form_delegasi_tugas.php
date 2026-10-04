<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/signature.js"></script>

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

                       
                        <?php
                            $message = $this->session->flashdata('message');
                           
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
                                            <li class="breadcrumb-item active">Main Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php

                                    $list_bulan = array_bulan();

                                    $periode_bulan = $this->session->userdata('periode_bulan'); 
                                    $periode_tahun = $this->session->userdata('periode_tahun'); 

                                    $status_pengajuan   = $this->session->flashdata('status');
                                    $message   = $this->session->flashdata('message');

                               
                                  
                                   $id_pegawai = $this->session->userdata('id_pegawai');
                                   
                                   $nama_user =  $this->session->userdata('nama');
                                   $nip_user =  $this->session->userdata('nip');
                                   $id_pegawai =  $this->session->userdata('id_pegawai');
                                   $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);


                                   $pin 	= substr($nip_user, -4);

                                   $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);

                                   $jabatan =  $detail_pegawai[0]->jabatan;
                                   $puskesmas =  $detail_pegawai[0]->puskesmas;


                               ?>



                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <span class="float-start m-2 me-4">
                                            <img src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photo ;?>" style="height: 100px; Width:100px" alt="" class="rounded-circle img-thumbnail">
                                        </span>
                                        <div class="">
                                            <h4 class="mt-1 mb-1"><?php echo  $nama_user ;?></h4>
                                              <p class="font-13"> <?php echo $nip_user;?></p>

                                            <strong class="font-13"> <?php echo $puskesmas;?></strong>
                                              <p class="font-13"> <?php echo $jabatan;?></p>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>

                        <?php echo $message;?>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                       
                                        <h4 class="header-title">Pengajuan Cuti</h4>
                                        <br>

                                        <?php

                                        $tgl_cuti =  $this->session->userdata('tgl_cuti');
                                        $jns_cuti =  $this->session->userdata('jns_cuti');
                                        $id_pengganti =  $this->session->userdata('id_pengganti');
                                        $alasan_cuti =  $this->session->userdata('alasan_cuti');
                                        $tlp =  $this->session->userdata('tlp');
                                        $alamat =  $this->session->userdata('alamat');

                                        $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pengganti);

                                      //  print_array($this->session->userdata);
                                                                            
                                                                    
                                        $explode      = explode("-", $tgl_cuti);
                                        $dateFrom     = $explode[0];
                                        $dateTo       = @$explode[1];
                                        //klo cuti cuma sehari
                                        if($dateTo==''){
                                            $dateTo = $dateFrom;
                                        }
                                        
                                        $dateFrom    = str_replace("/", "-", $dateFrom);
                                        $dateTo      = str_replace("/", "-", $dateTo);

                                        $start_date  = format_semi($dateFrom);
                                        $end_date    = format_semi($dateTo);

                                        $hariCuti      = $this->session->userdata('jml_hari_cuti');
                                        $arrayHariCuti = $this->session->userdata('list_hari_cuti');

                                        if ($jns_cuti==1) {
                                            # tahunan
                                            $jenis_cuti = 'Tahunan';
                                        }elseif ($jns_cuti==2) {
                                            # Cuti Bersalin
                                            $jenis_cuti = 'Bersalin';
                                        }elseif ($jns_cuti==3) {
                                            # Cuti Alasan Penting
                                            $jenis_cuti = 'Alasan Penting';
                                        }elseif ($jns_cuti==4) {
                                            # Cuti Sakit
                                            $jenis_cuti = 'Sakit';
                                        }elseif ($jns_cuti==5) {
                                            # Besar...
                                            $jenis_cuti = 'Besar';
                                        }else{
                                            #Cuti Bersalin Anak ke 3
                                            $jenis_cuti = 'Bersalin Anak ke 3';
                                        }

                                        ?>
                                      
                                        <!-- Date Range -->
                                         <div class="row">
                                            <div class="col-md-6">
                                                <table class="table table-sm table-bordered ">
                                                <tr>
                                                        <td> Jenis Cuti : </td>
                                                        <th>Cuti <?php echo $jenis_cuti;?></th>
                                                    </tr>

                                                    <tr  class="bg-light">
                                                        <th colspan="2">
                                                            Tanggal Cuti
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                       
                                                        <td> Tgl Mulai: <br> <strong> <?php echo $start_date;?></strong></td>
                                                        <td> Tgl Akhir:  <br>  <strong> <?php echo $end_date;?> </strong></td>
                                                    </tr>
                                                    <tr class="bg-light">
                                                        <td>Lama Cuti :  </td>
                                                        <th> <?php echo $hariCuti;?>  Hari </th>
                                                    </tr>
                                                    <tr>
                                                        <td> Pengganti Cuti : </td>
                                                        <th><?php echo  $detail_pegawai[0]->nama;?></th>
                                                    </tr>
                                                    <tr  class="bg-light">
                                                        <td> Alasan Cuti : </td>
                                                        <th><?php echo $alasan_cuti;?> </th>
                                                    </tr>
                                                    <tr>
                                                        <td> No Telepon : </td>
                                                        <th><?php echo $tlp;?> </th>
                                                    </tr>
                                                    <tr  class="bg-light">
                                                        <td> Alamat Selama Cuti : </td>
                                                        <th><?php echo $alamat;?> </th>
                                                    </tr>
                                                </table>


                                            </div><!--end cok md-4-->
                                            <div class="col-md-6">
                                                <h4 class="header-title">Form Delegasi Tugas</h4>
                                                   <form method="post" action="<?php echo base_url();?>cuti/simpan_pengajuan_cuti" enctype="multipart/form-data">
                                                        <label>Tugas 1 <span class="text-danger">*</span>:</label><br>
                                                        <input type="text"  name="tugas1" required  class="form-control">
                                                            
                                                        <br>
                                                        <label>Tugas 2 <span class="text-danger">*</span>:</label><br>
                                                        <input type="text"  name="tugas2" required  class="form-control" >
                                                            <br>  
                                                        <label>Tugas 3 <span class="text-danger">*</span>:</label><br>
                                                        <input type="text"  name="tugas3" required class="form-control" >
                                                        <br>
                                                        <label>Tugas 4 :</label><br>
                                                        <input type="text"  name="tugas4"  class="form-control">
                                                        
                                                    
                                                    
                                                
                                                    <center>
                                                    <button type="submit" class="btn btn-success mt-4 ms-2" id="submit_pengajuan">Kirim Pengajuan Cuti</button>
                                                    </center>
                                                
                                                    
                                                <form>
                                         </div>

                                       
                                                                    
                                                    
                                        
                                        
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

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


        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

        <script>
            var message = '<?php echo $message;?>';

            if(message != ''){
                $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
            }
          
        </script>




    </body>
</html>
