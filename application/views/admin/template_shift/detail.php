<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/addon.css" media="screen">

  <style>
   .bg-danger-light {
      background-color: #ffebeb !important;
    } 
    
    
    .alert-danger{
      color: darkred;
    }
    
    .alert-success{
      color: green;
    }

        /* Gaya Utama untuk Tabel */
    .table-custom {
        width:100%;
        border-collapse: collapse; /* Menggabungkan border ganda menjadi satu garis */
        margin-bottom: 1rem;
        background-color: #ffffff;
        font-family: sans-serif;
        font-size: 14px;
        color: #333333;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05); /* Efek bayangan halus */
        border-radius: 8px;
        overflow: hidden; /* Memastikan sudut melengkung bekerja */
    }

    /* Mengatur Jarak Padding dan Garis Batas pada Sel */
    .table-custom th,
    .table-custom td {
        padding: 10px 15px;
        text-align: left;
        border: 1px solid #e0e0e0;
    }

    /* Gaya Khusus Bagian Kepala Tabel (Header) */
    .table-custom thead th {
        background-color: #4f46e5; /* Warna latar belakang modern (indigo) */
        color: #ffffff;             /* Warna teks putih */
        font-weight: 600;
        text-transform: uppercase;  /* Membuat teks kapital */
        font-size: 12px;
        letter-spacing: 0.5px;
    }

    /* Efek Hover saat Kursor Diarahkan ke Baris */
    .table-custom tbody tr:hover {
        background-color: #f1f5f9;
        transition: background-color 0.2s ease;
    }

  </style>
</head>

<body>
  <!-- <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome to Modernize</h5>
        <h6 class="text-white fs-2 mb-0">Easy to costomize the Template!!!</h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div> -->
  <!-- Preloader -->

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
      <!--  Header End -->


      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Shift Kerja Pegawai</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                       <a class="text-muted text-decoration-none" href="<?= base_url() ?>dashboard/index">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>
                      <li class="breadcrumb-acive">Shift Kerja Pegawai Reguler</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">

                </div>
              </div>
            </div>


          </div>
        </div>

        <?php
        $success = $this->session->flashdata('success');
        $error = $this->session->flashdata('error');
        $id_template = $template->id ;
        $nama_template = $template->nama_template ;
        $bulan = $template->bulan ;
        $tahun = $template->tahun ;

        $nm_bulan = getBulan($bulan);


        $periode = $tahun . '-' . $bulan;
        $periode = date('Y-m', strtotime($periode));

        $listBulan = array_bulan();

        $lastDateMonth = date('t', strtotime($periode));
        ?>

        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">

            <div class="card-header">

              <h4>Template Shift Kerja Pegawai Reguler</h4>
               <h5>Periode : <?= getNamaBulan($bulan).' - '.$tahun ?></h5>

                <div class="card-body p-4">

              
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
      
            </div>
             

                   <div class="col-md-10">
                        <a href="<?= base_url('admin_jadwal_shift/shift_regular') ?>" class="btn btn-light me-2 float-start">Kembali</a>

                          <button type="button" class="btn btn-info float-end btn-input-hari-libur">Input Hari Libur</button>
                        <a href="<?= base_url('admin_jadwal_shift/generate/'.$id_template) ?>" class="btn btn-light me-2 float-end">Generate Shift</a>
                        <div class="clearfix"></div>

                        <?php  ?>
                        <table class="table-custom mt-2">
                            <thead>
                                <tr class="bg-light">
                                    <th>Tanggal</th>
                                    <th>Hari</th>
                                    <th>Kode Shift</th>
                                    <th>Shift</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Pulang</th>
                                    <th>Keterangan</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach($detail_template as $d):
                              
                              $kode_shift = $d->kode_shift;
                              if($kode_shift == 'OFF' ){
                                $class_tr = 'text-muted bg-danger-light';
                              }else{
                                
                                $class_tr = ''; 
                              }

                               $keterangan = '';
                              $hari_libur = $this->Shift_model->getHariLiburByDate($d->tanggal);
                              if(!empty($hari_libur)){
                                $keterangan = $hari_libur->keterangan;
                              }
                              ?>
                                <!-- Tambahkan ID unik pada baris untuk memudahkan update teks via JS -->
                                <tr id="row-<?= $d->id ?>" class="<?= isset($class_tr) ? $class_tr : ''   ?>">
                                    <td class="text-center">  <?= format_semi($d->tanggal) ?></td>
                                    <td class="text-center"><?= format_hari($d->tanggal) ; ?></td>
                                    <td class="text-center"> 
                                        <!-- Teks kode shift yang akan diupdate otomatis setelah AJAX sukses -->
                                        <span class="shift-code"><?= $d->kode_shift ?></span>
                                      
                                    </td>
                                    <td>
                                        <span class="shift-name"><?= $d->nama_shift ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="shift-start"><?= $d->jam_masuk ?></span>
                                    </td>
                                    <td class="text-center">
                                        <span class="shift-end"><?= $d->jam_pulang ?></span>
                                    </td>
                                     <td><?= $keterangan ?> </td>
                                    <td class="text-center">
                                        <!-- Ikon Pensil untuk Trigger Modal -->
                                        <button type="button" class="btn btn-sm btn-link p-0 ms-2 btn-ubah-shift" 
                                                data-id="<?= $d->id ?>" 
                                                data-current-shift="<?= $d->shift_id ?>">
                                            <i class="fas fa-pencil-alt text-warning"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                </div>

                                <!-- MODAL BOOTSTRAP UNTUK PILIH SHIFT -->
                                <div class="modal fade" id="modalUbahShift" tabindex="-1" aria-labelledby="modalUbahShiftLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="modalUbahShiftLabel">Pilih Shift Baru</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <select id="modal_shift_id" class="form-control" required>
                                                        <option value="">-- Pilih Shift --</option>
                                                        <?php foreach($shift_kerja as $s): ?>
                                                            <option value="<?= $s->id ?>"><?= $s->kode_shift ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                <button type="button" id="btn-simpan-ajax" class="btn btn-success btn-sm">Simpan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                 <!-- MODAL BOOTSTRAP UNTUK PILIH SHIFT -->
                                <div class="modal fade" id="modalInputHariLibur" tabindex="-1" aria-labelledby="modalInputHariLiburLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-md">
                                      <form action="<?php echo base_url();?>admin_jadwal_shift/insert_hari_libur/<?= $id_template; ?>" method="post">
                                          <div class="modal-content">
                                              <div class="modal-header">
                                                  <h5 class="modal-title" id="modalInputHariLiburLabel">Pilih Hari Libur</h5>
                                                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                              </div>
                                              <div class="modal-body">
                                                  <!-- Input hidden untuk menampung ID detail yang sedang diedit -->
                                                  <input type="hidden" id="modal_detail_id">
                                                  
                                                  <div class="form-group">
                                                      <label for="tanggal_libur">Tanggal Libur</label>
                                                      <input type="date" id="tanggal_libur" name="tgl" class="form-control" required>
                                                  </div>
                                                     <div class="form-group mt-4">
                                                      <label for="tanggal_libur">Keterangan</label>
                                                      <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="hari raya ..." required>
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                                                  <button type="submit" id="btn-submit-hari-libur" class="btn btn-success btn-sm">Simpan</button>
                                              </div>
                                          </div>

                                        </form>
                                    </div>
                                </div>
              </div>
            </div>
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
      <script src="../assets/js/app.init.js"></script>
      <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
      <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>


