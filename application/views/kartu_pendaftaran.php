<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Catin - Puskesmas Kecamatan Cilincing</title>

    <style>
        .container{
            width: 500px;
            height: 250px;
            border: 1px solid #666;
            padding:10px 20px;
            margin: 50px auto;
        }

        .left-logo{
            background-color: #FFF;
            float:left;
            width:60%;
            height: 80px;
        }
        .right-logo{
            background-color: #FFF;
            float:right;
            width:30%;
            height: 80px;
            text-align: right;
        }
        .content{
            margin-top: 20px;
            width: 100%;
        }
    </style>
    </head>
<body>

   <div class="container">
          <div class="left-logo"> <img src="<?php echo base_url();?>assets/img/logo_puskes_ori.png" width="200px"></div>
          <div class="right-logo"> <img src="<?php echo base_url();?>assets/img/logo_pkc.png" width="60px"></div>
        <div style="clear: both;"></div>
          
        <?php
        #print_array($detail_catin);
        $nama = $detail_catin[0]->nama;
        $nik = $detail_catin[0]->nik;
        $tgl_lahir = $detail_catin[0]->tgl_lahir;
        $alamat_domisili = $detail_catin[0]->alamat_domisili;
        ?>
          <div class="content">
               <table>
                <tr>
                    <td width="150">Nama Lengkap</td>
                    <td>:</td>
                    <td><?php echo $nama;?></td>
                </tr>
                <tr>
                    <td>NIK</td>
                    <td>:</td>
                    <td><?php echo $nik;?></td>
                </tr>
                <tr>
                    <td>Tanggal Lahir</td>
                    <td>:</td>
                    <td><?php echo $tgl_lahir;?></td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>:</td>
                    <td><?php echo $alamat_domisili;?></td>
                </tr>
               </table>
          </div>

           
           
   </div>

</body>

</html>

