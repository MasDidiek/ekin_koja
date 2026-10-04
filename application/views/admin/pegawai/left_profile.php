
<div class="photo-profile">
            <img src="<?php echo base_url();?>uploads/photo_profile/10202719870805201802227.jpg">
    </div>

    
    <br>
    <div class="text-center">
        <p>
            Slamet Didik Agus Kurniawan<br>
            <strong>10202719941013201801226</strong>
        </p>

    </div>


    <?php
    $func = $this->uri->segment(3);
    $id_pegawai = $this->uri->segment(4);
    $nip = $this->uri->segment(5);


    ?>
    <ul class="menu-profile">
        <li class="active"><a href="<?php echo PEGAWAI.'detail_pegawai/'.$id_pegawai.'/'.$nip;?>"><i class="fa-solid fa-user-tie"></i> Profile</a></li>
        <li><a href="<?php echo PEGAWAI.'cuti_pegawai/'.$id_pegawai.'/'.$nip;?>"><i class="fa-solid fa-calendar-xmark"></i> Cuti</a></li>
        <li><a href="<?php echo PEGAWAI.'gaji_pegawai/'.$id_pegawai.'/'.$nip;?>"><i class="fa-solid fa-money-bill-wave"></i> Gaji</a></li>
        <li><a href="<?php echo PEGAWAI.'absensi_pegawai/'.$id_pegawai.'/'.$nip;?>"><i class="fa-solid fa-hand-middle-finger"></i> Absensi</a></li>
        <li><a href="<?php echo PEGAWAI.'sip_str_pegawai/'.$id_pegawai.'/'.$nip;?>"><i class="fa-solid fa-layer-group"></i> SIP/STR</a></li>
        <li><a href="<?php echo PEGAWAI.'diklat_pegawai/'.$id_pegawai.'/'.$nip;?>"><i class="fa-solid fa-book-open-reader"></i> Diklat</a></li>

    </ul>