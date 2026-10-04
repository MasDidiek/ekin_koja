<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $info = $this->session->flashdata('message');
       $id_pegawai = $this->session->userdata('id_pegawai');

     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Capaian Kinerja</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Kinerja</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                    Capaian Kinerja
                    </li>
                </ul>
            </div>
            <?php   

                $totalTelat = 0;
                $totalIzin = 0;
                $totalSakit = 0;
                $totalCuti = 0;


                    for ($a=0; $a < count($dataRekap) ; $a++) { 
                        $telat  = $dataRekap[$a]->telat;
                        $p_awal = $dataRekap[$a]->pulang_awal;
                        $sakit  = $dataRekap[$a]->sakit;
                        $izin = $dataRekap[$a]->izin;
                        $sakit_dgn_sk  = $dataRekap[$a]->sakit_dgn_sk;
                        $cuti = $dataRekap[$a]->cuti;

                        $totalTelat = $totalTelat+$telat;
                        $totalIzin = $totalIzin+$izin;
                        $totalSakit = $totalSakit+$sakit;
                        $totalCuti = $totalCuti+$cuti;

                    }
            ?>

            <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-12">
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-3 card-body">
                                <div class="flex items-center justify-center text-red-500 bg-red-100 rounded-md size-12 text-15 dark:bg-red-500/20 shrink-0"><i data-lucide="file-bar-chart-2"></i></div>
                                <div class="grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $totalTelat;?>">0</span></h5>
                                    <p class="text-slate-500 dark:text-zink-200">Total Terlambat</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-3 card-body">
                                <div class="flex items-center justify-center text-green-500 bg-green-100 rounded-md size-12 text-15 dark:bg-green-500/20 shrink-0"><i data-lucide="calendar-days"></i></div>
                                <div class="grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $totalIzin;?>">0</span></h5>
                                    <p class="text-slate-500 dark:text-zink-200">Total Izin</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-3 card-body">
                                <div class="flex items-center justify-center text-purple-500 bg-purple-100 rounded-md size-12 text-15 dark:bg-purple-500/20 shrink-0"><i data-lucide="stethoscope"></i></div>
                                <div class="grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $totalSakit;?>">0</span></h5>
                                    <p class="text-slate-500 dark:text-zink-200">Total Sakit</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-3 card-body">
                                <div class="flex items-center justify-center rounded-md size-12 text-sky-500 bg-sky-100 text-15 dark:bg-sky-500/20 shrink-0"><i data-lucide="anchor"></i></div>
                                <div class="grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="<?php echo $totalCuti;?>">0</span></h5>
                                    <p class="text-slate-500 dark:text-zink-200">Total Cuti</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end grid-->

                <div class="card" id="ordersTable">
                    <div class="card-body">
                      
                        <div class="overflow-x-auto">
                            <div class="overflow-x-auto">
                                <table class="w-full whitespace-nowrap">
                                    <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:bg-zink-600 dark:text-zink-200">
                                        <tr>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Periode</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Telat</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">P. Awal</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Sakit</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Sakit dgn Surat</th>
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Izin</th>
                                            
                                            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Cuti</th>
                                           
                         
                                     
                                        </tr>
                                    </thead>
                                    <tbody>

                                      <?php
                                      
                                      $periode_bulan = $this->session->userdata('periode_bulan'); 
                                      $periode_tahun = $this->session->userdata('periode_tahun'); 

                                      $periodeNow = $periode_tahun.'-'.$periode_bulan;
                                      $periodeNow = date('Y-m', strtotime($periodeNow));;


                                        for ($i=0; $i < count($dataRekap) ; $i++) { 
                                                $telat  = $dataRekap[$i]->telat;
                                                $p_awal = $dataRekap[$i]->pulang_awal;
                                                $sakit  = $dataRekap[$i]->sakit;
                                                $izin = $dataRekap[$i]->izin;
                                                $sakit_dgn_sk  = $dataRekap[$i]->sakit_dgn_sk;
                                                $cuti = $dataRekap[$i]->cuti;

                                                $periode  = $dataRekap[$i]->periode;
                                                $periode_name = date('F, Y', strtotime($periode));

                                                if($periodeNow==$periode){
                                                  $clastr = 'bg-yellow-100 dark:border-zink-500  border';
                                                }else{
                                                  $clastr = '';
                                                }

                                                $rekapTKD  = $this->Laporan_model->getRekapTKDPegawai($nip, $periode);
                                                if(!empty($rekapTKD)){
                                                  $capaian = $rekapTKD[0]->capaian;
                                                  $thp = rupiah($rekapTKD[0]->thp);
                                                }else{
                                                  $capaian = 0;
                                                  $thp =0;
                                                }


                                        ?>
                                   
                                        <tr class=" <?php echo  $clastr;?>">
                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500  border"><?php echo $periode_name;?></td>
                                            <td class="px-3.5 py-2.5 text-right border-y border-slate-200 dark:border-zink-500  border"><?php echo $telat ;?></td>
                                            <td class="px-3.5 py-2.5 text-right border-y border-slate-200 dark:border-zink-500  border"><?php echo $p_awal ;?></td>
                                            <td class="px-3.5 py-2.5 text-right border-y border-slate-200 dark:border-zink-500  border"><?php echo $sakit ;?></td>
                                            <td class="px-3.5 py-2.5 text-right  border-y border-slate-200 dark:border-zink-500  border"><?php echo $sakit_dgn_sk ;?></td>
                                            <td class="px-3.5 py-2.5 text-right  border-y border-slate-200 dark:border-zink-500  border"><?php echo $izin ;?></td>
                                            <td class="px-3.5 py-2.5 text-right  border-y border-slate-200 dark:border-zink-500  border"><?php echo $cuti ;?></td>
                                         
                                            
                                        </tr>
                                        <?php } ?>
                                        
                                    </tbody>
                                </table>
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

<!-- listjs init -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

<script>



</script>

</html>