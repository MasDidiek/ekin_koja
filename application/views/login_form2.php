<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title> Ekinerja | Puskesmas Cilincing</title>

    <link rel="shortcut icon" href="<?php echo base_url(); ?>assets/images/logo_jakarta.png">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/fontawsom-all.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/login_style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <style>
        .roboto-regular {
            font-family: "Roboto", sans-serif;
            font-weight: 400;
            font-style: normal;
        }

        .error-message {
            background-color: #fff2f2;
            color: #f4666a;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #f4666a;
            font-size: 12px;
        }

        .box-info {
            position: absolute;
            background: rgba(255, 255, 255, 0.9);
            width: 50%;
            height: 300px;
            z-index: 1;
            top: 10%;
            left: 10%;
            border-radius: 10px;

        }

        .fw-bold {
            font-weight: bold;
        }

        /* The Modal (background) */
        .modal {
            display: none;
            /* Hidden by default */
            position: fixed;
            /* Stay in place */
            z-index: 1;
            /* Sit on top */
            padding-top: 100px;
            /* Location of the box */
            left: 0;
            top: 0;
            width: 100%;
            /* Full width */
            height: 100%;
            /* Full height */
            overflow: auto;
            /* Enable scroll if needed */
            background-color: rgb(0, 0, 0);
            /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4);
            /* Black w/ opacity */
        }


        @media (min-width:320px) {
            /* smartphones, iPhone, portrait 480x320 phones */

            .modal-content {
                position: relative;
                background-color: #fefefe;
                margin: auto;
                padding: 0;
                border: 1px solid #888;
                width: 90%;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.4s;
                animation-name: animatetop;
                animation-duration: 0.4s
            }
        }

        @media (min-width:481px) {

            /* portrait e-readers (Nook/Kindle), smaller tablets @ 600 or @ 640 wide. */
            .modal-content {
                position: relative;
                background-color: #fefefe;
                margin: auto;
                padding: 0;
                border: 1px solid #888;
                width: 90%;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.4s;
                animation-name: animatetop;
                animation-duration: 0.4s
            }
        }

        @media (min-width:641px) {
            .modal-content {
                position: relative;
                background-color: #fefefe;
                margin: auto;
                padding: 0;
                border: 1px solid #888;
                width: 90%;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.4s;
                animation-name: animatetop;
                animation-duration: 0.4s
            }

            /* portrait tablets, portrait iPad, landscape e-readers, landscape 800x480 or 854x480 phones */
        }

        @media (min-width:961px) {
            /* tablet, landscape iPad, lo-res laptops ands desktops */

            /* Modal Content */
            .modal-content {
                position: relative;
                background-color: #fefefe;
                margin: auto;
                padding: 0;
                border: 1px solid #888;
                width: 800px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.4s;
                animation-name: animatetop;
                animation-duration: 0.4s
            }

        }

        @media (min-width:1025px) {
            /* big landscape tablets, laptops, and desktops */

            /* Modal Content */
            .modal-content {
                position: relative;
                background-color: #fefefe;
                margin: auto;
                padding: 0;
                border: 1px solid #888;
                width: 800px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.4s;
                animation-name: animatetop;
                animation-duration: 0.4s
            }

        }

        @media (min-width:1281px) {
            /* hi-res laptops and desktops */

            /* Modal Content */
            .modal-content {
                position: relative;
                background-color: #fefefe;
                margin: auto;
                padding: 0;
                border: 1px solid #888;
                width: 800px;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                -webkit-animation-name: animatetop;
                -webkit-animation-duration: 0.4s;
                animation-name: animatetop;
                animation-duration: 0.4s
            }

        }


        /* Add Animation */
        @-webkit-keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }

            to {
                top: 0;
                opacity: 1
            }
        }

        @keyframes animatetop {
            from {
                top: -300px;
                opacity: 0
            }

            to {
                top: 0;
                opacity: 1
            }
        }

        /* The Close Button */
        .close {
            color: white;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }

        .modal-header {
            padding: 2px 16px;
            background-color: #EEE;
            color: darkcyan;
        }

        .modal-body {
            padding: 2px 16px;
            font-size: 20px;
        }

        .modal-footer {
            padding: 2px 16px;
            background-color: #FFF;
            color: darkcyan;
        }
    </style>
</head>


<?php
$dateNow = date('Y-m-d');
$hari = format_hari($dateNow);
$blnNow = date('m');

$bln_lalu = $blnNow - 1;
$nama_bulan_lalu = getBulan($bln_lalu);

$tanggal_hari_ini = formatTanggalIndo($dateNow);

$exlode = explode(" ", $tanggal_hari_ini);
$bulan  = $exlode[1];

$tgl_now = date('d');

if ($tgl_now < 6) {
    $showInfo =  true;
} else {
    $showInfo =  false;
}
?>

