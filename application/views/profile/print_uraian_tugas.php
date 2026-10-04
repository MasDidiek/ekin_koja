<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Tugas  - </title>
    <style>
      
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
 
        @page {
            size: A4;
            margin: 0;
        }
 
        /* Set content to fill the entire A4 page */
        html,
        body {
            width: 210mm;
            height: 297mm;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif
        }
 
        .container{
            width: 90%;
            /* Adjust the width as needed */
            height: 90%;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            font-size:15px;
            padding-left:10px;
           
        }
      
    
      .header{
        width: auto;
        padding: 0 40px;
        height: 150px;
      }


      .header2{
        width: auto;
        padding: 20px 40px;
        height: 150px;
        margin-top: 60px;
      }

      .logo{
       
        float: left;
        width: 20%;
      }

      .header-text{
       
        background-color: #FFF;
        float: left;
        width: 80%;
        text-align: center;
      }
      

      .hr1{
        margin-top: 10px;
        height: 2px;
        width: 100%;
        background-color: #333;
      }
      .hr2{
        margin-top: 1px;
        height: 4px;
        width: 100%;
        background-color: #333;
      }

      .main-content{
        width: auto;
        padding: 10px 40px;
        height: auto;

      }
      .main-header{
        color: #333;
        margin-top: 10px;
        text-align: center;
        font-size: 13px;
      }

      .photo{
        text-align: center;
        margin-top: 20px;
      }
      .photo img{
        width: 110px;
        height: 140px;

      }

      .data-diri{
        margin-top: 10px;
        padding: 20px;
      }

      .data-diri td{
        padding:3px
      }

      .title{
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        text-decoration: underline;
      }
      .tugas-pokok{
        padding:10px 20px;
      }
 
        .list{
            margin:10px 20px;
            line-height: 22px;
        }

        .mengetahui{
            margin-top: 50px;;
        }

        .left, .right{
            width: 50%;
            height: auto;
            float: left;
            text-align: center;
            padding:30px;
        }

        .left{
            text-align: left;
        }
        .nama_nip_footer{
            margin-top: 100px;
        }

        li{
            list-style:none;
        }
    </style>
