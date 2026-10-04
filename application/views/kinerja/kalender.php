<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/monthly.css">
    <style type="text/css">
        .calendar-table th {
            background: #f8f9fa;
            text-align: center;
        }

        .calendar-cell {
            height: 110px;
            vertical-align: top;
            position: relative;
            padding: 5px;
        }

        .calendar-cell .date-number {
            position: absolute;
            top: 5px;
            right: 8px;
            font-weight: bold;
            font-size: 14px;
        }

        .calendar-cell.today {
            background: #e3f2fd;
            border: 2px solid #2196f3;
        }

        .calendar-table {
            table-layout: fixed;
            width: 100%;
        }
    </style>
</head>

<body>


    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <aside class="left-sidebar with-vertical">
            <div><!-- ---------------------------------- -->
                <!-- Start Vertical Layout Sidebar -->
                <!-- ---------------------------------- -->


                <?php $this->load->view('layout/section/sidebar'); ?>

        </aside>

        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <?php $this->load->view('layout/section/header'); ?>


            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8"> Kinerja </h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home / Kinerja</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive"> Input Aktifitas </li>
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
                    $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
                    $menitEfektifBulanan  = $jumlahHariKerja * 300;
                    ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-12 text-center">
                                    <a href="?bulan=<?= $prev_bulan ?>&tahun=<?= $prev_tahun ?>" class="btn btn-sm btn-outline-secondary">
                                        «
                                    </a>

                                    <strong class="mx-3">
                                        <?= date('F Y', strtotime($tahun . '-' . $bulan . '-01')) ?>
                                    </strong>

                                    <a href="?bulan=<?= $next_bulan ?>&tahun=<?= $next_tahun ?>" class="btn btn-sm btn-outline-secondary">
                                        »
                                    </a>
                                </div>
                            </div>


                            <table class="table table-bordered calendar-table">
                                <thead class="thead-light text-center">
                                    <tr>
                                        <th>Sen</th>
                                        <th>Sel</th>
                                        <th>Rab</th>
                                        <th>Kam</th>
                                        <th>Jum</th>
                                        <th>Sab</th>
                                        <th>Min</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <?php
                                        $today = date('Y-m-d');

                                        // spasi sebelum tanggal 1
                                        for ($i = 1; $i < $hari_pertama; $i++) {
                                            echo '<td class="bg-light"></td>';
                                        }

                                        for ($tgl = 1; $tgl <= $jumlah_hari; $tgl++) {

                                            $currentDate = sprintf('%04d-%02d-%02d', $tahun, $bulan, $tgl);
                                            $isToday = ($currentDate == $today);
                                        ?>
                                            <td class="calendar-cell" data-tgl="<?= $currentDate ?>">

                                                <div class="calendar-day">
                                                    <div class="date-number"><?= $tgl ?></div>
                                                </div>

                                                <?php if (isset($kinerja[$currentDate])) : ?>
                                                    <div class="calendar-total" data-tgl="<?= $currentDate ?>">

                                                        <div class="p-1 mt-4  text-white text-center rounded fs-1  total-inputan <?= $kinerja[$currentDate]['bg'] ?>" style="cursor:pointer">
                                                            <?= $kinerja[$currentDate]['total'] ?> menit
                                                        </div>
                                                    </div>
                                                <?php endif; ?>

                                            </td>


                                        <?php

                                            if (($tgl + $hari_pertama - 1) % 7 == 0) {
                                                echo '</tr><tr>';
                                            }
                                        }
                                        ?>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4">

                            <div class="alert alert-info bg-info text-white mt-4">
                                Total Waktu efektif Pereiode : <?= date('F Y', strtotime($tahun . '-' . $bulan . '-01')) ?>
                                <br>
                                <h5 class="mt-2 text-white"><?php echo rupiah($menitEfektifBulanan); ?> menit</h5>
                            </div>
                            <div class="card">
                                <div class="card-body text-info">
                                    <strong>Input Aktifitas</strong>

                                    <div class="mb-3">
                                        <span class="text-muted">Total Input Aktifitas :</span>
                                        <h5 class="mt-2" id="sum-total-input">
                                            <?= $summary['total_input']['jumlah']; ?> Aktifitas
                                        </h5>
                                    </div>

                                    <div class="mb-3">
                                        <span class="text-muted">Total Menit Aktifitas :</span>
                                        <h5 class="mt-2" id="sum-total-menit">
                                            <?= $summary['total_input']['menit']; ?> Menit
                                        </h5>
                                    </div>
                                </div>
                            </div>


                            <div class="card">
                                <div class="card-body text-success">
                                    <strong>Aktifitas Disetujui</strong>

                                    <div class="mb-3">
                                        <span class="text-muted">Total Aktifitas :</span>
                                        <h5 class="mt-2">
                                            <?= $summary['disetujui']['jumlah']; ?> Aktifitas
                                        </h5>
                                    </div>

                                    <div class="mb-3">
                                        <span class="text-muted">Total Menit Aktifitas :</span>
                                        <h5 class="mt-2">
                                            <?= $summary['disetujui']['menit']; ?> Menit
                                        </h5>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>



                    <div class="modal fade" id="modalKinerja" tabindex="-1">
                        <div class="modal-dialog modal-xl modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-body" id="modalKinerjaBody">
                                    <div class="text-center p-4">
                                        <span class="spinner-border"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>



