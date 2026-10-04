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

     <h5>LISTING GAJI ke 13</h5>
        <h6>Periode Juni 2025</h6>
        <br>

        <a href="<?php echo base_url();?>laporan/listing_gaji13" class="btn btn-danger">Kembali</a>

        
        <p>
            Filter :
            <a href="<?php echo base_url();?>laporan/view_daftar_ttd_gaji13/all" class="filter-data">All</a>
            <a href="<?php echo base_url();?>laporan/view_daftar_ttd_gaji13/belum" class="filter-data">Belum TTD</a>
            <a href="<?php echo base_url();?>laporan/view_daftar_ttd_gaji13/sudah" class="filter-data">Sudah TTD</a>
        </p>


        <?php

            $filter_by = $this->uri->segment(4);

            $totalPegawai = count($data_gaji);
            $blm_ttd  = 0;
            $sudah_ttd  = 0;

            foreach ($data_gaji as $peg){

                $nama = $peg->nama;
                $jabatan = $peg->jabatan;
                $ttd_spj = $peg->ttd_spj;
                $id = $peg->id;
                $total = $peg->total;

                if($ttd_spj  == ''){

                    $blm_ttd = $blm_ttd+1;

                }else{
                    $sudah_ttd  = $sudah_ttd+1;
                }


            }


            $persenTTD = ($sudah_ttd/$totalPegawai)*100;


        ?>

        <div class="progress">
            <div class="progress-bar bg-success" style="width: <?php echo round($persenTTD) ;?>%;" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"><?php echo round($persenTTD) ;?>%</div>
        </div>

        <?php echo '<strong>'.$sudah_ttd  .'</strong>/'.$totalPegawai ;?>
        <br>  <br>

        <table class="styled-table">
            <thead class="bg-light">
                    <tr>

                        <th>No</th>
                        <th>Nama Pegawai</th>
                        <th>NIK</th>
                        <th>Jabatan</th>
                        <th>TMT</th>
                        <th>Gaji Pokok</th>
                        <th>Tunj. Suami</th>
                        <th>Tunj. Anak 1</th>
                        <th>Tunj. Anak 2</th>
                        <th>Jumlah Gaji Bruto</th>

                        <th>TKD Ke 13</th>
                        <th>Total</th>
                        <th>No Rekening</th>
                        <th>TTD SPJ</th>
                    </tr>
                </thead>
                <tbody class="list form-check-all">
                <?php

                        $totalGaji13 = 0;
                        $total_pajak = 0;

                        $total_thp = 0;

                        $no = 1;
                        foreach ($data_gaji as $peg){

                            $nama = $peg->nama;
                            $jabatan = $peg->jabatan;
                            $ttd_spj = $peg->ttd_spj;
                            $id = $peg->id;
                            $total = $peg->total;

                           /*  if($ttd_spj  == ''){
                                $flag_status = '<span class="text-danger"><i class="fa-solid fa-circle-exclamation"></i> </span>';
                                $btn_check = '<a href="'.base_url().'laporan/cekSesuai/'.$peg->id.'" class="text-info float-end"> <i class="mdi mdi-account-edit me-1"></i></a>';

                            }else{
                                $flag_status = '<span class="text-success"><i class="fa-solid fa-check"></i></span>';
                                $btn_check = '';
                            }
                            */
                            if($ttd_spj  == ''){
                                $flag_status = '0';
                                $btn_check = '<a href="'.base_url().'laporan/cekSesuai/'.$peg->id.'" class="text-info float-end"> <i class="mdi mdi-account-edit me-1"></i></a>';

                            }else{
                                $flag_status = '1';
                                $btn_check = '';
                            }



                            $cekNama = $this->Laporan_model->cekNamaPegawai($nama);
                        // print_array($cekNama);
                            if($cekNama == null){
                                $nama = '<span class="text-danger">'.$nama.'</span>';
                            }else{
                                $nama = '<span class="text-dark">'.$nama.'</span>';

                            }

                            $totalGaji13 = $totalGaji13+$total;



                            echo' <tr>
                                    <td class="text-center ">'.$no.'</td>
                                    <td class="text-left editable" data-id="'.$id.'">   '.$nama.' </td>
                                    <td class="text-center">'.$peg->nik.'</td>
                                    <td class="text-start">'.word_limiter($peg->jabatan,3).'</td>
                                    <td class="text-start">'.$peg->tmt.'</td>
                                    <td class="text-center  tkd_pokok">'.rupiah($peg->gaji_pokok).'</td>
                                    <td class="text-end">
                                    <strong>'.rupiah($peg->tunj_suami).'</strong>  </td>
                                    <td class="text-end">'.rupiah($peg->tunj_anak1).'</td>
                                    <td class="text-end">'.rupiah($peg->tunj_anak2).'</td>
                                    <td class="text-end">'.rupiah($peg->thr_gaji).'</td>
                                    <td class="text-end"> <strong>'.rupiah($peg->tkd13).'</strong></td>
                                    <td class="text-end"> <strong>'.rupiah($peg->total).'</strong></td>
                                    <td class="text-center">'.$peg->no_rekening.'</td>
                                    <td class="text-center">'.$flag_status.'</td>

                                    </tr>';

                                $no += 1;

                        }

                    ?>



                </tbody>

                <tr>
                    <th>Total</th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="6"></th>

                    <th><?php echo rupiah($totalGaji13);?></th>
                    <th></th>
                    <th></th>
                </tr>

            </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>

<script>
$(document).ready(function() {
  // Saat nama diklik dua kali
  $('.editable').dblclick(function() {
    let td = $(this);
    let currentText = td.text();
    let input = $('<input type="text">').val(currentText);

    td.html(input);
    input.focus();



    input.on('blur keydown', function (e) {
      if (e.which === 13) {
        if (e.type === 'blur' || e.key === 'Enter') {
            let newText = $(this).val();
            td.html(newText);

            let row = td.closest('tr');
            let id  = td.data('id');

              $.ajax({
                    url: 'updateNama', // Sesuaikan dengan route controller CodeIgniter kamu
                    method: 'POST',
                    data: {
                        id: id,
                        nama: newText
                    },
                    success: function (res) {
                        console.log('Update sukses:', res);
                    },
                    error: function () {
                        alert('Gagal update nama.');
                    }
                });
        }

      }
    });
  });
});
</script>
</html>
