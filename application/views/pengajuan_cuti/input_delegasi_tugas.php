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
              <?php 
                            $id_pegawai = $this->session->userdata('id_pegawai');
                            $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 1);
                            $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
                            $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);
            
                            $date_from        =  $this->session->userdata('date_from');
                            $date_to          =  $this->session->userdata('date_to');
                            $jns_cuti         =  $this->session->userdata('jns_cuti');
                            $jns_hak_cuti     =  $this->session->userdata('jns_hak_cuti');
                            $jml_hari_cuti    =  $this->session->userdata('jml_hari_cuti');
                            $list_hari_cuti   =  $this->session->userdata('list_hari_cuti');
            
                            $nama_pengganti     =  $this->session->userdata('nama_pengganti');
                            $alasan_cuti    =  $this->session->userdata('alasan_cuti');
                            $alamat   =  $this->session->userdata('alamat');
                            $tlp   =  $this->session->userdata('tlp');
            
                            
                            
            
                            if($date_from==''){
                                redirect('cuti/buat_pengajuan_cuti');
                            }
            
            
                            if($jns_cuti==1){
                                $jenis_cuti = 'Tahunan';
                            }else if($jns_cuti==2){
                                $jenis_cuti = 'Bersalin';
                            }else if($jns_cuti==3){
                                $jenis_cuti = 'Alasan Penting ';
                            }else if($jns_cuti==4){
                                $jenis_cuti = 'Sakit';
                            }else{
                                $jenis_cuti = 'Besar';
                            }
            
            
                            $message = $this->session->flashdata('message'); 
                            echo $message;
                
            ?>

                   
              <div class="row">
                
                <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                            <div class="card-body p-4">
                            <form method="post" action="<?php echo base_url();?>cuti/save_pengajuan_cuti" enctype="multipart/form-data">
                                    <div class="row">
                                        <div class="col-md-5 col-sm-12 col-12 mt-3 p-4 bg-light-subtle shadow-none">
                                            <h6>Pengajuan Cuti</h6>
                                            <table class="table table-sm table-borderless">
                                                <tr>
                                                    <td>Tanggal Mulai</td>
                                                    <td class="text-end text-danger" style="font-weight: bold;"><?php echo $date_from ;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Tanggal Akhir</td>
                                                    <td  class="text-end  text-danger"  style="font-weight: bold;"><?php echo $date_to ;?></td>
                                                </tr>
                                                <tr>
                                                    <td>Jumlah Hari</td>
                                                    <td  class="text-end"  style="font-weight: bold;"><?php echo $jml_hari_cuti;?> Hari</td>
                                                </tr>

                                                <tr>
                                                    <td>Jenis Cuti</td>
                                                    <td  class="text-end"  style="font-weight: bold;">Cuti <?php echo $jenis_cuti;?></td>
                                                </tr>


                                            </table>

                                            <br>

                                            <?php
                                                if($jml_hari_cuti ==1){
                                                    $hari = getNamahari($date_from);

                                                    echo $hari.', '.format_full($date_from);

                                                    
                                                }else{

                                                    $listHari = $this->session->userdata('list_hari_cuti');
                                                    for ($h=0; $h < count($listHari) ; $h++) { 
                                                        $tgl = $list_hari_cuti[$h];
                                                        $hari = getNamahari($tgl);
                                                        echo  '&nbsp;&nbsp;&nbsp;  -&nbsp;&nbsp;  '.$hari.', &nbsp;&nbsp;&nbsp; '.format_slash($tgl).'<br>';
                                                    }
                                                }
                                            ?>


                                        

                                        </div>
                                        <div class="col-md-7 col-sm-12 col-12 mt-3 ps-4">
                                                <table class="table table-sm table-borderless mt-4">
                                                        <tr>
                                                            <td>Pengganti Selama Cuti</td>
                                                            <td class="text-end text-danger" style="font-weight: bold;"><?php echo $nama_pengganti ;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Alasan Cuti</td>
                                                            <td  class="text-end  text-danger"  style="font-weight: bold;"><?php echo $alasan_cuti ;?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>No telp yang dapat dihubungi</td>
                                                            <td  class="text-end"  style="font-weight: bold;"><?php echo $tlp;?></td>
                                                        </tr>

                                                        <tr>
                                                            <td>Alamat selama cuti</td>
                                                            <td  class="text-end"  style="font-weight: bold;">Cuti <?php echo $alamat;?></td>
                                                        </tr>


                                                    </table>

                                                    
                                            <h4>Form Delegasi Tugas</h4>
                                            <br>
                                                <label>Tugas 1 <span class="text-danger">*</span>:</label><br>
                                                <div class="form-input mb-2">
                                                    <input type="text"  name="tugas1" value="" placeholder="input delegasi tugas" class="form-control" required autocomplete="off">
                                                    
                                                </div>
                                                <label>Tugas 2 <span class="text-danger">*</span>:</label><br>
                                                <div class="form-input mb-2">
                                                    <input type="text"  name="tugas2" value="" placeholder="input delegasi tugas" class="form-control" required autocomplete="off">
                                                    
                                                </div>
                                                <label>Tugas 3 <span class="text-danger">*</span>:</label><br>
                                                <div class="form-input mb-2">
                                                    <input type="text"  name="tugas3" value="" placeholder="input delegasi tugas" class="form-control" required autocomplete="off">
                                                    
                                                </div>
                                                <label>Tugas 4 :</label><br>
                                                <div class="form-input">
                                                    <input type="text"  name="tugas4" value="" placeholder="input delegasi tugas" class="form-control" autocomplete="off">
                                                    
                                                </div>
                                                
                                        </div>
                                    </div>
                                    <a href="<?php echo base_url();?>cuti/pengajuan_cuti_step2" class="btn btn-danger float-start">Kembali</a>
                                    <button type="submit" class="btn btn-primary float-end mt-4">Kirim Pengajuan Cuti</button>
                                </form>
                            
                            
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

$("#search_pegawai").keydown(function() {
    var keyword = $(this).val();
    $("#list_pegawai").show();
    $.ajax({
        type: "POST",
        url: "<?php echo base_url();?>cuti/search_pegawai",
        data: "keyword=" + keyword,
        success: function(return_data) {
            $("#list_pegawai").html(return_data);
        }
    });
});

</script>
</html>