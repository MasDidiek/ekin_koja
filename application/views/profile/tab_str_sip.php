                <div class="tab-pane fade" id="pills-str-sip" role="tabpanel" aria-labelledby="pills-bills-tab" tabindex="0">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-4">
                                    <button class="btn btn-primary float-end upload-btn" value="sip" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo">
                                        <i class="ti ti-plus" width="22" height="22"></i>
                                        Input SIP</button>

                                    <h4 class="fw-semibold mb-3">Dokumen SIP</h4>

                                    <?php
                                    for ($s = 0; $s < count($data_sip); $s++) {
                                        $id = $data_sip[$s]->id;
                                        echo ' <div class="d-flex align-items-center justify-content-between mt-7 mb-3 border-bottom">
                                                                    <div class="d-flex align-items-center gap-3">
                                                                        <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                          <a href="' . base_url() . 'uploads/sip_str/' . $data_sip[$s]->file_name . '" class="btn btn-warning" target="_blank">
                                                                             <i class="ti ti-file text-dark d-block fs-7" width="22" height="22"></i>
                                                                            </a>
                                                                        </div>
                                                                        <div>
                                                                            <p class="mb-0">No SIP</p>
                                                                            <h5 class="fs-4 fw-semibold">' . $data_sip[$s]->no_sip_str . '</h5>
                                                                        </div>
                                                                        <div class=" ms-4">
                                                                            <p class="mb-0">Tanggal Terbit</p>
                                                                            <h5 class="fs-4 fw-semibold">' . format_full($data_sip[$s]->tgl_terbit) . '</h5>
                                                                        </div>
                                                                        <div class=" ms-4">
                                                                            <p class="mb-0">Tanggal Kadaluarsa</p>
                                                                            <h5 class="fs-4 fw-semibold">' . format_full($data_sip[$s]->tgl_kadaluarsa) . '</h5>
                                                                        </div>
                                                                       

                                                                  

                                                                </div>
                                                              
                                                                <div class=" ms-4">
                                                                        <a href="' . base_url() . 'uploads/sip_str/' . $data_sip[$s]->file_name . '" class="btn btn-sm btn-success" target="_blank">
                                                                        <i class="ti ti-file"></i> Lihat File
                                                                    </a>
                                                                    <button type="button" class="btn btn-info btn-sm edit-sipstr" value="' . $data_sip[$s]->id . '"  data-bs-toggle="modal" data-bs-target="#edit-modal" data-bs-whatever="@mdo">
                                                                     <i class="ti ti-pencil" width="22" height="22"></i> Edit
                                                                    </button>
                                                                    <a class="btn btn-danger btn-sm"  href="' . base_url() . 'profile/delete_sip_str/' . $id . '/' . $data_sip[$s]->file_name . '"  onClick="return confirm(\'Apakah anda yakin menghapus Dokumen SIP ini\');">
                                                                     <i class="ti ti-trash" width="22" height="22"></i>  hapus
                                                                    </a>
                                                             </div>
                                                    </div>';
                                    }

                                    ?>


                                </div>
                            </div>
                        </div><!--col-lg-12-->



                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body p-4">

                                    <button class="btn btn-primary float-end upload-btn" value="str" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo">
                                        <i class="ti ti-plus" width="22" height="22"></i>
                                        Input STR</button>

                                    <h4 class="fw-semibold mb-3">Dokumen STR</h4>

                                    <?php
                                    for ($s = 0; $s < count($data_str); $s++) {

                                        $seumur_hidup = $data_str[$s]->seumur_hidup;
                                        $tgl_exp =  $data_str[$s]->tgl_kadaluarsa;

                                        if ($seumur_hidup == 1) {
                                            $exp_date = '<span class="text-success">Seumur Hidup</span>';
                                        } else {
                                            $exp_date = format_full($data_str[$s]->tgl_kadaluarsa);
                                        }

                                        echo ' <div class="d-flex align-items-center justify-content-between mt-7 mb-3 border-bottom">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                            <a href="' . base_url() . 'uploads/sip_str/' . $data_str[$s]->file_name . '" class="btn btn-warning" target="_blank">
                                                            <i class="ti ti-file text-dark d-block fs-7" width="22" height="22"></i>
                                                            </a>
                                                            </div>
                                                            <div>
                                                                <p class="mb-0">No SIP</p>
                                                                <h5 class="fs-4 fw-semibold">' . $data_str[$s]->no_sip_str . '</h5>
                                                            </div>
                                                            <div class=" ms-4">
                                                                <p class="mb-0">Tanggal Terbit</p>
                                                                <h5 class="fs-4 fw-semibold">' .  format_full($data_str[$s]->tgl_terbit) . '</h5>
                                                            </div>
                                                            <div class=" ms-4">
                                                                <p class="mb-0">Tanggal Kadaluarsa</p>
                                                                <h5 class="fs-4 fw-semibold">' . $exp_date . '</h5>
                                                            </div>
                                                            

                                                                  

                                                                </div>
                                                              
                                                                <div class=" ms-4">
                                                                    <a href="' . base_url() . 'uploads/sip_str/' . $data_str[$s]->file_name . '" class="btn btn-sm btn-success" target="_blank">
                                                                    <i class="ti ti-file"></i> Lihat File
                                                                </a>
                                                                    <button type="button" class="btn btn-info btn-sm edit-sipstr" value="' . $data_str[$s]->id . '"  data-bs-toggle="modal" data-bs-target="#edit-modal" data-bs-whatever="@mdo">
                                                                    <i class="ti ti-pencil" width="22" height="22"></i> Edit
                                                                </button>
                                                                <a class="btn btn-danger btn-sm"  href="' . base_url() . 'profile/delete_sip_str/' . $data_str[$s]->id . '/' . $data_str[$s]->file_name . '"  onClick="return confirm(\'Apakah anda yakin menghapus Dokumen SIP ini\');">
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