<body>
    <div class="container-fluid conya">
        <div class="side-left">

            <div class="box-info">
                <div class="bg-info p-2 rounded-2">
                    <div class="row">
                        <div class="col-md-6 text-white fw-bold">
                            INFORMASI
                        </div>
                        <div class="col-md-6 text-white text-right fw-bold">
                            <?php echo $hari; ?>, <?php echo $tanggal_hari_ini; ?>
                        </div>
                    </div>
                </div>


                <div class="p-4 roboto-regular text-dark" style="font-size:20px">
                    <ol>
                        <li> - Proses input aktivitas akan di tutup tanggal 5 pukul 23:59 bulan Berikutnya</li>
                        <li> - Batas akhir validasi Kinerja oleh Kepala Satuan Pelaksana adalah dari tanggal 6 sampai tanggal 10 di setiap bulannya.</li>
                        <li> - Selalu periksa capaian kinerja dan absensi setiap bulannya</li>
                        <li> - Apabila anda tdk menyelesaikan input kinerja akan berpengaruh kepada tunjangan kinerja yang diterima</li>
                    </ol>


                    <a href="<?php echo base_url(); ?>" class="text-info">
                        <i class="fa fa-download"></i> </a>
                </div>

            </div>

            <div class="sid-layy">
                <div class="row slid-roo">

                    <div class="data-portion">
                        <h2>Puskesmas Cilincing</h2>
                        <p>Puskesmas Cilincing Kota Administrasi Jakarta Utara Lantai 1 Jl.Sungai landak No. 26 Cilincing, Kecamatan Cilincing, Kota Jakarta Utara, DKI Jakarta 14120</p>
                        <ul>
                            <li>Tlp :021-43905753</li>
                            <li>Hotline :0812-9829-1487</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <?php
        $global_config = $this->Master_model->config_global();
        $logo = $global_config[0]->logo;
        ?>

        <!-- Trigger/Open The Modal -->
        <button id="myBtn" class="d-none">Open Modal</button>

        <!-- The Modal -->
        <div id="myModal" class="modal">

            <!-- Modal content -->
            <div class="modal-content">
                <div class="modal-header">
                    <p>
                    <h2>Pengumuman</h2>
                    </p>

                    <span class="close">&times;</span>

                </div>
                <div class="modal-body p-4 ">
                    <center>


                        <img class="logo" src="<?php echo base_url(); ?>assets/images/megaphone.png" alt="informasi" width="200"><br><br>
                    </center>
                    <div class="alert alert-warning">
                        <h4>Hari tanggal <strong> <?php echo $tanggal_hari_ini; ?></strong></h4>
                        <hr>
                        <h4>Jangan lupa untuk melakukan pengisian aktifitas bulan <strong> <?php echo $nama_bulan_lalu; ?> 2024 </strong> </h4>
                        <hr>
                        <h4>Pengisian aktifitas bulan Juli akan ditutup pada tanggal <strong> 06 <?php echo $bulan; ?> 2024 Pukul 00:01 WIB</strong> </h4>

                    </div>

                </div>

            </div>

        </div>


        <div class="side-right">
            <img class="logo" src="<?php echo base_url(); ?>assets/images/<?php echo $logo; ?>" alt=""><br>
            <strong>Ekinerja Cilincing</strong>
            <h2></h2>

            <?php
            $msg = $this->session->flashdata('msg_login');
            $emailLogin = $this->session->userdata('email_login');
            $nip_sess = $this->session->userdata('nip_sess');



            if ($msg != '') {
                echo '<div class="error-message">
                    <img src="' . base_url() . 'assets/images/error-icon.png" alt="" width="30">
                    <strong>Login Gagal!</strong>  ' . $msg . '</div>';
            }
            ?>
            <h2>Login into Your Account</h2>
            <form action="<?php echo EKIN; ?>Login/do_login" method="post" name="form-login">
                <div class="form-row">
                    <label for="">NIP/NRK</label>
                    <input type="nip" required name="idpegawai" placeholder="masukan NIP / NRK anda" autocomplete="off" class="form-control   <?= form_error('idpegawai') ? 'is-invalid' : '' ?>" value="<?php echo $nip_sess; ?>">
                    <span class="invalid-feedback"><?php echo form_error('idpegawai'); ?> </span>
                </div>

                <div class="form-row">
                    <label for="">Password</label>
                    <input type="password" name="password" placeholder="Your password" id="userpassword" autocomplete="off" required class="form-control  <?= form_error('password') ? 'is-invalid' : '' ?>">
                </div>

                <div class="form-row row skjh">
                    <div class="col-7 left no-padding">
                        <input type="checkbox"> Keep me Sign In
                    </div>
                    <div class="col-5">
                        <span> <a href="<?php echo base_url(); ?>login/forget_password">Forget Password ?</a></span>
                    </div>


                </div>


                <div class="form-row dfr">
                    <button type="submit" class="btn btn-sm btn-success">Login</button>
                </div>
            </form>

            <div class="ord-v">
                <a href="or login with"></a>
            </div>



        </div>
        <div class="copyco">
            <p>Copyrigh 2024 @ didiekagus.kurniawan</p>
        </div>
    </div>
</body>

<script src="<?php echo base_url(); ?>assets/js/login/jquery-3.2.1.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/login/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/login/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/login/script.js"></script>



<script>
    // Get the modal
    var modal = document.getElementById("myModal");



    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    <?php if ($showInfo == true) { ?>
        // When the user clicks the button, open the modal 
        window.onload = function() {
            modal.style.display = "block";
        }

    <?php } ?>
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }


    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>



</html>