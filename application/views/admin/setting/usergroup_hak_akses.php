
                            <?php
                                $userGroupID = $this->uri->segment(4);

                                $usergroupName = getugName($userGroupID);
                            ?>
                            
                               <form action="<?php echo base_url();?>admin/setting/update_hak_akses/<?php echo $userGroupID;?>" method="post">

                                <button type="submit" class="btn btn-primary float-end mb-4 me-2"> <i class="fa-solid fa-floppy-disk"></i> &nbsp; Update  </button>
                                <div class="clearfix"></div>

                                    <h4>Usergroup :  <?php echo '<span class="text-info">'.$usergroupName ;?></span></h4>
                                    <table class="table table-bordered">

                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Menu</th>
                                                <th>Akses</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                    
                                    <?php
                                                for ($i=0; $i < count($menu) ; $i++) { 
                                                    $id_menu = $menu[$i]->id_menu;
                                                    $menu_name = $menu[$i]->menu_name;
                                                    $cekHakAkses = $this->Master_model->cekHakAkses($userGroupID, $id_menu);

                                                   
                                                    if(empty($cekHakAkses)){
                                                        $check = '';
                                                    }else{
                                                        $check = 'checked';
                                                    }

                                                    echo ' <tr>
                                                              <td class="text-center">'.($i+1).'</td>
                                                              <td>'.$menu_name .'</td>
                                                              <td  class="text-center"> <input type="checkbox" '.$check.' value="'.$id_menu.'" name="id_menu[]"> </td>
                                                           
                                                
                                                            </tr> ';
                                                }
                                        ?>

                                    </tbody>

                              </table>
                       
                              </form>
