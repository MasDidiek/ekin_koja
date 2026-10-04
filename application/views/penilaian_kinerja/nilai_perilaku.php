<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
<style>
    .bg-blue-light{
        background:#eff6f9 !important;
    }
</style>
                                                
    <style>
     
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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/index">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/penilaian_kinerja/validasi_aktifitas">Penilaian Kinerja</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/penilaian_kinerja/perilaku">Penilaian Perilaku</a></li>
                                            <li class="breadcrumb-item active">Nilai Perilaku Pegawai</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->



                            <div class="col-xxl-12col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Penilaian Perilaku Pegawai</h4>
                                        <br>

                                        <?php
                                                    $info = $this->session->flashdata('message');

                                                            
                                                    $list_bulan = array_bulan();
                                                    
                                                    //print_array($this->session->userdata);

                                                    $periode_bulan = $this->session->userdata('periode_bulan');
                                                    //$periode_bulan = '04';
                                                    $periode_tahun = $this->session->userdata('periode_tahun');
                                                    $id_pkm_sess   = $this->session->userdata('id_pkm');
                                                    $id_pj_sess = $this->session->userdata('id_pj');
                                                    $id_user_validator   = $this->session->userdata('id_pegawai');

                                                    if($periode_bulan=='') {
                                                    $bulan = date('m');
                                                    $tahun = date('Y');

                                                    }else{
                                                        $bulan = $periode_bulan;
                                                        $tahun = $periode_tahun;
                                                    }

                                                    $periode = $tahun.'-'.$bulan;
                                                    $periode = date('Y-m', strtotime($periode));

                                                                                        
                                                    $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
                                                    $menitEfektifBulanan  = $jumlahHariKerja*300;
                                        
                                                    $nama_bulan = getBulan($bulan);

                                                    $id_pegawai = $pegawai[0]->id_pegawai;
                                                    $nip  = $pegawai[0]->nip;

                                        ?>

                                                                
                                            <div class="row">
                                                
                                                <div class="col-lg-6 col-md-12 mb-1">
                                                   
                                                        <h4><?php echo $pegawai[0]->nama;?> </h4>          
                                                        <strong><?php echo $pegawai[0]->nip;?></strong>   <br>
                                                        <strong><?php echo $pegawai[0]->jabatan;?></strong>  
                                                        @<?php echo $pegawai[0]->puskesmas;?>         
                                                                    
                                                       <div class="fs-3">
                                                          Periode : <strong><?php echo $nama_bulan;?> <?php echo $tahun;?></strong>
                                                        </div>
                                                        <a href="<?php echo base_url();?>admin/penilaian_kinerja/perilaku/<?php echo $id_pegawai.'/'.$bulan.'/'.$tahun;?>" class="btn btn-light">
                                                        <i class="mdi mdi-reply me-1"></i> Kembali</a>      
                                                </div>

                                                                
                                                    <?php
                                                        $persenPoin = $totalPoin/2;

                                                       
                                                    ?>
                                                    
                                                    <div class="col-lg-3 col-md-12 mb-1">
                                                        <div>
                                                            <h4>Total Poin</h4>
                                                            <span class="fs-2 fw-bold" id="poin_perilaku"><?php echo $totalPoin;?></span>
                                                        </div>

                                                        <div class="rateit rateit-mdi" data-rateit-mode="font" data-rateit-icon="󰓒"  data-rateit-value="<?php echo $persenPoin;?>" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                                 
                                                        <br>

                                                        <a href="<?php echo base_url();?>admin/penilaian_kinerja/resetPenilainPerilaku/<?php echo $id_pegawai.'/'.$bulan.'/'.$tahun;?>" class="btn btn-white border text-danger" onclick="return confirm('Apakah anda ingin mereset penilaian perilaku pegawai ini?');">
                                                        <i class="mdi mdi-refresh me-1"></i> Reset Penilaian</a>      
                                                    </div>

                                            </div>


                                            
                                            <form method="post" action="<?php echo base_url(); ?>simpan_penilaian/<?php echo $id_pegawai; ?>">


                                                <?php

                                                $check = '';

                                                for ($a = 0; $a < count($datalist); $a++) {

                                                $id_kat = $datalist[$a]->id;
                                                $daftar = $this->Kinerja_model->getDaftarPertanyaan($id_kat);

                                                $namaKat = $datalist[$a]->nama;


                                                echo '

                                                <div class="col-lg-10 col-md-12 mb-1">
                                                         <br>
                                                            <h4> <span style="font-weight:bold; color:orange">' . $namaKat . '</span></h4>
                                                          
                                                        ';


                                                            for ($i = 0; $i < count($daftar); $i++) {

                                                                $pertanyaan = $daftar[$i]->pertanyaan;
                                                                $id         = $daftar[$i]->id;
                                                                $jns_item   = $daftar[$i]->jns_item;
                                                                $getJawaban  = $this->Kinerja_model->getJawaban($id_pegawai, $id, $bulan, $tahun);
                                                                #print_array($getJawaban);

                                                                if (!empty($getJawaban)) {
                                                                    $jawaban = $getJawaban[0]->jawaban;
                                                                    $id_jawaban = $getJawaban[0]->id;
                                                                } else {
                                                                    $id_jawaban = 0;
                                                                    $jawaban = 0;
                                                                }

                                                                if ($jns_item == 1) {
                                                                $jns = '<span style="color:#25be9b">(+) Lebih tinggi lebih baik </span>';
                                                                } else {
                                                                $jns = '<span style="color:#E34547">(-) Lebih rendah lebih baik</span>';
                                                                }

                                                                $b = $i + 1;


                                                                echo ' <div class="fs-4 mt-2 bg-blue-light p-2 rounded" >
                                                                    
                                                                        ' . $b . '.  ' . $pertanyaan . ' <Br>
                                                                              <div class="ms-3">' . $jns . ' </div>
                                                                                    <div class="ms-3   p-2 rounded">  ';
                                                                                    
                                                                                        for ($g = 0; $g < 10; $g++) {
                                                                                            $val = $g + 1;
                                                                                            if ($val ==  $jawaban) {
                                                                                                $check = 'checked';
                                                                                            }


                                                                                            echo ' <div class="form-check form-check-inline">
                                                                                                            <input type="radio" id="customRadio' . $id . '" name="jawaban' . $id . '"  value="' . $val . '_' . $id_jawaban . '_'.$jns_item.'" ' . $check . ' class="form-check-input">
                                                                                                            <label class="form-check-label" for="customRadio3"> ' . $val . '</label>
                                                                                                        </div>       ';

                                                                                        $check = '';
                                                                                        }

                                                                                    echo '
                                                                                    </div>
                                                                    </div> ';
                                                            }

                                                            echo '</div>';
                                                    }
                                                ?>
                                                </form>


                                        </div> <!-- end card-body -->       
                                     

                                        

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
     
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.rateit.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

                                                
                
            <script type="text/javascript">
            $(".form-check-input").click(function(){
                    var value = $(this).val();
                    var id_pegawai = '<?php echo $id_pegawai;?>';
                    var persen = 0;
                    
                        $.ajax({
                                type:"POST",
                                dataType:"html",
                                url:"<?php echo base_url();?>admin/penilaian_kinerja/ajaxGetPoinPerilaku",
                                data:"value="+value+'&id_pegawai='+id_pegawai,
                                success:function(msg){
                                $("#poin_perilaku").html(msg);
                                var persen = msg*10;
                                $("#persen").html('<div class="h-3.5 rounded bg-green-500" style="width:'+persen+'%"></div>'); 
                                
                                }
                                
                            });

                    });
            </script>


    </body>
</html>
