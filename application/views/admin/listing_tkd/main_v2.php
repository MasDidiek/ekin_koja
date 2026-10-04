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

        $tanggal_cuti = $this->session->userdata('tanggal_cuti');
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

                               <a href="<?php echo base_url();?>admin/listing_tkd/create_listing_tkd" class="bg-white border-dashed text-sky-500 btn border-sky-500 hover:text-sky-500 hover:bg-sky-50 hover:border-sky-600 focus:text-sky-600 focus:bg-sky-50 focus:border-sky-600 active:text-sky-600 active:bg-sky-50 active:border-sky-600 dark:bg-zink-700 dark:ring-sky-400/20 dark:hover:bg-sky-800/20 dark:focus:bg-sky-800/20 dark:active:bg-sky-800/20" target="_blank" ><i class="align-bottom ri-add-line me-1"></i> Create Listing</a>


                                <button type="button" data-modal-target="largeModal" class="bg-white border-dashed text-sky-500 btn border-sky-500 hover:text-sky-500 hover:bg-sky-50 hover:border-sky-600 focus:text-sky-600 focus:bg-sky-50 focus:border-sky-600 active:text-sky-600 active:bg-sky-50 active:border-sky-600 dark:bg-zink-700 dark:ring-sky-400/20 dark:hover:bg-sky-800/20 dark:focus:bg-sky-800/20 dark:active:bg-sky-800/20"><i class="align-baseline ltr:pr-1 rtl:pl-1 ri-download-2-line"></i> Import File</button>

                                <button type="button" id="update_tkd" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20" ><i class="align-bottom ri-add-line me-1"></i> Update Data</button>
                                <a href="<?php echo base_url();?>admin/listing_tkd/update_listing_tkd" class="text-white btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-custom-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20" ><i class="align-bottom ri-add-line me-1"></i> Update Listing</a>
                                

                            </div>

                        <div class="info_delete mb-4"></div>
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap" id="customerTable">
                                <thead class="bg-slate-100 dark:bg-zink-600">
                                    <tr>


                                    <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="no">No</th>


                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="nama_pegawai">Nama Pegawai</th>

                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="jabatan">Jabatan</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right">NPWP</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="tkd_pokok">TKD Pokok</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="capaian">Capaian</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="bruto">Bruto</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="pph21">Pajak</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="bpjs">BPJS</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="bpjs_tk">BPJS TK</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="thp">THP</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="norek">No Rekening</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="ket">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                <?php


                                        $no = 1;
                                        foreach ($listing_tkd as $peg){

                                        $nama = $peg->nama;
                                        $nip = $peg->nip;
                                        $jabatan = $peg->jabatan;

                                        $id_pegawai = $this->Pegawai_model->cekData($nip);


                                        $capaian = $peg->capaian;
                                        if($capaian < 50){
                                            $class_text = 'text-red-500 ';
                                        }else if($capaian > 50 && $capaian < 90){
                                            $class_text = 'text-yellow-500 ';
                                        }else if($capaian > 90 && $capaian < 98){
                                            $class_text = 'text-blue-500 ';
                                        }else{
                                            $class_text = 'text-green-500 ';
                                        }

                                            echo' <tr class=" fs-2">
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$no.'</td>
                                                    <td class="text-left px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 nama_pegawai">
                                                    <a href="'.base_url().'admin/pegawai/detail_pegawai/'.$id_pegawai.'">'.$peg->nama.'</a></td>

                                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 jabatan">'.$jabatan.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$peg->npwp.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 tkd_pokok">'.rupiah($peg->tkd_pokok).'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 '.$class_text.' capaian">
                                                     <strong>'.$peg->capaian.'</strong>  </td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 bruto">'.rupiah($peg->bruto).'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 pph21">'.rupiah($peg->pph21).'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 bpjs">'.rupiah($peg->bpjs).'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 bpjs_tk">'.rupiah($peg->bpjs_tk).'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 thp"> <h6 class="grow">'.rupiah($peg->thp).'</h6></td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$peg->no_rekening.'</td>
                                                    <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500"></td>

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

    <div id="largeModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
            <div class="w-screen md:w-[20rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                    <h5 class="text-16">Import Data BPJS</h5>
                    <button data-modal-close="largeModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                </div>
                <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto" id="modal-info">
                        <?php
                       // echo form_open_multipart(base_url() . 'admin/listing_tkd/import_file');
                        echo form_open_multipart(base_url() . 'admin/listing_tkd/import_gaji');

                        echo '
                            <strong>Jenis File</strong><br>

                             <input id="checkboxDefault1" value="bpjs" name="jns_file" class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox">
                             <label for="checkboxDefault1" class="align-middle"> BPJS </label> &nbsp;&nbsp;&nbsp;

                              <input id="checkboxDefault2" value="bpjs_tk" name="jns_file" class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox">
                             <label for="checkboxDefault2" class="align-middle"> BPJS TK </label>&nbsp;&nbsp;&nbsp;

                              <input id="checkboxDefault3" value="pph21" name="jns_file" class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox">
                             <label for="checkboxDefault4" class="align-middle"> PAJAK </label>&nbsp;&nbsp;&nbsp;

                             <input id="checkboxDefault3" value="gaji" name="jns_file" class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox">
                             <label for="checkboxDefault4" class="align-middle"> GAJI </label>&nbsp;&nbsp;&nbsp;

                             <br><br>
                            <strong> file (*.xls) : </strong>
                            <input name="file" type="file"><br>
                            <br>


                            <button type="submit" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/2o" id="clickme">
                            <i class="fa fa-external-link-square"></i> &nbsp; Import
                            </button>';

                        echo form_close();
                            ?>
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
