        
        <?php
            
            $id_jabatan    = $pegawai[0]->id_jabatan;
            $jabatan       = $this->Master_model->getNamaJabatan($id_jabatan);
            $id_puskesmas  = $pegawai[0]->id_puskesmas;
            $nm_puskesmas  = $this->Master_model->getNamaPuskesmas($id_puskesmas);
            $tgl_masuk     = $pegawai[0]->tgl_masuk;
            $nip = $pegawai[0]->nip;
            $photo         = $this->Pegawai_model->getPhotoPegawai($nip);
            if($photo==''){
                $photo = 'avatar.png';
             }

             
             $message = $this->session->flashdata('message'); 
             $message_update = $this->session->flashdata('message_update'); 
             $error_msg = $this->session->flashdata('error_msg'); 



             $invalid1 = '';
             $invalid2 = '';
             if($error_msg=='failed1'){
               $invalid1 = 'is-invalid';
             }else if($error_msg=='failed2'){
               $invalid2 = 'is-invalid';
             }

            
        ?>
        <div class="tab-pane fade show active" id="pills-account" role="tabpanel"
                    aria-labelledby="pills-account-tab" tabindex="0">

                    <div class="border py-2 px-4 mb-2 bg-info-subtle  form-upload d-none" id="form-upload-photo">
                            <form method="post" action="<?php echo base_url();?>profile/upload_image" enctype="multipart/form-data">
                            <div class="fw-bold font-medium">Upload Image Profile</div>
                            <Br>
                            <div class="input-group flex-nowrap bg-white"> 
                                <div class="custom-file" style="width: 100%;">
                                    <input class="form-control" name="imageupload" required type="file" id="formFile">
                                </div>
                                <button class="btn btn-info  font-medium" type="submit">
                                    Upload
                                </button>
                                
                            </div>

                            
                            <br>
                                Ukuran file yang diizinkan : <br>
                                <div class="text-danger">
                                    Maximum -  (H x W):  <strong> 2000px &nbsp;  x &nbsp;  2500px</strong><br> 
                                    Maximum - File Size :  <strong> 5 MB</strong>
                                </div>
                            </form>
                    </div> 


                    <div class="row">
                        <div class="col-lg-5 d-flex align-items-stretch">
                           <div class="card w-100 position-relative overflow-hidden">
                               <div class="card-body p-4">
                                    <div class="text-center">
                                        <img src="<?php echo  base_url();?>uploads/photo_profile/<?php echo $photo;?>" alt="" class=" rounded-circle"
                                        width="180" height="180">
                                            <div class="d-flex align-items-center justify-content-center my-4 gap-3 btn-upload">
                                                <button type="button" id="button_upload" class="justify-content-center btn mb-1 btn-rounded btn-primary d-flex align-items-center">
                                                    <i class="ti ti-inbox fs-4 me-2"></i>
                                                    Change Image Profile
                                                </button>
                                                
                                            
                                                <!-- <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p> -->
                                            </div>

                                            <h5 class="card-title fw-semibold"><?php echo $pegawai[0]->nama;?></h5>
                                        <p class="card-subtitle mb-4"><?php echo $jabatan ;?></p>

                                        <span class="text-info" style="font-size: 12px;"> <i class="ti ti-map fs-4 me-2"></i>  <?php echo $nm_puskesmas ;?></span> 
                                        &nbsp;&nbsp;&nbsp;&nbsp; |  &nbsp;&nbsp;&nbsp;&nbsp;  
                                        
                                        <span class="text-info" style="font-size: 12px;">
                                        <i class="ti ti-id-badge fs-4 me-2"></i>Join Date : <?php echo format_slash($tgl_masuk);?></span> 
                                    </div>

                                    
                                       
                            </div>
                        </div>
                 </div>
                        <div class="col-lg-7 d-flex align-items-strech">
                                <div class="card  border-0 w-100">
                                <div class="card-body pb-0">
                                    <h5 class="fw-semibold mb-1 text-primary card-title">
                                     Rekap Absensi  
                                    </h5>
                                    <p class="fs-3 mb-3 text-danger">Januari 2024</p>
                               
                                </div>
                                <div class="card mx-2 mb-2 mt-n2">
                                    <div class="card-body">

                                        <div class="mb-7 pb-1">
                                            <div class="d-flex justify-content-between align-items-center mb-6">
                                            <div>
                                                <h6 class="mb-1 fs-4 fw-semibold">Akumulasi Terlambat</h6>
                                                <p class="fs-3 mb-0">0</p>
                                            </div>
                                            <div>
                                                <span class="badge bg-primary-subtle text-primary fw-semibold fs-3">0%</span>
                                            </div>
                                            </div>
                                            <div class="progress bg-primary-subtle" style="height: 4px">
                                            <div class="progress-bar w-2" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                        <div class="mb-7 pb-1">
                                            <div class="d-flex justify-content-between align-items-center mb-6">
                                            <div>
                                                <h6 class="mb-1 fs-4 fw-semibold">Akumulasi Cuti</h6>
                                                <p class="fs-3 mb-0">0</p>
                                            </div>
                                            <div>
                                                <span class="badge bg-success-subtle text-success fw-semibold fs-3">0%</span>
                                            </div>
                                            </div>
                                            <div class="progress bg-success-subtle" style="height: 4px">
                                            <div class="progress-bar  text-bg-success w-1" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-6">
                                            <div>
                                                <h6 class="mb-1 fs-4 fw-semibold">Akumulasi Izin</h6>
                                                <p class="fs-3 mb-0">0</p>
                                            </div>
                                            <div>
                                                <span class="badge bg-warning-subtle text-warning fw-bold fs-3">0%</span>
                                            </div>
                                        </div>
                                        <div class="progress bg-warning-subtle" style="height: 4px">
                                        <div class="progress-bar text-bg-warning w-0" role="progressbar" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        <div class="col-12">
                        <form method="post" action="<?php echo base_url();?>profile/update_profile">
                        <div class="card w-100 position-relative overflow-hidden mb-0">
                            <div class="card-body p-4">
                            <h5 class="card-title fw-semibold">Personal Details</h5>
                            <p class="card-subtitle mb-4">To change your personal detail , edit and save from here</p>
                            <form>
                                <div class="row">
                                    <div class="col-lg-6">
                                            <div class="mb-4">
                                                <label for="exampleInputtext" class="form-label fw-semibold">Nama Lengkap</label>
                                                <input type="text" name="nama" class="form-control" disabled  value="<?php echo $pegawai[0]->nama;?>" readonly>
                                            </div><!--mb-4-->

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
                                            </div><!--mb-4-->
                                            <div class="mb-4">
                                                <label for="exampleInputPassword1" class="form-label fw-semibold">Lokasi Kerja / Puskesmas</label>
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
                                            </div><!--mb-4-->

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
                                            </div><!--mb-4-->

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
                                            </div><!--mb-4-->


                                            <div class="mb-4">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="">
                                                            <label for="exampleInputtext" class="form-label fw-semibold">No KTP</label>
                                                            <input type="text" name="no_ktp" class="form-control" value="<?php echo $data_detail[0]->no_ktp;?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="">
                                                            <label for="exampleInputtext" class="form-label fw-semibold">No Rekening (Bank DKI)</label>
                                                            <input type="text" name="no_rekening" class="form-control" value="<?php echo $data_detail[0]->no_rekening;?>">
                                                        </div>
                                                    </div>
                                                    
                                                </div>
            
                                            </div><!--mb-4-->

                                            <div class="mb-4">
                                                    <label for="exampleInputtext3" class="form-label fw-semibold">NPWP</label>
                                                    <input type="text" class="form-control" name="npwp" value="<?php echo $data_detail[0]->npwp;?>" id="exampleInputtext3">
                                            </div><!--mb-4-->

                                    </div>
                                <div class="col-lg-6">
                                
                                    
                                                        
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="mb-4">
                                                        <label for="exampleInputtext" class="form-label fw-semibold">NIP</label>
                                                        <input type="text" name="nip" class="form-control"  readonly disabled value="<?php echo $pegawai[0]->nip;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="mb-4">
                                                        <label for="exampleInputtext" class="form-label fw-semibold">NRK</label>
                                                        <input type="text" name="nrk" class="form-control" readonly disabled value="<?php echo $pegawai[0]->nrk;?>">
                                                    </div>
                                                </div>
                                            </div>

                                    

                                        <div class="mb-4">
                                                    
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="">
                                                        <label for="exampleInputtext" class="form-label fw-semibold">Tempat/Kota Lahir</label>
                                                        <input type="text" name="kota_lahir" class="form-control" value="<?php echo $data_detail[0]->tempat_lahir;?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-5">
                                                    <div class="">
                                                        <label for="exampleInputtext" class="form-label fw-semibold">Tgl Lahir</label>
                                                        <input type="date" name="tgl_lahir" class="form-control" value="<?php echo $data_detail[0]->tgl_lahir;?>">
                                                    </div>
                                                </div>
                                            
                                            </div>

                                        </div><!--mb-4-->

                                        <div class="mb-4">
                                            <label for="exampleInputtext3" class="form-label fw-semibold">No Telp / HP</label>
                                            <input type="text" class="form-control" name="no_hp" value="<?php echo $data_detail[0]->no_tlp;?>" id="exampleInputtext3">
                                        </div><!--mb-4-->
                                        <div class="mb-4">
                                            <label for="exampleInputtext3" class="form-label fw-semibold">Email</label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $data_detail[0]->email;?>" id="exampleInputtext3">
                                        </div><!--mb-4-->

                                        <div class="mb-4">
                                            <label for="exampleInputtext4" class="form-label fw-semibold">Alamat KTP</label>
                                            <textarea name="alamat_ktp"  class="form-control"  id="alamat_ktp" cols="30" rows="3"><?php echo $data_detail[0]->alamat_ktp;?></textarea>
                                        </div><!--mb-4-->
                                        <div class="mb-4">
                                            <label for="exampleInputtext4" class="form-label fw-semibold">Alamat Domisili</label>
                                            <textarea name="alamat_domisili"  class="form-control"  id="alamat_domisili" cols="30" rows="3"><?php echo $data_detail[0]->alamat_domisili;?></textarea>
                                        </div><!--mb-4-->
                                </div>



                                <div class="col-12">
                                    <div class="d-flex align-items-center justify-content-end mt-4 gap-2">
                                    <button type="submit" class="btn btn-primary">Save Change</button>
                                    </div>
                                </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    </div>