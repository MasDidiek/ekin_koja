<!DOCTYPE html>
<html lang="en">
  <head>

  <?php $this->load->view('admin/master/meta');?>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/datepicker.css">
  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/main.css">

  </head>
  <body class="skin-base animate">
        <?php $this->load->view('admin/master/menu');?>

    <div class="content">
      <div class="content-header">
        
        <a id="contentMenu" href="#" class="content-menu d-none d-lg-flex"><i data-feather="menu"></i></a>
        <a id="mobileMenu" href="#" class="content-menu d-lg-none"><i data-feather="menu"></i></a>
        
      </div><!-- content-header -->
      <div class="content-body">
   
            <div class="main-content">
                <h1>Useradmin</h1>
                <hr>
                  
                    <?php  $message = $this->session->flashdata('message');
                    
                    
                    echo $message;
                    
                    ?>

                <a href="<?php echo  base_url('user/add_user');?>" class="btn btn-primary"><i data-feather="plus"></i> Add New</a>
                       
                  <table class="row-table">
                        <thead>
                          <tr>
                            <th style="text-align:center">No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Puskesmas</th>
                            <th style="text-align:center">Userlevel</th>
                            <th style="text-align:center">Action</th>
                          </tr>
                       
                       </thead>
                       <tbody>
            
                            <?php
            
            
                                  for ($i=0; $i < count($list_user) ; $i++) { 
                                      $username  = $list_user[$i]->username;
                                      $nama      = $list_user[$i]->name;
                                      $puskesmas = $list_user[$i]->puskesmas;
                                      $usertype  = $list_user[$i]->usertype;
                                      
                                      
                                      if($usertype==0){
                                          $userlevel = 'Admin';
                                      }else if($usertype==1){
                                          $userlevel = 'Dokter';
                                      }else{
                                           $userlevel = 'Bidan';
                                      }
                                      
                                      
                                      echo '<tr>
                                      
                                            <td style="text-align:center">'.($i+1).'</td>
                                            <td>'.$nama.'</td>
                                            <td>'.$username.'</td>
                                            <td>'. $puskesmas.'</td>
                                            <td style="text-align:center">'. $userlevel.'</td>
                                            <td style="text-align:center">
                                                <a href="'.base_url().'user/edit_user/'.$list_user[$i]->id.'" class="text-success" title="edit data user"><i data-feather="edit"></i></a> &nbsp;  &nbsp; 
                                                <a href="'.base_url().'user/delete_user/'.$list_user[$i]->id.'" class="text-danger"  title="delete data user" onClick="return confirm(\'Delete this user?\');"><i data-feather="trash"></i></a>
                                            </td>
                        
                                            
                                      </tr>';
            
            
            
            
                                  }
            
                            ?>
                            </tbody>
                         </table>
            </div>


      </div><!-- content-body -->
    </div><!-- content -->


  </body>
  <?php $this->load->view('admin/master/footer_js');?>
  
</html>
