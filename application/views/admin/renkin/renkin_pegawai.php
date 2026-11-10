<!DOCTYPE html>
<?php $theme = $this->session->userdata('theme'); ?>
<html lang="en" dir="ltr" data-bs-theme="<?php echo $theme; ?>" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .renkin-status {
      font-size: 0.75rem;
      border: 1px solid #cbd5e1;
      border-radius: 0.75rem;
    }

    .renkin-status-emerald {
      background-color: #ecfdf5;
      color: #059669;
      border-color: #a7f3d0;
    }

    .renkin-status-rose {
      background-color: #fff1f2;
      color: #e11d48;
      border-color: #fecdd3;
    }

    .renkin-status-amber {
      background-color: #fffbeb;
      color: #d97706;
      border-color: #fde68a;
    }

    .renkin-status.bg-danger-subtle {
      border-color: #fca5a5;
    }

    .renkin-status.bg-warning-subtle {
      border-color: #fde68a;
    }

    .renkin-status.bg-primary-subtle {
      border-color: #c7d2fe;
    }

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
      padding: 8px !important;
      color: #444 !important;
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

                      <li class="breadcrumb-acive">Renkin Pegawai</li>
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
              <form action="<?= base_url('admin/renkin/renkin_pegawai'); ?>" method="get">
                <div class="row align-items-end g-3">
                  <div class="col-md-3">
                    <label for="tahun" class="form-label">Tahun</label>
                    <input type="number" name="tahun" id="tahun" class="form-control" min="1000" max="9999" value="<?= $tahun; ?>" required>
                  </div>
                  <div class="col-md-4">
                    <label for="validator" class="form-label">Validator</label>
                    <select name="id_validator" id="validator" class="form-select" required>
                      <?php foreach ($validator as $pj) : ?>
                        <option value="<?= $pj->id_pegawai; ?>" <?= $id_validator == $pj->id_pegawai ? 'selected' : ''; ?>><?= htmlspecialchars($pj->nama, ENT_QUOTES, 'UTF-8'); ?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter me-1"></i> Filter</button>
                  </div>
                </div>
              </form>


                <div class="row">


                        <table class="table-responsive table mt-4">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Pegawai</th>
                                <th>NIP</th>
                                <th>Jabatan</th>
                                <th>Jumlah Indikator</th>
                                     
                                <th>Status Renkin</th>
                                <th>Aksi</th>
                                
                            </tr>
                        </thead>

                            <tbody>


                            <?php if (empty($renkin_pegawai)) : ?>
                              <tr><td colspan="7" class="text-center">Tidak ada data pegawai.</td></tr>
                            <?php endif; ?>
                            <?php
                                  // print_array($renkin_pegawai);
                                    $no = 1;
                                    foreach ($renkin_pegawai as $r) {
                                      
                                    

                                      $total_input = $r->total_indikator;
                                      $status_keseluruhan = $r->status_keseluruhan;
                           

                                      $status_classes = array(
                                        'Belum Ada Data' => 'renkin-status-rose',
                                        'Ditolak' => 'bg-danger-subtle text-dark',
                                        'Revisi' => 'bg-warning-subtle text-dark',
                                        'Diajukan' => 'renkin-status-amber',
                                        'Draft' => 'bg-light text-dark',
                                        'Disetujui Semua' => 'renkin-status-emerald',
                                        'Proses Validasi' => 'bg-primary-subtle text-dark'
                                      );
                                      $class_status = isset($status_classes[$status_keseluruhan]) ? $status_classes[$status_keseluruhan] : 'bg-light text-dark';

                                      ?>

                                        <tr>
                                            <td class="text-center"><?php echo $no++; ?></td>
                                            <td><?php echo $r->nama; ?></td>
                                            <td><?php echo $r->nip; ?></td>
                                            <td><?php echo $r->jabatan; ?></td>
                                            <td class="text-center"><?php echo $total_input; ?></td>
                                          
                                            
                                            <td class="text-center">
                                              <span class="badge renkin-status <?=$class_status;?>"><?php echo $status_keseluruhan; ?></span> </td>

                                             <td> 
                                                <a href="<?=base_url();?>admin/renkin/detail_renkin?id_pegawai=<?=$r->id_pegawai;?>&tahun=<?=$tahun;?>&id_validator=<?=$id_validator;?>" class="btn btn-sm btn-primary">
                                                  Validasi
                                                </a>
                                                <a href="<?=base_url();?>admin/renkin/print_renkin?id_pegawai=<?=$r->id_pegawai;?>&tahun=<?=$tahun;?>" class="btn btn-sm btn-outline-secondary" target="_blank" rel="noopener">
                                                  <i class="ti ti-printer"></i> Print
                                                </a>
                                             </td> 
                                        </tr>


                                        
                            <?php  } ?>
                            </tbody>
                        
                    </table>


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