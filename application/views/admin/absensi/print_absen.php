<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Absensi</title>

    <style>
        .main-container {
            width: 1000px;
            height: auto;
            padding: 20px;
            border: 1px solid #F8F8F8;
            font-family: Arial, Helvetica, sans-serif;
            margin: 0 auto;
        }


        table {
            width: 100%;
            border-collapse: collapse;

        }

        .table-absen tr td,
        th {
            border: 1px solid #DDD;
            padding: 10px;
            text-align: center;
        }

        .table-header {
            width: 500px;
        }


        .table-header td {

            padding: 6px;
            text-align: left;
        }
    </style>
</head>

<body>

    <?php


    $id_pjlp = $this->uri->segment(4);
    $message = $this->session->flashdata('message');

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





    <div class="main-container">

        <center>
            <h3>Absensi Kehadiran</h3>
        </center>


        <?php
        $nama = $data_pjlp[0]->nama;
        //  $jabatan = $data_pjlp[0]->jabatan;
        // $lokasi_kerja = $data_pjlp[0]->lokasi_kerja;

        $id_jabatan = $data_pjlp[0]->id_jabatan;
        $jabatan = $this->Master_model->getNamaJabatan($id_jabatan);

        $id_puskesmas = $data_pjlp[0]->id_puskesmas;
        $lokasi_kerja = $this->Master_model->getNamaPuskesmas($id_puskesmas);
        ?>



        <table class="table-header">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?php echo $nama; ?></td>
            </tr>
            <tr>
                <td>ID PJLP</td>
                <td>:</td>
                <td><?php echo $id_pjlp; ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>:</td>
                <td>Petugas <?php echo $jabatan; ?></td>
            </tr>
            <tr>
                <td>Lokasi Kerja</td>
                <td>:</td>
                <td>Puskesmas <?php echo $lokasi_kerja; ?></td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>:</td>
                <td><?php echo date('F Y', strtotime($periode)); ?></td>
            </tr>

        </table>

        <br> <br>

        <table class="table-absen">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Hari</th>
                    <th>Absen Masuk</th>
                    <th>Absen Keluar</th>
                </tr>
            </thead>

            <tbody>
                <?php


                $pin = substr($id_pjlp, -5);
                $pin =  $id_pjlp;
                //$dataAbsensi = $this->Presensi_model->getAbsenHarian($pin, $tanggal);


                for ($i = 0; $i < 31; $i++) {
                    $tgl = $i + 1;

                    $tanggal = $periode . '-' . $tgl;
                    $tanggal = format_db($tanggal);

                    $day = date('l', strtotime($tanggal));
                    $hari = getNamahari($tanggal);

                    $masuk = '';
                    $pulang = '';

                    $dataAbsensi = $this->Presensi_model->getAbsenHarian($pin, $tanggal);
                    if (!empty($dataAbsensi)) {
                        #print_array($dataAbsensi);
                        $absenHarian = '';
                        for ($a = 0; $a < count($dataAbsensi); $a++) {

                            $date = $dataAbsensi[$a]->tanggal;
                            $status  = $dataAbsensi[$a]->status;

                            if ($status == 0) {
                                $jns_absen = '(Masuk)';
                                $masuk =  $jamAbsen = date('H:i:s', strtotime($date));
                            } else {
                                $jns_absen = '(Pulang)';
                                $pulang =  $jamAbsen = date('H:i:s', strtotime($date));
                            }


                            $jamAbsen = date('H:i:s', strtotime($date));
                            $absenHarian .= $jamAbsen . ' ' . $jns_absen . '<br>';
                        }
                    } else {
                        $date = '-';
                        $status  = '';
                        $absenHarian = '';
                    }

                    echo '<tr>
                                        <td>' . format_view($tanggal) . '</td>
                                        <td>' . $hari . '</td>
                                        <td>' . $masuk . '</td>
                                        <td>' . $pulang . '</td>
                                        
                                    
                                    </tr>';
                    //print_array($dataAbsensi);

                }

                // print_array($dataAbsensi);
                ?>
            </tbody>
        </table>
    </div>

</body>

</html>