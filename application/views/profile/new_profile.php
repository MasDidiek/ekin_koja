<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">


   <style>
    .w3-light-grey{
        background-color: #EEE;
    }
    .w3-blue{
        background-color: #4696e0;
    }

    .readonly{
        background-color: #F8F8F8;
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


   </style>
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $info = $this->session->flashdata('message');
       $message_status = $this->session->flashdata('message_status');

          
       $list_bulan = array_bulan();
       $arayJenis = getListJnsDiklat();

        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');
        $id_pkm_sess   = $this->session->userdata('id_pkm');
        $id_pj_sess = $this->session->userdata('id_pj');
        $id_user_validator   = $this->session->userdata('id_pegawai');

        if($periode_bulan=='') {
        $bulan = date('m');
        $tahun = date('Y');

        }else{
            $bulan = $periode_bulan;
            $tahun = $periode_tahun;
        }

        $periode = $tahun.'-'.$bulan;
        $periode = date('Y-m', strtotime($periode));

        $nm_bulan = getBulan($bulan);

        $nip = $pegawai[0]->nip;

        $detailPegawai = $this->Pegawai_model->getDataDetailPegawai($nip);

       

     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

              <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                  <div class="grow">
                      <h5 class="text-16">Pegawai</h5>
                  </div>
                  <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                      <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                          <a href="#!" class="text-slate-400 dark:text-zink-200">Pegawai</a>
                      </li>
                      <li class="text-slate-700 dark:text-zink-100">
                      Detail Pegawai
                      </li>
                  </ul>
              </div>

        <?php


            //print_array($rekap_capaian_kinerja);

          $id_pegawai = $pegawai[0]->id_pegawai;
          $tgl_masuk = $pegawai[0]->tgl_masuk;
          $nip = $pegawai[0]->nip;
          $nama_pegawai = $pegawai[0]->nama;
          $photo = $this->Pegawai_model->getPhotoPegawai($nip);

          if($photo==''){
            $photo = 'avatar.png';
          }

          $arrayTelat = array();
          $totalTelat = 0;
          for ($r=0; $r < 12; $r++) { 

                $periode = @$rekap_absensi[$r]->periode;
                $telat   = @$rekap_absensi[$r]->telat;

                if($periode==''){
                    $telat = 0;

                }

                $totalTelat = $totalTelat+$telat;

               array_push($arrayTelat, $telat);
          }

          $json_telat = json_encode($arrayTelat);


         
          $totalIzin = 0;
          $totalSakit = 0;
          $totalCuti = 0;
          for ($r=0; $r < 12; $r++) { 

                $periode = @$rekap_absensi[$r]->periode;
                $izin   = @$rekap_absensi[$r]->izin;
                $sakit   = @$rekap_absensi[$r]->sakit;
                $cuti   = @$rekap_absensi[$r]->cuti;

                if($periode==''){
                    $izin = 0;
                    $sakit = 0;
                    $cuti = 0;

                }

                $totalIzin = $totalIzin+$izin;
                $totalSakit = $totalSakit+$sakit;
                $totalCuti = $totalCuti+$cuti;

          }

          
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

      //  print_array($pegawai);

        $capaianTerkecil = min($listCapaian);
        $min = $capaianTerkecil-1;

        $list_capaian = json_encode($listCapaian);
        $bulanCapaian = json_encode($listBulanCapaian);

     
            $status_kawin  = $pegawai[0]->status_kawin;
            $status_pajak  = $pegawai[0]->status_pajak;
            $id_pendidikan = $pegawai[0]->id_pendidikan;
            
            $pendidikan = $this->Master_model->getNamaPendidikan($id_pendidikan);

            if($status_kawin==1){
                $status_nikah = 'K3 (Menikah + 2 anak)';
            }else if($status_kawin==2){
                $status_nikah = 'K2 (Menikah + 1 anak)';
            }else if($status_kawin==3){
                $status_nikah = 'K1 (Menikah + 0 anak)';
            }else{
                $status_nikah = 'K0 (Belum Menikah)';
            }
           

            $gaji_pokok = $pegawai[0]->gaji_pokok;
            $pengkalian = $pegawai[0]->pengkalian;
            $status_kerja= $pegawai[0]->status_kerja;
            
            
             $checkAktif = '';
             $checkCuti = '';
             $checkNonAktif = '';
             
            if($status_kerja==1){
                $checkAktif = 'checked';
            }
            
            if($status_kerja==2){
                $checkCuti = 'checked';
            }
            
            if($status_kerja==3){
                $checkNonAktif = 'checked';
            }
            

            $tkd_pokok  = $gaji_pokok*$pengkalian;


            $tmt = $pegawai[0]->tmt;
            $today = date('Y-m-d');

            $masa_kerja = hitungMasaKerja($tmt, $today);

            $detailPegawai = $this->Pegawai_model->getDataDetailPegawai($nip);


                    
            $sisaTahunLalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
            $sisaTahunIni = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');
            $sisaCuber = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 3, 'DESC');

            $sisaCutiAll = $sisaTahunLalu+$sisaTahunIni+$sisaCuber;
        ?>
              <div class="mt-1 -ml-3 -mr-3 rounded-none card">
                    <div class="card-body !px-2.5">
                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-12 2xl:grid-cols-12">
                            <div class="lg:col-span-2 2xl:col-span-1">
                                <div class="relative inline-block rounded-full shadow-md size-10 bg-slate-100 profile-user xl:size-28">
                                    <img src="<?php echo base_url().'uploads/photo_profile/'.$photo;?>" alt="" class="object-cover border-0 rounded-full img-thumbnail user-profile-image">
                                    <div class="rounded-full size-8 ltr:right-0 rtl:left-0 profile-photo-edit">
                                       <input id="profile-img-file-input" type="file" class="hidden profile-img-file-input">
                                         <!-- <label for="profile-img-file-input" class="flex items-center justify-center bg-white rounded-full shadow-lg cursor-pointer size-8 dark:bg-zink-600 profile-photo-edit">
                                            <i data-lucide="image-plus" class="size-4 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-500"></i>
                                        </label> -->

                                       
                                    </div>

                                   
                                </div>
                            </div><!--end col-->
                            <div class="lg:col-span-4 2xl:col-span-5">
                                <h5 class="mb-1"><?php echo $nama_pegawai;?> <i data-lucide="badge-check" class="inline-block size-4 text-sky-500 fill-sky-100 dark:fill-custom-500/20"></i></h5>
                                <div class="flex gap-3 mb-4">
                                    <p class="text-slate-500 dark:text-zink-200"><i data-lucide="user-circle" class="inline-block size-4 ltr:mr-1 rtl:ml-1 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-500"></i> <?php echo $pegawai[0]->jabatan;?></p>
                                    <p class="text-slate-500 dark:text-zink-200"><i data-lucide="map-pin" class="inline-block size-4 ltr:mr-1 rtl:ml-1 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-500"></i> <?php echo $pegawai[0]->puskesmas;?></p>
                                </div>
                                <ul class="flex flex-wrap gap-3 mt-4 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                    <li class="px-5">
                                        <h5><?php echo format_semi($tgl_masuk);?></h5>
                                        <p class="text-slate-500 dark:text-zink-200">TMT</p>
                                    </li>
                                    <li class="px-5">
                                        <h5><?php echo $masa_kerja['years'].' Tahun '.$masa_kerja['months'].' bulan';?></h5>
                                        <p class="text-slate-500 dark:text-zink-200">Masa Kerja</p>
                                    </li>
                                   
                                </ul>
                               
                               <br><br>
                               <button type="button" class="btn bg-custom-500 text-white"  data-modal-target="smallModal" >Change Profile Picture</button>
                             

                            </div>
                            
                            
                            <div class="lg:col-span-6 2xl:col-span-6">
                              <div class="grid grid-cols-12 2xl:grid-cols-12 gap-x-2 ">
                                <div class="col-span-12  md:col-span-4 2xl:col-span-3">
                                    <div class="card-body">
                                       
                                        <p class="mb-3 text-slate-500 dark:text-zink-200">Gaji Pokok</p>
                                        <h5 class="mb-4">Rp. <span class="counter-value" data-target="<?php echo $gaji_pokok;?>">0</span> </h5>

                                    </div>
                                </div><!--end col-->
                                <div class="col-span-12  md:col-span-3 2xl:col-span-3">
                                    <div class="card-body">
                                      
                                        <p class="mb-3 text-slate-500 dark:text-zink-200">Pengali</p>
                                        <h5 class="mb-4"><span><?php echo $pengkalian;?></span> x </h5>

                                    </div>
                                </div><!--end col-->
                                <div class="col-span-12  md:col-span-4 2xl:col-span-3">
                                    <div class="card-body">
                                       
                                        <p class="mb-3 text-slate-500 dark:text-zink-200"> TKD Pokok</p>
                                        <h5 class="mb-4">Rp.  <span class="counter-value" data-target="<?php echo $tkd_pokok?>">0</span> </h5>

                                    </div>
                                </div><!--end col-->
                                
                            </div>
                            </div>
                        </div><!--end grid-->
                        <br>
                    </div>
                    <div class="card-body !px-2.5 !py-0">
                        <ul class="flex flex-wrap w-full text-sm font-medium text-center nav-tabs">
                            <li class="group active">
                                <a href="javascript:void(0);" data-tab-toggle="" data-target="overviewTabs" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border-b border-transparent group-[.active]:text-custom-500 dark:group-[.active]:text-custom-500 group-[.active]:border-b-custom-500 dark:group-[.active]:border-b-custom-500 hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px]">Overview</a>
                            </li>
                            <li class="group">
                                <a href="javascript:void(0);" data-tab-toggle="" data-target="personalTabs" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border-b border-transparent group-[.active]:text-custom-500 dark:group-[.active]:text-custom-500 group-[.active]:border-b-custom-500 dark:group-[.active]:border-b-custom-500 hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px]">Account</a>
                            </li>
                            <li class="group">
                                <a href="javascript:void(0);" data-tab-toggle="" data-target="projectsTabs" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border-b border-transparent group-[.active]:text-custom-500 dark:group-[.active]:text-custom-500 group-[.active]:border-b-custom-500 dark:group-[.active]:border-b-custom-500 hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px]">Pelatihan</a>
                            </li>
                            <li class="group">
                                <a href="javascript:void(0);" data-tab-toggle="" data-target="followersTabs" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border-b border-transparent group-[.active]:text-custom-500 dark:group-[.active]:text-custom-500 group-[.active]:border-b-custom-500 dark:group-[.active]:border-b-custom-500 hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px]">FolloDawers</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div id="smallModal" modal-center=""  class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                        <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                <h5 class="text-16" id="modal_heading">Ubah Profile Picture</h5>
                                <button data-modal-close="smallModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                            </div>
                            
                                <div id="info_error" class="pb-3"></div>
                                    <div id="form_cuti">
                                    <form action="<?php echo base_url(); ?>profile/upload_profile_picture" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                                      <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                                            <div class="mb-3">
                                             
                                            <div class="p-3 file-upload-izin bg-yellow-100">
                                            
                                                    <p class="text-danger">
                                                        Jenis file yang diizinkan : <strong>JPG, PNG, JPEG </strong> <br>
                                                        Ukuran Maksimum File      : <strong>1 MB </strong> 
                                                    </p>


                                                <button type="button" class="mt-4 file-upload-button text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                                    <i class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> 
                                                    Buka File
                                                </button>

                                                <input type="file" accept="image/*"  id="file-input2"  name="imageupload">
                                                <span class="file-upload-name">No file chosen</span>
                                            </div>

                                            <img id="preview3" src="#" alt="Image preview" style="display: none; max-width: 300px;">
                                            <br><br>
                                            </div>


                                        <br>


                                            <button type="submit"  class=" ml-2 text-white btn bg-green-500  hover:text-white hover:bg-green-600">
                                                Upload
                                            </button>
                                            <button type="button" data-modal-close="smallModal"  class=" text-red-500 bg-red-100 btn hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20"> <i class="align-baseline ltr:pl-1 rtl:pr-1 ri-close-line"></i> Cancel</button>
                                            </div>
                                    </form>
                               </div>
                          
                          
                       </div>
                    </div><!--close modal form cuti-->



                <div class="tab-content">
                    <div class="block tab-pane" id="overviewTabs">
                        <div class="grid grid-cols-1   2xl:grid-cols-12">
                           <div class="2xl:col-span-3 xl:col-span-3">
                             
                             
                            </div><!--end col-->

                            <div class="2xl:col-span-12">
                                <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-12">
                                    <div class="xl:col-span-9">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="mb-3 text-15"> Statistics Capaian Kinerja</h6>
                                                <div id="capaianStatistics" class="apex-charts" data-chart-colors='["bg-custom-500", "bg-purple-500"]' dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="text-left card xl:col-span-3">
                                        <div class="flex flex-col h-full card-body">
                                           <h6 class="mb-4 text-15">Cuti</h6>

                                                <div class="divide-y divide-slate-200 dark:divide-zink-500">
                                                      <div class="flex items-center gap-3 pb-3">
                                                           
                                                        <div>
                                                            <h6 class="text-lg"><?php echo $sisaTahunLalu;?></h6>
                                                            <p class="text-slate-500 dark:text-zink-200">Sisa Cuti Tahun Lalu</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-3 py-3">
                                                       
                                                        <div>
                                                            <h6 class="text-lg"><?php echo $sisaTahunIni;?></h6>
                                                            <p class="text-slate-500 dark:text-zink-200">Sisa Cuti Tahun Ini</p>
                                                        </div>
                                                    </div>
                                                    <div class="flex items-center gap-3 pt-3">
                                                      
                                                        <div>
                                                            <h6 class="text-lg"><?php echo $sisaCuber;?></h6>
                                                            <p class="text-slate-500 dark:text-zink-200">Sisa Cuti Bersama</p>
                                                        </div>
                                                    </div>

                                                    <div class="flex items-center gap-3 pt-3">
                                                       
                                                        <div>
                                                            <h6 class="text-lg"><?php echo $sisaCutiAll;?> </h6>
                                                            <p class="text-slate-500 dark:text-zink-200">Total</p>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div><!--end col-->
                                </div><!--end grid-->
                                <div class="card">
                                    <div class="card-body">
                                    <h6 class="mb-3 text-15">Riwayat Cuti </h6>
                                     <div class="overflow-x-auto">
                                        <table class="w-full whitespace-nowrap">
                                            <thead class="ltr:text-left rtl:text-right">
                                                <tr>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Tanggal Pengajuan</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Tanggal Mulai</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Tanggal Akhir</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Lama Cuti</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Alasan</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Status</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Action</th>
                                                </tr>
                                            </thead>

                                          
                                            <tbody>
                                            <?php
                                                    for ($i=0; $i < count($cutiPegawai) ; $i++) { 
                                                    $tgl = $cutiPegawai[$i]->tgl;
                                                        $tgl_dari = $cutiPegawai[$i]->tgl_dari;
                                                        $tgl_sampai = $cutiPegawai[$i]->tgl_sampai;
                                                        $hari_cuti = $cutiPegawai[$i]->hari_cuti;
                                                        $status = $cutiPegawai[$i]->status;
                                                    
                                                    //    / $flagStatus = getStatusCuti($status);

                                                        
                                                        if($status=='APPROVE'){
                                                            $flag_status = '<span class="delivery_status px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-green-100 border-green-200 text-green-500 dark:bg-green-500/20 dark:border-green-500/20">Approved</span>';
                                                        }else if($status=='CANCEL'){
                                                            $flag_status = '<span class="delivery_status px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-slate-100 border-slate-200 text-slate-500 dark:bg-slate-500/20 dark:border-slate-500/20">Canceled</span>';
                                                        }else if($status=='REJECT'){
                                                            $flag_status = '<span class="delivery_status px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-danger-100 border-danger-200 text-danger-500 dark:bg-danger-500/20 dark:border-danger-500/20">Ditolak</span>';
                                                        }else{
                                                            $flag_status = '<span class="delivery_status px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-yellow-100 border-yellow-200 text-yellow-500 dark:bg-yellow-500/20 dark:border-yellow-500/20">Pending</span>';
                                                        }

                                                        echo '
                                                        <tr>
                                                            <td  class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.format_semi($tgl).'</td>
                                                            <td  class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.format_semi($tgl_dari).'</td>
                                                            <td  class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500"> '.format_semi($tgl_sampai).'</td>
                                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'. $hari_cuti.' hari</td>
                                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'. $cutiPegawai[$i]->alasan_cuti.' </td>
                                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'. $flag_status.'</td>
                                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                                <a href="'.base_url().'cuti/detail_mycuti/'.$cutiPegawai[$i]->id.'" class="py-1 text-xs px-1.5 text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Lihat Detail</a>';
                                                                  if($status=='PEND0' || $status=='PEND1'){
                                                                        echo ' <a href="'.base_url().'cuti/cancel_cuti_pegawai/'.$cutiPegawai[$i]->id.'" onClick="return confirm(\'Apakah anda yakin membatalkan cuti ini?\')" class="py-1 text-xs px-2.5 text-white btn bg-red-500 border-red-500 hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-custom-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/20">Cancel</a>'
                                                                    ;
                                                                    }else if($status=='CANCEL'){
                                                                   
                                                                        echo ' <a href="'.base_url().'cuti/delete_pengajuan_cuti/'.$cutiPegawai[$i]->id.'" onClick="return confirm(\'Apakah anda ingin menghapus cuti ini?\')" class="py-1 text-xs px-2.5 text-red-500 btn bg-red-100 border-red-100 hover:text-red-300 hover:bg-slate-300 hover:border-slate-200 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-custom-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/20">Hapus</a>'
                                                                    ;
                                                                    }
                                                        echo ' </td>
                                                        </tr>
                                                        ';


                                                    }

                                                    ?>


                                            </tbody>
                                        </table>
                                    </div>
                                     
                                    </div>
                                </div>
                            </div><!--end col-->
                           
                        </div><!--end grid-->

                      
                    </div><!--end tab pane-->
                    <div class="hidden tab-pane" id="personalTabs">
                         <div class="card">
                            <div class="card-body">
                                <h6 class="mb-1 text-15">Setting Account</h6>
                                <p class="mb-4 text-slate-500 dark:text-zink-200">Update your photo and personal details here easily.</p>
                                <form action="<?php echo base_url();?>profile/update_profile" method="post" id="update_myprofile">
                                    <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Nama Lengkap</label>
                                            <input type="text" id="inputValue" readonly value="<?php echo $pegawai[0]->nama;?>" class="readonly form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                        </div><!--end col-->
                                        <div class="xl:col-span-3">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">NIP</label>
                                            <input type="text" id="inputValue" readonly value="<?php echo $pegawai[0]->nip;?>" class="readonly form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                        </div><!--end col-->
                                        
                                         <?php
                                            $id_poli = $pegawai[0]->id_poli;
                                            $jns_pegawai = $pegawai[0]->jns_pegawai;
                                            
                                            $jns_jam_kerja = $pegawai[0]->jns_jam_kerja;
                                            $rumpun_kerja  = $pegawai[0]->rumpun_kerja;
                                            $id_validator  = $pegawai[0]->id_validator;
                                            
                                            $namaValidator = $this->Pegawai_model->getNamaPegawaiByID($id_validator);
                                            
                                            
                                            
                                            if($jns_pegawai=='non_pns'){
                                                $jenis_pegawai = 'NON PNS'; 
                                            }else{
                                                $jenis_pegawai = 'PNS'; 
                                            }
                                            
                                            
                                            
                                           ?>
                                           
                                        <div class="xl:col-span-3">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Jenis Pegawai</label>
                                            <input type="text" id="inputValue" readonly value="<?php echo $jenis_pegawai;?>" class="readonly form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                        </div><!--end col-->
                                        
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Jabatan</label>
                                            <input type="text" id="inputValue" readonly value="<?php echo $pegawai[0]->jabatan;?>" class="readonly form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Keterangan Jabatan</label>
                                            <input type="text" id="inputValue" readonly value="<?php echo $pegawai[0]->keterangan_jabatan;?>" class="readonly form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                        </div><!--end col-->
                                        
                                          
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Poli/Bagian</label>
                                             <select class="form-select" id="poliInput" name="id_poli"  data-choices=""  aria-label="Default select example">
                                                    <?php
                                                        foreach ($list_poli as $poli){
                                                                                    
                                                            $id_poli = $poli->id;
                                                            $nama_poli = $poli->nama_poli;


                                                                if($id_poli== $pegawai[0]->id_poli){
                                                                
                                                                    echo ' <option value="'. $id_poli .'" selected>'.$nama_poli .'</option>';
                                                            }else{
                                                                    echo ' <option value="'. $id_poli .'">'.$nama_poli .'</option>';
                                                            }
                                                        
                                                          
                                                        }

                                                    ?>
                                            
                                            </select>
                                        </div><!--end col-->
                                        
                                          <div class="xl:col-span-3">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Rumpun Kerja</label>
                                           
                                           <div class="flex flex-wrap gap-2">
                                                <div class="flex items-center gap-2">
                                                    <input id="radioInline1" value="ukp" <?php echo ($rumpun_kerja=='ukp') ? "checked" : "";?> name="rumpun_kerja" class="border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500" type="radio">
                                                    <label for="radioInline1" class="align-middle">
                                                        UKP
                                                    </label>
                                                </div>
                                    
                                                <div class="flex items-center gap-2">
                                                    <input id="radioInline2" value="ukm" name="rumpun_kerja" <?php echo ($rumpun_kerja=='ukm') ? "checked" : "";?> class="border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-green-500 checked:border-green-500 dark:checked:bg-green-500 dark:checked:border-green-500" type="radio">
                                                    <label for="radioInline2" class="align-middle">
                                                        UKM
                                                    </label>
                                                </div>
                                    
                                                <div class="flex items-center gap-2">
                                                    <input id="radioInline3" value="admen"  name="rumpun_kerja" <?php echo ($rumpun_kerja=='admen') ? "checked" : "";?> class="border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-orange-500 checked:border-orange-500 dark:checked:bg-orange-500 dark:checked:border-orange-500" type="radio">
                                                    <label for="radioInline3" class="align-middle">
                                                        Admen
                                                    </label>
                                                </div>
                                    
                                               
                                            </div>
                                            
                                        </div><!--end col-->
                                        <div class="xl:col-span-3">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Jenis Jam Kerja</label>
                                               
                                           <div class="flex flex-wrap gap-4">
                                                <div class="flex items-center gap-2">
                                                    <input id="radioInline4" name="jam_kerja"  value="non_shift" <?php echo ($jns_jam_kerja=='non_shift') ? "checked" : "";?> class="border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500" type="radio" value="" checked="">
                                                    <label for="radioInline4" class="align-middle">
                                                        REGULER
                                                    </label>
                                                </div>
                                    
                                           
                                    
                                                <div class="flex items-center gap-2">
                                                    <input id="radioInline5" name="jam_kerja"  value="shift" <?php echo ($jns_jam_kerja=='shift') ? "checked" : "";?>  class="border rounded-full appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-orange-500 checked:border-orange-500 dark:checked:bg-orange-500 dark:checked:border-orange-500" type="radio" value="">
                                                    <label for="radioInline5" class="align-middle">
                                                        SHIFT
                                                    </label>
                                                </div>
                                    
                                               
                                            </div>
                                            
                                            
                                           
                                        </div><!--end col-->
                                      
                                        
                                          <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Puskesmas</label>
                                            <select id="puskesmasInput" data-choices="" class="form-input bg-white border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" name="id_puskesmas" required aria-label="Default select example">
                                             
                                                    <?php
                                                         foreach ($list_puskesmas as $puskesmas){
                                                                                    
                                                                $id_puskesmas = $puskesmas->id_puskesmas;
                                                                $nama_puskesmas = $puskesmas->nama;
                                                                
                                                                if($id_puskesmas== $pegawai[0]->id_puskesmas){
                                                                    
                                                                     echo ' <option value="'. $id_puskesmas .'" selected>'.$nama_puskesmas .'</option>';
                                                                }else{
                                                                     echo ' <option value="'. $id_puskesmas .'">'.$nama_puskesmas .'</option>';
                                                                }

                                                               
                                                          

                                                            }


                                                    ?>
                                                </select>
                                        </div><!--end-->
                                        
                                        
                                          <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Atasan Langsung</label>
                                            <input type="text" id="id_validator" readonly value="<?php echo $namaValidator;?>"  name="validator"  class="readonly form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="No Rekening Bank DKI">
                                        </div>
                                        
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">No Telp/HP</label>
                                            <input type="text" id="inputValue" name="no_tlp" value="<?php echo $detailPegawai[0]->no_tlp;?>" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="081222...">
                                        </div>
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Email Address</label>
                                            <input type="email" id="inputValue" name="email" value="<?php echo $detailPegawai[0]->email;?>" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Enter your email address">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="tmptLahir" class="inline-block mb-2 text-base font-medium">Tempat Lahir</label>
                                            <input type="text" id="tmptLahir" name="tempat_lahir" value="<?php echo $detailPegawai[0]->tempat_lahir;?>" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="cth: Jakarta, Semarang" >
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="joiningDateInput" class="inline-block mb-2 text-base font-medium">Tanggal Lahir</label>
                                            <input type="text" id="joiningDateInput" value="<?php echo $detailPegawai[0]->tgl_lahir;?>" data-default-date="<?php echo date('d-m-Y', strtotime($detailPegawai[0]->tgl_lahir));?>" name="tgl_lahir"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Select date" data-provider="flatpickr" data-date-format="d-m-Y" >
                                        </div><!--end col-->
                                       <!--end col-->
                                        <div class="xl:col-span-4">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">No KTP</label>
                                            <input type="text" id="ktp" value="<?php echo $detailPegawai[0]->no_ktp;?>"  name="no_ktp"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="No KTP">
                                        </div><!--end col-->
                                        <div class="xl:col-span-4">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">No NPWP</label>
                                            <input type="text" id="npwp" value="<?php echo $detailPegawai[0]->npwp;?>"  name="npwp"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="No NPWP">
                                        </div><!--end col-->
                                        <div class="xl:col-span-4">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">No Rekening</label>
                                            <input type="text" id="norek" value="<?php echo $detailPegawai[0]->no_rekening;?>"  name="no_rekening"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="No Rekening Bank DKI">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="block mb-2 text-base font-medium">Alamat KTP</label>
                                            <textarea name="alamat_ktp" class="w-full form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="exampleFormControlTextarea2" placeholder="Alamat sesuai KTP" rows="3"><?php echo $detailPegawai[0]->alamat_ktp;?></textarea>
                                            
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="block mb-2 text-base font-medium">Alamat Domisili</label>
                                            <textarea name="alamat_domisili" class="w-full form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="exampleFormControlTextarea1" placeholder="Alamat domisili" rows="3"><?php echo $detailPegawai[0]->alamat_domisili;?></textarea>
                                            
                                        </div><!--end col-->
                                    </div><!--end grid-->
                                    <div class="flex justify-end mt-6 gap-x-4">
                                        <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Updates</button>
                                        <button type="button" class="text-red-500 bg-red-100 btn hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20">Cancel</button>
                                    </div>
                                </form><!--end form-->
                            </div>
                        </div>
                    </div><!--end tab pane-->
                    <div class="hidden tab-pane" id="projectsTabs">
                      
                        <div>
                            <div class="card">
                              <div class="card-body">
                                
                                 <div class="flex items-center gap-3 mb-4">
                                    <h5 class="underline grow">Pelatihan / Diklat</h5>
                                    <div class="shrink-0">
                                        <button type="button"   data-modal-target="largeModal" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                            Input Pelatihan</button>
                                    </div>
                                </div>

                                <table class="w-full whitespace-nowrap">
                                    <thead class="ltr:text-left rtl:text-right">
                                        <tr>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">No</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Jenis Pelatihan</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Judul Pelatihan</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Tanggal Pelatihan</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Lokasi</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Sertifikat</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Action</th>
                                        </tr>
                                    </thead>


                                    <tbody>
                                    <?php
                                        for ($s=0; $s < count($data_diklat) ; $s++) { 
                                                $id = $data_diklat[$s]->id;

                                                $tgl_dari = $data_diklat[$s]->tgl_mulai;
                                                $tgl_sampai = $data_diklat[$s]->tgl_selesai;

                                            echo '
                                                   <tr>
                                                    <td  class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500"> 
                                                     '.($s+1).'.
                                                    </td>
                                                    <td  class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.$data_diklat[$s]->jns_pelatihan.'</td>
                                                    <td  class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500"> 
                                                            <a href="'.base_url().'profile/detail_pelatihan/'.$data_diklat[$s]->id.'" class="text-dark-600 underline"  >
                                                            '.word_limiter($data_diklat[$s]->judul_pelatihan,5).'
                                                            </a>
                                                    </td>
                                                       <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500"  
                                                        <p class="mb-3 text-sm text-slate-500 dark:text-zink-300">
                                                            <i data-lucide="calendar" class="inline-block w-3.5 h-3.5 mr-1"></i> <span class="align-middle">
                                                            '.format_hari($tgl_dari).' - '.format_semi($tgl_dari).' s/d   '.format_hari($tgl_sampai).' - '.format_semi($tgl_sampai).'
                                                            </span>
                                                        </p>
                                                    </td>
                                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.$data_diklat[$s]->lokasi_diklat.'</td>
                                                 
                                                  
                                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                       <a href="'.base_url().'uploads/diklat/'.$data_diklat[$s]->surtug_sertifikat.'" class="btn btn-warning" target="_blank">
                                                            <i data-lucide="file-text" class="inline-block w-3.5 h-3.5 mr-1"></i> Lihat
                                                        </a>
                                                    </td>
                                                    <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                    <a href="'.base_url().'cuti/" onClick="return confirm(\'Apakah anda ingin menghapus cuti ini?\')" class="py-1 text-xs px-2.5 text-red-500 btn bg-red-100 border-red-100 hover:text-red-300 hover:bg-slate-300 hover:border-slate-200 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-custom-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/20">Hapus</a></td>
                                                    </tr>  ';
                                        }

                                    ?>

                                    </tbody>
                                </table>
                                
                             </div>
                            </div>

                        </div><!--end grid-->
                      
                    </div><!--end tab pane-->
                    <div class="hidden tab-pane" id="followersTabs">
                        <h5 class="mb-4 underline">Followers</h5>

                        <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-x-5">
                        </div>
                    </div><!--end tab pane-->
                </div><!--end tab content-->

                <div id="largeModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                    <div class="w-screen md:w-[40rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                            <h5 class="text-16">Modal Heading</h5>
                            <button data-modal-close="largeModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                        </div>
                        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                        <form action="<?php echo base_url();?>profile/input_diklat" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                            
                            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">

                                   <div class="xl:col-span-6 mb-2">
                                        <label for="judul" class="inline-block mb-2 text-base font-medium">Judul / Nama Pelatihan </label>
                                        <input type="text" name="judul"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                    </div>   

                                    <div class="xl:col-span-6 mb-2">
                                        <label for="tgl_diklat" class="inline-block mb-2 text-base font-medium">Tanggal Mulai - Selesai</label>
                                        <input type="text" name="tgl_diklat"  class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="tgl_diklat" data-range-date="true"  value="" data-provider="flatpickr" data-date-format="d M Y" placeholder="Select Date">
                                    </div>   

                              
                                    <div class="mb-3">
                                        <label for="inputValue" class="inline-block text-base font-medium">Jenis Diklat</label>
                                        <select id="choices-pengganti-cuti"  name="jns_diklat" data-choices="<?php echo set_value('jns_diklat');?>" data-choices-sorting-false="" <?= form_error('jns_diklat') ? 'is-invalid' : '' ?>>
                                            <option value="">--Cari Jenis Diklat--</option>
                                            <?php
                                                    for ($d=0; $d < count($arayJenis) ; $d++) { 
                                                        $jns_diklat = trim($arayJenis[$d]);
                                                        

                                                        echo '<option value="'.$jns_diklat.'">'.$jns_diklat .'</option>';

                                                    }
                                                ?>
                                            
                                            </select>     
                                      </div><!--end col-->


                                    <div class="xl:col-span-12 mt-3">
                            
                                        <label for="lokasi" class="inline-block mb-2 text-base font-medium">Lokasi / Tempat Pelatihan</label>
                                        <textarea name="lokasi" required id="lokasi" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"  rows="2" cols="10" wrap="soft"></textarea>
                                    </div>

                                    
                                     <div class="xl:col-span-12 mb-4 mt-3">
                                  

                                                <div class="file-upload-izin bg-yellow-100">
                                                 <h6>Dokumen Sertifikat/Surat Tugas:</h6>
                                                        <p class="text-danger">
                                                            Jenis file yang diizinkan : <strong>PDF </strong> <br>
                                                            Ukuran Maksimum File      : <strong>1 MB </strong> 
                                                        </p>

                                                        
                                                        <br>
                                                        <br>
                                                            <input type="file" name="filedocs" required id="file-input" class="d-none" multiple />
                                                            <label for="file-input">


                                                                    <div class="btn bg-custom-500 text-white">  
                                                                        <i class="fa fa-folder-open"></i>
                                                                        &nbsp; Choose Files To Upload
                                                                    </div> 
                                                            </label>

                                                            <div id="num-of-files">No Files Choosen</div>
                                                            <ul id="files-list"></ul>
                                                </div>

                                               
                                        </div>
                                    
                                        <button type="submit"  class=" ml-2 text-white btn bg-green-500  hover:text-white hover:bg-green-600 float-right">
                                                Submit
                                            </button>
                                            <button type="button" data-modal-close="largeModal"  class=" text-red-500 bg-red-100 btn hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20">
                                                 <i class="align-baseline ltr:pl-1 rtl:pr-1 ri-close-line"></i> Cancel
                                             </button>
                                           <div class="clearfix"></div>
                            </div>

                            </form>
                        </div>
                        <div class="flex items-center justify-between p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
                            
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

<div class="fixed items-center hidden bottom-6 right-12 h-header group-data-[navbar=hidden]:flex">
    <button data-drawer-target="customizerButton" type="button" class="inline-flex items-center justify-center w-12 h-12 p-0 transition-all duration-200 ease-linear rounded-md shadow-lg text-sky-50 bg-sky-500">
        <i data-lucide="settings" class="inline-block w-5 h-5"></i>
    </button>
</div>


<?php $this->load->view('layout/theme_config');?>
<?php $this->load->view('layout/mainjs');?>



<!-- apexcharts js -->
<script src="<?php echo base_url();?>assets/premium/libs/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo base_url();?>assets/premium/libs/dropzone/dropzone-min.js"></script>
<script src="<?php echo base_url();?>assets/premium/js/pages/pages-account.init.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

<script>
    
    $(".check-status-kerja").click(function(){
        
            var data = $(this).val();
            
             location.href = "<?php echo base_url();?>admin/pegawai/change_status_kerja/"+data;
            //alert(data);
        
    });
    
    
    
//Delivered Rate
var options = {
    series: [{
        name: 'Terlambat',
        data:<?php echo $json_telat;?>
    }],
    chart: {
        id: 'area-datetime',
        type: 'bar',
        height: 80,
        sparkline: {
            enabled: true
        },
        zoom: {
            autoScaleYaxis: true
        }
    },
    colors: getChartColorsArray("deliveredRate"),
    stroke: {
        width: 1,
        curve: 'smooth',
    },
    dataLabels: {
        enabled: false
    },
    xaxis: {
        categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
    },
};
var chart = new ApexCharts(document.querySelector("#deliveredRate"), options);
chart.render();



//basic column chart
var options = {
    series: [{
        name: 'Capaian',
        data: <?php echo $list_capaian;?>
    }],
    chart: {
        height: 350,
        type: 'line',
        dropShadow: {
            enabled: true,
            color: '#000',
            top: 18,
            left: 7,
            blur: 10,
            opacity: 0.2
        },
        toolbar: {
            show: false
        }
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: '45%',
            endingShape: 'rounded'
        },
    },
    dataLabels: {
        enabled: true
    },
    colors: getChartColorsArray("capaianStatistics"),
    dataLabels: {
        enabled: true,
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        title: {
            text: 'Month'
        }
    },
    yaxis: {
        min: <?php echo $min;?>,
        max: 100
    },
    fill: {
        opacity: 1
    },
};

