<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
  .badge-capaian {
    background-color: #ecfdf5;
    color: #059669;
    border: 1px solid #a7f3d0;
    border-radius: 0.75rem;
    font-size: 0.75rem;
  }

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

    .bg-light-warning{
      background-color: #fcf6ee;
    }
    .text-light{
      color: #CCC !important;
    }

    .btn-outline-success{
      border: 1px solid green !important;
      color: green !important;
    }

     .btn-outline-warning{
      border: 1px solid darkorange !important;
      color: darkorange !important;
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
                $id_pegawai = $this->session->userdata('id_pegawai');
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
                        <div class="d-flex gap-2">
                          <form action="<?= base_url('kinerja/buat_renkin') ?>" method="post" onsubmit="return confirm('Buat Renkin untuk tahun <?= (int) $tahun_renkin ?>?')">
                            <input type="hidden" name="tahun" value="<?= (int) $tahun_renkin ?>">
                            <button type="submit" class="btn btn-primary">
                              <i class="fa fa-plus me-1"></i> Buat Renkin <?= (int) $tahun_renkin ?>
                            </button>
                          </form>
                          <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalIndikator">
                            <i class="fa fa-plus me-1"></i> Tambah Indikator
                          </button>
                        </div>
                      <?php else: ?>

                        <?php
                         if(!empty($list_renkin)){
                                $tahun = $list_renkin[0]->tahun;
                               
                        }else{
                            $tahun = date('Y');
                            $status = 0;
                        }
                        

                        //print_array($list_renkin);

                        // 1. Ambil data status angka dari database (misal: 0, 1, 2, 3, atau 4)
                        $status = isset($list_renkin[0]->status) ? (int)$list_renkin[0]->status : -1;

                        // 2. Ambil master mapping status dari Renkin Model
                        $status_master = $this->rm->get_status_list(); // Ambil array pemetaan status

                        // 3. Tentukan text dan class berdasarkan data dari Model dengan Fallback aman
                        if (isset($status_master[$status])) {
                        // Menggunakan string interpolation untuk menyisipkan $tahun_renkin secara rapi
                            $flag_status = "Status Renkin tahun {$tahun_renkin} : " . strtolower($status_master[$status]['label']);
                            $class_bg    = $status_master[$status]['class'];
                        } else {
                        // Fallback jika status tidak ditemukan/tidak valid
                            $flag_status = " Renkin tahun {$tahun_renkin} Belum dibuat";;
                            $class_bg    = 'bg-danger ';
                        }
                        ?>
                        <span class="badge <?=$class_bg ;?>"><?=$flag_status ;?></span>
                         
                
                      <a href="<?=base_url();?>admin/renkin/print_renkin?id_pegawai=<?=$id_pegawai;?>&tahun=<?=$tahun;?>" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">
                        <i class="ti ti-printer"></i> Print
                      </a>
                        <?php if($status==0){?>
                              <div class="col-md-12  mb-2 text-end">
                                        <a href="<?=site_url('kinerja/ajukan_renkin?tahun='.(int) $tahun_renkin);?>" class="btn btn-outline-warning me-2" id="btn-ajukan-renkin">Kunci Target & Ajukan</a>
                                      
                                        <?php if ($can_add_indikator): ?>
                                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#modalIndikator">
                                          <i class="uil-plus me-1"></i> Tambah Indikator
                                      </button>
                                        <?php endif; ?>
                                  </div>
                              <?php } ?>
                      <?php endif; ?>

                      
                    </div>

                    <div class="mt-4" style="max-height: 750px; overflow-y: auto; padding-right: 4px;">
                          <?php if (!empty($list_renkin)): ?>
                            <?php foreach ($list_renkin as $index => $row): ?>
                              <?php
                                $detail_by_month = array();
                                $status_target_renkin = $row->status;
                                foreach ($this->rm->getRenkinDetail($row->id) as $detail) {
                                    $detail_by_month[(int) $detail->bulan] = $detail;
                                }

                                $monthly_targets = array();
                                for ($month = 1; $month <= 12; $month++) {
                                  $monthly_targets[$month] = isset($detail_by_month[$month]) ? $detail_by_month[$month]->target : 0;
                                }

                                $satuan = $row->satuan;
                                $explod = explode(" ", $satuan);
                                $satuan_target = (count($explod) == 1) ? $satuan : $explod[1];

                                // --- LOGIKA PENENTUAN DEADLINE ---
                                $current_month = (int) date('n');
                                $allowed_month = ($current_month == 1) ? 12 : ($current_month - 1);
                              ?>

                              <!-- CARD UTAMA INDIKATOR -->
                              <div class="card border-0 shadow-sm mb-4 rounded-3">
                                
                                <!-- HEADER CARD: Nomor, Renkin Atasan, Status & Tombol Aksi -->
                                <div class="card-header bg-white border-bottom py-3 px-4">
                                  <div class="d-flex flex-wrap justify-content-between align-items-start gap-2">
                                    
                                    <!-- Kiri: Badge Nomor & Renkin Atasan -->
                                    <div class="d-flex align-items-center gap-2">
                                      <span class="badge bg-primary rounded-pill px-2.5 py-1.5 fs-6">#<?= $index + 1 ?></span>
                                      <div>
                                        <span class="text-muted small d-block" style="font-size: 0.75rem;">Rencana Hasil Kerja Atasan yang Diintervensi</span>
                                        <span class="fw-semibold text-secondary small">
                                          <i class="fas fa-level-up-alt fa-rotate-90 me-1 text-muted"></i>
                                          <?= htmlspecialchars(isset($row->renkin_atasan) && $row->renkin_atasan !== '' ? $row->renkin_atasan : 'Belum diisi', ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                      </div>
                                    </div>

                                    <!-- Kanan: Status Persetujuan & Tombol Edit -->
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                      <?php if ($status_target_renkin == 0): ?>
                                        <button type="button" 
                                                class="btn btn-info btn-sm text-white" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditTarget" 
                                                data-renkin-id="<?= (int) $row->id ?>" 
                                                data-tahun="<?= (int) $row->tahun ?>" 
                                                data-indikator="<?= escape($row->indikator) ?>" 
                                                data-satuan="<?= escape($row->satuan) ?>" 
                                                data-target-tahunan="<?= escape($row->target_tahunan) ?>" 
                                                data-target-bulanan="<?= escape(json_encode($monthly_targets)) ?>">
                                          <i class="fas fa-sliders-h me-1"></i> Edit Target
                                        </button>
                                      <?php elseif ($status_target_renkin == 2): ?>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill">
                                          <i class="fas fa-check-circle me-1"></i> Target Renkin Disetujui
                                        </span>
                                      <?php elseif ($status_target_renkin == 4): ?>
                                        <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-3 py-2 rounded-pill" 
                                              title="Catatan: <?= htmlspecialchars($row->catatan, ENT_QUOTES, 'UTF-8') ?>">
                                          <i class="fas fa-exclamation-circle me-1"></i> Perlu Direvisi
                                        </span>
                                        <button type="button" 
                                                class="btn btn-info btn-sm text-white" 
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEditTarget" 
                                                data-renkin-id="<?= (int) $row->id ?>" 
                                                data-tahun="<?= (int) $row->tahun ?>" 
                                                data-indikator="<?= escape($row->indikator) ?>" 
                                                data-satuan="<?= escape($row->satuan) ?>" 
                                                data-target-tahunan="<?= escape($row->target_tahunan) ?>" 
                                                data-target-bulanan="<?= escape(json_encode($monthly_targets)) ?>">
                                          <i class="fas fa-edit me-1"></i> Edit Target
                                        </button>
                                      <?php endif; ?>

                                      <button type="button" 
                                              class="btn btn-outline-primary btn-sm input-renkin-atasan" 
                                              data-bs-toggle="modal" 
                                              data-bs-target="#modalInputRenkinAtasan" 
                                              data-id="<?= (int) $row->id ?>">
                                        <i class="fas fa-edit me-1"></i> Input Renkin Atasan
                                      </button>
                                    </div>

                                  </div>

                                  <!-- Alert Catatan Revisi jika status == 4 -->
                                  <?php if ($status_target_renkin == 4 && !empty($row->catatan)): ?>
                                    <div class="alert alert-warning py-2 px-3 mt-2 mb-0 small">
                                      <strong>Catatan Revisi:</strong> <?= htmlspecialchars($row->catatan, ENT_QUOTES, 'UTF-8') ?>
                                    </div>
                                  <?php endif; ?>
                                </div>

                                <!-- BODY CARD: Judul RHK, Indikator, Satuan & Target Tahunan -->
                                <div class="card-body px-4 py-3">
                                  <div class="mb-3">
                                    <span class="text-uppercase text-muted fw-bold" style="font-size: 0.7rem; letter-spacing: 0.5px;">Rencana Hasil Kerja</span>
                                    <h6 class="fw-bold text-dark mb-2 mt-1" style="line-height: 1.4;">
                                      <?= htmlspecialchars(isset($row->rencana_hasil_kerja) ? $row->rencana_hasil_kerja : '', ENT_QUOTES, 'UTF-8') ?>
                                    </h6>
                                    
                                    <div class="d-flex flex-wrap align-items-center gap-3 mt-2 pt-2 border-top border-light">
                                      <div>
                                        <span class="text-muted small">Indikator: </span>
                                        <span class="fw-semibold text-dark small"><?= htmlspecialchars($row->indikator, ENT_QUOTES, 'UTF-8') ?></span>
                                      </div>
                                      <div class="vr d-none d-md-block text-muted"></div>
                                      <div>
                                        <span class="text-muted small">Satuan: </span>
                                        <span class="badge bg-light text-dark border"><?= htmlspecialchars($row->satuan, ENT_QUOTES, 'UTF-8') ?></span>
                                      </div>
                                      <div class="vr d-none d-md-block text-muted"></div>
                                      <div>
                                        <span class="text-muted small">Target Tahunan: </span>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle fs-6">
                                          <?= number_format((float) $row->target_tahunan, 0, ',', '.') ?> <?= htmlspecialchars($satuan_target, ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                      </div>
                                    </div>
                                  </div>

                                  <!-- GRID 12 BULAN -->
                                  <div class="row g-2 mt-2">
                                    <?php
                                    for ($month = 1; $month <= 12; $month++): 
                                      $detail = isset($detail_by_month[$month]) ? $detail_by_month[$month] : null; 
                                      $target_bln = isset($detail_by_month[$month]) ? (float) $detail_by_month[$month]->target : 0;
                                      $realisasi  = isset($detail_by_month[$month]) ? (float) $detail_by_month[$month]->realisasi : 0;
                                      $validasi   = isset($detail_by_month[$month]) ? (float) $detail_by_month[$month]->validasi : 0;

                                      $persen_capaian = ($realisasi == 0) ? 0 : round(($validasi / $realisasi) * 100);

                                      // Warna border & badge dinamis agar tidak menyilaukan mata
                                      if ($persen_capaian >= 100) {
                                        $card_border = "border-success";
                                        $badge_style = "bg-success-subtle text-success";
                                      } elseif ($realisasi > 0 || $target_bln > 0) {
                                        $card_border = "border-warning";
                                        $badge_style = "bg-warning-subtle text-warning-emphasis";
                                      } else {
                                        $card_border = "border-primary";
                                        $badge_style = "bg-light text-muted";
                                      }

                                      // Logika Tombol Input/Edit
                                      $can_edit = ($month === $allowed_month) && ($validasi == 0);
                                      if ($can_edit) {
                                        $disble_button = '';
                                        $btn_class = ($realisasi == 0) ? 'btn-primary' : 'btn-warning text-dark';
                                      } else {
                                        $disble_button = 'disabled';
                                        $btn_class = 'btn-light text-muted border';
                                      }
                                      $text_btn = ($realisasi == 0) ? 'Input Realisasi' : 'Edit Realisasi';
                                    ?>
                                      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="border <?= $card_border ?> rounded-3 p-2.5 h-100 d-flex flex-column justify-content-between bg-white">
                                          
                                          <!-- Header Bulan & Persentase -->
                                          <div>
                                            <div class="d-flex justify-content-between align-items-center mb-2 pb-1 border-bottom border-light">
                                              <span class="fw-bold text-dark small"><?= getBulan($month) ?></span>
                                              <span class="badge <?= $badge_style ?> rounded-pill" style="font-size: 0.7rem;">
                                                Capaian: <strong><?= $persen_capaian ?>%</strong>
                                              </span>
                                            </div>

                                            <!-- 3 Kolom Angka (Target, Realisasi, Validasi) -->
                                            <div class="row g-1 text-center my-2 bg-light rounded-2 py-1.5 mx-0">
                                              <div class="col-4 border-end">
                                                <div class="text-muted" style="font-size: 0.65rem;">Target</div>
                                                <div class="fw-bold text-dark small"><?= escape($target_bln) ?></div>
                                              </div>
                                              <div class="col-4 border-end">
                                                <div class="text-muted" style="font-size: 0.65rem;">Realisasi</div>
                                                <div class="fw-bold text-primary small"><?= $realisasi ?></div>
                                              </div>
                                              <div class="col-4">
                                                <div class="text-muted" style="font-size: 0.65rem;">Validasi</div>
                                                <div class="fw-bold text-success small"><?= $validasi ?></div>
                                              </div>
                                            </div>
                                          </div>

                                          <!-- Tombol Aksi di Dalam Kartu Bulan -->
                                          <button type="button" 
                                                  class="btn <?= $btn_class ?> btn-sm w-100 mt-1 input-realisasi" 
                                                  style="font-size: 0.75rem;"
                                                  data-bs-toggle="modal" 
                                                  data-bs-target="#modalInputRealisasi" 
                                                  data-renkin-id="<?= (int) $row->id ?>" 
                                                  data-bulan="<?= $month ?>" 
                                                  <?= $disble_button ?>>
                                            <i class="fas <?= ($realisasi == 0) ? 'fa-plus' : 'fa-pen' ?> me-1"></i> <?= $text_btn ?>
                                          </button>

                                        </div>
                                      </div>
                                    <?php endfor; ?>
                                  </div>

                                </div>
                              </div>

                            <?php endforeach; ?>
                          <?php else: ?>
                            <div class="card border-0 shadow-sm rounded-3">
                              <div class="card-body text-center text-muted py-5">
                                <i class="fas fa-folder-open fa-2x mb-2 text-light-emphasis"></i>
                                <p class="mb-0">Belum ada Renkin untuk tahun <?= (int) $tahun_renkin ?>.</p>
                              </div>
                            </div>
                          <?php endif; ?>
                        </div>

                  </div>
                </div>
              </div>
            </div>

            

            <div class="modal fade" id="modalInputRenkinAtasan" tabindex="-1" aria-labelledby="modalInputRenkinAtasanLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable">
                <div class="modal-content">
                  <form action="<?= base_url('kinerja/input_renkin_atasan') ?>" method="post">
                    <input type="hidden" name="id_renkin" id="id_renkin" value="">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                    <div class="modal-header">
                      <h5 class="modal-title" id="modalInputRenkinAtasanLabel">Input Renkin Atasan</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                      <div class="mb-3">
                        <label for="cari-indikator" class="form-label">RENCANA HASIL KERJA ATASAN YANG DIINTERVENSI</label>
                        <textarea name="renkin_atasan" id="renkin_atasan" class="form-control"></textarea>
                      </div>
                      <label for="pilih-indikator" class="form-label">RENCANA HASIL KINERJA</label>
                      <textarea name="rencana_hasil" id="rencana_hasil" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                  </form>
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

                      <div class="row">
                        <div class="col-md-6">
                              <div class="mb-4">
                              <label for="info-target-tahunan" class="form-label fw-semibold">Periode</label>
                              <input type="text" class="form-control" id="info-periode" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                              <div class="mb-4">
                              <label for="info-target-tahunan" class="form-label fw-semibold">Target Tahunan</label>
                              <input type="number" min="0" step="any" class="form-control" id="info-target-tahunan" readonly>
                            </div>
                        </div>
                         <div class="col-md-6">

                            <div class="mb-4">
                              <label for="info-target-bulanan" class="form-label fw-semibold">Target Bulanan</label>
                              <input type="number" min="0" step="any" class="form-control" id="info-target-bulanan" readonly>
                            </div>

                          </div>

                        <div class="col-md-6">
                          
                            <div class="mb-4">
                              <label for="realisasi" class="form-label fw-semibold">Realisasi</label>
                              <input type="number" min="0" step="any" class="form-control" name="realisasi" id="realisasi" required>
                            </div>
                          </div>



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
        var cariIndikator = document.getElementById('cari-indikator');
        var pilihIndikator = document.getElementById('pilih-indikator');
        function filterIndikator() {
          var keyword = cariIndikator.value.trim().toLowerCase();
          var visibleCount = 0;
          Array.prototype.forEach.call(pilihIndikator.options, function(option) {
            option.hidden = option.textContent.toLowerCase().indexOf(keyword) === -1;
            if (option.hidden && option.selected) option.selected = false;
            if (!option.hidden) visibleCount++;
          });
          document.getElementById('indikator-kosong').hidden = visibleCount > 0;
        }
        if (cariIndikator && pilihIndikator && document.getElementById('indikator-kosong')) {
          cariIndikator.addEventListener('input', filterIndikator);
          filterIndikator();
        }

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


          $('.input-renkin-atasan').on('click', function() {
                var renkinId = $(this).data('id');
                $('#id_renkin').val(renkinId);
          });


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

          var bulan_tahun = detail.bulan+"-"+detail.tahun;

          $('#input-realisasi-renkin-id').val(detail.id_renkin);
          $('#input-realisasi-bulan').val(detail.bulan);
          $('#info-target-indikator').text(detail.indikator);
          $('#info-target-satuan').text(detail.satuan);
          $('#info-renkin-tahun').text(detail.tahun);
          $('#info-target-bulan').text(detail.bulan);
          $('#info-target-tahunan').val(detail.target_tahunan);
          $('#info-target-bulanan').val(detail.target_bulanan);
          $('#realisasi').val(detail.realisasi);
          $("#info-periode").val(bulan_tahun);
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