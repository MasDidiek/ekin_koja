<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/css/dncalendar-skin.css">
   <style>
        .total{
            font-size:35px;
            font-weight:bold;
            padding:10px;
            float:left;
        }

        .icon{
            font-size:35px;
            font-weight:bold;
            padding:10px;
            float:right;

        }
        .clearfix{
            clear:both;
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
       $id_pegawai    = $this->session->userdata('id_pegawai');


     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
                
                 <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                    <div class="grow">
                        <h5 class="text-16">Dashboards</h5>
                    </div>
                    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                            <a href="#!" class="text-slate-400 dark:text-zink-200">Dashboards</a>
                        </li>
                        <li class="text-slate-700 dark:text-zink-100">
                        Dashboards
                        </li>
                    </ul>
                </div>
        
               
                

                <div class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
                    <div class="col-span-12 md:order-1 xl:col-span-12 2xl:col-span-12">
                        <h5 class="mb-2">Welcome, <?php echo $nama;?> 🎉</h5>
                      
                    </div>
               
                    
                    <?php
                  
                    $numCutiPending = $this->Cuti_model->getNumCutiPending($id_pegawai);
                   
                    ?>

                    
                    <div class="col-span-12 md:order-3 lg:col-span-3 2xl:col-span-3">
                         <div class="card">
                            <div class="card-body">
                                <h6 class="mb-4 text-slate-500">
                                            Pengajuan Cuti Pending
                                        </h6>
                                    <div class="total">
                                      <?php echo $numCutiPending;?>
                                    
                                    </div> 
                                    <div class="icon bg-yellow-100">
                                        <i data-lucide="clock-alert" class="inline-block size-16 text-yellow-500"></i>
                                    </div> 
                                    <div class="clearfix"></div>
                                
                                    <a class="btn inline-flex items-center gap-2 text-sm font-medium transition-all duration-200 ease-linear text-white bg-yellow-500 hover:text-custom-100" href="<?php echo base_url();?>admin/pengajuan_cuti/list_pegawai_cuti_pending">
                                        Lihat<i data-lucide="chevron-right" class="inline-block size-4"></i>
                                    </a>
                            </div>
                        </div><!--end card-->
                    </div>
                    <div class="col-span-12 md:order-4 lg:col-span-3 2xl:col-span-3">
                    <div class="card">
                            <div class="card-body">
                                <h6 class="mb-4 text-slate-500">
                                            Pengajuan Cuti Disetujui
                                        </h6>
                                    <div class="total">
                                       -
                                    
                                    </div> 
                                    <div class="icon">
                                        <i data-lucide="file-check" class="inline-block size-16 text-green-500"></i>
                                    </div> 
                                    <div class="clearfix"></div>
                                
                                    <a class="btn inline-flex items-center gap-2 text-sm font-medium transition-all duration-200 ease-linear text-white bg-green-500 hover:text-custom-100" href="#">
                                        Lihat<i data-lucide="chevron-right" class="inline-block size-4"></i>
                                    </a>
                            </div>
                        </div><!--end card-->
                    </div>
         
                    <div class="col-span-12 md:order-5 2xl:order-6 lg:col-span-3 2xl:col-span-3">
                         <div class="card">
                            <div class="card-body">
                                <h6 class="mb-4 text-slate-500">
                                            Pengajuan Cuti Total
                                        </h6>
                                    <div class="total">
                                      -
                                    
                                    </div> 
                                    <div class="icon">
                                        <i data-lucide="calendar-check" class="inline-block size-16 text-custom-500"></i>
                                    </div> 
                                    <div class="clearfix"></div>
                                
                                    <a class="btn inline-flex items-center gap-2 text-sm font-medium transition-all duration-200 ease-linear text-white bg-custom-500 hover:text-custom-100" href="#">
                                        Lihat<i data-lucide="chevron-right" class="inline-block size-4"></i>
                                    </a>
                            </div>
                        </div><!--end card-->
                    </div>
                    <div class="col-span-12 md:order-6 2xl:order-7 lg:col-span-3 2xl:col-span-3 ">
                         <div class="card">
                            <div class="card-body">
                                <h6 class="mb-4 text-slate-500">
                                           Aktifitas Kinerja
                                        </h6>
                                    <div class="total">
-
                                    
                                    </div> 
                                    <div class="icon">
                                        <i data-lucide="calendar-check2" class="inline-block size-16 text-sky-500"></i>
                                    </div> 
                                    <div class="clearfix"></div>
                                
                                    <a class="btn inline-flex items-center gap-2 text-sm font-medium transition-all duration-200 ease-linear text-white bg-sky-500 hover:text-custom-100" href="#">
                                        Lihat<i data-lucide="chevron-right" class="inline-block size-4"></i>
                                    </a>
                            </div>
                        </div><!--end card-->
                    </div>
                 
                    <div class="col-span-12 md:order-11 lg:col-span-6 xl:col-span-12 2xl:col-span-12 card">
                        <div class="!pb-0 card-body">
                            <h6 class="mb-3 text-15">Pengajuan Cuti</h6>
                        </div>
                        <div class="pb-5">
                            <div data-simplebar="" class="flex flex-col h-[350px] gap-4 px-5">
                                <div class="flex flex-col gap-3">
                                    <div class="dark:border-zink-500">
                                        <div class="flex flex-col gap-4 mt-3">

                                            <?php
                                                for ($i=0; $i < count($list_pegawai_cuti) ; $i++) { 
                                                    $tgl_dl = $list_pegawai_cuti[$i]->tgl_dari;
                                                    $jns_dl = $list_pegawai_cuti[$i]->jns_cuti;
                                                    $hari_cuti = $list_pegawai_cuti[$i]->hari_cuti;
                                                    $nama = $list_pegawai_cuti[$i]->nama;
                                                    $keterangan = $list_pegawai_cuti[$i]->alasan_cuti;
                                                    $id_cuti = $list_pegawai_cuti[$i]->id;
                                                    
                                                    
                                               
                                                    $tgl_dari = $list_pegawai_cuti[$i]->tgl_dari;
                                                    $tgl_sampai = $list_pegawai_cuti[$i]->tgl_sampai;

                                                    echo ' <div class="flex gap-3">
                                                            <div class="flex flex-col items-center justify-center border rounded-sm size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                                             <span class="text-sm text-slate-500 dark:text-zink-200 ">PEND</span>
                                                             </div>

                                                            <div class="grow">
                                                                <h6 class="mb-1"> <span class="p-1 bg-sky-100 text-sky-500 rounded py-1.5  text-[11px]"> Tahunan </span> - '.$nama.' <small class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-slate-100 text-slate-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent">'.$hari_cuti.' hari</small></h6>
                                                                
                                                                 <small class="inline-block px-2 font-medium border border-transparent rounded text-[11px] py-0.5 bg-orange-100 text-zink-500 dark:bg-slate-500/20 dark:text-zink-200 dark:border-transparent"> '.format_semi($tgl_dari).' &nbsp; - &nbsp;  '.format_semi($tgl_sampai).'  </small>
                                                                <p class="text-slate-500 dark:text-zink-200">'.$keterangan.'</p>
                                                            </div>
                                                                <div class="flex flex-col items-center justify-center  size-12 border-slate-200 dark:border-zink-500 shrink-0">
                                                                 <button type="button"  value="'.$id_cuti.'"  data-modal-target="infoAbsen" class="btn-info-cuti btn inline-flex items-center gap-2 text-sm font-medium transition-all duration-200 ease-linear text-white bg-custom-500 hover:text-custom-100">Setujui</button>
                                                                </div>
                                                              
                                                            </div>';
                                                }
                                            ?>




      
                                                    <a href="<?php echo base_url();?>admin/pengajuan_cuti/list_pegawai_cuti_all" class="mt-4">Lihat Semua</a>
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

   
    <div id="infoAbsen" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
            <div class="w-screen md:w-[40rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                    <h5 class="text-16">Detail Cuti</h5>
                    <button data-modal-close="infoAbsen" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                </div>
                <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto" id="modalinfocuti">
                                                                
                

                    <div id="btn_delete_absensi"></div>                                            

                </div>
               
            </div>
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







</body>

<script type="text/javascript">
		$(document).ready(function() {
		    $(".btn-info-cuti").click(function(){
                var id_cuti = $(this).val();

                $.ajax({

                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/pengajuan_cuti/ajaxDetailCuti",
                            data:"id_cuti="+id_cuti,
                            success:function(msg){
                              $("#modalinfocuti").html(msg);
                            }

                      });

              });
		});

    

                
		</script>

</script>

</html>