<!DOCTYPE html>
<html lang="en">
    <?php $this->load->view('layout/section/header');?>
                                                        <!-- Datatables css -->
<link href="<?php echo base_url();?>assets/new/css/vendor/dataTables.bootstrap5.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url();?>assets/new/css/vendor/responsive.bootstrap5.css" rel="stylesheet" type="text/css" />


    <body class="loading" data-layout-config='{"leftSideBarTheme":"light","layoutBoxed":false, "leftSidebarCondensed":true, "leftSidebarScrollable":false,"darkMode":false, "showRightSidebarOnStart": false}'>
        <!-- Begin page -->
        <div class="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
          
            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                  
                    <?php
                    //print_array($rekap_capaian_kinerja);

                       

                            $arrayJnsPegawai = array('non_pns', 'pns', 'pppk', 'pjlp');

                            $arrayUsergroup = arrayUsergroup();

                            $message = $this->session->flashdata('message');
                            $nama = $this->session->userdata('nama');
                            $email = $this->session->userdata('email');
                            


                            //print_array($this->session->userdata);
                            if($email==''){
                                redirect('register/index');
                            }

                           
                     ?>


                    <!-- Start Content-->
                    <div class="container">

                 

                        <div class="row">
                             <div class="col-sm-12">
                                 <!-- Profile -->
                                 <div class="card">
                                     <div class="card-body profile-user-box">
                                        <h3>Registrasi Pegawai Baru</h3>
                                        <br>

                                        <?php

                                                if ( $message != '') {
                                                    echo '<div class="alert alert-success">'.$message.'</div>';
                                                }
                                        ?>


                                                
                                        <form action="<?php echo base_url();?>register/save" method="post" id="update_myprofile">
                                          <div class="row">
                                            <div class="col-md-6">
                                                
                                                
                                                   <div class="row mb-2">
                                                        <div class="col-md-12">

                                                    
                                                            <label for="nama" class="inline-block">Nama Lengkap</label> <label class="text-danger">*</label>
                                                            <input type="text" id="nama" name="nama" value="<?php echo  $nama ;?>" required class=" form-control">
                                                        </div><!--end col-->
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="mb-2">
                                                                <label for="nip" class="inline-block">NIP</label> <label class="text-danger">*</label>
                                                                <input type="text" id="nip" name="nip" required class=" form-control">
                                                            </div><!--end col-->
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-2">
                                                                <label for="nrk" class="inline-block">NRK</label>
                                                                <input type="text" id="nrk" name="nrk" value="0" readonly class="form-control">
                                                            </div><!--end col-->
                                                        
                                                        </div>
                                                    </div>

                                                    <div class="row mb-2">
                                                        <div class="col-md-4">
                                                            <div>
                                                                <label for="nrk" class="inline-block">TMT (Tanggal Masuk)</label> <label class="text-danger">*</label>
                                                                <input type="date" id="tmt" name="tmt" placeholder="" required class=" form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div>
                                                                <label for="inputValue" class="inline-block">Jenis Pegawai</label>
                                                                <select class="form-select" id="jns_pegawai" readonly name="jns_pegawai">
                                                                        <option value="non_pns" selected> NON PNS</option>
                                                                        <?php
                                                                            for ($j=0; $j < 4; $j++){
                                                                                                        
                                                                                $jns_peg = $arrayJnsPegawai[$j];

                                                                                $namaJnsPegawai = strtoupper($jns_peg);
                                                                                $namaJnsPegawai = str_replace("_"," ", $namaJnsPegawai);
                                                                              
                                                                                 echo ' <option value="'. $jns_peg .'">'.$namaJnsPegawai .'</option>';
                                                                              
                                                                            
                                                                            }

                                                                        ?>
                                                                
                                                                </select>
                                                                
                                                                
                                                            </div><!--end col-->
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div>
                                                              <label for="inputValue" class="inline-block">Rumpun Kerja</label> <label class="text-danger">*</label>
                                                                 <input type="text" class="form-control" required id="rumpun_kerja" value="UKP" name="rumpun_kerja">
                                                            </div><!--end col-->
                                                        </div>
                                                    </div>
                                                  
                                                    
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                                <div class="mb-2">
                                                                <label for="id_jabatan" class="inline-block">Jabatan</label> <label class="text-danger">*</label>
                                                                <select class="form-select" id="id_jabatan" name="id_jabatan" >
                                                                    <?php
                                                                        foreach ($list_jabatan as $jbt){
                                                                                                    
                                                                            $id_jab = $jbt->id;
                                                                            $nama_jabatan = $jbt->nama;

                                                                            echo ' <option value="'. $id_jab .'">'.$nama_jabatan .'</option>';
                                                                        
                                                                        
                                                                            
                                                                        }

                                                                    ?>
                                                            
                                                                </select>
                                                                
                                                            
                                                            </div><!--end col-->
                                                        </div>
                                                        <div class="col-md-6">
                                                                
                                                                <div class="mb-2">
                                                                    <label for="inputValue" class="inline-block">Keterangan Jabatan</label>
                                                                    <input type="text" id="inputValue" name="ket_jab" placeholder="Dokter Umum, Perawat Gigi" class="form-control">
                                                                </div><!--end col-->
                                                                
                                                                
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                             <div class="mb-2">
                                                                <label for="inputValue" class="inline-block">Poli/Bagian</label> <label class="text-danger">*</label>
                                                                <select class="form-select" id="poliInput" name="id_poli">
                                                                        <?php
                                                                            foreach ($list_poli as $poli){
                                                                                                        
                                                                                $id_poli = $poli->id;
                                                                                $nama_poli = $poli->nama_poli;

                                                                                echo ' <option value="'. $id_poli .'">'.$nama_poli .'</option>';
                                                                                
                                                                            
                                                                            }

                                                                        ?>
                                                                
                                                                </select>
                                                            </div><!--end col-->
                                                            
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class=" mb-2 ">
                                                                    <label for="inputValue" class="inline-block">Puskesmas</label> <label class="text-danger">*</label>
                                                                    <select id="puskesmasInput" class="form-control " name="id_puskesmas" required aria-label="Default select example">
                                                                    
                                                                            <option value="0">--Pilih Puskesmas--</option>
                                                                            <?php
                                                                                foreach ($list_puskesmas as $puskesmas){
                                                                                                            
                                                                                        $id_puskesmas = $puskesmas->id_puskesmas;
                                                                                        $nama_puskesmas = $puskesmas->nama;
                                                                                        
                                                                                        echo ' <option value="'. $id_puskesmas .'">'.$nama_puskesmas .'</option>';
                                                                                                                                    
                                                                                

                                                                                    }


                                                                            ?>
                                                                        </select>
                                                            </div><!--end-->
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="mb-2">
                                                                <label for="id_pendidikan" class="inline-block">Pendidikan</label> <label class="text-danger">*</label>
                                                                <select class="form-select" id="id_pendidikan" name="id_pendidikan" required>
                                                                <option value="">Pilih Pendidikan</option>
                                                                    <?php
                                                                        foreach ($list_pendidikan as $pend){
                                                                                                    
                                                                            $id_pend = $pend->id;
                                                                            $pendidikan = $pend->pendidikan;

                                                                            echo ' <option value="'. $id_pend .'">'.$pendidikan .'</option>';
                                                                        
                                                                            
                                                                        }

                                                                    ?>
                                                            
                                                                </select>
                                                                
                                                            
                                                            </div><!--end col-->

                                                        </div>
                                                        <div class="col-md-6">
                                                                                
                                                                <div class="mb-4">
                                                                    <label for="inputValue" class="inline-block">Atasan Langsung</label> <label class="text-danger">*</label>
                                                                    <input type="text" id="id_validator" readonly value=""  name="validator"  class="form-control">
                                                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                          <div class="mb-2">
                                                                <label for="id_pendidikan" class="inline-block">Status Kawin</label> <label class="text-danger">*</label>
                                                                <select class="form-select" id="status_kawin" name="status_kawin" required >
                                                                         <option value="">Pilih Status Kawin</option>
                                                                        <option value="4">Belum Menikah</option>
                                                                        <option value="3">Menikah</option>
                                                                        <option value="2">Menikah 1 Anak</option>
                                                                        <option value="1">Menikah 2 Anak</option>
                                                            
                                                                </select>
                                                                
                                                            
                                                            </div><!--end col-->

                                                        </div>
                                                        <div class="col-md-6">
                                                                                
                                                                <div class="mb-4">
                                                                    <label for="inputValue" class="inline-block">Jenis Jam Kerja</label> <label class="text-danger">*</label>
                                                                    <br>
                                                                    <div class="form-check form-check-inline mt-2">
                                                                        <input type="radio" id="customRadio3"  name="jam_kerja"  value="non_shift" class="form-check-input">
                                                                        <label class="form-check-label" for="customRadio3">REGULER</label>
                                                                    </div>
                                                                    <div class="form-check form-check-inline">
                                                                        <input type="radio" id="customRadio4"  name="jam_kerja"  value="shift"  class="form-check-input">
                                                                        <label class="form-check-label" for="customRadio4">SHIFT</label>
                                                                    </div>
                                                                </div>
                                                            
                                                        </div>
                                                    </div>
                                                    

                                                      
                                                  
                                                
                                                  
                                               
                                            
                                            </div><!--col-md-4-->
                                            <div class="col-md-6">

                                                  <div class="row">
                                                        <div class="col-md-5">
                                                            <div class="mb-2 ">
                                                                <label for="inputValue" class="inline-block">No Telp/HP</label> <label class="text-danger">*</label>
                                                                <input type="text" id="inputValue" name="no_tlp" class="form-control" placeholder="081222...">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="mb-2">
                                                                <label for="inputValue" class="inline-block">Email Address</label> <label class="text-danger">*</label>
                                                                <input type="email" id="inputValue" name="email" value="<?php echo  $email ;?>" class=" form-control" placeholder="Enter your email address">
                                                            </div><!--end col-->
                                                         </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="mb-2">
                                                                <label for="tmptLahir" class="inline-block">Tempat Lahir</label> <label class="text-danger">*</label>
                                                                <input type="text" id="tmptLahir" name="tempat_lahir" class=" form-control" placeholder="cth: Jakarta, Semarang" >
                                                            </div><!--end col-->
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="mb-2">
                                                                <label for="joiningDateInput" class="inline-block">Tanggal Lahir</label> <label class="text-danger">*</label>
                                                                <input type="text" id="joiningDateInput"  name="tgl_lahir" autocomplete="off" required  class="form-control" placeholder="21-02-1999" data-provider="flatpickr" data-date-format="d M, Y" >
                                                            </div><!--end col-->
                                                        </div>
                                                    </div>
                                                  
                                              
                                                    <div class="row">
                                                        <div class="col-md-6">

                                                                <div class="mb-2">
                                                                    <label for="inputValue" class="inline-block">No KTP</label> <label class="text-danger">*</label>
                                                                    <input type="text" id="ktp"   name="no_ktp"  class="form-control" required placeholder="No KTP">
                                                                </div><!--end col-->
                                                        </div>
                                                        <div class="col-md-6">

                                                            <div class="mb-2">
                                                                <label for="inputValue" class="inline-block">No NPWP</label> <label class="text-danger">*</label>
                                                                <input type="text" id="npwp"   name="npwp"  class="form-control" required placeholder="isikan hanya angka, tanpa tanda baca">
                                                            </div><!--end col-->
                                                        </div>
                                                        <div class="col-md-6">

                                                                <div class="mb-2">
                                                                    <label for="inputValue" class="inline-block">No Rekening</label>
                                                                    <input type="text" id="no_rekening"  name="no_rekening"  class="form-control" placeholder="isikan hanya angka, tanpa tanda baca">
                                                                </div><!--end col-->
                                                        </div>
                                                        <div class="col-md-6">


                                                                <div class="mb-2">
                                                                    <label for="inputValue" class="inline-block">Usergroup</label>
                                                                    <select class="form-control" id="usergroup" name="usergroup"  data-choices=""  aria-label="Default select example">
                                                                        <option value="6">User</option>
                                                                
                                                                    </select>
                                                                    
                                                                </div><!--end col-->
                                                                
                                                        </div>
                                                    </div>

                                                    <div class="mb-2">
                                                        <label for="inputValue">Alamat KTP</label>
                                                        <textarea name="alamat_ktp" class="form-control" id="exampleFormControlTextarea2" placeholder="Alamat sesuai KTP" rows="3"></textarea>
                                                        
                                                    </div><!--end col-->
                                                    <div class="mb2">
                                                        <label for="inputValue" class="block mb-2">Alamat Domisili</label>
                                                        <textarea name="alamat_domisili" class="form-control" id="exampleFormControlTextarea1" placeholder="Alamat domisili" rows="3"></textarea>
                                                        
                                                    </div><!--end col-->

                                                    <div class="mt-4">
                                                        <a href="<?php echo base_url();?>register/index" class="btn btn-light">Kembali</a>
                                                        <button type="submit" class="btn btn-success float-end">Simpan</button>
                                                    </div>

                                             </div>
                                         </div>
                                         
                                            
                                        </form><!--end form-->

                                     </div> <!-- end card-body/ profile-user-box-->
                                 </div><!--end profile/ card -->
                             </div> <!-- end col-->
                         </div>
                         <!-- end row -->
                        

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
            
        $("#puskesmasInput").change(function(){
            var id_puskesmas = $(this).val();
            var rumpun = 'UKP';
    
                   $.ajax({
        
                            type:"POST",
                            dataType:"html",
                            url:"<?php echo base_url();?>register/getValidator",
                            data:"id_puskesmas="+id_puskesmas+"&rumpun_kerja="+rumpun,
                            success:function(msg){
                                //window.location.reload();
                                $("#id_validator").val(msg);
                                //console.log(msg);
                            }
    
                    });
    
            });
        
        
                 
        </script>



    </body>
</html>
