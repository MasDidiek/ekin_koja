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
    .table{
      width: 100%;
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
   
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">



        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16"> Cuti </h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Cuti</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                     Detail Cuti
                    </li>
                </ul>
            </div>

            <?php
            
                             $id_pegawai = $this->session->userdata('id_pegawai'); 
                           
                                $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
                                $id_pj       = $detail_pegawai[0]->id_validator;
                                $nama        = $detail_pegawai[0]->nama;
                                $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
                                $jabatan     = $detail_pegawai[0]->jabatan;
                                $puskesmas   = $detail_pegawai[0]->puskesmas;
                                $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
                  

                            $message = $this->session->flashdata('message'); 
                           

            ?>

         


              <div class="grid grid-cols-1 gap-x-5 md:grid-cols-4 xl:grid-cols-2">

                    <div class="border card border-custom-200 dark:border-custom-800">
                        <div class="card-body">
                            <h6 class="mb-4 text-15">
                               Detail Pengajuan Sakit dengan surat keterangan
                            </h6>

                          
                                    <div class="flex flex-col h-full card-body">
                                        <h6 class="mb-4 text-15">
                                        <strong class="text-dark"><?php echo $detail_pegawai[0]->nama;?></strong> <br>
                                        <?php echo $detail_pegawai[0]->nip;?>
                                        </h6>
                                        <p class="text-slate-500 dark:text-zink-200">
                                                <?php echo $detail_pegawai[0]->jabatan;?> @ <?php echo $detail_pegawai[0]->puskesmas;?>
                                        </p>

                                        <br>  <br>
                                        <div class="mt-4">
                                             Tanggal  : <?php echo format_full($detail[0]->tanggal);?>
                                             <br>   <br>

                                           

                                        </div>
                                        
                                    </div>

                        </div>

                         <hr>
                    


                    </div><!--end card-->

                    
                    <div class="border border-green-200 card dark:border-green-800">
                        <div class="card-body">

                           <h4> Image Surat Keterangan</h4>  <br>
                          <img src="<?php echo base_url();?>uploads/surat_izin/<?php echo $detail[0]->file_image;?>" alt="">
                            
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


var msg = '<?php echo $info;?>';
if(msg != ''){
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




</script>

</html>