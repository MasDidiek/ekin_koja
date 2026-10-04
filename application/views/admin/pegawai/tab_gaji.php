<?php


$tgl_masuk = $pegawai[0]->tgl_masuk;
$nip = $pegawai[0]->nip;
$nama_pegawai = $pegawai[0]->nama;
$photo = $this->Pegawai_model->getPhotoPegawai($nip);

if ($photo == '') {
  $photo = 'avatar.png';
}


$arrayStatusPajak = array('TK', 'K0', 'K1', 'K2');
$array_group = arrayUsergroup();

?>

<div class="row">
  <div class="col-lg-4 d-flex align-items-stretch">
    <div class="card w-100 position-relative overflow-hidden">
      <div class="card-body p-4">

        <div class="text-center">

          <h5 class="card-title fw-semibold"><?php echo $pegawai[0]->nama; ?></h5>
          <p class="card-subtitle mb-4"><?php echo $pegawai[0]->nip; ?></p>


          <img src="<?php echo  base_url(); ?>uploads/photo_profile/<?php echo $photo; ?>" alt="" class=" rounded-circle" width="180" height="180">
          <div class="d-flex align-items-center justify-content-center my-4 gap-3">
            <!-- <button class="btn btn-primary">Upload</button>
              <button class="btn btn-outline-danger">Reset</button> -->
            Join Date : <span class="text-primary"> <?php echo format_full($tgl_masuk); ?></span>
          </div>
          <!-- <p class="mb-0">Allowed JPG, GIF or PNG. Max size of 800K</p> -->
        </div>
      </div>
    </div>
  </div>

  <?php


  $gaji_pokok = $data_gaji[0]->gaji_pokok;
  $pengkalian = $data_gaji[0]->pengkalian;
  $pph21 = $data_gaji[0]->pph21;
  $bpjs_kes = $data_gaji[0]->bpjs_kes;
  $bpjs_tk = $data_gaji[0]->bpjs_tk;
  $ptkp = $data_gaji[0]->ptkp;

  $tkd = $gaji_pokok * $pengkalian;
  ?>


  <div class="col-lg-8 d-flex align-items-stretch">
    <div class="card w-100 position-relative overflow-hidden">
      <div class="card-body p-4">
        <form method="post" action="<?php echo base_url(); ?>admin/pegawai/update_data_gaji/<?php echo $pegawai[0]->id_pegawai; ?>">
          <h5 class="card-title fw-semibold">Edit Data Gaji </h5><br>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-4">
                <label for="exampleInputtext" class="form-label fw-semibold">Gaji Pokok</label>
                <input type="text" name="gaji_pokok" class="form-control  text-end" value="<?php echo $gaji_pokok; ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-4">
                <label for="exampleInputtext" class="form-label fw-semibold">Pengkalian</label>
                <input type="text" name="pengkalian" class="form-control  text-end" value="<?php echo $pengkalian; ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-4">
                <label for="exampleInputtext" class="form-label fw-semibold">Jumlah TKD</label>
                <input type="text" name="tkd" class="form-control  text-end" value="<?php echo $tkd; ?>">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-4">
                <label for="exampleInputtext" class="form-label fw-semibold">PPH21</label>
                <input type="text" name="pph21" class="form-control  text-end" value="<?php echo $pph21; ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-4">
                <label for="exampleInputtext" class="form-label fw-semibold">BPJS Kesehatan</label>
                <input type="text" name="bpjs_kes" class="form-control  text-end" value="<?php echo $bpjs_kes; ?>">
              </div>
            </div>
            <div class="col-md-4">
              <div class="mb-4">
                <label for="exampleInputtext" class="form-label fw-semibold">BPJS TK</label>
                <input type="text" name="bpjs_tk" class="form-control text-end" value="<?php echo $bpjs_tk; ?>">
              </div>

            </div>
          </div>

          <div class="row">
            <div class="col-md-4">
              <div class="mb-4">
                <label for="exampleInputtext" class="form-label fw-semibold">PTKP</label>
                <input type="text" name="ptkp" class="form-control  text-end" value="<?php echo $ptkp; ?>">
              </div>

            </div>
          </div>

          <button type="submit" class="btn btn-primary float-end">Simpan Perubahan</button>



      </div>

      </form>
    </div>
  </div>
</div>