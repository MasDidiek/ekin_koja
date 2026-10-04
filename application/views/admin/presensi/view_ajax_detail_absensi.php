<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans:400,700);



    p {
        font-size: 13px;
    }


    input,
    section {
        clear: both;
        padding-top: 10px;
        display: none;
    }

    label {
        font-weight: bold;
        font-size: 14px;
        display: block;
        float: left;
        padding: 10px 30px;
        border-top: 2px solid transparent;
        border-right: 1px solid transparent;
        border-left: 1px solid transparent;
        border-bottom: 1px solid #DDD;
    }

    label:hover {
        cursor: pointer;
        text-decoration: underline;
    }

    #tab1:checked~#content1,
    #tab2:checked~#content2,
    #tab3:checked~#content3,
    #tab4:checked~#content4,
    #tab5:checked~#content5 {
        display: block;
    }

    input:checked+label {
        border-top-color: #FFB03D;
        border-right-color: #DDD;
        border-left-color: #DDD;
        border-bottom-color: transparent;
        text-decoration: none;
    }
</style>

<main>

    <?php
    $arrayAbsen = array('DL-PENUH', 'DL-AWAL', 'DL-AKHIR', 'SAKIT', 'IZIN', 'ALPHA');
    $nama       = $detail_pegawai[0]->nama;

    $id_pegawai = $detail_pegawai[0]->id_pegawai;
    $nip        = $detail_pegawai[0]->nip;
    $pin        = substr($nip, -4);

    if (!empty($absensiHarian)) {
        $kodeShift         = $absensiHarian[0]->shift;
        $jamMasukKerja     = $absensiHarian[0]->jam_masuk;
        $jamKeluarKerja    = $absensiHarian[0]->jam_pulang;

        $absenMasuk         = $absensiHarian[0]->masuk;
        $absenPulang        = $absensiHarian[0]->pulang;
        $keterangan_absen   = $absensiHarian[0]->keterangan;


        $absenTidakhadir = '';

        if ($absenMasuk == 'DLP') {
            $absenMasuk = '<span class="fs-2  badge bg-primary-subtle  text-primary">DL-PENUH</span>';
            $absenPulang = '<span class="fs-2  badge bg-primary-subtle  text-primary">DL-PENUH</span>';
            $absenTidakhadir = 'DL-PENUH';
        } else if ($absenMasuk == 'DLA') {
            $absenMasuk = '<span class="fs-2  badge bg-info-subtle text-info ">DL-AWAL</span>';
            $absenTidakhadir = 'DL-AWAL';
        } else if ($absenMasuk == 'SAKIT') {
            $absenMasuk = '<span class="fs-2  badge bg-warning-subtle text-warning">SAKIT</span>';
            $absenPulang = '<span class="fs-2  badge bg-warning-subtle text-warning">SAKIT</span>';
            $absenTidakhadir = 'SAKIT';
        } else if ($absenMasuk == 'IZIN') {
            $absenMasuk = '<span class="fs-2  badge bg-warning-subtle text-warning">IZIN</span>';
            $absenPulang = '<span class="fs-2  badge bg-warning-subtle text-warning">IZIN</span>';
            $absenTidakhadir = 'IZIN';
        } else if ($absenMasuk == 'CUTI') {
            $absenMasuk = '<span class="fs-2 badge  bg-success-subtle text-success">CUTI</span>';
            $absenPulang = '<span class="fs-2  badge  bg-success-subtle text-success">CUTI</span>';
            $absenTidakhadir = 'CUTI';
        }



        if ($absenPulang == 'DLH') {
            $absenTidakhadir = 'DL-AKHIR';
            $absenPulang = '<span class="fs-2 badge bg-info-subtle text-info">DL-AKHIR</span>';
        }
    } else {
        $absenMasuk   = '';
        $absenPulang  = '';
        $keterangan_absen  = '';
        $absenTidakhadir = '';

        $kodeShift         =  '';
        $jamMasukKerja     =  '';
        $jamKeluarKerja    = '';
    }

    #print_array($izinSakit);
    ?>

    <div class=" p-2 fs-5 mb-2">
        <strong> <?php echo $nama; ?></strong>
        <br>
        <small> <?php echo $nip;   #print_array($shift_kerja);
                ?></small>
    </div>

    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1">Absensi</label>
    <input id="tab2" type="radio" name="tabs">
    <label for="tab2">Dinas Luar</label>
    <input id="tab3" type="radio" name="tabs">
    <label for="tab3">Cuti</label>
    <input id="tab4" type="radio" name="tabs">
    <label for="tab4">Izin</label>
    <input id="tab5" type="radio" name="tabs">
    <label for="tab5">Input Jam Absen</label>

    <section id="content1">

        <table class="table table-bordered">
            <tr>
                <th class="text-start bg-light">Hari / Tanggal</th>
                <td class="text-start"> <span class="text-dark  fw-semibold"><?php echo format_hari($tanggal); ?>, <?php echo format_full($tanggal); ?></span></td>
            </tr>
            <tr>
                <th class="text-start  bg-light">Shift Kerja</th>
                <td class="text-start"><?php echo $kodeShift; ?></td>
            </tr>

            <tr>
                <th class="text-start bg-light">Jam Kerja</th>
                <td class="text-start">

                    <i class="far fa-clock text-success"></i> &nbsp;<?php echo $jamMasukKerja; ?>&nbsp; &nbsp; - &nbsp; &nbsp;
                    <i class="fas fa-power-off text-danger"></i> &nbsp; <?php echo $jamKeluarKerja; ?>
                </td>
            </tr>

            <tr>
                <th class="text-start bg-light">Jam Absen</th>
                <td class="text-start">
                    <i class="far fa-clock text-success"></i> &nbsp;<?php echo $absenMasuk; ?> &nbsp; &nbsp; - &nbsp; &nbsp;
                    <i class="fas fa-power-off text-danger"></i> &nbsp; <?php echo $absenPulang; ?>
                </td>
            </tr>


        </table>
    </section>
    <section id="content2">


        <table class="table table-bordered">
            <tr>
                <th>Tanggal</th>
                <th>Jenis DL</th>
                <th>Keterangan</th>
                <th>Status</th>
                <th width="100">File</th>
                <th width="100">Action</th>
            </tr>
            <?php
            foreach ($dinasLuar as $dl) {
                $statusDL = $dl->status;
                if ($statusDL == 0) {
                    $flagStatusDL = '<span class="badge bg-warning-subtle text-warning">Pending</span>';
                } else {
                    $flagStatusDL = '<span class="badge bg-success-subtle text-success">Approved</span>';
                }
                echo '  <tr>
                                      <td>' . $dl->tanggal . '</td>
                                      <td>' . $dl->jns_dl . '</td>
                                      <td>' . $dl->keterangan . '</td>
                                      <td>' . $flagStatusDL . '</td>
                                      <td>
                                        <a href="' . base_url() . 'uploads/photo_dinas_luar/thumb/' . $dl->photo . '" class="btn border btn-sm ">
                                           <i class="fa-solid fa-image"></i> 
                                        </a> 
                                        
                                        <a href="' . base_url() . 'uploads/surat_tugas/' . $dl->surtug . '" class="btn border btn-sm ">
                                            <i class="fa-solid fa-file"></i>
                                        </a> 
                                        
                                        </td>
                                      <td>
                                          <a href="' . base_url() . 'admin/presensi/setujui_pengajuan_dl2/' . $dl->id . '/1/' . $pin . '" class="btn btn-success btn-sm "> 
                                                <i class="fa-solid fa-check"></i>&nbsp; ACC
                                            </a> 
                                    
                                      </td>
                                </tr>';
            }
            ?>

        </table>
    </section>
    <section id="content3">

        <table class="table table-bordered">
            <tr>
                <th>Tanggal</th>
                <th>Tanggal Cuti</th>
                <th>Keterangan</th>
                <th>Status</th>

                <th width="100">Action</th>
            </tr>
            <?php

            foreach ($cuti as $list) {


                $id_cuti = $list->id;
                $jns_cuti = $list->jns_cuti;
                $alasan_cuti = $list->alasan_cuti;
                $tgl_dari = $list->tgl_dari;
                $tgl_sampai = $list->tgl_sampai;
                $hari_cuti = $list->hari_cuti;
                $status = $list->status;

                $jenis_cuti = getJenisCuti($jns_cuti);

                $btn_upload = ' ';
                if ($status == 'APPROVE') {
                    $flag_status = '<span class="badge bg-success">' . $status . '</span>';
                    $btn_upload = '  <a href="' . base_url() . 'admin/presensi/insert_absen_cuti/' . $list->id . '/' . $list->id_pegawai . '" class="btn btn-info btn-sm "> 
                                                <i class="fa-solid fa-upload"></i>&nbsp; upload
                                            </a> ';
                } else if ($status == 'CANCEL') {
                    $flag_status = '<span class="badge bg-danger">' . $status . '</span>';
                } else {
                    $flag_status = '<span class="badge bg-warning">' . $status . '</span>';
                }



                echo '  <tr>
                                      <td class="text-center">' . $list->tgl . '</td>
                                      <td class="text-center">';
                if ($hari_cuti == 1) {
                    echo '<strong>' . format_view($tgl_dari) . '</tstrongd>';
                } else {
                    echo '<strong>' . format_view($tgl_dari) . ' </strong> <br>
                                                <strong> ' . format_view($tgl_sampai) . '</strong>';
                }
                echo '</td>
                                      <td>' . $alasan_cuti . '</td>
                                      <td>' . $flag_status . '</td>
                                      <td width="130" class="text-center">' . $btn_upload . ' </td>
                                </tr>';
            }
            ?>

        </table>

    </section>
    <section id="content4">
        <?php

        for ($p = 0; $p < count($izinSakit); $p++) {
            $id = $izinSakit[$p]->id;
            $status = $izinSakit[$p]->status;

            if ($status == 0) {
                $flag_class = '<span class="badge bg-warning-subtle text-warning">Belum diperiksa</span>';
            } else {
                if ($status == 1) {
                    $status_valid = 'Disetujui';
                    $bg_badge = 'bg-success-subtle text-success';
                } else {
                    $status_valid = 'Ditolak';
                    $bg_badge = 'bg-danger-subtle text-danger';
                }
                $flag_class = '<span class="badge ' . $bg_badge . '">Sudah divalidasi ( <strong> ' . $status_valid . ' </strong>)</span>';
            }
        ?>
            <table class="table table-sm table-borderless p-2">
                <tr>
                    <td>Jenis Absen</td>
                    <td> <span><?php echo $izinSakit[$p]->jenis_absen; ?></span></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td> <span><?php echo $izinSakit[$p]->keterangan; ?></span></td>
                </tr>

                <tr>
                    <td>Upload On</td>
                    <td><span><?php echo $izinSakit[$p]->create_at; ?></span></td>
                </tr>
                <tr>
                    <td>Photo :</td>
                    <td>
                        <a href="<?php echo base_url(); ?>uploads/surat_izin/<?php echo $izinSakit[$p]->file_image; ?>" target="_blank" class="text-info btn-light">
                            <i class="fas fa-file-image"></i> Lihat Surat izin / Sakit
                        </a>

                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td><?php echo $flag_class; ?></td>
                </tr>
                <tr>
                    <td>Action</td>
                    <td>
                        <?php if ($status == 0) { ?>
                            <button type="button" class="btn btn-success btn-sm btn-validasi" value="1/<?php echo $id . '/' . $pin; ?>">Setujui</button>
                            <button type="button" class="btn btn-danger btn-sm  btn-validasi" value="2/<?php echo $id . '/' . $pin; ?>">Reject</button>

                        <?php } else {
                            echo '-';
                        } ?>
                    </td>
                </tr>
            </table>
        <?php } ?>

    </section>
    <section id="content5">
        <form method="post" action="<?php echo base_url() . 'admin/presensi/insert_absen_manual/' . $pin . '/' . $tanggal; ?>">


            <strong> Input Jam Absen </strong>

            <div class="row alert-info">
                <div class="col-md-6">

                    <input type="text" name="jam_masuk" placeholder="Jam Masuk " class="form-control">
                </div>
                <div class="col-md-6">
                    <input type="text" name="jam_pulang" placeholder="Jam Pulang" class="form-control">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-sm btn-info float-end">Simpan</button>
            <div class="clearfix"> </div>
        </form>

    </section>
</main>