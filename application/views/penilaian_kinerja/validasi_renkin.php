<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
 /* Container Utama */

table{
    width: 100%;
}

tr td{
    border: none !important;
}

/* Setiap Kotak Bulan */
.list-bulan-renkin .list {
    background-color: #ffffff;
    border: 1px solid #e3e6f0;
    border-radius: 6px;
    align-items: center; 
    /* Memisahkan nama bulan di kiri ekstrem & data angka di kanan ekstrem */
    justify-content: space-between; 
}

/* Nama Bulan (Sisi Kiri) */
.list-bulan-renkin .list .nama-bulan {
    font-weight: 700;
    color: #333;
    font-size: 14px;
    flex-shrink: 0; /* Mencegah nama bulan gepeng atau mengecil */
    margin-right: 15px;
}

/* Kontainer Data Angka (Memaksimalkan Sisa Space Kotak) */
.list-bulan-renkin .list .data-bulan {
    
    font-size: 13px;
}

/* Tampilan Responsif (Layar HP) */
@media (max-width: 768px) {
    .list-bulan-renkin {
        grid-template-columns: 1fr;
    }
}

.text-amber{
    color: #c17915;
}

.text-emerald{
    color: #16a35d;
}

/* Menyesuaikan border radio button card saat aktif */
.btn-check:checked + .btn-outline-success {
    background-color: #d1e7dd !important;
    color: #0f5132 !important;
    border-color: #badbcc !important;
}

.btn-check:checked + .btn-outline-danger {
    background-color: #f8d7da !important;
    color: #842029 !important;
    border-color: #f5c2c7 !important;
}

/* Mempercantik textarea focus */
#modalValidasiRenkin textarea.form-control:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.border-rose{
    border: 1px solid #F34E91 !important ;
}

.border-success{
    border: 1px solid #2CC070 !important ;
}

.renkin-indikator-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 1rem;
}

.renkin-indikator-info {
    min-width: 0;
}

.renkin-last-input {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.4rem 0.8rem;
    margin-top: 0.65rem;
    color: #495057;
    font-size: 0.875rem;
}

.renkin-indikator-actions {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 0.5rem;
    flex-shrink: 0;
}

