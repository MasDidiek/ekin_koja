<!DOCTYPE html>
<html>
<head>
    <title>Detail Pengganti Cuti</title>
</head>
<body>



<?php

    //print_array($detail_cuti);

    if(count($cuti)>0)
    {

        $id_cuti = $cuti[0]->id;
        $detail_cuti = $this->Cuti_model->getDetailCuti($id_cuti);

        $id   =  $detail_cuti[0]->id;
        $tgl_dari   =  $detail_cuti[0]->tgl_dari;
        $tgl_sampai =  $detail_cuti[0]->tgl_sampai;
        $hari_cuti  =  $detail_cuti[0]->hari_cuti;
        $status  =  $detail_cuti[0]->status;
        $id_cuti  =  $detail_cuti[0]->id;
        $id_pegawai_pengaju =  $detail_cuti[0]->id_pegawai;

        $tgl_pengajuan  =  $detail_cuti[0]->tgl;
        $id_pengganti  =  $detail_cuti[0]->id_pengganti;
        $delegasi_tugas  =  $detail_cuti[0]->delegasi_tugas;
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

        $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai_pengaju);
        $id_pj       = $detail_pegawai[0]->id_validator;
        $nama        = $detail_pegawai[0]->nama;
        $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
        $jabatan     = $detail_pegawai[0]->jabatan;
        $puskesmas   = $detail_pegawai[0]->puskesmas;
        $jns_pegawai = $detail_pegawai[0]->jns_pegawai;

    }


    $id_pegawai = $this->session->userdata('id_pegawai');


?>


<table class="table table-sm fs-5 text-start">
  <tr>
    <td>Tanggal Pengajuan</td>
    <td class="text-left"> : &nbsp; <strong> <?php echo format_full($tgl_pengajuan);?> </strong></td>
  </tr>

  <tr>
    <td>Pegawai Pengaju Cuti</td>
    <td class="text-left"> : &nbsp; <strong> <?php echo $nama;?></strong> (<?php echo $jabatan ;?>)</td>
  </tr>

  <tr height="40">
    <td>Jenis  Cuti</td>
    <td class="text-left"> : &nbsp;  <strong>Cuti <?php echo $jenis_cuti ;?> </strong></td>
  </tr>
  <tr>
    <td>Tanggal Cuti</td>
    <td class="text-left"> : &nbsp;
      <strong>
        <?php
            if($detail_cuti[0]->hari_cuti==1){
              echo getNamahari($tgl_dari).', '.format_full($tgl_dari);
            }else{
              echo getNamahari($tgl_dari).', '.format_full($tgl_dari) .' s/d '. getNamahari($tgl_sampai).', '.format_full($tgl_sampai);;
            }
        ?>
       </strong>
      </td>
  </tr>

  <tr height="40">
    <td>Lama Cuti</td>
    <td class="text-left"> : &nbsp;  <strong><?php echo $detail_cuti[0]->hari_cuti ;?> hari</strong></td>
  </tr>

  <tr>
    <td>Alasan Cuti</td>
    <td class="text-left"> : &nbsp; <strong> <?php echo $detail_cuti[0]->alasan_cuti ;?> </strong></td>
  </tr>

  <tr height="40">
    <td>Alamat Selama Cuti</td>
    <td class="text-left"> : &nbsp;  <strong><?php echo $detail_cuti[0]->alamat_cuti ;?> </strong></td>
  </tr>

  <tr>
    <td>No Telp / HP</td>
    <td class="text-left"> : &nbsp; <strong> <?php echo $detail_cuti[0]->no_tlp ;?> </strong></td>
  </tr>

  <tr height="60">
    <td>Status Cuti</td>
    <td class="text-left"> : &nbsp; Menunggu Persetujuan</td>
  </tr>

  <tr height="60">
      <td></td>
      <td class="text-left">
          <form id="formSetujuiCuti" data-id="<?= $detail_cuti[0]->id ?>">
              <button type="button" class="btn btn-success" onclick="submitCuti(1)">Setujui Cuti</button>
              <button type="button" class="btn btn-danger" onclick="submitCuti(2)">Tolak Cuti</button>
          </form>
      </td>
  </tr>

</table>


<!-- jQuery CDN -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


        <script>

        </script>

</body>

</html>
