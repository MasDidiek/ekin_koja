<!DOCTYPE html>
<!-- Created By CodingLab - www.codinglabweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    -<title> Sipuspa - SkrIning Kesehatan Pengemudi BUS PuskesmAs </title>-
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/register.css">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    form .user-details .input-box{
  margin-bottom: 15px;
  width: calc(100% / 2 - 20px);
}
form .input-box span.details{
  display: block;
  font-weight: 500;
  margin-bottom: 5px;
}
.user-details .input-box input{
  height: 45px;
  width: 100%;
  outline: none;
  font-size: 16px;
  border-radius: 2px;
  padding-left: 15px;
  border: 1px solid #ccc;
  transition: all 0.3s ease;
}

.user-details .input-box select{
  height: 45px;
  width: 100%;
  outline: none;
  font-size: 16px;
  border-radius: 2px;
  padding-left: 15px;
  border: 1px solid #ccc;
  transition: all 0.3s ease;
  background-color: #fff;
}

.invalid-feedback{
  color:#F00;
  font-size:14px;
}

.text-danger{
  color:#f00;
}
.is-invalid{
  border:1px solid #F00 !important;
}
.alamat{
  height: 60px;
  width: 100%;
  outline: none;
  font-size: 16px;
  border-radius: 5px;
  padding-left: 15px;
  border: 1px solid #ccc;
  transition: all 0.3s ease;
  background-color: #fff;
}
.alamat:focus, .alamat:valid{
  border-color: #69ce89;
}

.user-details .input-box select:focus,
.user-details .input-box select:valid{
  border-color: #69ce89;
}

