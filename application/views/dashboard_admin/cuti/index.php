<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.css'); ?>">
    <link rel="stylesheet" href="<?php echo base_url('assets/dashboard_admin/style.css'); ?>">

    <style>
        .td-link {
            text-decoration: none;
            color: cadetblue;
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
            $months = [
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember',
            ];
            $currentYear = date('Y');
            $years = range($currentYear - 2, $currentYear + 1);
            $currMonth = date('m') - 1;

            $selectedMonth = $this->input->get('bulan');
            $selectedYear = $this->input->get('tahun');

            $selectedStatus = $this->input->get('status_akhir');
            $selectedType = $this->input->get('jenis_cuti');



            $jenisCuti = [
                1 => [
                    'label' => 'Cuti Tahunan',
                    'class' => 'text-primary'
                ],
                2 => [
                    'label' => 'Cuti Bersalin',
                    'class' => 'text-success'
                ],
                3 => [
                    'label' => 'Cuti Alasan Penting',
                    'class' => 'text-warning'
                ],
                4 => [
                    'label' => 'Lainnya',
                    'class' => 'text-secondary'
                ],
            ];

            $statusMapping = [
                'draft' => ['label' => 'Draft', 'class' => 'status-pending'],
                'proses' => ['label' => 'Proses', 'class' => 'status-proses'],
                'disetujui' => ['label' => 'Disetujui', 'class' => 'status-approved'],
                'ditolak' => ['label' => 'Ditolak', 'class' => 'status-rejected'],
                'dibatalkan' => ['label' => 'Dibatalkan', 'class' => 'status-canceled'],
            ];

            //print_array($cuti);
            ?>


            <section class="overview">

                <div class="card">
                    <h3>Data Pengajuan cuti</h3>
                    <p>Daftar pengajuan cuti karyawan berikut status dan tanggalnya.</p>
                </div>

                <div class="card">
                    <form method="get" action="<?php echo base_url('cuti'); ?>">
                        <div class="filter-panel">
                            <div class="filter-group">
                                <label class="filter-label" for="month-filter">Bulan</label>
                                <select id="month-filter" name="bulan" class="filter-select">
                                    <option value="">Semua Bulan</option>
                                    <?php foreach ($months as $value => $label) : ?>
                                        <option value="<?php echo $value; ?>" <?php echo ($selectedMonth === (string) $value) ? 'selected' : ''; ?>><?php echo $label; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label" for="year-filter">Tahun</label>
                                <select id="year-filter" name="tahun" class="filter-select">
                                    <option value="">Semua Tahun</option>
                                    <?php foreach ($years as $year) : ?>
                                        <option value="<?php echo $year; ?>" <?php echo ($selectedYear === (string) $year) ? 'selected' : ''; ?>><?php echo $year; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label" for="type-filter">Jenis Cuti</label>
                                <select id="type-filter" name="jenis_cuti" class="filter-select">
                                    <option value="">Semua Jenis</option>
                                    <option value="1" <?php echo ($selectedType === '1') ? 'selected' : ''; ?>>Cuti Tahunan</option>
                                    <option value="2" <?php echo ($selectedType === '2') ? 'selected' : ''; ?>>Cuti Bersalin</option>
                                    <option value="3" <?php echo ($selectedType === '3') ? 'selected' : ''; ?>>Cuti Alasan Penting</option>
                                    <option value="4" <?php echo ($selectedType === '4') ? 'selected' : ''; ?>>Cuti Sakit</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label" for="status-filter">Status</label>
                                <select id="status-filter" name="status_akhir" class="filter-select">
                                    <option value="">Semua Status</option>
                                    <option value="draft" <?php echo ($selectedStatus === 'draft') ? 'selected' : ''; ?>>Pengajuan</option>
                                    <option value="disetujui" <?php echo ($selectedStatus === 'disetujui') ? 'selected' : ''; ?>>Disetujui</option>
                                    <option value="proses" <?php echo ($selectedStatus === 'proses') ? 'selected' : ''; ?>>Proses</option>
                                    <option value="ditolak" <?php echo ($selectedStatus === 'ditolak') ? 'selected' : ''; ?>>Ditolak</option>
                                </select>
                            </div>
                            <div class="filter-group">
                                <label class="filter-label" for="search-name">Cari Nama</label>
                                <input id="search-name" type="text" placeholder="Cari nama pegawai..." class="filter-input" />
                            </div>
                            <div class="filter-actions">

                                <button class="filter-button" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>

                    Total : <strong id="total-rows"><?php echo count($cuti); ?></strong> Rows
                    <br><br>

                    <div class="table-wrapper">

                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th class="text-start">Nama Pegawai</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Selesai</th>
                                    <th>Durasi</th>
                                    <th>Alasan Cuti</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($cuti)) : ?>
                                    <?php $no = 1; ?>
                                    <?php foreach ($cuti as $row) : ?>
                                        <?php
                                        $statusKey = strtolower(str_replace(' ', '', $row['status_akhir']));
                                        $statusInfo = isset($statusMapping[$statusKey]) ? $statusMapping[$statusKey] : ['label' => $row['status_akhir'], 'class' => 'status-pending'];
                                        $cuti = $jenisCuti[$row['jenis_cuti']];
                                        if ($cuti == '') {
                                            $cuti =
                                                [
                                                    'label' => 'Tidak Diketahui',
                                                    'class' => 'text-dark'
                                                ];
                                        }
                                        ?>
                                        <tr class="row-link">
                                            <td><?php echo $no++; ?></td>
                                            <td class="fw-bold text-start">
                                                <a href="<?php echo site_url('dashboard_admin/cuti_detail/' . $row['id']); ?>" class="td-link">
                                                    <?php echo htmlspecialchars($row['nama']); ?>
                                                </a>
                                            </td>
                                            <td class="<?= $cuti['class']; ?>"><?php echo $cuti['label']; ?></td>
                                            <td><?php echo date('d M Y', strtotime($row['tgl_mulai'])); ?></td>
                                            <td><?php echo date('d M Y', strtotime($row['tgl_selesai'])); ?></td>
                                            <td><?php echo $row['lama_cuti']; ?> hari</td>
                                            <td class="text-start"><?php echo htmlspecialchars(substr($row['alasan_cuti'], 0, 30)); ?></td>
                                            <td><span class="status-pill <?php echo $statusInfo['class']; ?>"><?php echo $statusInfo['label']; ?></span></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="8" style="text-align: center; padding: 20px; color: #999;">Tidak ada data cuti</td>
                                    </tr>
                                <?php endif; ?>
                                <tr id="no-results-row" class="no-results" style="display:none;">
                                    <td colspan="8" style="text-align: center; padding: 20px; color: #999;">Nama pegawai tidak ditemukan.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </main>
    </div>
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

            var searchInput = document.getElementById('search-name');
            var tableBody = document.querySelector('.data-table tbody');
            var filterForm = document.querySelector('form');
            var tableRows = Array.from(tableBody.querySelectorAll('tr')).filter(function(row) {
                return !row.classList.contains('no-results');
            });
            var noResultsRow = document.getElementById('no-results-row');
            var totalRowsCounter = document.getElementById('total-rows');

            function updateRowCount(visibleCount) {
                if (totalRowsCounter) {
                    totalRowsCounter.textContent = visibleCount;
                }
            }

            function filterRows() {
                var query = (searchInput && searchInput.value || '').trim().toLowerCase();
                var visibleCount = 0;

                tableRows.forEach(function(row) {
                    var nameCell = row.querySelector('td:nth-child(2)');
                    var nameText = nameCell ? nameCell.textContent.trim().toLowerCase() : '';
                    var visible = !query || nameText.indexOf(query) !== -1;
                    row.style.display = visible ? '' : 'none';
                    if (visible) {
                        visibleCount++;
                    }
                });

                if (noResultsRow) {
                    noResultsRow.style.display = visibleCount === 0 ? '' : 'none';
                }
                updateRowCount(visibleCount);
            }

            if (searchInput) {
                searchInput.addEventListener('input', filterRows);
            }

            if (filterForm) {
                filterForm.addEventListener('reset', function() {
                    setTimeout(filterRows, 0);
                });
            }

            var rows = document.querySelectorAll('.row-link');
            rows.forEach(function(row) {
                row.addEventListener('dblclick', function() {
                    var href = this.getAttribute('data-href');
                    if (href) {
                        window.location.href = href;
                    }
                });
            });
        });
    </script>
</body>

</html>