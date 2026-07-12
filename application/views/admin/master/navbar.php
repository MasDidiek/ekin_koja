	<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class="sidebar-brand" href="<?php echo base_url();?>home/index">
                     SIPUSPA
                </a>


                <?php

                    #print_array($this->session->userdata);
                    $nama = $this->session->userdata('nama');
                    $id_user = $this->session->userdata('id_user');
                    $usergroup= $this->session->userdata('usergroup');
                    
                    if($id_user==''){
                        redirect('login/index');
                    }
                    
                    
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
			
			
			
				<ul class="sidebar-nav">
					<li class="sidebar-header">
						Pages
					</li>



					</li>
				
    				    <li class="sidebar-item <?php echo $menu_home ;?>">
    						  <a href="<?php echo base_url();?>admin/home/index"  class="sidebar-link">
                            <i class="align-middle" data-feather="home"></i> <span class="align-middle">Dashboard</span>
                          </a>
				    	</li>
				    	<li class="sidebar-item <?php echo $menu_driver ;?>">
    						  <a href="<?php echo base_url();?>admin/admin_driver/index"  class="sidebar-link">
                            <i class="align-middle" data-feather="truck"></i> <span class="align-middle">Pengemudi</span>
                          </a>
				    	</li>
				    	<li class="sidebar-item <?php echo $menu_pemeriksaan ;?>">
    						  <a href="<?php echo base_url();?>admin/admin_pemeriksaan/index"  class="sidebar-link">
                            <i class="align-middle" data-feather="clipboard"></i> <span class="align-middle">Data Pemeriksaan</span>
                          </a>
				    	</li>
				    	<li class="sidebar-item <?php echo $menu_laporan ;?>">
    						  <a href="<?php echo base_url();?>admin/admin_laporan/index"  class="sidebar-link">
                            <i class="align-middle" data-feather="book"></i> <span class="align-middle">Laporan</span>
                          </a>
				    	</li>

						<li class="sidebar-item <?php echo $menu_petugas;?>">
    						  <a href="<?php echo base_url();?>admin/admin_petugas/index"  class="sidebar-link">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">Petugas</span>
                          </a>
				    	</li>

				    	
				    	<li class="sidebar-item">
    						  <a href="<?php echo base_url();?>admin/admin_user/index"  class="sidebar-link">
                            <i class="align-middle" data-feather="user"></i> <span class="align-middle">User Admin</span>
                          </a>
				    	</li>
				    	
				    	
				    	
				    	



			</div>
		</nav>

		<div class="main">
			<nav class="navbar navbar-expand navbar-light navbar-bg">
				<a class="sidebar-toggle js-sidebar-toggle">
          <i class="hamburger align-self-center"></i>
        </a>
        
      
				<div class="navbar-collapse collapse">
					<ul class="navbar-nav navbar-align">
					
				
						<li class="nav-item dropdown">
							<a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                        <i class="align-middle" data-feather="settings"></i>
                      </a>

							<a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                <img src="<?php echo base_url();?>assets/img/avatar_01.jpeg" class="avatar img-fluid rounded me-1" alt="<?php echo  $nama ;?>" /> <span class="text-dark"><?php echo  $nama ;?></span>
              </a>
							<div class="dropdown-menu dropdown-menu-end">
								<a class="dropdown-item" href="pages-profile.html"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="pie-chart"></i> Analytics</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="index.html"><i class="align-middle me-1" data-feather="settings"></i> Settings & Privacy</a>
								<a class="dropdown-item" href="#"><i class="align-middle me-1" data-feather="help-circle"></i> Help Center</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?php echo base_url();?>login/logout">Log out</a>
							</div>
						</li>
					</ul>
				</div>
			</nav>