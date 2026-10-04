<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
  .datepicker{
    z-index: 1999;
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
      <div class="body-wrapper">
      <div class="container-fluid">
            <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8">Pengajuan Cuti</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="<?php echo base_url();?>dashboard/index" >Home</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive">Pengajuan Cuti</li>
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
                $id_pegawai = $this->session->userdata('id_pegawai');
                $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 1);
                $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
                $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);

                $date_from      =  $this->session->userdata('date_from');
                $date_to        =  $this->session->userdata('date_to');
                $jns_cuti       =  $this->session->userdata('jns_cuti');

                $jns_hak_cuti   = $this->uri->segment(3);

                if($jns_hak_cuti==''){
                    $jns_hak_cuti   =  $this->session->userdata('jns_hak_cuti');
                }
              

                
                $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');
                $arraySisaCuti = array($hakCutiThnLalu, $hakCutiThnIni, $hakCutiBersama );

                $message = $this->session->flashdata('message'); 
                echo $message;
            ?>
         <div class="card">
            <div class="card-body">
            <h5>Form Pengajuan Cuti</h5>
                <form method="post" action="<?php echo base_url();?>cuti/check_date" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-6 mt-3">
                            <label for="">Tanggal Mulai: </label>
                            <input type="text" required name="date_from" autocomplete="off" class="form-control" value="<?php echo $date_from  ;?>" id="dpd1" ></div>
                        <div class="col-md-3 col-sm-6 col-6 mt-3">
                             <label for=""> Tanggal Akhir: </label> 
                            <input type="text" required  name="date_to"  autocomplete="off"   class="form-control" value="<?php echo $date_to  ;?>" id="dpd2" ></div>
                        <div class="col-md-3 mt-3">
                          Jenis Cuti: 
                            <select name="jns_cuti" id="jns_cuti"  class="form-control">
                                <option value="1">Cuti Tahunan</option>
                                <option value="2">Cuti Bersalin</option>
                                <option value="3">Cuti Alasan Penting</option>
                                <option value="4">Cuti Sakit</option>
                                <option value="5">Cuti Besar</option>

                            </select>

                        </div>
                        <div class="col-md-3 mt-3">
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
                    <button type="submit" class="btn btn-primary float-end mt-4">Buat Pengajuan</button>
                </form>
               
            </div>


          </div>
        </div>
    


            <div class="py-6 px-6 text-center">
              <p class="mb-0 fs-4">Design and Developed by
                <a href="#" target="_blank" class="pe-1 text-primary text-decoration-underline">DhifaWebStudio</a> </p>
            </div>

  <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>dashboard.js"></script>


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