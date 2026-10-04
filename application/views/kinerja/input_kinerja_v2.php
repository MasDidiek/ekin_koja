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

    #ajaxlist_aktifitas,  #list_keterangan{
        border: 1px solid #EEE;
        padding: 10px;
        max-height: 300px;
        overflow-y: scroll;
        display: none;
    }



    .list-aktifitas, .list-keterangan{
        border-bottom: 1px solid #EEE;
        padding: 5px;
        cursor: pointer;
    }

    .list-aktifitas:hover{
        color: orangered;
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
        $id_pegawai   = $this->session->userdata('id_pegawai');

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


     
        $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
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
        $persenApprove = ($totalApprove/$totalInput)*100;


        $totalReject = $this->Kinerja_model->getAktifitasByStatus($id_pegawai, $periode, 2);
        if($totalReject==''){
            $totalReject  = 0;
        }
        $persenReject = ($totalReject/$totalInput)*100;

     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Input Kinerja</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Kinerja</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                     Input Kinerja
                    </li>
                </ul>
            </div>
            <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-12">
                    <div class="xl:col-span-9">
                        <div class="card">
                            <div class="card-body">
                                <div cursor-pointerid='calendar-container'>
                                    <button type="hidden" id="calendarBtn" data-modal-target="event-modal"></button>
                                    <div id='calendar'></div>
                                </div>
                            </div>
                        </div>
                    </div><!--end col-->

                  

                    <div class="xl:col-span-3">
                        <div class="card">
                            <div class="card-body">
           
                           
                                 <strong class="mb-4 text-15">Waktu Efektif</strong>

                                 <span class="float-right">   Periode :  <strong> <?php echo  $nm_bulan.' '.$tahun;?> </strong> </span>  

                                 <div class="p-4 mt-3">
                                    <div class="grid grid-cols-6">
                                        <div class="px-4 text-center ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500 ltr:last:border-r-0 rtl:last:border-l-0">
                                            <h5 class="mb-1 font-bold"><span class="counter-value" data-target="<?php echo $menitEfektifBulanan ;?>">0</span> menit</h5>
                                            <p class="text-slate-500 dark:text-zink-200"> Jumlah minimal menit aktifitas yang harus diinput pada periode tersebut</p>
                                           
                                        </div>
                                     
                                   
                                    </div>
                                </div>


                                <hr> <br>
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


                                <hr> <br>

                                <h6 class="mb-4 text-15 mt-4">Template aktifitas </h6>
                                <div id='external-events' class="flex flex-col gap-3 mb-4">

                                                <?php
                                                // for ($i=0; $i < 5 ; $i++) { 
                                                //     $nama_kegiatan = @$freqAktifitas[$i]->nama_kegiatan;
                                                //     $waktu = @$freqAktifitas[$i]->waktu_efektif;

                                                //     echo '  <button style="text-align:left" data-modal-target="event-modal" data-class="transition-all w-[100%] text-custom-500 !bg-custom-100 dark:!bg-custom-500/20 border-none rounded-md py-1.5 px-3" class="external-event fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event text-custom-500 btn bg-custom-100 hover:text-white hover:bg-custom-600 focus:text-white focus:bg-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:ring active:ring-custom-100 dark:bg-custom-500/20 dark:text-custom-500 dark:hover:bg-custom-500 dark:hover:text-white dark:focus:bg-custom-500 dark:focus:text-white dark:active:bg-custom-500 dark:active:text-white dark:ring-custom-400/20">
                                                //                 '.word_limiter($nama_kegiatan, 5).'
                                                //             </button> ';

                                                // }
                                                ?>
                                                

                            
                                    <div class="flex items-center gap-2">
                                        <input id='businessCalendar' class="size-4 cursor-pointer bg-white border border-slate-200 checked:bg-none dark:bg-zink-700 dark:border-zink-500 rounded-sm appearance-none arrow-none relative after:absolute after:content-['\eb7b'] after:top-0 after:left-0 after:font-remix after:leading-none after:opacity-0 checked:after:opacity-100 after:text-custom-500 checked:border-custom-500 dark:after:text-custom-500 dark:checked:border-custom-800" type="checkbox">
                                        <label for="businessCalendar" class="align-middle cursor-pointer">
                                            Business Hours & Week
                                        </label>
                                    </div>
        
                                    <div class="flex items-center gap-2">
                                        <input id='weekNumberCalendar' class="size-4 cursor-pointer bg-white border border-slate-200 checked:bg-none dark:bg-zink-700 dark:border-zink-500 rounded-sm appearance-none arrow-none relative after:absolute after:content-['\eb7b'] after:top-0 after:left-0 after:font-remix after:leading-none after:opacity-0 checked:after:opacity-100 after:text-custom-500 checked:border-custom-500 dark:after:text-custom-500 dark:checked:border-custom-800" type="checkbox">
                                        <label for="weekNumberCalendar" class="align-middle cursor-pointer">
                                            Week Number
                                        </label>
                                    </div>
                                </div>



                                <a href="<?php echo base_url();?>kinerja/list_kinerja" class="btn btn-info">Data List Kinerja</a>

                            </div>
                        </div>
                    </div><!--end col-->
                </div><!--end grid-->

            

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    
<div id="event-modal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 ">
    <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600">
        <div class="flex items-center justify-between p-4 border-b dark:border-zink-500">
            <h5 class="text-16" id="modal-title">Add Event</h5>
            <button data-modal-close="event-modal" id="eventModal-close" class="transition-all duration-200 ease-linear text-slate-400 hover:text-red-500"><i data-lucide="x" class="w-5 h-5"></i></button>
        </div>
        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
             <div id="info_absen"></div>
            <form class="needs-validation" name="event-form" id="form-event" autocomplete="off">
                <div class="grid grid-cols-1 gap-4 xl:grid-cols-12">
                    <div class="xl:col-span-6">
                        <label for="tgl_kegiatan" class="inline-block mb-2 text-base font-medium">Tanggal </label>
                        <input type="text" name="tgl_kegiatan" id="tgl_kegiatan" value="" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    </div>


                    <div class="xl:col-span-12">
                        <label for="aktifitas" class="inline-block mb-2 text-base font-medium">Aktifitas</label>
                        <input type="text" id="aktifitas" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="cari aktifitas" required="">
                        <div id="ajaxlist_aktifitas"></div>
                    </div>

                    <div class="xl:col-span-6">
                        <label for="jam_mulai" class="inline-block mb-2 text-base font-medium">Jam Mulai </label>
                        <input type="text"  name="jam_mulai" id="jam_mulai" value="06:00" class="time jam_mulai form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    </div>
                    <div class="xl:col-span-6">
                        <label for="jam_selesai" class="inline-block mb-2 text-base font-medium">Jam Selesai</label>
                        <input type="text" name="jam_selesai" id="jam_selesai" value="07:00" class="time durationNegativeMinMax form-input-kinerja form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    </div>


                    <div class="xl:col-span-6">
                        <label for="waktu_efektif" class="inline-block mb-2 text-base font-medium"> Waktu Efektif  </label> <span class="text-danger">*</span></label>
                        <input  type="number" id="waktu_efektif" name="waktu_efektif" value="0" value="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    </div>
                    <div class="xl:col-span-6">
                        <label for="volume" class="inline-block mb-2 text-base font-medium">Volume</label><span class="text-danger">*</span></label>
                        <input  type="number" id="volume" name="vol" required  autocomplete="off"  value="0" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    </div>

                  
            
                  

                    <div class="xl:col-span-12">
                   
                        <label for="keterangan" class="inline-block mb-2 text-base font-medium">Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"  rows="2" cols="10" wrap="soft"></textarea>
                   <div id="list_keterangan"></div>
                    </div>
                </div>
                <div class="flex justify-end gap-2 mt-4">
                    <button type="reset" data-modal-close="event-modal" class="text-red-500 bg-white btn hover:text-red-500 hover:bg-red-100 focus:text-red-500 focus:bg-red-100 active:text-red-500 active:bg-red-100 dark:bg-zink-600 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 dark:active:bg-red-500/10">Cancel</button>
                    <button type="reset" id="btn-delete-event" value="" data-modal-close="event-modal" class="hidden text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20">Delete</button>
                    <button type="submit" id="btn-save-event" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end event modal -->


      <?php $this->load->view('layout/footer');?>


    </div>

</div>

<div class="fixed items-center hidden bottom-6 right-12 h-header group-data-[navbar=hidden]:flex">
    <button data-drawer-target="customizerButton" type="button" class="inline-flex items-center justify-center w-12 h-12 p-0 transition-all duration-200 ease-linear rounded-md shadow-lg text-sky-50 bg-sky-500">
        <i data-lucide="settings" class="inline-block w-5 h-5"></i>
    </button>
</div>

<?php

    //print_array($cutiPegawai);


    $arrayAktifitas = array();
 
    foreach ($cutiPegawai as $cuti ) {
        $tgl_dari    = $cuti->tgl_dari;
        $tgl_sampai    = $cuti->tgl_sampai;
        $status         = $cuti->status;
        $alasan_cuti         = $cuti->alasan_cuti;

        if($status=='APPROVE'){
              $arrayAktifitas[] = array(
                    'id'=> $cuti->id,
                    'title' => 'Cuti : '.$alasan_cuti,
                    'start' => $tgl_dari,
                    'end' => $tgl_sampai,
                    'className' =>'w-[100%] text-red-500 bg-red-100 dark:!bg-red-500/20 border-none rounded-md py-1.5 px-3'

                );

        }
      
    }

    foreach ($izinSakit as $row ) {
        $tanggal    = $row->tanggal;
        $jenis_absen    = $row->jenis_absen;
        $keterangan    = $row->keterangan;
     


   
            $arrayAktifitas[] = array(
                'id'=> 0,
                'title' => $jenis_absen.' : '.$keterangan,
                'start' => $tanggal,
                'end' => $tanggal,
                'className' =>'w-[100%] text-red-500 bg-red-100 dark:!bg-red-500/20 border-none rounded-md py-1.5 px-3'

            );

    
      
    }


    


    foreach ($dataAktifitasPegawai as $akt ) {


        $nama_kegiatan = $akt->nama_kegiatan;
        $tgl            = $akt->tgl;
        $jam_mulai    = $akt->jam_mulai;
        $jam_selesai    = $akt->jam_selesai;
        $status         = $akt->status;

        if($status==0){
            $className = 'text-yellow-500 w-[100%] !bg-yellow-100 dark:!bg-yellow-500/20 border-none rounded-md py-1.5 px-3';
        }else if($status==1){
            $className = 'w-[100%] text-green-500 !bg-green-100 dark:!bg-green-500/20 border-none rounded-md py-1.5 px-3';
        }else{
            $className = 'w-[100%] text-orange-500 !bg-red-100 dark:!bg-red-500/20 border-none rounded-md py-1.5 px-3';
        }

        $arrayAktifitas[] = array(
            'id'=> $akt->id,
            'title' => $nama_kegiatan,
            'start' => $tgl.' '.$jam_mulai,
            'end' => $tgl.' '.$jam_selesai,
            'className' => $className

        );

    }    

    $kegiatanList = json_encode($arrayAktifitas);

   // echo $kegiatanList;
    
   // print_array($arrayAktifitas);

?>

<?php $this->load->view('layout/theme_config');?>
<?php $this->load->view('layout/mainjs');?>



<!-- calendar min js -->
<script src="<?php echo base_url();?>assets/premium/libs/fullcalendar/index.global.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/jquery-clock-timepicker.js"></script>
</body>

<script>
 $("#ajaxlist_aktifitas").hide();


// /*
// Template Name: tailwik - Admin & Dashboard Template
// Author: StarCode Kh
// Website: https://StarCode Kh.in/
// Contact: StarCode Kh@gmail.com
// File: Calendar init js
// */

// Constants
const getElement = (id) => document.getElementById(id);
const calendarEl = getElement('calendar');
const checkbox = getElement('drop-remove');
const businessHoursCheckbox = getElement('businessCalendar');
const weekNumberCalendar = getElement('weekNumberCalendar');
const modalTitle = getElement('modal-title');
const formEvent = getElement('form-event');
const eventModal = getElement('event-modal');

id_event = 0;

const aktifitasInput = getElement('aktifitas');
const tanggalInput = getElement('tgl_kegiatan');
const jam_mulaiInput = getElement('jam_mulai');
const jam_selesaiInput = getElement('jam_selesai');
const waktu_efektifInput = getElement('waktu_efektif');
const volumeInput = getElement('volume');
const keteranganInput = getElement('keterangan');
const deleteEventBtn = getElement('btn-delete-event');
const saveEventBtn = getElement('btn-save-event');
const localeSelect = getElement('locale-select');
const eventModalCloseBtn = getElement('eventModal-close');
const tglKegiatan = document.getElementById(tgl_kegiatan);

// Variables
let selectedEvent = null;
let newEventData = null;


// Functions
const initializeDraggable = () => {
    const externalEventContainerEl = getElement('external-events');
    new FullCalendar.Draggable(externalEventContainerEl, {
        itemSelector: '.external-event',
        eventData: (eventEl) => ({
            title: eventEl.innerText,
            start: new Date(),
            className: eventEl.getAttribute('data-class'),
        }),
    });
};

const getDefaultEvents = () => {
    const date = new Date();
    const d = date.getDate();
    const m = date.getMonth();
    const y = date.getFullYear();

    // return [
    //     { title: 'Membuat daftar gaji/tunjangan/penghasilan lainnya', start: new Date(y, m, 5, 8,30), end: new Date(y, m, 5, 12,0), className: 'w-[100%] text-orange-500 !bg-yellow-100 dark:!bg-yellow-500/20 border-none rounded-md py-1.5 px-3' },
    //     { title: 'Memperbaiki jaringan internet', start: new Date(y, m, 5, 13,0), className: 'w-[100%] text-green-500 !bg-green-100 dark:!bg-green-500/20 border-none rounded-md py-1.5 px-3' },
    //     { id: 999, title: 'Repeating Event', start: new Date(y, m, d - 3, 16, 0), allDay: false, className: 'text-yellow-500 w-[100%] !bg-yellow-100 dark:!bg-yellow-500/20 border-none rounded-md py-1.5 px-3' },
    //     { id: 999, title: 'Repeating Event', start: new Date(y, m, d + 4, 16, 0), allDay: false, className: 'w-[100%] text-custom-500 !bg-custom-100 dark:!bg-custom-500/20 border-none rounded-md py-1.5 px-3' },
    //     { title: 'Meeting', start: new Date(y, m, d, 10, 30), allDay: false, className: 'text-green-500 w-[100%] !bg-green-100 dark:!bg-green-500/20 border-none rounded-md py-1.5 px-3' },
    //     { title: 'Lunch', start: new Date(y, m, d, 12, 0), end: new Date(y, m, d, 14, 0), allDay: false, className: 'text-purple-500 w-[100%] !bg-purple-100 dark:!bg-purple-500/20 border-none rounded-md py-1.5 px-3' },
    //     { title: 'Birthday Party', start: new Date(y, m, d + 1, 19, 0), end: new Date(y, m, d + 1, 22, 30), allDay: false, className: 'w-[100%] text-sky-500 !bg-sky-100 dark:!bg-sky-500/20 border-none rounded-md py-1.5 px-3' },
    //     { title: 'Click for Google', start: new Date(y, m, 28), end: new Date(y, m, 29), url: 'http://google.com/', className: 'w-[100%] text-custom-500 !bg-custom-100 dark:!bg-custom-500/20 border-none rounded-md py-1.5 px-3' }
    // ];

    return <?php echo  $kegiatanList;?>;
};

const addNewEvent = (info) => {
    formEvent.classList.remove('was-validated');
    formEvent.reset();
    selectedEvent = null;
    modalTitle.innerText = 'Input Kegiatan Harian';
    newEventData = info;
    tgl_pilih = newEventData.date;

    const formattedDate = `${tgl_pilih.getDate()}-${tgl_pilih.getMonth() + 1}-${tgl_pilih.getFullYear()}`;
    document.getElementById("btn-delete-event").style.display="none";
    $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>kinerja/cekTanggal',
                data: "tanggal="+formattedDate,
                success: function(msg) {
                    let cekStatus = msg.includes("Warning");
                    if(cekStatus){
                        document.getElementById("jam_mulai").disabled = true;
                        document.getElementById("jam_selesai").disabled = true;
                        document.getElementById("aktifitas").disabled = true;
                        document.getElementById("volume").disabled = true;
                        document.getElementById("btn-save-event").style.display="none";
              
                    }else{
                        document.getElementById("jam_mulai").disabled = false;
                        document.getElementById("jam_selesai").disabled = false;
                        document.getElementById("aktifitas").disabled = false;
                        document.getElementById("volume").disabled = false;
                        document.getElementById("btn-save-event").style.display="block";
     
                    }
                    $("#info_absen").html(msg);
        
                }
        })
   
    //console.log(tgl_pilih);
    //tglKegiatan.value = tgl_pilih;

   


    document.getElementById("tgl_kegiatan").value = formattedDate; 

    //alert(tgl_pilih);
};

