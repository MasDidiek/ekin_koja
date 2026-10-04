<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

  <style>
    .form-periode {
      width: 20em;
      height: 13em;
      background: #FFF;
      position: absolute;
      top: 9em;
      left: 2em;
      border: 1px solid #DDD;
      border-radius: 3px;
      padding: 0;
      display: none;
    }

    .header-periode {
      background-color: #FFF;
      color: #666;
      height: 50px;
      display: block;
      width: 100%;
      padding: 5px;
    }



    .body-periode {
      background-color: #FFF;

      height: auto;
      display: block;
    }

    .btn-prev,
    .btn-next {
      width: 20%;
      display: inline-block;
      padding: 6px 10px;
      border: none;
      font-size: 14px;
    }



    .tahun_periode {
      border: none;
      width: 57%;
      display: inline-block;
      padding: 6px 10px;
      font-size: 14px;
      cursor: none;
      text-align: center;
    }

    .btn-bulan {
      display: inline-block;
      width: 25%;
      padding: 8px 5px;
      border: none;
      background-color: #FFF;
      color: #666;
      border-radius: 3px;
    }

    .btn-bulan:hover {
      background-color: #2792e7;
      color: #FFF;
    }

    .bln-active {
      background-color: #2792e7;
      color: #FFF;
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
                  <h4 class="fw-semibold mb-8">Data Pegawai</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Data Pegawai</li>
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

          $bulan_tmt_filter = $this->session->userdata('bulan_tmt');
          $ganjil_genap = $this->session->userdata('ganjil_genap');

          $listBulan = array_bulan();

          if ($ganjil_genap == 1) {
            $check = 'checked';
          } else {
            $check = '';
          }

          #print_array($this->session->userdata);
          ?>


          <div class="row">

            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <form action="<?php echo base_url(); ?>admin/gaji/filter_tmt" method="post">
                    <div class="row">


                      <div class="col-md-2">
                        <label for="Filter">Filter Bulan TMT</label>
                        <select name="bulan_tmt" id="bulan" class="form-control">
                          <?php
                          for ($i = 1; $i < count($listBulan); $i++) {
                            if ($i == $bulan_tmt_filter) {
                              echo ' <option value="' . $i . '" selected>' . $listBulan[$i] . '</option>';
                            } else {
                              echo ' <option value="' . $i . '">' . $listBulan[$i] . '</option>';
                            }
                          }
                          ?>


                        </select>

                      </div>
                      <div class="col-md-3">
                        <label for="">Ganjil/Genap</label> <br>
                        <input type="checkbox" name="ganjil_genap" <?php echo $check; ?> value="1" id="ganjil_genap"> <label for="ganjil_genap">Genap</label>
                        &nbsp;&nbsp;&nbsp;
                        <button type="submit" class="btn btn-info">Submit</button>
                        <a href="<?php echo base_url(); ?>admin/gaji/all_data" class="btn btn-success">Semua</a>
                      </div>


                    </div>
                  </form>

                  <div class=" float-end">

                    <form method="post" action="<?php echo base_url(); ?>admin/gaji/recount" class="row">
                      <div>
                        <label for="recipient-name" class="control-label  float-start">Tanggal Recount:</label><br>
                        <input type="text" required name="tanggal" autocomplete="off" class="form-control float-start me-2" value="<?php echo date('d-m-Y'); ?>" style="width: 150px;" id="tanggal_recount">
                        <button type="submit" class="btn btn-info  float-start">Recount</button>
                      </div>


                    </form>
                  </div>

                  <div class="clearfix"></div>
                  <Br><Br><Br>

                  <a href="<?php echo base_url(); ?>admin/gaji/data_gaji" class="btn btn-light float-end ms-2"> <i class="fas fa-refresh"></i> Update Data Gaji</a>
                  <a href="<?php echo base_url(); ?>admin/gaji/data_bpjs_pajak" class="btn btn-light float-end ms-2"> <i class="fas fa-book"></i> Update BPJS & Pajak</a>


                  <div class="clearfix"></div>

                  <?php $last_recount = $pegawai[0]->last_date_recount; ?>
                  Tanggal Recount Terakhir : <strong><?php echo format_view($last_recount); ?></strong>

                  <div class="table-responsive mt-4">
                    <table class="table  table-hover" id="data-table">
                      <thead>
                        <tr>

                          <th class="w-1">No.</th>

                          <th>TMT</th>
                          <th>Masa Kerja</th>
                          <th>Nama</th>
                          <th>Jabatan</th>
                          <th>Gaji Pokok</th>
                          <th>Pengali </th>
                          <th>TKD Pokok </th>
                          <th>PPh21 </th>
                          <th>BPJS </th>
                          <th>BPJS TK </th>


                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $bulan = 1;


                        $date1 = '2025-01-01';


                        $no = 1;
                        foreach ($pegawai as $peg) {

                          $id_pegawai = $peg->id_pegawai;
                          $nip = $peg->nip;
                          $id_jabatan = $peg->id_jabatan;
                          $tmt = $peg->tgl_masuk;
                          $id_pendidikan = $peg->id_pendidikan;

                          $gaji_pokok = $peg->gaji_pokok;
                          $pengkalian = $peg->pengkalian;
                          $pph21 = $peg->pph21;
                          $bpjs_kes = $peg->bpjs_kes;
                          $bpjs_tk = $peg->bpjs_tk;

                          $tkd_pokok = $gaji_pokok * $pengkalian;

                          $masa_kerja = hitungMasaKerja($date1, $tmt);
                          $masa_tahun = $masa_kerja['years'];
                          $masa_bulan = $masa_kerja['months'];


                          $bulan_tmt = date('m', strtotime($tmt));
                          $tahun_tmt = date('Y', strtotime($tmt));

                          if ($tahun_tmt % 2 == 0) {
                            //angka genap
                            $gg = 1; //tahun ganil / genap
                            if ($bulan_tmt == $bulan) {
                              $cekNaikGaji = 'class="bg-danger-subtle text-danger"';
                            } else {
                              $cekNaikGaji = '';
                            }
                          } else {
                            //angka ganjil
                            $gg = 0;
                            $cekNaikGaji = '';
                          }



                          $id_masa_kerja = $this->Master_model->getIdMasaKerja($masa_tahun);
                          $gaji_pokok_mst = $this->Master_model->getGajiPokok($id_masa_kerja, $id_pendidikan);

                          if ($gaji_pokok != $gaji_pokok_mst) {
                            $classDngr = 'fw-bold text-danger';
                          } else {
                            $classDngr = 'fw-semi-bold text-success';
                          }
                          //print_array($id_masa_kerja);

                          //    if ($bulan_tmt == $bulan_tmt_filter && $gg == $ganjil_genap) {



                          echo ' <tr>
                                                                  <td>' . $no . ' </td>
                                                                
                                                                  <td class="text-center">' . format_semi($tmt) . '</td>
                                                                  <td class="text-center">' . $masa_tahun . ' tahun ' . $masa_bulan . ' bulan</td>
                                                                  <td ' . $cekNaikGaji . '>
                                                                  <a href="' . base_url() . 'admin/pegawai/detail_pegawai/' . $id_pegawai . '">' . $peg->nama . '</a></td>
                                                                  <td>' . $peg->jabatan . ' </td>
                                                              
                                                                  <td class="text-end ' . $classDngr . '">' . rupiah($gaji_pokok) . '</td>
                                                                  <td class="text-end">' . $pengkalian . '</td>
                                                                  <td class="text-end">' . rupiah($tkd_pokok) . '</td>
                                                                  <td class="text-end">' . rupiah($pph21) . '</td>
                                                                  <td class="text-end">' . rupiah($bpjs_kes) . '</td>
                                                                  <td class="text-end">' . rupiah($bpjs_tk) . '</td>
                                                                 
                                                                  
                                                              </tr>';

                          $no += 1;
                          //   }
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

        <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>

        <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>


</body>




<script>
  var pesan = '<?php echo $message; ?>';
  if (pesan != '') {
    toastr.success(pesan, "Success!");
  }


  var nowTemp = new Date();
  var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

  var checkin = $('#tanggal_recount').datepicker({
    onRender: function(date) {
      //  return date.valueOf() < now.valueOf() ? 'disabled' : '';
    }
  }).on('changeDate', function(ev) {

    if (ev.date.valueOf() > checkout.date.valueOf()) {
      var newDate = new Date(ev.date)
      newDate.setDate(newDate.getDate() + 1);
      checkout.setValue(newDate);
    }
    checkin.hide();

  }).data('datepicker');



  $('#data-table').dataTable({

    dom: 'lBfrtip',
    lengthMenu: [
      [50, -1],
      ['50', 'Show all']
    ],
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ]
  });
</script>

</html>