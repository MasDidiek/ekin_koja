<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">


  <style>

    .alert-danger{
      color: darkred;
    }
    
    .alert-success{
      color: green;
    }

     .bg-danger {
      background-color: #F95959 !important;
    } 

    .btn-white{
       background-color: #F8F8F8 !important;
       color:slategray
    }

    .bg-success-light{
       background-color: #ECFFF4FF !important;
       color:green
    }

    .btn-info{
          background-color: #4BA9E3FF !important;
           color:white;
           border: 1px solid  #4BA9E3FF !important;
        
    }
    .badge{
        font-size:12px;
    }
    
  </style>
</head>

<body>
  <!--  Body Wrapper -->
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


      <?php

    
      $success = $this->session->flashdata('success');
      $error = $this->session->flashdata('error');


     // print_array($pengajuan);

      ?>

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Absensi Pegawai</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="<?php echo base_url(); ?>admin/dashboard/index">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Pengajuan Izin - Sakit</li>

                    </ol>
                  </nav>
                </div>

              </div>
            </div>
          </div>

            
                <?php if ($success != '') { ?>
                  <div class="alert alert-success">
                    <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?php echo  $success; ?>
                  </div>
                <?php }  ?>

                   <?php if ($error != '') { ?>
                  <div class="alert alert-danger">
                    <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?php echo  $error; ?>
                  </div>
                <?php }  ?>
          <div class="card shadow position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">

              <div class="row g-3 align-items-end mt-1">
                <div class="col-md-4">
                  <label for="filter_status_pengajuan" class="form-label">Filter Status</label>
                  <select id="filter_status_pengajuan" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="0">Belum diperiksa</option>
                    <option value="1">Disetujui</option>
                    <option value="2">Ditolak</option>
                  </select>
                </div>
                <div class="col-md-5">
                  <label for="cari_nama_pengaju" class="form-label">Cari Nama Pegawai</label>
                  <input type="search" id="cari_nama_pengaju" class="form-control" placeholder="Ketik nama pegawai...">
                </div>
                <div class="col-md-3">
                  <button type="button" id="reset_filter_pengajuan" class="btn btn-light w-100">Reset Filter</button>
                </div>
              </div>

              <div class="table-responsive mt-4">
                <div class="clearfix"></div>

                <table id="tabel_pengajuan_izin_sakit" class="table table-bordered table-hover align-middle mt-2">
                  <thead class="table-light">
                    <tr class="text-center">
                      <th>No.</th>
                      <th>Nama Pegawai</th>
                      <th>Tanggal</th>
                      <th>Jenis Pengajuan</th>
                    
                      <th>Keterangan</th>
                      <th>Status</th>
                      <th>Lampiran</th>
                      <th width="200">Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($pengajuan)) : ?>
                      <?php $no = 1; ?>
                      <?php foreach ($pengajuan as $item) : ?>
                        <?php
                          $jenisAbsen = strtoupper((string) $item->jenis_absen);
                          if ($jenisAbsen === 'IZIN') {
                                $jenis_izin = $item->jns_izin;
                                  $rincian = 'Izin '.$jenis_izin;
                          } else {
                             $jenis_sakit = $item->jns_sakit;
                             $rincian = 'Sakit '.$jenis_sakit;
                          }
                        ?>
                        <tr class="baris-pengajuan" data-status="<?= (int) $item->status ?>">
                          <td class="text-center"><?= $no++ ?></td>
                          <td><?= html_escape($item->nama) ?></td>
                          <td class="text-center"><?= html_escape(format_semi($item->tanggal)) ?></td>
                          <td class="text-center">
                            <span class="badge <?= $jenisAbsen === 'IZIN' ? 'bg-warning-subtle text-warning' : 'bg-info-subtle text-info' ?>">
                              <?= html_escape($jenisAbsen) ?>
                             </span> <br>
                            <span class="text-muted"> <?= html_escape($rincian) ?> </span> </td>
                          <td><?= nl2br(html_escape($item->keterangan)) ?></td>
                          <td class="text-center status-pengajuan">
                            <?php if ((int) $item->status === 1) : ?>
                              <span class="badge bg-success-subtle text-success">Disetujui</span>
                            <?php elseif ((int) $item->status === 2) : ?>
                              <span class="badge bg-danger-subtle text-danger">Ditolak</span>
                            <?php else : ?>
                              <span class="badge bg-warning-subtle text-warning">Belum diperiksa</span>
                            <?php endif; ?>
                          </td>
                          <td class="text-center">


                            <?php if (!empty($item->file_image)) : ?>
                              <a
                                href="<?= html_escape(base_url('uploads/surat_izin/' . rawurlencode($item->file_image))) ?>"
                                class="btn btn-sm bg-info-subtle text-info"
                                target="_blank"
                                rel="noopener"
                              >
                                <i class="fas fa-file-alt"></i> Lihat
                              </a>
                            <?php else : ?>
                              <span class="text-muted">Tidak ada</span>
                            <?php endif; ?>
                          </td>

                          <td class="text-center">
                            <?php if ((int) $item->status === 0) : ?>
                            <button
                              type="button"
                              class="btn btn-sm btn-primary edit-pengajuan"
                              data-id="<?= (int) $item->id ?>"
                              data-tanggal="<?= html_escape($item->tanggal) ?>"
                              data-jenis="<?= html_escape($jenisAbsen) ?>"
                              data-jenis-izin="<?= isset($item->jns_izin) ? (int) $item->jns_izin : '' ?>"
                              data-jenis-sakit="<?= isset($item->jns_sakit) ? (int) $item->jns_sakit : '' ?>"
                              data-keterangan="<?= html_escape($item->keterangan) ?>"
                              data-bs-toggle="modal"
                              data-bs-target="#modalEditPengajuan"
                            >Ubah</button>
                            <button
                              type="button"
                              class="btn btn-sm btn-info approval-pengajuan"
                              data-id="<?= (int) $item->id ?>"
                              data-pegawai="<?= html_escape($item->nama) ?>"
                              data-tanggal="<?= html_escape($item->tanggal) ?>"
                              data-jenis="<?= html_escape($jenisAbsen) ?>"
                              data-bs-toggle="modal"
                              data-bs-target="#modalApprovalPengajuan"
                            >Approval</button>
                            <?php else : ?>
                              <span class="text-muted">-</span>
                            <?php endif; ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else : ?>
                      <tr class="empty-pengajuan">
                        <td colspan="8" class="text-center text-muted">Tidak ada pengajuan izin atau sakit.</td>
                      </tr>
                    <?php endif; ?>
                    <tr id="hasil_filter_kosong" style="display: none;">
                      <td colspan="8" class="text-center text-muted">Tidak ada pengajuan yang sesuai dengan filter.</td>
                    </tr>
                  </tbody>
                </table>
              </div>

            </div>
          </div>

          <div class="modal fade" id="modalEditPengajuan" tabindex="-1" aria-labelledby="modalEditPengajuanLabel" aria-hidden="true">
            <div class="modal-dialog">
              <form method="post" action="<?= site_url('admin/absensi/update_pengajuan_izin_sakit') ?>">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalEditPengajuanLabel">Ubah Pengajuan Izin / Sakit</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" id="edit_pengajuan_id">
                    <div class="mb-3">
                      <label for="edit_tanggal" class="form-label">Tanggal</label>
                      <input type="date" class="form-control" name="tanggal" id="edit_tanggal" required>
                    </div>
                    <div class="mb-3">
                      <label for="edit_jenis" class="form-label">Jenis Pengajuan</label>
                      <select class="form-select" name="jenis_absen" id="edit_jenis" required>
                        <option value="IZIN">IZIN</option>
                        <option value="SAKIT">SAKIT</option>
                      </select>
                    </div>

                    <div class="mb-3 d-none" id="form_jenis_izin">
                      <label for="edit_jenis_izin" class="form-label">Jenis Izin</label>
                      <select class="form-select" name="jns_izin" id="edit_jenis_izin" disabled>
                            <option value="">-- Pilih jenis izin --</option>
                            <option value="penuh">Izin penuh</option>
                            <option value="awal">Izin awal</option>
                            <option value="akhir">Izin akhir</option>
                      </select>
                    </div>
                     <div class="mb-3  d-none" id="form_jenis_sakit">
                      <label for="edit_jenis_sakit" class="form-label">Jenis Sakit</label>
                      <select class="form-select" name="jns_sakit" id="edit_jenis_sakit" disabled>
                            <option value="">-- Pilih jenis sakit --</option>
                            <option value="tanpa_surat">Tanpa surat keterangan</option>
                            <option value="dgn_surat">Dengan surat keterangan</option>
                      </select>
                    </div>


                    <div class="mb-3">
                      <label for="edit_keterangan" class="form-label">Keterangan</label>
                      <textarea class="form-control" name="keterangan" id="edit_keterangan" rows="4" maxlength="200" required></textarea>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <div class="modal fade" id="modalApprovalPengajuan" tabindex="-1" aria-labelledby="modalApprovalPengajuanLabel" aria-hidden="true">
            <div class="modal-dialog">
              <form method="post" action="<?= site_url('admin/absensi/approval_pengajuan_izin_sakit') ?>">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="modalApprovalPengajuanLabel">Approval Pengajuan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                  </div>
                  <div class="modal-body">
                    <input type="hidden" name="id" id="approval_pengajuan_id">
                    <p class="mb-3">
                      Pegawai: <strong id="approval_nama_pegawai"></strong><br>
                      Tanggal: <strong id="approval_tanggal"></strong><br>
                      Jenis: <strong id="approval_jenis"></strong>
                    </p>
                    <div class="mb-3">
                      <label for="approval_status" class="form-label">Keputusan</label>
                      <select class="form-select" name="status" id="approval_status" required>
                        <option value="">-- Pilih keputusan --</option>
                        <option value="1">Setujui</option>
                        <option value="2">Tolak</option>
                      </select>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Approval</button>
                  </div>
                </div>
              </form>
            </div>
          </div>

          <script>
            function handleColorTheme(e) {
              $("html").attr("data-color-theme", e);
              $(e).prop("checked", !0);
            }
          </script>

          <?php $this->load->view('layout/section/theme-setting.php'); ?>

          <?php $this->load->view('master/request-cuti.php'); ?>

        </div>
        <div class="dark-transparent sidebartoggler"></div>
        <!-- Import Js Files -->

        <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
        <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
        <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

        <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>
        <script>
          $(function() {
            function filterPengajuan() {
              var status = $('#filter_status_pengajuan').val();
              var nama = $.trim($('#cari_nama_pengaju').val()).toLocaleLowerCase();
              var terlihat = 0;

              $('#tabel_pengajuan_izin_sakit .baris-pengajuan').each(function() {
                var $row = $(this);
                var statusSesuai = !status || $row.attr('data-status') === status;
                var namaPegawai = $row.children('td').eq(1).text().toLocaleLowerCase();
                var namaSesuai = !nama || namaPegawai.indexOf(nama) !== -1;
                var tampil = statusSesuai && namaSesuai;

                $row.toggle(tampil);
                if (tampil) {
                  terlihat++;
                }
              });

              $('#hasil_filter_kosong').toggle(
                $('#tabel_pengajuan_izin_sakit .baris-pengajuan').length > 0 && terlihat === 0
              );
            }

            $('#filter_status_pengajuan, #cari_nama_pengaju').on('input change', filterPengajuan);
            $('#reset_filter_pengajuan').on('click', function() {
              $('#filter_status_pengajuan').val('');
              $('#cari_nama_pengaju').val('');
              filterPengajuan();
            });

            $('.edit-pengajuan').on('click', function() {
              var $button = $(this);
              $('#edit_pengajuan_id').val($button.attr('data-id'));
              $('#edit_tanggal').val($button.attr('data-tanggal'));
              $('#edit_jenis').val($button.attr('data-jenis'));
              $('#edit_jenis_izin').val($button.attr('data-jenis-izin'));
              $('#edit_jenis_sakit').val($button.attr('data-jenis-sakit'));
              $('#edit_keterangan').val($button.attr('data-keterangan'));
              toggleJenisPengajuan();
            });

            $('#edit_jenis').on('change', toggleJenisPengajuan);

            function toggleJenisPengajuan() {
              var jenis = $('#edit_jenis').val();
              var isIzin = jenis === 'IZIN';
              var isSakit = jenis === 'SAKIT';

              $('#form_jenis_izin').toggleClass('d-none', !isIzin);
              $('#edit_jenis_izin').prop('disabled', !isIzin).prop('required', isIzin);
              $('#form_jenis_sakit').toggleClass('d-none', !isSakit);
              $('#edit_jenis_sakit').prop('disabled', !isSakit).prop('required', isSakit);
            }

            $('.approval-pengajuan').on('click', function() {
              var $button = $(this);
              $('#approval_pengajuan_id').val($button.attr('data-id'));
              $('#approval_nama_pegawai').text($button.attr('data-pegawai'));
              $('#approval_tanggal').text($button.attr('data-tanggal'));
              $('#approval_jenis').text($button.attr('data-jenis'));
              $('#approval_status').val('');
            });
          });
        </script>


