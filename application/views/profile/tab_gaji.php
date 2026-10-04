<div >
    <div class="row ">
        <div class="col-lg-12">
            <h4 class="fw-semibold mb-3">Data Penggajian</h4>
        </div>

        <?php
        $tgl_masuk               = $pegawai[0]->tgl_masuk;
        $nama                    = $pegawai[0]->nama;
        $masa_kerja              = $pegawai[0]->masa_kerja;
        $kategori_masa_kerja     = $pegawai[0]->kategori_masa_kerja;
        $id_jabatan              = $pegawai[0]->id_jabatan;
        $id_pendidikan           = $pegawai[0]->id_pendidikan;
        $jabatan                 = $this->Master_model->getNamaJabatan($id_jabatan);

        $kategori                = $this->Master_model->getMasaKerja($kategori_masa_kerja);
        $pendidikan                 = $this->Master_model->getNamaPendidikan($id_pendidikan);



        $expl = explode("-", $masa_kerja);
        $tahun = @$expl[0] . ' Tahun';
        $bulan = @$expl[1] . ' Bulan';
        $hari  = @$expl[0] . ' Hari';

        $masa_kerja_detail = $tahun . ' ' . $bulan . ' ' . $hari;

        $id_pendidikan   = $pegawai[0]->id_pendidikan;
        $status_kawin    = $pegawai[0]->status_kawin;

        //echo $status_kawin;

        if ($status_kawin == 1) {
            $status = 'Menikah &nbsp;  ( 2 anak )';
        } else if ($status_kawin == 2) {
            $status = 'Menikah &nbsp;  ( 1 anak )';
        } else if ($status_kawin == 3) {
            $status = 'Menikah';
        } else {
            $status = 'Belum Menikah';
        }

        if (!empty($data_gaji)) {
            $gaji_pokok = $data_gaji[0]->gaji_pokok;
            $pengkalian = $data_gaji[0]->pengkalian;
            $pph21 = $data_gaji[0]->pph21;
            $bpjs_kes = $data_gaji[0]->bpjs_kes;
            $bpjs_tk = $data_gaji[0]->bpjs_tk;
            $ptkp = $data_gaji[0]->ptkp;
            $last_date_recount = $data_gaji[0]->last_date_recount;
            $last_date_recount = format_slash($last_date_recount);
            $tkd = $gaji_pokok * $pengkalian;
        } else {
            $gaji_pokok = 0;
            $pengkalian = 0;
            $pph21 = 0;
            $bpjs_kes = 0;
            $bpjs_tk = 0;
            $ptkp = 0;
            $last_date_recount = '';
            $tkd = $gaji_pokok * $pengkalian;
        }


        ?>


        <div class="col-lg-7">

            <table class="table table-md">
                <tr>
                    <td width="200">Nama</td>
                    <td class="text-end fw-bold"><?php echo $nama; ?></td>
                </tr>
                <tr>
                    <td>Tanggal Masuk</td>
                    <td class="text-end fw-bold"><?php echo format_full($tgl_masuk); ?></td>
                </tr>
                <tr>
                    <td>Masa Kerja</td>
                    <td class="text-end fw-bold"><?php echo  $masa_kerja_detail; ?> <br> <span class="text-info">( update at &nbsp; <?php echo $last_date_recount; ?>)</span></td>
                </tr>
                <tr>
                    <td>Golongan Masa Kerja</td>
                    <td class="text-end fw-bold"><?php echo $kategori[0]->masa_kerja; ?> Tahun </td>
                </tr>
            </table>

            <table class="table table-md">
                <tr>
                    <td width="200">Pendidikan</td>
                    <td class="text-end fw-bold"><?php echo $pendidikan; ?></td>
                </tr>
                <tr>
                    <td>Status Pernikahan</td>
                    <td class="text-end fw-bold"><?php echo $status; ?></td>
                </tr>
                <tr>
                    <td>Jabatan</td>
                    <td class="text-end fw-bold"><?php echo  $jabatan; ?></td>
                </tr>

            </table>


        </div>

        <div class="col-lg-5">


            <table class="table table-md">
                <tr>
                    <td width="200">Gaji Pokok</td>
                    <td class="text-end fw-bold"><?php echo   rupiah($gaji_pokok); ?></td>
                </tr>
                <tr>
                    <td>Pengali TKD</td>
                    <td class="text-end fw-bold"><?php echo $pengkalian; ?> x </td>
                </tr>
                <tr>
                    <td>Besaran TKD<br><span class="text-sm">(gaji pokok x pengali TKD) </span> </td>
                    <td class="text-end fw-bold"><?php echo   rupiah($tkd); ?></td>
                </tr>
                <tr>
                    <td>PPh21</td>
                    <td class="text-end fw-bold"><?php echo   rupiah($pph21); ?></td>
                </tr>
                <tr>
                    <td>BPJS Kesehatan</td>
                    <td class="text-end fw-bold"><?php echo   rupiah($bpjs_kes); ?></td>
                </tr>
                <tr>
                    <td>BPJS Ketenagakerjaan</td>
                    <td class="text-end fw-bold"><?php echo   rupiah($bpjs_tk); ?></td>
                </tr>
                <tr>
                    <td>PTKP</td>
                    <td class="text-end fw-bold"><?php echo   rupiah($ptkp); ?></td>
                </tr>
            </table>

        </div>


    </div>
</div>