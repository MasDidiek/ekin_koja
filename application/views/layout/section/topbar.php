                    <div class="navbar-custom">
                        <ul class="list-unstyled topbar-menu float-end mb-0">
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <i class="dripicons-bell noti-icon"></i>
                                    <?php
                                        $id_pegawai = $this->session->userdata("id_pegawai");
                                        $penggantian_cuti= $this->acm->getPengajuanCutiPegawai($id_pegawai, 'pengganti');
                                        if(count($penggantian_cuti) > 0){
                                            echo ' <span class="noti-icon-badge"></span>';
                                        }
                                    ?>
                                   
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                    <!-- item-->
                                    <div class="dropdown-item noti-title">
                                        <h5 class="m-0">
                                            <span class="float-end">
                                                <a href="javascript: void(0);" class="text-dark">
                                                    <small>Clear All</small>
                                                </a>
                                            </span>Notification
                                        </h5>
                                    </div>


                                    <div style="max-height: 230px;" data-simplebar="">
                                        <!-- item-->

                                        <?php

//print_array($this->session->userdata);

//print_array($penggantian_cuti);
                                    foreach($penggantian_cuti as $cuti){
                                        $id_cuti = $cuti->id;   
                                        $namaPegawai = $cuti->nama;
                                        $alasan_cuti = $cuti->alasan_cuti;
                                        $tgl_dari = $cuti->tgl_mulai;
                                        $tgl_sampai = $cuti->tgl_selesai;
                                         $lama_cuti = $cuti->lama_cuti;


                                         if($lama_cuti==1){
                                              $tgl_cuti = date('d F Y', strtotime($tgl_dari));
                                         }else{
                                            $tgl_cuti = date('d F Y', strtotime($tgl_dari)).' s/d '.date('d F Y', strtotime($tgl_sampai));
                                         }


                                         echo ' 
                                                        
                                                <a href="'.base_url().'cuti/detail_pengajuan_cuti/'.$id_cuti.'" class="dropdown-item notify-item">
                                                    <div class="notify-icon bg-success">
                                                    <i class="uil uil-briefcase"></i>
                                                    </div>
                                                    <p class="notify-details">
                                                    '.$namaPegawai.'
                                                        <small class="text-muted">" '.$alasan_cuti.' "</small>
                                                      
                                                        <small class="text-dark fw-semibold"> '.$tgl_cuti.'</small>
                                                    </p>
                                                </a>';


                                    }
                        

                                            // $id_cuti = 0;

                                            // for ($c=0; $c < count($penggantian_cuti); $c++) 
                                            // { 
                                            //     $id_cuti = $penggantian_cuti[$c]->id;
                                            //     $id_pegawai_cuti = $penggantian_cuti[$c]->id_pegawai;
                                            //     $alasan_cuti = $penggantian_cuti[$c]->alasan_cuti;
                                            //     $tgl_dari = $penggantian_cuti[$c]->tgl_dari;
                                            //     $tgl_sampai = $penggantian_cuti[$c]->tgl_sampai;

                                            //     $detail_pegawai_cuti = $this->Pegawai_model->getDetailPegawai($id_pegawai_cuti);

                                            //     $namaPegawai =  $detail_pegawai_cuti[0]->nama;


                                            //     echo ' 
                                                        
                                            //     <a href="'.base_url().'cuti/detail_pengajuan_cuti/'.$id_cuti.'" class="dropdown-item notify-item">
                                            //         <div class="notify-icon bg-success">
                                            //         <i class="uil uil-briefcase"></i>
                                            //         </div>
                                            //         <p class="notify-details">
                                            //         '.$namaPegawai.'
                                            //             <small class="text-muted">Permohonan Pengganti Cuti </small>
                                            //         </p>
                                            //     </a>

                                            // ';

                                            // }
                                            ?>



                                    </div>

                                    

                                    <!-- All-->
                                    <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item notify-all">
                                        View All
                                    </a>

                                </div>
                            </li>

                            
                            <li class="notification-list">
                                <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                    <i class="dripicons-gear noti-icon"></i>
                                </a>
                            </li>
                          <?php

                              $nama_user =  $this->session->userdata('nama');
                              $nip_user =  $this->session->userdata('nip');
                              $id_pegawai =  $this->session->userdata('id_pegawai');
                              $photo = $this->Pegawai_model->getPhotoPegawai($nip_user);


                              $pin 						 = substr($nip_user, -4);

                              $detail_pegawai = $this->Pegawai_model->getDetailPegawai($id_pegawai);

                            //   print_array($detail_pegawai);
                            //   exit;

                              $jabatan =   $detail_pegawai->jabatan;
                              $puskesmas =   $detail_pegawai->puskesmas;




                              $penggantian_cuti = $this->Cuti_model->getPermohonanPengganti($id_pegawai);
                              $numPermohonan = count($penggantian_cuti);

                              if($photo==''){
                                $photo = 'avatar.png';
                              }
                           ?>
                            <li class="dropdown notification-list">
                                <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                    <span class="account-user-avatar">
                                        <img src="<?php echo base_url();?>uploads/photo_profile/<?php echo $photo ;?>" alt="user-image" class="rounded-circle">
                                    </span>
                                    <span>
                                        <span class="account-user-name"><?php echo $nama_user;?></span>
                                        <span class="account-position"><?php echo $jabatan;?></span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                    <!-- item-->
                                    <div class=" dropdown-header noti-title">
                                        <h6 class="text-overflow m-0">Welcome !</h6>
                                    </div>

                                    <!-- item-->
                                    <a href="<?php echo base_url();?>profile/my_profile" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-circle me-1"></i>
                                        <span>My Account</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="mdi mdi-account-edit me-1"></i>
                                        <span>Settings</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="mdi mdi-lifebuoy me-1"></i>
                                        <span>Support</span>
                                    </a>

                                    <!-- item-->
                                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                                        <i class="mdi mdi-lock-outline me-1"></i>
                                        <span>Lock Screen</span>
                                    </a>

                                    <!-- item-->
                                    <a href="<?php echo base_url();?>login/logout" class="dropdown-item notify-item">
                                        <i class="mdi mdi-logout me-1"></i>
                                        <span>Logout</span>
                                    </a>
                                </div>
                            </li>

                        </ul>
                        <button class="button-menu-mobile open-left">
                            <i class="mdi mdi-menu"></i>
                        </button>
                        <div class="app-search dropdown d-none d-lg-block">
                            <form method="post" action="<?php echo base_url();?>admin/pengajuan_cuti/search_pegawai_cuti">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control dropdown-toggle" placeholder="Search..." id="top-search">
                                    <span class="mdi mdi-magnify search-icon"></span>
                                    <button class="input-group-text btn-primary" type="submit">Search</button>
                                </div>
                            </form>

                           
                        </div>
                    </div>
                    <!-- end Topbar -->