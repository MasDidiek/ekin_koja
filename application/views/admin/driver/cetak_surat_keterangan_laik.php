<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sipuspa</title>

    <style>
        .main-content{
            width:800px;
            height:auto;
            padding:20px;
            border:1px solid #CCC;
            margin:0 auto;
            text-align:center;
            font-size:16px
        }

        .image-logo{
            width:100px;
            height:100px;
            display:inline-block;
            padding:10px;
            margin:0 auto;
        }

        .image-logo img{
            width:100px;
            height:100px;
        }

        .content{
            width:100%;
            text-align:left;
            margin-top:50px
        }

        .status-laik{
            font-size:20px;
            font-weight:bold;
            
        }
        
        .mengetahui1{
            width:300px;
            height:130px;
            text-align:center;
            float:left;
        }
        
         
        .mengetahui2{
            width:300px;
            height:130px;
            text-align:center;
            float:right;
        }
        
        
        .title{
            height:80%;
            width:100%;
        }
    </style>
</head>
<body>

  
<?php
  $id_driver =  $detail_pemeriksaan[0]->id_driver;
  $id_pemeriksaan = $detail_pemeriksaan[0]->id;
  $data_detail =  $this->Driver_model->get_data_edit($id_driver);
  $tgl_lahir   = $data_detail[0]->tgl_lahir;
  $nama_terminal = $detail_pemeriksaan[0]->nama_terminal;

  $status_laik = $detail_pemeriksaan[0]->status_laik;

  $status_ht = $detail_pemeriksaan[0]->status_ht;
  $status_gds = $detail_pemeriksaan[0]->status_gds;
  $ada_gejala = $detail_pemeriksaan[0]->ada_gejala;

  $nama_dokter = $detail_pemeriksaan[0]->nama_dokter;
  

  $riwayatPTMKeluarga = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_ptm_keluarga');
  $riwayatPTMDiri = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_ptm');
  $faktorResiko   = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_faktor_resiko');
  

  $tes_urine = $faktorResiko[0]->tes_urine;

  $catatan_mengemudi = '<ul>';
  if($status_laik==1){
         $status_layak = 'LAIK MENGEMUDI';
  }else if($status_laik==2){
         $status_layak = 'LAIK MENGEMUDI<br> dengan Catatan';

            if($status_ht==3){
                $catatan_mengemudi .= '- Hipertensi Sedang <br>';
            }

            if($ada_gejala==0){
                $catatan_mengemudi .= ' - GDS > 200 Tanpa Gejala Penyerta <br>';
            }

            if($tes_urine==0){
                $catatan_mengemudi .= '- Amphetamin Urin TIDAK DIPERIKSA';
          }
    


  }else{
        $status_layak = 'TIDAK LAIK MENGEMUDI<br> dengan Catatan';
        
        if($status_ht==4){
            $catatan_mengemudi .= '- Hipertensi Berat <br>';
        }

        if($ada_gejala==1){
            $catatan_mengemudi .= '- GDS > 200 Dengan Gejala Penyerta <br>';
        }

        if($tes_urine==2){
              $catatan_mengemudi .= '- Amphetamin Urin Positif (+)';
        }

    }

    $catatan_mengemudi .= '</ul>';

  $umur = calculateAge($tgl_lahir);
?>


<div class="main-content">
        <div class="image-logo">
                <img src="<?php echo base_url();?>assets/img/dishub.png">
        </div>
        <div class="image-logo">
                <img src="<?php echo base_url();?>assets/img/pemprov.png">
        </div>
        <div class="image-logo">
                <img src="<?php echo base_url();?>assets/img/dinkes.jpg">
        </div>




        <h1>Surat Keterangan Laik Mengemudi</h1>

        <div class="content">

                <table width="100%">
                    <tr>
                        <td width="260">Nama PO</td>
                        <td width="30">:</td>
                        <td><?php echo $data_detail[0]->nama_po;?></td>
                    </tr>
                    <tr>
                        <td>Nama Supir/Umur/HP</td>
                        <td>:</td>
                        <td><?php echo $data_detail[0]->nama;?> / <?php echo $umur;?> tahun / <?php echo $data_detail[0]->no_hp;?></td>
                    </tr>
                    <tr>
                        <td>Nama Supir Cadangan/Umur/No.HP</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Jurusan Keberangkatan</td>
                        <td>:</td>
                        <td>Terminal <?php echo $data_detail[0]->terminal_tujuan;?></td>
                    </tr>
                    <tr>
                        <td>Terminal Keberangkatan</td>
                        <td>:</td>
                        <td> <?php echo $nama_terminal;?></td>
                    </tr>
                
                </table>

                <p> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                     Berdasarkan hasil pemeriksaan diatas, dan berdasarkan pengetahuan saya, <br>
                      maka pada saat ini yang bersangkutan dinyatakan : </p> <br><br>



                      <center>
                            <div class="status-laik">
                                <?php echo $status_layak;?>
                            </div>
                      </center>
                      <br><br>



                     
                    <p>&nbsp;  &nbsp;  &nbsp;  &nbsp;  &nbsp;Bus dijalankan oleh pengemudi dengan kriteria  <strong><?php echo $status_layak;?></strong>. </p>

                    <?php echo $catatan_mengemudi;?>
                    <br><br><br>

                    <div class="mengetahui1">
                        <div class="title">Mengetahui</div>
                        <div class="bagian">Dishub</div>
                        
                    </div>
                    
                      <div class="mengetahui2">
                        <div class="title"> Dokter Pemeriksa</div>
                        <div class="bagian"><?php echo $nama_dokter;?></div>
                        
                    </div>
                    <div style="clear:both"></div>
                     
                    


        </div>

       
</div>
    
</body>
</html>