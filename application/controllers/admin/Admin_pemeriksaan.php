<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pemeriksaan extends CI_Controller {

	public function index()
	{
		$this->load->model('Pemeriksaan_model');

		$tgl = date('Y-m-d');

		$status_ht = $this->session->userdata('status_ht');
		$status_gds = $this->session->userdata('status_gds');
		$status_laik = $this->session->userdata('status_laik');
		if($status_ht==''){
			$status_ht=0; $status_gds=0; $status_laik=0;
		}
		
		
		$data['data_pemeriksaan'] = $this->Pemeriksaan_model->getDataPemeriksaan($tgl, $status_ht, $status_gds, $status_laik);
		$this->load->view('admin/pemeriksaan/main', $data);
	}

	function create_session_filter(){
		$tgl = $this->input->post('tgl');

		$tgl = format_db($tgl);

        $dataFilter = array(
            'tgl' => $tgl,
            'status_ht' => $this->input->post('status_ht'),
            'status_gds' => $this->input->post('status_gds'),
            'status_laik' => $this->input->post('status_laik'),
        );

		$this->session->set_userdata('tgl_daftar', $tgl);
		return true;
	}

	public function ubah_data_pemeriksaan($id_pemeriksaan)
	{
		   
		$data['dataPemeriksaan'] = $this->Driver_model->getDataEditPemeriksaan($id_pemeriksaan);
		$data['riwayatPTMKeluarga'] = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_ptm_keluarga');

		$data['riwayatPTMDiri'] = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_ptm');
		$data['faktorResiko']   = $this->Driver_model->getDataPemeriksaan($id_pemeriksaan, 'tbl_faktor_resiko');
	  
		
		$this->load->view('admin/driver/ubah_data_pemeriksaan', $data);
	}
}