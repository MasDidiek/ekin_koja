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

					<h1 class="h3 mb-3">Input Pengemudi</h1>
            <?php
            
               $date_now = date('Y-m-d');
                    $day      = date('D', strtotime($date_now));
       
            ?>
                    
					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-12">
							<div class="card">
								<div class="card-header">
                                        
                                      Input Pengemudi baru
								
								</div>
								
							    	<div class="card-body">
							    	    
							    	     
							    	      <form action="<?php echo base_url();?>admin/admin_driver/insert_driver" method="post">
                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                             
                                                        <div class="form-group mb-3">
                                                            <label class="details">Nama Pengemudi <span class="text-danger">*</span></label>
                                                            <input type="text" placeholder=" nama pengemudi" name="nama_lengkap" class="<?= form_error('nama_lengkap') ? 'is-invalid form-control' : 'form-control' ?>" value="<?php echo set_value('nama_lengkap'); ?>" >
                                                            <span class="invalid-feedback"><?php echo form_error('nama_lengkap'); ?> </span>
                                                          </div>
                                                          
                                                          <div class="form-group  mb-3">
                                                            <label class="details">NIK / NO KTP <span class="text-danger">*</span></label>
                                                            <input type="text" name="no_ktp" placeholder="ketik no KTP "  onkeypress="return onlyNumberKey(event)"  class="charcounter-control <?= form_error('no_ktp') ? 'is-invalid form-control' : 'form-control' ?>" value="<?php echo set_value('no_ktp'); ?>"   maxlength='16'  warnlength='14' >
                                                            <span class="invalid-feedback"><?php echo form_error('no_ktp'); ?> </span>
                                                          </div>
                                                          
                                                          <div class="form-group  mb-3">
                                                            <label class="details">Tanggal Lahir  <span class="text-danger">*</span></label>
                                                            <input type="text" placeholder="tgl/bln/thn" name="tgl_lahir" class="js-date <?= form_error('nama_lengkap') ? 'is-invalid form-control' : 'form-control' ?>" maxlength="10" value="<?php echo set_value('tgl_lahir'); ?>">
                                                            <span class="invalid-feedback"><?php echo form_error('tgl_lahir'); ?> </span>
                                                          </div>
                                                          <br>
                                                          <div class="form-group  mb-3">
                                                             <label>  Jenis Kelamin : </label> <br>
                                                                    <input type="radio" name="gender" value="L" checked id="dot-1"> Laki-laki &nbsp; &nbsp; &nbsp; &nbsp;
                                                                    <input type="radio" name="gender" value="P"  id="dot-2"> Perempuan
                                                              
                                                          </div>
                                                          
                                                            <div class="form-group  mb-3">
                                                                <label class="details">No Handphone  <span class="text-danger">*</span></label>
                                                                <input type="text" name="no_hp"  onkeypress="return onlyNumberKey(event)"  placeholder="ketik no handphone" class="<?= form_error('no_hp') ? 'is-invalid form-control' : 'form-control' ?>"   value="<?php echo set_value('no_hp'); ?>" >
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
                                                                        <option value="">-Pilih Pendidikan Terakhir-</option>
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
                                                                            <option value="">-Pilih Status-</option>
                                                                            <option value="BM" <?php echo  set_select('status_pernikahan', 'BM'); ?>>Belum Menikah</option>
                                                                            <option value="M" <?php echo  set_select('status_pernikahan', 'M'); ?>>Menikah</option>
                                                                            <option value="D" <?php echo  set_select('status_pernikahan', 'D'); ?>>Duda</option>
                                                                            <option value="J" <?php echo  set_select('status_pernikahan', 'J'); ?>>Janda</option>
                                                                            
                                                                    </select>
                                                              </div>
                                                              <div class="form-group  mb-3">
                                                                <label class="details">Alamat Rumah</label>
                                                                <textarea name="alamat"  class="form-control"></textarea>
                                                              </div>
                                                    
                                                                  <div class="form-group  mb-3">
                                                        
                                                        
                                                                           <label class="gender-title">Status Supir</label> <br>
                                                                            <input type="radio" name="status_supir" value="Utama" checked id="status-1"> Utama &nbsp;&nbsp;&nbsp;&nbsp;
                                                                            <input type="radio" name="status_supir" value="Cadangan"  id="status-2"> Cadangan
                                                                      
                                                        
                                                                  </div>
                                                        
                                                                    <div class="form-group  mb-3">
                                                                        <label class="details">Nama PO  <span class="text-danger">*</span></label>
                                                                        <input type="text" name="nama_po" placeholder="ketik nama perusahaan " class="<?= form_error('nama_po') ? 'is-invalid form-control' : 'form-control' ?>"   value="<?php echo set_value('nama_po'); ?>" >
                                                                        <span class="invalid-feedback"><?php echo form_error('nama_po'); ?> </span>
                                                                   
                                                                    </div>
                                                         
                                                    
                                                    
                                                              
                                                                    <br><br>
                                                                     <button type="submit" class="btn btn-success ">Simpan</button>
                                                                     <a href="<?php echo base_url();?>admin/admin_driver/index" class="btn btn-dangert" style="margin-right:5px">Kembali</a>
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


   
$(document).ready(function(){
  
        
  $('#dataTable').DataTable({
    "pageLength": 10
  });


  $( function() {
        $( "#datepicker" ).datepicker({
            dateFormat : "dd-mm-yy",
          changeMonth: true
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