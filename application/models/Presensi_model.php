<?php ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class Presensi_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

	// Ambil data absen 1 bulan penuh
	public function getAbsensiBulan($pin, $periode)
	{
		$this->db->where('pin', $pin); // Sesuaikan nama kolom ID di tabel absensi harian
		$this->db->like('tanggal', $periode, 'after');
		return $this->db->get('tbl_absensi_pjlp')->result();
	}

	// Logic Upsert (Insert/Update)
	public function saveRekapBulanan($data)
	{
		// Cek apakah row rekap sudah ada
		$this->db->where('id_pegawai', $data['id_pegawai']);
		$this->db->where('periode', $data['periode']);
		$cek = $this->db->get('ts_rekap_absensi_pjlp')->row();

		if ($cek) {
			// KONDISI UPDATE: Jika data sudah ada
			$this->db->where('id', $cek->id);
			return $this->db->update('ts_rekap_absensi_pjlp', $data);
		} else {
			// KONDISI INSERT: Jika data belum pernah ada
			return $this->db->insert('ts_rekap_absensi_pjlp', $data);
		}
	}

	function update_absensi_cuti($pin, $tanggal, $alasan_cuti)
	{
		$data = array(
			'shift' => 'OFF',
			'jam_masuk' => '00:00:00',
			'jam_pulang' => '00:00:00',
			'masuk' => 'CUTI',
			'pulang' => 'CUTI',
			'telat' => 0,
			'p_awal' => 0,
			'keterangan' => $alasan_cuti
		);


		//print_array($data);
		$this->db->where('pin', $pin);
		$this->db->where('tanggal', $tanggal);
		$this->db->update('tbl_absensi', $data);

		return true;
	}


	function cekLogImport($sn)
	{
		$this->db->order_by('tanggal', 'DESC');

		$qry = $this->db->get_where('log_import_absensi', array('sn' => $sn), 1, 0);
		$row = $qry->result();
		return $row;
	}

	function getNamaPuskesmas($id_puskesmas)
	{
		$this->db->where('id_puskesmas', $id_puskesmas);
		$qry = $this->db->get('mst_puskesmas');
		$row = $qry->result();
		$nama = $row[0]->nama;

		return $nama;
	}

	function getListPuskesmas()
	{

		$this->db->order_by('id_puskesmas', 'ASC');
		$qry = $this->db->get('mst_puskesmas');
		$row = $qry->result();
		return $row;
	}




	function insertDataPegawai()
	{


		$new_data = array(
			'nama_pegawai' => $this->input->post('nama'),
			'nip' => $this->input->post('nip'),
			'pin' => $this->input->post('pin'),
			'rumpun_kerja' => $this->input->post('rumpun_kerja'),
			'id_puskesmas' => $this->input->post('puskesmas'),
			'shift' => $this->input->post('shift'),
			'jns_pegawai' => 'reg',
			'status' => 1
		);

		#print_array($new_data );
		$this->db->insert('mst_pegawai', $new_data);

		return true;
	}


	function updateStatusAbsensiRekap($id_rekap)
	{
		$this->db->where('id', $id_rekap);
		$this->db->set('status', 1);
		$this->db->update('ts_rekap_absensi');

		return true;
	}


	function countAbsenSesuai($periode, $status = 0)
	{

		$qry = $this->db->get_where('ts_rekap_absensi', array('periode' => $periode, 'status' => $status));
		$row = $qry->num_rows();
		return $row;
	}


	function updateDataPegawai($id_pegawai)
	{


		$new_data = array(
			'nama_pegawai' => $this->input->post('nama'),
			'nip' => $this->input->post('nip'),
			'pin' => $this->input->post('pin'),
			'rumpun_kerja' => $this->input->post('rumpun_kerja'),
			'id_puskesmas' => $this->input->post('puskesmas'),
			'shift' => $this->input->post('shift'),
		);

		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->update('mst_pegawai', $new_data);

		return true;
	}

	function getIDPegawaiByNip($nip)
	{

		$qry = $this->db->get_where('mst_pegawai', array('nip' => $nip));
		$row = $qry->result();
		$id_pegawai = $row[0]->id_pegawai;
		return $id_pegawai;
	}



	function getListPegawai()
	{
		$thn_anggaran = '2024';
		$qry = $this->db->get_where('mst_pegawai', array('jns_pegawai' => 'non_pns', 'status_kerja > ' => 0, 'tahun_anggaran' => $thn_anggaran), 25, 0);
		$row = $qry->result();
		return $row;
	}

	function getListPegawaiUKP_UKM($rumpun_kerja)
	{
		$thn_anggaran = '2024';
		$qry = $this->db->get_where('mst_pegawai', array('jns_pegawai' => 'non_pns', 'status_kerja > ' => 0, 'rumpun_kerja' => $rumpun_kerja, 'tahun_anggaran' => $thn_anggaran));
		$row = $qry->result();
		return $row;
	}
	function getListPegawaiKelurahan($id_puskesmas)
	{
		$thn_anggaran = '2024';
		$this->db->order_by('nama', 'ASC');
		$qry = $this->db->get_where('mst_pegawai', array('jns_pegawai' => 'non_pns', 'status_kerja > ' => 0, 'id_puskesmas' => $id_puskesmas, 'tahun_anggaran' => $thn_anggaran));
		$row = $qry->result();
		return $row;
	}



	function getDataCutiPegawai($id_pegawai)
	{
		$this->db->order_by('tgl', 'DESC');
		$qry = $this->db->get_where('ts_cuti', array('id_pegawai' => $id_pegawai), 5, 0);
		$row = $qry->result();
		return $row;
	}
	function deleteAbsenCuti($id_cuti)
	{

		$this->db->where('id', $id_cuti);
		$this->db->delete('absensi_cuti');
		return true;
	}



	function cekCutiPegawai($id_pegawai, $tanggal)
	{

		$qry = $this->db->get_where('absensi_cuti', array('id_pegawai' => $id_pegawai, 'tanggal' => $tanggal));
		$row = $qry->result();
		return $row;
	}

	public function cekHariLibur($tanggal)
	{
		$qry = $this->db->get_where('ts_hari_libur', ['tgl' => $tanggal]);
		return $qry->result(); // jika ada isi array, jika kosong berarti bukan libur
	}



	// function cekHariLibur($tanggal)
	// {

	// 	$qry = $this->db->get_where('ts_hari_libur', array('tgl' => $tanggal));
	// 	$row = $qry->result();
	// 	return $row;
	// }



	function insertPengajuanIzinSakit($id_pegawai, $tgl, $jns_absensi, $ket)
	{
		$newarray = array(
			'id_pegawai' => $id_pegawai,
			'tanggal ' => $tgl,
			'jenis_absen' => $jns_absensi,
			'status' => 1,
			'keterangan' => $ket
		);


		$this->db->insert('pengajuan_izin_sakit', $newarray);

		// print_array($newarray);
		// exit;

		return true;
	}

	function cekIzinSakit($id_pegawai, $tanggal)
	{

		$qry = $this->db->get_where('pengajuan_izin_sakit', array('id_pegawai' => $id_pegawai, 'tanggal' => $tanggal));
		$row = $qry->result();
		return $row;
	}

	function pengajuanDinasLuarPegawai($id_validator = 0, $status = '')
	{

		$periode_bulan = $this->session->userdata('periode_bulan');
		$periode_tahun = $this->session->userdata('periode_tahun');


		if ($periode_bulan == '') {
			$bulan = date('m');
			$tahun = date('Y');
		} else {
			$bulan = $periode_bulan;
			$tahun = $periode_tahun;
		}
		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));


		#	print_array($this->session->userdata);
		if ($id_validator == 0) {
			$and = "";
		} else {
			$and = "AND b.id_validator = $id_validator";
		}

		if ($status == 'Pending') {
			$AND2 = "AND status = 0";
		} elseif ($status == 'Disetujui') {
			$AND2 = "AND status = 1";
		} elseif ($status == 'Ditolak') {
			$AND2 = "AND status = 2";
		} else {
			$AND2 = "";
		}
		// $sql = "SELECT a.*, b.nama
		// FROM pengajuan_dinas_luar a
		// LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai WHERE status = 0 AND tanggal >= '2024-02-01' $and ";

		$sql = "SELECT a.*, b.nama
			FROM pengajuan_dinas_luar a
			LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai WHERE  tanggal LIKE '$periode%' $and $AND2";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}


	function getDetailPengajuanDinasLuar($id_pengajuan)
	{
		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id' => $id_pengajuan));
		$row = $qry->row();
		return $row;
	}


	function getDataPengajuanDLByJenis($id_pegawai, $tanggal, $jns_dl = 'DLP')
	{

		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id_pegawai' => $id_pegawai, 'tanggal' => $tanggal, 'jns_dl' => $jns_dl));
		$row = $qry->row();

		return $row;
	}


	function getDataPengajuanDL($id_pegawai, $tanggal)
	{


		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id_pegawai' => $id_pegawai, 'tanggal' => $tanggal));
		$row = $qry->result();
		return $row;
	}


	function getDataPengajuanDLPerbulan($id_pegawai, $periode)
	{

		$sql = "SELECT * FROM pengajuan_dinas_luar WHERE id_pegawai = $id_pegawai AND tanggal like '$periode%' order by tanggal ASC";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}

	function deletePengajuanIzinSakit($id_pegawai, $tgl)
	{
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('tanggal', $tgl);
		$this->db->delete('pengajuan_izin_sakit');
		return true;
	}



	function cekDL($id_pegawai, $tanggal, $jns_dl)
	{

		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id_pegawai' => $id_pegawai, 'tanggal' => $tanggal, 'jns_dl' => $jns_dl, 'status' => 1));
		$row = $qry->result();
		return $row;
	}

	function cekDataShift($id_pegawai, $tanggal)
	{

		$qry = $this->db->get_where('shift_kerja', array('id_pegawai' => $id_pegawai, 'tanggal' => $tanggal));
		$row = $qry->result();
		return $row;
	}

	function deleteTblAbsensi($pin, $tanggal)
	{
		$this->db->where('pin', $pin);
		$this->db->where('tanggal', $tanggal);
		$this->db->delete('tbl_absensi');
		return true;
	}

	function deleteShiftPegawai($id_pegawai, $tanggal)
	{
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('tanggal', $tanggal);
		$this->db->delete('shift_kerja');
		return true;
	}


	// function insertAbsensiCuti($tanggal, $pin, $ket=''){

	// 	$cekAbsenExist = $this->cekAbsenExist($tanggal, $pin);
	// 	if($cekAbsenExist==false){
	// 		$newArray = array(
	// 			'tanggal' => $tanggal,
	// 			'pin' => $pin,
	// 			'shift' => 'REG',
	// 			'jam_masuk' => '07:30:00',
	// 			'jam_pulang' => '16:00:00',
	// 			'masuk' => 'CUTI',
	// 			'pulang' => 'CUTI',
	// 			'telat' => 0,
	// 			'p_awal' => 0,
	// 			'keterangan' =>  $ket
	// 		);

	// 		#print_array($newArray);

	// 	$this->db->insert('tbl_absensi', $newArray);

	// 	}else{

	// 		$id = $cekAbsenExist;
	// 		$newArray = array(
	// 			'masuk' => 'CUTI',
	// 			'pulang' => 'CUTI',
	// 			'telat' => 0,
	// 			'p_awal' => 0,
	// 			'keterangan' => ''
	// 		);

	// 		#print_array($newArray);
	// 		$this->db->where('id', $id);
	// 		$this->db->update('tbl_absensi', $newArray);

	// 	}

	// 	return true;


	// }

	function  updateShiftPegawai($pin, $tanggal, $shift, $id)
	{

		$JamKerjaShift = $this->detailShiftByKode($shift);
		$jamMasuk  = $JamKerjaShift->jam_masuk;
		$jamPulang  = $JamKerjaShift->jam_pulang;

		$newArray = array(
			'shift' => $shift,
			'jam_masuk' => $jamMasuk,
			'jam_pulang' => $jamPulang,
		);

		$this->db->where('id', $id);
		$this->db->update('tbl_absensi', $newArray);
	}

	function insertShiftPegawai($pin, $tanggal, $shift = null, $jam_masuk = null, $jam_pulang = null, $jam_masuk_shift = null, $jam_pulang_shift = null)
	{
		$sql = "
			INSERT INTO tbl_absensi
			(pin, tanggal, shift, masuk, pulang, jam_masuk, jam_pulang, telat, p_awal)
			VALUES (?, ?, ?, ?, ?, ?, ?, 0, 0)
			ON DUPLICATE KEY UPDATE
				shift = COALESCE(VALUES(shift), shift),
				masuk = COALESCE(VALUES(masuk), masuk),
				pulang = COALESCE(VALUES(pulang), pulang),
				jam_masuk = COALESCE(VALUES(jam_masuk), jam_masuk),
				jam_pulang = COALESCE(VALUES(jam_pulang), jam_pulang)
		";

		$this->db->query($sql, [$pin, $tanggal, $shift, $jam_masuk, $jam_pulang, $jam_masuk_shift, $jam_pulang_shift]);
	}


	public function getRekapImportSebulan($pin, $periode)
	{
		$sql = "
			SELECT 
				DATE(tanggal) as tanggal,
				MIN(TIME(tanggal)) as jam_masuk,
				MAX(TIME(tanggal)) as jam_pulang
			FROM import_absen
			WHERE pin = ?
			AND DATE_FORMAT(tanggal, '%Y-%m') = ?
			GROUP BY DATE(tanggal)
		";

		return $this->db->query($sql, [$pin, $periode])->result();
	}


	public function syncRawAbsensiOnlyIfEmpty($pin, $periode)
	{
		$rekap = $this->getRekapImportSebulan($pin, $periode);

		foreach ($rekap as $row) {
			$tanggal   = $row->tanggal;
			$jamMasuk  = $row->jam_masuk;
			$jamPulang = $row->jam_pulang;

			$existing = $this->db->get_where('tbl_absensi', array('pin' => $pin, 'tanggal' => $tanggal))->row();

			if ($existing) {
				$updateData = array();

				if (empty($existing->masuk)) {
					$updateData['masuk'] = $jamMasuk;
				}

				if (empty($existing->pulang)) {
					$updateData['pulang'] = $jamPulang;
				}

				if (!empty($updateData)) {
					$this->db->where('id', $existing->id);
					$this->db->update('tbl_absensi', $updateData);
				}
			}
		}
	}

	public function calculateTelatPawalSingle($jamMasukShift, $jamPulangShift, $absenMasuk, $absenPulang, $kodeShift = '')
	{
		$telat = 0;
		$p_awal = 0;

		if ($kodeShift == 'OFF' || $kodeShift == 'L-OFF') {
			return array('telat' => 0, 'p_awal' => 0);
		}

		$masukClean  = trim(strip_tags((string)$absenMasuk));
		$pulangClean = trim(strip_tags((string)$absenPulang));

		$isMasukTime       = (bool) preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $masukClean);
		$isPulangTime      = (bool) preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $pulangClean);
		$isShiftMasukTime  = (bool) preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', trim((string)$jamMasukShift));
		$isShiftPulangTime = (bool) preg_match('/^([0-1]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', trim((string)$jamPulangShift));

		// 1. Hitung Telat
		if ($isMasukTime && $isShiftMasukTime) {
			$tMasuk = strtotime($masukClean);
			$tShiftMasuk = strtotime(trim((string)$jamMasukShift));
			if ($tMasuk > $tShiftMasuk) {
				$telat = floor(($tMasuk - $tShiftMasuk) / 60);
			} else {
				$telat = 0;
			}
		} elseif ($masukClean === 'ALPHA') {
			$telat = 300;
		} else {
			$telat = 0;
		}

		// 2. Hitung Pulang Awal
		if ($isPulangTime && $isShiftPulangTime) {
			$tPulang = strtotime($pulangClean);
			$tShiftPulang = strtotime(trim((string)$jamPulangShift));
			if ($tPulang < $tShiftPulang) {
				$p_awal = floor(($tShiftPulang - $tPulang) / 60);
			} else {
				$p_awal = 0;
			}
		} elseif ($pulangClean === 'ALPHA') {
			$p_awal = 150;
		} else {
			$p_awal = 0;
		}

		return array('telat' => (int)$telat, 'p_awal' => (int)$p_awal);
	}

	public function recalculateTelatPawal($pin, $tanggal, $id_pegawai = null)
	{
		$row = $this->db->get_where('tbl_absensi', array('pin' => $pin, 'tanggal' => $tanggal))->row();
		if ($row) {
			$calc = $this->calculateTelatPawalSingle($row->jam_masuk, $row->jam_pulang, $row->masuk, $row->pulang, $row->shift);
			$this->db->where('id', $row->id);
			$this->db->update('tbl_absensi', array(
				'telat'  => $calc['telat'],
				'p_awal' => $calc['p_awal']
			));
		}

		$periode = date('Y-m', strtotime($tanggal));
		$this->recalculateTelatPawalPeriode($pin, $periode, $id_pegawai);
	}

	public function recalculateTelatPawalPeriode($pin, $periode, $id_pegawai = null)
	{
		$rows = $this->db->query("SELECT * FROM tbl_absensi WHERE pin = ? AND tanggal LIKE ? ORDER BY tanggal ASC", array($pin, $periode . '%'))->result();

		$totalTelat = 0;
		$totalPawal = 0;
		$numSakit = 0;
		$numIzin = 0;
		$numCuti = 0;
		$numDLP = 0;
		$numDLA = 0;
		$numDLH = 0;
		$numSakitDgnSK = 0;

		foreach ($rows as $row) {
			$calc = $this->calculateTelatPawalSingle($row->jam_masuk, $row->jam_pulang, $row->masuk, $row->pulang, $row->shift);
			$telat  = $calc['telat'];
			$p_awal = $calc['p_awal'];

			$this->db->where('id', $row->id);
			$this->db->update('tbl_absensi', array(
				'telat'  => $telat,
				'p_awal' => $p_awal
			));

			$totalTelat += $telat;
			$totalPawal += $p_awal;

			$m = trim((string)$row->masuk);
			$p = trim((string)$row->pulang);

			if ($m === 'SAKIT') $numSakit++;
			if ($m === 'IZIN') $numIzin++;
			if ($m === 'DLP') $numDLP++;
			if ($m === 'DLA') $numDLA++;
			if ($p === 'DLAK') $numDLH++;
			if ($m === 'SAKIT DGN SURAT') $numSakitDgnSK++;
			if ($m === 'CUTI') $numCuti++;
		}

		if (empty($id_pegawai)) {
			$peg = $this->db->get_where('mst_pegawai', array('pin' => $pin))->row();
			if ($peg) {
				$id_pegawai = isset($peg->id_pegawai) ? $peg->id_pegawai : (isset($peg->id) ? $peg->id : null);
			}
		}

		if (!empty($id_pegawai)) {
			$id_rekap = $this->cekDataRekapAbsensi($id_pegawai, $periode);
			if ($id_rekap == 0) {
				$this->rekapAbsensi($id_pegawai, $periode, $totalTelat, $totalPawal, $numIzin, $numSakit, $numDLP, $numDLA, $numDLH);
			} else {
				$this->updateRekapAbsensi($id_rekap, $totalTelat, $totalPawal, $numIzin, $numSakit, $numDLP, $numDLA, $numDLH, $numSakitDgnSK, $numCuti);
			}
		}
	}


	function getAbsensiSebulan($pin, $periode)
	{
		$this->db->where('pin', $pin);
		$this->db->like('tanggal', $periode, 'after');
		return $this->db->get('tbl_absensi')->result();
	}





	// function updateShiftPegawai($id, $shift){

	// 	$this->db->where('id', $id);
	// 	$this->db->set('shift', $shift);
	// 	$this->db->update('shift_kerja');
	// 	return true;
	// }


	function getRawAbensiPertanggal($pin, $tgl)
	{

		$this->db->where('pin', $pin);
		$this->db->order_by('tanggal', 'ASC');
		$this->db->like('tanggal', $tgl, 'after');
		$qry = $this->db->get('import_absen');
		$row = $qry->result();
		return $row;
	}
	function getRawAbensi($pin, $tgl)
	{

		$this->db->where('pin', $pin);
		$this->db->order_by('tanggal', 'ASC');
		$this->db->like('tanggal', $tgl, 'after');
		$qry = $this->db->get('import_absen');
		$row = $qry->result();
		return $row;
	}

	function getRawAbensiDB($pin, $tgl)
	{

		$this->db->where('pin', $pin);
		$this->db->order_by('tanggal', 'ASC');
		$this->db->like('tanggal', $tgl, 'after');
		$qry = $this->db->get('ts_absensi');
		$row = $qry->result();
		return $row;
	}


	function EditRawAbsen($id)
	{



		$sql = $this->db->get_where('import_absen', array('id' => $id));
		$row = $sql->result();

		$status = $row[0]->status;
		if ($status == 0) {
			$this->db->where('id', $id);
			$this->db->set('status', 1);
			$this->db->update('import_absen');
			echo '<span class="badge bg-warning">KEL</span>';
		} else {
			$this->db->where('id', $id);
			$this->db->set('status', 0);
			$this->db->update('import_absen');
			echo '<span class="badge bg-success">MSK</span>';
		}

		return true;
	}


	function cekAbsensi($tanggal, $pin)
	{
		$qry = $this->db->get_where('import_absen', array('tanggal' => $tanggal, 'pin' => $pin));
		$row = $qry->num_rows();
		return $row;
	}



	function deleteRawAbsensi($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('import_absen');
		return true;
	}


	function deleteDataShift($id_pegawai, $periode)
	{
		$sql = "DELETE FROM `shift_kerja` WHERE tanggal like '$periode%' AND id_pegawai= $id_pegawai";

		$this->db->query($sql);
		return true;
	}

	function deleteAbsenDL($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('pengajuan_dinas_luar');
		return true;
	}

	function deleteAbsenIzinSakit($id)
	{

		$this->db->where('id', $id);
		$this->db->delete('absensi_izin');
		return true;
	}

	function getNamaPegawai($id_pegawai)
	{

		$this->db->select('nama');
		$sql = $this->db->get_where('mst_pegawai', array('id_pegawai' => $id_pegawai));
		$row = $sql->result();

		$nama = $row[0]->nama;
		return $nama;
	}


	function getDataRekapAbsensiPegawai($id_pegawai, $periode = '2023-02')
	{
		$sql = "SELECT * FROM `ts_rekap_absensi` WHERE id_pegawai = $id_pegawai AND periode = '$periode' ORDER BY periode ASC";
		$qry = $this->db->query($sql);

		return $qry->result();
	}

	function getDataRekapAbsensi($periode, $order_by, $table = 'ts_rekap_absensi')
	{
		$this->db->order_by($order_by, "ASC");
		$sql = $this->db->get_where($table, array('periode' => $periode));
		$row = $sql->result();

		///print_array($row);
		return $row;
	}

	function cekDataRekapAbsensi($id_pegawai, $periode,  $table = 'ts_rekap_absensi')
	{
		$sql = $this->db->get_where($table, array('id_pegawai' => $id_pegawai, 'periode' => $periode));
		$row = $sql->result();

		if (empty($row)) {
			return 0;
		} else {
			$id = $row[0]->id;
			return $id;
		}
	}


	function insertDataCuti($data_cuti)
	{

		$this->db->insert_batch('absensi_cuti', $data_cuti);
		return true;
	}

	function getDataInitialShift($tgl)
	{
		$this->db->where('tgl', $tgl);
		$qry = $this->db->get('tbl_initial_shift');
		$row = $qry->result();
		return $row;
	}


	function getShiftKerja()
	{
		$this->db->where('status_kerja', 'non_pns');
		$this->db->where('publish', 1);
		$this->db->order_by('urutan', 'ASC');
		$qry = $this->db->get('mst_shift_kerja');
		$row = $qry->result();
		return $row;
	}

	function getIpaddressByPuskesmas($id_puskesmas, $ket = '')
	{

		$qry = $this->db->get_where('tbl_mesin_absensi', array('id_puskesmas' => $id_puskesmas, 'ket' => $ket));
		$row = $qry->result();
		$ip  = $row[0]->ip_address;
		return $ip;
	}

	function getDetPegawai($pin)
	{

		$qry = $this->db->get_where('mst_pegawai', array('pin' => $pin));
		$row = $qry->result();
		return $row;
	}

	function getdetPegawaiBYNIP($nip)
	{

		$qry = $this->db->get_where('mst_pegawai', array('nip' => $nip));
		$row = $qry->result();
		return $row;
	}


	function getRekapAbsensiPegawai($id_pegawai, $periode)
	{

		$qry = $this->db->get_where('ts_rekap_absensi', array('id_pegawai' => $id_pegawai, 'periode' => $periode));
		$row = $qry->result();
		return $row;
	}

	public function getShiftSebulan($id_pegawai, $periode)
	{
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('jns_pegawai', 'non_pns');
		$this->db->like('tanggal', $periode, 'after'); // '%2026-02%'
		$qry = $this->db->get('ts_shift_kerja');
		return $qry->result();
	}


	public function getShiftPegawai($id_pegawai, $tgl)
	{


		$qry = $this->db->get_where('ts_shift_kerja', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl));
		$row = $qry->result();
		if (!empty($row)) {
			$shift = $row[0]->shift;
			return $shift;
		} else {
			return '';
		}
	}


	function detailShiftByKode($kode)
	{
		$qry = $this->db->get_where('mst_shift_kerja', array('kode_shift' => $kode));
		//$row = $qry->result();
		$row = $qry->row(); // cukup 1 row

		return $row;
	}


	public function getDataAbsenRaw($pin, $tanggal = '2023-08')
	{

		$sql = "SELECT * FROM ts_import_absensi WHERE tanggal like '$tanggal%' AND pin = '$pin'";
		# echo $sql;
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}

	function insertDataAbsen($pin)
	{

		$tahun = $this->session->userdata('periode_tahun');
		$bulan = $this->session->userdata('periode_bulan');
		$periode = $tahun . '-' . $bulan;
		$periode = date('Y-m', strtotime($periode));

		$absen = $this->getDataAbsenRaw($pin,  $periode);

		for ($i = 0; $i < count($absen); $i++) {
			$datetime = $absen[$i]->tanggal;
			$status = $absen[$i]->status;
			$this->insertAbsensi($datetime, $pin, $status);
		}
		return true;
	}


	function insertAbsensi($datetime, $pin, $status)
	{
		$newArray = array(
			'tanggal' => $datetime,
			'pin' => $pin,
			'status' => $status
		);

		$this->db->insert('ts_absensi', $newArray);
		return true;
	}


	function insertAbsensiDL($pin, $tanggal, $jns_dl, $ket = '')
	{

		$cekAbsenExist = $this->cekAbsenExist($tanggal, $pin);
		if ($cekAbsenExist == false) {

			if ($jns_dl == 'DLA') {
				$newArray = array(
					'tanggal' => $tanggal,
					'pin' => $pin,
					'masuk' => $jns_dl,
					'pulang' => '',
					'telat' => 0,
					'p_awal' => 150,
					'keterangan' => $ket
				);
			} elseif ($jns_dl == 'DLAK') {
				$newArray = array(
					'tanggal' => $tanggal,
					'pin' => $pin,
					'masuk' => '',
					'pulang' => $jns_dl,
					'telat' => 300,
					'p_awal' => 0,
					'keterangan' => $ket
				);
			} else {
				$newArray = array(
					'tanggal' => $tanggal,
					'pin' => $pin,
					'masuk' => $jns_dl,
					'pulang' => $jns_dl,
					'telat' => 0,
					'p_awal' => 0,
					'keterangan' => $ket
				);
			}



			$this->db->insert('tbl_absensi', $newArray);
		} else {
			$id = $cekAbsenExist;


			if ($jns_dl == 'DLA') {
				$newArray = array(
					'masuk' => $jns_dl,
					'telat' => 0,
					'keterangan' => $ket
				);
			} elseif ($jns_dl == 'DLAK') {
				$newArray = array(
					'pulang' => $jns_dl,
					'p_awal' => 0,
					'keterangan' => $ket
				);


				// exit;
			} else {
				$newArray = array(
					'masuk' => $jns_dl,
					'pulang' => $jns_dl,
					'telat' => 0,
					'p_awal' => 0,
					'keterangan' => $ket
				);
			}

			$this->db->where('id', $id);
			$this->db->update('tbl_absensi', $newArray);
		}

		return true;
	}


	function insertAbsensiIzinSakit($pin, $tanggal, $jns_absen, $ket = '')
	{

		$cekAbsenExist = $this->cekAbsenExist($tanggal, $pin);

		if ($cekAbsenExist == false) {

			$newArray = array(
				'tanggal' => $tanggal,
				'pin' => $pin,
				'masuk' => $jns_absen,
				'pulang' => $jns_absen,
				'telat' => 0,
				'p_awal' => 0,
				'keterangan' => $ket
			);


			$this->db->insert('tbl_absensi', $newArray);
		} else {
			$id = $cekAbsenExist;

			$newArray = array(
				'masuk' => $jns_absen,
				'pulang' => $jns_absen,
				'telat' => 0,
				'p_awal' => 0,
				'keterangan' => $ket
			);


			$this->db->where('id', $id);
			$this->db->update('tbl_absensi', $newArray);
		}

		return true;
	}









	function insertAbsensiHarian($pin, $datetime,  $status,  $id_absen, $ket = '')
	{

		$explode = explode(" ", $datetime);
		$tanggal = $explode[0];
		$jam     = $explode[1];


		$masuk  = '';
		$pulang = '';

		if ($status == 0) {
			$masuk  = $jam;

			$newArray = array(
				'tanggal' => $tanggal,
				'pin' => $pin,
				'masuk' => $masuk,
				'telat' => 0,
				'keterangan' => $ket
			);
		}

		if ($status == 1) {
			$pulang  = $jam;
			$newArray = array(
				'tanggal' => $tanggal,
				'pin' => $pin,
				'pulang' => $pulang,
				'p_awal' => 0,
				'keterangan' => $ket
			);
		}


		//khusus untuk absensi IZIN, SAKIT, DL
		if ($status == 2) {
			$masuk  = $jam;
			$pulang  = $jam;

			$newArray = array(
				'tanggal' => $tanggal,
				'pin' => $pin,
				'masuk' => $masuk,
				'pulang' => $pulang,
				'telat' => 0,
				'p_awal' => 0,
				'keterangan' => $ket
			);
		}



		$cekAbsenExist = $this->cekAbsenExist($tanggal, $pin);
		if ($cekAbsenExist == false) {



			$this->db->insert('tbl_absensi', $newArray);
		} else {


			$data = array(
				'masuk' => $masuk,
				'pulang' => $pulang,
				'keterangan' => $ket
			);

			$this->db->where('pin', $pin);
			$this->db->where('tanggal', $tanggal);
			$this->db->update('tbl_absensi', $data);
		}

		$this->db->where('id', $id_absen);
		$this->db->set('status_update', 1);
		$this->db->update('ts_absensi');

		return true;
	}

	function getAbsensiPegawai($pin, $periode, $tbl = 'tbl_absensi')
	{

		$sql = "SELECT * FROM $tbl WHERE pin = '$pin' AND tanggal like '$periode%'  ORDER BY tanggal ASC";
		$qry = $this->db->query($sql);

		return $qry->result();
	}


	function modelDataAbsensi($pin, $id_pegawai, $id, $jns_jam_kerja, $hari, $absenMasuk, $absenPulang, $jamMasukKerja, $jamKeluarKerja, $formatDate, $kodeShift)
	{

		$tgl_now = date('Y-m-d');
		$keterangan_absen   = '';

		if ($jns_jam_kerja == 'non_shift') {

			//khusus untuk yang jam kerjanya shift
			if ($hari != 'Sabtu' && $hari != 'Minggu') {


				if ($absenMasuk == '' && $jamMasukKerja != '' && $formatDate < $tgl_now) {
					$absenMasuk = '<button class="btn-info-absensi flat-btn" value="' . $pin . '/' . $id_pegawai . '/' . $formatDate . '"
					data-bs-toggle="modal" data-bs-target="#edit-absensi">ALPHA</button>';
					$telat          = 300;

					if ($kodeShift == 'OFF') {
						$absenMasuk = '<button class="btn-borderless text-muted" value="' . $pin . '/' . $id_pegawai . '/' . $formatDate . '"
						data-bs-toggle="modal" data-bs-target="#edit-absensi">-</button>';
					}
				}


				if ($absenPulang == '' && $jamKeluarKerja != ''  && $formatDate < $tgl_now) {
					$absenPulang = '<button class="btn-info-absensi flat-btn" value="' . $pin . '/' . $id_pegawai . '/' . $formatDate . '"
					data-bs-toggle="modal" data-bs-target="#edit-absensi">ALPHA</button>';
					$p_awal         = 150;
					if ($kodeShift == 'OFF') {
						$absenPulang = '<button class="btn-borderless text-muted" value="' . $pin . '/' . $id_pegawai . '/' . $formatDate . '"
						data-bs-toggle="modal" data-bs-target="#edit-absensi">-</button>';
					}
				}
			}


			$hariLibur = $this->Presensi_model->cekHariLibur($formatDate);
			$hari_libur = false;
			if (!empty($hariLibur)) {
				$kodeShift         = '';
				$jamMasukKerja     = '-';
				$jamKeluarKerja    = '-';
				$bg_btn = 'btn btn-xs badge-danger-lighten';

				$absenMasuk         = '<span class="btn btn-xs badge-danger-lighten">LIBUR NASIONAL</span>';
				$absenPulang        =  '<span class="btn btn-xs  badge-danger-lighten">LIBUR NASIONAL</span>';
				$keterangan_absen   = $hariLibur[0]->keterangan;


				$telat          = 0;
				$p_awal         = 0;
				$hari_libur = true;
			}
		} else { // shift2an
			if ($kodeShift == 'P' || $kodeShift == 'S' || $kodeShift == 'PS') {


				if ($absenMasuk == '') {
					$absenMasuk = '<button class="btn-info-absensi flat-btn" value="' . $pin . '/' . $id_pegawai . '/' . $formatDate . '"
					data-bs-toggle="modal" data-bs-target="#edit-absensi">ALPHA</button>';
					$telat         = 300;
				}

				if ($absenPulang == '') {
					$absenPulang = '<button class="btn-info-absensi  flat-btn" value="' . $pin . '/' . $id_pegawai . '/' . $formatDate . '"
					data-bs-toggle="modal" data-bs-target="#edit-absensi">ALPHA</button>';
					$p_awal         = 150;
				}
			}

			if ($kodeShift == 'L-OFF') {

				if ($absenPulang == '') {
					$absenPulang = '<button class="btn-info-absensi flat-btn" value="' . $pin . '/' . $id_pegawai . '/' . $formatDate . '"
					data-bs-toggle="modal" data-bs-target="#edit-absensi">ALPHA</button>';
					$p_awal         = 150;
				}
			}

			if ($kodeShift == 'SM' || $kodeShift == 'M' || $kodeShift == 'PSM') {
				if ($absenMasuk == '' && $jamMasukKerja != '') {
					$absenMasuk = '<button class="btn-info-absensi   flat-btn" value="' . $pin . '/' . $id_pegawai . '/' . $formatDate . '"
					data-bs-toggle="modal" data-bs-target="#bs-example-modal-xlg">ALPHA</button>';
					$telat          = 300;
					$bg_btn = 'btn btn-xs btn-danger';
				}
			}
		} //close if juam kerja == shift


		if ($kodeShift == 'OFF') {
			$jamMasukKerja  = '';
			$jamKeluarKerja  = '';
			$bg_btn = 'btn btn-xs badge-danger-lighten';
		} else if ($kodeShift == 'L-OFF') {

			$bg_btn = 'btn btn-xs badge-warning-lighten';
			$jamMasukKerja  = '-';
		} else if ($kodeShift == 'N/A') {

			$bg_btn = '';
			$jamMasukKerja  = '-';
		} else {


			$bg_btn = 'btn btn-xs badge-info-lighten';
		}

		if ($jamKeluarKerja == '00:00:00') {
			$jamKeluarKerja  = '-';
		}

		if ($absenMasuk == 'CUTI') {
			$absenMasuk         = '<span class="text-success">CUTI</span>';
			$absenPulang        =  '<span class="text-success">CUTI</span>';
		}

		if ($absenMasuk == 'DLP') {
			$absenMasuk         = '<span class="text-info">DLP</span>';
			$absenPulang        =  '<span class="text-info">DLP</span>';
		}

		if ($absenMasuk == 'IZIN') {
			$absenMasuk         = '<span class="text-warning">IZIN</span>';
			$absenPulang        =  '<span class="text-warning">IZIN</span>';
		}

		if ($absenPulang == 'DLAK') {

			$absenPulang        =  '<span class=" text-info">DLAK</span>';
		}
		if ($absenMasuk == 'DLA') {

			$absenMasuk        =  '<span class="text-info">DLA</span>';
		}


		if ($absenMasuk == 'SAKIT') {
			$absenMasuk         = '<span class="text-warning"  value="' . format_view($formatDate) . '">SAKIT</span>';
			$absenPulang        =  '<span class="text-warning"  value="' . format_view($formatDate) . '">SAKIT</span>';
		}


		return array($bg_btn, $absenMasuk, $absenPulang);
	}



	function getDataAbsensi($pin, $tanggal, $table = "tbl_absensi")
	{
		$sql = $this->db->get_where($table, array('tanggal' => $tanggal, 'pin' => $pin));
		$row = $sql->result();

		return $row;
	}

	function getDataAbsensiHarian($tanggal, $pin)
	{
		$sql = $this->db->get_where('tbl_absensi', array('tanggal' => $tanggal, 'pin' => $pin));
		$row = $sql->result();

		return $row;
	}


	function insertAbsensiCuti($tgl_cuti, $pin, $alasan)
	{

		$cekAbsenExist = $this->Presensi_model->cekAbsenExist($tgl_cuti, $pin);


		if ($cekAbsenExist == false) {
			$newArray = array(
				'pin' => $pin,
				'tanggal' => $tgl_cuti,
				'shift' => 'OFF',
				'jam_masuk' => '00:00:00',
				'jam_pulang' => '00:00:00',
				'masuk' => 'CUTI',
				'pulang' => 'CUTI',
				'telat' => 0,
				'p_awal' => 0,
				'keterangan' => $alasan
			);

			$this->db->insert('tbl_absensi', $newArray);
		} else {

			$newArray = array(
				'shift' => 'OFF',
				'jam_masuk' => '00:00:00',
				'jam_pulang' => '00:00:00',
				'masuk' => 'CUTI',
				'pulang' => 'CUTI',
				'telat' => 0,
				'p_awal' => 0,
				'keterangan' => $alasan
			);

			$this->db->where('pin', $pin);
			$this->db->where('tanggal', $tgl_cuti);
			$this->db->update('tbl_absensi', $newArray);
		}
		return true;
	}


	function cekAbsenShiftKerja($pin, $periode)
	{
		$sql = "SELECT id FROM tbl_absensi WHERE pin = '$pin' AND tanggal like '$periode%' LIMIT 10";
		#echo $sql;
		$qry = $this->db->query($sql);
		$row = $qry->result();

		if (empty($row)) {
			//belum ada sama sekali
			return false;
		} else {
			return true;
		}
	}
	public function getJnsCuti($id_pegawai, $tgl)
	{
		$this->db->select('jenis_cuti');
		$this->db->from('ts_pengajuan_cuti');
		$this->db->where('id_pegawai', $id_pegawai);
		$this->db->where('status_akhir', 'Disetujui');
		// Menyusun kondisi BETWEEN
		$this->db->where("'$tgl' BETWEEN tgl_mulai AND tgl_selesai", NULL, FALSE);
		$this->db->limit(1);

		$query = $this->db->get();

		// Menggunakan row() untuk mengambil 1 baris objek secara langsung
		if ($query->num_rows() > 0) {
			return $query->row()->jenis_cuti;
		}

		return '-';
	}


	function cekAbsenExist($tanggal, $pin, $table = 'tbl_absensi')
	{
		$sql = $this->db->get_where($table, array('tanggal' => $tanggal, 'pin' => $pin));
		$row = $sql->result();

		if (empty($row)) {
			return 0;
		} else {
			$id = $row[0]->id;
			return $id;
		}
	}

	function updateAbsensiCancelCuti($id_cuti, $pin)
	{
		//klo cuti di cancel sedangkan cuti sudah diapprove, maka data absen harus dikembalikan

		$list_hari = $this->Cuti_model->getListHariCuti($id_cuti);
		#print_array($list_hari);
		for ($c = 0; $c < count($list_hari); $c++) {
			$tgl_cuti = $list_hari[$c]->tanggal;
			# $this->Presensi_model->insertAbsensiCuti($tgl_cuti, $pin);

			$dataAbsensi  = $this->Presensi_model->getAbsenHarian($pin, $tgl_cuti);

			#print_array($dataAbsensi);
			if (!empty($dataAbsensi)) {
				$datetime       = $dataAbsensi[$a]->tanggal;
				$status_absen   = $dataAbsensi[$a]->status;
				$id_absen       = $dataAbsensi[$a]->id;

				$explode = explode(" ", $datetime);
				$tanggal = $explode[0];
				$jam     = $explode[1];

				if ($status_absen == 0) {

					$newArray = array(
						'tanggal' => $tanggal,
						'pin' => $pin,
						'masuk' => $jam,
						'telat' => 0,
						'keterangan' => ''
					);
				} else {
					$newArray = array(
						'tanggal' => $tanggal,
						'pin' => $pin,
						'pulang' => $jam,
						'p_awal' => 0,
						'keterangan' => ''
					);
				}


				$this->db->where('pin', $pin);
				$this->db->where('tanggal', $tanggal);
				$this->db->update('tbl_absensi', $newArray);
			} else {
				$newArray = array(
					'masuk' => '',
					'pulang' => '',
					'telat' => 300,
					'p_awal' => 150,
					'keterangan' => ''
				);

				$this->db->where('pin', $pin);
				$this->db->where('tanggal', $tgl_cuti);
				$this->db->update('tbl_absensi', $newArray);
			}
		}


		return true;
	}

	function getAbsenHarian($pin, $tanggal)
	{
		$sql = "SELECT * FROM ts_absensi WHERE tanggal  like '$tanggal%'  AND pin = '$pin'";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}


	function createinitialShift2($pin, $tgl, $masuk = '', $pulang = '')
	{



		$libur = isWeekend($tgl);

		if ($libur == true) {
			$shift = 'OFF';
			$jamMasuk = '00:00:00';
			$jamPulang = '00:00:00';
		} else {
			$day = date('D', strtotime($tgl));

			if ($day == 'Fri') {
				$shift = 'REG-JUM';
				$jamMasuk = '07:30:00';
				$jamPulang = '16:30:00';
			} else {
				$shift = 'REG';
				$jamMasuk = '07:30:00';
				$jamPulang = '16:00:00';
			}
		}

		$newArray = array(
			'tanggal' => $tgl,
			'pin' => $pin,
			'shift' => $shift,
			'jam_masuk' => $jamMasuk,
			'jam_pulang' => $jamPulang,
			'masuk' => $masuk,
			'pulang' => $pulang,
			'telat' => 0,
			'p_awal' => 0,
			'keterangan' => ''
		);

		$this->db->insert('tbl_absensi', $newArray);

		return true;
	}


	function createinitialShift($pin, $tgl, $masuk = '', $pulang = '')
	{

		$lastDate = date('t', strtotime($tgl));
		//  $lastDate = getLastDateMonth($tgl);
		$newdate = $tgl;
		for ($a = 0; $a < $lastDate; $a++) {

			$libur = isWeekend($newdate);

			if ($libur == true) {
				$shift = 'OFF';
				$jamMasuk = '00:00:00';
				$jamPulang = '00:00:00';
			} else {
				$day = date('D', strtotime($newdate));

				if ($day == 'Fri') {
					$shift = 'REG-JUM';
					$jamMasuk = '07:30:00';
					$jamPulang = '16:30:00';
				} else {
					$shift = 'REG';
					$jamMasuk = '07:30:00';
					$jamPulang = '16:00:00';
				}
			}

			$newArray = array(
				'tanggal' => $newdate,
				'pin' => $pin,
				'shift' => $shift,
				'jam_masuk' => $jamMasuk,
				'jam_pulang' => $jamPulang,
				'masuk' => $masuk,
				'pulang' => $pulang,
				'telat' => 0,
				'p_awal' => 0,
				'keterangan' => ''
			);

			$this->db->insert('tbl_absensi', $newArray);
			$newdate = addDaysToDate($newdate, 1);
		} //close for

		return true;
	}

	function getDataImportAbsensi($id_mesin, $periode)
	{
		$sql = "SELECT * FROM import_absen WHERE tanggal  like '$periode%'  AND pin = '$id_mesin'";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}

	function getAbsenBulanan($pin, $periode)
	{
		//$sql = "SELECT * FROM ts_absensi WHERE tanggal  like '$periode%'  AND pin = '$pin' AND status_update = 0";
		$sql = "SELECT * FROM import_absen WHERE tanggal  like '$periode%'  AND pin = '$pin' ";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}

	function getDatashiftKerjaPJLP($id_pjlp, $tgl, $select = '*')
	{
		$sql = "SELECT $select FROM ts_shift_kerja WHERE tanggal = '$tgl' AND pin = '$id_pjlp'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		//echo $sql;

		//print_array($row_data);
		if ($select == 'shift') {
			if (!empty($row)) {
				$data = $row[0]->shift;
				//print_array($row_data);
			} else {
				$data = '-';
			}
		} else if ($select == 'id') {
			if (!empty($row)) {
				$data = $row[0]->id;
			} else {
				$data =  0;
			}
		} else {
			$data = $row;
		}


		return $data;
		//return $row;
	}



	function getDatashiftKerja($pin, $tgl, $select = '*')
	{
		$sql = "SELECT $select FROM ts_shift_kerja WHERE tanggal = '$tgl' AND pin = '$pin'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		//echo $sql;

		//print_array($row_data);
		if ($select == 'shift') {
			if (!empty($row)) {
				$data = $row[0]->shift;
				//print_array($row_data);
			} else {
				$data = '-';
			}
		} else if ($select == 'id') {
			if (!empty($row)) {
				$data = $row[0]->id;
			} else {
				$data =  0;
			}
		} else {
			$data = $row;
		}


		return $data;
		//return $row;
	}

	function updateRekapAbsensiPJLP($id_pjlp, $periode)
	{
	}

	function getDataRekapAbsensiPJLP($id_pjlp, $periode)
	{

		$qry = $this->db->get_where('ts_rekap_absensi_pjlp', array('id_pegawai' => $id_pjlp, 'periode' => $periode));
		//	echo $this->db->last_query();
		return $qry->result();
	}

	function insertRekapAbsensiPJLP($id_pjlp, $periode)
	{

		$dataRekap = array(
			'id_pegawai' => $id_pjlp,
			'periode' => $periode,
			'telat' => 0,
			'pulang_awal' => 0,
			'izin' => 0,
			'sakit' => 0,
			'sakit_dgn_sk' => 0,
			'alpha' => 0,
			'cuti' => 0,
			'isoman' => 0,
			'status' => 0
		);


		$this->db->insert('ts_rekap_absensi_pjlp', $dataRekap);
		return true;
	}

	function rekapAbsensi($id_pegawai, $periode, $totalTelat, $totalPawal, $numIzin, $numSakit, $numDLP, $numDLA, $numDLH)
	{

		$dataRekap = array(
			'id_pegawai' => $id_pegawai,
			'periode' => $periode,
			'telat' => $totalTelat,
			'pulang_awal' => $totalPawal,
			'izin' => $numIzin,
			'sakit' => $numSakit,
			'alpha' => 0,
			'isoman' => 0,
			'dl_penuh' => $numDLP,
			'dl_awal' => $numDLA,
			'dl_akhir' => $numDLH,
			'status' => 0
		);


		$this->db->insert('ts_rekap_absensi', $dataRekap);
		return true;
	}


	function getCutiFromTableAbsensi($pin, $periode)
	{
		$sql = "SELECT * FROM `tbl_absensi` WHERE pin = '$pin' AND tanggal like '$periode%' AND masuk ='CUTI'";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}

	function updateRekapAbsensi($id, $totalTelat, $totalPawal, $numIzin, $numSakit, $numDLP, $numDLA, $numDLH, $sakit_dgn_surat, $numCuti)
	{

		$dataRekap = array(
			'telat' => $totalTelat,
			'pulang_awal' => $totalPawal,
			'izin' => $numIzin,
			'sakit' => $numSakit,
			'alpha' => 0,
			'isoman' => 0,
			'dl_penuh' => $numDLP,
			'dl_awal' => $numDLA,
			'dl_akhir' => $numDLH,
			'cuti' => $numCuti,
			'sakit_dgn_sk' => $sakit_dgn_surat,
		);

		$this->db->where('id', $id);
		$this->db->update('ts_rekap_absensi', $dataRekap);
		return true;
	}


	public function getAbsenMasuk($pin, $tanggal)
	{
		$tgl = date('Y-m-d', strtotime($tanggal));

		$sql = "SELECT tanggal FROM ts_absensi WHERE tanggal like '$tgl%' AND pin = '$pin' AND status = 0";
		# echo $sql;
		$qry = $this->db->query($sql);
		$row = $qry->result();

		if (empty($row)) {
			$jam = '-';
		} else {
			$tgl = $row[0]->tanggal;
			$jam = date('H:i:s', strtotime($tgl));

			return $jam;
		}
	}






	public function getAbsenPulang($pin, $tanggal)
	{
		$tgl = date('Y-m-d', strtotime($tanggal));

		$sql = "SELECT tanggal FROM ts_absensi WHERE tanggal like '$tgl%' AND pin = '$pin' AND status = 1";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		if (empty($row)) {
			$jam = '-';
		} else {
			$tgl = $row[0]->tanggal;
			$jam = date('H:i:s', strtotime($tgl));

			return $jam;
		}
	}



	public function insertJamAbsen($tgl, $jam_absen, $pin, $status)
	{

		if (strpos($jam_absen, ':') !== false) {
			$tanggal_jam_absen = $tgl . ' ' . $jam_absen;
		} else {

			if (strpos($jam_absen, '.') !== false) {
				$full = str_replace(".", ":", $jam_absen);
			} else {
				$hour = substr($jam_absen, 0, 2);

				$min = substr($jam_absen, 2, 2);
				$sec = substr($jam_absen, 4, 2);
				$full = $hour . ':' . $min . ':' . $sec;
			}



			$tanggal_jam_absen = $tgl . ' ' . $full;
		}


		$newData = array(
			'pin' => $pin,
			'tanggal' => $tanggal_jam_absen,
			'status' => $status,
			'status_update' => 0
		);


		$this->db->insert('import_absen', $newData);

		return true;
	}

	public function getListMesin()
	{
		$qry = $this->db->get('tbl_mesin_absensi');
		$row = $qry->result();
		return $row;
	}

	public function detailMesin($serial_number)
	{
		$this->db->where('serial_number', $serial_number);
		$qry = $this->db->get('tbl_mesin_absensi');
		$row = $qry->result();
		return $row;
	}



	function insertUpdateMesinAbsensi()
	{
		$nama_mesin  = $this->input->post('nama_mesin');
		$ip_addr     = $this->input->post('ip_address');
		$sn          = $this->input->post('sn');
		$action    = $this->input->post('action');


		if ($action == '') {
			$new_data = array(
				'nama_mesin' => $nama_mesin,
				'serial_number' => $sn,
				'id_puskesmas' =>  $this->input->post('id_puskesmas'),
				'ip_address' => $ip_addr
			);

			$this->db->insert('tbl_mesin_absensi', $new_data);
		} else {
			$new_data = array(
				'nama_mesin' => $nama_mesin,
				'serial_number' => $sn,
				'id_puskesmas' =>  $this->input->post('id_puskesmas'),
				'ip_address' => $ip_addr
			);

			$this->db->where('serial_number', $sn);
			$this->db->update('tbl_mesin_absensi', $new_data);
		}




		return true;
	}

	function updateStatusMesinAbsensi($ip_address, $statusMesin)
	{

		$this->db->where('ip_address', $ip_address);
		$this->db->set('status', $statusMesin);
		$this->db->update('tbl_mesin_absensi');
		return true;
	}
	function insertDataAbsensiImport($datetime, $pin, $status, $method_absen = 'fingerprint')
	{


		$newArray = array(
			'tanggal' => $datetime,
			'pin' => $pin,
			'status' => $status,
			'method_absen' => $method_absen
		);


		#print_array($newArray);

		$cekAbsensi = $this->cekExistAbsensi($pin, $datetime);
		if ($cekAbsensi == 0) {
			$this->db->insert('ts_absensi', $newArray);
		}

		return true;
	}

	function cekExistAbsensi($pin, $tanggal)
	{

		$qry = $this->db->get_where('ts_absensi', array('pin' => $pin, 'tanggal' => $tanggal));
		$row = $qry->num_rows();
		return $row;
	}

	function getjumlahCuti($id_pegawai, $periode)
	{
		$sql = "SELECT SUM(jml_hari) as jumlah_cuti FROM `ts_rekap_cuti` WHERE id_pegawai = $id_pegawai AND periode = '$periode'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		return $row[0]->jumlah_cuti;
	}

	function cekDataRekapCuti($id_cuti)
	{

		$qry = $this->db->get_where('ts_rekap_cuti', array('id_cuti' => $id_cuti));
		$row = $qry->num_rows();
		return $row;
	}


	function cekLastImportData($serial_number)
	{
		$this->db->order_by('tanggal', 'DESC');
		$this->db->where('serial_number', $serial_number, 2, 0);
		$qry = $this->db->get('ts_absensi');
		$row = $qry->result();

		return $row;
	}

	function getDataIzinSakit($status = 0)
	{

		$sql = "SELECT a.*, b.nama
		FROM pengajuan_izin_sakit  a
		LEFT JOIN mst_pegawai b ON a.id_pegawai = b.id_pegawai
		WHERE a.status = $status ORDER BY tanggal DESC";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		return $row;
	}

	function generate_shift_kerja($pin, $tanggal)
	{

		$absenMasuk   = $this->Presensi_model->getAbsenMasuk($pin, $tanggal);
		$absenPulang  = $this->Presensi_model->getAbsenPulang($pin, $tanggal);



		$shiftKerja = '-';
		if ($absenMasuk == '' && $absenPulang == '') {
			$shiftKerja = 'OFF';
		}


		if ($absenMasuk != '' && $absenPulang == '') {

			$xplod = explode(":", $absenMasuk);
			$jam = $xplod[0];
			if ($jam < 9) {
				$shiftKerja = 'PSM';
			} else if ($jam > 12 && $jam < 15) {
				$shiftKerja = 'SM';
			} else if ($jam >= 15 && $jam < 18) {
				$shiftKerja = 'SM-RUS';
			} else {
				$shiftKerja = 'M';
			}
		}


		if ($absenMasuk != '' && $absenPulang != '') {

			$xplod = explode(":", $absenMasuk);
			$jam = $xplod[0];

			$xplod2 = explode(":", $absenPulang);
			$jam2 = $xplod2[0];

			if ($jam < 9) {
				//P atau PS
				if ($jam2 < 17) {
					//pagi
					$shiftKerja = 'P';
				} else {
					$shiftKerja = 'PS';
				}
			} else if ($jam > 13 && $jam < 18) {
				$shiftKerja = 'S';
			} else {
				$shiftKerja = 'M';
			}
		}


		if ($absenMasuk == '' && $absenPulang != '') {
			$shiftKerja = 'L-OFF';
		}


		return $shiftKerja;
	}



	// function generate_shift_kerja($pin){

	// 	$periode_bulan = $this->session->userdata('periode_bulan');
	// 	$periode_tahun = $this->session->userdata('periode_tahun');

	// 	if($periode_bulan=='') {
	// 	  $bulan = date('m');
	// 	  $tahun = date('Y');

	// 	}else{
	// 	  $bulan = $periode_bulan;
	// 	  $tahun = $periode_tahun;
	// 	}


	// 	$periode = $tahun . '-' . $bulan;
	//     $periode = date('Y-m', strtotime($periode));


	// 	$lastDate = date('t', strtotime($periode)) + 1;

	// 	for ($t = 1; $t < $lastDate; $t++) {
	// 		$tanggal = $periode . '-' . $t;
	// 		$formatDate = date('Y-m-d', strtotime($tanggal));
	// 		$day = date('D', strtotime($tanggal));



	// 		$absenMasuk = $this->Presensi_model->getAbsenMasuk($pin, $tanggal);
	// 		$absenPulang = $this->Presensi_model->getAbsenPulang($pin, $tanggal);

	// 		if($absenMasuk =='' && $absenPulang==''){
	// 			$shiftKerja = 'OFF';
	// 		}

	// 		if($absenMasuk !='' && $absenPulang==''){

	// 			$xplod = explode(":", $absenMasuk);
	// 			$jam = $xplod[0];
	// 			if($jam < 9){
	// 				$shiftKerja = 'PSM';
	// 			}else if($jam > 12 && $jam < 15){
	// 				$shiftKerja = 'SM';
	// 			}else if($jam >= 15 && $jam < 18){
	// 				$shiftKerja = 'SM-RUS';
	// 			}else{
	// 				$shiftKerja = 'M';
	// 			}

	// 		}


	// 		if($absenMasuk !='' && $absenPulang !=''){

	// 			$xplod = explode(":", $absenMasuk);
	// 			$jam = $xplod[0];

	// 			$xplod2 = explode(":", $absenPulang);
	// 			$jam2 = $xplod2[0];

	// 			if($jam < 9){
	// 				//P atau PS
	// 				if($jam2 < 17){
	// 					//pagi
	// 					$shiftKerja = 'P';
	// 				}else{
	// 					$shiftKerja = 'PS';
	// 				}

	// 			}else if($jam > 13 && $jam < 18){
	// 				$shiftKerja = 'S';
	// 			}else{
	// 				$shiftKerja = 'M';
	// 			}


	// 		}

	// 		if($absenMasuk =='' && $absenPulang !=''){
	// 			$shiftKerja = 'L-OFF';
	// 		}

	// 		#$this->Presensi_model->deleteShiftPegawai($id_pegawai, $tanggal);
	// 		$insert = $this->Presensi_model->insertShiftPegawai($pin, $formatDate, $shiftKerja);
	// 	}

	// 	return true;
	// }







}
