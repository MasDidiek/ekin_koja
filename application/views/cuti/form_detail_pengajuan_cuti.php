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
                                    <h4 class="page-title">Pengajuan Cuti</h4>
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

                                    //print_array($this->session->userdata);

                                    $tgl_mulai =  $this->session->userdata('tgl_mulai');
                                    $tgl_akhir =  $this->session->userdata('tgl_akhir');
                                    $jns_cuti =  $this->session->userdata('jns_cuti');
                                    $list_tgl_cuti =  $this->session->userdata('list_tgl_cuti');

                                    if(count($list_tgl_cuti) < 20 ){
                                        $total_hari = count($list_tgl_cuti).' Hari';    
                                    }else{
                                        $total_hari = '3 Bulan';
                                    }

                                    

                                    //print_array($this->session->userdata);

                                    $jenis_cuti = $this->Master_model->getJenisCuti($jns_cuti);

                                    $id_pengganti =  $this->session->userdata('id_pengganti');
                                    $alasan_cuti =  $this->session->userdata('alasan_cuti');
                                    $tlp =  $this->session->userdata('tlp');
                                    $alamat =  $this->session->userdata('alamat');

                                  
                                   $id_pegawai = $this->session->userdata('id_pegawai');
                                   $nama_user =  $this->session->userdata('nama');
                                   $nip_user =  $this->session->userdata('nip');
                                   $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);


                                   $pin 	= substr($nip_user, -4);

                                   $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);

                                   $jabatan   =  $detail_pegawai[0]->jabatan;
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
                                       
                                        <h4 class="header-title">Form Pengajuan Cuti</h4>
                                        <br>


                                        <form method="post" action="<?php echo base_url();?>cuti/simpan_pengajuan_cuti" enctype="multipart/form-data">
                                        <!-- Date Range -->
                                         <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-2">
                                                    <strong>Tanggal Cuti</strong>
                                                        <div class="text-muted" >
                                                            <?php echo format_hari($tgl_mulai).', '. format_semi($tgl_mulai);?> 
                                                            &nbsp; - &nbsp;
                                                            <?php echo format_hari($tgl_akhir).', '. format_semi($tgl_akhir);?>

                                                             &nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp; ( <?php echo $total_hari ;?> )
                                                         </div>

                                                </div>

                                                 <div class="mb-2">
                                                      <strong>Jenis Cuti</strong>
                                                      <div class="text-muted" > <?php echo $jenis_cuti;?> </div>
                                                    
                                                </div>

                                                
                                            </div><!--end cok md-4-->

                                         </div>
                                            <div class="row mt-2">
                                                <div class="col-md-6">
                                                   <div class="mb-2">
                                                     <strong>Pegawai Pengganti</strong>

                                                    <select id="pengganti_select" name="id_pengganti" class="form-control" required>
                                                        <option value="">Pilih Pegawai Pengganti</option>
                                                        <?php foreach ($pegawai_pengganti as $row): ?>
                                                            <option value="<?php echo $row->id_pegawai; ?>"><?php echo $row->nama; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div><!--end mb-2-->

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

                                            <div class="col-md-6">
                                              

                                              <label>Tugas 1 <span class="text-danger">*</span>:</label><br>
                                                        <input type="text"  name="tugas1" required placeholder="input delegasi tugas"  class="form-control">
                                                            
                                                        <br>
                                                        <label>Tugas 2 <span class="text-danger">*</span>:</label><br>
                                                        <input type="text"  name="tugas2" required  placeholder="input delegasi tugas" class="form-control" >
                                                            <br>  
                                                        <label>Tugas 3 <span class="text-danger">*</span>:</label><br>
                                                        <input type="text"  name="tugas3" required placeholder="input delegasi tugas" class="form-control" >
                                                        <br>
                                                        <label>Tugas 4 :</label><br>
                                                        <input type="text"  name="tugas4"  class="form-control">
                                                        
                                                    
                                                   

                                               
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
