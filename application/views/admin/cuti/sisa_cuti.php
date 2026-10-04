<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>

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
                                    <h4 class="fw-semibold mb-8">Cuti Pegawai</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Sisa Cuti Pegawai</li>
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
                    $tahun = $this->input->get('tahun', true) ?: date('Y');


                    $message = $this->session->flashdata('message');
                    $link = base_url() . 'admin/penilaian_kinerja/';


                    $listBulan = array_bulan();
                    ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">

                                <h5>Sisa Cuti Pegawai</h5>
                                <div class="table-responsive mt-3">
                                    <a href="<?php echo base_url(); ?>admin/cuti/sisa_cuti?tahun=2025" class="flat-btn btn-md  <?= ($tahun == 2025) ? 'btn-primary' : 'btn-light'; ?>"> 2025</a>
                                    <a href="<?php echo base_url(); ?>admin/cuti/sisa_cuti?tahun=2026" class="flat-btn  btn-md <?= ($tahun == 2026) ? 'btn-primary' : 'btn-light'; ?>"> 2026</a>
                                    <a href="<?php echo base_url(); ?>admin/cuti/cuti_bersama?tahun=2026" class="flat-btn btn-md btn-light"> Cuti Bersama</a>
                                    <div class="clearfix"></div> <br>


                                    <table class="table table-sm mb-0 table-bordered">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th class="text-center bg-warning-lighten">Hak Cuti</td>
                                                <th class="text-center bg-warning-lighten">Terpakai</td>
                                                <th class="text-center bg-warning-lighten">Sisa Cuti</td>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php $no = 1;
                                            foreach ($list as $row) :
                                                $sisa_cuti = $row->hak_total - $row->hak_terpakai - $row->hak_reserved; ?>
                                                <tr>
                                                    <td class="text-center"><?= $no++; ?></td>
                                                    <td><?= $row->nama; ?></td>
                                                    <td><?= $row->nama_jabatan; ?></td>
                                                    <td class="text-center text-primary"><?= $row->hak_total; ?></td>
                                                    <td class="text-center <?php echo ($row->hak_terpakai > 0) ? 'text-dark fw-bold' : 'text-muted'; ?>"><?= $row->hak_terpakai; ?></td>
                                                    <td class="text-center  <?php echo ($sisa_cuti > 0) ? 'text-success fw-bold' : 'text-muted'; ?>"><?= $sisa_cuti; ?></td>


                                                    <td class="text-center">
                                                        <button type="button" class="btn btn-sm btn-warning btn-input-cuti" data-id="<?= $row->id_pegawai; ?>" data-nama="<?= $row->nama; ?>" data-bs-toggle="modal" data-bs-target="#modal-report">
                                                            Input Sisa Cuti 2025
                                                        </button>

                                                        <a href="<?= base_url('admin/cuti/info_detail/' . $row->id_pegawai); ?>" class="btn btn-sm btn-info mt-1">
                                                            Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>


                            <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm" role="document">
                                    <div class="modal-content">
                                        <form action="<?= base_url(
                                                            "admin/cuti/simpanSisaCuti2025"
                                                        ) ?>" method="post">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Input Sisa Cuti 2025</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <input type="hidden" name="id_pegawai" id="idPegawai">

                                                <div class="mb-2">
                                                    <label>Nama Pegawai</label>
                                                    <input type="text" id="namaPegawai" class="form-control" readonly>
                                                </div>

                                                <div class="mb-2">
                                                    <label>Sisa Cuti Tahun 2025</label>
                                                    <input type="number" name="sisa_cuti" id="sisaCuti" class="form-control" min="0" max="12" required>
                                                    <small class="text-muted">
                                                        Diisi sesuai rekap sisa cuti tahun 2025
                                                    </small>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal"> Cancel</a>
                                                <button type="submit" class="btn btn-primary ms-auto"> Simpan</button>
                                            </div>

                                        </form>

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

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {

                            document.querySelectorAll('.btn-input-cuti').forEach(function(btn) {
                                btn.addEventListener('click', function() {

                                    document.getElementById('idPegawai').value = this.dataset.id;
                                    document.getElementById('namaPegawai').value = this.dataset.nama;
                                    document.getElementById('sisaCuti').value = this.dataset.sisa;

                                    var modal = new bootstrap.Modal(
                                        document.getElementById('modalSisaCuti')
                                    );
                                    modal.show();
                                });
                            });

                        });
                    </script>

</body>



</html>