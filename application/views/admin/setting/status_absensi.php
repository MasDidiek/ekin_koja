<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>

    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('layout/section/sidebar');?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view('layout/section/topbar');?>

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Main Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php
                                    $message = $this->session->flashdata('message');
                                    $function = $this->uri->segment(3);
                                ?>


                  <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                        <div class="card-body p-4">

                            <h4 class="card-title">Status Absensi</h4>
                            <!-- Tombol untuk membuka modal -->
                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#statusModal">
                              Tambah Status
                            </button>
                            <div class="clearfix"></div>


                            <table id="basic-datatable" class="table dt-responsive nowrap w-100 mt-3">

                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th>Nama Status</th>
                                      <th>Menit Penambah</th>
                                      <th>Menit Pengurang</th>
                                      <th>Aksi</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                      <?php if (!empty($status_absensi)): ?>
                                            <?php $no = 1; foreach ($status_absensi as $status): ?>
                                              <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= htmlspecialchars($status->status_absensi) ?></td>
                                                <td><?= $status->mnt_penambah ?></td>
                                                <td><?= $status->mnt_pengurang ?></td>
                                                <td>
                                                  <!-- Tombol Edit dan Hapus (bisa dihubungkan dengan modal atau form aksi) -->
                                                  <button class="btn btn-sm btn-success" onclick="editStatus(<?= $status->id ?>)">Edit</button>
                                                  <button class="btn btn-sm btn-danger" onclick="hapusStatus(<?= $status->id ?>)">Hapus</button>
                                                </td>
                                              </tr>
                                            <?php endforeach; ?>
                                          <?php else: ?>
                                            <tr>
                                              <td colspan="5" class="text-center">Belum ada data status absen.</td>
                                            </tr>
                                          <?php endif; ?>
                                  </tbody>
                                </table>

                        </div>
                      </div>
                    </div>

                    <!-- Modal -->
                    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <form id="statusForm" method="post" action="<?= base_url('admin/setting/insert_status_absensi') ?>">
                            <div class="modal-header">
                              <h5 class="modal-title" id="statusModalLabel">Tambah Status</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                              <div class="mb-3">
                                <label for="nama_status" class="form-label">Nama Status</label>
                                <input type="text" class="form-control" id="nama_status" name="nama_status" required>
                              </div>

                              <div class="mb-3">
                                <label for="menit_penambah" class="form-label">Menit Penambah</label>
                                <input type="number" class="form-control" id="menit_penambah" name="menit_penambah" required>
                              </div>

                              <div class="mb-3">
                                <label for="menit_pengurang" class="form-label">Menit Pengurang</label>
                                <input type="number" class="form-control" id="menit_pengurang" name="menit_pengurang" required>
                              </div>
                            </div>

                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>



                  </div>
                  </div> <!-- container -->
                </div> <!-- content -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>


        </div>
        <!-- END wrapper -->
        <?php $this->load->view('layout/section/theme-setting');?>


        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url();?>assets/new/js/ui/component.todo.js"></script>


        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>

        <!-- Datatable Init js -->
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.datatable-init.js"></script>


        <?php
    if($message !=''){
    ?>
    <script>$.NotificationApp.send("Berhasil","<?php echo $message;?>","top-right","rgba(0,0,0,0.2)","success")</script>

    <?php } ?>
    </body>
</html>
