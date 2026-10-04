<!DOCTYPE html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical">

<head>
<?php  $this->load->view('master/meta');?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">

<style>
      tr td{
        font-size: 12px;
      }
      .btn{
        font-size: 12px Im !important;
      }
     #snackbar {
          visibility: hidden;
          min-width: 250px;
          margin-left: -125px;
          background-color: #54e196;
          color: #FFF;
          text-align: center;
          border-radius: 2px;
          padding: 16px;
          position: fixed;
          z-index: 1;
          left: 50%;
          bottom: 30px;
          font-size: 17px;
        }

        #snackbar.show {
          visibility: visible;
          -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
          animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
          from {bottom: 0; opacity: 0;} 
          to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
          from {bottom: 0; opacity: 0;}
          to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
          from {bottom: 30px; opacity: 1;} 
          to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
          from {bottom: 30px; opacity: 1;}
          to {bottom: 0; opacity: 0;}
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
                      <h4 class="fw-semibold mb-8">Pengaturan Aktifitas</h4>
                      <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                          <li class="breadcrumb-item">
                            <a class="text-muted text-decoration-none" href="<?php echo base_url();?>dashboard/index" >Dashboard</a>
                          </li>
                         
                           <li> &nbsp;  /   &nbsp;<a class="text-muted text-decoration-none" href="<?php echo base_url();?>kinerja/index" >Kinerja</a> </li>
                          
                          <li class="breadcrumb-acive">  &nbsp;/ &nbsp; Pengaturan Aktifitas</li>
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
                
          

               #print_array($this->session->userdata);
            ?>

                   
              <div class="row">

                    <div class="col-lg-5 d-flex align-items-stretch">
                         <div class="card w-100">
                            <div class="card-body p-4">
                               <h3>List  Aktifitas Utama Saya</h3>
                               <div class="clearfix"></div>
                               <Br><Br><Br>
                           
                                  <div class="table-responsive mt-4">
                                      <table class="table " id="table-aktifitas">
                                          <thead>
                                              <tr>
                                              
                                                <th class="w-1">No.</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Waktu</th>
                                                <th>Action</th>
                                              
                                              </tr>
                                          </thead>
                                          <tbody id="data_aktifitas_utama">
                                              <?php 

                                                    $no = 1;
                                                    foreach ($aktifitas_utama as $aktifitas){
                        
                                                        $id             = $aktifitas->id;
                                                        $nama_kegiatan  = $aktifitas->nama_kegiatan;
                                                        $satuan         = $aktifitas->satuan;
                                                        $waktu          = $aktifitas->waktu;
                                                    
                                                      
                            
                                                        echo' <tr>
                                                                    <td>'.$no.' </td>

                                                                    <td> '.$nama_kegiatan.'   <br> <span class="text-muted"> Satuan  </span>:  <strong>'.$satuan.'</strong></td>
                                                                   
                                                                    <td class="text-center">'.$waktu.' menit </td>
                                                                    <td>  <button type="button" value="'.$id.'" class="btn btn-sm btn-danger" title="Delete from list">
                                                                    <i class="ti ti-trash fs-3"></i>
                                                                     </button></td>
                                                                    
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
                
                  
         <div class="modal fade" id="add_aktifitasmodal" tabindex="-1" aria-labelledby="exampleModalLabel1">
             <div class="modal-dialog modal-lg" role="document">
                 <form method="post" action="<?php echo base_url();?>kinerja/insert_new_aktifitas" enctype="multipart/form-data">
                      <div class="modal-content">
                          <div class="modal-header d-flex align-items-center">
                              <h4 class="modal-title" id="exampleModalLabel1">
                                 Input Aktifitas Baru
                              </h4>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <div class="modal-body">
                        
                              <div class="row">
                                 <input type="hidden" name="id_kegiatan" id="id_kegiatan" value="0">
                                  <div class="col-md-12 mt-3">
                                      <label for="">Nama Kegiatan: </label>
                                      
                                      <input type="text" required name="nama" id="nama_kegiatan" value="" autocomplete="off" class="form-control" >
                                    </div>
                                   <div class="col-md-6 mt-3">
                                      <label for=""> Satuan : </label> 
                                      <input type="text" required  name="satuan" id="satuan" value=""  autocomplete="off" placeholder="dokumen"  class="form-control">
                                    </div>
                                    <div class="col-md-3 mt-3">
                                      <label for=""> Waktu : </label> 
                                      <input type="number" required  name="waktu" id="waktu" value="30"  autocomplete="off"   class="form-control"> menit
                                    </div>
                                
                                 
                              </div>
                           
                       
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn bg-danger-subtle text-danger font-medium"
                                  data-bs-dismiss="modal">
                                  Close
                              </button>
                              <button type="submit" class="btn btn-success">
                                Simpan
                              </button>
                          </div>
                      </div>

                      </form>
                  </div>
              </div>
  


                     <div class="col-lg-7 d-flex align-items-stretch">
                         <div class="card w-100">
                            <div class="card-body p-4">
                               <h3>List Master Aktifitas</h3>
                               <button type="button" class="btn btn-rounded me-2 bg-secondary-subtle rounded-pill float-end  text-info"  data-bs-toggle="modal" data-bs-target="#add_aktifitasmodal">
                                    <i class="ti ti-plus fs-4 me-2"></i>
                                    Tambah Aktifitas
                                </button>

                               <div class="clearfix"></div>
                               <Br><Br><Br>
                           
                                  <div class="table-responsive mt-4">
                                      <table class="table table-sm table-hover" id="data-table">
                                          <thead>
                                              <tr>
                                              
                                               <th class="w-1">No.</th>
                                                <th>Nama Kegiatan</th>
                                                <th>Satuan</th>
                                                <th>Waktu</th>
                                                <th width="200">Action</th>
                                              </tr>
                                          </thead>
                                          <tbody>
                                              <?php 

                                                   
                                                    $no = 1;
                                                    foreach ($kegiatan as $aktifitas){
                        
                                                        $id             = $aktifitas->id;
                                                        $nama_kegiatan  = $aktifitas->nama_kegiatan;
                                                        $satuan  = $aktifitas->satuan;
                                                        $waktu     = $aktifitas->waktu;
                                                    
                                                        $dataPost = $id.'-+-'.$nama_kegiatan.'-+-'.$satuan.'-+-'.$waktu;
                                                      
                            
                                                        echo' <tr>
                                                                    <td>'.$no.' </td>
                                                                    <td>'.$nama_kegiatan.' </td>
                                                                    <td>'.$satuan.'</td>
                                                                    <td class="text-center">'.$waktu.' </td>
                                                                    <td class="text-center">
                                                                       <button type="button" value="'.$dataPost.'" class="btn btn-sm border text-success edit_aktifitas" title="add to list" data-bs-toggle="modal" data-bs-target="#add_aktifitasmodal"><i class="ti ti-edit fs-3"></i> Ubah </button>
                                                                       <button type="button" value="'.$id.'" class="btn btn-sm btn-info add_aktifitas" title="add to list"><i class="ti ti-upload fs-3"></i>Tambahkan </button>
                                                                    </td>
                                                                    
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
           

            <div id="snackbar"><strong>Success!</strong> Data aktifitas berhasil ditambahkan.</div>

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
  

</body>




<script>
  
  $(".add_aktifitas").click(function(){
     var id = $(this).val();


        $.ajax({
            
            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>kinerja/add_aktifitas_utama",
            data:"id="+id,
            success:function(msg){
              $("#data_aktifitas_utama").html(msg);
              var x = document.getElementById("snackbar");
              x.className = "show";
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
            
          });
  });


  $(".edit_aktifitas").click(function(){
     var data_get = $(this).val();
     var pecah = data_get.split("-+-");
     var id = pecah[0];
     var nama_kegiatan = pecah[1];
     var satuan = pecah[2];
     var waktu = pecah[3];

    
     $("#id_kegiatan").val(id);
     $("#nama_kegiatan").val(nama_kegiatan);
     $("#satuan").val(satuan);
     $("#waktu").val(waktu);

   
  });
  
       
  $(".btn-danger").click(function(){
     var id = $(this).val();


        $.ajax({
            
            type:"POST",
            dataType:"html",
            url:"<?php echo base_url();?>kinerja/delete_aktifitas_utama",
            data:"id="+id,
            success:function(msg){
              $("#data_aktifitas_utama").html(msg);
              $("#snackbar").html('Kegiatan berhasil dihapus dari aktiftias utama');
              var x = document.getElementById("snackbar");
              x.className = "show";
              setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
            }
            
          });
  });

 $('#data-table').dataTable( {
              
            dom: 'lBfrtip',
            lengthMenu: [
                [  50, -1 ],
                ['50', 'Show all' ]
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
            } );

		

</script>
</html>