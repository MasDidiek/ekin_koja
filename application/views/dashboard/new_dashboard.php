<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
   <style>
    .d-none{
        display: none;
    }
    .bg-success{
        background: #3fd480;
    }
    .clearfix{
        clear: both;
    }

    .form-dinas-luar, .form-izin-sakit, .form-sakit{
        padding: 15px;
        border: 1px solid #4992c9;
        margin-top: 10px;
        display: none;
    }
    .form-izin-sakit
    {
        border: 1px solid orange;
    }

    .file-upload-izin{
        position: relative;
        display: inline-block;
        overflow: hidden;
        border: 1px solid #DDD;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }
    
    
    .file-upload {
      position: relative;
      display: inline-block;
      overflow: hidden;
      border: 1px solid #DDD;
      border-radius: 5px;
      padding: 10px;
    }

    .file-upload input[type='file'] {
      position: absolute;
      font-size: 100px;
      opacity: 0;
      right: 0;
      top: 0;
    }

    .file-upload-izin input[type='file'] {
      position: absolute;
      font-size: 100px;
      opacity: 0;
      right: 0;
      top: 0;
    }

    .file-upload-button{
        cursor: pointer;
    }

    .file-upload-name {
      margin-left: 10px;
      font-family: Arial, sans-serif;
    }

    .loading-bg{
        background-color: rgba(255, 255, 255, 0.8);
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        z-index: 99;
        display: none;
    }

    .loader{
        width: 600px;
        height: 100%;
        margin: 10% auto;
    }

    .left, .right{
        width: 45%;
        height: auto;
        background-color: #FFF;
        border-radius: 10px;
        padding:15px;
        text-align: center;
        float: left;
        color: green;
        margin-bottom: 20px;
    }

    .left{
        margin-right: 20px;
    }

    .right{
        color: orange;
    }
    .left span{
        color: #666;
    }
    .right span{
        color: #666;
    }
    .time{
        font-size:18px;
    }


    .btn-shorcut{
        background-color: #FFF;
        text-align: center;
        border-radius: 15px;
        height: 150px;
        width: 100px;
        font-weight: bold;
        margin-bottom: 5px;
        font-size: 12px;
        display: inline-block;
        cursor: pointer;
    }

    .inner-icon{
     
        text-align: center;
        padding:15px 10px;
        border-radius: 5px;
        width: 95%;
        transition: all 0.5s;
        margin: 10px auto;
        border: 1px solid rgb(223, 240, 247);
    }

    .inner-icon:hover{
        background-color:rgb(224, 248, 255);
    }

    .btn-shorcut img{
        text-align: center;
        display: block;
        margin: 0 auto;
    }
  
   </style>

</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $status_upload = $this->session->flashdata('status');
       $info = $this->session->flashdata('message');

     

       $nama    = $this->session->userdata('nama');
       $usergroup    = $this->session->userdata('usergroup');

    //    if($usergroup <= 3){
    //     $link = '';
    //    }else{
    //     $link = 'hidden';
    //    }

      // print_array($this->session->userdata);

       

     

        $listCapaian = array();
        $listBulanCapaian = array();

        foreach ($rekap_capaian_kinerja AS $data_capaian) {

            $capaian = $data_capaian->capaian;
                
            if($capaian == ''){
                $capaian = 0;
            }
            $periodeBulan = date('M', strtotime($data_capaian->periode));

            array_push($listCapaian, $capaian);
            array_push($listBulanCapaian, $periodeBulan);

        }

        if(empty($listCapaian)){
            $listCapaian = array(0);
        }
        

        $list_capaian = json_encode($listCapaian);
        $bulanCapaian = json_encode($listBulanCapaian);

        $capaianTerkecil = min($listCapaian);
        $min = $capaianTerkecil-1;


        $listBulan = array_bulan();
        
     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



      <?php

                $id_pegawai = $this->session->userdata('id_pegawai');
                $nip  = $this->session->userdata('nip');

                $bulan = $this->session->userdata('periode_bulan'); 
                $tahun = $this->session->userdata('periode_tahun'); 
               
                $periode = $tahun.'-'.$bulan;
                $periode = date('Y-m', strtotime($periode));


            
                $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);

               
               // echo  'jumlh hari'.$jumlahHariKerja;
                //exit;
                $menitEfektifBulanan  = $jumlahHariKerja*300;


                $totalInput = $this->Kinerja_model->getJumlahInputPerBulan($id_pegawai, $periode);
                if($totalInput==0){
                    $totalInput = 1;
                }

                $persenInput = ($totalInput/$menitEfektifBulanan)*100;
                if ($persenInput > 100) {
                    $persenInput = 100;
                }


                //print_array($getLastAbsensi);
              

                $totalApprove  = $this->Kinerja_model->getAktifitasApprove($id_pegawai, $periode);
                if($totalApprove==''){
                    $totalApprove  = 0;
                }
                $persenApprove = ceil(($totalApprove/$totalInput)*100);


                $totalReject = $this->Kinerja_model->getAktifitasByStatus($id_pegawai, $periode, 2);
                if($totalReject==''){
                    $totalReject  = 0;
                }

                $persenReject = ($totalReject/$totalInput)*100;

                            
                if(!empty($rekapAbsensi)){

                        $telat       = $rekapAbsensi[0]->telat;
                        $pulang_awal = $rekapAbsensi[0]->pulang_awal;
                        $izin        = $rekapAbsensi[0]->izin;
                        $sakit       = $rekapAbsensi[0]->sakit;
                        $cuti        = $rekapAbsensi[0]->cuti;
                        $sakit_dgn_sk = $rekapAbsensi[0]->sakit_dgn_sk;

                        
                        $menit_izin = $izin*300;
                        $menit_sakit = $sakit*300;
                        $menit_sakit_dgn_surat = $sakit_dgn_sk*300;

                        $totalPengurang = $telat+$pulang_awal+$menit_izin+$menit_sakit+$menit_sakit_dgn_surat;
                        $menitPenambah       = $cuti*300;
                }else{
                        $telat       = '-';
                        $pulang_awal =  '-';
                        $izin        =  '-';
                        $sakit       =  '-';
                        $cuti        =  '-';
                        $sakit_dgn_sk = '-';
                        $totalPengurang = $menitEfektifBulanan;
                        $menitPenambah       = 0;
                }


                

                $nilaiTotalAktifitas = $totalAktifitas+$menitPenambah;
        
        
            
                $totalWaktuEfektif = $menitEfektifBulanan-$totalPengurang;
        
                $nilaiLebihKecil  =  $totalWaktuEfektif;
                if ($totalWaktuEfektif > $nilaiTotalAktifitas) {
                 $nilaiLebihKecil  =  $nilaiTotalAktifitas;
                }

                
                        
                $bobotAktifitas = ($nilaiLebihKecil/$menitEfektifBulanan)*100;
                $bobotTotal     = round($bobotAktifitas*0.7, 2);


                        
                $bobotAktifitas = ($nilaiLebihKecil/$menitEfektifBulanan)*100;
                $bobotTotal     = round($bobotAktifitas*0.7, 2);


                $nama_bulan = getBulan($bulan);

                $nip =  $this->session->userdata('nip');


                if(!empty($rekapTKD)){
                    $tkd_pokok = $rekapTKD[0]->tkd_pokok;
                    $totalCapaian = $rekapTKD[0]->capaian;
                    $bruto  = $rekapTKD[0]->bruto;
                    $pph21 = $rekapTKD[0]->pph21;
                    $bpjs = $rekapTKD[0]->bpjs;
                    $bpjs_tk = $rekapTKD[0]->bpjs_tk;
                    $thp = $rekapTKD[0]->thp;
                    $masa_kerja = $rekapTKD[0]->masa_kerja;
                       
                  }else{
                    $tkd_pokok = 0;
                    $totalCapaian =  0;
                    $bruto  = 0;
                    $pph21 =  0;
                    $bpjs =  0;
                    $bpjs_tk =  0;
                    $thp =  0;
                    $masa_kerja = '';
                  }
          
                  $totalPotongan = $pph21+$bpjs+$bpjs_tk;

                  $today = date('Y-m-d');
                  
                $pin           = substr($nip, -4);

                $absensiPegawai = $this->Presensi_model->getDataAbsensi($pin, $today);


                if(!empty($absensiPegawai)){
                    $masuk   = $absensiPegawai[0]->masuk;
                    $pulang   = $absensiPegawai[0]->pulang;
                    $doUpdate = false;
                }else{
                    $masuk   =  '';
                    $pulang   = '';
                    $doUpdate = true;
                }
             



                
                $sisaTahun2024 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
                $sisaTahun2025 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');

               $sisaCutiAll = $sisaTahun2024+$sisaTahun2025;
               $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');


                ?>

        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
         <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
                
                 <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                    <div class="grow">
                      
                    <h4>Welcome Back, <?php echo  $nama ;?></h4>
                           Dashboard ekinerja Puskesmas Cilincing
                           
                    </div>
                   
                </div>
        
               
                

               
                        

                           


                      <button type="button" class="hidden mb-3 text-white btn bg-purple-500 border-purple-500 hover:text-white hover:bg-purple-600 hover:border-purple-600 focus:text-white focus:bg-purple-600 focus:border-purple-600 focus:ring focus:ring-purple-100 active:text-white active:bg-purple-600 active:border-purple-600 active:ring active:ring-purple-100 dark:ring-purple-400/20"><i class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> Input DL</button>
                      <!-- <button type="button" class="mb-3 text-white btn bg-orange-500 border-orange-500 hover:text-white hover:bg-orange-600 hover:border-orange-600 focus:text-white focus:bg-orange-600 focus:border-orange-600 focus:ring focus:ring-orange-100 active:text-white active:bg-orange-600 active:border-orange-600 active:ring active:ring-orange-100 dark:ring-orange-400/20"><i class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> Input Izin</button>
                      <button type="button" class="mb-3 text-white btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20"><i class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> Input Cuti</button> -->

                      <br>
                         <div class="loading-bg">
                            <div class="loader"> <img src="<?php echo base_url();?>assets/images/loading-bar.gif" alt=""> </div>
                        </div>

                      <div class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
                            <div class="col-span-12 p-4 lg:col-span-7 bg-sky-500 xl:col-span-7 2xl:col-span-7 card">
                                <h6 class="text-15 text-white grow">Today-  <?php echo date('d M Y');?></h6>
                                    <br>
                                    <div class="left">
                                            <div class="time"> 
                                            <strong>  
                                            <?php 
                                                if($masuk==''){
                                                        echo '--:--';
                                                }else{
                                                    echo date('H:i', strtotime($masuk));
                                                }
                                            ?> 
                                            </strong> 
                                            WIB</div>
                                            <span>Masuk</span>  
                                    </div>
                                    <div class="right">
                                        <div class="time">
                                            <strong>  
                                            <?php 
                                                if($pulang==''){
                                                        echo '--:--';
                                                }else{
                                                    echo date('H:i', strtotime($pulang));
                                                }
                                            ?> 
                                            </strong> 
                                            WIB</div>
                                            <span>Pulang</span> 
                                        </div>


                                    <center>
                                    <button type="button" class="btn-sinkron mb-3 text-white btn bg-yellow-500 border-yellow-500 hover:text-white hover:bg-yellow-600 hover:border-yellow-600 focus:text-white focus:bg-yellow-600 focus:border-yellow-600 focus:ring focus:ring-yellow-100 active:text-white active:bg-yellow-600 active:border-yellow-600 active:ring active:ring-yellow-100 dark:ring-yellow-400/20"><i class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> Sinkron Absen</button>
                                    </center>
                             </div><!--end grid-->

                             <div class="col-span-12  lg:col-span-5  xl:col-span-5 2xl:col-span-5 card">

                             
                                        <div class="card-body">
                                                <div class=" items-center">
                                                    <h6 class="text-15">Shortcut</h6>
                                                    <br>
                                                          
                                                       <button class="btn-shorcut"  data-modal-target="actionModal">

                                                        
                                                            <div class="inner-icon">
                                                               <img src="<?php echo base_url();?>assets/images/briefcase.png" width="55" alt="">
                                                              </div>

                                                             Dinas Luar
                                                        </button>

                                                            
                                                        <button class="btn-shorcut">
                                                            <a href="<?php echo base_url();?>absensi/pengajuan_izin_sakit">
                                                            <div class="inner-icon">  <img src="<?php echo base_url();?>assets/images/leave.png"  width="60" alt=""> </div>
                                                             Izin
                                                            </a>
                                                        </button>
                                                            
                                                        <button class="btn-shorcut" data-modal-target="sakitModal">
                                                         <a href="<?php echo base_url();?>absensi/pengajuan_izin_sakit">
                                                               <div class="inner-icon">
                                                                <img src="<?php echo base_url();?>assets/images/bedrest.png"   width="60" alt="">
                                                                </div>
                                                                 Sakit
                                                         </a>
                                                        </button>

                                                        <button class="btn-shorcut"  data-modal-target="cutiModal" >

                                                            <div class="inner-icon">
                                                                 <img src="<?php echo base_url();?>assets/images/cuti.png"   width="60" alt="">
                                                            </div>
                                                             Cuti
                                                        </button>
                                                </div>

                                        </div>
                             </div>

                             <div class="col-span-12 p-4 lg:col-span-12  xl:col-span-12 2xl:col-span-12 card">
                             
                                                ini info <?php   echo   $status_upload.' - '.$info;?>
                                                
                             </div>


                       <div class="col-span-12 md:order-6 lg:col-span-6 xl:col-span-6 2xl:col-span-4 card">

                         <div class="card-body">
                                <div class="flex items-center">
                                    <h6 class="text-15 grow">Data Inputan Aktifitas</h6>
                                    <div class="relative dropdown shrink-0">
                                        <button id="orderAction1" data-bs-toggle="dropdown" class="flex items-center justify-center size-[30px] dropdown-toggle p-0 bg-white text-slate-500 btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:hover:bg-slate-500/10 dark:focus:bg-slate-500/10 dark:active:bg-slate-500/10">
                                            <i data-lucide="more-horizontal" class="size-3"></i></button>
                                        <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600" aria-labelledby="orderAction1">
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200" href="#!">This Year</a>
                                            </li>
                                            <li>
                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200" href="#!">Last Year</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <br>
                                <center>
                                 Waktu Efektif  <strong> <?php echo date('M, Y', strtotime($periode));?></strong>  <br>
                                <strong><?php echo rupiah($menitEfektifBulanan);?></strong> menit
                                </center>
                                <div id="emailMarketingChart" class="apex-charts" data-chart-colors='["bg-sky-500", "bg-green-500", "bg-red-500"]' dir="ltr"></div>
                                  <br>
                                <div class="text-center mt-4">
                                 <a href="<?php echo base_url();?>kinerja/input_kinerja_v2" class="px-2 py-1.5  text-xs text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Input Aktifitas</a>
                                </div>
                               
                           </div>

                        
                       </div>

                       <div class="col-span-12 md:order-7 lg:col-span-6 xl:col-span-6 2xl:col-span-4 card">

                          <div class="card-body">
                                <div class="items-center">
                                    <h6 class="text-15 grow">Capaian Kinerja  </h6>
                                     <br>
                                   <center>
                                     <span class="counter-value text-orange-500" style="font-size: 40px;" data-target="<?php echo $totalCapaian;?>">0</span>%</h5>
                                     <p class="text-slate-500 dark:text-zink-200">Total Capaian Kinerja</p>
                                   </center>
                                       <br>
                                  

                                        <div class="col-span-12 md:order-2 xl:col-span-4 2xl:col-start-9 ">
                                            <div class="p-4">
                                                <div class="grid grid-cols-3">
                                                    <div class="px-4 text-center ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500 ltr:last:border-r-0 rtl:last:border-l-0">
                                                        <h6 class="mb-1 font-bold">
                                                            <span class="counter-value" style="font-size: 20px;" data-target="  <?php echo  $bobotTotal ;?>">0</span>%</h6>
                                                        <p class="text-slate-500 dark:text-zink-200">Bobot Kinerja</p>
                                                    </div>
                                                    <div class="px-4 text-center ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500 ltr:last:border-r-0 rtl:last:border-l-0">
                                                        <h6 class="mb-1 font-bold"><span class="counter-value"  style="font-size: 20px;" data-target="<?php echo $poinPerilaku;?>">0</span>%</h6>
                                                        <p class="text-slate-500 dark:text-zink-200">Perilaku</p>
                                                    </div>
                                                    <div class="px-4 text-center ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500 ltr:last:border-r-0 rtl:last:border-l-0">
                                                        <h6 class="mb-1 font-bold"><span class="counter-value"  style="font-size: 20px;" data-target="20">0</span>%</h6>
                                                        <p class="text-slate-500 dark:text-zink-200">Serapan</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <hr>
                                        <Br>
                                        <div class="col-span-12 md:order-2 xl:col-span-12 2xl:col-start-9 ">
                                            <table class="w-full">
                                               
                                                <tbody>
                                                    <tr>
                                                      
                                                        <td class="px-3.5 py-2.5 border-y">Terlambat</td>
                                                        <td class="px-3.5 py-2.5 border-y text-right"><span class="counter-value"  data-target="  <?php echo  $telat ;?>">0</span> 
                                                        <span class="text-slate-500 dark:text-zink-200">Menit </span></td>
                                                       
                                                    </tr>
                                                    <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">Pulang Awal</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right"><?php echo $pulang_awal;?> 
                                                      <span class="text-slate-500 dark:text-zink-200">Menit </span></td>
                                                     
                                                  </tr>
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">Izin</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right"><?php echo $izin;?> <span class="text-slate-500 dark:text-zink-200">Hari </span></td>
                                                     
                                                  </tr>
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">Sakit</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right"><?php echo  $sakit ;?> <span class="text-slate-500 dark:text-zink-200">Hari </span></td>
                                                     
                                                  </tr>
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">Sakit Dgn Surat</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right"><?php echo  $sakit_dgn_sk ;?> <span class="text-slate-500 dark:text-zink-200">Hari </span></td>
                                                     
                                                  </tr>
                                                   
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">Cuti</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right"><?php echo  $cuti ;?> <span class="text-slate-500 dark:text-zink-200">Hari </span></td>
                                                     
                                                  </tr>
                                                </tbody>
                                            </table>

                                           
                                        </div>
                                            
                                </div>
                                <br>
                              
                           </div>

                        
                       </div>
                       <div class="col-span-12 md:order-7 lg:col-span-4 xl:col-span-4 2xl:col-span-4 card">

                          <div class="card-body">
                                <div class="items-center">
                                    <h6 class="text-15 grow">Penerimaan TKD  </h6>
                                     <br>
                                   <center>
                                     Rp. <span class="counter-value text-green-500" style="font-size: 40px;" data-target="<?php echo $thp;?>">0</span>,00</h5>
                                     <p class="text-slate-500 dark:text-zink-200">Take Home Pay</p>
                                   </center>
                                       <br>
                                  



                                        <hr>
                                        <Br>
                                        <div class="col-span-12 md:order-2 xl:col-span-12 2xl:col-start-9 ">
                                            <table class="w-full">
                                               
                                                <tbody>
                                                    <tr>
                                                      
                                                        <td class="px-3.5 py-2.5 border-y">TKD Pokok</td>
                                                        <td class="px-3.5 py-2.5 border-y text-right">Rp. <span class="counter-value"  data-target="  <?php echo  $tkd_pokok ;?>">0</span> 
                                                        <span class="text-slate-500 dark:text-zink-200"> </span></td>
                                                       
                                                    </tr>
                                                    <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">Capaian Kinerja</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right"><?php echo $totalCapaian;?> 
                                                      <span class="text-slate-500 dark:text-zink-200">% </span></td>
                                                     
                                                  </tr>
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">TKD Bruto</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right">Rp. <?php echo rupiah($bruto);?> <span class="text-slate-500 dark:text-zink-200"> </span></td>
                                                     
                                                  </tr>
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">PPh21</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right">Rp.  <?php echo   rupiah($pph21) ;?> <span class="text-slate-500 dark:text-zink-200"> </span></td>
                                                     
                                                  </tr>
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">BPJS Kesehatan</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right">Rp.  <?php echo  rupiah($bpjs) ;?> <span class="text-slate-500 dark:text-zink-200"> </span></td>
                                                     
                                                  </tr>
                                                   
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">BPJS TK</td>
                                                      <td class="px-3.5 py-2.5 border-y border-transparent text-right">Rp. <?php echo rupiah($bpjs_tk) ;?> <span class="text-slate-500 dark:text-zink-200"> </span></td>
                                                     
                                                  </tr>
                                                      
                                                  <tr>
                                                      
                                                      <td class="px-3.5 py-2.5 border-y border-transparent">Total </td>
                                                      <td style="font-size: 20px; font-weight:bold;" class="px-3.5 py-2.5  border-y border-transparent text-right">Rp. <?php echo rupiah($thp) ;?> <span class="text-slate-500 dark:text-zink-200"> </span></td>
                                                     
                                                  </tr>
                                                </tbody>
                                            </table>

                                           
                                        </div>
                                            
                                </div>
                                <br>
                              
                           </div>

                        
                       </div>

              
                    
                    <div class="col-span-12 md:order-9 lg:col-span-6 lg:row-span-2 xl:col-span-4 xl:row-span-3 2xl:row-span-2 2xl:col-span-4 card">
                        
                        <div class="card-body">
                            <h6 class="mb-3 text-15 grow">Scheduled</h6>
                          
                            <div id="dncalendar-container"></div>


                            <br>
                            <div class="flex flex-col gap-4 mt-3">

                            <?php
                                $schdl = array();

                                for ($dl=0; $dl < count($pengajuan_dinas_luar) ; $dl++) { 
                                    $id_dl        = $pengajuan_dinas_luar[$dl]->id;
                                    $tgl        = $pengajuan_dinas_luar[$dl]->tanggal;
                                    $jns_dl     = $pengajuan_dinas_luar[$dl]->jns_dl;
                                    $keterangan = $pengajuan_dinas_luar[$dl]->keterangan;
                                    $status     = $pengajuan_dinas_luar[$dl]->status;

                                    if($jns_dl=='DLP'){
                                        $jenis_dl = 'DL-PENUH';
                                    }else if($jns_dl=='DLA'){
                                        $jenis_dl = 'DL-AWAL';
                                    }else{
                                        $jenis_dl = 'DL-AKHIR';
                                    }

                                    $date  = date('d', strtotime($tgl));
                                    $month =  date('M', strtotime($tgl));

                                    $schdl[] = array(
                                        'date' => $tgl,
                                        'note' => $jenis_dl.' - '.$keterangan

                                    );
                                    


                                    echo '<div class="flex gap-3">
                                            <div class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                            <h6>'. $date .'</h6> 
                                           
                                            <span class="text-sm text-slate-500 dark:text-zink-200">'.$month.'</span></div>
                                            <div class="grow">
                                                <h6 class="mb-1">'. $jenis_dl.'     <a href="'.base_url().'absensi/delete_pengajuan_dl/'.$id_dl.'" class="float-right text-red-500" > <i data-lucide="trash-2" style="font-size:10px"></i>  </a>  </h6>
                                                <p class="text-slate-500 dark:text-zink-200">'. $keterangan .'  </p>
                                             
                                            </div>
                                        </div>';
                                }


                                $status = '';
                                for ($c=0; $c < count($dataCuti); $c++) { 

                                    $id_cuti        = $dataCuti[$c]->id;
                                    $tgl_dari        = $dataCuti[$c]->tgl_dari;
                                   
                                    $alasan_cuti = $dataCuti[$c]->alasan_cuti;
                                    $jns_cuti = $dataCuti[$c]->jns_cuti;
                                    $hari_cuti     = $dataCuti[$c]->hari_cuti;

                                    $dateCuti  = date('d', strtotime($tgl_dari));
                                    $monthCuti =  date('M', strtotime($tgl_dari));


                                    if($jns_cuti==1){
                                        $cuti_jns = 'TAHUNAN';
                                    }else if($jns_cuti==1){
                                        $cuti_jns = 'BERHASIL';
                                    }else{
                                        $cuti_jns = 'SAKIT';
                                    }



                                    if($status=='APPROVE'){
                                        $class= 'bg-green-100 text-green-400 border-green ';
                                    }else{
                                        $class= 'bg-yellow-100 text-yellow-400 border-orange ';
                                    }

                                    if($hari_cuti==1){
                                        
                                            $date  = date('d', strtotime($tgl_dari));
                                            $month =  date('M', strtotime($tgl_dari));

                                            $schdl[] = array(
                                                'date' => $tgl_dari,
                                                'note' => $cuti_jns.' - '.$alasan_cuti

                                            );
                                            
                                        echo '<div class="flex gap-3">
                                                <div class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                                <h6>'. $dateCuti .'</h6>  
                                                <span class="text-sm text-slate-500 dark:text-zink-200">'.$monthCuti.'</span></div>
                                                <div class="grow">
                                                    <h6 class="mb-1">CUTI '. $cuti_jns.' </h6>
                                                    <p class="text-slate-500 dark:text-zink-200">'. $alasan_cuti .' </p>
                                                </div>
                                            </div>';
                                            
                                    }else{

                                          
                                        $listHari = $this->Cuti_model->getListHariCuti($id_cuti);

                                        //print_array($listHari);

                                        for ($l=0; $l < count($listHari) ; $l++) { 
                                            
                                            $dateCuti  = date('d', strtotime($listHari[$l]->tanggal));
                                            $monthCuti = date('M', strtotime($listHari[$l]->tanggal));


                                            $schdl[] = array(
                                                'date' => $listHari[$l]->tanggal,
                                                'note' => $cuti_jns.' - '.$alasan_cuti

                                            );

                                            echo '<div class="flex gap-3">
                                                    <div class="flex '. $class.' flex-col items-center justify-center  rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                                    <h6>'. $dateCuti .'</h6>  
                                                    <span class="text-sm text-slate-500 dark:text-zink-200">'.$monthCuti.'</span></div>
                                                    <div class="grow">
                                                        <h6 class="mb-1">CUTI '. $cuti_jns.' </h6>
                                                        <p class="text-slate-500 dark:text-zink-200">'. $alasan_cuti .' </p>
                                                    </div>
                                                </div>';
                                        }
                                       
                                    }
                                }
                              
                                //print_array($schdl);

                                for ($i=0; $i < count($dataIzinSakit); $i++) { 
                              
                                    $tgl_absen = $dataIzinSakit[$i]->tanggal;
                                    $date  = date('d', strtotime($tgl_absen));
                                    $month =  date('M', strtotime($tgl_absen));
                                    $keterangan = $dataIzinSakit[$i]->keterangan;
                                    $jenis_absen = $dataIzinSakit[$i]->jenis_absen;
                                 
                                    $periode_izin_sakit =date('Y-m', strtotime($tgl_absen)); 

                                    if($periode==$periode_izin_sakit){

                                        $schdl[] = array(
                                            'date' => $tgl_absen,
                                            'note' => $jenis_absen.' - '.$keterangan
    
                                        );


                                        echo '<div class="flex gap-3">
                                                <div class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                                <h6>'. $date .'</h6>  
                                                <span class="text-sm text-slate-500 dark:text-zink-200">'.$month.'</span></div>
                                                <div class="grow">
                                                    <h6 class="mb-1">'. $jenis_absen.' </h6>
                                                    <p class="text-slate-500 dark:text-zink-200">'. $keterangan .' </p>
                                                </div>
                                            </div>';
                                    }

                                 
                                }
                                $jsn_schdl = json_encode($schdl);
                               
                            ?>
                                
                             
                            </div>
                           
                        </div>
                    </div>

                    <div class="col-span-12 md:order-10 lg:col-span-4 xl:col-span-8 2xl:col-span-8 card">
                           <div class="card-body">
                            
                                <h6>Statistik Capaian Kinerja</h6>
                                <br>

                                <div id="deliveredRate" data-chart-colors='["bg-sky-500"]' dir="ltr" class="mt-4 grow apex-charts"></div> 
                            </div>
                    </div>
                  
                </div>

                    
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

      <?php $this->load->view('layout/footer');?>


    </div>

