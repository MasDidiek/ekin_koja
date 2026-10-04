<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <style>
    table {
      width: 100%;
    }

    table tr td,
    th {
      padding: 8px 10px;
      border-bottom: 1px solid #EEE;
      font-size: 13px;
    }

    .text-black {
      font-weight: 600 color:#666;
    }

    th {
      background: #f2f4f7;
      color: #333 !important;
      padding: 10px;
      font-size: 14px;
    }

    .status_cuti {
      padding: 3px 10px;
      font-weight: 400;
      font-size: 13px;
      border-radius: 3px;
      font-family: arial
    }

    .approved {
      color: #FFF;
      border: 1px solid #55d97a;
      background: #5ee684;
    }

    .pending {
      color: #FFF;
      border: 1px solid #f1c73e;
      background: #f1c73e;
    }

    .reject {
      color: #d9563c;
      border: 1px solid #d9563c;
    }

    .cancel {
      color: #999;
      border: 1px solid #DDD;
    }


    .pagination {
      width: 100%;
      background: #FFF;
      margin-top: 20px;
    }
  </style>
</head>

<body>


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


      <div class="body-wrapper">
        <div class="container-fluid mw-100">
          <!--  Row 1 -->


          <?php
          #print_array($this->session->userdata);
          $tgl_pencarian = $this->session->userdata('tgl_pencarian');
          $usergroup   = $this->session->userdata('usergroup');
          $arrayStatus = array('Semua', 'Pending', 'Approve', 'Tolak', 'Batal', 'Ditangguhkan');
          $offset      = $this->uri->segment(4);

          $jns_cuti = $this->session->userdata('jns_cuti');
          $arrayJnsCuti = array('Semua', 'Tahunan', 'Bersalin', 'Alasan Penting', 'Sakit', 'Besar');

          $arrayBulan = array_bulan2();

          ?>

          <div class="card">
            <div class="card-body">
              <div class="row">

                <div class="col-md-12 mb-2">
                  <h5>Pengajuan Cuti Pegawai</h5><br>

                  <form action="<?php echo base_url(); ?>admin/pengajuan_cuti/filter_data" method="post">
                    <div class="row">

                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="Jns">Jenis Cuti</label>
                          <select name="jns_cuti" class="form-control">
                            <?php
                            $idjns  = 0;
                            for ($i = 0; $i < count($arrayJnsCuti); $i++) {

                              $jenis_cuti = $arrayJnsCuti[$i];

                              if ($jns_cuti == $idjns) {
                                echo '<option value="' . $idjns . '" selected> ' . $jenis_cuti . '</option>';
                              } else {
                                echo '<option value="' . $idjns . '"> ' . $jenis_cuti . '</option>';
                              }


                              $idjns  = $i + 1;
                            }
                            ?>

                          </select>
                        </div>

                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="Jns">Status Cuti</label>
                          <select name="status_cuti" class="form-control">
                            <option value="pending">Semua</option>
                            <option value="pending">Pending</option>
                            <option value="pending">Disetujui</option>
                            <option value="pending">Cancel</option>
                            <option value="pending">Ditolak</option>

                          </select>
                        </div>

                      </div>

                      <div class="col-md-2">
                        <div class="form-group">
                          <label for="Jns">Periode </label>
                          <input type="text" id="tgl_pencarian" name="tgl_pencarian" value="<?php echo $tgl_pencarian; ?>" required class="form-control " data-provider="flatpickr" data-date-format="d M Y" data-range-date="true" placeholder="Select Date">
                        </div>

                      </div>

                      <div class="col-md-2">
                        <br>
                        <button type="submit" class="btn btn-info" name="button">Submit</button>
                      </div>

                    </div>
                  </form>


                  <form action="<?php echo base_url(); ?>admin/pengajuan_cuti/cari_nama" method="post">
                    <div class="row mt-4">

                      <div class="col-md-4">
                        <div class="form-group">
                          <input type="text" name="keyword" class="form-control" placeholder="cari nama pegawai">
                        </div>
                      </div>

                      <div class="col-md-2">
                        <button type="submit" class="btn btn-info" name="button">Cari</button>
                      </div>



                    </div>
                  </form>



                  <div class="table-responsive mt-4 ">
                    <table class="text-nowrap">
                      <thead>
                        <tr class="text-muted fw-semibold">
                          <th scope="col">No</th>
                          <th scope="col">Nama</th>
                          <th scope="col" width="150">Jenis Cuti</th>
                          <th scope="col">Tanggal Mulai </th>
                          <th scope="col">Tanggal Akhir </th>
                          <th scope="col">Lama Cuti</th>
                          <th scope="col">Alasan</th>
                          <th scope="col">Status</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $noRows = 0;
                        $id_pegawai_validator = $this->session->userdata('id_pegawai');  //id atasan yang sedang login
                        $no = 1;
                        //  print_array($list_cuti );
                        foreach ($list_cuti as $cuti) {
                          $id         = $cuti->id;
                          $photo         = $cuti->photo;
                          $tgl_dari      =  $cuti->tgl_dari;
                          $tgl_sampai    =  $cuti->tgl_sampai;
                          $hari_cuti     =  $cuti->hari_cuti;
                          $status        =  $cuti->status;
                          $id_validator  =  $cuti->id_validator;
                          $id_jns_cuti      =  $cuti->jns_cuti;

                          $jns_cuti      = $this->Master_model->getJnsCuti($id_jns_cuti);

                          if ($photo == '') {
                            $photo = 'avatar.png';
                          }

                          if ($hari_cuti == 1) {
                            $tgl_cuti = '<span class="text-dark">' . format_full($tgl_dari) . '</span>';
                          } else {
                            $tgl_cuti = '<span class="text-dark">' . format_full($tgl_dari) . ' </span> s/d <span class="text-dark">' . format_full($tgl_sampai) . '</span>';
                          }


                          $flagStatus = getStatusCuti($status);

                          if ($status == 'APPROVE') {
                            $flag_cuti = '<span class="status_cuti approved">  Disetujui</span>';
                          } else if ($status == 'CANCEL') {
                            $flag_cuti = '<span class="status_cuti cancel">Dibatalkan</span>';
                          } else if ($status == 'REJECT') {
                            $flag_cuti = '<span class="status_cuti reject">Ditolak</span>';
                          } else {
                            $flag_cuti = '<span class="status_cuti pending">Pending</span>';
                          }

                          $noRows = $no + $offset;
                          if ($usergroup < 3) {
                            //bu muklah / kasubaag TU
                            echo ' <tr>
                                                                <td class="text-black" > ' . $noRows . '</td>
                                                                <td class="text-black" > <a href="' . base_url() . 'admin/pengajuan_cuti/detail/' . $id . '"> ' . $cuti->nama . ' </a> </td>
                                                                <td class="text-black" > ' . $jns_cuti . '</td>
                                                                <td class="text-black"> ' . date('d, M Y', strtotime($tgl_dari)) . ' </td>
                                                                <td class="text-black">' . date('d, M Y', strtotime($tgl_sampai)) . ' </td>
                                                                <td class="text-black text-center"> ' .  $hari_cuti . '</td>
                                                                <td class="text-black">  ' . word_limiter($cuti->alasan_cuti, 4) . '  </td>
                                                                <td> ' . $flag_cuti . '</td>

                                                            </tr> ';
                          } else {


                            if ($id_pegawai_validator == $id_validator) {
                              //Kapuskel, kasatpel


                              echo '  <tr>
                                                                    <td>
                                                                      ' . $cuti->nama . '
                                                                    </td>
                                                                    <td> 05/01/2025 </td>
                                                                    <td> 07/01/2025 </td>
                                                                    <td> 3</td>
                                                                    <td>
                                                                    <p class="mb-0 fs-3">' . $cuti->alasan_cuti . '</p>
                                                                    </td>
                                                                    <td>  </td>

                                                                </tr>  ';
                            }
                          }

                          $no += 1;
                        }
                        ?>


                      </tbody>
                    </table>
                  </div>

                  <div class="row">
                    <div class="col-md-8 p-3">
                      Show <strong> <?php echo $offset + 1; ?> </strong> - <strong><?php echo $noRows; ?></strong> Rows &nbsp; &nbsp; From &nbsp;
                      <strong><?php echo $total_rows; ?></strong> &nbsp;Rows
                    </div>
                    <div class="col-md-4">
                      <div class="pagination"><?php echo $this->pagination->create_links(); ?></div>
                    </div>

                  </div>




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

      <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

</body>


<script>
  $('#data-table').dataTable({
    lengthMenu: [
      [20, -1],
      ['20', '50', '100', 'Show all']
    ]
  });


  $("#tgl_pencarian").flatpickr({
    mode: "range",
    dateFormat: "Y-m-d",
  });
</script>

</html>