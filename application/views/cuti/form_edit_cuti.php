<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
  .datepicker{
    z-index: 1999;
}


.alert-danger{
    color: #F04444;
    background: #FFF8F8 !important;
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

      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <div class="body-wrapper">
      <div class="container-fluid">
            <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8">Pengajuan Cuti</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="<?php echo base_url();?>dashboard/index" >Home</a>
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

           // print_array($detail_cuti);
                $id_pegawai = $detail_cuti->id_pegawai;
                $jns_cuti      =  $detail_cuti->jenis_cuti;
                $tgl_mulai     =  $detail_cuti->tgl_mulai;
                $tgl_akhir     =  $detail_cuti->tgl_selesai;
                $id_pengganti  =  $detail_cuti->id_pengganti;
                $alasan_cuti   =  $detail_cuti->alasan_cuti;
                $tlp           =  $detail_cuti->no_telp;
                $alamat        =  $detail_cuti->alamat_cuti;
                $delegasi_tugas        =  $detail_cuti->delegasi_tugas;
                $lama_cuti        =  $detail_cuti->lama_cuti;

                $error = $this->session->flashdata('error');
                //echo $message;
                $jabatan =  $detail_pegawai[0]->jabatan;
                $puskesmas =  $detail_pegawai[0]->puskesmas;

                $id_jabatan =  $detail_pegawai[0]->id_jabatan;

                $listPegawaiPengganti = $this->Cuti_model->getListPegawaiPenggantiCuti( $id_pegawai, $id_jabatan);
                $sisaTahun2025 = $rekap_hak_cuti['2025']['sisa'];
                $sisaTahun2026 = $rekap_hak_cuti['2026']['sisa'];

                $sisa2025 = (int) $sisaTahun2025;
                $sisa2026 = (int) $sisaTahun2026;

                // default
                $checked2025 = '';
                $checked2026 = '';
                $disabled2025 = '';
                $disabled2026 = '';

                // logic disabled
                if ($sisa2025 <= 0) {
                    $disabled2025 = 'disabled';
                }
                if ($sisa2026 <= 0) {
                    $disabled2026 = 'disabled';
                }

                // logic auto checked
                if ($sisa2025 > 0 && $sisa2026 <= 0) {
                    $checked2025 = 'checked';
                }
                elseif ($sisa2026 > 0 && $sisa2025 <= 0) {
                    $checked2026 = 'checked';
                }

            ?>


         <div class="card">

             <?php if($error!=''){echo '<div class="alert alert-danger">'.$error.'</div>';}?>
            <div class="card-body">
            <h5>Form Ubah Pengajuan Cuti</h5>
                <form method="post" action="<?php echo base_url();?>cuti/update_pengajuan_cuti/<?= $detail_cuti->id;?> ?>" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 mt-3">
                              <div class="mb-3">
                                <label for=""  class="form-label"> Jenis Cuti: </label>
                                <select name="jns_cuti" id="jns_cuti" class="form-control">
                                        <?php
                                        for ($c=0; $c < count($master_cuti); $c++) {
                                            $id = $master_cuti[$c]->id;
                                            $jenis_cuti = $master_cuti[$c]->jenis_cuti;
                                            echo '<option value="'.$id.'">'.$jenis_cuti.'</option>';
                                        }
                                        ?>
                                    </select>
                              </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6 mt-3">
                            <div class="mb-3">
                                <label for="" class="form-label">Tanggal Mulai: </label>
                                <input type="text" required name="tgl_mulai" autocomplete="off" class="form-control" value="<?php echo $tgl_mulai  ;?>" id="tgl_mulai" >
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-6 col-6 mt-3">
                             <div class="mb-3">
                                <label for=""  class="form-label"> Tanggal Akhir: </label>
                                <input type="text" required  name="tgl_akhir"  autocomplete="off"   class="form-control" value="<?php echo $tgl_akhir  ;?>" id="tgl_akhir" >
                             </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-6 mt-3">

                            <!-- Jumlah Hari -->
                            <div class="mb-3">
                                <label class="form-label">Jumlah Hari Cuti</label>
                                <div class="input-group" style="max-width:200px;">
                                    <input type="text" name="jumlah_hari_cuti" id="jumlah_hari_cuti" value="<?= $lama_cuti; ?>"
                                        class="form-control bg-white" readonly>
                                    <span class="input-group-text titel_hari">hari</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6 col-6 mt-3">
                                <!-- Hak Cuti -->
                                <div class="mb-3">
                                    <label class="form-label">Hak Cuti yang Digunakan</label>
                                    <select name="hak_cuti" id="hak_cuti" class="form-control">
                                        <option value="2025">2025 &nbsp; (<?=$sisa2025;?> hari)</option>
                                        <option value="2026">2026 &nbsp; (<?=$sisa2026;?> hari)</option>
                                    </select>
                                </div>

                        </div>
                        <div class="col-md-6 col-sm-6 col-6 mt-3">

                            <!-- Pengganti Cuti -->
                            <div class="mb-3">
                                <label class="form-label">Pengganti Cuti</label>
                                <select class="form-control select2" name="id_pengganti" required>
                                    <option value="">-- Pilih pengganti cuti --</option>
                                    <?php
                                    for ($p=0; $p < count($listPegawaiPengganti); $p++) {
                                        $id_pegawai = $listPegawaiPengganti[$p]->id_pegawai;
                                        $nama_pegawai = $listPegawaiPengganti[$p]->nama;
                                        $selected = ($id_pegawai==$id_pengganti) ? 'selected' : '';
                                        echo '<option value="'.$id_pegawai.'" '.$selected.'>'.$nama_pegawai.'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="mb-4">
                                <label for="tlp" class="form-label">No Telepon / HP</label>
                                <input type="text" id="tlp" name="no_tlp"
                                    class="form-control" placeholder="08xxxx"
                                    value="<?php echo $tlp;?>" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <!-- Alasan -->
                            <div class="mb-3">
                                <label for="alasan_cuti" class="form-label">Alasan Cuti</label>
                                <textarea name="alasan_cuti" class="form-control" required id="alasan_cuti" rows="3"><?= $alasan_cuti; ?></textarea>
                            </div>

                        </div>

                        <div class="col-md-6 col-12">
                            <!-- Alasan -->
                            <div class="mb-3">
                                <label for="alamat" class="form-label">Alamat Selama Cuti</label>
                                <textarea name="alamat" class="form-control" required  id="alamat" rows="3"><?= $alamat; ?></textarea>
                            </div>

                        </div>
                            <div class="col-md-6 col-12">
                            <!-- Alasan -->
                            <div class="mb-3">
                                <label for="delgeasi tugas" class="form-label">Delegasi Tugas</label>

                                <textarea name="delegasi_tugas" class="form-control" required min="50" id="delegasi_tugas" rows="3"><?= $delegasi_tugas;?></textarea>
                                <span class="text-muted">Tuliskan pekerjaan-pekerjaan yang akan didelegasikan ke pengganti cuti minimal 3 tugas, beri tanda koma(,) sebagai pemisah</span>
                            </div>

                        </div>

                    </div>
                    <button type="submit" class="btn btn-primary float-end mt-4">Simpan Perubahan </button>
                </form>

            </div>


          </div>
        </div>



            <div class="py-6 px-6 text-center">
              <p class="mb-0 fs-4">Design and Developed by
                <a href="#" target="_blank" class="pe-1 text-primary text-decoration-underline">DhifaWebStudio</a> </p>
            </div>

  <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>dashboard.js"></script>


    <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>bootstrap-datepicker.js"></script>

  <script>

        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        //1700931600000
        //1703264400000

        var checkin = $('#tgl_mulai').datepicker({
            onRender: function(date) {
                //alert(date.valueOf());
                //return date.valueOf() < now.valueOf() ? 'disabled' : '';
                return '';
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
            var checkout = $('#tgl_akhir').datepicker({
            onRender: function(date) {
           // return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
           return '';
        }
        }).on('changeDate', function(ev) {
          checkout.hide();

          const tglMulai = $("#tgl_mulai").val();
          const tglAkhir = $("#tgl_akhir").val();

          hitungHariCuti(tglMulai, tglAkhir);

        }).data('datepicker');



            function hitungHariCuti(tglMulai, tglAkhir) {
                const jenis = $("#jenis_jam_kerja").val();
                $.ajax({
                  url: "<?php echo base_url("cuti/hitung"); ?>",
                  type: "POST",
                  data: { tgl_mulai: tglMulai, tgl_akhir: tglAkhir, jenis_jam_kerja: jenis },
                  dataType: "json",
                  success: function(response) {
                    if (response.error) {
                      alert(response.error);
                      $("#jumlah_hari_cuti").val(0);
                    } else {
                      $("#jumlah_hari_cuti").val(response.jumlah_hari );
                    }
                  },
                  error: function() {
                    alert("Terjadi kesalahan saat menghitung cuti.");
                    $("#jumlah_hari_cuti").val(0);
                  }
                });
              }


  </script>

  </body>
</html>
