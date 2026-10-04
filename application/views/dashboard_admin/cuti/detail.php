<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dashboard_admin/style.css'); ?>">
    <style>
        .btn-acc {
            max-width: 100px;
        }

        .editable-hak {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="app-shell">
        <?php $this->load->view('dashboard_admin/layouts/sidebar'); ?>
        <main class="main-content">
            <div class="overview-header">
                <div>
                    <h1 class="page-title">Pengajuan Cuti</h1>
                </div>
            </div>

            <?php


            $jenisCuti = [
                1 => 'Cuti Tahunan',
                2 => 'Cuti Bersalin',
                3 => 'Cuti Alasan Penting',
                4 => 'Lainnya',
            ];



            $info_cuti = $cuti;
            $info_approval = $approval;

            $riwayat_cuti   = $history;
            $list_hari      = $list_hari;

            //print_array($hak_cuti);

            // usort($riwayat_cuti, function ($a, $b) {
            //     return $b['tahun_hak_cuti'] <=> $a['tahun_hak_cuti'];
            // });




            $id_pengajuan = $info_cuti->id;
            $id_pegawai = $info_cuti->id_pegawai;
            $tgl_pengajuan = $info_cuti->tgl_pengajuan;
            $jenis_cuti = $info_cuti->jenis_cuti;
            $id_pengganti = $info_cuti->id_pengganti;
            $tahun_hak_cuti = $info_cuti->tahun_hak_cuti;
            $tgl_mulai = $info_cuti->tgl_mulai;
            $tgl_selesai = $info_cuti->tgl_selesai;
            $lama_cuti = $info_cuti->lama_cuti;
            $alasan_cuti = $info_cuti->alasan_cuti;
            $alamat_cuti = $info_cuti->alamat_cuti;
            $no_telp = $info_cuti->no_telp;
            $delegasi_tugas = $info_cuti->delegasi_tugas;
            $status_akhir = $info_cuti->status_akhir;

            $tgl_pengajuan_format = formatBulan($tgl_pengajuan);


            ?>

            <section class="overview">

                <div class="detail-container  grid-7">
                    <!-- Kolom Kiri: Informasi Pengajuan Cuti -->
                    <div class="detail-section">
                        <h3><i class="fa fa-file-text"></i> Informasi Pengajuan</h3>

                        <div class="detail-row">
                            <div class="detail-label">Nama</div>
                            <div class="detail-value fw-bold"><?= htmlspecialchars($info_cuti->nama); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Jenis Cuti</div>
                            <div class="detail-value"><?= $jenisCuti[$jenis_cuti] == '' ? htmlspecialchars($jenisCuti[$jenis_cuti]) : ''; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tgl Pengajuan</div>
                            <div class="detail-value"><?= htmlspecialchars($tgl_pengajuan_format); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Hak Cuti Tahun</div>
                            <div class="detail-value"><?= htmlspecialchars($tahun_hak_cuti); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tgl Mulai</div>
                            <div class="detail-value"><?= htmlspecialchars(formatBulan($tgl_mulai)); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Tgl Akhir</div>
                            <div class="detail-value"><?= htmlspecialchars(formatBulan($tgl_selesai)); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Lama Cuti</div>
                            <div class="detail-value"><?= htmlspecialchars($lama_cuti); ?> hari</div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Alasan</div>
                            <div class="detail-value"><?= htmlspecialchars($alasan_cuti); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Alamat</div>
                            <div class="detail-value"><?= htmlspecialchars($alamat_cuti); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">No Telp</div>
                            <div class="detail-value"><?= htmlspecialchars($no_telp); ?></div>
                        </div>
                    </div>

                    <!-- Kolom Kanan: Informasi Approval -->
                    <div class="detail-section">
                        <h3><i class="fa fa-check-circle"></i> Status Persetujuan</h3>

                        <?php if (!empty($info_approval)) : ?>
                            <?php foreach ($info_approval as $approval) : ?>
                                <?php
                                $status_approval = strtolower($approval['status']);
                                $id_approval     = $approval['id']; //id


                                $status_class = 'status-pending';
                                if ($status_approval === 'approved') {
                                    $status_class = 'status-approved';
                                } elseif ($status_approval === 'rejected') {
                                    $status_class = 'status-rejected';
                                }

                                $link_acc = 'id_pengajuan=' . $id_pengajuan . '&id_approval=' . $id_approval . '&role=' . $approval['role_approval'];
                                ?>
                                <div class="approval-item">
                                    <div class="approval-role"><?= htmlspecialchars(strtoupper($approval['role_approval'])); ?>
                                        <br>
                                        <span style="font-size: 12px; color: #6b7280; font-weight: 500;"><?= htmlspecialchars($approval['nama']); ?></span>
                                    </div>
                                    <div class="approval-status <?= $status_class; ?>"><?= htmlspecialchars(ucfirst($approval['status'])); ?></div>

                                    <?php if ($status_approval == 'pending') : ?>

                                        <a href="<?php echo base_url(); ?>cuti/acc_cuti?<?= $link_acc; ?>" class="btn btn-sm btn-success btn-acc" onclick="return confirm('Apakah anda ingin menyetujui cuti ini?');"> <i class="fa fa-check"></i> Setujui</a>

                                    <?php endif; ?>


                                    <span style="font-size: 12px; color: #6b7280; font-weight: 500; color: <?= $status_approval === 'approved' ? '#10b981' : ($status_approval === 'rejected' ? '#ef4444' : '#6b7280'); ?>;">
                                        <?php if (!empty($approval['approved_at'])) : ?>
                                            approved at <?= formatBulan($approval['approved_at']); ?>
                                        <?php else : ?>
                                            waiting approval
                                        <?php endif; ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <p style="color: #999; text-align: center; padding: 20px 0;">Tidak ada data persetujuan</p>
                        <?php endif; ?>


                    </div>
                </div>


                <div class="detail-container  grid-7">
                    <!-- Kolom Kiri: Informasi Pengajuan Cuti -->
                    <div class="detail-section">
                        <h3><i class="fa fa-file-text"></i> Cuti</h3>


                        <?php
                        $message = $this->session->flashdata('message');

                        if ($message != '') {
                            echo '<div class="alert alert-success">' . $message . '</div>';
                        }

                        ?>

                        Tanggal Mulai : <strong> <?= htmlspecialchars(formatBulan($tgl_mulai)); ?></strong> &nbsp;&nbsp;&nbsp;
                        Tanggal Selesai : <strong> <?= htmlspecialchars(formatBulan($tgl_selesai)); ?> </strong>


                        <a href="<?= base_url(); ?>cuti/re_sync_absen_cuti/<?= $info_cuti->id ?>/<?= $info_cuti->id_mesin; ?>" class="btn btn-info float-end">
                            <i class="fa fa-refresh"></i> Sinkron Ulang </a>

                        <table class="absensi-table mt-4">
                            <tr>
                                <th>Hari</th>
                                <th>Tanggal</th>
                            </tr>
                            <?php
                            foreach ($list_hari as $hari) {

                                echo ' <tr>
                                        <td>' . getNamahari($hari['tgl_cuti']) . '</td>
                                        <td>' . formatBulan($hari['tgl_cuti']) . '</td>
                                    </tr>';
                            }
                            ?>

                        </table>


                    </div>

                    <!-- Kolom Kanan: Informasi Approval -->
                    <div class="detail-section">
                        <h3><i class="fa fa-check-circle"></i> Sisa Cuti</h3>


                        <table class="absensi-table mt-2">
                            <thead>
                                <tr>
                                    <th>Tahun</th>
                                    <th>Total Hak</th>
                                    <th>Digunakan</th>
                                    <th>Dalam Proses</th>
                                    <th>Sisa Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($hak_cuti as $hak) {

                                    $sisa_hak = $hak['hak_total'] - $hak['hak_terpakai'] - $hak['hak_reserved'];

                                    echo "<tr>
                                            <td>{$hak['tahun']}</td>
                                            <td class='bg-info-subtle text-info'>{$hak['hak_total']}</td>
                                            <td class='bg-danger-subtle text-danger editable-hak' data-field='hak_terpakai' data-tahun='{$hak['tahun']}' data-id_pegawai='{$info_cuti->id_pegawai}'>
                                            <span>  {$hak['hak_terpakai']}</span> 
                                            </td>
                                            <td class='bg-warning-subtle text-dark editable-hak' data-field='hak_terpakai' data-tahun='{$hak['tahun']}' data-id_pegawai='{$info_cuti->id_pegawai}'>
                                            <span> {$hak['hak_reserved']}</span> 
                                            </td>
                                            <td class='bg-success-subtle text-success fw-bold'>
                                                {$sisa_hak}
                                            </td>
                                        </tr>";
                                }
                                ?>
                            </tbody>
                        </table>


                    </div>
                </div>

                <div class="detail-section">
                    <h3><i class="fa fa-file-text"></i> Riwayat Cuti</h3>



                    <table class="data-table table-sm text-left">
                        <thead>
                            <tr>
                                <th>No</th>

                                <th>Jenis Cuti</th>
                                <th>Tahun Hak Cuti</th>
                                <th>Tanggal Cuti Mulai</th>
                                <th>Tanggal Cuti Selesai</th>
                                <th>Lama Cuti</th>
                                <th>Alasan Cuti</th>
                                <th>Status Akhir</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            $statusMapping = [
                                'draft' => ['label' => 'Draft', 'class' => 'status-pending'],
                                'proses' => ['label' => 'Proses', 'class' => 'status-proses'],
                                'disetujui' => ['label' => 'Disetujui', 'class' => 'status-approved'],
                                'ditolak' => ['label' => 'Ditolak', 'class' => 'status-rejected'],
                                'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'status-canceled'],
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
                                                <td class='text-center'><span class='status-pill " . $statusInfo['class'] . "'>" . $statusInfo['label'] . "</span> </td>
                                                <td>
                                                    <a href='" . base_url('dashboard_admin/cuti_detail/' . $pengajuan['id']) . "' class='btn btn-sm btn-info'>Detail</a>";
                                if ($status_akhir_cuti == 'proses') {
                                    echo "
                                                        <a href='" . base_url('dashboard_admin/edit_cuti/' . $pengajuan['id']) . "' class='btn btn-sm btn-success'>Edit</a>
                                                        <a href='" . base_url('dashboard_admin/cancel_cuti/' . $pengajuan['id']) . "' onclick='return confirm(\"Are you sure you want to cancel this cuti?\")' class='btn btn-sm btn-warning'>Cancel</a>";
                                } else if ($status_akhir_cuti == 'dibatalkan') {
                                    echo "&nbsp; <a href='" . base_url('dashboard_admin/delete_cuti/' . $pengajuan['id']) . "/" . $info_cuti->id . "' onclick='return confirm(\"Are you sure you want to delete this cuti?\")' class='btn btn-sm btn-danger'>Delete</a>";
                                }
                                echo "</td>
                                        </tr>";
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </section>
        </main>
    </div>

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
            var toggleButton = document.querySelector('.toggle-button');
            var appShell = document.querySelector('.app-shell');
            var sidebar = document.querySelector('.sidebar');
            toggleButton && toggleButton.addEventListener('click', function() {
                var collapsed = appShell.classList.toggle('collapsed');
                sidebar.classList.toggle('collapsed', collapsed);
                toggleButton.setAttribute('aria-expanded', String(!collapsed));
            });
            var rows = document.querySelectorAll('.row-link');
            rows.forEach(function(row) {
                row.addEventListener('dblclick', function() {
                    var href = this.getAttribute('data-href');
                    if (href) {
                        window.location.href = href;
                    }
                });
            });

            // Handler untuk double click edit hak cuti
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
        });
    </script>
</body>

</html>