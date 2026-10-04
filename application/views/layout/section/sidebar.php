<?php
$global_config = $this->Master_model->config_global();
$logo = $global_config[0]->logo;
?>

<div class="brand-logo d-flex align-items-center justify-content-between">
  <a href="<?php echo base_url(); ?>dashboard/index" class="text-nowrap logo-img">
    <img src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>" width="140" alt="" />
  </a>
  <a href="javascript:void(0)" class="sidebartoggler ms-auto text-decoration-none fs-5 d-block d-xl-none">
    <i class="ti ti-x"></i>
  </a>
</div>


<nav class="sidebar-nav scroll-sidebar" data-simplebar>
  <ul id="sidebarnav">
    <!-- ---------------------------------- -->
    <!-- Home -->
    <!-- ---------------------------------- -->
    <li class="nav-small-cap">
      <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
      <span class="hide-menu">Home</span>
    </li>
    <!-- ---------------------------------- -->
    <!-- Dashboard -->
    <!-- ---------------------------------- -->


    <?php

    $parentMenu  = $this->Master_model->getListMenu($menu_type = 'P', $parent_id = 0);
    $id_usergroup = $this->session->userdata('usergroup');

    ?>


    <?php
    for ($i = 0; $i < count($parentMenu); $i++) {
      $id_menu = $parentMenu[$i]->id_menu;
      $menu_name = $parentMenu[$i]->menu_name;
      $link = $parentMenu[$i]->link;
      $icon = $parentMenu[$i]->icon;

      $childMenu = $this->Master_model->getListMenu($menu_type = 'C', $parent_id = $id_menu);

      $cekAuthMenu = $this->Auth_model->cekAuthMenu($id_usergroup, $id_menu);

      if ($cekAuthMenu) {
        if (empty($childMenu)) {
          echo ' <li class="sidebar-item">
                                        <a class="sidebar-link" href="' . base_url() . $link . '" aria-expanded="false">
                                        <span>
                                        ' . $icon . '
                                        </span>
                                        <span class="hide-menu"> ' . $menu_name . '</span>
                                        </a>
                                    </li>';
        } else {

          echo ' <li class="sidebar-item">
                                      <a  class="sidebar-link has-arrow" href="javascript:void(0)"  aria-expanded="false" >
                                                <span class="d-flex">   ' . $icon . '</span>
                                                <span class="hide-menu">' . $menu_name . '</span>
                                        </a>
                                        <ul aria-expanded="false" class="collapse first-level">  ';

          for ($c = 0; $c < count($childMenu); $c++) {
            echo ' <li class="sidebar-item">
                                                      <a class="sidebar-link" href="' . base_url() . $childMenu[$c]->link . '">
                                                        <div class="round-16 d-flex align-items-center justify-content-center">
                                                            <i class="ti ti-circle"></i>
                                                        </div>
                                                        <span class="hide-menu">  ' . $childMenu[$c]->menu_name . '  </span>
                                                      </a>
                                                    </li>';
          }


          echo '  </ul>
                                    </li>';
        }
      }
    }

    ?>


  </ul>
</nav>