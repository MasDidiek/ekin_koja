<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <style>
        .btn-xs{
            padding:3px 6px !important;
        }

        .modal-dialog{
            z-index:999;
        }

        .badge-status{
            padding: 2px 5px;
            font-size: 12px;
            color: #FFF;
        }
       .bg-danger-subtle{
        background-color: #fff8f8;
        color: #cc6060;
       }

    </style>
    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":true, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Main Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Data Absensi</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php
                                $nm_bulan = getBulan($bulan);
                                $pin = $this->uri->segment(4);
                                $id_pegawai = $detailPegawai->id_pegawai;
                                $id_puskesmas = $detailPegawai->id_puskesmas;

                                $ip_address = $this->Master_model->getIpAddress($id_puskesmas);

                                // $absensi_raw    = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);

                                // print_array($absensi_raw);


                                 //$ip_address = $this->Master_model->getIpAddress($id_puskesmas);

                                if (!empty($dataRekap)) {

                                    $id_rekap = $dataRekap[0]->id;
                                    $status = $dataRekap[0]->status;
                                    
                                    $telat = $dataRekap[0]->telat;
                                    $alpha = $dataRekap[0]->alpha;
                                    $pulang_awal = $dataRekap[0]->pulang_awal;
                                    $sakit = $dataRekap[0]->sakit;
                                    $sakit_dgn_dk = $dataRekap[0]->sakit_dgn_sk;
                                    $izin = $dataRekap[0]->izin;
                                    $cuti = $dataRekap[0]->cuti;
                        
                                    if($status==0){
                                        $status_absen = '<div class="badge badge-warning-lighten">
                                                            <i class="uil-shield-question text-warning"></i>   Data absensi belum sesuai
                                                        </div> ';
                                    }else{
                                        $status_absen = '<div class="badge badge-success-lighten">
                                                            <i class="uil-shield-check text-success"></i>   Data absensi sudah sesuai.
                                                        </div>';
                                    }

                        
                            }else{
                                    $id_rekap =  0;
                                    $telat = '-';
                                    $pulang_awal = '-';
                                     $alpha = 0;
                                    $sakit =  '-';
                                    $izin =  '-';
                                    $cuti = '-';
                                    $sakit_dgn_dk = 0;
                                    $status=0;
                                    $status_absen = '<div class="badge badge-danger-lighten">
                                                    <i class="uil-exclamation-circle  text-danger"></i> <span class="font-bold">Warning!</span>  Data absensi Belum direkap.
                                                </div>';
                            
                            }
                        ?>
                        <div class="row">

                        

                            <div class="col-xxl-3 col-lg-6">
                                
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                         <a href="<?php echo base_url();?>admin/absensi/rekap_absensi" class="btn btn-light float-start">
                                        <i class="mdi mdi-arrow-left"></i> Kembali</a>
                                        <div class="clearfix"></div>
                                       
                                    
                                        <div class="row">
                                             <div class="col-md-3">
                                                   
                                                <div style="font-size:80px">
                                                    <i class="mdi mdi-account-box"></i>
                                                </div>
                                            </div>
                                             <div class="col-md-8 pb-2"> 
                                                <br>
                                                <h4 class="mb-1"><a href="#!" class="text-dark"><?php echo $detailPegawai->nama;?></a></h4>
                                                <p class="font-13"><a href="#!"  class="text-secondary"><?php echo $detailPegawai->nip;?></a></p>

                                                <strong><?php echo $detailPegawai->jabatan;?></strong> <br>
                                                <?php echo $detailPegawai->puskesmas;?>
                                               
                                             </div>

                                             <hr>

                                             <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-md-7">  <strong> Periode : <?php echo  $nm_bulan.' &nbsp; '.$tahun;?> </strong></div>
                                                  
                                                </div>
                                               
                                             </div>
                                    </div>
                                </div>
                            </div>
                               </div>

                            <div class="col-xxl-9 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data Absensi Mesin</h4>
                                        <br>

                                      <?php //print_array($absensi_raw);
                                      
                                      
                                        $periode = $tahun . '-' . $bulan;
                                        $periode = date('Y-m', strtotime($periode));
                                         $filtered = [];

                                            foreach ($absensi_raw as $row) {
                                                
                                                $bulan_data = date('Y-m', strtotime($row['DateTime']));
                                                
                                                if ($bulan_data === $periode) {
                                                    $filtered[] = $row;
                                                }
                                            }
                                      ?>
                                         <table class="table mt-4 table-bordered table-sm text-center">
                                                <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th class="text-center">Date Time</th>
                                                    <th>Status Absen</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
                                                 <?php if (!empty($filtered)) : ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($filtered as $row) : ?>

                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= date('d-m-Y H:i:s', strtotime($row['DateTime'])); ?></td>
                                                            <td>
                                                                <?php 
                                                                    if ($row['Status'] == 0) {
                                                                        echo '<span class="badge bg-success">Masuk</span>';
                                                                    } elseif ($row['Status'] == 1) {
                                                                        echo '<span class="badge bg-danger">Pulang</span>';
                                                                    } else {
                                                                        echo '<span class="badge bg-secondary">Lainnya</span>';
                                                                    }
                                                                ?>
                                                            </td>
                                                        </tr>

                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="3">Tidak ada data</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>

                                       </table>

                                    

                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>    
                     </div>
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


        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url();?>assets/new/js/ui/component.todo.js"></script>
     

        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

        
    </body>
</html>
