<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Data TTD SPJ</title>

    <style>

        .container{
                width:1000px;
                padding:20px;
                margin:0 auto;
                font-size:12px;
            }

            .header_no_dokumen{
                border:1px solid #EEE;
                padding:10px;
                float:right;
            }

            table{
                width: 100%;
                border-collapse:collapse;
            }

            .table tr td, th{
                padding:10px;
                border:1px solid #666;
            }

            .text-center{
                text-align:center;
            }
    </style>
   

   <?php
  //header("Content-type: application/vnd-ms-excel");


//   header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
 
//   header("Content-Disposition: attachment; filename=Data Gaji Pegawai PJLP.xlsx");


   ?>
</head>
<body>


<div class="container">

   <div class="header_no_dokumen">
      <table>
          <tr>
            <td>No.Dokumen</td>
            <td>:</td>
            <td>FRM.083 / PKC / ADMEN	</td>
          </tr>
          <tr>
            <td>No.Revisi</td>
            <td>:</td>
            <td>00</td>
          </tr>
          <tr>
            <td>Tgl.Tertib</td>
            <td>:</td>
            <td>30 September 2019	</td>
          </tr>
      </table>

   </div><!--header_no_dokumen-->


    <div style="clear:both"></div>
       <center>
        <h4>Daftar Hadir	</h4>
        </center>



        <?php
            $periode_bulan = $this->session->userdata('periode_bulan'); 
            $periode_tahun = $this->session->userdata('periode_tahun'); 
            $id_pkm_sess   = $this->session->userdata('id_pkm');

        

            $periode = $periode_tahun.'-'.$periode_bulan;
            $periode = date('F Y', strtotime($periode));
        ?>
        
        <table>
            <tr>
                <td width="250">Uraian Kegiatan	</td>
                <td  width="20">:</td>
                <td> <strong>TUNJANGAN KINERJA PEGAWAI NON PNS PUSAT KESEHATAN MASYARAKAT CILINCING	</strong> </td>
            </tr>
            <tr>
                <td>Unit	</td>
                <td>:</td>
                <td>1.02.0.00.0.00.01.0103 PUSKESMAS CILINCING	</td>
            </tr>
            <tr>
                <td>Tahun Anggaran	</td>
                <td>:</td>
                <td><?php echo $periode_tahun;?></td>
            </tr>
            <tr>
                <td>Waktu Pelaksanaan</td>
                <td>:</td>
                <td><?php echo getBulan($periode_bulan);?></td>
            </tr>
            <tr>

            <tr>
                <td>Program</td>
                <td>:</td>
                <td>1.02.03 PROGRAM PENINGKATAN KAPASITAS SUMBER DAYA MANUSIA KESEHATAN</td>
            </tr>

            <tr>
                <td>Kegiatan</td>
                <td>:</td>
                <td>1.02.03.2.02 Perencanaan Kebutuhan dan Pendayagunaan Sumber Daya Manusia Kesehatan untuk UKP dan UKM di Wilayah Kabupaten/Kota</td>
            </tr>
            <tr>

                <td>Sub Kegiatan</td>
                <td>:</td>
                <td>1.02.03.2.02.0002 Pemenuhan Kebutuhan Sumber Daya Manusia Kesehatan Sesuai Standar</td>
            </tr>
            <tr>
                <td>Aktivitas Sub Kegiatan	</td>
                <td>:</td>
                <td>002 Pembayaran Tunjangan Pegawai Non PNS </td>
            </tr>
          
        </table>
        <!-- <table>
            <tr>
                <td width="250">Uraian Kegiatan	</td>
                <td  width="20">:</td>
                <td>TUNJANGAN HARI RAYA PEGAWAI NON PNS PUSAT KESEHATAN MASYARAKAT CILINCING	</td>
            </tr>
            <tr>
                <td>Unit	</td>
                <td>:</td>
                <td>1.02.0.00.0.00.01.0103 PUSKESMAS CILINCING	</td>
            </tr>
            <tr>
                <td>Tahun Anggaran	</td>
                <td>:</td>
                <td>2025</td>
            </tr>
            <tr>
                <td>Waktu Pelaksanaan</td>
                <td>:</td>
                <td>Januari</td>
            </tr>
            <tr>
                <td>Program</td>
                <td>:</td>
                <td>1.02.03 / Program Peningkatan Kapasitas Sumber Daya Manusia Kesehatan</td>
            </tr>
            <tr>
                <td>Kegiatan	</td>
                <td>:</td>
                <td>1.02.03.2.02 / Perencanaan Kebutuhan dan Pendayagunaan Sumberdaya Manusia Kesehatan				
                untuk UKP dan UKM di Wilayah Kabupaten / Kota	
                </td>
            </tr>
            <tr>
                <td>Sub Kegiatan</td>
                <td>:</td>
                <td>1.02.03.2.02.0002 / Pemenuhan Kebutuhan Sumber Daya Manusia Kesehatan Sesuai Standar</td>
            </tr>
            <tr>
                <td>Aktifitas Sub Kegiatan	</td>
                <td>:</td>
                <td>002 / Pembayaran gaji dan Tunjangan pegawai Non Pns</td>
            </tr>
        </table> -->

        <br> <br>

         <table border="1" cellspacing="5" cellpadding="5" class="table">
            <thead>
                <tr>
                    
                        <th class="text-center">No.</th>
                        <th>Nama</th>
                        <th>Unit/Satuan Kerja/Asal</th>
                        <th class="text-center">No. Handphone / Email</th>
                        
                        <th class="text-center">Tanda Tangan</th>
                        <th class="text-center">No. Rek Bank DKI</th>
                        
                    
                    </tr>
            </thead>
            <tbody>
                
            <?php 

    
                $no = 1;
                foreach ($data_tkd as $peg){

                $nama = $peg->nama;
                $nip = $peg->nip;
                $jabatan = $peg->jabatan;
                $no_rekening = $peg->no_rekening;

                $ttd_spj = $peg->ttd_spj;
               // $status = $peg->status;
                

                $ukpd = $this->Pegawai_model->getNamaPuskesmasByNip($nip);

                if($ttd_spj==''){
                    $btn_ttd = '<span class="badge bg-danger">Belum</span>';
                    $no_hp = '';
               
                }else{
                    $btn_ttd = '<img src="'.base_url().'uploads/ttd_spj/'.$ttd_spj.'" width="150">';
                    $no_hp = $peg->no_hp;
                    
                }
                    
                
                    $mod = $no % 2;

                    echo' <tr>
                                <td class="text-center">'.$no.'</td>
                                <td class="text-left"> '.$nama.'</td>
                                <td class="text-center">'.$ukpd.'</td>
                            
                                <td class="text-center">'.$no_hp.'</td>
                               
                                <td class="text-left" style="font-size:10px;">'.$no.' <br> '.$btn_ttd.'</td>
                                <td class="text-center">'.$no_rekening.'</td>
                                

                            </tr>';

                        $no += 1;

                }

                ?>

            </tbody>
        </table>
    

</div>






    
</body>
</html>