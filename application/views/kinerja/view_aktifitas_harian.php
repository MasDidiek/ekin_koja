<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .btn-edit{
            border:none;
            color:#0ebf8e;
            font-size:18px;
            background:none;
            display: inline-block;
        }
        .btn-delete{
            border:none;
            color:#F00;
            font-size:18px;
            background:none;
            display: inline-block;
        }
        .jam{
            font-size:12px;

        }

    </style>
</head>
<body>

<?php
$id_pegawai  = $this->session->userdata('id_pegawai');
    $TotalPerhari = 0;
    foreach ($aktifitas as $akt) {
        $total1 = $akt->total;
        $TotalPerhari = $TotalPerhari +$total1;

    }

    $izinSakit         = $this->Presensi_model->cekIzinSakit($id_pegawai, $tanggal_aktifitas);
    $cekCutiPegawai    = $this->Cuti_model->cekCutiPegawai($tanggal_aktifitas, $id_pegawai);

    $bulanNow = date('m');
    $bulanAktifitas = date('m', strtotime($tanggal_aktifitas));




?>

    <div class="row">

        <div class="col-md-8 text-center">
             <table class="table table-bordered table-sm">
                 <tr>
                    <th><h5><?php echo format_hari($tanggal_aktifitas).', '. format_full($tanggal_aktifitas);?></h5></th>
                    <th>Masuk  <br> <span class="badge badge-success-lighten fs-5" id="absen_masuk"><?php echo $absensi[0];?></span> </th>
                    <th>Keluar  <br>
                        <span class="badge badge-danger-lighten fs-5" id="absen_keluar">

                        <?php echo $absensi[1];?>
                        </span>
                    </th>
                </tr>

             </table>


        </div>
    </div>

    <br>
   <span class="alert alert-info">
     Total : <strong><?php echo  $TotalPerhari;?> menit</strong>
   </span>

    <?php




        $showBtnInput = true;

        $dateNow = date('d');

        if($bulanAktifitas < $bulanNow){

            if($dateNow < 6){
                $showBtnInput = true;
            }else{
                $showBtnInput = false;
            }
        }


        if(!empty($izinSakit)){
            if($izinSakit[0]->jenis_absen=='IZIN'){
                $jns_pengajuan = 'IZIN';
            }else{
                $jns_pengajuan = 'SAKIT';
            }
            echo ' <div class="alert alert-danger mt-3">Anda tidak dizinkan menginput aktifitas harian</div>';
            $showBtnInput = false;

        }


        if(!empty($cekCutiPegawai)){
            echo ' <div class="alert alert-danger  mt-3">Anda tidak dizinkan menginput aktifitas harian</div>';
            $showBtnInput = false;

        }



        if($showBtnInput==true){
            echo '<button class="btn btn-info float-end mb-2" value="'.$tanggal_aktifitas.'" type="button" id="insert_aktifitas"><i class="uil-edit"></i> Input Aktifitas
             </button>';
        }

    ?>


    <table class="table">
         <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Kegiatan</th>
                <th>Status</th>
                <th width="120">Action</th>
            </tr>
         </thead>
         <tbody>
            <?php

                    for ($i=0; $i < count($aktifitas) ; $i++) {
                        $id = $aktifitas[$i]->id;
                        $jam_mulai = $aktifitas[$i]->jam_mulai;
                        $jam_selesai = $aktifitas[$i]->jam_selesai;
                        $nama_kegiatan = $aktifitas[$i]->nama_kegiatan;
                        $ket = $aktifitas[$i]->ket;
                        $status = $aktifitas[$i]->status;
                        $waktu_efektif = $aktifitas[$i]->waktu_efektif;

                        $jam_aktifitas = $jam_mulai.' s/d '.$jam_selesai;
                        $volume = $aktifitas[$i]->volume;
                        $total = $aktifitas[$i]->total;

                        if($status==1){
                            $flag_status = '<span class="badge bg-success">Disetujui</span>';
                        }else if($status==2){
                            $flag_status = '<span class="badge bg-danger">Ditolak</span>';
                        }else{
                            $flag_status = '<span class="badge bg-warning">Pending</span>';
                        }

                        echo ' <tr>
                                    <td>'.($i+1).'</td>
                                    <td class="jam text-center"> '.$jam_aktifitas.' <br><br>

                                     </td>
                                    <td><strong>'.$nama_kegiatan.'</strong><br>

                                           <p> <i> '.$ket.'</i></p>

                                     <span class="text-primary">Waktu Efektif : <strong> '.$waktu_efektif.' </strong>  menit </span>  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                      <span class="text-info">Volume : <strong> '.$volume.'</strong> </span>    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;
                                      <span class="text-info">Total : <strong>'.$total.' </strong>  menit</span>
                                    </td>


                                    <td>'.$flag_status.'</td>
                                    <td>
                                      <button class="btn-edit" value="'.$id.'" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight"
                                        aria-controls="offcanvasRight"><i class="uil-edit-alt"></i>
                                        </button>
                                        <a href="'.base_url().'kinerja/deleteAktifitas/'.$id.'" class="btn-delete" onClick="return confirm(\'Apakah anda ingin menghapus aktifitas ini?\')"><i class="uil-trash-alt"></i></a>
                                    </td>
                                </tr>';
                    }
            ?>

         </tbody>
    </table>


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 id="offcanvasRightLabel">Ubah Data Aktifitas</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body" id="form_edit">

        </div>
    </div>


    <script>
            $(".btn-edit").click(function(){
                var id = $(this).val();

                 $("#form_edit").html(id);

                 $.ajax({

                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>kinerja/ajaxGetEditAktifitas",
                        data:"id="+id,
                        success:function(msg){
                            $("#form_edit").html(msg);
                        }
                 });
            });


            $("#insert_aktifitas").click(function(){
                var tanggal = $(this).val();



                 $.ajax({

                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>kinerja/input_aktifitas",
                        data:"tanggal="+tanggal,
                        success:function(msg){
                            $(".modal-body").html(msg);
                        }
                 });
            });





        </script>

</body>
</html>