var chart = new ApexCharts(document.querySelector("#capaianStatistics"), options);
chart.render();


    
    var message_status = '<?php echo $message_status;?>';
    var message = " <?php echo $info;?> ";


    if(message_status==200){
        Toastify({
                    text: message,
                    duration: 5000,
                    close: true,
                    className: "success",
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover   
                    style: {
                        background: "#04c394",
                        color: "#FFF"
                    },              
                    onClick: function(){} // Callback after click
                }).showToast();
    }else if(message_status==250){
        Toastify({
                    text: message,
                    duration: 5000,
                    close: true,
                    className: "danger",
                    gravity: "top", // `top` or `bottom`
                    position: "center", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "#ed1b24",
                        color: "#FFF"
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
    }
    



    $('#update_myprofile').submit(function() {
           
        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(msg) {
                Toastify({
                    text: msg,
                    duration: 3000,
                    close: true,
                    className: "info",
                    gravity: "top", // `top` or `bottom`
                    position: "right", // `left`, `center` or `right`
                    stopOnFocus: true, // Prevents dismissing of toast on hover
                    style: {
                        background: "#2f8f4c",
                        color: "#FFF"
                    },
                    onClick: function(){} // Callback after click
                }).showToast();
            }
        })
        return false;
    });


    $("#puskesmasInput").change(function(){
        var id_puskesmas = $(this).val();
        var rumpun = '<?php echo $rumpun_kerja;?>';

        $.ajax({

                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>profile/getValidator",
                    data:"id_puskesmas="+id_puskesmas+"&rumpun_kerja="+rumpun,
                    success:function(msg){
                        //window.location.reload();
                        $("#id_validator").val(msg);
                        //console.log(msg);
                    }

                });

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



</script>

</html>