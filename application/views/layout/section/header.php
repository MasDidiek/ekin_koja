<header class="topbar">
  <div class="with-vertical">

    <?php

    $nama_user =  $this->session->userdata('nama');
    $nip_user =  $this->session->userdata('nip');
    $id_pegawai =  $this->session->userdata('id_pegawai');
    $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);

    #print_array($this->session->userdata);

    $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);
    if(!$detail_pegawai){
      redirect('login/logout');
    }

    $jabatan =  $detail_pegawai[0]->jabatan;
    $puskesmas =  $detail_pegawai[0]->puskesmas;


    $permohonanPengganti = $this->Cuti_model->getPermohonanPengganti($id_pegawai);
    $numPermohonan = count($permohonanPengganti);

    if ($photo == '') {
      $photo = 'avatar.png';
    }


    ?>
    <nav class="navbar navbar-expand-lg p-0">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link sidebartoggler nav-icon-hover ms-n3" id="headerCollapse" href="javascript:void(0)">
            <i class="fa-solid fa-bars"></i>
          </a>
        </li>

        <li class="nav-item d-none d-lg-block">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="ti ti-search"></i>
          </a>
        </li>
      </ul>

      <div class="d-block d-lg-none">
        <img src="../assets/images/logos/dark-logo.svg" width="180" alt="" />
      </div>
      <a class="navbar-toggler nav-icon-hover p-0 border-0" href="javascript:void(0)" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="p-2">
          <i class="ti ti-dots fs-7"></i>
        </span>
      </a>
      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <div class="d-flex align-items-center justify-content-between">
          <a href="javascript:void(0)" class="nav-link d-flex d-lg-none align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobilenavbar" aria-controls="offcanvasWithBothOptions">
            <i class="ti ti-align-justified fs-7"></i>
          </a>


          <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-center">

            <li class="nav-item">
              <a class="nav-link position-relative nav-icon-hover" href="javascript:void(0)" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight">
                <i class="ti ti-calendar"></i>
                <?php
                if ($numPermohonan > 0) {
                  echo '   <span class="popup-badge rounded-pill bg-danger text-white fs-2">' . $numPermohonan . '</span>';
                }
                ?>


              </a>
            </li>

            <li class="nav-item dropdown">
              <a class="nav-link pe-0" href="javascript:void(0)" id="drop1" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="d-flex align-items-center">
                  <div class="user-profile-img">
                    <img src="<?php echo base_url(); ?>uploads/photo_profile/<?php echo $photo; ?>" class="rounded-circle" width="35" height="35" alt="" />
                  </div>
                </div>
              </a>
              <div class="dropdown-menu content-dd dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop1">
                <div class="profile-dropdown position-relative" data-simplebar>
                  <div class="py-3 px-7 pb-0">
                    <h5 class="mb-0 fs-5 fw-semibold">User Profile</h5>
                  </div>
                  <div class="d-flex align-items-center py-9 mx-7 border-bottom">
                    <img src="<?php echo base_url(); ?>uploads/photo_profile/<?php echo $photo; ?>" class="rounded-circle" width="80" height="80" alt="" />
                    <div class="ms-3">
                      <h5 class="mb-1 fs-3"><?php echo $nama_user; ?></h5>
                      <span class="mb-1 d-block"><?php echo $jabatan; ?></span>
                      <p class="mb-0 d-flex align-items-center gap-2">
                        <i class="ti ti-mail fs-4"></i> <?php echo $puskesmas; ?>
                      </p>
                    </div>
                  </div>


                  <div class="message-body">
                    <a href="<?php echo base_url(); ?>profile/my_profile" class="py-8 px-7 mt-8 d-flex align-items-center">
                      <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-cog" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                          <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                          <path d="M6 21v-2a4 4 0 0 1 4 -4h2.5"></path>
                          <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path>
                          <path d="M19.001 15.5v1.5"></path>
                          <path d="M19.001 21v1.5"></path>
                          <path d="M22.032 17.25l-1.299 .75"></path>
                          <path d="M17.27 20l-1.3 .75"></path>
                          <path d="M15.97 17.25l1.3 .75"></path>
                          <path d="M20.733 20l1.3 .75"></path>
                        </svg>
                      </span>
                      <div class="w-75 d-inline-block v-middle ps-3">
                        <h6 class="mb-1 fs-3 fw-semibold lh-base">My Profile</h6>
                        <span class="fs-2 d-block text-body-secondary">Account Settings</span>
                      </div>
                    </a>
                    <a href="<?php echo base_url(); ?>profile/change_password" class="py-8 px-7 d-flex align-items-center">
                      <span class="d-flex align-items-center justify-content-center text-bg-light rounded-1 p-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock-cog" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                          <path d="M12 21h-5a2 2 0 0 1 -2 -2v-6a2 2 0 0 1 2 -2h10c.564 0 1.074 .234 1.437 .61" />
                          <path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" />
                          <path d="M8 11v-4a4 4 0 1 1 8 0v4" />
                          <path d="M19.001 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                          <path d="M19.001 15.5v1.5" />
                          <path d="M19.001 21v1.5" />
                          <path d="M22.032 17.25l-1.299 .75" />
                          <path d="M17.27 20l-1.3 .75" />
                          <path d="M15.97 17.25l1.3 .75" />
                          <path d="M20.733 20l1.3 .75" />
                        </svg>
                      </span>
                      <div class="w-75 d-inline-block v-middle ps-3">
                        <h6 class="mb-1 fs-3 fw-semibold lh-base">Password</h6>
                        <span class="fs-2 d-block text-body-secondary">Change Password</span>
                      </div>
                    </a>

                  </div>
                  <div class="d-grid py-4 px-7 pt-8">

                    <a href="<?php echo base_url(); ?>login/logout" class="btn btn-outline-primary">Log Out</a>
                  </div>
                </div>

              </div>
            </li>
            <!-- ------------------------------- -->
            <!-- end profile Dropdown -->
            <!-- ------------------------------- -->
          </ul>


        </div>
      </div>
    </nav>


  </div>

</header>