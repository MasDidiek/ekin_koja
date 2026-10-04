<?php if (empty($cuti)): ?>
  <p class="text-muted">Tidak ada pegawai cuti pada tanggal ini</p>
<?php else: ?>
  <ul class="list-group">
    <?php foreach ($cuti as $c): ?>
      <li class="list-group-item">
        <strong><?= $c->nama ?></strong><br>
        <small>
          <?= $c->jenis_cuti ?><br>
          <?= date('d M Y', strtotime($c->tgl_mulai)) ?>
          s/d
          <?= date('d M Y', strtotime($c->tgl_selesai)) ?><br>
          Status:
          <span class="badge badge-<?= $c->status_akhir == 'disetujui' ? 'success' : 'info' ?>">
            <?= ucfirst($c->status_akhir) ?>
          </span>
        </small>
      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>
