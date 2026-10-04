<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .my-table{
            width: 100%;
        }
        .my-table  td{
            padding:2px;

        }
        .btn-list {
            padding:10px 15px;
            text-align:center;
            border-bottom:1px solid #EEE;
            color:#666;
            margin-right:2px;
        }

        .active-btn{
            border-bottom:1px solid #66bad9;
            color:orange;
        }

        .btn-acc-cuti{
            padding:5px 10px;
            background-color: #3ED890;
            color:white;
            border-radius:5px;
            text-decoration:none;
            border: none;
        }

        .btn-acc-cuti:hover{
            padding:5px 10px;
            background-color: #27B372;
            color:white;
            border-radius:5px;
            text-decoration:none;
            border: none;
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


                        <?php
                            $message = $this->session->flashdata('message');
                            $id_pegawai = $this->session->userdata('id_pegawai');


                        ?>



                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Main Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php

                                    $list_bulan = array_bulan();

                                    $periode_bulan = $this->session->userdata('periode_bulan');
                                    $periode_tahun = $this->session->userdata('periode_tahun');
                                    $jenis   = $this->session->userdata('jenis'); //jenis absensi IZIN/SAKIT


                                    $tgl_dari_session = '2025-11-01';
                                    $tgl_sampai_session = '2025-11-30';



                                   // print_array($pegawai);



                               ?>




                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">

                                        <h4 class="header-title">Pengajuan Izin/Sakit Pegawai</h4>
                                        <br>

                                        <form action="<?php echo base_url();?>admin/presensi/filter_pengajuan_izin" method="post">
                                            <div class="row">
                                                  <div class="col-md-2">
                                                    <label for="status">Jenis Absensi</label>
                                                    <select name="jenis" class="form-control">
                                                        <option value="IZIN"  <?= ($jenis=='IZIN') ? 'selected' : ''; ?>>IZIN</option>
                                                        <option value="SAKIT" <?= ($jenis=='SAKIT') ? 'selected' : ''; ?>>SAKIT</option>

                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="status">Status</label>
                                                    <select name="status" class="form-control" >
                                                        <option value="0">Pending</option>
                                                        <option value="1">Approved</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="status">Date From</label>
                                                    <input type="text" name="date_from" class="date_from form-control" value="<?php echo  $tgl_dari_session;?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="status">Date To</label>
                                                    <input type="text" name="date_to" class="date_to form-control" value="<?php echo  $tgl_sampai_session;?>">
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="status"></label><br>
                                                    <button type="submit" class="btn btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </form>

                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm mb-0 table-bordered">
                                                 <thead>
                                                        <tr>
                                                            <th class="text-center" data-sort="no">No</th>
                                                            <th class="text-center" data-sort="nama_pegawai">Nama Pegawai</th>
                                                            <th class="text-center" data-sort="telat">Jenis Absensi</th>
                                                            <th class="text-center" data-sort="p_awal">Jenis Izin</th>
                                                            <th class="text-center" data-sort="p_awal">Tanggal</th>
                                                            <th class="text-center" data-sort="izin">Keterangan</th>
                                                            <th class="text-center" data-sort="sakit">Status</th>
                                                    
                                                            <th class="text-center" data-sort="status">Date Created</th>
                                                            <th class="text-center" data-sort="action">Action</th>
                                                        </tr>
                                                 </thead>
                                                <tbody>
                                                  <?php 

                                                
//print_array($pengajuan);
                                                    $no = 1;
                                                    foreach ($pengajuan as $rekap){

                                                            $nama = $rekap->nama;
                                                            $id = $rekap->id;
                                                            $jenis_absen = $rekap->jenis_absen;
                                                            $jns_izin = $rekap->jns_izin;
                                                             $tanggal = $rekap->tanggal;
                                                            $jns_sakit = $rekap->jns_sakit;
                                                            $keterangan = $rekap->keterangan;
                                                            $file_image = $rekap->file_image;
                                                            $status = $rekap->status;
                                                            $nip = $rekap->nip;

                                                            $pin = substr($nip, -4);
                                                            $create_at = $rekap->create_at;

                                                            if($jns_izin==1){
                                                                $jenis_izin = 'Awal';
                                                            }else if($jns_izin==2){
                                                                $jenis_izin = 'Akhir';
                                                            }else if($jns_izin==3){
                                                                $jenis_izin = '1 hari';
                                                            }else{
                                                                $jenis_izin = '-';

                                                            }

                                                            if($status==0){
                                                                $flag = 'Pending';
                                                            }else{
                                                                $flag = 'Approved';
                                                            }

                                                        

                                                        echo' <tr>
                                                                <td class="text-center">'.$no.'</td>
                                                                <td class="text-left">'.$nama.'</td>
                                                                <td class=" text-center">'.$jenis_absen.'</td>
                                                                <td class="text-center">'.$jenis_izin.'</td>
                                                                  <td class="text-center">'.format_view($tanggal).'</td>
                                                                <td class="text-left">'.$keterangan.'</td>
                                                                <td class="text-center">'.$flag.'</td>
                                                                <td class="text-center">'.format_view($create_at).'</td>
                                                                 <td class="text-center">
                                                                    <button type="button" data-id="'.$id.'" data-pin="'.$pin.'" class="btn btn-sm btn-info approve">Approve</button>
                                                                    <button type="button" data-id="'.$id.'" data-pin="'.$pin.'" class="btn btn-sm btn-danger delete">Delete</button>
                                                                 </td>
                                                         

                                                                </tr>';

                                                            $no += 1;

                                                    }

                                                ?>
                                          
                                                   

                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

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


        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
         <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- demo end -->

       
        <script>

           
           $(document).on("click", ".approve", function () {
                    let id = $(this).data("id");
                     let pin = $(this).data("pin");

                    Swal.fire({
                        title: 'Setujui Pengajuan IZIN?',
                        text: "Pastikan data sudah benar.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Setujui!'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "<?php echo site_url('admin/presensi/ajaxSetujuiIzin'); ?>",
                                type: "POST",
                                data: { id: id, pin:pin },
                                dataType: "json",
                                success: function (res) {
                                    if (res.status === true) {

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: 'Pengajuan izin/sakit berhasil di ACC.',
                                            timer: 1500,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload(); // refresh tabel
                                        });

                                    } else {

                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal!',
                                            text: res.message
                                        });

                                    }
                                },
                                error: function () {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Terjadi kesalahan pada server.'
                                    });
                                }
                            });

                        }
                    });
                });


                $(document).on("click", ".delete", function () {
                    let id = $(this).data("id");
                 
                    Swal.fire({
                        title: 'Hapus Pengajuan Izin/sakit ini ?',
                        text: "Pastikan data sudah benar.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus'
                    }).then((result) => {
                        if (result.isConfirmed) {

                            $.ajax({
                                url: "<?php echo site_url('admin/presensi/ajaxDeleteIzin'); ?>",
                                type: "POST",
                                data: { id: id},
                                dataType: "json",
                                success: function (res) {
                                    if (res.status === true) {

                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Berhasil!',
                                            text: 'Pengajuan izin/sakit berhasil di hapus.',
                                            timer: 1500,
                                            showConfirmButton: false
                                        }).then(() => {
                                            location.reload(); // refresh tabel
                                        });

                                    } else {

                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Gagal!',
                                            text: res.message
                                        });

                                    }
                                },
                                error: function () {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: 'Terjadi kesalahan pada server.'
                                    });
                                }
                            });

                        }
                    });
                });


        </script>






        <script>
              $(".date_from").flatpickr();
              $(".date_to").flatpickr();

        </script>

    </body>
</html>
