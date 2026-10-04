<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
        }


        .editable-hak {
            cursor: pointer;
        }

        .editable-hak:hover {
            font-weight: bold;
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
                                    <h4 class="fw-semibold mb-8">Cuti Pegawai</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Info Detail Cuti Pegawai</li>
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
                    $id_pegawai = $detail_pegawai[0]->id_pegawai;
                    $nama = $detail_pegawai[0]->nama;
                    $nip = $detail_pegawai[0]->nip;
                    $jabatan = $detail_pegawai[0]->jabatan;
                    $puskesmas = $detail_pegawai[0]->puskesmas;

                    // print_array($detail_pegawai);

                    $listBulan = array_bulan();
                    ?>

                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <h5>
                                    <span class="text-primary">Info Detail Cuti Pegawai</span>
                                </h5>
                                <div class="col-md-6">
                                    <h3><i class="fa fa-user"></i> <?= htmlspecialchars($nama); ?></h3>

                                    <div class="detail-row">
                                        <div class="fs-4 fw-bold"><?= $jabatan; ?> - <?= $puskesmas; ?></div>
                                        <div class="fs-4 fw-bold"><?= $nip; ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h3><i class="fa fa-list"></i> Sisa Cuti</h3>
                                    <table class="table table-bordered text-center mt-2">
                                        <thead>
                                            <tr>
                                                <th class="bg-light">Tahun</th>
                                                <th class="bg-light">Total Hak</th>
                                                <th class="bg-light">Digunakan</th>
                                                <th class="bg-light">Dalam Proses</th>
                                                <th class="bg-light">Sisa Akhir</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($hak_cuti as $hak) {

                                                $sisa_hak = $hak['hak_total'] - $hak['hak_terpakai'] - $hak['hak_reserved'];

                                                echo "<tr>
                                                    <td>{$hak['tahun']}</td>
                                                    <td class='text-info'>{$hak['hak_total']}</td>
                                                    <td class='text-danger editable-hak' data-field='hak_terpakai' data-tahun='{$hak['tahun']}' data-id_pegawai='{$id_pegawai}'>
                                                    <span>  {$hak['hak_terpakai']}</span> 
                                                    </td>
                                                    <td class='text-dark editable-hak' data-field='hak_terpakai' data-tahun='{$hak['tahun']}' data-id_pegawai='{$id_pegawai}'>
                                                    <span> {$hak['hak_reserved']}</span> 
                                                    </td>
                                                    <td class=text-success fw-bold'>
                                                        {$sisa_hak}
                                                    </td>
                                                </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>


                                </div>






                                <br>
                                <div class="table-responsive mt-3">

                                    <h3><i class="fa fa-table"></i> Riwayat Cuti</h3>
                                    <table class="table table-bordered text-left ">
                                        <thead>
                                            <tr>
                                                <th class="bg-light">No</th>

                                                <th class="bg-light">Jenis Cuti</th>
                                                <th class=" bg-light">Tahun Hak Cuti</th>
                                                <th class=" bg-light">Tanggal Cuti Mulai</th>
                                                <th class=" bg-light">Tanggal Cuti Selesai</th>
                                                <th class=" bg-light">Lama Cuti</th>
                                                <th class=" bg-light">Alasan Cuti</th>
                                                <th class=" bg-light">Status Akhir</th>
                                                <th class=" bg-light">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            $statusMapping = [
                                                'draft' => ['label' => 'Draft', 'class' => 'bg-light text-warning'],
                                                'proses' => ['label' => 'Proses', 'class' => 'bg-warning-subtle text-warning'],
                                                'disetujui' => ['label' => 'Disetujui', 'class' => 'bg-success-subtle text-success'],
                                                'ditolak' => ['label' => 'Ditolak', 'class' => 'bg-danger-subtle text-danger'],
                                                'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'bg-danger-subtle'],
                                            ];


                                            $jenisCuti = [
                                                1 => 'Cuti Tahunan',
                                                2 => 'Cuti Bersalin',
                                                3 => 'Cuti Alasan Penting',
                                                4 => 'Lainnya',
                                            ];


                                            // print_array($jenisCuti);
                                            $no = 1;
                                            foreach ($riwayat_cuti as $pengajuan) {
                                                $class_tr = '';

                                                // print_array($pengajuan);
                                                $id_jenis_cuti = $pengajuan['jenis_cuti'];



                                                if (isset($jenisCuti[$id_jenis_cuti])) {
                                                    $jenis_cuti = $jenisCuti[$id_jenis_cuti];
                                                } else {
                                                    $jenis_cuti = 'Tidak Diketahui';
                                                }



                                                $status_akhir_cuti = $pengajuan['status_akhir'];

                                                $statusKey = strtolower(str_replace(' ', '', $pengajuan['status_akhir']));
                                                $statusInfo = isset($statusMapping[$statusKey]) ? $statusMapping[$statusKey] : ['label' => $pengajuan['status_akhir'], 'class' => 'status-pending'];

                                                //print_array($cuti);

                                                $tahun_hak_cuti = $pengajuan['tahun_hak_cuti'];
                                                if ($tahun_hak_cuti == 2026) {
                                                    $class_text = 'text-info fw-bold';
                                                } else {
                                                    $class_text = '';
                                                }


                                                echo "<tr class='" . $class_tr . "'>
                                                <td class='text-center '>" . $no++ . "</td>

                                                <td>{$jenis_cuti}</td>
                                                <td class='text-center " . $class_text . "'>{$pengajuan['tahun_hak_cuti']}</td>
                                                <td class='text-center'>" . format_view($pengajuan['tgl_mulai']) . "</td>
                                                <td class='text-center'>" . format_view($pengajuan['tgl_selesai']) . "</td>
                                                <td class='text-center'>" . $pengajuan['lama_cuti'] . "</td>
                                                <td class='text-start'>" . $pengajuan['alasan_cuti'] . "</td>
                                                <td class='text-center'><span class='badge " . $statusInfo['class'] . "'>" . $statusInfo['label'] . "</span> </td>
                                                <td>
                                                    <a href='" . base_url('dashboard_admin/cuti_detail/' . $pengajuan['id']) . "' class='btn btn-sm btn-info'>Detail</a>";
                                                if ($status_akhir_cuti == 'proses') {
                                                    echo "
                                                        <a href='" . base_url('dashboard_admin/edit_cuti/' . $pengajuan['id']) . "' class='btn btn-sm btn-success'>Edit</a>
                                                        <a href='" . base_url('dashboard_admin/cancel_cuti/' . $pengajuan['id']) . "' onclick='return confirm(\"Are you sure you want to cancel this cuti?\")' class='btn btn-sm btn-warning'>Cancel</a>";
                                                } else if ($status_akhir_cuti == 'dibatalkan') {
                                                    echo "&nbsp; <a href='" . base_url('dashboard_admin/delete_cuti/' . $pengajuan['id']) . "' onclick='return confirm(\"Are you sure you want to delete this cuti?\")' class='btn btn-sm btn-danger'>Delete</a>";
                                                }
                                                echo "</td>
                                        </tr>";
                                            }
                                            ?>
                                        </tbody>
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
                    <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                    <?php if ($this->session->flashdata('notif')) : ?>

                        <?php $notif = $this->session->flashdata('notif'); ?>

                        <script>
                            Swal.fire({
                                icon: '<?= $notif['status'] ? 'success' : 'error'; ?>',
                                title: '<?= $notif['status'] ? 'Berhasil' : 'Gagal'; ?>',
                                text: '<?= $notif['message']; ?>'
                            });
                        </script>

                    <?php endif; ?>

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

                        document.querySelectorAll('.editable-hak').forEach(el => {
                            el.addEventListener('dblclick', function() {
                                const field = this.dataset.field;
                                const tahun = this.dataset.tahun;
                                const id_pegawai = this.dataset.id_pegawai;
                                const currentValue = this.querySelector('span').innerText.trim();
                                const label = (field === 'hak_terpakai') ? 'Hak Terpakai' : 'Hak Reserved';

                                Swal.fire({
                                    title: 'Edit ' + label + ' (' + tahun + ')',
                                    input: 'number',
                                    inputValue: currentValue,
                                    showCancelButton: true,
                                    confirmButtonText: 'Simpan',
                                    cancelButtonText: 'Batal',
                                    showLoaderOnConfirm: true,
                                    preConfirm: (newValue) => {
                                        const formData = new FormData();
                                        formData.append('id_pegawai', id_pegawai);
                                        formData.append('tahun', tahun);
                                        formData.append('field', field);
                                        formData.append('value', newValue);

                                        return fetch("<?= base_url('dashboard_admin/updateHakCuti') ?>", {
                                                method: 'POST',
                                                body: formData
                                            })
                                            .then(response => {
                                                if (!response.ok) throw new Error(response.statusText);
                                                return response.json();
                                            })
                                            .then(data => {
                                                if (!data.status) throw new Error(data.message || 'Gagal memperbarui data');
                                                return data;
                                            })
                                            .catch(error => {
                                                Swal.showValidationMessage(`Request failed: ${error}`);
                                            });
                                    },
                                    allowOutsideClick: () => !Swal.isLoading()
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        Swal.fire('Berhasil', 'Data hak cuti telah diperbarui', 'success')
                                            .then(() => location.reload());
                                    }
                                });
                            });
                        });
                    </script>

</body>



</html>