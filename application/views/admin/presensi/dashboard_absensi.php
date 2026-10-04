<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <style>
        .btn-xs{
            padding:3px 6px !important;
        }
    </style>

    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/index">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/presensi/index_v3">Absensi Pegawai</a></li>
                                            <li class="breadcrumb-item active">Data Absensi</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Data Absensi</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                       <?php
//print_array($validator);
                        //hilangkan array terakhir, karna validator ukp terlalu banyak pegawainya, dibuat terpisah saja
                        $validator = array_slice($validator, 0, 11);

                        $labels = array_map(function($item) {
                            return str_replace('validator_', '', $item->userlevel_name);
                        }, $validator);


                        //print_array($labels);

                        
                        $thn_anggaran = 2024;
                        $numPegawaiArray = array();
                        $periode = '2025-07';

                        $jumlahPegawaiArray = array();

                        foreach ($validator as $key => $value) {
                            $id_validator = $value->id_pegawai;
                            $nama_validator = $value->nama;

                            // Ambil daftar pegawai berdasarkan validator
                            $pegawaiList = $this->Pegawai_model->getListPegawaiByValidator($id_validator, $thn_anggaran);
                            $jumlahPegawaiArray[] = count($pegawaiList);
                            // Inisialisasi counter untuk setiap status absensi
                            $sudahSesuai = 0;
                            $belumSesuai = 0;
                            $belumDirekap = 0;

                            foreach ($pegawaiList as $pegawai) {
                                // Ambil status absensi pegawai (gunakan model atau query untuk ini)
                                $absensi = $this->Presensi_model->getRekapAbsensiPegawai($pegawai->id_pegawai, $periode);

                                // Jika data absensi ditemukan
                                if ($absensi) {
                                    // Cek status absensi
                                    if ($absensi[0]->status == 1) {
                                        // Status 1 berarti absensi sudah sesuai
                                        $sudahSesuai++;
                                    } elseif ($absensi[0]->status == 0) {
                                        // Status 0 berarti absensi belum sesuai
                                        $belumSesuai++;
                                    }
                                } else {
                                    // Jika tidak ada data absensi, berarti belum direkap
                                    $belumDirekap++;
                                }
                            }

                            // Simpan hasil per validator
                            $numPegawaiArray[] = [
                                'validator' => $nama_validator,
                                'sudah_sesuai' => $sudahSesuai,
                                'belum_sesuai' => $belumSesuai,
                                'belum_direkap' => $belumDirekap
                            ];
                        }

                     //print_array($numPegawaiArray);
                      ?>
                        <div class="row">
                            <div class="col-xl-8">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Rekap Absensi</h4>
                                        <div dir="ltr">
                                            <div id="stacked-column" class="apex-charts" data-colors="#39afd1,#ffbc00,#F00"></div>
                                        </div>
                                    </div>
                                    <!-- end card body-->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col-->


                            <div class="col-xl-4">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Rekap Absensi Pegawai UKP</h4>
                                        <div dir="ltr">
                                            <div id="full-stacked-column" class="apex-charts" data-colors="#39afd1,#0acf97,#e3eaef"></div>
                                        </div>
                                    </div>
                                    <!-- end card body-->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col-->
                        </div>
                        <!-- end row-->

                        <!-- end row -->
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

        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


  <script>

   var sudahSesuai = <?= json_encode(array_column($numPegawaiArray, 'sudah_sesuai')); ?>;
   var belumSesuai = <?= json_encode(array_column($numPegawaiArray, 'belum_sesuai')); ?>;
   var belumDirekap = <?= json_encode(array_column($numPegawaiArray, 'belum_direkap')); ?>;
   var totalPegawai = <?= json_encode(array_map(function($item) {
       return array_sum([$item['sudah_sesuai'], $item['belum_sesuai'], $item['belum_direkap']]);
     }, $numPegawaiArray)); ?>;

   var labels =  <?= json_encode($labels); ?>;

    var options = {
      chart: {
        type: 'bar',
        height: 400,
        stacked: true,
        toolbar: {
          show: true
        },
        zoom: {
          enabled: true
        }
      },
      series: [{
             name: 'Sudah Sesuai',
             data: sudahSesuai,
             color: '#28a745' // Warna hijau untuk "Sudah Sesuai"
           },
           {
             name: 'Belum Sesuai',
             data: belumSesuai,
                color: '#ffc107' // Warna kuning untuk "Belum Sesuai"
           },
           {
             name: 'Belum Direkap',
             data: belumDirekap,
               color: '#dc3545' // Warna merah untuk "Belum Direkap"
           }
         ],
         xaxis: {
           categories: labels,
           labels: {
             rotate: -45
           }
         },
         yaxis: [{
           title: {
             text: 'Jumlah Pegawai'
           }
         }],
         legend: {
           position: 'top'
         },
         fill: {
           opacity: 1
         },
         title: {
           text: 'Status Absensi Pegawai per Validator',
           align: 'center'
         }
    };

    var chart = new ApexCharts(document.querySelector("#stacked-column"), options);
    chart.render();
  </script>

    </body>





</html>
