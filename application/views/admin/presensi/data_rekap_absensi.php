<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css">
  
  
<style>
    .form-periode{
          display: none;
          width: 15em;
          height: 13em;
          background: #fff;
          position: absolute;
          border: 1px solid #ddd;
          border-radius: 3px;
          padding: 0;
          z-index: 999;
      }


   table{
                width: 100% ;
            }

            .table-absensi th{
                border: 1px solid #EEE;
                padding: 10px;
                text-align: center;
                font-size: 15px;
            }
            .table td{
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
 

      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>

  
      <?php

            #print_array($this->session->userdata);
            // $bulan = $this->session->userdata('periode_bulan');
            // $tahun = $this->session->userdata('periode_tahun');

          
            $periode_bulan = $this->session->userdata('periode_bulan'); 
            $periode_tahun = $this->session->userdata('periode_tahun'); 
            $id_pkm_sess   = $this->session->userdata('id_pkm');

            $order_by = $this->uri->segment(4);

          
            if($periode_bulan=='') {
                $bulan = date('m');
                $tahun = date('Y');
  
              }else{
                $bulan = $periode_bulan;
                $tahun = $periode_tahun;
              }

              

            $nm_bulan = getBulan($bulan);
            $periode = $tahun.'-'.$bulan;
            $periode = date('Y-m', strtotime($periode));
            $id_validator = $this->session->userdata('id_pegawai');
            $id_pj_sess  = $this->session->userdata('id_pj');
        
        
              $listBulan = array_bulan();
              
            if($id_pj_sess != ''){
              $id_validator = $id_pj_sess;
            }
        #print_array($rekap_absensi);

            ?>

      <div class="body-wrapper">
         <div class="container-fluid">
             <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
          
                  </div>

                  
                </div>
              </div>
                       
      
              <div class="row">

               
                    
                        <div class="col-md-2">
                              <label for="puskesmas">Bulan</label>
                              <select name="periode_bulan" id="bulan_pilih" class="pilih-validator form-control">

                              <?php
                                for ($b=1; $b < 13; $b++) { 

                                  if($b==$bulan){
                                    $active = 'selected';
                                  }else{
                                    $active = '';
                                  }
                                  echo '<option value="'.$listBulan[$b].'" '.$active.'>'.$listBulan[$b].'</option>';
                                }
                                
                                  
                              ?>
                              
                              </select>
                        </div>
                        <div class="col-md-2">
                              <label for="puskesmas">Tahun</label>
                              <select name="periode_tahun" id="tahun_pilih" class="form-control">

                              <?php
                                for ($b=2024; $b < 2030; $b++) { 

                                  if($b==$tahun){
                                    $active = 'selected';
                                  }else{
                                    $active = '';
                                  }
                                  echo '<option value="'.$b.'" '.$active.'>'.$b.'</option>';
                                }
                                
                                  
                              ?>
                              
                              </select>
                        </div>





                        <div class="col-md-3">
                              <label for="puskesmas">Puskesmas</label>
                              <select name="id_validator" id="validator" class="pilih-validator form-control">

                              <?php
                                  foreach ($validator as $pj) {

                                    $id_pj = $pj->id_pegawai;
                                    $nama_pj   = $pj->nama;


                                    if($id_pj_sess==$id_pj){
                                      echo '<option value="'. $id_pj.'" selected>'.$nama_pj.'</option>';
                                    }else{
                                      echo '<option value="'. $id_pj.'">'.$nama_pj.'</option>';
                                    }
                                  
                                  }
                              ?>
                              
                              </select>
                        </div>


                        <div class="col-lg-4 col-md-6">
                        </div>

                    <div class="col-lg-4 col-md-6 mt-3">
                        <div class="card">
                          <a href="#" class="stretched-link"></a>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-3">
                                <div class="bg-success-subtle text-success rounded d-flex align-items-center p-8 justify-content-center">
                                  <i class="ti ti-checkbox fs-8"></i>
                                </div>
                              </div>
                              <div class="col-9 d-flex align-items-center justify-content-end text-end">
                                <div>
                                  <h4 class="card-title"><?php   echo $absensiSesuai;?></h4>
                                  <h6 class="card-subtitle mb-0">Absensi Sesuai</h6>
                                </div>
                              </div>
                            </div>
                            <div class="progress mt-3 text-bg-light">
                              <div class="progress-bar text-bg-success" role="progressbar" style="width: 26%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4 col-md-6  col-md-6 mt-3">
                        <div class="card">
                          <a href="#" class="stretched-link"></a>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-3">
                                <div class="bg-warning-subtle text-warning rounded d-flex align-items-center p-8 justify-content-center">
                                  <i class="ti ti-exclamation-mark fs-8"></i>
                                </div>
                              </div>
                              <div class="col-9 d-flex align-items-center justify-content-end text-end">
                                <div>
                                  <h4 class="card-title"><?php echo $absensiBlmSesuai;?></h4>
                                  <h6 class="card-subtitle mb-0"> Absensi Belum Sesuai</h6>
                                </div>
                              </div>
                            </div>
                            <div class="progress mt-3 text-bg-light">
                              <div class="progress-bar text-bg-warning" role="progressbar" style="width: 26%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>

                
                      <div class="col-lg-4 col-md-6  col-md-6 mt-3">
                        <div class="card">
                          <a href="#" class="stretched-link"></a>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-3">
                                <div class="bg-danger-subtle text-danger rounded d-flex align-items-center p-8 justify-content-center">
                                  <i class="ti ti-chart-pie fs-8"></i>
                                </div>
                              </div>
                              <div class="col-9 d-flex align-items-center justify-content-end text-end">
                                <div>
                                  <h4 class="card-title">0</h4>
                                  <h6 class="card-subtitle mb-0">Absensi Belum direkap</h6>
                                </div>
                              </div>
                            </div>
                            <div class="progress mt-3 text-bg-light">
                              <div class="progress-bar text-bg-danger" role="progressbar" style="width: 26%; height: 6px;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                          </div>
                        </div>
                      </div>
            </div><!--row-->

              <div class="row">
                <!-- Column -->
                <div class="col-md-12 mb-2">
                   <!-- <a href="<?php echo base_url();?>admin/presensi/DataRekapAbsensi/telat" class="btn btn-light text-info">Telat</a>
                   <a href="<?php echo base_url();?>admin/presensi/DataRekapAbsensi/pulang_awal" class="btn btn-light text-info">Pulang awal</a>
                   <a href="<?php echo base_url();?>admin/presensi/DataRekapAbsensi/izin" class="btn btn-light text-info">Izin</a>
                   <a href="<?php echo base_url();?>admin/presensi/DataRekapAbsensi/sakit" class="btn btn-light text-info">Sakit</a> -->


                </div>


             
                
              <div class="table-responsive mt-4">

               <a href="<?php echo base_url();?>admin/presensi/lihat_data_rekapan_absensi" class="btn btn-info float-end" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-download"></i> Lihat </a>
                              <div class="clearfix">  </div>
                              <br>

               
               <table class="table  table-hover table-bordered"  id="data-table">
                          <thead>
                              <tr>
                              
                                <th class="w-1">No.</th>
                                <th>Nama</th>
                                <th>Telat</th>
                                <th>Pulang Awal</th>
                                <th>Izin</th>
                                <th>Sakit</th>
                                <th>Cuti Tahunan</th>
                                <th>Cuti Bersalin</th>
                                <th>Alpha</th>
                        
                                <th>Status</th>
                              </tr>
                          </thead>
                          <tbody>

                      <?php 

                        


                          $select = 'nama, nip, id_validator';
                          for ($i=0; $i < count($pegawai) ; $i++) { 
                            $id_pegawai = $pegawai[$i]->id_pegawai;
                            $nip = $pegawai[$i]->nip;
                            $nama_pegawai = $pegawai[$i]->nama;
                           // $id_validator_peg = $pegawai[$i]->id_validator;
                            $pin = substr($nip, -4);


                            $rekap_absensi = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);

                     

                              //print_array($rekap_absensi);
                            $numRekap = count($rekap_absensi);;
                            if($numRekap > 0){
                              $telat = $rekap_absensi[0]->telat;
                              $pulang_awal = $rekap_absensi[0]->pulang_awal;
                              $status = $rekap_absensi[0]->status;
                              $i_izin = $rekap_absensi[0]->izin;
                              $i_sakit = $rekap_absensi[0]->sakit;

                              $alpha = $rekap_absensi[0]->alpha;
                              $cuti = $rekap_absensi[0]->cuti;
                           

                                if($status==0){
                                  $status_absen = '<span class="badge bg-warning">Belum sesuai</span>';
                                }else{
                                  $status_absen = '<span class="badge bg-success">Sudah  sesuai</span>';
                                }
                            }else{
                              $telat = 0;
                              $pulang_awal = 0;
                              $i_izin = 0;
                              $i_sakit = 0;
                              $alpha = 0;
                              $cuti = 0;
                              $status_absen = '<span class="badge bg-danger">Belum direkap</span>';
                            }


                           
                      ?>


                                <tr>
                                  <td><?php echo ($i+1);?></td>
                                  <td class="text-start">
                                    <a href="<?php echo base_url();?>admin/presensi/lihat_absensi_pegawai/<?php echo $id_pegawai.'/'. $pin  ;?>"><?php echo $nama_pegawai ;?></a></td>
                                  <td><?php echo $telat ;?></td>
                                  <td><?php echo  $pulang_awal ;?></td>
                                  <td><?php echo  $i_izin ;?></td>
                                  <td><?php echo  $i_sakit ;?></td>
                                  <td><?php echo  $cuti ;?></td>
                                  <td></td>
                                  <td><?php echo  $alpha ;?></td>
                                  <td><?php echo $status_absen;?></td>

                                 
                                </tr>

                        <?php } 
                        
                            //}
                          ?>  

                          </tbody>  

                       </table>

                          </div>

                
                <!-- Column -->
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


    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
  </body>


