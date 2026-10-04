<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        .datepicker {
            z-index: 1999;
        }


        /* The snackbar - position it at the bottom and in the middle of the screen */
        #snackbar {

            /* Hidden by default. Visible on click */
            min-width: 250px;
            /* Set a default minimum width */
            margin-left: -125px;
            /* Divide value of min-width by 2 */
            background-color: #fbf8d2;
            /* Black background color */
            color: #936017;
            /* White text color */
            text-align: center;
            /* Centered text */
            border-radius: 2px;
            /* Rounded borders */
            padding: 16px;
            /* Padding */
            position: fixed;
            /* Sit on top of the screen */
            z-index: 1;
            /* Add a z-index if needed */
            left: 50%;
            /* Center the snackbar */
            top: 50px;

            /* 30px from the bottom */
        }

        /* Show the snackbar when clicking on a button (class added with JavaScript) */
        #snackbar.show {
            visibility: visible;
            /* Show the snackbar */
            /* Add animation: Take 0.5 seconds to fade in and out the snackbar.
        However, delay the fade out process for 2.5 seconds */
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        /* Animations to fade the snackbar in and out */
        @-webkit-keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }

            to {
                top: 50px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                top: 0;
                opacity: 0;
            }

            to {
                top: 50px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                top: 50px;
                opacity: 1;
            }

            to {
                top: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                top: 50px;
                opacity: 1;
            }

            to {
                top: 0;
                opacity: 0;
            }
        }
    </style>
</head>

