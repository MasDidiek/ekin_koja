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


                            $dataGajiPegawai    = $this->Pegawai_model->getDataGajiPegawai($nip, $tahun);


                             if(!empty($dataGajiPegawai)){

                                $gaji_pokok = $dataGajiPegawai[0]->gaji_pokok;
                                $pengkalian = $dataGajiPegawai[0]->pengali;
                                $tkd_pokok = $gaji_pokok*$pengkalian;
                                $id_gaji   =  $dataGajiPegawai[0]->id;

                            }else{
                                $gaji_pokok= 0;
                                $pengkalian = 0;
                                $tkd_pokok =  0;
                                $id_gaji   = 0;
                            }

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
                                              <div class="fw-bold fs-5 pt-2">DATA KELUARGA</div> <br>

                                                <!-- Tombol untuk buka modal -->
                                                    <button class="btn btn-info btn-sm float-end" data-bs-toggle="modal" data-bs-target="#modalKeluarga">
                                                    Tambah Data Keluarga
                                                    </button>


                                                    <table class="table table-bordered table-sm mt-4" id="tabel-keluarga">
                                                        <thead>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Nama</th>
                                                                 <th>Hubungan</th>
                                                                <th>Tgl Lahir</th>
                                                                <th>L/P</th>
                                                                <th>Pekerjaan</th>
                                                                <th>Pendidikan</th>
                                                                <th>Alamat</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <!-- data akan dimasukkan di sini lewat JS -->

                                                        </tbody>
                                                        </table>


                                                    <!-- Modal Form Input Keluarga -->
                                                    <div class="modal fade" id="modalKeluarga" tabindex="-1" aria-labelledby="modalKeluargaLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                            <form id="formKeluarga" action="<?= base_url('profile/simpan_data_keluarga') ?>">
                                                                <!-- Dalam form modal -->
                                                                <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">

                                                                <div class="modal-header">
                                                                <h5 class="modal-title">Input Data Keluarga</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                <div class="mb-2">
                                                                    <label>Hubungan Keluarga</label>
                                                                    <select class="form-select" name="status_anggota">
                                                                            <option value="">-- Hubungan Keluarga --</option>
                                                                            <option value="1">Orang Tua</option>
                                                                            <option value="2">Saudara Kandung</option>
                                                                            <option value="3">Suami/Istri</option>
                                                                            <option value="4">Anak</option>

                                                                        </select>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label>Nama</label>
                                                                    <input type="text" name="nama" class="form-control" required>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <div class="mb-2">
                                                                            <label>Tanggal Lahir</label>
                                                                            <input type="date" name="tgl_lahir" class="form-control" required>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <div class="mb-2">
                                                                            <label>Jenis Kelamin</label>
                                                                            <select name="jns" class="form-select" required>
                                                                            <option value="">-- Pilih --</option>
                                                                            <option value="Laki-laki">Laki-laki</option>
                                                                            <option value="Perempuan">Perempuan</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-2">
                                                                    <label>Pekerjaan</label>
                                                                    <input type="text" name="pekerjaan" class="form-control" required placeholder="cth: Karyawan swasta, Polri, Dokter">
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label>Pendidikan</label>
                                                                    <select class="form-select" name="pendidikan">
                                                                            <option value="">-- Pendidikan --</option>
                                                                            <option value="0">Tidak Sekolah</option>
                                                                            <option value="1">Lulus SD</option>
                                                                            <option value="2">Lulus SMP </option>
                                                                            <option value="3">Lulus SMA</option>
                                                                            <option value="4">Lulus Perguruan Tinggi</option>

                                                                        </select>
                                                                </div>
                                                                <div class="mb-2">
                                                                    <label>Alamat</label>
                                                                    <textarea name="alamat" class="form-control" rows="2"></textarea>
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


                        <div class="modal fade" id="modalEditKeluarga" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <form id="formEditKeluarga" action="<?= base_url('profile/update_keluarga') ?>">
                                        <div class="modal-header">
                                        <h5 class="modal-title">Edit Data Keluarga</h5>
                                        </div>
                                        <div class="modal-body">
                                        <input type="hidden" name="id" id="edit_id">
                                        <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ?>">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-2">
                                                    <label>Nama</label>
                                                    <input type="text" name="nama" class="form-control" id="edit_nama">
                                                </div>
                                            </div>
                                             <div class="col-6">

                                                <div class="mb-2">
                                                    <label>Tanggal Lahir</label>
                                                    <input type="date" name="tgl_lahir" class="form-control" id="edit_tgl_lahir">
                                                </div>
                                            </div>
                                             <div class="col-6">
                                                 <div class="mb-2">
                                                    <label>Jenis Kelamin</label>
                                                    <select name="jns_kelamin" class="form-control" id="edit_jns_kelamin">
                                                    <option value="L">Laki-laki</option>
                                                    <option value="P">Perempuan</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="col-6">
                                                 <div class="mb-2">
                                                    <label>Hubungan Keluarga</label>
                                                    <select name="status_anggota" class="form-control" id="edit_status_anggota">
                                                    <option value="1">Orang Tua</option>
                                                    <option value="2">Saudara Kandung</option>
                                                    <option value="3">Pasangan</option>
                                                    <option value="4">Anak</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="col-6">
                                                  <div class="mb-2">
                                                    <label>Pendidikan</label>
                                                    <select name="pendidikan" class="form-control" id="edit_pendidikan">
                                                    <option value="0">Tidak Sekolah</option>
                                                    <option value="1">Lulus SD</option>
                                                    <option value="2">Lulus SMP</option>
                                                    <option value="3">Lulus SMA</option>
                                                    <option value="4">Diploma</option>
                                                    <option value="5">Sarjana (S1)</option>
                                                    <option value="6">Magister (S2)</option>
                                                    <option value="7">Doktor (S3)</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="col-6">

                                                    <div class="mb-2">
                                                        <label>Pekerjaan</label>
                                                        <input type="text" name="pekerjaan" class="form-control" id="edit_pekerjaan">
                                                    </div>
                                            </div>
                                             <div class="col-6">
                                                 <div class="mb-2">
                                                    <label>Alamat</label>
                                                    <textarea name="alamat" class="form-control" id="edit_alamat"></textarea>
                                                </div>
                                            </div>
                                        </div>





                                        </div>
                                        <div class="modal-footer">
                                        <button class="btn btn-primary">Simpan Perubahan</button>
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
                $(document).ready(function() {
                    const idPegawai = $('input[name="id_pegawai"]').val();

                    // fungsi untuk reload data keluarga dari server
                    function loadKeluarga() {
                        $.get('<?= base_url('profile/get_keluarga_by_pegawai/') ?>' + idPegawai, function(data) {
                        const keluarga = JSON.parse(data);
                        let html = '';

                        // mapping status hubungan keluarga
                            const hubunganMap = {
                                1: 'Orang Tua',
                                2: 'Saudara ',
                                3: 'Suami/istri',
                                4: 'Anak',
                                5: 'Kerabat Lain'
                            };

                            // mapping pendidikan
                            const pendidikanMap = {
                                0: 'Tidak Sekolah',
                                1: 'Lulus SD',
                                2: 'Lulus SMP',
                                3: 'Lulus SMA',
                                4: 'Diploma',
                                5: 'Sarjana (S1)',
                                6: 'Magister (S2)',
                                7: 'Doktor (S3)'
                            };

                            // mapping jenis kelamin (jika singkatan)
                            const jkMap = {
                                'L': 'Laki-laki',
                                'P': 'Perempuan'
                            };

                        keluarga.forEach((row, index) => {
                            const hubungan = hubunganMap[row.status_anggota] ?? 'Lainnya';
                            const pendidikan = pendidikanMap[row.pendidikan] ?? '-';
                            const jk = jkMap[row.jns_kelamin] ?? row.jns_kelamin;

                            html += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.nama}</td>
                                <td>${hubungan}</td>
                                <td class="text-center">${row.tgl_lahir}</td>
                                <td class="text-center">${row.jns_kelamin}</td>
                                <td>${row.pekerjaan}</td>
                                <td>${pendidikan}</td>
                                <td>${row.alamat}</td>
                                <td>
                                    <button class="btn btn-xs btn-success btnEditKeluarga" data-id="${row.id}">Edit</button>
                                    <button class="btn btn-xs btn-danger btnDeleteKeluarga" data-id="${row.id}">Hapus</button>
                                </td>
                            </tr>`;
                        });

                        $('#tabel-keluarga tbody').html(html);
                        });
                    }

                    // pertama kali load
                    loadKeluarga();

                    // form submit
                        $('#formKeluarga').submit(function(e) {
                            e.preventDefault();
                            var form = $(this);
                            var actionUrl = form.attr('action');
                            var formData = form.serialize();

                            $('.loader').removeClass('d-none').text("Menyimpan data...");

                            $.post(actionUrl, formData, function(response) {
                            $('.loader').text("✅ Data berhasil disimpan!");
                            form[0].reset();

                            // Reload table keluarga dari database
                            loadKeluarga();

                            setTimeout(() => {
                                $('#modalKeluarga').modal('hide');
                                $('.loader').addClass('d-none');
                            }, 1000);
                            }).fail(function() {
                            $('.loader').text("❌ Gagal menyimpan data");
                            });
                        });


                                                // TOMBOL EDIT
                        $(document).on('click', '.btnEditKeluarga', function () {
                        const id = $(this).data('id');

                        $.get('<?= base_url('profile/get_keluarga_by_id/') ?>' + id, function (data) {
                            const keluarga = JSON.parse(data);

                            $('#edit_id').val(keluarga.id);
                            $('#edit_nama').val(keluarga.nama);
                            $('#edit_tgl_lahir').val(keluarga.tgl_lahir);
                            $('#edit_jns_kelamin').val(keluarga.jns_kelamin);
                            $('#edit_status_anggota').val(keluarga.status_anggota);
                            $('#edit_pendidikan').val(keluarga.pendidikan);
                            $('#edit_pekerjaan').val(keluarga.pekerjaan);
                            $('#edit_alamat').val(keluarga.alamat);

                            $('#modalEditKeluarga').modal('show');
                        });
                        });

                        // SUBMIT FORM EDIT
                        $('#formEditKeluarga').submit(function (e) {
                        e.preventDefault();
                        const formData = $(this).serialize();

                        $.post($(this).attr('action'), formData, function (res) {
                            $('#modalEditKeluarga').modal('hide');
                            loadKeluarga();
                        });
                        });

                        // DELETE
                        $(document).on('click', '.btnDeleteKeluarga', function () {
                        const id = $(this).data('id');
                        if (confirm('Yakin ingin menghapus data ini?')) {
                            $.post('<?= base_url('profile/delete_keluarga') ?>', { id }, function (res) {
                            loadKeluarga();
                            });
                        }
                        });


                });





                </script>

    </body>
</html>
