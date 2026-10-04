<div>Aktifitas Tanggal : <strong> <?= format_full($tgl); ?></strong></div>
<button type="button" class="btn btn-sm btn-primary mb-2 float-end input-aktifitas" data-tgl="<?= $tgl; ?>">Input Aktifitas</button>


<table class="table  table-bordered table-striped  fs-2">
    <thead class="thead-light text-center">
        <tr>
            <th>No</th>
            <th>Kegiatan</th>

            <th>Waktu</th>
            <th>Volume</th>
            <th>Waktu Efektif</th>
            <th>Total</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        <?php

        $no = 1;
        foreach ($list as $aktifitas) {

            $jns_kegiatan = $aktifitas->jns_kegiatan;
            if ($jns_kegiatan == 1) {
                $kategori_aktifitas = '<h6 class="text-success">  Aktifitas Utama</h6>';
            } else {
                $kategori_aktifitas = '<h6 class=" text-warning"> Aktifitas Tambahan</h6>';
            }


            echo '
        <tr valign="middle">
            <td>' . $no . '</td>
            <td>' . $kategori_aktifitas . ' <strong>Indikator : </strong> ' . $aktifitas->indikator . '<br>
            <strong>Nama Kegiatan : </strong> ' . $aktifitas->nama_kegiatan . ' <br>  <strong>Keterangan : </strong> ' . $aktifitas->ket . ' </td>
            <td class="text-center">' . $aktifitas->jam_mulai . ' -  ' . $aktifitas->jam_selesai . ' </td>
            <td class="text-center">' . $aktifitas->volume . '</td>
            <td class="text-center">' . $aktifitas->waktu_efektif . '</td>
            <td class="text-center">' . $aktifitas->total . '</td>
            <td>
                <button type="button" class="btn btn-sm btn-success edit-aktifitas" data-id="' . $aktifitas->id . '">Ubah</button>
                <button type="button" class="btn btn-sm btn-danger delete-aktifitas" data-id="' . $aktifitas->id . '"  data-tgl="' . $tgl . '">Hapus</button>
                </td>
        </tr>';

            $no++;
        }
        ?>

    </tbody>
</table>