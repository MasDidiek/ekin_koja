<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Listing Gaji ke 13</title>
    <style>
        .filter-data{
            background-color: #EEE !important;
            color:#666;
            padding:5px 10px;
            text-decoration:none;
            border-radius:15px;
            font-size:12px;
        }
        .bg-dark {
            background-color: #232341 !important;
        }

        .editable{
            color: #232341 !important;
        }
        table {
            width: 100%;
            font-size: 14px;
        }

        .styled-table th {
            background-color: #EEE;
            color: #666;
            border-top: 1px solid #DDD;
            padding: 10px;
        }

        .styled-table td {
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

        .progress {
            display: -ms-flexbox;
            display: flex;
            height: 1.5rem;
            overflow: hidden;
            line-height: 0;
            font-size: .95rem;
            background-color: #e9ecef;
            border-radius: 0.25rem;
            margin-bottom: 1rem;
        }
        .progress-bar {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            -ms-flex-pack: center;
            justify-content: center;
            overflow: hidden;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            background-color: #007bff;
            transition: width .6s ease;
        }



        .bg-success {
            background-color: #28a745!important;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Ekinerja Cilincing</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="<?php echo base_url();?>dashboard/index">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>admin/laporan/capaian_kinerja">Capaian Kinerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo base_url();?>admin/laporan/listing_tkd">Listing TKD</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid mt-4">

     <h5>LISTING GAJI ke </h5>
        <h6>Periode Juni 2025</h6>
        <br>


        <a href="<?php echo base_url();?>laporan/dataraw_spj_ttd_gaji/all" class="btn btn-sm btn-primary">All</a>
        <a href="<?php echo base_url();?>laporan/dataraw_spj_ttd_gaji/belum" class="btn btn-sm btn-light">Belum TTD</a>
        <a href="<?php echo base_url();?>laporan/dataraw_spj_ttd_gaji/sudah" class="btn btn-sm btn-light">Sudah TTD</a>


        <table class="table">
            <thead>
                   <tr>
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>NIK</th>
                        <th>No Rekening</th>
                        <th class="text-center">Total </th>
                        <th class="text-center">No Handphone</th>
                        <th class="text-center">TTD</th>

                    </tr>
            </thead>
            <tbody>

            <?php


                $no = 1;
                foreach ($data_gaji as $peg){

                $nama = $peg->nama;
                $npwp = $peg->nik;

                $jabatan = $peg->jabatan;
                $netto = $peg->netto;

                $no_hp  = '';
                $ttd_spj = $peg->ttd_spj;

                $cekNama = $this->db->get_where('mst_pegawai',array('nama'=>$nama))->row();
                //print_r($cekNama);
                if($cekNama == null){
                    $nama = '<span class="text-dark">'.$nama.'</span>';
                }else{
                    $nama = '<span class="text-dark">'.$nama.'</span>';

                }



                if($ttd_spj==''){
                    $flag = '<span class="badge bg-warning">Belum</span>';
                }else{
                    $flag = '<span class="badge bg-success">Sudah</span>';
                }



                    echo' <tr>
                                <td class="text-center">'.$no.'</td>
                                <td class="text-left"> '.$nama.'</td>

                                <td class="text-left">'.$jabatan.'</td>
                                 <td class="text-center">'.$npwp.'  <button  type="button" value="'.$npwp.'/'.$peg->id.'" class="btn btn-sm edit_npwp" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm"> <i class="mdi mdi-pencil"></i></button> </td>
                               <td class="text-left">'.$peg->no_rekening.'</td>
                                 <td class="text-end">'.rupiah($netto).'</td>

                                <td class="text-center">'.$no_hp.'</td>
                                <td class="text-center">'.$flag.'</td>


                            </tr>';

                        $no += 1;

                }

                ?>

            </tbody>

            </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

</html>
