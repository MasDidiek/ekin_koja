<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<style>
 tr td, th{
    border-right:1px solid #CCC;
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

         
     <div class="body-wrapper">
          <div class="container-fluid mw-100">
        <!--  Row 1 -->
                <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-12">
                                    <h4 class="fw-semibold mb-8">Pengajuan Cuti Pegawai</h4>
                                  
                                </div>
                               
                        </div>
                </div>
            </div>

     
            <?php
                #print_array($this->session->userdata);

                $usergroup = $this->session->userdata('usergroup');
                $arrayStatus = array('Semua', 'Pending', 'Approve','Tolak','Batal', 'Ditangguhkan');
                $statusNow = $this->uri->segment(4);

                $jns_cuti = $this->session->userdata('jns_cuti');

            ?>
              
            <div class="card">
                 <div class="card-body">
                    <div class="row">

                    <div class="col-md-12 mb-2">
                        <h6>Filter Data</h6>
                        <?php
                          for ($i=0; $i < count($arrayStatus) ; $i++) { 
                                if($statusNow==$arrayStatus[$i]){
                                    echo '<a href="'.base_url().'admin/pengajuan_cuti/index/'.$arrayStatus[$i].'" class="btn btn-light btn-outline-success btn-sm me-2">'.$arrayStatus[$i].'</a>';
                                }else{
                                    echo '<a href="'.base_url().'admin/pengajuan_cuti/index/'.$arrayStatus[$i].'" class="btn btn-light btn-sm  me-2">'.$arrayStatus[$i].'</a>';
                                }
                            
                          }
                        ?>
                    </div>
                    <?php
                        $arrayJnsCuti = array('Semua','Tahunan', 'Bersalin', 'Alasan Penting', 'Sakit', 'Besar');

                        $arrayBulan = array_bulan2();
                    ?>

                        
                <form action="<?php echo base_url();?>admin/pengajuan_cuti/filter_data" method="post" >

                     <div class="row">

                                <div class="col-md-3">
                                     <select name="bulan" class="form-control">
                                        <?php
                                         
                                            for ($g=0; $g < count($arrayBulan) ; $g++) { 
                                                echo '<option value="'.$g.'"> '.$arrayBulan[$g].'</option>';
                                              
                                            }
                                        ?>

                                        </select>
                                 </div>
                                <div class="col-md-3">
                                        
                                            <div class="d-block">
                                                <select name="jns_pegawai" class="form-control">
                                                    <option value="0">Semua</option>
                                                    <option value="pns">PNS</option>
                                                    <option value="non_pns">NON PNS</option>
                                                </select>
                                            </div>
                                        
                                            
                                    
                                </div>
                                <div class="col-md-3">
                                     <div class="form-group">
                                        <select name="jns_cuti" class="form-control">
                                        <?php
                                         $idjns  = 0;
                                            for ($i=0; $i < count($arrayJnsCuti) ; $i++) { 
                                              
                                                $jenis_cuti = $arrayJnsCuti[$i];

                                                if($jns_cuti==$idjns){
                                                    echo '<option value="'.$idjns.'" selected> '.$jenis_cuti.'</option>';
                                                }else{
                                                    echo '<option value="'.$idjns.'"> '.$jenis_cuti.'</option>';
                                                }
                                                

                                                $idjns  = $i+1;
                                            }
                                        ?>

                                        </select>
                                    </div>

                                  
                                </div>
                                <div class="col-md-3">

                                    <button type="submit" class="btn btn-info">Submit</button>
                                
                                </div>
                        
                    </div>   
                    </form>
                    <div class="table-responsive mt-4">
                            <table class="table align-middle  text-nowrap mb-0"   id="data-table">
                                <thead>
                                    <tr class="text-muted fw-semibold">
                                        <th scope="col" class="ps-0">Nama</th>
                                        <th scope="col">Tanggal Cuti</th>
                                        <th scope="col">Alasan</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <?php

                                        $id_pegawai_validator = $this->session->userdata('id_pegawai');  //id atasan yang sedang login

                                        #print_array($list_cuti );
                                            foreach ($list_cuti as $cuti) {
                                                
                                                $photo         = $cuti->photo;
                                                $tgl_dari      =  $cuti->tgl_dari;
                                                $tgl_sampai    =  $cuti->tgl_sampai;
                                                $hari_cuti     =  $cuti->hari_cuti;
                                                $status        =  $cuti->status;
                                                $id_validator  =  $cuti->id_validator;
                                                
                                                
                                                if($photo==''){
                                                    $photo = 'avatar.png';
                                                }
                                                
                                                if($hari_cuti==1){
                                                    $tgl_cuti = '<span class="text-dark">'.format_full($tgl_dari).'</span>';
                                                }else{
                                                    $tgl_cuti = '<span class="text-dark">'.format_full($tgl_dari).' </span> s/d <span class="text-dark">'.format_full($tgl_sampai).'</span>';
                                                }

                                                
                                                $flagStatus = getStatusCuti($status);

                                                
                                                if($usergroup < 3){
                                                    //bu muklah / kasubaag TU
                                                    echo ' <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-2 pe-1">
                                                                                <img src="'.base_url().'uploads/photo_profile/'. $photo.'" class="rounded-circle" width="40" height="40" alt="">
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="fw-semibold mb-1">'.$cuti->nama.'</h6>
                                                                            <p class="fs-2 mb-0 text-muted">
                                                                            '.$cuti->jabatan.'
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                
                                                                    <div>
                                                                            <h6 class="fw-semibold mb-1">'.$tgl_cuti.'</h6>
                                                                            <p class="fs-2 mb-0 text-muted">
                                                                            '.$cuti->hari_cuti.'&nbsp;  hari
                                                                            </p>
                                                                        </div>
                                                                </td>
                                                                <td>
                                                                <p class="mb-0 fs-3">'.$cuti->alasan_cuti.'</p>
                                                                </td>
                                                                <td> '. $flagStatus .' </td>
                                                                <td>
                                                                    <a href="'.base_url().'admin/pengajuan_cuti/detail/'.$cuti->id.'" class="btn btn-sm btn-info">Detail</a>
                                                                </td>
                                                            </tr> ';
                                                }else{

                                                    
                                                    if($id_pegawai_validator==$id_validator){
                                                        //Kapuskel, kasatpel


                                                        echo ' <tr>
                                                                <td>
                                                                    <div class="d-flex align-items-center">
                                                                        <div class="me-2 pe-1">
                                                                                <img src="'.base_url().'uploads/photo_profile/'. $photo.'" class="rounded-circle" width="40" height="40" alt="">
                                                                        </div>
                                                                        <div>
                                                                            <h6 class="fw-semibold mb-1">'.$cuti->nama.'</h6>
                                                                            <p class="fs-2 mb-0 text-muted">
                                                                            '.$cuti->jabatan.'
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                
                                                                        <div>
                                                                            <h6 class="fw-semibold mb-1">'.$tgl_cuti.'</h6>
                                                                            <p class="fs-2 mb-0 text-muted">
                                                                            '.$cuti->hari_cuti.'&nbsp;  hari
                                                                            </p>
                                                                        </div>
                                                                </td>
                                                                <td>
                                                                <p class="mb-0 fs-3">'.$cuti->alasan_cuti.'</p>
                                                                </td>
                                                                <td>
                                                                '. $flagStatus .'
                                                                </td>
                                                                <td>
                                                                    <a href="'.base_url().'admin/pengajuan_cuti/detail/'.$cuti->id.'" class="btn btn-sm btn-info">Detail</a>
                                                                </td>
                                                            </tr> ';
                                                            
                                                    }
                                                }


                                            

                                            }
                                        ?>
                                        

                                        </tbody>
                            </table>
                            </div>

                        


                        </div>
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


  </script>

</html>