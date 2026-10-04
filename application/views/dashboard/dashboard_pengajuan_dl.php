<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

     <style>
    .switch {
      position: relative;
      display: inline-block;
      width: 50px;
      height: 24px;
    }

    .switch input {
      opacity: 0;
      width: 0;
      height: 0;
    }

    .slider {
      position: absolute;
      cursor: pointer;
      top: 0; left: 0;
      right: 0; bottom: 0;
      background-color: #db3535ff;
      transition: .4s;
      border-radius: 34px;
    }

    .slider:before {
      position: absolute;
      content: "";
      height: 20px; width: 20px;
      left: 4px; bottom: 2px;
      background-color: white;
      transition: .4s;
      border-radius: 50%;
    }

    input:checked + .slider {
      background-color: #4caf50;
    }

    input:checked + .slider:before {
      transform: translateX(24px);
    }

    /* Optional: label text */
    .switch-label {
      font-family: sans-serif;
      margin-left: 10px;
      vertical-align: middle;
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

                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/my_dashboard">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>setting/hari_kerja">Admin Dashboard</a></li>
                                            <li class="breadcrumb-item active">Pengajuan Dinas Luar</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Pengajuan Dinas Luar</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                    <?php
                    
                            $flashdata = $this->session->flashdata('message');
                            $function = $this->uri->segment(3);

                            $numPengajuanIzin =  count($pengajuanIzin);
                             $numPengajuanSakit =  count($pengajuanSakit);

                             $numAll = $numPengajuanIzin+$numPengajuanSakit;
                        ?>

            
                         <div class="row">

                            <div class="col-xxl-12">
                                <div class="card w-100">
                                    <div class="card-body p-2">
                                         <a href="<?php echo base_url();?>dashboard/dashboard_pengajuan_cuti" class="btn btn-light">Pengajuan Cuti  (<?php echo count($pengajuanCuti);?>)</a>
                                         <a href="<?php echo base_url();?>dashboard/dashboard_pengajuan_dl" class="btn btn-light">Pengajuan Dinas Luar (<?php echo count($pengajuanDL);?>)</a>
                                          <a href="<?php echo base_url();?>dashboard/dashboard_pengajuan_izin" class="btn btn-info">Pengajuan Izin  & Sakit (<?php echo $numAll;?>)</a>
                                       
                                    </div>
                                </div>
                            </div>
                             

                                <?php
                                     $no = 0;
                                      for ($i=0; $i < count($pengajuanDL) ; $i++) { 

                                        $id = $pengajuanDL[$i]->id;
                                        $nama = $pengajuanDL[$i]->nama;
                                        $jns_dl = $pengajuanDL[$i]->jns_dl;
                                        $keterangan = $pengajuanDL[$i]->keterangan;
                                        $tanggal = $pengajuanDL[$i]->tanggal;
                                        $nip = $pengajuanDL[$i]->nip;
                                        

                                        $pin = substr($nip, -4);

                                        if($jns_dl=='DLA'){
                                            $flagDL   = '  <span class="badge badge-warning-lighten float-end">DL-AWAL</span>';
                                        }else if($jns_dl=='DLP'){
                                            $flagDL   = '  <span class="badge badge-info-lighten float-end">DL-PENUH</span>';
                                        }else{
                                            $flagDL   = '  <span class="badge badge-success-lighten float-end">DL-AKHIR</span>';
                                        }
                                            ?>

                                        <div class="col-lg-3 d-flex align-items-stretch card-wrapper" id="card-<?= $id; ?>">
                                            <div class="card w-100">
                                                <div class="card-body p-2">
                                                 
                                                       
                                                        <h5> <?php echo $flagDL;?></h5>
                                                        <h5> <?php echo $nama;?></h5>

                                                         <p class="text-info"><?php echo format_hari($tanggal).', '.format_semi($tanggal);?></p>

                                                        <?= $keterangan;?> 

                                                     
                                                         <div class=" border-top mt-2 pt-2">
                                                             
                                                             <button type="button" value="<?= $id;?>"  class="btn btn-sm text-dark border-none bg-white btn-detail-dl"  data-bs-toggle="modal"  data-bs-target="#detailDL">
                                                                <i class="uil uil-expand-arrows-alt"></i> Detail
                                                             </button>

                                                               <span class="text-light">|</span> 

                                                              <a href="javascript:void(0);" 
                                                                    class="btn btn-sm text-success btn-acc-dl" 
                                                                    data-id="<?= $id; ?>">
                                                                    <i class="uil uil-file-check-alt"></i> ACC
                                                                </a>

                                                              <span class="text-light">|</span>     

                                                                <button type="button" value="<?= $id;?>"  class="btn btn-sm text-info border-none bg-white btn-edit-dl"  data-bs-toggle="modal"  data-bs-target="#editDL">
                                                                    <i class="uil  uil-edit"></i> Edit
                                                                </button>

                                                               <span class="text-light">|</span> 

                                                                 <a href="javascript:void(0);" 
                                                                    class="btn btn-sm text-danger btn-delete-dl" 
                                                                    data-id="<?= $id; ?>">
                                                                    <i class="uil uil-trash-alt"></i> Delete
                                                                </a>

                                                        </div>
                                                  
                                                   
                                                </div>
                                                        

                                            </div>
                                        </div>


                                <?php  } ?>
                      

                                

                            <div class="modal fade" id="detailDL" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">

                                    <div class="modal-content">
                                            <form action="<?php echo base_url(); ?>cuti/create_session_pengajuan_cuti" method="post" enctype="multipart/form-data" id="pengajuan_cuti">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scrollableModalTitle">Pengajuan Dinas Luar</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body" id="detailPengajuanDL">
                                                
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </form>
                                    </div><!-- /.modal-content -->


                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->


                        
                                <div class="modal fade" id="editDL" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form id="formEditShift" method="post" action="<?= base_url('dashboard/update_pengajuan_dl'); ?>">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myLargeModalLabel">Edit Dinas Luar </h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                  <div class="modal-body">
                                                 
                                                         <input type="hidden" name="id" id="id">

                                                            <div class="row">
                                                                 <div class="col-4">
                                                                        <div class="form-group">
                                                                            <label>Jenis DL</label>
                                                                            <input type="text" name="jns_dl" id="jns_dl" class="form-control" required>
                                                                        </div>
                                                                 </div>
                                                                 <div class="col-8">
                                                                    <div class="form-group">
                                                                        <label>Tanggal</label>
                                                                        <input type="date" name="tgl" id="tgl" class="form-control" required>
                                                                    </div>
                                                                 </div>
                                                            </div>


                                                              <div class="form-group mt-3">
                                                                <label>Keterangan</label>
                                                                <input type="text" name="keterangan" id="keterangan" class="form-control" required>
                                                            </div>
                                                           
                                                        </div>
                                                 

                                                      <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                    </div>

                                                </form>

                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->




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

                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



         <script>
            $(document).ready(function() {
                $('.btn-edit-dl').on('click', function() {
                    var id = $(this).val();

                    $.ajax({
                    url: '<?= base_url("dashboard/getDetailDL"); ?>',
                    type: 'POST',
                    data: { id: id },
                    dataType: 'json',
                    success: function(return_data) {

                        data = return_data[0];
                        // Isi modal dengan data yang didapat
                        $('#id').val(data.id);
                        $('#jns_dl').val(data.jns_dl);
                        $('#tgl').val(data.tanggal);
                        $('#keterangan').val(data.keterangan);
                    },
                    error: function(xhr, status, error) {
                        console.error('Gagal ambil data:', error);
                    }
                    });
                });



                 $('.btn-delete-dl').on('click', function(e) {
                    e.preventDefault();
                    var id = $(this).data('id');

                    Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: "Data ini tidak bisa dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                        url: '<?= base_url("dashboard/delete_dl"); ?>',
                        type: 'POST',
                        data: { id: id },
                        success: function(response) {
                            var res = JSON.parse(response);
                            if (res.status === 'success') {
                            toastr.success('Data berhasil dihapus.');

                            // Hapus card dari tampilan
                            $('#card-' + id).fadeOut(600, function() {
                                $(this).remove();
                            });
                            } else {
                            toastr.error('Gagal menghapus data.');
                            }
                        },
                        error: function() {
                            toastr.error('Terjadi kesalahan saat menghapus.');
                        }
                        });
                    }
                    });
                });


                 $('.btn-acc-dl').on('click', function(e) {
                        e.preventDefault();
                        var id = $(this).data('id');

                        Swal.fire({
                        title: 'Setujui Pengajuan DL ini?',
                        text: "Pastikan data sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Setujui'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                            url: '<?= base_url("dashboard/acc_dl"); ?>', // Ganti sesuai controller kamu
                            type: 'POST',
                            data: { id: id },
                            success: function(response) {
                                var res = JSON.parse(response);
                                if (res.status === 'success') {
                                toastr.success('Pengajuan DL berhasil disetujui.');

                                // Hapus kartu dari tampilan (atau ubah status di dalam kartu)
                                $('#card-' + id).fadeOut(600, function() {
                                    $(this).remove();
                                });
                                } else {
                                  toastr.error('Gagal menyetujui pengajuan.');
                                }
                            },
                            error: function() {
                                toastr.error('Terjadi kesalahan saat menyetujui.');
                            }
                            });
                        }
                        });
                    });


                     $('.btn-detail-dl').on('click', function(e) {
                        e.preventDefault();
                        let id = $(this).val();

                         $.ajax({

                                type:"POST",
                                dataType:"html",
                                url:"<?php echo base_url();?>admin/presensi/ajax_detail_dl",
                                data:"id="+id,
                                success:function(msg){
                        
                                   $("#detailPengajuanDL").html(msg);
                                //console.log(msg);
                                }

                            });
                   });

                    
                
            });
            </script>

                   
            <?php
             
                if ($flashdata):
                ?>
                <script>
                $(document).ready(function() {
                    toastr.options = {
                        "closeButton": true,
                        "progressBar": true,
                        "positionClass": "toast-top-right",
                        "timeOut": "3000"
                    };

                    toastr["<?= $flashdata['type']; ?>"]("<?= $flashdata['text']; ?>");
                });

                </script>
                <?php endif; ?>

    </body>
</html>
