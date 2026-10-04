<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Gaji P3K Paruh Waktu</title>
</head>
<body>

    <h3>Import Gaji P3K Paruh Waktu</h3>

    <form action="<?= base_url('admin/import_data/import_gaji_p3k_pw') ?>" 
          method="post" 
          enctype="multipart/form-data">

        <table>
            <tr>
                <td>Bulan</td>
                <td>:</td>
                <td>
                    <select name="bulan" required>
                        <option value="">-- Pilih Bulan --</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td>Tahun</td>
                <td>:</td>
                <td>
                    <input type="number" name="tahun" value="<?= date('Y') ?>" required>
                </td>
            </tr>

            <tr>
                <td>File Excel</td>
                <td>:</td>
                <td>
                    <input type="file" name="file" accept=".xlsx" required>
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <button type="submit">Import Data</button>
                </td>
            </tr>
        </table>

    </form>

</body>
</html>
