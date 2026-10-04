
<a href="#" class="btn btn-primary mb-4 float-end " data-bs-toggle="modal" data-bs-target="#modal-report"><i class="fa-solid fa-plus"></i>&nbsp; 
 Add Jabatan  </a>
           
           <div class="clearfix"></div>
              <div class="table-responsive">
                 <table class="table  table-bordered">

                      <thead>
                          <tr>
                              <th>No</th>
                              <th>Nama Jabatan</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                                                      
                                                  

                      <tbody>

                      
                      
                          <?php
                                  for ($i=0; $i < count($list_jabatan) ; $i++) { 
                                      $nama = $list_jabatan[$i]->nama;
                     
                                      $id = $list_jabatan[$i]->id;
                                

                                      echo ' <tr>
                                                <td class="text-center">'.($i+1).'</td>
                                                <td class="text-left">'. $nama.'</td>
   
                                                <td class="text-center">
                                                      <button type="button" class="btn btn-sm btn-info edit-jabatan" value="'.$id.'" data-bs-toggle="modal" data-bs-target="#modal-report">
                                                      <i class="fa-solid fa-pen-to-square"></i>&nbsp;  Edit </button>

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
  <form action="<?php echo base_url();?>admin/setting/insert_jabatan" method="post">

      <div class="modal-header">
          <h5 class="modal-title">Add Jabatan </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <?php
      $list_bulan = array_bulan();
      ?>
  <div class="modal-body">
      <div class="row">
     
          <div class="col-lg-12">
                  <div class="mb-3">
                      <label class="form-label">Nama Jabatan</label>
                      <input type="text" class="form-control" name="nama_jabatan" required >
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