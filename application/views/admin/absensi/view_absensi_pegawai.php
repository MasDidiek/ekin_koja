<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <style>
        .btn-xs{
            padding:3px 6px !important;
        }

        .modal-dialog{
            z-index:999;
        }

        .badge-status{
            padding: 2px 5px;
            font-size: 12px;
            color: #FFF;
        }
       .bg-danger-subtle{
        background-color: #fff8f8;
        color: #cc6060;
       }

    </style>
    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":true, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('layout/section/sidebar');?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view('layout/section/topbar');?>

                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Main Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Data Absensi</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php
                                $nm_bulan = getBulan($bulan);
                                $pin = $this->uri->segment(4);
                                $id_pegawai = $detailPegawai->id_pegawai;
                                $id_puskesmas = $detailPegawai->id_puskesmas;

                                $ip_address = $this->Master_model->getIpAddress($id_puskesmas);

                                // $absensi_raw    = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);

                                //print_array($detailPegawai);


                                 //$ip_address = $this->Master_model->getIpAddress($id_puskesmas);

                                if (!empty($dataRekap)) {

                                    $id_rekap = $dataRekap[0]->id;
                                    $status = $dataRekap[0]->status;
                                    
                                    $telat = $dataRekap[0]->telat;
                                    $alpha = $dataRekap[0]->alpha;
                                    $pulang_awal = $dataRekap[0]->pulang_awal;
                                    $sakit = $dataRekap[0]->sakit;
                                    $sakit_dgn_dk = $dataRekap[0]->sakit_dgn_sk;
                                    $izin = $dataRekap[0]->izin;
                                    $cuti = $dataRekap[0]->cuti;
                        
                                    if($status==0){
                                        $status_absen = '<div class="badge badge-warning-lighten">
                                                            <i class="uil-shield-question text-warning"></i>   Data absensi belum sesuai
                                                        </div> ';
                                    }else{
                                        $status_absen = '<div class="badge badge-success-lighten">
                                                            <i class="uil-shield-check text-success"></i>   Data absensi sudah sesuai.
                                                        </div>';
                                    }

                        
                            }else{
                                    $id_rekap =  0;
                                    $telat = '-';
                                    $pulang_awal = '-';
                                     $alpha = 0;
                                    $sakit =  '-';
                                    $izin =  '-';
                                    $cuti = '-';
                                    $sakit_dgn_dk = 0;
                                    $status=0;
                                    $status_absen = '<div class="badge badge-danger-lighten">
                                                    <i class="uil-exclamation-circle  text-danger"></i> <span class="font-bold">Warning!</span>  Data absensi Belum direkap.
                                                </div>';
                            
                            }
                        ?>
                        <div class="row">

                        

                            <div class="col-xxl-3 col-lg-6">
                                
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                         <a href="<?php echo base_url();?>admin/absensi/rekap_absensi" class="btn btn-light float-start">
                                        <i class="mdi mdi-arrow-left"></i> Kembali</a>
                                        <div class="clearfix"></div>
                                       
                                    
                                        <div class="row">
                                             <div class="col-md-3">
                                                   
                                                <div style="font-size:80px">
                                                    <i class="mdi mdi-account-box"></i>
                                                </div>
                                            </div>
                                             <div class="col-md-8 pb-2"> 
                                                <br>
                                                <h4 class="mb-1"><a href="#!" class="text-dark"><?php echo $detailPegawai->nama;?></a></h4>
                                                <p class="font-13"><a href="#!"  class="text-secondary"><?php echo $detailPegawai->nip;?></a></p>

                                                <strong><?php echo $detailPegawai->jabatan;?></strong> <br>
                                                <?php echo $detailPegawai->puskesmas;?>
                                               
                                             </div>

                                             <hr>

                                             <div class="mb-3">
                                                <div class="row">
                                                    <div class="col-md-7">  <strong> Periode : <?php echo  $nm_bulan.' &nbsp; '.$tahun;?> </strong></div>
                                                    <div class="col-md-5"><?php echo  $status_absen;?></div>
                                                </div>
                                               
                                             </div>

                                             <h5>Rekap Absensi</h5>
                                             <div class="chart-widget-list mb-4">
                                                    <p>
                                                        <i class="mdi mdi-square text-primary"></i> Terlambat
                                                        <span class="float-end"><?php echo $telat;?> &nbsp;  Menit</span>
                                                    </p>
                                                    <p>
                                                        <i class="mdi mdi-square text-primary"></i> Pulang Awal
                                                        <span class="float-end"><?php echo $pulang_awal;?> &nbsp;  Menit</span>
                                                    </p>
                                                       <p>
                                                        <i class="mdi mdi-square text-danger"></i> Alpha
                                                        <span class="float-end"><?php echo $alpha;?> &nbsp;  Hari</span>
                                                    </p>
                                                    <p>
                                                        <i class="mdi mdi-square text-warning"></i> Sakit
                                                        <span class="float-end"><?php echo $sakit;?> &nbsp;  Hari</span>
                                                    </p>
                                                    <p>
                                                        <i class="mdi mdi-square text-warning"></i> Sakit Dengan Surat
                                                        <span class="float-end"><?php echo $sakit_dgn_dk;?> &nbsp;  Hari</span>
                                                    </p>
                                                    <p>
                                                        <i class="mdi mdi-square text-warning"></i> Izin
                                                        <span class="float-end"><?php echo $izin;?> &nbsp;  Hari</span>
                                                    </p>
                                                    <p>
                                                        <i class="mdi mdi-square text-success"></i> Cuti
                                                        <span class="float-end"><?php echo $cuti;?> &nbsp;  Hari</span>
                                                    </p>
                                                </div>

                                             <h5 class="text-success">Data Cuti</h5>
                                             <div class="col-md-12"> 

                                                    
                                        
                                                <?php 
                                                    if(empty($cuti_pegawai)){
                                                        echo '<div class="alert text-muted">--Tidak ada Pengajuan Cuti--</div>';
                                                    }
                                                foreach ($cuti_pegawai as $cuti): ?>

                                                        <?php
                                                            $tgl_dari   = $cuti->tgl_mulai;
                                                            $tgl_sampai = $cuti->tgl_selesai;
                                                            $hari_cuti  = $cuti->lama_cuti;
                                                            $id_cuti    = $cuti->id;

                                                            $nama_jenis_cuti = $cuti->nama_jenis_cuti;
                                                            $status_akhir    = $cuti->status_akhir;

                                                            $getRoleAccApproval = $this->acm->get_last_status_approval_cuti($id_cuti);
                                                           


                                                            // badge status
                                                            if ($status_akhir === 'disetujui') {
                                                                $badge_class = 'badge-success-lighten';
                                                                $icon        = 'uil-check text-success';
                                                                $status_tampilan = 'Disetujui';
                                                            } elseif ($status_akhir === 'proses') {
                                                                $badge_class = 'badge-warning-lighten';
                                                                $icon        = 'uil-clock text-warning';
                                                                $status_tampilan = 'Menunggu ACC '. $getRoleAccApproval;
                                                            } else {
                                                                $badge_class = 'badge-secondary-lighten';
                                                                $icon        = 'uil-info-circle';
                                                                 $status_tampilan = '';
                                                            }


                                                            // format tanggal ringkas
                                                            $periodeCuti = format_full($tgl_dari);
                                                            if ($tgl_dari !== $tgl_sampai) {
                                                                $periodeCuti .= ' s/d ' . format_full($tgl_sampai);
                                                            }


                                                        ?>

                                                        <div class="mb-3">

                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <div>
                                                                    <div class="fw-bold fs-5">
                                                                        <i class="uil-calendar-alt"></i> <?= $periodeCuti; ?>
                                                                    </div>

                                                                    <div class="text-muted">
                                                                        <?= $nama_jenis_cuti; ?> · <?= $hari_cuti; ?> hari
                                                                    </div>

                                                                    <div class="mt-1">
                                                                        <span class="badge <?= $badge_class; ?>">
                                                                            <i class="uil <?= $icon; ?>"></i>
                                                                             <?= $status_tampilan; ?>
                                                                        </span>
                                                                    </div>
                                                                </div>

