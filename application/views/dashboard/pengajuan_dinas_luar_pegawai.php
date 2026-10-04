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
                      <h4 class="fw-semibold mb-8">Pengajuan Dinas Luar Pegawai</h4>
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
             
                $message = $this->session->flashdata('message'); 
  
                
            ?>

         

                   


           <div class="row">

                  <div class="col-md-12">
                        <?php echo $message;?>
                    <h5 class="fw-semibold mb-8">Pengajuan Dinas Luar Pegawai</h5>
                    </div>

   
                            <table class="table table-bordered table-hover" style="width: 160%;">
                               <thead>
                                        <tr>
                                            <th class="w-1">No.</th>
                                            <th>Status</th>    
                                            <th>Action </th>
                                            <th>Tanggal</th>
                                            <th>Nama Pegawai</th>
                                            <th>Jenis Dinas Luar</th>
                                            <th>Keterangan</th>
                                           
                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    <?php 

                                    $path        = 'uploads/surat_tugas/';
                                    $no = 1;
                                    foreach ($pengajuan_dinas_luar as $dl){

                                        $id_pegawai = $dl->id_pegawai;
                                        $id = $dl->id;
                                        $jns_dl = $dl->jns_dl;
                                        $tanggal = $dl->tanggal;
                                        $keterangan = $dl->keterangan;
                                        $status = $dl->status;
                                        $surtug = $dl->surtug;

                                        $nama = $this->Pegawai_model->getNamaPegawaiByID($id_pegawai);

                                        if ($jns_dl=='DLP') {
                                            $dl_name = '<span class="badge  bg-primary-subtle text-primary">DL - PENUH</span>';
                                        }else if($jns_dl=='DLA'){
                                            $dl_name = '<span class="badge  bg-warning-subtle text-warning">DL - AWAL</span>';
                                        }else{
                                            $dl_name = '<span class="badge  bg-success-subtle text-success">DL -  AKHIR</span>';
                                        }

                                        if($status==0){
                                            $flag = '<span class="badge bg-warning fs-1">Belum diperiksa</span>';
                                        }else if($status==1){
                                            $flag = '<span class="badge bg-success">Valid</span>';
                                        }else{
                                            $flag = '<span class="badge bg-danger">Tidak Valid</span>';
                                        }

                                        echo' <tr>
                                                <td>'.$no.' </td>
                                                <td class="text-center">'.$flag.' </td>
                                                <td class="text-center">
                                                    <a href="'.base_url(). $path.$surtug.'" class="btn btn-sm btn-info" title="lihat detail" target="_blank">
                                                     <i class="fas fa-file-pdf"></i> Lihat </a>
                                                  
                                                </td>
                                               
                                                <td class="text-center">'.format_semi($tanggal).'</td>
                                                <td class="text-left"> '.$nama.'</td>
                                                <td class="text-center"> '.$dl_name.'</td>
                                                <td>'.$keterangan.' </td>
                                           
                                            
                                                
                                            </tr>';

                                                $no += 1;



                                    }

                                    ?>
                                    
                                 </tbody>
                            </table>
                        
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



</script>
</html>