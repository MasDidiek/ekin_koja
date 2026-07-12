<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php $this->load->view('admin/master/meta');?>
</head>
<body>
    <div id="wrapper">
  

    
           <!-- /. NAV TOP  -->
           <?php $this->load->view('admin/master/menu');?>
        <!-- /. NAV SIDE  -->

        <div class="nav-top">
             <div class="account-info">
              <i class="fa fa-user"></i>&nbsp;  Login as : &nbsp; &nbsp;  PKM Kalibaru</div> 
           </div>


        

        <?php
       
            $nama_user = $this->session->userdata('nama_user');
        ?>
						<div id="page-wrapper" >
							<div id="page-inner">
								<div class="row">
									<div class="col-md-12">
									<h2>Data List Catin</h2>   
										
									</div>
								</div>              
								<!-- /. ROW  -->
								<hr />
								
								
                                <!-- id="dataTables-example" -->

                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                            <th style="text-align:center">No</th>
                                            <th style="text-align:center">Tgl Daftar</th>
                                            <th style="text-align:center">NIK</th>
                                            <th>Nama</th>
                                            <th style="text-align:center">L/P</th>
                                            <th style="text-align:center">Tgl Lahir</th>
                                            <th style="text-align:center">Status Kawin</th>
                                            <th style="text-align:center">No HP</th>
                                            <th style="text-align:center">Tgl Rencana </th>
                                            <th style="text-align:center">Status </th>
                                            <th style="text-align:center">Action</th>
                                            </tr>
                                        
                                        </thead>
                                        <tbody>
                            
                                            <?php
                            
                            
                                                    for ($i=0; $i < count($list_catin) ; $i++) { 
                                                        $nik = $list_catin[$i]->nik;
                                                        $nama = $list_catin[$i]->nama;
                                                        $tgl_lahir = $list_catin[$i]->tgl_lahir;
                                                        $gender = $list_catin[$i]->gender;
                                                        $no_hp = $list_catin[$i]->no_hp;
                                                        $status_kawin = $list_catin[$i]->status_kawin;
                                                        $id_provinsi = $list_catin[$i]->id_provinsi;
                                                        $id_kota = $list_catin[$i]->id_kota;
                                                        $id_kecamatan = $list_catin[$i]->id_kecamatan;
                                                        $id_kelurahan = $list_catin[$i]->id_kelurahan;
                                                        $tgl_rencana_menikah = $list_catin[$i]->tgl_rencana_menikah;
                                                        $date_create = $list_catin[$i]->date_create;
                                                        
                                                        $status = $list_catin[$i]->status;
                                                        if($status == 0)
                                                            {
                                                            $flag = '<span class="badge badge-warning">Pending</span>';
                                                            }else if($status == 1){
                                                                $flag =  '<span class="badge badge-success">Valid</span>';
                                                            }else{
                                                                $flag =  '<span class="badge badge-danger">Tidak Valid</span>';
            
                                    
                                                            }


                                                        if($status_kawin==0){
                                                            $kawin = 'Belum Menikah';
                                                        }else{
                                                            $kawin = 'Duda/Janda';
                                                        }
                                                        
                                                        
                                                        echo '<tr  class="view_detail" id="'.$list_catin[$i]->id.'">
                                                            
                                                                <td style="text-align:center">'.($i+1).'</td>
                                                                <td style="text-align:center">'.format_view($date_create).' &nbsp; '.date('H:i', strtotime($date_create)).'</td>
                                                                <td style="text-align:center">'.$nik.'</td>
                                                                <td><a href="'.base_url().'data_catin/detail_catin/'.$list_catin[$i]->id.'">'.$nama.'</a></td>
                                                                <td style="text-align:center">'. $gender.'</td>
                                                                <td style="text-align:center">'.format_view($tgl_lahir).'</td>
                                                                <td style="text-align:center">'.$kawin.'</td>
                                                                <td style="text-align:center">'.$no_hp.'</td>
                                                                <td  style="text-align:center">'.format_view($tgl_rencana_menikah).'</td>
                                                                <td style="text-align:center">'.$flag .'</td>
                                                                <td style="text-align:center">
                                                                    <a href="'.base_url().'admin/edit_catin/'.$list_catin[$i]->id.'" class="text-success" title="edit data catin">Ubah &nbsp;  &nbsp; 
                                                                    <a href="'.base_url().'admin/delete_catin/'.$list_catin[$i]->id.'" class="text-danger"  title="delete data catin" onClick="return confirm(\'Delete this user?\');">Hapus</a>
                                                                </td>
                                                                
                                                            </tr>';
                            
                            
                            
                            
                                                    }
                            
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>

						   	</div><!-- /. PAGE INNSER  -->
             </div> <!-- /. PAGE WRAPPER  -->
       </div> <!-- /. ID WRAPPER  -->
              
    
       
      </div>
    <!-- /. WRAPPER  -->
	 <script src="<?php echo JS_ADMIN;?>jquery-1.10.2.js"></script>
      <!-- BOOTSTRAP SCRIPTS -->
    <script src="<?php echo JS_ADMIN;?>bootstrap.min.js"></script>
    <!-- METISMENU SCRIPTS -->
    <script src="<?php echo JS_ADMIN;?>jquery.metisMenu.js"></script>
     <!-- DATA TABLE SCRIPTS -->
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

    
  
    

        <script>
            $(document).ready(function () {
                $('#dataTables-example').dataTable();
            });

    </script>
         <!-- CUSTOM SCRIPTS -->
    <script src="assets/js/custom.js"></script>
   
</body>
</html>
