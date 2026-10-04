<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
          .btn-shift{
            background-color: #aaf1ca;
            display: inline-block;
            width: 70px;
            border: none;
            padding: 5px;
            color: #0d503a;
            margin: 1px;
            transition: ease-in 0.2s;    
            font-size: 11px;      
          }
          .btn-shift:hover{
            background-color: #26a45d;
            color: #FFF;
          }

          .shift-off{
            color: #900;
            background-color: #ffdace;
          }

          .shift-off:hover{
            background-color: #cf4031;
          }

          .shift-loff{
            color: #b05906;
            background-color: #fbe6ca;
          }

          .shift-loff:hover{
            background-color: #d06b0b;
          }

          .btn-absen {
            display: inline-block;
            width: 80px;
            border: none;
            padding: 5px;
            color: #4c97b2;
            background-color: #d7f4ff;
            margin: 1px;
            font-size: 12px;
            transition: ease-in 0.2s;   
          }

    
          .btn-secondary:hover{
            background-color:#69cdfc;
            color: #FFF;
          }
        
       
          .btn-warning:hover{
            background-color:#f8a317;
            color: #FFF;
          }

          .badge-sm{
            font-size: 11px;
            padding: 3px 5px;
          }
          

          .check-absen-active{
            background-color:#1a7fa3;
            color: #FFF;
          }

          .form-periode{
            width: 20em;
            height: 13em;
            background: #FFF;
            position: absolute;
            top: 9em;
            left: 2em;
            border: 1px solid #DDD;
            border-radius: 3px;
            padding: 0;
            display: none;
          }

          .header-periode{
            background-color: #FFF;
            color: #666;
            height: 50px;
            display: block;
            width: 100%;
            padding: 5px;
          }



          .body-periode{
            background-color: #FFF;
           
            height: auto;
            display: block;
          }

          .btn-prev, .btn-next{
            width: 20%;
            display: inline-block;
            padding:6px 10px;
            border: none;
            font-size: 14px;
          }



          .tahun_periode{
            border: none;
            width: 57%;
            display: inline-block;
            padding:6px 10px;
            font-size: 14px;
            cursor:none;
            text-align: center;
          }

          .btn-bulan{
            display: inline-block;
            width: 25%;
            padding:8px 5px;
            border: none;
            background-color: #FFF;
            color: #666;
            border-radius: 3px;
          }

          .btn-bulan:hover{
            background-color: #2792e7;
            color: #FFF;
          }

          .bln-active{
            background-color: #2792e7;
            color: #FFF;
          }
          
          .periode, .pilih-pkm{
             background-color: #F8F8F8;
             color: #333;
             padding: 10px 15px;
             border:none;
             font-weight: bold;
          }

        .pilih-pkm{
             background-color: #F8F8F8;
             color: #333;
             padding: 12px 15px;
             border:none;
             font-weight: 500;
          }

                  
         thead tr th {
          position: sticky;
          top: 0;
        }

          tr>th:first-child,tr>td:first-child {
            position: sticky;
            left: 0;
          }



          

        
 </style>
</head>

<body>
  <!-- <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome to Modernize</h5>
        <h6 class="text-white fs-2 mb-0">Easy to costomize the Template!!!</h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div> -->
  <!-- Preloader -->

  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->
>

      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->
       <?php

            $jns_pegawai = $this->uri->segment(4);
            $message = $this->session->flashdata('message'); 

            // print_array($this->session->userdata);
            // exit;
            $periode_bulan = $this->session->userdata('periode_bulan'); 
            $periode_tahun = $this->session->userdata('periode_tahun'); 
            $id_pkm_sess   = $this->session->userdata('id_pkm');
            $id_pj_sess = $this->session->userdata('id_pj');
            $id_user_validator   = $this->session->userdata('id_pegawai');

            
            ?>

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
                            <a class="text-muted text-decoration-none" href="../main/index.html" >Home</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive">Absensi Pegawai</li>
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
                             
                             

                                <div class="clearfix"></div>
         
                              <div class="table-responsive mt-4" style="max-height:500px">
                                 
                                      
                                </div><!--table-responsive-->
                                    

                              </div>
                        </div>
                  </div>
            </div>

                  

            
            <div id="bs-example-modal-md" class="modal fade" tabindex="-1"
                        aria-labelledby="bs-example-modal-md" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable modal-lg">
                          <div class="modal-content">
                            <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="myModalLabel">
                                Detail Absensi Pegawai
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                            </div>
                            <div class="modal-body" id="modal-form">
                             
                               
                           
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn bg-danger-subtle text-danger font-medium waves-effect"
                                data-bs-dismiss="modal">
                                Close
                              </button>
                            </div>
                          </div>
                          <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                      </div>
                    </div>
                    <div>




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
    <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.min.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>theme.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>init.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>jquery.blockUI.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>block-ui.js"></script>
</body>


<script>
 

</script>
</html>