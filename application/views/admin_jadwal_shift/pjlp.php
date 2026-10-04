<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        table {
            width: 100%;
        }

        table tr td,
        th {
            padding: 8px 10px;
            border-bottom: 1px solid #EEE;
            font-size: 13px;
        }


        th {
            background: #f2f4f7;
            color: #333 !important;
            padding: 10px;
            font-size: 14px;
        }



        .pagination {
            width: 100%;
            background: #FFF;
            margin-top: 20px;
        }

        .pagination a {
            background-color: #FFF;
            padding: 8px 14px;
            margin-right: 1px;
        }

        .pagination strong {
            background-color: #37aee9;
            padding: 8px 14px;
            margin-right: 1px;
            color: #FFF;
            border-radius: 3px;
        }

        .shift-off {
            background: #f53b54;
            color: #FFF;
            font-weight: 100;
        }

        .shift-loff {
            background: #f5b03b;
            color: #FFF;
            font-weight: 100;
        }

        .btn-close {
            float: right;
            cursor: pointer;
        }

        .alert .close-btn {
            position: absolute;
            top: 10px;
            right: 15px;
            color: #aaa;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
        }

        .alert .close-btn:hover {
            color: #000;
        }

        #div_change_shift {
            width: 400px;
            height: auto;
            background: #FFF;
            position: fixed;
            top: 18%;
            right: 400px;
            box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
            -webkit-box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
            -moz-box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
            display: none;
            padding: 20px;
            z-index: 99;
        }

        .col-name {
            left: 0;
            position: sticky;
        }

        .pilih-shift {
            border: 1px solid #DDD;
            padding: 5px 10px;
            font-size: 12px;
            color: #FFF;
            margin: 3px;
            width: 80px;
        }

        .shift-on {
            background: #FFF;
            color: #097d42;
        }

        .shift-on:hover {
            background: #bef4e6;
            color: #097d42;
        }

        .jam-kerja {
            font-size: 11px;
            color: #d87829;
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
            <!--  Header End -->


            <div class="body-wrapper">
                <div class="container-fluid mw-100">
                    <!--  Row 1 -->


                    <?php
                    $message = $this->session->flashdata('success');

                    // $periode = date('Y-m');
                    $periode_bulan = $this->session->userdata('periode_bulan');
                    $periode_tahun = $this->session->userdata('periode_tahun');

                    if ($periode_bulan == '') {
                        $bulan = date('m');
                        $tahun = date('Y');
                    } else {
                        $bulan = $periode_bulan;
                        $tahun = $periode_tahun;
                    }


                    $nm_bulan = getBulan($bulan);


                    $periode = $tahun . '-' . $bulan;
                    $periode = date('Y-m', strtotime($periode));

                    echo $message;


                    $listBulan = array_bulan();

                    $lastDateMonth = date('t', strtotime($periode));

                    $offset =  $this->uri->segment(3);
                    if ($offset == '') {
                        $offset = 0;
                    }
                    ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-12 mb-2">
                                    <h5>Pengajuan Cuti Pegawai</h5><br>



                                    <form action="<?php echo base_url(); ?>admin/pengajuan_cuti/cari_nama" method="post">
                                        <div class="row mt-4">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <input type="text" name="keyword" class="form-control" placeholder="cari nama pegawai">
                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <button type="submit" class="btn btn-info" name="button">Cari</button>
                                            </div>



                                        </div>
                                    </form>


                                    <div id="div_change_shift">

                                        <div class="btn-close"></div>
                                        <h3>Pengaturan Shift Kerja</h3>
                                        <hr>
                                        <div id="data_info"></div> <br>

                                        <?php
                                        for ($g = 0; $g < count($shift_kerja); $g++) {
                                            echo '<button type="button" value="' . $shift_kerja[$g]->kode_shift . '" class="pilih-shift shift-on">' . $shift_kerja[$g]->kode_shift . '</button>';
                                        }
                                        ?>



                                    </div>



                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="mt-4">
                                                FILTER PERIODE :

                                                <form action="<?php echo base_url(); ?>admin_jadwal_shift/change_periode/0" method="post">

                                                    <select name="periode_bulan" id="bulan" class="form-control float-start me-2" style="width:120px">
                                                        <?php
                                                        for ($i = 1; $i < 13; $i++) {
                                                            if ($periode_bulan == $i) {
                                                                echo ' <option value="' . $i . '" selected>' . getBulan($i) . '</option>';
                                                            } else {
                                                                echo ' <option value="' . $i . '">' . getBulan($i) . '</option>';
                                                            }
                                                        }
                                                        ?>

                                                    </select>
                                                    <input type="number" name="periode_tahun" class="form-control me-2 float-start" style="width:120px" id="tahun" value="<?php echo $periode_tahun; ?>">
                                                    <button type="submit" class="btn btn-info">Submit</button>
                                                </form>

                                            </div>
                                        </div>


                                    </div><!--row-->


                                    <div class="table-responsive mt-4 ">
                                        <table class="text-nowrap">
                                            <thead>
                                                <tr>

                                                    <th>Nama Pegawai</th>
                                                    <?php
                                                    for ($i = 1; $i < ($lastDateMonth + 1); $i++) {
                                                        $date =  $periode . '-' . $i;

                                                        $tanggal = format_db($date);
                                                        $day = date('l', strtotime($tanggal));
                                                        if ($day == 'Sunday') {
                                                            $hari = 'Mg';
                                                        } else if ($day == 'Monday') {
                                                            $hari = 'Sn';
                                                        } else if ($day == 'Tuesday') {
                                                            $hari = 'Sl';
                                                        } else if ($day == 'Wednesday') {
                                                            $hari = 'Rb';
                                                        } else if ($day == 'Thursday') {
                                                            $hari = 'Km';
                                                        } else if ($day == 'Friday') {
                                                            $hari = 'Jm';
                                                        } else {
                                                            $hari = 'Sb';
                                                        }

                                                        echo ' <th class="text-center">' . $i . ' <br>
                                                    <small>' . $hari . '</small></th>';
                                                    }

                                                    ?>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php



                                                for ($i = 0; $i < count($list_pegawai); $i++) {
                                                    $id_pegawai = $list_pegawai[$i]->id;
                                                    $id_pjlp        = $list_pegawai[$i]->id_pjlp;
                                                    $pin        = 0;

                                                    echo '

                                                        <tr>
                                                          <td class="col-name">' . $list_pegawai[$i]->nama . ' 
                                                          
                                                          </td>';
                                                    for ($a = 1; $a < ($lastDateMonth + 1); $a++) {


                                                        $tanggal  = $periode . '-' . $a;
                                                        $matrikId = $id_pjlp . '_' . $tanggal;
                                                        $tgl = format_db($tanggal);

                                                        $shift = $this->Presensi_model->getDatashiftKerjaPJLP($id_pjlp, $tgl, 'shift', 'pjlp');
                                                        $shift_class = '';
                                                        if ($shift != '-') {
                                                            $detailShift = $this->Presensi_model->detailShiftByKode($shift);
                                                            $jam_masuk  = format_jam($detailShift->jam_masuk);
                                                            $jam_pulang = format_jam($detailShift->jam_pulang);

                                                            $jam_kerja = $jam_masuk . ' - ' . $jam_pulang;

                                                            if ($shift == 'L-OFF') {
                                                                $shift_class = 'bg-light';
                                                            } else {
                                                                $shift_class = 'bg-success';
                                                            }

                                                            if ($jam_pulang == '00:00') {
                                                                $jam_pulang = '23:59:59';

                                                                if ($shift == 'OFF') {
                                                                    $jumlah_jam_kerja =  0;
                                                                    $shift_class = 'bg-danger';
                                                                } else {
                                                                    $jumlah_jam_kerja = calculateMinutesDifference($jam_pulang, $jam_masuk) + 1;
                                                                    $jumlah_jam_kerja = round($jumlah_jam_kerja / 60);
                                                                }
                                                            } else {
                                                                $jumlah_jam_kerja = calculateMinutesDifference($jam_pulang, $jam_masuk);
                                                                $jumlah_jam_kerja = round($jumlah_jam_kerja / 60);
                                                            }
                                                        } else {
                                                            $jam_kerja = '';
                                                            $jumlah_jam_kerja = 0;
                                                            $shift_class = 'bg-light';
                                                        }
                                                        echo '<td class="text-center">
                                                                      <button type="button" class="btn-change-shift btn btn-sm fs-1 ' . $shift_class . '" value="' . $list_pegawai[$i]->id . '" id="' . $matrikId . '">' . $shift . '</button>
                                                                     
                                                                      </td>';
                                                    }
                                                }

                                                $no_rows = $i + $offset;
                                                ?>
                                            </tbody>
                                        </table>


                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 p-3">
                                            Show <strong> <?php echo $offset + 1; ?> </strong> - <strong><?php echo $no_rows; ?></strong> Rows &nbsp; &nbsp; From &nbsp;
                                            <strong><?php echo $total_rows; ?></strong> &nbsp;Rows
                                        </div>
                                        <div class="col-md-4">
                                            <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
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

            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

            <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>


<script>
    matrikId = '';
    id_pegawai = '';
    $(".btn-change-shift").click(function() {

        matrikId = $(this).attr("id");
        id_pegawai = $(this).val();


        $("#div_change_shift").show();

        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>admin_jadwal_shift/getInfoPegawaiPJLP",
            data: "data_post=" + matrikId,
            success: function(return_data) {
                $("#data_info").html(return_data);

            }
        });


    });


    $(".pilih-shift").click(function() {
        var kode_shift = $(this).val();

        $("#" + matrikId).html(kode_shift);


        $.ajax({
            type: "POST",
            url: "<?php echo base_url(); ?>admin_jadwal_shift/insertShiftKerjaPJLP",
            data: "data_post=" + matrikId + "&kode_shift=" + kode_shift,
            success: function(return_data) {
                //$("#data_info").html(return_data);

            }
        });
        $("#div_change_shift").hide();
    });


    $(".btn-close").click(function() {
        $("#div_change_shift").hide();
    });
</script>

</html>