<script>
$(document).ready(function() {
    $('.btn-ubah-shift').on('click', function() {
        var idDetail = $(this).attr('data-id');
        var currentShiftId = $(this).attr('data-current-shift');

        $('#modal_detail_id').val(idDetail);
        $('#modal_shift_id').val(currentShiftId);

        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('modalUbahShift')
        ).show();
    });

    $('.btn-input-hari-libur').on('click', function() {
        bootstrap.Modal.getOrCreateInstance(
            document.getElementById('modalInputHariLibur')
        ).show();
    });

    $('#btn-simpan-ajax').on('click', function() {
        var idDetail = $('#modal_detail_id').val();
        var shiftId = $('#modal_shift_id').val();

        if (!idDetail || !shiftId) {
            alert("Silakan pilih shift terlebih dahulu!");
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "<?= site_url('admin_jadwal_shift/ajax_update_shift_kerja') ?>",
            type: "POST",
            data: {
                detail_id: idDetail,
                shift_id: shiftId
            },
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    var $row = $('#row-' + idDetail);
                    $row.find('.shift-code').text(response.shift.kode_shift);
                    $row.find('.shift-name').text(response.shift.nama_shift);
                    $row.find('.shift-start').text(response.shift.jam_masuk || '');
                    $row.find('.shift-end').text(response.shift.jam_pulang || '');
                    $row.toggleClass('text-muted bg-danger-light', response.shift.kode_shift === 'OFF');
                    $row.find('.btn-ubah-shift').attr('data-current-shift', shiftId);

                    bootstrap.Modal.getOrCreateInstance(
                        document.getElementById('modalUbahShift')
                    ).hide();
                    alert('Shift berhasil diperbarui!');
                } else {
                    alert('Gagal memperbarui: ' + response.message);
                }
            },
            error: function(xhr) {
                var message = xhr.responseJSON && xhr.responseJSON.message
                    ? xhr.responseJSON.message
                    : 'Terjadi kesalahan sistem. Coba lagi.';
                alert(message);
            },
            complete: function() {
                $btn.prop('disabled', false).text('Simpan');
            }
        });
    });
});
</script>

</body>
</html>