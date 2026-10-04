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
            font-size:14px;
           
        }

 
    </style>
</head>
<body>

<?php
    $TotalPerhari = 0;
    foreach ($aktifitas as $akt) {
        $total1 = $akt->total;
        $TotalPerhari = $TotalPerhari +$total1;

    }

?>
    
   <h5><?php echo format_hari($tanggal_aktifitas).', '. format_full($tanggal_aktifitas);?></h5>
    <br>
   <span class="alert alert-info float-start">
     Total : <strong><?php echo  $TotalPerhari;?> menit</strong>
   </span>

   <br>



    <form action="<?php echo base_url();?>admin/penilaian_kinerja/approveChecklist/<?php echo $id_pegawai;?>" method="post" id="ApproveMultiple">


        <button type="submit" name="status" id="approveAll" value="approve" class="btn btn-success float-end">
            <i class="uil-check"></i> Setujui Aktifitas
            </button>
            <button type="submit"  name="status"  id="rejectAll" value="reject" class="btn btn-danger float-end me-2">
            <i class="uil-x"></i> Tolak  Aktifitas
            </button> 
            
            <div class="clearfix"></div><br>
            
        <table class="table table-bordered mt-1">
            <thead>
                <tr class="bg-light">
                    <th> No</th>
                    <th>Kegiatan</th>
                    <th>Status</th>
                    <th class="text-center">
                        <div class="form-check form-checkbox-success mb-2"> 
                        <input class="check-semua form-check-input " type="checkbox" id="checkAll" value="<?php echo $tanggal_aktifitas;?>"> 
                        </div>
                    </th>
                
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
                                    <td>'.($i+1).' </td>
                                    <td>
                                     '.$jam_aktifitas.' <br><br>
                                     <strong>'.$nama_kegiatan.'</strong><br>
                                    
                                           <p> <i> '.$ket.'</i></p>
                                           
                                     <span class="text-info">Waktu Efektif : <strong> '.$waktu_efektif.' </strong>  menit </span>  &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp; 
                                      <span class="text-info">Volume : <strong> '.$volume.'</strong> </span>    &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;    
                                      <span class="text-info">Total : <strong>'.$total.' </strong>  menit</span>      
                                    </td>


                                    <td>'.$flag_status.'</td>
                                    <td class="text-center">
                                      <div class="form-check form-checkbox-success mb-2">
                                          <input type="checkbox" class="form-check-input  form-check-all" id="customCheck1" name="chk_child[]" value="'.$id.'">
                                         
                                     </div>

                                 
                                    </td>
                                    
                                </tr>';
                     }
                ?>
            
            </tbody>
        </table>

    </form>



    
    <script>

        button = document.getElementById('approveAll');
        button.disabled = true;


        button2 = document.getElementById('rejectAll');
        button2.disabled = true;




        $(".check-semua").click(function(){
            var tgl = $(this).val();
            button.disabled = false;
            button2.disabled = false;
            $(".form-check-all").prop("checked", true);
        });
           

        $(".form-check-all").click(function(){
          
            button.disabled = false;
            button2.disabled = false;
           
        });
           
        


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

          
           
        </script>

</body>
</html>