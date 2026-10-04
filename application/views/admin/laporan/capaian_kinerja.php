<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Petruk Koja</title>

    <style>
        .bg-dark {
            background-color: #232341 !important;
        }

        table {
            width: 100%;
            font-size: 14px;
        }

        .mytable th {
            background-color: #EEE;
            color: #666;
            border-top: 1px solid #DDD;
            padding: 10px;
        }

        .mytable td {
            color: #666;
            border-top: 1px solid #f2f2f2;
            padding: 10px;
        }

        td a {
            color: #666;
            font-style: none;
        }

        tr:nth-child(even) {
            background-color: #f8f8f8;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Petruk Koja</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo base_url(); ?>dashboard/index">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>admin/laporan/capaian_kinerja">Capaian Kinerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url(); ?>admin/laporan/listing_tkd">Listing TKD</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <?php

    $periode = '2025-05';
    ?>

    <div class="container-fluid mt-4">

        <h5>LISTING TKD</h5>
        Periode : <?php echo $periode; ?>

        <table class="mytable  table-hover" id="data-table">
            <thead>
                <tr>

                    <th class="w-1">No.</th>
                    <th>Nama</th>
                    <th>Bobot Aktifitas</th>
                    <th>Perilaku</th>
                    <th>Serapan</th>
                    <th>Total Capaian</th>

                </tr>
            </thead>
            <tbody>
                <?php

                $no = 1;
                foreach ($capaian_kinerja as $peg) {


                    $nip = $peg->nip;
                    $bobot_aktifitas = $peg->bobot_aktifitas;
                    $perilaku = $peg->perilaku;
                    $serapan = $peg->serapan;
                    $total_capaian = $peg->total_capaian;

                    $nama = $this->Pegawai_model->getNamaByNip($nip, '2024');


                    echo ' <tr>
                                    <td class="text-center">' . $no . ' </td>
                                    <td class="text-start">' . $nama . '</a></td>
                                    <td>' . $bobot_aktifitas . '</td> 
                                    <td class="text-end">' .  $perilaku  . '</td>
                                    <td class="text-end">' .  $serapan  . '</td>
                                    <td class="text-end">' .  $total_capaian  . '</td>
                                  
                                    
                                    
                                </tr>';

                    $no += 1;
                }

                ?>

            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    -->
</body>

</html>