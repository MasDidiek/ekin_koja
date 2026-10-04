<?php


$tgl_masuk = $pegawai[0]->tgl_masuk;
$nip = $pegawai[0]->nip;
$nama_pegawai = $pegawai[0]->nama;
$id_pegawai = $pegawai[0]->id_pegawai;


$sisaTahunLalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
$sisaTahunIni = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');
$sisaCuber = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 3, 'DESC');

$sisaCutiAll = $sisaTahunLalu + $sisaTahunIni + $sisaCuber;


$tahun_ini = date('Y');
$tahun_lalu = $tahun_ini - 1;
?>

<div class="row">
  <div class="row g-3">

  <!-- Card 1: Sisa Cuti Tahun Lalu -->
  <div class="col-lg-3 col-md-6">
    <div class="card border border-light-subtle shadow-sm rounded-3">
      <div class="card-body p-3">
      
        <div class="d-flex align-items-center">
          <div class="rounded-circle text-white d-flex align-items-center justify-content-center bg-warning" style="width: 48px; height: 48px;">
            <i class="ti ti-credit-card fs-4"></i>
          </div>
          <div class="ms-3">
            <h3 class="mb-0 fw-bold fs-4">
              <span id="display_cuti1"><?= $sisaTahunLalu; ?></span> <small class="fs-6 text-muted">hari</small>
            </h3>
            <span class="text-muted small">Sisa Cuti Tahun <?= $tahun_lalu; ?></span>
          </div>
        </div>

      
      </div>
    </div>
  </div>

  <!-- Card 2: Sisa Cuti Tahun Ini -->
  <div class="col-lg-3 col-md-6">
    <div class="card border border-light-subtle shadow-sm rounded-3">
      <div class="card-body p-3">
      
        <div class="d-flex align-items-center">
          <div class="rounded-circle text-white d-flex align-items-center justify-content-center bg-info" style="width: 48px; height: 48px;">
            <i class="ti ti-users fs-4"></i>
          </div>
          <div class="ms-3">
            <h3 class="mb-0 fw-bold fs-4">
              <span id="display_cuti2"><?= $sisaTahunIni; ?></span> <small class="fs-6 text-muted">hari</small>
            </h3>
            <span class="text-muted small">Sisa Cuti Tahun <?= $tahun_ini; ?></span>
          </div>
        </div>

       
      </div>
    </div>
  </div>

  <!-- Card 3: Hak Cuti Bersama -->
  <div class="col-lg-3 col-md-6">
    <div class="card border border-light-subtle shadow-sm rounded-3">
      <div class="card-body p-3">
       
        <div class="d-flex align-items-center">
          <div class="rounded-circle text-white d-flex align-items-center justify-content-center bg-danger" style="width: 48px; height: 48px;">
            <i class="ti ti-calendar fs-4"></i>
          </div>
          <div class="ms-3">
            <h3 class="mb-0 fw-bold fs-4">
              <span id="display_cuti3"><?= $sisaCuber; ?></span> <small class="fs-6 text-muted">hari</small>
            </h3>
            <span class="text-muted small">Hak Cuti Bersama</span>
          </div>
        </div>

      
      </div>
    </div>
  </div>

   <!-- Card 2: Sisa Cuti Tahun Ini -->
  <div class="col-lg-3 col-md-6">
    <div class="card border border-info-subtle shadow-sm rounded-3">
      <div class="card-body p-3">
              
        <div class="d-flex align-items-center">
          <div class="rounded-circle text-white d-flex align-items-center justify-content-center bg-info" style="width: 48px; height: 48px;">
            <i class="ti ti-users fs-4"></i>
          </div>
          <div class="ms-3">
            <h3 class="mb-0 fw-bold fs-4">
              <span id="display_cuti2"><?= $sisaCutiAll; ?></span> <small class="fs-6 text-muted">hari</small>
            </h3>
            <span class="text-muted small">Total hak Cuti</span>
          </div>
        </div>

      
      </div>
    </div>
  </div>

  
</div>
  <!-- Column -->

  <!-- Column -->



       <table class="table align-middle text-center table-bordered text-nowrap mb-0" id="data-table">
            <thead>
              <tr class="text-muted fw-semibold">
                <th>No</th>
                <th>Tanggal Pengajuan</th>
                <th scope="col">Jenis Cuti</th>
                <th scope="col">Tanggal Mulai</th>
                <th scope="col">Tanggal Akhir</th>
                <th scope="col">Lama Cuti</th>
                <th class="text-start" scope="col">Alasan</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
              </tr>
            </thead>
            <tbody class="border-top">
              <?php if (!empty($history)): ?>
                <?php 
                // Mapping jenis cuti
                $list_jenis_cuti = [
                    1 => 'Cuti Tahunan',
                    2 => 'Cuti Bersalin',
                    3 => 'Cuti Alasan Penting',
                    4 => 'Cuti Sakit',
                    5 => 'Cuti Besar',
                    6 => 'Cuti Bersalin Anak ke-3'
                ];

                $no = 1;
                foreach ($history as $row): 
                  // Ambil nama jenis cuti
                 $nama_jenis_cuti = (isset($list_jenis_cuti[$row->jenis_cuti]) && $list_jenis_cuti[$row->jenis_cuti] != '') 
                ? $list_jenis_cuti[$row->jenis_cuti] 
                : 'Cuti Lainnya';

                  // Badge Status Styling
                  $status = strtolower($row->status_akhir);
                  if ($status == 'proses') {
                      $badge_status = '<span class="badge bg-warning-subtle text-warning px-2 py-1">Proses</span>';
                  } elseif ($status == 'disetujui' || $status == 'acc') {
                      $badge_status = '<span class="badge bg-success-subtle text-success px-2 py-1">Disetujui</span>';
                  } elseif ($status == 'ditolak') {
                      $badge_status = '<span class="badge bg-danger-subtle text-danger px-2 py-1">Ditolak</span>';
                  } else {
                      $badge_status = '<span class="badge bg-secondary-subtle text-secondary px-2 py-1">' . ucfirst($status) . '</span>';
                  }
                ?>
                  <tr>
                    <td><?= $no++ ?></td>
                    <td><?= format_semi($row->tgl_pengajuan) ?></td>
                    <td><span class="fw-semibold text-dark"><?= $nama_jenis_cuti ?></span></td>
                    <td><?= format_semi($row->tgl_mulai) ?></td>
                    <td><?= format_semi($row->tgl_selesai) ?></td>
                    <td><?= $row->lama_cuti ?> Hari</td>
                    <td class="text-start"><?= htmlspecialchars($row->alasan_cuti) ?></td>
                    <td><?= $badge_status ?></td>
                    <td>
                      <a href="<?= base_url('admin/pegawai/detail_cuti/' . $row->id) ?>" class="btn btn-sm btn-info text-white">
                        <i class="ti ti-eye me-1"></i> Detail
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="9" class="text-muted">Belum ada riwayat pengajuan cuti.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
      </div>

