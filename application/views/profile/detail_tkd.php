<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/circle.css">
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/signature.js"></script>

    <style>
        .my-table{
            width: 100%;
        }
        .my-table  td{
            padding:5px;
            font-size: 16px;

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
                                     $nip = $this->session->userdata('nip');


                                    $bulan = $periode_bulan;
                                    $tahun = $this->uri->segment(4);


                                   //$pin 	= substr($nip_user, -4);

                                   $id_listing_tkd = $detail_tkd->id;
                                   $periode = $detail_tkd->periode;

                                   $nama_pegawai = $detail_tkd->nama;
                                  
                                   
                                   $tkd_pokok = $detail_tkd->tkd_pokok;
                                   $bruto = $detail_tkd->bruto;
                                   $pph21 = $detail_tkd->pph21;
                                   $bpjs = $detail_tkd->bpjs;
                                  
                                   $thp = $detail_tkd->thp;
                                  
                                   $ttd_spj = $detail_tkd->ttd_spj;
                                   $ttd_on = $detail_tkd->ttd_on;
                                   $masa_kerja = $detail_tkd->masa_kerja;

                                   $explod_masa_kerja = explode(" ", $masa_kerja);

                                   $jns_pegawai =  $this->session->userdata('jns_pegawai');
                                   if($jns_pegawai=='non_pns' || $tahun <= 2025){

                                        $bpjs_tk     = $detail_tkd->bpjs_tk;
                                        $no_rekening = $detail_tkd->no_rekening;
                                        $npwp = $detail_tkd->npwp;
                                        $capaian = $detail_tkd->capaian;
                                        $titleBPJS = 'BPJS TK';
                                        $infoBruto = '(TKD Pokok x Capaian )';
                                   }else{
                                        $bpjs_tk     = $detail_tkd->tht;
                                        $no_rekening = 0;
                                        $npwp =  0;
                                        $capaian = 0;
                                        $titleBPJS = 'Tunjangan Hari Tua (THT)';
                                        $infoBruto = '(TKD Pokok - Potongan Absensi )';


                                        $dataDetail = $this->Laporan_model->getDetailPegawaiByNIP($nip);
                                         $no_rekening = $dataDetail->no_rekening;
                                        $npwp = $dataDetail->npwp;
                                        //print_array($dataDetail);
                                  
                                   }

                                  

                                   //print_array($explod_masa_kerja);
                                   $mk_tahun = $explod_masa_kerja[0]; //masa kerja tahun
                                   $mk_bulan = @$explod_masa_kerja[2]; //masa kerja tahun

                                   $detail_pegawai = $this->Pegawai_model->getPegawaiByNama($nama_pegawai);
                                   $nip =  $detail_pegawai[0]->nip;
                                   $nama =  $detail_pegawai[0]->nama;
                                   $id_pegawai =  $detail_pegawai[0]->id_pegawai;


                                   $id_pendidikan =  $detail_pegawai[0]->id_pendidikan;

                                   $tmt =  $detail_pegawai[0]->tmt;
                                 
                                   //print_array($detail_pegawai);


                                   $pendidikan = $this->Master_model->getNamaPendidikan($id_pendidikan);

                                   $data_gaji = $this->Pegawai_model->getDataGajiPegawai($nip,2025);
                                   if(!empty($data_gaji)){
                                       $gaji_pokok = $data_gaji[0]->gaji_pokok;
                                       $pengkalian = $data_gaji[0]->pengali;
                                   }else{
                                       $gaji_pokok =0;
                                       $pengkalian =0;
                                   }






                                   $today = new DateTime('2025-04-30');

                                    $format_periode = date('F Y', strtotime($periode));
                                    $status = $detail_tkd->status;

                                    if($status==0){
                                        $btn_ttd = '';
                                    }else{

                                        if($ttd_spj==''){
                                            if($thp==0){
                                                     $btn_ttd = '<div class="alert alert-info">SPJ TKD bulan ini belum dapat ditandatangani, menunggu admin update data</div>';
                                            }else{
 $btn_ttd = '<button type="button" class="btn btn-info btn-sm ttd_spj"  data-bs-toggle="modal" data-bs-target="#modal-ttd-spj" > Tandatangani SPJ TKD</button>';
                                            }
                                           
                                        }else{
                                            $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="200">  <br> <br>
                                            <p>Sign On : <em> '. format_view($ttd_on) .'  &nbsp; '. date('H:i', strtotime($ttd_on)) .'</em></p>';
                                        }

                                    }

                                   
                                        $penambah = 0;
                                        $pengurang = 0;

                                        $keterangan_tambahan = [];
                                        $keterangan_potongan = [];

                                        foreach ($transaksi as $row) {

                                            if ($row->jenis_transaksi == 'penambahan') {
                                                $penambah += $row->jumlah;
                                                $keterangan_tambahan[] = $row->keterangan;
                                            }

                                            if ($row->jenis_transaksi == 'pemotongan') {
                                                $pengurang += $row->jumlah;
                                                $keterangan_potongan[] = $row->keterangan;
                                            }
                                        }

                                        $thp = $thp + $penambah - $pengurang;

                                        $keterangan_tambahan = implode(', ', array_filter($keterangan_tambahan));
                                        $keterangan_potongan = implode(', ', array_filter($keterangan_potongan));


                                    if($mk_tahun==0 && $mk_bulan < 4){
                                        $keterangan2 = 'Masa kerja <= 3 bulan ';
                                       
                                    }


                               ?>




                        <div class="row">

                            <div class="col-xl-7 col-lg-7">
                                <div class="card">
                                    <div class="card-body">
                                         <h3>Profile Pegawai</h3>

                                         <table class="my-table">
                                            <tr>
                                                <td width="150">Nama</td>
                                                <td><strong><?php echo  $nama_pegawai ;?> </strong> </td>
                                            </tr>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td><strong><?php echo $detail_tkd->jabatan;?> </strong> </td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Masuk</td>
                                                <td><strong><?php echo format_full($tmt);?></strong> </td>
                                            </tr>
                                            <tr>
                                                <td>Masa Kerja</td>
                                                <td><strong><?php echo $masa_kerja;?></strong>
                                                </td>
                                            </tr>

                                            <tr>
                                            <td width="150">Pendidikan</td>
                                            <td><strong><?php echo $pendidikan;?></strong> </td>
                                            </tr>
                                            <tr>
                                                <td>Gaji Pokok</td>
                                                <td><strong>Rp. <?php echo rupiah($gaji_pokok);?> </strong> </td>
                                            </tr>
                                            <tr>
                                                <td>Pengali</td>
                                                <td><strong><?php echo $pengkalian;?>x </strong> </td>
                                            </tr>
                                            <tr>
                                                <td>TKD Pokok</td>
                                                <td> <strong>Rp. <?php echo rupiah($tkd_pokok);?> </strong> </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-5 col-lg-5">
                                <div class="card">
                                <h4 class="header-title p-2">Tunjangan Kinerja</h4>

                                    <div class="card-body text-center fw-bold">

                                            <div class=" p-2">
                                                <div class="fs-1">  <span><?php echo $capaian;?>%</span> </div>
                                                <div class="fs-4 fw-bold">Capaian Kinerja</div>
                                              </div>
                                              <hr>

                                            <h3 class="fw-bold mt-3">
                                                <span class="text-success">Rp. <?php echo rupiah($thp);?></span>
                                            </h3>

                                            <div class=" fs-4 fw-bold">Total Penerimaan</div>

                                    </div>

                                         <div class="card-body border-top p-2">
                                           <h5>Perhitungan Tunjangan Kinerja</h5>
                                             <br>
                                             <i class="mdi mdi-arrow-right"> </i> Pokok  :
                                            <ul>
                                                <li> TKD Pokok :  <span class="float-end fw-bold">Rp. <?php echo rupiah($tkd_pokok);?></span></li>
                                                <li>  Bruto <?= $infoBruto; ?> :  <span class="float-end fw-bold">Rp. <?php echo rupiah($bruto);?></span> </li>
                                            </ul>
                                           <br>

                                          <i class="mdi mdi-arrow-right"> </i> Potongan
                                          <ul>
                                                <li>Pajak PPh21  <span class="float-end fw-bold">Rp. <?php echo rupiah($pph21);?></span></li>
                                                <li>BPJS  <span class="float-end fw-bold">Rp. <?php echo rupiah($bpjs);?></span></li>
                                                <li><?= $titleBPJS ?>  <span class="float-end fw-bold">Rp. <?php echo rupiah($bpjs_tk);?></span></li>
                                          </ul>


                                          <i class="mdi mdi-arrow-right"> </i> Lain  - lain
                                           <ul>
                                                <li>Penambahan   <i> <span class="text-primary"><?php echo  $keterangan_tambahan;?>  </span>  </i>  <span class="float-end fw-bold">Rp. <?php echo rupiah($penambah);?></span>

                                            </li>
                                                <li>Pengurang  <i>  <br><span class="text-primary"><?php echo  $keterangan_potongan;?>  </span>  </i>  <span class="float-end fw-bold text-danger">  Rp. <?php echo rupiah($pengurang);?></span></li>

                                          </ul>

                                          <hr>

                                          <div class=" fs-5 fw-bold">Total Penerimaan</div>
                                            <span class="fs-4 float-end fw-bold">Rp. <?php echo rupiah($thp);?></span>
                                        </div>


                                </div>
                            </div>



                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">



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
                                            <h4 class="modal-title" id="mySmallModalLabel">Tanda tangan SPJ TKD</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                             <form method="post" action="<?php echo base_url();?>profile/insert_tdd_spj" enctype="multipart/form-data">
                                                Periode TKD :  <input type="text" name="periode" readonly class="form-control"  value="<?php echo $format_periode;?>" id="periode">
                                                <br>
                                                    No HP :  <input type="text" name="no_hp" required class="form-control" placeholder="masukkan no telepon / hanphonde">
                                                <br><br>


                                                    <div class="flex flex-wrap gap-2">

                                                            <div id="signature-pad">
                                                                <div style="border:solid 1px teal; width:360px;height:110px;padding:3px;position:relative;">
                                                                    <div id="note" onmouseover="my_function();">Tanda tangan harus di dalam kotak</div>
                                                                    <canvas id="the_canvas" width="350px" height="100px"></canvas>
                                                                </div>

                                                                <div style="margin:10px;">
                                                                    <input type="hidden" id="id_spj" name="id_spj" value="<?php echo $detail_tkd->id;?>">
                                                                    <input type="hidden" id="tahun" name="tahun" value="<?php echo $tahun;?>">
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
