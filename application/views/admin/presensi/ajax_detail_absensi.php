<?php
            $arrayAbsen = array('DL-PENUH', 'DL-AWAL', 'DL-AKHIR', 'SAKIT', 'IZIN', 'ALPHA');
            $nama       = $detail_pegawai[0]->nama;

            $id_pegawai = $detail_pegawai[0]->id_pegawai;
            $nip        = $detail_pegawai[0]->nip;
            $pin        = substr($nip, -4);

            if(!empty($absensiHarian)){
                 $id_absen         = $absensiHarian[0]->id;
                $kodeShift         = $absensiHarian[0]->shift;
                $jamMasukKerja     = $absensiHarian[0]->jam_masuk;
                $jamKeluarKerja    = $absensiHarian[0]->jam_pulang;

                $absenMasuk         = $absensiHarian[0]->masuk;
                $absenPulang        = $absensiHarian[0]->pulang;
                $keterangan_absen   = $absensiHarian[0]->keterangan;


                $absenTidakhadir = '';
                
                $checkDLP = '';
                $checkDLA = '';
                $checkDLAK = '';
                $checkIZ = '';
                $checkSKT = '';
                $checkSKTDGNSURAT = '';


               
                if ($absenMasuk=='DLP') {
                    $absenMasuk = '<span class="fs-2    text-custom-500">DL-PENUH</span>';
                    $absenPulang = '<span class="fs-2  text-custom-500">DL-PENUH</span>';
                    $absenTidakhadir = 'DL-PENUH';
                    $checkDLP = 'checked';
                     
                }else if ($absenMasuk=='DLA') {
                    $absenMasuk = '<span class="fs-2  badge bg-info-subtle text-custom-500 ">DL-AWAL</span>';
                    $absenTidakhadir = 'DL-AWAL';
                    $checkDLA = 'checked';
                }else if ($absenMasuk=='SAKIT') {
                    $absenMasuk = '<span class="fs-2  badge  text-orange-500">SAKIT</span>';
                    $absenPulang = '<span class="fs-2  badge  text-orange-500">SAKIT</span>';
                    $absenTidakhadir = 'SAKIT';
                    $checkSKT = 'checked';
                }else if ($absenMasuk=='IZIN') {
                    $absenMasuk = '<span class="fs-2  badge  text-range-500">IZIN</span>';
                    $absenPulang = '<span class="fs-2  badge text-range-500">IZIN</span>';
                    $absenTidakhadir = 'IZIN';
                    $checkIZ = 'checked';
                }else if ($absenMasuk=='CUTI') {
                    $absenMasuk = '<span class="fs-2 badge  text-green-500">CUTI</span>';
                    $absenPulang = '<span class="fs-2  badge  text-green-500">CUTI</span>';
                    $absenTidakhadir = 'CUTI';
                    
                }else if ($absenMasuk=='SAKIT DGN SURAT'){
                    $checkSKTDGNSURAT = 'checked';
                }


             




                if($absenPulang=='DLH'){
                    $absenTidakhadir = 'DL-AKHIR';
                    $absenPulang = '<span class="fs-2 badge bg-info-subtle text-info">DL-AKHIR</span>';
                    $checkDLAK = 'checked';
                }

              }else{
                $absenMasuk   ='';
                $absenPulang  ='';
                $keterangan_absen  = '';
                $absenTidakhadir = '';

                $kodeShift         =  '';
                $jamMasukKerja     =  '';
                $jamKeluarKerja    = '';
              }

              #print_array($izinSakit);
        ?>

<ul class="nav nav-tabs mb-3">
    <li class="nav-item">
        <a href="#home" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-home-variant d-md-none d-block"></i>
            <span class="d-none d-md-block">Input Absensi</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#profile" data-bs-toggle="tab" aria-expanded="true" class="nav-link active">
            <i class="mdi mdi-account-circle d-md-none d-block"></i>
            <span class="d-none d-md-block">Input Jam Absen</span>
        </a>
    </li>
    <li class="nav-item">
        <a href="#settings" data-bs-toggle="tab" aria-expanded="false" class="nav-link">
            <i class="mdi mdi-settings-outline d-md-none d-block"></i>
            <span class="d-none d-md-block">Settings</span>
        </a>
    </li>
