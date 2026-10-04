<?php


$tgl_masuk = $pegawai[0]->tgl_masuk;
$nip = $pegawai[0]->nip;
$nama_pegawai = $pegawai[0]->nama;
$id_pegawai = $pegawai[0]->id_pegawai;


$tahun_ini = date('Y');
$tahun_lalu = $tahun_ini - 1;



$hakCutiTahunlalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, $tahun_lalu, 'tahunan');
$hakCutiTahunini  = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, $tahun_ini, 'tahunan');
$hakCutiBersama   = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, $tahun_ini, 'bersama');


//print_array($hakCutiTahunlalu);
$sisaTahunLalu = 0;
$sisaTahunIni = 0;
$sisaCutiBersama = 0;




$hakTotal1 = 0;
$hakTerpakai1 = 0;
$hakOnProses1 = 0;

$hakTotal2 = 0;
$hakTerpakai2 = 0;
$hakOnProses2 = 0;

if (!empty($hakCutiTahunlalu)) {
  $hakTotal1 = $hakCutiTahunlalu->hak_total;
  $hakTerpakai1 = $hakCutiTahunlalu->hak_terpakai;
  $hakOnProses1 = $hakCutiTahunlalu->hak_reserved;

  $sisaTahunLalu = $hakTotal1 - $hakTerpakai1 - $hakOnProses1;
}

//print_array($hakCutiTahunini);


if (!empty($hakCutiTahunini)) {
  $hakTotal2 = $hakCutiTahunini->hak_total;
  $hakTerpakai2 = $hakCutiTahunini->hak_terpakai;
  $hakOnProses2 = $hakCutiTahunini->hak_reserved;
  $sisaTahunIni = $hakTotal2 - $hakTerpakai2 - $hakOnProses2;
}



if (!empty($hakCutiBersama)) {
  $hakTotal3 = $hakCutiBersama->hak_total;
  $hakTerpakai3 = $hakCutiBersama->hak_terpakai;
  $hakOnProses3 = $hakCutiBersama->hak_reserved;
  $sisaCutiBersama = $hakTotal3 - $hakTerpakai3 - $hakOnProses3;
} else {
  $hakTotal3 = 0;
  $hakTerpakai3 = 0;
  $hakOnProses3 = 0;
}

$sisaCutiAll = $sisaTahunLalu + $sisaTahunIni + $sisaCutiBersama;

?>

