<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <style>

:root {
  --teal-050: #effcf6;
  --teal-100: #c6f7e2;
  --teal-200: #8eedc7;
  --teal-300: #65d6ad;
  --teal-400: #3ebd93;
  --teal-500: #27ab83;
  --teal-600: #199473;
  --teal-700: #147d64;
  --teal-800: #0c6b58;
  --teal-900: #014d40;

  --blue-grey-050: #f0f4f8;
  --blue-grey-100: #d9e2ec;
  --blue-grey-200: #bcccdc;
  --blue-grey-300: #9fb3c8;
  --blue-grey-400: #829ab1;
  --blue-grey-500: #627d98;
  --blue-grey-600: #486581;
  --blue-grey-700: #334e68;
  --blue-grey-800: #243b53;
  --blue-grey-900: #102a43;
}



main {
  max-width: 100%
  background-color: #fff;
  border-radius: 8px;
}


.month-indicator {
  color: var(--blue-grey-700);
  text-align: center;
  font-weight: bold;
  font-size:25px;
}


.day-of-week,
.date-grid {
  display: grid;
  grid-template-columns: repeat(7, 1fr);
}


.day-of-week {
  margin-top: 1.25em;
}

.day-of-week > * {
  font-size: 1.0em;
  color: #666;
  font-weight:bold;
  letter-spacing: 0.1em;
  text-align: center;
  height:40px;
  padding:5px;
  border:1px solid #EEE;

}

/* Dates */
.date-grid {
  border-bottom:1px solid #DDD;
}


.info-inputan{
    background:#66DF80;
    color:#FFF;
    border-radius:3px;
    padding:2px;
    font-size:12px;
    text-align:center;
}
.pending{
    background:#FFDE59;
}

.approve{
    background:#66DF80;
}

.reject{
    background:#F34F50;
}

.date-grid span {
  text-align: right;
  position: relative;
  border: 0;
  width: 100%;
  min-height: 80px;
  background-color: #FFF;
  border-top:1px solid #EEE;
  border-right:1px solid #EEE;
  padding:3px;
  color:#CCC;
}

.date-grid button {
  text-align: right;
  position: relative;
  border: 0;
  width: 100%;
  min-height: 80px;
  background-color: transparent;
  border-top:1px solid #EEE;
  border-right:1px solid #EEE;
  color: var(--blue-grey-600);
}

.date-grid button:hover,
.date-grid button:focus {
  outline: none;
  background-color: var(--blue-grey-050);
  color: var(--blue-grey-700);
}

.date-grid button:active,
.date-grid button.is-selected {
  background-color: var(--teal-100);
  color: var(--teal-900);
}

.absen{
    background-color: #EEE;
    color:#F00;
}

.class_disabled{
    background-color: #EEE !important;
    color:#F00;
}

#ajaxlist_aktifitas,  #list_keterangan{
            border: 1px solid #EEE;
            padding: 10px;
            max-height: 300px;
            overflow-y: scroll;
            display: none;
        }



        .list-aktifitas, .list-keterangan{
            border-bottom: 1px solid #EEE;
            padding: 5px;
            cursor: pointer;
        }

        .list-aktifitas:hover{
            color: orangered;
        }