</ul>

<div class="tab-content">
    <div class="tab-pane" id="home">
    <form method="post" action="<?php echo base_url();?>admin/presensi/insert_absen_ketidakhadiran_v2" id="insertAbsensi">
                        <input type="hidden" name="tgl_absensi" value="<?php echo $tanggal;?>">
                         <input type="hidden" name="pin" value="<?php echo $pin;?>">
                         <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai;?>">
                         
                        <strong> Input Absen  </strong>

                        <div class="mt-2">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="checkDLP" <?php echo $checkDLP;?>  value="DL-PENUH" name="jns_absensi">
                                <label class="form-check-label" for="checkDLP">DL-PENUH</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="checkDLA" <?php echo $checkDLA;?>  value="DL-AWAL" name="jns_absensi">
                                <label class="form-check-label" for="checkDLA">DL-AWAL</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="checkbox" class="form-check-input" id="checkDLAK" <?php echo $checkDLAK;?>  value="DL-AKHIR" name="jns_absensi">
                                <label class="form-check-label" for="checkDLAK">DL-AKHIR</label>
                            </div>
                            <div class="form-check form-check-inline form-checkbox-warning">
                                <input type="checkbox" class="form-check-input" id="checkIzin" <?php echo $checkIZ;?>  value="IZIN" name="jns_absensi">
                                <label class="form-check-label" for="checkIzin">IZIN</label>
                            </div>
                            <div class="form-check form-check-inline form-checkbox-warning">
                                <input type="checkbox" class="form-check-input" id="checkSAKIT" <?php echo $checkSKT;?>  value="SAKIT" name="jns_absensi">
                                <label class="form-check-label" for="checkSAKIT">SAKIT</label>
                            </div>

                            <div class="form-check form-check-inline form-checkbox-warning">
                                <input type="checkbox" class="form-check-input" id="checkSAKIT2" <?php echo $checkSKTDGNSURAT;?>  value="SAKIT  DGN SURAT" name="jns_absensi">
                                <label class="form-check-label" for="checkSAKIT2">SAKIT DENGAN SURAT</label>
                            </div>

                        </div>
 
                       
                            <div class="mb-1 mt-2 p-2 form_jns_izin border d-none jns_izin">
                                <label>Jenis Izin</label> :  &nbsp; &nbsp;<br>

                                <input type="radio" name="jns_izin" value="1" id="izin1">
                                <label for="izin1">1 Hari</label> <br>

                                <input type="radio" name="jns_izin" value="2" id="izin2">
                                <label for="izin2">1/2 Hari awal</label> <br>

                                <input type="radio" name="jns_izin" value="3" id="izin3">
                                <label for="izin3">1/2 Hari akhir</label>
                      

                           </div>

                            <br>
                            
                            <input type="text" id="inputText" value="<?php echo $keterangan_absen;?>" name="keterangan" placeholder="keterangan" class="form-control">
        
                                <br>
                            <button type="submit" class="btn btn-success float-end">Simpan</button>
                            <div class="clearfix"></div>
                       
                
                   </form>            
                   
                
    </div>
    <div class="tab-pane show active p-3" id="profile">
      <form method="post" action="<?php echo base_url().'admin/presensi/insert_absen_manual/'.$pin.'/'.$tanggal;?>">
            <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai;?>">


            <div class="row g-2">
                <div class="mb-3 col-md-6">
                    <label>Jam Masuk</label>
                    <input type="text" id="inputText"  name="jam_masuk" placeholder="Jam Masuk" class="form-control">
                </div>
                <div class="mb-3 col-md-6">
                    <label>Jam Pulang</label>
                    <input type="text" id="inputText" name="jam_pulang" placeholder="Jam Pulang"  class="form-control">
                </div>
            </div>

            <button type="submit" class="btn btn-sm btn-success">Simpan</button>

            
            
            

            
        </form>
    </div>
    <div class="tab-pane" id="settings">
        <p>...</p>
    </div>
</div>

<script>
    $("#checkIzin").click(function(){
     
        
       var checkd =  $(this).is(":checked");
        if(checkd){
            $(".jns_izin").removeClass('d-none');
        }else{
            $(".jns_izin").addClass('d-none');
        }
    });
</script>