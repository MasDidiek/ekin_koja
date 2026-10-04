<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        tr td,
        th {
            border-right: 1px solid #EEE;
            padding: 6px;
            text-align: center;
            font-size: 13px;
            color: #555
        }

        .form-periode2 {
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
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Data SIP - STR</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Data SIP - STR</li>
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


                    $jns_dokumen = $this->uri->segment(4);
                    $message = $this->session->flashdata('message');


                    ?>


                    <div class="row">

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <div class="row loading-update d-none">
                                        <div class="col-md-1"> <img src="<?php echo base_url(); ?>assets/images/loading-blue.gif" width="80"></div>
                                        <div class="col-md-6 fs-6 fw-bold text-info pt-4">Updating data ... </div>
                                    </div>




                                    <div class="clearfix"></div>

                                    <a href="<?php echo base_url(); ?>admin/laporan/str_sip/sip" class="btn btn-light"> SIP</a>
                                    <a href="<?php echo base_url(); ?>admin/laporan/str_sip/str" class="btn btn-light"> STR</a>
                                    <div class="table-responsive mt-4">
                                        <table class="table  table-hover" id="data-table">
                                            <thead>
                                                <tr>

                                                    <th class="w-1">No.</th>
                                                    <th>Jenis Dokumen</th>
                                                    <th>Nama</th>
                                                    <th>No SIP/STR</th>
                                                    <th>Tanggal Terbit</th>
                                                    <th>Tanggal Kadaluarsa</th>
                                                    <th>Seumur Hidup</th>
                                                    <th>Status</th>
                                                    <th>Action</th>

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php

                                                $today = date('Y-m-d');
                                                $no = 1;
                                                foreach ($data_sip_str as $key => $value) {

                                                    $nip = $value->nip;
                                                    $jns_dokumen = $value->jns_dokumen;
                                                    $no_sip_str = $value->no_sip_str;
                                                    $tgl_terbit = $value->tgl_terbit;
                                                    $tgl_kadaluarsa = $value->tgl_kadaluarsa;
                                                    $seumur_hidup = $value->seumur_hidup;

                                                    if ($seumur_hidup == 0) {
                                                        $status_dokumen = 'Tidak';
                                                    } else {
                                                        $status_dokumen = 'Iya';
                                                    }

                                                    $nama = $this->Pegawai_model->getPegawaiByNIP($nip);

                                                    if ($tgl_kadaluarsa < $today) {
                                                        if ($seumur_hidup == 1) {
                                                            $status_aktif = '<span class="badge bg-success">Aktif Seumur hidup</span>';
                                                        } else {
                                                            $status_aktif = '<span class="badge bg-danger">Kadaluarsa</span>';
                                                        }
                                                    } else {
                                                        $status_aktif = '<span class="badge bg-success">Aktif</span>';
                                                    }

                                                    echo '<tr>
                                                                        <td>' . $no . '</td>
                                                                        <td>' . strtoupper($jns_dokumen) . '</td>
                                                                        <td class="text-start">' . $nama . '</td>
                                                                        <td>' . $no_sip_str . '</td>
                                                                        <td>' . format_view($tgl_terbit) . '</td>
                                                                        <td>' . format_view($tgl_kadaluarsa) . '</td>
                                                                       
                                                                        <td>' . $status_dokumen . '</td>
                                                                        <td>' . $status_aktif . '</td>
                                                                        <td>
                                                                          <a href="' . base_url() . 'uploads/sip_str/' . $value->file_name . '" class="btn btn-sm btn-info" target="_blank">Lihat File</a>
                                                                        </td>
                                                                    </tr>';

                                                    $no += 1;
                                                }

                                                ?>






                                            </tbody>
                                        </table>
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

                <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
                <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

                <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
                <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

</body>




<script>
    $('#data-table').dataTable({
        lengthMenu: [
            [20, -1],
            ['20', '50', '100', 'Show all']
        ]
    });
</script>

</html>