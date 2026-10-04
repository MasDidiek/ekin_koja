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

                                    $list_bulan = array_bulan();

                                    $periode_bulan = $this->session->userdata('periode_bulan');
                                    $periode_tahun = $this->session->userdata('periode_tahun');
                                    $id_pkm_sess   = $this->session->userdata('id_pkm');


                                    $bulan = $periode_bulan;
                                    $tahun = $periode_tahun;



                                   $id_pegawai = $this->session->userdata('id_pegawai');

                                   $nama_user =  $this->session->userdata('nama');
                                   $nip_user =  $this->session->userdata('nip');
                                   $id_pegawai =  $this->session->userdata('id_pegawai');
                                   $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);


                                   $pin 	= substr($nip_user, -4);


                                   $jabatan =  $detail_pegawai->jabatan;
                                   $puskesmas =  $detail_pegawai->puskesmas;
                                   $id_pendidikan =  $detail_pegawai->id_pendidikan;
                                  
                                   //$pengkalian =  $detail_pegawai->pengkalian;

                                   $pengkalian = '';

                                   //$tmt =  $detail_pegawai->tmt;

                                   $pendidikan = $this->Master_model->getNamaPendidikan($id_pendidikan);


                                   $tmt = $detail_gaji[0]->tmt;
                                   $periode_gaji = $detail_gaji[0]->periode;
                                   $created_date_gaji = $periode_gaji.'-01';

                                   $date_gaji = new DateTime($created_date_gaji);

                                  // print_r($today);

                                  

                              

                                   $no_hp     = $this->Laporan_model->getNoHP($nip_user);

                                   //print_array($detail_gaji);
                                   $diff = $date_gaji->diff(new DateTime($tmt));
                                   $masa_kerja = $diff->y.' tahun '.$diff->m.' bulan &nbsp; '.$diff->d.' hari';

                                 //  echo $masa_kerja;


                                    $periode = $detail_gaji[0]->periode;

                                    $nama_pegawai = $detail_gaji[0]->nama;
                                    $npwp    = $detail_gaji[0]->nik;
                                    $jabatan = $detail_gaji[0]->jabatan;
                                    $gaji_pokok = $detail_gaji[0]->gaji_pokok;
                                    $bruto = $detail_gaji[0]->bruto;
                                    $pph21 = $detail_gaji[0]->pajak;
                                    $ptkp = $detail_gaji[0]->ptkp;
                                   // $tmt = $detail_gaji[0]->tmt;
                                    $status_kawin = $detail_gaji[0]->status_kawin;
                                    $tunj_suami = $detail_gaji[0]->tunj_suami;
                                    $tunj_anak1 = $detail_gaji[0]->tunj_anak1;
                                    $tunj_anak2 = $detail_gaji[0]->tunj_anak2;
                                    $no_rekening = $detail_gaji[0]->no_rekening;
                                    $tarif_ter = $detail_gaji[0]->tarif_ter;
                                    $netto = $detail_gaji[0]->netto;
                                    $ttd_spj = $detail_gaji[0]->ttd_spj;
                                    $ttd_on = $detail_gaji[0]->date_ttd;
                                    $created_at = $detail_gaji[0]->created_at;

                                    $format_periode = date('F Y', strtotime($periode));


                                    if($ttd_spj==''){
                                        $btn_ttd = '<button type="button" class="btn btn-info btn-sm ttd_spj"  data-bs-toggle="modal" data-bs-target="#modal-ttd-spj" > Tandatangani SPJ Gaji</button>';
                                    }else{
                                        $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="200">  <br> <br>
                                        <p>Sign On : <em> '. format_view($ttd_on) .'  &nbsp; '. date('H:i', strtotime($ttd_on)) .'</em></p>';
                                    }


                               ?>




                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">Detail Informasi Tunjangan Kinerja</h4><br><br>

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
                                                        <td><strong><?php echo format_full($tmt);?></strong> </td>
                                                    </tr>
                                                    <tr>
                                                        <td>Masa Kerja</td>
                                                        <td><strong><?php echo $masa_kerja;?></strong>
                                                        ( <span class="fs-5" style="font-style:italic">pertanggal <?php echo format_full($created_date_gaji);?> </span> ) </td>
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
                                                        <td>Status Kawin</td>
                                                        <td class="text-end"><strong><?php echo $status_kawin;?></strong> </td>
                                                    </tr>
                                                     <tr>
                                                        <td>Tanggal Terbit Gaji</td>
                                                        <td class="text-end"><strong><?php echo format_full($created_at).' '.date('H:i:s', strtotime($created_at));?></strong> </td>
                                                    </tr>

                                                </table>
                                                </div>

                                            </div>

                                            <hr>

                                            <div class="row text-start mt-2">
                                                    <div class="col-md-12">
                                                         <table class="table table-borderless table-sm ">
                                                            <tr>
                                                                <td >Gaji Pokok  &nbsp; &nbsp; : </td>
                                                                <th class="text-end">Rp. <?php echo rupiah($gaji_pokok);?> </th>
                                                            </tr>
                                                            <tr>
                                                                <td>Tunjangan Suami/istri  &nbsp; &nbsp; : </td>
                                                                <th class="text-end">Rp. <?php echo rupiah($tunj_suami);?> </th>
                                                            </tr>
                                                            <tr>
                                                                <td>Tunjangan Anak ke 1  &nbsp; &nbsp; : </td>
                                                                <th class="text-end"> Rp. <?php echo rupiah($tunj_anak1);?> </th>
                                                            </tr>
                                                            <tr>
                                                                <td>Tunjangan Anak ke 2  &nbsp; &nbsp; : </td>
                                                                <th class="text-end"> Rp. <?php echo rupiah($tunj_anak2);?> </th>
                                                            </tr>


                                                         </table><hr>
                                                            <table class="table table-borderless table-sm ">
                                                                <tr>
                                                                    <td>Bruto &nbsp; &nbsp; : </td>
                                                                    <th class="text-end"> Rp. <?php echo rupiah($bruto);?> </th>
                                                                </tr>

                                                                <tr height="50">
                                                                    <td>Pajak &nbsp; &nbsp; : </td>
                                                                    <th class="text-end"> Rp. <?php echo rupiah($pph21);?> </th>
                                                                </tr>
                                                         </table>

                                                         <hr>
                                                            <table class="table table-borderless table-sm ">


                                                                <tr height="50">
                                                                    <td>Netto &nbsp; &nbsp; : </td>
                                                                    <th class="text-end"> Rp. <?php echo rupiah($netto);?> </th>
                                                                </tr>
                                                         </table>
                                                    </div>

                                            </div>



                                            <div class="row text-end mt-2 p-4">

                                                    <h1 class="fw-bold mt-3">
                                                            <span class="text-success">Rp. <?php echo rupiah($netto);?></span>
                                                            </h1>
                                                        <p class="text-muted mb-0 mb-2"> Total Penerimaan Gaji</p>
                                                    </div>
                                            </div>

                                            <div class="row text-center mt-2 p-4" >
                                                <div class="col-md-4 mb-3">
                                                    NIK
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
                                            <h4 class="modal-title" id="mySmallModalLabel">Tanda tangan SPJ Gaji</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                             <form method="post" action="<?php echo base_url();?>profile/insert_tdd_spj_gaji" enctype="multipart/form-data">
                                                Periode Gaji :  <input type="text" name="periode" readonly class="form-control"  value="<?php echo $format_periode;?>" id="periode">
                                                <br>
                                                    No HP :  <input type="text" name="no_hp" value="<?php echo $no_hp;?>" required class="form-control" placeholder="masukkan no telepon / hanphonde">
                                                <br><br>


                                                    <div class="flex flex-wrap gap-2">

                                                            <div id="signature-pad">
                                                                <div style="border:solid 1px teal; width:360px;height:110px;padding:3px;position:relative;">
                                                                    <div id="note" onmouseover="my_function();">Tanda tangan harus di dalam kotak</div>
                                                                    <canvas id="the_canvas" width="350px" height="100px"></canvas>
                                                                </div>

                                                                <div style="margin:10px;">
                                                                    <input type="hidden" id="id_spj" name="id_spj" value="<?php echo $detail_gaji[0]->id;?>">
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
