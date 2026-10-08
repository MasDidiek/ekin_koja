<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/addon.css" media="screen">

  <style>
    .shift-off {
      background: #f53b54;
      color: #FFF;
      font-weight: 100;
    }

    .shift-loff {
      background: #f5b03b;
      color: #FFF;
      font-weight: 100;
    }

    .btn-close {
      float: right;
      cursor: pointer;
    }

    .alert .close-btn {
      position: absolute;
      top: 10px;
      right: 15px;
      color: #aaa;
      font-size: 20px;
      font-weight: bold;
      cursor: pointer;
    }

    .alert .close-btn:hover {
      color: #000;
    }

    #div_change_shift {
      width: 400px;
      height: auto;
      background: #FFF;
      position: fixed;
      top: 18%;
      right: 400px;
      box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
      -webkit-box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
      -moz-box-shadow: 3px -3px 23px 0px rgba(167, 161, 161, 0.75);
      display: none;
      padding: 20px;
      z-index: 99;
    }

    .col-name {
      left: 0;
      position: sticky;
    }

    .pilih-shift {
      border: 1px solid #DDD;
      padding: 5px 10px;
      font-size: 12px;
      color: #FFF;
      margin: 3px;
      width: 80px;
    }

    .shift-on {
      background: #FFF;
      color: #097d42;
    }

    .shift-on:hover {
      background: #bef4e6;
      color: #097d42;
    }

    .jam-kerja {
      font-size: 11px;
      color: #d87829;
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


      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8">Shift Kerja Pegawai</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Shift Kerja Pegawai UGD-RB</li>
                    </ol>
                  </nav>
                </div>
                <div class="col-3">

                </div>
              </div>
            </div>


          </div>
        </div>

        <?php
        $message = $this->session->flashdata('success');

        // $periode = date('Y-m');
        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');

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

        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">

                <?php if ($message != '') { ?>
                  <div class="alert alert-success">
                    <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Success! </strong> <?php echo  $message; ?>
                  </div>
                <?php }  ?>

                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            Tambah Depertamen /  Bagian
                            </button> -->

                


                </div><!--row-->

                <div class="table-responsive mt-4">
                  <table class="table table-bordered table-hover ">
                    <thead>
                      <tr>
                        <th class="text-center">No</th>
                        <th class="text-center">Tahun</th>
                        <th class="text-center">Bulan</th>
                        <th class="text-center">Nama Shift</th>
                        <th class="text-center">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $no = 1;
                       foreach ($shift_kerja as $row) {
                        echo '<tr>
                                <td class="text-center">' . $no++ . '</td>
                                <td class="text-center">' . $row->tahun . '</td>
                                <td class="text-center">' . getBulan($row->bulan) . '</td>
                                <td class="text-center">' . $row->nama_template . '</td>
                                <td class="text-center">
                                  <a href="' . base_url('admin_jadwal_shift/detail_shift_template/' . $row->id) . '" class="btn btn-sm btn-primary">Detail</a>
                                  <button class="btn btn-sm btn-success btn-change-shift"  data-id="' . $row->id . '"  data-bs-toggle="modal" data-bs-target="#modalEdit">Ubah</button>
                                </td>';
                        echo '</tr>';

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


</body>
<script type="text/javascript">
  
</script>

</html>
