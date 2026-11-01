<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Renkin extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
	
		$this->Auth_model->cekAuthLogin();
		$this->load->model('Renkin_model', 'rm');
		$this->load->model('Master_model');

	}

	function index()
	{

		
		//$data['renkin'] = $this->Pegawai_model->detailPegawaiPJLP($id_pjlp);
		$this->load->view('admin/renkin/index');
		
       
    }

    function indikator_renkin(){
		$data['list_jabatan'] = $this->Master_model->getlistJabatan();
		$data['list_indikator'] = $this->rm->getListIndikator($this->input->get('id_jabatan'));
        $this->load->view('admin/renkin/indikator_renkin', $data);
    }

	function simpan_indikator_kinerja(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('indikator', 'Indikator Kinerja', 'required|trim');
		$this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
		$this->form_validation->set_rules('target_tahunan', 'Target Tahunan', 'required|integer|greater_than[0]');
		$this->form_validation->set_rules('profesi', 'Jabatan/Profesi', 'required|integer');
		$this->form_validation->set_rules('auto_fill_target', 'Auto Fill Target', 'required|in_list[Y,T]');
		$this->form_validation->set_rules('jns_indikator', 'Jenis Indikator', 'required|in_list[absolut,akumulatif]');

		if (!$this->form_validation->run()) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">' . validation_errors() . '</div>');
			redirect('admin/renkin/indikator_renkin');
		}

		$data = array(
			'indikator' => $this->input->post('indikator', TRUE),
			'satuan' => $this->input->post('satuan', TRUE),
			'target_tahunan' => $this->input->post('target_tahunan'),
			'profesi' => $this->input->post('profesi'),
			'auto_fill_target' => $this->input->post('auto_fill_target'),
			'jns_indikator' => $this->input->post('jns_indikator')
		);
		$id = $this->input->post('id');

		if (!empty($id)) {
			if (!$this->rm->get_indikator_by_id($id)) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger">Data indikator tidak ditemukan.</div>');
				redirect('admin/renkin/indikator_renkin');
			}

			$this->rm->update_indikator($id, $data);
			$message = 'Data indikator berhasil diperbarui.';
		} else {
			$data['publish'] = 1;
			$this->rm->insert_indikator($data);
			$message = 'Data indikator berhasil ditambahkan.';
		}

		$this->session->set_flashdata('message', '<div class="alert alert-success">' . $message . '</div>');
		redirect('admin/renkin/indikator_renkin');
	}

	function update_publish_indikator($id){
		if ($this->input->method(TRUE) !== 'POST') {
			show_404();
		}

		$publish = $this->input->post('publish');
		if (!in_array((string) $publish, array('0', '1'), TRUE) || !$this->rm->get_indikator_by_id($id)) {
			$this->session->set_flashdata('message', '<div class="alert alert-danger">Status indikator tidak valid.</div>');
			redirect('admin/renkin/indikator_renkin');
		}

		$this->rm->update_indikator($id, array('publish' => (int) $publish));
		$message = $publish == '1' ? 'Indikator berhasil dipublikasikan.' : 'Indikator berhasil di-unpublish.';
		$this->session->set_flashdata('message', '<div class="alert alert-success">' . $message . '</div>');
		redirect('admin/renkin/indikator_renkin');
	}

}