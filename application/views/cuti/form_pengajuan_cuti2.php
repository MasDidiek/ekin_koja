<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

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

                                  
                                    $bulan = $periode_bulan;
                                    $tahun = $periode_tahun;
                                
                                    $tgl_cuti =  $this->session->userdata('tgl_cuti');
                                    $explodeTglCuti = explode("-", $tgl_cuti);
                                    $tgl_cuti_dari = $explodeTglCuti[0];    
                                    $tgl_cuti_sampai = $explodeTglCuti[1];
                                    $id_pengganti =  $this->session->userdata('id_pengganti');
                                    $alasan_cuti =  $this->session->userdata('alasan_cuti');
                                    $tlp =  $this->session->userdata('tlp');
                                    $alamat =  $this->session->userdata('alamat');

                                  
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
                                       
                                        <h4 class="header-title">Buat Pengajuan Cuti</h4>
                                        <br>


                                        <form method="post" action="<?php echo base_url();?>cuti/check_date" enctype="multipart/form-data">
                                        <!-- Date Range -->
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Tanggal Cuti</label>
                                                   
                                                   <div class="row">
                                                    <div class="col-md-6">  <input type="text" placeholder="tanggal mulai" required class="form-control date" name="tgl_cuti_dari" id="from" autocomplete="off" value="<?php echo $tgl_cuti_dari;?>"></div>
                                                    <div class="col-md-6"><input type="text" placeholder="tanggal selesai" required class="form-control date" name="tgl_cuti_sampai" id="to"  autocomplete="off" value="<?php echo $tgl_cuti_sampai;?>"></div>
                                                   </div>
                                                  
                                                    
                                                </div>

                                                 <div class="mb-2">
                                                 <label class="form-label">Jenis Cuti</label>
                                                    <select name="jns_cuti" id="jns_cuti"  class="form-control">

                                                            <?php

                                                            for ($c=0; $c < count($master_cuti); $c++) {
                                                                $id = $master_cuti[$c]->id;
                                                                $jenis_cuti = $master_cuti[$c]->jenis_cuti;

                                                                echo ' <option value="'. $id .'">'.$jenis_cuti .'</option>';

                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="mb-2">
                                                 <label class="form-label">Pengganti Cuti</label>
                                                        

                                                    <select class="form-control select2" name="id_pengganti" required autofocus data-toggle="select2">
                                                        <option>--Pilih pengganti cuti--</option>
                                                        <?php
                                                            for ($p=0; $p < count($listPegawaiPengganti) ; $p++) {
                                                            
                                                                $id_pegawai = $listPegawaiPengganti[$p]->id_pegawai;
                                                                $nama_pegawai = $listPegawaiPengganti[$p]->nama;

                                                                if ($id_pegawai==$id_pengganti) {
                                                                    $selected = 'selected';
                                                                }else{
                                                                        $selected = '';
                                                                }
                                                            
                                                                echo '<option value="'.$id_pegawai.'" '.$selected.'>'.$nama_pegawai.'</option>';
                
                
                                                            }
                                                        ?>
                                                    </select>

                                                    
                                                </div><!--end mb-2-->
                                            </div><!--end cok md-4-->
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <label class="form-label">Alasan Cuti</label>
                                                    <input type="text" id="alasan_cuti" name="alasan_cuti" placeholder="tuliskan alasan cuti" value="<?php echo $alasan_cuti;?>" class="form-control" min="10"  required autocomplete="off">
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label">No Telepon </label>
                                                    <input type="text" id="tlp" name="tlp"  class="form-control" min="10" placeholder="08xxxx" value="<?php echo $tlp;?>" required   autocomplete="off">
                                                </div>

                                                <div class="mb-2">
                                                    <label class="form-label">Alamat Selama Cuti </label>
                                                    <textarea name="alamat"  class="form-control"  min="10"><?php echo $alamat;?></textarea>
                                                </div>
                                         </div>

                                         <div class="col-md-12">
                                            <center>
                                             <button type="submit" class="btn btn-success mt-4 ms-2" id="submit_pengajuan">Kirim Pengajuan Cuti</button>
                                            </center>
                                        </div>
                                            
                                        <form>
                                                                    
                                                    
                                        
                                        
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
         <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <!-- demo end -->

        <script>
            var message = '<?php echo $message;?>';

            if(message != ''){
                $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
            }
          
        </script>


        <script>
        $( function() {
      
            from = $( "#from" )
                .datepicker({
                defaultDate: "+1w",
                changeMonth: false,
                numberOfMonths: 2,
                dateFormat: 'dd/mm/yy',
                minDate: -2
                })
                .on( "change", function() {
                    
                  to.datepicker( "option", "minDate", getDate( this )  );
                
                }),
            to = $( "#to" ).datepicker({
                defaultDate: "+1w",
                changeMonth: false,
                numberOfMonths: 2,
                dateFormat: 'dd/mm/yy',
            })
            .on( "change", function() {
                from.datepicker( "option", "maxDate", getDate( this ) );
            });
        
            function getDate( element ) {
            var date;
            try {
                date = $.datepicker.parseDate( dateFormat, element.value );
            } catch( error ) {
                date = null;
            }
        
            return date;
            }
        } );
        </script>



    </body>
</html>
