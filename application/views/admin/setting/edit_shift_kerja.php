                <div class="card-body">
                      
                  <form action="<?php echo base_url();?>admin/setting/update_shift_kerja/<?php echo $dataEdit->id;?>" method="post">

                      <div class="row pt-3">
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Kode Shift</label>
                            <input type="text" name="kode_shift" id="firstName" class="form-control" value="<?php echo $dataEdit->kode_shift;?>">
                            
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Nama Shift Kerja</label>
                            <input type="text"  name="nama_shift"  class="form-control"  value="<?php echo $dataEdit->nama_shift;?>">
                          </div>
                        </div>
                        <!--/span-->
                      </div>
                      <!--/row-->
                      <div class="row">
                      <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Jam Masuk</label>
                            <input type="text" name="jam_masuk" id="jam_masuk" class="form-control" value="<?php echo $dataEdit->jam_masuk;?>">
                          
                          </div>
                        </div>
                        <!--/span-->
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label">Jam Keluar</label>
                            <input type="text"  name="jam_keluar"  class="form-control"  value="<?php echo $dataEdit->jam_pulang;?>">
                          </div>
                        </div>
                        <!--/span-->
                      </div>
                      <!--/row-->
                      <div class="row">
                        
                      <?php 
                         $status_kerja =  $dataEdit->status_kerja;
                         $checkUser1 = '';
                         $checkUser2 = '';

                         if($status_kerja =='non_pns'){
                                $checkUser1 = 'checked';
                         }else{
                               $checkUser2 = 'checked';
                         }
                      ?>
                        <!--/span-->
                        <div class="col-md-6">
                          <div class="mb-3">
                            <label class="form-label">Penggunaan untuk pegawai</label>
                            <div class="form-check py-1">
                              <input type="radio" id="customRadio11" name="user_pengguna" value="non_pns" class="form-check-input" <?php echo $checkUser1;?>>
                              <label class="form-check-label" for="customRadio11">Non PNS</label>
                            </div>
                            <div class="form-check py-1">
                              <input type="radio" id="customRadio22" name="user_pengguna"   value="pjlp" class="form-check-input"  <?php echo $checkUser2;?>>
                              <label class="form-check-label" for="customRadio22">PJLP</label>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                            

                        </div>
                        <!--/span-->
                      </div>


                      <a href="<?= base_url() ?>admin/setting/shift_kerja" class="flat-btn btn-light btn-border fs-3 px-4 py-2 mb-3 me-2">Kembali</a>
                      <button type="submit" class="flat-btn fs-3 px-4 py-2 mb-3 me-2  btn-success">Simpan Perubahan</button>
                      </form>

                    </div>
