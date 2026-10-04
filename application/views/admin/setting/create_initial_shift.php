<?php

$bulan_shift = $this->session->userdata('bulan_shift');
$tahun_shift = $this->session->userdata('tahun_shift');
if ($tahun_shift == '') {
    $bulan_shift = date('m');
    $tahun_shift = date('Y');
}

$periode = $tahun_shift . '-' . $bulan_shift;
$periode = date('Y-m', strtotime($periode));


?>

<a href="<?php echo base_url(); ?>admin/presensi/lihat_absensi_pegawai" class="btn btn-danger  mb-3">
    Back
</a>


<form action="<?php echo base_url(); ?>admin/setting/change_periode" method="post">

    <select name="bulan_shift" id="bulan" class="form-control float-start me-2" style="width:120px">
        <?php
        for ($i = 1; $i < 13; $i++) {
            if ($bulan_shift == $i) {
                echo ' <option value="' . $i . '" selected>' . getBulan($i) . '</option>';
            } else {
                echo ' <option value="' . $i . '">' . getBulan($i) . '</option>';
            }
        }
        ?>

    </select>
    <input type="number" name="tahun_shift" class="form-control me-2 float-start" style="width:120px" id="tahun" value="<?php echo $tahun_shift; ?>">
    <button type="submit" class="btn btn-info">Submit</button>
</form>


<form action="<?php echo base_url(); ?>admin/setting/update_initial_shift" method="post">


    <button type="submit" class="btn btn-success float-end  mb-3">
        <i class="fas fa-refresh"></i> Save Change
    </button>



    <div class="clearfix"></div>


    <div class="table-responsive mt-4">
        <?php echo $periode; ?>
        <table class="table-shift">
            <thead>
                <tr>
                    <th width="50" rowspan="2">Tanggal</th>
                    <th width="100" rowspan="2">Hari</th>
                    <th width="100" rowspan="2">Shift</th>
                    <th width="160" colspan="2">Jam Kerja</th>
                </tr>

                <tr>
                    <th width="100"> Masuk</th>
                    <th width="100"> Pulang</th>


                </tr>
            </thead>


            <tbody>

                <?php


                for ($t = 1; $t < 31; $t++) {

                    $tgl =    $periode . '-' . $t;
                    $newDate = format_db($tgl);
                    #$day = date('l', strtotime($newDate));
                    $hari = getNamahari($newDate);

                    echo ' 
                                       
                                                       <tr>
                                                        <input type="hidden" name="tgl[]" value="' . $t . '">
                                                         <td class="text-center">' . $t . '</td>
                                                         <td class="text-center">' . $hari . '</td>
                                     
                                                        <td class="text-center">
                                                            <select name="shift[]" class="form-shift">';

                    foreach ($shift_kerja as $listshift) {
                        $kode_shift = $listshift->kode_shift;

                        $init_shift = $this->Presensi_model->getDataInitialShift($t);
                        if (!empty($init_shift)) {
                            $shiftKode = $init_shift[0]->shift;
                        } else {
                            $shiftKode = '';
                        }


                        if ($shiftKode == $kode_shift) {
                            $checkShift = 'selected';
                        } else {
                            $checkShift = '';
                        }
                        echo ' <option value="' . $kode_shift . '" ' . $checkShift . '>' . $listshift->kode_shift . '</option>';
                    }

                    echo '</select>
                                                        </td>
                                                        <td class="text-darkblue text-center">' . $jamMasukKerja  . '</td>
                                                        <td class="text-darkblue  text-center">' . $jamKeluarKerja . '</td>
                                            
                                                 
                                                        
                                                 </tr>';
                }


                ?>




            </tbody>
        </table>
    </div>

</form>