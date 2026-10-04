<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/dncalendar-skin.css">
   <style>
   
     .border-y{
        border-bottom:1px solid #EEE ;
     }
     .text-bold{
        font-weight: bold;
     }
     .text-muted{
        color: #666;
     }

   </style>

</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $info = $this->session->flashdata('message');

       $nama    = $this->session->userdata('nama');

      // print_array($this->session->userdata);


        $listBulan = array_bulan();
        
     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



    <?php

                $id_pegawai = $pegawai[0]->id_pegawai;
                $nip  = $pegawai[0]->nip;

                $bulan = $this->session->userdata('periode_bulan'); 
                $tahun = $this->session->userdata('periode_tahun'); 
                

                // if($bulan=='November'){
                //     $bulan = 11;
                // }else if($bulan=='December'){
                //     $bulan = 11;
                // }else if($bulan=='October'){
                //     $bulan = 10;
                // }else if($bulan=='September'){
                //     $bulan = 9;
                // }

                //print_array($this->session->userdata);
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

                $nama_bulan = getBulan($bulan);
                $list_bulan = array_bulan();

                ?>

        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
         <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
                
                 <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                    <div class="grow">
                        <h5 class="text-16">Penilaian Kinerja</h5>
                    </div>
                    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                            <a href="#!" class="text-slate-400 dark:text-zink-200">Penilaian Kinerja</a>
                        </li>
                        <li class="text-slate-700 dark:text-zink-100">
                        Validasi Aktifitas
                        </li>
                    </ul>
                </div>
        

                        

                
                        


                    <div class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
                       <div class="col-span-12 md:order-5    lg:col-span-12 xl:col-span-12 2xl:col-span-12 card">

                         <div class="card-body" id="customerList">
                                <div class="flex items-center">
                                    <h6 class="text-15 grow">Data Inputan Aktifitas</h6>
                                   
                                </div>
                                <br>
                            
                                            
                                            <div class="info_delete mb-4"></div>
                                            
                                            <div class="overflow-x-auto">
                                                <table class="w-full whitespace-nowrap" id="customerTable">
                                                    <thead class="bg-slate-100 dark:bg-zink-600">
                                                        <tr>
                                                            
                                                          
                                                            <th>No</th>

                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="jam">Jam</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="kegiatan"> Kegiatan</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="waktu">waktu</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="volume">Volume</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="Total">Total</th>
                                                            <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="status">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="list form-check-all">
                                                        

                                                        <?php

                                                                $no = 1;
                                                            
                                                                $tgl_first = '';

                                                                $totalVolume =  0;
                                                                foreach ($dataAktifitasPegawai as $list ) {

                                                                        $id = $list->id;
                                                                        $tgl = $list->tgl;
                                                                        $nama = $list->nama_kegiatan;
                                                                        $jns_kegiatan = $list->jns_kegiatan;
                                                                        $jam_mulai = $list->jam_mulai;
                                                                
                                                                        $jam_selesai = $list->jam_selesai;
                                                                        $total = $list->total;
                                                                        $status= $list->status;
                                                                        $keterangan= $list->ket;
                                                                        $volume = $list->volume;
                                                                        $waktu_efektif = $list->waktu_efektif;

                                                                        $totalVolume = $totalVolume+$total;


                                                                        if($jns_kegiatan==1){
                                                                            $jns = 'Utama';
                                                                        }else{
                                                                            $jns = 'Tambahan';
                                                                        }

                                                                        if($status==0){
                                                                            $flag = '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-orange-100 border-orange-200 text-orange-500 dark:bg-orange-500/20 dark:border-orange-500/20">Pending</span>';
                                                                        }else if($status==1){
                                                                            $flag = '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-green-100 border-green-200 text-green-500 dark:bg-green-500/20 dark:border-green-500/20">Disetujui</span>';
                                                                        }else{
                                                                            $flag = '<span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-red-100 border-red-200 text-red-500 dark:bg-red-500/20 dark:border-red-500/20">Ditolak</span>';
                                                                        }

                                                                        
                                                                        
                                                                        $jam = date('H:i', strtotime($jam_mulai)).' - '.date('H:i', strtotime($jam_selesai));
                                                                        
                                                                            if($tgl_first !=$tgl){
                                                                                echo '
                                                                                <tr class="bg-slate-100 dark:bg-zink-600">
                                                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" scope="col" style="width: 50px;">
                                                                                        <input class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox" id="checkAll" value="option">
                                                                                    </th>
                                                                                    <th  colspan="2" class="text-left px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500" scope="row">
                                                                                    '.getNamahari($tgl).', '.formatTanggalIndo($tgl).'</th>
                                                                                    <th class="text-left" colspan="5"></th>
                                                                                   
                                                                                </tr>';
                                                                              
                                                             
                                                                            }
                                                                           
                                                                            
                                                                            
                                                                               echo '<tr> 
                                                                                    
                                                                                    <th class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 id" style="display:none;"><a href="javascript:void(0);" class="fw-medium link-primary id">'.$id.'</a></th>	
                                                                                    <th class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$no.'</th>
                                                                                    <th class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 tgl">'.$jam.'</th>
                                                                                   <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 kegiatan">
                                                                                    <span class="text-bold"> '.$nama.' </span>
                                                                                    <br> <span class="text-muted">'.$keterangan.'</span>
                                                                                    </td>
                                                                                    <td class="text-right px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 waktu">'.$waktu_efektif.'</td>
                                                                                    <td class="text-right  px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 volume">'.$volume.'</td>
                                                                                    <td class="text-right  px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 volume">'.$total.'</td>
                                                                                     <td class="text-right  px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 status'.$id.'">'.$flag.'</td>
                                                                                    
                                                                                   
                                                                                </tr>';



                                                                                $tgl_first =$tgl;
                                                                                

                                                                $no+=1;
                                                               
                                                             
                                                            }

                                                            $totalVolume = 0;
                                                            
                                                          

                                                        ?>

                                                    </tbody>
                                                </table>
                                                <div class="noresult" style="display: none">
                                                    <div class="text-center p-7">
                                                        <h5 class="mb-2">Sorry! No Result Found</h5>
                                                        <p class="mb-0 text-slate-500 dark:text-zink-200">We've searched more than 150+ Orders We did not find any orders for you search.</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex flex-col items-center gap-4 px-4 mt-4 md:flex-row" id="pagination-element">
                                            <div class="grow">
                                                <p class="text-slate-500 dark:text-zink-200">Showing <b class="showing">10</b> of <b class="total-records"><?php echo $no ;?></b> Results</p>
                                            </div>

                                        
                                                <div class="flex gap-2 pagination-wrap">
                                                    <a class="inline-flex items-center justify-center bg-white dark:bg-zink-700 h-8 px-3 transition-all duration-150 ease-linear border rounded border-slate-200 dark:border-zink-500 text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-500 dark:[&.active]:text-custom-500 [&.active]:bg-custom-50 dark:[&.active]:bg-custom-500/10 [&.active]:border-custom-50 dark:[&.active]:border-custom-500/10 [&.active]:hover:text-custom-700 dark:[&.active]:hover:text-custom-700 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto page-item pagination-prev disabled pagination-prev disabled" href="#">
                                                        Previous
                                                    </a>
                                                    <ul class="flex gap-2 mb-0 pagination listjs-pagination"></ul>
                                                    <a class="inline-flex items-center justify-center bg-white dark:bg-zink-700 h-8 px-3 transition-all duration-150 ease-linear border rounded border-slate-200 dark:border-zink-500 text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-500 dark:[&.active]:text-custom-500 [&.active]:bg-custom-50 dark:[&.active]:bg-custom-500/10 [&.active]:border-custom-50 dark:[&.active]:border-custom-500/10 [&.active]:hover:text-custom-700 dark:[&.active]:hover:text-custom-700 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto page-item pagination-prev disabled pagination-next" href="#">
                                                        Next
                                                    </a>
                                                </div>
                                            </div>

                                     
                           </div>

                        
                       </div>

                       
                       <div class="col-span-12 md:order-1 lg:col-span-6 lg:row-span-4 xl:col-span-4 xl:row-span-4 2xl:row-span-2 2xl:col-span-3 card">
                        
                        <div class="card-body">
                        
                           <div>
                                <h4><?php echo $pegawai[0]->nama;?> </h4>          
                                <strong><?php echo $pegawai[0]->nip;?></strong>   <br>
                                <strong><?php echo $pegawai[0]->jabatan;?></strong>  
                                @<?php echo $pegawai[0]->puskesmas;?>         
                                            
                                <br>  <br>
                                Periode : <strong><?php echo $nama_bulan;?> <?php echo $tahun;?></strong>
                           </div>
                           <br>
                           <strong>Pilih Bulan</strong> <br>
                           <div class="xl:col-span-3">
                                
                                <div>
                                    
                                    <select  name="bulan" id="bulan"  data-choices="" >
                                            <option value="">Bulan</option>
                                            <?php
                                                for ($b=0; $b < count($list_bulan) ; $b++) { 

                                                    //$no_bulan = $b+1;
                                                    $nama_bulan = $list_bulan[$b];
                                                    $opt_bulan  = $b.'. '.$nama_bulan;

                                                    if($bulan == $b){
                                                        $selc = 'selected';
                                                    }else{
                                                        $selc = '';
                                                    }
                                                    

                                                    echo '<option value="'.$b.'" '.$selc.'>'.$opt_bulan.'</option>';
                                                }
                                                ?>
                                        </select>
                                    </div>
                                </div><!--end col-->
                                
                       </div>
                   </div>

                    <div class="col-span-12 md:order-2 lg:col-span-6 lg:row-span-4 xl:col-span-4 xl:row-span-4 2xl:row-span-2 2xl:col-span-3 card">
                        
                         <div class="card-body">
                            <h6 class="mb-3 text-15 grow">Scheduled</h6>
