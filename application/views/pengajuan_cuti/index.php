<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .datepicker {
      z-index: 1999;
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



      $tgl_masuk = $pegawai[0]->tgl_masuk;
      $id_pegawai = $pegawai[0]->id_pegawai;
      $nama_pegawai  = $pegawai[0]->nama;
      $message_update = $this->session->flashdata('message_update');
      $message = $this->session->flashdata('message');


      ?>
      <div class="body-wrapper">
        <div class="container-fluid mw-100">
          <!--  Row 1 -->
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
            <div class="card-body px-4 py-3">
              <div class="row align-items-center">
                <div class="col-12">
                  <h4 class="fw-semibold mb-8">Cuti Saya</h4>
                  <?php echo   $message_update; ?>
                </div>

              </div>
            </div>
          </div>

          <?php echo $message; ?>
          <div class="card">



            <div class="card-body">

              <?php $this->load->view('profile/tab_cuti'); ?>

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


  <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
  <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>


</body>


<script>
  $(".cancel_cuti").click(function() {
    var id_cuti = $(this).val();
    $("#id_cuti_cancel").val(id_cuti);

  });



  var nowTemp = new Date();
  var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

  var checkin = $('#dpd1').datepicker({
    onRender: function(date) {
      //  return date.valueOf() < now.valueOf() ? 'disabled' : '';
    }
  }).on('changeDate', function(ev) {
    if (ev.date.valueOf() > checkout.date.valueOf()) {
      var newDate = new Date(ev.date)
      newDate.setDate(newDate.getDate() + 1);
      checkout.setValue(newDate);
    }
    checkin.hide();
    $('#dpd2')[0].focus();
  }).data('datepicker');
  var checkout = $('#dpd2').datepicker({
    onRender: function(date) {
      // return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
    }
  }).on('changeDate', function(ev) {
    checkout.hide();
  }).data('datepicker');


  // var nowTemp = new Date();
  // var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);

  // var checkin = $('#dpd1').datepicker({
  //  onRender: function(date) {
  //     //  return date.valueOf() < now.valueOf() ? 'disabled' : '';
  //     }
  // }).on('changeDate', function(ev) {
  // if (ev.date.valueOf() > checkout.date.valueOf()) {
  //     var newDate = new Date(ev.date)
  //     newDate.setDate(newDate.getDate() + 1);
  //     checkout.setValue(newDate);
  // }
  //       checkin.hide();
  // $('#dpd2')[0].focus();
  // }).data('datepicker');
  //     var checkout = $('#dpd2').datepicker({
  //     onRender: function(date) {
  //     return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
  // }
  // }).on('changeDate', function(ev) {
  // checkout.hide();
  // }).data('datepicker');
</script>

</html>