<div class="row">
  <div class="row g-3">

    <!-- Card 1: Sisa Cuti Tahun Lalu -->
    <div class="col-lg-3 col-md-6">
      <div class="card border border-light-subtle shadow-sm rounded-3">
        <div class="card-body p-3">
          <button type="button" class="btn btn-sm btn-light text-primary float-end btn-toggle-edit" data-target=".input-cuti1" title="Edit Cuti">
            <i class="ti ti-pencil fs-5"></i>
          </button>

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

          <!-- Inline Edit Form -->
          <form method="post" action="<?= base_url('admin/pegawai/insert_sisa_cuti/' . $id_pegawai); ?>" class="form-update-cuti">
            <div class="input-cuti1 row g-2 mt-3 d-none">
              <div class="col-12">

                <table class="table text-center table-sm table-bordered">
                  <tr>
                    <th class="bg-info text-white">Hak</th>
                    <th class="bg-info text-white">Digunakan</th>
                    <th class="bg-info text-white">Proses</th>

                  </tr>
                  <tr>
                    <td> <input type="number" name="hak_total" id="hak_total" class="form-control" value="<?= $hakTotal1; ?>"> </td>
                    <td class="text-info"> <input type="number" name="used" class="form-control" id="used" value="<?= $hakTerpakai1; ?>"> </td>
                    <td class="text-warning"> <input type="number" name="process" class="form-control" id="process" value="<?= $hakOnProses1; ?>"> </td>

                  </tr>
                </table>


                <input type="hidden" name="jns_hak" value="tahunan">
                <input type="hidden" name="tahun" value="<?= $tahun_lalu; ?>">


                <button type="button" class="btn btn-sm btn-outline-danger  btn-cancel-edit" data-target=".input-cuti1" title="Batal">
                  <i class="ti ti-x fs-6"></i> Batal</button>
                <button type="submit" class="btn btn-sm btn-success float-end" title="Simpan"><i class="ti ti-check fs-6"></i> Simpan</button>
              </div>
            </div>
          </form>

          <div class="p-2 mt-2 border-1">
            <table class="table text-center table-sm table-bordered">
              <tr>
                <th>Hak</th>
                <th>Digunakan</th>
                <th>Proses</th>
                <th>Sisa</th>
              </tr>
              <tr>
                <td><?= $hakTotal1; ?></td>
                <td class="text-info"><?= $hakTerpakai1 ?></td>
                <td class="text-warning"><?= $hakOnProses1 ?></td>
                <td class="text-success"><?= $sisaTahunLalu ?></td>
              </tr>
            </table>
          </div>

        </div>
      </div>
    </div>

    <!-- Card 2: Sisa Cuti Tahun Ini -->
    <div class="col-lg-3 col-md-6">
      <div class="card border border-light-subtle shadow-sm rounded-3">
        <div class="card-body p-3">
          <button type="button" class="btn btn-sm btn-light text-info float-end btn-toggle-edit" data-target=".input-cuti2" title="Edit Cuti">
            <i class="ti ti-pencil fs-5"></i>
          </button>

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

          <!-- Inline Edit Form -->
          <form method="post" action="<?= base_url('admin/pegawai/insert_sisa_cuti/' . $id_pegawai); ?>" class="form-update-cuti">
            <div class="input-cuti2 row g-2 mt-3 d-none">
              <div class="col-12">

                <table class="table text-center table-sm table-bordered">
                  <tr>
                    <th class="bg-info text-white">Hak</th>
                    <th class="bg-info text-white">Digunakan</th>
                    <th class="bg-info text-white">Proses</th>

                  </tr>
                  <tr>
                    <td> <input type="number" name="hak_total" id="hak_total" class="form-control" value="<?= $hakTotal2; ?>"> </td>
                    <td class="text-info"> <input type="number" name="used" class="form-control" id="used" value="<?= $hakTerpakai2; ?>"> </td>
                    <td class="text-warning"> <input type="number" name="process" class="form-control" id="process" value="<?= $hakOnProses2; ?>"> </td>

                  </tr>
                </table>


                <input type="hidden" name="jns_hak" value="tahunan">
                <input type="hidden" name="tahun" value="<?= $tahun_ini; ?>">


                <button type="button" class="btn btn-sm btn-outline-danger  btn-cancel-edit" data-target=".input-cuti2" title="Batal">
                  <i class="ti ti-x fs-6"></i> Batal</button>
                <button type="submit" class="btn btn-sm btn-success float-end" title="Simpan"><i class="ti ti-check fs-6"></i> Simpan</button>
              </div>
            </div>
          </form>

          <div class="p-2 mt-2 border-1">
            <table class="table text-center table-sm table-bordered">
              <tr>
                <th>Hak</th>
                <th>Digunakan</th>
                <th>Proses</th>
                <th>Sisa</th>
              </tr>
              <tr>
                <td><?= $hakTotal2; ?></td>
                <td class="text-info"><?= $hakTerpakai2 ?></td>
                <td class="text-warning"><?= $hakOnProses2 ?></td>
                <td class="text-success"><?= $sisaTahunIni ?></td>
              </tr>
            </table>
          </div>

        </div>
      </div>
    </div>

    <!-- Card 3: Hak Cuti Bersama -->
    <div class="col-lg-3 col-md-6">
      <div class="card border border-light-subtle shadow-sm rounded-3">
        <div class="card-body p-3">
          <button type="button" class="btn btn-sm btn-light text-danger float-end btn-toggle-edit" data-target=".input-cuti3" title="Edit Cuti">
            <i class="ti ti-pencil fs-5"></i>
          </button>

          <div class="d-flex align-items-center">
            <div class="rounded-circle text-white d-flex align-items-center justify-content-center bg-danger" style="width: 48px; height: 48px;">
              <i class="ti ti-calendar fs-4"></i>
            </div>
            <div class="ms-3">
              <h3 class="mb-0 fw-bold fs-4">
                <span id="display_cuti3"><?= $sisaCutiBersama; ?></span> <small class="fs-6 text-muted">hari</small>
              </h3>
              <span class="text-muted small">Hak Cuti Bersama</span>
            </div>
          </div>

          <!-- Inline Edit Form -->
          <form method="post" action="<?= base_url('admin/pegawai/insert_sisa_cuti/' . $id_pegawai); ?>" class="form-update-cuti">
            <div class="input-cuti3 row g-2 mt-3 d-none">
              <div class="col-12">

                <table class="table text-center table-sm table-bordered">
                  <tr>
                    <th class="bg-info text-white">Hak</th>
                    <th class="bg-info text-white">Digunakan</th>
                    <th class="bg-info text-white">Proses</th>

                  </tr>
                  <tr>
                    <td> <input type="number" name="hak_total" id="hak_total" class="form-control" value="<?= $hakTotal3; ?>"> </td>
                    <td class="text-info"> <input type="number" name="used" class="form-control" id="used" value="<?= $hakTerpakai3; ?>"> </td>
                    <td class="text-warning"> <input type="number" name="process" class="form-control" id="process" value="<?= $hakOnProses3; ?>"> </td>

                  </tr>
                </table>


                <input type="hidden" name="jns_hak" value="bersama">
                <input type="hidden" name="tahun" value="<?= $tahun_ini; ?>">


                <button type="button" class="btn btn-sm btn-outline-danger  btn-cancel-edit" data-target=".input-cuti3" title="Batal">
                  <i class="ti ti-x fs-6"></i> Batal</button>
                <button type="submit" class="btn btn-sm btn-success float-end" title="Simpan"><i class="ti ti-check fs-6"></i> Simpan</button>

              </div>
            </div>
          </form>

          <div class="p-2 mt-2 border-1">
            <table class="table text-center table-sm table-bordered">
              <tr>
                <th>Hak</th>
                <th>Digunakan</th>
                <th>Proses</th>
                <th>Sisa</th>
              </tr>
              <tr>
                <td><?= $hakTotal3; ?></td>
                <td class="text-info"><?= $hakTerpakai3 ?></td>
                <td class="text-warning"><?= $hakOnProses3 ?></td>
                <td class="text-success"><?= $sisaCutiBersama ?></td>
              </tr>
            </table>
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

  <?php
  //print_array($cutiPegawai);
  ?>

  <table class="table align-middle text-center table-bordered text-nowrap mb-0" id="data-table">
    <thead>
      <tr class="text-muted fw-semibold">
        <th>No</th>
        <th>Tanggal Pengajuan</th>
        <th scope="col">Tahun Hak Cuti</th>
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
      <?php if (!empty($cutiPegawai)) : ?>
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
        foreach ($cutiPegawai as $row) :
          // Ambil nama jenis cuti
          $nama_jenis_cuti = (isset($list_jenis_cuti[$row->jenis_cuti]) && $list_jenis_cuti[$row->jenis_cuti] != '')
            ? $list_jenis_cuti[$row->jenis_cuti]
            : 'Cuti Lainnya';

          $tahun_hak_cuti = $row->tahun_hak_cuti;

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
            <td><?= $tahun_hak_cuti ?></td>
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
      <?php else : ?>
        <tr>
          <td colspan="9" class="text-muted">Belum ada riwayat pengajuan cuti.</td>
        </tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>