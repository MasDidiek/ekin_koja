<?php
    $usergroup = $this->session->userdata('usergroup');
   if($usergroup==3 || $usergroup==4 ){
			
		  $group = 'kapustu';
		}else if($usergroup==1){ //Kapuskec
		   $group = 'Kapuskec';
		}else if($usergroup==2){
			//ktu
      $group = 'ktu';
    }
?>
<?php if (empty($cuti)): ?>
  <p class="text-muted">Tidak ada pegawai cuti pada tanggal ini</p>
<?php else: ?>
  <ul class="list-group">
    <?php foreach ($cuti as $c): ?>

      <?php
        $statusText = ucfirst($c->status_akhir);
        $statusColor = ($c->status_akhir == 'disetujui') ? 'success' : 'warning';

        if ($c->status_akhir == 'proses' && !empty($c->role_approval)) {
            $statusText .= ' – ' . labelRoleApproval($c->role_approval);
        }
      ?>

      <li class="list-group-item">
        <strong><?= $c->nama ?></strong><br>
        <small>
          <?= $c->jenis_cuti ?><br>
          <?= date('d M Y', strtotime($c->tgl_mulai)) ?>
          s/d
          <?= date('d M Y', strtotime($c->tgl_selesai)) ?><br>
          Alasan Cuti :
          <strong><?= $c->alasan_cuti ?></strong><br>

          Status:
          <span class="badge bg-<?= $statusColor ?>">
            <?= $statusText ?>
          </span>
        </small>

        <?php if (
            $c->status_akhir == 'proses'
            && $c->role_approval == $group
        ): ?>
          <div class="mt-2">
            <button
              class="btn btn-sm btn-success"
              onclick="approveCutiAjax(<?= $c->id ?>, '<?= $group ?>')">
              Approve
            </button>

            <button
              class="btn btn-sm btn-danger btn-reject"
              data-id="<?= $c->id ?>">
              Tolak
            </button>
          </div>
        <?php endif; ?>

      </li>
    <?php endforeach; ?>
  </ul>
<?php endif; ?>





