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
		$this->load->model('Kinerja_model');
		$this->load->model('Pegawai_model');

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

    function renkin_pegawai() {

			$tahun = $this->input->get('tahun');
			$id_validator = $this->input->get('id_validator');
			$tahun = is_string($tahun) && preg_match('/^[1-9][0-9]{3}$/', $tahun) ? $tahun : date('Y');
			$id_validator = is_string($id_validator) && ctype_digit($id_validator) && (int) $id_validator > 0 ? $id_validator : 29519;
			$validator = $this->Pegawai_model->getValidator();
			$validator_ids = array();
			foreach ($validator as $pj) {
				$validator_ids[] = (string) $pj->id_pegawai;
			}
			if (!in_array((string) $id_validator, $validator_ids, true)) {
				$id_validator = 29519;
			}

			$data['tahun'] = $tahun;
			$data['id_validator'] = $id_validator;
			$data['validator'] = $validator;
      $data['renkin_pegawai'] = $this->Kinerja_model->getListRenkinPegawai($id_validator, $tahun);
      $this->load->view('admin/renkin/renkin_pegawai', $data);
    }

	function detail_renkin() {
		$id_pegawai = (int) $this->input->get('id_pegawai');
		$tahun = (int) $this->input->get('tahun');
		$id_validator = (int) $this->input->get('id_validator');
		if ($id_pegawai <= 0 || $tahun < 1000 || $tahun > 9999) {
			show_404();
		}

		$data['detail_pegawai'] = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		if (empty($data['detail_pegawai'])) {
			show_404();
		}
		$data['tahun_renkin'] = $tahun;
		$data['tahun_awal'] = min(date('Y') - 5, $tahun);
		$data['tahun_akhir'] = max(date('Y') + 1, $tahun);
		$data['list_renkin'] = $this->rm->getDataRenkinPegawai($id_pegawai, $tahun);
		$data['id_pegawai'] = $id_pegawai;
		$data['id_validator'] = $id_validator;
		$data['admin_renkin'] = true;
		$this->load->view('penilaian_kinerja/validasi_renkin', $data);
	}

	function print_renkin() {
		show_error('Format cetak renkin belum tersedia.', 501, 'Cetak Renkin');
	}


	function simpan_indikator_kinerja(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('indikator', 'Indikator Kinerja', 'required|trim');
		$this->form_validation->set_rules('satuan', 'Satuan', 'required|trim');
		$this->form_validation->set_rules('target_tahunan', 'Target Tahunan', 'required|integer|greater_than[0]');
		$this->form_validation->set_rules('profesi', 'Jabatan/Profesi', 'required|integer');
		
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