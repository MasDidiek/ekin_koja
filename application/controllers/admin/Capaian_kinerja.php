<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Capaian_kinerja  extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->model('Laporan_model');
		$this->load->helper('text');
		$this->Auth_model->cekAuthLogin();
	}


	public function index()
	{

		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		$id_validator = $this->session->userdata('id_pegawai');
		$id_pj_sess = $this->session->userdata('id_pj');
		$thn_anggaran = date('Y');

		if ($id_pj_sess != '') {
			$id_validator = $id_pj_sess;
		}

		if ($periode_bulan == '') {
			$bulan = date('m');
			$tahun = date('Y');

			$this->session->set_userdata('periode_bulan', $bulan);
			$this->session->set_userdata('periode_tahun', $tahun);
		} else {
			$bulan = $periode_bulan;
			$tahun = $periode_tahun;
		}
		$periode = $periode_tahun . '-' . $periode_bulan;
		$periode = date('Y-m', strtotime($periode));
		$thn_anggrn  = 2024;

		//get data rekap

		$this->db->where('periode', $periode);
		$this->db->where('b.id_validator', $id_validator);
		$this->db->select('a.*, b.nama, b.id_pegawai, b.id_validator');
		$this->db->from('ts_rekap_capaian a');
		$this->db->join('mst_pegawai b', 'a.nip = b.nip');
		$query = $this->db->get();

		$result = $query->result();



		$data['capaian_kinerja'] = $result;
		//$data['pegawai'] =  $this->Pegawai_model->getListPegawaiByValidator($id_validator, $thn_anggrn);
		$data['validator'] = $this->Pegawai_model->getValidator();
		$this->load->view('admin/capaian_kinerja/main', $data);
	}


	function detail_capaian($id_pegawai, $nip)
	{
		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		$periode = $periode_tahun . '-' . $periode_bulan;
		$periode = date('Y-m', strtotime($periode));


		$data['detail_pegawai']   = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		$data['dataRekap'] = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		$data['rekapTKD'] = $this->Laporan_model->getRekapTKDPegawai($nip, $periode);
		$data['master_cuti'] = $this->Master_model->getlistCuti();
		$this->load->view('admin/capaian_kinerja/detail_capaian', $data);
	}


	// function update_pendapatan($id_pegawai, $nip){

	// }


	function update_tkd($id_pegawai, $nip,  $totalCapaian, $periode)
	{


		$peg = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		#print_array($peg);
		$gaji_pokok = $peg[0]->gaji_pokok;
		$pengkalian = $peg[0]->pengkalian;
		$pph21 = $peg[0]->pph21;
		$bpjs_kes = $peg[0]->bpjs_kes;
		$bpjs_tk = $peg[0]->bpjs_tk;
		$bpjs_kes = $peg[0]->bpjs_kes;

		$tkd_pokok = ceil($gaji_pokok * $pengkalian);
		$bruto = round(($tkd_pokok * $totalCapaian) / 100);
		$pengurang = $pph21 + $bpjs_kes + $bpjs_tk;

		$thp = $bruto - $pengurang;

		$newRekap = array(
			'tkd_pokok' => $tkd_pokok,
			'capaian' => $totalCapaian,
			'bruto' => $bruto,
			'pph21' => $pph21,
			'bpjs' => $bpjs_kes,
			'bpjs_tk' => $bpjs_tk,
			'thp' => $thp,
			'update_on' => date('Y-m-d H:i:s')
		);


		// print_array($newRekap);
		// exit;
		$this->db->where('periode', $periode);
		$this->db->where('nip', $nip);
		$this->db->update('ts_rekap_tkd', $newRekap);
		$this->session->set_flashdata('message', ' Data rekap TKD berhasil diupdate');
		redirect('admin/capaian_kinerja/detail_capaian/' . $id_pegawai . '/' . $nip);
	}

	function detail($id_pegawai, $nip)
	{

		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		$nm_bulan = getBulan($periode_bulan);
		$periode = $periode_tahun . '-' . $periode_bulan;
		$periode = date('Y-m', strtotime($periode));
		$data['aktifitas'] = $this->Kinerja_model->getAktifitasPegawaiPerBulan($id_pegawai, $periode);
		$data['dataRekap'] = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		$this->load->view('admin/capaian_kinerja/detail', $data);
	}



	public function update_capaian_perpustu()
	{
		$id_validator = $this->session->userdata('id_pegawai');
		$id_pj_sess = $this->session->userdata('id_pj');


		if ($id_pj_sess != '') {
			$id_validator = $id_pj_sess;
		}

		$thn_anggrn = '2024';

		$pegawai =  $this->Pegawai_model->getListPegawaiByValidator($id_validator, $thn_anggrn);

		for ($i = 0; $i < count($pegawai); $i++) {
			$id_pegawai = $pegawai[$i]->id_pegawai;
			$this->Kinerja_model->updateCapaianKinerja($id_pegawai);
		}
		redirect('admin/capaian_kinerja/index');
	}
	public function update_capaian_pegawai($id_pegawai, $nip, $bulan, $tahun)
	{

		$this->Kinerja_model->updateCapaianKinerja($id_pegawai, $bulan, $tahun);
		$this->session->set_flashdata('message', ' Data capaian kinerja berhasil diupdate');
		redirect('admin/capaian_kinerja/detail_capaian/' . $id_pegawai . '/' . $nip);
		//print_array($newRekap);
	}


	function lihat_capaian($id_pegawai, $nip)
	{


		$bulan = $this->session->userdata('periode_bulan');
		$tahun = $this->session->userdata('periode_tahun');
		$periode = date('Y-m', strtotime("$tahun-$bulan"));

		$lastDay = date('t', strtotime($periode));

		$peg = $this->Pegawai_model->getDetailPegawai($id_pegawai)[0];

		$nip   = $peg->nip;
		$gaji  = $peg->gaji_pokok;
		$kali  = $peg->pengkalian;
		$pph21 = $peg->pph21;
		$bpjsK = $peg->bpjs_kes;
		$bpjsT = $peg->bpjs_tk;

		$serapan = SERAPAN;

		$rekap = $this->Presensi_model->getRekapAbsensiPegawai($id_pegawai, $periode);
		//$cuti  = $this->Cuti_model->getCutiPegawai($id_pegawai, $periode);


		//echo $bulan . ' - ' . $tahun;


		$rekap_cuti = $this->Kinerja_model->getRekapCutiBulanan($id_pegawai, $bulan, $tahun);

		$data['rekap_absen'] = $rekap;
		$data['rekap_cuti'] = $rekap_cuti;
		//print_array($rekap);
		//print_array($cuti//);

		$data['inputKinerja'] = $this->Kinerja_model->getAktifitasByStatus($id_pegawai, $periode, 1);
		$data['hariKerja'] = $this->Master_model->getMenitEfektifBulan($bulan, $tahun);
		$data['nilaiPerilaku'] = $this->Kinerja_model->getPoinPerilaku($id_pegawai, $bulan, $tahun);



		$this->load->view('admin/capaian_kinerja/lihat_capaian', $data);
	}


	function update_capaian()
	{

		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');
		$nm_bulan = getBulan($periode_bulan);
		$periode = $periode_tahun . '-' . $periode_bulan;
		$periode = date('Y-m', strtotime($periode));

		$id_pegawai = $this->input->post('id_pegawai');
		$bobotTotal = $this->input->post('bobot');
		$poinPerilaku = $this->input->post('perilaku');
		$serapan = $this->input->post('serapan');
		#print_array($this->input->post());

		$totalCapaian =  number_format($bobotTotal + $poinPerilaku + $serapan, 2);

		$peg = $this->Pegawai_model->getDetailPegawai($id_pegawai);
		// print_array($peg);
		// exit;
		$gaji_pokok = $peg[0]->gaji_pokok;
		$pengkalian = $peg[0]->pengkalian;
		$pph21 = $peg[0]->pph21;
		$bpjs_kes = $peg[0]->bpjs_kes;
		$bpjs_tk = $peg[0]->bpjs_tk;
		$bpjs_kes = $peg[0]->bpjs_kes;

		$nip = $peg[0]->nip;

		$tkd_pokok = ceil($gaji_pokok * $pengkalian);
		$bruto = round(($tkd_pokok * $totalCapaian) / 100);
		$pengurang = $pph21 + $bpjs_kes + $bpjs_tk;

		$thp = $bruto - $pengurang;

		$newRekap = array(
			'tkd_pokok' => $tkd_pokok,
			'capaian' => $totalCapaian,
			'bruto' => $bruto,
			'pph21' => $pph21,
			'bpjs' => $bpjs_kes,
			'bpjs_tk' => $bpjs_tk,
			'thp' => $thp,
			'update_on' => date('Y-m-d H:i:s')
		);


		// echo $periode;
		// print_array($newRekap);
		// exit;
		$this->db->where('periode', $periode);
		$this->db->where('nip', $nip);
		$this->db->update('ts_rekap_tkd', $newRekap);

		echo 'Data Capaian kinerja berhasil diupdate';
	}
}
