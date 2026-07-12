<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

public function index()
	{
		$this->session->sess_destroy();
		//$this->load->view('registrasi');
		$this->load->view('home');
	}

	function pre_registrasi(){
		//fungsi hanya untuk mengecek nama, no_ktp dan tgl lahir

		$nama = $this->input->post('nama_lengkap');
		$no_ktp = $this->input->post('no_ktp');
		$tgl_lahir = $this->input->post('tgl_lahir');

		// cek apakah KTP sudah ada
		$cek = $this->Driver_model->cek_ktp($no_ktp);

		if ($cek) {
			echo json_encode([
				"status" => "error",
				"message" => "Gagal!!. NIK sudah terdaftar!"
			]);
			return;
		}

		// kalau belum ada → simpan data
		$data = [
			"nama_lengkap" => $nama,
			"no_ktp"       => $no_ktp,
			"tgl_lahir"    => $tgl_lahir
		];
		$this->session->set_userdata($data);

		$this->session->set_flashdata('nama_lengkap', $nama);
		$this->session->set_flashdata('no_ktp', $no_ktp);
		$this->session->set_flashdata('tgl_lahir', $tgl_lahir);

		echo json_encode([
			"status" => "success",
			"message" => "Registrasi berhasil!",
			"redirect" => base_url("home/register_step2") // opsional redirect
		]);

	}

	// function create_session(){
	// 	$this->load->library('form_validation');
    //     $this->form_validation->set_rules('no_ktp', 'No KTP', array('required', 'min_length[16]', 'numeric'));
    //     $this->form_validation->set_rules('nama_lengkap', 'Nama', 'required');
	// 	$this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');


    //     if ($this->form_validation->run() == FALSE) {
    //         $this->load->view('landing_page');
    //     } else {
	// 		$this->session->set_userdata($this->input->post());
	// 		redirect('home/register_step2');
	// 	}

	// }

	function register_step2(){
		$this->load->view('register_step2');
	}


    public function submit()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_ktp', 'No KTP', array('required', 'min_length[16]', 'numeric'));
        $this->form_validation->set_rules('nama_lengkap', 'Nama', 'required');
        $this->form_validation->set_rules('gender', 'Jenis Kelamin', 'required');
        $this->form_validation->set_rules('no_hp', 'No Handphone', 'required');
        $this->form_validation->set_rules('tgl_lahir', 'Tanggal Lahir', 'required');
        $this->form_validation->set_rules('nama_po', 'Nama PO', 'required');
		$this->form_validation->set_rules('pendidikan', 'Pendidikan', 'required');
		$this->form_validation->set_rules('status_pernikahan', 'Status Pernikahan', 'required');

		
        if ($this->form_validation->run() == FALSE) {


            $this->load->view('register_step2');
        } else {
			$tgl_lahir = $this->input->post('tgl_lahir');
			$d = str_replace("/", "-", $tgl_lahir);
			$tgl_lahir = format_db($d);

			$kode_reg = $this->generateRegistrationCode(6);

			$data = array(
				'tgl_daftar' => date('Y-m-d'),
				'kode_registrasi'=> $kode_reg,
				'no_ktp' => $this->input->post('no_ktp'),
				'nama' => $this->input->post('nama_lengkap'),
				'tgl_lahir' => $tgl_lahir,
				'jns_kel' => $this->input->post('gender'),
				'no_hp' => $this->input->post('no_hp'),
				'pekerjaan' => $this->input->post('pekerjaan'),
				'nama_pekerjaan' => $this->input->post('pekerjaan_lainnya'),
				'pendidikan' => $this->input->post('pendidikan'),
				'status_kawin' => $this->input->post('status_pernikahan'),
				'alamat' => $this->input->post('alamat'),
				'nama_po' => $this->input->post('nama_po'),
				'status_supir' => $this->input->post('status_supir'),
				'terminal_tujuan' => $this->input->post('terminal_jurusan'),
				'status_pemeriksaan' => 0, #belum diperiksa
				'rekomendasi' => 0,
				'tgl_periksa' => '0000-00-00',
				'id_petugas' => 0,
				'nama_terminal' => ''

			);

		 $this->db->insert('mst_driver', $data);
          #echo 'berhasil, data berhasil disimpan';

		  $new_session = array(
			'nama' => $this->input->post('nama_lengkap'),
			'no_ktp' => $this->input->post('no_ktp'),
			'kode_registrasi'=> $kode_reg
		  );


		  $this->session->set_userdata($new_session);

          redirect('home/success_registrasi');
        }
     
    }
    

	function generateRegistrationCode($length = 8) {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';
	
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, strlen($characters) - 1)];
		}
	
		return $randomString;
	}
    
    function success_registrasi(){
        $this->load->view('success_registrasi');
    }
   
}
