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

                                            <li class="breadcrumb-acive">Capaian Kinerja </li>
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
                    $id_validator = $this->input->get('id_validator');

                    $bulan = $this->input->get('bulan');
                    $tahun = $this->input->get('tahun');

                    $message = $this->session->flashdata('message');
                    // print_array($this->session->userdata);



                    ?>




                    <div class="row">


                        <div class="col-12">
                            <form action="<?php echo site_url('admin/penilaian_kinerja/capaian_kinerja'); ?>" method="get" class="mb-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="bulan">Bulan</label>
                                            <select name="bulan" id="bulan" class="form-control">
                                                <?php
                                                $nama_bulan = array(
                                                    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                                                    7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                                                );
                                                foreach ($nama_bulan as $key => $value) {
                                                    $selected = (isset($bulan) && $bulan == $key) ? 'selected' : '';
                                                    echo '<option value="' . $key . '" ' . $selected . '>' . $value . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="tahun">Tahun</label>
                                            <select name="tahun" id="tahun" class="form-control">
                                                <?php
                                                $tahun_sekarang = date('Y');
                                                for ($i = $tahun_sekarang; $i >= $tahun_sekarang - 5; $i--) { // Menampilkan 5 tahun terakhir
                                                    $selected = (isset($tahun) && $tahun == $i) ? 'selected' : '';
                                                    echo '<option value="' . $i . '" ' . $selected . '>' . $i . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tahun">Validator</label>
                                            <select name="id_validator" id="validator" class="form-control">
                                                <?php

                                                foreach ($validator as $ls) {
                                                    $selected = $id_validator == $ls->id_pegawai ? 'selected' : '';
                                                    echo '<option value="' . $ls->id_pegawai . '" ' . $selected . '>' . $ls->nama . '</option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>




                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="submit" class="btn btn-primary">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="table-responsive mt-4">

                            <a href="<?php echo base_url(); ?>admin/penilaian_kinerja/update_capaian_perpustu/<?= $id_validator . '/' . $bulan . '/' . $tahun; ?>" class="btn btn-info update_data float-end">Update Data Capaian</a>
                            <div class="clearfix"></div>
                            <div class="loading" style="display: none;" id="loading_update">
                                <img src="<?php echo base_url(); ?>assets/images/loadinggif.gif" width="80">
                            </div>

                            <table class="table   table-hover" id="tblPerilaku">
                                <thead>
                                    <tr>

                                        <th class="w-1">No.</th>
                                        <th>Nama</th>
                                        <th class="text-center">Bobot Aktifitas</th>
                                        <th class="text-center">Perilaku</th>
                                        <th class="text-center">Serapan</th>
                                        <th class="text-center">Total Capaian</th>


                                    </tr>
                                </thead>
                                <tbody>

                                    <?php


                                    $no = 1;


                                    foreach ($capaian_kinerja as $capaian) {

                                        $id_pegawai = $capaian->id_pegawai;
                                        $nip = $capaian->nip;
                                        $nama = $capaian->nama;
                                        $id_validator = $capaian->id_validator;
                                        $bobot_aktifitas = $capaian->bobot_aktifitas;
                                        $poinPerilaku = $capaian->perilaku;
                                        $serapan = $capaian->serapan;
                                        $totalCapaian  = $capaian->total_capaian;

                                        if ($totalCapaian > 98) {
                                            $flag = '<span class="text-success">' . $totalCapaian . '</span>';
                                        } else if ($totalCapaian > 93 && $totalCapaian <= 98) {
                                            $flag = '<span class="text-primary">' . $totalCapaian . '</span>';
                                        } else if ($totalCapaian > 80 && $totalCapaian <= 93) {
                                            $flag = '<span class="text-warning">' . $totalCapaian . '</span>';
                                        } else if ($totalCapaian == 50) {
                                            $flag = '<span class="text-info">' . $totalCapaian . '</span>';
                                        } else {
                                            $flag = '<span class="text-danger">' . $totalCapaian . '</span>';
                                        }

                                        echo ' <tr>
                                              <td class="text-center">' . $no . ' </td>
                                              <td class="text-start"><a href="' . base_url() . 'admin/penilaian_kinerja/detail_capaian/' . $nip . '/' . $bulan . '/' . $tahun . '">' . $nama . '</a></td>
                                              <td class="text-center">' . $bobot_aktifitas . '</td>
                                              <td class="text-center">' . $poinPerilaku . '</td>
                                              <td class="text-center">' . $serapan . '</td>
                                              <td class="fw-semibold  text-center">' . $flag . '</td>

                                          </tr>';

                                        $no += 1;
                                    }

                                    ?>







                                </tbody>
                            </table>


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

                        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
                        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>


</body>


<script>
    $(document).ready(function() {
        $('#tblPerilaku').DataTable({
            pageLength: 10,
            lengthMenu: [10, 25, 50, 100],
            ordering: true,
            searching: true,
            info: true,
            autoWidth: false,
            columnDefs: [{
                    orderable: false,
                    targets: [0, 5]
                } // No & Aksi tidak bisa sort
            ],
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                infoEmpty: "Tidak ada data",
                zeroRecords: "Data tidak ditemukan",
                paginate: {
                    first: "Awal",
                    last: "Akhir",
                    next: "›",
                    previous: "‹"
                }
            }
        });
    });
</script>


</html>