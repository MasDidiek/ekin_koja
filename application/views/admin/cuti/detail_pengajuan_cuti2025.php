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

                      
                        $id_pegawai           = $cuti->id_pegawai;
                        $id_pengganti         = $cuti->id_pengganti;
                        $id_cuti         = $cuti->id;
                        $jenis_cuti         = $cuti->jenis_cuti;
                        $alasan_cuti         = $cuti->alasan_cuti;
                        $created_at         = $cuti->created_at;
                        $status_approval         = $cuti->status_akhir;
                        //$id_pegawai_approval         = $cuti->id_pegawai_approval;
                       // $role_approval         = $cuti->role_approval;
                       // $id_pegawai_validator = $this->session->userdata("id_pegawai");
                          $message            = $this->session->flashdata('success');
                        


                        $tahun_list         = [2025, 2026];
                       // $rekap_hak_cuti         = $this->Cuti_model->get_rekap_cuti_pegawai_by_id($id_pegawai, $tahun_list);
                       // $approval         = $this->Cuti_model->getApprovalCuti($id_cuti);

                        $pengaju         = $this->Cuti_model->getInfoPenggantiCuti($id_pegawai);
                        $pengganti         = $this->Cuti_model->getInfoPenggantiCuti($id_pengganti);
                       // print_array($cuti );

                        

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
                                            <li class="breadcrumb-item active">Detail Pengajuan Cuti</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Detail Pengajuan Cuti </h4>
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
                                          <a href="<?php echo base_url();?>admin/cuti/pengajuan_cuti" class="btn btn-light">Kembali</a>
                                        <div class="card border-bawah-danger mt-2">
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

                                               

                                                        <table class="table table-sm table-borderless">
                                                            <tr>
                                                                <td width="250" class="fw-bold">Tanggal Pengajuan</td>
                                                                <td width="20">:</td>
                                                                <td><?php echo format_full($cuti->tgl_pengajuan);?></td>
                                                            </tr>

                                                            <tr>
                                                                <td class="fw-bold">Jenis Cuti</td>
                                                                <td>:</td>
                                                                <td><?php echo $cuti->jenis_cuti;?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Alasan Cuti</td>
                                                                <td>:</td>
                                                                <td><?php echo $cuti->alasan_cuti;?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Tanggal Mulai</td>
                                                                <td>:</td>
                                                                <td><?php echo format_full($cuti->tgl_mulai);?></td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Tanggal Selesai</td>
                                                                <td>:</td>
                                                                <td><?php echo format_full($cuti->tgl_selesai);?></td>
                                                            </tr>

                                                            
                                                              <tr>
                                                                <td class="fw-bold">Lama Cuti</td>
                                                                <td>:</td>
                                                                <td><?php echo $cuti->lama_cuti;?> hari</td>
                                                            </tr>

                                                            <tr>
                                                                <td class="fw-bold">Alamat Selama Cuti</td>
                                                                <td>:</td>
                                                                <td><?php echo $cuti->alamat_cuti;?></td>
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
                                                                <td>- <?php echo str_replace(",", "<br>- ",$cuti->delegasi_tugas);?></td>
                                                            </tr>

                                                              <tr>
                                                                <td class="fw-bold">Status</td>
                                                                <td>:</td>
                                                                <td> <?= $status_approval; ?>
                                                                    
                                                                </td>
                                                            </tr>


                                                          
                                                        </table>
                                                       

                                                          <?php
                                                            if($status_approval=='PEND2' ){
                                                            
                                                            
                                                        ?>
                                                            <center>
                                                                <a href="<?php echo base_url();?>admin/cuti/approve/<?= $id_cuti;  ?>" class="btn btn-success" onclick="return confirm('Apakah anda ingin menyetujui cuti ini?');">Setujui</a>
                                                                <a href="<?php echo base_url();?>cuti/tolak/<?= $id_cuti ?>" class="btn btn-danger"  onclick="return confirm('Apakah anda ingin menolak cuti ini?');">Tolak</a>

                                                            </center>
                                                        <?php } ?>

                                                        <hr>
                                                      
                                                </div>
                                            <!-- end card-body -->
                                        </div>
                                         
                                    </div> <!-- end col-->

                                     <div class="col-sm-4">
                                        <div class="card border-bawah-danger">
                                                <div class="card-body ">

                                                          <h4 class="header-title mb-2">Recent Activity</h4>

                                                            <div data-simplebar style="max-height: 419px;"> 
                                                                <div class="timeline-alt pb-0">

                                                                    <!-- Step 0 : Pengajuan -->
                                                                   

                                                                </div>
                                                             </div>


                                                                
                                                 
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




    </body>
</html>
