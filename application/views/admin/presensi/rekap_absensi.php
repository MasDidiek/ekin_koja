<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
<!-- DataTables CSS -->


                    <!-- Datatables css -->
    <link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />


    
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

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/my_dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>setting/hari_kerja">Data Absensi</a></li>
                                            <li class="breadcrumb-item active">Rekap Absensi</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Rekap Absensi</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php
                                $message = $this->session->flashdata('message');
                            
                                $list_bulan = array_bulan();
                                $MonthNow = date('m');

                                
                                $periode_bulan = $this->session->userdata('periode_bulan');
                                $periode_tahun = $this->session->userdata('periode_tahun');
                                $id_pkm_sess   = $this->session->userdata('id_pkm');
                                $id_pj_sess = $this->session->userdata('id_pj');
                                $id_user_validator   = $this->session->userdata('id_pegawai');

                                if($periode_bulan=='') {
                                $bulan = date('m');
                                $tahun = date('Y');

                                }else{
                                    $bulan = $periode_bulan;
                                    $tahun = $periode_tahun;
                                }

                                $periode = $tahun.'-'.$bulan;
                                $periode = date('Y-m', strtotime($periode));

                                $nm_bulan = getBulan($bulan);

                            ?>

            
                  <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                        <div class="card-body p-4">
                    
                                   <div class="fs-4">
                                    <?php echo  $nm_bulan;?> 2025
                                    </div>

                                <div class="clearfix"></div>

                                     <table class="table  table-bordered table-sm"  id="data-table">
                                         <thead class="bg-light">
                                                <tr>
                                                    <th class="text-center" data-sort="no">No</th>
                                                    <th class="text-center" data-sort="nama_pegawai">Nama Pegawai</th>
                                                    <th class="text-center" data-sort="telat">Telat</th>
                                                    <th class="text-center" data-sort="p_awal">P. Awal</th>
                                                    <th class="text-center" data-sort="izin">Izin</th>
                                                    <th class="text-center" data-sort="sakit">Sakit</th>
                                                    <th class="text-center" data-sort="sakit_dgn_surat">Sakit Dgn Surat</th>
                                                    <th class="text-center" data-sort="cuti">Cuti</th>
                                                    <th class="text-center" data-sort="status">Status</th>
                                                </tr>
                                            </thead>
                                          <tbody>
      
                                          
                                            <?php 

                                                
                                                    $no = 1;
                                                    foreach ($data_rekap as $rekap){

                                                            $nama = $rekap->nama;
                                                            $telat = $rekap->telat;
                                                            $pulang_awal = $rekap->pulang_awal;
                                                            $sakit = $rekap->sakit;
                                                            $izin = $rekap->izin;
                                                            $cuti = $rekap->cuti;
                                                            $sakit_dgn_sk = $rekap->sakit_dgn_sk;
                                                            $status = $rekap->status;

                                                            if($status==0){
                                                                $flag_status = '<span class="badge bg-warning">Belum Sesuai</span>';
                                                            }else{
                                                                $flag_status = '<span class="badge bg-success">Sesuai</span>';
                                                            }
                                                            
                                                        

                                                        echo' <tr>
                                                                <td class="text-center">'.$no.'</td>
                                                                <td class="text-left"> '.$nama.' </td>
                                                                <td class=" text-center">'.$telat.'</td>
                                                                <td class="text-center">'.$pulang_awal.'</td>
                                                                <td class="text-center">'.$izin.'</td>
                                                                <td class="text-center">'.$sakit.'</td>
                                                                <td class="text-center">'.$sakit_dgn_sk.'</td>
                                                                <td class="text-center">'.$cuti.'</td>
                                                                <td class="text-center">'.$flag_status.'</td>


                                                                </tr>';

                                                            $no += 1;

                                                    }

                                                ?>
                                          
                                             
      
                                          </tbody>
      
                                    </table>
                                
                                </div>
                            </div><!--card body-->
                        </div>

                               
                       

                        </div>
                      </div>
                    </div>
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

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- DataTables JS -->
    
                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
   

        <!-- Inisialisasi DataTable -->
        <script>
            $(document).ready(function() {
                $('#data-table').DataTable({
                    // Optional settings:
                    paging: true,
                    searching: true,
                    ordering: true,
                    responsive: true,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                        },
                        zeroRecords: "Data tidak ditemukan",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        infoFiltered: "(disaring dari _MAX_ total data)"
                    }
                });
            });
        </script>



    </body>
</html>
