<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/addon.css" media="screen">

  <style>
    .bg-light {
      background-color: #f8f9fa !important;
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

            <div class="card-header">

              <h4>Template Shift Kerja Pegawai Reguler</h4>
               <h5>Periode : <?= getNamaBulan($bulan).' - '.$tahun ?></h5>
                    <?php if ($message != '') { ?>
                            <div class="alert alert-success">
                                <span class="close-btn" onclick="this.parentElement.style.display='none';">&times;</span>
                                <strong>Success! </strong> <?php echo  $message; ?>
                            </div>
                            <?php }  ?>


            </div>
              <div class="card-body p-4">

        
                   <?php

              //  print_array($template);
                                    $id_template = $template->id ;
                                    $nama_template = $template->nama_template ;
                                    $bulan = $template->bulan ;
                                    $tahun = $template->tahun ;

                                ?>
                                
                              <form method="post" action="<?= site_url('admin_jadwal_shift/update_shift') ?>">
                                <input type="hidden" name="id_template" value="<?= $id_template ?>">
                                    
                                    <button type="submit" class="btn btn-success float-end">Update Shift</button>
                                    

                                        <a href="<?= base_url('admin/template_shift/generate/'.$id_template) ?>" class="btn btn-light me-2 float-end">Generate Shift</a>
                                        <div class="clearfix"></div>


                                        <table class=" mt-2" >
                                             <thead>
                                                <tr class="bg-light">
                                                    <th>Tanggal</th>
                                                    <th>Hari</th>
                                                    <th>Shift</th>
                                                    <th>Change Shift</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            <?php foreach($detail_template as $d): ?>
                                            <tr>
                                                
                                                <td><?= format_semi($d->tanggal) ?></td>
                                                    <td><?= format_hari($d->tanggal) ; ?></td>
                                                <td> <?= $d->kode_shift ?></td>
                                                <td>
                                                    <input type="hidden" name="detail_id[]" value="<?= $d->id ?>">
                                                    <select name="shift_id[]" class="form-control" style="max-width: 250px;" required>
                                                        <option value="">-- Pilih Shift --</option>
                                                        <?php foreach($shift_kerja as $s): ?>
                                                                <option value="<?= $s->id ?>" 
                                                                <?= ($s->id == $d->shift_id) ? 'selected' : '' ?>>
                                                                <?= $s->kode_shift ?> 
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            </tbody>
                                        </table>
                        </form>
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
