<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi_pjlp extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model('Old_model');
		$this->Auth_model->cekAuthLogin();

	}

	function index($id_pjlp=0)
	{

		
		$data['data_pjlp'] = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);
		$this->load->view('admin/absensi/index', $data);
		
       
    }

	function change_periode($id_pjlp){
		$this->session->set_userdata($this->input->post());
		redirect('admin/absensi_pjlp/index/'.$id_pjlp);
	}


    function print($id_pjlp){
        $data['data_pjlp'] = $this->Pegawai_model->getDataEditPegawaiPJLP($id_pjlp);
		$this->load->view('admin/absensi/print_absen', $data);
    }

}