.user-details .input-box input:focus,
.user-details .input-box input:valid{
  border-color: #69ce89;
}
 form .gender-details .gender-title{
  font-size: 16px;
  font-weight: 500;
 }
 form .category{
   display: flex;
   width: 80%;
   margin: 14px 0 ;
   justify-content: space-between;
 }
 form .category label{
   display: flex;
   align-items: center;
   cursor: pointer;
 }
 form .category label .dot{
  height: 18px;
  width: 18px;
  border-radius: 50%;
  margin-right: 10px;
  background: #d9d9d9;
  border: 5px solid transparent;
  transition: all 0.3s ease;
}
 #dot-1:checked ~ .category label .one,
 #dot-2:checked ~ .category label .two,
 #dot-3:checked ~ .category label .three{
   background: #9b59b6;
   border-color: #d9d9d9;
 }

 #status-1:checked ~ .category label .s_one,
 #status-2:checked ~ .category label .s_two,
 #status-3:checked ~ .category label .s_three,
 #status-4:checked ~ .category label .s_four{
   background: #9b59b6;
   border-color: #d9d9d9;
 }

 form input[type="radio"]{
   display: none;
 }
 form .button{
   height: 45px;
   margin: 35px 0
 }
 form .button input{
   height: 100%;
   width: 100%;
   border-radius: 5px;
   border: none;
   color: #fff;
   font-size: 18px;
   font-weight: 500;
   letter-spacing: 1px;
   cursor: pointer;
   transition: all 0.3s ease;
   background: linear-gradient(135deg, #71b7e6, #9b59b6);
 }
 form .button input:hover{
  /* transform: scale(0.99); */
  background: linear-gradient(-135deg, #71b7e6, #9b59b6);
  }
</style>
   </head>
<body>
  <div class="container">
    <div class="title">Registrasi Pengemudi</div>
    <div class="content">
      <form action="<?php echo base_url();?>home/submit" method="post">
        <div class="user-details">
          <div class="input-box">
            <span class="details">Nama Lengkap <span class="text-danger">*</span></span>
            <input type="text" placeholder="ketik nama lengkap anda" name="nama_lengkap" class="<?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>" value="<?php echo set_value('nama_lengkap'); ?>" >
            <span class="invalid-feedback"><?php echo form_error('nama_lengkap'); ?> </span>
          </div>
          <div class="input-box">
            <span class="details">NIK / NO KTP <span class="text-danger">*</span></span>
            <input type="text" name="no_ktp" placeholder="ketik no KTP anda"  onkeypress="return onlyNumberKey(event)"  class="charcounter-control <?= form_error('no_ktp') ? 'is-invalid' : '' ?>" value="<?php echo set_value('no_ktp'); ?>"   maxlength='16'  warnlength='14' >
            <span class="invalid-feedback"><?php echo form_error('no_ktp'); ?> </span>
          </div>
          <div class="input-box">
            <span class="details">Tanggal Lahir  <span class="text-danger">*</span></span>
            <input type="text" placeholder="tgl/bln/thn" name="tgl_lahir" class="js-date <?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>" maxlength="10" value="<?php echo set_value('tgl_lahir'); ?>">
            <span class="invalid-feedback"><?php echo form_error('tgl_lahir'); ?> </span>
          </div>
          <div class="input-box">
                <div class="gender-details">
                    <input type="radio" name="gender" value="L" checked id="dot-1">
                    <input type="radio" name="gender" value="P"  id="dot-2">
              
                    <span class="gender-title">Jenis Kelamin</span>
                    <div class="category">
                        <label for="dot-1">
                        <span class="dot one"></span>
                        <span class="gender">Laki-laki</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Perempuan</span>
                        </label>
                    
                    </div>

                </div>
          </div>
          <div class="input-box">
            <span class="details">No Handphone  <span class="text-danger">*</span></span>
            <input type="text" name="no_hp"  onkeypress="return onlyNumberKey(event)"  placeholder="ketik no handphone" class="<?= form_error('no_hp') ? 'is-invalid' : '' ?>"   value="<?php echo set_value('no_hp'); ?>" >
            <span class="invalid-feedback"><?php echo form_error('no_hp'); ?> </span>
          </div>
          <div class="input-box">
            <span class="details">Pekerjaan</span>
            <input type="text" name="pekerjaan" value="Driver" readonly required>
          </div>
          <div class="input-box">
            <span class="details">Pendidikan Terakhir <span class="text-danger">*</span></span>
            <select name="pendidikan" class="<?= form_error('pendidikan') ? 'is-invalid' : '' ?> ">
                    <option value="">-Pilih Pendidikan Terakhir-</option>
                    <option value="Perguruan Tinggi" <?php echo  set_select('pendidikan', 'Perguruan Tinggi'); ?>>Perguruan Tinggi</option>
                    <option value="SMA" <?php echo  set_select('pendidikan', 'SMA'); ?>>SMA</option>
                    <option value="SMP" <?php echo  set_select('pendidikan', 'SMP'); ?>>SMP</option>
                    <option value="SD" <?php echo  set_select('pendidikan', 'SD'); ?>>SD</option>
                    <option value="Tidak Sekolah" <?php echo  set_select('pendidikan', 'Tidak Sekolah'); ?>>Tidak Sekolah</option>
            </select>
          </div>

          <div class="input-box">
          <span class="details">Status Pernikahan <span class="text-danger">*</span></span>
            <select name="status_pernikahan" class="<?= form_error('status_pernikahan') ? 'is-invalid' : '' ?> ">
                        <option value="">-Pilih Status-</option>
                        <option value="BM" <?php echo  set_select('status_pernikahan', 'BM'); ?>>Belum Menikah</option>
                        <option value="M" <?php echo  set_select('status_pernikahan', 'M'); ?>>Menikah</option>
                        <option value="D" <?php echo  set_select('status_pernikahan', 'D'); ?>>Duda</option>
                        <option value="J" <?php echo  set_select('status_pernikahan', 'J'); ?>>Janda</option>
                        
                </select>
          </div>
          <div class="input-box">
            <span class="details">Alamat Rumah</span>
            <textarea name="alamat" class="alamat"></textarea>
          </div>

          <div class="input-box">

             <div class="gender-details">
                    <input type="radio" name="status_supir" value="Utama" checked id="status-1">
                    <input type="radio" name="status_supir" value="Cadangan"  id="status-2">
              
                    <span class="gender-title">Status Supir</span>
                    <div class="category">
                        <label for="status-1">
                        <span class="dot s_one"></span>
                        <span class="gender">Utama</span>
                        </label>
                        <label for="status-2">
                            <span class="dot s_two"></span>
                            <span class="gender">Cadangan</span>
                        </label>
                    
                    </div>

                </div>

          </div>

          <div class="input-box">
            <span class="details">Nama PO  <span class="text-danger">*</span></span>
            <input type="text" name="nama_po" placeholder="ketik nama perusahaan " class="<?= form_error('nama_po') ? 'is-invalid' : '' ?>"   value="<?php echo set_value('nama_po'); ?>" >
            <span class="invalid-feedback"><?php echo form_error('nama_po'); ?> </span>
          </div>
          <div class="input-box">
            <span class="details">Jurusan <span class="text-danger">*</span></span>
            <input type="text" name="terminal_jurusan" placeholder="cth: terminal Tirtonadi, Terminal Purwokerto " class="<?= form_error('terminal_jurusan') ? 'is-invalid' : '' ?>"   value="<?php echo set_value('nama_po'); ?>" >
            <span class="invalid-feedback"><?php echo form_error('terminal_jurusan'); ?> </span>
          </div>
        </div>
        
        <div class="button">
          <input type="submit" value="Register">
        </div>
      </form>
    </div>
  </div>

</body>

    <script>

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
    </script>
</html>
