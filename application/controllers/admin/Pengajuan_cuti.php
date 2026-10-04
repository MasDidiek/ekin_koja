<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pengajuan_cuti extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('Profile_model');
		$this->Auth_model->cekAuthLogin();
		$this->load->helper('text');
	}

	function index($status = 'Semua')
	{
		// $id_pegawai = $this->session->userdata('id_pegawai');
		// $nip = $this->session->userdata('nip');
		//
		// $data['list_cuti'] = $this->Cuti_model->getDataCutiPegawai($status);

		//print_array($this->session->userdata);
		$this->load->library('pagination');
		$tgl_pencarian = $this->session->userdata('tgl_pencarian');

		if ($tgl_pencarian == '') {
			$periodeNow = date('Y-m');
			$tgl_dari   = $periodeNow . '-01';
			$tgl_sampai = $periodeNow . '-31';
		} else {
			$explod = explode(" to ", $tgl_pencarian);
			$tgl_dari   = $explod[0];
			$tgl_sampai   = @$explod[1];
		}


		// Konfigurasi pagination
		$config['base_url'] = base_url('admin/pengajuan_cuti/index');
		$config['total_rows'] = $this->Cuti_model->countCuti($tgl_dari, $tgl_sampai); // Jumlah total data
		$config['per_page'] = 10; // Jumlah data per halaman

		// Inisialisasi pagination
		$this->pagination->initialize($config);
		$offset =  $this->uri->segment(4);
		if ($offset == '') {
			$offset = 0;
		}
		// Ambil data dari model dengan limit dan offset

		$data['list_cuti'] = $this->Cuti_model->getDataCutiPegawai($tgl_dari, $tgl_sampai, $config['per_page'], $offset);
		$data['total_rows'] = 	 $config['total_rows'];


		$this->load->view('pengajuan_cuti/datalist_pengajuan_cuti_pegawai', $data);
	}

	function cari_nama()
	{
		$keyword = $this->input->post('keyword');

		$sql = "SELECT a.*, b.nama, b.id_validator, c.nama AS jabatan, d.photo
		FROM ts_cuti a
		LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai
		LEFT JOIN mst_jabatan c ON b.id_jabatan = c.id
		LEFT JOIN detail_pegawai d ON b.nip = d.nip
		WHERE b.nama like '%$keyword%' ORDER BY a.id DESC";
		$qry = $this->db->query($sql);
		$data['list_cuti'] = $qry->result();
		$data['total_rows'] = $qry->num_rows();

		$this->load->view('pengajuan_cuti/datalist_pengajuan_cuti_pegawai', $data);
	}

	function filter_data()
	{

		$this->session->set_userdata($this->input->post());

		redirect('admin/pengajuan_cuti/index');
		// $jns_cuti = $this->input->post('jns_cuti');
		//
		//
		// $data['list_cuti'] = $this->Cuti_model->getCutiByJnsCuti($jns_cuti);
		// $this->load->view('pengajuan_cuti/filter_data', $data);
	}

	function detail($id_cuti)
	{
		$data['detail_cuti'] = $this->Cuti_model->getDetailCuti($id_cuti);
		$this->load->view('pengajuan_cuti/detail_pengajuan_cuti', $data);
	}

	function calendar_pengajuan_cuti()
	{

		//print_array($this->session->userdata);
		$jns_cuti = $this->session->userdata('jns_cuti');
		$bln_cuti = $this->session->userdata('bln_cuti');



		$this->db->select('ts_cuti.*, mst_pegawai.nama');
		$this->db->from('ts_cuti');
		$this->db->join('mst_pegawai', 'ts_cuti.id_pegawai = mst_pegawai.id_pegawai');
		$this->db->where('ts_cuti.jns_cuti', $jns_cuti);


		if ($bln_cuti != '' && $jns_cuti != 2) {

			$this->db->where("(
				(MONTH(ts_cuti.tgl_dari) = $bln_cuti AND YEAR(ts_cuti.tgl_dari) = 2025) OR
				(MONTH(ts_cuti.tgl_sampai) = $bln_cuti AND YEAR(ts_cuti.tgl_sampai) = 2025)
			)");
		}



		$this->db->where('ts_cuti.tgl_dari >=', '2025-01-01');
		$this->db->order_by('ts_cuti.tgl_sampai', 'DESC');



		$query = $this->db->get();
		$row = $query->result();
		$data['list_cuti'] = $row;

		$this->load->view('pengajuan_cuti/calendar_pengajuan_cuti', $data);
	}

	function pengajuan_cuti_by_jns($jns_cuti = 1)
	{
		$this->session->set_userdata('jns_cuti', $jns_cuti);
		redirect('admin/pengajuan_cuti/calendar_pengajuan_cuti');
	}

	function set_session_bulan($bln_cuti = 1)
	{
		$this->session->set_userdata('bln_cuti', $bln_cuti);
		redirect('admin/pengajuan_cuti/calendar_pengajuan_cuti');
	}






	function pengajuan_cuti_pegawai($status = 'PEND1')
	{
		$id_puskesmas  = $this->session->userdata('id_puskesmas');
		$usergroup     = $this->session->userdata('usergroup');
		$id_pegawai    = $this->session->userdata('id_pegawai');
		$usergroup     = $this->session->userdata('usergroup');


		if ($usergroup == 3 || $usergroup == 4) {
			$data['cutiPegawai'] = $this->Cuti_model->getPengajuanCutiPegawai($id_pegawai, 'kapustu');
		} else if ($usergroup == 1) { //Kapuskec
			$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND3');
		} else {
			$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiKTU($status);
		}
		$this->load->view('pengajuan_cuti/pengajuan_cuti_pending', $data);
	}



	function pengajuan_cuti_admen()
	{
		$id_puskesmas  = $this->session->userdata('id_puskesmas');
		$usergroup     = $this->session->userdata('usergroup');
		$id_pegawai    = $this->session->userdata('id_pegawai');
		$usergroup     = $this->session->userdata('usergroup');

		$data['cutiPegawai'] = $this->Cuti_model->getDataCutiPegawaiPending('PEND1', $id_pegawai);

		$this->load->view('pengajuan_cuti/pengajuan_cuti_pending', $data);
	}

	function approve_pengajuan_cuti($id_cuti)
	{
		$status  = $this->input->post('status');

		if ($status == 'PEND0') {
			$data = array(
				'cek_pengganti' => 1,
				'tgl_cek' => date('Y-m-d'),
				'status' => 'PEND1'
			);
		} elseif ($status == 'PEND1') {
			$data = array(
				'check_kapuskel' => 1,
				'tgl_check' => date('Y-m-d'),
				'status' => 'PEND2'
			);
		} elseif ($status == 'PEND2') {
			$data = array(
				'check_ktu' => 1,
				'tgl_check_ktu' => date('Y-m-d'),
				'status' => 'PEND3'
			);
		} else if ($status == 'PEND3') {

			$detail_cuti  = $this->Cuti_model->getDetailCuti($id_cuti);
			$id_pegawai   = $detail_cuti[0]->id_pegawai;
			$jns_cuti     = $detail_cuti[0]->jns_cuti;
			$tgl_dari     = $detail_cuti[0]->tgl_dari;
			$jns_hak_cuti = $detail_cuti[0]->jns_hak_cuti;
			$hari_cuti    = $detail_cuti[0]->hari_cuti;
			$alasan_cuti  = $detail_cuti[0]->alasan_cuti;

			$nip          = $this->Pegawai_model->getNipPegawaiByID($id_pegawai);
			$pin          = substr($nip, -4);


			if ($jns_cuti == 1) {
				//cuti tahunan
				$sisa_cuti  = $this->Cuti_model->getSisaCuti($id_pegawai, $jns_hak_cuti);
				$sisa_akhir = $sisa_cuti - $hari_cuti;
				$ket        = 'Penggunaan cuti';
				$this->Cuti_model->insertLogCuti($id_pegawai, $jns_hak_cuti, $jns_cuti, $id_cuti, $hari_cuti, $sisa_akhir, $ket);

				$this->Presensi_model->insertAbsensiCuti($tgl_dari, $pin, $alasan_cuti);
			} else {


				$list_hari = $this->Cuti_model->getListHariCuti($id_cuti);
				for ($c = 0; $c < count($list_hari); $c++) {
					$tgl_cuti = $list_hari[$c]->tanggal;
					$this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin, $alasan_cuti);
				}
			}

			$data = array(
				'check_kapuskec' => 1,
				'tgl_check2' => date('Y-m-d'),
				'status' => 'APPROVE'
			);
		}

		$this->db->where('id', $id_cuti);
		$this->db->update('ts_cuti', $data);
		$this->session->set_flashdata('message', 'Pengajuan cuti telah disetujui');

		redirect('admin/pengajuan_cuti/detail/' . $id_cuti);
	}

	function tolak_cuti($id_cuti)
	{

		$status        = $this->input->post('status');
		$alasan_tolak  = $this->input->post('alasan_tolak');

		if ($status == 'PEND1') {
			$data = array(
				'check_kapuskel' => 2,
				'tgl_check' => date('Y-m-d'),
				'status' => 'REJECT',
				'alasan_tolak' => $alasan_tolak
			);
		} else if ($status == 'PEND2') {
			$data = array(
				'check_ktu' => 2,
				'tgl_check_ktu' => date('Y-m-d'),
				'status' => 'REJECT',
				'alasan_tolak' => $alasan_tolak
			);
		} else {
			$data = array(
				'check_kapuskec' => 2,
				'tgl_check2' => date('Y-m-d'),
				'status' => 'REJECT',
				'alasan_tolak' => $alasan_tolak
			);
		}


		$this->db->where('id', $id_cuti);
		$this->db->update('ts_cuti', $data);
		$this->session->set_flashdata('message', 'Pengajuan cuti telah ditolak');

		redirect('admin/pengajuan_cuti/detail/' . $id_cuti);
	}

	function cancel_cuti($id_cuti)
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

			$this->Presensi_model->updateAbsensiCancelCuti($id_cuti, $pin);
		}

		$this->db->where('id', $id_cuti);
		$this->db->set('status', 'CANCEL');
		$this->db->update('ts_cuti', $data);

		$this->session->set_flashdata('message', 'Cuti telah dibatalkan');
		redirect('admin/pengajuan_cuti/detail/' . $id_cuti);
	}

	function setujui_cuti()
	{
		$id_cuti     = $this->input->post('id_cuti');
		$status      = $this->input->post('status');


		if ($status == 'PEND1') {
			//kondisi menunggu validasi kapustu
			$data = array(
				'check_kapuskel' => 1,
				'tgl_check' => date('Y-m-d'),
				'status' => 'PEND2'
			);
		} else if ($status == 'PEND2') {
			//kondisi sudah divalidasi oleh kapustu/kasatpel, menunggu approve kasubbag
			$data = array(
				'check_ktu' => 1,
				'tgl_check_ktu' => date('Y-m-d'),
				'status' => 'PEND3'
			);
		} else {
			$detail_cuti  = $this->Cuti_model->getDetailCuti($id_cuti);
			$id_pegawai   = $detail_cuti[0]->id_pegawai;
			$jns_cuti     = $detail_cuti[0]->jns_cuti;
			$tgl_dari     = $detail_cuti[0]->tgl_dari;
			$jns_hak_cuti = $detail_cuti[0]->jns_hak_cuti;
			$hari_cuti    = $detail_cuti[0]->hari_cuti;
			$alasan_cuti     = $detail_cuti[0]->alasan_cuti;
			$nip          = $this->Pegawai_model->getNipPegawaiByID($id_pegawai);
			$pin          = substr($nip, -4);

			if ($jns_cuti == 1) {
				//cuti tahunan
				$sisa_cuti  = $this->Cuti_model->getSisaCuti($id_pegawai, $jns_hak_cuti);
				$sisa_akhir = $sisa_cuti - $hari_cuti;
				$ket = 'Penggunaan cuti';
				$this->Cuti_model->insertLogCuti($id_pegawai, $jns_hak_cuti, $jns_cuti, $id_cuti, $hari_cuti, $sisa_akhir, $ket);

				if ($hari_cuti == 1) {
					$this->Presensi_model->insertAbsensiCuti($tgl_dari, $pin);
				} else {
					$list_hari = $this->Cuti_model->getListHariCuti($id_cuti);
					for ($c = 0; $c < count($list_hari); $c++) {
						$tgl_cuti = $list_hari[$c]->tanggal;
						$this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin, $alasan_cuti);
					}
				}
				// kondisi sudah divalidasi oleh kasubbag TU
				$data = array(
					'check_kapuskec' => 1,
					'tgl_check2' => date('Y-m-d'),
					'status' => 'APPROVE'
				);
			} else {
				$detail_cuti  = $this->Cuti_model->getDetailCuti($id_cuti);
				$id_pegawai   = $detail_cuti[0]->id_pegawai;
				$jns_cuti     = $detail_cuti[0]->jns_cuti;
				$tgl_dari     = $detail_cuti[0]->tgl_dari;
				$end_date     = $detail_cuti[0]->tgl_sampai;
				$alasan_cuti     = $detail_cuti[0]->alasan_cuti;

				$selisihhari =  datediff('d', $tgl_dari, $end_date);
				$hari_cuti = $selisihhari + 1;
				$tgl_cuti = $tgl_dari;
				for ($c = 0; $c < $hari_cuti; $c++) {

					$this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin, $alasan_cuti);
					$tgl_cuti = add_date($tgl_cuti, 1);
				}



				$data = array(
					'check_kapuskec' => 1,
					'tgl_check2' => date('Y-m-d'),
					'status' => 'APPROVE'
				);
			}
		}

		$this->db->where('id', $id_cuti);
		$this->db->update('ts_cuti', $data);
		$this->session->set_flashdata('message', 'Cuti telah disetujui');

		redirect('admin/pengajuan_cuti/pengajuan_cuti_pegawai');
		#redirect('admin/pengajuan_cuti/detail/'.$id_cuti);

	}
}
