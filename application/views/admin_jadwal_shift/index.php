<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
  <style>
    #list_pegawai,
    #list_pegawai_cart {
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

    .cart-list {
      border: 1px solid #c6edd3;
      padding: 5px 10px;
      background: #f4fff7;
      font-size: 13px;
      margin-bottom: 5px;
      border-radius: 5px;
      color: #249147;
      width: auto;
      display: inline-block;
    }

    .cart-list .remove-cart {
      top: 10px;
      margin-left: 15px;
      color: #aaa;
      font-size: 20px;
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

    .add_pegawai {
      border: 1px solid #DDD;
      padding: 5px 10px;
      background: #F8F8F8;
      font-size: 12px;
      color: #444;
    }


    .add_pegawai:hover {
      border: 1px solid #CCC;
      background: #EEE;
      color: #333;
    }

    .remove-pegawai {
      cursor: pointer;
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

                      <li class="breadcrumb-acive">Shift Kerja Pegawai UGD-RB - FARMASI</li>
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
        ?>

        <div class="row">

          <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
              <div class="card-body p-4">

                <?php if ($message != '') { ?>
                  <div class="alert alert-success">
                    <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <strong>Success! </strong> <?php echo    $message; ?>
                  </div>
                <?php }  ?>

                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                  Tambah Depertamen / Bagian
                </button>
                <a href="<?php echo base_url(); ?>admin_jadwal_shift/shift_regular" class="btn btn-success">Shift Reguler</a>
                <a href="<?php echo base_url(); ?>admin_jadwal_shift/shift_pjlp" class="btn btn-info">Shift PJLP</a>

                <div class="table-responsive mt-4">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                        <th width="100">No</th>
                        <th>Nama Bagian</th>
                        <th>Nama Pj</th>
                        <th>List Pegawai</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php


                      $no = 1;
                      foreach ($bagian as $list) {
                        $id_bagian = $list->id_bagian;
                        $nama = $list->nama_bagian;
                        $nama_pj_bagian = $list->nama_pj_bagian;

                        $list_pegawai = $this->Pegawai_model->getPegawaiPerbagian($id_bagian);


                        echo ' <tr>
                                                                    <td>' . $no . '</td>
                                                                      <td>
                                                                        <a href="' . base_url() . 'admin_jadwal_shift/shift_kerja/' . $id_bagian . '" class="link-primary">
                                                                        ' . $nama . '
                                                                        </a>
                                                                        <td>' . $nama_pj_bagian . '</td>
                                                                        <td>
                                                                            <ul>';

                        for ($i = 0; $i < count($list_pegawai); $i++) {
                          echo '<li class="pegawai-list">' . $list_pegawai[$i]->nama . ' 
                                                                              <a href="' . base_url() . 'admin_jadwal_shift/delete_from_list/' . $list_pegawai[$i]->id_pegawai . '" class="remove-pegawai">  <i class="ti ti-trash"></i> </a> </li> ';
                        }

                        echo '
                                                                            </ul>
                                                                            <button type="button" class="add_pegawai float-end" data-nama_bagian="' . $nama . '" data-id_bagian="' . $id_bagian . '"  data-bs-toggle="modal" data-bs-target="#modalInputPegawai">
                                                                                Tambahkan
                                                                            </button>
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" class="btn btn-primary btn-sm edit" value="' . $id_bagian . '" data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                                              Ubah
                                                                          </button>
                                                                          <a href="' . base_url() . 'admin_jadwal_shift/delete/' . $id_bagian . '" class="btn  btn-sm btn-danger delete" onClick="return confirm(\'Apakah anda yakin untuk menghapus data bagian ini ? Menghapus data ini akan menghapus data yang ada didalamnya juga\')">Hapus </a>
                                                                        </td>
                                                                      </td>
                                                                  </tr>';
                        $no += 1;
                      }

                      ?>
                    </tbody>
                  </table>
                </div>


                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Tambah Depertamen / Bagian </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <label for="bagian">Nama Bagian <span class="text-danger">*</span>:</label></label>
                        <input type="text" name="nama_bagian" id="nama_bagian" class="form-control"> <br>

                        <label>Penanggung Jawab <span class="text-danger">*</span>:</label><br>
                        <div class="form-input">
                          <input type="text" id="search_pegawai" name="nama_pj" placeholder="cari nama pegawai" class="form-control" required autocomplete="off">
                          <div id="list_pegawai"></div>
                        </div>

                        <input type="hidden" name="id_pj" id="id_pj_choose" value="">
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success simpan-data">Simpan</button>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content" id="content_edit">

                    </div>
                  </div>
                </div>



                <div class="modal fade" id="modalInputPegawai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Tambah Pegawai </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        <div class="row">
                          <div class="col-md-4">
                            <label for="bagian">Nama Bagian </label>
                            <input type="text" name="nama_bagian" readonly id="nama_bagian_readonly" class="form-control"> <br>
                          </div>
                          <input type="hidden" name="id_bagian" id="id_bagian">
                          <div class="col-12">
                            <!-- Input Pencarian -->
                            <div class="mb-3">
                              <label for="search-input" class="form-label">Cari Nama / NIP Pegawai</label>
                              <input type="text" id="search-input" class="form-control" placeholder="Ketik nama agung atau NIP...">
                            </div>

                            <!-- Tabel Dinamis -->
                            <table class="table table-bordered table-striped">
                              <thead>
                                <tr>
                                  <th>Nama Pegawai</th>
                                  <th>NIP</th>
                                  <th>Jabatan</th>
                                  <th>Aksi</th>
                                </tr>
                              </thead>
                              <tbody id="tabel-pegawai">
                                <!-- Data akan otomatis diisi oleh AJAX -->
                              </tbody>
                            </table>

                          </div>
                        </div>


                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <!-- <button type="button" class="btn btn-success">Simpan</button> -->
                        <!-- <div id="btn-simpan"></div> -->
                      </div>
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
<script type="text/javascript">
  $(".simpan-data").click(function() {
    var nama_bagian = $("#nama_bagian").val();
    var nama_pj = $("#search_pegawai").val();
    var id_pj = $("#id_pj_choose").val();

    $.ajax({

      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>admin_jadwal_shift/create_bagian",
      data: "nama_bagian=" + nama_bagian + "&nama_pj=" + nama_pj + "&id_pj=" + id_pj,
      success: function(msg) {
        window.location.reload();
        //$("#modal-form").html(msg);
        //console.log(msg);
      }

    });

  });



  // $("#search_pegawai_cart").keydown(function() {
  //   var keyword = $(this).val();
  //   var bagian = $("#nama_bagian_readonly").val();
  //   $("#list_pegawai_cart").show();
  //   $.ajax({
  //     type: "POST",
  //     url: "<?php echo base_url(); ?>admin_jadwal_shift/search_pegawai_cart",
  //     data: {
  //       keyword: keyword,
  //       bagian: bagian
  //     },
  //     success: function(return_data) {
  //       $("#list_pegawai_cart").html(return_data);
  //     }
  //   });
  // });


  $("#search_pegawai").keydown(function() {
    var keyword = $(this).val();
    $("#list_pegawai").show();
    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>admin_jadwal_shift/search_pegawai",
      data: "keyword=" + keyword,
      success: function(return_data) {
        $("#list_pegawai").html(return_data);
      }
    });
  });



  $(".edit").click(function() {
    var id_bagian = $(this).val();

    $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>admin_jadwal_shift/edit",
      data: "id_bagian=" + id_bagian,
      success: function(return_data) {
        $("#content_edit").html(return_data);
      }
    });
  });



  $(".add_pegawai").click(function() {


    var id_bagian = $(this).data("id_bagian");
    var nama_bagian = $(this).data("nama_bagian");

    $("#nama_bagian_readonly").val(nama_bagian);
    $("#id_bagian").val(id_bagian);


    // $("#btn-simpan").html("<a href='<?php echo base_url(); ?>admin_jadwal_shift/simpan/" + id_bagian + "' class='btn btn-info'>Simpan</a>")
  });





  $(document).ready(function() {

    // Fungsi untuk load data pegawai dari controller
    function load_data(keyword = '') {

      let bagian = $("#id_bagian").val();

      $.ajax({
        url: "<?php echo base_url('admin_jadwal_shift/get_data'); ?>",
        method: "POST",
        data: {
          keyword: keyword,
          bagian: bagian
        },
        success: function(response) {
          $('#tabel-pegawai').html(response);
        }
      });
    }

    // Jalankan load data pertama kali saat halaman dibuka (menampilkan semua pegawai)
    load_data();

    // Event 1: Pencarian otomatis saat user mengetik
    $('#search-input').on('keyup', function() {
      var keyword = $(this).val();
      load_data(keyword);
    });

    // Event 2: Klik tombol "Tambahkan" menggunakan AJAX
    // Catatan: Harus pakai $(document).on() karena tombolnya digenerate secara dinamis oleh AJAX
    $(document).on('click', '.btn-tambah', function() {
      var id_pegawai = $(this).data('id');
      var input_search = $('#search-input').val(); // Simpan keyword pencarian saat ini
      var bagian = $("#id_bagian").val();

      if (confirm("Apakah Anda yakin ingin menambahkan pegawai ini?")) {
        $.ajax({
          url: "<?php echo base_url('admin_jadwal_shift/add_list_pegawai'); ?>",
          method: "POST",
          data: {
            id_pegawai: id_pegawai,
            bagian: bagian
          },
          dataType: "JSON",
          success: function(data) {
            if (data.status === 'success') {
              alert(data.message);
              // Refresh tabel dengan keyword pencarian terakhir agar tidak reset ke awal
              load_data(input_search);
            } else {
              alert(data.message);
            }
          }
        });
      }
    });

  });
</script>


</html>