const getInitialView = () => {
    const windowWidth = window.innerWidth;
    if (windowWidth >= 768 && windowWidth < 1200) return 'timeGridWeek';
    else if (windowWidth <= 768) return 'listMonth';
    else return 'dayGridMonth';
};

const getBusinessHours = () => (businessHoursCheckbox.checked ? { daysOfWeek: [1, 2, 3, 4, 5], startTime: '10:00', endTime: '18:00' } : []);

const weekNumber = () => weekNumberCalendar.checked;

// Event Listeners
businessHoursCheckbox.addEventListener('change', () => calendar.setOption('businessHours', getBusinessHours()));
weekNumberCalendar.addEventListener('change', () => calendar.setOption('weekNumbers', weekNumber()));

// Main Calendar Initialization
const calendar = new FullCalendar.Calendar(calendarEl, {
    timeZone: 'local',
    editable: true,
    droppable: true,
    selectable: true,
    // longPressDelay: true,
    weekNumbers: weekNumber(),
    initialView: getInitialView(),
    themeSystem: 'tailwindcss',
    headerToolbar: { left: 'prev,next,today', center: 'title', right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth' },
    drop: (info) => checkbox.checked && info.draggedEl.parentNode.removeChild(info.draggedEl),
    businessHours: getBusinessHours(),
    windowResize: (view) => calendar.changeView(getInitialView()),
    eventClick: (info) => {
        eventModal.classList.remove('hidden');
        document.getElementById("calendarBtn").click();
        formEvent.reset();
        aktifitasInput.value = '';
        tanggalInput.value=  '';
        var fullStartDate=  '';
        var fullEndDate =  '';

        selectedEvent = info.event;
        fullStartDate = selectedEvent.start;
        fullEndDate   = selectedEvent.end;

        const formattedDate = `${fullStartDate.getDate()}-${fullStartDate.getMonth() + 1}-${fullStartDate.getFullYear()}`;
        const startTime     = `${fullStartDate.getHours()}:${fullStartDate.getMinutes()}`;

        id_event = selectedEvent.id;
       // $("#id_aktifitas").val(selectedEvent.id);

        //alert(selectedEvent.id);

        $.ajax({
                        
                type:"POST",
                dataType:"html",
                url:"<?php echo base_url();?>kinerja/ajaxGetDataEdit",
                data:"tanggal="+formattedDate+"&jam="+startTime,
                success:function(editData){
                    //$("#ajaxlist_indikator").html(msg);

                    const obj = JSON.parse(editData);
                    jam_mulaiInput.value = obj[0].jam_mulai;
                    jam_selesaiInput.value = obj[0].jam_selesai;
                    waktu_efektifInput.value = obj[0].waktu_efektif;
                    volumeInput.value = obj[0].volume;
                    keteranganInput.value = obj[0].ket;

                    var status = obj[0].status;

                    if(status==0){
                        document.getElementById("jam_mulai").disabled = false;
                        document.getElementById("jam_selesai").disabled = false;
                        document.getElementById("aktifitas").disabled = false;
                        document.getElementById("volume").disabled = false;
                        document.getElementById("btn-save-event").style.display="block";
                        document.getElementById("btn-delete-event").style.display="block";
              
                    }else{
                        document.getElementById("jam_mulai").disabled = true;
                        document.getElementById("jam_selesai").disabled = true;
                        document.getElementById("aktifitas").disabled = true;
                        document.getElementById("volume").disabled = true;
                        document.getElementById("btn-save-event").style.display="none";
                        document.getElementById("btn-delete-event").style.display="none";
                    }
                   
                    
                   // console.log(status);
                }
                
            });

       

        aktifitasInput.value = selectedEvent.title;
        tanggalInput.value= formattedDate;
        jam_mulaiInput.value= startTime;
        //eventCategoryInput.value = selectedEvent.classNames[0];
        deleteEventBtn.classList.remove('hidden');

        newEventData = null;
        saveEventBtn.innerText = 'Simpan Perubahan';
    },
    dateClick: (info) => {
        addNewEvent(info);
        eventModal.classList.remove('hidden');
        document.getElementById("calendarBtn").click();
       // deleteEventBtn.classList.add('hidden');
       document.getElementById("btn-delete-event").style.display="none";
        saveEventBtn.innerText = 'Simpan';

        //alert("Test");
    },
    events: getDefaultEvents(),
});

// Localization
const changeLocale = () => calendar.setOption('locale', localeSelect.value);

// Form to add new event
formEvent.addEventListener('submit', (ev) => {
    ev.preventDefault();
    const updatedTitle = aktifitasInput.value;
    const tgl = tanggalInput.value;
    const jam_mulai = jam_mulaiInput.value;
    const jam_selesai = jam_selesaiInput.value;
    const waktu_efektif = waktu_efektifInput.value;
    const volume = volumeInput.value;
    const keterangan = keteranganInput.value;

    const updatedCategory = 'fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event text-yellow-500 w-[100%] bg-yellow-100 dark:!bg-yellow-500/20 border-none rounded-md py-1.5 px-3';
    const forms = document.getElementsByClassName('needs-validation');
    if (forms[0].checkValidity() === false) {
        forms[0].classList.add('was-validated');
    } else {
        if (selectedEvent) {
            selectedEvent.setProp('title', updatedTitle);
            selectedEvent.setProp('classNames', [updatedCategory]);

           // alert(id_event);
            
                $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>kinerja/update_aktifitas_v2',
                        data: "id="+id_event+"&tanggal="+tgl+"&waktu_efektif=" + waktu_efektif + "&jam_mulai=" + jam_mulai + "&jam_selesai=" + jam_selesai + "&volume=" + volume + "&aktifitas=" + updatedTitle+ "&keterangan=" + keterangan,
                        success: function(msg) {
                            Toastify({
                                    text: msg,
                                    duration: 3000,
                                    newWindow: true,
                                    close: true,
                                    gravity: "top", // `top` or `bottom`
                                    position: "right", // `left`, `center` or `right`
                                    stopOnFocus: true, // Prevents dismissing of toast on hover
                                    style: {
                                        background: "#5fb47f",
                                    },
                                onClick: function(){} // Callback after click
                                }).showToast();

              
                        }
                  }) //close ajax

          
        } else {
             
            // console.log(tgl);
            // console.log(jam_mulai);
            // console.log(jam_selesai);
            // console.log(volume);
            const newEvent = {
                title: updatedTitle,
                start: newEventData.date,
                allDay: newEventData.allDay,
                className: updatedCategory,

                
            };
            
            calendar.addEvent(newEvent);
                var periode = '2024-11';
                  $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>kinerja/insert_aktifitas_v2',
                        data: "tanggal="+tgl+"&waktu_efektif=" + waktu_efektif + "&jam_mulai=" + jam_mulai + "&jam_selesai=" + jam_selesai + "&volume=" + volume + "&aktifitas=" + updatedTitle+ "&keterangan=" + keterangan,
                        success: function(msg) {
                            

                                $.ajax({
                        
                                    type:"POST",
                                    dataType:"html",
                                    url:"<?php echo base_url();?>kinerja/refreshInputanKinerja",
                                    data:"periode="+periode,
                                    success:function(info_capaian){
                                        $("#rekap_inputan").html(info_capaian);
                    
                                        Toastify({
                                            text: msg,
                                            duration: 3000,
                                            newWindow: true,
                                            close: true,
                                            gravity: "top", // `top` or `bottom`
                                            position: "right", // `left`, `center` or `right`
                                            stopOnFocus: true, // Prevents dismissing of toast on hover
                                            style: {
                                                background: "#5fb47f",
                                            },
                                        onClick: function(){} // Callback after click
                                        }).showToast();
                                    
                                
                                    }
                                    
                                });
                    

                              
              
                        }
                  }) //close ajax
              

        }
        eventModalCloseBtn.click();
    }
});



