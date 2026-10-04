<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .my-table{
            width: 100%;
        }
        .my-table  td{
            padding:2px;

        }
        .btn-list {
            padding:10px 15px;
            text-align:center;
            border-bottom:1px solid #EEE;
            color:#666;
            margin-right:2px;
        }

        .active-btn{
            border-bottom:1px solid #66bad9;
            color:orange;
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

                    <!-- Start Content-->
                    <div class="container-fluid">


                        <?php
                        $message = $this->session->flashdata('message');
                        $id_pegawai = $this->session->userdata('id_pegawai');
                        // $sisaTahun2024 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
                        // $sisaTahun2025 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');

                        // $sisaCutiAll = $sisaTahun2024+$sisaTahun2025;
                        $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');


                        $list_bulan = array_bulan();

                   
                        $nama_user =  $this->session->userdata('nama');
                        $nip_user =  $this->session->userdata('nip');
                        $id_pegawai =  $this->session->userdata('id_pegawai');
                        $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);


                        $pin 	= substr($nip_user, -4);

                        $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);

                        $jabatan =  $detail_pegawai->jabatan;
                        $puskesmas =  $detail_pegawai->puskesmas;


                          $tahun = $this->uri->segment(3) ?: date('Y');
                        if ($tahun == '') {
                         $tahun = date('Y');
                        }

                        $thn_cuti =  $tahun;
                        $arrayTahun = [2024, 2025, 2026];
                        if (isset($tahun) && $tahun != '') {
                          $tahunAktif = $tahun;
                        } else {
                         $tahunAktif = date('Y');
                        }

                        $cutiThn2025 = $rekap_hak_cuti['2025'];
                        $cutiThn2026 = $rekap_hak_cuti['2026'];

                        $sisa2025 = $cutiThn2025['sisa'];
                        $sisa2026 = $cutiThn2026['sisa'];

                        $thnini = date('Y');
                        $thnLalu = $thnini - 1;

                        $sisaCutiAll = $sisa2025 + $sisa2026;
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
                                            <li class="breadcrumb-item active">Cuti</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Cuti Saya</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php


                               ?>



                        <div class="row ">
                            <div class="col-xl-6 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <span class="float-start m-2 me-4">
                                            <img src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photo ;?>" style="height: 100px; Width:100px" alt="" class="rounded-circle img-thumbnail">
                                        </span>
                                        <div class="">
                                            <h4 class="mt-1 mb-1"><?php echo  $nama_user ;?></h4>
                                              <p class="font-13"> <?php echo $nip_user;?></p>

                                            <strong class="font-13"> <?php echo $puskesmas;?></strong>
                                              <p class="font-13"> <?php echo $jabatan;?></p>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                            <div class="col-xl-6 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                       <strong>Sisa Cuti</strong>
                                       <table class="table table-bordered table-sm">
                                       <tr class="text-center">
                                            <th>Tahun <?= $thnLalu ?></th>
                                            <th>Tahun <?= $thnini ?></th>
                                            <th class="bg-success-lighten">Total</th>
                                        </tr>
                                        <tr class="text-center">
                                            <td><?php echo $sisa2025 ;?></td>
                                            <td><?php echo $sisa2026;?></td>
                                            <td class="bg-success-lighten"><?php echo $sisaCutiAll;?> </td>
                                        </tr>
                                       </table>

                                </div>
                            </div> <!-- end col -->

                        </div>



                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">Riwayat Cuti</h4>
                                        <br>
                                        
                                          <div class="btn-group" role="group">
                                            <?php foreach ($arrayTahun as $t) : ?>
                                                <a href="<?= base_url('cuti/index/' . $t) ?>" class="btn <?= ($t == $tahunAktif) ? 'btn-primary active' : 'btn-outline-primary' ?>">
                                                <?= $t ?>
                                                </a>
                                            <?php endforeach; ?>
                                            </div>
                                     <br>

                                    

                                        <a href="<?php echo base_url();?>cuti/buat_pengajuan_cuti" class="btn btn-sm btn-primary float-end">Buat Pengajuan Cuti</a>
                                        <div class="clearfix"></div> 

                                        <div class="table-responsive mt-1">
                                            <table class="table table-sm mb-0 table-hover">
                                                <thead>
                                                        <tr>
                                                            <th>Tanggal Pengajuan</th>
                                                            <th>Tanggal Mulai</th>
                                                            <th>Tanggal Akhir</th>
                                                            <th>Lama Cuti</th>
                                                            <th>Alasan</th>
                                                            <th>Status</th>
                                                          
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    

                                                     foreach($history as $row){

                                                        $tgl = $row->tgl_pengajuan;
                                                        $tgl_dari = $row->tgl_mulai;
                                                        $tgl_sampai = $row->tgl_selesai;
                                                        $hari_cuti = $row->lama_cuti;
                                                        $status = $row->status_akhir;
                                                        $tahunCuti = date('Y', strtotime($row->tgl_mulai));

                                                    //    / $flagStatus = getStatusCuti($status);

                                                        if($status=='disetujui'){
                                                            $flag_status = '<span class="badge bg-success">Approved</span>';
                                                        }else if($status=='dibatalkan'){
                                                            $flag_status = '<span class="badge bg-light text-danger">Canceled</span>';
                                                        }else if($status=='ditolak'){
                                                            $flag_status = '<span class="badge bg-danger">Ditolak</span>';
                                                        }else if($status=='draft'){
                                                            $flag_status = '<span class="badge bg-light text-primary">Pengajuan</span>';
                                                        }else{
                                                            $flag_status = '<span class=" badge bg-warning">Proses</span>';
                                                        }

                                                        echo '
                                                         <tr onclick="goToDetail('.$row->id.', '.$tahunCuti.');" style="cursor: pointer;">
                                                            <td>'.format_semi($tgl).'</td>
                                                            <td>'.format_semi($tgl_dari).'</td>
                                                            <td> '.format_semi($tgl_sampai).'</td>
                                                            <td>'. $hari_cuti.' hari</td>
                                                            <td>'. $row->alasan_cuti.' </td>
                                                            <td>'. $flag_status.'</td>
                                                           
                                                        </tr>
                                                        ';


                                                    }

                                                    ?>



                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>



                            <div class="modal fade" id="modal-cuti" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Tanda tangan SPJ TKD</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                             <form method="post" action="<?php echo base_url();?>profile/insert_tdd_spj" enctype="multipart/form-data">
                                             <!-- Date Range -->
                                                    <div class="mb-2">
                                                        <label class="form-label">Date Range</label>
                                                        <input type="text" class="form-control date" name="tgl_cuti" id="singledaterange" data-toggle="date-picker" data-cancel-class="btn-warning">
                                                    </div>

                                                    <div class="mb-2">
                                                        <label>Jenis Cuti</label>
                                                        <select name="jns_cuti" id="jns_cuti"  class="form-control">

                                                                <?php

                                                                for ($c=0; $c < count($master_cuti); $c++) {
                                                                    $id = $master_cuti[$c]->id;
                                                                    $jenis_cuti = $master_cuti[$c]->jenis_cuti;

                                                                    echo ' <option value="'. $id .'">'.$jenis_cuti .'</option>';

                                                                }
                                                            ?>
                                                        </select>
                                                     </div>

                                                     <div class="mb-2">
                                                            <label for="inputValue" class="inline-block text-base font-medium">Pengganti Cuti</label>





                                                                <?php  if(form_error('id_pengganti') != ''){
                                                                    echo '<div class="invalid-feedback px-4 py-3 text-sm text-orange-500 border border-transparent rounded-md bg-orange-50 dark:bg-orange-400/20">'.form_error("id_pengganti").'</div>';}
                                                                ?>



                                                        </div><!--end col-->

                                             <form>



                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <div class="modal fade" id="modal-info-tkd" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Detail Tunjangan</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="detail_tkd"></div>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->



                    </div> <!-- container -->

                </div> <!-- content -->

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


        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <!-- demo end -->


         <script>
            function goToDetail(id, tahunCuti){
                
                
                window.location.href = "<?php echo site_url('cuti/detail_mycuti/');?>"+id+"/"+tahunCuti;
            }

            $('#btn_edit_cuti').on('click', function(){
                var id = $(this).val();
                window.location.href = "<?php echo site_url('cuti/edit_pengajuan_cuti/');?>"+id;
            });
        </script>



        

    </body>
</html>
