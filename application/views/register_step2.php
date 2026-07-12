<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
      rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css"
      rel="stylesheet" />

    <link rel="stylesheet" href="<?php echo base_url();?>assets/style.css" />

    <style>
    .btn-register{
       width:200px;
       padding:10px;
       text-align:center;
       background:#2887ff;
       color:#FFF;
       border-radius:5px;
       cursor:pointer;
       margin:50px auto;
       border:1px solid #2887ff;
    }
    .btn-register:hover{
       background:#4c7acf;
    }
      .form-control{
        width: 100%;
        padding: 10px;
        border: 1px solid #DDD;
        margin-top: 2px;
        margin-bottom: 10px;
        border-radius: 3px;
      }

      .text-danger{
        color: #F00;
      }

      .alert-danger{
        background-color: #ffe7e8;
        color: #900;
        padding: 10px;
        border-radius: 3px;
        margin-bottom: 10px;
      }

    </style>
    <title>Sipuspa</title>
  </head>
  <body>
    <nav >
      <div class="nav__header">
        <div class="nav__logo">
          <a href="<?php echo base_url(); ?>" class="logo">Sipuspa </a>
        </div>
        <div class="nav__menu__btn" id="menu-btn">
          <i class="ri-menu-line"></i>
        </div>
      </div>
      <ul class="nav__links" id="nav-links">
        <li><a href="<?php echo base_url(); ?>">HOME</a></li>
        <li><a href="#about">TENTANG KAMI</a></li>
        <li><a href="#">LOGIN ADMIN</a></li>
      </ul>
      <div class="nav__btns">
        <button class="btn">LOGIN ADMIN</button>
      </div>
    </nav>



    <!-- Tempat alert pesan -->
    <div id="formAlert"></div>

   <?php
  	    $nama = $this->session->flashdata('nama_lengkap');
		$no_ktp = $this->session->flashdata('no_ktp');
		$tgl_lahir = $this->session->flashdata('tgl_lahir');


   ?>



    <section class="section__container journey__container" id="tour">
            <h3>Registrasi</h3>

       <form action="<?php echo base_url();?>home/submit" method="post" id="registrasi">

            <div class="journey__grid">
                <div class="">
                    <div class="input-box">
                        <span class="details">Nama Lengkap <span class="text-danger">*</span></span>
                        <input type="text" placeholder="ketik nama lengkap anda" name="nama_lengkap" required class="form-control" value="<?php echo $nama; ?>" >
                        <span class="invalid-feedback"  id="err_nama_lengkap"><?php echo form_error('nama_lengkap'); ?> </span>
                    </div>
                    <div class="input-box">
                        <span class="details">NIK / NO KTP <span class="text-danger">*</span></span>
                        <input type="text" name="no_ktp" placeholder="ketik no KTP anda" required onkeypress="return onlyNumberKey(event)" value="<?php echo $no_ktp; ?>" class="charcounter-control form-control"   maxlength='16'  warnlength='14' >
                        <span class="invalid-feedback"  id="err_no_ktp"><?php echo form_error('no_ktp'); ?> </span>
                    </div>
                    <div class="input-box">
                        <span class="details">Tanggal Lahir  <span class="text-danger">*</span></span>
                        <input type="text" placeholder="tgl/bln/thn" name="tgl_lahir" required class="js-date form-control" maxlength="10" value="<?php echo $tgl_lahir; ?>">
                        <span class="invalid-feedback"  id="err_tgl_lahir"><?php echo form_error('tgl_lahir'); ?> </span>
                    </div>

                    <div class="input-box">
                            <span class="details">Jenis Kelamin<span class="text-danger">*</span></span>
                            <select name="gender" class="form-control <?= form_error('gender') ? 'is-invalid' : '' ?> ">
                                        <option value="">-Pilih jenis kelamin-</option>
                                        <option value="L" <?php echo  set_select('gender', 'L'); ?>>Laki-laki</option>
                                        <option value="P" <?php echo  set_select('gender', 'P'); ?>>Perempuan</option>
                                        <span class="error-msg"><?php echo form_error('gender'); ?> </span>


                                </select>
                            <span class="invalid-feedback"  id="err_nama_lengkap"><?php echo form_error('gender'); ?> </span>
                    </div>

                </div>
                <div class="">

                    <div class="input-box">
                        <span class="details">No Handphone<span class="text-danger">*</span></span>
                        <input type="text" name="no_hp"  onkeypress="return onlyNumberKey(event)" required placeholder="ketik no handphone" class="form-control <?= form_error('no_hp') ? 'is-invalid' : '' ?>"   value="<?php echo set_value('no_hp'); ?>" >
                        <span class="error-msg"><?php echo form_error('no_hp'); ?> </span>
                    </div>
                    <div class="input-box">
                            <span class="details">Status Pernikahan  <span class="text-danger">*</span></span>
                            <select name="status_pernikahan" class="form-control <?= form_error('status_pernikahan') ? 'is-invalid' : '' ?> " required>
                                        <option value="">-Pilih Status-</option>
                                        <option value="BM" <?php echo  set_select('status_pernikahan', 'BM'); ?>>Belum Menikah</option>
                                        <option value="M" <?php echo  set_select('status_pernikahan', 'M'); ?>>Menikah</option>
                                        <option value="D" <?php echo  set_select('status_pernikahan', 'D'); ?>>Duda</option>
                                        <option value="J" <?php echo  set_select('status_pernikahan', 'J'); ?>>Janda</option>

                                </select>
                                <span class="error-msg"><?php echo form_error('status_pernikahan'); ?> </span>
                    </div>

                    <div class="input-box">
                        <span class="details">Pendidikan Terakhir <span class="text-danger">*</span></span>
                        <select name="pendidikan" class="form-control <?= form_error('pendidikan') ? 'is-invalid' : '' ?> " required>
                                    <option value="">-Pendidikan Terakhir-</option>
                                    <option value="Perguruan Tinggi" <?php echo  set_select('pendidikan', 'Perguruan Tinggi'); ?>>Perguruan Tinggi</option>
                                    <option value="SMA" <?php echo  set_select('pendidikan', 'SMA'); ?>>SMA</option>
                                    <option value="SMP" <?php echo  set_select('pendidikan', 'SMP'); ?>>SMP</option>
                                    <option value="SD" <?php echo  set_select('pendidikan', 'SD'); ?>>SD</option>
                                    <option value="Tidak Sekolah" <?php echo  set_select('pendidikan', 'Tidak Sekolah'); ?>>Tidak Sekolah</option>
                            </select>
                    </div>
                    <div class="input-box">
                        <span class="details">Alamat Rumah <span class="text-danger">*</span></span>
                        <textarea name="alamat" class="alamat form-control "></textarea>
                    </div>


                      <button type="submit" class="btn-register">Submit</button>
                </div>

                <div class="">
                    <div class="input-box">
                        <span class="details">Pekerjaan <span class="text-danger">*</span></span>
                        <select name="pekerjaan" id="job" class="form-control <?= form_error('pekerjaan') ? 'is-invalid' : '' ?> ">
                                <option value="driver" <?php echo  set_select('pekerjaan', 'driver'); ?>>Driver</option>
                                <option value="lainnya" <?php echo  set_select('pekerjaan', 'lainnya'); ?>>Lainnya</option>
                            </select>

                            <div class="col-md-6 mb-3" style="display: none;"  id="pekerjaan_lain">
                                <span class="details">Nama Pekerjaan</span>
                                <input type="text" name="pekerjaan_lainnya"  placeholder="tuliskan nama pekerjaan">
                            </div>
                    </div>
                        <div class="input-box">
                            <span class="details">Status Supir <span class="text-danger">*</span></span>

                            <select name="status_supir" id="status_supir" class="form-control <?= form_error('status_supir') ? 'is-invalid' : '' ?> ">
                                <option value="Utama" <?php echo  set_select('status_supir', 'Utama'); ?>>Utama</option>
                                <option value="Cadangan" <?php echo  set_select('status_supir', 'Cadangan'); ?>>Cadangan</option>
                            </select>

                        </div>


                    <div class="input-box">
                        <span class="details">Nama PO   <span class="text-danger">*</span></span>
                        <input type="text" name="nama_po" placeholder="ketik nama perusahaan" required   class="form-control <?= form_error('nama_po') ? 'is-invalid' : '' ?>"   value="<?php echo set_value('nama_po'); ?>" >
                        <span class="error-msg"><?php echo form_error('nama_po'); ?> </span>
                    </div>

                    <div class="input-box">
                    <span class="details">Jurusan <span class="text-danger">*</span></span>
                    <input type="text" name="terminal_jurusan" placeholder="cth: terminal Tirtonadi, Terminal Purwokerto " class="form-control <?= form_error('terminal_jurusan') ? 'is-invalid' : '' ?>"   value="<?php echo set_value('terminal_jurusan'); ?>" >
                    <span class="invalid-feedback"><?php echo form_error('terminal_jurusan'); ?> </span>
                  </div>




                </div>
            </div>


        </form>
    </section>



    <?php $this->load->view('footer'); ?>
    <script src="https://unpkg.com/scrollreveal"></script>
    <script src="<?php echo base_url();?>assets/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