</body>


</div>


</div><!--row-->


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

<script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/monthly.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-clock-timepicker.js"></script>

<script>
    $(document).ready(function() {

        $('#modalKinerja').on('click', '.input-aktifitas', function() {

            var tgl = $(this).data('tgl');

            $('#modalKinerjaBody').load(
                '<?= site_url('kinerja/view_form_input_aktifitas') ?>', {
                    tgl: tgl
                },
                function() {
                    initClockPicker();
                }
            );
        });




        // klik total → list aktivitas
        $('.calendar-cell').on('click', function(e) {
            e.stopPropagation(); // 🔴 PENTING

            var tgl = $(this).data('tgl');

            $('#modalKinerjaBody').load(
                '<?= site_url('kinerja/view_list_input_aktifitas') ?>', {
                    tgl: tgl
                },
                function() {
                    $('#modalKinerja').modal('show');
                    initClockPicker();
                }
            );
        });


        // klik total → list aktivitas
        $('.calendar-total').on('click', function(e) {
            e.stopPropagation(); // 🔴 PENTING

            var tgl = $(this).data('tgl');

            $('#modalKinerjaBody').load(
                '<?= site_url('kinerja/view_list_input_aktifitas') ?>', {
                    tgl: tgl
                },
                function() {
                    $('#modalKinerja').modal('show');
                    initClockPicker();
                }
            );
        });




        function initClockPicker() {
            $('.start_time').clockTimePicker({
                precision: 5
            });

            $('.end_time').clockTimePicker({
                duration: true,
                precision: 5
            });
        }


        $(document).on('change', '#jam_mulai', function() {


            var jam_mulai = $(this).val();
            $("#jam_selesai").val(jam_mulai);
            $('.durationNegativeMinMax').clockTimePicker({
                duration: true,
                minimum: jam_mulai,
                maximum: '23:59',
                precision: 5
            });
            $("#jam_selesai").focus();
        });


        /* ===============================
         * HITUNG VOLUME SAAT JAM SELESAI
         * =============================== */
        $(document).on('change', '#jam_selesai', function() {

            var waktu_efektif = $("#waktu_efektif").val();
            var jam_mulai = $("#jam_mulai").val();
            var jam_selesai = $(this).val();

            $(".loader").show();

            $.ajax({
                type: "POST",
                url: "<?= base_url('kinerja/hitung_volume'); ?>",
                data: {
                    waktu_efektif: waktu_efektif,
                    jam_mulai: jam_mulai,
                    jam_selesai: jam_selesai
                },
                success: function(res) {
                    $("#volume").val(res);
                    $(".loader").fadeOut();
                }
            });
        });


        /* =========================================
         * AKTIFITAS - KLIK (FREQUENT AKTIFITAS)
         * ========================================= */
        $(document).on('click', '#aktifitas', function() {

            var keyword = $(this).val();
            $("#ajaxlist_aktifitas").show();

            $.ajax({
                type: "POST",
                url: "<?= base_url('kinerja/ajaxGetFrequentAktifitas'); ?>",
                data: {
                    keyword: keyword
                },
                success: function(res) {
                    $("#ajaxlist_aktifitas").html(res);
                }
            });
        });


        /* =========================================
         * AKTIFITAS - KEYUP (SEARCH GLOBAL)
         * ========================================= */
        $(document).on('keyup', '#aktifitas', function() {

            var keyword = $(this).val();
            $("#ajaxlist_aktifitas").show();

            $.ajax({
                type: "POST",
                url: "<?= base_url('kinerja/ajaxSearchAktifitas'); ?>",
                data: {
                    keyword: keyword
                },
                success: function(res) {
                    $("#ajaxlist_aktifitas").html(res);
                }
            });
        });


        /* ===============================
         * KETERANGAN
         * =============================== */
        $(document).on('keyup', '#keterangan', function() {
            $("#list_keterangan").hide();
        });

        $(document).on('click', '#keterangan', function() {

            var keyword = $(this).val();
            $("#list_keterangan").show();

            $.ajax({
                type: "POST",
                url: "<?= base_url('kinerja/ajaxGetKeteranganAktifitas'); ?>",
                data: {
                    keyword: keyword
                },
                success: function(res) {
                    $("#list_keterangan").html(res);
                }
            });
        });


        $(document).on('keyup', '#indikator', function() {

            var keyword = $(this).val();
            $("#ajaxlist_indikator").show();
            $.ajax({

                type: "POST",
                dataType: "html",
                url: "<?php echo base_url(); ?>kinerja/ajaxSearchIndikator",
                data: "keyword=" + keyword,
                success: function(msg) {
                    $("#ajaxlist_indikator").html(msg);
                }

            });


        });




        $(document).on('submit', '#input_aktifitas', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: 'POST',
                dataType: 'json',
                data: $(this).serialize(),
                success: function(res) {

                    if (res.status) {




                        // 1️⃣ UPDATE CELL KALENDER
                        updateCalendarCell(res.tgl, res.calendar.total_menit);

                        // 2️⃣ UPDATE SUMMARY
                        updateSummary(res.summary);

                        $('#modalKinerja').modal('hide');
                    }
                }
            });
        });

        function updateCalendarCell(tgl, totalMenit) {

            let html = `
                <div class="p-1 mt-4 text-white text-center rounded fs-1 bg-warning">
                    ${totalMenit} menit
                </div>
            `;

            let cell = $(`.calendar-cell[data-tgl="${tgl}"]`);

            cell.find('.calendar-total').remove();

            if (totalMenit > 0) {
                cell.append(`<div class="calendar-total">${html}</div>`);
            }
        }


        function updateSummary(summary) {

            $('#sum-total-input').text(
                summary.total_input.jumlah + ' Aktifitas'
            );

            $('#sum-total-menit').text(
                summary.total_input.menit + ' Menit'
            );

            $('#sum-setuju-jumlah').text(
                summary.disetujui.jumlah + ' Aktifitas'
            );

            $('#sum-setuju-menit').text(
                summary.disetujui.menit + ' Menit'
            );
        }



        $('#modalKinerja').on('click', '.delete-aktifitas', function() {

            var id = $(this).data('id');
            var tgl = $(this).data('tgl');

            if (!confirm('Yakin ingin menghapus aktifitas ini?')) {
                return;
            }

            $.ajax({
                url: '<?= site_url('kinerja/delete_aktifitas') ?>',
                type: 'POST',
                dataType: 'json',
                data: {
                    id: id,
                    tgl: tgl
                },
                success: function(res) {

                    if (!res.status) {
                        alert(res.message);
                        return;
                    }

                    // 1️⃣ hapus row tabel
                    $('.delete-aktifitas[data-id="' + id + '"]').closest('tr').remove();

                    // 2️⃣ update kalender
                    updateCalendarCell(res);

                    // 3️⃣ update summary
                    updateSummary(res.summary);
                }
            });
        });


    });
</script>

</html>