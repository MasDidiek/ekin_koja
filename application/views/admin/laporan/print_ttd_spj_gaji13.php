<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .styled-table {
            width: 100%;
            border-collapse: collapse;
        }

        .styled-table th, .styled-table td {
            padding: 10px;
            border: 1px solid #666;
            text-align: left;
        }

        .styled-table th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }
        </style>
</head>
<body>
    
        <table class="styled-table">
            <thead>
                <tr>
                    
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Unit/Satuan Kerja/Asal</th>
                        <th class="text-center">No. Handphone / Email</th>
                        
                        <th class="text-center">Tanda Tangan</th>
                        <th class="text-center">No. Rek Bank DKI</th>
                        
                    
                    </tr>
            </thead>
                <tbody>
                <?php

//print_array($data_gaji);
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
                
 

                            $totalGaji13 = $totalGaji13+$total;


                            echo' <tr>
                                    <td class="text-center ">'.$no.'</td>
                                    <td class="text-left" data-id="'.$id.'">   '.$nama.' </td>
                                    <td class="text-start">'.$peg->jabatan.'</td>
                                     <td class="text-start">`'.$peg->no_hp.'</td>
                                    <td class="text-center">
                                    <img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="200"></td>
                                    <td class="text-start">'.$peg->no_rekening.'</td>


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

</body>
</html>