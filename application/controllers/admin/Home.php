<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index()
	{

	redirect('admin/dashboard');
		// $tgl_daftar = $this->session->userdata('tgl_daftar');
		// if($tgl_daftar==''){
		// 	$tgl = date('Y-m-d');
		// 	//$this->session->set_userdata('tgl_daftar', $tgl);
		// }else{
		// 	$tgl = $tgl_daftar;
		// }
		// $data['driver'] = $this->Driver_model->get_list_driver($tgl);
		// $data['numDriver'] = $this->Driver_model->countDriver();
		// $data['numDriverBlmDiperiksa'] = $this->Driver_model->countDriverBlmDiperiksa();
		// $data['DriverBlmDiperiksa'] = $this->Driver_model->getDriverBlmDiperiksa();
		// $data['driverHtTinggi'] = $this->Pemeriksaan_model->getDataPemeriksaan($tgl, 4, 0, 0);
		// $data['DriverLaik'] = $this->Driver_model->countDriverByStatusLaik(1);
		// $data['DriverLaikCttn'] = $this->Driver_model->countDriverByStatusLaik(2);
		// $data['DriverTdkLaik'] = $this->Driver_model->countDriverByStatusLaik(3);
		



		// $this->load->view('admin/dashboard', $data);
	}

}