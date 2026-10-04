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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/my_dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>setting/hari_kerja">Pengaturan</a></li>
                                            <li class="breadcrumb-item active">Hari Libur</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Hari Libur</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


            <?php
                    $message = $this->session->flashdata('message');
                   
                    $list_bulan = array_bulan();
                    $MonthNow = date('m');
                ?>

            
                  <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                        <div class="card-body p-4">
                      
                          <?php   echo $message;?>


                                 <button type="button" class="btn btn-primary mb-4 float-end " data-bs-toggle="modal" data-bs-target="#modal-report">
                                      <i class="uil-plus"></i>   Add <?php echo $title;?> 
                                </button>

                                <div class="clearfix"></div>

                                 <table class="table table-bordered">

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
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content" id="modal-form">
                                            <form action="<?php echo base_url();?>admin/setting/insert_hari_libur" method="post">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Hari Libur  </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>


                                            <div class="modal-body">
                                                                            
                                                    <div class="col-lg-5">
                                                        <div class="mb-3">
                                                            <label class="form-label">Tanggal</label>
                                                            <input type="date" class="form-control" name="tgl" value="<?php echo date('Y-m-d');?>" required >
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="mb-3">
                                                            <label class="form-label">Keterangan</label>
                                                            <input type="text" class="form-control" name="keterangan"  required >
                                                        </div>
                                                    </div>
                                            </div>


                                                <div class="modal-footer">
                                                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal"> Cancel  </a>
                                                    <button type="submit" class="btn btn-primary ms-auto">  Save  </button>
                                                </div>

                                           </form>

                                        </div>
                                    </div>
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

     
        <script>
        $(document).ready(function() {
            $('.edit-hari-kerja').on('click', function() {
                var id = $(this).val();
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/setting/get_hari_kerja/' + id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                       var item = data[0];  // Ambil objek pertama dalam array

                        $('#modal-report .modal-title').text('Edit Hari Kerja');
                        $('#modal-report form').attr('action', '<?php echo base_url(); ?>admin/setting/update_hari_kerja/' + item.id);
                        $('#modal-report select[name="bulan"]').val(item.bulan);
                        $('#modal-report input[name="tahun"]').val(item.tahun);
                        $('#modal-report input[name="jumlah_hari"]').val(item.jumlah_hari);
                    },
                    error: function() {
                        alert('Gagal mengambil data.');
                    }
                });
            });

            // Reset modal on close or add
            $('#modal-report').on('hidden.bs.modal', function () {
                $('#modal-report .modal-title').text('Add Hari Kerja');
                $('#modal-report form').attr('action', '<?php echo base_url(); ?>admin/setting/insert_hari_kerja');
                $('#modal-report form')[0].reset();
                $('#modal-report select[name="bulan"]').val('<?php echo $MonthNow; ?>');
                $('#modal-report input[name="tahun"]').val('<?php echo date('Y');?>');
                $('#modal-report input[name="jumlah_hari"]').val('20');
            });
        });
        </script>


    </body>
</html>
