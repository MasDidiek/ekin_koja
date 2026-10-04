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
                            $sisaTahunLalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 1, 'DESC');
                            $sisaTahunIni = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
                            $sisaCuber = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 3, 'DESC');

                            $sisaCutiAll = $sisaTahunLalu+$sisaTahunIni+$sisaCuber;
                            $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');
                            $arraySisaCuti = array($sisaTahunLalu, $sisaTahunIni, $sisaCuber );


                                $id   =  $detail_cuti[0]->id;
                                $tgl_dari   =  $detail_cuti[0]->tgl_dari;
                                $tgl_sampai =  $detail_cuti[0]->tgl_sampai;
                                $hari_cuti  =  $detail_cuti[0]->hari_cuti;
                                $status  =  $detail_cuti[0]->status;
                                $id_cuti  =  $detail_cuti[0]->id;
                                $id_pegawai_pengaju =  $detail_cuti[0]->id_pegawai;

                                $tgl_pengajuan  =  $detail_cuti[0]->tgl;
                                $id_pengganti  =  $detail_cuti[0]->id_pengganti;
                                $delegasi_tugas  =  $detail_cuti[0]->delegasi_tugas;

                                $file_image =  $detail_cuti[0]->file_image;

                                $tgl_check2  =  $detail_cuti[0]->tgl_check2;

                                if($tgl_check2 != null){
                                  $approve_date = format_full($tgl_check2);
                                }else{
                                  $approve_date = '';
                                }


                                $jns_cuti  =  $detail_cuti[0]->jns_cuti;
                                if($jns_cuti==1){
                                  $jenis_cuti = 'Tahunan';
                                }else if($jns_cuti==2){
                                  $jenis_cuti = 'Cuti Bersalin';
                                }else if($jns_cuti==3){
                                  $jenis_cuti = 'Cuti Alasan Penting';
                                }else if($jns_cuti==4){
                                  $jenis_cuti = 'Cuti Sakit';
                                }else if($jns_cuti==5){
                                  $jenis_cuti = 'Cuti Besar';
                                }else{
                                  $jenis_cuti = 'Cuti Bersalin Anak 3';
                                }


                                $status_cuti =  getStatusCuti($status);

                                $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai_pengaju);
                                $id_pj       = $detail_pegawai[0]->id_validator;
                                $nama        = $detail_pegawai[0]->nama;
                                $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
                                $jabatan     = $detail_pegawai[0]->jabatan;
                                $puskesmas   = $detail_pegawai[0]->puskesmas;
                                $jns_pegawai = $detail_pegawai[0]->jns_pegawai;



                                $detail_pegawai_pengganti = $this->Pegawai_model->getDetailPegawai($id_pengganti);
                                $jabatan_pengganti        = $detail_pegawai_pengganti[0]->jabatan;
                                $puskesmas_pengganti      = $detail_pegawai_pengganti[0]->puskesmas;
                                #print_array($detail_pegawai);
                                $delegasi = explode("+", $delegasi_tugas);

                                if($file_image !=''){
                                    $filePenunjang = explode(",", $file_image);
                                }else{
                                      $filePenunjang = array('');
                                }

                                $photoPengaju   = $this->Pegawai_model->getPhotoPegawai($detail_pegawai[0]->nip);
                                $photoPengganti = $this->Pegawai_model->getPhotoPegawai($detail_pegawai_pengganti[0]->nip);

                               // echo $photoPengaju;




                            $div_upload_file = 'd-none';

                            if($jns_cuti==1){
                                $jenis_cuti = 'Tahunan';
                            }else if($jns_cuti==2){
                                $jenis_cuti = 'Bersalin';
                                $div_upload_file = '';
                            }else if($jns_cuti==3){
                                $jenis_cuti = 'Alasan Penting ';
                                $div_upload_file = '';
                            }else if($jns_cuti==4){
                                $jenis_cuti = 'Sakit';
                                $div_upload_file = '';
                            }else{
                                $jenis_cuti = 'Besar';
                            }


                            $message = $this->session->flashdata('message');


            ?>




              <div class="grid grid-cols-1 gap-x-5 md:grid-cols-4 xl:grid-cols-2">

                    <div class="border card border-custom-200 dark:border-custom-800">
                        <div class="card-body">
                            <h6 class="mb-4 text-15">
                               Pengaju Cuti
                            </h6>

                            <div class="sm:flex">
                                <div>
                                  <img src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photoPengaju;?>"
                                    alt="<?php echo $detail_pegawai[0]->nama;?>" class="img-fluid" style="width: 160px; height:170px; border-radius: 10px;">
                                </div>
                                <div class="flex flex-wrap">
                                    <div class="flex flex-col h-full card-body">
                                        <h6 class="mb-4 text-15">
                                        <strong class="text-dark"><?php echo $detail_pegawai[0]->nama;?></strong> <br>
                                        <?php echo $detail_pegawai[0]->nip;?>
                                        </h6>
                                        <p class="text-slate-500 dark:text-zink-200">
                                        <?php echo $detail_pegawai[0]->jabatan;?> @ <?php echo $detail_pegawai[0]->puskesmas;?>
                                        </p>

                                    </div>
                                </div>
                            </div><!--end card-->
                        </div>

                         <hr>
                        <div class="card-body">
                            <h6 class="mb-4 text-15">
                               Pengganti Cuti
                            </h6>

                            <div class="sm:flex">
                                <div>
                                <img src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photoPengganti;?>"
                                alt="<?php echo $detail_pegawai[0]->nama;?>" class="img-fluid" style="width: 160px; height:170px; border-radius: 10px;">
                                </div>
                                <div class="flex flex-wrap">
                                    <div class="flex flex-col h-full card-body">
                                        <h6 class="mb-4 text-15">
                                        <strong class="text-dark"><?php echo $detail_pegawai_pengganti[0]->nama;?></strong> <br>
                                        <?php echo $detail_pegawai_pengganti[0]->nip;?>
                                        </h6>
                                        <p class="text-slate-500 dark:text-zink-200">
                                        <?php echo $detail_pegawai_pengganti[0]->jabatan;?> @ <?php echo $detail_pegawai_pengganti[0]->puskesmas;?>
                                        </p>

                                    </div>
                                </div>
                            </div><!--end card-->
                        </div>


                    </div><!--end card-->


                    <div class="border border-green-200 card dark:border-green-800">
                        <div class="card-body">
                            <h4 class="mb-4 text-15">
                               Detail Cuti
                            </h4>
                            <p class="mb-4 text-slate-500 dark:text-zink-200">


                              <table class="table">
                                <tr>
                                  <td>Tanggal Pengajuan</td>
                                  <td class="text-left"> : &nbsp; <strong> <?php echo format_full($tgl_pengajuan);?> </strong></td>
                                </tr>

                                <tr height="40">
                                  <td>Jenis  Cuti</td>
                                  <td class="text-left"> : &nbsp;  <strong>Cuti <?php echo $jenis_cuti ;?> </strong></td>
                                </tr>
                                <tr>
                                  <td>Tanggal Cuti</td>
                                  <td class="text-left"> : &nbsp;
                                    <strong>
                                      <?php
                                          if($detail_cuti[0]->hari_cuti==1){
                                            echo getNamahari($tgl_dari).', '.format_full($tgl_dari);
                                          }else{
                                            echo getNamahari($tgl_dari).', '.format_full($tgl_dari) .' s/d '. getNamahari($tgl_sampai).', '.format_full($tgl_sampai);;
                                          }
                                      ?>
                                     </strong>
                                    </td>
                                </tr>

                                <tr height="40">
                                  <td>Lama Cuti</td>
                                  <td class="text-left"> : &nbsp;  <strong><?php echo $detail_cuti[0]->hari_cuti ;?> hari</strong></td>
                                </tr>

                                <tr>
                                  <td>Alasan Cuti</td>
                                  <td class="text-left"> : &nbsp; <strong> <?php echo $detail_cuti[0]->alasan_cuti ;?> </strong></td>
                                </tr>

                                <tr height="40">
                                  <td>Alamat Selama Cuti</td>
                                  <td class="text-left"> : &nbsp;  <strong><?php echo $detail_cuti[0]->alamat_cuti ;?> </strong></td>
                                </tr>

                                <tr>
                                  <td>No Telp / HP</td>
                                  <td class="text-left"> : &nbsp; <strong> <?php echo $detail_cuti[0]->no_tlp ;?> </strong></td>
                                </tr>

                                <tr height="60">
                                  <td>Status Cuti</td>
                                  <td class="text-left"> : &nbsp; <?php echo $status_cuti;?></td>
                                </tr>

                                <?php
                                      if($status=='PEND0' && $id_pengganti==$id_pegawai){
                                        echo '<tr height="60">
                                                    <td></td>
                                                    <td class="text-left">
                                                      <button data-modal-target="extraSmallModal" type="button" class="text-white btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">Setujui Cuti</button>
                                                      <button data-modal-target="extraSmallModal" type="button" class="text-white btn bg-red-500 border-red-500 hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">Tolak Cuti</button>

                                                    </td>
                                                  </tr>  ';
                                      }
                                 ?>

                              </table>
                            </p>


                            <div id="extraSmallModal" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
                                <div class="w-screen md:w-[20rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
                                    <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                                        <h5 class="text-16">Pengajuan Cuti</h5>
                                        <button data-modal-close="extraSmallModal" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500"><i data-lucide="x" class="size-5"></i></button>
                                    </div>
                                    <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                                        <h5 class="mb-3 text-16">Persetujuan Pengganti Cuti</h5>
                                        <p class="text-slate-500 dark:text-zink-200">
                                          Apakah anda menyetujui sebagai pengganti cuti <strong><?php echo $detail_pegawai[0]->nama;?> ? </strong>  <Br>  <Br>


                                           <p>
                                            <center>
                                            <button data-modal-close="extraSmallModal" type="button" class="text-red-500 btn bg-red-100 border-red-100 hover:text-red-600 hover:bg-red-300 hover:border-red-300 focus:text-red focus:bg-red-300 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">Close</button>
                                            <a href="<?php echo base_url();?>cuti/setujui_cuti/<?php echo $id;?>" class="text-white btn bg-green-500 border-green-500 hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/20">Iya, Setujui</a>
                                            </center>
                                           </p>

                                        </p>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <hr>
                        <div class="card-body">
                          <h6 class="mb-4 text-15">
                               Delegasi Tugas
                            </h6>


                            <ol>
                                  <?php
                                  for ($i=0; $i < count($delegasi) ; $i++) {
                                      echo '<li>  -  &nbsp;  '.$delegasi[$i].'</li>
                                      ';
                                  }
                                ?>
                          </ol>
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


var msg = '<?php echo $message;?>';
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
