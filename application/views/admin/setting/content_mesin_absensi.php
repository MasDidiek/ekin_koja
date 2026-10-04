<h5 class="card-title fw-semibold mb-4"> <?php echo $title; ?> </h5>
<!-- <a href="<?php echo base_url(); ?>admin/setting/importDataAbsensi" class="btn btn-warning mb-4 float-start ">
                                <i class="fa-solid fa-download"></i>&nbsp;   Import Absensi  </a>
                  -->

<a href="#" class="btn btn-info mb-4 float-end " data-bs-toggle="modal" data-bs-target="#modal-report">
    <i class="fa-solid fa-plus"></i>&nbsp; Add Mesin Absensi </a>

<div class="clearfix"></div>
<div class="table-responsive">
    <table class="table  table-bordered" id="data-table">

        <thead>
            <tr>
                <th>No</th>
                <th>Serial Number</th>
                <th>Nama</th>
                <th>IP Address</th>
                <th>Status</th>
                <th>Last Update</th>
                <th>Action</th>
            </tr>
        </thead>



        <tbody>

            <?php
            //print_array($mesin_absensi);

            for ($i = 0; $i < count($mesin_absensi); $i++) {
                $serial_number = $mesin_absensi[$i]->serial_number;
                $nama_mesin = $mesin_absensi[$i]->nama_mesin;
                $ip_address = $mesin_absensi[$i]->ip_address;
                $status = $mesin_absensi[$i]->status;
                $last_update = $mesin_absensi[$i]->last_update;


                if ($status == 1) {
                    $flag = '<a href="' . base_url() . 'admin/setting/refresh_mesin/' . $ip_address . '" class="badge bg-success">
                     Online  &nbsp; <i class="fas fa-refresh"></i>
                    </a>';
                } else {
                    $flag = '<a href="' . base_url() . 'admin/setting/refresh_mesin/' . $ip_address . '" class="badge bg-danger">
                    Offline  &nbsp;<i class="fas fa-refresh"></i>
                   </a>';
                }


                echo ' <tr>
                <td class="text-center">' . ($i + 1) . '</td>                                                                
                <td class="text-center">' . $serial_number . '</td>
                <td class="text-center">
                <a href="' . base_url() . 'admin/setting/list_user/' . $serial_number . '">' . $nama_mesin . '</a></td>
                <td class="text-center">' . $ip_address . ' </td>
                <td class="text-center">' . $flag . '</td>
                <td class="text-center">' . $last_update . '</td>
                <td class="text-center">
                
                            <a href="' . base_url() . 'admin/setting/tarik_data/' . $serial_number . '"  class="btn btn-sm btn-light" >
                            <i class="fa-solid fa-download"></i> &nbsp;  Tarik Data
                        </a>

                        <button type="button" class="btn btn-sm btn-secondary upload-file" value="' . $serial_number . '" data-bs-toggle="modal" data-bs-target="#modal-upload">
                        <i class="fa-solid fa-upload"></i>&nbsp;  Import
                         </button>

                        
                      <button type="button" class="btn btn-sm btn-info edit-mesin-absensi" value="' . $serial_number . '" data-bs-toggle="modal" data-bs-target="#modal-report">
                      <i class="fa-solid fa-pen-to-square"></i>&nbsp;  Edit </button>

                      <a href="' . base_url() . 'admin/setting/delete_mesin_absensi/' . $serial_number . '"  class="btn btn-sm btn-danger"onClick="return confirm(\'Hapus baris ini?\');" >
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
            <form action="<?php echo base_url(); ?>admin/setting/insertUpdateMesin" method="post">

                <div class="modal-header">
                    <h5 class="modal-title">Add Mesin Absensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">Serial Number</label>
                                <input type="text" class="form-control" name="sn" required>

                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label">IP Address</label>
                                <input type="text" class="form-control" name="ip_address" required>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="mb-3">
                                <label class="form-label">Nama Mesin</label>
                                <input type="text" class="form-control" name="nama_mesin" required>
                            </div>
                        </div>

                        <div class="col-lg-8 mb-3">
                            <label>Puskesmas</label>
                            <select name="id_puskesmas" class="form-control">';

                                <?php
                                foreach ($list_puskesmas as $puskesmas) {

                                    $id_pkm = $puskesmas->id_puskesmas;
                                    $nama_puskesmas = $puskesmas->nama;


                                    echo ' <option value="' . $id_pkm . '">' . $nama_puskesmas . '</option>';
                                }




                                ?>
                            </select>

                        </div>
                    </div>

                </div>


                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary ms-auto">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Save
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-upload" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" id="modal-form">
            <?php echo nl2br(form_open_multipart('admin/setting/import_file')); ?>
            <div class="modal-header">
                <h5 class="modal-title">Import Absensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>


            <div class="modal-body">
                <div class="row">

                    <div class="col-lg-12 mb-3">
                        <div class="form-group mb-2">
                            <label>Serial Number</label>
                            <input type="text" class="form-control" name="sn" id="sn">
                        </div>


                        <div class="form-group">

                            <label>File </label>
                            <input type="file" name="file_1" size="20" class="form-control" /><br /><br />

                        </div>

                    </div>
                </div>

            </div>


            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                    Cancel
                </a>
                <button type="submit" class="btn btn-success ms-auto">

                    <i class="fa-solid fa-download"></i>&nbsp;
                    Import Absensi
                </button>
            </div>

            </form>

        </div>
    </div>
</div>