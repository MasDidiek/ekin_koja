<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    
    <script type="text/javascript" src="<?php echo base_url();?>assets/js/signature.js"></script>

    <style>
        .my-table{
            width: 100%;
        }
        .my-table  td{
            padding:2px;
           
        }
        .btn-list {
            padding:10px 15px;
            text-align:center;
            border-bottom:1px solid #EEE;
            color:#666;
            margin-right:2px;
        }

        .active-btn{
            border-bottom:1px solid #66bad9;
            color:orange;
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

                       
                        <?php
                            $message = $this->session->flashdata('message');
                           
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
                                            <li class="breadcrumb-item active">Main Dashboard</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Dashboard</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <?php

                                    $list_bulan = array_bulan();

                                    $periode_bulan = $this->session->userdata('periode_bulan'); 
                                    $periode_tahun = $this->session->userdata('periode_tahun'); 
                                    $id_pkm_sess   = $this->session->userdata('id_pkm');

                                  
                                    $bulan = $periode_bulan;
                                   // $tahun = $periode_tahun;
                                    $id_pegawai = $this->session->userdata('id_pegawai');

                                    $nama_user =  $this->session->userdata('nama');
                                    $nip_user =  $this->session->userdata('nip');
                                    $id_pegawai =  $this->session->userdata('id_pegawai');
                                    $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);
                                    $jns_pegawai =  $this->session->userdata('jns_pegawai');
                                    $tahun = $this->input->get('tahun')?? date('Y');


                                   $pin 	= substr($nip_user, -4);

                                   $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);

                                   $jabatan   =  $detail_pegawai->jabatan;
                                   $puskesmas =  $detail_pegawai->puskesmas;

                                   $tahun     = $this->input->get('tahun')?? date('Y');

                                  //  print_array($datalist);

                                  //  echo $tahun;

                               ?>



                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body">
                                        <span class="float-start m-2 me-4">
                                            <img src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photo ;?>" style="height: 100px; Width:100px" alt="" class="rounded-circle img-thumbnail">
                                        </span>
                                        <div class="">
                                            <h4 class="mt-1 mb-1"><?php echo  $nama_user ;?></h4>
                                              <p class="font-13"> <?php echo $nip_user;?></p>

                                            <strong class="font-13"> <?php echo $puskesmas;?></strong>
                                              <p class="font-13"> <?php echo $jabatan;?></p>
                                        </div>

                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="javascript:void(0);" class="dropdown-item">Refresh Report</a>
                                                <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            </div>
                                        </div>
                                        <h4 class="header-title">Listing TKD</h4>
                                        <br><br>

                                        <a href="<?php echo base_url();?>profile/my_tkd" class="btn-list active-btn">
                                           Listing  TKD
                                        </a>
                                        <a href="<?php echo base_url();?>profile/my_gaji" class="btn-list">
                                           Listing  Gaji
                                        </a>

                                        <a href="<?php echo base_url();?>profile/my_thr" class="btn-list">
                                         THR
                                        </a>

                                        <div class="table-responsive mt-3">
                                          
                                        <form action="<?php echo base_url();?>profile/my_tkd" method="get">
                                            <label for="tahun">Tahun</label>

                                            <select name="tahun" id="tahun">
                                               <?php
                                                for ($t=2025; $t < 2030; $t++) { 

                                                    if($tahun==$t){
                                                        $select = 'selected';
                                                    }else{
                                                        $select = '';
                                                    }
                                                    echo '<option value="'.$t.'" '.$select.'>'.$t.'</option>';
                                                }

                                               ?>
                                                
                                            </select>

                                            <button type="submit" class="btn btn-sm btn-info">Submit</button>
                                        </form>

                                         <?php if($jns_pegawai=='non_pns' || $tahun  <= 2025){?>
                                            <table class="table table-sm mt-3 mb-0 table-bordered">
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
                                                      for ($i=0; $i <  count($datalist); $i++) { 
                                                            $periode = $datalist[$i]->periode;
                                                            $format_periode = date('F Y', strtotime($periode));
                                                          
                                                            $tkd_pokok = $datalist[$i]->tkd_pokok;
                                                            $totalCapaian = $datalist[$i]->capaian;
                                                            $bruto  = $datalist[$i]->bruto;
                                                            $pph21 = $datalist[$i]->pph21;
                                                            $bpjs = $datalist[$i]->bpjs;
                                                            $bpjs_tk = $datalist[$i]->bpjs_tk;
                                                            $thp = $datalist[$i]->thp;
                                                            $masa_kerja = $datalist[$i]->masa_kerja;

                                                            $ttd_spj = $datalist[$i]->ttd_spj;
                                                            $status = $datalist[$i]->status;

                                                            if($status==0){
                                                                $btn_ttd = '';
                                                            }else{

                                                                if($ttd_spj==''){
                                                                    $btn_ttd = '<button type="button" class="btn btn-info btn-sm ttd_spj"  value="'.$datalist[$i]->id.'/'.$format_periode.'" data-bs-toggle="modal" data-bs-target="#modal-ttd-spj" > TTD</button>';
                                                                }else{
                                                                    $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="100">';
                                                                }
                                                                
                                                            }


                                                         
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
                                                                
                                                                <td  class="text-center"> <a href="'.base_url().'profile/detail_tkd/'.$datalist[$i]->id.'" class="btn btn-primary btn-sm"> Lihat Detail</a></td>
                                                            </tr>';
                                                            
                                                          
                                                      }
                                                    ?>
                                                   
                                                   
                                                </tbody>
                                            </table>
                                        <?php }else {?>
                                        <table class="table table-sm mt-3 mb-0 table-bordered">
                                                <thead>
                                                    <tr>
                                                        
                                                            <th class="text-center">No.</th>
                                                            <th>Periode</th>
                                                            <th class="text-end">TKD Pokok</th>
                                                            <th class="text-end">Potongan Absen</th>
                                                            <th class="text-end">Bruto</th>
                                                            <th class="text-end">PPh21</th>
                                                            <th class="text-end">BPJS</th>
                                                            <th class="text-end">THT</th>
                                                            <th class="text-end">Total</th>
                                                          
                                                            <th class="text-center">Action</th>
                                                        
                                                        </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                      for ($i=0; $i <  count($datalist); $i++) { 
                                                            $periode = $datalist[$i]->periode;
                                                            $format_periode = date('F Y', strtotime($periode));
                                                          
                                                            $tkd_pokok = $datalist[$i]->tkd_pokok;
                                                            $bruto  = $datalist[$i]->bruto;
                                                            $pph21 = $datalist[$i]->pph21;
                                                            $bpjs = $datalist[$i]->bpjs;
                                                            $tht = $datalist[$i]->tht;
                                                            $thp = $datalist[$i]->thp;
                                                            $pot_absensi = $datalist[$i]->pot_absensi;
                                                          
                                                            $ttd_spj = $datalist[$i]->ttd_spj;
                                                            $status = $datalist[$i]->status;

                                                            if($status==0){
                                                                $btn_ttd = '';
                                                            }else{

                                                                if($ttd_spj==''){
                                                                    $btn_ttd = '<button type="button" class="btn btn-info btn-sm ttd_spj"  value="'.$datalist[$i]->id.'/'.$format_periode.'" data-bs-toggle="modal" data-bs-target="#modal-ttd-spj" > TTD</button>';
                                                                }else{
                                                                    $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="100">';
                                                                }
                                                                
                                                            }


                                                         
                                                                echo ' <tr>
                                                                <td class="text-center"> 
                                                                    '.($i+1).'
                                                                </td>
                                                                <td> '.$format_periode .'</td>
                                                                <td class="text-end">'.rupiah($tkd_pokok).'</td>
                                                                <td class="text-end">'.rupiah($pot_absensi).'</td>
                  
                                                                <td class="text-end">'.rupiah($bruto).'</td>
                                                                <td class="text-end">'.rupiah($pph21).'</td>
                                                                <td class="text-end">'.rupiah($bpjs).'</td>
                                                                <td class="text-end">'.rupiah($tht).'</td>
                                                                <td class="text-end  fw-bold">'.rupiah($thp).'</td>
                                                                
                                                                <td  class="text-center"> <a href="'.base_url().'profile/detail_tkd/'.$datalist[$i]->id.'/'.$tahun .'" class="btn btn-primary btn-sm"> Lihat Detail</a></td>
                                                            </tr>';
                                                            
                                                          
                                                      }
                                                    ?>
                                                   
                                                   
                                                </tbody>
                                            </table>

                                            <div class="alert">
                                                NB : <br>
                                                Potongan absensi  = potongan karena izin, sakit, atau tidak hadir
                                            </div>

                                        <?php } ?>

                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>

                            <div class="modal fade" id="modal-ttd-spj" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Tanda tangan SPJ TKD</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                             <form method="post" action="<?php echo base_url();?>profile/insert_tdd_spj" enctype="multipart/form-data">
                                                Periode TKD :  <input type="text" name="periode" readonly class="form-control"  value="" id="periode">
                                                <br><br>
                                                    <div class="flex flex-wrap gap-2">
                                                        
                                                            <div id="signature-pad">
                                                                <div style="border:solid 1px teal; width:360px;height:110px;padding:3px;position:relative;">
                                                                    <div id="note" onmouseover="my_function();">Tanda tangan harus di dalam kotak</div>
                                                                    <canvas id="the_canvas" width="350px" height="100px"></canvas>
                                                                </div>

                                                                <div style="margin:10px;">
                                                                    <input type="hidden" id="id_spj" name="id_spj" value="">
                                                                    <input type="hidden" id="signature" name="signature">
                                                                    <button type="button" id="clear_btn" class="btn btn-danger" data-action="clear"><span class="glyphicon glyphicon-remove"></span> Clear</button>
                                                                    <button type="submit" id="save_btn" class="btn btn-primary" data-action="save-png"><span class="glyphicon glyphicon-ok"></span> Submit</button>
                                                                </div>
                                                            </div>
                                                        <form>
                                                        
                                                    </div>
                                                
                                                <br>
                                              
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->


                            <div class="modal fade" id="modal-info-tkd" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="mySmallModalLabel">Detail Tunjangan</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div id="detail_tkd"></div>   
                                              
                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->



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
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

        <script>
            var message = '<?php echo $message;?>';

            if(message != ''){
                $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
            }
          
        </script>



        <script>

                $(".ttd_spj").click(function(){
                    var data = $(this).val();
                    var expl  = data.split('/');
                    var id = expl[0];
                    var periode = expl[1];
                    
                    $("#periode").val(periode);
                    $("#id_spj").val(id);

                });



                
                var wrapper = document.getElementById("signature-pad");
                var clearButton = wrapper.querySelector("[data-action=clear]");
                var savePNGButton = wrapper.querySelector("[data-action=save-png]");
                var canvas = wrapper.querySelector("canvas");
                var el_note = document.getElementById("note");
                var signaturePad;
                signaturePad = new SignaturePad(canvas);
                clearButton.addEventListener("click", function (event) {
                document.getElementById("note").innerHTML="The signature should be inside box";
                signaturePad.clear();
                });
                savePNGButton.addEventListener("click", function (event){
                if (signaturePad.isEmpty()){
                    alert("Please provide signature first.");
                    event.preventDefault();
                }else{
                    var canvas  = document.getElementById("the_canvas");
                    var dataUrl = canvas.toDataURL();
                    document.getElementById("signature").value = dataUrl;
                }
                });
                function my_function(){
                document.getElementById("note").innerHTML="";
                }



                </script>

    </body>
</html>
