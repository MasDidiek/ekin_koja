<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('admin/master/meta');?>
<style>
  .box-profile{
    background-color: #FFF;
    border-bottom: 1px solid #CCC;
    padding-bottom: 20px;
  }  

  .nama{
    font-size:28px;
  }

  .clearfix{
    clear: both;
  }
  
  .myImg{
    width:90%;
    padding: 10px;
  }
table tr td{
  border: none;
  padding:5px;
  line-height: 15px;
 
}

.box-info{
  background-color: #FFF;
  padding:10px;
  color:#104751;
}
.box-info p{
  font-size:12px;
}

</style>
</head>
<body>
    <div id="wrapper">

           <!-- /. NAV TOP  -->
           <?php $this->load->view('admin/master/menu');?>
       
           <!-- /. NAV SIDE  -->

           <div class="nav-top">
             <div class="account-info">
              <i class="fa fa-user"></i>&nbsp;  Login as : &nbsp; &nbsp;  PKM Kalibaru</div> 
           </div>


						<div id="page-wrapper" >
							<div id="page-inner">
						
								<?php 
                    
                   // print_array($detail_catin);
                    
                            $id = $detail_catin[0]->id; 
                            $nik = $detail_catin[0]->nik; 
                            $nama = $detail_catin[0]->nama; 
                            $tgl_lahir = $detail_catin[0]->tgl_lahir; 
                            $gender = $detail_catin[0]->gender; 
                            $no_hp = $detail_catin[0]->no_hp;
                            $status_kawin = $detail_catin[0]->status_kawin; 
                            $id_provinsi = $detail_catin[0]->id_provinsi; 
                            $id_kota = $detail_catin[0]->id_kota; 
                            $id_kecamatan = $detail_catin[0]->id_kecamatan;
                            $id_kelurahan = $detail_catin[0]->id_kelurahan; 
                            
                            $provinsi_calon = $this->Master_model->getNamaProvinsi($id_provinsi);
                            $kota_calon = $this->Master_model->getNamaKota($id_kota);
                            $kecamatan_calon = $this->Master_model->getNamaKecamatan($id_kecamatan);
                            $kelurahan_calon = $this->Master_model->getNamaKelurahan($id_kelurahan);
                            
                            
                            $kode_pos = $detail_catin[0]->kode_pos; 
                            $tgl_rencana_menikah = $detail_catin[0]->tgl_rencana_menikah;
                            $ktp = $detail_catin[0]->ktp; 
                            $suket_rt = $detail_catin[0]->suket_rt; 
                            
                            
                            $ktp_pasangan = $detail_catin[0]->ktp_pasangan; 
                            $suket_pasangan = $detail_catin[0]->suket_pasangan;
                            $status = $detail_catin[0]->status; 
                            $alasan = $detail_catin[0]->alasan; //jika ditolak
                            $tgl_validasi = $detail_catin[0]->tgl_validasi;
                            $date_create = $detail_catin[0]->date_create; 
                            $no_surat = $detail_catin[0]->status; 

                            $tgl_daftar = format_view($date_create);
                            $umur_calon = hitungUmur($tgl_lahir, $tgl_daftar,'all');

                            $message = $this->session->flashdata('message');

                           
                    
                    ?>


                  <div class="box-info">
                      <strong><?= $nama;?> </strong>
                      <br><?php  echo $umur_calon;?> <br><br>

                      <button type="button" class="btn btn-primary">
                        <i class="fa fa-edit"></i>  Ubah Data     
                      </button>
                      <button type="button" class="btn btn-success">
                        <i class="fa fa-edit"></i>  Validasi Data
                      </button>



                      <p>
                        Tanggal Daftar :  &nbsp; <strong><?php echo $tgl_daftar ;?></strong> &nbsp; 
                        <strong><?php echo date('H:i:s', strtotime($date_create)) ;?></strong> <br>
                        Status Data  &nbsp; &nbsp; &nbsp;:   &nbsp;
                        <?php 
                                  if($status == 0)
                                  {
                                    echo '<span class="badge badge-warning">Pending </span> (data belum dicek)';
                                    $style="display:block";
                                  }else if($status == 1){
                                    echo '<span class="badge badge-success">Valid</span>';
                                    $style="display:none";
                                  }else{
                                    echo '<span class="badge badge-danger">Tidak Valid</span>';

                                    echo '<br> '.$alasan;

                                    $style="display:none";
                                  }

                                ?>
                          
                      </p>
                  </div>

                  <div class="box-profile">
                     
                  <button type="button" value="valid" class="btn btn-default"> Valid</button>
                                    <button type="button" value="not_valid" class="btn btn-default">Tidak Valid</button>


                                    <form method="post" action="<?php echo base_url();?>data_catin/submit_validasi/<?php echo $id;?>" id="form_unvalid">
                                         
                                         <div id="confirm_valid" style="display:none">Apakah anda yakin?</div>
                                          <input type="hidden" name="status_valid" id="status_valid" value="">   
                                         <textarea name="alasan" id="alasan" style="display:none" class="form-control" placeholder="tulis alasan data tidak valid"></textarea>
                                         
                                         
                                         <br><button type="submit" class="btn btn-primary pull-right">Submit</button>   
                                         <div class="clearfix"></div> 
                                    </form>

                      <h3>Profile Calon Pengantin</h3>

                        <button type="button" class="btn btn-info" onClick="modalImage('<?php echo base_url();?>uploads/ktp/<?php echo $ktp;?>');" alt=" KTP Calon Pengantin" >
                        <i class="fa fa-picture-o"></i>   Lihat   Photo KTP           
                        </button>

                        <button type="button" class="btn" onClick="modalImage('<?php echo base_url();?>uploads/suket/<?php echo $suket_rt;?>');" alt=" KTP Calon Pengantin" >
                           <i class="fa fa-picture-o"></i>  Lihat   Surat Keterangan RT/RW   
                        </button>

                        <br> <br>
                            <table style="width:100%">  
                                        <tr>
                                            <td width="200">NIK</td>
                                            <td width="20">:</td>
                                            <td><strong><?= $nik;?></strong> </td>
                                            <td>Alamat Lengkap</td>
                                            <td width="20">:</td>
                                            <td rowspan="5" valign="top">
                                              <?php echo $detail_catin[0]->alamat_lengkap;?>
                                             <br>
                                             RT/RW : &nbsp;&nbsp; <?php echo $detail_catin[0]->rt;?> / <?php echo $detail_catin[0]->rw;?>
                                             <br>   <br>
                                            
                                             Kel.&nbsp;&nbsp; <?= ucwords(strtolower($kelurahan_calon));?><br>
                                             Kec. &nbsp;&nbsp;<?=  ucwords(strtolower($kecamatan_calon));?> <br>
                                             Kota : &nbsp;&nbsp;<?=  ucwords(strtolower($kota_calon));?> <br>
                                             Provinsi : &nbsp;&nbsp; <?=  ucwords(strtolower($provinsi_calon));?>  <br>
                                            Kode Pos : &nbsp;&nbsp; <?php echo $kode_pos;?>

                                            <br><br>
                                          
                                            
                                          </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Nama Lengkap</td>
                                            <td>:</td>
                                            <td><strong><?= $nama;?> </strong></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Tanggal Lahir</td>
                                            <td>:</td>
                                            <td><strong><?= format_slash($tgl_lahir);?> </strong></td>
                                        </tr>
                                        <tr>
                                          <td>Umur</td>
                                          <td>:</td>
                                          <td><strong><?php  echo $umur_calon;?></strong></td>
                                        </tr>

                                        <tr>
                                            <td>Jenis Kelamin</td>
                                            <td>:</td>
                                            <td>
                                            <?php 
                                              if($gender == 'L')
                                              {
                                                echo 'Laki-laki';
                                              }else{
                                                echo 'Perempuan';
                                              }

                                            ?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>No Hanphone</td>
                                            <td>:</td>
                                            <td><?= $no_hp;?> </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>Status Kawin</td>
                                            <td>:</td>
                                            <td><?php echo $status_kawin = 1 ? 'Belum Menikah' : 'Duda/Janda'; ?></td>
                                            <td>Alamat Domisili</td>
                                            <td>:</td>
                                            <td><?php echo $detail_catin[0]->alamat_domisili;?></td>
                                        </tr>
                                        
                                        <tr>
                                            <td>No Surat Pengadilan</td>
                                            <td>:</td>
                                            <td><?= $no_surat;?> </td>
                                        </tr>
                                      
                                      
                                    </table>
                      
                      <div class="clearfix"></div>

                      
                  </div>

                  <div class="box-profile">
          
      <?php
                            
                            
                            $nama_pasangan = $detail_catin[0]->nama_pasangan; 
                            $nik_pasangan = $detail_catin[0]->nik_pasangan; 
                            $tgl_lahir_pasangan = $detail_catin[0]->tgl_lahir_pasangan;
                            $gender_pasangan = $detail_catin[0]->gender_pasangan; 
                            $hp_pasangan = $detail_catin[0]->hp_pasangan; 
                            $status_pasangan = $detail_catin[0]->status_pasangan;
                            $id_prov = $detail_catin[0]->id_prov; 
                            $id_kota_pasangan = $detail_catin[0]->id_kota_pasangan; 
                            $id_kec = $detail_catin[0]->id_kec;
                            $id_kel = $detail_catin[0]->id_kel; 
                            $kode_pos_pasangan = $detail_catin[0]->kode_pos_pasangan; 
                            $no_surat_pasangan = $detail_catin[0]->no_surat_pasangan; 
                        
                            
                        
                            $provinsi_pasangan= $this->Master_model->getNamaProvinsi($id_prov);
                            $kota_pasangan = $this->Master_model->getNamaKota($id_kota_pasangan);
                            $kecamatan_pasangan = $this->Master_model->getNamaKecamatan($id_kec);
                            $kelurahan_pasangan = $this->Master_model->getNamaKelurahan($id_kel);

                            $umur_pasangan = hitungUmur($tgl_lahir_pasangan, $tgl_daftar,'all');
                                
                            ?>
                      <table>  



                     <h3>Profile Pasangan Calon Pengantin</h3>

                       <button type="button" class="btn btn-info" onClick="modalImage('<?php echo base_url();?>uploads/ktp/<?php echo $ktp_pasangan;?>');" alt=" KTP Calon Pengantin" >
                       <i class="fa fa-picture-o"></i>   Lihat   Photo KTP           
                       </button>

                       <button type="button" class="btn" onClick="modalImage('<?php echo base_url();?>uploads/suket/<?php echo $suket_pasangan;?>');" alt=" KTP Calon Pengantin" >
                          <i class="fa fa-picture-o"></i>  Lihat   Surat Keterangan RT/RW   
                       </button>

                       <br> <br>
                           <table style="width:100%">  
                                       <tr>
                                           <td width="200">NIK</td>
                                           <td width="20">:</td>
                                           <td><strong><?= $nik_pasangan;?></strong> </td>
                                           <td>Alamat Lengkap</td>
                                           <td width="20">:</td>
                                           <td rowspan="5" valign="top">
                                             <?php echo $detail_catin[0]->alamat_pasangan;?>
                                            <br>
                                            RT/RW : &nbsp;&nbsp; <?php echo $detail_catin[0]->rt;?> / <?php echo $detail_catin[0]->rw;?>
                                            <br>   <br>
                                           
                                            Kel.&nbsp;&nbsp; <?= ucwords(strtolower($kelurahan_pasangan));?><br>
                                            Kec. &nbsp;&nbsp;<?=  ucwords(strtolower($kecamatan_pasangan));?> <br>
                                            Kota : &nbsp;&nbsp;<?=  ucwords(strtolower($kota_pasangan));?> <br>
                                            Provinsi : &nbsp;&nbsp; <?=  ucwords(strtolower($provinsi_pasangan));?>  <br>
                                           Kode Pos : &nbsp;&nbsp; <?php echo $kode_pos;?>

                                           <br><br>
                                         
                                           
                                         </td>
                                       </tr>
                                       
                                       <tr>
                                           <td>Nama Lengkap</td>
                                           <td>:</td>
                                           <td><strong><?= $nama_pasangan;?> </strong></td>
                                       </tr>
                                       
                                       <tr>
                                           <td>Tanggal Lahir</td>
                                           <td>:</td>
                                           <td><strong><?= format_slash($tgl_lahir_pasangan);?> </strong></td>
                                       </tr>
                                       <tr>
                                         <td>Umur</td>
                                         <td>:</td>
                                         <td><strong><?php  echo $umur_pasangan;?></strong></td>
                                       </tr>

                                       <tr>
                                           <td>Jenis Kelamin</td>
                                           <td>:</td>
                                           <td>
                                           <?php 
                                             if($gender_pasangan == 'L')
                                             {
                                               echo 'Laki-laki';
                                             }else{
                                               echo 'Perempuan';
                                             }

                                           ?></td>
                                       </tr>
                                       
                                       <tr>
                                           <td>No Hanphone</td>
                                           <td>:</td>
                                           <td><?= $hp_pasangan;?> </td>
                                       </tr>
                                       
                                       <tr>
                                           <td>Status Kawin</td>
                                           <td>:</td>
                                           <td><?php echo $status_pasangan = 1 ? 'Belum Menikah' : 'Duda/Janda'; ?></td>
                                           <td>Alamat Domisili</td>
                                           <td>:</td>
                                           <td><?php echo $detail_catin[0]->domisili_pasangan;?></td>
                                       </tr>
                                       
                                       <tr>
                                           <td>No Surat Pengadilan</td>
                                           <td>:</td>
                                           <td><?= $no_surat;?> </td>
                                       </tr>
                                     
                                     
                                   </table>
                     
                     <div class="clearfix"></div>

                     
                 </div>



						   	</div><!-- /. PAGE INNSER  -->
             </div> <!-- /. PAGE WRAPPER  -->
       </div> <!-- /. ID WRAPPER  -->
       <div id="myModal" class="modal">
            <span class="close"  onClick="closeModal();">&times;</span>
            <img class="modal-content" id="img01">
            <div id="caption"></div>
          </div>
    
       
      </div>
    <!-- /. WRAPPER  -->
	 <script src="<?php echo JS_ADMIN;?>jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="<?php echo JS_ADMIN;?>bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="<?php echo JS_ADMIN;?>jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="<?php echo JS_ADMIN;?>dataTables/jquery.dataTables.js"></script>
    <script src="<?php echo JS_ADMIN;?>dataTables/dataTables.bootstrap.js"></script>
        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();


                $(".btn-default").click(function() {
                  
                  $(this).removeClass("btn-warning");
                  $(this).removeClass("btn-success");

                  var status = $(this).val();


                  $("#form_unvalid").show();
                  if(status==='valid'){
                    $("#confirm_valid").show();
                    $("#alasan").hide();
                    $(this).addClass("btn-success");
                    $(".btn-primary").html("Iya");
                    $("#status_valid").val(1);

                  }else{
                    $("#alasan").show();
                    $("#confirm_valid").hide();
                    $(this).addClass("btn-warning");
                    $(".btn-primary").html("Kirim");
                    $("#status_valid").val(2);
                  }

                 

                });

            });


        function modalImage(image_src){
             var modal = document.getElementById("myModal");
              modal.style.display = "block";
              
            
             var img = document.getElementById("myImg");

             var modalImg = document.getElementById("img01");
             var captionText = document.getElementById("caption");
             
              modalImg.src = image_src;
              captionText.innerHTML = this.alt;
              
      
        }
        
         
        function closeModal(){
             var modal = document.getElementById("myModal");
              modal.style.display = "none";
              
      
        }

    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>
