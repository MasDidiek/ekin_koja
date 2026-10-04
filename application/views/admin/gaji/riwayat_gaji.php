<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />

    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":false, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
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

                                $bulan_filter    = $this->session->userdata('bulan_tmt');
                                $tanggal_recount = $this->session->userdata('tanggal_recount');

                                //print_array($pegawai);

                                $nama_pegawai = $pegawai[0]->nama;
                                $nip = $pegawai[0]->nip;
                                $jabatan = $pegawai[0]->jabatan;
                                $puskesmas = $pegawai[0]->puskesmas;
                                $tgl_masuk = $pegawai[0]->tgl_masuk;
                              
                        ?>


                            <div class="col-xxl-12 col-lg-12">
                                <div class="card widget-flat">
                                    <div class="card-body text-left">
                                        <h4>Datalist Riwayat Gaji</h4>
                                        <br>

                                        <table>
                                            <tr>
                                                <td width="130">Nama</td>
                                                <td width="30">:</td>
                                                <td>  <strong><?= $nama_pegawai; ?></strong> </td>
                                            </tr>
                                             <tr>
                                                <td>NIP</td>
                                                <td>:</td>
                                                <td><?= $nip; ?></td>
                                            </tr>
                                             <tr>
                                                <td>Jabatan</td>
                                                <td>:</td>
                                                <td><?= $jabatan; ?></td>
                                            </tr>
                                             <tr>
                                                <td>Unit Kerja</td>
                                                <td>:</td>
                                                <td><?= $puskesmas; ?></td>
                                            </tr>
                                             <tr>
                                                <td>Tgl Masuk</td>
                                                <td>:</td>
                                                <td><?= $tgl_masuk; ?></td>
                                            </tr>
                                        </table>
                                     



                                           <table id="datatable-buttons"   class="table dt-responsive nowrap mt-3 w-100">
                                                    <thead class="bg-light">
                                                        <tr>
                                                            <th class="w-1">No.</th>
                                                
                                                            <th class="text-center">TMT</th>
                                                            <th class="text-center">Masa Kerja</th>
                                                            <th class="text-center">Gaji Pokok</th>
                                                            <th class="text-center">Pengali </th>
                                                            <th class="text-center">TKD Pokok </th>
                                                            <th class="text-center">Update On</th>
                                                            <th class="text-center">Proyeksi</th>
                                                            <th class="text-center">Action</th>
                                                
                                                        </tr>
                                                    </thead>
                                                    <tbody>


                                                       <?php

                                                            $no = 1;

                                                            $tahunNow = date('Y');
                                                            $bulanNow = date('m');
                                                            $bulanLalu = $bulanNow-1;

                                                            foreach ($riwayat_gaji as $riwayat){
                                
                                                                
                                                                    $nip = $riwayat->nip;
                                                                    $tmt = $riwayat->tmt;
                                                          
                                                                    $masa_kerja_tahun = $riwayat->masa_kerja_tahun;
                                                                    $masa_kerja_bulan = $riwayat->masa_kerja_bulan;
                                                                   // $kategori_masa_kerja = $riwayat->kategori_masa_kerja; 
                                                                    $gaji_pokok = $riwayat->gaji_pokok;
                                                                    $pengkalian = $riwayat->pengali;
                                                                    $tkd_pokok = $riwayat->total_gaji; //total gaji adalah tkd pokok
                                                                    $update_on = $riwayat->created_at;
                                                                  
                                                                  
                                                                    $bulanTMT = date('m', strtotime($tmt));
                                                                    $tahunTMT = date('Y', strtotime($tmt));

                                                
                                                                    if($bulanLalu==$bulanTMT){
                                                                        $class = ' fw-bold text-warning';                                                               
                                                                    }else{
                                                                        $class = '';
                                                                    }

                                                                    $is_proyeksi = $riwayat->is_proyeksi;
                                                                    if($is_proyeksi==1){
                                                                        $flag_proyeksi = 'Ya';
                                                                    }else{
                                                                         $flag_proyeksi = '-';
                                                                    }

                                                                  
                                                                            echo' <tr>
                                                                                    <td class="">'.$no.' </td>
                                                                                    
                                                                                    <td class="text-center '.$class.'">'.format_semi($tmt).'</td>
                                                                                    <td class="text-center">'.$masa_kerja_tahun.' tahun '.$masa_kerja_bulan.' bulan</td>
                                                                                   
                                                                                    <td class="text-center"> '.rupiah($gaji_pokok).'</td>
                                                                                    <td class="text-center"> <strong>'. $pengkalian.'</strong></td>
                                                                                    <td class="text-center">'.rupiah($tkd_pokok).'</td>
                                                                                    <td class="text-center">'.$flag_proyeksi.'</td>
                                                                                    <td class="text-center">'. $update_on.'</td>
                                                                                    <td class="text-center"> 
                                                                                        <button 
                                                                                                type="button"
                                                                                                class="btn btn-info btn-sm btn-edit-gaji"
                                                                                                data-bs-toggle="modal"
                                                                                                data-bs-target="#edit-modal"

                                                                                                data-id="'.$riwayat->id .'"
                                                                                                data-tmt="'.$tmt .'"
                                                                                                data-mktahun="'.$masa_kerja_tahun .'"
                                                                                                data-mkbulan="'.$masa_kerja_bulan .'"
                                                                                                data-gaji="'.$gaji_pokok .'"
                                                                                                data-pengali="'.$pengkalian .'"
                                                                                                 data-proyeksi="'.$riwayat->is_proyeksi.'"
                                                                                            >
                                                                                                <i class="uil-edit"></i> Edit
                                                                                            </button>

                                                                                    </td>
                                                                                    
                                                                                </tr>';

                                                                    $no += 1;
                                                                   // }
                                                                    
                                                                        
                                                                        
                                                            }

                                                            ?>
                                                     </tbody>
                                                </table>

                                          <div id="edit-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                <form action="<?=  base_url('admin/gaji/update_riwayat_gaji'); ?>" enctype="multipart/form-data" method="post" accept-charset="utf-8">


                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="standard-modalLabel">Edit Data </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                    
                                                                    <!--form edit disini-->
                                                               <input type="hidden" name="id" id="edit_id">

                                                            <div class="mb-2">
                                                                <label class="form-label">TMT</label>
                                                                <input type="date" class="form-control" name="tmt" id="edit_tmt" readonly>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-2">
                                                                    <label class="form-label">Masa Kerja (Tahun)</label>
                                                                    <input type="number" class="form-control" name="masa_kerja_tahun" id="edit_mk_tahun" min="0">
                                                                </div>

                                                                <div class="col-md-6 mb-2">
                                                                    <label class="form-label">Masa Kerja (Bulan)</label>
                                                                    <input type="number" class="form-control" name="masa_kerja_bulan" id="edit_mk_bulan" min="0" max="11">
                                                                </div>
                                                            </div>

                                                            <div class="mb-2">
                                                                <label class="form-label">Gaji Pokok</label>
                                                                <input type="number" class="form-control" name="gaji_pokok" id="edit_gaji">
                                                            </div>

                                                            <div class="mb-2">
                                                                <label class="form-label">Pengali</label>
                                                                <input type="number" step="0.01" class="form-control" name="pengali" id="edit_pengali">
                                                            </div>

                                                            <div class="mb-2">
                                                                <label class="form-label">TKD Pokok (Auto)</label>
                                                                <input type="text" class="form-control" id="edit_total" readonly>
                                                            </div>

                                                               <div class="mb-2">
                                                                <label class="form-label">Is Proyeksi</label>
                                                                    <div class="form-check mb-2">
                                                                    <input 
                                                                        class="form-check-input"
                                                                        type="checkbox"
                                                                        id="edit_proyeksi"
                                                                        name="is_proyeksi"
                                                                        value="1"
                                                                    >
                                                                    <label class="form-check-label" for="edit_proyeksi">
                                                                        Proyeksi (belum final)
                                                                    </label>
                                                                </div>
                                                            </div>


                                                            
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>

                                                    </form>                      </div><!-- /.modal-content -->
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

           


        <script>
        $(document).on('click', '.btn-edit-gaji', function () {

            let gaji    = $(this).data('gaji');
            let pengali = $(this).data('pengali');
            let proyeksi = $(this).data('proyeksi');


            $('#edit_id').val($(this).data('id'));
            $('#edit_tmt').val($(this).data('tmt'));
            $('#edit_mk_tahun').val($(this).data('mktahun'));
            $('#edit_mk_bulan').val($(this).data('mkbulan'));
            $('#edit_gaji').val(gaji);
            $('#edit_pengali').val(pengali);
            

            // ⭐ INI BAGIAN PENTING
            if (parseInt(proyeksi) === 1) {
                $('#edit_proyeksi').prop('checked', true);
            } else {
                $('#edit_proyeksi').prop('checked', false);
            }
            hitungTotal();
        });

        function hitungTotal() {
            let gaji    = parseFloat($('#edit_gaji').val()) || 0;
            let pengali = parseFloat($('#edit_pengali').val()) || 0;

            let total = gaji * pengali;
            $('#edit_total').val(total.toLocaleString('id-ID'));
        }

        $('#edit_gaji, #edit_pengali').on('input', hitungTotal);
        </script>

    </body>
</html>
