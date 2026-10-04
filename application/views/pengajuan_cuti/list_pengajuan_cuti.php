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
                      <h4 class="fw-semibold mb-8">Data Pengajuan Cuti Pegawai</h4>
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

                
            ?>
            <div class="row">

            <?php
                for ($i=0; $i < count($cutiPegawai) ; $i++) { 
                    
                    $nama_pegawai = $cutiPegawai[$i]->nama;
                    $tgl_dari = $cutiPegawai[$i]->tgl_dari;
                    $tgl_sampai = $cutiPegawai[$i]->tgl_sampai;
                    $hari_cuti = $cutiPegawai[$i]->hari_cuti;
                    $status = $cutiPegawai[$i]->status;
                    $photo_pegawai = $cutiPegawai[$i]->photo;

                    if($photo_pegawai==''){
                        $photo_pegawai = 'avatar.png';
                      }
      

                    $flagStatus = getStatusCuti($status);

                    echo ' <div class="col-md-4 col-lg-4">
                            <div class="card text-center alert-dismissible fade show alert p-0 card-hover" role="alert">
                          
                            <div class="p-2 d-block mt-3">

                                <img src="'.base_url().'uploads/photo_profile/'.$photo_pegawai.'" width="85" class="img-fluid" style="height:100px">
                                <h5 class="card-title mt-3">'. $nama_pegawai.'</h5>
                                '.$flagStatus .'
                                <br> <br>



                                <div style="text-align:left">
                                    

                                    <table class="table table-sm">
                                       <tr>
                                         <td class="text-muted">Tgl Mulai  </td>
                                         <th>: &nbsp;'.format_semi($tgl_dari).'</th>
                                         <td class="text-center text-muted">Hari Cuti</td>
                                       </tr>
                                       <tr>
                                        <td class="text-muted">Tgl Akhir  </td>
                                        <th> :&nbsp;  '.format_semi($tgl_sampai).'</th>
                                        <th class="text-center">'.$hari_cuti.' hari</th>
                                     </tr>
                                     <tr>
                                        <td class="text-muted">Alasan Cuti  </td>
                                        <th colspan="2"> :&nbsp;  '.$cutiPegawai[$i]->alasan_cuti.'</th>
                                     </tr>
                                    </table>   


                                </div>
                            

                                <a href="#" class="btn btn-info  mt-4">Lihat Detail</a>
                                <button type="submit" class="btn btn-success approve mt-4" data-bs-toggle="modal" data-bs-target="#confirm-approve" value="'.$cutiPegawai[$i]->id.'">Setujui</button>
                            </div>
                            </div>
                        </div>';
                }
            ?>
               

              </div>



              <div class="modal fade" id="confirm-approve" tabindex="-1" aria-labelledby="vertical-center-modal" aria-hidden="true">
                     <div class="modal-dialog modal-sm">
                       <div class="modal-content modal-filled bg-light-success text-success">
                         <div class="modal-body p-4">
                            <div class="text-center text-success">
                                <i class="ti ti-circle-check fs-7"></i>
                                <h4 class="mt-2">Approve Cuti</h4>
                                <p class="mt-3 text-success-50">
                                  Apakah anda ingin menyetujui pengajuan cuti ini?
                                </p>
                                <form method="post" action="<?php echo base_url();?>admin/pengajuan_cuti/setujui_cuti">   
                                  <input type="hidden" name="status" value="<?php echo $status;?>">
                                  <input type="hidden" name="id_cuti" id="id_cuti_approve" value="">
                                  <button type="submit" class="btn btn-success my-2"> Iya, setujui </button>
                                  <button type="button" class="btn btn-light my-2" data-bs-dismiss="modal">  Batal  </button>
                                </form>
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


    <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>bootstrap-datepicker.js"></script>
</body>


<script>
    
    $(".approve").click(function(){
        var id = $(this).val();

        $("#id_cuti_approve").val(id);
    });



</script>
</html>