<!doctype html>
<html lang="en">
  <head>
         <?php  $this->load->view('master/meta');?>
         <style>
             .datepicker{
                z-index: 1999;
            }
         </style>
        
  </head>
  <body >
 <!--  Body Wrapper -->
 <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
      <?php $this->load->view('layout/section/sidebar');?>

    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
    
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->
      <div class="container-fluid mw-100">
        <!--  Row 1 -->
                    
        <?php
          $nama_user =  $this->session->userdata('nama');
          $nip_user =  $this->session->userdata('nip');
          $id_pegawai =  $this->session->userdata('id_pegawai');
          $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);
          if($photo==''){
            $photo = 'avatar.png';
          }
         # print_array($this->session->userdata);
         # 197003071990022001
        ?>

             <div class="row">

                <div class="col-lg-8 d-flex align-items-stretch">
                  <div class="card w-100   overflow-hidden">
                    <div class="card-body position-relative">
                      <div class="row">
                        <div class="col-sm-7">
                          <div class="d-flex align-items-center mb-7">
                            <div class="rounded-circle overflow-hidden me-6">
                              <img src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photo ;?>" alt="" width="40" height="40">
                            </div>
                            <h5 class="fw-semibold mb-0 fs-5"> <span class="text-muted">Welcome back</span>  <?php echo $nama_user;?>!</h5>
                          </div>
                          <div class="d-flex align-items-center">
                            <div class="border-end pe-4 border-muted border-opacity-10">
                              <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">$2,340<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                              <p class="mb-0 text-dark">Inputan Kinerja</p>
                            </div>
                            <div class="ps-4">
                              <h3 class="mb-1 fw-semibold fs-8 d-flex align-content-center">35%<i class="ti ti-arrow-up-right fs-5 lh-base text-success"></i></h3>
                              <p class="mb-0 text-dark">Capaian Kinerja</p>
                            </div>
                          </div>
                        </div>
                        <div class="col-sm-5">
                          <div class="welcome-bg-img mb-n7 text-end">
                            <img src="<?php echo base_url();?>assets/images/freelance-illustrator2.png" alt="" class="img-fluid" width="200">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                

              <div class="col-md-6 col-lg-4 d-flex align-items-stretch">
              <div class="card w-100">
                <div class="card-body">
                  <h5 class="card-title fw-semibold">Weekly Stats</h5>
                  <p class="card-subtitle mb-0">Average sales</p>
                 
                 
                  <div class="position-relative">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex">
                        <div class="p-6 bg-primary-subtle text-primary rounded-2 me-6 d-flex align-items-center justify-content-center">
                          <i class="ti ti-grid-dots fs-6"></i>
                        </div>
                        <div>
                          <h6 class="mb-1 fs-4 fw-semibold">Top Sales</h6>
                          <p class="fs-3 mb-0">Johnathan Doe</p>
                        </div>
                      </div>
                      <div class="bg-primary-subtle text-primary badge">
                        <p class="fs-3 fw-semibold mb-0">+68</p>
                      </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-4">
                      <div class="d-flex">
                        <div class="p-6 bg-success-subtle text-success rounded-2 me-6 d-flex align-items-center justify-content-center">
                          <i class="ti ti-grid-dots fs-6"></i>
                        </div>
                        <div>
                          <h6 class="mb-1 fs-4 fw-semibold">Best Seller</h6>
                          <p class="fs-3 mb-0">Footware</p>
                        </div>
                      </div>
                      <div class="bg-success-subtle text-success badge">
                        <p class="fs-3 fw-semibold mb-0">+68</p>
                      </div>
                    </div>
          
                  </div>
                </div>
              </div>
            </div>
                
                      <div class="col-lg-12 d-flex align-items-stretch">
                          <div class="card w-100">
                            <div class="card-body p-4">
                              <h5 class="card-title fw-semibold mb-4">Shortcut</h5>
                              
                                
                                <div class="row">
                                    <div class="col-3 text-center"> 
                                      <button type="button" class="btn btn-primary btn-circle btn-xl"><i class="fa-solid fa-book"></i> </button>
                                      <Br>  Input Kinerja
                                    </div>
                                    <div class="col-3 text-center">  
                                      <a href="<?php echo base_url();?>absensi/dinas_luar" class="btn btn-danger btn-circle btn-xl"><i class="fa-solid fa-building-circle-exclamation"></i></a>
                                      <br> Dinas Luar
                                    </div>
                                    <div class="col-3 text-center"> 
                                      <a href="<?php echo base_url();?>absensi/izin_sakit" class="btn btn-warning btn-circle btn-xl"><i class="fa-solid fa-file-medical"></i></a>
                                      <br>Sakit/Izin
                                      </div>
                                    <div class="col-3 text-center">
                                      <button type="button" class="btn btn-success btn-circle btn-xl"   data-bs-toggle="modal" data-bs-target="#samedata-modal" data-bs-whatever="@mdo"><i class="fa-solid fa-calendar"></i></button>
                                      <br>Pengajuan Cuti
                                      </div>
                                </div>

                            </div> 
                          <div>

                       </div>
                 </div>


             </div>
         </div>

