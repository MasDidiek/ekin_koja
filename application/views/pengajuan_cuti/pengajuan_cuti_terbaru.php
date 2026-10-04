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

        .text-link-cuti{
            text-decoration: none;
            color:#c1c4c8;
        }
        .text-link-cuti:hover{
            text-decoration: underline;
            color: #0d6efd;
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
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pengajuan Cuti</a></li>
                                            <li class="breadcrumb-item active">Detail Pengajuan Cuti</li>
                                        </ol>
                                    </div>
                                    <h4 class="page-title">Data Pengajuan Cuti</h4>
                                </div>
                            </div>
                        </div>
                        <!-- end page title -->


                        <div class="row">

                              <div class="col-xl-12 col-lg-12">
                                  <div class="card">
                                    <div class="card-body">

                                        <h4>Pengajuan Cuti Pegawai</h4>

                                        <?php

                                           // print_array($this->session->userdata);
                                             $status_session = $this->session->userdata('status_cuti');
                                             $id_validator_cuti = $this->session->userdata('id_validator_cuti');
                                             $arrayStatus =  array('PENDING 0','PENDING 1','PENDING 2','APPROVE','CANCEL','REJECT') ;

                                             $usergroup = $this->session->userdata('usergroup');

                                             $filter_date_cuti = $this->session->userdata('tanggal_cuti');
                                             //print_array($validator);
                                             if($filter_date_cuti != ''){
                                                $filter_date = format_view($filter_date_cuti);
                                             }else{
                                                $filter_date = '--SEMUA--';
                                             }
                                        ?>


                                        <div class="row mt-4">


                                             <?php    if($usergroup < 2){?>



                                                <div class="col-md-3">

                                                 <div class="mb-3 position-relative">
                                                    <label  class="form-label" for="puskesmas">Penanggung Jawab</label>
                                                        <select name="id_validator" id="validator" class="form-control">
                                                            <option value="0">--SEMUA--</option>
                                                                <?php
                                                                    for ($i=0; $i < count($validator); $i++) {
                                                                        $nama_validator= $validator[$i]->nama;
                                                                        if ($id_validator_cuti == $validator[$i]->id_pegawai) {
                                                                            echo '<option value="'.$validator[$i]->id_pegawai.'" selected>'.$nama_validator.'</option>';
                                                                        } else {
                                                                            echo '<option value="'.$validator[$i]->id_pegawai.'">'.$nama_validator.'</option>';
                                                                        }

                                                                    }
                                                                ?>

                                                        </select>
                                                    </div>
                                                    </div>
                                                 <?php } ?>

                                                    <div class="col-md-2">

                                                        <div class="mb-3 position-relative" id="datepicker4">
                                                            <label class="form-label">Filter By Date</label>
                                                            <input type="text" class="form-control" name="tgl" id="tgl_cuti" value="<?php echo $filter_date;?>" data-provide="datepicker" date-format="dd-mm" data-date-autoclose="true" data-date-container="#datepicker4">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                            <label class="form-label">&nbsp;</label> <br>
                                                            <button type="submit" class="btn btn btn-info btn-submit">Submit</button>
                                                    </div>



                                        </div>


                                    <br>
                                        <p>

                                        <strong>Filter Status Cuti</strong> &nbsp;&nbsp; <br>
                                        <?php
                                            for ($i=0; $i < count($arrayStatus); $i++) {
                                                $status_cuti = $arrayStatus[$i];
                                                if($status_cuti == 'PENDING 0'){
                                                    $title_status = 'Menunggu ACC Pengganti ';
                                                }else if($status_cuti == 'PENDING 1'){
                                                    $title_status = 'Menunggu ACC Kapustu/Kasatpel ';
                                                }else if($status_cuti == 'PENDING 2' || $status_cuti == 'PENDING 3'){
                                                    $title_status = 'Menunggu ACC Ka. TU ';
                                                }elseif($status_cuti == 'APPROVE'){
                                                    $title_status = 'Disetujui ';
                                                }else if($status_cuti == 'CANCEL'){
                                                    $title_status = 'Dibatalkan ';
                                                }else if($status_cuti == 'REJECT'){
                                                    $title_status = 'Tidak Disetujui ';
                                                }



                                                echo '<a href="'.base_url().'admin/pengajuan_cuti/set_session/'.url_title($status_cuti).'" class="text-link-cuti" title=" '.$title_status.'"> <strong>'.$status_cuti.'</strong></a> &nbsp;&nbsp; | &nbsp;&nbsp;';

                                            }

                                        ?>


                                        <form method="post" action="<?php echo base_url('admin/pengajuan_cuti/search_pegawai'); ?>" style="display: inline-block;">
                                            <div class="input-group" style="width: 500px;">
                                                <input type="text" class="form-control" name="nama_pegawai" id="search_pegawai" value="" placeholder="Search Pegawai">
                                                <button class="btn btn-primary" type="submit">
                                                    <i class="uil uil-search"></i>
                                                </button>
                                            </div>
                                        </form>

                                        </p>

                                        <div class="table-responsive">

                                            <table class="table mt-2">
                                                <tr class="fs-5 bg-light">
                                                <th>No</th>
                                                    <th>Tgl Pengajuan</th>
                                                    <th>Jenis Cuti</th>
                                                    <th>Nama</th>
                                                    <th>Lama Cuti</th>
                                                    <th>Tanggal Mulai</th>
                                                    <th>Tanggal Akhir</th>
                                                    <th>Alasan Cuti</th>
                                                    <th>Status</th>
                                                </tr>

                                                <?php
                                                // print_array($cutiPegawai);
                                                        $offset = $this->uri->segment(4);
                                                        if($offset==''){
                                                            $offset = 0;
                                                        }

                                                        $no = 0;
                                                        for ($i=0; $i < count($cutiPegawai) ; $i++) {
                                                            $tgl_pengajuan = $cutiPegawai[$i]->tgl;
                                                            $nama_pegawai = $cutiPegawai[$i]->nama;
                                                            $tgl_dari = $cutiPegawai[$i]->tgl_dari;
                                                            $tgl_sampai = $cutiPegawai[$i]->tgl_sampai;
                                                            $hari_cuti = $cutiPegawai[$i]->hari_cuti;
                                                            $status = $cutiPegawai[$i]->status;
                                                            $alasan_cuti = $cutiPegawai[$i]->alasan_cuti;
                                                            $jns_cuti = $cutiPegawai[$i]->jns_cuti;
                                                            $id_cuti = $cutiPegawai[$i]->id;

                                                            $no = $i + 1 + $offset;

                                                            if($status=='PEND0'){
                                                                $flag_status = '<span class="text-warning" title="pending menunggu acc pengganti"><i class="uil-info-circle"></i> Pending</span>';
                                                            }else if($status=='PEND1'){
                                                                $flag_status = '<span class="text-primary" title="pending menunggu acc Kapustu/Kasatpel"><i class="uil-info-circle"></i> Pending </span>';
                                                            }else if($status=='PEND2'){
                                                                $flag_status = '<span class="text-info" title="pending menunggu acc Ka. TU"><i class="uil-info-circle"></i> Pending</span>';
                                                            }else if($status=='PEND3'){
                                                                $flag_status = '<span class="text-success" title="pending menunggu acc Ka. TU"><i class="uil-info-circle"></i>  Pending</span>';
                                                            }else if($status=='APPROVE'){
                                                                $flag_status = '<span class="text-success" title="disetujui"><i class="uil-check"></i> Disetujui</span>';
                                                            }else if($status=='CANCEL'){
                                                                $flag_status = '<span class="text-danger" title="dibatalkan"><i class="uil-times-circle"></i> Dibatalkan</span>';
                                                            }else if($status=='REJECT'){
                                                                $flag_status = '<span class="text-danger" title="tidak disetujui"><i class="uil-exclamation-triangle"></i> </span>';
                                                            }

                                                            if ($jns_cuti==1){
                                                                $jenis_cuti = 'Cuti Tahunan';
                                                            }else if($jns_cuti==2){
                                                                $jenis_cuti = 'Cuti Melahirkan';
                                                            }else if($jns_cuti==3){
                                                                $jenis_cuti = 'Cuti Alasan Penting';
                                                            }else if($jns_cuti==4){
                                                                $jenis_cuti = 'Cuti Sakit';
                                                            }else if($jns_cuti==5){
                                                                $jenis_cuti = 'Cuti Besar';
                                                            }else{
                                                                $jenis_cuti = 'Cuti Lainnya';
                                                            }

                                                            echo '  <tr class="fs-5 fw-bold">
                                                                        <td>'.$no .'</td>
                                                                        <td>'.format_view($tgl_pengajuan).'</td>
                                                                        <td>'.$jenis_cuti .'</td>
                                                                        <td> <a href="'.base_url().'cuti/detail_pengajuan_cuti/'.$id_cuti.'"> '.$nama_pegawai.'</a></td>
                                                                        <td>'.$hari_cuti.' hari</td>
                                                                        <td>'.format_view($tgl_dari).'</td>
                                                                        <td>'.format_view($tgl_sampai).'</td>
                                                                        <td>'.$alasan_cuti.'</td>
                                                                        <td>'.$flag_status.'</td>
                                                                </tr>';
                                                        }
                                                ?>

                                            </table>
                                        </div>

                                    </div>
                                    <div class="ms-4">  Total : <strong><?php echo $num_row;?> </strong> Rows</div>

                                  <div class="me-4">  <?php echo $pagination;?></div>
                                  </div>

                             </div>



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
             $(".btn-submit").click(function(){
                var tgl = $("#tgl_cuti").val();

                $.ajax({

                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/pengajuan_cuti/set_session_tanggal",
                            data:"tgl="+tgl,
                            success:function(msg){
                             window.location.reload();
                              //$("#modal-form").html(msg);
                              //console.log(msg);
                            }

                      });

              });

              $("#validator").change(function(){
                var id_validator = $(this).val();

                $.ajax({

                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/pengajuan_cuti/set_session_validator",
                            data:"id_validator="+id_validator,
                            success:function(msg){
                             window.location.reload();
                              //$("#modal-form").html(msg);
                              //console.log(msg);
                            }

                      });

              });
        </script>


    </body>
</html>
