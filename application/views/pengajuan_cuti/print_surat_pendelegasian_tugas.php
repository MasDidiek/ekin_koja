<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ekinerja-cilincing | SURAT PENDELEGASIAN TUGAS</title>
</head>

<style>
  table
  {
	  border-collapse:collapse;
	  color:#000;
  }
</style>
<body onLoad="print();">

<?php
$day = date('d');
$year = date('Y');
$buln = date('m');
$bulanNow = getBulan($buln);

?>
<div style="width:1000px; height:auto;  margin:0 auto; font-size:20px; padding:0 10px;">
    
      <div style="width:35%; border:2px solid #666; padding:10px; font-family:Arial; font-size:16px; float:right;">
      	 <table>
              <tr>
                 <td width="110">No. Dokumen</td>
                 <td width="20">:</td>
                 <td>FRM.035/PKC/ADMEN</td>
              </tr>
              <tr>
                 <td>No. Revisi</td>
                 <td>:</td>
                 <td>00</td>
              </tr>
              <tr>
                 <td>Tgl. Terbit</td>
                 <td>:</td>
                 <td>2 Januari 2018</td>
              </tr>
            </table>
      
      </div>

<div style="clear:both"></div>

     <div style="width:130px; height:150px; padding-top:20px; padding-left:20px;  float:left">
        <img src="<?php echo base_url();?>assets/images/logo_dki_black_white.png" width="130">
     </div>
     
      <div style="width:800px; height:160px; background:#FFF; text-align:center; line-height:22px; font-size:20px; padding-top:30px; float:left">
        PEMERINTAH&nbsp;  PROVINSI &nbsp;DAERAH&nbsp; KHUSUS &nbsp;IBUKOTA&nbsp; JAKARTA<br>
        DINAS KESEHATAN<br>
        <strong>PUSAT KESEHATAN MASYARAKAT CILINCING</strong><br>
        <div style="font-family:Arial; font-size:20px; line-height:22px; padding-top:10px;">Jalan Sungai Landak No.26 Jakarta Utara &nbsp; Telepon 021-4418325<br>
        Faksimile : 021-21484022 &nbsp;Email : puskesmas.cilincing@yahoo.com</div>
     
        <div style="width:300px; margin:0 auto; font-weight:bold">J A K A R T A </div>
        <div style="width:150px; text-align:right; margin-top:1px; float:right; ">Kode Pos 14120</div>
     </div>
	
    	<div style="clear:both"></div>
		<hr style="border:2px solid #333">
    <br>
    
    <div style="width:100%; text-decoration:underline; height:50px; font-size:24px;  font-weight:bold; text-align:center;">
		SURAT PENDELEGASIAN TUGAS
	</div>




		<?php
			$id      = $detail_cuti[0]->id;
			$id_pegawai      = $detail_cuti[0]->id_pegawai;
			$tgl      		 = $detail_cuti[0]->tgl;
			
			
			
			$tgl_dari      		 = $detail_cuti[0]->tgl_dari;
			$tgl_sampai       = $detail_cuti[0]->tgl_sampai;
			$alamat_cuti       = $detail_cuti[0]->alamat_cuti;
			$no_tlp       = $detail_cuti[0]->no_tlp;
			$hari_cuti        = $detail_cuti[0]->hari_cuti ;
			$alasan        = $detail_cuti[0]->alasan_cuti ;
			$jns_cuti      = $detail_cuti[0]->jns_cuti ;
			$id_pengganti      = $detail_cuti[0]->id_pengganti;
			$delegasi_tugas   = $detail_cuti[0]->delegasi_tugas;
		
			$split = explode('<br>', $delegasi_tugas);

	
			
			$detPengaju      = $this->Ekin_model->getEditPegawai($id_pegawai);
			$namaPengaju     = $detPengaju[0]->nama;
			$nipPengaju      = $detPengaju[0]->nip;
			$nama_jabatan    = $detPengaju[0]->nama_jabatan;
			$id_validator    = $detPengaju[0]->id_validator;
			
			$jenis_cuti 		= $this->master_model->getNamaCuti($jns_cuti);
			$detPengganti = $this->Ekin_model->getEditPegawai($id_pengganti);
			$namaPengg    = $detPengganti[0]->nama;
			$nipPengg     = $detPengganti[0]->nip;
			$nama_jabatanPengg     = $detPengganti[0]->nama_jabatan;
			
			$detValidator = $this->master_model->getDetValidator($id_validator);
			
			//print_array($detValidator);
			$namaValidator    = $detValidator[0]->nama;
			$nipValidator    = $detValidator[0]->nip;
			$keterangan    = $detValidator[0]->keterangan;
			
		
			if($hari_cuti==1)
			{
				$tgl_cuti = format_view($tgl_dari) ;
			}else{
				$tgl_cuti = format_view($tgl_dari).' s/d '. format_view($tgl_sampai) ;
			}
			
			$sisaCuti  = $myCuti[0]->total;
