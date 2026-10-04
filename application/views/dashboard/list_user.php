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
                
                $function = $this->uri->segment(3);
                $message = $this->session->flashdata('message'); 
                $serial_number = $this->uri->segment(4);


                
            ?>

                   
      <div class="body-wrapper">
        <div class="container-fluid">
          <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                <div class="card-body px-4 py-3">
                  <div class="row align-items-center">
                    <div class="col-9">
                      <h4 class="fw-semibold mb-8"> Tarik Data Absensi</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="../main/index.html" >Home / Setting</a>
                          </li>
                         
                           <li> &nbsp; / &nbsp; </li>
                          
                          <li class="breadcrumb-acive"> <?php echo $mesin_absensi[0]->nama_mesin;?> (<?php echo $serial_number;?>)</li>
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
                              
                    $id_pkm = $this->uri->segment(3);
                    $serial_number = $this->uri->segment(4);
                    $tgl_absen = $this->uri->segment(5);

                    if($tgl_absen==''){
                        $tanggal = date('Y-m-d');
                    }else{
                        $tanggal = $tgl_absen;
                    }
                    


                    $nextDate = datePlus($tanggal, 1);
                    $prevDate = dateMinus($tanggal, 1);

                ?>

                
            <div class="row">
              <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">

                

                  <div class="card-body p-4">
                    <a href="<?php echo base_url();?>dashboard/tarikDataAbsensiMesin"  class="btn btn-danger mb-4" >
                    Back
                    </a>

                    <button type="button"  value="<?php echo $serial_number;?>" id="tarik_data" class="btn btn-info mb-4 float-end">
                        <i class="fa-solid fa-download"></i> &nbsp;  Tarik Data
                    </button>

                    <div class="col-md-12   text-center" id="loading" style="display:none">
                            <img src="<?php echo base_url();?>assets/images/slack_animation.gif" width="200"> <br>
                            <h5> Updating data....</h5>

                        </div>
                    <p>
                    <label>Tanggal : </label>  
                    <br>

                            <a href="<?php echo base_url().'dashboard/list_user/'.$id_pkm.'/'.$serial_number.'/'.$prevDate;?>"  class="btn btn-sm btn-light" >
                            <i class="fa-solid fa-arrow-left"></i>
                            </a> 

                            <?php echo format_full($tanggal);?>

                            <a href="<?php echo base_url().'dashboard/list_user/'.$id_pkm.'/'.$serial_number.'/'.$nextDate;?>"  class="btn btn-sm btn-light" >
                            &nbsp;   <i class="fa-solid fa-arrow-right"></i>
                            </a>
                    </p>

                        <table class="table table-striped table-bordered"  id="data-table">                                           
                            <thead>
                                <tr>
                                    <th class="w-1">No.</th>
                                    <th>NIP</th>
                                    <th>Nama</th>
                                    <th>Jam Absen</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                     $no = 1;
                                     foreach ($pegawai as $peg){
         
                                         $id_pegawai = $peg->id_pegawai;
                                         $nip = $peg->nip;
                                         $id_jabatan = $peg->id_jabatan;
                                         $tmt = $peg->tgl_masuk;
                                         $id_puskesmas = $peg->id_puskesmas;
                                         $pin          = substr($nip, -4);

                                         $absensi = $this->Presensi_model->getAbsenHarian($pin, $tanggal);
                                         if(!empty($absensi)){
                                           //$DateTime = $absensi[]
                                               $absensi_pegawai = '';
                                               for ($i=0; $i < count($absensi) ; $i++) { 
                                                   $DateTime = $absensi[$i]->tanggal;
                                                   $jam_absensi = date('H:i:s', strtotime($DateTime));

                                                   $absensi_pegawai .= $jam_absensi.', ';

                                               }
                                         }else{
                                           $absensi_pegawai = '';
                                         }

                                         #print_array($absensi);
             
                                         echo' <tr>
                                                     <td>'.$no.' </td>

                                                     <td class="text-center"> '.$peg->nip.'</td>
                                                     <td class="text-start"><a href="'.base_url().'admin/pegawai/detail_pegawai/'.$id_pegawai.'">'.$peg->nama.'</a></td>
                                                     <td class="text-start">'. $absensi_pegawai .'</td>
                                              
                                                     
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
 
            $('#data-table').dataTable( {
                lengthMenu: [
                    [  20, -1 ],
                    ['20', '50', '100', 'Show all' ]
                ]
            } );

            $("#tarik_data").click(function(){
                $("#loading").show();
                var serial_number = $(this).val();
                $.ajax({
                      
                      type:"POST",
                      dataType:"html",
                      url:"<?php echo base_url();?>dashboard/ajaxTarikDataAbsensi",
                      data:"serial_number="+serial_number,
                      success:function(msg){
                        $("#loading").html(msg);
                      }
                  
                });
                //alert(serial_number);

            });


           
          
		

</script>
</html>