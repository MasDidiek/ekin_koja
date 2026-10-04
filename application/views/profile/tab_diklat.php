
              <?php

                  

                    $arayJenis = getListJnsDiklat();

                    #print_array($arayJenis);
                ?>
              
              <div class="tab-pane fade" id="pills-pelatihan" role="tabpanel" aria-labelledby="pills-security-tab" tabindex="0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-4">
                                    <button class="btn btn-primary float-end upload-btn" value="diklat" data-bs-toggle="modal" data-bs-target="#diklat-modal" data-bs-whatever="@mdo">
                                    <i class="ti ti-plus" width="22" height="22"></i>
                                    Input Pelatihan</button>
                                        
                                    <h4 class="fw-semibold mb-3">Pelatihan / Diklat</h4>
                                
                                    <?php
                                        for ($s=0; $s < count($data_diklat) ; $s++) { 
                                            $id = $data_diklat[$s]->id;
                                            echo ' <div class="d-flex align-items-center justify-content-between mt-7 mb-3 border-bottom">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                    <a href="'.base_url().'uploads/diklat/'.$data_diklat[$s]->surtug_sertifikat.'" class="btn btn-warning" target="_blank">
                                                                        <i class="ti ti-file text-dark d-block fs-7" width="22" height="22"></i>
                                                                    </a>
                                                                </div>
                                                                <div>
                                                                    <p class="mb-0 fs-4 text-danger">
                                                                       '.$data_diklat[$s]->jns_pelatihan.'
                                                                    </p>

                                                                    <h5 class="fs-4 fw-semibold">'.$data_diklat[$s]->judul_pelatihan.'</h5>
                                                                    <p>  '.$data_diklat[$s]->lokasi_diklat.'</p>
                                                                </div>
                                                                <div class=" ms-4">
                                                                    <p class="mb-0">Tanggal Mulai</p>
                                                                    <h5 class="fs-4 fw-semibold">'.format_full($data_diklat[$s]->tgl_mulai).'</h5>
                                                                </div>
                                                                <div class=" ms-4">
                                                                    <p class="mb-0">Tanggal Selesai</p>
                                                                    <h5 class="fs-4 fw-semibold">'.format_full($data_diklat[$s]->tgl_selesai).'</h5>
                                                                </div>
                                                                

                                                            

                                                        </div>
                                                        
                                                        <div class=" ms-4">
                                                            <button type="button" class="btn btn-info btn-sm edit-diklat" value="'.$data_diklat[$s]->id.'"  data-bs-toggle="modal" data-bs-target="#edit-diklat-modal" data-bs-whatever="@mdo">
                                                                <i class="ti ti-pencil" width="22" height="22"></i> Edit
                                                            </button>
                                                            <a class="btn btn-danger btn-sm"  href="'.base_url().'profile/delete_pelatihan/'.$id.'/'.$data_diklat[$s]->surtug_sertifikat.'"  onClick="return confirm(\'Apakah anda yakin menghapus Dokumen SIP ini\');">
                                                                <i class="ti ti-trash" width="22" height="22"></i>  hapus
                                                            </a>
                                                        </div>
                                            </div>';
                                        }

                                    ?>
                                    
                            
                                </div>
                            </div>
                        </div><!--col-lg-12-->

                    </div>
            </div>

            
        <div class="modal fade" id="diklat-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                <form action="<?php echo base_url();?>profile/input_diklat" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="exampleModalLabel1">
                               Input Pelatihan/ Diklat
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                               <div class="mb-3">
                                    <label for="message-text" class="control-label">Judul / Nama Pelatihan:</label>
                                    <input type="text" name="judul" required autocomplete="off" class="form-control" >
                                </div>
                        
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="control-label">Tanggal Mulai:</label>
                                            <input type="text" required name="tanggal_mulai" autocomplete="off" class="form-control" id="dpd1" >
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                    <div class="mb-3">
                                            <label for="recipient-name" class="control-label">Tanggal Selesai:</label>
                                            <input type="text" name="tanggal_selesai" autocomplete="off" class="form-control" id="dpd2" >
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="recipient-name" class="control-label">Jenis Diklat:</label>
                                    <select name="jns_diklat" id="jns_diklat"  class="form-control">
                                        <?php
                                            for ($d=0; $d < count($arayJenis) ; $d++) { 
                                                $jns_diklat = trim($arayJenis[$d]);
                                                

                                                echo '<option value="'.$jns_diklat.'">'.$jns_diklat .'</option>';

                                            }
                                        ?>
                                    </select>
                                 </div>


                                 <div class="mb-3">
                                    <label for="message-text" class="control-label">Lokasi/Tempat Pelatihan:</label>
                                    <input type="text" name="lokasi" required autocomplete="off" class="form-control" >
                                </div>
                        

                            
                                <div class="mb-3">
                                        <div class="card w-100 bg-info-subtle overflow-hidden p-2 shadow-none">
                                            <h6>Dokumen Sertifikat/Surat Tugas:</h6>
                                            <p class="text-danger">
                                                Jenis file yang diizinkan : <strong>PDF </strong> <br>
                                                Ukuran Maksimum File      : <strong>1 MB </strong> 
                                            </p>

                                            
                                            <br>
                                            <br>
                                                <input type="file" name="filedocs" required id="file-input" class="d-none" multiple />
                                                <label for="file-input">


                                                        <div class="btn btn-primary">  
                                                            <i class="fa fa-folder-open"></i>
                                                            &nbsp; Choose Files To Upload
                                                        </div> 
                                                </label>

                                                <div id="num-of-files">No Files Choosen</div>
                                                <ul id="files-list"></ul>
                                            </div>
                                </div>


                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger-subtle text-danger font-medium"
                                data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-success">
                                Submit
                            </button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>


            <div class="modal fade" id="edit-diklat-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
                <div class="modal-dialog" role="document">
                <form action="<?php echo base_url();?>profile/update_pelatihan" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="exampleModalLabel1">
                                    Edit Data Pelatihan
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body" id="modal_form_edit">
                            
                                    
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-danger-subtle text-danger font-medium"
                                        data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>

                    </form>
                </div>
            </div>

