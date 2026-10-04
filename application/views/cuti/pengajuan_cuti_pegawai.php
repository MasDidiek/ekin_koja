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

    .legend{
        width: auto;
        height: auto;
        padding: 3px 10px;
        border-radius:5px ;
        font-size: 12px;
        
    }

    .pend1{
        background-color: #fcfad7;
        color: #bb9106;
       
        
    }
    
    .pend2{
        background-color: #fbead8;
        color: #f0973a;
       
        
    }
    .pend3{
        background-color: #f9e1f9;
        color: #a855f7;
       
        
    }
    .approve{
        background-color: #e1faef;
        color: #4bb687;
       
        
    }
    .cancel{
        background-color: #e5ebe9;
        color: #808584;
       
        
    }
    .reject{
        background-color: #ffefef;
        color: #ff5555;
       
        
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
           
<!--                            
                                 <strong class="mb-4 text-15">Waktu Efektif</strong>

                                 <span class="float-right">   Periode :  <strong> <?php echo  $nm_bulan.' '.$tahun;?> </strong> </span>  

                                 <div class="p-4 mt-3">
                                    <div class="grid grid-cols-6">
                                        <div class="px-4 text-center ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500 ltr:last:border-r-0 rtl:last:border-l-0">
                                            <h5 class="mb-1 font-bold"><span class="counter-value" data-target="<?php echo $menitEfektifBulanan ;?>">0</span> menit</h5>
                                            <p class="text-slate-500 dark:text-zink-200"> Jumlah minimal menit aktifitas yang harus diinput pada periode tersebut</p>
                                           
                                        </div>
                                     
                                   
                                    </div>
                                </div> -->


                                <!-- <div class="flex flex-col gap-5" id="rekap_inputan">
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
                                </div> -->


                                <hr> <br>

                               
                                <div id='external-events' class="flex flex-col gap-3 mb-4">

                                   <h6>Status Cuti By Warna</h6>
                                     <table>
                                        <tr>
                                           
                                            <td><div class="legend pend1">PENDING -  Menunggu ACC Pengganti</div></td>
                                        </tr>
                                        <tr height="50">
                                          
                                            <td><div class="legend pend2">PENDING -  Menunggu ACC Kapuskel / Kasatpel</div></td>
                                        </tr>
                                        <tr>
                                            
                                            <td><div class="legend pend3">PENDING -  Menunggu ACC Kasubbag TU</div></td>
                                        </tr>
                                        <tr height="50">
                                           
                                            <td><div class="legend approve">APPROVE -  Cuti disetujui</div></td>
                                        </tr>
                                        <tr>
                                           
                                            <td><div class="legend cancel">CANCEL -  Cuti dibatalkan</div></td>
                                        </tr>
                                        <tr height="50">
                                           
                                            <td><div class="legend reject">REJECT -  Cuti ditolak</div></td>
                                        </tr>
                                     </table>
                                       
                            
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
                        <div class="xl:col-span-12 mb-4">
                            <table style="width: 100%;">
                                <tr>
                                    <td width="100">Nama</td>
                                    <td>:</td>
                                    <td>  <input type="text" id="nama_pegawai" class="form-input border-0" required="" style="font-weight: bold;"></td>
                                </tr>
                                <tr>
                                    <td>Jenis Cuti</td>
                                    <td>:</td>
                                    <td> <input type="text" id="jenis_cuti" class="form-input border-0" required="" style="font-weight: bold;"></td>
                                </tr>
                                
                                <tr>
                                    <td>Alasan Cuti</td>
                                    <td>:</td>
                                    <td> <input type="text" id="keterangan" class="form-input border-0" required="" style="font-weight: bold;"></td>
                                </tr>
                                <tr height="50">
                                    <td>Tanggal Cuti</td>
                                    <td>:</td>
                                    <td>
                                        <input type="text" id="tgl_mulai" class="text-center border-0" required="" style="font-weight: bold; width:100px">
                                        s/d
                                        <input type="text" id="tgl_akhir" class="text-center border-0" required="" style="font-weight: bold; width:100px">
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lama Cuti</td>
                                    <td>:</td>
                                    <td> <input type="text" id="lama_cuti" class="text-center  border-0" required="" style="font-weight: bold; width:50px"> hari </td>
                                </tr>
                            </table>

                        </div>
   

                </div>

                <hr><br>
                <div class="flex justify-end gap-2 mt-4">
                         <button type="submit" id="btn-delete-event" value="" class="hidden text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/20">Tolak</button>
                         <button type="submit" id="btn-save-event" class="hidden text-white btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">Setujui</button>
                                 <div class="relative dropdown">
                                    <button type="button" class="text-white dropdown-toggle btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20" id="dropdownMenuButton" data-bs-toggle="dropdown">
                                        Opsi Lainnya <i data-lucide="chevron-down" class="inline-block size-4 ltr:ml-1 rtl:mr-1"></i></button>

                                    <ul class="absolute z-50 hidden py-2 mt-1 list-none bg-white rounded-md shadow-md ltr:text-left rtl:text-right dropdown-menu min-w-max dark:bg-zink-600" aria-labelledby="dropdownMenuButton">
                                      <li id="li_detail">
                                            
                                        </li>
                                        <li>
                                            <a id="btn-delete-event" class="block px-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200" href="#!">Tolak Cuti</a>
                                        </li>
                                        <li class="pt-2 mt-2 border-t border-slate-200 dark:border-zink-500">
                                            <a class="block px-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200" href="#!">Batalkan Cuti</a>
                                        </li>
                                    </ul>
                                </div>
                    <!-- <button type="reset" data-modal-close="event-modal" class="text-zink-500 bg-white btn hover:text-zink-500 hover:bg-zink-100 focus:text-zink-500 focus:bg-red-100 active:text-red-500 active:bg-red-100 dark:bg-zink-600 dark:hover:bg-zink-500/10 dark:focus:bg-zink-500/10 dark:active:bg-zink-500/10">Close</button>
                  -->
                    
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

   // print_array($cutiPegawai);


    $arrayAktifitas = array();
    $className = '';
    foreach ($cutiPegawai as $cuti ) {
        $tgl_dari    = $cuti->tgl_dari;
        $tgl_sampai    = $cuti->tgl_sampai;
        $status         = $cuti->status;
        $alasan_cuti         = $cuti->alasan_cuti;
        $nama_pegawai         = $cuti->nama;
        $jns_cuti    = $cuti->jns_cuti;
        $hari_cuti    = $cuti->hari_cuti;

        $end = addDaysToDate($tgl_sampai,1);
        
       if($status != 'CANCEL'){
           if($status=='PEND0'){
            $className = 'w-[100%] text-yellow-500 bg-yellow-100 dark:!bg-yellow-500/20 border-none rounded-md py-1.5 px-3';
           }else if($status=='PEND1'){
            $className = 'w-[100%] text-orange-500 bg-orange-100 dark:!bg-orange-500/20 border-none rounded-md py-1.5 px-3';
           }else if($status=='PEND2'){
            $className = 'w-[100%] text-purple-500 bg-purple-100 dark:!bg-purple-500/20 border-none rounded-md py-1.5 px-3';
           }else{
            $className = 'w-[100%] text-green-500 bg-green-100 dark:!bg-green-500/20 border-none rounded-md py-1.5 px-3';
           }

           if($jns_cuti==1){
            $jenis = 'Tahunan';
           }else if($jns_cuti==2){
            $jenis = 'Bersalin';
           }else if($jns_cuti==3){
            $jenis = 'Alasan Penting';
           }else{
            $jenis = 'Sakit';
           }
                

           $arrayAktifitas[] = array(
            'id'=> $cuti->id,
            'title' => $nama_pegawai.'--'.$alasan_cuti.'--'.$jenis.'--'.$hari_cuti.'--'.$status,
            'start' => $tgl_dari,
            'end' => $end,
            'className' =>$className

        );
       }
             

       
      
    }

    


    $kegiatanList = json_encode($arrayAktifitas);

 //echo $kegiatanList;
    
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

const namaPegawai = getElement('nama_pegawai');
const jenisCuti = getElement('jenis_cuti');
const tanggalMulai = getElement('tgl_mulai');
const tanggalAkhir = getElement('tgl_akhir');
const hari_cuti = getElement('lama_cuti');
const keteranganInput = getElement('keterangan');
const deleteEventBtn = getElement('btn-delete-event');
const saveEventBtn = getElement('btn-save-event');
const localeSelect = getElement('locale-select');
const eventModalCloseBtn = getElement('eventModal-close');

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
        namaPegawai.value = '';
        tanggalMulai.value=  '';
        tanggalAkhir.value=  '';
        jenisCuti.value=  '';
        hari_cuti.value=  '';


        var fullStartDate=  '';
        var fullEndDate =  '';

        selectedEvent = info.event;
        
        fullStartDate = selectedEvent.start;
        fullEndDate   = selectedEvent.end;




        const tgl_mulai_cuti = `${fullStartDate.getDate()}-${fullStartDate.getMonth() + 1}-${fullStartDate.getFullYear()}`;
        if(fullEndDate == null){
            var tgl_akhir_cuti = tgl_mulai_cuti;
        }else{
            var tgl_akhir_cuti = `${fullEndDate.getDate()-1}-${fullEndDate.getMonth() + 1}-${fullEndDate.getFullYear()}`;
        }
       
      

        id_event = selectedEvent.id;
  
        var eventTitle = selectedEvent.title;
        var explod = eventTitle.split("--");
        var nama = explod[0];
        var alasanCuti  = explod[1];
        var jenis  = explod[2];
        var jmlh_hari_cuti  = explod[3];
        var status  = explod[4];

        namaPegawai.value = nama;
        tanggalMulai.value= tgl_mulai_cuti;
        tanggalAkhir.value= tgl_akhir_cuti;
        keteranganInput.value = alasanCuti;
        jenisCuti.value = jenis;
        hari_cuti.value = jmlh_hari_cuti;
        //eventCategoryInput.value = selectedEvent.classNames[0];
      

        newEventData = null;

        if(status =='PEND1'){
            saveEventBtn.classList.remove('hidden');
            deleteEventBtn.classList.remove('hidden');
            saveEventBtn.innerText = 'Setujui';
        }


        $("#li_detail").html('<a class="block px-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200" href="<?php echo base_url();?>admin/pengajuan_cuti/detail_cuti/'+id_event+'">Lihat Detail</a>');
       

       
    },
    dateClick: (info) => {
        addNewEvent(info);
        eventModal.classList.remove('hidden');
        document.getElementById("calendarBtn").click();
       //deleteEventBtn.classList.add('hidden');
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
    const updatedTitle = 1;


    const updatedCategory = 'fc-event fc-h-event fc-daygrid-event fc-daygrid-block-event text-purple-500 w-[100%] bg-purple-100 dark:!bg-purple-500/20 border-none rounded-md py-1.5 px-3';
    const forms = document.getElementsByClassName('needs-validation');
    if (forms[0].checkValidity() === false) {
        forms[0].classList.add('was-validated');
    } else {
        if (selectedEvent) {
            // selectedEvent.setProp('title', updatedTitle);
             selectedEvent.setProp('classNames', [updatedCategory]);

           // alert(id_event);
            
                $.ajax({
                        type: 'POST',
                        url: '<?php echo base_url();?>admin/pengajuan_cuti/accCutiKapuskel',
                        data: "id_cuti="+id_event,
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
                url: "<?php echo base_url();?>cuti/tolak_cuti",
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

    
</script>

</html>