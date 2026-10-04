<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Ekinerja-cilincing</title>
</head>
<style>
  table
  {
	  border-collapse:collapse;
	  color:#000;
  }
</style>
<body onLoad="print();" >
<?php
$day = date('d');
$year = date('Y');
$buln = date('m');
$bulanNow = getBulan($buln);
?>
<div style="width:1000px; height:auto;  margin:0 auto; font-size:20px; padding:0 20px;">
     <div style="width:140px; height:140px; padding-top:20px; padding-left:20px;  float:left">
        <img src="<?php echo base_url();?>assets/images/logo_dki_black_white.png" width="140">
     </div>
     
      <div style="width:800px; height:170px; background:#FFF; text-align:center; line-height:28px; font-size:24px; padding-top:30px; float:left">
        PEMERINTAH&nbsp;  PROVINSI &nbsp;DAERAH&nbsp; KHUSUS &nbsp;IBUKOTA&nbsp; JAKARTA<br>
        DINAS KESEHATAN<br>
        <strong>PUSAT KESEHATAN MASYARAKAT CILINCING</strong><br>
        <div style="font-family:Arial; font-size:20px; line-height:22px; padding-top:10px;">Jalan Sungai Landak No.26 Jakarta Utara &nbsp; Telepon 021-4418325<br>
        Faksimile : 021-21484022 &nbsp;Email : puskesmas.cilincing@yahoo.com</div>
        
        <strong>J A K A R T A </strong>
     </div>
	
    	<div style="clear:both"></div>
		<hr style="border:2px solid #333">
    <br>
    
    <div style="width:100%; text-decoration:underline; height:50px; font-size:24px;  font-weight:bold; text-align:center;">
		LEMBAR PERMOHONAN CUTI
	</div>
<p>&nbsp;</p>
		<?php
		
		
		//print_array($detail_cuti);
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
	
	
	
			
			$detPengaju      = $this->Ekin_model->getEditPegawai($id_pegawai);
			
			$namaPengaju     = $detPengaju[0]->nama;
			$nipPengaju      = $detPengaju[0]->nip;
			$nama_jabatan    = $detPengaju[0]->nama_jabatan;
			$id_validator    = $detPengaju[0]->id_validator;
			
			$jenis_cuti 		= $this->master_model->getNamaCuti($jns_cuti);
			$detPengganti 		= $this->Ekin_model->getEditPegawai($id_pengganti);
			$namaPengg    		= $detPengganti[0]->nama;
			$nipPengg    		= $detPengganti[0]->nip;
			$nama_jabatanPengg  = $detPengganti[0]->nama_jabatan;
			
			$detValidator = $this->master_model->getDetValidator($id_validator);
			
			//print_array($detValidator);
			$namaValidator    = $detValidator[0]->nama;
			$nipValidator    = $detValidator[0]->nip;
			$keterangan    = $detValidator[0]->keterangan;
			
			
		
			
			$sisaCuti  = $myCuti[0]->total;
?>
		<div style="width:85%; height:auto; margin:0 auto; line-height:30px; font-size:22px;">
            Yang bertanda tangan dibawah ini :<Br><br>
            <table>
              <tr>
                 <td width="210">Nama</td>
                 <td width="20">:</td>
                 <td><?php echo $namaPengaju;?></td>
              </tr>
              <tr>
                 <td>NIP/NRK</td>
                 <td>:</td>
                 <td><?php echo $nipPengaju;?></td>
              </tr>
              <tr>
                 <td>Pangkat/Golongan</td>
                 <td>:</td>
                 <td>-</td>
              </tr>
              <tr>
                 <td>Jabatan</td>
                 <td>:</td>
                 <td><?php echo $nama_jabatan;?></td>
              </tr>
              <tr>
                 <td>Satuan Organisasi</td>
                 <td>:</td>
                 <td>Puskesmas Kecamatan Cilincing</td>
              </tr>
             
            </table>
            
           <p> 
            	Mengajukan permohonan dengan pengganti cuti :
            </p>		
            
            
             <table>
             <tr>
                 <td width="210">Nama</td>
                 <td width="20">:</td>
                 <td><?php echo $namaPengg;?></td>
              </tr>
              <tr>
                 <td>NIP/NRK</td>
                 <td>:</td>
                 <td><?php echo $nipPengg;?></td>
              </tr>
              <tr>
                 <td>Pangkat/Golongan</td>
                 <td>:</td>
                 <td>-</td>
              </tr>
              <tr>
                 <td>Jabatan</td>
                 <td>:</td>
                 <td><?php echo $nama_jabatanPengg;?></td>
              </tr>
              <tr>
                 <td>Satuan Organisasi</td>
                 <td>:</td>
                 <td>Puskesmas Kecamatan Cilincing</td>
              </tr>
            
            
            </table>
            <p>
            Selama ....<strong><?php echo $hari_cuti ;?></strong> ...(hari/<span style="text-decoration:line-through"> bulan/tahun </span>), 
            mulai tanggal    ....<strong><?php echo format_slash($tgl_dari);?></strong>....s/d ....<strong><?php echo format_slash($tgl_sampai);?></strong>....dengan
             alasan ..<strong><?php echo $alasan ;?></strong>..  selama menjalankan cuti berada di .<strong><?php echo $alamat_cuti ;?></strong>..
              No Telp/Hp yang dapat dihubungi ....<strong><?php echo $no_tlp ;?></strong>...
            </p>
            
            <p>&nbsp;</p>
            <p>Demikianlah surat pengajuan ini dibuat, atas perhatiannya diucapkan terima kasih.</p>
            
             <p>&nbsp;</p> <p>&nbsp;</p>
             
        
        
        	
             <div style="width:30%;  text-align:center; height:auto; float:left;">
             <br>
             	<p>Yang mengajukan</p>
                
                
                <p>&nbsp;</p> <p>&nbsp;</p>
                <p>(&nbsp; <?php echo ucwords(strtolower($namaPengaju));?>&nbsp; ) </p>	
             
             </div>
             
             	<div style="width:37%; float:left;  text-align:center; height:auto; ">
                     <br>
                     <p>&nbsp;</p> <p>&nbsp;</p><p>&nbsp;</p>
                        <p>Mengetahui <?php echo $keterangan;?><br>
                        	</p>
                        
                        
                    <p>&nbsp;</p> <p>&nbsp;</p>
                    <p>(&nbsp;<?php echo $namaValidator;?>&nbsp;) <br>
                   		<?php echo $nipValidator;?>
                    </p>	 
                 
                 </div>
             
             
              <div style="width:32%;  text-align:center; float:right; height:auto;">
              Jakarta, &nbsp;  <?php echo $day;?>  <?php echo getBulan($buln);?>  <?php echo $year;?>
             	<p>Pengganti</p>
                
                
                <p>&nbsp;</p> <p>&nbsp;</p>
                <p>(&nbsp; <?php echo ucwords(strtolower($namaPengg));?>&nbsp; ) </p>	
             
             </div>
             
             <div style="clear:both"></div>
             
                <p>&nbsp;</p> 						   
			</div>
    
    
</div>
</body>
</html>
