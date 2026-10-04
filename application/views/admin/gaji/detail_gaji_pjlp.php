<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
    <?php $this->load->view('master/meta'); ?>

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
                                    <h4 class="fw-semibold mb-8">Account Setting</h4>
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item">
                                                <a class="text-muted text-decoration-none" href="../main/index.html">Home</a>
                                            </li>
                                            <li class="breadcrumb-item" aria-current="page">Account Setting</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5">
                                        <img src="../assets/images/breadcrumb/ChatBc.png" alt="modernize-img" class="img-fluid mb-n4" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative rounded-0  d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab" aria-controls="pills-account" aria-selected="false">
                                    <i class="ti ti-user-circle me-2 fs-6"></i>
                                    <span class="d-none d-md-block">Data Diri</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-notifications-tab" data-bs-toggle="pill" data-bs-target="#pills-notifications" type="button" role="tab" aria-controls="pills-notifications" aria-selected="false">
                                    <i class="ti ti-bell me-2 fs-6"></i>
                                    <span class="d-none d-md-block">Absensi</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-bills-tab" data-bs-toggle="pill" data-bs-target="#pills-bills" type="button" role="tab" aria-controls="pills-bills" aria-selected="true">
                                    <i class="ti ti-article me-2 fs-6"></i>
                                    <span class="d-none d-md-block">Gaji</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-3" id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-security" type="button" role="tab" aria-controls="pills-security" aria-selected="false">
                                    <i class="ti ti-lock me-2 fs-6"></i>
                                    <span class="d-none d-md-block">Security</span>
                                </button>
                            </li>
                        </ul>
                        <div class="card-body">
                            <div class="tab-content" id="pills-tabContent">
                                <div class="tab-pane fade" id="pills-account" role="tabpanel" aria-labelledby="pills-account-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-6 d-flex align-items-stretch">
                                            <div class="card w-100 border position-relative overflow-hidden">
                                                <div class="card-body p-4">
                                                    <h4 class="card-title">Change Profile</h4>
                                                    <p class="card-subtitle mb-4">Change your profile picture from here</p>
                                                    <div class="text-center">
                                                        <img src="../assets/images/profile/user-1.jpg" alt="modernize-img" class="img-fluid rounded-circle" width="120" height="120">
                                                        <div class="d-flex align-items-center justify-content-center my-4 gap-6">
                                                            <button class="btn btn-primary">Upload</button>
                                                            <button class="btn bg-danger-subtle text-danger">Reset</button>
                                                        </div>
                                                        <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6 d-flex align-items-stretch">
                                            <div class="card w-100 border position-relative overflow-hidden">
                                                <div class="card-body p-4">
                                                    <!-- <h4 class="card-title">Change Password</h4>
                                    <p class="card-subtitle mb-4">To change your password please confirm here</p> -->
                                                    <!-- <form>
                                        <div class="mb-3">
                                        <label for="exampleInputPassword1" class="form-label">Current Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword1" value="12345678910">
                                        </div>
                                        <div class="mb-3">
                                        <label for="exampleInputPassword2" class="form-label">New Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword2" value="12345678910">
                                        </div>
                                        <div>
                                        <label for="exampleInputPassword3" class="form-label">Confirm Password</label>
                                        <input type="password" class="form-control" id="exampleInputPassword3" value="12345678910">
                                        </div>
                                    </form> -->
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <?php


                                            $arrayJab = array('keamanan', 'kebersihan', 'pengemudi', 'lainnya');
                                            ?>
                                            <div class="card w-100 border position-relative overflow-hidden mb-0">
                                                <div class="card-body p-4">
                                                    <h4 class="card-title">Personal Details</h4>
                                                    <p class="card-subtitle mb-4">To change your personal detail , edit and save from here</p>
                                                    <form method="post" action="<?php echo base_url(); ?>admin/pegawai/update_data_pegawai_pjlp/<?php echo $pegawai[0]->id; ?>">
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="exampleInputtext" class="form-label">Nama Lengkap</label>
                                                                    <input type="text" class="form-control" name="nama" value="<?php echo $pegawai[0]->nama; ?>" id="exampleInputtext" placeholder="Mathew Anderson">
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label">Lokasi Tugas</label>
                                                                    <select class="form-select" aria-label="Default select example" name="puskesmas">
                                                                        <?php
                                                                        foreach ($list_puskesmas as $pkm) {
                                                                            $puskesmas = $pkm->nama;
                                                                            if ($puskesmas == $pegawai[0]->lokasi_kerja) {
                                                                                $sel = 'selected';
                                                                            } else {
                                                                                $sel = '';
                                                                            }

                                                                            echo '  <option value="' . $puskesmas . '" ' . $sel . '>' . $puskesmas . '</option>';
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="exampleInputtext3" class="form-label">No Telpon</label>
                                                                    <input type="text" class="form-control" id="exampleInputtext3" value="<?php echo $pegawai[0]->no_tlp; ?>" name="no_tlp" placeholder="+91 12345 65478">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="exampleInputtext4" class="form-label">Alamat</label>
                                                                    <input type="text" class="form-control" id="exampleInputtext4" name="alamat" placeholder="jl. swadaya no 10" value="<?php echo $pegawai[0]->alamat; ?>">
                                                                </div>
                                                            </div>


                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jabatan</label>
                                                                    <select class="form-select" name="jabatan" aria-label="Default select example">

                                                                        <?php
                                                                        for ($j = 0; $j < 4; $j++) {
                                                                            $jab = $arrayJab[$j];
                                                                            echo '<option value="' . $jab . '">Petugas ' . $jab . '</option>';
                                                                        }
                                                                        ?>

                                                                    </select>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputtext2" class="form-label">ID PJLP</label>
                                                                            <input type="text" class="form-control" id="exampleInputtext2" name="id_pjlp" value="<?php echo $pegawai[0]->id_pjlp; ?>" placeholder="Maxima Studio">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputtext2" class="form-label">ID Mesin</label>
                                                                            <input type="text" class="form-control" id="exampleInputtext2" name="id_mesin" value="<?php echo $pegawai[0]->id_mesin; ?>" placeholder="Maxima Studio">
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputtext2" class="form-label">TMT</label>
                                                                            <input type="text" class="form-control" id="exampleInputtext2" name="tmt" value="<?php echo $pegawai[0]->tmt; ?>" placeholder="tgl masuk">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputtext2" class="form-label">Gaji Pokok</label>
                                                                            <input type="text" class="form-control" id="exampleInputtext2" name="gaji_pokok" value="<?php echo $pegawai[0]->gaji_pokok; ?>" placeholder="2.500.000">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputtext2" class="form-label">No Rekening</label>
                                                                            <input type="text" class="form-control" id="no_rekening" name="no_rekening" value="<?php echo $pegawai[0]->no_rekening; ?>" placeholder="212526332xx">
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-6">
                                                                        <div class="mb-3">
                                                                            <label for="exampleInputtext2" class="form-label">NPWP</label>
                                                                            <input type="text" class="form-control" id="npwp" name="npwp" value="<?php echo $pegawai[0]->npwp; ?>" placeholder="125352.2023320-0000">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>

                                                            <div class="col-12">
                                                                <div>

                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="d-flex align-items-center justify-content-end mt-4 gap-6">
                                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                                    <button class="btn bg-danger-subtle text-danger">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-notifications" role="tabpanel" aria-labelledby="pills-notifications-tab" tabindex="0">
                                    <div class="row justify-content-center">
                                        <div class="col-lg-9">
                                            <div class="card border shadow-none">
                                                <div class="card-body p-4">
                                                    <h4 class="card-title">Notification Preferences</h4>
                                                    <p class="card-subtitle mb-4">
                                                        Select the notificaitons ou would like to receive via email. Please note that you cannot opt
                                                        out of receving service
                                                        messages, such as payment, security or legal notifications.
                                                    </p>
                                                    <form class="mb-7">
                                                        <label for="exampleInputtext5" class="form-label">Email Address*</label>
                                                        <input type="text" class="form-control" id="exampleInputtext5" placeholder="" required>
                                                        <p class="mb-0">Required for notificaitons.</p>
                                                    </form>
                                                    <div>
                                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                    <i class="ti ti-article text-dark d-block fs-7" width="22" height="22"></i>
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-4 fw-semibold">Our newsletter</h5>
                                                                    <p class="mb-0">We'll always let you know about important changes</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-check form-switch mb-0">
                                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                    <i class="ti ti-checkbox text-dark d-block fs-7" width="22" height="22"></i>
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-4 fw-semibold">Order Confirmation</h5>
                                                                    <p class="mb-0">You will be notified when customer order any product</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-check form-switch mb-0">
                                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked1" checked>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                    <i class="ti ti-clock-hour-4 text-dark d-block fs-7" width="22" height="22"></i>
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-4 fw-semibold">Order Status Changed</h5>
                                                                    <p class="mb-0">You will be notified when customer make changes to the order</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-check form-switch mb-0">
                                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked2" checked>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between mb-4">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                    <i class="ti ti-truck-delivery text-dark d-block fs-7" width="22" height="22"></i>
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-4 fw-semibold">Order Delivered</h5>
                                                                    <p class="mb-0">You will be notified once the order is delivered</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-check form-switch mb-0">
                                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked3">
                                                            </div>
                                                        </div>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                    <i class="ti ti-mail text-dark d-block fs-7" width="22" height="22"></i>
                                                                </div>
                                                                <div>
                                                                    <h5 class="fs-4 fw-semibold">Email Notification</h5>
                                                                    <p class="mb-0">Turn on email notificaiton to get updates through email</p>
                                                                </div>
                                                            </div>
                                                            <div class="form-check form-switch mb-0">
                                                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked4" checked>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="card border shadow-none">
                                                <div class="card-body p-4">
                                                    <h4 class="card-title">Date & Time</h4>
                                                    <p class="card-subtitle">Time zones and calendar display settings.</p>
                                                    <div class="d-flex align-items-center justify-content-between mt-7">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-clock-hour-4 text-dark d-block fs-7" width="22" height="22"></i>
                                                            </div>
                                                            <div>
                                                                <p class="mb-0">Time zone</p>
                                                                <h5 class="fs-4 fw-semibold">(UTC + 02:00) Athens, Bucharet</h5>
                                                            </div>
                                                        </div>
                                                        <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle" href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download">
                                                            <i class="ti ti-download"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-9">
                                            <div class="card border shadow-none">
                                                <div class="card-body p-4">
                                                    <h4 class="card-title">Ignore Tracking</h4>
                                                    <div class="d-flex align-items-center justify-content-between mt-7">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-player-pause text-dark d-block fs-7" width="22" height="22"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="fs-4 fw-semibold">Ignore Browser Tracking</h5>
                                                                <p class="mb-0">Browser Cookie</p>
                                                            </div>
                                                        </div>
                                                        <div class="form-check form-switch mb-0">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked5">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-end gap-6">
                                                <button class="btn btn-primary">Save</button>
                                                <button class="btn bg-danger-subtle text-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade  show active" id="pills-bills" role="tabpanel" aria-labelledby="pills-bills-tab" tabindex="0">
                                    <div class="row justify-content-center">


                                        <?php

                                        if (!empty($DataRekapGaji)) {
                                            $periode = date('F Y', strtotime($DataRekapGaji[0]->periode));
                                            $id_gaji = $DataRekapGaji[0]->id;
                                            $capaian = $DataRekapGaji[0]->capaian;
                                            $bruto = $DataRekapGaji[0]->bruto;
                                            $gaji_pokok = $DataRekapGaji[0]->gaji_pokok;
                                            $pph21 = $DataRekapGaji[0]->pph21;
                                            $bpjs = $DataRekapGaji[0]->bpjs;
                                            $bpjs_tk = $DataRekapGaji[0]->bpjs_tk;
                                            $thp = $DataRekapGaji[0]->thp;
                                        } else {
                                            $periode = '';
                                            $capaian = 0;
                                            $bruto = 0;
                                            $pph21 = 0;
                                            $bpjs = 0;
                                            $bpjs_tk = 0;
                                            $thp = 0;
                                            $id_gaji = 0;
                                            $gaji_pokok = 0;
                                        }


                                        ?>
                                        <div class="col-lg-9">
                                            <div class="card border shadow-none">
                                                <div class="card-body p-4">
                                                    <h4 class="card-title">Periode : <span class="text-success"><?php echo $periode; ?></span>
                                                    </h4>

                                                    <div class="d-flex align-items-center justify-content-between mt-7 mb-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                                                <i class="ti ti-package text-dark d-block fs-7" width="22" height="22"></i>
                                                            </div>
                                                            <div>
                                                                <p class="mb-0">Total Gaji (THP)</p>
                                                                <h5 class="fs-4 fw-semibold">Rp. <?php echo rupiah($thp); ?></h5>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <table class="table">
                                                                    <tr>
                                                                        <td>Gaji Pokok</td>
                                                                        <td><?php echo rupiah($gaji_pokok); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Capaian</td>
                                                                        <td><?php echo $capaian; ?>%</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Bruto</td>
                                                                        <td><?php echo rupiah($bruto); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>pph21</td>
                                                                        <td><?php echo rupiah($pph21); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>BPJS Kesehatan</td>
                                                                        <td><?php echo rupiah($bpjs); ?></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>BPJS TK</td>
                                                                        <td><?php echo rupiah($bpjs_tk); ?></td>
                                                                    </tr>
                                                                </table>

                                                            </div>
                                                        </div>




                                                    </div>

                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                                <div class="tab-pane fade" id="pills-security" role="tabpanel" aria-labelledby="pills-security-tab" tabindex="0">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="card border shadow-none">
                                                <div class="card-body p-4">
                                                    <h4 class="card-title mb-3">Two-factor Authentication</h4>
                                                    <div class="d-flex align-items-center justify-content-between pb-7">
                                                        <p class="card-subtitle mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis sapiente
                                                            sunt earum officiis laboriosam ut.</p>
                                                        <button class="btn btn-primary">Enable</button>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between py-3 border-top">
                                                        <div>
                                                            <h5 class="fs-4 fw-semibold mb-0">Authentication App</h5>
                                                            <p class="mb-0">Google auth app</p>
                                                        </div>
                                                        <button class="btn bg-primary-subtle text-primary">Setup</button>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between py-3 border-top">
                                                        <div>
                                                            <h5 class="fs-4 fw-semibold mb-0">Another e-mail</h5>
                                                            <p class="mb-0">E-mail to send verification link</p>
                                                        </div>
                                                        <button class="btn bg-primary-subtle text-primary">Setup</button>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between py-3 border-top">
                                                        <div>
                                                            <h5 class="fs-4 fw-semibold mb-0">SMS Recovery</h5>
                                                            <p class="mb-0">Your phone number or something</p>
                                                        </div>
                                                        <button class="btn bg-primary-subtle text-primary">Setup</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body p-4">
                                                    <div class="text-bg-light rounded-1 p-6 d-inline-flex align-items-center justify-content-center mb-3">
                                                        <i class="ti ti-device-laptop text-primary d-block fs-7" width="22" height="22"></i>
                                                    </div>
                                                    <h4 class="card-title mb-0">Devices</h4>
                                                    <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit Rem.</p>
                                                    <button class="btn btn-primary mb-4">Sign out from all devices</button>
                                                    <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <i class="ti ti-device-mobile text-dark d-block fs-7" width="26" height="26"></i>
                                                            <div>
                                                                <h5 class="fs-4 fw-semibold mb-0">iPhone 14</h5>
                                                                <p class="mb-0">London UK, Oct 23 at 1:15 AM</p>
                                                            </div>
                                                        </div>
                                                        <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle" href="javascript:void(0)">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-between py-3">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <i class="ti ti-device-laptop text-dark d-block fs-7" width="26" height="26"></i>
                                                            <div>
                                                                <h5 class="fs-4 fw-semibold mb-0">Macbook Air</h5>
                                                                <p class="mb-0">Gujarat India, Oct 24 at 3:15 AM</p>
                                                            </div>
                                                        </div>
                                                        <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle" href="javascript:void(0)">
                                                            <i class="ti ti-dots-vertical"></i>
                                                        </a>
                                                    </div>
                                                    <button class="btn bg-primary-subtle text-primary w-100 py-1">Need Help ?</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-flex align-items-center justify-content-end gap-6">
                                                <button class="btn btn-primary">Save</button>
                                                <button class="btn bg-danger-subtle text-danger">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

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


        <script src="<?php echo NEW_JS_PATH; ?>prettify.js"></script>
        <script src="<?php echo NEW_JS_PATH; ?>jquery.js"></script>


</body>




<script>
    $('.btn-info').click(function() {
        $(".table-data").addClass('d-none');
        $(".table-edit").removeClass('d-none');

    });

    $('#update_pegawai').submit(function() {

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(data) {
                //window.location.reload();
                open_notification();
            }
        })
        return false;
    });





    function open_notification() {
        var x = document.getElementById("snackbar");
        x.className = "show";
        setTimeout(function() {
            x.className = x.className.replace("show", "");
        }, 3000);
    }
</script>

</html>