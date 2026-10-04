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
  .coret{
	  text-decoration:line-through;
  }
  td{
	  font-size:17px;
  }
</style>
<body onLoad="print();">
<?php
$day = date('d');
$year = date('Y');
$buln = date('m');
$bulanNow = getBulan($buln);
?>
<div style="width:1000px; height:auto;  margin:0 auto; font-size:20px; padding:0 20px;">

		<?php
		
		
		//print_array($detail_cuti);
			$id      = $detail_cuti[0]->id;
			$id_pegawai      = $detail_cuti[0]->id_pegawai;
			$tgl      		 = $detail_cuti[0]->tgl;
			
			
			
			$tgl_dari      		 = $detail_cuti[0]->tgl_dari;
			$tgl_sampai       = $detail_cuti[0]->tgl_sampai;
			$alamat_cuti       = $detail_cuti[0]->alamat_cuti;
			$no_tlp       = $detail_cuti[0]->no_tlp;
			
			$alasan        = $detail_cuti[0]->alasan_cuti ;
			$jns_cuti      = $detail_cuti[0]->jns_cuti ;
			$id_pengganti      = $detail_cuti[0]->id_pengganti;
			
			//echo $jns_cuti;
	
	
			$myCuti    = $this->master_model->getMasterCutiPegawai($id_pegawai);
			
			$sisa_cuti =  $myCuti[0]->sisa_cuti;
			$cuti_tahunan =  $myCuti[0]->cuti_tahunan;
			
			$detPengaju      = $this->Ekin_model->getEditPegawai($id_pegawai);
			
			$namaPengaju     = $detPengaju[0]->nama;
			$nipPengaju      = $detPengaju[0]->nip;
			$nama_jabatan    = $detPengaju[0]->nama_jabatan;
			$id_validator    = $detPengaju[0]->id_validator;
			$puskesmas_unit_kerja    = $detPengaju[0]->puskesmas;
			
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
			
			if($jns_cuti < 5){
				//cuti tahunan, sisa cuti
				$hari_cuti        = $detail_cuti[0]->hari_cuti ;
				$kethari  = '(hari/<span class="coret"> bulan/tahun </span>)';
				$kethari2 = 'hari';
			}else{
				//cuti melahirkan
				$hari_cuti        = 3;
				$kethari  = '(<span class="coret">hari</span>/bulan / <span class="coret">tahun </span>)';
				$kethari2 = 'bulan';
			}
		
			
			$sisaCuti  = $myCuti[0]->total;
?>
		
             
                 
  <?php
$day = date('d');
$year = date('Y');
$buln = date('m');
$bulanNow = getBulan($buln);

?>

		<?php
			$id      = $detail_cuti[0]->id;
			$id_pegawai      = $detail_cuti[0]->id_pegawai;
			$tgl      		 = $detail_cuti[0]->tgl;
			
			
			
			$tgl_dari      		 = $detail_cuti[0]->tgl_dari;
			$tgl_sampai       = $detail_cuti[0]->tgl_sampai;
			$alamat_cuti       = $detail_cuti[0]->alamat_cuti;
			$no_tlp       = $detail_cuti[0]->no_tlp;
		
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
			
			//khusus yang validator RB kalibaru dialihkan ke kepala puskesmas
			if($id_validator==436){
			    $id_validator=437;
			}
			
			$chekCutiTahunan = '';
			$chekCutiMelahirkan = '';
			
			
			if($jenis_cuti==5){
			    $chekCutiMelahirkan = 'v';
			}else{
			   $chekCutiTahunan= 'v';
			}
			
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


