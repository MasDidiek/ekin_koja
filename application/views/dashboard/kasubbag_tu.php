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
     
      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->


      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8">Dashboard</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html" >

                            <?php echo date('D, d F Y');?>
                            </a>
                          </li>
                         
                          
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
              <?php 
                
                $nama_user =  $this->session->userdata('nama');
                $nip_user =  $this->session->userdata('nip');
                $id_pegawai =  $this->session->userdata('id_pegawai');
                $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);
                $message = $this->session->flashdata('message'); 
  


               # print_array($this->session->userdata);

                if($photo==''){
                  $photo = 'avatar.png';
                }

                $jmlhPengajuanCuti = $nuPengajuanCuti;
                $jmlhPengajuanDL= count($pengajuanDL);
                $jmlhPengajuanCutiAdmen = count($cutiPegawaiAdmen);

                #print_array($cutiPegawaiAdmen);
                
            ?>

          <div class="row">

           <div class="col-md-12">
            <?php echo $message;?>

            <div class="d-flex align-items-center mb-7">
                <div class="rounded-circle overflow-hidden me-6">
                    <img
                    src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photo ;?>"
                    alt=""
                    width="40"
                    height="40"
                    />
                </div>
                <h5 class="fw-semibold mb-0 fs-5">
                    <span class="text-muted">Welcome back</span>
                    <?php echo $nama_user;?>!
                </h5>
                </div>


           </div>



           <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-row align-items-center">
                        <div class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-success">
                          <i class="ti ti-calendar fs-6"></i>
                        </div>
                        <div class="ms-3 align-self-center">
                          <h3 class="mb-0 fs-6"><?php echo $jmlhPengajuanCuti;?> <small>Pengajuan Cuti</small>  </h3>
                          <span class="text-muted">Menunggu Persetujuan Cuti </span>
                        </div>
                      </div>
                      <br>
                      <a href="<?php echo base_url();?>admin/cuti/pengajuan_cuti_pegawai/pending" 
                      class="btn btn-sm btn-success float-end mt-2">Lihat</a>
                    </div>

                   
                  </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-row align-items-center">
                        <div class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-info">
                          <i class="ti ti-files fs-6"></i>
                        </div>
                        <div class="ms-3 align-self-center">
                          <h3 class="mb-0 fs-6"><?php echo $jmlhPengajuanDL;?></h3>
                          <span class="text-muted">Pengajuan Dinas Luar</span>
                        </div>
                      </div>
                      <br>
                      <a href="<?php echo base_url();?>dashboard/pengajuan_dinas_luar_pegawai/Pending" class="btn btn-sm btn-info float-end mt-2">Lihat</a>
                    </div>
                   
                  </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-4 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-row align-items-center">
                        <div class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-warning">
                          <i class="ti ti-heart fs-6"></i>
                        </div>
                        <div class="ms-3 align-self-center">
                          <h3 class="mb-0 fs-6">0</h3>
                          <span class="text-muted">Pengajuan izin / Sakit</span>
                        </div>
                      </div>
                      <br>
                      <a href="<?php echo base_url();?>admin/absensi/pengajuan_izin_sakit_pegawai" class="btn btn-sm btn-warning float-end mt-2">Lihat</a>
                    </div>

                

                  </div>
                </div>
                <div class="col-lg-4 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-row align-items-center">
                        <div class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-info">
                          <i class="ti ti-files fs-6"></i>
                        </div>
                        <div class="ms-3 align-self-center">
                          <h3 class="mb-0 fs-6"><?php echo $jmlhPengajuanCutiAdmen;?></h3>
                          <span class="text-muted">Pengajuan Admen</span>
                        </div>
                      </div>
                      <br>
                      <a href="<?php echo base_url();?>admin/pengajuan_cuti/pengajuan_cuti_admen" class="btn btn-sm btn-info float-end mt-2">Lihat</a>
                    </div>
                   
                  </div>
                </div>
                <!-- Column -->
              
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
</body>


<script>
      $("#button_upload").click(function(){
            $(".form-upload").removeClass('d-none');


        });


      $(".approve").click(function() {
          var id_cuti = $(this).val();
          $("#id_cuti_approve").val(id_cuti);

      });




        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        //1700931600000
        //1703264400000

        var checkin = $('#dpd1').datepicker({
            
            onRender: function(date) {

                //alert(date.valueOf());
                //return date.valueOf() < now.valueOf() ? 'disabled' : '';
                return '';
            }
        }).on('changeDate', function(ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }

       
        checkin.hide();
        $('#dpd2')[0].focus();

        }).data('datepicker');
            var checkout = $('#dpd2').datepicker({
            onRender: function(date) {
           // return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
           return '';
        }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');


</script>
</html>