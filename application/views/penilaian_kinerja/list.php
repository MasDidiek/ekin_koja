<div>Aktifitas Tanggal : <strong> <?= format_full($tgl); ?></strong></div>


    <form action="<?php echo base_url();?>admin/penilaian_kinerja/setujui_aktifitas" method="post" id="approveAktifitas">
        <button type="submit" class="btn  btn-success mb-2 float-end" data-tgl="<?= $tgl; ?>">
        <i class="mdi mdi-check-line"></i>    
        Setujui Aktifitas</button>


        <table class="table  table-bordered  fs-2">
            <thead class="thead-light text-center">
                <tr>
                    <th>No</th>
                    <th>Kegiatan</th>
                    <th>Waktu</th>
                    <th>Volume (x) waktu efektif</th>
                    <th>Total</th>
                   
                    <th>Check</th>
                </tr>
            </thead>
            <tbody>

                <?php

                $no = 1;
                $total = 0;
                foreach ($list as $aktifitas) {

                    $jns_kegiatan = $aktifitas->jns_kegiatan;
                    if ($jns_kegiatan == 1) {
                        $kategori_aktifitas = '<span class="text-info"><strong>  Aktifitas Utama</strong></span>';
                    } else {
                        $kategori_aktifitas = '<span class=" text-secondary"> <strong>Aktifitas Tambahan</strong></span>';
                    }

                     $status = $aktifitas->status;
                     if($status==1){
                        $flag = '<span class="text-success">Disetujui</span>';
                     }else if($status==2){
                        $flag = '<span class="text-danger">Ditolak</span>';
                     }else{
                        $flag = '<span class="text-warning">Pending</span>';
                     }

                    $total = $total+$aktifitas->total;

                    echo '
                <tr valign="middle">
                    <td>' . $no . '</td>
                    <td>' . $kategori_aktifitas . ' <span style="float:right"> '.$flag .'</span> <br> <strong>Indikator : </strong> ' . $aktifitas->indikator . '<br>
                    ' . $aktifitas->nama_kegiatan . ' <br>  
                    <span class="text-muted"> ' . $aktifitas->ket . '</span> </td>
                    <td class="text-center">' . $aktifitas->jam_mulai . ' -  ' . $aktifitas->jam_selesai . ' </td>
                    <td class="text-center">' . $aktifitas->volume . ' x ' . $aktifitas->waktu_efektif . '</td>
                   
                    <td class="text-center">' . $aktifitas->total . '</td>
                    
                    <td>
                        <input type="checkbox" name="check_id[]" value="'.$aktifitas->id.'" checked>   
                    </td>
                </tr>';

                    $no++;
                }
                ?>

                <tr>
                    <th colspan="4"></th>
                    <th><?=  $total ; ?></th>
                </tr>

            </tbody>
        </table>

</form>