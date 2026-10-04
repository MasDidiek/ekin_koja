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

                                 

                                  
                                   $id_pegawai = $this->session->userdata('id_pegawai');
                                   
                                   $nama_user =  $this->session->userdata('nama');
                                   $nip_user =  $this->session->userdata('nip');
                                   $id_pegawai =  $this->session->userdata('id_pegawai');
                                   $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);


                                   $pin 	= substr($nip_user, -4);

                              
                                   $jabatan =  $detail_pegawai[0]->jabatan;
                                   $puskesmas =  $detail_pegawai[0]->puskesmas;
                                   $id_pendidikan =  $detail_pegawai[0]->id_pendidikan;
                               
                                   $pengkalian =  $detail_pegawai[0]->pengkalian;

                                   $tmt =  $detail_pegawai[0]->tmt;

                                   $pendidikan = $this->Master_model->getNamaPendidikan($id_pendidikan);

                                   $today = new DateTime('2025-01-31');

                               
                                //print_array($thr);
                                   $diff = $today->diff(new DateTime($tmt));
                                   $masa_kerja = $diff->y.' tahun '.$diff->m.' bulan &nbsp; '.$diff->d.' hari';

                                 //  echo $masa_kerja;

                            
                                 if(!empty($thr)){
                                    $periode = $thr[0]->periode;
                                   
                                    $nama_pegawai = $thr[0]->nama;
                                    $npwp = $thr[0]->npwp;
                                    $total = $thr[0]->total;
                                    $gaji_pokok = $thr[0]->gaji_pokok;
                                    $tunj_suami = $thr[0]->tunj_suami;
                                    $status_kawin = $thr[0]->status_kawin;
                                    $tunj_anak1 = $thr[0]->tunj_anak1;
                                    $tunj_anak2 = $thr[0]->tunj_anak2;
                                    $thr_gaji = $thr[0]->thr_gaji;
                                    $thr_tkd = $thr[0]->thr_tkd;
                                    $tmt = $thr[0]->tmt;
                                    $no_rekening = $thr[0]->no_rekening;
                                    $ttd_spj = $thr[0]->ttd_spj;
                                    $ttd_on = $thr[0]->date_ttd;
                                 }else{
                                    $periode = '';
                                   
                                    $nama_pegawai = '';
                                    $npwp = '';
                                    $total = 0;
                                    $gaji_pokok = 0;
                                    $tunj_suami = 0;
                                    $status_kawin = 0;
                                    $tunj_anak1 = 0;
                                    $tunj_anak2 = 0;
                                    $tmt ='';
                                    $no_rekening = '';
                                    $ttd_spj = '';
                                    $ttd_on = '';
                                    $thr_gaji = 0;
                                    $thr_tkd = 0;

                                 }

                                   




                                    $tkd_pokok = $gaji_pokok*$pengkalian;

                                    $format_periode = date('F Y', strtotime($periode));
                                  


                                    if($ttd_spj==''){
                                        $btn_ttd = '<button type="button" class="btn btn-info btn-sm ttd_spj"  data-bs-toggle="modal" data-bs-target="#modal-ttd-spj" > Tandatangani SPJ THR</button>';
                                    }else{
                                        $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="200">  <br> <br>
                                        <p>Sign On : <em> '. format_view($ttd_on) .'  &nbsp; '. date('H:i', strtotime($ttd_on)) .'</em></p>';
                                    }
                                  
                                    
                               ?>



                      
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                       
                                        <h4 class="header-title">Detail Informasi Tunjangan Hari Raya</h4><br><br>

                                        <div class="row">
                                                <div class="col-7">
                                                    <table class="my-table">
                                                    <tr>
                                                        <td width="150">Nama</td>
                                                        <td><strong><?php echo  $nama_pegawai ;?> </strong> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Jabatan</td>
                                                        <td><strong><?php echo $jabatan;?> </strong> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tanggal Masuk</td>
                                                        <td><strong><?php echo $tmt; ?></strong> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Masa Kerja</td>
                                                        <td><strong><?php echo $masa_kerja;?></strong>
                                                        <!-- ( <span class="fs-5" style="font-style:italic">pertanggal 31 Januari 2025</span> ) </td> -->
                                                    </tr>
                                                </table>
                                                </div>

                                                <div class="col-5">
                                                    <table class="my-table">
                                                    <tr>
                                                        <td width="150">Pendidikan</td>
                                                        <td class="text-end"><strong><?php echo $pendidikan;?></strong> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Gaji Pokok</td>
                                                        <td class="text-end"><strong>Rp. <?php echo rupiah($gaji_pokok);?> </strong> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pengali</td>
                                                        <td class="text-end"><strong><?php echo $pengkalian;?>x </strong> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>TKD Pokok</td>
                                                        <td class="text-end"> <strong>Rp. <?php echo rupiah($tkd_pokok);?> </strong> </td>
                                                    </tr>
                                                </table>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row mt-2">

                                                <div class="col-xl-6">
                                                 <table class="table fs-5">
                                                        <tr>
                                                            <td>Gaji Pokok Perbulan</td>
                                                            <td>:</td>
                                                            <td class="text-end"><strong><?php echo rupiah($gaji_pokok);?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tunjangan Suami / Istri</td>
                                                            <td>:</td>
                                                            <td class="text-end"><strong><?php echo rupiah($tunj_suami);?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tunjangan Anak Ke - 1 </td>
                                                            <td>:</td>
                                                            <td class="text-end"><strong><?php echo rupiah($tunj_anak1);?></strong></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Tunjangan Anak Ke - 2</td>
                                                            <td>:</td>
                                                            <td class="text-end"><strong><?php echo rupiah($tunj_anak2);?></strong></td>
                                                        </tr>
                                                        <tr class=" fs-4 text-primary">
                                                            <td>Jumlah THR Komponen Gaji</td>
                                                            <td>:</td>
                                                            <td class="text-end"><strong><?php echo rupiah($thr_gaji);?></strong></td>
                                                        </tr>

                                                         
                                                       <tr class=" fs-4 text-info">
                                                           <td>Jumlah THR Komponen TKD</td>
                                                           <td>:</td>
                                                           <td class="text-end"><strong><?php echo rupiah($thr_tkd);?></strong></td>
                                                       </tr>

                                                              
                                                       <tr>
                                                           <td colspan="3">&nbsp;</td>
                                                        
                                                       </tr>
                                                       <tr class=" fs-4 text-success">
                                                           <td>Jumlah THR Total</td>
                                                           <td>:</td>
                                                           <td class="text-end"><strong><?php echo rupiah($total);?></strong></td>
                                                       </tr>
                                                    </table>
                                                    
                                                </div>
                                                <div class="col-xl-6">
                                                    <table class="table fs-5">
                                                        
                                                   </table>
                                                </div>


                                                    
                                            </div>

                                     
                                           
                                            <div class="row text-center mt-2 p-4" >
                                                <div class="col-md-4 mb-3">
