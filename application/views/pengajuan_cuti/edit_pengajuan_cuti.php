
<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical" data-boxed-layout="boxed" data-card="shadow">
  <head>
         <?php  $this->load->view('master/meta');?>

  </head>
  <body >
 <!--  Body Wrapper -->
 <script src="<?php echo base_url();?>assets/js/demo-theme.min.js?1685973381')}}"></script>
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
                <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h4 class="fw-semibold mb-8">Edit Pengajuan Cuti</h4>
                                 
                                </div>
                               
                            </div>
                     </div>
                </div>


            <?php
                $id_pegawai = $this->session->userdata('id_pegawai');
                $hakCutiThnLalu = $this->Cuti_model->getSisaCuti($id_pegawai, 1);
                $hakCutiThnIni  = $this->Cuti_model->getSisaCuti($id_pegawai, 2);
                $hakCutiBersama = $this->Cuti_model->getSisaCuti($id_pegawai, 3);
                $id_cuti   = $this->uri->segment(3);
            

                $date_from      =  $this->session->userdata('date_from');
                $date_to        =  $this->session->userdata('date_to');
                $jns_cuti       =  $this->session->userdata('jns_cuti');
                $jns_hak_cuti   =  $this->session->userdata('jns_hak_cuti');

                   
                $nama_pengganti     =  $this->session->userdata('nama_pengganti');
                $alasan_cuti    =  $this->session->userdata('alasan_cuti');
                $alamat   =  $this->session->userdata('alamat');
                $tlp   =  $this->session->userdata('tlp');
                $id_pegawai_pengganti   =  $this->session->userdata('id_pegawai_pengganti');

                

                if($date_from==''){
                    $date_from = format_view($detail_cuti[0]->tgl_dari);
                    $date_to = format_view($detail_cuti[0]->tgl_sampai);
                    $jns_cuti = $detail_cuti[0]->jns_cuti;
                    $jns_hak_cuti = $detail_cuti[0]->jns_hak_cuti;

                    $jns_hak_cuti = $detail_cuti[0]->jns_hak_cuti;
                    $alasan_cuti = $detail_cuti[0]->alasan_cuti;
                    $alamat = $detail_cuti[0]->alamat;
                    $tlp = $detail_cuti[0]->tlp;
                }

              
              

                
                $arrayHakCuti = array('Sisa Cuti tahun lalu', 'Hak Cuti tahun ini', 'Hak Cuti Bersama');
                $arraySisaCuti = array($hakCutiThnLalu, $hakCutiThnIni, $hakCutiBersama );

                $arrayJnsCuti = array('Tahunan', 'Bersalin', 'Alasan Penting', 'Sakit', 'Besar');

                $message = $this->session->flashdata('message'); 
                echo $message;
            ?>
            <div class="card">
             <div class="card-body">
              <h5> Edit Data Pengajuan Cuti</h5>
                <form method="post" action="<?php echo base_url();?>cuti/edit_tanggal_cuti/<?php echo  $id_cuti ;?>" enctype="multipart/form-data">
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
                            <?php
                                for ($i=0; $i < count($arrayJnsCuti) ; $i++) { 
                                    $idjns= $i+1;
                                    $jenis_cuti = $arrayJnsCuti[$i];

                                    if($jns_cuti==$idjns){
                                        echo '<option value="'.$idjns.'" selected>Cuti '.$jenis_cuti.'</option>';
                                    }else{
                                        echo '<option value="'.$idjns.'">Cuti '.$jenis_cuti.'</option>';
                                    }
                                    
                                }
                            ?>

                            

                            </select>

                        </div>
                        <div class="col-md-3 mt-3" id="jenis_hak_cuti">
                           Hak  Cuti yang digunakan: 
                            <select name="jns_hak_cuti"   class="form-control">
                                <option value="0">Pilih Hak Cuti</option>
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

                    <a href="<?php echo base_url();?>cuti/index" class="btn btn-danger float-start mt-4" > Kembali</a>
                    <button type="submit" class="btn btn-primary float-end mt-4">Simpan Perubahan</button>
                </form>

                
            </div>

            <label>Pilih Pengganti Selama Cuti  <span class="text-danger">*</span>:</label><br>
                                    <div class="form-input">
                                      <input type="text" id="search_pegawai" name="nama_pengganti" value="<?php echo  $nama_pengganti ;?>" placeholder="cari nama pegawai" class="form-control" required autocomplete="off">
                                      <div id="list_pegawai"></div>
                                    </div>
                                    <input type="hidden" name="id_pegawai_pengganti" id="id_pegawai_choose"   value="<?php echo  $id_pegawai_pengganti ;?>">
                                    <br>
                                    <div class="form-input">
                                        <label for="from"> Alasan Cuti  <span class="text-danger">*</span></label> : <br>
                                        <input type="text" id="alasan_cuti" name="alasan_cuti" class="form-control" value="<?php echo  $alasan_cuti ;?>" required autocomplete="off">
                                    </div>
                                    <br>
                                    <div class="form-input">
                                        <label for="from"> No Telepon  <span class="text-danger">*</span> </label> : <br>
                                        <input type="text" id="tlp" name="tlp" class="form-control" value="<?php echo  $tlp ;?>" required style="width: 250px;"  autocomplete="off">
                                    </div>
                                    <br>

                                    <div class="form-input">
                                        <label for="from"> Alamat Selama Cuti  <span class="text-danger">*</span></label> : <br>
                                        <textarea name="alamat" class="form-control"><?php echo  $alamat ;?></textarea>
                                    </div>
          </div>

     


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
        

        $("#jns_cuti").change(function(){

            var jns_cuti = $(this).val();
            if(jns_cuti==1){
                $("#jenis_hak_cuti").show();
            }else{
                $("#jenis_hak_cuti").hide();
            }


        });

  </script>
  
  </body>
</html>