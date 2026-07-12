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

    <style>
        .dashboard-layout {
            display: flex;
            flex-wrap: nowrap;
            width: 100%;
            min-height: 100vh;
            align-items: stretch;
            position: relative;
            overflow-x: hidden;
        }
        .main-content {
            flex: 1 1 auto;
            width: 100%;
            min-width: 0;
        }
        .sidebar {
            flex: 0 0 250px;
            flex-shrink: 0;
        }
        /* overlay handled in global CSS */
    </style>

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
                        <h4 class="fw-bold mb-1">Dashboard Pemeriksaan Driver</h4>
                        <p class="text-muted mb-0">Ringkasan status kesehatan dan pemeriksaan driver secara komprehensif.</p>
                    </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Total Pengemudi</small>
                                <h3 class="fw-bold mt-2 mb-0"><?= isset($total_driver) ? $total_driver : 0; ?></h3>
                            </div>
                            <div class="stat-icon bg-primary-subtle text-primary">👥</div>
                        </div>
                         <a href="<?= base_url(); ?>admin/admin_driver" class="btn btn-sm btn-primary mt-3 w-100">Lihat Detail</a>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Belum Diperiksa</small>
                                <h3 class="fw-bold mt-2 mb-0 text-warning"><?= isset($belum_diperiksa) ? $belum_diperiksa : 0; ?></h3>
                            </div>
                            <div class="stat-icon bg-warning-subtle text-warning">⏳</div>
                        </div>
                        <button class="btn btn-sm btn-warning mt-3 w-100" onclick="viewDriver('belum_periksa')">Lihat Detail</button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Driver Laik</small>
                                <h3 class="fw-bold mt-2 mb-0 text-success"><?= isset($driver_laik) ? $driver_laik : 0; ?></h3>
                            </div>
                            <div class="stat-icon bg-success-subtle text-success"> <i class="fas fa-check"></i> </div>
                        </div>
                        <button class="btn btn-sm btn-success mt-3 w-100" onclick="viewDriver('laik')">Lihat Detail</button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Laik + Catatan</small>
                                <h3 class="fw-bold mt-2 mb-0 text-info"><?= isset($driver_laik_catatan) ? $driver_laik_catatan : 0; ?></h3>
                            </div>
                            <div class="stat-icon bg-info-subtle text-info">📋</div>
                        </div>
                        <button class="btn btn-sm btn-info mt-3 w-100" onclick="viewDriver('laik_catatan')">Lihat Detail</button>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-4">
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Tidak Laik</small>
                                <h3 class="fw-bold mt-2 mb-0 text-danger"><?= isset($driver_tidak_laik) ? $driver_tidak_laik : 0; ?></h3>
                            </div>
                            <div class="stat-icon bg-danger-subtle text-danger"><i class="fas fa-exclamation-triangle"></i> </div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger mt-3 w-100" onclick="viewDriver('tidak_laik')">Lihat Detail</button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Hipertensi</small>
                                <h3 class="fw-bold mt-2 mb-0 text-danger"><?= isset($driver_hipertensi) ? $driver_hipertensi : 0; ?></h3>
                            </div>
                            <div class="stat-icon bg-danger-subtle text-danger">❤️</div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger mt-3 w-100" onclick="viewDriver('hipertensi')">Lihat Detail</button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Gula Tinggi</small>
                                <h3 class="fw-bold mt-2 mb-0 text-warning"><?= isset($driver_gula_tinggi) ? $driver_gula_tinggi : 0; ?></h3>
                            </div>
                            <div class="stat-icon bg-warning-subtle text-warning">🩺</div>
                        </div>
                        <button class="btn btn-sm btn-outline-warning mt-3 w-100" onclick="viewDriver('gula_tinggi')">Lihat Detail</button>
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card stat-card p-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <small class="text-uppercase text-muted fw-bold">Positif Alkohol</small>
                                <h3 class="fw-bold mt-2 mb-0 text-danger"><?= isset($driver_positif_alkohol) ? $driver_positif_alkohol : 0; ?></h3>
                            </div>
                            <div class="stat-icon bg-danger-subtle text-danger">🚫</div>
                        </div>
                        <button class="btn btn-sm btn-outline-danger mt-3 w-100" onclick="viewDriver('positif_alkohol')">Lihat Detail</button>
                    </div>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-12 col-xl-8">
                    <div class="card chart-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Status Driver Berdasarkan Hasil Pemeriksaan</h5>
                                <p class="text-muted small mb-0">Distribusi driver laik, laik dengan catatan, dan tidak laik</p>
                            </div>
                        </div>
                        <div class="chart-wrapper">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-4">
                    <div class="card chart-card p-4">
                        <h5 class="fw-bold mb-1">Persentase Status Laik</h5>
                        <p class="text-muted small mb-0">Dari <?= isset($total_driver) ? $total_driver : 0; ?> total pengemudi</p>
                        <div class="chart-wrapper d-flex align-items-center justify-content-center">
                            <canvas id="donutChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Pemeriksaan Terbaru -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card chart-card p-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-bold mb-1">Data 10 Pemeriksaan Terakhir</h5>
                                <p class="text-muted small mb-0">Riwayat pemeriksaan terbaru</p>
                            </div>
                            <a href="#" class="btn btn-sm btn-primary">Lihat Semua Pemeriksaan</a>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Driver</th>
                                        <th>Terminal</th>
                                        <th>Petugas</th>
                                        <th>Status Laik</th>
                                        <th>HT</th>
                                        <th>GDS</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if(isset($pemeriksaan_terbaru) && count($pemeriksaan_terbaru) > 0): ?>
                                        <?php foreach($pemeriksaan_terbaru as $periksa): ?>
                                            <tr>
                                                <td><?= date('d/m/Y H:i', strtotime($periksa->date_time)); ?></td>
                                                <td><strong><?= $periksa->nama ?? '-'; ?></strong></td>
                                                <td><?= $periksa->nama_terminal ?? '-'; ?></td>
                                                <td><?= $periksa->petugas ?? '-'; ?></td>
                                                <td>
                                                    <?php 
                                                        $status = $periksa->status_laik;
                                                        $badge = '';
                                                        if($status == 1) $badge = '<span class="badge bg-success">Laik</span>';
                                                        else if($status == 2) $badge = '<span class="badge bg-info">Laik+Cat</span>';
                                                        else if($status == 3) $badge = '<span class="badge bg-danger">Tidak Laik</span>';
                                                        else $badge = '<span class="badge bg-secondary">-</span>';
                                                        echo $badge;
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $status_ht = $periksa->status_ht;
                                                        if($status_ht >= 3) echo '<span class="badge bg-danger">Masalah</span>';
                                                        else echo '<span class="badge bg-success">Normal</span>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php 
                                                        $status_gds = $periksa->status_gds;
                                                        if($status_gds >= 3) echo '<span class="badge bg-warning">Tinggi</span>';
                                                        else echo '<span class="badge bg-success">Normal</span>';
                                                    ?>
                                                </td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-outline-primary">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">Belum ada data pemeriksaan</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            </main>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Data dari controller
    const driverLaik = <?= isset($driver_laik) ? $driver_laik : 0 ?>;
    const driverLaikCatatan = <?= isset($driver_laik_catatan) ? $driver_laik_catatan : 0 ?>;
    const driverTidakLaik = <?= isset($driver_tidak_laik) ? $driver_tidak_laik : 0 ?>;
    const statusLaikData = <?= isset($status_laik_json) ? $status_laik_json : '[0, 0, 0]' ?>;

    // Bar Chart - Status Driver
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: ['Laik', 'Laik + Catatan', 'Tidak Laik'],
            datasets: [{
                label: 'Jumlah Driver',
                data: [driverLaik, driverLaikCatatan, driverTidakLaik],
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderRadius: 8,
                maxBarThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 10 }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });

    // Donut Chart - Status Laik Persentase
    new Chart(document.getElementById('donutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Laik', 'Laik + Catatan', 'Tidak Laik'],
            datasets: [{
                data: statusLaikData,
                backgroundColor: ['#10b981', '#f59e0b', '#ef4444'],
                borderWidth: 2,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            }
        }
    });

    // Function untuk melihat detail driver berdasarkan status
    function viewDriver(status) {
        const filterMap = {
            'belum_periksa': 'belum_diperiksa',
            'laik': 'laik',
            'laik_catatan': 'laik_catatan',
            'tidak_laik': 'tidak_laik',
            'hipertensi': 'hipertensi',
            'gula_tinggi': 'gula_tinggi',
            'positif_alkohol': 'positif_alkohol'
        };
        // Redirect ke halaman list driver dengan filter
        window.location.href = '<?= base_url('admin/dashboard/view_driver'); ?>?filter=' + filterMap[status];
    }

        function toggleSidebar(force) {
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (!sidebar || !overlay) return;
            const isSmall = window.innerWidth < 1200;

            if (isSmall) {
                // Mobile behavior: use open + overlay
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
                // Desktop behavior: toggle closed state (no overlay)
                const isClosed = sidebar.classList.contains('closed');
                if (typeof force === 'boolean') {
                    if (force) sidebar.classList.remove('closed');
                    else sidebar.classList.add('closed');
                } else {
                    if (isClosed) sidebar.classList.remove('closed');
                    else sidebar.classList.add('closed');
                }
                // ensure overlay is hidden on desktop
                overlay.classList.remove('active');
                sidebar.classList.remove('open');
            }
        }
</script>
</body>
</html>
