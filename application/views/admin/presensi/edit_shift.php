<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>

<style>
   table{
                width: 100% ;
            }

            .table-absensi th{
                border: 1px solid #EEE;
                padding: 10px;
                text-align: center;
                font-size: 15px;
            }
            .table-absensi td{
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
      <!-- ---------------------------------- -->


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


            $lastDate = date('t', strtotime($periode)) + 1;

            $id_pegawai = $this->uri->segment(5);

            $nip = $data_pegawai[0]->nip;
            $shift = $data_pegawai[0]->jns_jam_kerja;
            $nama_pegawai = $data_pegawai[0]->nama;
            $id_puskesmas = $data_pegawai[0]->id_puskesmas;
         
            $puskesmas = $this->Presensi_model->getNamaPuskesmas($id_puskesmas);
            $message = $this->session->flashdata('message');


            $pin = substr($nip, -4);

         


            ?>

      <div class="body-wrapper">
         <div class="container-fluid">
             <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8">Edit Shift Pegawai</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="<?php echo base_url();?>admin/dashboard/index" >Home</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive">Edit Shift Pegawai</li>
                        
                        </ol>
                      </nav>
                    </div>
                  
                  </div>

                  
                </div>
              </div>
             
                         <div class="dropdown float-end">
                            <a class="text-decoration-none" href="javascript:void(0)" id="balance-dd" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-dots fs-4"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="balance-dd" style="">
                                <li>
                                <a class="dropdown-item" href="#" data-bs-toggle="modal"  data-bs-target="#modal-loading">
                                    <i class="ti ti-share me-1 fs-4"></i>  Data Cuti </a>
                                </li>
                                <li>
                                <a class="dropdown-item" href="<?php echo base_url();?>admin/presensi/sinkron_absensi/<?php echo $pin.'/'.$id_pegawai;?>" >
                                    <i class="ti ti-download me-1 fs-4"></i> Tarik Data Absensi  </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo base_url();?>admin/presensi/data_rekap/<?php echo $pin.'/'.$id_pegawai;?>">
                                    <i class="ti ti-info-circle me-1 fs-4"></i>Data Rekap </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?php echo base_url();?>admin/presensi/data_rekap/<?php echo $pin.'/'.$id_pegawai;?>">
                                    <i class="ti ti-info-circle me-1 fs-4"></i>Data Cuti </a>
                                </li>
                            </ul>
                        </div>

                        <div class="clearfix"></div>

                 <div class="row">
                     
                 
                       <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                  <div class="card-body p-4">
                                   
                                    <div class="col-md-5  my-4">
                                    <h4>
                                        <?php echo $nama_pegawai ;?> 
                                        <a href="<?php echo base_url();?>admin/presensi/edit_data_pegawai/<?php echo $pin.'/'.$id_pegawai;?>" class="text-primary" title="edit data pegawai" >
                                          <i class="fas fa-edit"></i>
                                        </a>
                                        <br>
                                        <span class="text-muted fs-3"><?php echo $nip ;?></span>

                                     </h4>

                                        <small><?php echo $puskesmas;?></small>
                                        <?php

                                        if($shift ==1){
                                              echo '<span class="badge bg-info-subtle text-info">Shift</span>';
                                        }
                                        ?>
                                        <br>
                                        Periode : <strong> <?php echo date('F Y', strtotime($periode));?> </strong>

                                    </div>


                                                        
                                    <a href="<?php echo base_url();?>admin/presensi/lihat_absensi_pegawai/<?php echo $id_pegawai.'/'.$pin;?>" class="btn btn-danger  mb-3">
                                  Back
                              </a>


                                        <form action="<?php echo base_url();?>admin/presensi/update_shift_pegawai/<?php echo $pin.'/'.$id_pegawai;?>"  method="post">
                                            

                                                <button type="submit" class="btn btn-success float-end  mb-3">
                                                <i class="fas fa-refresh"></i> Save Change
                                            </button> 
                                    
                            
                                        
                                             <div class="clearfix"></div>

                                    
                                                  <div class="table-responsive mt-4">
                                                    <table class="table-absensi table-sm">
                                                            <thead>
                                                                <tr>
                                                                    <th width="50" rowspan="2">Tanggal</th>
                                                                    <th width="100" rowspan="2">Hari</th>
                                                                    <th width="100" rowspan="2">Shift</th>
                                                                    <th width="160" colspan="2">Jam Kerja</th>
                                                                    <th width="160" colspan="2">Jam Absen</th>
                                                        
                                                                    <th width="100"  rowspan="2">Telat</th>
                                                                    <th width="100"  rowspan="2">P Awal</th>
                                                                    <th  rowspan="2">Keterangan</th>
                                                                   
                                                                
                                                                </tr>

                                                                <tr>
                                                                    <th width="100">  Masuk</th>
                                                                    <th width="100"> Pulang</th>
                                                                    <th width="100"> Masuk</th>
                                                                 
                                                                </tr>
                                                            </thead>

                                                           
                                                        <tbody>

                                                        <?php
                                                                    $totalTelat = 0;
                                                                    $totalPawal = 0;  

                                                                    $totalIzin = 0;
                                                                    $totalSakit = 0;
                                                                    $totalCuti = 0;


                                                                for ($t = 1; $t < $lastDate; $t++) {
                                                                    $tanggal = $periode . '-' . $t;
                                                                    $formatDate = date('Y-m-d', strtotime($tanggal));
                                                                    $day = date('l', strtotime($tanggal));
                                                                    $hari = getNamahari($tanggal);

                                                                    $absensiHarian  = $this->Presensi_model->getDataAbsensi($pin, $formatDate);
                                                                    if(!empty($absensiHarian)){
                                                                        $kodeShift         = $absensiHarian[0]->shift;
                                                                        $jamMasukKerja     = $absensiHarian[0]->jam_masuk;
                                                                        $jamKeluarKerja    = $absensiHarian[0]->jam_pulang;
                                                        
                                                                        $absenMasuk         = $absensiHarian[0]->masuk;
                                                                        $absenPulang        = $absensiHarian[0]->pulang;
                                                                        $keterangan_absen   = $absensiHarian[0]->keterangan;
    
                                                                        $telat         = $absensiHarian[0]->telat;
                                                                        $p_awal         = $absensiHarian[0]->p_awal;
                                                                    }else{
                                                                        $kodeShift         = '';
                                                                        $jamMasukKerja      = '';
                                                                        $jamKeluarKerja    = '';
                                                        
                                                                        $absenMasuk        = '';
                                                                        $absenPulang        = '';
                                                                        $keterangan_absen   = '';
    
                                                                        $telat         = 0;
                                                                        $p_awal         = 0;

                                                                    }
                                                                   
                                                                  

                                                                    if($kodeShift=='OFF'){
                                                                        $jamMasukKerja  = '';
                                                                        $jamKeluarKerja  = '';
                                                                        $bg_btn = 'btn btn-outline-danger';
                                                                     
                                                                    }else{
                                                                        $bg_btn = 'btn btn-outline-success';
                                                                    }

                                                                    if ( $absenMasuk =='CUTI') {
                                                                        $absenMasuk         = '<span class="text-success bg-success-subtle fs-2">CUTI</span>';
                                                                        $absenPulang        =  '<span class="text-success bg-success-subtle fs-2">CUTI</span>';
                                                                      }



                                                                    $totalTelat = $totalTelat+$telat;
                                                                    $totalPawal = $totalPawal+$p_awal;
                            

                                                                        echo ' 
                                                                         <input type="hidden" name="tanggal[]" value="'.$formatDate.'">  
                                                                        <tr>
                                                                                        <td class="text-center">' . $t . '</td>
                                                                                        <td class="text-center">' . $hari . '</td>
                                                                                        <td id="tr_'.$t.'" class="text-center">
                                                                                            <select name="shift[]" class="form-control">';

                                                                                            foreach ($data_shift_kerja as $listshift) {
                                                                                                $kode_shift = $listshift->kode_shift;
                                                                                                if($kodeShift == $kode_shift){
                                                                                                    $checkShift = 'selected';
                                                                                                }else{
                                                                                                    $checkShift = '';
                                                                                                }
                                                                                                echo ' <option value="'.$kode_shift.'" '.$checkShift .'>'.$listshift->kode_shift.'</option>';
                                                                                            }
                                                                                              
                                                                                            echo '</select>
                                                                                        </td>
                                                                                        <td class="text-darkblue text-center">'.$jamMasukKerja  .'</td>
                                                                                        <td class="text-darkblue  text-center">'.$jamKeluarKerja.'</td>
                                                                                        <td class="text-center">'.$absenMasuk.'</td>
                                                                                        <td class="text-center">'.$absenPulang.'</td>
                                                                                        <td class="text-center">'.$telat.'</td>
                                                                                        <td class="text-center">'. $p_awal.'</td>
                                                                                        <td style="text-align:left">'. $keterangan_absen.'</td>
                                                                                 
                                                                                        
                                                                                 </tr>';
                                
                                                                            

                                                                            

                                                                }


                                                                ?>

                                                            <tr>
                                                                <td colspan="7"></td>
                                                                <td><?php echo $totalTelat ;?></td>
                                                                <td><?php echo $totalPawal ;?></td>
                                                              
                                                            
                                                            </tr>


                                                           
                                                        </tbody>
                                                  </table>
                                            </div>

                                            </form>
                                     </div>
                              </div>
                        </div>

                        
                        
                   
                  </div><!--row-->

        
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
</html>