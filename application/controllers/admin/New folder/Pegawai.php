<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pegawai extends CI_Controller
{
	public function __construct()
	{

		parent::__construct();
		$this->load->model('Old_model');
		$this->Auth_model->cekAuthLogin();
	}

	public function data_pegawai($jns_pegawai = 'non_pns', $status_kerja = 1)
	{
		$thn_anggrn = 2024;
		$data['title'] = 'Data Pegawai';
		$data['list_jabatan']   = $this->Master_model->getlistJabatan();
		$data['list_puskesmas'] = $this->Master_model->getlistPuskesmas();

		// Tangkap parameter filter dari GET
		$filters = array(
			'status'       => $this->input->get('status', TRUE),
			'id_jabatan'   => $this->input->get('id_jabatan', TRUE),
			'id_puskesmas' => $this->input->get('id_puskesmas', TRUE),
			'q'            => $this->input->get('q', TRUE) // keyword pencarian (Nama / NIP)
		);

		if ($jns_pegawai == 'pjlp') {
			$data['pegawai'] = $this->Pegawai_model->getPegawaiPJLP($filters);
			$this->load->view('admin/pegawai/pegawai_pjlp', $data);
		} else {
			// Oper $filters ke method Model
			$data['pegawai'] = $this->Pegawai_model->getListPegawai($jns_pegawai, $thn_anggrn, $filters);
			$this->load->view('admin/pegawai/main', $data);
		}
	}


	public function ajax_search_pegawai($jns_pegawai = 'non_pns')
	{
		$filters = array(
			'status'       => $this->input->get('status', TRUE),
			'id_jabatan'   => $this->input->get('id_jabatan', TRUE),
			'id_puskesmas' => $this->input->get('id_puskesmas', TRUE),
			'q'            => $this->input->get('q', TRUE)
		);

		$pegawai = $this->Pegawai_model->getListPegawai($jns_pegawai, 2024, $filters);

		// Format tanggal helper jika diperlukan
		foreach ($pegawai as $key => $peg) {
			$pegawai[$key]->tgl_masuk_formatted = format_semi($peg->tgl_masuk);
		}

		echo json_encode(['data' => $pegawai]);
	}


	function detail_pegawai($id_pegawai)
	{
		$data_pegawai   = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		$nip = $data_pegawai[0]->nip;
		$data['data_gaji'] = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);

		$data['list_jabatan'] 	   = $this->Master_model->getlistJabatan();
		$data['list_pendidikan']   = $this->Master_model->getlistPendidikan();
		$data['list_poli'] 		   = $this->Master_model->getlistPoli();
		$data['list_puskesmas']    = $this->Master_model->getlistPuskesmas();
		$data['list_Status']       = $this->Master_model->getlistStatus();
		$data['list_validator']    = $this->Pegawai_model->getValidator();
		$data['cutiPegawai']       = $this->Cuti_model->getHistoryCutiPegawai($id_pegawai);
		$data['pegawai'] 		   = $data_pegawai;


		$this->db->select('id');
		$cekDataDetailPegawai = $this->db->get_where('detail_pegawai', ['nip', $nip]);
		if (empty($cekDataDetailPegawai)) {
			$data_detail = array(
				'id_pegawai'      => $id_pegawai, // <-- JANGAN LUPA DITAMBAHKAN
				'nip'             => $nip,
				'npwp'            => 0,
				'no_rekening'      => 0,
				'no_ktp'          => 0,
				'tempat_lahir'    => '-',
				'tgl_lahir'       => date('Y-m-d'), // Format tanggal MySQL (YYYY-MM-DD)
				'alamat_ktp'      => '-',
				'alamat_domisili' => '-',
				'no_tlp'          => 0,
				'email'           => '-',
				'photo'           => 'avatar.png'
			);

			// 3. Lakukan Insert
			$this->db->insert('detail_pegawai', $data_detail);
		}


		$data['data_detail_pegawai'] = $this->Pegawai_model->getDataDetailPegawai($nip);
		$this->load->view('admin/pegawai/detail_pegawai', $data);
	}



	function edit_pegawai($id_pegawai)
	{
		$data_pegawai   = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		$nip = $data_pegawai[0]->nip;
		$data['data_gaji'] = $this->Pegawai_model->getDataGajiPegawai($id_pegawai);

		$data['list_jabatan'] 	   = $this->Master_model->getlistJabatan();
		$data['list_pendidikan']   = $this->Master_model->getlistPendidikan();
		$data['list_poli'] 		   = $this->Master_model->getlistPoli();
		$data['list_puskesmas']    = $this->Master_model->getlistPuskesmas();
		$data['list_Status']       = $this->Master_model->getlistStatus();
		$data['list_validator']    = $this->Pegawai_model->getValidator();
		$data['cutiPegawai']       = $this->Cuti_model->getHistoryCutiPegawai($id_pegawai);
		$data['pegawai'] 		   = $data_pegawai;
		$data['data_detail_pegawai'] = $this->Pegawai_model->getDataDetailPegawai($nip);

		$this->load->view('admin/pegawai/edit_pegawai', $data);
	}


	function detail_pegawai_pjlp($id)
	{
		$data['list_puskesmas']    = $this->Master_model->getlistPuskesmas();
		$data['pegawai'] 		   = $this->Pegawai_model->getDataEditPegawaiPJLPByID($id);
		$this->load->view('admin/pegawai/detail_pegawai_pjlp', $data);
	}



	function update_data_pegawai_pjlp($id)
	{
		$data = array(
			'nama' => $this->input->post('nama'),
			'id_pjlp' => $this->input->post('id_pjlp'),
			'id_mesin' =>  $this->input->post('id_mesin'),
			'jabatan' =>  $this->input->post('jabatan'),
			'lokasi_kerja' => $this->input->post('puskesmas'),
			'no_tlp' => $this->input->post('no_tlp'),
			'tgl_lahir' => format_db($this->input->post('tgl_lahir')),
			'gaji_pokok' => $this->input->post('gaji_pokok'),
			'no_kk' => $this->input->post('no_kk'),
			'nik' => $this->input->post('nik'),
			'tmpat_lahir' => $this->input->post('tmpat_lahir'),
			'alamat' => $this->input->post('alamat'),
			'no_rekening' => $this->input->post('no_rekening'),
			'npwp' => $this->input->post('npwp'),

		);

		$this->db->where('id', $id);
		$this->db->update('tbl_pegawai_pjlp', $data);

		redirect('admin/pegawai/detail_pegawai_pjlp/' . $id);
	}


	function add_pegawai($jns_pegawai = '')
	{
		$data['list_jabatan'] = $this->Master_model->getlistJabatan();
		$data['list_pendidikan'] = $this->Master_model->getlistPendidikan();
		$data['list_poli'] = $this->Master_model->getlistPoli();
		$data['list_puskesmas'] = $this->Master_model->getlistPuskesmas();
		$data['list_Status'] = $this->Master_model->getlistStatus();
		$data['list_validator'] = $this->Pegawai_model->getValidator();
		//	$data['list_validator_pjlp'] = $this->Pegawai_model->getPJ_PJLP();

		if ($jns_pegawai == 'pjlp') {
			$this->load->view('admin/pegawai/insert_pegawai_pjlp', $data);
		} else {
			$this->load->view('admin/pegawai/insert_pegawai', $data);
		}
	}


	function insert_pegawai($jns_pegawai = 'non_pns')
	{
		if ($jns_pegawai == 'pjlp') {
			$this->Pegawai_model->insertNewPegawaiPJLP();
		} else {
			$this->Pegawai_model->insertNewPegawai();
		}

		$pesan =  createMessageInfo('Data  pegawai  berhasil disimpan');
		$this->session->set_flashdata('message', $pesan);
		redirect('admin/pegawai/data_pegawai/' . $jns_pegawai);
	}

	function update_data_pegawai($id_pegawai, $nip)
	{

		$update = $this->Pegawai_model->updateDataPegawai($id_pegawai);
		$this->Pegawai_model->updateDataDetailPegawai($nip);

		$nip_inputan = $this->input->post('nip');
		if ($nip_inputan !== $nip && $nip_inputan !== '-' && !empty($nip_inputan)) {
			// Cek apakah NIP baru sudah dipakai pegawai lain
			$cek_nip = $this->db->get_where('mst_pegawai', ['nip' => $nip_inputan])->num_rows();

			if ($cek_nip > 0) {
				// Return error JSON jika NIP sudah terdaftar
				echo json_encode([
					'status'  => 'error',
					'message' => 'NIP ' . $nip_inputan . ' sudah digunakan oleh pegawai lain!'
				]);
				return;
			}

			// Jika unik, jalankan update NIP berdasarkan id_pegawai
			$this->Pegawai_model->update_nip_pegawai($id_pegawai, $nip_inputan);
		}


		// Respon JSON untuk AJAX
		if ($update) {
			$response = array(
				'status'  => 'success',
				'message' => 'Data pegawai berhasil diperbarui.'
			);
		} else {
			$response = array(
				'status'  => 'error',
				'message' => 'Gagal memperbarui data pegawai ke database.'
			);
		}

		// Output dalam bentuk JSON
		echo json_encode($response);
		return;
	}

	function delete_pegawai($id_pegawai)
	{

		// $this->db->where('id_pegawai', $id_pegawai);
		// $this->db->delete('mst_pegawai');
		//
		// query delete diubah jadi query update, untuk menghindari datapegawai yg suatu saat bisa digunakan lagi (Soft delete)
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('mst_pegawai', ['is_deleted ' => 1]);

		$pesan =  createMessageInfo('Data  pegawai  berhasil dihapus');
		$this->session->set_flashdata('message', $pesan);
		redirect('admin/pegawai/data_pegawai/non_pns');
	}

	function delete_pegawai_pjlp($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('tbl_pegawai_pjlp');

		$pesan =  createMessageInfo('Data  pegawai  berhasil dihapus');
		$this->session->set_flashdata('message', $pesan);
		redirect('admin/pegawai/data_pegawai/pjlp');
	}




	public function cuti_pegawai($jns_pegawai = 'non_pns')
	{
		$data['pegawai'] = $this->Pegawai_model->getListPegawai('non_pns', 2024);
		$this->load->view('admin/pegawai/cuti_pegawai', $data);
	}

	function detail_cuti($id_cuti = 0)
	{
		$data['cuti'] = $this->Cuti_model->get_detail_pengajuan($id_cuti);

		$this->load->view('admin/pegawai/detail_cuti', $data);
	}

	function cancel_cuti($id_cuti = 0)
	{
		$detail_cuti   = $this->Cuti_model->getDetailCuti($id_cuti);
		$id_pegawai    = $detail_cuti[0]->id_pegawai;
		$jns_hak_cuti  = $detail_cuti[0]->jns_hak_cuti;
		$hari_cuti     = $detail_cuti[0]->hari_cuti;
		$status        = $detail_cuti[0]->status;
		$jns_cuti      = $detail_cuti[0]->jns_cuti;

		if ($status == 'APPROVE') {
			//klo sudah di acc sama kapus kecamatan, harus kembalikan cutinya
			$sisa_cuti  = $this->Cuti_model->getSisaCuti($id_pegawai, $jns_hak_cuti);
			$sisa_akhir = $sisa_cuti + $hari_cuti;
			$ket = 'Sisa  cuti dikembalikan, pembatalan cuti';
			$this->Cuti_model->insertLogCuti($id_pegawai, $jns_hak_cuti, $jns_cuti, $id_cuti, $hari_cuti, $sisa_akhir, $ket);

			// $this->Presensi_model->updateAbsensiCancelCuti($id_cuti, $pin);
		}

		$this->db->where('id', $id_cuti);
		$this->db->set('status', 'CANCEL');
		$this->db->update('ts_cuti', $data);

		$this->session->set_flashdata('message', 'Cuti telah dibatalkan');
		redirect('admin/pegawai/detail_cuti/' . $id_cuti);
	}
	function update_data_gaji($id_pegawai)
	{

		#print_array($this->input->post());

		$this->Pegawai_model->updateDataGaji($id_pegawai);

		$pesan =  createMessageInfo('Data gaji  berhasil diupdate');
		$this->session->set_flashdata('message', $pesan);
		redirect('admin/pegawai/detail_pegawai/' . $id_pegawai);
	}

	function change_status_kerja($id_pegawai)
	{
		$status = $this->input->post('status');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->set('status_kerja', $status);
		$this->db->update('mst_pegawai');

		$pesan =  createMessageInfo('Status kerja pegawai telah diubah');
		$this->session->set_flashdata('message', $pesan);
		redirect('admin/pegawai/detail_pegawai/' . $id_pegawai);
	}

	function reset_password($id_pegawai)
	{

		$pass = 123456;
		$new_pass = md5($pass);
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->set('password', $new_pass);
		$this->db->update('mst_pegawai');
		$pesan =  createMessageInfo('Password berhasil direset');
		$this->session->set_flashdata('message', $pesan);
		redirect('admin/pegawai/detail_pegawai/' . $id_pegawai);
	}


	function insert_sisa_cuti($id_pegawai)
	{


		$jns_hak = $this->input->post('jns_hak');
		$jumlah  = $this->input->post('qty_input');
		$sisa_akhir  = $this->input->post('sisa_akhir');
		if ($jns_hak == '') {
			redirect('dashboard/index');
		}


		$newData = array(
			'id_pegawai' => $id_pegawai,
			'jns_hak_cuti' => $jns_hak,
			'jns_cuti' => 0, //karena ini bukan permtongan cuti dari pegawai
			'id_cuti' => 0,
			'jumlah_hari' => $jumlah,
			'sisa_akhir' => $sisa_akhir,
			'keterangan' => 'Penambahan/pengurangan cuti'
		);

		$this->db->insert('log_cuti', $newData);


		$pesan =  createMessageInfo('Sisa Cuti  pegawai telah tambahkan');
		$this->session->set_flashdata('message', $pesan);
		redirect('admin/pegawai/detail_pegawai/' . $id_pegawai);
	}


	function import_pajak()
	{
		$data = array(); // Buat variabel $data sebagai array

		$date_now  = date('Ymd_Hi');
		$file_name = $date_now;
		$path = 'pajak';

		$upload = $this->Master_model->upload_file($file_name, $path);

		if ($upload['result'] == "success") { // Jika proses upload sukses
			// Load plugin PHPExcel nya
			include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('uploads/' . $path . '/' . $file_name . '.xlsx'); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

			// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
			$data   = array();
			$numrow = 1;
			$num    = 0;
			foreach ($sheet as $row) {

				if ($numrow > 0) {
					$nama      = $row['A'];
					$pajak      = $row['B'];
					$bpjs_tk      = $row['C'];
					$pph21 = str_replace(",", "", $pajak);
					$tk = str_replace(",", "", $bpjs_tk);
					$id_pegawai = $this->Pegawai_model->getIDpegawaiByName($nama);
					$updatePajak = array(

						'id_pegawai' => $id_pegawai,
						'pph21' => $pph21,
						'bpjs_tk' => $tk,
					);


					//print_array( $updatePajak);
					if ($id_pegawai  > 0) {
						$this->db->where('id_pegawai', $id_pegawai);
						$this->db->update('gaji_pegawai', $updatePajak);
					}


					$numrow++; // Tambah 1 setiap kali looping



				}

				$numrow++; // Tambah 1 setiap kali looping
			}

			echo 'berhasil';
		} else { // Jika proses upload gagal

			echo  $upload['error'];
			#$this->session->set_userdata('error_msg', $upload['error']); // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			#redirect('admin/swab/error_import');
		}

		exit;
	}
	function importPegawaiPJLP()
	{



		$data = array(); // Buat variabel $data sebagai array

		$date_now  = date('Ymd_Hi');
		$file_name = $date_now;
		$path = 'pajak';

		$ta = 2024;
		$upload = $this->Master_model->upload_file($file_name, $path);

		if ($upload['result'] == "success") { // Jika proses upload sukses
			// Load plugin PHPExcel nya
			include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

			$excelreader = new PHPExcel_Reader_Excel2007();
			$loadexcel = $excelreader->load('uploads/' . $path . '/' . $file_name . '.xlsx'); // Load file yang tadi diupload ke folder excel
			$sheet = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

			// Buat sebuah variabel array untuk menampung array data yg akan kita insert ke database
			$data = array();
			$numrow = 1;
			$num = 0;

			foreach ($sheet as $row) {

				if ($numrow > 1) {

					$nama      = $row['B'];
					$jabatan      = $row['D'];
					$ID_PJLP      = $row['C'];
					$lokasi_kerja      = $row['E'];

					$data[] = array(
						'id_pjlp' => $ID_PJLP,
						'nama' => $nama,
						'jabatan' => $jabatan,
						'lokasi_kerja' => $lokasi_kerja
					);
				}

				$numrow++; // Tambah 1 setiap kali looping
			}


			#print_array($data);

			$this->db->insert_batch('tbl_pegawai_pjlp', $data);

			echo '<h3>Data BPJS TK berhasil diupdate</h3>';
		} else { // Jika proses upload gagal

			echo  $upload['error'];
			#$this->session->set_userdata('error_msg', $upload['error']); // Ambil pesan error uploadnya untuk dikirim ke file form dan ditampilkan
			#redirect('admin/swab/error_import');
		}

		exit;
	}
}
