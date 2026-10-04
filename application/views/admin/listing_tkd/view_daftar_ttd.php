<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/signature.js"></script>

    <style>
        .my-table{
            width: 100%;
        }
        .my-table  td{
            padding:2px;

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
                            $periode_bulan = $this->session->userdata('periode_bulan');
                            $periode_tahun = $this->session->userdata('periode_tahun');
                            $id_pkm_sess   = $this->session->userdata('id_pkm');



                            $periode = $periode_tahun.'-'.$periode_bulan;
                            $periode = date('F Y', strtotime($periode));

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
                                            <li class="breadcrumb-item active">Main Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php

                                    $list_bulan = array_bulan();

                                    $periode_bulan = $this->session->userdata('periode_bulan');
                                    $periode_tahun = $this->session->userdata('periode_tahun');
                                    $id_pkm_sess   = $this->session->userdata('id_pkm');
                                    $case = $this->uri->segment(4);



                               ?>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="<?php echo base_url();?>laporan/dataraw_spj_ttd_tkd" class="dropdown-item">Raw Data</a>
                                                <a href="<?php echo base_url();?>admin/listing_tkd/export_spj_ttd/<?php echo $case;?>" class="dropdown-item">Export Report</a>
                                            </div>
                                        </div>
                                        <h4 class="header-title">Data Tanda tangan SPJ Pegawai</h4>
                                        <strong>Periode : <?php echo  $periode ;?> </strong>
                                            <?php
                                                $totalRow = count($data_tkd);

                                                if($totalRow==0){
                                                    $totalRow = 1;
                                                }


                                                $numTTD = 0;
                                                for ($i=0; $i < count($data_tkd); $i++) {

                                                      $ttd_spj = $data_tkd[$i]->ttd_spj;
                                                      if($ttd_spj !=''){
                                                        $numTTD =  $numTTD +1;


                                                      }


                                                }

                                                $persentage = ($numTTD/$totalRow)*100;
                                                $persentage = ceil($persentage);
                                            ?>
                                        <div id="views-min" class="apex-charts mt-2" data-colors="#0acf97"></div>

                                                                                    <!-- Success -->
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persentage ;?>%" aria-valuenow="<?php echo $persentage ;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                              <h5>
                                            <?php
                                                echo  '<span class="text-warning">'.$numTTD.' </span>/ '.$totalRow .' rows &nbsp; ( '. $persentage.'%)';
                                            ?>

</h5>




                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm mb-0 table-bordered">
                                                <thead>
                                                    <tr>

                                                            <th class="text-center">No.</th>
                                                            <th>Nama</th>
                                                            <th>Jabatan</th>
                                                            <th>NPWP</th>
                                                            <th class="text-center">Total</th>
                                                            <th class="text-center">No Handphone</th>

                                                            <th class="text-center">TTD</th>
                                                            <th  class="text-center">Action</th>

                                                        </tr>
                                                </thead>
                                                <tbody>

                                                <?php
                                                    $case = $this->uri->segment(4);
                                                $grandTotal = 0;
                                                    $no = 1;
                                                    foreach ($data_tkd as $peg){

                                                    $nama = $peg->nama;
                                                    $nip = $peg->nip;
                                                    $jabatan = $peg->jabatan;
                                                    $npwp = $peg->npwp;


                                                    if($case=='thr'){
                                                        $total =   $peg->total;
                                                        $capaian = rupiah($total);

                                                        $grandTotal = $grandTotal +$total;
                                                    }else{
                                                        $capaian = $peg->capaian;
                                                        if($capaian < 50){
                                                            $class_text = 'text-danger ';
                                                        }else if($capaian > 50 && $capaian < 90){
                                                            $class_text = 'text-warning ';
                                                        }else if($capaian > 90 && $capaian < 98){
                                                            $class_text = 'text-info';
                                                        }else{
                                                            $class_text = 'text-success ';
                                                        }
                                                    }


                                                    $ttd_spj = $peg->ttd_spj;



                                                    if($ttd_spj==''){
                                                        $btn_ttd = '<span class="badge bg-danger">Belum</span>';
                                                        $no_hp = '';
                                                        $btn_reset = '';
                                                    }else{
                                                        $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="100">';
                                                        $no_hp = $peg->no_hp;
                                                        $btn_reset = '<a href="'.base_url().'admin/listing_tkd/reset_tdd/'.$peg->id.'" class="btn btn-sm btn-warning" onClick="return confirm(\'apakah anda ingin mereset tandatangan ini?\')">
                                                          Reset
                                                        </a>';
                                                    }



                                                        echo' <tr>
                                                                    <td class="text-center">'.$no.'</td>
                                                                    <td class="text-left"> '.$nama.'</td>

                                                                    <td class="text-left">'.$jabatan.'</td>
                                                                    <td class="text-center">'.$npwp.'</td>
                                                                    <td class="text-end">'.$capaian.'</td>

                                                                    <td class="text-center">'.$no_hp.'</td>
                                                                    <td class="text-center">'.$btn_ttd.'</td>
                                                                    <td class="text-center">'.$btn_reset.'</td>

                                                                </tr>';

                                                            $no += 1;

                                                    }

                                                    ?>

                                                    <tr>
                                                        <td>Total</td>
                                                        <td colspan="4" class="text-end fw-bold"><?php echo rupiah($grandTotal);?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

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
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

        <script>
        var message = '<?php echo $message;?>';

        if(message != ''){
            $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
        }

        </script>

    </body>
</html>
