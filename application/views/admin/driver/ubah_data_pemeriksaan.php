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
            
            
                     $id_pemeriksaan = $this->uri->segment(4);

                 $nama =  $this->session->userdata('nama');
                $puskesmas =  $this->session->userdata('puskesmas');
                $no_hp =  $this->session->userdata('no_hp');

                $id_driver = $dataPemeriksaan[0]->id_driver;
                $date_time = $dataPemeriksaan[0]->date_time;
                $terminal = $dataPemeriksaan[0]->nama_terminal;
                $ada_gejala = $dataPemeriksaan[0]->ada_gejala;
                $catatan = $dataPemeriksaan[0]->catatan;

                $tgl_periksa  = format_view($date_time);
                $jam_periksa  = date('H:i:s', strtotime($date_time));

                $day      = date('D', strtotime($tgl_periksa));
        
                $data_detail =  $this->Driver_model->get_data_edit($id_driver);

                $tgl_lahir = $data_detail[0]->tgl_lahir;
                $umur = calculateAge($tgl_lahir) ;


                $msg =  $this->session->flashdata('success');

                if($msg != '')
                {
                    echo '<div class="alert alert-success"><strong>Success!!</strong> '.$msg.'</div>';
                }
       
            ?>
                    
					<div class="row">
						<div class="col-12 col-lg-12 col-xxl-12">
							<div class="card">
								<div class="card-header">
                                        
                                     <h4> Pemeriksaan Pengemudi</h4>
								    <a href="<?php echo base_url();?>admin/admin_driver/detail/<?php echo $id_pemeriksaan;?>" class="btn btn-light border float-start  mr-2"><i class="align-middle" data-feather="corner-up-left"></i> Kembali </a>
								</div>
								
								
							    	<div class="card-body">
							    	    
							    	    <table class="infotable table-sm">
                                            <tr>
                                                <td width="200">Nama</td>
                                                <td width="20">:</td>
                                                <td><strong><?php echo $data_detail[0]->nama;?></strong></td>
                                            </tr>
                                            <tr>
                                                <td>NIK</td>
                                                <td>:</td>
                                                <td><?php echo $data_detail[0]->no_ktp;?></td>
                                            </tr>
                                            <tr>
                                                <td>Tanggal Lahir</td>
                                                <td>:</td>
                                                <td><?php echo $data_detail[0]->tgl_lahir;?></td>
                                            </tr>
                                            <tr>
                                                    <td>Status Supir</td>
                                                    <td>:</td>
                                                    <td>Supir <?php echo $data_detail[0]->status_supir;?></td>
                                                </tr>
            
                                        </table>
                                        <br><br>
							    	 
                                        <div id="snackbar">  <img src="<?php echo base_url();?>assets/img/sample-loading.gif" width="50">  Menyimpan data...</div>

							    	   
							    	      <form action="<?php echo base_url();?>admin/admin_driver/save_edit_pemeriksaan/<?php echo $data_detail[0]->id;?>" method="post">
                                                
                                                <div class="row">
                                                    <div class="col-md-7">
                                                        
                                                        <table class="infotable">
                                                            <tr height="50">
                                                                <td width="300">Hari/Tanggal</td>
                                                                <td width="20">:</td>
                                                                <td>
                                                                    <input type="text" name="hari_periksa" class="form-control float-start me-2" value="<?php echo namaHari($day);?>" style="width:100px">
                                                                    <input type="text" name="tgl_periksa" id="datepicker" required class="form-control float-start" value="<?php echo format_view($tgl_periksa);?>" style="width:150px"> 
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Waktu  Pemeriksaan</td>
                                                                <td>:</td>
                                                                <td><input type="text" name="waktu_periksa" required class="form-control" value="<?php echo $jam_periksa;?>" style="width:100px"> </td>
                                                            </tr>
                                                            <!-- <tr>
                                                                <td>Nama Terminal</td>
                                                                <td>:</td>
                                                                <td><input type="text" name="terminal" required class="form-control"> </td>
                                                            </tr> -->
                            
                                                            <tr  height="50">
                                                                <td>Nama Terminal</td>
                                                                <td>:</td>
                                                                <td>
                                                                   <input type="text" name="terminal" value="<?php echo $terminal;?>" style="width:200px" required class="form-control">
                                                                </td>
                                                            </tr>
                                                
                                                            <tr>
                                                                <td>Petugas  Pemeriksa / Puskesmas / No HP</td>
                                                                <td>:</td>
                                                                 <td><?php echo  $nama;?> / <?php echo $puskesmas;?> / <?php echo $no_hp;?></td>
                                                            </tr>
                            
                                                            <tr  height="50">
                                                                <td>Petugas  Pelapor / Puskesmas / No HP</td>
                                                                <td>:</td>
                                                                <td>-/ - / -</td>
                                                            </tr>
                                                        </table>
                                                        
                                                        
                                                             
                                                        
                                                    </div>
                                                    
                                                    <div class="col-md-5">
                                                           
                                                               <?php

                                                                $sistol  = $dataPemeriksaan[0]->tensi_sistol;
                                                                $diastol = $dataPemeriksaan[0]->tensi_diastol;
                                                    
                                                                $tensi_darah = $sistol.'/'.$diastol;
                                                    
                                                                ?>
                                                                
                                                              <h4>Pemeriksaan Fisik</h4>
                                                                     <table class="table table-sm table-borderless ">
                                
                                                                        <tr>
                                                                            <td  width="220">Berat Badan</td>
                                                                        
                                                                            <td>
                                                                                <div class="input-group mb-3">
                                                                                  
                                                                                  <input type="text" class="form-control" name="bb" placeholder="10" value="<?php echo $dataPemeriksaan[0]->bb;?>" aria-label="10" required aria-describedby="basic-addon1">
                                                                                  <span class="input-group-text" id="basic-addon1">kg</span>
                                                                                </div>
                                                                            </td>
                                                                        </tr>
                                
                                                                        <tr>
                                                                            <td>Tinggi Badan</td>
                                                                        
                                                                            <td>
                                                                                  <div class="input-group mb-3">
                                                                                    <input type="text" class="form-control" name="tb" placeholder="10" value="<?php echo $dataPemeriksaan[0]->tb;?>"  required aria-describedby="basic-addon1">
                                                                                   <span class="input-group-text" id="basic-addon1">cm</span>
                                                                                   </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Lingkar Pinggang</td>
                                                                    
                                                                             <td>
                                                                                   <div class="input-group mb-3">
                                                                              <input type="text" class="form-control" name="lp" placeholder="10" value="<?php echo $dataPemeriksaan[0]->lp;?>"  required aria-describedby="basic-addon1">
                                                                                  <span class="input-group-text" id="basic-addon1">cm</span>
                                                                                  </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Tekanan Darah </td>
                                                                        
                                                                         
                                                                            
                                                                             <td>
                                                                                   <div class="input-group mb-3">
                                                                                  <input type="text" class="form-control" name="tensi" placeholder="180/80" value="<?php echo $tensi_darah;?>" required aria-describedby="basic-addon1">
                                                                                  <span class="input-group-text" id="basic-addon1">mm/hg</span>
                                                                                  </div>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Gula Darah Sewaktu</td>
                                                                        
                                                                           
                                                                             <td>
                                                                                   <div class="input-group mb-3">
                                                                                  <input type="text" class="form-control" name="gds" placeholder="100" aria-label="10" value="<?php echo  $dataPemeriksaan[0]->gds;?>"  aria-describedby="basic-addon1">
                                                                                  <span class="input-group-text" id="basic-addon1">mg/dl</span>
                                                                                  </div>
                                                                            </td>
                                                                        </tr>
                                                                    
                                
                                                                  </table>
                                                        
                                                        
                                                               </div><!--close col-md-5-->
                                                               
                                                             <div class="col-md-6">
                                                                    <h4>Riwayat PTM Pada Keluarga</h4>
                                                                 <table class="table table-bordered">
                                                                  <thead>
                                                                    <tr>
                                                                          <th width="60%">Nama Penyakit</th>
                                                                            <th>Ya/Tidak</th>
                                                                        </tr>
                                                                    </thead>
                                                                    
                                                                   <tr>
                                                                    <td>Diabetes Melistus</td>
                                                                    <td align="center">
                                                                        <?php
                                                                            if ($riwayatPTMKeluarga[0]->dm==1) {
                                                                                echo '<input type="radio" name="dm_kel" value="1" required id="dm_kel_ya" checked><label for="dm_kel_ya">Ya </label> &nbsp;  &nbsp;  &nbsp; 
                                                                                <input type="radio" name="dm_kel" value="0" required id="dm_kel_tidak"><label for="dm_kel_tidak">Tidak</label> ';
                                                                            }else{
                                                                                echo '<input type="radio" name="dm_kel" value="1" required id="dm_kel_ya"><label for="dm_kel_ya">Ya </label> &nbsp;  &nbsp;  &nbsp; 
                                                                                <input type="radio" name="dm_kel" value="0" required id="dm_kel_tidak" checked><label for="dm_kel_tidak">Tidak</label> ';
                                                                            }
                                        
                                                                        ?>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Hipertensi</td>
                                                                    <td align="center">
                                                                        <?php
                                                                        if ($riwayatPTMKeluarga[0]->hipertensi==1) {
                                                                            echo '<input type="radio" name="ht_kel" value="1" id="ht_kel_ya" checked required><label for="ht_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                            <input type="radio" name="ht_kel" value="0" id="ht_kel_tdk" required><label for="ht_kel_tdk"> Tidak';
                                                                        }else{
                                                                            echo '<input type="radio" name="ht_kel" value="1" id="ht_kel_ya" required><label for="ht_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                            <input type="radio" name="ht_kel" value="0" id="ht_kel_tdk" checked><label for="ht_kel_tdk"> Tidak';  
                                                                        }
                                                                        ?>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Jantung</td>
                                                                    <td align="center">
                                        
                                                                    <?php
                                                                        if ($riwayatPTMKeluarga[0]->jantung==1) {
                                        
                                                                            echo ' <input type="radio" name="jantung_kel" value="1" id="jt_kel_ya" checked><label for="jt_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                            <input type="radio" name="jantung_kel" value="0" id="jt_kel_tdk" required><label for="jt_kel_tdk"> Tidak';
                                                                        }else{
                                                                            echo ' <input type="radio" name="jantung_kel" value="1" id="jt_kel_ya" required><label for="jt_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                            <input type="radio" name="jantung_kel" value="0" id="jt_kel_tdk" checked><label for="jt_kel_tdk"> Tidak';
                                                                        }
                                        
                                                                        ?>
                                                                       </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Stroke</td>
                                                                    <td align="center">
                                                                    <?php
                                                                        if ($riwayatPTMKeluarga[0]->stroke==1) {
                                                                            echo '<input type="radio" name="stroke_kel" value="1" id="str_kel_ya" checked><label for="str_kel_ya">  Ya &nbsp;  &nbsp;  &nbsp; 
                                                                            <input type="radio" name="stroke_kel" value="0" id="str_kel_tdk" required><label for="str_kel_tdk">  Tidak';
                                                                        }else{
                                                                            echo '<input type="radio" name="stroke_kel" value="1" id="str_kel_ya" required><label for="str_kel_ya">  Ya &nbsp;  &nbsp;  &nbsp; 
                                                                            <input type="radio" name="stroke_kel" value="0" id="str_kel_tdk" checked><label for="str_kel_tdk">  Tidak';
                                                                        }
                                        
                                                                        ?>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Asma</td>
                                                                    <td align="center">
                                                                        <?php
                                                                            if ($riwayatPTMKeluarga[0]->asma==1) {
                                                                                echo '<input type="radio" name="asma_kel" value="1" id="asma_kel_ya" checked> <label for="asma_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                <input type="radio" name="asma_kel" value="0" id="asma_kel_tdk" required> <label for="asma_kel_tdk"> Tidak';
                                                                            }else{
                                                                                echo '<input type="radio" name="asma_kel" value="1" id="asma_kel_ya" > <label for="asma_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                <input type="radio" name="asma_kel" value="0" id="asma_kel_tdk" checked> <label for="asma_kel_tdk"> Tidak';
                                                                            }
                                                                        ?>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Kanker</td>
                                                                    <td align="center">
                                                                    <?php
                                                                            if ($riwayatPTMKeluarga[0]->kanker==1) {
                                        
                                                                                echo '<input type="radio" name="kanker_kel" value="1" id="kan_kel_ya" checked> <label for="kan_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                <input type="radio" name="kanker_kel" value="0" id="kan_kel_tdk" required><label for="ken_kel_tdk">  Tidak';
                                                                            }else{
                                        
                                                                                echo '<input type="radio" name="kanker_kel" value="1" id="kan_kel_ya" > <label for="kan_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                <input type="radio" name="kanker_kel" value="0" id="kan_kel_tdk" checked><label for="ken_kel_tdk">  Tidak';
                                                                                
                                                                            }
                                        
                                                                            ?>
                                                                        
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Kolesterol</td>
                                                                    <td align="center">
                                        
                                                                         <?php
                                                                            if ($riwayatPTMKeluarga[0]->kolesterol==1) {
                                                                                echo ' <input type="radio" name="kolesterol_kel" value="1" id="kol_kel_ya" checked> <label for="kol_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                <input type="radio" name="kolesterol_kel" value="0" id="kol_kel_tdk" required> <label for="kol_kel_tdk"> Tidak';
                                        
                                                                            }else{
                                                                                echo ' <input type="radio" name="kolesterol_kel" value="1" id="kol_kel_ya"> <label for="kol_kel_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                <input type="radio" name="kolesterol_kel" value="0" id="kol_kel_tdk" checked> <label for="kol_kel_tdk"> Tidak';
                                                                                
                                                                            }
                                        
                                        
                                                                            ?>
                                                                       
                                                                    </td>
                                                                </tr>
                                                                
                                                                </table>
                                                              
                                                                  
                                                                    <br>
                                                                     <h4>Riwayat PTM Pada Diri Sendiri</h4>
                                                                        <table class="table  table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                    <th width="60%">Nama Penyakit</th>
                                                                                    <th>Ya/Tidak</th>
                                                                                </tr>
                                                                            </thead>
                                                                            
                                                                           <tr>
                                                                                <td>Diabetes Melistus</td>
                                                                                <td align="center">
                                                                                    <?php
                                                                                        if ($riwayatPTMDiri[0]->dm==1) {
                                                                                            echo '<input type="radio" name="dm" value="1" required id="dm_ya" checked><label for="dm_ya">Ya </label> &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="dm" value="0" required id="dm_tidak"><label for="dm_tidak">Tidak</label> ';
                                                                                        }else{
                                                                                            echo '<input type="radio" name="dm" value="1" required id="dm_ya"><label for="dm_ya">Ya </label> &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="dm" value="0" required id="dm_tidak" checked><label for="dm_tidak">Tidak</label> ';
                                                                                        }
                                                    
                                                                                    ?>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Hipertensi</td>
                                                                                <td align="center">
                                                                                    <?php
                                                                                    if ($riwayatPTMDiri[0]->hipertensi==1) {
                                                                                        echo '<input type="radio" name="ht" value="1" id="ht_ya" checked required><label for="ht_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                        <input type="radio" name="ht" value="0" id="ht_tdk" required><label for="ht_tdk"> Tidak';
                                                                                    }else{
                                                                                        echo '<input type="radio" name="ht" value="1" id="ht_ya" required><label for="ht_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                        <input type="radio" name="ht" value="0" id="ht_tdk" checked><label for="ht_tdk"> Tidak';  
                                                                                    }
                                                                                    ?>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Jantung</td>
                                                                                <td align="center">
                                                    
                                                                                <?php
                                                                                    if ($riwayatPTMDiri[0]->jantung==1) {
                                                    
                                                                                        echo ' <input type="radio" name="jantung" value="1" id="jt_ya" checked><label for="jt_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                        <input type="radio" name="jantung" value="0" id="jt_tdk" required><label for="jt_tdk"> Tidak';
                                                                                    }else{
                                                                                        echo ' <input type="radio" name="jantung" value="1" id="jt_ya" required><label for="jt_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                        <input type="radio" name="jantung" value="0" id="jt_tdk" checked><label for="jt_tdk"> Tidak';
                                                                                    }
                                                    
                                                                                    ?>
                                                                                   </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Stroke</td>
                                                                                <td align="center">
                                                                                <?php
                                                                                    if ($riwayatPTMDiri[0]->stroke==1) {
                                                                                        echo '<input type="radio" name="stroke" value="1" id="str_ya" checked><label for="str_ya">  Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                        <input type="radio" name="stroke" value="0" id="str_tdk" required><label for="str_tdk">  Tidak';
                                                                                    }else{
                                                                                        echo '<input type="radio" name="stroke" value="1" id="str_ya" required><label for="str_ya">  Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                        <input type="radio" name="stroke" value="0" id="str_tdk" checked><label for="str_tdk">  Tidak';
                                                                                    }
                                                    
                                                                                    ?>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Asma</td>
                                                                                <td align="center">
                                                                                    <?php
                                                                                        if ($riwayatPTMDiri[0]->asma==1) {
                                                                                            echo '<input type="radio" name="asma" value="1" id="asma_ya" checked> <label for="asma_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="asma" value="0" id="asma_tdk" required> <label for="asma_tdk"> Tidak';
                                                                                        }else{
                                                                                            echo '<input type="radio" name="asma" value="1" id="asma_ya" > <label for="asma_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="asma" value="0" id="asma_tdk" checked> <label for="asma_tdk"> Tidak';
                                                                                        }
                                                                                    ?>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Kanker</td>
                                                                                <td align="center">
                                                                                <?php
                                                                                        if ($riwayatPTMDiri[0]->kanker==1) {
                                                    
                                                                                            echo '<input type="radio" name="kanker" value="1" id="kan_ya" checked> <label for="kan_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="kanker" value="0" id="kan_tdk" required><label for="ken_tdk">  Tidak';
                                                                                        }else{
                                                    
                                                                                            echo '<input type="radio" name="kanker" value="1" id="kan_ya" > <label for="kan_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="kanker" value="0" id="kan_tdk" checked><label for="ken_tdk">  Tidak';
                                                                                            
                                                                                        }
                                                    
                                                                                        ?>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Kolesterol</td>
                                                                                <td align="center">
                                                    
                                                                                     <?php
                                                                                        if ($riwayatPTMDiri[0]->kolesterol==1) {
                                                                                            echo ' <input type="radio" name="kolesterol" value="1" id="kol_ya" checked> <label for="kol_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="kolesterol" value="0" id="kol_tdk" required> <label for="kol_tdk"> Tidak';
                                                    
                                                                                        }else{
                                                                                            echo ' <input type="radio" name="kolesterol" value="1" id="kol_ya"> <label for="kol_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="kolesterol" value="0" id="kol_tdk" checked> <label for="kol_tdk"> Tidak';
                                                                                            
                                                                                        }
                                                    
                                                    
                                                                                        ?>
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                        
                                                                        
                                                                        </table>
                                                               </div><!--close col-md-6-->
                                                                <div class="col-md-6">
                                                                    
                                                                        <h4>Faktor Resiko</h4>
                                                                        <table class="table table-bordered" style="margin-top:10px;">
                                                                            <thead>
                                                                            <tr>
                                                                                    <th>Faktor</th>
                                                                                    <th>Ya/Tidak</th>
                                                                                </tr>
                                                                            </thead>
                                                                            
                                                                             <tr>
                                                                                <td>Merokok</td>
                                                                                <td align="center">
                                                    
                                                                                <?php
                                                                                        if ($faktorResiko[0]->merokok==1) {
                                                                                            echo ' <input type="radio" name="rokok" value="1" id="rokok_ya" checked><label for="rokok_ya">  Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="rokok" value="0" id="rokok_tdk" required><label for="rokok_tdk"> Tidak';
                                                                                        }else{
                                                                                            echo ' <input type="radio" name="rokok" value="1" id="rokok_ya" required><label for="rokok_ya">  Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="rokok" value="0" id="rokok_tdk" checked><label for="rokok_tdk"> Tidak';
                                                                                        }
                                                    
                                                                                        ?>
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Kurang Aktifitas Fisik</td>
                                                                                <td align="center">
                                                                                <?php
                                                                                        if ($faktorResiko[0]->krng_aktf_fisik==1) {
                                                                                            echo '<input type="radio" name="aktf_fisik" value="1" id="fisik_ya" checked><label for="fisik_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="aktf_fisik" value="0" id="fisik_tdk" required><label for="fisik_tdk"> Tidak';
                                                                                        }else{
                                                                                            echo '<input type="radio" name="aktf_fisik" value="1" id="fisik_ya" required><label for="fisik_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="aktf_fisik" value="0" id="fisik_tdk" checked><label for="fisik_tdk"> Tidak';
                                                                                        }
                                                    
                                                                                        ?>
                                                                                    
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Kurang Sayur dan Buah</td>
                                                                                <td align="center">
                                                                                <?php
                                                                                        if ($faktorResiko[0]->krng_sayur_buah==1) {
                                                                                            echo ' <input type="radio" name="sayur_buah" value="1" id="buah_ya" checked><label for="buah_ya">  Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="sayur_buah" value="0" id="buah_tdk" required> <label for="buah_tdk"> Tidak';
                                                                                        }else{
                                                                                            echo ' <input type="radio" name="sayur_buah" value="1" id="buah_ya" required><label for="buah_ya">  Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="sayur_buah" value="0" id="buah_tdk" checked> <label for="buah_tdk"> Tidak';
                                                                                        }
                                                    
                                                                                        ?>
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>Konsumsi alkohol</td>
                                                                                <td align="center">
                                                                                <?php
                                                                                        if ($faktorResiko[0]->alkohol==1) {
                                                                                            echo ' <input type="radio" name="alkohol" value="1" id="alkh_ya" checked><label for="alkh_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="alkohol" value="0" id="alkh_tdk" required> <label for="alkh_tdk">Tidak';
                                                                                        }else{
                                                                                            echo ' <input type="radio" name="alkohol" value="1" id="alkh_ya" required><label for="alkh_ya"> Ya &nbsp;  &nbsp;  &nbsp; 
                                                                                            <input type="radio" name="alkohol" value="0" id="alkh_tdk" checked> <label for="alkh_tdk">Tidak';
                                                                                        }
                                                    
                                                                                        ?>
                                                                                   
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                             
                                                                      
                                                                             <br>
                                                                              <h6>Ada gejala Penyerta ?</h6>
                
                                                                             <input type="checkbox" name="gejala_penyerta" value="1" <?php echo ($ada_gejala  == 1) ? "checked" : "";?>> Iya, ada &nbsp; &nbsp; &nbsp; <small>( Cheklist jika ada )</small> <br>
                    <textarea name="ket_gejala_penyerta"  class="form-control"  placeholder="ketik keterangan mengenai penyakit gejala penyerta yang ada"><?php echo $catatan;?></textarea>
                                                                                
                                                                                    <br><br>
                                                                                  <h6>Penanganan Yang di Berikan </h6>
                                                                                    <table class=" table-borderless" style="margin-top:10px;">
                                                                                
                                                                                      
                                                                                        <tr>
                                                                                            <td>
                                                                                                <input type="checkbox" name="konseling_rokok" value="1"  <?php echo ($dataPemeriksaan[0]->kons_berhnt_rokok  == 1) ? "checked" : "";?>>   &nbsp;  Konseling berhenti merokok
                                                                                           </td>
                                                                                            
                                                                                        </tr>
                                                                                        <tr>
                                                                                        <td>
                                                                                                <input type="checkbox" name="konseling_diet" value="1"  <?php echo ($dataPemeriksaan[0]->kons_diet_sehat  == 1) ? "checked" : "";?>>  &nbsp;  Konseling diet sehat
                                                                                           </td>
                                                                                        </tr>
                                                                                     
                                                                                        <tr>
                                                                                        <td>
                                                                                                <input type="checkbox" name="rujuk" value="1"  id="rujuk"  <?php echo ($dataPemeriksaan[0]->rujuk  == 1) ? "checked" : "";?>>  &nbsp;   Rujuk Fasilitas kesehatan/ Puskesmas
                                                                                           </td>
                                                                                        </tr>

                                        
                                                                                    </table>
                                        
                                        
                                                                    <br><br>
                        
                                                                
                                                                    <h4>Pemeriksaan Penunjang </h4><br>
                        
                                                                    <table class="teble">
                        
                                                                           <tr>
                                                                                <td>
                                                                                 <label for="keseimbangan">Test keseimbangan</label> :
                                                                                </td>
                                                                                <td>
                                                                                    <select name="keseimbangan" class="form-control" style="width:300px">
                                                                                    <?php
                                                                                            if ($faktorResiko[0]->tes_keseimbangan==1) {
                                                                                                echo '<option value="1" selected>Normal</option>
                                                                                                <option value="2">Tidak Normal karena kelainan anatomis </option>
                                                                                                <option value="3">Tidak normal karena kelainan neurologis</option>';
                                                                                            }else if($faktorResiko[0]->tes_keseimbangan==2){
                                                                                                echo '<option value="1">Normal</option>
                                                                                                <option value="2" selected>Tidak Normal karena kelainan anatomis </option>
                                                                                                <option value="3">Tidak normal karena kelainan neurologis</option>';
                                                                                            }else{
                                                                                                echo '<option value="1">Normal</option>
                                                                                                <option value="2">Tidak Normal karena kelainan anatomis </option>
                                                                                                <option value="3" selected>Tidak normal karena kelainan neurologis</option>';
                                                                                            }
                                                                                        ?>
                                                                                            
                                                                                            
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td><label for="narkoba">Amphetamin Urine</label> : </td>
                                                                                <td> 
                                                                                    <select name="narkoba" class="form-control" style="width:300px">
                                                                                    <?php
                                                                                            if ($faktorResiko[0]->tes_urine==1) {
                                                                                                echo ' <option value="0">Amphetamin Tidak diperiksa </option>
                                                                                                <option value="1" selected>Amphetamin Negatif (-)</option>
                                                                                                <option value="2">Amphetamin Positif (+)</option>';
                                                                                            }else if($faktorResiko[0]->tes_urine==2){
                                                                                                echo ' <option value="0">Amphetamin Tidak diperiksa </option>
                                                                                                <option value="1">Amphetamin Negatif (-)</option>
                                                                                                <option value="2" selected>Amphetamin Positif (+)</option>';
                                                                                            }else{
                                                                                                echo ' <option value="0" selected>Amphetamin Tidak diperiksa </option>
                                                                                                <option value="1">Amphetamin Negatif (-)</option>
                                                                                                <option value="2">Amphetamin Positif (+)</option>';
                                                                                            }
                                                                                        ?>
                                                
                                                
                                                                                           
                                                                                            
                                                                                    </select>
                                                                                </td>
                                                                            </tr>
                                                                    </table>

  <br><br>
                                                                   
                                                                     
                                                                     
                                                                     
                                                                </div><!--close col-md-6-->
                                                               
                                                               
        
                                                         <div class="clearfix"></div>
                                                    <br><br>
                                                    
                                                    <div class="col-md-12">
                                                              <button type="submit" class="btn btn-success float-end ms-2">Simpan Perubahan</button>
                                                                             <a href="<?php echo base_url();?>admin/admin_driver/detail/<?php echo $data_detail[0]->id;?>" class="btn btn-danger  float-end">Kembali</a>
                                                                             
                                                                             </div>
                                                                     
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