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

     ?>
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">Data Pegawai</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Pegawai</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                       Data Pegawai
                    </li>
                </ul>
            </div>

            <input type="hidden" id="info" value="<?php echo $info;?>">


              <div class="card" id="customerList">
                    <div class="card-body">
                        <div class="grid grid-cols-1 gap-5 mb-5 xl:grid-cols-2">
                            <div>
                                <div class="relative xl:w-3/6">
                                    <input type="text" class="ltr:pl-8 rtl:pr-8 search form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" placeholder="Search for ..." autocomplete="off">
                                    <i data-lucide="search" class="inline-block size-4 absolute ltr:left-2.5 rtl:right-2.5 top-2.5 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-600"></i>
                                </div>
                                
                            </div>
                        
                                
                            
                            <div class="ltr:md:text-end rtl:md:text-start"> 
                                <a href="<?php echo base_url();?>admin/pegawai/add_pegawai"  class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20 add-btn" id="create-btn"><i class="align-bottom ri-add-line me-1"></i> Add Pegawai</a>
                                <button type="button" class="text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20" onclick="deleteMultiple()"><i class="ri-delete-bin-2-line"></i></button>
                            </div>
                        </div>

                        
                        <div class="info_delete mb-4"></div>
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap" id="customerTable">
                                <thead class="bg-slate-100 dark:bg-zink-600">
                                    <tr>
										
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500" scope="col" style="width: 50px;">
                                            <input class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox" id="checkAll" value="option">
                                        </th>
										<th>No</th>
                                        <th data-sort="tmt">TMT</th>
                                   
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="nip">NIP</th>

                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="nama_pegawai">Nama Pegawai</th>
             
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="jabatan">Jabatan</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="puskesmas">Puskesmas</th>
                                        <th class="sort px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 ltr:text-left rtl:text-right" data-sort="usergroup">Jam Kerja</th>
                                       
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    

									<?php

										 $no = 1;
										 
//print_array($pegawai);

                                            foreach ($pegawai as $list ) {

                                                    $id_pegawai = $list->id_pegawai;
                                                    $nip = $list->nip;
                                                    $nama = $list->nama;
                                                    $tmt  = $list->tmt;
                                                    $usergroup = $list->usergroup;
                                                    $email = '';
                                                    $puskesmas = $list->puskesmas;
                                                    $jabatan = $list->jabatan;
                                                    $jns_jam_kerja= $list->jns_jam_kerja;
                                                    
                                                    
                                                    $photo = $this->Pegawai_model->getPhotoPegawai($nip);
                                                    
                                                    $tmt = $list->tmt;

                                                   
                                                    $jns_pegawai = $list->jns_pegawai;
                                                    

                                                    if($jns_jam_kerja=='non_shift'){
                                                        $class_span = 'border bg-custom-100 border-custom-200 text-custom-500 dark:bg-custom-500/20 dark:border-custom-500/20';
                                                        $shift = 'REGULAR';
                                                    }else{
                                                        $class_span = 'border bg-yellow-100 border-yellow-200 text-yellow-500 dark:bg-yellow-500/20 dark:border-yellow-500/20';
                                                         $shift = 'SHIFT';
                                                    }

                                                    echo ' <tr> 
                                                                <th class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500" scope="row">
                                                                    <input class="border rounded-sm appearance-none cursor-pointer size-4 bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500 dark:checked:bg-custom-500 dark:checked:border-custom-500 checked:disabled:bg-custom-400 checked:disabled:border-custom-400" type="checkbox" name="chk_child">
                                                                </th>
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 id" style="display:none;">
                                                                <a href="javascript:void(0);" class="fw-medium link-primary id">'.$id_pegawai.'</a></td>	
                                                               
                                                                <td class="text-center px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$no.'</td>
                                                                   <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 tmt">'.date('d M, Y', strtotime($tmt)).'</td>
                                                              
                                                            
                                                                 <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 nrk" style="display:none;">'.$list->nrk.'</td>
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 nip">
                                                                <a href="#!" class="transition-all duration-150 ease-linear text-custom-500 hover:text-custom-600">
                                                                <a href="'.base_url().'admin/pegawai/detail_pegawai/'.$id_pegawai.'">'.$nip.'</a></td>
                                                                <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 nama_pegawai">
                                                                    <a href="'.base_url().'admin/pegawai/detail_pegawai/'.$id_pegawai.'" class="flex items-center gap-3">
                                                                        <div class="w-6 h-6 rounded-full shrink-0 bg-slate-100">
                                                                            <img src="'.base_url().'uploads/photo_profile/'.$photo.'" alt="" class="h-6 rounded-full">
                                                                        </div>
                                                                        <h6 class="grow">'.$nama.'</h6>
                                                                    </a>
                                                                </td>
                                                         
                                                               
                                                                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 email"  style="display:none;">'.$email.'</td>
                                                                <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 jabatan" style="display:none;"><span>'.$list->id_jabatan.'</span></td>
                                                                <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 puskesmas" style="display:none;"><span>'.$list->id_puskesmas.'</span></td>
                                                                <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$jabatan.'</td>
                                                                <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">'.$puskesmas.'</td>
                                                                <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 usergroup"> <span class="px-2.5 py-0.5 text-xs inline-block font-medium rounded border '.$class_span.' ">'.$shift.'</span></td>
                                                               
                                                            </tr>';

                                            

                                            $no+=1;
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
<script src="<?php echo base_url();?>assets/premium/js/pages/listjs.init.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</body>

<script>


   

function deleteMultiple() {
    var ids_array = [];
    var items = document.getElementsByName('chk_child');
    Array.from(items).forEach(function (ele) {
        if (ele.checked == true) {
            var trNode = ele.parentNode.parentNode;
            var id = trNode.querySelector('.id a').innerHTML;
            ids_array.push(id);
        }
    });
    
    if (ids_array.length > 0) {
        if (confirm('Are you sure you want to delete this?')) {
            ids_array.forEach(function (id) {
                // Assuming customerList.remove is a valid method to remove a single record
                customerList.remove("id", `<a href="javascript:void(0);" class="fw-medium link-primary id">${id}</a>`);

                deleteUser(id);
            });
            document.getElementById('checkAll').checked = false;
        } else {
            return false;
        }
    } else {
        Swal.fire({
            title: 'Please select at least one checkbox',
            customClass: {
                confirmButton: 'text-white btn bg-sky-500 border-sky-500 hover:text-white hover:bg-sky-600 hover:border-sky-600 focus:text-white focus:bg-sky-600 focus:border-sky-600 focus:ring focus:ring-sky-100 active:text-white active:bg-sky-600 active:border-sky-600 active:ring active:ring-sky-100 dark:ring-sky-400/20',
            },
            buttonsStyling: false,
            showCloseButton: true
        });
    }
}

function deleteUser(id_pegawai){
        $.ajax({
                type: 'POST',
                url: '<?php echo base_url();?>admin/pegawai/delete_pegawai',
                data: "id_pegawai="+id_pegawai,
                success: function(msg) {
                    //window.location.reload();
                    $(".info_delete").html(msg);
                }
            })
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
   

   
    // $('#delete-form').submit(function() {
           
    //         $.ajax({
    //             type: 'POST',
    //             url: $(this).attr('action'),
    //             data: $(this).serialize(),
    //             success: function(msg) {
    //                 //window.location.reload();
    //                 $("#confirm_delete").html(msg);
    //             }
    //         })
    //     return false;
    // });

});

  


</script>

</html>