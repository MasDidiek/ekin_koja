<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/addon.css" media="screen">

</head>

<body>


  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div>
        <!-- Start Vertical Layout Sidebar -->


        <?php $this->load->view('layout/section/sidebar'); ?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header'); ?>
      <!--  Header End -->
      <?php

      $jns_pegawai = $this->uri->segment(4);
      $message = $this->session->flashdata('message');

      // print_array($this->session->userdata);
      // exit;
      $periode_bulan = $this->session->userdata('periode_bulan');
      $periode_tahun = $this->session->userdata('periode_tahun');
      $id_pkm_sess   = $this->session->userdata('id_pkm');
      $id_pj_sess = $this->session->userdata('id_pj');
      $id_user_validator   = $this->session->userdata('id_pegawai');

      if ($periode_bulan == '') {
        $bulan = date('m');
        $tahun = date('Y');
      } else {
        $bulan = $periode_bulan;
        $tahun = $periode_tahun;
      }


      $nm_bulan = getBulan($bulan);


      $periode = $tahun . '-' . $bulan;
      $periode = date('Y-m', strtotime($periode));

      echo $message;


      $listBulan = array_bulan();

      $lastDateMonth = date('t', strtotime($periode));

      ?>

      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Absensi Pegawai</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Absensi Pegawai</li>
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


          <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">


                  <div class="row">
                    <div class="col-md-3">
                      <label for="bulan">Periode</label><br>
                      <input type="text" readonly class="periode" name="periode" id="periode" value="<?php echo $nm_bulan . ' &nbsp; &nbsp; ' . $tahun; ?>">
                    </div>
                    <div class="form-periode">
                      <div class="header-periode">
                        <button type="button" class="btn-prev"><i class="fa-solid fa-angle-left"></i> </button>
                        <input type="text" name="periode_tahun" class="tahun_periode" value="<?php echo $tahun; ?>" id="tahun">
                        <button type="button" class="btn-next"><i class="fa-solid fa-angle-right"></i> </button>
                      </div>
                      <div class="body-periode">
                        <?php
                        for ($b = 1; $b < 13; $b++) {

                          if ($b == $bulan) {
                            $active = 'bln-active';
                          } else {
                            $active = '';
                          }
                          echo '<button class="btn-bulan ' . $active . '" value="' . $listBulan[$b] . '">' . substr($listBulan[$b], 0, 3) . '</button>';
                        }
                        ?>

                      </div>
                    </div><!--form-periode-->


                    <div class="col-md-3">
                      <label for="puskesmas">Puskesmas</label>
                      <select name="id_validator" id="validator" class="pilih-validator form-control">

                        <?php
                        foreach ($validator as $pj) {

                          $id_pj = $pj->id_pegawai;
                          $nama_pj   = $pj->nama;


                          if ($id_pj_sess == $id_pj) {
                            echo '<option value="' . $id_pj . '" selected>' . $nama_pj . '</option>';
                          } else {
                            echo '<option value="' . $id_pj . '">' . $nama_pj . '</option>';
                          }
                        }
                        ?>

                      </select>
                    </div>
                     <div class="col-md-3">
                      <label for="puskesmas">Jenis Pegawai</label>
                      <select name="jenis_pegawai" id="jenis_pegawai" class="pilih-validator form-control">
                       
                        <option value="non_pns">Non PNS</option>
                        <option value="pppk_pw">PPPK PW</option>
                        <option value="pjlp">PJLP</option>
                      </select>
                    </div>


                  </div><!--row-->



                  <a href="<?php echo base_url(); ?>admin/presensi/importDataAbsensi" class="btn btn-info float-end" target="_blank" rel="noopener noreferrer"><i class="fa-solid fa-download"></i> Import Data Absensi</a>
                  <a href="<?php echo base_url(); ?>admin/presensi/DataRekapAbsensi" class="btn btn-success float-end me-2" target="_blank"><i class="fa-solid fa-file"></i> Rekap Data Absensi</a>
                  <a href="<?php echo base_url(); ?>admin/presensi/laporan_absensi" class="btn btn-success float-end me-2"><i class="fa-solid fa-file"></i> Laporan Absensi</a>


                  <div class="clearfix"></div>

                  <div class="table-responsive mt-4" style="max-height:500px">
                    <table class="table table-sm table-bordered table-hover" style="width: 160%;">
                      <thead>
                        <tr>
                          <th width="300">Nama</th>

                          <?php

                          for ($i = 1; $i < ($lastDateMonth + 1); $i++) {
                            $date =  $periode . '-' . $i;

                            $tanggal = format_db($date);
                            $day = date('l', strtotime($tanggal));
                            if ($day == 'Sunday') {
                              $hari = 'Mg';
                            } else if ($day == 'Monday') {
                              $hari = 'Sn';
                            } else if ($day == 'Tuesday') {
                              $hari = 'Sl';
                            } else if ($day == 'Wednesday') {
                              $hari = 'Rb';
                            } else if ($day == 'Thursday') {
                              $hari = 'Km';
                            } else if ($day == 'Friday') {
                              $hari = 'Jm';
                            } else {
                              $hari = 'Sb';
                            }

                            echo ' <th class="text-center">' . $i . ' <br>
                                              <small>' . $hari . '</small></th>';
                          }
                          ?>

                        </tr>
                      </thead>
                      <tbody>
                        <?php


                        $no = 1;



                        foreach ($pegawai as $peg) {

                         // print_array($peg);

                          $id_pegawai = $peg->id_pegawai;
                          $nip = $peg->nip;
                          $nama = $peg->nama;
                          $jns_jam_kerja = $peg->jns_jam_kerja;
                          $id_pj = $peg->id_validator;

                          $pin = $peg->id_mesin;
                          //$pin = substr($nip, -4);

                          $dataRekap = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
                          if (!empty($dataRekap)) {

                            $status = $dataRekap[0]->status;
                            if ($status == 1) {
                              $flag_rekap = '<span class="text-success"><i class="fa-solid fa-check-circle"></i></span>';
                            } else {
                              $flag_rekap = '<span class="text-warning"><i class="fa-solid fa-info-circle"></i></span>';
                            }
                          } else {
                            $flag_rekap = '<span class="text-danger"><i class="fa-solid fa-question-circle"></i></span>';
                          }

                          $dataAbsensi  = $this->Presensi_model->getAbsensiPegawai($pin, $periode);

                          echo ' <tr>

                                                              <td id="pin' . $pin . '">
                                                                  ' . $flag_rekap . ' &nbsp; <a href="' . base_url() . 'admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin . '" class="fs-2">
                                                                  ' . strtoupper($peg->nama) . '
                                                                  </a>

                                                                  <div class="progress" id="bar' . $pin . '">
                                                                      <div class="progress-bar bg-success" id="myBar' . $pin . '" role="progressbar" style="width: 1%" aria-valuenow="1" aria-valuemin="0" aria-valuemax="100"></div>
                                                                  </div>
                                                                  <a href="' . base_url() . 'admin/presensi/update_absensi_pegawai/' . $id_pegawai . '/' . $pin . '" id="' . $pin . '" class="fs4 text-primary float-end">
                                                                    <i class="fas fa-redo-alt"></i>
                                                                  </a>

                                                              </td>';

                          for ($i = 0; $i < count($dataAbsensi); $i++) {
                            $absn_msk = $dataAbsensi[$i]->masuk;
                            $absn_plg = $dataAbsensi[$i]->pulang;
                            $tanggal = $dataAbsensi[$i]->tanggal;
                            $shift   = $dataAbsensi[$i]->shift;

                            if ($absn_msk != '') {
                              $status_absen = 'Y';


                              if ($absn_plg != '') {
                                $status_absen = '<i class="fa-solid fa-check-double"></i>';
                                $flag = 'bg-success';
                              } else {
                                $status_absen = '<i class="fa-solid fa-check"></i>';
                                $flag = 'bg-warning';
                              }

                              if ($absn_msk == 'DLP') {
                                $status_absen = 'DL';
                                $flag = 'bg-info-subtle text-info';
                              }

                              if ($absn_msk == 'IZIN') {
                                $status_absen = 'IZ';
                                $flag = 'bg-warning-subtle text-warning';
                              }
                              if ($absn_msk == 'SAKIT') {
                                $status_absen = 'SK';
                                $flag = 'bg-warning-subtle text-warning';
                              }

                              if ($absn_msk == 'CUTI') {
                                $status_absen = 'CT';
                                $flag = 'bg-success-subtle text-success';

                                $cekCuti = $this->Presensi_model->getJnsCuti($id_pegawai, $tanggal);

                                if ($cekCuti == 1) {
                                  $status_absen = 'CT'; //cuti tahunan
                                } else if ($cekCuti == 2) {
                                  $status_absen = 'CB'; //cuti bersalin
                                } else if ($cekCuti == 3) {
                                  $status_absen = 'CAP'; //cuti bersalin
                                } else if ($cekCuti == 4) {
                                  $status_absen = 'CS'; //cuti bersalin
                                } else {
                                  $status_absen = 'CBS'; //cuti bersalin
                                }
                                // print_array($cekCuti);
                              }
                            } else {
                              $status_absen = 'T';


                              if ($absn_plg != '') {
                                $status_absen = '<i class="fa-solid fa-check"></i>';
                                $flag = 'bg-warning';
                              } else {
                                $status_absen = '<i class="fa-solid fa-question-circle"></i>';
                                $flag = 'bg-danger';


                                $hariLibur = $this->Presensi_model->cekHariLibur($tanggal);
                                if (!empty($hariLibur)) {
                                  $status_absen = '<i class="fa-solid fa-calendar-times"></i>';
                                  $flag = 'bg-light text-danger';
                                }


                                $day  = date('D', strtotime($tanggal));

                                if ($day == 'Sun' || $day == 'Sat') {
                                  $status_absen = '<i class="fa-solid fa-minus"></i>';
                                  $flag = 'bg-light text-danger';
                                }
                              }
                            } //close if $absn_msk != ''

                            if ($shift == '') {
                              $status_absen = '<i class="fa-solid fa-minus"></i>';
                              $flag = 'bg-light text-danger';
                            }


                            if ($jns_jam_kerja == 'shift') {
                              $flag = 'bg-light text-danger fs-1';
                              $status_absen = $shift;
                              if ($shift == 'SM') {
                                if ($absn_msk == '') {
                                  $flag = 'bg-danger  fs-1';
                                } else {
                                  $flag = 'bg-success  fs-1';
                                }
                              } else if ($shift == 'L-OFF') {
                                $status_absen = 'LO';
                                if ($absn_plg == '') {
                                  $flag = 'bg-danger  fs-1';
                                } else {
                                  $flag = 'bg-success  fs-1';
                                }
                              } else if ($shift == 'P') {
                                if ($absn_msk == '') {
                                  if ($absn_plg == '') {
                                    $flag = 'bg-danger  fs-1';
                                  } else {
                                    $flag = 'bg-warning  fs-1';
                                  }
                                } else {
                                  if ($absn_plg == '') {
                                    $flag = 'bg-warning  fs-1';
                                  } else {
                                    $flag = 'bg-success  fs-1';
                                  }
                                }
                              } else if ($shift == 'PSM') {
                                if ($absn_msk == '') {
                                  $flag = 'bg-danger  fs-1';
                                } else {
                                  $flag = 'bg-success  fs-1';
                                }
                              }
                            }


                            echo '<td class="text-center">
                                  <button class="btn btn-sm ' . $flag . ' btn-info-absensi" value="' . $pin . '/' . $id_pegawai . '/' . $tanggal . '"  data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg">' . $status_absen . ' </button>
                                </td>';
                              }

                          echo '</tr>';

                          $no += 1;

                          $status_absen =  '';
                          $flag = '';
                          # }

                        }


                        ?>

                      </tbody>
                    </table>
                  </div><!--table-responsive-->


                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" id="bs-example-modal-xlg" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                  <h4 class="modal-title" id="myLargeModalLabel">
                    Data Absensi Pegawai
                  </h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modal-form">


                </div>
                <div class="modal-footer">
                  <button type="button" class="btn bg-danger-subtle text-danger font-medium waves-effect text-start" data-bs-dismiss="modal"> Close </button>
                </div>
              </div>
              <!-- /.modal-content -->
            </div>

            <!-- /.modal-dialog -->
          </div>
          <!-- /.modal -->

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
    <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

    <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

    <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>
