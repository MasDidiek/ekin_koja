<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />

<style>

        .avatar-lg{
            width: 200px;
            height: 250px;
            box-shadow: 10px 10px 5px -4px rgba(240,240,240,0.75);
            -webkit-box-shadow: 10px 10px 5px -4px rgba(240,240,240,0.75);
            -moz-box-shadow: 10px 10px 5px -4px rgba(240,240,240,0.75);
            padding:5px;
            border:1px solid #ccc;
        }

        .avatar-lg img{
            width: 190px;
            height: 240px;

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

                          $id_pegawai = $pegawai[0]->id_pegawai;
                          $tgl_masuk = $pegawai[0]->tgl_masuk;
                          $nip = $pegawai[0]->nip;
                          $nama_pegawai = $pegawai[0]->nama;
                          $photo = $this->Pegawai_model->getPhotoPegawai($nip);

                          if($photo==''){
                            $photo = 'avatar.png';
                          }


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


                            $tahun = date('Y');


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


                            $tmt = $pegawai[0]->tmt;
                            $today = date('Y-m-d');

                            $masa_kerja = hitungMasaKerja($tmt, $today);

                            $detailPegawai = $this->Pegawai_model->getDataDetailPegawai($nip);


                            $no_ktp  = $detailPegawai[0]->no_ktp;
                            $no_rekening  = $detailPegawai[0]->no_rekening;
                            $npwp  = $detailPegawai[0]->npwp;

                            $jns_kelamin  = $detailPegawai[0]->jns_kelamin;
                            $alamat_ktp  = $detailPegawai[0]->alamat_ktp;
                            $alamat_domisili  = $detailPegawai[0]->alamat_domisili;
                            $no_tlp  = $detailPegawai[0]->no_tlp;
                            $email  = $detailPegawai[0]->email;

                            $agama  = $detailPegawai[0]->agama;
                            $status_perkawinan  = $detailPegawai[0]->status_perkawinan;


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
                             <div class="card">
                                    <div class="card-body">
                                        <div class="container border p-4">
                                                <h5>DATA PEGAWAI</h5>
                                                <div class="row">
                                                    <div class="col-md-10 ">
                                                        <table>
                                                            <tbody>
                                                                <tr>
                                                                    <td width="150">Nama</td>
                                                                    <td width="20">:</td>
                                                                    <td><?php echo $nama_pegawai; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>NIP</td>
                                                                     <td>:</td>
                                                                    <td><?php echo $nip; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Jabatan</td>
                                                                     <td>:</td>
                                                                    <td><?php echo  $pegawai[0]->jabatan; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Unit Kerja</td>
                                                                     <td>:</td>
                                                                    <td><?php echo $pegawai[0]->puskesmas; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>TMT</td>
                                                                     <td>:</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Masa Kerja</td>
                                                                     <td>:</td>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Status Pegawai</td>
                                                                     <td>:</td>
                                                                    <td></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="avatar-lg">
                                                            <img src="<?php echo base_url().'uploads/photo_profile/'. $photo ;?>" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <table class="table table-xs table-borderless p-2">
                                                    <tr>
                                                        <td class="text-muted" width="180">Nama Lengkap</td>
                                                        <td class="fw-bold "><?php echo $nama_pegawai ;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Tampat  Lahir</td>
                                                        <td class="fw-bold "><?php echo $detailPegawai[0]->tempat_lahir ;?></td>
                                                    </tr>
                                                     <tr>
                                                        <td class="text-muted">Tanggal  Lahir</td>
                                                        <td class="fw-bold "><?php echo format_view($detailPegawai[0]->tgl_lahir) ;?></td>
                                                    </tr>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Jenis Kelamin</td>
                                                        <td class="fw-bold "><?php echo ($jns_kelamin == 'P') ? 'Perempuan' : 'Laki-laki';?></td>
                                                    </tr>

                                                     <tr>
                                                        <td class="text-muted">Kewarganegaraan</td>
                                                        <td class="fw-bold ">WNI</td>
                                                    </tr>
                                                     <tr>
                                                        <td class="text-muted">Status Perkawinan</td>
                                                        <td class="fw-bold "><?php echo $status_perkawinan;?></td>
                                                    </tr>
                                                     <tr>
                                                        <td class="text-muted">Agama</td>
                                                        <td class="fw-bold "><?php echo $agama;?></td>
                                                    </tr>
                                                     <tr>
                                                        <td class="text-muted">No KTP</td>
                                                        <td class="fw-bold "><?php echo $detailPegawai[0]->no_ktp ;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">NPWP</td>
                                                        <td class="fw-bold "><?php echo $detailPegawai[0]->npwp ;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">No Rekening</td>
                                                        <td class="fw-bold "><?php echo $detailPegawai[0]->no_rekening ;?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-muted">Pendidikan Terakhir</td>
                                                        <td class="fw-bold "><?php echo $pendidikan;?></td>
                                                    </tr>
                                                      <tr>
                                                        <td class="text-muted">Email</td>
                                                        <td class="fw-bold "><?php echo $email ;?></td>
                                                    </tr>
                                                      <tr>
                                                        <td class="text-muted">No Telp/HP</td>
                                                        <td class="fw-bold "><?php echo $no_tlp ;?></td>
                                                    </tr>
                                                      <tr>
                                                        <td class="text-muted">Alamat</td>
                                                        <td class="fw-bold "></td>
                                                    </tr>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>


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





    </body>
</html>
