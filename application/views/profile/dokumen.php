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
                                              <div class="fw-bold fs-5 pt-2">DOKUMEN</div> <br>
                                                  <?php

                                                        if($upload_status==250){
                                                            echo '<div class="alert alert-danger">'.$upload_message.'</div>';
                                                        }
                                              ?>

                                                <h5>Ketentuan Dokumen yang perlu diupload</h5>

                                                <div class="alert alert-info">

                                                    Ukuran File yang diizinkan maksimal<strong> 2MB.</strong>
                                                </div>
                                                <ol>


                                                <?php

                                                foreach ($dokumen_rules as $rule) {
                                                        echo " <li> <strong> {$rule['jns_dokumen']},   </strong> &nbsp; &nbsp; &nbsp;  Format File :  &nbsp; &nbsp;  <strong> " . implode(', ', $rule['format']) . " </strong>,  (  {$rule['keterangan']} ) </li>";
                                                    }
                                                ?>

                                                 </ol>

                                                 <hr>

                                                <!-- Tombol untuk buka modal -->
                                                    <button class="btn btn-primary btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalKeluarga">
                                                       Upload Dokumen
                                                    </button>


                                                        <table class="table">

                                                            <tr>
                                                                <th>Jenis Dokumen</th>
                                                                <th>File</th>
                                                                <th>Image</th>
                                                                <th>Action</th>
                                                            </tr>

                                                    <?php

                                                        foreach ($dokumen_rules as $rule) {
                                                            $jns_dokumen = $rule['jns_dokumen'];



                                                             $dokumen_pegawai  =  $this->Pegawai_model->getDokumenPegawai($nip, $jns_dokumen);

                                                             for ($i=0; $i < count($dokumen_pegawai) ; $i++) {
                                                               echo '<tr>
                                                                        <td>'. $jns_dokumen.'</td>
                                                                        <td>'.$dokumen_pegawai[$i]->nama_file.'</td>
                                                                        <td>
                                                                            <img src="'.base_url().'uploads/dokumen/'.$dokumen_pegawai[$i]->nama_file.'" alt="Dokumen" class="img-thumbnail">
                                                                        </td>
                                                                        <td>

                                                                            <a href="'.base_url().'uploads/dokumen/'.$dokumen_pegawai[$i]->nama_file.'" class="btn btn-sm btn-info" target="_blank">Lihat</a>
                                                                            <button class="btn btn-sm btn-danger btnHapusDokumen" data-id="'.$dokumen_pegawai[$i]->id.'" data-file="'.$dokumen_pegawai[$i]->nama_file.'">
                                                                                Hapus
                                                                            </button>
                                                                        </td>


                                                               </tr>';
                                                             }

                                                        }






                                                        ?>

                                                         </table>

                                                     <!-- Modal Form Input Keluarga -->
                                                    <div class="modal fade" id="modalKeluarga" tabindex="-1" aria-labelledby="modalKeluargaLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                             <form id="formUploadDokumen" enctype="multipart/form-data" method="POST" action="<?= base_url('profile/upload_dokumen') ?>">
                                                                <!-- Dalam form modal -->
                                                                <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">

                                                                <div class="modal-header">
                                                                 <h5 class="modal-title">Upload Dokumen</h5>
                                                                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body">

                                                                    <div class="mb-3">
                                                                        <label for="jenis_dokumen" class="form-label">Jenis Dokumen</label>
                                                                        <select class="form-select" name="jenis_dokumen" id="jenis_dokumen" required>
                                                                        <option value="">-- Pilih Dokumen --</option>

                                                                              <?php

                                                                            foreach ($dokumen_rules as $rule) {
                                                                                    echo '<option value="'.$rule['jns_dokumen'].'">'.$rule['jns_dokumen'].'</option>';
                                                                                }
                                                                            ?>


                                                                        </select>
                                                                    </div>


                                                                   <div class="mb-3">
                                                                        <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                                                                        <input type="text" name="keterangan" class="form-control" id="keterangan">
                                                                    </div>

                                                                        <div class="mb-3">
                                                                            <label for="file_dokumen" class="form-label">Pilih File (PDF/JPG/PNG)</label>
                                                                            <input type="file" class="form-control" name="imageupload" id="file_dokumen" accept=".pdf,.jpg,.jpeg,.png" required>
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
                          url: '<?= base_url("profile/hapus_dokumen") ?>',
                          data: { id: id, file: file },
                          success: function (res) {
                              alert('Dokumen berhasil dihapus.');
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
