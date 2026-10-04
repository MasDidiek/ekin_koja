<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <script type="text/javascript" src="<?php echo base_url();?>assets/js/signature.js"></script>

    <style>
     .btn-xs{
        padding:2px 5px;
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



                                    $periode = $periode_tahun.'-'.$periode_bulan;
                                    $periode = date('F Y', strtotime($periode));

                               ?>

                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                    <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none card-drop p-0" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a href="<?php echo base_url();?>laporan/dataraw_spj_ttd_gaji" class="dropdown-item">Raw Data</a>
                                                <a href="<?php echo base_url();?>admin/listing_tkd/export_spj_ttd_gaji" class="dropdown-item">Export Report</a>
                                            </div>
                                        </div>
                                        <h4 class="header-title">Data Tanda tangan SPJ Gaji Pegawai</h4>
                                                <strong>Periode : <?php echo  $periode ;?> </strong>
                                            <?php
                                                //$totalRow = 1;
                                                $totalRow = count($data_gaji);
                                                $numTTD = 0;
                                                for ($i=0; $i < count($data_gaji); $i++) {

                                                      $ttd_spj = $data_gaji[$i]->ttd_spj;
                                                      if($ttd_spj !=''){
                                                        $numTTD =  $numTTD +1;


                                                      }


                                                }

                                                $persentage = ($numTTD/$totalRow)*100;
                                                $persentage = ceil($persentage);
                                            ?>
                                        <div id="views-min" class="apex-charts mt-2" data-colors="#0acf97"></div>

                                                                                    <!-- Success -->
                                            <div class="progress">
                                                <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $persentage ;?>%" aria-valuenow="<?php echo $persentage ;?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>

                                              <h5>
                                            <?php
                                                echo  '<span class="text-warning">'.$numTTD.' </span>/ '.$totalRow .' rows &nbsp; ( '. $persentage.'%)';
                                            ?>

</h5>




                                        <div class="table-responsive mt-3">
                                            <table class="table table-sm mb-0 table-bordered">
                                                <thead>
                                                       <tr>
                                                            <th class="text-center">No.</th>
                                                            <th>Nama</th>
                                                            <th>Jabatan</th>
                                                            <th>NIK</th>
                                                            <th>No Rekening</th>
                                                            <th class="text-center">Total </th>
                                                            <th class="text-center">No Handphone</th>
                                                            <th class="text-center">TTD</th>
                                                            <th  class="text-center">Action</th>
                                                        </tr>
                                                </thead>
                                                <tbody>

                                                <?php


                                                    $no = 1;
                                                    foreach ($data_gaji as $peg){

                                                    $nama = $peg->nama;
                                                    $npwp = $peg->nik;

                                                    $jabatan = $peg->jabatan;
                                                    $netto = $peg->netto;

                                                    $no_hp  = '';
                                                    $ttd_spj = $peg->ttd_spj;

                                                    $cekNama = $this->db->get_where('mst_pegawai',array('nama'=>$nama))->row();
                                                    //print_r($cekNama);
                                                    if($cekNama == null){
                                                        $nama = '<span class="text-danger">'.$nama.'</span>';
                                                    }else{
                                                        $nama = '<span class="text-info">'.$nama.'</span>';

                                                    }



                                                    if($ttd_spj==''){
                                                        $btn_ttd = '<span class="badge bg-danger">Belum</span>';
                                                        $no_hp = '';
                                                        $btn_reset = '
                                                        <a href="#" class="btn btn-xs btn-light" disabled>
                                                             <i class="mdi mdi-refresh"></i>
                                                        </a>
                                                         <button type="button" class="btn btn-xs btn-success edit-data-listing" value="'.$peg->nik.'" data-bs-toggle="modal" data-bs-target="#formModal">
                                                            <i class="mdi mdi-pencil"></i>
                                                        </button>
                                                        ';
                                                    }else{
                                                        $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="100">';
                                                        $no_hp = $peg->no_hp;
                                                        $btn_reset = '<a href="'.base_url().'admin/listing_tkd/reset_tdd_gaji/'.$peg->id.'" class="btn btn-xs btn-info" onClick="return confirm(\'apakah anda ingin mereset tandatangan ini?\')">
                                                             <i class="mdi mdi-refresh"></i>
                                                        </a>
                                                         <button type="button" class="btn btn-xs btn-success edit-data-listing" value="'.$peg->nik.'" data-bs-toggle="modal" data-bs-target="#formModal">
                                                             <i class="mdi mdi-pencil"></i>
                                                        </button>';
                                                    }



                                                        echo' <tr>
                                                                    <td class="text-center">'.$no.'</td>
                                                                    <td class="text-left"> '.$nama.'</td>

                                                                    <td class="text-left">'.$jabatan.'</td>
                                                                     <td class="text-center">'.$npwp.'  <button  type="button" value="'.$npwp.'/'.$peg->id.'" class="btn btn-sm edit_npwp" data-bs-toggle="modal" data-bs-target="#bs-example-modal-sm"> <i class="mdi mdi-pencil"></i></button> </td>
                                                                   <td class="text-left">'.$peg->no_rekening.'</td>
                                                                     <td class="text-end">'.rupiah($netto).'</td>

                                                                    <td class="text-center">'.$no_hp.'</td>
                                                                    <td class="text-center">'.$btn_ttd.'</td>
                                                                    <td class="text-center">'.$btn_reset.'</td>

                                                                </tr>';

                                                            $no += 1;

                                                    }

                                                    ?>

                                                </tbody>
                                            </table>
                                        </div>
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->

                            </div>

                            <div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="formModalLabel">Update Data listing Gaji</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">
                                                    Loading
                                        </div>
                                    </div>
                                </div>
                            </div>




                    </div> <!-- container -->

                </div> <!-- content -->
                <div class="modal fade" id="bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="mySmallModalLabel">Small modal</h4>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="<?php echo base_url();?>admin/listing_tkd/update_npwp">
                                     <input type="text" name="npwp_edit" value="" id="npwp_edit" class="form-control">
                                     <input type="text" name="id_spj" value="" id="id_spj">

                                     <br>
                                     <button type="submit" class="btn btn-success">Update</button>

                            </form>
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
         <script src="<?php echo base_url();?>assets/new/js/pages/demo.toastr.js"></script>
        <!-- demo end -->

        <script>
        var message = '<?php echo $message;?>';

        if(message != ''){
            $.NotificationApp.send("Berhasil",message,"top-right","rgba(0,0,0,0.2)","success")
        }

        $(".edit_npwp").click(function(){
            var data_value  = $(this).val();
            var expl = data_value.split("/");
            var npwp = expl[0];
            var id = expl[1];

            //alert(npwp);
            $("#id_spj").val(id);
            $("#npwp_edit").val(npwp);

        });

        $(".edit-data-listing").click(function(){
            var nik  = $(this).val();


            $.ajax({
            url: "<?php echo base_url();?>admin/listing_tkd/updateEditListingGaji",
            type: "POST",
            data: {nik:nik},
            dataType: "html",

            success: function(response) {
            // console.log(response);
                $("#formModal .modal-body").html(response);
            },
            error: function() {
                alert("An error occurred while fetching data.");
            }
            });
        });
        </script>

    </body>
</html>
