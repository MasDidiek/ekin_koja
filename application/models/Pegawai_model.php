<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Pegawai_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}


	function getPegawaiforListingTKD($thn_anggaran)
	{
		$this->db->order_by('mst_pegawai.id_jabatan', 'ASC');
		$this->db->orderP = t_by('mst_pegawai.tgl_masuk', 'ASC');
		$this->db->where('jns_pegawai', 'non_pns');
		$this->db->where('status_kerja >', 0);
		$this->db->where('tahun_anggaran', $thn_anggaran);
		$this->db->select('mst_pegawai.nip, mst_pegawai.staP=ttus_kerja, mst_pegawai.nama, mst_pegawai.tgl_masuk, mst_jabatan.nama AS jabatan, detail_pegawai.npwp, detail_pegawai.no_rekening, gaji_pegawai.*');
		$this->db->from('mst_pegawai');
		$this->db->join('mst_jabatan', 'mst_pegawai.id_jabatan = mst_jabatan.id');
		$this->db->join('detail_pegawai', 'mst_pegawai.nip = detail_pegawai.nip');
		$this->db->join('gaji_pegawai', 'mst_pegawai.id_pegawai = gaji_pegawai.id_pegawai');

		$qry = $this->db->get();

		$row = $qry->result();
		return $row;
	}

	function countTotalPegawai()
	{
		$jns_pegawai = 'non_pns';
		$thn_anggaran = 2024;
	}


	function getListPegawai($jns_pegawai, $thn_anggaran, $filters = array())
	{
		$this->db->order_by('mst_pegawai.nama', 'ASC');

		if ($jns_pegawai == 'non_pns') {
			$this->db->where('mst_pegawai.jns_pegawai', $jns_pegawai);
			$this->db->where('mst_pegawai.tahun_anggaran', $thn_anggaran);
			$this->db->where('mst_pegawai.is_deleted', 0);

			$this->db->select('mst_pegawai.*, mst_jabatan.nama AS jabatan, mst_puskesmas.nama AS puskesmas, gj.gaji_pokok, gj.pengkalian, gj.pph21, gj.bpjs_kes, gj.bpjs_tk');
			$this->db->from('mst_pegawai');
			$this->db->join('mst_jabatan', 'mst_pegawai.id_jabatan = mst_jabatan.id', 'left');
			$this->db->join('mst_puskesmas', 'mst_pegawai.id_puskesmas = mst_puskesmas.id_puskesmas', 'left');
			$this->db->join('gaji_pegawai gj', 'mst_pegawai.id_pegawai = gj.id_pegawai', 'left');
		} else {
			$this->db->where('mst_pegawai.jns_pegawai', $jns_pegawai);
			$this->db->select('mst_pegawai.*, mst_jabatan.nama AS jabatan, mst_puskesmas.nama AS puskesmas');
			$this->db->from('mst_pegawai');
			$this->db->join('mst_jabatan', 'mst_pegawai.id_jabatan = mst_jabatan.id', 'left');
			$this->db->join('mst_puskesmas', 'mst_pegawai.id_puskesmas = mst_puskesmas.id_puskesmas', 'left');
		}

		// --- MANAJEMEN FILTER ---
		// Filter status kerja dari GET request, jika kosong bisa di-set default jika diperlukan
		if (isset($filters['status']) && $filters['status'] !== '') {
			$this->db->where('mst_pegawai.status_kerja', $filters['status']);
		}

		if (!empty($filters['id_jabatan'])) {
			$this->db->where('mst_pegawai.id_jabatan', $filters['id_jabatan']);
		}

		if (!empty($filters['id_puskesmas'])) {
			$this->db->where('mst_pegawai.id_puskesmas', $filters['id_puskesmas']);
		}

		if (!empty($filters['q'])) {
			$this->db->group_start();
			$this->db->like('mst_pegawai.nama', $filters['q']);
			$this->db->or_like('mst_pegawai.nip', $filters['q']);
			$this->db->group_end();
		}
		$qry = $this->db->get();
		return $qry->result();
	}
	// function getListPegawai($jns_pegawai, $thn_anggaran, $status_kerja = 1)
	// {P=t
	// 	$this->db->order_by('nama', 'ASC');

	// 	#$qry = $this->db->get_where('mst_pegawai', array('jns_pegawai'=> $jns_pegawai,'tahun_anggaran'=> $thn_anggaran, 'status_kerja !='=> 0));
	// 	if ($jns_pegawai == 'non_pns') {
	// 		$this->db->where('jns_pegawai', $jns_pegawai);
	// 		$this->db->where('tahun_anggaran', $thn_anggaran);
	// 		$this->db->where('is_deleted', 0);
	// 		if ($status_kerja < 3) {
	// 			$this->db->where('status_kerja', $status_kerja);
	// 		}

	// 		$this->db->select('mst_pegawai.*, mst_jabatan.nama AS jabatan, mst_puskesmas.nama AS puskesmas, gj.gaji_pokok, gj.pengkalian, gj.pph21,gj.bpjs_kes, gj.bpjs_tk');
	// 		$this->db->from('mst_pegawai');
	// 		$this->db->join('mst_jabatan', 'mst_pegawai.id_jabatan = mst_jabatan.id');
	// 		$this->db->join('mst_puskesmas', 'mst_pegawai.id_puskesmas = mst_puskesmas.id_puskesmas');
	// 		$this->db->join('gaji_pegawai gj', 'mst_pegawai.id_pegawai = gj.id_pegawai', 'left');
	// 	} else {
	// 		$this->db->where('jns_pegawai', $jns_pegawai);
	// 		$this->db->select('mst_pegawai.*, mst_jabatan.nama AS jabatan, mst_puskesmas.nama AS puskesmas');
	// 		$this->db->from('mst_pegawai');
	// 		$this->db->join('mst_jabatan', 'mst_pegawai.id_jabatan = mst_jabatan.id', 'left');
	// 		$this->db->join('mst_puskesmas', 'mst_pegawai.id_puskesmas = mst_puskesmas.id_puskesmas');
	// 	}

	// 	$qry = $this->db->get();

	// 	//echo $this->db->last_query();

	// 	$row = $qry->result();
	// 	return $row;
	// }


	function getDetailPegawai($id_pegawai)
	{


		$this->db->where('mst_pegawai.id_pegawai', $id_pegawai);
		$this->db->select('mst_pegawai.*, mst_jabatan.nama AS jabatan, mst_puskesmas.nama AS puskesmas, gaji_pegawai.gaji_pokok, gaji_pegawai.pengkalian, gaji_pegawai.pph21, gaji_pegawai.bpjs_kes, gaji_pegawai.bpjs_tk');
		$this->db->from('mst_pegawai');
		$this->db->join('mst_jabatan', 'mst_pegawai.id_jabatan = mst_jabatan.id');
		$this->db->join('mst_puskesmas', 'mst_pegawai.id_puskesmas = mst_puskesmas.id_puskesmas');
		$this->db->join('gaji_pegawai', 'mst_pegawai.id_pegawai = gaji_pegawai.id_pegawai', 'left');

		$qry = $this->db->get();

		$row = $qry->result();
		return $row;
	}

	function cekData($nip)
	{
		#$this->db->order_by('tahun_anggaran','2024');
		$this->db->where('tahun_anggaran', '2024');
		$qry = $this->db->get_where('mst_pegawai', array('nip' => $nip));
		//$row = $qry->num_rows();
		//return $row;

		$row = $qry->result();
		if (!empty($row)) {
			$id_pegawai = $row[0]->id_pegawai;
		} else {
			$id_pegawai = 0;
		}


		return $id_pegawai;
	}

	function getPegawaiPenilaianKinerja($id_validator, $thn_anggaran)
	{
		$qry = $this->db->get_where(
			'mst_pegawai',
			array(
				'id_validator' => $id_validator,
				'tahun_anggaran' => $thn_anggaran
			)
		);
		$row = $qry->result();
		return $row;
	}




	function getDataListpegawaiAbsen($filter)
	{

		$this->db->order_by('nama', 'ASC');
		$this->db->where('id_validator', $filter['id_validator']);
		$this->db->where('jns_pegawai', $filter['jenis_pegawai']);
		$this->db->where('status_kerja > ', 0);
		$this->db->select('mst_pegawai.*, mst_jabatan.nama AS jabatan, mst_puskesmas.nama AS puskesmas');
		$this->db->from('mst_pegawai');
		$this->db->join('mst_jabatan', 'mst_pegawai.id_jabatan = mst_jabatan.id');
		$this->db->join('mst_puskesmas', 'mst_pegawai.id_puskesmas = mst_puskesmas.id_puskesmas');

		$qry = $this->db->get();

		$row = $qry->result();




		return $row;
	}


	function getListPegawaiByValidator($id_validator, $thn_anggaran, $status_kerja = 1)
	{


		$this->db->order_by('nama', 'ASC');
		$this->db->where('id_validator', $id_validator);
		$this->db->where('jns_pegawai', 'non_pns');
		$this->db->where('tahun_anggaran', $thn_anggaran);
		if ($status_kerja < 3) {
			$this->db->where('status_kerja', $status_kerja);
		}

		$this->db->select('mst_pegawai.*, mst_jabatan.nama AS jabatan, mst_puskesmas.nama AS puskesmas');
		$this->db->from('mst_pegawai');
		$this->db->join('mst_jabatan', 'mst_pegawai.id_jabatan = mst_jabatan.id');
		$this->db->join('mst_puskesmas', 'mst_pegawai.id_puskesmas = mst_puskesmas.id_puskesmas');

		$qry = $this->db->get();

		$row = $qry->result();




		return $row;
	}


	function getpegawaiCuti()
	{
		$qry = $this->db->get_where('mst_pegawai_cuti', array('jns_pegawai' => 'pns'));
		$row = $qry->result();
		return $row;
	}

	function getDataPegawai($id_pegawai, $select)
	{
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->select($select);

		$qry = $this->db->get('mst_pegawai');
		$row = $qry->result();
		return $row;
	}

	function getDataEditPegawai($id_pegawai)
	{

		$qry = $this->db->get_where('mst_pegawai', array('id_pegawai' => $id_pegawai));
		$row = $qry->result();
		return $row;
	}


	function getPegawaiPerbagian($bagian)
	{
		if ($bagian == 41) {
			$this->db->select('nama, id_pjlp, nip, id_mesin, id as id_pegawai');
			$qry = $this->db->get_where('tbl_pegawai_pjlp', array('bagian_shift > ' => 0));
		} else {
			$this->db->select('nama, id_pegawai, nip, id_mesin');
			$qry = $this->db->get_where('mst_pegawai', array('bagian_shift' => $bagian, 'tahun_anggaran' => 2024));
		}

		$row = $qry->result();


		return $row;
	}
	function getDataGajiPegawai($id_pegawai)
	{
		$qry = $this->db->get_where('gaji_pegawai', array('id_pegawai' => $id_pegawai));
		$row = $qry->result();
		return $row;
	}


	function checkJenisJamKerja($id_pegawai)
	{
		$this->db->select('jns_jam_kerja');
		$qry = $this->db->get_where('mst_pegawai', array('id_pegawai' => $id_pegawai));
		$row = $qry->result();
		$jns_jam_kerja = $row[0]->jns_jam_kerja;
		return $jns_jam_kerja;
	}


	function getNamaPegawaiByID($id_pegawai)
	{
		$this->db->select('nama');
		$row = $this->db->get_where('mst_pegawai', ['id_pegawai' => $id_pegawai])->row();
		return (isset($row->nama) && $row->nama != '') ? $row->nama : '-';
	}

	function getPegawaiByNama($nama)
	{
		$tahun = 2024;
		$this->db->where('nama', $nama);
		$this->db->where('tahun_anggaran', $tahun);
		$qry =  $this->db->get('mst_pegawai');
		$row = $qry->result();


		return $row;
	}

	function getKapuskec()
	{
		$this->db->select('nama, nip');
		$this->db->where('usergroup', 1);
		$qry =  $this->db->get('mst_pegawai');
		$row = $qry->result();


		return $row;
	}
	public function search_pegawai($keyword = '')
	{
		// Hindari query jika keyword kosong
		if (empty($keyword)) {
			return array();
		}

		$this->db->select('id_pegawai, nama, nip');
		$this->db->from('mst_pegawai');
		$this->db->like('nama', $keyword);
		$this->db->where('status_kerja >', 0);

		$query = $this->db->get();
		return $query->result();
	}

	function getDataDetailPegawai($nip)
	{
		$qry = $this->db->get_where('detail_pegawai', array('nip' => $nip));
		$row = $qry->result();
		return $row;
	}



	function getHakCutiPegawai($id_pegawai, $tahun, $jns_hak_cuti = "tahunan")
	{

		if ($jns_hak_cuti == 'bersama') {
			$qry = $this->db->get_where('ts_hak_cuti_bersama', ['tahun' => $tahun, 'id_pegawai' => $id_pegawai]);
		} else {
			$qry =  $this->db->get_where('ts_hak_cuti_pegawai', ['tahun' => $tahun, 'id_pegawai' => $id_pegawai]);
		}

		$row = $qry->row();
		return $row;
		#hak cuti 1 = sisa cuti tahun lalu, 2 = hak cuti tahun ini, 3 = hak cuti bersama

	}


	/*

	function getHakCutiPegawai($id_pegawai, $jns_hak_cuti, $order='ASC'){

		#hak cuti 1 = sisa cuti tahun lalu, 2 = hak cuti tahun ini, 3 = hak cuti bersama
		$this->db->order_by('id', $order);
		$qry = $this->db->get_where('cuti_pegawai', array('id_pegawai'=> $id_pegawai, 'jns_hak_cuti'=> $jns_hak_cuti));
		$row = $qry->result();
		return $row;
	}
*/
	// function getDetailPegawai($id_pegawai){
	// 	$this->db->where('mst_pegawai.id_pegawai', $id_pegawai);
	// 	$this->db->select('mst_pegawai.*, detail_pegawai.*, gaji_pegawai.*');
	// 	$this->db->from('mst_pegawai');
	// 	$this->db->join('detail_pegawai', 'mst_pegawai.nip = detail_pegawai.nip', 'left');
	// 	$this->db->join('gaji_pegawai', 'mst_pegawai.id_pegawai = gaji_pegawai.id_pegawai', 'left');

	//     $qry = $this->db->get();

	// 	$row = $qry->result();
	// 	return $row;

	// }


	function getValidator()
	{
		$this->db->order_by('usergroup', 'ASC');
		$this->db->where('usergroup < ', 4);
		$this->db->where('usergroup >= ', 1);
		$qry = $this->db->get('mst_pegawai');
		$row = $qry->result();
		return $row;
	}


	// function getPJ_PJLP(){
	// 	$this->db->order_by('usergroup', 'ASC');
	// 	$this->db->where('usergroup', 8);
	// 	$qry = $this->db->get('mst_pegawai');
	// 	$row = $qry->result();
	// 	return $row;
	// }

	function getListPJLP($limit = 10, $offset = 0)
	{

		$this->db->order_by('nama', 'ASC');
		$qry = $this->db->get('tbl_pegawai_pjlp', $limit, $offset);
		$row = $qry->result();

		return $row;
	}

	function countPegawaiPJLP()
	{
		$this->db->select('id');
		$qry = $this->db->get('tbl_pegawai_pjlp');
		$row = $qry->num_rows();
		return $row;
	}



	function getPegawaiPJLP()
	{
		$this->db->order_by('nama', 'ASC');
		$qry = $this->db->get('tbl_pegawai_pjlp');
		$row = $qry->result();
		return $row;
	}


	function getDataEditPegawaiPJLPByID($id)
	{

		$qry = $this->db->get_where('tbl_pegawai_pjlp', array('id' => $id));
		//$qry = $this->db->get_where('tbl_pegawai_pjlp', array('id' => $id_pjlp));
		$row = $qry->result();
		return $row;
	}

	function getDataEditPegawaiPJLP($id_pjlp)
	{

		$qry = $this->db->get_where('tbl_pegawai_pjlp', array('id_pjlp' => $id_pjlp));
		//$qry = $this->db->get_where('tbl_pegawai_pjlp', array('id' => $id_pjlp));
		$row = $qry->result();
		return $row;
	}

	function insertNewPegawaiPJLP()
	{

		$data = array(
			'nama' => $this->input->post('nama'),
			'id_pjlp' => $this->input->post('id_pjlp'),
			'id_mesin' =>  $this->input->post('id_mesin'),
			'jabatan' =>  $this->input->post('jabatan'),
			'lokasi_kerja' => $this->input->post('lokasi_kerja'),
		);

		$this->db->insert('tbl_pegawai_pjlp', $data);

		return true;
	}

	function getNoKTP($nip)
	{
		$this->db->select('no_ktp');
		$qry = $this->db->get_where('detail_pegawai', array('nip' => $nip));
		$row = $qry->result();
		$no_ktp = $row[0]->no_ktp;
		return $no_ktp;
	}


	public function getPhotoPegawai($nip)
	{
		$this->db->select('photo');
		$qry = $this->db->get_where('detail_pegawai', array('nip' => $nip));
		$row = $qry->result();

		if (!empty($row)) {

			$photo = $row[0]->photo;

			if ($photo == '') {
				$photo = 'avatar.png';
			}
		} else {
			$photo = 'avatar.png';
		}

		return $photo;
	}

	function getIDpegawaiByName($nama)
	{
		$this->db->select('id_pegawai');
		$qry = $this->db->get_where('mst_pegawai', array('nama' => $nama, 'tahun_anggaran' => '2024'));
		$row = $qry->result();

		if (!empty($row)) {
			$id_pegawai = $row[0]->id_pegawai;
		} else {
			$id_pegawai = 0;
		}
		return $id_pegawai;
	}

	function cekNoKTP($nik)
	{
		$this->db->select('nip');
		$qry = $this->db->get_where('detail_pegawai', array('no_ktp' => $nik));
		$row = $qry->result();

		if (!empty($row)) {
			$nip = $row[0]->nip;
		} else {
			$nip = 0;
		}
		return $nip;
	}

	function getNamaByNip($nip, $ta)
	{
		$this->db->select('nama');
		$qry = $this->db->get_where('mst_pegawai', array('nip' => $nip, 'tahun_anggaran' => $ta));
		$row = $qry->result();

		if (!empty($row)) {
			$nama = $row[0]->nama;
		} else {
			$nama = '-';
		}
		return $nama;
	}

	function getIDpegawaiByNIP($nip, $ta)
	{
		$this->db->select('id_pegawai');
		$qry = $this->db->get_where('mst_pegawai', array('nip' => $nip, 'tahun_anggaran' => $ta));
		$row = $qry->result();

		if (!empty($row)) {
			$nip = $row[0]->id_pegawai;
		} else {
			$nip = 0;
		}
		return $nip;
	}

	function getNipPegawaiByID($id_pegawai)
	{
		$this->db->select('nip');
		$qry = $this->db->get_where('mst_pegawai', array('id_pegawai' => $id_pegawai));
		$row = $qry->result();

		if (!empty($row)) {
			$nip = $row[0]->nip;
		} else {
			$nip = 0;
		}
		return $nip;
	}



	function insertDataGaji($id_pegawai, $gaji_pokok, $pengkalian, $pph21, $bpjs_kes, $bpjs_tk, $ptkp)
	{
		$data = array(
			'id_pegawai' => $id_pegawai,
			'gaji_pokok' => $gaji_pokok,
			'pengkalian' => $pengkalian,
			'pph21' =>  $pph21,
			'bpjs_kes' => $bpjs_kes,
			'bpjs_tk' => $bpjs_tk,
			'ptkp' => $ptkp
		);

		#print_array($data);
		$this->db->insert('gaji_pegawai', $data);
		return true;
	}

	function insertDataDetail($nip, $npwp, $no_rekening, $no_ktp, $tempat_lahir, $tgl_lahir, $alamat_ktp, $alamat_domisili, $no_tlp, $email, $photo)
	{
		$data = array(
			'nip' => $nip,
			'npwp' => $npwp,
			'no_rekening' => $no_rekening,
			'no_ktp' =>  $no_ktp,
			'tempat_lahir' => $tempat_lahir,
			'tgl_lahir' => $tgl_lahir,
			'alamat_ktp' => $alamat_ktp,
			'alamat_domisili' => $alamat_domisili,
			'no_tlp' => $no_tlp,
			'email ' => $email,
			'photo' => $photo,
		);


		$cekData = $this->cekDataDetailPegawai($nip);
		if ($cekData == false) {
			$this->db->insert('detail_pegawai', $data);
		} else {
			$this->db->where('nip', $nip);
			$this->db->update('detail_pegawai', $data);
		}
		#print_array($data);

		return true;
	}

	function cekDataDetailPegawai($nip)
	{
		$qry = $this->db->get_where('detail_pegawai', array('nip' => $nip));
		$row = $qry->result();
		$num = $qry->num_rows();
		if ($num == 0) {
			return false;
		} else {
			return true;
		}
	}

	function updateDataDetailPegawai($nip)
	{
		$data = array(
			'npwp' => $this->input->post('npwp'),
			'no_rekening' => $this->input->post('no_rekening'),
			'no_ktp' =>  $this->input->post('nik'),
			'email' =>  $this->input->post('email'),
			'no_tlp' =>  $this->input->post('no_telp'),

		);

		#print_array($data);
		$this->db->where('nip', $nip);
		$this->db->update('detail_pegawai', $data);
		return true;
	}

	function insertNewPegawai()
	{
		$tgl_masuk = $this->input->post('tmt');
		$nip = $this->input->post('nip');

		$data = array(
			'nama' => $this->input->post('nama'),
			'nip' => $nip,
			'nrk' =>  $this->input->post('nrk'),
			'golongan' =>  $this->input->post('golongan'),
			'id_puskesmas' => $this->input->post('id_puskesmas'),
			'rumpun_kerja' => $this->input->post('rumpun_kerja'),
			'id_jabatan' => $this->input->post('id_jabatan'),
			'id_poli' => $this->input->post('id_poli'),
			'tgl_masuk' => format_db($tgl_masuk),
			'tmt' => format_db($tgl_masuk),
			'jns_pegawai' => $this->input->post('jns_pegawai'),
			'jns_jam_kerja' => $this->input->post('jns_jam_kerja'),
			'status_kawin' => $this->input->post('status_kawin'),
			'status_pajak' => $this->input->post('status_pajak'),
			'id_pendidikan' =>  $this->input->post('id_pendidikan'),
			'id_validator' => $this->input->post('id_validator'),
			'usergroup' => $this->input->post('usergroup'),
			'password' => md5('123456'),
			'kategori_masa_kerja' => 1,
			'masa_kerja' => '0-0-1',
			'tahun_anggaran' => '2024'

		);


		$this->db->insert('mst_pegawai', $data);

		$this->insertDataDetail($nip, 0, 0, 0, '', '0000-00-00', '', '', '08', '@gmail.com', 'dummy.png');

		$id_pegawai = $this->getlastIDPegawai();

		$this->insertDataGaji($id_pegawai, 0, 0, 0, 0, 0, 0);

		return true;
	}

	function getlastIDPegawai()
	{
		$this->db->select('id_pegawai');
		$this->db->order_by('id_pegawai', 'DESC');
		$qry = $this->db->get('mst_pegawai', 1, 0);
		$row = $qry->result();
		$id_pegawai = $row[0]->id_pegawai;
		return $id_pegawai;
	}


	function updateDataPegawai($id_pegawai)
	{
		$tgl_masuk = $this->input->post('tmt');
		$data = array(
			'nama' => $this->input->post('nama'),
			'nip' => $this->input->post('nip'),
			'nrk' =>  $this->input->post('nrk'),
			'golongan' =>  $this->input->post('golongan'),
			'id_puskesmas' => $this->input->post('id_puskesmas'),
			'rumpun_kerja' => $this->input->post('rumpun_kerja'),
			'id_jabatan' => $this->input->post('id_jabatan'),
			'id_poli' => $this->input->post('id_poli'),
			'tgl_masuk' => format_db($tgl_masuk),
			'tmt' => format_db($tgl_masuk),
			'jns_pegawai' => $this->input->post('jns_pegawai'),
			'jns_jam_kerja' => $this->input->post('jns_jam_kerja'),
			'status_kawin' => $this->input->post('status_kawin'),
			'status_pajak' => $this->input->post('status_pajak'),
			'id_pendidikan' =>  $this->input->post('id_pendidikan'),
			'id_validator' => $this->input->post('id_validator'),
			'id_mesin' =>  $this->input->post('id_mesin'),
			'usergroup' => $this->input->post('usergroup'),
			'klaster' => $this->input->post('klaster'),

		);

		// print_array($data);
		// exit;
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('mst_pegawai', $data);
		return true;
	}

	public function update_nip_pegawai($id_pegawai, $nip_baru)
	{
		// Update spesifik berdasarkan id_pegawai
		$this->db->where('id_pegawai', $id_pegawai);
		return $this->db->update('mst_pegawai', array('nip' => $nip_baru));

		// Karena ON UPDATE CASCADE pada foreign key id_pegawai sudah aktif,
		// data NIP di detail_pegawai otomatis ter-update di database jika diperlukan.
	}


	function updateDataGaji($id_pegawai)
	{

		$data = array(
			'gaji_pokok' => $this->input->post('gaji_pokok'),
			'pengkalian' => $this->input->post('pengkalian'),
			'pph21' =>  $this->input->post('pph21'),
			'bpjs_kes' =>  $this->input->post('bpjs_kes'),
			'bpjs_tk' => $this->input->post('bpjs_tk'),
			'ptkp' => $this->input->post('ptkp'),


		);

		// print_array($data);
		// exit;
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('gaji_pegawai', $data);
		return true;
	}
}
