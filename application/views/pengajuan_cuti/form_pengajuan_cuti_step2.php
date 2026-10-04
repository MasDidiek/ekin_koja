<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    #list_pegawai {
      max-height: 200px;
      overflow: auto;
    }

    .choose_pegawai {
      padding: 5px;
      cursor: pointer;
    }

    .choose_pegawai:hover {
      color: darkorange;


    }

    .form-cuti {
      border: none;
      border-bottom: 1px solid #EEE;
      padding: 5px 0;
      width: 100%;
    }

    .form-cuti:focus {
      outline: none;
    }


    .preview {
      display: inline-block;
      margin: 10px;
    }

    .preview img {
      width: 200px;
      height: 200px;
      margin-right: 10px;
    }

    .delete {
      border: 1px solid #f07878;
      background-color: #f07878;
      padding: 5px 10px;
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
                  <h4 class="fw-semibold mb-8">Pengajuan Pegawai</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="<?php echo base_url(); ?>dashboard/index">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Pengajuan Cuti</li>
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

          //print_array($this->session->userdata);
          $id_pegawai = $this->session->userdata('id_pegawai');
          $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 1);
          $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
          $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);

          $date_from        =  $this->session->userdata('date_from');
          $date_to          =  $this->session->userdata('date_to');
          $jns_cuti         =  $this->session->userdata('jns_cuti');
          $jns_hak_cuti     =  $this->session->userdata('jns_hak_cuti');
          $jml_hari_cuti    =  $this->session->userdata('jml_hari_cuti');
          $list_hari_cuti   =  $this->session->userdata('list_hari_cuti');


          $nama_pengganti     =  $this->session->userdata('nama_pengganti');
          $alasan_cuti    =  $this->session->userdata('alasan_cuti');
          $alamat   =  $this->session->userdata('alamat');
          $tlp   =  $this->session->userdata('tlp');

          $id_pegawai_pengganti   =  $this->session->userdata('id_pengganti');

          $tugas1     =  $this->session->userdata('tugas1');
          $tugas2     =  $this->session->userdata('tugas2');
          $tugas3     =  $this->session->userdata('tugas3');
          $tugas4     =  $this->session->userdata('tugas4');


          if ($date_from == '') {
            redirect('cuti/buat_pengajuan_cuti');
          }

          $div_upload_file = 'd-none';

          if ($jns_cuti == 1) {
            $jenis_cuti = 'Tahunan';
          } else if ($jns_cuti == 2) {
            $jenis_cuti = 'Bersalin';
            $div_upload_file = '';
          } else if ($jns_cuti == 3) {
            $jenis_cuti = 'Alasan Penting ';
            $div_upload_file = '';
          } else if ($jns_cuti == 4) {
            $jenis_cuti = 'Sakit';
            $div_upload_file = '';
          } else {
            $jenis_cuti = 'Besar';
          }


          $message = $this->session->flashdata('message');
          echo $message;

          ?>


          <div class="row">

            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <h5 class="card-title fw-semibold mb-4">Pengajuan Cuti Pegawai </h5>
                  <form method="post" action="<?php echo base_url(); ?>cuti/insertPengajuanCuti" enctype="multipart/form-data" id="submit_form">

                    <div class="row">
                      <div class="col-md-4">
                        <table class="table">
                          <tr>
                            <td width="50"><i class="fa-regular fa-clipboard fs-8 text-muted"></i>
                            </td>
                            <td> <span class="text-muted"> Jenis Cuti </span><br>
                              Cuti <?php echo $jenis_cuti; ?>
                            </td>

                          </tr>
                          <tr>
                            <td width="50"><i class="ti ti-calendar fs-8 text-muted"></i></td>
                            <td><span class="text-muted">Tanggal Cuti </span><br>
                              <?php echo format_full($date_from); ?> &nbsp; - &nbsp; <?php echo format_full($date_to);; ?>
                            </td>

                          </tr>
                          <tr>
                            <td width="50"><i class="ti ti-clock fs-8 text-muted"></i></td>
                            <td><span class="text-muted">Lama Cuti </span><br>
                              <?php echo $jml_hari_cuti; ?> &nbsp;Hari
                            </td>

                          </tr>
                          <tr>
                            <td width="50"><i class="ti ti-id-badge fs-8 text-muted"></i> </td>
                            <td><span class="text-muted">Pengganti Cuti </span><br>

                              <span id="nama_pengganti_cuti"><?php echo $nama_pengganti; ?></span>
                              <?php
                              if ($nama_pengganti == '') {
                                $showDiv = '';
                                $showDivCancel = 'd-none';
                              } else {
                                $showDiv = 'd-none';
                                $showDivCancel = '';
                              }
                              ?>

                              <button type="button" class="text-warning btn-search btn mt-2 <?php echo  $showDiv; ?>" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo"><i class="fa-solid fa-magnifying-glass"></i> &nbsp; Cari Pegawai Pengganti</button>
                              <br>
                              <a href="#" class="cancel-pengganti text-danger <?php echo $showDivCancel; ?> m-2 btn btn-sm border border-danger">
                                <i class="fa-regular fa-circle-xmark"></i> &nbsp; Ganti pengganti cuti
                              </a>

                            </td>

                            <input type="hidden" name="nama_pengganti" value="<?php echo $nama_pengganti; ?>" id="nama_pengganti">
                            <input type="hidden" name="id_pengganti" value="<?php echo $id_pegawai_pengganti; ?>" id="id_pengganti">

                          </tr>

                          <tr>
                            <td width="50"><i class="fa-solid fa-circle-info fs-7 text-muted"></i></td>
                            <td><span class="text-muted">Alasan Cuti </span><br>
                              <input type="text" id="alasan_cuti" name="alasan_cuti" placeholder="tuliskan alasan cuti" class="form-cuti mt-1" min="10" value="<?php echo  $alasan_cuti; ?>" required autocomplete="off">
                            </td>

                          </tr>

                          <tr>
                            <td width="50"><fs-8 class="fa-solid fa-phone fs-7 text-muted"></i></td>
                            <td><span class="text-muted">No Telepon yang dapat dihubungi</span><br>
                              <input type="text" id="tlp" name="tlp" class="form-cuti mt-1" min="10" placeholder="08xxxx" value="<?php echo  $tlp; ?>" required autocomplete="off">
                            </td>

                          </tr>

                          <tr>
                            <td width="50"><i class="fa-solid fa-location-dot fs-7 text-muted"></i>
                            </td>
                            <td><span class="text-muted">Alamat Selama cuti</span><br>

                              <textarea name="alamat" class="form-cuti mt-1" min="10"><?php echo  $alamat; ?></textarea>
                            </td>

                          </tr>
                        </table>
                      </div>

                      <div class="col-md-6 border p-4">
                        <div class="upluad_file_pelengkap <?php echo $div_upload_file; ?>">
                          <h5>File / Photo Kelengkapan</h5> <br>
                          <div class="alert alert-warning text-dark">
                            Untuk pengajuan cuti bersalin / cuti alasan penting wajib melampirkan photo / gambar USG, surat keterangan kehamilan atau gambar pendukung lain
                            <br> <br>
                            <p>Hanya dapat menerima file dalam format <strong>Gambar / photo (JPG, PNG, JPEG) </strong> </p>
                            Dimensi maksimal gambar : <strong>5000px &nbsp; x &nbsp; 5000px </strong><br>
                            Ukuran maksimal gambar : <strong>5 Mb </strong><br>

                          </div>

                          <input type="file" name="files[]" id="file-input" multiple>
                          <div id="preview-container"></div>
                        </div>

                        <br><br>
                        <h5>Form Delegasi Tugas</h5>
                        <br>
                        <label>Tugas 1 <span class="text-danger">*</span>:</label><br>
                        <div class="form-input mb-2">
                          <input type="text" name="tugas1" value="<?php echo $tugas1; ?>" class="form-cuti" required>

                        </div>
                        <label>Tugas 2 <span class="text-danger">*</span>:</label><br>
                        <div class="form-input mb-2">
                          <input type="text" name="tugas2" value="<?php echo $tugas2; ?>" class="form-cuti" required>

                        </div>
                        <label>Tugas 3 <span class="text-danger">*</span>:</label><br>
                        <div class="form-input mb-2">
                          <input type="text" name="tugas3" value="<?php echo $tugas3; ?>" class="form-cuti" required>

                        </div>
                        <label>Tugas 4 :</label><br>
                        <div class="form-input">
                          <input type="text" name="tugas4" value="<?php echo $tugas4; ?>" class="form-cuti">

                        </div>




                        <button type="submit" class="btn btn-info float-end mt-4 ms-2" id="submit_pengajuan">Kirim Pengajuan Cuti</button>
                        <a href="<?php echo base_url(); ?>cuti/buat_pengajuan_cuti" class="btn btn-danger float-end mt-4">Kembali</a>

                      </div>
                    </div>


                  </form>
                </div>
              </div>
            </div>
          </div>


          <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">

              <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                  <h4 class="modal-title" id="exampleModalLabel1">
                    Cari Nama pegawai Pengganti cuti
                  </h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                  <div class="row">
                    <div class="form-input">
                      <input type="text" id="search_pegawai" name="nama_pengganti" placeholder="cari nama pegawai" class="form-control" required autocomplete="off">
                      <div id="list_pegawai"></div>
                    </div>
                    <input type="hidden" name="id_pegawai_pengganti" id="id_pegawai_choose" value="">
                  </div>


                </div>
                <div class="modal-footer">

                  <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                    Close
                  </button>
                  <button type="button" class="btn btn-success simpan_pengganti" data-bs-dismiss="modal">
                    OK
                  </button>

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


