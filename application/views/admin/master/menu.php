<!-- <ul>
                <li>
                    <a href="<?php echo base_url();?>admin/home/index"   class="active">
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">Home</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>admin/admin_driver/index">
                        <span class="icon"><i class="fas fa-desktop"></i></span>
                        <span class="item">Pengemudi</span>
                    </a>
                </li>
               
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-chart-line"></i></span>
                        <span class="item">Laporan</span>
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url();?>admin/admin_user/index">
                        <span class="icon"><i class="fas fa-user-shield"></i></span>
                        <span class="item">User Admin</span>
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon"><i class="fas fa-cog"></i></span>
                        <span class="item">Settings</span>
                    </a>
                </li>

                
            </ul>

       
            <div class="user_login">
                <a href="<?php echo base_url();?>admin/login/logout"><i class="fas fa-power-off"></i> &nbsp;&nbsp; Logout</a>
            </div> -->


                 <?php

                        $menu = $this->uri->segment(2);
                        

                        $menu_home  = '';
                        $menu_driver  = '';
                        $menu_pemeriksaan  = '';
                        $menu_laporan  = '';
                        $menu_user  = '';
                        $menu_petugas  = '';

                        if($menu=='admin_driver'){
                            $menu_driver  = 'active';
                        }else if($menu=='admin_pemeriksaan'){
                            $menu_pemeriksaan  = 'active';
                        }else if($menu=='admin_laporan'){
                            $menu_laporan  = 'active';
                        }else if($menu=='admin_user'){
                            $menu_user  = 'active';
                        }else if($menu=='admin_petugas'){
                            $menu_petugas  = 'active';
                        }else{
                            $menu_home  = 'active';
                        }

                ?>

            <div class="menu">
                    <a href="<?php echo base_url();?>admin/home/index" <?php echo 'class="'.$menu_home.'"';?> >
                        <span class="icon"><i class="fas fa-home"></i></span>
                        <span class="item">Home</span>
                    </a>

                    <a href="<?php echo base_url();?>admin/admin_driver/index"  <?php echo 'class="'.$menu_driver.'"';?>>
                        <span class="icon"><i class="fas fa-desktop"></i></span>
                        <span class="item">Pengemudi</span>
                    </a>

                    <a href="<?php echo base_url();?>admin/admin_pemeriksaan/index" <?php echo 'class="'.$menu_pemeriksaan.'"';?>>
                        <span class="icon"><i class="fas fa-stethoscope"></i></span>
                        <span class="item">Data Pemeriksaan</span>
                    </a>

                    <a href="<?php echo base_url();?>admin/admin_laporan/index" <?php echo 'class="'.$menu_laporan.'"';?>>
                        <span class="icon"><i class="fas fa-chart-line"></i></span>
                        <span class="item">Laporan</span>
                    </a>

                    
                    <a href="<?php echo base_url();?>admin/admin_petugas/index" <?php echo 'class="'.$menu_petugas.'"';?>>
                        <span class="icon"><i class="fas fa-user-shield"></i></span>
                        <span class="item">Petugas</span>
                    </a>

                    <a href="<?php echo base_url();?>admin/admin_user/index" <?php echo 'class="'.$menu_user.'"';?>>
                        <span class="icon"><i class="fas fa-user-shield"></i></span>
                        <span class="item">User Admin</span>
                    </a>
            </div>
            
            