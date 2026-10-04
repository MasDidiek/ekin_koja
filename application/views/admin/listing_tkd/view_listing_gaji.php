<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/buttons.bootstrap5.css" rel="stylesheet" type="text/css" />



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
                          $message  = $this->session->flashdata('message');


                          $list_bulan = array_bulan();


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

                           $nm_bulan = getBulan($bulan);

                           $listingSesuai = $this->Laporan_model->getListingTKDByStatus($periode, 1);
                           $listingBlmSesuai = $this->Laporan_model->getListingTKDByStatus($periode, 0);
                           $totalRow = $listingBlmSesuai+$listingSesuai;
                         ?>

                            <div class="col-xxl-12col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Data Listing Gaji</h4>
                                        <br>

                                         <?php echo  $listingSesuai.' / '.$totalRow ;?> Sesuai
                                        <div class="row mt-2 mb-3">

                                                <div class="col-md-3">
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
                                                <div class="col-md-6">

                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#import-modal" class="btn btn-light float-end"><i class="uil-download-alt"></i> Import File</button>

                                                        <a href="<?php echo base_url();?>admin/listing_tkd/view_daftar_ttd_gaji" class="btn btn-success me-2 float-end" ><i class="uil-file-alt"></i> Lihat TTD SPJ</a>

                                                        <div class="clearfix"></div>
                                                </div>




                                      </div><!--end grid-->

                                      <div id="loading-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="standard-modalLabel">Update Data Listing TKD</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                </div>
                                                <div class="modal-body">

                                                   <div class="text-center p-4">
                                                         <div class="spinner-grow text-primary" role="status"></div>
                                                        <div class="spinner-grow text-secondary" role="status"></div>
                                                        <div class="spinner-grow text-success" role="status"></div>
                                                        <div class="spinner-grow text-danger" role="status"></div>
                                                        <div class="spinner-grow text-warning" role="status"></div>
                                                        <div class="spinner-grow text-info" role="status"></div>
                                                        <div class="spinner-grow text-light" role="status"></div>
                                                        <div class="spinner-grow text-dark" role="status"></div>

                                                        <h5>Loading....</h5>
                                                   </div>



                                                </div>

                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->



                                        <table id="datatable-buttons" class="table table-sm dt-responsive nowrap w-100">
                                                <thead class="bg-light">
                                                      <tr>

                                                          <th>No</th>
                                                          <th>Nama Pegawai</th>

                                                          <th>NPWP</th>
                                                          <th>Gaji Pokok</th>
                                                          <th>Tunj. Suami</th>
                                                          <th>Tunj. Anak 1</th>
                                                          <th>Tunj. Anak 2</th>
                                                          <th>Pajak</th>

                                                          <th>Netto</th>
                                                          <th>No Rekening</th>
                                                          <th>TTD SPJ</th>
                                                      </tr>
                                                  </thead>
                                                  <tbody class="list form-check-all">
                                                  <?php

                                                         $total_bruto = 0;
                                                         $total_pajak = 0;

                                                         $total_thp = 0;

                                                          $no = 1;
                                                          foreach ($data_gaji as $peg){

                                                          $nama = $peg->nama;

                                                          $jabatan = $peg->jabatan;



                                                          $ttd_spj = $peg->ttd_spj;

                                                          if($ttd_spj  == ''){
                                                             $flag_status = '<span class="badge badge-warning-lighten">Belum </span>';
                                                             $btn_check = '<a href="'.base_url().'admin/listing_tkd/cekSesuai/'.$peg->id.'" class="text-info float-end"> <i class="mdi mdi-account-edit me-1"></i></a>';

                                                          }else{
                                                              $flag_status = '<span class="badge badge-success-lighten">Sudah</span>';
                                                               $btn_check = '';
                                                          }

                                                             $total_bruto = $total_bruto+$peg->bruto;
                                                             $total_pajak = $total_pajak+$peg->pajak;

                                                             $total_thp = $total_thp+$peg->netto;

                                                              echo' <tr>
                                                                      <td class="text-center ">'.$no.'</td>
                                                                      <td class="text-left  nama_pegawai">   '.$peg->nama.'
                                                                      </td>
                                                                      <td class="text-center">'.$peg->nik.'</td>
                                                                      <td class="text-center  tkd_pokok">'.rupiah($peg->gaji_pokok).'</td>
                                                                      <td class="text-end">
                                                                       <strong>'.rupiah($peg->tunj_suami).'</strong>  </td>
                                                                      <td class="text-end">'.rupiah($peg->tunj_anak1).'</td>
                                                                      <td class="text-end">'.rupiah($peg->tunj_anak2).'</td>
                                                                      <td class="text-end">'.rupiah($peg->pajak).'</td>
                                                                      <td class="text-end"> <strong>'.rupiah($peg->netto).'</strong></td>
                                                                      <td class="text-center">'.$peg->no_rekening.'</td>
                                                                      <td class="text-center">'.$flag_status.'</td>

                                                                      </tr>';

                                                                  $no += 1;

                                                          }

                                                       ?>



                                                  </tbody>

                                                    <tr>
                                                        <th>Total</th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th><?php echo rupiah($total_bruto);?></th>
                                                        <th><?php echo rupiah($total_pajak);?></th>

                                                        <th><?php echo rupiah($total_thp);?></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>

                                              </table>





                                    </div>
                                </div>
                            </div> <!-- end col-->
                        </div>
                     </div>
                  </div> <!-- container -->
                </div> <!-- content -->

                <div class="modal fade" id="detail_capaian" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="myLargeModalLabel">Capaian Kinerja Pegawai </h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body" id="view_detail_capaian">

                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                <div id="import-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                      <?php
                           // echo form_open_multipart(base_url() . 'admin/listing_tkd/import_file');
                            echo form_open_multipart(base_url() . 'admin/import_data/import_gaji');?>


                          <div class="modal-header">
                              <h4 class="modal-title" id="standard-modalLabel">Import Data</h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                          </div>
                          <div class="modal-body">
                                 <h5>Import Data Gaji</h5><br>
                                <?php
                                    $tahun = date('Y');


                                ?>
                                <div class="row">
                                  <div class="col-sm-4">
                                        <label class="form-label">Periode</label>
                                        <select name="periode" id="periode" class="form-control">
                                            <?php
                                                for ($b=1; $b < 13 ; $b++) {
                                                        if($b < 10){
                                                            $b = '0'.$b;
                                                        }
                                                        $optionPeriode = $tahun.'-'.$b;
                                                    echo '<option value="'.$optionPeriode.'">'.$optionPeriode.'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-sm-8">
                                        <label class="form-label">File input</label>
                                        <input class="form-control" name="file" type="file" required id="inputGroupFile04">
                                    </div>
                                </div>

                                <label class="form-label mt-2">Jenis File input</label>

                                <div class="">
                                    <div class="form-check form-check-inline">
                                        <input type="radio" value="gaji" id="customRadio1" name="jenis_file" class="form-check-input">
                                        <label class="form-check-label" for="customRadio1">Gaji</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" value="tkd"  id="customRadio2" name="jenis_file" class="form-check-input">
                                        <label class="form-check-label" for="customRadio2">TKD</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" value="gaji13" id="customRadio3" name="jenis_file" class="form-check-input">
                                        <label class="form-check-label" for="customRadio3">Gaji ke 13</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input type="radio" value="thr"  id="customRadio4" name="jenis_file" class="form-check-input">
                                        <label class="form-check-label" for="customRadio4">THR</label>
                                    </div>
                                </div>



                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Import File</button>
                          </div>

                          <?php  echo form_close();
                                ?>
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

                <!-- Datatables js -->
        <script src="<?php echo base_url();?>assets/new/js/vendor/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.bootstrap5.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.responsive.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/responsive.bootstrap5.min.js"></script>


        <script src="<?php echo base_url();?>assets/new/js/vendor/dataTables.buttons.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/buttons.bootstrap5.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/buttons.html5.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/buttons.flash.min.js"></script>
        <script src="<?php echo base_url();?>assets/new/js/vendor/buttons.print.min.js"></script>




        <!-- Datatable Init js -->
        <script src="<?php echo base_url();?>assets/new/js/pages/demo.datatable-init.js"></script>


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
                                //window.location.reload();
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



                    <?php

                        if($message){ ?>
                                //toastr.success('<?php echo $message;?>', 'Success!', {timeOut: 5000})
                                document.getElementById("loading-modal").style.display = "none";
                                //$('#loading-modal').modal('hide');
                                //$('#import-modal').modal('hide');

                                // Show the success message
                                var message = '<?php echo $message; ?>';
                                var div = document.createElement('div');
                                div.innerHTML = message;
                                document.body.appendChild(div);

                                // Automatically remove the message after a few seconds
                                setTimeout(function() {
                                    document.body.removeChild(div);
                            }, 5000); // Adjust the time as needed (5000ms = 5 seconds)

                    <?php  }  ?>


        </script>




    </body>
</html>
