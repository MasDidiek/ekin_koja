<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>
    <style>
        .datepicker {
            z-index: 1999;
        }

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
            $id_pegawai = $this->session->userdata('id_pegawai');
            $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
            $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 4);
            $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);
            $id_cuti   = $this->uri->segment(3);


            #print_array($detail_cuti);




            $date_from      =  $detail_cuti[0]->tgl_dari;
            $date_to        =  $detail_cuti[0]->tgl_sampai;
            $jns_cuti       =  $detail_cuti[0]->jns_cuti;
            $jns_hak_cuti   =  $detail_cuti[0]->jns_hak_cuti;

            $alasan_cuti    =  $detail_cuti[0]->alasan_cuti;
            $alamat         =  $detail_cuti[0]->alamat_cuti;
            $tlp            =  $detail_cuti[0]->no_tlp;
            $id_pegawai_pengganti   =  $detail_cuti[0]->id_pengganti;

            $date_from = format_view($detail_cuti[0]->tgl_dari);
            $date_to = format_view($detail_cuti[0]->tgl_sampai);


            $delegasi_tugas    =  $detail_cuti[0]->delegasi_tugas;
            $hari_cuti         =  $detail_cuti[0]->hari_cuti;



            $pengganti = $this->Pegawai_model->getDataEditPegawai($id_pegawai_pengganti);

            if (count($pengganti) == 0) {
                $nama_pengganti = '';
            } else {
                $nama_pengganti = $pengganti[0]->nama;
            }



            $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');
            $arrayIDHakCuti = array(2, 4, 3);
            $arraySisaCuti = array($hakCutiThnLalu, $hakCutiThnIni, $hakCutiBersama);

            $arrayJnsCuti = array('Tahunan', 'Bersalin', 'Alasan Penting', 'Sakit', 'Besar');

            $message = $this->session->flashdata('message');

            ?>


            <div class="body-wrapper">
                <div class="container-fluid mw-100">
                    <!--  Row 1 -->
                    <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h4 class="fw-semibold mb-8">Ubah Pengajuan Cuti</h4>

                                </div>

                            </div>
                        </div>
                    </div>

                    <?php echo $message;


                    if ($nama_pengganti == '') {

                        echo '<div class="alert alert-danger text-danger">
                                <strong>Pengajuan Cuti bermasalah!!</strong>
                                Nama Pengganti cuti tidak disi, mohon isi nama pengganti cuti 
                        </div>';
                    }

                    ?>
                    <div class="card">
                        <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-4" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#ubah-tanggal" type="button" role="tab" aria-controls="pills-account" aria-selected="true">
                                    <i class="ti ti-calendar me-2 fs-6"></i>
                                    <span class="d-none d-md-block">Tanggal Cuti</span>
                                </button>
                            </li>



                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4" id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#ubah-detail" type="button" role="tab" aria-controls="pills-security" aria-selected="false">
                                    <i class="ti ti-user-circle me-2 fs-6"></i>
                                    <span class="d-none d-md-block">Detail Cuti</span>
                                </button>
                            </li>


                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4" id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#ubah-delegasi-tugas" type="button" role="tab" aria-controls="pills-security" aria-selected="false">
                                    <i class="ti ti-list me-2 fs-6"></i>
                                    <span class="d-none d-md-block">Delegasi Tugas</span>
                                </button>
                            </li>




                        </ul>


                        <div class="card-body">

                            <div class="tab-content" id="pills-tabContent">

                                <div class="tab-pane fade show active" id="ubah-tanggal" role="tabpanel" aria-labelledby="pills-security-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 class="fw-semibold mb-3">Ubah Data Tanggal Cuti</h5>
                                            <form method="post" action="<?php echo base_url(); ?>cuti/edit_tanggal_cuti/<?php echo  $id_cuti; ?>" enctype="multipart/form-data">
                                                <div class="row">
                                                    <div class="col-md-2 col-sm-6 col-6 mt-3">
                                                        <label for="">Tanggal Mulai: </label>
                                                        <input type="text" required name="date_from" autocomplete="off" class="form-control" value="<?php echo $date_from; ?>" id="dpd1">
                                                    </div>
                                                    <div class="col-md-2 col-sm-6 col-6 mt-3">
                                                        <label for=""> Tanggal Akhir: </label>
                                                        <input type="text" required name="date_to" autocomplete="off" class="form-control" value="<?php echo $date_to; ?>" id="dpd2">
                                                    </div>

                                                    <div class="col-md-2 col-sm-6 col-6 mt-3">
                                                        <label for=""> Hari Cuti: </label>
                                                        <input type="text" readonly name="hari_cuti" style="width:80px" class="form-control" value="<?php echo $hari_cuti; ?>">
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        Jenis Cuti:
                                                        <select name="jns_cuti" id="jns_cuti" class="form-control">
                                                            <?php
                                                            for ($i = 0; $i < count($arrayJnsCuti); $i++) {
                                                                $idjns = $i + 1;
                                                                $jenis_cuti = $arrayJnsCuti[$i];

                                                                if ($jns_cuti == $idjns) {
                                                                    echo '<option value="' . $idjns . '" selected>Cuti ' . $jenis_cuti . '</option>';
                                                                } else {
                                                                    echo '<option value="' . $idjns . '">Cuti ' . $jenis_cuti . '</option>';
                                                                }
                                                            }
                                                            ?>



                                                        </select>

                                                    </div>
                                                    <div class="col-md-3 mt-3" id="jenis_hak_cuti">
                                                        Hak Cuti yang digunakan:
                                                        <select name="jns_hak_cuti" id="jns_cuti" class="form-control">
                                                            <?php
                                                            for ($i = 0; $i < count($arrayHakCuti); $i++) {
                                                                $idjnsHak = $arrayIDHakCuti[$i];
                                                                $nama_hak_cuti = $arrayHakCuti[$i];

                                                                echo '<option value="' . $idjnsHak . '">' . $nama_hak_cuti . ' (' . $arraySisaCuti[$i] . ')</option>';
                                                            }
                                                            ?>


                                                        </select>
                                                    </div>
                                                </div>

                                        </div>


                                        <div class="col-12 mt-4">
                                            <div class="d-flex align-items-center justify-content-end gap-3">
                                                <button type="submit" class="btn btn-primary ">Simpan Perubahan</button>
                                                <a href="<?php echo base_url(); ?>cuti/index" class="btn bg-danger-subtle text-danger">Cancel</a>
                                            </div>
                                        </div>

                                        </form>
                                    </div>
                                </div><!-- id="ubah-tanggal-->


                                <div class="tab-pane fade" id="ubah-detail" role="tabpanel" aria-labelledby="pills-security-tab" tabindex="0">
                                    <div class="row">
                                        <form method="post" action="<?php echo base_url(); ?>cuti/update_detail_cuti/<?php echo  $id_cuti; ?>">
                                            <div class="col-lg-12">
                                                <h5 class="fw-semibold mb-3">Ubah Data Detail Cuti</h5>

                                                <label>Pilih Pengganti Selama Cuti <span class="text-danger">*</span>:</label><br>
                                                <div class="form-input">
                                                    <input type="text" id="search_pegawai" name="nama_pengganti" value="<?php echo  $nama_pengganti; ?>" placeholder="cari nama pegawai" class="form-control" required autocomplete="off">
                                                    <div id="list_pegawai"></div>
                                                </div>
                                                <input type="hidden" name="id_pegawai_pengganti" id="id_pegawai_choose" value="<?php echo  $id_pegawai_pengganti; ?>">
                                                <br>
                                                <div class="form-input">
                                                    <label for="from"> Alasan Cuti <span class="text-danger">*</span></label> : <br>
                                                    <input type="text" id="alasan_cuti" name="alasan_cuti" class="form-control" value="<?php echo  $alasan_cuti; ?>" required autocomplete="off">
                                                </div>
                                                <br>
                                                <div class="form-input">
                                                    <label for="from"> No Telepon <span class="text-danger">*</span> </label> : <br>
                                                    <input type="text" id="tlp" name="tlp" class="form-control" value="<?php echo  $tlp; ?>" required style="width: 250px;" autocomplete="off">
                                                </div>
                                                <br>

                                                <div class="form-input">
                                                    <label for="from"> Alamat Selama Cuti <span class="text-danger">*</span></label> : <br>
                                                    <textarea name="alamat" class="form-control"><?php echo  $alamat; ?></textarea>
                                                </div>

                                            </div>


                                            <div class="col-12 mt-4">
                                                <div class="d-flex align-items-center justify-content-end gap-3">
                                                    <button type="submit" class="btn btn-primary ">Simpan Perubahan</button>
                                                    <a href="<?php echo base_url(); ?>cuti/index" class="btn bg-danger-subtle text-danger">Cancel</a>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div><!-- id="ubah-tanggal-->


                                <div class="tab-pane fade" id="ubah-delegasi-tugas" role="tabpanel" aria-labelledby="pills-security-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 class="fw-semibold mb-3">Ubah Delegasi Tugas</h5>

                                        </div>


                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-end gap-3">
                                                <button class="btn btn-primary">Save</button>
                                                <button class="btn bg-danger-subtle text-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- id="ubah-tanggal-->



                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>

        <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <form action="<?php echo base_url(); ?>profile/upload_sip_str" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="exampleModalLabel1">
                                Input Dokumen <span id="title_modal">SIP</span>
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="control-label">Tanggal Terbit:</label>
                                        <input type="text" required name="tanggal_terbit" autocomplete="off" class="form-control" id="dpd1">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="recipient-name" class="control-label">Tanggal Expired:</label>
                                        <input type="text" name="tanggal_expired" autocomplete="off" class="form-control" id="dpd2">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="jns_dokumen" id="jns_dokumen" value="">



                            <div class="mb-3">
                                <label for="message-text" class="control-label">No <span id="title_no">SIP</span>:</label>
                                <input type="text" name="no_sip_str" required autocomplete="off" class="form-control">
                            </div>
                            <div class="mb-3">
                                <div class="card w-100 bg-info-subtle overflow-hidden p-2 shadow-none">
                                    <h6>Dokumen <span id="title_dok">SIP</span>:</h6>
                                    <p class="text-danger">
                                        Jenis file yang diizinkan : <strong>PDF </strong> <br>
                                        Ukuran Maksimum File : <strong>1 MB </strong>
                                    </p>


                                    <br>
                                    <br>
                                    <input type="file" name="filedocs" required id="file-input" multiple />
                                    <label for="file-input">


                                        <div class="btn btn-primary">
                                            <i class="fa fa-folder-open"></i>
                                            &nbsp; Choose Files To Upload
                                        </div>
                                    </label>

                                    <div id="num-of-files">No Files Choosen</div>
                                    <ul id="files-list"></ul>
                                </div>
                            </div>



                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-success">
                                Submit
                            </button>
                        </div>
                    </div>

                </form>
            </div>
        </div>




        <div class="modal fade" id="edit-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog" role="document">
                <form action="<?php echo base_url(); ?>profile/update_sip_str" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                    <div class="modal-content">
                        <div class="modal-header d-flex align-items-center">
                            <h4 class="modal-title" id="exampleModalLabel1">
                                Edit Dokumen <span id="title_modal">SIP / STR</span>
                            </h4>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="modal_form_edit">


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-danger-subtle text-danger font-medium" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-success">
                                Submit
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


    <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH; ?>bootstrap-datepicker.js"></script>


</body>


<script>
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
            return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate', function(ev) {
        checkout.hide();
    }).data('datepicker');
</script>

</html>