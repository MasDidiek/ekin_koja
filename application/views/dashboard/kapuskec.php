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


      <?php $this->load->view('layout/section/sidebar');?>

<!-- 
            <div  class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
              <div class="hstack gap-3">
                <div class="john-img">
                  <img
                    src="../assets/images/profile/user-1.jpg"
                    class="rounded-circle"
                    width="40"
                    height="40"
                    alt=""
                  />
                </div>
                <div class="john-title">
                  <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                  <span class="fs-2">Designer</span>
                </div>
                <button
                  class="border-0 bg-transparent text-primary ms-auto"
                  tabindex="0"
                  type="button"
                  aria-label="logout"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  data-bs-title="logout"
                >
                  <i class="ti ti-power fs-6"></i>
                </button>
              </div>
            </div>

            <!-- ---------------------------------- -->
            <!-- Start Vertical Layout Sidebar -->
            <!-- ---------------------------------- -
            </div> -->
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

                $jmlhPengajuanCuti = count($cutiPegawai);
                $jmlhPengajuanDL= count($pengajuanDL);
                
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
                <div class="col-lg-3 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-row align-items-center">
                        <div class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-success">
                          <i class="ti ti-calendar fs-6"></i>
                        </div>
                        <div class="ms-3 align-self-center">
                          <h3 class="mb-0 fs-6"><?php echo $jmlhPengajuanCuti;?></h3>
                          <span class="text-muted">Pengajuan Cuti </span>
                        </div>
                      </div>
                      <br>
                      <a href="<?php echo base_url();?>admin/pengajuan_cuti/pengajuan_cuti_pegawai" 
                      class="btn btn-sm btn-success float-end mt-2">Lihat</a>
                    </div>

                   
                  </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-3 col-md-6">
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
                      <a href="<?php echo base_url();?>admin/absensi/pengajuan_dinas_luar_pegawai" class="btn btn-sm btn-info float-end mt-2">Lihat</a>
                    </div>
                   
                  </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-3 col-md-6">
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
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-3 col-md-6">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex flex-row align-items-center">
                        <div class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-primary">
                          <i class="ti ti-pencil fs-6"></i>
                        </div>
                        <div class="ms-3 align-self-center">
                          <h3 class="mb-0 fs-6"> Pengajuan Cuti</h3>
                          <span class="text-muted">Buat Pengajuan Cuti saya</span>
                        </div>
                      </div>
                      <br>
                      <button type="button" class="btn btn-primary btn-sm float-end mt-2"   data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo">
                        Buat Pengajuan Cuti
                      </button>
                    </div>
                  </div>
                </div>
                <!-- Column -->
              </div>



                
         
        </div>
      </div>


      
<?php
    $id_pegawai = $this->session->userdata('id_pegawai');
    $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 1);
    $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
    $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);
     $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');
     $arraySisaCuti = array($hakCutiThnLalu, $hakCutiThnIni, $hakCutiBersama );
?>


         <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
             <div class="modal-dialog" role="document">
                 <form method="post" action="<?php echo base_url();?>cuti/check_date" enctype="multipart/form-data">
                      <div class="modal-content">
                          <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="exampleModalLabel1">
                                  Pengajuan Cuti
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                        
                              <div class="row">
                                  <div class="col-md-6 col-sm-6 col-6 mt-3">
                                      <label for="">Tanggal Mulai: </label>
                                      <input type="text" required name="date_from" autocomplete="off" class="form-control" value="<?php echo date('d-m-Y');?>" id="dpd1" ></div>
                                  <div class="col-md-6 col-sm-6 col-6 mt-3">
                                      <label for=""> Tanggal Akhir: </label> 
                                      <input type="text" required  name="date_to"  autocomplete="off"   class="form-control"value="<?php echo date('d-m-Y');?>" id="dpd2" ></div>
                                  <div class="col-md-6 mt-3">
                                    Jenis Cuti: 
                                      <select name="jns_cuti" id="jns_cuti"  class="form-control">
                                          <option value="1">Cuti Tahunan</option>
                                          <option value="2">Cuti Bersalin</option>
                                          <option value="3">Cuti Alasan Penting</option>
                                          <option value="4">Cuti Sakit</option>
                                          <option value="5">Cuti Besar</option>

                                      </select>

                                  </div>
                                  <div class="col-md-6 mt-3">
                                  Hak  Cuti yang digunakan: 
                                      <select name="jns_hak_cuti" id="jns_cuti"  class="form-control">
                                      <?php
                                          for ($i=0; $i < count($arrayHakCuti) ; $i++) { 
                                              $idjnsHak = $i+1;
                                              $nama_hak_cuti = $arrayHakCuti[$i];

                                              if($jns_hak_cuti==$idjnsHak){
                                                  echo '<option value="'.$idjnsHak.'" selected>'.$nama_hak_cuti.' ('.$arraySisaCuti[$i].')</option>';
                                              }else{
                                                  echo '<option value="'.$idjnsHak.'">'.$nama_hak_cuti.' ('.$arraySisaCuti[$i].')</option>';
                                              }
                                              
                                          }
                                      ?>

                                        
                                      </select>
                                  </div>
                              </div>
                           
                       
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn bg-danger-subtle text-danger font-medium"
                                  data-bs-dismiss="modal">
                                  Close
                              </button>
                              <button type="submit" class="btn btn-primary">
                                Selanjutnya
                              </button>
                          </div>
                      </div>

                      </form>
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