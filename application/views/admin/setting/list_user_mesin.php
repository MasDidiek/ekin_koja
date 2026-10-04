<?php
                              $ip_address = $detail_mesin[0]->ip_address;
                              $serial_number = $detail_mesin[0]->serial_number;
                      
                              $msg_delete = $this->session->flashdata('msg_delete');
                              $msg_insert = $this->session->flashdata('msg_insert');

                              
                      
                              ?>


<div class="table-responsive p-4">
                        <table>
                            <tr>
                                <td width="150">Puskesmas</td>
                                <td width="20">:</td>
                                <td><strong><?php echo $detail_mesin[0]->nama_mesin;?></strong></td>
                            </tr>
                            <tr>
                                <td>IP Address</td>
                                <td>:</td>
                                <td><strong><?php echo $detail_mesin[0]->ip_address;?></strong></td>
                            </tr>
                            <tr>
                                <td>Serial Number</td>
                                <td>:</td>
                                <td><strong><?php echo $detail_mesin[0]->serial_number;?></strong></td>
                            </tr>
                        </table>
                        <br>
                        <?php echo $msg_insert;?>

                        <a href="<?php echo base_url();?>mesin_absensi/index" class="btn btn-danger">Back</a>
                        <a href="<?php echo base_url();?>mesin_absensi/getDataPresensi/<?php echo $detail_mesin[0]->ip_address;?>" class="btn btn-warning float-right">Lihat Data Presensi</a>

                        <a href="#" class="btn btn-primary mb-4 float-end " data-bs-toggle="modal" data-bs-target="#modal-report">
                                <i class="fa-solid fa-plus"></i>&nbsp;   Add New User </a>

                                <div class="clearfix"></div>
                 

                        <table class="table  "  id="data-table">
                            <thead style="text-align: center">
                                <tr>
                                    <th>No</th>
                                    <th>PIN</th>
                                    <th>Nama</th>
                                    <th>Edit</th>

                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                        $no = 0;
                                        for ($i=0; $i < count($list_user) ; $i++) { 
                                            $pin = $list_user[$i]['pin'];
                                            $nama = $list_user[$i]['nama'];

                                            if($pin !== ''){
                                                $no = $no+1;
                                                echo '
                                                <tr>
                                                    <td style="text-align:center">'.$no.'</td>
                                                    <td style="text-align:center">'.$pin.'</td>
                                                    <td>
                                                    <a href="'.base_url().'admin/setting/detail_user/'.$pin.'/'.$ip_address.'" class="text-info">
                                                     '.$nama.'
                                                    </a></td>
                                                    <td  style="text-align:center">
                                                    <a href="'.base_url().'admin/setting/delete_user/'.$pin.'/'.$ip_address.'/'.$serial_number.'" class="btn btn-danger btn-sm" onClick="return confirm(\'Delete user ini?\');">
                                                     Delete User
                                                    </a>
                                                      </td>
                                                  
                                                </tr>';
                                            }
                                        }
                                ?>
                            </tbody>

                        </table>
                  </div>


                  <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content" id="modal-form">
                      <form method="post" action="<?php echo base_url(); ?>admin/setting/insert_user/<?php echo $ip_address.'/'.$serial_number;?>">
      
                          <div class="modal-header">
                              <h5 class="modal-title">Add Mesin Absensi</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
      
                        
                            <div class="modal-body">
                             
                                    <label for="nama shift">PIN &nbsp;: </label> &nbsp;
                                    <input type="text" name="pin" class="form-control" style="width: 150px;" required><br>

                                    <br>
                                    <label for="nama shift">Nama &nbsp;: </label> &nbsp;
                                    <input type="text" name="nama" class="form-control" required><br><br>
            
                            </div>
      
      
                          <div class="modal-footer">
                              <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                  Cancel
                              </a>
                              <button type="submit" class="btn btn-primary ms-auto" >
                              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                              Save
                              </button>
                          </div>
      
                  </form>
      
              </div>
            </div>
          </div>