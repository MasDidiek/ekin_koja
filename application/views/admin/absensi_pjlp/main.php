<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        .datepicker {
            z-index: 1999;
        }

        table {
            width: 100%;
            font-family: Arial, Helvetica, sans-serif
        }

        table th {
            background-color: #f0f3f5;
            padding: 0.5rem;
            border: 1px solid #dee8ed;
            text-align: center;
        }

        table td {
            padding: 0.3rem 0.5rem;
            border-bottom: 1px solid #EEE;
            text-align: center;
            color: #666;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <!-- <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome to Modernize</h5>
        <h6 class="text-white fs-2 mb-0">Easy to costomize the Template!!!</h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div> -->
    <!-- Preloader -->

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
            <!--  Header End -->

            <div id="snackbar" class="snackbar">
                <div id="snackbar-icon" class="snackbar-icon">✓</div>
                <div class="snackbar-content">
                    <h4 id="snackbar-title">Judul</h4>
                    <p id="snackbar-message">Pesan notifikasi Anda.</p>
                </div>
                <button class="snackbar-close" onclick="closeSnackbar()">&times;</button>
            </div>


            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Data Absensi</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Data Absensi</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5">

                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                    <?php

                    $periode_bulan = $this->session->userdata('periode_bulan');
                    $periode_tahun = $this->session->userdata('periode_tahun');
                    $message       = $this->session->flashdata('message');

                    if ($periode_bulan == '') {
                        $periode_bulan = date('m');
                        $periode_tahun = date('Y');
                    }


                    //  echo $periode_bulan;
                    $periode = $periode_tahun . '-' . $periode_bulan;
                    $periode = date('Y-m', strtotime($periode));

                    ?>


                    <div class="row">

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold mb-4">Data Absensi PJLP</h5>

                                    <div class="btn-group mb-2" role="group" aria-label="Basic example">
                                        <a href="<?php echo base_url(); ?>admin/pegawai/data_pegawai/pjlp" class="btn bg-primary-subtle  text-primary ">
                                            Data Pegawai
                                        </a>
                                        <a href="<?php echo base_url(); ?>admin/absensi_pjlp/main" class="btn bg-primary text-white ">
                                            Data Absensi
                                        </a>
                                        <a href="<?php echo base_url(); ?>admin/gaji_pjlp/index" class="btn bg-primary-subtle text-primary ">
                                            Data Penggajian
                                        </a>
                                    </div>

                                    <!-- 
                                    <a href="<?php echo base_url(); ?>admin/absensi_pjlp/update_rekap" class="btn bg-success text-white float-end ">
                                        Update Data
                                    </a> -->

                                    <div class="mt-4">
                                        FILTER PERIODE :

                                        <form action="<?php echo base_url(); ?>admin/absensi_pjlp/change_periode/0" method="post">

                                            <select name="periode_bulan" id="bulan" class="form-control float-start me-2" style="width:120px">
                                                <?php
                                                for ($i = 1; $i < 13; $i++) {
                                                    if ($periode_bulan == $i) {
                                                        echo ' <option value="' . $i . '" selected>' . getBulan($i) . '</option>';
                                                    } else {
                                                        echo ' <option value="' . $i . '">' . getBulan($i) . '</option>';
                                                    }
                                                }
                                                ?>

                                            </select>
                                            <input type="number" name="periode_tahun" class="form-control me-2 float-start" style="width:120px" id="tahun" value="<?php echo $periode_tahun; ?>">
                                            <button type="submit" class="btn btn-info">Submit</button>
                                        </form>

                                    </div>


                                    <div class="table-responsive mt-4">
                                        <table>
                                            <thead>
                                                <tr>

                                                    <th class="w-1">No.</th>
                                                    <th>ID PJLP</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Telat</th>
                                                    <th>P.Awal</th>
                                                    <th>Izin Sehari</th>
                                                    <th>Izin Stngh Hari</th>
                                                    <th>Sakit</th>
                                                    <th>Cuti</th>
                                                    <th>Alpha</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $no = 1;


                                                //print_array($datalist);
                                                if (count($datalist) > 0) {

                                                    foreach ($datalist as $peg) {

                                                        $id_pjlp = $peg->id_pegawai;
                                                        $detailPegawai = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);


                                                        $telat = $peg->telat;
                                                        $pulang_awal = $peg->pulang_awal;
                                                        $izin = $peg->izin;
                                                        $izin_half = $peg->izin_half;
                                                        $sakit = $peg->sakit;
                                                        $sakit_dgn_sk = $peg->sakit_dgn_sk;
                                                        $alpha = $peg->alpha;
                                                        $cuti = $peg->cuti;


                                                        if (!empty($detailPegawai)) {
                                                            $nama_pegawai =  $detailPegawai[0]->nama;
                                                            $jabatan = $detailPegawai[0]->jabatan;
                                                        } else {
                                                            $nama_pegawai =  '-';
                                                            $jabatan =  '';
                                                        }



                                                        echo ' <tr>
                                                                       <td>' . $no . ' </td>

                                                                       <td class="text-center"> ' . $id_pjlp . '</td>
                                                                       <td class="text-start">
                                                                       <a href="' . base_url() . 'admin/absensi_pjlp/view_absensi/' . $id_pjlp . '">' . $nama_pegawai . '</a>
                                                                       </td>
                                                                       <td>' . $jabatan . ' </td>
                                                                       <td class="text-center">' . $telat . '</td>
                                                                       <td class="text-center">' . $pulang_awal . '</td>
                                                                       <td class="text-center">' . $izin . '</td>
                                                                       <td class="text-center">' . $izin_half . '</td>
                                                                       <td class="text-center">' . $sakit . '</td>
                                                                       <td class="text-center">' . $cuti . '</td>
                                                                       <td class="text-center">' . $alpha . '</td>
                                                                       <td class="text-center">

                                                                      

                                                                        <button class="btn btn-sm btn-secondary  insert_absen" type="button" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="' . $id_pjlp . ' - ' . $nama_pegawai . '">
                                                                             <i class="ti ti-pencil fs-4 me-1"></i>                                                                            
                                                                         </button>
                                                                          <button class="btn btn-sm btn-success lihat_absen" type="button" data-bs-toggle="modal" data-bs-target="#samedata-modal" value="' . $id_pjlp . ' - ' .  $nama_pegawai . '">
                                                                             <i class="ti ti-eye fs-4 me-1"></i>
                                                                          
                                                                         </button>
                                                                         <a href="' . base_url() . 'admin/absensi_pjlp/delete_data_rekap_pegawai/' . $peg->id . '" class="btn btn-danger btn-sm" onClick="return confirm(\'Hapus data absensi ini?\');"> <i class="ti ti-trash fs-4 me-1"></i></a>
                                                                       </button></td>

                                                                   </tr>';

                                                        $no += 1;
                                                    }
                                                } else {
                                                    echo '<div class="alert alert-danger text-danger">Data rekap absensi periode Januari 2025 belum direkap</div>';
                                                }


                                                ?>






                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <?php

                    $arrayAbsens = ['IZIN SEHARI', 'IZIN SETENGAH HARI AWAL', 'IZIN SETENGAH HARI AKHIR', 'SAKIT TNP SURAT KETERANGAN', 'SAKIT DGN SURAT KETERANGAN', 'CUTI', 'ALPHA'];

                    ?>



                    <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" role="document">
                            <form method="post" name="input_absen" action="<?php echo base_url(); ?>admin/absensi_pjlp/insert_absen_tidakhadir">
                                <div class="modal-content">
                                    <div class="modal-header d-flex align-items-center">
                                        <h4 class="modal-title" id="exampleModalLabel1">
                                            Input Ketidakhadiran
                                        </h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">


                                        <strong id="nama_pjlp"></strong> <br><br>
                                        <input type="hidden" name="id_pjlp" value="" id="id_pjlp">
                                        <div class="mb-3">
                                            <label for="recipient-name" class="">Jenis Ketidak-hadiran:</label> <br>

                                            <select name="jenis_absensi" id="jenis_absensi" class="form-control">
                                                <?php
                                                for ($i = 0; $i < count($arrayAbsens); $i++) {
                                                    echo '<option value="' . $i . '">' . $arrayAbsens[$i] . '</option>';
                                                }
                                                ?>
                                            </select>


                                        </div>


                                        <div class="mb-3">
                                            <label for="recipient-name" class="">Tanggal:</label>

                                            <div class="input-group">
                                                <input type="text" name="tanggal" class="form-control complex-colorpicker" required autocomplete="off" id="datepicker-autoclose" placeholder="mm/dd/yyyy" />

                                                <span class="input-group-text">
                                                    <i class="ti ti-calendar fs-5"></i>
                                                </span>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label for="message-text" class="">Keterangan:</label>
                                            <textarea class="form-control" name="keterangan" id="message-text1" required></textarea>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn bg-danger-subtle text-danger" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            Submit
                                        </button>
                                    </div>

                            </form>
                        </div>
                    </div>



                </div>




                <script>
                    function handleColorTheme(e) {
                        $("html").attr("data-color-theme", e);
                        $(e).prop("checked", !0);
                    }
                </script>

                <?php $this->load->view('layout/section/theme-setting.php'); ?>

                <?php $this->load->view('master/request-cuti.php'); ?>

            </div>
            <div class="dark-transparent sidebartoggler"></div>
            <!-- Import Js Files -->

            <script src="<?php echo LIBS_JS_PATH; ?>jquery/dist/jquery.min.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>app.min.js"></script>
            <script src="../assets/js/app.init.js"></script>
            <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
            <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

            <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

            <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>


            <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
            <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

            <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

