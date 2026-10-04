<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>

<style>
   table{
                width: 100% ;
            }

            .table-absensi th{
                border: 1px solid #EEE;
                padding: 10px;
                text-align: center;
                font-size: 15px;
            }
            .table-absensi td{
                border: 1px solid #EEE;
                padding: 8px;
                text-align: center;
                font-size: 14px;
                color:#555

            }

</style>
</head>

<body>
 <!--  Body Wrapper -->
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


      <div class="body-wrapper">
         <div class="container-fluid">
             <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8">Absensi Pegawai</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="<?php echo base_url();?>admin/dashboard/index" >Home</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive">Absensi  Pegawai</li>
                        
                        </ol>
                      </nav>
                    </div>
                  
                  </div>

                  
                </div>
              </div>


              
              <div class="row">
                  <div class="col-lg-6 d-flex align-items-stretch">
                      <div class="card w-100">
                            <div class="card-body p-4">
                             
                                    <h3>Import Data Absensi</h3>


                                        
                                    <form action="<?php echo base_url();?>admin/presensi/import_process" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                            
                                            <div class="mb-3">
                                                <label for="message-text" class="control-label">Data import:</label>
                                                <textarea class="form-control" name="data_import" rows="10"  required id="message-text1"></textarea>
                                            </div>
                                            
                                 
                                        
                                        <button type="submit" class="btn btn-success">
                                            Save
                                        </button>
                                    </div>
                              
                                </form>
                            </div>
                        </div>
                    </div>
            </div>          
              
           
           
           
         </div>



                   
         </div><!--row-->

        
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
    <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.min.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>theme.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>init.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>jquery.blockUI.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>block-ui.js"></script>


  </body>
</html>