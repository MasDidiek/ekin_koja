<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
<!-- DataTables CSS -->


                    <!-- Datatables css -->
    <link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />


    
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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>setting/hari_kerja">Data Absensi</a></li>
                                            <li class="breadcrumb-item active">Rekap Absensi</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Template Shift Kerja Pegawai</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


            
                  <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                        
                            <div class="card-body p-4">
                                <?php
                                    $id_template = $template->id ;
                                    $nama_template = $template->nama_template ;
                                    $bulan = $template->bulan ;
                                    $tahun = $template->tahun ;

                                ?>
                                                                     
                                         <h3>Detail Template:  <?= $nama_template ?></h3>

                                           <h5>Periode : <?= getNamaBulan($bulan).' - '.$tahun ?></h5>
                                           

                                            <form method="post" action="<?= base_url('admin/template_shift/update_shift') ?>">
                                            
                                                <button type="submit" class="btn btn-success float-end">Update Shift</button>

                                                <a href="<?= base_url('admin/template_shift/generate/'.$id_template) ?>" class="btn btn-light me-2 float-end">Generate Shift</a>
                                             <div class="clearfix"></div>


                                                <table class="table  table-bordered table-sm mt-2" >
                                                    <tr>
                                                        <th>Hari</th>
                                                        <th>Tanggal</th>
                                                        <th>Shift</th>
                                                        <th>Change Shift</th>
                                                    </tr>

                                                    <?php foreach($detail as $d): ?>
                                                    <tr>
                                                        <td><?= format_hari($d->tanggal) ?></td>
                                                        <td><?= format_semi($d->tanggal) ?></td>
                                                        <td> <?= $d->nama_shift ?></td>
                                                        <td>
                                                            <input type="hidden" name="detail_id[]" value="<?= $d->id ?>">
                                                            <select name="shift_id[]" class="form-control" style="max-width: 250px;" required>
                                                                <option value="">-- Pilih Shift --</option>
                                                                <?php foreach($shift as $s): ?>
                                                                     <option value="<?= $s->id ?>" 
                                                                        <?= ($s->id == $d->shift_id) ? 'selected' : '' ?>>
                                                                        <?= $s->kode_shift ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </td>
                                                    </tr>
                                                    <?php endforeach; ?>
                                                </table>
                                            </form>
                                
                                </div>
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
        <!-- DataTables JS -->
    
    </body>
</html>
