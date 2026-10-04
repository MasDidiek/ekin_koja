
                        <a href="#" class="btn btn-primary mb-4 float-end " data-bs-toggle="modal" data-bs-target="#modal-report"><i class="fa-solid fa-plus"></i>&nbsp;   Add Hari Kerja  </a>
           
                         <div class="clearfix"></div>
                            <div class="table-responsive">
                               <table class="table  table-bordered"  id="data-table">

                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Jumlah Hari</th>
                                            <th>Total Waktu Efektif</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                                                    
                                                                

                                    <tbody>

                                    
                                    
                                        <?php
                                                for ($i=0; $i < count($hari_kerja) ; $i++) { 
                                                    $bulan = $hari_kerja[$i]->bulan;
                                                    $tahun = $hari_kerja[$i]->tahun;
                                                    $id = $hari_kerja[$i]->id;
                                                    $jumlah_hari = $hari_kerja[$i]->jumlah_hari;
                                                    $waktu_efektif = $jumlah_hari*300;


                                                    echo ' <tr>
                                                              <td class="text-center">'.($i+1).'</td>
                                                              <td class="text-center">'. getBulan($bulan).'</td>
                                                              <td class="text-center">'. $tahun.'</td>
                                                              <td class="text-center">'. $jumlah_hari.'</td>
                                                              <td class="text-center">'. $waktu_efektif.' menit</td>
                                                              <td class="text-center">
                                                                    <button type="button" class="btn btn-sm btn-info edit-hari-kerja" value="'.$id.'" data-bs-toggle="modal" data-bs-target="#modal-report">
                                                                    <i class="fa-solid fa-pen-to-square"></i>&nbsp;  Edit </button>

                                                                    <a href="'.base_url().'admin/setting/delete_hari_kerja/'.$id.'"  class="btn btn-sm btn-danger"onClick="return confirm(\'Hapus baris ini?\');" >
                                                                    <i class="fa-solid fa-trash-can"></i> &nbsp;   Delete
                                                                    </a>
                                                              </td>
                                                
                                                            </tr>
                                                            ';
                                                }
                                        ?>

                                    </tbody>

                              </table>
                          </div><!--table-responsive-->

                     </div>


         <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content" id="modal-form">
                <form action="<?php echo base_url();?>admin/setting/insert_hari_kerja" method="post">

                    <div class="modal-header">
                        <h5 class="modal-title">Add New Hari Kerja </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <?php
                    $list_bulan = array_bulan();
                    ?>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Bulan</label>
                                    <select type="text" name="bulan" class="form-select" id="select-users"  tabindex="-1">
                                        <?php
                                            for ($b=1; $b < count($list_bulan) ; $b++) { 
                                               
                                                echo '<option value="'.$b.'">'.$list_bulan[$b].'</option>';
                                            }
                                        ?>
                              
                                    </select>  
                                       
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Tahun</label>
                                    <input type="text" class="form-control" name="tahun" value="<?php echo date('Y');?>" required >
                                </div>
                        </div>
                        <div class="col-lg-4">
                                <div class="mb-3">
                                    <label class="form-label">Jumlah Hari</label>
                                    <input type="number" class="form-control" name="jumlah_hari" value="20" required >
                                </div>
                        </div>
                    </div>

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