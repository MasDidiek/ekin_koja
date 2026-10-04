<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">


<head>
  <?php $this->load->view('master/meta'); ?>

  <style>
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    #map {
      height: 400px;
      width: 100%;
      margin: 0 auto;

    }
  </style>

  <script>
    function initMap() {
      var cilincing = {
        lat: <?php echo $pengajuan_dinas_luar[0]->lat; ?>,
        lng: <?php echo $pengajuan_dinas_luar[0]->lon; ?>
      };
      var map = new google.maps.Map(document.getElementById('map'), {
        center: cilincing,
        zoom: 15
      });



      var marker0 = new google.maps.Marker({
        position: {
          lat: <?php echo $pengajuan_dinas_luar[0]->lat; ?>,
          lng: <?php echo $pengajuan_dinas_luar[0]->lon; ?>
        },
        map: map,
        title: 'Lokasi'
      });


      marker0.addListener('click', function() {
        infowindow0.open(map, marker0);
      });


      var contentString0 = '';

      var infowindow0 = new google.maps.InfoWindow({
        content: contentString0
      });

    }
  </script>




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
    <?php
    $message    = $this->session->flashdata('message');
    $id = $pengajuan_dinas_luar[0]->id;
    $id_pegawai = $pengajuan_dinas_luar[0]->id_pegawai;
    $tgl = $pengajuan_dinas_luar[0]->tanggal;
    $create_at = $pengajuan_dinas_luar[0]->create_at;
    $jns_dl = $pengajuan_dinas_luar[0]->jns_dl;
    $photo = $pengajuan_dinas_luar[0]->photo;
    $keterangan = $pengajuan_dinas_luar[0]->keterangan;
    $latitude = $pengajuan_dinas_luar[0]->lat;
    $longitude = $pengajuan_dinas_luar[0]->lon;
    $status = $pengajuan_dinas_luar[0]->status;
    $surtug = $pengajuan_dinas_luar[0]->surtug;


    if ($jns_dl == 'DLP') {
      $dl_name = '<span class="badge  bg-primary-subtle text-primary">DL - PENUH</span>';
    } else if ($jns_dl == 'DLA') {
      $dl_name = '<span class="badge  bg-warning-subtle text-warning">DL - AWAL</span>';
    } else {
      $dl_name = '<span class="badge  bg-success-subtle text-success">DL -  AKHIR</span>';
    }

    if ($status == 0) {
      $status_dl = '<span class="text-warning"><i class="fa-solid fa-circle-exclamation"></i></span> &nbsp; Pending';
    } else if ($status == 1) {
      $status_dl = '<span class="text-success"><i class="fa-solid fa-circle-check"></i></span> &nbsp; Disetujui';
    } else {
      $status_dl = '<span  class="text-danger">Ditolak</span>';
    }

    $path   = 'uploads/surat_tugas/';
    $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
    ?>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header'); ?>

      <div class="body-wrapper">
        <div class="container-fluid">

          <?php
          if ($message) {
            echo '<div class="alert alert-success text-success mt-2">
                                ' . $message . '
                              </div>';
          }
          ?>

          <div class="row p-2">
            <div class="col-md-12 mb-4">
              <a href="<?php echo base_url(); ?>absensi/dinas_luar" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>

            <div class="col-md-8 mb-4">
              <h5 class="fw-semibold">Pengajuan Dinas Luar</h5>
              <?php echo $status_dl; ?>

            </div>

            <div class="col-md-4">
              <?php if ($status == 0) { ?>

                <button type="button" class="btn btn-success float-end  me-1" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo"><i class="fa-regular fa-square-check"></i>
                  Setujui / Tolak
                </button>
              <?php } ?>

            </div>

            <div class="col-md-12 mb-4">
              <?php
              if ($surtug == '') {
                echo '<div class="alert alert-warning text-warning mt-2">
                                                     Surat Tugas Belum diupload
                                               </div>';
              }
              ?>
            </div>



            <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
              <div class="modal-dialog " role="document">

                <div class="modal-content">
                  <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="exampleModalLabel1">
                      Pengajuan Dinas Luar
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <form action="<?php echo base_url(); ?>dashboard/approval_dinas_luar/<?php echo $id . '/' . $id_pegawai; ?>" method="post">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="mb-3">
                            <h6>Pilih aksi pengajuan Dinas Luar ?</h6>
                          </div>

                          <center>
                            <button type="submit" class="btn btn-danger font-medium" name="status" value="2">
                              Tolak
                            </button>
                            <button type="submit" class="btn btn-success" name="status" value="1">
                              Setujui
                            </button>
                          </center>
                        </div>

                      </div>
                    </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                      Close
                    </button>

                  </div>
                </div>

              </div>
            </div>


            <div class="row">
              <div class="col-lg-8 col-md-8">
                <div class="border">
                  <div class="card-body">
                    <div class="row p-3">
                      <div class="col-md-6  mb-3">
                        <span class="text-dark">Nama : </span> <br>
                        <strong><?php echo $detail_pegawai[0]->nama; ?></strong>
                      </div>

                      <div class="col-md-6 mb-3">
                        <span class="text-dark">NIP : </span> <br>
                        <strong><?php echo $detail_pegawai[0]->nip; ?></strong>
                      </div>

                      <div class="col-md-6">
                        <span class="text-dark">Jabatan : </span> <br>
                        <strong><?php echo $detail_pegawai[0]->jabatan; ?></strong>
                      </div>


                      <div class="col-md-6">
                        <span class="text-dark">Tempat Tugas : </span> <br>
                        <strong><?php echo $detail_pegawai[0]->puskesmas; ?></strong>
                      </div>



                    </div>
                  </div>
                </div>

                <div class="border mt-4">
                  <div class="card-body">
                    <h6 class="fw-semibold  border-bottom p-3 mb-2">Data Pengajuan Dinas Luar</h6>
                    <div class="row p-3">
                      <div class="col-md-4">
                        <h6 class="text-dark">Tanggal Pengajuan</h6>
                        <p><?php echo format_full($create_at); ?> &nbsp;&nbsp; <?php echo date('H:i:s', strtotime($create_at)); ?></p> <br>

                        <h6 class="text-dark">Tanggal DL</h6>
                        <p><?php echo format_full($tgl); ?></p>

                      </div>
                      <div class="col-md-8">
                        <h6 class="text-dark">Jenis DL</h6>
                        <p><?php echo $dl_name; ?></p> <br>

                        <h6 class="text-dark">Keterangan Dinas Luar</h6>
                        <p><?php echo $keterangan; ?></p>
                      </div>


                    </div>
                  </div>
                </div>

              </div>

              <div class="col-md-4 mt-4">
                <img src="<?php echo base_url(); ?>uploads/photo_dinas_luar/thumb/<?php echo $photo; ?>" width="300">

                <div id="map" class="border p-2 mt-4" style="width: 100%;"></div>
              </div>

            </div>


          </div>


          <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4ULw0TXRCvk5YaDkVBUdUwDZXLMs8opc&callback=initMap" type="text/javascript"></script>

        </div>
      </div>
    </div>

  </div>



  </div>

  </div>
  <!-- /.container -->


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
  <script src="<?php echo NEW_JS_PATH; ?>toastr-init.js"></script>


  <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>





</body>


<script>
  $(".btn-upload").click(function() {
    $(".form-upload-surtug").removeClass('d-none');
    $(this).addClass('d-none');

  });
</script>

</html>