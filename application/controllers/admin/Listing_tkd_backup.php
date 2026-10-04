<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Listing_tkd  extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
        $this->load->model('Laporan_model');
		$this->load->helper('text');
		$this->Auth_model->cekAuthLogin();
	}


	public function index()
	{

        $periode_bulan = $this->session->userdata('periode_bulan'); 
        $periode_tahun = $this->session->userdata('periode_tahun'); 
        $periode = $periode_tahun.'-'.$periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $data['listing_tkd'] = $this->Laporan_model->getListingTKD($periode);

        //$this->load->view('admin/listing_tkd/main', $data);
        $this->load->view('admin/listing_tkd/main_v2', $data);
    }

    public function listing_tkd_lengkap()
	{

        $periode_bulan = $this->session->userdata('periode_bulan'); 
        $periode_tahun = $this->session->userdata('periode_tahun'); 
        $periode = $periode_tahun.'-'.$periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $data['listing_tkd'] = $this->Laporan_model->getListingTKD($periode);

        $this->load->view('admin/listing_tkd/listing_tkd_lengkap', $data);
    }

    public function create_listing_tkd()
	{

        $periode_bulan = $this->session->userdata('periode_bulan'); 
        $periode_tahun = $this->session->userdata('periode_tahun'); 
        $periode = $periode_tahun.'-'.$periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $data['data_tkd'] = $this->Laporan_model->getListingTKD($periode);

        $this->load->view('admin/listing_tkd/create_listing_tkd', $data);
    }
    

    function update_rekap_tkd(){

        $periode = $this->input->post('periode');

        $explod = explode('-',$periode);
        $tahun = $explod[0];
        $bulan = $explod[1];
        $thn_anggrn    = 2024;
        $jumlahHariKerja = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
        $waktu_efektif = $jumlahHariKerja*300;

        $this->db->where('periode', $periode);
        $this->db->delete('ts_rekap_tkd');
        $pegawai = $this->Pegawai_model->getPegawaiforListingTKD( $thn_anggrn );
       
       $dateNow = $periode.'-30';
       # print_array($pegawai );

        $no = 1;
        foreach ($pegawai as $peg){

            $id_pegawai = $peg->id_pegawai;
            $nip = $peg->nip;
            $nama = $peg->nama;
            $jabatan = $peg->jabatan;
            $tmt = $peg->tgl_masuk;

            $npwp = $peg->npwp;
            $no_rekening = $peg->no_rekening;
            $gaji_pokok = $peg->gaji_pokok;
            $pengkalian = $peg->pengkalian;
            $pph21 = $peg->pph21;
            
            $bpjs_kes = $peg->bpjs_kes;
            $bpjs_tk = $peg->bpjs_tk;
            $bpjs_kes = $peg->bpjs_kes;
            $status_kerja = $peg->status_kerja;
           

            $hitungMasaKerja = hitungMasaKerja($dateNow, $tmt);
            $masa_tahun = $hitungMasaKerja['years'];
            $masa_bulan = $hitungMasaKerja['months'];

            $masa_kerja = $masa_tahun.' tahun &nbsp; '.$masa_bulan.' bulan';
            //


            $tkd_pokok = ceil($gaji_pokok*$pengkalian);
            
            $totalAktifitas =  $this->Kinerja_model->getAktifitasApprove($id_pegawai, $periode);
            $rekap_absensi  =  $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
            $jmlh_cuti      =  $this->Presensi_model->getjumlahCuti($id_pegawai, $periode);
            $poinPerilaku     =  $this->Kinerja_model->getPoinPerilaku($id_pegawai, $bulan, $tahun);
            $serapan = SERAPAN;

            if($jmlh_cuti==''){
               $jmlh_cuti = 0;
            }

            $menitPenambah       = $jmlh_cuti*300;
            $nilaiTotalAktifitas = $totalAktifitas+$menitPenambah;

          //  echo $nilaiTotalAktifitas;
           // $nilaiTotalAktifitas = 7000;
            #print_array($rekap_absensi);
            if(empty($rekap_absensi)){
               $telat = 0;
               $pulang_awal = 0;
               $izin = 0;
               $sakit = 0;

               $totalPengurang = $waktu_efektif;
              
            }else{
               $telat = $rekap_absensi[0]->telat;
               $pulang_awal = $rekap_absensi[0]->pulang_awal;
               $izin = $rekap_absensi[0]->izin;
               $sakit = $rekap_absensi[0]->sakit;
               $sakit_dgn_sk = $rekap_absensi[0]->sakit_dgn_sk;

               $menit_izin = $izin*300;
               $menit_sakit = $sakit*300;
               $menit_sakit_dgn_surat = $sakit_dgn_sk*150;

               $totalPengurang = $telat+$pulang_awal+$menit_izin+$menit_sakit+$menit_sakit_dgn_surat;
            }

            $totalWaktuEfektif = $waktu_efektif-$totalPengurang; //total waktu efektif setelah dikurangi menit pengurangik


            $nilaiLebihKecil  =  $totalWaktuEfektif;
            if ($totalWaktuEfektif > $nilaiTotalAktifitas) {
              $nilaiLebihKecil  =  $nilaiTotalAktifitas;
            }


            $bobotAktifitas = ($nilaiLebihKecil/$waktu_efektif)*100;
            $bobotTotal     = round($bobotAktifitas*0.7, 2);

          //  echo $bobotAktifitas;
            $totalCapaian =  number_format($bobotTotal+$poinPerilaku+$serapan,2);
            if($status_kerja == 1) {
              $totalCapaian =  number_format($bobotTotal+$poinPerilaku+$serapan,2);
            }else{
                //cuti bersalin
                $totalCapaian = 50;
            }

            $bruto = round(($tkd_pokok*$totalCapaian)/100);

            if($masa_tahun==0 && $masa_bulan < 4){
                $bruto =  $bruto*0.75;
            }
      


            $pengurang = $pph21+$bpjs_kes+$bpjs_tk;

            $thp = $bruto-$pengurang ;

            if($status_kerja > 0){
                $newRekap[] = array(
                    'periode'=> $periode,
                    'nip'=>$nip,
                    'nama'=>strtoupper($nama),
                    'jabatan'=> $jabatan,
                    'npwp'=> $npwp,
                    'tkd_pokok' => $tkd_pokok,
                    'capaian'=> $totalCapaian,
                    'bruto'=> $bruto,
                    'pph21' => $pph21,
                    'bpjs'=> $bpjs_kes,
                    'bpjs_tk' => $bpjs_tk,
                    'thp'=> $thp,
                    'no_rekening'=> $peg->no_rekening,
                    'masa_kerja' => $masa_kerja ,
                    'urutan'=> $no,
                    'update_on'=> date('Y-m-d H:i:s')
                );
    
            }

            
           
            $no +=1;


        }

        // print_array( $newRekap);

   
        // exit;

        $this->db->insert_batch('ts_rekap_tkd', $newRekap);
        $this->session->set_flashdata('message',' Data berhasil direkap');
     
        redirect('admin/listing_tkd/index');
        //print_array($pegawai);
    }


    function detailCapaianPegawai(){
        $nip = $this->input->post('nip');

        $periode_bulan = $this->session->userdata('periode_bulan'); 
        $periode_tahun = $ta = $this->session->userdata('periode_tahun'); 

        $periode = $periode_tahun.'-'.$periode_bulan;
        $periode = date('Y-m', strtotime($periode));

        $id_pegawai               =   $this->Pegawai_model->getIDpegawaiByNIP($nip, $ta);
        $data['detail_pegawai']   = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
        $data['dataRekap']        = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
        $data['dataTKD']          = $this->Laporan_model->getRekapTKDPegawai($nip, $periode);

        $this->load->view('admin/listing_tkd/detail_capaian_pegawai', $data);
    }

	function detail_capaian($id_pegawai){
		$periode_bulan = $this->session->userdata('periode_bulan'); 
		$periode_tahun = $this->session->userdata('periode_tahun'); 
		$periode = $periode_tahun.'-'.$periode_bulan;
        $periode = date('Y-m', strtotime($periode));

		$data['detail_pegawai']   = $this->Pegawai_model->getDataEditPegawai($id_pegawai);
		$data['dataRekap'] = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		$data['master_cuti'] = $this->Master_model->getlistCuti();
		$this->load->view('admin/capaian_kinerja/detail_capaian', $data);
	}

    function import_file()  {
         

		  $date_now  = date('Ymd_Hi');
		  $file_name = $date_now;

          $jns_file = $this->input->post('jns_file');
          $path = 'pajak';
		 
		  $upload = $this->Master_model->upload_file($file_name, $path);


          $sql = 'DELETE FROM temp_import';
          $this->db->query($sql);

		  
		  if($upload['result'] == "success"){ // Jika proses upload sukses
			// Load plugin PHPExcel nya
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('uploads/'. $path.'/'.$file_name.'.xlsx'); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
		
			// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
			$data = array();
			$numrow = 1;
            $num = 0;
			foreach($sheet as $row){


                if($numrow > 0){
                        $nama       = $row['A'];
                        $jumlah      = $row['B'];
    
                        $jumlah      = str_replace("Rp","", $jumlah);
                        $jumlah      = str_replace(",","", $jumlah);

                        $data[] = array(
                            'nama' => $nama,
                            'jumlah'=> $jumlah,
                            'import_file' => $jns_file

                        );

                      

                    $numrow++; // Tambah 1 setiap kali looping


                }

                $numrow++; // Tambah 1 setiap kali looping
            }
            
            $this->db->insert_batch('temp_import', $data);

             redirect('admin/listing_tkd/list_import');
           // print_array($data);
           

             // echo 'Data pajak berhasil diimport.';
			
		  }else{ // Jika proses upload gagal

            echo  $upload['error'];
			#$this->session->set_userdata('error_msg', $upload['error']); // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			#redirect('admin/swab/error_import');
		  }



    }
    
    function submit_import(){
        
          $qry         = $this->db->get('temp_import');
          $import_data = $qry->result();
          $periode     = '2024-10';
          
          foreach ($import_data as $import){

                    $nama    = $import->nama;
                    $jumlah  = $import->jumlah;
                    $import_file  = $import->import_file;
                  
                    $pegawai = $this->Pegawai_model->getPegawaiByNama($nama);
                    
                    if(!empty($pegawai)){
                        $id_pegawai  = $pegawai[0]->id_pegawai;
                        $nm  = $pegawai[0]->nama;
                        $nip = $pegawai[0]->nip;
                        
                        
                        
                        $this->db->where('nip', $nip);
                        $this->db->where('periode', $periode);
                        $this->db->set($import_file, $jumlah);
                        $this->db->update('ts_rekap_tkd');
                        
                        if($import_file=='bpjs'){
                            $colmn = 'bpjs_kes';
                        }else{
                             $colmn = $import_file;
                        }
                        
                        $this->db->where('id_pegawai', $id_pegawai);
                        $this->db->set($colmn, $jumlah);
                        $this->db->update('gaji_pegawai');


                    }
                                        
          }
          
          echo 'Data berhasil diupdate';
         
         
    }


































    function import_pajak(){
          $data = array(); // Buat variabel $data sebagai array


          $periode = '2024-08';

		  $date_now  = date('Ymd_Hi');
		  $file_name = $date_now;
          $path = 'pajak';
		 
		  $upload = $this->Master_model->upload_file($file_name, $path);
		  
		  if($upload['result'] == "success"){ // Jika proses upload sukses
			// Load plugin PHPExcel nya
			include APPPATH.'third_party/PHPExcel/PHPExcel.php';
			
			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('uploads/'. $path.'/'.$file_name.'.xlsx'); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true ,true);
			
			// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
			$data = array();
			$numrow = 1;
            $num = 0;
			foreach($sheet as $row){


                if($numrow > 0){
                        $nama       = $row['A'];
                        $pajak      = $row['G'];
    
                        $pph21      = str_replace("Rp","", $pajak);
                        $pph21      = str_replace(",","", $pph21);
                        $id_pegawai = $this->Pegawai_model->getIDpegawaiByName($nama);

                      
                     // echo 'Nama :'.$nama.'  - NIP : '.$NIP.' <br> Jumlah :'.$pph21.'<br>';


                        $this->db->where('id_pegawai', $id_pegawai);
                        $this->db->set('pph21', $pph21);
                        $this->db->update('gaji_pegawai');



                    $numrow++; // Tambah 1 setiap kali looping


                }

                $numrow++; // Tambah 1 setiap kali looping
            }

              echo 'Data pajak berhasil diimport.
              <a href="'.base_url().'admin/listing_tkd/update_listing_tkd">Update data</a>';
			
		  }else{ // Jika proses upload gagal

            echo  $upload['error'];
			#$this->session->set_userdata('error_msg', $upload['error']); // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			#redirect('admin/swab/error_import');
		  }

          exit;
    }
    
    
    function list_import(){
        
         $qry = $this->db->get('temp_import');
        
         $data['import_data'] = $qry->result();
         $this->load->view('admin/listing_tkd/import_data', $data);
    }


    function update_listing_tkd(){


        $periode_bulan = $this->session->userdata('periode_bulan');
        $periode_tahun = $this->session->userdata('periode_tahun');
        $periode = $periode_tahun.'-'.$periode_bulan;
        $periode = date('Y-m', strtotime($periode));
        
        
        $periode = '2024-10';

        $listing_tkd  = $this->Laporan_model->getListingTKD($periode);

        foreach ($listing_tkd as $tkd) {
                $id = $tkd->id;
                $bruto = $tkd->bruto;
                $pph21 = $tkd->pph21;
                $bpjs_kes = $tkd->bpjs;
                $bpjs_tk = $tkd->bpjs_tk;

                $potongan = $pph21+$bpjs_kes+$bpjs_tk;
                $thp = $bruto-$potongan;

                $this->db->where('id', $id);
                $this->db->set('thp', $thp);
                $this->db->update('ts_rekap_tkd');


        }

    redirect('admin/listing_tkd/index');
    }

}