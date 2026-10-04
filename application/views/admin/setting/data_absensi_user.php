<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
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
             

                $sortAbsensi = array();

                  //  print_array($absensi);
                  for ($b = 0; $b < count($absensi); $b++) {
                    $DateTime = $absensi[$b]['DateTime'];
                    $pin      = $absensi[$b]['pin'];
                    $Status   = $absensi[$b]['Status'];


                    $sortAbsensi[] =array(
                        'tanggal' => $DateTime,
                        'pin' => $pin,
                        'status' => $Status
                    );


                  }


                  rsort($sortAbsensi);
                 

                
            ?>

                   
      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8"> <?php echo $title;?> </h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html" >Home / Setting</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive"> <?php echo $title;?> </li>
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
                
                  <?php    echo $message;?>
                   
                          <table class="table table-center text-nowrap table-bordered" style="width:300px">
                                    <thead>
                                            <tr>
                                            <th>Tanggal</th>
                                                <th>Jam</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 

                                                //  print_array($absensi);
                                                for ($b = 0; $b < count($sortAbsensi); $b++) {
                                                    $DateTime = $sortAbsensi[$b]['tanggal'];
                                                    $pin      = $sortAbsensi[$b]['pin'];
                                                    $Status   = $sortAbsensi[$b]['status'];

                                                    if ($Status == 0) {
                                                        $flag = '<span class="badge bg-success-subtle text-success">MSK</span>';
                                                        $change_to = 1;
                                                    } else {
                                                        $flag = '<span class="badge bg-danger-subtle text-danger">KEL</span>';
                                                        $change_to = 0;
                                                    }




                                                    echo '
                                                                <tr>
                                                                    <td align="center">' . date('d-m-Y', strtotime($DateTime)) . '</td>
                                                                    <td align="center">' . date('H:i:s', strtotime($DateTime)) . '</td>
                                                                    <td align="center">' . $flag . '</td>
                                                                    
                                                                
                                                                </tr> ';

                                                 
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
 
</script>
</html>