<!--                           
                            <div id="dncalendar-container"></div> -->
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

                   
                   
                   <div class="col-span-12 md:order-3 lg:col-span-6 lg:row-span-4 xl:col-span-4 xl:row-span-4 2xl:row-span-2 2xl:col-span-3 card">
                        
                        <div class="card-body">
                           <h6 class="mb-3 text-15 grow">Data Aktifitas</h6>
<!--                           
                           <div id="dncalendar-container"></div> -->
                           <br>
                           <div class="flex flex-col gap-4 mt-3">
                           <div class="flex flex-col gap-5" id="rekap_inputan">
                                    <div>
                                        <div class="flex items-center justify-between gap-4 mb-2">
                                            <h6>Total Input Aktifitas</h6>
                                            <span class="text-slate-500 dark:text-zink-200"><?php echo $totalInput;?></span>
                                        </div>
                                        <div class="w-full h-3.5 rounded bg-slate-200 dark:bg-zink-600">
                                            <div class="h-3.5 rounded bg-custom-500" style="width:  <?php echo  $persenInput;?>%"></div>
                                        </div>
                                    </div>
                                    
                                    <div>
                                        <div class="flex items-center justify-between gap-4 mb-2">
                                            <h6>Disetujui</h6>
                                            <span class="text-slate-500 dark:text-zink-200"><?php echo $totalApprove ;?></span>
                                        </div>
                                        <div class="w-full h-3.5 rounded bg-slate-200 dark:bg-zink-600">
                                            <div class="h-3.5 rounded bg-green-500" style="width: <?php echo $persenApprove;?>%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex items-center justify-between gap-4 mb-2">
                                            <h6>Ditolak</h6>
                                            <span class="text-slate-500 dark:text-zink-200"><?php echo $totalReject ;?></span>
                                        </div>
                                        <div class="w-full h-3.5 rounded bg-slate-200 dark:bg-zink-600">
                                            <div class="h-3.5 rounded bg-red-500 dark:text-red-500" style="width: <?php echo $persenReject;?>%"></div>
                                        </div>
                                    </div>
                                </div>

                               
                            
                           </div>
                          
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


