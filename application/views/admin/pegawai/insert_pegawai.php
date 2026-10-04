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
                      <h4 class="fw-semibold mb-8">Input Data Pegawai</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html" >Home</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-item"> <a class="text-muted text-decoration-none" href="../main/index.html" >Data Pegawai</a></li>
                          <li> &nbsp; / &nbsp; </li>
                          <li class="breadcrumb-acive">Input Data Pegawai</li>
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
                
        
                $message = $this->session->flashdata('message'); 

           
                $jns_pegawai = $this->uri->segment(4);
                if($jns_pegawai=='non_pns'){
                     $flag_jns_pegawai = '<span class="text-info">NON PNS</span>';
                }else if($jns_pegawai=='pns'){
                  $flag_jns_pegawai = '<span class="text-success">PNS</span>';
                }else{
                 $flag_jns_pegawai = '<span class="text-warning">PJLLP</span>';
                }

                $arrayStatusPajak = array('TK', 'K0', 'K1', 'K2');
                $array_group = arrayUsergroup(); 


                echo $message


                
            ?>

                   
              <div class="row">
                
                <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                            <div class="card-body p-4">
                            

                                <form method="post" action="<?php echo base_url();?>admin/pegawai/insert_pegawai/<?php echo $jns_pegawai ;?>">
                                            <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label for="exampleInputtext" class="form-label fw-semibold">Nama Lengkap</label>
                                                    <input type="text" name="nama" class="form-control" >
                                                </div>
                                                
                                                    <div class="row">
                                                        <div class="col-md-7">
                                                            <div class="mb-4">
                                                                <label for="exampleInputtext" class="form-label fw-semibold">NIP</label>
                                                                <input type="text" name="nip" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="mb-4">
                                                                <label for="exampleInputtext" class="form-label fw-semibold">NRK</label>
                                                                <input type="text" name="nrk" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                

                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                                <label for="exampleInputtext" class="form-label fw-semibold">TMT</label>
                                                            <input type="date" name="tmt"  class="form-control" >
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                            <div class="mb-4">
                                                            <label for="exampleInputPassword1" class="form-label fw-semibold">Jenis Pegawai</label>
                                                            <select class="form-select" name="jns_pegawai" aria-label="Default select example">
                                                            <?php
                                                                if($jns_pegawai=='non_pns'){
                                                                    echo '  
                                                                    <option value="non_pns" selected>NON PNS</option>
                                                                    <option value="pns">PNS</option>
                                                                    <option value="pppk">PPPK</option>
                                                                    <option value="pjlp">PJLP</option>';

                                                                }else if($jns_pegawai=='pns'){
                                                                    echo '  
                                                                    <option value="non_pns">NON PNS</option>
                                                                    <option value="pns" selected>PNS</option>
                                                                    <option value="pppk">PPPK</option>
                                                                    <option value="pjlp">PJLP</option>';
                                                                }else if($jns_pegawai=='pppk'){
                                                                    echo '  
                                                                    <option value="non_pns">NON PNS</option>
                                                                    <option value="pns">PNS</option>
                                                                    <option value="pppk" selected>PPPK</option>
                                                                    <option value="pjlp">PJLP</option>';
                                                                }else{
                                                                    echo '  
                                                                    <option value="non_pns">NON PNS</option>
                                                                    <option value="pns">PNS</option>
                                                                    <option value="pjlp" selected>PJLP</option>';
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <label for="exampleInputtext" class="form-label fw-semibold">Golongan</label>
                                                            <input type="text" name="golongan" class="form-control">
                                                        </div>

                                                        <div class="mb-4">                                                                                                        
                                                            <label for="exampleInputPassword3" class="form-label fw-semibold">Pendidikan</label>
                                                            <select class="form-select" name="id_pendidikan"  aria-label="Default select example">
                                                                <?php
                                                                        foreach ($list_pendidikan as $pendidikan){
                                                                                                    
                                                                        $id_pnd = $pendidikan->id;
                                                                        $nama_pendidikan = $pendidikan->pendidikan;

                                                                        if($id_pnd==$pegawai[0]->id_pendidikan){
                                                                            echo ' <option value="'. $id_pnd .'" selected>'.$nama_pendidikan .'</option>';
                                                                        }else{
                                                                            echo ' <option value="'. $id_pnd .'">'.$nama_pendidikan .'</option>';
                                                                        }
                                                                        

                                                                        }
                                                                    ?>
                                                            </select>
                                                            </div>

                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <label for="exampleInputPassword3" class="form-label fw-semibold">Jabatan</label>
                                                            <select class="form-select" name="id_jabatan" aria-label="Default select example">

                                                            <?php
                                                                        foreach ($list_jabatan as $jabatan){
                                                                                                    
                                                                        $id = $jabatan->id;
                                                                        $nama_jabatan = $jabatan->nama;

                                                                        if($id==$pegawai[0]->id_jabatan){
                                                                            echo ' <option value="'. $id .'" selected>'.$nama_jabatan .'</option>';
                                                                        }else{
                                                                            echo ' <option value="'. $id .'">'.$nama_jabatan .'</option>';
                                                                        }
                                                                        

                                                                        }

                                                                    ?>
                                                                </select>
                                                        </div>
                                                        <div class="mb-4">

                                                        
                                                            <label for="exampleInputPassword3" class="form-label fw-semibold">Usergroup</label>

                                                            <select class="form-select" name="usergroup"  aria-label="Default select example">
                                                                    <?php
                                                                        for ($i=0; $i < count($array_group); $i++){
                                                                                                    
                                                                            $ug_id = $i+1;
                                                                            $group = $array_group[$i];

                                                                            echo '<option value="'. $ug_id .'" >'.$group .'</option>';
                                                                            
                                                                        

                                                                        }

                                                                    ?>
                                                                </select>
                                                        </div>
                                                            
                                                    </div>
                                                </div>
                                            
                                            </div><!--col-md-6-->
                                            <div class="col-md-6">
                                                <div class="mb-4">
                                                    <label for="exampleInputPassword1" class="form-label fw-semibold">Poli / Layanan</label>
                                                    <select class="form-select" name="id_poli" aria-label="Default select example">
                                                            <?php
                                                                foreach ($list_poli as $poli){
                                                                                            
                                                                    $id_poli = $poli->id;
                                                                    $nama_poli = $poli->nama_poli;

                                                                    if($id_poli==$pegawai[0]->id_poli){
                                                                    echo ' <option value="'. $id_poli .'" selected>'.$nama_poli .'</option>';
                                                                    }else{
                                                                    echo ' <option value="'. $id_poli .'">'.$nama_poli .'</option>';
                                                                    }
                                                                

                                                                }

                                                            ?>
                                                    
                                                    </select>
                                                </div>
                                                <div class="mb-4">
                                                    <label for="exampleInputPassword1" class="form-label fw-semibold">Puskesmas</label>
                                                    <select class="form-select" name="id_puskesmas" aria-label="Default select example">
                                                            <?php
                                                                foreach ($list_puskesmas as $puskesmas){
                                                                                            
                                                                $id_puskesmas = $puskesmas->id_puskesmas;
                                                                $nama_puskesmas = $puskesmas->nama;

                                                                if($id_puskesmas==$pegawai[0]->id_puskesmas){
                                                                    echo ' <option value="'. $id_puskesmas .'" selected>'.$nama_puskesmas .'</option>';
                                                                }else{
                                                                    echo ' <option value="'. $id_puskesmas .'">'.$nama_puskesmas .'</option>';
                                                                }
                                                                

                                                                }

                                                            ?>
                                                    
                                                        </select>
                                                </div>
                                                
                                                <div class="mb-4">
                                                    <label for="exampleInputPassword2" class="form-label fw-semibold">Atasan Langsung</label>
                                                        <select class="form-select" name="id_validator" aria-label="Default select example">
                                                        <?php

                                                                if($jns_pegawai=='pjlp'){
                                                                    $ls_validator = $list_validator_pjlp;
                                                                }else{
                                                                    $ls_validator = $list_validator;
                                                                }
                                                                
                                                                foreach ($ls_validator as $validator){
                                                                                            
                                                                    $id_pegawai_atasan = $validator->id_pegawai;
                                                                    $nama_pegawai = $validator->nama;

                                                                    if($id_pegawai_atasan==$pegawai[0]->id_validator){
                                                                    echo ' <option value="'. $id_pegawai_atasan .'" selected>'.$nama_pegawai .'</option>';
                                                                    }else{
                                                                    echo ' <option value="'. $id_pegawai_atasan .'">'.$nama_pegawai .'</option>';
                                                                    }
                                                                

                                                                }

                                                            ?>
                                                    
                                                        </select>
                                                    </div>

                                                
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                        <label for="exampleInputPassword2" class="form-label fw-semibold">Jenis Jam Kerja</label>
                                                            <select class="form-select" name="jns_jam_kerja" aria-label="Default select example">
                                                            <?php
                                                                    if($pegawai[0]->jns_jam_kerja=='shift'){
                                                                        echo '  
                                                                        <option value="shift" selected>SHIFT</option>
                                                                        <option value="non_shift">REGULAR</option>';

                                                                    }else{
                                                                        echo '  
                                                                        <option value="shift">SHIFT</option>
                                                                        <option value="non_shift" selected>REGULAR</option>';
                                                                    }
                                                                    ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                            <div class="mb-4">
                                                            <label for="exampleInputPassword2" class="form-label fw-semibold">Rumpun Kerja</label>
                                                                <select class="form-select" name="rumpun_kerja" aria-label="Default select example">

                                                                    <?php
                                                                        if($pegawai[0]->rumpun_kerja=='ukp'){
                                                                        echo '  
                                                                        <option value="ukp" selected>UKP</option>
                                                                        <option value="ukm">UKM</option>
                                                                        <option value="admen">ADMEN</option>';

                                                                        }else if($pegawai[0]->rumpun_kerja=='ukm'){
                                                                        echo '  
                                                                        <option value="ukp">UKP</option>
                                                                        <option value="ukm" selected>UKM</option>
                                                                        <option value="admen">ADMEN</option>';
                                                                        }else{
                                                                        echo '  
                                                                        <option value="ukp">UKP</option>
                                                                        <option value="ukm">UKM</option>
                                                                        <option value="admen" selected>ADMEN</option>';
                                                                        }
                                                                    ?>
                                                                
                                                                </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <label for="exampleInputPassword3" class="form-label fw-semibold">Status Kawin</label>
                                                            <select class="form-select" name="status_kawin" aria-label="Default select example">

                                                                <?php
                                                                        foreach ($list_Status as $status_kawin){
                                                                                                    
                                                                        $id_status = $status_kawin->id;
                                                                        $status = $status_kawin->status;
                                                                        $ket_status = $status_kawin->ket;

                                                                        if($id_status==$pegawai[0]->status_kawin){
                                                                            echo ' <option value="'. $id_status .'" selected>'.$status .' - '.$ket_status.'</option>';
                                                                        }else{
                                                                            echo ' <option value="'. $id_status .'">'.$status .' - '.$ket_status.'</option>';
                                                                        }
                                                                        

                                                                        }

                                                                    ?>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="mb-4">
                                                            <label for="exampleInputPassword3" class="form-label fw-semibold">Status Pajak</label>
                                                            <select class="form-select" name="status_pajak" aria-label="Default select example">
                                                            
                                                                
                                                                <?php
                                                                        for ($a=0; $a < count($arrayStatusPajak); $a++){
                                                                                                    
                                                                
                                                                        $status_pajak = $arrayStatusPajak[$a];

                                                                        if($status_pajak==$pegawai[0]->status_pajak){
                                                                            echo ' <option value="'. $status_pajak .'" selected>'.$status_pajak .'</option>';
                                                                        }else{
                                                                            echo ' <option value="'. $status_pajak .'">'.$status_pajak .'</option>';
                                                                        }
                                                                        

                                                                        }

                                                                    ?>
                                                                </select>
                                                        </div>
                                                    </div>

                                                
                                            </div>
                                            
                                        </div><!--col-md-6-->

                                        


                                        

                                        </div><!--row-->
                                        <button type="submit" class="btn btn-primary float-end">Simpan </button>
                                        <a href="<?php echo base_url();?>admin/pegawai/index "class="btn btn-danger float-start">Kembali</a>

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


=
</html>