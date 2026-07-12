<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Caten_model extends CI_Model
{
	function __construct()
	{
        parent::__construct();
		
    }
	
	function getMasterEdit($table, $colm, $id)
	{
			 
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where($colm, $id);
		$query  = $this->db->get();
		$data   = $query->result();
		
		return $data;
	}
	
	
	public function cekValidasiData($nik, $tanggal)
	{
		$this->db->select('*');
		$query = $this->db->get_where('mst_calon_pengantin', array('nik'=> $nik, 'tgl_lahir'=> $tanggal));
		$data  = $query->result();
		return $data;

	}

            
	function detailCatin($id){
	    
	    $this->db->select('a.*, b.nama AS nama_pasangan, b.nik as nik_pasangan, b.tgl_lahir as tgl_lahir_pasangan, 
	    b.gender as gender_pasangan, b.no_hp as hp_pasangan, b.status_kawin as status_pasangan, b.no_surat as no_surat_pasangan,
	    b.id_provinsi as id_prov, b.id_kota as id_kota_pasangan, b.id_kecamatan as id_kec, b.id_kelurahan as id_kel, b.kode_pos as kode_pos_pasangan, b.ktp as ktp_pasangan, b.suket_rt as suket_pasangan, b.alamat_lengkap as alamat_pasangan, b.alamat_domisili as domisili_pasangan');
		$this->db->from('mst_calon_pengantin a');
		$this->db->join('mst_pasangan_calon b', 'a.id = b.id_calon', 'left');
		$this->db->where('a.id', $id);
		$query  = $this->db->get();
		$data   = $query->result();
		
		return $data;
	    
	}

	public function getSelfReportingCatin($nik)
	{
		$this->db->select('*');
		$query = $this->db->get_where('ts_self_reporting', array('nik'=> $nik));
		$data  = $query->result();
		return $data;
	}



	function getAmnensisUmum($nik)
	{
		$this->db->select('*');
		$query = $this->db->get_where('ts_self_reporting', array('nik'=> $nik));
		$data  = $query->result();
		return $data;
	}

	function insertTblSelfReporting($nik, $pertanyaan, $jawaban){
		$array = array(
			'nik' => $nik,
			'id_pertanyaan' => $pertanyaan,
			'jawaban' => $jawaban
		);

		#print_array($array);
		$this->db->insert('ts_self_reporting', $array);
		return true;

	}

	function insertTblAmnensiUmum($nik){
		$array = array(
			'nik' => $nik,
			'merokok' => $this->session->userdata('merokok'),
			'makanan_lemak' => $this->session->userdata('makanan_lemak'),
			'olahraga_rutin' => $this->session->userdata('olahraga_rutin'),
			'alkohol' => $this->session->userdata('alkohol'),
			'obat_kb' => $this->session->userdata('obat_kb'),
			'nama_obat_kb' => $this->session->userdata('nama_obat_kb'),
			'hpht' => $this->session->userdata('hpht'),
			'haid_teratur' => $this->session->userdata('haid_teratur'),
			'durasi_haid' => $this->session->userdata('durasi_haid'),
			'sakit_saat_haid' => $this->session->userdata('sakit_haid'),
			'pembalut_perhari' => $this->session->userdata('pembalut_perhari'),
			'trauma' => $this->session->userdata('trauma'),
			'nama_trauma' => $this->session->userdata('nama_trauma'),
			'gondongan' => $this->session->userdata('gondongan'),
			'kronis_keluarga' => $this->session->userdata('peny_kronis'),
			'nama_penyakit_kronis' => $this->session->userdata('nama_penyakit')
		);
		#print_array($array);
		$this->db->insert('tbl_anamnesis_umum', $array);
		return true;

	}

	function insertTblAmnensiTambahan($nik){
		$array = array(
			'nik' => $nik,
			'tunda_kehamilan' => $this->session->userdata('tunda_hamil'),
			'skrining_tt' => $this->session->userdata('tgl_tt_terakhir'),
			'pendidikan_terakhir' => $this->session->userdata('pendidikan_terakhir'),
			'bekerja' => $this->session->userdata('bekerja'),
			'jns_pekerjaan' => $this->session->userdata('jns_pekerjaan'),
			'lokasi_kerja' => $this->session->userdata('lokasi'),
			'seks_pranikah' => $this->session->userdata('seks_pranikah'),
			'napza' => $this->session->userdata('napza'),
			'riwayat_organ_reproduksi' => $this->session->userdata('resiko_reproduksi'),
			'prlku_seks_beresiko' => $this->session->userdata('perilaku_seks'),
			'kemungkian_hamil' => $this->session->userdata('kemungkinan_hamil'),
			'usia_kehamilan' => $this->session->userdata('usia_hamil'),
			'kemungkian_hiv' => $this->session->userdata('kemungkinan_hiv'),
			'kekerasan_seks' => $this->session->userdata('kemungkinan_kekerasan_seks')
		);
		#print_array($array);
		$this->db->insert('tbl_anamnesis_tambahan', $array);
		return true;

	}

	
	function insertTblInfoLain($nik){
		$array = array(
			'nik' => $nik,
			'alasan_menikah_remaja' => $this->session->userdata('kehendak_menikah'), //alasan menikah remaja
			'usia_pertama_kali_nikah' => $this->session->userdata('usia_pert_nikah'),
			'lama_pernikahan' => $this->session->userdata('lama_pernikahan'),
			'jumlah_anak' => $this->session->userdata('jml_anak_nikah'),
			'jarak_anak' => $this->session->userdata('jarak_anak'),
			'status_kes_seblm' => $this->session->userdata('kes_pasangan'), #status Kesehatan Pasangan Sebelumnya, sehat, tidak?
			'riwayat_peny_pasangan' => $this->session->userdata('riw_peny_pasangan'), 
			'perilaku_seks_beresiko' => $this->session->userdata('perilaku_seks_resiko'),
			'riwayat_kehamilan' => $this->input->post('riwa_kehamilan'),
			'riwayat_persalinan' => $this->input->post('riwa_persalinan'),
			'riwayat_kontrasepsi' => $this->input->post('riwa_kontrasepsi')
		);

		#print_array($array);
		$this->db->insert('tbl_info_catin_lain', $array);
		return true;

	}





    function getlistProvinsi()
	{	 
		$this->db->select('*');
		$this->db->from('provinsi');
		$query  = $this->db->get();
		$data   = $query->result();
		
		return $data;
	}


    function getlistKota($id_provinsi)
	{	 
        $this->db->where('id_provinsi', $id_provinsi);
		$this->db->select('*');
		$this->db->from('kota');
		$query  = $this->db->get();
		$data   = $query->result();
		
		return $data;
	}

    function getlistKecamatan($id_kota)
	{	 
        $this->db->where('id_kota', $id_kota);
		$this->db->select('*');
		$this->db->from('kecamatan');
		$query  = $this->db->get();
		$data   = $query->result();
		
		return $data;
	}
    

    function getlistKelurahan($id_kecamatan)
	{	 
        $this->db->where('id_kecamatan', $id_kecamatan);
		$this->db->select('*');
		$this->db->from('mst_kelurahan');
		$query  = $this->db->get();
		$data   = $query->result();
		
		return $data;
	}
	
	
	function getIDCalonByNIK($nik){
	    
	  
	    $this->db->where('nik', $nik);
		$this->db->select('id');
		$this->db->from('mst_calon_pengantin');
		$query  = $this->db->get();
		$data   = $query->result();
		
		
		
	//	print_array($data);
		if(!empty($data)){
		    
		    $id = $data[0]->id;
		}else{
		    $id = 0;
		}
		
		return $id;
	}
	
	 function uploadImage($file_name_ktp, $path, $Image, $Image_temp,  $input_name)
	   {
		
	        $config['file_name']      = $file_name_ktp.'_temp';
            $config['upload_path']    = './uploads/'.$path.'/';
            $config['allowed_types']  = 'jpg|png|JPG|jpeg|';
            $config['max_size']	      = '500';
            $config['max_width']      = '2000';
            $config['max_height']     = '2000';
            $this->upload->initialize($config);
            
            if(!$this->upload->do_upload($input_name)) 
            {
                $data = array('error' => $this->upload->display_errors('',''));	
                $error = $data['error'];
                //$this->session->set_flashdata('error_upload', $error);
                
                return $error;
               
            }else{
                #delete temp image
                $fileImage_temp 	= './uploads/'.$path.'/'.$Image_temp;
                if (file_exists($fileImage_temp)){unlink($fileImage_temp);}
                #delete image exis
                $fileImage 	= './uploads/'.$path.'/'.$Image;
                if (file_exists($fileImage) && $Image!= ''){unlink($fileImage);}
                #second upload with no error, not necessary to make a condition error upload image
                $config['file_name']      = $file_name_ktp; // initialization new config file_name 
                $this->upload->initialize($config);
                $this->upload->do_upload($input_name);			
                #close upload image =========================================================================		
              
                
               return 'success';
            }
	}
	
	
	
		
    
    

}


?>