<?php $this->load->view('layout/theme_config');?>

<!--apexchart js-->
<script src="<?php echo base_url();?>assets/premium/libs/apexcharts/apexcharts.min.js"></script>
<!-- vanila calendar -->
<script src="<?php echo base_url();?>assets/premium/libs/vanilla-calendar-pro/build/vanilla-calendar.min.js"></script>
<script src="<?php echo base_url();?>assets/premium/js/pages/dashboards-hr.init.js"></script>
<?php $this->load->view('layout/mainjs');?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
		<script type="text/javascript" src="<?php echo base_url();?>assets/js/dncalendar.min.js"></script>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>







</body>

<script type="text/javascript">
		$(document).ready(function() {
			var my_calendar = $("#dncalendar-container").dnCalendar({
				minDate: "2017-01-01",
				maxDate: "2024-12-31",
				defaultDate: "2024-11-01",
				monthNames: [ "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember" ], 
				monthNamesShort: [ 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des' ],
				dayNames: [ 'Mgg', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                dayNamesShort: [ 'Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab' ],
                dataTitles: { defaultDate: '', today : 'Today' },
                notes: <?php  echo $jsn_schdl;?>,
                showNotes: false,
                startWeek: 'monday',
                dayClick: function(date, view) {
                	//alert(date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear());

                    var tanggal = (date.getDate() + "-" + (date.getMonth() + 1) + "-" + date.getFullYear());
                    $("#modalAction").trigger("click");

                    $("#tgl_absen").val(tanggal);

                    $("#tgl_absen_dl").val(tanggal);
                    $("#tgl_absen_izin").val(tanggal);
                    $("#tgl_absen_sakit").val(tanggal);
                }
			});

			// init calendar
			my_calendar.build();

			// update calendar
			// my_calendar.update({
			// 	minDate: "2016-01-05",
			// 	defaultDate: "2016-05-04"
			// });
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


		</script>

</script>

</html>