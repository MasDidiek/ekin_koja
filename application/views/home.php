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
            /* Overlay (background gelap) */
      .modal {
        display: none; /* default hidden */
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
      }

      /* Isi modal */
      .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 8px;
        width: 400px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
        animation: fadeIn .3s ease;
      }

      /* Tombol close (x) */
      .close {
        float: right;
        font-size: 22px;
        font-weight: bold;
        cursor: pointer;
      }
      .close:hover {
        color: red;
      }

      /* Animasi masuk */
      @keyframes fadeIn {
        from { transform: translateY(-20px); opacity: 0; }
        to   { transform: translateY(0); opacity: 1; }
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
        <a href="<?php echo base_url('admin/login'); ?>" class="btn">LOGIN ADMIN</a>
      </div>
    </nav>

    <header id="home">
      <div class="header__container">
        <div class="header__content">
          <p>SIPUSPA</p>
          <div style="font-size:40px; margin-bottom:20px">SkrIning Kesehatan Pengemudi BUS PuskesmAs </div>
          <div class="header__btns">
            <button class="btn"  id="openModalBtn">Registrasi</button>
            <a href="#">
              <span><i class="ri-play-circle-fill"></i></span>
            </a>
          </div>
        </div>
        <div class="header__image">
          <img src="<?php echo base_url();?>assets/img/bus.png" alt="header" />
        </div>
      </div>
    </header>


<!-- Modal -->
<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h2>Registrasi</h2>

    <br>

    <!-- Tempat alert pesan -->
    <div id="formAlert"></div>

        <form action="<?php echo base_url();?>home/pre_registrasi" method="post" id="registrasi">
            <div class="input-box">
              <span class="details">Nama Lengkap <span class="text-danger">*</span></span>
              <input type="text" placeholder="ketik nama lengkap anda" name="nama_lengkap" required class="form-control"  >
              <span class="invalid-feedback"  id="err_nama_lengkap"><?php echo form_error('nama_lengkap'); ?> </span>
            </div>
            <div class="input-box">
              <span class="details">NIK / NO KTP <span class="text-danger">*</span></span>
              <input type="text" name="no_ktp" placeholder="ketik no KTP anda" required onkeypress="return onlyNumberKey(event)"  class="charcounter-control form-control"   maxlength='16'  warnlength='14' >
              <span class="invalid-feedback"  id="err_no_ktp"><?php echo form_error('no_ktp'); ?> </span>
            </div>
            <div class="input-box">
              <span class="details">Tanggal Lahir  <span class="text-danger">*</span></span>
              <input type="text" placeholder="tgl/bln/thn" name="tgl_lahir" required class="js-date form-control" maxlength="10" >
              <span class="invalid-feedback"  id="err_tgl_lahir"><?php echo form_error('tgl_lahir'); ?> </span>
            </div>

            <br>
            <center>
               <button class="btn" type="submit"  >Selanjutnya</button>
             </center>
          </form>
  </div>
</div>



    <!-- <section class="section__container journey__container" id="tour">

      <div class="journey__grid">
        <div class="journey__card">
          <div class="journey__card__bg">
            <span><i class="ri-bookmark-3-line"></i></span>
            <h4>Seamless Booking Process</h4>
          </div>
          <div class="journey__card__content">
            <span><i class="ri-bookmark-3-line"></i></span>
            <h4>Seat Booking, one Click Away</h4>
            <p>
              From booking tickets to tracking your bus in real-time, everything
              is just a click away. No more long queues or last-minute confusion
              — plan, book, and board with complete ease. Your journey,
              simplified.
            </p>
          </div>
        </div>

        <div class="journey__card">
          <div class="journey__card__bg">
            <span><i class="ri-landscape-fill"></i></span>
            <h4>Tailored Itineraries</h4>
          </div>
          <div class="journey__card__content">
            <span><i class="ri-landscape-fill"></i></span>
            <h4>Customized Plans Just for You</h4>
            <p>
              Everyone travels differently — that’s why we create plans just for
              you. From preferred timings to budget-friendly options and seat
              choices, enjoy a trip designed around your lifestyle.
            </p>
          </div>
        </div>

        <div class="journey__card">
          <div class="journey__card__bg">
            <span><i class="ri-map-2-line"></i></span>
            <h4>Expert Local Insights</h4>
          </div>
          <div class="journey__card__content">
            <span><i class="ri-map-2-line"></i></span>
            <h4>Insider Tips and Recommendations</h4>
            <p>
              From the best boarding points to local travel hacks, our insights
              are powered by real people who know the roads. It’s local
              knowledge, delivered straight to your screen.
            </p>
          </div>
        </div>
      </div>
    </section> -->



<?php //$this->load->view('footer'); ?>
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
