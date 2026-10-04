<?php
    // $bulan = $this->session->userdata('periode_bulan');
    // $tahun = $this->session->userdata('periode_tahun');

    $bulan = 12;
    $tahun = 2023;

    $periode = $tahun . '-' . $bulan;
    $periode = date('Y-m', strtotime($periode));
    $lastDate = date('t', strtotime($periode)) + 1;
    $nip = $this->session->userdata('nip');
    $id_pegawai = $this->session->userdata('id_pegawai');

    $jns_jam_kerja = $detail_pegawai[0]->jns_jam_kerja;


    $pin = substr($nip, -4);
    ?>    
                                
                <thead>
                    <tr>
                        <th width="50" rowspan="2">Tanggal</th>
                        <th width="100" rowspan="2">Hari</th>
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
                     $keterangan = '';
                     $totalTelat = 0;
                     $totalPawal = 0;
                     $totalIzin = 0;
                     $totalSakit = 0;
                     $totalCuti = 0;
                     $totalDLA = 0;
                     $totalDLAK = 0;
                     $totalDLP = 0;
                     $btn_input = '';

                    for ($t = 1; $t < $lastDate; $t++) 
                    {
                        $tanggal      = $periode . '-' . $t;
                        $formatDate   = date('Y-m-d', strtotime($tanggal));
                        $day          = date('l', strtotime($tanggal));

                        $absenMasuk    = $this->Presensi_model->getAbsenMasuk($pin, $tanggal);
                        $absenPulang   = $this->Presensi_model->getAbsenPulang($pin, $tanggal);

                        $hari          = getNamahari($tanggal);
                        #Secho $id_pegawai.'----'.$tanggal;
                        $shiftKerja    = $this->Presensi_model->getShiftPegawai($id_pegawai, $tanggal);

                        $bg_btn        = '';
                        $JamKerjaShift = $this->Presensi_model->detailShiftByKode($shiftKerja);
                        if(!empty($JamKerjaShift )){
                            $kode_shift  = $JamKerjaShift->kode_shift;
                            $jamMasuk  = $JamKerjaShift->jam_masuk;
                            $jamPulang  = $JamKerjaShift->jam_pulang;

                            if($jamPulang =='00:00:00'){
                                $jamPulang  = '';
                            }

                            if($jamMasuk =='00:00:00'){
                                $jamMasuk  = '';
                            }
                            
                        }else{
                            $shift_kerja  = '-';
                            $jamMasuk  = '';
                            $jamPulang  =  '';
                            $jam_kerja_pegawai  =  '';

                        }

                        if($jamMasuk != '' ){
                            if($absenMasuk==''){

                                $telat = 300;

                                $cekCuti = $this->Presensi_model->cekCutiPegawai($id_pegawai, $tanggal);
                                if(empty($cekCuti)){
                                    //klo cutinya ga ada

                                    $cekLibur = $this->Presensi_model->cekHariLibur($tanggal);
                                    if(empty($cekLibur)){
                                        //cari DL Penuh
                                        $cekDLAwal = $this->Presensi_model->cekDL($id_pegawai, $tanggal, 1);
                                        if(empty($cekDLAwal)){
                                            $cekDLPenuh = $this->Presensi_model->cekDL($id_pegawai, $tanggal, 3);

                                            if(empty($cekDLPenuh)){

                                                $cekIzinSakit = $this->Presensi_model->cekIzinSakit($id_pegawai, $tanggal);
                                                if(empty($cekIzinSakit)){
                                                    $telat = 300;
                                                    $absenMasuk = '<span class="badge bg-danger-subtle text-danger">ALPHA</span>';
                                                   
                                                }else{
                                                    $telat = 0;

                                                    if($cekIzinSakit[0]->jns_absen==4){
                                                        $absenMasuk = '<span class="badge bg-warning-subtle text-warning">IZIN</span>';
                                                        $totalIzin = $totalIzin+1;
                                                     
                                                       
                                                    }else{
                                                        $absenMasuk = '<span class="badge bg-warning-subtle text-warning">SAKIT</span>';
                                                        $totalSakit = $totalSakit+1;
                                                        
                                                    }
                                                   
                                                }


                                                
                                            }else{
                                                 $telat = 0;
                                                 $keterangan = $cekDLPenuh[0]->keterangan;
                                                 $absenMasuk = '<span class="badge bg-info-subtle text-info">DL-PENUH</span>';
                                                 $totalDLP =  $totalDLP+1;
                                                 $btn_input = '<a href="'.base_url().'admin/presensi/delete_absensi_dl/'.$cekDLPenuh[0]->id.'/'.$pin.'/'.$id_pegawai.'" class="badge badge-outline text-red">Delete</a>';
                                            }

                                        }else{
                                            $telat = 0;
                                            $keterangan = $cekDLAwal[0]->keterangan;
                                            $absenMasuk = '<span class="badge bg-info-subtle text-info">DL-AWAL</span>';
                                            $totalDLA = $totalDLA+1;
                                            $btn_input = '<a href="'.base_url().'admin/presensi/delete_absensi_dl/'.$cekDLAwal[0]->id.'">Delete</a>';
                                        }


                                    }else{
                                        $telat = 0;
                                        $absenMasuk = '<span class="badge  bg-primary-subtle text-primary">LIBUR NASIONAL</span>';
                                    }
                                    
                                }else{
                                    $telat = 0;
                                    $absenMasuk = '<span class="badge  bg-info-subtle text-info">CUTI</span>';
                                    $totalCuti= $totalCuti+1;
                                }

                               # print_array($cekCuti);
                                
                            }else{
                                $telat = getHourDifference($jamMasuk, $absenMasuk);
                            }
                        }else{

                            $telat = 0;
                        }

                        if($jamPulang != '' ){
                            $p_awal = 150;
                            if($absenPulang==''){
                                $cekCuti = $this->Presensi_model->cekCutiPegawai($id_pegawai, $tanggal);
                                if(empty($cekCuti)){
                                    //klo cutinya ga ada
                                    $cekLibur = $this->Presensi_model->cekHariLibur($tanggal);
                                    if(empty($cekLibur)){
                                        $cekDLAkhir = $this->Presensi_model->cekDL($id_pegawai, $tanggal, 2);
                                        if(empty($cekDLAkhir)){
                                            $cekDLPenuh = $this->Presensi_model->cekDL($id_pegawai, $tanggal, 3);
                                            if(empty($cekDLPenuh)){

                                                $cekIzinSakit = $this->Presensi_model->cekIzinSakit($id_pegawai, $tanggal);
                                                if(empty($cekIzinSakit)){
                                                    $p_awal = 150;
                                                    $absenPulang = '<span class="badge bg-danger-subtle text-danger">ALPHA</span>';
                                                    $btn_input = '<span class="badge badge-outline '.$bg_btn.' input-absen" value="'.$tanggal.'" data-bs-toggle="modal" data-bs-target="#modal-input"> Input</span>';
                                                }else{
                                                    $p_awal = 0;

                                                    if($cekIzinSakit[0]->jns_absen==4){
                                                        $absenPulang = '<span class="badge bg-warning-subtle text-warning">IZIN</span>';
                                                    }else{
                                                        $absenPulang = '<span class="badge bg-warning-subtle text-warning">SAKIT</span>';
                                                    }


                                                   
                                                }


                                                
                                            }else{
                                                $keterangan = $cekDLPenuh[0]->keterangan;
                                                 $p_awal = 0;
                                                 $absenPulang = '<span class="badge bg-info-subtle text-info">DL-PENUH</span>';
                                            }

                                        }else{
                                            $keterangan = $cekDLAkhir[0]->keterangan;
                                            $p_awal = 0;
                                            $totalDLAK = $totalDLAK+1;
                                            $absenPulang = '<span class="badge bg-info-subtle text-info">DL-AKHIR</span>';
                                            $btn_input = '<a href="'.base_url().'admin/presensi/delete_absensi_dl/'.$cekDLAkhir[0]->id.'/'.$pin.'/'.$id_pegawai.'" class="badge badge-outline text-red">Delete</a>';
                                        }
                                    }else{
                                        $p_awal = 0;
                                        $absenPulang = '<span class="badge bg-purple-lt">LIBUR NASIONAL</span>';
                                    }


                                   

                                }else{
                                    $p_awal = 0;
                                    $absenPulang = '<span class="badge  bg-info-subtle text-infot">CUTI</span>';
                                }

                               
                            }else{
                                $p_awal = getHourDifference($jamPulang, $absenPulang, 'p.awal');
                            }
                        }else{
                                $p_awal = 0;   
                           
                        }


                        $totalTelat = $totalTelat+$telat;
                        $totalPawal = $totalPawal+$p_awal;


                        echo '  <tr>
                                    <td class="text-center">' . $t . '</td>
                                    <td class="text-center">' . $hari . '</td>
                                    <td class="text-darkblue text-center">'.$jamMasuk  .'</td>
                                    <td class="text-darkblue  text-center">'.$jamPulang.'</td>
                                    <td class="text-center">'.$absenMasuk.'</td>
                                    <td class="text-center">'.$absenPulang.'</td>
                                    <td class="text-center">'.$telat.'</td>
                                    <td class="text-center">'. $p_awal.'</td>
                                    <td style="text-align:left">'. $keterangan.'</td>
                                        
                                </tr>';

                            $keterangan = '';
                            $btn_input = '';

                            

                    }


                    ?>
                </tbody>