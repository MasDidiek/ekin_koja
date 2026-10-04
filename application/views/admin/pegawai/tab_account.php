        <?php


                $tgl_masuk = $pegawai[0]->tgl_masuk;
                $nip = $pegawai[0]->nip;
                $nama_pegawai = $pegawai[0]->nama;
                $photo = $this->Pegawai_model->getPhotoPegawai($nip);

                if($photo==''){
                $photo = 'avatar.png';
                }


                $arrayStatusPajak = array('TK', 'K0', 'K1', 'K2');
                $array_group = arrayUsergroup(); 

                $status_kerja = $pegawai[0]->status_kerja;

                $class_status0 = 'btn-light';
                $class_status1 = 'btn-light';
                $class_status2 = 'btn-light';
                if($status_kerja==1){
                  $class_status1 = 'btn-success';
                }else if($status_kerja==2){
                  $class_status2 = 'btn-warning';
                }else{
                  $class_status0 = 'btn-danger';
                }



                $jns_pegawai  = $pegawai[0]->jns_pegawai;
        ?>
        
            <div class="row">
                    <div class="col-lg-4 d-flex align-items-stretch">
                      <div class="card w-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                         
                          <div class="text-center">

                          <h5 class="card-title fw-semibold"><?php echo $pegawai[0]->nama;?></h5>
                          <p class="card-subtitle mb-4"><?php echo $pegawai[0]->nip;?></p>


                            <img src="<?php echo  base_url();?>uploads/photo_profile/<?php echo $photo;?>" alt="" class=" rounded-circle"
                              width="180" height="180">
                            <div class="d-flex align-items-center justify-content-center my-4 gap-3">
                              <!-- <button class="btn btn-primary">Upload</button>
                              <button class="btn btn-outline-danger">Reset</button> -->
                             <p>
                              Join Date :  <span class="text-primary"> <?php echo format_full($tgl_masuk);?></span>
                              </p>
                             
                            </div>

                            <div class="row">
                                <p> Status kerja : </p> 

                                <form method="post" action="<?php echo base_url();?>admin/pegawai/change_status_kerja/<?php echo $pegawai[0]->id_pegawai;?>">
                                    <button type="submit" value="1" name="status" class="w-100 btn mb-1   <?php echo $class_status1 ;?>">
                                      <i class="ti ti-check fs-4 me-2"></i>
                                      Aktif
                                    </button>


                                    <button type="submit" value="2"  name="status"  class=" w-100 btn mb-1 <?php echo $class_status2 ;?>">
                                      <i class="ti ti-heart fs-4 me-2"></i>
                                      Cuti bersalin
                                    </button>

                                    <button type="submit" value="0"  name="status"  class=" w-100 btn mb-1 <?php echo $class_status0 ;?>">
                                      <i class="ti ti-x fs-4 me-2"></i>
                                      Tidak Aktif
                                    </button>
                                </form>


                                   

                            </div>
                          
                            <a href="<?php echo base_url();?>admin/pegawai/delete_pegawai/<?php echo $pegawai[0]->id_pegawai;?>" 
                            class="btn btn-light w-100 text-danger" 
                            onclick="return confirm('Apakah anda yakin ingin menghapus data pegawai ini?');">
                                  <i class="ti ti-trash fs-4 me-2"></i>
                                  Hapus
                                </a>
                                
                       
                          <a href="<?php echo base_url();?>admin/pegawai/reset_password/<?php echo $pegawai[0]->id_pegawai;?>" 
                            class="btn btn-warning w-100" 
                            onclick="return confirm('Apakah anda yakin ingin mereset password ?');">
                                  <i class="ti ti-refresh fs-4 me-2"></i>
                                  Reset password
                                </a>


                            <!-- <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p> -->
                          </div>
                        </div>
                            
                      </div>

                      
                    </div>


                    <div class="col-lg-8 d-flex align-items-stretch">
                      <div class="card w-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                        <form method="post" action="<?php echo base_url();?>admin/pegawai/update_data_pegawai/<?php echo $pegawai[0]->id_pegawai.'/'.$pegawai[0]->nip;?>">
                          <h5 class="card-title fw-semibold">Edit Profile Account </h5><br>

                               <div class="row">
                                    <div class="col-md-7">
                                      <div class="mb-4">
                                        <label for="exampleInputtext" class="form-label fw-semibold">Nama Lengkap</label>
                                        <input type="text" name="nama" class="form-control"  value="<?php echo $pegawai[0]->nama;?>">
                                      </div>
                                    </div>
                                    <div class="col-md-5">
                                       <div class="mb-4">
                                            <label for="exampleInputtext" class="form-label fw-semibold">TMT</label>
                                        <input type="date" name="tmt"  class="form-control" value="<?php echo $tgl_masuk;?>">
                                      </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-7">
                                        <div class="mb-4">
                                          <label for="exampleInputtext" class="form-label fw-semibold">NIP</label>
                                          <input type="text" name="nip" class="form-control"  value="<?php echo $pegawai[0]->nip;?>">
                                        </div>
                                    </div>
                                      <div class="col-md-3">
                                        <div class="mb-4">
                                          <label for="exampleInputtext" class="form-label fw-semibold">ID Mesin</label>
                                         
                                          <input type="text" name="id_mesin" class="form-control"  value="<?php echo $pegawai[0]->id_mesin;?>">
                                           <span class="text-muted">ID di Mesin Absensi</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-4">
                                          <label for="exampleInputtext" class="form-label fw-semibold">NRK</label>
                                          <input type="text" name="nrk" class="form-control"  value="<?php echo $pegawai[0]->nrk;?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                          <label for="exampleInputtext" class="form-label fw-semibold">Golongan</label>
                                          <input type="text" name="golongan" class="form-control"  value="<?php echo $pegawai[0]->golongan;?>">
                                        </div>

                                    </div>
                                    <div class="col-md-5">
                                          <div class="mb-4">
                                              <label for="exampleInputPassword3" class="form-label fw-semibold">Jabatan</label>
                                              <select class="form-select" name="id_jabatan" aria-label="Default select example">

                                              <?php
                                                        foreach ($list_jabatan as $jabatan){
                                                                                    
                                                          $id = $jabatan->id;
                                                          $nama_jabatan = $jabatan->nama;

                                                          if($id==$pegawai[0]->id_jabatan){
                                                            echo ' <option value="'. $id .'" selected>'.$nama_jabatan .'</option>';
                                                          }else{
                                                            echo ' <option value="'. $id .'">'.$nama_jabatan .'</option>';
                                                          }
                                                        

                                                        }

                                                    ?>
                                                </select>
                                          </div>
                                    </div>

                                    <div class="col-md-3">
                                      <div class="mb-4">
                                          <label for="exampleInputPassword1" class="form-label fw-semibold">Jenis Pegawai</label>
                                          <select class="form-select" name="jns_pegawai" aria-label="Default select example">
                                              <?php
                                               
                                                   if($jns_pegawai=='non_pns'){
                                                    echo '  
                                                    <option value="non_pns" selected>NON PNS</option>
                                                    <option value="pns">PNS</option>
                                                    <option value="pppk">PPPK</option>
                                                    <option value="pjlp">PJLP</option>';

                                                }else if($jns_pegawai=='pns'){
                                                    echo '  
                                                    <option value="non_pns">NON PNS</option>
                                                    <option value="pns" selected>PNS</option>
                                                    <option value="pppk">PPPK</option>
                                                    <option value="pjlp">PJLP</option>';
                                                }else if($jns_pegawai=='pppk'){
                                                    echo '  
                                                    <option value="non_pns">NON PNS</option>
                                                    <option value="pns">PNS</option>
                                                    <option value="pppk" selected>PPPK</option>
                                                    <option value="pjlp">PJLP</option>';
                                                }else{
                                                    echo '  
                                                    <option value="non_pns">NON PNS</option>
                                                    <option value="pns">PNS</option>
                                                    <option value="pjlp" selected>PJLP</option>';
                                                }
                                                ?>
                                            </select>
                                          </div>
                                  </div>
                               
                          
                            </div>
                      </div>
                    </div>

                    </div>
                 

                    
                    <div class="col-12">
                      <div class="card w-100 position-relative overflow-hidden mb-0">
                        <div class="card-body p-4">
                          <h5 class="card-title fw-semibold">Personal Details</h5>
                          <p class="card-subtitle mb-4">To change your personal detail , edit and save from here</p>
                   
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="mb-4">
                                      <label for="exampleInputPassword1" class="form-label fw-semibold">Poli / Layanan</label>
                                      <select class="form-select" name="id_poli" aria-label="Default select example">
                                              <?php
                                                  foreach ($list_poli as $poli){
                                                                              
                                                    $id_poli = $poli->id;
                                                    $nama_poli = $poli->nama_poli;

                                                    if($id_poli==$pegawai[0]->id_poli){
                                                      echo ' <option value="'. $id_poli .'" selected>'.$nama_poli .'</option>';
                                                    }else{
                                                      echo ' <option value="'. $id_poli .'">'.$nama_poli .'</option>';
                                                    }
                                                  

                                                  }

                                              ?>
                                        
                                          </select>
                                    </div>

                                    <div class="mb-4">
                                        <label for="exampleInputPassword1" class="form-label fw-semibold">Puskesmas</label>
                                        <select class="form-select" name="id_puskesmas" aria-label="Default select example">
                                                <?php
                                                    foreach ($list_puskesmas as $puskesmas){
                                                                                
                                                      $id_puskesmas = $puskesmas->id_puskesmas;
                                                      $nama_puskesmas = $puskesmas->nama;

                                                      if($id_puskesmas==$pegawai[0]->id_puskesmas){
                                                        echo ' <option value="'. $id_puskesmas .'" selected>'.$nama_puskesmas .'</option>';
                                                      }else{
                                                        echo ' <option value="'. $id_puskesmas .'">'.$nama_puskesmas .'</option>';
                                                      }
                                                    

                                                    }

                                                ?>
                                          
                                            </select>
                                    </div>

                                
                                  

                                      <div class="mb-4">
                                          <label for="exampleInputPassword2" class="form-label fw-semibold">Jenis Jam Kerja</label>
                                          <select class="form-select" name="jns_jam_kerja" aria-label="Default select example">
                                          <?php
                                                  if($pegawai[0]->jns_jam_kerja=='shift'){
                                                    echo '  
                                                    <option value="shift" selected>SHIFT</option>
                                                    <option value="non_shift">REGULAR</option>';

                                                  }else{
                                                    echo '  
                                                    <option value="shift">SHIFT</option>
                                                    <option value="non_shift" selected>REGULAR</option>';
                                                  }
                                                ?>
                                            </select>
                                      </div>
                           
                            
                             </div>
                             <div class="col-lg-4">
                                 <div class="mb-4">
                                      <label for="exampleInputPassword2" class="form-label fw-semibold">Atasan Langsung</label>
                                        <select class="form-select" name="id_validator" aria-label="Default select example">
                                          <?php
                                                  foreach ($list_validator as $validator){
                                                                              
                                                    $id_pegawai_atasan = $validator->id_pegawai;
                                                    $nama_pegawai = $validator->nama;

                                                    if($id_pegawai_atasan==$pegawai[0]->id_validator){
                                                      echo ' <option value="'. $id_pegawai_atasan .'" selected>'.$nama_pegawai .'</option>';
                                                    }else{
                                                      echo ' <option value="'. $id_pegawai_atasan .'">'.$nama_pegawai .'</option>';
                                                    }
                                                  

                                                  }

                                              ?>
                                      
                                          </select>
                                    </div>

                                  <div class="mb-4">
                                    <label for="exampleInputPassword3" class="form-label fw-semibold">Status Kawin</label>
                                      <select class="form-select" name="status_kawin" aria-label="Default select example">

                                          <?php
                                                foreach ($list_Status as $status_kawin){
                                                                            
                                                  $id_status = $status_kawin->id;
                                                  $status = $status_kawin->status;
                                                  $ket_status = $status_kawin->ket;

                                                  if($id_status==$pegawai[0]->status_kawin){
                                                    echo ' <option value="'. $id_status .'" selected>'.$status .' - '.$ket_status.'</option>';
                                                  }else{
                                                    echo ' <option value="'. $id_status .'">'.$status .' - '.$ket_status.'</option>';
                                                  }
                                                

                                                }

                                            ?>
                                        </select>
                                  </div>
                                  <div class="mb-4">

                                    <label for="exampleInputPassword3" class="form-label fw-semibold">Status Pajak</label>
                                    <select class="form-select" name="status_pajak" aria-label="Default select example">
                                    
                                        
                                        <?php
                                                for ($a=0; $a < count($arrayStatusPajak); $a++){
                                                                            
                                        
                                                  $status_pajak = $arrayStatusPajak[$a];

                                                  if($status_pajak==$pegawai[0]->status_pajak){
                                                    echo ' <option value="'. $status_pajak .'" selected>'.$status_pajak .'</option>';
                                                  }else{
                                                    echo ' <option value="'. $status_pajak .'">'.$status_pajak .'</option>';
                                                  }
                                                

                                                }

                                            ?>
                                        </select>
                                    </div>

                             </div>
                             <div class="col-lg-4">
                                    <div class="mb-4">

                                  
                                       <label for="exampleInputPassword3" class="form-label fw-semibold">Pendidikan</label>

                                        <select class="form-select" name="id_pendidikan"  aria-label="Default select example">
                                              <?php
                                                    foreach ($list_pendidikan as $pendidikan){
                                                                                
                                                      $id_pnd = $pendidikan->id;
                                                      $nama_pendidikan = $pendidikan->pendidikan;

                                                      if($id_pnd==$pegawai[0]->id_pendidikan){
                                                        echo ' <option value="'. $id_pnd .'" selected>'.$nama_pendidikan .'</option>';
                                                      }else{
                                                        echo ' <option value="'. $id_pnd .'">'.$nama_pendidikan .'</option>';
                                                      }
                                                    

                                                    }
                                                ?>
                                        </select>
                                    </div>


                                   <div class="mb-4">
                                      <label for="exampleInputPassword2" class="form-label fw-semibold">Rumpun Kerja</label>
                                      <select class="form-select" name="rumpun_kerja" aria-label="Default select example">

                                              <?php
                                                if($pegawai[0]->rumpun_kerja=='ukp'){
                                                  echo '  
                                                  <option value="ukp" selected>UKP</option>
                                                  <option value="ukm">UKM</option>
                                                  <option value="admen">ADMEN</option>';

                                                }else if($pegawai[0]->rumpun_kerja=='ukm'){
                                                  echo '  
                                                  <option value="ukp">UKP</option>
                                                  <option value="ukm" selected>UKM</option>
                                                  <option value="admen">ADMEN</option>';
                                                }else{
                                                  echo '  
                                                  <option value="ukp">UKP</option>
                                                  <option value="ukm">UKM</option>
                                                  <option value="admen" selected>ADMEN</option>';
                                                }
                                              ?>
                                          
                                          </select>
                                    </div>

                                    <div class="mb-4">

                                      <?php $id_usergroup = $pegawai[0]->usergroup;  ?>
                                      <label for="exampleInputPassword3" class="form-label fw-semibold">Usergroup</label>

                                       <select class="form-select" name="usergroup"  aria-label="Default select example">
                                            <?php
                                                  for ($i=0; $i < count($array_group); $i++){
                                                                              
                                                    $ug_id = $i;
                                                    $group = $array_group[$i];

                                                    if($ug_id==$id_usergroup){
                                                      echo ' <option value="'. $ug_id .'" selected>'.$group .'</option>';
                                                    }else{
                                                      echo ' <option value="'. $ug_id .'">'.$group .'</option>';
                                                    }
                                                  

                                                  }

                                              ?>
                                          </select>
                                      </div>


                                      <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                 
                                </div> 
                             </div>

                             
                                    




                          </form>
                        </div>
                      </div>
                    </div>
                  </div>