<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">


    <style>
        .form-periode {
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


        table {
            width: 100%;
        }

        .table th {
            border: 1px solid #EEE;

        }

        .table td {
            border: 1px solid #EEE;


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


                <?php $this->load->view('layout/section/sidebar'); ?>

        </aside>

        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <?php $this->load->view('layout/section/header'); ?>


            <?php


            $bulan_start = $this->session->userdata('bulan_start');
            $bulan_end = $this->session->userdata('bulan_end');
            $tahun = $this->session->userdata('tahun');

            $diff = ($bulan_end - $bulan_start) + 1;

            $listBulan = array_bulan();

            $jns_absensi = array('telat', 'izin', 'sakit', 'cuti');
            ?>

            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <h3 class="title-page">Laporan Absensi Pegawai</h3>

                            </div>


                        </div>
                    </div>




                    <div class="row">
                        <div class="col-md-2 col-3">
                            <div class="mb-3">
                                <label for="bulan" class="form-label">Bulan Dari</label><br>
                                <select name="bulan_start" id="bulan_start" class="form-control">
                                    <?php
                                    for ($i = 0; $i < count($listBulan); $i++) {
                                        if ($bulan_start == $i) {
                                            echo ' <option value="' . $i . '" selected>' . $listBulan[$i] . '</option>';
                                        } else {
                                            echo ' <option value="' . $i . '">' . $listBulan[$i] . '</option>';
                                        }
                                    }
                                    ?>

                                </select>


                            </div>
                        </div>
                        <div class="col-md-2  col-3">
                            <div class="mb-3">
                                <label for="bulan" class="form-label">Bulan Sampai</label><br>
                                <select name="bulan_end" id="bulan_end" class="form-control">
                                    <?php
                                    for ($i = 0; $i < count($listBulan); $i++) {
                                        if ($bulan_end == $i) {
                                            echo ' <option value="' . $i . '" selected>' . $listBulan[$i] . '</option>';
                                        } else {
                                            echo ' <option value="' . $i . '">' . $listBulan[$i] . '</option>';
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2  col-3">
                            <div class="mb-3">
                                <label for="bulan" class="form-label">Tahun</label><br>
                                <select name="tahun" id="tahun" class="form-control">
                                    <?php
                                    for ($t = 2024; $t < 2030; $t++) {

                                        echo ' <option value="' . $t . '">' . $t . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-2  col-3">
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Absensi</label><br>
                                <select name="jenis" id="jenis" class="form-control">
                                    <?php
                                    for ($j = 0; $j < 4; $j++) {

                                        echo ' <option value="' . $jns_absensi[$j] . '">' . $jns_absensi[$j] . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>



                        <div class="col-md-2  col-3">
                            <div class="mb-3">
                                <label for="bulan" class="form-label text-white">Filter Data</label><br>
                                <button type="submit" class="btn btn-primary" id="submit_form">Submit</button>
                            </div>
                        </div>



                    </div>





                    <div class="row">
                        <!-- Column -->
                        <div class="col-md-12 mb-2">
                            <!-- <a href="<?php echo base_url(); ?>admin/presensi/DataRekapAbsensi/telat" class="btn btn-light text-info">Telat</a>
                   <a href="<?php echo base_url(); ?>admin/presensi/DataRekapAbsensi/pulang_awal" class="btn btn-light text-info">Pulang awal</a>
                   <a href="<?php echo base_url(); ?>admin/presensi/DataRekapAbsensi/izin" class="btn btn-light text-info">Izin</a>
                   <a href="<?php echo base_url(); ?>admin/presensi/DataRekapAbsensi/sakit" class="btn btn-light text-info">Sakit</a> -->


                        </div>



                        <div class="table-responsive mt-4" id="table_laporan">
                            <?php

                            echo '<table class="table table-bordered table-hover" id="data-table">
                                        <thead>
                                            <tr>
                                            <th class="w-1">No.</th>
                                            <th>Nama</th>';

                            $bulan = $bulan_start;
                            for ($i = 0; $i < $diff; $i++) {
                                $nm_bulan = getBulan($bulan);

                                $nm_bulan = substr($nm_bulan, 0, 3);
                                // $periode = $tahun.'-'.$bulan;
                                // $periode = date('Y-m', strtotime($periode));          

                                // $rekap = $this->Laporan_model->getRekapAbsensi($periode);
                                echo '<th>' . $nm_bulan . '</th>';

                                $bulan = $bulan + 1;
                            }

                            echo ' <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>';

                            $jns_absensi_filter = $this->session->userdata('jns_absensi');

                            if ($jns_absensi_filter == '') {
                                $jns_absensi_filter = 'telat';
                            }

                            $no = 1;
                            foreach ($pegawai as $peg) {

                                $id_pegawai = $peg->id_pegawai;
                                $nama = $peg->nama;
                                $nip = $peg->nip;
                                $pin = substr($nip, -4);

                                echo '
                                            <tr>
                                                <td>' . $no . '</td>
                                                <td>' . $nama . '</td>';


                                $bulan_td = $bulan_start;
                                $totalTelat = 0;
                                for ($i = 0; $i < $diff; $i++) {
                                    $nm_bulan = getBulan($bulan_td);

                                    $periode = $tahun . '-' . $bulan_td;
                                    $periode = date('Y-m', strtotime($periode));

                                    $telat = $this->Laporan_model->getRekapTelat($jns_absensi_filter, $periode, $id_pegawai);
                                    $totalTelat = $totalTelat + $telat;
                                    echo '<td class="text-end"><a href="' . base_url() . 'laporan/create_session_absensi/' . $id_pegawai . '/' . $pin . '/' . $periode . '">' . $telat . '</a></td>';

                                    $bulan_td = $bulan_td + 1;
                                }


                                echo '
                                                <td class="text-end fw-bold">' . $totalTelat . '</td>
                                            </tr>
                                            ';


                                $totalTelat = 0;
                                $no += 1;
                            }


                            echo '</tbody>
                                </table>';
                            ?>

                        </div>


                        <!-- Column -->
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
                <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
                <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

                <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

                <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>


                <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
</body>


<script>
    $("#submit_form").click(function() {
        var bulan_start = $("#bulan_start").val();
        var bulan_end = $("#bulan_end").val();
        var tahun = $("#tahun").val();
        var jenis = $("#jenis").val();


        $.ajax({

            type: "POST",
            dataType: "html",
            url: "<?php echo base_url(); ?>laporan/filter_data",
            data: "bulan_start=" + bulan_start + "&bulan_end=" + bulan_end + "&tahun=" + tahun + "&jenis=" + jenis,
            success: function(msg) {
                window.location.reload();
                // $("#table_laporan").html(msg);
                //console.log(msg);
            }

        });

    });


    $('#data-table').dataTable({
        lengthMenu: [
            [20, -1],
            ['20', '50', '100', 'Show all']
        ]
    });
</script>

</html>