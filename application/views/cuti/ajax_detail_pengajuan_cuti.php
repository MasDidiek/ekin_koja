<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>


    <?php
        $id_cuti    =  $detail_cuti[0]->id;
        $id_pegawai    =  $detail_cuti[0]->id_pegawai;
        $tgl_dari    =  $detail_cuti[0]->tgl_dari;
        $tgl_sampai  =  $detail_cuti[0]->tgl_sampai;
        $jns_cuti  =  $detail_cuti[0]->jns_cuti;
        $jns_hak_cuti  =  $detail_cuti[0]->jns_hak_cuti;
        $id_pengganti  =  $detail_cuti[0]->id_pengganti;
        $alasan_cuti  =  $detail_cuti[0]->alasan_cuti;
        $tlp  =  $detail_cuti[0]->no_tlp;
        $alamat  =  $detail_cuti[0]->alamat_cuti;
        $hariCuti  =  $detail_cuti[0]->hari_cuti;

        $status    =  $detail_cuti[0]->status;
        $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
        $id_jabatan = $detail_pegawai[0]->id_jabatan;


        $detail_pegawai_pengganti = $this->Pegawai_model->getDetailPegawai($id_pengganti);
        $listPegawaiPengganti  = $this->Cuti_model->getListPegawaiPenggantiCuti($id_pegawai, $id_jabatan) ;


        //print_array($detail_pegawai);
        $start_date  = format_semi($tgl_dari);
        $end_date    = format_semi($tgl_sampai);


        if ($jns_cuti==1) {
            # tahunan
            $jenis_cuti = 'Tahunan';
        }elseif ($jns_cuti==2) {
            # Cuti Bersalin
            $jenis_cuti = 'Bersalin';
        }elseif ($jns_cuti==3) {
            # Cuti Alasan Penting
            $jenis_cuti = 'Alasan Penting';
        }elseif ($jns_cuti==4) {
            # Cuti Sakit
            $jenis_cuti = 'Sakit';
        }elseif ($jns_cuti==5) {
            # Besar...
            $jenis_cuti = 'Besar';
        }else{
            #Cuti Bersalin Anak ke 3
            $jenis_cuti = 'Bersalin Anak ke 3';
        }


        $status_cuti = '<span class="badge bg-warning">
        PENDING
        </span>';
        $ket_acc = 'Menunggu persetujuan Pengganti';

        if($status=='PEND1'){

            $ket_acc = 'Menunggu persetujuan Kapustu/Kasatpel';
            $status_cuti = '<span class="badge bg-warning">
            PENDING
            </span>';


            }else if($status == 'PEND2'){

            $ket_acc = 'Menunggu persetujuan Ka.Subbag TU';
            $status_cuti = '<span class="badge bg-warning">
            PENDING
            </span>';

            }elseif($status == 'PEND3' || $status == 'APPROVE'){

            $ket_acc = 'Cuti telah disetujui';
            $status_cuti = '<span class="badge bg-success">APPROVED </span>';

            }elseif($status == 'CANCEL'){

            $status_cuti = '<span class="badge bg-danger">CANCELED </span>';
            $canceled = true;

            }else{
            $approve_date = '';
            $approve_date_ktu = '';
            // $ket_acc = 'Cuti dibatalkan';
            }



    ?>


<div class="row">

                             <div class="col-xxl-12  col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Pegawai yang mengajukan  Cuti</h4>


                                            <table class="table table-sm  ">
                                                  <tr>
                                                        <td width="200"> Nama : </td>
                                                        <th><?php echo $detail_pegawai[0]->nama;?></th>
                                                    </tr>


                                                    <tr>

                                                        <td>NIP </td>
                                                        <th><?php echo $detail_pegawai[0]->nip;?></th>
                                                    </tr>
                                                    <tr>

                                                        <td>Jabatan </td>
                                                        <th><?php echo $detail_pegawai[0]->jabatan;?>, <?php echo $detail_pegawai[0]->keterangan_jabatan;?></th>
                                                    </tr>
                                                    <tr>
                                                        <td> Lokasi Kerja : </td>
                                                        <th><?php echo  $detail_pegawai[0]->puskesmas;?></th>
                                                    </tr>

                                                </table>



                
                                        <h4>Detail Pengajuan Cuti</h4>


                                         <table class="table table-sm  ">
                                                  <tr>
                                                        <td width="200"> Jenis Cuti : </td>
                                                        <th>Cuti <?php echo $jenis_cuti;?></th>
                                                    </tr>


                                                    <tr>

                                                        <td>Tanggal Cuti </td>
                                                        <td> <strong> <?php echo $start_date;?></strong> &nbsp;  s/d    <strong> <?php echo $end_date;?> </strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Lama Cuti :  </td>
                                                        <th> <?php echo $hariCuti;?>  Hari </th>
                                                    </tr>
                                                    <tr>
                                                        <td> Pengganti Cuti : </td>
                                                        <th><?php echo  $detail_pegawai_pengganti[0]->nama;?></th>
                                                    </tr>
                                                    <tr>
                                                        <td> Alasan Cuti : </td>
                                                        <th><?php echo $alasan_cuti;?> </th>
                                                    </tr>
                                                    <tr>
                                                        <td> No Telepon : </td>
                                                        <th><?php echo $tlp;?> </th>
                                                    </tr>
                                                    <tr>
                                                        <td> Alamat Selama Cuti : </td>
                                                        <th><?php echo $alamat;?> </th>
                                                    </tr>

                                                    <tr>
                                                        <td> Status Cuti : </td>
                                                        <th><?php echo $status_cuti;?>  (<?php echo $ket_acc;?>)</th>
                                                    </tr>
                                                </table>


                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
    
</body>
</html>