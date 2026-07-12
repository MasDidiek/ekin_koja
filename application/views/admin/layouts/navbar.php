         
         <?php

        $nama = $this->session->userdata('nama');
        $id_user = $this->session->userdata('id_user');
        $usergroup= $this->session->userdata('usergroup');

        if($id_user==''){
        redirect('login/index');
        }

        ?>
         <div class="topbar d-flex justify-content-between align-items-center px-3">
                <div class="d-flex align-items-center">
                    <button class="btn text-dark btn-sm me-3 sidebar-toggle" type="button" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="topbar-user">
                    
                        <div>
                            <div class="text-dark" style="font-weight: 600; font-size: 0.875rem;"><?php echo $nama; ?></div>
                         
                        </div>
                    </div>
                    <a href="<?php echo base_url('login/logout'); ?>" class="btn btn-danger btn-sm">
                        <i class="fas fa-sign-out-alt me-1"></i> Logout
                    </a>
                </div>
            </div>