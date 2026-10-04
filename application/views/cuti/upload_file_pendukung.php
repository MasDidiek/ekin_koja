<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/css/snackbar.css" rel="stylesheet" type="text/css" />


<style>
  
     .image-preview {
            display: inline-block;
            margin: 10px;
            position: relative;
        }
        .image-preview img {
            width: 150px;
            height: auto;
            border: 1px solid #ccc;
        }


</style>


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
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

                      
                        $id_pegawai         = $cuti[0]->id_pegawai;
                        $id_pengganti         = $cuti[0]->id_pengganti;
                        $id_cuti         = $cuti[0]->id;
                        $jenis_cuti         = $cuti[0]->jenis_cuti;
                        $alasan_cuti         = $cuti[0]->alasan_cuti;
                        $status_akhir         = $cuti[0]->status_akhir;
                        $created_at         = $cuti[0]->created_at;
                        $id_pengajuan   = $cuti[0]->id;
                        


                        $tahun_list         = [2025, 2026];
                        $rekap_hak_cuti         = $this->acm->get_rekap_cuti_pegawai_by_id($id_pegawai, $tahun_list);
                        $approval         = $this->acm->getApprovalCuti($id_cuti);

                        $pengaju         = $this->acm->getInfoPenggantiCuti($id_pegawai);
                        $pengganti         = $this->acm->getInfoPenggantiCuti($id_pengganti);
                       // print_array($cuti );

                         $message            = $this->session->flashdata('success');
                        

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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Cuti</a></li>
                                            <li class="breadcrumb-item active">Summary Pengajuan Cuti</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Summary Pengajuan Cuti </h4>
                                     <?php 
                                    if($message !=''){
                                        echo '<div class="alert alert-success">'.$message.'</div>';
                                    }?>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                            <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card border-bawah-danger">
                                                <div class="card-body ">

                                                    <div class="d-flex align-items-center">
                                                        <div class="w-100 overflow-hidden">
                                                            <h5 class="mt-0"><?php echo $pengaju[0]->nama;?></h5>
                                                            <h5 class="m-0 fw-normal cta-box-title"><?php echo $pengaju[0]->jabatan;?>   -
                                                            <b><?php echo $pengaju[0]->puskesmas;?></b> </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- end card-body -->
                                        </div>
                                            <!-- end card-->
                                    </div> <!-- end col-->

                                      <div class="col-sm-8">
                                           <div class="card border-bawah-danger">
                                                <div class="card-body ">
                                                        <h5>Upload File Pendukung (Photo)</h5>
                                                        <div class="alert alert-info">
                                                            Untuk Pangajuan cuti dengan jenis cuti  
                                                            ( <strong>Cuti Bersalin, Cuti Alasan Penting (CAP), Cuti Sakit </strong> ) Wajib melampirkan bukti atau photo 
                                                            pendukung. seperti surat keterangan sakit, hasil Ronsen, Hasil USG dan lain-lain sesuai dengan jenis cuti yang diajukan.
                                                        </div>
                                                        
                                                            <input type="file" id="buktiUpload" multiple accept="image/*,.pdf" hidden>

                                                            <button type="button" class="btn btn-primary" onclick="$('#buktiUpload').click()">
                                                                + Tambah Bukti
                                                            </button>

                                                            <div class="row mt-3" id="previewArea"></div>


                                                            <a href="<?php echo base_url();?>cuti/summary_pengajuan_cuti/<?php echo $id_pengajuan;?>" class="btn btn-success mt-4 btn-continue d-none float-end">Selesaikan Pengajuan Cuti</a>
                                                </div>


                                              
                                            <!-- end card-body -->
                                        </div>
                                         
                                    </div> <!-- end col-->

                                     <div class="col-sm-4">
                                        <div class="card border-bawah-danger">
                                                <div class="card-body ">

                                                          <h4 class="header-title mb-2">Informasi Pengajuan Cuti</h4>

                                                             <table class="table table-sm table-borderless">
                                                            <tr>
                                                                <td width="200" class="fw-bold">Tanggal Pengajuan</td>
                                                                <td width="20">:</td>
                                                                <td><?php echo format_full($cuti[0]->tgl_pengajuan);?></td>
                                                            </tr>

                                                            <tr>
                                                                <td class="fw-bold">Jenis Cuti</td>
                                                                <td>:</td>
                                                                <td><?php echo $cuti[0]->jenis_cuti;?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Alasan Cuti</td>
                                                                <td>:</td>
                                                                <td><?php echo $cuti[0]->alasan_cuti;?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Tanggal Mulai</td>
                                                                <td>:</td>
                                                                <td><?php echo format_full($cuti[0]->tgl_mulai);?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Tanggal Selesai</td>
                                                                <td>:</td>
                                                                <td><?php echo format_full($cuti[0]->tgl_selesai);?></td>
                                                            </tr>

                                                            
                                                              <tr>
                                                                <td class="fw-bold">Lama Cuti</td>
                                                                <td>:</td>
                                                                <td><?php echo $cuti[0]->lama_cuti;?> hari</td>
                                                            </tr>

                                                            <tr>
                                                                <td class="fw-bold">Alamat Selama Cuti</td>
                                                                <td>:</td>
                                                                <td><?php echo $cuti[0]->alamat_cuti;?></td>
                                                            </tr>
                                                          
                                                            <tr>
                                                                <td class="fw-bold">Pegawai Pengganti</td>
                                                                <td>:</td>
                                                                <td> <?= $pengganti[0]->nama; ?> - <?= $pengganti[0]->nip; ?>
                                                                    
                                                                </td>
                                                            </tr>

                                                              <tr>
                                                                <td class="fw-bold">Delegasi Tugas</td>
                                                                <td>:</td>
                                                                <td>- <?php echo str_replace(",", "<br>- ",$cuti[0]->delegasi_tugas);?></td>
                                                            </tr>


                                                          
                                                        </table>




                                                                
                                                 
                                                </div>
                                            <!-- end card-body -->
                                        </div>
                                         
                                    </div> <!-- end col-->

                                    
                                 
                            </div>



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



        <script>
              const ID_PENGAJUAN = <?= $id_pengajuan ?>;
                    const BASE_URL = "<?= base_url() ?>";
            
            $(document).ready(function() {
               
                  

                 $('#buktiUpload').on('change', function () {
                    let files = this.files;

                    for (let i = 0; i < files.length; i++) {
                        uploadFile(files[i]);
                    }

                    this.value = ''; // reset input
                });

                function uploadFile(file) {
                    let formData = new FormData();
                    formData.append('file', file);
                    formData.append('id_pengajuan', ID_PENGAJUAN);

                    $.ajax({
                        url: BASE_URL + 'cuti/ajax_upload',
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        beforeSend() {
                            $('#previewArea').append(`
                                <div class="col-md-3 loading">
                                    <div class="border p-2 text-center">Uploading...</div>
                                </div>
                            `);
                        },
                        success(res) {
                            $('.loading').last().replaceWith(res);
                            $(".btn-continue").removeClass('d-none');
                        }
                    });
                }


                    
                });
                

                 function hapusBukti(id) {
                    $.post(BASE_URL + 'cuti/delete_bukti', {id:id}, function(){
                            $('#bukti_'+id).remove();
                        });
                    }

            </script>

    </body>
</html>