<div style="width:1000px; height:auto; border:1px solid #EEE; margin:0 auto; padding:0 20px;">
 <table  width="100%" cellpadding="5">
 		<td width="60%">&nbsp;</td>
        <td width="40%" style="font-size:18px">
          Lampiran II<br>
          Peraturan Gubernur Provinsi Daerah Khusus Ibukota Jakarta<br>
          Nomor 13 TAHUN 2018 <br>
          Tanggal 26 Februari 2019 <br>
          
          <p>
             Jakarta, <?php echo $day;?> <?php echo $bulanNow;?> <?php echo $year;?><br>
             Kepada :
             Yth. Kepala Puskesmas Kec. Cilincing<br>
             di<br>
             Tempat
          
          </p>
        </td>
 </table>
 
 
  <table border="1" width="100%" cellpadding="5">
            
            <tr>
                    <td align="center"  colspan="4"><strong>FORMULIR PERMINTAAN DAN PEMBERIAN CUTI</strong></td>
            </tr>
            
            <tr>
                    <td align="left" colspan="4"><strong>1. DATA PEGAWAI</strong></td>
            </tr>
             <tr>
                    <td align="left"><strong>Nama</strong></td>
                    <td align="left"><?php echo $namaPengaju;?></td>
                    <td align="left"><strong>NIP</strong></td>
                    <td align="left"><?php echo $nipPengaju;?></td>
            </tr>
            <tr>
                    <td align="left"><strong>Jabatan</strong></td>
                    <td align="left"><?php echo $nama_jabatan;?></td>
                    <td align="left"><strong>Masa Kerja</strong></td>
                    <td align="left"></td>
            </tr>
            <tr>
                    <td align="left"><strong>Unit Kerja</strong></td>
                    <td align="left" colspan="3"><?php echo $puskesmas_unit_kerja;?></td>
 
            </tr>
    
    
    </table>
    
   <br>
     <table border="1" width="100%" cellpadding="5" style="font-size:16px">
  
            
            <tr>
                    <td align="left" colspan="4"><strong>II. JENIS CUTI YANG DIAMBIL</strong></td>
            </tr>
             <tr>
                    <td align="left" width="300">1. Cuti Tahunan</td>
                    <td align="center"><?php echo $chekCutiTahunan;?></td>
                    <td align="left"  width="300">3. Cuti Sakit</td>
                    <td align="center"></td>
            </tr>
            <tr>
                    <td align="left">2. Cuti Besar</td>
                    <td align="center"></td>
                    <td align="left">4. Cuti Melahirkan</td>
                    <td align="center"><?php echo $chekCutiMelahirkan;?></td>
            </tr>
            
             <tr>
                    <td align="left">5. Cuti Karena Alasan Penting</td>
                    <td align="center"></td>
                    <td align="left">6. Cuti di Luar Tanggungan Negara</td>
                    <td align="center"></td>
            </tr>
            
    
    
    </table>
    
    <br>
     <table border="1" width="100%" cellpadding="5">
  
            
            <tr>
                    <td align="left" colspan="4"><strong>III. ALASAN CUTI</strong></td>
            </tr>
             <tr>
                    <td align="left" colspan="4"> <?php echo $alasan;?></td>    
            </tr>
           
    </table>
    
     
    <br>
     <table border="1" width="100%" cellpadding="5">
  
            
            <tr>
                    <td align="left" colspan="6"><strong>IV. LAMANYA CUTI</strong></td>
            </tr>
            
             <tr>
                    <td align="left">Selama</td>
                    <td align="left"><strong><?php echo $hari_cuti .' '.$kethari2;?></strong> </td>
                    <td align="left">Mulai Tanggal</td>
                    <td align="left"><strong><?php echo format_slash($tgl_dari);?></strong></td>
                    <td align="left">s/d</td>
                    <td align="left"><strong><?php echo format_slash($tgl_sampai);?></strong></td>
            </tr>
           
    </table>
    
    <br>
     <table border="1" width="100%" cellpadding="5" style="font-size:16px">
  
            
            <tr>
                    <td align="left" colspan="6"><strong>V. CATATAN CUTI ***</strong></td>
            </tr>
            
             <tr>
                    <td align="left" colspan="3">1. CUTI TAHUNAN</td>
                    <td align="left">2. CUTI BESAR </td>
                    <td align="left" width="100"></td>
  
            </tr>
             <tr>
                    <td align="center">Tahun</td>
                    <td align="center">Sisa </td>
                    <td align="center">Keterangan</td>
                    <td align="left">3. CUTI SAKIT </td>
                    <td align="left"></td>
  
            </tr>
             <tr>
                    <td align="left">N-2</td>
                    <td align="left"> </td>
                    <td align="left"></td>
                    <td align="left">4. CUTI MELAHIRKAN </td>
                    <td align="left"></td>
  
            </tr>
            <tr>
                    <td align="left">N-1</td>
                    <td align="center"><?php echo $sisa_cuti;?> </td>
                    <td align="left"></td>
                    <td align="left">5. CUTI KARENA ALASAN PENTING </td>
                    <td align="left"></td>
  
            </tr>
             <tr>
                    <td align="left">N</td>
                    <td align="center"><?php echo $cuti_tahunan;?></td>
                    <td align="left"></td>
                    <td align="left">6. CUTI DILUAR TANGGUNGAN NEGARA </td>
                    <td align="left"></td>
  
            </tr>
   
    </table>
    
     <br>
     <table border="1" width="100%" cellpadding="5">
  
            
            <tr>
                    <td align="left" colspan="6"><strong>VI. ALAMAT SELAMA MENJALANKAN CUTI</strong></td>
            </tr>
            
             <tr>
                    <td align="left" width="50%"><?php echo $alamat_cuti;?></td>
                    <td align="left">TELP</td>
                    <td align="left"><?php echo $no_tlp;?></td>
            </tr>
             <tr>
                    <td align="center">
                    	Pengganti<br>
                        <p>&nbsp;</p>
                        
                     
                        	<?php echo $namaPengg;?><br>
                           <?php echo $nipPengg;?>
                           <br>
                    </td>
                    <td align="center" colspan="2">
                    
                    
                                    Hormat Saya<br>
                                    <p>&nbsp;</p>
                                    
                               
										<?php echo $namaPengaju;?><br>
                                       <?php echo $nipPengaju;?>
                                      <br>
                    </td>
            </tr>
           
    </table>
    
    <br>
    
     <table border="1" width="100%" cellpadding="5">
  
            
            <tr>
                    <td align="left" colspan="6"><strong>VII. PERTIMBANGAN ATASAN LANGSUNG **</strong></td>
            </tr>
            
             <tr>
                    <td align="left">DISETUJUI</td>
                    <td align="left">PERUBAHAN ****</td>
                    <td align="left">DITANGGUHKAN ****</td>
                    <td align="left">TIDAK DISETUJUI ****</td>
                   
            </tr>
            
             <tr>
                    <td align="left" colspan="3"><P>&nbsp;</P></td> 
                    <td align="center">
                    		<P>&nbsp;</P>
                        <br>
                      <?php echo $namaValidator;?><br>
                       <?php echo $nipValidator;?>
                        
                    </td>
                   
            </tr>
           
    </table>
    
    <br>
    <table border="1" width="100%" cellpadding="5">
  
            
            <tr>
                    <td align="left" colspan="6"><strong>VIII. PERTIMBANGAN PEJABAT YANG BERWENANG MEMBERIKAN CUTI **</strong></td>
            </tr>
            
             <tr>
                    <td align="left">DISETUJUI</td>
                    <td align="left">PERUBAHAN ****</td>
                    <td align="left">DITANGGUHKAN ****</td>
                    <td align="left">TIDAK DISETUJUI ****</td>
                   
            </tr>
          
             <tr>
                    <td align="left" colspan="3"><P>&nbsp;</P></td> 
                    <td align="center">
                    		<P>&nbsp;</P>
                        <br>
                        dr. Dian Anggrainy<br>
                        NIP. 197304112006042015
                        
                    </td>
                   
            </tr>
           
    </table>
    
    <br>
    
     <table  width="100%" cellpadding="5">
 		<tr>
        	<td width="60">*</td>
            <td>Coret yang tidak perlu</td>
        </tr>
        <tr>
        	<td>**</td>
            <td>Pilih salah satu dengan memberi tanda centang (&radic;)</td>
        </tr>
        <tr>
        	<td>***</td>
            <td>Diisi oleh pejabat yang menangani bidang kepegawaian sebelum non PNS mengajukan cuti</td>
        </tr>
        <tr>
        	<td>****</td>
            <td>Diberi tanda centang dan alasan</td>
        </tr>
        
 </table>
    
</div>
    
    
</div>
</body>
</html>
