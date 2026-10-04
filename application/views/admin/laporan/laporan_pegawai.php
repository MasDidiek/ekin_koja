<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        table{
            width: 100%;
            border-collapse: collapse;
        }

        tr td, th{
            padding: 10px;
            border: 1px solid #DDD;
        }

        .bg-red{
            background-color: #fde0e0ff;
        }
    </style>
</head>
<body>
    

Laporan data Pegawai

<?php
//print_array($datalist);
?>



    <table>
        <tr>
            <th>No</th>
            <th>nama</th>
            <th>Tempat tanggal lahir</th>
            <th>Pendidikan</th>
             <th>Jabatan</th>
            <th>tmt</th>
             <th>masa kerja (Thn)</th>
              <th>masa kerja (Bln)</th>
              <th>Status</th> 
              <th>Gaji Pokok</th>
               <th>Koefisien</th>
                <th>Tunjangan</th>
                <th>THR</th>
                <th>Gaji13</th>
           
        </tr>

        <?php
            $no=1;
            foreach ($datalist as $pegawai) {
                $status_kerja = $pegawai->status_kerja;
                if($status_kerja==0){
                    $class= 'bg-red';
                }else{
                     $class= '';
                }
                 $status_kawin = $pegawai->status_kawin;

                 if($status_kawin==1){
                    $sk = 'K3';
                 }else if($status_kawin==2){
                     $sk = 'K2';
                 }else if($status_kawin==3){
                    $sk = 'K1';
                 }else{
                    $sk = 'K0';
                 }

                
                $masa_kerja = calculateMasakerja($pegawai->tgl_masuk);
                $explodMasaKerja = explode("-", $masa_kerja);

                $gaji_pokok = $pegawai->gaji_pokok;
                $pengali = $pegawai->pengali;

                $tunjangan = $gaji_pokok*$pengali;

                $thr = $pegawai->total_thr;
                $gaji_13 = $pegawai->total;


                echo '    <tr class="'.$class.'">
                             <td>'.$no.'</td>
                             <td>'.$pegawai->nama.'</td>
                             <td>'.$pegawai->tempat_lahir.', '.format_full($pegawai->tgl_lahir).'</td>
                              <td>'.$pegawai->pendidikan.'</td>
                               <td>'.$pegawai->jabatan.'</td>
                             <td>'.format_semi($pegawai->tgl_masuk).'</td>
                             <td>'.$explodMasaKerja[0].'</td>
                              <td>'.$explodMasaKerja[1].'</td>
                              <td>'.$sk.'</td>
                              <td>'.rupiah($gaji_pokok).'</td>
                              <td>'.$pengali.'</td>
                              <td>'.rupiah($tunjangan).'</td>
                               <td>'.rupiah($thr).'</td>
                                <td>'.rupiah($gaji_13).'</td>
                            
                        </tr>';

                        $no++;
            }
        ?>

    
    </table>

</body>
</html>