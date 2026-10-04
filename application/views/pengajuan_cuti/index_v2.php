<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
   <?php $this->load->view('layout/header');?>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">
<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    <?php 
       $this->load->view('layout/sidebar');
       $this->load->view('layout/topheader');

       $info = $this->session->flashdata('message');

     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Pengajuan Cuti Pegawai</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Cuti</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                    Pengajuan Cuti
                    </li>
                </ul>
            </div>

            <?php
            	$tanggal_cuti = $this->session->userdata('tanggal_cuti');
                $status_session = $this->session->userdata('status');
            ?>

            <input type="hidden" id="info" value="<?php echo $info;?>">

             <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-12">
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-3 card-body">
                                <div class="flex items-center justify-center rounded-md size-12 text-15 bg-custom-100 text-custom-500 dark:bg-custom-500/20 shrink-0"><i data-lucide="file-bar-chart-2"></i></div>
                                <div class="grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="18">0</span>/<span class="counter-value" data-target="60">0</span></h5>
                                    <p class="text-slate-500 dark:text-zink-200">Today/Presents Leave</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-3 card-body">
                                <div class="flex items-center justify-center text-green-500 bg-green-100 rounded-md size-12 text-15 dark:bg-green-500/20 shrink-0"><i data-lucide="calendar-check"></i></div>
                                <div class="grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="5">0</span></h5>
                                    <p class="text-slate-500 dark:text-zink-200">Today Leaves</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-3 card-body">
                                <div class="flex items-center justify-center text-purple-500 bg-purple-100 rounded-md size-12 text-15 dark:bg-purple-500/20 shrink-0"><i data-lucide="codepen"></i></div>
                                <div class="grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="0">0</span></h5>
                                    <p class="text-slate-500 dark:text-zink-200">Unplanned Leaves</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="flex items-center gap-3 card-body">
                                <div class="flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-md size-12 text-15 dark:bg-yellow-500/20 shrink-0"><i data-lucide="loader"></i></div>
                                <div class="grow">
                                    <h5 class="mb-1 text-16"><span class="counter-value" data-target="6">0</span></h5>
                                    <p class="text-slate-500 dark:text-zink-200">Pending Leaves</p>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end grid-->

              <div class="card" id="customerList">
                 <form action="<?php echo base_url();?>admin/pengajuan_cuti/search_cuti" method="post">
                    <div class="card-body">
                       <div class="grid grid-cols-1 gap-5 mb-5 xl:grid-cols-12">
                       
                            <div class="xl:col-span-2">
                                    <input type="text" class="ltr:pl-8 rtl:pr-8 search form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Search for ..." autocomplete="off">
                                    <i data-lucide="search" class="inline-block size-4 absolute ltr:left-2.5 rtl:right-2.5 top-2.5 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-600"></i>
                                </div>
                                
                                <div class="xl:col-span-2">
                                	<?php
                                        $status_pending = FALSE;
                                        $status_approve = FALSE;
                                        $status_cancel = FALSE;
                                        $status_reject = FALSE;

                                        if($status_session=='pending'){
                                            $status_pending = TRUE;
                                        }else if($status_session=='approve'){
                                            $status_approve = TRUE;
                                        }else if($status_session=='cancel'){
                                            $status_cancel = TRUE;
                                        }else if($status_session=='reject'){
                                            $status_reject = TRUE;
                                        }
                                        
                                    ?>

                                    <select  name="status" id="status"  data-choices="" >
                                            <option value="">Status</option>
                                            <option value="pending" <?php echo  set_select('status', 'pending', $status_pending); ?>>Pending</option>
                                            <option value="approve" <?php echo  set_select('status', 'pending', $status_approve); ?>>Disetujui</option>
                                            <option value="reject" <?php echo  set_select('status', 'pending', $status_reject); ?>>Ditolak</option>
                                            <option value="cancel" <?php echo  set_select('status', 'pending', $status_cancel); ?>>Batal</option>
                                           
                                            
                                    </select>
                                </div>

                                <div class="xl:col-span-2">
                                  
                                    <input type="text" value="<?php echo $tanggal_cuti ;?>" name="tanggal_cuti" class="ltr:pl-5 rtl:pr-10 form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" data-provider="flatpickr" data-date-format="d-m-Y" data-range-date="true" readonly="readonly" placeholder="Select Date">
                                </div>

                                <div class="xl:col-span-2">
                                 <button type="submit" id="search" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20"><i class="align-bottom ri-search-line me-1"></i> Search</button>
                                </div>
                                
                        </div>
                     </form>
                        
                        <div class="info_delete mb-4"></div>
                        
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap" id="customerTable">
                                <thead class="bg-slate-100 dark:bg-zink-600">
                                     <tr>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">#</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 nama_pegawai">Nama</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 jenis_cuti">Jenis Cuti</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 alasan_cuti">Alasan Cuti</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 hari">Hari</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 dari">Dari</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sampai">Sampai</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 status">Status</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    
                                  <?php
                                      $no = 0;

                                            $id_pegawai_validator = $this->session->userdata('id_pegawai');  //id atasan yang sedang login

                                            // print_array($list_cuti);
                                                for ($a=0; $a < count($list_cuti); $a++) {
                                                    
                                                        $nama_pegawai = $list_cuti[$a]->nama;
                                                        $hari_cuti = $list_cuti[$a]->hari_cuti;
                                                        $tgl_dari = $list_cuti[$a]->tgl_dari;
                                                        $tgl_sampai = $list_cuti[$a]->tgl_sampai;
                                                        $alasan_cuti = $list_cuti[$a]->alasan_cuti;
                                                        $jns_cuti = $list_cuti[$a]->jns_cuti;
                                                        $status = $list_cuti[$a]->status;

                                                        if($jns_cuti==1){
                                                                $jns = 'Tahunan';
                                                        }else if($jns_cuti==2){
                                                            $jns = 'Bersalin';
                                                        }else if($jns_cuti==3){
                                                            $jns = 'Sakit';
                                                        }else if($jns_cuti==4){
                                                            $jns = 'Alasan Penting';
                                                        }else{
                                                            $jns = 'Besar';
                                                        }
                                                        
                                                        
                                                        $flagStatus = getStatusCuti($status);
                                                
                                                        $no = $a+1;
                                                
                                                    echo '<tr>

                                                                <td  class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.$no .'</td>
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 nama_pegawai">
                                                                <a href="'.base_url().'admin/pengajuan_cuti/detail_cuti/'.$list_cuti[$a]->id.'" class="text-primary">'.$nama_pegawai.'</a>
                                                                </td>
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.$jns.'</td>
                                                                 <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.word_limiter($alasan_cuti,5).'</td>
                                                               
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.$hari_cuti.'</td>
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.format_view($tgl_dari).'</td>
                                                                 <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.format_view($tgl_sampai).'</td>
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">'.$flagStatus.'</td> 
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                                <div class="flex gap-2">
                                                                    <a href="'.base_url().'admin/pengajuan_cuti/detail_cuti/'.$list_cuti[$a]->id.'" class="btn-view flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 text-custom-500 bg-custom-100 hover:text-white hover:bg-custom-500 dark:bg-zink-600 dark:text-zink-200 dark:hover:text-white dark:hover:bg-custom-500"  title="lihat detail cuti"><i data-lucide="eye" class="size-4"></i></a>
                                                                    ';

                                                                    if($status=='PEND1'){
                                                                        echo '  <button type="button" data-modal-target="smallModal" value="'.$list_cuti[$a]->id.'" class="btn-acc flex items-center justify-center text-green-500 transition-all duration-200 ease-linear bg-green-100 rounded-md size-8 hover:text-white hover:bg-green-500 dark:bg-green-500/20 dark:hover:bg-green-500"  title="setujui cuti"><i data-lucide="check" class="size-4"></i></button>
                                                                    <button type="button" data-modal-target="smallModal" value="'.$list_cuti[$a]->id.'" data-modal-target="deleteModal" class="btn-reject flex items-center justify-center text-red-500 transition-all duration-200 ease-linear bg-red-100 rounded-md size-8 hover:text-white hover:bg-red-500 dark:bg-red-500/20 dark:hover:bg-red-500" title="tolak cuti"><i data-lucide="triangle-alert" class="size-4"></i></button>';
                                                                    }else{
                                                                        echo '  <span class="flex items-center justify-center text-slate-500 transition-all duration-200 ease-linear bg-slate-100 rounded-md size-8 dark:bg-slate-500/20 dark:hover:bg-slate-500"  title="setujui cuti"><i data-lucide="check" class="size-4"></i></span>
                                                                            <span class="flex items-center justify-center text-slate-500 transition-all duration-200 ease-linear bg-slate-100 rounded-md size-8  dark:bg-slate-500/20 dark:hover:bg-slate-500" title="tolak cuti"><i data-lucide="triangle-alert" class="size-4"></i></span>';
                                                                    }
                                                                  
                                                               echo '</div>
                                                            </td>
                                                            
                                                        </tr>';

                                                }
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

                  <div id="smallModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                        <div class="w-screen md:w-[25rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                <h5 class="text-16" id="modal_heading">Modal Heading</h5>
                                <button data-modal-close="smallModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                            </div>
                            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                                <h5 class="mb-3 text-16" id="confirm-title">Modal Content</h5>
                                <br>
                                  <center>
                                    <button type="button" id="id_cuti" value="" class="confirm-acc-cuti text-white mr-2 btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                                        <i class="align-baseline ltr:pr-1 rtl:pl-1 ri-check-line"></i> Iya, Setujui
                                    </button>
                                    <button type="button" data-modal-close="smallModal"  class="cancel-btn text-red-500 bg-red-100 btn hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20">Tidak <i class="align-baseline ltr:pl-1 rtl:pr-1 ri-close-line"></i></button>
                                

                                    <button type="button" style="display: none;" class="loading-btn flex items-center text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                            <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            Processing...
                                    </button>

                                    <div class="info-acc"></div>
                                
                                </center>

                                 <br>
                            </div>
                    </div>
                    
                </div>  

                <div id="extraLargeModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                    <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                        <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                            <h5 class="text-16">Detail Cuti</h5>
                            <button data-modal-close="extraLargeModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                        </div>
                        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                            <div id="info_detail_cuti"></div>
                          
                            <button type="button" class="text-red-500 bg-red-100 btn hover:text-white hover:bg-red-600 focus:text-white focus:bg-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:ring active:ring-red-100 dark:bg-red-500/20 dark:text-red-500 dark:hover:bg-red-500 dark:hover:text-white dark:focus:bg-red-500 dark:focus:text-white dark:active:bg-red-500 dark:active:text-white dark:ring-red-400/20">Close <i class="align-baseline ltr:pl-1 rtl:pr-1 ri-close-line"></i></button>

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

<!-- listjs init -->
<script src="<?php echo base_url();?>assets/premium/js/pages/listcuti.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
Usage
</body>

<script>



$(document).ready(function() {

    $(".btn-acc").click(function(){
        var id = $(this).val();

        $("#modal_heading").html("Persetujuan Cuti");
        $("#confirm-title").html("Apakah anda ingin menyetujui Cuti ini?");
        $("#id_cuti").val(id);
       

    });
 

    $(".confirm-acc-cuti").click(function(){
        var id = $(this).val();
        $(this).hide();
        $(".cancel-btn").hide();
        $(".loading-btn").show();

        $.ajax({

            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>admin/pengajuan_cuti/accCutiKapuskel",
            data:"id_cuti="+id,
                success:function(msg){
                    $(".cancel-btn").html("Tutup");
                    $(".cancel-btn").show();
                    $(".loading-btn").hide();
                  
                    Toastify({
                            text: 'Success!! Cuti telah berhasil disetujui ',
                            duration: 3000,
                            close: true,
                            className: "success",
                            gravity: "top", // `top` or `bottom`
                            position: "right", // `left`, `center` or `right`
                            stopOnFocus: true, // Prevents dismissing of toast on hover
                            style: {
                                background: "#2f8f4c",
                                color: "#FFF"
                            },
                            onClick: function(){} // Callback after click
                        }).showToast();

                    setTimeout(function(){
                          window.location.reload();
                        }, 2000);
                }

            });

    });



    $(".btn-view").click(function(){
        var id = $(this).val();
    
        $.ajax({

            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>admin/pengajuan_cuti/ajaxDetailCuti",
            data:"id_cuti="+id,
                success:function(msg){
                    $("#info_detail_cuti").html(msg);
                }

            });

    });


  
    var info = $("#info").val();

        if(info !=''){
            Toastify({
            text: info,
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


});

  


</script>

</html>