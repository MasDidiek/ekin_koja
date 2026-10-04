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
        <a href="<?php echo base_url(); ?>admin/laporan/update_rekap_tkd/<?php echo $periode; ?>" class="btn  float-end btn-info  ms-2"> <i class="fas fa-refresh"></i> Update Rekap</a>
        <div class="clearfix"></div>
        Periode : <?php echo $periode; ?>
        <table class="mytable  table-hover mt-4" id="data-table">
            <thead>
                <tr>

                    <th class="w-1">No.</th>
                    <th>Nama</th>
                    <th>Jabatan</th>
                    <th>NPWP</th>
                    <th>TKD Pokok</th>
                    <th>Total Capaian</th>
                    <th>Bruto</th>
                    <th>PPh21</th>
                    <th>BPJS</th>
                    <th>BPJS TK</th>
                    <th>Total</th>
                    <th>No Rekening</th>
                    <th>Keterangan</th>

                </tr>
            </thead>
            <tbody>
                <?php

                $no = 1;
                foreach ($listing_tkd as $peg) {

                    $nama = $peg->nama;
                    $nip = $peg->nip;
                    $jabatan = $peg->jabatan;

                    $id_pegawai = $this->Pegawai_model->cekData($nip);
                    $capaian =  $peg->capaian;
                    if ($capaian > 98) {
                        $class = "text-success";
                    } else if ($capaian > 92 && $capaian <= 98) {
                        $class = "text-primary";
                    } else if ($capaian > 90 && $capaian <= 92) {
                        $class = "text-warning";
                    } else {
                        $class = "text-danger";
                    }

                    //cuti hamil
                    if ($capaian == 50) {
                        $class = 'text-info';
                    }
                    echo ' <tr>
                                    <td class="text-center">' . $no . ' </td>
                                    <td class="text-start"><a href="' . base_url() . 'admin/capaian_kinerja/detail_capaian/' . $id_pegawai . '/' . $nip . '">' . $peg->nama . '</a></td>
                                    <td>' . $jabatan . '</td>
                                    <td>' . $peg->npwp . '</td>
                                    <td>' . rupiah($peg->tkd_pokok) . '</td>
                                    <td class="text-end ' . $class . '">' . $peg->capaian . '</td>
                                    <td>' . rupiah($peg->bruto) . '</td>
                                    <td>' . rupiah($peg->pph21) . '</td>
                                    <td>' . rupiah($peg->bpjs) . '</td>
                                    <td>' . rupiah($peg->bpjs_tk) . '</td>
                                    <td>' . rupiah($peg->thp) . '</td>
                                    <td>' . $peg->no_rekening . '</td>
                                    <td></td>
                                    
                                    
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