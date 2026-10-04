<?php ob_start();
defined('BASEPATH') or exit('No direct script access allowed');
class Absensi_model extends CI_Model
{
	function __construct()
	{
		parent::__construct();
		//$this->db = $this->load->database('ekin', true);
	}



	function getDataAbsenDB($dateFrom, $dateTo, $pin)
	{

		// Load database

		$startDate = date('Y-m-d', strtotime($dateFrom));
		$endDate = date('Y-m-d', strtotime($dateTo));
		$date1 = $startDate . ' 00:01:01';
		$date2 = $endDate . ' 23:59:01';

		$sql = "SELECT * FROM absensi WHERE pin='$pin' AND tanggal > '$date1' AND tanggal < '$date2' order by tanggal ASC";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}


	public function getAbsenMasuk($pin, $tgl)
	{


		$sql = "SELECT * FROM absensi WHERE pin='$pin' AND tanggal like '$tgl%' AND status = 0";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		if (!empty($row)) {
			$tanggal = $row[0]->tanggal;
			$explo = explode(" ", $tanggal);
			$jam = $explo[1];
		} else {
			$jam = '-';
		}

		return $jam;
	}


	public function getAbsenPulang($pin, $tgl)
	{


		$sql = "SELECT * FROM absensi WHERE pin='$pin' AND tanggal like '$tgl%' AND status = 1";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		if (!empty($row)) {
			$tanggal = $row[0]->tanggal;
			$explo = explode(" ", $tanggal);
			$jam = $explo[1];
		} else {
			$jam = '-';
		}

		return $jam;
	}

	public function getAbsenByPegawai($id_pegawai, $id_jenis_absen)
	{

		$periode = '2022-03-01';


		$sql = "SELECT * FROM `absensi_izin` WHERE `id_pegawai` = $id_pegawai AND tanggal >= '$periode' AND jns_absen = $id_jenis_absen ORDER BY `id` DESC";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}



