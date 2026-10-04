<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        tr td {
            font-weight: 100;
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>

</head>

<body>

    <!-- Preloader -->

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
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Lihat Capaian Kinerja Pegawai</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Lihat Capaian Kinerja Pegawai</li>
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


                    $jns_pegawai = $this->uri->segment(4);
                    $usergroup = $this->session->userdata('usergroup');
                    $id_pj_sess = $this->session->userdata('id_pj');


                    $message = $this->session->flashdata('message');
                    $link = base_url() . 'admin/penilaian_kinerja/';


                    //print_array($rekap_absen);
                    $listBulan = array_bulan();

                    $waktuEfektif = $hariKerja * 300;


                    ?>

                    <div class="card">
                        <div class="card-body">



                            <div class="row">

                                <div class="table-responsive mt-3">
                                    <table class="table">
                                        <tr>
                                            <th>Jumlah Menit Efektif</th>
                                            <th class="text-end"><?php echo rupiah($waktuEfektif); ?> menit</th>
                                        </tr>
                                        <tr>
                                            <th>Menit Pengurang</th>
                                            <th>
                                                <table class="table table-sm table-bordered" width="100%">
                                                    <tr>
                                                        <th>Jenis Absen</th>
                                                        <th align="center">Lama (hari)</th>

                                                        <th class="text-end">Menit</th>

                                                    </tr>

                                                    <?php


                                                    $totalMenitPengurang = $rekap_absen[0]->telat + $rekap_absen[0]->pulang_awal;

                                                    $izinMenit = $rekap_absen[0]->izin * 300;
                                                    $sakitMenit = $rekap_absen[0]->sakit * 300;
                                                    $sakit_dgn_skMenit = $rekap_absen[0]->sakit_dgn_sk * 150;

                                                    $totalMenitPengurang =   $totalMenitPengurang + $izinMenit + $sakitMenit + $sakit_dgn_skMenit;

                                                    ?>
                                                    <tr>
                                                        <td>Telat</td>
                                                        <td align="center">-</td>
                                                        <td class="text-end"><?php echo $rekap_absen[0]->telat; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Pulang Awal</td>
                                                        <td align="center"></td>
                                                        <td class="text-end"><?php echo $rekap_absen[0]->pulang_awal; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Izin</td>
                                                        <td align="center"><?= $rekap_absen[0]->izin; ?></td>
                                                        <td class="text-end"><?php echo $rekap_absen[0]->izin * 300; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sakit</td>
                                                        <td align="center"><?= $rekap_absen[0]->sakit; ?></td>
                                                        <td class="text-end"><?php echo $rekap_absen[0]->sakit * 300; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Sakit dengan Surat</td>
                                                        <td align="center"><?= $rekap_absen[0]->sakit_dgn_sk; ?></td>
                                                        <td class="text-end"><?php echo $rekap_absen[0]->sakit_dgn_sk * 150; ?></td>
                                                    </tr>

                                                    <tr class="bg-info">
                                                        <th colspan="2">Total Menit Pengurang</th>
                                                        <th class="text-end"><?= rupiah($totalMenitPengurang); ?> </th>
                                                    </tr>
                                                </table>

                                            </th>
                                        </tr>

                                        <?php

                                        $jenisCuti = [
                                            1 => 'Cuti Tahunan',
                                            2 => 'Cuti Bersalin',
                                            3 => 'Cuti Alasan Penting',
                                            4 => 'Cuti Sakit',
                                            5 => 'Cuti Besar'
                                        ];

                                        $cutiMap = [];

                                        foreach ($rekap_cuti as $row) {
                                            $cutiMap[$row->jns_cuti][$row->status] = $row->total_hari;
                                        }

                                        $totalMenitPenambah = 0;
                                        ?>

                                        <tr>
                                            <th>Menit Penambah</th>
                                            <th>
                                                <table class="table table-sm table-bordered" width="100%">
                                                    <tr>
                                                        <th>Jenis Cuti</th>
                                                        <th align="center">Lama Cuti (hari)</th>
                                                        <th class="text-start">Status</th>
                                                        <th class="text-end">Menit</th>

                                                    </tr>

                                                    <?php foreach ($jenisCuti as $kode => $nama) : ?>

                                                        <?php
                                                        $approve = isset($cutiMap[$kode]['APPROVE']) ? $cutiMap[$kode]['APPROVE'] : 0;
                                                        $pending = isset($cutiMap[$kode]['PENDING']) ? $cutiMap[$kode]['PENDING'] : 0;
                                                        $reject  = isset($cutiMap[$kode]['REJECT'])  ? $cutiMap[$kode]['REJECT']  : 0;

                                                        if ($approve > 0) {
                                                            $statusText = 'APPROVE';
                                                            $hari = $approve;
                                                        } elseif ($pending > 0) {
                                                            $statusText = 'PENDING';
                                                            $hari = $pending;
                                                        } elseif ($reject > 0) {
                                                            $statusText = 'REJECT';
                                                            $hari = $reject;
                                                        } else {
                                                            $statusText = '-';
                                                            $hari = 0;
                                                        }


                                                        $menitCuti = $hari * 300;
                                                        $totalMenitPenambah = $totalMenitPenambah + $menitCuti;
                                                        ?>

                                                        <tr>
                                                            <td><?php echo $nama; ?></td>
                                                            <td class="text-center"><?php echo $hari; ?> hari</td>
                                                            <td class="text-center"><?php echo $statusText; ?></td>
                                                            <td class="text-end"><?php echo ($hari * 300); ?> </td>
                                                        </tr>


                                                    <?php endforeach; ?>
                                                    <tr class="bg-info">
                                                        <th colspan="3">Total Menit Penambah</th>
                                                        <th class="text-end"><?= rupiah($totalMenitPenambah); ?> </th>
                                                    </tr>
                                                </table>


                                            </th>
                                        </tr>

                                        <tr>
                                            <th>Menit Input Aktifitas</th>
                                            <th class="text-end text-primary"><?php echo rupiah($inputKinerja); ?> menit</th>
                                        </tr>

                                        <tr>
                                            <th>Menit Aktifitas = Menit Input Aktifitas+ Menit Penambah</th>
                                            <th class="text-end text-success"><?php echo rupiah($inputKinerja + $totalMenitPenambah); ?> menit</th>
                                        </tr>

                                        <tr>
                                            <th>
                                                Menit Efektif Aktifitas = Jumlah Menit Efektif (bulanan) - Menit Pengurang <br>
                                                (<?php echo rupiah($waktuEfektif); ?> - <?php echo rupiah($totalMenitPengurang); ?> )
                                            </th>
                                            <th class="text-end text-warning"><?php
                                                                                $menitAktif  = $waktuEfektif - $totalMenitPengurang;
                                                                                echo rupiah($menitAktif);

                                                                                ?> menit</th>
                                        </tr>

                                        <tr>
                                            <th>Penghitungan Nilai Aktifitas <br>
                                                <span class="text-muted fw-100"> min(Menit Efektif Aktifitas, Menit Aktifitas ) / Menit Efektif (bulan) x 100 </span>
                                                <?php

                                                //menit aktifitas =  total inputan yang disetujui + penambah (cuti)
                                                $menitAktfitas = $inputKinerja + $totalMenitPenambah;
                                                $nilaiTerkecil =  min($menitAktif, $menitAktfitas);



                                                $nilaiAktifitas = round(($nilaiTerkecil / $waktuEfektif) * 100, 2);
                                                $bobotAktifitas = $nilaiAktifitas * 0.7;

                                                ?>
                                            </th>
                                            <th class="text-end"><?php echo  $nilaiAktifitas; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Bobot Aktifitas (Nilai Aktifitas x 70%)</th>
                                            <th class="text-end"><?php echo  $bobotAktifitas; ?></th>
                                        </tr>
                                        <tr>
                                            <th>Total Capaian = Bobot Aktifitas + Nilai Perilaku + Serapan <br>

                                                = <?= $bobotAktifitas; ?> + <?= $nilaiPerilaku; ?> + <?= SERAPAN; ?>
                                            </th>
                                            <th class="text-end fs-4">
                                                <?php
                                                $totalCapaian =  $bobotAktifitas + $nilaiPerilaku + SERAPAN;

                                                echo round($totalCapaian, 2);
                                                ?>
                                            </th>

                                        </tr>




                                    </table>
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


</body>



</html>