<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
  table{
    width: 100%;
  }
    table th,  td{
      border:1px solid #CCC;
      padding: 10px;
      font-family: Arial, Helvetica, sans-serif;
    }
    .form-table{
      border:1px solid #DDD;
      padding:5px;
      text-align:center
    }

    th{
      color: #444;
      background-color: #EEE;
      border:1px solid #CCC !important;
    }
    .text-secondary{
      color: #666 !important;
    }
    .border-secondary{
      border-color: pink !important;
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


      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->

         <?php
                $message = $this->session->flashdata('message');
                $title = 'Renkin';
            ?>

                   
      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8"> <?php echo $title;?> </h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="<?php echo base_url();?>dashboard" >Home / Kinerja</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive"> <?php echo $title;?> </li>
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
            
            <div class="row">
              <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">


                    <?php if (!empty($message)): ?>
                      <?= $message ?>
                    <?php endif; ?>

                    <?php
                    
                   // print_array($list_renkin);
                    ?>

                    <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                      <form action="<?= base_url('kinerja/renkin') ?>" method="get" class="d-flex align-items-end gap-2">
                        <div>
                          <label for="tahun-renkin" class="form-label">Tahun</label>
                          <select name="tahun" id="tahun-renkin" class="form-select">
                            <?php for ($year = $tahun_awal; $year <= $tahun_akhir; $year++): ?>
                              <option value="<?= $year ?>" <?= $year == $tahun_renkin ? 'selected' : '' ?>><?= $year ?></option>
                            <?php endfor; ?>
                          </select>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Tampilkan</button>
                      </form>

                      <?php if (empty($list_renkin)): ?>
                        <form action="<?= base_url('kinerja/buat_renkin') ?>" method="post" onsubmit="return confirm('Buat Renkin untuk tahun <?= (int) $tahun_renkin ?>?')">
                          <input type="hidden" name="tahun" value="<?= (int) $tahun_renkin ?>">
                          <button type="submit" class="btn btn-primary">
                            <i class="fa fa-plus me-1"></i> Buat Renkin <?= (int) $tahun_renkin ?>
                          </button>
                        </form>
                      <?php else: ?>

                        <?php
                          $status = $list_renkin[0]->status;
                         if($status==0)
                          {
                            $flag_status = 'Renkin '.$tahun_renkin.' sudah dibuat';
                            $class_bg = 'bg-info';
                          }else if($status==1){
                            $flag_status = 'Renkin '.$tahun_renkin.' sudah diajukan';
                            $class_bg = 'bg-warning';
                          }else if($status==2){
                            $flag_status = 'Renkin '.$tahun_renkin.' sudah disetujui';
                            $class_bg = 'bg-success';
                          }else if($status==3){
                            $flag_status = 'Renkin '.$tahun_renkin.'  ditolak';
                            $class_bg = 'bg-danger';
                          }else if($status==4){
                            $flag_status = 'Renkin '.$tahun_renkin.'  perlu direvisi';
                            $class_bg = 'bg-danger-outline';
                          }else{
                            $flag_status = '-';
                            $class_bg = '';
                          }
                        ?>
                        <span class="badge <?=$class_bg ;?>"><?=$flag_status ;?></span>
                         
                 

                             <?php if($status==0){?>
                                <div class="col-md-12  mb-2 text-end">
                                          <a href="<?=site_url('kinerja/ajukan_renkin?tahun='.(int) $tahun_renkin);?>" class="btn btn-outline-warning me-2" id="btn-ajukan-renkin">Kunci Target & Ajukan</a>
                                        
                                          <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalIndikator">
                                            <i class="uil-plus me-1"></i> Tambah Indikator
                                        </button>
                                    </div>
                               <?php } ?>
                        <?php endif; ?>

                      
                    </div>

                    <div class="table-responsive mt-4" style=" max-height:600px">
                      <table class="align-middle text-secondary overflow-scroll" style="width:150%;">
                        <thead class=" table-light text-center">
                          <tr>
                            <th rowspan="2">No</th>
                            <th rowspan="2" class="text-start" width="600">Indikator</th>
                            <th rowspan="2">Satuan</th>
                            <th rowspan="2">Target Tahunan</th>
                            <?php for ($month = 1; $month <= 12; $month++): ?>
                              <th><?= getNamaBulan($month) ?></th>
                            <?php endfor; ?>
                            <th>Aksi</th>
                          </tr>
                         
                        </thead>
                        <tbody >
                          <?php if (!empty($list_renkin)): ?>
                           <?php foreach ($list_renkin as $index => $row): ?>
                                  <?php
                                    $detail_by_month = array();
                                    foreach ($this->rm->getRenkinDetail($row->id) as $detail) {
                                        $detail_by_month[(int) $detail->bulan] = $detail;
                                    }
                                    $monthly_targets = array();
                                    for ($month = 1; $month <= 12; $month++) {
                                      $monthly_targets[$month] = isset($detail_by_month[$month]) ? $detail_by_month[$month]->target : 0;
                                    }

                                    // --- LOGIKA PENENTUAN DEADLINE ---
                                    $current_month = (int) date('n'); // Contoh: 11 untuk November
                                    $current_day   = (int) date('j'); // Contoh: 1 s.d 31

                                    // Bulan yang diizinkan untuk di-update (bulan lalu)
                                    $allowed_month = $current_month - 1; 

                                    // Kasus Khusus: Jika sekarang Januari (bulan 1), maka bulan lalu adalah Desember (bulan 12)
                                    if ($current_month == 1) {
                                        $allowed_month = 12;
                                    }

                                    // Cek apakah hari ini masih dalam batas penginputan (<= tanggal 5)
                                    $is_within_deadline = ($current_day <= 5);
                                  ?>
                                  <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td width="600" class="text-start"><?= htmlspecialchars($row->indikator, ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="text-center"><?= htmlspecialchars($row->satuan, ENT_QUOTES, 'UTF-8') ?></td>
                                    <td class="text-center fs-4 text-primary"> <strong><?= number_format((float) $row->target_tahunan, 0, ',', '.') ?></strong> </td>
                                    
                                    <?php for ($month = 1; $month <= 12; $month++): ?>
                                      <?php $detail = isset($detail_by_month[$month]) ? $detail_by_month[$month] : null; ?>
                                      
                                      <td class="text-center" width="200">
                                        <?php
                                          $validasi = isset($detail_by_month[$month]) ? (int) $detail_by_month[$month]->validasi : 0;
                                          $status_validasi =  (int) $detail_by_month[$month]->status ;
                                          if($status_validasi==0){
                                              $class_border= 'border-secondary';
                                          }else if($status_validasi==1){
                                            $class_border= 'border-warning';
                                          }else if($status_validasi==2){
                                            $class_border= 'border-success';
                                          }else{
                                            $class_border= 'border-danger';
                                          }


                                        // Ambil nilai realisasi & validasi dari object detail
                                          $realisasi = isset($detail_by_month[$month]) ? (float) $detail_by_month[$month]->realisasi : 0;
                                          $validasi  = isset($detail_by_month[$month]) ? (float) $detail_by_month[$month]->validasi : 0;

                                          if ($validasi == 0) {
                                              // Menghindari error Division by Zero jika validasi masih 0
                                              $persen_capaian = 0;
                                              
                                          } else {
                                              // Realisasi dibagi Validasi (Kunci Capaian)
                                              $persen_capaian = round(($validasi / $realisasi) * 100);
                                              

                                          }

                                          if($persen_capaian==0){
                                            $bg_capaian = "border-danger";
                                          }elseif($persen_capaian >=100){
                                            $bg_capaian = "border-success text-success";
                                            }else{
                                            $bg_capaian = "border-warning text-warning";
                                          }


                                         

                                          
                                          // PERIKSA APABILA BULAN SAAT INI BOLEH DIEDIT
                                          $can_edit = ($month === $allowed_month) && $is_within_deadline && $validasi==0;

                                          if($can_edit){
                                            $disble_button = '';
                                            $btn_class = 'btn-info';
                                          }else{
                                             $disble_button = 'disabled';
                                             $btn_class = 'btn-light text-muted';
                                          }


                                        ?>
                                        <div class="target-info text-start border-2 <?=$class_border;?> rounded p-2">
                                        <div class="d-inline-flex align-items-center border rounded overflow-hidden fs-1 fw-semibold">
                                              <span class="px-2 py-1 bg-light text-dark">
                                                T: <?= isset($detail_by_month[$month]) ? htmlspecialchars($detail_by_month[$month]->target, ENT_QUOTES, 'UTF-8') : 0 ?>
                                              </span>
                                              <span class="px-2 py-1 bg-light text-muted border-start">
                                                R: <?= isset($detail_by_month[$month]) ? htmlspecialchars($detail_by_month[$month]->realisasi, ENT_QUOTES, 'UTF-8') : 0 ?>
                                              </span>
                                              <span class="px-2 py-1 bg-light text-success border-start">
                                                V: <?= $validasi ?>
                                              </span>
                                            </div>
                                            <div class="clearfix"></div>

                                            <span  class="fs-3 d-block border rounded text-center  <?=$bg_capaian;?> p-1 mt-2 mb-2"> <strong> <?=$persen_capaian;?>%</strong></span>
                                            
                                            <!-- TOMBOL REALISASI DENGAN ATRIBUT DISABLED & DATA-BULAN SESUAI LOOP -->
                                            <button type="button" 
                                                    class="btn <?=$btn_class;?> btn-sm input-realisasi" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#modalInputRealisasi" 
                                                    data-renkin-id="<?= (int) $row->id ?>" 
                                                    data-bulan="<?= $month ?>" 
                                                    <?= $disble_button?>>
                                                Input Realisasi
                                            </button>
                                          
                                        </div>
                                      </td>
                                    <?php endfor; ?>
                                    
                                      <td>
                                          <?php if($status==0): ?>
                                            <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalEditTarget" data-renkin-id="<?= (int) $row->id ?>" data-tahun="<?= (int) $row->tahun ?>" data-indikator="<?= htmlspecialchars($row->indikator, ENT_QUOTES, 'UTF-8') ?>" data-satuan="<?= htmlspecialchars($row->satuan, ENT_QUOTES, 'UTF-8') ?>" data-target-tahunan="<?= htmlspecialchars($row->target_tahunan, ENT_QUOTES, 'UTF-8') ?>" data-target-bulanan="<?= htmlspecialchars(json_encode($monthly_targets), ENT_QUOTES, 'UTF-8') ?>">Edit Target</button>
                                        <?php elseif($status==1):?>
                                            
                                          <?php endif;?>
                                      </td>
                                  </tr>
                                <?php endforeach; ?>
                          <?php else: ?>
                            <tr>
                              <td colspan="40" class="text-center text-muted py-4">Belum ada Renkin untuk tahun <?= (int) $tahun_renkin ?>.</td>
                            </tr>
                          <?php endif; ?>
                        </tbody>
                      </table>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            

            <div class="modal fade" id="modalInputRealisasi" tabindex="-1" aria-labelledby="modalInputRealisasiLabel" aria-hidden="true">
              <div class="modal-dialog  modal-dialog-scrollable">
                <div class="modal-content">
                  <form action="<?= base_url('kinerja/update_realisasi') ?>" method="post" id="formInputRealisasi">
                    <input type="hidden" name="id_renkin" id="input-realisasi-renkin-id">
                    <input type="hidden" name="bulan" id="input-realisasi-bulan">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalInputRealisasiLabel">Input Realisasi</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3 p-3 bg-light rounded">
                        <div class="fw-semibold" id="info-target-indikator"></div>
                        <div class="small text-muted">Satuan: <span id="info-target-satuan" class="fw-bold text-primary"></span> <br>
                         Periode :  <span id="info-target-bulan"></span> - <span id="info-renkin-tahun"></span>  </div>
                      </div>
                      <div class="mb-4">
                        <label for="info-target-tahunan" class="form-label fw-semibold">Target Tahunan</label>
                        <input type="number" min="0" step="any" class="form-control" id="info-target-tahunan" readonly>
                      </div>

                      <div class="mb-4">
                        <label for="info-target-bulanan" class="form-label fw-semibold">Target Bulanan</label>
                        <input type="number" min="0" step="any" class="form-control" id="info-target-bulanan" readonly>
                      </div>
                      <div class="mb-4">
                        <label for="realisasi" class="form-label fw-semibold">Realisasi</label>
                        <input type="number" min="0" step="any" class="form-control" name="realisasi" id="realisasi" required>
                      </div>
                     
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan Target</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>div>

            <div class="modal fade" id="modalEditTarget" tabindex="-1" aria-labelledby="modalEditTargetLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <form action="<?= base_url('kinerja/update_target_renkin') ?>" method="post" id="formEditTargetRenkin">
                    <input type="hidden" name="id_renkin" id="edit-target-renkin-id">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalEditTargetLabel">Edit Target Renkin</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3 p-3 bg-light rounded">
                        <div class="fw-semibold" id="edit-target-indikator"></div>
                        <div class="small text-muted">Satuan: <span id="edit-target-satuan"></span> | Tahun: <span id="edit-target-tahun"></span></div>
                      </div>
                      <div class="mb-4">
                        <label for="edit-target-tahunan" class="form-label fw-semibold">Target Tahunan</label>
                        <input type="number" min="0" step="any" class="form-control" name="target_tahunan" id="edit-target-tahunan" required>
                      </div>
                      <h6 class="mb-3">Target Bulanan</h6>
                      <div class="row g-3">
                        <?php for ($month = 1; $month <= 12; $month++): ?>
                          <div class="col-6 col-md-4">
                            <label for="edit-target-bulan-<?= $month ?>" class="form-label"><?= getNamaBulan($month) ?></label>
                            <input type="number" min="0" step="any" class="form-control" name="target_bulanan[<?= $month ?>]" id="edit-target-bulan-<?= $month ?>" required>
                          </div>
                        <?php endfor; ?>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan Target</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>

      <script>
          function handleColorTheme(e) {
            $("html").attr("data-color-theme", e);
            $(e).prop("checked", !0);
          }
        </script>

        <?php $this->load->view('layout/section/theme-setting.php');?>

        <?php $this->load->view('master/request-cuti.php');?>

  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->

    <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>
    <script src="../assets/js/app.init.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.min.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>theme.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>init.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>jquery.blockUI.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>block-ui.js"></script>


    <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>bootstrap-datepicker.js"></script>

  

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
        var btnRenkin = document.getElementById('btn-ajukan-renkin');

          if (btnRenkin) {
            btnRenkin.addEventListener('click', function(event) {
              event.preventDefault();

              var url = this.href;
              Swal.fire({
                title: 'Ajukan Renkin?',
                text: 'Target akan dikunci dan tidak dapat diubah setelah diajukan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, kunci dan ajukan',
                cancelButtonText: 'Batal'
              }).then(function(result) {
                if (result.isConfirmed) {
                  window.location.href = url;
                }
              });
            });
          }



    document.getElementById('modalEditTarget').addEventListener('show.bs.modal', function(event) {
      var trigger = event.relatedTarget;
      var monthlyTargets = JSON.parse(trigger.dataset.targetBulanan || '{}');

      document.getElementById('edit-target-renkin-id').value = trigger.dataset.renkinId;
      document.getElementById('edit-target-indikator').textContent = trigger.dataset.indikator;
      document.getElementById('edit-target-satuan').textContent = trigger.dataset.satuan;
      document.getElementById('edit-target-tahun').textContent = trigger.dataset.tahun;
      document.getElementById('edit-target-tahunan').value = trigger.dataset.targetTahunan;

      for (var month = 1; month <= 12; month++) {
        document.getElementById('edit-target-bulan-' + month).value = monthlyTargets[month] || 0;
      }
    });



    $(document).on('click', '.input-realisasi', function() {
      var button = $(this);

      $.ajax({
        type: 'GET',
        url: '<?= site_url('kinerja/ajax_get_detail_renkin') ?>',
        dataType: 'json',
        data: {
          id_renkin: button.data('renkin-id'),
          bulan: button.data('bulan')
        },
        success: function(response) {
          if (!response.status) {
            alert(response.message || 'Detail Renkin tidak ditemukan.');
            return;
          }

          var detail = response.data;
          $('#input-realisasi-renkin-id').val(detail.id_renkin);
          $('#input-realisasi-bulan').val(detail.bulan);
          $('#info-target-indikator').text(detail.indikator);
          $('#info-target-satuan').text(detail.satuan);
          $('#info-renkin-tahun').text(detail.tahun);
          $('#info-target-bulan').text(detail.bulan);
          $('#info-target-tahunan').val(detail.target_tahunan);
          $('#info-target-bulanan').val(detail.target_bulanan);
          $('#realisasi').val(detail.realisasi);
        },
        error: function() {
          alert('Gagal mengambil detail Renkin. Silakan coba kembali.');
        }
      });
    });

    document.getElementById('formInputRealisasi').addEventListener('submit', function(e) {
        // 1. Hentikan form agar tidak langsung submit otomatis
        e.preventDefault(); 
        
        // 2. Munculkan SweetAlert konfirmasi
        Swal.fire({
            title: 'Update Realisasi?',
            text: "Pastikan data realisasi kinerja yang Anda masukkan sudah benar.",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Update!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            // 3. Jika user menekan tombol 'Ya, Update!'
            if (result.isConfirmed) {
                // Jalankan submit form ke controller 'kinerja/update_realisasi'
                this.submit(); 
            }
        });
    });
</script>


<!-- Script Menampilkan Pesan Setelah Redirect -->
<?php if($this->session->flashdata('status')): ?>
<script>
    Swal.fire({
        icon: '<?= $this->session->flashdata('status') == 'sukses' ? 'success' : 'error' ?>',
        title: '<?= $this->session->flashdata('status') == 'sukses' ? 'Berhasil!' : 'Gagal!' ?>',
        text: '<?= $this->session->flashdata('pesan') ?>',
        showConfirmButton: true
    });
</script>
<?php endif; ?>


</body>

</html>