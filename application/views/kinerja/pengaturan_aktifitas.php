<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">                                        
<style>
  .ui-autocomplete {
    z-index: 9999 !important;
    position: absolute;
    background-color: #fff; /* untuk jaga-jaga kalau transparan */
    border: 1px solid #ddd;
    max-height: 300px;
    overflow-y: auto;
  }
</style>

    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('layout/section/sidebar');?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view('layout/section/topbar');?>

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                             <li class="breadcrumb-item"><a href="javascript: void(0);">Kinerja</a></li>
                                            <li class="breadcrumb-item active">Pengaturan Aktifitas</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Pengaturan Aktifitas</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                        <?php
                          $info = $this->session->flashdata('message');

                          $list_bulan = array_bulan();

                           $id_pj_sess = $this->session->userdata('id_pj');
                           $id_user_validator   = $this->session->userdata('id_pegawai');
                         ?>

                            <div class="col-xxl-12col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Datalist Aktifitas</h4>
                                        <br>

                                      <button type="button" class="btn btn-sm btn-primary float-end" data-bs-toggle="modal"  data-bs-target="#modalAktifitas">Tambah List Aktifitas</button>
                                      <div class="clearfix"></div>
                                            <br>

                                    
                                           <table id="datatable-buttons" class="table table-sm dt-responsive nowrap w-100 mt-3">
                                                <thead class="bg-light">
                                                      <tr>

                                                          <th>No</th>
                                                          <th>Nama Kegiatan</th>
                                                           <th>Satuan</th>
                                                          <th>Waktu</th>
                                                          <th>Action</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody class="list form-check-all" id="data_list">
                                                  
                                                        <?php 
                                                                $no = 1;
                                                                foreach ($aktifitas_utama as $aktifitas){

                                                                    $id             = $aktifitas->id;
                                                                    $nama_kegiatan  = $aktifitas->nama_kegiatan;
                                                                    $satuan         = $aktifitas->satuan;
                                                                    $waktu          = $aktifitas->waktu;

                                                                

                                                                    echo' <tr>
                                                                                <td class="text-center">'.$no.' </td>

                                                                                <td> '.$nama_kegiatan.'</td>
                                                                                <td>'.$satuan.' </td>
                                                                                <td>'.$waktu.' menit </td>
                                                                                <td> 
                                                                                <a href="'.base_url().'kinerja/delete_aktifitas_utama/'.$id.'" class="btn btn-danger btn-sm" title="Delete from list">
                                                                                    Hapus
                                                                                </a>
                                                                                </td>
                                                                                
                                                                            </tr>';

                                                                            $no += 1;
                                                                        

                                                        }


                                                        ?>
                                              
                                                       
                                                  </tbody>

                                                    
                                              </table>


                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                     </div>
                  </div> <!-- container -->
                </div> <!-- content -->

               <!-- Modal -->
            <div class="modal fade" id="modalAktifitas" tabindex="-1" aria-labelledby="modalAktifitasLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <form id="formAktifitas" method="POST">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="modalAktifitasLabel">Tambah Aktivitas Pegawai</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <div id="info-add" class="alert alert-info"> Cari nama aktifitas lalu klik tambahkan, jika sudah selesai, refresh halaman</div>
                            <label for="nama_aktivitas" class="form-label">Nama Aktivitas</label>
                            <div class="row">
                                <div class="col-10"><input type="text" class="form-control" id="nama_aktivitas" name="nama_aktivitas" autocomplete="off"></div>
                                 <div class="col-2">  <button type="submit" class="btn btn-primary">Tambahkan</button></div>
                            </div>

                            <input type="hidden" id="aktivitas_id" name="aktivitas_id">
                        </div>
                        </div>
                        <div class="modal-footer">
                             <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                        </div>
                    </div>
                    </form>
                </div>
            </div>


                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>


        </div>
        <!-- END wrapper -->
        <?php $this->load->view('layout/section/theme-setting');?>


        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url();?>assets/new/js/ui/component.todo.js"></script>


        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>
                            
        <!-- Datatable Init js -->
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.datatable-init.js"></script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>


        <script type="text/javascript">

              $(function() {
                    $("#nama_aktivitas").autocomplete({
                        source: function(request, response) {
                            $.ajax({
                                url: "<?= base_url('kinerja/autocomplete') ?>",
                                dataType: "json",
                                data: {
                                    term: request.term
                                },
                                success: function(data) {
                                    response(data);
                                }
                            });
                        },
                        minLength: 2,
                        select: function(event, ui) {
                            $('#nama_aktivitas').val(ui.item.label);
                            $('#aktivitas_id').val(ui.item.value);
                            return false;
                        }
                    });


                    
                });



                $(document).ready(function () {
                    $('#formAktifitas').on('submit', function (e) {
                        e.preventDefault(); // mencegah reload form biasa
                         $(".alert").removeClass("alert-info");
                        $(".alert").addClass("alert-success");
                        $.ajax({
                            url: '<?= base_url('kinerja/simpan_aktifitas_pegawai') ?>', // endpoint controller
                            type: 'POST',
                            data: $(this).serialize(),
                            dataType: 'json',
                            success: function (res) {
                                if (res.status === 'success') {
                                    $('#info-add').text('Aktivitas berhasil ditambahkan').show();

                                    // Reset input form
                                    $('#formAktifitas')[0].reset();

                                
                                    // Refresh list tabel (panggil fungsi atau reload)
                                    loadAktifitasList(); // Pastikan fungsi ini ada
                                } else {
                                    $('#info-add').text('Gagal menyimpan data').show();
                                }
                            },
                            error: function () {
                                $('#info-add').text('Terjadi kesalahan server').show();
                            }
                        });
                    });


                });


        </script>




    </body>
</html>
