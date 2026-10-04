<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Register extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();

		$this->load->helper('form');
		$this->load->helper('text');

	}



	function index()
	{

        $this->load->view('register/main');
    }

	function set_session()
	{

		$nama = $this->input->post('nama');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		//$md5_pass = md5($password);
		$newSession = array(
			'nama' => $nama,
			'email' => $email,
			'password' => $hashed_password
		);

		$this->session->set_userdata($newSession);
       redirect('register/step2');
    }


	function step2() {




		$data['list_jabatan'] 	   = $this->Master_model->getlistJabatan();
		$data['list_pendidikan']   = $this->Master_model->getlistPendidikan();
		$data['list_poli'] 		   = $this->Master_model->getlistPoli();
		$data['list_puskesmas']    = $this->Master_model->getlistPuskesmas();
		$data['list_Status']       = $this->Master_model->getlistStatus();
		$data['list_validator']    = $this->Pegawai_model->getValidator();

		$this->load->view('register/step2', $data);
	}

	function save(){



		$nip = $this->input->post('nip');
		$tgl_masuk = $this->input->post('tmt');
		$jns_pegawai = $this->input->post('jns_pegawai');


		$ket_jab = $this->input->post('ket_jab');

		$id_pendidikan = $this->input->post('id_pendidikan');
		$validator = $this->input->post('validator');
		$jam_kerja = $this->input->post('jam_kerja');
		$no_tlp = $this->input->post('no_tlp');
		$email = $this->input->post('email');
		$tempat_lahir = $this->input->post('tempat_lahir');
		$tgl_lahir = $this->input->post('tgl_lahir');

		$no_ktp = $this->input->post('no_ktp');
		$npwp = $this->input->post('npwp');
		$no_rekening = $this->input->post('no_rekening');
		$usergroup = $this->input->post('usergroup');
		$alamat_ktp = $this->input->post('alamat_ktp');
		$alamat_domisili = $this->input->post('alamat_domisili');

		$id_puskesmas =  $this->input->post('id_puskesmas');
		$rumpun_kerja =  $this->input->post('rumpun_kerja');

		$id_validator = $this->getIdValidator($rumpun_kerja, $id_puskesmas);

		$password = $this->session->userdata('password');

		$data = array(
			'nama' => $this->input->post('nama'),
			'nip' => $nip,
			'nrk' =>  $this->input->post('nrk'),
			'golongan' =>  '0',
			'id_puskesmas' => $id_puskesmas,
			'rumpun_kerja' => $rumpun_kerja,
			'id_jabatan' => $this->input->post('id_jabatan'),
			'id_poli' => $this->input->post('id_poli'),
			'tgl_masuk' => format_db($tgl_masuk),
			'tmt' => format_db($tgl_masuk),
			'jns_pegawai' => $this->input->post('jns_pegawai'),
			'jns_jam_kerja' => $this->input->post('jam_kerja'),
			'status_kawin' => $this->input->post('status_kawin'),
			'status_pajak' => 'TK',
			'id_pendidikan' =>  $this->input->post('id_pendidikan'),
			'id_validator' => $id_validator,
			'usergroup' => $this->input->post('usergroup'),
			'password'=> $password,
			'kategori_masa_kerja' => 1,
			'masa_kerja' => '0-0-1',
			'tahun_anggaran' => '2024'

		);


		$this->db->insert('mst_pegawai', $data);

		$this->Pegawai_model->insertDataDetail($nip, $npwp, $no_rekening, $no_ktp, $tempat_lahir, format_db($tgl_lahir), $alamat_ktp, $alamat_domisili, $no_tlp, $email, 'dummy.png');

		$id_pegawai = $this->Pegawai_model->getlastIDPegawai();

		$this->Pegawai_model->insertDataGaji($id_pegawai, 0, 0, 0, 0, 0, 0);

		redirect('register/success_register');


	}

	function success_register() {
		$this->load->view('register/success_register');
	}

	function getIdValidator($rumpun_kerja, $id_puskesmas)  {

		$sql = "SELECT id_pegawai, nama FROM mst_pegawai WHERE id_puskesmas  = $id_puskesmas AND (usergroup < 5 && usergroup != 0) AND rumpun_kerja = '$rumpun_kerja'";

        $qry = $this->db->query($sql);
        $row = $qry->result();

		if(count($row) > 0){
				$id_pegawai = $row[0]->id_pegawai;
		}else{
				$id_pegawai = 0;
		}

		return $id_pegawai;

	}

	function getValidator()  {

        $rumpun_kerja = $this->input->post('rumpun_kerja');
        $id_puskesmas = $this->input->post('id_puskesmas');

		$sql = "SELECT id_pegawai, nama FROM mst_pegawai WHERE id_puskesmas  = $id_puskesmas AND (usergroup < 5 && usergroup != 0) AND rumpun_kerja = '$rumpun_kerja'";

        $qry = $this->db->query($sql);
        $row = $qry->result();

         if(count($row) > 0){
             	$nama = $row[0]->nama;
         }else{
             	$nama = 'Nama tidak ditemukan';
         }


        echo $nama;

    }

}
