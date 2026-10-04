<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />

<style>
        .inputfile {
            width: 0.1px;
            height: 0.1px;
            opacity: 0;
            overflow: hidden;
            position: absolute;
            z-index: -1;
        }

        .inputfile + label {
            font-size: 1.05em;
            font-weight: 700;
            color: white;
            background-color: #2993EA;
            display: inline-block;
            padding:5px 10px;
            border-radius:4px;
        }

        .inputfile:focus + label,
        .inputfile + label:hover {
            background-color: #1B77C2;
        }

        .inputfile + label {
            cursor: pointer; /* "hand" cursor */
        }

        .inputfile:focus + label {
            outline: 1px dotted #000;
            outline: -webkit-focus-ring-color auto 5px;
        }

</style>


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <?php $this->load->view('layout/section/sidebar');?>
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    <?php $this->load->view('layout/section/topbar');?>
                    <?php
                    //print_array($rekap_capaian_kinerja);

                          $id_pegawai = $pegawai->id_pegawai;
                          $tgl_masuk = $pegawai->tgl_masuk;
                          $nip = $pegawai->nip;
                          $nama_pegawai = $pegawai->nama;
                          $photo = $this->Pegawai_model->getPhotoPegawai($nip);

                          if($photo==''){
                            $photo = 'avatar.png';
                          }



                          $arrayTelat = array();
                          $totalTelat = 0;
                          for ($r=0; $r < 12; $r++) {

                                $periode = @$rekap_absensi[$r]->periode;
                                $telat   = @$rekap_absensi[$r]->telat;

                                if($periode==''){
                                    $telat = 0;

                                }

                                $totalTelat = $totalTelat+$telat;

                               array_push($arrayTelat, $telat);
                          }

                          $json_telat = json_encode($arrayTelat);



                          $totalIzin = 0;
                          $totalSakit = 0;
                          $totalCuti = 0;
                          for ($r=0; $r < 12; $r++) {

                                $periode = @$rekap_absensi[$r]->periode;
                                $izin   = @$rekap_absensi[$r]->izin;
                                $sakit   = @$rekap_absensi[$r]->sakit;
                                $cuti   = @$rekap_absensi[$r]->cuti;

                                if($periode==''){
                                    $izin = 0;
                                    $sakit = 0;
                                    $cuti = 0;

                                }

                                $totalIzin = $totalIzin+$izin;
                                $totalSakit = $totalSakit+$sakit;
                                $totalCuti = $totalCuti+$cuti;

                          }


                        $listCapaian = array();
                        $listBulanCapaian = array();

                        //print_array($rekap_capaian_kinerja);

                        foreach ($rekap_capaian_kinerja AS $data_capaian) {

                            $capaian = $data_capaian->capaian;




                            if($capaian == ''){
                                $capaian = 0;
                            }
                            $periodeBulan = date('M', strtotime($data_capaian->periode));

                            array_push($listCapaian, $capaian);
                            array_push($listBulanCapaian, $periodeBulan);

                        }

                        if(empty($listCapaian)){
                            $listCapaian = array(0);
                        }

                      //  print_array($listCapaian);

                        $capaianTerkecil = min($listCapaian);
                        $min = $capaianTerkecil-1;

                        $list_capaian = json_encode($listCapaian);
                        $bulanCapaian = json_encode($listBulanCapaian);






                            $status_kawin  = $pegawai->status_kawin;
                            $status_pajak  = $pegawai->status_pajak;
                            $id_pendidikan = $pegawai->id_pendidikan;

                            $pendidikan = $this->Master_model->getNamaPendidikan($id_pendidikan);

                            if($status_kawin==1){
                                $status_nikah = 'K3 (Menikah + 2 anak)';
                            }else if($status_kawin==2){
                                $status_nikah = 'K2 (Menikah + 1 anak)';
                            }else if($status_kawin==3){
                                $status_nikah = 'K1 (Menikah + 0 anak)';
                            }else{
                                $status_nikah = 'K0 (Belum Menikah)';
                            }


                            $tahun = date('Y');

                            $dataGajiPegawai    = $this->Pegawai_model->getDataGajiPegawai($nip, $tahun);


                             if(!empty($dataGajiPegawai)){

                                $gaji_pokok = $dataGajiPegawai[0]->gaji_pokok;
                                $pengkalian = $dataGajiPegawai[0]->pengali;
                                $tkd_pokok = $gaji_pokok*$pengkalian;
                                $id_gaji   =  $dataGajiPegawai[0]->id;

                            }else{
                                $gaji_pokok= 0;
                                $pengkalian = 0;
                                $tkd_pokok =  0;
                                $id_gaji   = 0;
                            }



                            $status_kerja= $pegawai->status_kerja;


                            if($status_kerja==1){
                                $flag_status_kerja = ' <span class="badge bg-success"> Aktif</span>';  
                                $new_status_kerja = 0;  
                            }else if($status_kerja==2){
                                $flag_status_kerja = '<span class="badge bg-info">Cuti Bersalin</span>'; 
                                   $new_status_kerja = 1;
                            }else if($status_kerja==0){
                                $flag_status_kerja = '<span class="badge bg-danger">Tidak Aktif</span>';
                                   $new_status_kerja = 1;
                            }

                            $tmt = $pegawai->tmt;
                            $today = date('Y-m-d');

                            $masa_kerja = hitungMasaKerja($tmt, $today);

                            $detailPegawai = $this->Pegawai_model->getDataDetailPegawai($nip);



                           // $sisaTahunLalu = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 2, 'DESC');
                            $sisaTahun2024 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai,2, 'DESC'); //tahun 2024
                            $sisaTahun2025 = $this->Pegawai_model->getHakCutiPegawai($id_pegawai, 4, 'DESC');  //tahun 2025

                            $sisaCutiAll = $sisaTahun2024+$sisaTahun2025;





                     ?>


                    <!-- Start Content-->
                    <div class="container-fluid">

                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active">Pegawai</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Detail Pegawai </h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                         <div class="row">
                             <div class="col-sm-12">
                                 <!-- Profile -->
                                 <div class="card">
                                     <div class="card-body profile-user-box">
                                         <div class="row">
                                             <div class="col-sm-8">
                                                 <div class="row align-items-center">
                                                     <div class="col-auto">
                                                         <div class="avatar-lg">
                                                             <img src="<?php echo base_url().'uploads/photo_profile/'. $photo ;?>" alt="" class="rounded-circle img-thumbnail">
                                                         </div>
                                                     </div>
                                                     <div class="col">
                                                         <div>
                                                             <h4 class="mt-1 mb-1 text-dark"><?php echo $nama_pegawai;?></h4>
                                                             <p class="font-13 text-dark-50"> <?php echo $pegawai->jabatan;?></p>

                                                             <ul class="mb-0 list-inline text-dark">
                                                                 <li class="list-inline-item me-3">
                                                                     <h5 class="mb-1"><?php echo $pegawai->puskesmas;?></h5>
                                                                     <?php echo $nip;?>

                                                                 </li>
                                                                 <li class="list-inline-item">
                                                                     <h5 class="mb-1"><?php echo format_semi($tgl_masuk);?></h5>
                                                                     <p class="mb-0 font-13 text-dark-50">(<?php echo $masa_kerja['years'].' Tahun '.$masa_kerja['months'].' bulan';?>)</p>
                                                                 </li>
                                                             </ul>
                                                         </div>

                                                      Status Kerja: <?php echo $flag_status_kerja ;?>

                                                      <a href="<?php echo base_url();?>admin/pegawai/change_status_kerja/<?php echo $new_status_kerja.'/'.$id_pegawai;?>" class="btn btn-primary btn-sm mt-2">
                                                            Ubah Status Kerja
                                                        </a>

                                                       

                                                     </div>
                                                 </div>
                                             </div> <!-- end col-->

                                             <div class="col-sm-4">
                                                 <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                                     <a href="<?php echo base_url();?>admin/pegawai/edit_pegawai/<?php echo $id_pegawai.'/'.$nip;?>" class="btn btn-light">
                                                         <i class="mdi mdi-account-edit me-1"></i> Edit Profile
                                                    </a>

                                                    <!-- Small modal -->
                                                    <button  type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm">
                                                       <i class="mdi mdi-account-edit me-1"></i> Edit Gaji
                                                    </button>

                                                    <a href="<?php echo base_url();?>admin/pegawai/view_profile_pegawai/<?php echo $id_pegawai.'/'.$nip;?>" class="btn btn-success">
                                                        <i class="mdi mdi-account me-1"></i> View Full Profile
                                                   </a>


                                                    <div class="modal fade" id="bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-sm">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="mySmallModalLabel">Edit Gaji</h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                                </div>
                                                                <div class="modal-body text-start">
                                                                    <form action="<?php echo base_url();?>admin/pegawai/update_gaji/<?php echo $id_pegawai.'/'.$id_gaji;?>" method="post" id="update_myprofile">
                                                                            <div class="mb-2">
                                                                                <label for="inputValue">Gaji Pokok</label>
                                                                                <input type="text" id="ktp" value="<?php echo  rupiah($gaji_pokok);?>"  name="gaji_pokok"  class="form-control">
                                                                            </div><!--end col-->
                                                                            <div class="mb-2">
                                                                                <label for="inputValue">Pengali</label>
                                                                                <input type="text" id="npwp" value="<?php echo $pengkalian;?>"  name="pengali"  class="form-control">
                                                                            </div><!--end col-->

                                                                            <button type="submit" class="btn btn-success float-end">Save Changes</button>

                                                                    </form>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->

                                                 </div>
                                             </div> <!-- end col-->
                                         </div> <!-- end row -->

                                     </div> <!-- end card-body/ profile-user-box-->
                                 </div><!--end profile/ card -->
                             </div> <!-- end col-->
                         </div>
                         <!-- end row -->


                         <div class="row">
                             <div class="col-xl-6 col-xxl-4">
                                 <!-- Personal-Information -->



                                 <div class="card">
                                     <div class="card-body">
                                         <h4 class="header-title mt-0 mb-3">Detail Information</h4>
                                         <hr>

                                         <div class="text-start">
                                           <table class="table table-sm table-borderless">
                                             <tr>
                                               <td>Nama Lengkap</td>
                                               <td>:</td>
                                               <td><?php echo $nama_pegawai;?> </td>
                                             </tr>
                                             <tr>
                                               <td>Tempat Tanggal Lahir</td>
                                               <td>:</td>
                                               <td><?php echo $detailPegawai->tempat_lahir;?>, <?php echo format_semi($detailPegawai->tgl_lahir);?></td>
                                             </tr>
                                             <tr>
                                               <td>Pendidikan</td>
                                               <td>:</td>
                                               <td><?php echo $pendidikan;?></td>
                                             </tr>
                                             <tr>
                                               <td>Status Kawin</td>
                                               <td>:</td>
                                               <td><?php echo $status_nikah;?></td>
                                             </tr>
                                             <tr>
                                               <td>No Telp</td>
                                               <td>:</td>
                                               <td><?php echo $detailPegawai->no_tlp;?></td>
                                             </tr>
                                             <tr>
                                               <td>Alamat Email</td>
                                               <td>:</td>
                                               <td><?php echo $detailPegawai->email;?></td>
                                             </tr>
                                           </table>

                                           <table class="table table-bordered text-center">
                                                    <tr class="bg-light">
                                                        <th colspan="3">SISA CUTI</th>
                                                    </tr>
                                                    <tr class="bg-info text-white">
                                                        <th>2024</th>
                                                        <th>2025</th>
                                                        <th>Total</th>

                                                    </tr>
                                                    <tr>
                                                        <td class="fs-3"> <h4><?php echo $sisaTahun2024;?></h4> </td>
                                                        <td class="fs-3"><h4> <?php echo $sisaTahun2025;?></h4> </td>
                                                        <td class="fs-3"><h4> <?php echo $sisaCutiAll;?> </h4> </td>
                                                    </tr>
                                                    <tr>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-light">Edit</button>
                                                            </td>
                                                          <td>
                                                                <button type="button" class="btn btn-sm btn-light">Edit</button>

                                                                <form method="post" action="<?php echo base_url();?>admin/pegawai/insert_sisa_cuti/<?php echo $id_pegawai;?>" id="input_cuti_tahun_ini">
                                                                        <div class="input-number input-cuti1 row mt-4 d-none">
                                                                                <div class="col-md-8">

                                                                                    <input type="hidden" name="jns_hak" value="4">  <!-- 4 jenis hak cuti tahun 2025-->
                                                                                    <input type="text" name="sisa_akhir" id="sisa_akhir2" value="<?php echo $sisaTahun2025;?>">
                                                                                </div>

                                                                        </div>


                                                                        <div class="mb-3">
                                                                            <label class="form-label">Edit Sisa Cuti</label>
                                                                            <input data-toggle="touchspin" type="text"  name="qty_input" class="text-center"  id="input_form2"  value="0" min="-10" max="100" readonly="">
                                                                        </div>


                                                                        <div class="mt-4">
                                                                        <button type="submit" class="btn btn-success">Save</button>

                                                                        </div>
                                                                    </form>

                                                                </td>
                                                        <td></td>
                                                    </tr>
                                                </table>
                                         </div>
                                     </div>
                                 </div>
                                 <!-- Personal-Information -->



                             </div> <!-- end col-->

                             <div class="col-xl-12 col-xxl-8">

                                 <div class="row p-0">
                                     <div class="col-xxl-4 col-xl-4">
                                            <div class="card tilebox-one">
                                                <div class="card-body">
                                                    <i class="dripicons-basket float-end text-muted"></i>
                                                    <h6 class="text-muted text-uppercase mt-0">Gaji Pokok</h6>
                                                    <h3 class="m-b-20">Rp. <?php echo rupiah($gaji_pokok);?></h3>

                                                </div> <!-- end card-body-->
                                            </div> <!--end card-->
                                        </div><!-- end col -->

                                        <div class="col-xxl-4 col-xl-4">
                                            <div class="card tilebox-one">
                                                <div class="card-body">
                                                    <i class="dripicons-box float-end text-muted"></i>
                                                    <h6 class="text-muted text-uppercase mt-0">Pengali</h6>
                                                    <h3 class="m-b-20"><?php echo $pengkalian;?> X</h3>

                                                </div> <!-- end card-body-->
                                            </div> <!--end card-->
                                        </div><!-- end col -->

                                        <div class="col-xxl-4 col-xl-4">
                                            <div class="card tilebox-one">
                                                <div class="card-body">
                                                    <i class="dripicons-jewel float-end text-muted"></i>
                                                    <h6 class="text-muted text-uppercase mt-0">TKD Pokok</h6>
                                                    <h3 class="m-b-20">Rp.  <?php echo rupiah($tkd_pokok);?></h3>

                                                </div> <!-- end card-body-->
                                            </div> <!--end card-->
                                        </div><!-- end col -->
                                    </div>



                                    <div class="card">
                                     <div class="card-body">
                                         <h4 class="header-title mb-3">Riwayat Tunjangan dan Gaji</h4>
                                         <table class="table table-sm mb-0 table-bordered">
                                                <thead>
                                                    <tr>

                                                            <th class="text-center">No.</th>
                                                            <th>Periode</th>
                                                            <th class="text-end">TKD Pokok</th>
                                                            <th class="text-center">Total Capaian</th>
                                                            <th class="text-end">Bruto</th>
                                                            <th class="text-end">PPh21</th>
                                                            <th class="text-end">BPJS</th>
                                                            <th class="text-end">BPJS TK</th>
                                                            <th class="text-end"    >Total</th>

                                                            <th class="text-center">Action</th>

                                                        </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                      for ($i=0; $i <  count($data_tkd); $i++) {
                                                            $periode = $data_tkd[$i]->periode;
                                                            $format_periode = date('F Y', strtotime($periode));

                                                            $tkd_pokok = $data_tkd[$i]->tkd_pokok;
                                                            $totalCapaian = $data_tkd[$i]->capaian;
                                                            $bruto  = $data_tkd[$i]->bruto;
                                                            $pph21 = $data_tkd[$i]->pph21;
                                                            $bpjs = $data_tkd[$i]->bpjs;
                                                            $bpjs_tk = $data_tkd[$i]->bpjs_tk;
                                                            $thp = $data_tkd[$i]->thp;
                                                            $masa_kerja = $data_tkd[$i]->masa_kerja;

                                                            $ttd_spj = $data_tkd[$i]->ttd_spj;
                                                            $status = $data_tkd[$i]->status;

                                                            if($status==0){
                                                                $btn_ttd = '';
                                                            }else{

                                                                if($ttd_spj==''){
                                                                    $btn_ttd = '<button type="button" class="btn btn-info btn-sm ttd_spj"  value="'.$data_tkd[$i]->id.'/'.$format_periode.'" data-bs-toggle="modal" data-bs-target="#modal-ttd-spj" > TTD</button>';
                                                                }else{
                                                                    $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="100">';
                                                                }

                                                            }


                                                            if($status==1){
                                                                echo ' <tr>
                                                                <td class="text-center">
                                                                    '.($i+1).'
                                                                </td>
                                                                <td> '.$format_periode .'</td>
                                                                <td class="text-end">'.rupiah($tkd_pokok).'</td>
                                                                <td class="text-center fw-bold">'.$totalCapaian.'%</td>
                                                                <td class="text-end">'.rupiah($bruto).'</td>
                                                                <td class="text-end">'.rupiah($pph21).'</td>
                                                                <td class="text-end">'.rupiah($bpjs).'</td>
                                                                <td class="text-end">'.rupiah($bpjs_tk).'</td>
                                                                <td class="text-end  fw-bold">'.rupiah($thp).'</td>

                                                                <td  class="text-center"> <a href="'.base_url().'profile/detail_tkd/'.$data_tkd[$i]->id.'" class="btn btn-primary btn-sm"> Lihat Detail</a></td>
                                                            </tr>';
                                                            }

                                                      }
                                                    ?>


                                                </tbody>
                                            </table>

                                      </div>

                                    </div>
                             </div>



                             <div class="col-xl-12 ">


                                 <div class="card">
                                     <div class="card-body">
                                         <h4 class="header-title mb-3">Riwayat Cuti</h4>

                                         <div class="table-responsive">
                                             <table class="table  table-centered mb-0">
                                                 <thead>
                                                     <tr>
                                                         <th>Jenis Cuti</th>
                                                         <th>Hak Cuti</th>
                                                         <th>Tanggal Cuti</th>
                                                         <th>Hari Cuti</th>
                                                         <th>Alasan Cuti</th>
                                                         <th>Status Cuti</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody>
                                                        <?php
                                                            for ($i=0; $i < count($cutiPegawai) ; $i++) {
                                                                $jns_hak_cuti = $cutiPegawai[$i]->jns_hak_cuti;
                                                                $jns_cuti = $cutiPegawai[$i]->jns_cuti;
                                                                $status = $cutiPegawai[$i]->status;

                                                                if ($jns_cuti==1) {
                                                                    $jenis_cuti = 'TAHUNAN';
                                                                }else if($jns_cuti==2){
                                                                    $jenis_cuti = 'BERSALIN';
                                                                }else if($jns_cuti==3){
                                                                    $jenis_cuti = 'ALASAN PENTING';
                                                                }else if($jns_cuti==4){
                                                                    $jenis_cuti = 'SAKIT';
                                                                }else if($jns_cuti==5){
                                                                    $jenis_cuti = 'BESAR';
                                                                }else{
                                                                    $jenis_cuti = 'BERSALIN ANAK KE 3';
                                                                }


                                                                if($jns_hak_cuti==2){
                                                                    $hak_cuti = '2024';
                                                                }else{
                                                                    $hak_cuti =  '2025';
                                                                }

                                                                $tgl_dari   = $cutiPegawai[$i]->tgl_dari;
                                                                $tgl_sampai = $cutiPegawai[$i]->tgl_sampai;

                                                                if($tgl_dari != $tgl_sampai){
                                                                    $tgl_cuti =  format_full($tgl_dari).' s/d'. format_full($tgl_sampai) ;
                                                                }else{
                                                                    $tgl_cuti =  format_full($tgl_dari);
                                                                }

                                                                $hari_cuti = $cutiPegawai[$i]->hari_cuti;
                                                                $alasan_cuti = $cutiPegawai[$i]->alasan_cuti;

                                                                $tahunCuti = date('Y', strtotime($tgl_dari));

                                                                if($status=='APPROVE'){
                                                                    $flag_status = '<span class="badge bg-success">APPROVE</span>';
                                                                }else if($status=='CANCEL'){
                                                                    $flag_status = '<span class="badge bg-danger">CANCELED</span>';
                                                                }else{
                                                                    $flag_status = '<span class="badge bg-warning">'.$status.'</span>';
                                                                }

                                                                if($tahunCuti==2024){
                                                                    echo '

                                                                        <tr class="bg-light">
                                                                            <td>'.$jenis_cuti .'</td>
                                                                            <td>'. $hak_cuti .'</td>
                                                                            <td>'.$tgl_cuti.'</td>
                                                                            <td>'.$hari_cuti.'</td>
                                                                            <td>'.$alasan_cuti.'</td>
                                                                            <td>'.$flag_status.'</td>
                                                                        </tr>';

                                                                }else{

                                                               echo ' <tr>
                                                                    <td>'.$jenis_cuti .'</td>
                                                                    <td>'. $hak_cuti .'</td>
                                                                    <td>'.$tgl_cuti.'</td>
                                                                    <td>'.$hari_cuti.'</td>
                                                                        <td>'.$alasan_cuti.'</td>
                                                                        <td>'.$flag_status.'</td>
                                                                </tr>';

                                                                }




                                                            }

                                                        ?>

                                                 </tbody>
                                             </table>
                                         </div> <!-- end table responsive-->
                                     </div> <!-- end col-->
                                 </div> <!-- end row-->

                                 <div class="card">
                                     <div class="card-body">
                                         <h4 class="header-title mb-3">Hukuman Disiplin (HUBDIS)</h4>

                                         <!-- Standard modal -->
                                            <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#standard-modal">Input Hubdis</button>
                                                            <div class="clearfix"></div>

                                         <div class="table-responsive">
                                             <table class="table  table-centered mb-0">
                                                 <thead>
                                                     <tr>
                                                         <th>Tanggal</th>
                                                         <th>Jenis Hukuman</th>
                                                         <th>Kategori Hukuman</th>
                                                         <th>No SK</th>
                                                         <th>File</th>
                                                         <th>Action</th>
                                                     </tr>
                                                 </thead>
                                                 <tbody>

                                                 <?php
                                                        foreach ($hubdis as $hd) {
                                                            $id_hubdis= $hd->id;
                                                            $tgl_hubdis= $hd->tgl_hubdis;
                                                            $jns_hukuman= $hd->jns_hukuman;
                                                            $kategori= $hd->kategori;
                                                            $no_sk= $hd->no_sk;
                                                            $pejabat_ttd= $hd->pejabat_ttd;
                                                            $tgl_mulai= $hd->tgl_mulai;
                                                            $tgl_akhir= $hd->tgl_akhir;
                                                            $catatan= $hd->catatan;
                                                            $file_hubdis= $hd->file_hubdis;

                                                            if($kategori=='Ringan'){
                                                                $flag_kategori = '<span class="badge bg-info">'.$kategori.'</span>';
                                                            }else if($kategori=='Sedang'){
                                                                $flag_kategori = '<span class="badge bg-warning">'.$kategori.'</span>';
                                                            }else{
                                                                $flag_kategori = '<span class="badge bg-danger">'.$kategori.'</span>';
                                                            }


                                                            if($file_hubdis != ''){
                                                                $linkFile = '<a href="'.base_url().'uploads/hubdis/'.$file_hubdis.'" target="_blank">'.$file_hubdis.'</a>';
                                                            }else{
                                                                 $linkFile = '-';
                                                            }

                                                            echo ' <tr>
                                                                    <td>'.$tgl_hubdis .'</td>
                                                                    <td>'. $jns_hukuman .'</td>
                                                                    <td>'.$flag_kategori.'</td>
                                                                    <td>'.$no_sk.'</td>
                                                                    <td>'.$linkFile.'</td>

                                                                    <td>
                                                                        <button type="button" class="btn text-info detail_hubdis" value="'.$id_hubdis.'" data-bs-toggle="modal" data-bs-target="#detail-modal"><i class="uil-eye"></i> View</button>
                                                                        <button type="button" class="btn text-danger delete_hubdis" value="'.$id_hubdis.'" data-bs-toggle="modal" data-bs-target="#delete-modal"><i class="uil-trash"></i> Delete</button>
                                                                    </td>

                                                                </tr>';
                                                        }
                                                 ?>


                                                 </tbody>
                                             </table>
                                         </div> <!-- end table responsive-->
                                     </div> <!-- end col-->
                                 </div> <!-- end row-->


                                 <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="mySmallModalLabel">Delete Hubdis</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">
                                                Apakah anda yakin untuk menghapus data hubdis ini?
                                            </div>
                                            <div class="text-center p-2">

                                                <form action="<?php echo base_url();?>admin/pegawai/delete_hubdis/<?php echo $id_pegawai;?>" method="post">
                                                     <input type="hidden" name="id_hubdis" id="id_hubdis" value="">

                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-success">Iya</button>
                                                </form>
                                            </div>
                                            <br>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->


                                 <div id="standard-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog">

                                        <div class="modal-content">
                                        <form action="<?php echo base_url();?>admin/pegawai/insert_hubdis/<?php echo $id_pegawai.'/'.$nip;?>" method="post" enctype="multipart/form-data" id="upload_file_pdf">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Modal Heading</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body">

                                                    <div class="mb-2">
                                                        <label for="tgl_hubdis">Tanggal</label>
                                                        <input type="text" required name="tgl_hubdis"  class="form-control" id="tgl_hubdis"   value="20-05-2025" data-provider="flatpickr" data-date-format="d M Y" placeholder="Select Date">
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="tgl_hubdis">Jenis Hukuman</label>
                                                            <select  name="jns_hukuman" required class="form-control">
                                                                <option value="">--Pilih Jenis Hukuman--</option>
                                                                <option value="Lisan">Lisan</option>
                                                                <option value="Tertulis">Tertulis</option>
                                                            </select>

                                                    </div>

                                                        <div class="mb-2">
                                                            <label for="tgl_hubdis">Kategori Hukuman</label>
                                                                <select  name="kategori_hukuman" required class="form-control">

                                                                    <option value="Ringan">Ringan</option>
                                                                    <option value="Sedang">Sedang</option>
                                                                    <option value="berat">berat</option>

                                                                </select>

                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="tgl_hubdis">No SK </label>
                                                            <input type="text" name="no_sk" required class="form-control" id="no_sk">
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="tgl_hubdis">Pejabatan Penanda Tangan</label>
                                                            <input type="text" name="pejabat_ttd" required class="form-control" id="pejabat_ttd">
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="tgl_hubdis">Tanggal Stop TKD</label>
                                                                <div class="row">
                                                                    <div class="col-md-6">  <input type="text" required name="tmt_awal_tkd"  class="form-control" id="tmt_awal_tkd"   value="" data-provider="flatpickr" data-date-format="d M Y" placeholder="Tanggal Mulai"></div>
                                                                    <div class="col-md-6">  <input type="text" required name="tmt_akhir_tkd"  class="form-control" id="tmt_akhir_tkd"   value="" data-provider="flatpickr" data-date-format="d M Y" placeholder="Tanggal Akhir"></div>
                                                                </div>

                                                        </div>
                                                        <div class="mb-2">
                                                            <label for="tgl_hubdis">Keterangan Tambahan (opsional)</label>

                                                            <textarea name="catatan" id="catatan" class="form-control"></textarea>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                                    </div>

                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->

                                </div><!-- /.modal -->


                                <div id="detail-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">

                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h4 class="modal-title" id="standard-modalLabel">Hukuman Disiplin</h4>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                            </div>
                                            <div class="modal-body" id="detail_hubdis">



                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>

                                            </div>

                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->

                                </div><!-- /.modal -->



                             </div>
                             <!-- end col -->

                         </div>
                         <!-- end row -->



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



        <script type="text/javascript">

        $("#bulan").change(function(){
              var bulan = $(this).val();

              $.ajax({

                          type:"POST",
                          dataType:"html",
                          url:"<?php echo base_url();?>admin/presensi/set_session_periode",
                          data:"bulan="+bulan,
                          success:function(msg){
                           window.location.reload();
                            //$("#modal-form").html(msg);
                            //console.log(msg);
                          }

                    });

            });


        $("#tahun").change(function(){
              var tahun = $(this).val();

              $.ajax({

                        type:"POST",
                        dataType:"html",
                        url:"<?php echo base_url();?>admin/presensi/set_session_tahun",
                        data:"tahun="+tahun,
                        success:function(msg){
                         window.location.reload();
                          //$("#modal-form").html(msg);
                          //console.log(msg);
                        }

                  });

            });


            $("#update_tkd").click(function(){
                var periode = '<?php echo $periode;?>';

                  $.ajax({
                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/listing_tkd/update_rekap_tkd",
                            data:"periode="+periode,
                            success:function(msg){
                                window.location.reload();
                                //$("#modal-form").html(msg);
                                //console.log(msg);
                            }

                        });

                });

                $(".btn-white").click(function(){
                    var data = $(this).val();

                      $.ajax({
                              type:"POST",
                              dataType:"html",
                              url:"<?php echo base_url();?>admin/listing_tkd/ajaxDetailCapaian",
                              data:"data="+data,
                              success:function(msg){
                                $("#view_detail_capaian").html(msg);
                              }

                          });



                    });

                    $(".delete_hubdis").click(function(){
                        var id = $(this).val();
                        $("#id_hubdis").val(id);

                    });
                    $(".detail_hubdis").click(function(){
                        var id = $(this).val();

                        $.ajax({
                              type:"POST",
                              dataType:"html",
                              url:"<?php echo base_url();?>admin/pegawai/ajaxDetailHubdis",
                              data:"id="+id,
                              success:function(msg){
                                $("#detail_hubdis").html(msg);
                              }

                          });

                    });



          $(".bootstrap-touchspin-down").click(function(){
                var jumlah = $("#input_form2").val();
                var jmlhSebelumnya = <?php echo $sisaTahun2025;?>;
                var total = parseInt(jumlah)+parseInt(jmlhSebelumnya);
                $("#jumlah_cuti2").val(total);
                $("#sisa_akhir2").val(total);

          });

          $(".bootstrap-touchspin-up").click(function(){
                var jumlah = $("#input_form2").val();
                var jmlhSebelumnya = <?php echo $sisaTahun2025;?>;
                var total = parseInt(jumlah)+parseInt(jmlhSebelumnya);
                $("#jumlah_cuti2").val(total);
                $("#sisa_akhir2").val(total);

          });




        </script>




    </body>
</html>
