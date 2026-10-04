<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <style>
       .clearfix{
           clear:both;
       }

       .delete_absensi{
        background-color: #e86874;
        border-radius: 3px;
        color: #FFF;
        padding: 10px 15px;
       }
   </style>
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $info = $this->session->flashdata('message');


                $id_pegawai = $detail_pegawai[0]->id_pegawai;
                $nip = $detail_pegawai[0]->nip;
                $pin = substr($nip, -4);
     
                $periode_bulan = $this->session->userdata('periode_bulan'); 
                $periode_tahun = $this->session->userdata('periode_tahun'); 
                
    
                if($periode_bulan=='') {
                    $bulan = date('m');
                    $tahun = date('Y');
      
                  }else{
                    $bulan = $periode_bulan;
                    $tahun = $periode_tahun;
                  }
    
                  
     
                $nm_bulan = getBulan($bulan);
                $periode = $tahun.'-'.$bulan;
                $periode = date('F Y', strtotime($periode));
  
     
                if (!empty($dataRekap)) {

                  $id_rekap = $dataRekap[0]->id;
                  $status = $dataRekap[0]->status;
                  
                  $telat = $dataRekap[0]->telat;
                  $pulang_awal = $dataRekap[0]->pulang_awal;
                  $sakit = $dataRekap[0]->sakit;
                  $izin = $dataRekap[0]->izin;
                  $cuti = $dataRekap[0]->cuti;
       
                 if($status==0){
                    $status_absen = '<div class="flex gap-1 px-4 py-3 text-sm text-orange-500 border border-orange-200 rounded-md md:items-center bg-orange-50 dark:bg-orange-400/20 dark:border-orange-500/50">
                                       <i data-lucide="check" class="size-3"></i> <span class="font-bold">Warning!</span>  Data absensi belum sesuai
                                    </div> ';
                  }else{
                    $status_absen = '<div class="flex gap-1 px-4 py-3 text-sm text-green-500 border border-green-200 rounded-md md:items-center bg-green-50 dark:bg-green-400/20 dark:border-green-500/50">
                                       <i data-lucide="check-check" class="size-3"></i> <span class="font-bold">Good!</span>  Data absensi sudah sesuai.
                                    </div>';
                  }

              
                }else{
                   $id_rekap =  0;
                  $telat = '-';
                  $pulang_awal = '-';
                  $sakit =  '-';
                  $izin =  '-';
                  $cuti = '-';
                  $status=0;
                   $status_absen = '<div class="flex gap-1 px-4 py-3 text-sm text-red-500 border border-red-200 rounded-md md:items-center bg-red-50 dark:bg-red-400/20 dark:border-red-500/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="alert-circle" class="lucide lucide-alert-circle h-4"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg> <span class="font-bold">Alert! </span> Data absensi belum direkap.
                                    </div>';
                 
                }
                
                
     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">


        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
         <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

                <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                    <div class="grow">
                        <h5 class="text-16">Main Attendance</h5>
                    </div>
                    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                            <a href="<?php echo base_url();?>admin/presensi/index_v3" class="text-slate-400 dark:text-zink-200">Absensi Pegawai</a>
                        </li>
                        <li class="text-slate-700 dark:text-zink-100">
                            Main Attendance
                        </li>
                    </ul>
                </div>
                <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-12">
                    <div class="xl:col-span-2">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center rounded-md size-12 text-sky-500 bg-sky-100 text-15 dark:bg-sky-500/20 shrink-0"><i data-lucide="users-2"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $telat;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200">Terlambat</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-2">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-md size-12 text-15 dark:bg-yellow-500/20 shrink-0"><i data-lucide="user-x-2"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $pulang_awal;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200">Pulang Awal</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-2">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center text-orange-500 bg-orange-100 rounded-md size-12 text-15 dark:bg-orange-500/20 shrink-0"><i data-lucide="user-check-2"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $sakit;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200">Sakit</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-2">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center text-orange-500 bg-orange-100 rounded-md size-12 text-15 dark:bg-orange-500/20 shrink-0"><i data-lucide="user-check-2"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $sakit;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200">Sakit Dengan Surat</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-2">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center text-orange-500 bg-orange-100 rounded-md size-12 text-15 dark:bg-orange-500/20 shrink-0"><i data-lucide="user-check-2"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $izin;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200">Izin</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-2">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center rounded-md size-12 text-custom-500 bg-custom-100 text-15 dark:bg-custom-500/20 shrink-0"><i data-lucide="briefcase"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $cuti;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200">Cuti</p>
                                </div>
                            </div>
                        </div>

                    </div><!--end col-->

                 
                </div>


                

             <div class="grid grid-cols-1 lg:grid-cols-12 xl:grid-cols-12 gap-x-5">
                    <div class="lg:col-span-12 xl:col-span-3 xl:row-span-2">
                       
                        <div class="card">
                            <div class="card-body">
                                <div class="text-center">
                                    <div class="mx-auto rounded-full size-20 bg-slate-100 dark:bg-zink-600">
                                        <img src="<?php echo base_url();?>assets/images/user-4.jpg" alt="" class="h-20 rounded-full">
                                    </div>
                                    <h6 class="mt-3 mb-1 text-16"><a href="#!"><?php echo $detail_pegawai[0]->nama;?></a></h6>
                               
                                </div>

                                <?php
                               //  print_array($detail_pegawai);
                                ?>
                                <div class="mt-5 overflow-x-auto">
                                    <table class="w-full mb-0">
                                        <tbody>
                                            <tr>
                                                <td class="px-3.5 py-2.5 first:pl-0 last:pr-0 border-y border-transparent text-slate-500 dark:text-zink-200">NIP</td>
                                                <td class="px-3.5 py-2.5 first:pl-0 last:pr-0 border-y border-transparent font-semibold"><?php echo $detail_pegawai[0]->nip;?></td>
                                            </tr>
                                            
											<tr>
                                                <td class="px-3.5 py-2.5 first:pl-0 last:pr-0 border-y border-transparent text-slate-500 dark:text-zink-200">Jabatan</td>
                                                <td class="px-3.5 py-2.5 first:pl-0 last:pr-0 border-y border-transparent font-semibold"><?php echo $detail_pegawai[0]->jabatan;?></td>
                                            </tr>
                                            
											<tr>
                                                <td class="px-3.5 py-2.5 first:pl-0 last:pr-0 border-y border-transparent text-slate-500 dark:text-zink-200">Puskesmas</td>
                                                <td class="px-3.5 py-2.5 first:pl-0 last:pr-0 border-y border-transparent font-semibold"><?php echo $detail_pegawai[0]->puskesmas;?></td>
                                            </tr>
                                            
											<tr>
                                                <td class="px-3.5 py-2.5 first:pl-0 last:pr-0 border-y border-transparent text-slate-500 dark:text-zink-200">TMT</td>
                                                <td class="px-3.5 py-2.5 first:pl-0 last:pr-0 border-y border-transparent font-semibold"><?php echo $detail_pegawai[0]->tmt;?></td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                  
                    <?php

                        $list_bulan = array_bulan();

                         $periode_bulan = $this->session->userdata('periode_bulan'); 
                            $periode_tahun = $this->session->userdata('periode_tahun'); 
                            $id_pkm_sess   = $this->session->userdata('id_pkm');
                
                          
                            if($periode_bulan=='') {
                                $bulan = date('m');
                                $tahun = date('Y');
                  
                              }else{
                                $bulan = $periode_bulan;
                                $tahun = $periode_tahun;
                              }
                
                              
                 
                            $nm_bulan = getBulan($bulan);
                            $periode = $tahun.'-'.$bulan;
                            $periode = date('Y-m', strtotime($periode));
                
                
                            $lastDate = date('t', strtotime($periode)) + 1;
                
                            $id_pegawai = $this->uri->segment(4);
                
                            $nip = $detail_pegawai[0]->nip;
                            $shift = $jns_jam_kerja= $detail_pegawai[0]->jns_jam_kerja;
                            $nama_pegawai = $detail_pegawai[0]->nama;
                            $id_puskesmas = $detail_pegawai[0]->id_puskesmas;
                         
                            $puskesmas = $this->Presensi_model->getNamaPuskesmas($id_puskesmas);
                            $message = $this->session->flashdata('message');
                
                
                            $pin = substr($nip, -4);
						
						
                        ?>


                    <div class="xl:col-span-9 lg:col-span-12">
                        <div class="card">
                            <div class="card-body">
							<h4>	Data Absensi</h4>
							<br>

                            <?php echo $status_absen;?>
                            <br>
                                <div class="grid grid-cols-1 gap-4 mb-5 lg:grid-cols-2 xl:grid-cols-12">
                               
                                    <div class="xl:col-span-3">
										
                                    <div>
										
                                        <select  name="bulan" id="bulan">
                                                <option value="">Bulan</option>
                                                <?php
                                                    for ($b=0; $b < count($list_bulan) ; $b++) { 

                                                        $no_bulan = $b+1;

                                                        if($bulan_choice == $no_bulan){
                                                            $selc = 'selected';
                                                        }else{
                                                            $selc = '';
                                                        }
                                                        

                                                        echo '<option value="'.$no_bulan.'" '.$selc.'>'.$list_bulan[$b].'</option>';
                                                    }
                                                    ?>
                                            </select>
                                        </div>
                                    </div><!--end col-->
                                    <div class="flex justify-end gap-2 text-right lg:col-span-9 xl:col-span-9 xl:col-start-8">

                                        <button type="button" class="loading-update hidden flex items-center text-slate-500 btn bg-slate-100 border-slate-200 hover:text-white hover:bg-slate-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                            <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewbox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                        loading....
                                        </button>

                                    
                                    <button type="button" data-modal-target="loading_update" value="<?php echo $id_rekap;?>" type="button" class="text-green btn-check-ok btn bg-green-200 border-green-200 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-success-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-orange-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                                        <i data-lucide="check" class="inline-block size-4"></i> <span class="align-middle">Check Sesuai</span>
                                    </button>
                                  
                                        <a href="<?php echo base_url();?>admin/presensi/update_data_rekap/<?php echo $pin.'/'.$id_pegawai;?>" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                        <i data-lucide="check" class="inline-block size-4"></i>  Update Rekap</a>
                                    <!-- <a href="<?php echo base_url();?>admin/presensi/list_absensi/<?php echo $pin.'/'.$id_pegawai;?>" class="text-white btn bg-slate-500 border-slate-500 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/20">List Absensi</a> -->
                                        <a href="<?php echo base_url();?>admin/presensi/tarik_absensi/<?php echo $pin.'/'.$id_pegawai;?>" class="tarik_absensi text-dark btn bg-slate-100 border-slate-200 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/20">
                                        <i data-lucide="download" class="inline-block size-4"></i> Tarik Absensi</a>  

                                        <a href="<?php echo base_url();?>admin/presensi/updateShiftBulanan/<?php echo $id_pegawai.'/'.$pin.'/'.$periode;?>" class="tarik_absensi text-dark btn bg-slate-100 border-slate-200 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/20">
                                        <i data-lucide="upload" class="inline-block size-4"></i> Update Shift</a>  


                                    </div>
                                </div><!--end grid-->
                                <div class="overflow-x-auto">
                                     <table class="w-full whitespace-nowrap">
                                        <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                                                <tr>
                                                        
                                                        <th class="px-3.5 py-2.5 font-semibold border border-slate-200 dark:border-zink-500 text-center"> Tanggal</th>
                                                        <th class="px-3.5 py-2.5 font-semibold border border-slate-200 dark:border-zink-500 text-center">Hari</th>
                                                        <th class="px-3.5 py-2.5 font-semibold border border-slate-200 dark:border-zink-500 text-center">Shift</th>
                                                       
                                                        <th class="px-3.5 py-2.5 font-semibold border border-slate-200 dark:border-zink-500 text-center">Absen Masuk</th>
                                                        <th class="px-3.5 py-2.5 font-semibold border border-slate-200 dark:border-zink-500 text-center">Absen Keluar</th>
                                                        <th class="px-3.5 py-2.5 font-semibold border border-slate-200 dark:border-zink-500 text-center"> Telat</th>
                                                        <th class="px-3.5 py-2.5 font-semibold border border-slate-200 dark:border-zink-500 text-center">Pulang Awal</th>
                                                        <th class="px-3.5 py-2.5 font-semibold border border-slate-200 dark:border-zink-500">Keterangan</th>
                                                </tr>
                                        </thead>
                                        <tbody>
                                               <?php
                    
                                                     $tgl_now = date('Y-m-d');
                                            
                                                      $totalTelat = 0;
                                                      $totalPawal = 0;  

                                                      $totalIzin = 0;
                                                      $totalSakit = 0;
                                                      $totalCuti = 0;


                                                  for ($t = 1; $t < $lastDate; $t++) {
                                                      $tanggal = $periode . '-' . $t;
                                                      $formatDate = date('Y-m-d', strtotime($tanggal));
                                                      $day = date('l', strtotime($tanggal));
                                                      $hari = getNamahari($tanggal);

                                                      $absensiHarian  = $this->Presensi_model->getDataAbsensi($pin, $formatDate);
                                                      if(!empty($absensiHarian)){
                                                         $id         = $absensiHarian[0]->id;
                                                          $kodeShift         = $absensiHarian[0]->shift;
                                                          $jamMasukKerja     = $absensiHarian[0]->jam_masuk;
                                                          $jamKeluarKerja    = $absensiHarian[0]->jam_pulang;
                                          
                                                          $absenMasuk         = $absensiHarian[0]->masuk;
                                                          $absenPulang        = $absensiHarian[0]->pulang;
                                                          $keterangan_absen   = $absensiHarian[0]->keterangan;

                                                          $telat         = $absensiHarian[0]->telat;
                                                          $p_awal         = $absensiHarian[0]->p_awal;
                                                      }else{
                                                        $id         = 0;
                                                          $kodeShift         = 'N/A';
                                                          $jamMasukKerja      = '';
                                                          $jamKeluarKerja    = '';
                                          
                                                          $absenMasuk        = '';
                                                          $absenPulang        = '';
                                                          $keterangan_absen   = '';

                                                          $telat         = 0;
                                                          $p_awal         = 0;

                                                      }




                                                      if($jns_jam_kerja == 'non_shift'){

                                                            //khusus untuk yang jam kerjanya shift
                                                             if($hari != 'Sabtu' && $hari != 'Minggu'){

                                                            
                                                                if($absenMasuk=='' && $jamMasukKerja != '' && $formatDate < $tgl_now ){
                                                                    $absenMasuk = '<button class="btn-info-absensi px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent" value="'.$pin.'/'.$id_pegawai.'/'.$tanggal.'"
                                                                    data-modal-target="extraLargeModal">ALPHA</button>';
                                                                    $telat          = 300;
                                                                }

                                                                
                                                                if($absenPulang=='' && $jamKeluarKerja != ''  && $formatDate < $tgl_now ){
                                                                    $absenPulang = '<button class="btn-info-absensi px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent" value="'.$pin.'/'.$id_pegawai.'/'.$tanggal.'"
                                                                    data-modal-target="extraLargeModal">ALPHA</button>';
                                                                    $p_awal         = 150;
                                                                }


                                                            }

                                                                
                                                            $hariLibur = $this->Presensi_model->cekHariLibur($tanggal);
                                                            $hari_libur = false;
                                                            if(!empty($hariLibur )){
                                                                    $kodeShift         = '';
                                                                    $jamMasukKerja     = '-';
                                                                    $jamKeluarKerja    = '-';
                                                    
                                                                    $absenMasuk         = '<span class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:border-transparent">LIBUR NASIONAL</span>';
                                                                    $absenPulang        =  '<span class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:border-transparent">LIBUR NASIONAL</span>';
                                                                    $keterangan_absen   = $hariLibur[0]->keterangan;

                                                                    
                                                                    $telat          = 0;
                                                                    $p_awal         = 0;
                                                                    $hari_libur = true;


                                                            }
                                                      }else{ // shift2an
                                                          if($kodeShift=='P' || $kodeShift=='S' || $kodeShift=='PS'){

                                                                
                                                                if($absenMasuk==''){
                                                                $absenMasuk = '<button class="btn-info-absensi px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent" value="'.$pin.'/'.$id_pegawai.'/'.$tanggal.'"
                                                                    data-modal-target="extraLargeModal">ALPHA</button>';
                                                                $telat         = 300;
                                                                }

                                                              if($absenPulang==''){
                                                                $absenPulang = '<button class="btn-info-absensi px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent" value="'.$pin.'/'.$id_pegawai.'/'.$tanggal.'"
                                                                    data-modal-target="extraLargeModal">ALPHA</button>';
                                                                $p_awal         = 150;
                                                              }
                                                           
                                                          }

                                                          if($kodeShift=='L-OFF'){
                                                            
                                                            if($absenPulang==''){
                                                              $absenPulang = '<button class="btn-info-absensi px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent" value="'.$pin.'/'.$id_pegawai.'/'.$tanggal.'"
                                                                    data-modal-target="extraLargeModal">ALPHA</button>';
                                                              $p_awal         = 150;
                                                            }
                                                          }
                                                            
                                                          if($kodeShift=='SM' ||$kodeShift=='M' ||$kodeShift=='PSM'){
                                                            if($absenMasuk=='' && $jamMasukKerja != '' ){
                                                              $absenMasuk = '<button class="btn-info-absensi px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent" value="'.$pin.'/'.$id_pegawai.'/'.$tanggal.'"
                                                                    data-modal-target="extraLargeModal">ALPHA</button>';
                                                              $telat          = 300;
                                                              $bg_btn = 'px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-custom-100 border-transparent text-custom-500 dark:bg-custom-500/20 dark:border-transparent';
                                                            }

                                                          }



                                                      }//close if juam kerja == shift


                                                      if($kodeShift=='OFF'){
                                                          $jamMasukKerja  = '';
                                                          $jamKeluarKerja  = '';
                                                          $bg_btn = 'px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent';
                                                        
                                                      }else if($kodeShift=='L-OFF'){
                                                        
                                                          $bg_btn = 'px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent';
                                                          $jamMasukKerja  = '-';
                                                         

                                                      }else if($kodeShift=='N/A'){
                                                        
                                                        $bg_btn = 'px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-slate-100 border-transparent text-slate-500 dark:bg-slate-500/20 dark:border-transparent';
                                                        $jamMasukKerja  = '-';
                                                       

                                                    }else{
                                                        
                                                       
                                                        $bg_btn = 'px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-custom-100 border-transparent text-custom-500 dark:bg-custom-500/20 dark:border-transparent';
                                                      }

                                                      if($jamKeluarKerja=='00:00:00'){
                                                        $jamKeluarKerja  = '-';
                                                      }

                                                      if ($absenMasuk =='CUTI') {
                                                          $absenMasuk         = '<button class="info-cuti px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent status" value="'.$pin.'/'.$id_pegawai.'/'.$id.'"
                                                             data-modal-target="infoAbsen">CUTI</button>';
                                                          $absenPulang        =  '<button class="info-cuti px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent status" value="'.$pin.'/'.$id_pegawai.'/'.$id.'"
                                                             data-modal-target="infoAbsen">CUTI</button>';
                                                        }

                                                       if ($absenMasuk =='DLP') {
                                                          $absenMasuk         = '<button class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-purple-100 border-transparent text-purple-500 dark:bg-purple-500/20 dark:border-transparent status"  data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >DLP</button>';
                                                          $absenPulang        =  '<button class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-purple-100 border-transparent text-purple-500 dark:bg-purple-500/20 dark:border-transparent status" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >DLP</button>';
                                                        }

                                                        if ($absenMasuk =='IZIN') {
                                                          $absenMasuk         = '<button class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent status"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >IZIN</button>';
                                                          $absenPulang        =  '<button class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent status"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >IZIN</button>';
                                                        }

                                                        if ($absenPulang =='DLAK') {
                                                         
                                                            $absenPulang        =  '<button class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-purple-100 border-transparent text-purple-500 dark:bg-purple-500/20 dark:border-transparent status">DLAK</button>';
                                                        }
                                                        if ($absenMasuk =='DLA') {
                                                         
                                                            $absenMasuk        =  '<button class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-purple-100 border-transparent text-purple-500 dark:bg-purple-500/20 dark:border-transparent status">DLAK</button>';
                                                        }

                                                        
                                                        if($absenMasuk =='SAKIT') {
                                                            $absenMasuk         = '<button class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent status"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >SAKIT</button>';
                                                            $absenPulang        =  '<button class="px-2.5 py-0.5 inline-flex items-center text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent status"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >SAKIT</button>';
                                                            }



                                                      $totalTelat = $totalTelat+$telat;
                                                      $totalPawal = $totalPawal+$p_awal;
              

                                                          echo '  <tr>
                                                                          <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center">' . $t . '</td>
                                                                          <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center">' . $hari . '</td>
                                                                          <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center"> 
                                                                           <button type="button" data-modal-target="largeModal" id="'.format_view($tanggal).'" class="'.$bg_btn .' btn_change_shift " value="'.format_view($tanggal).'" style="font-size:12px">
                                                                            '. $kodeShift.'
                                                                            </button>                                                                        
                                                                           </td>
                                
                                                                          <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center">'.$absenMasuk;
                                                                          if($absenMasuk == ''){
                                                                            echo '<button class="btn-hover-show"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg"><i class="fa-solid fa-pencil"></i></button>';
                                                                          }else{
                                                                            echo '<a href="'.base_url().'admin/presensi/delete_absensi/'.$tanggal.'/'.$pin.'/'.$id_pegawai.'/0" class="float-end hover-show"><i class="fa-solid fa-trash"></i></a>';
                                                                          }

                                                                          echo '</td>
                                                                          <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center">'.$absenPulang;

                                                                          if($absenPulang != ''){
                                                                            echo '<a href="'.base_url().'admin/presensi/delete_absensi/'.$tanggal.'/'.$pin.'/'.$id_pegawai.'/1" class="float-end hover-show"><i class="fa-solid fa-trash"></i>  </a>';
                                                                          }else{
                                                                            echo '<button class="btn-hover-show"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg"><i class="fa-solid fa-pencil"></i></button>';
                                                                          }

                                                                        
                                                                          echo '</td>
                                                                          <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center">'.$telat.'</td>
                                                                          <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center">'. $p_awal.'</td>
                                                                          <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500">'. $keterangan_absen.'</td>
                                                                         
                                                                          
                                                              </tr>';
                  
                                                              

                                                              

                                                  }


                                                  ?>
                                                <tr>
                                                    <td colspan="5" class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center"></td>
                                                    <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center"><?php echo $totalTelat ;?></td>
                                                    <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center"><?php echo $totalPawal ;?></td>
                                                    <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center"></td>
                                                    <td class="px-3.5 py-2.5 border border-slate-200 dark:border-zink-500 text-center"></td>
                                                
                                                </tr>
						
										</tbody>
                                    </table>
                                </div>

                                <div id="extraLargeModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                                    <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                                        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                                <h5 class="text-16">Detail Absensi</h5>
                                            <button data-modal-close="extraLargeModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                                        </div>
                                        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto" id="modal-form">
                                          
                                        </div>
                                      
                                    </div>
                                </div>
                               
                           
                                <div id="largeModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                                    <div class="w-screen md:w-[40rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                                        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                            <h5 class="text-16">Ubah Shift kerja</h5>
                                            
                                            <button data-modal-close="largeModal" id="closeModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                                        </div>
                                        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto" id="modal-info">
                                            
                                            <form method="post" action="<?php echo base_url();?>admin/presensi/update_shift_v2/<?php echo $pin.'/'.$id_pegawai;?>" id="update_shift">
                                               Tanggal :  <input type="text" name="tanggal"  value="" id="tgl_shift">
                                               <br><br>
                                                <div class="flex flex-wrap gap-2">

                                                <table class="w-full whitespace-nowrap">
                                                    <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                                                            <tr>
                                                                    
                                                                <th class="px-3.5 py-2.5 font-semibold border border-slate-200 text-center"> Kode Shift </th>
                                                                <th class="px-3.5 py-2.5 font-semibold border border-slate-200 text-center">Nama Shift</th>
                                                                
                                                            
                                                            </tr>
                                                    </thead>
                                                    <tbody>
                                                     <?php
        
        
                                                        for ($i=0; $i < count($data_shift_kerja) ; $i++) { 
                                                                $kode_shift = $data_shift_kerja[$i]->kode_shift;
                                                                $nama_shift = $data_shift_kerja[$i]->nama_shift;
                                                                
                                                                if($kode_shift=='L-OFF'){
                                                                    $class_text = 'style="color:orange"';
                                                                    $checked_class= 'text-orange-500 btn bg-orange-100 hover:text-white hover:bg-orange-600 focus:text-white focus:bg-orange-600 focus:ring focus:ring-orange-100 active:text-white active:bg-orange-600 active:ring active:ring-orange-100 dark:bg-orange-500/20 dark:text-orange-500 dark:hover:bg-orange-500 dark:hover:text-white dark:focus:bg-orange-500 dark:focus:text-white dark:active:bg-orange-500 dark:active:text-white dark:ring-orange-400/20';
                                                                }else if($kode_shift=='OFF'){
                                                                    $checked_class= 'text-red-500 btn bg-red-100 hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20';
                                                                }else{
                                                                     $class_text = 'style="color:#5484cc"';
                                                                     $checked_class = 'text-custom-500 btn hover:text-custom-500 hover:bg-custom-200 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20';
                                                                }
                                                                echo '
                                                                   <tr>
                                                                        <td class="px-3.5 py-2.5 border border-slate-200 text-center"> 
                                                                         <button type="button" class="'. $checked_class.' checkshift" value="'.$kode_shift.'">'.$kode_shift.'</button> </td>
                                                                        <td class="px-3.5 py-2.5 border border-slate-200 text-left">'.$nama_shift.'</td>
                                                                       
                                                                
                                                                   </tr>
                                                                ';
        
        
                                                              
                                                            
                                                        }
                                                    ?>
                                                     </tbody>
                                                    </table>
                                                
                                                </div>
                                            
                                            <br>
                                            <button id="btn_submit" style="display:none" type="submit" class="my-4 float-right text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Simpan</button>
                                            
                                            </form>
                                        </div>
                                        
                                     
                                    </div>
                                </div>



                        </div>
                    </div><!--end col-->
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


<div id="infoAbsen" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
    <div class="w-screen md:w-[40rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
            <h5 class="text-16">Absensi Cuti</h5>
            <button data-modal-close="infoAbsen" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
        </div>
        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto" id="modalinfocuti">
                                                        
           

            <div id="btn_delete_absensi"></div>                                            

        </div>
        <div class="flex items-center justify-between p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
            <h5 class="text-16">Modal Footer</h5>
        </div>
    </div>
</div>


<div class="fixed items-center hidden bottom-6 right-12 h-header group-data-[navbar=hidden]:flex">
    <button data-drawer-target="customizerButton" type="button" class="inline-flex items-center justify-center w-12 h-12 p-0 transition-all duration-200 ease-linear rounded-md shadow-lg text-sky-50 bg-sky-500">
        <i data-lucide="settings" class="inline-block w-5 h-5"></i>
    </button>
</div>


<?php $this->load->view('layout/theme_config');?>
<?php $this->load->view('layout/mainjs');?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

<script>
    $(document).ready(function() {

        var info = '<?php echo $info;?>';

        if(info=='gagal'){
            message = 'Input Absen gagal! tanggal tidak boleh kosong';
            bg = '#F00';
        }else{
            message = 'Input Absen berhasil! ';
            bg = '#2f8f4c';
        }

          Toastify({
                    text: message,
                    duration: 3000,
                    close: true,
                    className: "info",
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: bg,
                        color: "#FFF"
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
        

                

        $(".tarik_absensi").click(function(){
            $(this).addClass("hidden");
            $(".loading-update").removeClass("hidden");


                Toastify({
                        text: 'Sinkroning data absensi',
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
            

        });

        $(".btn-info-absensi").click(function(){

            var data_post = $(this).val();
            $.ajax({

                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>admin/presensi/ajax_detail_absensi",
                    data:"data_post="+data_post,
                    success:function(msg){
                        $("#modal-form").html(msg);
                    }

                });

            });


            $(".info-cuti").click(function(){
                var data_post = $(this).val();
        
                var linkDelete = "<?php echo base_url();?>admin/presensi/delete_absensi_cuti";

                var btn = '<a href="'+linkDelete+'/'+data_post+'" class="delete_absensi">Delete Absensi</a>';

              //  alert(data_post);;
                $("#btn_delete_absensi").html(btn);
            });


              
        $(".btn-info-absensi").click(function(){

            var data_post = $(this).val();
            $.ajax({

                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>admin/presensi/ajax_detail_absensi",
                    data:"data_post="+data_post,
                    success:function(msg){
                        $("#modalinfocuti").html(msg);
                    }

                });

            });

        
          $('.btn_change_shift').click(function() {
              
              var tanggal = $(this).val();
              $("#tgl_shift").val(tanggal);

              $(".checkshift").prop('checked', false);

          }); 
        
        $('.checkshift').click(function() {
           
            var shift     = $(this).val();
            var pin       = '<?php echo $pin;?>';
            var tanggal   = $("#tgl_shift").val();

          

             $.ajax({
                
                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>admin/presensi/update_shift_pegawai",
                        data:"pin="+pin+"&tanggal="+tanggal+"&shift="+shift,
                        success:function(msg){
                            //$("#modalinfocuti").html(msg);
                           
                            Toastify({
                                    text: 'Data shift berhasil diubah',
                                    duration: 6000,
                                    close: true,
                                    className: "info",
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "linear-gradient(to right, #25ad4e, #31cd5a)",
                                        color: "#FFF"
                                    },
                                    onClick: function(){} // Callback after click
                                }).showToast();
                               

                                
                        }

                      
                      
                });
              
                $("#"+tanggal).html(shift);
                $("#closeModal").trigger("click");
            // if ($(this).is(':checked')) {
            //     console.log('Checkbox is checked');
            //     //$("#btn_submit").show();
            //     // Tambahkan tindakan lain yang ingin dilakukan ketika checkbox dicentang
            // } else {
            //     console.log('Checkbox is not checked');
            //      // $("#btn_submit").slideUp();
            //     // Tambahkan tindakan lain yang ingin dilakukan ketika checkbox tidak dicentang
            // }
        });


        $(".btn-check-ok").click(function(){
              
              $("#list_info_data_rekap").html('<div class="inline-block border-2 rounded-full size-8 animate-spin border-l-transparent border-sky-500"></div>');
              
              var id_rekap = $(this).val();
              
              $.ajax({
    
                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>admin/presensi/check_ok2",
                        data:"id_rekap="+id_rekap,
                        success:function(msg){
                          $("#list_info_data_rekap").html(msg);
                          
                          setTimeout(function(){
                               window.location.reload();
                            }, 1000);
                        }
    
                  });

          });

});


</script>
</html>