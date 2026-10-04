<?php
$menu_current = $this->uri->segment(2);
$method_current = $this->uri->segment(3);
$param_current = $this->uri->segment(4);
?>


<header class="navbar">

    <button class="toggle-button" type="button" aria-label="Toggle menu" aria-expanded="true">
        <i class="fa fa-bars"></i>
    </button>
    <div class="profile">
        <span>Halo, <strong> Mas Didiek</strong></span>
    </div>
</header>
<aside class="sidebar">
    <div class="brand">Dashboard EKIN</div>
    <div class="title-menu">MAIN MENU</div>
    <ul class="nav-list">
        <li><a href="<?= base_url('dashboard') ?>" class="nav-link <?= ($menu_current == 'dashboard' || !$menu_current) ? 'active' : '' ?>"><span class="icon"><i class="fa fa-home"></i></span><span class="label">Dashboard</span></a></li>
        <li><a href="<?= base_url('absensi') ?>" class="nav-link <?= ($menu_current == 'absensi') ? 'active' : '' ?>"><span class="icon"><i class="fa fa-clock-o"></i></span><span class="label">Absensi</span></a></li>
        <li><a href="<?= base_url('dashboard_admin/cuti') ?>" class="nav-link <?= ($menu_current == 'cuti') ? 'active' : '' ?>"><span class="icon"><i class="fa fa-suitcase"></i></span><span class="label">Cuti</span></a></li>
        <li><a href="<?= base_url('dinas_luar') ?>" class="nav-link <?= ($menu_current == 'dinas_luar') ? 'active' : '' ?>"><span class="icon"><i class="fa fa-briefcase"></i></span><span class="label">Dinas Luar</span></a></li>
        <li><a href="<?= base_url('izin_sakit') ?>" class="nav-link <?= ($menu_current == 'izin_sakit') ? 'active' : '' ?>"><span class="icon"><i class="fa fa-stethoscope"></i></span><span class="label">Izin / Sakit</span></a></li>

        <li class="nav-item-has-submenu <?= ($menu_current == 'pegawai' || $menu_current == 'data_pegawai') ? 'active' : '' ?>">
            <a href="javascript:void(0)" class="nav-link submenu-toggle">
                <span class="icon"><i class="fa fa-users"></i></span>
                <span class="label">Pegawai</span>
                <span class="arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            <ul class="nav-submenu">
                <li><a href="<?= base_url('pegawai/index/non_pns') ?>" class="nav-link <?= ($param_current == 'non_pns') ? 'active' : '' ?>">Non PNS</a></li>
                <li><a href="<?= base_url('pegawai/index/pns') ?>" class="nav-link <?= ($param_current == 'pns') ? 'active' : '' ?>">PNS</a></li>
                <li><a href="<?= base_url('pegawai/index/pppk_pw') ?>" class="nav-link <?= ($param_current == 'pppk_pw') ? 'active' : '' ?>">PPPK PW</a></li>
                <li><a href="<?= base_url('pegawai/index/pppk') ?>" class="nav-link <?= ($param_current == 'pppk') ? 'active' : '' ?>">PPPK</a></li>
            </ul>
        </li>

        <li><a href="<?= base_url('kinerja/capaian') ?>" class="nav-link <?= ($menu_current == 'kinerja') ? 'active' : '' ?>"><span class="icon"><i class="fa fa-dashboard"></i></span><span class="label">Kinerja</span></a></li>

        <li class="nav-item-has-submenu <?= ($menu_current == 'data_listing') ? 'active' : '' ?>">
            <a href="javascript:void(0)" class="nav-link submenu-toggle">
                <span class="icon"><i class="fa fa-file-text"></i></span>
                <span class="label">Data Listing</span>
                <span class="arrow"><i class="fa fa-chevron-right"></i></span>
            </a>
            <ul class="nav-submenu">
                <li><a href="<?= base_url('data_listing/gaji_non_pns') ?>" class="nav-link">Gaji Non PNS</a></li>
                <li><a href="<?= base_url('data_listing/gaji_pppk') ?>" class="nav-link">Gaji PPPK</a></li>
                <li><a href="<?= base_url('data_listing/index') ?>" class="nav-link">TKD Non PNS</a></li>
                <li><a href="<?= base_url('data_listing/tkd_pppk') ?>" class="nav-link">TKD PPPK</a></li>
            </ul>
        </li>
    </ul>
</aside>

<script>
    document.querySelectorAll('.submenu-toggle').forEach(item => {
        item.addEventListener('click', event => {
            const parent = item.parentElement;

            // Cek jika sidebar sedang collapsed, abaikan toggle manual atau buka sidebar dulu
            if (document.querySelector('.sidebar').classList.contains('collapsed')) {
                return;
            }

            // Tutup submenu lain yang sedang terbuka (optional)
            document.querySelectorAll('.nav-item-has-submenu').forEach(otherItem => {
                if (otherItem !== parent) {
                    otherItem.classList.remove('active');
                }
            });

            // Toggle menu saat ini
            parent.classList.toggle('active');
        });
    });
</script>