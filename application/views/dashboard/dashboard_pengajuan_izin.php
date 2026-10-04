<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
<!-- Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<style>
    .border-5 {
    border-width: 5px !important;
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
                                            <li class="breadcrumb-item active">Pengajuan Izin / Sakit</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Pengajuan Izin / Sakit</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                    <?php
                    
                            $flashdata = $this->session->flashdata('message');
                            $function = $this->uri->segment(3);

                        ?>

            
                         <div class="row">


                              <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Daftar Pengajuan Izin / Sakit</h4>
                                        <div class="card-body">

                                        
                                            <table class="table">

                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama</th>
                                                        <th>Jenis Pengajuan</th>
                                                        <th>Jenis Izin</th>
                                                        <th>Keterangan</th>
                                                        <th>Tanggal</th>
                                                        <th>File</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                    
                                                <?php

                                                        $numPengajuanIzinSakit = $pengajuanIzinSakit['count'];
                                                        $dataPengajuanIzinSakit = $pengajuanIzinSakit['data'];

                                                       // print_array($dataPengajuanIzinSakit);

                                                        $no = 0;
                                                        for ($i=0; $i < $numPengajuanIzinSakit ; $i++) { 

                                                            $id = $dataPengajuanIzinSakit[$i]->id;
                                                            $nama = $dataPengajuanIzinSakit[$i]->nama;
                                                            $nip = $dataPengajuanIzinSakit[$i]->nip;
                                                            $jns_izin = $dataPengajuanIzinSakit[$i]->jns_izin;
                                                             $jenis_absen = $dataPengajuanIzinSakit[$i]->jenis_absen;
                                                            $keterangan = $dataPengajuanIzinSakit[$i]->keterangan;
                                                            $tanggal = $dataPengajuanIzinSakit[$i]->tanggal;
                                                            $file_image = $dataPengajuanIzinSakit[$i]->file_image;

                                                            if($jenis_absen=='IZIN'){
                                                                $flag_jns_absen = '<span class="badge bg-info">IZIN</span>';
                                                                if($jns_izin==1){
                                                                    $jenis_izin_text = '1 hari';
                                                                }else if($jns_izin==2){
                                                                    $jenis_izin_text = 'Setengah hari Awal';
                                                                }else{
                                                                    $jenis_izin_text = 'Setengah hari Akhir';   
                                                                }
                                                            }else{
                                                                $jenis_izin_text = '-';
                                                                  $flag_jns_absen = '<span class="badge bg-warning">Sakit</span>';
                                                            }
                                                       



                                                            echo '
                                                            <tr>
                                                                <td>'.++$no.'</td>
                                                                <td> <strong>'.$nama.'</strong> <br> <small>NIP. '.$nip.'</small> </td>
                                                                <td>'.$flag_jns_absen.'</td>
                                                                <td>'.$jenis_izin_text.'</td>
                                                                
                                                                <td>'.$keterangan.'</td>
                                                                <td>'.format_hari($tanggal).', '.format_view($tanggal).'</td>
                                                                <td>
                                                                    <a href="'.base_url('uploads/surat_izin/'.$file_image).'" class="text-primary" target="_blank">
                                                                        Lihat File
                                                                    </a>
                                                                </td>
                                                                <td>
                                                                    <button class="btn btn-sm btn-success btn-acc-izin" data-id="'.$id.'" data-title="'.$jenis_absen.'">Setujui</button>  
                                                            </tr>';

                                                        }

                                                ?>

                                         </table>
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

                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>
        <!-- Toastr JS -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
         <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>




         <script>
              $(document).ready(function() {
                  
                $('.btn-acc-izin').on('click', function(e) {
                        e.preventDefault();
                        var id = $(this).data('id');
                        var title = $(this).data('title');

                        Swal.fire({
                        title: 'Setujui Pengajuan "' + title + '" ini?',
                        text: "Jenis Izin: " + title + ". Pastikan data sudah benar.",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#28a745',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, Setujui'
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                            url: '<?= base_url("dashboard/acc_pengajuan_izin_sakit"); ?>', // Ganti sesuai controller kamu
                            type: 'POST',
                            data: { id: id },
                            success: function(response) {
                                var res = JSON.parse(response);
                                if (res.status === 'success') {
                                toastr.success('Pengajuan ' + title + ' berhasil disetujui.');

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
