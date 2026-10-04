<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/addon.css" media="screen">

  <style>
    .table-absensi {
      border-collapse: collapse;
      width: 100%;
    }

    .table-absensi th,
    .table-absensi td {
      border: 1px solid #ddd;
      padding:6px 4px;
    }

    .table-absensi th {
      background-color: #f2f2f2;
      text-align: center;
    }

    .table-absensi td {
      text-align: center;
    }

        /* Class untuk menandai tombol sedang dalam kondisi loading */
    .btn-reset-absensi.is-loading {
        pointer-events: none; /* Matikan klik */
        opacity: 0.7; /* Buat agak transparan */
        cursor: wait; /* Ubah cursor jadi loading */
    }
    .btn-info {
      background-color: #0dcaf0;
      border-color: #0dcaf0;
    }

    .btn-success {
      background-color: #19cd7c;
      border-color: #19cd7c;
    }
    
    </style>
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

       //print_array($this->session->userdata);
      // exit;
     

      if ($this->input->get()) {
           
            $periode       = $this->input->get('periode');
            $id_validator  = $this->input->get('id_validator');
            $jenis_pegawai = $this->input->get('jenis_pegawai');
            
        } 
          // Jika tidak ada parameter GET, ambil dari Session yang tersimpan sebelumnya
      else if ($this->session->userdata('filter_presensi')) {
          $filter = $this->session->userdata('filter_presensi');
          $periode       = $filter['periode'];
          $id_validator  = $filter['id_validator'];
          $jenis_pegawai = $filter['jenis_pegawai'];
        } 
          // Default jika session juga belum ada
          else {
               $periode       =  date('Y-m');
               $id_validator  = $this->session->userdata('id_pegawai');
              $jenis_pegawai  = 'non_pns';
          
          }
          

      $tahun = date('Y', strtotime($periode));
      $bulan = date('m', strtotime($periode));
      $nm_bulan = getBulan($bulan);
      $periode = $tahun . '-' . $bulan;
      $periode = date('Y-m', strtotime($periode));
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


                 <form action="<?php echo base_url('admin/presensi/index'); ?>" method="GET">
                        <div class="row align-items-end">
                          
                          <!-- Filter Periode/Bulan -->
                          <div class="col-md-3">
                            <label for="periode" class="form-label">Periode</label>
                           <input type="month" name="periode" id="periode" class="form-control" value="<?php echo isset($periode) ? $periode : date('Y-m'); ?>">
                          </div>

                          <!-- Filter Puskesmas / Validator -->
                          <div class="col-md-3">
                            <label for="validator" class="form-label">Puskesmas</label>
                            <select name="id_validator" id="validator" class="form-select">
                              <option value="">-- Semua Puskesmas --</option>
                              <?php foreach ($validator as $pj): ?>
                                <?php $selected = ($id_validator == $pj->id_pegawai) ? 'selected' : ''; ?>
                                <option value="<?php echo $pj->id_pegawai; ?>" <?php echo $selected; ?>>
                                  <?php echo $pj->nama; ?>
                                </option>
                              <?php endforeach; ?>
                            </select>
                          </div>

                          <!-- Filter Jenis Pegawai -->
                          <div class="col-md-3">
                            <label for="jenis_pegawai" class="form-label">Jenis Pegawai</label>
                            <select name="jenis_pegawai" id="jenis_pegawai" class="form-select">
                              <option value="">-- Semua Jenis --</option>
                              <option value="non_pns" <?php echo ($jenis_pegawai == 'non_pns') ? 'selected' : ''; ?>>Non PNS</option>
                              <option value="pppk_pw" <?php echo ($jenis_pegawai == 'pppk_pw') ? 'selected' : ''; ?>>PPPK PW</option>
                              <option value="pjlp" <?php echo ($jenis_pegawai == 'pjlp') ? 'selected' : ''; ?>>PJLP</option>
                            </select>
                          </div>

                          <!-- Tombol Submit & Reset -->
                          <div class="col-md-3">
                            <button type="submit" class="flat-btn btn-primary  px-4 py-2  fs-3">
                              <i class="fa-solid fa-filter me-1"></i> Filter
                            </button>
                            <a href="<?php echo base_url('admin/presensi'); ?>" class="flat-btn btn-light  fs-3   px-4 py-2 ">
                              Reset
                            </a>
                          </div>

                        </div>
                      </form>


                     
                   
                      <div class="row mt-4">
                        <div class="col-12 text-end">
                           
                            <a href="<?php echo base_url(); ?>admin/presensi/DataRekapAbsensi" class="flat-btn btn-success text-white fs-3 px-4 py-2 mb-3" title="rekap data absensi" target="_blank">
                              <i class="fa-solid fa-file"></i> Rekap Data</a>
                            <a href="<?php echo base_url(); ?>admin/presensi/laporan_absensi" class="flat-btn btn-success text-white fs-3 px-4 py-2 mb-3">
                              <i class="fa-solid fa-file"></i> Laporan</a>

                               <a href="<?php echo base_url(); ?>admin/presensi/importDataAbsensi" class="flat-btn btn-info fs-3 px-4 py-2 mb-3 ms-2" title="import data absensi" target="_blank" rel="noopener noreferrer">
                              <i class="fa-solid fa-download"></i> Import</a>

                        </div>
                      </div>


           

                  <div class="clearfix"></div>

                  <div class="table-responsive mt-4" style="max-height:500px">
                    <table class="table-absensi" style="width: 120%;">
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

                                <td id="pin' . $pin . '" class="text-start">
                                    ' . $flag_rekap . ' &nbsp; <a href="' . base_url() . 'admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/' . $pin . '" class="fs-2">
                                    ' . strtoupper($peg->nama) . '
                                    </a>';

                                    if(empty($dataAbsensi)){
                                      echo '<a href="' . base_url() . 'admin/presensi/update_absensi_pegawai/' . $id_pegawai . '/' . $pin . '" id="' . $pin . '" class="fs4 text-primary float-end btn-reset-absensi">
                                        <i class="fas fa-redo-alt"></i>
                                    </a>';
                                    }

                                    

                                
                                echo '</td>';

                                 $cekCuti  = '';
                          for ($i = 0; $i < count($dataAbsensi); $i++) {
                            $absn_msk = $dataAbsensi[$i]->masuk;
                            $absn_plg = $dataAbsensi[$i]->pulang;
                            $tanggal = $dataAbsensi[$i]->tanggal;
                            $shift   = $dataAbsensi[$i]->shift;

                            if ($absn_msk != '') {
                              $status_absen = 'Y';


                              if ($absn_plg != '') {
                                $status_absen = '<i class="fa-solid fa-check-double"></i>';
                                $flag = 'text-success';
                              } else {
                                $status_absen = '<i class="fa-solid fa-check"></i>';
                                $flag = 'text-warning';
                              }

                              if ($absn_msk == 'DLP') {
                                $status_absen = 'DL';
                                $flag = 'text-info-subtle text-info';
                              }

                              if ($absn_msk == 'IZIN') {
                                $status_absen = 'IZ';
                                $flag = 'text-warning-subtle text-warning';
                              }
                              if ($absn_msk == 'SAKIT') {
                                $status_absen = 'SK';
                                $flag = 'text-warning-subtle text-warning';
                              }

                              if ($absn_msk == 'CUTI') {
                                $status_absen = 'CT';
                                $flag = 'text-success-subtle text-success';

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
                                 $flag = 'text-dark fw-bold';
                                // print_array($cekCuti);
                              }
                            } else {
                              $status_absen = 'T';


                              if ($absn_plg != '') {
                                $status_absen = '<i class="fa-solid fa-check"></i>';
                                $flag = 'text-warning';
                              } else {
                                $status_absen = '<i class="fa-solid fa-question-circle"></i>';
                                $flag = 'text-danger';


                                $hariLibur = $this->Presensi_model->cekHariLibur($tanggal);
                                if (!empty($hariLibur)) {
                                  $status_absen = '<i class="fa-solid fa-calendar-times"></i>';
                                  $flag = 'text-light text-danger';
                                }


                                $day  = date('D', strtotime($tanggal));

                                if ($day == 'Sun' || $day == 'Sat') {
                                  $status_absen = '-';
                                  $flag = 'text-light text-danger';
                                }
                              }
                            } //close if $absn_msk != ''

                            if ($shift == '') {
                              $status_absen = '<i class="fa-solid fa-minus"></i>';
                              $flag = 'text-light text-danger';
                            }


                            if ($jns_jam_kerja == 'shift') {
                              $flag = 'text text-danger fs-2';
                              $status_absen = $shift;
                              if ($shift == 'SM') {
                                if ($absn_msk == '') {
                                  $flag = 'text text-danger fs-2';
                                } else {
                                  $flag = 'text-success  fs-2';
                                }
                              } else if ($shift == 'L-OFF') {
                                $status_absen = 'LO';
                                if ($absn_plg == '') {
                                  $flag = 'text text-danger  fs-2';
                                } else {
                                  $flag = 'text-success  fs-2';
                                }
                              } else if ($shift == 'P') {
                                if ($absn_msk == '') {
                                  if ($absn_plg == '') {
                                    $flag = 'text-light text-danger  fs-2';
                                  } else {
                                    $flag = 'text-warning  fs-2';
                                  }
                                } else {
                                  if ($absn_plg == '') {
                                    $flag = 'text-warning  fs-2';
                                  } else {
                                    $flag = 'text-success  fs-2';
                                  }
                                }
                              } else if ($shift == 'PSM') {
                                if ($absn_msk == '') {
                                  $flag = 'text text-danger  fs-2';
                                } else {
                                  $flag = 'text-success  fs-2';
                                }
                              }
                            }


                            echo '<td class="text-center ">
                                     <span class="' . $flag . '"> ' . $status_absen . ' </span>
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

      $('.btn-reset-absensi').on('click', function(e) {
            // e.preventDefault(); // Jangan preventDefault() agar link tetap mengarah ke href-nya

            var $link = $(this); // Ambil element <a> yang diklik
            var $icon = $link.find('i'); // Cari elemen <i> di dalamnya

            // 1. Tambahkan class 'is-loading' ke elemen <a> untuk memicu CSS kita (matikan klik)
            $link.addClass('is-loading');

            // 2. Ubah ikon asli (fa-redo-alt) menjadi spinner dan tambahkan fa-spin agar berputar
            // Kita simpan class asli di data-original agar bisa dikembalikan jika perlu (opsional)
            if (!$icon.data('original-class')) {
                $icon.data('original-class', $icon.attr('class'));
            }

            // Hapus fa-redo-alt, ganti dengan fa-spinner, dan tambahkan fa-spin
            $icon.removeClass('fa-redo-alt')
                .addClass('fa-spinner fa-spin');

            // Proses pengalihan link akan berjalan normal setelah ini (href dijalankan)
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