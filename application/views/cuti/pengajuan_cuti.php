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
                    <h5 class="text-16">Shift Kerja </h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Shift Kerja</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                     Jadwal Shift Kerja
                    </li>
                </ul>

                


            </div>

            <?php
            
                 $id_pegawai = $this->session->userdata('id_pegawai'); 
                    // $periode = date('Y-m');
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

                $listBulan = array_bulan();

                $lastDateMonth = date('t', strtotime($periode));
              

            ?>


                    <div class="grid grid-cols-1 gap-x-5 2xl:grid-cols-12">
                            <div class="2xl:col-span-12">
                            
                                <div class="card">
                                    <div class="card-body">
                                        <h6 class="mb-3 text-15">Shift Kerja</h6>
                                         
                                        <hr>  <br>

                                 <div class="grid grid-cols-1 gap-5 mb-5 xl:grid-cols-12">     
                                        <div class="xl:col-span-2 xl:col-start-1"> 
                                          Periode :  <strong><?php echo date('F Y', strtotime($periode));?></strong> 
                                        </div>
                                          <div class="xl:col-span-2 xl:col-start-10">
                                              
                                              <select  name="bulan" id="bulan"  data-choices="" >
                                                      <option value="">Bulan</option>
                                                      <?php
                                                          for ($b=0; $b < count($listBulan) ; $b++) { 
              
                                                              $no_bulan = $b+1;
              
                                                              if($bulan == $b){
                                                                  $selc = 'selected';
                                                              }else{
                                                                  $selc = '';
                                                              }
                                                              
              
                                                              echo '<option value="'.$b.'" '.$selc.'>'.$b.' - '.$listBulan[$b].'</option>';
                                                          }
                                                          ?>
                                                  </select>
                                          </div>
                                          <div class="xl:col-span-1 xl:col-start-12">
              
                                              <select  name="tahun" id="tahun"  data-choices="" >
                                                      <option value="">Tahun</option>
                                                        <?php
                                                            for ($b=2023; $b < 2030 ; $b++) { 
              
                                                              
              
                                                                if($periode_tahun == $b){
                                                                    $selc2 = 'selected';
                                                                }else{
                                                                    $selc2 = '';
                                                                }
              
                                                                echo '<option value="'.$b.'" '.$selc2.'> '.$b.'</option>';
                                                            }
                                                            ?>
                                                  </select>
                                        </div>
                                    </div>

                                    <div class="overflow-x-auto">

                                      
                                          <div id="largeModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                                                 
                                              <div class="w-screen md:w-[40rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                                                      <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                                          <h5 class="text-16">Tambah Pegawai</h5>
                                                          <button data-modal-close="largeModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                                                      </div>
                                                      <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto"  style="min-height:300px">

                                                        <h6>Cari Pegawai</h6>
                                                           <select  name="nama_pegawai" id="nama_pegawai"  data-choices="" >
                                                              <option value="0"> -- cari pegawai --</option>
                                                              <?php 
                                                            
                                                                for ($b=0; $b < count($all_pegawai) ; $b++) { 

                                                                  echo '<option value="'.$all_pegawai[$b]->id_pegawai.'">'.$all_pegawai[$b]->nama.'</option>';
                                                              }

                                                              ?>
                                                            
                                                            </select>

                                                            
                                                            <h6>List Pegawai</h6>
                                                           
                                                            <div id="textAreaPegawai">
                                                               <table class="w-full mt-4">
                                                                  <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                                                                    <tr>
                                                                      <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">No.</th>
                                                                      <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">NIP</th>
                                                                      <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Nama</th>
                                                                      <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Action</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody> 
                                                                     <?php 
                                                                      $no = 1;
                                                                      foreach ($cart_contents as $item) :

                                                                        
                                                                        echo '<tr id="tr_' . $item['rowid'] . '">
                                                                            <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">'.$no .'</td>
                                                                            <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500">' . $item['desc'] . ' </td>
                                                                            <td class="px-3.5 py-2.5 border-b border-slate-200 dark:border-zink-500"> ' . $item['name'] . ' </td>
                                                                            <td class="px-3.5 py-2.5  border-b border-slate-200 dark:border-zink-500">
                                                                            <button type="button" value="' . $item['rowid'].'" class="remove-cart">Remove</button> </td> 
                                                                          </tr>';
                                                                            $no += 1;
                                                                      endforeach;

                                                                      ?>


                                                                  </tbody>
                                                                </table>

                                                            </div>
                                                            
                                                            <div class=" p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
                                                                  <a href="<?php echo base_url();?>admin_jadwal_shift/simpan/<?php echo $this->uri->segment(3);?>" class="float-right text-white transition-all duration-200 ease-linear btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:focus:ring-green-400/20">Simpan</a>
                                                              </div>
                                                           

                                                      </div>
                                                     
                                                  </div>
                                              </div>
                                            
                                      

                                                      <table class="w-full whitespace-nowrap mt-4">
                                                      <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:bg-zink-600 dark:text-zink-200">
                                                              <tr>
                                                              <th  class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">#</th>
                                                                  <th  class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">Nama Pegawai</th>
                                                                  <?php
                                                                    for ($i=1; $i < ($lastDateMonth+1) ; $i++) {
                                                                      $date =  $periode.'-'.$i;

                                                                      $tanggal = format_db($date);
                                                                      $day = date('l', strtotime($tanggal));
                                                                        if ($day=='Sunday') {
                                                                          $hari = 'Mg';
                                                                        }else if($day=='Monday'){
                                                                        $hari = 'Sn';
                                                                        }else if($day=='Tuesday'){
                                                                        $hari = 'Sl';
                                                                        }else if($day=='Wednesday'){
                                                                        $hari = 'Rb';
                                                                        }else if($day=='Thursday'){
                                                                        $hari = 'Km';
                                                                        }else if($day=='Friday'){
                                                                        $hari = 'Jm';
                                                                        }else{
                                                                        $hari = 'Sb';
                                                                        }

                                                                      echo ' <th  class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">'.$i.' <br>
                                                                      <small>'.$hari.'</small></th>';
                                                                    }
                                                                  
                                                                  ?>

                                                              </tr>
                                                          </thead>
                                                          <tbody>



                                                            <?php

                                                                    for ($i=0; $i < count($list_pegawai); $i++) {
                                                                      $id_pegawai = $list_pegawai[$i]->id_pegawai;
                                                                    
                                                                      
                                                                 
                                                                      echo '

                                                                          <tr>
                                                                            <td class="px-1.5 text-center font-semibold border border-slate-200 dark:border-zink-500">
                                                                                <a href="'.base_url().'admin_jadwal_shift/delete_from_list/'.$id_pegawai.'/'.$this->uri->segment(3).'" class="fs4 text-green-500">
                                                                                     <i data-lucide="check" class="inline-block size-4"></i>
                                                                                    </a>
                                                                                     &nbsp; 
                                                                                <a href="'.base_url().'admin_jadwal_shift/update_absensi_pegawai/'.$id_pegawai.'" class="mr-3 text-red-500" onClick="return confirm(\'Hapus data pegawai dari list bagian ini?\')" >
                                                                                    <i data-lucide="x" class="inline-block size-4"></i>
                                                                                </a>
                                                                                     &nbsp; 
                                                                            </td>
                                                                            <td  class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500" >
                                                                           
                                                                            '.$list_pegawai[$i]->nama.' 
                                                                             
                                                                            </td>';
                                                                            $id_cuti = 0;
                                                                            for ($a=1; $a < ($lastDateMonth+1) ; $a++) {


                                                                                $tanggal  = $periode.'-'.$a;
                                                                                $matrikId = $id_pegawai.'_'.$tanggal;
                                                                                $tgl      = format_db($tanggal);

                                                                                $checkCuti = $this->Cuti_model->cekCutiPegawai($tgl, $id_pegawai);


                                                                                if(count($checkCuti) == 1){
                                                                                    $jns_cuti = $checkCuti[0]->jns_cuti;
                                                                                    $status_cuti = $checkCuti[0]->status;
                                                                                    $id_cuti = $checkCuti[0]->id;
                                                                                    
                                                                                    if($jns_cuti==1){
                                                                                        $check = 'CT';  
                                                                                    }else if($jns_cuti==2){
                                                                                        $check = 'CB';  
                                                                                    }else if($jns_cuti==3){
                                                                                        $check = 'CAP';  
                                                                                    }else{
                                                                                        $check = 'CS';  
                                                                                    }
                                                                                  
                                                                                    if($status_cuti=='PEND0'){
                                                                                        $class = 'text-yellow-500  bg-yellow-100 hover:text-white hover:bg-yellow-600 ';
                                                                                    }else if($status_cuti=='PEND1'){
                                                                                        $class = 'text-orange-500  bg-orange-100 hover:text-white hover:bg-orange-600 ';
                                                                                    }else if($status_cuti=='PEND2'){
                                                                                        $class = 'text-sky-500  bg-sky-100 hover:text-white hover:bg-sky-600 ';
                                                                                    }else if($status_cuti=='PEND3'){
                                                                                        $class = 'text-custom-500  bg-custom-100 hover:text-white hover:bg-custom-600 ';
                                                                                    }else if($status_cuti=='CANCEL'){
                                                                                        $check = '';  
                                                                                        $class = '';
                                                                                    }else{
                                                                                        $class = 'text-green-500  bg-green-100 hover:text-white hover:bg-green-600 ';
                                                                                    }


                                                                                    
                                                                                }else{
                                                                                    $check = '';
                                                                                    $class = '';
                                                                                }
                                                                                echo '<td class="px-1.5 text-center font-semibold border border-slate-100 dark:border-zink-500 '.$class.'" style="font-size:10px;">
                                                                                        <button type="button" style="font-size:10px; padding:3px 6px"  class="btn-info-cuti " value="'.$id_cuti.'" data-modal-target="infoAbsen">'.$check.'</button>
                                                                                       </td>';

                                                                            }

                                                                            

                                                                    }


                                                            ?>

                                                            
                                                          </tbody>
                                                      </table>

                                                   


                                         </div>
                                                
                                    </div>
                                </div>
                            </div><!--end col-->
                           
                        </div><!--end grid-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->

    
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
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>

        <script type="text/javascript">
 


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

                 
          $("#tahun").change(function(){
                var tahun = $(this).val();

                $.ajax({

                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/presensi/set_session_tahun",
                            data:"tahun="+tahun,
                            success:function(msg){
                             window.location.reload();
                              //$("#modal-form").html(msg);
                              //console.log(msg);
                            }

                      });

              });


        </script>

</html>