?>

		<div style="width:85%; height:auto; margin:0 auto; line-height:24px; font-size:19px;">
            Yang bertanda tangan dibawah ini :<Br><br>
            <table>
              <tr>
                 <td width="210">Nama</td>
                 <td width="20">:</td>
                 <td><?php echo $namaPengaju;?></td>
              </tr>
              <tr>
                 <td>NIP</td>
                 <td>:</td>
                 <td><?php echo $nipPengaju;?></td>
              </tr>
               <tr>
                 <td>Unit Kerja</td>
                 <td>:</td>
                 <td>Puskesmas Kecamatan Cilincing</td>
              </tr>
       
              <tr>
                 <td>Jabatan</td>
                 <td>:</td>
                 <td><?php echo $nama_jabatan;?></td>
              </tr>
             
             
            </table>
            
           <p> 
            	Menyatakan tidak dapat melaksanakan tugas sebagai......<strong><?php echo $nama_jabatan;?></strong>...... pada: 
            </p>		
            
             <table>
             <tr>
                 <td width="210">Hari/Tanggal</td>
                 <td width="20">:</td>
                 <td><?php echo $tgl_cuti;?></td>
              </tr>
              <tr>
                 <td>Dikarenakan</td>
                 <td>:</td>
                 <td><?php echo $alasan;?></td>
              </tr>
             
              
              </table>
              
              
              <p>Demi Kelancaran pelaksanaan tugas tersebut, saya mendelegasikan pelaksanaan tugas beserta kewenangan kepada :</p>
              
              
             <table>
             <tr>
                 <td width="210">Nama</td>
                 <td width="20">:</td>
                 <td><?php echo $namaPengg;?></td>
              </tr>
              <tr>
                 <td>NIP</td>
                 <td>:</td>
                 <td><?php echo $nipPengg;?></td>
              </tr>
             <tr>
                 <td>Unit Kerja</td>
                 <td>:</td>
                 <td>Puskesmas Kecamatan Cilincing</td>
              </tr>
              <tr>
                 <td>Jabatan</td>
                 <td>:</td>
                 <td><?php echo $nama_jabatanPengg;?></td>
              </tr>
              
            
            </table>
            
           
            <p>
            Adapun tugas-tugas yang saya limpahkan tersebut adalah sebagai berikut
            </p>
            
            <ul>
            <?php
			 for($d=0; $d < count($split); $d++)
			 {
				 $tugas = $split[$d];
				 
				 if($tugas <> '')
				 {
					  echo '<li style="list-style:none"> '.($d+1).'. &nbsp; '. $split[$d].'</li>';
				 }
				
			 }
			 
			?>
           
            </ul> 
             <div style="clear:both"></div>
             
            <p>  Demikianlah surat pendelegasian ini saya buat dengan sungguh-sungguh. </p>
          
             <p>&nbsp;</p>
             
             <div style="width:30%;  text-align:center; height:auto; float:left;">
             <br>
             	<p>Penerima Delegasi	</p>
                
                
                <p>&nbsp;</p> <p>&nbsp;</p>
                <p>(&nbsp; <?php echo ucwords(strtolower($namaPengg));?> &nbsp;) </p>	
             
             </div>
             
             	<div style="width:37%; float:left;  text-align:center; height:auto; ">
                     <br>
                     <p>&nbsp;</p> <p>&nbsp;</p><p>&nbsp;</p>
                        <p>Mengetahui <?php echo $keterangan;?></p>
                        
                        
                    <p>&nbsp;</p> <p>&nbsp;</p>
                    <p>(&nbsp;.........................................................&nbsp;) </p>	
                 
                 </div>
             
             
              <div style="width:30%;  text-align:center; float:right; height:auto;">
              Jakarta, &nbsp;  <?php echo $day;?>  <?php echo getBulan($buln);?>  <?php echo $year;?>
             	<p>Yang Mendelegasikan	</p>
                
                
                <p>&nbsp;</p> <p>&nbsp;</p>
                <p>(&nbsp; <?php echo ucwords(strtolower($namaPengaju));?>&nbsp; ) </p>	
             
             </div>
             
             <div style="clear:both"></div>
             
           	<center>  
                     
             </center>
             
             
                <p>&nbsp;</p> 						   
			</div>

    
    
</div>


</body>
</html>
