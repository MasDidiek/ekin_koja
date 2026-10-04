<!DOCTYPE html>
<html lang="en">
<head>
<?php $this->load->view('layout/header');?>
</head>
<body>
    
     <?php
                $id_pegawai = $data_pegawai[0]->id_pegawai;
                $nip = $data_pegawai[0]->nip;
                $pin = substr($nip, -4);
     
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
                $periode = date('F Y', strtotime($periode));
                
                
                

     
                if (!empty($dataRekap)) {

                  $id_rekap = $dataRekap[0]->id;
                  $status = $dataRekap[0]->status;
                  
                  $telat = $dataRekap[0]->telat;
                  $pulang_awal = $dataRekap[0]->pulang_awal;
                  $sakit = $dataRekap[0]->sakit;
                  $izin = $dataRekap[0]->izin;
                  $cuti = $dataRekap[0]->cuti;
                  $sakit_dgn_sk = $dataRekap[0]->sakit_dgn_sk;
       
                 if($status==0){
                    $status_absen = '<div class="flex gap-1 px-4 py-3 text-sm text-orange-500 border border-orange-200 rounded-md md:items-center bg-orange-50 dark:bg-orange-400/20 dark:border-orange-500/50">
                                       <i data-lucide="check" class="size-3"></i> <span class="font-bold">Warning!</span>  Data absensi belum sesuai
                                    </div> ';
                  }else{
                    $status_absen = '<div style="max-width:200px" class="flex items-center p-2 text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">
                    <i data-lucide="check-check" class="inline-block size-4"></i> <span class="align-middle"> Absen sudah sesuai</span></div>';
                  }

              
                }else{
                   $id_rekap =  0;
                  $telat = '-';
                  $pulang_awal = '-';
                  $sakit =  '-';
                  $izin =  '-';
                  $sakit_dgn_sk =  0;
                  $cuti = '-';
                  $status=0;
                   $status_absen = '<div class="flex gap-1 px-4 py-3 text-sm text-red-500 border border-red-200 rounded-md md:items-center bg-red-50 dark:bg-red-400/20 dark:border-red-500/50">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="alert-circle" class="lucide lucide-alert-circle h-4"><circle cx="12" cy="12" r="10"></circle><line x1="12" x2="12" y1="8" y2="12"></line><line x1="12" x2="12.01" y1="16" y2="16"></line></svg> <span class="font-bold">Alert! </span> Data absensi belum direkap.
                                    </div>';
                 
                }
                
                
             ?>
            
            
              <button type="button" data-modal-target="loading_update" value="<?php echo $pin.'/'.$id_pegawai;?>" type="button" class="text-white btn-rekap btn bg-orange-500 border-orange-500 hover:text-white hover:bg-orange-600 hover:border-orange-600 focus:text-white focus:bg-orange-600 focus:border-orange-600 focus:ring focus:ring-orange-100 active:text-white active:bg-orange-600 active:border-orange-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                    <i data-lucide="rotate-ccw" class="inline-block size-4"></i> <span class="align-middle">Update Rekap</span>
                </button>
                <a href="<?php echo base_url();?>admin/presensi/view_absensi/<?php echo $id_pegawai.'/'.$pin;?>" data-modal-target="addOrderModal" type="button" class="float-right text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                    <i data-lucide="calendar-range" class="inline-block size-4"></i> <span class="align-middle">Lihat Absensi</span>
                </a>
                
                
                <?php   if($status==0){
             
                         echo '<button type="button" data-modal-target="loading_update" value="'.$id_rekap.'" type="button" class="text-green btn-check-ok btn bg-green-200 border-green-200 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-success-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-orange-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">
                                <i data-lucide="check" class="inline-block size-4"></i> <span class="align-middle">Check Sesuai</span>
                            </button>';
                }
                  ?>
                 
                 
                 <br><br> 
            
            
            <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-12">
                    
                    <div class="xl:col-span-6">
                        <?php echo  $status_absen;?>
                            <div class="flex items-center gap-4 card-body">
                               
                                <div class="overflow-hidden grow">
                                     <strong><?php echo $data_pegawai[0]->nama;?></strong> 
                                     <br> <?php echo  $nip;?>
                                     
                                     <br> <br> <br>
                                     <p>
                                          Periode : <br>
                                         <strong> <?php echo $periode;?> </strong>
                                     </p>
                                     
                                   
                                </div>
                            </div>
                       
                    </div><!--end col-->
                    
                    
                    
                    <div class="xl:col-span-6">
                        <div class="card" id="list_info_data_rekap">
                            <div class="flex items-center gap-4 card-body">

                                <ul class="flex flex-col gap-5">
                                    <li class="flex items-center gap-3">
                                        <div class="flex items-center justify-center text-red-500 bg-red-100 rounded-md size-8 dark:bg-red-500/20 shrink-0">
                                            <i data-lucide="clock" class="size-4"></i>
                                        </div>
                                        <h6 class="grow">Telat</h6>
                                        <p class="text-slate-500 dark:text-zink-200"> <i data-lucide="arrow-right" class="inline-block size-4"></i> <span class="align-middle"> </p>
                                         <div class="w-12 text-red-500 ltr:text-right rtl:text-left">
                                          <?php echo $telat;?>
                                        </div>
                                       
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <div class="flex items-center justify-center rounded-md size-8 text-red-500 bg-red-100 dark:bg-red-500/20 shrink-0">
                                            <i data-lucide="log-out" class="size-4"></i>
                                        </div>
                                        <h6 class="grow">Pulang Awal</h6>
                                        <p class="text-slate-500 dark:text-zink-200"> <i data-lucide="arrow-right" class="inline-block size-4"></i> <span class="align-middle"> </p>
                                          <div class="w-12 text-red-500 ltr:text-right rtl:text-left">
                                          <?php echo $pulang_awal;?>
                                        </div>
                                       
                                       
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <div class="flex items-center justify-center text-orange-500 bg-orange-100 rounded-md size-8 dark:bg-orange-500/20 shrink-0">
                                            <i data-lucide="user-x-2" class="size-4"></i>
                                        </div>
                                        <h6 class="grow">Sakit</h6>
                                         <p class="text-slate-500 dark:text-zink-200"> <i data-lucide="arrow-right" class="inline-block size-4"></i> <span class="align-middle"> </p>
                                      
                                         <div class="w-12 text-orange-500 ltr:text-right rtl:text-left">
                                          <?php echo $sakit;?>
                                        </div>
                                       
                                    </li>
                                      <li class="flex items-center gap-3">
                                        <div class="flex items-center justify-center rounded-md size-8 text-orange-500 bg-orange-100 dark:bg-zink-600 dark:text-zink-200 shrink-0">
                                            <i data-lucide="file-input" class="size-4"></i>
                                        </div>
                                        <h6 class="grow">Sakit Dengan Surat</h6>
                                         <p class="text-orange-500 dark:text-orange-200"> <i data-lucide="arrow-right" class="inline-block size-4"></i> <span class="align-middle"> </p>
                                       
                                         <div class="w-12 text-orange-500 ltr:text-right rtl:text-left">
                                         <?php echo $sakit_dgn_sk;?>
                                        </div>
                                       
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <div class="flex items-center justify-center text-custom-500 bg-custom-100 rounded-md size-8 dark:bg-custom-500/20 shrink-0">
                                          
                                             <i data-lucide="info" class="inline-block size-4"></i> <span class="align-middle"> </p>
                                            
                                        </div>
                                        <h6 class="grow">Izin</h6>
                                         <p class="text-slate-500 dark:text-zink-200"> <i data-lucide="arrow-right" class="inline-block size-4"></i> <span class="align-middle"> </p>
                                        
                                         <div class="w-12 text-orange-500 ltr:text-right rtl:text-left">
                                          <?php echo $izin;?>
                                        </div>
                                       
                                    </li>
                                    <li class="flex items-center gap-3">
                                        <div class="flex items-center justify-center rounded-md size-8 text-green-500 bg-green-100 dark:bg-zink-600 dark:text-zink-200 shrink-0">
                                            <i data-lucide="calendar-off" class="size-4"></i>
                                        </div>
                                        <h6 class="grow">Cuti</h6>
                                         <p class="text-slate-500 dark:text-zink-200"> <i data-lucide="arrow-right" class="inline-block size-4"></i> <span class="align-middle"> </p>
                                       
                                         <div class="w-12 text-green-500 ltr:text-right rtl:text-left">
                                          <?php echo $cuti;?>
                                        </div>
                                       
                                    </li>
                                   
                                </ul>
                                
                            </div>
                        </div>
                    </div><!--end col-->
                    
                
                </div>

              

          
                <?php $this->load->view('layout/mainjs');?>
</body>


<script>



          $(".btn-rekap").click(function(){
              
               $("#list_info_data_rekap").html('<div class="inline-block border-2 rounded-full size-8 animate-spin border-l-transparent border-sky-500"></div>');
              
              
              var data_post = $(this).val();
              $.ajax({
    
                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>admin/presensi/ajax_rekap_absensi",
                        data:"data_post="+data_post,
                        success:function(msg){
                          $("#list_info_data_rekap").html(msg);
                          
                        //   setTimeout(function(){
                        //        window.location.reload();
                        //     }, 1000);
                        }
    
                  });

          });
          
          
          $(".btn-check-ok").click(function(){
              
              $("#list_info_data_rekap").html('<div class="inline-block border-2 rounded-full size-8 animate-spin border-l-transparent border-sky-500"></div>');
              
              var id_rekap = $(this).val();
              
              $.ajax({
    
                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>admin/presensi/check_ok2",
                        data:"id_rekap="+id_rekap,
                        success:function(msg){
                          $("#list_info_data_rekap").html(msg);
                          
                          setTimeout(function(){
                               window.location.reload();
                            }, 1000);
                        }
    
                  });

          });
          

       
   

</script>
</html>
               