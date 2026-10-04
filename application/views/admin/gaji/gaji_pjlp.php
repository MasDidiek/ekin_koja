<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        table{
            width: 100%;
            font-family: Arial, Helvetica, sans-serif
        }
        table th{
            background-color: #f0f3f5;
            padding: 0.5rem;
            border: 1px solid #dee8ed;
            text-align: center;
        }

        table td{
            padding:0.3rem 0.5rem;
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
                                    <h4 class="fw-semibold mb-8">Data Gaji Pegawai PJLP</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>

                                            <li> &nbsp; / &nbsp; </li>

                                            <li class="breadcrumb-acive">Data Gaji Pegawai PJLP</li>
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


                                    <div class="btn-group mb-2" role="group" aria-label="Basic example">
                                        <a href="<?php echo base_url();?>admin/pegawai/data_pegawai/pjlp" class="btn bg-primary-subtle text-primary ">
                                        Data Pegawai
                                        </a>
                                        <a href="<?php echo base_url();?>admin/absensi_pjlp/main" class="btn bg-primary-subtle text-primary ">
                                             Data Absensi
                                          </a>
                                        <a href="<?php echo base_url();?>admin/gaji_pjlp/index" class="btn bg-primary text-white ">
                                             Data Penggajian
                                         </a>
                                    </div>

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


  <a href="<?php echo base_url();?>admin/gaji_pjlp/export_gaji" class="btn btn-success float-end ms-1">Export Data Gaji </a>
                                    <a href="<?php echo base_url();?>admin/gaji_pjlp/edit_data_gaji" class="btn btn-info float-end">Edit Data </a>

                                    <div class="clearfix"></div>
                                    <div class="table-responsive mt-4">
                                        <table>
                                            <thead>
                                                <tr>

                                                    <th class="w-1">No.</th>
                                                    <th>ID PJLP</th>
                                                    <th>Nama</th>
                                                    <th>Jabatan</th>
                                                    <th>Gaji Pokok</th>
                                                    <th>Capaian</th>
                                                    <th>Bruto</th>
                                                    <th>Pajak</th>
                                                    <th>BPJS Kes</th>
                                                    <th>BPJS TK</th>
                                                    <th>THP</th>
                                                    <th>Update</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php

                                                $no = 1;

                                                #print_array($pegawai);
                                                foreach ($pegawai as $peg) {

                                                    $id_pjlp = $peg->id_pjlp;
                                                    $gaji_pokok = $peg->gaji_pokok;

                                                    if($gaji_pokok==''){
                                                      $gaji_pokok = 0;
                                                    }

                                                    $DataRekapGaji = $this->Laporan_model->cekDataRekapGajiPjlp($id_pjlp, $periode);
                                                    if(!empty($DataRekapGaji)){

                                                      $id_gaji = $DataRekapGaji[0]->id;
                                                      $capaian = $DataRekapGaji[0]->capaian;
                                                      $bruto = $DataRekapGaji[0]->bruto;
                                                      $pph21 = $DataRekapGaji[0]->pph21;
                                                      $bpjs = $DataRekapGaji[0]->bpjs;
                                                      $bpjs_tk = $DataRekapGaji[0]->bpjs_tk;
                                                      $thp = $DataRekapGaji[0]->thp;
                                                    }else{
                                                      $capaian = 0;
                                                      $bruto = 0;
                                                      $pph21 = 0;
                                                      $bpjs = 0;
                                                      $bpjs_tk = 0;
                                                      $thp = 0;
                                                      $id_gaji = 0;
                                                    }

                                                    echo ' <tr>
                                                                  <td>' . $no . ' </td>

                                                                  <td class="text-center"> ' . $id_pjlp . '</td>
                                                                  <td class="text-start"><a href="' . base_url() . 'admin/gaji_pjlp/detail_gaji_pjlp/' . $id_gaji. '/'.$id_pjlp.'">' . $peg->nama . '</a></td>
                                                                  <td>Petugas ' . $peg->jabatan . ' </td>

                                                                  <td  class="text-end">' . rupiah($gaji_pokok) . ' </td>
                                                                  <td>'.$capaian .'</td>

                                                                  <td>'.rupiah($bruto) .'</td>
                                                                  <td>'.rupiah($pph21) .'</td>
                                                                  <td>'.rupiah($bpjs) .'</td>
                                                                  <td>'.rupiah($bpjs_tk) .'</td>
                                                                  <td>'.rupiah($thp).'</td>
                                                                  <td><a href="' . base_url() . 'admin/gaji_pjlp/update_data_gaji_pegawai/' . $peg->id_pjlp . '" class="btn btn-sm btn-info">Update</a></td>

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
</script>

</html>
