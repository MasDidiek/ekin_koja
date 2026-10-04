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


                             $detailPegawai = $this->Pegawai_model->getDataDetailPegawai($nip);


                             //print_array($detailPegawai);
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
                            <div class="col-md-7">
                                <?php
                                    $this->load->view('profile/partial/tab-menu');
                                ?>

                                 <div class="card">
                                    <div class="card-body">



                                                <?php

                                                // print_array($detailPegawai);
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



                                                    $agama_list = [ 'Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu','Lainnya' ];
                                                ?>


                                            <!-- Tombol untuk membuka modal -->
                                            <button type="button" class="btn btn-light float-end btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditData">
                                             <i class="uil-edit"></i>   Ubah
                                            </button>




                                              <div class="fw-bold fs-5 pt-2">DATA DIRI</div> <br>
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
                             <div class="col-md-5">
                                 <div class="card">
                                    <div class="card-body">
                                         <div class="fw-bold fs-5 pt-2">DATA KEPEGAWAIAN</div> <br>
                                         <table class="table table-xs table-borderless p-2">
                                                <tr>
                                                    <td class="text-muted" width="180">NIP</td>
                                                    <td class="fw-bold "><?php echo $nip;?></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-muted">Jabatan</td>
                                                    <td class="fw-bold "> <?php echo $pegawai[0]->jabatan;?> -  <?php echo $pegawai[0]->keterangan_jabatan;?></td>
                                                </tr>
                                                 <tr>
                                                    <td class="text-muted">Unit Kerja</td>
                                                    <td class="fw-bold "><?php echo $pegawai[0]->puskesmas;?></td>
                                                </tr>
                                                 <tr>
                                                    <td class="text-muted">Rumpun Kerja</td>
                                                    <td class="fw-bold "><?php echo $pegawai[0]->rumpun_kerja;?></td>
                                                </tr>
                                                 <tr>
                                                    <td class="text-muted">Jenis Jam Kerja</td>
                                                    <td class="fw-bold "><?php echo ($jns_jam_kerja == 'shift') ? 'SHIFT' : 'REGULER';?></td>
                                                </tr>
                                                  <tr>
                                                    <td class="text-muted">Atasan Langsung</td>
                                                    <td class="fw-bold "></td>
                                                </tr>
                                         </table>

                                    </div>
                                 </div>
                             </div>
                        </div>


                         <div class="modal fade" id="modalEditData" tabindex="-1" aria-labelledby="modalEditDataLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <form id="formEditData" action="<?php echo base_url();?>profile/update_myprofile" method="post">
                                    <div class="modal-header">
                                     <h5 class="modal-title" id="editDataModalLabel">Edit Data</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                    </div>
                                    <div class="modal-body">

                                      <div class="loader mb-4 text-center d-none">
                                        <div class="spinner-border text-primary" role="status"></div> <span class="text-primary"> Sedang Menyimpan data...</span>
                                    </div>

                                    <div class="row g-3">
                                        <div class="col-md-4">
                                            <label class="form-label">Nama Lengkap</label>
                                            <input type="text" class="form-control" name="nama_lengkap" value="<?php echo $nama_pegawai;?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Jenis Kelamin</label>
                                            <select class="form-select" name="jenis_kelamin">
                                                <option value="L" <?= ($detailPegawai[0]->jns_kelamin == 'L') ? 'selected' : '' ?>>Laki-laki</option>
                                                <option value="P" <?= ($detailPegawai[0]->jns_kelamin == 'P') ? 'selected' : '' ?>>Perempuan</option>
                                            </select>
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">Tempat Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir" value="<?php echo $detailPegawai[0]->tempat_lahir ;?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input type="date" class="form-control" name="tgl_lahir" value="<?php echo $detailPegawai[0]->tgl_lahir ;?>">
                                        </div>

                                        <div class="col-md-4">
                                        <label class="form-label">Status Perkawinan</label>
                                            <select class="form-select" name="status_perkawinan">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="Belum menikah" <?= ($status_perkawinan == 'Belum menikah') ? 'selected' : '' ?>>Belum menikah</option>
                                                <option value="Menikah"  <?= ($status_perkawinan == 'Menikah') ? 'selected' : '' ?>>Menikah</option>
                                                <option value="Duda"  <?= ($status_perkawinan == 'Duda') ? 'selected' : '' ?>>Duda</option>
                                                <option value="Janda"  <?= ($status_perkawinan == 'Janda') ? 'selected' : '' ?>>Janda</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                        <label class="form-label">Agama</label>
                                            <select class="form-select" name="agama">
                                                <option value="">-- Pilih Agama --</option>
                                                <?php foreach ($agama_list as $item): ?>
                                                <option value="<?= $item ?>" <?= ($agama == $item) ? 'selected' : '' ?>>
                                                    <?= $item ?>
                                                </option>
                                                <?php endforeach; ?>
                                                    </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">No KTP</label>
                                            <input type="text" class="form-control" name="no_ktp" value="<?php echo $no_ktp;?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">NPWP</label>
                                            <input type="text" class="form-control" name="npwp" value="<?php echo $npwp;?>">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="form-label">No Rekening</label>
                                            <input type="text" class="form-control" name="no_rekening" value="<?php echo $no_rekening;?>">
                                        </div>

                                        <div class="col-md-4">
                                            <label class="form-label">No Telp/HP</label>
                                            <input type="text" class="form-control" name="no_hp" value="<?php echo $no_tlp;?>">
                                        </div>

                                        <div class="col-md-8">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" value="<?php echo $email;?>">
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Alamat KTP</label>
                                            <textarea class="form-control" name="alamat_ktp" rows="3"><?php echo $alamat_ktp;?></textarea>
                                        </div>


                                        <div class="col-md-6">
                                            <label class="form-label">Alamat Domisili</label>
                                            <textarea class="form-control" name="alamat_domisili" rows="3"><?php echo $alamat_domisili;?></textarea>
                                        </div>
                                        </div>
                                    </div>



                                    <div class="modal-footer mt-3">


                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
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


          <script>
            /*$(document).ready(function() {
                $('#formEditData').submit(function() {
                    $(".loader").removeClass("d-none");
                     $.ajax({


                        type: 'POST',
                        url: $(this).attr('action'),
                        data: $(this).serialize(),
                        success: function(msg) {
                            // Ganti isi loader dengan pesan sukses
                             $(".loader").html(msg);

                                // Tunggu 5 detik (5000 ms), lalu reload halaman
                                setTimeout(function() {
                                window.location.reload();
                                }, 5000);
                            }
                        });
                           return false;
                    });


                 });*/
            </script>

    </body>
</html>
