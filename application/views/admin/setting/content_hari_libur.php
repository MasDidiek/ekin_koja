


                            <a href="#" class="btn btn-primary mb-4 float-end " data-bs-toggle="modal" data-bs-target="#modal-report"><i class="fa-solid fa-plus"></i>&nbsp;   Add <?php echo $title;?>  </a>

                            <div class="clearfix"></div>

                                 <table class="table table-bordered table-striped" id="data-table">

                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal</th>
                                            <th>Keterangan</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                                                    
                                                                

                                    <tbody>

                                    
                                    
                                        <?php
                                                for ($i=0; $i < count($hari_libur) ; $i++) { 
                                                    $tgl = $hari_libur[$i]->tgl;
                                                    $keterangan = $hari_libur[$i]->keterangan;
                                                    $id = $hari_libur[$i]->id;
                                                  


                                                    echo ' <tr>
                                                              <td class="text-center">'.($i+1).'</td>
                                                           
                                                              <td class="text-center">'.format_view($tgl).'</td>
                                                              <td class="text-left">'. $keterangan.' </td>
                                                              <td class="text-center">
                                                                   <a href="'.base_url().'admin/setting/delete_hari_libur/'.$id.'"  class="btn btn-sm btn-danger"onClick="return confirm(\'Hapus baris ini?\');" >
                                                                    <i class="fa-solid fa-trash-can"></i> &nbsp;   Delete
                                                                    </a>
                                                              </td>
                                                
                                                            </tr>
                                                            ';
                                                }
                                        ?>

                                    </tbody>

                              </table>
                       

                     </div>
                </div><!--card body-->
            </div>

<div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="modal-form">
          <form action="<?php echo base_url();?>admin/setting/insert_hari_libur" method="post">

                <div class="modal-header">
                    <h5 class="modal-title">Add New Hari Libur </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


               <div class="modal-body">
                    <div class="row">
                        
                        <div class="col-lg-3">
                                <div class="mb-3">
                                    <label class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" name="tgl" value="<?php echo date('Y-m-d');?>" required >
                                </div>
                        </div>
                        <div class="col-lg-9">
                                <div class="mb-3">
                                    <label class="form-label">Keterangan</label>
                                    <input type="text" class="form-control" name="keterangan"  required >
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