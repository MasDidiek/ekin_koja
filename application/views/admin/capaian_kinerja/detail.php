<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>

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


                <?php $this->load->view('layout/section/sidebar'); ?>

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
            <?php $this->load->view('layout/section/header'); ?>
            <!--  Header End -->


            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Capaian Kinerja Pegawai</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Capaian Kinerja Pegawai</li>
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


                    $id_pegawai = $this->uri->segment(4);
                    $message = $this->session->flashdata('message');
                    $periode_bulan = $this->session->userdata('periode_bulan');
                    $periode_tahun = $this->session->userdata('periode_tahun');
                    $usergroup = $this->session->userdata('usergroup');
                    $id_pj_sess = $this->session->userdata('id_pj');


                    if ($periode_bulan == '') {
                        $bulan = date('m');
                        $tahun = date('Y');
                    } else {
                        $bulan = $periode_bulan;
                        $tahun = $periode_tahun;
                    }

                    $periode = $periode_tahun . '-' . $periode_bulan;
                    $periode = date('Y-m', strtotime($periode));

                    $nm_bulan = getBulan($bulan);
                    $listBulan = array_bulan();

                    #print_array($dataRekap);
                    $jmlh_cuti        =  $this->Presensi_model->getjumlahCuti($id_pegawai, $periode);

                    if ($jmlh_cuti == '') {
                        $jmlh_cuti = 0;
                    }

                    ?>


                    <div class="row">

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">

                                    <div class="table-responsive mt-4">
                                        <table class="table  table-sm  table-hover" id="data-table">
                                            <thead>
                                                <tr>

                                                    <th class="w-1">No.</th>
                                                    <th>Nama kegiatan</th>
                                                    <th>Waktu</th>
                                                    <th>Volume</th>
                                                    <th>Waktu Efektif</th>
                                                    <th>Total</th>
                                                    <th>Status</th>


                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($periode_bulan, $periode_tahun);
                                                $waktu_efektif_bulan  = $jumlahHariKerja * 300;


                                                $no = 1;
                                                $totalInput = 0;
                                                foreach ($aktifitas as $listdata) {
                                                    $tgl = $listdata->tgl;
                                                    $jns_kegiatan = $listdata->jns_kegiatan;
                                                    $id_indikator = $listdata->id_indikator;
                                                    $nama_kegiatan = $listdata->nama_kegiatan;
                                                    $jam_mulai = $listdata->jam_mulai;
                                                    $jam_selesai = $listdata->jam_selesai;
                                                    $volume = $listdata->volume;
                                                    $waktu_efektif = $listdata->waktu_efektif;
                                                    $total = $listdata->total;
                                                    $status = $listdata->status;


                                                    $totalInput = $totalInput + $total;

                                                    if ($status == 1) {
                                                        $flag = '<span class="badge bg-success">Approved</span>';
                                                    } else {
                                                        $flag = '<span class="badge bg-warning">Pending</span>';
                                                    }

                                                    echo '<tr>

                                                        <td class="text-center">' . $no . '</td>
                                                        <td>' . $nama_kegiatan . '</td>
                                                        <td class="text-center">' .  format_view($tgl) . ', &nbsp;&nbsp;' .  $jam_mulai . ' - ' .  $jam_selesai . '</td>
                                                        <td class="text-center">' . $volume . '</td>
                                                        <td class="text-center">' . $waktu_efektif . '</td>
                                                        <td class="text-center">' . $total . '</td>
                                                        <td class="text-center">' . $flag . '</td>
                                                        </tr>';

                                                    $no += 1;
                                                }

                                                ?>







                                            </tbody>

                                            <tr>
                                                <td colspan="5">
                                                    <strong> Total</strong>
                                                </td>
                                                <td><strong><?php echo rupiah($totalInput); ?></strong></td>
                                            </tr>
                                        </table>

                                        <?php

                                        $telat = $dataRekap[0]->telat;
                                        $pulang_awal = $dataRekap[0]->pulang_awal;
                                        $izin = $dataRekap[0]->izin;
                                        $sakit = $dataRekap[0]->sakit;
                                        $sakit_dgn_sk = $dataRekap[0]->sakit_dgn_sk;
                                        $alpha = $dataRekap[0]->alpha;

                                        $izinMenit = $izin * 300;
                                        $sakitMenit = $sakit * 300;
                                        $alphaMenit = $alpha * 450;
                                        $sakit_dgn_skMenit = $sakit_dgn_sk * 150;

                                        $totalPengurang = $telat + $pulang_awal + $izinMenit + $sakitMenit + $alphaMenit + $sakit_dgn_skMenit;

                                        $waktuEfektifTotal = $waktu_efektif_bulan - $totalPengurang;

                                        $cuti = 0;
                                        $totalPenambah = 0;

                                        $totalWaktuKinerja = $totalInput + $totalPengurang;


                                        ?>

                                        <h4>Waktu Efektif : <?php echo  rupiah($waktu_efektif_bulan); ?></h4>
                                        <br>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <h5>Menit Pengurang</h5>
                                                <br>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>Terlambat</td>
                                                        <td class="text-end"><?php echo  $telat; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pulang Awal</td>
                                                        <td class="text-end"><?php echo  $pulang_awal; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Izin</td>
                                                        <td class="text-end"><?php echo  $izin; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sakit</td>
                                                        <td class="text-end"><?php echo  $sakit; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sakit Dengan Surat</td>
                                                        <td class="text-end"><?php echo  $sakit_dgn_sk; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Alpha</td>
                                                        <td class="text-end"><?php echo  $alpha; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Waktu Efektif</th>
                                                        <th class="text-end"><?php echo  rupiah($waktuEfektifTotal); ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-md-3">
                                                <h5>Menit Penambah</h5>
                                                <br>
                                                <table class="table table-bordered">
                                                    <tr>
                                                        <td>Cuti</td>
                                                        <td><?php echo $jmlh_cuti; ?></td>
                                                    </tr>

                                                    <tr>
                                                        <th>Total Waktu Kinerja</th>
                                                        <th><?php echo  rupiah($totalWaktuKinerja); ?></td>
                                                    </tr>


                                                </table>

                                            </div>
                                            <?php

                                            $nilaiLebihKecil  =  $waktuEfektifTotal;


                                            if ($waktuEfektifTotal > $totalWaktuKinerja) {
                                                $nilaiLebihKecil  =  $totalWaktuKinerja;
                                            }


                                            $bobotAktifitas = ($nilaiLebihKecil / $waktu_efektif_bulan) * 100;


                                            ?>

                                            <div class="col-md-5">
                                                <h5>Perhitungan Bobot Aktifitas</h5>

                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td class="text-end"> <strong> Bobot Aktifitas &nbsp;=</strong> &nbsp;</td>
                                                        <td class="text-center"> <span style="text-decoration: underline;">min ( Total Waktu Efektif, Total Waktu Kinerja )</span>
                                                            <br> Waktu Efektif bulan
                                                        </td>
                                                        <td>x 100</td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-end"> <strong> &nbsp;=</strong> &nbsp;</td>
                                                        <td class="text-center"> <span style="text-decoration: underline;">min (<?php echo  rupiah($waktuEfektifTotal); ?>, <?php echo  rupiah($totalWaktuKinerja); ?> )</span>
                                                            <br> <?php echo  rupiah($waktu_efektif_bulan); ?>
                                                        </td>
                                                        <td>x 100</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end"> <strong> &nbsp;=</strong> &nbsp;</td>
                                                        <td class="text-center"> <span style="text-decoration: underline;"> <?php echo  rupiah($nilaiLebihKecil); ?> </span>
                                                            <br> <?php echo  rupiah($waktu_efektif_bulan); ?>
                                                        </td>
                                                        <td>x 100</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end"> <strong> &nbsp;=</strong> &nbsp;</td>
                                                        <td class="text-center"> <?php echo  number_format($bobotAktifitas, 2); ?></td>
                                                        <td></td>
                                                    </tr>

                                                    <tr>
                                                        <td class="text-end"> <strong> Nilai Aktifitas &nbsp;=</strong> &nbsp;</td>
                                                        <td class="text-center">Bobot Aktifitas &nbsp; x &nbsp;70%</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end"> <strong> &nbsp;=</strong> &nbsp;</td>
                                                        <td class="text-center"><?php echo  number_format($bobotAktifitas, 2); ?> &nbsp; x &nbsp;70%</td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-end"> <strong> &nbsp;=</strong> &nbsp;</td>
                                                        <td class="text-center fs-4"> <strong><?php echo  number_format($bobotAktifitas * 0.7, 2); ?> %</strong> </td>
                                                        <td></td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>


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


                <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

                <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

</body>





</html>