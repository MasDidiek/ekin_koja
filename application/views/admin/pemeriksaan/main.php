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

					<h1 class="h3 mb-3">Pemeriksaan Pengemudi</h1>


 <?php
                $msg        = $this->session->flashdata('success'); 
                $tgl_daftar = $this->session->userdata('tgl_daftar');

                if($tgl_daftar==''){
                    $tgl = date('d-m-Y');
                  
                }else{
                    $tgl = format_view($tgl_daftar);
                }


 
            ?>
            
                    
					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-12">
							<div class="card">
								<div class="card-header">
                                        
                                    <label for="datepicker">Filter Data: </label><br>
                                        <input type="text" name="filter_date" class="form-control float-start me-2" value="<?php echo $tgl ;?>" style="width:120px" id="datepicker">
                                        <select name="status_ht" id="status_ht"  class="form-control float-start me-2"  style="width:150px">
                                               <option value="0">Tekanan Darah</option>
                                               <option value="0">Semua</option>
                                                <option value="1">Normal</option>
                                                <option value="2">HT Ringan</option>
                                                <option value="3">HT Sedang</option>
                                                <option value="4">HT Berat</option>
                                        </select>
                            
                                        <select name="status_gds" id="status_gds"  class="form-control float-start me-2"  style="width:220px">
                                               <option value="0">Gula Darah Sewaktu</option>
                                               <option value="0">Semua</option>
                                                <option value="1">80 mg/dl - 200 mg/dl</option>
                                                <option value="2"> > 200 mg/dl Tanpa Gejala</option>
                                                <option value="3"> > 200 mg/dl Dengan Gejala</option>
                                             
                                        </select>
                            
                                        <select name="status_laik" id="status_laik"   class="form-control float-start me-2"  style="width:220px">
                                               <option value="0">Semua</option>
                                                <option value="1">Laik</option>
                                                <option value="2"> Laik dengan Catatan</option>
                                                <option value="3"> Tidak Laik dengan Catatan</option>
                                             
                                        </select>
                            
                                        <button type="button" class="btn btn-primary" id="filter_bydatae">Submit</button>
                            
                            
                                        <button type="button" id="openModal" class="btn btn-info float-right">Tambah Pengemudi</button>
								
								</div>
								
								<div class="card-body">
							    	<table class="table table-hover" id="dataTable">
								    	  <thead>
									     <tr>
                                            <th>No</th>
                                            <th align="center">Tanggal</th>
                                            <th align="left">Nama</th>   
                                             <th align="left">Tanggal Lahir</th>       
                                            <th align="center">Hipertensi</th>
                                            <th align="center">GDS</th>
                                            <th align="center">Status Laik</th>
                                             <th align="center">Action</th>
                                         </tr>
    								  	</thead>
    									<tbody>
    									    
									         <?php
                                               for ($i=0; $i < count($data_pemeriksaan) ; $i++) { 
                                                    $nama_supir = $data_pemeriksaan[$i]->nama;
                                                
                                                 
                                                
                                                    $status_laik = $data_pemeriksaan[$i]->status_laik;
                                                    $status_ht = $data_pemeriksaan[$i]->status_ht;
                                                    $status_gds = $data_pemeriksaan[$i]->status_gds;
                                                    $nama = $data_pemeriksaan[$i]->nama;
                                                    $tgl_lahir = $data_pemeriksaan[$i]->tgl_lahir;
                                                    $jns_kel = $data_pemeriksaan[$i]->jns_kel;
                                                    $nama_po = $data_pemeriksaan[$i]->nama_po;
                                                    
                                                    
                                                    
                                                    $date_time = $data_pemeriksaan[$i]->date_time;
                                                    $tgl_periksa = format_db($date_time);
                        
                                                    $umur = hitungUmur($tgl_lahir, $tgl_periksa, 'Y');
                                                   
                                                   echo '<tr>
                                                            <td>'.($i+1).'</td>
                                                            <td>'. format_view($tgl_periksa).'</td>
                                                            <td>'.$nama_supir .'</td>
                                                            <td>'. format_view($tgl_lahir).'</td>
                                                            <td>'.getFlagHT($status_ht).'</td>
                                                            <td>'.getFlagGDS($status_gds).'</td>
                                                            <td>'.getFlagLaik($status_laik).'</td>
                                                            <td>
                                                            <a href="'.base_url().'admin/admin_pemeriksaan/ubah_data_pemeriksaan/'.$data_pemeriksaan[$i]->id.'" class="btn btn-sm btn-primary">Ubah</a>
                                                            <a href="'.base_url().'admin/admin_pemeriksaan/rujuk/'.$data_pemeriksaan[$i]->id.'" class="btn btn-sm btn-danger">Rujuk</a>
                                                            </td>
                                                   
                                                           </tr>';
                        
                                               }
                                            ?>
                                           
									</tbody>
								</table>
								
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