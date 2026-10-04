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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Data Listing</a></li>
                                             <li class="breadcrumb-item"><a href="javascript: void(0);">Data Listing TKD</a></li>
                                              <li class="breadcrumb-item active">Detail TKD</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Data TKD Pegawi</h4>
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



                                //    $id_pegawai = $this->session->userdata('id_pegawai');

                                //    $nama_user =  $this->session->userdata('nama');
                                //    $nip_user =  $this->session->userdata('nip');
                                //    $id_pegawai =  $this->session->userdata('id_pegawai');
                                //    $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);




                                   //$pin 	= substr($nip_user, -4);

                                   $id_listing_tkd = $detail_tkd[0]->id;
                                   $periode = $detail_tkd[0]->periode;

                                   $nama_pegawai = $detail_tkd[0]->nama;
                                   $npwp = $detail_tkd[0]->npwp;
                                   $capaian = $detail_tkd[0]->capaian;
                                   $tkd_pokok = $detail_tkd[0]->tkd_pokok;
                                   $bruto = $detail_tkd[0]->bruto;
                                   $pph21 = $detail_tkd[0]->pph21;
                                   $bpjs = $detail_tkd[0]->bpjs;
                                   $bpjs_tk = $detail_tkd[0]->bpjs_tk;
                                   $thp = $detail_tkd[0]->thp;
                                   $no_rekening = $detail_tkd[0]->no_rekening;
                                   $ttd_spj = $detail_tkd[0]->ttd_spj;
                                   $ttd_on = $detail_tkd[0]->ttd_on;
                                   $masa_kerja = $detail_tkd[0]->masa_kerja;

                                   $explod_masa_kerja = explode(" ", $masa_kerja);

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
                                    $status = $detail_tkd[0]->status;

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
                                            <p>Sign On : <em> '. format_view($ttd_on) .'  &nbsp; '. date('H:i', strtotime($ttd_on)) .'</em></p>
                                            
                                            <a href="'.base_url().'admin/listing_tkd/delete_ttd/'.$id_listing_tkd.'">Delete</a>';
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
                                         <h4>Profile Pegawai</h4>

                                         <table class="my-table">
                                            <tr>
                                                <td width="150">Nama</td>
                                                <td><strong><?php echo  $nama_pegawai ;?> </strong> </td>
                                            </tr>
                                            <tr>
                                                <td>Jabatan</td>
                                                <td><strong><?php echo $detail_tkd[0]->jabatan;?> </strong> </td>
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

                                        <hr>
                                         <a href="<?php echo base_url();?>admin/listing_tkd/index" class="btn btn-light btn-sm">
                                                <i class="mdi mdi-arrow-left"></i> Kembali
                                             </a>
                                            
                                        <div class="text-center">

                                                    <button type="button"
                                                            class="btn btn-danger btn-sm btn-input-tkd"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalTkd"
                                                            data-type="potongan"
                                                            data-title="Input Pemotongan Tunjangan"
                                                            data-action="<?= base_url('admin/listing_tkd/insert_transaksi'); ?>">
                                                        + Input Potongan
                                                    </button>

                                                    <button type="button"
                                                            class="btn btn-success btn-sm btn-input-tkd"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#modalTkd"
                                                            data-type="penambahan"
                                                            data-title="Input Penambahan Tunjangan"
                                                            data-action="<?= base_url('admin/listing_tkd/insert_transaksi'); ?>">
                                                        + Input Penambahan
                                                    </button>
                                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                 <i class="mdi mdi-pencil"></i> Edit Data TKD
                                            </button>
                                        </div>
                                          

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
                                                <li>  Bruto (TKD Pokok x Capaian ) :  <span class="float-end fw-bold">Rp. <?php echo rupiah($bruto);?></span> </li>
                                            </ul>
                                           <br>

                                          <i class="mdi mdi-arrow-right"> </i> Potongan
                                          <ul>
                                                <li>Pajak PPh21  <span class="float-end fw-bold">Rp. <?php echo rupiah($pph21);?></span></li>
                                                <li>BPJS  <span class="float-end fw-bold">Rp. <?php echo rupiah($bpjs);?></span></li>
                                                <li>BPJS TK  <span class="float-end fw-bold">Rp. <?php echo rupiah($bpjs_tk);?></span></li>
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
                                             <br>
                                          </div>
                                </div>
                            </div>



                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                            <div class="row text-center mt-2 p-4" >
                                                <div class="col-md-4 mb-3">
                                                        NPWP <br>  <strong><?php echo $npwp;?></strong>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                No Rekening  <br> <strong><?php echo $no_rekening;?></strong>
                                                </div>
                                                <div class="col-md-4 mb-3">
                                                  Tanda Tangan  <br> <br>  <?php echo $btn_ttd;?>
                                              </div>
                                            </div>

                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>


                             <div class="modal fade" id="modalTkd" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalTitle"></h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <form id="formTkd" method="post">
                                               
                                                <div class="modal-body">

                                                    <input type="hidden" name="id_rekap_tkd" value="<?= $id_listing_tkd; ?>">
                                                     <input type="hidden" name="jenis_transaksi" id="tipe">
                                                  

                                                    <div class="mb-3">
                                                        <label class="form-label" id="labelJumlah"></label>
                                                        <input type="number" class="form-control" name="jumlah" value="0" required>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">Keterangan</label>
                                                        <textarea class="form-control" name="keterangan" rows="3"></textarea>
                                                    </div>

                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                </div>


                               <!-- Modal Pemotongan Tunjangan -->
                                <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                        
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalPemotonganLabel">Ubah Data Tunjangan</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <form id="formPemotongan" action="<?php echo base_url();?>admin/listing_tkd/update_data_tkd" method="post">
                                            <div class="modal-body">
                                            <!-- Hidden id_rekap_tkd -->
                                            <input type="hidden" name="id_rekap_tkd" id="id_rekap_tkd" value="<?php echo $id_listing_tkd;?>">

                                            <div class="row">
                                                <div class="col-md-8">
                                                     <div class="mb-3">
                                                        <label for="jumlah" class="form-label">TKD Pokok</label>
                                                        <input type="number" class="form-control" value="<?php echo $tkd_pokok;?>" id="tkd_pokok" name="tkd_pokok" required>
                                                    </div>
                                                </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                        <label for="jumlah" class="form-label">Capaian</label>
                                                        <input type="text" class="form-control" id="capaian" value="<?php echo $capaian;?>" name="capaian" required>
                                                    </div>
                                                 </div>
                                            </div>
                                             <div class="row">
                                                <div class="col-md-4">
                                                     <div class="mb-3">
                                                        <label for="jumlah" class="form-label">Pajak</label>
                                                        <input type="number" class="form-control" id="pajak" value="<?php echo $pph21;?>" name="pajak" required>
                                                    </div>
                                                </div>
                                                 <div class="col-md-4">
                                                     <div class="mb-3">
                                                        <label for="jumlah" class="form-label">BPJS</label>
                                                        <input type="text" class="form-control" id="bpjs" name="bpjs" value="<?php echo $bpjs;?>" required>
                                                    </div>
                                                 </div>
                                                  <div class="col-md-4">
                                                     <div class="mb-3">
                                                        <label for="jumlah" class="form-label">BPJS TK</label>
                                                        <input type="text" class="form-control" id="bpjs_tk" name="bpjs_tk" value="<?php echo $bpjs_tk;?>" required>
                                                    </div>
                                                 </div>
                                            </div>
                                            <!-- Jumlah -->
                                           

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>

                                        </div>
                                    </div>
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
                                                                    <input type="hidden" id="id_spj" name="id_spj" value="<?php echo $detail_tkd[0]->id;?>">
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

        
            document.querySelectorAll('.btn-input-tkd').forEach(button => {
                button.addEventListener('click', function () {

                    const title  = this.dataset.title;
                    const action = this.dataset.action;
                    const type   = this.dataset.type;

                    document.getElementById('modalTitle').innerText = title;
                    document.getElementById('formTkd').action = action;
                    document.getElementById('tipe').value = type;
                    
                    document.getElementById('labelJumlah').innerText =
                        type === 'potongan'
                        ? 'Jumlah Pemotongan'
                        : 'Jumlah Penambahan';
                });
            });
            </script>



    </body>
</html>
