<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
     body{
        background-color:#F8F8F8;
    }

    /* Profile Image */
.profile-image {
    position: relative;
    width: 100%;
    height: 150px;
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
}

.profile-image img {
    width: 80%;
    height: 80%;
    object-fit: cover;
    border-radius: 50%;
}
  </style>
</head>

<body>


  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
        <!-- Start Vertical Layout Sidebar -->
        <?php $this->load->view('layout/section/sidebar'); ?>
    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header'); ?>
      <!--  Header End -->


      <div class="body-wrapper">
        <div class="container-fluid">

          <?php
          $message = $this->session->flashdata('message');
          $periode_bulan = $this->session->userdata('periode_bulan');
          $periode_tahun = $this->session->userdata('periode_tahun');
          $nm_bulan = getBulan($periode_bulan);
          $periode = $periode_tahun . '-' . $periode_bulan;
          $periode = date('Y-m', strtotime($periode));
          $id_pegawai = $detail_pegawai[0]->id_pegawai;
          $nip = $detail_pegawai[0]->nip;
          $pin = substr($nip, -4);
          $jns_jam_kerja = $detail_pegawai[0]->jns_jam_kerja;
          $nama_pegawai = $detail_pegawai[0]->nama;
          $puskesmas = $detail_pegawai[0]->puskesmas;
          //print_array($detail_pegawai);
          $jabatan = $detail_pegawai[0]->jabatan;
          $gaji_pokok = $detail_pegawai[0]->gaji_pokok;
          $pengkalian = $detail_pegawai[0]->pengkalian;
          $pph21 = $detail_pegawai[0]->pph21;
          $bpjs_kes = $detail_pegawai[0]->bpjs_kes;
          $bpjs_tk = $detail_pegawai[0]->bpjs_tk;
          $status_kerja = $detail_pegawai[0]->status_kerja;
          
          $tkd_pokok = ceil($gaji_pokok * $pengkalian);

          $pengurang = $pph21 + $bpjs_kes + $bpjs_tk;

          $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($periode_bulan, $periode_tahun);
          $waktu_efektif  = $jumlahHariKerja * 300;

          $poinPerilaku     =  $this->Kinerja_model->getPoinPerilaku($id_pegawai, $periode_bulan, $periode_tahun);
          $totalAktifitas   =  $this->Kinerja_model->getAktifitasApprove($id_pegawai, $periode);
          $rekap_absensi    =  $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
          $jmlh_cuti        =  $this->Presensi_model->getjumlahCuti($id_pegawai, $periode);

          if (!empty($rekap_absensi)) {
              $absen = $rekap_absensi[0];
          } else {
              $absen = new stdClass();
              $absen->telat = 0;
              $absen->pulang_awal = 0;
              $absen->izin = 0;
              $absen->sakit = 0;
              $absen->alpha = 0;
              $absen->sakit_dgn_sk = 0;
              $absen->cuti = 0;
              $absen->dl_penuh = 0;
          }

          //print_array($absen);

          // Data absensi
          $telat        = $absen->telat;
          $pulang_awal  = $absen->pulang_awal;
          $izin         = $absen->izin * 300;
          $sakit        = $absen->sakit * 300;
          $alpha        = $absen->alpha * 450;
          $sakit_sk     = $absen->sakit_dgn_sk * 150;

          // Total pengurang
          $totalPengurang =
              $telat +
              $pulang_awal +
              $izin +
              $sakit +
              $alpha +
              $sakit_sk;

          $serapan = SERAPAN;
          #print_array($detail_pegawai)

          if ($jmlh_cuti == '') {
            $jmlh_cuti = 0;
          }

          $menitPenambah       = $jmlh_cuti * 300;
          $nilaiTotalAktifitas = $totalAktifitas + $menitPenambah;
          $totalWaktuEfektif = $waktu_efektif - $totalPengurang; //total waktu efektif setelah dikurangi menit pengurangik
          #echo $totalWaktuEfektif;
          $nilaiLebihKecil  =  $totalWaktuEfektif;

          if ($totalWaktuEfektif > $nilaiTotalAktifitas) {
            $nilaiLebihKecil  =  $nilaiTotalAktifitas;
          }

          $bobotAktifitas = ($nilaiLebihKecil / $waktu_efektif) * 100;
          $bobotTotal     = round($bobotAktifitas * 0.7, 2);
          $totalCapaian =  number_format($bobotTotal + $poinPerilaku + $serapan, 2);
          #echo $totalCapaian;
          $bruto = round(($tkd_pokok * $totalCapaian) / 100);

          if (!empty($rekapTKD)) {
            $tkd_pokok = $rekapTKD[0]->tkd_pokok;
            $capaian = $rekapTKD[0]->capaian;
            $bruto  = $rekapTKD[0]->bruto;
            $pph21 = $rekapTKD[0]->pph21;
            $bpjs = $rekapTKD[0]->bpjs;
            $bpjs_tk = $rekapTKD[0]->bpjs_tk;
            $thp = $rekapTKD[0]->thp;
          } else {
            $tkd_pokok = 0;
            $capaian =  0;
            $bruto  = 0;
            $pph21 =  0;
            $bpjs =  0;
            $bpjs_tk =  0;
            $thp =  0;
          }

          ?>


          <div class="row">
    <!-- Header Pegawai -->

          <div class="col-md-8">
              <div class="card">
                  <div class="card-body">
                      <div class="row align-items-center">
                          <div class="col-2">
                              <div class="profile-image">
                                <img src="<?php echo base_url();?>uploads/photo_profile/avatar.png" alt="User Photo">
                            </div>
                          </div>
                          <div class="col-10">
                              <h5 class="card-title fw-semibold"><?php echo $nama_pegawai; ?></h5>
                              <span><?php echo $jabatan; ?></span> <br>
                              <span class="text-muted fs-3"><?php echo $nip; ?></span>
                              <h5 class="text-danger fs-3"><?php echo $puskesmas; ?></h5>

                          </div>
                          <div class="col-12 border-top pt-3 mt-3">
                             <h5 class="card-title mb-1 fw-semibold">Capaian Kinerja</h5>
                             Periode : <strong><?php echo $nm_bulan; ?> <?php echo $periode_tahun; ?></strong>
                              <h4 class="fw-semibold mb-3 mt-4"><?php echo $capaian; ?>%</h4>
                              
                              <!-- Visualisasi progres dengan progress bar -->
                              <div class="progress mb-3" style="height: 20px;">
                                  <div class="progress-bar bg-success" style="width: <?php echo $bobotTotal; ?>%;" role="progressbar" aria-valuenow="<?php echo $bobotTotal; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                  <div class="progress-bar bg-warning" style="width: <?php echo $poinPerilaku; ?>%;" role="progressbar" aria-valuenow="<?php echo $poinPerilaku; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                  <div class="progress-bar bg-info" style="width: <?php echo $serapan; ?>%;" role="progressbar" aria-valuenow="<?php echo $serapan; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                              </div>

                              <div class="d-flex align-items-center mb-3">
                                  <span class="fs-4 fw-bold text-success"><?php echo $bobotTotal; ?>% Aktifitas</span>
                                  <span class="fs-4 fw-bold text-warning ms-3"><?php echo $poinPerilaku; ?>% Perilaku</span>
                                  <span class="fs-4 fw-bold text-info ms-3"><?php echo $serapan; ?>% Serapan</span>
                              </div>


                               <?php if ($status_kerja == 2) { ?>
                                  <span class="round-8 text-bg-primary rounded-circle me-2 d-inline-block"></span>  
                                  <span> Cuti bersalin</span>
                              <?php } ?>
                             
                                  <input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $id_pegawai; ?>">
                                  <input type="hidden" name="bobot" id="bobot" value="<?php echo $bobotTotal; ?>">
                                  <input type="hidden" name="perilaku" id="perilaku" value="<?php echo $poinPerilaku; ?>">
                                  <input type="hidden" name="serapan" id="serapan" value="<?php echo $serapan; ?>">
                                  <div class="d-flex justify-content-end pt-4" id="return_update">
                                      <a href="<?php echo base_url(); ?>admin/capaian_kinerja/update_capaian_pegawai/<?php echo $id_pegawai . '/' . $nip.'/'.$periode_bulan.'/'.$periode_tahun; ?>" class="btn btn-success update-btn me-2">Update &nbsp; <i class="fas fa-refresh"></i></a>
                                      <a href="<?php echo base_url(); ?>admin/capaian_kinerja/lihat_capaian/<?php echo $id_pegawai . '/' . $nip; ?>" class="btn btn-primary">Lihat Detail&nbsp; <i class="ti ti-arrow-up-right"></i></a>
                                  </div>
                            

                          </div>
                      </div>
                  </div>
              </div>
          </div>



        <!-- Jumlah Penerimaan -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                      
                        <div class="col-12">
                            <h5 class="card-title mb-9 fw-semibold">Jumlah Penerimaan</h5>
                            <h4 class="fw-semibold mb-3">Rp. <?php echo rupiah($thp); ?></h4>
                            <span class="round-8 text-bg-primary rounded-circle me-2 d-inline-block"></span>
                            <span class="fs-2">Total Penerimaan Tunjangan Kinerja <br>&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; <strong> <?php echo  $nm_bulan; ?> <?php echo  $periode_tahun; ?> </strong></span>
                            <br><br>

                            <table class="table table-sm table-borderless">
                              <tr>
                                <td>TKD Pokok</td>
                                <td class="text-end">Rp. <?php echo rupiah($tkd_pokok); ?></td>
                              </tr>
                              <tr>
                                <td>TKD Bruto</td>
                                <td class="text-end">Rp. <?php echo rupiah($bruto); ?></td>
                              </tr>
                               <tr>
                                <td>Pajak </td>
                                <td class="text-end">Rp. <?php echo rupiah($pph21); ?></td>
                              </tr>
                                 <tr>
                                <td>BPJS </td>
                                <td class="text-end">Rp. <?php echo rupiah($bpjs); ?></td>
                              </tr>
                                <tr>
                                <td>BPJS TK </td>
                                <td class="text-end">Rp. <?php echo rupiah($bpjs_tk); ?></td>
                              </tr>
                              <tr>
                                <td>Total Pengurang</td>
                                <td class="text-end">Rp. <?php echo rupiah($pengurang); ?></td> 
                              </tr>
                              <tr>
                                <td>Total THP</td>
                                <td class="text-end">Rp. <?php echo rupiah($thp); ?></td> 
                              </tr>
                            </table>


                            <button type="button" id="detail_tkd" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg" class="btn btn-primary btn-sm ms-2 float-end">Detail <i class="ti ti-arrow-up-right"></i></button>
                            <a href="<?php echo base_url(); ?>admin/capaian_kinerja/update_tkd/<?php echo $id_pegawai . '/' . $nip . '/' . $totalCapaian . '/' . $periode; ?>" class="btn btn-success btn-sm float-end">Update &nbsp; <i class="fas fa-refresh"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <!-- Kehadiran -->
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
    
            <h5>Kehadiran</h5>
              <table class="table table-bordered">
                  <tr><th>Jenis Absensi</th><th>Jumlah</th></tr>
                  <tr><td class="text-info">Telat</td><td class="text-end text-danger"><?php echo $telat; ?>&nbsp; menit</td></tr>
                  <tr><td class="text-info">Pulang Awal</td><td class="text-end text-danger"><?php echo $pulang_awal; ?>&nbsp; menit</td></tr>
                  <tr><td class="text-info">Izin</td><td class="text-end text-danger"><?php echo $izin; ?>&nbsp; hari</td></tr>
                  <tr><td class="text-info">Sakit</td><td class="text-end text-danger"><?php echo $sakit; ?>&nbsp; hari</td></tr>
                  <tr><td class="text-info">Sakit dengan Surat Sakit</td><td class="text-end text-danger"><?php echo $sakit_sk; ?>&nbsp; hari</td></tr>
              </table>

                 <a href="<?php echo base_url(); ?>admin/presensi/lihat_absensi_pegawai/<?php echo $id_pegawai . '/' . $pin; ?>" class="btn btn-primary btn-sm float-end" target="_blank">
                  Lihat Absensi <i class="ti ti-arrow-up-right"></i></a>
          </div>
      </div>
    </div>
    

    <!-- Cuti -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-body">
            <h5>Cuti</h5>
            <table class="table table-bordered">
                <tr><th>Jenis Cuti</th><th>Jumlah</th></tr>
                <?php foreach($master_cuti as $cuti) {
                    $rekap_cuti = $this->Cuti_model->getRekapCutiByJnsCuti($id_pegawai, $periode, $cuti->id);
                    $jumlah_cuti = $rekap_cuti[0]->jumlah ?: 0;
                ?>
                <tr><td class="text-info"><?php echo $cuti->jenis_cuti; ?></td><td class="text-end text-danger"><?php echo $jumlah_cuti; ?>&nbsp; hari</td></tr>
                <?php } ?>
            </table>
        </div>
       </div>
    </div>