<!--                                                                 
                                                                <br>

                                                                <button type="button" 
                                                                        data-id="<?= $id_cuti; ?>" 
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal-info-absen"
                                                                        class="btn btn-sm btn-primary view-detail-cuti">
                                                                            <i class="mdi mdi-eye-outline"></i> Detail
                                                                </button> -->

                                                                <a href="<?php echo base_url();?>admin/absensi/update_absensi_cuti/<?= $pin.'/'.$cuti->id.'/'.$bulan.'/'.$tahun ?>" class="btn btn-info btn-sm">
                                                                    Update
                                                                </a>
                                                            </div>

                                                        </div>

                                                        <hr>

                                                        <?php endforeach; ?>

                                                        <div class="clearfix"></div>
                                                        <br>

                                                          <h4 class="header-title mb-3">Dinas Luar</h4>
                                                           <div data-simplebar="" style="max-height: 500px; overflow-x: hidden;">
                                                        
                                                            
                                                    
                                                            <?php
                                                                if(empty($DinasLuar)){
                                                                    echo '<div class="alert alert-info">Tidak ada Pengajuan Dinas Luar</div>';

                                                                }else{
                                                                    for ($d=0; $d < count($DinasLuar); $d++) { 
                                                                        $tanggal_dl = $DinasLuar[$d]->tanggal;
                                                                        $id_dl = $DinasLuar[$d]->id;
                                                                        $jns_dl = $DinasLuar[$d]->jns_dl;
                                                                        $photo_dl = $DinasLuar[$d]->photo;
                                                                        $keterangan_dl = $DinasLuar[$d]->keterangan;
                                                                        $lat = $DinasLuar[$d]->lat;
                                                                        $lon = $DinasLuar[$d]->lon;
                                                                        $status_dl = $DinasLuar[$d]->status;
                                                                    
                
                
                
                                                                        if($status_dl==1){
                                                                            $flag_status_dl = '<div class="badge badge-success-lighten">
                                                                            <i class="uil-check text-success"></i>   Disetujui
                                                                            </div> ';
                                                                        }else{
                                                                            $flag_status_dl = '<div class="badge badge-warning-lighten">
                                                                            <i class="uil-question text-warning"></i> Pending
                                                                            </div>';
                                                                        }

                                                                        switch ($jns_dl) {
                                                                            case 'DLP':
                                                                                $jenis_dl = 'DL-PENUH';
                                                                                break;
                                                                            case 'DLA':
                                                                                $jenis_dl = 'DL-AWAL';
                                                                                break;
                                                                            
                                                                            default:
                                                                               $jenis_dl = 'DL-AKHIR';
                                                                                break;
                                                                        }
                
                                                                        echo '
                                                                            <div class="row py-1 ">
                                                                                    <div class="col-12 fw-bold pe-2"> '.$jenis_dl.' </div>
                                                                                    <div class="col-12 ps-2">
                                                                                        <a href="javascript:void(0);" class="text-body">'.$keterangan_dl.'</a>
                                                                                        <p class="mb-0 text-muted"><small>'.format_full($tanggal_dl).'</small></p>
                                                                                        '.$flag_status_dl.'
                                                                                    </div>
                                                                                    <div class="col-12 mt-3">
                                            
                                                                                        <a href="'. base_url().'admin/absensi/insertAbsenPengajuanDL/'.$id_dl.'/'.$pin.'/'.$bulan.'/'.$tahun.'" class="btn btn-sm btn-info fw-bold" title="update absensi Dinas luar">
                                                                                            <i class="uil-upload fw-bold  fs-5"></i> Sinkron
                                                                                        </a>
                                                                                         <a href="'. base_url().'admin/absensi/viewAbsenPengajuanDL/'.$id_dl.'/'.$pin.'/'.$bulan.'/'.$tahun.'" class="btn btn-sm btn-info fw-bold" title="View absensi Dinas luar">
                                                                                            <i class="uil-eye fw-bold  fs-5"></i> Detail
                                                                                        </a>
                                                                                         <a href="'. base_url().'admin/absensi/deleteAbsenPengajuanDL/'.$id_dl.'/'.$pin.'/'.$bulan.'/'.$tahun.'" class="btn btn-sm btn-danger fw-bold" title="delete absensi Dinas luar">
                                                                                            <i class="uil-trash fw-bold  fs-5"></i> 
                                                                                        </a>
                                                                                        
                                                                                    </div>
                                                                                </div>
                                                                            
                                                                        
                                                                            <hr>';
                                                                    }
                                                                }
                                                            
                                                            ?>
                                                        
                                                            <div class="clearfix"></div>
                                                            <br>
                                                            <h4 class="header-title mb-3">IZIN / SAKIT</h4>
                                                           <div data-simplebar="" style="max-height: 500px; overflow-x: hidden;">
                                                        
                                                            
                                                    
                                                            <?php
                                                                if(empty($IzinSakit)){
                                                                    echo '<div class="alert alert-info">Tidak ada Pengajuan Izin / Sakit</div>';

                                                                }else{

                                                                 foreach ($IzinSakit as $is) {


                                                                        $jenis_absen = $is->jenis_absen;
                                                                        $jns_izin = $is->jns_izin;
                                                                        $jns_sakit = $is->jns_sakit;
                                                                        $file_image = $is->file_image;
                                                                        $status = $is->status;
                
                                                                        if($jns_izin==1){
                                                                            $flag_status_izin = '<div class="badge badge-success-lighten">
                                                                            <i class="uil-check text-success"></i>   FULL
                                                                            </div> ';
                                                                        }else if($jns_izin==2){
                                                                             $flag_status_izin = '<div class="badge badge-success-lighten">
                                                                            <i class="uil-check text-warning"></i>   IZIN AWAL
                                                                            </div> ';
                                                                        }else{
                                                                            $flag_status_izin = '<div class="badge badge-warning-lighten">
                                                                            <i class="uil-question text-warning"></i> IZIN AKHIR
                                                                            </div>';
                                                                        }


                                                                        if($jns_sakit==1){
                                                                            $flag_jns_sakit = '<div class="badge badge-warning-lighten">
                                                                            <i class="uil-question text-warning"></i> Tanpa Surat Keterangan
                                                                            </div>';
                                                                        }else{
                                                                            $flag_jns_sakit = '<div class="badge badge-warning-lighten">
                                                                            <i class="uil-question text-warning"></i> Dengan Surat Keterangan
                                                                            </div>';
                                                                        }


                                                                        
                                                                        if($jenis_absen=='IZIN'){
                                                                            $status_detail_abensi = $flag_status_izin;
                                                                        }else{
                                                                            $status_detail_abensi = $flag_jns_sakit;
                                                                        }
                
                                                                        echo '
                                                                              <div class="row">
                                                                                   
                                                                                    <div class="col-md-12">
                                                                                     '.$jenis_absen.' <br> '.$status_detail_abensi.'
                                                                                    <p>'.$is->keterangan.'<br>
                                                                                        
                                                                                        <small>'.format_full($is->tanggal).'</small>
                                                                                          
                                                                                  
                                                                                     </p>
                                                                                        <a href="'. base_url().'admin/absensi/insertAbsenPengajuanIzinSakit/'.$is->id.'/'.$pin.'/'.$bulan.'/'.$tahun.'" class="btn btn-sm btn-primary fw-bold" title="update absensi pengajuan izin sakit">
                                                                                            <i class="uil-upload fw-bold"></i> Sinkron
                                                                                        </a>
                                                                                          <a href="'. base_url().'uploads/surat_izin/'.$file_image.'" class="btn btn-sm btn-success fw-bold" title="update absensi Dinas luar" target="_blank">
                                                                                            <i class="uil-upload fw-bold"></i> Detail
                                                                                        </a>
                                                                                    </div>
                                                                                </div>
                                                                            
                                                                        
                                                                            <hr>';
                                                                    }
                                                                }
                                                            
                                                            ?>
                                                           </div>
                                                            <div class="clearfix"></div>
                                                            <br>


                                                                                       
                                                        </div>

                                             </div>
                                            

                                        <a href="<?php echo base_url();?>admin/absensi/view_raw_absensi/<?php echo $pin.'/'.$ip_address.'/'.$bulan.'/'.$tahun.'/'.$detailPegawai->jns_pegawai;?>" target="_blank" class="mt-3 btn btn-info">
                                        <i class="mdi mdi-update"></i> Lihat Data Absensi</a>
                                                
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-9 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data Kehadiran</h4>
                                        <br>

                                        <?php
