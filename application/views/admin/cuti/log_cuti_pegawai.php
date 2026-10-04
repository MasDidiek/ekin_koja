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


                               ?>




                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">Riwayat Cuti</h4>
                                        <br>

                                       

                                        <div class="table-responsive mt-3">
                                            <h4> Cuti tahun : 2024 </h4>
                                            <table class="table table-sm mb-0 table-bordered">
                                                <thead>
                                                        <tr>
                                                            <th class="text-center">No</th>
                                                            <th class="text-center">Jenis Cuti</th>
                                                            <th class="text-center">Jenis Transaksi</th>
                                                            <th class="text-center">Tgl Cuti</th>
                                                            <th>Keterangan</th>
                                                             <th  class="text-center">Sisa Awal</th>
                                                            <th  class="text-center">Jmlh Hari Cuti</th>
                                                            <th class="text-center">Sisa Akhir</th>

                                                        </tr>
                                                      
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        //print_array($pegawai);
                                                        $no = 1;
                                                        foreach ($log_cuti_2024 as $list) {

                                                            $id_pegawai = $list->id_pegawai;
                                                            $id_cuti = $list->id_cuti;
                                                            
                                                            $detCuti = $this->Cuti_model->getDetailCuti($id_cuti);
                                                            if(!empty($detCuti)){
                                                                $tgl_awal = $detCuti[0]->tgl_dari;
                                                                $tgl_akhir = $detCuti[0]->tgl_sampai;

                                                                $tgl_cuti = $tgl_awal.' - '.$tgl_akhir;
                                                            }else{
                                                              
                                                                $tgl_cuti = '';
                                                            }




                                                           echo '
                                                           <tr>
                                                              <td>'.$no.'</td>
                                                               <td class="text-center">'.$list->jns_cuti .'</td>
                                                               <td class="text-center">'.$list->jns_transaksi.'</td>
                                                                <td class="text-center">'.$tgl_cuti.'</td>
                                                               <td>'.$list->keterangan.'</td>
                                                               <td class="text-center">'.$list->sisa_awal.'</td>
                                                               <td class="text-center">'.$list->jumlah.'</td>
                                                               <td class="text-center">'.$list->sisa_akhir.'</td>
                                                             
                                                           </tr>';

                                                           $no++;
                                                        }
                                                    ?>

                                                </tbody>
                                            </table>


                                            <br>
                                             <h4> Cuti tahun : 2025 </h4>
                                            <table class="table table-sm mb-0 table-bordered">
                                                <thead>
                                                        <tr>
                                                             <th class="text-center">No</th>
                                                            <th class="text-center">Jenis Cuti</th>
                                                            <th class="text-center">Jenis Transaksi</th>
                                                            <th class="text-center">Tgl Cuti</th>
                                                            <th>Keterangan</th>
                                                             <th  class="text-center">Sisa Awal</th>
                                                            <th  class="text-center">Jmlh Hari Cuti</th>
                                                            <th class="text-center">Sisa Akhir</th>

                                                        </tr>
                                                      
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        //print_array($pegawai);
                                                        $no = 1;
                                                        foreach ($log_cuti_2025 as $list) {

                                                            $id_pegawai = $list->id_pegawai;
                                                             $id_cuti = $list->id_cuti;
                                                            
                                                            $detCuti = $this->Cuti_model->getDetailCuti($id_cuti);
                                                            if(!empty($detCuti)){
                                                                $tgl_awal = $detCuti[0]->tgl_dari;
                                                                $tgl_akhir = $detCuti[0]->tgl_sampai;

                                                                $tgl_cuti = $tgl_awal.' - '.$tgl_akhir;
                                                            }else{
                                                              
                                                                $tgl_cuti = '';
                                                            }



                                                           echo '
                                                           <tr>
                                                              <td>'.$no.'</td>
                                            
                                                               <td class="text-center">'.$list->jns_cuti .'</td>
                                                               <td class="text-center">'.$list->jns_transaksi.'</td>
                                                                <td class="text-center">'.$tgl_cuti.'</td>
                                                               <td>'.$list->keterangan.'</td>
                                                               <td class="text-center">'.$list->sisa_awal.'</td>
                                                               <td class="text-center">'.$list->jumlah.'</td>
                                                               <td class="text-center">'.$list->sisa_akhir.'</td>
                                                             
                                                           </tr>';

                                                           $no++;
                                                        }
                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>


                             <div class="modal fade" id="cuti-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-scrollable" role="document">

                                        <div class="modal-content">
                                                <form action="<?php echo base_url(); ?>admin/cuti/insert_hak_cuti/2024" method="post" enctype="multipart/form-data" id="pengajuan_cuti">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="scrollableModalTitle">Input Hak Cuti</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        
                                                            <input type="text" class="hari_cuti" id="id_pegawai" name="id_pegawai">
                                                            <div class="col-md-4 mt-2">
                                                                <div class="form-group">
                                                                    <label class="form-label">Jumlah Hari</label>
                                                                    <input type="number" class="form-control text-center" value="0" name="hari">
                                                                </div>
                                                            </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-success kirim" id="submit_btn">Simpan</button>
                                                    </div>
                                            </form>
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
            var message = '<?php echo $message;?>';

            if(message != ''){
                $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
            }


            $(".insert_hak_cuti").click(function(){
                var id_pegawai = $(this).val();

                $("#id_pegawai").val(id_pegawai);

            });
         

        </script>




    </body>
</html>
