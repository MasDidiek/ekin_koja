<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('layout/section/sidebar');?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view('layout/section/topbar');?>
                    <?php
                    //print_array($rekap_capaian_kinerja);

                          $id_pegawai = $pegawai[0]->id_pegawai;
                          $tgl_masuk = $pegawai[0]->tgl_masuk;
                          $nip = $pegawai[0]->nip;
                          $nama_pegawai = $pegawai[0]->nama;
                          $photo = $this->Pegawai_model->getPhotoPegawai($nip);

                          if($photo==''){
                            $photo = 'avatar.png';
                          }

                          $message = $this->session->flashdata('message_update');



                            $status_kawin  = $pegawai[0]->status_kawin;
                            $status_pajak  = $pegawai[0]->status_pajak;
                            $id_pendidikan = $pegawai[0]->id_pendidikan;

                            $pendidikan = $this->Master_model->getNamaPendidikan($id_pendidikan);

                            if($status_kawin==1){
                                $status_nikah = 'K3 (Menikah + 2 anak)';
                            }else if($status_kawin==2){
                                $status_nikah = 'K2 (Menikah + 1 anak)';
                            }else if($status_kawin==3){
                                $status_nikah = 'K1 (Menikah + 0 anak)';
                            }else{
                                $status_nikah = 'K0 (Belum Menikah)';
                            }


                            $gaji_pokok = $pegawai[0]->gaji_pokok;
                            $pengkalian = $pegawai[0]->pengkalian;
                            $status_kerja= $pegawai[0]->status_kerja;


                             $checkAktif = '';
                             $checkCuti = '';
                             $checkNonAktif = '';

                            if($status_kerja==1){
                                $checkAktif = 'checked';
                            }

                            if($status_kerja==2){
                                $checkCuti = 'checked';
                            }

                            if($status_kerja==0){
                                $checkNonAktif = 'checked';
                            }


                            $tkd_pokok  = $gaji_pokok*$pengkalian;


                            $tmt = $pegawai[0]->tmt;
                            $today = date('Y-m-d');

                            $masa_kerja = hitungMasaKerja($tmt, $today);

                            $detailPegawai = $this->Pegawai_model->getDataDetailPegawai($nip);



                           // $sisaTahunLalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
                            $sisaTahun2024 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai,2, 'DESC'); //tahun 2024
                            $sisaTahun2025 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');  //tahun 2025

                            $sisaCutiAll = $sisaTahun2024+$sisaTahun2025;

                            
                            if(!empty($pegawai_gaji)){
                                $gaji_pokok = $pegawai_gaji[0]->gaji_pokok;
                                $pengkalian = $pegawai_gaji[0]->pengkalian;
                                $tkd_pokok = $gaji_pokok*$pengkalian;
                                $id_gaji   =  $pegawai_gaji[0]->id;
                            
                            }else{
                                $gaji_pokok= 0;
                                $pengkalian = 0;
                                $tkd_pokok =  0;
                                $id_gaji   = 0;
                            }

                            
                     ?>


                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Pegawai</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Detail Pegawai </h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                         <div class="row">
                             <div class="col-sm-12">
                                 <!-- Profile -->
                                 <div class="card">
                                     <div class="card-body profile-user-box">
                                         <div class="row">
                                             <div class="col-sm-8">
                                                 <div class="row align-items-center">
                                                     <div class="col-auto">
                                                         <div class="avatar-lg">
                                                             <img src="<?php echo base_url().'uploads/photo_profile/'. $photo ;?>" alt="" class="rounded-circle" width="80"  height="90">
                                                         </div>
                                                     </div>
                                                     <div class="col">
                                                         <div>
                                                             <h4 class="mt-1 mb-1 text-dark"><?php echo $nama_pegawai;?></h4>
                                                             <p class="font-13 text-dark-50"> <?php echo $pegawai[0]->jabatan;?></p>

                                                             <ul class="mb-0 list-inline text-dark">
                                                                 <li class="list-inline-item me-3">
                                                                     <h5 class="mb-1"><?php echo $pegawai[0]->puskesmas;?></h5>
                                                                     <h5 class="mb-1">Join Date : <?php echo format_semi($tgl_masuk);?></h5>
                                                                     <p class="mb-0 font-13 text-dark-50">(<?php echo $masa_kerja['years'].' Tahun '.$masa_kerja['months'].' bulan';?>)</p>

                                                                 </li>
                                                                
                                                             </ul>
                                                         </div>
                                                     </div>
                                                 </div>
                                             </div> <!-- end col-->

                                             <div class="col-sm-4">

                                                    <span class="fs-5" style="color:#50b6ef">
                                                        <i class="uil-user-square"></i>
                                                    </span>
                                                    <?php echo $detailPegawai[0]->nip;?>

                                                    <br>  <br>

                                                    <span class="fs-5" style="color:#50b6ef">
                                                        <i class="uil-envelope"></i>
                                                    </span>
                                                    <?php echo $detailPegawai[0]->email;?>

                                                    <br>  <br>
                                                    
                                                    <span class="fs-5" style="color:#50b6ef">
                                                        <i class="uil-phone"></i>
                                                    </span>
                                                    <?php echo $detailPegawai[0]->no_tlp;?>

                                                 <!-- <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                                     <a href="<?php echo base_url();?>admin/pegawai/edit_pegawai/<?php echo $id_pegawai.'/'.$nip;?>" class="btn btn-light">
                                                         <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                                                    </a>
                                                 
                                                 </div> -->
                                             </div> <!-- end col-->
                                         </div> <!-- end row -->

                                     </div> <!-- end card-body/ profile-user-box-->

                                    
                                 </div><!--end profile/ card -->
                             </div> <!-- end col-->
                         </div>
                         <!-- end row -->


                         <div class="row">

                                     
                          <div class="col-md-12 px-2 mb-2 ">
                                <a href="<?php echo base_url();?>profile/my_profile" class="btn-profile ">Data Diri</a>
                                <a href="" class="btn-profile">Data Keluarga</a>
                                <a href="<?php echo base_url();?>profile/riwayat_pendidikan" class="btn-profile">Pendidikan</a>
                                <a href="" class="btn-profile">Dokumen</a>
                                <a href="" class="btn-profile">Pelatihan</a>
                                <a href="<?php echo base_url();?>profile/uraian_tugas" class="btn-profile active-tab">Uraian Tugas</a>
                            </div>

                 
                             
                             <div class="col-xl-12 ">
                               
                                 <div class="card">
                                     <div class="card-body">
                                         <h4 class="header-title mb-3">Uraian Tugas</h4>
                                            

                                            <?php
                                              if(!empty($uraian_tugas)){

                                                    echo '<button 
                                                            type="button" 
                                                            class="btn btn-success float-end" 
                                                            data-bs-toggle="modal" 
                                                            data-bs-target="#editModal" 
                                                            value="'.$uraian_tugas[0]->id.'" >
                                                        
                                                            <i class="uil-edit"></i>  Edit
                                                        </button>
                                                        <a href="'.base_url().'profile/print_uraian_tugas" class="btn me-2  btn-light float-end">
                                                            <i class="uil-print"></i> Print</a>
                                                        <br>';



                                                $tugas_pokok = $uraian_tugas[0]->tugas_pokok;
                                                $tugas_integrasi = $uraian_tugas[0]->tugas_integrasi;
                                                $wewenang = $uraian_tugas[0]->wewenang;
                                                $tanggung_jawab = $uraian_tugas[0]->tanggung_jawab;
                                                


                                                // RegEx untuk memecah berdasarkan angka diikuti titik, misalnya 1., 2., dst
                                                preg_match_all('/\d+\..*?(?=\s\d+\.|$)/', $tugas_pokok, $matches);
                                                $list = $matches[0];


                                                preg_match_all('/\d+\..*?(?=\s\d+\.|$)/', $tugas_integrasi, $matches2);
                                                $list2 = $matches2[0];


                                                preg_match_all('/\d+\..*?(?=\s\d+\.|$)/', $wewenang, $matches3);
                                                $list3 = $matches3[0];

                                                echo '
                                                    <h4>Tugas Pokok</h4>
                                                    <ul>';
                                                       foreach ($list as $item): 
                                                            echo '<li>'.trim($item).'</li>';
                                                         endforeach; 
                                                    echo '</ul>
                                                    <h4>Tugas Integrasi</h4>
                                                     <ul>';
                                                       foreach ($list2 as $item): 
                                                            echo '<li>'.trim($item).'</li>';
                                                         endforeach; 
                                                    echo '</ul>
                                                     <h4>Wewenang</h4>
                                                    <ul>';
                                                       foreach ($list3 as $item): 
                                                            echo '<li>'.trim($item).'</li>';
                                                         endforeach; 
                                                    echo '</ul>
                                                    <h4>Tanggung Jawab</h4>
                                                     '.  $tanggung_jawab .'

                                                ';
                                              }else{


                                                echo ' <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formModal">
                                                           Input Uraian Tugas
                                                        </button>';
                                              }

                                            ?>

                                        <!-- Modal -->
                                        <div class="modal fade" id="formModal" tabindex="-1" aria-labelledby="formModalLabel" aria-hidden="true">
                                         <div class="modal-dialog "> <!-- modal-lg agar lebih lebar -->
                                            <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="formModalLabel">Form Tugas dan Wewenang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                            <form action="<?php echo base_url();?>profile/insert_uraian_tugas" method="post"> <!-- sesuaikan action -->
                                                <div class="modal-body">

                                                <div class="mb-3">
                                                    <label for="tugas_pokok" class="form-label">Tugas Pokok</label>
                                                    <textarea class="form-control" id="tugas_pokok" name="tugas_pokok" rows="5" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tugas_integrasi" class="form-label">Tugas Integrasi</label>
                                                    <textarea class="form-control" id="tugas_integrasi" name="tugas_integrasi" rows="3" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="wewenang" class="form-label">Wewenang</label>
                                                    <textarea class="form-control" id="wewenang" name="wewenang" rows="3" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tanggung_jawab" class="form-label">Tanggung Jawab</label>
                                                    <textarea class="form-control" id="tanggung_jawab" name="tanggung_jawab" rows="3" required></textarea>
                                                </div>

                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                </div>
                                            </form>
                                            </div>
                                        </div>
                                        </div>


                                     </div> <!-- end col-->
                                 </div> <!-- end row-->


                                 
                                 <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                         <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="formModalLabel">Form Edit Tugas dan Wewenang</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                            </div>
                                             <form action="<?php echo base_url();?>profile/update_uraian_tugas" method="post"> <!-- sesuaikan action -->
                                                <div class="modal-body">

                                                <div class="mb-3">
                                                    <label for="tugas_pokok" class="form-label">Tugas Pokok</label>
                                                    <textarea class="form-control" id="edit-tugas_pokok" name="tugas_pokok" rows="5" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tugas_integrasi" class="form-label">Tugas Integrasi</label>
                                                    <textarea class="form-control" id="edit-tugas_integrasi" name="tugas_integrasi" rows="3" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="wewenang" class="form-label">Wewenang</label>
                                                    <textarea class="form-control" id="edit-wewenang" name="wewenang" rows="3" required></textarea>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="tanggung_jawab" class="form-label">Tanggung Jawab</label>
                                                    <textarea class="form-control" id="edit-tanggung_jawab" name="tanggung_jawab" rows="3" required></textarea>
                                                </div>

                                                </div>
                                                <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                    </div>
                                    </div>
                                

                             </div>
                             <!-- end col -->


                                        
                            <?php
                                        if($message != ''){
                                            echo '    <div id="snackbar">'.$message.'</div>';
                                        }
                                    ?>

                         </div>
                         <!-- end row -->



                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>


        </div>
        <!-- END wrapper -->
        <?php $this->load->view('layout/section/theme-setting');?>


        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url();?>assets/new/js/ui/component.todo.js"></script>


        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->



        <script type="text/javascript">

                $(".btn-success").click(function(){
                    var id = $(this).val();

                      $.ajax({
                              type:"POST",
                              dataType: 'json',
                              url:"<?php echo base_url();?>profile/ajaxEditUraianTugas",
                              data:"id="+id,
                              success:function(response){
                                                    // isi textarea modal dengan hasil JSON

                                 let data = response[0];
                                $('#edit-tugas_pokok').val(data.tugas_pokok);
                                $('#edit-tugas_integrasi').val(data.tugas_integrasi);
                                $('#edit-wewenang').val(data.wewenang);
                                $('#edit-tanggung_jawab').val(data.tanggung_jawab);

                               // $('#editModal').modal('show');
                              }

                          });



                    });
     

                     
            var x = document.getElementById("snackbar");
            x.className = "show";
            setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
          
                    
                    
        </script>




    </body>
</html>
