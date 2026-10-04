<div class="leftside-menu">
    <?php     $usergroup = $this->session->userdata('usergroup');?>
      <!-- LOGO -->
      <a href="<?php echo base_url();?>dashboard/index" class="logo text-center logo-light">
          <span class="logo-lg">
              <img src="<?php echo base_url();?>assets/images/logo-ekin-baru.png" alt="" height="16">
          </span>
          <span class="logo-sm">
              <img src="<?php echo base_url();?>assets/images/logo-ekin-baru.png" alt="" height="16">
          </span>
      </a>

      <!-- LOGO -->
      <a href="<?php echo base_url();?>dashboard/index" class="logo text-center logo-dark">
          <span class="logo-lg">
              <img src="<?php echo base_url();?>assets/images/logo-ekin-baru.png" alt="" height="40">
          </span>
          <span class="logo-sm">
              <img src="<?php echo base_url();?>assets/images/logo-ekin-baru.png" alt="" height="16">
          </span>
      </a>

      <div class="h-100" id="leftside-menu-container" data-simplebar="">

          <!--- Sidemenu -->

          <ul class="side-nav">

                  <li class="side-nav-title side-nav-item">Navigation</li>

                  <?php

                    if($usergroup < 6){
                        echo '<li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#dashboard" aria-expanded="false" aria-controls="dashboard" class="side-nav-link">
                                        <i class="uil-clipboard-alt"></i>
                                        <span> Dashboard </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="dashboard">
                                        <ul class="side-nav-second-level">
                                            <li>
                                                <a href="'.base_url().'dashboard/my_dashboard">User Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="'.base_url().'dashboard/dashboard_pengajuan_cuti">Admin Dashboard</a>
                                            </li>

                                        </ul>
                                    </div>
                                </li>';
                    }else{

                        echo ' <li class="side-nav-item">
                                    <a  href="'.base_url().'dashboard/index" class="side-nav-link">
                                        <i class="uil-home-alt"></i>

                                        <span> Dashboards </span>
                                    </a>

                                </li>';

                    }

                    ?>







                  <li class="side-nav-title side-nav-item">User Menu</li>

                  <?php
                       if ($usergroup == 6 || $usergroup == 7 || $usergroup==0)  {

                  ?>
                  <li class="side-nav-item">
                      <a data-bs-toggle="collapse" href="#sidebarTasks" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                          <i class="uil-clipboard-alt"></i>
                          <span> My Absensi </span>
                          <span class="menu-arrow"></span>
                      </a>
                      <div class="collapse" id="sidebarTasks">
                          <ul class="side-nav-second-level">
                              <li>
                                  <a href="<?php echo base_url();?>absensi/view_absensi">Kehadiran</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>absensi/rekap_absensi">Rekap Absensi</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>absensi/pengajuan_dinas_luar">Dinas Luar</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>absensi/pengajuan_izin_sakit">Izin - Sakit</a>
                              </li>
                          </ul>
                      </div>
                  </li>

                  <li class="side-nav-item">
                      <a data-bs-toggle="collapse" href="#kinerja" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                          <i class="uil-chart"></i>
                          <span> Kinerja </span>
                          <span class="menu-arrow"></span>
                      </a>
                      <div class="collapse" id="kinerja">
                          <ul class="side-nav-second-level">
                              <li>
                                  <a href="<?php echo base_url();?>kinerja/index">Input Kinerja</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>kinerja/capaian_kinerja_v2">Capaian</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>kinerja/pengaturan_aktifitas">Pengaturan Aktifitas</a>
                              </li>

                          </ul>
                      </div>
                  </li>

                  <?php } ?>



                  <li class="side-nav-title side-nav-item">Admin Menu</li>

                <?php
                //  print_array($this->session->userdata);


                    if($usergroup < 6){
                ?>


                <li class="side-nav-item">
                      <a data-bs-toggle="collapse" href="#absenPegawai" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                          <i class="uil-clipboard-alt"></i>
                          <span>Absensi Pegawai</span>
                          <span class="menu-arrow"></span>
                      </a>
                      <div class="collapse" id="absenPegawai">
                          <ul class="side-nav-second-level">
                              <li>
                                  <a href="<?php echo base_url();?>admin/presensi/index_v2">Data Absensi</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>admin/presensi/rekap_absensi">Rekap Absensi</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>admin_jadwal_shift/index">Jadwal Dinas</a>
                              </li>

                          </ul>
                      </div>
                  </li>

                  <li class="side-nav-item">
                      <a data-bs-toggle="collapse" href="#pegawai" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                          <i class="uil-user"></i>
                          <span> Pegawai </span>
                          <span class="menu-arrow"></span>
                      </a>
                      <div class="collapse" id="pegawai">
                          <ul class="side-nav-second-level">
                              <li>
                                  <a href="<?php echo base_url();?>admin/pegawai/list_pegawai/non_pns">Pegawai NON PNS</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>admin/pegawai/list_pegawai/pns">Pegawai PNS</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>admin/pegawai/list_pegawai/pppk">Pegawai PPPK</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>admin/pegawai/list_pegawai/pjlp">Pegawai PJLP</a>
                              </li>

                          </ul>
                      </div>
                  </li>


                  <li class="side-nav-item">
                      <a data-bs-toggle="collapse" href="#validasi" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                          <i class="uil-file-bookmark-alt"></i>
                          <span> Penilaian Kinerja </span>
                          <span class="menu-arrow"></span>
                      </a>
                      <div class="collapse" id="validasi">
                          <ul class="side-nav-second-level">
                              <li>
                                  <a href="<?php echo base_url();?>admin/penilaian_kinerja/validasi_aktifitas">Penilaian Aktifitas</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>admin/penilaian_kinerja/perilaku">Penilaian Perilaku</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>admin/penilaian_kinerja/capaian_kinerja">Capaian Kinerja</a>
                              </li>

                          </ul>
                      </div>
                  </li>


                        <?php if($usergroup ==0){    ?>
                                        <li class="side-nav-item">
                                            <a data-bs-toggle="collapse" href="#listing" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                                                <i class="uil-usd-square"></i>
                                                <span> Data Listing</span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="collapse" id="listing">
                                                <ul class="side-nav-second-level">
                                                    <li>
                                                        <a href="<?php echo base_url();?>admin/listing_tkd/index">Listing  TKD</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url();?>admin/listing_tkd/listing_gaji">Listing  Gaji</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url();?>laporan/listing_gaji13">Listing  Gaji ke 13</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>

                                        <li class="side-nav-item">
                                            <a data-bs-toggle="collapse" href="#datagaji" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                                                <i class="uil-usd-square"></i>
                                                <span> Gaji Pegawai </span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="collapse" id="datagaji">
                                                <ul class="side-nav-second-level">
                                                    <li>
                                                        <a href="<?php echo base_url();?>admin/gaji/index">Data Gaji</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url();?>admin/setting/master_gaji">Master Data Gaji</a>
                                                    </li>


                                                </ul>
                                            </div>
                                        </li>

                                        <li class="side-nav-item">
                                            <a data-bs-toggle="collapse" href="#setting" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                                                <i class="uil-cog"></i>
                                                <span> Pengaturan </span>
                                                <span class="menu-arrow"></span>
                                            </a>
                                            <div class="collapse" id="setting">
                                                <ul class="side-nav-second-level">
                                                    <li>
                                                        <a href="<?php echo base_url();?>admin/setting/hari_kerja">Hari Kerja</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url();?>admin/setting/hari_libur">Hari Libur</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url();?>admin/setting/mesin_absensi">Mesin Absensi</a>
                                                    </li>
                                                    <li>
                                                        <a href="<?php echo base_url();?>admin/setting/shift_kerja">Jadwal Kerja</a>
                                                    </li>

                                                     <li>
                                                        <a href="<?php echo base_url();?>admin/auth/menu">Menu</a>
                                                    </li>

                                                </ul>
                                            </div>
                                        </li>

                        <?php } ?>

                  <li class="side-nav-item">
                      <a href="<?php echo base_url();?>admin/pengajuan_cuti/index" class="side-nav-link">
                          <i class="uil-calender"></i>
                          <span>Pengajuan Cuti </span>
                      </a>
                  </li>


                  <li class="side-nav-item">
                        <a href="<?php echo base_url();?>admin_jadwal_shift/index" class="side-nav-link">
                            <i class="uil-calender"></i>
                            <span> Jadwal Dinas </span>
                        </a>
                    </li>


             <?php } ?>

                    <?php

                        if($usergroup == 7){ //penanggung jawab
                            echo '
                                    <li class="side-nav-item">
                                        <a href="'.base_url().'admin_jadwal_shift/index" class="side-nav-link">
                                            <i class="uil-calender"></i>
                                            <span> Jadwal Dinas </span>
                                        </a>
                                    </li>';
                        }
                    ?>

             <?php
                    if($usergroup != 3){?>




                    <li class="side-nav-item">
                      <a data-bs-toggle="collapse" href="#tkd_gaji" aria-expanded="false" aria-controls="sidebarTasks" class="side-nav-link">
                          <i class="uil-usd-square"></i>
                          <span> TKD & Gaji </span>
                          <span class="menu-arrow"></span>
                      </a>
                      <div class="collapse" id="tkd_gaji">
                          <ul class="side-nav-second-level">
                              <li>
                                  <a href="<?php echo base_url();?>profile/my_tkd">Data TKD</a>
                              </li>
                              <li>
                                  <a href="<?php echo base_url();?>profile/my_gaji">Data Gaji</a>
                              </li>


                          </ul>
                      </div>
                  </li>


                <?php  }  ?>




                  <li class="side-nav-item">
                      <a href="<?php echo base_url();?>cuti/my_cuti" class="side-nav-link">
                          <i class="uil-calender"></i>
                          <span> My Cuti </span>
                      </a>
                  </li>

            </ul>


          <div class="clearfix"></div>

      </div>
      <!-- Sidebar -left -->

  </div>
  <!-- Left Sidebar End -->

  <!-- ============================================================== -->
  <!-- Start Page Content here -->
  <!-- ============================================================== -->
