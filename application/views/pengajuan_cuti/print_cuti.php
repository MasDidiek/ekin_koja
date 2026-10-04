
        <!doctype html>

        <html lang="en">
          <head>
          <title>e-cuti - Puskesmas Cilincing</title>
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

          <style>

                table
                  {
                    border-collapse:collapse;
                    color:#000;
                  }
                  .coret{
                    text-decoration:line-through;
                  }
                  td{
                    font-size:17px;
                  }
          </style>
          </head>
          <body >

                      

                      <?php
                              $id_validator_session = $this->session->userdata('id_validator_session');
                              $day = date('d');
                              $year = date('Y');
                              $buln = date('m');
                              $bulanNow = getBulan($buln);

                              $tgl       = $detail_cuti[0]->tgl;
                              $id_cuti       = $detail_cuti[0]->id;
                              $id_pegawai       = $detail_cuti[0]->id_pegawai;
                              $tgl_dari         = $detail_cuti[0]->tgl_dari;
                              $tgl_sampai       = $detail_cuti[0]->tgl_sampai;
                              $hari_cuti = $detail_cuti[0]->hari_cuti;
                              $id_pengganti     = $detail_cuti[0]->id_pengganti;
                  
                  
                              $jns_cuti         = $detail_cuti[0]->jns_cuti;
                              $alasan_cuti         = $detail_cuti[0]->alasan_cuti;
                              $alamat_cuti         = $detail_cuti[0]->alamat_cuti;
                              $no_tlp         = $detail_cuti[0]->no_tlp;
                              $status         = $detail_cuti[0]->status;
                              $check_ktu   = $detail_cuti[0]->check_ktu;
                              $cek_pengganti   = $detail_cuti[0]->cek_pengganti;
                              $check_kapuskel = $detail_cuti[0]->check_kapuskel;
                              $check_kapuskec = $detail_cuti[0]->check_kapuskec;
                              $alasan_tolak = $detail_cuti[0]->alasan_tolak;
                              $tgl_cek = $detail_cuti[0]->tgl_cek; //tgl cek pengganti cuti

                                //print_array($detail_cuti);

                              $detail_pegawai   = $this->Pegawai_model->getDetailPegawai($id_pegawai);
                              //print_array($detail_pegawai);
                              $nama_pengaju    = $detail_pegawai[0]->nama;
                              $rumpun_kerja          = $detail_pegawai[0]->rumpun_kerja;
                              $id_puskesmas    = $detail_pegawai[0]->id_puskesmas;
                              $nip_pengaju     = $detail_pegawai[0]->nip;
                              $sisa_cuti_n     = 0;
                              $sisa_cuti_n1    = 8;
                              $jns_pegawai     = $detail_pegawai[0]->jns_pegawai;
                              $id_validator     = $detail_pegawai[0]->id_validator;
                              $id_jabatan     = $detail_pegawai[0]->id_jabatan;
                              $masa_kerja     = $detail_pegawai[0]->masa_kerja;

                              $jabatan         = $detail_pegawai[0]->jabatan;
                              $puskesmas_unit_kerja         = $detail_pegawai[0]->puskesmas;
                              $piket_cuber     ='';
                           
                            
                            
                              $namaValidator    = '';
                              $nipValidator     = '';
                              $keterangan       = '';


                           

                                $chekCutiTahunan = '';
                                $chekCutiMelahirkan = '';
                                if ($jns_cuti == 1) {
                                    $cuti = 'Tahunan';
                                    $chekCutiTahunan = '<i class="fa fa-check" aria-hidden="true"></i>';
                                    $kethari  = '(hari/<span class="coret"> bulan/tahun </span>)';
                                    $kethari2 = 'hari';
                                } else if ($jns_cuti == 2) {
                                    $cuti = 'Sisa Cuti';
                                    $hari_cuti = '3';
                                    $kethari  = '(hari/<span class="coret"> bulan/tahun </span>)';
                                    $kethari2 = 'bulan';
                                    $chekCutiMelahirkan = '<i class="fa-solid fa-check"></i>';
                                } else if ($jns_cuti == 3) {
                                  $chekCutiMelahirkan = '<i class="fa fa-check" aria-hidden="true"></i>';
                                  $kethari  = '(<span class="coret">hari</span>/bulan / <span class="coret">tahun </span>)';
				                          $kethari2 = 'bulan';
                                } else {
                                    $cuti = 'Alasan Penting';
                                }


                                if($hari_cuti==1)
                                {
                                  $tgl_cuti = format_view($tgl_dari) ;
                                }else{
                                  $tgl_cuti = format_view($tgl_dari).' s/d '. format_view($tgl_sampai) ;
                                }
   
                                
                              $hariDari   = getNamahari($tgl_dari);
                              $hariSampai = getNamahari($tgl_sampai);

                              $detail_validator   = $this->Pegawai_model->getDataEditPegawai($id_validator);
                              

                           
                              if($jns_pegawai=='pns'){
                                $titlePejabat = ' Kepala Suku Dinas Kesehatan<br> Kota Administrasi Jakarta Utara';
                                $namaValidator = 'dr. Lysbeth Regina Pandjaitan,M.Biomed';
                                $nipValidator  = '197503242006042004';


                                if($rumpun_kerja=='admen'){
                                        $kapuskec = $this->Master_model->getKapuskec();
                                        $namaValidator2 = $kapuskec[0]->nama;
                                        $nipValidator2  = $kapuskec[0]->nip;
                                        $titlePejabat2 = ' Ka Subbag Tata Usaha<br> Puskesmas Cilincing';
                                }else{

                                        $titlePejabat2 = ' Kepala Suku Dinas Kesehatan<br> Kota Administrasi Jakarta Utara';
                                        $namaValidator2 = 'dr. Lysbeth Regina Pandjaitan,M.Biomed';
                                        $nipValidator2  = '197503242006042004';

                                }

                              }else{

                                $namaValidator = $detail_validator[0]->nama;
                                $nipValidator  = $detail_validator[0]->nip;

                                if($id_puskesmas==1){
                                        //orang PKC

                                        if($rumpun_kerja=='ukp'){

                                        //kasatpel UKP
                                                $titlePejabat = ' Kepala Satuan Pelaksana  UKP Puskesmas Cilincing';

                                        }else if($rumpun_kerja=='ukm'){
                                                //kasatpel ukm
                                                $titlePejabat = ' Kepala Satuan Pelaksana  UKM Puskesmas Cilincing';
                                        }else{
                                                //kasubbag tu
                                                $titlePejabat = ' Kepala Subbagian Tata Usaha Puskesmas Cilincing ';
                                        }


                                }else{
                                        //di pustu
                                        $namaPuskesmas = $this->Master_model->getNamaPuskesmas($id_puskesmas);
                                        $puskesmas = str_replace("Pustu", "", $namaPuskesmas);
                                       // echo $namaPuskesmas;
                                        $titlePejabat = ' Kepala Puskesmas Pembantu '.$puskesmas;

                                }
                                


                                $titlePejabat2 = ' Kepala Subbagian Tata Usaha Puskesmas Cilincing ';
                                //sesuai dengan peraturan semua pegawai non pns baik di PKC maupun dipustu TTDnya adalah KTU
                                $KTU = $this->Master_model->getKasubbagTU();
                                $namaValidator2 = $KTU[0]->nama;
                                $nipValidator2  = $KTU[0]->nip;

                              

                              }//close if jenis pegawai

                      
                              ?>


                          <div style="width:1000px; height:auto; border:1px solid #EEE; margin:0 auto; padding:0 20px;">
                          <table  width="100%" cellpadding="5">
                              <td width="50%">&nbsp;</td>
                                  <td width="60%" style="font-size:18px">
                                 
                                    <table>
                                        <tr>
                                           <td width="100"> Lampiran II</td>
                                           <td colspan="3">Surat Edaran Kepala Badan Kepegawaian</td>
                                           <td> </td>
                                         
                                        </tr>
                                        <tr>
                                           <td> </td>
                                           <td colspan="3">  Daerah Provinsi DKI Jakarta</td>
                                           <td> </td>
                                           
                                        </tr>
                                        
                                        <tr>
                                          <td> </td>
                                          <td width="100">No</td>
                                          <td>:</td>
                                          <td>11/SE/2023</td>
                                        </tr>
                                        <tr>
                                          <td> </td>
                                          <td>Tanggal</td>
                                          <td>:</td>
                                          <td>14 Desember 2023</td>
                                        </tr>


                                        <tr height="50">
                                                <td></td>
                                                <td></td>
                                                <td> </td>
                                        </tr>
                                        <tr >
                                                <td> </td>
                                                <td colspan="2">Jakarta, <?php echo $day;?> <?php echo $bulanNow;?> <?php echo $year;?></td>
                                                <td></td>
                                               
                                        </tr>
                                        <tr>
                                                <td></td>
                                                <td>Kepada</td>
                                                
                                        </tr>
                                        <tr>
                                          <td style="text-align:right; padding-right:5px">   Yth. </td>
                                          <td  colspan="2">  Kepala Suku Dinas Kesehatan </td>
                                        </tr>
                                        <tr>  
                                                <td></td>
                                                <td  colspan="2"> Kota Adm Jakarta Utara <br> di </td>
                                        </tr>
                                        <tr>
                                                <td></td>
                                                <td></td>
                                                <td>Jakarta</td>
                                        </tr>



                                    </table>
                                   <br>

                                 
                                   
                                  </td>
                          </table>
                          
                    
                          <center>
                                <div style="font-size:20px">
                                  <strong>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</strong>
                                  <br>
                                  <strong> No Surat : &nbsp; &nbsp; &nbsp; &nbsp;  / &nbsp; &nbsp; &nbsp; &nbsp; </strong>
                                  </div>
                          </center>

                          <br><br>
                                              
                      <table border="1" width="100%" cellpadding="5">
                                
                                
                                <tr>
                                        <td align="left" colspan="4"><strong>1. DATA PEGAWAI</strong></td>
                                </tr>
                                <tr>
                                        <td align="left"><strong>Nama</strong></td>
                                        <td align="left"><?php echo $nama_pengaju;?></td>
                                        <td align="left"><strong>NIP</strong></td>
                                        <td align="left"><?php echo $nip_pengaju;?></td>
                                </tr>
                                <tr>
                                        <td align="left"><strong>Jabatan</strong></td>
                                        <td align="left"><?php echo $jabatan;?></td>
                                        <td align="left"><strong>Masa Kerja</strong></td>
                                        <td align="left"></td>
                                </tr>
                                <tr>
                                        <td align="left"><strong>Unit Kerja</strong></td>
                                        <td align="left" colspan="3"><?php echo $puskesmas_unit_kerja;?></td>
                    
                                </tr>
                        
                        
                        </table>
                        
                      <br>
                        <table border="1" width="100%" cellpadding="5" style="font-size:16px">
                      
                                
                                <tr>
                                        <td align="left" colspan="4"><strong>II. JENIS CUTI YANG DIAMBIL</strong></td>
                                </tr>
                                <tr>
                                        <td align="left" width="300">1. Cuti Tahunan</td>
                                        <td align="center"><?php echo $chekCutiTahunan;?></td>
                                        <td align="left"  width="300">3. Cuti Besar</td>
                                        <td align="center"></td>
                                </tr>
                                <tr>
                                        <td align="left">2. Cuti Sakit</td>
                                        <td align="center"></td>
                                        <td align="left">4. Cuti Melahirkan</td>
                                        <td align="center"><?php echo $chekCutiMelahirkan;?></td>
                                </tr>
                                
                                <tr>
                                        <td align="left">5. Cuti Karena Alasan Penting</td>
                                        <td align="center"></td>
                                        <td align="left">6. Cuti di Luar Tanggungan Negara</td>
                                        <td align="center"></td>
                                </tr>
                                
                        
                        
                        </table>

                                                
                            <br>
                            <table border="1" width="100%" cellpadding="5">
                          
                                    
                                    <tr>
                                            <td align="left" colspan="4"><strong>III. ALASAN CUTI</strong></td>
                                    </tr>
                                    <tr>
                                            <td align="left" colspan="4"> <?php echo $alasan_cuti;?></td>    
                                    </tr>
                                  
                            </table>
                            
                            
                            <br>
                            <table border="1" width="100%" cellpadding="5">
                          
                                    
                                    <tr>
                                            <td align="left" colspan="6"><strong>IV. LAMANYA CUTI</strong></td>
                                    </tr>
                                    
                                    <tr>
                                            <td align="left">Selama</td>
                                            <td align="left"><strong><?php echo $hari_cuti .' '.$kethari2;?></strong> </td>
                                            <td align="left">Mulai Tanggal</td>
                                            <td align="left"><strong><?php echo format_slash($tgl_dari);?></strong></td>
                                            <td align="left">s/d</td>
                                            <td align="left"><strong><?php echo format_slash($tgl_sampai);?></strong></td>
                                    </tr>
                                  
                            </table>
                            
                            <br>
                            <table border="1" width="100%" cellpadding="5" style="font-size:16px">
                                <tr>
                                        <td align="left" colspan="6"><strong>V. CATATAN CUTI ***</strong></td>
                                </tr>
                                
                                <tr>
                                        <td align="left" colspan="3">1. CUTI TAHUNAN</td>
                                        <td align="left">2. CUTI BESAR </td>
                                        <td align="left" width="100"></td>
                      
                                </tr>
                                <tr>
                                        <td align="center">Tahun</td>
                                        <td align="center">Sisa </td>
                                        <td align="center">Keterangan</td>
                                        <td align="left">3. CUTI SAKIT </td>
                                        <td align="left"></td>
                      
                                </tr>
                                <tr>
                                        <td align="left">N-2</td>
                                        <td align="center"> 0</td>
                                        <td align="left"></td>
                                        <td align="left">4. CUTI MELAHIRKAN </td>
                                        <td align="left"></td>
                      
                                </tr>
                                <tr>
                                        <td align="left">N-1</td>
                                        <td align="center"><?php echo $sisa_cuti_n;?> </td>
                                        <td align="left"></td>
                                        <td align="left">5. CUTI KARENA ALASAN PENTING </td>
                                        <td align="left"></td>
                      
                                </tr>
                                <tr>
                                        <td align="left">N</td>
                                        <td align="center"><?php echo $sisa_cuti_n1;?></td>
                                        <td align="left"></td>
                                        <td align="left">6. CUTI DILUAR TANGGUNGAN NEGARA </td>
                                        <td align="left"></td>
                      
                                </tr>
                      
                        </table>
                        
                        <br>
                        <table border="1" width="100%" cellpadding="5">
                      
                                
                                <tr>
                                        <td align="left" colspan="6"><strong>VI. ALAMAT SELAMA MENJALANKAN CUTI</strong></td>
                                </tr>
                                
                                <tr>
                                        <td align="left" width="50%"><?php echo $alamat_cuti;?></td>
                                        <td align="left">TELP</td>
                                        <td align="left"><?php echo $no_tlp;?></td>
                                </tr>
                                <tr>
                                        <td align="center">
                                         
                                        </td>
                                        <td align="center" colspan="2">  Hormat Saya<br>
                                             <p>&nbsp;</p>
                                              <?php echo $nama_pengaju;?><br>
                                                  <?php echo $nip_pengaju;?>
                                                  <br>
                                        </td>
                                </tr>
                              
                        </table>
                        
                        <br>

                        <table border="1" width="100%" cellpadding="5">
  
                                      
                            <tr>
                                    <td align="left" colspan="6"><strong>VII. PERTIMBANGAN ATASAN LANGSUNG **</strong></td>
                            </tr>
                            
                            <tr>
                                   <td align="center">DISETUJUI </td>
                                   
                                    <td align="left">PERUBAHAN ****</td>
                                    <td align="left">DITANGGUHKAN ****</td>
                                    <td align="left"  width="300">TIDAK DISETUJUI ****</td>
                                   
                                  
                            </tr>
                            <tr height="30">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            
                            <tr>
                                    <td align="left" colspan="3"><P>&nbsp;</P></td> 
                                    <td align="center">
                                      
                                      
                                       <?php echo $titlePejabat;?>
                                        <P>&nbsp;</P>  <br>


                                        <?php echo $namaValidator ;?><br>
                                        NIP.  <?php echo $nipValidator ;?>

                                        
                                    </td>
                                  
                            </tr>
                          
                          </table>

                          <br>
                          <table border="1" width="100%" cellpadding="5">

                            
                            <tr>
                                    <td align="left" colspan="6"><strong>VIII. 	KEPUTUSAN PEJABAT  YANG BERWENANG MEMBERIKAN CUTI **</strong></td>
                            </tr>
                            <tr>
                                   <td align="center">DISETUJUI </td>
                                   
                                    <td align="left">PERUBAHAN ****</td>
                                    <td align="left">DITANGGUHKAN ****</td>
                                    <td align="left"  width="300">TIDAK DISETUJUI ****</td>
                                   
                                  
                            </tr>
                            <tr height="30">
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                    <td align="left" colspan="3"><P>&nbsp;</P></td> 
                                    <td align="center">
                                      
                                      
                                    <?php echo $titlePejabat2;?>
                                        <P>&nbsp;</P>  <br>


                                        <?php echo $namaValidator2 ;?><br>
                                        NIP.  <?php echo $nipValidator2 ;?>


                                        
                                    </td>
                                  
                            </tr>
                          
                          
                          </table>




                              <table  width="100%" cellpadding="5">
                                  <tr>
                                      <td width="60">*</td>
                                      <td>Coret yang tidak perlu</td>
                                  </tr>
                                  <tr>
                                      <td>**</td>
                                      <td>Pilih salah satu dengan memberi tanda centang (&radic;)</td>
                                  </tr>
                                  <tr>
                                      <td>***</td>
                                      <td>Diisi oleh pejabat yang menangani bidang kepegawaian sebelum non PNS mengajukan cuti</td>
                                  </tr>
                                  <tr>
                                      <td>****</td>
                                      <td>Diberi tanda centang dan alasan</td>
                                  </tr>

                                  <tr>
                                      <td>N</td>
                                      <td> = Sisa cuti tahun berjalan</td>
                                  </tr>
                                  <tr>
                                      <td>N-1</td>
                                      <td> = Sisa cuti 1 tahun Sebelumnya</td>
                                  </tr>
                                  <tr>
                                      <td>N</td>
                                      <td> = Sisa cuti 2 tahun Sebelumnya</td>
                                  </tr>

                              </table>


                          </div>
              </div>
            </div>


          </div>
        </div>



          </body>
</html>