<!DOCTYPE html>
<?php
$theme = $this->session->userdata('theme');
$theme = (isset($theme) && $theme != '') ? $theme : 'light';
?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>

</head>

<body>

    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <aside class="left-sidebar with-vertical">
            <div>
                <?php $this->load->view('layout/section/sidebar'); ?>
            </div>
        </aside>
        <!-- Sidebar End -->

        <div class="page-wrapper">
            <!-- Header Start -->
            <?php $this->load->view('layout/section/header'); ?>
            <!-- Header End -->

            <div class="body-wrapper">
                <div class="container-fluid">

                    <div class="card shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Rencana Kinerja</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-primary text-decoration-none" href="<?php echo base_url('dashboard/index'); ?>">Dashboard</a>
                                            </li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-item">
                                                <a class="text-primary text-decoration-none" href="<?php echo base_url('admin/penilaian_kinerja/index'); ?>">Penilaian Kinerja</a>
                                            </li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-active text-muted">Validasi Aktivitas</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    $jns_pegawai = $this->uri->segment(4);
                    $usergroup   = $this->session->userdata('usergroup');
                    $id_pj_sess  = $this->session->userdata('id_pj');
                    $message    = $this->session->flashdata('message');

                    if (!empty($message)) {
                        echo $message;
                    }

   
                    $selected_profesi = $this->input->get('id_jabatan');

                    $selected_profesi = (isset($selected_profesi)) ? $selected_profesi : '';
                    ?>


                    <div class="card">
                        <div class="card-header"> <h5> Tambah Data Master Indikator</h5></div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <!-- Form Filter Menggunakan Method GET -->
                                
                                    <?php if ( $this->session->flashdata('success')): ?>
                                        <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
                                    <?php endif; ?>

                                    <?php if (validation_errors()): ?>
                                        <div class="alert alert-danger"><?= validation_errors() ?></div>
                                    <?php endif; ?>

                                    <form action="<?= base_url('admin/renkin/simpan_indikator_kinerja') ?>" method="post">
                                        
                                        <div class="mb-3">
                                            <label for="indikator" class="form-label">Indikator Kinerja <span class="text-danger">*</span></label>
                                            <textarea name="indikator" id="indikator" class="form-control" rows="3" required><?= set_value('indikator') ?></textarea>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="satuan" class="form-label">Satuan <span class="text-danger">*</span></label>
                                                <input type="text" name="satuan" id="satuan" class="form-control" placeholder="Contoh: Dokumen, %, Orang" value="<?= set_value('satuan') ?>" required>
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="target_tahunan" class="form-label">Target Tahunan <span class="text-danger">*</span></label>
                                                <input type="number" name="target_tahunan" id="target_tahunan" class="form-control" value="<?= set_value('target_tahunan') ?>" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="profesi" class="form-label">Profesi / Jabatan <span class="text-danger">*</span></label>
                                            <select name="profesi" id="profesi" class="form-select" required>
                                                <option value="">-- Pilih Jabatan --</option>
                                                <?php foreach ($list_jabatan as $j): ?>
                                                    <option value="<?= $j->id ?>" <?= set_select('profesi', $j->id) ?>>
                                                        <?= $j->nama ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label d-block">Auto Fill Target</label>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="auto_fill_target" id="auto_T" value="T" <?= set_radio('auto_fill_target', 'T', TRUE) ?>>
                                                <label class="form-check-label" for="auto_T">Tidak (T)</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="auto_fill_target" id="auto_Y" value="Y" <?= set_radio('auto_fill_target', 'Y') ?>>
                                                <label class="form-check-label" for="auto_Y">Ya (Y)</label>
                                            </div>
                                        </div>

                                        <hr>
                                        <div class="d-flex justify-content-end gap-2">
                                            <button type="reset" class="btn btn-secondary">Reset</button>
                                            <button type="submit" class="btn btn-success">Simpan Data</button>
                                        </div>

                                    </form>
                                </div>

                            </div>
                    </div>
                </div>


                       

                       
                    <?php $this->load->view('layout/section/theme-setting.php'); ?>
                    <?php $this->load->view('master/request-cuti.php'); ?>

                </div>
            </div>
            <div class="dark-transparent sidebartoggler"></div>
        </div>
    </div>

    <!-- Import JavaScript Files -->
    <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

    <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

    <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>


    <script>
        function handleColorTheme(e) {
            $("html").attr("data-color-theme", e);
            $(e).prop("checked", !0);
        }
        

       
    </script>
</body>

</html>