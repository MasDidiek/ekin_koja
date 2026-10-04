<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .form-periode2 {
      display: none;
      width: 15em;
      height: 13em;
      background: #fff;
      position: absolute;
      border: 1px solid #ddd;
      border-radius: 3px;
      padding: 0;
      z-index: 999;
    }

    tr th {
      border-top: 1px solid #DDD;
      border-right: 1px solid #DDD;
    }

    tr td {
      border-right: 1px solid #DDD;
    }


    .pagination {
      float: right;
    }

    .loading-update {
      display: none;
      position: fixed;
      z-index: 989;
      top: 40%;
      width: 100%;

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
                  <h4 class="fw-semibold mb-8">Penilaian Kinerja</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Penilaian Kinerja Pegawai</li>
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
          $usergroup = $this->session->userdata('usergroup');
          $id_pj_sess = $this->session->userdata('id_pj');


          $message = $this->session->flashdata('message');
          $link = base_url() . 'admin/penilaian_kinerja/';


          echo $message;

          #print_array($this->session->userdata);


          $periode_tahun     = $this->session->userdata('periode_tahun');
          $periode_bulan     = $this->session->userdata('periode_bulan');
          if ($periode_bulan == '') {
            $bulan = date('m');
            $tahun = date('Y');
          } else {
            $bulan = $periode_bulan;
            $tahun = $periode_tahun;
          }

          $day        = date('d');
          $month = $bulan;
          $year = $tahun;

          $nm_bulan = getBulan($bulan);

          $bulanNow = date('m');
          $now = date('Y-m-d');


          $periode = $tahun . '-' . $bulan;
          $periode = date('Y-m', strtotime($periode));

          $tgl_dari = $year . '-' . $month . '-01';



          if ($month < $bulanNow) {
            $day = date('t', strtotime($tgl_dari));
            // $tgl_sampai = $year.'-'.$month.'-'.$day;
          }

          $tgl_sampai = $year . '-' . $month . '-' . $day;

          $listBulan = array_bulan();
          ?>





          <div class="loading-update">
            <div class="card">
              <div class="card-body">
                <img src="<?php echo base_url(); ?>assets/images/loading_baru.gif" width="60"> Loading...
              </div>


            </div>
          </div>

          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <label for="bulan">Periode</label>
                  <input type="text" readonly class="periode" style="width: 150px;" name="periode" id="periode" value="<?php echo $nm_bulan . ' &nbsp; &nbsp; ' . $tahun; ?>">

                  <div class="form-periode2">
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
                </div>

                <?php if ($usergroup < 3) { ?>

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
                <?php } ?>


                <div class="row">


                  <div class="table-responsive mt-4">
                    <a href="<?php echo base_url(); ?>admin/penilaian_kinerja/updateRekapInput" class="btn btn-primary float-end mb-2 update-btn">Update Data</a>




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
  $("#light-layout").click(function() {
    $.ajax({
      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>dashboard/change_theme",
      data: "theme=light",
      success: function(msg) {

        setTimeout(function() {
          window.location.reload(1);
        }, 3000);
        //$("#aktifitasPegawai"+id).fadeOut(1000);

      }

    });

  });


  $("#dark-layout").click(function() {
    $.ajax({
      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>dashboard/change_theme",
      data: "theme=dark",
      success: function(msg) {

        setTimeout(function() {
          window.location.reload(1);
        }, 3000);
        //$("#aktifitasPegawai"+id).fadeOut(1000);

      }

    });

  });



  $('#list-table').dataTable({
    lengthMenu: [
      [20, -1],
      ['20', '50', '100', 'Show all']
    ]
  });
</script>

</html>