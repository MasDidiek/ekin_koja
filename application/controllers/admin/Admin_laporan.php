<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Admin_laporan extends CI_Controller {

	public function index()
	{


		#print_array($this->session->userdata);
		$filter_date = $this->session->userdata('filter_date');

		$tanggal = format_db($filter_date);
		$terminal = $this->session->userdata('nama_terminal');
	//	$data['laporan'] = $this->Laporan_model->getDataLaporan($tgl, $terminal);



	    $tanggal = '2025-12-23';
        $data['laporan'] = $this->Laporan_model
            ->get_laporan_checklist($tanggal, $terminal);

		$this->load->view('admin/main_laporan', $data);
	}

	function filter_data(){


		$this->session->set_userdata($this->input->post());
		redirect('admin/admin_laporan/index');
	}

	function by_date(){
		$this->load->view('admin/laporan_by_date');
	}

	public function export_laporan()
	{
		$tanggal = '2025-12-23';
		$terminal = $this->session->userdata('nama_terminal');
		$dataList = $this->Laporan_model->get_laporan_checklist($tanggal, $terminal);
		print_array($dataList);
		exit;

	  }



}