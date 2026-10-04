<!-- Container Form Penilaian Aktivitas -->
<form id="formPenilaianAktifitas" action="<?= base_url('admin/penilaian_kinerja/proses_aktifitas'); ?>" method="post">

  <!-- Action Bar: Tombol Setujui, Tolak & Info -->
  <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2 mb-3">
    <div class="text-muted small">
      <i class="ti ti-info-circle me-1"></i> Pilih/centang aktivitas yang ingin diproses.
    </div>
    <div class="d-flex gap-2">
      <!-- Tombol Tolak -->
      <button type="button" class="btn btn-danger btn-action" data-status="tolak">
        <i class="ti ti-x me-1"></i> Tolak Terpilih
      </button>
      <!-- Tombol Setujui -->
      <button type="button" class="btn btn-success btn-action" data-status="setujui">
        <i class="ti ti-check me-1"></i> Setujui Terpilih
      </button>
    </div>
  </div>

  <!-- Table List Aktivitas -->
  <div class="table-responsive custom-card">
    <table class="table  align-middle mb-0" id="tableAktifitas">
      <thead class="table-light text-center">
        <tr>
          <th class="text-start ps-3" style="width: 45%;">Kegiatan & Detail Aktivitas</th>
          <th style="width: 20%;">Volume x Waktu Efektif</th>
          <th style="width: 15%;">Total Waktu</th>
          <th style="width: 15%;">Status</th>
          <th style="width: 20%;" class="text-center">
            <!-- Checkbox Global Check All -->
            <div class="form-check d-flex justify-content-center align-items-center gap-1 m-0">
              <input type="checkbox" class="form-check-input" id="checkAllGlobal" style="cursor: pointer;">
              <label class="form-check-label fw-semibold small" for="checkAllGlobal" style="cursor: pointer;">Pilih Semua</label>
            </div>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($list)) : ?>
          <?php foreach ($list as $tanggal => $kegiatan) : ?>

            <!-- Header Baris Tanggal -->
            <tr class="table-subheading">
              <td colspan="5" class="fw-bold text-white  bg-primary py-2 ps-3">
                <i class="ti ti-calendar me-1"></i> <?= date('d F Y', strtotime($tanggal)); ?>
              </td>
            </tr>

            <!-- Detail Items Kegiatan per Tanggal -->
            <!-- Detail Items Kegiatan per Tanggal -->
            <?php foreach ($kegiatan as $row) : ?>
              <tr>
                <td class="ps-3">
                  <!-- Jam Mulai - Selesai -->
                  <div class="mb-1">
                    <span class="badge bg-primary-subtle text-primary fw-semibold">
                      <i class="ti ti-clock me-1"></i><?= date('H:i', strtotime($row->jam_mulai)); ?> - <?= date('H:i', strtotime($row->jam_selesai)); ?>
                    </span>
                  </div>

                  <!-- Indikator -->
                  <div class="fw-bold text-dark mb-1">
                    <?= htmlspecialchars(isset($row->indikator) ? $row->indikator : ''); ?>
                  </div>

                  <!-- Nama Kegiatan & Keterangan -->
                  <div class="text-muted small">
                    <div class="text-danger fw-semibold">
                      <?= htmlspecialchars(isset($row->nama_kegiatan) ? $row->nama_kegiatan : ''); ?>
                    </div>
                    <div class="text-wrap">
                      <?= nl2br(htmlspecialchars(isset($row->ket) ? $row->ket : '')); ?>
                    </div>
                  </div>
                </td>

                <!-- Volume x Waktu Efektif -->
                <td class="text-center">
                  <span class="fw-semibold text-dark"><?= isset($row->volume) ? $row->volume : 0; ?></span>
                  <span class="text-muted">x</span>
                  <span class="fw-semibold text-dark"><?= isset($row->waktu_efektif) ? $row->waktu_efektif : 0; ?> mnt</span>
                </td>

                <!-- Total -->
                <td class="text-center fw-bold text-primary">
                  <?= isset($row->total) ? $row->total : 0; ?> mnt
                </td>

                <!-- Status Aktivitas -->
                <td class="text-center">
                  <?php
                  $st = isset($row->status) ? $row->status : 0;
                  if ($st == 1) :
                  ?>
                    <span class="badge bg-success-subtle text-success px-2 py-1 border border-success-subtle fw-semibold">
                      <i class="ti ti-circle-check me-1"></i> Disetujui
                    </span>
                  <?php elseif ($st == 2) : ?>
                    <span class="badge bg-danger-subtle text-danger px-2 py-1 border border-danger-subtle fw-semibold">
                      <i class="ti ti-circle-x me-1"></i> Ditolak
                    </span>
                  <?php else : ?>
                    <span class="badge bg-warning-subtle text-warning px-2 py-1 border border-warning-subtle fw-semibold">
                      <i class="ti ti-clock me-1"></i> Belum divalidasi
                    </span>
                  <?php endif; ?>
                </td>

                <!-- Checkbox Item -->
                <td class="text-center">
                  <div class="form-check d-flex justify-content-center m-0">
                    <input type="checkbox" class="form-check-input check-item" name="check_aktifitas[]" value="<?= isset($row->id) ? $row->id : ''; ?>" style="cursor: pointer; width: 1.25rem; height: 1.25rem;">
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>

          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="4" class="text-center text-muted py-4">
              <i class="ti ti-clipboard-x fs-2 d-block mb-2"></i>
              Tidak ada aktivitas pegawai yang perlu dinilai saat ini.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</form>