</div>
<!-- end main content -->


<div class="fixed items-center hidden bottom-6 right-12 h-header group-data-[navbar=hidden]:flex">
    <button data-drawer-target="customizerButton" type="button" class="inline-flex items-center justify-center w-12 h-12 p-0 transition-all duration-200 ease-linear rounded-md shadow-lg text-sky-50 bg-sky-500">
        <i data-lucide="settings" class="inline-block w-5 h-5"></i>
    </button>
</div>


                    <div id="cutiModal" modal-center=""  class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                        <div class="w-screen md:w-[25rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full" style="min-height: 500px;">
                            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                <h5 class="text-16" id="modal_heading">Pengajuan Cuti</h5>
                                <button data-modal-close="cutiModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                            </div>
                            
                                <div id="info_error" class="pb-3"></div>
                                    <div id="form_cuti">
                                    <form action="<?php echo base_url();?>cuti/check_date" method="post" id="check_date">
                                      <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                                            <div class="mb-3">
                                                <label>Tanggal Cuti</label>
                                                <input type="text" id="tgl_cuti" name="tgl_cuti" required class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" data-provider="flatpickr" data-date-format="d M Y" data-range-date="true" placeholder="Select Date">
                                            </div>

                                            <div class="mb-3">
                                                <label>Jenis Cuti</label>
                                                <select name="jns_cuti" id="jns_cuti"  class="form-input bg-white text-slate-600 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 ">

                                                        <?php

                                                        for ($c=0; $c < count($master_cuti); $c++) {
                                                            $id = $master_cuti[$c]->id;
                                                            $jenis_cuti = $master_cuti[$c]->jenis_cuti;

                                                            echo ' <option value="'. $id .'">'.$jenis_cuti .'</option>';

                                                        }
                                                    ?>
                                                </select>
                                            </div>

                                            
                                            <div class="mb-3">
                                                <label for="inputValue" class="inline-block text-base font-medium">Pengganti Cuti</label>
                                                <select id="choices-pengganti-cuti"  name="id_pengganti" data-choices="<?php echo set_value('id_pegawai');?>" data-choices-sorting-false="" <?= form_error('id_pengganti') ? 'is-invalid' : '' ?>>
                                                    <option value="">--Cari Nama Pengganti--</option>
                                                        <?php
                                                            for ($p=0; $p < count($listPegawaiPengganti) ; $p++) {
                                                            
                                                                $id_pegawai = $listPegawaiPengganti[$p]->id_pegawai;
                                                                $nama_pegawai = $listPegawaiPengganti[$p]->nama;
                                                            
                                                                echo '<option value="'.$id_pegawai.'" '.set_select('id_pengganti', $p).'>'.$nama_pegawai.'</option>';
                
                
                                                            }
                                                        ?>
                                                    
                                                    </select>
                                                    
                                                    
                                                    <?php  if(form_error('id_pengganti') != ''){
                                                    echo '<div class="invalid-feedback px-4 py-3 text-sm text-orange-500 border border-transparent rounded-md bg-orange-50 dark:bg-orange-400/20">'.form_error("id_pengganti").'</div>';}
                                                    ?>
                                                
                                                
                                                
                                            </div><!--end col-->

                                            <div class="mb-3">
                                                <label>Hak  Cuti yang digunakan:</label>
                                                
                                                    <select name="jns_hak_cuti" id="jns_hak_cuti" class="form-input bg-white text-slate-600 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 ">
                                                        <option value="2-<?php echo $sisaTahun2024;?>">Sisa Cuti tahun 2024 -  (<?php echo $sisaTahun2024;?>)</option>
                                                        <option value="4-<?php echo $sisaTahun2025;?>">Sisa Cuti tahun 2025  - (<?php echo $sisaTahun2025;?>) </option>

                                                </select>
                                            </div>

                                        <br>


                                            <button type="submit"  class="float-right ml-2 text-white btn bg-success border-success ">
                                                Selanjutnya
                                            </button>
                                            <button type="button" data-modal-close="cutiModal"  class="float-right  text-red-500 bg-red-100 btn hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20"> <i class="align-baseline ltr:pl-1 rtl:pr-1 ri-close-line"></i> Cancel</button>
                                            </div>
                                    </form>
                               </div>
                          
                          
                       </div>
                    </div><!--close modal form cuti-->


                <div id="actionModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                  <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                            <h5 class="text-16">Input Pengajuan Dinas Luar</h5>
                            <button data-modal-close="actionModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                                <i data-lucide="x" class="size-5"></i></button>
                        </div>
                        <div class="p-4">
                
                             <form action="<?php echo base_url(); ?>absensi/insertPengajuanDinasLuar" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                              
                             
                              
                                    <label for="tgl_dl" class="inline-block mb-2 text-base font-medium">Tanggal Dinas Luar</label>
                                    <input type="text" name="tgl_absen"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="tgl_absen_dl" value="" data-provider="flatpickr" data-date-format="d M Y" placeholder="Select Date">


                            
                                  <div class="xl:col-span-12 mt-3">

                                  
                                    <label for="keterangan" class="inline-block mb-2 text-base font-medium">Jenis Dinas Luar</label>
                                    <div class="flex items-center gap-2">
                                        <input id="radioInline1" required value="DLP" name="jns_dl" class="border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500" type="radio">
                                        <label for="radioInline1" class="align-middle">
                                            DL-PENUH
                                        </label>
                                            &nbsp;&nbsp;&nbsp;
                                        <input id="radioInline2" required value="DLA" name="jns_dl" class="border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500" type="radio">
                                        <label for="radioInline2" class="align-middle">
                                        DL-AWAL
                                        </label>
                                        &nbsp;&nbsp;&nbsp;
                                        <input id="radioInline3" required value="DLAK" name="jns_dl" class="border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500" type="radio">
                                        <label for="radioInline3" class="align-middle">
                                            DL-AKHIR
                                        </label>

                                    </div>
                                </div>

                                <div class="xl:col-span-12 mt-3">
                        
                                    <label for="keterangan" class="inline-block mb-2 text-base font-medium">Keterangan</label>
                                    <textarea name="keterangan" required id="keterangan" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"  rows="2" cols="10" wrap="soft"></textarea>
                                </div>
                                <div class="xl:col-span-12 mt-3">
                                    <div class="file-upload">
                                        <button type="button" class="file-upload-button text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                        <i class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> 
                                        Open Camera</button>
                                        <input type="file" accept="image/*" capture="camera" id="cameraInput" name="cameraInput">
                                        <span class="file-upload-name">No file chosen</span>
                                    </div>

                                    <img id="preview" src="#" alt="Image preview" style="display: none; max-width: 300px;">
                                    <br><br>
                                    <input type="hidden" id="latitude" name="latitude">
                                    <input type="hidden" id="longitude" name="longitude">
                                </div>
                                    <button type="submit" class="text-white float-right btn bg-success hover:text-white hover:bg-green-600 hover:border-custom-600 focus:text-white focus:bg-success-600 focus:border-success-600 focus:ring focus:ring-custom-100 active:text-white active:bg-success-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                        Kirim Pengajuan
                                </button>
                            </form>

                            <div class="clearfix"></div>

                            </div>
                        </div>


                        
                    </div>
                    <div class="flex items-center justify-between p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
                        
                    </div>
                </div>
            </div>


            
            <div id="sakitModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                  <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                    <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                        <h5 class="text-16">Input Pengajuan Sakit</h5>
                        <button data-modal-close="sakitModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                            <i data-lucide="x" class="size-5"></i></button>
                    </div>
                    <form action="<?php echo base_url(); ?>absensi/insertPengajuanIzinSakit" method="post" enctype="multipart/form-data" id="upload_file_pdf">
              
                        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">

                        

                                <div class="xl:col-span-6">
                                    <label for="tgl_absen" class="inline-block mb-2 text-base font-medium">Tanggal </label>
                                    <input type="text" name="tgl_absen"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="tgl_absen_dl" value="" data-provider="flatpickr" data-date-format="d M Y" placeholder="Select Date">
                                </div>   

                            <div>
                                <div class="xl:col-span-12 mt-3">
                        
                                    <label for="keterangan" class="inline-block mb-2 text-base font-medium">Keterangan</label>
                                    <textarea name="keterangan" required id="keterangan" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"  rows="2" cols="10" wrap="soft"></textarea>
                                </div>

                                
                                <div class="xl:col-span-12 mt-3">
                                <span class="text-slate-400">Pengajuan sakit harus disertai dengan surat keterangan yang menginformasikan bahwa pegawai dirawat atau istirahat</span> <br>
                                 <br>

                                          <div class="file-upload-izin bg-yellow-100">
                                             <h6>Lampirkan Surat Keterangan Izin/Sakit:</h6>
                                                    <p class="text-danger">
                                                        Jenis file yang diizinkan : <strong>JPG, PNG, JPEG </strong> <br>
                                                        Ukuran Maksimum File      : <strong>1 MB </strong> 
                                                    </p>


                                                <button type="button" class="mt-4 file-upload-button text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                                    <i class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> 
                                                    Buka File
                                                </button>

                                                <input type="file" accept="image/*"  id="file-input2"  name="ImageUpload">
                                                <span class="file-upload-name">No file chosen</span>
                                            </div>

                                            <img id="preview3" src="#" alt="Image preview" style="display: none; max-width: 300px;">
                                            <br><br>
                                  </div>
                                    <button type="submit" class="text-white float-right btn bg-success hover:text-white hover:bg-green-600 hover:border-custom-600 focus:text-white focus:bg-success-600 focus:border-success-600 focus:ring focus:ring-custom-100 active:text-white active:bg-success-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                        Kirim Pengajuan
                                </button>
                         
                            <div class="clearfix"></div>
                        </div>

                        </form>
                    </div>
                    <div class="flex items-center justify-between p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
                        
                    </div>
                </div>
            </div>




