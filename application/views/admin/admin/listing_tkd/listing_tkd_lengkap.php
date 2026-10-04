<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
            tr td, th{
                border-right: 1px solid #EEE;
                padding:6px;
                text-align: right;
                font-size: 13px;
                color:#555

            }

            .form-periode2{
              display: none;
              width: 15em;
              height: 13em;
              background: #fff;
              position: absolute;
              border: 1px solid #ddd;
              border-radius: 3px;
              padding: 0;
              z-index: 999;
            }

         </style>
</head>

<body>
  <!-- <div class="toast toast-onload align-items-center text-bg-primary border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body hstack align-items-start gap-6">
      <i class="ti ti-alert-circle fs-6"></i>
      <div>
        <h5 class="text-white fs-3 mb-1">Welcome to Modernize</h5>
        <h6 class="text-white fs-2 mb-0">Easy to costomize the Template!!!</h6>
      </div>
      <button type="button" class="btn-close btn-close-white fs-2 m-0 ms-auto shadow-none" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div> -->
  <!-- Preloader -->

  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->
    

      <?php $this->load->view('layout/section/sidebar');?>

<!-- 
            <div  class="fixed-profile p-3 mx-4 mb-2 bg-secondary-subtle rounded mt-3">
              <div class="hstack gap-3">
                <div class="john-img">
                  <img
                    src="../assets/images/profile/user-1.jpg"
                    class="rounded-circle"
                    width="40"
                    height="40"
                    alt=""
                  />
                </div>
                <div class="john-title">
                  <h6 class="mb-0 fs-4 fw-semibold">Mathew</h6>
                  <span class="fs-2">Designer</span>
                </div>
                <button
                  class="border-0 bg-transparent text-primary ms-auto"
                  tabindex="0"
                  type="button"
                  aria-label="logout"
                  data-bs-toggle="tooltip"
                  data-bs-placement="top"
                  data-bs-title="logout"
                >
                  <i class="ti ti-power fs-6"></i>
                </button>
              </div>
            </div>

            <!-- ---------------------------------- -->
            <!-- Start Vertical Layout Sidebar -->
            <!-- ---------------------------------- -
            </div> -->
    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->


      <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8">Listing TKD</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html" >Home</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive">Listing TKD</li>
                        </ol>
                      </nav>
                    </div>
                    <div class="col-3">
                      <div class="text-center mb-n5">
                
                      </div>
                    </div>
                  </div>

                  
                </div>
              </div>
              <?php 
                
                    
                $jns_pegawai = $this->uri->segment(4);
                $message = $this->session->flashdata('message'); 
                $bulan = $this->session->userdata('periode_bulan'); 
                $tahun = $this->session->userdata('periode_tahun'); 

                $periode = $tahun.'-'.$bulan;
                $periode = date('Y-m', strtotime($periode));

                $nm_bulan = getBulan($bulan);
                $listBulan = array_bulan();
                
            ?>

                   
              <div class="row">
                
                <div class="col-lg-12 d-flex align-items-stretch">
                      <div class="card w-100">
                            <div class="card-body p-4">
                              <div class="row loading-update d-none">
                                <div class="col-md-1"> <img src="<?php echo base_url();?>assets/images/loading-blue.gif" width="80"></div>
                                <div class="col-md-6 fs-6 fw-bold text-info pt-4">Updating data ... </div>
                              </div>

                              <div class="col-md-4">
                              <label for="bulan">Periode</label>
                              <input type="text" readonly class="periode" style="width: 150px;" name="periode" id="periode" value="<?php echo $nm_bulan.' &nbsp; &nbsp; '.$tahun;?>">

                              <div class="form-periode2">
                                  <div class="header-periode">
                                    <button type="button" class="btn-prev"><i class="fa-solid fa-angle-left"></i> </button> 
                                    <input type="text" name="periode_tahun" class="tahun_periode" value="<?php echo $tahun;?>" id="tahun">
                                    <button type="button" class="btn-next"><i class="fa-solid fa-angle-right"></i> </button>  
                                  </div>
                                    <div class="body-periode">
                                    <?php
                                      for ($b=1; $b < 13; $b++) { 

                                      if($b==$bulan){
                                        $active = 'bln-active';
                                      }else{
                                        $active = '';
                                      }
                                      echo '<button class="btn-bulan '.$active.'" value="'.$listBulan[$b].'">'.substr($listBulan[$b], 0,3).'</button>';
                                      }
                                    ?>
                                
                              </div>
                        
                          
                      </div><!--form-periode-->
                      
                </div>
                             
                                    <a href="<?php echo base_url();?>admin/listing_tkd/create_listing_tkd/<?php echo $periode;?>" class="btn  float-end btn-success ms-2"> <i class="fa-solid fa-file"></i>&nbsp;  Listing TKD</a>
                                    <a href="<?php echo base_url();?>admin/listing_tkd/update_rekap_tkd/<?php echo $periode;?>" class="btn  float-end btn-info  ms-2"> <i class="fas fa-refresh"></i> Update Rekap</a>
                                   
                                 
                                    <button type="button" class="btn btn-warning  btn-circle float-end btn-xl"   data-bs-toggle="modal" data-bs-target="#import-modal" data-bs-whatever="@mdo">
                                        <i class="fa-solid fa-download"></i>&nbsp; Import Data Pajak
                                    </button>


                                    <div class="clearfix"></div>
                                  <div class="table-responsive mt-4">
                                      <table class="table  table-hover" >
                                          <thead>
                                              <tr>
                                              
                                                <th class="w-1">No.</th>
                                                <th>Nama</th>
                                                <th>Jabatan</th>
                                                <th>NPWP</th>
                                                <th>TKD Pokok</th>
                                                <th>Total Capaian</th>
                                                <th>Sakit</th>
                                                <th>Izin</th>
                                                <th>Telat</th>
                                                <th>P. Awal</th>
                                                <th>Bruto</th>
                                                <th>PPh21</th>
                                                <th>BPJS</th>
                                                <th>BPJS TK</th>
                                                <th>Total</th>
                                                <th>No Rekening</th>
                                                <th>Keterangan</th>
                                          
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php 