<body onLoad="myFunction()">
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

                <!-- 
            <div  class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
              <div class="hstack gap-3">
                <div class="john-img">
                  <img
                    src="../assets/images/profile/user-1.jpg"
                    class="rounded-circle"
                    width="40"
                    height="40"
                    alt=""
                  />
                </div>
                <div class="john-title">
                  <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                  <span class="fs-2">Designer</span>
                </div>
                <button
                  class="border-0 bg-transparent text-primary ms-auto"
                  tabindex="0"
                  type="button"
                  aria-label="logout"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  data-bs-title="logout"
                >
                  <i class="ti ti-power fs-6"></i>
                </button>
              </div>
            </div>

            <!-- ---------------------------------- -->
                <!-- Start Vertical Layout Sidebar -->
                <!-- ---------------------------------- -
            </div> -->
        </aside>

        <!--  Sidebar End -->
        <div class="page-wrapper">
            <!--  Header Start -->
            <?php $this->load->view('layout/section/header'); ?>
            <!--  Header End -->


            <div class="body-wrapper">
                <div class="container-fluid">
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Update Data Pajak & BPJS</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Update Data Pajak & BPJS</li>
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


                    $jns_pegawai = $this->uri->segment(4);
                    $message = $this->session->flashdata('message');

                    // echo $message

                    if ($message != '') {
                        echo '
                        <div id="snackbar">
                            <i class="fas fa-check-circle"></i> Data berhasil diupdate
                        </div>';
                    }


                    ?>




                    <div class="row">

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold mb-4">Update Data Pajak & BPJS </h5>

                                    <div class="clearfix"></div>
                                    <!-- 
                                    <button type="button" class="btn btn-warning  btn-circle float-end ms-2" data-bs-toggle="modal" data-bs-target="#import-modal" data-bs-whatever="@mdo">
                                        <i class="fa-solid fa-download"></i>&nbsp; Import Data BPJS TK
                                    </button>

                                    <button type="button" class="btn btn-info  btn-circle float-end ms-2" data-bs-toggle="modal" data-bs-target="#import-pajak" data-bs-whatever="@mdo">
                                        <i class="fa-solid fa-download"></i>&nbsp; Import Data Pajak
                                    </button> -->

                                    <form action="<?php echo base_url(); ?>admin/gaji/proses_update_pajak_bpjs" id="update_form" method="post">
                                        <button type="submit" class="btn btn-success  btn-circle float-end ms-2">
                                            <i class="fa-solid fa-upload"></i>&nbsp; Update Data
                                        </button <a href="<?php echo base_url(); ?>admin/gaji/index" class="btn btn-danger float-start">Kembali</a>

                                        <div class="clearfix"></div>
                                        <div class="table-responsive mt-4">

                                            <table class="table  table-hover table-bordered">
                                                <thead>
                                                    <tr>

                                                        <th class="w-1">No.</th>
                                                        <th>TMT</th>

                                                        <th>Nama</th>
                                                        <th>Gaji Pokok</th>
                                                        <th>Pengkalian</th>
                                                        <th>TKD Pokok </th>
                                                        <th>BPJS </th>
                                                        <th>BPJS TK</th>
                                                        <th>PPH21</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php



                                                    $no = 1;
                                                    foreach ($pegawai as $peg) {

                                                        $id_pegawai = $peg->id_pegawai;
                                                        $nip = $peg->nip;
                                                        $id_jabatan = $peg->id_jabatan;
                                                        $tmt = $peg->tgl_masuk;
                                                        $id_puskesmas = $peg->id_puskesmas;

                                                        $gajiPegawai = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);
                                                        if (!empty($gajiPegawai)) {
                                                            $gaji_pokok = $gajiPegawai[0]->gaji_pokok;
                                                            $pengkalian = $gajiPegawai[0]->pengkalian;
                                                            $bpjs_kes = $gajiPegawai[0]->bpjs_kes;
                                                            $bpjs_tk = $gajiPegawai[0]->bpjs_tk;
                                                            $pph21 = $gajiPegawai[0]->pph21;
                                                        } else {
                                                            $gaji_pokok = 0;
                                                            $pengkalian = 0;
                                                            $bpjs_kes =  0;
                                                            $bpjs_tk = 0;
                                                            $pph21 = 0;
                                                        }

                                                        $tkd_pokok = $gaji_pokok * $pengkalian;
                                                        $tkd_pokok = number_format($tkd_pokok, 0);


                                                        echo ' <tr>
                                                                  <td>' . $no . ' </td>
                                                                  
                                                                  <td class="text-center">' . format_semi($tmt) . '</td>
                                                                   <td><a href="' . base_url() . 'admin/pegawai/detail_pegawai/' . $id_pegawai . '">' . $peg->nama . '</a></td>
                                                                 
                                                  
                                                                  <td class="text-center"><input type="hidden" name="id_pegawai[]" value="' . $id_pegawai . ' "> ' . $gaji_pokok . '</td>
                                                                  <td> ' . $pengkalian  . ' </td>
                                                                  <td class="text-end">
                                                                  ' . $tkd_pokok . '</td>
                                                                  <td class="text-end">
                                                                  <input type="text" name="bpjs[]" value="' . $bpjs_kes . '">   </td>
                                                                  <td class="text-end">
                                                                  <input type="text" name="bpjs_tk[]" value="' . $bpjs_tk . '">  </td>
                                                                  <td class="text-end">
                                                                  <input type="text" name="pajak[]" value="' . $pph21 . '"></td>
                                                                  
                                                              </tr>';

                                                        $no += 1;
                                                    }


                                                    ?>






                                                </tbody>
                                            </table>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- 
                    <div class="modal fade" id="import-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="exampleModalLabel1">
                                        Import BPJS TK
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">

                                        <div class="col-md-6">
                                            <?php
                                            echo form_open_multipart(base_url() . 'admin/gaji/import_bpjs_tk');

                                            echo '
                                      <label>Upload file (*.xls) : </label>
                                      <input name="file" type="file"><br>
                                      <br>
                                      <button type="submit" class="btn btn-info" id="clickme">
                                        <i class="fa fa-external-link-square"></i> &nbsp; Import
                                      </button>';

                                            echo form_close();
                                            ?>

                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                                        Close
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>



                    <div class="modal fade" id="import-pajak" tabindex="-1" aria-labelledby="exampleModalLabel1">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header d-flex align-items-center">
                                    <h4 class="modal-title" id="exampleModalLabel1">
                                        Update Data Pajak & BPJS
                                    </h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="row">

                                        <div class="col-md-6">
                                            Loading
                                        </div>
                                    </div>


                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                                        Close
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div> -->

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


                <script>
                    function myFunction() {
                        var x = document.getElementById("snackbar");
                        x.className = "show";
                        setTimeout(function() {
                            x.className = x.className.replace("show", "");
                        }, 3000);
                    }
                </script>
</body>


</html>