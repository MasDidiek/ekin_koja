<aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <h1 class="navbar-brand navbar-brand-autodark">
        <a href=".">
        <i class="fa-solid fa-laptop-file"></i> Ekinerja
        </a>
      </h1>
      <div class="navbar-nav flex-row d-lg-none">
  
      
        <div class="nav-item dropdown">
          <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
            <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
            <div class="d-none d-xl-block ps-2">
              <div>Paweł Kuna</div>
              <div class="mt-1 small text-secondary">UI Designer</div>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
            <a href="#" class="dropdown-item">Status</a>
            <a href="./profile.html" class="dropdown-item">Profile</a>
            <a href="#" class="dropdown-item">Feedback</a>
            <div class="dropdown-divider"></div>
            <a href="./settings.html" class="dropdown-item">Settings</a>
            <a href="<?php echo base_url();?>login/logout" class="dropdown-item">Logout</a>
          </div>
        </div>
      </div>


      <?php

            $parentMenu = $this->Master_model->getListMenu($menu_type='P', $parent_id=0);

        ?>

      <div class="collapse navbar-collapse" id="sidebar-menu">
        <ul class="navbar-nav pt-lg-3">

            <?php
                for ($i=0; $i < count($parentMenu) ; $i++) { 
                    $id_menu = $parentMenu[$i]->id_menu;
                    $menu_name = $parentMenu[$i]->menu_name;
                    $link = $parentMenu[$i]->link;
                    $icon = $parentMenu[$i]->icon;

                    $childMenu = $this->Master_model->getListMenu($menu_type='C', $parent_id=$id_menu);
                  
                    if(empty($childMenu)){
                        echo ' <li class="nav-item">
                                <a class="nav-link" href="'.base_url().$link .'" >
                                <span class="nav-link-icon d-md-none d-lg-inline-block">'. $icon.'  </span>
                                <span class="nav-link-title">
                                    '.$menu_name.'
                                </span>
                                </a>
                            </li>';
                    }else{

                        echo ' <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                                        <span class="nav-link-icon d-md-none d-lg-inline-block">'. $icon.'  </span>
                                        <span class="nav-link-title"> '.$menu_name.' </span> 
                                    </a>
                                       <div class="dropdown-menu"> ';

                                        for ($c=0; $c < count($childMenu); $c++) { 
                                                echo '  <a class="dropdown-item" href="'.base_url().$childMenu[$c]->link.'">
                                                            '.$childMenu[$c]->menu_name.'
                                                        </a>';
                                        
                                        }


                                echo ' 
                                 </div>
                            </li>';
                     
                    }

                  


                }

            ?>


        </ul>
      </div>
    </div>
  </aside>