echo $periode;
                                                //$waktu_efektif = 6000;
                                                $no = 1;
                                                foreach ($listing_tkd as $peg){

                                                  $nama = $peg->nama;
                                                  $nip = $peg->nip;
                                                  $jabatan = $peg->jabatan;

                                                  $id_pegawai = $this->Pegawai_model->cekData($nip);
                                                 
                                                  $rekapAbsensi = $this->Presensi_model->getDataRekapAbsensiPegawai($id_pegawai,$periode);


                                                    echo' <tr class=" fs-2">
                                                            <td class="text-center">'.$no.' </td>
                                                            <td class="text-start"><a href="'.base_url().'admin/capaian_kinerja/detail_capaian/'.$id_pegawai.'/'.$nip.'">'.$peg->nama.'</a></td>
                                                            <td>'.$jabatan.'</td>
                                                            <td>'.$peg->npwp.'</td>
                                                            <td>'.rupiah($peg->tkd_pokok).'</td>
                                                            <td class="text-danger fw-semibold">'.$peg->capaian.'</td>
                                                            <td>'.$rekapAbsensi[0]->sakit.'</td>
                                                            <td>'.$rekapAbsensi[0]->izin.'</td>
                                                            <td>'.$rekapAbsensi[0]->telat.'</td>
                                                            <td>'.$rekapAbsensi[0]->pulang_awal.'</td>
                                                            <td>'.rupiah($peg->bruto).'</td>
                                                            <td>'.rupiah($peg->pph21).'</td>
                                                            <td>'.rupiah($peg->bpjs).'</td>
                                                            <td>'.rupiah($peg->bpjs_tk).'</td>
                                                            <td>'.rupiah($peg->thp).'</td>
                                                            <td>'.$peg->no_rekening.'</td>
                                                            <td></td>
                                                          
                                                            
                                                        </tr>';

                                                        $no += 1;

                                                }

                                                ?>
                                              
                                          

                                          

                                          
                                          
                                          </tbody>
                                  </table>
                               </div>
                              </div>
                        </div>
                  </div>
            </div>
           

            <div class="modal fade" id="import-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
               <div class="modal-dialog" role="document">
                
                      <div class="modal-content">
                          <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="exampleModalLabel1">
                               Import Pajak
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                        
                              <div class="row">
                                  
                                  <div class="col-md-6">
                                     <?php
                                    echo form_open_multipart(base_url() . 'admin/listing_tkd/import_pajak');
                                  
                                    echo '
                                      <label>Upload file (*.xls) : </label>
                                      <input name="file" type="file"><br>
                                      <br>
                                      <button type="submit" class="btn btn-info" id="clickme">
                                        <i class="fa fa-external-link-square"></i> &nbsp; Import
                                      </button>';
                                
                                    echo form_close();
                                     ?>
                            
                                  </div>
                              </div>
                           
                       
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn bg-danger-subtle text-danger font-medium"
                                  data-bs-dismiss="modal">
                                  Close
                              </button>
                             
                          </div>
                      </div>

                     
                  </div>
              </div>
  

      <script>
          function handleColorTheme(e) {
            $("html").attr("data-color-theme", e);
            $(e).prop("checked", !0);
          }
        </script>

        <?php $this->load->view('layout/section/theme-setting.php');?>

        <?php $this->load->view('master/request-cuti.php');?>

  </div>
  <div class="dark-transparent sidebartoggler"></div>
  <!-- Import Js Files -->

    <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>
    <script src="../assets/js/app.init.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.min.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>theme.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>init.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>jquery.blockUI.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>block-ui.js"></script>

    <script src="<?php echo NEW_JS_PATH;?>toastr-init.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>bootstrap-datepicker.js"></script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