</body>




<script>
  <?php if ($message != '') { ?>
    $(document).ready(function() {
      showSnackbar('success', 'Berhasil!', '<?= $message; ?>');
    });

    <?php } ?>closeSnackbar


    let snackbarTimeout;

    function showSnackbar(type, title, message) {
      const snackbar = document.getElementById("snackbar");
      const icon = document.getElementById("snackbar-icon");
      const titleEl = document.getElementById("snackbar-title");
      const messageEl = document.getElementById("snackbar-message");

      // Bersihkan sisa timeout dan class tipe sebelumnya jika ada
      clearTimeout(snackbarTimeout);
      snackbar.classList.remove("show", "success", "error", "warning");

      // Suntik isi konten secara dinamis
      titleEl.innerText = title;
      messageEl.innerText = message;

      // Setel ikon dan kelas CSS berdasarkan tipenya
      if (type === "success") {
        icon.innerHTML = "✓";
        snackbar.classList.add("success");
      } else if (type === "error") {
        icon.innerHTML = "✕";
        snackbar.classList.add("error");
      } else if (type === "warning") {
        icon.innerHTML = "⚠";
        snackbar.classList.add("warning");
      }

      // Picu animasi muncul
      setTimeout(() => {
        snackbar.classList.add("show");
      }, 10);

      // Otomatis tutup setelah 4 detik
      snackbarTimeout = setTimeout(function() {
        snackbar.classList.remove("show");
      }, 4000);
    }

    function closeSnackbar() {
      const snackbar = document.getElementById("snackbar");
      snackbar.classList.remove("show");
      clearTimeout(snackbarTimeout);
    }
   
</script>

</html>