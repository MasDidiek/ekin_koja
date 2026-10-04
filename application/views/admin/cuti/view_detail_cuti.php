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
                $status  =  $detail_cuti[0]->status;
                $id_cuti  =  $detail_cuti[0]->id;
                $id_pegawai =  $detail_cuti[0]->id_pegawai;

                $tgl_pengajuan  =  $detail_cuti[0]->tgl;
                $id_pengganti  =  $detail_cuti[0]->id_pengganti;
                $delegasi_tugas  =  $detail_cuti[0]->delegasi_tugas;

                $file_image =  $detail_cuti[0]->file_image;

                $tgl_check2  =  $detail_cuti[0]->tgl_check2;

                if($tgl_check2 != null){
                  $approve_date = format_full($tgl_check2);
                }else{
                  $approve_date = '';
                }

                $jns_cuti  =  $detail_cuti[0]->jns_cuti;
                if($jns_cuti==1){
                  $jenis_cuti = 'Tahunan';
                }else if($jns_cuti==2){
                  $jenis_cuti = 'Cuti Bersalin';
                }else if($jns_cuti==3){
                  $jenis_cuti = 'Cuti Alasan Penting';
                }else if($jns_cuti==4){
                  $jenis_cuti = 'Cuti Sakit';
                }else if($jns_cuti==5){
                  $jenis_cuti = 'Cuti Besar';
                }else{
                  $jenis_cuti = 'Cuti Bersalin Anak 3';
                }

                $message = $this->session->flashdata('message');


               if($hari_cuti==1){
                   $tgl_cuti = '<span class="text-dark">'.format_full($tgl_dari).'</span>';
               }else{
                   $tgl_cuti = '<span class="text-dark">'.format_full($tgl_dari).' </span> &nbsp;&nbsp;&nbsp; s/d &nbsp;&nbsp;&nbsp;<span class="text-dark">'.format_full($tgl_sampai).'</span>';
               }


               //$flagStatus = getStatusCuti($status);


               $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
               $id_pj       = $detail_pegawai[0]->id_validator;
               $nama        = $detail_pegawai[0]->nama;
               $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
               $jabatan     = $detail_pegawai[0]->jabatan;
               $puskesmas   = $detail_pegawai[0]->puskesmas;
               $jns_pegawai = $detail_pegawai[0]->jns_pegawai;


               $photoPengaju   = $this->Pegawai_model->getPhotoPegawai($detail_pegawai[0]->nip);


               $detail_pegawai_pengganti = $this->Pegawai_model->getDetailPegawai($id_pengganti);
               $jabatan_pengganti        = $detail_pegawai_pengganti[0]->jabatan;
               $puskesmas_pengganti      = $detail_pegawai_pengganti[0]->puskesmas;

               $photoPengganti = $this->Pegawai_model->getPhotoPegawai($detail_pegawai_pengganti[0]->nip);
              #print_array($detail_pegawai);
               $delegasi = explode("+", $delegasi_tugas);
               
               if($file_image !=''){
                   $filePenunjang = explode(",", $file_image);
               }else{
                    $filePenunjang = array('');
               }



               $status_persetujuan = '';
               if($status=='APPROVE'){
                $status_persetujuan = 'Disetujui ';
                $flag_cuti = '<span class="p-2 bg-green-100 text-green-500 ">  Disetujui</span>';
              }else if($status=='CANCEL'){
                $flag_cuti = '<span class="p-2 bg-slate-100 text-slate-500">Dibatalkan</span>';
              }else if($status=='REJECT'){
                $flag_cuti = '<span class="p-2 bg-orange-100 text-orange-500">Ditolak</span>';
              }else{
                  $flag_cuti = '<span class="badge bg-warning ">Pending</span>';

                  if($status=='PEND0'){
                    $status_persetujuan = '<div class="badge bg-warning">Menunggu ACC Pengganti</div>';
                  }else if($status=='PEND1'){
                    $status_persetujuan = '<div class="badge bg-info">Menunggu ACC Kapustu/Kasatpel</div>';
                  }else{
                    $status_persetujuan = '<div class="badge bg-primary">Menunggu ACC Ka. TU </div>';
                  }
              }

               
               
            ?>

                   <div class="card-body">
                    <h4>Detail Pengajuan Cuti</h4>

                    <table class="w-full mt-2" id="detail_cuti">
                      
                      <tr>
                        <td  width="200">Pengaju</td>
                        <td width="20">:</td>
                        <td><?php echo $nama;?> </td>
                      </tr>
                        <tr>
                        <td>Pengganti</td>
                        <td>:</td>
                        <td><?php echo $detail_pegawai_pengganti[0]->nama;?> </td>
                      </tr>
                      <tr>
                        <td>Tanggal Mulai</td>
                        <td>:</td>
                        <td><?php echo format_hari($tgl_dari).', '.format_full($tgl_dari);?> </td>
                      </tr>
                      <tr>
                        <td>Tanggal Akhir</td>
                        <td>:</td>
                        <td><?php echo format_hari($tgl_sampai).', '.format_full($tgl_sampai);?></td>
                      </tr>
                      <tr>
                        <td>Lama Cuti</td>
                        <td>:</td>
                        <td><?php echo $hari_cuti;?> Hari</td>
                      </tr>
                      <tr>
                        <td>Jenis Cuti</td>
                        <td>:</td>
                        <td><?php echo $jenis_cuti ;?></td>
                      </tr>
                      <tr>
                        <td>Alasan Cuti</td>
                        <td>:</td>
                        <td><?php echo $detail_cuti[0]->alasan_cuti ;?></td>
                      </tr>
                      <tr>
                        <td>Alasan Selama Cuti</td>
                        <td>:</td>
                        <td><?php echo $detail_cuti[0]->alamat_cuti ;?></td>
                      </tr>

                      <tr>
                        <td>Status</td>
                        <td>:</td>
                        <td><?php echo $status_persetujuan ;?></td>
                      </tr>

                      
                    </table>

                      <br>
                        <a href="<?php echo base_url('admin/cuti/sinkron/'.$id.'/'.$id_pegawai);?>" class="btn btn-warning btn-sm">Sinkron</a>
                    </div>

                                     