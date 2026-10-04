<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

   <style>
    .w3-light-grey{
        background-color: #EEE;
    }
    .w3-blue{
        background-color: #4696e0;
    }
   </style>
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $info = $this->session->flashdata('message');

          
       $list_bulan = array_bulan();
        

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

        //print_array($rekap_capaian_kinerja);

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

      //  print_array($listCapaian);

        $capaianTerkecil = min($listCapaian);
        $min = $capaianTerkecil-1;

        $list_capaian = json_encode($listCapaian);
        $bulanCapaian = json_encode($listBulanCapaian);

     

        


          


         // print_array($arrayTelat);

        //   [periode] => 2024-10
        //   [telat] => 78
        //   [pulang_awal] => 0
        //   [izin] => 0
        //   [sakit] => 0
        //   [sakit_dgn_sk] => 0
        //   [alpha] => 0
        //   [isoman] => 0
        //   [dl_penuh] => 0
        //   [dl_awal] => 0
        //   [dl_akhir] => 1
        //   [cuti] => 3
        //   [id_pegawai] => 952
        //     [nama] => Lilis Saidah
        //     [nip] => 10202719960508201908291
        //     [nrk] => 0
        //     [golongan] => 
        //     [id_puskesmas] => 3
        //     [rumpun_kerja] => ukp
        //     [id_jabatan] => 6
        //     [keterangan_jabatan] => 
        //     [id_poli] => 28
        //     [bagian_shift] => 0
        //     [tgl_masuk] => 2019-08-01
        //     [tmt] => 2019-08-01
        //     [keterangan] => 
        //     [jns_pegawai] => non_pns
        //     [jns_jam_kerja] => non_shift
        //     [password] => e10adc3949ba59abbe56e057f20f883e
        //     [status_kawin] => 2
        //     [status_pajak] => TK
        //     [id_pendidikan] => 4
        //     [status_kerja] => 1
        //     [jabfung] => 
        //     [id_validator] => 1035
        //     [kategori_masa_kerja] => 3
        //     [masa_kerja] => 5-1-29
        //     [tahun_anggaran] => 2024
        //     [usergroup] => 6
        //     [jabatan] => Kesehatan Lingkungan
        //     [puskesmas] => Pustu Marunda
        //     [gaji_pokok] => 4285444
        //     [pengkalian] => 0.8
        //     [pph21] => 118835
        //     [bpjs_kes] => 50674
        //     [bpjs_tk] => 128563


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


                    
            $sisaTahunLalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 1, 'DESC');
            $sisaTahunIni = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
            $sisaCuber = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 3, 'DESC');

            $sisaCutiAll = $sisaTahunLalu+$sisaTahunIni+$sisaCuber;
        ?>
              <div class="mt-1 -ml-3 -mr-3 rounded-none card">
                    <div class="card-body !px-2.5">
                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-12 2xl:grid-cols-12">
                            <div class="lg:col-span-2 2xl:col-span-1">
                                <div class="relative inline-block rounded-full shadow-md size-20 bg-slate-100 profile-user xl:size-28">
                                    <img src="<?php echo base_url().'uploads/photo_profile/'.$photo;?>" alt="" class="object-cover border-0 rounded-full img-thumbnail user-profile-image">
                                    <div class="absolute bottom-0 flex items-center justify-center rounded-full size-8 ltr:right-0 rtl:left-0 profile-photo-edit">
                                        <input id="profile-img-file-input" type="file" class="hidden profile-img-file-input">
                                        <label for="profile-img-file-input" class="flex items-center justify-center bg-white rounded-full shadow-lg cursor-pointer size-8 dark:bg-zink-600 profile-photo-edit">
                                            <i data-lucide="image-plus" class="size-4 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-500"></i>
                                        </label>
                                    </div>
                                </div>
                            </div><!--end col-->
                            <div class="lg:col-span-10 2xl:col-span-5">
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
                             

                            </div>
                            
                            
                            <div class="lg:col-span-12 2xl:col-span-6">
                              <div class="grid grid-cols-12 2xl:grid-cols-12 gap-x-2 divide-y md:divide-x md:divide-y-0">
                                <div class="col-span-12  md:col-span-3 2xl:col-span-3">
                                    <div class="card-body">
                                        <a href="#!" data-tooltip="default" data-tooltip-content="Taking the number of delivered emails and dividing it by the total number of emails sent" class="ltr:float-right rtl:float-left text-slate-500 dark:text-zink-200"><i data-lucide="info" class="size-4"></i></a>
                                        <p class="mb-3 text-slate-500 dark:text-zink-200">Total Terlambat</p>
                                        <h5 class="mb-4"><span class="counter-value" data-target="<?php echo $totalTelat;?>">0</span> menit</h5>

                                        <div id="deliveredRate" data-chart-colors='["bg-sky-500"]' dir="ltr" class="grow apex-charts"></div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-span-12  md:col-span-3 2xl:col-span-3">
                                    <div class="card-body">
                                        <a href="#!" data-tooltip="default" data-tooltip-content="Taking the number of delivered emails and dividing it by the total number of emails sent" class="ltr:float-right rtl:float-left text-slate-500 dark:text-zink-200"><i data-lucide="info" class="size-4"></i></a>
                                        <p class="mb-3 text-slate-500 dark:text-zink-200">Total Izin</p>
                                        <h5 class="mb-4"><span class="counter-value" data-target="<?php echo $totalIzin;?>">0</span> hari</h5>

                                        <div id="hardBounceRate" data-chart-colors='["bg-green-500"]' dir="ltr" class="grow apex-charts"></div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-span-12  md:col-span-3 2xl:col-span-3">
                                    <div class="card-body">
                                        <a href="#!" data-tooltip="default" data-tooltip-content="Taking the number of delivered emails and dividing it by the total number of emails sent" class="ltr:float-right rtl:float-left text-slate-500 dark:text-zink-200"><i data-lucide="info" class="size-4"></i></a>
                                        <p class="mb-3 text-slate-500 dark:text-zink-200">Total Sakit</p>
                                        <h5 class="mb-4"><span class="counter-value" data-target="<?php echo $totalSakit?>">0</span> hari</h5>

                                        <div id="unsubscribedRate" data-chart-colors='["bg-yellow-500"]' dir="ltr" class="grow apex-charts"></div>
                                    </div>
                                </div><!--end col-->
                                <div class="col-span-12  md:col-span-3 2xl:col-span-3">
                                    <div class="card-body">
                                        <a href="#!" data-tooltip="default" data-tooltip-content="Taking the number of delivered emails and dividing it by the total number of emails sent" class="ltr:float-right rtl:float-left text-slate-500 dark:text-zink-200"><i data-lucide="info" class="size-4"></i></a>
                                        <p class="mb-3 text-slate-500 dark:text-zink-200">Total Cuti</p>
                                        <h5 class="mb-4"><span class="counter-value" data-target="<?php echo $totalCuti?>">0</span> hari</h5>

                                        <div id="spanReportRate" data-chart-colors='["bg-purple-500"]' dir="ltr" class="grow apex-charts"></div>
                                    </div>
                                </div>
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
                                <a href="javascript:void(0);" data-tab-toggle="" data-target="projectsTabs" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border-b border-transparent group-[.active]:text-custom-500 dark:group-[.active]:text-custom-500 group-[.active]:border-b-custom-500 dark:group-[.active]:border-b-custom-500 hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px]">Data Cuti</a>
                            </li>
                            <li class="group">
                                <a href="javascript:void(0);" data-tab-toggle="" data-target="followersTabs" class="inline-block px-4 py-2 text-base transition-all duration-300 ease-linear rounded-t-md text-slate-500 dark:text-zink-200 border-b border-transparent group-[.active]:text-custom-500 dark:group-[.active]:text-custom-500 group-[.active]:border-b-custom-500 dark:group-[.active]:border-b-custom-500 hover:text-custom-500 dark:hover:text-custom-500 active:text-custom-500 dark:active:text-custom-500 -mb-[1px]">FolloDawers</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div class="block tab-pane" id="overviewTabs">
                        <div class="grid grid-cols-1  gap-x-5 2xl:grid-cols-12">
                           <div class="2xl:col-span-3 xl:col-span-3">
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-4 text-15">Personal Information</h6>
                                        <div class="overflow-x-auto">
                                            <table class="w-full ltr:text-left rtl:ext-right">
                                                <tbody>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">NIP</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200"><?php echo $pegawai[0]->nip;?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Phone No</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200"><?php echo $detailPegawai[0]->no_tlp;?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Tempat, Tanggal Lahir</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200"> <?php echo $detailPegawai[0]->tempat_lahir;?>, <?php echo format_semi($detailPegawai[0]->tgl_lahir);?></td>
                                                    </tr>
                                                   
                                                 
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Email</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200"><?php echo $detailPegawai[0]->email;?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Pendidikan</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200"><?php echo $pendidikan;?></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="py-2 font-semibold ps-0" scope="row">Status Kawin</th>
                                                        <td class="py-2 text-right text-slate-500 dark:text-zink-200"><?php echo $status_nikah;?></td>
                                                    </tr>
                                                  
                                                    <tr>
                                                        <th class="pt-2 font-semibold ps-0" scope="row">Joining Date</th>
                                                        <td class="pt-2 text-right text-slate-500 dark:text-zink-200"><?php echo format_semi($tgl_masuk);?></td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                            <br>
                                            <strong>Alamat KTP</strong>
                                            <p class="mb-2 text-slate-500 dark:text-zink-200"><?php echo $detailPegawai[0]->alamat_ktp;?></p>
                                            <strong>Alamat Domisili</strong>
                                            <p class="text-slate-500 dark:text-zink-200"><?php echo $detailPegawai[0]->alamat_domisili;?></p>
                                            </div>
                                    </div>
                                </div><!--end card-->
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-4 text-15">Gaji & Tunjangan</h6>

                                        <div class="divide-y divide-slate-200 dark:divide-zink-500">
                                            <div class="flex items-center gap-3 pb-3">
                                                <div class="flex items-center justify-center rounded-full size-12 bg-slate-100 dark:bg-zink-600">
                                                    <i data-lucide="wallet" class="size-5 text-slate-500 dark:text-zink-200"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-lg"><?php echo  rupiah($gaji_pokok);?></h6>
                                                    <p class="text-slate-500 dark:text-zink-200">Gaji Pokok</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 py-3">
                                                <div class="flex items-center justify-center rounded-full size-12 bg-slate-100 dark:bg-zink-600">
                                                    <i data-lucide="goal" class="size-5 text-slate-500 dark:text-zink-200"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-lg"><?php echo  $pengkalian;?></h6>
                                                    <p class="text-slate-500 dark:text-zink-200">Pengali</p>
                                                </div>
                                            </div>
                                            <div class="flex items-center gap-3 pt-3">
                                                <div class="flex items-center justify-center rounded-full size-12 bg-slate-100 dark:bg-zink-600">
                                                    <i data-lucide="package" class="size-5 text-slate-500 dark:text-zink-200"></i>
                                                </div>
                                                <div>
                                                    <h6 class="text-lg"><?php echo  rupiah($tkd_pokok);?></h6>
                                                    <p class="text-slate-500 dark:text-zink-200">TKD Pokok</p>
                                                </div>
                                            </div>

                                            
                                        </div>
                                    </div>
                                </div> <!--end card-->
                            </div><!--end col-->

                            <div class="2xl:col-span-9">
                                <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-12">
                                    <div class="xl:col-span-9">
                                        <div class="card">
                                            <div class="card-body">
                                                <h6 class="mb-3 text-15"> Statistics Capaian Kinerja</h6>
                                                <div id="capaianStatistics" class="apex-charts" data-chart-colors='["bg-custom-500", "bg-purple-500"]' dir="ltr"></div>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                    <div class="text-left card -500 xl:col-span-3">
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
                                                 <a href="'.base_url().'admin/pegawai/detail_cuti/'.$cutiPegawai[$i]->id.'" class="py-1 text-xs px-1.5 text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Lihat Detail</a> </td>
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
                                <h6 class="mb-1 text-15">Personal Information</h6>
                                <p class="mb-4 text-slate-500 dark:text-zink-200">Update your photo and personal details here easily.</p>
                                <form action="#!">
                                    <div class="grid grid-cols-1 gap-5 xl:grid-cols-12">
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">First Name</label>
                                            <input type="text" id="inputValue" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Enter your value" value="Star">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Last Name</label>
                                            <input type="text" id="inputValue" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Enter your value" value="Code">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Phone Number</label>
                                            <input type="text" id="inputValue" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="+855 8456 5555 23" value="+855 8456 5555 23">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Email Address</label>
                                            <input type="email" id="inputValue" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Enter your email address" value="starcode@starcode.com">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="joiningDateInput" class="inline-block mb-2 text-base font-medium">Birth of Date</label>
                                            <input type="text" id="joiningDateInput" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Select date" data-provider="flatpickr" data-date-format="d M, Y" data-default-date="24 Oct, 2023">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="joiningDateInput" class="inline-block mb-2 text-base font-medium">Joining Date</label>
                                            <input type="text" id="joiningDateInput" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Select date" data-provider="flatpickr" data-date-format="d M, Y" data-default-date="30 Nov, 2023">
                                        </div><!--end col-->
                                        <div class="xl:col-span-12">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Skill</label>
                                            <select class="form-input border-slate-300 focus:outline-none focus:border-custom-500" id="choices-multiple-default" data-choices="" name="choices-multiple-default" multiple="">
                                                <option value="Choice 1" selected="">Choice 1</option>
                                                <option value="Choice 2">Choice 2</option>
                                                <option value="Choice 3">Choice 3</option>
                                                <option value="Choice 2">Choice 4</option>
                                                <option value="Choice 3">Choice 5 </option>
                                                <option value="Choice 4" disabled="">Choice 4</option>
                                            </select>
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Designation</label>
                                            <input type="text" id="inputValue" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Enter your value" value="Web Developer">
                                        </div><!--end col-->
                                        <div class="xl:col-span-6">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Website</label>
                                            <input type="text" id="inputValue" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Enter your value" value="www.starcodekh.com">
                                        </div><!--end col-->
                                        <div class="xl:col-span-4">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">City</label>
                                            <select class="form-input border-slate-300 focus:outline-none focus:border-custom-500" id="choices-single-no-sorting" name="choices-single-no-sorting" data-choices="" data-choices-sorting-false="">
                                                <option value="Madrid">Madrid</option>
                                               
                                            </select>
                                        </div><!--end col-->
                                        <div class="xl:col-span-4">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Country</label>
                                            <select id="choices-single-no-sorting" name="choices-single-no-sorting" data-choices="" data-choices-sorting-false="">
                                                <option value="Madrid">USA</option>
                                                <option value="Toronto">Toronto</option>
                                                <option value="Vancouver">Vancouver</option>
                                             
                                            </select>
                                        </div><!--end col-->
                                        <div class="xl:col-span-4">
                                            <label for="inputValue" class="inline-block mb-2 text-base font-medium">Zip Code</label>
                                            <select id="choices-single-no-sorting" name="choices-single-no-sorting" data-choices="" data-choices-sorting-false="">
                                                <option value="Madrid">00012</option>
                                                <option value="Toronto">00014</option>
                                                <option value="Vancouver">00016</option>
                                                <option value="London">88800</option>
                                                <option value="Manchester">00100</option>
                                                <option value="Liverpool">00001</option>
                                            </select>
                                        </div><!--end col-->
                                        <div class="xl:col-span-12">
                                            <label for="inputValue" class="block mb-2 text-base font-medium">Description</label>
                                            <textarea class="w-full form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="exampleFormControlTextarea" placeholder="Enter your description" rows="3">𝗦𝘁𝗮𝗿𝗖𝗼𝗱𝗲 𝗞𝗵 is our website that learns and reads, PHP, Framework Laravel, How to and download Admin template sample source code free.&amp; Design with designing team in the company to build perfect web designs.</textarea>
                                            
                                        </div><!--end col-->
                                    </div><!--end grid-->
                                    <div class="flex justify-end mt-6 gap-x-4">
                                        <button type="button" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Updates</button>
                                        <button type="button" class="text-red-500 bg-red-100 btn hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20">Cancel</button>
                                    </div>
                                </form><!--end form-->
                            </div>
                        </div>
                    </div><!--end tab pane-->
                    <div class="hidden tab-pane" id="projectsTabs">
                        <div class="flex items-center gap-3 mb-4">
                            <h5 class="underline grow">Projects</h5>
                            <div class="shrink-0">
                                <button type="button" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Add Project</button>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 2xl:grid-cols-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex">
                                        <div class="grow">
                                            <img src="assets/images/adwords.png" alt="" class="h-11">
                                        </div>
                                        <div class="shrink-0">
                                            <div class="relative dropdown">
                                                <button class="flex items-center justify-center size-[37.5px] dropdown-toggle p-0 text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:border-zink-600 dark:hover:border-zink-500 dark:text-zink-200 dark:ring-zink-400/50" id="projectDropdownmenu1" data-bs-toggle="dropdown"><i data-lucide="more-horizontal" class="size-4"></i></button>
                                                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]" aria-labelledby="projectDropdownmenu1">
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i> Overview</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-1 text-16"><a href="#!">Chat App</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">Allows you to communicate with your customers in web chat rooms.</p>
                                    </div>
                                    <div class="flex w-full gap-3 mt-6 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">16 July, 2023</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Due Date</p>
                                        </div>
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">$8,740.00</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Budget</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 mt-6 rounded-full bg-slate-100 dark:bg-zink-600">
                                        <div class="h-1.5 rounded-full bg-custom-500" style="width: 25%"></div>
                                    </div>
                                </div>
                            </div><!--end card & col-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex">
                                        <div class="grow">
                                            <img src="assets/images/app-store.png" alt="" class="h-11">
                                        </div>
                                        <div class="shrink-0">
                                            <div class="relative dropdown">
                                                <button class="flex items-center justify-center size-[37.5px] dropdown-toggle p-0 text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:border-zink-600 dark:hover:border-zink-500 dark:text-zink-200 dark:ring-zink-400/50" id="projectDropdownmenu2" data-bs-toggle="dropdown"><i data-lucide="more-horizontal" class="size-4"></i></button>
                                                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]" aria-labelledby="projectDropdownmenu2">
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i> Overview</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-1 text-16"><a href="#!">Business Template - UI/UX design</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">UX design process is iterative and non-linear, includes a lot of research.</p>
                                    </div>
                                    <div class="flex w-full gap-3 mt-6 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">28 Nov, 2023</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Due Date</p>
                                        </div>
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">$10,254.00</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Budget</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 mt-6 rounded-full bg-slate-100 dark:bg-zink-600">
                                        <div class="h-1.5 rounded-full bg-sky-500" style="width: 61%"></div>
                                    </div>
                                </div>
                            </div><!--end card & col-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex">
                                        <div class="grow">
                                            <img src="data:image/png;base64,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" alt="" class="h-11">
                                        </div>
                                        <div class="shrink-0">
                                            <div class="relative dropdown">
                                                <button class="flex items-center justify-center size-[37.5px] dropdown-toggle p-0 text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:border-zink-600 dark:hover:border-zink-500 dark:text-zink-200 dark:ring-zink-400/50" id="projectDropdownmenu3" data-bs-toggle="dropdown"><i data-lucide="more-horizontal" class="size-4"></i></button>
                                                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]" aria-labelledby="projectDropdownmenu3">
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i> Overview</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-1 text-16"><a href="#!">ABC Project Customization</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">The process of tailoring the overall project delivery process to meet the requirements.</p>
                                    </div>
                                    <div class="flex w-full gap-3 mt-6 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">20 Oct, 2023</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Due Date</p>
                                        </div>
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">$9,832.00</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Budget</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 mt-6 rounded-full bg-slate-100 dark:bg-zink-600">
                                        <div class="h-1.5 rounded-full bg-green-500" style="width: 87%"></div>
                                    </div>
                                </div>
                            </div><!--end card & col-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex">
                                        <div class="grow">
                                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAIAAAACACAYAAADDPmHLAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAADsQAAA7EB9YPtSQAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAv1SURBVHic7Z15cFXlGcZ/7703gbAkLCIVZRGtUlA2tSpUMELYkaoEQcERHLFTW0dBabWFXqlOpwwKWp2OVi1qBQEXFBtRlhQFxoUmWmWw4EKpikvZwUS457z9I+DQKiHLeb9zbu79/Q3P8809T872fd9zhIihwws6E4sXAucDXYDOQFMg38Sw04AUuc0SAav6ILtBdwKbEdmAz2p8/xWZO29XwF71QsIeAIAObZVPDhNRvQqkt1PzTgMht6krtwMoL4I8Qn6HFySZ9F0ZH41QA6CD2jal8cFbUG4AWoYyCLcBOJINqN4ud89bHIb5YUILgF7ccjgq9wMdwxoDEGYADrMciV8nsx/6KAzzmGtDnUyOXtzqLlSWEvbBjwZFqFemU6++NAxzpwHQke2asK3VEpQpROT+IyK0AHlKp06c5trYWQC0+KQ8pHIZMMyVZ5ohwO91yqTpLk2dBECLiVNZsQjlAhd+aY3oTJ06abIrOzdngMpWvwEd4cSrQaD36ZSJfVw4mQdAh7e8APiVtU8DIwfhCb15gvnjiWkA9EISxOQ+a58GSif8HPP7AdsDk9/yWqC7qUdDRvQmnXqN6aOyWQB0MjmoOH+saWDkgneLpYHdGeCz1iOBTmb6mYLKRJ02qbmVvF0A1J9gpp1JCE3w1OwtoUkAdCiNQAZbaGckyigraZszQM5xfYA8E+1MRCjU4uK4hbTRJcA7x0Y3Y2lB+7xTLIRtAuDL6Sa6mUwsZvKb2gRAOMlEN5PxYx0sZK2eAsweWzKWmJqsiTQKgDay0c1kxOQ3NboEyH4T3UzG130WsjYBUInU0ucGgWDym1pdAj6w0c1gfDZbyFo9BWw00c1k/Ph7FrJWAVhjopuxyCa556HPLZRtAvDcjo3ApybamYjoSitpkwAIKLDIQjsj8VhoJW03Hez5j5ppZxT6EQUdX7VSNwuAlOx6C1hupZ9BzLbcRGq7JlD0dqouB1nqgrKV5jxiaWEaAHl+51qQJyw9GjSiN0lyXqWlhf1y7URiKvCZuU/D4xm5a94z1ibmAZBnP/8C5ErAs/ZqOOhHeHqNCycnGzZk6fZVCD914dUA2I6XGO6qSsbZjh15fseDiP6C7E1hNchOVEfI3IecvUp3umVLnt85C7gWOOjSN034NyL95O55r7k0db5nT5bueBikLxBKJUo0kZWk4ufI7Iffde0cyqZNWbr9TRprL+BeMvvmcAfojTTvMMhqsudYhF7ToqNadUXlNlTHAiZr36slnJKoHcA9eHpv2L2BoQfgMDqi9YngX4HIaOAsXIXBXQD2AqXAk/j7lsicxRUuTI9FZAJwJFrcsoBKObdCOvTYE+vWKyUFLXxp1DaHPWeifk5gPuTsad3OW52bp/V+27Y30ShvTzyv6UGJJw7EEjEVdn8tOdubpSrKO+/fsZaC9mWSTKaCGHeQRCoAy4u1IJXDJaoMBPoB7a091ef04QtlU63/4wo9DbgMKATOo/ql8HuAdSirEJ5moHxYp8EaEIkAvDhOuytMAy7F8Z7CWgUgqTH6MhrhRqq6jOtkCaxBmMOrPEdSQq2LDTUAL43V9p4wh6oDH8pYahyA5TqYGHNRugRo/w4+P2eQrA5Qs1aE1t3z17H6E69q8ehlRORM9J2UaD4r9QmEZQEffIAziVHKCn2YlzSUvtqga9KPyaJizWuW4BFgrGvvWrNKu+GxBOVUQxcBJhHnPEp1FIXyvqHXt3B6BlherAXNEiwjHQ7+Cj0fn1cQ04N/JF3xWMsqPcuRH+AwAIuKNe9AgqVU3d1HmxXaHSgBWjl2Ph6flazSHq4M3VTFotI8zgIhDapil2sHqtYytghpBAX4vMAKbevCzEkAlo3jZhW7npvAKNUEMB84PuSRnAQsYJGavw01D0DJldpV4Q5rn0DwmIbQN+xhHKKQVlxvbWJ/BvC5H8g196kvpdqJ6HUaz6RUv2dpYBqAkst1EHChpUdgePwaaBL2MP6PAnxM21Ztl4XH+KWlfmCs1BOBaBZbKtdRqsdZyZsFYNl4PVXT5a8fria6l6kmeFxhJW4WAM9nPFF+xXskavcDB8R4K2G7vYHKECvtIFl2GicAXcMexzE42+oyYBKA0mJtRtWqnsjz946cG/YYaoCQor+FsEkAvs6hKyFMNNWFPY04Lewx1JAzLURt2sI1bX5UKhOcHPYYaoSQPlWxfvivUmuMF3c+4VM3hDYWslYVMc0sdC1QIdQPB9cYtanfzX7NK8OxuQcAk1pTC0RJj1pbYa+FrEkAYvCFha4FcY8dYY+hRvg2v6nRByP4p4muAY1TabJJNWbzm5oEoLHPRiByu2C+i4IDaRJWn3csZE0CULhY9qGst9AOmt5beCPsMdQAnwSvWAjbzQXAMivtIBmyiW3AhrDHUS3KmxTKfyyk7T4dq/yF9KmDiXqVndn4zAIwbKF8QNV26OgjPAZ8HfYwjsJ+EiywEjd9ERQTfmepHxgD5JNDIYgiD1id/sE4AEPmywpglaVHYPjcAZF7KbQLmGVpYP4qOA7XAwesfepNkWxFI7Z8XZjOQDHtDjIPwOAF8h5wm7VPICSYDZH52kkp2/mjtYmTyaChC7hbFfPe23pTKCnijCP8buOteIxljJg3qLmpikV0v8d4BbMPHwRGoXyMMghsPtNWA7ajDGGwOJlPcTYdPGaxVOSmGAn8zZVnnSmSd1CGAtsdO3+OUkSRNMyq2KLFsjuvEUOJ/osXKJLXUC4AR3MFwrsIfSmScid+h3C+IKRwnlQOWyDjUSYT9XUDRbKRxpyD8rihiwIPkscPGSDOP7gZ2oqgYU/Kn7wUXRAWAqE2ZVXLj2QvRXIVPgMJfs6gHKUfA+U6+kgoxZGhLgkbuVg+GTZfxvo+PYDHgEi0Z34ng2Qla+iOMhpYR93nORRhNTFGMYCzKJJQHzsjtXWr5ErNV49RsRhFqvQDOlp71rkoslRPxeNS4CKqiiILqvnXu1DWIawiztMUypa6jTZ4IhWAb1g/OYdY27Pb7G3Vu/OXx5+dX9G0TaNUTsu9jSt6+eIHViQZ86UylajsuXbMhPrf6C3TE8jhZKpWRBcAu1H24vGBq0e6uhCd3Ttv39wUbXYJquNA+oM2/TJ/F1/mmz6ON0YkmCnrIbIN2BaIlkPCD8Drt7YmJ/dGfH4GeqiYKV2WEaQ/4QVAEcqTExC9CzArQMhSPeEEoOzWNpQ3ehzRwaH4Z/kG9wEom94Dib8IeoJz7yzfwm0AypN9gBLQ6h6ZsjjE3Yugt5NnAC9kD360cBOA129tjUcJaEsnfllqjJtLQG7uPFDzz79kqT32Z4CyGeOAEeY+WeqEbQDWJ5sgMtvUI0u9sA1A3L8WaGfqkaVe2AVAkzGQKWb6WQLBLgDlXAR0MNPPEgh2ARDGmGlnCQzLe4CBhtpZAsImAGXJdqDpUcCY4RidAfwf2OhmCRqbAMRip5joZgkcmwBoaJ9cy1JLrG4Co/btnaOjqYxef2YVgOj3ARxGE1ErhXCK0SXAN6k1NaHJV+kzVgNsAiBsNdENnl10mZUNQOB4sfRo3xTeC3sIYWMTgA83bAbZaaIdLOnQEmqKTQDGLPZAo98GopIePYaGGE4GyXNm2oEg+8llRdijCBu7AFTyFPCVmX690Wfplox2QYUD7AJwXnIPyKNm+vVGzCvY0gHrRaGzQA4ae9SFl+mVXBf2IKKAbQB6JbcAc009ak8K9U0/yZ5O2C8Lz2UmsMXcp8bIHHr/9u2wRxEV7APQLbkPkcuJxvzAepptnx72IKKEm61hPZNvIHqDE6+jItvQ1Gi+/4eofhcgFNxtDu058wFUZzjz+x9kJ+oNpfed/wrHP7q4L4kqS96A6BychU+2AcPolXzLjV96EU5LWHnyx6B/BvOVQ2uQ1Fh63vmJsU/aEk5RZK/kEmJeb+BlGwOpQHUGu6Qwe/CrJ/yewLIZlyGSBM6ov5h4oAuJy3S6Jz+sv17DJ/wAQFVj2D9mjMCPTQQdDuTWUuFTYD54D9Lrjs0GI2ywRCMAR/JaMp88vz8a6w/aDZVTqKqRy6fqXcI+4GOUTQhlKKt4f0N51RR0ltryXwgaOlCPaywuAAAAAElFTkSuQmCC" alt="" class="h-11">
                                        </div>
                                        <div class="shrink-0">
                                            <div class="relative dropdown">
                                                <button class="flex items-center justify-center size-[37.5px] dropdown-toggle p-0 text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:border-zink-600 dark:hover:border-zink-500 dark:text-zink-200 dark:ring-zink-400/50" id="projectDropdownmenu4" data-bs-toggle="dropdown"><i data-lucide="more-horizontal" class="size-4"></i></button>
                                                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]" aria-labelledby="projectDropdownmenu4">
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i> Overview</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-1 text-16"><a href="#!">starcode Design</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">Drawing created with Microsoft Expression Design, a drawing and design program for Windows.</p>
                                    </div>
                                    <div class="flex w-full gap-3 mt-6 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">07 Dec, 2023</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Due Date</p>
                                        </div>
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">$11,971.00</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Budget</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 mt-6 rounded-full bg-slate-100 dark:bg-zink-600">
                                        <div class="h-1.5 bg-purple-500 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div><!--end card & col-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex">
                                        <div class="grow">
                                            <img src="data:image/png;base64,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" alt="" class="h-11">
                                        </div>
                                        <div class="shrink-0">
                                            <div class="relative dropdown">
                                                <button class="flex items-center justify-center size-[37.5px] dropdown-toggle p-0 text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:border-zink-600 dark:hover:border-zink-500 dark:text-zink-200 dark:ring-zink-400/50" id="projectDropdownmenu5" data-bs-toggle="dropdown"><i data-lucide="more-horizontal" class="size-4"></i></button>
                                                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]" aria-labelledby="projectDropdownmenu5">
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i> Overview</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-1 text-16"><a href="#!">HR Management</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">The strategic approach to nurturing and supporting employees and ensuring a positive.</p>
                                    </div>
                                    <div class="flex w-full gap-3 mt-6 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">02 Jan, 2024</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Due Date</p>
                                        </div>
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">$7,546.00</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Budget</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 mt-6 rounded-full bg-slate-100 dark:bg-zink-600">
                                        <div class="h-1.5 bg-purple-500 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div><!--end card & col-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex">
                                        <div class="grow">
                                            <img src="assets/images/meta.png" alt="" class="h-11">
                                        </div>
                                        <div class="shrink-0">
                                            <div class="relative dropdown">
                                                <button class="flex items-center justify-center size-[37.5px] dropdown-toggle p-0 text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:border-zink-600 dark:hover:border-zink-500 dark:text-zink-200 dark:ring-zink-400/50" id="projectDropdownmenu6" data-bs-toggle="dropdown"><i data-lucide="more-horizontal" class="size-4"></i></button>
                                                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]" aria-labelledby="projectDropdownmenu6">
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i> Overview</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-1 text-16"><a href="#!">Finance Apps</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">A personal budget app is a technology solution that is connected.</p>
                                    </div>
                                    <div class="flex w-full gap-3 mt-6 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">10 Feb, 2024</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Due Date</p>
                                        </div>
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">$13,745.00</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Budget</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 mt-6 rounded-full bg-slate-100 dark:bg-zink-600">
                                        <div class="h-1.5 bg-purple-500 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div><!--end card & col-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex">
                                        <div class="grow">
                                            <img src="assets/images/search.png" alt="" class="h-11">
                                        </div>
                                        <div class="shrink-0">
                                            <div class="relative dropdown">
                                                <button class="flex items-center justify-center size-[37.5px] dropdown-toggle p-0 text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:border-zink-600 dark:hover:border-zink-500 dark:text-zink-200 dark:ring-zink-400/50" id="projectDropdownmenu7" data-bs-toggle="dropdown"><i data-lucide="more-horizontal" class="size-4"></i></button>
                                                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]" aria-labelledby="projectDropdownmenu7">
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i> Overview</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-1 text-16"><a href="#!">Mailbox Design</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">An email template is an HTML preformatted email that you can use to create your own.</p>
                                    </div>
                                    <div class="flex w-full gap-3 mt-6 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">19 Feb, 2024</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Due Date</p>
                                        </div>
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">$9,120.00</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Budget</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 mt-6 rounded-full bg-slate-100 dark:bg-zink-600">
                                        <div class="h-1.5 bg-purple-500 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div><!--end card & col-->
                            <div class="card">
                                <div class="card-body">
                                    <div class="flex">
                                        <div class="grow">
                                            <img src="data:image/png;base64,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" alt="" class="h-11">
                                        </div>
                                        <div class="shrink-0">
                                            <div class="relative dropdown">
                                                <button class="flex items-center justify-center size-[37.5px] dropdown-toggle p-0 text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100 active:text-slate-600 active:bg-slate-300 active:border-slate-300 active:ring active:ring-slate-100 dark:bg-zink-600 dark:hover:bg-zink-500 dark:border-zink-600 dark:hover:border-zink-500 dark:text-zink-200 dark:ring-zink-400/50" id="projectDropdownmenu8" data-bs-toggle="dropdown"><i data-lucide="more-horizontal" class="size-4"></i></button>
                                                <ul class="absolute z-50 hidden py-2 mt-1 text-left list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem]" aria-labelledby="projectDropdownmenu8">
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="eye" class="inline-block mr-1 size-3"></i> Overview</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="file-edit" class="inline-block mr-1 size-3"></i> Edit</a>
                                                    </li>
                                                    <li>
                                                        <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear bg-white text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500" href="#!"><i data-lucide="trash-2" class="inline-block mr-1 size-3"></i> Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <h6 class="mb-1 text-16"><a href="#!">Banking Management</a></h6>
                                        <p class="text-slate-500 dark:text-zink-200">Bank management refers to the process of managing the Bank's statutory activity.</p>
                                    </div>
                                    <div class="flex w-full gap-3 mt-6 text-center divide-x divide-slate-200 dark:divide-zink-500 rtl:divide-x-reverse">
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">01 March, 2024</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Due Date</p>
                                        </div>
                                        <div class="px-3 grow">
                                            <h6 class="mb-1">$24,863.00</h6>
                                            <p class="text-slate-500 dark:text-zink-200">Budget</p>
                                        </div>
                                    </div>
                                    <div class="w-full h-1.5 mt-6 rounded-full bg-slate-100 dark:bg-zink-600">
                                        <div class="h-1.5 bg-purple-500 rounded-full" style="width: 65%"></div>
                                    </div>
                                </div>
                            </div><!--end card & col-->
                        </div><!--end grid-->
                        <div class="flex flex-col items-center gap-4 mt-2 mb-4 md:flex-row">
                            <div class="grow">
                                <p class="text-slate-500 dark:text-zink-200">Showing <b>8</b> of <b>30</b> Results</p>
                            </div>
                            <ul class="flex flex-wrap items-center gap-2 shrink-0">
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto"><i class="size-4 rtl:rotate-180" data-lucide="chevrons-left"></i></a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto"><i class="size-4 rtl:rotate-180" data-lucide="chevron-left"></i></a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">1</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">2</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto active">3</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">4</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">5</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">6</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto"><i class="size-4 rtl:rotate-180" data-lucide="chevron-right"></i></a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto"><i class="size-4 rtl:rotate-180" data-lucide="chevrons-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div><!--end tab pane-->
                    <div class="hidden tab-pane" id="followersTabs">
                        <h5 class="mb-4 underline">Followers</h5>

                        <div class="grid grid-cols-1 md:grid-cols-2 2xl:grid-cols-4 gap-x-5">
                            <div class="relative card">
                                <div class="card-body">
                                    <p class="absolute inline-block px-5 py-1 text-xs ltr:left-0 rtl:right-0 text-custom-600 bg-custom-100 dark:bg-custom-500/20 top-5 ltr:rounded-e rtl:rounded-l">Executive Operations</p>
                                    <div class="flex items-center justify-end">
                                        <p class="text-slate-500 dark:text-zink-200">Doj : 15 Jan, 2023</p>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="overflow-hidden rounded-full size-20 bg-slate-100">
                                                <img src="assets/images/avatar-3.png" alt="" class="">
                                            </div>
                                        </div>
                                        <a href="#!"><h4 class="mt-4 mb-2 font-semibold text-16">Ralaphe Flores </h4></a>
                                        <div class="text-slate-500 dark:text-zink-200">
                                            <p class="mb-1">floral12@starcode.com</p>
                                            <p>+213 617 219 6245</p>
                                            <p class="inline-block px-3 py-1 my-4 font-semibold rounded-md text-slate-600 bg-slate-100 dark:bg-zink-600 dark:text-zink-200">Exp. : 1.5 years</p>
                                            <h4 class="text-15 text-custom-500">Salary : $463.42 <span class="text-xs font-normal text-slate-500 dark:text-zink-200">/ Month<span></span></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-->
                            <div class="relative card">
                                <div class="card-body">
                                    <p class="absolute inline-block px-5 py-1 text-xs text-green-600 bg-green-100 ltr:left-0 rtl:right-0 dark:bg-green-500/20 top-5 ltr:rounded-e rtl:rounded-l">Project Manager</p>
                                    <div class="flex items-center justify-end">
                                        <p class="text-slate-500 dark:text-zink-200">Doj : 29 Feb, 2023</p>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="overflow-hidden rounded-full size-20 bg-slate-100">
                                                <img src="assets/images/avatar-2.png" alt="" class="">
                                            </div>
                                        </div>
                                        <a href="#!">
                                            <h4 class="mt-4 mb-2 font-semibold text-16">James Lash </h4>
                                        </a>
                                        <div class="text-slate-500 dark:text-zink-200">
                                            <p class="mb-1">jameslash@starcode.com</p>
                                            <p>+210 85 383 2388</p>
                                            <p class="inline-block px-3 py-1 my-4 font-semibold rounded-md text-slate-600 bg-slate-100 dark:bg-zink-600 dark:text-zink-200">Exp. : 0.5 years</p>
                                            <h4 class="text-15 text-custom-500">Salary : $701.77 <span class="text-xs font-normal text-slate-500 dark:text-zink-200">/ Month<span></span></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-->
                            <div class="relative card">
                                <div class="card-body">
                                    <p class="absolute inline-block px-5 py-1 text-xs ltr:left-0 rtl:right-0 text-sky-600 bg-sky-100 dark:bg-sky-500/20 top-5 ltr:rounded-e rtl:rounded-l">React Developer</p>
                                    <div class="flex items-center justify-end">
                                        <p class="text-slate-500 dark:text-zink-200">Doj : 04 March, 2023</p>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="overflow-hidden rounded-full size-20 bg-slate-100">
                                                <img src="assets/images/avatar-4.png" alt="" class="">
                                            </div>
                                        </div>
                                        <a href="#!">
                                            <h4 class="mt-4 mb-2 font-semibold text-16">Angus Garnsey</h4>
                                        </a>
                                        <div class="text-slate-500 dark:text-zink-200">
                                            <p class="mb-1">angusgarnsey@starcode.com</p>
                                            <p>+210 41521 1325</p>
                                            <p class="inline-block px-3 py-1 my-4 font-semibold rounded-md text-slate-600 bg-slate-100 dark:bg-zink-600 dark:text-zink-200">Exp. : 0.7 years</p>
                                            <h4 class="text-15 text-custom-500">Salary : $478.32 <span class="text-xs font-normal text-slate-500 dark:text-zink-200">/ Month<span></span></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-->
                            <div class="relative card">
                                <div class="card-body">
                                    <p class="absolute inline-block px-5 py-1 text-xs text-yellow-600 bg-yellow-100 ltr:left-0 rtl:right-0 dark:bg-yellow-500/20 top-5 ltr:rounded-e rtl:rounded-l">Shopify Developer</p>
                                    <div class="flex items-center justify-end">
                                        <p class="text-slate-500 dark:text-zink-200">Doj : 11 March, 2023</p>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="overflow-hidden rounded-full size-20 bg-slate-100">
                                                <img src="assets/images/avatar-5.png" alt="" class="">
                                            </div>
                                        </div>
                                        <a href="#!">
                                            <h4 class="mt-4 mb-2 font-semibold text-16">Matilda Marston</h4>
                                        </a>
                                        <div class="text-slate-500 dark:text-zink-200">
                                            <p class="mb-1">matildamarston@starcode.com</p>
                                            <p>+210 082 288 1065</p>
                                            <p class="inline-block px-3 py-1 my-4 font-semibold rounded-md text-slate-600 bg-slate-100 dark:bg-zink-600 dark:text-zink-200">Exp. : 1 years</p>
                                            <h4 class="text-15 text-custom-500">Salary : $120.37 <span class="text-xs font-normal text-slate-500 dark:text-zink-200">/ Month<span></span></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-->
                            <div class="relative card">
                                <div class="card-body">
                                    <p class="absolute inline-block px-5 py-1 text-xs text-red-600 bg-red-100 ltr:left-0 rtl:right-0 dark:bg-red-500/20 top-5 ltr:rounded-e rtl:rounded-l">Angular Developer</p>
                                    <div class="flex items-center justify-end">
                                        <p class="text-slate-500 dark:text-zink-200">Doj : 22 March, 2023</p>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="overflow-hidden rounded-full size-20 bg-slate-100">
                                                <img src="assets/images/avatar-6.png" alt="" class="">
                                            </div>
                                        </div>
                                        <a href="#!">
                                            <h4 class="mt-4 mb-2 font-semibold text-16">Zachary Benjamin</h4>
                                        </a>
                                        <div class="text-slate-500 dark:text-zink-200">
                                            <p class="mb-1">zacharybenjamin@starcode.com</p>
                                            <p>+120 348 9730 237</p>
                                            <p class="inline-block px-3 py-1 my-4 font-semibold rounded-md text-slate-600 bg-slate-100 dark:bg-zink-600 dark:text-zink-200">Exp. : 0 years</p>
                                            <h4 class="text-15 text-custom-500">Salary : $89.99 <span class="text-xs font-normal text-slate-500 dark:text-zink-200">/ Month<span></span></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-->
                            <div class="relative card">
                                <div class="card-body">
                                    <p class="absolute inline-block px-5 py-1 text-xs text-purple-600 bg-purple-100 ltr:left-0 rtl:right-0 dark:bg-purple-500/20 top-5 ltr:rounded-e rtl:rounded-l">Graphic Designer</p>
                                    <div class="flex items-center justify-end">
                                        <p class="text-slate-500 dark:text-zink-200">Doj : 09 June, 2023</p>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="overflow-hidden rounded-full size-20 bg-slate-100">
                                                <img src="assets/images/avatar-7.png" alt="" class="">
                                            </div>
                                        </div>
                                        <a href="#!">
                                            <h4 class="mt-4 mb-2 font-semibold text-16">Ruby Chomley</h4>
                                        </a>
                                        <div class="text-slate-500 dark:text-zink-200">
                                            <p class="mb-1">rubychomley@starcode.com</p>
                                            <p>+120 1234 56789</p>
                                            <p class="inline-block px-3 py-1 my-4 font-semibold rounded-md text-slate-600 bg-slate-100 dark:bg-zink-600 dark:text-zink-200">Exp. : 0.2 years</p>
                                            <h4 class="text-15 text-custom-500">Salary : $214.82 <span class="text-xs font-normal text-slate-500 dark:text-zink-200">/ Month<span></span></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-->
                            <div class="relative card">
                                <div class="card-body">
                                    <p class="absolute inline-block px-5 py-1 text-xs text-yellow-600 bg-yellow-100 ltr:left-0 rtl:right-0 dark:bg-yellow-500/20 top-5 ltr:rounded-e rtl:rounded-l">Shopify Developer</p>
                                    <div class="flex items-center justify-end">
                                        <p class="text-slate-500 dark:text-zink-200">Doj : 27 June, 2023</p>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="overflow-hidden rounded-full size-20 bg-slate-100">
                                                <img src="assets/images/avatar-8.png" alt="" class="">
                                            </div>
                                        </div>
                                        <a href="#!">
                                            <h4 class="mt-4 mb-2 font-semibold text-16">Jesse Edouardy</h4>
                                        </a>
                                        <div class="text-slate-500 dark:text-zink-200">
                                            <p class="mb-1">jessedouard@starcode.com</p>
                                            <p>+87 044 017 3869</p>
                                            <p class="inline-block px-3 py-1 my-4 font-semibold rounded-md text-slate-600 bg-slate-100 dark:bg-zink-600 dark:text-zink-200">Exp. : 1.7 years</p>
                                            <h4 class="text-15 text-custom-500">Salary : $278.96 <span class="text-xs font-normal text-slate-500 dark:text-zink-200">/ Month<span></span></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-->
                            <div class="relative card">
                                <div class="card-body">
                                    <p class="absolute inline-block px-5 py-1 text-xs text-orange-600 bg-orange-100 ltr:left-0 rtl:right-0 dark:bg-orange-500/20 top-5 ltr:rounded-e rtl:rounded-l">Team Leader</p>
                                    <div class="flex items-center justify-end">
                                        <p class="text-slate-500 dark:text-zink-200">Doj : 15 July, 2023</p>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="flex justify-center">
                                            <div class="overflow-hidden rounded-full size-20 bg-slate-100">
                                                <img src="assets/images/avatar-9.png" alt="" class="">
                                            </div>
                                        </div>
                                        <a href="#!">
                                            <h4 class="mt-4 mb-2 font-semibold text-16">Xavier Bower</h4>
                                        </a>
                                        <div class="text-slate-500 dark:text-zink-200">
                                            <p class="mb-1">xavierbower@starcode.com</p>
                                            <p>+159 98765 32451</p>
                                            <p class="inline-block px-3 py-1 my-4 font-semibold rounded-md text-slate-600 bg-slate-100 dark:bg-zink-600 dark:text-zink-200">Exp. : 6.7 years</p>
                                            <h4 class="text-15 text-custom-500">Salary : $901.94 <span class="text-xs font-normal text-slate-500 dark:text-zink-200">/ Month<span></span></span></h4>
                                        </div>
                                    </div>
                                </div>
                            </div><!--end card-->
                        </div><!--end grid-->
                        <div class="flex flex-col items-center gap-4 mb-4 md:flex-row">
                            <div class="grow">
                                <p class="text-slate-500 dark:text-zink-200">Showing <b>8</b> of <b>18</b> Results</p>
                            </div>
                            <ul class="flex flex-wrap items-center gap-2">
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto"><i class="size-4 rtl:rotate-180" data-lucide="chevron-left"></i></a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">1</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">2</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto active">3</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">4</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">5</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto">6</a>
                                </li>
                                <li>
                                    <a href="#!" class="inline-flex items-center justify-center bg-white dark:bg-zink-700 size-8 transition-all duration-150 ease-linear border border-slate-200 dark:border-zink-500 rounded text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-50 dark:[&.active]:text-custom-50 [&.active]:bg-custom-500 dark:[&.active]:bg-custom-500 [&.active]:border-custom-500 dark:[&.active]:border-custom-500 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto"><i class="size-4 rtl:rotate-180" data-lucide="chevron-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div><!--end tab pane-->
                </div><!--end tab content-->


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


</script>

</html>