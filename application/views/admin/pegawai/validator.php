<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
<!-- DataTables CSS -->

    <link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

    <style>
    .ui-autocomplete {
        z-index: 9999 !important;
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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/my_dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>setting/hari_kerja">Pegawai</a></li>
                                            <li class="breadcrumb-item active">Validator</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Validator</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php
                                $message = $this->session->flashdata('message');
                          
                            ?>

            
                  <div class="row">
                    <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                       
                         <div class="card-body">
                            <h4 class="card-title">List Validator</h4>
                            <button class="btn btn-primary mb-3 float-end"
                                    data-bs-toggle="modal"
                                    data-bs-target="#addModal">
                                + Tambah Validator
                            </button>
                                <div class="clearfix"></div>

                                
                                     <table class="table  table-bordered"  id="data-table">


                                         <thead class="bg-light">
                                                <tr>
                                                    <th class="text-center" data-sort="no">No</th>
                                                    <th class="text-center" data-sort="nama_pegawai">Nama Validator</th>
                                                    <th class="text-center" data-sort="telat">NIP</th>
                                                    <th class="text-center" data-sort="p_awal">Jabatan</th>
                                                    <th class="text-center" data-sort="izin">Keterangan</th>
                                                     <th class="text-center" data-sort="status">Unit Kerja</th>
                                                   
                                                    <th class="text-center" data-sort="status">Action</th>
                                                </tr>
                                            </thead>
                                          <tbody>
      
                                          
                                            <?php 
                                                
                                                    $no = 1;
                                                    foreach ($validator as $v){

                                                            $nama = $v->nama;
                                                            $nip = $v->nip;
                                                            $nrk = $v->nrk;
                                                            $jabatan = $v->jabatan;
                                                            $usergroup = $v->usergroup;
                                                          
                                                            $puskesmas = $v->puskesmas;
                                                            $klaster = $v->klaster;


                                                            if($v->id_puskesmas==1){
                                                                 $keterangan = 'PJ Klaster '.$klaster;
                                                            }else{
                                                                 $keterangan = 'PJ Pustu '.$puskesmas;
                                                            }


                                                        echo' <tr>
                                                                <td class="text-center">'.$no.'</td>
                                                                <td class="text-left"><a href="'.base_url().'admin/pegawai/list_pegawai/'.$v->id_pegawai.'"> '.$nama.' </a></td>
                                                                <td class=" text-center">'.$nip.'</td>
                                                                <td class="text-start">'.$jabatan.'</td>
                                                           
                                                                <td class="text-start">'.$keterangan.'</td>
                                                                <td class="text-start">'.$puskesmas.'</td>
                                                              
                                                         
                                                                <td class="text-center">
                                                                    <button type="button" data-id="'.$v->id_pegawai.'" data-nama="'.$nama.'" data-puskesmas="'.$v->id_puskesmas.'" data-klaster="'.$v->klaster.'"
                                                                    data-bs-toggle="modal" data-bs-target="#editModal"  class="btn btn-sm btn-info edit-validator">Edit</button>
                                                                    <a href="'.base_url().'admin/pegawai/delete_validator/'.$v->id_pegawai.'" class="btn btn-sm btn-danger" onclick="return confirm(\'Apakah Anda yakin ingin menghapus validator ini?\')">Delete</a>
                                                                </td>


                                                                </tr>';

                                                            $no += 1;

                                                    }

                                                ?>
                                          
                                             
      
                                          </tbody>
      
                                    </table>
                                  </div>
                                </div>
                            </div><!--card body-->
                        </div>

                               
                       
                            <!-- Modal -->
                        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <form action="<?php echo base_url();?>admin/pegawai/update_validator" method="post"  enctype="multipart/form-data">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel">Edit Validator</h5>
                                    <button type="button" class="close btn btn-sm btn-light" data-bs-dismiss="modal" aria-label="Tutup">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                           <input type="hidden" name="id_pegawai" id="edit_id_pegawai">

                                                <div class="mb-3">
                                                    <label>Nama Pegawai</label>
                                                    <input type="text" id="edit_nama" class="form-control" readonly>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Puskesmas</label>
                                                    <select name="id_puskesmas" id="edit_id_puskesmas" class="form-control">
                                                        <?php foreach($list_puskesmas as $p){ ?>
                                                            <option value="<?= $p->id_puskesmas ?>">
                                                                <?= $p->nama ?>
                                                            </option>
                                                        <?php } ?>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label>Klaster</label>
                                                    <select name="klaster" id="edit_klaster" class="form-control">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                    </select>
                                                </div>
                                
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                                </form>
                            </div>
                        </div>


                        <div class="modal fade" id="addModal" tabindex="-1">
                            <div class="modal-dialog">
                                <form action="<?= base_url('admin/pegawai/add_validator') ?>" method="post">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Tambah Validator</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">

                                            <!-- Hidden ID Pegawai -->
                                            <input type="hidden" name="id_pegawai" id="add_id_pegawai">

                                            <!-- Autocomplete Pegawai -->
                                            <div class="mb-3">
                                                <label>Cari Pegawai</label>
                                                <input type="text" id="search_pegawai" class="form-control" placeholder="Ketik nama atau NIP...">
                                            </div>

                                            <div class="mb-3">
                                                <label>Puskesmas</label>
                                                <select name="id_puskesmas" class="form-control" required>
                                                    <?php foreach($list_puskesmas as $p){ ?>
                                                        <option value="<?= $p->id_puskesmas ?>">
                                                            <?= $p->nama ?>
                                                        </option>
                                                    <?php } ?>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Klaster</label>
                                                <select name="klaster" class="form-control" required>
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label>Usergroup (Role)</label>
                                                <select name="usergroup" class="form-control" required>
                                                    <option value="2">KTU</option>
                                                    <option value="3">PJ Klaster</option>
                                                    <option value="4">PJ Pustu</option>
                                                </select>
                                            </div>

                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        </div>
                      </div>
                    </div>
                  </div>

                  </div>
                  </div> <!-- container -->
                </div> <!-- content -->

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

        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <!-- DataTables JS -->
    
                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="//code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
   

        <!-- Inisialisasi DataTable -->
        <script>
            $(document).ready(function() {
                $('#data-table').DataTable({
                    // Optional settings:
                    paging: true,
                    searching: true,
                    ordering: true,
                    responsive: true,
                    language: {
                        search: "Cari:",
                        lengthMenu: "Tampilkan _MENU_ data",
                        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                        paginate: {
                            previous: "Sebelumnya",
                            next: "Berikutnya"
                        },
                        zeroRecords: "Data tidak ditemukan",
                        infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                        infoFiltered: "(disaring dari _MAX_ total data)"
                    }
                });
            });


            $(document).on('click', '.edit-validator', function() {

                var id = $(this).data('id');
                var nama = $(this).data('nama');
                var puskesmas = $(this).data('puskesmas');
                var klaster = $(this).data('klaster');

                $('#edit_id_pegawai').val(id);
                $('#edit_nama').val(nama);
                $('#edit_id_puskesmas').val(puskesmas);
                $('#edit_klaster').val(klaster);

            });

            $('#search_pegawai').autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "<?= base_url('admin/pegawai/search_pegawai') ?>",
                        type: "POST",
                        dataType: "json",
                        data: {
                            keyword: request.term
                        },
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search_pegawai').val(ui.item.label);
                    $('#add_id_pegawai').val(ui.item.value);
                    return false;
                }
            });
        </script>



    </body>
</html>
