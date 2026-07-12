

        <div id="main" class="main-content">
           

            <?php
        
                $id_driver =  $detail_pemeriksaan[0]->id_driver;
                $data_detail =  $this->Driver_model->get_data_edit($id_driver);

                $id_pemeriksaan = $detail_pemeriksaan[0]->id;
                $dataPemeriksaan = $detail_pemeriksaan;
                $riwayatPTMKeluarga = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_ptm_keluarga');
                $riwayatPTMDiri = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_ptm');
                $faktorResiko   = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_faktor_resiko');

                $tgl_periksa = $detail_pemeriksaan[0]->date_time;
                $status_ht = $detail_pemeriksaan[0]->status_ht;
                $status_gds = $detail_pemeriksaan[0]->status_gds;
                $status_laik = $detail_pemeriksaan[0]->status_laik;
                $petugas = $detail_pemeriksaan[0]->petugas;
                $rujuk = $detail_pemeriksaan[0]->rujuk;

                $tensi_sistol = $detail_pemeriksaan[0]->tensi_sistol;
                $tensi_diastol = $detail_pemeriksaan[0]->tensi_diastol;
                $nama_terminal = $detail_pemeriksaan[0]->nama_terminal;
                $gds = $detail_pemeriksaan[0]->gds;


                $flagHT = getFlagHT($status_ht);
                $flagGDS = getFlagGDS($status_gds);
                $flagLaik = getFlagLaik($status_laik);

                if($rujuk==1){
                    $status_rujuk = 'Ya';
                }else{
                    $status_rujuk = 'Tidak';
                }
                 
                $tes_keseimbangan = $faktorResiko[0]->tes_keseimbangan;
                $tes_urine = $faktorResiko[0]->tes_urine;
                
                if($tes_keseimbangan==1){
                    $keseimbangan ='<span class="badge badge-success">Normal</span>';
                }else if($tes_keseimbangan==2){
                      $keseimbangan ='<span class="badge badge-warning">Tidak Normal karena kelainan anatomis</span>';
                }else{
                      $keseimbangan ='<span class="badge badge-danger">Tidak Normal karena kelainan neurologis</span>';
                }
                
                if($tes_urine==0){
                    $narkoba = '<span class="badge badge-warning">Amphetamin Tidak diperiksa</span>';
                }else if($tes_urine==1){
                      $narkoba = '<span class="badge badge-success">Amphetamin Negatif (-)</span>';
                }else{
                      $narkoba = '<span class="badge badge-danger">Amphetamin Positif (+)</span>';
                }
                  
            ?>

           
            <?php
                    if($rujuk==1){
             ?>
                <a href="<?php echo base_url();?>admin/admin_driver/cetak_rujuk/<?php echo $id_pemeriksaan;?>" target="_blank" class="btn btn-primary float-end">
                   <i class="align-middle" data-feather="print"></i>   Cetak Rujukan                
                 </a>

             <?php } ?>
                            
                            
                 <a href="<?php echo base_url();?>admin/admin_driver/cetak_surat_keterangan_laik/<?php echo $id_pemeriksaan;?>"  target="_blank" style="margin:0 5px;" class="btn btn-success float-end">
                   <i class="align-middle" data-feather="print"></i> Cetak Keterangan Laik                
                 </a>
                 
                 <a href="<?php echo base_url();?>admin/admin_driver/ubah_data_pemeriksaan/<?php echo $id_pemeriksaan;?>" class="btn btn-info float-end">
                  <i class="align-middle" data-feather="edit"></i>  Ubah Data Pemeriksaan             
                 </a>
                 
                 <div class="clearfix"></div>
                 <br>
           
            <div class="row">
                  <div class="col-md-4">
                      <h4>Data Diri Pengemudi</h4>
                 
                     <table class="table table-sm table-borderless">
                            <tr>
                                <td width="200">Nama</td>
                                <td width="20">:</td>
                                <td><strong><?php echo $data_detail[0]->nama;?></strong></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td><?php echo $data_detail[0]->no_ktp;?></td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td><?php echo $data_detail[0]->tgl_lahir;?></td>
                            </tr>
                            
                            <tr>
                                    <td width="200">Nama PO </td>
                                    <td width="20">:</td>
                                    <td><?php echo $data_detail[0]->nama_po;?></td>
                                </tr>
                                <tr>
                                    <td>Status Supir</td>
                                    <td>:</td>
                                    <td><?php echo $data_detail[0]->status_supir;?></td>
                                </tr>
                        </table>
                  </div> <!-- col-md-6-->
                  <div class="col-md-8">
                   
                          <h4>Pemeriksaan Pengemudi</h4>
                            
                                <table class="table table-sm table-borderless">
                                 <tr>
                                    <td  width="200">Tanggal Pemeriksaan</td>
                                    <td width="20">:</td>
                                    <td><?php echo $tgl_periksa;?></td>
                                </tr>
                               
                                <tr>
                                    <td>Lokasi Pemeriksaan</td>
                                    <td>:</td>
                                    <td>Terminal <?php echo $nama_terminal;?></td>
                                </tr>
                                <tr>
                                    <td>Nama Petugas</td>
                                    <td>:</td>
                                    <td><?php echo $detail_pemeriksaan[0]->petugas;?></td>
                                </tr>
                                
                                  <tr>
                                    <td>Tekanan Darah</td>
                                    <td>:</td>
                                    <td><?php echo $dataPemeriksaan[0]->tensi_sistol;?>/<?php echo $dataPemeriksaan[0]->tensi_diastol;?>   mm/Hg 
                                    &nbsp;  &nbsp; <?php echo $flagHT;?></td>
                                </tr>
                                 <tr>
                                    <td>Gula Darah Sewaktu</td>
                                    <td>:</td>
                                    <td> <?php echo $dataPemeriksaan[0]->gds;?> mg/dl &nbsp;  &nbsp; <?php echo $flagGDS;?> </td>
                                </tr>
                                 <tr>
                                    <td>Tes Keseimbangan</td>
                                    <td>:</td>
                                    <td><?php echo $keseimbangan;?></td>
                                </tr>
                                
                                  <tr>
                                    <td>Amphetamin Urine</td>
                                    <td>:</td>
                                    <td><?php echo $narkoba;?></td>
                                </tr>
                                  <tr>
                                    <td>Rekomendasi Pengemudi</td>
                                    <td>:</td>
                                    <td><?php echo $flagLaik;?></td>
                                </tr>
            
                                <tr>
                                    <td>Dirujuk</td>
                                    <td>:</td>
                                    <td><?php echo $status_rujuk;?></td>
                                </tr>
            
            
                          </table>
                          
                          
                        <h5>Data Pemeriksaan Fisik</h5>
                        <br>
                         <table class="table table-sm table-borderless">
                            <tr>
                                <td width="200">Berat Badan (BB)</td>
                                 <td width="20">:</td>
                                <td><?php echo $dataPemeriksaan[0]->bb;?> Kg</td>
                            </tr>
                             <tr>
                                <td>Tinggi Badan (TB)</td>
                                 <td>:</td>
                                <td><?php echo $dataPemeriksaan[0]->tb;?>  Cm</td>
                            </tr>
                             <tr>
                                <td>Lingkar Pinggang (LP)</td>
                                 <td>:</td>
                                <td><?php echo $dataPemeriksaan[0]->lp;?>  Cm</td>
                            </tr>
                             <tr>
                                <td>Tensi</td>
                                 <td>:</td>
                                <td><?php echo $dataPemeriksaan[0]->tensi_sistol;?>/<?php echo $dataPemeriksaan[0]->tensi_diastol;?>   mm/Hg</td>
                            </tr>
                             <tr>
                                <td>Gula Darah Sewaktu (GDS)</td>
                                 <td>:</td>
                                <td><?php echo $dataPemeriksaan[0]->gds;?> mg/dl</td>
                            </tr>
                        </table>
                        
                        <br><br>
                         <h5>Data Riwayat PTM</h5>
                              <table class="table table-sm table-bordered">
                                 <tr>
                                     <th>Nama Penyakit</th>
                                     <th>Keluarga</th>
                                     <th>Diri Sendiri</th>
                                 </tr>
                                 
                                 <tr>
                                     <td>Diabetes Melistus</td>
                                     <td align="center">
                                         <?php  echo  ($riwayatPTMKeluarga[0]->dm == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                      <td align="center">
                                         <?php  echo  ($riwayatPTMDiri[0]->dm == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                 </tr>
                                  <tr>
                                     <td>Hipertensi</td>
                                      
                                       <td align="center">
                                         <?php  echo  ($riwayatPTMKeluarga[0]->hipertensi == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                     <td align="center">
                                         <?php  echo  ($riwayatPTMDiri[0]->hipertensi == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                 </tr>
                                  <tr>
                                     <td>Jantung</td>
                                    
                                        <td align="center">
                                         <?php  echo  ($riwayatPTMKeluarga[0]->jantung == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                       <td align="center">
                                         <?php  echo  ($riwayatPTMDiri[0]->jantung == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                 </tr>
                                  <tr>
                                     <td>Stroke</td>
                                     
                                        <td align="center">
                                         <?php  echo  ($riwayatPTMKeluarga[0]->stroke == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                      <td align="center">
                                         <?php  echo  ($riwayatPTMDiri[0]->stroke == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                 </tr>
                                  <tr>
                                     <td>Asma</td>
                                
                                       <td align="center">
                                         <?php  echo  ($riwayatPTMKeluarga[0]->asma == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                        <td align="center">
                                         <?php  echo  ($riwayatPTMDiri[0]->asma == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                 </tr>
                                  <tr>
                                     <td>Kanker</td>
                                    
                                        <td align="center">
                                         <?php  echo  ($riwayatPTMKeluarga[0]->kanker == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                      <td align="center">
                                         <?php  echo  ($riwayatPTMDiri[0]->kanker == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                 </tr>
                                 <tr>
                                     <td>Kolesterol</td>
                                      <td align="center">
                                         <?php  echo  ($riwayatPTMKeluarga[0]->kolesterol == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                     <td align="center">
                                         <?php  echo  ($riwayatPTMDiri[0]->kolesterol == 0) ? 'Tidak' : 'Ya'; ?>
                                     </td>
                                 </tr>
                             
                            </table>
                                  
                  </div> <!-- col-md-6-->
                
            </div>
           


       


        </div>

            </div>
           
                
      