//print_array($detailPegawai);//
                                        ?>


                                        <a href="<?php echo base_url();?>admin/absensi/update_rekap_absensi/<?php echo $id_pegawai.'/'.$pin.'/'.$bulan.'/'.$tahun;?>" class="btn btn-info">
                                        <i class="mdi mdi-update"></i> Update Rekap</a>

                                        <!-- <a href="<?php echo base_url();?>admin/absensi/update_shift/<?php //echo $pin.'/'.$bulan.'/'.$tahun.'/'.$detailPegawai->jns_jam_kerja;?>" class="btn btn-light float-end">
                                        <i class="mdi mdi-update"></i> Update Shift</a> -->

                                        <button type="button"  class="btn btn-light float-end" data-bs-toggle="modal" data-bs-target="#modal-choose-template-shift"> 
                                            <i class="mdi mdi-update"></i>  Update Shift
                                        </button>
                                        
                                        <a href="<?php echo base_url();?>admin/absensi/sinkron_absensi/<?php echo $id_pegawai.'/'.$pin.'/'.$bulan.'/'.$tahun.'/'.$ip_address;?>" class="btn btn-warning  float-end me-2">
                                            <i class="mdi mdi-download"></i> Sinkron Absensi
                                        </a>


                                         <table class="table mt-4 table-bordered table-sm text-center">
                                                <thead>
                                                <tr>
                                                    <th>Tanggal</th>
                                                    <th class="text-center">Hari</th>
                                                    <th>Shift</th>
                                                    <th>Jam Masuk</th>
                                                    <th>Jam Pulang</th>
                                                    <th>Telat</th>
                                                    <th>Pulang Awal</th>
                                                    <th>Status</th>
                                                    <th>Status Detail</th>
                                                    <th>Keterangan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $total_telat = 0;
                                                $total_pulang_awal = 0;

                                                ?>
                                                <?php if (!empty($absensi)) : ?>
                                                    <?php foreach ($absensi as $row) : ?>

                                                        <?php 

                                                       // print_array($row);
                                                        $hari = getNamahari($row->tanggal); 
                                                        $class_tr = ($hari == 'Sabtu' || $hari == 'Minggu') ? 'bg-danger-subtle' : '';

                                                      
                                                        $status = $row->status;
                                                        $status_detail = $row->status_detail;
                                                        $jam_masuk  = $row->jam_masuk ;
                                                        $jam_pulang = $row->jam_pulang;


                                                        $telat  =  $row->telat_menit ;
                                                        $p_awal =  $row->p_awal_menit ;

                                                         
                                                        $flag_status = $status;
                                                        $badge_class = '';
                                                        $badge_status_class = '';

                                                        switch ($status) {


                                                            case 'OFF':
                                                                $badge_class = 'bg-light text-secondary';
                                                                $badge_status_class = 'text-muted';
                                                                break;

                                                            case 'CUTI':
                                                                $badge_class = 'bg-success';
                                                                $badge_status_class = 'bg-success';
                                                                break;

                                                            case 'SAKIT':
                                                            case 'IZIN':
                                                                $badge_class = 'bg-warning';
                                                                $badge_status_class = 'bg-warning';
                                                                break;

                                                            case 'DINAS':
                                                                $badge_class = 'bg-primary';
                                                                $badge_status_class = 'bg-primary';
                                                                break;

                                                            case 'ALPHA':
                                                                $badge_status_class = 'bg-danger';
                                                                break;

                                                            case 'TELAT':
                                                                $badge_status_class = 'text-warning';
                                                                break;

                                                            case 'HADIR':
                                                                $badge_status_class = 'text-success';
                                                                break;
                                                        }

                                                        // Badge untuk jam masuk & pulang (jika status khusus)
                                                        if (in_array($status, ['CUTI','SAKIT','IZIN','DINAS'])) {

                                                            if($row->status_detail=='DLA'){
                                                                $jam_masuk  = '<span class="badge '.$badge_class.'">'.$status.'</span>';
                                                            }else if($row->status_detail=='DLAK'){
                                                                $jam_pulang = '<span class="badge '.$badge_class.'">'.$status.'</span>';
                                                            }else{
                                                                $jam_masuk  = '<span class="badge '.$badge_class.'">'.$status.'</span>';
                                                                $jam_pulang = '<span class="badge '.$badge_class.'">'.$status.'</span>';
                                                            }
                                                               


                                                        }



                                                        // Badge status kolom status
                                                        $flag_status = '<button type="button"  class="btn badge-status edit-absen '.$badge_status_class.'" data-id="'.$row->tanggal.'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm">'.$status.'</button>';

                                                        if($status_detail=='LIBUR NASIONAL'){
                                                            $jam_masuk  = '<span class="text-uccess">-</span>';
                                                            $jam_pulang  = '<span class="text-success">-</span>';
                                                        }

                                                         $class_shift = 'text-info';
                                                        if($row->shift=='OFF'){
                                                             $jam_masuk  = '<span >-</span>';
                                                                $jam_pulang = '<span >-</span>';
                                                                $class_shift = 'text-danger';
                                                        }

                                                        // if($status == 'HADIR') {
                                                        //     $telat = empty($row->jam_masuk) ? 300 : $row->telat_menit;
                                                        //     $p_awal = empty($row->jam_pulang) ? 150 : $row->p_awal_menit;

                                                            
                                                        // }

                                                        $total_telat += $telat;
                                                        $total_pulang_awal += $p_awal;

                                                        ?>

                                                        <tr class="<?= $class_tr ?>">
                                                            <td><?= date('d, M', strtotime($row->tanggal)) ?></td>
                                                            <td><?= $hari ?></td>
                                                           <td class="fw-bold <?= $class_shift ?>">
                                                            <?= $row->shift ?>
                                                            
                                                            <?php if($row->shift != 'OFF'): ?>
                                                                <i class="mdi mdi-help-circle-outline float-end text-primary"
                                                                data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Jam Kerja : <?= $row->jam_shift_masuk ?> 
                                                                     -  <?= $row->jam_shift_pulang ?>">
                                                                </i>
                                                            <?php endif; ?>
                                                        </td>

                                                            <?php if (isset($row->status)) : ?>
                                                              <td class="editable-time" 
                                                                    data-id="<?= $row->id ?>" 
                                                                    data-field="jam_masuk">
                                                                    <?= $jam_masuk ?>
                                                                </td>

                                                                <td class="editable-time" 
                                                                    data-id="<?= $row->id ?>" 
                                                                    data-field="jam_pulang">
                                                                    <?= $jam_pulang ?>
                                                                </td>
                                                                <td><?= $telat?></td>
                                                                <td><?= $p_awal ?></td>
                                                                <td><?= $flag_status?></td>
                                                                <td class="fw-bold <?= $class_shift ?>"><?= $row->status_detail ?></td>
                                                            <?php else : ?>
                                                                <td><?= $row->masuk ?></td>
                                                                <td>-</td>
                                                                <td class="editable-time" 
                                                                    data-id="<?= $row->id ?>" 
                                                                    data-field="jam_masuk">
                                                                    <?= $jam_masuk ?>
                                                                </td>

                                                                <td class="editable-time" 
                                                                    data-id="<?= $row->id ?>" 
                                                                    data-field="jam_pulang">
                                                                    <?= $jam_pulang ?>
                                                                </td>
                                                                <td><?= $telat ?></td>
                                                                <td><?= $p_awal ?></td>
                                                            <?php endif; ?>
                                                            <td class="text-start"><?= $row->keterangan ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>

                                                    <!-- baris total -->
                                                    <tr class="fw-bold bg-light">
                                                        <td colspan="5" class="text-end">Total:</td>
                                                        <td><?= $total_telat ?> menit</td>
                                                        <td><?= $total_pulang_awal ?> menit</td>
                                                        <td colspan="3"></td>
                                                    </tr>

                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="10" align="center">Tidak ada data</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>

                                       </table>

                                    

                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>    
                     </div>
                  </div> <!-- container -->
                </div> <!-- content -->


                
            <?php
                  $arrayAbsen = ['DL-PENUH', 'DL-AWAL', 'DL-AKHIR', 'IZIN', 'SAKIT', 'SAKIT DGN SURAT'];
            ?>


                <div class="modal fade" id="bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                              <form method="post" action="<?php echo base_url();?>admin/absensi/insert_absen_ketidakhadiran" id="update_shift">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Edit Data Absensi</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">
                                 <!-- Hidden input -->
                                            <input type="hidden" name="pin" id="modal_pin" value="<?= $pin; ?>">
                                            <input type="hidden" name="id_pegawai" id="modal_id_pegawai" value="<?= $id_pegawai; ?>">
                                            <input type="hidden" name="tanggal" id="modal_tanggal">

                                            <!-- Nav Tabs -->
                                            <ul class="nav nav-tabs" id="absensiTab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link active" id="manual-tab" data-bs-toggle="tab"
                                                        data-bs-target="#manual" type="button">
                                                        Input Jam Manual
                                                    </button>
                                                </li>

                                                <li class="nav-item" role="presentation">
                                                    <button class="nav-link" id="status-tab" data-bs-toggle="tab"
                                                        data-bs-target="#dl_izin" type="button">
                                                        Tidak Hadir / Dinas Luar
                                                    </button>
                                                </li>
                                            </ul>

                                            <!-- Tab Content -->
                                            <div class="tab-content mt-3">
                                                    <div class="mb-3">
                                                        <label class="form-label">Tanggal Absensi</label>
                                                        <input type="date" name="tanggal_display" id="modal_tanggal_display"
                                                            class="form-control" readonly>
                                                    </div>

                                                
                                                <!-- TAB 1 : INPUT JAM -->
                                                    <div class="tab-pane fade show active" id="manual">

                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jam Masuk</label>
                                                                    <input type="time" name="jam_masuk" class="form-control">
                                                                </div>
                                                                
                                                            </div>
                                                            <div class="col-6">
                                                            
                                                                <div class="mb-3">
                                                                    <label class="form-label">Jam Pulang</label>
                                                                    <input type="time" name="jam_pulang" class="form-control">
                                                                </div>
                                                            </div>
                                                        </div>
                                                


                                                        <small class="text-muted">
                                                            Isi salah satu atau keduanya jika mesin absensi tidak sinkron.
                                                        </small>

                                                    </div>

                                                <!-- TAB 2 : STATUS -->
                                                    <div class="tab-pane fade" id="dl_izin">

                                                        <div class="mb-3">
                                                            <label class="form-label">Status Absensi</label>
                                                            <select name="status" class="form-select">
                                                                <option value="">-- Pilih Status --</option>
                                                                <?php foreach ($arrayAbsen as $status) : ?>
                                                                    <option value="<?= $status ?>"><?= $status ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label">Keterangan</label>
                                                            <textarea name="keterangan" class="form-control"></textarea>
                                                        </div>

                                                    </div>

                                            </div>

                                        </div>


                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>

                                    </form>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                <div class="modal fade" id="modal-choose-template-shift" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                             
                                <div class="modal-header">
                                    <h4 class="modal-title" id="mySmallModalLabel">Pilih Template Shift Kerja</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                </div>
                                <div class="modal-body">
                                    <table class="table  table-bordered table-sm ">
                                        <thead>
                                            <tr>
                                            <th>No</th>
                                            <th>Nama Template</th>
                                            <th>Bulan</th>
                                            <th>Tahun</th>
                                            <th>Aksi</th>
                                            </tr>
                                        </thead>
                                          

                                        <tbody>

                                            <?php
                                            $no = 1;
                                            foreach($template as $t): ?>

                                            <tr>
                                                <td><?= $no++ ?></td>
                                                <td><?= $t->nama_template ?></td>
                                                <td><?= $t->bulan ?></td>
                                                <td><?= $t->tahun ?></td>
                                                <td>
                                                    <a href="<?= base_url('admin/absensi/update_shift/'.$t->id.'/'.$pin.'/'.$bulan.'/'.$tahun.'/'.$detailPegawai->jns_jam_kerja) ?>">Pilih</a>
                                                </td>
                                            </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <td colspan="5">
                                                    <a href="<?= base_url('admin/absensi/update_shift/'.$id_pegawai.'/'.$pin.'/'.$bulan.'/'.$tahun.'/'.$detailPegawai->jns_jam_kerja) ?>" class="btn btn-light">
                                                        <i class="mdi mdi-update"></i> Petugas Shift
                                                    </a>
                                                </td>
                                            </tr>
                                      </tbody>
                                    </table>
                                </div>
                                 
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->

                <!-- Footer Start -->
                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-6">
                                <script>document.write(new Date().getFullYear())</script> © Hyper - Coderthemes.com
                            </div>
                            <div class="col-md-6">
                                <div class="text-md-end footer-links d-none d-md-block">
                                    <a href="javascript: void(0);">About</a>
                                    <a href="javascript: void(0);">Support</a>
                                    <a href="javascript: void(0);">Contact Us</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
                <!-- end Footer -->

            </div>


        </div>
        <!-- END wrapper -->
        <?php $this->load->view('layout/section/theme-setting');?>


        <!-- bundle -->
        <script src="<?php echo base_url();?>assets/new/js/vendor.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/app.min.js"></script>

        <!-- Todo js -->
        <script src="<?php echo base_url();?>assets/new/js/ui/component.todo.js"></script>
     

        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

        <script>
            $(document).on('dblclick', '.editable-time', function() {

                let td = $(this);
                let currentText = td.text().trim();
                let id = td.data('id');
                let field = td.data('field');

                // ambil jam saja (HH:MM)
                let timeValue = currentText !== '-' ? currentText.substring(0,5) : '';

                td.html('<input type="time" class="form-control form-control-sm edit-input" value="'+timeValue+'">');

                td.find('input').focus();

                td.find('input').on('blur keypress', function(e) {

                    if(e.type === 'blur' || e.which === 13) {

                        let newValue = $(this).val();

                        $.ajax({
                            url: "<?= base_url('admin/absensi/update_jam_manual') ?>",
                            type: "POST",
                            data: {
                                id: id,
                                field: field,
                                value: newValue
                            },
                            success: function(response) {

                                if(newValue === '') {
                                    td.html('-');
                                } else {
                                    td.html(newValue);
                                }
                            }
                        });
                    }
                });

            });

            $(".edit-absen").click(function(){
                var tanggal = $(this).data("id");
                $("#modal_tanggal_display") .val(tanggal); 
                $("#modal_tanggal") .val(tanggal); 
                                                          

            });

           
                document.addEventListener("DOMContentLoaded", function () {
                    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
                    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                        return new bootstrap.Tooltip(tooltipTriggerEl)
                    })
                });

            </script>

    </body>
</html>
