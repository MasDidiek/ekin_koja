<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
    <style>
    #list_pegawai{
        max-height:200px;
        overflow: auto;
    }
    .choose_pegawai{
        padding:5px;
        cursor: pointer;
    }
    .choose_pegawai:hover{
        color:darkorange;


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

            
            <?php
                
                $cutiPending1 = $this->Cuti_model->numDataCutiByStatus('pending1');
                $cutiPending2 = $this->Cuti_model->numDataCutiByStatus('pending2');
                $cutiPending3 = $this->Cuti_model->numDataCutiByStatus('pending3');
                $cutiPending4 = $this->Cuti_model->numDataCutiByStatus('pending4');
                $cutiApprove  = $this->Cuti_model->numDataCutiByStatus('approve');
                $cutiReject   = $this->Cuti_model->numDataCutiByStatus('reject');
                
                
                $status_url = $this->uri->segment(4);
                
                if( $status_url==''){
                     $list_cuti = array();
                }else{
                     $list_cuti = $this->Cuti_model->getDataCutiPegawaiByStatus($status_url);
                }
               
                
            ?>

      <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8">Pengajuan Pegawai</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="<?php echo base_url();?>dashboard/index" >Home</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive">Pengajuan Cuti</li>
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
            
           <div class="col-lg-4 col-xxl-3 col-6">
              <div class="card text-white text-bg-warning">
                <div class="card-body p-4">
                  <span>
                    <i class="ti ti-layout-grid fs-8"></i>
                  </span>
                  <h4 class="card-title mt-3 mb-0 text-white"><?php echo $cutiPending1;?></h4>
                 
                    <a href="<?php echo base_url();?>admin/pengajuan_cuti/dashboard_cuti/pending1" class="card-text text-white opacity-75 fs-3 fw-normal">Pending Kapustu/Kasatpel</a>
                 
                </div>
              </div>
            </div>
            
             <div class="col-lg-4 col-xxl-3 col-6">
              <div class="card text-white text-bg-warning">
                <div class="card-body p-4">
                  <span>
                    <i class="ti ti-layout-grid fs-8"></i>
                  </span>
                  <h4 class="card-title mt-3 mb-0 text-white"><?php echo $cutiPending2;?></h4>
                 <a href="<?php echo base_url();?>admin/pengajuan_cuti/dashboard_cuti/pending2" class="card-text text-white opacity-75 fs-3 fw-normal">Pending Kasubbag TU</a>
                </div>
              </div>
            </div>
            
             <div class="col-lg-4 col-xxl-2 col-6">
              <div class="card text-white text-bg-info">
                <div class="card-body p-4">
                  <span>
                    <i class="ti ti-layout-grid fs-8"></i>
                  </span>
                  <h4 class="card-title mt-3 mb-0 text-white"><?php echo $cutiPending3;?></h4>
                 <a href="<?php echo base_url();?>admin/pengajuan_cuti/dashboard_cuti/pending3" class="card-text text-white opacity-75 fs-3 fw-normal">Pending Kapuskec</a>
                </div>
              </div>
            </div>
            
             <div class="col-lg-4 col-xxl-2 col-6">
              <div class="card text-white text-bg-success">
                <div class="card-body p-4">
                  <span>
                    <i class="ti ti-layout-grid fs-8"></i>
                  </span>
                  <h4 class="card-title mt-3 mb-0 text-white"><?php echo $cutiApprove;?></h4>
                 <a href="<?php echo base_url();?>admin/pengajuan_cuti/dashboard_cuti/approve" class="card-text text-white opacity-75 fs-3 fw-normal">Pending Kasudin</a>
                </div>
              </div>
            </div>
             <div class="col-lg-4 col-xxl-2 col-6">
              <div class="card text-white text-bg-danger">
                <div class="card-body p-4">
                  <span>
                    <i class="ti ti-layout-grid fs-8"></i>
                  </span>
                  <h4 class="card-title mt-3 mb-0 text-white">450</h4>
                 <a href="<?php echo base_url();?>admin/pengajuan_cuti/dashboard_cuti/<?php echo $cutiReject;?>" class="card-text text-white opacity-75 fs-3 fw-normal">Ditolak</a>
                </div>
              </div>
            </div>
            
            
            <div class="col-md-12">
                 
                         <table class="table align-middlemb-0" >
                                <thead>
                                    <tr class="text-muted fw-semibold">
                                        <th>No</th>
                                        <th scope="col" class="ps-0">Nama</th>
                                        <th scope="col">Tanggal Cuti</th>
                                        <th width="300">Alasan</th>
                                        <th scope="col">Status</th>
                                      
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php

                                        $id_pegawai_validator = $this->session->userdata('id_pegawai');  //id atasan yang sedang login

                                      // print_array($list_cuti);
                                            for ($a=0; $a < count($list_cuti); $a++) {
                                                
                                                    $nama_pegawai = $list_cuti[$a]->nama;
                                                    $hari_cuti = $list_cuti[$a]->hari_cuti;
                                                    $tgl_dari = $list_cuti[$a]->tgl_dari;
                                                    $tgl_sampai = $list_cuti[$a]->tgl_sampai;
                                                    $status = $list_cuti[$a]->status;
                                                    
                                                     if($hari_cuti==1){
                                                        $tgl_cuti = date('d M, Y',strtotime($tgl_dari));
                                                    }else{
                                                        $tgl_cuti = date('d M, Y',strtotime($tgl_dari)).' s / d '.format_view($tgl_sampai);
                                                    }
                                                    
                                                     $flagStatus = getStatusCuti($status);
                                               
                                            
                                                echo '<tr>
                                                            <td>'.($a+1).'</td>
                                                            <td><a href="'.base_url().'admin/pengajuan_cuti/detail/'.$list_cuti[$a]->id.'" class="text-primary">'.$nama_pegawai.'</a></td>
                                                            <td><a href="'.base_url().'admin/pengajuan_cuti/detail/'.$list_cuti[$a]->id.'" class="text-link">'.$tgl_cuti.'</a></td>
                                                            <td>'.$list_cuti[$a]->alasan_cuti.'</td>
                                                            <td>'.$flagStatus.'</td> 
                                                          
                                                     </tr>';

                                            }
                                        ?>
                                        

                                        </tbody>
                            </table>
                
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


</html>