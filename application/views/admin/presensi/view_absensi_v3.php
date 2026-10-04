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
                                       $message = $info= $this->session->flashdata('message');
                                 
                                        $id_pegawai = $detail_pegawai[0]->id_pegawai;
                                        $nip = $detail_pegawai[0]->nip;
                                        $pin = substr($nip, -4);

                                        $id_pegawai_session =  $this->session->userdata('id_pegawai');
                                        $userlevel_name = $this->Pegawai_model->cekUsergroupName($id_pegawai_session);
                                        //print_array( $this->session->userdata);


                                        $periode_bulan = $this->session->userdata('periode_bulan'); 
                                        $periode_tahun = $this->session->userdata('periode_tahun'); 
                                        
                            
                                        if($periode_bulan=='') {
                                            $bulan = date('m');
                                            $tahun = date('Y');
                            
                                        }else{
                                            $bulan = $periode_bulan;
                                            $tahun = $periode_tahun;
                                        }
                            
                                        
                            
                                        $nm_bulan = getBulan($bulan);
                                        $periode = $tahun.'-'.$bulan;
                                        $periode = date('Y-m', strtotime($periode));
                                      //  $periode = date('F Y', strtotime($periode));
                        

                            
                                        $lastDate = date('t', strtotime($periode)) + 1;
                            
                                        $id_pegawai = $this->uri->segment(4);
                            
                                        $nip = $detail_pegawai[0]->nip;
                                        $shift = $jns_jam_kerja= $detail_pegawai[0]->jns_jam_kerja;
                                        $nama_pegawai = $detail_pegawai[0]->nama;
                                        $id_puskesmas = $detail_pegawai[0]->id_puskesmas;
                                     
                                        $puskesmas = $this->Presensi_model->getNamaPuskesmas($id_puskesmas);
                                        $message = $this->session->flashdata('message');
                                        
                            
                                        $pin = substr($nip, -4);

                                        if (!empty($dataRekap)) {

                                                $id_rekap = $dataRekap[0]->id;
                                                $status = $dataRekap[0]->status;
                                                
                                                $telat = $dataRekap[0]->telat;
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
                                                $sakit =  '-';
                                                $izin =  '-';
                                                $cuti = '-';
                                                $sakit_dgn_dk = 0;
                                                $status=0;
                                                $status_absen = '<div class="badge badge-danger-lighten">
                                                             <i class="uil-exclamation-circle  text-danger"></i> <span class="font-bold">Warning!</span>  Data absensi Belum direkap.
                                                          </div>';
                                        
                                        }


                                       // $DataCuti = $this->Cuti_model->getCutiPegawai($id_pegawai, $periode);

                                        $DinasLuar =  $this->Presensi_model->getDataPengajuanDLPerbulan($id_pegawai, $periode);

                                         $ip_address = $this->Master_model->getIpAddress($id_puskesmas);
                                        // $absensi    = $this->Sinkron_model->getDataAbsenMesin($ip_address, $pin);

                                       // print_array($cuti_pegawai);
                                        
                                ?>


                        <div class="d-flex align-items-center bg-warning text-white p-2 mb-3 d-none loading">
                            <strong>Loading...</strong>
                            <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                        </div>


                        <div class="row">
                            <div class="col-xl-4 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                    <a href="<?php echo base_url();?>admin/presensi/index_v3" class="btn badge-danger-lighten">
                                    <i class="mdi mdi-arrow-left"></i> Kembali</a>

                                      <a href="<?php echo base_url();?>admin/absensi/view_absensi_pegawai/<?= $pin.'/'.$bulan.'/'.$tahun ?>" class="btn badge-info-lighten">
                                    <i class="mdi mdi-arrow-right"></i> Lihat Versi 2</a>


                                        <div class="row">
                                             <div class="col-md-3">
                                                <div style="font-size:80px">
                                                    <i class="mdi mdi-account-box"></i>
                                                </div>
                                            </div>
                                             <div class="col-md-6 pb-2"> 
                                                <br>
                                                <h4 class="mb-1"><a href="#!" class="text-dark"><?php echo $detail_pegawai[0]->nama;?></a></h4>
                                                <p class="font-13"><a href="#!"  class="text-secondary"><?php echo $detail_pegawai[0]->nip;?></a></p>

                                                <strong><?php echo $detail_pegawai[0]->jabatan;?></strong> <br>
                                                <?php echo $detail_pegawai[0]->puskesmas;?>
                                               
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

                                                

                                             <h5>Data Cuti</h5>
                                             <div class="col-md-12"> 

                                                    
                                        
                                                <?php foreach ($cuti_pegawai as $cuti): ?>

                                                        <?php
                                                            $tgl_dari   = $cuti->tgl_mulai;
                                                            $tgl_sampai = $cuti->tgl_selesai;
                                                            $hari_cuti  = $cuti->lama_cuti;
                                                            $id_cuti    = $cuti->id;

                                                            $nama_jenis_cuti = $cuti->nama_jenis_cuti;
                                                            $status_akhir    = $cuti->status_akhir;
                                                            $status_tampilan = $cuti->status_tampilan;

                                                            // badge status
                                                            if ($status_akhir === 'disetujui') {
                                                                $badge_class = 'badge-success-lighten';
                                                                $icon        = 'uil-check text-success';
                                                            } elseif ($status_akhir === 'proses') {
                                                                $badge_class = 'badge-warning-lighten';
                                                                $icon        = 'uil-clock text-warning';
                                                            } else {
                                                                $badge_class = 'badge-secondary-lighten';
                                                                $icon        = 'uil-info-circle';
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

                                                                <button type="button" 
                                                                        data-id="<?= $id_cuti; ?>" 
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#modal-info-absen"
                                                                        class="btn btn-sm btn-primary view-detail-cuti">
                                                                            <i class="mdi mdi-eye-outline"></i> Detail
                                                                </button>
                                                            </div>

                                                        </div>

                                                        <hr>

                                                        <?php endforeach; ?>

                                                        <div class="clearfix"></div>
                                                        <br>

                                             </div>
                                            

                                             
                                             <h4 class="header-title mb-3">Dinas Luar</h4>
                                              <div data-simplebar="" style="max-height: 320px; overflow-x: hidden;">
                                               
                                                  
                                        
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
                                                                           <a href="'. base_url().'admin/presensi/insert_absen_cuti/'.$id_dl.'/'.$id_pegawai.'" title="lihat detail Dinas luar" class="me-2">
                                                                                 <i class="uil-maximize-left fw-bold fs-5 text-info"></i>
                                                                             </a>
     
                                                                             <a href="'. base_url().'admin/presensi/insertAbsenPengajuanDL/'.$id_dl.'/'.$pin.'/'.$id_pegawai.'" class=" fw-bold" title="update absensi Dinas luar">
                                                                                 <i class="uil-upload fw-bold  fs-5 text-success"></i>
                                                                             </a>
                                                                              
                                                                          </div>
                                                                     </div>
                                                                 
                                                            
                                                                 <hr>';
                                                         }
                                                    }
                                                   
                                                ?>
                                              
                                                <div class="clearfix"></div>
                                                <br>


                                         
                                              <button  type="button" class="btn btn-info raw-absensi" data-bs-toggle="modal" data-bs-target="#scrollable-modal">View Absensi (mesin)</button>
                                                  


                                             </div>

                                            
                                            
                                        </div>
                                        <!-- end div-->
                                    </div>
                                </div>
                            </div> <!-- end col -->

                            <div class="col-xxl-8 col-lg-6">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data Kehadiran</h4>
                                        <br>



                                    
                                        <button type="button" data-modal-target="loading_update" value="<?php echo $id_rekap;?>" type="button" class="btn btn-success btn-check-ok">
                                        <i class="mdi mdi-check"></i> <span class="align-middle">Check Sesuai</span>
                                        </button>
                                  
                                        <a href="<?php echo base_url();?>admin/presensi/update_data_rekap/<?php echo $pin.'/'.$id_pegawai;?>" class="btn btn-info">
                                        <i class="mdi mdi-update"></i> Update Rekap</a>
                                    <!-- <a href="<?php echo base_url();?>admin/presensi/list_absensi/<?php echo $pin.'/'.$id_pegawai;?>" class="text-white btn bg-slate-500 border-slate-500 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/20">List Absensi</a> -->
                                        <a href="<?php echo base_url();?>admin/presensi/tarik_absensi/<?php echo $pin.'/'.$id_pegawai;?>" class="tarik_absensi btn btn-light  float-end">
                                        <i class="mdi mdi-download"></i>  Tarik Absensi</a>  

                                        <a href="<?php echo base_url();?>admin/presensi/updateShiftBulanan/<?php echo $id_pegawai.'/'.$pin.'/'.$periode.'/'. $shift;?>" class="tarik_absensi btn btn-primary me-2 float-end">
                                         <i class="mdi mdi-update"></i> Update Shift</a>  

                                    
                                         <a href="<?php echo base_url();?>admin/presensi/print_absensi/<?php echo $id_pegawai.'/'.$pin.'/'.$periode.'/'. $shift;?>" class="tarik_absensi btn btn-primary me-2 float-end">
                                         <i class="mdi mdi-print"></i> Print</a>  

                                    



                                         <table class="table mt-4 table-bordered table-sm">
                                                <thead class="bg-light">
                                                    <tr>
                                                            
                                                        <th class="text-center"> Tanggal</th>
                                                        <th class="text-center">Hari</th>
                                                        <th class="text-center">Shift</th>
                                                        
                                                        <th class="text-center">Absen Masuk</th>
                                                        <th class="text-center">Absen Keluar</th>
                                                        <th class="text-center"> Telat</th>
                                                        <th class=" text-center">Pulang Awal</th>
                                                        <th width="300">Keterangan</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                    
                                               // $absensiHarian  = $this->Presensi_model->getDataAbsensi($pin, '2025-01-21');

                                                 $absensiHarian  = $this->Presensi_model->getAbsensiPegawai($pin, $periode);

                                              //   print_array($absensiHarian);


                                                    $tgl_now = date('Y-m-d');
                                        
                                                    $totalTelat = 0;
                                                    $totalPawal = 0;  

                                                    $totalIzin = 0;
                                                    $totalSakit = 0;
                                                    $totalCuti = 0;
                                        

                                                //   for ($t = 1; $t < $lastDate; $t++) {
                                                //       $tanggal = $periode . '-' . $t;
                                                //       $formatDate = date('Y-m-d', strtotime($tanggal));
                                                //       $day = date('l', strtotime($tanggal));
                                                //       $hari = getNamahari($tanggal);

                                                      //$absensiHarian  = $this->Presensi_model->getDataAbsensi($pin, $formatDate);
                                                      
                                                        for ($t = 0; $t < count($absensiHarian); $t++) {
                                                                    
                                                            $id         = $absensiHarian[$t]->id;
                                                            $tanggal         = $absensiHarian[$t]->tanggal;
                                                            $kodeShift         = $absensiHarian[$t]->shift;
                                                            $jamMasukKerja     = $absensiHarian[$t]->jam_masuk;
                                                            $jamKeluarKerja    = $absensiHarian[$t]->jam_pulang;
                                            
                                                            $absenMasuk         = $absensiHarian[$t]->masuk;
                                                            $absenPulang        = $absensiHarian[$t]->pulang;
                                                            $keterangan_absen   = $absensiHarian[$t]->keterangan;

                                                            $telat         = $absensiHarian[$t]->telat;
                                                            $p_awal         = $absensiHarian[$t]->p_awal;

                                                            $hari = getNamahari($tanggal);


                                                            $formatDate = format_db($tanggal);
                                                            $dataModelAbsensi = $this->Presensi_model->modelDataAbsensi($pin, $id_pegawai, $id, $jns_jam_kerja, $hari, $absenMasuk, $absenPulang, $jamMasukKerja, $jamKeluarKerja, $formatDate, $kodeShift);
                                                            $bg_btn = $dataModelAbsensi[0];
                                                            $absenMasuk = $dataModelAbsensi[1];
                                                            $absenPulang= $dataModelAbsensi[2];



                                                            $totalTelat = $totalTelat+$telat;
                                                            $totalPawal = $totalPawal+$p_awal;
                    

                                                            echo '  <tr>
                                                                    <td class="text-center">
                                                                        <a href="'.base_url().'admin/presensi/delete_absensi_harian/'.$id.'/'.$pin.'/'.$id_pegawai.'" class="float-start hover-show"> 
                                                                    <i class="uil uil-trash fw-bold text-danger fs-4"></i> </a> &nbsp;
                                                                    
                                                                    ' . date('d, M',strtotime($formatDate)) . '
                                                                    
                                                                    </td>
                                                                    <td class="text-center">' . $hari . '</td>
                                                                    <td class="text-center">';
                                                                    if($userlevel_name=='admin_pkc'){
                                                                        echo '  <button type="button" id="'.$formatDate.'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm"  class="'.$bg_btn .' btn_change_shift " value="'.$formatDate.'" style="font-size:12px">
                                                                        '. $kodeShift.'
                                                                        </button> ';
                                                                    }else{
                                                                         echo  $kodeShift;
                                                                    }
                                                                  
                                                                
                                                                    
                                                                   echo '</td>
                        
                                                                    <td class="text-center">'.$absenMasuk;
                                                                    if($absenMasuk == ''){
                                                                    echo '<button class="btn btn-hover-show"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg"><i class="fa-solid fa-pencil"></i></button>';
                                                                    }else{
                                                                    echo '<a href="'.base_url().'admin/presensi/delete_absensi/'.$tanggal.'/'.$pin.'/'.$id_pegawai.'/0" class="float-end hover-show">  <i class="mdi mdi-trash-can-outline"></i> </a>';
                                                                    }

                                                                    echo '</td>
                                                                    <td class="text-center">'.$absenPulang;

                                                                        if($absenPulang != ''){
                                                                            echo '<a href="'.base_url().'admin/presensi/delete_absensi/'.$tanggal.'/'.$pin.'/'.$id_pegawai.'/1" class="float-end hover-show text-danger">    <i class="mdi mdi-trash-can-outline"></i>   </a>';
                                                                        }else{
                                                                         echo '<button class="btn btn-hover-show"  value="'.format_view($tanggal).'" data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg"><i class="fa-solid fa-pencil"></i></button>';
                                                                        }

                                                                    
                                                                    echo '</td>
                                                                    <td class="text-center">'.$telat.'</td>
                                                                    <td class="text-center">'. $p_awal.'</td>
                                                                    <td class>'. $keterangan_absen.'</td>
                                                                            
                                                                            
                                                                </tr>';
                    

                                                        }


                                                     ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center"></td>
                                                        <td class="text-center"><?php echo $totalTelat ;?></td>
                                                        <td class="text-center"><?php echo $totalPawal ;?></td>
                                                        <td class="text-center"></td>
                                                        <td class="text-center"></td>
                                                    
                                                    </tr>
						
										</tbody>
                                    </table>

                                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="scrollableModalTitle">Modal title</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body" id="datalist_absensi_raw">
                                                    asf
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Save changes</button>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    



                                        <!-- <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#standard-modal">Add Sidik Jari</button> -->
                                        <div class="modal fade" id="bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="mySmallModalLabel">Ubah Cuti</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                     <form method="post" action="<?php echo base_url();?>admin/presensi/update_shift_v2/<?php echo $pin.'/'.$id_pegawai;?>" id="update_shift">
                                                            Tanggal :  <input type="text" name="tanggal" class="form-control"  value="" id="tgl_shift">
                                                            <br><br>
                                                                <div class="flex flex-wrap gap-2">

                                                                    <?php
                        
                        
                                                                        for ($i=0; $i < count($data_shift_kerja) ; $i++) { 
                                                                                $kode_shift = $data_shift_kerja[$i]->kode_shift;
                                                                                $nama_shift = $data_shift_kerja[$i]->nama_shift;
                                                                                
                                                                                if($kode_shift=='L-OFF'){
                                                                                    $class_text = 'style="color:orange"';
                                                                                    $checked_class= 'btn-outline-warning';
                                                                                }else if($kode_shift=='OFF'){
                                                                                    $checked_class= 'btn-outline-danger';
                                                                                }else{
                                                                                    $class_text = 'style="color:#5484cc"';
                                                                                    $checked_class = 'btn-outline-success';
                                                                                }
                                                                                echo ' <button type="button" class="btn '. $checked_class.' mb-1 checkshift" value="'.$kode_shift.'">'.$kode_shift.'</button> </td>
                                                                             
                                                                                ';
                        
                        
                                                                            
                                                                            
                                                                        }
                                                                    ?>
                                                                   
                                                                </div>
                                                            
                                                            <br>
                                                            <button id="btn_submit" style="display:none" type="submit" class="my-4 float-right text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">Simpan</button>
                                                            
                                                            </form>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        <div class="modal fade" id="modal-info-absen" tabindex="-1" role="dialog" aria-labelledby="modal-info-absen" aria-hidden="true">
                                            <div class="modal-dialog  modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="modal-info-absen">Data Absensi</h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body" id="modalinfocuti">
                                                   
                                                           
                                                         
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->

                                        

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

                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>

        <!-- Datatable Init js -->
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.datatable-init.js"></script>


        <?php
    if($message !=''){
    ?>
    <script>$.NotificationApp.send("Berhasil","<?php echo $message;?>","top-right","rgba(0,0,0,0.2)","success")</script>

    <?php } ?>

                
            <script>
                $(document).ready(function() {

                    // $(".btn").click(function(){
                    //     $(".loading").removeClass("d-none");
                    // });

                    var info = '<?php echo $info;?>';

                    if(info=='gagal'){
                        message = 'Input Absen gagal! tanggal tidak boleh kosong';
                        bg = '#F00';
                    }else{
                        message = 'Input Absen berhasil! ';
                        bg = '#2f8f4c';
                    }


                            

                    $(".tarik_absensi").click(function(){
                        $(this).addClass("hidden");
                        $(".loading-update").removeClass("hidden");



                    });

                    $(".btn-info-absensi").click(function(){

                        var data_post = $(this).val();
                        $.ajax({

                                type:"POST",
                                dataType:"html",
                                url:"<?php echo base_url();?>admin/presensi/ajax_detail_absensi",
                                data:"data_post="+data_post,
                                success:function(msg){
                                    $("#modal-form").html(msg);
                                }

                            });

                        });


                        $(".info-cuti").click(function(){
                            var data_post = $(this).val();
                    
                            var linkDelete = "<?php echo base_url();?>admin/presensi/delete_absensi_cuti";

                            var btn = '<a href="'+linkDelete+'/'+data_post+'" class="delete_absensi">Delete Absensi</a>';

                        //  alert(data_post);;
                            $("#btn_delete_absensi").html(btn);
                        });


                        

                        $(".raw-absensi").click(function(){


                            var pin = '<?php echo $pin;?>';
                            var ip_address = '<?php echo $ip_address;?>';

                            $.ajax({

                                    type:"POST",
                                    dataType:"html",
                                    url:"<?php echo base_url();?>admin/presensi/ajax_get_raw_absensi",
                                    data:"pin="+pin+"&ip_address="+ip_address,
                                    success:function(msg){
                                        $("#datalist_absensi_raw").html(msg);
                                    }

                                });

                        });


                        

                        $(".view-detail-cuti").click(function(){

                            var id = $(this).data("id");
                            $.ajax({

                                    type:"POST",
                                    dataType:"html",
                                    url:"<?php echo base_url();?>admin/presensi/ajax_detail_cuti",
                                    data:"id="+id,
                                    success:function(msg){
                                        $("#modalinfocuti").html(msg);
                                    }

                                });

                        });

                    
                        
                      $(".btn-info-absensi").click(function(){

                            var data_post = $(this).val();
                            $.ajax({

                                    type:"POST",
                                    dataType:"html",
                                    url:"<?php echo base_url();?>admin/presensi/ajax_detail_absensi",
                                    data:"data_post="+data_post,
                                    success:function(msg){
                                        $("#modalinfocuti").html(msg);
                                    }

                                });

                        });

                    
                    $('.btn_change_shift').click(function() {
                        
                        var tanggal = $(this).val();

                        $("#tgl_shift").val(tanggal);

                        $(".checkshift").prop('checked', false);

                    }); 
                    
                    $('.checkshift').click(function() {
                    
                        var shift     = $(this).val();
                        var pin       = '<?php echo $pin;?>';
                        var tanggal   = $("#tgl_shift").val();

                     

                        $.ajax({
                            
                                    type:"POST",
                                    dataType:"html",
                                    url:"<?php echo base_url();?>admin/presensi/update_shift_pegawai",
                                    data:"pin="+pin+"&tanggal="+tanggal+"&shift="+shift,
                                    success:function(msg){
                                        $(".btn-close").trigger("click");
                                        $("#"+tanggal).html(shift);

                                            
                                    }

                                
                                
                            });
                        
                           
                          
                        // if ($(this).is(':checked')) {
                        //     console.log('Checkbox is checked');
                        //     //$("#btn_submit").show();
                        //     // Tambahkan tindakan lain yang ingin dilakukan ketika checkbox dicentang
                        // } else {
                        //     console.log('Checkbox is not checked');
                        //      // $("#btn_submit").slideUp();
                        //     // Tambahkan tindakan lain yang ingin dilakukan ketika checkbox tidak dicentang
                        // }
                    });


                    $(".btn-check-ok").click(function(){
                        
                        $("#list_info_data_rekap").html('<div class="inline-block border-2 rounded-full size-8 animate-spin border-l-transparent border-sky-500"></div>');
                        
                        var id_rekap = $(this).val();
                        
                        $.ajax({
                
                                    type:"POST",
                                    dataType:"html",
                                    url:"<?php echo base_url();?>admin/presensi/check_ok2",
                                    data:"id_rekap="+id_rekap,
                                    success:function(msg){
                                    $("#list_info_data_rekap").html(msg);
                                    
                                    setTimeout(function(){
                                        window.location.reload();
                                        }, 1000);
                                    }
                
                            });

                    });

            });



            </script>


    </body>
</html>
