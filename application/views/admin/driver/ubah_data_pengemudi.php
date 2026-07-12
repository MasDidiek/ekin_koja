<!DOCTYPE html>
<html lang="en">

<?php $this->load->view('admin/master/meta');?>
    <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

<body>
	<div class="wrapper">
	
    <?php $this->load->view('admin/master/navbar');?>
			<main class="content">
				<div class="container-fluid p-0">

					<h1 class="h3 mb-3">Pengemudi</h1>
            <?php
            
                   $date_now = date('Y-m-d');
                    $day      = date('D', strtotime($date_now));
                    
                   // print_array($data_detail);
                    
                    $no_ktp = $data_detail[0]->no_ktp;
                    $no_ktp = $data_detail[0]->no_ktp;
                    $nama = $data_detail[0]->nama;
                    $tgl_lahir = $data_detail[0]->tgl_lahir;
                    $jns_kel = $data_detail[0]->jns_kel;
                    $no_hp = $data_detail[0]->no_hp;
                    $pekerjaan = $data_detail[0]->pekerjaan;
                    $nama_pekerjaan = $data_detail[0]->nama_pekerjaan;
                    $pendidikan = $data_detail[0]->pendidikan;
                    $status_kawin = $data_detail[0]->status_kawin;
                    $alamat = $data_detail[0]->alamat;
                    $nama_po = $data_detail[0]->nama_po;
                    $status_supir = $data_detail[0]->status_supir;
                    $no_ktp = $data_detail[0]->no_ktp;
                    
                    
                   $msg =  $this->session->flashdata('success');
       
            ?>
                    
					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-12">
							<div class="card">
								<div class="card-header">
                                        
                                     <h4> Ubah Data Pengemudi</h4>
								    <a href="<?php echo base_url();?>admin/admin_driver/detail/<?php echo $data_detail[0]->id;?>" class="btn btn-light border float-start  mr-2"><i class="align-middle" data-feather="corner-up-left"></i> Kembali </a>
								</div>
								
								
							    	<div class="card-body">
							    	    
							    	 
                                        <div id="snackbar">  <img src="<?php echo base_url();?>assets/img/sample-loading.gif" width="50">  Menyimpan data...</div>

							    	   
							    	      <form action="<?php echo base_url();?>admin/admin_driver/update_driver/<?php echo $data_detail[0]->id;?>" method="post">
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                             
                                                        <div class="form-group mb-3">
                                                            <label class="details">Nama Pengemudi <span class="text-danger">*</span></label>
                                                            <input type="text" placeholder=" nama pengemudi" name="nama_lengkap" class="<?= form_error('nama_lengkap') ? 'is-invalid form-control' : 'form-control' ?>" value="<?php echo $nama; ?>" >
                                                            <span class="invalid-feedback"><?php echo form_error('nama_lengkap'); ?> </span>
                                                          </div>
                                                          
                                                          <div class="form-group  mb-3">
                                                            <label class="details">NIK / NO KTP <span class="text-danger">*</span></label>
                                                            <input type="text" name="no_ktp" placeholder="ketik no KTP "  onkeypress="return onlyNumberKey(event)"  class="charcounter-control <?= form_error('no_ktp') ? 'is-invalid form-control' : 'form-control' ?>" value="<?php echo $no_ktp; ?>"   maxlength='16'  warnlength='14' >
                                                            <span class="invalid-feedback"><?php echo form_error('no_ktp'); ?> </span>
                                                          </div>
                                                          
                                                          <div class="form-group  mb-3">
                                                            <label class="details">Tanggal Lahir  <span class="text-danger">*</span></label>
                                                            <input type="text" placeholder="tgl/bln/thn" name="tgl_lahir" id="datepicker" class="js-date <?= form_error('nama_lengkap') ? 'is-invalid form-control' : 'form-control' ?>" maxlength="10" value="<?php echo $tgl_lahir; ?>">
                                                            <span class="invalid-feedback"><?php echo form_error('tgl_lahir'); ?> </span>
                                                          </div>
                                                          <br>
                                                          <div class="form-group  mb-3">
                                                             <label>  Jenis Kelamin : </label> <br>
                                                             <?php
                                                                if($jns_kel=='L'){
                                                                    echo ' <input type="radio" name="gender" value="L" checked id="dot-1"> Laki-laki &nbsp; &nbsp; &nbsp; &nbsp;
                                                                    <input type="radio" name="gender" value="P"  id="dot-2"> Perempuan';
                                                                }else{
                                                                      echo ' <input type="radio" name="gender" value="L"  id="dot-1"> Laki-laki &nbsp; &nbsp; &nbsp; &nbsp;
                                                                    <input type="radio" name="gender" value="P"  id="dot-2" checked> Perempuan';
                                                                }
                                                             ?>
                                                                   
                                                              
                                                          </div>
                                                          
                                                            <div class="form-group  mb-3">
                                                                <label class="details">No Handphone  <span class="text-danger">*</span></label>
                                                                <input type="text" name="no_hp"  onkeypress="return onlyNumberKey(event)"  placeholder="ketik no handphone" class="<?= form_error('no_hp') ? 'is-invalid form-control' : 'form-control' ?>"   value="<?php echo $no_hp; ?>" >
                                                                <span class="invalid-feedback"><?php echo form_error('no_hp'); ?> </span>
                                                              </div>
                                                              
                                                    </div>
                                                    
                                                    <div class="col-md-6">
                                                           
                                                              <div class="form-group  mb-3">
                                                                <label class="details">Pekerjaan</label>
                                                                 <input type="text" name="pekerjaan" value="Driver" readonly required class="form-control">
                                                              </div>
                                                              
                                                              <div class="form-group  mb-3">
                                                                <label class="details">Pendidikan Terakhir <span class="text-danger">*</span></label>
                                                                <select name="pendidikan" class="<?= form_error('pendidikan') ? 'is-invalid form-control' : 'form-control' ?> ">
                                                                      
                                                                      <?php
                                                                        if($pendidikan=='SMA'){
                                                                            echo ' <option value="SMA" selected>SMA</option>';
                                                                        }elseif($pendidikan=='SMP'){
                                                                             echo ' <option value="SMP" selected>SMP</option>';
                                                                        }elseif($pendidikan=='SD'){
                                                                             echo ' <option value="SD" selected>SD</option>';
                                                                        }elseif($pendidikan=='Tidak Sekolah'){
                                                                             echo ' <option value="Tidak Sekolah" selected>Tidak Sekolah</option>';
                                                                        }
                                                                      ?>
                                                                        
                                                                        <option value="Perguruan Tinggi" <?php echo  set_select('pendidikan', 'Perguruan Tinggi'); ?>>Perguruan Tinggi</option>
                                                                        <option value="SMA" <?php echo  set_select('pendidikan', 'SMA'); ?>>SMA</option>
                                                                        <option value="SMP" <?php echo  set_select('pendidikan', 'SMP'); ?>>SMP</option>
                                                                        <option value="SD" <?php echo  set_select('pendidikan', 'SD'); ?>>SD</option>
                                                                        <option value="Tidak Sekolah" <?php echo  set_select('pendidikan', 'Tidak Sekolah'); ?>>Tidak Sekolah</option>
                                                                        
                                                                </select>
                                                              </div>
                                                    
                                                              <div class="form-group  mb-3">
                                                              <label class="details">Status Pernikahan <span class="text-danger">*</span></label>
                                                                <select name="status_pernikahan" class="<?= form_error('status_pernikahan') ? 'is-invalid form-control' : 'form-control' ?> ">
                                                                    
                                                                           <?php
                                                                                if($status_kawin=='BM'){
                                                                                    echo ' <option value="BM" selected>Belum Menikah</option>';
                                                                                }elseif($status_kawin=='M'){
                                                                                     echo ' <option value="M" selected>Menikah</option>';
                                                                                }elseif($status_kawin=='D'){
                                                                                     echo ' <option value="D" selected>Duda</option>';
                                                                                }elseif($status_kawin=='J'){
                                                                                     echo ' <option value="J" selected>Janda</option>';
                                                                                }
                                                                              ?>
                                                                              
                                                                          
                                                                            <option value="BM" <?php echo  set_select('status_pernikahan', 'BM'); ?>>Belum Menikah</option>
                                                                            <option value="M" <?php echo  set_select('status_pernikahan', 'M'); ?>>Menikah</option>
                                                                            <option value="D" <?php echo  set_select('status_pernikahan', 'D'); ?>>Duda</option>
                                                                            <option value="J" <?php echo  set_select('status_pernikahan', 'J'); ?>>Janda</option>
                                                                            
                                                                    </select>
                                                              </div>
                                                              <div class="form-group  mb-3">
                                                                <label class="details">Alamat Rumah</label>
                                                                <textarea name="alamat"  class="form-control"><?php echo $alamat;?></textarea>
                                                              </div>
                                                    
                                                                  <div class="form-group  mb-3">
                                                        
                                                        
                                                                           <label class="gender-title">Status Supir</label> <br>
                                                                             <?php
                                                                            if($status_supir=='Utama'){
                                                                                echo ' <input type="radio" name="status_supir" value="Utama" checked id="status-1"> Utama &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="status_supir" value="Cadangan"  id="status-2"> Cadangan';
                                                                            }else{
                                                                                  echo '   <input type="radio" name="status_supir" value="Utama"  id="status-1"> Utama &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="status_supir" value="Cadangan"  id="status-2" checked> Cadangan';
                                                                            }
                                                                         ?>
                                                                         
                                                                          
                                                                      
                                                        
                                                                  </div>
                                                        
                                                                    <div class="form-group  mb-3">
                                                                        <label class="details">Nama PO  <span class="text-danger">*</span></label>
                                                                        <input type="text" name="nama_po" placeholder="ketik nama perusahaan " class="<?= form_error('nama_po') ? 'is-invalid form-control' : 'form-control' ?>"   value="<?php echo $nama_po; ?>" >
                                                                        <span class="invalid-feedback"><?php echo form_error('nama_po'); ?> </span>
                                                                   
                                                                    </div>
                                                         
                                                    
                                                    
                                                              
                                                                    <br><br>
                                                                     <button type="submit" class="btn btn-success " onclick="myFunction()">Simpan</button>
                                                                     <a href="<?php echo base_url();?>admin/admin_driver/detail/<?php echo $data_detail[0]->id;?>" class="btn btn-dangert" style="margin-right:5px">Kembali</a>
                                                    </div>
                                                    
                                               
                                                  
                                               
                                                         <div class="clearfix"></div>
                                                    <br><br>
                                                </div>
                                
                                     
                                        
                                         </form>

								
									</div>
							</div>
						</div>
						
					</div>

				</div>
			</main>

			<footer class="footer">
				<div class="container-fluid">
					<div class="row text-muted">
						<div class="col-6 text-start">
							<p class="mb-0">
								<a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>AdminKit</strong></a> - <a class="text-muted" href="https://adminkit.io/" target="_blank"><strong>Bootstrap Admin Template</strong></a>								&copy;
							</p>
						</div>
						<div class="col-6 text-end">
							<ul class="list-inline">
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Support</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Help Center</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Privacy</a>
								</li>
								<li class="list-inline-item">
									<a class="text-muted" href="https://adminkit.io/" target="_blank">Terms</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</footer>
		</div>
	</div>

	<script src="<?php echo base_url();?>assets/js/app.js"></script>


<!-- Scripts below are for demo only -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/js/main.min.js?v=1628755089081"></script>
<script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>

</body>


<script>

    function myFunction() {
      var x = document.getElementById("snackbar");
      x.className = "show";
      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }


   
$(document).ready(function(){
  
        
    var msg = '<?php echo $msg ;?>';
    if(msg !=''){
        $("#snackbar").html('<strong>Success!!</strong> Data pengemudi berhasil diupdate');
        myFunction();
    }

  $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat : "dd-mm-yy",
            changeMonth: true,
            changeYear: true
        });
    } );

  $("#filter_bydatae").click(function(){
        $(this).html('loading');
       
        var tgl = $("#datepicker").val();


        $.ajax({
            type: "POST",
            dataType: "html",
            url: "<?php echo  base_url() . 'admin/admin_driver/create_session_date'; ?>",
            data: "tgl=" + tgl,
            success: function(msg) {
                window.location.reload();
            }
        });

    });

});

</script>
</html>