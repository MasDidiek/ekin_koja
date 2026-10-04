<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

   <style>
    .bg-success{
        background: #30cb8c;
    }
    .bg-success:hover{
        background: #1ca86f;
    }
   </style>
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $info = $this->session->flashdata('message');

     ?>
   
   <input type="hidden" name="info" id="info" value="<?php echo $info;?>">
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Dinas Luar </h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Absensi</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                    Dinas Luar
                    </li>
                </ul>
            </div>

            <?php
            
                 $id_pegawai = $this->session->userdata('id_pegawai'); 
              

            ?>

         
                    <div id="smallModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                        <div class="w-screen md:w-[25rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                <h5 class="text-16" id="modal_heading">Dinas Luar</h5>
                                <button data-modal-close="smallModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                            </div>
                            <form action="<?php echo base_url();?>cuti/check_date" method="post">
                              <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                                 <div class="mb-3">
                                    <label>Tanggal Cuti</label>
                                    <input type="text" name="tgl_cuti" required class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" data-provider="flatpickr" data-date-format="d M, Y" data-range-date="true" placeholder="Select Date">
                                </div>

                                <div class="mb-3">
                                    <label>Jenis Cuti</label>
                                  
                                </div>
                                 <div class="mb-3">
                                      <label>Hak  Cuti yang digunakan:</label>
                                    
                                       
                           

                                  </div>

                                  <br>

                                  <button type="submit"  class="float-right ml-2 text-white btn bg-success border-success ">
                                     Submit
                                </button>
                                  <button type="button" data-modal-close="smallModal"  class="float-right  text-red-500 bg-red-100 btn hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20"> <i class="align-baseline ltr:pl-1 rtl:pr-1 ri-close-line"></i> Cancel</button>
                                  </form>
                            </div>
                       </div>
                    </div><!--close modal form cuti-->


                    <div class="grid grid-cols-1 gap-x-5 2xl:grid-cols-12">
                            <div class="2xl:col-span-12">
                               
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 text-15">Log Cuti</h6>
                                        
                                        <hr>
                                          <br>
                                        <div class="overflow-x-auto">



                                         <table class="w-full whitespace-nowrap mt-4">
                                            <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                                                <tr>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Date Created</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Tanggal Cuti</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Hari Cuti</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Jenis Cuti</th>
                                                   
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Keterangan</th>
                                                   
                                              
                                                   
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Alasan Cuti</th>
                                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Sisa Cuti</th>
                                                </tr>
                                            </thead>

                                          
                                               <tbody>
                                         
                                               <?php

                                                    $path   = 'uploads/surat_tugas/';
                                                    $no = 1;

                                                    //print_array($pengajuan_dinas_luar);
                                                    foreach ($logCuti as $log) {

                                                      $id_pegawai = $log->id_pegawai;
                                                      $id = $log->id;
                                                      $jns_cuti = $log->jns_cuti;
                                                      $jumlah_hari = $log->jumlah_hari;
                                                      $keterangan = $log->keterangan;
                                                      $sisa_akhir = $log->sisa_akhir;
                                                      $alasan_cuti = $log->alasan_cuti;
                                                      $tgl_dari = $log->tgl_dari;
                                                      $tgl_sampai = $log->tgl_sampai;
                                                      $create_at = $log->date_create;
                                                      
                                                      if($jns_cuti==1){
                                                        $jenis_cuti = 'Tahunan';
                                                      }else if($jns_cuti==2){
                                                        $jenis_cuti = 'Cuti Bersalin';
                                                      }else if($jns_cuti==3){
                                                        $jenis_cuti = 'Cuti Alasan Penting';
                                                      }else if($jns_cuti==4){
                                                        $jenis_cuti = 'Cuti Sakit';
                                                      }else if($jns_cuti==5){
                                                        $jenis_cuti = 'Cuti Besar';
                                                      }else{
                                                        $jenis_cuti = 'Cuti Bersalin Anak 3';
                                                      }

                                                      echo ' <tr>                
                                                                <td class="text-center px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">' . format_semi($create_at) . '</td>
                                                                 <td class="text-left px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">';
                                                                   if($jumlah_hari==1){
                                                                        echo getNamahari($tgl_dari).', '.format_full($tgl_dari);
                                                                    }else{
                                                                        echo getNamahari($tgl_dari).', '.format_full($tgl_dari) .' s/d '. getNamahari($tgl_sampai).', '.format_full($tgl_sampai);;
                                                                    }
                                                                echo '
                                                                   <td class="text-center px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">' . $jumlah_hari . '</td>
                                                                   <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">' . $jenis_cuti . ' </td>
                                                                <td class="text-left px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500"> ' . $keterangan . '</td>
                                                             
                                                                 
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">' . $alasan_cuti . ' </td>
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">' . $sisa_akhir . ' </td>
                                                                                         
                                                                
                                                            </tr>';

                                                      $no += 1;
                                                    }

                                                    ?>



                                                </tbody>
                                            </table>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div><!--end col-->
                           <!--end col-->
                        </div><!--end grid-->

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
<script src="<?php echo base_url();?>assets/premium/js/pages/listcuti.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
Usage
</body>

<script>

  


</script>

</html>