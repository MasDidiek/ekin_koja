<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('admin/master/meta');?>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<style>
  

</style>
</head>
<body>
    <div id="wrapper">
    <?php $this->load->view('admin/master/top_nav');?> 
           <!-- /. NAV TOP  -->
           <?php $this->load->view('admin/master/menu');?>
        <!-- /. NAV SIDE  -->
						<div id="page-wrapper" >
							<div id="page-inner">
								<div class="row">
									<div class="col-md-12">
									<h2>Detail Catin Pengantin</h2>   
										
									</div>
								</div>              
								<!-- /. ROW  -->
								<hr />
								<?php 
                    
                                // print_array($detail_catin);
                                    
                                            $id = $detail_catin[0]->id; 
                                            $nik = $detail_catin[0]->nik; 
                                            $nama = $detail_catin[0]->nama; 
                                            $tgl_lahir = $detail_catin[0]->tgl_lahir; 
                                            $gender = $detail_catin[0]->gender; 
                                            $no_hp = $detail_catin[0]->no_hp;
                                        
                                            $tgl_validasi = $detail_catin[0]->tgl_validasi;
                                            $date_create = $detail_catin[0]->date_create; 
                                            $no_surat = $detail_catin[0]->status; 

                                            $tgl_daftar = format_db($date_create);
                                            $umur_calon = hitungUmur($tgl_lahir, $tgl_daftar,'all');


                                        
                                    
                                    ?>


                             <br>

                             <div class="row"  style="margin:10px">
                              <div class="col-md-12">

                              

                                        <table>
                                        <tr>
                                            <td width="300">Nama</td>
                                            <td width="20">:</td>
                                            <td><strong><?php echo $nama ;?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td width="300">NIK</td>
                                            <td width="20">:</td>
                                            <td><strong><?php echo $nik ;?></strong> </td>
                                        </tr>
                                        <tr>
                                            <td width="300">Tanggal Lahir</td>
                                            <td width="20">:</td>
                                            <td><strong><?php echo format_view($tgl_lahir) ;?></strong> </td>
                                        </tr>

                                        <tr>
                                            <td width="300">Tanggal Daftar</td>
                                            <td width="20">:</td>
                                            <td><strong><?= format_view($date_create) .' &nbsp; '.date('H:i', strtotime($date_create)) ;?></strong> </td>
                                        </tr>
                                        
                                        
        
                                        </tr>
        
        
                                        </table>
                                <br><br>
                                
                                    
                              </div>
                             </div>
          

                           <div class="row" style="margin:10px">
                             
                              <div class="col-md-12">

                              <div class="w3-bar">
                                    <button class="btn btn-default" onclick="openCity('London')">Self Reporting</button>
                                    <button class="btn btn-default" onclick="openCity('Paris')">Anamnesis Umum</button>
                                    <button class="btn btn-default" onclick="openCity('Tokyo')">Anamnesis Tambahan</button>
                                </div>
                                <hr>

                                    <div id="London" class="w3-container city">
                                         <h2>Self Reporting Calon Pengantin</h2>
                                         <?php
                                                if(empty($self_reporting)){
                                                    echo '<div class="alert alert-warning">
                                                        <h5>Calon pengantin belum mengisi sefl reporting</h5>
                                                        </div>';
                                                }else{

                                                    echo '<table class="table table-bordered">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Pertanyaan</th>
                                                        <th>Jawaban</th>
                                                    </tr>';
                                                    $id_pertanyaan = $self_reporting[0]->id_pertanyaan;
                                                    $jawaban    = $self_reporting[0]->jawaban;

                                                    $xplode     = explode(",", $id_pertanyaan);
                                                    $xplode_jwb     = explode(",", $jawaban);

                                                    for ($i=0; $i <  count($xplode); $i++) { 
                                                            $id_pert = $xplode[$i];
                                                            $jwb = $xplode_jwb[$i];

                                                            if($jwb==0){
                                                                $jawaban = '<span class="text-success">Tidak</span>';
                                                            }else{
                                                                $jawaban = '<span class="text-danger">Iya</span>';
                                                            }

                                                            $quest =  $this->Master_model->getPertanyaan($id_pert);
                                                            
                                                            echo '
                                                            <tr>
                                                                <td>'.($i+1).'</td>
                                                                <td>'.$quest.'</td>
                                                                <td>'. $jawaban.'</td>
                                                            </tr>';
                                                    }

                                                    echo  '</table>';
                                                }

                                            ?>

                                    </div>

                                    <div id="Paris" class="w3-container city" style="display:none">
                                    <h2>Anamnesis Umum</h2>
                                    <p>Paris is the capital of France.</p> 
                                    </div>

                                    <div id="Tokyo" class="w3-container city" style="display:none">
                                    <h2>Anamnesis Tambahan</h2>
                                    <p>Tokyo is the capital of Japan.</p>
                                    </div>

                                  <br>

                                  

                                  

                                 
                                    

                              </div>

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
   
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>

    <script>
            function openCity(cityName) {
            var i;
            var x = document.getElementsByClassName("city");
            for (i = 0; i < x.length; i++) {
                x[i].style.display = "none";  
            }
            document.getElementById(cityName).style.display = "block";  
            }
            </script>
   
</body>
</html>
