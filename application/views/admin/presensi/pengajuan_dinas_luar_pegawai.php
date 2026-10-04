<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>

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
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Pengajuan Dinas Luar</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="<?php echo base_url(); ?>dashboard/index"> Dashboard </a> / Pengajuan Dinas Luar
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
            </div>
          </div>
          <?php

          $periode_bulan = $this->session->userdata('periode_bulan');
          $periode_tahun = $this->session->userdata('periode_tahun');
          $id_pkm_sess   = $this->session->userdata('id_pkm');
          $id_pj_sess = $this->session->userdata('id_pj');
          $id_user_validator   = $this->session->userdata('id_pegawai');
          $message = $this->session->flashdata('message');


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


          $listBulan = array_bulan();

          $lastDateMonth = date('t', strtotime($periode));



          ?>
          <!-- <ul class="nav-links">
               <li><a href="#">Dashboard</a></li>
               <li class="center"><a href="#">Portfolio</a></li>
               <li class="upward"><a href="#">Services</a></li>
               <li class="forward"><a href="#">Feedback</a></li>
             </ul> -->




          <div class="row">
            <!-- Column -->
            <div class="col-lg-12 col-md-12">

              <?php
              if ($message) {
                echo '<div class="alert alert-success text-success mt-2">
                                ' . $message . '
                              </div>';
              }
              ?>
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-2">
                      <label for="bulan">Periode</label><br>
                      <input type="text" readonly class="periode" name="periode" id="periode" value="<?php echo $nm_bulan . ' &nbsp; &nbsp; ' . $tahun; ?>">
                    </div>
                    <div class="col-md-8">

                      <ul class="nav-links">
                        <?php
                        $li_active = $this->uri->segment(3);

                        $flag_status_dl = array('Semua', 'Pending', 'Disetujui', 'Ditolak');
                        for ($i = 0; $i < 4; $i++) {
                          if ($li_active == $flag_status_dl[$i]) {
                            echo '  <li class="active"><a href="' . base_url() . 'dashboard/pengajuan_dinas_luar_pegawai/' . $flag_status_dl[$i] . '">' . $flag_status_dl[$i] . '</a></li>';
                          } else {
                            echo '  <li><a href="' . base_url() . 'dashboard/pengajuan_dinas_luar_pegawai/' . $flag_status_dl[$i] . '">' . $flag_status_dl[$i] . '</a></li>';
                          }
                        }
                        ?>

                      </ul>
                    </div>
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



                  <div class="table-responsive mt-4">
                    <table class="table  table-hover " id="data-table">
                      <thead>
                        <tr>
                          <th class="bg-light">No.</th>
                          <th class="bg-light">Tanggal</th>
                          <th class="bg-light">Jenis Dinas Luar</th>
                          <th class="bg-light">Nama </th>
                          <th class="bg-light">Keterangan</th>
                          <th class="bg-light">Status</th>
                          <th class="bg-light">Action</th>

                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $no = 1;
                        foreach ($pengajuanDL as $peg) {

                          $id_pegawai = $peg->id_pegawai;
                          $id = $peg->id;
                          $tanggal = $peg->tanggal;
                          $jns_dl = $peg->jns_dl;
                          $surtug = $peg->surtug;

                          $keterangan = $peg->keterangan;
                          $status = $peg->status;
                          $nama = $peg->nama;

                          if ($jns_dl == 'DLAK') {
                            $dl = 'Dinas Luar Akhir';
                          } else if ($jns_dl == 'DLP') {
                            $dl = 'Dinas Luar Awal';
                          } else {
                            $dl = 'Dinas Luar Penuh';
                          }

                          if ($status == 0) {
                            $status_dl = '<span class="text-warning"><i class="fa-solid fa-circle-exclamation"></i></span> &nbsp; Pending';
                          } else if ($status == 1) {
                            $status_dl = '<span class="text-success"><i class="fa-solid fa-circle-check"></i></span> &nbsp; Disetujui';
                          } else {
                            $status_dl = '<span  class="text-danger">Ditolak</span>';
                          }

                          echo '<tr>
                                                                <td>' . $no . '</td>
                                                                <td>  <a href="' . base_url() . 'dashboard/detail_pengajuan_dl/' . $id . '/' . $id_pegawai . '" class="fw-semibold">' . format_semi($tanggal) . '</a></td>
                                                                <td>' . $dl . '</td>
                                                                <td>
                                                                <a href="' . base_url() . 'admin/presensi/lihat_absensi_pegawai/' . $id_pegawai . '/0">' . $nama . '</a></td>
                                                                <td>' . word_limiter($keterangan, 5) . '</td>
                                                                <td>' . $status_dl . '</td>
                                                                <td width="60">
                                                                    <a href="' . base_url() . 'dashboard/detail_pengajuan_dl/' . $id . '/' . $id_pegawai . '" class="btn btn-xs btn-info">Lihat</a>
                                                                
                                                                 </td>
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
            <!-- Column -->

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
</script>

</html>