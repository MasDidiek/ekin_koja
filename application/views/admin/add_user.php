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
                <h1>Add New User</h1>
                <hr>
                 
                     <div style="width:450px">
                         
                         <form action="<?php echo base_url('user/insert_user');?>" method="post">
                        <table>
                            <tr  height="50">
                                <td width="100">Nama</td>
                                <td width="20">:</td>
                                <td>
                                    <input type="text" name="nama" class="form-control" required>
                                </td>
                            </tr>
                           
                            <tr>
                                <td>Puskesmas</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="puskesmas" class="form-control" placeholder="Puskesmas Kelurahan Kalibaru " required>
                                </td>
                            </tr>
                           <tr height="50">
                                <td>Userlevel</td>
                                <td>:</td>
                                <td>
                                    <select name="userlevel" class="form-control">
                                        <option value="1">Dokter</option>
                                        <option value="2">Bidan</option>
                                    </select>
                                </td>
                            </tr>
                            
                             <tr>
                                <td>Username</td>
                                <td>:</td>
                                <td>
                                    <input type="text" name="username" class="form-control" value="" autocomplete="off"  required>
                                </td>
                            </tr>
                             <tr height="50">
                                <td>Password</td>
                                <td>:</td>
                                <td>
                                    <input type="password" name="userpass" class="form-control" value="" autocomplete="off" required>
                                </td>
                            </tr>
                            
                             <tr height="80">
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>
                                    <button type="submit" class="btn btn-success">Simpan</button>
                                     <a href="<?php echo  base_url('user/index');?>" class="btn btn-danger">Kembali</a>
                                 </td>
                                
                          </tr>
                        </table>
                        
                        </form>
                    </div>

            </div>


      </div><!-- content-body -->
    </div><!-- content -->


  </body>
  <?php $this->load->view('admin/master/footer_js');?>
  
</html>
