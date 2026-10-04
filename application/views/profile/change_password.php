<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
  .datepicker{
    z-index: 1999;
}
</style>
</head>

<body>
 

  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->


      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->

          <?php 



              $tgl_masuk = $pegawai[0]->tgl_masuk;
              $id_pegawai = $pegawai[0]->id_pegawai;
              $nama_pegawai  = $pegawai[0]->nama;
              $message = $this->session->flashdata('message'); 

              $message_status = $this->session->flashdata('message_status'); 


          ?>
     <div class="body-wrapper">
          <div class="container-fluid mw-100">
        <!--  Row 1 -->
                <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h4 class="fw-semibold mb-8">Account Setting</h4>
                               
                                </div>
                               
                        </div>
                </div>
            </div>

        <?php echo $message ;?>
         <div class="card">


            <div class="card-body">
  
            <div class="row">
              <div class="col-md-6">
                    <h5 class="card-title fw-semibold">Change Password</h5>
                          <p class="card-subtitle mb-4">To change your password please confirm here</p>
                          <form action="<?php echo base_url();?>profile/change_password_process" method="post">
                            <div class="mb-4">
                              <label for="exampleInputPassword1" class="form-label fw-semibold">Current Password</label>
                              <input type="password" name="curr_password" class="form-control" required id="exampleInputPassword1"
                              >
                            </div>
                            <div class="mb-4">
                              <label for="exampleInputPassword2" class="form-label fw-semibold">New Password</label>
                              <input type="password" class="form-control" name="new_password"  required id="exampleInputPassword2">
                            </div>
                            <div class="mb-4">
                              <label for="exampleInputPassword3" class="form-label fw-semibold">Confirm Password</label>
                              <input type="password" class="form-control" name="confirm_password"  required id="exampleInputPassword3">
                            </div>

                            <div class="">
                            <button type="submit" class="btn btn-primary float-end mt-4">Simpan</button>

                            </div>
                          </form>
              </div>
            </div>
                   
                 
            </div>


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

    <script src="<?php echo NEW_JS_PATH;?>toastr-init.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>bootstrap-datepicker.js"></script>


</body>


<script>
   

   var status_message = '<?php echo $message_status;?>';
    var message = '<?php echo $message;?>';


    if (status_message==200) {
        toastr.success(message, "<strong>Success!! </strong>");
    }else if(status_message==250){
       toastr.error(message, "<strong>Error!! </strong>");
    }

  </script>

</html>