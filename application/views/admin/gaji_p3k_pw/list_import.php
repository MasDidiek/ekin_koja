<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h3>Data Gaji P3K Paruh Waktu</h3>

    <form method="get">
        Bulan :
        <select name="bulan">
            <option value="">Semua</option>
            <?php for ($i = 1; $i <= 12; $i++) : ?>
                <option value="<?= $i ?>" <?= (@$_GET['bulan'] == $i ? 'selected' : '') ?>>
                    <?= date('F', mktime(0, 0, 0, $i, 1)) ?>
                </option>
            <?php endfor; ?>
        </select>

        Tahun :
        <input type="number" name="tahun" value="<?= @$_GET['tahun'] ?>">

        <button type="submit">Filter</button>
    </form>

    <br>

    <table border="1" cellpadding="5" cellspacing="0">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Bulan</th>
            <th>Tahun</th>
            <th>Jumlah Diterima</th>
            <th>No Rekening</th>
            <th>Status TTD</th>
        </tr>

        <?php if (count($list) > 0): ?>
            <?php $no = 1; foreach ($list as $row): 
                $ttd_pegawai = $row->ttd_pegawai;
                 $ttd_oleh = $row->ttd_oleh;
                
                    if($ttd_pegawai==0){
                        $image_ttd = '';
                    }else{
                        $image_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_oleh.'" width="100"> ';
                    }


            ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nama ?></td>
                    <td><?= $row->jabatan ?></td>
                    <td><?= $row->bulan ?></td>
                    <td><?= $row->tahun ?></td>
                    <td align="right"><?= number_format($row->jumlah_diterima, 0, ',', '.') ?></td>
                    <td><?= $row->no_rekening ?></td>
                    <td>
                        <?= $image_ttd;?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" align="center">Data tidak ditemukan</td>
            </tr>
        <?php endif; ?>
    </table>

</body>
</html>