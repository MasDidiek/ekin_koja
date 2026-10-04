<?php

            //print_array($this->session->userdata);
                $id_validator    = $this->session->userdata('id_pegawai');
                $usergroup    = $this->session->userdata('usergroup');
                $my_nip       = $this->session->userdata('nip');

                #echo $usergroup;
                $id   =  $detail_cuti[0]->id;
                $tgl_dari   =  $detail_cuti[0]->tgl_dari;
                $tgl_sampai =  $detail_cuti[0]->tgl_sampai;
                $hari_cuti  =  $detail_cuti[0]->hari_cuti;
                $alasan_cuti  =  $detail_cuti[0]->alasan_cuti;
                $alamat_cuti  =  $detail_cuti[0]->alamat_cuti;
                 $tlp  =  $detail_cuti[0]->no_tlp;
                $id_pegawai =  $detail_cuti[0]->id_pegawai;

                $tgl_pengajuan  =  $detail_cuti[0]->tgl;
                $id_pengganti  =  $detail_cuti[0]->id_pengganti;
                $delegasi_tugas  =  $detail_cuti[0]->delegasi_tugas;


               $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
               $id_pj       = $detail_pegawai[0]->id_validator;
               $nama        = $detail_pegawai[0]->nama;
               $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
               $jabatan     = $detail_pegawai[0]->jabatan;
               $id_jabatan   = $detail_pegawai[0]->id_jabatan;
              
               
               $listPegawaiPengganti  = $this->Cuti_model->getListPegawaiPenggantiCuti( $id_pegawai, $id_jabatan );

               
            ?>
            

            <form method="post" action="<?php echo base_url();?>admin/cuti/update_cuti" enctype="multipart/form-data">
                 <input type="hidden" name="id_cuti" value="<?= $id ;?>">
                 <input type="hidden" name="id_pegawai" value="<?= $id_pegawai ;?>">

                <div class="row">
                    <div class="col-md-12">
                            <div class="mb-2">
                                <label for="">Jenis Cuti</label>
                                <select name="jns_cuti" id="jns_cuti"  class="form-control">

                                        <?php

                                        for ($c=0; $c < count($master_cuti); $c++) {
                                            $id = $master_cuti[$c]->id;
                                            $jenis_cuti = $master_cuti[$c]->jenis_cuti;

                                            $checekd = $master_cuti[$c]->id==$detail_cuti[0]->jns_cuti?'selected':'';

                                            echo ' <option value="'. $id .'" '.$checekd.'>'.$jenis_cuti .'</option>';

                                        }
                                    ?>
                                </select>
                            </div>
                    </div>
                    <div class="col-md-6">
                            <div class="mb-2">
                                <label for="TanggalMulaiCuti">Tanggal Mulai Cuti</label>
                                <div class="input-group">
                                    <input type="date" name="tgl_mulai"  class="form-control bg-white"  required id="tgl_mulai_cuti" value="<?php echo $tgl_dari;?>"  placeholder="Pilih tanggal cuti">
                                    
                                </div>
                            </div>
                     </div>
                      <div class="col-md-6">
                             <div class="mb-2">
                                <label for="TanggalMulaiCuti">Tanggal Akhir Cuti</label>
                                <div class="input-group" >
                                    <input type="date" name="tgl_akhir"  class="form-control bg-white"  required  id="tgl_akhir_cuti"  value="<?php echo $tgl_sampai;?>"  placeholder="Pilih tanggal cuti ">
                                    
                                </div>
                            </div>
                    </div>
                     <div class="col-md-12">
                             <div class="mb-2">
                                    <label for="PenggantiCuti">Pengganti Cuti</label>
                                    <select class="form-control select2" name="id_pengganti" required autofocus data-toggle="select2">
                                        <option>--Pilih pengganti cuti--</option>
                                        <?php
                                            for ($p=0; $p < count($listPegawaiPengganti) ; $p++) {

                                                $id_pegawai = $listPegawaiPengganti[$p]->id_pegawai;
                                                $nama_pegawai = $listPegawaiPengganti[$p]->nama;

                                                if ($id_pegawai==$id_pengganti) {
                                                    $selected = 'selected';
                                                }else{
                                                        $selected = '';
                                                }

                                                echo '<option value="'.$id_pegawai.'" '.$selected.'>'.$nama_pegawai.'</option>';


                                            }
                                        ?>
                                    </select>
                             </div>
                             <div class="mb-2">
                                <label for="AlasanCuti">Alasan Cuti</label>
                                <textarea name="alasan_cuti"  class="form-control bg-white"  required  id="alasan_cuti" placeholder="tuliskan alasan cuti "><?php echo $alasan_cuti;?></textarea>
                             </div>
                              <div class="mb-2">
                                 <label for="AlasanCuti">Alamat Cuti</label>
                                 <textarea name="alamat"  class="form-control bg-white"  required  id="alamat" placeholder="tuliskan alamat  "><?php echo $alamat_cuti;?></textarea>
                             </div>
                              <div class="mb-2">
                                <label for="AlasanCuti">Alasan Cuti</label>
                                <input type="text" id="tlp" name="tlp"  class="form-control" min="10" placeholder="08xxxx" value="<?php echo $tlp;?>" required   autocomplete="off">
                               </td>
                                
                             </div>
                              <div class="mb-2">
                                 <button type="submit" class="btn btn-success " value="" id="btn_edit_cuti">Simpan Perubahan</button>
                              </div>

                    </div>
              </div>

            </form>


