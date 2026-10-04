

<?php
$current = $this->uri->segment(2); // misalnya 'data_keluarga', 'dokumen', dll
?>
<div class="tab-list">
    <a href="<?= base_url('profile/my_profile') ?>" class="btn-tab <?= ($current == 'my_profile') ? 'tab-active' : '' ?>">Data Diri</a>
    <a href="<?= base_url('profile/data_keluarga') ?>" class="btn-tab <?= ($current == 'data_keluarga') ? 'tab-active' : '' ?>">Data Keluarga</a>
    <a href="<?= base_url('profile/riwayat_pendidikan') ?>" class="btn-tab <?= ($current == 'riwayat_pendidikan') ? 'tab-active' : '' ?>">Pendidikan</a>
    <a href="<?= base_url('profile/dokumen') ?>" class="btn-tab <?= ($current == 'dokumen') ? 'tab-active' : '' ?>">Dokumen</a>
    <a href="<?= base_url('profile/pelatihan') ?>" class="btn-tab <?= ($current == 'pelatihan') ? 'tab-active' : '' ?>">Pelatihan</a>
    <a href="<?= base_url('profile/uraian_tugas') ?>" class="btn-tab <?= ($current == 'uraian_tugas') ? 'tab-active' : '' ?>">Uraian Tugas</a>
</div>
