<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view("layout/section/header"); ?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">



    <style>

         

        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .inputfile + label {
                font-weight: 700;
                color: #fff;
                background-color: #3095b2;
                border-color: #2e8ca7;
                border-radius:5px;
                display: inline-block;
                cursor: pointer;
                padding: .45rem .9rem;
                font-size: .9rem;
                transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out,-webkit-box-shadow .15s ease-in-out;
            }

            .inputfile:focus + label,
            .inputfile + label:hover {
                background-color:rgb(21, 124, 152);
            }

            #preview{
                width: 100%;
                height:auto;
            }

            #preview img{
                width: 100%;
                height:auto;
            }




    </style>


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view("layout/section/sidebar"); ?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view("layout/section/topbar"); ?>

                    <!-- Start Content-->
                    <div class="container-fluid">


                        <?php $message = $this->session->flashdata(
                            "message"
                        ); ?>



                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">User Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>

                         
                            </div>
                        </div>
                        <!-- end page title -->

                        <?php
                        $list_bulan = array_bulan();

                        $periode_bulan = $this->session->userdata(
                            "periode_bulan"
                        );
                        $periode_tahun = $this->session->userdata(
                            "periode_tahun"
                        );
                        $id_pkm_sess = $this->session->userdata("id_pkm");

                        $bulan = $periode_bulan;
                        $tahun = $periode_tahun;

                        // print_array($this->session->userdata);

                        $id_pegawai = $this->session->userdata("id_pegawai");
                        $nm_bulan = getBulan($bulan);
                        $periode = $tahun . "-" . $bulan;
                        $periode = date("Y-m", strtotime($periode));

                        $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan(
                            $bulan,
                            $tahun
                        );
                        $menitEfektifBulanan = $jumlahHariKerja * 300;

                        $totalInput = $this->Kinerja_model->getJumlahInputPerBulan(
                            $id_pegawai,
                            $periode
                        );
                        if ($totalInput == 0) {
                            $totalInput = 1;
                        }

                        $totalAktifitas = $this->Kinerja_model->getJumlahInputAktifitas(
                            $id_pegawai,
                            $periode
                        );

                        // $dateNow = date('d');
                        // if($dateNow > 10 && $dateNow < 22){

                        // }

                        //echo $tahun.'<br>';
                        $bulanTKD = $bulan - 1;

                        //

                        $nama_user = $this->session->userdata("nama");
                        $nip_user = $this->session->userdata("nip");
                        $id_pegawai = $this->session->userdata("id_pegawai");
                        $photo = $this->Pegawai_model->getPhotoPegawai(
                            $nip_user
                        );

                        $pin = substr($nip_user, -4);

                        $detail_pegawai = $this->Pegawai_model->getDetailPegawai(
                            $id_pegawai
                        );

                        //print_array($detail_pegawai);
                        $jabatan = $detail_pegawai[0]->jabatan;
                        $puskesmas = $detail_pegawai[0]->puskesmas;

                        $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
                        $tgl_masuk = $detail_pegawai[0]->tgl_masuk;
                        $keterangan_jabatan =
                            $detail_pegawai[0]->keterangan_jabatan;

                        $penggantian_cuti = $this->Cuti_model->getPermohonanPengganti(
                            $id_pegawai
                        );
                        $numPermohonan = count($penggantian_cuti);

                        if ($photo == "") {
                            $photo = "avatar.png";
                        }

                        if ($bulanTKD == 0) {
                            $bulanTKD = 12;
                            $tahunTKD = $tahun - 1;

                            $periodeTKD = $tahunTKD . "-" . $bulanTKD;
                        } else {
                            $periodeTKD = $periode;
                        }

                        
                        $nik     = $this->Pegawai_model->getNIKbyNIP($nip_user);

                        $rekapTKD = $this->Laporan_model->getRekapTKDPegawaipertahun( $nip_user,'2025' );

                     


                      //  print_array($rekapTKD);
                        if (!empty($rekapTKD)) {
                             $id_tkd = $rekapTKD[0]->id;
                            $tkd_pokok = $rekapTKD[0]->tkd_pokok;
                            $totalCapaian = $rekapTKD[0]->capaian;
                            $bruto = $rekapTKD[0]->bruto;
                            $pph21 = $rekapTKD[0]->pph21;
                            $bpjs = $rekapTKD[0]->bpjs;
                            $bpjs_tk = $rekapTKD[0]->bpjs_tk;
                            $nettoTKD = $rekapTKD[0]->thp;
                            $masa_kerja = $rekapTKD[0]->masa_kerja;
                             $periodeTKD = $rekapTKD[0]->periode;
                        } else {
                            $tkd_pokok = 0;
                            $totalCapaian = 0;
                            $bruto = 0;
                            $pph21 = 0;
                            $bpjs = 0;
                            $bpjs_tk = 0;
                            $nettoTKD = 0;
                            $masa_kerja = "";
                            $periodeTKD = '';
                            $id_tkd = 0;
                        }

                        $totalPotongan = $pph21 + $bpjs + $bpjs_tk;

                        $tgl_hari_ini = $this->session->userdata(
                            "tgl_hari_ini"
                        );

                        if ($tgl_hari_ini == "") {
                            $today = date("Y-m-d");
                        } else {
                            $today = $tgl_hari_ini;
                        }

                        $hari = format_hari($today);
                        $tgl_ini = formatTanggalIndo($today);

                        $daysBefore = addDaysToDate($today, 1);
                        $daysAfter = dateMinus($today, 1);

                        $dataAbsenHarian = $this->Presensi_model->getDataAbsensi(
                            $pin,
                            $today
                        );
                        //print_array($dataAbsenHarian);

                        if (!empty($dataAbsenHarian)) {
                            $shift = $dataAbsenHarian[0]->shift;
                            $jam_masuk = $dataAbsenHarian[0]->jam_masuk;
                            $jam_pulang = $dataAbsenHarian[0]->jam_pulang;
                            $masuk = $dataAbsenHarian[0]->masuk;
                            $pulang = $dataAbsenHarian[0]->pulang;

                            if ($masuk == "") {
                                $masuk = "00:00:00";
                            }

                            if ($pulang == "") {
                                $pulang = "00:00:00";
                            }
                        } else {
                            $masuk = "00:00:00";
                            $pulang = "00:00:00";
                        }

                        echo $message;


                        $lastGaji = $this->Laporan_model->getlastGaji($nik);
                        if(empty($lastGaji)){
                            $periodeGaji = 0;
                            $nettoGaji   = 0;
                            $id_gaji = 0;
                        }else{
                            $periodeGaji = $lastGaji[0]->periode;
                            $nettoGaji   = $lastGaji[0]->netto;
                            $id_gaji   = $lastGaji[0]->id;
                        }

                      

                        $lastTHR = $this->Laporan_model->getlastTHR($nama_user);
                        if(empty($lastTHR)){
                            $periodeTHR = 0;
                            $nettoTHR   = 0;
                            $id_thr =  0;
                        }else{
                            $periodeTHR = $lastTHR[0]->periode;
                            $nettoTHR   = $lastTHR[0]->total;
                            $id_thr =  $lastTHR[0]->id;
                        }

                        $lastGaji13 = $this->Laporan_model->getlastGaji13($nama_user);
                        if(empty($lastGaji13)){
                            $periodeGaji13 = 0;
                            $nettoGaji13   = 0;
                            $id_gaji13 = 0;
                        }else{
                            $periodeGaji13 = $lastGaji13[0]->periode;
                            $nettoGaji13   = $lastGaji13[0]->total;
                            $id_gaji13 = $lastGaji13[0]->id;
                        }


                        $blmTTDGaji = $this->Laporan_model->getBelumTTDSPJGaji($nik);
                        $blmTTDTKD =  $this->Laporan_model->getBelumTTDSPJTKD($nip_user);

                

                        $infoTTD = [];
                        $infoTTDTKD = [];

                        for ($t=0; $t < count($blmTTDGaji) ; $t++) { 
                            $periode_gaji = $blmTTDGaji[$t]->periode;

                             $infoTTD[] = $periode_gaji;
                        }


                         for ($kd=0; $kd < count($blmTTDTKD) ; $kd++) { 
                            $periode_tkd = $blmTTDTKD[$kd]->periode;

                            $infoTTDTKD[] = $periode_tkd;
                            
                        }