<?php $this->load->view('layout/theme_config');?>

<!--apexchart js-->
<script src="<?php echo base_url();?>assets/premium/libs/apexcharts/apexcharts.min.js"></script>

<script src="<?php echo base_url();?>assets/premium/js/pages/dashboards-hr.init.js"></script>
<?php $this->load->view('layout/mainjs');?>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/dncalendar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>





</body>

<script type="text/javascript">
		$(document).ready(function() {

            <?php if(count($penggantian_cuti) > 0){?>
            Toastify({
                    text: ' Pemberitahuan baru, Permohonan Pengganti cuti',
                    duration: 6000,
                    close: true,
                    className: "info",
                    gravity: "top", // `top` or `bottom`
                    position: "center", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right,rgb(204, 120, 10),rgb(220, 159, 30))",
                        color: "#FFF"
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
                <?php } ?>


            $('#check_date').submit(function() {
                    //$("#form_cuti").html('memeriksa tanggal');
                    $.ajax({
                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        success: function(msg) {
                            //ndow.location.reload();
                        /// $("#form_cuti").html(data);
                        if(msg==1){

                            $("#info_error").hide();

                            $.ajax({

                                    type:"POST",
                                    dataType:"html",
                                    url:"<?php echo base_url();?>cuti/form_cuti2/",
                                    data:"",
                                        success:function(msg){
                                            $("#form_cuti").html(msg);
                                        }

                                    });

                        
                        
                        }else{
                            $("#info_error").html(msg);
                        } 

                        }
                    })
                    return false;
                });

                
            });
                
		

    var status_upload = "<?php echo $status_upload;?>"; 
    var info_upload = "<?php echo $info;?>"; 

    if(status_upload==202){
       
            Toastify({
                    text: info_upload,
                    duration: 6000,
                    close: true,
                    className: "info",
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right,#e01d2d,rgb(169, 24, 31))",
                        color: "#FFF"
                    },
                    onClick: function(){} // Callback after click
                }).showToast();

            
        
        
    }else if(status_upload==200){
        Toastify({
                    text: info_upload,
                    duration: 6000,
                    close: true,
                    className: "info",
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "linear-gradient(to right,#27b060,#27b060)",
                        color: "#FFF"
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
    }
    


        $(".btn-sinkron").click(function(){
           // $(this).addClass("hidden");
            $(".loading-bg").show();

                $.ajax({

                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>admin/presensi/ajax_tarik_absensi",
                    data:"",
                    success:function(msg){
                        Toastify({
                                text: msg,
                                duration: 6000,
                                close: true,
                                className: "info",
                                gravity: "top", // `top` or `bottom`
                                position: "right", // `left`, `center` or `right`
                                stopOnFocus: true, // Prevents dismissing of toast on hover
                                style: {
                                    background: "linear-gradient(to right, #40aef9, #d841fa)",
                                    color: "#FFF"
                                },
                                onClick: function(){} // Callback after click
                            }).showToast();

                            // setTimeout(function(){
                            // window.location.reload(1);
                            // }, .3000);
                    
                    }

                    });

            });


        $("#bulan").change(function(){
            var bulan = $(this).val();

                $.ajax({

                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>admin/presensi/set_session_periode",
                        data:"bulan="+bulan,
                        success:function(msg){
                            window.location.reload();
                            //$("#modal-form").html(msg);
                            //console.log(msg);
                        }

                    });


        });

      

                    
            //email marketing chart
            var options = {
                series: [<?php echo  $persenInput;?>, <?php echo  $persenApprove;?>, <?php echo  $persenReject;?>],
                chart: {
                    height: 410,
                    type: 'radialBar',
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    horizontalAlign: 'center', 
                },
                plotOptions: {
                    radialBar: {
                        dataLabels: {
                            name: {
                                fontSize: '22px',
                            },
                            value: {
                                fontSize: '16px',
                            },
                            total: {
                                show: true,
                                label: 'Total Menit Input',
                                formatter: function (w) {
                                    return <?php echo $totalInput;?> 
                                }
                            }
                        },
                        track: {
                            margin: 14, 
                        }
                    }
                },
                colors: getChartColorsArray("emailMarketingChart"),
                labels: ['Input (%)', 'Disetujui', 'Ditolak'],
            };

            var chart = new ApexCharts(document.querySelector("#emailMarketingChart"), options);
            chart.render();


                            
                //Delivered Rate
                var options = {
                    series: [{
                        name: 'Capaian Kinerja',
                        data: <?php echo $list_capaian;?>
                    }],
                    chart: {
                        id: 'area-datetime',
                        type: 'bar',
                        height: 200,
                        sparkline: {
                            enabled: true
                        },
                        zoom: {
                            autoScaleYaxis: true
                        }
                    },
                    grid: {
                        show: true,
                        padding: {
                            top: -20,
                            right: -10,
                        }
                    },
                    xaxis: {
                        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    },
                    colors: getChartColorsArray("deliveredRate"),
                    stroke: {
                        width: 1,
                        curve: 'smooth',
                    },
                    dataLabels: {
                        enabled: true
                    },
                    legend: {
                        position: 'bottom',
                    },
                };
                var chart = new ApexCharts(document.querySelector("#deliveredRate"), options);
                chart.render();




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
          
                document.getElementById('file-input2').addEventListener('change', function(event) {
                    var file = event.target.files[0];
                    if (file) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('preview3').src = e.target.result;
                        document.getElementById('preview3').style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                    }
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
                
		</script>

</script>

</html>