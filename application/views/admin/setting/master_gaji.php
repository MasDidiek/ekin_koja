
                
                 
            <?php

                        
           # print_array( $masa_kerja);
                $id_masa_kerja = $masa_kerja[0]->id;
                $masakerja = $masa_kerja[0]->masa_kerja;


                $id_validator_session = $this->session->userdata('id_validator_session');
                $id_validator = $this->session->userdata('id_user');
                $usergroup = $this->session->userdata('usergroup');
                $tahun     = $this->session->userdata('periode_tahun');
                $bulan     = $this->session->userdata('periode_bulan');
                $day = date('d');
                $month = $bulan;
                $year = $tahun;

                $bulanNow = date('m');
                $now = date('Y-m-d');


                $tgl_dari = $year . '-' . $month . '-01';

                if ($usergroup == 4) {
                $id_validator_session = $id_validator;
                }


                if ($month < $bulanNow) {
                $day = date('t', strtotime($tgl_dari));
                // $tgl_sampai = $year.'-'.$month.'-'.$day;
                }



                $tgl_sampai = $year . '-' . $month . '-' . $day;
                $arrayBulan = array_bulan();
                $msg_update = $this->session->flashdata('success');


                if ($msg_update <> '') {
                echo '
                <div class="alert alert-success">
                <strong>Berhasil!!! </strong> ' . $msg_update . '
                </div>';
                }
                ?>

                
                
           <div class="col-md-12">    
                
                <div class="table-responsive p-4">

                            
                         <table class="table table-center text-nowrap">

                         <?php

                            for ($a=0; $a < count($datalist_masa_kerja) ; $a++) { 
                              # code...
                              $id_ms_kerja      = $datalist_masa_kerja[$a]->id;
                              $masa_kerja    = $datalist_masa_kerja[$a]->masa_kerja;
                          
                              if($id_masa_kerja==$id_ms_kerja)
                              {
                                $class = 'btn-primary';
                              }else{
                                $class = 'btn-light';
                              }
                            echo '<a href="'.base_url().'admin/setting/master_gaji/'.$id_ms_kerja.'" class="btn '.$class.' btn-flat" style="margin:3px;">
                                '.$masa_kerja.' &nbsp; tahun
                            </a>';
                                          
                            } 
                            ?> 


                            <br>  <br>

                      
                            
                            <button type="submit" class="btn btn-success pull-right">Update</button>
                            <br><br>
                            <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                          
                                            <th>STATUS</th>
                                            <?php
                                for($p=0; $p < count($mst_pendidikan); $p++)
                                {
                                echo ' <th>'.strtoupper($mst_pendidikan[$p]->pendidikan).'</th> ';
                                }
                              ?>
                           <th>Ket</th>  	
                        </tr>
                       
                    </thead>
                     <tbody>
                     
                     
					               <?php
                          for($s=0; $s < count($mst_status); $s++)
                          {
                            $id_status = $mst_status[$s]->id;
                          ?>
                     
                            <tr>
                            
                              <td><?php echo $mst_status[$s]->status;?></td>
                               <?php
                                  for($p=0; $p < count($mst_pendidikan); $p++)
                                  {
                                        $id_pend = $mst_pendidikan[$p]->id;
                                        
                                        $Gaji = $this->Master_model->getMstGaji($id_masa_kerja, $id_status, $id_pend);
									  
                                     echo ' 
									 <td style="text-align:center"> '.number_format($Gaji).'  </td> ';
                                  }
                                ?>
                              <td><?php echo $mst_status[$s]->ket;?></td>
                         
                            </tr>
                        
                      <?php  }  ?>
                        
                    </tbody>
                 </table>
                       
                    
              </div>
        </div>