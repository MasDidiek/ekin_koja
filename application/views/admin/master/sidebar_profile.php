
<nav id="navbar-main" class="navbar is-fixed-top">
  <div class="navbar-brand">
    <a class="navbar-item mobile-aside-button">
      <span class="icon"><i class="mdi mdi-forwardburger mdi-24px"></i></span>
    </a>
    <div class="navbar-item">
      <div class="control"><input placeholder="Search everywhere..." class="input"></div>
    </div>
  </div>
  <div class="navbar-brand is-right">
    <a class="navbar-item --jb-navbar-menu-toggle" data-target="navbar-menu">
      <span class="icon"><i class="mdi mdi-dots-vertical mdi-24px"></i></span>
    </a>
  </div>
  <div class="navbar-menu" id="navbar-menu">
    <div class="navbar-end">
      
      <div class="navbar-item dropdown has-divider has-user-avatar">
        <a class="navbar-link">
          <div class="user-avatar">
           
          </div>
          <div class="is-user-name"><span>Administrator</span></div>
          <span class="icon"><i class="mdi mdi-chevron-down"></i></span>
        </a>
        <div class="navbar-dropdown">
          <a href="profile.html" class="navbar-item">
            <span class="icon"><i class="mdi mdi-account"></i></span>
            <span>My Profile</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-settings"></i></span>
            <span>Settings</span>
          </a>
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-email"></i></span>
            <span>Messages</span>
          </a>
          <hr class="navbar-divider">
          <a class="navbar-item">
            <span class="icon"><i class="mdi mdi-logout"></i></span>
            <span>Log Out</span>
          </a>
        </div>
      </div>
    
  
      <a title="Log out" class="navbar-item desktop-icon-only">
        <span class="icon"><i class="mdi mdi-logout"></i></span>
        <span>Log out</span>
      </a>
    </div>
  </div>
</nav>

<aside class="aside is-placed-left is-expanded">
  <div class="aside-tools">
    <div>
      SIPUSPA <b class="font-black">CAKUNG</b>
    </div>
  </div>
  <div class="menu is-menu-main">
    <p class="menu-label">General</p>
    <ul class="menu-list">
      <li class="--set-active-index-html">
        <a href="index.html">
          <span class="icon"><i class="mdi mdi-desktop-mac"></i></span>
          <span class="menu-item-label">Dashboard</span>
        </a>
      </li>
    </ul>
    <p class="menu-label">Examples</p>
    <ul class="menu-list">
      <li class="active">
        <a href="<?php echo base_url();?>admin/admin_driver/index">
          <span class="icon"><i class="mdi mdi-account-circle"></i></span>
          <span class="menu-item-label">Pengemudi</span>
        </a>
      </li>

      <li class="--set-active-profile-html">
        <a href="<?php echo base_url();?>admin/admin_pemeriksaan/index">
          <span class="icon"><i class="mdi mdi-table"></i></span>
          <span class="menu-item-label">Data Pemeriksaan</span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url();?>admin/admin_laporan/index">
          <span class="icon"><i class="mdi mdi-file"></i></span>
          <span class="menu-item-label">Laporan</span>
        </a>
      </li>
      <li>
        <a href="<?php echo base_url();?>admin/admin_user/index"">
          <span class="icon"><i class="mdi mdi-lock"></i></span>
          <span class="menu-item-label">User Admin</span>
        </a>
      </li>
     
    </ul>
    
  </div>
</aside>
