<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>

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
                        // print_array($pegawai);

                            $id_pegawai     = $pegawai[0]->id_pegawai;
                            $tgl_masuk      = $pegawai[0]->tgl_masuk;
                            $nip            = $pegawai[0]->nip;
                            $nama_pegawai   = $pegawai[0]->nama;
                            $tmt            = $pegawai[0]->tmt;
                            $id_pendidikan = $pegawai[0]->id_pendidikan;
                            $jns_jam_kerja  = $pegawai[0]->jns_jam_kerja;
                            $photo          = $this->Pegawai_model->getPhotoPegawai($nip);

                            if($photo==''){
                                $photo = 'avatar.png';
                            }




                            $pendidikan = $this->Master_model->getNamaPendidikan($id_pendidikan);

                            $tahun = date('Y');
                            $today = date('Y-m-d');

                            $masa_kerja = hitungMasaKerja($tmt, $today);




                            $arrayPendidikan  = array('SD', 'SMP', 'SMA', 'D3', 'S1', 'S2', 'S3');

                            if(!empty($riwayat_pendidikan)){
                                $btn_text = 'Simpan Perubahan';
                            }else{
                                $btn_text = 'Simpan';
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

                        <?php
                            $this->load->view('profile/partial/top-profile');
                        ?>

                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                    $this->load->view('profile/partial/tab-menu');
                                ?>

                                 <div class="card">
                                    <div class="card-body">
                                              <div class="fw-bold fs-5 pt-2">PENDIDIKAN</div> <br>

                                               <form action="<?php echo base_url();?>profile/update_data_pendidikan" method="post">

                                               <button type="submit" class="btn btn-success float-end"><?php echo $btn_text;?></button>

                                                <table class="table">
                                                    <tr>

                                                        <th width="150">Jenjang</th>
                                                        <th>Nama Sekolah</th>
                                                        <th>Jurusan</th>
                                                        <th width="150">Tahun Lulus</th>
                                                    </tr>

                                                <?php

                                                    //print_array($riwayat_pendidikan);
                                                    for ($i=0; $i < 6; $i++) {

                                                        if($i < 2){
                                                            $disable = 'readonly';
                                                        }else{
                                                            $disable = '';
                                                        }


                                                        $jenjang = $arrayPendidikan[$i];
                                                        $pend = $this->Pegawai_model->getRiwayatPendidikanByJenjang($nip, $jenjang);

                                                        if(!empty($pend)){
                                                            $nama_sekolah = $pend[0]->nama_sekolah;
                                                            $jurusan = $pend[0]->jurusan;
                                                            $tahun_lulus = $pend[0]->tahun_lulus;
                                                        }else{
                                                            $nama_sekolah = '';
                                                            $jurusan = '';
                                                            $tahun_lulus = '';
                                                        }


                                                        echo ' <tr>

                                                                    <td> <input type="text" name="jenjang[]" value="'.$jenjang.'" readonly class="form-control"></td>
                                                                    <td> <input type="text" name="nama_sekolah[]" value="'. $nama_sekolah.'" class="form-control"></td>
                                                                    <td> <input type="text" name="jurusan[]" value="'.$jurusan.'" '. $disable.' class="form-control"  ></td>
                                                                    <td>
                                                                        <select name="tahun_lulus[]" class="form-control">';

                                                                            if($i < 2){
                                                                                $thn_pilih = 2005;
                                                                            }else{
                                                                                $thn_pilih = 2025;
                                                                            }
                                                                            for ($t=$thn_pilih; $t > 1980; $t--) {
                                                                                    if( $tahun_lulus== $t){
                                                                                        echo '<option value="'.$t.'" selected>'.$t.'</option>';
                                                                                    }else{
                                                                                        echo '<option value="'.$t.'">'.$t.'</option>';
                                                                                    }

                                                                            }

                                                                        echo '</select>
                                                                    </td>

                                                                </tr>
                                                        ';
                                                    }
                                                ?>

                                                </table>

                                            </form>




                                    </div>
                                </div>
                            </div>

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
