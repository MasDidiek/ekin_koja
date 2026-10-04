<!doctype html>
<html lang="en" dir="ltr" data-bs-theme="light" data-color-theme="Blue_Theme" data-layout="vertical" data-boxed-layout="boxed" data-card="shadow">
  <head>
         <?php  $this->load->view('master/meta');?>

  </head>
  <body >
 <!--  Body Wrapper -->
 <script src="<?php echo base_url();?>assets/js/demo-theme.min.js?1685973381')}}"></script>
 <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <!-- Sidebar Start -->
      <?php $this->load->view('layout/section/sidebar');?>

    <!--  Sidebar End -->
    <!--  Main wrapper -->
    <div class="body-wrapper">
      <!--  Header Start -->
    
      <?php $this->load->view('layout/section/header');?>
      <!--  Header End -->
      <div class="container-fluid mw-100">
        <!--  Row 1 -->
                <div class="card bg-info-subtle shadow-none position-relative overflow-hidden mb-4">
                        <div class="card-body px-4 py-3">
                            <div class="row align-items-center">
                                <div class="col-9">
                                    <h4 class="fw-semibold mb-8">Account Setting</h4>
                                    <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item">
                                        <a class="text-muted text-decoration-none" href="../main/index.html"
                                            >Home</a
                                        >
                                        </li>
                                        <li class="breadcrumb-item" aria-current="page">Account Setting</li>
                                    </ol>
                                    </nav>
                                </div>
                                <div class="col-3">
                                    <div class="text-center mb-n5">
                                    <img
                                        src="../assets/images/breadcrumb/ChatBc.png"
                                        alt=""
                                        class="img-fluid mb-n4"
                                    />
                                    </div>
                                </div>
                        </div>
                </div>
            </div>


            <?php
              // print_array($pegawai);

              // [jns_pegawai] => non_pns
              // [jns_jam_kerja] => non_shift
              // [password] => e10adc3949ba59abbe56e057f20f883e
              // [status_kawin] => 4
              // [status_pajak] => 0
              // [id_pendidikan] => 4
              // [status_kerja] => 1
              // [jabfung] => 
              // [id_validator] => 6
              // [kategori_masa_kerja] => 1
              // [masa_kerja] => 1-0-30
              // [tahun_anggaran] => 2023
              // [usergroup] => 7
              // [id] => 37
              // [npwp] => 533170544045000
              // [no_rekening] => 20523232084
              // [no_ktp] => 3172046301980001
              // [tempat_lahir] => KOTA JAKARTA UTARA
              // [tgl_lahir] => 2023-01-01
              // [alamat_ktp] => Rusunawa Nagrak Tower 14 Cilincing Jakarta Utara
              // [alamat_domisili] => 
              // [no_tlp] => 0895320039036
              // [email] => inkah45@gmail.com
              // [photo] => 10202719980123202201352.jpg
              // [gaji_pokok] => 4078947
              // [pengkalian] => 0.8
              // [pph21] => 99590
              // [bpjs_kes] => 49018
              // [bpjs_tk] => 122368
              // [ptkp] => 4500000

              $photo = $pegawai[0]->photo;

              if($photo==''){
                $photo = 'avatar.png';
              }
            ?>
         <div class="card">
            <ul class="nav nav-pills user-profile-tab" id="pills-tab" role="tablist">
              <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 active d-flex align-items-center justify-content-center bg-transparent fs-3 py-4"
                    id="pills-account-tab" data-bs-toggle="pill" data-bs-target="#pills-account" type="button" role="tab"
                    aria-controls="pills-account" aria-selected="true">
                    <i class="ti ti-user-circle me-2 fs-6"></i>
                    <span class="d-none d-md-block">Account</span>
                </button>
              </li>

              <li class="nav-item" role="presentation">
                <button
                    class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4"
                    id="pills-notifications-tab" data-bs-toggle="pill" data-bs-target="#pills-gaji" type="button"
                    role="tab" aria-controls="pills-notifications" aria-selected="false">
                    <i class="ti ti-bell me-2 fs-6"></i>
                    <span class="d-none d-md-block">Data Gaji</span>
                </button>
              </li>


              <li class="nav-item" role="presentation">
                <button
                  class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4"
                  id="pills-bills-tab" data-bs-toggle="pill" data-bs-target="#pills-str-sip" type="button" role="tab"
                  aria-controls="pills-bills" aria-selected="false">
                  <i class="ti ti-article me-2 fs-6"></i>
                  <span class="d-none d-md-block">SIP/STR</span>
                </button>
              </li>


              <li class="nav-item" role="presentation">
                <button
                  class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4"
                  id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-cuti" type="button"
                  role="tab" aria-controls="pills-security" aria-selected="false">
                  <i class="ti ti-lock me-2 fs-6"></i>
                  <span class="d-none d-md-block">Data Cuti</span>
                </button>
              </li>
            

              <li class="nav-item" role="presentation">
                <button
                  class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4"
                  id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-pelatihan" type="button"
                  role="tab" aria-controls="pills-security" aria-selected="false">
                  <i class="ti ti-lock me-2 fs-6"></i>
                  <span class="d-none d-md-block">Pelatihan</span>
                </button>
              </li>
              

              <li class="nav-item" role="presentation">
                <button
                  class="nav-link position-relative rounded-0 d-flex align-items-center justify-content-center bg-transparent fs-3 py-4"
                  id="pills-security-tab" data-bs-toggle="pill" data-bs-target="#pills-renkin" type="button"
                  role="tab" aria-controls="pills-security" aria-selected="false">
                  <i class="ti ti-lock me-2 fs-6"></i>
                  <span class="d-none d-md-block">Renkin</span>
                </button>
              </li>
              



            </ul>


            <div class="card-body">
              <div class="tab-content" id="pills-tabContent">
                <div class="tab-pane fade show active" id="pills-account" role="tabpanel"
                  aria-labelledby="pills-account-tab" tabindex="0">
                  <div class="row">
                    <div class="col-lg-6 d-flex align-items-stretch">
                      <div class="card w-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                          <h5 class="card-title fw-semibold"><?php echo $pegawai[0]->nama;?></h5>
                          <p class="card-subtitle mb-4">Change your profile picture from here</p>
                          <div class="text-center">
                            <img src="<?php echo  base_url();?>uploads/photo_profile/<?php echo $photo;?>" alt="" class="img-fluid rounded-circle"
                              width="120" height="120">
                            <div class="d-flex align-items-center justify-content-center my-4 gap-3">
                              <!-- <button class="btn btn-primary">Upload</button>
                              <button class="btn btn-outline-danger">Reset</button> -->
                              Join Date : 
                            </div>
                            <!-- <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p> -->
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-6 d-flex align-items-stretch">
                      <div class="card w-100 position-relative overflow-hidden">
                        <div class="card-body p-4">
                          <h5 class="card-title fw-semibold">Change Password</h5>
                          <p class="card-subtitle mb-4">To change your password please confirm here</p>
                          <form>
                            <div class="mb-4">
                              <label for="exampleInputPassword1" class="form-label fw-semibold">Current Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword1"
                                value="12345678910">
                            </div>
                            <div class="mb-4">
                              <label for="exampleInputPassword2" class="form-label fw-semibold">New Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword2"
                                value="12345678910">
                            </div>
                            <div class="">
                              <label for="exampleInputPassword3" class="form-label fw-semibold">Confirm Password</label>
                              <input type="password" class="form-control" id="exampleInputPassword3"
                                value="12345678910">
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="card w-100 position-relative overflow-hidden mb-0">
                        <div class="card-body p-4">
                          <h5 class="card-title fw-semibold">Personal Details</h5>
                          <p class="card-subtitle mb-4">To change your personal detail , edit and save from here</p>
                          <form>
                            <div class="row">
                              <div class="col-lg-6">
                                <div class="mb-4">
                                  <label for="exampleInputtext" class="form-label fw-semibold">Your Name</label>
                                  <input type="text" class="form-control" id="exampleInputtext"
                                    placeholder="Mathew Anderson">
                                </div>
                                <div class="mb-4">
                                  <label class="form-label fw-semibold">Location</label>
                                  <select class="form-select" aria-label="Default select example">
                                    <option selected>United Kingdom</option>
                                    <option value="1">United States</option>
                                    <option value="2">United Kingdom</option>
                                    <option value="3">India</option>
                                    <option value="3">Russia</option>
                                  </select>
                                </div>
                                <div class="mb-4">
                                  <label for="exampleInputtext1" class="form-label fw-semibold">Email</label>
                                  <input type="email" class="form-control" id="exampleInputtext1"
                                    placeholder="info@modernize.com">
                                </div>
                              </div>
                              <div class="col-lg-6">
                                <div class="mb-4">
                                  <label for="exampleInputtext2" class="form-label fw-semibold">Store Name</label>
                                  <input type="text" class="form-control" id="exampleInputtext2"
                                    placeholder="Maxima Studio">
                                </div>
                                <div class="mb-4">
                                  <label class="form-label fw-semibold">Currency</label>
                                  <select class="form-select" aria-label="Default select example">
                                    <option selected>India (INR)</option>
                                    <option value="1">US Dollar ($)</option>
                                    <option value="2">United Kingdom (Pound)</option>
                                    <option value="3">India (INR)</option>
                                    <option value="3">Russia (Ruble)</option>
                                  </select>
                                </div>
                                <div class="mb-4">
                                  <label for="exampleInputtext3" class="form-label fw-semibold">Phone</label>
                                  <input type="text" class="form-control" id="exampleInputtext3"
                                    placeholder="+91 12345 65478">
                                </div>
                              </div>
                              <div class="col-12">
                                <div class="">
                                  <label for="exampleInputtext4" class="form-label fw-semibold">Address</label>
                                  <input type="text" class="form-control" id="exampleInputtext4"
                                    placeholder="814 Howard Street, 120065, India">
                                </div>
                              </div>
                              <div class="col-12">
                                <div class="d-flex align-items-center justify-content-end mt-4 gap-3">
                                  <button class="btn btn-primary">Save</button>
                                  <button class="btn bg-danger-subtle text-danger">Cancel</button>
                                </div>
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-gaji" role="tabpanel"
                  aria-labelledby="pills-notifications-tab" tabindex="0">
                  <div class="row ">
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-body p-4">
                          <h4 class="fw-semibold mb-3">Notification Preferences</h4>
                          <p>
                            Select the notificaitons ou would like to receive via email. Please note that you cannot opt
                            out of receving service
                            messages, such as payment, security or legal notifications.
                          </p>
                          <form class="mb-7">
                            <label for="exampleInputtext5" class="form-label fw-semibold">Email Address*</label>
                            <input type="text" class="form-control" id="exampleInputtext5" placeholder="" required>
                            <p class="mb-0">Required for notificaitons.</p>
                          </form>
                       
                        </div>
                      </div>
                    </div>
               
                    <div class="col-12">
                      <div class="d-flex align-items-center justify-content-end gap-3">
                        <button class="btn btn-primary">Save</button>
                        <button class="btn bg-danger-subtle text-danger">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-str-sip" role="tabpanel" aria-labelledby="pills-bills-tab"
                  tabindex="0">
                  <div class="row">
                   
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-body p-4">
                          <h4 class="fw-semibold mb-3">Current Plan : <span class="text-success">Executive</span></h4>
                          <p>Thanks for being a premium member and supporting our development.</p>
                          <div class="d-flex align-items-center justify-content-between mt-7 mb-3">
                            <div class="d-flex align-items-center gap-3">
                              <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-package text-dark d-block fs-7" width="22" height="22"></i>
                              </div>
                              <div>
                                <p class="mb-0">Current Plan</p>
                                <h5 class="fs-4 fw-semibold">750.000 Monthly Visits</h5>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                              href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top"
                              data-bs-title="Add">
                              <i class="ti ti-circle-plus"></i>
                            </a>
                          </div>
                          <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-primary">Change Plan</button>
                            <button class="btn btn-outline-danger">Reset Plan</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-12">
                      <div class="card">
                        <div class="card-body p-4">
                          <h4 class="fw-semibold mb-3">Payment Method</h4>
                          <p>On 26 December, 2023</p>
                          <div class="d-flex align-items-center justify-content-between mt-7">
                            <div class="d-flex align-items-center gap-3">
                              <div class="text-bg-light rounded-1 p-6 d-flex align-items-center justify-content-center">
                                <i class="ti ti-credit-card text-dark d-block fs-7" width="22" height="22"></i>
                              </div>
                              <div>
                                <h5 class="fs-4 fw-semibold">Visa</h5>
                                <p class="mb-0 text-dark">*****2102</p>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                              href="javascript:void(0)" data-bs-toggle="tooltip" data-bs-placement="top"
                              data-bs-title="Edit">
                              <i class="ti ti-pencil-minus"></i>
                            </a>
                          </div>
                          <p class="my-2">If you updated your payment method, it will only be dislpayed here after your
                            next billing cycle.</p>
                          <div class="d-flex align-items-center gap-3">
                            <button class="btn btn-outline-danger">Cancel Subscription</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex align-items-center justify-content-end gap-3">
                        <button class="btn btn-primary">Save</button>
                        <button class="btn bg-danger-subtle text-danger">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-cuti" role="tabpanel" aria-labelledby="pills-security-tab"
                  tabindex="0">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="card">
                        <div class="card-body p-4">
                          <h4 class="fw-semibold mb-3">Two-factor Authentication</h4>
                          <div class="d-flex align-items-center justify-content-between pb-7">
                            <p class="mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis sapiente
                              sunt earum officiis laboriosam ut.</p>
                            <button class="btn btn-primary">Enable</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">Authentication App</h5>
                              <p class="mb-0">Google auth app</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">Another e-mail</h5>
                              <p class="mb-0">E-mail to send verification link</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">SMS Recovery</h5>
                              <p class="mb-0">Your phone number or something</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="card">
                        <div class="card-body p-4">
                          <div
                            class="text-bg-light rounded-1 p-6 d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="ti ti-device-laptop text-primary d-block fs-7" width="22" height="22"></i>
                          </div>
                          <h5 class="fs-5 fw-semibold mb-0">Devices</h5>
                          <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit Rem.</p>
                          <button class="btn btn-primary mb-4">Sign out from all devices</button>
                          <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                              <i class="ti ti-device-mobile text-dark d-block fs-7" width="26" height="26"></i>
                              <div>
                                <h5 class="fs-4 fw-semibold mb-0">iPhone 14</h5>
                                <p class="mb-0">London UK, Oct 23 at 1:15 AM</p>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                              href="javascript:void(0)">
                              <i class="ti ti-dots-vertical"></i>
                            </a>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3">
                            <div class="d-flex align-items-center gap-3">
                              <i class="ti ti-device-laptop text-dark d-block fs-7" width="26" height="26"></i>
                              <div>
                                <h5 class="fs-4 fw-semibold mb-0">Macbook Air</h5>
                                <p class="mb-0">Gujarat India, Oct 24 at 3:15 AM</p>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                              href="javascript:void(0)">
                              <i class="ti ti-dots-vertical"></i>
                            </a>
                          </div>
                          <button class="btn bg-primary-subtle text-primary w-100 py-1">Need Help ?</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex align-items-center justify-content-end gap-3">
                        <button class="btn btn-primary">Save</button>
                        <button class="btn bg-danger-subtle text-danger">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-pelatihan" role="tabpanel" aria-labelledby="pills-security-tab"
                  tabindex="0">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="card">
                        <div class="card-body p-4">
                          <h4 class="fw-semibold mb-3">Two-factor Authentication</h4>
                          <div class="d-flex align-items-center justify-content-between pb-7">
                            <p class="mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis sapiente
                              sunt earum officiis laboriosam ut.</p>
                            <button class="btn btn-primary">Enable</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">Authentication App</h5>
                              <p class="mb-0">Google auth app</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">Another e-mail</h5>
                              <p class="mb-0">E-mail to send verification link</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">SMS Recovery</h5>
                              <p class="mb-0">Your phone number or something</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="card">
                        <div class="card-body p-4">
                          <div
                            class="text-bg-light rounded-1 p-6 d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="ti ti-device-laptop text-primary d-block fs-7" width="22" height="22"></i>
                          </div>
                          <h5 class="fs-5 fw-semibold mb-0">Devices</h5>
                          <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit Rem.</p>
                          <button class="btn btn-primary mb-4">Sign out from all devices</button>
                          <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                              <i class="ti ti-device-mobile text-dark d-block fs-7" width="26" height="26"></i>
                              <div>
                                <h5 class="fs-4 fw-semibold mb-0">iPhone 14</h5>
                                <p class="mb-0">London UK, Oct 23 at 1:15 AM</p>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                              href="javascript:void(0)">
                              <i class="ti ti-dots-vertical"></i>
                            </a>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3">
                            <div class="d-flex align-items-center gap-3">
                              <i class="ti ti-device-laptop text-dark d-block fs-7" width="26" height="26"></i>
                              <div>
                                <h5 class="fs-4 fw-semibold mb-0">Macbook Air</h5>
                                <p class="mb-0">Gujarat India, Oct 24 at 3:15 AM</p>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                              href="javascript:void(0)">
                              <i class="ti ti-dots-vertical"></i>
                            </a>
                          </div>
                          <button class="btn bg-primary-subtle text-primary w-100 py-1">Need Help ?</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex align-items-center justify-content-end gap-3">
                        <button class="btn btn-primary">Save</button>
                        <button class="btn bg-danger-subtle text-danger">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-renkin" role="tabpanel" aria-labelledby="pills-security-tab"
                  tabindex="0">
                  <div class="row">
                    <div class="col-lg-8">
                      <div class="card">
                        <div class="card-body p-4">
                          <h4 class="fw-semibold mb-3">Two-factor Authentication</h4>
                          <div class="d-flex align-items-center justify-content-between pb-7">
                            <p class="mb-0">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Corporis sapiente
                              sunt earum officiis laboriosam ut.</p>
                            <button class="btn btn-primary">Enable</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">Authentication App</h5>
                              <p class="mb-0">Google auth app</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">Another e-mail</h5>
                              <p class="mb-0">E-mail to send verification link</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3 border-top">
                            <div>
                              <h5 class="fs-4 fw-semibold mb-0">SMS Recovery</h5>
                              <p class="mb-0">Your phone number or something</p>
                            </div>
                            <button class="btn bg-primary-subtle text-primary">Setup</button>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-lg-4">
                      <div class="card">
                        <div class="card-body p-4">
                          <div
                            class="text-bg-light rounded-1 p-6 d-inline-flex align-items-center justify-content-center mb-3">
                            <i class="ti ti-device-laptop text-primary d-block fs-7" width="22" height="22"></i>
                          </div>
                          <h5 class="fs-5 fw-semibold mb-0">Devices</h5>
                          <p class="mb-3">Lorem ipsum dolor sit amet consectetur adipisicing elit Rem.</p>
                          <button class="btn btn-primary mb-4">Sign out from all devices</button>
                          <div class="d-flex align-items-center justify-content-between py-3 border-bottom">
                            <div class="d-flex align-items-center gap-3">
                              <i class="ti ti-device-mobile text-dark d-block fs-7" width="26" height="26"></i>
                              <div>
                                <h5 class="fs-4 fw-semibold mb-0">iPhone 14</h5>
                                <p class="mb-0">London UK, Oct 23 at 1:15 AM</p>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                              href="javascript:void(0)">
                              <i class="ti ti-dots-vertical"></i>
                            </a>
                          </div>
                          <div class="d-flex align-items-center justify-content-between py-3">
                            <div class="d-flex align-items-center gap-3">
                              <i class="ti ti-device-laptop text-dark d-block fs-7" width="26" height="26"></i>
                              <div>
                                <h5 class="fs-4 fw-semibold mb-0">Macbook Air</h5>
                                <p class="mb-0">Gujarat India, Oct 24 at 3:15 AM</p>
                              </div>
                            </div>
                            <a class="text-dark fs-6 d-flex align-items-center justify-content-center bg-transparent p-2 fs-4 rounded-circle"
                              href="javascript:void(0)">
                              <i class="ti ti-dots-vertical"></i>
                            </a>
                          </div>
                          <button class="btn bg-primary-subtle text-primary w-100 py-1">Need Help ?</button>
                        </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex align-items-center justify-content-end gap-3">
                        <button class="btn btn-primary">Save</button>
                        <button class="btn bg-danger-subtle text-danger">Cancel</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>


         </div>

            <div class="py-6 px-6 text-center">
              <p class="mb-0 fs-4">Design and Developed by
                <a href="#" target="_blank" class="pe-1 text-primary text-decoration-underline">DhifaWebStudio</a> </p>
            </div>


      </div>
    </div>
  </div>
  <script src="<?php echo LIBS_JS_PATH;?>jquery/dist/jquery.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH;?>bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>sidebarmenu.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>app.min.js"></script>
  <script src="<?php echo LIBS_JS_PATH;?>simplebar/dist/simplebar.js"></script>
  <script src="<?php echo NEW_JS_PATH;?>dashboard.js"></script>
  
  </body>
</html>