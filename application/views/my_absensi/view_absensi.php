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

                                
                                $id_pegawai = $detailPegawai->id_pegawai;
                                $id_puskesmas = $detailPegawai->id_puskesmas;

                                $ip_address = $this->Master_model->getIpAddress($id_puskesmas);

                                $currentMonth = (int)$bulan;
                                $currentYear  = (int)$tahun;

                                // Prev Month
                                $prevMonth = $currentMonth - 1;
                                $prevYear  = $currentYear;

                                if ($prevMonth < 1) {
                                    $prevMonth = 12;
                                    $prevYear--;
                                }

                                // Next Month
                                $nextMonth = $currentMonth + 1;
                                $nextYear  = $currentYear;

                                if ($nextMonth > 12) {
                                    $nextMonth = 1;
                                    $nextYear++;
                                }
                            
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

                                                    
                                        
                                                <?php foreach ($cuti_pegawai as $cuti): ?>

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
                
                                                                        echo '
                                                                            <div class="row py-1 align-items-center">
                                                                                    <div class="col-auto fw-bold pe-2">
                                                                                        
                                                                                            '.$jns_dl.'
                                                                                        
                                                                                    </div>
                                                                                    <div class="col ps-0">
                                                                                        <a href="javascript:void(0);" class="text-body">'.$keterangan_dl.'</a>
                                                                                        <p class="mb-0 text-muted"><small>'.format_full($tanggal_dl).'</small></p>
                                                                                        '.$flag_status_dl.'
                                                                                    </div>
                                                                                    <div class="col-auto">
                                            
                                                                                      
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


                                                                        if($jns_sakit==0){
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
                                            

                                        <a href="<?php echo base_url();?>admin/absensi/view_raw_absensi/<?php echo $pin.'/'.$ip_address.'/'.$bulan.'/'.$tahun;?>" target="_blank" class="mt-3 btn btn-info">
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



                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <a href="<?= base_url('absensi/view_absensi?bulan='.$prevMonth.'&tahun='.$prevYear) ?>" class="btn btn-outline-primary">
                                                ← Prev Month
                                            </a>

                                            <h4>
                                                <?= date('F Y', strtotime($tahun.'-'.$bulan.'-01')) ?>
                                            </h4>

                                            <a href="<?= base_url('absensi/view_absensi/?bulan='.$nextMonth.'&tahun='.$nextYear) ?>" class="btn btn-outline-primary">
                                                Next Month →
                                            </a>
                                        </div>

                                           <!-- <a href="<?php echo base_url();?>absensi/repair_periode_reguler/<?= $pin.'/'.$bulan.'/'.$tahun ?>" class="btn btn-info btn-sm">
                                                Update Shift Kerja
                                            </a> -->
                                             <a href="<?php echo base_url();?>absensi/update_data_absensi/<?= $pin.'/'.$ip_address.'/'.$bulan.'/'.$tahun ?>" class="btn btn-success update-btn btn-sm">
                                                Tarik Data Absensi  &nbsp;  <i class="mdi mdi-refresh"></i>          
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
                                                        $flag_status = '<span class="badge-status '.$badge_status_class.'">'.$status.'</span>';

                                                        if($status_detail=='LIBUR NASIONAL'){
                                                            $jam_masuk  = '<span class="text-uccess">-</span>';
                                                            $jam_pulang  = '<span class="text-success">-</span>';
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
                                                            <td><?= $row->shift ?></td>
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
                                                                <td><?= $row->status_detail ?></td>
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
                

                $(document).ready(function() {

                    $(".update-btn").click(function() {
                    //lert('Update capaian kinerja?');
                    $(this).addClass("disabled").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Updating...');
                        setTimeout(function() {
                            $(".update-btn").removeClass("disabled").html('Update &nbsp;  <i class="mdi mdi-refresh"></i>');
                        }, 2000);
                    });
                });
            </script>

    </body>
</html>
