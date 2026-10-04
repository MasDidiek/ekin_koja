<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <style>
       .clearfix{
           clear:both;
       }
       
       .custom-pagination ul li a{
           background:#FFF;
           padding:8px 12px;
           border:1px solid #EEE;
           border-radius:4px;
           color:#666;
       }
         .custom-pagination ul li a:hover{
           background:#e0f2fe;
           color:#3b82f6;
    
       }
   </style>
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $info = $this->session->flashdata('message');
       
       $page = $this->uri->segment(4);
       if($page==''){
           $page = 0;
       }

        $numPage = $page+10;
        
        
        $blmDiRekap = $numAllPegawai-$absensiSesuai-$absensiBlmSesuai;
        
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


        $nm_bulan = getBulan($bulan);



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
                            <a href="#!" class="text-slate-400 dark:text-zink-200">HR Management</a>
                        </li>
                        <li class="text-slate-700 dark:text-zink-100">
                            Main Attendance
                        </li>
                    </ul>
                </div>
                <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-12">
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center rounded-md size-12 text-sky-500 bg-sky-100 text-15 dark:bg-sky-500/20 shrink-0"><i data-lucide="users-2"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $numAllPegawai;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200">Total Employee</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center text-red-500 bg-red-100 rounded-md size-12 text-15 dark:bg-red-500/20 shrink-0"><i data-lucide="user-x-2"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $blmDiRekap;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200"> <a href="<?php echo base_url();?>admin/presensi/absensi_by_status/-">Belum di Rekap</a></p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-md size-12 text-15 dark:bg-yellow-500/20 shrink-0"><i data-lucide="user-check-2"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $absensiBlmSesuai;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200">
                                        <a href="<?php echo base_url();?>admin/presensi/absensi_by_status/0">Belum Sesuai</a></p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-4 card-body">
                                <div class="flex items-center justify-center rounded-md size-12 text-green-500 bg-green-100 text-15 dark:bg-green-500/20 shrink-0"><i data-lucide="check-check"></i></div>
                                <div class="overflow-hidden grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $absensiSesuai;?>">0</span></h5>
                                    <p class="truncate text-slate-500 dark:text-zink-200"> <a href="<?php echo base_url();?>admin/presensi/absensi_by_status/1">Sudah Sesuai</a></p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-5 mb-5 xl:grid-cols-12">
                            <!-- <div class="xl:col-span-3">
                                <div class="relative">
                                    <input type="text" class="ltr:pl-8 rtl:pr-8 search form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Search for ..." autocomplete="off">
                                    <i data-lucide="search" class="inline-block size-4 absolute ltr:left-2.5 rtl:right-2.5 top-2.5 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-600"></i>
                                </div>
                            </div>end col -->
                            <div class="xl:col-span-3">
                          
                                <select name="id_validator" id="validator" data-choices="">

                                    <?php
                                        foreach ($validator as $pj) {
    
                                          $id_pj = $pj->id_pegawai;
                                          $nama_pj   = $pj->nama;
    
    
                                          if($id_pj_sess==$id_pj){
                                            echo '<option value="'. $id_pj.'" selected>'.$nama_pj.'</option>';
                                          }else{
                                            echo '<option value="'. $id_pj.'">'.$nama_pj.'</option>';
                                          }
    
                                        }
                                    ?>

                                </select>
                                    
                                            
                            </div><!--end col-->
                            
                            <div class="xl:col-span-2 xl:col-start-11">
                                	
                                <select  name="bulan" id="bulan"  data-choices="" >
                                        <option value="">Bulan</option>
                                        <?php
                                            for ($b=0; $b < count($list_bulan) ; $b++) { 

                                                $no_bulan = $b+1;

                                                if($bulan == $b){
                                                    $selc = 'selected';
                                                }else{
                                                    $selc = '';
                                                }
                                                

                                                echo '<option value="'.$b.'" '.$selc.'>'.$b.' - '.$list_bulan[$b].'</option>';
                                            }
                                            ?>
                                    </select>
                            </div>
                        </div><!--end grid-->
                        
                        
                        
                        
                                <div id="largeModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                                    <div class="w-screen md:w-[40rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                                        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                            <h5 class="text-16">Rekap Absensi</h5>
                                            <button data-modal-close="largeModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                                        </div>
                                        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto" id="modal-info">
                                           
                                        </div>
                                     
                                    </div>
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
                                
                                  <div class="grid grid-cols-1 gap-4 mb-5 lg:grid-cols-2 xl:grid-cols-12">
                               
                                    <div class="xl:col-span-3">
										
                                         <div>
    									
                                            </div>
                                    </div><!--end col-->
                                  
                                </div><!--end grid-->
                                
                                
                        <div class="overflow-x-auto"  style="height:500px">
                            <table class="w-full whitespace-nowrap">
                                <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                                    <tr class="*:px-3.5 *:py-2.5 *:font-semibold *:border-b *:border-slate-200 *:dark:border-zink-500">
                                        <th>#</th>
                                      <th>Employee Name</th>
                                        <th>01</th>
                                        <th>02</th>
                                        <th>03</th>
                                        <th>04</th>
                                        <th>05</th>
                                        <th class="active">06</th>
                                        <th>07</th>
                                        <th>08</th>
                                        <th>09</th>
                                        <th>10</th>
                                        <th>11</th>
                                        <th>12</th>
                                        <th>13</th>
                                        <th>14</th>
                                        <th>15</th>
                                        <th>16</th>
                                        <th>17</th>
                                        <th>18</th>
                                        <th>19</th>
                                        <th>20</th>
                                        <th>21</th>
                                        <th>22</th>
                                        <th>23</th>
                                        <th>24</th>
                                        <th>25</th>
                                        <th>26</th>
                                        <th>27</th>
                                        <th>28</th>
                                        <th>29</th>
                                        <th>30</th>
                                        <th>31</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                     <?php
                                     
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
                                            $periode = date('Y-m', strtotime($periode));
                                            
                                            
                                              $no = 1;


                                              foreach ($pegawai as $peg){

                 
                                                      $id_pegawai = $peg->id_pegawai;
                                                      $nip = $peg->nip;
                                                      $nama = $peg->nama;
                                                      $jns_jam_kerja = $peg->jns_jam_kerja;
                                                      $id_pj = $peg->id_validator;
    
                                                      $pin = substr($nip, -4);
                                                     
                                                      $flag_rekap = '<i data-lucide="check" class="size-4 flex items-center justify-center text-orange-500 "></i>';
                                                      $dataAbsensi  = $this->Presensi_model->getAbsensiPegawai($pin, $periode); 
                                                      
                                                    echo ' <tr class="*:px-3.5 *:py-2.5 *:border-y *:border-slate-200 *:dark:border-zink-500">
                                                                     <td>'.$flag_rekap.'</td>
                                                                    <td>  <a href="#!"  data-modal-target="largeModal" id="'.$id_pegawai.'"  class="info-rekap transition-all duration-200 ease-linear">
                                                                    '.word_limiter($nama,2).'</a></td>';
                                                                    
                                                                       for ($i=0; $i < count($dataAbsensi); $i++) {
                                                                              $absn_msk = $dataAbsensi[$i]->masuk;
                                                                              $absn_plg = $dataAbsensi[$i]->pulang;
                                                                              $tanggal = $dataAbsensi[$i]->tanggal;
                                                                              $shift   = $dataAbsensi[$i]->shift;
                                                                              
                                                                              if($absn_msk != ''){
                                                                                 $status_absen = 'Y';
            
            
                                                                                 if($absn_plg != ''){
                                                                                   $status_absen = '<i data-lucide="check" class="size-3"></i>';
                                                                                   $flag = 'flex items-center justify-center text-green-500 bg-green-100 rounded-md size-6 dark:bg-green-500/20 shrink-0';
                                                                                 }else{
                                                                                    $status_absen = '<i data-lucide="check" class="size-4"></i>';
                                                                                    $flag = 'flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-md size-6 dark:bg-yellow-500/20 shrink-0';
                                                                                 }
            
                                                                                 if($absn_msk=='DLP'){
                                                                                    $status_absen = 'DL';
                                                                                      $flag = 'flex items-center justify-center text-purple-500 bg-purple-100 rounded-md size-6 dark:bg-purple-500/20 shrink-0';
                                                                                 }
                                                                                 
                                                                                  if($absn_msk=='DLA'){
                                                                                    $status_absen = 'DLA';
                                                                                      $flag = 'flex items-center justify-center text-purple-500 bg-purple-100 rounded-md size-6 dark:bg-purple-500/20 shrink-0';
                                                                                 }
            
            
                                                                                 if($absn_msk=='IZIN'){
                                                                                    $status_absen = 'IZ';
                                                                                      $flag = 'text-orange-500';
                                                                                 }
                                                                                 if($absn_msk=='SAKIT'){
                                                                                    $status_absen = 'SK';
                                                                                      $flag = 'text-orange-500';
                                                                                 }
                                                                                 
                                                                                 if($absn_msk=='SAKIT DGN SURAT'){
                                                                                    $status_absen = 'SK2';
                                                                                    $flag = 'flex items-center justify-center text-orange-500 bg-orange-100 rounded-md size-6 dark:bg-orange-500/20 shrink-0';
                                                                                  }
            
            
                                                                                 if($absn_msk=='CUTI'){
                                                                                      $status_absen = 'CT';
                                                                                      $flag = 'flex items-center justify-center text-custom-500 bg-custom-100 rounded-md size-6 dark:bg-custom-500/20 shrink-0';
            
                                                                                      $cekCuti = $this->Presensi_model->getJnsCuti($id_pegawai, $tanggal);
            
                                                                                      if($cekCuti==1){
                                                                                        $status_absen = '<span style="font-size:10px">CT</span>'; //cuti tahunan
                                                                                      }else if($cekCuti==2){
                                                                                        $status_absen = '<span style="font-size:10px">CB</span>'; //cuti bersalin
                                                                                      }else if($cekCuti==3){
                                                                                        $status_absen = '<span style="font-size:10px">CAP</span>'; //cuti bersalin
                                                                                      }else if($cekCuti==4){
                                                                                        $status_absen = '<span style="font-size:10px">CS</span>'; //cuti bersalin
                                                                                      }else{
                                                                                        $status_absen = '<span style="font-size:10px">CBS</span>'; //cuti bersalin
                                                                                      }
                                                                                     // print_array($cekCuti);
                                                                                 }
                                                                              }else{
                                                                                  $status_absen = 'T';
            
            
                                                                                  if($absn_plg != ''){
                                                                                    $status_absen = '<i data-lucide="check" class="size-4"></i>';
                                                                                    $flag = 'flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-md size-6 dark:bg-yellow-500/20 shrink-0';
                                                                                    
                                                                                    
                                                                                  }else{
                                                                                    $status_absen = '<i data-lucide="x" class="text-red-500 size-4"></i>';
                                                                                    $flag = 'flex items-center justify-center text-red-500 bg-orange-100 rounded-md size-6 dark:bg-orange-500/20 shrink-0';
            
            
                                                                                        $hariLibur = $this->Presensi_model->cekHariLibur($tanggal);
                                                                                        if(!empty($hariLibur )){
                                                                                          $status_absen = '<i data-lucide="calendar-x" class="size-4"></i>';
                                                                                          $flag = 'flex items-center justify-center text-red-500 bg-red-100 rounded-md size-6 dark:bg-red-500/20 shrink-0';
                                                                                        }
                
                
                                                                                          $day  = date('D', strtotime($tanggal));
                
                                                                                          if($day=='Sun' || $day =='Sat'){
                                                                                            $status_absen = '-';
                                                                                            $flag = 'text-slate-500';
                                                                                          }
                
                                                                                   }
            
                                                                                          if($absn_plg=='DLAK'){
                                                                                            $status_absen = 'DL';
                                                                                              $flag = 'flex items-center justify-center text-purple-500 bg-purple-100 rounded-md size-6 dark:bg-purple-500/20 shrink-0';
                                                                                         }
            
            
            
                                                                                } //close if $absn_msk != ''
                                                                                
                                                                                
                                                                                
                                                                                if($jns_jam_kerja=='shift'){
                                                                                    $flag = 'bg-light text-danger fs-1';
                                                                                    $status_absen = '<span style="font-size:10px">'.$shift.'</span>';
                                                                                    
                                                                                    if($shift=='SM'){
                                                                                      if($absn_msk ==''){
                                                                                          $flag = 'flex items-center justify-center text-red-500 bg-red-100 rounded-md size-6 dark:bg-red-500/20 shrink-0';
                                                                                      }else{
                                                                                          $flag = 'flex items-center justify-center text-green-500 bg-green-100 rounded-md size-6 dark:bg-green-500/20 shrink-0';
                                                                                      }
                                                                                    }else if($shift=='L-OFF'){
                                                                                       $status_absen = '<span style="font-size:10px">LO</span>';
                                                                                       if($absn_plg==''){
                                                                                           $flag = 'flex items-center justify-center text-green-500 bg-orange-500 text-white rounded-md size-6 dark:bg-orange-500/20 shrink-0';
                                                                                       }else{
                                                                                           $flag = 'flex items-center justify-center text-green-500 bg-orange-500 text-white rounded-md size-6 dark:bg-orange-500/20 shrink-0';
                                                                                       }
                                                                                    }else if($shift=='P'){
                                                                                      if($absn_msk ==''){
                                                                                          if($absn_plg==''){
                                                                                              $flag = 'flex items-center justify-center text-red-500 bg-red-100 rounded-md size-6 dark:bg-red-500/20 shrink-0';
                                                                                          }else{
                                                                                              $flag = 'flex items-center justify-center text-red-500 bg-yellow-100 rounded-md size-6 dark:bg-yellow-500/20 shrink-0';
                                                                                          }
            
                                                                                      }else{
                                                                                          if($absn_plg==''){
                                                                                              $flag = 'flex items-center justify-center text-red-500 bg-yellow-100 rounded-md size-6 dark:bg-yellow-500/20 shrink-0';
                                                                                          }else{
                                                                                              $flag = 'flex items-center justify-center text-green-500 bg-green-100 rounded-md size-6 dark:bg-green-500/20 shrink-0';
                                                                                          }
            
                                                                                      }
                                                                                    }else if($shift=='PSM'){
                                                                                      if($absn_msk ==''){
                                                                                          $flag = 'bg-danger  fs-1';
                                                                                      }else{
                                                                                          $flag = 'bg-success  fs-1';
                                                                                      }
                                                                                    }else if($shift=='OFF'){
                                                                                      $flag = 'flex items-center justify-center  bg-slate-200 text-slate-500 rounded-md size-6 dark:bg-slate-500/20 shrink-0';
                                                                                    }
            
                                                                                  }

                                                                                
                                                                                
                                                                                  echo ' <td>
                                                                                              <button type="button" data-modal-target="extraLargeModal" class="'.$flag .' btn-info-absensi transition-all duration-200 ease-linear hover:text-green-600" value="'.$pin.'/'.$id_pegawai.'/'.$tanggal.'">
                                                                                                '. $status_absen.'
                                                                                              </button>
                                                                                          </td>';
                                                                                
                                                                                
            
            
                                                                       }
            

                                                                    
                                                              echo ' </tr>  ';
        

                                                }
                                                
                                                ?>
                                   
                                    
                                  
                                </tbody>
                            </table>

                            
                        </div>
                    
                            
                       
                    </div>
                </div><!--end card-->

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
<?php $this->load->view('layout/mainjs');?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

<script>



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

             $("#validator").change(function(){
                var id_pj = $(this).val();

                $.ajax({

                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/presensi/set_session_validator",
                            data:"id_pj="+id_pj,
                            success:function(msg){
                             window.location.reload();
                              //$("#modal-form").html(msg);
                              //console.log(msg);
                            }

                      });

              });


          $(".info-rekap").click(function(){

          var id_pegawai = $(this).attr("id");
          $.ajax({

                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>admin/presensi/ajax_get_data_rekap",
                    data:"id_pegawai="+id_pegawai,
                    success:function(msg){
                      $("#modal-info").html(msg);
                    }

              });

          });

       
   

</script>

</html>