<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/css/snackbar.css" rel="stylesheet" type="text/css" />


<style>
        .calendar{
            width: 100%;
        }
      header {
            display: flex;
            align-items: center;
            font-size: 14px;
            justify-content: center;
            margin-bottom: 0.3em;
            color: #333;
            min-height: 6vh;
            text-align: center;

        }

        .calendar ul, ol {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            margin: 0 auto;
            max-width: 64em;
            padding: 0;
            }

            .calendar  li {
                display: flex;
                align-items: center;
                justify-content: center;
                list-style: none;
                margin-left: 0;
                font-size: 12px;
                background: #F8F8F8;
                color: #333;
                font-family:Arial;
            }
            ul.weekdays {
                margin-bottom: 0.2em;

            }

            ul.weekdays li {
                height: 30px;
            }

            ol.day-grid li {
                background-color:#FFF;
                border: 1px solid #F8F8F8;
                height: 8vw;
                max-height: 45px;

            }

            ul.weekdays abbr[title] {
                border: none;
                font-weight: 800;
                text-decoration: none;
            }

            /* ol.day-grid li:nth-child(1),
            ol.day-grid li:nth-child(2),
            ol.day-grid li:nth-child(3),
            ol.day-grid li:nth-child(34),
            ol.day-grid li:nth-child(35) {
                background-color: #FFF;
                color: #CCC;
            } */

            .month_prev{
                color: #CCC  !important;
            }


            .tgl_cuti{
                background-color:rgb(50, 156, 237) !important;
                border: 1px solid #51a4f1  !important;
                color: #FFF  !important;
                font-weight: bold;
                padding:8px 10px;
                border-radius: 40px;;
            }


            .weekend{
                background-color:#FFF !important;
                color: #F00  !important;
                font-weight: bold;
                padding:5px 10px;
                border-radius: 40px;;
            }

            @media all and (max-width: 800px) {
            ul, ol {
                grid-gap: .25em;
            }

            ul.weekdays li {
                font-size: 0;
            }

            ul.weekdays > li abbr:after {
                content: attr(title);
                font-size: calc(12px + (26 - 16) * ((100vw - 300px) / (1600 - 300)));
                text-align: center;
                }
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
                    <?php
                    //print_array($rekap_capaian_kinerja);

                            $id_pegawai_session = $this->session->userdata('id_pegawai');
                            $usergroup          = $this->session->userdata('usergroup');

                            $tgl_dari           = $this->session->userdata('tgl_mulai');
                            $tgl_akhir          = $this->session->userdata('tgl_akhir');
                            $jns_cuti           = $this->session->userdata('jns_cuti');

                            $tlp                = $this->session->userdata('tlp');
                            $alasan_cuti        = $this->session->userdata('alasan_cuti');
                            $alamat             = $this->session->userdata('alamat');
                            $list_tgl_cuti      = $this->session->userdata('list_tgl_cuti');




                            $sisaTahun2024 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai_session, 2, 'DESC');
                            $sisaTahun2025 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai_session, 4, 'DESC');

                            $sisaCutiAll = $sisaTahun2024+$sisaTahun2025;
                            $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');

                             $id_pj       = $detail_pegawai[0]->id_validator;
                             $nama        = $detail_pegawai[0]->nama;
                             $nip        = $detail_pegawai[0]->nip;
                             $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
                             $id_jabatan = $detail_pegawai[0]->id_jabatan;
                             $jabatan     = $detail_pegawai[0]->jabatan;
                             $puskesmas   = $detail_pegawai[0]->puskesmas;
                             $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
                             $jns_jam_kerja = $detail_pegawai[0]->jns_jam_kerja;
                             $rumpun_kerja = strtolower($detail_pegawai[0]->rumpun_kerja);
                             $keterangan_jabatan = $detail_pegawai[0]->keterangan_jabatan;

                             $nama_pengganti        = $detail_pegawai_pengganti[0]->nama;
                             $jabatan_pengganti        = $detail_pegawai_pengganti[0]->jabatan;
                             $puskesmas_pengganti      = $detail_pegawai_pengganti[0]->puskesmas;
                             //print_array($this->session->userdata);

                             $message = $this->session->flashdata('message');


                             if($jns_jam_kerja=='non_shift'){
                                $jenis_jam_kerja = 'N';
                             }
                             else{
                                 $jenis_jam_kerja = 'S';
                             }


                            $start = DateTime::createFromFormat('d-m-Y', $tgl_dari);
                            $end   = DateTime::createFromFormat('d-m-Y', $tgl_akhir);

                            $hari_cuti = $this->Cuti_model->hitungHariKerja( $start, $end, $jenis_jam_kerja);


                            $periodeCuti = date('F Y', strtotime($tgl_dari));

                            $LastDateMonth = date('t', strtotime($tgl_dari));
                            $BulanCuti = date('Y-m', strtotime($tgl_dari));
                            $blnCuti   = $BulanCuti.'-01';
                            //untuk mendapatkan tgl 1 hari apa
                            $hariAwal = date('N', strtotime($blnCuti));


                            //1 = Senin, 7 = Minggu

                             $hariBulan = 'Hari';
                            if($jns_cuti==1){
                                $jenis_cuti = 'Cuti Tahunan';
                              }else if($jns_cuti==2){
                                $jenis_cuti = 'Cuti Bersalin';
                                $hari_cuti = '3 ';
                                $hariBulan = 'Bulan';
                              }else if($jns_cuti==3){
                                $jenis_cuti = 'Cuti Alasan Penting';
                              }else if($jns_cuti==4){
                                $jenis_cuti = 'Cuti Sakit';
                              }else if($jns_cuti==5){
                                $jenis_cuti = 'Cuti Besar';
                              }else{
                                $jenis_cuti = 'Cuti Bersalin Anak 3';
                              }



                            $date = DateTime::createFromFormat('Y-m', $BulanCuti);
                            $date->modify('-1 month');
                            $bulan_lalu = $date->format('Y-m');

                            $LastDateMonthPrevMonth = date('t', strtotime($bulan_lalu));

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
                                            <li class="breadcrumb-item active">Pegawai</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Detail Pegawai </h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                            <div class="row">
                                    <div class="col-sm-12">

                                        <div class="card border-bawah-danger">
                                                <div class="card-body ">

                                                    <div class="d-flex align-items-center">
                                                        <div class="w-100 overflow-hidden">
                                                            <h5 class="mt-0"><?php echo $nama;?></h5>
                                                            <h5 class="m-0 fw-normal cta-box-title"><?php echo $jabatan;?>    -
                                                            <b><?php echo $keterangan_jabatan;?></b> <i class="mdi mdi-arrow-right-bold-outline"></i></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- end card-body -->
                                        </div>
                                            <!-- end card-->
                                    </div> <!-- end col-->
                                    <div class="col-sm-12">

                                        <div class="card border-bawah-danger">
                                    <div class="card-body ">

                                        <div class="d-flex align-items-center">
                                            <div class="w-100 overflow-hidden">

                                                <div class="row">
                                                    <div class="col-md-8 mb-2" style="line-height: 10px;">
                                                        <h4 class="mt-0">Ringkasan Pengajuan Cuti</h4>
                                                        <br> <br>

                                                        <label for="jenis_cuti" style="color: #999;">Jenis Cuti</label>
                                                        <h5 class="text-dark"><?php echo $jenis_cuti ;?> </h5>

                                                        <br>
                                                        <label for="jenis_cuti" style="color: #999;">Tanggal Cuti</label>
                                                        <h5 class="text-dark">
                                                            <span class="text-success"> Mulai</span> &nbsp;:&nbsp;<?php echo format_full($tgl_dari);?>
                                                            &nbsp;&nbsp;  <i class="uil-arrow-right"></i>&nbsp;&nbsp;
                                                            <span class="text-danger"> Akhir  </span> :&nbsp; <?php echo format_full($tgl_akhir);?> &nbsp;&nbsp; ( <?php echo $hari_cuti;?>
                                                            <span class="text-dark"> <?php echo $hariBulan;?></span> )

                                                        </h5>

                                                        <br>
                                                        <label for="jenis_cuti" style="color: #999;">Pengganti Selama Cuti</label>
                                                        <h5 class="text-dark"><?php echo $nama_pengganti;?> - <?php echo $jabatan_pengganti;?></h5>

                                                        <br>
                                                        <label for="jenis_cuti" style="color: #999;">Alasan Cuti</label>
                                                        <h5 class="text-dark"><?php echo $alasan_cuti;?></h5>



                                                        <br>
                                                        <label for="jenis_cuti" style="color: #999;">Alamat Cuti</label>
                                                        <h5 class="text-dark"><?php echo $alamat;?></h5>


                                                        <hr>

                                                        <h5 class="mt-0">Delegasi Tugas</h5>
                                                        <br>
                                                            <div>
                                                                <div class="mb-2"><i class="uil-check"></i> <?php echo $this->session->userdata('tugas1');?></div>
                                                                <div class="mb-2"> <i class="uil-check"></i> <?php echo $this->session->userdata('tugas2');?></div>
                                                                <div class="mb-2"><i class="uil-check"></i> <?php echo $this->session->userdata('tugas3');?></div>
                                                                <div><i class="uil-check"></i> <?php echo $this->session->userdata('tugas4');?></div>

                                                            </div>

                                                        <br>

                                                         <!-- <div class="border border-info p-2 my-4">

                                                                <h5>Upload dokumen Pelengkap (surat sakit, hasil USG, dll)</h5>

                                                                  <div class="alert alert-info">
                                                                    Jenis dokumen dalam format image (jpg, png, jpeg)
                                                                  </div>

                                                                    <form id="uploadForm" enctype="multipart/form-data">
                                                                        <label for="files">Pilih File:</label>
                                                                        <input type="file" id="files" name="files[]" multiple>
                                                                        <br><br>
                                                                        <button type="submit" class="btn btn-info">Upload File</button>
                                                                    </form>

                                                                    <div id="status"></div>
                                                            </div> -->




                                                    </div>


                                                    <div class="col-md-4  mb-2">
                                                        <form action="<?php echo base_url();?>cuti/simpan_pengajuan_cuti" method="post">
                                                            <input type="hidden" name="lama_cuti" value="<?php echo $hari_cuti;?>">
                                                            <a href="" class="btn btn-light me-1">Kembali</a>
                                                            <button type="submit" class="btn btn-success">Simpan Pengajuan Cuti</button>
                                                        </form>

                                                        <br>
                                                        <?php
                                                            if($jns_cuti==1){
                                                        ?>

                                                            <div class="mb-2 rounded px-2 py-1 bg-light text-primary">



                                                                <center>
                                                                    <h5>Sisa Cuti </h5>
                                                                    </center>

                                                                    <table class="table rounded table-sm bg-white">
                                                                    <tr>
                                                                        <td> <i class="uil-arrow-right"></i> Sisa Cuti Awal </td>
                                                                        <td class="text-end"><?php echo  $sisaCutiAll;?> hari</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td> <i class="uil-arrow-right"></i> Hak Cuti digunakan </td>
                                                                        <td class="text-end  text-danger"><?php echo $hari_cuti;?> hari</td>
                                                                    </tr>
                                                                    <tr class="fw-bold">
                                                                        <td> <i class="uil-arrow-right"></i> Sisa Cuti Akhir </td>
                                                                        <td class="text-end  text-success"><?php echo  $sisaCutiAll-$hari_cuti;?> hari</td>
                                                                    </tr>
                                                                    </table>


                                                            </div>
                                                            <?php } ?>


                                                        <br>



                                                                <div class="calendar">
                                                                <header>
                                                                    <h5><?php echo $periodeCuti;?></h5>
                                                                </header>

                                                                <ul class="weekdays">

                                                                    <li>
                                                                    <abbr title="Senin">Sen</abbr>
                                                                    </li>
                                                                    <li>
                                                                    <abbr title="Selasa">Sel</abbr>
                                                                    </li>
                                                                    <li>
                                                                    <abbr title="Rabu">Rab</abbr>
                                                                    </li>
                                                                    <li>
                                                                    <abbr title="Kamis">Kam</abbr>
                                                                    </li>
                                                                    <li>
                                                                    <abbr title="Jum'at">Jum</abbr>
                                                                    </li>
                                                                    <li>
                                                                    <abbr title="Sabtu">Sab</abbr>
                                                                    </li>
                                                                    <li>
                                                                    <abbr title="Minggu">Mgg</abbr>
                                                                    </li>
                                                                </ul>

                                                                <ol class="day-grid">

                                                                <?php
                                                                $stringListHariCuti =  implode(', ', $list_tgl_cuti);

                                                                //echo $stringListHariCuti;


                                                                //echo $hariAwal;
                                                                ?>


                                                                    <?php
                                                                            $LD = $LastDateMonthPrevMonth;  //LastDate bulan lalu ( Mei = 31 hari)

                                                                            $loopPrevMont = $hariAwal-1;
                                                                            $t_awal = $LD - ($hariAwal-2);


                                                                            if($hariAwal > 1){

                                                                                for ($mp=0; $mp < $loopPrevMont; $mp++) {

                                                                                    echo '<li class="month_prev">'.$t_awal.'</li>';

                                                                                    $t_awal = $t_awal+1;

                                                                                }

                                                                            }



                                                                        for ($d=0; $d < $LastDateMonth  ; $d++) {
                                                                            $tg =$d+1;
                                                                            $full_date = format_db($BulanCuti.'-'.$tg);

                                                                            $hariKe = date('N', strtotime($full_date));

                                                                            if (str_contains($stringListHariCuti, $full_date)) {
                                                                                $class= 'tgl_cuti';
                                                                            }else{
                                                                                if($hariKe < 6){
                                                                                    $class= '';
                                                                                }else{
                                                                                    $class= 'weekend';
                                                                                }

                                                                            }


                                                                            echo '<li><span class="'. $class.'">'.$tg.'</span></li>';
                                                                        }
                                                                    ?>

<!--

                                                                    <li class="month-next">1</li>
                                                                    <li class="month-next">2</li> -->
                                                                </ol>

                                                       </div>

                                                    </div>




                                                                <div class="col-12 text-center">


                                                                </div>




                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            <!-- end card-body -->
                                        </div>
                                            <!-- end card-->
                                    </div> <!-- end col-->
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



        <script>
            $(document).ready(function() {
                $('#uploadForm').on('submit', function(e) {
                    e.preventDefault();

                    var formData = new FormData(this);

                    // Menampilkan status upload
                    $('#status').html('Meng-upload file...');

                    // Mengirim file menggunakan AJAX
                    $.ajax({
                        url: '<?php echo base_url();?>cuti/upload_dokumen_cuti', // Ganti dengan URL endpoint server untuk menerima file
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            $('#status').html('File berhasil diupload.');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $('#status').html('Terjadi kesalahan saat mengupload file.');
                        }
                    });
                });
            });
            </script>

    </body>
</html>
