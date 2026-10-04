<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <!-- CSS Select2 -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

  <!-- Opsional: Tema Bootstrap 4/5 agar tampilan Select2 cocok dengan Bootstrap Anda -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css">
  <style>
    .datepicker {
      z-index: 1999;
    }


    .alert-danger {
      color: #F04444;
      background: #FFF8F8 !important;
    }
  </style>
</head>

<body>


  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <!-- ---------------------------------- -->

        <?php $this->load->view('layout/section/sidebar'); ?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header'); ?>
      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Pengajuan Cuti</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="<?php echo base_url(); ?>dashboard/index">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Pengajuan Cuti</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">
                  <div class="text-center mb-n5">

                  </div>
                </div>
              </div>


            </div>
          </div>


          <?php
          $id_pegawai = $this->session->userdata('id_pegawai');
          $jns_cuti      =  $this->session->userdata('jns_cuti');
          $tgl_mulai     =  $this->session->userdata('tgl_mulai');
          $tgl_akhir     =  $this->session->userdata('tgl_akhir');
          $id_pengganti  =  $this->session->userdata('id_pengganti');
          $alasan_cuti   =  $this->session->userdata('alasan_cuti');
          $tlp           =  $this->session->userdata('no_tlp');
          $alamat        =  $this->session->userdata('alamat');
          $delegasi_tugas        =  $this->session->userdata('delegasi_tugas');
          $lama_cuti        =  $this->session->userdata('lama_cuti');

          $error = $this->session->flashdata('error');
          //echo $message;
          $jabatan =  $detail_pegawai[0]->jabatan;
          $puskesmas =  $detail_pegawai[0]->puskesmas;

          $id_jabatan =  $detail_pegawai[0]->id_jabatan;


          if ($sisa_cuti_bersama) {
            $sisaCuber = $sisa_cuti_bersama->hak_total - $sisa_cuti_bersama->hak_terpakai - $sisa_cuti_bersama->hak_reserved;
          }



          $listPegawaiPengganti = $this->Cuti_model->getListPegawaiPenggantiCuti($id_pegawai, $id_jabatan);
          $sisaTahun2025 = $rekap_hak_cuti['2025']['sisa'];
          $sisaTahun2026 = $rekap_hak_cuti['2026']['sisa'];

          $sisa2025 = (int) $sisaTahun2025;
          $sisa2026 = (int) $sisaTahun2026;

          // default
          $checked2025 = '';
          $checked2026 = '';
          $disabled2025 = '';
          $disabled2026 = '';

          // logic disabled
          if ($sisa2025 <= 0) {
            $disabled2025 = 'disabled';
          }
          if ($sisa2026 <= 0) {
            $disabled2026 = 'disabled';
          }

          // logic auto checked
          if ($sisa2025 > 0 && $sisa2026 <= 0) {
            $checked2025 = 'checked';
          } elseif ($sisa2026 > 0 && $sisa2025 <= 0) {
            $checked2026 = 'checked';
          }

          ?>


          <div class="card">

            <?php if ($error != '') {
              echo '<div class="alert alert-danger">' . $error . '</div>';
            } ?>
            <div class="card-body">
              <h5>Form Pengajuan Cuti</h5>
              <form method="post" action="<?php echo base_url(); ?>cuti/simpan_pengajuan_cuti" enctype="multipart/form-data">
                <div class="row">
                  <div class="col-md-6 mt-3">
                    <div class="mb-3">
                      <label for="" class="form-label"> Jenis Cuti: </label>
                      <select name="jns_cuti" id="jns_cuti" class="form-control">
                        <?php
                        for ($c = 0; $c < count($master_cuti); $c++) {
                          $id = $master_cuti[$c]->id;
                          $jenis_cuti = $master_cuti[$c]->jenis_cuti;
                          echo '<option value="' . $id . '">' . $jenis_cuti . '</option>';
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-6 col-6 mt-3">
                    <div class="mb-3">
                      <label for="" class="form-label">Tanggal Mulai: </label>
                      <input type="text" required name="tgl_mulai" autocomplete="off" class="form-control" value="<?php echo $tgl_mulai; ?>" id="tgl_mulai">
                    </div>
                  </div>
                  <div class="col-md-3 col-sm-6 col-6 mt-3">
                    <div class="mb-3">
                      <label for="" class="form-label"> Tanggal Akhir: </label>
                      <input type="text" required name="tgl_akhir" autocomplete="off" class="form-control" value="<?php echo $tgl_akhir; ?>" id="tgl_akhir">
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-6 col-6 mt-3">

                    <!-- Jumlah Hari -->
                    <div class="mb-3">
                      <label class="form-label">Jumlah Hari Cuti</label>
                      <div class="input-group" style="max-width:200px;">
                        <input type="text" name="jumlah_hari_cuti" id="jumlah_hari_cuti" value="<?= $lama_cuti; ?>" class="form-control bg-white" readonly>
                        <span class="input-group-text titel_hari">hari</span>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-6 col-6 mt-3">
                    <!-- Hak Cuti -->
                    <div class="mb-3">
                      <label class="form-label">Hak Cuti yang Digunakan</label>
                      <select name="hak_cuti" id="hak_cuti" class="form-control">
                        <option value="2025">2025 &nbsp; (<?= $sisa2025; ?> hari)</option>
                        <option value="2026">2026 &nbsp; (<?= $sisa2026; ?> hari)</option>
                        <?php if ($sisa_cuti_bersama) : ?>
                          <option value="cuti_bersama">Cuti Bersama &nbsp; (<?= $sisaCuber; ?> hari)</option>
                        <?php endif; ?>
                        <option value="lainnya">Lainnya (CAP, Sakit, Bersalin)</option>
                      </select>
                    </div>

                  </div>
                  <div class="col-md-6 col-sm-6 col-6 mt-3">

                    <!-- Pengganti Cuti -->
                    <div class="mb-3">
                      <label class="form-label">Pengganti Cuti</label>
                      <select class="form-control select2" name="id_pengganti" required>
                        <option value="">-- Pilih pengganti cuti --</option>
                        <?php if (!empty($listPegawaiPengganti)) : ?>
                          <?php foreach ($listPegawaiPengganti as $pegawai) : ?>
                            <?php $selected = ($pegawai->id_pegawai == $id_pengganti) ? 'selected' : ''; ?>
                            <option value="<?= $pegawai->id_pegawai; ?>" <?= $selected; ?>>
                              <?= $pegawai->nama; ?>
                            </option>
                          <?php endforeach; ?>
                        <?php endif; ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-6 col-12">
                    <div class="mb-4">
                      <label for="tlp" class="form-label">No Telepon / HP</label>
                      <input type="text" id="tlp" name="no_tlp" class="form-control" placeholder="08xxxx" value="<?php echo $tlp; ?>" required>
                    </div>
                  </div>
                  <div class="col-md-6 col-12">
                    <!-- Alasan -->
                    <div class="mb-3">
                      <label for="alasan_cuti" class="form-label">Alasan Cuti</label>
                      <textarea name="alasan_cuti" class="form-control" required id="alasan_cuti" rows="3"><?= $alasan_cuti; ?></textarea>
                    </div>

                  </div>

                  <div class="col-md-6 col-12">
                    <!-- Alasan -->
                    <div class="mb-3">
                      <label for="alamat" class="form-label">Alamat Selama Cuti</label>
                      <textarea name="alamat" class="form-control" required id="alamat" rows="3"><?= $alamat; ?></textarea>
                    </div>

                  </div>
                  <div class="col-md-6 col-12">
                    <!-- Alasan -->
                    <div class="mb-3">
                      <label for="delgeasi tugas" class="form-label">Delegasi Tugas</label>

                      <textarea name="delegasi_tugas" class="form-control" required min="50" id="delegasi_tugas" rows="3"><?= $delegasi_tugas; ?></textarea>
                      <span class="text-muted">Tuliskan pekerjaan-pekerjaan yang akan didelegasikan ke pengganti cuti minimal 3 tugas, beri tanda koma(,) sebagai pemisah</span>
                    </div>

                  </div>

                </div>
                <button type="submit" class="btn btn-primary float-end mt-4">Kirim Pengajuan Cuti</button>
              </form>

            </div>


          </div>
        </div>

        <?php $lock_cuti = 0; ?>

        <div class="py-6 px-6 text-center">
          <p class="mb-0 fs-4">Design and Developed by
            <a href="#" target="_blank" class="pe-1 text-primary text-decoration-underline">DhifaWebStudio</a>
          </p>
        </div>

        <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
        <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
        <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>dashboard.js"></script>


        <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>


        <!-- 2. JS Select2 -->
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <!-- Pastikan jQuery & Select2 CSS/JS sudah di-load di template Anda -->
        <script>
          $(document).ready(function() {
            $('.select2').select2({
              placeholder: "-- Pilih pengganti cuti --",
              allowClear: true,
              width: '100%' // Memastikan lebar sesuai kontainer form
            });
          });
        </script>

        <script>
          var lockCuti = <?php echo (int)$lock_cuti; ?>;
          var nowTemp = new Date();

          var now = new Date(
            nowTemp.getFullYear(),
            nowTemp.getMonth(),
            nowTemp.getDate(),
            0, 0, 0, 0
          );


          // ======================================================
          // TANGGAL MULAI
          // ======================================================

          var checkin = $('#tgl_mulai').datepicker({
            onRender: function(date) {

              // Jika fitur lock aktif
              if (lockCuti == 1) {

                // Tidak boleh memilih tanggal sebelum hari ini
                return date.valueOf() < now.valueOf() ?
                  'disabled' :
                  '';
              }

              // Jika lock tidak aktif
              return '';
            }

          }).on('changeDate', function(ev) {

            var tanggalMulai = new Date(ev.date);

            // Normalisasi jam supaya perbandingan tanggal aman
            tanggalMulai.setHours(0, 0, 0, 0);

            // Cek tanggal akhir yang sudah dipilih
            var tanggalAkhir = checkout.date;

            // Jika tanggal akhir belum ada
            // atau tanggal akhir lebih kecil dari tanggal mulai
            if (
              !tanggalAkhir ||
              tanggalAkhir.valueOf() < tanggalMulai.valueOf()
            ) {

              // Set tanggal akhir sama dengan tanggal mulai
              checkout.setValue(tanggalMulai);
              $("#jumlah_hari_cuti").val(1);
            }

            checkin.hide();

          }).data('datepicker');


          // ======================================================
          // TANGGAL AKHIR
          // ======================================================

          var checkout = $('#tgl_akhir').datepicker({

            onRender: function(date) {

              // Normalisasi tanggal yang sedang dirender
              var tanggal = new Date(date);
              tanggal.setHours(0, 0, 0, 0);

              // // 1. Tidak boleh sebelum hari ini
              // if (tanggal.valueOf() < now.valueOf()) {
              //   return 'disabled';
              // }

              // 2. Jika tanggal mulai sudah dipilih,
              //    tanggal akhir tidak boleh sebelum tanggal mulai
              // if (checkin && checkin.date) {

              //   var tanggalMulai = new Date(checkin.date);
              //   tanggalMulai.setHours(0, 0, 0, 0);

              //   if (tanggal.valueOf() < tanggalMulai.valueOf()) {
              //     return 'disabled';
              //   }
              // }

              return '';

            }

          }).on('changeDate', function(ev) {

            var tanggalMulai = checkin.date;
            var tanggalAkhir = ev.date;

            // Pengaman tambahan
            if (
              tanggalMulai &&
              tanggalAkhir.valueOf() < tanggalMulai.valueOf()
            ) {

              alert('Tanggal akhir tidak boleh lebih kecil dari tanggal mulai.');

              checkout.setValue(tanggalMulai);

              return;
            }

            checkout.hide();

            const tglMulai = $("#tgl_mulai").val();
            const tglAkhir = $("#tgl_akhir").val();

            hitungHariCuti(tglMulai, tglAkhir);

          }).data('datepicker');


          // ======================================================
          // HITUNG HARI CUTI
          // ======================================================

          function hitungHariCuti(tglMulai, tglAkhir) {

            const jenis = $("#jenis_jam_kerja").val();

            $.ajax({
              url: "<?php echo base_url("cuti/hitung"); ?>",
              type: "POST",

              data: {
                tgl_mulai: tglMulai,
                tgl_akhir: tglAkhir,
                jenis_jam_kerja: jenis
              },

              dataType: "json",

              success: function(response) {

                if (response.error) {

                  alert(response.error);
                  $("#jumlah_hari_cuti").val(0);

                } else {

                  $("#jumlah_hari_cuti").val(response.jumlah_hari);

                }
              },

              error: function() {

                alert("Terjadi kesalahan saat menghitung cuti.");
                $("#jumlah_hari_cuti").val(0);

              }
            });
          }
        </script>

</body>

</html>