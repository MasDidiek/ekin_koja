<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Login extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Auth_model');
	}
	function index()
	{


		$this->load->view('login_page2');
	}

	function login2()
	{


		$this->load->view('login_page2');
	}



	function do_login()
	{
		$nip        = $this->input->post('idpegawai');
		$pass       = $this->input->post('password');
		$password   = md5($pass);

		$this->load->library('form_validation');
		$this->form_validation->set_rules('idpegawai', 'NIP', array('required', 'numeric'));
		$this->form_validation->set_rules('password', 'Password', 'required');


		if ($this->form_validation->run() == FALSE) {
			$this->load->view('login_page2');
		} else {
			$cekAuth = $this->Auth_model->cekUserAuth($nip, $password);

			// print_array($cekAuth);
			// exit;


			if (!empty($cekAuth)) {

				$newSession = array(
					'id_pegawai' => $cekAuth[0]->id_pegawai,
					'nama' => $cekAuth[0]->nama,
					'nip' => $cekAuth[0]->nip,
					'nrk' => $cekAuth[0]->nrk,
					'id_puskesmas' => $cekAuth[0]->id_puskesmas,
					'usergroup' => $cekAuth[0]->usergroup,

				);
				$this->session->set_userdata($newSession);


				$uri_login = $this->session->userdata('uri_login');
				if ($uri_login != '') {
					redirect($uri_login);
				} else {
					redirect('dashboard/index');
				}
			} else {
				$this->session->set_userdata('nip_sess', $nip);
				$this->session->set_flashdata('msg_login', 'NIP/NRK atau password salah');
				redirect('Login/index');
			}
		}
	}

	function logout()
	{
		$this->session->sess_destroy();

		redirect('login/index');
	}


	function register()
	{
		$data['mst_pendidikan'] = $this->Ekin_model->select_in('mst_pendidikan', '*', 'order by id ASC');
		$data['mst_puskesmas'] = $this->Ekin_model->select_in('mst_puskesmas', '*', 'order by id_puskesmas ASC');
		$data['mst_jabatan'] = $this->Ekin_model->select_in('mst_jabatan', '*', 'order by id ASC');
		$this->load->view('register', $data);
	}

	function do_register()
	{


		$this->load->library('form_validation');
		$this->form_validation->set_rules('nama', 'Nama Lengkap', array('required'));
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[mst_pegawai.email]');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('ver_code', 'Kode Verifikasi', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('register');
		} else {

			$ver_code = $this->input->post('ver_code');
			$md5 = md5($ver_code);


			//PKCCIL3175=f61fe98d09353750bf30572662255d1b

			if ($md5 !== 'f61fe98d09353750bf30572662255d1b') {

				$this->load->view('register');
			} else {
				$this->session->set_userdata($this->input->post());

				redirect('login/register_step2');
			}
		}
	}


	function register_step2()
	{
		$data['mst_puskesmas'] = $this->Ekin_model->select_in('mst_puskesmas', '*', 'order by id_puskesmas ASC');
		$data['mst_jabatan'] = $this->Ekin_model->select_in('mst_jabatan', '*', 'order by id ASC');
		$data['mst_bagian'] = $this->Ekin_model->select_in('mst_bagian_kerja', '*', 'order by id ASC');
		$data['listValidator']   = $this->master_model->getListValidator();
		$data['list_pendidikan'] = $this->Pegawai_model->getListPendidikan();

		$this->load->view('register_step2', $data);
	}

	function submit_register()
	{


		$this->load->library('form_validation');
		$this->form_validation->set_rules('kota_lahir', 'Tempat Lahir', array('required'));

		$this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
		$this->form_validation->set_rules('jurusan', 'Jurusan', 'required');
		$this->form_validation->set_rules('nama_sekolah', 'nama Sekolah', 'required');
		$this->form_validation->set_rules('no_hp', 'No Handphone', 'required');
		$this->form_validation->set_rules('ktp', 'KTP', 'required');
		$this->form_validation->set_rules('npwp', 'NPWP', 'required');
		$this->form_validation->set_rules('nip', 'NIP', 'required|is_unique[mst_pegawai.NIP]');

		if ($this->form_validation->run() == FALSE) {
			$data['mst_puskesmas'] = $this->Ekin_model->select_in('mst_puskesmas', '*', 'order by id_puskesmas ASC');
			$data['mst_jabatan'] = $this->Ekin_model->select_in('mst_jabatan', '*', 'order by id ASC');
			$data['mst_bagian'] = $this->Ekin_model->select_in('mst_bagian_kerja', '*', 'order by id ASC');
			$data['listValidator']   = $this->master_model->getListValidator();
			$data['list_pendidikan'] = $this->Pegawai_model->getListPendidikan();
			$this->load->view('register_step2', $data);
		} else {



			$this->Pegawai_model->insertPegawaiEkin();
			$this->Pegawai_model->insertDataPegawai();
			$this->Pegawai_model->insertDataDetail();

			redirect('login/success_register');
		}
	}


	function success_register()
	{

		$this->load->view('success_register');
	}


























	function getData()
	{
		$usergroupID = $this->session->userdata('usergroup');
		$id_admin    = $this->session->userdata('id_admin');
		$data['dataFollowup'] = $this->Mastermodel->getDataFollowup($id_admin);
		//$this->load->view('admin/service/system');
		if ($usergroupID == 4) {
			$data['dataImport'] = $this->Mastermodel->select_in('log_import', '*', 'ORDER BY id DESC');
			$this->load->view('admin/home/spv_page', $data);
		} else {
			$this->load->view('admin/home/follow_up', $data);
		}
	}
	public function forget_password()
	{
		$this->load->view('forget_password');
	}
	public function reset_password()
	{
		$nip         = $this->input->post('idpegawai');
		$email       = $this->input->post('email');
		$pass        = $this->input->post('password');
		$newpass     = $this->input->post('re_password');
		$cekLogin = $this->Ekin_model->cekIDPegawai($nip);
		if (!empty($cekLogin)) {
			if ($pass == $newpass) {
				$password    = md5($pass);
				$this->db->where('nip', $nip);
				$this->db->set('password', $password);
				$this->db->update('mst_pegawai');
				redirect($this->url . 'Login/success_reset_password');
			} else {
				redirect($this->url . 'Login/forget_password/error1');
			}
		} else {
			redirect($this->url . 'Login/forget_password/error2');
		}
	}
	public function success_reset_password()
	{
		$this->load->view('ekin/success_reset_password');
	}
	/*function index()
	{
		$username = $this->input->post('username');
		$pass     = $this->input->post('pass');
		$password = md5(sha1($pass));
		//$check = $this->Mastermodel->valid_user($username, $password);
		$check = $this->Mastermodel->mst_check_3('user',"name='$username' AND password='$password'");
		if($check == '')
		{
			redirect('admin/useradmin/index/error/'.$username);
		}else
		{
			$id_group = $check[0]->id_group;
			$ID 	  = $check[0]->ID;
			$name 	  = $check[0]->name;
			$newdata = array
			(
			   'name_admin' => $name,
			   'id_group'   => $id_group,
			   'id_admin'   => $ID,
			   'UserID'  	 => $ID,
			   'logged_in'  => TRUE
			);
			$this->session->set_userdata($newdata);
			echo $id_group;
			exit;
			if($id_group==3)
			{
				redirect('admin/dashboard/index/9');
			}else{
				redirect('admin/home/index/8');
			}
		}
	}*/
}
