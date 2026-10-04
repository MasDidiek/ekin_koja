
<?php


$id_pegawai     = $pegawai[0]->id_pegawai;
$tgl_masuk      = $pegawai[0]->tgl_masuk;
$nip            = $pegawai[0]->nip;
$nama_pegawai   = $pegawai[0]->nama;
$tmt            = $pegawai[0]->tmt;
$id_pendidikan = $pegawai[0]->id_pendidikan;
$jns_jam_kerja  = $pegawai[0]->jns_jam_kerja;
$photo          = $this->Pegawai_model->getPhotoPegawai($nip);

if($photo==''){
    $photo = 'avatar.png';
}


$pendidikan = $this->Master_model->getNamaPendidikan($id_pendidikan);

$tahun = date('Y');
$today = date('Y-m-d');

$masa_kerja = hitungMasaKerja($tmt, $today);


$dataGajiPegawai    = $this->Pegawai_model->getDataGajiPegawai($nip, $tahun);


 if(!empty($dataGajiPegawai)){

    $gaji_pokok = $dataGajiPegawai[0]->gaji_pokok;
    $pengkalian = $dataGajiPegawai[0]->pengali;
    $tkd_pokok = $gaji_pokok*$pengkalian;
    $id_gaji   =  $dataGajiPegawai[0]->id;

}else{
    $gaji_pokok= 0;
    $pengkalian = 0;
    $tkd_pokok =  0;
    $id_gaji   = 0;
}




?>
<div class="row">
     <div class="col-md-7">
         <div class="card">
              <div class="card-body profile-user-box">
                 <div class="row">
                     <div class="col-4">
                         <div class="photo-profile">
                             <img src="<?php echo base_url().'uploads/photo_profile/'. $photo ;?>" alt="" >
                         </div>
                         <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#changePhotoModal">Change Photo</button>
                     </div>

                     <div class="col-8">
                         <div class="fw-bold fs-4 text-teal">
                             <?php echo $nip;?>
                         </div>

                          <div class="fw-bold fs-4 text-dark">
                                     <?php echo $nama_pegawai;?>
                         </div>

                          <p class="font-13 text-dark-50"> <?php echo $pegawai[0]->jabatan;?>- <?php echo $pegawai[0]->keterangan_jabatan;?></p>

                          <table class="table table-xs table-borderless">
                             <tr>
                                 <td class="text-dark">Tanggal Masuk</td>
                                 <td class="fw-bold"> <?php echo format_semi($tgl_masuk);?></td>
                             </tr>
                             <tr>
                                 <td class="text-dark">Masa Kerja</td>
                                 <td class="fw-bold"><?php echo $masa_kerja['years'].' Tahun '.$masa_kerja['months'].' bulan';?></td>
                             </tr>
                             <tr>
                                 <td class="text-dark">Status Pegawai</td>
                                 <td class="fw-bold">NON PNS</td>
                             </tr>
                          </table>

                     </div>
                 </div>

              </div>

         </div>
     </div>
     <div class="col-md-5">
          <div class="card">
             <div class="card-body">
                 <div class="fw-bold fs-5">DATA GAJI & TUNJANGAN</div> <br>
                 <table class="table table-xs table-borderless">
                     <tr>
                         <td class="text-info">Gaji Pokok</td>
                         <td class="fw-bold  text-end"> Rp. <?php echo  rupiah($gaji_pokok) ;?></td>
                     </tr>
                     <tr>
                         <td class="text-info">Pengali</td>
                         <td class="fw-bold  text-end"><?php echo $pengkalian;?> x</td>
                     </tr>
                     <tr>
                         <td class="text-info">TKD Pokok</td>
                         <td class="fw-bold  text-end"> Rp. <?php echo  rupiah($tkd_pokok) ;?></td>
                     </tr>
                 </table>

             </div>
         </div>
     </div>


 </div>


    <!-- Modal Form Input Keluarga -->
    <div class="modal fade" id="changePhotoModal" tabindex="-1" aria-labelledby="changePhotoModal" aria-hidden="true">
        <div class="modal-dialog">
         <div class="modal-content">
         <form id="formUploadDokumen" enctype="multipart/form-data" method="POST" action="<?= base_url('profile/upload_profile_picture') ?>">

            <div class="modal-header">
                <h5 class="modal-title">Ubah Photo Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
             <div class="modal-body">

                    <div class="mb-3">
                        <label for="file_dokumen" class="form-label">Pilih File (JPG/PNG)</label>
                        <input type="file" class="form-control" name="imageupload" id="file_dokumen" accept="jpg,.jpeg,.png" required>
                    </div>


                </div>
                <div class="modal-footer">
                    <div class="loader d-none text-success">Menyimpan...</div>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
