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
        $id_user_validator   = $this->session->userdata('id_pegawai');

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

     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Listing TKD</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">TKD</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                    Listing TKD
                    </li>
                </ul>
            </div>

            <input type="hidden" id="info" value="<?php echo $info;?>">


              <div class="card" id="customerList">
                    <div class="card-body">
                    <div class="grid grid-cols-1 gap-5 mb-5 xl:grid-cols-12">
                           
                              <div class="xl:col-span-2">
                                    <input type="text" class="ltr:pl-8 rtl:pr-8 search form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Search for ..." autocomplete="off">
                                    <i data-lucide="search" class="inline-block size-4 absolute ltr:left-2.5 rtl:right-2.5 top-2.5 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-600"></i>
                                </div>
                                
                            
                                <div class="xl:col-span-2">
                                	
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
                        
                        </div>

                        <div class="w3-light-grey loading-bar" style="display: none;">
                            <div id="myBar" class="w3-round-xlarge w3-blue" style="height:15px;width:0"></div>
                        </div>
                        <br>

                      
                        
                        <div class="ltr:md:text-end rtl:md:text-start"> 
                                <button type="button" id="update_tkd" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20" ><i class="align-bottom ri-add-line me-1"></i> Update Data</button>
                               
                      </div>

                        <div class="info_delete mb-4"></div>
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap" id="customerTable">
                                <thead class="bg-slate-100 dark:bg-zink-600">
                                    <tr>
										
                                      
                                    <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="no">No</th>


                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="nama_pegawai">Nama Pegawai</th>
             
                                        <th class="sort text-center  px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" data-sort="telat">Telat</th>
                                        <th class="sort text-center  px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" data-sort="p_awal">P. Awal</th>
                                        <th class="sort text-center  px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" data-sort="izin">Izin</th>
                                        <th class="sort text-center  px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" data-sort="sakit">Sakit</th>
                                        <th class="sort text-center  px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" data-sort="sakit_dgn_surat">Sakit Dgn Surat</th>
                                        <th class="sort text-center  px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" data-sort="cuti">Cuti</th>
                                        <th class="sort text-center  px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" data-sort="status">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                <?php 

                                       
                                        $no = 1;
                                        foreach ($data_rekap as $rekap){

                                        $nama = $rekap->nama;
                                        $telat = $rekap->telat;
                                        $pulang_awal = $rekap->pulang_awal;
                                        $sakit = $rekap->sakit;
                                        $izin = $rekap->izin;
                                        $cuti = $rekap->cuti;
                                        $sakit_dgn_sk = $rekap->sakit_dgn_sk;
                                        $status = $rekap->status;

                                        if($status==0){
                                            $flag_status = '<span class="delivery_status px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-yellow-100 border-yellow-200 text-yellow-500 dark:bg-yellow-500/20 dark:border-yellow-500/20">Belum Sesuai</span>';
                                        }else{
                                             $flag_status = '<span class="delivery_status px-2.5 py-0.5 text-xs inline-block font-medium rounded border bg-green-100 border-green-200 text-green-500 dark:bg-green-500/20 dark:border-green-500/20">Sesuai</span>';
                                        }
                                        
                                     

                                            echo' <tr class=" fs-2">
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$no.'</td>
                                                    <td class="text-left px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 nama_pegawai">
                                                    <button type="button" class="detail-tkd" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg">
                                                     '.$nama.'
                                                    </button>
                                                    <td class=" text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 telat">'.$telat.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 pulang_awal">'.$pulang_awal.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 izin">'.$izin.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 sakit">'.$sakit.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 sakit_dgn_sk">'.$sakit_dgn_sk.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 cuti">'.$cuti.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 cuti">'.$flag_status.'</td>


                                                    </tr>';

                                                $no += 1;

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
                                    First
                                </a>
                                <ul class="flex gap-2 mb-0 pagination listjs-pagination"></ul>
                                <a class="inline-flex items-center justify-center bg-white dark:bg-zink-700 h-8 px-3 transition-all duration-150 ease-linear border rounded border-slate-200 dark:border-zink-500 text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-500 dark:[&.active]:text-custom-500 [&.active]:bg-custom-50 dark:[&.active]:bg-custom-500/10 [&.active]:border-custom-50 dark:[&.active]:border-custom-500/10 [&.active]:hover:text-custom-700 dark:[&.active]:hover:text-custom-700 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto page-item pagination-prev disabled pagination-next" href="#">
                                    Last
                                </a>
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

<div class="fixed items-center hidden bottom-6 right-12 h-header group-data-[navbar=hidden]:flex">
    <button data-drawer-target="customizerButton" type="button" class="inline-flex items-center justify-center w-12 h-12 p-0 transition-all duration-200 ease-linear rounded-md shadow-lg text-sky-50 bg-sky-500">
        <i data-lucide="settings" class="inline-block w-5 h-5"></i>
    </button>
</div>


<?php $this->load->view('layout/theme_config');?>
<?php $this->load->view('layout/mainjs');?>

<!-- listjs init -->
<script src="<?php echo base_url();?>assets/premium/js/pages/list_tkd.init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

<script>


function move() {
  var elem = document.getElementById("myBar");   
  var width = 1;
  var id = setInterval(frame, 120);
  function frame() {
    if (width >= 100) {
      clearInterval(id);
    } else {
      width++; 
      elem.style.width = width + '%'; 
    }
  }
}


$(document).ready(function() {
 
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
   

    $("#update_tkd").click(function(){
        var periode = '<?php echo $periode;?>';
        $(".loading-bar").show();
        move();
        $.ajax({

                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>admin/listing_tkd/update_rekap_tkd",
                    data:"periode="+periode,
                    success:function(msg){
                        window.location.reload();
                        //$("#modal-form").html(msg);
                        //console.log(msg);
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
    });

  


</script>

</html>