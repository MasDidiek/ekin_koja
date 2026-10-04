<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

<style>
    .custom-badge {
        font-size: 12px !important;
        padding: 0.25rem 0.5rem !important;
        border-radius: 0.25rem !important;
        color: #FFF !important;
    }

    /* TABLE: hanya garis horizontal */
    #tblPerilaku {
        border-collapse: collapse;
    }

    #tblPerilaku thead th {
        border-left: none !important;
        border-right: none !important;
        border-top: none;
        border-bottom: 2px solid #dee2e6;
    }

    #tblPerilaku tbody td {
        border-left: none !important;
        border-right: none !important;
        border-top: none;
        border-bottom: 1px solid #e9ecef;
    }

    /* hover row lebih halus */
    #tblPerilaku tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Snackbar */
    .snackbar {
        position: fixed;
        top: 20px;
        left: 50%;
        transform: translateX(-50%) translateY(-20px);

        min-width: 300px;
        max-width: 90%;

        background: #323232;
        color: white;
        padding: 16px 24px;
        border-radius: 10px;

        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);

        opacity: 0;
        visibility: hidden;

        transition: all 0.4s ease;
        z-index: 9999;
    }

    .snackbar.show {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }
</style>

<head>
    <?php $this->load->view('master/meta'); ?>

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
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Penilaian Kinerja</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Penilaian Kinerja Pegawai</li>
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

                    $jumlahHari = $hariKerja ? $hariKerja->jumlah_hari : 0;
                    $menitEfektif = $jumlahHari * 300;

                    //print_array($dataAktifitas);

                    $totalInput   = $dataAktifitas[0];
                    $totalPending = $dataAktifitas[1];
                    $totalSetuju  = $dataAktifitas[2];


                    // persen terhadap menit efektif
                    $persenCapaian = ($menitEfektif > 0) ? ($totalInput / $menitEfektif) * 100 : 0;
                    $persenCapaian = min($persenCapaian, 100);
                    // persen disetujui dari total input
                    $persenSetuju = ($totalInput > 0) ? ($totalSetuju / $totalInput) * 100 : 0;

                    if (!empty($absensi)) {
                        $absen = $absensi[0];
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

                    $menitPenambah = $absen->cuti * 300;

                    // Total pengurang
                    $totalPengurang =
                        $telat +
                        $pulang_awal +
                        $izin +
                        $sakit +
                        $alpha +
                        $sakit_sk;

                    // Menit efektif setelah dikurangi absensi
                    $menitFinal = $menitEfektif - $totalPengurang;

                    // Jangan sampai minus
                    if ($menitFinal < 0) {
                        $menitFinal = 0;
                    }


                    $TotalMenitCapaian = $totalSetuju + $menitPenambah;

                    $menitPembanding = min($menitFinal, $TotalMenitCapaian);


                    $nilaiAktifitas = ($menitEfektif > 0)
                        ? ($menitPembanding / $menitEfektif) * 100
                        : 0;

                    // Maksimal 100%
                    $nilaiAktifitas = min($nilaiAktifitas, 100);
                    $bobotAktifitas = $nilaiAktifitas * 0.7;

                    $id_pegawai = $rekap->id_pegawai;
                    $nip = $rekap->nip;
                    $pin = substr($nip, 0, 4);
                    ?>



                    <div class="card shadow-sm mb-4">
                        <div class="card-body">

                            <!-- Header Pegawai -->
                            <div class="mb-4">
                                <h4 class="mb-1">Rekap Absensi & Capaian</h4>
                                <div class="text-muted">
                                    <strong>Nama:</strong> <?= $rekap->nama ?> <br>
                                    <strong>NIP:</strong> <?= $rekap->nip ?> <br>
                                    <strong>Periode:</strong> <?= date('F Y', strtotime($rekap->periode . '-01')) ?>
                                </div>
                            </div>

                            <div class="row">

                                <!-- Rekap Absensi -->
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h5 class="mb-3">Rekap Absensi</h5>



                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Telat</span>
                                                    <span class="badge bg-warning"><?= $absen->telat ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Pulang Awal</span>
                                                    <span class="badge bg-secondary"><?= $absen->pulang_awal ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Izin</span>
                                                    <span class="badge bg-info"><?= $absen->izin ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Sakit</span>
                                                    <span class="badge bg-primary"><?= $absen->sakit ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Sakit dgn Keterangan</span>
                                                    <span class="badge bg-primary"><?= $absen->sakit_dgn_sk ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Cuti</span>
                                                    <span class="badge bg-dark"><?= $absen->cuti ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Dinas Luar</span>
                                                    <span class="badge bg-success"><?= $absen->dl_penuh ?></span>
                                                </li>
                                                <li class="list-group-item d-flex justify-content-between">
                                                    <span>Alpha</span>
                                                    <span class="badge bg-danger"><?= $absen->alpha ?></span>
                                                </li>
                                            </ul>
                                            <br>
                                            <a href="<?php echo base_url(); ?>admin/presensi/lihat_absensi_pegawai/<?= $id_pegawai . '/' . $pin; ?>" class="btn btn-success float-end">
                                                Lihat Absensi</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Capaian -->
                                <div class="col-md-4">
                                    <div class="card border-0 shadow-sm h-100">
                                        <div class="card-body">
                                            <h5 class="mb-3">Capaian Kinerja</h5>

                                            <p class="mb-1">Bobot Aktifitas (<?= $rekap->bobot_aktifitas ?>%) </p>
                                            <div class="progress mb-3">
                                                <div class="progress-bar bg-info" style="width: <?= $rekap->bobot_aktifitas ?>%">
                                                </div>
                                            </div>

                                            <p class="mb-1">Perilaku (<?= $rekap->perilaku ?>%)</p>
                                            <div class="progress mb-3">
                                                <div class="progress-bar bg-warning" style="width: <?= $rekap->perilaku ?>%">
                                                </div>
                                            </div>

                                            <p class="mb-1">Serapan (<?= $rekap->serapan ?>%)</p>
                                            <div class="progress mb-3">
                                                <div class="progress-bar bg-success" style="width: <?= $rekap->serapan ?>%">
                                                </div>
                                            </div>

                                            <hr>

                                            <h5 class="text-end">
                                                Total Capaian:
                                                <span class="text-primary fs-6">
                                                    <?= $rekap->total_capaian ?>%
                                                </span>
                                            </h5>



                                        </div>

                                        <!-- $telat = $absen->telat;
                                        $pulang_awal = $absen->pulang_awal;
                                        $izin = $absen->izin * 300;
                                        $sakit = $absen->sakit * 300;
                                        $alpha = $absen->alpha * 450;
                                        $sakit_sk = $absen->sakit_dgn_sk * 150; -->
                                        <div class="card p-3">
                                            <h5>Info Perhitungan</h5>
                                            <table>
                                                <tr>
                                                    <td>Waktu Efektif</td>
                                                    <td class="text-end fw-bold"><?= number_format($menitEfektif) ?> menit</td>
                                                </tr>
                                                <tr>
                                                    <td class=" fw-bold">Menit Pengurang</td>
                                                    <td class="text-end"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-danger">- Telat</td>
                                                    <td class="text-end"><?= $telat; ?> menit</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-danger">- Pulang Awal</td>
                                                    <td class="text-end"><?= $pulang_awal; ?> menit</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-danger">- Izin</td>
                                                    <td class="text-end"><?= $izin; ?> menit</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-danger">- Sakit</td>
                                                    <td class="text-end"><?= $sakit; ?> menit</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-danger">- Sakit dgn Keterangan</td>
                                                    <td class="text-end"><?= $sakit_sk; ?> menit</td>
                                                </tr>

                                                <tr height="50">
                                                    <td class="text-danger fw-bold">Total Menit Pengurang</td>
                                                    <td class="text-end text-danger fw-bold"><?= $totalPengurang; ?> menit</td>
                                                </tr>

                                                <tr height="50">
                                                    <td class="text-primary fw-bold">Total Waktu Efektif</td>
                                                    <td class="text-end text-primary fw-bold"><?= rupiah($menitFinal); ?> menit</td>

                                                </tr>
                                                <tr height="50">
                                                    <td class="text-dark fw-bold">Nilai Aktifitas <br>
                                                        <span class="text-muted">
                                                            Total Waktu efektif / Waktu efektiif bulan x 100%)</span>
                                                    </td>
                                                    <td class="text-end text-dark fw-bold"><?= round($nilaiAktifitas, 2); ?> %</td>
                                                </tr>
                                                <tr height="50">
                                                    <td class="text-primary fw-bold">Bobot Aktifitas <br>
                                                        <span class="text-muted">
                                                            Nilai Aktifitas x 70%)</span>
                                                    </td>
                                                    <td class="text-end text-primary fw-bold" style="font-size: 20px;"><?= round($bobotAktifitas, 2); ?> %</td>
                                                </tr>




                                            </table>
                                            <br>

                                            <?php
                                            $message = $this->session->flashdata('message');

                                            ?>

                                            <?php if ($message) : ?>
                                                <div id="snackbar" class="snackbar">
                                                    <?php echo $message; ?>
                                                </div>

                                            <?php endif ?>


                                            <form action="<?php echo base_url(); ?>admin/penilaian_kinerja/update_capaian_kinerja" method="post">

                                                <input type="hidden" name="nip" value="<?= $nip; ?>">
                                                <input type="hidden" name="periode" value="<?= $periode; ?>">
                                                <input type="hidden" name="bobot_aktifitas" value="<?= $bobotAktifitas; ?>">
                                                <input type="hidden" name="perilaku" value="<?= $rekap->perilaku ?>">

                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </form>

                                        </div>
                                    </div>



                                </div>

                                <div class="col-md-4">
                                    <div class="card shadow-sm mb-4">
                                        <div class="card-body">
                                            <div class="alert alert-info">
                                                <strong>Informasi Hari Kerja Periode <?= date('F Y', strtotime($periode . '-01')) ?></strong><br>
                                                Jumlah Hari Kerja : <strong><?= $jumlahHari ?> hari</strong><br>
                                                Menit Efektif : <strong><?= number_format($menitEfektif) ?> menit</strong>
                                            </div>

                                            <h5 class="mb-4">Input Aktivitas Bulanan</h5>

                                            <div class="row text-center mb-4">
                                                <div class="col-md-4">
                                                    <h6>Total Input</h6>
                                                    <h4 class="text-primary"><?= number_format($totalInput) ?></h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Pending</h6>
                                                    <h4 class="text-warning"><?= number_format($totalPending) ?></h4>
                                                </div>
                                                <div class="col-md-4">
                                                    <h6>Disetujui</h6>
                                                    <h4 class="text-success"><?= number_format($totalSetuju) ?></h4>
                                                </div>
                                            </div>

                                            <!-- Progress Target -->
                                            <label class="fw-bold">
                                                Capaian
                                                <span class="float-right"><?= number_format($persenCapaian, 2) ?>%</span>
                                            </label>
                                            <div class="progress mb-4" style="height: 10px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?= $persenCapaian ?>%;">
                                                </div>
                                            </div>

                                            <!-- Progress Disetujui -->
                                            <label class="fw-bold">
                                                Persentase Disetujui
                                                <span class="float-end"><?= number_format($persenSetuju, 2) ?>%</span>
                                            </label>
                                            <div class="progress" style="height: 10px;">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?= $persenSetuju ?>%;">
                                                </div>
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



</body>


<script>
    window.onload = function() {
        const snackbar = document.getElementById("snackbar");

        snackbar.classList.add("show");

        setTimeout(() => {
            snackbar.classList.remove("show");
        }, 5000);

    };
</script>

</html>