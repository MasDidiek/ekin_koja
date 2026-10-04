<!DOCTYPE html>
<html>

<head>
  <title>Data Gaji Pegawai</title>
</head>

<body>
  <style type="text/css">
    body {
      font-family: sans-serif;
    }

    table {
      margin: 20px auto;
      border-collapse: collapse;
    }

    table th,
    table td {
      border: 1px solid #3c3c3c;
      padding: 3px 8px;

    }

    a {
      background: blue;
      color: #fff;
      padding: 8px 10px;
      text-decoration: none;
      border-radius: 2px;
    }
  </style>

  <?php
  header("Content-type: application/vnd-ms-excel");
  header("Content-Disposition: attachment; filename=Data Gaji Pegawai PJLP.xls");


  $periode_bulan = $this->session->userdata('periode_bulan');
  $periode_tahun = $this->session->userdata('periode_tahun');

  if ($periode_bulan == '') {
    $periode_bulan = date('m');
    $periode_tahun = date('Y');
  }


  //  echo $periode_bulan;
  $periode = $periode_tahun . '-' . $periode_bulan;
  $periode = date('Y-m', strtotime($periode));
  ?>
  <h4>Gaji Pegawai PJLP </h4>
  <h5>Periode : <?php echo   $periode; ?></h5>
  <table border="1">
    <thead>
      <tr>

        <th class="w-1">No.</th>
        <th>ID PJLP</th>
        <th>Nama</th>
        <th>Jabatan</th>
        <th>Gaji Pokok</th>
        <th>Capaian</th>
        <th>Bruto</th>
        <th>Pajak</th>
        <th>BPJS Kes</th>
        <th>BPJS TK</th>
        <th>THP</th>

      </tr>
    </thead>
    <tbody>
      <?php

      $no = 1;

      #print_array($pegawai);
      foreach ($pegawai as $peg) {

        $id_pjlp = $peg->id_pjlp;
        $gaji_pokok = $peg->gaji_pokok;

        if ($gaji_pokok == '') {
          $gaji_pokok = 0;
        }

        $DataRekapGaji = $this->Laporan_model->cekDataRekapGajiPjlp($id_pjlp, $periode);
        if (!empty($DataRekapGaji)) {

          $id_gaji = $DataRekapGaji[0]->id;
          $capaian = $DataRekapGaji[0]->capaian;
          $bruto = $DataRekapGaji[0]->bruto;
          $pph21 = $DataRekapGaji[0]->pph21;
          $bpjs = $DataRekapGaji[0]->bpjs;
          $bpjs_tk = $DataRekapGaji[0]->bpjs_tk;
          $thp = $DataRekapGaji[0]->thp;
        } else {
          $capaian = 0;
          $bruto = 0;
          $pph21 = 0;
          $bpjs = 0;
          $bpjs_tk = 0;
          $thp = 0;
          $id_gaji = 0;
        }

        echo ' <tr>
                            <td>' . $no . ' </td>

                            <td class="text-center"> ' . $id_pjlp . '</td>
                            <td class="text-start">' . $peg->nama . '</td>
                            <td>Petugas ' . $peg->jabatan . ' </td>

                            <td  class="text-end">' . rupiah($gaji_pokok) . ' </td>
                            <td>' . $capaian . '</td>

                            <td>' . rupiah($bruto) . '</td>
                            <td>' . rupiah($pph21) . '</td>
                            <td>' . rupiah($bpjs) . '</td>
                            <td>' . rupiah($bpjs_tk) . '</td>
                            <td>' . rupiah($thp) . '</td>

                        </tr>';

        $no += 1;
      }


      ?>






    </tbody>
  </table>
</body>

</html>