</body>


<script>
  $("#search_pegawai").html("");

  var search_result = $("#search_pegawai").val();
  if (search_result == '') {
    $(".btn-success").addClass('d-none');
  } else {
    $(".btn-success").removeClass('d-none');
  }

  $("#search_pegawai").keydown(function() {
    var keyword = $(this).val();
    $("#list_pegawai").show();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>cuti/search_pegawai",
      data: "keyword=" + keyword,
      success: function(return_data) {
        $("#list_pegawai").html(return_data);
      }
    });

  });


  $(".simpan_pengganti").click(function() {
    var id_pengganti = $("#id_pegawai_choose").val();
    var nama_pengganti = $("#search_pegawai").val();

    $(".btn-search").hide();
    $("#nama_pengganti").val(nama_pengganti);
    $("#nama_pengganti_cuti").html(nama_pengganti);
    $("#id_pengganti").val(id_pengganti);
    $("#search_pegawai").val("");
    $(".cancel-pengganti").removeClass('d-none');

  });

  $(".cancel-pengganti").click(function() {


    $(".btn-search").removeClass('d-none');
    $("#nama_pengganti_cuti").html("");
    $(".btn-success").addClass('d-none');
    $("#id_pegawai_choose").val("");

    $(".cancel-pengganti").addClass('d-none');

  });

  $("#submit_pengajuan").click(function() {


    var pengganti_cuti = $("#nama_pengganti").val();
    if (pengganti_cuti == '') {
      alert("pengganti cuti belum di pilih");
      $("#search_pegawai").val("");
      $(".btn-search").trigger("click");
      return false;
    }



  });

  $("#file-input").on("change", function() {
    var files = $(this)[0].files;
    $("#preview-container").empty();
    if (files.length > 0) {
      for (var i = 0; i < files.length; i++) {
        var reader = new FileReader();
        reader.onload = function(e) {
          $("<div class='preview'><img src='" + e.target.result + "'><button class='delete'>Delete</button></div>").appendTo("#preview-container");
        };
        reader.readAsDataURL(files[i]);
      }
    }
  });
  $("#preview-container").on("click", ".delete", function() {
    $(this).parent(".preview").remove();
    $("#file-input").val(""); // Clear input value if needed
  });
</script>

</html>