</head>
<body>

            
 
    <div class="container">

        <div class="header">
             <div class="logo">
                 <img src="<?php echo base_url();?>assets/images/logo_dki.png" width="105">
             </div>
             <div class="header-text">
                 PEMERINTAH  PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA <br>
                    DINAS KESEHATAN<br>
                    SUKU DINAS KESEHATAN KOTA ADMINISTRASI JAKARTA UTARA<br>
                    <strong> PUSAT KESEHATAN MASYARAKAT CILINCING</strong><br>
                    <span style="font-size: 14px;">

                   
                        Jalan Sungai Landak No.26, Jakarta Utara Telepon 021-4418325<br>
                        Faksimile : 021-21484022 E-mail : puskesmas.cilincing @jakarta.go.id<br>
                  
                        JAKARTA

                    </span>
             </div>

             <div style="clear: both;"></div>

            <div class="hr1"></div>
            <div class="hr2"></div>
        </div>
        <?php

                $nip    = $uraian_tugas[0]->nip;
                $tugas_pokok    = $uraian_tugas[0]->tugas_pokok;
                $tugas_integrasi = $uraian_tugas[0]->tugas_integrasi;
                $wewenang = $uraian_tugas[0]->wewenang;
                $tanggung_jawab = $uraian_tugas[0]->tanggung_jawab;

                $pendTerakhir = $this->Pegawai_model->getPendidikanTerakhir($nip);

                if(!empty($pendTerakhir)){
                    $jenjang = $pendTerakhir[0]->jenjang;
                    $jurusan = $pendTerakhir[0]->jurusan;

                    $pendidikan = $jenjang.' '.$jurusan;
                }else{
                    $pendidikan = '-';
                }

                // Pisahkan berdasarkan angka + titik
                $array = preg_split('/\d+\./', $tugas_pokok, -1, PREG_SPLIT_NO_EMPTY);
                // Hilangkan spasi ekstra jika ada
                $array = array_map('trim', $array);

                $tugas_intrg = preg_split('/\d+\./', $tugas_integrasi, -1, PREG_SPLIT_NO_EMPTY);
                $tugas_intrg = array_map('trim', $tugas_intrg);


                $wwn = preg_split('/\d+\./', $wewenang, -1, PREG_SPLIT_NO_EMPTY);
                $wwn = array_map('trim', $wwn);
                

                $tj = preg_split('/\d+\./', $tanggung_jawab, -1, PREG_SPLIT_NO_EMPTY);
                $tj = array_map('trim', $tj);


                $photo = $this->Pegawai_model->getPhotoPegawai($nip);

                if($photo==''){
                  $photo = 'avatar.png';
                }

              
                //print_array($pegawai);
                $nama = $pegawai[0]->nama;
                $jabatan = $pegawai[0]->jabatan;
                $keterangan_jabatan = $pegawai[0]->keterangan_jabatan;
                $puskesmas = $pegawai[0]->puskesmas;
                // $nama = $pegawai[0]->nama;
                // $nama = $pegawai[0]->nama;

             

            ?>


        <div class="main-content">
            <div class="main-header">
                TUGAS POKOK DAN FUNGSI<br>
                PUSAT KESEHATAN MASYARAKAT CILINCING<br><br>

                BERDASARKAN PERATURAN GUBERNUR PROVINSI DKI JAKARTA NOMOR 14 TAHUN 2023<br>
                TENTANG PEMBENTUKAN ORGANISASI DAN TATA KERJA PUSAT KESEHATAN MASYARAKAT
            </div>


            <div class="photo">
                 <img src="<?php echo base_url().'uploads/photo_profile/'. $photo ;?>" alt="">
            </div>


         
            <div class="data-diri">
                <table>
                    <tr>
                        <td width="150">Nama</td>
                        <td  width="20">:</td>
                        <td><?php echo $nama;?></td>
                    </tr>
                    <tr>
                        <td>NIP</td>
                        <td>:</td>
                        <td><?php echo $nip;?></td>
                    </tr>
                    <tr>
                        <td>Jabatan</td>
                        <td>:</td>
                        <td><?php echo $jabatan.' '.$keterangan_jabatan;?></td>
                    </tr>
                    <tr>
                        <td>Pendidikan</td>
                        <td>:</td>
                        <td><?php echo $pendidikan;?> </td>
                    </tr>
                    <tr>
                        <td>Tempat Tugas</td>
                        <td>:</td>
                        <td><?php echo $puskesmas;?></td>
                    </tr>
                </table>
            </div>


             <div class="title">
               URAIAN TUGAS
             </div>


            <div class="tugas-pokok" style="margin-bottom:60px">
               <p> 1. &nbsp; Tugas Pokok	:</p>

                <div class="list">
                     <ul>
                                <?php 
                                    $no = 0;

                                    $numRows = count($array);

                                    if($numRows > 10){
                                        $maxLoop = 10;
                                    }else{
                                        $maxLoop = $numRows;
                                    }

                                    for ($i=0; $i < $maxLoop ; $i++) { 
                                        $no = $no+1;
                                        echo '<li>'.$no .'. '.$array[$i].'</li>';
                                    }



                                ?>
                     </ul>
                    <br>
                    
                   
                </div>
                 
            </div>

           
        </div><!--close main-content-->

        
       

        <div class="header2">
             <div class="logo">
                 <img src="<?php echo base_url();?>assets/images/logo_dki.png" width="105">
             </div>
             <div class="header-text">
                 PEMERINTAH  PROVINSI DAERAH KHUSUS IBUKOTA JAKARTA <br>
                    DINAS KESEHATAN<br>
                    SUKU DINAS KESEHATAN KOTA ADMINISTRASI JAKARTA UTARA<br>
                    <strong> PUSAT KESEHATAN MASYARAKAT CILINCING</strong><br>
                    <span style="font-size: 14px;">

                   
                        Jalan Sungai Landak No.26, Jakarta Utara Telepon 021-4418325<br>
                        Faksimile : 021-21484022 E-mail : puskesmas.cilincing @jakarta.go.id<br>
                  
                        JAKARTA

                    </span>
             </div>

             <div style="clear: both;"></div>

            <div class="hr1"></div>
            <div class="hr2"></div>
        </div>

        <div class="main-content">
            <div class="tugas-pokok">
                <div class="list">
                      <ul>
                        <?php
                             if($numRows > 10){
                                $nextNumber = $no;
                                for ($i=$no; $i < $numRows ; $i++) { 
                                    $nextNumber = $nextNumber+1;
                                     echo '<li>'.$nextNumber .'. '.$array[$i].'</li>';
                                }
                            }
                        ?>
                        </ul>
                    </div>

            </div>

       
                <p> 2. &nbsp; Tugas Integrasi	:</p>
                <div class="tugas-pokok">
                    <div class="list">
                    <ul>
                        <?php

                            $no = 0;
                            for ($ti=0; $ti < count($tugas_intrg); $ti++) { 
                                $no = $no+1;
                                echo '<li>'.$no .'. '.$tugas_intrg[$ti].'</li>';
                            }
                        
                        ?>
                        </ul>
                     </div>
               </div>


               <p> 3. &nbsp; Wewenang	:</p>
               <div class="tugas-pokok">
                    <div class="list">
                        <?php

                            $no = 0;
                            for ($w=0; $w < count($wwn); $w++) { 
                                $no = $no+1;
                                echo $no .'. '.$wwn[$w].'<br>';
                            }
                        
                        ?>
                     </div>
               </div>

               <p> 4. &nbsp; Tanggung Jawab	:</p>
               <div class="tugas-pokok">
                    <div class="list">
                        <?php

                            $no = 0;
                            for ($w=0; $w < count($tj); $w++) { 
                                $no = $no+1;
                                echo $no .'. '.$tj[$w].'<br>';
                            }
                        
                        ?>
                     </div>
               </div>

               <p>Demikian surat tugas ini agar dilaksanakan dengan sebaik - baiknya dan penuh rasa tanggung jawab</p>


               <div class="mengetahui">
                     
                    <div class="left">
                         Mengetahui<br>
                         Kepala Pusat Kesehatan Masyarakat<br>
                         Cilincing <br>


                         <div class="nama_nip_footer">
                            dr. Raden Achmad Sigit Mustika Adi<br>
                            NIP. 196801242007011020 
                            </div>
                    </div>

                    <div class="right">
                    Pelaksana

                    <br><br><br>
                        <div class="nama_nip_footer">
                            <?php echo $nama;?> <br>
                            NIP.<?php echo $nip;?>
                        </div>
                  
                    </div>

               
               </div>
        </div>

        
            
     
  
    </div>
    

</body>

</html>