	public function getIzin($id_pegawai, $tgl)
	{

		$qry = $this->db->get_where('absensi_izin', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl, 'jns_absen' => 4));
		$row = $qry->result();
		if (!empty($row)) {
			return array(true, $row[0]->keterangan, $row[0]->id);
		} else {
			return false;
		}
	}

	public function getSakit($id_pegawai, $tgl)
	{

		$qry = $this->db->get_where('absensi_izin', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl, 'jns_absen' => 5));
		$row = $qry->result();
		if (!empty($row)) {
			return array(true, $row[0]->keterangan, $row[0]->id);
		} else {
			return false;
		}
	}

	public function getAbsenDLP($id_pegawai, $tgl)
	{

		$qry = $this->db->get_where('absensi_dl', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl, 'jns_dl' => 3));
		$row = $qry->result();
		if (!empty($row)) {
			return array(true, $row[0]->keterangan, $row[0]->id);
		} else {
			return false;
		}
	}

	public function getAbsenDLakhir($id_pegawai, $tgl)
	{

		$qry = $this->db->get_where('absensi_dl', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl, 'jns_dl' => 2));
		$row = $qry->result();
		if (!empty($row)) {
			return array(true, $row[0]->keterangan, $row[0]->id);
		} else {
			return false;
		}
	}

	public function getAbsenDLawal($id_pegawai, $tgl)
	{

		$qry = $this->db->get_where('absensi_dl', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl, 'jns_dl' => 1));
		$row = $qry->result();
		if (!empty($row)) {
			return array(true, $row[0]->keterangan, $row[0]->id);
		} else {
			return false;
		}
	}

	function hariLibur($tgl)
	{

		$qry = $this->db->get_where('hari_libur', array('tanggal' => $tgl));
		$row = $qry->result();

		if (!empty($row)) {
			$note = $row[0]->keterangan;
		} else {
			$note = '';
		}
		return $note;
	}

	public function getCuti($id_pegawai, $tgl)
	{

		// echo 'id_pegawai = ' . $id_pegawai . ' / ' . $tgl;
		// $qry = $this->db->get_where('absensi_cuti', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl));
		// $row = $qry->result();

		$sql = "SELECT * FROM absensi_cuti WHERE id_pegawai = $id_pegawai AND tanggal = '$tgl'";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}

	function insertCuti($id_pegawai, $tanggal, $jns_cuti, $keterangan)
	{


		$newData = array(
			'id_pegawai' => $id_pegawai,
			'tanggal' => $tanggal,
			'jns_cuti' => $jns_cuti,
			'keterangan' => $keterangan
		);

		//print_array($newData);

		$this->db->insert('absensi_cuti', $newData);

		return true;
	}


	public function insertJamAbsen($tgl, $jam_absen, $pin, $status)
	{

		//echo 'jam absen' . $jam_absen . '<br>';
		if (strpos($jam_absen, ':') !== false) {
			$tanggal_jam_absen = $tgl . ' ' . $jam_absen;
		} else {

			$hour = substr($jam_absen, 0, 2);

			$min = substr($jam_absen, 2, 2);
			$sec = substr($jam_absen, 4, 2);
			$full = $hour . ':' . $min . ':' . $sec;

			$tanggal_jam_absen = $tgl . ' ' . $full;
		}


		$newData = array(
			'pin' => $pin,
			'tanggal' => $tanggal_jam_absen,
			'status' => $status,
			'id_puskesmas' => 1
		);



		$this->db->insert('absensi', $newData);
	}

	function getDataMesinPegawai($pin)
	{

		$sql = "Select  a.id_puskesmas, b.ip_address
		FROM mst_pegawai a LEFT JOIN tbl_mesin_absensi b ON a.id_puskesmas = b.id_puskesmas WHERE pin ='$pin'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		return $row;
	}


	function getRawAbensi($pin, $tgl)
	{


		$this->db->where('pin', $pin);
		$this->db->order_by('status', 'ASC');
		$this->db->like('tanggal', $tgl, 'after');
		$qry = $this->db->get('absensi');
		$row = $qry->result();
		return $row;

		// $db2 = $this->load->database('database2', TRUE);
		// $sql = "SELECT * FROM ";
	}


	function detailPegawaiById($id_pegawai)
	{

		$qry = $this->db->get_where('mst_pegawai', array('id_pegawai' => $id_pegawai));
		$row = $qry->result();
		return $row;
	}


	function getIDPegawayByNIP($nip)
	{

		$this->db->select('id_pegawai, nama_pegawai');

		$qry = $this->db->get_where('mst_pegawai', array('nip' => $nip));
		$row = $qry->result();

		#print_array($row);
		$id_pegawai = $row[0]->id_pegawai;
		return $id_pegawai;
	}

	function detailPegawaiByNip($nip)
	{

		$qry = $this->db->get_where('mst_pegawai', array('nip' => $nip));
		$row = $qry->result();
		return $row;
	}

	function detailPegawaiAbsen($pin)
	{

		$qry = $this->db->get_where('mst_pegawai', array('pin' => $pin));
		$row = $qry->result();

		return $row;
	}






	public function getShiftPegawai($id_pegawai, $tgl)
	{


		$qry = $this->db->get_where('shift_kerja', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl));
		$row = $qry->result();


		if (!empty($row)) {
			$shift = $row[0]->shift;
			return $shift;
		} else {
			return '';
		}
	}

	public function cekAbsensiIsoman($id_pegawai, $tgl)
	{

		$sql = "SELECT id FROM `absensi_isoman` WHERE id_pegawai = '$id_pegawai' AND '$tgl' BETWEEN tgl_dari AND tgl_sampai";
		$qry = $this->db->query($sql);
		$row = $qry->num_rows();

		return $row;
	}



	function getDataIsoman($id_pegawai, $periode)
	{

		$sql = "SELECT * FROM absensi_isoman WHERE id_pegawai = $id_pegawai AND (tgl_dari like '$periode%' OR tgl_sampai like '$periode%')";

		$qry = $this->db->query($sql);
		$row = $qry->result();
		return $row;
	}

	public function cekShiftExist($id_pegawai, $tgl)
	{

		$this->db->select('id');
		$qry = $this->db->get_where('shift_kerja', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl));
		$row = $qry->result();
		if (!empty($row)) {
			$id = $row[0]->id;
			return $id;
		} else {
			return 0;
		}
	}


	function insertPengajuanDL($id_pegawai, $photo, $latitude = '', $longitude = '')
	{

		$tanggal = $this->input->post('tanggal');
		$tgl     = format_db($tanggal);

		$newarray = array(
			'id_pegawai' => $id_pegawai,
			'tanggal ' => $tgl,
			'jns_dl' => $this->input->post('jns_dl'),
			'photo' => $photo,
			'surtug' => '',
			'lat' => $latitude,
			'lon' => $longitude,
			'keterangan' => $this->input->post('keterangan')
		);
		$this->db->insert('pengajuan_dinas_luar', $newarray);

		return true;
	}

	function insertPengajuanIzinSakit($id_pegawai, $file_name)
	{

		$tanggal = $this->input->post('tanggal');
		$tgl     = format_db($tanggal);

		$newarray = array(
			'id_pegawai' => $id_pegawai,
			'tanggal ' => $tgl,
			'jenis_absen' => $this->input->post('jns_absen'),
			'file_image' => $file_name,
			'keterangan' => $this->input->post('keterangan')
		);
		$this->db->insert('pengajuan_izin_sakit', $newarray);

		return true;
	}


	public function getDataPengjuanIzinSakit($jenis_absen = 'IZIN', $status = 0)
	{
		$this->db->order_by('tanggal', 'ASC');
		$qry = $this->db->get_where('pengajuan_izin_sakit', array('jenis_absen' => $jenis_absen, 'status' => $status));
		$row = $qry->result();
		return $row;
	}


	public function getDetailPengajuanDL($id)
	{

		$this->db->order_by('tanggal', 'DESC');
		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id' => $id));
		$row = $qry->result();

		return $row;
	}


	public function getListPengajuanDL($id_pegawai)
	{

		$this->db->order_by('tanggal', 'DESC');
		$qry = $this->db->get_where('pengajuan_dinas_luar', array('id_pegawai' => $id_pegawai));
		$row = $qry->result();

		return $row;
	}


	public function getListPengajuanIzinSakit($id_pegawai)
	{

		$this->db->order_by('tanggal', 'DESC');
		$qry = $this->db->get_where('pengajuan_izin_sakit', array('id_pegawai' => $id_pegawai));
		$row = $qry->result();

		return $row;
	}

	function updateShift($id_pegawai, $tgl, $shift_kerja, $id_shift)
	{

		$newData = array(
			'id_pegawai' => $id_pegawai,
			'tanggal' => $tgl,
			'shift' => $shift_kerja
		);



		//print_array($newData);
		$this->db->where('id', $id_shift);
		$this->db->update('shift_kerja', $newData);
		return true;
	}

	public function cekAbsensiExist($pin, $tgl, $status)
	{


		$qry = $this->db->get_where('ts_absensi', array('pin' => $pin, 'date_only' => $tgl, 'status' => $status));
		$row = $qry->num_rows();
		return $row;
	}

	public function insertAbsensi($pin, $tanggal, $status, $date, $jam)
	{

		$newArray = array(
			'pin' => $pin,
			'tanggal' => $tanggal,
			'status' => $status,
			'date_only' => $date,
			'time_only' => date('H:i:s', $jam)

		);

		$this->db->insert('ts_absensi', $newArray);
		return true;
	}

	function insertShift($id_pegawai, $tgl, $shift_kerja)
	{

		$newData = array(
			'id_pegawai' => $id_pegawai,
			'tanggal' => $tgl,
			'shift' => $shift_kerja
		);

		$this->db->insert('shift_kerja', $newData);

		return true;
	}




	function cekAbsenMasuk($id_pegawai, $formatDate)
	{

		$num_DLP = 0;
		$num_DLawal = 0;
		$num_cuti = 0;
		$num_izin = 0;
		$num_sakit = 0;
		$num_isoman = 0;



		$DLP     = $this->Absensi_model->getAbsenDLP($id_pegawai, $formatDate);
		if ($DLP == false) {
			//klo ga lagi dinas luar penuh -> cek dinas luar awal
			$DLawal  = $this->Absensi_model->getAbsenDLawal($id_pegawai, $formatDate);

			if ($DLawal == false) {
				//klo dinas luar awal kosong => cek cuti
				$cuti    = $this->Absensi_model->getCuti($id_pegawai, $formatDate);
				if ($cuti == false) {
					//klo tidak lagi cuti -> cek izin
					$izin    = $this->Absensi_model->getIzin($id_pegawai, $formatDate);
					if ($izin == false) {
						//klo ga izin -> cek isoman
						$sakit   = $this->Absensi_model->getSakit($id_pegawai, $formatDate);

						if ($sakit == false) {
							//cek isoman

							$isoman   = $this->Absensi_model->cekAbsensiIsoman($id_pegawai, $formatDate);
							if ($isoman == 0) {
								$telat = 300;
							} else {
								$telat = 0;
								$num_isoman = 1;
							} // if isoman
						} else {
							$telat = 0;
							$num_sakit = 1;
						} //if sakit
					} else {
						$telat = 0;
						$num_izin = 1;
					} // if izin
				} else {
					$telat = 0;
					$num_cuti = 1;
				} // if cuti
			} else {
				$telat = 0;
				$num_DLawal = 1;
			} // if DL awal
		} else {
			$telat = 0;
			$num_DLP = 1;
		} // if DLP


		$data = array(
			'telat' => $telat,
			'num_DLP' => $num_DLP,
			'num_DLawal' => $num_DLawal,
			'num_cuti' => $num_cuti,
			'num_izin' => $num_izin,
			'num_sakit' => $num_sakit,
			'num_isoman' => $num_isoman,
		);

		return $data;
	}

	function cekAbsenKeluar($id_pegawai, $formatDate)
	{
		$DLakhir  = $this->Absensi_model->getAbsenDLakhir($id_pegawai, $formatDate);
		if ($DLakhir == false) {

			$DLP     = $this->Absensi_model->getAbsenDLP($id_pegawai, $formatDate);
			if ($DLP == false) {
				$pulang_cepat = 150;
			} else {
				$pulang_cepat = 0;
			}
		} else {
			$pulang_cepat = 0;
		}
		return $pulang_cepat;
	}



	function getRandomString($n)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randomString = '';

		for ($i = 0; $i < $n; $i++) {
			$index = rand(0, strlen($characters) - 1);
			$randomString .= $characters[$index];
		}

		return $randomString;
	}



	public function getJamAbsenMasuk($pin, $tgl)
	{

		$sql = "SELECT * FROM ts_absensi WHERE pin ='$pin' AND tanggal like '$tgl%' AND status = 0";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		if (!empty($row)) {
			$tanggal = $row[0]->tanggal;
			$explo = explode(" ", $tanggal);
			$jam = $explo[1];
		} else {
			$jam = '-';
		}

		return $jam;
	}



	function cekAbsenDL($id_pegawai, $tgl)
	{

		$qry = $this->db->get_where('absensi_dl', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl));
		$row = $qry->result();

		return $row;
	}

	function cekAbsenIzin($id_pegawai, $tgl)
	{

		$qry = $this->db->get_where('absensi_izin', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl));
		$cekAbsenIzinSakit = $qry->result();



		$izinSakit = false;
		if (!empty($cekAbsenIzinSakit)) {
			$jns_absen = $cekAbsenIzinSakit[0]->jns_absen;
			if ($jns_absen == 4) {
				$jam_masuk = '<span class="text-warning"><strong>IZIN</strong></span>';
				$telat = 0;
				$izinSakit = true;
			} else if ($jns_absen == 5) {
				$jam_masuk = '<span class="text-warning"><strong>SAKIT</strong></span>';
				$telat = 0;
				$izinSakit = true;
			} else {
				$jam_masuk = '<span class="text-danger"><strong>ALPHA</strong></span>';
				$telat = 300;
			}
			$link_delete = '<a href="' . base_url() . 'absensi/hapus_absen_izin/' . $cekAbsenIzinSakit[0]->id . '/' . $id_pegawai . '" class="btn btn-hapus">Hapus</a>';
		} else {
			$telat = 300;
			$jam_masuk = '-';
			$izinSakit = false;
			$link_delete = '';
		}

		return array($jam_masuk, $telat, $izinSakit, $link_delete);
	}




	function cekAbsenDLAkhir($id_pegawai, $tgl)
	{

		$qry = $this->db->get_where('absensi_dl', array('id_pegawai' => $id_pegawai, 'tanggal' => $tgl, 'jns_dl' => 2));
		$row = $qry->result();

		if (!empty($row)) {
			$keterangan = $row[0]->keterangan;
			$id = $row[0]->id;
			return array(true, $keterangan, $id);
		} else {
			return array(false, '', '');
		}
	}





	function getHariLibur($tgl)
	{
		$query = $this->db->get_where('ts_hari_libur', array('tgl' => $tgl), 1, 0);
		$row   = $query->result();
		return $row;
	}
	public function getJamAbsenPulang($pin, $tgl)
	{

		$sql = "SELECT * FROM ts_absensi WHERE pin ='$pin' AND tanggal like '$tgl%' AND status = 1";
		$qry = $this->db->query($sql);
		$row = $qry->result();
		if (!empty($row)) {
			$tanggal = $row[0]->tanggal;
			$explo = explode(" ", $tanggal);
			$jam = $explo[1];
		} else {
			$jam = '-';
		}

		return $jam;
	}


	function getAbsensiDLIzin($id_pegawai, $periode)
	{

		$sql = "SELECT * FROM absensi_dl WHERE id_pegawai = $id_pegawai AND tanggal like '$periode%'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		$sql2 = "SELECT * FROM absensi_izin WHERE id_pegawai = $id_pegawai AND tanggal like '$periode%'";
		$qry2 = $this->db->query($sql2);
		$row2 = $qry2->result();
	}

	public function getDataCutiPegawai($id_pegawai, $periode)
	{

		$sql = "SELECT tanggal FROM absensi_cuti WHERE id_pegawai = $id_pegawai AND tanggal like '$periode%'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		return $row;
	}



	public function getAbsensi($pin, $periode)
	{

		$sql = "SELECT * FROM absensi WHERE pin='$pin' AND tanggal like '$periode%'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		return $row;
	}


	public function deleteTempAbsen($pin)
	{
		$this->db->where('pin', $pin);
		$this->db->delete('absensi_temp');

		return true;
	}


	public function insertTempAbsen($pin, $array, $code, $status)
	{

		for ($i = 0; $i < count($array); $i++) {
			$newData = array(
				'random_code' => $code,
				'tanggal' => $array[$i],
				'pin' => $pin,
				'status' => $status
			);


			print_array($newData);
			$this->db->insert('absensi_temp', $newData);
		}

		$this->session->set_userdata('random_code', $code);
		return true;
	}

	function cekAbsenIsoman($id_pegawai, $tgl)
	{

		$sql   = "SELECT id FROM absensi_isoman WHERE id_pegawai = $id_pegawai AND  '$tgl' between tgl_dari AND tgl_sampai";
		$query = $this->db->query($sql);
		$row   = $query->result();

		if (!empty($row)) {
			return true;
		} else {
			return false;
		}
	}


	public function rekapAbsensiPerbulan($periode)
	{

		$this->db->select('b.nama_pegawai, b.nip, a.*');
		$this->db->where('periode', $periode);
		$this->db->from('ts_rekap_absensi a');
		$this->db->join('mst_pegawai b', 'a.id_pegawai = b.id_pegawai', 'left');
		$this->db->order_by('nama_pegawai', 'ASC');

		$qry = $this->db->get();
		$row = $qry->result();

		return $row;
	}


	public function getDataRekap($id_pegawai, $periode)
	{
		$qry = $this->db->get_where('ts_rekap_absensi', array('id_pegawai' => $id_pegawai, 'periode' => $periode));
		$row = $qry->result();

		return $row;
	}

	public function cekRekapAbsen($id_pegawai, $periode)
	{
		$this->db->select('id');
		$qry = $this->db->get_where('rekap_absensi', array('id_pegawai' => $id_pegawai, 'periode' => $periode));
		$row = $qry->result();
		if (!empty($row)) {
			$id = $row[0]->id;
			return $id;
		} else {
			return 0;
		}
	}


	public function perhitunganRekapAbsen($periode, $pin, $id_pegawai)
	{
		$last_date  = date('t', strtotime($periode));

		$today          = date('Y-m-d');
		$totalTelat     = 0;
		$totalPC        = 0;

		$totalCuti 		= 0;
		$totalSakit 	= 0;
		$totalIzin 		= 0;
		$totalIsoman 	= 0;

		$telat = 0;
		$num_DLP = 0;
		$num_cuti = 0;
		$num_izin = 0;
		$num_sakit = 0;
		$num_isoman = 0;


		for ($a = 0; $a < $last_date; $a++) {

			$tgl = $a + 1;
			$fullDate = $periode . '-' . $tgl;
			$formatDate = format_db($fullDate);

			$day = date('N', strtotime($formatDate));

			//echo $day;
			//$hari = format_hari($day);

			$jam_masuk  = $this->Absensi_model->getAbsenMasuk($pin, $formatDate);
			$jam_pulang = $this->Absensi_model->getAbsenPulang($pin, $formatDate);

			$getHariLibur = $this->Absensi_model->hariLibur($formatDate);

			//print_array($getHariLibur);

			// if ($hari == 'Minggu' || $hari == 'Sabtu') {
			// 	$bg = '#fef5f5; color:#b33030';
			// 	$jamMasuk = '';
			// 	$jamPulang = '';

			// } else if ($hari == 'Jumat') {
			// 	$bg = '#FFF';
			// 	$jamMasuk = '07:30:00';
			// 	$jamPulang = '16:30:00';

			// } else {
			// 	$bg = '#FFF';
			// 	$jamMasuk = '07:30:00';
			// 	$jamPulang = '16:00:00';

			// }


			if ($day < 6) {
				//bukan hari sabtu atau minggu

				if ($getHariLibur == '') {
					//klo bukan hari libur

					if ($jam_masuk == '-') {
						$telat = 300;
						$data = $this->Absensi_model->cekAbsenMasuk($id_pegawai, $formatDate);
						$num_DLawal     = $data['num_DLawal'];
						$num_DLP     = $data['num_DLP'];
						$num_cuti    = $data['num_cuti'];
						$num_izin    = $data['num_izin'];
						$num_sakit   = $data['num_sakit'];
						$num_isoman  = $data['num_isoman'];


						if ($num_cuti == 1) {
							$totalCuti = $totalCuti + 1;
							$telat = 0;
						}

						if ($num_sakit == 1) {
							$totalSakit = $totalSakit + 1;
							$telat = 0;
						}

						if ($num_izin == 1) {
							$totalIzin = $totalIzin + 1;
							$telat = 0;
						}

						if ($num_isoman == 1) {
							$totalIsoman = $totalIsoman + 1;
							$telat = 0;
						}

						if ($num_DLawal == 1) {
							$telat = 0;
						}

						if ($num_DLP == 1) {
							$telat = 0;
						}
					} else {
						//klo ada jam kerjanya (absen masuk)

						$jamMasuk = '07:30:00';
						$telat = hitungTelat($jamMasuk, $jam_masuk);
					} // close if jam masuk

					if ($jam_pulang == '-') {

						$pc = $this->Absensi_model->cekAbsenKeluar($id_pegawai, $formatDate);
						$data = $this->Absensi_model->cekAbsenMasuk($id_pegawai, $formatDate);
						$num_DLawal     = $data['num_DLawal'];
						$num_DLP     = $data['num_DLP'];
						$num_cuti    = $data['num_cuti'];
						$num_izin    = $data['num_izin'];
						$num_sakit   = $data['num_sakit'];
						$num_isoman  = $data['num_isoman'];


						if ($num_cuti == 1) {
							$pc = 0;
						}

						if ($num_sakit == 1) {
							$pc = 0;
						}

						if ($num_izin == 1) {
							$pc = 0;
						}

						if ($num_isoman == 1) {
							$pc = 0;
						}

						if ($num_DLP == 1) {
							$pc = 0;
						}
					} else {
						if ($day == 5) {
							//jari jumat 
							$jamPulang = '16:30:00';
						} else {
							$jamPulang = '16:00:00';
						}
						$pc =  hitungPulangCepat($jamPulang, $jam_pulang);
					}
				} else {
					$telat = 0;
					$pc = 0;
				}
			} else {
				$telat = 0;
				$pc = 0;
			}


			$totalTelat = $totalTelat + $telat;
			$totalPC =  $totalPC + $pc;
		}


		$newArray = array(
			'id_pegawai' => $id_pegawai,
			'periode' => $periode,
			'telat' => $totalTelat,
			'pulang_awal' => $totalPC,
			'cuti' => $totalCuti,
			'izin' => $totalIzin,
			'sakit' => $totalSakit,
			'alpha' => 0,
			'isoman' => $totalIsoman
		);


		$checkRekap = $this->Absensi_model->cekRekapAbsen($id_pegawai, $periode);
		if ($checkRekap == 0) {
			$this->db->insert('rekap_absensi', $newArray);
		} else {
			$id = $checkRekap;
			$this->db->where('id', $id);
			$this->db->update('rekap_absensi', $newArray);
		}

		return true;
	} // end function


	public function perhitunganRekapAbsenShift($periode, $pin, $id_pegawai)
	{
		$last_date  = date('t', strtotime($periode));

		$today          = date('Y-m-d');
		$totalTelat     = 0;
		$totalPC        = 0;

		$totalCuti 		= 0;
		$totalSakit 	= 0;
		$totalIzin 		= 0;
		$totalIsoman 	= 0;

		$isoman = $this->Absensi_model->getDataIsoman($id_pegawai, $periode);
		if (!empty($isoman)) {
			$tglDari    = $isoman[0]->tgl_dari;
			$tglSampai  = $isoman[0]->tgl_sampai;
			$tgl_dari   = strtotime($tglDari);
			$tgl_sampai = strtotime($tglSampai);
			$cekIsoman  = true;

			$totalIsoman = datediff('d', $tglDari, $tglSampai) + 1;
		} else {
			$tgl_dari   = '';
			$tgl_sampai   = '';
			$cekIsoman  = false;
			$totalIsoman = 0;
		}



		for ($a = 0; $a < $last_date; $a++) {

			$tgl = $a + 1;
			$fullDate = $periode . '-' . $tgl;
			$formatDate = format_db($fullDate);

			$day = date('D', strtotime($formatDate));
			$hari = format_hari($day);

			$jam_masuk  = $this->Absensi_model->getAbsenMasuk($pin, $formatDate);
			$jam_pulang = $this->Absensi_model->getAbsenPulang($pin, $formatDate);

			$DLP     = $this->Absensi_model->getAbsenDLP($id_pegawai, $formatDate);
			$DLakhir = $this->Absensi_model->getAbsenDLakhir($id_pegawai, $formatDate);
			$DLawal  = $this->Absensi_model->getAbsenDLawal($id_pegawai, $formatDate);
			$cuti    = $this->Absensi_model->getCuti($id_pegawai, $formatDate);
			$izin    = $this->Absensi_model->getIzin($id_pegawai, $formatDate);
			$sakit   = $this->Absensi_model->getSakit($id_pegawai, $formatDate);


			$shiftKerja = $this->Absensi_model->getShiftPegawai($id_pegawai, $formatDate);

			$JamKerjaShift = getJamKerjaShift($shiftKerja);
			if ($JamKerjaShift == '-') {
				$jamMasuk = '-';
				$jamPulang = '-';
				$jam_kerja_pegawai = 'OFF';
			} else {
				$xplod = explode("-", $JamKerjaShift);
				$jamMasuk = $xplod[0];
				$jamPulang = $xplod[1];

				$jam_kerja_pegawai =  $jamMasuk . '-' . $jamPulang;
			}



			if ($shiftKerja == 'SM' || $shiftKerja == 'M' || $shiftKerja == 'P' || $shiftKerja == 'PS' || $shiftKerja == 'PSM' ||  $shiftKerja == 'REG') {
				$countTelat = true;
			} else {
				$countTelat = false;
			}

			if ($countTelat) {

				if ($jam_masuk <> '-') {
					$telat = hitungTelat($jamMasuk, $jam_masuk);
				} else {
					$telat = 300;
				}
			} else {
				$telat = 0;
			}

			if ($jam_kerja_pegawai <> 'OFF') {
				$pc = hitungPulangCepat($jamPulang, $jam_pulang);
			} else {
				$pc = 0;
			}


			if (strtotime($formatDate) >= strtotime($today)) {
				$telat = 0;
				$pc = 0;
			}

			if (!empty($DLP)) {

				$telat = 0;
				$pc = 0;
			}

			if (!empty($DLakhir)) {
				$pc = 0;
			}
			if (!empty($DLawal)) {
				$telat = 0;
			}

			if (!empty($cuti)) {
				$telat = 0;
				$pc = 0;
				$totalCuti = $totalCuti + 1;
			}

			if (!empty($izin)) {
				$telat = 0;
				$pc = 0;
				$totalIzin 		= 0;
			}

			if (!empty($sakit)) {
				$telat = 0;
				$pc = 0;
				$totalSakit 	= 0;
			}

			$tgl_a = strtotime($formatDate);

			if ($cekIsoman == true) {
				if ($tgl_a >= $tgl_dari && $tgl_a <= $tgl_sampai) {
					$jam_masuk  = 'ISOMAN';
					$jam_pulang = 'ISOMAN';
					$telat = 0;
					$pc = 0;
				}
			}

			$totalTelat = $totalTelat + $telat;
			$totalPC =  $totalPC + $pc;
		} // end looping



		$newArray = array(
			'id_pegawai' => $id_pegawai,
			'periode' => $periode,
			'telat' => $totalTelat,
			'pulang_awal' => $totalPC,
			'cuti' => $totalCuti,
			'izin' => $totalIzin,
			'sakit' => $totalSakit,
			'alpha' => 0,
			'isoman' => $totalIsoman
		);


		$checkRekap = $this->Absensi_model->cekRekapAbsen($id_pegawai, $periode);
		if ($checkRekap == 0) {
			$this->db->insert('rekap_absensi', $newArray);
		} else {
			$id = $checkRekap;
			$this->db->where('id', $id);
			$this->db->update('rekap_absensi', $newArray);
		}

		return true;
	} // end function


	function cekAbsenExist($tanggal, $pin, $status)
	{

		$sql = "SELECT id FROM ts_absensi WHERE pin='$pin' AND  tanggal = '$tanggal' AND status = $status";
		$qry = $this->db->query($sql);
		$row = $qry->num_rows();

		if ($row == 0) {
			return true; // belum ada
		} else {
			return false;
		}
	}




	function getDataMesinAbsensi($pin)
	{

		$sql = "Select  a.id_puskesmas, b.ip_address
		FROM mst_pegawai a LEFT JOIN tbl_mesin_absensi b ON a.id_puskesmas = b.id_puskesmas WHERE pin ='$pin'";
		$qry = $this->db->query($sql);
		$row = $qry->result();

		return $row;
	}

	public function getDataAbsenMesin($ip_address, $pin)
	{

		$buffer      = $this->getDataPresensi($ip_address,  $pin);
		$new_array   = array();

		for ($a = 0; $a < count($buffer); $a++) {
			$data = $this->Parse_Data($buffer[$a], "<Row>", "</Row>");
			$PIN_absen = $this->Parse_Data($data, "<PIN>", "</PIN>");
			$DateTime = $this->Parse_Data($data, "<DateTime>", "</DateTime>");
			$Verified = $this->Parse_Data($data, "<Verified>", "</Verified>");
			$Status   = $this->Parse_Data($data, "<Status>", "</Status>");

			$new_array[] = array(
				'pin' => $PIN_absen,
				'DateTime' => $DateTime,
				'Status'  => $Status,
				'Verified'  => $Verified
			);
		}

		return $new_array;
	}

	function getDataPresensi($ip_address,  $PIN)
	{
		$Connect = fsockopen($ip_address, "80", $errno, $errstr, 1);
		if ($Connect) {


			$soap_request = "

                    <GetAttLog>
                        <ArgComKey xsi:type=\"xsd:integer\">0</ArgComKey>
                        <Arg>
                            <PIN xsi:type=\"xsd:integer\">$PIN</PIN>
                            <DateTime xsi:type=\"xsd:date\">
                                    2019-05-01
                            </DateTime>
                        </Arg>

                    </GetAttLog>";
			$newLine = "\r\n";
			fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
			fputs($Connect, "Content-Type: text/xml" . $newLine);
			fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
			fputs($Connect, $soap_request . $newLine);
			$buffer = "";
			while ($Response = fgets($Connect, 1024)) {
				$buffer = $buffer . $Response;
			}
		} else {
			echo "<div class='alert alert-danger'>Koneksi Gagal</div>";
		}



		$buffer = $this->Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
		$buffer = explode("\r\n", $buffer);

		return $buffer;
	}


	function Parse_Data($data, $p1, $p2)
	{
		$data = " " . $data;
		$hasil = "";
		$awal = strpos($data, $p1);
		if ($awal != "") {
			$akhir = strpos(strstr($data, $p1), $p2);
			if ($akhir != "") {
				$hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
			}
		}
		return $hasil;
	}
}