</div>


        <div class="modal fade" id="bs-example-modal-xlg" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header d-flex align-items-center">
                <h4 class="modal-title" id="myLargeModalLabel">
                  Perhitungan Tunjangan Kinerja
                </h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">

                <table class="table table-bordered">
                  <tr>
                    <th colspan="4" class=" text-primary fs-4"><strong>Pokok</strong></th>
                  </tr>
                  <tr>
                    <td>
                      <label for="" class="text-muted">Gaji Pokok</label>
                      <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($gaji_pokok); ?></h5>
                      <span class="fs-2 text-muted"> Masa kerja : 2 tahun 6 bulan</span>
                    </td>
                    <td>
                      <label for="" class="text-muted">Pengkalian</label>
                      <h5 class="fw-semibold mb-3"><?php echo $pengkalian; ?></h5>
                      <span class="fs-2 text-muted"> Jabatan : Dokter Umum</span>
                    </td>
                    <td>
                      <label for="" class="text-muted">TKD Pokok</label>
                      <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($tkd_pokok); ?></h5>
                    </td>
                    <td>
                      <label for="" class="text-muted">TKD Bruto</label>
                      <h5 class="fw-semibold mb-3  text-info">Rp. <?php echo rupiah($bruto); ?></h5>
                      <span class="fs-2">TKD Bruto <span class="text-muted"> x </span> Capaian kinerja </span>
                    </td>
                  </tr>

                  <tr>
                    <th colspan="4" class=" text-warning fs-4"><strong>Pengurang</strong></th>
                  </tr>
                  <tr>

                    <td>
                      <label for="" class="text-muted">Pajak (PPh21)</label>
                      <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($pph21); ?></h5>
                    </td>
                    <td>
                      <label for="" class="text-muted">BPJS Kesehatan</label>
                      <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($bpjs_kes); ?></h5>
                    </td>
                    <td>
                      <label for="" class="text-muted">BPJS Ketenagakerjaan</label>
                      <h5 class="fw-semibold mb-3">Rp. <?php echo rupiah($bpjs_tk); ?></h5>
                    </td>
                    <td>
                      <label for="" class="text-muted">Total Pengurang</label>
                      <h5 class="fw-semibold mb-3 text-danger">Rp. <?php echo rupiah($pengurang); ?></h5>
                    </td>
                  </tr>
                  <tr>
                    <td colspan="3"><strong class=" fs-4 text-success">Penerimaan</strong>
                      <br>
                      <label for="" class="text-muted">TKD Bruto - Pengurang</label>
                    </td>
                    <td>
                      <label for="" class="text-muted">Total THP</label>
                      <h5 class="fw-semibold mb-3 text-success">Rp. <?php echo rupiah($thp); ?></h5>
                    </td>
                  </tr>


                </table>



              </div>
              <div class="modal-footer">
                <button type="button" class="btn bg-danger-subtle text-danger font-medium waves-effect text-start" data-bs-dismiss="modal"> Close </button>
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

        <?php $this->load->view('layout/section/theme-setting.php'); ?>

        <?php $this->load->view('master/request-cuti.php'); ?>

      </div>
      <div class="dark-transparent sidebartoggler"></div>
      <!-- Import Js Files -->

      <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
      <script src="../assets/js/app.init.js"></script>
      <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
      <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

</body>

<script>
  var pesan = '<?php echo $message; ?>';
  if (pesan != '') {
    toastr.success(pesan, "Success!");
  }


  $(document).ready(function() {

    $(".update-btn").click(function() {
     //lert('Update capaian kinerja?');
      $(this).addClass("disabled").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
        setTimeout(function() {
            $(".update-btn").removeClass("disabled").html('Update &nbsp; <i class="fas fa-refresh"></i>');
          }, 2000);
    });
  });
</script>


</html>