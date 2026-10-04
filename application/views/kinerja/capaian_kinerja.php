<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
         
         
         .loading-image{
              background: rgba(255,255,255,0.8) ;
              width: 100%;
              height: 100%;
              position: absolute;
              z-index: 888;
              text-align: center;
              display: none;
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
         
              <?php 
                
                    
                $id_pegawai = $this->session->userdata('id_pegawai');
                $message = $this->session->flashdata('message'); 
                $periode_bulan = $this->session->userdata('periode_bulan'); 
                $periode_tahun = $this->session->userdata('periode_tahun'); 

                if($periode_bulan=='') {
                  $bulan = date('m');
                  $tahun = date('Y');
    
                }else{
                  $bulan = $periode_bulan;
                  $tahun = $periode_tahun;
                }
                $periode = $tahun.'-'.$bulan;
                $periode = date('Y-m', strtotime($periode));

                $nama_bulan = getBulan($bulan);
                
                $nip = $detail_pegawai[0]->nip;
                $pin = substr($nip, -4);
                $jns_jam_kerja= $detail_pegawai[0]->jns_jam_kerja;
                $nama_pegawai = $detail_pegawai[0]->nama;
                $id_puskesmas = $detail_pegawai[0]->id_puskesmas;
                $puskesmas = $detail_pegawai[0]->puskesmas;
               
                $gaji_pokok= $detail_pegawai[0]->gaji_pokok;
                $pengkalian = $detail_pegawai[0]->pengkalian;
                $pph21 = $detail_pegawai[0]->pph21;
                $bpjs_kes= $detail_pegawai[0]->bpjs_kes;
                $bpjs_tk = $detail_pegawai[0]->bpjs_tk;
                $jabatan = $detail_pegawai[0]->jabatan;
                
             

                $tkd_pokok = ceil($gaji_pokok*$pengkalian);
                
                $pengurang = $pph21+$bpjs_kes+$bpjs_tk;


                $waktu_efektif = 6000;

                #print_array($detail_pegawai);
                $totalAktifitas   =  $this->Kinerja_model->getAktifitasApprove($id_pegawai, $periode);
                $rekap_absensi    =  $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
                $jmlh_cuti        =  $this->Presensi_model->getjumlahCuti($id_pegawai, $periode);
                $poinPerilaku     =  $this->Kinerja_model->getPoinPerilaku($id_pegawai, $periode_bulan, $periode_tahun);

                $serapan = SERAPAN;

                if($jmlh_cuti==''){
                   $jmlh_cuti = 0;
                }



                $menitPenambah       = $jmlh_cuti*300;
                $nilaiTotalAktifitas = $totalAktifitas+$menitPenambah;



                #print_array($detail_pegawai);
                if(empty($rekap_absensi)){
                   $telat = 0;
                   $pulang_awal = 0;
                   $izin = 0;
                   $sakit = 0;

                   $totalPengurang = 6000;
                  
                }else{
                   $telat = $rekap_absensi[0]->telat;
                   $pulang_awal = $rekap_absensi[0]->pulang_awal;
                   $izin = $rekap_absensi[0]->izin;
                   $sakit = $rekap_absensi[0]->sakit;
                   $sakit_dgn_sk = $rekap_absensi[0]->sakit_dgn_sk;

                   $menit_izin = $izin*300;
                   $menit_sakit = $sakit*300;
                   $menit_sakit_dgn_surat = $sakit_dgn_sk*150;


                   $totalPengurang = $telat+$pulang_awal+$menit_izin+$menit_sakit+$menit_sakit_dgn_surat;
                }


                $totalWaktuEfektif = $waktu_efektif-$totalPengurang; //total waktu efektif setelah dikurangi menit pengurangik


                #echo $totalWaktuEfektif;
                $nilaiLebihKecil  =  $totalWaktuEfektif;
                if ($totalWaktuEfektif > $nilaiTotalAktifitas) {
                  $nilaiLebihKecil  =  $nilaiTotalAktifitas;
                }


                $bobotAktifitas = ($nilaiLebihKecil/$waktu_efektif)*100;
                $bobotTotal     = round($bobotAktifitas*0.7, 2);
                $totalCapaian =  number_format($bobotTotal+$poinPerilaku+$serapan,2);
                $bruto = round(($tkd_pokok*$totalCapaian)/100);
               

                #print_array($rekapTKD);

                if(!empty($rekapTKD)){
                  $tkd_pokok = $rekapTKD[0]->tkd_pokok;
                  $capaian = $rekapTKD[0]->capaian;
                  $bruto  = $rekapTKD[0]->bruto;
                  $pph21 = $rekapTKD[0]->pph21;
                  $bpjs = $rekapTKD[0]->bpjs;
                  $bpjs_tk = $rekapTKD[0]->bpjs_tk;
                  $thp = $rekapTKD[0]->thp;
                  $masa_kerja = $rekapTKD[0]->masa_kerja;
                     
                }else{
                  $tkd_pokok = 0;
                  $capaian =  0;
                  $bruto  = 0;
                  $pph21 =  0;
                  $bpjs =  0;
                  $bpjs_tk =  0;
                  $thp =  0;
                  $masa_kerja = '';
                }
            ?>

                   
              <div class="row">
                <div class="col-md-12 mb-4">
                      <h4> <?php echo $nama_pegawai ;?>    <br>
                          <span class="text-muted fs-3"><?php echo $nip ;?></span>
                        </h4>
                        <h5 class="text-danger fs-3"><?php echo $puskesmas;?></h5>

                        <select class="form-select w-auto" id="change_periode">
                        <?php
                          $listBulan = array_bulan();


                          for ($i=1; $i < count($listBulan) ; $i++) { 

                            if($i==$bulan){
                              echo '<option value="'.$i.'/'.$tahun.'" selected>'.$listBulan[$i].' '.$tahun.'</option>';
                            }else{
                              echo '<option value="'.$i.'/'.$tahun.'">'.$listBulan[$i].'  '.$tahun.'</option>';
                            }
                             
                          }
                        ?>
                     
                      </select>
                  </div>

                  
              <div class="col-md-7">
                        <div class="card">
                          <div class="card-body">
                            <div class="row align-items-center">
                              <div class="loading-image">
                              <img src="<?php echo base_url();?>assets/images/loading_baru.gif" width="200">
                            </div>


                            <div class="col-2">
                                  <div class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-warning">
                              
                                    <i class="ti ti-chart-bar  fs-6"></i>
                                    
                                  </div>
                              </div>
                              <div class="col-10">
                                <h5 class="card-title mb-9 fw-semibold">
                                 Capaian Kinerja
                                </h5>
                                <h4 class="fw-semibold mb-3"><?php echo $capaian;?>%</h4>
                                <div class="d-flex align-items-center mb-3">
                                     Aktifitas :  &nbsp; <span class="fs-4 fw-bold text-success"><?php echo  $bobotTotal;?>%</span> &nbsp; &nbsp;  <span class="round-8 text-bg-success rounded-circle mx-2 d-inline-block"></span> &nbsp; &nbsp;
                                    Perilaku :  &nbsp; <span class="fs-4 fw-bold  text-warning"><?php echo $poinPerilaku ;?>%</span> &nbsp; &nbsp;   <span class="round-8 text-bg-success rounded-circle mx-2 d-inline-block"></span> &nbsp; &nbsp;
                                    Serapan :  &nbsp; <span class="fs-4 fw-bold  text-info"><?php echo $serapan;?>%</span>
                                </div>
                                
                              </div>
                                <div class="col-12">
                                    <div class="d-flex justify-content-end pt-4">
                                     <a href="<?php echo base_url();?>admin/capaian_kinerja/update_tkd/" class="btn btn-primary btn-sm"> 
                                     Detail  <i class="ti ti-arrow-up-right"></i></a>
                                    </div>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>


                    <div class="col-md-5">
                        <div class="card">
                          <div class="card-body">
                            <div class="row align-items-center">
                              <div class="col-2">
                                  <div class="round-40 rounded-circle text-white d-flex align-items-center justify-content-center text-bg-info">
                                    <i class="ti ti-credit-card fs-6"></i>
                                  </div>
                              </div>

                              <div class="col-10">
                              <div class="loading-image">
                              <img src="<?php echo base_url();?>assets/images/loading_baru.gif" width="200">
                            </div>
                                <h5 class="card-title mb-9 fw-semibold">
                                  Jumlah Penerimaan
                                </h5>
                                <h4 class="fw-semibold mb-3">Rp. <?php echo rupiah($thp);?></h4>
                              
                                <div>
                                  <div class="me-2">
                                    <span class="round-8 text-bg-primary rounded-circle me-2 d-inline-block"></span>
                                    <span class="fs-2">Total Penerimaan Tunjangan Kinerja <br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; <strong>  <?php echo $nama_bulan;?> <?php echo $tahun;?> </strong></span> 

                                    <br><br>
                                    <button type="button" id="detail_tkd"   data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg" class="btn btn-primary btn-sm ms-2 float-end">Detail  <i class="ti ti-arrow-up-right"></i></button>
                                 
                                 
                                  </div>
                                </div>
                              </div>
                            
                            </div>
                          </div>
                        </div>
                    </div>



                <?php


                    if(!empty($dataRekap)){
                      $telat = $dataRekap[0]->telat;
                      $pulang_awal = $dataRekap[0]->pulang_awal;
                      $izin = $dataRekap[0]->izin;
                      $sakit = $dataRekap[0]->sakit;
                      $sakit_dgn_sk = $dataRekap[0]->sakit_dgn_sk;
                    }else{
                      $telat = 0;
                      $pulang_awal =0;
                      $izin = 0;
                      $sakit =0;
                      $sakit_dgn_sk = 0;
                    }


                ?>

                    <div class="col-lg-6 ">
                      
                                    <h5>Kehadiran</h5> 
                                    <a href="<?php echo base_url();?>absensi/lihat_absensi/<?php echo $periode_bulan.'/'.$periode_tahun;?>" class="btn float-end btn-primary btn-sm" target="_blank"> 
                                     Detail  <i class="ti ti-arrow-up-right"></i></a>
                                     <div class="clearfix"></div><br>

                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Jenis Absensi</th>
                                            <th>Jumlah</th>
                                            
                                        </tr>
                                        <tr>
                                            <td class="text-info">Telat</td>
                                            <td class="text-end text-danger"><?php echo $telat;?>&nbsp; menit</td>
                                        </tr>
                                        <tr>
                                            <td class="text-info">Pulang Awal</td>
                                            <td class="text-end  text-danger"><?php echo $pulang_awal;?>&nbsp; menit</td>
                                        </tr>
                                        <tr>
                                            <td class="text-info">Izin</td>
                                            <td class="text-end  text-danger" ><?php echo $izin;?> &nbsp;hari</td>
                                        </tr>
                                        <tr>
                                            <td class="text-info">Sakit</td>
                                            <td class="text-end  text-danger"><?php echo $sakit;?> &nbsp;hari</td>
                                        </tr>
                                        <tr>
                                            <td class="text-info">Sakit dengan Surat Sakit</td>
                                            <td class="text-end  text-danger"><?php echo $sakit_dgn_sk;?>   &nbsp; hari</td>
                                        </tr>
                                    </table>
                            
                                
                              
                    </div>
                    
                      <div class="col-lg-6">
                      
                                <h5>Cuti</h5> 
                                <a href="<?php echo base_url();?>cuti/index" class="btn float-end btn-primary btn-sm" target="_blank"> 
                                     Detail  <i class="ti ti-arrow-up-right"></i></a>
                                     <div class="clearfix"></div><br>
                                <table class="table table-bordered">
                                        <tr>
                                            <th>Jenis Cuti</th>
                                            <th>Jumlah</th>
                                            
                                        </tr>
                                        <?php
                                       
                                     
                                            for ($i=0; $i < count($master_cuti); $i++) { 
                                                $jns_cuti = $master_cuti[$i]->id;

                                                $rekap_cuti = $this->Cuti_model->getRekapCutiByJnsCuti($id_pegawai, $periode, $jns_cuti);
                                                $jumlah_cuti = $rekap_cuti[0]->jumlah;
                                                if($jumlah_cuti==''){
                                                  $jumlah_cuti = 0;
                                                }
                                                #print_array($rekap_cuti);
                                               echo ' <tr>
                                                            <td class="text-info">'.$master_cuti[$i]->jenis_cuti.'</td>
                                                            <td class="text-end  text-danger">'.$jumlah_cuti.' &nbsp; hari</td>
                                                        </tr>';
                                            }
                                        ?>
                                       
                                        
                                    </table>
                            
                            
                    </div>

              </div>
            </div>
           
                  <div class="modal fade" id="bs-example-modal-xlg" tabindex="-1"
                      aria-labelledby="bs-example-modal-lg" aria-hidden="true">
                      <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="myLargeModalLabel">
                                    Perhitungan Tunjangan Kinerja
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                  </div>
                                  <div class="modal-body">

                                  <table class="table table-bordered">
                                        <tr>
                                          <th colspan="4" class=" text-primary fs-4"><strong>Pokok</strong></th>
                                        </tr>
                                        <tr>
                                          <td> 
                                             <label for="" class="text-muted">Gaji Pokok</label>
                                             <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($gaji_pokok);?></h5>
                                             <span class="fs-2 text-muted"> Masa kerja : </span> <?php echo $masa_kerja;?>
                                          </td>
                                          <td>
                                              <label for="" class="text-muted">Pengkalian</label>
                                              <h5 class="fw-semibold mb-3"><?php echo $pengkalian;?></h5>
                                              <span class="fs-2 text-muted"> Jabatan : </span> <?php echo $jabatan;?>
                                          </td>
                                          <td>
                                              <label for="" class="text-muted">TKD Pokok</label>
                                              <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($tkd_pokok);?></h5>
                                          </td>
                                          <td> 
                                             <label for="" class="text-muted">TKD Bruto</label>
                                             <h5 class="fw-semibold mb-3  text-info">Rp. <?php echo rupiah($bruto);?></h5>
                                             <span class="fs-2">TKD Bruto  <span class="text-muted">  x </span>  Capaian kinerja </span> 
                                          </td>
                                        </tr>

                                        <tr>
                                          <th colspan="4" class=" text-warning fs-4"><strong>Pengurang</strong></th>
                                        </tr>
                                        <tr>
                                         
                                          <td>
                                              <label for="" class="text-muted">Pajak (PPh21)</label>
                                              <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($pph21);?></h5>
                                          </td>
                                          <td>
                                              <label for=""  class="text-muted">BPJS Kesehatan</label>
                                              <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($bpjs_kes);?></h5>
                                          </td>
                                          <td>
                                              <label for="" class="text-muted">BPJS Ketenagakerjaan</label>
                                              <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($bpjs_tk);?></h5>
                                          </td>
                                          <td>
                                              <label for="" class="text-muted">Total Pengurang</label>
                                              <h5 class="fw-semibold mb-3 text-danger">Rp. <?php echo rupiah($pengurang);?></h5>
                                          </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"><strong class=" fs-4 text-success">Penerimaan</strong>
                                           <br>
                                           <label for="" class="text-muted">TKD Bruto - Pengurang</label>
                                        </td>
                                            <td>
                                            <label for="" class="text-muted">Total THP</label>
                                              <h5 class="fw-semibold mb-3 text-success">Rp. <?php echo rupiah($thp);?></h5>
                                            </td>
                                        </tr>
                                        

                                  </table>
                                    


                                  </div>
                                  <div class="modal-footer">
                                      <button type="button"
                                      class="btn bg-danger-subtle text-danger font-medium waves-effect text-start"
                                      data-bs-dismiss="modal"> Close </button>
                                  </div>
                              </div>
                            <!-- /.modal-content -->
                            </div>

                        <!-- /.modal-dialog -->
                        </div>
                      <!-- /.modal -->
                      </div>
                  <div>

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

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

</body>

<script>
    
    $("#change_periode").change(function(){
              var periode = $(this).val();
              var explod = periode.split("/");
              var bulan  = explod[0];
              var tahun = explod[1];
              $(".loading-image").show();
             
              // alert(tahun);
              // return false;

              $.ajax({
                          
                          type:"POST",
                          dataType:"html",
                          url:"<?php echo base_url();?>dashboard/set_session_periode",
                          data:"bulan="+bulan+"&tahun="+tahun,
                          success:function(msg){
                            //return false;
                            window.location.reload();
                            //$("#modal-form").html(msg);
                            //console.log(msg);
                          }
                      
                    });

            });

</script>


</html>