
<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Profile_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function updateProfile(){
		$id_pegawai = $this->session->userdata('id_pegawai');
		$data = array(
			'id_puskesmas' => $this->input->post('id_puskesmas'),
			'id_poli' => $this->input->post('id_poli'),
			'klaster' => $this->input->post('klaster'),
			'jns_jam_kerja' => $this->input->post('jns_jam_kerja'),
			'id_validator' => $this->input->post('id_validator')
		);

		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('mst_pegawai', $data);
		return true;

	}

    function updateProfileDetail(){

		$nip = $this->session->userdata('nip');
		$data = array(
			'no_ktp' => $this->input->post('nik'),
			'no_rekening' => $this->input->post('no_rekening'),
			'npwp' => $this->input->post('npwp'),
			'tempat_lahir' => $this->input->post('kota_lahir'),
            'tgl_lahir' => $this->input->post('tgl_lahir'),
            'no_tlp' => $this->input->post('no_telp'),
            'email' => $this->input->post('email'),
            'alamat_ktp' => $this->input->post('alamat_ktp'),
            'alamat_domisili' => $this->input->post('alamat_domisili'),
		);

		// print_array($data);
		// exit;
		$this->db->where('nip', $nip);
		$this->db->update('detail_pegawai', $data);
		return true;

	}


	
	function getDataDiklat($nip){

		$this->db->order_by('id', 'DESC');
		
		$qry = $this->db->get_where('tbl_diklat', array('nip'=> $nip));
		$row = $qry->result();

		#print_array($row);
		return $row;
	}

	function getDataSIPSTR($nip, $jns_dokumen='sip'){

		$this->db->order_by('id', 'DESC');
		
		$qry = $this->db->get_where('tbl_sip_str', array('nip'=> $nip, 'jns_dokumen'=> $jns_dokumen));
		$row = $qry->result();
		return $row;
	}


	
	function insertSIPSTR($nip, $file_name){
		
		$tanggal_terbit = $this->input->post('tanggal_terbit');
		$tgl_terbit     = format_db($tanggal_terbit);

		$tanggal_expired = $this->input->post('tanggal_expired');
		if($tanggal_expired==''){
			$tgl_kadaluarsa     = '';
		}else{
			$tgl_kadaluarsa     = format_db($tanggal_expired);
		}
		


			$newarray = array(
				'nip' => $nip,
				'tgl_terbit' => $tgl_terbit,
				'tgl_kadaluarsa' => $tgl_kadaluarsa,
				'jns_dokumen' => $this->input->post('jns_dokumen'),
				'file_name' => $file_name,
				'no_sip_str' => $this->input->post('no_sip_str')
			);

			#print_array($newarray);
			$this->db->insert('tbl_sip_str', $newarray);

			return true;
	}


	function insertDiklat($nip, $file_name){
		
		$tanggal_mulai = $this->input->post('tanggal_mulai');
		$tanggal_selesai = $this->input->post('tanggal_selesai');

		$tgl_mulai     = format_db($tanggal_mulai);
		$tgl_selesai = format_db($tanggal_selesai);
		

			$newarray = array(
				'nip' => $nip,
				'tgl_mulai' => $tgl_mulai,
				'tgl_selesai' => $tgl_selesai,
				'judul_pelatihan'=> $this->input->post('judul'),
				'jns_pelatihan' => $this->input->post('jns_diklat'),
				'surtug_sertifikat' => $file_name,
				'lokasi_diklat' => $this->input->post('lokasi')
			);

			#print_array($newarray);
			$this->db->insert('tbl_diklat', $newarray);

			return true;
	}

	function updateDataDiklat($nip, $id){
		
		$tanggal_mulai = $this->input->post('tanggal_mulai');
		$tanggal_selesai = $this->input->post('tanggal_selesai');

		$tgl_mulai     = format_db($tanggal_mulai);
		$tgl_selesai = format_db($tanggal_selesai);
		

			$newarray = array(
				'tgl_mulai' => $tgl_mulai,
				'tgl_selesai' => $tgl_selesai,
				'judul_pelatihan'=> $this->input->post('judul'),
				'jns_pelatihan' => $this->input->post('jns_diklat'),
				'lokasi_diklat' => $this->input->post('lokasi')
			);

			#print_array($newarray);
			$this->db->where('id', $id);
			$this->db->update('tbl_diklat', $newarray);

			return true;
	}


	function updateFileDiklat($id, $fileName){
		$this->db->where('id', $id);
		$this->db->set('surtug_sertifikat', $fileName);
		$this->db->update('tbl_diklat');

		return true;
	}
	
	


    function do_upload($imgName)
	{
		$config['file_name']      = $imgName;
		$config['upload_path']    = './uploads/photo_profile/';
		$config['allowed_types']  = 'gif|jpg|png|';
		$config['max_size']	      = '3000';
		$config['max_width']      = '2500';
		$config['max_height']     = '2000';
		$this->upload->initialize($config);
		$upload = $this->upload->do_upload('imageupload');
		if (!$upload) {
			$data = array('error' => $this->upload->display_errors('', ''));
			$error = $data['error'];
		} else {
			$error = "";
		}
		return $error;
	}



}