//


                        ?>


                        <div class="modal fade" id="ttdSPJModal" tabindex="-1" aria-labelledby="ttdSPJModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="cutiModalLabel">Warning </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                </div>
                                <div class="modal-body">
                                    <center>
                                         <img src="<?php echo base_url();?>assets/images/reminder.jpg" alt="pengingat">

                                           <?php if( count($infoTTD) > 0){?>
                                                    <div class="fs-4 alert alert-warning text-start">
                                                            Anda belum menandatangani SPJ Gaji Bulan ....   
                                                            <br>
                                                            
                                                            <?php
                                                                for ($d=0; $d < count($infoTTD) ; $d++) { 

                                                                    $bulanTTD =   format_full($infoTTD[$d]);
                                                                    echo '<strong> - '.str_replace("01", "", $bulanTTD).'</strong> <br>' ;
                                                                }
                                                            ?>
                                                    </div> 

                                          <?php } ?>
                                        <?php if( count($infoTTDTKD) > 0){?>
                                              <div class="fs-4 alert alert-info text-start">
                                                    Anda belum menandatangani SPJ TKD Bulan ....   
                                                    <br>
                                                    
                                                    <?php
                                                        for ($d=0; $d < count($infoTTDTKD) ; $d++) { 

                                                            $bulanTTDTKD =   format_full($infoTTDTKD[$d]);
                                                            echo '<strong> - '.str_replace("01", "", $bulanTTDTKD).'</strong> <br>' ;
                                                        }
                                                    ?>
                                            </div> 
                                        <?php } ?>

                                    </center>
                                    
                                  

                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                                </div>
                            </div>
                            </div>

                        </div> <!-- end page title box -->                                          



  
                                <div class="modal fade" id="cutiModal" tabindex="-1" aria-labelledby="cutiModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="cutiModalLabel">Permohonan Pengganti Cuti </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                              //  print_array($penggantian_cuti);

                                                if($penggantian_cuti != null){

                                                        $id_cuti = $penggantian_cuti[0]->id;
                                                        $id_pegawai_cuti = $penggantian_cuti[0]->id_pegawai;
                                                        $alasan_cuti = $penggantian_cuti[0]->alasan_cuti;
                                                        $tgl_dari = $penggantian_cuti[0]->tgl_mulai;
                                                        $tgl_sampai = $penggantian_cuti[0]->tgl_selesai;

                                                        $namaPegawai =  $penggantian_cuti[0]->nama;


                                                        echo '<div class="alert alert-warning">
                                                                Anda memiliki  permohonan pengganti cuti yang belum diproses.</div>';
                                                        echo '<table class="table table-bordered">
                                                                <tr>
                                                                    <th>Nama Pegawai</th>
                                                                    <td>' . $namaPegawai . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Tanggal Pengajuan</th>
                                                                    <td>' . formatTanggalIndo($tgl_dari) . ' s/d ' . formatTanggalIndo($tgl_sampai) . '</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Alasan Cuti</th>
                                                                    <td>' . $alasan_cuti . '</td>
                                                                </tr>
                                                            </table>';


                                                   
                                                    echo '<center>
                                                            <a href="' . base_url() . 'cuti/detail_pengajuan_cuti/' . $id_cuti . '" class="btn btn-info">Lihat Detail</a>
                                                       </center>';
                                                }
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                        </div>
                                    </div>
                                    </div>

                            </div> <!-- end page title box -->                                          





                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="row  p-3">
                                        <div class="col-2">
                                            <span class=" m-2 me-4">
                                                <img src="<?php echo base_url(); ?>uploads/photo_profile/<?php echo $photo; ?>" style="height: 100px; Width:100px" alt="" class="rounded-circle img-thumbnail">
                                            </span>
                                        </div>

                                        <div class="col-8">
                                            <h4 class="mt-1 mb-1"><?php echo $nama_user; ?></h4>
                                              <p class="font-13"> <?php echo $nip_user; ?></p>

                                            <strong class="font-13"> <?php echo $puskesmas; ?></strong>
                                              <p class="font-13"> <?php echo $jabatan; ?> -   <?php echo $keterangan_jabatan; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-3">
                                <div class="card bg-white text-center p-2">
                                    <h5 class="text-info"> Gaji <?php echo date('F Y', strtotime($periodeGaji));?></h5>
                                    <h4>Rp. <?php echo rupiah($nettoGaji);?></h4>

                                    <a href="<?php echo base_url();?>profile/detail_gaji/<?php echo $id_gaji;?>" class="btn btn-sm btn-info">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-white text-center p-2">
                                    <h5 class="text-info"> TKD  <?php echo date('F Y', strtotime($periodeTKD));?></h5>
                                    <h4>Rp. <?php echo rupiah($nettoTKD);?></h4>

                                    <a href="<?php echo base_url();?>profile/detail_tkd/<?php echo $id_tkd;?>" class="btn btn-sm btn-info">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-white text-center p-2">
                                    <h5 class="text-primary"> THR</h5>
                                    <h4>Rp. <?php echo rupiah($nettoTHR);?></h4>

                                    <a href="<?php echo base_url();?>profile/my_thr" class="btn btn-sm btn-primary">Lihat Detail</a>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-white text-center p-2">
                                    <h5 class="text-warning"> Gaji ke 13</h5>
                                    <h4>Rp. <?php echo rupiah($nettoGaji13);?></h4>

                                    <a href="<?php echo base_url();?>profile/detail_gaji13/<?php echo $id_gaji13;?>" class="btn btn-sm btn-warning">Lihat Detail</a>
                                </div>
                            </div>


                            <div class="col-xxl-4 col-lg-6">


                                <div class="card widget-flat">
                                    <div class="card-body text-center">
                                    <h5>Absensi Harian </h5>

                                          <div class="row mt-1">
                                                <div class="col-md-2 col-2">  <a href="<?php echo base_url(); ?>dashboard/change_date/<?php echo $daysAfter; ?>" class="text-muted btn btn-light">  <i class="dripicons-chevron-left"></i></a></div>
                                                <div class="col-md-8 col-8">  <h4>  <?php echo $hari; ?>, <?php echo $tgl_ini; ?> <br>
                                                 <small>   <span id="time" class="text-dark">00:00:00</span> </small>  </h4>
                                               </div>
                                                <div class="col-md-2 col-2">  <a href="<?php echo base_url(); ?>dashboard/change_date/<?php echo $daysBefore; ?>" class="text-muted  btn btn-light"><i class="dripicons-chevron-right"></i></a></div>
                                          </div>



                                        <div class="row mt-4">
                                            <div class="col-md-6 col-6">
                                                <h5 class="text-muted fw-normal mt-0" title="Revenue">Absen Masuk</h5>
                                                <h3 class="mt-1 mb-3 text-success" id="absen_masuk"><?php echo $masuk; ?></h3>
                                            </div>
                                            <div class="col-md-6 col-6">
                                              <h5 class="text-muted fw-normal mt-0" title="Revenue">Absen Keluar</h5>
                                              <h3 class="mt-1 mb-3 text-danger" id="absen_keluar"><?php echo $pulang; ?></h3>
                                            </div>
                                        </div>

                                        <button type="button" name="button" id="sinkron_absen"  value="<?php echo $today; ?>" class="btn btn-info btn-rounded btn-sinkron">
                                          <i class="dripicons-clockwise"></i> &nbsp; Sinkron
                                        </button>

                                        <button class="btn btn-primary btn-spinner btn-rounded d-none" type="button" disabled>
                                            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                                            Loading...
                                        </button>

                                    </div>
                                </div>
                            </div> <!-- end col-->


                            <div class="col-xxl-4 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <div class="float-end">
                                            <a href="<?php echo base_url(); ?>kinerja/list_kinerja" class="btn btn-sm btn-light">View</a>
                                        </div>
                                        <h6 class="text-muted text-uppercase mt-0" title="Revenue">Total Inputan Aktifitas</h6>
                                        <h3 class="mb-4 mt-2"><?php echo $totalAktifitas; ?> <small>aktifitas</small> </h3>
                                        <div id="spark1" class="apex-charts mb-3" data-colors="#734CEA"></div>

                                        <div class="row text-center">
                                            <div class="col-6">
                                                <h6 class="text-truncate d-block">Menit Efektif</h6>
                                                <p class="font-18 mb-0"><?php echo number_format(
                                                    $menitEfektifBulanan
                                                ); ?></p>
                                            </div>
                                            <div class="col-6">
                                                <h6 class="text-truncate d-block">Total Input</h6>
                                                <p class="font-18 mb-0"> <?php echo number_format(
                                                    $totalInput
                                                ); ?> </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col-->



                            <div class="col-xxl-4 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                         <h5>SHORTCUT BUTTON </h5>
                                         <br>
                                         <div class="text-center">

                                           <div class="row">
                                               <div class="col-3">
                                                   <button type="button" class="btn btn-primary btn-xl btn-rounded"  data-bs-toggle="modal" data-bs-target="#scrollable-modal">
                                                     <i class="mdi mdi-google-maps" style="font-size:30px"></i>
                                                   </button>
                                                   <h6>Dinas Luar</h6>

                                               </div>
                                               <div class="col-3">
                                                   <a href="<?php echo base_url(); ?>absensi/pengajuan_izin_sakit" class="btn btn-warning btn-xl btn-rounded">
                                                     <i class="mdi mdi-account-arrow-right-outline" style="font-size:30px"></i>
                                                   </a>
                                                   <h6>Izin</h6>

                                               </div>
                                               <div class="col-3">
                                                 <a href="<?php echo base_url(); ?>absensi/pengajuan_izin_sakit" class="btn btn-danger btn-xl btn-rounded">
                                                     <i class="mdi mdi-bed" style="font-size:30px"></i>
                                                  </a>
                                                   <h6>Sakit</h6>

                                               </div>
                                               <div class="col-3">
                                                   <button type="button" class="btn btn-success btn-xl btn-rounded"  data-bs-toggle="modal" data-bs-target="#cuti-modal">
                                                     <i class="mdi mdi-briefcase-account" style="font-size:30px"></i>
                                                  </button>
                                                   <h6>Cuti</h6>

                                               </div>
                                           </div>

                                         </div>

                                    </div>
                                </div>
                            </div> <!-- end col-->

                        </div>








                        <div class="modal fade" id="cuti-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                           <div class="modal-dialog modal-dialog-scrollable" role="document">

                                <div class="modal-content">
                                        <form action="<?php echo base_url(); ?>cuti/create_session_pengajuan_cuti" method="post" enctype="multipart/form-data" id="pengajuan_cuti">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scrollableModalTitle">Pengajuan Cuti</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <div class="form-group">  <label class="form-label">Jenis Cuti</label>
                                                                <select name="jns_cuti" id="jenis_cuti" required  class="form-control">

                                                                    <option value="">Pilih Jenis Cuti</option>
                                                                        <?php
                                                                        for ( $c = 0; $c < count($master_cuti);$c++ ) {
                                                                            $id = $master_cuti[$c]->id;
                                                                            $jenis_cuti = $master_cuti[$c]->jenis_cuti;

                                                                            echo ' <option value="' . $id . '">' .$jenis_cuti . "</option>";
                                                                        } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mt-2 col-6">
                                                            <div class="form-group">
                                                                <label for="tgl_mulai">Tanggal Mulai</label>
                                                                <input type="text" name="tgl_mulai"  class="form-control bg-white"  required id="tgl_mulai_cuti"   data-date-format="d-m-Y" placeholder="Select Date">
                                                            </div>

                                                        </div>
                                                        <div class="col-md-6 mt-2 col-6">
                                                            <div class="form-group">
                                                                <label for="tgl_mulai">Tanggal Akhir</label>
                                                                <input type="text" name="tgl_akhir"  class="form-control bg-white"  required  id="tgl_akhir_cuti"  data-date-format="d-m-Y" placeholder="Select Date">
                                                            </div>

                                                        </div>

                                                        <div class="col-md-4 mt-2">
                                                            <div class="form-group">
                                                                <label class="form-label">Hari Cuti</label>
                                                                <div id="jumlah_hari_cuti" class="border bg-light text-center p-1 fs-4 fw-bold">- hari </div>
                                                            </div>
                                                        </div>


                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success kirim" id="submit_btn">Selanjutnya</button>
                                            </div>
                                     </form>
                                </div><!-- /.modal-content -->


                          </div><!-- /.modal-dialog -->
                      </div><!-- /.modal -->



                        <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-scrollable" role="document">
                          <form action="<?php echo base_url(); ?>absensi/insertPengajuanDinasLuar" method="post" enctype="multipart/form-data" id="pengajuan_dl">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="scrollableModalTitle">Pengajuan Dinas Luar</h5>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                  </div>
                                  <div class="modal-body">
                                       <table class="table table-borderless table-sm">
                                          <tr>
                                            <th>Tanggal</th>
                                            <td>   <input type="text" name="tgl_dl"  class="form-control"  required value="<?php echo date(
                                                "d-m-Y"
                                            ); ?>" id="tgl_absen_dl" value="" data-provider="flatpickr" data-date-format="d-m-Y" placeholder="Select Date"></td>
                                          </tr>
                                          <tr>
                                            <th>Jenis DL</th>
                                            <td>
                                            <div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="DLP"  required name="jns_dl" value="DLP"  class="form-check-input">
                                                    <label class="form-check-label" for="DLP">DL-PENUH</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="DLA" required value="DLA" name="jns_dl"  class="form-check-input">
                                                    <label class="form-check-label" for="DLA"> DL-AWAL</label>
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <input type="radio" id="DLAK"  required value="DLAK" name="jns_dl" class="form-check-input">
                                                    <label class="form-check-label" for="DLAK"> DL-AKHIR</label>
                                                </div>

                                            </div>
                                            </td>
                                          </tr>

                                          <tr>
                                            <th> <label for="keterangan" class="inline-block mb-2 text-base font-medium">Keterangan</label></th>
                                            <td> <textarea name="keterangan" required id="keterangan" class="form-control"  rows="2" cols="10" wrap="soft"></textarea></td>
                                        </tr>

                                       </table>


                                       <div class="xl:col-span-12 ">
                                                <!-- <div class="file-upload">
                                                    <button type="button" class="file-upload-button btn btn-primary mr-4">
                                                    <i class="mdi mdi-camera"></i>
                                                    Open Camera</button>
                                                    <input type="file" accept="image/*" capture="camera" id="cameraInput" name="cameraInput">
                                                    <span class="file-upload-name">No file chosen</span>
                                                </div> -->

                                                    <center>
                                                            <input type="file" name="cameraInput" id="cameraInput" class="inputfile" />
                                                        <label for="cameraInput">Choose a file</label>

                                                    </center>

                                                    <br><br>

                                                  <img id="preview" src="#" alt="Image preview" style="display: none;">

                                                <br><br>
                                                <input type="hidden" id="latitude" name="latitude">
                                                <input type="hidden" id="longitude" name="longitude">
                                        </div>

                                  </div>
                                  <div class="modal-footer">
                                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-success kirim" id="submit_btn">Kirim</button>
                                  </div>
                              </div><!-- /.modal-content -->

                              </form>
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
        <?php $this->load->view("layout/section/theme-setting"); ?>

        <!-- bundle -->
        <script src="<?php echo base_url(); ?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url(); ?>assets/new/js/ui/component.todo.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

         <script src="<?php echo base_url(); ?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

        <script>


            $("#jenis_cuti").on("change", function() {
                const jenisCuti = $(this).val();

                if (jenisCuti === 1) {
                    $("#tgl_akhir_cuti").prop("disabled", true);
                    $("#jumlah_hari_cuti").text("3 bulan");
                } else {
                    $("#tgl_akhir_cuti").prop("disabled", false);
                    $("#jumlah_hari_cuti").text("-");
                }

                $("#tgl_mulai_cuti").focus();
            });


              const yesterday = new Date();
              yesterday.setDate(yesterday.getDate() - 2);

                flatpickr("#tgl_absen_dl", {});

                // Inisialisasi tanggal mulai
                const tglMulai = flatpickr("#tgl_mulai_cuti", {
                  minDate: yesterday,              // Mulai dari hari ini
                  maxDate: new Date().fp_incr(90), // Maksimal 90 hari ke depan (~3 bulan)
                  dateFormat: "d-m-Y",
                  allowInput: true,
                  altInput: false,
                  onChange: function(selectedDates, dateStr, instance) {
                      // Otomatis isi tanggal akhir sama dengan tanggal mulai
                      if (selectedDates.length > 0) {
                           const startDate = selectedDates[0];

                           // Set tanggal akhir sama dengan tanggal mulai
                           tglAkhir.setDate(startDate);
                           tglAkhir.set('minDate', startDate);

                           // Fokus ke input akhir
                           document.getElementById("tgl_akhir_cuti").focus();
                         }
                    }
                });

                // Inisialisasi tanggal akhir
                const tglAkhir = flatpickr("#tgl_akhir_cuti", {
                  minDate: yesterday,
                  allowInput: true,
                    altInput: false,         // Ini akan di-update saat pilih tgl mulai
                  maxDate: new Date().fp_incr(120),
                  dateFormat: "d-m-Y"
                });


                function isValidDate(dateString) {
                  // Cek format YYYY-MM-DD pakai regex sederhana
                  return /^\d{2}-\d{2}-\d{4}$/.test(dateString);
                }

                $("#tgl_mulai_cuti, #tgl_akhir_cuti").on("change", function() {
                  const tglMulai = $("#tgl_mulai_cuti").val();
                  const tglAkhir = $("#tgl_akhir_cuti").val();
                  const jenisCuti = $("#jenis_cuti").val();

                  if (!tglMulai || !tglAkhir) {
                    $("#jumlah_hari_cuti").text("-");
                    return;
                  }

                  if (!isValidDate(tglMulai) || !isValidDate(tglAkhir)) {
                    alert("Format tanggal harus YYYY-MM-DD");
                    $("#jumlah_hari_cuti").text("-");
                    return;
                  }

                //   if (tglAkhir < tglMulai) {
                //     alert("Tanggal akhir tidak boleh sebelum tanggal mulai");
                //     $("#jumlah_hari_cuti").text("-");
                //     return;
                //   }


                  if (jenisCuti == 2) {
                      const parts = tglMulai.split("-"); // format: dd-mm-yyyy
                      const d = new Date(`${parts[2]}-${parts[1]}-${parts[0]}`); // yyyy-mm-dd

                      d.setMonth(d.getMonth() + 3); // tambah 3 bulan

                      const day = String(d.getDate()).padStart(2, "0");
                      const month = String(d.getMonth() + 1).padStart(2, "0");
                      const year = d.getFullYear();

                      const tglAkhir = `${day}-${month}-${year}`;
                      $("#tgl_akhir_cuti").val(tglAkhir);
                      $("#jumlah_hari_cuti").text("3 bulan");
                  }else{
                     hitungHariCuti(tglMulai, tglAkhir);
                  }


                  // Jika valid, jalankan AJAX (kita nanti isi)

                });

                function hitungHariCuti(tglMulai, tglAkhir) {
                  const jenis = $("#jenis_jam_kerja").val();
                  $.ajax({
                    url: "<?php echo base_url("cuti/hitung"); ?>",
                    type: "POST",
                    data: { tgl_mulai: tglMulai, tgl_akhir: tglAkhir, jenis_jam_kerja: jenis },
                    dataType: "json",
                    success: function(response) {
                      if (response.error) {
                        alert(response.error);
                        $("#jumlah_hari_cuti").text("-");
                      } else {
                        $("#jumlah_hari_cuti").text(response.jumlah_hari + " hari");
                      }
                    },
                    error: function() {
                      alert("Terjadi kesalahan saat menghitung cuti.");
                      $("#jumlah_hari_cuti").text("-");
                    }
                  });
                }


                //   $('#pengajuan_cuti').submit(function() {

                //           $.ajax({
                //               type: 'POST',
                //               url: $(this).attr('action'),
                //               data: $(this).serialize(),
                //               success: function(response) {
                //                 $(".modal-content").html(response);
                //               }
                //           })
                //           return false;
                //     });





          function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;
            document.getElementById('time').textContent = timeString;
          }

          // Update the clock every second
          setInterval(updateClock, 1000);

          // Initialize clock immediately
          updateClock();



           $(document).ready(function () {

                    <?php if ($numPermohonan > 0): ?>
                        window.onload = function() {
                                var cutiModal = new bootstrap.Modal(document.getElementById('cutiModal'));
                                cutiModal.show();
                            };
                    <?php endif; ?>
                
                
                
                  <?php if (count($blmTTDGaji) > 0 || count($blmTTDTKD) > 0  ): ?>
                         window.onload = function() {
                                  var ttdSPJModal = new bootstrap.Modal(document.getElementById('ttdSPJModal'));
                                ttdSPJModal.show();
                            };

                

                        document.getElementById('cameraInput').addEventListener('change', function(event) {
                            var file = event.target.files[0];
                            if (file) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('preview').src = e.target.result;
                                document.getElementById('preview').style.display = 'block';
                            }
                            reader.readAsDataURL(file);
                            }
                        });
             <?php endif; ?>


                        $('#sinkron_absen').click(function() {
                            let tgl = $(this).val();

                            $(".btn-sinkron").addClass("d-none");
                            $(".btn-spinner").removeClass("d-none");

                            $.ajax({
                                type: 'POST',
                                url: '<?php echo base_url(); ?>dashboard/sinkron_absensi',
                                data: 'tgl='+tgl,
                                success: function(msg) {
                                    $(".btn-sinkron").removeClass("d-none");
                                    $(".btn-spinner").addClass("d-none");

                                    let absen = msg.split("/");
                                    let absen_masuk  = absen[0];
                                    let absen_keluar = absen[1];
                                    $("#absen_masuk").html(absen_masuk);
                                    $("#absen_keluar").html(absen_keluar);

                                    $.NotificationApp.send("Success","Data Absensi berhasil disinkron","top-center","#FFF","success");
                                //  $(this).html(msg)
                                }
                            })

                        });

                });


                // Mendapatkan lokasi pengguna
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude;
                    document.getElementById('longitude').value = position.coords.longitude;
                    }, function(error) {
                    console.error('Error getting location:', error);
                    });
                } else {
                    console.error('Geolocation is not supported by this browser.');
                }



                $("#pengajuan_dl").submit(function(){
                   // alert("sagfasw");
                    $(".modal-footer").html('<div class="d-flex align-items-center"><strong>Loading...</strong><div class="spinner-border text-success ms-auto" role="status" aria-hidden="true"></div></div>');
                });
        </script>

           


    </body>
</html>