.action-container {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.renkin-toggle .fa-chevron-down {
    transition: transform 0.2s ease;
}

.renkin-toggle[aria-expanded="true"] .fa-chevron-down {
    transform: rotate(180deg);
}

@media (max-width: 768px) {
    .renkin-indikator-header {
        flex-direction: column;
    }

    .renkin-indikator-actions {
        width: 100%;
        justify-content: flex-end;
    }
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

               // print_array($detail_pegawai);
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

                      <a href="<?=base_url();?>admin/penilaian_kinerja/renkin_pegawai" class="btn  btn-secondary">
                       <i class="fas fa-arrow-left"></i>         Kembali
                     </a>
                     
                        <div class="card border-0 shadow-sm mb-4 bg-light">
                            <div class="card-body p-4">
                                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
                                    
                                    <!-- Sisi Kiri: Profil & Jabatan -->
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 55px; height: 55px; flex-shrink: 0;">
                                            <i class="fas fa-user-circle fs-2"></i>
                                        </div>
                                        <div>
                                            <!-- Menggunakan Akses Object (->) -->
                                            <h5 class="fw-bold text-dark mb-1"><?= escape($detail_pegawai[0]->nama) ?></h5>
                                            <p class="text-muted mb-0 font-size-sm">
                                                <i class="fas fa-id-card me-1"></i> NIP: <span class="fw-semibold text-secondary"><?= escape($detail_pegawai[0]->nip) ?></span>
                                            </p>
                                        </div>
                                    </div>

                                    <!-- Sisi Kanan: Detail Unit Kerja & Status -->
                                    <div class="d-flex flex-wrap gap-2 gap-md-4 text-md-end w-100 w-md-auto justify-content-between justify-content-md-end">
                                        <!-- Info Jabatan & Puskesmas -->
                                        <div class="pe-md-3 border-md-right">
                                            <div class="fw-bold text-dark mb-0"><?= escape($detail_pegawai[0]->jabatan) ?></div>
                                            <small class="text-muted"><i class="fas fa-hospital-alt me-1"></i> Unit: <?= escape($detail_pegawai[0]->puskesmas) ?></small>
                                        </div>
                                        
                                        <!-- Status Pegawai (Badge Dinamis) -->
                                        <div class="d-flex align-items-center">
                                            <?php if ($detail_pegawai[0]->jns_pegawai === 'non_pns'): ?>
                                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                                    <i class="fas fa-user-tag me-1"></i> Non PNS
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                                    <i class="fas fa-user-check me-1"></i> PNS
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

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

                      

                      
                        <?php
                       // print_array($list_renkin);


                        if(!empty($list_renkin)){
                                $tahun = $list_renkin[0]->tahun;
                               $status = $list_renkin[0]->status;
                        }else{
                            $tahun = date('Y');
                            $status = 0;
                        }
                        


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
                         
                 
                      
                    </div>

                  


                    <div class="table-responsive mt-4">
                        <table class="table align-middle text-secondary table-bordered ">
                            <thead class="table-light text-center align-middle">
                                <tr>
                                   
                                    <th class="text-start" style="min-width: 300px; max-width: 400px;">Indikator</th>
                                    
                                </tr>
                            </thead>
                            <tbody>

                            
                                <?php 

                                $bulanNow = (int) date('m'); // Mengambil bulan saat ini secara dinamis (misal: 2)
                                $tglNow   = (int) date('d'); // Mengambil tanggal saat ini secara dinamis
                                $bulan_lalu = $bulanNow-1;
                                $tanggal_bulan_validasi = strtotime('first day of previous month');
                                $bulan_validasi = (int) date('n', $tanggal_bulan_validasi);
                                $tahun_bulan_validasi = (int) date('Y', $tanggal_bulan_validasi);
                            

                                
                                if (!empty($list_renkin)): ?>
                                    <?php foreach ($list_renkin as $index => $row):
                                        $satuan = $row->satuan;
                                         $status = $row->status;
                                        $explod = explode(" ", $satuan);
                                        $suku_kata = count($explod);
                                        if($suku_kata==1){
                                            $satuan_target = $satuan;
                                        }else{
                                            $satuan_target = $explod[1];
                                        }


                                        $detail_by_month = array();
                                        foreach ($this->rm->getRenkinDetail($row->id) as $detail) {
                                            $detail_by_month[(int) $detail->bulan] = $detail;
                                        }
                                        $monthly_targets = array();
                                        for ($month = 1; $month <= 12; $month++) {
                                            $monthly_targets[$month] = isset($detail_by_month[$month]) ? $detail_by_month[$month]->target : 0;
                                        }

                                        $bulan_ringkasan = null;
                                        if ((int) $tahun_renkin === $tahun_bulan_validasi) {
                                            $bulan_ringkasan = $bulan_validasi;
                                        } elseif ((int) $tahun_renkin < (int) date('Y')) {
                                            for ($candidate_month = 12; $candidate_month >= 1; $candidate_month--) {
                                                if (!isset($detail_by_month[$candidate_month])) {
                                                    continue;
                                                }

                                                $candidate_detail = $detail_by_month[$candidate_month];
                                                if ((float) $candidate_detail->realisasi > 0 || (float) $candidate_detail->validasi > 0 || (int) $candidate_detail->status === 1) {
                                                    $bulan_ringkasan = $candidate_month;
                                                    break;
                                                }
                                            }
                                        }

                                        $detail_ringkasan = $bulan_ringkasan !== null && isset($detail_by_month[$bulan_ringkasan]) ? $detail_by_month[$bulan_ringkasan] : null;
                                        $realisasi_ringkasan = $detail_ringkasan ? (float) $detail_ringkasan->realisasi : 0;
                                        $validasi_ringkasan = $detail_ringkasan ? (float) $detail_ringkasan->validasi : 0;
                                        $capaian_ringkasan = $realisasi_ringkasan > 0 ? round(($validasi_ringkasan / $realisasi_ringkasan) * 100) : 0;
                                        $status_ringkasan = $detail_ringkasan && (int) $detail_ringkasan->status === 1 ? 'Sudah divalidasi' : ($realisasi_ringkasan > 0 ? 'Menunggu validasi' : 'Belum ada input');
                                        $class_status_ringkasan = $detail_ringkasan && (int) $detail_ringkasan->status === 1 ? 'bg-success-subtle text-success' : ($realisasi_ringkasan > 0 ? 'bg-warning-subtle text-warning' : 'bg-light text-muted');

                                         $show_tombol_validasi = false;

                                        if($status==1){
                                            $show_tombol_validasi = true;
                                        }

                                        ?>
                                       
                                          <tr>
                                           
                                            <td class="text-start text-wrap lh-sm">
                                                <div class="renkin-indikator-header">
                                                    <div class="renkin-indikator-info">
                                                        <span class="fw-semibold"> <?= $index + 1 ?>.  <?= htmlspecialchars($row->indikator, ENT_QUOTES, 'UTF-8') ?></span>
                                                        <div class="my-2"> Satuan :
                                                            <span class="text-amber fw-semibold"> <?= htmlspecialchars($row->satuan, ENT_QUOTES, 'UTF-8') ?></span>
                                                        </div>
                                                        <div class="text-muted"> Target Tahunan :
                                                            <span class="text-amber fw-semibold"> <?= number_format((float) $row->target_tahunan, 0, ',', '.') ?> </span> &nbsp;
                                                            <span class="fw-"> ( <?=$satuan_target;?> ) </span>
                                                        </div>
                                                        <div class="renkin-last-input border border-success p-2 rounded">
                                                            <span class="fw-semibold">Input terakhir<?= $bulan_ringkasan !== null ? ' · ' . htmlspecialchars(getBulan($bulan_ringkasan), ENT_QUOTES, 'UTF-8') : '' ?>:</span>
                                                            <?php if ($detail_ringkasan): ?>
                                                                <span>Realisasi <strong><?= number_format($realisasi_ringkasan, 0, ',', '.') ?></strong></span> |
                                                                <span>Validasi <strong><?= number_format($validasi_ringkasan, 0, ',', '.') ?></strong></span> | 
                                                                <span>Capaian <strong><?= number_format($capaian_ringkasan, 0, ',', '.') ?>%</strong></span> | 
                                                            <?php else: ?>
                                                                <span>Belum ada input</span>
                                                            <?php endif; ?>
                                                            <span class="badge <?= $class_status_ringkasan ?>"><?= $status_ringkasan ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="renkin-indikator-actions">
                                                        <div class="action-container">
                                                        <?php if ($show_tombol_validasi): ?>
                                                            <button type="button" class="btn btn-success btn-sm shadow-sm setujui-target-renkin" data-id="<?=$row->id;?>">
                                                                <i class="fas fa-check-double me-1"></i> Setujui
                                                            </button>
                                                            <button type="button" class="btn btn-danger btn-sm shadow-sm tolak-target-renkin" data-id="<?=$row->id;?>">
                                                                <i class="fas fa-x me-1"></i> Revisi
                                                            </button>
                                                        <?php else: ?>
                                                            <button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                                                                <i class="fas fa-check-circle me-1"></i> Target Renkin Sudah Divalidasi
                                                            </button>
                                                        <?php endif; ?>
                                                        </div>
                                                        <button type="button" class="btn btn-outline-secondary btn-sm renkin-toggle" data-bs-toggle="collapse" data-bs-target="#renkin-bulanan-<?= (int) $row->id ?>" aria-expanded="false" aria-controls="renkin-bulanan-<?= (int) $row->id ?>" aria-label="Tampilkan detail bulanan">
                                                            <i class="fas fa-chevron-down"></i>
                                                        </button>
                                                    </div>
                                                </div>


                                           
                                                   
                                                   <div class="collapse mt-3" id="renkin-bulanan-<?= (int) $row->id ?>">
                                                       <div class="row g-2">

                                                            <?php for ($month = 1; $month <= 12; $month++): 
                                                                
                                                                $detail = isset($detail_by_month[$month]) ? $detail_by_month[$month] : null; 
                                                                $validasi = isset($detail_by_month[$month]) ? (int) $detail_by_month[$month]->validasi : 0;
                                                                $status_validasi = isset($detail_by_month[$month]) ? (int) $detail_by_month[$month]->status : 0;
                                                    
                                                                $realisasi = isset($detail_by_month[$month]) ? (float) $detail_by_month[$month]->realisasi : 0;
                                                                $target_bln = isset($detail_by_month[$month]) ? htmlspecialchars($detail_by_month[$month]->target, ENT_QUOTES, 'UTF-8') : 0;

                                                                                                                            
                                                                if ($realisasi == 0) {
                                                                    $persen_capaian = 0;
                                                                } else {
                                                                    $persen_capaian = round(($validasi / $realisasi) * 100);
                                                                }

                                                                // Styling visual persentase capaian
                                                                if($persen_capaian == 0) {
                                                                    $text_capaian = "text-muted opacity-50"; 
                                                                    $badge_capaian = "bg-light text-muted border";
                                                                } elseif($persen_capaian >= 100) {
                                                                    $text_capaian = "text-success fw-bold";
                                                                    $badge_capaian = "bg-success text-white";
                                                                } else {
                                                                    $text_capaian = "text-warning fw-bold";
                                                                    $badge_capaian = "bg-warning text-dark";
                                                                }

                                                                if($bulan_lalu== $month){
                                                                    $class_border = 'border-primary';
                                                                }else{
                                                                    if($bulan_lalu < $month){
                                                                          $class_border = 'border-rose';
                                                                    }else{
                                                                          $class_border = 'border-success';
                                                                    }
                                                                   
                                                                }

                                                            ?>
                                                                
                                                                <div class="col-md-3 mb-3">

                                                                    <div class="p-2 border <?= $class_border; ?> rounded h-100">
                                                                            <div class="mb-1 p-2 text-primary "><strong> <?= getBulan($month) ?>  </strong>
                                                                                <div class="text-dark">
                                                                                Target : <span class="text-amber fw-semibold"> <?= $target_bln ?></span> &nbsp;
                                                                                <span class="text-muted"> <?= $satuan_target?></span>
                                                                            </div>
                                                                        </div>
                                                                            
                                                                            <!-- Bungkus data angka agar bisa di-justify rata kanan -->
                                                                            <div class="text-muted  py-2 border-top ">
                                                                                
                                                                            
                                                                                <div>   
                                                                                    <table class="table-sm">
                                                                                        <tr>
                                                                                            <td>Realisasi</td>
                                                                                            <td>:</td>
                                                                                            <td class="fw-semibold text-dark"><?=$realisasi;?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Validasi</td>
                                                                                            <td>:</td>
                                                                                            <td class="fw-semibold text-primary"><?=$validasi;?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td>Capaian</td>
                                                                                            <td>:</td>
                                                                                            <td class="fw-semibold text-primary"><?=$persen_capaian;?> % </td>
                                                                                        </tr>
                                                                                    </table>
                                                                                
                                                                                </div>       
                                                                                <?php if ((int) $tahun_renkin === $tahun_bulan_validasi && (int) $month === $bulan_validasi): ?>
                                                                                    <?php if ($status_validasi !== 1): ?>
                                                                                        <button type="button" class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal" data-bs-target="#modalValidasiBulananRenkin" data-id-renkin="<?= (int) $row->id ?>" data-bulan="<?= (int) $month ?>" data-nama-bulan="<?= htmlspecialchars(getBulan($month), ENT_QUOTES, 'UTF-8') ?>" data-target="<?= htmlspecialchars((string) $target_bln, ENT_QUOTES, 'UTF-8') ?>" data-realisasi="<?= htmlspecialchars((string) $realisasi, ENT_QUOTES, 'UTF-8') ?>" data-satuan="<?= htmlspecialchars($satuan_target, ENT_QUOTES, 'UTF-8') ?>">
                                                                                            <i class="fas fa-check me-1"></i> Validasi Bulan
                                                                                        </button>
                                                                                    <?php else: ?>
                                                                                        <span class="badge bg-success-subtle text-success mt-2">Sudah divalidasi</span>
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                            </div>
                                                                         </div>
                                                                </div>

                                                        
                                                                
                                                           <?php endfor;?>
                                                       </div>
                                                   </div>

                                                      
                                        
                                           </td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="16" class="text-center py-4 text-muted">Data Rencana Kinerja Kosong.</td>
                            </tr>
                        <?php endif; ?>

                    </div>

                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="modalValidasiBulananRenkin" tabindex="-1" aria-labelledby="modalValidasiBulananRenkinLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <form action="<?= site_url('admin/penilaian_kinerja/proses_validasi_bulanan_renkin') ?>" method="post">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalValidasiBulananRenkinLabel">Validasi Renkin Bulanan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id_renkin" id="validasi-bulanan-id-renkin">
                                <input type="hidden" name="id_pegawai" value="<?= (int) $id_pegawai ?>">
                                <input type="hidden" name="tahun" value="<?= (int) $tahun_renkin ?>">
                                <input type="hidden" name="bulan" id="validasi-bulanan-bulan">

                                <h6 class="fw-semibold mb-3" id="validasi-bulanan-nama"></h6>
                                <div class="row g-2 mb-3">
                                    <div class="col-6">
                                        <div class="border rounded p-2 h-100">
                                            <small class="text-muted d-block">Target</small>
                                            <strong id="validasi-bulanan-target"></strong>
                                            <span class="text-muted" id="validasi-bulanan-satuan-target"></span>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="border rounded p-2 h-100">
                                            <small class="text-muted d-block">Realisasi</small>
                                            <strong id="validasi-bulanan-realisasi"></strong>
                                            <span class="text-muted" id="validasi-bulanan-satuan-realisasi"></span>
                                        </div>
                                    </div>
                                </div>
                                <label for="validasi-bulanan-nilai" class="form-label">Angka Validasi</label>
                                <input type="number" class="form-control" id="validasi-bulanan-nilai" name="validasi" min="0" step="any" required>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Validasi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

                        <!-- Modal Validasi Renkin -->
            <div class="modal fade" id="modalValidasiRenkin" tabindex="-1" aria-labelledby="modalValidasiLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 shadow">
                        
                        <!-- Header Modal -->
                        <div class="modal-header bg-light">
                            <h5 class="modal-title fw-bold text-dark" id="modalValidasiLabel">Validasi Rencana Kinerja (Renkin)</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <!-- Form Validasi -->
                        <form action="<?=site_url();?>admin/penilaian_kinerja/proses_validasi_renkin" method="POST" id="formValidasiRenkin">
                            <div class="modal-body py-4">
                                
                              <input type="hidden" name="id_pegawai" value="<?=$id_pegawai;?>">
                               <input type="hidden" name="tahun" value="<?=$tahun;?>">
                                <!-- Pilihan Status (Radio Button Card Style agar Rapi) -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold text-muted d-block mb-2">Pilih Tindakan Validasi :</label>
                                    <div class="row g-2">
                                        <!-- Opsi Setujui -->
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="status_validasi" id="statusSetuju" value="2" checked autocomplete="off">
                                            <label class="btn btn-outline-success w-100 py-3 fw-semibold d-flex flex-column align-items-center gap-1" for="statusSetuju">
                                                <i class="fas fa-check-circle fs-4"></i> Setujui
                                            </label>
                                        </div>
                                        <!-- Opsi Revisi -->
                                        <div class="col-6">
                                            <input type="radio" class="btn-check" name="status_validasi" id="statusRevisi" value="4" autocomplete="off">
                                            <label class="btn btn-outline-danger w-100 py-3 fw-semibold d-flex flex-column align-items-center gap-1" for="statusRevisi">
                                                <i class="fas fa-exclamation-triangle fs-4"></i> Revisi
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Catatan / Alasan -->
                                <div class="mb-2">
                                    <label for="alasan_validasi" class="form-label fw-semibold text-muted">
                                        Catatan / Alasan <span class="text-muted fw-normal">(Opsional)</span>
                                    </label>
                                    <textarea class="form-textarea form-control" id="alasan_validasi" name="alasan_validasi" rows="4" placeholder="Tuliskan catatan atau alasan di sini jika diperlukan..."></textarea>
                                </div>
                                
                            </div>
                            
                            <!-- Footer Modal -->
                            <div class="modal-footer bg-light border-top-0">
                                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary px-4 fw-semibold">Simpan Validasi</button>
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
     $(document).ready(function() {

                $('#modalValidasiBulananRenkin').on('show.bs.modal', function(event) {
                    const button = $(event.relatedTarget);
                    const modal = $(this);

                    modal.find('#validasi-bulanan-id-renkin').val(button.data('id-renkin'));
                    modal.find('#validasi-bulanan-bulan').val(button.data('bulan'));
                    modal.find('#validasi-bulanan-nama').text('Bulan ' + button.data('nama-bulan'));
                    modal.find('#validasi-bulanan-target').text(button.data('target'));
                    modal.find('#validasi-bulanan-realisasi').text(button.data('realisasi'));
                    modal.find('#validasi-bulanan-satuan-target, #validasi-bulanan-satuan-realisasi').text(' ' + button.data('satuan'));
                    modal.find('#validasi-bulanan-nilai').val('');
                });

                // ----------------------------------------------------
                // 1. PROSES SETUJUI RENKIN
                // ----------------------------------------------------
                $(document).on('click', '.setujui-target-renkin', function() {
                    let btn = $(this);
                    let idRenkin = btn.data('id');
                    let container = btn.closest('.action-container'); // Container pembungkus tombol

                    Swal.fire({
                        title: 'Konfirmasi Persetujuan',
                        text: 'Apakah Anda yakin ingin menyetujui target renkin ini?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#198754',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-check me-1"></i> Ya, Setujui',
                        cancelButtonText: 'Batal',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Tampilkan loading saat AJAX berjalan
                            Swal.fire({
                                title: 'Memproses...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => { Swal.showLoading(); }
                            });

                            $.ajax({
                                url: '<?= site_url("admin/penilaian_kinerja/validasi_setujui"); ?>', // Sesuaikan URL controller Anda
                                type: 'POST',
                                data: {
                                    id: idRenkin,
                                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: response.message || 'Target renkin berhasil disetujui.',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });

                                        // Ubah tombol di UI menjadi terdisable & terupdate
                                        renderDisabledButton(container, 'disetujui');
                                    } else {
                                        Swal.fire('Gagal!', response.message || 'Terjadi kesalahan sistem.', 'error');
                                    }
                                },
                                error: function() {
                                    Swal.fire('Error!', 'Gagal menghubungkan ke server.', 'error');
                                }
                            });
                        }
                    });
                });

                // ----------------------------------------------------
                // 2. PROSES REVISI / TOLAK RENKIN (DENGAN TEXTAREA)
                // ----------------------------------------------------
                $(document).on('click', '.tolak-target-renkin', function() {
                    let btn = $(this);
                    let idRenkin = btn.data('id');
                    let container = btn.closest('.action-container');

                    Swal.fire({
                        title: 'Revisi Target Renkin',
                        html: '<p class="text-muted small mb-2">Masukkan alasan revisi/penolakan agar pegawai dapat melakukan perbaikan:</p>',
                        input: 'textarea',
                        inputPlaceholder: 'Tuliskan alasan revisi di sini...',
                        inputAttributes: {
                            'aria-label': 'Tuliskan alasan revisi di sini',
                            'rows': 4
                        },
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: '<i class="fas fa-paper-plane me-1"></i> Kirim Revisi',
                        cancelButtonText: 'Batal',
                        reverseButtons: true,
                        inputValidator: (value) => {
                            if (!value || !value.trim()) {
                                return 'Alasan revisi wajib diisi!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            let alasanRevisi = result.value;

                            Swal.fire({
                                title: 'Memproses...',
                                text: 'Mohon tunggu sebentar',
                                allowOutsideClick: false,
                                didOpen: () => { Swal.showLoading(); }
                            });

                            $.ajax({
                                url: '<?= site_url("admin/penilaian_kinerja/validasi_revisi"); ?>', // Sesuaikan URL controller Anda
                                type: 'POST',
                                data: {
                                    id: idRenkin,
                                    alasan: alasanRevisi,
                                    <?= $this->security->get_csrf_token_name(); ?>: '<?= $this->security->get_csrf_hash(); ?>'
                                },
                                dataType: 'json',
                                success: function(response) {
                                    if (response.status === 'success') {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: response.message || 'Catatan revisi berhasil dikirim.',
                                            timer: 1500,
                                            showConfirmButton: false
                                        });

                                        // Ubah tombol di UI menjadi terdisable & terupdate
                                        renderDisabledButton(container, 'revisi');
                                    } else {
                                        Swal.fire('Gagal!', response.message || 'Terjadi kesalahan sistem.', 'error');
                                    }
                                },
                                error: function() {
                                    Swal.fire('Error!', 'Gagal menghubungkan ke server.', 'error');
                                }
                            });
                        }
                    });
                });

                // Helper Function untuk mengubah tombol menjadi Disabled Badge/Button
                function renderDisabledButton(container, status) {
                    let badgeClass = status === 'disetujui' ? 'btn-outline-success' : 'btn-outline-warning';
                    let statusText = status === 'disetujui' ? 'Disetujui' : 'Direvisi';
                    let iconClass  = status === 'disetujui' ? 'fa-check-circle' : 'fa-exclamation-circle';

                    let htmlDisabled = `
                        <button type="button" class="btn ${badgeClass} btn-sm" disabled>
                            <i class="fas ${iconClass} me-1"></i> Sudah Divalidasi (${statusText})
                        </button>
                        <div class="clearfix"></div>
                    `;
                    
                    container.html(htmlDisabled);
                }

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