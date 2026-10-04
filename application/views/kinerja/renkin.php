<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
    .table th,  td{
      border-right:1px solid #EEE;
    }
    .form-table{
      border:1px solid #DDD;
      padding:5px;
      text-align:center
    }

    .table-shift th, td{
      border:1px solid #DDD;
      padding:5px;
      text-align:center
    }
</style>
</head>

<body>
 

  <div id="main-wrapper">
    <!-- Sidebar Start -->
    <aside class="left-sidebar with-vertical">
      <div><!-- ---------------------------------- -->
      <!-- Start Vertical Layout Sidebar -->
      <!-- ---------------------------------- -->


      <?php $this->load->view('layout/section/sidebar');?>

    </aside>

    <!--  Sidebar End -->
    <div class="page-wrapper">
      <!--  Header Start -->
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->

         <?php 
                
                $tw = $this->uri->segment(3);
                $message = $this->session->flashdata('message'); 
             
                $title = 'Renkin';

                if($tw==''){
                  $tw = 1;
                }

                
            ?>

                   
      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8"> <?php echo $title;?> </h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="<?php echo base_url();?>dashboard" >Home / Kinerja</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive"> <?php echo $title;?> </li>
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
            
            <div class="row">
              <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                  <div class="card-body p-4">


                  <?php

                      $trw = 0;
                      for ($i=0; $i < 4; $i++) { 

                        $trw = $i+1;
                      
                        if($trw == $tw)
                        {
                          echo '<a href="'.base_url().'kinerja/renkin/'.$trw .'" class="btn btn-info me-2">TW'.$trw.'</a>';
                        }else{
                          echo '<a href="'.base_url().'kinerja/renkin/'.$trw .'" class="btn btn-outline-info me-2">TW'.$trw.'</a>';
                        }
                       


                      }
                  ?>

                    <a href="<?php echo base_url();?>admin/listing_tkd/update_rekap_tkd" class="btn  float-end btn-info  ms-2"> 
                    <i class="fas fa-pencil"></i> Edit Target</a>


                    <button type="button" class="btn btn-warning  btn-circle float-end btn-xl"   data-bs-toggle="modal" data-bs-target="#import-modal" data-bs-whatever="@mdo">
                    <i class="fa fa-plus"></i>&nbsp; Tambah Indikator Kegiatan
                    </button>



                      <div class="table-responsive mt-4">
                               <table class="table  table-bordered"  id="data-table">

                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Indikator</th>
                                            <th>Satuan</th>
                                            <th>Target</th>
                                            <th>Realisasi</th>
                                            <th>validasi</th>
                                            <th>Capaian</th>
                                            <th>Keterangan</th>
                                            <th width="100">Action</th>
                                        </tr>
                                    </thead>
                                                                                      

                                    <tbody>

                                    <?php

                                    #print_array($renkin);
                                    $no = 1;
                                            foreach ($renkin as $key => $value) {
                                                

                                              $id_indikator = $value->id_indikator;
                                              $tgl = $value->tgl;
                                              $triwulan = $value->triwulan;
                                              $target = $value->target;
                                              $realisasi = $value->realisasi;
                                              $validasi = $value->validasi;
                                              $capaian = $value->capaian;
                                              $keterangan = $value->keterangan;
                                              $tgl_validasi = $value->tgl_validasi;
                                              $kode_program = $value->kode_program;
                                              $kode_kegiatan = $value->kode_kegiatan;
                                              $nama_kegiatan = $value->nama_kegiatan;
                                              $indikator_kegiatan = $value->indikator_kegiatan;
                                              $satuan = $value->satuan;


                                              if($triwulan==$tw){
                                                    echo '<tr>
                                                              <td>'.$no.'</td>
                                                              <td class="text-start">'.$indikator_kegiatan.'</td>
                                                              <td>'.$satuan.'</td>
                                                              <td>'.$target.'</td>
                                                              <td>'.$realisasi.'</td>
                                                              <td>'.$validasi.'</td>
                                                              <td>'.$capaian.'</td>
                                                              <td>'.$keterangan.'</td>
                                                              <td>
                                                                  <button type="button" class="btn btn-success btn-sm"  data-bs-toggle="modal" data-bs-target="#edit-modal" data-bs-whatever="@mdo">
                                                                     <i class="fa fa-pencil"></i>
                                                                  </button>

                                                                  <button type="button" class="btn btn-danger btn-sm"  data-bs-toggle="modal" data-bs-target="#delete-modal">
                                                                  <i class="ti ti-trash"></i>
                                                               </button>
                                                              
                                                              </td>
                                                        </tr>';

                                                  $no +=1;
                                              }
                                             

                                                  
                                            }

                                     ?>

                                    </tbody>

                              </table>
                          </div><!--table-responsive-->

                  </div>
                </div>
              </div>
            </div>

            <div class="modal fade" id="import-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
               <div class="modal-dialog modal-md" role="document">
                <?php   echo form_open_multipart(base_url() . 'kinerja/add_indikator_renkin');?>
                      <div class="modal-content">
                          <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="exampleModalLabel1">
                                Tambah Indikator Renkin
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                        
                              <div class="row">
                                  
                                  <div class="col-md-12">
                                     <?php
                                  
                                  
                                    echo '
                                      <label>Indikator kegiatan : </label>
                                      <textarea id="indikator" name="indikator" class="form-input-kinerja"  required autocomplete="off"  rows="2" cols="10" wrap="soft"></textarea>
                                      <div id="ajaxlist_indikator"></div>
                                      <br>

                                      <input type="hidden" id="id_indikator_post" name="id_indikator">
                                      <div class="row">
                                           <div class="col-md-6">
                                            <label>Sumber Data</label>
                                            <input type="text" name="sumber_data" id="sumber_data" class="form-control">
                                            <br>
                                           
                                            
                                           </div>


                                           <div class="col-md-6">
                                            <label>Satuan</label>
                                            <input type="text" name="satuan" id="satuan" class="form-control">
                                           </div>

                                           <div class="col-sm-12">
                                              <label>Triwulan</label> <br>';

                                              for ($i=1; $i < 5 ; $i++) { 
                                                  echo '  <div class="form-check py-2 col-md-3 float-start">
                                                  <input type="checkbox" name="tw[]" value="'.$i.'" class="form-check-input" id="customCheck'.$i.'">
                                                  <label class="form-check-label" for="customCheck'.$i.'">Triwulan '.$i.'</label>
                                                </div>';
                                              }        
                                            
                                            echo ' 
                                            </div>
                                      </div>
                                          
                                    <br> ';
                                
                                  
                                     ?>
                            
                                  </div>
                              </div>
                           
                       
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn bg-danger-subtle text-danger font-medium"
                                  data-bs-dismiss="modal">
                                  Close
                              </button>

                              <button type="submit" class="btn btn-success float-end" >
                                        <i class="fa fa-check"></i> &nbsp; Simpan
                                      </button>
                             
                          </div>
                      </div>

                      <?php   echo form_close();?>
                     
                  </div>
              </div>

              <div class="modal fade" id="delete-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
               <div class="modal-dialog modal-sm" role="document">
                <?php   echo form_open_multipart(base_url() . 'kinerja/add_indikator_renkin');?>
                      <div class="modal-content">
                          <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="exampleModalLabel1">
                                Hapus Renkin
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                        
                              <div class="row">     
                                  <div class="col-md-12">

                                      <div class="alert alert-danger text-danger">
                                        Apakah anda yakin ingin menghapus indikator renkin ini?
                                      </div>
                                      <input type="hidden" id="id_indikator_post" name="id_indikator">
                                  </div>
                              </div>
                           
                       
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn bg-light font-medium"
                                  data-bs-dismiss="modal">
                                  Close
                              </button>

                              <button type="submit" class="btn btn-danger float-end" >
                                        <i class="fa fa-check"></i> &nbsp; Iya, Hapus
                                      </button>
                             
                          </div>
                      </div>

                      <?php   echo form_close();?>
                     
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


    <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>bootstrap-datepicker.js"></script>

    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>

</body>


<script>

      $("#indikator").keyup(function(){
          var keyword = $(this).val();
          $("#ajaxlist_indikator").show();
                  $.ajax({
                      
                      type:"POST",
                      dataType:"html",
                      url:"<?php echo base_url();?>kinerja/ajaxSearchIndikator",
                      data:"keyword="+keyword,
                      success:function(msg){
                          $("#ajaxlist_indikator").html(msg);
                      }
                      
                  });


      });

  </script>

</html>