deleteEventBtn.addEventListener('click', () => {
  
    if (selectedEvent) {
        selectedEvent.remove();
        selectedEvent = null;
        eventModalCloseBtn.click();

        $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo base_url();?>kinerja/ajaxDeleteAktifitas",
                data: "id=" + id_event,
                success: function(msg) {
                  
                    Toastify({
                        text: msg,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "#5fb47f",
                        },
                        onClick: function(){} // Callback after click
                        }).showToast();


                }
            });
        //alert(id_event);
       
    }
});

// Calendar Rendering
calendar.render();

// Additional Initialization
initializeDraggable();

    $('.jam_mulai').clockTimePicker({
        precision: 5
        });

    $('.durationNegativeMinMax').clockTimePicker({
        duration: true,
        precision: 5
        });
        


    $("#jam_mulai").change(function() {
            var jam_mulai = $(this).val();

            $("#jam_selesai").val(jam_mulai);
            $('.durationNegativeMinMax').clockTimePicker({
                duration: true,
                minimum: jam_mulai,
                maximum: '23:59',
                precision: 5
            });

          $("#jam_selesai").focus();
    });


    $("#jam_selesai").change(function() {
            waktu_efektif = $("#waktu_efektif").val();
            var jam_mulai = $("#jam_mulai").val();
            var jam_selesai = $(this).val();
            $(".loader").show();
            $.ajax({
                type: "POST",
                dataType: "html",
                url: "<?php echo base_url();?>kinerja/hitung_volume",
                data: "waktu_efektif=" + waktu_efektif + "&jam_mulai=" + jam_mulai + "&jam_selesai=" + jam_selesai,
                success: function(msg) {
                $("#volume").val(msg);
                $(".loader").fadeOut();
                }
            });
    });

     


  //klik di inputan untuk mencari kegiatan yang biasa di input oleh pegawai tersebut
  $("#aktifitas").click(function(){

    var keyword = $(this).val();
    $("#ajaxlist_aktifitas").show();
        $.ajax({
            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>kinerja/ajaxGetFrequentAktifitas",
            data:"keyword="+keyword,
            success:function(msg){
                $("#ajaxlist_aktifitas").html(msg);
            }
            
        });
    });

    $("#aktifitas").keyup(function(){
            var keyword = $(this).val();
            $("#ajaxlist_aktifitas").show();
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>kinerja/ajaxSearchAktifitas",
                    data:"keyword="+keyword,
                    success:function(msg){
                        $("#ajaxlist_aktifitas").html(msg);
                    }
                    
                });


        });
        
        
           $("#keterangan").keyup(function(){
            $("#list_keterangan").hide();
           });
        

           $("#keterangan").click(function(){
            var keyword = $(this).val();
            $("#list_keterangan").show();
                $.ajax({
                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>kinerja/ajaxGetKeteranganAktifitas",
                    data:"keyword="+keyword,
                    success:function(msg){
                        $("#list_keterangan").html(msg);
                    }
                    
                });
           });
        

    
</script>

</html>