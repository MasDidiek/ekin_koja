<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
  <?php $this->load->view('master/meta'); ?>
  <style>
    .bg-grey {
      background-color: #F8F8F8;
    }

    .wrapper {
      padding: 10px;
      font-size: 14px;
    }

    .StepProgress {
      position: relative;
      padding-left: 45px;
      list-style: none;
    }

    .StepProgress::before {
      display: inline-block;
      content: '';
      position: absolute;
      top: 0;
      left: 15px;
      width: 10px;
      height: 100%;
      border-left: 2px solid #CCC;
    }

    .StepProgress-item {
      position: relative;
      counter-increment: list;
    }

    .StepProgress-item:not(:last-child) {
      padding-bottom: 20px;
    }

    .StepProgress-item::before {
      display: inline-block;
      content: '';
      position: absolute;
      left: -30px;
      height: 100%;
      width: 10px;
    }

    .StepProgress-item::after {
      content: '';
      display: inline-block;
      position: absolute;
      top: 0;
      left: -40px;
      width: 22px;
      height: 22px;
      border: 2px solid #CCC;
      border-radius: 50%;
      background-color: #FFF;
    }

    .StepProgress-item.is-done::before {
      border-left: 2px solid #06c495;
    }

    .StepProgress-item.is-reject::after {
      content: "x";
      font-size: 12px;
      color: #FFF;
      text-align: center;
      border: 2px solid #ed5551;
      background-color: #ed5551;
    }


    .StepProgress-item.is-done::after {
      content: "✔";
      font-size: 12px;
      color: #FFF;
      text-align: center;
      border: 2px solid #06c495;
      background-color: #06c495;
    }

    .StepProgress-item.current::before {
      border-left: 2px solid #06c495;
    }

    .StepProgress-item.current::after {
      content: counter(list);
      padding-top: 1px;
      width: 25px;
      height: 25px;
      top: -5px;
      left: -41px;
      font-size: 14px;
      text-align: center;
      color: #06c495;
      border: 2px solid #06c495;
      background-color: white;
    }

    .StepProgress strong {
      display: block;
    }


    .calendar {
      background: #FFF;
      border-radius: 4px;
      height: 380px;
      perspective: 1000;
      transition: .9s;
      transform-style: preserve-3d;
      width: 90%;
      border: 1px solid #DDD;
      margin-top: 20px
    }

    /* Front - Calendar */
    .front {
      transform: rotateY(0deg);
    }

    .current-date {
      border-bottom: 1px solid rgba(73, 114, 133, .6);
      display: flex;
      justify-content: space-between;
      padding: 10px 20px;
    }


    .week-days {
      color: #555;
      display: flex;
      justify-content: space-between;
      font-weight: 600;
      padding: 20px 30px;

    }

    .days {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;

    }

    .weeks {
      color: #666;
      display: flex;
      flex-direction: column;
      padding: 0 20px;
    }

    .weeks div {
      display: flex;
      font-size: 1em;
      font-weight: 300;
      justify-content: space-between;
      margin-bottom: 5px;
      width: 100%;

    }

    .last-month {
      opacity: .3;
    }

    .weeks span {
      padding: 10px;
    }

    .weeks span.active {
      background: orange;
      border-radius: 5px;
      color: #FFF
    }

    .weeks span:not(.last-month):hover {
      cursor: pointer;
      font-weight: 600;
    }

    .event {
      position: relative;
    }

    .event:after {
      content: '•';
      color: #f78536;
      font-size: 1.4em;
      position: absolute;
      right: -4px;
      top: -4px;
    }

    /* Back - Event form */

    .back {
      height: 100%;
      transform: rotateY(180deg);
    }

    .back input {
      background: none;
      border: none;
      border-bottom: 1px solid rgba(73, 114, 133, .6);
      color: #dfebed;
      font-size: 1.4em;
      font-weight: 300;
      padding: 30px 40px;
      width: 100%;
    }

    .info {
      color: #dfebed;
      display: flex;
      flex-direction: column;
      font-weight: 600;
      font-size: 1.2em;
      padding: 30px 40px;
    }

    .info div:not(.observations) {
      margin-bottom: 40px;
    }

    .info span {
      font-weight: 300;
    }

    .info .date {
      display: flex;
      justify-content: space-between;
    }

    .info .date p {
      width: 50%;
    }

    .info .address p {
      width: 100%;
    }

    .actions {
      bottom: 0;
      border-top: 1px solid rgba(73, 114, 133, .6);
      display: flex;
      justify-content: space-between;
      position: absolute;
      width: 100%;
    }

    .actions button {
      background: none;
      border: 0;
      color: #fff;
      font-weight: 600;
      letter-spacing: 3px;
      margin: 0;
      padding: 30px 0;
      text-transform: uppercase;
      width: 50%;
    }

    .actions button:first-of-type {
      border-right: 1px solid rgba(73, 114, 133, .6);
    }

    .actions button:hover {
      background: #497285;
      cursor: pointer;
    }

    .actions button:active {
      background: #5889a0;
      outline: none;
    }

    /* Flip animation */

    .flip {
      transform: rotateY(180deg);
    }

    .front,
    .back {
      backface-visibility: hidden;
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

      //print_array($this->session->userdata);
      $id_validator    = $this->session->userdata('id_pegawai');
      $usergroup    = $this->session->userdata('usergroup');
      $my_nip       = $this->session->userdata('nip');

      #echo $usergroup;
      $id   =  $detail_cuti[0]->id;
      $tgl_dari   =  $detail_cuti[0]->tgl_dari;
      $tgl_sampai =  $detail_cuti[0]->tgl_sampai;
      $hari_cuti  =  $detail_cuti[0]->hari_cuti;
      $status  =  $detail_cuti[0]->status;
      $id_cuti  =  $detail_cuti[0]->id;
      $id_pegawai =  $detail_cuti[0]->id_pegawai;

      $tgl_pengajuan  =  $detail_cuti[0]->tgl;
      $id_pengganti  =  $detail_cuti[0]->id_pengganti;
      $delegasi_tugas  =  $detail_cuti[0]->delegasi_tugas;

      $tgl_check2  =  $detail_cuti[0]->tgl_check2;

      if ($tgl_check2 != null) {
        $approve_date = format_full($tgl_check2);
      } else {
        $approve_date = '';
      }

      $jns_cuti  =  $detail_cuti[0]->jns_cuti;
      if ($jns_cuti == 1) {
        $jenis_cuti = 'Tahunan';
      } else if ($jns_cuti == 2) {
        $jenis_cuti = 'Cuti Bersalin';
      } else if ($jns_cuti == 3) {
        $jenis_cuti = 'Cuti Alasan Penting';
      } else if ($jns_cuti == 4) {
        $jenis_cuti = 'Cuti Sakit';
      } else if ($jns_cuti == 5) {
        $jenis_cuti = 'Cuti Besar';
      } else {
        $jenis_cuti = 'Cuti Bersalin Anak 3';
      }

      $message = $this->session->flashdata('message');



      if ($hari_cuti == 1) {
        $tgl_cuti = '<span class="text-dark">' . format_full($tgl_dari) . '</span>';
      } else {
        $tgl_cuti = '<span class="text-dark">' . format_full($tgl_dari) . ' </span> &nbsp;&nbsp;&nbsp; s/d &nbsp;&nbsp;&nbsp;<span class="text-dark">' . format_full($tgl_sampai) . '</span>';
      }


      $flagStatus = getStatusCuti($status);


      $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
      $id_pj       = $detail_pegawai[0]->id_validator;
      $nama        = $detail_pegawai[0]->nama;
      $jns_pegawai = $detail_pegawai[0]->jns_pegawai;
      $jabatan     = $detail_pegawai[0]->jabatan;
      $puskesmas   = $detail_pegawai[0]->puskesmas;
      $jns_pegawai = $detail_pegawai[0]->jns_pegawai;



      $detail_pegawai_pengganti = $this->Pegawai_model->getDetailPegawai($id_pengganti);
      $jabatan_pengganti        = $detail_pegawai_pengganti[0]->jabatan;
      $puskesmas_pengganti      = $detail_pegawai_pengganti[0]->puskesmas;
      #print_array($detail_pegawai);
      $delegasi = explode("+", $delegasi_tugas);
      ?>

      <div class="body-wrapper">
        <div class="container-fluid">

          <div class="row p-2">
            <div class="col-md-12 mb-4">
              <a href="<?php echo base_url(); ?>admin/pengajuan_cuti/pengajuan_cuti_pegawai" class="btn btn-light"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
            </div>

            <div class="col-md-8">
              <h5 class="fw-semibold">Pengajuan Cuti Pegawai</h5>

            </div>

            <div class="col-md-4">
              <?php
              //echo $usergroup;
              if ($usergroup == 0 && $status != 'CANCEL') {
                echo '<a href="' . base_url() . 'admin/pengajuan_cuti/cancel_cuti/' . $id . '" class="btn btn-danger float-end  me-1" onClick="return confirm(\'Apakah anda ingin membatalkan cuti pegawai ini?\')">
                                  <i class="fa-regular fa-circle-x"></i> Batalkan Cuti
                                </a>';
              }

              if (($usergroup == 3 || $usergroup == 4) && $status == 'PEND1') {
                echo '  <button type="button"  class="btn btn-danger  float-end"><i class="fa-solid fa-circle-xmark"></i> Tolak</button>
                              <button type="button" class="btn btn-success float-end  me-1" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@setuju">
                                <i class="fa-regular fa-circle-check"></i> Setujui
                              </button>';
              }

              if ($my_nip  == $detail_pegawai_pengganti[0]->nip && $status == 'PEND0') {
                echo '  <button type="button" data-bs-toggle="modal" data-bs-target="#rejectcuti-modal" data-bs-whatever="reject" class="btn btn-danger  float-end"><i class="fa-solid fa-circle-xmark"></i> Tolak</button>
                                    <button type="button" class="btn btn-success float-end  me-1" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo">
                                      <i class="fa-regular fa-circle-check"></i> Setujui
                                    </button>';
              }

              if ($usergroup == 2 && ($status == 'PEND2' or $status == 'PEND1')) {
                echo '  <button type="button" data-bs-toggle="modal" data-bs-target="#rejectcuti-modal" data-bs-whatever="reject" class="btn btn-danger  float-end"><i class="fa-solid fa-circle-xmark"></i> Tolak</button>
                                    <button type="button" class="btn btn-success float-end  me-1" data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo">
                                      <i class="fa-regular fa-circle-check"></i> Setujui
                                    </button>';
              }

              if ($usergroup == 1 && $status == 'PEND3') {
                echo '  <button type="button"  class="btn btn-danger  float-end" data-bs-toggle="modal" data-bs-target="#rejectcuti-modal" data-bs-whatever="@mdo"><i class="fa-solid fa-circle-xmark"></i> Tolak</button>
                                <button type="button" class="btn btn-success float-end  me-1"  data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo" >
                                  <i class="fa-regular fa-circle-check"></i> Setujui
                                </button>';
              }

              ?>


            </div>
          </div>

          <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog " role="document">
              <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                  <h4 class="modal-title" id="exampleModalLabel1">
                    Pengajuan Cuti
                  </h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="<?php echo base_url(); ?>admin/pengajuan_cuti/approve_pengajuan_cuti/<?php echo $id; ?>" method="post">
                    <div class="mb-3">
                      <h6>Apakah anda yakin untuk menyetujui pengajuan cuti ini ?</h6>
                    </div>
                    <center>
                      <button type="submit" class="btn btn-success" name="status" value="<?php echo $status; ?>">
                        Iya, Setujui
                      </button>
                    </center>

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


          <div class="modal fade" id="rejectcuti-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
            <div class="modal-dialog " role="document">
              <div class="modal-content">
                <div class="modal-header d-flex align-items-center">
                  <h4 class="modal-title" id="exampleModalLabel1">
                    Pengajuan Cuti
                  </h4>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                  <form action="<?php echo base_url(); ?>admin/pengajuan_cuti/tolak_cuti/<?php echo $id; ?>" method="post">
                    <div class="mb-3">
                      <label>Alasan Penolakan</label>
                      <textarea name="alasan_tolak" required class="form-control" placeholder="tuliskan alasan cuti ditolak"></textarea>
                    </div>

                    <button type="submit" class="btn btn-success" name="status" value="<?php echo $status; ?>">
                      Submit
                    </button>

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
                  <h6 class="fw-semibold  bg-grey  border-bottom p-3 mb-2">Pegawai yang mengajukan cuti</h6>
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

                  <h6 class="fw-semibold  bg-grey  border-bottom p-3 mb-2">Pegawai pengganti cuti</h6>
                  <div class="row p-3">
                    <div class="col-md-6  mb-3">
                      <span class="text-dark">Nama : </span> <br>
                      <strong><?php echo $detail_pegawai_pengganti[0]->nama; ?></strong>
                    </div>

                    <div class="col-md-6 mb-3">
                      <span class="text-dark">NIP : </span> <br>
                      <strong><?php echo $detail_pegawai_pengganti[0]->nip; ?></strong>
                    </div>

                    <div class="col-md-6">
                      <span class="text-dark">Jabatan : </span> <br>
                      <strong><?php echo $detail_pegawai_pengganti[0]->jabatan; ?></strong>
                    </div>


                    <div class="col-md-6">
                      <span class="text-dark">Tempat Tugas : </span> <br>
                      <strong><?php echo $detail_pegawai_pengganti[0]->puskesmas; ?></strong>
                    </div>

                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-4 col-md-4">
              <div class="border">
                <div class="card-body">
                  <h6 class="fw-semibold bg-grey border-bottom p-3 mb-2">Status Pengajuan cuti</h6>

                  <?php

                  $progress0 = '';
                  $text_info0 = '';
                  $progress1 = '';
                  $text_info1 = '';
                  $progress2 = '';
                  $text_info2 = '';
                  $progress3 = '';
                  $text_info3 = '';
                  $progress4 = '';
                  $text_info4 = '';

                  if ($status == 'PEND0') {
                    //baru buat,belum diacc pengganti
                    $progress1 = 'current';
                    $text_info1 = '<span class="text-warning"> Menunggu ACC Pengganti</span>';
                  } else if ($status == 'PEND1') {
                    //sudah  diacc pengganti
                    $progress1 = 'is-done';
                    $progress2 = 'current';
                    $text_info1 = '<span class="text-success">' . format_full($detail_cuti[0]->tgl_cek) . ' </span>';
                    $text_info2 = ' <span class="text-warning"> Menunggu ACC Kapustu / Kasatpel</span>';
                  } else if ($status == 'PEND2') {
                    $progress1 = 'is-done';
                    $progress2 = 'is-done';
                    $progress3 = 'current';
                    $text_info1 = '<span class="text-success">' . format_full($detail_cuti[0]->tgl_cek) . ' </span>';
                    $text_info2 = ' <span class="text-success">' . format_full($detail_cuti[0]->tgl_check) . ' </span>';
                    $text_info3 = ' <span class="text-warning"> Menunggu ACC Kepala TU</span>';
                    //sudah  diacc Kasatpel. kapustu
                  } else if ($status == 'PEND3') {
                    $progress1 = 'is-done';
                    $progress2 = 'is-done';
                    $progress3 = 'is-done';
                    $progress4 = 'current';
                    $text_info1 = '<span class="text-success">' . format_full($detail_cuti[0]->tgl_cek) . ' </span>';
                    $text_info2 = '<span class="text-success">' . format_full($detail_cuti[0]->tgl_check) . ' </span>';
                    $text_info3 = '<span class="text-success"> ' . format_full($detail_cuti[0]->tgl_check_ktu) . '</span>';
                    $text_info4 = '<span class="text-warning"> Menunggu ACC Kepala Puskesmas</span>';
                    //sudah  diacc ka TU
                  } else if ($status == 'APPROVE') {
                    $progress1 = 'is-done';
                    $progress2 = 'is-done';
                    $progress3 = 'is-done';
                    $progress4 = 'is-done';
                    $text_info1 = '<span class="text-success">' . format_full($detail_cuti[0]->tgl_cek) . ' </span>';
                    $text_info2 = '<span class="text-success">' . format_full($detail_cuti[0]->tgl_check) . ' </span>';
                    $text_info3 = '<span class="text-success"> ' . format_full($detail_cuti[0]->tgl_check_ktu) . '</span>';
                    $text_info4 = '<span class="text-success"> ' . format_full($detail_cuti[0]->tgl_check2) . '</span>';
                    //sudah  di acc kapuskel
                  } else if ($status == 'REJECT') {
                    $progress1 = 'is-done';
                    $progress2 = 'is-done';

                    $text_info1 = '<span class="text-success">' . format_full($detail_cuti[0]->tgl_cek) . ' </span>';
                    $text_info2 = '<span class="text-success">' . format_full($detail_cuti[0]->tgl_check) . ' </span>';
                    if ($detail_cuti[0]->check_ktu == 2) {
                      //ditolak oleh KTU
                      $text_info3 = '<span class="text-danger"> ' . format_full($detail_cuti[0]->tgl_check_ktu) . ' (Cuti Ditolak) <br>
                                                ' . $detail_cuti[0]->alasan_tolak . '</span>';
                      $progress3 = 'is-reject';
                      $progress4 = '';
                    } else {
                      $text_info4 = '<span class="text-danger"> ' . format_full($detail_cuti[0]->tgl_check2) . '</span>';
                    }


                    //sudah  di acc kapuskel
                  } else {
                    //cancel

                    echo '<div class="alert alert-danger text-danger">Cuti telah dibatalkan</div>';
                  }
                  ?>
                  <div class="wrapper">
                    <ul class="StepProgress">
                      <li class="StepProgress-item is-done"><strong>Pengajuan Cuti</strong>
                        <span class="text-success"> <?php echo format_full($tgl_pengajuan); ?></span>
                      </li>
                      <li class="StepProgress-item <?php echo $progress1; ?>"><strong>ACC Pengganti Cuti </strong>
                        <span class="text-success"> <?php echo $text_info1; ?></span>
                      </li>
                      <li class="StepProgress-item  <?php echo $progress2; ?>"><strong>ACC Kapustu / Kasatpel </strong>
                        <?php echo $text_info2; ?>
                      </li>

                      <li class="StepProgress-item <?php echo $progress3; ?>"><strong>ACC Kepala TU</strong>
                        <?php echo $text_info3; ?>
                      </li>
                      <li class="StepProgress-item  <?php echo $progress4; ?>"><strong>ACC Kepala Puskesmas Koja</strong>
                        <?php echo $text_info4; ?>
                      </li>


                    </ul>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-8 mb-4">
              <div class="border mt-4">
                <div class="card-body">
                  <h6 class="fw-semibold  border-bottom p-3 mb-2">Data Pengajuan Cuti</h6>
                  <div class="row p-3">
                    <div class="col-md-6">
                      <h6 class="text-dark">Tanggal Pengajuan</h6>
                      <p><?php echo format_full($tgl_pengajuan); ?></p> <br>

                      <h6 class="text-dark">Tanggal Cuti</h6>
                      <p><?php echo format_full($tgl_dari); ?> &nbsp; &nbsp; - &nbsp; &nbsp; <?php echo format_full($tgl_sampai); ?></p>
                      <br>
                      <h6 class="text-dark">Lama Cuti</h6>
                      <p><?php echo $detail_cuti[0]->hari_cuti; ?> hari</p>


                    </div>
                    <div class="col-md-6">
                      <h6 class="text-dark">Jenis Cuti</h6>
                      <p><?php echo $jenis_cuti; ?></p> <br>


                      <h6 class="text-dark">Alasan Cuti</h6>
                      <p><?php echo $detail_cuti[0]->alasan_cuti; ?></p> <br>


                      <h6 class="text-dark">Alamat Selama Cuti</h6>
                      <p><?php echo $detail_cuti[0]->alamat_cuti; ?></p>


                    </div>


                  </div>

                </div>
              </div>
            </div>

            <div class="col-md-4 mt-4">
              <h5>Delegasi tugas </h5>
              <ol>
                <?php
                for ($i = 0; $i < count($delegasi); $i++) {
                  echo '<li> ' . $delegasi[$i] . '</li>
                                      ';
                }
                ?>
              </ol>

              <!-- 
                              <div class="calendar">
                                      <div class="front">
                                        <div class="current-date">

                                             <h3>January 2024</h3>
                                           </div>
                                        <div class="current-month">
                                          <ul class="week-days">
                                            <li>MON</li>
                                            <li>TUE</li>
                                            <li>WED</li>
                                            <li>THU</li>
                                            <li>FRI</li>
                                            <li>SAT</li>
                                            <li>SUN</li>
                                          </ul>

                                          <div class="weeks">
                                            <div class="first">
                                              <span class="last-month">28</span>
                                              <span class="last-month">29</span>
                                              <span class="last-month">30</span>
                                              <span class="last-month">31</span>
                                              <span>01</span>
                                              <span>02</span>
                                              <span>03</span>
                                            </div>

                                            <div class="second">
                                              <span>04</span>
                                              <span>05</span>
                                              <span class="event">06</span>
                                              <span>07</span>
                                              <span>08</span>
                                              <span>09</span>
                                              <span>10</span>
                                            </div>

                                            <div class="third">
                                              <span>11</span>
                                              <span>12</span>
                                              <span>13</span>
                                              <span>14</span>
                                              <span class="active">15</span>
                                              <span>16</span>
                                              <span>17</span>
                                            </div>

                                            <div class="fourth">
                                              <span>18</span>
                                              <span>19</span>
                                              <span>20</span>
                                              <span>21</span>
                                              <span>22</span>
                                              <span>23</span>
                                              <span>24</span>
                                            </div>

                                            <div class="fifth">
                                              <span>25</span>
                                              <span>26</span>
                                              <span>27</span>
                                              <span>28</span>
                                              <span>29</span>
                                              <span>30</span>
                                              <span>31</span>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="back">
                                        <input placeholder="What's the event?">
                                        <div class="info">
                                          <div class="date">
                                            <p class="info-date">
                                            Date: <span>Jan 15th, 2016</span>
                                            </p>
                                            <p class="info-time">
                                              Time: <span>6:35 PM</span>
                                            </p>
                                          </div>
                                          <div class="address">
                                            <p>
                                              Address: <span>129 W 81st St, New York, NY</span>
                                            </p>
                                          </div>
                                          <div class="observations">
                                            <p>
                                              Observations: <span>Be there 15 minutes earlier</span>
                                            </p>
                                          </div>
                                        </div>

                                        <div class="actions">
                                          <button class="save">
                                            Save <i class="ion-checkmark"></i>
                                          </button>
                                          <button class="dismiss">
                                            Dismiss <i class="ion-android-close"></i>
                                          </button>
                                        </div>
                                      </div>

                                    </div>


                            </div> -->


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

      <script src="<?php echo LIBS_JS_PATH; ?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
      <script src="<?php echo LIBS_JS_PATH; ?>simplebar/dist/simplebar.min.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>sidebarmenu.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>theme.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>init.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>jquery.blockUI.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>block-ui.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>toast.js"></script>

      <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
      <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>





</body>


<script>
  const toasts = new Toasts({
    width: 300,
    timing: 'ease',
    duration: '1s',
    dimOld: false,
    position: 'top-right' // top-left | top-center | top-right | bottom-left | bottom-center | bottom-right
  });

  <?php

  if ($message != '') {  ?>
    toasts.push({
      title: 'Success',
      content: '<?php echo $message; ?>',
      style: 'success'
    });

    $('.toast-notification').delay(5000).slideUp('slow');


  <?php } ?>
  // toasts.push({
  //     title: 'Dark Toast',
  //     content: 'Click me to visit CodeShack!',
  //     style: 'dark',
  //     closeButton: false,
  //     link: 'https://codeshack.io',
  //     linkTarget: '_blank',
  //     onOpen: toast => {
  //         console.log(toast);
  //     },
  //     onClose: toast => {
  //         console.log(toast);
  //     }
  // });


  // toasts.push({
  //     title: 'Verified Toast',
  //     content: 'My notification description.',
  //     style: 'verified'
  // });
  //
  // toasts.push({
  //     title: 'Error Toast',
  //     content: 'My notification description.',
  //     style: 'error'
  // });
  //
  // toasts.push({
  //     title: 'Toast',
  //     content: 'My notification description.'
  // });

  // Press SPACE to add a custom toast
  // window.onkeyup = event => {
  //     if (event.key == ' ') {
  //         toasts.push({
  //             title: 'Custom ' + (toasts.numToasts+1),
  //             content: 'Custom description ' + (toasts.numToasts+1) + '.'
  //         });
  //     }
  // };
</script>

</html>