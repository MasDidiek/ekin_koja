<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
    .table th,  td{
      border-right:1px solid #EEE;
    }
    .form-table{
      border:1px solid #DDD;
      padding:5px;
      text-align:center
    }

    .table-shift th, td{
      border:1px solid #DDD;
      padding:5px;
      text-align:center
    }
</style>
</head>

<body>
 

  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->


      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->

         <?php 
                
                $function = $this->uri->segment(3);
                $message = $this->session->flashdata('message'); 
             


                
            ?>

                   
      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8"> Tarik Data Absensi</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html" >Home / Setting</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive"> Tarik Data Absensi </li>
                        </ol>
                      </nav>
                    </div>
                    <div class="col-3">
                      <div class="text-center mb-n5">
                
                      </div>
                    </div>
                  </div>

                  
                </div>
              </div>
            
            <div class="row">
              <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">
                        <table class="table  table-bordered"  id="data-table">                                           
                            <thead>
                                <tr>
                                     <th class="w-1">No.</th>
                                    <th>Serial Number</th>
                                    <th>Lokasi Mesin</th>
                                    <th>IP Address</th>
                                    <th>Status</th>
                                    <th>Last Update</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                    for ($i=0; $i < count($mesin_absensi) ; $i++) { 
                                        $serial_number = $mesin_absensi[$i]->serial_number;
                                        $nama_mesin = $mesin_absensi[$i]->nama_mesin;
                                        $ip_address = $mesin_absensi[$i]->ip_address;
                                        $status = $mesin_absensi[$i]->status;
                                        $last_update = $mesin_absensi[$i]->last_update;
                                        $id_puskesmas = $mesin_absensi[$i]->id_puskesmas;
                                        

                                        if ($status==1) {
                                            $flag = '<a href="'.base_url().'admin/setting/refresh_mesin/'.$ip_address.'" class="badge text-success bg-success-subtle">
                                            Online  &nbsp; <i class="fas fa-refresh"></i>
                                            </a>';
                                        }else{
                                            $flag = '<a href="'.base_url().'admin/setting/refresh_mesin/'.$ip_address.'" class="badge text-danger bg-danger-subtle">
                                            Offline  &nbsp;<i class="fas fa-refresh"></i>
                                        </a>';
                                        }


                                        echo ' <tr>
                                                    <td class="text-center">'.($i+1).'</td>                                                                
                                                    <td class="text-center">'. $serial_number.'</td>
                                                    <td class="text-start">
                                                    <a href="'.base_url().'dashboard/list_user/'.$id_puskesmas.'/'.$serial_number.'" class="text-info">'. $nama_mesin.'</a></td>
                                                    <td class="text-center">'. $ip_address.' </td>
                                                    <td class="text-center">'.$flag.'</td>
                                                    <td class="text-center">'.$last_update.'</td>
                                                
                                    
                                                </tr>
                                                ';
                                    }
                            ?>
                            </tbody>
                        </table>
                

                  </div>
                </div>
              </div>
            </div>


      <script>
          function handleColorTheme(e) {
            $("html").attr("data-color-theme", e);
            $(e).prop("checked", !0);
          }
        </script>

        <?php $this->load->view('layout/section/theme-setting.php');?>

        <?php $this->load->view('master/request-cuti.php');?>

  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->

    <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>
    <script src="../assets/js/app.init.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.min.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>theme.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>init.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>jquery.blockUI.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>block-ui.js"></script>


    <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>bootstrap-datepicker.js"></script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

</body>




<script>
 
 $('#data-table').dataTable( {
                lengthMenu: [
                    [  20, -1 ],
                    ['20', '50', '100', 'Show all' ]
                ]
            } );


           
          
		

</script>
</html>