NPWP  
                                                                    <br>
                                                                    <strong><?php echo $npwp;?></strong>
                                                                

                                                </div>
                                                <div class="col-md-4 mb-3">
                                                No Rekening
                                                                <br>
                                                                <strong><?php echo $no_rekening;?></strong>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                Tanda Tangan  <br>
                                                                    <br>
                                                                    <?php echo $btn_ttd;?>
                                                </div>
                                            </div>
                                        

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>

                            
                            
                            <div class="modal fade" id="modal-ttd-spj" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Tanda tangan SPJ THR</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                             <form method="post" action="<?php echo base_url();?>profile/insert_tdd_spj_thr" enctype="multipart/form-data">
                                                Periode TKD :  <input type="text" name="periode" readonly class="form-control"  value="<?php echo $format_periode;?>" id="periode">
                                                <br>
                                                    No HP :  <input type="text" name="no_hp" required class="form-control" placeholder="masukkan no telepon / hanphonde">
                                                <br><br>


                                                    <div class="flex flex-wrap gap-2">
                                                        
                                                            <div id="signature-pad">
                                                                <div style="border:solid 1px teal; width:400px;height:150px;padding:3px;position:relative;">
                                                                    <div id="note" onmouseover="my_function();">Tanda tangan harus di dalam kotak</div>
                                                                    <canvas id="the_canvas" width="350px" height="100px"></canvas>
                                                                </div>

                                                                <div style="margin:10px;">
                                                                    <input type="hidden" id="id_spj" name="id_spj" value="<?php echo $thr[0]->id;?>">
                                                                    <input type="hidden" id="signature" name="signature">
                                                                    <button type="button" id="clear_btn" class="btn btn-danger" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                                                                    <button type="submit" id="save_btn" class="btn btn-primary" data-action="save-png"><span class="glyphicon glyphicon-ok"></span> Submit</button>
                                                                </div>
                                                            </div>
                                                        <form>
                                                        
                                                    </div>
                                                
                                                <br>
                                              
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

        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

    

        <script>
        var message = '<?php echo $message;?>';

        if(message != ''){
            $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
        }


                
var wrapper = document.getElementById("signature-pad");
                var clearButton = wrapper.querySelector("[data-action=clear]");
                var savePNGButton = wrapper.querySelector("[data-action=save-png]");
                var canvas = wrapper.querySelector("canvas");
                var el_note = document.getElementById("note");
                var signaturePad;
                signaturePad = new SignaturePad(canvas);
                clearButton.addEventListener("click", function (event) {
                document.getElementById("note").innerHTML="The signature should be inside box";
                signaturePad.clear();
                });
                savePNGButton.addEventListener("click", function (event){
                if (signaturePad.isEmpty()){
                    alert("Please provide signature first.");
                    event.preventDefault();
                }else{
                    var canvas  = document.getElementById("the_canvas");
                    var dataUrl = canvas.toDataURL();
                    document.getElementById("signature").value = dataUrl;
                }
                });
                function my_function(){
                document.getElementById("note").innerHTML="";
                }

            </script>

    </body>
</html>
