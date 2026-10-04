<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.14.1/themes/base/jquery-ui.css">

  <style>
        .image-preview {
            display: inline-block;
            margin: 10px;
            position: relative;
        }
        .image-preview img {
            width: 150px;
            height: auto;
            border: 1px solid #ccc;
        }
        .image-preview button {
            position: absolute;
            top: 2px;
            right: 2px;
            background: red;
            color: white;
            border: none;
            cursor: pointer;
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
                                    <h4 class="page-title">Pengajuan Cuti</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php

                                    $list_bulan = array_bulan();

                                    $periode_bulan = $this->session->userdata('periode_bulan'); 
                                    $periode_tahun = $this->session->userdata('periode_tahun'); 

                                    $status_pengajuan   = $this->session->flashdata('status');
                                    $message   = $this->session->flashdata('message');

                                  
                                    $bulan = $periode_bulan;
                                    $tahun = $periode_tahun;

                                    $id_cuti = $this->uri->segment(3);



                                    $tgl_mulai =  $data_cuti[0]->tgl_dari;
                                    $tgl_akhir =  $data_cuti[0]->tgl_sampai;
                                    $alamat_cuti     =  $data_cuti[0]->alamat_cuti;
                                    $no_tlp         =  $data_cuti[0]->no_tlp;
                                    $id_pegawai     =  $data_cuti[0]->id_pegawai;

                                    $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);

                                    $jabatan   =  $detail_pegawai[0]->jabatan;
                                    $puskesmas =  $detail_pegawai[0]->puskesmas;

                                    $nip_user      =  $detail_cuti[0]->nip;

                                    $jenis_cuti      =  $detail_cuti[0]->jns_cuti;

                                   // print_array($detail_cuti);
                                    $list_tgl_cuti   =  $detail_cuti[0]->list_tgl_cuti;
                                    $nama_pengganti  =  $detail_cuti[0]->nama_pengganti;
                                    $alasan_cuti     =  $detail_cuti[0]->alasan_cuti;

                                    $listHari = explode(",",$list_tgl_cuti);

                                    if(count($listHari) < 20 ){
                                        $total_hari = count($listHari).' Hari';    
                                    }else{
                                        $total_hari = '3 Bulan';
                                    }

                                    
                                  
               
            
                                   $pin 	= substr($nip_user, -4);

                               
                              



                               ?>



                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <table class="table table-sm">

                                            <tr>
                                                <td>Jenis Cuti :  <br><span class="text-dark fw-bold"><?php echo $jenis_cuti ;?> </span></td>
                                                 <td>Tanggal Cuti :  <br><span class="text-dark fw-bold"><?php echo format_full($tgl_mulai);?> </span>
                                                    s/d   <span class="text-dark fw-bold"><?php echo format_full($tgl_akhir);?> </span>
                                                </td>
                                                  <td>Pengganti Cuti :<br> <span class="text-dark fw-bold"><?php echo $nama_pengganti ;?> </span></td>
                                                  <td>Alasan Cuti : <br> <span class="text-dark fw-bold"><?php echo $alasan_cuti ;?> </span></td>
                                                  <td>Alamat Selama Cuti : <br> <span class="text-dark fw-bold"><?php echo $alamat_cuti ;?> </span></td>
                                            </tr>

                                    
                                                
                                        </table>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>

                      

                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                       
                                        <h4 class="header-title">Upload File Pendukung</h4>
                                        <p class="text-muted">Untuk pengajuan <span class="fw-bold text-danger">Alasan Penting dan Cuti Melahirkan</span> wajib menyertakan dokumen pendukung seperti surat keterangan dokter, surat rawat, surat keterangan hamil, hasil usg atas lainnya. Silahkan upload file sesuai dengan ketentuan dibawah, bisa upload beberapa file dengan maksimal file 5 file </p>
                                       
                                         <div class="alert alert-warning">
                                            <h4> File yang diizinkan</h4> 
                                            Format File : <strong>file image (jpg, png, jpeg)</strong> <br>
                                            Ukuran File : <strong>Max 1MB </strong> <br>
                                            Dimensi  Maksimal : <strong>width 2000px, height 2000px  </strong> 
                                         </div>

                                     
                                            <div class="row">
                                                <div class="col-md-6">
                                                    
                                                        <div id="upload-area">
                                                            <input type="file" class="file-input" style="display:none;" accept="image/*">
                                                            <button id="add-file-btn" class="btn btn-info">Pilih File</button>
                                                        </div>

                                                        <div id="preview-area"></div>



                                               <div id="alert-container"></div>
                                                        <br><br><br>
                                                      
                                                         <a href="<?php echo base_url();?>cuti/summary_pengajuan_cuti/<?php echo $id_cuti;?>" class="btn btn-success">Lihat Detail Cuti</a>
                                                </div>
                                                

                                            <div class="col-md-12">
                                              
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
         <script src="https://code.jquery.com/ui/1.14.1/jquery-ui.js"></script>
        <!-- demo end -->

        <script>
            var message = '<?php echo $message;?>';

            if(message != ''){
                $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
            }
          
        </script>


            <script>
            let uploadCount = 0;
            const maxUploads = 5;
            const idCuti = <?= $id_cuti ?>;





            $(document).ready(function () {

                // Tombol untuk men-trigger input file tersembunyi
                $('#add-file-btn').click(function () {
                    if (uploadCount >= maxUploads) {
                        alert("Maksimal 5 file.");
                        return;
                    }
                    $('.file-input').click();
                });

                // Saat file dipilih
                $('.file-input').change(function () {
                    const file = this.files[0];
                    if (!file) return;

                    const formData = new FormData();
                    formData.append('bukti', file);
                    formData.append('id_cuti', idCuti);

                    $.ajax({
                        url: '<?= site_url("cuti/ajax_upload"); ?>',
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            const data = JSON.parse(res);
                            if (data.status === 'success') {
                                uploadCount++;

                                const preview = `
                                    <div class="image-preview" data-file="${data.filename}">
                                        <button class="remove-btn">x</button>
                                        <img src="<?= base_url('uploads/dokumen_cuti/'); ?>${data.filename}" />
                                    </div>
                                `;
                                $('#preview-area').append(preview);

                                 if (uploadCount === 1) {
                                    const alertSuccess = `
                                        <div class="alert alert-success mt-4" id="upload-success-alert">
                                            Data cuti berhasil disimpan. Jika anda sudah mengupload file maka file sudah otomatis tersimpan dan anda bisa melihat detail cuti dengan mengklik tombol <strong>Lihat Detail Cuti</strong>.
                                        </div>
                                    `;
                                    $('#alert-container').html(alertSuccess); // Pastikan elemen ini ada di HTML
                                }
                                
                            } else {
                                alert(data.message);
                            }
                        }
                    });

                    // Reset input file
                    $(this).val('');
                });

                // Hapus gambar
                $('#preview-area').on('click', '.remove-btn', function () {
                    const parentDiv = $(this).parent();
                    const filename = parentDiv.data('file');

                                    
                    $.ajax({
                        url: '<?= site_url("cuti/ajax_delete"); ?>',
                        type: 'POST',
                        data: { 
                            filename: filename,
                            id_cuti: idCuti // ambil dari variabel JS kamu
                        },
                        success: function (res) {
                            const data = JSON.parse(res);
                            if (data.status === 'success') {
                                parentDiv.remove();
                                uploadCount--;
                            } else {
                                alert(data.message);
                            }
                        }
                    });
                });
            });
            </script>





    </body>
</html>
