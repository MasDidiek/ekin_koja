<!DOCTYPE html>
<?php
$theme = $this->session->userdata('theme');
$theme = (isset($theme) && $theme != '') ? $theme : 'light';
?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap4.min.css">

    <style>
        .custom-badge {
            font-size: 12px !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 0.25rem !important;
            color: #FFF !important;
        }

        /* TABLE: hanya garis horizontal */
        #tbl-validasi {
            border-collapse: collapse;
        }

        #tbl-validasi thead th {
            border-left: none !important;
            border-right: none !important;
            border-top: none;
            border-bottom: 2px solid #dee2e6;
        }

        #tbl-validasi tbody td {
            border-left: none !important;
            border-right: none !important;
            border-top: none;
            border-bottom: 1px solid #e9ecef;
        }

        /* hover row lebih halus */
        #tbl-validasi tbody tr:hover {
            background-color: #f8f9fa;
        }
    </style>
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
                                    <h4 class="fw-semibold mb-8">Penilaian Kinerja</h4>
                                    <nav aria-label="breadcrumb">
                                       <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                            <a class="text-muted text-decoration-none" href="<?= base_url('dashboard/index') ?>">Home</a>
                                        </li>

                                        <li> &nbsp; / &nbsp; </li>

                                        <li class="breadcrumb-acive">Rencana Kinerja</li>
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


                     $tahun_renkin     = $this->input->get('tahun');

                        if(empty($tahun_renkin)){
                        $tahun_renkin = date('Y');
                        }
                    
                        $tahun_awal = 2026;
                        $tahun_akhir = $tahun_renkin+5;

                        
   
                   // print_array($list_pegawai);
                    ?>

                    <div class="card">
                        <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <!-- Form Filter Menggunakan Method GET -->
                                        
                                        <form action="<?= base_url('admin/renkin/index'); ?>" method="get" class="form-inline">
                                            <div class="form-group" style="max-width: 300px;">
                                                <label for="tahun" class="mr-2">Tahun:</label>
                                                <div class="input-group">
                                                    <select name="tahun" id="tahun" class="custom-select form-control" style="width: auto; margin-right: 10px;">
                                                        <?php
                                                        for ($i = $tahun_awal; $i <= $tahun_akhir; $i++) {
                                                        $selected = ($i == $tahun_renkin) ? 'selected' : '';
                                                        echo "<option value='$i' $selected>$i</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" type="submit">Submit</button>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                    </div>

                                

                                    <div class="table-responsive">
                                    

                                        <div class="clearfix"></div>
                                        <table class="table table-bordered table-hover table-sm mt-3" id="tbl-validasi">
                                            <thead class="table-light text-center">
                                                        <tr>
                                                            <th width="50">No</th>
                                                            <th>Nama Pegawai</th>
                                                            <th width="250">NIP</th>
                                                            <th>Jabatan</th>
                                                            <th  class="text-center">Jenis Pegawai</th>
                                                            <th  class="text-center">Aksi</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        
                                                        <?php
                                                      
                                                            $no = 1;
                                                            foreach ($list_pegawai as $pegawai): ?>
            
                                                                <tr>
                                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                                    <td><?php echo $pegawai->nama; ?></td>
                                                                    <td class="text-start"><?php echo $pegawai->nip; ?></td>
                                                                    <td class="text-start"><?php echo $pegawai->jabatan; ?></td>
                                                                    <td class="text-center">
                                                                        <?php
                                                                        if ($pegawai->jns_pegawai == 'non_pns') {
                                                                            echo '<span class="badge bg-success custom-badge">Non PNS</span>';
                                                                        } elseif ($pegawai->jns_pegawai == 'pppk_pw') {
                                                                            echo '<span class="badge bg-primary custom-badge">PPPK PW</span>';
                                                                        } else {
                                                                            echo '<span class="badge bg-secondary custom-badge">Lainnya</span>';
                                                                        }
                                                                        ?>
                                                                    <td class="text-center">
                                                                        <a href="<?php echo base_url('admin/renkin/validasi_renkin?id_pegawai=' . $pegawai->id_pegawai.'&tahun=' . $tahun_renkin); ?>" class="btn btn-sm btn-primary" title="Lihat Renkin">
                                                                            <i class="ti ti-eye"></i> Lihat Renkin
                                                                        </a>
                                                                    </td>
                                                                </tr>           
                                                    
                                                        <?php endforeach; ?>
                                                       
                                                  
                                                    </tbody>
                                        </table>
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
    <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap4.min.js"></script>

    <script>
        function handleColorTheme(e) {
            $("html").attr("data-color-theme", e);
            $(e).prop("checked", !0);
        }
        

         $(document).ready(function() {
            $('#tbl-validasi').DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                ordering: true,
                searching: true,
                info: true,
                autoWidth: false,
                columnDefs: [
                    { orderable: false, targets: [3] } // Nonaktifkan pengurutan pada kolom ke-4 (Aksi)
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
</body>

</html>