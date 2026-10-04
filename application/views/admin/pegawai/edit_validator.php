<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
<!-- DataTables CSS -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    
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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/my_dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>setting/hari_kerja">Pegawai</a></li>
                                            <li class="breadcrumb-item active">Validator</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Validator</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php
                                $message = $this->session->flashdata('message');
                            
                                $id_puskesmas = $validator->id_puskesmas;
                        // print_array($validator)
                            ?>

            
                  <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                       
                          <div class="card-body">
                               <h5>Edit Validator</h5>
                                 <div class="clearfix"></div>
                                 <br>

                                 <?= $message; ?>
                                  <form id="formEditShift" method="post" action="<?= base_url('admin/pegawai/update_validator/'.$validator->id_validator ); ?>">
                                        <div class="row">
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Nama Validator</label>
                                                    <input type="text" id="nama" name="nama" 
                                                        value="<?= $validator->nama ?>" 
                                                        class="form-control" autocomplete="off" required>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>NIP</label>
                                                    <input type="text" name="nip"  id="nip" value="<?= $validator->nip ?>" class="form-control" required>
                                                    <input type="text" name="id_pegawai"  id="id_pegawai" value="<?= $validator->id_pegawai ?>" class="form-control" required>
                                                </div>
                                            </div>
                                              <div class="col-3">
                                                <div class="form-group">
                                                    <label>NRK</label>
                                                    <input type="text" name="nrk" id="nrk" value="<?= $validator->nrk ?>" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="form-group">
                                                    <label>Jabatan</label>
                                                    <input type="text" name="jabatan" id="jabatan"  value="<?= $validator->jabatan ?>"class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                
                                        <div class="row mt-2">
                                            <div class="col-6">
                                                    <div class="form-group">
                                                    <label>Unit Kerja</label>
                                                   <select name="id_puskesmas" id="id_puskesmas" class="form-control">
                                                     <?php
                                                        foreach ($list_puskesmas as $pkm):?>


                                                            <option value="<?= $pkm->id_puskesmas;?>" <?= $pkm->id_puskesmas==$validator->id_puskesmas? 'selected':'';  ?> ><?= $pkm->nama; ?></option>


                                                        <?php endforeach; ?>

                                                   </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                            
                                                <div class="form-group">
                                                    <label>Keterangan</label>
                                                    <input type="text" name="keterangan" value="<?= $validator->ket ?>"  class="form-control" required>
                                                </div>
                                            </div>
                                    </div>

                                    <div class="form-group mt-3 text-end">
                                         <a href="<?= base_url().'admin/pegawai/validator';?>" class="btn btn-light">Kembali</a>
                                         <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>

                                  </form>

                                 
                            </div><!--card body-->
                        </div>

                               
                       

                        </div>
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

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
       

        <script>
            $(document).ready(function(){

                $("#nama").autocomplete({
                    source: function(request, response) {
                        $.ajax({
                            url: "<?= base_url('admin/pegawai/search_pegawai') ?>",
                            type: "POST",
                            dataType: "json",
                            data: {
                                keyword: request.term
                            },
                            success: function(data) {
                                response(data);
                            }
                        });
                    },
                    select: function(event, ui) {
                        $("#nama").val(ui.item.nama);
                        $("#nip").val(ui.item.nip);
                        $("#nrk").val(ui.item.nrk);
                        $("#id_pegawai").val(ui.item.id_pegawai);
                        $("#jabatan").val(ui.item.jabatan);
                        return false;
                    }
                });

            });
            </script>

    
     

    </body>
</html>