<script>

$("#validator").change(function(){
                var id_pj = $(this).val();

                $.ajax({
                            
                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/presensi/set_session_validator",
                            data:"id_pj="+id_pj,
                            success:function(msg){
                             window.location.reload();
                              //$("#modal-form").html(msg);
                              //console.log(msg);
                            }
                        
                      });

              });
  

              

    
    $("#bulan_pilih").change(function(){
        var bulan = $(this).val();
        var tahun = $("#tahun_pilih").val();
        $.ajax({
                    
                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>admin/presensi/set_session_periode",
                    data:"bulan="+bulan+"&tahun="+tahun,
                    success:function(msg){
                      window.location.reload();
                      //$("#modal-form").html(msg);
                      //console.log(msg);
                    }
                
              });

      });

      


    
    $("#tahun_pilih").change(function(){
        var tahun = $(this).val();
        var bulan = $("#tahun_pilih").val();
        $.ajax({
                    
                    type:"POST",
                    dataType:"html",
                    url:"<?php echo base_url();?>admin/presensi/set_session_periode",
                    data:"bulan="+bulan+"&tahun="+tahun,
                    success:function(msg){
                      window.location.reload();
                      //$("#modal-form").html(msg);
                      //console.log(msg);
                    }
                
              });

      });

      

        $('#data-table').dataTable( {
                lengthMenu: [
                    [  20, -1 ],
                    ['20', '50', '100', 'Show all' ]
                ]
            } );
		

</script>
  
</html>