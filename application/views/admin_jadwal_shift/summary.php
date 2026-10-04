<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Shift Kerja</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: "Poppins", sans-serif;
            font-weight: 400;
            font-style: normal;

        }

        h2 {
            font-size: 20px;
        }


        table {
            border-collapse: collapse;
            font-size: 12px;

        }

        table tr td,
        th {
            border: 1px solid #666;
            padding: 6px;
            text-align: center;
        }

        .col-name {
            left: 0;
            position: sticky;
            background: #FFF;
            border-right: 1px solid #666;
        }

        .bg-danger {
            background: #ef504c;
            color: #FFF;
        }


        .bg-light {
            background: #FFF;
            color: #333;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <?php
    $message = $this->session->flashdata('success');

    // $periode = date('Y-m');
    $periode_bulan = $this->session->userdata('periode_bulan');
    $periode_tahun = $this->session->userdata('periode_tahun');

    if ($periode_bulan == '') {
        $bulan = date('m');
        $tahun = date('Y');
    } else {
        $bulan = $periode_bulan;
        $tahun = $periode_tahun;
    }


    $nm_bulan = getBulan($bulan);
    $periode = $tahun . '-' . $bulan;
    $periode = date('Y-m', strtotime($periode));

    $listBulan = array_bulan();

    $lastDateMonth = date('t', strtotime($periode));
    ?>


    <h2>Rekap Jadwal Kerja Pegawai Puskesmas Koja</h2>

    <table class="table" style="width:120%">
        <thead>
            <tr>

                <th width="200">Nama Pegawai</th>
                <?php
                for ($i = 1; $i < ($lastDateMonth + 1); $i++) {
                    $date =  $periode . '-' . $i;

                    $tanggal = format_db($date);
                    $day = date('l', strtotime($tanggal));
                    if ($day == 'Sunday') {
                        $hari = 'Mg';
                    } else if ($day == 'Monday') {
                        $hari = 'Sn';
                    } else if ($day == 'Tuesday') {
                        $hari = 'Sl';
                    } else if ($day == 'Wednesday') {
                        $hari = 'Rb';
                    } else if ($day == 'Thursday') {
                        $hari = 'Km';
                    } else if ($day == 'Friday') {
                        $hari = 'Jm';
                    } else {
                        $hari = 'Sb';
                    }

                    echo ' <th class="text-center" width="50">' . $i . ' <br>
                                    <small>' . $hari . '</small>
                                    </th>';
                }

                ?>

                <th>Total </th>

            </tr>
        </thead>
        <tbody>

            <?php

            for ($i = 0; $i < count($list_pegawai); $i++) {
                $id_pegawai = $list_pegawai[$i]->id_pegawai;
                $nip        = $list_pegawai[$i]->nip;
                $pin        = substr($nip, -4);

                echo '

                                <tr>
                                    <td class="col-name">' . $list_pegawai[$i]->nama . ' </td>';

                for ($a = 1; $a < ($lastDateMonth + 1); $a++) {


                    $tanggal  = $periode . '-' . $a;
                    $matrikId = $id_pegawai . '_' . $tanggal;
                    $tgl = format_db($tanggal);

                    $shift = $this->Presensi_model->getDatashiftKerja($id_pegawai, $tgl, 'shift');
                    if ($shift == 'OFF') {
                        $shift_class = 'bg-danger';
                    } else {
                        $shift_class = 'bg-light';
                    }

                    echo '<td class="text-center ' . $shift_class . '">
                                                <span class="text-dark">' . $shift . '</span>
                                              </td>
                                            ';
                }
                echo '
                                      <td></td>
                                      </tr>
                                     
                                    <tr> 
                                      <td class="col-name">Jam Kerja</td>';
                $totalJamKerja = 0;
                for ($a = 1; $a < ($lastDateMonth + 1); $a++) {


                    $tanggal  = $periode . '-' . $a;
                    $matrikId = $id_pegawai . '_' . $tanggal;
                    $tgl = format_db($tanggal);

                    $shift = $this->Presensi_model->getDatashiftKerja($id_pegawai, $tgl, 'shift');
                    $shift_class = '';

                    if ($shift != '-') {
                        $detailShift = $this->Presensi_model->detailShiftByKode($shift);
                        $jam_masuk  = format_jam($detailShift->jam_masuk);
                        $jam_pulang = format_jam($detailShift->jam_pulang);

                        $jam_kerja = $jam_masuk . ' - ' . $jam_pulang;

                        if ($shift == 'L-OFF') {
                            $shift_class = 'bg-light';
                        } else {
                            $shift_class = 'bg-success';
                        }

                        $jumlah_jam_kerja = $detailShift->jam_kerja;

                        // if ($jam_pulang == '00:00') {
                        //     $jam_pulang = '23:59:59';

                        //     if ($shift == 'OFF') {
                        //         $jumlah_jam_kerja =  0;
                        //         $shift_class = 'bg-danger';
                        //     } else {
                        //         $jumlah_jam_kerja = calculateMinutesDifference($jam_pulang, $jam_masuk) + 1;
                        //         $jumlah_jam_kerja = $jumlah_jam_kerja / 60;
                        //     }
                        // } else {
                        //     $jumlah_jam_kerja = calculateMinutesDifference($jam_pulang, $jam_masuk);
                        //     $jumlah_jam_kerja = $jumlah_jam_kerja / 60;
                        // }
                    } else {
                        $jam_kerja = '';
                        $jumlah_jam_kerja = 0;
                        $shift_class = 'bg-light';
                    }


                    $totalJamKerja = $totalJamKerja + $jumlah_jam_kerja;
                    echo '<td style="background:#eaf2ff">  <span class="jam-kerja">' . $jumlah_jam_kerja . '</span></td>';
                }

                echo ' 
                                      <td>' . $totalJamKerja . '</td>
                                      </tr>';
            }
            ?>
        </tbody>
    </table>


</body>

</html>