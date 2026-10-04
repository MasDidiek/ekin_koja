<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Laporan Absensi - <?= htmlspecialchars($data_pjlp[0]->nama); ?></title>
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

    <?php

                    //print_array($data_pjlp);
                    $id_pegawai = $data_pjlp[0]->id;
                    $id_pjlp = $data_pjlp[0]->id_pjlp;
                    $nama = $data_pjlp[0]->nama;
                    $jabatan = $data_pjlp[0]->jabatan;
                    $puskesmas = $data_pjlp[0]->lokasi_kerja;
                    $bagian_shift = $data_pjlp[0]->bagian_shift;

                    if($bagian_shift==0){
                        $jns_jam_kerja = 'Regular';
                    }else{
                        $jns_jam_kerja = 'Shift';
                    }
                    $periode_bulan = $this->session->userdata('periode_bulan');
                    $periode_tahun = $this->session->userdata('periode_tahun');

                    if ($periode_bulan == '') {
                        $periode_bulan = date('m');
                        $periode_tahun = date('Y');
                    }


                    //  echo $periode_bulan;
                    $periode = $periode_tahun . '-' . $periode_bulan;
                    $periode = date('Y-m', strtotime($periode));

                    $absensi_raw = $this->Presensi_model->getAbsenBulanan($id_pjlp, $periode);

                
                  ?>

            <div class="no-print" style="margin-bottom: 15px;">
                <button onclick="window.print()" style="padding: 8px 15px; cursor: pointer;">Cetak Laporan</button>
                <button onclick="window.close()" style="padding: 8px 15px; cursor: pointer;">Tutup</button>
            </div>

            <div class="header-cetak">
                <h2>Laporan Presensi Pegawai</h2>
            
                <p>Periode: <?= date('F Y', strtotime($periode)); ?></p>
            </div>

            <table class="info-pegawai">
                <tr>
                <td width="15%"><strong>Nama Pegawai</strong></td>
                <td width="2%">:</td>
                <td width="33%"><?= htmlspecialchars($nama); ?></td>
                <td width="15%"><strong>NIP / ID</strong></td>
                <td width="2%">:</td>
                <td width="33%"><?= $id_pjlp;?></td>
                </tr>
                <tr>
                    <td><strong>Jabatan</strong></td>
                    <td>:</td>
                    <td><?= $jabatan; ?></td>

                    <td><strong>Unit Kerja</strong></td>
                    <td>:</td>
                    <td><?= $puskesmas; ?></td>
                </tr>
                <tr>
            
                <td><strong>Jenis Jam Kerja</strong></td>
                <td>:</td>
                <td><?= $jns_jam_kerja; ?></td>
                <td><strong>Tanggal Cetak</strong></td>
                <td>:</td>
                <td><?= date('d-m-Y H:i'); ?></td>
                </tr>
            </table>

            <table class="table-data">
                 <thead>
                          <tr>
                            <th rowspan="2" class="text-center align-middle">Tanggal</th>
                            <th rowspan="2" class="text-center align-middle">Hari</th>
                            <th rowspan="2" class="text-center align-middle">Shift</th>
                            <th colspan="2" class="text-center">Jam Kerja</th>
                            <th colspan="2" class="text-center">Jam Absen</th>
                            <th rowspan="2" class="text-center align-middle">Telat</th>
                            <th rowspan="2" class="text-center align-middle">P. Awal</th>
                            <th rowspan="2" class="text-left align-middle">Keterangan</th>
                          </tr>
                          <tr>
                            <th class="text-center sub-header">Masuk</th>
                            <th class="text-center sub-header">Keluar</th>
                            <th class="text-center sub-header">Masuk</th>
                            <th class="text-center sub-header">Keluar</th>
                          </tr>
                        </thead>
                <tbody>
               <?php
                          $totalTelat  = 0;
                          $totalP_awal = 0;

                          for ($i = 0; $i < 31; $i++) {
                            $tgl = $i + 1;
                            $tanggal = format_db($periode . '-' . $tgl);
                            $hari = getNamahari($tanggal);
                            $dataAbsensi = $this->Presensi_model->getDataAbsensi($id_pjlp, $tanggal, "tbl_absensi_pjlp");

                            if (!empty($dataAbsensi)) {
                              $shift       = $dataAbsensi[0]->shift;
                              $jam_masuk   = $dataAbsensi[0]->jam_masuk;
                              $jam_pulang  = $dataAbsensi[0]->jam_pulang;
                              $masuk       = $dataAbsensi[0]->masuk;
                              $pulang      = $dataAbsensi[0]->pulang;
                              $telat       = $dataAbsensi[0]->telat;
                              $p_awal      = $dataAbsensi[0]->p_awal;
                              $keterangan  = $dataAbsensi[0]->keterangan;
                            } else {
                              $shift = $jam_masuk = $jam_pulang = $masuk = $pulang = $keterangan = '-';
                              $telat = 0;
                              $p_awal = 0;
                            }



                            $totalTelat += $telat;
                            $totalP_awal += $p_awal;

                            // Formatting Badge Status (Izin / Sakit)
                            $masuk_display = $masuk;
                            $pulang_display = $pulang;
                            if (in_array($masuk, ['IZIN', 'SAKIT'])) {
                              $masuk_display = '<span class="badge bg-warning-subtle text-warning fw-semibold">' . $masuk . '</span>';
                              $pulang_display = '<span class="badge bg-warning-subtle text-warning fw-semibold">' . $pulang . '</span>';
                            }
                            if ($masuk == 'CUTI') {
                              $masuk_display = '<span class="badge bg-success-subtle text-success fw-semibold">' . $masuk . '</span>';
                              $pulang_display = '<span class="badge bg-success-subtle text-success fw-semibold">' . $pulang . '</span>';
                            }

                           

                            // Penanda Akhir Pekan (Weekend Highlight)
                            $isWeekend = in_array($hari, ['Sabtu', 'Minggu', 'Saturday', 'Sunday']);
                            $rowClass = $isWeekend ? 'table-light-weekend' : '';
                          ?>
                            <tr class="<?= $rowClass; ?>">
                              <td class="text-center fw-medium"><?= format_view($tanggal); ?></td>
                              <td class="text-center"><?= $hari; ?></td>
                              <td class="text-center"><span class="badge bg-light text-dark border"><?= $shift; ?></span></td>
                              <td class="text-center text-muted"><?= $jam_masuk; ?></td>
                              <td class="text-center text-muted"><?= $jam_pulang; ?></td>
                              <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                  <span><?= $masuk_display; ?></span>
                                
                                </div>
                              </td>
                              <td class="text-center">
                                <div class="d-flex align-items-center justify-content-center">
                                  <span><?= $pulang_display; ?></span>
                                
                                </div>
                              </td>
                              <td class="text-center"><?= $telat > 0 ? '<span class="text-danger fw-bold">' . $telat . 'm</span>' : '-'; ?></td>
                              <td class="text-center"><?= $p_awal > 0 ? '<span class="text-warning fw-bold">' . $p_awal . 'm</span>' : '-'; ?></td>
                              <td class="text-start text-muted fs-2"><?= $keterangan; ?></td>
                            </tr>
                          <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <th colspan="7" style="text-align: right;">Total :</th>
                    <th><?= $totalTelat; ?></th>
                    <th><?= $totalP_awal; ?></th>
                    <th></th>
                </tr>
                </tfoot>
            </table>

            <table class="footer-ttd">
                <tr>
                <td width="50%">
                    Pegawai Yang Bersangkutan
                    <br><br><br><br>
                    <strong>( <?= htmlspecialchars($nama); ?> )</strong><br>
                    ID PJLP. <?= htmlspecialchars($id_pjlp); ?>
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