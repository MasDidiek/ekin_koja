<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

    <style>
    .custom-badge{
        font-size: 12px !important;
        padding: 0.25rem 0.5rem !important;
        border-radius: 0.25rem !important;
        color:#FFF !important;
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

    .radio-score {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border: 1px solid #ccc;
        border-radius: 6px;
        margin-right: 6px;
        cursor: pointer;
        font-weight: 600;
        transition: all .2s ease;
    }

    .radio-score input {
        display: none;
    }

    .radio-score:hover {
        background: #f1f3f5;
    }

    .radio-score input:checked + span {
        background: #0d6efd;
        color: #fff;
        border-radius: 6px;
        padding: 6px 10px;
    }

    .radio-score:active span {
        transform: scale(0.95);
    }
    .skor{
        font-size: 34px;
        font-weight: 600;
        color: #0d6efd;
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

                    $message = $this->session->flashdata('success');


                    ?>

                        <div class="row">
                            <div class="col-md-8">
                                <table>
                                        <tr>
                                                <td style="width: 150px;">Nama Pegawai</td>
                                                <td width="20">:</td>
                                                <td><?= $pegawai[0]->nama ?></td>

                                        </tr>
                                        <tr>
                                                <td>NIP</td>
                                                <td>:</td>
                                                <td><?= $pegawai[0]->nip ?></td>

                                        </tr>
                                        <tr>
                                                <td>Jabatan</td>
                                                <td>:</td>
                                                <td><?= $pegawai[0]->jabatan ?></td>

                                        </tr>
                                        <tr>
                                                <td>Unit Kerja</td>
                                                <td>:</td>
                                                <td><?= $pegawai[0]->puskesmas ?></td>

                                        </tr>
                                </table>
                            </div>
                            <div class="col-md-4">
                                <h4> Skor Perilaku</h4>
                                <div class="skor">
                                    <span class="text-success"><?=$nilai_perilaku;?></span>
                                </div>
                            </div>
                        </div>




                            <div class="row mt-4">
                                <form method="post" action="<?= site_url('admin/penilaian_kinerja/simpan_penilaian_perilaku') ?>">

                                <input type="hidden" name="id_pegawai" value="<?= $pegawai[0]->id_pegawai ?>">
                                <input type="hidden" name="bulan" value="<?= $bulan ?>">
                                <input type="hidden" name="tahun" value="<?= $tahun ?>">

                                <?php
                                $current_kategori = null;
                                $no = 1;
                                ?>

                                <?php foreach ($pertanyaan as $index => $row): ?>

                                    <?php if ($current_kategori != $row->id_kategori): ?>

                                        <?php if ($current_kategori !== null): ?>
                                                </div> <!-- card-body -->
                                            </div> <!-- card -->
                                        <?php endif; ?>

                                        <?php $current_kategori = $row->id_kategori; ?>

                                        <div class="card mb-3">
                                            <div class="card-header font-weight-bold bg-light">
                                                <?= strtoupper($row->nama_kategori) ?>
                                            </div>
                                            <div class="card-body">

                                    <?php endif; ?>

                                    <div class="mb-3">
                                        <label class="font-weight-bold d-block">
                                            <?= $no++ ?>. <?= $row->pertanyaan ?>
                                        </label>

                                        <small class="<?= ($row->jns_item == 1) ? 'text-success' : 'text-danger' ?>">
                                            <?= ($row->jns_item == 1)
                                                ? '(+) Lebih tinggi lebih baik'
                                                : '(-) Lebih rendah lebih baik'
                                            ?>
                                        </small>

                                        <input type="hidden" name="id_pertanyaan[]" value="<?= $row->id_pertanyaan ?>">
                                        <input type="hidden" name="jns_item[<?= $row->id_pertanyaan ?>]" value="<?= $row->jns_item ?>">

                                        <div class="mt-2">
                                            <?php for ($i = 1; $i <= 10; $i++): ?>
                                               <label class="radio-score">
                                                    <input type="radio"
                                                        name="jawaban[<?= $row->id_pertanyaan ?>]"
                                                        value="<?= $i ?>"
                                                        <?= ($row->jawaban == $i) ? 'checked' : '' ?>
                                                        required>
                                                    <span><?= $i ?></span>
                                                </label>

                                            <?php endfor; ?>
                                        </div>
                                    </div>

                                <?php endforeach; ?>

                                <?php if ($current_kategori !== null): ?>
                                        </div> <!-- card-body -->
                                    </div> <!-- card -->
                                <?php endif; ?>

                                <div class="text-right mt-4">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-save"></i> Simpan Penilaian
                                    </button>
                                    <a href="<?= site_url('admin/penilaian_kinerja/penilaian_perilaku') ?>" class="btn btn-secondary">
                                        Kembali
                                    </a>
                                </div>

                                </form>



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

                        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
                        <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>


</body>


<script>
$(document).ready(function () {
    $('#tblPerilaku').DataTable({
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        ordering: true,
        searching: true,
        info: true,
        autoWidth: false,
        columnDefs: [
            { orderable: false, targets: [0, 5] } // No & Aksi tidak bisa sort
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
