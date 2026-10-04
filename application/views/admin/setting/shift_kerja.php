<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

     <style>
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0;
      right: 0; bottom: 0;
      background-color: #db3535ff;
      transition: .4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 20px; width: 20px;
      left: 4px; bottom: 2px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: #4caf50;
    }

    input:checked + .slider:before {
      transform: translateX(24px);
    }

    /* Optional: label text */
    .switch-label {
      font-family: sans-serif;
      margin-left: 10px;
      vertical-align: middle;
    }
  </style>

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

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/my_dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>setting/hari_kerja">Pengaturan</a></li>
                                            <li class="breadcrumb-item active">Shift Kerja</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Shift Kerja</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                    <?php
                            $flashdata = $this->session->flashdata('message');
                            $function = $this->uri->segment(3);
                        ?>

            
                     <div class="row">
                            <div class="col-12 mb-2">
                                 <button type="button"  class="btn btn-info float-end"  data-bs-toggle="modal"  data-bs-target="#addShift">Add Shift</button>
                            </div>

                                <?php
                                $no = 0;
                                        for ($i=0; $i < count($shift_kerja) ; $i++) { 
                                            $id  = $shift_kerja[$i]->id;
                                            $nama_shift = $shift_kerja[$i]->nama_shift;
                                            $kode_shift = $shift_kerja[$i]->kode_shift;
                                            $jam_masuk = $shift_kerja[$i]->jam_masuk;
                                            $jam_pulang = $shift_kerja[$i]->jam_pulang;
                            
                                            $publish = $shift_kerja[$i]->publish;
                                            $urutan = $shift_kerja[$i]->urutan;

                                            if($publish==1){
                                                $check ='checked';
                                            }else{
                                                $check ='';
                                            }

                                            ?>
                                     <div class="col-lg-3 d-flex align-items-stretch">
                                            <div class="card w-100">
                                                <div class="card-body p-2">
                                                    <div class="row">
                                                        <div class="col-8">
                                                             <h4> <?php echo $kode_shift;?></h4>
                                                                <h6> <?php echo $nama_shift;?></h6>

                                                                <?= $jam_masuk;?> -   <?= $jam_pulang;?>
                                                        </div>
                                                         <div class="col-4 text-end">
                                                                <span class="switch-label">Publish</span>
                                                                <label class="switch">
                                                                    <input type="checkbox" name="publish" class="check_publish" value="<?= $id;?>" <?=$check;?>>
                                                                    <span class="slider"></span>
                                                                </label>
                                                                
                                                                    
                                                             <button type="button" value="<?= $id;?>"  class="btn text-success border-none bg-white btn-edit-shift"  data-bs-toggle="modal"  data-bs-target="#tambahpegawai">Edit</button>
                                                             <a href="<?php echo base_url();?>admin/setting/delete_shift/<?= $id;?>" onclick="return confirm('Apakah anda ingin menghapus data shift ini?');" class="text-danger">Delete</a>
                                                        </div>
                                                    </div>

                                                   
                                                   
                                                </div>
                                                        

                                            </div>
                                        </div>


                                <?php  } ?>
                      

                                <div class="modal fade" id="addShift" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="formEditShift" method="post" action="<?= base_url('admin/setting/insert_shift_kerja'); ?>">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Add Shift Kerja </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                  <div class="modal-body">
                                                 
                    
                                                            <div class="row">
                                                                 <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Kode Shift</label>
                                                                            <input type="text" name="kode_shift"  class="form-control" required>
                                                                        </div>
                                                                 </div>
                                                                 <div class="col-8">
                                                                    <div class="form-group">
                                                                        <label>Nama Shift</label>
                                                                        <input type="text" name="nama_shift"  class="form-control" required>
                                                                    </div>
                                                                 </div>
                                                            </div>

                                                        
                                                              <div class="row mt-2">
                                                                 <div class="col-6">
                                                                         <div class="form-group">
                                                                            <label>Jam Masuk</label>
                                                                            <input type="time" name="jam_masuk" class="form-control" required>
                                                                        </div>
                                                                 </div>
                                                                 <div class="col-6">
                                                                   
                                                                        <div class="form-group">
                                                                            <label>Jam Pulang</label>
                                                                            <input type="time" name="jam_pulang"  class="form-control" required>
                                                                        </div>
                                                                 </div>
                                                            </div>

                                                              <div class="form-group mt-3">
                                                                <label>Pegawai</label>
                                                               
                                                                <select name="jns_pegawai" id="jns_pegawai" class="form-control">
                                                                    <option value="non_pns">Non PNS</option>
                                                                    <option value="pjlp">PJLP</option>
                                                                </select>
                                                            </div>
                                                          
                                                           
                                                        </div>
                                                 

                                                      <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->



                            <div class="modal fade" id="tambahpegawai" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="formEditShift" method="post" action="<?= base_url('admin/setting/update_shift_kerja'); ?>">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Edit Shift Kerja </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                  <div class="modal-body">
                                                 
                                                         <input type="hidden" name="id_shift" id="id_shift">

                                                            <div class="row">
                                                                 <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Kode Shift</label>
                                                                            <input type="text" name="kode_shift" id="kode_shift" class="form-control" required>
                                                                        </div>
                                                                 </div>
                                                                 <div class="col-8">
                                                                    <div class="form-group">
                                                                        <label>Nama Shift</label>
                                                                        <input type="text" name="nama_shift" id="nama_shift" class="form-control" required>
                                                                    </div>
                                                                 </div>
                                                            </div>

                                                        
                                                              <div class="row mt-2">
                                                                 <div class="col-6">
                                                                         <div class="form-group">
                                                                            <label>Jam Masuk</label>
                                                                            <input type="time" name="jam_masuk" id="jam_masuk" class="form-control" required>
                                                                        </div>
                                                                 </div>
                                                                 <div class="col-6">
                                                                   
                                                                        <div class="form-group">
                                                                            <label>Jam Pulang</label>
                                                                            <input type="time" name="jam_pulang" id="jam_pulang" class="form-control" required>
                                                                        </div>
                                                                 </div>
                                                            </div>

                                                              <div class="form-group mt-3">
                                                                <label>Pegawai</label>
                                                                <input type="text" name="user_pengguna" id="user_pengguna" class="form-control" required>
                                                            </div>


                                                         

                                                          
                                                           
                                                        </div>
                                                 

                                                      <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    </div>

                                                </form>


                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->




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
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



            <script>
            $(document).ready(function() {
                $('.check_publish').on('change', function() {
                    var id = $(this).val();
                    var status = $(this).is(':checked') ? 1 : 0;

                    $.ajax({
                        url: '<?= base_url("admin/setting/ajaxChangePublish"); ?>', // Ganti dengan nama controller kamu
                        type: 'POST',
                        data: { id: id, publish: status },
                        success: function(response) {
                            var res = JSON.parse(response);
                            if(res.status === 'success') {
                                toastr.success('Status publish berhasil diperbarui.');
                            } else {
                                toastr.error('Gagal memperbarui status.');
                            }
                        },
                        error: function(xhr, status, error) {
                             toastr.error('Terjadi kesalahan AJAX.');
                            console.error('Error updating publish:', error);
                        }
                    });
                });



                $('.btn-edit-shift').on('click', function() {
                    var id = $(this).val();

                    $.ajax({
                    url: '<?= base_url("admin/setting/get_shift_by_id"); ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(data) {
                        $('#id_shift').val(data.id);
                        $('#kode_shift').val(data.kode_shift);
                        $('#nama_shift').val(data.nama_shift);
                        $('#jam_masuk').val(data.jam_masuk);
                        $('#jam_pulang').val(data.jam_pulang);
                        $('#user_pengguna').val(data.status_kerja);
                    },
                    error: function(xhr, status, error) {
                        toastr.error('Gagal mengambil data shift.');
                        console.error(error);
                    }
                    });
                });
                
                
            });


            </script>

            <?php
             
                if ($flashdata):
                ?>
                <script>
                $(document).ready(function() {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "3000"
                    };

                    toastr["<?= $flashdata['type']; ?>"]("<?= $flashdata['text']; ?>");
                });

                </script>
                <?php endif; ?>


                                            
    </body>
</html>
