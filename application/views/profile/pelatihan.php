<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>

<style>


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
                    <?php
                        // print_array($pegawai);

                        $upload_status  = $this->session->flashdata('message_status');
                        $upload_message = $this->session->flashdata('message');
   $arayJenis = getListJnsDiklat();

                        $id_pegawai     = $pegawai[0]->id_pegawai;
                        $nip            = $pegawai[0]->nip;
                        $nama_pegawai   = $pegawai[0]->nama;

                            $dokumen_rules = [
                            [
                                'jns_dokumen' => 'KTP',
                                'format' => ['jpg', 'png'],
                                'keterangan' => '<span class="text-danger">wajib Upload</span>'
                            ],
                            [
                                'jns_dokumen' => 'Kartu Keluarga',
                                'format' => ['jpg', 'png'],
                                'keterangan' => '<span class="text-danger">wajib Upload</span>'
                            ],
                            [
                                'jns_dokumen' => 'Ijazah',
                                'format' => ['pdf', 'jpg', 'png'],
                                'keterangan' => '<span class="text-danger">wajib Upload</span>'
                            ],

                            [
                                'jns_dokumen' => 'Surat Nikah',
                                'format' => ['pdf'],
                                'keterangan' => '<span class="text-primary">Jika sudah menikah</span>'
                            ],
                            [
                                'jns_dokumen' => 'Surat Cerai',
                                'format' => ['pdf'],
                                'keterangan' => '<span class="text-primary">Jika sudah Cerai</span>'
                            ],[
                                'jns_dokumen' => 'Akta Lahir Anak',
                                'format' => ['pdf'],
                                'keterangan' => '<span class="text-primary">Jika sudah punya anak</span>'
                            ],[
                                'jns_dokumen' => 'SIP',
                                'format' => ['pdf'],
                                'keterangan' => '<span class="text-warning">Nakes wajib upload</span>'
                            ],
                            [
                                'jns_dokumen' => 'STR',
                                'format' => ['pdf'],
                                'keterangan' => '<span class="text-warning">Nakes wajib upload</span>'
                            ]

                        ];



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
                                              <div class="fw-bold fs-5 pt-2">DIKLAT/PELATIHAN</div> <br>
                                                  <?php

                                                        if($upload_status==250){
                                                            echo '<div class="alert alert-danger">'.$upload_message.'</div>';
                                                        }
                                              ?>



                                                <!-- Tombol untuk buka modal -->
                                                    <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalKeluarga">
                                                        Input Pelatihan
                                                    </button>

                                                    <table class="table">
                                                          <thead class="ltr:text-left rtl:text-right">
                                                              <tr>
                                                                  <th class="text-center">No</th>
                                                                  <th class="text-center">Jenis Diklat</th>
                                                                  <th class="text-start">Nama/judul diklat</th>
                                                                  <th class="text-center">Lokasi</th>
                                                                  <th class="text-center">Waktu</th>
                                                                  <th class="text-center">File</th>
                                                                  <th class="text-center">Action</th>
                                                              </tr>
                                                          </thead>


                                                          <tbody>
                                                          <?php
                                                              for ($s=0; $s < count($pelatihan) ; $s++) {
                                                                      $id = $pelatihan[$s]->id;

                                                                  echo '
                                                                          <tr>
                                                                          <td  class="text-center">

                                                                          </td>
                                                                          <td  class="text-center">'.$pelatihan[$s]->jns_pelatihan.'</td>
                                                                          <td  class="text-start"> '.word_limiter($pelatihan[$s]->judul_pelatihan, 10).'</td>
                                                                          <td class="text-start">'.$pelatihan[$s]->lokasi_diklat.'</td>
                                                                          <td class="text-center">'.format_view($pelatihan[$s]->tgl_mulai).' s/d '.format_view($pelatihan[$s]->tgl_selesai).'</td>

                                                                          <td class="text-center">
                                                                                <a href="'.base_url().'uploads/diklat/'.$pelatihan[$s]->surtug_sertifikat.'" class="btn btn-light btn-xs" target="_blank">
                                                                                Lihat
                                                                                </a>
                                                                          </td>
                                                                          <td>
                                                                                <a href="'.base_url().'profile/edit_pelatihan/'.$pelatihan[$s]->id.'" class="btn btn-success btn-xs">
                                                                                    Edit
                                                                                </a>
                                                                                <button class="btn btn-xs btn-danger btnHapusDokumen" data-id="'.$pelatihan[$s]->id.'" data-file="'.$pelatihan[$s]->surtug_sertifikat.'">
                                                                                    Hapus
                                                                                </button>
                                                                          </td>
                                                                          </tr>  ';
                                                              }

                                                          ?>

                                                          </tbody>
                                                   </table>

                                                     <!-- Modal Form Input Keluarga -->
                                                    <div class="modal fade" id="modalKeluarga" tabindex="-1" aria-labelledby="modalKeluargaLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                             <form id="formUploadDokumen" enctype="multipart/form-data" method="POST" action="<?= base_url('profile/input_diklat') ?>">
                                                                <!-- Dalam form modal -->
                                                                <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">

                                                                <div class="modal-header">
                                                                 <h5 class="modal-title">   Input Pelatihan/ Diklat</h5>
                                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div class="mb-3">
                                                                         <label for="message-text" class="control-label">Judul / Nama Pelatihan:</label>
                                                                         <input type="text" name="judul" required autocomplete="off" class="form-control" >
                                                                     </div>

                                                                     <div class="row">
                                                                         <div class="col-md-6">
                                                                             <div class="mb-3">
                                                                                 <label for="recipient-name" class="control-label">Tanggal Mulai:</label>
                                                                                 <input type="date" required name="tanggal_mulai" autocomplete="off" class="form-control" id="dpd1" >
                                                                             </div>
                                                                         </div>
                                                                         <div class="col-md-6">
                                                                         <div class="mb-3">
                                                                                 <label for="recipient-name" class="control-label">Tanggal Selesai:</label>
                                                                                 <input type="date" name="tanggal_selesai" autocomplete="off" class="form-control" id="dpd2" >
                                                                             </div>
                                                                         </div>
                                                                     </div>

                                                                     <div class="mb-3">
                                                                         <label for="recipient-name" class="control-label">Jenis Diklat:</label>
                                                                         <select name="jns_diklat" id="jns_diklat"  class="form-control">
                                                                             <?php
                                                                                 for ($d=0; $d < count($arayJenis) ; $d++) {
                                                                                     $jns_diklat = trim($arayJenis[$d]);


                                                                                     echo '<option value="'.$jns_diklat.'">'.$jns_diklat .'</option>';

                                                                                 }
                                                                             ?>
                                                                         </select>
                                                                      </div>


                                                                      <div class="mb-3">
                                                                         <label for="message-text" class="control-label">Lokasi/Tempat Pelatihan:</label>
                                                                         <input type="text" name="lokasi" required autocomplete="off" class="form-control" >
                                                                     </div>



                                                                        <div class="mb-3">
                                                                            <label for="file_dokumen" class="form-label">Dokumen Sertifikat/Surat Tugas (.pdf)</label>
                                                                            <input type="file" class="form-control" name="filedocs" id="file_dokumen" accept=".pdf" required>
                                                                            <small class="form-text text-muted">Ukuran maksimal file 2MB</small>
                                                                        </div>


                                                                </div>
                                                                <div class="modal-footer">
                                                                <div class="loader d-none text-success">Menyimpan...</div>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-primary">Simpan</button>
                                                                </div>
                                                            </form>
                                                            </div>
                                                        </div>
                                                    </div>



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

        <script>
            $(document).on('click', '.btnHapusDokumen', function () {
                const id = $(this).data('id');
                const file = $(this).data('file');

                if (confirm('Yakin ingin menghapus dokumen ini?')) {
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url("profile/hapus_diklat") ?>',
                        data: { id: id, file: file },
                        success: function (res) {
                            alert('Data Pelatihan /  diklat berhasil dihapus.');
                            loadDokumen(); // fungsi untuk reload tabel dokumen
                        },
                        error: function () {
                            alert('Terjadi kesalahan saat menghapus dokumen.');
                        }
                    });
                }
            });

          </script>


    </body>
</html>
