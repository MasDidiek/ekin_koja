<!DOCTYPE html>
<!---Coding By CodingLab | www.codinglabweb.com--->
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <!--<title>Registration Form in HTML CSS</title>-->
    <!---Custom CSS File--->
    <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" />
  </head>
  <body>
    <section class="container">
    
                <a href="#" class="brand">  SIPUSPA  </a>
                <div class="caption"> <span>S</span>kr<span>I</span>ning 
                 Kesehatan <span>P</span>engemudi B<span>US P</span>uskesm<span>A</span>s
                </div>

      <header>Registrasi Pengemudi Bus</header>
      
      
       <form action="<?php echo base_url();?>home/submit" method="post" class="form">
        <div class="input-box">
          <label>Nama Lengkap <span class="text-danger">*</span></label>
          <input type="text" placeholder="ketik nama lengkap anda" name="nama_lengkap" class="<?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>" value="<?php echo set_value('nama_lengkap'); ?>" required />
           <span class="error-msg"> <?php echo form_error('nama_lengkap'); ?> </span>
        </div>

        <div class="input-box">
          <label>IK / NO KTP <span class="text-danger">*</span></label>
           <input type="text" name="no_ktp" placeholder="ketik no KTP anda"  onkeypress="return onlyNumberKey(event)"  class="charcounter-control <?= form_error('no_ktp') ? 'is-invalid' : '' ?>" value="<?php echo set_value('no_ktp'); ?>"   maxlength='16'  warnlength='14' >
         <span class="error-msg"><?php echo form_error('no_ktp'); ?> </span>
        </div>

        <div class="column">
          <div class="input-box">
            <label>No Handphone  <span class="text-danger">*</span</label>
              <input type="text" name="no_hp"  onkeypress="return onlyNumberKey(event)"  placeholder="ketik no handphone" class="<?= form_error('no_hp') ? 'is-invalid' : '' ?>"   value="<?php echo set_value('no_hp'); ?>" >
               <span class="error-msg"><?php echo form_error('no_hp'); ?> </span>
          </div>
          <div class="input-box">
            <label>Tanggal Lahir  <span class="text-danger">*</span></label>
            <input type="text" placeholder="tgl/bln/thn" name="tgl_lahir" class="js-date <?= form_error('nama_lengkap') ? 'is-invalid' : '' ?>" maxlength="10" value="<?php echo set_value('tgl_lahir'); ?>">
              <span class="error-msg"><?php echo form_error('tgl_lahir'); ?> </span>
          </div>
        </div>
        <div class="gender-box">
          <h3>Jenis Kelamin</h3>
          <div class="gender-option">
            <div class="Jenis_ke">
              <input type="radio" id="check-male" name="gender" value="L" checked />
              <label for="check-male">Laki-laki</label>
            </div>
            <div class="gender">
              <input type="radio" id="check-female" name="gender" value="P" />
              <label for="check-female">Perempuan</label>
            </div>
           
          </div>
        </div>
        
         <div class="column">
          <div class="input-box">
            <label>Status Pernikahan <span class="text-danger">*</span></label>
             <div class="select-box">
                <select name="status_pernikahan" class="<?= form_error('status_pernikahan') ? 'is-invalid' : '' ?> ">
                   <option value="">-Pilih Status-</option>
                    <option value="BM" <?php echo  set_select('status_pernikahan', 'BM'); ?>>Belum Menikah</option>
                    <option value="M" <?php echo  set_select('status_pernikahan', 'M'); ?>>Menikah</option>
                    <option value="D" <?php echo  set_select('status_pernikahan', 'D'); ?>>Duda</option>
                    <option value="J" <?php echo  set_select('status_pernikahan', 'J'); ?>>Janda</option>
                </select>
              </div>
          </div>
          <div class="input-box">
            <label>Pekerjaan <span class="text-danger">*</span></label>
             <div class="select-box">
             <select name="pekerjaan" id="job" class="<?= form_error('pekerjaan') ? 'is-invalid' : '' ?> ">
               <option value="driver" <?php echo  set_select('pekerjaan', 'driver'); ?>>Driver</option>
               <option value="lainnya" <?php echo  set_select('pekerjaan', 'lainnya'); ?>>Lainnya</option> 
            </select>
             </div>
          </div>
          
             
        </div>
        
          <div class="col-md-6 mb-3" id="pekerjaan_lain"> 
        <span class="details">Nama Pekerjaan</span>
        <input type="text" name="pekerjaan_lainnya"  placeholder="tuliskan nama pekerjaan">
        </div>
        <div class="input-box address">
          <label>Alamat</label>
          <input type="text" name="alamat" placeholder="Enter street address" required />
         
        </div>
        
          <div class="column">
          <div class="input-box">
            <label>Status Supir</label>
             <div class="select-box">
                  <select name="status_supir" class="<?= form_error('status_supir') ? 'is-invalid' : '' ?> ">
                    <option value="">-Pilih Status-</option>
                    <option value="Utama" <?php echo  set_select('status_supir', 'Utama'); ?>>Utama</option>
                    <option value="Cadangan" <?php echo  set_select('status_supir', 'Cadangan'); ?>>Cadangan</option>
                    
                    
                 </select>
             </div>
          </div>
          <div class="input-box">
            <label>Nama PO  <span class="text-danger">*</span></label>
            <input type="text" name="nama_po" placeholder="ketik nama perusahaan " class="<?= form_error('nama_po') ? 'is-invalid' : '' ?>"   value="<?php echo set_value('nama_po'); ?>" >
            <span class="error-msg"><?php echo form_error('nama_po'); ?> </span>
          </div>
          
             
        </div>
        <button type="submit">Registrasi</button>
      </form>
    </section>
  </body>
</html>