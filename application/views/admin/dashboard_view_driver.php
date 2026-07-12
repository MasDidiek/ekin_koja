<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemeriksaan Driver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js"></script>
    <link href="https://googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">


</head>
<body>
<div class="container-fluid p-0">
    <div class="dashboard-layout">
        <?php $this->load->view('admin/layouts/sidebar'); ?>
        <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar(false)"></div>
        <div class="main-content">
            <main class="p-4">
                <?php $this->load->view('admin/layouts/navbar'); ?>
                 <div class="d-none d-md-block mb-3">
                    <h4 class="fw-bold mb-1"> Pemeriksaan Driver</h4>
                   
                </div>



            <?php 
                $filterLabels = [
                    'belum_diperiksa' => 'Belum Diperiksa',
                    'laik' => 'Driver Laik',
                    'laik_catatan' => 'Driver Laik dengan Catatan',
                    'tidak_laik' => 'Driver Tidak Laik',
                    'hipertensi' => 'Driver dengan Hipertensi',
                    'gula_tinggi' => 'Driver dengan Gula Darah Tinggi',
                    'positif_alkohol' => 'Driver Positif Alkohol'
                ];
                $filterColors = [
                    'belum_diperiksa' => 'warning',
                    'laik' => 'success',
                    'laik_catatan' => 'info',
                    'tidak_laik' => 'danger',
                    'hipertensi' => 'danger',
                    'gula_tinggi' => 'warning',
                    'positif_alkohol' => 'danger'
                ];
            ?>
            
        

            <div class="card p-4 stat-card">
                <div class="table-responsive">
                        <div class="p-2 mb-3 text-muted">
                        <?= $filterLabels[$filter] ?? 'Unknown'; ?> ( <strong><?= count($drivers) ?></strong> pengemudi)
                    </div>
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Driver</th>
                                <th>No. KTP</th>
                                <th>No. HP</th>
                                <th>Tanggal Lahir</th>
                                <th>PO (Perusahaan)</th>
                                <th>Terminal</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($drivers) > 0): ?>
                                <?php $no = 1; foreach($drivers as $driver): ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><strong><?= $driver->nama ?? '-'; ?></strong></td>
                                        <td><?= $driver->no_ktp ?? '-'; ?></td>
                                        <td><?= $driver->no_hp ?? '-'; ?></td>
                                        <td><?= isset($driver->tgl_lahir) ? date('d/m/Y', strtotime($driver->tgl_lahir)) : '-'; ?></td>
                                        <td><?= $driver->nama_po ?? '-'; ?></td>
                                        <td><?= $driver->nama_terminal ?? '-'; ?></td>
                                        <td>
                                            <?php 
                                                $status = $driver->status_pemeriksaan;
                                                if($status == 0) echo '<span class="badge bg-warning">Belum Periksa</span>';
                                                else echo '<span class="badge bg-success">Sudah Periksa</span>';
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?= base_url('admin/admin_driver/detail/' . $driver->id) ?>" class="text-primary text-decoration-none">
                                                <i class="fas fa-eye"></i>  Lihat Detail</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted py-4">Tidak ada data driver</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </main>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</script>
<script>
    // Toggle sidebar behavior (matches dashboard main)
    function toggleSidebar(force) {
        const sidebar = document.querySelector('.sidebar');
        const overlay = document.getElementById('sidebarOverlay');
        if (!sidebar || !overlay) return;
        const isSmall = window.innerWidth < 1200;

        if (isSmall) {
            const isOpen = sidebar.classList.contains('open');
            if (typeof force === 'boolean') {
                if (force) {
                    sidebar.classList.add('open');
                    overlay.classList.add('active');
                } else {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                }
            } else {
                if (isOpen) {
                    sidebar.classList.remove('open');
                    overlay.classList.remove('active');
                } else {
                    sidebar.classList.add('open');
                    overlay.classList.add('active');
                }
            }
        } else {
            const isClosed = sidebar.classList.contains('closed');
            if (typeof force === 'boolean') {
                if (force) sidebar.classList.remove('closed');
                else sidebar.classList.add('closed');
            } else {
                if (isClosed) sidebar.classList.remove('closed');
                else sidebar.classList.add('closed');
            }
            overlay.classList.remove('active');
            sidebar.classList.remove('open');
        }
    }
</script>
</body>
</html>
