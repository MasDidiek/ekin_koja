<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .table th,
    td {
      border-right: 1px solid #EEE;
    }

    .form-table {
      border: 1px solid #DDD;
      padding: 5px;
      text-align: center
    }

    .table-shift th,
    td {
      border: 1px solid #DDD;
      padding: 5px;
      text-align: center
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

      <?php

      $function = $this->uri->segment(3);
      $message = $this->session->flashdata('message');


      //echo $function;


      ?>


      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-9">
                  <h4 class="fw-semibold mb-8"> <?php echo $title; ?> </h4>
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a class="text-muted text-decoration-none" href="../main/index.html">Home / Setting</a>
                      </li>

                      <li> &nbsp; / &nbsp; </li>

                      <li class="breadcrumb-acive"> <?php echo $title; ?> </li>
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

                  <?php echo $message;
                  //echo $function;
                  ?>
                  <?php
                  if ($function == 'menu') {
                    $this->load->view('admin/setting/content_menu');
                  } else if ($function == 'menu_level_2') {
                    $this->load->view('admin/setting/content_submenu');
                  } else if ($function == 'hari_kerja') {
                    $this->load->view('admin/setting/content_hari_kerja');
                  } else if ($function == 'hari_libur') {
                    $this->load->view('admin/setting/content_hari_libur');
                  } else if ($function == 'usergroup') {
                    $this->load->view('admin/setting/content_usergroup');
                  } else if ($function == 'usergroup_hak_akses') {
                    $this->load->view('admin/setting/usergroup_hak_akses');
                  } else if ($function == 'mesin_absensi') {
                    $this->load->view('admin/setting/content_mesin_absensi');
                  } else if ($function == 'list_user') {
                    $this->load->view('admin/setting/list_user_mesin');
                  } else if ($function == 'shift_kerja') {
                    $this->load->view('admin/setting/list_shift_kerja');
                  } else if ($function == 'edit_shift_kerja') {
                    $this->load->view('admin/setting/edit_shift_kerja');
                  } else if ($function == 'create_initial_shift') {
                    $this->load->view('admin/setting/create_initial_shift');
                  } else if ($function == 'jabatan') {
                    $this->load->view('admin/setting/list_jabatan');
                  } else if ($function == 'master_gaji') {
                    $this->load->view('admin/setting/master_gaji');
                  }
                  ?>

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



  $(".edit-hari-kerja").click(function() {

    var id = $(this).val();
    $.ajax({

      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>admin/setting/edit_hari_kerja",
      data: "id=" + id,
      success: function(msg) {
        $("#modal-form").html(msg);
      }

    });

  });



  $(".edit-jabatan").click(function() {

    var id = $(this).val();
    $.ajax({

      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>admin/setting/edit_jabatan",
      data: "id=" + id,
      success: function(msg) {
        $("#modal-form").html(msg);
      }

    });

  });





  $(".edit-mesin-absensi").click(function() {

    var sn = $(this).val();
    $.ajax({

      type: "POST",
      dataType: "html",
      url: "<?php echo base_url(); ?>admin/setting/edit_mesin_absensi",
      data: "sn=" + sn,
      success: function(msg) {
        $("#modal-form").html(msg);
      }

    });

  });
</script>

<script>
$(document).ready(function() {
  $(".btn-edit-shift").click(function() {
    var kode_shift = $(this).data("kode");

    $.ajax({
      url: "<?= base_url('admin/setting/get_detail_shift'); ?>",
      type: "POST",
      dataType: "JSON",
      data: { kode_shift: kode_shift },
      success: function(data) {
        if (data) {
          // Fill text & time inputs
          $("#edit_id").val(data.id);
          $("#edit_kode_shift").val(data.kode_shift);
          $("#edit_nama_shift").val(data.nama_shift);
          $("#edit_jam_masuk").val(data.jam_masuk);
          $("#edit_jam_keluar").val(data.jam_pulang);

          // Reset semua checkbox edit terlebih dahulu
          $(".edit-user-check").prop("checked", false);

          // Cek jika status_kerja ada isinya
          if (data.status_kerja) {
            // Ubah string "non_pns,pjlp" menjadi array ["non_pns", "pjlp"]
            var selectedUsers = data.status_kerja.split(",");

            // Loop dan centang checkbox yang nilainya ada dalam array
            $(".edit-user-check").each(function() {
              var val = $(this).val();
              if (selectedUsers.includes(val)) {
                $(this).prop("checked", true);
              }
            });
          }

          // Tampilkan modal
          var editModal = new bootstrap.Modal(document.getElementById('modalEditShift'));
          editModal.show();
        }
      },
      error: function() {
        alert("Gagal mengambil data shift.");
      }
    });
  });
});


document.addEventListener("DOMContentLoaded", function() {
    // Tangkap semua elemen checkbox publish
    const checkboxes = document.querySelectorAll('.publish-check');

    checkboxes.forEach(function(checkbox) {
        checkbox.addEventListener('change', function() {
            // Cari input hidden terdekat dalam baris yang sama
            const hiddenInput = this.closest('.form-check').querySelector('.publish-val');

            // Ubah nilainya jadi 1 jika diceklist, 0 jika tidak
            hiddenInput.value = this.checked ? "1" : "0";
        });
    });
});
</script>

</html>