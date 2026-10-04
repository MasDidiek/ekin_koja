<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>

<title> ekinerja - Puskesmas Cilincing</title>
  
<style>
            body{
              font-family: Arial, Helvetica, sans-serif;
            }

            .main{
                width: 1000px;
                height: auto;
                margin: 0 auto;
                padding:20px;
                border: 1px solid #EEE;
            }
            table{
             width: 100% ;
            }

            table{
            border-collapse: collapse;
            }
            .table-absensi th{
            border: 1px solid #666;
            padding: 10px;
            text-align: center;
            font-size: 15px;
            }
            .table-absensi td{
                border: 1px solid #666;
                padding: 8px;
                text-align: center;
                font-size: 14px;
                color:#555

            }
            .left-ttd{
                width: 49%;
                height: 200px;
                background: #FFF;
                display: inline-block;
                margin-top: 50px;
                text-align: center;
            }  
            .right-ttd{
                width: 49%;
                height: 200px;
                background: #FFF;
                display: inline-block;
                margin-top: 50px;
                text-align: center;
            }
          
          
</style>
</head>

<body>
 <!--  Body Wrapper -->
 
      <?php

            #print_array($this->session->userdata);
            // $bulan = $this->session->userdata('periode_bulan');
            // $tahun = $this->session->userdata('periode_tahun');

            $periode_bulan = $this->session->userdata('periode_bulan'); 
            $periode_tahun = $this->session->userdata('periode_tahun'); 
            $id_pkm_sess   = $this->session->userdata('id_pkm');

          
            if($periode_bulan=='') {
                $bulan = date('m');
                $tahun = date('Y');
  
              }else{
                $bulan = $periode_bulan;
                $tahun = $periode_tahun;
              }

              
 
            $nm_bulan = getBulan($bulan);
            $periode = $tahun.'-'.$bulan;
            $periode = date('Y-m', strtotime($periode));


            $lastDate = date('t', strtotime($periode)) + 1;

            $id_pegawai = $this->uri->segment(4);

            $nip = $data_pegawai[0]->nip;
            $shift = $jns_jam_kerja= $data_pegawai[0]->jns_jam_kerja;
            $nama_pegawai = $data_pegawai[0]->nama;
            $id_puskesmas = $data_pegawai[0]->id_puskesmas;
         
            $puskesmas = $this->Presensi_model->getNamaPuskesmas($id_puskesmas);
          
            $pin = substr($nip, -4);

            $Kapuskec = $this->Pegawai_model->getKapuskec();

            
            ?>

    <div class="main">


            <center>
                    <h1>Data Kehadiran</h1>
            </center>

          <h3>
                <?php echo $nama_pegawai ;?> 
                <a href="<?php echo base_url();?>admin/presensi/edit_data_pegawai/<?php echo $pin.'/'.$id_pegawai;?>" class="text-primary" title="edit data pegawai" >
                <i class="fas fa-edit"></i>
                </a>
                <br>
                <span class="text-muted fs-3"><?php echo $nip ;?></span>

            </h3>

            <small><?php echo $puskesmas;?></small>
            <?php

            if($shift ==1){
                    echo '<span class="badge bg-info-subtle text-info">Shift</span>';
            }
            ?>
            <br>
            Periode : <strong> <?php echo date('F Y', strtotime($periode));?> </strong>

            <br><br>
                        
        <table class="table-absensi table-sm">
        <thead>
            <tr>
                <th width="50" rowspan="2">Tanggal</th>
                <th width="100" rowspan="2">Hari</th>
                <th width="100" rowspan="2">Shift</th>
                <th width="160" colspan="2">Jam Kerja</th>
                <th width="160" colspan="2">Jam Absen</th>

                <th width="100"  rowspan="2">Telat</th>
                <th width="100"  rowspan="2">P Awal</th>
                <th  rowspan="2">Keterangan</th>
            
            
            </tr>

            <tr>
                <th width="100">  Masuk</th>
                <th width="100"> Pulang</th>
                <th width="100"> Masuk</th>
                <th width="100"> Pulang</th>
            </tr>
        </thead>
        <tbody>

            <?php

                $tgl_now = date('Y-m-d');
        
                    $totalTelat = 0;
                    $totalPawal = 0;  

                    $totalIzin = 0;
                    $totalSakit = 0;
                    $totalCuti = 0;


                for ($t = 1; $t < $lastDate; $t++) {
                    $tanggal = $periode . '-' . $t;
                    $formatDate = date('Y-m-d', strtotime($tanggal));
                    $day = date('l', strtotime($tanggal));
                    $hari = getNamahari($tanggal);

                    $absensiHarian  = $this->Presensi_model->getDataAbsensi($pin, $formatDate);
                    if(!empty($absensiHarian)){
                        $kodeShift         = $absensiHarian[0]->shift;
                        $jamMasukKerja     = $absensiHarian[0]->jam_masuk;
                        $jamKeluarKerja    = $absensiHarian[0]->jam_pulang;
        
                        $absenMasuk         = $absensiHarian[0]->masuk;
                        $absenPulang        = $absensiHarian[0]->pulang;
                        $keterangan_absen   = $absensiHarian[0]->keterangan;

                        $telat         = $absensiHarian[0]->telat;
                        $p_awal         = $absensiHarian[0]->p_awal;
                    }else{
                        $kodeShift         = '';
                        $jamMasukKerja      = '';
                        $jamKeluarKerja    = '';
        
                        $absenMasuk        = '';
                        $absenPulang        = '';
                        $keterangan_absen   = '';

                        $telat         = 0;
                        $p_awal         = 0;

                    }




                    if($jns_jam_kerja == 'non_shift'){

                    //khusus untuk yang jam kerjanya shift
                    if($hari != 'Sabtu' && $hari != 'Minggu'){

                        
                        if($absenMasuk=='' && $jamMasukKerja != '' && $formatDate < $tgl_now ){
                        $absenMasuk = '-';
                        $telat          = 300;
                        }

                            
                        if($absenPulang=='' && $jamKeluarKerja != ''  && $formatDate < $tgl_now ){
                        $absenPulang = '-';
                        $p_awal         = 150;
                        }


                    }

                            
                        $hariLibur = $this->Presensi_model->cekHariLibur($tanggal);
                        $hari_libur = false;
                        if(!empty($hariLibur )){
                        $kodeShift         = '';
                        $jamMasukKerja     = '-';
                        $jamKeluarKerja    = '-';
        
                        $absenMasuk         = '<span class="text-danger btn bg-danger-subtle fs-2">LIBUR NASIONAL</span>';
                        $absenPulang        =  '<span class="text-danger btn bg-danger-subtle fs-2">LIBUR NASIONAL</span>';
                        $keterangan_absen   = $hariLibur[0]->keterangan;

                        
                        $telat          = 0;
                        $p_awal         = 0;
                        $hari_libur = true;


                        }
                    }else{
                        if($kodeShift=='P' || $kodeShift=='S' || $kodeShift=='PS'){

                        
                        if($absenMasuk==''){
                            $absenMasuk = '-';
                            $telat         = 300;
                        }

                            if($absenPulang==''){
                            $absenPulang = '-';
                            $p_awal         = 150;
                            }
                        
                        }

                        if($kodeShift=='L-OFF'){
                        
                        if($absenPulang==''){
                            $absenPulang = '-';
                            $p_awal         = 150;
                        }
                        }
                        
                        if($kodeShift=='SM' ||$kodeShift=='M' ||$kodeShift=='PSM'){
                        if($absenMasuk=='' && $jamMasukKerja != '' ){
                            $absenMasuk = '-';
                            $telat          = 300;
                        }

                        }



                    }


                    if($kodeShift=='OFF'){
                        $jamMasukKerja  = '';
                        $jamKeluarKerja  = '';
                        $bg_btn = 'btn-danger';
                    
                    }else if($kodeShift=='L-OFF'){
                    
                        $bg_btn = 'btn-warning';
                        $jamMasukKerja  = '-';
                        
                    }else{
                    $bg_btn = 'btn-info';
                    }

                    if($jamKeluarKerja=='00:00:00'){
                    $jamKeluarKerja  = '-';
                    }

                    if ($absenMasuk =='CUTI') {
                        $absenMasuk         = '<span class="text-success btn bg-success-subtle">CUTI</span>';
                        $absenPulang        =  '<span class="text-success btn bg-success-subtle">CUTI</span>';
                    }

                    if ($absenMasuk =='DLP') {
                        $absenMasuk         = '<span class="text-success btn bg-success-subtle  btn-delete-dl"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >DLP</span>';
                        $absenPulang        =  '<span class="text-success btn bg-success-subtle  btn-delete-dl"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >DLP</span>';
                    }

                    if ($absenMasuk =='IZIN') {
                        $absenMasuk         = '<span class="text-warning btn bg-warning-subtle  btn-delete-izin"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >IZIN</span>';
                        $absenPulang        =  '<span class="text-warning btn bg-warning-subtle  btn-delete-izin"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >IZIN</span>';
                    }

                    if ($absenPulang =='DLAK') {
                        
                        $absenPulang        =  '<span class="text-info btn bg-info-subtle  btn-delete-dl"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >DLAK</span>';
                    }

                    if ($absenMasuk =='SAKIT') {
                        $absenMasuk         = '<span class="text-warning btn bg-warning-subtle  btn-delete-sakit"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >SAKIT</span>';
                        $absenPulang        =  '<span class="text-warning btn bg-warning-subtle  btn-delete-sakit"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm" >SAKIT</span>';
                    }



                    $totalTelat = $totalTelat+$telat;
                    $totalPawal = $totalPawal+$p_awal;


                        echo '  <tr>
                                        <td class="text-center">' . $t . '</td>
                                        <td class="text-center">' . $hari . '</td>
                                        <td class="text-center">'. $kodeShift.'</td>
                                        

                                        <td class="text-info text-center">'.$jamMasukKerja  .'</td>
                                        <td class="text-danger  text-center">'.$jamKeluarKerja.'</td>
                                        <td class="text-center">'.$absenMasuk;
                                        if($absenMasuk == ''){
                                        echo '<span class="btn-hover-show"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg"><i class="fa-solid fa-pencil"></i></span>';
                                        }else{
                                        echo '<a href="'.base_url().'admin/presensi/delete_absensi/'.$tanggal.'/'.$pin.'/'.$id_pegawai.'/0" class="float-end hover-show"><i class="fa-solid fa-trash"></i></a>';
                                        }

                                        echo '</td>
                                        <td class="text-center" class="td-jam-absen">'.$absenPulang;

                                        if($absenPulang != ''){
                                        echo '<a href="'.base_url().'admin/presensi/delete_absensi/'.$tanggal.'/'.$pin.'/'.$id_pegawai.'/1" class="float-end hover-show"><i class="fa-solid fa-trash"></i>  </a>';
                                        }else{
                                        echo '<span class="btn-hover-show"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg"><i class="fa-solid fa-pencil"></i></span>';
                                        }

                                    
                                        echo '</td>
                                        <td class="text-center">'.$telat.'</td>
                                        <td class="text-center">'. $p_awal.'</td>
                                        <td style="text-align:left">'. $keterangan_absen.'</td>
                                        
                                        
                            </tr>';

                            

                            

                }


                ?>
                        <tr>
                            <td colspan="7"></td>
                            <td><?php echo $totalTelat ;?></td>
                            <td><?php echo $totalPawal ;?></td>
                            <td></td>
                        </tr>
                </tbody>
            </table>



            <div class="left-ttd">
                <p>Pegawai</p>
                <p>&nbsp;</p> <p>&nbsp;</p>
                <?php echo $nama_pegawai;?> <br>
                NIP .  <?php echo $nip;?>
            </div>


            <div class="right-ttd">
            Mengetahui<br>
            Kepala Puskesmas Cilincing
            <p>&nbsp;</p> <p>&nbsp;</p>
               <?php echo $Kapuskec[0]->nama;?> <br>
                NIP . <?php echo $Kapuskec[0]->nip;?>
            </div>


        </div>
                 
        


  </body>


  
</html>