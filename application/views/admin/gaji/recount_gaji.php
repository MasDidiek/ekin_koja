<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        .datepicker {
            z-index: 1999;
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
                                    <h4 class="fw-semibold mb-8">Recount Data</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Preview Recount Data</li>
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


                    $tgl_recount = $this->session->userdata('tgl_recount');
                    $date1 = format_db($tgl_recount);

                    ?>


                    <div class="row">

                        <div class="col-md-12   text-center" id="loading" style="display:none">
                            <img src="<?php echo base_url(); ?>assets/images/slack_animation.gif" width="200"> <br>
                            <h5> Updating data....</h5>

                        </div>

                        <div class="col-lg-12 d-flex align-items-stretch">
                            <div class="card w-100">
                                <div class="card-body p-4">
                                    <h5 class="card-title fw-semibold mb-4">Preview Recount Data </h5>
                                    Recount data ke tanggal : <strong><?php echo format_full($tgl_recount); ?></strong>


                                    <div class="clearfix"></div>
                                    <br><br><br>



                                    <a href="<?php echo base_url(); ?>admin/gaji/index" class="btn btn-danger float-start">Kembali</a>
                                    <a href="<?php echo base_url(); ?>admin/gaji/recount_process" onclick="return confirm('Apakah anda yakin untuk melalukan update data gaji pegawai?');" class="btn btn-success float-end">Proses Recount</a>
                                    <div class="clearfix"></div>


                                    <div class="table-responsive mt-4">
                                        <table class="table  table-hover table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>TMT</th>
                                                    <th>Masa Kerja</th>
                                                    <th>Nama</th>
                                                    <th>Gaji </th>
                                                    <th>Gaji Perubahan</th>
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
                                                    $id_pendidikan = $peg->id_pendidikan;
                                                    $pengkalian = $peg->pengkalian;
                                                    $gaji_pokok = $peg->gaji_pokok;

                                                    $namaPegawai = $this->Pegawai_model->getNamaPegawaiByID($id_pegawai);

                                                    $masa_kerja = hitungMasaKerja($date1, $tmt);
                                                    $masa_tahun = $masa_kerja['years'];
                                                    $masa_bulan = $masa_kerja['months'];


                                                    $bulan_tmt = date('m', strtotime($tmt));
                                                    $tahun_tmt = date('Y', strtotime($tmt));

                                                    $id_masa_kerja  = $this->Master_model->getIdMasaKerja($masa_tahun);
                                                    $gaji_pokok_mst = $this->Master_model->getGajiPokok($id_masa_kerja, $id_pendidikan);

                                                    if ($gaji_pokok != $gaji_pokok_mst) {
                                                        $classDngr = 'fw-bold text-danger';
                                                    } else {
                                                        $classDngr = 'fw-semi-bold text-success';
                                                    }

                                                    echo '<tr>
                                                                    <td>' . $no . '</td>
                                                                    <td>' . format_view($tmt) . '</td>
                                                                    <td>' . $masa_tahun . ' tahun  &nbsp; ' . $masa_bulan . ' bulan</td>
                                                                    <td>' . $namaPegawai . '</td>
                                                                    <td class="text-end">' . rupiah($gaji_pokok) . '</td>
                                                                    <td class="text-end ' . $classDngr . '">' . rupiah($gaji_pokok_mst) . '</td>
                                                                
                                                                </tr>';

                                                    $no += 1;
                                                }


                                                ?>






                                            </tbody>
                                        </table>
                                    </div>

                                </div>
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
    $(".btn-success").click(function() {

        $("#loading").show();


    });
</script>

</html>