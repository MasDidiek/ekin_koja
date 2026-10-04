<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4ULw0TXRCvk5YaDkVBUdUwDZXLMs8opc&callback=initMap"
type="text/javascript"></script>

<style>
      #map {
            height: 400px;
            width: 100%;
            margin: 0 auto;
    
          }
   </style>

        <?php
            
            //print_array($pengajuan_dinas_luar);
                    $id_pegawai = $pengajuan_dinas_luar[0]->id_pegawai;
                
                    $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
                    $id_pj       = $detail_pegawai[0]->id_validator;
                    $nama        = $detail_pegawai[0]->nama;
                    $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
                    $jabatan     = $detail_pegawai[0]->jabatan;
                    $puskesmas   = $detail_pegawai[0]->puskesmas;
                    $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
      

                    $id = $pengajuan_dinas_luar[0]->id;
                  
                    $tgl = $pengajuan_dinas_luar[0]->tanggal;
                    $create_at = $pengajuan_dinas_luar[0]->create_at;
                    $jns_dl = $pengajuan_dinas_luar[0]->jns_dl;
                    $photo = $pengajuan_dinas_luar[0]->photo;
                    $keterangan = $pengajuan_dinas_luar[0]->keterangan;
                    $latitude = $pengajuan_dinas_luar[0]->lat;
                    $longitude = $pengajuan_dinas_luar[0]->lon;
                    $status = $pengajuan_dinas_luar[0]->status;
                    $surtug = $pengajuan_dinas_luar[0]->surtug;
    
    
                    
                    if($jns_dl=='DLA'){
                      $flagDL   = '  <span class="badge badge-warning-lighten float-end">DL-AWAL</span>';
                  }else if($jns_dl=='DLP'){
                      $flagDL   = '  <span class="badge badge-info-lighten float-end">DL-PENUH</span>';
                  }else{
                      $flagDL   = '  <span class="badge badge-success-lighten float-end">DL-AKHIR</span>';
                  }
    
                    if($status==0){
                      $classBg =  createClassBadge('warning');
                      $status_dl = ' Pending';
                    }else if($status==1){
                      $classBg =  createClassBadge('success');
                      $status_dl = '  Disetujui';
                    }else{
                      $classBg =  createClassBadge('danger');
                      $status_dl = 'Ditolak';

                    }
    
                    $path   = 'uploads/surat_tugas/';
                           

            ?>


  <div class="row">
    <div class="col-12">
       <strong class="text-dark"><?php echo $detail_pegawai[0]->nama;?></strong>
       <br>  <?php echo $detail_pegawai[0]->nip;?>

       <h5> <?php echo $detail_pegawai[0]->jabatan;?> @ <?php echo $detail_pegawai[0]->puskesmas;?></h5>
      
    </div>                         
    <div class="col-8">
        <table class="table">
              <tr>
                <td>Jenis DL</td>
                <td><?php echo $flagDL ;?></td>
              </tr>
              <tr>
                <td>Tanggal Pengajuan</td>
                <td class="text-end"><?php echo format_full($create_at );?> &nbsp;&nbsp;&nbsp; <?php echo date('H:i',strtotime($create_at ));?> </td>
              </tr>
              <tr>
                <td>Tanggal Dinas Luar</td>
                <td class="text-end"><?php echo format_full($tgl );?> </td>
              </tr>

            
              <tr>
                <td>Keterangan</td>
                <td class="text-end"><?php  echo $keterangan;?> </td>
              </tr>

              <tr>
                <td>Maps Position</td>
                <td class="text-end">Lat : <?php  echo $latitude.' &nbsp; &nbsp; Long: '.$longitude;?> </td>
              </tr>



        </table>
    </div>
    <div class="col-4">
       <img src="<?php echo base_url();?>uploads/photo_dinas_luar/thumb/<?php echo $photo;?>" width="200" height="250"> <br>
       <center>
       <a href="<?php echo base_url();?>uploads/photo_dinas_luar/thumb/<?php echo $photo;?>" class="btn btn-sm mt-2 btn-light">View Image</a>
       </center>
       
    </div>


  </div>

  <div id="map" class="border p-2 mt-4" style="width: 100%;"></div>
      


  
<script>
     
     function initMap() {
        var cilincing = {lat: <?php echo $pengajuan_dinas_luar[0]->lat; ?>, lng:<?php echo $pengajuan_dinas_luar[0]->lon; ?>};
         var map = new google.maps.Map(document.getElementById('map'), {
         center: cilincing,
         zoom: 15
       });

   
                     
       var marker0 = new google.maps.Marker({
       position: {lat: <?php echo $pengajuan_dinas_luar[0]->lat; ?>, lng:<?php echo $pengajuan_dinas_luar[0]->lon; ?>},
       map: map,
       title: 'Lokasi'
         });

     
       marker0.addListener('click', function() {
         infowindow0.open(map, marker0);
       });
       
       
         var contentString0 = '';

             var infowindow0 = new google.maps.InfoWindow({
           content: contentString0  
           });
       
     }
</script>