<?php
    $id_pegawai = $this->session->userdata('id_pegawai');
    $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 1);
    $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
    $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);
     $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');
     $arraySisaCuti = array($hakCutiThnLalu, $hakCutiThnIni, $hakCutiBersama );
?>
         <div class="modal fade" id="samedata-modal" tabindex="-1" aria-labelledby="exampleModalLabel1">
             <div class="modal-dialog" role="document">
                 <form method="post" action="<?php echo base_url();?>cuti/check_date" enctype="multipart/form-data">
                      <div class="modal-content">
                          <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="exampleModalLabel1">
                                  Pengajuan Cuti
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                        
                              <div class="row">
                                  <div class="col-md-6 col-sm-6 col-6 mt-3">
                                      <label for="">Tanggal Mulai: </label>
                                      <input type="text" required name="date_from" autocomplete="off" class="form-control" value="<?php echo date('d-m-Y');?>" id="dpd1" ></div>
                                  <div class="col-md-6 col-sm-6 col-6 mt-3">
                                      <label for=""> Tanggal Akhir: </label> 
                                      <input type="text" required  name="date_to"  autocomplete="off"   class="form-control"value="<?php echo date('d-m-Y');?>" id="dpd2" ></div>
                                  <div class="col-md-6 mt-3">
                                    Jenis Cuti: 
                                      <select name="jns_cuti" id="jns_cuti"  class="form-control">
                                          <option value="1">Cuti Tahunan</option>
                                          <option value="2">Cuti Bersalin</option>
                                          <option value="3">Cuti Alasan Penting</option>
                                          <option value="4">Cuti Sakit</option>
                                          <option value="5">Cuti Besar</option>

                                      </select>

                                  </div>
                                  <div class="col-md-6 mt-3">
                                  Hak  Cuti yang digunakan: 
                                      <select name="jns_hak_cuti" id="jns_cuti"  class="form-control">
                                      <?php
                                          for ($i=0; $i < count($arrayHakCuti) ; $i++) { 
                                              $idjnsHak = $i+1;
                                              $nama_hak_cuti = $arrayHakCuti[$i];

                                              if($jns_hak_cuti==$idjnsHak){
                                                  echo '<option value="'.$idjnsHak.'" selected>'.$nama_hak_cuti.' ('.$arraySisaCuti[$i].')</option>';
                                              }else{
                                                  echo '<option value="'.$idjnsHak.'">'.$nama_hak_cuti.' ('.$arraySisaCuti[$i].')</option>';
                                              }
                                              
                                          }
                                      ?>

                                        
                                      </select>
                                  </div>
                              </div>
                           
                       
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn bg-danger-subtle text-danger font-medium"
                                  data-bs-dismiss="modal">
                                  Close
                              </button>
                              <button type="submit" class="btn btn-primary">
                                Selanjutnya
                              </button>
                          </div>
                      </div>

                      </form>
                  </div>
              </div>
  
   

            <div class="py-6 px-6 text-center">
              <p class="mb-0 fs-4">Design and Developed by
                <a href="#" target="_blank" class="pe-1 text-primary text-decoration-underline">DhifaWebStudio</a> </p>
            </div>
      </div>
    </div>
  </div>
  <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>dashboard.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap4.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>


  <script src="<?php echo NEW_JS_PATH;?>prettify.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>jquery.js"></script>
    <script src="<?php echo NEW_JS_PATH;?>bootstrap-datepicker.js"></script>

  <script>
        $("#button_upload").click(function(){
            $(".form-upload").removeClass('d-none');


        });


        var nowTemp = new Date();
        var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
        //1700931600000
        //1703264400000

        var checkin = $('#dpd1').datepicker({
            
            onRender: function(date) {

                //alert(date.valueOf());
                //return date.valueOf() < now.valueOf() ? 'disabled' : '';
                return '';
            }
        }).on('changeDate', function(ev) {
        if (ev.date.valueOf() > checkout.date.valueOf()) {
            var newDate = new Date(ev.date)
                newDate.setDate(newDate.getDate() + 1);
                checkout.setValue(newDate);
            }

       
        checkin.hide();
        $('#dpd2')[0].focus();

        }).data('datepicker');
            var checkout = $('#dpd2').datepicker({
            onRender: function(date) {
           // return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
           return '';
        }
        }).on('changeDate', function(ev) {
          checkout.hide();
        }).data('datepicker');

  </script>
  

  </body>
</html>