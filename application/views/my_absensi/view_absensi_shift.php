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


                                        echo '  <tr>
                                                    <td class="text-center">' . $t . '</td>
                                                    <td class="text-center">' . $hari . '</td>
                                                    <td id="tr_'.$t.'" class="text-center">'. $shift_kerja.' </td>
                                                    <td class="text-secondary text-center">'.$jamMasuk  .'</td>
                                                    <td class="text-secondary  text-center">'.$jamPulang.'</td>
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