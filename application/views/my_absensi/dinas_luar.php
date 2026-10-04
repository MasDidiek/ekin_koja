<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>


  <style>
    .datepicker {
      z-index: 1999;
    }

    .table-medium td {
      padding: 8px;
      color: #666;
    }

    .loading {
      width: 100%;
      height: 300px;
      margin: 0 auto;
      text-align: center;
      background: rgba(255, 255, 255, 0.8);
      position: fixed;
      z-index: 999;
      font-size: 20px;
      color: #134fc4;

    }

    .file-upload {
      position: relative;
      display: inline-block;
      overflow: hidden;
    }

    .file-upload input[type='file'] {
      position: absolute;
      font-size: 100px;
      opacity: 0;
      right: 0;
      top: 0;
    }

    .file-upload-button {
      border: 2px solid #ccc;
      color: #333;
      background-color: #fff;
      padding: 10px 20px;
      cursor: pointer;
    }

    .file-upload-name {
      margin-left: 10px;
      font-family: Arial, sans-serif;
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
                  <h4 class="fw-semibold mb-8">Dinas Luar</h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive">Dinas Luar</li>
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
          $message    = $this->session->flashdata('message');
          $tanggal_dl = $this->session->userdata('tanggal');
          $jns_dl     = $this->session->userdata('jns_dl');
          $keterangan_sess = $this->session->userdata('keterangan');

          if ($tanggal_dl == '') {
            $tanggal_dl = date('d-m-Y');
          }
          echo $message
          ?>


          <div class="row">

            <div class="col-lg-12 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body p-4">
                  <h5 class="card-title fw-semibold mb-4">Dinas Luar</h5>

                  <button type="button" class="btn btn-primary waves-effect float-end ml-2" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo">
                    <i class="ti ti-plus"></i> Pengajuan Dinas Luar
                  </button>


                  <div class="clearfix"></div>


                  <div class="table-responsive mt-4">
                    <table class="table  " id="data-table">
                      <thead>
                        <tr>
                          <th class="w-1">No.</th>

                          <th>Tanggal</th>
                          <th>Jenis Dinas Luar</th>
                          <th>Keterangan</th>
                          <th>Status</th>
                          <th>Surat Tugas</th>
                          <th>Action </th>

                        </tr>
                      </thead>
                      <tbody>

                        <?php

                        $path   = 'uploads/surat_tugas/';
                        $no = 1;
                        foreach ($pengajuan_dinas_luar as $dl) {

                          $id_pegawai = $dl->id_pegawai;
                          $id = $dl->id;
                          $jns_dl = $dl->jns_dl;
                          $tanggal = $dl->tanggal;
                          $keterangan = $dl->keterangan;
                          $status = $dl->status;
                          $surtug = $dl->surtug;
                          $photo = $dl->photo;

                          if ($jns_dl == 'DLP') {
                            $dl_name = '<span class="badge  bg-primary-subtle text-primary">DL - PENUH</span>';
                          } else if ($jns_dl == 'DLA') {
                            $dl_name = '<span class="badge  bg-warning-subtle text-warning">DL - AWAL</span>';
                          } else {
                            $dl_name = '<span class="badge  bg-success-subtle text-success">DL -  AKHIR</span>';
                          }

                          if ($status == 0) {
                            $flag = '<span class="badge bg-warning fs-1">Belum diperiksa</span>';
                          } else if ($status == 1) {
                            $flag = '<span class="badge bg-success">Valid</span>';
                          } else {
                            $flag = '<span class="badge bg-danger">Tidak Valid</span>';
                          }


                          if ($surtug == '') {
                            $flag_surtug = '<span class="text-danger fs-2"> <i class="fas fa-times"></i> belum upload</span>';
                          } else {
                            $flag_surtug = '  <a href="' . base_url() . $path . '/' . $surtug . '" class="btn btn-sm bg-info-subtle text-info" title="Unduh file" target="_blank""  class="btn btn-sm btn-info">
                                      <i class="fas fa-file-pdf"></i> Lihat
                                </a>';
                          }
                          echo ' <tr>
                                                              <td>' . $no . ' </td>
                                                          
                                                              <td class="text-center">' . format_semi($tanggal) . '</td>
                                                              <td class="text-center"> ' . $dl_name . '</td>
                                                              <td>' . $keterangan . ' </td>
                                                              <td class="text-center">' . $flag . ' </td>
                                                              <td class="text-center">' . $flag_surtug . ' </td>
                                                              <td class="text-center">
                                                                  <a href="' . base_url() . 'absensi/detail_pengajuan_dl/' . $id . '" class="btn btn-sm bg-info-subtle text-info" title="Unduh file" target="_blank""  class="btn btn-sm btn-info">
                                                                         Lihat Detail
                                                                  </a>';

                          if ($status == 0) {
                            echo '
                                                                      <a href="' . base_url() . 'absensi/delete_pengajuan_dl/' . $id . '/' . $surtug . '" class="btn btn-sm bg-danger-subtle text-danger" onClick="return confirm(\'Apakah anda yakin menghapus pengajuan Dinas luar ini\');">
                                                                      <i class="fas fa-trash"></i> Hapus
                                                                      </a> ';
                          } else {
                            echo '
                                                                      <a href="#" class="btn btn-sm bg-light-subtle btn-disabled">
                                                                      <i class="fas fa-trash"></i> Hapus
                                                                      </a> ';
                          }

                          echo ' </td>
                                                          
                                                              
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


          <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
              <form action="<?php echo base_url(); ?>absensi/insertPengajuanDinasLuar" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                <div class="modal-content">
                  <div class="modal-header d-flex align-items-center">
                    <h4 class="modal-title" id="exampleModalLabel1">
                      Pengajuan Dinas Luar
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="recipient-name" class="control-label">Tanggal:</label>
                          <input type="text" required name="tanggal" autocomplete="off" class="form-control" value="<?php echo  $tanggal_dl; ?>" id="dpd1">
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label for="recipient-name" class="control-label">Jenis DL:</label>
                          <select name="jns_dl" id="jns_dl" class="form-control">
                            <option value="DLP">DINAS LUAR - PENUH</option>
                            <option value="DLA">DINAS LUAR - AWAL</option>
                            <option value="DLAK">DINAS LUAR - AKHIR</option>
                          </select>
                        </div>
                      </div>
                    </div>



                    <div class="mb-3">
                      <label for="message-text" class="control-label">Keterangan:</label>
                      <textarea class="form-control" name="keterangan" required id="message-text1"><?php echo $keterangan_sess; ?></textarea>
                    </div>
                    <div class="mb-3">
                      <div class="card w-100 bg-info-subtle overflow-hidden p-2 shadow-none">
                        <h6>Photo :</h6>

                        <br>
                        <div class="file-upload">
                          <button type="button" class="file-upload-button">Open Camera</button>
                          <input type="file" accept="image/*" capture="camera" id="cameraInput" name="cameraInput">
                          <span class="file-upload-name">No file chosen</span>
                        </div>
                        <img id="preview" src="#" alt="Image preview" style="display: none; max-width: 300px;">
                        <br><br>
                        <input type="hidden" id="latitude" name="latitude">
                        <input type="hidden" id="longitude" name="longitude">

                      </div>
                    </div>

                    <div class="loading-upload float-end d-none">
                      <div class="spinner-border text-primary " role="status">
                        <span class="visually-hidden">Loading...</span>

                      </div>

                      Sedang Menyimpan....
                    </div>



                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                      Close
                    </button>
                    <button type="submit" class="btn btn-success">
                      Kirim Pengajuan
                    </button>
                  </div>
                </div>

              </form>
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




</body>


<script>
  function move() {
    var elem = document.getElementById("myBar");
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




  $(document).ready(function() {


    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
    //1700931600000
    //1703264400000

    var checkin = $('#dpd1').datepicker({
      onRender: function(date) {
        return '';
      }
    }).on('changeDate', function(ev) {
      $('.datepicker').hide();
    });



    $(".btn-success").click(function() {
      $(".loading-upload").removeClass("d-none");
    });

  });
  // Success Type
  //  $("#ts-success").on("click", function () {
  //     toastr.success("Have fun storming the castle!", "Miracle Max Says");
  // });

  document.getElementById('cameraInput').addEventListener('change', function(event) {
    var file = event.target.files[0];
    if (file) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview').src = e.target.result;
        document.getElementById('preview').style.display = 'block';
      }
      reader.readAsDataURL(file);
    }
  });

  // Mendapatkan lokasi pengguna
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      document.getElementById('latitude').value = position.coords.latitude;
      document.getElementById('longitude').value = position.coords.longitude;
    }, function(error) {
      console.error('Error getting location:', error);
    });
  } else {
    console.error('Geolocation is not supported by this browser.');
  }
</script>

</html>