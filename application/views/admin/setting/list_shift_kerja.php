            <?php
            $msg_delete = $this->session->flashdata('msg_delete');
            $msg_insert = $this->session->flashdata('msg_insert');

            ?>


            <div class="table-responsive p-4">

                <?php echo $msg_insert; ?>

                <a href="<?php echo base_url(); ?>mesin_absensi/index" class="btn btn-danger">Back</a>

                <form action="<?php echo base_url(); ?>admin/setting/update_all" method="post">

                    <button type="submit" class="btn btn-success float-end ms-2"> <i class="fa-solid fa-refresh"></i>&nbsp; Update Data</button>

                    <a href="#" class="btn btn-info mb-4 float-end ms-2 " data-bs-toggle="modal" data-bs-target="#modal-report">
                        <i class="fa-solid fa-plus"></i>&nbsp; Tambah Shift Kerja </a>

                    <a href="<?php echo base_url(); ?>admin/setting/create_initial_shift" class="btn btn-light mb-4 float-end">
                        <i class="fa-solid fa-calendar"></i>&nbsp; Buat Inisial Shift </a>


                    <div class="clearfix"></div>


                    <table class="table ">
                        <thead style="text-align: center">
                            <tr>
                                <th>No</th>
                                <th>Kode Shift</th>
                                <th>Nama Shift</th>
                                <th>Jam Masuk </th>
                                <th>Jam Keluar</th>
                                 <th>Pengguna</th>
                                <th>Sort</th>
                                <th>Publish</th>

                                <th>Action</th>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $no = 0;
                            for ($i = 0; $i < count($shift_kerja); $i++) {
                                $id          = $shift_kerja[$i]->id;
                                $nama_shift  = $shift_kerja[$i]->nama_shift;
                                $kode_shift  = $shift_kerja[$i]->kode_shift;
                                $jam_masuk   = $shift_kerja[$i]->jam_masuk;
                                $jam_pulang  = $shift_kerja[$i]->jam_pulang;
                                $publish     = $shift_kerja[$i]->publish;
                                $urutan      = $shift_kerja[$i]->urutan;

                                $check = ($publish == 1) ? 'checked' : '';
                                $no++;
                                ?>
                                <tr>
                                    <input type="hidden" name="id_shift[]" value="<?= $id; ?>">
                                    <td class="text-center"><?= $no; ?></td>
                                    <td class="text-center"><strong><?= $kode_shift; ?></strong></td>
                                    <td><?= $nama_shift; ?></td>
                                    <td class="text-center text-success"><?= $jam_masuk; ?></td>
                                    <td class="text-center text-danger"><?= $jam_pulang; ?></td>
                                    <td class="text-center"><?= $shift_kerja[$i]->status_kerja; ?></td>
                                    <td class="text-center">
                                        <input type="text" name="sort[]" value="<?= $urutan; ?>" class="form-control form-control-sm text-center mx-auto" style="width:60px;">
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check d-flex justify-content-center">
                                            <!-- Input HIDDEN ini yang dikirim ke controller PHP -->
                                            <input type="hidden" name="publish[]" class="publish-val" value="<?= $publish; ?>">

                                            <!-- Checkbox tampilan (tanpa atribut name) -->
                                            <input type="checkbox" class="form-check-input publish-check" <?= $check; ?>>
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <button type="button" class="btn btn-sm btn-success btn-edit-shift" data-kode="<?= $kode_shift; ?>">
                                            <i class="fa fa-edit me-1"></i> Ubah
                                        </button>
                                        <a href="<?= base_url('admin/setting/delete_shift_kerja/' . $id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah anda yakin ?');">Hapus</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>

                </form>
            </div>
            </div>
            <br>


            <!-- Modal Edit Shift Kerja -->
            <div class="modal fade" id="modalEditShift" tabindex="-1" aria-labelledby="modalEditShiftLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalEditShiftLabel"><i class="fa fa-pencil-square-o text-success me-2"></i>Edit Shift Kerja</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="formEditShift" action="<?= base_url('admin/setting/update_shift_kerja'); ?>" method="post">
                    <div class="modal-body py-3">
                        <!-- Hidden Input untuk ID / Primary Key -->
                        <input type="hidden" name="id" id="edit_id">

                        <div class="mb-3">
                        <label class="form-label fw-semibold fs-2">Kode Shift</label>
                        <input type="text" class="form-control rounded-3" name="kode_shift" id="edit_kode_shift" required>
                        </div>
                        <div class="mb-3">
                        <label class="form-label fw-semibold fs-2">Nama Shift</label>
                        <input type="text" class="form-control rounded-3" name="nama_shift" id="edit_nama_shift" required>
                        </div>
                        <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold fs-2">Jam Masuk</label>
                            <input type="time" class="form-control rounded-3" name="jam_masuk" id="edit_jam_masuk" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold fs-2">Jam Keluar</label>
                            <input type="time" class="form-control rounded-3" name="jam_keluar" id="edit_jam_keluar" required>
                        </div>
                        </div>
                        <div class="mb-2">
                        <label class="form-label fw-semibold fs-2 d-block">Status Pengguna</label>
                        <div class="mb-2">
                            <div class="mb-2">
                              <label class="form-label fw-semibold fs-2 d-block">Penggunaan Untuk Pegawai</label>
                              <div class="d-flex flex-wrap gap-3 pt-1">
                                <div class="form-check">
                                  <input type="checkbox" id="edit_user_non_pns" name="user_pengguna[]" value="non_pns" class="form-check-input edit-user-check">
                                  <label class="form-check-label" for="edit_user_non_pns">Non PNS</label>
                                </div>
                                <div class="form-check">
                                  <input type="checkbox" id="edit_user_pjlp" name="user_pengguna[]" value="pjlp" class="form-check-input edit-user-check">
                                  <label class="form-check-label" for="edit_user_pjlp">PJLP</label>
                                </div>
                                <div class="form-check">
                                  <input type="checkbox" id="edit_user_pppk_pw" name="user_pengguna[]" value="pppk_pw" class="form-check-input edit-user-check">
                                  <label class="form-check-label" for="edit_user_pppk_pw">PPPK PW</label>
                                </div>
                              </div>
                            </div>
                        </div>
                        <div id="edit_status_pengguna_container"></div>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 px-4"><i class="fa fa-save me-1"></i> Simpan Perubahan</button>
                    </div>
                    </form>
                </div>
                </div>
            </div>

            <!-- Modal Add New Shift -->
            <div class="modal fade" id="modal-report" tabindex="-1" aria-labelledby="modalAddShiftLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">

                  <!-- Modal Header -->
                  <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" id="modalAddShiftLabel">
                      <i class="fa fa-plus-circle text-primary me-2"></i>Tambah Shift Kerja Baru
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <!-- Form Shift -->
                  <form method="post" action="<?php echo base_url(); ?>admin/setting/add_new_shift">
                    <div class="modal-body py-3">

                      <!-- Baris 1: Kode & Nama Shift -->
                      <div class="row">
                        <div class="col-md-5 mb-3">
                          <label class="form-label fw-semibold fs-2">Kode Shift</label>
                          <input type="text" name="kode_shift" class="form-control rounded-3" required placeholder="Contoh: P">
                        </div>
                        <div class="col-md-7 mb-3">
                          <label class="form-label fw-semibold fs-2">Nama Shift</label>
                          <input type="text" name="nama_shift" class="form-control rounded-3" required placeholder="Contoh: Pagi">
                        </div>
                      </div>

                      <!-- Baris 2: Jam Masuk & Jam Keluar -->
                      <div class="row">
                        <div class="col-md-6 mb-3">
                          <label class="form-label fw-semibold fs-2">Jam Masuk</label>
                          <input type="time" name="jam_masuk" id="jam_masuk" class="form-control rounded-3" required value="08:00">
                        </div>
                        <div class="col-md-6 mb-3">
                          <label class="form-label fw-semibold fs-2">Jam Keluar</label>
                          <input type="time" name="jam_keluar" class="form-control rounded-3" required value="16:00">
                        </div>
                      </div>

                      <!-- Baris 3: Status Pengguna -->
                      <div class="mb-2">
                        <label class="form-label fw-semibold fs-2 d-block">Penggunaan Untuk Pegawai</label>
                        <div class="d-flex flex-wrap gap-3 pt-1">
                          <div class="form-check">
                            <input type="checkbox" id="customRadio11" name="user_pengguna[]" checked value="non_pns" class="form-check-input">
                            <label class="form-check-label" for="customRadio11">Non PNS</label>
                          </div>
                          <div class="form-check">
                            <input type="checkbox" id="customRadio22" name="user_pengguna[]" value="pjlp" class="form-check-input">
                            <label class="form-check-label" for="customRadio22">PJLP</label>
                          </div>
                          <div class="form-check">
                            <input type="checkbox" id="customRadio33" name="user_pengguna[]" value="pppk_pw" class="form-check-input">
                            <label class="form-check-label" for="customRadio33">PPPK PW</label>
                          </div>
                        </div>
                      </div>

                    </div>

                    <!-- Modal Footer -->
                    <div class="modal-footer border-top-0 pt-0">
                      <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">Batal</button>
                      <button type="submit" class="btn btn-primary rounded-3 px-4">
                        <i class="fa fa-save me-1"></i> Simpan Shift
                      </button>
                    </div>
                  </form>

                </div>
              </div>
            </div>