</body>


<script>
  $(document).mouseup(function(e) {
    var container = $(".form-periode");

    // if the target of the click isn't the container nor a descendant of the container
    if (!container.is(e.target) && container.has(e.target).length === 0) {
      container.hide();
    }
  });


  $(document).ready(function(e) {

    $(".btn-bulan").click(function() {
      var bulan = $(this).val();
      var tahun = $("#tahun").val();

      var bulan_tahun = bulan + '  ' + tahun;
      $("#periode").val(bulan_tahun);

      $(".form-periode").hide();

      $(".btn-bulan").removeClass("bln-active");
      $(this).addClass("bln-active");

      $.ajax({

        type: "POST",
        dataType: "html",
        url: "<?php echo base_url(); ?>admin/presensi/set_session_periode",
        data: "bulan=" + bulan + "&tahun=" + tahun,
        success: function(msg) {
          window.location.reload();
          //$("#modal-form").html(msg);
          //console.log(msg);
        }

      });

    });


    $("#periode").click(function() {
      $(".form-periode").show();
    });

    $(".text-primary").click(function() {
      var pin = $(this).attr("id");

      $("#bar" + pin).show();
      move(pin);
    });

    $(".btn-next").click(function() {
      var tahun = $("#tahun").val();

      var new_tahun = parseInt(tahun) + 1;
      $("#tahun").val(new_tahun);
    });


    $(".btn-prev").click(function() {
      var tahun = $("#tahun").val();

      var new_tahun = parseInt(tahun) - 1;
      $("#tahun").val(new_tahun);
    });

    $("#validator").change(function() {
      var id_pj = $(this).val();

      $.ajax({

        type: "POST",
        dataType: "html",
        url: "<?php echo base_url(); ?>admin/presensi/set_session_validator",
        data: "id_pj=" + id_pj,
        success: function(msg) {
          window.location.reload();
          //$("#modal-form").html(msg);
          //console.log(msg);
        }

      });

    });


    $(".btn-info-absensi").click(function() {

      var data_post = $(this).val();
      $.ajax({

        type: "POST",
        dataType: "html",
        url: "<?php echo base_url(); ?>admin/presensi/detail_absensi_harian",
        data: "data_post=" + data_post,
        success: function(msg) {
          $("#modal-form").html(msg);
        }

      });

    });


  });


  function move(pin) {
    var elem = document.getElementById("myBar" + pin);
    var width = 20;
    var id = setInterval(frame, 45);

    function frame() {
      if (width >= 100) {
        clearInterval(id);
      } else {
        width++;
        elem.style.width = width + '%';
        elem.innerHTML = width * 1 + '%';
      }
    }
  }
</script>

</html>