</style>
    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": true}'>
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
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                            <?php
                                       $message = $this->session->flashdata('message');

                                       $id_pegawai = $this->session->userdata('id_pegawai');
                                       $nip  =$this->session->userdata('nip');


                                        $periode_bulan = $this->session->userdata('periode_bulan');
                                        $periode_tahun = $this->session->userdata('periode_tahun');


                                        if($periode_bulan=='') {
                                            $bulan = date('m');
                                            $tahun = date('Y');

                                        }else{
                                            $bulan = $periode_bulan;
                                            $tahun = $periode_tahun;
                                        }

                                        $bulanLalu = $bulan-1;


                                        $nm_bulan = getBulan($bulan);
                                        $periode = $tahun.'-'.$bulan;
                                        $periode = date('Y-m', strtotime($periode));

                                        $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);


                                        // echo  'jumlh hari'.$jumlahHariKerja;
                                         //exit;
                                         $menitEfektifBulanan  = $jumlahHariKerja*300;


                                         $totalInput = $this->Kinerja_model->getJumlahInputPerBulan($id_pegawai, $periode);
                                         if($totalInput==0){
                                             $totalInput = 1;
                                         }

                                         $persenInput = ($totalInput/$menitEfektifBulanan)*100;
                                         if ($persenInput > 100) {
                                             $persenInput = 100;
                                         }




                                         $totalApprove  = $this->Kinerja_model->getAktifitasApprove($id_pegawai, $periode);
                                         if($totalApprove==''){
                                             $totalApprove  = 0;
                                         }
                                         $persenApprove = ceil(($totalApprove/$totalInput)*100);


                                         $totalReject = $this->Kinerja_model->getAktifitasByStatus($id_pegawai, $periode, 2);
                                         if($totalReject==''){
                                             $totalReject  = 0;
                                         }

                                         $persenReject = ($totalReject/$totalInput)*100;



                                         $lastDate = date('t', strtotime($periode))+1;
                                         $hariAwal = date('N', strtotime($periode.'-01'));

                                         $prevPeriode = $tahun.'-'.$bulanLalu;

                                         $lastDateBlnLalu = date('t', strtotime($prevPeriode))+1;



                                         $tglTerakhirBulanLalu = $lastDateBlnLalu-$hariAwal;


                                ?>

                                <style>

                                    .date-grid button:first-child {
                                    grid-column: <?php echo $hariAwal;?>;

                                    }

                                </style>

                        <div class="row">
                          <div class="col-xxl-4 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Capaian Kinerja</h4>
                                        <br>


                                            <span class="float-right">   Periode :  <strong> <?php echo $nm_bulan;?> <?php echo $tahun;?> </strong> </span>

                                            <div class="row">

                                                <div class="col-md-4 col-xxl-12">

                                                    <h4><?php echo number_format($menitEfektifBulanan);?> menit</h4>
                                                     <h5 class="text-muted fw-normal mt-0" title="Revenue">Waktu Efektif</h5>
                                                </div>
                                                <hr>


                                                <div class="col-md-4 col-xxl-12">

                                                       <h4 ><?php echo number_format($totalInput) ;?> Menit</h4>
                                                        <h5 class="text-muted fw-normal mt-0" title="Revenue">Total Input Aktifitas</h5>
                                                        <div class="progress mb-2">
                                                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $persenInput;?>%" aria-valuenow="<?php echo $persenInput;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>

                                                </div>

                                                <div class="col-md-4 col-xxl-12">

                                                        <h4><?php echo number_format($totalApprove) ;?> Menit</h4>
                                                        <h5 class="text-muted fw-normal mt-0" title="Revenue">Aktiftias Disetujui</h5>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persenApprove;?>%" aria-valuenow="<?php echo $persenApprove;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>

                                                </div>

                                            </div>




                                    </div>
                                </div>
                            </div> <!-- end col-->




                            <div class="col-xxl-8 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data List Kinerja</h4>
                                        <br>

                                         <main>
                                            <div class="calendar2">

                                                <div class="month-indicator">

                                                <button type="button" value="prev" class="btn btn-outline-secondary me-4 change-month">
                                                        <i class="mdi mdi-arrow-left"></i>
                                                </button>

                                                  <time datetime="<?php echo $periode;?>"> <?php echo $nm_bulan;?> <?php echo $tahun;?> </time>

                                                  <button type="button"  value="next" class="btn btn-outline-secondary ms-4 change-month">
                                                    <i class="mdi mdi-arrow-right"></i>
                                                </button>


                                                </div>
                                                <div class="day-of-week">
                                                    <div>Mgg</div>
                                                    <div>Sen</div>
                                                    <div>Sel</div>
                                                    <div>Rab</div>
                                                    <div>Kam</div>
                                                    <div>Jum</div>
                                                    <div>Sab</div>
                                                </div>
                                                <div class="date-grid">

                                                    <?php
                                                            for ($i=$tglTerakhirBulanLalu; $i <  $lastDateBlnLalu  ; $i++) {
                                                            echo ' <span>
                                                                        <time datetime="2025-02-01">'.$i.'</time>
                                                                    </span>';
                                                            }
                                                        ?>


                                                    <?php

                                                            $tglNow = date('Y-m-d');
                                                            $dateNow = strtotime($tglNow);


                                                        for ($i=1; $i < $lastDate ; $i++) {
                                                            $fullDate =  $periode.'-'.$i;
                                                            $dateFormat = format_db($fullDate);

                                                            $aktifitas    = $this->Kinerja_model->getInputanPerhari($id_pegawai, $dateFormat);
                                                            $numAktifitas = count($aktifitas);
                                                            //print_array($aktifitas);

                                                            $class_status = 'reject';
                                                            for ($s=0; $s < $numAktifitas; $s++) {
                                                                $status = $aktifitas[$s]->status;

                                                                if($status==1){
                                                                    $class_status = 'approve';
                                                                }else{
                                                                    $class_status = 'pending';
                                                                }
                                                            }

                                                            $izinSakit         = $this->Presensi_model->cekIzinSakit($id_pegawai, $dateFormat);
                                                            $cekCutiPegawai    = $this->Cuti_model->cekCutiPegawai($dateFormat, $id_pegawai);


                                                            $dateCalendar = strtotime($dateFormat);

                                                            if($dateCalendar > $dateNow){
                                                                $disabled = 'disabled';
                                                                $class_disabled = 'bg-light';
                                                            }else{
                                                                $disabled = '';
                                                                $class_disabled = '';
                                                            }

                                                           echo ' <button type="button" value="'.$dateFormat.'" class="data-kegiatan '.$class_disabled.'" '.$disabled.'  data-bs-toggle="modal" data-bs-target="#bs-example-modal-lg">
                                                                <time datetime="'.$dateFormat.'">'.$i.'</time><br>';

                                                                if($numAktifitas !=0){
                                                                    echo ' <div class="info-inputan '.$class_status.'">'. $numAktifitas.' aktifitas</div>';

                                                                }

                                                                if(!empty($izinSakit)){
                                                                    if($izinSakit[0]->jenis_absen=='IZIN'){
                                                                        $jns_pengajuan = 'IZIN';
                                                                    }else{
                                                                        $jns_pengajuan = 'SAKIT';
                                                                    }
                                                                    echo ' <div class="info-inputan bg-danger">'.$jns_pengajuan.'</div>';

                                                                }


                                                                if(!empty($cekCutiPegawai)){
                                                                    echo ' <div class="info-inputan bg-info">CUTI</div>';

                                                                }

                                                            echo '</button>';
                                                        }
                                                    ?>


                                               <?php
                                                            for ($i=1; $i < 2 ; $i++) {
                                                            echo ' <span>
                                                                        <time datetime="2025-02-01">'.$i.'</time>
                                                                    </span>';
                                                            }
                                                        ?>

                                                </div>
                                            </div>
                                            </main>

                                            <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg  modal-dialog-scrollable">
                                                    <div class="modal-content" id="modal_content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myLargeModalLabel">Aktifitas Harian</h4>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                                <div class="spinner-grow text-primary" role="status"></div>
                                                                <div class="spinner-grow text-secondary" role="status"></div>
                                                                <div class="spinner-grow text-success" role="status"></div>
                                                                <div class="spinner-grow text-danger" role="status"></div>
                                                                <div class="spinner-grow text-warning" role="status"></div>
                                                                <div class="spinner-grow text-info" role="status"></div>
                                                                <div class="spinner-grow text-light" role="status"></div>
                                                                <div class="spinner-grow text-dark" role="status"></div>

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




        <?php
    if($message !=''){
    ?>
    <script>$.NotificationApp.send("Berhasil","<?php echo $message;?>","top-right","rgba(0,0,0,0.2)","success")</script>

    <?php } ?>


        <script>
            $(".data-kegiatan").click(function(){
                var tanggal = $(this).val();


                 $("#tgl_inputan").html(tanggal);

                 $.ajax({

                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>kinerja/ajaxGetAktifitasHarian",
                        data:"tanggal="+tanggal,
                        success:function(msg){
                            $(".modal-body").html(msg);
                        }

                 });


            });

            $(".change-month").click(function(){
                var prev_next = $(this).val();

                 $.ajax({

                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>kinerja/ajaxSetSessionPeriode",
                        data:"prev_next="+prev_next,
                        success:function(msg){
                            window.location.reload();
                        }

                 });


            });





        </script>
    </body>
</html>
