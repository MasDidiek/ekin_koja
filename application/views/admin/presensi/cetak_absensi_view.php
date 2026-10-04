<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Absensi - <?= htmlspecialchars($pegawai->nama); ?></title>
  <style>
    body {
      font-family: Arial, sans-serif;
      font-size: 12px;
      color: #333;
      margin: 20px;
    }
    .header-cetak {
      text-align: center;
      margin-bottom: 20px;
      border-bottom: 2px solid #333;
      padding-bottom: 10px;
    }
    .header-cetak h2 {
      margin: 0;
      font-size: 18px;
      text-transform: uppercase;
    }
    .header-cetak p {
      margin: 2px 0;
    }
    .info-pegawai {
      width: 100%;
      margin-bottom: 15px;
    }
    .info-pegawai td {
      padding: 3px 5px;
      vertical-align: top;
    }
    .table-data {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }
    .table-data th, .table-data td {
      border: 1px solid #666;
      padding: 5px;
      text-align: center;
    }
    .table-data th {
      background-color: #f2f2f2;
      font-weight: bold;
    }
    .text-left { text-align: left !important; }
    .footer-ttd {
      width: 100%;
      margin-top: 30px;
    }
    .footer-ttd td {
      text-align: center;
      vertical-align: bottom;
      height: 80px;
    }
    @media print {
      @page {
        size: A4 portrait;
        margin: 10mm;
      }
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body onload="window.print()">

  <div class="no-print" style="margin-bottom: 15px;">
    <button onclick="window.print()" style="padding: 8px 15px; cursor: pointer;">Cetak Laporan</button>
    <button onclick="window.close()" style="padding: 8px 15px; cursor: pointer;">Tutup</button>
  </div>

  <div class="header-cetak">
    <h2>Laporan Presensi Pegawai</h2>
    <p><strong><?= htmlspecialchars($puskesmas); ?></strong></p>
    <p>Periode: <?= date('F Y', strtotime($periode)); ?></p>
  </div>

  <table class="info-pegawai">
    <tr>
      <td width="15%"><strong>Nama Pegawai</strong></td>
      <td width="2%">:</td>
      <td width="33%"><?= htmlspecialchars($pegawai->nama); ?></td>
      <td width="15%"><strong>NIP / ID</strong></td>
      <td width="2%">:</td>
      <td width="33%"><?= htmlspecialchars($pegawai->nip); ?> / PIN: <?= htmlspecialchars($pin); ?></td>
    </tr>
    <tr>
      <td><strong>Jenis Kerja</strong></td>
      <td>:</td>
      <td><?= ($pegawai->jns_jam_kerja == 1) ? 'Shift' : 'Non-Shift'; ?></td>
      <td><strong>Tanggal Cetak</strong></td>
      <td>:</td>
      <td><?= date('d-m-Y H:i'); ?></td>
    </tr>
  </table>

  <table class="table-data">
    <thead>
      <tr>
        <th width="5%" rowspan="2">No</th>
        <th width="12%" rowspan="2">Tanggal</th>
        <th width="10%" rowspan="2">Hari</th>
        <th width="8%" rowspan="2">Shift</th>
        <th colspan="2">Jam Kerja</th>
        <th colspan="2">Jam Absen</th>
        <th width="8%" rowspan="2">Telat (m)</th>
        <th width="8%" rowspan="2">P. Awal (m)</th>
        <th rowspan="2">Keterangan</th>
      </tr>
      <tr>
        <th>Masuk</th>
        <th>Pulang</th>
        <th>Masuk</th>
        <th>Pulang</th>
      </tr>
    </thead>
    <tbody>
      <?php 
      $no = 1;
      $totalTelat = 0;
      $totalPawal = 0;

      if (!empty($absensiHarian)) :
        foreach ($absensiHarian as $row) :
          $totalTelat += $row->telat;
          $totalPawal += $row->p_awal;
      ?>
          <tr>
            <td><?= $no++; ?></td>
            <td><?= date('d-m-Y', strtotime($row->tanggal)); ?></td>
            <td><?= getNamahari($row->tanggal); ?></td>
            <td><?= htmlspecialchars($row->shift); ?></td>
            <td><?= $row->jam_masuk; ?></td>
            <td><?= $row->jam_pulang; ?></td>
            <td><?= $row->masuk ? $row->masuk : '-'; ?></td>
            <td><?= $row->pulang ? $row->pulang : '-'; ?></td>
            <td><?= $row->telat; ?></td>
            <td><?= $row->p_awal; ?></td>
            <td class="text-left"><?= htmlspecialchars($row->keterangan); ?></td>
          </tr>
      <?php 
        endforeach;
      else :
      ?>
        <tr>
          <td colspan="11">Tidak ada data absensi pada periode ini.</td>
        </tr>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="8" style="text-align: right;">Total :</th>
        <th><?= $totalTelat; ?></th>
        <th><?= $totalPawal; ?></th>
        <th></th>
      </tr>
    </tfoot>
  </table>

  <table class="footer-ttd">
    <tr>
      <td width="50%">
        Pegawai Yang Bersangkutan
        <br><br><br><br>
        <strong>( <?= htmlspecialchars($pegawai->nama); ?> )</strong><br>
        NIP. <?= htmlspecialchars($pegawai->nip); ?>
      </td>
      <td width="50%">
        Atasan / Validator
        <br><br><br><br>
        <strong>( ________________________ )</strong><br>
        NIP. 
      </td>
    </tr>
  </table>

</body>
</html>