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
     <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">

    <style>
        td a {
            text-decoration: none !important;
        }

        .avatar-circle {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #2563eb, #60a5fa);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.18);
        }

        .info-item {

            border-radius: 0.85rem;
            height: 100%;
        }

        .info-item .label {
            display: block;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
            margin-bottom: 0.25rem;
        }

        .detail-soft-card {
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
        }
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
                    <h4 class="fw-bold mb-1"> Pengemudi</h4>
                   
                    <div class="breadcrums">
                       <a href="<?php echo base_url('admin/dashboard'); ?>">Home</a> / 
                       <a href="<?php echo base_url('admin/admin_driver'); ?>">Pengemudi</a> / Detail Pengemudi
                    </div>
                </div>

                      
                       <?php
                            $id_driver =  $data_detail[0]->id;
                            $status_kawin =  $data_detail[0]->status_kawin;
                            if($status_kawin=='BM'){
                                $s_nikah = 'Belum Menikah';
                            }else if($status_kawin=='M'){
                                $s_nikah = 'Menikah';
                            }else if($status_kawin=='D'){
                                $s_nikah = 'Duda';
                            }else{
                                $s_nikah = 'Janda';
                            }
        
                
                      ?>


<div class="card p-4 stat-card detail-soft-card">
                <div class="card-header bg-white border-0 p-0 mb-4">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar-circle text-white fw-bold">
                                <?php echo strtoupper(substr($data_detail[0]->nama, 0, 1)); ?>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-1"><?php echo $data_detail[0]->nama;?></h4>
                                <p class="text-muted mb-0">Detail profil pengemudi</p>
                            </div>
                        </div>
                        <div class="d-flex flex-wrap gap-2">
                            <a href="<?php echo base_url();?>admin/admin_driver/index" class="btn btn-light border"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
                            <a href="<?php echo base_url();?>admin/admin_driver/ubah_data_pengemudi/<?php echo $data_detail[0]->id;?>" class="btn btn-info text-white"><i class="fa-solid fa-pen-to-square"></i> Ubah Data</a>
                            <a href="<?php echo base_url();?>admin/admin_driver/delete/<?php echo $id_driver;?>" onClick="return confirm('Hapus data pengemudi ini?');" class="btn btn-danger">
                                <i class="fa-solid fa-trash"></i> Hapus
                            </a>
                        </div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-lg-7">
                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <div class="info-item">
                                    <span class="label">Nama Lengkap</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->nama;?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-item">
                                    <span class="label">NIK</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->no_ktp;?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-item">
                                    <span class="label">Tanggal Lahir</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->tgl_lahir;?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-item">
                                    <span class="label">Jenis Kelamin</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->jns_kel == "L" ? "Laki-laki" : "Perempuan"; ?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-item">
                                    <span class="label">No HP</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->no_hp;?></div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="info-item">
                                    <span class="label">Status Pernikahan</span>
                                    <div class="fw-semibold text-dark"><?php echo $s_nikah;?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-lg-5">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="info-item">
                                    <span class="label">Alamat</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->alamat;?></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-item">
                                    <span class="label">Pendidikan</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->pendidikan;?></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-item">
                                    <span class="label">Pekerjaan</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->pekerjaan;?></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-item">
                                    <span class="label">Nama PO</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->nama_po;?></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="info-item">
                                    <span class="label">Status Supir</span>
                                    <div class="fw-semibold text-dark"><?php echo $data_detail[0]->status_supir;?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <div class="table-responsive border-0 mt-4">
                    <div class="modal fade" id="defaultModalPrimary" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Detail Pemeriksaan</h5>
                                </div>
                                <div class="modal-body m-3" id="content-modal">
                                    <p class="mb-0"></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <div>
                            <h5 class="fw-bold mb-1">Riwayat Pemeriksaan</h5>
                            <p class="text-muted small mb-0">Catatan pemeriksaan kesehatan driver secara berkala</p>
                        </div>
                        <a href="<?php echo base_url();?>admin/admin_driver/periksa/<?php echo $id_driver;?>" class="btn btn-primary">
                            <i class="fa-solid fa-stethoscope"></i> Periksa Pengemudi
                        </a>
                    </div>
                        
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal Periksa</th>
                                    <th>Hipertensi</th>
                                    <th>Gula Darah</th>
                                    <th>Status Laik</th>
                                    <th>Terminal</th>
                                    <th>Rujuk</th>
                                    <th>Petugas</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                            for ($i=0; $i < count($history); $i++) {
                                $id = $history[$i]->id;
                                $tgl_periksa = $history[$i]->date_time;
                                $status_ht = $history[$i]->status_ht;
                                $status_gds = $history[$i]->status_gds;
                                $status_laik = $history[$i]->status_laik;
                                $petugas = $history[$i]->petugas;
                                $rujuk = $history[$i]->rujuk;

                                $tensi_sistol = $history[$i]->tensi_sistol;
                                $tensi_diastol = $history[$i]->tensi_diastol;
                                $nama_terminal = $history[$i]->nama_terminal;
                                $gds = $history[$i]->gds;

                                $flagHT = getFlagHT($status_ht);
                                $flagGDS = getFlagGDS($status_gds);
                                $flagLaik = getFlagLaik($status_laik);

                                if($rujuk==1){
                                    $status_rujuk = '<i class="fas fa-check text-success"></i>';
                                }else{
                                    $status_rujuk = '';
                                }

                            echo ' <tr>
                                        <td align="center">'.($i+1).'</td>
                                        <td align="center">'. $tgl_periksa.'</td>
                                        <td align="center">'.$flagHT.'</td>
                                        <td align="center">'.$flagGDS.'</td>
                                        <td align="center">'.$flagLaik.'</td>
                                        <td>'.$nama_terminal.'</td>
                                        <td align="center">'.$status_rujuk.'</td>
                                        <td>'. $petugas .'</td>
                                        <td class="text-center">
                                            <button type="button" value="'.$id.'" class="btn btn-sm btn-outline-primary lihat-detail" data-bs-toggle="modal" data-bs-target="#defaultModalPrimary">
                                                Detail
                                            </button>
                                        </td>
                                    </tr>';
                            }
                            ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
            </main>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

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