</body>




<script>
 

 $(document).mouseup(function(e) 
        {
            var container = $(".form-periode2");

            // if the target of the click isn't the container nor a descendant of the container
            if (!container.is(e.target) && container.has(e.target).length === 0) 
            {
                container.hide();
            }
        });



        $(".btn-bulan").click(function(){
                var bulan = $(this).val();
                var tahun = $("#tahun").val();

                var bulan_tahun = bulan+'  '+tahun;
                $("#periode").val(bulan_tahun);
                
                $(".form-periode2").hide();

                $(".btn-bulan").removeClass("bln-active");
                $(this).addClass("bln-active");

                $.ajax({
                            
                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>admin/presensi/set_session_periode",
                            data:"bulan="+bulan+"&tahun="+tahun,
                            success:function(msg){
                             window.location.reload();
                              //$("#modal-form").html(msg);
                              //console.log(msg);
                            }
                        
                      });

              });


              $("#periode").click(function(){
                $(".form-periode2").show();
              });

              $(".btn-next").click(function(){
                  var tahun =  $("#tahun").val();
                  
                  var new_tahun = parseInt(tahun)+1;
                  $("#tahun").val(new_tahun);
              });


              $(".btn-prev").click(function(){
                  var tahun =  $("#tahun").val();
                  
                  var new_tahun = parseInt(tahun)-1;
                  $("#tahun").val(new_tahun);
              });



        $(".label-kegiatan").click(function(){
           
            $(".label-kegiatan").removeClass("kegiatan_active");
            $(this).addClass("kegiatan_active");

        });
        
 var pesan = '<?php echo $message;?>';
  if (pesan != '') {
    toastr.success(pesan, "Success!");
  }
   
  $(".btn-info").click(function(){
    $(".loading-update").removeClass('d-none');
  });

 $('#data-table').dataTable( {
                lengthMenu: [
                    [  20, -1 ],
                    ['20', '50', '100', 'Show all' ]
                ]
            } );
		

</script>
</html>