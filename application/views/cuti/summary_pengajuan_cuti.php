<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        .btn-back {
            padding: 10px 20px;
            background-color: #F8F8F8;
            margin-bottom: 20px;
        }


        table tr td {
            color: #464d5a !important;
        }

        .info-canceled {
            background-color: #ef4444;
            color: #FFF;
            width: 100%;
            padding: 1rem;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .table-sisa-cuti {
            padding: 20px;
            border: 1px solid #EEE;
        }

        .table-sisa-cuti table {
            width: 100%;
        }

        .table-sisa-cuti th,
        td {
            padding: 5px;
            border-bottom: 1px solid #e5e7eb;


        }

        .timeline-modern {
            position: relative;
            margin-left: 20px;
        }

        .timeline-modern::before {
            content: '';
            position: absolute;
            left: 16px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-step {
            position: relative;
            display: flex;
            gap: 16px;
            padding-bottom: 30px;
        }

        .timeline-step:last-child {
            padding-bottom: 0;
        }

        .timeline-dot {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            z-index: 1;
        }

        .timeline-content {
            background: #fff;
            padding: 10px 14px;
            border-radius: 8px;
            width: 100%;

        }

        /* STATUS */
        .timeline-step.completed .timeline-dot {
            background: #22c55e;
        }

        .timeline-step.pending .timeline-dot {
            background: #f59e0b;
        }

        .timeline-step.rejected .timeline-dot {
            background: #ef4444;
        }

        timeline-step {
            animation: fadeUp .4s ease;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>


    <div id="main-wrapper">
        <!-- Sidebar Start -->
        <aside class="left-sidebar with-vertical">
            <div><!-- ---------------------------------- -->
                <!-- Start Vertical Layout Sidebar -->
                <!-- ---------------------------------- -->

                <?php $this->load->view('layout/section/sidebar'); ?>

        </aside>

        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <?php $this->load->view('layout/section/header'); ?>
            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Pengajuan Cuti</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a href="<?php echo base_url(); ?>dashboard/index">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb">
                                                <a href="<?php echo base_url(); ?>admin/cuti/pengajuan_cuti_pegawai">Pengajuan Cuti </a>

                                            </li>
                                            <li> &nbsp; / &nbsp; </li>
                                            <li class="breadcrumb-active">Detail Pengajuan Cuti</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>


                        </div>
                    </div>


                    <?php
                    $id_pegawai_validator = $this->session->userdata("id_pegawai");

                    //print_array($cuti);


                    $id_cuti         = $cuti['id'];
                    $id_pegawai         = $cuti['id_pegawai'];

                    $cuti = (object) $cuti;

                    $delegasi = $cuti->delegasi_tugas;
                    $status_akhir = $cuti->status_akhir;

                    $jenis_cuti         = $cuti->jenis_cuti;
                    $alasan_cuti         = $cuti->alasan_cuti;
                    $created_at         = $cuti->created_at;

                    $infoPengaju = $this->ACM->getInfoPenggantiCuti($cuti->id_pegawai);
                    $infoPengganti = $this->ACM->getInfoPenggantiCuti($cuti->id_pengganti);
                    $approval         = $this->Cuti_model->getApprovalCuti($cuti->id);


                    // pecah berdasarkan koma ATAU baris baru
                    $listDelegasi = preg_split("/[\r\n,]+/", $delegasi);

                    // buang spasi & item kosong
                    $listDelegasi = array_filter(array_map('trim', $listDelegasi));



                    //print_array($infoPengganti);

                    $tahun_list         = [2025, 2026];
                    $tahun_now = date('Y');
                    $rekap_hak_cuti         = $this->ACM->get_rekap_cuti_pegawai_by_id($id_pegawai, $tahun_list);
                    $hakCutiBersama         = $this->ACM->getHakCutiBersama($id_pegawai, $tahun_now);

                    if ($status_akhir == 'dibatalkan') {
                        $class_hide = '';
                    } else {
                        $class_hide = 'd-none';
                    }
                    // print_array($hakCutiBersama );
                    //   [tahun] => 2026
                    // [hak_total] => 2
                    // [hak_terpakai] => 0
                    // [hak_reserved] => 1


                    //print_array($cuti);
                    $jenis_hak_cuti  = $cuti->jenis_hak_cuti; //tahunan/bersama


                    ?>



                    <div class="col-12">

                        <div class="info-canceled <?= $class_hide; ?>">
                            <i class="fa-solid fa-circle-info"></i> &nbsp; Pengajuan cuti ini sudah dibatalkan
                        </div>


                        <div class="page-title-box mb-4">



                            <a href="<?php echo base_url(); ?>cuti/index" class="btn-back">
                                <i class="fa-solid fa-arrow-left"></i> Kembali</a>

                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row fs-3" style="font-family: Arial, Helvetica, sans-serif;">



                    <!-- ================= KIRI : INFORMASI CUTI ================= -->
                    <div class="col-md-7">
                        <div class="card border-bawah-danger">
                            <div class="card-header">
                                <h5 class="mb-0">Informasi Pengajuan Cuti</h5>
                            </div>
                            <div class="card-body">



                                <h6 class="text-info">Pemohon Cuti</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="35%">Nama</th>
                                        <td width="3%">:</td>
                                        <td> <?= $cuti->nama_pemohon ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td width="3%">:</td>
                                        <td> <?= $infoPengaju->jabatan ?: '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Unit Kerja</th>
                                        <td width="3%">:</td>
                                        <td><?= $infoPengaju->puskesmas ?:  '-' ?></td>
                                    </tr>
                                </table>

                                <hr>

                                <table class="table table-sm table-borderless " style="color: #464d5a;">

                                    <tr>
                                        <th width="35%">Jenis Cuti</th>
                                        <td width="3%">:</td>
                                        <td><?= $cuti->jenis_cuti ?></td>
                                    </tr>

                                    <tr>
                                        <th>Tahun Hak Cuti</th>
                                        <td>:</td>
                                        <td><?= $cuti->tahun_hak_cuti ?> ( Hak cuti <?= $jenis_hak_cuti; ?>)</td>
                                    </tr>

                                    <tr>
                                        <th>Tanggal Pengajuan</th>
                                        <td>:</td>
                                        <td><?= date('d-m-Y', strtotime($cuti->tgl_pengajuan)) ?></td>
                                    </tr>

                                    <tr>
                                        <th>Tanggal Mulai Cuti</th>
                                        <td>:</td>
                                        <td><?= date('d-m-Y', strtotime($cuti->tgl_mulai)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal Akhir Cuti</th>
                                        <td>:</td>
                                        <td><?= date('d-m-Y', strtotime($cuti->tgl_selesai)) ?></td>
                                    </tr>



                                    <tr>
                                        <th>Lama Cuti</th>
                                        <td>:</td>
                                        <td><?= $cuti->lama_cuti ?> hari </td>
                                    </tr>

                                    <tr>
                                        <th>Alamat Selama Cuti</th>
                                        <td>:</td>
                                        <td><?= $cuti->alamat_cuti ?></td>
                                    </tr>

                                    <tr>
                                        <th>No. Telp</th>
                                        <td>:</td>
                                        <td><?= $cuti->no_telp ?></td>
                                    </tr>

                                    <tr>
                                        <th>Alasan Cuti</th>
                                        <td>:</td>
                                        <td><?= $cuti->alasan_cuti ?></td>
                                    </tr>

                                    <tr>
                                        <th class=" align-top">Delegasi Tugas</th>
                                        <td class="align-top">:</td>
                                        <td>
                                            <ul class="mb-0">
                                                <?php foreach ($listDelegasi as $item) : ?>
                                                    <li><?= htmlspecialchars($item) ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </td>
                                    </tr>

                                </table>

                                <hr>

                                <h6 class="text-warning">Pengganti Cuti</h6>
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="35%">Nama</th>
                                        <td width="3%">:</td>
                                        <td> <?= $cuti->nama_pengganti ?: '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Jabatan</th>
                                        <td width="3%">:</td>
                                        <td> <?= $infoPengganti->jabatan ?: '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Unit Kerja</th>
                                        <td width="3%">:</td>
                                        <td><?= $infoPengganti->puskesmas ?:  '-' ?></td>
                                    </tr>
                                </table>

                                <hr>

                                <center>
                                    <?php
                                    if ($status_akhir == 'proses' || $status_akhir == 'draft') {  ?>
                                        <a href="<?php echo base_url(); ?>cuti/edit_cuti/<?= $id_cuti; ?>" class="btn btn-info "> <i class="fa-solid fa-pencil"></i> Ubah</a>
                                        <button id="btn-approve" class="btn btn-danger" onclick="cancelCutiAjax(<?= $id_cuti ?>)">
                                            <i class="fa-solid fa-circle-check"></i> Batalkan
                                        </button>



                                    <?php } else if ($status_akhir == 'dibatalkan') { ?>

                                        <a href="<?php echo base_url(); ?>cuti/delete_cuti/<?= $id_cuti; ?>" class="btn btn-danger " onclick="return confirm('hapus pengajuan cuti ini?');"> <i class="fa-solid fa-trash"></i> Hapus</a>
                                    <?php } ?>
                                </center>


                            </div>
                        </div>
                    </div>

                    <!-- ================= KANAN : PROSES CUTI ================= -->
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0">Proses Persetujuan Cuti</h5>
                            </div>
                            <div class="card-body">
                                <div data-simplebar>
                                    <div class="timeline-modern">

                                        <!-- STEP 0 : PENGAJUAN -->
                                        <div class="timeline-step completed">
                                            <div class="timeline-dot bg-info">
                                                <i class="fa-solid fa-circle-check"></i>
                                            </div>
                                            <div class="timeline-content">
                                                <h6 class="text-info mb-1">Pengajuan Cuti</h6>
                                                <small><?= $jenis_cuti ?> “<?= $alasan_cuti ?>”</small>
                                                <div class="text-muted mt-1"><?= timeAgo($created_at) ?></div>
                                            </div>
                                        </div>




                                        <!-- STEP APPROVAL -->
                                        <?php foreach ($approval as $row) :
                                            $style = statusStyle($row['status']);

                                            $statusClass = $row['status'] === 'approved' ? 'completed' : ($row['status'] === 'rejected' ? 'rejected' : 'pending');
                                        ?>
                                            <div class="timeline-step <?= $statusClass ?>">
                                                <div class="timeline-dot <?= $style['bg'] ?>">
                                                    <i class="fa-solid <?= $style['icon'] ?>"></i>
                                                </div>
                                                <div class="timeline-content">
                                                    <h6 class="<?= $style['text'] ?> mb-1">
                                                        Persetujuan <?= ucfirst($row['role_approval']) ?>
                                                    </h6>
                                                    <small><?= $row['nama'] ?: '-' ?></small>

                                                    <div class="mt-1">
                                                        <span class="<?= $style['text'] ?>">
                                                            <?= $style['label'] ?>
                                                        </span>
                                                        <?php if ($row['approved_at']) : ?>
                                                            <div class="text-muted"><?= timeAgo($row['approved_at']) ?></div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endforeach; ?>

                                    </div>
                                </div>
                                <hr>

                                <h5>Sisa Cuti</h5>

                                <div class="table-sisa-cuti">

                                    <table>
                                        <tr style="background-color: #e5e7eb;">

                                            <th>Hak Cuti Tahun</th>
                                            <th class="text-dark">Jumlah</th>
                                            <th class="text-danger">Digunakan</th>
                                            <th class="text-warning">Pending</th>
                                            <th class="text-success">Sisa Akhir</th>
                                        </tr>
                                        <?php foreach ($rekap_hak_cuti as $tahun => $cuti) : ?>
                                            <tr>
                                                <td class="text-center"><?= $tahun ?></td>
                                                <td class="text-center"><?= $cuti['hak'] ?></td>
                                                <td class="text-center"><?= $cuti['terpakai'] ?></td>
                                                <td class="text-center"><?= $cuti['reserved'] ?></td>
                                                <td class="text-center fw-bold"><?= $cuti['sisa'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                        <?php
                                        $sisaBersama = $hakCutiBersama['hak_total'] - $hakCutiBersama['hak_terpakai'] - $hakCutiBersama['hak_reserved'];
                                        ?>
                                        <tr>
                                            <td class="text-center"><?= $hakCutiBersama['tahun'] ?></td>
                                            <td class="text-center"><?= $hakCutiBersama['hak_total'] ?></td>
                                            <td class="text-center"><?= $hakCutiBersama['hak_terpakai'] ?></td>
                                            <td class="text-center"><?= $hakCutiBersama['hak_reserved'] ?></td>
                                            <td class="text-center fw-bold"><?= $sisaBersama ?></td>
                                        </tr>
                                    </table>



                                </div>
                                <strong>ket :</strong> <br>
                                - <span class="text-danger">Digunakan : </span> Cuti yang sudah disetujui oleh Kasubbag TU / Kepala Puskesmas Cilincing <br>
                                - <span class="text-warning">Pending : </span> Cuti yang masih dalam proses pengajuan (belum disetujui) <br>
                                - <span class="text-success">Sisa Akhir : </span> Sisa Cuti yang dapat digunakan
                                <br><br>
                                <p>Sisa cuti akan tetap memotong hak cuti meskipun pengajuan masih dalam status <strong>pending</strong> <br>
                                    Hak cuti akan dikembalikan jika cuti dibatalkan atau pengajuan ditolak
                                </p>

                            </div>
                        </div>
                    </div>

                </div>


            </div>



            <div class="py-6 px-6 text-center">
                <p class="mb-0 fs-4">Design and Developed by
                    <a href="#" target="_blank" class="pe-1 text-primary text-decoration-underline">DhifaWebStudio</a>
                </p>
            </div>

            <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
            <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
            <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>dashboard.js"></script>


            <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

            <script>
                function lockButtons() {
                    document.getElementById('btn-approve')?.setAttribute('disabled', true);
                    document.getElementById('btn-reject')?.setAttribute('disabled', true);
                }

                function cancelCutiAjax(id) {
                    Swal.fire({
                        title: '<span style="font-size:18px">Apakah anda yakin untuk membatalkan Pengajuan Cuti ini?</span>',
                        text: '',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, batalkan',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            lockButtons();

                            fetch("<?= base_url('cuti/cancel') ?>", {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json'
                                    },
                                    body: JSON.stringify({
                                        id_pengajuan: id
                                    })
                                })
                                .then(res => res.json())
                                .then(res => {
                                    if (res.status) {
                                        Swal.fire({
                                            toast: true,
                                            position: 'top-end',
                                            icon: 'success',
                                            title: res.message,
                                            showConfirmButton: false,
                                            timer: 3000
                                        });

                                        setTimeout(() => location.reload(), 1000);
                                    } else {
                                        Swal.fire('Gagal', res.message, 'error');
                                    }
                                })
                                .catch(() => {
                                    Swal.fire('Error', 'Terjadi kesalahan sistem', 'error');
                                });
                        }
                    });
                }
            </script>



</body>

</html>