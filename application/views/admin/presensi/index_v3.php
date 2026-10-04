<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <style>
        .btn-xs{
            padding:3px 6px !important;
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
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>dashboard/index">Dashboard</a></li>
                                            <li class="breadcrumb-item"><a href="<?php echo base_url();?>admin/presensi/index_v3">Absensi Pegawai</a></li>
                                            <li class="breadcrumb-item active">Data Absensi</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Data Absensi</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                 <?php
                    $message = $this->session->flashdata('message');

                    $info = $this->session->flashdata('message');

                    $page = $this->uri->segment(4);
                    if($page==''){
                        $page = 0;
                    }

                    $numPage = $page+10;


                    $blmDiRekap = $numAllPegawai-$absensiSesuai-$absensiBlmSesuai;

                    $list_bulan = array_bulan();


                    //print_array( $this->session->userdata);
                    $periode_bulan = $this->session->userdata('periode_bulan');
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

                    $keyword = $this->uri->segment(6);

                    $nm_bulan = getBulan($bulan);



                        $numPegawai = count($pegawai);
                        $numBelumRekap  = 0;
                        $numAbsenSesuai = 0;
                        $numBelumSesuai = 0;

                    for ($i=0; $i < $numPegawai; $i++) {
                            $id_pegawai = $pegawai[$i]->id_pegawai;


                            $dataRekap = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
                            if (!empty($dataRekap)) {

                                $status = $dataRekap[0]->status;
                                if($status==1){
                                    $numAbsenSesuai =  $numAbsenSesuai +1;
                                }else{
                                    $numBelumSesuai = $numBelumSesuai+1;
                                }

                            }else{
                                $numBelumRekap  = $numBelumRekap +1;
                            }
                    }


            ?>


                        <!-- Modal -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <form action="<?php echo base_url();?>admin/import_data/import_absensi" method="post"  enctype="multipart/form-data">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="uploadModalLabel">Upload File TXT</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Tutup">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                </div>
                                <div class="modal-body">

                              <div class="mb-3">
                                        <label class="form-label">File input</label>
                                        <input class="form-control" type="file" name="absensi_file" id="inputGroupFile04">
                                    </div>

                                </div>
                                <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Upload</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                </div>
                            </div>
                            </form>
                        </div>
                        </div>




                        <div class="row">


                        <div class="col-xxl-12 col-lg-12">
                            <div class="card widget-flat">
                             <div class="card-body text-left">
                                <h4>Datalist Pegawai</h4>
                                <!-- Button trigger modal -->
                                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    Import Absensi
                                    </button>


                                <div class="clearfix"></div>
                                <br>



                                <div class="row mt-2 mb-3">


                                        <div class="col-md-3">


                                            <select name="id_validator" id="validator"  class="form-control"  data-choices="">

                                            <?php
                                                foreach ($validator as $pj) {

                                                $id_pj = $pj->id_pegawai;
                                                $nama_pj   = $pj->nama;


                                                if($id_pj_sess==$id_pj){
                                                    echo '<option value="'. $id_pj.'" selected>'.$nama_pj.'</option>';
                                                }else{
                                                    echo '<option value="'. $id_pj.'">'.$nama_pj.'</option>';
                                                }

                                                }
                                            ?>

                                            </select>

                                        </div>
                                        <div class="col-md-2">
                                        <select  name="bulan" id="bulan"  class="form-control"  data-choices="" >
                                            <option value="">Bulan</option>
                                            <?php
                                                for ($b=0; $b < count($list_bulan) ; $b++) {

                                                    $no_bulan = $b+1;

                                                    if($bulan == $b){
                                                        $selc = 'selected';
                                                    }else{
                                                        $selc = '';
                                                    }


                                                    echo '<option value="'.$b.'" '.$selc.'>'.$b.' - '.$list_bulan[$b].'</option>';
                                                }
                                                ?>
                                        </select>

                                        </div>
                                        <div class="col-md-2">
                                            <select  name="tahun" id="tahun" class="form-control"  data-choices="" >
                                            <option value="">Tahun</option>
                                                <?php
                                                    for ($b=2023; $b < 2030 ; $b++) {



                                                        if($periode_tahun == $b){
                                                            $selc2 = 'selected';
                                                        }else{
                                                            $selc2 = '';
                                                        }

                                                        echo '<option value="'.$b.'" '.$selc2.'> '.$b.'</option>';
                                                    }
                                                    ?>
                                        </select>
                                        </div>


                                        <div class="col-md-4">

                                                <input type="text" name="nama_pegawai" id="keyword" class="form-control"  value="<?php echo  $keyword;?>" placeholder="Search for ..." value autocomplete="off">
                                                <i data-lucide="search" class="inline-block size-4 absolute ltr:left-2.5 rtl:right-2.5 top-2.5 text-slate-500 dark:text-zink-200 fill-slate-100 dark:fill-zink-600"></i>

                                        </div>

                                        <div class="col-md-1">
                                            <button type="button" id="search" class="btn btn-info"><i class="align-bottom ri-search-line me-1"></i> Search</button>
                                        </div>


                            </div><!--end grid-->



                    <div class="modal fade" id="bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                          <div class="modal-dialog modal-lg">
                              <div class="modal-content">

                                  <h5 class="text-16">Rekap Absensi</h5>
                                  <div id="modal-info"></div>

                              </div>

                          </div>
                      </div>


                            <table class="table table-sm">
                                <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                                    <tr class="*:px-3.5 *:py-2.5 *:font-semibold *:border-b *:border-slate-200 *:dark:border-zink-500">
                                        <th>#</th>
                                        <th>Employee Name</th>
                                          <?php

                                          $lastDateMonth = date('t', strtotime($periode));
                                            for ($i=1; $i < ($lastDateMonth+1) ; $i++) {
                                              $date =  $periode.'-'.$i;

                                              $tanggal = format_db($date);
                                              $day = date('l', strtotime($tanggal));
                                                if ($day=='Sunday') {
                                                  $hari = 'Mg';
                                                }else if($day=='Monday'){
                                                $hari = 'Sn';
                                                }else if($day=='Tuesday'){
                                                $hari = 'Sl';
                                                }else if($day=='Wednesday'){
                                                $hari = 'Rb';
                                                }else if($day=='Thursday'){
                                                $hari = 'Km';
                                                }else if($day=='Friday'){
                                                $hari = 'Jm';
                                                }else{
                                                $hari = 'Sb';
                                                }

                                              echo ' <th class="text-center">'.$i.' <br>
                                              <small>'.$hari.'</small></th>';
                                            }
                                            ?>


                                    </tr>
                                </thead>
                                <tbody>

                                     <?php


                                              $no = 1;



                                              foreach ($pegawai as $peg){

                                                #print_array($peg);

                                                          $id_pegawai = $peg->id_pegawai;
                                                          $nip = $peg->nip;
                                                          $nama = $peg->nama;
                                                          $jns_jam_kerja = $peg->jns_jam_kerja;
                                                          //$id_pj = $peg->id_validator;

                                                          $pin = substr($nip, -4);

                                                          $dataRekap = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
                                                          if (!empty($dataRekap)) {

                                                              $status = $dataRekap[0]->status;
                                                              if($status==1){
                                                                $flag_rekap = '<i class="uil-shield-check text-success"></i>';
                                                              }else{
                                                                $flag_rekap = '<i class="uil-shield-question  text-warning"></i>';
                                                              }

                                                          }else{
                                                            $flag_rekap = '<i class="uil-exclamation-circle  text-danger"></i>';
                                                          }

                                                          $dataAbsensi  = $this->Presensi_model->getAbsensiPegawai($pin, $periode);

                                                         // print_array($dataAbsensi);

                                                         // flex items-center justify-center text-green-500 bg-green-100 rounded-md size-8 dark:bg-green-500/20 shrink-0


                                                         
                                                          echo ' <tr>
                                                                     <td style="font-size:20px">'.$flag_rekap.'</td>
                                                                    <td>  <a href="'.base_url().'admin/presensi/view_absensi/'.$id_pegawai.'/'.$pin.'" class="btn btn-sm text-start"> '.word_limiter($nama,2).'</a></td>';

                                                                       for ($i=0; $i < count($dataAbsensi); $i++) {
                                                                              $absn_msk = $dataAbsensi[$i]->masuk;
                                                                              $absn_plg = $dataAbsensi[$i]->pulang;
                                                                              $tanggal = $dataAbsensi[$i]->tanggal;
                                                                              $shift   = $dataAbsensi[$i]->shift;

                                                                              if($absn_msk != ''){
                                                                                 $status_absen = 'Y';


                                                                                 if($absn_plg != ''){
                                                                                   $status_absen = '<i class="uil-check"></i>';
                                                                                   $flag = 'badge-info-lighten';
                                                                                 }else{
                                                                                    $status_absen = ' <i class="uil-check"></i>';
                                                                                    $flag = 'badge-warning-lighten';
                                                                                 }

                                                                                 if($absn_msk=='DLP'){
                                                                                    $status_absen = 'DL';
                                                                                      $flag = 'btn-info  fs-6';
                                                                                 }

                                                                                  if($absn_msk=='DLA'){
                                                                                    $status_absen = 'DLA';
                                                                                      $flag = 'btn-info  fs-6';
                                                                                  }


                                                                                 if($absn_msk=='IZIN'){
                                                                                    $status_absen = 'IZ';

                                                                                      $flag = 'btn-warning  fs-6';
                                                                                 }
                                                                                 if($absn_msk=='SAKIT'){
                                                                                    $status_absen = 'SK';
                                                                                    $flag = 'btn-warning  fs-6';
                                                                                 }

                                                                                 if($absn_msk=='SAKIT DGN SURAT'){
                                                                                    $status_absen = 'SK2';
                                                                                    $flag = 'btn-warning fs-6';
                                                                                  }

                                                                                 if($absn_msk=='CUTI'){
                                                                                      $status_absen = 'CT';
                                                                                      $flag = 'btn-success';

                                                                                      $cekCuti = $this->Presensi_model->getJnsCuti($id_pegawai, $tanggal);

                                                                                      if($cekCuti==1){
                                                                                        $status_absen = '<span style="font-size:10px">CT</span>'; //cuti tahunan
                                                                                      }else if($cekCuti==2){
                                                                                        $status_absen = '<span style="font-size:10px">CB</span>'; //cuti bersalin
                                                                                      }else if($cekCuti==3){
                                                                                        $status_absen = '<span style="font-size:10px">CAP</span>'; //cuti bersalin
                                                                                      }else if($cekCuti==4){
                                                                                        $status_absen = '<span style="font-size:10px">CS</span>'; //cuti bersalin
                                                                                      }else{
                                                                                        $status_absen = '<span style="font-size:10px">CBS</span>'; //cuti bersalin
                                                                                      }
                                                                                     // print_array($cekCuti);
                                                                                 }
                                                                              }else{
                                                                                  $status_absen = 'T';


                                                                                  if($absn_plg != ''){
                                                                                    $status_absen = '<i data-lucide="check" class="size-4"></i>';
                                                                                    $flag = 'flex items-center justify-center text-yellow-500 bg-yellow-100 rounded-md size-6 dark:bg-yellow-500/20 shrink-0';


                                                                                  }else{
                                                                                    $status_absen = '<i class="uil-question-circle"></i>';
                                                                                    $flag = 'btn-danger';


                                                                                        $hariLibur = $this->Presensi_model->cekHariLibur($tanggal);
                                                                                        if(!empty($hariLibur )){
                                                                                          $status_absen = '<i class="uil-calendar-slash"></i>';
                                                                                          $flag = 'bg-danger-lighten text-danger';
                                                                                        }


                                                                                          $day  = date('D', strtotime($tanggal));

                                                                                          if($day=='Sun' || $day =='Sat'){
                                                                                            $status_absen = '-';
                                                                                            $flag = 'text-slate-500';
                                                                                          }

                                                                                   }

                                                                                          if($absn_plg=='DLAK'){
                                                                                            $status_absen = 'DL';
                                                                                              $flag = 'btn-info  fs-6';
                                                                                         }



                                                                                } //close if $absn_msk != ''



                                                                                if($jns_jam_kerja=='shift'){
                                                                                    $flag = 'badge-info-lighten';
                                                                                    $status_absen = '<span style="font-size:10px">'.$shift.'</span>';

                                                                                    //echo $absn_msk;
                                                                                    if($shift=='SM'){
                                                                                      if($absn_msk ==''){
                                                                                          $flag = 'btn-danger';
                                                                                      }else{
                                                                                          $flag = 'btn-info';
                                                                                      }
                                                                                    }else if($shift=='L-OFF'){
                                                                                       $status_absen = '<span style="font-size:10px">LO</span>';
                                                                                       if($absn_plg==''){
                                                                                           $flag = 'badge-danger-lighten';
                                                                                       }else{
                                                                                           $flag = 'badge-warning-lighten';
                                                                                       }
                                                                                    }else if($shift=='P'){
                                                                                        $status_absen = '<span style="font-size:10px">PA</span>';
                                                                                      if($absn_msk ==''){

                                                                                          if($absn_plg==''){
                                                                                              $flag = 'badge-danger-lighten0';
                                                                                          }else{
                                                                                              $flag = 'badge-warning-lighten';
                                                                                          }


                                                                                      }else{
                                                                                          if($absn_plg==''){
                                                                                              $flag = 'badge-danger-lighten';
                                                                                          }else{
                                                                                              $flag = 'badge-info-lighten';
                                                                                          }

                                                                                      }
                                                                                    }else if($shift=='PSM'){
                                                                                      if($absn_msk ==''){
                                                                                          $flag = 'badge-danger-lighten';
                                                                                      }else{
                                                                                          $flag = 'badge-info-lighten';
                                                                                      }
                                                                                    }else if($shift=='OFF'){
                                                                                      $flag = 'badge-danger-lighten';
                                                                                    }

                                                                                    if($absn_msk=='CUTI'){
                                                                                        $status_absen = '<span style="font-size:10px">CT</span>';
                                                                                        $flag = 'btn-success';
                                                                                    }
                                                                                  } //close if pegawai shift



                                                                                  echo ' <td>
                                                                                              <button type="button" data-modal-target="extraLargeModal" class="btn btn-xs '.$flag .' btn-info-absensi" value="'.$pin.'/'.$id_pegawai.'/'.$tanggal.'">
                                                                                                '. $status_absen.'
                                                                                              </button>
                                                                                          </td>';




                                                                       }



                                                              echo ' </tr>
                                                                ';


                                                }

                                                ?>


                                           </tbody>
                                        </table>

                                           <nav>

                                                   <?php //echo $pagination; ?>

                                            </nav>


                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                      </div>
                        <!-- end row -->
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
   

    </body>

    <?php
    if($message !=''){
    ?>
    <script>$.NotificationApp.send("Berhasil","<?php echo $message;?>","top-right","rgba(0,0,0,0.2)","success")</script>

    <?php } ?>


<script>



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


   $("#validator").change(function(){
      var id_pj = $(this).val();

      $.ajax({

                  type:"POST",
                  dataType:"html",
                  url:"<?php echo base_url();?>admin/presensi/set_session_validator",
                  data:"id_pj="+id_pj,
                  success:function(msg){
                   window.location.reload();
                    //$("#modal-form").html(msg);
                    //console.log(msg);
                  }

            });

    });


$(".info-rekap").click(function(){

  var id_pegawai = $(this).attr("id");
  $.ajax({

            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>admin/presensi/ajax_get_data_rekap",
            data:"id_pegawai="+id_pegawai,
            success:function(msg){
              $("#modal-info").html(msg);
            }

      });

});

$("#search").click(function(){
  var keyword = $("#keyword").val();
  var keyword = keyword.replace(" ","-");
  window.location.href = "<?php echo base_url();?>admin/presensi/search_result/0/0/"+keyword;
  //alert(keyword);

});



$(document).on('keydown', function(event) {
  if (event.key === 'Enter') {
    var keyword = $("#keyword").val();
    var keyword = keyword.replace(" ","-");
    window.location.href = "<?php echo base_url();?>admin/presensi/search_result/0/0/"+keyword;
  }
});



</script>


</html>