<!-- jQuery CDN -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
                // Ambil elemen
          const modal = document.getElementById("myModal");
          const openBtn = document.getElementById("openModalBtn");
          const closeBtn = document.querySelector(".close");

          // Buka modal
          openBtn.onclick = () => {
            modal.style.display = "block";
          }

          // Tutup modal lewat tombol X
          closeBtn.onclick = () => {
            modal.style.display = "none";
          }

          // Tutup modal kalau klik di luar modal-content
          window.onclick = (e) => {
            if (e.target === modal) {
              modal.style.display = "none";
            }
          }

          // Tutup modal dengan tombol ESC
          document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
              modal.style.display = "none";
            }
          });

          function onlyNumberKey(evt) {

                      // Only ASCII character in that range allowed
                      var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                      if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                          return false;
                      return true;
                  }


                var input = document.querySelectorAll('.js-date')[0];

                var dateInputMask = function dateInputMask(elm) {
                    elm.addEventListener('keypress', function(e) {
                    if(e.keyCode < 47 || e.keyCode > 57) {
                        e.preventDefault();
                    }

                    var len = elm.value.length;

                    // If we're at a particular place, let the user type the slash
                    // i.e., 12/12/1212
                    if(len !== 1 || len !== 3) {
                        if(e.keyCode == 47) {
                        e.preventDefault();
                        }
                    }

                    // If they don't add the slash, do it for them...
                    if(len === 2) {
                        elm.value += '/';
                    }

                    // If they don't add the slash, do it for them...
                    if(len === 5) {
                        elm.value += '/';
                    }
                    });
                };

                dateInputMask(input);


                $(document).ready(function() {
                  $("#registrasi").on("submit", function(e) {
                    e.preventDefault(); // cegah reload

                    $.ajax({
                      url: $(this).attr("action"),
                      type: "POST",
                      data: $(this).serialize(),
                      dataType: "json",
                      success: function(res) {
                        if (res.status === "success") {
                          // Jika berhasil → redirect atau tampil pesan sukses
                          $("#formAlert").html('<div class="alert alert-success">'+res.message+'</div>');
                          if (res.redirect) {
                            window.location.href = res.redirect;
                          }
                        } else if (res.status === "error") {
                          // Tampilkan pesan error
                          $("#formAlert").html('<div class="alert alert-danger">'+res.message+'</div>');
                        }
                      },
                      error: function(xhr) {
                        $("#formAlert").html('<div class="alert alert-danger">Terjadi kesalahan. Coba lagi.</div>');
                      }
                    });
                  });
                });



    </script>
  </body>
</html>
