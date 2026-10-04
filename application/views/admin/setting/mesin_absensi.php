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
                                            <li class="breadcrumb-item active">Mesin Absensi</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Mesin Absensi</h4>
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

                                  <table class="table  table-bordered"  id="data-table">
      
                                          <thead>
                                              <tr>
                                                  <th>No</th>
                                                  <th>Serial Number</th>
                                                  <th>Nama</th>
                                                  <th>IP Address</th>
                                                  <th>Status</th>
                                                  <th>Action</th>
                                              </tr>
                                          </thead>
                                                                          
                                                                      
      
                                          <tbody>
      
                                          
                                          
                                              <?php
                                                      for ($i=0; $i < count($mesin_absensi) ; $i++) { 
                                                          $serial_number = $mesin_absensi[$i]->serial_number;
                                                          $nama_mesin = $mesin_absensi[$i]->nama_mesin;
                                                          $ip_address = $mesin_absensi[$i]->ip_address;
                                                          $status = $mesin_absensi[$i]->status;
                                                        

                                                          if ($status==1) {
                                                            $flag = '<a href="'.base_url().'admin/setting/refresh_mesin/'.$ip_address.'" class="badge bg-success">
                                                             Online  &nbsp; <i class="fas fa-refresh"></i>
                                                            </a>';
                                                          }else{
                                                            $flag = '<a href="'.base_url().'admin/setting/refresh_mesin/'.$ip_address.'" class="badge bg-danger">
                                                            Offline  &nbsp;<i class="fas fa-refresh"></i>
                                                           </a>';
                                                          }
      
      
                                                          echo ' <tr>
                                                                    <td class="text-center">'.($i+1).'</td>                                                                
                                                                    <td class="text-center">'. $serial_number.'</td>
                                                                    <td class="text-left">
                                                                    <a href="'.base_url().'admin/setting/list_user/'.$serial_number.'">'. $nama_mesin.'</a></td>
                                                                    <td class="text-center">'. $ip_address.' </td>
                                                                    <td class="text-center">'.$flag.'</td>
                                                                  
                                                                    <td class="text-center">
                                                                    
                                                                                
                                                                             <a href="'.base_url().'admin/setting/tarik_data/'.$serial_number.'"  class="btn btn-sm btn-light" >
                                                                               <i class="uil-download"></i>&nbsp;  Tarik Data
                                                                            </a>

                                                                          <button type="button" class="btn btn-sm btn-success edit-mesin-absensi" value="'.$serial_number.'" data-bs-toggle="modal" data-bs-target="#modal-report">
                                                                           <i class="uil-edit"></i></button>
      
                                                                          <a href="'.base_url().'admin/setting/delete_mesin_absensi/'.$serial_number.'"  class="btn btn-sm btn-danger"onClick="return confirm(\'Hapus baris ini?\');" >
                                                                               <i class="uil-trash"></i>
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
                                            <form action="<?php echo base_url();?>admin/setting/insert_mesin_absensi" method="post">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Add Mesin Absensi </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>


                                            <div class="modal-body">
                                                                                                
                                                    <div class="row">
                                                            <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Serial Number</label>
                                                                        <input type="text" class="form-control" name="sn" required >
                                                                            
                                                                    </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">IP Address</label>
                                                                        <input type="text" class="form-control" name="ip_address"  required >
                                                                    </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Mesin</label>
                                                                        <input type="text" class="form-control" name="nama_mesin" required >
                                                                    </div>
                                                            </div>

                                                            <div class="col-lg-6 mb-3">
                                                                  <label class="form-label">Puskesmas</label>
                                                                        <select name="id_puskesmas" class="form-control" >';

                                                                    <?php  
                                                                            foreach ($list_puskesmas as $puskesmas){
                                                                                                                                
                                                                            $id_pkm = $puskesmas->id_puskesmas;
                                                                            $nama_puskesmas = $puskesmas->nama;

                                                                        
                                                                            echo ' <option value="'. $id_pkm .'">'.$nama_puskesmas .'</option>';
                                                                            

                                                                        }




                                                                            ?>
                                                                    </select>
                                                                
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
            $('.edit-mesin-absensi').on('click', function() {
                var sn = $(this).val();
                $.ajax({
                    url: '<?php echo base_url(); ?>admin/setting/getDetMesinAbsensi/' + sn,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                       var item = data[0];  // Ambil objek pertama dalam array

                        $('#modal-report .modal-title').text('Edit Mesin Absensi');
                        $('#modal-report form').attr('action', '<?php echo base_url(); ?>admin/setting/update_mesin_absensi/' + sn);
                        $('#modal-report select[name="id_puskesmas"]').val(item.id_puskesmas);
                        $('#modal-report input[name="ip_address"]').val(item.ip_address);
                        $('#modal-report input[name="sn"]').val(item.serial_number);
                        $('#modal-report input[name="nama_mesin"]').val(item.nama_mesin);
                    },
                    error: function() {
                        alert('Gagal mengambil data.');
                    }
                });
            });

            // Reset modal on close or add
            $('#modal-report').on('hidden.bs.modal', function () {
                $('#modal-report .modal-title').text('Add Mesin Absensi');
                $('#modal-report form').attr('action', '<?php echo base_url(); ?>admin/setting/insert_mesin_absensi');
                $('#modal-report form')[0].reset();
                $('#modal-report select[name="id_puskesmas"]').val("");
                $('#modal-report input[name="ip_address"]').val("");
                $('#modal-report input[name="sn"]').val("");
                $('#modal-report input[name="nama_mesin"]').val("");
            });
        });
        </script>


    </body>
</html>