</body>




<script>
    $('#data-table').dataTable({
        lengthMenu: [
            [20, -1],
            ['20', '50', '100', 'Show all']
        ]
    });

    $(".insert_absen").click(function() {

        var dataPjlp = $(this).attr("data-bs-whatever");
        $("#nama_pjlp").html(dataPjlp);
        $("#id_pjlp").val(dataPjlp);
    });


    $(".lihat_absen").click(function() {

        var dataPjlp = $(this).val();
        $("#nama_pjlp").html(dataPjlp);
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>admin/absensi_pjlp/ajax_lihat_absensi_ketidakhadiran',
            data: 'dataPjlp=' + dataPjlp,
            success: function(msg) {
                $(".modal-content").html(msg);
            }
        })




    });

    <?php if ($message != '') { ?>
        $(document).ready(function() {
            showSnackbar('success', 'Berhasil!', '<?= $message; ?>');
        });

        <?php } ?>closeSnackbar


        let snackbarTimeout;

        function showSnackbar(type, title, message) {
            const snackbar = document.getElementById("snackbar");
            const icon = document.getElementById("snackbar-icon");
            const titleEl = document.getElementById("snackbar-title");
            const messageEl = document.getElementById("snackbar-message");

            // Bersihkan sisa timeout dan class tipe sebelumnya jika ada
            clearTimeout(snackbarTimeout);
            snackbar.classList.remove("show", "success", "error", "warning");

            // Suntik isi konten secara dinamis
            titleEl.innerText = title;
            messageEl.innerText = message;

            // Setel ikon dan kelas CSS berdasarkan tipenya
            if (type === "success") {
                icon.innerHTML = "✓";
                snackbar.classList.add("success");
            } else if (type === "error") {
                icon.innerHTML = "✕";
                snackbar.classList.add("error");
            } else if (type === "warning") {
                icon.innerHTML = "⚠";
                snackbar.classList.add("warning");
            }

            // Picu animasi muncul
            setTimeout(() => {
                snackbar.classList.add("show");
            }, 10);

            // Otomatis tutup setelah 4 detik
            snackbarTimeout = setTimeout(function() {
                snackbar.classList.remove("show");
            }, 4000);
        }

        function closeSnackbar() {
            const snackbar = document.getElementById("snackbar");
            snackbar.classList.remove("show");
            clearTimeout(snackbarTimeout);
        }

        // Date Picker
        jQuery(".mydatepicker, #datepicker, .input-group.date").datepicker({
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#datepicker-autoclose").datepicker({
            autoclose: true,
            todayHighlight: true,
        });
        jQuery("#date-range").datepicker({
            toggleActive: true,
        });
        jQuery("#datepicker-inline").datepicker({
            todayHighlight: true,
        });
</script>

</html>